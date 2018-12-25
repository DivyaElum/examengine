<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use App\Models\CourseModel;
use App\Models\Event;
use App\Models\ExamSlotModel;
use Calendar;

class ExamController extends Controller
{
	private $CourseModel;

    public function __construct(

        CourseModel $CourseModel
    )
    {
        $this->CourseModel  = $CourseModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Certification Listing';
        $this->ModuleView  = 'front.exam.';
        $this->ModulePath  = 'CourseModel';
    }	

	public function index(Request $request, $token)
	{
		$exam = Session::get('exam');
		
		if ($exam['respd'] == $token) 
		{
			$this->ViewData['object'] = $exam['object'];
			
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
        // dd($data);
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
					$events[] = Calendar::event(
		                $value->exam->title,
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
}
