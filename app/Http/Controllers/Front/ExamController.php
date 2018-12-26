<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExamModel;
use App\Models\ExamQuestionsModel;
use App\Models\QuestionOptionsAnswer;

use Session;
use App\Models\CourseModel;
use App\Models\Event;
use App\Models\ExamSlotModel;
use Calendar;
use DB;

class ExamController extends Controller
{
 		
 	public function __construct(
 		ExamModel $ExamModel,
 		ExamQuestionsModel $ExamQuestionsModel,
 		QuestionOptionsAnswer $QuestionOptionsAnswer
 	)
 	{
 		$this->BaseModel = $ExamModel;
 		$this->ExamQuestionsModel = $ExamQuestionsModel;
 		$this->QuestionOptionsAnswer = $QuestionOptionsAnswer;

 		$this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Certification Listing';
        $this->ModuleView  = 'front.exam.';
        $this->ModulePath  = 'CourseModel';
    }	

	public function index(Request $request)
	{
		$token = $request->get('token');
		$exam  = Session::get('exam');
		
		if ($exam['token'] == $token) 
		{
			$course = $exam['object'];
			$this->ViewData['course'] = $course;
			$this->ViewData['exam']   =  $this->BaseModel->find($course->exam_id);
			$this->ViewData['exam_questions'] = $this->ExamQuestionsModel
													 ->with('repository')
													 ->where('exam_id',$course->exam_id)
													 ->orderBy(DB::raw('RAND()'))
													 ->limit($this->ViewData['exam']->total_question)
													 ->get();
			return view('exam', $this->ViewData);			
		}
		else
		{
			abort(404);
		}
	}

	public function examBook()
	{
		$events = [];
        $data = ExamSlotModel::with(['exam'])->get();
        
        $intI = '0';

        foreach ($data as $key => $value) 
        {

        	$strData = json_decode($value->time);
        	$days = self::getAllDaysInAMonth(date('Y'), date('m'), $value->day);

			foreach ($days as $day) 
			{
        		$start_time =  $day->format('Y-m-d').' '.$strData['0']->start_time;
        		$end_time   =  $day->format('Y-m-d').' '.$strData['0']->end_time;
				

				if (Date('Y-m-d') < $day->format('Y-m-d')) 
				{
					//$strExamTitle = $value->exam->title;
					$strExamTitle = 'Examp';
					$events[] = Calendar::event(
		                $strExamTitle,
		                true,
		                new \DateTime($start_time),
		                new \DateTime($end_time),
		                null,
		                [
		                    'color' => '#f05050',
		                    'url' 	=> 'pass here url and any route',
		                ]
		            );
				}
			}
        }
        $calendar = Calendar::addEvents($events);
       
		$this->ViewData['page_title']    = $this->ModuleTitle;
    	$this->ViewData['moduleTitle']   = $this->ModuleTitle;
        $this->ViewData['moduleAction']  = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']    = $this->ModulePath;
        $this->ViewData['calendar']      = $calendar;
        $this->ViewData['calendarData']  = $data;

        return view($this->ModuleView.'index', $this->ViewData);
	}


	public function getAllDaysInAMonth($year, $month, $day = 'Monday', $daysError = 3) 
	{
	    $dateString = 'first '.$day.' of '.$year.'-'.$month;

	    if (!strtotime($dateString)) 
	    {
	        throw new \Exception('"'.$dateString.'" is not a valid strtotime');
	    }

	    $startDay = new \DateTime($dateString);

	    if ($startDay->format('j') > $daysError) {
	        $startDay->modify('- 7 days');
	    }

	    $days = array();

	    while ($startDay->format('Y-m') <= $year.'-'.str_pad($month, 2, 0, STR_PAD_LEFT)) {
	        $days[] = clone($startDay);
	        $startDay->modify('+ 7 days');
	    }

	    return $days;
	}

