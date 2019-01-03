<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\PaymentExecution;


use App\Models\CourseModel;
use App\Models\TransactionModel;
use App\Models\VoucherDiscountModel;

use DB;
use URL;
use Session;

class PaymentController extends Controller
{
	private $JsonData;
	private $PaypalConfig;
	private $ApiContext;

    public function __construct(
    
    	CourseModel $CourseModel,
    	TransactionModel $TransactionModel,
    	VoucherDiscountModel $VoucherDiscountModel
    )
    {
    	ini_set('max_execution_time', 0);

    	$this->BaseModel 			= $TransactionModel;
    	$this->CourseModel 			= $CourseModel;	
    	$this->VoucherDiscountModel = $VoucherDiscountModel;	

    	$this->JsonData = [];

        $this->PaypalConfig = \Config::get('paypal');
        $this->ApiContext = new ApiContext(new OAuthTokenCredential(
            	$this->PaypalConfig['client_id'],
            	$this->PaypalConfig['secret']        	
        	)
		);

        $this->ApiContext->setConfig($this->PaypalConfig['settings']);		
	}

	public function purchase(Request $request)
	{
		// formdata
		$user_id 	= base64_decode(base64_decode($request->pud));
		$course_id 	= base64_decode(base64_decode($request->pcd));

		$arrCourseData = $this->CourseModel->where('status','1')->find($course_id);
		if($arrCourseData != 'null' && isset($arrCourseData)){
			// manage data
			$course = $this->CourseModel->find($course_id);
			$course->user_id = $user_id;

			 //get voucher data with login user details
            $arrCheckVoc = $this->VoucherDiscountModel->where('user_id', $user_id)
                                                  ->where('is_use', '1')
                                                  ->where('course_id', $course_id)
                                                  ->first();
            
            if($arrCheckVoc != 'null' && isset($arrCheckVoc))
            {
            	$intDisPrice = $arrCheckVoc->discount_price;
            }
            else
            {
            	$intDisPrice = $course->calculated_amount;
            }

			//$intDisPrice
			$this->JsonData = self::_create($course, $intDisPrice);
		}
		else
		{
			$this->JsonData['status'] = 'error';	
			$this->JsonData['msg'] 	  = 'Something went wrong, Please try again later.';
		}

		return response()->json($this->JsonData);
	}

	public function response(Request $request)
	{
		$this->JsonData = self::_execute($request);

		if ($this->JsonData['status'] == '404' ) 
		{
			abort(404);
		}
		else
		{
			return view($this->JsonData['view']);
		}
	}

	public function cancel(Request $request)
	{
		
		return redirect('/certification-list');
	}

	/*------------------------------
	| Sub functions
	---------------------------------------------*/
	public function _create($course, $discountAount = FALSE)
	{
		/*------------------------------
		| 1> Set new Payer
		---------------------------------------------*/
			$payer = new Payer();
			$payer->setPaymentMethod("paypal");
		
		/*------------------------------
		| 2> (Optional) Create new Item object
		---------------------------------------------*/
			$item1 = new Item();
			$item1->setName($course->title)
			    	->setCurrency('USD')
			    	->setQuantity(1)
			    	->setSku($course->id)
			    	->setPrice($discountAount);
			$itemList = new ItemList();
			$itemList->setItems(array($item1));

			// dump($itemList);

		/*------------------------------
		| 3> Create Amount and Amount details (Optional) objects
		---------------------------------------------*/
			// $details = new Details();
			// $details->setTax($course->discount)
			//     	->setSubtotal($course->calculated_amount);

			// dump($details);
			
			$amount = new Amount();
			$amount->setCurrency("USD")
			    	->setTotal($discountAount);
			    	// ->setDetails($details);
		
		/*------------------------------
		| 4> Add Amount and Amount details object into ransaction object
		---------------------------------------------*/
			$transaction = new Transaction();
			$transaction->setAmount($amount)
			    		->setItemList($itemList)
			    		->setDescription("Purchasing new course")
			    		->setInvoiceNumber(uniqid());
		
		/*------------------------------
		| 5> Create redirect url
		---------------------------------------------*/
			$redirectUrls = new RedirectUrls();
			$redirectUrls->setReturnUrl(URL::to('purchase/response'))
			    		->setCancelUrl(URL::to('purchase/cancel'));
		
		/*------------------------------
		| 6> Create new payment object
		---------------------------------------------*/
			$payment = new Payment();
			$payment->setIntent("sale")
			    	->setPayer($payer)
			    	->setRedirectUrls($redirectUrls)
			    	->setTransactions(array($transaction));
		
		/*------------------------------
		| 7> Create new payment
		---------------------------------------------*/
			try {

			    $payment->create($this->ApiContext);

				/*------------------------------
				| 8> Get redirect url
				---------------------------------------------*/

				$approvalUrl = $payment->getApprovalLink();
				if (!empty($approvalUrl)) 
				{
					\Session::put('course', $course);
					\Session::put('course_payment', $payment);

					$this->JsonData['status'] = 'success';	
					$this->JsonData['url'] = $approvalUrl;
				}
				else
				{
					$this->JsonData['status'] = 'error';	
					$this->JsonData['url'] = 'Something went wrong, Please try again later.';
				}

			} 
			catch (Exception $ex) 
			{
			    $this->JsonData['status'] = 'error';	
				$this->JsonData['url'] = $ex->getMessage();
			}
		
		return $this->JsonData;
	}

	public function _execute($request)
	{
		DB::beginTransaction();

		$course_payment = \Session::get('course_payment');
		$course = \Session::get('course');

		$paymentId 	= $request->paymentId;
		$PayerID 	= $request->PayerID;

		
		if (!empty($course_payment->id) && $paymentId == $course_payment->id) 
		{
				
			$payment 	= Payment::get($paymentId, $this->ApiContext);

			$execution 	= new PaymentExecution();
			$execution->setPayerId($PayerID);
			
			$result = $payment->execute($execution, $this->ApiContext);

			if ($result->state == 'approved') 
			{
				$object = new $this->BaseModel;
				
				$object->transaction_id = $result->id;
				$object->course_id 		= $course->id;
				$object->user_id 		= $course->user_id;

				$object->state  		= $result->state;
				$object->intent 		= $result->intent;
				$object->cart 			= $result->cart;
				
				$object->payer_id 		= $PayerID;
				$object->payer_status   = $result->payer->status;
				
				$object->payment_method = $result->payer->payment_method;

				$object->invoice 		= $result->transactions[0]->invoice_number;
				$object->currency 		= $result->transactions[0]->amount->currency;
				$object->total_amount   = $result->transactions[0]->amount->total;
				$object->description    = $result->transactions[0]->description;

				$object->payment_response = json_encode((array)$result);
				if ($object->save()) 
				{
					// \Session::forget('course_payment');
					// \Session::forget('course');

					\Session::flush();

					DB::commit();
					$this->JsonData['status'] = 'success';
					$this->JsonData['view'] = 'front.payment.success';
				}
				else
				{
					DB::rollback();
					$this->JsonData['status'] = 'error';
					$this->JsonData['view'] = 'front.payment.failed';
				}
			}
			else
			{
				DB::rollback();
				$this->JsonData['status'] = 'error';
				$this->JsonData['view'] = 'front.payment.failed';
			}
		}
		else
		{
			DB::rollback();
			$this->JsonData['status'] = '404';
		}

		return $this->JsonData;
	}
}
