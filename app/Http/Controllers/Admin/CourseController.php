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
    private $ViewData;
    private $JsonData;
    private $BaseModel;
    private $ModulePath;
    private $ModuleView;
    private $ModuleTitle;

    // use MultiModelTrait;

    public function __construct(

        ExamModel           $ExamModel,
        CourseModel         $CourseModel,
        TransactionModel    $TransactionModel,
        PrerequisiteModel   $PrerequisiteModel
    )
    {
        $this->ExamModel            = $ExamModel;
        $this->BaseModel            = $CourseModel;
        $this->TransactionModel     = $TransactionModel;
        $this->PrerequisiteModel    = $PrerequisiteModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Course';
        $this->ModuleView  = 'admin.course.';
        $this->ModulePath  = 'course';
    
        $this->ViewData['modulePath']  = $this->ModulePath;
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
                $prerequisites = $request->prerequisite;

                // adding prerequisite
                $inserted = [];
                if (!empty($prerequisites) && sizeof($prerequisites) > 0)
                {
                    // title validation
                    $isValid = [];
                    foreach ($prerequisites as $data) 
                    {
                        if (empty($isValid)) 
                        {
                            $isValid[] = $data['title'];
                        }
                        else
                        {
                            if (in_array($data['title'], $isValid)) 
                            {
                                DB::rollBack();
                                $this->JsonData['status']   = 'error';
                                $this->JsonData['msg']      = __('messages.ERR_PRERE_NAME_ERROR_MSG');
                                return response()->json($this->JsonData); 
                                exit;
                            }
                            else
                            {
                                $isValid[] = $data['title'];
                            }
                        }
                    }

                    // creating object
                    foreach ($prerequisites as $key => $row) 
                    {
                        $objPrerequisite = new $this->PrerequisiteModel;  

                        $objPrerequisite->video_file                = NULL;
                        $objPrerequisite->video_file_mime           = NULL;
                        $objPrerequisite->video_file_original_name  = NULL;
                        $objPrerequisite->pdf_file                  = NULL;
                        $objPrerequisite->pdf_file_original_name    = NULL;
                        $objPrerequisite->youtube_url               = NULL;
                        $objPrerequisite->video_url                 = NULL;
                        $objPrerequisite->other                     = NULL;

                        // type validation
                        switch ($row['type']) 
                        {
                            case 'file':
                               if (empty($row['video_file'])) 
                               {
                                    DB::rollBack();
                                    $this->JsonData['status']   = 'error';
                                    $this->JsonData['msg']      = __('messages.ERR_PRERE_VIDEO_ERROR_MSG');
                                    return response()->json($this->JsonData); 
                                    exit;
                               }
                               else if(!empty($row['video_file']))
                               {
                                    $video_file     = $row['video_file'];
                                    $originalName   = strtolower($video_file->getClientOriginalName());
                                    $extension      = strtolower($video_file->getClientOriginalExtension());
                                    $video_file     = Storage::disk('local')->put('prerequisite_video', $video_file, 'public');
                                    $objPrerequisite->video_file_original_name   = $originalName;
                                    $objPrerequisite->video_file_mime            = $extension;
                                    $objPrerequisite->video_file                 = $video_file;
                               }
                            break;

                            case 'pdf':
                                if (empty($row['pdf_file'])) 
                                {
                                    DB::rollBack();
                                    $this->JsonData['status']   = 'error';
                                    $this->JsonData['msg']      =  __('messages.ERR_PRERE_PDF_ERROR_MSG');
                                    return response()->json($this->JsonData);
                                    exit;
                                }
                                else if(!empty($row['pdf_file']))
                                {
                                    $pdf_file = $row['pdf_file'];
                                    $pdf_originalName   = strtolower($pdf_file->getClientOriginalName());
                                    $pdf_file     = Storage::disk('local')->put('prerequisite_pdf', $pdf_file, 'public');
                                    $objPrerequisite->pdf_file_original_name   = $pdf_originalName;
                                    $objPrerequisite->pdf_file                 = $pdf_file;
                                }
                            break;

                            case 'url':
                               if (empty($row['video_url'])) 
                                {
                                    DB::rollBack();
                                    $this->JsonData['status']   = 'error';
                                    $this->JsonData['msg']      =  __('messages.ERR_PRERE_VIDEO_URL_ERROR_MSG');
                                    return response()->json($this->JsonData);
                                    exit; 
                                }
                                else if(!empty($row['video_url']))
                                {
                                    $objPrerequisite->video_url  = $row['video_url'];
                                }
                            break;

                            case 'youtube':
                               if (empty($row['youtube_url'])) 
                                {
                                    DB::rollBack();
                                    $this->JsonData['status']   = 'error';
                                    $this->JsonData['msg']      = __('messages.ERR_PRERE_YOUTUBE_ERROR_MSG'); 
                                    return response()->json($this->JsonData);
                                    exit;
                                }
                                else if(!empty($row['youtube_url']))
                                {
                                    $objPrerequisite->youtube_url    = $row['youtube_url'];
                                }
                            break;

                            case 'other':
                                if (empty($row['other'])) 
                                {
                                    DB::rollBack();
                                    $this->JsonData['status']   = 'error';
                                    $this->JsonData['msg']      =  __('messages.ERR_PRERE_OTHER_ERROR_MSG'); 
                                    return response()->json($this->JsonData);
                                    exit;
                                }
                                else if(!empty($row['other']))
                                {
                                    $objPrerequisite->other = $row['other'];
                                }
                            break;

                            default:
                                DB::rollBack();
                                $this->JsonData['status']   = 'error';
                                $this->JsonData['msg']      = __('messages.ERR_PRERE_EMPTY_ERROR_MSG');
                                return response()->json($this->JsonData);
                                exit;
                            break;
                        }

                        $objPrerequisite->course_id  = $object->id;
                        $objPrerequisite->title      = $row['title'];
                        $objPrerequisite->status     = '1';

                        if ($objPrerequisite->save()) 
                        {
                            $inserted[] = 1;
                        }
                        else
                        {
                            
                            $inserted[] = 0;
                        }
                    }
                }

                if (!in_array(0, $inserted)) 
                {
                    DB::commit();
                    $this->JsonData['status']   = 'success';
                    $this->JsonData['msg']      = __('messages.ERR_COURSE_SUCCESS_MSG');
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
        $this->ViewData['prerequisites'] = $this->PrerequisiteModel->where('status', 1)->get(['title','id']);
        $this->ViewData['exams'] =  $this->ExamModel->where('status', 1)->get(['title','id']);
        $this->ViewData['object'] = $this->BaseModel->with(['prerequisites'])->find($id);

        // dd($this->ViewData['object']);

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
                // adding prerequisite
                $inserted = [];
                $prerequisites = $request->prerequisite;
                // dd($prerequisites);

                // deleting previous non seleceted prerequisites
                $encAllId = array_column($prerequisites, 'pd');
                if (!empty($encAllId) && sizeof($encAllId) > 0) 
                {
                    $allId = array_map(function ($data)
                        {
                            return base64_decode(base64_decode($data));
                        }, $encAllId);

                    $notSelected = $this->PrerequisiteModel->where('course_id', $object->id)
                                                            ->whereNotIn('id', $allId)->get();

                    if (!empty($notSelected) && sizeof($notSelected) > 0) 
                    {
                        foreach ($notSelected as $notKey => $notValue) 
                        {
                            if(is_file(storage_path().'/app/public/'.$notValue->video_file))
                            {
                                unlink(storage_path().'/app/public/'.$notValue->video_file);
                            }

                            if(is_file(storage_path().'/app/public/'.$notValue->pdf_file))
                            {
                                unlink(storage_path().'/app/public/'.$notValue->pdf_file);
                            }
                        }   
                    }

                    $this->PrerequisiteModel->where('course_id', $object->id)
                                            ->whereNotIn('id', $allId)->delete();
                }

                
                if (!empty($prerequisites) && sizeof($prerequisites) > 0)
                {
                    // title validation
                    $isValid = [];
                    foreach ($prerequisites as $data) 
                    {
                        if (empty($isValid)) 
                        {
                            $isValid[] = $data['title'];
                        }
                        else
                        {
                            if (in_array($data['title'], $isValid)) 
                            {
                                DB::rollBack();
                                $this->JsonData['status']   = 'error';
                                $this->JsonData['msg']      = __('messages.ERR_PRERE_NAME_ERROR_MSG'); 
                                return response()->json($this->JsonData); 
                                exit;
                            }
                            else
                            {
                                $isValid[] = $data['title'];
                            }
                        }
                    }

                    // creating object
                    foreach ($prerequisites as $key => $row) 
                    {
                        // getting object
                        $id = !empty($row['pd']) ? base64_decode(base64_decode($row['pd'])) : NULL ;

                        $objPrerequisite = $this->PrerequisiteModel->firstOrCreate(['id' => $id]);  

                        if (!empty($objPrerequisite) && $objPrerequisite != NULL) 
                        {

                            $objPrerequisite->youtube_url    = NULL;
                            $objPrerequisite->video_url      = NULL;
                            $objPrerequisite->other          = NULL;

                            // type validation
                            switch ($row['type']) 
                            {
                                case 'file':
                                   if (empty($row['video_file'])) 
                                   {
                                        if (!empty($row['old_video_file'])) 
                                        {
                                            break;
                                        }
                                        else
                                        {
                                            DB::rollBack();
                                            $this->JsonData['status']   = 'error';
                                            $this->JsonData['msg']      = __('messages.ERR_PRERE_VIDEO_ERROR_MSG'); 
                                            return response()->json($this->JsonData); 
                                            exit;
                                        }
                                   }
                                   else if(!empty($row['video_file']))
                                   {    
                                        // removing old file
                                        if (!empty($row['old_video_file'])) 
                                        {
                                            if(is_file(storage_path().'/app/public/'.$objPrerequisite->video_file))
                                            {
                                                unlink(storage_path().'/app/public/'.$objPrerequisite->video_file);
                                            }
                                        }

                                        $objPrerequisite->video_file        = NULL;
                                        $objPrerequisite->video_file_mime   = NULL;
                                        $objPrerequisite->video_file_original_name = NULL;
                                        $objPrerequisite->pdf_file       = NULL;
                                        $objPrerequisite->pdf_file_original_name = NULL;

                                        $video_file = $row['video_file'];
                                        $originalName   = strtolower($video_file->getClientOriginalName());
                                        $extension      = strtolower($video_file->getClientOriginalExtension());
                                        $video_file     = Storage::disk('local')->put('prerequisite_video', $video_file, 'public');
                                        $objPrerequisite->video_file_original_name   = $originalName;
                                        $objPrerequisite->video_file_mime            = $extension;
                                        $objPrerequisite->video_file                 = $video_file;
                                   }
                                break;

                                case 'pdf':
                                    if (empty($row['pdf_file'])) 
                                    {
                                        if (!empty($row['old_pdf_file'])) 
                                        {
                                            break;
                                        }
                                        else
                                        {
                                            DB::rollBack();
                                            $this->JsonData['status']   = 'error';
                                            $this->JsonData['msg']      = __('messages.ERR_PRERE_PDF_ERROR_MSG'); 
                                            return response()->json($this->JsonData);
                                            exit;
                                        }
                                    }
                                    else if(!empty($row['pdf_file']))
                                    {

                                        if (!empty($row['old_pdf_file'])) 
                                        {
                                            if(is_file(storage_path().'/app/public/'.$objPrerequisite->pdf_file))
                                            {
                                                unlink(storage_path().'/app/public/'.$objPrerequisite->pdf_file);
                                            }
                                        }

                                        $objPrerequisite->video_file        = NULL;
                                        $objPrerequisite->video_file_mime   = NULL;
                                        $objPrerequisite->video_file_original_name = NULL;
                                        $objPrerequisite->pdf_file       = NULL;
                                        $objPrerequisite->pdf_file_original_name = NULL;

                                        $pdf_file = $row['pdf_file'];
                                        $pdf_originalName   = strtolower($pdf_file->getClientOriginalName());
                                        $pdf_file     = Storage::disk('local')->put('prerequisite_pdf', $pdf_file, 'public');
                                        $objPrerequisite->pdf_file_original_name   = $pdf_originalName;
                                        $objPrerequisite->pdf_file                 = $pdf_file;
                                    }
                                break;

                                case 'url':
                                   if (empty($row['video_url'])) 
                                    {
                                        DB::rollBack();
                                        $this->JsonData['status']   = 'error';
                                        $this->JsonData['msg']      = __('messages.ERR_PRERE_VIDEO_URL_ERROR_MSG'); 
                                        return response()->json($this->JsonData);
                                        exit; 
                                    }
                                    else if(!empty($row['video_url']))
                                    {
                                        $objPrerequisite->video_file        = NULL;
                                        $objPrerequisite->video_file_mime   = NULL;
                                        $objPrerequisite->video_file_original_name = NULL;
                                        $objPrerequisite->pdf_file       = NULL;
                                        $objPrerequisite->pdf_file_original_name = NULL;

                                        $objPrerequisite->video_url      = $row['video_url'];
                                    }
                                break;

                                case 'youtube':
                                   if (empty($row['youtube_url'])) 
                                    {
                                        DB::rollBack();
                                        $this->JsonData['status']   = 'error';
                                        $this->JsonData['msg']      = __('messages.ERR_PRERE_YOUTUBE_ERROR_MSG'); 
                                        return response()->json($this->JsonData);
                                        exit;
                                    }
                                    else if(!empty($row['youtube_url']))
                                    {
                                        $objPrerequisite->video_file                = NULL;
                                        $objPrerequisite->video_file_mime           = NULL;
                                        $objPrerequisite->video_file_original_name  = NULL;
                                        $objPrerequisite->pdf_file                  = NULL;
                                        $objPrerequisite->pdf_file_original_name    = NULL;
                                        $objPrerequisite->youtube_url               = $row['youtube_url'];
                                    }
                                break;

                                case 'other':
                                    if (empty($row['other'])) 
                                    {
                                        DB::rollBack();
                                        $this->JsonData['status']   = 'error';
                                        $this->JsonData['msg']      = __('messages.ERR_PRERE_OTHER_ERROR_MSG'); 
                                        return response()->json($this->JsonData);
                                        exit;
                                    }
                                    else if(!empty($row['other']))
                                    {
                                        $objPrerequisite->video_file                = NULL;
                                        $objPrerequisite->video_file_mime           = NULL;
                                        $objPrerequisite->video_file_original_name  = NULL;
                                        $objPrerequisite->pdf_file                  = NULL;
                                        $objPrerequisite->pdf_file_original_name    = NULL;
                                        $objPrerequisite->other = $row['other'];
                                    }
                                break;

                                default:
                                    DB::rollBack();
                                    $this->JsonData['status']   = 'error';
                                    $this->JsonData['msg']      = __('messages.ERR_PRERE_EMPTY_ERROR_MSG');
                                    return response()->json($this->JsonData);
                                    exit;
                                break;
                            }

                            $objPrerequisite->course_id  = $object->id;
                            $objPrerequisite->title   = $row['title'];

                            if ($objPrerequisite->save()) 
                            {
                                $inserted[] = 1;
                            }
                            else
                            {
                                
                                $inserted[] = 0;
                            }

                        }
                        else
                        {
                            $inserted[] = 0;
                        }

                    }
                }

                if (!in_array(0, $inserted)) 
                {
                    DB::commit();
                    $this->JsonData['status']   = 'success';
                    $this->JsonData['msg']      =  __('messages.ERR_COURSE_UPDATE_SUCCESS_MSG');
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
            $this->JsonData['msg']    = __('messages.ERR_COURSE_DEL_DEP_ERROR_MSG');
            return response()->json($this->JsonData);
            exit;
        }

        if($this->BaseModel->where('id', $id)->delete())
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['msg']      = __('messages.ERR_COURSE_DELETE_SUCCESS_MSG');
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_CONCIL_DELETE_ERROR_MSG');
        }
        
        return response()->json($this->JsonData);
    }

    public function changeStatus(Request $request)
    {
        $this->JsonData['status']   = 'error';
        $this->JsonData['msg']      = __('messages.ERR_CONCIL_MEM_STS_ERROR_MSG');

        $id = base64_decode(base64_decode($request->id));

        $flag = $this->_checkDependency($id);
        if ($flag) 
        {
            $this->JsonData['status'] = 'error';
            $this->JsonData['msg']    = __('messages.ERR_COURSE_STS_DEP_ERROR_MSG');
            return response()->json($this->JsonData);
            exit;
        }
        if ($request->has('id') && $request->has('status') ) 
        {
            $id = base64_decode(base64_decode($request->id));
            $status = $request->status;

            if($this->BaseModel->where('id', $id)->update(['status' => $status]))
            {
                $this->JsonData['status']   = 'success';
                $this->JsonData['msg']      = __('messages.ERR_STATUS_ERROR_MSG');
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
                    3 => 'currency',
                    4 => 'discount',
                    5 => 'discount_by',
                    6 => 'calculated_amount',
                    7 => 'created_at',
                    8 => 'status',
                    9 => 'id'
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
                                $query->orwhere('currency', 'LIKE', '%'.$search.'%');   
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
                        
                        $data[$key]['currency']     = $row->currency;

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