<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\QestionCategoryRequest;
use App\Http\Controllers\Controller;

use App\Models\QuestionCategoryModel;
use Validator;

class QuestionCategoryController extends Controller
{
    private $QuestionCategory;

    // use MultiModelTrait;

    public function __construct(

        QuestionCategoryModel $QuestionCategoryModel
    )
    {
        $this->QuestionCategoryModel  = $QuestionCategoryModel;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QestionCategoryRequest $request)
    {
        $QuestionCategoryModel = new $this->QuestionCategoryModel;

        $QuestionCategoryModel->category_name = $request->category;
        $QuestionCategoryModel->status        = $request->status;
        
        if ($QuestionCategoryModel->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = 'admin/question-category';
            $this->JsonData['msg']      = 'Question Category saved successfully.';
        }
        else
        {
            $this->JsonData['status']   ='error';
            $this->JsonData['msg']      ='Failed to save Question Category, Something went wrong.';
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

            if($this->QuestionCategoryModel->where('id', $id)->update(['status' => $status]))
            {
                $this->JsonData['status'] = 'success';
                $this->JsonData['msg']    = 'Status changed successfully.';
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
                    1 => 'category',
                    2 => 'status',
                    4 => 'created_at',
                    5 => 'id'
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
                            $query->orwhere('category', 'LIKE', '%'.$search.'%');   
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
                            $data[$key]['status'] = '<a title="Click to Change Status" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="0"  class="btn btn-default btn-circle stsInactiveClass" href="javascript:void(0)" ><i class="fa fa-check" aria-hidden="true"></i></a>&nbsp';
                        }
                        else
                        {
                            $data[$key]['status'] = '<a title="Click to Change Status" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="1"  class="btn btn-default btn-circle stsActiveClass" href="javascript:void(0)"><i class="fa fa-times" aria-hidden="true"></i></a>&nbsp';
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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QestionCategoryRequest $request, $id)
    {
        $QuestionCategoryModel = new $this->QuestionCategoryModel;

        $intId              = base64_decode(base64_decode($id));
        
        $QuestionCategoryModel = $this->QuestionCategoryModel->find($intId);

        $QuestionCategoryModel->category_name = $request->category;
        $QuestionCategoryModel->status        = $request->status;
        
        if ($QuestionCategoryModel->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = '/admin/question-category/';
            $this->JsonData['msg']      = 'Question Category saved successfully.';
        }
        else
        {
            $this->JsonData['status']   ='error';
            $this->JsonData['msg']      ='Failed to save Question Category, Something went wrong.';
        } 
        return response()->json($this->JsonData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $intId = base64_decode(base64_decode($id));

        if($this->QuestionCategoryModel->where('id', $intId)->delete())
        {
            $this->JsonData['status'] = 'success';
            $this->JsonData['msg'] = 'Council member deleted successfully.';
        }
        else
        {
            $this->JsonData['status'] = 'error';
            $this->JsonData['msg'] = 'Failed to delete Council member, Something went wrong.';
        }
        
        return response()->json($this->JsonData);
    }
}
