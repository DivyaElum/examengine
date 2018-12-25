<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExamModel;
use App\Models\ExamQuestionsModel;

use Session;
use DB;

class ExamController extends Controller
{
 		
 	public function __construct(
 		ExamModel $ExamModel,
 		ExamQuestionsModel $ExamQuestionsModel
 	)
 	{
 		$this->BaseModel = $ExamModel;
 		$this->ExamQuestionsModel = $ExamQuestionsModel;

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
		$this->ViewData['page_title']           = $this->ModuleTitle;
    	$this->ViewData['moduleTitle']          = $this->ModuleTitle;
        $this->ViewData['moduleAction']         = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']           = $this->ModulePath;
       
        return view($this->ModuleView.'index', $this->ViewData);
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
	}~
}
