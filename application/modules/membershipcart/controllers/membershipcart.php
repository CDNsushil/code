<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* @Description: This controller is use to manage purchase, renew and refund 
* container and purchase, refund, donwgrade, renew package membership
* 
*/ 

class Membershipcart extends MX_Controller {
  
  //defined arrary for passing data
  private $data   =   array();
  private $userId = null;
  
  /** Constructor **/
  function __construct() {
    $load = array(
      'model'       =>  'membershipcart/model_membershipcart + tmail/model_tmail + messagecenter/model_message_center',
      'library'     =>  'tmail/Tmail_messaging + messagecenter/lib_message_center',
      'language'    =>  'membershipcart'
    );
    parent::__construct($load);
    //$this->head->add_css($this->config->item('system_css').'frontend.css');		
    //$this->head->add_css($this->config->item('default_css').'template.css');	
    $this->userId = isLoginUser();
  }

  /*
  * Function buyspaceinfo called from buy tools only 
  * In case of new container purchase
  * isChecked checks selected items as per clicked checkboxes
  * productQty checks selected qty for product & matches with selected checkboxes
  * */
 
 public function buyspaceinfo(){				
    
  $isChecked = $this->input->post('item');
  $productQty = $this->input->post('select');
  
  //$this->checkPreviousItems($isChecked);
  
  $productDetailsList = array();
  $data = array();
  
  $loginuserId=$this->isloginUser();
  
  $inserts = array('totalPrice'=>'0','totalTaxAmt'=>'0','tdsUid'=>$loginuserId);
  
  
  $cartId=$this->session->userdata('currentCartId');
  if($cartId==''){
  $cartId = $this->model_membershipcart->addData($inserts);
    }
  $this->session->set_userdata('currentCartId',$cartId);
    if(isset($isChecked) && is_array($isChecked) && count($isChecked)>0 ) {
        $i=0;
      foreach ($isChecked as $items =>$item) {
                            
        $productDetailsList[$i] = $this->model_membershipcart->getProductDetails($item);
        $productDetailsList[$i]['extraSpace'] =getAssociatedSpace($item);	
        
        foreach ($productQty as $qnty =>$qty) {
              
          if($items==$qnty){							
              
             $productDetailsList[$i]['qty'] = $qty;							 
             $productCount = getSelectedTools($cartId,$item);					
          
              for($l=1;$l<=$qty;$l++){ 
                    
                     $res = $this->model_membershipcart->getRoleId($productDetailsList[$i][0]->tsProductId);
                     $pkgId  = $res[0]['pkgId'];
                     $pkgRoleId =  $res[0]['pkgRoleId'];
                                 
                    $insert['cartId'] = $cartId;
                    $insert['tsProductId'] =  $productDetailsList[$i][0]->tsProductId;
                    $insert['price'] =  $productDetailsList[$i][0]->price;
                    $insert['size'] =  is_numeric($productDetailsList[$i][0]->size)?$productDetailsList[$i][0]->size:0;
                    $insert['pkgId'] =  $pkgId;
                    $insert['pkgRoleId'] =  $pkgRoleId;
                    $insert['totalPrice'] =  $productDetailsList[$i][0]->price;								
                    $this->model_membershipcart->addDataMem($insert);							 
                   }				 
                 
                 }
            } $i++; 
           }
      //die;
    $data['productDetails']=$productDetailsList;	
        
    } else { // IF DIRECT HIT BY USER OR BLANK DATA		  
         redirect(base_url(lang().'/package/buytools'));
         }
    
   redirect(base_url(lang().'/membershipcart/buyspace'));
      
 }
 
  /*
   * Function buyspace
   * Called in case of NEW Container/Add Space/Renew
   * isChecked gets saved data from db 
   *  
   * */
   
  public function buyspace(){	  	
  
  $isChecked = $this->model_membershipcart->getUserBuyData();		
  $defult='';	
  $productDetailsList = array();
  $data = array();
    
  if(isset($isChecked) && is_array($isChecked) && count($isChecked)>0 ) {
    $i=0;
      foreach ($isChecked as $items) {				
          $item = $items->tsProductId;
        
        if(isset($items->elementId) && ($items->elementId>0)) {								
          $container = $this->model_membershipcart->getSizeCalculation($items->elementId);	 
          $usedSpace = $this->getFolderUsedSize($container->projectType,$container->projId);										
         }
        
        //echo $items->type;die;
        
        if($items->type==2){
          $product=$this->model_common->getDataFromTabel('UserContainer', 'tsProductId',  array('userContainerId'=>$items->elementId),'','','',1);										
          $productDetailsList[$i] = $this->model_membershipcart->getProductDetails($product[0]->tsProductId);					
          } else{				
          $productDetailsList[$i] = $this->model_membershipcart->getProductDetails($item);
          }
          
         if($items->type==3){ 
           $productDetailsList[$i]['usedSpace'] = $usedSpace;
          }else {
            $productDetailsList[$i]['usedSpace'] = 0;						
            } 
              
        //$productDetailsList[$i]['extraSpace'] =getAssociatedSpace($item);	
        $extraSpace = $this->model_membershipcart->getExtraSpace($items->cartItemId);				
        $productDetailsList[$i]['purchaseType'] =$items->type;
        
        if($items->type!=1){
          $res=$this->model_common->getDataFromTabel('UserContainer', 'containerSize',  array('userContainerId'=>$items->elementId),'','','',1);					
          $productDetailsList[$i]['containerSize'] = $res[0]->containerSize;					
          }else {
            $productDetailsList[$i]['containerSize']=0;						
            }
        
                        
        if(isset($extraSpace->price) && ($extraSpace->price!='')){
          $productDetailsList[$i]['extraSpace'] =$extraSpace;				   
          }else{
          $productDetailsList[$i]['extraSpace'] ='';
          }
        
        /* For per mb price for Additional Space */	
        $additionalSpacePrice = $this->model_membershipcart->getSpaceInfo();
        $additionalSpacePrice = ($additionalSpacePrice > 0 ) ? $additionalSpacePrice :1;	
        $productDetailsList[$i]['additionalSpacePrice'] = $additionalSpacePrice ;	
        /* End */
                
        $productDetailsList[$i]['cartItemId'] = $items->cartItemId;	
        $i++;
      }
      
         $data['productDetails']=$productDetailsList;	

  } else { // IF DIRECT HIT BY USER OR BLANK DATA		  
            redirect(base_url(lang().'/package/buytools'));
         }
   $this->template->load('frontend','buy_space',$data);		 
 }
 
  /* 
   * Function checkPreviousItems
   * checks is previously checked data still checked or uncheckd by user on update
   * called when user clicks on update and then go back to buy space page
   * 
   * */
   
  function checkPreviousItems($isChecked) {
    
   $cartId=$this->session->userdata('currentCartId');
   $cartCurrentItem = $this->model_membershipcart->getAllCartItems($cartId);
    
   foreach ($cartCurrentItem as $items =>$item) {	
  /* IN CASE OF NEW CHECK BASED ON CHECK BOX */	 	 
     if($item->type==1) {	
     if (!in_array($item->tsProductId, $isChecked)) {			  
             $productId = $item->tsProductId;
             $cartItemId = $item->cartItemId;                         
             $this->model_membershipcart->deleteCart($cartId,$productId,$cartItemId);                       
          }
      }
    }
   }
  
  
  function deleteCartItem($delItem){	  
     $this->model_membershipcart->deleteCartItem($delItem);
     echo 1;
    }
    
  
  function confirmBilling(){	 
    $userId=$this->isloginUser();	  
    $this->updateCart(true);  	  
    $billingDetail = $this->model_membershipcart->getBillingDetails();

    if(isset($billingDetail->billingdetails) && $billingDetail->billingdetails!=''){
      $billingDetail = json_decode($billingDetail->billingdetails);
      $userProfileData =  $billingDetail;
    }else {	  
      $userProfileData =  $this->model_membershipcart->getUserBillingDetails($userId);
    }
    
  $billing=$this->model_common->getDataFromTabel('UserBuyerSettings', 'billing_firstName',  array('tdsUid'=>$userId),'','','',1);	    
  $isUserBilling = isset($billing[0]->billing_firstName)?$billing[0]->billing_firstName:'';	
  $data['globelBilling'] = $isUserBilling;
  

    $data['userProfileData'] = $userProfileData;
    $data['countryList'] = getCountryList();
    $this->template->load('frontend','confirm_billing',$data); 
  }


/* Save Billing detail from cart */	  
function saveBillingData(){
  $userId = isLoginUser();
  $saveglobalSettings = $this->input->post('saveglobalSettings');
  $countryId = $this->input->post('billing_country');	
  $countryName = $this->model_membershipcart->getUserCountryName($countryId);	
  
 if(isset($saveglobalSettings) && $saveglobalSettings==true){		
  $UserBuyerSettings = array(
        'tdsUid' => $this->userId,
        'billing_firstName'=> $this->input->post('billing_firstName'),
        'billing_lastName' => $this->input->post('billing_lastName'),
        'billing_address1' => $this->input->post('billing_address1'),
        'billing_address2' => $this->input->post('billing_address2'),
        'billing_city' => $this->input->post('billing_city'),
        'billing_state' => $this->input->post('billing_state'),
        'billing_country' => $this->input->post('billing_country'),
        'billing_zip' => $this->input->post('billing_zip'),
        'billing_phone' => $this->input->post('billing_phone'),
        'billing_email' => $this->input->post('billing_email'),
        'EuVatIdentificationNumber' => $this->input->post('EuVatIdentificationNumber')			
      );
      
      $cartId=$this->session->userdata('currentCartId'); 
      $json = array('billingdetails'=>'');
      $this->model_common->editDataFromTabel('MembershipCart', $json, 'cartId', $cartId);
      
      $res=$this->model_common->getDataFromTabel('UserBuyerSettings', 'id',  array('tdsUid'=>$userId),'','','',1);
      if(isset($res[0]->id) && $res[0]->id > 0){
        $this->model_common->editDataFromTabel('UserBuyerSettings', $UserBuyerSettings, 'id', $res[0]->id);
      }else{
        $this->model_common->addDataIntoTabel('UserBuyerSettings', $UserBuyerSettings);
      }
                    
         $msg = "Update Billing Address";
       set_global_messages($msg, $type='success', $is_multiple=true);  	    
      
  } else {
    $userId=$this->isloginUser();
   $UserBuyerSettings = array(
        'tdsUid' => $userId,
        'billing_firstName'=> $this->input->post('billing_firstName'),
        'billing_lastName' => $this->input->post('billing_lastName'),
        'billing_address1' => $this->input->post('billing_address1'),
        'billing_address2' => $this->input->post('billing_address2'),
        'billing_city' => $this->input->post('billing_city'),
        'billing_state' => $this->input->post('billing_state'),
        'billing_country' => $this->input->post('billing_country'),
        'billing_zip' => $this->input->post('billing_zip'),
        'billing_phone' => $this->input->post('billing_phone'),
        'billing_email' => $this->input->post('billing_email'),
          'EuVatIdentificationNumber' => $this->input->post('EuVatIdentificationNumber'),
          'countryName'               => $countryName->countryName,
        'countryGroup'              => $countryName->countryGroup
        
      );
      
      $cartId=$this->session->userdata('currentCartId'); 
      $json = array('billingdetails'=>json_encode($UserBuyerSettings ));
      $this->model_common->editDataFromTabel('MembershipCart', $json, 'cartId', $cartId);
      
     }
     
    /*  $EuVatIdentificationNumber = $this->input->post('EuVatIdentificationNumber') ;
      if($EuVatIdentificationNumber!=''){
       $countryEu = $this->input->post('billing_country');
       $inserEuCountry = array('CountryEU_VAT'=>$countryEu);
       $this->model_common->editDataFromTabel('UserBuyerSettings', $inserEuCountry, 'tdsUid', $userId);
      } */ 
     
     
         redirect(base_url(lang().'/membershipcart/cartSummary'));	
  }	  
     
 
  function cartSummary(){
      
    $userId=$this->isloginUser();
    $billingDetail = $this->model_membershipcart->getBillingDetails();

    if(isset($billingDetail->billingdetails) && $billingDetail->billingdetails!=''){
      $billingDetail = json_decode($billingDetail->billingdetails);
      $billingDetail =  $billingDetail;
    }
    else {	  
       $billingDetail =  $this->model_membershipcart->getUserBillingDetails($userId);
    }

    $isChecked = $this->model_membershipcart->getUserBuyData();		
    $defult='';	
    $productList = array();
    $data = array();    

    if(isset($isChecked) && is_array($isChecked) && count($isChecked)>0 ) {
      $i=0;
      foreach ($isChecked as $items) {								
        $item = $items->tsProductId;
        
        if($items->type==2){
          $product=$this->model_common->getDataFromTabel('UserContainer', 'tsProductId',  array('userContainerId'=>$items->elementId),'','','',1);										
          $productList[$i] = $this->model_membershipcart->getProductDetails($product[0]->tsProductId);					
          } else{				
          $productList[$i] = $this->model_membershipcart->getProductDetails($item);
          }
                
        $productList[$i]['extraSpace'] =$this->model_membershipcart->getExtraSpace($items->cartItemId);										
        $productList[$i]['cartItemId'] = $items->cartItemId;
        $productList[$i]['purchaseType'] =$items->type;
        $i++;
      }			
      $data['productDetails']=$productList;
      $vat = getConsumptionTax($userId);	  
      $vat = (isset($vat) && $vat!='') ? $vat : 0;
      
      
  $billing=$this->model_common->getDataFromTabel('UserBuyerSettings', 'billing_firstName',  array('tdsUid'=>$userId),'','','',1);	    
  $isUserBilling = isset($billing[0]->billing_firstName)?$billing[0]->billing_firstName:'';	
  $data['globelBilling'] = $isUserBilling;

      $data['billingDetail'] = $billingDetail;
      $data['vatCharge'] = 	$vat;    
      $this->template->load('frontend','cart_summary',$data);	
    }  
    else{
      redirect(base_url(lang().'/package/buytools'));	
    } 
  }
  
  
  /*Paypal transaction detail*/
  
  function confirmation($invoiceId=''){
  // $invoiceId='5PY92560CB396890B';
   if($invoiceId!='') {
    
    $res=$this->model_common->getDataFromTabel('MembershipOrder','orderId',  array('ordNumber'=>$invoiceId),'','','',1);
    
    if($res)
     $orderId = $res[0]->orderId;
        
    $userId=$this->isloginUser();
    
    $billingDetail=$this->model_common->getDataFromTabel('MembershipOrder','buyerInfo',  array('ordNumber'=>$invoiceId),'','','',1);
    
    if($billingDetail)
      $buyerInfo = $billingDetail[0]->buyerInfo;		
    

    if(isset($buyerInfo) && $buyerInfo!=''){
      $billingDetail = json_decode($buyerInfo);
      $billingDetail =  $billingDetail;
    }
    else {	  
       $billingDetail = '';
    }
    
    
    $isChecked = $this->model_membershipcart->getOrderdDetails($orderId);		
    $defult='';	
    $productList = array();
    $data = array();    

    if(isset($isChecked) && is_array($isChecked) && count($isChecked)>0 ) {
      $i=0;
      foreach ($isChecked as $items) {
        
        $item = $items->tsProductId;
        if($items->type==2){
          $product=$this->model_common->getDataFromTabel('UserContainer', 'tsProductId',  array('userContainerId'=>$items->userContainerId),'','','',1);										
          $productList[$i] = $this->model_membershipcart->getProductDetails($product[0]->tsProductId);					
          
          } else{				
          $productList[$i] = $this->model_membershipcart->getOrderProductDetails($item,$items->orderId);	
          }
        
        
        if($items->type==2){					
          $productList[$i]['extraSpace'] =$this->model_membershipcart->getAddSpace($items->memItemId);					
          } else{				
          $productList[$i]['extraSpace'] =$this->model_membershipcart->getOrderSpace($items->memItemId);
          }
          
                          
        $productList[$i]['cartItemId'] = $items->memItemId;
        $productList[$i]['purchaseType'] =$items->type;
        $i++; 
      }	
          
      $data['productDetails']=$productList;
      
      $vat=$this->model_common->getDataFromTabel('MembershipOrder','taxPercent,isFree',  array('ordNumber'=>$invoiceId),'','','',1);
      
      if($vat)
      $vatCharge = $vat[0]->taxPercent;			
      
          
      $vatCharge = (isset($vatCharge) && $vatCharge!='') ? $vatCharge : 0;	
        $data['billingDetail'] = $billingDetail; 
      $data['vatCharge'] = 	$vatCharge;
      $data['isFree'] = $vat[0]->isFree;    
      
      $this->template->load('frontend','transactionView',$data);	
    } 
  
    }	 
    else{
      redirect(base_url(lang().'/payment/process/transactionerror'));	
      } 
  }
  
    
  
  /*
   * 
   *************************************
   *  This function is used to show Thank You Message after completed transaction from paypal
   **************************************
   *
   */   
  
  
  function thankyouMessage(){	
    
    $userId=$this->isloginUser();	
    $data['userId'] = $userId;  
    $this->template->load('frontend','thankyou_message',$data); 
  }
  
  
  /**
   * Update Cart on continue shopping
   * Called from checkout or continue shopping 
   * isBilling true when user clicks on checkout
  **/ 
  
