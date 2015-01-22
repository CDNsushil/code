<?php 
/**
 * @Author : Amit Wali
 * @Email  : amitwali@cdnsol.com
 * @Timestamp : June-3-13  
 * @Copyright : www.cdnsol.com 
**/
	date_default_timezone_set('Europe/Luxembourg');
	// -- Check if file YAML file exists --
	define("BASEPATH",dirname(__FILE__));
	// -- File Extension --
	define("EXT",".php");
	ini_set('display_errors','1');
	
	define('ENVIRONMENT', 'development');
	
	//require_once '../../controllers/paypal/adaptive_payments.php';
	//include($_SERVER['DOCUMENT_ROOT'].'/toadsquare/system/core/Controller'.EXT);
	//include($_SERVER['DOCUMENT_ROOT'].'/toadsquare/application/third_party/MX/Controller'.EXT);			
	include($_SERVER['DOCUMENT_ROOT'].'/toadsquare/application/controllers/paypal_cron/adaptive_payments'.EXT);
	include($_SERVER['DOCUMENT_ROOT'].'/toadsquare/application/config/constants'.EXT);
	include('common_function'.EXT);
	include('../application/newtcpdf/config/lang/eng.php');
    include('../application/newtcpdf/tcpdf.php');
	
	
	// -- Check if file Common file exists --
	if(file_exists(dirname(__FILE__).'/inc/common'.EXT))
	{
		include(dirname(__FILE__).'/inc/common'.EXT);
		log_message("ALL","All files include successfully");
	}
	if(isset($_POST["key"]) && $_POST["key"]==config::getInst()->getKeyValue("encryption_key"))
	{
		log_message("ALL","expiryCheck will run for --> EXTERNAL (".$_SERVER["REQUESTED_URI"].")");
		
	} else {
		
		/// -- Log Message to Log file for Type of call --
		log_message("ALL","expiryCheck will run for --> INTERNAL ()");
		$db_job = savePaypalOrder();
		exit();
		
	}// -- FII :: $_POST["key"] --
	
/* Generate Sales Order */
  function savePaypalOrder(){
			  
	  $trackId = getPendingTrackId();
	  
		if($trackId) {
			
			foreach ($trackId as $tId){				
				 generateOrder($tId);			
			  }
			  	
		} else {							
			return false;
		  }		  
	}
  
 
 /* Get all pending tracking id's */ 
  function getPendingTrackId(){		 
	//where "isSent" = 0
	$db = db_connect();
	$query= pg_query($db, 'SELECT * from "TDS_PaypalTrackingLog" where "status" = false ');			
	
	if($query){
		$trackingId=array();
		while ($data = pg_fetch_assoc($query)) {
				$trackingId[]=$data['trackingId'];
			}
		return $trackingId;
	 }else{
		   return false;
		 }		
	}
	   
	 
		
  function generateOrder($trackingId) {		 
   $db = db_connect();	 
   $res = pg_query($db, 'SELECT "basketId" from "TDS_SalesCustomersBasket" where "trackingId" =\''.$trackingId.'\' ' ) ;   
   
	if($res){			
		$data = pg_fetch_object($res);			
		$basketId = $data->basketId;				
	}
	
	
	$payDetails = new Adaptive_payments();
	$getData = $payDetails->Payment_details($trackingId);	
	
	$getTransactiondata = json_decode($getData);	
	
	$res =  getTransactionId($getTransactiondata->paymentInfoList->paymentInfo);
		
	$transId = (isset($res['transactionId']) && ($res['transactionId']!='') ) ? $res['transactionId'] :0;	
		
	//$transId = $getTransactiondata->paymentInfoList->paymentInfo[0]->transactionId;	
	$paypalStatus = $getTransactiondata->responseEnvelope->ack;	
	//$transId = (isset($transId) && ($transId) ) ? $transId : 0;
		
	 $currency =getDataFromTabel('TDS_SalesBasketItem','currency','basketId',$basketId);
	 $currencyId = (isset($currency) && ($currency!='')) ? $currency :  0;  	
	
		// ADD DATA IN SalesOrderItem	 
	   $orderId = insertSalesOrder($basketId,$currencyId,$transId,$getData,$trackingId);
	   
	  if($orderId > 0 && $basketId > 0){ 
	   updateOrderPaypalLog($trackingId,$orderId); 
		// Update  DATA IN SalesOrderItem
		insertSalesOrderItem($basketId,$currencyId,$orderId,$transId);
						
			//This function call for purchased invoice send on email 
			//invoiceSendToEmail($orderId);
			//deleteBasket($trackingId);						
		}			 
		 
	 }	 


 /* Get transaction Id */	
 function getTransactionId($data){ 
   $res = array();	 	 
   foreach($data as $key => $id) {	   
	  if ( isset($id->transactionId) && $id->transactionId!='' ){
		   $res['transactionId'] =  $id->transactionId;
		   $res['transactionStatus'] =   $id->transactionStatus;
		 return $res;
	  }	 
    } 
   return false;
}			 
			
  function insertSalesOrder ($basketId,$currencyId,$transId='',$getData='',$trackingId) {
		   
   $ordId = getDataFromTabel('TDS_SalesOrder', 'ordId', 'trackingId',$trackingId);	
   
  if(isset($ordId) && $ordId !=''){
			return false;
	} 	
	else {
		 
		 $basketItems=getUserBasketItems($basketId,$currencyId);		
		 $itemCount = count($basketItems);
		 $userId=isset($basketItems[0]->uId) ? $basketItems[0]->uId : 0;
		 $cartTotal =getBasketTotal($basketId);	
		 		 
		 $billingData = getBillingInfo($basketId,$userId);
				
		if($billingData->billing_state!=''){
			 $billingStateName = getDataFromTabel('TDS_MasterStates', 'stateName',  'stateId',$billingData->billing_state);		 			 
		   } else { $billingStateName=''; }
		   
		   if($billingData->shipping_state!=''){
		   $shippingStateName = getDataFromTabel('TDS_MasterStates', 'stateName',  'stateId',$billingData->shipping_state);
		   }else { $shippingStateName=''; } 			
			
			$ordNumber = createRanOrderNo();
			$toadAmount = getToadCommision($basketId);	
			$toadAmount  = ($toadAmount>0) ? $toadAmount : 0;	  
			$cartTotal  = $cartTotal + $toadAmount;	
			
			$billngName = $billingData->billing_firstName .' '.$billingData->billing_lastName;
			$shippingName = $billingData->shipping_firstName .' '.$billingData->shipping_lastName;		
		
			
	        $db = db_connect();		
					$SQL = 'INSERT INTO "TDS_SalesOrder" (
															"ordNumber",
															"ordStatus",
															"itemCount",
															"customerUid",
															"custName",
															"custStreetAddress",
															"custSuburb",
															"custCity",
															"custZip",
															"custState",
															"custCountry",
															"custPhone",
															"custEmail",
															"deliveryName",
															"deliveryStreet",
															"deliverySuburb",
															"deliveryCity",
															"deliveryZip",
															"deliveryState",
															"deliveryCountry",
															"payment_method",
															"grandTotal",
															"ordCurrency",
															"transactionId",
															"paypalTransectionInfo",
															"trackingId",
															"otherInfoConsumptionTax"
															
														)
												 VALUES (
															'.$ordNumber.',															
															1,															
															'.$itemCount.',															
															'.$userId.',															
															\''.$billngName.'\',
															\''.$billingData->billing_address1.'\',
															\''.$billingData->billing_address2.'\',
															\''.$billingData->billing_city.'\',
															'.$billingData->billing_zip.',														
															\''.$billingStateName.'\',
															\''.$billingData->countryName.'\',
															'.$billingData->billing_phone.',
															\''.$billingData->billing_email .'\',
															\''.$shippingName.'\',
															\''.$billingData->shipping_address1.'\',
															\''.$billingData->shipping_address2.'\',
															\''.$billingData->shipping_city.'\',
															'.$billingData->shipping_zip.',
															\''.$shippingStateName.'\',
															\''.$billingData->shippingcountryname.'\',
															\'paypal\',														
															'.$cartTotal.',
															'.$currencyId.',														
															\''.$transId.'\',
															\''.pg_escape_string($getData).'\',															
															\''.$trackingId.'\',
															\''.$billingData->otherAboutConsumptionTax.'\'
																														
														) ';
														
					//echo $SQL;die;																
					$flag = pg_query($db, $SQL);
								
					$insert_query = 'SELECT lastval();';
					$insert_row = pg_fetch_row(pg_query($insert_query));
					return $orderId= $insert_row[0];			
	
	    }   
	 }		
		
	  		
	function updateOrderPaypalLog($trackingId='',$orderId=0){
	
	  $db = db_connect();	
	  	  
	  $rec = pg_query($db, 'UPDATE "TDS_PaypalTransactionLog" SET "ordId" = '.$orderId .' WHERE "trackingId" = \''.$trackingId .'\' ') or die();	
	  return true;	
				 
	 }	
	

 function insertSalesOrderItem($basketId=0,$currencyId=0,$orderId=0,$transId=''){
		global $configPay;
		
	$items=getUserBasketItems($basketId,$currencyId); 
			
  if(isset($items) && is_array($items) && count($items)) {
			foreach($items as $item){
				$entityId = $item->entityId;
				$elementId=$item->elementId;
				$projId=$item->projId;
				$ownerId =  $item->sellerId;		 
				$sectionId =  $item->sectionId;
				$purchaseType=$item->purchaseType;		 
				$userId=$item->uId;		 
				$itemQty=$item->basketQty;
				
				$itemSellerInfo=$item->sellerInfo;
				$itemSellerInfo=json_decode($itemSellerInfo);
				
				$billingdetails=$item->billingdetails;
				$billingdetails=json_decode($billingdetails);				

				$json ='';
				$sellerInfo=getSellerDetails($ownerId);
				if($sellerInfo){ 
					$UserShippingJson = array(	 
						'firstName' => $sellerInfo->firstName,
						'lastName'  => $sellerInfo->lastName,
						'email'     => $sellerInfo->email,
						'seller_address1' => $sellerInfo->seller_address1,
						'seller_city' => $sellerInfo->seller_city,
						'seller_state' => $sellerInfo->seller_state,
						'seller_zip' => $sellerInfo->seller_zip,
						'seller_phone' => $sellerInfo->seller_phone,
						'territoryCountryId' => $sellerInfo->territoryCountryId,
						'sellerEuIdnumber' => $sellerInfo->identificationNumber	
					);					
		
					$json = json_encode($UserShippingJson); 					
				} 
				
				
				$sellerTerritory = (isset($sellerInfo->territory) && ($sellerInfo->territory!='')) ? $sellerInfo->territory : 0; 
				
				$euIdNo =0;
				
				if($sellerTerritory==1){
					$sellerInfo = getBillingInfo($basketId,$userId);					
					
				  if($sellerInfo->countryGroup=='EU'){					
					 $euIdNo = ($sellerInfo->EuVatIdentificationNumber!='') ? $sellerInfo->EuVatIdentificationNumber : 0 ;		
				    }
				}	
	 
     $db = db_connect();		
	               $SQL = 'INSERT INTO "TDS_SalesOrderItem" (
															"ordId",
															"entityId",
															"elementId",
															"sectionId",
															"purchaseType",
															"itemQty",
															"itemName",
															"itemValue",
															"basePrice",
															"taxName",
															"taxPercent",
															"taxValue",
															"shipping",
															"tsCommissionPercent",
															"tsCommissionValue",
															"tsVatPercent",
															"tsVatValue",
															"tsGrossCommision",
															"dispatchPrice",
															"sellerId",
															"sellerInfo",															
															"transactionId",
															"invoiceId",
															"projId",
															"registrationId"
															
														)
												 VALUES (
															'.$orderId.',															
															'.$entityId.',							
															'.$elementId.',															
															\''.$sectionId.'\',															
															'.$item->purchaseType.',
															'.$itemQty.',
															\''.$item->itemName.'\',
															'.$item->itemValue.',
															'.$item->basePrice.',														
															\''.$item->taxName.'\',
															'.$item->taxPercent.',
															'.$item->taxValue.',
															'.$item->shipping .',
															'.$item->tsCommissionPercent.',
															'.$item->tsCommissionValue.',
															'.$item->tsVatPercent.',
															'.$item->tsVatValue.',
															'.$item->tsGrossCommision.',
															'.$item->dispatchPrice.',
															'.$item->sellerId.',
															\''.$json.'\',
															\''.$transId.'\',
															\''.$item->invoiceId.'\',
															'.$projId.',
															'.$euIdNo.'												
																														
														) ';
														
					//echo $SQL;die;																
					$query = pg_query($db, $SQL);  
					
					$insert_query = 'SELECT lastval();';
					$insert_row = pg_fetch_row(pg_query($insert_query));
					$salesItemId = $insert_row[0];
				
				insertReceiverTransId($salesItemId,$orderId,$item->invoiceId);				

			if(is_numeric($salesItemId) && $salesItemId > 0){
					$itemIds[]=$item->itemId;
					/* delete wishlist for purchased items */
				    deleteWishlistItem($entityId,$elementId,$purchaseType,$userId);	
										   
					$uId = ($item->uId!='') ? $item->uId :0;	   

					if($item->purchaseType==1){
						insertSalesItemShipping($salesItemId,$uId,$orderId,$basketId,$transId); 
						 
					}
					else{
						 $expiryDays = $configPay['setExpiryDays'];
						 $insertDowndata = array(
							'itemId'=>$salesItemId,
							'ordId'=>$orderId,
							'transactionId'=>$transId,
							'purchaseType'=>$item->purchaseType,
							'ownerId'=>$item->sellerId,
							'entityId'=> $entityId,
							'elementId' =>$elementId,
							'projId'=>$projId,
							'sectionId' =>$sectionId,
							'dwnMaxday' =>$expiryDays,
							'userId' =>$userId												                    
					     );
					     
					     if(($entityId == 54) && ($elementId == $projId)){
							$existingElements=getExistingElements($projId,$sectionId);
							if($existingElements){
								$insertDowndata['itemInfo'] =$existingElements;
							}
						 }
						insertSalesItemDownload($insertDowndata);  
					}
					
					if($item->purchaseType==1 || $item->purchaseType==5){ //shipping or tickets
						if( ($orderId > 0) && ($entityId > 0) && ($elementId > 0) && ($itemQty > 0) ){
							
							$purchaseProductDetails=array(
								'orderId' =>$orderId,
								'entityId'=> $entityId,
								'elementId' => $elementId,
								'projectId' => $projId,
								'transQty' =>$itemQty,
								'transactionId' => $transId
							);
						
							manageProductQuantity($purchaseProductDetails);
						}
					}
				}
			}

			if(isset($itemIds) && is_array($itemIds) && count($itemIds) > 0){
				/* delete SalesBasketItem for purchased items */
				//$this->model_common->deleteRowFromTabel('SalesBasketItem', 'itemId', $itemIds);
			}

		}	  
	}		
	
		
		
 function getDataFromTabel($tableName='',$field='',$whereField='',$whereVal=''){	
	 	
	// $basketId =619;			 
      $db = db_connect();	 
    // echo $SQL ='SELECT "'.$field.'" from "'.$tableName.'"  where "'.$whereField.'" = \''.$whereVal.'\' ';die;
      $res = pg_query($db, 'SELECT "'.$field.'" from "'.$tableName.'"  where "'.$whereField.'" = \''.$whereVal.'\' ' ) ;   
   
		if($res){			
			$data = pg_fetch_object($res);	
			  if($data!=''){		
			    $result = $data->$field;				
			   } else {
				        $result='';
				      } 
		} 
		
		return $result;
		
		}		 
		 
