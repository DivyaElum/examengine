<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

// controllers
use App\Http\Controllers\Controller;

// models
use App\Models\QuestionTypesModel;
use App\Models\QuestionsModel;
use App\Models\QuestionTypeStructureModel;
use App\Models\QuestionOptionsAnswer;
use App\Models\QuestionCategoryModel;
use App\Models\ExamQuestionsModel;

// requests
use App\Http\Requests\Admin\QuestionsRequest;

// others
use Validator;
use DB;

// use App\Trait\MultiModelTrait;

class QuestionsController extends Controller
{
    private $BaseModel;
    private $ViewData;
    private $JsonData;
    private $ModuleTitle;
    private $ModuleView;
    private $ModulePath;

    // use MultiModelTrait;

    public function __construct(

        QuestionsModel              $QuestionsModel,
        QuestionTypesModel          $QuestionTypesModel,
        ExamQuestionsModel          $ExamQuestionsModel,
        QuestionCategoryModel       $QuestionCategoryModel,
        QuestionOptionsAnswer       $QuestionOptionsAnswer,
        QuestionTypeStructureModel  $QuestionTypeStructureModel
    )
    {
        $this->BaseModel                    = $QuestionsModel;
        $this->ExamQuestionsModel           = $ExamQuestionsModel;
        $this->QuestionTypesModel           = $QuestionTypesModel;
        $this->QuestionCategoryModel        = $QuestionCategoryModel;
        $this->QuestionOptionsAnswer        = $QuestionOptionsAnswer;
        $this->QuestionTypeStructureModel   = $QuestionTypeStructureModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle  = 'Question';
        $this->ModuleView   = 'admin.question.';
        $this->ModulePath   = 'question';
    }
    
    public function index()
    {
        $this->ViewData['modulePath']   = $this->ModulePath;
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Manage Questions';

        return view($this->ModuleView.'index', $this->ViewData);
    }

    public function create()
    {
        $this->ViewData['modulePath']   = $this->ModulePath;
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Add Question';
        $this->ViewData['types']        = $this->QuestionTypesModel->where('status', 1)->get(); 
        $this->ViewData['category']     = $this->QuestionCategoryModel->where('status', 1)->get(); 
        
        return view($this->ModuleView.'create', $this->ViewData);
    }

    public function store(QuestionsRequest $request)
    {
        // validations
        $validation = $this->_validateQuestionAnswers($request);
        if (!empty($validation['status']) && $validation['status'] == 'error') 
        {
            return response()->json($validation);
            exit;
        }

        // get type 
        $id = base64_decode(base64_decode($request->type));
        $questionTypeObject = $this->QuestionTypesModel->where('id', $id)->first();

        // get answer by type
        $correct_answer = self::_BuildTypeWiseAnswer($questionTypeObject->option, $request->correct);    

        $repository = new $this->BaseModel;

        $repository->correct_answer     = $correct_answer;
            
        $repository->question_type      = $questionTypeObject->slug;

        $repository->option_type        = $questionTypeObject->option;
        
        $repository->category_id        = $request->category;

        $repository->question_text      = $request->question_text;
        
        $repository->right_marks        = $request->right_marks;
        
        // options
        $repository->option1  = $request->option1 ?? NULL;
        $repository->option2  = $request->option2 ?? NULL;
        $repository->option3  = $request->option3 ?? NULL;
        $repository->option4  = $request->option4 ?? NULL;
        $repository->option5  = $request->option5 ?? NULL;
        $repository->option6  = $request->option6 ?? NULL;
        $repository->option7  = $request->option7 ?? NULL;
        $repository->option8  = $request->option8 ?? NULL;
        $repository->option9  = $request->option9 ?? NULL;
        $repository->option10 = $request->option10 ?? NULL;
        $repository->option11 = $request->option11 ?? NULL;
        $repository->option12 = $request->option12 ?? NULL;
        $repository->option13 = $request->option13 ?? NULL;
        $repository->option14 = $request->option14 ?? NULL;
        $repository->option15 = $request->option15 ?? NULL;
        $repository->option16 = $request->option16 ?? NULL;

        if ($repository->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['msg']      = __('messages.ERR_QESTION_SUCCESS_MSG');
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_INTERNAL_SERVER_ERRO_MSG');
        }   

        return response()->json($this->JsonData);
    }

    public function show($id)
    {
    }

