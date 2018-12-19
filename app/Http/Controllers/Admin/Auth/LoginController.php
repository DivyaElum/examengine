<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Admin\ForgotPasswordRequest;
use App\Http\Requests\Admin\resetPasswordRequest;
use App\Mail\passwordResetMail;

use App\User;
use App\PasswordReset;
use App\Models\Auth\CheckLoginModel;
use Validator;
use Mail;
use Session;

class LoginController extends Controller
{
	private $User;
	private $CheckLoginModel;

	public function __construct(
        User $User,
        CheckLoginModel $CheckLoginModel
    )
    {       
        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Login';
        $this->ModuleView  = 'admin.auth.';
        $this->ModulePath  = 'admin.auth';
    }

    public function index()
    {
    	$this->ViewData['modulePath']   = $this->ModulePath;
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Manage '.str_plural($this->ModuleTitle);

        return view($this->ModuleView.'login', $this->ViewData);
    }

    //Function for check login details
    public function checkLogin(LoginRequest $request){
    	//Custome validation messages
 		
    	if(!empty($request->input())){
			$strEmail 	  = $request->input('email');
			$strPassword  = $request->input('password');
			$strHashPass  =  Hash::make($strPassword);

			//check user exists in db
		  	$arrUserData = User::where('email',$strEmail)->first();
		  	
		  	$remember_me = $request->has('chkRememberMe') ? 'true' : 'false'; 
		  	
		  	if($remember_me == 'true'){
		  		$strPasswordEncd = base64_encode(base64_encode($strPassword));
		  		setcookie('setEmail',$strEmail,time() + (10 * 365 * 24 * 60 * 60));
		  		setcookie('setPassword',$strPasswordEncd,time() + (10 * 365 * 24 * 60 * 60));
		  	}else{
		  		unset($_COOKIE['setEmail']);
    			unset($_COOKIE['setPassword']);
    			setcookie('setEmail', '', -1, time() + (10 * 365 * 24 * 60 * 60));
    			setcookie('setPassword', '', -1,time() + (10 * 365 * 24 * 60 * 60));
		  	}

		  	if (auth()->attempt(['email' => $strEmail, 'password' => $strPassword], $remember_me))
		  	{
	            $this->JsonData['status'] = 'success';
	            $this->JsonData['url'] 	  = '/admin/dashboard';
            	$this->JsonData['msg'] 	  = 'login successfully.';
	        }
	        else
	        {
	        	//wrong email entered
			    $this->JsonData['status'] ='error';
            	$this->JsonData['msg'] 	  ='Entered  credentials is incorrect...';
	        }
		}
		else{
			$this->JsonData['status'] ='error';
            $this->JsonData['msg'] ='Please enter a data';
		}
    	return response()->json($this->JsonData);
    }

    public function forgotpassword(){
    	return view('admin.auth.forgotPassword');
    }

    //Function for forgot password
    public function forgot(ForgotPasswordRequest $request)
    {
    	if($request->input()){
	 		$strEmail = $request->input('txtEmail');
			//check user exists in db
		  	$arrUserData = User::where('email',$strEmail)->first();
		  	//dd($arrUserData);
		  	if (count($arrUserData)<=0) {
		  		//wrong email entered
			    $this->JsonData['status'] ='error';
            	$this->JsonData['msg'] 	  ='Please enter valid Email Id';
		  	}else{
		  		$intId = $arrUserData->id;
		  		$strEmail = $arrUserData->email;
		  		
		  		//Mail::to($strEmail)->send(new passwordResetMail);
				echo $url = url('admin/resetpassword/'.base64_encode(base64_encode($intId)));

				//save token 
				$post = PasswordReset::create([
					'email' => $strEmail,
					'token' => base64_encode(base64_encode($intId))
				]);
				$this->JsonData['status'] = 'success';
	            //$this->JsonData['url'] 	  = '/admin/login';
            	$this->JsonData['msg'] 	  =  $url;
            	//$this->JsonData['msg'] 	  = 'Password has been updated successfully.';
            	die;
		  	}
		  	return response()->json($this->JsonData);
    	}
    	return view('admin.auth.forgotPassword');
    }
     //Function for reset password
    public function resetpassword($intToken){    
    	$arrData = PasswordReset::where('token',$intToken)->first();
    	if(!empty($arrData)){
	    	$strEmail = $arrData->email;
			$arrUserData['arrUserData'] = User::where('email',$strEmail)->first();
	    	return view('admin.auth.resetpassword',$arrUserData);
    	}else{
    		Session::flash('errorMsg', 'Invalid Token');
            return redirect('/admin/forgot');
    	}
    }
    
    public function resetpass(resetPasswordRequest $request){
 		$validator = Validator::make($request->all(), [
   	 	 	'txtEmail'         	=> 'required|email',
		 	'txtNewPassword'	=> 'required|min:8|max:20',
		  	'txtComPassword' 	=> 'required|same:txtNewPassword|min:8|max:20'
		])->validate();

 		if(!empty($request->input())){
			$strEmail 	  	 = $request->input('txtEmail');
			$strNewPassword  = $request->input('txtNewPassword');
			$strComPassword  = $request->input('txtComPassword');
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
	            $this->JsonData['url'] 	  = '/admin/login';
            	$this->JsonData['msg'] 	  = 'Password has been updated successfully.';
		  	}else{
		  		$this->JsonData['status'] ='error';
            	$this->JsonData['msg']    ='Token is invalid';
		  	}

		}

		return response()->json($this->JsonData);
    }

    //Function for logout
	public function logout()
	{
		auth()->logout();
		return redirect('/admin/login');
	}
}
