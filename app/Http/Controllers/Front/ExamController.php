<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;

class ExamController extends Controller
{
 		
 	public function __construct()
 	{
 		$this->ViewData = [];
        $this->JsonData = [];
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

}
