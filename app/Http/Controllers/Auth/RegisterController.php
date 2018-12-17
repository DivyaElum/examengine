<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;

use App\User;
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
        RegisterModel $RegisterModel,
        UserInfoModels $UserInfoModels
    )
    {
        $this->RegisterModel    = $RegisterModel;
        $this->User             = $User;
        $this->UserInfoModels   = $UserInfoModels;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = '';
        $this->ModuleView  = 'auth.';
        $this->ModulePath  = 'sign-up';

    }
    public function index()
    {
        $this->ViewData['page_title'] = 'Become a Candidate';
        $this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Sign-up '.str_plural($this->ModuleTitle);

        return view($this->ModuleView.'registration', $this->ViewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        
        $User               = new $this->User;
        $User->name         = $request->first_name.'_'.$request->last_name;
        $User->email        = $request->email;
        $User->password     = Hash::make($request->password);
        
        $strImgName = '';
        if ($User->save()) 
        {
            //$User->assignRole($request->user_role);
           
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

            if ($UserInfoModels->save()) 
            {
                DB::commit();
                $this->JsonData['status']   = 'success';
                $this->JsonData['url']      = '/sign-up?type='.$request->user_role;
                $this->JsonData['msg']      = $request->user_role.' saved successfully.';
            }else{
                 DB::rollBack();
                $this->JsonData['status']   ='error';
                $this->JsonData['msg']      ='Failed to save member, Something went wrong.';
            }
        }
        else
        {
             DB::rollBack();
            $this->JsonData['status']   ='error';
            $this->JsonData['msg']      ='Failed to save member, Something went wrong.';
        }
        return response()->json($this->JsonData);
    }

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
                $this->JsonData['msg']    = 'login successfully.';
            }
            else
            {
                //wrong email entered
                $this->JsonData['status'] ='error';
                $this->JsonData['msg']    ='Entered  credentials is incorrect...';
            }
        }
        else{
            $this->JsonData['status'] ='error';
            $this->JsonData['msg'] ='Please enter a data';
        }
        return response()->json($this->JsonData);

    }

}
