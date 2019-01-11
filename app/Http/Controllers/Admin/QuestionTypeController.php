<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// models
use App\Models\QuestionTypesModel;
use App\Models\QuestionTypeStructureModel;
use App\Models\OptionStructureModel;
use App\Models\QuestionsModel;

// requests
use App\Http\Requests\Admin\QuestionTypeRequest;

// others
use Validator;
use DB;


class QuestionTypeController extends Controller
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
        OptionStructureModel        $OptionStructureModel,
        QuestionTypeStructureModel  $QuestionTypeStructureModel
    )
    {
        $this->QuestionsModel               = $QuestionsModel;
        $this->BaseModel                    = $QuestionTypesModel;
        $this->OptionStructureModel         = $OptionStructureModel;
        $this->QuestionTypeStructureModel   = $QuestionTypeStructureModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Question Type';
        $this->ModuleView  = 'admin.questionType.';
        $this->ModulePath  = 'question-type';
    }

    public function index()
    {
        $this->ViewData['modulePath']   = $this->ModulePath;    
        $this->ViewData['moduleTitle']  = str_plural($this->ModuleTitle);
        $this->ViewData['moduleAction'] = 'Manage '.str_plural($this->ModuleTitle);

        return view($this->ModuleView.'index', $this->ViewData);
    }

    public function create()
    {
        $this->ViewData['modulePath']   = $this->ModulePath; 
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Add '.$this->ModuleTitle;

        return view($this->ModuleView.'create', $this->ViewData);
    }

    public function store(QuestionTypeRequest $request)
    {
        DB::beginTransaction();

        $this->JsonData['status']   = 'error';
        $this->JsonData['msg']      = __('messages.ERR_QESTION_SAVE_ERROR_MSG');

        $structure  = $this->OptionStructureModel->where('option', $request->option)->pluck('structure')->first();

        $question_type = new $this->BaseModel;
        $question_type->title   = $request->title;
        $question_type->option  = $request->option;
        $question_type->slug    = str_slug($request->title,'-');
        $question_type->status  = '1';

        if ($question_type->save()) 
        {
            $question_type_structure = new $this->QuestionTypeStructureModel;
            $question_type_structure->question_type_id = $question_type->id;
            // $question_type_structure->question_slug = str_slug($request->title,'-');
            $question_type_structure->structure = $structure;
            if($question_type_structure->save())
            {
                DB::commit();
                $this->JsonData['status']   = 'success';
                $this->JsonData['msg']      = __('messages.ERR_QESTION_TYP_SUCCESS_MSG');
            }
            else{
                DB::rollBack();
            }
        }
        else{
            DB::rollBack();
        }

        return response()->json($this->JsonData);
    }

    public function edit($enc_id)
    {
        $id = base64_decode(base64_decode($enc_id));
        
        $this->ViewData['modulePath']   = $this->ModulePath; 
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Add '.$this->ModuleTitle;
        $this->ViewData['object'] = $this->BaseModel->find($id);

        return view($this->ModuleView.'edit', $this->ViewData);
    }

    public function update(QuestionTypeRequest $request, $enc_id)
    {
        DB::beginTransaction();

        $this->JsonData['status']   = 'error';
        $this->JsonData['msg']      = __('messages.ERR_QESTION_STS_ERROR_MSG');

        $structure  = $this->OptionStructureModel->where('option', $request->option)->pluck('structure')->first();

        $id = base64_decode(base64_decode($enc_id));
        $question_type = $this->BaseModel->find($id);
        $question_type->title   = $request->title;
        $question_type->option  = $request->option;
        $question_type->slug    = str_slug($request->title,'-');
        
        if ($question_type->save()) 
        {
            $question_type_structure = $this->QuestionTypeStructureModel->where('question_type_id', $question_type->id)->first();
            $question_type_structure->structure = $structure;
            if($question_type_structure->save())
            {
                DB::commit();
                $this->JsonData['status']   = 'success';
                $this->JsonData['msg']      = __('messages.ERR_QESTION_TYP_SUCCESS_MSG');
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

        $flag = $this->_checkDependency($id);
        if ($flag) 
        {
            $this->JsonData['status'] = 'error';
            $this->JsonData['msg']    = __('messages.ERR_QESTION_TYP_DEL_DEP_ERROR_MSG');
            return response()->json($this->JsonData);
            exit;
        }

        if($this->BaseModel->where('id', $id)->delete())
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['msg']      =  __('messages.ERR_QESTION_TYP_DELETE_SUCCESS_MSG');
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_QESTION_DELETE_STS_ERROR_MSG');
        }
        
        return response()->json($this->JsonData);
    }

    public function changeStatus(Request $request)
    {
        $this->JsonData['status']   = 'error';
        $this->JsonData['msg']      = __('messages.ERR_QESTION_STS_ERROR_MSG');

        if ($request->has('id') && $request->has('status') ) 
        {
            $id = base64_decode(base64_decode($request->id));
            
            // change status dependent on exam moulde 
            $flag = $this->_checkDependency($id);
            if ($flag) 
            {
                $this->JsonData['status'] = 'error';
                $this->JsonData['msg']    = __('messages.ERR_QESTION_TYP_STS_DEP_ERROR_MSG');
                return response()->json($this->JsonData);
                exit;
            }

            // update status
            $status = $request->status;
            if($this->BaseModel->where('id', $id)->update(['status' => $status]))
            {
                $this->JsonData['status'] = 'success';
                $this->JsonData['msg']    = __('messages.ERR_STATUS_ERROR_MSG');
            } 
        }
        
        return response()->json($this->JsonData);
    }

    /*-----------------------------------------------------
    |  Ajax Calls
    */
        public function getTypes(Request $request)
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
                    2 => 'created_at',
                    3 => 'status',
                    4 => 'id'
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
                if (!empty($search) || $search == '0') 
                {
                
                    $modelQuery = $modelQuery->where(function ($query) use($search)
                    {
                        $query->orwhere('id', 'LIKE', '%'.$search.'%');   
                        $query->orwhere('title', 'LIKE', '%'.$search.'%');   
                        $query->orwhere('status', 'LIKE', '%'.$search.'%');   
                        $query->orwhere('created_at', 'LIKE', '%'.Date('Y-m-d', strtotime($search)).'%');   
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

                        $data[$key]['title']  = '<span title="'.$row->title.'">'.str_limit($row->title, '55', '...').'</span>';
                        
                        if (!empty($row->status)) 
                        {
                            $data[$key]['status'] = '<a title="Click to Change Status" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="0"  class="btn btn-default btn-circle  stsActiveClass " href="javascript:void(0)" ><i class="fa fa-check" aria-hidden="true"></i></a>&nbsp';
                        }
                        else
                        {
                            $data[$key]['status'] = '<a title="Click to Change Status" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="1"  class="btn btn-default btn-circle stsInactiveClass" href="javascript:void(0)"><i class="fa fa-times" aria-hidden="true"></i></a>&nbsp';
                        }

                        $data[$key]['created_at']     = Date('d-m-Y', strtotime($row->created_at));
                        
                        $view   = '';
                        $edit   = '<a title="Edit" class="btn btn-default btn-circle" href="'.route('question-type.edit', [ base64_encode(base64_encode($row->id))]).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';
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

    /*-----------------------------------------------------
    |  sub function Calls
    */

        public function _checkDependency($id)
        {
            $object = $this->BaseModel->find($id);
            $count  = $this->QuestionsModel->where('question_type', $object->slug)->count();
                   
            if ($count > 0) 
            {
                return true;
            }
            else
            {
                return false;
            }
        }
}
