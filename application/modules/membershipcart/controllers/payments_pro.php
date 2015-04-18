<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * This controller for post paypal payment & refund amount 
 * 
 * @Description: This controller is used to manage paypal payment and refund 
 * amount for container and membership 
 * @modified by: Lokendra & Tosif 
 * 
 */ 

class Payments_pro extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();

		//-----------Load helpers-----------//
		$this->load->helper('url');
		
		//-----------Load language---------//
		$this->load->language('package');
		
		//----------Load PayPal library---------//
		$this->config->load('paypal_pro');
		
		$config = array(
				'Sandbox' 		=>	$this->config->item('Sandbox'), 		// Sandbox / testing mode option.
				'APIUsername' 	=>	$this->config->item('APIUsername'), 	// PayPal API username of the API caller
				'APIPassword' 	=>	$this->config->item('APIPassword'), 	// PayPal API password of the API caller
				'APISignature' 	=>	$this->config->item('APISignature'), 	// PayPal API signature of the API caller
				'APISubject' 	=>	'', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
				'APIVersion' 	=>	$this->config->item('APIVersion')		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
		);
		
		// Show Errors if sanbox mode on
		if($config['Sandbox'])
		{
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
		}
		
		//-----------load payment pro library-----------//
		$this->load->library('paypal/Paypal_pro', $config);	
	}
	
	
	function index()
	{
		$this->load->view('payments_pro_demo');
	}
	
	
	function Do_capture()
	{
		$DCFields = array(
						'authorizationid' => '', 				// Required. The authorization identification number of the payment you want to capture. This is the transaction ID returned from DoExpressCheckoutPayment or DoDirectPayment.
						'amt' => '', 							// Required. Must have two decimal places.  Decimal separator must be a period (.) and optional thousands separator must be a comma (,)
						'completetype' => '', 					// Required.  The value Complete indiciates that this is the last capture you intend to make.  The value NotComplete indicates that you intend to make additional captures.
						'currencycode' => '', 					// Three-character currency code
						'invnum' => '', 						// Your invoice number
						'note' => '', 							// Informational note about this setlement that is displayed to the buyer in an email and in his transaction history.  255 character max.
						'softdescriptor' => '', 				// Per transaction description of the payment that is passed to the customer's credit card statement.
						'storeid' => '', 						// ID of the merchant store.  This field is required for point-of-sale transactions.  Max: 50 char
						'terminalid' => ''						// ID of the terminal.  50 char max.  
					);
					
		$PayPalRequestData = array('DCFields' => $DCFields);
		$PayPalResult = $this->paypal_pro->DoCapture($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Do_authorization()
	{
		$DAFields = array(
							'transactionid' => '', 					// Required.  The value of the order's transaction ID number returned by PayPal.  
							'amt' => '', 							// Required. Must have two decimal places.  Decimal separator must be a period (.) and optional thousands separator must be a comma (,)
							'transactionentity' => '', 				// Type of transaction to authorize.  The only allowable value is Order, which means that the transaction represents a customer order that can be fulfilled over 29 days.
							'currencycode' => '', 					// Three-character currency code.
						);
						
		$PayPalRequestData = array('DAFields' => $DAFields);
		$PayPalResult = $this->paypal_pro->DoAuthorization($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Do_reauthorization()
	{
		$DRFields = array(
						'authorizationid' => '', 				// Required. The value of a previously authorized transaction ID returned by PayPal.
						'amt' => '', 							// Required. Must have two decimal places.  Decimal separator must be a period (.) and optional thousands separator must be a comma (,)
						'currencycode' => ''					// Three-character currency code.
					);	
					
		$PayPalRequestData = array('DRFields' => $DRFields);
		$PayPalResult = $this->paypal_pro->DoReauthorization($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Do_void()
	{
		$DVFields = array(
						'authorizationid' => '', 				// Required.  The value of the original authorization ID returned by PayPal.  NOTE:  If voiding a transaction that has been reauthorized, use the ID from the original authorization, not the reauth.
						'note' => '' 							// An information note about this void that is displayed to the payer in an email and in his transaction history.  255 char max.
					);	
					
		$PayPalRequestData = array('DVFields' => $DVFields);
		$PayPalResult = $this->paypal_pro->DoVoid($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Mass_pay()
	{
		$MPFields = array(
							'emailsubject' => '', 						// The subject line of the email that PayPal sends when the transaction is completed.  Same for all recipients.  255 char max.
							'currencycode' => '', 						// Three-letter currency code.
							'receivertype' => '' 						// Indicates how you identify the recipients of payments in this call to MassPay.  Must be EmailAddress or UserID
						);
		
		// MassPay accepts multiple payments in a single call.  
		// Therefore, we must create an array of payments to pass into the class.
		// In this sample we're simply passing in 2 separate payments with static amounts.
		// In most cases you'll be looping through records in a data source to generate the $MPItems array below.
		
		$Item1 = array(
					'l_email' => '', 							// Required.  Email address of recipient.  You must specify either L_EMAIL or L_RECEIVERID but you must not mix the two.
					'l_receiverid' => '', 						// Required.  ReceiverID of recipient.  Must specify this or email address, but not both.
					'l_amt' => '', 								// Required.  Payment amount.
					'l_uniqueid' => '', 						// Transaction-specific ID number for tracking in an accounting system.
					'l_note' => '' 								// Custom note for each recipient.
				);
				
		$Item2 = array(
					'l_email' => '', 							// Required.  Email address of recipient.  You must specify either L_EMAIL or L_RECEIVERID but you must not mix the two.
					'l_receiverid' => '', 						// Required.  ReceiverID of recipient.  Must specify this or email address, but not both.
					'l_amt' => '', 								// Required.  Payment amount.
					'l_uniqueid' => '', 						// Transaction-specific ID number for tracking in an accounting system.
					'l_note' => '' 								// Custom note for each recipient.
				);
									
		$MPItems = array($Item1, $Item2);
		
		$PayPalRequestData = array(
						'MPFields' => $MPFields, 
						'MPItems' => $MPItems
					);
					
		$PayPalResult = $this->paypal_pro->MassPay($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	
	}
	
	
	
	function Refund_transaction()
	{ 
			
		$transactionid = $this->input->post('transactionid');
		$refundtype =$this->input->post('refundtype');
		$currencycode = $this->input->post('currencycode');
		$amt = $this->input->post('amt'); 
		$containerId = $this->input->post('containerId'); 
		$requestOrderId = $this->input->post('currentOrderId'); 
		$sectionName = $this->input->post('sectionName'); 		
		
		$RTFields = array(
					'transactionid' => $transactionid, 							// Required.  PayPal transaction ID for the order you're refunding.
					'invoiceid' => '', 								// Your own invoice tracking number.
					'refundtype' => 'Partial', 							// Required.  Type of refund.  Must be Full, Partial, or Other.
					'amt' => $amt, 									// Refund Amt.  Required if refund type is Partial.  
					'currencycode' => $this->config->item('toadCurrency'), 							// Three-letter currency code.  Required for Partial Refunds.  Do not use for full refunds.
					'note' => $sectionName,  						// Custom memo about the refund.  255 char max.
					'retryuntil' => '', 							// Maximum time until you must retry the refund.  Note:  this field does not apply to point-of-sale transactions.
					'refundsource' => '', 							// Type of PayPal funding source (balance or eCheck) that can be used for auto refund.  Values are:  any, default, instant, eCheck
					'merchantstoredetail' => '', 					// Information about the merchant store.
					'refundadvice' => '', 							// Flag to indicate that the buyer was already given store credit for a given transaction.  Values are:  1/0
					'refunditemdetails' => '', 						// Details about the individual items to be returned.
					'storeid' => '', 								// ID of a merchant store.  This field is required for point-of-sale transactions.  50 char max.
					'terminalid' => ''								// ID of the terminal.  50 char max.
				);	
					
		$PayPalRequestData = array('RTFields' => $RTFields);
	
		$PayPalResult = $this->paypal_pro->RefundTransaction($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			echo "0";
			//$errors = array('Errors'=>$PayPalResult['ERRORS']);
			//$this->load->view('paypal_error',$errors);
		}
		else
		{
			
			$paypalJasonInfo = json_encode($PayPalResult);
			
			$userId=isloginUser(); 
			$refundTransactionId = $PayPalResult['REFUNDTRANSACTIONID'];
			$insert['refundTransactionId'] = $refundTransactionId;
			$insert['feeRefundAmt'] = $PayPalResult['FEEREFUNDAMT'];			
			$insert['date'] = $PayPalResult['TIMESTAMP'];		
			$insert['userContainerId'] = $containerId;		
			$insert['orderId'] = $requestOrderId;
			$insert['refundedAmount'] = $amt;
			$insert['userId']         = $userId;
			
			$data['refundTransactionId'] = $refundTransactionId;
			$data['orderId'] = $requestOrderId;
			$data['userContainerId'] = $containerId;			
			$data['amt'] = $amt;
			$data['paypalJasonInfo'] = $paypalJasonInfo;
						
				
				$latestOrderId = Modules::run("membershipcart/saveRefundOrder",$data);		    
				
				 $this->insertSalesOrderInvoice($refundTransactionId);
				// $this->insertRefundDetails($insert);
				 $this->updateRefundedItem($containerId,$requestOrderId); 	
				 
				//this module call for sending refund invoice on email and tamil
                Modules::run("membershipcart/membershipInvoiceEmail",$latestOrderId);	   
				
				echo "1";
			// Successful call.  Load view or whatever you need to do here.	
		}
		
		
	}
	
	//-----------------------------------------------------------------------
	/*
	 * @Description: This method is use to refund membership amount
	 * @return true
	 * @auther: @lokendra
	 */ 
	
	public function refundmembership($refundData='')
	{ 
		
		$transactionId    =  $refundData['transactionid'];
		$totalPrice       =  $refundData['totalPrice'];
		$sectionName      =  $refundData['sectionName'];
		$requestOrderId   =  $refundData['orderId'];
	
		$RTFields = array(
			'transactionid'   =>  $transactionId,   // Required.  PayPal transaction ID for the order you're refunding.
			'invoiceid'       =>  '',               // Your own invoice tracking number.
			'refundtype'      =>  'Partial',        // Required.  Type of refund.  Must be Full, Partial, or Other.
			'amt'             =>  $totalPrice,      // Refund Amt.  Required if refund type is Partial.  
			'currencycode'    =>  $this->config->item('toadCurrency'),            // Three-letter currency code.  Required for Partial Refunds.  Do not use for full refunds.
			'note'            =>  $sectionName,     // Custom memo about the refund.  255 char max.
			'retryuntil'      =>  '',               // Maximum time until you must retry the refund.  Note:  this field does not apply to point-of-sale transactions.
			'refundsource'    =>  '',               // Type of PayPal funding source (balance or eCheck) that can be used for auto refund.  Values are:  any, default, instant, eCheck
			'merchantstoredetail' =>  '',           // Information about the merchant store.
			'refundadvice'        =>  '',           // Flag to indicate that the buyer was already given store credit for a given transaction.  Values are:  1/0
			'refunditemdetails'   =>  '',           // Details about the individual items to be returned.
			'storeid'             =>  '',           // ID of a merchant store.  This field is required for point-of-sale transactions.  50 char max.
			'terminalid'          =>  ''            // ID of the terminal.  50 char max.
		);	
					
		$PayPalRequestData = array('RTFields' => $RTFields);
        
        $PayPalResult = $this->paypal_pro->RefundTransaction($PayPalRequestData);

		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			return false;
		}
		else
		{
			// get paypal info
			$paypalJasonInfo                     =  json_encode($PayPalResult);
			
			// get logged in user id
			$userId                              =  $this->isloginUser(); 
		
			$refundTransactionId                 =  $PayPalResult['REFUNDTRANSACTIONID'];
			$dataSave['refundTransactionId']     =  $refundTransactionId;
			$dataSave['orderId']                 =  $requestOrderId;
			$dataSave['amt']                     =  $totalPrice;
			$dataSave['paypalJasonInfo']         =  $paypalJasonInfo;
			
			//refund membership order data
			$latestOrderId = Modules::run("membershipcart/saverefundmemberhsip",$dataSave);		    

			$this->insertSalesOrderInvoice($refundTransactionId);
			
			// $this->insertRefundDetails($insert);
			//$this->updateRefundedItem($containerId,$requestOrderId); 	
			
			//this module call for sending refund invoice on email and tamil
			Modules::run("membershipcart/membershipInvoiceEmail",$latestOrderId);
            
            return true;	   
		}
	}
	
	
	function Get_transaction_details($transId='')
	{
		
		$GTDFields = array(
							'transactionid' => $transId		// PayPal transaction ID of the order you want to get details for.
						);
						
		$PayPalRequestData = array('GTDFields' => $GTDFields);
		
		$PayPalResult = $this->paypal_pro->GetTransactionDetails($PayPalRequestData);
		
		//echo "<pre/>";
		//print_r($PayPalResult);die;
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{    return $PayPalResult;
			//$errors = array('Errors'=>$PayPalResult['ERRORS']);
			//$this->load->view('paypal_error',$errors);
		}
		else
		{   return $PayPalResult;
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	function Do_direct_payment()
	{
		$DPFields = array(
							'paymentaction' => '', 						// How you want to obtain payment.  Authorization indidicates the payment is a basic auth subject to settlement with Auth & Capture.  Sale indicates that this is a final sale for which you are requesting payment.  Default is Sale.
							'ipaddress' => '', 							// Required.  IP address of the payer's browser.
							'returnfmfdetails' => '' 					// Flag to determine whether you want the results returned by FMF.  1 or 0.  Default is 0.
						);
						
		$CCDetails = array(
							'creditcardtype' => '', 					// Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
							'acct' => '', 								// Required.  Credit card number.  No spaces or punctuation.  
							'expdate' => '', 							// Required.  Credit card expiration date.  Format is MMYYYY
							'cvv2' => '', 								// Requirements determined by your PayPal account settings.  Security digits for credit card.
							'startdate' => '', 							// Month and year that Maestro or Solo card was issued.  MMYYYY
							'issuenumber' => ''							// Issue number of Maestro or Solo card.  Two numeric digits max.
						);
						
		$PayerInfo = array(
							'email' => '', 								// Email address of payer.
							'payerid' => '', 							// Unique PayPal customer ID for payer.
							'payerstatus' => '', 						// Status of payer.  Values are verified or unverified
							'business' => '' 							// Payer's business name.
						);
						
		$PayerName = array(
							'salutation' => '', 						// Payer's salutation.  20 char max.
							'firstname' => '', 							// Payer's first name.  25 char max.
							'middlename' => '', 						// Payer's middle name.  25 char max.
							'lastname' => '', 							// Payer's last name.  25 char max.
							'suffix' => ''								// Payer's suffix.  12 char max.
						);
						
		$BillingAddress = array(
								'street' => '', 						// Required.  First street address.
								'street2' => '', 						// Second street address.
								'city' => '', 							// Required.  Name of City.
								'state' => '', 							// Required. Name of State or Province.
								'countrycode' => '', 					// Required.  Country code.
								'zip' => '', 							// Required.  Postal code of payer.
								'phonenum' => '' 						// Phone Number of payer.  20 char max.
							);
							
		$ShippingAddress = array(
								'shiptoname' => '', 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
								'shiptostreet' => '', 					// Required if shipping is included.  First street address.  100 char max.
								'shiptostreet2' => '', 					// Second street address.  100 char max.
								'shiptocity' => '', 					// Required if shipping is included.  Name of city.  40 char max.
								'shiptostate' => '', 					// Required if shipping is included.  Name of state or province.  40 char max.
								'shiptozip' => '', 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
								'shiptocountry' => '', 					// Required if shipping is included.  Country code of shipping address.  2 char max.
								'shiptophonenum' => ''					// Phone number for shipping address.  20 char max.
								);
							
		$PaymentDetails = array(
								'amt' => '', 							// Required.  Total amount of order, including shipping, handling, and tax.  
								'currencycode' => '', 					// Required.  Three-letter currency code.  Default is USD.
								'itemamt' => '', 						// Required if you include itemized cart details. (L_AMTn, etc.)  Subtotal of items not including S&H, or tax.
								'shippingamt' => '', 					// Total shipping costs for the order.  If you specify shippingamt, you must also specify itemamt.
								'insuranceamt' => '', 					// Total shipping insurance costs for this order.  
								'shipdiscamt' => '', 					// Shipping discount for the order, specified as a negative number.
								'handlingamt' => '', 					// Total handling costs for the order.  If you specify handlingamt, you must also specify itemamt.
								'taxamt' => '', 						// Required if you specify itemized cart tax details. Sum of tax for all items on the order.  Total sales tax. 
								'desc' => '', 							// Description of the order the customer is purchasing.  127 char max.
								'custom' => '', 						// Free-form field for your own use.  256 char max.
								'invnum' => '', 						// Your own invoice or tracking number
								'buttonsource' => '', 					// An ID code for use by 3rd party apps to identify transactions.
								'notifyurl' => '', 						// URL for receiving Instant Payment Notifications.  This overrides what your profile is set to use.
								'recurring' => ''						// Flag to indicate a recurring transaction.  Value should be Y for recurring, or anything other than Y if it's not recurring.  To pass Y here, you must have an established billing agreement with the buyer.
							);
		
		// For order items you populate a nested array with multiple $Item arrays.  
		// Normally you'll be looping through cart items to populate the $Item array
		// Then push it into the $OrderItems array at the end of each loop for an entire 
		// collection of all items in $OrderItems.
				
		$OrderItems = array();
			
		$Item	 = array(
							'l_name' => '', 						// Item Name.  127 char max.
							'l_desc' => '', 						// Item description.  127 char max.
							'l_amt' => '', 							// Cost of individual item.
							'l_number' => '', 						// Item Number.  127 char max.
							'l_qty' => '', 							// Item quantity.  Must be any positive integer.  
							'l_taxamt' => '', 						// Item's sales tax amount.
							'l_ebayitemnumber' => '', 				// eBay auction number of item.
							'l_ebayitemauctiontxnid' => '', 		// eBay transaction ID of purchased item.
							'l_ebayitemorderid' => '' 				// eBay order ID for the item.
					);
		
		array_push($OrderItems, $Item);
		
		$Secure3D = array(
							'authstatus3d' => '', 
							'mpivendor3ds' => '', 
							'cavv' => '', 
							'eci3ds' => '', 
							'xid' => ''
							);
							
		$PayPalRequestData = array(
								'DPFields' => $DPFields, 
								'CCDetails' => $CCDetails, 
								'PayerInfo' => $PayerInfo, 
								'PayerName' => $PayerName, 
								'BillingAddress' => $BillingAddress, 
								'ShippingAddress' => $ShippingAddress, 
								'PaymentDetails' => $PaymentDetails, 
								'OrderItems' => $OrderItems, 
								'Secure3D' => $Secure3D
							);
							
		$PayPalResult = $this->paypal_pro->DoDirectPayment($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Do_direct_payment_demo()
	{
		$DPFields = array(
							'paymentaction' => 'Sale', 						// How you want to obtain payment.  Authorization indidicates the payment is a basic auth subject to settlement with Auth & Capture.  Sale indicates that this is a final sale for which you are requesting payment.  Default is Sale.
							'ipaddress' => $_SERVER['REMOTE_ADDR'], 							// Required.  IP address of the payer's browser.
							'returnfmfdetails' => '1' 					// Flag to determine whether you want the results returned by FMF.  1 or 0.  Default is 0.
						);
						
		$CCDetails = array(
							'creditcardtype' => 'MasterCard', 					// Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
							'acct' => '5424180818927383', 								// Required.  Credit card number.  No spaces or punctuation.  
							'expdate' => '102012', 							// Required.  Credit card expiration date.  Format is MMYYYY
							'cvv2' => '123', 								// Requirements determined by your PayPal account settings.  Security digits for credit card.
							'startdate' => '', 							// Month and year that Maestro or Solo card was issued.  MMYYYY
							'issuenumber' => ''							// Issue number of Maestro or Solo card.  Two numeric digits max.
						);
						
		$PayerInfo = array(
							'email' => 'test@domain.com', 								// Email address of payer.
							'payerid' => '', 							// Unique PayPal customer ID for payer.
							'payerstatus' => '', 						// Status of payer.  Values are verified or unverified
							'business' => 'Testers, LLC' 							// Payer's business name.
						);
						
		$PayerName = array(
							'salutation' => 'Mr.', 						// Payer's salutation.  20 char max.
							'firstname' => 'Tester', 							// Payer's first name.  25 char max.
							'middlename' => '', 						// Payer's middle name.  25 char max.
							'lastname' => 'Testerson', 							// Payer's last name.  25 char max.
							'suffix' => ''								// Payer's suffix.  12 char max.
						);
						
		$BillingAddress = array(
								'street' => '123 Test Ave.', 						// Required.  First street address.
								'street2' => '', 						// Second street address.
								'city' => 'Kansas City', 							// Required.  Name of City.
								'state' => 'MO', 							// Required. Name of State or Province.
								'countrycode' => 'US', 					// Required.  Country code.
								'zip' => '64111', 							// Required.  Postal code of payer.
								'phonenum' => '555-555-5555' 						// Phone Number of payer.  20 char max.
							);
							
		$ShippingAddress = array(
								'shiptoname' => 'Tester Testerson', 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
								'shiptostreet' => '123 Test Ave.', 					// Required if shipping is included.  First street address.  100 char max.
								'shiptostreet2' => '', 					// Second street address.  100 char max.
								'shiptocity' => 'Kansas City', 					// Required if shipping is included.  Name of city.  40 char max.
								'shiptostate' => 'MO', 					// Required if shipping is included.  Name of state or province.  40 char max.
								'shiptozip' => '64111', 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
								'shiptocountry' => 'US', 					// Required if shipping is included.  Country code of shipping address.  2 char max.
								'shiptophonenum' => '555-555-5555'					// Phone number for shipping address.  20 char max.
								);
							
		$PaymentDetails = array(
								'amt' => '100.00', 							// Required.  Total amount of order, including shipping, handling, and tax.  
								'currencycode' => $this->config->item('toadCurrency'), 					// Required.  Three-letter currency code.  Default is USD.
								'itemamt' => '95.00', 						// Required if you include itemized cart details. (L_AMTn, etc.)  Subtotal of items not including S&H, or tax.
								'shippingamt' => '5.00', 					// Total shipping costs for the order.  If you specify shippingamt, you must also specify itemamt.
								'shipdiscamt' => '', 					// Shipping discount for the order, specified as a negative number.  
								'handlingamt' => '', 					// Total handling costs for the order.  If you specify handlingamt, you must also specify itemamt.
								'taxamt' => '', 						// Required if you specify itemized cart tax details. Sum of tax for all items on the order.  Total sales tax. 
								'desc' => 'Web Order', 							// Description of the order the customer is purchasing.  127 char max.
								'custom' => '', 						// Free-form field for your own use.  256 char max.
								'invnum' => '', 						// Your own invoice or tracking number
								'notifyurl' => ''						// URL for receiving Instant Payment Notifications.  This overrides what your profile is set to use.
							);	
				
		$OrderItems = array();
		$Item	 = array(
							'l_name' => 'Test Widget 123', 						// Item Name.  127 char max.
							'l_desc' => 'The best test widget on the planet!', 						// Item description.  127 char max.
							'l_amt' => '95.00', 							// Cost of individual item.
							'l_number' => '123', 						// Item Number.  127 char max.
							'l_qty' => '1', 							// Item quantity.  Must be any positive integer.  
							'l_taxamt' => '', 						// Item's sales tax amount.
							'l_ebayitemnumber' => '', 				// eBay auction number of item.
							'l_ebayitemauctiontxnid' => '', 		// eBay transaction ID of purchased item.
							'l_ebayitemorderid' => '' 				// eBay order ID for the item.
					);
		array_push($OrderItems, $Item);
		
		$Secure3D = array(
							'authstatus3d' => '', 
							'mpivendor3ds' => '', 
							'cavv' => '', 
							'eci3ds' => '', 
							'xid' => ''
							);
							
		$PayPalRequestData = array(
								'DPFields' => $DPFields, 
								'CCDetails' => $CCDetails, 
								'PayerInfo' => $PayerInfo, 
								'PayerName' => $PayerName, 
								'BillingAddress' => $BillingAddress, 
								'ShippingAddress' => $ShippingAddress, 
								'PaymentDetails' => $PaymentDetails, 
								'OrderItems' => $OrderItems, 
								'Secure3D' => $Secure3D
							);
							
		$PayPalResult = $this->paypal_pro->DoDirectPayment($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.
			$data = array('PayPalResult'=>$PayPalResult);
			$this->load->view('do_direct_payment_demo',$data);
		}
	}
	
	
	function Set_express_checkout()
	{
		$SECFields = array(
							'token' => '', 								// A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
							'maxamt' => '', 						// The expected maximum total amount the order will be, including S&H and sales tax.
							'returnurl' => '', 							// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
							'cancelurl' => '', 							// Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
							'callback' => '', 							// URL to which the callback request from PayPal is sent.  Must start with https:// for production.
							'callbacktimeout' => '', 					// An override for you to request more or less time to be able to process the callback request and response.  Acceptable range for override is 1-6 seconds.  If you specify greater than 6 PayPal will use default value of 3 seconds.
							'callbackversion' => '', 					// The version of the Instant Update API you're using.  The default is the current version.							
							'reqconfirmshipping' => '', 				// The value 1 indicates that you require that the customer's shipping address is Confirmed with PayPal.  This overrides anything in the account profile.  Possible values are 1 or 0.
							'noshipping' => '', 						// The value 1 indiciates that on the PayPal pages, no shipping address fields should be displayed.  Maybe 1 or 0.
							'allownote' => '', 							// The value 1 indiciates that the customer may enter a note to the merchant on the PayPal page during checkout.  The note is returned in the GetExpresscheckoutDetails response and the DoExpressCheckoutPayment response.  Must be 1 or 0.
							'addroverride' => '', 						// The value 1 indiciates that the PayPal pages should display the shipping address set by you in the SetExpressCheckout request, not the shipping address on file with PayPal.  This does not allow the customer to edit the address here.  Must be 1 or 0.
							'localecode' => '', 						// Locale of pages displayed by PayPal during checkout.  Should be a 2 character country code.  You can retrive the country code by passing the country name into the class' GetCountryCode() function.
							'pagestyle' => '', 							// Sets the Custom Payment Page Style for payment pages associated with this button/link.  
							'hdrimg' => '', 							// URL for the image displayed as the header during checkout.  Max size of 750x90.  Should be stored on an https:// server or you'll get a warning message in the browser.
							'hdrbordercolor' => '', 					// Sets the border color around the header of the payment page.  The border is a 2-pixel permiter around the header space.  Default is black.  
							'hdrbackcolor' => '', 						// Sets the background color for the header of the payment page.  Default is white.  
							'payflowcolor' => '', 						// Sets the background color for the payment page.  Default is white.
							'skipdetails' => '', 						// This is a custom field not included in the PayPal documentation.  It's used to specify whether you want to skip the GetExpressCheckoutDetails part of checkout or not.  See PayPal docs for more info.
							'email' => '', 								// Email address of the buyer as entered during checkout.  PayPal uses this value to pre-fill the PayPal sign-in page.  127 char max.
							'solutiontype' => '', 						// Type of checkout flow.  Must be Sole (express checkout for auctions) or Mark (normal express checkout)
							'landingpage' => '', 						// Type of PayPal page to display.  Can be Billing or Login.  If billing it shows a full credit card form.  If Login it just shows the login screen.
							'channeltype' => '', 						// Type of channel.  Must be Merchant (non-auction seller) or eBayItem (eBay auction)
							'giropaysuccessurl' => '', 					// The URL on the merchant site to redirect to after a successful giropay payment.  Only use this field if you are using giropay or bank transfer payment methods in Germany.
							'giropaycancelurl' => '', 					// The URL on the merchant site to redirect to after a canceled giropay payment.  Only use this field if you are using giropay or bank transfer methods in Germany.
							'banktxnpendingurl' => '',  				// The URL on the merchant site to transfer to after a bank transfter payment.  Use this field only if you are using giropay or bank transfer methods in Germany.
							'brandname' => '', 							// A label that overrides the business name in the PayPal account on the PayPal hosted checkout pages.  127 char max.
							'customerservicenumber' => '', 				// Merchant Customer Service number displayed on the PayPal Review page. 16 char max.
							'giftmessageenable' => '', 					// Enable gift message widget on the PayPal Review page. Allowable values are 0 and 1
							'giftreceiptenable' => '', 					// Enable gift receipt widget on the PayPal Review page. Allowable values are 0 and 1
							'giftwrapenable' => '', 					// Enable gift wrap widget on the PayPal Review page.  Allowable values are 0 and 1.
							'giftwrapname' => '', 						// Label for the gift wrap option such as "Box with ribbon".  25 char max.
							'giftwrapamount' => '', 					// Amount charged for gift-wrap service.
							'buyeremailoptionenable' => '', 			// Enable buyer email opt-in on the PayPal Review page. Allowable values are 0 and 1
							'surveyquestion' => '', 					// Text for the survey question on the PayPal Review page. If the survey question is present, at least 2 survey answer options need to be present.  50 char max.
							'surveyenable' => '', 						// Enable survey functionality. Allowable values are 0 and 1
							'totaltype' => '', 							// Enables display of "estimated total" instead of "total" in the cart review area.  Values are:  Total, EstimatedTotal
							'notetobuyer' => '', 						// Displays a note to buyers in the cart review area below the total amount.  Use the note to tell buyers about items in the cart, such as your return policy or that the total excludes shipping and handling.  127 char max.							
							'buyerid' => '', 							// The unique identifier provided by eBay for this buyer. The value may or may not be the same as the username. In the case of eBay, it is different. 255 char max.
							'buyerusername' => '', 						// The user name of the user at the marketplaces site.
							'buyerregistrationdate' => '',  			// Date when the user registered with the marketplace.
							'allowpushfunding' => ''					// Whether the merchant can accept push funding.  0 = Merchant can accept push funding : 1 = Merchant cannot accept push funding.			
						);
		
		// Basic array of survey choices.  Nothing but the values should go in here.  
		$SurveyChoices = array('Choice 1', 'Choice2', 'Choice3', 'etc');
		
		// You can now utlize parallel payments (split payments) within Express Checkout.
		// Here we'll gather all the payment data for each payment included in this checkout 
		// and pass them into a $Payments array.  
		
		// Keep in mind that each payment will ahve its own set of OrderItems
		// so don't get confused along the way.
		$Payments = array();
		$Payment = array(
						'amt' => '', 							// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
						'currencycode' => '', 					// A three-character currency code.  Default is USD.
						'itemamt' => '', 						// Required if you specify itemized L_AMT fields. Sum of cost of all items in this order.  
						'shippingamt' => '', 					// Total shipping costs for this order.  If you specify SHIPPINGAMT you mut also specify a value for ITEMAMT.
						'shipdiscamt' => '', 				// Shipping discount for this order, specified as a negative number.
						'insuranceoptionoffered' => '', 		// If true, the insurance drop-down on the PayPal review page displays the string 'Yes' and the insurance amount.  If true, the total shipping insurance for this order must be a positive number.
						'handlingamt' => '', 					// Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
						'taxamt' => '', 						// Required if you specify itemized L_TAXAMT fields.  Sum of all tax items in this order. 
						'desc' => '', 							// Description of items on the order.  127 char max.
						'custom' => '', 						// Free-form field for your own use.  256 char max.
						'invnum' => '', 						// Your own invoice or tracking number.  127 char max.
						'notifyurl' => '', 						// URL for receiving Instant Payment Notifications
						'shiptoname' => '', 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
						'shiptostreet' => '', 					// Required if shipping is included.  First street address.  100 char max.
						'shiptostreet2' => '', 					// Second street address.  100 char max.
						'shiptocity' => '', 					// Required if shipping is included.  Name of city.  40 char max.
						'shiptostate' => '', 					// Required if shipping is included.  Name of state or province.  40 char max.
						'shiptozip' => '', 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
						'shiptocountrycode' => '', 					// Required if shipping is included.  Country code of shipping address.  2 char max.
						'shiptophonenum' => '',  				// Phone number for shipping address.  20 char max.
						'notetext' => '', 						// Note to the merchant.  255 char max.  
						'allowedpaymentmethod' => '', 			// The payment method type.  Specify the value InstantPaymentOnly.
						'allowpushfunding' => '', 				// Whether the merchant can accept push funding:  0 - Merchant can accept push funding.  1 - Merchant cannot accept push funding.  This will override the setting in the merchant's PayPal account.
						'paymentaction' => '', 					// How you want to obtain the payment.  When implementing parallel payments, this field is required and must be set to Order. 
						'paymentrequestid' => '',  				// A unique identifier of the specific payment request, which is required for parallel payments. 
						'sellerid' => '', 						// The unique non-changing identifier for the seller at the marketplace site.  This ID is not displayed.
						'sellerusername' => '', 				// The current name of the seller or business at the marketplace site.  This name may be shown to the buyer.
						'sellerpaypalaccountid' => ''			// A unique identifier for the merchant.  For parallel payments, this field is required and must contain the Payer ID or the email address of the merchant.
						);
		
		// For order items you populate a nested array with multiple $Item arrays.  
		// Normally you'll be looping through cart items to populate the $Item array
		// Then push it into the $OrderItems array at the end of each loop for an entire 
		// collection of all items in $OrderItems.
				
		$PaymentOrderItems = array();
		$Item = array(
					'name' => '', 								// Item name. 127 char max.
					'desc' => '', 								// Item description. 127 char max.
					'amt' => '', 								// Cost of item.
					'number' => '', 							// Item number.  127 char max.
					'qty' => '', 								// Item qty on order.  Any positive integer.
					'taxamt' => '', 							// Item sales tax
					'itemurl' => '', 							// URL for the item.
					'itemweightvalue' => '', 					// The weight value of the item.
					'itemweightunit' => '', 					// The weight unit of the item.
					'itemheightvalue' => '', 					// The height value of the item.
					'itemheightunit' => '', 					// The height unit of the item.
					'itemwidthvalue' => '', 					// The width value of the item.
					'itemwidthunit' => '', 						// The width unit of the item.
					'itemlengthvalue' => '', 					// The length value of the item.
					'itemlengthunit' => '',  					// The length unit of the item.
					'itemurl' => '', 							// URL for the item.
					'itemcategory' => '', 						// Must be one of the following values:  Digital, Physical
					'ebayitemnumber' => '', 					// Auction item number.  
					'ebayitemauctiontxnid' => '', 				// Auction transaction ID number.  
					'ebayitemorderid' => '',  					// Auction order ID number.
					'ebayitemcartid' => ''						// The unique identifier provided by eBay for this order from the buyer. These parameters must be ordered sequentially beginning with 0 (for example L_EBAYITEMCARTID0, L_EBAYITEMCARTID1). Character length: 255 single-byte characters
					);
		array_push($PaymentOrderItems, $Item);
		
		// Now we've got our OrderItems for this individual payment, 
		// so we'll load them into the $Payment array
		$Payment['order_items'] = $PaymentOrderItems;
		
		// Now we add the current $Payment array into the $Payments array collection
		array_push($Payments, $Payment);
		
		$BuyerDetails = array(
								'buyerid' => '', 				// The unique identifier provided by eBay for this buyer.  The value may or may not be the same as the username.  In the case of eBay, it is different.  Char max 255.
								'buyerusername' => '', 			// The username of the marketplace site.
								'buyerregistrationdate' => ''	// The registration of the buyer with the marketplace.
								);
								
		// For shipping options we create an array of all shipping choices similar to how order items works.
		$ShippingOptions = array();
		$Option = array(
						'l_shippingoptionisdefault' => '', 				// Shipping option.  Required if specifying the Callback URL.  true or false.  Must be only 1 default!
						'l_shippingoptionname' => '', 					// Shipping option name.  Required if specifying the Callback URL.  50 character max.
						'l_shippingoptionlabel' => '', 					// Shipping option label.  Required if specifying the Callback URL.  50 character max.
						'l_shippingoptionamount' => '' 					// Shipping option amount.  Required if specifying the Callback URL.  
						);
		array_push($ShippingOptions, $Option);
			
		// For billing agreements we create an array similar to working with 
		// payments, order items, and shipping options.	
		$BillingAgreements = array();
		$Item = array(
						'l_billingtype' => '', 							// Required.  Type of billing agreement.  For recurring payments it must be RecurringPayments.  You can specify up to ten billing agreements.  For reference transactions, this field must be either:  MerchantInitiatedBilling, or MerchantInitiatedBillingSingleSource
						'l_billingagreementdescription' => '', 			// Required for recurring payments.  Description of goods or services associated with the billing agreement.  
						'l_paymenttype' => '', 							// Specifies the type of PayPal payment you require for the billing agreement.  Any or IntantOnly
						'l_billingagreementcustom' => ''					// Custom annotation field for your own use.  256 char max.
						);
		array_push($BillingAgreements, $Item);
		
		$PayPalRequestData = array(
						'SECFields' => $SECFields, 
						'SurveyChoices' => $SurveyChoices, 
						'Payments' => $Payments, 
						'BuyerDetails' => $BuyerDetails, 
						'ShippingOptions' => $ShippingOptions, 
						'BillingAgreements' => $BillingAgreements
					);
					
		$PayPalResult = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function AGet_express_checkout_details($token)
	{			
		$PayPalResult = $this->paypal_pro->GetExpressCheckoutDetails($token);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Do_express_checkout_payment($PayPalResult)
	{
		$temp_user_id = $PayPalResult['CUSTOM'];
		
		$DECPFields = array(
							'token' => $PayPalResult['TOKEN'], 		// Required.  A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
							'payerid' => $PayPalResult['PAYERID'] 		// Required.  Unique PayPal customer id of the payer.  Returned by GetExpressCheckoutDetails, or if you used SKIPDETAILS it's returned in the URL back to your RETURNURL.
		
						);
						
						
		// You can now utlize parallel payments (split payments) within Express Checkout.
		// Here we'll gather all the payment data for each payment included in this checkout 
		// and pass them into a $Payments array.  
		
		// Keep in mind that each payment will ahve its own set of OrderItems
		// so don't get confused along the way.	
							
		$Payments = array();
		$Payment = array(
						'amt' => $PayPalResult['AMT'], 				// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
						'currencycode' => $PayPalResult['CURRENCYCODE'], 	// A three-character currency code.  Default is USD.
						'itemamt' => '', 			// Required if you specify itemized L_AMT fields. Sum of cost of all items in this order.  
						'shippingamt' => '', 			// Total shipping costs for this order.  If you specify SHIPPINGAMT you mut also specify a value for ITEMAMT.
						'shipdiscamt' => '', 			// Shipping discount for this order, specified as a negative number.
						'insuranceoptionoffered' => '', 	// If true, the insurance drop-down on the PayPal review page displays the string 'Yes' and the insurance amount.  If true, the total shipping insurance for this order must be a positive number.
						'handlingamt' => '', 			// Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
						'taxamt' => '',	// Required if you specify itemized L_TAXAMT fields.  Sum of all tax items in this order. 
						'desc' => '', 				// Description of items on the order.  127 char max.
						'custom' => $PayPalResult['CUSTOM'], 			// Free-form field for your own use.  256 char max.
						'invnum' => $PayPalResult['INVNUM'], 			// Your own invoice or tracking number.  127 char max.
						'notifyurl' => base_url('en/payments_pro/handleIpnResponse'), 			// URL for receiving Instant Payment Notifications
						'shiptoname' => '', 			// Required if shipping is included.  Person's name associated with this address.  32 char max.
						'shiptostreet' => '', 			// Required if shipping is included.  First street address.  100 char max.
						'shiptostreet2' => '', 			// Second street address.  100 char max.
						'shiptocity' => '', 			// Required if shipping is included.  Name of city.  40 char max.
						'shiptostate' => '', 			// Required if shipping is included.  Name of state or province.  40 char max.
						'shiptozip' => '', 			// Required if shipping is included.  Postal code of shipping address.  20 char max.
						'shiptocountrycode' => '', 		// Required if shipping is included.  Country code of shipping address.  2 char max.
						'shiptophonenum' => '',  		// Phone number for shipping address.  20 char max.
						'notetext' => '', 			// Note to the merchant.  255 char max.  
						'allowedpaymentmethod' => '', 		// The payment method type.  Specify the value InstantPaymentOnly.
						'paymentaction' => '', 			// How you want to obtain the payment.  When implementing parallel payments, this field is required and must be set to Order. 
						'paymentrequestid' => '',  		// A unique identifier of the specific payment request, which is required for parallel payments. 
						'sellerid' => '', 			// The unique non-changing identifier for the seller at the marketplace site.  This ID is not displayed.
						'sellerusername' => '', 		// The current name of the seller or business at the marketplace site.  This name be shown to the buyer.
						'sellerregistrationdate' => '', 	// Date when the seller registered with the marketplace.
						'softdescriptor' => '', 		// A per transaction description of the payment that is passed to the buyer's credit card statement.
						'transactionid' => ''			// Tranaction identification number of the tranasction that was created.  NOTE:  This field is only returned after a successful transaction for DoExpressCheckout has occurred. 
						);
			
			
			
		// For order items you populate a nested array with multiple $Item arrays.  
		// Normally you'll be looping through cart items to populate the $Item array
		// Then push it into the $OrderItems array at the end of each loop for an entire 
		// collection of all items in $OrderItems.
					
		$PaymentOrderItems = array();
		
		for($m=0;$m<count($PayPalResult['ORDERITEMS']);$m++)
		{
			$Item = array(
						'name' => $PayPalResult['ORDERITEMS'][$m]['L_NAME'],	// Item name. 127 char max.
						'desc' => $PayPalResult['ORDERITEMS'][$m]['L_DESC'],	// Item description. 127 char max.
						'amt' => $PayPalResult['ORDERITEMS'][$m]['L_AMT']	// Cost of item.
						
					);
					
			array_push($PaymentOrderItems, $Item);
		}
		
		// Now we've got our OrderItems for this individual payment, 
		// so we'll load them into the $Payment array
		$Payment['order_items'] = $PaymentOrderItems;
		
		// Now we add the current $Payment array into the $Payments array collection
		array_push($Payments, $Payment);
		
		$UserSelectedOptions = array(
									 'shippingcalculationmode' => '', 	// Describes how the options that were presented to the user were determined.  values are:  API - Callback   or   API - Flatrate.
									 'insuranceoptionselected' => '', 	// The Yes/No option that you chose for insurance.
									 'shippingoptionisdefault' => '', 	// Is true if the buyer chose the default shipping option.  
									 'shippingoptionamount' => '', 		// The shipping amount that was chosen by the buyer.
									 'shippingoptionname' => '', 		// Is true if the buyer chose the default shipping option...??  Maybe this is supposed to show the name..??
									 );
									 
		$PayPalRequestData = array(
							'DECPFields' => $DECPFields, 
							'Payments' => $Payments, 
							'UserSelectedOptions' => $UserSelectedOptions
						);
						
		$PayPalResult = $this->paypal_pro->DoExpressCheckoutPayment($PayPalRequestData);
		
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			return $PayPalResult;
			//$this->load->view('paypal_error',$errors);
		}
		else
		{
			return $PayPalResult;
			
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Transaction_search()
	{
		$TSFields = array(
							'startdate' => '', 							// Required.  The earliest transaction date you want returned.  Must be in UTC/GMT format.  2008-08-30T05:00:00.00Z
							'enddate' => '', 							// The latest transaction date you want to be included.
							'email' => '', 								// Search by the buyer's email address.
							'receiver' => '', 							// Search by the receiver's email address.  
							'receiptid' => '', 							// Search by the PayPal account optional receipt ID.
							'transactionid' => '', 						// Search by the PayPal transaction ID.
							'invnum' => '', 							// Search by your custom invoice or tracking number.
							'acct' => '', 								// Search by a credit card number, as set by you in your original transaction.  
							'auctionitemnumber' => '', 					// Search by auction item number.
							'transactionclass' => '', 					// Search by classification of transaction.  Possible values are: All, Sent, Received, MassPay, MoneyRequest, FundsAdded, FundsWithdrawn, Referral, Fee, Subscription, Dividend, Billpay, Refund, CurrencyConversions, BalanceTransfer, Reversal, Shipping, BalanceAffecting, ECheck
							'amt' => '', 								// Search by transaction amount.
							'currencycode' => '', 						// Search by currency code.
							'status' => '',  							// Search by transaction status.  Possible values: Pending, Processing, Success, Denied, Reversed
							'profileid' => ''							// Recurring Payments profile ID.  Currently undocumented but has tested to work.
						);
						
		$PayerName = array(
							'salutation' => '', 						// Search by payer's salutation.
							'firstname' => '', 							// Search by payer's first name.
							'middlename' => '', 						// Search by payer's middle name.
							'lastname' => '', 							// Search by payer's last name.
							'suffix' => ''	 							// Search by payer's suffix.
						);
						
		$PayPalRequestData = array(
							'TSFields' => $TSFields, 
							'PayerName' => $PayerName
						);	
						
		$PayPalResult = $this->paypal_pro->TransactionSearch($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Do_non_reference_credit()
	{
		$DNRCFields = array(
							'amt' => '', 						// Required.  Total of order including shipping, handling, and tax.  
							'netamt' => '', 					// Total amount of all items in this transactions.  Subtotal.
							'shippingamt' => '', 				// Total shipping costs on the transaction.
							'taxamt' => '', 					// Sum of tax for all items on the order.
							'currencycode' => '', 				// Required.  Default is USD.  Only valid values are: AUD, CAD, EUR, GBP, JPY, and USD.
							'note' => '' 						// Field used by merchant to record why this credit was issued to the buyer.
						);	
						
		$CCDetails = array(
							'creditcardtype' => '', 			// Required.  Type of credit card.  Values can be: Visa, MasterCard, Discover, Amex, Maestro, Solo
							'acct' => '', 						// Required.  Credit card number.  No spaces or punctuation.
							'expdate' => '', 					// Required.  Credit card expiration date.  MMYYYY
							'cvv2' => '', 						// Requirement determined by PayPal profile settings.  Credit Card security digits.
							'startdate' => '', 					// Mo and Yr that Maestro or Solo card was issued.  MMYYYY.
							'issuenumber' => '' 				// Isssue number of Maestro or Solo card.  
		);
		
		$PayerInfo = array(
							'email' => '', 						// Email address of payer.
							'firstname' => '', 					// Payer's first name.
							'lastname' => '' 					// Payer's last name.
						);
						
		$BillingAddress = array(
								'street' => '', 				// Required.  First street address.
								'street2' => '', 				// Second street address.
								'city' => '', 					// Required.  Name of City.
								'state' => '', 					// Required. Name of State or Province.
								'countrycode' => '', 			// Required.  Country code.
								'zip' => '', 					// Required.  Postal code of payer.
								'phonenum' => '' 				// Phone Number of payer.  20 char max.
							);
							
		$PayPalRequestData = array(
							'DNRCFields' => $DNRCFields, 
							'CCDetails' => $CCDetails, 
							'PayerInfo' => $PayerInfo, 
							'BillingAddress' => $BillingAddress
						);
						
		$PayPalResult = $this->paypal_pro->DoNonReferenceCredit($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Do_reference_transaction()
	{
		$DRTFields = array(
						 'referenceid' => '', 						// Required.  A transaction ID from a previous purchase, such as a credit card charage using DoDirectPayment, or a billing agreement ID
						 'paymentaction' => '', 						// How you want to obtain payment.  Values are:  Authorization, Sale
						 'ipaddress' => '', 							// IP address of the buyer's browser
						 'reqconfirmshipping' => '', 					// Whether you require that the buyer's shipping address on file with PayPal be a confirmed address or not.  Values are 0/1
						 'returnfmfdetails' => '', 					// Flag to indicate whether you want the results returned by Fraud Management Filters.  Values are 0/1
						 'softdescriptor' => ''						// Per transaction description of the payment that is passed to the customer's credit card statement.
						 );
		
		$ShippingAddress = array(
								'shiptoname' => '', 							// Required if shipping is included.  Person's name associated with this address.  32 char max.
								'shiptostreet' => '', 					// Required if shipping is included.  First street address.  100 char max.
								'shiptostreet2' => '', 					// Second street address.  100 char max.
								'shiptocity' => '', 					// Required if shipping is included.  Name of city.  40 char max.
								'shiptostate' => '', 					// Required if shipping is included.  Name of state or province.  40 char max.
								'shiptozip' => '', 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
								'shiptocountry' => '', 					// Required if shipping is included.  Country code of shipping address.  2 char max.
								'shiptophonenum' => ''						// Phone number for shipping address.  20 char max.
								);
		
		$PaymentDetails = array(
								'amt' => '', 							// Required. Total amount of the order, including shipping, handling, and tax.
								'currencycode' => '', 					// A three-character currency code.  Default is USD.
								'itemamt' => '', 						// Required if you specify itemized L_AMT fields. Sum of cost of all items in this order.  
								'shippingamt' => '', 					// Total shipping costs for this order.  If you specify SHIPPINGAMT you mut also specify a value for ITEMAMT.
								'insuranceamt' => '', 
								'shippingdiscount' => '', 
								'handlingamt' => '', 					// Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
								'taxamt' => '', 						// Required if you specify itemized L_TAXAMT fields.  Sum of all tax items in this order. 
								'insuranceoptionoffered' => '', 		// If true, the insurance drop-down on the PayPal review page displays Yes and shows the amount.
								'desc' => '', 							// Description of items on the order.  127 char max.
								'custom' => '', 						// Free-form field for your own use.  256 char max.
								'invnum' => '', 						// Your own invoice or tracking number.  127 char max.
								'notifyurl' => '', 						// URL for receiving Instant Payment Notifications
								'recurring' => ''						// Flag to indicate a recurring transaction.  Values are:  Y for recurring.  Anything other than Y is not recurring.
								);
		
		// For order items you populate a nested array with multiple $Item arrays.  Normally you'll be looping through cart items to populate the $Item 
		// array and then push it into the $OrderItems array at the end of each loop for an entire collection of all items in $OrderItems.
		
		$OrderItems = array();
		$Item		 = array(
							'l_name' => '', 							// Item name. 127 char max.
							'l_desc' => '', 
							'l_amt' => '', 								// Cost of item.
							'l_number' => '', 							// Item number.  127 char max.
							'l_qty' => '', 								// Item qty on order.  Any positive integer.
							'l_taxamt' => '', 							// Item sales tax
							'l_itemweightvalue' => '', 					// The weight value of the item.
							'l_itemweightunit' => '', 					// The weight unit of the item.
							'l_itemheightvalue' => '', 					// The height value of the item.
							'l_itemheightunit' => '', 					// The height unit of the item.
							'l_itemwidthvalue' => '', 					// The width value of the item.
							'l_itemwidthunit' => '', 					// The width unit of the item.
							'l_itemlengthvalue' => '', 					// The length value of the item.
							'l_itemlengthunit' => '',  					// The length unit of the item.
							'l_ebayitemnumber' => '', 					// Auction item number.  
							'l_ebayitemauctiontxnid' => '', 			// Auction transaction ID number.  
							'l_ebayitemorderid' => '' 					// Auction order ID number.
							);
							
		array_push($OrderItems, $Item);
		
		$CCDetails = array(
							'creditcardtype' => '', 					// Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
							'acct' => '', 								// Required.  Credit card number.  No spaces or punctuation.  
							'expdate' => '', 							// Required.  Credit card expiration date.  Format is MMYYYY
							'cvv2' => '', 								// Requirements determined by your PayPal account settings.  Security digits for credit card.
							'startdate' => '', 							// Month and year that Maestro or Solo card was issued.  MMYYYY
							'issuenumber' => ''							// Issue number of Maestro or Solo card.  Two numeric digits max.
						);
		
		$PayerInfo = array(
							'email' => '', 								// Email address of payer.
							'firstname' => '', 							// Unique PayPal customer ID for payer.
							'lastname' => ''						// Status of payer.  Values are verified or unverified
						);
						
		$BillingAddress = array(
								'street' => '', 						// Required.  First street address.
								'street2' => '', 						// Second street address.
								'city' => '', 							// Required.  Name of City.
								'state' => '', 							// Required. Name of State or Province.
								'countrycode' => '', 					// Required.  Country code.
								'zip' => '', 							// Required.  Postal code of payer.
								'phonenum' => '' 						// Phone Number of payer.  20 char max.
							);
							
		$PayPalRequestData = array(
							'DRTFields' => $DRTFields, 
							'ShippingAddress' => $ShippingAddress, 
							'PaymentDetails' => $PaymentDetails, 
							'OrderItems' => $OrderItems, 
							'CCDetails' => $CCDetails, 
							'PayerInfo' => $PayerInfo, 
							'BillingAddress' => $BillingAddress
						);	
						
		$PayPalResult = $this->paypal_pro->DoReferenceTransaction($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Get_balance()
	{		
		$GBFields = array('returnallcurrencies' => '1');
		$PayPalRequestData = array('GBFields'=>$GBFields);
		$PayPalResult = $this->paypal_pro->GetBalance($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.
			$data = array('PayPalResult'=>$PayPalResult);
			$this->load->view('get_balance',$data);
		}
	}
	
	
	function Get_pal_details()
	{
		$PayPalResult = $this->paypal_pro->GetPalDetails();
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Address_verify()
	{
		$AVFields = array
					(
					'email' => '', 							// Required. Email address of PayPal member to verify.
					'street' => '', 						// Required. First line of the postal address to verify.  35 char max.
					'zip' => ''								// Required.  Postal code to verify.  
					);
					
		$PayPalRequestData = array('AVFields' => $AVFields);
		
		$PayPalResult = $this->paypal_pro->AddressVerify($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Manage_pending_transaction_status()
	{
		$MPTSFields = array
					(
					'transactionid' => '', 								// Required. Transaction ID of the payment transaction.
					'action' => ''										// Required.  The operation you want to perform on the pending transaction.  Options are: Accept, Deny 
					);
					
		$PayPalRequestData = array('MPTSFields' => $MPTSFields);
		
		$PayPalResult = $this->paypal_pro->ManagePendingTransactionStatus($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Create_recurring_payments_profile()
	{
		$CRPPFields = array(
					'token' => '', 								// Token returned from PayPal SetExpressCheckout.  Can also use token returned from SetCustomerBillingAgreement.
						);
						
		$ProfileDetails = array(
							'subscribername' => '', 					// Full name of the person receiving the product or service paid for by the recurring payment.  32 char max.
							'profilestartdate' => '', 					// Required.  The date when the billing for this profiile begins.  Must be a valid date in UTC/GMT format.
							'profilereference' => '' 					// The merchant's own unique invoice number or reference ID.  127 char max.
						);
						
		$ScheduleDetails = array(
							'desc' => '', 								// Required.  Description of the recurring payment.  This field must match the corresponding billing agreement description included in SetExpressCheckout.
							'maxfailedpayments' => '', 					// The number of scheduled payment periods that can fail before the profile is automatically suspended.  
							'autobilloutamt' => '' 						// This field indiciates whether you would like PayPal to automatically bill the outstanding balance amount in the next billing cycle.  Values can be: NoAutoBill or AddToNextBilling
						);
						
		$BillingPeriod = array(
							'trialbillingperiod' => '', 
							'trialbillingfrequency' => '', 
							'trialtotalbillingcycles' => '', 
							'trialamt' => '', 
							'billingperiod' => '', 						// Required.  Unit for billing during this subscription period.  One of the following: Day, Week, SemiMonth, Month, Year
							'billingfrequency' => '', 					// Required.  Number of billing periods that make up one billing cycle.  The combination of billing freq. and billing period must be less than or equal to one year. 
							'totalbillingcycles' => '', 				// the number of billing cycles for the payment period (regular or trial).  For trial period it must be greater than 0.  For regular payments 0 means indefinite...until canceled.  
							'amt' => '', 								// Required.  Billing amount for each billing cycle during the payment period.  This does not include shipping and tax. 
							'currencycode' => '', 						// Required.  Three-letter currency code.
							'shippingamt' => '', 						// Shipping amount for each billing cycle during the payment period.
							'taxamt' => '' 								// Tax amount for each billing cycle during the payment period.
						);
						
		$ActivationDetails = array(
							'initamt' => '', 							// Initial non-recurring payment amount due immediatly upon profile creation.  Use an initial amount for enrolment or set-up fees.
							'failedinitamtaction' => '', 				// By default, PayPal will suspend the pending profile in the event that the initial payment fails.  You can override this.  Values are: ContinueOnFailure or CancelOnFailure
						);
						
		$CCDetails = array(
							'creditcardtype' => '', 					// Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
							'acct' => '', 								// Required.  Credit card number.  No spaces or punctuation.  
							'expdate' => '', 							// Required.  Credit card expiration date.  Format is MMYYYY
							'cvv2' => '', 								// Requirements determined by your PayPal account settings.  Security digits for credit card.
							'startdate' => '', 							// Month and year that Maestro or Solo card was issued.  MMYYYY
							'issuenumber' => ''							// Issue number of Maestro or Solo card.  Two numeric digits max.
						);
						
		$PayerInfo = array(
							'email' => '', 								// Email address of payer.
							'payerid' => '', 							// Unique PayPal customer ID for payer.
							'payerstatus' => '', 						// Status of payer.  Values are verified or unverified
							'business' => '' 							// Payer's business name.
						);
						
		$PayerName = array(
							'salutation' => '', 						// Payer's salutation.  20 char max.
							'firstname' => '', 							// Payer's first name.  25 char max.
							'middlename' => '', 						// Payer's middle name.  25 char max.
							'lastname' => '', 							// Payer's last name.  25 char max.
							'suffix' => ''								// Payer's suffix.  12 char max.
						);
						
		$BillingAddress = array(
								'street' => '', 						// Required.  First street address.
								'street2' => '', 						// Second street address.
								'city' => '', 							// Required.  Name of City.
								'state' => '', 							// Required. Name of State or Province.
								'countrycode' => '', 					// Required.  Country code.
								'zip' => '', 							// Required.  Postal code of payer.
								'phonenum' => '' 						// Phone Number of payer.  20 char max.
							);
							
		$ShippingAddress = array(
								'shiptoname' => '', 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
								'shiptostreet' => '', 					// Required if shipping is included.  First street address.  100 char max.
								'shiptostreet2' => '', 					// Second street address.  100 char max.
								'shiptocity' => '', 					// Required if shipping is included.  Name of city.  40 char max.
								'shiptostate' => '', 					// Required if shipping is included.  Name of state or province.  40 char max.
								'shiptozip' => '', 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
								'shiptocountry' => '', 				// Required if shipping is included.  Country code of shipping address.  2 char max.
								'shiptophonenum' => ''					// Phone number for shipping address.  20 char max.
								);
								
		$PayPalRequestData = array(
							'CRPPFields' => $CRPPFields, 
							'ProfileDetails' => $ProfileDetails, 
							'ScheduleDetails' => $ScheduleDetails, 
							'BillingPeriod' => $BillingPeriod, 
							'ActivationDetails' => $ActivationDetails, 
							'CCDetails' => $CCDetails, 
							'PayerInfo' => $PayerInfo, 
							'PayerName' => $PayerName, 
							'BillingAddress' => $BillingAddress, 
							'ShippingAddress' => $ShippingAddress
						);	
						
		$PayPalResult = $this->paypal_pro->CreateRecurringPaymentsProfile($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Get_recurring_payments_profile_details()
	{
		$GRPPDFields = array(
						 'profileid' => ''			// Profile ID of the profile you want to get details for.
						 );
						 
		$PayPalRequestData = array('GRPPDFields' => $GRPPDFields);
		
		$PayPalResult = $this->paypal_pro->GetRecurringPaymentsProfileDetails($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Manage_recurring_payments_profile_status()
	{
		$MRPPSFields = array(
						'profileid' => '', 				// Required. Recurring payments profile ID returned from CreateRecurring...
						'action' => '', 				// Required. The action to be performed.  Mest be: Cancel, Suspend, Reactivate
						'note' => ''					// The reason for the change in status.  For express checkout the message will be included in email to buyers.  Can also be seen in both accounts in the status history.
						);
						
		$PayPalRequestData = array('MRPPSFields' => $MRPPSFields);
		
		$PayPalResult = $this->paypal_pro->ManageRecurringPaymentsProfileStatus($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}		
	}
	
	
	function Bill_outstanding_amount()
	{
		$BOAFields = array(
								 'profileid' => '', 				// Required.  Recurring payments profile ID returned from CreateRecurringPaymentsProfile.
								 'amt' => '', 					// The amount to bill.  Must be less than or equal to the current oustanding balance.  Default is to collect entire amount.
								 'note' => ''						// Note about the reason for the non-scheduled payment.  EC profiles will show this message in the email notification to the buyer and can be seen in the details page by both buyer and seller.
								 );
								 
		$PayPalRequestData = array('BOAFields' => $BOAFields);
		
		$PayPalResult = $this->paypal_pro->BillOutstandingAmount($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}		
	}
	
	
	function Update_recurring_payments_profile()
	{
		$URPPFields = array(
							 'profileid' => '', 							// Required.  Recurring payments ID.
							 'note' => '', 								// Note about the reason for the update to the profile.  Included in EC profile notification emails and in details pages.
							 'desc' => '', 								// Description of the recurring payment profile.
							 'subscribername' => '', 						// Full name of the person receiving the product or service paid for by the recurring payment profile.
							 'profilereference' => '', 					// The merchant's own unique reference or invoice number.
							 'additionalbillingcycles' => '', 			// The number of additional billing cycles to add to this profile.
							 'amt' => '', 								// Billing amount for each cycle in the subscription, not including shipping and tax.  Express Checkout profiles can only be updated by 20% every 180 days.
							 'shippingamt' => '', 						// Shipping amount for each billing cycle during the payment period.
							 'taxamt' => '',  							// Tax amount for each billing cycle during the payment period.
							 'outstandingamt' => '', 						// The current past-due or outstanding amount.  You can only decrease this amount.  
							 'autobilloutamt' => '', 						// This field indiciates whether you would like PayPal to automatically bill the outstanding balance amount in the next billing cycle.
							 'maxfailedpayments' => '', 					// The number of failed payments allowed before the profile is automatically suspended.  The specified value cannot be less than the current number of failed payments for the profile.
							 'profilestartdate' => ''						// The date when the billing for this profile begins.  UTC/GMT format.
							 );
		
		$BillingAddress = array(
							'street' => '', 						// Required.  First street address.
							'street2' => '', 						// Second street address.
							'city' => '', 							// Required.  Name of City.
							'state' => '', 							// Required. Name of State or Province.
							'countrycode' => '', 					// Required.  Country code.
							'zip' => '', 							// Required.  Postal code of payer.
							'phonenum' => '' 						// Phone Number of payer.  20 char max.
						);
		
		$ShippingAddress = array(
							'shiptoname' => '', 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
							'shiptostreet' => '', 					// Required if shipping is included.  First street address.  100 char max.
							'shiptostreet2' => '', 					// Second street address.  100 char max.
							'shiptocity' => '', 					// Required if shipping is included.  Name of city.  40 char max.
							'shiptostate' => '', 					// Required if shipping is included.  Name of state or province.  40 char max.
							'shiptozip' => '', 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
							'shiptocountry' => '', 				// Required if shipping is included.  Country code of shipping address.  2 char max.
							'shiptophonenum' => ''					// Phone number for shipping address.  20 char max.
							);
		
		$BillingPeriod = array(
						'trialbillingperiod' => '', 
						'trialbillingfrequency' => '', 
						'trialtotalbillingcycles' => '', 
						'trialamt' => '', 
						'billingperiod' => '', 						// Required.  Unit for billing during this subscription period.  One of the following: Day, Week, SemiMonth, Month, Year
						'billingfrequency' => '', 					// Required.  Number of billing periods that make up one billing cycle.  The combination of billing freq. and billing period must be less than or equal to one year. 
						'totalbillingcycles' => '', 				// the number of billing cycles for the payment period (regular or trial).  For trial period it must be greater than 0.  For regular payments 0 means indefinite...until canceled.  
						'amt' => '', 								// Required.  Billing amount for each billing cycle during the payment period.  This does not include shipping and tax. 
						'currencycode' => '', 						// Required.  Three-letter currency code.
					);
		
		$CCDetails = array(
						'creditcardtype' => '', 					// Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
						'acct' => '', 								// Required.  Credit card number.  No spaces or punctuation.  
						'expdate' => '', 							// Required.  Credit card expiration date.  Format is MMYYYY
						'cvv2' => '', 								// Requirements determined by your PayPal account settings.  Security digits for credit card.
						'startdate' => '', 							// Month and year that Maestro or Solo card was issued.  MMYYYY
						'issuenumber' => ''							// Issue number of Maestro or Solo card.  Two numeric digits max.
					);
		
		$PayerInfo = array(
						'email' => '', 								// Payer's email address.
						'firstname' => '', 							// Required.  Payer's first name.
						'lastname' => ''							// Required.  Payer's last name.
					);	
					
		$PayPalRequestData = array(
							'URPPFields' => $URPPFields, 
							'BillingAddress' => $BillingAddress, 
							'ShippingAddress' => $ShippingAddress, 
							'BillingPeriod' => $BillingPeriod, 
							'CCDetails' => $CCDetails, 
							'PayerInfo' => $PayerInfo
						);
						
		$PayPalResult = $this->paypal_pro->UpdateRecurringPaymentsProfile($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Billing_agreement_update()
	{
		$BAUFields = array(
							 'referenceid' => '', 							// Required. An ID, such as a billing agreement ID or a reference transaction ID that is associated with a billing agreement.
							 'billingagreementstatus' => '', 					// The current status of the billing agreement, which is one of the following values: Active or Canceled.
							 'billingagreementdescription' => '', 			// Description of goods or services associated with the billing agreement, which is required for each recurring payment billing agreement. PayPal recommends that the description contain a brief summary of the billing agreement terms and conditions. For example, customer will be billed at "9.99 per month for 2 years". 127 Car max.
							 'billingagreementcustom' => ''					// Custom annotation field for your own use.  256 char max.
							 );
							 
		$PayPalRequestData = array('BAUFields' => $BAUFields);	
		
		$PayPalResult = $this->paypal_pro->BillingAgreementUpdate($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Set_mobile_checkout()
	{
		$SMCFields = array(
							'phonecountrycode' => '', 				// Three-digit country code for buyer's phone number.  
							'phonenum' => '', 						// Localized phone number used by the buyer to submit the payment request.  if the phone number is activated for mobile checkout, PayPal uses this value to pre-fill the PayPal login page.
							'amt' => '', 							// Required. Cost of item before tax and shipping.
							'currencycode' => '', 					// Required.  Three-character currency code.  Default is USD.
							'taxamt' => '', 						// Tax on item purchased.
							'shippingamt' => '', 					// shipping costs for this transaction.
							'desc' => '', 							// Required. The name of the item is being ordered.  127 char max.
							'number' => '', 						// Pass-through field allowing you to specify detailis, such as a SKU.  127 char max.
							'custom' => '', 						// Free-form field for your own use.  256 char max.
							'invnum' => '', 						// Your own invoice or tracking number.  127 char max.
							'returnurl' => '', 						// URL to direct the browser to after leaving PayPal pages.
							'cancelurl' => '', 						// URL to direct the borwser to if the user cancels payment.
							'addressdisplay' => '', 				// Indiciates whether or not a shipping address is required.  1 or 0. 
							'sharephonenum' => '', 					// Indiciates whether or not the customer's phone number is returned to the merchant.  1 or 0.  
							'email' => '' 							// Email address of the buyer as entered during checkout.  If the phone number is not activated for Mobile Checkout, PayPal uses this value to pre-fill the PayPal login page.  127 char max.
						);
						
		$ShippingAddress = array(
								'shiptoname' => '', 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
								'shiptostreet' => '', 					// Required if shipping is included.  First street address.  100 char max.
								'shiptostreet2' => '', 					// Second street address.  100 char max.
								'shiptocity' => '', 					// Required if shipping is included.  Name of city.  40 char max.
								'shiptostate' => '', 					// Required if shipping is included.  Name of state or province.  40 char max.
								'shiptozip' => '', 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
								'shiptocountry' => '' 					// Required if shipping is included.  Country code of shipping address.  2 char max.
								);
								
		$PayPalRequestData = array(
							'SMCFields' => $SMCFields, 
							'ShippingAddress' => $ShippingAddress
						);	
						
		$PayPalResult = $this->paypal_pro->SetMobileCheckout($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Do_mobile_checkout_payment()
	{
		$DMCFields = array(
							 'token' => ''				// Token returned by SetMobileCheckout
							 );
							 
		$PayPalRequestData = array('DMCFields' => $DMCFields);
		
		$PayPalResult = $this->paypal_pro->DoMobileCheckoutPayment($PayPalRequestData);	
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Set_auth_flow_param()
	{
		$SetAuthFlowParamFields = array(
										'ReturnURL' => '', 														// URL to which the customer's browser is returned after choosing to authenticate with PayPal
										'CancelURL' => '', 														// URL to which the customer is returned if they decide not to log in.
										'LogoutURL' => '', 														// URL to which the customer is returned after logging out from your site.
										'LocalCode' => '', 														// Local of pages displayed by PayPal during authentication.  AU, DE, FR, IT, GB, ES, US
										'PageStyle' => '', 														// Sets the custom payment page style of the PayPal pages associated with this button/link.
										'HDRIMG' => '', 														// URL for the iamge you want to appear at the top of the PayPal pages.  750x90.  Should be stored on a secure server.  127 char max.
										'HDRBorderColor' => '', 												// Sets the border color around the header on PayPal pages.HTML Hexadecimal value.
										'HDRBackColor' => '', 													// Sets the background color for PayPal pages.
										'PayFlowColor' => '', 													// Sets the background color for the payment page.
										'InitFlowType' => '', 													// The initial flow type, which is one of the following:  login  / signup   Default is login.
										'FirstName' => '', 														// Customer's first name.
										'LastName' => '',  														// Customer's last name.
										'ServiceName1' => 'Name', 
										'ServiceName2' => 'Email', 
										'ServiceDefReq1' => 'Required', 
										'ServiceDefReq2' => 'Required'
										);
		
		$ShippingAddress = array(
								'ShipToName' => '', 													// Persona's name associated with this address.
								'ShipToStreet' => '', 													// First street address.
								'ShipToStreet2' => '', 													// Second street address.
								'ShipToCity' => '', 													// Name of city.
								'ShipToState' => '', 													// Name of State or Province.
								'ShipToZip' => '', 														// US Zip code or other country-specific postal code.
								'ShipToCountryCode' => '' 												// Country code.
								 );
								 
		$PayPalRequestData = array(
							'SetAuthFlowParamFields' => $SetAuthFlowParamFields, 
							'ShippingAddress' => $ShippingAddress
						);	
						
		$PayPalResult = $this->paypal_pro->SetAuthFlowParam($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Get_auth_details($token)
	{
		$PayPalResult = $this->paypal_pro->GetAuthDetails($token);	
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Get_access_permissions_details($token)
	{
		$PayPalResult = $this->paypal_pro->GetAccessPermissionsDetails($token);	
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Set_access_permissions()
	{
		$SetAccessPermissionsFields = array(
											'ReturnURL' => '', 														// URL to return the browser to after authorizing permissions.
											'CancelURL' => '', 													 	// URL to return if the customer cancels authorization
											'LogoutURL' => '', 														// URL to return to on logout from PayPal
											'LocalCode' => '', 														// Local of pages displayed by PayPal during authentication.  AU, DE, FR, IT, GB, ES, US
											'PageStyle' => '', 														// Sets the custom payment page style of the PayPal pages associated with this button/link.
											'HDRIMG' => '', 														// URL for the iamge you want to appear at the top of the PayPal pages.  750x90.  Should be stored on a secure server.  127 char max.
											'HDRBorderColor' => '', 												// Sets the border color around the header on PayPal pages.HTML Hexadecimal value.
											'HDRBackColor' => '', 													// Sets the background color for PayPal pages.
											'PayFlowColor' => '', 													// Sets the background color for the payment page.
											'InitFlowType' => '', 													// The initial flow type, which is one of the following:  login  / signup   Default is login.
											'FirstName' => '', 														// Customer's first name.
											'LastName' => ''
											);
		
		$RequiredPermissions = array(
									 'Email', 
									 'Name', 
									 'GetBalance', 
									 'RefundTransaction', 
									 'GetTransactionDetails', 
									 'TransactionSearch', 
									 'MassPay', 
									 'EncryptedWebsitePayments', 
									 'GetExpressCheckoutDetails', 
									 'SetExpressCheckout', 
									 'DoExpressCheckoutPayment', 
									 'DoCapture', 
									 'DoAuthorization', 
									 'DoReauthorization', 
									 'DoVoid', 
									 'DoDirectPayment', 
									 'SetMobileCheckout', 
									 'CreateMobileCheckout', 
									 'DoMobileCheckoutPayment', 
									 'DoUATPAuthorization', 
									 'DoUATPExpressCheckoutPayment', 
									 'GetBillingAgreementCustomerDetails', 
									 'SetCustomerBillingAgreement', 
									 'CreateBillingAgreement', 
									 'BillAgreementUpdate', 
									 'BillUser', 
									 'DoReferenceTransaction', 
									 'Express_Checkout', 
									 'Admin_API', 
									 'Auth_Settle', 
									 'Transaction_History'
									 );
		
		$OptionalPermissions = array(
									 'Email', 
									 'Name', 
									 'GetBalance', 
									 'RefundTransaction', 
									 'GetTransactionDetails', 
									 'TransactionSearch', 
									 'MassPay', 
									 'EncryptedWebsitePayments', 
									 'GetExpressCheckoutDetails', 
									 'SetExpressCheckout', 
									 'DoExpressCheckoutPayment', 
									 'DoCapture', 
									 'DoAuthorization', 
									 'DoReauthorization', 
									 'DoVoid', 
									 'DoDirectPayment', 
									 'SetMobileCheckout', 
									 'CreateMobileCheckout', 
									 'DoMobileCheckoutPayment', 
									 'DoUATPAuthorization', 
									 'DoUATPExpressCheckoutPayment', 
									 'GetBillingAgreementCustomerDetails', 
									 'SetCustomerBillingAgreement', 
									 'CreateBillingAgreement', 
									 'BillAgreementUpdate', 
									 'BillUser', 
									 'DoReferenceTransaction', 
									 'Express_Checkout', 
									 'Admin_API', 
									 'Auth_Settle', 
									 'Transaction_History'
									 );
		
		$PayPalRequestData = array(
									 'SetAccessPermissionsFields' => $SetAccessPermissionsFields, 
									 'RequiredPermissions' => $RequiredPermissions, 
									 'OptionalPermissions' => $OptionalPermissions
									 );	
									 
		$PayPalResult = $this->paypal_pro->SetAccessPermissions($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Update_access_permissions($payer_id)
	{
		$PayPalResult = $this->paypal_pro->UpdateAccessPermissions($payer_id);	
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Bm_button_search()
	{
		$BMButtonSearchFields = array
								(
								'startdate' => '', 			// Required.  Starting date for the search.  UTC/GMT format: 2009-08-24T05:38:48Z
								'enddate' => ''				// Ending date for the search.  UTC/GMT format: 2010-05-01T05:38:48Z  
								);
								
		$PayPalRequestData = array('BMButtonSearchFields'=>$BMButtonSearchFields);
						
		$PayPalResult = $this->paypal_pro->BMButtonSearch($PayPalRequestData);	
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}




	function sendPaypalData(){
		$this->load->model('model_membershipcart');
		$cartId=$this->session->userdata('currentCartId');  
		$sendData = $this->model_membershipcart->getUserBuyData();	
	
		$mainAmmount = "";
		foreach($sendData as $send_Data)
		{
			$userId=isloginUser();
			$vatApplied = getConsumptionTax($userId);    
			
			
			$getProductDetails =  $this->model_membershipcart->getProductDetails($send_Data->tsProductId);
			$getMembershipSpacePrice =  $this->model_membershipcart->getMembershipSpacePrice($send_Data->cartItemId);
			
			
			
			$vatVal = (number_format(($getMembershipSpacePrice*$vatApplied)/100,2)) ;
			$getSpacePrice = $getMembershipSpacePrice + $vatVal;
			
			if($send_Data->type!=2){			
				$vatVal = (number_format(($getProductDetails[0]->price*$vatApplied)/100,2)) ;
				$getProductPrice = $getProductDetails[0]->price + $vatVal ;
			 }else {
				$getProductPrice=0;						 
			 }
						
			$send_Data->productName = $getProductDetails[0]->title;
			$send_Data->price = $getSpacePrice + $getProductPrice;
			$mainAmmount =  $send_Data->price  + $mainAmmount;
			//print_r($getProductDetails[0]->title);
			
		}
		
		$SECFields = array(
							'token' => '', 			// A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
							//'maxamt' => $this->input->post("amt"), 		// The expected maximum total amount the order will be, including S&H and sales tax.
							'returnurl' => base_url('en/membershipcart/payments_pro/return_express_checkout'), 		// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
							'cancelurl' => base_url('en/payment/process/canceltransaction'), 		// Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
							'solutiontype' => 'Sole',
							//'callback' => 'http://115.113.182.131/dc/paypal/payments_pro.php/return_express_checkout_callback', 		// URL to which the callback request from PayPal is sent.  Must start with https:// for production.
							/*
							'callbacktimeout' => '', 	// An override for you to request more or less time to be able to process the callback request and response.  Acceptable range for override is 1-6 seconds.  If you specify greater than 6 PayPal will use default value of 3 seconds.
							'callbackversion' => '', 	// The version of the Instant Update API you're using.  The default is the current version.							
							'reqconfirmshipping' => '', 	// The value 1 indicates that you require that the customer's shipping address is Confirmed with PayPal.  This overrides anything in the account profile.  Possible values are 1 or 0.
							'noshipping' => '', 		// The value 1 indiciates that on the PayPal pages, no shipping address fields should be displayed.  Maybe 1 or 0.
							'allownote' => '', 		// The value 1 indiciates that the customer may enter a note to the merchant on the PayPal page during checkout.  The note is returned in the GetExpresscheckoutDetails response and the DoExpressCheckoutPayment response.  Must be 1 or 0.
							'addroverride' => '', 		// The value 1 indiciates that the PayPal pages should display the shipping address set by you in the SetExpressCheckout request, not the shipping address on file with PayPal.  This does not allow the customer to edit the address here.  Must be 1 or 0.
							'localecode' => '', 		// Locale of pages displayed by PayPal during checkout.  Should be a 2 character country code.  You can retrive the country code by passing the country name into the class' GetCountryCode() function.
							'pagestyle' => '', 		// Sets the Custom Payment Page Style for payment pages associated with this button/link.  
							'hdrimg' => '', 		// URL for the image displayed as the header during checkout.  Max size of 750x90.  Should be stored on an https:// server or you'll get a warning message in the browser.
							'hdrbordercolor' => '', 	// Sets the border color around the header of the payment page.  The border is a 2-pixel permiter around the header space.  Default is black.  
							'hdrbackcolor' => '', 		// Sets the background color for the header of the payment page.  Default is white.  
							'payflowcolor' => '', 		// Sets the background color for the payment page.  Default is white.
							'skipdetails' => '', 		// This is a custom field not included in the PayPal documentation.  It's used to specify whether you want to skip the GetExpressCheckoutDetails part of checkout or not.  See PayPal docs for more info.
							'email' => '', 			// Email address of the buyer as entered during checkout.  PayPal uses this value to pre-fill the PayPal sign-in page.  127 char max.
							'solutiontype' => '', 		// Type of checkout flow.  Must be Sole (express checkout for auctions) or Mark (normal express checkout)
							'landingpage' => '', 		// Type of PayPal page to display.  Can be Billing or Login.  If billing it shows a full credit card form.  If Login it just shows the login screen.
							'channeltype' => '', 		// Type of channel.  Must be Merchant (non-auction seller) or eBayItem (eBay auction)
							'giropaysuccessurl' => '', 	// The URL on the merchant site to redirect to after a successful giropay payment.  Only use this field if you are using giropay or bank transfer payment methods in Germany.
							'giropaycancelurl' => '', 	// The URL on the merchant site to redirect to after a canceled giropay payment.  Only use this field if you are using giropay or bank transfer methods in Germany.
							'banktxnpendingurl' => '',  	// The URL on the merchant site to transfer to after a bank transfter payment.  Use this field only if you are using giropay or bank transfer methods in Germany.
							'brandname' => '', 		// A label that overrides the business name in the PayPal account on the PayPal hosted checkout pages.  127 char max.
							'customerservicenumber' => '', 	// Merchant Customer Service number displayed on the PayPal Review page. 16 char max.
							'giftmessageenable' => '', 	// Enable gift message widget on the PayPal Review page. Allowable values are 0 and 1
							'giftreceiptenable' => '', 	// Enable gift receipt widget on the PayPal Review page. Allowable values are 0 and 1
							'giftwrapenable' => '', 	// Enable gift wrap widget on the PayPal Review page.  Allowable values are 0 and 1.
							'giftwrapname' => '', 		// Label for the gift wrap option such as "Box with ribbon".  25 char max.
							'giftwrapamount' => '', 	// Amount charged for gift-wrap service.
							'buyeremailoptionenable' => '', // Enable buyer email opt-in on the PayPal Review page. Allowable values are 0 and 1
							'surveyquestion' => '', 	// Text for the survey question on the PayPal Review page. If the survey question is present, at least 2 survey answer options need to be present.  50 char max.
							'surveyenable' => '', 		// Enable survey functionality. Allowable values are 0 and 1
							'buyerid' => '', 		// The unique identifier provided by eBay for this buyer. The value may or may not be the same as the username. In the case of eBay, it is different. 255 char max.
							'buyerusername' => '', 		// The user name of the user at the marketplaces site.
							'buyerregistrationdate' => '',  // Date when the user registered with the marketplace.
							'allowpushfunding' => ''	// Whether the merchant can accept push funding.  0 = Merchant can accept push funding : 1 = Merchant cannot accept push funding.			
						*/	
						);
		
		$invNo = $this->createInvNo();			
						
		$Payments = array();
		$Payment = array(
				'amt' => number_format($mainAmmount,2), 	// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
				'currencycode' => $this->config->item('toadCurrency'), 		// A three-character currency code.  Default is USD.
				'custom' => $cartId, 			// Free-form field for your own use.  256 char max.
				'invnum' => $invNo,
				'notifyurl' => base_url('en/payments_pro/handleIpnResponse')				// Your own invoice or tracking number.  127 char m
			);		
		$PaymentOrderItems = array();
		
		foreach ($sendData as $paydata ) {	
			$Item = array(
					'name' => $paydata->productName, 		// Item name. 127 char max.
					'desc' => 'Toadsquare Tool', 		// Item description. 127 char max.
					'amt' => number_format($paydata->price,2)				
				);
						
			array_push($PaymentOrderItems, $Item);	
		}	
	
		$Payment['order_items'] = $PaymentOrderItems;
		array_push($Payments, $Payment);		
		
		$BillingAddress = array(
						'street' => '123 Test Ave.', 						// Required.  First street address.
						'street2' => '', 						// Second street address.
						'city' => 'Kansas City', 							// Required.  Name of City.
						'state' => 'MO', 							// Required. Name of State or Province.
						'countrycode' => 'US', 					// Required.  Country code.
						'zip' => '64111', 							// Required.  Postal code of payer.
						'phonenum' => '555-555-5555' 						// Phone Number of payer.  20 char max.
					);
							
		$ShippingAddress = array(
						'shiptoname' => 'Tester Testerson', 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
						'shiptostreet' => '123 Test Ave.', 					// Required if shipping is included.  First street address.  100 char max.
						'shiptostreet2' => '', 					// Second street address.  100 char max.
						'shiptocity' => 'Kansas City', 					// Required if shipping is included.  Name of city.  40 char max.
						'shiptostate' => 'MO', 					// Required if shipping is included.  Name of state or province.  40 char max.
						'shiptozip' => '64111', 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
						'shiptocountry' => 'US', 					// Required if shipping is included.  Country code of shipping address.  2 char max.
						'shiptophonenum' => '555-555-5555'					// Phone number for shipping address.  20 char max.
					);

		$PayPalRequestData = array(				
							'SECFields' => $SECFields,						
							'Payments' => $Payments,
							'BillingAddress' => $BillingAddress, 
							'ShipToAddress' => $ShippingAddress,
						);
		$PayPalResult = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{   
			//redirect(base_url(lang().'/payment/process/paymenterror'));
			redirect(base_url(lang().'/package/paymenterror'));
		} else {
			// Successful call.  Load view or whatever you need to do here.	
			$isSandBox =$this->config->item('Sandbox');
			if($isSandBox==true){		
				redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
			} else {
				redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
			}	
		}
	}

	//---------------------------------------------------------------------------------
	
	/*
	 * @Description: This function is used to post packages data in paypal 
	 * @return: string
	 * @auther: lokendra
	 */ 
	 
	function packagepaypaldata(){
		
		$this->load->model('model_membershipcart');
		$cartId   =  $this->session->userdata('packageCartId');  
		$sendData = $this->model_membershipcart->packagesuserbuydata();	
		
		if(isLoginUser()){
			$userId     =  isLoginUser(); # get user id
		}else{
			$userId     =  $this->session->userdata('joinedUserId');
		}
		
		$mainAmmount = "";
		foreach($sendData as $send_Data)
		{
		 
			$vatApplied       =  $this->config->item('package_vat_percent');    
		 
			$selectedPacakge  =  $this->session->userdata('selectedPacakge');  
	
		 if($selectedPacakge==$this->config->item('package_type_2')){
				$totalPrice         = $this->config->item('package_1_year_price');
				$packageTitle       = $this->config->item('package_title_2');
				$pkgId              = $this->config->item('package_1_year_id');
			}elseif($selectedPacakge==$this->config->item('package_type_3')){
				$totalPrice         = $this->config->item('package_3_year_price');
				$packageTitle       = $this->config->item('package_title_3');
				$pkgId              = $this->config->item('package_3_year_id');
			}
			
			// set total price to membership price
			$getMembershipSpacePrice  =  $totalPrice;
			
			$vatVal         = (number_format(($getMembershipSpacePrice*$vatApplied)/100,2)) ;
			$getSpacePrice  = $getMembershipSpacePrice + $vatVal;
			
			
			$send_Data->productName   =   $packageTitle;
			$send_Data->price         =   $getSpacePrice;
			$mainAmmount              =   $getSpacePrice;
		}
		
		$SECFields = array(
							'token' => '', 			// A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
							//'maxamt' => $this->input->post("amt"), 		// The expected maximum total amount the order will be, including S&H and sales tax.
							'returnurl' => base_url('en/membershipcart/payments_pro/packagereturnprocess'), 		// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
							'cancelurl' => base_url('en/payment/process/canceltransaction'), 		// Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
							'solutiontype' => 'Sole',
							//'callback' => 'http://115.113.182.131/dc/paypal/payments_pro.php/return_express_checkout_callback', 		// URL to which the callback request from PayPal is sent.  Must start with https:// for production.
							/*
							'callbacktimeout' => '', 	// An override for you to request more or less time to be able to process the callback request and response.  Acceptable range for override is 1-6 seconds.  If you specify greater than 6 PayPal will use default value of 3 seconds.
							'callbackversion' => '', 	// The version of the Instant Update API you're using.  The default is the current version.							
							'reqconfirmshipping' => '', 	// The value 1 indicates that you require that the customer's shipping address is Confirmed with PayPal.  This overrides anything in the account profile.  Possible values are 1 or 0.
							'noshipping' => '', 		// The value 1 indiciates that on the PayPal pages, no shipping address fields should be displayed.  Maybe 1 or 0.
							'allownote' => '', 		// The value 1 indiciates that the customer may enter a note to the merchant on the PayPal page during checkout.  The note is returned in the GetExpresscheckoutDetails response and the DoExpressCheckoutPayment response.  Must be 1 or 0.
							'addroverride' => '', 		// The value 1 indiciates that the PayPal pages should display the shipping address set by you in the SetExpressCheckout request, not the shipping address on file with PayPal.  This does not allow the customer to edit the address here.  Must be 1 or 0.
							'localecode' => '', 		// Locale of pages displayed by PayPal during checkout.  Should be a 2 character country code.  You can retrive the country code by passing the country name into the class' GetCountryCode() function.
							'pagestyle' => '', 		// Sets the Custom Payment Page Style for payment pages associated with this button/link.  
							'hdrimg' => '', 		// URL for the image displayed as the header during checkout.  Max size of 750x90.  Should be stored on an https:// server or you'll get a warning message in the browser.
							'hdrbordercolor' => '', 	// Sets the border color around the header of the payment page.  The border is a 2-pixel permiter around the header space.  Default is black.  
							'hdrbackcolor' => '', 		// Sets the background color for the header of the payment page.  Default is white.  
							'payflowcolor' => '', 		// Sets the background color for the payment page.  Default is white.
							'skipdetails' => '', 		// This is a custom field not included in the PayPal documentation.  It's used to specify whether you want to skip the GetExpressCheckoutDetails part of checkout or not.  See PayPal docs for more info.
							'email' => '', 			// Email address of the buyer as entered during checkout.  PayPal uses this value to pre-fill the PayPal sign-in page.  127 char max.
							'solutiontype' => '', 		// Type of checkout flow.  Must be Sole (express checkout for auctions) or Mark (normal express checkout)
							'landingpage' => '', 		// Type of PayPal page to display.  Can be Billing or Login.  If billing it shows a full credit card form.  If Login it just shows the login screen.
							'channeltype' => '', 		// Type of channel.  Must be Merchant (non-auction seller) or eBayItem (eBay auction)
							'giropaysuccessurl' => '', 	// The URL on the merchant site to redirect to after a successful giropay payment.  Only use this field if you are using giropay or bank transfer payment methods in Germany.
							'giropaycancelurl' => '', 	// The URL on the merchant site to redirect to after a canceled giropay payment.  Only use this field if you are using giropay or bank transfer methods in Germany.
							'banktxnpendingurl' => '',  	// The URL on the merchant site to transfer to after a bank transfter payment.  Use this field only if you are using giropay or bank transfer methods in Germany.
							'brandname' => '', 		// A label that overrides the business name in the PayPal account on the PayPal hosted checkout pages.  127 char max.
							'customerservicenumber' => '', 	// Merchant Customer Service number displayed on the PayPal Review page. 16 char max.
							'giftmessageenable' => '', 	// Enable gift message widget on the PayPal Review page. Allowable values are 0 and 1
							'giftreceiptenable' => '', 	// Enable gift receipt widget on the PayPal Review page. Allowable values are 0 and 1
							'giftwrapenable' => '', 	// Enable gift wrap widget on the PayPal Review page.  Allowable values are 0 and 1.
							'giftwrapname' => '', 		// Label for the gift wrap option such as "Box with ribbon".  25 char max.
							'giftwrapamount' => '', 	// Amount charged for gift-wrap service.
							'buyeremailoptionenable' => '', // Enable buyer email opt-in on the PayPal Review page. Allowable values are 0 and 1
							'surveyquestion' => '', 	// Text for the survey question on the PayPal Review page. If the survey question is present, at least 2 survey answer options need to be present.  50 char max.
							'surveyenable' => '', 		// Enable survey functionality. Allowable values are 0 and 1
							'buyerid' => '', 		// The unique identifier provided by eBay for this buyer. The value may or may not be the same as the username. In the case of eBay, it is different. 255 char max.
							'buyerusername' => '', 		// The user name of the user at the marketplaces site.
							'buyerregistrationdate' => '',  // Date when the user registered with the marketplace.
							'allowpushfunding' => ''	// Whether the merchant can accept push funding.  0 = Merchant can accept push funding : 1 = Merchant cannot accept push funding.			
						*/	
						);
		
			$invNo = $this->createInvNo();			

			$Payments = array();
			$Payment = array(
				'amt' => number_format($mainAmmount,2), 	// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
				'currencycode' => $this->config->item('toadCurrency'), 		// A three-character currency code.  Default is USD.
				'custom' => $cartId, 			// Free-form field for your own use.  256 char max.
				'invnum' => $invNo,
				'notifyurl' => base_url('en/payments_pro/handleIpnResponse')				// Your own invoice or tracking number.  127 char m
			);

		$PaymentOrderItems = array();
		
		foreach ($sendData as $paydata ) {	
			$Item     =   array(
				'name'  =>  $packageTitle, 		// Item name. 127 char max.
				'desc'  =>  'Toadsquare Membership Package', 		// Item description. 127 char max.
				'amt'   =>  number_format($paydata->price,2)				
			);

			array_push($PaymentOrderItems, $Item);	
		}	
	
	
		$Payment['order_items'] = $PaymentOrderItems;
		array_push($Payments, $Payment);		
		
		$BillingAddress = array(
								'street' => '123 Test Ave.', 						// Required.  First street address.
								'street2' => '', 						// Second street address.
								'city' => 'Kansas City', 							// Required.  Name of City.
								'state' => 'MO', 							// Required. Name of State or Province.
								'countrycode' => 'US', 					// Required.  Country code.
								'zip' => '64111', 							// Required.  Postal code of payer.
								'phonenum' => '555-555-5555' 						// Phone Number of payer.  20 char max.
							);
							
		$ShippingAddress = array(
								'shiptoname' => 'Tester Testerson', 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
								'shiptostreet' => '123 Test Ave.', 					// Required if shipping is included.  First street address.  100 char max.
								'shiptostreet2' => '', 					// Second street address.  100 char max.
								'shiptocity' => 'Kansas City', 					// Required if shipping is included.  Name of city.  40 char max.
								'shiptostate' => 'MO', 					// Required if shipping is included.  Name of state or province.  40 char max.
								'shiptozip' => '64111', 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
								'shiptocountry' => 'US', 					// Required if shipping is included.  Country code of shipping address.  2 char max.
								'shiptophonenum' => '555-555-5555'					// Phone number for shipping address.  20 char max.
								);

	 $PayPalRequestData = array(				
					'SECFields' => $SECFields,						
					'Payments' => $Payments,
					//'BillingAddress' => $BillingAddress, 
					//'ShipToAddress' => $ShippingAddress,
					);
					
		$PayPalResult = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{   
			
			//echo "<pre/>";print_r($PayPalResult);
			redirect(base_url(lang().'/package/paymenterror'));
			
		}
		else{
			// Successful call.  Load view or whatever you need to do here.	
				//echo "<pre/>";
			
			$isSandBox =$this->config->item('Sandbox');
			
			if($isSandBox==true){		
				redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
				}else {
					redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
				 }	
		}
	}

	//------------------------------------------------------------------------
	
	/*
	* @Description: This function is used to post packages renew data in paypal 
	* @return: string
	* @auther: lokendra
	*/ 
	 
	public function packagerenew(){


		// get active current cartId 
		$packageCartId   =  $this->session->userdata('packageCartId');  
		
		// get logged in user data
		$userId     =  $this->isLoginUser(); 
		
		// get user membership cart data
		$whereMemCart 	     =  array('cartId' => $packageCartId);
		$membershipCartData  =  $this->model_common->getDataFromTabel('MembershipCart', '*',  $whereMemCart, '', $orderBy='cartId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
		if(!empty($membershipCartData)){
			$membershipCartData   =  $membershipCartData[0];
		}
		
		//total price user have to pay
		$totalPrice = $membershipCartData->totalPrice;
		
		/* set title and description of package */
		$productTitle = $this->lang->line('renew_package_title');
		
		$desc = $this->lang->line('renew_package_desc');
		//get degrade session value if exist
		$isDowngradePackage = $this->session->userdata('isDegradePackage');
		if(!empty($isDowngradePackage)) {
			$productTitle = $this->lang->line('degrade_package_title');
			$desc = $this->lang->line('degrade_package_desc');
		}
		
		//membership order send data prepare
		$membershipOrderData[]  = array(
			'productTitle' => $productTitle,
			'totalPrice' => $totalPrice,
		);
	
		//SECFields
		$paypalField = array(
			'token' => '', 			// A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
			'returnurl' => base_url('en/membershipcart/payments_pro/renewpackageprocess'), 		// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
			'cancelurl' => base_url('en/payment/process/canceltransaction'), 		// Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
			'solutiontype' => 'Sole',
		);

		// get randon invoice number
		$invoieNumber = $this->createInvNo();			

		//define default array
		$paypaylPaymentArray = array();
		
		// set payment details
		$paymentDetails = array(
			'amt' => number_format($totalPrice,2), 	// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
			'currencycode' => $this->config->item('toadCurrency'), 		// A three-character currency code.  Default is USD.
			'custom' => $packageCartId, 			// Free-form field for your own use.  256 char max.
			'invnum' => $invoieNumber,
			'notifyurl' => base_url('en/payments_pro/handleIpnResponse')				// Your own invoice or tracking number.  127 char m
		);

		// default payment order item array
		$paymentOrderItems = array();

		//prepare payment order  item data for paypal
		if(!empty($membershipOrderData)){
			foreach($membershipOrderData as $membershipOrder){
				$Item     =   array(
					'name'  =>  $membershipOrder['productTitle'], 		// Item title. 127 char max.
					'desc'  =>  $desc, 		// Item description. 127 char max.
					'amt'   =>  number_format($membershipOrder['totalPrice'],2)				
				);

				//push data in payment order item array 
				array_push($paymentOrderItems, $Item);	
			}
		}
	 
		// add data in payment details 
		$paymentDetails['order_items'] = $paymentOrderItems;
		
		//push payment details in paypal palment array
		array_push($paypaylPaymentArray, $paymentDetails);	
	
		//prepre paypal request array data
		$PayPalRequestData = array(
			'SECFields' => $paypalField,
			'Payments' => $paypaylPaymentArray,
		);
		
		//send request to paypal for express checkout
		$PayPalResult = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);

		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{   
			redirect(base_url(lang().'/package/paymenterror'));
		}else{
			// set flage for live and development
			$isSandBox =$this->config->item('Sandbox');
			if($isSandBox==true){		
				redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
			}else {
				redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
			}	
		}
	}
	
	
	//------------------------------------------------------------------------
	
	/*
	* @Description: This function is used to post packages renew data in paypal 
	* @return: string
	* @auther: lokendra
	*/ 
	 
	public function refunddowngradepackage(){

		// get active current cartId 
		$packageCartId   =  $this->session->userdata('refundCartId');  
		
		// get logged in user data
		$userId     =  $this->isLoginUser(); 
		
		// get user membership cart data
		$whereMemCart 	     =  array('cartId' => $packageCartId);
		$membershipCartData  =  $this->model_common->getDataFromTabel('MembershipCart', '*',  $whereMemCart, '', $orderBy='cartId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
		if(!empty($membershipCartData)){
			$membershipCartData   =  $membershipCartData[0];
		}
		
		//total price user have to pay
		$totalPrice = $membershipCartData->totalPrice;
		
		//membership order send data prepare
		$membershipOrderData[]  = array(
			'productTitle' => 'Membership Renew',
			'totalPrice' => $totalPrice,
		);
	
		//SECFields
		$paypalField = array(
		'token' => '', 			// A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
		'returnurl' => base_url('en/membershipcart/payments_pro/refundpackageprocess'), 		// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
		'cancelurl' => base_url('en/payment/process/canceltransaction'), 		// Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
		'solutiontype' => 'Sole',
		);

		// get randon invoice number
		$invoieNumber = $this->createInvNo();			

		//define default array
		$paypaylPaymentArray = array();
		
		// set payment details
		$paymentDetails = array(
			'amt' => number_format($totalPrice,2), 	// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
			'currencycode' => $this->config->item('toadCurrency'), 		// A three-character currency code.  Default is USD.
			'custom' => $packageCartId, 			// Free-form field for your own use.  256 char max.
			'invnum' => $invoieNumber,
			'notifyurl' => base_url('en/payments_pro/handleIpnResponse')				// Your own invoice or tracking number.  127 char m
		);

		// default payment order item array
		$paymentOrderItems = array();

		//prepare payment order  item data for paypal
		if(!empty($membershipOrderData)){
			foreach($membershipOrderData as $membershipOrder){
				$Item     =   array(
					'name'  =>  $membershipOrder['productTitle'], 		// Item title. 127 char max.
					'desc'  =>  'Refund Toadsquare Membership Package', 		// Item description. 127 char max.
					'amt'   =>  number_format($membershipOrder['totalPrice'],2)				
				);

				//push data in payment order item array 
				array_push($paymentOrderItems, $Item);	
			}
		}
	 
		// add data in payment details 
		$paymentDetails['order_items'] = $paymentOrderItems;
		
		//push payment details in paypal palment array
		array_push($paypaylPaymentArray, $paymentDetails);	
		
		//prepre paypal request array data
		$PayPalRequestData = array(
			'SECFields' => $paypalField,
			'Payments' => $paypaylPaymentArray,
			//'BillingAddress' => $BillingAddress, 
			//'ShipToAddress' => $ShippingAddress,
		);
		
		//send request to paypal for express checkout
		$PayPalResult = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);

		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{   
			redirect(base_url(lang().'/package/paymenterror'));
		}else{
			// set flage for live and development
			$isSandBox =$this->config->item('Sandbox');
			if($isSandBox==true){		
				redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
			}else {
				redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
			}	
		}
	}
	
	//--------------------------------------------------------------------------

	/*
	* @Description: This function is use return express checkout process 
	* @return string
	*/
	function return_express_checkout(){
		$token = $_GET['token'];		
		$r = $this->Get_express_checkout_details($token);
	}
	
	//--------------------------------------------------------------------------
	
	/*
	 * @Description: This function is use to container purchase data save
	 * @return void
	 */ 
	
	function Get_express_checkout_details($token){			
		$PayPalResults = $this->paypal_pro->GetExpressCheckoutDetails($token);

		if(!$this->paypal_pro->APICallSuccessful($PayPalResults['ACK'])){
		
		 //  echo "Error in Transaction."; 
			//echo "<pre/>";
			//print_r($PayPalResult);
			//$errors = array('Errors'=>$PayPalResult['ERRORS']);
			redirect(base_url(lang().'/package/paymenterror'));
			
		}else{
			//success here 
			$PayPalResult = $this->Do_express_checkout_payment($PayPalResults);
			$invoiceId	 = $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];
			
		if(isset($invoiceId) && ($invoiceId!='')){	
			
			$orderId = Modules::run("membershipcart/saveOrder",$PayPalResults);		
			
			$getItemId	 = $PayPalResult['REQUESTDATA']['PAYMENTREQUEST_0_CUSTOM'];		
			
			$getPayPalData = json_encode($PayPalResult);
			
			$invoiceData = array('ordNumber' => $invoiceId, 'paypalTransectionInfo'=>$getPayPalData);
			
			$this->model_membershipcart->membershipInvoiceNumberUpdate($getItemId,$invoiceData);
			
			/* Add Payer Id in Order Table */
			$payerPaypalId = $this->Get_payerPaypalID($invoiceId);
			
			$dataUpdate['paypalEmail'] =  $payerPaypalId;				
			$this->model_common->editDataFromTabel('MembershipOrder', $dataUpdate, 'cartId', $getItemId);
			/* End */		
			
			
			$this->insertSalesOrderInvoice($invoiceId);
			
			$insert['transactionId'] =  $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];	
			$insert['amount'] =  (isset($PayPalResult['PAYMENTS'][0]['AMT']) && ($PayPalResult['PAYMENTS'][0]['AMT']!='')) ? $PayPalResult['PAYMENTS'][0]['AMT']: 0;	
			$insert['feesamount'] = (isset($PayPalResult['PAYMENTS'][0]['FEEAMT']) && ($PayPalResult['PAYMENTS'][0]['FEEAMT']!='')) ? $PayPalResult['PAYMENTS'][0]['FEEAMT'] : 0;
			$insert['currencycode'] = (isset($PayPalResult['PAYMENTS'][0]['CURRENCYCODE']) && ($PayPalResult['PAYMENTS'][0]['CURRENCYCODE']!='')) ? $PayPalResult['PAYMENTS'][0]['CURRENCYCODE'] :''; 
			$insert['paymentstatus'] = (isset($PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS']) && ($PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS']!='')) ? $PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS'] : ''; 
			$insert['pendingreason'] =(isset($PayPalResult['PAYMENTS'][0]['PENDINGREASON']) && ($PayPalResult['PAYMENTS'][0]['PENDINGREASON']!='')) ? $PayPalResult['PAYMENTS'][0]['PENDINGREASON'] : ''; 
			$insert['reasoncode'] = (isset($PayPalResult['PAYMENTS'][0]['REASONCODE']) && ($PayPalResult['PAYMENTS'][0]['REASONCODE']!='')) ? $PayPalResult['PAYMENTS'][0]['REASONCODE'] : ''; 
			$txnId = $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];			
			
			$this->insertMembershipPaypalInfo($insert,$txnId);
			
			//this module call for sending invoice to email
			Modules::run("membershipcart/membershipInvoiceEmail",$orderId);
			
			$this->model_membershipcart->delete_temp_membership_item($getItemId);
			//	echo  Modules::run("membershipcart/thankyouMessage",$PayPalResult);
			redirect(base_url('membershipcart/confirmation/'.$invoiceId));	
			
		 }else
			{ 
				 return redirect(base_url(lang().'/payment/process/canceltransaction'));			  
			}
		}
	}
	
	//--------------------------------------------------------------------------

	/*
	 * @Description: This function is use return package return process 
	 * @return string
	 */


	function packagereturnprocess(){
		$token = $_GET['token'];		
		//call payment checkout method
		$this->packagecheckoutprocess($token);
	}
	
	//-------------------------------------------------------------------------
	
	/*
	 * @Description: This function is used return save "Package Purchase" data save
	 * @return void 
	 */ 
	
	function packagecheckoutprocess($token){			
			
		$PayPalResults = $this->paypal_pro->GetExpressCheckoutDetails($token);

		if(!$this->paypal_pro->APICallSuccessful($PayPalResults['ACK'])){
			redirect(base_url(lang().'/package/paymenterror'));
		}
		else
		{
			//success here 
			$PayPalResult = $this->Do_express_checkout_payment($PayPalResults);
			$invoiceId	 = $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];
			
			if(isset($invoiceId) && ($invoiceId!='')){	

				//save selected package data
				$orderId = Modules::run("membershipcart/packageordersave",$PayPalResults);
				
				$getItemId	 = $PayPalResult['REQUESTDATA']['PAYMENTREQUEST_0_CUSTOM'];		

				$getPayPalData = json_encode($PayPalResult);

				$invoiceData = array('ordNumber' => $invoiceId, 'paypalTransectionInfo'=>$getPayPalData);

				$this->model_membershipcart->membershipInvoiceNumberUpdate($getItemId,$invoiceData);

				/* Add Payer Id in Order Table */
				$payerPaypalId = $this->Get_payerPaypalID($invoiceId);

				$dataUpdate['paypalEmail'] =  $payerPaypalId;				
				$this->model_common->editDataFromTabel('MembershipOrder', $dataUpdate, 'cartId', $getItemId);
				/* End */		

				$this->insertSalesOrderInvoice($invoiceId);

				$insert['transactionId']     =  $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];	
				$insert['amount']            =  (isset($PayPalResult['PAYMENTS'][0]['AMT']) && ($PayPalResult['PAYMENTS'][0]['AMT']!='')) ? $PayPalResult['PAYMENTS'][0]['AMT']: 0;	
				$insert['feesamount']        =  (isset($PayPalResult['PAYMENTS'][0]['FEEAMT']) && ($PayPalResult['PAYMENTS'][0]['FEEAMT']!='')) ? $PayPalResult['PAYMENTS'][0]['FEEAMT'] : 0;
				$insert['currencycode']      =  (isset($PayPalResult['PAYMENTS'][0]['CURRENCYCODE']) && ($PayPalResult['PAYMENTS'][0]['CURRENCYCODE']!='')) ? $PayPalResult['PAYMENTS'][0]['CURRENCYCODE'] :''; 
				$insert['paymentstatus']     =  (isset($PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS']) && ($PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS']!='')) ? $PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS'] : ''; 
				$insert['pendingreason']     =  (isset($PayPalResult['PAYMENTS'][0]['PENDINGREASON']) && ($PayPalResult['PAYMENTS'][0]['PENDINGREASON']!='')) ? $PayPalResult['PAYMENTS'][0]['PENDINGREASON'] : ''; 
				$insert['reasoncode']        =  (isset($PayPalResult['PAYMENTS'][0]['REASONCODE']) && ($PayPalResult['PAYMENTS'][0]['REASONCODE']!='')) ? $PayPalResult['PAYMENTS'][0]['REASONCODE'] : ''; 
				$txnId                       =  $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];			

				$this->insertMembershipPaypalInfo($insert,$txnId);

				//this module call for sending invoice to email
				Modules::run("membershipcart/membershipInvoiceEmail",$orderId);

				// delete temp data from membershipCart/membershipCartItem tabel
				$this->model_membershipcart->delete_temp_membership_item($getItemId);
				
				//--------allowed to see welcome screen if payment sucess---------//
				$packagesubstage   =  $this->session->userdata('packagesubstage'); # get sub stage array
				array_push($packagesubstage,"4"); # push stage next
				$this->session->set_userdata('packagesubstage',$packagesubstage); # set sub stage   
				
				//redirect(base_url('package/paidjoined/'.$invoiceId));	
				redirect(base_url('package/paidjoined'));	
			}
			else
			{ 
				redirect(base_url(lang().'/payment/process/canceltransaction'));			  
			}
		}
	}
	
	//--------------------------------------------------------------------------

	/*
	 * @Description: This function is use return "Package Renew" return process 
	 * @return string
	 */
	
	 function renewpackageprocess(){
		$token = $_GET['token'];		
		// call payment checkout method
		$this->renewpackagecheckoutprocess($token);
	}
	
	//-------------------------------------------------------------------------
	
	/*
	 * @Description: This function is used return save "Package Renew" data save
	 * @return void 
	 */ 
	
	function renewpackagecheckoutprocess($token){
			
		$PayPalResults = $this->paypal_pro->GetExpressCheckoutDetails($token);

		if(!$this->paypal_pro->APICallSuccessful($PayPalResults['ACK'])){
			redirect(base_url(lang().'/package/paymenterror'));
		}
		else
		{
			//success here 
			$PayPalResult = $this->Do_express_checkout_payment($PayPalResults);
			$invoiceId	 = $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];
			
			if(isset($invoiceId) && ($invoiceId!='')){	

				//save selected package data
				$orderId = Modules::run("membershipcart/renewordersave",$PayPalResults);
				
				$getItemId	 = $PayPalResult['REQUESTDATA']['PAYMENTREQUEST_0_CUSTOM'];		

				$getPayPalData = json_encode($PayPalResult);

				$invoiceData = array('ordNumber' => $invoiceId, 'paypalTransectionInfo'=>$getPayPalData);

				$this->model_membershipcart->membershipInvoiceNumberUpdate($getItemId,$invoiceData);

				/* Add Payer Id in Order Table */
				$payerPaypalId = $this->Get_payerPaypalID($invoiceId);

				$dataUpdate['paypalEmail'] =  $payerPaypalId;				
				$this->model_common->editDataFromTabel('MembershipOrder', $dataUpdate, 'cartId', $getItemId);
				/* End */		

				$this->insertSalesOrderInvoice($invoiceId);

				$insert['transactionId']     =  $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];	
				$insert['amount']            =  (isset($PayPalResult['PAYMENTS'][0]['AMT']) && ($PayPalResult['PAYMENTS'][0]['AMT']!='')) ? $PayPalResult['PAYMENTS'][0]['AMT']: 0;	
				$insert['feesamount']        =  (isset($PayPalResult['PAYMENTS'][0]['FEEAMT']) && ($PayPalResult['PAYMENTS'][0]['FEEAMT']!='')) ? $PayPalResult['PAYMENTS'][0]['FEEAMT'] : 0;
				$insert['currencycode']      =  (isset($PayPalResult['PAYMENTS'][0]['CURRENCYCODE']) && ($PayPalResult['PAYMENTS'][0]['CURRENCYCODE']!='')) ? $PayPalResult['PAYMENTS'][0]['CURRENCYCODE'] :''; 
				$insert['paymentstatus']     =  (isset($PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS']) && ($PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS']!='')) ? $PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS'] : ''; 
				$insert['pendingreason']     =  (isset($PayPalResult['PAYMENTS'][0]['PENDINGREASON']) && ($PayPalResult['PAYMENTS'][0]['PENDINGREASON']!='')) ? $PayPalResult['PAYMENTS'][0]['PENDINGREASON'] : ''; 
				$insert['reasoncode']        =  (isset($PayPalResult['PAYMENTS'][0]['REASONCODE']) && ($PayPalResult['PAYMENTS'][0]['REASONCODE']!='')) ? $PayPalResult['PAYMENTS'][0]['REASONCODE'] : ''; 
				$txnId                       =  $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];			

				$this->insertMembershipPaypalInfo($insert,$txnId);

				//this module call for sending invoice to email
				Modules::run("membershipcart/membershipInvoiceEmail",$orderId);

				// delete temp data from membershipCart/membershipCartItem tabel
				$this->model_membershipcart->delete_temp_membership_item($getItemId);
				
				//--------allowed to see welcome screen if payment sucess for renew---------//
				$renewsubstage   =  $this->session->userdata('renewsubstage'); # get sub stage renew array
				array_push($renewsubstage,"3"); # push stage next
				$this->session->set_userdata('renewsubstage',$renewsubstage); # set sub stage renew   
				
				redirect(base_url('package/renewsuccess'));	
			}
			else
			{ 
				redirect(base_url(lang().'/payment/process/canceltransaction'));			  
			}
		}
	}
	
	
	//--------------------------------------------------------------------------

	/*
	 * @Description: This function is use return "Package Renew" return process 
	 * @return string
	 */
	
	 function refundpackageprocess(){
		$token = $_GET['token'];		
		// call payment checkout method
		$this->refundpackagecheckoutprocess($token);
	}
	
	//-------------------------------------------------------------------------
	
	/*
	 * @Description: This function is used return save "Package Renew" data save
	 * @return void 
	 */ 
	
	function refundpackagecheckoutprocess($token){
		
		$userId     =  isLoginUser(); # get logged user id 
			
		$PayPalResults = $this->paypal_pro->GetExpressCheckoutDetails($token);

		if(!$this->paypal_pro->APICallSuccessful($PayPalResults['ACK'])){
			redirect(base_url(lang().'/package/paymenterror'));
		}
		else
		{
			//success here 
			$PayPalResult = $this->Do_express_checkout_payment($PayPalResults);
			$invoiceId	 = $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];
			
			if(isset($invoiceId) && ($invoiceId!='')){	

				//save selected package data
				$orderId = Modules::run("membershipcart/renewordersave",$PayPalResults);
				
				$getItemId	 = $PayPalResult['REQUESTDATA']['PAYMENTREQUEST_0_CUSTOM'];		

				$getPayPalData = json_encode($PayPalResult);

				$invoiceData = array('ordNumber' => $invoiceId, 'paypalTransectionInfo'=>$getPayPalData);

				$this->model_membershipcart->membershipInvoiceNumberUpdate($getItemId,$invoiceData);

				/* Add Payer Id in Order Table */
				$payerPaypalId = $this->Get_payerPaypalID($invoiceId);

				$dataUpdate['paypalEmail'] =  $payerPaypalId;				
				$this->model_common->editDataFromTabel('MembershipOrder', $dataUpdate, 'cartId', $getItemId);
				/* End */		

				$this->insertSalesOrderInvoice($invoiceId);

				$insert['transactionId']     =  $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];	
				$insert['amount']            =  (isset($PayPalResult['PAYMENTS'][0]['AMT']) && ($PayPalResult['PAYMENTS'][0]['AMT']!='')) ? $PayPalResult['PAYMENTS'][0]['AMT']: 0;	
				$insert['feesamount']        =  (isset($PayPalResult['PAYMENTS'][0]['FEEAMT']) && ($PayPalResult['PAYMENTS'][0]['FEEAMT']!='')) ? $PayPalResult['PAYMENTS'][0]['FEEAMT'] : 0;
				$insert['currencycode']      =  (isset($PayPalResult['PAYMENTS'][0]['CURRENCYCODE']) && ($PayPalResult['PAYMENTS'][0]['CURRENCYCODE']!='')) ? $PayPalResult['PAYMENTS'][0]['CURRENCYCODE'] :''; 
				$insert['paymentstatus']     =  (isset($PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS']) && ($PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS']!='')) ? $PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS'] : ''; 
				$insert['pendingreason']     =  (isset($PayPalResult['PAYMENTS'][0]['PENDINGREASON']) && ($PayPalResult['PAYMENTS'][0]['PENDINGREASON']!='')) ? $PayPalResult['PAYMENTS'][0]['PENDINGREASON'] : ''; 
				$insert['reasoncode']        =  (isset($PayPalResult['PAYMENTS'][0]['REASONCODE']) && ($PayPalResult['PAYMENTS'][0]['REASONCODE']!='')) ? $PayPalResult['PAYMENTS'][0]['REASONCODE'] : ''; 
				$txnId                       =  $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];			

				$this->insertMembershipPaypalInfo($insert,$txnId);

				//this module call for sending invoice to email
				Modules::run("membershipcart/membershipInvoiceEmail",$orderId);

				// delete temp data from membershipCart/membershipCartItem tabel
				$this->model_membershipcart->delete_temp_membership_item($getItemId);
				
				//refund action do (1/3) membership to free
			    redirect(base_url(lang().'/package/refundactiondo'));
				
			}
			else
			{ 
				redirect(base_url(lang().'/payment/process/canceltransaction'));			  
			}
		}
	}
	
	//-------------------------------------------------------------------------
	/*
	 * @Description: This function is use to create random invoice id 
	 * @return string
	 */

	function createInvNo(){	
	
		// create random Capital letters	  	
		$len = 1;
		$alphabase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$max = strlen($alphabase) - 1;
		$alphacode = '';
		mt_srand((double) microtime() * 1000000);
		while (strlen($alphacode) < $len + 1) {
			$alphacode.=$alphabase{mt_rand(0, $max)};        
		}

		// create random no's
		$len = 7; 	
		$numericcode = '';  
		$numericbase = "123456789";
		$max = strlen($numericbase) - 1;
		mt_srand((double) microtime() * 1000000);
		while (strlen($numericcode) < $len + 1) {
			$numericcode.=$numericbase{mt_rand(0, $max)};        
		}
		return  $alphacode.$numericcode; 
	}
	 
	//-------------------------------------------------------------------------
	
	/*
	 * @Description: This function is used to sales order invoice data 
	 * @return bool
	 */ 
	 
	function insertSalesOrderInvoice($invoiceId)
	{ 
		$result = $this->model_common->getDataFromTabel('MembershipOrder', 'orderId',  array('ordNumber' =>$invoiceId),'','','',1);			
		$ordId =  $result[0]->orderId;			

		$insert['ordId'] = $ordId;	
		$insert['receiverTransactionId'] =$invoiceId;
		$insert['type'] =1;
		$res = $this->model_common->getDataFromTabel('SalesOrderInvoice', 'id',  array('ordId' =>$ordId,'receiverTransactionId'=>$invoiceId),'','','',1);					

		if(($res) && isset($res[0]->id) && ($res[0]->id!='') ){
			//$this->model_common->editDataFromTabel('MembershipCartItem', $data, 'memItemId', $res[0]->tsProductId); 					
		}else{			
			$this->db->insert('SalesOrderInvoice', $insert); 
		}

		return true;		 	
	}
	 
	//-------------------------------------------------------------------------
	
	/*
	 * @Description: This function is used to insert membership paypal info 
	 * @return bool
	 */ 
	 
	function insertMembershipPaypalInfo($insert,$transId)
	{
		$res = $this->model_common->getDataFromTabel('MembershipPaypalInfo', 'id',  array('transactionId'=>$transId),'','','',1);					
		if(($res) && isset($res[0]->id) && ($res[0]->id!='') ){
			$this->model_common->editDataFromTabel('MembershipPaypalInfo', $insert, 'transactionId', $transId); 					
		}else{			
			$this->db->insert('MembershipPaypalInfo', $insert); 
		}
		return true;	
	}
	
	//-------------------------------------------------------------------------
	
	/* Handle IPN RESPONSE */		 
	function handleIpnResponse(){
		
		$transId =   $this->input->post('txn_id:') ;	
		
		//Send test email
		Modules::run("membershipcart/sendTestEmail",$transId); // send email for test methode calling
			
		//$transId = '7CL32572G6923414L';
		$PayPalResult = $this->Get_transaction_details($transId);
		
		 if($PayPalResult!=''){		  
			
			$insert['transactionId'] =  $PayPalResult['TRANSACTIONID'];	
			$insert['amount'] =  (isset($PayPalResult['AMT']) && ($PayPalResult['AMT']) ) ? $PayPalResult['AMT']  :0;
			$insert['feesamount'] = (isset($PayPalResult['feesamount']) && ($PayPalResult['feesamount']) ) ? $PayPalResult['feesamount']  :0; 
			$insert['currencycode'] = (isset($PayPalResult['CURRENCYCODE']) && ($PayPalResult['CURRENCYCODE']) ) ? $PayPalResult['CURRENCYCODE']  :'';
			$insert['paymentstatus'] = (isset($PayPalResult['PAYMENTSTATUS']) && ($PayPalResult['PAYMENTSTATUS']) ) ? $PayPalResult['PAYMENTSTATUS']  :'';
			$insert['pendingreason'] = (isset($PayPalResult['PENDINGREASON']) && ($PayPalResult['PENDINGREASON']) ) ? $PayPalResult['PENDINGREASON']  :'';
			$insert['reasoncode'] =  (isset($PayPalResult['REASONCODE']) && ($PayPalResult['REASONCODE']) ) ? $PayPalResult['REASONCODE'] :'';			
			$insert['date'] =  (isset($PayPalResult['ORDERTIME']) && ($PayPalResult['ORDERTIME']) ) ? $PayPalResult['ORDERTIME'] :'';			
			$txnId = $PayPalResult['TRANSACTIONID'];			
				
			$this->insertMembershipPaypalInfo($insert,$txnId);
			return true;		
			} else{		   
				return false;		   
			}		
	}	
	
	/* Free Renew */
	
	function freeRenew(){
		$userId=$this->isloginUser();
		 $cartId=$this->session->userdata('currentCartId');	 
		 Modules::run("membershipcart/saveFreeOrder",$cartId);
				
		//$getItemId	 = $PayPalResult['REQUESTDATA']['PAYMENTREQUEST_0_CUSTOM'];
		
		$invoiceId	 = $this->createInvNo();			
		
		$invoiceData = array('ordNumber' => $invoiceId);
		
		$this->model_membershipcart->membershipInvoiceNumberUpdate($cartId,$invoiceData);
		
		$this->insertSalesOrderInvoice($invoiceId);			
		
		//this module call for sending invoice to email
		//Modules::run("membershipcart/membershipInvoiceEmail",$getItemId,0);
				
		$this->model_membershipcart->delete_temp_membership_item($cartId);
		//	echo  Modules::run("membershipcart/thankyouMessage",$PayPalResult);
		redirect(base_url('membershipcart/confirmation/'.$invoiceId));	
		
		}	
	
	
	
	/* Remove Refunded Item */
	
	function updateRefundedItem($containerId=0,$orderId=0) {
		$this->load->model('model_membershipcart');
		$res=$this->model_common->getDataFromTabel('UserMembershipItem', 'type',  array('userContainerId'=>$containerId,'orderId'=>$orderId),'','','',1);		 

		// @Type  1- Add New  2- Add Space 3- Renew

		if($res[0]->type!=1) {		 

			$refundedSize = $this->model_membershipcart->getRefundItemSize($containerId,$orderId);				    
			$row=$this->model_common->getDataFromTabel('UserContainer', 'containerSize',  array('userContainerId'=>$containerId),'','','',1);

			$containerCurrentSize =  $row[0]->containerSize - $refundedSize->size;

			$dataU['containerSize'] =  $containerCurrentSize;				
			$this->model_common->editDataFromTabel('UserContainer', $dataU, 'userContainerId', $containerId);

		} else{
			$update['containerStatus']='f' ;
			$this->model_common->editDataFromTabel('UserContainer', $update, 'userContainerId', $containerId);	
		}

	}
		 
	//------------------------------------------------------------------------
	
	/*
	 * @Description: This function is used Insert data in refund 
	 * transaction table
	 * @return paypal result data
	 */ 
 
	function insertRefundDetails($insert){
		$this->db->insert('RefundTransactions', $insert); 	 
	}

	//------------------------------------------------------------------------
	 
	/*
	 * @Description: This function is used to get paypal data
	 * @return paypal result data
	 */ 
	 
	function Get_payerPaypalID($transId='')
	{
		
		$GTDFields        =   array(
			'transactionid' =>  $transId		// PayPal transaction ID of the order you want to get details for.
		);

		$PayPalRequestData = array('GTDFields' => $GTDFields);		
		$PayPalResult = $this->paypal_pro->GetTransactionDetails($PayPalRequestData);

		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			return $PayPalResult['EMAIL']='';
		}
		else
		{ 
			return $PayPalResult['EMAIL'];
		}
	} 
	 
	//------------------------------------------------------------------------
	 
	/*
	 * @Description: This function is used to refund degrade package 
	 * @return paypal result data
	 */ 
	 
	 function refundDegradeAmount() {
			
		$userId = $this->isLoginUser();
		/* get users last 3 year order data */
		$orderData   =  $this->model_membershipcart->getLastThirdYearOrder($userId,$this->config->item('package_3_year_id'));
		
		$transactionid  = $orderData->transactionid;
		$amt            = $orderData->price;
		$requestOrderId = $orderData->orderId;		
		$containerId    = 0;
		
		$RTFields = array(
				'transactionid'       => $transactionid, 	// Required.  PayPal transaction ID for the order you're refunding.
				'invoiceid'           => '', 			    // Your own invoice tracking number.
				'refundtype'          => 'Partial', 		// Required.  Type of refund.  Must be Full, Partial, or Other.
				'amt'                 => $amt, 			// Refund Amt.  Required if refund type is Partial.  
				'currencycode'        => $this->config->item('toadCurrency'), 			// Three-letter currency code.  Required for Partial Refunds.  Do not use for full refunds.
				'note'                => '',  			// Custom memo about the refund.  255 char max.
				'retryuntil'          => '', 				// Maximum time until you must retry the refund.  Note:  this field does not apply to point-of-sale transactions.
				'refundsource'        => '', 				// Type of PayPal funding source (balance or eCheck) that can be used for auto refund.  Values are:  any, default, instant, eCheck
				'merchantstoredetail' => '', 			    // Information about the merchant store.
				'refundadvice'        => '', 				// Flag to indicate that the buyer was already given store credit for a given transaction.  Values are:  1/0
				'refunditemdetails'   => '', 		     	// Details about the individual items to be returned.
				'storeid'             => '', 				// ID of a merchant store.  This field is required for point-of-sale transactions.  50 char max.
				'terminalid'          => ''				// ID of the terminal.  50 char max.
			);	
				
		$PayPalRequestData = array('RTFields' => $RTFields);
		
		$PayPalResult = $this->paypal_pro->RefundTransaction($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
			$refundReturn = false;
			//$errors = array('Errors'=>$PayPalResult['ERRORS']);
			//$this->load->view('paypal_error',$errors);
		} else {
			
			$paypalJasonInfo = json_encode($PayPalResult);

			$userId=isloginUser(); 
			$refundTransactionId = $PayPalResult['REFUNDTRANSACTIONID'];
			$insert['refundTransactionId'] = $refundTransactionId;
			$insert['feeRefundAmt'] = $PayPalResult['FEEREFUNDAMT'];			
			$insert['date'] = $PayPalResult['TIMESTAMP'];		
			$insert['userContainerId'] = $containerId;		
			$insert['orderId'] = $requestOrderId;
			$insert['refundedAmount'] = $amt;
			$insert['userId']         = $userId;

			$data['refundTransactionId'] = $refundTransactionId;
			$data['orderId'] = $requestOrderId;
			$data['userContainerId'] = $containerId;			
			$data['amt'] = $amt;
			$data['paypalJasonInfo'] = $paypalJasonInfo;


			$latestOrderId = Modules::run("membershipcart/saveRefundDegradeOrder",$data);		    

			$this->insertSalesOrderInvoice($refundTransactionId);
			// $this->insertRefundDetails($insert);
			$this->updateRefundedItem($containerId,$requestOrderId); 	

			//this module call for sending refund invoice on email and tamil
			Modules::run("membershipcart/membershipInvoiceEmail",$latestOrderId);	   

			$refundReturn = true;
			// Successful call.  Load view or whatever you need to do here.	
		}
		return $refundReturn;
	}
	
	//------------------------------------------------------------------------
	
	/*
	* @Description: This function is used to post wizard cart data in paypal 
	* @access: public
	* @author: Tosif Qureshi
	* @return: void
	*/ 
	 
	public function mediacartpayment() {

		// get active current cartId 
		$mediaCartId   =  $this->session->userdata('mediaCartId'); 
		// get logged in user data
		$userId     =  $this->isLoginUser(); 
		// get user membership cart data
		$whereMemCart 	     =  array('cartId' => $mediaCartId);
		$membershipCartData  =  $this->model_common->getDataFromTabel('MembershipCart', '*',  $whereMemCart, '', $orderBy='cartId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
		if(!empty($membershipCartData)) {
			$membershipCartData   =  $membershipCartData[0];
		}
		
		//total price user have to pay
		$totalPrice = $membershipCartData->totalPrice;
		// set title and description of package 
		$productTitle = $this->lang->line('mediaShowcase');
		$desc = $this->lang->line('storageSpace');
		
		// order send data prepare
		$membershipOrderData[]  = array(
			'productTitle' => $productTitle,
			'totalPrice' => $totalPrice,
		);
	
		//SECFields
		$paypalField = array(
			'token'        => '', 	// A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
			'returnurl'    => base_url('en/membershipcart/payments_pro/mediareturnpayment'), // Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
			'cancelurl'    => base_url('en/payment/process/canceltransaction'), // Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
			'solutiontype' => 'Sole',
		);

		// get randon invoice number
		$invoieNumber = $this->createInvNo();			
		//define default array
		$paypaylPaymentArray = array();
		
		// set payment details
		$paymentDetails = array(
			'amt'          => number_format($totalPrice,2), 	// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
			'currencycode' => $this->config->item('toadCurrency'), 		// A three-character currency code.  Default is USD.
			'custom'       => $packageCartId, 			// Free-form field for your own use.  256 char max.
			'invnum'       => $invoieNumber,
			'notifyurl'    => base_url('en/payments_pro/handleIpnResponse')				// Your own invoice or tracking number.  127 char m
		);
		
		// default payment order item array
		$paymentOrderItems = array();

		//prepare payment order  item data for paypal
		if(!empty($membershipOrderData)) {
			foreach($membershipOrderData as $membershipOrder) {
				$Item   =   array(
				'name'  =>  $productTitle, // Item title. 127 char max.
				'desc'  =>  $desc, 		   // Item description. 127 char max.
				'amt'   =>  number_format($membershipOrder['totalPrice'],2)				
				);

				//push data in payment order item array 
				array_push($paymentOrderItems, $Item);	
			}
		}
	 
		// add data in payment details 
		$paymentDetails['order_items'] = $paymentOrderItems;
		
		//push payment details in paypal palment array
		array_push($paypaylPaymentArray, $paymentDetails);	
	
		//prepre paypal request array data
		$PayPalRequestData = array(
			'SECFields' => $paypalField,
			'Payments' => $paypaylPaymentArray,
		);
		
		//send request to paypal for express checkout
		$PayPalResult = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);
		// get wizard media section
		$mediaSection = $this->session->userdata('wizardMediaSection');
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {   
			redirect(base_url(lang().'/media/'.$mediaSection.'/paymenterror'));
		} else {
			// set flage for live and development
			$isSandBox =$this->config->item('Sandbox');
			if($isSandBox==true) {		
				redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
			} else {
				redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
			}	
		}
	}
	
	//--------------------------------------------------------------------------

	/*
	 * @Description: This function is use return "Media showcase" return process 
	 * @access: public
	 * @author: Tosif Qureshi
	 * @return: void
	 */
	
	public function mediareturnpayment() {
		$token = $_GET['token'];		
		// call payment checkout method 
		$this->mediareturncheckoutPayment($token);
	}
	
	//-------------------------------------------------------------------------
	
	/*
	 * @Description: This function is used return save "Media showcase" data save
	 * @access: private
	 * @author: Tosif Qureshi
	 * @return: void 
	 */ 
	
	private function mediareturncheckoutPayment($token) {
			
		$PayPalResults = $this->paypal_pro->GetExpressCheckoutDetails($token);
		// get wizard media section
		$mediaSection = $this->session->userdata('wizardMediaSection');
		if(!$this->paypal_pro->APICallSuccessful($PayPalResults['ACK'])) {
			redirect(base_url(lang().'/media/'.$mediaSection.'/paymenterror'));
		} else {
			//success here 
			$PayPalResult = $this->Do_express_checkout_payment($PayPalResults);
			
			$invoiceId	 = $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];
			
			if(isset($invoiceId) && ($invoiceId!='')) {
				// get session media cart id
				$sessionCartId = $this->session->userdata('mediaCartId');
				if(!empty($sessionCartId)) {
					$getItemId =  $sessionCartId;
				} else {
					$getItemId	 = $PayPalResult['REQUESTDATA']['PAYMENTREQUEST_0_CUSTOM'];	
				}
				// save selected package data
				$orderId = Modules::run("membershipcart/mediawizardordersave",$PayPalResults);
				// manage invoice and paypal data
				$this->managemediainvoicedata($invoiceId,$orderId,$getItemId,$PayPalResult);
				// set project id in session for renew container
				$renewProjectId  = $this->session->userdata('renewProjectId');
				if(empty($renewProjectId)) { // send mails exept renew container
					// this module call for sending invoice to email
					Modules::run("membershipcart/membershipInvoiceEmail",$orderId);
				}

				// delete temp data from membershipCart/membershipCartItem tabel
				$this->model_membershipcart->delete_temp_membership_item($getItemId);
				// unset media cart id
				$this->session->unset_userdata('mediaCartId');
                // get session id of showcase if exists
                $addSpaceShowcaseId   = $this->session->userdata('addSpaceShowcaseId'); 
                if(!empty($addSpaceShowcaseId)) {
                    redirect(base_url('showcase/paymentsuccess'));
                } else {
                    redirect(base_url('media/'.$mediaSection.'/paymentsuccess'));
                }
					
			} else { 
				redirect(base_url(lang().'/payment/process/canceltransaction'));			  
			}
		}
	}
	
	//-------------------------------------------------------------------------
	
	/*
	 * @Description: This function is used manage Invoice and paypal info saving
	 * @access: private
	 * @author: Tosif Qureshi
	 * @return: void 
	 */ 
	
	private function managemediainvoicedata($invoiceId,$orderId,$getItemId,$PayPalResult) {
		
		
		// prepare and store invoice details
		$getPayPalData = json_encode($PayPalResult);
		$invoiceData = array('ordNumber' => $invoiceId, 'paypalTransectionInfo'=>$getPayPalData);
		$this->model_membershipcart->membershipInvoiceNumberUpdate($getItemId,$invoiceData);

		// get paypal payer id 
		$payerPaypalId = $this->Get_payerPaypalID($invoiceId);
		// update paypal payer id in order info
		$dataUpdate['paypalEmail'] =  $payerPaypalId;				
		$this->model_common->editDataFromTabel('MembershipOrder', $dataUpdate, 'cartId', $getItemId);		

		$this->insertSalesOrderInvoice($invoiceId);
		// prepare paypal transactions data to store
		$insert['transactionId']     =  $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];	
		$insert['amount']            =  (isset($PayPalResult['PAYMENTS'][0]['AMT']) && ($PayPalResult['PAYMENTS'][0]['AMT']!='')) ? $PayPalResult['PAYMENTS'][0]['AMT']: 0;	
		$insert['feesamount']        =  (isset($PayPalResult['PAYMENTS'][0]['FEEAMT']) && ($PayPalResult['PAYMENTS'][0]['FEEAMT']!='')) ? $PayPalResult['PAYMENTS'][0]['FEEAMT'] : 0;
		$insert['currencycode']      =  (isset($PayPalResult['PAYMENTS'][0]['CURRENCYCODE']) && ($PayPalResult['PAYMENTS'][0]['CURRENCYCODE']!='')) ? $PayPalResult['PAYMENTS'][0]['CURRENCYCODE'] :''; 
		$insert['paymentstatus']     =  (isset($PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS']) && ($PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS']!='')) ? $PayPalResult['PAYMENTS'][0]['PAYMENTSTATUS'] : ''; 
		$insert['pendingreason']     =  (isset($PayPalResult['PAYMENTS'][0]['PENDINGREASON']) && ($PayPalResult['PAYMENTS'][0]['PENDINGREASON']!='')) ? $PayPalResult['PAYMENTS'][0]['PENDINGREASON'] : ''; 
		$insert['reasoncode']        =  (isset($PayPalResult['PAYMENTS'][0]['REASONCODE']) && ($PayPalResult['PAYMENTS'][0]['REASONCODE']!='')) ? $PayPalResult['PAYMENTS'][0]['REASONCODE'] : ''; 
		$txnId                       =  $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];			
		// insert paypal transaction details
		$this->insertMembershipPaypalInfo($insert,$txnId);
	}
	
	
	//------------------------------------------------------------------------
	
	/*
	* @Description: This function is used to post wizard add space cart data in paypal 
	* @access: public
	* @author: Tosif Qureshi
	* @return: void
	*/ 
	 
	public function addspacecartpayment() {

		// get active current cartId 
		$cartId   =  $this->session->userdata('cartId'); 
		// get logged in user data
		$userId     =  $this->isLoginUser(); 
		// get user membership cart data
		$whereMemCart 	     =  array('cartId' => $cartId);
		$membershipCartData  =  $this->model_common->getDataFromTabel('MembershipCart', '*',  $whereMemCart, '', $orderBy='cartId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
		if(!empty($membershipCartData)) {
			$membershipCartData   =  $membershipCartData[0];
		}
		// get entity id
		$entityId = $this->session->userdata('addSpaceEntityId');
		//total price user have to pay
		$totalPrice = $membershipCartData->totalPrice;
		// set title and description of package 
		$productTitle = $this->lang->line('productTitle'.$entityId);
		$desc = $this->lang->line('storageSpace');
		
		// order send data prepare
		$membershipOrderData[]  = array(
			'productTitle' => $productTitle,
			'totalPrice' => $totalPrice,
		);
	
		//SECFields
		$paypalField = array(
			'token'        => '', 	// A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
			'returnurl'    => base_url('en/membershipcart/payments_pro/addspacereturnpayment'), // Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
			'cancelurl'    => base_url('en/payment/process/canceltransaction'), // Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
			'solutiontype' => 'Sole',
		);

		// get randon invoice number
		$invoieNumber = $this->createInvNo();			
		//define default array
		$paypaylPaymentArray = array();
		
		// set payment details
		$paymentDetails = array(
			'amt'          => number_format($totalPrice,2), 	// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
			'currencycode' => $this->config->item('toadCurrency'), 		// A three-character currency code.  Default is USD.
			'custom'       => $packageCartId, 			// Free-form field for your own use.  256 char max.
			'invnum'       => $invoieNumber,
			'notifyurl'    => base_url('en/payments_pro/handleIpnResponse')				// Your own invoice or tracking number.  127 char m
		);
		
		// default payment order item array
		$paymentOrderItems = array();

		//prepare payment order  item data for paypal
		if(!empty($membershipOrderData)) {
			foreach($membershipOrderData as $membershipOrder) {
				$Item   =   array(
				'name'  =>  $productTitle, // Item title. 127 char max.
				'desc'  =>  $desc, 		   // Item description. 127 char max.
				'amt'   =>  number_format($membershipOrder['totalPrice'],2)				
				);

				//push data in payment order item array 
				array_push($paymentOrderItems, $Item);	
			}
		}
	 
		// add data in payment details 
		$paymentDetails['order_items'] = $paymentOrderItems;
		
		//push payment details in paypal palment array
		array_push($paypaylPaymentArray, $paymentDetails);	
	
		//prepre paypal request array data
		$PayPalRequestData = array(
			'SECFields' => $paypalField,
			'Payments' => $paypaylPaymentArray,
		);
		
		//send request to paypal for express checkout
		$PayPalResult = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {   
			redirect(base_url(lang().'/blog/paymenterror'));
		} else {
			// set flage for live and development
			$isSandBox =$this->config->item('Sandbox');
			if($isSandBox==true) {		
				redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
			} else {
				redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=continue&token='.html_entity_decode($PayPalResult['TOKEN']));	
			}	
		}
	}
	
	//--------------------------------------------------------------------------

	/*
	 * @Description: This function is use return add space return process 
	 * @access: public
	 * @author: Tosif Qureshi
	 * @return: void
	 */
	
	public function addspacereturnpayment() {
		$token = $_GET['token'];		
		// call payment checkout method 
		$this->addspacereturncheckoutpayment($token);
	}
	
	//-------------------------------------------------------------------------
	
	/*
	 * @Description: This function is used return save add space data save
	 * @access: private
	 * @author: Tosif Qureshi
	 * @return: void 
	 */ 
	
	private function addspacereturncheckoutpayment($token) {
			
		$PayPalResults = $this->paypal_pro->GetExpressCheckoutDetails($token);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResults['ACK'])) {
			redirect(base_url(lang().'/membershipcart/paymenterror'));
		} else {
			//success here 
			$PayPalResult = $this->Do_express_checkout_payment($PayPalResults);
			
			$invoiceId	 = $PayPalResult['PAYMENTS'][0]['TRANSACTIONID'];
			
			if(isset($invoiceId) && ($invoiceId!='')) {
				// get session blog cart id
				$sessionCartId = $this->session->userdata('cartId');
				if(!empty($sessionCartId)) {
					$getItemId =  $sessionCartId;
				} else {
					$getItemId	 = $PayPalResult['REQUESTDATA']['PAYMENTREQUEST_0_CUSTOM'];	
				}
				// save selected package data
				$orderId = Modules::run("membershipcart/mediawizardordersave",$PayPalResults);
				// manage invoice and paypal data
				$this->managemediainvoicedata($invoiceId,$orderId,$getItemId,$PayPalResult);
				// delete temp data from membershipCart/membershipCartItem tabel
				$this->model_membershipcart->delete_temp_membership_item($getItemId);
				// unset media cart id
				$this->session->unset_userdata('cartId');
				// redirect to payment success page
				redirect(base_url(lang().'/membershipcart/paymentsuccess'));  
					
			} else { 
				redirect(base_url(lang().'/payment/process/canceltransaction'));			  
			}
		}
	}
	
}

/* End of file payments_pro.php */
/* Location: ./system/application/controllers/payments_pro.php */
