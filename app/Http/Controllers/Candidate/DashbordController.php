<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User as UserModel;
use App\Models\UserInfoModels;
use App\Models\CourseModel;
use App\Models\TransactionModel;

class DashbordController extends Controller
{
    private $CourseModel;
    private $UserModel;
    private $TransactionModel;

    public function __construct(
        UserModel $UserModel,
        CourseModel $CourseModel,
        TransactionModel $TransactionModel
    )
    {
    	$this->CourseModel  	  = $CourseModel;
    	$this->UserModel 		    = $UserModel;
    	$this->TransactionModel = $TransactionModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Dashboard';
        $this->ModuleView  = 'front.dashboard';
        $this->ModulePath  = 'dashboard';
    }

   	public function index()
   	{
   		$user_id = auth()->user()->id;

   		$arrUsers = $this->UserModel->with(['information'])->find($user_id);	//get login user data
   		
      $courses = $this->CourseModel->whereHas('transaction',function($query) use($user_id)
  		  {
  			   $query->where('user_id', $user_id);
  		  })
		->get();
		
   		$this->ViewData['modulePath']   	 = $this->ModulePath;
      $this->ViewData['moduleTitle']  	 = $this->ModuleTitle;
      $this->ViewData['moduleAction'] 	 = $this->ModuleTitle;
      $this->ViewData['page_title']   	 = $this->ModuleTitle;
      $this->ViewData['arrUserData']  	 = $arrUsers;
      $this->ViewData['arrUsersCourse']  = $courses;
        
        return view($this->ModuleView, $this->ViewData);
   	}
}