/* Get Items to insert in Sales Order Table */ 
 function getUserBasketItems($itemId=0,$currency=0){	
	 
	 $db = db_connect();
	 	
	$tableSalesBasketItem		= 'TDS_SalesBasketItem';	
	$tableSalesCustomersBasket	= 'TDS_SalesCustomersBasket';	
			
	$SQL=' SELECT p.*, t."uId",t."trackingId",t.billingdetails				
				FROM "'.$tableSalesBasketItem.'" p
				LEFT JOIN "'.$tableSalesCustomersBasket.'" t ON (t."basketId" = p."basketId")				
				WHERE p."basketId" =  '.$itemId.' AND p.sendpaypal = true 		
			';	
	 
	$query= pg_query($db, $SQL);			
	
	  if($query){
		  
		  $data = array();		  
		    while ($row = pg_fetch_object($query)) {		  
		        $data[] = $row;
		      }		  
		    return $data;
	      }else {
			       return false;
			     }
  } 
  
  
  
  /* Get Sum of duration /containersize */
  function getBasketTotal($basketId){	
	  
	$db = db_connect();	 	
	$tableSalesBasketItem		= 'TDS_SalesBasketItem';	
				
	$SQL=' SELECT SUM("dispatchPrice") AS total		
				FROM "'.$tableSalesBasketItem.'" 						
				WHERE "basketId" =  '.$basketId.' AND sendpaypal = true 
				group by "basketId"
				order by "basketId" DESC';	
	 
	$query= pg_query($db, $SQL);		
	
	  if($query){
		 $data = pg_fetch_object($query);			
			$result = $data->total;			
		    return $result;
	      }else {
			       return false;
			     }
	     
	  } 
	  
	  
	  
  function getBillingInfo($basketId,$userId) {
	  
		$billingDetail = getBillingDetails($basketId);	
		
		if(isset($billingDetail->billingdetails) && $billingDetail->billingdetails!=''){
			$billingdetail = json_decode($billingDetail->billingdetails);
			$userBillingData =  $billingdetail;			
			
		}else{				
			$userBillingData = getUserBillingDetails($userId);
		}

		if(isset($billingDetail->shippingdetails) && $billingDetail->shippingdetails!=''){		
			$shippingdetails = json_decode($billingDetail->shippingdetails);
			$userShippingData =  $shippingdetails;
		}else {
			$userShippingData = getBillingShipDetails($userId);
		}
						
		$billingData = (object) array_merge((array) $userBillingData, (array) $userShippingData);
		
		return $billingData; 
	 
	}
	
	
	
 function getBillingDetails($cartId){   	  
	 
	   if($cartId) { 
		  $db = db_connect();	 	
		 $tableSalesCustomersBasket	= 'TDS_SalesCustomersBasket';	
					
	    	$SQL=' SELECT billingdetails, shippingdetails		
					FROM "'.$tableSalesCustomersBasket.'" 						
					WHERE "basketId" =  '.$cartId.' ';	
				
		$query= pg_query($db, $SQL);	
				
		  if($query){
			 $data = pg_fetch_object($query);			
				$result = $data;				
				return $result;
			  } else {
			       return false;
			     }
			
		 }	  
 }
 
 
 function getUserBillingDetails($id){	 
	 
	  $db = db_connect();		 					
      $SQL=' SELECT bill."billing_firstName",bill."billing_lastName",bill."billing_address1",bill.billing_address2,bill.billing_city,bill.billing_state,bill.billing_country,bill.billing_zip,bill.billing_phone,bill.billing_email,bill."EuVatIdentificationNumber",t."countryName",t."countryGroup","EuVatIdentificationNumber"		
				FROM "TDS_UserBuyerSettings" bill 		
				LEFT JOIN "TDS_MasterCountry" t ON (t."countryId" = bill."billing_country")				
				LEFT JOIN "TDS_ConsumptionTax" tax ON (tax."countryId" = bill."billing_country")				
				WHERE bill."tdsUid" =  '.$id.' 
  			';	
		
	   $query= pg_query($db, $SQL);		 	
		  if($query){
			 $data = pg_fetch_object($query);			
			 $result = $data;				
			 return $result;
	      } else {
			       return false;
			     }
     } 
  
  
  function getBillingShipDetails($id){	 
	 
	  $db = db_connect();	 					
      $SQL=' SELECT ship."shipping_firstName",ship."shipping_lastName",ship.shipping_address1,ship.shipping_address2,ship.shipping_state,ship.shipping_country,ship.shipping_city,ship.shipping_zip,ship.shipping_phone,ship.shipping_email,t."countryName" as shippingcountryName		
				FROM "TDS_UserBuyerSettings" ship 		
				LEFT JOIN "TDS_MasterCountry" t ON (t."countryId" = ship."billing_country")				
				LEFT JOIN "TDS_ConsumptionTax" tax ON (tax."countryId" = ship."billing_country")				
				WHERE ship."tdsUid" =  '.$id.' 
  			';	
		
	   $query= pg_query($db, $SQL);		 	
		  if($query){
			 $data = pg_fetch_object($query);			
			 $result = $data;				
			 return $result;
	      } else {
			       return false;
			     } 
     } 
  
  
  
 /* Create Random no for New Order */
 function createRanOrderNo()	{ 			
	
	$generateNo = randomNumber();
		
	$isAlreadyExists= getDataFromTabel('TDS_SalesOrder', 'ordNumber', 'ordNumber',$generateNo);
	if($isAlreadyExists!=''){
		$generateNo = randomNumber();
		}
					
	return $generateNo;
 } 
 
 
 function randomNumber(){	 
	 //We generate a random string, based our our settings
	$len = 9; 	
	$numericcode = '';  
	$numericbase = "0123456789";
	$max = strlen($numericbase) - 1;
	mt_srand((double) microtime() * 1000000);
		while (strlen($numericcode) < $len + 1) {
		  $numericcode.=$numericbase{mt_rand(0, $max)};        
		}
	 return $numericcode;	 
	 }
  
  
  
 function getToadCommision($basketId,$currency=0){
	 
	$db = db_connect();	 	
	$tableSalesBasketItem		= 'TDS_SalesBasketItem';	
				
	$SQL=' SELECT SUM("tsGrossCommision") AS price		
			FROM "'.$tableSalesBasketItem.'" 						
			WHERE "basketId" =  '.$basketId.' AND sendpaypal = true 
			AND "currency" =  '.$currency.'
			group by "basketId"	';	
	 
	$query= pg_query($db, $SQL);	
	  if($query){
		 $data = pg_fetch_object($query);			
			$result = $data->price;			
		    return $result;
	      }	else {
			       return false;
			     } 
 } 
  
  
  
 function getSellerDetails($ownerId){
		
	$db = db_connect();	 					
      $SQL=' SELECT 
                s.seller_address1,s.seller_city,s.seller_state,s.seller_zip,s.seller_phone,s."territoryCountryId",
                s.territory,s."identificationNumber",p."firstName",p."lastName",u.email
				FROM "TDS_UserSellerSettings" s		
				LEFT JOIN "TDS_UserProfile" p ON (p."tdsUid" = s."tdsUid")				
				LEFT JOIN "TDS_UserAuth" u ON (p."tdsUid" = u."tdsUid")				
				WHERE s."tdsUid" =  '.$ownerId.' ';	
	   
	   $query= pg_query($db, $SQL);		 	
		  if($query){
			 $data = pg_fetch_object($query);			
			 $result = $data;				
			 return $result;
	      } else {
			       return false;
			} 
  }	 
  
  
  function insertReceiverTransId($salesItemId=0,$ordId=0,$invoiceId=''){	 
	  
		$db = db_connect();	
		$recvId = getDataFromTabel('TDS_PaypalTransactionLog', 'senderTransactionId',  'invoiceId',$invoiceId);			
		$recvId = ($recvId!='') ? $recvId : '';		 
	  	  
	    $rec = pg_query($db, 'UPDATE "TDS_SalesOrderItem" SET "receiverTransactionId" = \''.$recvId.'\'  WHERE "itemId" = '.$salesItemId.' ') ;		
			
		$InvId = getSalesOrderInv($ordId,$recvId);					
			
		if(isset($InvId) && ($InvId!='') ){
			 //$this->model_common->editDataFromTabel('MembershipCartItem', $data, 'memItemId', $res[0]->tsProductId); 					
		}else{	
			
			   $SQL = 'INSERT INTO "TDS_SalesOrderInvoice" ( "ordId","receiverTransactionId" )
							 VALUES  ('.$ordId.', \''.$recvId.'\')';
							 							         
		       $query = pg_query($db, $SQL);							
		     }
		
	   return true;		 	
		 	 
	 }	
	 
	 
 function getSalesOrderInv($ordId=0,$recvId=''){
			 
      $db = db_connect();	 
      $SQL ='SELECT id from "TDS_SalesOrderInvoice"  where "ordId" = '.$ordId.' AND "receiverTransactionId" = \''.$recvId.'\'  ';
      
      $res = pg_query($db, $SQL ) ;    
		if($res){			
			$data = pg_fetch_object($res);	
		if($data!=''){		
			$result = $data->id;				
		} else {
			$result='';
			} 
		} 		
	return $result;	 
 }	 
	 

 function deleteWishlistItem($entityId,$elementId,$purchaseType,$userId){	 

	   $db = db_connect();
	   $sql = 'DELETE  FROM "TDS_Wishlist"                   
               WHERE "entityId" = '.$entityId.'  
               AND "elementId" = '.$elementId.'  
               AND "purchaseType" = '.$purchaseType.'  
               AND "tdsUid" = '.$userId.'  
               ';
	   pg_query($db, $sql ) ;
	   return true;	  			
	}	 
	
	
	
  function insertSalesItemShipping($salesItemId,$uId,$orderId,$basketId,$transId){
	
	// $basketId= 32;
	 
	  $billingDetail = getBillingDetails($basketId);	   	
				
	  if(isset($billingDetail->shippingdetails) && $billingDetail->shippingdetails!=''){		
		$shippingdetails = json_decode($billingDetail->shippingdetails);
		$userShippingData =  $shippingdetails;
	   }else {
		$userShippingData =  getBillingShipDetails($uId);
		}
		
   if($userShippingData->shipping_state!=''){
	   $shippingStateName =getDataFromTabel('TDS_MasterStates', 'stateName',  'stateId',$userShippingData->shipping_state);	   
	   }else { $shippingStateName=''; } 		
			
	 $address = $userShippingData; 	
		   
	 $fName=getDataFromTabel('TDS_UserProfile','firstName',  'tdsUid', $uId );
	 $lName=getDataFromTabel('TDS_UserProfile','lastName',  'tdsUid', $uId);	 	   
		               
        $db = db_connect();    
        $SQL = 'INSERT INTO "TDS_SalesItemShipping" ( "itemId",
                                                      "shpStatus",
                                                      "fName",
                                                      "lName",
                                                      "address",
                                                      "zip",
                                                      "city",
                                                      "state",
                                                      "country",
                                                      "ordId",
                                                      "transactionId"                                               
                                                 )
                                                 
							           VALUES  (
							                        '.$salesItemId.',
													  0,
							                       \''.$fName.'\',
							                       \''.$lName.'\',
							                       \''.$address->shipping_address1.'\',
							                       '.$address->shipping_zip.',
							                       \''.$address->shipping_city.'\',
							                       \''.$shippingStateName.'\',
							                       \''.$address->shippingcountryname.'\',
							                       '.$orderId.',
							                       \''.$transId.'\'							                        
							                    )';							 							         
		           $query = pg_query($db, $SQL); 
	            }
	
	
