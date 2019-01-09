<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// models
use App\Models\CourseModel;
use App\Models\PrerequisiteModel;
use App\Models\ExamModel;
use App\Models\TransactionModel;

// request
use App\Http\Requests\Admin\CourseRequest;

// others
use Illuminate\Support\Facades\Input;
use Storage;
use Image;
use DB;


class CourseController extends Controller
{
    private $BaseModel;
    private $ViewData;
    private $JsonData;
    private $ModuleTitle;
    private $ModuleView;
    private $ModulePath;

    // use MultiModelTrait;

    public function __construct(

    	CourseModel $CourseModel,
        PrerequisiteModel $PrerequisiteModel,
        ExamModel $ExamModel,
        TransactionModel $TransactionModel
    )
    {
        $this->BaseModel = $CourseModel;
        $this->PrerequisiteModel = $PrerequisiteModel;
        $this->ExamModel = $ExamModel;
        $this->TransactionModel = $TransactionModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Course';
        $this->ModuleView = 'admin.course.';
        $this->ModulePath = 'course';
    
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
        $this->ViewData['prerequisites'] = $this->PrerequisiteModel->where('status', 1)->get(['title','id']);
        $this->ViewData['exams'] =  $this->ExamModel->where('status', 1)->get(['title','id']);
        return view($this->ModuleView.'create', $this->ViewData);
    }

