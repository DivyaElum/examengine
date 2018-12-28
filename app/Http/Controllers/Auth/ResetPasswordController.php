<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\resetPasswordRequest;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\PasswordReset;
use Session;

class ResetPasswordController extends Controller
{
	private $User;

	public function __construct(
        User $User
    )
    {       
        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Password reset';
        $this->ModuleView  = 'auth.';
        $this->ModulePath  = 'auth';
    }

    //Function for reset password
    public function index($intToken){ 
    	$arrData  = PasswordReset::where('token',$intToken)->first();
    	if(!empty($arrData)){
			$strEmail = $arrData->email;
			$this->ViewData['arrUserData'] = User::where('email',$strEmail)->first();

			$this->ViewData['modulePath'] = $this->ModulePath;
			$this->ViewData['moduleTitle'] = $this->ModuleTitle;
			$this->ViewData['moduleAction'] = 'forgot password';

			return view($this->ModuleView.'resetpassword', $this->ViewData);
    	}else{
    		Session::flash('errorMsg', 'Your Token is expire');
            return redirect('/signup');
    	}
    }
    
    public function resetpass(resetPasswordRequest $request){
 		if(!empty($request->input())){
			$strEmail 	  	 = $request->input('email');
			$strNewPassword  = $request->input('password');
			$strComPassword  = $request->input('confirm_password');
			$strToken	     = $request->input('urltoken');
			
			//check token exists in db
		  	$arrChkData = PasswordReset::where('token',$strToken)->first();
		  	if($arrChkData){
		  		$arrUserData = User::where('email',$strEmail)->first();
		  		$intUserId 	 = $arrUserData->id;
		  		$arrData = array(
					'password' 		 => Hash::make($strNewPassword),
					'updated_at'	 =>date('Y-m-d H:i:s')
				);
				User::where('id',$intUserId)->update($arrData);

				PasswordReset::where('token',$strToken)->delete();
				$this->JsonData['status'] = 'success';
	            $this->JsonData['url'] 	  = '/signup';
            	$this->JsonData['msg'] 	  = 'Password has been updated successfully.';
		  	}else{
		  		$this->JsonData['status'] ='error';
            	$this->JsonData['msg']    ='Token is invalid';
		  	}
		}

		return response()->json($this->JsonData);
    }
}