function insertSalesItemDownload($data=''){
	
	if(isset($data) && is_array($data)) {
		
	$itemInfo = (isset($data['itemInfo']) && ($data['itemInfo']!='') ) ? $data['itemInfo'] : '' ;
		
        $db = db_connect();    
        $SQL = 'INSERT INTO "TDS_SalesItemDownload" ( "itemId",
                                                      "ordId",
                                                      "transactionId",
                                                      "purchaseType",
                                                      "ownerId",
                                                      "entityId",
                                                      "elementId",
                                                      "projId",
                                                      "sectionId",
                                                      "dwnMaxday",
                                                      "userId",
                                                      "itemInfo"                                               
                                                 )
                                                 
							           VALUES  (
							                        '.$data['itemId'].',
							                        '.$data['ordId'].',													
							                       \''.$data['transactionId'].'\',
							                        '.$data['purchaseType'].',
							                        '.$data['ownerId'].',
							                        '.$data['entityId'].',
							                        '.$data['elementId'].',
							                        '.$data['projId'].',
							                        '.$data['sectionId'].',
							                        '.$data['dwnMaxday'].',
							                        '.$data['userId'].',
							                       \''.$itemInfo.'\'							                        							                       							                        
							                    )';							 							         
		           $query = pg_query($db, $SQL); 	
	  } 
   }	
 
 	
function getExistingElements($projId=0,$sectionId=0){
		$return=false;
		if(is_numeric($projId) && $projId>0 && $sectionId != ''){
			$isTableFound=true;
			switch ($sectionId){	
				case '1':
					$table='"TDS_FvElement"';	
				break;
				
				case '2':
					$table='"TDS_MaElement"';	
				break;
				
				case '3':
					$table='"TDS_WpElement"';	
				break;
				
				case '4':
					$table='"TDS_PaElement"';	
				break;
				
				case '10':
					$table='"TDS_EmElement"';	
				break;
				
				default:
					$isTableFound=false;
				break;			
			}
			
	if($isTableFound){
				
	$db = db_connect();	 
	$selectfields = '"elementId","isDownloadPrice","isPerViewPrice"';
    $SQL ='SELECT '.$selectfields.' from '.$table.'  where "projId" = '.$projId.' ';      
      $res = pg_query($db, $SQL ) ;    
		if($res){			
			$data = pg_fetch_object($res);	
			 $result = $data;		
		  }		
		
			if($result){
					$return = json_encode($result);
				}
			}
		}		
		return $return;
	}
	
	
 	function getProductInfo($entityId=0,$elementId=0,$purchaseType=1){
		$cartDetails=false;
		if( $entityId >0 && $elementId > 0){
			$entity_tableName = getMasterTableName($entityId);
			$tableName= $entity_tableName[0];
			$isTableFound=true;
			switch ($tableName){	
				case 'TDS_Product':
					
					$quantity = '"productQuantity" as "aviliableqty"' ;
					$whereId = '"productId"';														
					break;
							
				case 'TDS_Project':
					
					$quantity = '"projQuantity" as "aviliableqty"' ;				
					$whereId = '"projId"';						
				break;
				
				case 'TDS_EmElement':
				case 'TDS_FvElement':
				case 'TDS_MaElement':
				case 'TDS_PaElement':
				case 'TDS_WpElement':
					
					$quantity = 'quantity as aviliableqty' ;				
					$whereId = '"elementId"';						
				break;
				
				case 'TDS_Tickets':
									
					$quantity = 'Quantity as aviliableqty' ;
					$whereId = '"TicketId"';		
				break;
				
				
				default:
					$isTableFound=false;
				break;			
			}
			
			if($isTableFound){
				
				$selectfields = '';
				$isSelectfields = false;
						
				if(isset($quantity) && $quantity != '' ){
					if($isSelectfields){
						$selectfields = $selectfields.','.$quantity;
					}else{
						$selectfields = $quantity;
					}
					
				}		
				
				//$where = array($whereId=>$elementId);				
				$db = db_connect();	 
				
			     $SQL ='SELECT '.$selectfields.' from "'.$tableName.'"  where '.$whereId.' = '.$elementId.' ';
				  $res = pg_query($db, $SQL ) ;    
					if($res){			
						$data = pg_fetch_object($res);	
						 $aviliableqty = $data;		
					  }			
			}
		}
		return $aviliableqty;
	}	
	
	
 function manageProductQuantity($purchaseProductDetails=''){ 
	 
	if(is_array($purchaseProductDetails) && count($purchaseProductDetails) > 0){
			$entityId=$purchaseProductDetails['entityId'];
			$elementId=$purchaseProductDetails['elementId'];
			$purchaseType=1;	
			$orderId=$purchaseProductDetails['orderId'];
			$itemQty=$purchaseProductDetails['transQty'];
			$projId=$purchaseProductDetails['projectId'];
			$transId=$purchaseProductDetails['transactionId'];			
			
			
			$ProductInfo=getProductInfo($entityId,$elementId,$purchaseType);
						
			if($ProductInfo && isset($ProductInfo->aviliableqty) && $ProductInfo->aviliableqty > 0){
				$prevQty=$ProductInfo->aviliableqty;
				$transQty=$purchaseProductDetails['transQty'];
				$availableQty=($prevQty - $transQty);
				if(!($availableQty > 0)){
					$availableQty=0;
				}
								
				$purchaseProductDetails['prevQty']=$prevQty;
				$purchaseProductDetails['availableQty']=$availableQty;
				
				$entity_tableName = getMasterTableName($entityId);
				$tableName= $entity_tableName[0]; 
				$isTableFound=true;
				
				switch ($tableName){	
					
					case 'TDS_Product':
					    $whereId = '"productId"';
					    $updateData = '"productQuantity"';					
						
					break;
						
					case 'TDS_Tickets':
					    $whereId = '"TicketId"';
					    $updateData = '"Quantity"';							
						
					break;
								
					case 'TDS_Project':
					    $whereId = '"projId"';	
					    $updateData = '"projQuantity"';					
						
					break;
					
					case 'TDS_EmElement':
					case 'TDS_FvElement':
					case 'TDS_MaElement':
					case 'TDS_PaElement':
					case 'TDS_WpElement':
					    $whereId = '"elementId"';	
					    $updateData = '"quantity"';					
						
					break;
					
					default:
						$isTableFound=false;
					break;			
				}
				if($isTableFound){ 
					$db = db_connect();	  	  
					//echo $r = 'UPDATE "'.$tableName.'" SET '.$updateData.' = '.$availableQty .' WHERE '.$whereId.' = '.$elementId .' ';die;
					$result = pg_query($db, 'UPDATE "'.$tableName.'" SET '.$updateData.' = '.$availableQty .' WHERE '.$whereId.' = '.$elementId .' ');
									
					if($result){						
						
				    $SQL = 'INSERT INTO "TDS_ProductQuantityLog" ( "orderId",
																   "entityId",
																   "elementId",
																   "projectId",
																   "prevQty",
																   "transQty",
																   "availableQty",
																   "transactionId"																	                                                
																 )
                                                 
													   VALUES  (
																	'.$orderId.',
																	'.$entityId.',
																	'.$elementId.',
																	'.$projId.',
																	'.$prevQty.',
																	'.$itemQty.',																	
																	'.$availableQty.',																	
																    \''.$transId.'\'													  
																	
																)';
							 							         
		                   $query = pg_query($db, $SQL);
						
					}
				}
			}
		}
	}	
	
 
