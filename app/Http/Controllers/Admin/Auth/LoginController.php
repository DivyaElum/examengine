<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Admin\ForgotPasswordRequest;
use App\Http\Requests\Admin\resetPasswordRequest;
use App\Mail\ForgotPasswordMail; 

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

			//check user role 
		  	$user = User::where('email',$strEmail)->first();
		  	if($user->hasRole('admin'))
		  	{
			  	$remember_me = $request->has('chkRememberMe') ? 'true' : 'false'; 
			  	
			  	if($remember_me == 'true')
			  	{
			  		$strPasswordEncd = base64_encode(base64_encode($strPassword));
			  		setcookie('setEmail',$strEmail,time() + (10 * 365 * 24 * 60 * 60));
			  		setcookie('setPassword',$strPasswordEncd,time() + (10 * 365 * 24 * 60 * 60));
			  	}
			  	else
			  	{
			  		unset($_COOKIE['setEmail']);
	    			unset($_COOKIE['setPassword']);
	    			setcookie('setEmail', '', -1, time() + (10 * 365 * 24 * 60 * 60));
	    			setcookie('setPassword', '', -1,time() + (10 * 365 * 24 * 60 * 60));
			  	}

			  	if (auth()->attempt(['email' => $strEmail, 'password' => $strPassword], $remember_me))
			  	{
		            $this->JsonData['status'] = 'success';
		            $this->JsonData['url'] 	  = '/admin/dashboard';
	            	$this->JsonData['msg'] 	  = __('messages.ERR_STR_LOGIN_SUCCESSFULLY_MESSAGE');
		        }
		        else
		        {
		        	//wrong email entered
				    $this->JsonData['status'] ='error';
	            	$this->JsonData['msg'] 	  = __('messages.ERR_STR_CREDENTIALS_ERROR_MESSAGE');
		        }
		    }
		    else
		    {
		    	$this->JsonData['status'] ='error';
	            $this->JsonData['msg'] 	  = __('messages.ERR_STR_CREDENTIALS_ERROR_MESSAGE');
		    }
		}
		else{
			$this->JsonData['status'] ='error';
            $this->JsonData['msg'] 	  = __('messages.ERR_STR_EMPTY_FIELD_ERROR_MESSAGE');
		}
    	return response()->json($this->JsonData);
    }

    public function forgotpassword(){
    	return view('admin.auth.forgotPassword');
    }

    //Function for forgot password
    public function forgot(ForgotPasswordRequest $request)
    {
    	if (!empty($request->txtEmail)) 
    	{
    		$strEmail = $request->txtEmail;
	  		$arrUserData = User::where('email',$strEmail)->first();

		  	if (empty($arrUserData) && sizeof($arrUserData) == 0) 
		  	{
			    $this->JsonData['status'] ='error';
            	$this->JsonData['msg'] 	  = __('messages.ERR_STR_EMAILID_ERROR_MESSAGE');
		  	}
		  	else
		  	{
		  		$intId 	  = $arrUserData->id;
		  		$strEmail = $arrUserData->email;
		  						
				$data = [];
				$data['url'] = url('admin/resetpassword/'.base64_encode(base64_encode($intId)));
		  		$mail 	= Mail::to($strEmail)->send(new ForgotPasswordMail($data));

				$post = PasswordReset::create([
					'email' => $strEmail,
					'token' => base64_encode(base64_encode($intId))
				]);
				
				$this->JsonData['status'] = 'success';
				$this->JsonData['url'] 	  = '/admin/login';
            	$this->JsonData['msg'] 	  =  __('messages.ERR_RESET_PASSWORD_MESSAGE');
		  	}
		  	
		  	return response()->json($this->JsonData);
    		die;
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
            	$this->JsonData['msg'] 	  = __('messages.ERR_STR_PASSWORD_SUCCESS_MESSAGE');
		  	}else{
		  		$this->JsonData['status'] ='error';
            	$this->JsonData['msg']    = __('messages.ERR_STR_TOKEN_ERROR_MESSAGE');
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
