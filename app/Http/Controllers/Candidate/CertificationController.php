<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Carbon\Carbon;
use App\User;
use App\SiteSetting;
use App\Models\CourseModel;
use App\Models\voucherModel;
use App\Models\TransactionModel;
use App\Models\VoucherDiscountModel;
use App\Models\ExamResultModel;

use Browsershot;
use URL;

class CertificationController extends Controller
{
	private $CourseModel;

    public function __construct(

        CourseModel $CourseModel,
        voucherModel $voucherModel,
        TransactionModel $TransactionModel,
        VoucherDiscountModel $VoucherDiscountModel,
        ExamResultModel $ExamResultModel,
        User $UserModel,
        SiteSetting $SiteSettingModel
    )
    {
        $this->CourseModel          = $CourseModel;
        $this->voucherModel         = $voucherModel;
        $this->TransactionModel     = $TransactionModel;
        $this->VoucherDiscountModel = $VoucherDiscountModel;
        $this->ExamResultModel      = $ExamResultModel;
        $this->UserModel            = $UserModel;
        $this->SiteSettingModel     = $SiteSettingModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Certification Listing';
        $this->ModuleView  = 'front.certification.';
        $this->ModulePath  = 'CourseModel';
    }
    public function index()
    {
        if(isset(auth()->user()->id)){
           $intId = auth()->user()->id; 
        }else{
            $intId = '';
        }

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

        $this->ViewData['page_title']   = 'Detail page for Certification';
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']   = $this->ModulePath;

        if(isset(auth()->user()->id)){
           $intId = auth()->user()->id; 
        }else{
            $intId = '';
        }
        $arrCourseData = $this->CourseModel->where('status','1')->find(base64_decode(base64_decode($indId)));
        
        $intDisAmount = '';
        $arrDisVouData = $this->VoucherDiscountModel->where('is_use', '1')
                                                    ->where('user_id', $intId)
                                                    ->where('course_id', $arrCourseData->id)
                                                    ->where('course_price', $arrCourseData->calculated_amount)
                                                    ->first();
        if(!empty($arrDisVouData) && sizeof($arrDisVouData) > 0){
            $intDisAmount = $arrDisVouData->discount_price;
        }
        if($arrCourseData != 'null' && isset($arrCourseData)){
            $this->ViewData['arrCerficationDetils'] = $arrCourseData;
            $this->ViewData['intDisAmount']        = $intDisAmount;
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
        if($request->voucher_code != '' && $request->voucher_code != 'null')    //check empty
        {
            $strVoucher  = $request->voucher_code;
            
            //get voucher data with login user details
            $arrCheckVoc = $this->VoucherDiscountModel->where('user_id', base64_decode(base64_decode($request->user_id)))
                                                  ->where('is_use', '1')
                                                  ->where('course_id', $request->courses_id)
                                                  ->first();
            
            if($arrCheckVoc != 'null' && count($arrCheckVoc) != '0')      //check voucher use or not
            {
                $this->JsonData['status']   = 'error';
                $this->JsonData['msg']      = __('messages.ERR_STR_USE_VOUCHER_ERR_MSG');        
            }
            else
            {
                $strUserRole = auth()->user()->getRoleNames();
                
                //check user role
                $arrData = $this->voucherModel->where('voucher_code', $strVoucher )
                                              ->where('user_type', $strUserRole['0'] )
                                              ->first();

                if(isset($arrData)  && $arrData != 'null')  //check user role
                {
                    $strUserUseCnt   = $arrData->voc_use_count;
                    $strUserApplyCnt = $arrData->user_count;
                    
                    if($strUserApplyCnt >= $strUserUseCnt) // check voucher applicable user count
                    {
                        $now = Carbon::now();
                        $strNowDate = date("Y-m-d", strtotime($now));
                        if($strNowDate <= $arrData->end_date) // check voucher validate date
                        {
                            $strDiscount  = $arrData->discount;
                            $strDisType   = $arrData->discount_by;
                            $intCosPrice  = $request->course_price;
                            if($strDisType == 'Flat')
                            {
                                $strGrandTotal = $intCosPrice - $strDiscount;
                            }
                            else
                            {
                                $strTotalPrice = ($intCosPrice*$strDiscount)/100; 
                                $strGrandTotal = $intCosPrice - $strTotalPrice;
                            }
                            DB::beginTransaction();

                            $VoucherDiscountModel                   = new $this->VoucherDiscountModel;
                            $voucherModel                           = new $this->voucherModel;

                            $VoucherDiscountModel->user_id          = base64_decode(base64_decode($request->user_id));
                            $VoucherDiscountModel->course_id        = $request->courses_id;
                            $VoucherDiscountModel->voucher_id       = $arrData->id;
                            $VoucherDiscountModel->course_price     = $request->course_price;
                            $VoucherDiscountModel->discount_price   = $strGrandTotal;
                            $VoucherDiscountModel->is_use           = '1';
                            $VoucherDiscountModel->apply_date       = Carbon::now();

                            if($VoucherDiscountModel->save())           //save discount price
                            {
                                $strUseVocCnt = $arrData->voc_use_count + 1;
                                
                                // Update the use voucher count
                                $this->voucherModel->where('id', $arrData->id)->update(['voc_use_count' => $strUseVocCnt]);
                                DB::commit();
                                $this->JsonData['status']   = 'success';
                                $this->JsonData['msg']      = __('messages.ERR_STR_VOUCHER_SUCC_MSG');
                            }
                            else
                            {
                                DB::rollBack();
                                $this->JsonData['status']   = 'error';
                                $this->JsonData['msg']      = __('messages.ERR_STR_DB_VOUCHER_ERRO_MSG');
                            }
                        }
                        else
                        {
                            $this->JsonData['status']   = 'error';
                            $this->JsonData['msg']      = __('messages.ERR_STR_EXP_VOUCHER_ERR_MSG');
                        }
                    }
                    else
                    {
                        $this->JsonData['status']   = 'error';
                        $this->JsonData['msg']      = __('messages.ERR_STR_EXP_VOUCHER_ERR_MSG');       
                    }    
                }
                else
                {
                    $this->JsonData['status']   = 'error';
                    $this->JsonData['msg']      = __('messages.ERR_STR_INVALID_VOUCHER_ERR_MSG');       
                }
            }
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_STR_EMPTY_VOUCHER_ERR_MSG');
        }
        return response()->json($this->JsonData);
    }

    public function userCertificatesListing(Request $request)
    {
        $userId = auth()->user()->id;

        // find exam results that has completed

        $passExams = $this->ExamResultModel->where('user_id', $userId)
                                         ->where('exam_status', 'Pass')
                                         ->get();
        
        if ($passExams) 
        {
            // generate certificates

            foreach ($passExams as $passExamKey => $exam) 
            {
                $this->ViewData['object'][] =  self::createCertificate($exam);
            }
        }
    }

    public function createCertificate($exam)
    {
        $userName   = $this->UserModel->find($exam->user_id)->pluck('name')->first();
        $courseName = $this->CourseModel->find($exam->course_id)->pluck('title')->first();
        $siteName   = $this->SiteSettingModel->find('1')->pluck('site_title')->first();


        if ($userName != NULL && $courseName != NULL && $siteName != NULL) 
        {
            $strDate  = date('d-m-Y');
            $html = '
                <!doctype html>
                <html >
                    <head>
                        <title>
                            Certificate
                        </title>

                        <style type="text/css" media="all">

                            #top 
                            {
                                height: 100%;
                            }

                            #position_me 
                            {
                                left: 0;
                            }

                            .SlideBackGround
                            {
                                height:650px;
                                width:880px;
                                position:fixed;
                                margin:10px 10px 10px 10px;
                                background-color:white;
                                background-image:url({{asset("certificate/frame.png")}});
                                background-size:880px 650px;
                                background-repeat:no-repeat;
                                z-index: 2;
                            }

                            .MiddlePart
                            {
                                height:170px;
                                width:670px;
                                position:fixed;
                                left:125px;
                                top:80px;
                                background-image:url({{asset("certificate/middle_part.png")}});
                                background-size:670px 170px;
                                background-repeat:no-repeat;
                                z-index: 5;
                            }
                            
                            .Seal
                            {
                                height:90px;
                                width:90px;
                                position:fixed;
                                left:415px;
                                top:420px;
                                background-image:url({{asset("certificate/sigill.png")}});
                                background-size:90px 90px;
                                background-repeat:no-repeat;
                                z-index: 5;
                            }
                            
                            .Ribbon
                            {
                            
                                width:60px;
                                height:90px;
                                position:fixed;
                                left:435px;
                                top:520px;
                                background-image:url({{asset("certificate/band.png")}});
                                background-size:60px 90px;
                                background-repeat:no-repeat;
                                z-index: 5;
                            }
                            
                            .Signature
                            {
                                width:180px;
                                height:90px;
                                position:fixed;
                                left:582px;
                                top:517px;
                                background-image:url({{asset("certificate/signature.png")}});
                                background-size:180px 90px;
                                background-repeat:no-repeat;
                                z-index: 11;
                            }
                            
                            .DateLine
                            {
                                width:300px;
                                position:fixed;
                                left:112px;
                                top:570px;
                                z-index:11;
                            }
                            
                            .ExaminerLine
                            {
                                width:300px;
                                position:fixed;
                                left:500px;
                                top:570px;
                                z-index:11;
                            }
                            
                            .ExaminerText
                            {
                                width:270px;
                                position:fixed;
                                left:632px;
                                top:585px;
                                color:#8B7B67;
                                z-index:11;
                            }
                            
                            .DateText
                            {
                                width:270px;
                                position:fixed;
                                left:232px;
                                top:585px;
                                z-index:11;
                                color:#8B7B67;
                            }
                            
                            .ParagraphSmall
                            {
                                height:200px;
                                width:500px;
                                position:fixed;
                                left:200px;
                                top:350px;
                                font-size:13px;
                                text-align:center;
                                z-index:11;
                                color:#8B7B67;
                            }
                            
                            .ParagraphMedium
                            {
                                height:200px;
                                width:420px;
                                position:fixed;
                                left:240px;
                                top:260px;
                                font-size:14px;
                                text-align:center;
                                z-index:11;
                                color:#8B7B67;
                            }
                            
                            /*.HeadingLarge
                            {
                                height:200px;
                                width:600px;
                                position:fixed;
                                left:330px;
                                top:130px;
                                font-size:66px;
                                z-index:11;
                                color:#8B7B67;
                            }*/

                            .HeadingLarge {
                                height: 200px;
                                width: 600px;
                                position: fixed;
                                left: 170px;
                                top: 132px;
                                font-size: 57px;
                                z-index: 11;
                                color: #8B7B67;
                            }
                            
                            .MiddleLine
                            {
                                width:720px;
                                position:fixed;
                                left:100px;
                                top:330px;
                                z-index:11;
                                color:#8B7B67;
                            }
                            
                            .StudentName
                            {
                                font-weight:bold;
                                height:200px;
                                width:720px;
                                position:fixed;
                                left:100px;
                                top:310px;
                                font-size:18px;
                                text-align:center;
                                z-index:11;
                                color:#8B7B67;
                            }
                            
                            .CompletionDate
                            {
                                position:fixed;
                                left:225px;
                                top:555px;
                                z-index:11;
                                color:#8B7B67;
                                text-align:center;
                            } 
                        </style>
                    </head>
                    <body>

                        <div class="SlideBackGround">
                        </div>

                        <div class="MiddlePart">
                        </div>

                        <div class="HeadingLarge">Managed Service Council</div>

                        <div class="ParagraphMedium">
                            <p>
                                CERTIFICATE OF COMPLETION. AWARDED TO,
                            </p>
                        </div>
                        
                        <div class="ParagraphSmall">
                            For successfully completing the on-line course
                            "'.strtoupper($siteName).'"
                        </div>

                        <div class="Seal"></div>

                        <div class="Ribbon"></div>

                        <hr class="DateLine" />

                        <hr class="ExaminerLine" />

                        <hr class="MiddleLine" />

                        <div class="DateText">Date</div>

                        <div class="ExaminerText">Examiner</div>

                        <div class="Signature"></div>

                        <div id="CompletionDatePanel" class="CompletionDate">
                        
                        <span id="CompletionDateLabel">'.$strDate.'</span>

                        </div>

                        <div id="StudentNamePanel" class="StudentName">
                        
                        <span id="StudentNameLabel">{{"Sheshkumar Prajapati"}}</span>

                        </div>
                    </body>
                </html>
            ';

            $fileWithPath = 'certifications/'.str_replace(' ', '-', $userName).'-'.str_replace(' ', '-', $courseName).'.jpg';

            dd(Browsershot::html($html)->save($fileWithPath));
        }

    }
}
