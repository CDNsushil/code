<?php

// Include required library files.


class Pay_chained extends Public_Controller 
{
	
	function __construct()
	{
		parent::__construct();

		// Load helpers
		$this->load->helper('url');
		 $this->config->load('paypal');
		
		$PayPalConfig = array(
					  'Sandbox' => $this->config->item('Sandbox'), 	
					  'DeveloperAccountEmail' => '',
					  'ApplicationID' => $this->config->item('ApplicationID'),
					  'DeviceID' => '',
					  'IPAddress' => $_SERVER['REMOTE_ADDR'],
					  'APIUsername' => $this->config->item('APIUsername'),
					  'APIPassword' => $this->config->item('APIPassword'), 
					  'APISignature' =>  $this->config->item('APISignature'),
					  'APISubject' => '',
                      'PrintHeaders' => '', 
					  'LogResults' => false, 
					  'LogPath' => '',
					);
		
		// Show Errors
		if($PayPalConfig['Sandbox'])
		{
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
		}
		$this->load->library('chainPayment/Adaptive', $PayPalConfig);
		
	}
	

	function DoChainedPayment($data)
	{
		// Prepare request arrays
		if(empty($data)){
			redirect(base_url());
		}
		$PayRequestFields = array(
								'ActionType' => 'PAY_PRIMARY', 							// Required.  Whether the request pays the receiver or whether the request is set up to create a payment request, but not fulfill the payment until the ExecutePayment is called.  Values are:  PAY, CREATE, PAY_PRIMARY
								'CancelURL' => $data['CENCEL_URL'],					// Required.  The URL to which the sender's browser is redirected if the sender cancels the approval for the payment after logging in to paypal.com.  1024 char max.
								'CurrencyCode' => $data['CURRENCYCODE'], 			// Required.  3 character currency code.
								'FeesPayer' => 'PRIMARYRECEIVER', 						// The payer of the fees.  Values are:  SENDER, PRIMARYRECEIVER, EACHRECEIVER, SECONDARYONLY
								'IPNNotificationURL' => '', 						// The URL to which you want all IPN messages for this payment to be sent.  1024 char max.
								'Memo' => '', 										// A note associated with the payment (text, not HTML).  1000 char max
								'Pin' => '', 										// The sener's personal id number, which was specified when the sender signed up for the preapproval
								'PreapprovalKey' => '', 							// The key associated with a preapproval for this payment.  The preapproval is required if this is a preapproved payment.  
								'ReturnURL' => $data['RETURN_URL'], 									// Required.  The URL to which the sener's browser is redirected after approvaing a payment on paypal.com.  1024 char max.
								'ReverseAllParallelPaymentsOnError' => '', 			// Whether to reverse paralel payments if an error occurs with a payment.  Values are:  TRUE, FALSE
								'SenderEmail' => '', 								// Sender's email address.  127 char max.
								'TrackingID' => rand(),									// Unique ID that you specify to track the payment.  127 char max.
								
								);

		$ClientDetailsFields = array(
								'CustomerID' => '', 								// Your ID for the sender  127 char max.
								'CustomerType' => '', 								// Your ID of the type of customer.  127 char max.
								'GeoLocation' => '', 								// Sender's geographic location
								'Model' => '', 										// A sub-identification of the application.  127 char max.
								'PartnerName' => ''									// Your organization's name or ID
								);
								
		$FundingTypes = array('ECHECK', 'BALANCE', 'CREDITCARD');					// Funding constrainigs require advanced permissions levels.

		$Receivers = array();
			foreach($data as $key=>$paypalData){
				if(Is_Numeric ($key)){
				$Receiver = array(
								'Amount' => $paypalData['AMT']*$data['PRODUCT_QUANTITY'], 										// Required.  Amount to be paid to the receiver.
								'Email' =>  $paypalData['PAYPAL_ID'], 							// Receiver's email address. 127 char max.
								'InvoiceID' => '', 											// The invoice number for the payment.  127 char max.
								'PaymentType' => '', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
								'PaymentSubType' => '', 									// The transaction subtype for the payment.
								'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
								'Primary' => $paypalData['PRIMARY']												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
								);
				array_push($Receivers,$Receiver);
			}
		}
		
	/*	$Receiver = array(
						'Amount' => '10.00', 											// Required.  Amount to be paid to the receiver.
						'Email' => 'mahendrayadav@cdnsol.com', 												// Receiver's email address. 127 char max.
						'InvoiceID' => '', 											// The invoice number for the payment.  127 char max.
						'PaymentType' => '', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
						'PaymentSubType' => '', 									// The transaction subtype for the payment.
						'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
						'Primary' => 'false'												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
						);
		array_push($Receivers,$Receiver); */

		/*$Receiver = array(
						'Amount' => '20.00', 											// Required.  Amount to be paid to the receiver.
						'Email' => 'drew@angelleye.com', 												// Receiver's email address. 127 char max.
						'InvoiceID' => '', 											// The invoice number for the payment.  127 char max.
						'PaymentType' => '', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
						'PaymentSubType' => '', 									// The transaction subtype for the payment.
						'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
						'Primary' => 'false'												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
						);
		array_push($Receivers,$Receiver); */

		$SenderIdentifierFields = array(
										'UseCredentials' => TRUE						// If TRUE, use credentials to identify the sender.  Default is false.
										);
										
		$AccountIdentifierFields = array(
										'Email' => '', 								// Sender's email address.  127 char max.
										'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => '')								// Sender's phone number.  Numbers only.
										);
										
		$PayPalRequestData = array(
							'PayRequestFields' => $PayRequestFields, 
							'ClientDetailsFields' => $ClientDetailsFields, 
							//'FundingTypes' => $FundingTypes, 
							'Receivers' => $Receivers, 
							'SenderIdentifierFields' => $SenderIdentifierFields, 
							'AccountIdentifierFields' => $AccountIdentifierFields
							);


		// Pass data into class for processing with PayPal and load the response array into $PayPalResult
		$PayPalResult = $this->adaptive->Pay($PayPalRequestData);

		// Write the contents of the response array to the screen for demo purposes.
	
		/*echo '<pre />';
		print_r($PayPalResult);
		die; */
		
		if(!empty($PayPalResult)){
			if(!empty($PayPalResult['Errors'])){
				$error=$PayPalResult['Errors'][0];
				$this->session->set_flashdata('error',$error['Message']);
				redirect('');
			}else{ if($PayPalResult['Ack']=='Success')
				$this->session->set_userdata('PayKey',$PayPalResult['PayKey']);
				redirect($PayPalResult['RedirectURL']);
			}
		}else{
			$this->session->set_flashdata('error','Sorry! Request Failed Please Try Again.');
			redirect('');
		}
	}
	
