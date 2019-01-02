<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\CourseModel;
use App\Models\voucherModel;


class CertificationController extends Controller
{
	private $CourseModel;

    public function __construct(

        CourseModel $CourseModel,
        voucherModel $voucherModel
    )
    {
        $this->CourseModel   = $CourseModel;
        $this->voucherModel  = $voucherModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Certification Listing';
        $this->ModuleView  = 'front.certification.';
        $this->ModulePath  = 'CourseModel';
    }
    public function index()
    {
        $this->ViewData['page_title']           = 'Listings for Certifications';
    	$this->ViewData['moduleTitle']          = $this->ModuleTitle;
        $this->ViewData['moduleAction']         = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']           = $this->ModulePath;
        $this->ViewData['arrCerficationList']   = $this->CourseModel
                                                        ->where('status', '1')
                                                        ->whereHas('exam',function($exam)
                                                        {
                                                           $exam->where('is_test', 1);
                                                        }, '<', 1)
                                                        ->get();

        return view($this->ModuleView.'index', $this->ViewData);
    }
    
    public function detail($indId)
    {
        $this->ViewData['page_title']           = 'Detail page for Certification';
        $this->ViewData['moduleTitle']          = $this->ModuleTitle;
        $this->ViewData['moduleAction']         = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']           = $this->ModulePath;
        $this->ViewData['arrCerficationDetils'] = $this->CourseModel->find(base64_decode(base64_decode($indId)));
        
        return view($this->ModuleView.'detail', $this->ViewData);
    }

    public function applyVoucher(Request $request)
    {
        //dd($request->all());
        if($request->voucher_code != '' && $request->voucher_code != 'null')
        {
            $strVoucher = $request->voucher_code;
            $strUserRole = auth()->user()->getRoleNames();
            $arrData = $this->voucherModel->where('voucher_code', $strVoucher )
                                           ->where('user_type', $strUserRole['0'] )
                                          ->first();
            if(isset($arrData)  && $arrData != 'null')
            {
                $strUserUseCnt   = $arrData->voc_use_count;
                $strUserApplyCnt = $arrData->user_count;
                
                if($strUserApplyCnt >= $strUserUseCnt)
                {
                    $to = Carbon::now();
                    dd($to);
                }
                else
                {
                    $this->JsonData['status']   = 'error';
                    $this->JsonData['msg']      = __('messages.ERR_STR_EXP_VOUCHER_ERR_MSG');       
                }    
            }else
            {
                $this->JsonData['status']   = 'error';
                $this->JsonData['msg']      = __('messages.ERR_STR_INVALID_VOUCHER_ERR_MSG');       
            }
        }else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_STR_EMPTY_VOUCHER_ERR_MSG');
        }
        return response()->json($this->JsonData);
    }
}
