<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*** 
	 * written by Sushil Mishra 
	 * Date 01-02-2013 
	 * payment Class 
	 * @access	public
	 * @param	
	 * @return	
****/

class Payment extends MX_Controller {
	private $data = array();
	private $userId = null;
	/** Constructor **/
	function __construct() {
		$load = array(
		'model' 	=> 'cart/model_cart + tmail/model_tmail',
		'library' 	=> 'tmail/Tmail_messaging',	
		'language' 	=> 'membershipcart'				
		);
		parent::__construct($load);				
		//$this->head->add_css($this->config->item('system_css').'frontend.css');		
		//$this->head->add_css($this->config->item('default_css').'template.css');	
		$this->userId = isLoginUser();
		//$this->load->model('model_common');
	}
	
	/*function process($Process='',$trackingId=''){
		
		$view = 'transetion_details';
		switch ($Process) {
			case 'confirmation': 					// IF PAYPAL RETURN CONFIRMATION 
				$this->getTransetionDetails($trackingId);
				if( $this->data['purchaseItem']){
					$this->data['paymentHeading'] = $this->lang->line('paymentConfirmation');
					$this->data['paymentMessage'] = 'Thank you for shopping on Toadsquare.';
				}else{
					$this->data['paymentHeading'] = $this->lang->line('noTransectionFound');
					$this->data['paymentMessage'] = $this->lang->line('noTransectionFoundMsg');
				}
			break;
			
			case 'cancel': // IF PAYPAL RETURN CANCEl 
				$this->data['paymentHeading'] = $this->lang->line('paymentConfirmation');
				$this->data['paymentMessage'] = $this->lang->line('cancelPurchase');
			break;
			
			case 'paypalerror': // IF PAYPAL RETURN CANCEl 
				$this->data['paymentHeading'] = 'Paypal Transaction Error';
				$this->data['paymentMessage'] = 'Paypal is not responding. Please try after some time.';
			break;
			
			case 'transactionerror': // IF PAYPAL RETURN CANCEl 
				$this->data['paymentHeading'] = 'Paypal Transaction Error';
				$this->data['paymentMessage'] = 'Transaction is pending,we will send you confirmation email.';
			break;
			
			case 'paymenterror': // IF PAYPAL RETURN CANCEl 
				$this->data['paymentHeading'] = 'Paypal Transaction Error';
				$this->data['paymentMessage'] = 'Paypal is not responding. Please try after some time.';
				$view = 'membership_details';
			break;
			
			case 'canceltransaction': // IF PAYPAL RETURN CANCEl 
				$this->data['paymentHeading'] = $this->lang->line('paymentConfirmation');
				$this->data['paymentMessage'] = $this->lang->line('cancelPurchase');
				$view = 'membership_details';
			break;
			
			
			default: 
				$this->data['paymentHeading'] = $this->lang->line('paymentNotCompleted');
				$this->data['paymentMessage'] = $this->lang->line('paymentNotCompletedMsg');
			break;
		}
		
		$this->template->load('frontend',$view,$this->data);
	}*/
    
    //-----------------------------------------------------------------------
    
    /*
    * @description: This method is use to show cart payment status
    * @param: payment status
    * @param: trackingId
    * @return: void
    * @auther: lokendra meena
    */ 
    
    public function process($Process='paymenterror',$trackingId=''){
        switch ($Process){
            case 'confirmation': // IF PAYPAL RETURN CONFIRMATION 
                if(!empty($trackingId)){
                    $this->getTransetionDetails($trackingId);
                }
                if(isset($this->data['purchaseItem'])){
                    $this->_shoppingcartpaymentsuccess();
                }else{
                    $this->data['paymentHeading'] = 'No Transection <br> Found.';
                    $this->data['paymentMessage'] = $this->lang->line('noTransectionFoundMsg');
                    $this->_shoppingcarterror();
                }
            break;
            
            case 'cancel': // IF PAYPAL RETURN CANCEl 
                $this->data['paymentHeading'] = 'Payment <br> Confirmation';
                $this->data['paymentMessage'] = $this->lang->line('cancelPurchase');
                 $this->_shoppingcarterror();
            break;
            
            case 'paypalerror': // IF PAYPAL RETURN CANCEl 
                $this->data['paymentHeading'] = 'Paypal Transaction <br> Error';
                $this->data['paymentMessage'] = 'Paypal is not responding. Please try after some time.';
                 $this->_shoppingcarterror();
            break;
            
            case 'transactionerror': // IF PAYPAL RETURN CANCEl 
                $this->data['paymentHeading'] = 'Paypal Transaction <br> Error';
                $this->data['paymentMessage'] = 'Transaction is pending,we will send you confirmation email.';
                 $this->_shoppingcarterror();
            break;
            
            default: 
                $this->data['paymentHeading'] = 'Payment process <br> not completed';
                $this->data['paymentMessage'] = $this->lang->line('paymentNotCompletedMsg');
                $this->_shoppingcarterror();
            break;
        }
    }
    
    //----------------------------------------------------------------------

    /*
    * @access: private
    * @description: This method is use to show shopping cart success message
    * @return:void
    * @auther: lokendra meena
    */ 
    
    private function _shoppingcartpaymentsuccess(){
        $this->data['packagestageheading']         =   $this->lang->line('shoppingcart');  #set package heading
        $this->data['shoppingCartStage']           =   'stage3';  #set package heading 
        $this->new_version->load('new_version','shopping_cart_payment_success',$this->data);
    }
    
    //----------------------------------------------------------------------

    /*
    * @access: private
    * @description: This method is use to show shopping cart paypal error
    * @return:void
    * @auther: lokendra meena
    */ 
    
    private function _shoppingcarterror(){
        $this->data['packagestageheading']         =   $this->lang->line('shoppingcart');  #set package heading
        $this->data['shoppingCartStage']           =   'stage3';  #set package heading 
        $this->new_version->load('new_version','shopping_cart_paypal_error',$this->data);
    }
  

	function getTransetionDetails($trackingId=''){	  
		 
		  $transetionDetails = array();
		  $purchaseItem=false;
		  $buyerDetail='';
		  if($trackingId !=''){
			  
			  // Delete Customer Basket & item
			  $this->deleteBasket($trackingId);
			  
			  $buyerDetail = $this->model_cart->getBuyerInfo($trackingId);
			  if($buyerDetail)	
			  $buyerDetail = $buyerDetail[0];		
			  
			  $purchaseItem=$this->model_cart->getTransetionDetails($trackingId);
			  
			  if(is_array($purchaseItem) && isset($purchaseItem) && count($purchaseItem)>0) {	 
				
				$i=0;	  	   
				foreach ($purchaseItem as $key=>$items) {	 
					
					$entityId = $items->entityId ;
					$elementId = $items->elementId;
					$projId = $items->projId;
					$sectionId = $items->sectionId;
					$purchaseType = $items->purchaseType;
					
					$sellerInfo=$items->sellerInfo;
					$sellerInfo=json_decode($sellerInfo);
					
					$isticketPrice=false;
					if($entityId == 66){ //ticketPurchase
						if(isset($sellerInfo->entityIdPE)){
							$isticketPrice=true;
							$entityIdPE=$sellerInfo->entityIdPE;
							$entityIdSession=getMasterTableRecord('EventSessions');
							$SessionId=$sellerInfo->SessionId;
						}
					}
					
					if($purchaseType == 4){ // for donate
						$image =$this->config->item('defaultDonateImg');
						$image = getimage($image);		
					}else{
						if($isticketPrice){
							$image = $this->getImageInfo($entityIdPE,$projId,$sectionId);
						}else{
							$image = $this->getImageInfo($entityId,$elementId,$sectionId);
						}
					}
					$purchaseItem[$key]->image=$image;
					
					if($isticketPrice){
						$ProductInfo=$this->getProductInfo($entityIdPE,$projId,$purchaseType);
						$purchaseItem[$key]->ticketcategory=$sellerInfo->ticketcategory;
						$purchaseItem[$key]->isFree=$sellerInfo->isFree;
					}else{
						$ProductInfo=$this->getProductInfo($entityId,$elementId,$purchaseType);	
					}
					 
					
					if($ProductInfo){
						$purchaseItem[$key]->title=$ProductInfo[0]->title;
						$purchaseItem[$key]->description=$ProductInfo[0]->description;
					}
					
					/*Change buyers status after purchase for auction*/
					$sellType = $this->getSellType($entityId,$elementId);
					
					if(isset($sellType) && $sellType==2) {
						//Manage winners status
						$autionWinnerRes = $this->changeAuctionWinnerStatus($entityId,$elementId,$projId,$items->customerUid);
					}	
				 }
				 
					  
			 }
		 }
		 
		 $this->data['buyerDetail'] = $buyerDetail ;
		 $this->data['purchaseItem']=$purchaseItem;	    
		  
	}
	
