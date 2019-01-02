<?php

namespace App\Http\Controllers\Front;

use App\Models\Event;
use App\Models\ExamModel;
use App\User as UserModel;
use App\Models\CourseModel;
use Illuminate\Http\Request;
use App\Models\ExamSlotModel;
use App\Models\BookExamSlotModel;
use App\Models\ExamQuestionsModel;
use App\Models\ExamResultModel;
use App\Models\ExamResultCategoryWiseModel;
use App\Models\QuestionCategoryModel;

use App\Models\QuestionOptionsAnswer;
use App\Http\Controllers\Controller;

use DB;
use Session;
use Calendar;
use Carbon\Carbon;

class ExamController extends Controller
{
 	public function __construct(
 		ExamModel 			$ExamModel,
 		UserModel 			$UserModel,
 		ExamResultModel 	$ExamResultModel,
 		BookExamSlotModel 	$BookExamSlotModel,
 		ExamQuestionsModel 	$ExamQuestionsModel,
 		QuestionOptionsAnswer $QuestionOptionsAnswer,
 		ExamResultCategoryWiseModel $ExamResultCategoryWiseModel,
 		QuestionCategoryModel $QuestionCategoryModel,
 		CourseModel $CourseModel
 	)
 	{
 		$this->BaseModel 		  = $ExamModel;
 		$this->UserModel 		  = $UserModel;
 		$this->ExamResultModel	  = $ExamResultModel;
 		$this->BookExamSlotModel  = $BookExamSlotModel;
 		$this->ExamQuestionsModel = $ExamQuestionsModel;
 		$this->QuestionOptionsAnswer = $QuestionOptionsAnswer;
 		$this->ExamResultCategoryWiseModel  = $ExamResultCategoryWiseModel;
 		$this->QuestionCategoryModel  = $QuestionCategoryModel;
 		$this->CourseModel  = $CourseModel;


 		$this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Exam Slot book';
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
													 ->with(['repository','category'])
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

	public function examBook($endId)
	{       
		$this->ViewData['page_title']    = $this->ModuleTitle;
    	$this->ViewData['moduleTitle']   = $this->ModuleTitle;
        $this->ViewData['moduleAction']  = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']    = $this->ModulePath;
        $this->ViewData['course_id']     = $endId;
        $this->ViewData['exam_id']       = $this->CourseModel->where('id', base64_decode(base64_decode($endId)))->pluck('exam_id')->first();
        
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

	public function submit(Request $request)
	{		

		$optionsAnswers = $this->QuestionOptionsAnswer->get();

		if (!empty($request->result_id)) 
		{
			$result_id = base64_decode(base64_decode($request->result_id));
			$resultObject = $this->ExamResultModel->find($result_id);
			$exam_id = $resultObject->exam_id;

			$statusBag = [];
			$resultBag = [];	
			$resultBag['total_questions'] =  $this->BaseModel->where('id', $exam_id)
														     ->pluck('total_question')
														     ->first();

			if (!empty($request->correct) && sizeof($request->correct) > 0) 
			{
				// check answers for radio
				if (!empty($request->correct['radio']) && sizeof($request->correct['radio']) > 0)
				{
					foreach ($request->correct['radio'] as $radioKey => $radio) 
					{
						$examQuestionsRadio = $this->ExamQuestionsModel
								 			  ->with(['repository','category'])
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
								$statusBag[] = array('exam_id' => $radioKey, 'category_id' => $examQuestionsRadio['category']['id'], 'status' => 1);
							}
							else
							{
								$statusBag[] = array('exam_id' => $radioKey, 'category_id' => $examQuestionsRadio['category']['id'], 'status' => 0);
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
								 			  ->with(['repository','category'])
								 			  ->find($checkBoxKey);
						// dd($examQuestionsCheckbox);

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
							if (count($checkbox)==count($questionCorrectOptionsCheckbox))
							{
								$result = array_diff($checkbox,  $questionCorrectOptionsCheckbox);
								if (!empty($result) && sizeof($result) > 0) 
								{
									$statusBag[] = array('exam_id' => $checkBoxKey, 'category_id' => $examQuestionsCheckbox['category']['id'], 'status' => 0);
								}
								else
								{
									$statusBag[] = array('exam_id' => $checkBoxKey, 'category_id' => $examQuestionsCheckbox['category']['id'], 'status' => 1);
								}
							}
							else
							{
								$statusBag[] = array('exam_id' => $checkBoxKey, 'category_id' => $examQuestionsCheckbox['category']['id'], 'status' => 0);
							}
						}
					}	
				}

				$categoryWiseBag = $statusBag;

				$resultBag['total_attempted']  = count($statusBag);

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

				$resultBag['exam_status'] =  $resultBag['percentage'] >= 75 ? 'Pass' : 'Fail';
			}
			else
			{
				$resultBag['total_attempted']  	= 0;
				$resultBag['total_right']  		= 0;
				$resultBag['total_wrong']  		= 0;
				$resultBag['percentage'] 		= 0;
				$resultBag['exam_status'] 	= 'Fail';
			}

			// get each question categroy
			$ExamQuestions = $this->ExamQuestionsModel->with(['category'])
													 ->whereIn('id', $request->question_id)
												   	->get(['category_id', 'id as question_id'])
												   	->toArray();

			// find how many categories used 
			$uniqueExamIdWithCategories = array_unique(array_column($ExamQuestions, 'category_id'));

			// find total question within category
			$arrCategoriesWithExam = [];
			foreach ($uniqueExamIdWithCategories as $uniqueExamIdWithCategoryKey => $uniqueExamIdWithCategory) 
			{
				foreach ($ExamQuestions as $ExamQuestionKey => $ExamQuestion) 
				{
					if ($uniqueExamIdWithCategory == $ExamQuestion['category_id']) 
					{
						$arrCategoriesWithExam[$uniqueExamIdWithCategory]['questions_id'][] = $ExamQuestion['question_id'];
						$arrCategoriesWithExam[$uniqueExamIdWithCategory]['category_name'] 	  = $ExamQuestion['category']['category_name'];
					}
				}	
			}
			
			// build category wise result
			$resultBag['categories'] = [];
			foreach ($arrCategoriesWithExam as $arrCategoryWithExamKey => $arrCategoryWithExam) 
			{
				$resultBag['categories'][$arrCategoryWithExamKey]['category_name'] 	 = $arrCategoryWithExam['category_name'];

				$resultBag['categories'][$arrCategoryWithExamKey]['category_id'] 	 = $arrCategoryWithExamKey;
				
				$resultBag['categories'][$arrCategoryWithExamKey]['total_questions'] = count($arrCategoryWithExam['questions_id']);

				$total_attempted = [];
				$total_right = [];
				$total_wrong = [];
				foreach ($statusBag as $statusKey => $status) 
				{
					if ($arrCategoryWithExamKey == $status['category_id']) 
					{
						$total_attempted[] = $status;
					
						if (!empty($status['status'])) 
						{
							$total_right[] = $status;
						}

						if (empty($status['status'])) 
						{
							$total_wrong[] = $status;
						}
					}
				}

				$resultBag['categories'][$arrCategoryWithExamKey]['total_attempted'] = count($total_attempted);
				$resultBag['categories'][$arrCategoryWithExamKey]['total_right']  	 = count($total_right);
				$resultBag['categories'][$arrCategoryWithExamKey]['total_wrong']  	 = count($total_wrong);	
			}

			// update main table
			$arrResult = array_except($resultBag, 'categories');			
			$updatedExamStatus = $this->ExamResultModel->where('id', $result_id)->update($arrResult);
			if ($updatedExamStatus) 
			{
				// update ctegory wise table
				$arrResultCategoryWise = array_only($resultBag, 'categories')['categories'];
				foreach ($arrResultCategoryWise as $key => $value) 
				{
					$tmp = array_except($value, 'category_name'); 
					$tmp['exam_result_id'] = $result_id; 

					$this->ExamResultCategoryWiseModel->insert($tmp);
				}
			}

			return view('front.exam.result', ['resultBag' => $resultBag]);
		}
	}

	public function events(Request $request)
	{
		$intId = base64_decode(base64_decode($request->id));
		
		$events = [];
        $data = ExamSlotModel::with(['exam'])->where('exam_id', $intId)->get();
        foreach ($data as $key => $value) 
	      {
	      	$strData = json_decode($value->time);
	      	$days 	 = self::getAllDaysInAMonth(date('Y'), date('m'), $value->day);

			foreach ($days as $day) 
			{
				for($i=0;$i<count($strData);$i++)
				{
					$start_time =  $day->format('Y-m-d').' '.$strData[$i]->start_time;
	      			$end_time   =  $day->format('Y-m-d').' '.$strData[$i]->end_time;

	      			$cstart_time = Carbon::parse($start_time);
		      		$cend_time   = Carbon::parse($end_time);
					
					if (Date('Y-m-d') < $day->format('Y-m-d')) 
					{
						$eventsTemp['id'] 	 = $value->id;
						$eventsTemp['title'] = $value->exam->title;
						$eventsTemp['start'] = $start_time;
						$eventsTemp['end']   = $end_time;
						$events[] 			 = $eventsTemp;
						
						for($i = 1; $i <= 24; $i++) 
						{
							$tempStart = Carbon::parse($start_time);
							$tempEnd = Carbon::parse($end_time);

							$eventsTemp['id'] 	 = $value->id;
							$eventsTemp['title'] = $value->exam->title;
							$eventsTemp['start'] = $tempStart->addWeek($i)->format('Y-m-d H:i:s');
							$eventsTemp['end']   = $tempEnd->addWeek($i)->format('Y-m-d H:i:s');
							$events[] = $eventsTemp;

						}
					}
				}
			}
		}

		return response()->json($events);
	}

	public function getExampSlot(Request $request)
	{
		$intId = $request->id;
		//$data = ExamSlotModel::with(['exam'])->first();

		$data = ExamSlotModel::with(['exam'])->where('id', $intId)->first();
    	$strData = json_decode($data->time);
		
    	$html = '';
		for($i=0;$i<count($strData);$i++)
		{
			$start_time =  $strData[$i]->start_time;
  			$end_time   =  $strData[$i]->end_time;

  			$html .= '<input type="radio" name="slot" id="slot_'.$i.'" value="'.$start_time.'/'.$end_time.'"> <label for="slot_'.$i.'">'.$start_time.' To '.$end_time.'</label> &nbsp&nbsp;';
  		}
    	return response()->json($html);
	}

	public function bookExamSlot(Request $request){
		DB::beginTransaction();

        $object          	 = new $this->BookExamSlotModel;
        $object->exam_id   	 = base64_decode(base64_decode(base64_decode(base64_decode($request->exam_id))));
        $object->user_id   	 = base64_decode(base64_decode($request->user_id));
        $object->course_id   = $request->course_id;
        $object->slot_time   = $request->slot_time;
        
        if($object->save())
        {
        	DB::commit();
        	$this->JsonData['status']   = 'success';
            $this->JsonData['msg']      = __('messages.ERR_EXAM_BOOK_MESSAGE');
        }
        else
        {
        	$this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_SAVE_EXM_ERROR_MESSAGE');
            DB::rollBack();
        }
        return response()->json($this->JsonData);
	}

	public function updateExamResultStatus(Request $request)
	{
		if (!empty($request->user_id) && !empty($request->course_id) && !empty($request->exam_id)) 
		{
			$user_id 	= base64_decode(base64_decode($request->user_id));
			$course_id 	= base64_decode(base64_decode($request->course_id));
			$exam_id 	= base64_decode(base64_decode($request->exam_id));

			$ExamResultModel = new $this->ExamResultModel;
			
			$ExamResultModel->user_id 		= $user_id;
			$ExamResultModel->course_id 	= $course_id;
			$ExamResultModel->exam_id 		= $exam_id;
			$ExamResultModel->exam_status 	= 'Started';

			if ($ExamResultModel->save()) 
			{
				$this->JsonData['status'] = 'success';
				$this->JsonData['result'] = base64_encode(base64_encode($ExamResultModel->id));				
			}
			else
			{
				$this->JsonData['status'] = 'error';
				$this->JsonData['status'] = __('messages.ERR_SAVE_EXM_ERROR_MESSAGE');
			}
		}
		else
		{
			$this->JsonData['status'] = 'error';
			$this->JsonData['status'] = __('messages.ERR_SAVE_EXM_ERROR_MESSAGE');
		}

		return response()->json($this->JsonData);
	}
}
