<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User as UserModel;
use App\Models\UserInfoModels;
use App\Models\CourseModel;
use App\Models\TransactionModel;
use App\Models\PrerequisiteModel;

class CourseController extends Controller
{
   	private $CourseModel;
    private $UserModel;
    private $TransactionModel;
    private $PrerequisiteModel;

    public function __construct(
        UserModel $UserModel,
        CourseModel $CourseModel,
        TransactionModel $TransactionModel,
        PrerequisiteModel $PrerequisiteModel
    )
    {
    	$this->CourseModel  	 = $CourseModel;
    	$this->UserModel 		 = $UserModel;
    	$this->TransactionModel  = $TransactionModel;
    	$this->PrerequisiteModel = $PrerequisiteModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Course Details';
        $this->ModuleView  = 'Candidate.course-details';
        $this->ModulePath  = 'course-details';
    }
    public function index($indEncId)
   	{
   		$intId = base64_decode(base64_decode($indEncId));

   		$user_id = auth()->user()->id;
   		$arrUsers = $this->UserModel->with(['information'])->find($user_id);	//get login user data

   		$enc_prerequisites = $this->CourseModel->where('id', $intId)->pluck('prerequisite_id')->first();
   		
   		$arrPrerequisites = $this->PrerequisiteModel->whereIn('id', json_decode($enc_prerequisites))->get();

   		$this->ViewData['modulePath']   		= $this->ModulePath;
        $this->ViewData['moduleTitle']  		= $this->ModuleTitle;
        $this->ViewData['moduleAction'] 		= $this->ModuleTitle;
        $this->ViewData['page_title']   		= $this->ModuleTitle;
        $this->ViewData['arrUserData']  	 = $arrUsers;
        $this->ViewData['arrPrerequisites']  	= $arrPrerequisites;
        
        return view($this->ModuleView, $this->ViewData);
   	}
}