	/*
	 * This function used to get sell type of product 
	 */			
	function getSellType($entityId=0,$elementId=0) {
		if(isset($entityId) && !empty($entityId) && isset($elementId) && !empty($elementId)) {
			$getElementTable = getMasterTableName($entityId);
			$getElementTable = $getElementTable[0];
			$isTable = true;
			//Set project where clause and fields name
			switch($getElementTable) {
				case 'TDS_Product':
				$sellTypeRes = $this->model_common->getDataFromTabel($getElementTable, 'productSellType',  array('productId'=>$elementId),'','','','');
				$sellType = $sellTypeRes[0]->productSellType;
				break;
				default:
				$isTable = false;
				$sellType = 0;
			}
		} else {
			$sellType = 0;
		}
		return $sellType;
	}
	
	/*
	 * This function used to change buyers status after purchase in auction
	 */
	function changeAuctionWinnerStatus($entityId=0,$elementId=0,$projId=0,$buyerId=0) {
	
		$isStatusChange = false; //Set default status
		//Get auction record
		if(isset($entityId) && !empty($entityId) && isset($elementId) && !empty($elementId) && isset($projId) && !empty($projId)) {
			$bidRes = $this->model_common->getDataFromTabel('Auction', 'auctionId',  array('entityId'=>$entityId,'elementId'=>$elementId,'projectId'=>$projId),'','','','');
			//Set auction params
			$auctionId = $bidRes[0]->auctionId;
			
			if(isset($auctionId)) {
				//Get auctions bid record
				$bidwinnerRes = $this->model_common->getDataFromTabel('AuctionBids', 'bidId',  array('auctionId' =>$auctionId,'userId'=>$buyerId,'isWinnerExpire'=>'f'),'','','',1);
				$bidId = $bidwinnerRes[0]->bidId;
		
				//Get winner record
				$winnerRes = $this->model_common->getDataFromTabel('AuctionWinners', 'winnerId',  array('bidId' =>$bidId,'userId'=>$buyerId),'','','',1);
				$winnerId = $winnerRes[0]->winnerId;
				
				//Update winners status as successfull purchase
				if(isset($winnerId)) {
					$winner['invitationStatus'] = 2;
					$this->model_common->editDataFromTabel('AuctionWinners', $winner, 'winnerId', $winnerId);
					
					//Close auction after purchase
					$auction['isAuctionClosed'] = 't';
					$this->model_common->editDataFromTabel('Auction', $auction, 'auctionId', $auctionId);
					$isStatusChange = true;
				}
			}
		}
		return $isStatusChange;
	}
	
	
	function manageProductQuantity($purchaseProductDetails=''){ 
		if(is_array($purchaseProductDetails) && count($purchaseProductDetails) > 0){
			$entityId=$purchaseProductDetails['entityId'];
			$elementId=$purchaseProductDetails['elementId'];
			$purchaseType=1;
			
			
			$ProductInfo=$this->getProductInfo($entityId,$elementId,$purchaseType);
			
			
			
			if($ProductInfo && isset($ProductInfo[0]->aviliableqty) && $ProductInfo[0]->aviliableqty > 0){
				$prevQty=$ProductInfo[0]->aviliableqty;
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
						$where=array('productId'=>$elementId);
						$updateData=array('productQuantity'=>$availableQty);
					break;
						
					case 'TDS_Tickets':
						$where=array('TicketId'=>$elementId);
						$updateData=array('Quantity'=>$availableQty);
					break;
								
					case 'TDS_Project':
						$where=array('projId'=>$elementId);
						$updateData=array('projQuantity'=>$availableQty);
					break;
					
					case 'TDS_EmElement':
					case 'TDS_FvElement':
					case 'TDS_MaElement':
					case 'TDS_PaElement':
					case 'TDS_WpElement':
						$where=array('elementId'=>$elementId);
						$updateData=array('quantity'=>$availableQty);
					break;
					
					default:
						$isTableFound=false;
					break;			
				}
				if($isTableFound){
					$result=$this->model_common->editDataFromTabel($tableName, $updateData, $where);
					if($result){
						$this->model_common->addDataIntoTabel('ProductQuantityLog',$purchaseProductDetails);
					}
				}
			}
		}
	}

	function getProductInfo($entityId=0,$elementId=0,$purchaseType=1){
		$cartDetails=false;
		if( $entityId >0 && $elementId > 0){
			$entity_tableName = getMasterTableName($entityId);
			$tableName= $entity_tableName[0];
			$isTableFound=true;
			switch ($tableName){	
				case 'TDS_Product':
					$owner = 'tdsUid';
					$title = 'productTitle as title';
					$itemPrice = 'productPrice as price';
					$description = 'productOneLineDesc as description' ;
					$quantity = 'productQuantity as aviliableqty' ;
					$whereId = 'productId';														
					break;
							
				case 'TDS_Project':
					$owner = 'tdsUid';
					$title = 'projName as title';
					
					if($purchaseType==2){ 						// download
						$itemPrice = 'projDownloadPrice as price';
					}elseif($purchaseType==3){ 					// pay per view
						$itemPrice = 'projPpvPrice as price';
					}else{										// product price
						$itemPrice = 'projPrice as price';
					}
					
					$description = 'projShortDesc as description' ;
					$quantity = 'projQuantity as aviliableqty' ;				
					$whereId = 'projId';						
				break;
				
				case 'TDS_EmElement':
				case 'TDS_FvElement':
				case 'TDS_MaElement':
				case 'TDS_PaElement':
				case 'TDS_WpElement':
					$owner = 'tdsUid';
					$title = 'title';
					if($purchaseType==2){ 						// download
						$itemPrice = 'downloadPrice as price';
					}elseif($purchaseType==3){ 					// pay per view
						$itemPrice = 'perViewPrice as price';
					}else{										// product price
						$itemPrice = 'price';
					}
					
					$description = 'description' ;
					$quantity = 'quantity as aviliableqty' ;				
					$whereId = 'elementId';						
				break;
				
				case 'TDS_NewsElement':
				case 'TDS_ReviewsElement':
					$owner = 'tdsUid';
					$title = 'title';
					$itemPrice = '';
					$description = 'description' ;
					$quantity = '' ;			
					$whereId = 'elementId';						
				break;
				
				case 'TDS_Blogs':
					$owner = 'custId as "tdsUid"';
					$title = 'blogTitle as title';
					$itemPrice = '';
					$description = 'blogOneLineDesc as description' ;
					$quantity = '' ;
					$whereId = 'blogId';														
					break;
				break;
				
				case 'TDS_UpcomingProject':
					$owner = 'tdsUid';
					$title = 'projTitle as title';
					$itemPrice = '';
					$description = 'proShortDesc as description' ;
					$quantity = '' ;
					$whereId = 'projId';														
					break;
				break;
				
				case 'TDS_Events':
					$owner = 'tdsUid';
					$title = 'Title as title';
					$itemPrice = '';
					$description = 'OneLineDescription as description' ;
					$quantity = '' ;
					$whereId = 'EventId';														
					break;
				break;
				
				case 'TDS_LaunchEvent':
					$owner = 'tdsUid';
					$title = 'Title as title';
					$itemPrice = '';
					$description = 'OneLineDescription as description' ;
					$quantity = '' ;
					$whereId = 'LaunchEventId';														
					break;
				break;
				
				case 'TDS_Tickets':
					$owner = '';
					$title = '';
					$itemPrice = '';
					$description = '' ;
					$quantity = 'Quantity as aviliableqty' ;
					$whereId = 'TicketId';		
				break;
				
				
				default:
					$isTableFound=false;
				break;			
			}
			
			if($isTableFound){
				
				$selectfields = '';
				$isSelectfields = false;
				if(isset($title) && $title != '' ){
					$selectfields = $title;
					$isSelectfields = true;
				}
				if(isset($description) && $description != '' ){
					if($isSelectfields){
						$selectfields = $selectfields.','.$description;
					}else{
						$selectfields = $description;
					}
				}
				if(isset($owner) && $owner != '' ){
					if($isSelectfields){
						$selectfields = $selectfields.','.$owner;
					}else{
						$selectfields = $owner;
					}
				}
				if(isset($itemPrice) && $itemPrice != '' ){
					if($isSelectfields){
						$selectfields = $selectfields.','.$itemPrice;
					}else{
						$selectfields = $itemPrice;
					}
					
				}		
				if(isset($quantity) && $quantity != '' ){
					if($isSelectfields){
						$selectfields = $selectfields.','.$quantity;
					}else{
						$selectfields = $quantity;
					}
					
				}		
				$where = array($whereId=>$elementId);
				$cartDetails=$this->model_cart->getProductInfo($tableName,$selectfields,$where);
			}
		}
		return $cartDetails;
	}
	
	function getImageInfo($entityId=0,$elementId=0,$sectionId=0){	
		if( $entityId >0 && $elementId > 0){
			$entity_tableName = getMasterTableName($entityId);
			$tableName= $entity_tableName[0];
			$isTableFound=true;	
			$thumbFolder= 'thumb';		
			switch ($tableName){	
				case 'TDS_Product':				
					$image = $this->model_cart->getProductImage($elementId);						
				break;
				
				case 'TDS_Project':
					$imagePath = 'projBaseImgPath as imagepath';					
					$whereId = 'projId';
					
					$selectfields =$imagePath;			
				    $where = array($whereId=>$elementId);
				    $getImage = $this->model_cart->getMediaImage($tableName,$selectfields,$where);		
				    /********make element image as project image code add********/
				    if(empty($getImage)){
						$image = getElementImageByType($elementId,$sectionId);
					}else{
						$image = $getImage;
					}	
					/********make element image as project image code add********/																		
					break;							
								
				case 'TDS_EmElement':
				case 'TDS_FvElement':
				case 'TDS_MaElement':			
				case 'TDS_WpElement':
					//$owner = 'tdsUid';
					$imagePath = 'imagePath as imagepath';					
					$whereId = 'projId';
					
					//$selectfields =$imagePath.','.$owner;				
					$selectfields =$imagePath;				
					$where = array($whereId=>$elementId);
					$image = $this->model_cart->getMediaImage($tableName,$selectfields,$where);		
					/********make video capture image as element image code add********/
						if($tableName=="TDS_FvElement"){
							if(empty($image)){
								$image = getProjectElementImage(0,$entityId,$elementId);
							}
						}
					/********make video capture image as element image code add********/										
				    break;
				    
				case 'TDS_WpElement':
					//$owner = 'tdsUid';
					$imagePath = 'imagePath as imagepath';					
					$whereId = 'projId';
					
					//$selectfields =$imagePath.','.$owner;		
					$selectfields =$imagePath;				
					$where = array($whereId=>$elementId);
					$image = $this->model_cart->getMediaImage($tableName,$selectfields,$where);											
				    break;
				
				case 'TDS_PaElement':
					$image = $this->model_cart-> getPnArtImage($tableName,'elementId',$elementId ,'fileId');
					$thumbFolder= 'watermark';		
				break;
				
				case 'TDS_Events':
					$image = $this->model_cart-> getPnArtImage($tableName,'EventId',$elementId ,'FileId');
				break;
				
				case 'TDS_LaunchEvent':
					$image = $this->model_cart-> getPnArtImage($tableName,'LaunchEventId',$elementId ,'FileId');
				break;				
				
				default:
					 $image = '';
				break;					
					
			}
						
		}
	
	$section=str_replace(':','_',$sectionId);
	
	if($this->config->item('sectionImage'.$section)){
		$imageType=$this->config->item('sectionImage'.$section);
	}else{
		$imageType=$this->config->item('sectionIdImage'.$section);
	}
	$imageType='images/default_thumb/'.$imageType;
	
	if(is_array($image)){
		$image = $image['filePath'];
	}else{
		if( $image !=''){
			$image=addThumbFolder($image,$suffix='_xs',$thumbFolder,$imageType); 
		} 	
		$image=getImage($image,$imageType);	
	}
	return $image;	  
	  
  }


	/**************Dummy working end**************/
	
	function testipn(){
		/*$insert['info'] = 'saveOrderDetails';
		$this->db->insert('test', $insert);
		 
		 die;
		 */
		foreach ($_REQUEST as $key => $value) { $message .= "\n$key: $value<br>"; } 
		
		$message .= 'currentbasket'.$this->input->get('currentbasket') ; 
		$this->email->from('your@example.com', 'Your Name');
		$this->email->to('amitwali@cdnsol.com');
		$this->email->subject('subject');
		$this->email->message($message);
		$this->email->send();   
	  
	 } 
	 
	 
 function updateOrderPaypalLog($trackingId,$orderId){	 
	 $updateData=array('ordId'=>$orderId); 
	 $this->db->where('trackingId',$trackingId);		
	 $this->db->update('PaypalTransactionLog', $updateData);
	 return true;	 
	 }
	
	
	function saveOrderDetails($trackingId,$isfree=0){
	
		$res = $this->model_common->getDataFromTabel('SalesCustomersBasket', 'basketId',  array('trackingId' =>$trackingId),'','','',1);
		
		if(isset($res[0]->basketId) && $res[0]->basketId !=''){
			 $basketId =  $res[0]->basketId;
		
			if($isfree==1){
				$getData = '';
				$transId = '';	
			}else{
				$getData = Modules::run("paypal/adaptive_payments/Payment_details",$trackingId);
				$getTransactiondata = json_decode($getData);			
				$transId = $getTransactiondata->paymentInfoList->paymentInfo[0]->transactionId;	
				$paypalStatus = $getTransactiondata->responseEnvelope->ack;	
				$transId = (isset($transId) && ($transId) ) ? $transId : 0;
			}
		
		
			
			 $currency = $this->model_common->getDataFromTabel('SalesBasketItem', 'currency',  array('basketId' =>$basketId),'','','',1);
			 $currencyId = (isset($currency[0]->currency) && ($currency[0]->currency!='')) ? $currency[0]->currency :  0;  	
		
			// ADD DATA IN SalesOrderItem	 
			$orderId = $this->insertSalesOrder($basketId,$currencyId,$transId,$getData,$trackingId);
			
			if($isfree==0){
				$this->updateOrderPaypalLog($trackingId,$orderId); 
			}
			// Update  DATA IN SalesOrderItem
			$this->insertSalesOrderItem($basketId,$currencyId,$orderId,$transId,$isfree=0);
			
			if($orderId > 0 && $basketId > 0){
				$this->invoiceSendToEmail($orderId);
				redirect('payment/process/confirmation/'.$trackingId);
			}
			
        }else{
			 redirect('payment/process/error');
		}
    
    }
 
 
 /* Get Currency ID acording to paypal return currency*/
 function getCurrencyID($currency='EUR') {
   
		switch ($currency){			
			case 'USD':
			$cId=1;
			break;	

			default:	
			$cId=0;		 		 	
		}
			  
	  return $cId;		 
  }
 
 
 
 function insertSalesOrder ($basketId,$currencyId,$transId='',$getData='',$trackingId) {
	   
   $res = $this->model_common->getDataFromTabel('SalesOrder', 'ordId',  array('trackingId' =>$trackingId),'','','',1);			 
			
  if(isset($res[0]->ordId) && $res[0]->ordId !=''){
			redirect('payment/process/confirmation/'.$trackingId);
	} 	
	else {
		 
		 $basketItems=$this->model_cart->getUserBasketItems($basketId,$currencyId);	 
		 $itemCount = count($basketItems);
		 $userId=isset($basketItems[0]->uId) ? $basketItems[0]->uId : 0;
		 $cartTotal =$this->model_cart->getBasketTotal($basketId,'basketId','dispatchPrice');	
		 
		 $billingData = $this->getBillingInfo($basketId);
				
		if($billingData->billing_state!=''){
			 $billingStateName = getstateName($billingData->billing_state);
		   } else { $billingStateName=''; }
		   
		   if($billingData->shipping_state!=''){
		   $shippingStateName = getstateName($billingData->shipping_state);
		   }else { $shippingStateName=''; } 			
			
			$ordNumber = $this->createRanOrderNo();
			$toadAmount = $this->model_cart->getToadCommision($basketId);		
			$toadAmount  = ($toadAmount>0) ? $toadAmount : 0;	  
			$cartTotal  = $cartTotal + $toadAmount;	
			
			$billngName = $billingData->billing_firstName .' '.$billingData->billing_lastName;
			$shippingName = $billingData->shipping_firstName .' '.$billingData->shipping_lastName;		
			
			$insert['ordNumber'] =$ordNumber;			
			$insert['ordStatus'] =1;						
			$insert['itemCount'] = $itemCount ;
			$insert['customerUid'] = $userId;
			$insert['custName'] = $billngName;
			$insert['custStreetAddress'] = $billingData->billing_address1;
			$insert['custSuburb'] =$billingData->billing_address2;
			$insert['custCity'] = $billingData->billing_city;
			$insert['custZip'] = $billingData->billing_zip;
			$insert['custState'] =$billingStateName;
			$insert['custCountry'] =$billingData->countryName;
			$insert['custPhone'] = $billingData->billing_phone;
			$insert['custEmail'] = $billingData->billing_email;
			$insert['deliveryName'] = $shippingName;
			$insert['deliveryStreet'] = $billingData->shipping_address1;  
			$insert['deliverySuburb'] = $billingData->shipping_address2;
			$insert['deliveryCity'] = $billingData->shipping_city;
			$insert['deliveryZip'] = $billingData->shipping_zip;
			$insert['deliveryState'] = $shippingStateName;
			$insert['deliveryCountry'] =$billingData->shippingcountryname;
			$insert['payment_method'] = 'paypal';	
			$insert['grandTotal'] = $cartTotal;
			//$insert['totalPaid'] = '';
			$insert['ordCurrency'] = $currencyId;	
			$insert['transactionId'] = $transId;
			$insert['paypalTransectionInfo'] = $getData;
			$insert['trackingId'] = $trackingId;	
			$insert['otherInfoConsumptionTax'] =$billingData->otherAboutConsumptionTax;  					
			$this->db->insert('SalesOrder', $insert);
			return $orderId =  $this->db->insert_id();
        }    
	 
	 
	 }
	 
	 
	function insertSalesOrderItem($basketId,$currencyId,$orderId,$transId='',$isfree=0){
		$userId = isLoginUser();
		// $basketId= 55;$currencyId=0;$orderId=51;	 
		$items=$this->model_cart->getUserBasketItems($basketId,$currencyId); 
		$tempOrderDeleteId = 0;
		
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
				$sellerInfo=$this->model_cart->getSellerDetails($ownerId);
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
				} 	
					
					if(isset($itemSellerInfo->entityIdPE) && $entityId ==66){
						$UserShippingJson['ticketcategory']=$itemSellerInfo->ticketcategory;
						$UserShippingJson['price']=$itemSellerInfo->price;
						$UserShippingJson['earybirddate']=$itemSellerInfo->earybirddate;
						$UserShippingJson['earybirdprice']=$itemSellerInfo->earybirdprice;
						$UserShippingJson['eventSellstatus']=$itemSellerInfo->eventSellstatus;
						$UserShippingJson['earlyBirdStatus']=$itemSellerInfo->earlyBirdStatus;
						$UserShippingJson['entityIdPE']=$itemSellerInfo->entityIdPE;
						$UserShippingJson['eventORlaunchId']=$itemSellerInfo->eventORlaunchId;
						$UserShippingJson['SessionId']=$itemSellerInfo->SessionId;
						$UserShippingJson['TicketId']=$itemSellerInfo->TicketId;
						$UserShippingJson['isFree']=$itemSellerInfo->isFree;
						
						$ticketPrice=$item->itemValue;
						$ticketPrice=$item->itemValue;
						$totalPrice = ($ticketPrice + $item->taxValue + $item->tsCommissionValue + $item->tsVatValue);
						$ticketPrice= ($totalPrice/$itemQty);
						$ticketPrice= number_format($ticketPrice,2);
						
						$taxValue= ($item->taxValue/$itemQty);
						$taxValue= number_format($taxValue,2);
						$shipping= ($item->shipping/$itemQty);
						$shipping= number_format($shipping,2);
						$tsCommissionValue= ($item->tsCommissionValue/$itemQty);
						$tsCommissionValue= number_format($tsCommissionValue,2);
						$tsVatValue= ($item->tsVatValue/$itemQty);
						$tsVatValue= number_format($tsVatValue,2);
						$tsGrossCommision= ($item->tsGrossCommision/$itemQty);
						$tsGrossCommision= number_format($tsGrossCommision,2);
						$dispatchPrice= ($item->dispatchPrice/$itemQty);
						$dispatchPrice= number_format($dispatchPrice,2);
						$itemValue= ($item->itemValue/$itemQty);
						$itemValue= number_format($itemValue,2);
						
						$TicketTransectionLog=array();
						
						$ticketNumber=getTicketNumber();
						
						$ticketInfo=$this->getSessionDetails($itemSellerInfo->entityIdPE,$itemSellerInfo->eventORlaunchId,$itemSellerInfo->SessionId);
						
						for($k=1; $k<=$itemQty; $k++){
							$ticketNumber=($ticketNumber+1);
							$ticketNumber=getTicketNumberAsString($ticketNumber);
							$TicketTransectionLog[] = array(
								'entityId' =>$itemSellerInfo->entityIdPE,
								'projectId'=> $projId,
								'sessionId' => $itemSellerInfo->SessionId,
								'ticketId' => $itemSellerInfo->TicketId,
								'transectionId' => $transId,
								'invoiceId' => $item->invoiceId,
								'userId' => $userId,
								'category' => $itemSellerInfo->ticketcategory,
								'userName' => $billingdetails->billing_firstName.' '.$billingdetails->billing_lastName,
								'ticketNumber' => $ticketNumber,
								'currency' => $item->currency,
								'price' => $ticketPrice,
								'basePrice' => $item->basePrice,
								'taxValue'=> $taxValue,
								'shipping'=> $shipping,
								'tsCommissionPercent'=> $item->tsCommissionPercent,
								'tsCommissionValue'=> $tsCommissionValue,
								'tsVatPercent'=> $item->tsVatPercent,
								'tsVatValue'=> $tsVatValue,
								'tsGrossCommision'=> $tsGrossCommision,
								'dispatchPrice'=> $dispatchPrice,
								'itemValue'=> $itemValue,
								'ownerId' => $item->sellerId,
								'ticketInfo' => $ticketInfo
							);
						}
						
						if(is_array($TicketTransectionLog) && count($TicketTransectionLog) > 0){
							$this->model_common->insertBatch('TicketTransectionLog',$TicketTransectionLog);
						}
					}

					$json = json_encode($UserShippingJson);   
				
				
				$euIdNo =0;
				
				if($sellerInfo) {
					$sellerTerritory = (isset($sellerInfo->territory) && ($sellerInfo->territory!='')) ? $sellerInfo->territory : 0; 
				
					if($sellerTerritory==1){
						$sellerInfo = $this->getBillingInfo($basketId);	
					  if($sellerInfo->countryGroup=='EU'){					
						 $euIdNo = ($sellerInfo->EuVatIdentificationNumber!='') ? $sellerInfo->EuVatIdentificationNumber : 0 ;		
						}
					}
				}	
				 							
				
				$insertSalesOrderItem = array(
					'ordId' =>$orderId,
					'entityId'=> $entityId,
					'elementId' => $elementId,
					'sectionId' => $sectionId,
					'purchaseType' => $item->purchaseType,
					'itemQty' =>$itemQty,
					'itemName' =>$item->itemName,
					'itemValue' =>$item->itemValue,				
					'basePrice' => $item->basePrice,
					'taxName' =>$item->taxName,
					'taxPercent' =>$item->taxPercent,
					'taxValue' =>$item->taxValue,
					'shipping' =>$item->shipping,
					'tsCommissionPercent' =>$item->tsCommissionPercent,
					'tsCommissionValue' => $item->tsCommissionValue,
					'tsVatPercent'    => $item->tsVatPercent,
					'tsVatValue' =>$item->tsVatValue,
					'tsGrossCommision' => $item->tsGrossCommision,				
					'dispatchPrice'=>$item->dispatchPrice,
					'sellerId'     => $item->sellerId,
					'sellerInfo'   => $json,	
					'transactionId' => $transId,
					'invoiceId'	  =>  $item->invoiceId,
					'projId'      => $projId,
					'registrationId' =>$euIdNo,
					'isProductAuction' =>$item->isProductAuction,
					'projCategory' =>(!empty($item->projCategory))?$item->projCategory:0,
                );	

				$this->db->insert('SalesOrderItem', $insertSalesOrderItem);	
				$salesItemId =  $this->db->insert_id();	
				
				$this->insertReceiverTransId($salesItemId,$orderId,$item->invoiceId,$isfree=0);
				

				if(is_numeric($salesItemId) && $salesItemId > 0){
					$itemIds[]=$item->itemId;
					
                    /* delete wishlist for purchased items */
					$this->model_common->deleteRowFromTabel('Wishlist', array('entityId'=>$entityId,'elementId'=>$elementId,'purchaseType'=>$purchaseType,'tdsUid'=>$userId));
                    
                    //if purchase is auction then delete auction temp purchase data
                    if($item->isProductAuction=="t"){
                        //auction temp purcahse data
                        $auctionTempDataList  =  $this->model_cart->getauctiontempdata($userId,$entityId,$elementId);
                        
                        if(!empty($auctionTempDataList)){
                            foreach($auctionTempDataList as $auctionTempData){
                               $tempOrderDeleteId   =  $auctionTempData->ordId;
                               $itemId  =  $auctionTempData->itemId;
                                $this->model_common->deleteRowFromTabel('SalesOrderItem', array('itemId'=>$entityId,'purchaseType'=>'6'));
                            }
                        }
                        
                        //------update auction purchased status-------//
                        $auctionUpdateData  =   array('isAuctionPurchased'=>'t');
                        $whereCondition     =   array('entityId'=>$entityId,'elementId'=>$elementId,'projectId'=>$elementId);
                        $this->model_common->editDataFromTabel('Auction', $auctionUpdateData, $whereCondition);
                    }
                    
					$uId = ($item->uId!='') ? $item->uId :0;	   

					if($item->purchaseType==1){
						$this->insertSalesItemShipping($salesItemId,$uId,$orderId,$basketId,$transId); 
						 
					}
					else{
						 $expiryDays = $this->config->item('setExpiryDays');
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
							$existingElements=$this->getExistingElements($projId,$sectionId);
							if($existingElements){
								$insertDowndata['itemInfo'] =$existingElements;
							}
						 }
						 $this->insertSalesItemDownload($insertDowndata);  
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
						
							$this->manageProductQuantity($purchaseProductDetails);
						}
					}
				}
			}
            
            //auction temp delete data
            if(!empty($tempOrderDeleteId)){
                 $this->model_common->deleteRowFromTabel('SalesOrder', array('ordId'=>$tempOrderDeleteId,'customerUid'=>$userId));
            }

			if(isset($itemIds) && is_array($itemIds) && count($itemIds) > 0){
				/* delete SalesBasketItem for purchased items */
				//$this->model_common->deleteRowFromTabel('SalesBasketItem', 'itemId', $itemIds);
			}

		}	  
	}	 
 
 
 function insertSalesItemShipping($salesItemId,$uId,$orderId,$basketId,$transId){
	
	// $basketId= 32;
	 
	  $billingDetail = $this->model_cart->getBillingDetails($basketId);	   	
				
	  if(isset($billingDetail->shippingdetails) && $billingDetail->shippingdetails!=''){		
		$shippingdetails = json_decode($billingDetail->shippingdetails);
		$userShippingData =  $shippingdetails;
	   }else {
		$userShippingData =  $this->model_cart->getBillingShipDetails($uId);
		}
		
   if($userShippingData->shipping_state!=''){
	   $shippingStateName = getstateName($userShippingData->shipping_state);
	   }else { $shippingStateName=''; } 		
			
	$address = $userShippingData; 	
	
	$resultUserName = getDataFromTabel('UserProfile','firstName,lastName',  'tdsUid', $uId,'', 'ASC', $limit=1 );
	if($resultUserName)
	   $userInfo = $resultUserName[0];
	   
	 $fName=$userInfo->firstName;
	 $lName=$userInfo->lastName;	 	   
		   
		    $insertShp['itemId'] =$salesItemId;		            
            $insertShp['shpStatus'] = 0;
            $insertShp['fName'] = $fName;
            $insertShp['lName'] = $lName;
            $insertShp['address'] = $address->shipping_address1;         
            $insertShp['zip'] = $address->shipping_zip;
            $insertShp['city'] = $address->shipping_city;
            $insertShp['state'] = $shippingStateName;
            $insertShp['country'] = $address->shippingcountryname;
            $insertShp['ordId'] =  $orderId;
            $insertShp['transactionId'] = $transId;
            
		 $this->db->insert('SalesItemShipping', $insertShp);		    
     	  
	}
 
 
    
  function insertSalesItemDownload($data){
	  
	   if(isset($data) && is_array($data)) {		 
		   $this->db->insert('SalesItemDownload', $data);
		  } 
		 
	}
	
	
 function insertReceiverTransId($salesItemId,$ordId,$invoiceId,$isfree=0){
	 
		if($isfree==0)
		{
			$recvId = $this->createRandomNo();
		}else
		{
			$result = $this->model_common->getDataFromTabel('PaypalTransactionLog', 'senderTransactionId',  array('invoiceId' =>$invoiceId),'','','',1);	
		
			$recvId =  $result[0]->senderTransactionId;
		}
		
		$updateData=array('receiverTransactionId'=>$recvId);
		$where=array('itemId'=>$salesItemId);
		$this->model_common->editDataFromTabel('SalesOrderItem', $updateData, array('itemId'=>$salesItemId));
		
		$insert['ordId'] = $ordId;	
		$insert['receiverTransactionId'] =$recvId;
		$res = $this->model_common->getDataFromTabel('SalesOrderInvoice', 'id',  array('ordId' =>$ordId,'receiverTransactionId'=>$recvId),'','','',1);					
			
		if(($res) && isset($res[0]->id) && ($res[0]->id!='') ){
			 //$this->model_common->editDataFromTabel('MembershipCartItem', $data, 'memItemId', $res[0]->tsProductId); 					
		}else{			
				$this->db->insert('SalesOrderInvoice', $insert); 
			 }
		
	   return true;		 	
		 	 
	 }	
	
	
	
	/* Get Billing details based on current billing addres or existing (Global Settings) address */
	 
	 function getBillingInfo($basketId) {
		$billingDetail = $this->model_cart->getBillingDetails($basketId);
		$userId = isLoginUser();
	 
		if(isset($billingDetail->billingdetails) && $billingDetail->billingdetails!=''){
			$billingdetail = json_decode($billingDetail->billingdetails);
			$userBillingData =  $billingdetail;
		}else{				
			$userBillingData =  $this->model_cart->getUserBillingDetails($userId);
		}
					

		if(isset($billingDetail->shippingdetails) && $billingDetail->shippingdetails!=''){		
			$shippingdetails = json_decode($billingDetail->shippingdetails);
			$userShippingData =  $shippingdetails;
		}else {
			$userShippingData =  $this->model_cart->getBillingShipDetails($userId);
		}
				
		$billingData = (object) array_merge((array) $userBillingData, (array) $userShippingData);
		return $billingData; 
	 
	}	
	
	
	 /* Create Random no for New Order */
 public function createRanOrderNo()	{ 			
	//We generate a random string, based our our settings
	$generateNo = random_string('numeric', 10);
	
	$isAlreadyExists= $this->model_common->getDataFromTabel('SalesOrder', 'ordNumber',  array('ordNumber'=>$generateNo),'','','','');
	if($isAlreadyExists!=''){
		$generateNo = random_string('numeric', 10);
		}
					
	return $generateNo;
 }  
	
	
 function deleteBasket($trackingId='') {
	if($trackingId!='') { 
			  $res = $this->model_common->getDataFromTabel('SalesCustomersBasket', 'basketId',  array('trackingId' =>$trackingId),'','','',1);			 
			
		if(isset($res[0]->basketId) && $res[0]->basketId !=''){
			 $basketId =  $res[0]->basketId;
			  $this->model_common->deleteRowFromTabel('SalesBasketItem', 'basketId', $basketId);			 
			 $this->model_common->deleteRowFromTabel('SalesCustomersBasket', 'basketId', $basketId);
		 }	 
		
    } 
	 
}

	
	
	function test(){
	die();	
	
	$invC = $this->model_cart->Sal();
	
	
	
	foreach($invC as $in)
	{
		
		echo"<br>";
		$invoiceId = $in->invoiceId;
		$salesItemId =$in->itemId;
        $ordId =     $in->ordId; 
		
		$result = $this->model_common->getDataFromTabel('PaypalTransactionLog', 'senderTransactionId',  array('invoiceId' =>$invoiceId),'','','',1);	
		
	    $recvId =  $result[0]->senderTransactionId;
	    
	    
		$updateData=array('receiverTransactionId'=>$recvId);
		$where=array('itemId'=>$salesItemId);
		$this->model_common->editDataFromTabel('SalesOrderItem', $updateData, array('itemId'=>$salesItemId));
		
		$insert['ordId'] = $ordId;	
		$insert['receiverTransactionId'] =$recvId;
		$res = $this->model_common->getDataFromTabel('SalesOrderInvoice', 'id',  array('ordId' =>$ordId,'receiverTransactionId'=>$recvId),'','','',1);					
			
		if(($res) && isset($res[0]->id) && ($res[0]->id!='') ){
			 //$this->model_common->editDataFromTabel('MembershipCartItem', $data, 'memItemId', $res[0]->tsProductId); 					
		}else{			
				$this->db->insert('SalesOrderInvoice', $insert); 
			 }	
				
		
		}
		
		
		
		
				
		
	//	$info = $this->model_cart->getBuyerInfo('DGWJ9gUaHtT');
		
	//	echo "<pre/>";
	//	print_r($info);
		
		die;
		
		
		
		}
	
	
	
	/*
	 *************************************** 
	 *  This function is used to send invoice email to customer, seller and toadsquare by order Id
	 *************************************** 
	 */ 


	function invoiceSendToEmail($orderId=0)
	{
		//echo "<pre>";	
		$sentWhere=array('ordId'=>$orderId);
		$purchasedtemplate=getDataFromTabel('SalesOrder','isInvoiceSent',  $sentWhere, '','', '', 1 );
		// this codition for email send one time only when isInvoiceSent is "f"
		if(isset($purchasedtemplate[0]->isInvoiceSent) && $purchasedtemplate[0]->isInvoiceSent=="f")
		{
			//This query for get invoiceId by orderId
			$get_invoice_by_orderId=$this->model_cart->get_invoice_by_orderId($orderId);
			
			$get_sales_record['get_num_rows']='0';
			$get_sales_record['get_result']=''; 
			if($get_invoice_by_orderId['get_num_rows'] > 0)
			{
				$countAdd = 0;
				
				//for getting itemId by invoiceId
				foreach($get_invoice_by_orderId['get_result']  as $sales_record_by_invoice)
				{
					//This query get itemId by invoiceId
					$getSalesRecord =  $this->model_cart->get_sales_record($sales_record_by_invoice->invoiceId);
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
						$purchased_details_by_itemId =  $this->model_cart->purchased_details_by_itemId($sales_record['itemId']);
						if($purchased_details_by_itemId['get_num_rows'] > 0)
						{
							
							$get_sales_record['get_result'][$countRow] = $purchased_details_by_itemId['get_result']; 
							
							$getSellerDetail = json_decode($get_sales_record['get_result'][$countRow]->sellerInfo);
							
							// if not empty seller info
							if(!empty($getSellerDetail) && !empty($getSellerDetail->territoryCountryId) && !empty($getSellerDetail->seller_state)){
								$userCountryName = $this->model_cart->getUserCountryName($getSellerDetail->territoryCountryId);
								$getSellerDetail->territoryCountryId = $userCountryName->countryName;
								$getSellerDetail->seller_state = getstateName($getSellerDetail->seller_state);
							}
							$get_sales_record['get_result'][$countRow]->sellerInfo =   json_encode($getSellerDetail);
							
							$get_sales_record['get_result'][$countRow]->getItemsDetils = $this->model_cart->getItemsDetils($get_sales_record['get_result'][$countRow]->invoiceId);
							
							$get_sales_record['get_result'][$countRow]->isTakingShipping = $this->model_cart->isTakingShipping($get_sales_record['get_result'][$countRow]->invoiceId);
							
							$countRow++;
						}
					
					}
				
				}

				//invoice sending to customer:to,seller:cc and toadsquare:bcc
			
				if($get_sales_record['get_num_rows'] > 0)
				{
					
					foreach($get_sales_record['get_result'] as $get_invoice_data)
					{
						$this->load->library('email');
						//$this->email->from($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
						//$this->email->reply_to($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
						
						//get currency type
						$currencyType =  getCurrencyType($get_invoice_data->ordCurrency);
						
						$get_Items_Detils= $get_invoice_data->getItemsDetils;
						
						$getItemListing = "";
						if($get_Items_Detils['get_num_rows'] > 0)
						{
							$list = 0;
							foreach($get_Items_Detils['get_result'] as $itemsDetils)
							{
								$where=array('purpose'=>'purchasedtemplateitems','active'=>1);
								$getPurchasedItems=getDataFromTabel('EmailTemplates','templates',  $where, '','', '', 1 );
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
									$get_Session_Details = $this->model_cart->get_Session_Details($getSessionId);
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
						$purchasedtemplate=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
						$purchasedSubject=$purchasedtemplate[0]->subject;
						$purchasedtemplate=$purchasedtemplate[0]->templates;
						
						
						$logo_image_url = site_base_url()."images/toademaillogo_invoice.jpg";// image base url
						$parseTemplateArray	= 
						array("{logo_image_url}","{item_body}","{sale_order_date}","{sale_order_no}","{registraion_no}","{seller_body}","{seller_body_border}","{buyer_name}","{buyer_address}","{buyer_city}","{buyer_state}","{buyer_zip}","{buyer_country}","{buyer_phone}","{buyer_email}","{otherInfoConsumptionTax}","{shpping_body}");
						
						/*********template parsing code here*******/
						$sale_order_date = date("d F Y H:i",strtotime($get_invoice_data->ordDateComplete));//order date
						$sale_order_no = getInvoiceId($get_invoice_data->receiverTransactionId); //invoice id
						
						
						//registration no
						$registraion_no = ($get_invoice_data->registrationId==0)?"":$get_invoice_data->registrationId.' VAT Exemption<br>';
						$otherInfoConsumptionTax = ($get_invoice_data->otherInfoConsumptionTax=='')?"":$get_invoice_data->otherInfoConsumptionTax.' VAT Exemption';
						//seller info
						$sellerInfo = json_decode($get_invoice_data->sellerInfo);//get seller info data
						
						//seller body
						$seller_body="";
						$seller_body_border="height:130px;";
						if(!empty($sellerInfo) && isset($sellerInfo->firstName) && isset($sellerInfo->email)) {
						
						$seller_name = ucwords($sellerInfo->firstName.' '.$sellerInfo->lastName);
						$seller_address = $sellerInfo->seller_address1;
						$seller_city = $sellerInfo->seller_city;
						$seller_state = $sellerInfo->seller_state;
						$seller_zip = $sellerInfo->seller_zip;
						$seller_country = $sellerInfo->territoryCountryId;
						$seller_phone = $sellerInfo->seller_phone;
						$seller_email = $sellerInfo->email;
						
						//Get seller active and banned value
						$sellerWhereCondi = array('email'=>$seller_email);
						$sellerStatusData = getDataFromTabel('UserAuth','active,banned',  $sellerWhereCondi, '','', '', 1 );
						
						if(isset($getSellerDetail->sellerEuIdnumber) && $getSellerDetail->sellerEuIdnumber!='')
							{
								$sellerEuIdnumber = "#".$getSellerDetail->sellerEuIdnumber;	
							}else
							{
								$sellerEuIdnumber = "";
							}
							
							// prepare seller body	
							$seller_body .= '<font style="font-size:22px; color:#888888;margin:0">Seller</font> <br /> <br />';
							$seller_body .= '<font style="font-weight:bold;">'.$seller_name.'</font><br />';
							$seller_body .= $seller_address.'<br />';
							$seller_body .= $seller_city;
							$seller_body .= ($seller_city!='')?', ':'';
							$seller_body .= $seller_state.' '.$seller_zip.'<br />';
							$seller_body .= $seller_country.'<br /><div style="height:6px"></div>';
							$seller_body .= $seller_phone.'<br />';
							$seller_body .= $seller_email.'<br />';
							$seller_body .=	$sellerEuIdnumber;	
							
							//set seller body border
							$seller_body_border="border-left:3px solid #f15921;";
							
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
						
						//Get buyer active and banned value
						$buyerWhereCondi = array('email'=>$buyer_email);
						$buyersStatusData = getDataFromTabel('UserAuth','active,banned',  $buyerWhereCondi, '','', '', 1 );
						
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
						array($logo_image_url,$getItemListing,$sale_order_date,$sale_order_no,$registraion_no,$seller_body,$seller_body_border,$buyer_name,$buyer_address,$buyer_city,$buyer_state,$buyer_zip,$buyer_country,$buyer_phone,$buyer_email,$otherInfoConsumptionTax,$shpping_body);
						
						$getPurchasedTemplate =str_replace($parseTemplateArray, $replaceTemplateArray, $purchasedtemplate);
					
					
						//--------Invoice email send only which grand total amount is greater than from zero-------//	
						
						if(isset($get_invoice_data->grandTotal) && $get_invoice_data->grandTotal>0) {
							
							/*************get email body for purchase from database start*************/
				
							$purWhereCondi=array('purpose'=>'purchaseontoadsquare','active'=>1);
							$PurchaseDataBody = getDataFromTabel('EmailTemplates','templates,subject',  $purWhereCondi, '','', '', 1 );
							$PurchaseDataBody = $PurchaseDataBody[0];
							$site_url = base_url('');
							$site_base_url = site_base_url();
							$image_base_url = site_base_url().'images/email_images/';
							$crave_us = $this->config->item('crave_us');
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
							
							$purchase_page_url = base_url().'cart/purchase';
							$comment_url = base_url().'cart/purchase';
							$dashboard_url = base_url('dashboard');
							$facebook_url = $this->config->item('facebook_follow_url');
							$linkedin_url = $this->config->item('linkedin_follow_url');
							$twitter_url = $this->config->item('twitter_follow_url');
							$gPlus_url = $this->config->item('google_follow_url');
							$PurchaseBodyEmail=$PurchaseDataBody->templates;
							$purchaseGetArray = array("{crave_us}","{facebook_url}","{linkedin_url}","{item_body}","{purchase_page_url}" , "{dashboard_url}" ,"{site_url}" , "{site_base_url}", "{image_base_url}","{comment_url}","{twitter_url}","{gPlus_url}");
							$purchaseReplaceArray = array($crave_us,$facebook_url,$linkedin_url,$item_body, $purchase_page_url, $dashboard_url, $site_url,$site_base_url,$image_base_url,$comment_url,$twitter_url,$gPlus_url);
							$purchaseEmailBody=str_replace($purchaseGetArray, $purchaseReplaceArray, $PurchaseBodyEmail);
							$purchaseEmailSubject=$PurchaseDataBody->subject;
							
							
							
							//---------- This section for purchase tmail start------------//
							if($buyersStatusData[0]->active != 2 && $buyersStatusData[0]->banned != 1){
								
								$where=array('purpose'=>'tmailpurchaseontoadsquare','active'=>1);
								$purchaseTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
								$purchaseTmailTemplate=$purchaseTemplateRes[0]->templates;
								$searchArray = array("{item_body}","{purchase_page_url}","{site_url}","{comment_url}");
								$replaceArray = array($item_body,$purchase_page_url,$site_url,$purchase_page_url);
								$purchaseTmailBody=str_replace($searchArray, $replaceArray, $purchaseTmailTemplate);
								$purchaseTmailSubject=$purchaseTemplateRes[0]->subject;
								
								$senderId = 0; //message send from toadsquare
								$recipients = $get_invoice_data->customerUid;
								
								$this->tmail_messaging->send_new_message($senderId,$recipients, $purchaseTmailSubject,$purchaseTmailBody,'',9);
							}
							//---------- This section for purchase tmail end------------//
							
							
							/*************get email body from database end*************/
						
							/*************get email body for sales from database start*************/
				
							$salesWhereCondi=array('purpose'=>'salesontoadsquare','active'=>1);
							$SalesDataBody = getDataFromTabel('EmailTemplates','templates,subject',  $salesWhereCondi, '','', '', 1 );
							$SalesDataBody = $SalesDataBody[0];
							$site_url = base_url('');
							$site_base_url = site_base_url();
							$image_base_url = site_base_url().'images/email_images/';
							$crave_us = $this->config->item('crave_us');
							$salespage_url = base_url().'cart/sales';
							$dashboard_url = base_url('dashboard');
							$facebook_url = $this->config->item('facebook_follow_url');
							$linkedin_url = $this->config->item('linkedin_follow_url');
							$twitter_url = $this->config->item('twitter_follow_url');
							$gPlus_url = $this->config->item('google_follow_url');
							$SalesBodyEmail=$SalesDataBody->templates;
							$SalesGetArray = array("{crave_us}","{facebook_url}","{linkedin_url}","{item_body}","{salespage_url}" , "{dashboard_url}" ,"{site_url}" , "{site_base_url}", "{image_base_url}","{twitter_url}","{gPlus_url}");
							$SalesReplaceArray = array($crave_us,$facebook_url,$linkedin_url, $item_body, $salespage_url, $dashboard_url, $site_url,$site_base_url,$image_base_url,$twitter_url,$gPlus_url);
							$SalesEmailBody=str_replace($SalesGetArray, $SalesReplaceArray, $SalesBodyEmail);
							$SalesEmailSubject=$SalesDataBody->subject;
							
							
							
							//--------------This section is used for sales tmail start------------------//
							
							if($sellerStatusData[0]->active != 2 && $sellerStatusData[0]->banned != 1 && !empty($sellerInfo)){
								$where=array('purpose'=>'tmailsalesontoadsquare','active'=>1);
								$salesTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
								$salesTmailTemplate=$salesTemplateRes[0]->templates;
								$searchArray = array("{item_body}","{salespage_url}");
								$replaceArray = array($item_body,$salespage_url);
								$SalesTmailBody=str_replace($searchArray, $replaceArray, $salesTmailTemplate);
								$SalesTmailSubject=$salesTemplateRes[0]->subject;
								
								$senderId = 0; //message send from toadsquare
								$recipients = $get_invoice_data->sellerId;
								
								$this->tmail_messaging->send_new_message($senderId,$recipients,$SalesTmailSubject,$SalesTmailBody,'',9);
							}
							//--------------This section is used for sales tmail end------------------//
							
							
							/*************get email body from database end*************/
						
							/********attachment file create here start*******/
							$attachFileName=  'invoices/'.$sale_order_no.'.'.'html';
							$handle = fopen($attachFileName, 'w');//create file here
							fwrite($handle, $getPurchasedTemplate); 
							/********attachment file create here end*******/
						
							//------------------------------------------------//
							//------------Send Email to Buyer-----------------//
							//------------------------------------------------//
				
							if($buyersStatusData[0]->active != 2 && $buyersStatusData[0]->banned != 1){
								$this->email->from($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
								$this->email->reply_to($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
								$this->email->to($buyer_email);
								$this->email->cc($this->config->item('toadsquare_email'));
								$this->email->subject(sprintf($purchaseEmailSubject));
								$this->email->message($purchaseEmailBody);
								$this->email->attach($attachFileName);
								$this->email->send();
								$this->email->clear(TRUE);
							}
											
							//-----------------------------------------------------------------//
							//----------------------Send Email to Saler------------------------//
							//-----------------------------------------------------------------//
							
							
							if($sellerStatusData[0]->active != 2 && $sellerStatusData[0]->banned != 1 && !empty($sellerInfo)){
								$this->email->from($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
								$this->email->reply_to($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
								$this->email->to($seller_email);
								$this->email->cc($this->config->item('toadsquare_email'));
								$this->email->subject(sprintf($SalesEmailSubject));
								$this->email->message($SalesEmailBody);
								$this->email->attach($attachFileName);
								$this->email->send();
								$this->email->clear(TRUE);
								unlink($attachFileName); // attachment file delete here
							}	
							
							
						}	
							
						//------------------------------------------------------------------------//	
						//------------this section for event if purchase type is 5----------------//
						//------------------------------------------------------------------------//	
					
						if($get_invoice_data->purchaseType=="5" && $buyersStatusData[0]->active!=2 && $buyersStatusData[0]->banned!=1)
						{	
								
							$where=array('purpose'=>'event_ticket','active'=>1);
							$eventTicketTemplate=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
							$eventTicketSubject=$eventTicketTemplate[0]->subject;
							$eventTicketTemplate=$eventTicketTemplate[0]->templates;
							/* while we don't remove restriction (username, password) in .htacess file  from live site*/
							//$site_base_url = site_url('');
							$site_base_url = site_base_url();
							$event_url = "";
							$image_base_url = site_base_url().'images/email_images/';
							$crave_us = $this->config->item('crave_us');
							$facebook_url = $this->config->item('facebook_follow_url');
							$linkedin_url = $this->config->item('linkedin_follow_url');
							$twitter_url = $this->config->item('twitter_follow_url');
							$gPlus_url = $this->config->item('google_follow_url');
							$purchasePageUrl = base_url().'cart/purchase';
							$event_showcase_url = '';
							if(!empty($get_Items_Detils['get_result'][0]->invoiceId) && isset($get_Items_Detils['get_result'][0]->invoiceId)){
								$ticketInfoDetails = $this->model_common->ticket_invoice_data($get_Items_Detils['get_result'][0]->invoiceId);
								if(!empty($ticketInfoDetails)){
									$ticketInfoDetails = $ticketInfoDetails[0];
									$entityId = $ticketInfoDetails->entityId;
									$elementId = $ticketInfoDetails->projectId;
									$event_showcase_url = getFrontEndLink($entityId,$elementId);
								}	
							}
							
							$searchArray = array( "{event_name}","{event_url}","{event_showcase_url}", "{site_base_url}", "{image_base_url}","{crave_us}","{purchase_page_url}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
							$replaceArray = array($item_name,$event_url,$event_showcase_url,$site_base_url,$image_base_url,$crave_us,$purchasePageUrl,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
							$eventShowTemplate=str_replace($searchArray, $replaceArray, $eventTicketTemplate);
							$getInvoiceId =  $get_invoice_data->invoiceId;
							$this->event_ticket_pdf($getInvoiceId);
							$attachEventFileName = 'invoices/event_ticket.pdf';
							
							//--------------Event ticket tmail code start-----------------//	
							
							$where=array('purpose'=>'tmaileventicket','active'=>1);
							$ticketTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
							$ticketTemplate=$ticketTemplateRes[0]->templates;
							$searchArray = array("{event_title}","{event_link}","{purchase_page_url}");
							$replaceArray = array($item_name,$event_url,$purchasePageUrl);
							$tickeTmailBody=str_replace($searchArray, $replaceArray, $ticketTemplate);
							$tickeTmailSubject=$ticketTemplateRes[0]->subject;
							
							$senderId = 0; //message send from toadsquare
							$recipientsBuyer = $get_invoice_data->customerUid;
							//$recipientsSaler = $get_invoice_data->sellerId;
							//This function call for send ticket tmail to Buyer
							$this->tmail_messaging->send_new_message($senderId,$recipientsBuyer,$tickeTmailSubject,$tickeTmailBody,'',9);
							//This function call for send ticket tmail to Seller
							//$this->tmail_messaging->send_new_message($senderId,$recipientsSaler,$tickeTmailSubject,$tickeTmailBody,'',9);
							
							//--------------Event ticket tmail code end-----------------//	
							
							$this->email->from($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
							$this->email->reply_to($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
							$this->email->to($buyer_email);
							//$this->email->cc($seller_email); 
							$this->email->bcc($this->config->item('toadsquare_email')); // need to change with toadsquare email
							$this->email->subject(sprintf($eventTicketSubject));
							$this->email->message($eventShowTemplate);
							$this->email->attach($attachEventFileName);
							$this->email->send();
							unlink($attachEventFileName);  //
						}
						
					}
					
				}
		
			}
			
			//udpate invoice email status
			$this->model_cart->isInvoiceSent($orderId);
		}
	
	}
	
	
	/*
	 ******************************************** 
	 * This section for creating event tickets
	 ******************************************** 
	 */ 
	
	function event_ticket_pdf($eventInvoiceId=0)
	{	
		if($eventInvoiceId != '0'){
			
			$eventInvoiceData = $this->model_common->ticket_invoice_data($eventInvoiceId);
			if(isset($eventInvoiceData) && !empty($eventInvoiceData)){
				$data['eventInvoiceData'] =  $eventInvoiceData;
				$data['isDownload'] =  'no';
				$this->load->view('ticketPdf',$data) ;	
			}else{
				redirectToNorecord404();
			}
		}else{
			redirectToNorecord404();
		}
	}
	
	function getSessionDetails($entityId=0,$elementId=0,$SessionId){
		$ticketInfo='';
		if( $entityId >0 && $elementId > 0){
			$entity_tableName = getMasterTableName($entityId);
			$tableName= $entity_tableName[0];
			$isTableFound=true;
			switch ($tableName){	
				case 'TDS_Events':
					$tableName='Events';
					$selectedField=$tableName.'.Title, '.$tableName.'.OneLineDescription, '.$tableName.'.StartDate, '.$tableName.'.FinishDate, '.$tableName.'.Time';
					$whereField = 'EventId';														
					$whereSesField = 'eventId';														
				break;
							
				case 'TDS_LaunchEvent':
					$tableName='LaunchEvent';	
					$selectedField=$tableName.'.Title, '.$tableName.'.OneLineDescription,'.$tableName.'.LaunchDate,'.$tableName.'.Time';
					$whereField = 'LaunchEventId';
					$whereSesField = 'launchEventId';		
				break;
				
				default:
					$isTableFound=false;
				break;			
			}
			
			if($isTableFound){
				$res=$this->model_cart->getSessionDetails($tableName,$elementId,$selectedField,$whereField,$whereSesField,$SessionId);
				
				if($res){
					$res=$res[0];
					$ticketInfo=json_encode($res);
					$ticketInfo=str_replace("'","&apos;",$ticketInfo);	//encode data in json format
				}
			}
		}
		return $ticketInfo;
	}

	function getExistingElements($projId=0,$sectionId=''){
		$return=false;
		if(is_numeric($projId) && $projId>0 && $sectionId != ''){
			$isTableFound=true;
			switch ($sectionId){	
				case '1':
					$table='FvElement';	
				break;
				
				case '2':
					$table='MaElement';	
				break;
				
				case '3':
					$table='WpElement';	
				break;
				
				case '4':
					$table='PaElement';	
				break;
				
				case '10':
					$table='EmElement';	
				break;
				
				default:
					$isTableFound=false;
				break;			
			}
			
			if($isTableFound){
				$selectfields = 'elementId, isDownloadPrice, isPerViewPrice';
				$where = array('projId'=>$projId);
				$res=$this->model_common->getDataFromTabel($table,$selectfields,$where);
				if($res){
					$return = json_encode($res);
				}
			}
		}
		return $return;
	}
	
	/*
	 *********************************** 
	 * Get Random Number
	 **********************************  
	 */ 
	
	function createRandomNo($length=10) {
    $len = $length;
    $base = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
    $max = strlen($base) - 1;
    $activatecode = '';
    mt_srand((double) microtime() * 1000000);

    while (strlen($activatecode) < $len + 1) {
        $activatecode.=$base{mt_rand(0, $max)};
        
    }
      return $activatecode;
    
}

	function testWork(){

	$this->insertSalesOrderItem('741','0','429','','1');	
	}		

} 
