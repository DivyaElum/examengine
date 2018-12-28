<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\NewsLetterMail; 

use DB;
use Mail;
use App\SiteSetting;
use App\Models\NewsLetterModel;


class homeController extends Controller
{
    private $NewsLetterModel;

    public function __construct(

        NewsLetterModel $NewsLetterModel
    )
    {
        $this->NewsLetterModel =  $NewsLetterModel;
    }
	public function index()
	{
		$this->ModuleTitle = 'Home';
        $this->ModuleView  = '';
        $this->ModulePath  = '';

        $arrSiteSetting = SiteSetting::find('1');

        $this->ViewData['page_title']    = $this->ModuleTitle;
    	$this->ViewData['moduleTitle']   = $this->ModuleTitle;
        $this->ViewData['moduleAction']  = $this->ModuleTitle;
        $this->ViewData['modulePath']    = $this->ModulePath;
        $this->ViewData['siteSetting']   = $arrSiteSetting;
        
		return view('welcome', $this->ViewData);
	}

    public function saveNewsLetter(Request $request)
    {
        if(!empty($request->input()))
        { 
            DB::beginTransaction();
            $NewsLetterModel = $this->NewsLetterModel;
            $NewsLetterModel->email_id = $request->email_id;
            $NewsLetterModel->status   = '1';

            if ($NewsLetterModel->save()) 
            {
                DB::commit();
                $strEmail = $request->email_id;
                $data['email']  = $request->email_id;
                $mail     = Mail::to($strEmail)->send(new NewsLetterMail($data));

                $this->JsonData['status']   = 'success';
                $this->JsonData['url']      = '/';
                $this->JsonData['msg']      = 'send mail successfully.';
            }
            else{
                 DB::rollBack();
                $this->JsonData['status']   ='error';
                $this->JsonData['msg']      ='Failed to save member, Something went wrong.';
            }
        }
        return response()->json($this->JsonData);
    }
    
}
