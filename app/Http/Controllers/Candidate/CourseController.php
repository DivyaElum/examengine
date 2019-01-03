<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User as UserModel;
use App\Models\UserInfoModels;
use App\Models\CourseModel;
use App\Models\TransactionModel;
use App\Models\PrerequisiteModel;
use App\Models\CoursePreStatus;
use App\Models\BookExamSlotModel;

use Illuminate\Support\Facades\Hash;
use URL;
use Session;
use DB;

class CourseController extends Controller
{
   	private $CourseModel;
    private $UserModel;
    private $TransactionModel;
    private $PrerequisiteModel;
    private $CoursePreStatus;

    public function __construct(
        UserModel         $UserModel,
        CourseModel       $CourseModel,
        TransactionModel  $TransactionModel,
        PrerequisiteModel $PrerequisiteModel,
        CoursePreStatus   $CoursePreStatus,
        BookExamSlotModel   $BookExamSlotModel
    )
    {

    	$this->CourseModel  	   = $CourseModel;
    	$this->UserModel 		     = $UserModel;
    	$this->TransactionModel  = $TransactionModel;
      $this->PrerequisiteModel = $PrerequisiteModel;
      $this->CoursePreStatus   = $CoursePreStatus;
    	$this->BookExamSlotModel   = $BookExamSlotModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Course Details';
        $this->ModuleView  = 'front.course.details';
        $this->ModulePath  = 'course-details';

        $this->ViewData['modulePath']         = $this->ModulePath;
        $this->ViewData['moduleTitle']        = $this->ModuleTitle;
        $this->ViewData['moduleAction']       = $this->ModuleTitle;
        $this->ViewData['page_title']         = $this->ModuleTitle;
    }

    public function index($indEncId)
   	{
      $intId     = base64_decode(base64_decode($indEncId));

      // set book exam visibility status wise
      $bookExam = $this->BookExamSlotModel
                              ->where('user_id' , auth()->user()->id)
                              ->where('course_id', $intId)
                              ->first();

      $this->ViewData['bookingStatus'] = [];  
      if (!empty($bookExam) && $bookExam['pass'] == 1)
      {
          $this->ViewData['bookingStatus'] = 'completed';
      }
      if (!empty($bookExam) && $bookExam['pass'] == 0)
      {
          $this->ViewData['bookingStatus'] = 'rescheduled';
      }
      if (!empty($bookExam) && $bookExam['pass'] == NULL && $bookExam['pass'] != 0) 
      {
          $this->ViewData['bookingStatus'] = 'booked';
      }
      if ((empty($bookExam) && $bookExam != 'null')) 
      {
          $this->ViewData['bookingStatus'] = 'new';
      }

      $arrCourse = $this->CourseModel->where('id', $intId)->first();

      $enc_prerequisites = $this->CourseModel
                                ->where('id', $intId)
                                ->pluck('prerequisite_id')
                                ->first();

      $this->ViewData['arrCourse'] = $arrCourse;
      $this->ViewData['exam_id']   = $arrCourse->exam_id;

      if(!empty($enc_prerequisites) && ($enc_prerequisites != 'null'))
      {
        $arrPrerequisites = $this->PrerequisiteModel->whereIn('id', json_decode($enc_prerequisites))->get();
              
        $this->ViewData['arrPrerequisites']   = $arrPrerequisites;
        $this->ViewData['enc_prerequisites']  = $enc_prerequisites; 
      }
      
      return view($this->ModuleView, $this->ViewData);

   	}

    public function courseListing()
    {
      $this->ModuleTitle = 'Course Listing';
      $this->ModuleView  = 'front.course.course_listing';
      $this->ModulePath  = 'course-details';

      $user_id = auth()->user()->id;  
      $courses = $this->CourseModel->whereHas('transaction',function($query) use($user_id)
        {
           $query->where('user_id', $user_id);
        })
      ->get();
    
      $this->ViewData['modulePath']      = $this->ModulePath;
      $this->ViewData['moduleTitle']     = $this->ModuleTitle;
      $this->ViewData['moduleAction']    = $this->ModuleTitle;
      $this->ViewData['page_title']      = $this->ModuleTitle;
      $this->ViewData['arrUsersCourse']  = $courses;

        return view($this->ModuleView, $this->ViewData);
    }

    public function varify(Request $request, $token)
    {
        $object = $this->CourseModel->find($token);

        if ($object) 
        { 
          $examToken = Hash::make(uniqid($token));

          $this->JsonData['status'] = 'success';
          $this->JsonData['url']   = URL::to('/exam?token='.$examToken);

          $data = [];
          $data['token']  = $examToken;
          $data['object'] = $object;
          \Session::put('exam', $data);
        }
        else
        {
          $this->JsonData['status'] = 'error';
          $this->JsonData['object'] = 'User verification failed';
        }

        return response()->json($this->JsonData);
    }

    public function UpdatePreStatus(Request $request)
    {
      $strUserId          = base64_decode(base64_decode($request->user_id));
      $strCourseId        = base64_decode(base64_decode($request->course_id));
      $strPrerequisiteId  = base64_decode($request->prerequisite_id);

      $CoursePreStatus   = $this->CoursePreStatus->firstOrNew(array('user_id' => $strUserId,'course_id' => $strCourseId,'prerequisite_id' => $strPrerequisiteId));

      //dd($request->all());
      DB::beginTransaction();
      $CoursePreStatus->user_id         = base64_decode(base64_decode($request->user_id));
      $CoursePreStatus->course_id       = base64_decode(base64_decode($request->course_id));
      $CoursePreStatus->prerequisite_id = base64_decode($request->prerequisite_id);
      $CoursePreStatus->watch_time      = $request->watch_time;
      $CoursePreStatus->duration        = $request->duration;

        if ($CoursePreStatus->save()) 
        {
          DB::commit();
          $this->JsonData['status']   = 'success';
          $this->JsonData['msg']      = 'Added successfully';
        }
        return response()->json($this->JsonData);
    }
}


