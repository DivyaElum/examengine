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
        CoursePreStatus   $CoursePreStatus
    )
    {

    	$this->CourseModel  	   = $CourseModel;
    	$this->UserModel 		     = $UserModel;
    	$this->TransactionModel  = $TransactionModel;
      $this->PrerequisiteModel = $PrerequisiteModel;
    	$this->CoursePreStatus   = $CoursePreStatus;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Course Details';
        $this->ModuleView  = 'front.course.details';
        $this->ModulePath  = 'course-details';
    }

    public function index($indEncId)
   	{
   		$intId = base64_decode(base64_decode($indEncId));

   		$user_id = auth()->user()->id;
   		$arrUsers = $this->UserModel->with(['information'])->find($user_id);	//get login user data

      $arrCourse = $this->CourseModel->where('id', $intId)->first();

   		$enc_prerequisites = $this->CourseModel->where('id', $intId)->pluck('prerequisite_id')->first();
   		
   		$arrPrerequisites = $this->PrerequisiteModel->whereIn('id', json_decode($enc_prerequisites))->get();

   		$this->ViewData['modulePath']   		  = $this->ModulePath;
      $this->ViewData['moduleTitle']  		  = $this->ModuleTitle;
      $this->ViewData['moduleAction'] 		  = $this->ModuleTitle;
      $this->ViewData['page_title']   		  = $this->ModuleTitle;
      $this->ViewData['arrUserData']        = $arrUsers;
      $this->ViewData['arrCourse']          = $arrCourse;      
      $this->ViewData['arrPrerequisites']   = $arrPrerequisites;
      $this->ViewData['enc_prerequisites']  = $enc_prerequisites;
        
        return view($this->ModuleView, $this->ViewData);
   	}

    public function varify(Request $request, $token)
    {
        $object = $this->CourseModel->with(['exam' => function ($exam) 
                                    {
                                        $exam->with(['questions' => function ($questions) 
                                              {
                                                  $questions->with('repository');
                                              }]);
                                    }])
                                    ->find($token);

        if ($object) 
        {          
          $this->JsonData['status'] = 'success';
          $this->JsonData['object'] = $object;
          $this->JsonData['respd']  = rand(9999999999, time()).base64_encode(base64_encode($object->id)).rand(9999999999, time());
          $this->JsonData['url']   = URL::to('/exam/'.$this->JsonData['respd'].'/perform');
          \Session::put('exam', $this->JsonData);
        }
        else
        {
          $this->JsonData['status'] = 'error';
          $this->JsonData['object'] = 'Something went wrong, Please try again later';
        }

        return response()->json($this->JsonData);
    }

    public function UpdatePreStatus(Request $request)
    {
      $strUserId          = base64_decode(base64_decode($request->user_id)));
      $strCourseId        = base64_decode(base64_decode($request->course_id));
      $strPrerequisiteId  = base64_decode($request->prerequisite_id);

      $CoursePreStatus   = $this->CoursePreStatus->firstOrNew(array('user_id' => $strUserId,'course_id' => $strCourseId,'prerequisite_id' => $strPrerequisiteId)));

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
    }
}


