<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use App\Models\CourseModel;

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

	public function examBook(){
		$this->ViewData['page_title']           = $this->ModuleTitle;
    	$this->ViewData['moduleTitle']          = $this->ModuleTitle;
        $this->ViewData['moduleAction']         = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']           = $this->ModulePath;
       

        return view($this->ModuleView.'index', $this->ViewData);
	}

}