  function updateCart($isBilling=''){
   
   $post=$this->input->post('extraspace');
   $cartId=$this->session->userdata('currentCartId');
   
   if(isset($post) && is_array($post)) {

  foreach($post as $key=>$space ){		
    
    if(isset($space)) {
     
     /* Get Per MB price from Space */ 
     $additionalSpacePrice = $this->model_membershipcart->getSpaceInfo();
     $additionalSpacePrice = ($additionalSpacePrice > 0 ) ? $additionalSpacePrice :1;	 
     
     $totalPrice = ($space * $additionalSpacePrice);
  /* Change FOR ADD SPACE */
      $type=$this->model_common->getDataFromTabel('MembershipCartItem','type,elementId',  array('cartItemId'=>$key),'','','',1);		
        
        // set tool type
        if($type[0]->type=='3'){
          $toolType = '2'; // type 2 for add space
        }else{
          //$toolType = $type[0]->type; "code comment by lokendra its was running wrong for tool + add space case"
          $toolType = '2';
        }
        $cartId=$this->session->userdata('currentCartId');
        $insert['cartId'] = $cartId;
        $insert['tsProductId'] ='20';
        $insert['price'] =  $totalPrice;
        /* convert size mb into bytes */
		//$spaceBytes =  mbToBytes($space,'mb');
        $insert['size'] =  is_numeric($space)?$space:0;
        $insert['parentCartItemId'] = $key;
        $insert['type'] = $toolType;
        $insert['elementId'] = $type[0]->elementId;
        
        $res=$this->model_membershipcart->getCartItemDetails(20,$key,$cartId);				

               /* In Case Add Space Set Size N Price O for Container Associated to Add Space */ 
        if($type[0]->type==2){					
          $update['size']=0 ;
            $update['price']=0 ;
          $this->model_common->editDataFromTabel('MembershipCartItem', $update, 'cartItemId', $key);					
          } 
        
        /*END */								
            
        if(isset( $res->cartItemId) && $res->cartItemId > 0){						
          $this->model_common->editDataFromTabel('MembershipCartItem', $insert, 'cartItemId', $res->cartItemId);
        }else{
          $this->model_membershipcart->addDataMem($insert);
        }			
      }	
    }
   }   
   
   $data = array('totalPrice' => $this->input->post('carttotalPrice'));	
   $this->model_common->editDataFromTabel('MembershipCart',$data,'cartId', $cartId); 
  
   if($isBilling==true) {
           return true;			   
         } else {
             redirect(base_url(lang().'/package/buytools'));				   
           } 
    
    }
 
 
 /* * 
  * Save Order in DB
  * Function Called on paypal notify url service 
  * get data from paypal
  * custom n invoice paypal fields used to send userId and CartId
 * */ 
 
 function saveOrder($getData=""){
   $userId=$this->isloginUser();	
  // $paypalStatus =   $this->input->post('payment_status') ;
  // $userId =  $this->input->post('custom');
   $cartId =  $getData['CUSTOM'];
   $result = getDataFromTabel('MembershipCart','tdsUid,billingdetails',  'cartId', $cartId,'', 'ASC', $limit=1 );
  
  if(isset($result[0]->tdsUid) && $result[0]->tdsUid >=1){
    
  }else{
    redirect('home');
  }
  
    $userId = ($result[0]->tdsUid!='') ? $result[0]->tdsUid:$userId;
   
   // $billingdetails = ($result[0]->billingdetails!='') ? $result[0]->billingdetails:'';
  
    /*************get userinfo *************/
    
    $billingDetail = $this->model_membershipcart->getBillingDetails($userId);

    if(isset($billingDetail->billingdetails) && $billingDetail->billingdetails!=''){
      $billingdetails = json_decode($billingDetail->billingdetails);
    }else {	  
      $billingdetails =  $this->model_membershipcart->getUserBillingDetails($userId);
    }
    $billingdetails = json_encode($billingdetails);
  
     /*************get userinfo *************/
     
    
  $paypalStatus = '1';
  // $items = $this->model_membershipcart->getAllCartItems($cartId);
    

   $vatApplied = getConsumptionTax($userId);
   $cartTotal = getTotalPrice ($cartId,'cartId','price');
   $cartTotal = $cartTotal->total;
   
   $vatValTot = (($cartTotal*$vatApplied)/100) ;
       
   $TotalPaid =  number_format(($cartTotal+$vatValTot),2);
   $resultUserName = getDataFromTabel('UserProfile','firstName,lastName',  'tdsUid', $userId,'', 'ASC', $limit=1 );
   $userEmail = getDataFromTabel('UserAuth','email',  'tdsUid', $userId,'', 'ASC', $limit=1 );
  if($resultUserName)
     $userInfo = $resultUserName[0];
     
     $userEmail = ($userEmail[0]->email!='') ? $userEmail[0]->email:'';
     
   $custName=$userInfo->firstName.' '.$userInfo->lastName;	
   
    $insert['cartId'] = $cartId;
    $insert['grandTotal'] =  $cartTotal;
    $insert['totalTaxAmt'] =  $vatApplied;
    $insert['TotalPrice'] =  $cartTotal;
    $insert['paymentStatus'] =  $paypalStatus ;
    $insert['tdsUid'] =  $userId;
    $insert['totalPaid'] =  $TotalPaid;
    $insert['custName'] = $custName;
    $insert['custPhone'] =  '';
    $insert['custEmail'] =$userEmail;	
    $insert['buyerInfo'] =$billingdetails;
    $insert['taxPercent'] =$vatApplied;
    $insert['taxValue'] =number_format($vatValTot,2);
    $insert['orderType'] =1;
    
   
  // $orderId = $this->model_membershipcart->addOrderData($insert);
   
  // $this->db->insert('MembershipOrder', $updatedata);
   $this->db->insert('MembershipOrder', $insert);
   $orderId =  $this->db->insert_id();
   
   $userContainerId = $this->UserMembershipItem($orderId,$cartId,$userId,$paypalStatus);	
    
   // ADD DATA IN CONTAINER	 
   $this->insertDataInConatainer($orderId,$userContainerId);
   
   // Update  DATA IN CONTAINER 
    $this->updateConatainer($orderId);
    
    return	$orderId;

 }
  
  //----------------------------------------------------------------------
  
  /*
   * @access: publilc
   * @description: This function is used to save package order data
   * @param:string 
   */ 
 
  function packageordersave($getData=""){
    
    //call membership order save method
    $membershipOrderArray = $this->_packagemembershiporder($getData);
  
    // set membership item require variable
    $orderId        =  $membershipOrderArray['orderId'];
    $cartId         =  $membershipOrderArray['cartId'];
    $userId         =  $membershipOrderArray['userId'];
    $paypalStatus   =  $membershipOrderArray['paypalStatus'];
  
    //add package membership item  
    $this->packagemembershipitem($orderId,$cartId,$userId,$paypalStatus);	
    
    return $orderId;
  }
  
  //----------------------------------------------------------------------
  
  /*
   * @access: publilc
   * @description: This function is used to save renw package order data
   * @param:string 
   */ 
 
  function renewordersave($getData=""){
    
    //call membership order save method
    $membershipOrderArray = $this->_packagemembershiporder($getData);
  
    // set membership item require variable
    $orderId        =  $membershipOrderArray['orderId'];
    $cartId         =  $membershipOrderArray['cartId'];
    $userId         =  $membershipOrderArray['userId'];
    $paypalStatus   =  $membershipOrderArray['paypalStatus'];
  
    //add renew membership item  
    $this->renewmembershipitem($orderId,$cartId,$userId,$paypalStatus);	
    
    return  $orderId;
  }
  
  //-------------------------------------------------------------------------
  
  /*
  * @description: This function is used to save renew membership item
  * @return array
  */ 
  
  function renewmembershipitem($orderId,$cartId,$userId,$paypalStatus){
    
    //get membership cart item 
    $membershipTempItemData = $this->model_common->getDataFromTabel('MembershipCartItem','*',  'cartId', $cartId,'', 'ASC');
  
    if(!empty($membershipTempItemData)){
     
      foreach($membershipTempItemData as $membershipItem){

        // vat percent for membership 
        $vatApplied  = $this->config->item('package_vat_percent');
        
        $membershipItemType =  $membershipItem->type;

        $cartItemData['orderId']                    =  $orderId;		
        $cartItemData['tdsUid']                     =  $userId;
        $cartItemData['pkgId']                      =  $membershipItem->pkgId;
        $cartItemData['pkgRoleId']                  =  $membershipItem->pkgRoleId;
        $cartItemData['tsProductId']                =  $membershipItem->tsProductId;		
        $cartItemData['size']                       =  $membershipItem->size;
        $cartItemData['totalPrice']                 =  $membershipItem->totalPrice;
        $cartItemData['userContainerId']            =  '0';
        $cartItemData['type']                       =   $membershipItemType;
        $cartItemData['taxPercent']                 =  (!empty($membershipItem->taxAmt))?$vatApplied:'0';
        $cartItemData['taxValue']                   =  $membershipItem->taxAmt;
        $cartItemData['EuVatIdentificationNumber']  =  '0';
        $cartItemData['basePrice']                  =  number_format($membershipItem->price,2);
        
        //if type is 3 for user container renew
        $userContainerId =  $this->_getcontainerid($membershipItem);
        if($userContainerId){
          $cartItemData['userContainerId']        =   $userContainerId;
        }
     
        // insert data in user membership cart item
        $this->model_common->addDataIntoTabel('UserMembershipItem', $cartItemData);
      
        //unset old value array
        unset($cartItemData);
      }
      
      //renew user existing membership subscription plan
      $this->_renewpackagesubcription($userId,$orderId);
      
      //renew user selected container and campaign
      $this->_renewpackagecontainer($userId,$orderId);
      
    }
  }
  
  //----------------------------------------------------------------------

  /*
  *  @Description: This function is used to update userContainerId in
  *  UsermembershipId table
  *  @return false/containerId
  */ 
  
  private function _getcontainerid($membershipItem){
    $returnValue = false;
    if($membershipItem->type==$this->config->item('membership_item_type_3')){
      $renewContainEntityId    =  $membershipItem->entityId;
      $renewContainEelementId  =  $membershipItem->elementId;
      
      //renew container details
      $whereContainer        =  array('entityId' => $renewContainEntityId,'elementId' => $renewContainEelementId);
      $userContainerDetails  =  $this->model_common->getDataFromTabel('UserContainer', 'userContainerId',  $whereContainer, '', $orderBy='userContainerId');
      
      if(!empty($userContainerDetails)){
        $userContainerDetails  = $userContainerDetails[0];
        $userContainerId = $userContainerDetails->userContainerId;
        //set container id if exist
        $returnValue  =  $userContainerId;
      }
    }
    return $returnValue;
  }
    
    //--------------------------------------------------------------------
    
    /*
    * dummy testing method
    */ 
    function lokendra(){
        
        
        $this->_renewpackagesubcription('564','979');
    }
  
   //----------------------------------------------------------------------

  /*
   * @access: private
   * @description: This function is used to renew user package subscription 
   * @return array
   */ 
  
  private function _renewpackagesubcription($userId,$orderId){
      
    //get degrade session value if exist
    $isDowngradePackage = $this->session->userdata('isDegradePackage');

    //get user existing package details
    $whereSubcrip        =  array('tdsUid' => $userId);
    $userPackageDetails  =  $this->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);

    if(!empty($userPackageDetails)){
       $userPackageDetails  = $userPackageDetails[0];
    }else{
      return true; 
    }
    
    
    if(!empty($isDowngradePackage)){
        //membership change details
        $whereChangeMem        =  array('orderId' => $orderId,'type' =>$this->config->item('membership_item_type_4'));
        $ChangeMemData  =  $this->model_common->getDataFromTabel('UserMembershipItem', '*',  $whereChangeMem, '', $orderBy='memItemId');

        if(!empty($ChangeMemData)){
            $ChangeMemData  =   $ChangeMemData[0];
            $pakcageId      =  $ChangeMemData->pkgId;
        }
    }else{
        // get user existing package Id
        $pakcageId      =  $userPackageDetails->pkgId;
    }

    //get master pacakge data
    $whereCondition       =  array('pkgId' => $pakcageId);	
    $masterPakcageData    =  $this->model_common->getDataFromTabel('MasterPackage', 'pkgValidity',  $whereCondition, '', $orderBy='pkgId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
    
    if(!empty($masterPakcageData)){

        $masterPakcageData = $masterPakcageData[0];
        $duration    = $masterPakcageData->pkgValidity;
      
        //membership order extra space data
        $whereExtraSpace        =  array('orderId' => $orderId,'type' =>$this->config->item('membership_item_type_9'));
        $extraSpaceData  =  $this->model_common->getDataFromTabel('UserMembershipItem', '*',  $whereExtraSpace, '', $orderBy='memItemId');
      
      $extraSpaceSize = '0'; // default size of extra space
      if(!empty($extraSpaceData)){
        $extraSpaceData  = $extraSpaceData[0]; 
        $extraSpaceSize  = (!empty($extraSpaceData->size))?$extraSpaceData->size:'0';
      }
      
    // prepare membership start and end time
    $today 		      =     time();
      
    //membership downgrade condition
    if(!empty($isDowngradePackage)){
        $endDateStrtotime =  time(); // get package end date
    }else{  
        //membership renew condition  
        $pakcageEndDate =  strtotime($userPackageDetails->endDate); // get package end date
        //check for end of package
        if($pakcageEndDate < $today){
        $endDateStrtotime =  $today;
        }else{
        $endDateStrtotime =  $pakcageEndDate;
        }
    }

      $expiryDate     =     strtotime("+".$duration." months", $endDateStrtotime);
      $expiryDate     =     date('Y-m-d h:i:s',$expiryDate);
      $startDate	  =     currntDateTime();
      
      //package size update
      $packageSpace       =  mbToBytes($this->config->item('package_membership_default_space'),'gb');
      //$totalPackageSpace  =  $packageSpace  + $extraSpaceSize;
      $totalPackageSpace  =  $packageSpace;
      
      $packageType = '1';
        if($pakcageId=="16"){
            $packageType = '2';
        }elseif($pakcageId=="17"){
            $packageType = '3';
        }

      //prepare package update data
      $subscriptionData          =   array(
          'startDate'                =>  $startDate,
          'endDate'                  =>  $expiryDate,
          'modifiedDate'             =>  currntDateTime(),
          'packageSpace'             =>  $totalPackageSpace,
          'pkgId'                    =>  $pakcageId,
          'subscriptionType'         =>  $packageType,
      );
      
      //update for renew package data
      $this->model_common->editDataFromTabel('UserSubscription', $subscriptionData, $whereSubcrip);
    }
  }
  
  //----------------------------------------------------------------------

  /*
   * @access: private
   * @description: This function is used to renew package container 
   * @return void
   */ 
  
