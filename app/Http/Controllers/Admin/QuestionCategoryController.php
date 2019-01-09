<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\QestionCategoryRequest;
use App\Http\Controllers\Controller;

use File;
use Session;
use App\Models\QuestionCategoryModel;
use App\Models\QuestionsModel;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Imports\QuestionCategoryImport;
use App\Exports\QuestionCategoryExport;

class QuestionCategoryController extends Controller
{
    private $QuestionCategory;

    // use MultiModelTrait;

    public function __construct(

        QuestionCategoryModel $QuestionCategoryModel,
        QuestionsModel $QuestionsModel
    )
    {        
        $this->QuestionCategoryModel  = $QuestionCategoryModel;
        $this->QuestionsModel  = $QuestionsModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Question Category';
        $this->ModuleView  = 'admin.questionCategory.';
        $this->ModulePath  = 'question-category';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Manage '.str_plural($this->ModuleTitle);

        return view($this->ModuleView.'index', $this->ViewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Manage '.str_plural($this->ModuleTitle);

        return view($this->ModuleView.'create', $this->ViewData);
    }

    public function store(QestionCategoryRequest $request)
    {
        $QuestionCategoryModel = new $this->QuestionCategoryModel;

        $QuestionCategoryModel->category_name = $request->category;
        $QuestionCategoryModel->status        = '1';
        
        if ($QuestionCategoryModel->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = 'admin/question-category';
            $this->JsonData['msg']      = __('messages.ERR_QESTION_CAT_SUCCESS_MSG');
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_INTERNAL_SERVER_ERRO_MSG');
        } 

        return response()->json($this->JsonData);
    }

    public function changeStatus(Request $request)
    {
        $this->JsonData['status']   = 'error';
        $this->JsonData['msg']      = __('messages.ERR_INTERNAL_SERVER_ERRO_MSG');

        if ($request->has('id') && $request->has('status') ) 
        {
            $id = base64_decode(base64_decode($request->id));

            $flag = $this->_checkDependency($id);
            if ($flag) 
            {
                $this->JsonData['status'] = 'error';
                $this->JsonData['msg']    = __('messages.ERR_QESTION_CAT_STS_DEP_ERROR_MSG');
                return response()->json($this->JsonData);
                exit;
            }

            $status = $request->status;
            if($this->QuestionCategoryModel->where('id', $id)->update(['status' => $status]))
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
        public function getQuestionCategory(Request $request)
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
                    1 => 'category_name',
                    2 => 'created_at',
                    3 => 'status',
                    4 => 'id'
                );

            /*--------------------------------------
            |  Model query and filter
            ------------------------------*/

                // start model query
                $modelQuery = $this->QuestionCategoryModel;

                // get total count 
                $countQuery = clone($modelQuery);            
                $totalData  = $countQuery->count();

                // filter options
                if (!empty($search)) 
                {
                
                    $modelQuery = $modelQuery->where(function ($query) use($search)
                        {
                            $query->orwhere('id', 'LIKE', '%'.$search.'%');   
                            $query->orwhere('category_name', 'LIKE', '%'.$search.'%');   
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
                        $data[$key]['id']         = ($key+$start+1);
                        $data[$key]['category']   = '<span title="'.$row->category_name.'">'.str_limit($row->category_name, '55', '...').'</span>';

                        if (!empty($row->status)) 
                        {
                            $data[$key]['status'] = '<a title="Click to Change Status" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="0"  class="btn btn-default btn-circle stsActiveClass" href="javascript:void(0)" ><i class="fa fa-check" aria-hidden="true"></i></a>&nbsp';
                        }
                        else
                        {
                            $data[$key]['status'] = '<a title="Click to Change Status" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="1"  class="btn btn-default btn-circle  stsInactiveClass" href="javascript:void(0)"><i class="fa fa-times" aria-hidden="true"></i></a>&nbsp';
                        }

                        $data[$key]['created_at']   = Date('d-m-Y', strtotime($row->created_at));
                        
                        $view   = '';
                        $edit   = '<a title="Edit" class="btn btn-default btn-circle" href="'.route('question-category.edit', [ base64_encode(base64_encode($row->id))]).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';
                        $delete = '<a title="Delete" onclick="return deleteQuestionCategory(this)" data-qsnid="'.base64_encode(base64_encode($row->id)).'" class="btn btn-default btn-circle" href="javascript:void(0)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
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

    public function edit($id)
    {
        $QuestionCategoryModel = new $this->QuestionCategoryModel;

        $intId = base64_decode(base64_decode($id));
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Edit '. $this->ModuleTitle;
        $this->ViewData['modulePath']   = $this->ModulePath;
        $this->ViewData['object']       = $this->QuestionCategoryModel->find($intId);

        return view($this->ModuleView.'edit', $this->ViewData);
    }

    public function update(QestionCategoryRequest $request, $id)
    {
        $QuestionCategoryModel = new $this->QuestionCategoryModel;

        $intId = base64_decode(base64_decode($id));
        
        $QuestionCategoryModel = $this->QuestionCategoryModel->find($intId);

        $QuestionCategoryModel->category_name = $request->category;
        
        if ($QuestionCategoryModel->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = '/admin/question-category/';
            $this->JsonData['msg']      = __('messages.ERR_QESTION_CAT_UPDATE_SUCCESS_MSG');
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_INTERNAL_SERVER_ERRO_MSG');
        } 
        return response()->json($this->JsonData);
    }

    public function destroy($id)
    {
        $intId = base64_decode(base64_decode($id));


        $flag = $this->_checkDependency($intId);
        if ($flag) 
        {
            $this->JsonData['status'] = 'error';
            $this->JsonData['msg']    = __('messages.ERR_QESTION_CAT_DEL_DEP_ERROR_MSG');
            return response()->json($this->JsonData);
            exit;
        }


        if($this->QuestionCategoryModel->where('id', $intId)->delete())
        {
            $this->JsonData['status'] = 'success';
            $this->JsonData['msg']    =  __('messages.ERR_QESTION_CAT_DELETE_SUCCESS_MSG');
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_INTERNAL_SERVER_ERRO_MSG');
        }
        
        return response()->json($this->JsonData);
    }

    public function exportFile()
    {     
        return Excel::download(new QuestionCategoryExport, 'Question-category.xlsx');
    }      

    public function excelImport(Request $request)
    {
        //validate the xls file
        $this->validate($request, array(
           'import_file'      => 'required'
        ));

        if($request->hasFile('import_file'))
        {
            $extension = File::extension($request->import_file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv")
            {
                $path = $request->import_file->getRealPath();
                $data = Excel::load($path, function($reader){
                })->get();
                if(!empty($data) && $data->count())
                {
                    $insert = [];
                    foreach ($data as $key => $value)
                    {
                        if(!empty($value->category_name))
                        {
                            if(!in_array($value->category_name , $insert))
                            {
                                $tmp = [];
                                $tmp  = $this->QuestionCategoryModel->firstOrCreate(['category_name' => $value->category_name]);

                                if (!empty($tmp)) 
                                {
                                    $insert[] = 1;
                                }
                                else
                                {
                                    $insert[] = 0;
                                }
                            }
                        }
                    }

                    if(!in_array(0, $insert))
                    {
                       Session::flash('success', 'Your Data has successfully imported');
                    }
                    else
                    {                        
                       Session::flash('error', 'Error inserting the data..');
                    }
                }
            }
            else
            {
                Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!');
            }    
        }

        return back();
    }

    /*-----------------------------------------------------
    |  sub function Calls
    */

    public function _checkDependency($id)
    {
        $count  = $this->QuestionsModel->where('category_id', $id)->count();
               
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