function getMasterTableName($tableId=''){
		global $masterTable;	
						
		return (array_keys($masterTable,$tableId));

		}
		
		
 /*
	 *************************************** 
	 *  This function is used to send invoice email to customer, seller and toadsquare by order Id
	 *************************************** 
	 */ 


	function invoiceSendToEmail($orderId=''){
		 global $configPay;
		//echo "<pre>";	
		$sentWhere=array('ordId'=>$orderId);
		$purchasedtemplate=getDataFromTabel('TDS_SalesOrder','isInvoiceSent', 'ordId',$orderId);		
		
		
		// this codition for email send one time only when isInvoiceSent is "f"
		if(isset($purchasedtemplate) && $purchasedtemplate=="f")
		{
			
			//This query for get invoiceId by orderId
			$get_invoice_by_orderId=get_invoice_by_orderId($orderId);
			
			$get_sales_record['get_num_rows']='0';
			$get_sales_record['get_result']=''; 
			if($get_invoice_by_orderId['get_num_rows'] > 0)
			{
				$countAdd = 0;
				
				//for getting itemId by invoiceId
				foreach($get_invoice_by_orderId['get_result']  as $sales_record_by_invoice)
				{
								//This query get itemId by invoiceId
					$getSalesRecord =  get_sales_record($sales_record_by_invoice);
					
					if($getSalesRecord['get_num_rows'] > 0)
					{					
						$get_sales_record['get_result'][$countAdd]['itemId'] = $getSalesRecord['get_result']->itemId;  
						$countAdd++;
					}
				
				}
				
				$get_sales_record['get_num_rows'] =	$countAdd;
				
				//this check for getting purchased details
				if($get_sales_record['get_num_rows'] > 0 )
				{
					$countRow=0;
					//for getting purchased details by itemId 
					foreach($get_sales_record['get_result']  as $sales_record)
					{
					
						//This query get itemId by invoiceId
						$purchased_details_by_itemId =  purchased_details_by_itemId($sales_record['itemId']);
					
						if($purchased_details_by_itemId['get_num_rows'] > 0)
						{
						
						   $get_sales_record['get_result'][$countRow] = $purchased_details_by_itemId['get_result']; 					
							
							$getSellerDetail = json_decode($get_sales_record['get_result'][$countRow]->sellerInfo);							
					
							$userCountryName = getDataFromTabel('TDS_MasterCountry', 'countryName','countryId',$getSellerDetail->territoryCountryId);
							
							
							$getSellerDetail->territoryCountryId = $userCountryName;
							
							$getSellerDetail->seller_state = getDataFromTabel('TDS_MasterStates', 'stateName',  'stateId',$getSellerDetail->seller_state);
							
														
							$get_sales_record['get_result'][$countRow]->sellerInfo =   json_encode($getSellerDetail);
							
							$get_sales_record['get_result'][$countRow]->getItemsDetils = getItemsDetils($get_sales_record['get_result'][$countRow]->invoiceId);
										
							$get_sales_record['get_result'][$countRow]->isTakingShipping = isTakingShipping($get_sales_record['get_result'][$countRow]->invoiceId);
							
							$countRow++;
						}
					
					}
				
				}

				//invoice sending to customer:to,seller:cc and toadsquare:bcc
			
				if($get_sales_record['get_num_rows'] > 0)
				{
					
					foreach($get_sales_record['get_result'] as $get_invoice_data)
					{
						//$this->load->library('email');
						//$this->email->from($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
						//$this->email->reply_to($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
						
						//get currency type
						
						$currencyType = ($get_invoice_data->ordCurrency==1) ?'$':'€';
						
						//$currencyType =  getCurrencyType($get_invoice_data->ordCurrency);
						
						$get_Items_Detils= $get_invoice_data->getItemsDetils;
						
						$getItemListing = "";
						if($get_Items_Detils['get_num_rows'] > 0)
						{
							$list = 0;
							foreach($get_Items_Detils['get_result'] as $itemsDetils)
							{
								
								$where=array('purpose'=>'purchasedtemplateitems','active'=>1);
								//$getPurchasedItems=getDataFromTabel('TDS_EmailTemplates','templates', 'purpose', $where, '','', '', 1 );
								
								$getPurchasedItems = getTemplateFromTabel('TDS_EmailTemplates','templates', 'purpose', 'purchasedtemplateitems', 'active',1);								
								$getPurchasedItems=$getPurchasedItems[0]->templates;								
								
								$parseArray 
								=array("{item_name}","{event_date_data}","{item_price}","{item_quantity}","{item_total}","{consumption_tax_name}","{consumption_tax_percent}","{consumption_tax_value}","{item_grand_total}","{purchase_type}","{toadsquare_fees}","{toad_vat_percent}","{toad_vat_value}","{purchaseMessage}");
								
								/***********parsing value code here**********/
								$item_name = $itemsDetils->itemName; // item name
								$itemNameListing[$list]['itemName'] = $item_name;
								$itemNameListing[$list]['itemUrl'] = getFrontEndLink($itemsDetils->entityId, $itemsDetils->elementId);
								$event_date_data = '';
								 
								//this section get event session date and time
							    if($get_invoice_data->purchaseType=="5")
								{
									$get_SellerDetail = json_decode($get_invoice_data->sellerInfo);
									$getSessionId = $get_SellerDetail->SessionId;
									$get_Session_Details = get_Session_Details($getSessionId);									
									$getSessionDetails = $get_Session_Details['get_result'];
		
									$sessionDate = 	date("d M Y",strtotime($getSessionDetails->date));	
									 $getTimeFormate= explode(":",$getSessionDetails->startTime);
									$sessionTime = 	$getTimeFormate[0].':'.$getTimeFormate[1];
									$event_date_data = ' <font color="000;" style="padding-right:14px;"> Date </font>'.$sessionDate.'
										 <br />
										 <font color="000" style="padding-right:14px;"> Time </font>'.$sessionTime;
								}
								$item_price = $currencyType.' '.number_format($itemsDetils->basePrice,2); // item price
								$item_quantity = $itemsDetils->itemQty; // item quantity
								$itemPrice = $itemsDetils->basePrice; 
								$itemQty = $itemsDetils->itemQty;
								$priceTotal = ($itemQty*$itemPrice);
								$item_total =   $currencyType.' '.number_format($priceTotal,2);// item total price
								$consumption_tax_percent = $itemsDetils->taxPercent;// consumption tax percent
								$consumption_tax_name = $itemsDetils->taxName;
								$vatTaxValue =  $itemsDetils->taxValue;
								$consumption_tax_value =  $currencyType.' '.number_format($itemsDetils->taxValue,2);// consumption tax value
								$mainPriceTotal = $priceTotal+$vatTaxValue;
								$item_grand_total =   $currencyType.' '.number_format($mainPriceTotal,2); // item_grand_total
								$purchase_type = getPurchaseType($itemsDetils->purchaseType); // item purchase type
								$toad_vat_percent = $itemsDetils->tsVatPercent;
								$toadsquare_fees = 	$currencyType.' '.number_format($itemsDetils->tsCommissionValue,2);
								$toad_vat_value = $currencyType.' '.number_format($itemsDetils->tsVatValue,2);							   
								   //This section show  message according to type 
                                   //1:shipping,2:download,3:PPV,4:Donation, 5: event
								switch($itemsDetils->purchaseType)
									{
										case 1:
										$purchaseMessage='Shipping details entered by the Seller on their Sales page can be seen on the Buyer\'s Purchses page.';
										break;
										case 2:
										$getDownloadPeriod = getDownloadPeriod($itemsDetils->itemId);										
										$startDateShow  =  date("d F Y",strtotime($getDownloadPeriod->dwnDate));
										$dwnMaxday = $getDownloadPeriod->dwnMaxday;
										$endDataShow = mktime(0,0,0,date("m",strtotime($getDownloadPeriod->dwnDate)),date("d",strtotime($getDownloadPeriod->dwnDate))+$dwnMaxday,date("Y",strtotime($getDownloadPeriod->dwnDate)));
										$endDataShow = date("d F Y", $endDataShow);
										$purchaseMessage='The Purchase can be downloaded from the Buyer\'s Purchases page   '.$startDateShow.' to '.$endDataShow.'.';
										break;
										case 3:
										$getDownloadPeriod = getDownloadPeriod($itemsDetils->itemId);	
																		
										$startDateShow  =  date("d F Y",strtotime($getDownloadPeriod->dwnDate));
										$dwnMaxday = $getDownloadPeriod->dwnMaxday;
										$endDataShow = mktime(0,0,0,date("m",strtotime($getDownloadPeriod->dwnDate)),date("d",strtotime($getDownloadPeriod->dwnDate))+$dwnMaxday,date("Y",strtotime($getDownloadPeriod->dwnDate)));
										$endDataShow = date("d F Y", $endDataShow);
										$purchaseMessage='The Purchase can be viewed from the Buyer\'s Purchases page '.$startDateShow.' to '.$endDataShow.'.';
										break;
										case 4:
										$purchaseMessage='';
										break;
										case 5:
										$purchaseMessage='Buyers will receive their tickets by email and they can also print them from their Purchases page.';
										break;
										default:
											$purchaseMessage="None";
									}
								//replace value array value code here
							
								$replaceArray = array($item_name,$event_date_data, $item_price, $item_quantity, 
								$item_total,$consumption_tax_name,$consumption_tax_percent, $consumption_tax_value,$item_grand_total, $purchase_type,$toadsquare_fees, $toad_vat_percent,$toad_vat_value,$purchaseMessage);
								//array replacing here
								$getItemListing.=str_replace($parseArray, $replaceArray, $getPurchasedItems);
								$list++;
								
							}							
						}
						
						//This section for get main email template from database
						
						$where=array('purpose'=>'purchasedtemplate','active'=>1);
						//$purchasedtemplate=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
						
						$purchasedtemplate = getPurchasedTemplate('TDS_EmailTemplates','templates','subject','purpose', 'purchasedtemplate', 'active',1);						
						
						$purchasedSubject=$purchasedtemplate[0]->subject;
						$purchasedtemplate=$purchasedtemplate[0]->templates;
						
						
						$logo_image_url = site_base_url()."images/toademaillogo_invoice.jpg"; // image base url
						$parseTemplateArray	= 
						array("{logo_image_url}","{item_body}","{sale_order_date}","{sale_order_no}","{registraion_no}","{seller_name}","{seller_address}","{seller_city}","{seller_state}","{seller_zip}","{seller_country}","{seller_phone}","{seller_email}","{sellerEuIdnumber}","{buyer_name}","{buyer_address}","{buyer_city}","{buyer_state}","{buyer_zip}","{buyer_country}","{buyer_phone}","{buyer_email}","{otherInfoConsumptionTax}","{shpping_body}");
						
						/*********template parsing code here*******/
						$sale_order_date = date("d F Y H:i",strtotime($get_invoice_data->ordDateComplete));//order date
						$sale_order_no = getInvoiceId($get_invoice_data->receiverTransactionId); //invoice id		
						
						//registration no
						$registraion_no = ($get_invoice_data->registrationId==0)?"":$get_invoice_data->registrationId.' VAT Exemption<br>';
						$otherInfoConsumptionTax = ($get_invoice_data->otherInfoConsumptionTax=='')?"":$get_invoice_data->otherInfoConsumptionTax.' VAT Exemption';
						//seller info
						$sellerInfo = json_decode($get_invoice_data->sellerInfo);//get seller info data
						
						$seller_name = ucwords($sellerInfo->firstName.' '.$sellerInfo->lastName);
						$seller_address = $sellerInfo->seller_address1;
						$seller_city = $sellerInfo->seller_city;
						$seller_state = $sellerInfo->seller_state;
						$seller_zip = $sellerInfo->seller_zip;
						$seller_country = $sellerInfo->territoryCountryId;
						$seller_phone = $sellerInfo->seller_phone;
						$seller_email = $sellerInfo->email;
						if(isset($getSellerDetail->sellerEuIdnumber) && $getSellerDetail->sellerEuIdnumber!='')
							{
								$sellerEuIdnumber = "#".$getSellerDetail->sellerEuIdnumber;	
							}else
							{
								$sellerEuIdnumber = "";
							}
														
						//buyer info
						$buyer_name = ucwords($get_invoice_data->custName);
						$buyer_address = $get_invoice_data->custStreetAddress;
						$buyer_address .= ($get_invoice_data->custStreetAddress!="")?', '.$get_invoice_data->custSuburb:'';
						$buyer_city = $get_invoice_data->custCity;
						$buyer_state = $get_invoice_data->custState;
						$buyer_zip = $get_invoice_data->custZip;
						$buyer_country = $get_invoice_data->custCountry;
						$buyer_phone = $get_invoice_data->custPhone;
						$buyer_email = $get_invoice_data->custEmail;
						
						//shipping body
						$shpping_body="";
						
						if($get_invoice_data->isTakingShipping=="yes")
						{
							
							$shpping_body .= '<font style="font-size:22px; color:#888888;margin:0">Shipping Details</font> <br /> <br />';
							$shpping_body .= '<font style="font-weight:bold;">'.ucwords($get_invoice_data->deliveryName).'</font> <br />';
							$shpping_body .= $get_invoice_data->deliveryStreet;
							$shpping_body .= ($get_invoice_data->deliveryStreet!="")?', '.$get_invoice_data->deliverySuburb:'';
							$shpping_body .= '<br>';
							$shpping_body .= $get_invoice_data->deliveryCity.', '.$get_invoice_data->deliveryState.', '.$get_invoice_data->deliveryZip.'<br />';
							$shpping_body .= $get_invoice_data->deliveryCountry.'<br/><div style="height:6px"></div>';
							$shpping_body .= $get_invoice_data->custPhone.'<br/>';
							$shpping_body .= $get_invoice_data->custEmail;
						}
						
						$replaceTemplateArray = 
						array($logo_image_url,$getItemListing,$sale_order_date,$sale_order_no,$registraion_no,$seller_name,$seller_address,$seller_city,$seller_state,$seller_zip,$seller_country,$seller_phone,$seller_email,$sellerEuIdnumber,$buyer_name,$buyer_address,$buyer_city,$buyer_state,$buyer_zip,$buyer_country,$buyer_phone,$buyer_email,$otherInfoConsumptionTax,$shpping_body);
						
						$getPurchasedTemplate =str_replace($parseTemplateArray, $replaceTemplateArray, $purchasedtemplate);
					
						
						/*************get email body for purchase from database start*************/
			
						$purWhereCondi=array('purpose'=>'purchaseontoadsquare','active'=>1);
						//$PurchaseDataBody = getDataFromTabel('EmailTemplates','templates,subject',  $purWhereCondi, '','', '', 1 );
						
						$PurchaseDataBody = getPurchasedTemplate('TDS_EmailTemplates','templates','subject','purpose', 'purchaseontoadsquare', 'active',1);											
						
						$siteUrl = config::getInst()->getKeyValue("base_url");
						$base_url = config::getInst()->getKeyValue("base_url");
						
						$PurchaseDataBody = $PurchaseDataBody[0];
						$site_url = $siteUrl;
						$site_base_url = site_base_url();
						$image_base_url = site_base_url().'images/email_images/';						
						$crave_us = $configPay['crave_us'];						
						$item_body = "";
						$itemCount = count($itemNameListing);
						$iCount=1;
						
						foreach($itemNameListing as $itemListing)
						{
							$item_body .=  '<a class="gryclr hoverOrange" href="'.$itemListing['itemUrl'].'" >'.$itemListing['itemName'].'</a>';
							if($itemCount > $iCount)
							{
								$item_body .=', ';	
							}
							$iCount++;
						}
						
						$purchase_page_url = $base_url.'cart/purchase';
						$comment_url = $base_url.'cart/purchase';
						$dashboard_url = $base_url.'dashboard';
						$facebook_url = $configPay['facebook_follow_url'];
						$linkedin_url = $configPay['linkedin_follow_url'];
						$PurchaseBodyEmail=$PurchaseDataBody->templates;
						$purchaseGetArray = array("{crave_us}","{facebook_url}","{linkedin_url}","{item_body}","{purchase_page_url}" , "{dashboard_url}" ,"{site_url}" , "{site_base_url}", "{image_base_url}","{comment_url}");
						$purchaseReplaceArray = array($crave_us,$facebook_url,$linkedin_url,$item_body, $purchase_page_url, $dashboard_url, $site_url,$site_base_url,$image_base_url,$comment_url);
						$purchaseEmailBody=str_replace($purchaseGetArray, $purchaseReplaceArray, $PurchaseBodyEmail);
						$purchaseEmailSubject=$PurchaseDataBody->subject;
						
						//---------- This section for purchase tmail start------------//
						
						$where=array('purpose'=>'tmailpurchaseontoadsquare','active'=>1);
						
						//$purchaseTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
						
						$purchaseTemplateRes = getPurchasedTemplate('TDS_EmailTemplates','templates','subject','purpose', 'tmailpurchaseontoadsquare', 'active',1);											
												
						$purchaseTmailTemplate=$purchaseTemplateRes[0]->templates;
						$searchArray = array("{item_body}","{purchase_page_url}","{site_url}","{comment_url}");
						$replaceArray = array($item_body,$purchase_page_url,$site_url,$purchase_page_url);
						$purchaseTmailBody=str_replace($searchArray, $replaceArray, $purchaseTmailTemplate);
						$purchaseTmailSubject=$purchaseTemplateRes[0]->subject;
						
						$senderId = 0; //message send from toadsquare
						$recipients = $get_invoice_data->customerUid;
						
						send_tmail_template($recipients,$purchaseTmailBody,$purchaseTmailSubject);
						
						//---------- This section for purchase tmail end------------//						
						
						/*************get email body from database end*************/
					
						/*************get email body for sales from database start*************/
			
						$salesWhereCondi=array('purpose'=>'salesontoadsquare','active'=>1);
						//$SalesDataBody = getDataFromTabel('EmailTemplates','templates,subject',  $salesWhereCondi, '','', '', 1 );
						
						$SalesDataBody = getPurchasedTemplate('TDS_EmailTemplates','templates','subject','purpose', 'salesontoadsquare', 'active',1);
						
						$SalesDataBody = $SalesDataBody[0];
						
						$siteUrl = config::getInst()->getKeyValue("base_url");
						$base_url = config::getInst()->getKeyValue("base_url");
						
						$site_base_url = site_base_url();
						$image_base_url = site_base_url().'images/email_images/';
						$crave_us = $configPay['crave_us'];
						$salespage_url = $base_url.'cart/sales';
						$dashboard_url = $base_url.'dashboard';
						$facebook_url = $configPay['facebook_follow_url'];
						$linkedin_url = $configPay['linkedin_follow_url'];
						
											
						$SalesBodyEmail=$SalesDataBody->templates;
						$SalesGetArray = array("{crave_us}","{facebook_url}","{linkedin_url}","{item_body}","{salespage_url}" , "{dashboard_url}" ,"{site_url}" , "{site_base_url}", "{image_base_url}");
						$SalesReplaceArray = array($crave_us,$facebook_url,$linkedin_url, $item_body, $salespage_url, $dashboard_url, $site_url,$site_base_url,$image_base_url);
						$SalesEmailBody=str_replace($SalesGetArray, $SalesReplaceArray, $SalesBodyEmail);
						
						$SalesEmailSubject=$SalesDataBody->subject;						
						
						//--------------This section is used for sales tmail start------------------//						
						
						$where=array('purpose'=>'tmailsalesontoadsquare','active'=>1);
						//$salesTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
						
						$salesTemplateRes = getPurchasedTemplate('TDS_EmailTemplates','templates','subject','purpose', 'tmailsalesontoadsquare', 'active',1);
						
						
						$salesTmailTemplate=$salesTemplateRes[0]->templates;
						$searchArray = array("{item_body}","{salespage_url}");
						$replaceArray = array($item_body,$salespage_url);
						$SalesTmailBody=str_replace($searchArray, $replaceArray, $salesTmailTemplate);
						$SalesTmailSubject=$salesTemplateRes[0]->subject;
						
						$senderId = 0; //message send from toadsquare
						$recipients = $get_invoice_data->sellerId; 
						
						send_tmail_template($recipients,$SalesTmailBody,$SalesTmailSubject);					
						
						
						//--------------This section is used for sales tmail end------------------//
						
						
						/*************get email body from database end*************/
					
						/********attachment file create here start*******/
						$attachFileName=  '../invoices/'.$sale_order_no.'.'.'html';
						$handle = fopen($attachFileName, 'w');//create file here
						fwrite($handle, $getPurchasedTemplate); 
						/********attachment file create here end*******/
					
						//$buyer_email = "lokendrameena@cdnsol.com";
						//$seller_email = "rizwanshaikh@cdnsol.com";
					
						//------------------------------------------------//
						//------------Send Email to Buyer-----------------//
						//------------------------------------------------//
						
						
												
						send_email_template($buyer_email,'',$purchaseEmailBody,$purchaseEmailSubject,$attachFileName); 
						//$seller_email = "amitwali@cdnsol.com"; 
										
						//------------------------------------------------//
						//------------Send Email to Saler-----------------//
						//------------------------------------------------//
						
						send_email_template($seller_email,'',$SalesEmailBody,$SalesEmailSubject,$attachFileName);
								
						unlink($attachFileName); // attachment file delete here
						
						//------------------------------------------------------------------------//	
						//------------this section for event if purchase type is 5----------------//
						//------------------------------------------------------------------------//	
					 
						if($get_invoice_data->purchaseType=="5")
						{	
							//$this->email->from($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
						//	$this->email->reply_to($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
							$where=array('purpose'=>'event_ticket','active'=>1);
						//	$eventTicketTemplate=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
							$eventTicketTemplate=getPurchasedTemplate('TDS_EmailTemplates','templates','subject','purpose', 'event_ticket', 'active',1);
							$eventTicketSubject=$eventTicketTemplate[0]->subject;
							$eventTicketTemplate=$eventTicketTemplate[0]->templates;
							/* while we don't remove restriction (username, password) in .htacess file  from live site*/
							//$site_base_url = site_url('');
							
							$siteUrl = config::getInst()->getKeyValue("base_url");
						    $base_url = config::getInst()->getKeyValue("base_url");
							
							$site_base_url = site_base_url();
							$event_url = "";
							$image_base_url = site_base_url().'images/email_images/';
							$crave_us = $configPay['crave_us'];
							$purchasePageUrl = $base_url.'cart/purchase';
							$searchArray = array( "{event_name}","{event_url}", "{site_base_url}", "{image_base_url}","{crave_us}","{purchase_page_url}");
							$replaceArray = array($item_name,$event_url,$site_base_url,$image_base_url,$crave_us,$purchasePageUrl);
							$eventShowTemplate=str_replace($searchArray, $replaceArray, $eventTicketTemplate);
							$getInvoiceId =  $get_invoice_data->invoiceId;
							
							// Geneterate ticket for buyer
							event_ticket_pdf($getInvoiceId);
							
							$attachEventFileName = '../invoices/event_ticket.pdf';
							
							//--------------Event ticket tmail code start-----------------//	
							
							$where=array('purpose'=>'tmaileventicket','active'=>1);
							//$ticketTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
							
							$ticketTemplateRes=getPurchasedTemplate('TDS_EmailTemplates','templates','subject','purpose', 'tmaileventicket', 'active',1);
							$ticketTemplate=$ticketTemplateRes[0]->templates;
							$searchArray = array("{event_title}","{event_link}","{purchase_page_url}");
							$replaceArray = array($item_name,$event_url,$purchasePageUrl);
							$tickeTmailBody=str_replace($searchArray, $replaceArray, $ticketTemplate);
							$tickeTmailSubject=$ticketTemplateRes[0]->subject;
							
							$senderId = 0; //message send from toadsquare
							$recipientsBuyer = $get_invoice_data->customerUid;
							$bcc = $configPay['toadsquare_email'];
														
							//--------------Event ticket tmail code end-----------------//	
							//$buyer_email="lokendrameena@cdnsol.com";
							send_email_template($buyer_email,'',$eventShowTemplate,$eventTicketSubject,$attachEventFileName,$bcc);					
							unlink($attachEventFileName);  //
						}
						
					}
					
				}
		
			}
			
			//udpate invoice email status
			isInvoiceSent($orderId);
		}
	
	}
	
 function get_invoice_by_orderId($orderId) {
	 	 
	  $db = db_connect();	 					
      $SQL=' SELECT SalesOrderItem."invoiceId"            
			FROM "TDS_SalesOrderItem" SalesOrderItem		
			LEFT JOIN "TDS_SalesOrder" SalesOrder ON (SalesOrder."ordId" = SalesOrderItem."ordId")									
			WHERE SalesOrderItem."ordId" =  '.$orderId.' ';	
	   
	   $query= pg_query($db, $SQL);		  
	   if($query){
			  $data = pg_fetch_object($query);
			  $result['get_num_rows'] = pg_num_rows($query);
			  $result['get_result'] = $data;
		      return $result;			 
	     } else {
			  return false;
		} 
	}	
	
 /*
  * This function is used to show sales records details by invoice id
  * 
  */ 	
	
 function get_sales_record ($invoiceId)	{
	 
	 $db = db_connect();	 					
     $SQL=' SELECT SalesOrder."ordId",SalesOrder."custName",SalesOrder."ordNumber",SalesOrder."ordDateComplete",SalesOrder."ordCurrency",SalesOrderItem."itemId",SalesOrderItem."entityId",SalesOrderItem."sellerId",SalesOrderItem."invoiceId",SalesOrderItem."elementId",SalesOrderItem."itemQty",SalesOrderItem."basePrice",SalesOrderItem."itemName",SalesOrderItem."itemName",SalesOrderItem."purchaseType",SalesOrderItem."dispatchPrice",SalesOrderItem."tsGrossCommision",BuyerComments."rateSeller"            
			FROM "TDS_SalesOrderItem" SalesOrderItem		
			LEFT JOIN "TDS_SalesOrder" SalesOrder ON (SalesOrder."ordId" = SalesOrderItem."ordId")									
			LEFT JOIN "TDS_BuyerComments" BuyerComments ON (SalesOrderItem."itemId" = BuyerComments."itemId")									
			WHERE SalesOrderItem."invoiceId" =  \''.$invoiceId.'\' ';	
	   
	   $query= pg_query($db, $SQL);		  
	   if($query){
			  $data = pg_fetch_object($query);
			  $result['get_num_rows'] = pg_num_rows($query);
			  $result['get_result'] = $data;
		      return $result;			 
	     } else {
			  return false;
		} 	 	
	}
	
	
 /*
  ********************************************** 
  *  This function is used to get purchase details by itemId
  ********************************************** 
 */ 
 	
	function purchased_details_by_itemId($itemId) {
		
	 $db = db_connect();	 					
     $SQL=' SELECT SalesOrder.*,
            SalesOrderItem."itemId",SalesOrderItem."registrationId",SalesOrderItem."invoiceId",SalesOrderItem."entityId",SalesOrderItem."elementId",SalesOrderItem."itemQty",SalesOrderItem."sellerId",SalesOrderItem."sellerInfo",SalesOrderItem."basePrice",SalesOrderItem."itemName",SalesOrderItem."purchaseType",SalesOrderItem."receiverTransactionId"
            
			FROM "TDS_SalesOrderItem" SalesOrderItem		
			LEFT JOIN "TDS_SalesOrder" SalesOrder ON (SalesOrder."ordId" = SalesOrderItem."ordId")									
			WHERE SalesOrderItem."itemId" =  '.$itemId.' ';	
	   
	   $query= pg_query($db, $SQL);		  
	   if($query){
			  $data = pg_fetch_object($query);
			  $result['get_num_rows'] = pg_num_rows($query);
			  $result['get_result'] = $data;
		      return $result;			 
	     } else {
			  return false;
		} 	 	
	}	
		

 /*******
   * 
   * This function is used to get all items details by orderId
   * 
 * *****/
  
  function getItemsDetils($invoiceId) {
	  
	  $db = db_connect();	 					
      $SQL=' SELECT *
			FROM "TDS_SalesOrderItem"
			WHERE "invoiceId" =  \''.$invoiceId.'\' ';	
	   
	   $query= pg_query($db, $SQL);	
	   
	   if($query){
		  $result['get_num_rows'] = pg_num_rows($query); 		  
		  $result['get_result'] = array();		  
		    while ($row = pg_fetch_object($query)) {		  
		        $result['get_result'][] = $row;
		      }		  
		    return $result;
		    		    
	      }else  {
			  return false;
		    }
	}
	
	
 /*******
   * 
   * This function is used to get status of shipping service
   * 
 * *****/
  
  function isTakingShipping($invoiceId)	{
	  
	 $db = db_connect();	 					
     $SQL=' SELECT *
			FROM "TDS_SalesOrderItem"
			WHERE "invoiceId" =  \''.$invoiceId.'\' 
			AND "purchaseType" = 1 	';	
	   
	 $query= pg_query($db, $SQL);	
	   
	   if(pg_num_rows($query)>0)
	   {
			$result="yes";
		}else
		{
			$result="no";
		}
		return $result;
	}
	

