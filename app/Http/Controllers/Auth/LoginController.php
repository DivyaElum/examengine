<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Models\Auth\CheckLoginModel;

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
        $this->ModuleView  = 'auth.';
        $this->ModulePath  = 'login';
    }

    public function index()
    {
        $this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Login '.str_plural($this->ModuleTitle);

        return view($this->ModuleView.'login', $this->ViewData);
    }

    public function store(LoginRequest $request)
    {
        if(!empty($request->input())){
            $strEmail     = $request->input('email');
            $strPassword  = $request->input('password');
            $strHashPass  =  Hash::make($strPassword);
            
            //check user exists in db
            $arrUserData = User::where('email',$strEmail)->first();
            
            $remember_me = $request->has('remember') ? 'true' : 'false'; 
     
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
                $this->JsonData['url']    = '/dashboard';
                $this->JsonData['msg']    = 'Login successfully.';
            }
            else
            {
                //wrong email entered
                $this->JsonData['status'] ='error';
                $this->JsonData['msg']    ='Invalid Email Id and Password';
            }
        }
        else{
            $this->JsonData['status'] = 'error';
            $this->JsonData['msg']    = 'Please enter a data';
        }
        return response()->json($this->JsonData);
    }

    //Function for logout
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
