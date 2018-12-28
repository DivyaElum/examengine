<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail; 

use Mail;
use App\User;
use App\PasswordReset;

class ForgotPasswordController extends Controller
{
	private $User;
    private $CheckLoginModel;

    public function __construct(
        User $User
    )
    {       
        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Forgot Password';
        $this->ModuleView  = 'auth.';
        $this->ModulePath  = 'ForgotPasswordController';
    }
    public function index(){
        $this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'forgot password';

        return view($this->ModuleView.'forgot', $this->ViewData);
    }
    public function forgotpassword(Request $request){
    	if($request->input()){
	 		$strEmail = $request->input('email');
			//check user exists in db
		  	$arrUserData = User::where('email',$strEmail)->first();
		  	//dd($arrUserData);
		  	if (!$arrUserData) {
		  		//wrong email entered
			    $this->JsonData['status'] ='error';
            	$this->JsonData['msg'] 	  ='Please enter valid Email Id';
		  	}else{
		  		$intId = $arrUserData->id;
		  		$strEmail = $arrUserData->email;
		  		
		  		//Mail::to($strEmail)->send(new passwordResetMail);
				// echo $url = url('/resetpassword/'.base64_encode(base64_encode($intId)));

                $data['url'] = url('/resetpassword/'.base64_encode(base64_encode($intId)));
                $mail        = Mail::to($strEmail)->send(new ForgotPasswordMail($data));
				//save token 
				$post = PasswordReset::create([
					'email' => $strEmail,
					'token' => base64_encode(base64_encode($intId))
				]);
                $this->JsonData['status'] = 'success';
				$this->JsonData['url']    = '/signup';
                $this->JsonData['msg']    = 'Password reset link has sent to your mail address.';
            	
		  	}
		  	return response()->json($this->JsonData);
    	}
    	return view('auth.forgotPassword');
    }
}