    public function edit($enc_id)
    {
        $id = base64_decode(base64_decode($enc_id));
        $this->ViewData['modulePath']   = $this->ModulePath;
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Edit Question';
        $this->ViewData['object']       = $this->BaseModel->with(['questionFormat'])->find($id);
        $this->ViewData['types']        = $this->QuestionTypesModel->where('status', 1)->get();
        $this->ViewData['category']     = $this->QuestionCategoryModel->where('status', 1)->get();


        return view($this->ModuleView.'edit', $this->ViewData);
    }

    public function update(QuestionsRequest $request, $enc_id)
    {

        $validation = $this->_validateQuestionAnswers($request);
        if (!empty($validation['status']) && $validation['status'] == 'error') 
        {
            return response()->json($validation);
            exit;
        }

        // get type 
        $typeId = base64_decode(base64_decode($request->type));
        $questionTypeObject = $this->QuestionTypesModel->where('id', $typeId)->first();

        // get answer by type
        $correct_answer = self::_BuildTypeWiseAnswer($questionTypeObject->option, $request->correct);    

        $id = base64_decode(base64_decode($enc_id));
        $repository = $this->BaseModel->find($id);

        $repository->correct_answer     = $correct_answer;
            
        $repository->question_type      = $questionTypeObject->slug;

        $repository->option_type        = $questionTypeObject->option;

        $repository->category_id        = $request->category;
        
        $repository->question_text      = $request->question_text;
        
        $repository->right_marks        = $request->right_marks;
        
        // options
        $repository->option1  = $request->option1 ?? NULL;
        $repository->option2  = $request->option2 ?? NULL;
        $repository->option3  = $request->option3 ?? NULL;
        $repository->option4  = $request->option4 ?? NULL;
        $repository->option5  = $request->option5 ?? NULL;
        $repository->option6  = $request->option6 ?? NULL;
        $repository->option7  = $request->option7 ?? NULL;
        $repository->option8  = $request->option8 ?? NULL;
        $repository->option9  = $request->option9 ?? NULL;
        $repository->option10 = $request->option10 ?? NULL;
        $repository->option11 = $request->option11 ?? NULL;
        $repository->option12 = $request->option12 ?? NULL;
        $repository->option13 = $request->option13 ?? NULL;
        $repository->option14 = $request->option14 ?? NULL;
        $repository->option15 = $request->option15 ?? NULL;
        $repository->option16 = $request->option16 ?? NULL;

        if ($repository->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['msg']      = __('messages.ERR_QESTION_UPDATE_SUCCESS_MSG');
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_INTERNAL_SERVER_ERRO_MSG');
        }   
        
        return response()->json($this->JsonData);
    }

    public function destroy($enc_id)
    {
        $id = base64_decode(base64_decode($enc_id));

        $flag = $this->_checkDependency($id);
        if ($flag) 
        {
            $this->JsonData['status'] = 'error';
            $this->JsonData['msg']    = __('messages.ERR_QESTION_DEL_DEP_ERROR_MSG');
            return response()->json($this->JsonData);
            exit;
        }

        if($this->BaseModel->where('id', $id)->delete())
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['msg']      = __('messages.ERR_QESTION_DELETE_SUCCESS_MSG');
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_INTERNAL_SERVER_ERRO_MSG');
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
                    1 => 'question_text',
                    2 => 'question_type',
                    3 => 'category_id',
                    4 => 'right_marks',
                    5 => 'created_at',
                    6 => 'id'
                );

            /*--------------------------------------
            |  Model query and filter
            ------------------------------*/

                // DB::enableQueryLog();
                // start model query
                $modelQuery =  $this->BaseModel->with('category');

                // get total count 
                $countQuery = clone($modelQuery);            
                $totalData  = $countQuery->count();