	function getPaymentDetails($key='',$TrackingID='')
	{
		
		// Prepare request arrays
		$PaymentDetailsFields = array(
									'PayKey' => $key, 							// The pay key that identifies the payment for which you want to retrieve details.  
									'TransactionID' => '', 						// The PayPal transaction ID associated with the payment.  
									'TrackingID' => $TrackingID							// The tracking ID that was specified for this payment in the PayRequest message.  127 char max.
									);
									
		$PayPalRequestData = array('PaymentDetailsFields' => $PaymentDetailsFields);


		// Pass data into class for processing with PayPal and load the response array into $PayPalResult
		$PayPalResult = $this->adaptive->PaymentDetails($PayPalRequestData);
		return $PayPalResult;
		// Write the contents of the response array to the screen for demo purposes.
		echo '<pre />';
		print_r($PayPalResult);
	}
	
	function sendPaymentToSecondryReciver($key)
	{
		// Prepare request arrays
		$ExecutePaymentFields = array(
									'PayKey' => $key, 								// The pay key that identifies the payment to be executed.  This is the key returned in the PayResponse message.
									'FundingPlanID' => '' 							// The ID of the funding plan from which to make this payment.
									);
									
		$PayPalRequestData = array('ExecutePaymentFields' => $ExecutePaymentFields);

		// Pass data into class for processing with PayPal and load the response array into $PayPalResult
		$PayPalResult = $this->adaptive->ExecutePayment($PayPalRequestData);
		return 	$PayPalResult ;

		// Write the contents of the response array to the screen for demo purposes.
		echo '<pre />';
		print_r($PayPalResult);
	}


}

?>
