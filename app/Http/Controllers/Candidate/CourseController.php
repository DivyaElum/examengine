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
use App\Models\ExamResultModel;

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
        BookExamSlotModel   $BookExamSlotModel,
        ExamResultModel   $ExamResultModel
    )
    {

    	$this->CourseModel  	   = $CourseModel;
    	$this->UserModel 		     = $UserModel;
    	$this->TransactionModel  = $TransactionModel;
      $this->PrerequisiteModel = $PrerequisiteModel;
      $this->CoursePreStatus   = $CoursePreStatus;
      $this->BookExamSlotModel   = $BookExamSlotModel;
    	$this->ExamResultModel   = $ExamResultModel;

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
      $intId   = base64_decode(base64_decode($indEncId));
      $user_id =  auth()->user()->id;


      // set book exam visibility status wise
      $bookExam = $this->BookExamSlotModel
                              ->where('user_id' , $user_id)
                              ->where('course_id', $intId)
                              ->first();



      $this->ViewData['bookingStatus'] = [];  

      if (!empty($bookExam)) 
      { 
          $exam_id = $bookExam->exam_id;
          $course_id = $intId;

          $ExamResultCompareArray = [];
          $ExamResultCompareArray['user_id']   = $user_id;
          $ExamResultCompareArray['course_id'] = $course_id;
          $ExamResultCompareArray['exam_id']   = $exam_id;

          if ($bookExam['pass'] === NULL) 
          {
              $this->ViewData['bookingStatus'] = 'booked';
          }

          if ($bookExam['pass'] === 0) 
          {
              $this->ViewData['bookingStatus'] = 'rescheduled';
          }

          if ($bookExam['pass'] === 1) 
          {
              $this->ViewData['bookingStatus'] = 'completed';
          }
      }
      else
      {
          $this->ViewData['bookingStatus'] = 'new';
      }

      // check exam status time check exact time:
      if ($this->ViewData['bookingStatus'] == 'booked') 
      {
          // get times
          $slotTime = explode('/', $bookExam->slot_time);  
          $startTime = $slotTime[0];
          $endTime = $slotTime[1];

          // get date
          $date = $bookExam->slot_date;

          // mearge date and time 
          $startTimeStamp = Date('Y-m-d H:i:s', strtotime("$date $startTime"));
          $endTimeStamp = Date('Y-m-d H:i:s', strtotime("$date $endTime"));
          $currentDate = Date('Y-m-d H:i:s');
          
          // dd($currentDate, $startTimeStamp);

          if(strtotime($currentDate) >= strtotime($startTimeStamp))
          {
             $this->ViewData['bookingStatus'] = 'hasExamAccess';
          }

          $extraTime = Date('Y-m-d H:i:s', strtotime("+15 minutes", strtotime($startTimeStamp)));
          if(strtotime($currentDate) > strtotime($extraTime))
          { 
              $ExamResultModel = $this->ExamResultModel->firstOrNew($ExamResultCompareArray);
              $ExamResultModel->user_id     = $user_id;
              $ExamResultModel->course_id   = $course_id;
              $ExamResultModel->exam_id     = $exam_id;
              $ExamResultModel->exam_status   = 'Delayed';
              $ExamResultModel->save();

              $BookExamSlotModel = $this->BookExamSlotModel->where($ExamResultCompareArray)->first();
              $BookExamSlotModel->pass = 0;
              $BookExamSlotModel->save();

            $this->ViewData['bookingStatus'] = 'rescheduled';
          }
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


