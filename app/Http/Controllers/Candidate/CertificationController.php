<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Carbon\Carbon;
use App\Models\CourseModel;
use App\Models\voucherModel;
use App\Models\TransactionModel;
use App\Models\VoucherDiscountModel;


class CertificationController extends Controller
{
	private $CourseModel;

    public function __construct(

        CourseModel $CourseModel,
        voucherModel $voucherModel,
        TransactionModel $TransactionModel,
        VoucherDiscountModel $VoucherDiscountModel
    )
    {
        $this->CourseModel          = $CourseModel;
        $this->voucherModel         = $voucherModel;
        $this->TransactionModel     = $TransactionModel;
        $this->VoucherDiscountModel = $VoucherDiscountModel;

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
                            dd('dsa');
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
}