                // filter options
                if (!empty($search)) 
                {
                
                    $modelQuery = $modelQuery->where(function ($query) use($search)
                            {
                                $query->orwhere('id', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('question_text', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('question_type', 'LIKE', '%'.str_replace(" ", '-',$search).'%');   
                                $query->orwhere('right_marks', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('created_at', 'LIKE', '%'.Date('Y-m-d', strtotime($search)).'%');   
                                $query->orWhereHas('category', function ($nested_query) use($search)
                                {
                                    $nested_query->where('category_name', 'LIKE', '%'.$search.'%');
                                });   
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
 
                // dd(DB::getQueryLog());
            /*--------------------------------------
            |  data binding
            ------------------------------*/
                $data = [];
                if (!empty($object) && sizeof($object) > 0) 
                {
                    foreach ($object as $key => $row) 
                    {
                        $data[$key]['id']             = ($key+$start+1);

                        $data[$key]['question_text']  = '<span title="'.$row->question_text.'">'.ucfirst(str_limit($row->question_text, '55', '...')).'</span>';
                        
                        $data[$key]['question_type']  = ucfirst(str_replace('-', " ", $row->question_type));

                        $data[$key]['category']       = $row->category->category_name ?? '--';
                        
                        $data[$key]['right_marks']    = $row->right_marks;
                        
                        $data[$key]['created_at']     = Date('d-m-Y', strtotime($row->created_at));
                        
                        $view   = '';
                        $edit   = '<a title="Edit" class="btn btn-default btn-circle" href="'.route('question.edit', [ base64_encode(base64_encode($row->id))]).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';
                        $delete = '<a title="Delete" onclick="return deleteQuestion(this)" data-qsnid="'.base64_encode(base64_encode($row->id)).'" class="btn btn-default btn-circle" href="javascript:void(0)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';

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

        public function getStructure($end_id)
        {
            $id = base64_decode(base64_decode($end_id));
            $structure = $this->QuestionTypeStructureModel->where('question_type_id', $id)->first();
            
            if (!empty($structure)) 
            {
                $this->JsonData = $structure->structure;
            }
            else
            {
                $this->JsonData = __('messages.ERR_NOT_FOUND_ERROR_MSG');
            }

            return response()->json($this->JsonData);
        }

        public function getOptionsAnswer($index)
        {
            $object = $this->QuestionOptionsAnswer->where('index', $index)->first();

            if (!empty($object))
            {
                $this->JsonData['status'] = 'success';
                $this->JsonData['value']  = $object->answer;
                $this->JsonData['name']   = $object->option;
            }
            else
            {
                $this->JsonData['status']   = 'error';
                $this->JsonData['msg']      = __('messages.ERR_QESTION_INDEX_ERROR_MSG');
            }
            
            return response()->json($this->JsonData);
        }

    /*-----------------------------------------------------
    |  Supportive Functions
    */

        public function _BuildTypeWiseAnswer($type, $answer)
        {
            $correct_answer = '';

            switch ($type) 
            {
                case 'radio':
                    $correct_answer = $answer;
                break;

                case 'checkbox':
                    $correct_answer = implode(',', $answer);
                break;
            }

            return $correct_answer;
        }

    /*-----------------------------------------------------
    |  sub function Calls
    */

        public function _checkDependency($id)
        {
            $count  = $this->ExamQuestionsModel->where('question_id', $id)->count();
                   
            if ($count > 0) 
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function _validateQuestionAnswers($request)
        {
            $formdata = $request->all();
            // dd($formdata);
            $answers = $this->QuestionOptionsAnswer->get();

            // find correct value dont have blank answers
            foreach ($answers as $key => $answer) 
            {
                if (is_array($formdata['correct'])) 
                {
                    if (in_array($answer->answer, $formdata['correct'])) 
                    {
                        $checkbox_option = $answer->option;
                        
                        if ($formdata[$checkbox_option] == NULL) 
                        {
                            $this->JsonData['status']   = 'error';
                            $this->JsonData['msg']      =  __('messages.ERR_QESTION_INP_EMPTY_ERROR_MSG');
                        }
                        else
                        {
                            // check revers order from option 
                            for ($i=($answer->id-1); $i > 0 ; $i--) 
                            { 
                                $reverse_options = $answers[$i]['option'];
                                if ($formdata[$reverse_options] == NULL) 
                                {
                                    $this->JsonData['status']   = 'error';
                                    $this->JsonData['msg']      = __('messages.ERR_QESTION_PRE_EMPTY_ERROR_MSG');
                                }
                            }                   
                        }
                    }
                }
                else
                {
                    if ($answer->answer == $formdata['correct']) 
                    {
                        $radio_option = $answer->option;
                        
                        if ($formdata[$radio_option] == NULL) 
                        {
                            $this->JsonData['status'] = 'error';
                            $this->JsonData['msg']    = __('messages.ERR_QESTION_INP_EMPTY_ERROR_MSG');
                        }
                        else
                        {
                            // check revers order from option 
                            for ($i=($answer->id-1); $i > 0 ; $i--) 
                            { 
                                $reverse_options = $answers[$i]['option'];
                                if ($formdata[$reverse_options] == NULL) 
                                {
                                    $this->JsonData['status'] = 'error';
                                    $this->JsonData['msg']    = __('messages.ERR_QESTION_PRE_EMPTY_ERROR_MSG');
                                }
                            }
                        }
                    }
                }
                
            }
            

            return $this->JsonData;   
        }
}