/*******
   * 
   * This function is used to get template from database with single field
   * 
******/

	
 function getTemplateFromTabel($tableName='',$field='',$whereField='',$whereVal='',$whereField1='',$whereVal1=''){		 	
			 
      $db = db_connect();	 
      $SQL ='SELECT "'.$field.'" from "'.$tableName.'"  where "'.$whereField.'" = \''.$whereVal.'\'
             AND "'.$whereField1.'" = \''.$whereVal1.'\' LIMIT 1 ';
      
      $res = pg_query($db, $SQL ) ;   
   
		if($res){
			$result=array();			
			$data = pg_fetch_object($res);	
			  if($data!=''){		
			    $result[] = $data;				
			   } else {
				        $result='';
				      } 
		} 
		
		return $result;
		
		}
		
		

/*******
   * 
   * This function is used to get template from database with multiple fields
   * 
******/		
 	
 function getPurchasedTemplate($tableName='',$field='',$field1='',$whereField='',$whereVal='',$whereField1='',$whereVal1=''){	
	 	
	// $basketId =619;			 
      $db = db_connect();	 
      $SQL ='SELECT "'.$field.'","'.$field1.'"  from "'.$tableName.'"  where "'.$whereField.'" = \''.$whereVal.'\'
             AND "'.$whereField1.'" = \''.$whereVal1.'\' LIMIT 1 ';
      
      $res = pg_query($db, $SQL ) ;   
   
		if($res){
			$result=array();			
			$data = pg_fetch_object($res);	
			  if($data!=''){		
			    $result[] = $data;				
			   } else {
				        $result='';
				      } 
		} 
		
		return $result;
		
		}			
		
		
				
	
 /** Get userId on the basis of elementId and enitytId **/

	function getFrontEndLink($entityId=54,$elementId=61) {
		$projectLink='#';		
		$whereCondition=array('entityid'=>$entityId,'elementid'=>$elementId);
		//$result=getDataFromTabel('search', '*, (item).userid,(item).languageid,(item).element_type,(item).type',  $whereCondition, '','','',  $limit=1 );
		$result=getDataFromTabelWhereIn($entityId,$elementId);
		
		//$siteUrl = 'http://localhost/toadsquare/en';		
		$siteUrl = config::getInst()->getKeyValue("base_url");
				
		if($result && isset($result[0])){
			$search=$result[0];
			$section=$search->section;
			if($search->section=='upcoming'){
				switch ($search->sectionid) {
					case 1:
						$section='filmNvideo';
						break;
					case 2:
						$section='musicNaudio';
						break;
					case 3:
						$section='writingNpublishing';
						break;
					case 4:
						$section='photographyNart';
						break;
				}
				
			}
			switch ($section) {
				case 'filmNvideo':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?$siteUrl.'/upcomingfrontend/viewproject/'.$linkId.'filmvideo':$siteUrl.'/mediafrontend/searchresult/'.$linkId.'filmvideo';
					break;
				case 'musicNaudio':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?$siteUrl.'/upcomingfrontend/viewproject/'.$linkId.'musicaudio':$siteUrl.'/mediafrontend/searchresult/'.$linkId.'musicaudio';
					break;
				case 'photographyNart':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?$siteUrl.'/upcomingfrontend/viewproject/'.$linkId.'photographyart':$siteUrl.'/mediafrontend/searchresult/'.$linkId.'photographyart';
					break;
				case 'writingNpublishing':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?$siteUrl.'/upcomingfrontend/viewproject/'.$linkId.'writingpublishing':$siteUrl.'/mediafrontend/searchresult/'.$linkId.'writingpublishing';
					break;
				case 'educationMaterial':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?$siteUrl.'/upcomingfrontend/viewproject/'.$linkId.'educationmaterial':$siteUrl.'/mediafrontend/searchresult/'.$linkId.'educationmaterial';
					break;
				case 'performances&events':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=$siteUrl.'/eventfrontend/events/'.$search->element_type.'/'.$linkId;
					break;
				case 'event':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=$siteUrl.'/eventfrontend/events/'.$search->element_type.'/'.$linkId;
					break;
				case 'launch':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=$siteUrl.'/eventfrontend/events/'.$search->element_type.'/'.$linkId;
					break;
				case 'notification':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=$siteUrl.'/eventfrontend/events/'.$search->element_type.'/'.$linkId;
					break;
				case 'product':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=$siteUrl.'/productshowcase/viewproject/'.$linkId;
					break;
				case 'blog':
					$linkId=($search->elementid == $search->projectid)?'frontblog/'.$search->userid.'/'.$search->projectid.'/':'frontpost/'.$search->userid.'/'.$search->elementid.'/';
					$projectLink=$siteUrl.'/blogs/'.$linkId;
					break;
				case 'work':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=$siteUrl.'/workshowcase/viewproject/'.$linkId;
					break;
				case 'news':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?$siteUrl.'/upcomingfrontend/viewproject/'.$linkId.'news':$siteUrl.'/mediafrontend/searchresult/'.$linkId.'news';
					break;
				case 'reviews':
					$search->type=($search->elementid != $search->projectid)?$search->type:'';
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?$siteUrl.'/upcomingfrontend/viewproject/'.$linkId.'reviews':$siteUrl.'/mediafrontend/searchresult/'.$linkId.'reviews';
					break;
				case 'creatives':
					$linkId=$search->userid.'/';
					$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
					$projectLink=$siteUrl.'/showcase/index/'.$linkId;
					break;
				case 'associatedprofessionals':
					$linkId=$search->userid.'/';
					$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
					$projectLink=$siteUrl.'/showcase/index/'.$linkId;
					break;
				case 'enterprises':
					$linkId=$search->userid.'/';
					$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
					$projectLink=$siteUrl.'/showcase/index/'.$linkId;
					break;
				default:
					$projectLink='#';
			}
		}
				
		return $projectLink;
	}
	
	
 function getDataFromTabelWhereIn($entityId,$elementId){
			
	$db = db_connect();	 
    $SQL ='SELECT *, (item).userid,(item).languageid,(item).element_type,(item).type
           from "TDS_search"  where "entityid" ='.$entityId.'
             AND "elementid" = '.$elementId.' LIMIT 1 ';
      
      $res = pg_query($db, $SQL ) ;   
   
		if($res){
			$result=array();			
			$data = pg_fetch_object($res);	
			  if($data!=''){		
			    $result[] = $data;				
			   } else {
				        $result='';
				      } 
		} 
		return $result;
	 
	 }	
	
