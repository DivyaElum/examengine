<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// models
use App\Models\ExamModel;
use App\Models\ExamQuestionsModel;
use App\Models\QuestionCategoryModel;
use App\Models\RepositoryModel;
use App\Models\ExamSlotModel;

// request
use App\Http\Requests\Admin\ExamRequest;

// others
use Illuminate\Support\Facades\Input;
use Storage;
use DB;

class ExamController extends Controller
{
    private $BaseModel;
    private $ViewData;
    private $JsonData;
    private $ModuleTitle;
    private $ModuleView;
    private $ModulePath;

    // use MultiModelTrait;

    public function __construct(

        ExamModel $ExamModel,
    	ExamQuestionsModel $ExamQuestionsModel,
        QuestionCategoryModel $QuestionCategoryModel,
        RepositoryModel $RepositoryModel,
        ExamSlotModel $ExamSlotModel

    )
    {
        $this->BaseModel = $ExamModel;
        $this->ExamQuestionsModel = $ExamQuestionsModel;
        $this->ExamSlotModel = $ExamSlotModel;
        $this->QuestionCategoryModel = $QuestionCategoryModel;
        $this->RepositoryModel      = $RepositoryModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Exam';
        $this->ModuleView = 'admin.exam.';
        $this->ModulePath = 'exam';
    
        $this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
    }
    
    public function index()
    {
        $this->ViewData['moduleAction'] = 'Manage '.str_plural($this->ModuleTitle);

        return view($this->ModuleView.'index', $this->ViewData);
    }

    public function create()
    {
        $this->ViewData['moduleAction'] = 'Add '.$this->ModuleTitle;
        $this->ViewData['weekdays'] = $this->getWeekdays();
        $this->ViewData['categories'] = $this->QuestionCategoryModel->where('status', 1)->get();

        return view($this->ModuleView.'create', $this->ViewData);
    }

    public function store(ExamRequest $request)
    {
        // dd($request->all());

        $this->JsonData['status']   = 'error';
        $this->JsonData['msg']      = 'Failed to save exam, Something went wrong.';

        // validation 
        if (count($request->exam_questions) < $request->total_question) 
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = 'Exam question must be greater than total number of questions';
             return response()->json($this->JsonData);
             exit;
        }

        DB::beginTransaction();

        $object                 = new $this->BaseModel;
        $object->title          = $request->title;
        $object->duration       = $request->duration;
        $object->total_question = $request->total_question;
        $object->status         = $request->status;

        if ($object->save()) 
        {
            $exam_id = $object->id;
            
            // exam slots
            if (!empty($request->exam_days) && count($request->exam_days) > 0) 
            {
                $slots = [];
                $error_bag = [];
                foreach ($request->exam_days as $key => $exam_day) 
                {
                    // exam day validation 
                    if (empty($error_bag)) 
                    {
                        $error_bag[] = $exam_day;
                    }
                    else
                    {
                        if (in_array($exam_day, $error_bag)) 
                        {
                            DB::rollBack();
                            $this->JsonData['status']   = 'error';
                            $this->JsonData['msg']      = 'Exam days must not be same.';
                            return response()->json($this->JsonData);
                            exit;
                        }
                        else
                        {
                            $error_bag[] = $exam_day;
                        }
                    }

                    // saving exam days
                    $exam_slots = new $this->ExamSlotModel;
                    $exam_slots->exam_id = $exam_id;
                    $exam_slots->day     = $exam_day['day'];

                    // getting start and end time
                    $out = [];
                    foreach($exam_day['start_time'] as $key_time => $start_time)
                    {
                        // start time validation
                        if (empty($error_bag)) 
                        {
                            $error_bag[] = $start_time;
                        }
                        else
                        {
                            if (in_array($start_time, $error_bag)) 
                            {
                                DB::rollBack();
                                $this->JsonData['status']   = 'error';
                                $this->JsonData['msg']      = 'Exam start time must not be same.';
                                return response()->json($this->JsonData);
                                exit;
                            }
                            else
                            {
                                $error_bag[] = $start_time;
                            }
                        }


                        $tmp = [];
                        $minuts                 = $request->duration*60;
                        $enc_end_time           = strtotime("+".$minuts." minutes", strtotime($start_time));
                        $end_time               = date('H:i', $enc_end_time);
                        $tmp['start_time']      = $start_time;
                        $tmp['end_time']        = $end_time;
                        $out[] = $tmp;
                    }
                    
                    $exam_slots->time    = json_encode($out);

                    if($exam_slots->save())
                    {
                        $slots[] = 1;
                    }
                    else
                    {
                        $slots[] = 0;
                    }
                }
            }

            // exam questions
            if (!empty($request->exam_questions) && count($request->exam_questions) > 0) 
            {
                $questions = [];
                foreach ($request->exam_questions as $key => $question) 
                {
                    $category_id = $this->RepositoryModel->where('id', $question)->pluck('category_id')->first();
                    $exam_question                  = new $this->ExamQuestionsModel;
                    $exam_question->exam_id         = $exam_id;
                    $exam_question->category_id     = $category_id;
                    $exam_question->question_id     = $question;
                    
                    if($exam_question->save())
                    {
                        $questions[] = 1;
                    }
                    else
                    {
                        $questions[] = 0;
                    }
                }   
            }

            if (!in_array(0,$questions) && !in_array(0,$slots)) 
            {
                DB::commit();
                $this->JsonData['status']   = 'success';
                $this->JsonData['msg']      = 'Exam saved successfully';   
            }
            else
            {
                 DB::rollBack();
            }
        }
        else
        {
            DB::rollBack();
        }