	public function submit(Request $request, $user_id, $course_id, $exam_id)
	{

		$optionsAnswers = $this->QuestionOptionsAnswer->get();

		if (!empty($user_id) && !empty($course_id) && !empty($exam_id)) 
		{
			if (!empty($request->correct) && sizeof($request->correct) > 0) 
			{
				$statusBag = []; 

				// check answers for radio
				if (!empty($request->correct['radio']) && sizeof($request->correct['radio']) > 0)
				{
					foreach ($request->correct['radio'] as $radioKey => $radio) 
					{
						$examQuestionsRadio = $this->ExamQuestionsModel
								 			  ->with('repository')
								 			  ->find($radioKey);

						if ($examQuestionsRadio) 
						{
							$examQuestionsRadio = $examQuestionsRadio->toArray();
					
							// find correct answers
							$correctOptionRadio = '';
							foreach ($optionsAnswers as $optionAnswerKey => $optionAnswer) 
							{
								if ($examQuestionsRadio['repository']['correct_answer'] == $optionAnswer->answer) 
								{
									$correctOptionRadio = $optionAnswer->option;
								}
							}

							// varify is correct
							if ($examQuestionsRadio['repository'][$correctOptionRadio] == $radio) 
							{
								$statusBag[] = array('exam_id' => $radioKey, 'status' => 1);
							}
							else
							{
								$statusBag[] = array('exam_id' => $radioKey, 'status' => 0);
							
							}
						}
					}
				}

				// check answers for checkbox
				if (!empty($request->correct['checkbox']) && sizeof($request->correct['checkbox']) > 0) 
				{
					foreach ($request->correct['checkbox'] as $checkBoxKey => $checkbox) 
					{

						$examQuestionsCheckbox = $this->ExamQuestionsModel
								 			  ->with('repository')
								 			  ->find($checkBoxKey);

						if ($examQuestionsCheckbox) 
						{
							$examQuestionsCheckbox = $examQuestionsCheckbox->toArray();
					
							// find correct answers
							$correctOptionsCheckbox = [];
							foreach ($optionsAnswers as $optionAnswerKey => $optionAnswer) 
							{
								$questionOptionsCheckbox = explode(',', $examQuestionsCheckbox['repository']['correct_answer']);
								if (in_array($optionAnswer->answer, $questionOptionsCheckbox)) 
								{
									$correctOptionsCheckbox[] = $optionAnswer->option;
								}
							}

							// create correct answers array
							$questionCorrectOptionsCheckbox = [];
							foreach ($correctOptionsCheckbox as $correctOptionCheckboxKey => $correctOptionCheckbox) 
							{
								$questionCorrectOptionsCheckbox[] = $examQuestionsCheckbox['repository'][$correctOptionCheckbox];
							}

							//compare correct answers array
							$result = array_diff($checkbox,  $questionCorrectOptionsCheckbox);
							if (!empty($result) && sizeof($result) > 0) 
							{
								$statusBag[] = array('exam_id' => $checkBoxKey, 'status' => 1);
							}
							else
							{
								$statusBag[] = array('exam_id' => $checkBoxKey, 'status' => 0);
							}
						}
					}	
				}

				$resultBag = [];
				$resultBag['total_questions'] =  $this->BaseModel->where('id', $exam_id)
															     ->pluck('total_question')
															     ->first();

				$resultBag['total_attemped']  = count($statusBag);

				$resultBag['total_wrong']  = count(
													array_filter($statusBag, function($data)
													{
														if (empty($data['status'])) 
														{
															return true;
														}
													})
												);

				$resultBag['total_right']  = count(
													array_filter($statusBag, function($data)
													{
														if (!empty($data['status'])) 
														{
															return true;
														}
													})
												);

				$resultBag['percentage'] = (((int)$resultBag['total_right'])/((int)$resultBag['total_questions']))*100;

				$resultBag['result_status'] =  $resultBag['percentage'] >= 75 ? 'pass' : 'fail';

				return view('front.exam.result', ['resultBag' => $resultBag]);
 
			}	
		}
	}

	public function events(Request $request){
		$events = [];
        $data = ExamSlotModel::with(['exam'])->get();
        
	      foreach ($data as $key => $value) 
	      {

	      	$strData = json_decode($value->time);
	      	$days = self::getAllDaysInAMonth(date('Y'), date('m'), $value->day);

			foreach ($days as $day) 
			{
	      		$start_time =  $day->format('Y-m-d').' '.$strData['0']->start_time;
	      		$end_time   =  $day->format('Y-m-d').' '.$strData['0']->end_time;
				

				if (Date('Y-m-d') < $day->format('Y-m-d')) 
				{
					$eventsTemp['title'] = $value->exam->title;
					$eventsTemp['start'] = $start_time;
					$eventsTemp['end'] = $end_time;

					$events[] = $eventsTemp;
				}

			}
		}
	
		return \Response::json($events);
		// return response()->json($events);
	}
}