/*
 ***********
 * This functino return download period 
 *********** 
 */		
  
  function getDownloadPeriod($itemId){
	  
	$db = db_connect();	 
    $SQL ='SELECT "dwnDate","dwnMaxday"
           from "TDS_SalesItemDownload"  where "itemId" ='.$itemId.' ';
                 
      $res = pg_query($db, $SQL ) ; 
        
		if($res){
			//$result=array();			
			$data = pg_fetch_object($res);	
			  if($data!=''){		
			    $result = $data;				
			   } else {
				        $result='';
				      } 
		} 
		return $result;  
	  
	}	
		
	
  function getPurchaseType($purchaseType) {		
		
		switch($purchaseType)
		{
			case 1:
			$purchaseType='Product';
		    break;
		    case 2:
			$purchaseType='Download';
		    break;
		    case 3:
			$purchaseType='Pay Per View';
			break;
			case 4:
			$purchaseType='Donation';
			break;
			case 5:
			$purchaseType='Event';
		    break;
		    default:
				$purchaseType="None";
		}
			
		 return $purchaseType;
			
		}	
	
 /*
	****************************** 
	*  This functino is used to get site_base_url
	******************************  
 */ 
			
	function site_base_url(){
			//return base_url();
			return 'http://115.113.182.141/toadsquare_branch/dev/';					
		}
		
		
 /*
	 *************************************** 
	 * This function use for player module for view padi view
	 *************************************** 
 */ 
	 
	 
  function get_InvoiceId_Data($transactionId,$type=0) {
	
	$db = db_connect();	 					
      $SQL=' SELECT id
			FROM "TDS_SalesOrderInvoice"
			WHERE "receiverTransactionId" =  \''.$transactionId.'\' 
			AND "type" =  \''.$type.'\' ';	
	   
	   $query= pg_query($db, $SQL);	
	   
	   if($query){
		  $result['get_num_rows'] = pg_num_rows($query); 		  
		  //$result['get_result'] = array();		  
		    while ($row = pg_fetch_object($query)) {		  
		        $result['get_result'] = $row;
		      }		  
		    return $result;
		    		    
	      }else  {
			  return false;
		    }		 
		}	
		