        return response()->json($this->JsonData);

    }

    public function show($id)
    {
    }

    public function edit($enc_id)
    {
        $id = base64_decode(base64_decode($enc_id));
        
        $this->ViewData['moduleAction'] = 'Edit '.$this->ModuleTitle;
        $this->ViewData['weekdays']     = $this->getWeekdays();
        $this->ViewData['categories']   = $this->QuestionCategoryModel->where('status', 1)->get();
        $this->ViewData['object']       = $this->BaseModel->with(['slots','questions'])->find($id);

        /*---------------------------------------------------
        |   Questions 
        ----------------------*/
            $this->ViewData['object_quesitons'] = [];
            $this->ViewData['object_quesitons_categories'] = [];
            if (!empty($this->ViewData['object']->questions)) 
            {
                foreach ($this->ViewData['object']->questions as $key => $question) 
                {
                    $this->ViewData['object_quesitons'][] = $question->question_id;
                    $this->ViewData['object_quesitons_categories'][] = $question->category_id;
                }

                // only unique values
                if(!empty($this->ViewData['object_quesitons']))
                {
                    $this->ViewData['object_quesitons'] = array_unique($this->ViewData['object_quesitons']);
                }
            }

            // find category questions
            $this->ViewData['all_categories_questions'] = '';
            if (!empty($this->ViewData['object_quesitons_categories'])) 
            {
                $this->ViewData['all_categories_questions'] = $this->RepositoryModel->whereIn('category_id', $this->ViewData['object_quesitons_categories'])->get();
            }

        /*---------------------------------------------------
        |   Slots 
        ----------------------*/
            if (!empty($this->ViewData['object']->slots)) 
            {
                $out = [];
                foreach ($this->ViewData['object']->slots as $slot_key => $slot) 
                {
                    $tmp = [];
                    $tmp['day'] = $slot->day;
                    $tmp['time'] = json_decode($slot->time);
                    $out[] = $tmp;
                }
            }

            $this->ViewData['slots'] = $out;

        return view($this->ModuleView.'edit', $this->ViewData);
    }

    public function update(ExamRequest $request, $enc_id)
    {
        $this->JsonData['status']   = 'error';
        $this->JsonData['msg']      = 'Failed to save exam, Something went wrong.';

        // validation 
        if (count($request->exam_questions) < $request->total_question) 
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = 'Exam question must be greater than total number of questions';
            return response()->json($this->JsonData);
            exit;
        }

        DB::beginTransaction();

        $exam_id = base64_decode(base64_decode($enc_id));

        $object                 = $this->BaseModel->find($exam_id);
        $object->title          = $request->title;
        $object->duration       = $request->duration;
        $object->total_question = $request->total_question;
        $object->status         = $request->status;

        if ($object->save()) 
        {
            $exam_id = $object->id;

            // Delete previouse slots and questions
            $this->ExamSlotModel->where('exam_id', $exam_id)->delete();
            $this->ExamQuestionsModel->where('exam_id', $exam_id)->delete();

            // exam slots
            if (!empty($request->exam_days) && count($request->exam_days) > 0) 
            {
                $slots = [];
                $error_bag = [];
                foreach ($request->exam_days as $key => $exam_day) 
                {
                    // exam day validation 
                    if (empty($error_bag)) 
                    {
                        $error_bag[] = $exam_day;
                    }
                    else
                    {
                        if (in_array($exam_day, $error_bag)) 
                        {
                            DB::rollBack();
                            $this->JsonData['status']   = 'error';
                            $this->JsonData['msg']      = 'Exam days must not be same.';
                            return response()->json($this->JsonData);
                            exit;
                        }
                        else
                        {
                            $error_bag[] = $exam_day;
                        }
                    }

                    // saving exam days
                    $exam_slots = new $this->ExamSlotModel;
                    $exam_slots->exam_id = $exam_id;
                    $exam_slots->day     = $exam_day['day'];

                    // getting start and end time
                    $out = [];
                    foreach($exam_day['start_time'] as $key_time => $start_time)
                    {
                        // start time validation
                        if (empty($error_bag)) 
                        {
                            $error_bag[] = $start_time;
                        }
                        else
                        {
                            if (in_array($start_time, $error_bag)) 
                            {
                                DB::rollBack();
                                $this->JsonData['status']   = 'error';
                                $this->JsonData['msg']      = 'Exam start time must not be same.';
                                return response()->json($this->JsonData);
                                exit;
                            }
                            else
                            {
                                $error_bag[] = $start_time;
                            }
                        }


                        $tmp = [];
                        $minuts                 = $request->duration*60;
                        $enc_end_time           = strtotime("+".$minuts." minutes", strtotime($start_time));
                        $end_time               = date('H:i', $enc_end_time);
                        $tmp['start_time']      = $start_time;
                        $tmp['end_time']        = $end_time;
                        $out[] = $tmp;
                    }
                    
                    $exam_slots->time    = json_encode($out);

                    if($exam_slots->save())
                    {
                        $slots[] = 1;
                    }
                    else
                    {
                        $slots[] = 0;
                    }
                }   
            }

            // exam questions
            if (!empty($request->exam_questions) && count($request->exam_questions) > 0) 
            {
                $questions = [];
                foreach ($request->exam_questions as $key => $question) 
                {
                    $category_id = $this->RepositoryModel->where('id', $question)->pluck('category_id')->first();
                    $exam_question                  = new $this->ExamQuestionsModel;
                    $exam_question->exam_id         = $exam_id;
                    $exam_question->category_id     = $category_id;
                    $exam_question->question_id     = $question;
                    
                    if($exam_question->save())
                    {
                        $questions[] = 1;
                    }
                    else
                    {
                        $questions[] = 0;
                    }
                }   
            }

            if (!in_array(0,$questions) && !in_array(0,$slots)) 
            {
                DB::commit();
                $this->JsonData['status']   = 'success';
                $this->JsonData['msg']      = 'Exam saved successfully';   
            }
            else
            {
                 DB::rollBack();
            }
        }
        else
        {
            DB::rollBack();
        }

        return response()->json($this->JsonData);
    }

    public function destroy($enc_id)
    {
        $id = base64_decode(base64_decode($enc_id));

        if($this->BaseModel->where('id', $id)->delete())
        {
            $this->JsonData['status'] = 'success';
            $this->JsonData['msg'] = 'Record deleted successfully.';
        }
        else
        {
            $this->JsonData['status'] = 'error';
            $this->JsonData['msg'] = 'Failed to delete record, Something went wrong.';
        }
        
        return response()->json($this->JsonData);
    }

    public function changeStatus(Request $request)
    {
        $this->JsonData['status']   = 'error';
        $this->JsonData['msg']      = 'Failed to change status, Something went wrong.';

        if ($request->has('id') && $request->has('status') ) 
        {
            $id = base64_decode(base64_decode($request->id));
            $status = $request->status;

            if($this->BaseModel->where('id', $id)->update(['status' => $status]))
            {
                $this->JsonData['status'] = 'success';
                $this->JsonData['msg'] = 'Status changed successfully.';
            } 
        }
        
        return response()->json($this->JsonData);
    }

    /*-----------------------------------------------------
    |  Ajax Calls
    */
        public function getRecords(Request $request)
        {
            /*--------------------------------------
            |  Variables
            ------------------------------*/
                
                // skip and limit
                $start = $request->start;
                $length = $request->length;

                // serach value
                $search = $request->search['value']; 

                // order
                $column = $request->order[0]['column'];
                $dir = $request->order[0]['dir'];

                // filter columns
                $filter = array(
                    0 => 'id',
                    1 => 'title',
                    2 => 'duration',
                    3 => 'total_question',
                    4 => 'created_at',
                    5 => 'status',
                    6 => 'id'
                );

            /*--------------------------------------
            |  Model query and filter
            ------------------------------*/

                // start model query
                $modelQuery =  $this->BaseModel;

                // get total count 
                $countQuery = clone($modelQuery);            
                $totalData  = $countQuery->count();

                // filter options
                if (!empty($search)) 
                {
                
                    $modelQuery = $modelQuery->where(function ($query) use($search)
                            {
                                $query->orwhere('id', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('title', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('duration', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('total_question', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('created_at', 'LIKE', '%'.Date('Y-m-d', strtotime($search)).'%');
                                $query->orwhere('status', 'LIKE', '%'.$search.'%');   
                            });
                }

                // get total filtered
                $filteredQuery = clone($modelQuery);            
                $totalFiltered  = $filteredQuery->count();
                
                // offset and limit
                $object = $modelQuery->orderBy($filter[$column], $dir)
                                     ->skip($start)
                                     ->take($length)
                                     ->get();            

            /*--------------------------------------
            |  data binding
            ------------------------------*/
                $data = [];
                if (!empty($object) && sizeof($object) > 0) 
                {
                    foreach ($object as $key => $row) 
                    {
                        $data[$key]['id']             = ($key+$start+1);

                        $data[$key]['title']  = '<span title="'.$row->title.'">'.ucfirst(str_limit($row->title, '55', '...')).'</span>';
                        
                        $data[$key]['duration']       = $row->duration;

                        $data[$key]['total_question'] = $row->total_question;

                        $data[$key]['created_at']     = Date('d-m-Y', strtotime($row->created_at));
                        
                        if (!empty($row->status)) 
                        {
                            $data[$key]['status'] = '<a title="Click to Change Status" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="0"  class="btn btn-default btn-circle stsActiveClass" href="javascript:void(0)" ><i class="fa fa-check" aria-hidden="true"></i></a>&nbsp';
                        }
                        else
                        {
                            $data[$key]['status'] = '<a title="Click to Change Status" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="1"  class="btn btn-default btn-circle stsInactiveClass" href="javascript:void(0)"><i class="fa fa-times" aria-hidden="true"></i></a>&nbsp';
                        }
                        
                        $view   = '';
                        $edit   = '<a title="Edit" class="btn btn-default btn-circle" href="'.route('exam.edit', [ base64_encode(base64_encode($row->id))]).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';
                        $delete = '<a title="Delete" onclick="return rwDelete(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" class="btn btn-default btn-circle" href="javascript:void(0)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';

                        $data[$key]['actions'] = $view.$edit.$delete;
                    }
                }

                // wrapping up
                $this->JsonData['draw']             = intval($request->draw);
                $this->JsonData['recordsTotal']     = intval($totalData);
                $this->JsonData['recordsFiltered']  = intval($totalFiltered);
                $this->JsonData['data']             = $data;

            return response()->json($this->JsonData);
        }

        public function getDynamicQuesions(Request $request)
        {
            if (!empty($request->categories)) 
            {
                $categories = explode(',', $request->categories);
                $this->JsonData['questions'] = $this->RepositoryModel
                                                    ->whereIn('category_id', $categories)
                                                    ->get(['id', 'question_text']);
            }

            return response()->json($this->JsonData); 
        }

    /*-----------------------------------------------------
    |  Supportive Functions
    */
        public function getWeekdays()
        {
            $days = [ 
                      'Sunday',
                      'Monday',
                      'Tuesday',
                      'Wednesday',
                      'Thursday',
                      'Friday',
                      'Saturday'
                                 ];

            return $days;
        }
}       
