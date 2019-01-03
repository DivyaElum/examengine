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
          
          $examResult = $this->ExamResultModel
                             ->where('course_id', $courseId)
                             ->first()
                             ->toArray();

        $this->JsonData['tooltip']['total_questions'] = $examResult['total_questions'];
        $this->JsonData['tooltip']['total_attemted'] = $examResult['total_attempted'];
        $this->JsonData['tooltip']['total_right'] = $examResult['total_right'];
        $this->JsonData['tooltip']['total_wrong'] = $examResult['total_wrong'];
        $this->JsonData['tooltip']['exam_status'] = ucfirst($examResult['exam_status']);

        $total_pass_percetage = 0;
        if (!empty($examResult['total_right'])) 
        {
          $total_pass_percetage = ($examResult['total_right']/$examResult['total_questions'])*100;
        }
        
        $total_fail_percetage = 0;
        if (!empty($examResult['total_wrong'])) 
        {
          $total_fail_percetage = ($examResult['total_wrong']/$examResult['total_questions'])*100;
        }

        $total_notattempted_percetage = 0;
        $total_notattempted = $examResult['total_questions'] - $examResult['total_attempted'];
        
        $total_notattempted_percetage = ($total_notattempted/$examResult['total_questions'])*100;


        $this->JsonData['graph'] = 'pie';
        $this->JsonData['dataset'][] = array('label' => 'Total Right', 'count' => $total_pass_percetage);
        $this->JsonData['dataset'][] = array('label' => 'Total Wrong', 'count' => $total_fail_percetage);
        $this->JsonData['dataset'][] = array('label' => 'Not Attempted', 'count' => $total_notattempted_percetage);

        return response()->json($this->JsonData);
      }
    } 

    public function buildAllInOneChart(Request $request)
    {
        $userId = auth()->user()->id;

        $examResults = $this->ExamResultModel
                           ->where('user_id', $userId)
                           ->whereIn('exam_status', ['Pass', 'Fail'])
                           ->get()
                           ->toArray();

        // total course attempted
        $totalCourses = count($examResults);

        if (!empty($totalCourses)) 
        {
            $totalPassed = count(array_filter($examResults, function ($data)
                              {
                                if ($data['exam_status'] == 'Pass') 
                                {
                                  return true;  
                                }
                              }));

            $totalFailed = count(array_filter($examResults, function ($data)
                              {
                                if ($data['exam_status'] == 'Fail') 
                                {
                                  return true;  
                                }
                              }));

          $totalPassPercetage = 0;
          if (!empty($totalPassed)) 
          {
            $totalPassPercetage = ($totalPassed/$totalCourses)*100;
          }
          
          $totalFailPercetage = 0;
          if (!empty($totalFailed)) 
          {
            $totalFailPercetage = ($totalFailed/$totalCourses)*100;
          }

          $this->JsonData['graph'] = 'pie';
          $this->JsonData['dataset'][] = array('label' => 'Total Passed', 'count' => $totalPassPercetage);
          $this->JsonData['dataset'][] = array('label' => 'Total Failed', 'count' => $totalFailPercetage);
        }
        else
        {
          $this->JsonData['graph'] = '';
          $this->JsonData['msg'] = 'No course found';
        }

        return response()->json($this->JsonData);
    }
}