function getInvoiceId($transactionId,$type=0) {	
		
		$result = get_InvoiceId_Data($transactionId,$type);
		 
		if($result['get_num_rows'] > 0)
		{
			
			$getId = $result['get_result']->id;
			$getNumberLenght = strlen($getId);
			switch($getNumberLenght)
			{
				case 1:
				$nvoiceId = 'TS00000'.$getId;
				break;
				case 2:
				$nvoiceId = 'TS0000'.$getId;
				break;
				case 3:
				$nvoiceId = 'TS000'.$getId;
				break;
				case 4:
				$nvoiceId = 'TS00'.$getId;
				break;
				case 5:
				$nvoiceId = 'TS0'.$getId;
				break;
				case 6:
				$nvoiceId = 'TS'.$getId;
				break;
				default:
				$nvoiceId = 'TS000000';
			}
			
		}else
		{
			$nvoiceId = 'TS000000';
		}
		
		 return $nvoiceId;
			
		}		
		
 		
	/*
	 ******************************************** 
	 * This section for creating event tickets
	 ******************************************** 
	 */ 
	
 function event_ticket_pdf($eventInvoiceId=0){	
	global $l;
		if($eventInvoiceId != '0'){
			
			$eventInvoiceData = ticket_invoice_data($eventInvoiceId);
			
		if(isset($eventInvoiceData) && !empty($eventInvoiceData)){								
				
				//$this->load->view('ticketPdf',$data) ;
				
     // create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(15, 10, 15);

//set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, 10);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

//Set custom fonts
$museo_slab_500 = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/museo_slab_500.ttf', 'TrueTypeUnicode', '', 32);
$OpenSans_bold = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/OpenSans-Bold-webfont.ttf', 'TrueTypeUnicode', '', 32);
$Opensans_semibold = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/opensans-semibold.ttf', 'TrueTypeUnicode', '', 64);
$helvetica_bold = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/19693_hvbl____.ttf', 'TrueTypeUnicode', '', 64);
$opensans_condbold = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/OpenSans-CondBold-webfont.ttf', 'TrueTypeUnicode', '', 64);
$helvetica_medium = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/helveticaneue-medium.ttf', 'TrueTypeUnicode', '', 72);
$opensans_regular = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/OpenSans-Regular-webfont.ttf', 'TrueTypeUnicode', '', 64);
$helvetica_regular = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/4864.ttf', 'TrueTypeUnicode', '', 64);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();


$knifeImgPath = '../images/ticket_images/knife.svg';
$event_img = '../images/ticket_images/event_tic.svg';
//$toad_logo = ROOTPATH.'images/toademaillogo_invoice.jpg';
$toad_logo = '../images/ticket_images/pdflolgotop.svg';
$bottom_toad_logo = '../images/ticket_images/tablelogo.svg';
$bottom_border = '../images/ticket_images/pdfborder.png';
$default_logo = '../images/ticket_images/square.svg';
$invoiceCount = count($eventInvoiceData);
$htmlBody = '';
$htmlHeader = '';
//Set some content to print

$htmlHeader.='<table>
	<tr>
		<td style="font-family:'.$museo_slab_500.';color:#f15c34; width:310px;font-size:24pt;text-align:left;line-height:8px;">
			Tickets 
		</td>
		<td style="font-family:'.$opensans_regular.';text-align:right;"><font style="color:#666666;"> Brought to you by</font><br/>
			<img src="'.$toad_logo.'">
		</td>
	</tr>
</table>';


$htmlHeader.= <<<EOD
<table>
	<tr>
		<td style="border-bottom: 1px solid #bdbec1" width="625px">	
		</td>
	</tr>
	<tr>
		<td style="height:8mm;">&nbsp;</td>
	</tr>
</table>
EOD;

$htmlBody .= $htmlHeader;

for($i=0;$i<count($eventInvoiceData);$i++){
	//Get all details of ticket event
	$ticketInfo = json_decode($eventInvoiceData[$i]->ticketInfo);
	//Set time formate
	$timeExp =explode(':' , $ticketInfo->startTime);	
	
	if(!empty($timeExp[1])) {
		$timeExp[1] = $timeExp[1];
	}else {
		$timeExp[1] = '';
	}
	$timeFormate = $timeExp[0].':'.$timeExp[1];		
	//Set day name like Sat
	$dayFormate = date("D", strtotime($ticketInfo->date));
	//Set day name like Saturday
	$fullDay = date("l", strtotime($ticketInfo->date));
	//Set date day like 13
	$dateNumeric = date("d", strtotime($ticketInfo->date));
	//Set date month & year like Apr 2013
	$monthYearFormate = date("M  Y", strtotime($ticketInfo->date));
	//Set date formate like Apr 13 April 2013
	$fullMonthYearFormate = date("d F  Y", strtotime($ticketInfo->date));
	//Set category Name
	if(isset($eventInvoiceData[$i]->category)){
		if($eventInvoiceData[$i]->category=='Free Tickets'){
			$ticketCategory = 'Free Ticket';
		}else{
			$ticketCategory = $eventInvoiceData[$i]->category;
		}
	}else{
		$ticketCategory = '';
	}

if(isset($ticketInfo->country) && !empty($ticketInfo->country)){	
	$userCountryName = getDataFromTabel('TDS_MasterCountry', 'countryName','countryId',$ticketInfo->country);
}else{ ''; }	
	$sessionTitle = (isset($ticketInfo->venueName) && !empty($ticketInfo->venueName)) ?$ticketInfo->venueName:'';
	$venueName = (isset($ticketInfo->venue) && !empty($ticketInfo->venue)) ? $ticketInfo->venue:'';
	$address = (isset($ticketInfo->address) && !empty($ticketInfo->address)) ? $ticketInfo->address:'';
	$city = (isset($ticketInfo->city) && !empty($ticketInfo->city)) ? $ticketInfo->city:'';
	$zip = (isset($ticketInfo->zip) && !empty($ticketInfo->zip)) ? $ticketInfo->zip:'';
	$state = (isset($ticketInfo->state) && !empty($ticketInfo->state)) ? $ticketInfo->state:'';
	//$country = (isset($ticketInfo->country) && !empty($ticketInfo->country)) ? userCountryName($ticketInfo->country):'';
	$country = $userCountryName;
	$eventTitle = (isset($ticketInfo->Title) && !empty($ticketInfo->Title)) ?$ticketInfo->Title:'';
	$url = (isset($ticketInfo->url) && !empty($ticketInfo->url)) ? $ticketInfo->url:'';	
	$phoneNumber = (isset($ticketInfo->phoneNumber) && !empty($ticketInfo->phoneNumber)) ? $ticketInfo->phoneNumber:'';
	if(isset($eventInvoiceData[$i]->price) && !empty($eventInvoiceData[$i]->price)){
		$price = '<tr>
				<td style="font-family:'.$opensans_condbold.';color: #231f20;text-align:center;font-size:13pt;">$'.$eventInvoiceData[$i]->price.'</td>
			</tr>';
	}else{
		$price = '<tr>
				<td></td>
			</tr>';
	}
	$eventTitle = str_replace("&apos;","&acute;",$eventTitle);
	
	$html[$i] = '<table style="border:8px solid #f15c34;" cellspacing="0" cellpadding="0">
		<tr>
			<td style="border-right:8px solid  #f15c34; vertical-align: top; width:130px;">
				<table cellpadding="6" cellspacing="6">
					<tr>
						<td>
							<table>
								<tr>
									<td style="font-family:'.$OpenSans_bold.';border-bottom: 1px solid #F15921;line-height:3px;color:#595a5c;font-size:10pt;">
									'.$dayFormate.'
									</td>
								</tr>
								<tr>
									<td></td>
								</tr>
								<tr>
									<td>
										<table>
											<tr>
												<td style="color:#ed1c24;font-weight:bold;width:25px;font-size:55px;height: 20px;line-height:1px;">'.$dateNumeric.'</td>
												<td style="font-family:'.$Opensans_semibold.';color:#595a5c;width:110px;font-size:10pt;line-height:2px;">'.$monthYearFormate.'</td>
											</tr>
											<tr>
												<td style="width:52px;"></td>
												<td style="font-family:'.$Opensans_semibold.';color:#595a5c;text-align:left;font-size:10pt;line-height:-1px;height: 20px;">'.$timeFormate.'</td>
											</tr>
										</table>
									</td>
								</tr>
								
								<tr>
									<td style="text-align:center;">
										<img src="'.$default_logo.'">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>			
			<td style="font-family:'.$opensans_regular.';border-right: 1px dashed #f15c34;vertical-align: top;width:355px">
				<table cellpadding="6" cellspacing="6">
					<tr>
						<td>
							<table >
								<tr>
									<td style="border-bottom: 1px solid #fff;line-height:3px;width:50px;"></td>
									<td style="font-family:'.$Opensans_semibold.';border-bottom: 1px solid #F15921;line-height:3px;color:#231f20;width:auto;font-size:10pt;">'.$sessionTitle.'</td>
								</tr>
								<tr>
									<td style="width:50px;"></td>
									<td style="font-family:'.$OpenSans_bold.';color:#231f20;width:220px;font-size:10pt;">
									'.$venueName.'</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style="width:50px;"></td>
									<td style="color:#414142;">'.$address.'</td>
								</tr>';
					
					if($city!="")
					{
					$html[$i] .=	'<tr>
									<td style="width:50px;"></td>
									<td style="color:#414142;">'.$city.'</td></tr>';
					}
					
					if($zip!="")
					{
					$html[$i] .=	'<tr>
									<td style="width:50px;"></td>
									<td style="color:#414142;">'.$zip.'</td>
									</tr>';
					}
				
					$html[$i] .= '
								
								<tr>
									<td style="width:50px;"></td>
									<td style="color:#414142;">'.$state.'</td>
								</tr>
								<tr>
									<td style="width:50px;"></td>
									<td style="color:#414142;">'.$country.'</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<table>	
								<tr>
									<td style="font-family:'.$opensans_condbold.';border-top:solid 1px #444; border-bottom:solid 1px #444; color:#595a5c;font-size:15pt;">'.$eventTitle.'
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td style="width:140px;">
				<table cellpadding="6" cellspacing="6">
					<tr>
						<td>
							<table>
								<tr>
									<td style="font-family:'.$helvetica_bold.';text-align:center;font-size:9pt;color: #595a5c;">'.$eventInvoiceData[$i]->userName.'<br/></td>
								</tr>
								<tr>
									<td style="font-family:'.$Opensans_semibold.';color:#f15a2b;text-align:center;font-size:10pt;">'.$ticketCategory.'</td>
								</tr>
								'.$price.'
								<tr>
									<td style="color: #818385;font-weight:bold;text-align:center;">ONE<br/></td>
								</tr>
								
								<tr>
									<td style="color: #414142;text-align:center;">'.$fullDay.'</td>
								</tr>
								<tr>
									<td style="font-family:'.$opensans_regular.';color: #414142;text-align:center;">'.$fullMonthYearFormate.'</td>
								</tr>
								<tr>
									<td style="color: #414142;text-align:center;">'.$timeFormate.'</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
			
		<tr>
			<td style="border-right:8px solid  #f15c34; width:130px;">
				<table cellpadding="6" cellspacing="6">
					<tr>
						<td>
							<table>
								<tr>
									<td style="font-family:'.$Opensans_semibold.';color: #f15a2b;text-align:center;font-size:10pt;">'.$ticketCategory.'</td>
								</tr>
								'.$price.'
								<tr>
									<td style="font-family:'.$Opensans_semibold.';color: #bdbec1;text-align:center;font-size:14pt;line-height:1px;">ONE</td>
								</tr>
							</table>
						</td>
					</tr>			
				</table>
			</td>
			<td style="border-right: 1px dashed #f15c34;width:355px">
				<table cellpadding="6" cellspacing="6">
					<tr>
						<td>
							<table>
								<tr>
									<td>
										<table>
											<tr>
												<td style="height:3mm;">&nbsp;</td>
												<td style="height:3mm;">&nbsp;</td>
											</tr>
											<tr>
												<td style="font-family:'.$Opensans_semibold.';color:#595a5c;width:210px;font-size:10pt;">'.$phoneNumber.'</td>
												<td style="font-family:'.$helvetica_regular.';color:#595a5c;font-size:10pt;">'.$eventInvoiceData[$i]->userName.'</td>
											</tr>
											<tr>
												<td style="font-family:'.$opensans_regular.';color:#414142;width:210px;font-size:9pt;">'.$url.'</td>
												<td style="font-family:'.$helvetica_regular.';color: #f15a2b;font-size:10pt;">'.$eventInvoiceData[$i]->ticketNumber.'</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>			
				</table>
			</td>
			<td style="width:140px;">
				<table cellpadding="6" cellspacing="6">	
					<tr>
						<td style="font-family:'.$helvetica_regular.';color: #f15a2b;text-align:center;font-size:10pt;line-height:12px;">'.$eventInvoiceData[$i]->ticketNumber.'																	
						</td>
					</tr>																							
				</table>
			</td>
		</tr>
	</table>
	<table style="width:686px">
		<tr>
			<td style="width:617px;"></td>
			<td><img src="'.$knifeImgPath.'" style="line-height:3px"></td>
		</tr>
		<tr>
			<td style="height:2mm;">&nbsp;</td>
		</tr>
	</table>';
	$htmlBody .= $html[$i];
	if($i % 2 == 1){
		$invoicelast = $invoiceCount-1;
		if($i!=$invoicelast){	
			$htmlBody .='<table style="width:686px">
			<tr>
				<td style="height:80mm;">&nbsp;</td>
			</tr>
			</table>';	
			$htmlBody .= $htmlHeader;
		}
	}	
}	

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $htmlBody, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->Output('../invoices/event_ticket.pdf', 'F'); 
			
		}
	}	
 }		
		/* Function to get invoice event data */
 function ticket_invoice_data($invoiceId=0){
	
	$db = db_connect();	 					
    $SQL=' SELECT *
			FROM "TDS_TicketTransectionLog"
			WHERE "invoiceId" =  \''.$invoiceId.'\' 
			order by "ticketNumber" ASC  ';	
	   
	   $query= pg_query($db, $SQL);	   
		 // $result['get_num_rows'] = pg_num_rows($query); 		  	   
		if(pg_num_rows($query)>0){			   			   
				//$result['get_num_rows'] = pg_num_rows($query); 		  
				$result = array();		  
				while ($row = pg_fetch_object($query)) {		  
				$result[] = $row;   
			   
			 } 
	    } 
	    
	    return $result; 	 
  }	
		
		
 /*******
   * 
   * This function is used to get session date and time
   * 
  * *****/
  
  function get_Session_Details($sessionId)	{	  
	
	$db = db_connect();	 					
      $SQL=' SELECT "date", "startTime"
			FROM "TDS_EventSessions"
			WHERE "sessionId" =  \''.$sessionId.'\' ';	
	   
	   $query= pg_query($db, $SQL);	
	   
	   if($query){
		  $result['get_num_rows'] = pg_num_rows($query); 		  
		  //$result['get_result'] = array();		  
		    while ($row = pg_fetch_object($query)) {		  
		        $result['get_result'] = $row;
		      }		  
		    return $result;
		    		    
	      }else  {
			  return false;
		    }
	  
	}		
		
 /*
  ********************************************** 
  *  This function is used update invoice email status change
  ********************************************** 
 */ 
 	 		 
 function isInvoiceSent($orderId)  {	 
	$db = db_connect();		  	  
	$rec = pg_query($db, 'UPDATE "TDS_SalesOrder" SET "isInvoiceSent" = \'t\' WHERE "ordId" = '.$orderId .' ') ;	
	return true;	 
	
 	}	
 
 /*
  ********************************************** 
  *  This function is used to remove items from basket n basket item
  ********************************************** 
 */ 	
 
 function deleteBasket($trackingId='') {
	if($trackingId!='') { 
		
		  $res = getDataFromTabel('TDS_SalesCustomersBasket', 'basketId',  'trackingId',$trackingId);
			
		if(isset($res) && $res!=''){
			 $basketId =  $res;
			 deleteRowFromTabel('TDS_SalesBasketItem', 'basketId', $basketId);			 
			 deleteRowFromTabel('TDS_SalesCustomersBasket', 'basketId', $basketId);
	   }		
    } 
}	
 
 
/*
  ********************************************** 
  *  This function is used to remove items from basket n basket item
  ********************************************** 
 */ 
 
function deleteRowFromTabel($tableName,$field,$value){	 

	   $db = db_connect();
	   $sql = 'DELETE  FROM "'.$tableName.'"                   
               WHERE "'.$field.'" = '.$value.'   ';              
	   pg_query($db, $sql ) ;
	   return true;	  			
	}	 
 	
		
					
?>