  private function _renewpackagecontainer($userId,$orderId){
    
    //membership order item data
    $whereMembershipItem        =  array('orderId' => $orderId, 'tdsUid'=>$userId, 'type'=>$this->config->item('membership_item_type_3'));
    $userMembershipItem  =  $this->model_common->getDataFromTabel('UserMembershipItem', '*',  $whereMembershipItem, '', $orderBy='memItemId');
    
    //get user package plan details
    $whereSubcrip 		= array('tdsUid' => $userId);
    $userSubscription  = $this->model_common->getDataFromTabel('UserSubscription', 'pkgId',  $whereSubcrip, '', $orderBy='pkgId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);

    if(!empty($userSubscription)){
      $userSubscription  =  $userSubscription[0];
      $pakcageId         =  $userSubscription->pkgId;
    }
    
    // get user selected package valedity
    $whereCondition = array('pkgId' => $pakcageId);	
    $pakcageData    = $this->model_common->getDataFromTabel('MasterPackage', 'pkgValidity',  $whereCondition, '', $orderBy='pkgId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);

    if(!empty($pakcageData)){
       $pakcageData   =  $pakcageData[0];
       $duration      =  $pakcageData->pkgValidity; 
    }
    
    if(!empty($userMembershipItem)){
      
      foreach($userMembershipItem as $userMembership){
        
        //get userContainerId
        $userContainerId  =  $userMembership->userContainerId;
        $memItemId        =  $userMembership->memItemId;
        
        $whereUserContainer        =  array('userContainerId' => $userContainerId, 'tdsUid'=>$userId );
        $userContainerDetails  =  $this->model_common->getDataFromTabel('UserContainer', 'expiryDate, pkgId, pkgRoleId',  $whereUserContainer, '', $orderBy='userContainerId');
        
        if(!empty($userContainerDetails)){
          $userContainerDetails = $userContainerDetails[0];

          //get master pacakge data
          $pakcageId            =  $userContainerDetails->pkgId;
          $expiryDate           =  $userContainerDetails->expiryDate;
          $renewExpireDate      =  $this->_renewcontainerdate($duration, $expireDate);
          $renewStartDate	      =  currntDateTime();
          
          //prepare array for update container renew
          $containerUpdateData['expiryDate']        =  $renewExpireDate; 
          $containerUpdateData['isSentExpiryMail']  =  'f'; 
          $containerUpdateData['isExpired']         =  'f'; 
          $containerUpdateData['orderId']	          =  $orderId;
          $containerUpdateData['orderitemid'] 	    =  $memItemId;
          
          //renew the container data
          $this->model_common->editDataFromTabel('UserContainer', $containerUpdateData, 'userContainerId', $userContainerId);	
          
          //prepare array for update campaing renew 	
          $campaingUpdateData['expire_time']              =  $renewExpireDate; 
          $campaingUpdateData['isExpired']                =  'f'; 
          $campaingUpdateData['target_impression']        =  $this->config->item('campagin_impression_count'); 
          
          //renew associated container campaign 
          //set default prefix for campaign
          $this->db->set_dbprefix('tds_');
          $this->model_common->editDataFromTabel('ox_campaigns', $campaingUpdateData, 'userContainerId', $userContainerId);	
          
          // set default prefix
          $this->db->set_dbprefix('TDS_');
          //unset array
          unset($containerUpdateData);
          unset($campaingUpdateData);
        }
      }
    }
  }
  
  
  
  //-----------------------------------------------------------------------------
  
  /*
   *  @Description: This function is use to get renew container expiry date
   *  @return expiry date
   */ 
  
  private function _renewcontainerdate($duration, $expireDate){
     
    // prepare membership start and end time
    $today 		      =     time();
    $pakcageEndDate =  strtotime($expireDate); // get package end date

    //check for end of package
    if($pakcageEndDate < $today){
      $endDateStrtotime =  $today;
    }else{
      $endDateStrtotime =  $pakcageEndDate;
    }

    $expiryDate     =     strtotime("+".$duration." months", $endDateStrtotime);
    $expiryDate     =     date('Y-m-d h:i:s',$expiryDate);

    return  $expiryDate; 
  }
  
  //-----------------------------------------------------------------------------
  
  /*
   * @Description: This function is used to save memerbship order data 
   * @retrun: OrderId
   */ 
  
  private function _packagemembershiporder($getData){
    
    if(isLoginUser()){
      $userId     =  isLoginUser(); # get user id
    }else{
      $userId     =  $this->session->userdata('joinedUserId');
    }
   
	// get current cartId
	$cartId =  $getData['CUSTOM'];
    
    // get temp membership cart tabel data
    $result = $this->model_common->getDataFromTabel('MembershipCart','*',  'cartId', $cartId,'', 'ASC', $limit=1 );
    
    // if empty then redirect to home page
    if(empty($result)){
      redirect('home');
    }elseif(!empty($result)){
      $result  = $result[0];
    }

     // set buyer details
    $billingdetails   =  (!empty($result->billingdetails))?$result->billingdetails:'';
   
    $paypalStatus     =  '1';

    //vat percent applied
    $vatPercentApplied   =  $this->config->item('package_vat_percent');

    $cartTotal       =  (!empty($result->totalPrice)) ? $result->totalPrice:'0';
    $vatValAmount    =  (!empty($result->totalTaxAmt)) ? $result->totalTaxAmt:'0';
    $TotalPaid       =  number_format(($cartTotal),2);
    $resultUserName  =  $this->model_common->getDataFromTabel('UserProfile','firstName,lastName',  'tdsUid', $userId,'', 'ASC', $limit=1 );
    $userEmail       =  $this->model_common->getDataFromTabel('UserAuth','email',  'tdsUid', $userId,'', 'ASC', $limit=1 );
    if($resultUserName){
      $userInfo = $resultUserName[0];
    }
    
    $userEmail = ($userEmail[0]->email!='') ? $userEmail[0]->email:'';

    $custName=$userInfo->firstName.' '.$userInfo->lastName;	

    $insert['cartId']         =  $cartId;
    $insert['grandTotal']     =  $cartTotal;
    $insert['totalTaxAmt']    =  number_format($vatValAmount,2);
    $insert['TotalPrice']     =  $cartTotal;
    $insert['paymentStatus']  =  $paypalStatus ;
    $insert['tdsUid']         =  $userId;
    $insert['totalPaid']      =  $TotalPaid;
    $insert['custName']       =  $custName;
    $insert['custPhone']      =  '';
    $insert['custEmail']      =  $userEmail;	
    $insert['buyerInfo']      =  $billingdetails;
    $insert['taxPercent']     =  $vatPercentApplied;
    $insert['taxValue']       =  number_format($vatValAmount,2);
    $insert['orderType']      =  $this->config->item('membership_order_type_3'); // membership  order type

    $this->db->insert('MembershipOrder', $insert);
    $orderId =  $this->db->insert_id();
    
    $membershipOrderArray =  array('orderId'=>$orderId,'cartId'=>$cartId,'userId'=>$userId,'paypalStatus'=>$paypalStatus);
 
    return $membershipOrderArray;
  }
  
  //------------------------------------------------------------------------------
  
  /*
   * @description: This function is used insert user membership data for 
   * individual container page
   * @return integer 
   */ 
  
  function UserMembershipItem($orderId,$cartId,$userId,$paypalStatus) {
    
   $vatApplied = getConsumptionTax($userId);
   $cartTotal  = getTotalPrice ($cartId,'cartId','price');
   $cartTotal  = $cartTotal->total;
     
   $TotalPaid  =  number_format(($cartTotal+$vatApplied),2);
   
    $order['cartId'] = $cartId;
    $order['grandTotal'] =  $cartTotal;
    $order['totalTaxAmt'] =  $vatApplied;
    $order['TotalPrice'] =  $cartTotal;
    $order['paymentStatus'] =  $paypalStatus ;
    $order['tdsUid'] =  $userId;
    $order['totalPaid'] =  $TotalPaid;
   
  // $orderId = $this->model_membershipcart->addOrderData($insert);
   
  
  // $this->db->insert('MembershipOrder', $order);
  // $orderId =  $this->db->insert_id();
   
   //$orderId=2;
   $userContainerId = 0;
  $items = $this->model_membershipcart->getAllCartItems($cartId);	
    
  foreach ($items as $cartItem){		
    
    if($cartItem->elementId!=''){			
      $userContainerId = $cartItem->elementId;			
      } else {
        $userContainerId = 0;				
        }		
    
    
  $pkgId = ($cartItem->pkgId!='') ?$cartItem->pkgId:0;	
  $pkgRoleId = ($cartItem->pkgRoleId!='') ?$cartItem->pkgRoleId:0;
  
  $buyerInfo = $this->billingInfo();	 
  $euIdNo=0;		
  if($buyerInfo->countryGroup=='EU'){					
   $euIdNo = ($buyerInfo->EuVatIdentificationNumber!='') ? $buyerInfo->EuVatIdentificationNumber : 0 ;		
  }
  
  
   $vatApplied = getConsumptionTax($userId);
   $vatVal = (($cartItem->price*$vatApplied)/100) ;	
   $totalPrice = number_format(($cartItem->price +  $vatVal),2);	
   $totalPaid =  number_format(($cartItem->price + $vatVal),2);
        
      $cart['orderId'] = $orderId;		
    $cart['tdsUid'] =  $userId;
    $cart['pkgId'] =  $pkgId;
    $cart['pkgRoleId'] =  $pkgRoleId;
    $cart['tsProductId'] =  $cartItem->tsProductId ;		
    $cart['size'] = is_numeric($cartItem->size)?$cartItem->size:0;
      $cart['totalPrice'] =  $totalPaid;
      $cart['userContainerId'] =$userContainerId;
      $cart['type'] =$cartItem->type;
      $cart['taxPercent'] =$vatApplied;
      $cart['taxValue'] =number_format($vatVal,2);
      $cart['EuVatIdentificationNumber'] =$euIdNo;
      $cart['basePrice'] =number_format($cartItem->price,2);
      
      
  
   /* ADD SPACE */
  if($cartItem->type!=2){ 		
     $this->db->insert('UserMembershipItem', $cart);
   }
   
    /* END */
    
    $parentId =  $this->db->insert_id();	
    $cartItems= $this->model_membershipcart->getAllChildItems($cartItem->cartItemId);
    
     if(is_array($cartItems) && count($cartItems)>0 ){
      foreach ($cartItems as $child){
       
       /* ADD SPACE */  
        if($child->type!=2){
          $parentId = $parentId;				  
          }else {
            $parentId = 0;					  
            }
           $parentId;  
       /* END */		  
          
          $childSize = ($child->size > 0) ? mbToBytes($child->size,'mb') :0;			    
              $childVatVal = (($child->price*$vatApplied)/100) ;		   
          $childPrice = $child->price; 
           
          $totalChildPaid =  number_format(($childPrice + $childVatVal),2);        
        $pkgId = ($child->pkgId!='') ?$child->pkgId:0;	
        $pkgRoleId = ($child->pkgRoleId!='') ?$child->pkgRoleId:0;					
        $cartChild['orderId'] = $orderId;				
        $cartChild['tdsUid'] =  $userId;
        $cartChild['pkgId'] =  $pkgId ;
        $cartChild['pkgRoleId'] =  $pkgRoleId;
        $cartChild['tsProductId'] =  $child->tsProductId ; ;
        $cartChild['parentContId'] =  $parentId;
        $cartChild['size'] = is_numeric($childSize)? $childSize:0;
        $cartChild['totalPrice'] =  $totalChildPaid;
                $cartChild['type'] =  $child->type; 
                $cartChild['userContainerId'] =$userContainerId;
                $cartChild['taxPercent'] =number_format($vatApplied,2);
        $cartChild['taxValue'] =$childVatVal;
        $cartChild['EuVatIdentificationNumber'] =$euIdNo;
        $cartChild['basePrice'] =number_format($child->price,2);
      if(($childSize>0)|| ($childPrice>0) ){	
        $this->db->insert('UserMembershipItem', $cartChild);		  
         }
        
       }	  
    }   
   }	 
    return $userContainerId;
  }	 
  
  //-------------------------------------------------------------------------
  
  /*
   * @description: This function is used to save membership item
   * @return array
   * 
   */ 
  
  function packagemembershipitem($orderId,$cartId,$userId,$paypalStatus) {
    
    //get membership cart item 
    $membershipTempItemData = getDataFromTabel('MembershipCartItem','*',  'cartId', $cartId,'', 'ASC', $limit=1 );

    if(!empty($membershipTempItemData)){
      $membershipTempItemData = $membershipTempItemData[0];
    }
	
		/* set new package type  */
		$packageType 			= $this->config->item('membership_item_type_4');
		/* get upgrade session value */
		$isUpgradePackage =  $this->session->userdata('isUpgradePackage');
		if(!empty($isUpgradePackage)) {
			/* set upgrade package type  */
			$packageType = $this->config->item('membership_item_type_6');
		}

    // vat percent 
    $vatApplied  = $this->config->item('package_vat_percent');

    $cartItemData['orderId']                    =  $orderId;		
    $cartItemData['tdsUid']                     =  $userId;
    $cartItemData['pkgId']                      =  $membershipTempItemData->pkgId;
    $cartItemData['pkgRoleId']                  =  '0';
    $cartItemData['tsProductId']                =  '0';		
    $cartItemData['size']                       =  $membershipTempItemData->size;
    $cartItemData['totalPrice']                 =  $membershipTempItemData->totalPrice;
    $cartItemData['userContainerId']            =  '0';
    $cartItemData['type']                       =  $packageType;
    $cartItemData['taxPercent']                 =  $vatApplied;
    $cartItemData['taxValue']                   =  $membershipTempItemData->taxAmt;
    $cartItemData['EuVatIdentificationNumber']  =  '0';
    $cartItemData['basePrice']                  =  number_format($membershipTempItemData->price,2);

    // insert data in user membership cart item
    $this->db->insert('UserMembershipItem', $cartItemData); 
    
    //update subscription data  by selected packages
    $this->_subcriptionupdate($userId,$membershipTempItemData->pkgId);
   
  }
  
  //----------------------------------------------------------------------

  /*
   * @access: private
   * @description: This function is used to update user subscription data
   * by selected package
   * @return array
   */ 
  
  private function _subcriptionupdate($userId,$pakcageId="0",$isPromoCode="f",$promoCode=NULL){

    //get master pacakge data
    $whereCondition = array('pkgId' => $pakcageId);	
    $pakcageData    = $this->model_common->getDataFromTabel('MasterPackage', 'pkgValidity',  $whereCondition, '', $orderBy='pkgId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);

    if(!empty($pakcageData)){

      $pakcageData = $pakcageData[0];
      $duration 	 = $pakcageData->pkgValidity;
      //get selected package type
      $pakcageType = ($pakcageId==$this->config->item('package_1_year_id'))?$this->config->item('package_type_2'):$this->config->item('package_type_3');

      // prepare membership start and end time
      $today 		   = 	time();
      $expiryDate  = 	strtotime("+".$duration." months", $today);
      $expiryDate  = 	date('Y-m-d h:i:s',$expiryDate);
      $startDate	 = 	currntDateTime();

      //prepare insert and update data
      $subscriptionData          =   array(
      'tdsUid'                   =>  $userId,
      'startDate'                =>  $startDate,
      'endDate'                  =>  $expiryDate,
      'pkgId'                    =>  $pakcageId,
      'subscriptionType'         =>  $pakcageType,
      'modifiedDate'             =>  currntDateTime(),
      'packageSpace'             =>  mbToBytes($this->config->item('package_membership_default_space'),'gb'),
      'status'                   =>  '1',
      'isPromoCode'              =>  $isPromoCode,
      'promoCode'                =>  $promoCode,
      );

      //update data in user-subscription
      $whereSubcrip 		= array('tdsUid' => $userId);
      $userSubscription  = $this->model_common->getDataFromTabel('UserSubscription', 'subId',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);

      if(!empty($userSubscription)){
        //update for new registered member
        $this->model_common->editDataFromTabel('UserSubscription', $subscriptionData, $whereSubcrip);
      }else{
        //insert for already registered member
        $this->model_common->addDataIntoTabel('UserSubscription', $subscriptionData);
      }
      
      //activate user data
      $whereUserCondition 		= array('tdsUid' => $userId);
      $getUserData    = $this->model_common->getDataFromTabel('UserAuth', 'fbUid, email',  $whereUserCondition, '', $orderBy='tdsUid', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
      if(!empty($getUserData)){
          $getUserData = $getUserData[0];
          if(!empty($getUserData->fbUid)){
              $userUpdateData=array( 'active'=> '1', 'modified'=>date('Y-m-d H:i:s'));
              $this->model_common->editDataFromTabel('UserAuth', $userUpdateData, $whereUserCondition); 
          }
      } 
       
    }
  } 
  
    //-----------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use update promo code user subscription update
    *  @auther: lokendra meena
    *  @return: void
    */ 
   
    public function promocodesubcription($userId,$pakcageId,$promoCode){
        
        $this->_subcriptionupdate($userId,$pakcageId,"t",$promoCode);
    }
    
  //---------------------------------------------------------------------- 
  
  /**
   *  INSERT DATA IN CONTAINER
   *  orderId N userContainerId to update tables
   * 
   **/ 
   
   function insertDataInConatainer($orderId,$userContainerId){	   
     
		$membershipItem = $this->model_membershipcart->getMembershipItem($orderId); 
		/*echo "<pre>";
		print_r($membershipItem);die();*/
        $userContainerId = 0;
		foreach ($membershipItem as $item) {
       
			$pkgId = ($item->pkgId!='') ?$item->pkgId:0; 
			$pkgRoleId = ($item->pkgRoleId!='') ?$item->pkgRoleId:0;
			$extarSpaceTotal =  $this->model_membershipcart->getContainerPrice($item->memItemId);			
			$extarSpaceTotal->total;
			
			$containerId = (!empty($item->userContainerId))? $item->userContainerId:$userContainerId;
			
			$data['tdsUid'] 		=  $item->tdsUid;
			$data['containerSize']	=  $extarSpaceTotal->total;
			$data['orderId']		=  $item->orderId;
			$data['pkgId'] 			=  $pkgId ;
			$data['tsProductId']    =  $item->tsProductId ; 
			$data['pkgSections'] 	=  $item->allowedSections;					
			$data['duration'] 		=  $item->duration;
			$data['pkgRoleId'] 		=  $pkgRoleId;					                   
			$data['title'] 			=  $item->title;
			$data['orderitemid'] 	=  $item->memItemId; 			
      
			/* In case of Add Space N Renewal We have to update conatiner */	
			if(isset($item->type) && $item->type!=1){	
        
				$containerSize = $this->model_common->getDataFromTabel('UserContainer', 'userContainerId,entityId,elementId,pkgSections,containerSize,expiryDate,pkgRoleId',  array('userContainerId'=>$containerId),'','','',1);						
        
				//$containerSize=mbToBytes($containerSize[0]->containerSize,'mb');	                        						
				$size= $containerSize[0]->containerSize + $extarSpaceTotal->total;
        
				// If Renew update space 
				if(isset($item->type) && $item->type==3){
         
					//$size= $extarSpaceTotal->total;	
            
					// get container expiry date
					$expiryDate = $this->getContainerExpireDate($containerSize[0]->pkgRoleId,$containerSize[0]->expiryDate);
					if(isset($expiryDate) && strlen($expiryDate) >=6 ){
						$dataU['expiryDate'] =  $expiryDate; 
					}
					$dataU['isSentExpiryMail'] =  'f'; 
					$dataU['isExpired'] =  'f'; 
            
					// move project to unarchive 
					$this->updateConatainerElement($containerSize[0]->entityId,$containerSize[0]->elementId,$containerSize[0]->pkgSections,$containerSize[0]->userContainerId);
              
				}
            
				// if type is 2 then update new purchase space
				if(isset($item->type) && $item->type==2){
					$dataU['containerSize'] =  $size; 
				}
        
				$dataU['orderId']	    =  $item->orderId;
				$dataU['orderitemid'] 	=  $item->memItemId;
				$this->model_common->editDataFromTabel('UserContainer', $dataU, 'userContainerId', $containerId);				
        
				/* In case of New Container request */	
			} else {			
				$userContainerId = $this->model_common->addDataIntoTabel('UserContainer',$data);			
			}			    
		}
	}
  
  //----------------------------------------------------------------------------  
    
  /*
   ************************  
   *  This function is used to update project unarchive
   *********************** 
   */   
  
  function  updateConatainerElement($entityId,$elementId,$pkgSections,$userContainerId)
  {
    
    $istable=true;
    $isElements=false;
    $eventWithLaunch=false;
    
    $tableElement='';
    $primeryFieldElement='';
    $publishFieldElement='';
    $archiveFieldElement='';
    
    if(isset($entityId) && isset($elementId) && $entityId > 0 && $elementId >0){
        
        switch($entityId){
          case 93: 
            $table='TDS_UserShowcase';
            $primeryField='showcaseId';
            $publishField='isPublished';
            $archiveField='isArchive';
            break;
          case 86: 
            $table='TDS_WorkProfile';
            $primeryField='workProfileId';
            $publishField='isPublished';
            $archiveField='isArchive';
            break;
          case 71: 
            $table='TDS_UpcomingProject';
            $primeryField='projId';
            $publishField='isPublished';
            $archiveField='projArchived';
            break;
          case 82: 
            $table='TDS_Work';
            $primeryField='workId';
            $publishField='isPublished';
            $archiveField='workArchived';
            break;
          case 49: 
            $table='TDS_Product';
            $primeryField='productId';
            $publishField='isPublished';
            $archiveField='productArchived';
            break;
          case 97: 
            $table='TDS_Blogs';
            $primeryField='blogId';
            $publishField='blogPublish';
            $archiveField='isArchive';
            
            $isElements=true;
            $tableElement='TDS_Posts';
            $primeryFieldElement='blogId';
            $publishFieldElement='isPublished';
            //$archiveFieldElement='postArchived';
            break;
          case 9: 
            $table='TDS_Events';
            $primeryField='EventId';
            $publishField='isPublished';
            $archiveField='EventArchive';
            if($pkgSections=='{9:4}'){
              $eventWithLaunch=true;
            }
            break;
          case 15: 
            $table='TDS_LaunchEvent';
            $primeryField='LaunchEventId';
            $publishField='isPublished';
            $archiveField='isArchive';
            break;
            
          case 54: 
            $table='TDS_Project';
            $primeryField='projId';
            $publishField='isPublished';
            $archiveField='isArchive';
            
            $isElements=true;
            if($pkgSections=='{1}'){
              $tableElement='TDS_FvElement';
            }elseif($pkgSections=='{2}'){
              $tableElement='TDS_MaElement';
            }elseif($pkgSections=='{3}'){
              $tableElement='TDS_WpElement';
            }elseif($pkgSections=='{3:1}'){
              $tableElement='TDS_NewsElement';
            }elseif($pkgSections=='{3:2}'){
              $tableElement='TDS_ReviewsElement';
            }elseif($pkgSections=='{4}'){
              $tableElement='TDS_PaElement';
            }elseif($pkgSections=='{10}'){
              $tableElement='TDS_EmElement';
            }
            $primeryFieldElement='projId';
            $publishFieldElement='isPublished';
            break;
            
          default:
            $istable=false;
                
        }

        if($istable){
          
          //--------update data in project table---------//
          $updateData = array($archiveField=>'f','isExpired'=>'f');
          $result = $this->model_common->editDataFromTabel($table, $updateData, array($primeryField=>$elementId));
          
          if($result){
            
            //------update project data in search table-----------//
            $searchUpdate =  array('isdeleted'=>'f','datemodified'=>date('Y-m-d h:i:s'));
            $res1 = $this->model_common->editDataFromTabel('search', $searchUpdate, array('entityid'=>$entityid,'elementid'=>$elementId));
            
            //------------check is element data update---------//
            if($isElements){
              //------update element data in search table-----------//
              $searchElementUpdate =  array('isdeleted'=>'f','datemodified'=>date('Y-m-d h:i:s'));
              $res2 = $this->model_common->editDataFromTabel('search', $searchElementUpdate, array('entityid'=>$entityid,'projectid'=>$elementId));
            }
            
            //--------check eventWithLaunch then action--------//
            if($eventWithLaunch){
              //------get data in launch table-----------//
              $launchResult =$this->model_common->getDataFromTabel('LaunchEvent', 'LaunchEventId',  array('userContainerId'=>$userContainerId),'','','');						
            
              foreach ($launchResult as $rows) {
                if(isset( $rows->LaunchEventId) && $rows->LaunchEventId >0){
                  
                  //------update data in launch table-----------//
                  $launchEventUpdate =  array('isArchive'=>'f','isExpired'=>'f');
                  $res3 = $this->model_common->editDataFromTabel('LaunchEvent', $launchEventUpdate, array('LaunchEventId'=>$rows->LaunchEventId));
                  
                  //------update launch data in search table-----------//
                  if($res3){
                    $searchLaunchUpdate =  array('isdeleted'=>'f','datemodified'=>date('Y-m-d h:i:s'));
                    $res1 = $this->model_common->editDataFromTabel('search', $searchLaunchUpdate, array('entityid'=>'15','elementid'=>$rows->LaunchEventId));
                }
              }
            }
          }
        }
      }
    
    }
     
  }	
     

  function getContainerExpireDate($pkgRoleId,$expireDate){
  
    $containerExpireData =  $this->model_membershipcart->getContainerExpireDate($pkgRoleId);
    //$expireDate='2013-09-14 02:50:02';
    $duration=NULL;
    // first check duration in masterPackageRole table
    if($containerExpireData->initialValidity!='')
    {
      $duration = $containerExpireData->initialValidity;
    //then check in duration in masterPackage table		
    }elseif($containerExpireData->pkgValidity!=''){
      
      $duration = $containerExpireData->pkgValidity;
    //then check in duration in masterTsProduct table	
    }elseif($containerExpireData->duration!=''){
    
      $duration = $containerExpireData->duration;
    // other wise set defult unlimited expire date	
    }else{
      
      $duration = NULL;
    }
    
    if($duration!=NUll && $duration!=0){
      
      $expireTimeStamp= strtotime($expireDate);
      $currentTimeStamp= time();
      
      if($expireTimeStamp >= $currentTimeStamp){
      
        $containerExtendDate = $expireTimeStamp;
      }else{
        $containerExtendDate = $currentTimeStamp;
      }
      $monthDuration = $duration.' month';
      
      $updateExpireDate = getPreviousOrFututrDate(date('Y-m-d H:i:s',$containerExtendDate), $monthDuration ,$format='Y-m-d H:i:s');
    }else{
      $updateExpireDate = $duration;
    }
    
    return $updateExpireDate;
      
  }



   /**
   * Update Container
   * Add Container Id in User MembershipItem Table
   * orderId is current inserted id in Order table
   * 
   * */
     
  function updateConatainer($orderId){	 
  
   $containerData = $this->model_membershipcart->getUserContainerData($orderId);	
    
    if(isset($containerData) && is_array($containerData) && count($containerData)>0) {	
       foreach($containerData as $item) { 
               
        $data['userContainerId'] = $item->userContainerId;						
        $this->model_common->editDataFromTabel('UserMembershipItem', $data, 'memItemId', $item->orderitemid);
        $this->model_common->editDataFromTabel('UserMembershipItem', $data, 'parentContId', $item->orderitemid);
      }
    }
    
   $this->session->unset_userdata('currentCartId');	
   
  }	     
     

  
 /* Check wheather selected country in billing form in cart is european or not */
  
 function checkBillingCountry($countryId) {
   
    $countryDetails = $this->model_membershipcart->getUserCountryName($countryId);	  
    if(isset($countryDetails->countryGroup) && ($countryDetails->countryGroup=='EU')){		  
         echo 1;	  		  
      }
        else {
        echo 0;
      }
  }
  
 /**
  *  Add Space
  *  userContainerId to get data of container
  *  Update data bases of this ID
  *  */
 
  public function addspace($userContainerId=''){	
  
  $productDetailsList = array();
  $data = array();
  $loginuserId=$this->isloginUser();
  $addCart = array('totalPrice'=>'0','totalTaxAmt'=>'0','tdsUid'=>$loginuserId);
  $cartId=$this->session->userdata('currentCartId');
  if($cartId==''){
    $cartId =  $this->model_common->addDataIntoTabel('MembershipCart', $addCart);
    }
  $this->session->set_userdata('currentCartId',$cartId);
  
 if(isset($userContainerId) && ($userContainerId>0)) { 
                            
  $productDetailsList = $this->model_membershipcart->getUserContainerInfo($userContainerId);		
  //$productDetailsList['extraSpace'] =getAssociatedSpace($containerId);
       
  $insert['cartId'] = $cartId;
  $insert['tsProductId'] =  $productDetailsList[0]->tsProductId;
  $insert['price'] =  $productDetailsList[0]->price;
  $insert['size'] =  is_numeric($productDetailsList[0]->size)? $productDetailsList[0]->size:0;
  //$insert['parentCartItemId'] =  $containerId;
  $insert['entityId'] =  75;
  $insert['elementId'] =  $productDetailsList[0]->userContainerId;	
  $insert['pkgId'] =  $productDetailsList[0]->pkgId;
  $insert['type'] = 2;
  //$insert['totalPrice'] =$productDetailsList[0]->price;
  
  // Added to check wheather this is already added in current session	
  $res=$this->model_common->getDataFromTabel('MembershipCartItem', 'tsProductId',  array('cartId'=>$cartId,'type'=>2,'elementId'=>$productDetailsList[0]->userContainerId,'entityId'=>75),'','','',1);		
  
  
    if(($res) && isset($res[0]->tsProductId) && ($res[0]->tsProductId!='') ){
       //$this->model_common->editDataFromTabel('MembershipCartItem', $data, 'memItemId', $res[0]->tsProductId); 					
    }else{			
        $this->model_common->addDataIntoTabel('MembershipCartItem', $insert);  
       }	
    
  //$this->model_common->addDataIntoTabel('MembershipCartItem', $insert);				
        
  } else { // IF DIRECT HIT BY USER OR BLANK DATA		  
        redirect(base_url(lang().'/package/buytools'));
        }	  
  // redirect(base_url(lang().'/membershipcart/buyspace/addspace'));		  
   redirect(base_url(lang().'/membershipcart/buyspace'));		  
 } 
 
 
 /** 
  * Renew Cart
  * get userContainerId from calling function  
  * 
  *  */
 
 function renewCart($userContainerId=''){	 

  if(isset($userContainerId) && ($userContainerId!='')) {
       
    $productDetailsList = array();
    $data = array();

    $loginuserId=$this->isloginUser();
    $addCart = array('totalPrice'=>'0','totalTaxAmt'=>'0','tdsUid'=>$loginuserId);
    $cartId=$this->session->userdata('currentCartId');
      if($cartId==''){
          $cartId =  $this->model_common->addDataIntoTabel('MembershipCart', $addCart);
      }
    $this->session->set_userdata('currentCartId',$cartId);

    $product=$this->model_common->getDataFromTabel('UserContainer', 'containerSize,tsProductId,pkgId',  array('userContainerId'=>$userContainerId),'','','',1);	

    $containerSize = bytestoMB($product[0]->containerSize); 		
    $productDetailsList = $this->model_membershipcart->getProductDetails($product[0]->tsProductId);	

    $insert['cartId'] = $cartId;
    $insert['tsProductId'] = $productDetailsList[0]->tsProductId;
    $insert['price'] =  $productDetailsList[0]->price;
    //$insert['size'] =  is_numeric($productDetailsList[0]->size)? $productDetailsList[0]->size:0;	
    $insert['entityId'] =  75;
    $insert['elementId'] =$userContainerId;	
    $insert['pkgId'] =  $product[0]->pkgId;
    $insert['type'] = 3;

    //$usedSpace = encode($usedSpace);
    
  // Added to check wheather this is already added in current session	
  $res=$this->model_common->getDataFromTabel('MembershipCartItem', 'tsProductId',  array('cartId'=>$cartId,'type'=>3,'elementId'=>$userContainerId,'entityId'=>75),'','','',1);		
  
   if(($res) && isset($res[0]->tsProductId) && ($res[0]->tsProductId!='') ){
       //$this->model_common->editDataFromTabel('MembershipCartItem', $data, 'memItemId', $res[0]->tsProductId); 					
    }else{			
        $this->model_common->addDataIntoTabel('MembershipCartItem', $insert);  
       }	
       
  //$this->model_common->addDataIntoTabel('MembershipCartItem', $insert);  		 
    
    redirect(base_url(lang().'/membershipcart/buyspace'));
   }
    else { // IF DIRECT HIT BY USER OR BLANK DATA		  
         redirect(base_url(lang().'/package/buytools'));
        }	   
       
   }


/* Add single tool from Dashboard */ 	 
   
  public function addTool($prodId=''){				
    
 if ($prodId!='') {	
  
  $productDetailsList = array();
  $data = array();
  
  $loginuserId=$this->isloginUser();	
  $inserts = array('totalPrice'=>'0','totalTaxAmt'=>'0','tdsUid'=>$loginuserId);	
  
  $cartId=$this->session->userdata('currentCartId');
  if($cartId==''){
  $cartId = $this->model_membershipcart->addData($inserts);
    }
  $this->session->set_userdata('currentCartId',$cartId);	  
  $i=0;													
  $productDetailsList[$i] = $this->model_membershipcart->getProductDetails($prodId);					
  $productDetailsList[$i]['qty'] = 1;	
    
     $res = $this->model_membershipcart->getRoleId($productDetailsList[$i][0]->tsProductId);
     $pkgId  = (isset($res[0]['pkgId']) && ($res[0]['pkgId']!=''))?$res[0]['pkgId']: 0;
     $pkgRoleId = (isset($res[0]['pkgRoleId']) && ($res[0]['pkgRoleId']!=''))?$res[0]['pkgRoleId']: 0; 
                 
    $insert['cartId'] = $cartId;
    $insert['tsProductId'] =  $productDetailsList[$i][0]->tsProductId;
    $insert['price'] =  $productDetailsList[$i][0]->price;
    $insert['size'] =  is_numeric($productDetailsList[$i][0]->size)? $productDetailsList[$i][0]->size:0;
    $insert['pkgId'] =  $pkgId;
    $insert['pkgRoleId'] =  $pkgRoleId;
    $insert['totalPrice'] =  $productDetailsList[$i][0]->price;								
    $this->model_membershipcart->addDataMem($insert);			
    //$data['productDetails']=$productDetailsList;
      redirect(base_url(lang().'/membershipcart/buyspace'));	
  }			
    else { // IF DIRECT HIT BY USER OR BLANK DATA		  
         redirect(base_url(lang().'/package/buytools'));
         }
    
 }	 
   
 
 
 /**
  * Get Used Space of Folder
  * industryType N projectId to get space of that folder
  * 
 **/ 
 
  function getFolderUsedSize($industryType='',$projectId=''){
  
  $uploadDir ='media/'.LoginUserDetails('username');	 
  $dirname = $uploadDir.$this->config->item($industryType.'UploadMedia');	
  $dirname=is_dir($dirname.$projectId)?$dirname.$projectId:$dirname;	
  $dirSize=getFolderSize($dirname);		
  $continerSize=bytestoMB($dirSize,'mb');
  $usedSpace=number_format($continerSize,0); 	  
  return  $usedSpace;	  
  }
  
  function billingInfo(){
   $userId=isloginUser();
   $billingDetail = $this->model_membershipcart->getBillingDetails(); 
   if(isset($billingDetail->billingdetails) && $billingDetail->billingdetails!=''){
      $billingDetail = json_decode($billingDetail->billingdetails);
      $userProfileData =  $billingDetail;
    }else {	  
      $userProfileData =  $this->model_membershipcart->getUserBillingDetails($userId);
    }
    
      return $userProfileData;	  
    }
    
    
	/** 
	  * Save Free Order in DB
	  * In case of free renew Order
	  */ 
 
	function saveFreeOrder($cartId=""){	
		$userId=$this->isloginUser();
		$result = getDataFromTabel('MembershipCart','tdsUid,billingdetails',  'cartId', $cartId,'', 'ASC', $limit=1 );	
		$userId = ($result[0]->tdsUid!='') ? $result[0]->tdsUid:0;
		$paypalStatus = '1';	 
	  
		/*************get userinfo *************/
		
		$billingDetail = $this->model_membershipcart->getBillingDetails($userId);

		if(isset($billingDetail->billingdetails) && $billingDetail->billingdetails!=''){
		  $billingdetails = json_decode($billingDetail->billingdetails);
		}else {	  
		  $billingdetails =  $this->model_membershipcart->getUserBillingDetails($userId);
		}
		$billingdetails = json_encode($billingdetails);
	  
		/*************get userinfo *************/	   
  
		$vatApplied = getConsumptionTax($userId);
		$cartTotal = getTotalPrice ($cartId,'cartId','price');
		$cartTotal = $cartTotal->total;
	   
		$vatValTot = (($cartTotal*$vatApplied)/100) ;
       
		$TotalPaid =  $cartTotal+$vatValTot;
		$resultUserName = getDataFromTabel('UserProfile','firstName,lastName',  'tdsUid', $userId,'', 'ASC', $limit=1 );
		$userEmail = getDataFromTabel('UserAuth','email',  'tdsUid', $userId,'', 'ASC', $limit=1 );
		if($resultUserName)
     $userInfo = $resultUserName[0];
     
   $userEmail = ($userEmail[0]->email!='') ? $userEmail[0]->email:'';
     
   $custName=$userInfo->firstName.' '.$userInfo->lastName;	
   
    $insert['cartId'] = $cartId;
    $insert['grandTotal'] =  $cartTotal;
    $insert['totalTaxAmt'] =  $vatApplied;
    $insert['TotalPrice'] =  $cartTotal;
    $insert['paymentStatus'] =  $paypalStatus ;
    $insert['tdsUid'] =  $userId;
    $insert['totalPaid'] =  $TotalPaid;
    $insert['custName'] = $custName;
    $insert['custPhone'] =  '';
    $insert['custEmail'] =$userEmail;	
    $insert['buyerInfo'] =$billingdetails;
    $insert['taxPercent'] =$vatApplied;
    $insert['taxValue'] =number_format($vatValTot,2);
    $insert['isFree'] ='t';
      
	// $orderId = $this->model_membershipcart->addOrderData($insert);
   
	// $this->db->insert('MembershipOrder', $updatedata);
	$this->db->insert('MembershipOrder', $insert);
	$orderId =  $this->db->insert_id();

	$userContainerId = $this->UserMembershipItem($orderId,$cartId,$userId,$paypalStatus);	

	// ADD DATA IN CONTAINER	 
	$this->insertDataInConatainer($orderId,$userContainerId);

	// Update  DATA IN CONTAINER 
	return $this->updateConatainer($orderId);

    }	  
  
  
  //------------------------------------------------------------------------
  
  /*
   * @Description: This function is use to show membership invoice 
   * @return: void
   */ 
 
  public function membershipInvoice($orderId=0)
  { 
    // This function is use to get order details
    $membershipDetails = $this->model_membershipcart->membership_order_details($orderId);
    
    if(!empty($membershipDetails)){
        
        // get order item listing
        $membershipItemList = $this->model_membershipcart->get_membership_item($orderId);
        
        //call method for invoice html
        echo  $this->_invoiceHtmlBody($membershipDetails,$membershipItemList);
    }
  }
  
  //-------------------------------------------------------------------------

  /*
  * @Description: This function is used to send membership invoice
  * @return: void
  */  
  
  
  public function membershipInvoiceEmail($orderId=0)
  {
    // This function is use to get order details
    $membershipDetails = $this->model_membershipcart->membership_order_details($orderId);
    
    if(!empty($membershipDetails)){
        
        // get order item listing
        $membershipItemList = $this->model_membershipcart->get_membership_item($orderId);
       
        //call method for invoice html
        $invoiceHtmlBody = $this->_invoiceHtmlBody($membershipDetails,$membershipItemList);
        
        //call method for membership email
        $emailSendData = $this->_membershipInvoiceEmailNTmail($membershipDetails,$membershipItemList);
        
        // get email subject and body
        $emailSubject    =  $emailSendData['emailSubject'];
        $emailBody       =  $emailSendData['emailBody'];
       
        //order invoice number
        $orderInvoiceNumber     =  getInvoiceId($membershipDetails['ordNumber'],1);
       
        //attachment file create here start
        $attachmentInvoice=  'invoices/'.$orderInvoiceNumber.'.'.'html';
        $handle = fopen($attachmentInvoice, 'w');//create file here
        fwrite($handle, $invoiceHtmlBody); 
       
        //get buyer info for sending email
        $buyerDetails      = (array) json_decode($membershipDetails['buyerInfo']);
        $buyerEmail        =  $buyerDetails['billing_email'];
       
        //send email to  
        $this->load->library('email');
        $this->email->from($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
        $this->email->reply_to($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
        $this->email->to($buyerEmail);
        $this->email->cc($this->config->item('toadsquare_email')); // need to change with toadsquare email
        $this->email->subject(sprintf($emailSubject));
        $this->email->message($emailBody);
        $this->email->attach($attachmentInvoice);
        $this->email->send();
        unlink($attachmentInvoice); 
    }
    
  }
  
  //-----------------------------------------------------------------------
  
  /*
   * @Description: This function is use to send email and tmail 
   * membership and tool purchase
   * @return: html (string) 
   */ 
   private function _membershipInvoiceEmailNTmail($membershipDetails,$membershipItemList){
        
    $orderType  =  $membershipDetails['orderType'];
    
    switch($orderType){
        case '1';
        case '3';
            //call method for tool purchase notification 
            $purchaseEmailData = $this->_toolPurchaseEmailNTmail($membershipDetails,$membershipItemList);
        break;

        case '2';
        case '4';
            //call method for tool refund notification 
            $purchaseEmailData = $this->_toolRefundEmailNTmail($membershipDetails,$membershipItemList); 
        break; 
    }
    return array('emailSubject'=>$purchaseEmailData['emailSubject'],'emailBody'=>$purchaseEmailData['emailBody']);
  }
  
  //----------------------------------------------------------------------
  
  /*
   * @Description: This function is use to tool purchase email and tmail notificatin
   * @return: array
   */ 
  
  private function _toolPurchaseEmailNTmail($membershipDetails,$membershipItemList){
	/* get upgrade session value */
	$isUpgradePackage =  $this->session->userdata('isUpgradePackage');
	/* get renew session value */
	$isRenewPackage =  $this->session->userdata('isRenewPackage');
	$membershipItem = $membershipItemList[0];
	if(!empty($isUpgradePackage) && empty($isRenewPackage)) {
		
		// set email template for upgrade membership
		$emailData      = $this->membershipUgradeTemplate($membershipItem);
		$emailBody      =  $emailData['emailBody'];
		$emailSubject   =  $emailData['emailSubject'];
	} else if(!empty($isRenewPackage) && empty($isUpgradePackage)) {
		
		// set email template for renew membership
		$emailData      = $this->membershipRenewTemplate($membershipItem);
		$emailBody      =  $emailData['emailBody'];
		$emailSubject   =  $emailData['emailSubject'];
	} else {
		//tool purchase prepare email body and subject
		$whereCondi         =  array('purpose'=>'toolpurchase','active'=>1);
		$toolPurchaseBody   =  getDataFromTabel('EmailTemplates','templates,subject',  $whereCondi, '','', '', 1 );
		$toolPurchaseBody   =  $toolPurchaseBody[0];
		$site_url           =  base_url();
		$site_base_url      =  site_base_url();
		$image_base_url     =  site_base_url().'images/email_images/';
		$crave_us           =  $this->config->item('crave_us');
		$invoice_name       =  'Purchases';
		$invoice_url        =  base_url().'package/membershipinvoices';
		$dashboard_url      =  base_url('dashboard');
		$facebook_url       =  $this->config->item('facebook_follow_url');
		$linkedin_url       =  $this->config->item('linkedin_follow_url');
		$toolBody           =  $toolPurchaseBody->templates;
		$getArray           =  array("{crave_us}","{facebook_url}","{linkedin_url}","{invoice_name}" ,"{purchase_page_url}" , "{dashboard_url}" ,"{site_url}" , "{site_base_url}", "{image_base_url}");
		$replaceArray       =  array($crave_us,$facebook_url,$linkedin_url,$invoice_name, $invoice_url, $dashboard_url, $site_url,$site_base_url,$image_base_url);
		$emailBody          =  str_replace($getArray, $replaceArray, $toolBody);
		$emailSubject       =  $toolPurchaseBody->subject;
	}

    //send tool purchase tmail notification
    $where              =  array('purpose'=>'tmailtoolpurchase','active'=>1);
    $toolTemplateRes    =  getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
    $toolTemplate       =  $toolTemplateRes[0]->templates;
    $dashboard_url      =  site_url().'dashboard';
    $invoice_url        =  base_url().'package/membershipinvoices';
    $searchArray        =  array("{tool_name}","{purchase_page_url}","{dashboard_url}");
    $replaceArray       =  array($invoice_name,$invoice_url,$dashboard_url);
    $toolTmailBody      =  str_replace($searchArray, $replaceArray, $toolTemplate);
    $toolTmailSubject   =  $toolTemplateRes[0]->subject;
    
    $senderId   = 0; //message send from toadsquare
    $recipients = $membershipDetails['tdsUid'];
    $this->tmail_messaging->send_new_message($senderId,$recipients, $toolTmailSubject,$toolTmailBody,'',9);
    
    return array('emailSubject'=>$emailSubject,'emailBody'=>$emailBody);
  }
  
   //----------------------------------------------------------------------
  
   /*
	* @Description: This function is use to manage membership updation template
	* @return: array
	*/ 
  
	private function membershipUgradeTemplate($membershipItem) {
		
		//membership management prepare email body and subject
		$whereCondi         =  array('purpose'=>'membershipupgrade','active'=>1);
		$templateBody   =  getDataFromTabel('EmailTemplates','templates,subject',  $whereCondi, '','', '', 1 );
		$templateBody   =  $templateBody[0];
		if($membershipItem['pkgId'] == $this->config->item('package_1_year_id')) {
			$membership_type = $this->config->item('package_title_2'); 
		} elseif($membershipItem['pkgId'] == $this->config->item('package_3_year_id')) {
			$membership_type = $this->config->item('package_title_3'); 
		}

		$image_base_url     =  site_base_url().'images/email_images/';
		$crave_us           =  $this->config->item('crave_us');
		$invoice_url        =  base_url().'package/membershipinvoices';
		$facebook_url       =  $this->config->item('facebook_follow_url');
		$linkedin_url       =  $this->config->item('linkedin_follow_url');
		$toolBody           =  $templateBody->templates;
        $expiry_date        =  date('d F Y', strtotime("+12 months ".$membershipItem['createDate']));
		$membership_price   =  $this->config->item('toadCurrencySgine').''.$membershipItem['basePrice'];
		$getArray           =  array("{expiry_date}","{membership_type}","{membership_price}","{membership_action}","{crave_us}","{facebook_url}","{linkedin_url}","{purchase_page_url}" , "{image_base_url}");
		$replaceArray       =  array($expiry_date,$membership_type,$membership_price,$membership_action,$crave_us,$facebook_url,$linkedin_url,$invoice_url,$image_base_url);
		$emailBody          =  str_replace($getArray, $replaceArray, $toolBody);
		$emailSubject       =  $templateBody->subject;
		return array('emailBody'=>$emailBody,'emailSubject'=>$emailSubject);
	} 
	
	//----------------------------------------------------------------------
  
   /*
	* @Description: This function is use to manage membership renew template
	* @return: array
	*/ 
  
	private function membershipRenewTemplate($membershipItem) {
		
		//membership management prepare email body and subject
		$whereCondi         =  array('purpose'=>'membershiprenew','active'=>1);
		$templateBody   =  getDataFromTabel('EmailTemplates','templates,subject',  $whereCondi, '','', '', 1 );
		$templateBody   =  $templateBody[0];
		if($membershipItem['pkgId'] == $this->config->item('package_1_year_id')) {
			$membership_type = $this->config->item('package_title_2'); 
		} elseif($membershipItem['pkgId'] == $this->config->item('package_3_year_id')) {
			$membership_type = $this->config->item('package_title_3'); 
		}

		$image_base_url     =  site_base_url().'images/email_images/';
		$crave_us           =  $this->config->item('crave_us');
		$invoice_url        =  base_url().'package/membershipinvoices';
		$facebook_url       =  $this->config->item('facebook_follow_url');
		$linkedin_url       =  $this->config->item('linkedin_follow_url');
		$toolBody           =  $templateBody->templates;
        $expiry_date        =  date('d F Y', strtotime("+12 months ".$membershipItem['createDate']));
		$membership_price   =  $this->config->item('toadCurrencySgine').''.$membershipItem['basePrice'];
		$getArray           =  array("{expiry_date}","{membership_type}","{membership_price}","{membership_action}","{crave_us}","{facebook_url}","{linkedin_url}","{purchase_page_url}" , "{image_base_url}");
		$replaceArray       =  array($expiry_date,$membership_type,$membership_price,$membership_action,$crave_us,$facebook_url,$linkedin_url,$invoice_url,$image_base_url);
		$emailBody          =  str_replace($getArray, $replaceArray, $toolBody);
		$emailSubject       =  $templateBody->subject;
		return array('emailBody'=>$emailBody,'emailSubject'=>$emailSubject);
	} 
	
	//----------------------------------------------------------------------
  
   /*
	* @Description: This function is use to manage membership Degrade template
	* @return: array
	*/ 
  
	private function membershipDegradeTemplate($membershipItem) {
		
		//membership management prepare email body and subject
		$whereCondi     =  array('purpose'=>'membershipdegrade','active'=>1);
		$templateBody   =  getDataFromTabel('EmailTemplates','templates,subject',  $whereCondi, '','', '', 1 );
		$templateBody   =  $templateBody[0];
		if($membershipItem['pkgId'] == $this->config->item('package_1_year_id')) {
			$membership_type = $this->config->item('package_title_1');  
		} elseif($membershipItem['pkgId'] == $this->config->item('package_3_year_id')) {
			$membership_type = $this->config->item('package_title_2'); 
		}

		$image_base_url     =  site_base_url().'images/email_images/';
		$crave_us           =  $this->config->item('crave_us');
		$invoice_url        =  base_url().'package/membershipinvoices';
		$facebook_url       =  $this->config->item('facebook_follow_url');
		$linkedin_url       =  $this->config->item('linkedin_follow_url');
		$toolBody           =  $templateBody->templates;
        $expiry_date        =  date('d F Y', strtotime("+12 months ".$membershipItem['createDate']));
		$membership_price   =  $this->config->item('toadCurrencySgine').''.$membershipItem['basePrice'];
		$getArray           =  array("{expiry_date}","{membership_type}","{membership_price}","{membership_action}","{crave_us}","{facebook_url}","{linkedin_url}","{purchase_page_url}" , "{image_base_url}");
		$replaceArray       =  array($expiry_date,$membership_type,$membership_price,$membership_action,$crave_us,$facebook_url,$linkedin_url,$invoice_url,$image_base_url);
		$emailBody          =  str_replace($getArray, $replaceArray, $toolBody);
		$emailSubject       =  $templateBody->subject;
		return array('emailBody'=>$emailBody,'emailSubject'=>$emailSubject);
	} 
  
  //----------------------------------------------------------------------
  
  /*
   * @Description: This function is use to tool purchase email and tmail notificatin
   * @return: array
   */ 
  
  private function _toolRefundEmailNTmail($membershipDetails,$membershipItemList){
	
	$membershipItem = $membershipItemList[0];
	/* get degrade session value */
	$isDegradePackage =  $this->session->userdata('isDegradePackage');
	if(!empty($isDegradePackage)) {
		
		// set email template for upgrade membership
		$emailData      = $this->membershipDegradeTemplate($membershipItem);
		$emailBody      =  $emailData['emailBody'];
		$emailSubject   =  $emailData['emailSubject'];
	} else {
	
		if(!empty($membershipItem)) {
			if($membershipItem['pkgId'] == $this->config->item('package_1_year_id')) {
				$membership_type = $this->config->item('package_title_2'); 
			} elseif($membershipItem['pkgId'] == $this->config->item('package_3_year_id')) {
				$membership_type = $this->config->item('package_title_3'); 
			}
		}
		//tool refund prepare email body and subject
		$whereCondi         =  array('purpose'=>'membershippackagerefund','active'=>1);
		$toolPurchaseBody   =  getDataFromTabel('EmailTemplates','templates,subject',  $whereCondi, '','', '', 1 );
		$toolPurchaseBody   =  $toolPurchaseBody[0];
		$site_url           =  base_url('');
		$site_base_url      =  site_base_url();
		$image_base_url     =  $site_base_url.'images/email_images/';
		$crave_us           =  $this->config->item('crave_us');
		$invoice_name       =  'Purchases';
		$invoice_url        =  base_url().'package/membershipinvoices';
		$dashboard_url      =  base_url('dashboard');
		$facebook_url       =  $this->config->item('facebook_follow_url');
		$linkedin_url       =  $this->config->item('linkedin_follow_url');
		$toolBody           =  $toolPurchaseBody->templates;
		$refund_cost        =  (isset($membershipItem['totalPrice']))?$membershipItem['totalPrice']:''; 
		$space              =  (isset($membershipItem['size']))?bytestoMB($membershipItem['size'],'mb'):''; // set space size
		$paypal_email       =  $membershipDetails['paypalEmail'];
		$mail_url           =  base_url_lang('dashboard/globalsettings/3');
		$getArray           =  array("{crave_us}","{facebook_url}","{linkedin_url}","{refund_cost}" ,"{memdership_type}" , "{space}", "{mail_url}" , "{paypal_email}" ,"{site_url}" , "{site_base_url}", "{image_base_url}","{purchase_page_url}");
		$replaceArray       =  array($crave_us,$facebook_url,$linkedin_url,$refund_cost, $membership_type, $space, $mail_url, $paypal_email, $site_url,$site_base_url,$image_base_url,$invoice_url);
		$emailBody          =  str_replace($getArray, $replaceArray, $toolBody);
		$emailSubject       =  $toolPurchaseBody->subject;
	}
    //send tool refund tmail notification
    $mailUrl            =  "https://www.paypal.com/home";
    $where              =  array('purpose'=>'tmailmembershiprefund','active'=>1);
    $refundTemplateRes  =  getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
    $refundTemplate     =  $refundTemplateRes[0]->templates;
    $searchArray        =  array("{refund_cost}","{memdership_type}","{space}","{paypal_email}","{mail_url}","{purchase_page_url}");
    $replaceArray       =  array($item_price,$item_name,$item_size,$paypal_email,$mailUrl,$invoice_url);
    $refurndTmailBody   =  str_replace($searchArray, $replaceArray, $refundTemplate);
    $refurndTmailSubject=  $refundTemplateRes[0]->subject;

    $senderId   = 0; //message send from toadsquare
    $recipients = $membershipDetails['tdsUid'];
    $this->tmail_messaging->send_new_message($senderId,$recipients, $refurndTmailSubject,$refurndTmailBody,'',9);
    
    return array('emailSubject'=>$emailSubject,'emailBody'=>$emailBody);
  }
  
  //-----------------------------------------------------------------------
  
  /*
   * @Description: This function is use to prepare invoice html
   * @return: html (string) 
   * 
   */ 
  
  private function _invoiceHtmlBody($membershipDetails,$membershipItemList){
      
    // order type 2 & 4 for refund container and refund memberhsip 
    if($membershipDetails['orderType']==2 || $membershipDetails['orderType']==4){
        $invoiceHeadingTitle   =   $this->lang->line('refund');
    }else{
        $invoiceHeadingTitle   =   $this->lang->line('invoice_heading');
    }

    //invoice logo & website url
    $logoImageUrl   =   site_base_url()."images/logo_12.png";// image base url
    $siteBaseUrl    =   site_base_url();// image base url

    //call method for invoice info boy details 
    $invoiceHeadingBody = $this->_invoiceHeaderInfoBody($membershipDetails);

    //call method for seller info body
    $sellerInfoBody = $this->_sellerInfoBody();

    //call method for buyer info body
    $buyerInfoBody = $this->_buyerInfoBody($membershipDetails);

    //call method for order item body
    $orderItemBody = $this->_orderItemBody($membershipDetails,$membershipItemList);

    //get membershiptemplate html from db
    $wherePurCondi          =   array('purpose'=>'membershiptemplate','active'=>1);
    $purchasedTemplateData  =   getDataFromTabel('EmailTemplates','templates,subject',  $wherePurCondi, '','', '', 1 );

    // get purchase subject and invoice tempalte html
    $purchasedSubject=$purchasedTemplateData[0]->subject;
    $purchasedTemplate=$purchasedTemplateData[0]->templates;	

    // prepare parse entity array
    $parseTemplateArray =  array("{site_base_url}","{heading_title}","{logo_image_url}","{header_info_body}","{seller_body}","{buyer_body}","{order_item_body}");

    //prepare data array
    $dataTemplateArray  =  array($siteBaseUrl,$invoiceHeadingTitle, $logoImageUrl,$invoiceHeadingBody,$sellerInfoBody,$buyerInfoBody,$orderItemBody);
        
    //replace parse array to data array    
    $invoiceHtmlBody        =  str_replace($parseTemplateArray, $dataTemplateArray, $purchasedTemplate);

    return $invoiceHtmlBody;
  }
  
  //-----------------------------------------------------------------------
  
  /*
   * @Description: This function is use to used prepare invoice header information 
   * body prepare
   * @return: html (string)
   * 
   */ 
  
  private function _invoiceHeaderInfoBody($membershipDetails){
    $sendData['membershipDetails'] = $membershipDetails; 
    return $this->load->view('invoice_view/header_info',$sendData,TRUE);
  }
  
  //-----------------------------------------------------------------------
  
  /*
   * @Description: This function is use to used prepare invoice seller body prepare
   * @return: html (string)
   */ 
  
  private function _sellerInfoBody(){
    return $this->load->view('invoice_view/seller_info',TRUE,TRUE);
  }
  
  //-----------------------------------------------------------------------
  
  /*
   * @Description: This function is use to used prepare invoice buyer body prepare
   * @return: html (string)
   */ 
  
  private function _buyerInfoBody($membershipDetails){
    
    $buyerInfo  = (array)  json_decode($membershipDetails['buyerInfo']);
    $sendData['buyerInfo'] = $buyerInfo; 
    return $this->load->view('invoice_view/buyer_info',$sendData,TRUE);
  }
  
  //-----------------------------------------------------------------------
  
  /*
   * @Description: This function is use to preapre order item listing body 
   * @return: html (string)
   */ 
  
  private function _orderItemBody($membershipDetails,$membershipItemList){
    
    $sendData['membershipDetails']  = $membershipDetails; 
    $sendData['membershipItemList'] = $membershipItemList; 
    $orderType = $membershipDetails['orderType'];
    
    if($orderType=="1" || $orderType=="2"){
        // order type 1/2 for container
        return $this->load->view('invoice_view/container_order_items',$sendData,TRUE);
    }elseif($orderType=="3" || $orderType=="4"){
        // order type 3/4 for membership
        return $this->load->view('invoice_view/membership_order_items',$sendData,TRUE);
    }
  }
  
  
  
  //-------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to open refund view popup
  * @return: void
  */  
  
  function refund(){
    $orderId         =  $this->input->get('val1');
    $userContainerId =  $this->input->get('val2');
    $sectionName     =  $this->input->get('val3');

    // get refund item price
    $price = $this->getRefundItemPrice($userContainerId,$orderId);	 
    
    // get membership order data
    $orderDetails=$this->model_common->getDataFromTabel('MembershipOrder', 'ordNumber,paypalEmail,custEmail',  array('orderId'=>$orderId,'isFree'=>'f'),'','','',1);	   

    $data['orderDetails']     =  $orderDetails[0];	
    $data['price']            =  $price;	
    $data['userContainerId']  =  $userContainerId;
    $data['currentOrderId']   =  $orderId;
    $data['sectionName']      =  $sectionName;	  
    $this->load->view('refundView',$data);
  }
  
  //-------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to get refund items price sum
  * @return: refund item price
  */  
    
  function getRefundItemPrice($userContainerId='',$orderId=0){
    $result = $this->model_membershipcart->getRefundItemPrice($userContainerId,$orderId);
    if(!empty($result->price)){
      return $result->price;
    }else{
      return 0;
    }
  }
 
  //-------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to save refund order and item data
  * @return: refundOrderId
  */ 
  
  public function saveRefundOrder($data){
    
    $refundTransactionId  =  $data['refundTransactionId']; 
    $orderId              =  $data['orderId'];
    $containerId          =  $data['userContainerId'];
    $amnt                 =  $data['amt'];
    $paypalInfo           =  $data['paypalJasonInfo'];

    //insert refund new order
    $refundOrderId = $this->insertRefundOrder($orderId,$containerId,$amnt,$refundTransactionId,$paypalInfo);	  

    // insert refund item order
    $this->insertRefundOrderItem($orderId,$containerId,$refundOrderId,$amnt);	  

    return $refundOrderId;
  }
  
  //-------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to save refund order
  * @return: refundOrderId
  */ 
  
  function insertRefundOrder($orderId,$containerId,$amnt,$refundTransactionId,$paypalInfo){

    $userId  =  $this->isLoginUser();
    $res     =  $this->model_common->getDataFromTabel('MembershipOrder', '*',  array('orderId'=>$orderId),'','','');
    
    if(!empty($res)){
      $res = $res[0];
      $insert['grandTotal'] = $res->grandTotal;
      $insert['totalTaxAmt'] = $res->totalTaxAmt;
      $insert['TotalPrice'] = $res->TotalPrice;
      $insert['paymentStatus'] = 't' ;
      $insert['tdsUid'] =  $userId;
      $insert['totalPaid'] =$amnt;
      $insert['custName'] = $res->custName;
      $insert['comments'] = 'Refund';
      $insert['custPhone'] =  '';
      $insert['custEmail'] =$res->custEmail;	
      $insert['buyerInfo'] =$res->buyerInfo;
      $insert['ordNumber'] =$refundTransactionId; 
      $insert['paypalTransectionInfo'] =$paypalInfo; 			
      $insert['taxPercent'] =$res->taxPercent;
      $insert['taxValue'] =$res->taxValue;
      $insert['orderType'] =2;
      $insert['paypalEmail'] =$res->paypalEmail;

      $this->db->insert('MembershipOrder', $insert);
      return $orderId =  $this->db->insert_id();
    }
  }
  
  //-------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to save refund order item
  * @return: void
  */ 
  
  function insertRefundOrderItem($orderId=0,$containerId=0,$currentOrderId=0,$amnt=0){
   
    $userId   =  $this->isLoginUser();		
    
    //get refund item size
    $refSize  =  $this->model_membershipcart->getRefundItemSize($containerId,$orderId);

    // get membership item data 
    $res      =  $this->model_common->getDataFromTabel('UserMembershipItem', '*',  array('orderId'=>$orderId,'userContainerId'=>$containerId,'parentContId'=>0),'','','');

    if(!empty($res)){  
      $res = $res[0];		  
      $cart['orderId'] = $currentOrderId;		
      $cart['tdsUid'] =  $userId;
      $cart['pkgId'] =  $res->pkgId;
      $cart['pkgRoleId'] =  $res->pkgRoleId;
      $cart['tsProductId'] =  $res->tsProductId ;		
      $cart['size'] =is_numeric($res->size)? $res->size:0;	
      $cart['totalPrice'] = $res->totalPrice ;
      $cart['userContainerId'] =$containerId;
      $cart['type'] =$res->type;
      $cart['taxPercent'] =$res->taxPercent;
      $cart['taxValue'] =$res->taxValue;
      $cart['EuVatIdentificationNumber'] =$res->EuVatIdentificationNumber;
      $cart['basePrice'] =$res->basePrice;			
      $cart['parentOrderId'] =$orderId;			
      
      //insert refund membership item data
      $this->db->insert('UserMembershipItem', $cart);
    }

    //get last inserted id as a parent item id
    $parentId   =  $this->db->insert_id();
    // get parent item data
    $cartItems  =  $this->model_common->getDataFromTabel('UserMembershipItem', '*',  array('orderId'=>$orderId,'userContainerId'=>$containerId,'parentContId'=>$res->memItemId),'','','');	

    if(!empty($cartItems)){
      foreach ($cartItems as $child){
        //defined parent item id
        $parentId = $parentId;

        $cartChild['orderId']           =  $currentOrderId;
        $cartChild['tdsUid']            =  $userId;
        $cartChild['pkgId']             =  $child->pkgId ;
        $cartChild['pkgRoleId']         =  $child->pkgRoleId;
        $cartChild['tsProductId']       =  $child->tsProductId ; ;
        $cartChild['parentContId']      =  $parentId;
        $cartChild['size']              =  is_numeric($child->size)? $child->size:0;
        $cartChild['totalPrice']        =  $child->totalPrice;
        $cartChild['type']              =  $child->type; 
        $cartChild['userContainerId']   =  $containerId;
        $cartChild['taxPercent']        =  $child->taxPercent;
        $cartChild['taxValue']          = $child->taxValue;
        $cartChild['EuVatIdentificationNumber']   =  $child->EuVatIdentificationNumber;
        $cartChild['basePrice']                   =  $child->basePrice;		
        $cartChild['parentOrderId']               =  $orderId;				
        $this->db->insert('UserMembershipItem', $cartChild);
      }
    }
  }
   
  //-------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to save refund membership order and item data
  * @return: refundOrderId
  */ 
  
  public function saverefundmemberhsip($data){
  
    $refundTransactionId  =  $data['refundTransactionId']; 
    $orderId              =  $data['orderId'];
    $amount               =  $data['amt'];
    $paypalInfo           =  $data['paypalJasonInfo'];

    //insert refund membership new order
    $refundOrderId = $this->_refundmembershiporderinsert($orderId,$amount,$refundTransactionId,$paypalInfo);	  

    // insert refund membership item order
    $this->_refundmembershipiteminsert($orderId,$refundOrderId,$amount);	  

    return $refundOrderId;
  }
  
  function test(){
			$orderDetails     =  $this->model_common->getDataFromTabel('MembershipOrder', '*',  array('orderId'=>'663'),'','','');
			
			echo "<pre>";
			print_r($orderDetails);
	}
  
  //-------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to save refund membership order
  * @return: orderId
  */ 
  
  private function _refundmembershiporderinsert($orderId,$amount,$refundTransactionId,$paypalInfo){

    $userId           =  $this->isLoginUser();
    $orderDetails     =  $this->model_common->getDataFromTabel('MembershipOrder', '*',  array('orderId'=>$orderId),'','','');
    
    if(!empty($orderDetails)){
      $orderDetails             =  $orderDetails[0];
      $insert['cartId']     	  =  '0';
      $insert['grandTotal']     =  $amount;
      $insert['totalTaxAmt']    =  '0';
      $insert['TotalPrice']     =  $amount;
      $insert['paymentStatus']  = 't' ;
      $insert['tdsUid']         =  $userId;
      $insert['totalPaid']      =  $amount;
      $insert['custName']       =  $orderDetails->custName;
      $insert['comments']       = 'Refund Membership';
      $insert['custPhone']      =  '';
      $insert['custEmail']      =  $orderDetails->custEmail;	
      $insert['buyerInfo']      =  $orderDetails->buyerInfo;
      $insert['ordNumber']      =  $refundTransactionId; 
      $insert['paypalTransectionInfo'] =  $paypalInfo; 			
      $insert['taxPercent']            =  '0';
      $insert['taxValue']              =  '0';
      $insert['orderType']             =  4;
      $insert['paypalEmail']           =  $orderDetails->paypalEmail;

      $this->db->insert('MembershipOrder', $insert);
      return $orderId =  $this->db->insert_id();
    }
  }
  
  //-------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to save refund order item
  * @return: void
  */ 
  
  private function _refundmembershipiteminsert($orderId=0,$currentOrderId=0,$amount=0){
   
    $userId   =  $this->isLoginUser();		
    
    // get membership item data 
    $membershipItemDetails      =  $this->model_common->getDataFromTabel('UserMembershipItem', '*',  array('orderId'=>$orderId),'','','');

    if(!empty($membershipItemDetails)){
      foreach ($membershipItemDetails as $membershipItem){
        $membershipItemInsert['orderId']           =  $currentOrderId;
        $membershipItemInsert['tdsUid']            =  $userId;
        $membershipItemInsert['pkgId']             =  $membershipItem->pkgId ;
        $membershipItemInsert['pkgRoleId']         =  $membershipItem->pkgRoleId;
        $membershipItemInsert['tsProductId']       =  $membershipItem->tsProductId ;
        $membershipItemInsert['parentContId']      =  '0';
        $membershipItemInsert['size']              =  $membershipItem->size;
        $membershipItemInsert['totalPrice']        =  $amount;
        $membershipItemInsert['type']              =  $this->config->item('membership_item_type_5'); 
        $membershipItemInsert['taxPercent']        =  '0';
        $membershipItemInsert['taxValue']          =  '0';
        $membershipItemInsert['EuVatIdentificationNumber']   =  $membershipItem->EuVatIdentificationNumber;
        $membershipItemInsert['basePrice']                   =  $amount;		
        $membershipItemInsert['parentOrderId']               =  $membershipItem->parentOrderId;				
        $this->db->insert('UserMembershipItem', $membershipItemInsert);
      }
    }
  }

  //-------------------------------------------------------------------------
  
 /*
  * @Description: This function is use to state list
  * @return: string 
  */   

  public function stateList() {
    $lang       =  lang();
    $countryId  =  $this->input->post('val1');
    $fieldName  =  $this->input->post('val2');
    $class      =  $this->input->post('val3');
    $showClass  =  ($class!='') ? $class : 'l12';
    $stateList  =  getStatesList($countryId,true);
    $html       =  form_dropdown($fieldName, $stateList, '','class="'.$showClass.'" ');
    $html      .=  "<script>selectBox();</script>";
    echo $html;
  }	
  
  //-------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to save degrade refund order and item data
  * @return: refundOrderId
  */ 
  
  public function saveRefundDegradeOrder($data) {
    
    $refundTransactionId  =  $data['refundTransactionId']; 
    $orderId              =  $data['orderId'];
    $containerId          =  $data['userContainerId'];
    $amnt                 =  $data['amt'];
    $paypalInfo           =  $data['paypalJasonInfo'];

    //insert refund new order
    $refundOrderId = $this->insertRefundDegradeOrder($orderId,$containerId,$amnt,$refundTransactionId,$paypalInfo);	  

    // insert refund item order
    $this->insertRefundDegradeOrderItem($orderId,$containerId,$refundOrderId,$amnt);	  

    return $refundOrderId;
  }
  
   //-------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to save degrade refund order
  * @return: refundOrderId
  */ 
  
  function insertRefundDegradeOrder($orderId,$containerId,$amnt,$refundTransactionId,$paypalInfo) {

    $userId  =  $this->isLoginUser();
    $res     =  $this->model_common->getDataFromTabel('MembershipOrder', '*',  array('orderId'=>$orderId),'','','');
    
    if(!empty($res)){
		$res = $res[0];
		$insert['grandTotal'] = $amnt;
		$insert['totalTaxAmt'] = '0';
		$insert['TotalPrice'] = $amnt;
		$insert['paymentStatus'] = 't' ;
		$insert['tdsUid'] =  $userId;
		$insert['totalPaid'] =$amnt;
		$insert['custName'] = $res->custName;
		$insert['comments'] = 'Refund Membership';
		$insert['custPhone'] =  '';
		$insert['custEmail'] =$res->custEmail;	
		$insert['buyerInfo'] =$res->buyerInfo;
		$insert['ordNumber'] =$refundTransactionId; 
		$insert['paypalTransectionInfo'] =$paypalInfo; 			
		$insert['taxPercent'] ='0';
		$insert['taxValue'] ='0';
		$insert['orderType'] = $this->config->item('membership_order_type_4');
		$insert['paypalEmail'] =$res->paypalEmail;

		$this->db->insert('MembershipOrder', $insert);
		return $orderId =  $this->db->insert_id();
    }
  }
  
  //-------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to save refund order item
  * @return: void
  */ 
  
  function insertRefundDegradeOrderItem($orderId=0,$containerId=0,$currentOrderId=0,$amnt=0) {
   
    $userId   =  $this->isLoginUser();		
    
    //get refund item size
    $refSize  =  $this->model_membershipcart->getRefundItemSize($containerId,$orderId);

    // get membership item data 
    $res      =  $this->model_common->getDataFromTabel('UserMembershipItem', '*',  array('orderId'=>$orderId,'userContainerId'=>$containerId,'parentContId'=>0),'','','');

    if(!empty($res)) {  
      $res = $res[0];		  
      $cart['orderId'] = $currentOrderId;		
      $cart['tdsUid'] =  $userId;
      $cart['pkgId'] =  $res->pkgId;
      $cart['pkgRoleId'] =  $res->pkgRoleId;
      $cart['tsProductId'] =  $res->tsProductId ;		
      $cart['size'] =is_numeric($res->size)? $res->size:0;	
      $cart['totalPrice'] = $amnt;
      $cart['userContainerId'] =$containerId;
      $cart['type'] = $this->config->item('membership_item_type_5');
      $cart['taxPercent'] ='0';
      $cart['taxValue'] ='0';
      $cart['EuVatIdentificationNumber'] =$res->EuVatIdentificationNumber;
      $cart['basePrice'] =$amnt;			
      $cart['parentOrderId'] =$orderId;			
      
      //insert refund membership item data
      $this->db->insert('UserMembershipItem', $cart);
    }

    //get last inserted id as a parent item id
    $parentId   =  $this->db->insert_id();
    // get parent item data
    $cartItems  =  $this->model_common->getDataFromTabel('UserMembershipItem', '*',  array('orderId'=>$orderId,'userContainerId'=>$containerId,'parentContId'=>$res->memItemId),'','','');	

    if(!empty($cartItems)) {
      foreach ($cartItems as $child) {
        //defined parent item id
        $parentId = $parentId;

        $cartChild['orderId']           =  $currentOrderId;
        $cartChild['tdsUid']            =  $userId;
        $cartChild['pkgId']             =  $child->pkgId ;
        $cartChild['pkgRoleId']         =  $child->pkgRoleId;
        $cartChild['tsProductId']       =  $child->tsProductId ; ;
        $cartChild['parentContId']      =  $parentId;
        $cartChild['size']              =  is_numeric($child->size)? $child->size:0;
        $cartChild['totalPrice']        =  $child->totalPrice;
        $cartChild['type']              =  $this->config->item('membership_item_type_5'); 
        $cartChild['userContainerId']   =  $containerId;
        $cartChild['taxPercent']        =  $child->taxPercent;
        $cartChild['taxValue']          = $child->taxValue;
        $cartChild['EuVatIdentificationNumber']   =  $child->EuVatIdentificationNumber;
        $cartChild['basePrice']                   =  $child->basePrice;		
        $cartChild['parentOrderId']               =  $orderId;				
        $this->db->insert('UserMembershipItem', $cartChild);
      }
    }
  }
  
	//-------------------------------------------------------------------------
  
   /*
	* @Description: This function is use to save tool in cart
	* @return: void
	*/  

	public function addMediaTool($prodId=''){				

		if (!empty($prodId)) {	

			$productDetailsList = array();
			$data = array();

			$loginuserId=$this->isloginUser();	
			$inserts = array('totalPrice'=>'0','totalTaxAmt'=>'0','tdsUid'=>$loginuserId);	

			$cartId=$this->session->userdata('currentCartId');
			
			if($cartId==''){
				$cartId = $this->model_membershipcart->addData($inserts);
			}
			$this->session->set_userdata('currentCartId',$cartId);	  
			$i=0;													
			$productDetailsList[$i] = $this->model_membershipcart->getProductDetails($prodId);					
			$productDetailsList[$i]['qty'] = 1;	

			$res = $this->model_membershipcart->getRoleId($productDetailsList[$i][0]->tsProductId);
			$pkgId  = (isset($res[0]['pkgId']) && ($res[0]['pkgId']!=''))?$res[0]['pkgId']: 0;
			$pkgRoleId = (isset($res[0]['pkgRoleId']) && ($res[0]['pkgRoleId']!=''))?$res[0]['pkgRoleId']: 0; 

			$insert['cartId'] = $cartId;
			$insert['tsProductId'] =  $productDetailsList[$i][0]->tsProductId;
			$insert['price'] =  $productDetailsList[$i][0]->price;
			$insert['size'] =  is_numeric($productDetailsList[$i][0]->size)? $productDetailsList[$i][0]->size:0;
			$insert['pkgId'] =  $pkgId;
			$insert['pkgRoleId'] =  $pkgRoleId;
			$insert['totalPrice'] =  $productDetailsList[$i][0]->price;								
			$this->model_membershipcart->addDataMem($insert);			
			//$data['productDetails']=$productDetailsList;
			//redirect(base_url(lang().'/media/membershipcart'));	
		} 
	}
	
	//----------------------------------------------------------------------
  
   /*
	* @description: This function is used to save media space order data
	* @access: publilc
	* @author: Tosif Qureshi
	* @param:string 
	*/ 
	 
	public function mediawizardordersave($getData="") {
		
		//call membership order save method
		$membershipOrderArray = $this->mediawizardorder($getData);
	  
		// set membership item require variable
		$orderId        =  $membershipOrderArray['orderId'];
		$cartId         =  $membershipOrderArray['cartId'];
		$userId         =  $membershipOrderArray['userId'];
		$paypalStatus   =  $membershipOrderArray['paypalStatus'];
	  
		//add renew membership item  
		$this->mediawizarditem($orderId,$cartId,$userId,$paypalStatus);	
		return $orderId;
	}	
	  
	//-----------------------------------------------------------------------------
  
   /*
	* @Description: This function is used to save media wizard order data 
	* @access: private
	* @author: Tosif Qureshi
	* @retrun: OrderId
	*/ 
  
	private function mediawizardorder($getData) {
    
		$userId  =  isLoginUser(); # get user id
		// get session media cart id
		$sessionCartId = $this->session->userdata('mediaCartId');
		// get session cart id
		$cartId = $this->session->userdata('cartId');
		if(!empty($cartId) && empty($sessionCartId)) {
			$sessionCartId = $cartId;
		}
		
		if(!empty($sessionCartId)) {
			$cartId =  $sessionCartId;
		} else {
			// get current cartId
			$cartId =  $getData['CUSTOM'];
		}
    
		// get temp membership cart tabel data
		$result = $this->model_common->getDataFromTabel('MembershipCart','*',  'cartId', $cartId,'', 'ASC', $limit=1 );
		
		// if empty then redirect to home page
		if(empty($result)) {
			redirect('home');
		} elseif(!empty($result)) {
			$result  = $result[0];
		}

		// get user billing information
		//$billingDetail = $this->model_membershipcart->getBillingDetails($userId);

		if(isset($result->billingdetails) && $result->billingdetails!='') {
			$billingdetails =  json_decode($result->billingdetails);
		} else {	  
			$billingdetails =  $this->model_membershipcart->getUserBillingDetails($userId);
		}
		$billingdetails   =  json_encode($billingdetails);

		$paypalStatus     =  '1';

		//vat percent applied
		$vatPercentApplied   =  $this->config->item('media_vat_percent');

		$cartTotal       =  (!empty($result->totalPrice)) ? $result->totalPrice:'0';
		$vatValAmount    =  (!empty($result->totalTaxAmt)) ? $result->totalTaxAmt:'0';
		$TotalPaid       =  number_format(($cartTotal),2);
		$resultUserName  =  $this->model_common->getDataFromTabel('UserProfile','firstName,lastName',  'tdsUid', $userId,'', 'ASC', $limit=1 );
		$userEmail       =  $this->model_common->getDataFromTabel('UserAuth','email',  'tdsUid', $userId,'', 'ASC', $limit=1 );
		if($resultUserName) {
			$userInfo = $resultUserName[0];
		}
		
		$userEmail = ($userEmail[0]->email!='') ? $userEmail[0]->email:'';

		$custName=$userInfo->firstName.' '.$userInfo->lastName;	

		$insert['cartId']         =  $cartId;
		$insert['grandTotal']     =  $cartTotal;
		$insert['totalTaxAmt']    =  number_format($vatValAmount,2);
		$insert['TotalPrice']     =  $cartTotal;
		$insert['paymentStatus']  =  $paypalStatus ;
		$insert['tdsUid']         =  $userId;
		$insert['totalPaid']      =  $TotalPaid;
		$insert['custName']       =  $custName;
		$insert['custPhone']      =  '';
		$insert['custEmail']      =  $userEmail;	
		$insert['buyerInfo']      =  $billingdetails;
		$insert['taxPercent']     =  $vatPercentApplied;
		$insert['taxValue']       =  number_format($vatValAmount,2);
		$insert['orderType']      =  $this->config->item('membership_order_type_1'); // membership  order type

		$this->db->insert('MembershipOrder', $insert);
		$orderId =  $this->db->insert_id();
		
		$membershipOrderArray =  array('orderId'=>$orderId,'cartId'=>$cartId,'userId'=>$userId,'paypalStatus'=>$paypalStatus);
	 
		return $membershipOrderArray;
	}
	
	//-------------------------------------------------------------------------
  
   /*
	* @description: This function is used to save media item
	* @access private
	* @author: Tosif Qureshi
	* @return array
	*/ 
  
	private function mediawizarditem($orderId,$cartId,$userId,$paypalStatus) {
    
		//get membership cart item 
		$membershipTempItemData = $this->model_common->getDataFromTabel('MembershipCartItem','*',  'cartId', $cartId,'', 'ASC');
		$userContainerId = 0;
		if(!empty($membershipTempItemData)) {
			$parentId = 0;
			foreach($membershipTempItemData as $membershipItem) {

				// vat percent for membership 
				$vatApplied  = $this->config->item('media_vat_percent');

				$cartItemData['orderId']                    =  $orderId;		
				$cartItemData['tdsUid']                     =  $userId;
				$cartItemData['pkgId']                      =  $membershipItem->pkgId;
				$cartItemData['pkgRoleId']                  =  $membershipItem->pkgRoleId;
				$cartItemData['tsProductId']                =  $membershipItem->tsProductId;		
				$cartItemData['size']                       =  $membershipItem->size;
				$cartItemData['totalPrice']                 =  $membershipItem->totalPrice;
				$cartItemData['userContainerId']            =  '0';
				$cartItemData['type']                       =  $membershipItem->type;
				$cartItemData['taxPercent']                 =  (!empty($membershipItem->taxAmt))?$vatApplied:'0';
				$cartItemData['taxValue']                   =  $membershipItem->taxAmt;
				$cartItemData['parentContId']               =  $parentId;
				$cartItemData['EuVatIdentificationNumber']  =  '0';
				$cartItemData['basePrice']                  =  number_format($membershipItem->price,2);
				
				//get user's media container id
				$userContainerId = $membershipItem->userContainerId;
				if(isset($userContainerId) && !empty($userContainerId)) {
					$cartItemData['userContainerId']    =   $userContainerId;
					// set media container id in session
					$this->session->set_userdata('mediaContainerId',$userContainerId);
				}
		 
				// insert data in user membership cart item
				$parentId   = $this->model_common->addDataIntoTabel('UserMembershipItem', $cartItemData);
				
				//unset old value array
				unset($cartItemData);
			}
			
			if($userContainerId == 0) {
				//add user selected container
				$this->mediawizardcontainer($userId,$orderId);
			}
		}
	}
	
	//----------------------------------------------------------------------

  /*
   * @access: private
   * @description: This function is used to manage media container 
   * @author: Tosif Qureshi
   * @return void
   */ 
  
	private function mediawizardcontainer($userId,$orderId) {
    
		//membership order item data
		$whereMembershipItem =  array('orderId' => $orderId, 'tdsUid'=>$userId, 'userContainerId'=>0, 'parentContId'=>0);
		$userMembershipItem  =  $this->model_common->getDataFromTabel('UserMembershipItem', '*',  $whereMembershipItem, '', $orderBy='memItemId','',1);
		if(!empty($userMembershipItem) && is_array($userMembershipItem)) {
			$userMembership = $userMembershipItem[0];
			
			// get media pakage section
			$wherePkgCondition = array('tsProductId' => $userMembership->tsProductId);	
			$pkgSectionData    = $this->model_common->getDataFromTabel('MasterTsProduct', '*',  $wherePkgCondition, '', $orderBy='tsProductId', $order='ASC', $limit=1);

			// set current date n time
			$currentDate	   =  currntDateTime();
			//set next year date
            $expiryDate = date('Y-m-d h:i:s', strtotime("+12 months ".$currentDate));
			
			//prepare array for add  container
			$containerData['tdsUid'] 		    =  $userId;
			$containerData['tsProductId']       =  $userMembership->tsProductId ; 
			$containerData['isSentExpiryMail']  =  'f'; 
			$containerData['isExpired']         =  'f'; 
			$containerData['duration']          =  (!empty($pkgSectionData[0]->duration))?$pkgSectionData[0]->duration:'12'; 
			$containerData['title'] 			=  (!empty($pkgSectionData[0]->title))?$pkgSectionData[0]->title:''; 
			$containerData['pkgId']             =  $userMembership->pkgId;
			$containerData['pkgSections'] 	    =  (!empty($pkgSectionData[0]->allowedSections))?$pkgSectionData[0]->allowedSections:'';	
			$containerData['containerSize']     =  $userMembership->size;
			$containerData['orderId']	        =  $userMembership->orderId;
			$containerData['orderitemid'] 	    =  $userMembership->memItemId;  
			$containerData['expiryDate'] 	    =  $expiryDate;  
			
			// add container data
			$mediaContainerId = $this->model_common->addDataIntoTabel('UserContainer',$containerData);
			// set media container id in session
			$this->session->set_userdata('mediaContainerId',$mediaContainerId);
		}
	}
  
	function sendTestEmail($transId=0) {
	  
		$this->email->from($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
		$this->email->to('tosifqureshi@cdnsol.com','lokendrameena@cdnsol.com');
		$this->email->subject('Seccess test Email '.$transId);
		$this->email->message('Hello');
		  
		if($this->email->send()){
			echo "Sent Message successfully";
		} else {
			echo "Error: <br/>";
			$msg=$this->email->print_debugger();
			echo $msg;
		}
	}
	
	//----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to manage membership cart under stage 1
	 * @return void
	 */ 
	public function managecart($entityId=0,$elementId=0) {
        
        if($elementId == 0 || $entityId == 0) {
			redirect('/home');
		}
        $this->userId = $this->isLoginUser();
		// get section data
		$sectionData = $this->getsectiondata($entityId,$elementId);

		$imagePath = (isset($sectionData['imagePath'])) ? $sectionData['imagePath'] : '';
		$userContainerId = (isset($sectionData['userContainerId'])) ? $sectionData['userContainerId'] : 0;

        //----- start manage data for edit project's add space 
         // set entity id in session for add space
        $this->session->set_userdata('addSpaceEntityId',$entityId);
        // set project id in session for add space
        $this->session->set_userdata('addSpaceProjectId',$elementId);
        // set user container id in session for add space
        $this->session->set_userdata('addSpaceContainerId',$userContainerId);
       
        //----- end managing data for add space 
        
		//get logged user subscription details
		$whereSubcrip    = array('tdsUid' => $this->userId);
		$subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', 'subscriptionType',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
		if(!empty($subcripDetails)) {
			$subscriptionType  = $subcripDetails[0]->subscriptionType;
		}
		// get media session cart id if exists
		$cartId = $this->session->userdata('cartId');
		$cartData = '';
		if(!empty($cartId)) {
			// get cart temp data
			$cartData = $this->model_common->getCurrentCartData($cartId);
		} 	
		
        // load industry typr lang file
        $this->load->language('media');
		$this->data['mediaCartData']     = $cartData;
		$this->data['subscriptionType']  = $subscriptionType;
        $this->data['innerPage']         = 'wizardform/membership_cart';
		$this->data['s1menu']            = 'TabbedPanelsTabSelected';
        $this->data['membership2menu']   = 'TabbedPanelsTabSelected';
        $this->data['entityId']          = $entityId;
        $this->data['elementId']         = $elementId;
        $this->data['imagePath']         = $imagePath;
        $this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
		$this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);
	}
    
    //----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to manage membership temp cart data
	 * @return string
	 */ 
    public function membershipcartpost() {
		
        // get membership form post values 
        $data = $this->input->post();
		// set default next step as blank
		$nextStep = 'home'; 
        if( !empty($data['entityId']) && $data['elementId']) {
			if($data['entityId'] == 86) {
				// set workprofile product id
				$data['tsProductId'] = $this->config->item('tsProductId_Workprofile');
			} else if($data['entityId'] == 93) {
				// set showcase product id
				$data['tsProductId'] = $this->config->item('tsProductId_ShowcaseHomepage');
			} else if($data['entityId'] == 97) {
				// set blog product id
				$data['tsProductId'] = $this->config->item('tsProductId_BlogShowcase');
			}
			
			// set cart values
			$cartValues  = $this->setcartvalues($data); 
			// get vat percentage
			$vatPercent  = $this->config->item('media_vat_percent');
			// set vat price of total 
			$vatPrice    = (($data['extraSpacePrice']*$vatPercent)/100);
			// set total price
			$totalPrice  = $vatPrice + $data['extraSpacePrice'];
			
			// insert data in  temp membership cart tabel
			$cartId = $this->addCartData($totalPrice,$cartValues['orderType'],$vatPrice);
		  
			
			if(isset($cartId) && !empty($cartId)) {
				// set cart id in session
				$this->session->set_userdata('cartId',$cartId); 
				// set default values as 0
				$pkgId = 0;	
				$containerId = 0;
				$parentCartItem = 0;
				
				// manage add space type if project id exists
				$addSpaceContainerId = $this->session->userdata('addSpaceContainerId'); 
				if(!empty($addSpaceContainerId) && $data['subscriptionType'] != 1 ) {
					$elementId   = $this->session->userdata('addSpaceProjectId'); 
					$entityId    = $data['entityId'];
					$containerId = $addSpaceContainerId;
				}
				
				// set vat price on extra space 
				$vatPrice    = (($data['cartTotalPrice']*$vatPercent)/100);
				// prepare membership cart item data
				$memItemInsert = array(
					'cartId'           => $cartId,
					'tsProductId'      => $cartValues['tsProductId'],
					'price'            => $data['extraSpacePrice'],
					'size'             => $cartValues['size'],
					'pkgId'            => $pkgId,
					'pkgRoleId'        => 0,
					'totalPrice'       => $data['extraSpacePrice'],
					'type'             => $cartValues['itemType'],
					'elementId'        => (isset($elementId))?$elementId:0,
					'entityId'         => (isset($entityId))?$entityId:0,
					'parentCartItemId' => $parentCartItem,
					'userContainerId'  => $containerId,
					);
				   
				// insert data in  temp membership cart item tabel
				$this->model_membershipcart->addDataMem($memItemInsert);

				$nextStep = 'membershipcart/billingdetails'; // set next step as billing page
			}
		}
        redirect($nextStep);
    }
    
     //----------------------------------------------------------------------

	/*
	 * @access: private
	 * @description: This function is used to add temp cart data
	 * @return int
	 */ 
    private function addCartData($cartTotalPrice,$orderType,$vatPrice) {
		
		//prepare cart insertion data
		$inserts = array(
			'totalPrice'  => $cartTotalPrice,
			'totalTaxAmt' => $vatPrice,
			'tdsUid'      => $this->userId,
			'orderType'   => $orderType
			);
        
        // insert data in  temp membership cart tabel
        $cartId = $this->model_membershipcart->addData($inserts);
        return $cartId; 
	}
    
    //----------------------------------------------------------------------

	/*
	 * @access: private
	 * @description: This function is used to set cart values as subscription 
	 * @return string
	 */ 
    private function setcartvalues($data) {
		
        // manage add space type if container id exists
        $addSpaceContainerId = $this->session->userdata('addSpaceContainerId'); 
        if(!empty($addSpaceContainerId)) {
            $itemType  = $this->config->item('membership_item_type_2'); // set add container space / membership space type
            $orderType = $this->config->item('membership_item_type_1'); // set add container space / membership space type
        }
        
		if($data['subscriptionType'] != 1) { // set values for paid user
		
			//$cartValues['parentContainerSize'] = mbToBytes($this->config->item('defaultUnitofStorageSpace_paidMember_GB'),'gb');
			$cartValues['parentContainerSize'] = 0;
			$cartValues['itemType']            = (isset($itemType))?$itemType:$this->config->item('membership_item_type_10'); // set type for paid member
			$cartValues['size']                = mbToBytes($data['extraspace'],'gb'); // set type for paid member
			$cartValues['orderType']           = (isset($orderType))?$orderType:$this->config->item('membership_order_type_3'); // set order type for paid member;
			$cartValues['tsProductId']         = $this->config->item('ts_product_id_paid_user'); // set ts product id 
			$cartValues['containerPrice']      = 0;
			
			
		} else { // set values for free user
		
			$cartValues['parentContainerSize'] = mbToBytes($this->config->item('defaultUnitofStorageSpace_freeMember_MB'),'kb');
			$cartValues['size']                = mbToBytes($data['extraspace'],'mb');  // convert mb unit to bytes
			$cartValues['itemType']            = (isset($itemType))?$itemType:$this->config->item('membership_item_type_2'); // set type for free member
			$cartValues['orderType']           = $this->config->item('membership_order_type_1'); // set order type for free member;
			//$cartValues['tsProductId']       = $this->config->item('ts_product_id_free_user'); // set ts product id
			$cartValues['tsProductId']         = $data['tsProductId'];
			// set container total price of item
			$containerPrice = $this->config->item('defaultPrice_per_unitofStorageSpace_freeMember_EURO');
			if(!empty($data['totalProductPrice'])) {
				$containerPrice = $data['totalProductPrice'];
			}
			$cartValues['containerPrice'] = $containerPrice;
		}
		return $cartValues;
	}
    
     //----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to manage billing information
	 * @return string
	 */ 
	public function billingdetails() {
		
		// get users profile details
		$userProfileData = $this->model_common->getUserProfileData($this->userId);
		$userProfileData =  (!empty($userProfileData[0]))?$userProfileData[0]:''; 
		$this->load->language('media');
		$this->data['userProfileData'] = $userProfileData; # set user profile data 
        $this->data['innerPage'] = 'wizardform/billing_details';
        $this->data['membership3menu'] = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
		$this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);
	}
    
    //----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to manage billing data 
	 * @return string
	 */ 
    public function billingdetailspost() {
		
		// get billing form post values 
		$billingData = $this->input->post();
		$nextStep = 'membershipcart/billingdetails'; // set default next step as blank
       
		if(!empty($billingData)) {
			
			if(isset($billingData['isSameAsSeller']) && !empty($billingData['isSameAsSeller'])) { 
				
				// set seller details as billing data
				$billing_firstName   = (!empty($billingData['firstName']))?$billingData['firstName']:'';
				$billing_lastName    = (!empty($billingData['lastName']))?$billingData['lastName']:'';
				$billing_companyName = (!empty($billingData['seller_companyName']))?$billingData['seller_companyName']:'';
				$billing_address1    = (!empty($billingData['seller_address1']))?$billingData['seller_address1']:'';
				$billing_address2    = (!empty($billingData['seller_address2']))?$billingData['seller_address2']:'';
				$billing_city        = (!empty($billingData['seller_city']))?$billingData['seller_city']:'';
				$billing_country     = (!empty($billingData['seller_country']))?$billingData['seller_country']:'';
				$billing_state       = (!empty($billingData['seller_state']))?$billingData['seller_state']:'';
				$billing_zip         = (!empty($billingData['seller_zip']))?$billingData['seller_zip']:'';
				$billing_email       = (!empty($billingData['seller_email']))?$billingData['seller_email']:'';
				$billing_phone       = (!empty($billingData['seller_phone']))?$billingData['seller_phone']:'';
				
			} else { 
				
				// set billing details
				$billing_firstName   = (!empty($billingData['firstName']))?$billingData['firstName']:'';
				$billing_lastName    = (!empty($billingData['lastName']))?$billingData['lastName']:'';
				$billing_companyName = (!empty($billingData['companyName']))?$billingData['companyName']:'';
				$billing_address1    = (!empty($billingData['addressLine1']))?$billingData['addressLine1']:'';
				$billing_address2    = (!empty($billingData['addressLine2']))?$billingData['addressLine2']:'';
				$billing_city        = (!empty($billingData['townOrCity']))?$billingData['townOrCity']:'';
				$billing_country     = (!empty($billingData['countriesList']))?$billingData['countriesList']:'';
				$billing_state       = (!empty($billingData['stateList']))?$billingData['stateList']:'';
				$billing_zip         = (!empty($billingData['zipCode']))?$billingData['zipCode']:'';
				$billing_email       = (!empty($billingData['email']))?$billingData['email']:'';
				$billing_phone       = (!empty($billingData['phoneNumber']))?$billingData['phoneNumber']:'';
			}
			
			// set billing data array 
			$billingDataArray = array(
				'tdsUid'              => $this->userId,
				'billing_firstName'   => $billing_firstName,
				'billing_lastName'    => $billing_lastName, 
				'billing_companyName' => $billing_companyName,
				'billing_address1'    => $billing_address1,
				'billing_address2'    => $billing_address2,
				'billing_city'        => $billing_city,
				'billing_country'     => $billing_country,
				'billing_state'       => $billing_state,
				'billing_zip'         => $billing_zip,
				'billing_email'       => $billing_email,
				'billing_phone'       => $billing_phone,
				);
			
			// get membership card from session
			$cartId = $this->session->userdata('cartId');
			
			if(!empty($cartId)) {
				// manage buyer's billing data log
				$nextStep = $this->updatebuyerdata($billingDataArray,$billingData,$cartId);
			}
		}
		
		redirect('membershipcart/'.$nextStep);
	}
    
    //----------------------------------------------------------------------

	/*
	 * @access: private
	 * @description: This function is used to update buyer billing data
	 * @return string
	 */ 
    private function updatebuyerdata($billingDataArray,$billingData,$cartId) {
		// add billing data in cart 
		$this->model_common->updateBillingData(array('billingdetails'=>json_encode($billingDataArray)), $cartId);
		// update or add buyer billing data for global setting
		if(isset($billingData['isSaveInBilling']) && !empty($billingData['isSaveInBilling'])) {
			// insert & udpate buyer data in user buyer table
			$buyerSettingData =  $this->model_common->getDataFromTabel('UserBuyerSettings', 'id',  array('tdsUid' => $this->userId),'','','',1);
			// push tax text value if exists
			if(!empty($billingData['otherAboutConsumptionTax'])) {
				$billingDataArray['otherAboutConsumptionTax'] = $billingData['otherAboutConsumptionTax'];
			}
			
			if(!empty($buyerSettingData)) {
				$buyerSettingData  =  $buyerSettingData[0];
				$buyerUserId       =  $buyerSettingData->id;
				// update buyer billing data
				$this->model_common->editDataFromTabel('UserBuyerSettings', $billingDataArray, 'id', $buyerUserId);
			} else {
				// add buyer billing data
				$this->model_common->addDataIntoTabel('UserBuyerSettings', $billingDataArray);
			}
			
		}
		$nextStep = 'purchasesummary'; // set next step as purchase summary
		return $nextStep;
	}
	
	  //----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to show purchase summary
	 * @return string
	 */ 
	public function purchasesummary() {
		// get membership card from session
		$cartId = $this->session->userdata('cartId');
		$this->load->language('media');
		$spaceSize = '';
		$spaceUnit = '';
		$spacePrice = 0;
		$containerPrice = 0;
		if(!empty($cartId)) {
			// get membership cart data
			$cartData =  $this->model_common->getDataFromTabel('MembershipCart', '*',  array('cartId' => $cartId),'','','',1);
			$buyerBillingData = '';
			if(!empty($cartData)) {
				$cartData = $cartData[0];
				// set buyers billing data of cart
				$buyerBillingData = json_decode($cartData->billingdetails);
				// get membership cart item data
				$cartMemItemData =  $this->model_common->getDataFromTabel('MembershipCartItem', '*',  array('cartId' => $cartId),'','cartItemId','DESC');
				
				if(!empty($cartMemItemData) && is_array($cartMemItemData)) {
					$cartItemData = $cartMemItemData[0]; // get cart space data
					//get logged user subscription details
					$whereSubcrip 		= array('tdsUid' => $this->userId);
					$subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', 'subscriptionType',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
					if(!empty($subcripDetails)) {
						$subscriptionType  = $subcripDetails[0]->subscriptionType; // set subscription type
						if($subscriptionType == 1) { //set space values for free type
							$spaceSize = bytestoMB($cartItemData->size,'mb');
							$spaceUnit = $this->lang->line('mb');
						} else { //set space values for paid type
							$spaceSize = bytestoMB($cartItemData->size,'gb');
							$spaceUnit = $this->lang->line('gb');
						}
						// set containers price if container exists
						if(isset($cartMemItemData[1]) && !empty($cartMemItemData[1])) {
							$containerPrice = $cartMemItemData[1]->totalPrice;
						}
					}	
					// set space price
					$spacePrice = $cartItemData->totalPrice;
				}
			}
		} else {
			redirect(base_url(lang().'/home'));
		}
		
		// get users seller details 
		$userSellerData = $this->model_common->getUserProfileData($this->userId);
		// set wizard section
		$this->session->set_userdata('wizardMediaSection',$this->router->fetch_method()); 
		// get vat percentage	
		$vatPercent  = $this->config->item('media_vat_percent');
		// calculate total price
		$totalPrice  = $spacePrice + $containerPrice;
		// set vat price of total 
		$vatPrice    = (($totalPrice*$vatPercent)/100);
		// get entity id
		$entityId = $this->session->userdata('addSpaceEntityId');
		// get element id
		$elementId = $this->session->userdata('addSpaceProjectId');
		// get section data
		$sectionData = $this->getsectiondata($entityId,$elementId);

		$imagePath = (isset($sectionData['imagePath'])) ? $sectionData['imagePath'] : '';
		
		 // get user's showcase details
        $showcaseRes = getUserShowcaseId($this->userId);
		$this->data['spaceSize']        = $spaceSize;
		$this->data['spaceUnit']        = $spaceUnit;	
		$this->data['spacePrice']       = $spacePrice;
		$this->data['totalPrice']       = $totalPrice;
		$this->data['vatPrice']         = $vatPrice;
		$this->data['containerPrice']   = $containerPrice;		
		$this->data['buyerSettingData'] = $buyerBillingData;	
		$this->data['userSellerData']   = (!empty($userSellerData[0]))?$userSellerData[0]:'';
		$this->data['imagePath']        = $imagePath;
        $this->data['innerPage']        = 'wizardform/purchase_summary';
        $this->data['membership4menu']  = 'TabbedPanelsTabSelected';
		$this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
		$this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);
		
	}

    /**
     * Get user's section image
     * @access: private
     * 
     */
     private function getsectiondata($entityId=0,$elementId=0) {
		 $returnData = array();
		 if($entityId == 86) { // get workprofile image
			// get workprofile data
			$workProfileDetails = $this->model_membershipcart->getWorkProfileDetails($elementId);
			if(!empty($workProfileDetails)) {
				$workProfileDetails = $workProfileDetails[0];
				//set image path
				$imagePath = (!empty($workProfileDetails->filePath) && !empty($workProfileDetails->fileName)) ? $workProfileDetails->filePath.$workProfileDetails->fileName : '';
				$userDefaultImage = $this->config->item('sectionIdImage32');
		 
				$workprofileThumbImage = addThumbFolder($imagePath,'_m');	
				$imagePath = getImage($workprofileThumbImage,$userDefaultImage);
				$returnData = array('userContainerId'=>$workProfileDetails->userContainerId,'imagePath'=>$imagePath);
			}
			
		} else if($entityId == 93) { // get showcase image
			$imagePath = $this->getshowcaseimage();
			
			$returnData = array('userContainerId'=>$workProfileDetails->userContainerId,'imagePath'=>$imagePath);
		} else if($entityId == 97) { // get blog image
			// get blog data
			$data = $this->model_membershipcart->getUserBlog($this->userId);
			if(!empty($data)) {
				$blogData = $data[0];
				$imagePath = getBlogImage($blogData,1,'_s');
				$returnData = array('userContainerId'=>$blogData->userContainerId,'imagePath'=>$imagePath);
			}
		}
		
		return $returnData;
	 }
	 
	//----------------------------------------------------------------------

	/*
	 * @access: private
	 * @description: This function is used to get showcase image
	 * @return string
	 */ 
     private function getshowcaseimage() {
		 
		// get user's showcase details
        $showcaseRes = getUserShowcaseId($this->userId);
		$userFolderName = LoginUserDetails('username');
		$profileJsImagePath = 'media/'.$userFolderName.'/profile_image/';	
		// set user profile image
		if(isset($showcaseRes->profileImageName) && $showcaseRes->profileImageName!='' && file_exists(ROOTPATH.$profileJsImagePath.$showcaseRes->profileImageName))
		{
			$files = glob($dataFormValue['profileJsImagePath'].'*'); // get all file names
			
			$currentProfileImage = $profileJsImagePath.$showcaseRes->profileImageName;
		}
		else
		{
			$stockImagePath = "images/stock_images/profile/";
			if(isset($showcaseRes->stockImageId) && $showcaseRes->stockImageId > 0)
			{ 	
				$stockImageName = getFieldValueFrmTable('stockFilename','StockImages','stockImgId',$showcaseRes->stockImageId);
				if(count($stockImageName[0])>0) 
					$CurrentStockFileName = $stockImagePath.$stockImageName[0]->stockFilename;
				else
					$CurrentStockFileName = $stockImagePath.'no.jpg';
					
				$currentProfileImage = $CurrentStockFileName;

		   } else { 
				$currentProfileImage = ($showcaseRes->enterprise=='t')?$this->config->item('defaultEnterpriseImg_152_210'):($showcaseRes->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_152_210'):$this->config->item('defaultCreativeImg_152_210'));
		  }
		}
		return $currentProfileImage;
	 }
	 
	  //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to show payment error view
     * @return void
     */ 
    
    public function paymenterror() {
		// load media language 
        $this->load->language('media');
        // manage payment error page display
        $this->data['innerPage']        = 'wizardform/payment_error';
        $this->data['membership5menu']  = 'TabbedPanelsTabSelected';
        $this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);
       
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to show payment success view
     * @return void
     */ 
    
    public function paymentsuccess() {
		// load media language 
        $this->load->language('media');
        // get media container id
        $addSpaceContainerId = $this->session->userdata('addSpaceContainerId');
        if(!empty($addSpaceContainerId)) {
             
            // set project id in session for add space
            $addSpaceProjectId  = $this->session->userdata('addSpaceProjectId');
			
            if(!empty($addSpaceProjectId)) {
                $projId = $addSpaceProjectId;
                // update space for free member
                $this->updatefreeaddpace();
                    
				// unset session values
				$this->session->unset_userdata('addSpaceProjectId');
				$this->session->unset_userdata('projectContainerId');
			}              

			$this->data['innerPage']           = 'wizardform/payment_success';
			$this->data['membership5menu']     = 'TabbedPanelsTabSelected';
			$this->data['successContent']      = $this->lang->line('successAddStorageSpace');
			$this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
			$this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);

        } else {
            redirect('home');
        }
    }
    
	//-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to get update ad space of project
     * @return void
     */ 
    private function updatefreeaddpace() {
        // get container id
        $addSpaceContainerId = $this->session->userdata('addSpaceContainerId');
        //get logged user subscription details
        $whereSubcrip    = array('tdsUid' => $this->userId);
        $subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', 'subscriptionType',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($subcripDetails) && !empty($addSpaceContainerId)) {
            $subscriptionType  = $subcripDetails[0]->subscriptionType; // set subscription type
            if( $subscriptionType == 1 ) { //set space values for free type
                // get item's space size  
                $itemMembershipRes = $this->model_media->getItemContainerSize($addSpaceContainerId);
                if(!empty($itemMembershipRes)) {
                    // add total space
                    $addSpace = intval($itemMembershipRes[0]->containerSize) + intval($itemMembershipRes[0]->size);
                    // update added space
                    $this->model_common->editDataFromTabel('UserContainer', array('containerSize'=>$addSpace), array('userContainerId' => $addSpaceContainerId));
                }
            }
        }
    }
	
} 
