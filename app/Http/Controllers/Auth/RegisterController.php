<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;

use Mail;
use App\User;
use App\SiteSetting;
use App\Mail\RegisterMail; 
use App\Models\UserInfoModels;
use App\Models\Auth\RegisterModel;

// others
use Validator;
use DB;

class RegisterController extends Controller
{
    private $User;
    private $RegisterModel;
    private $UserInfoModels;

    public function __construct(

        User $User,
        SiteSetting $SiteSetting,
        RegisterModel $RegisterModel,
        UserInfoModels $UserInfoModels
    )
    {
        $this->RegisterModel    = $RegisterModel;
        $this->User             = $User;
        $this->UserInfoModels   = $UserInfoModels;
        $this->SiteSetting      = $SiteSetting;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = '';
        $this->ModuleView  = 'auth.';
        $this->ModulePath  = 'signup';

    }
    public function index()
    {
        $this->ViewData['page_title'] = 'Become a Candidate';
        $this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Sign-up '.str_plural($this->ModuleTitle);

        return view($this->ModuleView.'registration', $this->ViewData);
    }

    //store user data
    public function store(RegisterRequest $request)
    {
        DB::beginTransaction();
        $User               = new $this->User;
        $User->name         = $request->first_name.'_'.$request->last_name;
        $User->email        = $request->email;
        $User->password     = Hash::make($request->password);
        
        $strImgName = '';
        if ($User->save()) 
        {
            $User->assignRole($request->user_role);
           
            //Store orignal image
            if($request->user_role != 'candidate'){
                $strImage = $request->organisation_image;
                $strImgName = time().$strImage->getClientOriginalName();
                $strOriginalImgdesignationPath = public_path().'/upload/organisation-image' ;
                $strImage->move($strOriginalImgdesignationPath, $strImgName);
            }
            $UserInfoModels                     = new $this->UserInfoModels;

            $UserInfoModels->user_id            = $User->id;
            $UserInfoModels->first_name         = $request->first_name;
            $UserInfoModels->last_name          = $request->last_name;
            $UserInfoModels->phone              = $request->telephone_no;
            $UserInfoModels->organisation_name  = $request->organisation_name;
            $UserInfoModels->organisation_image = $strImgName;
            $UserInfoModels->status             = '0';

            //get site seeting data
            $arrSiteSetting = SiteSetting::find('1');
            if ($UserInfoModels->save()) 
            {
                $endId                = base64_encode(base64_encode(base64_encode($UserInfoModels->id)));
                $token                = Hash::make($endId);
                $data['url']          = url('/active-member/'.$endId."/".$token);
                $data['first_name']   = $request->first_name;
                $data['last_name']    = $request->last_name;
                $data['siteName']     = $arrSiteSetting->site_title;
                $data['email_id']     = $request->email;
                $mail                 = Mail::to($request->email)->send(new RegisterMail($data));
                
                DB::commit();
                $this->JsonData['status']   = 'success';
                $this->JsonData['url']      = '/sign-up?type='.$request->user_role;
                $this->JsonData['msg']      = $request->user_role.' saved successfully.';
            }else{
                 DB::rollBack();
                $this->JsonData['status']   ='error';
                $this->JsonData['msg']      = __('messages.ERR_SAVE_MEM_ERROR_MESSAGE');
            }
        }
        else
        {
             DB::rollBack();
            $this->JsonData['status']   ='error';
            $this->JsonData['msg']      = __('messages.ERR_SAVE_MEM_ERROR_MESSAGE');
        }
        return response()->json($this->JsonData);
    }

    //check login function
    public function checkLogin(LoginRequest $request)
    {
        if(!empty($request->input())){
            $strEmail     = $request->input('email');
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
                $this->JsonData['url']    = '/admin/dashboard';
                $this->JsonData['msg']    = '';
            }
            else
            {
                //wrong email entered
                $this->JsonData['status'] = 'error';
                $this->JsonData['msg']    = __('messages.ERR_INVALID_USER_PASS');
            }
        }
        else{
            $this->JsonData['status'] ='error';
            $this->JsonData['msg'] = __('messages.ERR_STR_EMPTY_FIELD_ERROR_MESSAGE');
        }
        return response()->json($this->JsonData);
    }

}