    public function store(CourseRequest $request)
    {

        /*------------------------------
        |   Default error message
        -----------------------------------------*/
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_INTERNAL_SERVER_ERRO_MSG');

        /*------------------------------
        |   Began transaction
        -----------------------------------------*/

            DB::beginTransaction();

            $object = new $this->BaseModel;

            /*------------------------------
            |   Upload featured image
            -----------------------------------------*/
                if (Input::hasFile('featured_image')) 
                {
                    $original_name      = strtolower(Input::file('featured_image')->getClientOriginalName());
                    $featured_image     = Storage::disk('local')->put('course/featuredImage', Input::file('featured_image'), 'public');
                    
                    $featured_thumbnail_image = time().$original_name;
                    $str_thumb_designation_path = storage_path().'/app/public/course/featuredImageThumbnails' ;
                    $thumb_img = Image::make(Input::file('featured_image')->getRealPath())->resize(125, 125);
                    $thumb_img->save($str_thumb_designation_path.'/'.$featured_thumbnail_image,80);

                    $object->featured_image               = $featured_image;
                    $object->featured_image_thumbnail     = $featured_thumbnail_image;
                    $object->featured_image_original_name = $original_name;
                }


            
            $object->title              = $request->title;
            $object->description        = $request->description;
            $object->exam_id            = $request->exam;
            $object->amount             = $request->amount;
            $object->currency           = $request->currency;
            $object->discount           = $request->discount;
            $object->discount_by        = $request->discount_by;
            $object->calculated_amount  = $request->calculated_amount;            
            $object->start_date         = Date('Y-m-d',strtotime($request->start_date));
            $object->end_date           = Date('Y-m-d',strtotime($request->end_date));

            $object->status             = '1';

            if ($object->save()) 
            {
                 DB::commit();
                $this->JsonData['status']   = 'success';
                $this->JsonData['msg']      = 'Course saved successfully';
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
        $this->ViewData['prerequisites'] = $this->PrerequisiteModel->where('status', 1)->get(['title','id']);
        $this->ViewData['exams'] =  $this->ExamModel->where('status', 1)->get(['title','id']);
        $this->ViewData['object'] = $this->BaseModel->find($id);

        return view($this->ModuleView.'edit', $this->ViewData);
    }

    public function update(CourseRequest $request, $enc_id)
    {

        /*------------------------------
        |   Default error message
        -----------------------------------------*/
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_INTERNAL_SERVER_ERRO_MSG');

        /*------------------------------
        |   Began transaction
        -----------------------------------------*/

            DB::beginTransaction();

            $id = base64_decode(base64_decode($enc_id));
            $object = $this->BaseModel->find($id);

            /*------------------------------
            |   Upload featured image
            -----------------------------------------*/
                if (Input::hasFile('featured_image')) 
                {
                    $original_name      = strtolower(Input::file('featured_image')->getClientOriginalName());
                    $featured_image     = Storage::disk('local')->put('course/featuredImage', Input::file('featured_image'), 'public');
                    
                    $featured_thumbnail_image = time().$original_name;
                    $str_thumb_designation_path = storage_path().'/app/public/course/featuredImageThumbnails' ;
                    $thumb_img = Image::make(Input::file('featured_image')->getRealPath())->resize(125, 125);
                    $thumb_img->save($str_thumb_designation_path.'/'.$featured_thumbnail_image,80);

                    $object->featured_image               = $featured_image;
                    $object->featured_image_thumbnail     = $featured_thumbnail_image;
                    $object->featured_image_original_name = $original_name;
                }
                else
                if(empty($request->old_image))
                {
                    if(is_file(storage_path().'/app/public/course/featuredImageThumbnails/'.$object->featured_image_thumbnail))
                    {
                        unlink(storage_path().'/app/public/course/featuredImageThumbnails/'.$object->featured_image_thumbnail);
                    }

                    if(is_file(storage_path().'/app/public/'.$object->featured_image))
                    {
                        unlink(storage_path().'/app/public/'.$object->featured_image);
                    }
                    
                    $object->featured_image               = NULL;
                    $object->featured_image_thumbnail     = NULL;
                    $object->featured_image_original_name = NULL;
                }
            
            $object->title              = $request->title;
            $object->description        = $request->description;
            $object->exam_id            = $request->exam;
            $object->amount             = $request->amount;
            $object->currency           = $request->currency;
            $object->discount           = $request->discount;
            $object->discount_by        = $request->discount_by;
            $object->calculated_amount  = $request->calculated_amount;            
            $object->start_date         = Date('Y-m-d',strtotime($request->start_date));
            $object->end_date           = Date('Y-m-d',strtotime($request->end_date));

            $object->status             = '1';

            if ($object->save()) 
            {
                 DB::commit();
                $this->JsonData['status']   = 'success';
                $this->JsonData['msg']      = 'Course saved successfully';
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
            $this->JsonData['msg']    = 'Can\'t delete, This course has been purchased.';
            return response()->json($this->JsonData);
            exit;
        }

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

        $id = base64_decode(base64_decode($request->id));

        $flag = $this->_checkDependency($id);
        if ($flag) 
        {
            $this->JsonData['status'] = 'error';
            $this->JsonData['msg']    = 'Can\'t change status, This course has been purchased.';
            return response()->json($this->JsonData);
            exit;
        }
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
                    2 => 'amount',
                    3 => 'discount',
                    4 => 'discount_by',
                    5 => 'calculated_amount',
                    6 => 'created_at',
                    7 => 'status',
                    8 => 'id'
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
                                $query->orwhere('amount', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('discount', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('discount_by', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('calculated_amount', 'LIKE', '%'.$search.'%');
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
                        $data[$key]['id']           = ($key+$start+1);

                        $data[$key]['title']        = '<span title="'.$row->title.'">'.ucfirst(str_limit($row->title, '55', '...')).'</span>';
                        
                        $data[$key]['amount']       = number_format($row->amount);

                        $data[$key]['discount']     = $row->discount == 0 ? '0' : number_format($row->discount);

                         $data[$key]['discount_by'] = $row->discount != 0 ? $row->discount_by == '%' ? ' AED' : '%' : '--';

                        $data[$key]['total']        = number_format($row->calculated_amount,2);
                        
                        $data[$key]['created_at']   = Date('d-m-Y', strtotime($row->created_at));
                        
                        if (!empty($row->status)) 
                        {
                            $data[$key]['status'] = '<a title="Click to Change Status" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="0"  class="btn btn-default btn-circle stsActiveClass" href="javascript:void(0)" ><i class="fa fa-check" aria-hidden="true"></i></a>&nbsp';
                        }
                        else
                        {
                            $data[$key]['status'] = '<a title="Click to Change Status" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="1"  class="btn btn-default btn-circle stsInactiveClass" href="javascript:void(0)"><i class="fa fa-times" aria-hidden="true"></i></a>&nbsp';
                        }
                        
                        $view   = '';
                        $edit   = '<a title="Edit" class="btn btn-default btn-circle" href="'.route('course.edit', [ base64_encode(base64_encode($row->id))]).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';
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
    |  Supportive Functions
    */

        public function _checkDependency($id)
        {
            $count  = $this->TransactionModel->where('course_id', $id)->count();
                   
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