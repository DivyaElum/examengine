<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
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

        $this->ModuleTitle = 'register Member';
        $this->ModuleView  = 'auth.';
        $this->ModulePath  = 'register';
    }
    public function index()
    {
        $this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Manage '.str_plural($this->ModuleTitle);

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

        DB::beginTransaction();
        
        $User           = new $this->User;

        $User->name         = $request->txtFirstName.'_'.$request->txtLastName;
        $User->email        = $request->email;
        $User->password     = Hash::make($request->txtPassword);
        
        if ($User->save()) 
        {
            // $User->assignRole('candidate');
            
            $UserInfoModels               = new $this->UserInfoModels;
            $UserInfoModels->user_id      = $User->id;
            $UserInfoModels->first_name   = $request->txtFirstName;
            $UserInfoModels->last_name    = $request->txtLastName;
            $UserInfoModels->phone        = $request->txtPhone;

            if ($UserInfoModels->save()) 
            {
                DB::commit();
                $this->JsonData['status']   = 'success';
                $this->JsonData['msg']      = 'member saved successfully.';
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
