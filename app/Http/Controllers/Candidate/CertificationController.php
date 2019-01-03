<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\CourseModel;
use App\Models\voucherModel;
use App\Models\TransactionModel;


class CertificationController extends Controller
{
	private $CourseModel;

    public function __construct(

        CourseModel $CourseModel,
        voucherModel $voucherModel,
        TransactionModel $TransactionModel
    )
    {
        $this->CourseModel      = $CourseModel;
        $this->voucherModel     = $voucherModel;
        $this->TransactionModel = $TransactionModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Certification Listing';
        $this->ModuleView  = 'front.certification.';
        $this->ModulePath  = 'CourseModel';
    }
    public function index()
    {
        $intId = auth()->user()->id;
        $arrTemp = [];
        $arrTransData = $this->TransactionModel->where('user_id', $intId)->get(['course_id'])->toArray();
        
        if(!empty($arrTransData) && sizeof($arrTransData) > 0){
            $arrTemp = array_column($arrTransData, 'course_id');
        }

            $this->ViewData['page_title']           = 'Listings for Certifications';
        	$this->ViewData['moduleTitle']          = $this->ModuleTitle;
            $this->ViewData['moduleAction']         = str_plural($this->ModuleTitle);
            $this->ViewData['modulePath']           = $this->ModulePath;
            $this->ViewData['arrTransData']         = $arrTemp;
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

        $arrCourseData = $this->CourseModel->where('status','1')->find(base64_decode(base64_decode($indId)));

        if($arrCourseData != 'null' && isset($arrCourseData)){
            $this->ViewData['arrCerficationDetils'] = $arrCourseData;
            return view($this->ModuleView.'detail', $this->ViewData);
        }else{
            $this->ViewData['arrCerficationList']   = $this->CourseModel
                                                        ->where('status', '1')
                                                        ->whereHas('exam',function($exam)
                                                        {
                                                           $exam->where('is_test', 1);
                                                        }, '<', 1)
                                                        ->get();
            return view($this->ModuleView.'index', $this->ViewData);
        }
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
