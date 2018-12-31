<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User as UserModel;
use App\Models\UserInfoModels;
use App\Models\CourseModel;
use App\Models\TransactionModel;
use App\Models\ExamResultModel;
use App\SiteSetting;

use DB;

class DashbordController extends Controller
{
    private $CourseModel;
    private $UserModel;
    private $TransactionModel;
    private $SiteSetting;
    private $userId;
 
    public function __construct(
        UserModel $UserModel,
        CourseModel $CourseModel,
        TransactionModel $TransactionModel,
        SiteSetting $SiteSetting,
        ExamResultModel $ExamResultModel
    )
    {
      $this->SiteSetting      = $SiteSetting;
    	$this->CourseModel  	  = $CourseModel;
    	$this->UserModel 		    = $UserModel;
    	$this->TransactionModel = $TransactionModel;
      $this->ExamResultModel  = $ExamResultModel;
      // $this->$userId  = auth()->user()->id;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Dashboard';
        $this->ModuleView  = 'front.dashboard';
        $this->ModulePath  = 'dashboard';
    }

   	public function index()
   	{
      $this->userId  = auth()->user()->id;

      $this->ViewData['modulePath']      = $this->ModulePath;
      $this->ViewData['moduleTitle']     = $this->ModuleTitle;
      $this->ViewData['moduleAction']    = $this->ModuleTitle;
      $this->ViewData['page_title']      = $this->ModuleTitle;

      $this->ViewData['exams'] = $this->ExamResultModel
                                      ->select(DB::raw('course_id'))
                                      ->with('course')
                                      ->where('user_id', $this->userId)
                                      ->groupBy('course_id')
                                      ->get();

      return view($this->ModuleView, $this->ViewData);
   	}

    public function buildCourseWiseCharts(Request $request)
    {
      if (!empty($request->course_id)) 
      {
          $courseId = base64_decode(base64_decode($request->course_id));
          
          $this->JsonData['examResult'] = $this->ExamResultModel
                                                ->where('course_id', $courseId)
                                                ->first();

          // build pie chart data
        


          return response()->json($this->JsonData);
      }
    }
}
