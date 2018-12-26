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
 		BookExamSlotModel 	$BookExamSlotModel,
 		ExamQuestionsModel $ExamQuestionsModel
 	)
 	{
 		$this->BaseModel 		  = $ExamModel;
 		$this->ExamQuestionsModel = $ExamQuestionsModel;
 		$this->UserModel 		  = $UserModel;
 		$this->BookExamSlotModel  = $BookExamSlotModel;

 		$this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Examp Slot book';
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

			$this->ViewData['arrUserData']        = $arrUsers;
			return view('exam', $this->ViewData);			
		}
		else
		{
			abort(404);
		}
	}

	public function examBook($endId)
	{
		// $events = [];
  //       $data = ExamSlotModel::with(['exam'])->get();
        
  //       $intI = '0';

  //       foreach ($data as $key => $value) 
  //       {

  //       	$strData = json_decode($value->time);
  //       	$days = self::getAllDaysInAMonth(date('Y'), date('m'), $value->day);

		// 	foreach ($days as $day) 
		// 	{
  //       		$start_time =  $day->format('Y-m-d').' '.$strData['0']->start_time;
  //       		$end_time   =  $day->format('Y-m-d').' '.$strData['0']->end_time;
				
		// 		if (Date('Y-m-d') < $day->format('Y-m-d')) 
		// 		{
		// 			//$strExamTitle = $value->exam->title;
		// 			$strExamTitle = 'Examp';
		// 			$events[] = Calendar::event(
		//                 $strExamTitle,
		//                 true,
		//                 new \DateTime($start_time),
		//                 new \DateTime($end_time),
		//                 null,
		//                 [
		//                     'color' => '#f05050',
		//                     'url' 	=> 'pass here url and any route',
		//                 ]
		//             );
		// 		}
		// 	}
  //       }
  //       $calendar = Calendar::addEvents($events);
       
		$this->ViewData['page_title']    = $this->ModuleTitle;
    	$this->ViewData['moduleTitle']   = $this->ModuleTitle;
        $this->ViewData['moduleAction']  = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']    = $this->ModulePath;
        $this->ViewData['exam_id']    	 = $endId;

        // $this->ViewData['calendar']      = $calendar;
        // $this->ViewData['calendarData']  = $data;

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
		if (!empty($user_id) && !empty($course_id) && !empty($exam_id)) 
		{
			if (!empty($request->correct) && sizeof($request->correct) > 0) 
			{
				// check answers for radio buttons
				if (!empty($request->correct['radio']) && sizeof($request->correct['radio']) > 0) 
				{
					foreach ($request->correct['radio'] as $key => $radio) 
					{
						$exam_question = $this->ExamQuestionsModel
								 			  ->with('repository')
								 			  ->find($key);
						dd($radio, $key, $exam_question);
					}
				}
				
			}	
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

		return \Response::json($events);
		// return response()->json($events);
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
            $this->JsonData['msg']      = 'Exam slot booked successfully';
        }
        else
        {
        	$this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = 'Failed to save exam slot, Something went wrong.';
            DB::rollBack();
        }
        return response()->json($this->JsonData);
	}
}
