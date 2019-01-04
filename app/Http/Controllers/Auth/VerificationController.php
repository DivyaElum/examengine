<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use DB;
use Mail;
use Session;
use App\User;
use App\SiteSetting;
use App\Models\UserInfoModels;
use App\Models\Auth\RegisterModel;

class VerificationController extends Controller
{
	private $User;
    private $RegisterModel;

    public function __construct(

        User $User,
        SiteSetting $SiteSetting,
        RegisterModel $RegisterModel,
        UserInfoModels $UserInfoModels
    )
    {
        $this->User             = $User;
        $this->RegisterModel    = $RegisterModel;
        $this->UserInfoModels   = $UserInfoModels;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = '';
        $this->ModuleView  = 'auth.';
        $this->ModulePath  = 'Active user';

    }
    public function index()
    {
    	$strEndId  = request()->segment(2);
    	$intUserId = base64_decode(base64_decode(base64_decode($strEndId)));
    	if(isset($strEndId))
    	{
    		$arrUserData = $this->UserInfoModels->where('id',$intUserId)
    											->where('status','0')
    											->first();

			if($arrUserData != 'null' && isset($arrUserData))
			{
				$this->UserInfoModels->where('id', $intUserId )->update(['status' => '1']);
				Session::flash('successMsg', 'Your account is actived successfully'); 
				return redirect('signup');
    		}
    		else
    		{
    			Session::flash('errorMessage', 'This token is expired. Please try again'); 
				return redirect('signup');
    		}
    	}
    	else
    	{
    		abort(404);
    	}
    }
}
