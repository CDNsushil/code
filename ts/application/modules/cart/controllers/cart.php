<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cart extends MX_Controller {

    private $data   =  array();
    private $userId =  null;
   
    /*
    * construct: 
    */ 
    function __construct() {
        $load = array(
            'model'     => 'model_cart',
            'language' 	=> 'membershipcart',
            'library'   => 'pagination_new_ajax'
        );
        parent::__construct($load);
        $this->userId = isLoginUser();
    }

    //---------------------------------------------------------------------
    
    /*
    * @acces: public
    * @description: This method is show default mywishlist
    * @retun: void
    * @modified by: lokendra meena 
    */ 
    
    public function index(){
        $this->mywishlist(1);
    }
    
    //---------------------------------------------------------------------
    
    /*** 
     * written by Sushil Mishra 
     * Date 01-02-2013 
     * getProductInfo fucntion 
     * @access	public
     * @param	
     * @return	
     */
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
                    $title = 'projName as title, projCategory as projcategory';
                    
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
                
                
                default:
                    $isTableFound=false;
                break;			
            }
            
            if($isTableFound){
                $selectfields = $title.','.$description.','.$owner;
                if(isset($itemPrice) && $itemPrice != '' ){
                    $selectfields = $selectfields.','.$itemPrice;
                }		
                if(isset($quantity) && $quantity != '' ){
                    $selectfields = $selectfields.','.$quantity;
                }		
                $where = array($whereId=>$elementId);
                $cartDetails=$this->model_cart->getProductInfo($tableName,$selectfields,$where);
                
            }
        }
        return $cartDetails;
    }

    /*** 
     * written by Sushil Mishra 
     * Date 03-03-2013 
     * donate fucntion 
     * @access	public
     * @param	
     * @return	
     */
    
    /*
     * function donate(){
          
        $isValidItem=false;
        $userId = isLoginUser();	 
        
        $thirdPartyCartId = $this->crfeateSalesCustomersBasket();


        $projId=$this->input->post('projId');
        $sectionId=$this->input->post('sectionId');
        $entityId=$this->input->post('entityId');
        $elementId=$this->input->post('elementId');
        $currency=$this->input->post('currency');
        $purchaseType=$this->input->post('purchaseType');
        $price=$this->input->post('price');
        $price = (is_numeric($price) && $price > 0) ? $price : 0;
        $ownerId=$this->input->post('ownerId');
        $qty = (isset($qnty) && ($qnty > 0)) ? $qnty :1;
        $i=0;	 

        if($entityId >0 && $elementId > 0){					
            $cartDetails=$this->getProductInfo($entityId,$elementId,$purchaseType);
            if($cartDetails){
                    $isValidItem=true;
                    
                    $donationAmount = $price;					
                    
                    // CALCULATION BASED ON QUANTITY
                    
                    $shippingPrice = 0;						

                    // Consumption Tax & Price Calculation 
                    $consumptionTaxPer = $this->getConsumptionTax($entityId,$elementId,$cartDetails[0]->tdsUid);
                    if(!$consumptionTaxPer){
                        $consumptionTaxPer=0;
                    }
                    
                    $consumptionTaxName = $this->getTaxName($entityId,$elementId,$cartDetails[0]->tdsUid);
                    if(!$consumptionTaxName){
                        $consumptionTaxName='';
                    }
                                    
                    
                    
                    $productPrice = $this->getPriceInfo($donationAmount,$currency,$cartDetails[0]->tdsUid);
                    
                    // Toad Square Calculation
                    $tsCommissionPercent= $productPrice['commisionPercentage'];
                    $tsCommissionValue  = $productPrice['commisionOnPrice'];			
                    $tsVatPercent       = $productPrice['VATpercentage'];
                    $tsVatValue         = $productPrice['VATCharge'];
                    $tsGrossCommision	= $productPrice['totalCommision'];
                    
                    $itemValue = ($donationAmount -($tsCommissionValue + $tsVatValue))	;
                    
                    $userTax = (($itemValue*$consumptionTaxPer)/100);
                    
                    
                    $basePrie = ($itemValue-$userTax);
                    $dispatch = $itemValue;
                    
                    $userTax = number_format($userTax,2);
                    $basePrie = number_format($basePrie,2);
                    $itemValue = number_format($itemValue,2);
                    
                     $json = '';
                     $sellerInfo=$this->model_cart->getSellerDetails($cartDetails[0]->tdsUid);		 
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
                        
                                
                    $sellerId=$cartDetails[0]->tdsUid;
                                
                    $customerBasketItem = array(
                        'basketId' =>$thirdPartyCartId,
                        'entityId'=> $entityId,
                        'elementId' => $elementId,
                        'sectionId' => $sectionId,
                        'projId' => $projId,
                        'itemName' =>$cartDetails[0]->title,
                        'basketQty' =>$qty,
                        'itemValue' =>$itemValue,				
                        'basePrice' =>$basePrie,
                        'taxName' =>$consumptionTaxName,
                        'taxPercent' =>$consumptionTaxPer,
                        'taxValue' =>$userTax,
                        'shipping' =>$shippingPrice,
                        'tsCommissionPercent' =>$tsCommissionPercent,
                        'tsCommissionValue' => $tsCommissionValue,
                        'tsVatPercent'    => $tsVatPercent,
                        'tsVatValue' =>$tsVatValue,
                        'tsGrossCommision' => $tsGrossCommision,				
                        'dispatchPrice'=> $dispatch,
                        'purchaseType'=>$purchaseType,
                        'sellerId'       => $cartDetails[0]->tdsUid,
                        'sellerInfo'   => $json
                    );		  
                
                
                $res=$this->model_common->getDataFromTabel('SalesBasketItem', 'itemId,basketId',  array('entityId'=> $entityId,'elementId' => $elementId,'basketId' =>$thirdPartyCartId,'purchaseType'=>$purchaseType),'','','',1);			
                
                if(isset($res[0]->basketId) && $res[0]->basketId > 0){
                    $this->model_common->editDataFromTabel('SalesBasketItem', $customerBasketItem, 'itemId', $res[0]->itemId);
                }else{
                    
                    $invoiceId=$this->getInvoiceId($thirdPartyCartId,$sellerId);
                    if($invoiceId && strlen($invoiceId) > 5){
                        
                    }else{
                        $invoiceId = $this->createInvoiceId();
                    }
                    
                    $customerBasketItem['invoiceId'] =$invoiceId;
                    $this->model_common->addDataIntoTabel('SalesBasketItem', $customerBasketItem);	
                }
                redirect(base_url(lang().'/cart/confirmbilling/'.$purchaseType)); 
                
            }
        }
        if(!$isValidItem){
            $msg='selected Item is not available now. please try later.';
            set_global_messages($msg, $type='success', $is_multiple=true);
         
            if(isset($_SERVER['HTTP_REFERER'])){
                $redirect=$_SERVER['HTTP_REFERER'];
            }else{
                $redirect='home';
            }
            
            redirect($redirect);
        }
    }
    */
    
    //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to do donate button action
    * @return: void
    * @auther: lokendra meena 
    */
      
    function donate(){
          
        $isValidItem    =   false;
        $userId         =   isLoginUser(); 
       
        // get cart id for donation action
        $thirdPartyCartId = $this->crfeateSalesCustomersBasket();

        // get post data
        $projId         =   $this->input->post('projId');
        $sectionId      =   $this->input->post('sectionId');
        $entityId       =   $this->input->post('entityId');
        $elementId      =   $this->input->post('elementId');
        $currency       =   $this->input->post('currency');
        $purchaseType   =   $this->input->post('purchaseType');
        $price          =   $this->input->post('price');
        $price          =   (is_numeric($price) && $price > 0) ? $price : 0;
        $ownerId        =   $this->input->post('ownerId');
        $qty            =   (isset($qnty) && ($qnty > 0)) ? $qnty :1;
        $i              =   0;	 

        if($entityId >0 && $elementId > 0){					
            $cartDetails=$this->getProductInfo($entityId,$elementId,$purchaseType);
            if($cartDetails){
                    $isValidItem=true;
                    
                    $donationAmount = $price;					
                    
                    // CALCULATION BASED ON QUANTITY
                    
                    $shippingPrice = 0;						

                    /* Consumption Tax & Price Calculation */
                    $consumptionTaxPer = $this->getConsumptionTax($entityId,$elementId,$cartDetails[0]->tdsUid);
                    if(!$consumptionTaxPer){
                        $consumptionTaxPer=0;
                    }
                    
                    $consumptionTaxName = $this->getTaxName($entityId,$elementId,$cartDetails[0]->tdsUid);
                    if(!$consumptionTaxName){
                        $consumptionTaxName='';
                    }
                                    
                    
                    
                    $productPrice = $this->getPriceInfo($donationAmount,$currency,$cartDetails[0]->tdsUid);
                    
                    /* Toad Square Calculation */
                    $tsCommissionPercent= $productPrice['commisionPercentage'];
                    $tsCommissionValue  = $productPrice['commisionOnPrice'];			
                    $tsVatPercent       = $productPrice['VATpercentage'];
                    $tsVatValue         = $productPrice['VATCharge'];
                    $tsGrossCommision	= $productPrice['totalCommision'];
                    
                    $itemValue = ($donationAmount -($tsCommissionValue + $tsVatValue))	;
                    
                    $userTax = (($itemValue*$consumptionTaxPer)/100);
                    
                    
                    $basePrie = ($itemValue-$userTax);
                    $dispatch = $itemValue;
                    
                    $userTax = number_format($userTax,2);
                    $basePrie = number_format($basePrie,2);
                    $itemValue = number_format($itemValue,2);
                    
                     $json = '';
                     $sellerInfo=$this->model_cart->getSellerDetails($cartDetails[0]->tdsUid);		 
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
                        
                                
                    $sellerId=$cartDetails[0]->tdsUid;
                                
                    $customerBasketItem = array(
                        'basketId' =>$thirdPartyCartId,
                        'entityId'=> $entityId,
                        'elementId' => $elementId,
                        'sectionId' => $sectionId,
                        'projId' => $projId,
                        'itemName' =>$cartDetails[0]->title,
                        'basketQty' =>$qty,
                        'itemValue' =>$itemValue,				
                        'basePrice' =>$basePrie,
                        'taxName' =>$consumptionTaxName,
                        'taxPercent' =>$consumptionTaxPer,
                        'taxValue' =>$userTax,
                        'shipping' =>$shippingPrice,
                        'tsCommissionPercent' =>$tsCommissionPercent,
                        'tsCommissionValue' => $tsCommissionValue,
                        'tsVatPercent'    => $tsVatPercent,
                        'tsVatValue' =>$tsVatValue,
                        'tsGrossCommision' => $tsGrossCommision,				
                        'dispatchPrice'=> $dispatch,
                        'purchaseType'=>$purchaseType,
                        'sellerId'       => $cartDetails[0]->tdsUid,
                        'sellerInfo'   => $json
                    );		  
                
                
                $res=$this->model_common->getDataFromTabel('SalesBasketItem', 'itemId,basketId',  array('entityId'=> $entityId,'elementId' => $elementId,'basketId' =>$thirdPartyCartId,'purchaseType'=>$purchaseType),'','','',1);			
                
                if(isset($res[0]->basketId) && $res[0]->basketId > 0){
                    $this->model_common->editDataFromTabel('SalesBasketItem', $customerBasketItem, 'itemId', $res[0]->itemId);
                }else{
                    
                    $invoiceId=$this->getInvoiceId($thirdPartyCartId,$sellerId);
                    if($invoiceId && strlen($invoiceId) > 5){
                        
                    }else{
                        $invoiceId = $this->createInvoiceId();
                    }
                    
                    $customerBasketItem['invoiceId'] =$invoiceId;
                    $this->model_common->addDataIntoTabel('SalesBasketItem', $customerBasketItem);	
                }
                redirect(base_url(lang().'/cart/shoppingcartbilling/'.$purchaseType)); 
                
            }
        }
        if(!$isValidItem){
            $msg='selected Item is not available now. please try later.';
            set_global_messages($msg, $type='success', $is_multiple=true);
         
            if(isset($_SERVER['HTTP_REFERER'])){
                $redirect=$_SERVER['HTTP_REFERER'];
            }else{
                $redirect='home';
            }
            
            redirect($redirect);
        }
    }
    
    //----------------------------------------------------------------------
    
    
    function getInvoiceId($basketId=0,$sellerId=0){
        $invoiceId=false;
        if($basketId > 0 && $sellerId > 0){
            $res=$this->model_common->getDataFromTabel('SalesBasketItem', 'invoiceId',  array('basketId' =>$basketId,'sellerId'=>$sellerId),'','','',1);	
            if(isset($res[0]->invoiceId)){
                $invoiceId=$res[0]->invoiceId;
            }
        }
        return $invoiceId;
    }
    
    /*** 
     * written by Sushil Mishra 
     * Date 01-03-2013 
     * donate fucntion 
     * @access	public
     * @param	
     * @return	
     */
     
    function getTicketInfo ($TicketId=0){
        //$type == >0:free, 1:sell, 2:earlyBird
        $TicketDetails=false;
        if(is_numeric($TicketId) && $TicketId > 0){
            $TicketDetails=$this->model_cart->getTicketInfo($TicketId);
        }
        return $TicketDetails;
    }
     
    function buyTickets (){
        $ticketDetails=$_POST['ticketDetails'];
        $ticketDetails=trim($ticketDetails);
        $isValidItem=false;
        if(strlen($ticketDetails) > 4){
            
            $userId = isLoginUser();	 
            
            $thirdPartyCartId = $this->crfeateSalesCustomersBasket();
            
            $td=json_decode($ticketDetails);
            
            if(is_array($td) && count($td) >0){
                foreach($td as $k=>$data){
                    if(!isset($data->eor) && isset($data->entityId) && ($data->entityId > 0) && isset($data->TicketId) && ($data->TicketId > 0)){
                        
                        $projId=$data->eventORlaunchId;
                        
                        $SessionId=$data->SessionId;
                        $entityIdSession=getMasterTableRecord('EventSessions');
                        $sellType=$data->type; //0:free, 1:sell, 2:earlyBird
                        
                        $entityIdPE=$data->entityId;
                        
                        $sectionId=$data->sectionId;
                        $entityId=getMasterTableRecord('Tickets');
                        $elementId=$data->TicketId;
                        
                        $currency=$data->seller_currency;
                        $ownerId=$data->ownerId;
                        $qnty=$data->qty;
                        $qty = (isset($qnty) && ($qnty > 0)) ? $qnty :1;
                        $purchaseType=5;
                        
                        $eventDetils=$this->getProductInfo($entityIdPE,$projId,$purchaseType); 
                        $TicketDetails=$this->getTicketInfo($elementId); 
                        
                        $isFree=0;
                        
                        if($eventDetils && $TicketDetails){
                                
                                $eventDetils=$eventDetils[0];
                                $TicketDetails=$TicketDetails[0];
                                
                                if($TicketDetails->eventSellstatus=='t'){
                                    if($TicketDetails->earlyBirdStatus=='t'){
                                        
                                        $currentDateTime= currntDateTime('y-m-d');
                                        if(isset($TicketDetails->earybirdstartdate) && (strtotime($TicketDetails->earybirdstartdate) > strtotime($currentDateTime)) ){
                                            $price = $TicketDetails->earybirdprice;
                                        }else{
                                            $price = $TicketDetails->Price;
                                        }
                                        
                                    }else{
                                        $price = $TicketDetails->Price;
                                    }
                                    
                                }else{
                                    $price = 0;
                                    $isFree=1;
                                }
                                
                                $price=(is_numeric($price) && ($price))?$price:0;
                                
                                if($isFree == 0 && $price==0){
                                    continue;
                                }
                                
                                $isValidItem=true;
                                
                                
                                $shippingPrice = 0;
                                
                                
                                $basePrice = $price;					
                                
                                
                                // CALCULATION BASED ON QUANTITY
                                $itemValue = $basePrice * $qty	;
                                $shippingPrice = 0;							

                                /* Consumption Tax & Price Calculation */
                                $consumptionTaxPer = $this->getConsumptionTax($entityIdSession,$SessionId,$eventDetils->tdsUid);
                                if(!$consumptionTaxPer){
                                    $consumptionTaxPer=0;
                                }
                                
                                $consumptionTaxName = $this->getTaxName($entityIdSession,$SessionId,$eventDetils->tdsUid);
                                if(!$consumptionTaxName){
                                    $consumptionTaxName='';
                                }
                                                
                                $vatPrice = ($itemValue*$consumptionTaxPer)/100;				
                                $finalPrice  =  $itemValue + $shippingPrice + $vatPrice ;							
                                
                                $productPrice = $this->getPriceInfo( $itemValue,$currency,$eventDetils->tdsUid);
                                
                                $displayPrice = $productPrice['displayPrice'];
                                
                                /* Toad Square Calculation */
                                $tsCommissionPercent= $productPrice['commisionPercentage'];
                                $tsCommissionValue  = $productPrice['commisionOnPrice'];			
                                $tsVatPercent       = $productPrice['VATpercentage'];
                                $tsVatValue         = $productPrice['VATCharge'];
                                $tsGrossCommision	= $productPrice['totalCommision'];
                                
                                 $json = '';
                                 //$sellerInfo=$this->model_cart->getSellerDetails($eventDetils->tdsUid);		 
                                 
                                 if($isFree){ 
                                   $sellerInfo=$this->model_cart->getSellerDetailsTicket($eventDetils->tdsUid);		 
                                 }else{
                                   $sellerInfo=$this->model_cart->getSellerDetails($eventDetils->tdsUid);
                                 }
                                 
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
                                            'ticketcategory' => $TicketDetails->ticketcategory,
                                            'price' => $TicketDetails->Price,
                                            'earybirddate' => $TicketDetails->earybirdstartdate,
                                            'earybirdprice' => $TicketDetails->earybirdprice,
                                            'eventSellstatus' => $TicketDetails->eventSellstatus,
                                            'earlyBirdStatus' => $TicketDetails->earlyBirdStatus,
                                            'entityIdPE' => $entityIdPE,
                                            'eventORlaunchId' => $projId,
                                            'SessionId' => $SessionId,
                                            'TicketId' => $elementId,
                                            'isFree' => $isFree
                                        );
                                        
                                        $json = json_encode($UserShippingJson);   
                                    }
                                    
                                $sellerId = $eventDetils->tdsUid;			
                                            
                                $customerBasketItem = array(
                                'basketId' =>$thirdPartyCartId,
                                'entityId'=> $entityId,
                                'elementId' => $elementId,
                                'sectionId' => $sectionId,
                                'projId' => $projId,
                                'itemName' =>$eventDetils->title,
                                'basketQty' =>$qty,
                                'itemValue' =>$itemValue,				
                                'basePrice' => $basePrice,
                                'taxName' =>$consumptionTaxName,
                                'taxPercent' =>$consumptionTaxPer,
                                'taxValue' =>$vatPrice,
                                'shipping' =>$shippingPrice,
                                'tsCommissionPercent' =>$tsCommissionPercent,
                                'tsCommissionValue' => $tsCommissionValue,
                                'tsVatPercent'    => $tsVatPercent,
                                'tsVatValue' =>$tsVatValue,
                                'tsGrossCommision' => $tsGrossCommision,				
                                'dispatchPrice'=>$finalPrice,
                                'purchaseType'=>$purchaseType,
                                'sellerId'       => $sellerId,
                                'sellerInfo'   => $json
                              );	
                             
                            $res=$this->model_common->getDataFromTabel('SalesBasketItem', 'itemId,basketId',  array('entityId'=> $entityId,'elementId' => $elementId,'basketId' =>$thirdPartyCartId,'purchaseType'=>$purchaseType),'','','',1);			
                            if(isset($res[0]->basketId) && $res[0]->basketId > 0){
                                $this->model_common->editDataFromTabel('SalesBasketItem', $customerBasketItem, 'itemId', $res[0]->itemId);
                            }else{
                                $invoiceId=$this->getInvoiceId($thirdPartyCartId,$sellerId);
                                if($invoiceId && strlen($invoiceId) > 5){
                                    
                                }else{
                                    $invoiceId = $this->createInvoiceId();
                                }
                                
                                $customerBasketItem['invoiceId'] =$invoiceId;
                                 
                                $this->model_common->addDataIntoTabel('SalesBasketItem', $customerBasketItem);	
                            }
                            
                        }
                    }
                }
            }
            
        }
        if(!$isValidItem){
            $msg='selected Item is not available now. please try later.';
            set_global_messages($msg, $type='success', $is_multiple=true);
         
            if(isset($_SERVER['HTTP_REFERER'])){
                $redirect=$_SERVER['HTTP_REFERER'];
            }else{
                $redirect='home';
            }
            redirect($redirect);
        }else{
            redirect(base_url(lang().'/cart/confirmbilling/'.$purchaseType)); 
        }
    }
    
    
    /*
     * date: 27-Aug-2013
     * details: Buy Free Session Ticket(s)
     * access: public
     * author: Lokendra Meena
     */ 
    
    function buyFreeTickets (){
        $ticketDetails=$_POST['ticketDetails'];
        $ticketDetails=trim($ticketDetails);
        $isValidItem=false;
        if(strlen($ticketDetails) > 4){
            
             
            $data=json_decode($ticketDetails);
        
            if(!empty($data)){
            
                if(!isset($data->eor) && isset($data->entityId) && ($data->entityId > 0) && isset($data->TicketId) && ($data->TicketId > 0)){
                    
                    $projId=$data->eventORlaunchId;
                    $userId = $data->LoggedInUserId;	
                    $SessionId=$data->SessionId;
                    $entityIdSession=getMasterTableRecord('EventSessions');
                    $sellType=$data->type; //0:free, 1:sell, 2:earlyBird
                    
                    $entityIdPE=$data->entityId;
                    
                    $sectionId=$data->sectionId;
                    $entityId=getMasterTableRecord('Tickets');
                    $elementId=$data->TicketId;
                    
                    $currency=$data->seller_currency;
                    $ownerId=$data->ownerId;
                    $qnty=$data->qty;
                    $qty = (isset($qnty) && ($qnty > 0)) ? $qnty :1;
                    $purchaseType=5;
                    
                    $eventDetils=$this->getProductInfo($entityIdPE,$projId,$purchaseType); 
                    $TicketDetails=$this->getTicketInfo($elementId); 
                    
                    if($eventDetils && $TicketDetails){
                        
                        $eventDetils=$eventDetils[0];
                        $TicketDetails=$TicketDetails[0];
                        $price = 0;
                        $isFree=1;
                        $json = '';
                        $TicketTransectionLogId='';
                        $salesItemId='';
                        $orderId=''; 
                         
                        $sellerInfo=$this->model_cart->getSellerDetailsTicket($eventDetils->tdsUid);		 
                         
                        //Prepare seller info json 
                         
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
                                    'ticketcategory' => $TicketDetails->ticketcategory,
                                    'price' => $TicketDetails->Price,
                                    'earybirddate' => $TicketDetails->earybirdstartdate,
                                    'earybirdprice' => $TicketDetails->earybirdprice,
                                    'eventSellstatus' => $TicketDetails->eventSellstatus,
                                    'earlyBirdStatus' => $TicketDetails->earlyBirdStatus,
                                    'entityIdPE' => $entityIdPE,
                                    'eventORlaunchId' => $projId,
                                    'SessionId' => $SessionId,
                                    'TicketId' => $elementId,
                                    'isFree' => $isFree
                                );
                                
                                $json = json_encode($UserShippingJson);   
                            }
                            
                            $getUserDetails = $this->model_common->getUserDetails($userId); // get loggedIn user details
                            $getUserDetails= $getUserDetails[0];
                            $trackingId = $this->createRandomNo();
                            
                            //--------------Prepare data for sales order table------------//
                            
                            $ordNumber = $this->createRanOrderNo();
                            $insert['ordNumber'] =$ordNumber;			
                            $insert['ordStatus'] =1;						
                            $insert['itemCount'] = $qty;
                            $insert['customerUid'] = $userId;
                            $insert['custName'] = $getUserDetails->firstName.' '.$getUserDetails->lastName;
                            $insert['custEmail'] = $getUserDetails->email;
                            $insert['custCountry'] =$getUserDetails->countryName;
                            $insert['deliveryName'] = $getUserDetails->firstName.' '.$getUserDetails->lastName;
                            $insert['payment_method'] = 'none';	
                            $insert['grandTotal'] = 0;	
                            $insert['trackingId'] = $trackingId;

                            //-------------Insert Data In Sales Order Table-------------//
                            
                            if(is_array($insert) && count($insert) > 0){
                                $this->db->insert('SalesOrder', $insert);
                                $orderId =  $this->db->insert_id();
                            }
                            
                            //-----------Prepare data for sale order item table ---------//
                        
                            $invoiceId = $this->createInvoiceId();
                            $recvId = $this->createRandomNo();
                            $sellerId = $eventDetils->tdsUid;	
                            $insertSalesOrderItem = array(
                                'ordId' =>$orderId,
                                'entityId'=> $entityId,
                                'elementId' => $elementId,
                                'sectionId' => $sectionId,
                                'purchaseType' => $purchaseType,
                                'itemQty' =>$qty,
                                'itemName' =>$eventDetils->title,
                                'sellerId'     => $sellerId,
                                'sellerInfo'   => $json,	
                                'transactionId' => $transId,
                                'invoiceId'	  =>  $invoiceId,
                                'projId'      => $projId,
                                'receiverTransactionId' => $recvId
                            );	
                        
                        
                            //-------------Insert Data In Sales Order Item Table-------------//
                            if(is_array($insertSalesOrderItem) && count($insertSalesOrderItem) > 0){
                                $this->db->insert('SalesOrderItem', $insertSalesOrderItem);	
                                $salesItemId =  $this->db->insert_id();
                            }
                            
                    
                            //------------PrePare & Insert Receiver Transaction Id----//
                            
                            /*$invoiceInsert['ordId'] = $orderId;	
                            $invoiceInsert['receiverTransactionId'] =$recvId;
                            $this->db->insert('SalesOrderInvoice', $invoiceInsert); */
                            
                            //-------------prepare data transaction log -----------//
                            $TicketTransectionLog=array();
                            $ticketNumber=getTicketNumber();
                            $ticketInfo=$this->getSessionDetails($entityIdPE,$projId,$SessionId);
                            
                                for($k=1; $k<=$qty; $k++){
                                $ticketNumber=($ticketNumber+1);
                                $ticketNumber=getTicketNumberAsString($ticketNumber);
                                $TicketTransectionLog[] = array(
                                    'entityId' =>$entityIdPE,
                                    'projectId'=> $projId,
                                    'sessionId' => $SessionId,
                                    'ticketId' => $elementId,
                                    'invoiceId' => $invoiceId,
                                    'userId' => $userId,
                                    'category' => $TicketDetails->ticketcategory,
                                    'userName' => $getUserDetails->firstName.' '.$getUserDetails->lastName,
                                    'ticketNumber' => $ticketNumber,
                                    'ownerId' => $sellerId,
                                    'ticketInfo' => $ticketInfo
                                );
                            }
                        
                        //------------insert data in ticket transaction log table---------//
                        if(is_array($TicketTransectionLog) && count($TicketTransectionLog) > 0){
                            $TicketTransectionLogId = $this->model_common->insertBatch('TicketTransectionLog',$TicketTransectionLog);
                        }
                        
                        //----------check inserted data id--------//	
                        if($TicketTransectionLogId > 0 && $salesItemId > 0 && $orderId > 0){
                            // send email ticket to Buyer 
                            Modules::run("payment/invoiceSendToEmail",$orderId);
                            $isValidItem=true;
                            $msg='Ticket purchase successfully.';
                            set_global_messages($msg, $type='success');
                            $returnData=array('msg'=>$msg,'success'=>'1');
                            echo json_encode($returnData);
                        }else{
                            $msg='Ticket not purchase successfully.';
                            set_global_messages($msg, $type='success');
                            $returnData=array('msg'=>$msg,'success'=>'0');
                            echo json_encode($returnData);
                        }
                    }
                }
            }
        }
        //------if ticket information is wrong------//
        if(!$isValidItem){
            $msg='Wrong ticket information.';
            set_global_messages($msg, $type='success');
            $returnData=array('msg'=>$msg,'success'=>'0');
            echo json_encode($returnData);
        }
        
    }
    
    //-------------------------------------------------------------------------
    
    /*** 
     * commented by lokendra meena
     * date: 25-nov-2014
     */  
    /*function buynow(){
          
        $isValidItem=false;
        $userId = isLoginUser();	 
        
        $thirdPartyCartId = $this->crfeateSalesCustomersBasket();

        $projId=$this->input->post('projId');
        $sectionId=$this->input->post('sectionId');
        $entityId=$this->input->post('entityId');
        $elementId=$this->input->post('elementId');
        $currency=$this->input->post('currency');
        $purchaseType=$this->input->post('purchaseType');
        $price=$this->input->post('price');
        $ownerId=$this->input->post('ownerId');
        $qnty=$this->input->post('qnty');
        $qty = (isset($qnty) && ($qnty > 0)) ? $qnty :1;
         
        
        $i=0;	 

        if($entityId >0 && $elementId > 0){					
            $cartDetails=$this->getProductInfo($entityId,$elementId,$purchaseType);
            if($cartDetails){
                   $sendpaypal= 't';	
                    $isValidItem=true;
                    if($purchaseType==1){				
                        $shippingPrice =  $this->getProductShipping($entityId,$elementId);
                        if($shippingPrice==0){
                                    $sendpaypal='f'; // if shipping 0 & type product not send to paypal 							
                                    }
                    }else{
                        $shippingPrice = 0;
                    }
                    
                        
                    $basePrice = (isset($cartDetails[0]->price) && $cartDetails[0]->price > 0) ? $cartDetails[0]->price : 0;					
            
                    //Manage cart pricing for auction
                    
                    $sellType = $this->input->post('sellType'); //Set sell type
                    //Manage base price if sell type is auction
                    if(isset($sellType) && !empty($sellType)) {
                        $productPrice = $this->getPriceInfo($price,$currency,$cartDetails[0]->tdsUid); //get product info
                        $basePrice    = $price - $productPrice['totalCommision']; 
                        $isAuction = true;
                    } else {
                        $isAuction = false;
                    }
                    
                    //Manage cart pricing for auction
                    
                    // CALCULATION BASED ON QUANTITY
                    $itemValue = $basePrice * $qty	;
                    $shippingPrice = $shippingPrice * $qty;							

                    // Consumption Tax & Price Calculation 
                    $consumptionTaxPer = $this->getConsumptionTax($entityId,$elementId,$cartDetails[0]->tdsUid);
                    if(!$consumptionTaxPer){
                        $consumptionTaxPer=0;
                    }
                    
                    $consumptionTaxName = $this->getTaxName($entityId,$elementId,$cartDetails[0]->tdsUid);
                    if(!$consumptionTaxName){
                        $consumptionTaxName='';
                    }
                                    
                    $vatPrice = ($itemValue*$consumptionTaxPer)/100;				
                    $finalPrice  =  $itemValue + $shippingPrice + $vatPrice ;							
                    
                    if($isAuction==false) {
                        $productPrice = $this->getPriceInfo($itemValue,$currency,$cartDetails[0]->tdsUid);
                    }
                    //echo "<pre>";
                    //print_r($productPrice);
                    $displayPrice = $productPrice['displayPrice'];
                    
                    // Toad Square Calculation 
                    $tsCommissionPercent= $productPrice['commisionPercentage'];
                    $tsCommissionValue  = $productPrice['commisionOnPrice'];			
                    $tsVatPercent       = $productPrice['VATpercentage'];
                    $tsVatValue         = $productPrice['VATCharge'];
                    $tsGrossCommision	= $productPrice['totalCommision'];
                    
                     $json = '';
                     $sellerInfo=$this->model_cart->getSellerDetails($cartDetails[0]->tdsUid);		 
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
                        
                    $sellerId = $cartDetails[0]->tdsUid;			
                                
                    $customerBasketItem = array(
                    'basketId' =>$thirdPartyCartId,
                    'entityId'=> $entityId,
                    'elementId' => $elementId,
                    'sectionId' => $sectionId,
                    'projId' => $projId,
                    'itemName' =>$cartDetails[0]->title,
                    'basketQty' =>$qty,
                    'itemValue' =>$itemValue,				
                    'basePrice' => $basePrice,
                    'taxName' =>$consumptionTaxName,
                    'taxPercent' =>$consumptionTaxPer,
                    'taxValue' =>$vatPrice,
                    'shipping' =>$shippingPrice,
                    'tsCommissionPercent' =>$tsCommissionPercent,
                    'tsCommissionValue' => $tsCommissionValue,
                    'tsVatPercent'    => $tsVatPercent,
                    'tsVatValue' =>$tsVatValue,
                    'tsGrossCommision' => $tsGrossCommision,				
                    'dispatchPrice'=>$finalPrice,
                    'purchaseType'=>$purchaseType,
                    'sellerId'       => $sellerId,
                    'sellerInfo'   => $json,
                    'sendpaypal' => $sendpaypal	
                  );		  
                //echo "<pre>";
                    //print_r($customerBasketItem);die;
                
                $res=$this->model_common->getDataFromTabel('SalesBasketItem', 'itemId,basketId',  array('entityId'=> $entityId,'elementId' => $elementId,'basketId' =>$thirdPartyCartId,'purchaseType'=>$purchaseType),'','','',1);			
                
                if(isset($res[0]->basketId) && $res[0]->basketId > 0){
                    $this->model_common->editDataFromTabel('SalesBasketItem', $customerBasketItem, 'itemId', $res[0]->itemId);
                }else{
                    $invoiceId=$this->getInvoiceId($thirdPartyCartId,$sellerId);
                    if($invoiceId && strlen($invoiceId) > 5){
                        
                    }else{
                        $invoiceId = $this->createInvoiceId();
                    }
                    
                    $customerBasketItem['invoiceId'] =$invoiceId;
                     
                     $this->model_common->addDataIntoTabel('SalesBasketItem', $customerBasketItem);	
                }
                redirect(base_url(lang().'/cart/confirmbilling/'.$purchaseType)); 
            }

        }
        if(!$isValidItem){
            $msg='selected Item is not available now. please try later.';
            set_global_messages($msg, $type='success', $is_multiple=true);
         
            if(isset($_SERVER['HTTP_REFERER'])){
                $redirect=$_SERVER['HTTP_REFERER'];
            }else{
                $redirect='home';
            }
            redirect($redirect);
        }
    }*/
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to buy shopping cart
    * @return:  void
    * @modified by: lokendra meena
    */ 
    
    function buynow(){
          
        $isValidItem    =   false; // set default value 
        $userId = isLoginUser();    // get loggedIn user Id 
        
        //get cart Id
        $thirdPartyCartId = $this->crfeateSalesCustomersBasket();
        
        $projId         =  $this->input->post('projId');
        $sectionId      =  $this->input->post('sectionId');
        $entityId       =  $this->input->post('entityId');
        $elementId      =  $this->input->post('elementId');
        $currency       =  $this->input->post('currency');
        $purchaseType   =  $this->input->post('purchaseType');
        $price          =  $this->input->post('price');
        $ownerId        =  $this->input->post('ownerId');
        $qnty           =  $this->input->post('qnty');
        $qty            =  (isset($qnty) && ($qnty > 0)) ? $qnty :1;
         
        $i=0;	 

        if($entityId >0 && $elementId > 0){
            $cartDetails=$this->getProductInfo($entityId,$elementId,$purchaseType);
            
            //echo "<pre>";
            //print_r($cartDetails);die();
            
            if($cartDetails){
                   $sendpaypal= 't';	
                    $isValidItem=true;
                    if($purchaseType==1){				
                        $shippingPrice =  $this->getProductShipping($entityId,$elementId);
                        if($shippingPrice==0){
                                    $sendpaypal='f'; // if shipping 0 & type product not send to paypal 							
                                    }
                    }else{
                        $shippingPrice = 0;
                    }
                        
                    $basePrice = (isset($cartDetails[0]->price) && $cartDetails[0]->price > 0) ? $cartDetails[0]->price : 0;					
            
                    /*Manage cart pricing for auction*/
                    
                    $sellType = $this->input->post('sellType'); //Set sell type
                    
                    //Manage base price if sell type is auction
                    if(isset($sellType) && !empty($sellType)) {
                        $productPrice = $this->getPriceInfo($price,$currency,$cartDetails[0]->tdsUid); //get product info
                        $basePrice    = $price - $productPrice['totalCommision']; 
                        $isAuction = true;
                    } else {
                        $isAuction = false;
                    }
                    
                    /*Manage cart pricing for auction*/
                    
                    // CALCULATION BASED ON QUANTITY
                    $itemValue = $basePrice * $qty	;
                    $shippingPrice = $shippingPrice * $qty;							

                    /* Consumption Tax & Price Calculation */
                    $consumptionTaxPer = $this->getConsumptionTax($entityId,$elementId,$cartDetails[0]->tdsUid);
                    if(!$consumptionTaxPer){
                        $consumptionTaxPer=0;
                    }
                    
                    $consumptionTaxName = $this->getTaxName($entityId,$elementId,$cartDetails[0]->tdsUid);
                    if(!$consumptionTaxName){
                        $consumptionTaxName='';
                    }
                                    
                    $vatPrice = ($itemValue*$consumptionTaxPer)/100;				
                    $finalPrice  =  $itemValue + $shippingPrice + $vatPrice ;							
                    
                    if($isAuction==false) {
                        $productPrice = $this->getPriceInfo($itemValue,$currency,$cartDetails[0]->tdsUid);
                    }
                    //echo "<pre>";
                    //print_r($productPrice);
                    $displayPrice = $productPrice['displayPrice'];
                    
                    /* Toad Square Calculation */
                    $tsCommissionPercent= $productPrice['commisionPercentage'];
                    $tsCommissionValue  = $productPrice['commisionOnPrice'];			
                    $tsVatPercent       = $productPrice['VATpercentage'];
                    $tsVatValue         = $productPrice['VATCharge'];
                    $tsGrossCommision	= $productPrice['totalCommision'];
                    
                     $json = '';
                     $sellerInfo=$this->model_cart->getSellerDetails($cartDetails[0]->tdsUid);		 
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
                        
                    $sellerId = $cartDetails[0]->tdsUid;			
                                
                    $customerBasketItem = array(
                    'basketId' =>$thirdPartyCartId,
                    'entityId'=> $entityId,
                    'elementId' => $elementId,
                    'sectionId' => $sectionId,
                    'projId' => $projId,
                    'itemName' =>$cartDetails[0]->title,
                    'basketQty' =>$qty,
                    'itemValue' =>$itemValue,				
                    'basePrice' => $basePrice,
                    'taxName' =>$consumptionTaxName,
                    'taxPercent' =>$consumptionTaxPer,
                    'taxValue' =>$vatPrice,
                    'shipping' =>$shippingPrice,
                    'tsCommissionPercent' =>$tsCommissionPercent,
                    'tsCommissionValue' => $tsCommissionValue,
                    'tsVatPercent'    => $tsVatPercent,
                    'tsVatValue' =>$tsVatValue,
                    'tsGrossCommision' => $tsGrossCommision,				
                    'dispatchPrice'=>$finalPrice,
                    'purchaseType'=>$purchaseType,
                    'sellerId'       => $sellerId,
                    'sellerInfo'   => $json,
                    'sendpaypal' => $sendpaypal,	
                    'projCategory' => (!empty($cartDetails[0]->projcategory))?$cartDetails[0]->projcategory:0,	
                  );		  
                //echo "<pre>";
                    //print_r($customerBasketItem);die;
                
                $res=$this->model_common->getDataFromTabel('SalesBasketItem', 'itemId,basketId',  array('entityId'=> $entityId,'elementId' => $elementId,'basketId' =>$thirdPartyCartId,'purchaseType'=>$purchaseType),'','','',1);			
                
                if(isset($res[0]->basketId) && $res[0]->basketId > 0){
                    $this->model_common->editDataFromTabel('SalesBasketItem', $customerBasketItem, 'itemId', $res[0]->itemId);
                }else{
                    $invoiceId=$this->getInvoiceId($thirdPartyCartId,$sellerId);
                    if($invoiceId && strlen($invoiceId) > 5){
                        
                    }else{
                        $invoiceId = $this->createInvoiceId();
                    }
                    
                    $customerBasketItem['invoiceId'] =$invoiceId;
                     
                     $this->model_common->addDataIntoTabel('SalesBasketItem', $customerBasketItem);	
                }
                redirect(base_url(lang().'/cart/shoppingcartbilling/'.$purchaseType)); 
            }

        }
        if(!$isValidItem){
            $msg='selected Item is not available now. please try later.';
            set_global_messages($msg, $type='success', $is_multiple=true);
         
            if(isset($_SERVER['HTTP_REFERER'])){
                $redirect=$_SERVER['HTTP_REFERER'];
            }else{
                $redirect='home';
            }
            redirect($redirect);
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * comment by lokendra meena
     * 25-11-2014 
     * 
    function buylater(){		 
         // $userId = isLoginUser();	 
        $entityId = $this->input->post('entityId');
        $elementId = $this->input->post('elementId');		  
        $userId = $this->input->post('userId');		  
        if( $entityId>0 && $elementId>0){  
        $customerWishlist = array(				
        'entityId'=> $this->input->post('entityId'),
        'elementId' => $this->input->post('elementId'),
        'tdsUid'    => $userId,
        'currency'  => $this->input->post('currency'),
        'purchaseType' => $this->input->post('purchaseType'),
        'sectionId' => $this->input->post('sectionId'),
        'projId' => $this->input->post('projId'),
        'ownerId' => $this->input->post('ownerId')
        );	

        $currency = $this->input->post('currency');
        $type = ($currency==1) ? 'dollar' : 'euro';

        $entityId = $this->input->post('entityId');		
        $elementId = $this->input->post('elementId');
        $tdsUid = $userId;
        $purchaseType = $this->input->post('purchaseType'); 
             
        $res=$this->model_common->getDataFromTabel('Wishlist', 'itemId',  array('entityId'=> $entityId,'elementId' => $elementId,'tdsUid' =>$tdsUid,'purchaseType'=>$purchaseType),'','','',1);			

        if($res)
        {
        echo "0";
        }else
        {					 
        $this->model_common->addDataIntoTabel('Wishlist', $customerWishlist);
        echo "1";	
        }  
        //redirect(base_url(lang().'/cart/wishlist/'.$type));				

        } else{
        echo "0";
        //redirect(base_url(lang().'/home'));		 
        }	
    }*/
    
    //-------------------------------------------------------------------------
    
    /*
    * @description: This method is use to perform buy latter action
    * @return: void
    * @auther: lokendra meena
    */ 
        
    function buylater(){
       
        // $userId = isLoginUser();	 
        $entityId       =  $this->input->post('entityId');
        $elementId      =  $this->input->post('elementId');		  
        $userId         =  $this->input->post('userId');		  
        if(!empty($entityId) && !empty($elementId)){  
            $customerWishlist   = array(				
                'entityId'      =>  $this->input->post('entityId'),
                'elementId'     =>  $this->input->post('elementId'),
                'tdsUid'        =>  $userId,
                'currency'      =>  $this->input->post('currency'),
                'purchaseType'  =>  $this->input->post('purchaseType'),
                'sectionId'     =>  $this->input->post('sectionId'),
                'projId'        =>  $this->input->post('projId'),
                'ownerId'       =>  $this->input->post('ownerId')
            );

            $currency     =  $this->input->post('currency');
            $type         =  ($currency==1) ? 'dollar' : 'euro';

            $entityId     =  $this->input->post('entityId');		
            $elementId    =  $this->input->post('elementId');
            $tdsUid       =  $userId;
            $purchaseType =  $this->input->post('purchaseType'); 
            
            //get wishlist data
            $wishlistData    =   $this->model_common->getDataFromTabel('Wishlist', 'itemId',  array('entityId'=> $entityId,'elementId' => $elementId,'tdsUid' =>$tdsUid,'purchaseType'=>$purchaseType),'','','',1);			

            if($wishlistData){
                echo "0";
            }else{					 
                $this->model_common->addDataIntoTabel('Wishlist', $customerWishlist);
                echo "1";	
            } 
            
            $msg = "Item succefully add in wishlist.";
            set_global_messages($msg, $type='success', $is_multiple=true);   
        }else{
            echo "0";
        }
    }
    
     function wishlist($currency=0){
        
        
         switch($currency){		 
              case 'dollar':
              $currencyId = 1;
              break;
              
              default:
              $currencyId = 0;		 
          }
             
         $userId = isLoginUser();
        // $userId = 21;
         $wishlistItem=$this->model_common->getDataFromTabel('Wishlist', '*',  array('tdsUid'=>$userId,'currency'=>$currencyId),'','','','');	 
        
         if(is_array($wishlistItem) && isset($wishlistItem) && count($wishlistItem)>0) {		 
            
            $i=0;	  	   
            foreach ($wishlistItem as $items) {		 
                
                $entity_tableName = getMasterTableName($items->entityId);
                $tableName= $entity_tableName[0];
                
                $entityId = ($items->entityId!='') ? $items->entityId : 0 ;
                $elementId = ($items->elementId!='') ?$items->elementId : 0 ;
                $wishlistItemId = ($items->itemId!='') ?$items->itemId : 0 ;
                $currency = (is_numeric($items->currency) && $items->currency > 0) ?$items->currency : 0 ;
                $sectionId = (isset($items->sectionId) && $items->sectionId !='') ?$items->sectionId : '' ;
                
                $ownerId = ($items->ownerId!='') ?$items->ownerId : 0 ;
                $projId = ($items->projId!='') ?$items->projId : 0 ;
                
                $purchaseType  = ($items->purchaseType!='')? $items->purchaseType :1;
                if($purchaseType ==4){
                    $image =$this->config->item('defaultDonateImg');
                    $image = getimage($image);	
                }else{
                    $image = $this->getImageInfo($entityId,$elementId,$sectionId);
                }
                
                $productResult=$this->getProductInfo($entityId,$elementId,$purchaseType);
                if($productResult){
                    $cartDetails[$i]=$productResult;
                    $basePrice  = ($cartDetails[$i][0]->price!='') ? $cartDetails[$i][0]->price :0;
                    
                    if($purchaseType==1){				
                        $shippingPrice =  $this->getProductShipping($entityId,$elementId);
                    }else{
                        $shippingPrice = 0;
                    }
                    
                    /* manage data for auction start */
                    //Get entity table name 
                    /*$getElementTable = getMasterTableName($entityId);
                    $getElementTable = $getElementTable[0];
                    $isTable = true;
                    //Set project where clause and fields name
                    switch($getElementTable) {
                        case 'TDS_Product':
                        $sellType = $this->model_common->getDataFromTabel($getElementTable, 'productSellType',  array('tdsUid'=>$cartDetails[$i][0]->tdsUid,'productId'=>$elementId),'','','','');
                        break;
                        default:
                        $isTable = false;
                        $sellType = 0;
                    }
                    
                    if($isTable==true && isset($sellType) && !empty($sellType) && $sellType==2) {
                        $productData = $this->model_common->getDataFromTabel($getElementTable, 'productSellType',  array('tdsUid'=>$cartDetails[$i][0]->tdsUid,'productId'=>$elementId),'','','','');
                    
                    }*/
                    /* manage data for auction end */
                    
                    
                                    
                    $qty = (isset($qnty) && ($qnty!='')) ? $qnty :1;	
                    
                    // CALCULATION BASED ON QUANTITY
                        $itemValue = $basePrice * $qty	;
                        $shippingPrice = $shippingPrice * $qty; 		 
                                
                        $productPrice = $this->getPriceInfo($itemValue,$currency,$cartDetails[$i][0]->tdsUid);	
                        
                        /*Manage cart pricing for auction start*/ 
                        $sellType = $this->getSellType($entityId,$elementId,$ownerId);
                        if(isset($sellType) && $sellType==2) {
                            //Get sales record from basket
                            $salesRes = $this->model_common->getDataFromTabel('SalesBasketItem', '*',  array('sellerId'=>$ownerId,'entityId'=>$entityId,'elementId'=>$elementId,'projId'=>$projId),'','itemId','Desc','');
                            
                            /* Toad Square Calculation */
                            $productPrice['commisionOnPrice'] =(isset($salesRes[0]->tsCommissionValue) && ($salesRes[0]->tsCommissionValue!='')) ?$salesRes[0]->tsCommissionValue : $productPrice['commisionOnPrice'];
                            $productPrice['VATCharge'] =(isset($salesRes[0]->tsVatValue) && ($salesRes[0]->tsVatValue!='')) ?$salesRes[0]->tsVatValue : $productPrice['VATCharge'];
                            $productPrice['displayPrice'] =(isset($salesRes[0]->itemValue) && ($salesRes[0]->itemValue!='')) ?$salesRes[0]->itemValue : $productPrice['displayPrice'];
                            $itemValue = (isset($salesRes[0]->itemValue) && ($salesRes[0]->itemValue!='')) ?$salesRes[0]->itemValue : $itemValue;
                        }
                        /*Manage cart pricing for auction end*/ 
                                            
                        $displayPrice = $productPrice['displayPrice'];
                                        
                        $cartDetails[$i]['displayPrice'] = $displayPrice;
                        $cartDetails[$i]['itemValue'] = $itemValue;
                        //$cartDetails[$i]['tsCommissionValue'] = $productPrice['totalCommision'];
                        $cartDetails[$i]['tsCommissionValue'] = $productPrice['commisionOnPrice'];
                        $cartDetails[$i]['tsVatValue'] = $productPrice['VATCharge'];				
                    
                        $cartDetails[$i]['image'] =  $image;
                        $cartDetails[$i]['shippingPrice'] =  $shippingPrice;
                        $cartDetails[$i]['wishlistId'] =  $wishlistItemId;	
                        $cartDetails[$i]['consumptionTaxPer'] = $this->getConsumptionTax($entityId,$elementId,$cartDetails[$i][0]->tdsUid);
                        $cartDetails[$i]['consumptionTaxName'] = $this->getTaxName($entityId,$elementId,$cartDetails[$i][0]->tdsUid);
                        $cartDetails[$i]['elementId'] =  $elementId;
                        $cartDetails[$i]['entityId'] =  $entityId;
                        $cartDetails[$i]['purchaseType'] =  $purchaseType;
                        
                                                    
                        $i++;
                }		 
             }
            
                 $data['currency']=$currencyId;
                 $data['basketItems']=$cartDetails;	  
                 $this->template->load('frontend','wishlist',$data);
         } else {
                 $data['currency']=$currencyId;
                 $data['basketItems']='';	  
                 $this->template->load('frontend','wishlist',$data);
                }
                
     }	
     
     
    //-----------------------------------------------------------------------
    
    /*
    * @description: This method is use to show my wishlist currency type
    * @param: currencyType
    * @return: void
    * @auther: lokendra meena 
    */  
    
    function mywishlist($currency=1){
        
        //get currencyId 1=dollar, 0=euro
        $currencyId       = ($currency=='dollar')?'1':'0';
         
        //get loggedIn userId 
        $userId           =   $this->isLoginUser();
     
        // get user whislist item
        $wishlistItem     =   $this->model_common->getDataFromTabel('Wishlist', '*',  array('tdsUid'=>$userId,'currency'=>$currencyId),'','','','');	 
    
        $userWishlistItem = false;  //defined
    
        //if whishlist has a item then show
        if(!empty($wishlistItem)){

            $i=0;	  	   
            foreach ($wishlistItem as $items) {
                $itemId        =  (isset($items->itemId))?$items->itemId:0;
                $entityId      =  (isset($items->entityId))?$items->entityId:0;
                $elementId     =  (isset($items->elementId))?$items->elementId:0;
                $tdsUid        =  (isset($items->tdsUid))?$items->tdsUid:0;
                $currency      =  (isset($items->currency))?$items->currency:0;
                $purchaseType  =  (isset($items->purchaseType))?$items->purchaseType:1;
                $sectionId     =  (isset($items->sectionId))?$items->sectionId:0;
                $projId        =  (isset($items->projId))?$items->projId:0;
                $ownerId       =  (isset($items->ownerId))?$items->ownerId:0;
                $isAuction     =  (isset($items->isAuction))?$items->isAuction:'f';
                $auctionPrice  =  (!empty($items->auctionPrice))?$items->auctionPrice:0;
                $createDate    =  (!empty($items->createDate))?$items->createDate:'';
                
                $daysRemaining       =   daycountdown($createDate,"7");
                
                //show only available day auction purchase wishlist show
                if(($isAuction=="t" && $daysRemaining>0) || $isAuction=="f"){
                
                    //get name of table by entity  id
                    $entityTableName    =  getMasterTableName($entityId);
                    $tableName          =  (!empty($entityTableName[0]))?$entityTableName[0]:0;
                    
                    //get image by purchase type
                    if($purchaseType ==4){
                        $image   =  $this->config->item('defaultDonateImg');
                        $image   =  getimage($image);	
                    }else{
                        $image   =  $this->getImageInfo($entityId,$elementId,$sectionId);
                    }
                    
                    // get project information details
                    $productDetails  =   $this->getProductInfo($entityId,$elementId,$purchaseType);
                    $productDetails  =   (!empty($productDetails[0]))?$productDetails[0]:false;
                     
                    //check project details is not empty
                    if(!empty($productDetails)){
                        
                        // get poject/product base price
                        $basePrice      =   (!empty($productDetails->price))?$productDetails->price:0;
                        $aviliableQty   =   (!empty($productDetails->aviliableqty))?$productDetails->aviliableqty:1;
                        $quantityValue  =   1;
                        
                        // check project type is auction get price
                        if($isAuction=="t") {
                            $basePrice   =   $auctionPrice;
                        }
                        
                        // quantity calculation
                        $itemValue           = $basePrice * $quantityValue;
                        
                        //get product price details 
                        
                        if($isAuction=="t") {
                            //auction product/project price
                            $productPrice =  $this->getAuctionProductPrice($itemValue,$currency,$productDetails->tdsUid);
                            $itemValue    =  $productPrice['price'];
                        }else{
                            //product/project price
                            $productPrice = $this->getPriceInfo($itemValue,$currency,$productDetails->tdsUid);	
                        }
                       
                        //set value in array
                        $userWishlistItem[$i]['displayPrice']        =  $productPrice['displayPrice'];
                        $userWishlistItem[$i]['itemValue']           =  $itemValue;
                        $userWishlistItem[$i]['tsCommissionValue']   =  $productPrice['commisionOnPrice'];
                        $userWishlistItem[$i]['tsVatValue']          =  $productPrice['VATCharge'];				
                        $userWishlistItem[$i]['image']               =  $image;
                        $userWishlistItem[$i]['shippingPrice']       =  $shippingPrice;
                        $userWishlistItem[$i]['wishlistId']          =  $wishlistItemId;	
                        $userWishlistItem[$i]['consumptionTaxPer']   =  $this->getConsumptionTax($entityId,$elementId,$productDetails->tdsUid);
                        $userWishlistItem[$i]['consumptionTaxName']  =  $this->getTaxName($entityId,$elementId,$productDetails->tdsUid);
                        $userWishlistItem[$i]['elementId']           =  $elementId;
                        $userWishlistItem[$i]['entityId']            =  $entityId;
                        $userWishlistItem[$i]['purchaseType']        =  $purchaseType;
                        $userWishlistItem[$i]['title']               =  $productDetails->title;
                        $userWishlistItem[$i]['description']         =  $productDetails->description;
                        $userWishlistItem[$i]['tdsUid']              =  $productDetails->tdsUid;
                        $userWishlistItem[$i]['aviliableqty']        =  $aviliableQty;
                        $userWishlistItem[$i]['isLoginUser']         =  $userId;
                        $userWishlistItem[$i]['wishlistId']         =  $itemId;
                        $i++;
                    }
                
                }
            }
        } 
        
        $data['currency']               =   $currencyId;    // set currency asign
        $data['basketItems']            =   $userWishlistItem; // wishlist listing data
        $data['packagestageheading']    =   $this->lang->line('shoppingcart');  #set package heading	
        $this->new_version->load('new_version','wishlist_new',$data);
    }
    
    //---------------------------------------------------------------------
    
    /*
    *  @description: This method is use to auction price information of product/project
    *  @param: $price
    *  @param: $currency
    *  @param: $ownerId
    *  @modified by: lokendra meena
    *  @return: void
    */ 
     
    function getAuctionProductPrice($price=0,$currency=0,$ownerId=0){
         
        // get user billing & shipping details 
        $billingCountry = $this->getBillingInfo(0);
        
        $countryGroup        =  (!empty($billingCountry->countryGroup))?($billingCountry->countryGroup):'' ;
        $euIdntNo            =  (!empty($billingCountry->EuVatIdentificationNumber))?($billingCountry->EuVatIdentificationNumber):0 ;
        $buyerBillingCountry =  (!empty($billingCountry->billing_country))?($billingCountry->billing_country):0 ;
        $buyercountryGrP     =  (!empty($billingCountry->countryGroup))?($billingCountry->countryGroup):'' ;
        
        // $buyerEuIdntNo = (isset($billingCountry->EuVatIdentificationNumber) && ($billingCountry->EuVatIdentificationNumber!='') ) ? ($billingCountry->EuVatIdentificationNumber) :0 ;
        
        //get seller details
        $sellerDetail  =  $this->model_common->getDataFromTabel('UserSellerSettings', 'territory,territoryCountryId',  array('tdsUid'=>$ownerId),'','','',1);
        
        //get seller territory
        $sellerTerritory           = (!empty($sellerDetail[0]->territory))?$sellerDetail[0]->territory:0;
        $sellerTerritoryCountryId  = (!empty($sellerDetail[0]->territoryCountryId))?$sellerDetail[0]->territoryCountryId:0;
        
        //get user product owner countryId
        $sellerProfle   =   $this->model_common->getDataFromTabel('UserProfile', 'countryId',  array('tdsUid'=>$ownerId),'','','',1);		
      
        //get seller country id
        $sellerCountry = (!empty($sellerProfle[0]->countryId))?$sellerProfle[0]->countryId:0;
        
        //get seller vat percentage
        $sellerVat  =   $this->model_common->getDataFromTabel('MasterCountry', 'vatPercentage',  array('countryId'=>$sellerTerritoryCountryId),'','','',1);
        
        // check vatpercent exist
        if(!empty($sellerVat[0]->vatPercentage)) {
            $VATpercentage = $sellerVat[0]->vatPercentage;			 
        }else{
            $VATpercentage = 0;			   
        }  		
    
                
            $price      =   (!empty($price))?$price:0;
            $currency   =   (!empty($currency))?$currency:0;
            
            //get default value from config for product/project
            $currencySign           =   $this->config->item('currency'.$currency);
            $minimumComission       =   $this->config->item('minimumComission'.$currency);
            $commisionPercentage    =   $this->config->item('commisionPercentage');
            
            $commisionOnPrice   =   (($price * $commisionPercentage)/100);
            $commisionOnPrice   =   ($commisionOnPrice > $minimumComission)?$commisionOnPrice:$minimumComission;
            
            $commisionOnPrice   =   ($price>0)?$commisionOnPrice:0;
            
            $VATCharge      =   (($commisionOnPrice * $VATpercentage)/100);
            $VATCharge      =   ($price>0)?$VATCharge:0;
            
            
            // Seller & Buyer must be from EU but not from same country 							
            if($sellerTerritory==1){		
          
                if(($countryGroup=='EU') && ($euIdntNo!='') && ($sellerCountry!=$buyerBillingCountry) ){						
                    $totalCommision=($commisionOnPrice+$VATCharge);				
                }else {
                    $VATCharge = 0; 
                    $VATpercentage = 0;	
                    $totalCommision=$commisionOnPrice;
                }
            }else{
                $VATCharge = 0; 
                $VATpercentage = 0;	
                $totalCommision=$commisionOnPrice;
            }
            
            $totalCommision  =   ($price>0)?$totalCommision:0;
            $price           =   ($price-$totalCommision);
            $displayPrice    =   ($price+$totalCommision);
            $displayPrice    =   $price>0?$displayPrice:0;
            $commisionOnPrice=   number_format($commisionOnPrice,2,'.','');
            $displayPrice    =   number_format($displayPrice,2,'.','');
            $totalCommision  =   number_format($totalCommision,2,'.','');
            $VATCharge       =   number_format($VATCharge,2,'.','');
            $priceArray      =  array(
                'currencySign'       => $currencySign,
                'minimumComission'   => $minimumComission,
                'commisionPercentage'=> $commisionPercentage,
                'VATpercentage'      => $VATpercentage,
                'price'              => $price,
                'commisionOnPrice'   => $commisionOnPrice,
                'VATCharge'          => $VATCharge,
                'totalCommision'     => $totalCommision,
                'displayPrice'       => $displayPrice
            );
        return $priceArray;
    } 
    
     
    //---------------------------------------------------------------------
    
    /*
    *  @description: This method is use to project/product price information
    *  @param: $price
    *  @param: $currency
    *  @param: $ownerId
    *  @modified by: lokendra meena
    *  @return: void
    */ 
     
    function getPriceInfo($price=0,$currency=0,$ownerId=0){
         
        // get user billing & shipping details 
        $billingCountry = $this->getBillingInfo(0);
        
        $countryGroup        =  (!empty($billingCountry->countryGroup))?($billingCountry->countryGroup):'' ;
        $euIdntNo            =  (!empty($billingCountry->EuVatIdentificationNumber))?($billingCountry->EuVatIdentificationNumber):0 ;
        $buyerBillingCountry =  (!empty($billingCountry->billing_country))?($billingCountry->billing_country):0 ;
        $buyercountryGrP     =  (!empty($billingCountry->countryGroup))?($billingCountry->countryGroup):'' ;
        
        // $buyerEuIdntNo = (isset($billingCountry->EuVatIdentificationNumber) && ($billingCountry->EuVatIdentificationNumber!='') ) ? ($billingCountry->EuVatIdentificationNumber) :0 ;
        
        //get seller details
        $sellerDetail  =  $this->model_common->getDataFromTabel('UserSellerSettings', 'territory,territoryCountryId',  array('tdsUid'=>$ownerId),'','','',1);
        
        //get seller territory
        $sellerTerritory           = (!empty($sellerDetail[0]->territory))?$sellerDetail[0]->territory:0;
        $sellerTerritoryCountryId  = (!empty($sellerDetail[0]->territoryCountryId))?$sellerDetail[0]->territoryCountryId:0;
        
        //get user product owner countryId
        $sellerProfle   =   $this->model_common->getDataFromTabel('UserProfile', 'countryId',  array('tdsUid'=>$ownerId),'','','',1);		
      
        //get seller country id
        $sellerCountry = (!empty($sellerProfle[0]->countryId))?$sellerProfle[0]->countryId:0;
        
        //get seller vat percentage
        $sellerVat  =   $this->model_common->getDataFromTabel('MasterCountry', 'vatPercentage',  array('countryId'=>$sellerTerritoryCountryId),'','','',1);
        
        // check vatpercent exist
        if(!empty($sellerVat[0]->vatPercentage)) {
            $VATpercentage = $sellerVat[0]->vatPercentage;			 
        }else{
            $VATpercentage = 0;			   
        }  		
    
                
            $price      =   (!empty($price))?$price:0;
            $currency   =   (!empty($currency))?$currency:0;
            
            //get default value from config for product/project
            $currencySign           =   $this->config->item('currency'.$currency);
            $minimumComission       =   $this->config->item('minimumComission'.$currency);
            $commisionPercentage    =   $this->config->item('commisionPercentage');
            
            $commisionOnPrice   =   (($price * $commisionPercentage)/100);
            $commisionOnPrice   =   ($commisionOnPrice > $minimumComission)?$commisionOnPrice:$minimumComission;
            
            $commisionOnPrice   =   ($price>0)?$commisionOnPrice:0;
            
            $VATCharge      =   (($commisionOnPrice * $VATpercentage)/100);
            $VATCharge      =   ($price>0)?$VATCharge:0;
            
            
            // Seller & Buyer must be from EU but not from same country 							
            if($sellerTerritory==1){		
          
                if(($countryGroup=='EU') && ($euIdntNo!='') && ($sellerCountry!=$buyerBillingCountry) ){						
                    $totalCommision=($commisionOnPrice+$VATCharge);				
                }else {
                    $VATCharge = 0; 
                    $VATpercentage = 0;	
                    $totalCommision=$commisionOnPrice;
                }
            }else{
                $VATCharge = 0; 
                $VATpercentage = 0;	
                $totalCommision=$commisionOnPrice;
            }
            
            $totalCommision  =   ($price>0)?$totalCommision:0;
            $displayPrice    =   ($price+$totalCommision);
            $displayPrice    =   $price>0?$displayPrice:0;
            $commisionOnPrice=   number_format($commisionOnPrice,2,'.','');
            $displayPrice    =   number_format($displayPrice,2,'.','');
            $totalCommision  =   number_format($totalCommision,2,'.','');
            $VATCharge       =   number_format($VATCharge,2,'.','');
            $priceArray      =  array(
                'currencySign'       => $currencySign,
                'minimumComission'   => $minimumComission,
                'commisionPercentage'=> $commisionPercentage,
                'VATpercentage'      => $VATpercentage,
                'price'              => $price,
                'commisionOnPrice'   => $commisionOnPrice,
                'VATCharge'          => $VATCharge,
                'totalCommision'     => $totalCommision,
                'displayPrice'       => $displayPrice
            );
        return $priceArray;
    }   
      
    //-----------------------------------------------------------------------
    
    /*
    *  @description: This method is use to create sales customer basket
    *  @modified by : lokendra meena
    *  @return: void
    */
    
    public function crfeateSalesCustomersBasket(){
    
        $userId         =   isLoginUser();
        $trackingId     =   $this->createRandomNo(); // genrate random number
        $customerBasket =   array('uId' => $userId,'basketFinalPrice' =>0,'trackingId' =>$trackingId);
        
        //get old basket data list
        $basketData = $this->model_common->getDataFromTabel('SalesCustomersBasket', 'basketId',  array('uId'=>$userId));
        if(!empty($basketData)){
            foreach($basketData as $k=>$basket){
                //prepare basketId list data
                $basketIds[]=$basket->basketId;
            }
            //delete basketId
            $this->model_common->deleteRowFromTabel('SalesBasketItem', 'basketId', $basketIds);
        }
        
        //sales customer basket add new record
        $thirdPartyCartId = $this->model_common->addDataIntoTabel('SalesCustomersBasket', $customerBasket);
        $this->session->set_userdata('thirdPartyCartId',$thirdPartyCartId);//add order basket id into session
        return $thirdPartyCartId;
    }
    
    //----------------------------------------------------------------------
  
    function checkout(){
      
      $userId = isLoginUser();
      $buyProductItems = $this->input->post('wishlistitem');
      
       $thirdPartyCartId = $this->crfeateSalesCustomersBasket();  
       
       
       $isShippingDetails=false;
      
        if($buyProductItems && is_array($buyProductItems) && count($buyProductItems) > 0){
        
          foreach($buyProductItems as $key=>$item){
            $wishlistItem=$this->model_common->getDataFromTabel('Wishlist', '*',  array('tdsUid'=>$userId,'itemId'=>$key),'','','','');			
                  
            if(is_array($wishlistItem) && isset($wishlistItem) && count($wishlistItem)>0) {		 
                
                $i=0;
                
                foreach ($wishlistItem as $items) {					
                 
                        $entity_tableName = getMasterTableName($items->entityId);
                        $tableName= $entity_tableName[0];
                        
                        $entityId = ($items->entityId!='') ? $items->entityId : 0 ;
                        $elementId = ($items->elementId!='') ?$items->elementId : 0 ;
                        $purchaseType = ($items->purchaseType!='') ? $items->purchaseType : 1 ;				
                        $currency = (is_numeric($items->currency) && $items->currency > 0) ?$items->currency : 0 ;
                        $sectionId = (isset($items->sectionId) && $items->sectionId !='') ?$items->sectionId : '' ;
                        
                        if($purchaseType ==1){
                            $isShippingDetails=true;
                        }
                        
                        
                        $sendpaypal= 't';	       
                         if($purchaseType==1){
                                $isShippingDetails=true;									
                                $shippingPrice =  $this->getProductShipping($entityId,$elementId);
                                if($shippingPrice==0){
                                    $sendpaypal='f'; // if shipping 0 & type product not send to paypal 							
                                    }									
                                }else{
                                    $shippingPrice = 0;
                                }
                                                
                        
                        if($purchaseType ==4){
                            $image =$this->config->item('defaultDonateImg');
                            $image = getimage($image);		
                        }else{
                            $image = $this->getImageInfo($entityId,$elementId,$sectionId);
                        }
                        $productResult=$this->getProductInfo($entityId,$elementId,$purchaseType);		
                        if($productResult){
                            $cartDetails[$i]=$productResult;				   
                                            
                            //$shippingPrice =  $this->getProductShipping($entityId,$elementId);
                            $basePrice = ($cartDetails[$i][0]->price!='') ? $cartDetails[$i][0]->price : 0;
                            $qty = (isset($qnty) && ($qnty!='')) ? $qnty :1;	
                            
                            // CALCULATION BASED ON QUANTITY
                            $itemValue = $basePrice * $qty	;
                            $shippingPrice = $shippingPrice * $qty;
                            
                            /* Consumption Tax & Price Calculation */
                            $consumptionTaxPer = $this->getConsumptionTax($entityId,$elementId,$cartDetails[$i][0]->tdsUid);
                            $consumptionTaxName = $this->getTaxName($entityId,$elementId,$cartDetails[$i][0]->tdsUid);
                            $vatPrice = ($itemValue*$consumptionTaxPer)/100;				
                            $finalPrice  = $itemValue + $shippingPrice + $vatPrice ;							
                            
                            $productPrice = $this->getPriceInfo($itemValue,$currency,$cartDetails[$i][0]->tdsUid);				
                            $displayPrice = $productPrice['displayPrice'];
                            
                            /* Toad Square Calculation */
                            $tsCommissionPercent= $productPrice['commisionPercentage'];
                            $tsCommissionValue  = $productPrice['commisionOnPrice'];			
                            $tsVatPercent       = $productPrice['VATpercentage'];
                            $tsVatValue         = $productPrice['VATCharge'];
                            $tsGrossCommision	= $productPrice['totalCommision'];
                            
                            $json ='';
                            $sellerInfo=$this->model_cart->getSellerDetails($cartDetails[$i][0]->tdsUid);
                        if($sellerInfo) {			 
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
                         
                         
                        $sellerId = $cartDetails[$i][0]->tdsUid;
                          
                                        
                        $customerBasketItem = array(
                            'basketId' =>$thirdPartyCartId,
                            'entityId'=> $entityId,
                            'elementId' => $elementId,
                            'sectionId' =>$items->sectionId,
                            'itemName' =>$cartDetails[$i][0]->title,
                            'basketQty' =>$qty,
                            'currency' =>$items->currency,
                            'itemValue' =>$itemValue,				
                            'basePrice' => $basePrice,
                            'taxName' =>$consumptionTaxName,
                            'taxPercent' =>$consumptionTaxPer,
                            'taxValue' =>$vatPrice,
                            'shipping' =>$shippingPrice,
                            'tsCommissionPercent' =>$tsCommissionPercent,
                            'tsCommissionValue' => $tsCommissionValue,
                            'tsVatPercent'    => $tsVatPercent,
                            'tsVatValue' =>$tsVatValue,
                            'tsGrossCommision' => $tsGrossCommision,				
                            'dispatchPrice'=>$finalPrice,
                            'purchaseType'=>$purchaseType,
                            'sellerId'    => $sellerId,
                            'sellerInfo'  => $json,
                            'projId'      => $items->projId,
                            'sendpaypal' => $sendpaypal	
                      );
                                
                        $res=$this->model_common->getDataFromTabel('SalesBasketItem', 'basketId',  array('entityId'=> $entityId,'elementId' => $elementId,'basketId' =>$thirdPartyCartId,'purchaseType'=>$purchaseType),'','','',1);			
                        
                        $this->model_cart->deleteCartItem($thirdPartyCartId,$entityId,$elementId,$purchaseType);
                        
                        if(isset($res[0]->basketId) && $res[0]->basketId > 0){
                            $this->model_common->editDataFromTabel('SalesBasketItem', $customerBasketItem, 'itemId', $res[0]->id);
                        }else{
                             $invoiceId=$this->getInvoiceId($thirdPartyCartId,$sellerId);
                             if($invoiceId && strlen($invoiceId) > 5){
                                
                             }else{
                                $invoiceId = $this->createInvoiceId();
                             }
                             
                             $customerBasketItem['invoiceId'] =$invoiceId;
                             $this->model_common->addDataIntoTabel('SalesBasketItem', $customerBasketItem);	
                        }	
                                        
                         $i++;
                    }else{
                        $this->model_cart->deleteCartItem($thirdPartyCartId,$entityId,$elementId,$purchaseType);
                    }
                         
                 }
                    
             }
             
          } 
         
        } 
          if($isShippingDetails){
              $purchaseType=1;
          }else{
              $purchaseType='2';
          } 	   
               redirect(base_url(lang().'/cart/confirmbilling/'.$purchaseType)); 
    }
    
    
    //----------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to wishlist checkout 
    *  @return: void
    *  @modified by: lokendra meena
    */ 
    
    public function wishlistcheckout(){
      
        // get logged In user id
        $userId             = $this->isLoginUser();
        
        $buyProductItems    = $this->input->post('wishlistitem');
        
        //create customer basket id 
        $thirdPartyCartId = $this->crfeateSalesCustomersBasket();  
       
        $isShippingDetails=false; // set default value 
        if(!empty($buyProductItems)){
        
            foreach($buyProductItems as $key=>$item){
           
                //call purchase item purchase method 
                $isShippingStatus = $this->_wishlistitempurchase($userId,$key,$thirdPartyCartId);
                //get shipping status 
                if($isShippingStatus){
                    $isShippingDetails = true;
                }
            } 
        } 
        if($isShippingDetails){
            $purchaseType=1;
        }else{
            $purchaseType='2';
        }
        redirect(base_url(lang().'/cart/shoppingcartbilling/'.$purchaseType)); 
    }
    
    
    //----------------------------------------------------------------------
    
    /*
    *  @description: This method is use to purchase wishlist item
    *  @param: $userId
    *  @param: $wishlistItemId
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    private function _wishlistitempurchase($userId,$wishlistItemId,$thirdPartyCartId){
        
        $isShippingDetails=false;
        //get wishlist record by userId and wishlist id
        $wishlistItem   =   $this->model_common->getDataFromTabel('Wishlist', '*',  array('tdsUid'=>$userId,'itemId'=>$wishlistItemId),'','','','');			

        if(!empty($wishlistItem)){                
            
            $i=0; //counter
            foreach ($wishlistItem as $items) {					
             
                    $entityTableName =  getMasterTableName($items->entityId);
                    $tableName       =  $entityTableName; // entity table name get
                    
                    $itemId       =  (!empty($items->itemId))?$items->itemId:0;
                    $entityId     =  (!empty($items->entityId))?$items->entityId:0;
                    $elementId    =  (!empty($items->elementId))?$items->elementId:0;
                    $purchaseType =  (!empty($items->purchaseType))?$items->purchaseType:1;				
                    $currency     =  (!empty($items->currency))?$items->currency:0;
                    $sectionId    =  (!empty($items->sectionId))?$items->sectionId:'';
                    $projId       =  (!empty($items->projId))?$items->projId:'';
                    $ownerId      =  (!empty($items->ownerId))?$items->ownerId:'';
                    $isAuction    =  (!empty($items->isAuction))?$items->isAuction:'';
                    $auctionPrice =  (!empty($items->auctionPrice))?$items->auctionPrice:'';
                    
                    
                    //check purchase type 1 set shipping true
                    $isShippingDetails  =  ($purchaseType==1)?true:false;
                    
                    $sendpaypal   =   't';
                    if($purchaseType==1){
                        $isShippingDetails=true;									
                        $shippingPrice =  $this->getProductShipping($entityId,$elementId);
                        if($shippingPrice==0){
                            $sendpaypal='f'; // if shipping 0 & type product not send to paypal 							
                        }
                    }else{
                        $shippingPrice = 0;
                    }
                    
                    //check purchase type for donating image
                    if($purchaseType==4){
                        $image =    $this->config->item('defaultDonateImg');
                        $image =    getimage($image);		
                    }else{
                        $image = $this->getImageInfo($entityId,$elementId,$sectionId);
                    }
                    
                    //get product information
                    $productDetails   =   $this->getProductInfo($entityId,$elementId,$purchaseType);
                    $productDetails  =   (!empty($productDetails[0]))?$productDetails[0]:false;
                    
                    if($productDetails){
                                        
                        // get poject/product base price
                        $basePrice      =   (!empty($productDetails->price))?$productDetails->price:0;
                        $aviliableQty   =   (!empty($productDetails->aviliableqty))?$productDetails->aviliableqty:1;
                        $quantityValue  =   1;//set one only
                        
                        // check project type is auction get price
                        if($isAuction=="t") {
                            $basePrice   =   $auctionPrice;
                        }
                        
                        // CALCULATION BASED ON QUANTITY
                        $itemValue = $basePrice * $quantityValue;
                        $shippingPrice = $shippingPrice * $quantityValue;
                        
                        
                        
                        //get product price details 
                        if($isAuction=="t") {
                            //auction product/project price
                            $productPrice =  $this->getAuctionProductPrice($itemValue,$currency,$productDetails->tdsUid);
                            $itemValue    =  $productPrice['price'];
                        }else{
                            //product/project price
                            $productPrice = $this->getPriceInfo($itemValue,$currency,$productDetails->tdsUid);	
                        }
                        
                        //Consumption Tax & Price Calculation
                        $consumptionTaxPer   =  $this->getConsumptionTax($entityId,$elementId,$productDetails->tdsUid);
                        $consumptionTaxName  =  $this->getTaxName($entityId,$elementId,$productDetails->tdsUid);
                        $vatPrice            =  ($itemValue*$consumptionTaxPer)/100;				
                        $finalPrice          =  $itemValue + $shippingPrice + $vatPrice ;							
                        $displayPrice        =  $productPrice['displayPrice'];
                        
                        //Toad Square Calculation
                        $tsCommissionPercent    =   $productPrice['commisionPercentage'];
                        $tsCommissionValue      =   $productPrice['commisionOnPrice'];			
                        $tsVatPercent           =   $productPrice['VATpercentage'];
                        $tsVatValue             =   $productPrice['VATCharge'];
                        $tsGrossCommision       =   $productPrice['totalCommision'];
                        
                        $json ='';
                        $sellerInfo =   $this->model_cart->getSellerDetails($productDetails->tdsUid);
                        
                        if(!empty($sellerInfo)) { 
                            //seller information json
                            $UserShippingJson = array( 
                                'firstName'             => $sellerInfo->firstName,
                                'lastName'              => $sellerInfo->lastName,
                                'email'                 => $sellerInfo->email,
                                'seller_address1'       => $sellerInfo->seller_address1,
                                'seller_city'           => $sellerInfo->seller_city,
                                'seller_state'          => $sellerInfo->seller_state,
                                'seller_zip'            => $sellerInfo->seller_zip,
                                'seller_phone'          => $sellerInfo->seller_phone,
                                'territoryCountryId'    => $sellerInfo->territoryCountryId,
                                'sellerEuIdnumber'      => $sellerInfo->identificationNumber
                            );					
                             $json = json_encode($UserShippingJson);  
                        }  
                     
                        //get product/project owner/seller id
                        $sellerId = $productDetails->tdsUid;
                      
                        //prepare array for basket item
                        $customerBasketItem = array(
                            'basketId'      =>  $thirdPartyCartId,
                            'entityId'      =>  $entityId,
                            'elementId'     =>  $elementId,
                            'sectionId'     =>  $items->sectionId,
                            'itemName'      =>  $productDetails->title,
                            'basketQty'     =>  $quantityValue,
                            'currency'      =>  $items->currency,
                            'itemValue'     =>  $itemValue,				
                            'basePrice'     =>  $basePrice,
                            'taxName'       =>  $consumptionTaxName,
                            'taxPercent'    =>  $consumptionTaxPer,
                            'taxValue'      =>  $vatPrice,
                            'shipping'      =>  $shippingPrice,
                            'tsCommissionPercent'   =>  $tsCommissionPercent,
                            'tsCommissionValue'     =>  $tsCommissionValue,
                            'tsVatPercent'          =>  $tsVatPercent,
                            'tsVatValue'            =>  $tsVatValue,
                            'tsGrossCommision'      =>  $tsGrossCommision,				
                            'dispatchPrice'         =>  $finalPrice,
                            'purchaseType'          =>  $purchaseType,
                            'sellerId'              =>  $sellerId,
                            'sellerInfo'            =>  $json,
                            'projId'                =>  $items->projId,
                            'sendpaypal'            =>  $sendpaypal,
                            'isProductAuction'      =>  $isAuction,
                      );
                    
                    //get sales basket item in basket table        
                    $res=$this->model_common->getDataFromTabel('SalesBasketItem', 'basketId',  array('entityId'=> $entityId,'elementId' => $elementId,'basketId' =>$thirdPartyCartId,'purchaseType'=>$purchaseType),'','','',1);			
                    
                    //if already exist then delete
                    $this->model_cart->deleteCartItem($thirdPartyCartId,$entityId,$elementId,$purchaseType);
                    
                    //if record already exist then updated
                    if(!empty($res[0]->basketId)){
                        $this->model_common->editDataFromTabel('SalesBasketItem', $customerBasketItem, 'itemId', $res[0]->id);
                    }else{
                        //if not exist then update it
                        $invoiceId =   $this->getInvoiceId($thirdPartyCartId,$sellerId);
                        //if invioce id not exist then create
                        if(empty($invoiceId)){
                            $invoiceId = $this->createInvoiceId();
                        }
                         
                        $customerBasketItem['invoiceId'] =$invoiceId;
                        $this->model_common->addDataIntoTabel('SalesBasketItem', $customerBasketItem);
                    }
                
                    $i++;
                }else{
                    $this->model_cart->deleteCartItem($thirdPartyCartId,$entityId,$elementId,$purchaseType);
                }
                     
             }
                
         }
         
        return $isShippingDetails;
        
    }
    
    //----------------------------------------------------------------------


    function confirmbilling($purchaseType=1){
        //$thirdPartyCartId=9; 
        $userId = isLoginUser(); 
        $thirdPartyCartId=$this->session->userdata('thirdPartyCartId'); 
        $billingData = $this->getBillingInfo($thirdPartyCartId);
        
        $billing=$this->model_common->getDataFromTabel('UserBuyerSettings', 'billing_firstName,shipping_firstName',  array('tdsUid'=>$this->userId),'','','',1);	    
        $isUserBilling = isset($billing[0]->billing_firstName)?$billing[0]->billing_firstName:'';
        $isUsershipping = isset($billing[0]->shipping_firstName)?$billing[0]->shipping_firstName:'';	
                
        if($purchaseType==1){
            $isShippingDetails=true;
        }else{
            $isShippingDetails=false;
        }
        
        $data['isShippingDetails'] = $isShippingDetails;
        $data['userProfileData'] = $billingData;
        $data['globelBilling'] = $isUserBilling;
        $data['globelShipping'] = $billingData;	
        
        $data['countryList'] = getCountryList();	
        $this->template->load('frontend','confirm_billing_address',$data);
         
    }
    
    //--------------------------------------------------------------------------
    
    /*
    *  @Descrition: This method is use to show shoping cart billing details
    *  @param: purchaseType
    *  @return: void
    *  @auther: Lokendra Meena
    */ 
    
    function shoppingcartbilling($purchaseType=1){
        //$thirdPartyCartId=9; 
        $userId             =   $this->isLoginUser(); 
        //get cart id
        $thirdPartyCartId   =   $this->session->userdata('thirdPartyCartId'); 
        // get billing & shipping info
        $billingData    =   $this->getBillingInfo($thirdPartyCartId);
        
        $billing        =   $this->model_common->getDataFromTabel('UserBuyerSettings', 'billing_firstName,shipping_firstName',  array('tdsUid'=>$this->userId),'','','',1);	    
        $isUserBilling  =   isset($billing[0]->billing_firstName)?$billing[0]->billing_firstName:'';
        $isUsershipping =   isset($billing[0]->shipping_firstName)?$billing[0]->shipping_firstName:'';	
                
        if($purchaseType==1){
            $isShippingDetails=true;
        }else{
            $isShippingDetails=false;
        }
        
        $data['isShippingDetails'] = $isShippingDetails;
        $data['userProfileData'] = $billingData;
        $data['globelBilling'] = $isUserBilling;
        $data['globelShipping'] = $billingData;	
        
        $data['countryList']                =   getCountryList();	
        $data['packagestageheading'] 	    =   $this->lang->line('shoppingcart');  #set package heading
        $data['shoppingCartStage'] 	        =   'stage1';  #set package heading
        $this->new_version->load('new_version','confirm_billing_address_new',$data);
    }
    
    //-----------------------------------------------------------------------

  function saveBillingDetails(){	  
    
    $userId = isLoginUser();	  
    $billingsaveglobalSettings = $this->input->post('billingsaveglobalSettings');
    $shippingsaveglobalSettings = $this->input->post('shippingsaveglobalSettings');
     
    $countryIdBilling = $this->input->post('billing_country');	
    $countryNameBilling = $this->model_cart->getUserCountryName($countryIdBilling);
    $thirdPartyCartId=$this->session->userdata('thirdPartyCartId');
     
    if($this->input->post('shipping_isSameAsBilling')==true){		
             $countryIdShipping = $this->input->post('billing_country');
        }else{  
             $countryIdShipping = $this->input->post('shipping_country');	
         }
    $countryNameShipping = $this->model_cart->getUserCountryName($countryIdShipping);  
      
      
        if($this->input->post('save')==true)
        {	
            $shipping_isSameAsBilling=$this->input->post('shipping_isSameAsBilling')==true?true:false;
            if($shipping_isSameAsBilling==true){
                 //echo $msg = "SameAsBilling";
                $shipping_firstName = $this->input->post('billing_firstName');
                $shipping_lastName = $this->input->post('billing_lastName');
                $shipping_address1 = $this->input->post('billing_address1');
                $shipping_address2 = $this->input->post('billing_address2');
                $shipping_city = $this->input->post('billing_city');
                $shipping_state = $this->input->post('billing_state');
                $shipping_country = $this->input->post('billing_country');
                $shipping_zip = $this->input->post('billing_zip');
                $shipping_phone = $this->input->post('billing_phone');
                $shipping_email = $this->input->post('billing_email');
            }else{
                //echo $msg = "NOt SameAsBilling";
                $shipping_firstName = $this->input->post('shipping_firstName');
                $shipping_lastName = $this->input->post('shipping_lastName');
                $shipping_address1 = $this->input->post('shipping_address1');
                $shipping_address2 = $this->input->post('shipping_address2');
                $shipping_city = $this->input->post('shipping_city');
                $shipping_state = $this->input->post('shipping_state');
                $shipping_country = $this->input->post('shipping_country');
                $shipping_zip = $this->input->post('shipping_zip');
                $shipping_phone = $this->input->post('shipping_phone');
                $shipping_email =$this->input->post('shipping_email');
            }
        
        
                            
        if(isset($billingsaveglobalSettings) && $billingsaveglobalSettings==true){
            
                $res=$this->model_common->getDataFromTabel('UserBuyerSettings', 'id,otherAboutConsumptionTax',  array('tdsUid'=>$userId),'','','',1);	 
        
                            
                $UserBilling = array(
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
                'EuVatIdentificationNumber' => $this->input->post('EuVatIdentificationNumber'),
                'otherAboutConsumptionTax' => $res[0]->otherAboutConsumptionTax				
              );
              
            //$res=$this->model_common->getDataFromTabel('UserBuyerSettings', 'id',  array('tdsUid'=>$userId),'','','',1);
            
            $json = array('billingdetails'=>'');
            $this->model_common->editDataFromTabel('SalesCustomersBasket', $json, 'basketId', $thirdPartyCartId);
            
            
            if(isset($res[0]->id) && $res[0]->id > 0){
                $this->model_common->editDataFromTabel('UserBuyerSettings', $UserBilling, 'id', $res[0]->id);
            }else{
                $this->model_common->addDataIntoTabel('UserBuyerSettings', $UserBilling);
            }
                                    
            echo $msg = "Update Billing Address";
             set_global_messages($msg, $type='success', $is_multiple=true);  	    
          
    } else {
    
        $res=$this->model_common->getDataFromTabel('UserBuyerSettings', 'id,otherAboutConsumptionTax',  array('tdsUid'=>$userId),'','','',1);	 
        
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
                'countryName'               => $countryNameBilling->countryName,
                'countryGroup'              => $countryNameBilling->countryGroup,				
                'otherAboutConsumptionTax' => $res[0]->otherAboutConsumptionTax	

            );			
             
              
            //$thirdPartyCartId=9;
            $json = array('billingdetails'=>json_encode($UserBuyerSettings ));
            $this->model_common->editDataFromTabel('SalesCustomersBasket', $json, 'basketId', $thirdPartyCartId);
            
             $msg = "Update Billing Address";
             set_global_messages($msg, $type='success', $is_multiple=true);				
         }		
                
    if(isset($shippingsaveglobalSettings) && $shippingsaveglobalSettings==true){
                
                $UserShipping = array(
                'tdsUid' => $this->userId,
                'shipping_firstName' => $shipping_firstName,
                'shipping_lastName' => $shipping_lastName,
                'shipping_address1' => $shipping_address1,
                'shipping_address2' => $shipping_address2,
                'shipping_city' => $shipping_city,
                'shipping_state' => $shipping_state,
                'shipping_country' => $shipping_country,
                'shipping_zip' => $shipping_zip,
                'shipping_phone' => $shipping_phone,
                'shipping_email' => $shipping_email,
                'EuVatIdentificationNumber' => $this->input->post('EuVatIdentificationNumber')			
              );
            
            
            $json = array('shippingdetails'=>'');
            $this->model_common->editDataFromTabel('SalesCustomersBasket', $json, 'basketId', $thirdPartyCartId);
            
            $res=$this->model_common->getDataFromTabel('UserBuyerSettings', 'id',  array('tdsUid'=>$userId),'','','',1);
            if(isset($res[0]->id) && $res[0]->id > 0){
                $this->model_common->editDataFromTabel('UserBuyerSettings', $UserShipping, 'id', $res[0]->id);
            }else{
                $this->model_common->addDataIntoTabel('UserBuyerSettings', $UserShipping);
            }
                                    
             $msg = "Update Shipping  Address";
             set_global_messages($msg, $type='success', $is_multiple=true);  	    
          
    } else {
        
      $userId=isloginUser();
     $UserShippingJson = array(
                'tdsUid' => $userId,
                'shipping_firstName' => $shipping_firstName,
                'shipping_lastName' => $shipping_lastName,
                'shipping_address1' => $shipping_address1,
                'shipping_address2' => $shipping_address2,
                'shipping_city' => $shipping_city,
                'shipping_state' => $shipping_state,
                'shipping_country' => $shipping_country,
                'shipping_zip' => $shipping_zip,
                'shipping_phone' => $shipping_phone,
                'shipping_email' => $shipping_email,			   
                'shippingcountryname'  => $countryNameShipping->countryName,
                'shippingcountryGroup' => $countryNameShipping->countryGroup
            );
            //$thirdPartyCartId=9;
            
            $json = array('shippingdetails'=>json_encode($UserShippingJson));
            $this->model_common->editDataFromTabel('SalesCustomersBasket', $json, 'basketId', $thirdPartyCartId);
            
             $msg = "Update Shipping Jason Address";
            // set_global_messages($msg, $type='success', $is_multiple=true);
                
         }
         
        /*$EuVatIdentificationNumber = $this->input->post('EuVatIdentificationNumber') ;
        if($EuVatIdentificationNumber!=''){
         $countryEu = $this->input->post('billing_country');
         $inserEuCountry = array('CountryEU_VAT'=>$countryEu);
         $this->model_common->editDataFromTabel('UserBuyerSettings', $inserEuCountry, 'tdsUid', $userId);
        }  */ 
         
     }	
    redirect(base_url(lang().'/cart/showcart'));	  
 }
    
    /*
    * @description: This method is use to save billing details  
    * @return: void
    * @auther: lokendra meena
    */ 
 
    function postshoppingcartbilling(){	  
    
        $userId = isLoginUser();	  
        $billingsaveglobalSettings = $this->input->post('billingsaveglobalSettings');
        $shippingsaveglobalSettings = $this->input->post('shippingsaveglobalSettings');
         
        $countryIdBilling = $this->input->post('billing_country');	
        $countryNameBilling = $this->model_cart->getUserCountryName($countryIdBilling);
        $thirdPartyCartId=$this->session->userdata('thirdPartyCartId');
        
        $shipping_isSameAsBilling=($this->input->post('shipping_isSameAsBilling'))?true:false; 
         
        //check shipping same as billing for country id
        if($shipping_isSameAsBilling){		
            $countryIdShipping = $this->input->post('billing_country');
        }else{  
            $countryIdShipping = $this->input->post('shipping_country');	
        }
        
        //get shipping coutry name
        $countryNameShipping = $this->model_cart->getUserCountryName($countryIdShipping);  
          
        if($this->input->post())
        {
            
                if($shipping_isSameAsBilling){
                     //echo $msg = "SameAsBilling";
                    $shipping_firstName     =  $this->input->post('billing_firstName');
                    $shipping_lastName      =  $this->input->post('billing_lastName');
                    $shipping_companyName   =  $this->input->post('billing_companyName');
                    $shipping_address1      =  $this->input->post('billing_address1');
                    $shipping_address2      =  $this->input->post('billing_address2');
                    $shipping_city          =  $this->input->post('billing_city');
                    $shipping_state         =  $this->input->post('billing_state');
                    $shipping_country       =  $this->input->post('billing_country');
                    $shipping_zip           =  $this->input->post('billing_zip');
                    $shipping_phone         =  $this->input->post('billing_phone');
                    $shipping_email         =  $this->input->post('billing_email');
                }else{
                    //echo $msg = "NOt SameAsBilling";
                    $shipping_firstName     =  $this->input->post('shipping_firstName');
                    $shipping_lastName      =  $this->input->post('shipping_lastName');
                    $shipping_companyName   =  $this->input->post('shipping_companyName');
                    $shipping_address1      =  $this->input->post('shipping_address1');
                    $shipping_address2      =  $this->input->post('shipping_address2');
                    $shipping_city          =  $this->input->post('shipping_city');
                    $shipping_state         =  $this->input->post('shipping_state');
                    $shipping_country       =  $this->input->post('shipping_country');
                    $shipping_zip           =  $this->input->post('shipping_zip');
                    $shipping_phone         =  $this->input->post('shipping_phone');
                    $shipping_email         =  $this->input->post('shipping_email');
                }
            
            
                                
            if(isset($billingsaveglobalSettings) && $billingsaveglobalSettings==true){
                
                    $res=$this->model_common->getDataFromTabel('UserBuyerSettings', 'id,otherAboutConsumptionTax',  array('tdsUid'=>$userId),'','','',1);	 
                                
                    $UserBilling = array(
                    'tdsUid' => $this->userId,
                    'billing_firstName'=> $this->input->post('billing_firstName'),
                    'billing_lastName' => $this->input->post('billing_lastName'),
                    'billing_companyName' => $this->input->post('billing_companyName'),
                    'billing_address1' => $this->input->post('billing_address1'),
                    'billing_address2' => $this->input->post('billing_address2'),
                    'billing_city' => $this->input->post('billing_city'),
                    'billing_state' => $this->input->post('billing_state'),
                    'billing_country' => $this->input->post('billing_country'),
                    'billing_zip' => $this->input->post('billing_zip'),
                    'billing_phone' => $this->input->post('billing_phone'),
                    'billing_email' => $this->input->post('billing_email'),
                    'EuVatIdentificationNumber' => $this->input->post('EuVatIdentificationNumber'),
                    'otherAboutConsumptionTax' => $res[0]->otherAboutConsumptionTax				
                  );
                  
                //$res=$this->model_common->getDataFromTabel('UserBuyerSettings', 'id',  array('tdsUid'=>$userId),'','','',1);
                
                $json = array('billingdetails'=>'');
                $this->model_common->editDataFromTabel('SalesCustomersBasket', $json, 'basketId', $thirdPartyCartId);
                
                
                if(isset($res[0]->id) && $res[0]->id > 0){
                    $this->model_common->editDataFromTabel('UserBuyerSettings', $UserBilling, 'id', $res[0]->id);
                }else{
                    $this->model_common->addDataIntoTabel('UserBuyerSettings', $UserBilling);
                }
                                        
                echo $msg = "Update Billing Address";
                 set_global_messages($msg, $type='success', $is_multiple=true);  	    
              
            } else {
        
                $res=$this->model_common->getDataFromTabel('UserBuyerSettings', 'id,otherAboutConsumptionTax',  array('tdsUid'=>$userId),'','','',1);	 

                $UserBuyerSettings = array(
                    'tdsUid' => $userId,
                    'billing_firstName'=> $this->input->post('billing_firstName'),
                    'billing_lastName' => $this->input->post('billing_lastName'),
                    'billing_companyName' => $this->input->post('billing_companyName'),
                    'billing_address1' => $this->input->post('billing_address1'),
                    'billing_address2' => $this->input->post('billing_address2'),
                    'billing_city' => $this->input->post('billing_city'),
                    'billing_state' => $this->input->post('billing_state'),
                    'billing_country' => $this->input->post('billing_country'),
                    'billing_zip' => $this->input->post('billing_zip'),
                    'billing_phone' => $this->input->post('billing_phone'),
                    'billing_email' => $this->input->post('billing_email'),
                    'EuVatIdentificationNumber' => $this->input->post('EuVatIdentificationNumber'),
                    'countryName'               => $countryNameBilling->countryName,
                    'countryGroup'              => $countryNameBilling->countryGroup,				
                    'otherAboutConsumptionTax' => $res[0]->otherAboutConsumptionTax	

                );			
                 
                  
                //$thirdPartyCartId=9;
                $json = array('billingdetails'=>json_encode($UserBuyerSettings ));
                $this->model_common->editDataFromTabel('SalesCustomersBasket', $json, 'basketId', $thirdPartyCartId);

                 $msg = "Update Billing Address";
                 set_global_messages($msg, $type='success', $is_multiple=true);				
            }		
                    
            if(isset($shippingsaveglobalSettings) && $shippingsaveglobalSettings==true){
                    
                    $UserShipping = array(
                    'tdsUid' => $this->userId,
                    'shipping_firstName' => $shipping_firstName,
                    'shipping_lastName' => $shipping_lastName,
                    'shipping_companyName' => $shipping_companyName,
                    'shipping_address1' => $shipping_address1,
                    'shipping_address2' => $shipping_address2,
                    'shipping_city' => $shipping_city,
                    'shipping_state' => $shipping_state,
                    'shipping_country' => $shipping_country,
                    'shipping_zip' => $shipping_zip,
                    'shipping_phone' => $shipping_phone,
                    'shipping_email' => $shipping_email,
                    'EuVatIdentificationNumber' => $this->input->post('EuVatIdentificationNumber')			
                  );
                
                
                $json = array('shippingdetails'=>'');
                $this->model_common->editDataFromTabel('SalesCustomersBasket', $json, 'basketId', $thirdPartyCartId);
                
                $res=$this->model_common->getDataFromTabel('UserBuyerSettings', 'id',  array('tdsUid'=>$userId),'','','',1);
                if(isset($res[0]->id) && $res[0]->id > 0){
                    $this->model_common->editDataFromTabel('UserBuyerSettings', $UserShipping, 'id', $res[0]->id);
                }else{
                    $this->model_common->addDataIntoTabel('UserBuyerSettings', $UserShipping);
                }
                                        
                 $msg = "Update Shipping  Address";
                 set_global_messages($msg, $type='success', $is_multiple=true);  	    
              
            } else {
            
                $userId=isloginUser();
                $UserShippingJson = array(
                    'tdsUid' => $userId,
                    'shipping_firstName' => $shipping_firstName,
                    'shipping_lastName' => $shipping_lastName,
                    'shipping_companyName' => $shipping_companyName,
                    'shipping_address1' => $shipping_address1,
                    'shipping_address2' => $shipping_address2,
                    'shipping_city' => $shipping_city,
                    'shipping_state' => $shipping_state,
                    'shipping_country' => $shipping_country,
                    'shipping_zip' => $shipping_zip,
                    'shipping_phone' => $shipping_phone,
                    'shipping_email' => $shipping_email,			   
                    'shippingcountryname'  => $countryNameShipping->countryName,
                    'shippingcountryGroup' => $countryNameShipping->countryGroup
                );
                //$thirdPartyCartId=9;
                
                $json = array('shippingdetails'=>json_encode($UserShippingJson));
                
                $this->model_common->editDataFromTabel('SalesCustomersBasket', $json, 'basketId', $thirdPartyCartId);
                
                 $msg = "Update Shipping Jason Address";
                // set_global_messages($msg, $type='success', $is_multiple=true);
                    
            }
             
            /*$EuVatIdentificationNumber = $this->input->post('EuVatIdentificationNumber') ;
            if($EuVatIdentificationNumber!=''){
             $countryEu = $this->input->post('billing_country');
             $inserEuCountry = array('CountryEU_VAT'=>$countryEu);
             $this->model_common->editDataFromTabel('UserBuyerSettings', $inserEuCountry, 'tdsUid', $userId);
            }  */ 
         
        }
        redirect(base_url(lang().'/cart/shoppingcartsummary'));	  
     }
    
    //----------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to update cart information
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    function updateCart(){
      
      $userId = $this->isLoginUser(); // get logged in userId
      $thirdPartyCartId=$this->session->userdata('thirdPartyCartId');//get cart Id
      
      //get sales basket item list data
      $salesItemListData   =   $this->model_common->getDataFromTabel('SalesBasketItem', '*',  array('basketId' =>$thirdPartyCartId),'','','');
        
        if(!empty($salesItemListData)){
        
           foreach($salesItemListData as $item){
                
                //get sales item data
                $entityId       =   (!empty($item->entityId))?$item->entityId:0 ;
                $elementId      =   (!empty($item->elementId))?$item->elementId:0;
                $basePrice      =   (!empty($item->basePrice))?$item->basePrice:0;
                $itemValue      =   (!empty($item->itemValue))?$item->itemValue:0;
                $ownerId        =   (!empty($item->sellerId))?$item->sellerId:0;
                $qty            =   (!empty($item->basketQty))?$item->basketQty:0;
                $currency       =   (isset($item->currency))?$item->currency:0;
                $purchaseType   =   (!empty($item->purchaseType))?$item->purchaseType:1;
                $isProductAuction   =   (isset($item->isProductAuction))?$item->isProductAuction:'f';
                $sendpaypal     =   't';
               
                if($purchaseType==1){				
                    $shippingPrice =  $this->getProductShipping($entityId,$elementId);
                    if($shippingPrice==0){
                        $sendpaypal='f'; // if shipping 0 & type product not send to paypal 							
                    }
                }else{
                    $shippingPrice = 0;
                }
                
                //calcuate shipping price with quantity
                $shippingPrice = $shippingPrice * $qty;
                            
                /* Consumption Tax & Price Calculation */
                $consumptionTaxPer  =   $this->getConsumptionTax($entityId,$elementId,$ownerId);
                $consumptionTaxName =   $this->getTaxName($entityId,$elementId,$ownerId);
                $vatPrice           =   ($itemValue*$consumptionTaxPer)/100;
                $finalPrice         =   $itemValue + $shippingPrice + $vatPrice;
                
                $updateBasketItem = array(
                    'shipping'      =>  $shippingPrice,
                    'dispatchPrice' =>  $finalPrice,
                    'sendpaypal'    =>  $sendpaypal
                );
                  
                $this->model_common->editDataFromTabel('SalesBasketItem', $updateBasketItem, 'itemId', $item->itemId);		   
            }
        }else{
            redirect('home');  
        }
    }
  
    
    function showCart(){	  
      $thirdPartyCartId=$this->session->userdata('thirdPartyCartId');
      
      $cartDetails = array();
      $userId = isLoginUser();	
      
      $this->updateCart();
      
      $wishlistItem=$this->model_cart->getAllUserBasketItems($thirdPartyCartId);
      
     
       if(is_array($wishlistItem) && isset($wishlistItem) && count($wishlistItem)>0) {		 
         
     
        $i=0;	  	   
        foreach ($wishlistItem as $items) {	 
            
            $entityId = ($items->entityId!='') ? $items->entityId : 0 ;
            $elementId = ($items->elementId!='') ?$items->elementId : 0 ;
            $wishlistItemId = ($items->itemId!='') ?$items->itemId : 0 ;
            $qty = (isset($items->basketQty) && ($items->basketQty!='')) ? $items->basketQty :1;
            $ownerId =  $items->sellerId;					
            $projId =  $items->projId;					
            $trackingId =  $items->trackingId;					
            $purchaseType = ($items->purchaseType!='') ? $items->purchaseType : 1 ;
            $itemValue = $items->itemValue;		
            $basePrice = $items->basePrice;		
            $currency = (is_numeric($items->currency) && $items->currency > 0) ?$items->currency : 0 ;
            $sectionId = (isset($items->sectionId) && $items->sectionId !='') ?$items->sectionId : '' ;
            
            $sellerInfo=$items->sellerInfo;
            $sellerInfo=json_decode($sellerInfo);
            
            $productResult=false;
            $isticketPrice=false;
            if($entityId == 66){ //ticketPurchase
                
                if(isset($sellerInfo->entityIdPE)){
                    $isticketPrice=true;
                    $entityIdPE=$sellerInfo->entityIdPE;
                    $entityIdSession=getMasterTableRecord('EventSessions');
                    $SessionId=$sellerInfo->SessionId;
                }
            }			
                
                if($isticketPrice){
                    $productResult=$this->getProductInfo($entityIdPE,$projId,$purchaseType);
                }else{
                    $productResult=$this->getProductInfo($entityId,$elementId,$purchaseType);
                }
                
                if($productResult){
                    $cartDetails[$i]=$productResult;
                    
                    if($purchaseType ==4){ // for donate
                        $image =$this->config->item('defaultDonateImg');
                        $image = getimage($image);		
                    }else{
                        if($isticketPrice){
                            $image = $this->getImageInfo($entityIdPE,$projId,$sectionId);
                            
                        }else{
                            $image = $this->getImageInfo($entityId,$elementId,$sectionId);
                        }
                        
                        
                    }
                    
                    if($purchaseType==1){				
                        $shippingPrice =  $this->getProductShipping($entityId,$elementId);
                    }else{
                        $shippingPrice = 0;
                    }
                    
                    $shippingPrice = $shippingPrice * $qty;						
                    
                    if($purchaseType ==4){ // for donate
                        $donationAmount=($itemValue+$items->tsCommissionValue);
                        $productPrice = $this->getPriceInfo($donationAmount,$currency,$ownerId);	
                    }else{
                        $productPrice = $this->getPriceInfo($itemValue,$currency,$ownerId);	
                    }
                    
                    /*Manage cart pricing for auction start*/ 
                    $sellType = $this->getSellType($entityId,$elementId,$ownerId);
                    if(isset($sellType) && $sellType==2) {
                    
                        /* Toad Square Calculation */
                        $productPrice['commisionOnPrice'] =(isset($items->tsCommissionValue) && ($items->tsCommissionValue!='')) ? $items->tsCommissionValue : $productPrice['commisionOnPrice'] ;
                        $productPrice['VATCharge']        =(isset($items->tsVatValue) && ($items->tsVatValue!='')) ? $items->tsVatValue : $productPrice['VATCharge'] ;
                    }
                    /*Manage cart pricing for auction end*/ 			
                                
                    $displayPrice = $productPrice['displayPrice'];
                    
                    
                    $cartDetails[$i]['itemValue'] = $itemValue;			
                    $cartDetails[$i]['displayPrice'] = $displayPrice;
                    //$cartDetails[$i]['tsCommissionValue'] = $productPrice['totalCommision'];
                    
                    $cartDetails[$i]['tsCommissionValue'] = $productPrice['commisionOnPrice'];
                    $cartDetails[$i]['tsVatValue'] = $productPrice['VATCharge'];
                    
                    $cartDetails[$i]['image'] =  $image;
                    $cartDetails[$i]['shippingPrice'] =  $shippingPrice;
                    
                    if($isticketPrice){
                        $cartDetails[$i]['consumptionTaxPer'] = $this->getConsumptionTax($entityIdSession,$SessionId,$ownerId);
                        $cartDetails[$i]['consumptionTaxName'] = $this->getTaxName($entityIdSession,$SessionId,$ownerId);			
                    }else{
                        $cartDetails[$i]['consumptionTaxPer'] = $this->getConsumptionTax($entityId,$elementId,$ownerId);
                        $cartDetails[$i]['consumptionTaxName'] = $this->getTaxName($entityId,$elementId,$ownerId);			
                    }
                        
                    $cartDetails[$i]['wishlistId'] =  $wishlistItemId;					
                    $cartDetails[$i]['elementId'] =  $elementId;
                    $cartDetails[$i]['entityId'] =  $entityId;
                    $cartDetails[$i]['purchaseType'] = $purchaseType;							
                    $cartDetails[$i]['basePrice'] = $basePrice;							
                    $cartDetails[$i]['sellerInfo'] = $sellerInfo;
                    $cartDetails[$i]['sendpaypal'] = $items->sendpaypal	;						
                    $i++;
                }	
         }
            $billingData = $this->getBillingInfo($thirdPartyCartId);
            $billing=$this->model_common->getDataFromTabel('UserBuyerSettings', 'billing_firstName,shipping_firstName',  array('tdsUid'=>$this->userId),'','','',1);	    
            $isUserBilling = isset($billing[0]->billing_firstName)?$billing[0]->billing_firstName:'';
            $isUsershipping = isset($billing[0]->shipping_firstName)?$billing[0]->shipping_firstName:'';
            $OwnerCurrency = $this->getOwnerCurrency($ownerId);
            
            $cartProductTotal = $this->model_cart->getBasketTotal($thirdPartyCartId);	
            $toadComm = $this->model_cart->getToadCommision($thirdPartyCartId,$OwnerCurrency);
            
            $cartGrandTotal = $cartProductTotal +  $toadComm;
            
            $data['globelBilling'] = $isUserBilling;
            $data['globelShipping'] = $billingData;
                    
            $data['currency']  = $OwnerCurrency;
            $data['trackingId'] = $trackingId;
            $data['billingDetail'] = $billingData;
            $data['basketItems']=$cartDetails;
            $data['cartGrandTotal'] = $cartGrandTotal;	  
            $this->template->load('frontend','cart',$data);
     } else {
              redirect(base_url(lang().'/home'));			 
             }	 
      
   }
   
    //----------------------------------------------------------------------
    /*
    * @description: This method is use to show shopping cart summary
    * @return: void
    * @auther: lokendra meena
    */ 
   
    function shoppingcartsummary(){
        
        //get basket cart id
        $thirdPartyCartId=$this->session->userdata('thirdPartyCartId');
        
        $cartDetails  =  array(); //defined default array
        $userId       =  $this->isLoginUser();// get loggedIn user
        
        //call update cart for cart info update
        $this->updateCart();
        
        //get list of sale basket item listing data
        $salesCartItem   =   $this->model_cart->getAllUserBasketItems($thirdPartyCartId);
   
        
        if(!empty($salesCartItem)){		 
            $i=0;
            foreach ($salesCartItem as $items){ 
                
                $entityId       =  (!empty($items->entityId))?$items->entityId:0;
                $elementId      =  (!empty($items->elementId))?$items->elementId:0;
                $salesItemId    =  (!empty($items->itemId))?$items->itemId:0;
                $itemName       =  (!empty($items->itemName))?$items->itemName:'';
                $qty            =  (!empty($items->basketQty))?$items->basketQty:1;
                $ownerId        =  (!empty($items->sellerId))?$items->sellerId:0;
                $projId         =  (!empty($items->projId))?$items->projId:0;
                $trackingId     =  (!empty($items->trackingId))?$items->trackingId:0;
                $purchaseType   =  (!empty($items->purchaseType))?$items->purchaseType:1;
                $itemValue      =  (!empty($items->itemValue))?$items->itemValue:0;		
                $basePrice      =  (!empty($items->basePrice))?$items->basePrice:0;		
                $currency       =  (!empty($items->currency))?$items->currency:0 ;
                $sectionId      =  (!empty($items->sectionId))?$items->sectionId:'';
                $tsCommissionValue      =  (!empty($items->tsCommissionValue))?$items->tsCommissionValue:'';
                $isProductAuction      =  (!empty($items->isProductAuction))?$items->isProductAuction:'f';
               
                // set again item value for show data  
                $itemValue      =   $itemValue + $tsCommissionValue;
               
                //get seller info json 
                $sellerInfo=$items->sellerInfo;
                //decode seller info
                $sellerInfo=json_decode($sellerInfo);
                
                $productResult  =   false; //set default value
                $isticketPrice  =   false; // set default value
                
                //check entity is for ticket purchase get info 
                if($entityId == 66){ 
                    if(!empty($sellerInfo->entityIdPE)){
                        $isticketPrice=true;
                        $entityIdPE=$sellerInfo->entityIdPE;
                        $entityIdSession=getMasterTableRecord('EventSessions');
                        $SessionId=$sellerInfo->SessionId;
                    }
                }
                
                //get price by check itTicket price
                if($isticketPrice){
                    $productDetails=$this->getProductInfo($entityIdPE,$projId,$purchaseType);
                }else{
                    $productDetails=$this->getProductInfo($entityId,$elementId,$purchaseType);
                }
                
                //assign multiple array into single array
                $productDetails  =   (!empty($productDetails[0]))?$productDetails[0]:false;
                
                if($productDetails){
                    
                    //check type for donate default image
                    if($purchaseType ==4){
                        $image =    $this->config->item('defaultDonateImg');
                        $image =    getimage($image);		
                    }else{
                        if($isticketPrice){
                            $image = $this->getImageInfo($entityIdPE,$projId,$sectionId);
                        }else{
                            $image = $this->getImageInfo($entityId,$elementId,$sectionId);
                        }
                    }
                    
                    //check product/project is isShippable
                    if($purchaseType==1){				
                        $shippingPrice =  $this->getProductShipping($entityId,$elementId);
                    }else{
                        $shippingPrice = 0;
                    }
                    
                    $shippingPrice = $shippingPrice * $qty;						
                    
                    //get price by purchase type
                    if($purchaseType ==4){ // for donate
                        $donationAmount=($itemValue+$items->tsCommissionValue);
                        $productPrice = $this->getPriceInfo($donationAmount,$currency,$ownerId);	
                    }else{
                        //get auction product/project price info
                        if($isProductAuction=="t"){
                            //auction product/project price
                            $productPrice =  $this->getAuctionProductPrice($itemValue,$currency,$productDetails->tdsUid);
                            $itemValue    =  $productPrice['price'];
                        }else{
                            $productPrice = $this->getPriceInfo($itemValue,$currency,$ownerId);	
                        }
                    }
                        
                                
                    $displayPrice                           =  $productPrice['displayPrice'];
                    $cartDetails[$i]['itemValue']           =  $itemValue;			
                    $cartDetails[$i]['title']               =  $itemName;			
                    $cartDetails[$i]['displayPrice']        =  $displayPrice;
                    $cartDetails[$i]['tsCommissionValue']   =  $productPrice['commisionOnPrice'];
                    $cartDetails[$i]['tsVatValue']          =  $productPrice['VATCharge'];
                    $cartDetails[$i]['image']               =  $image;
                    $cartDetails[$i]['shippingPrice']       =  $shippingPrice;
                    
                    //if is ticket then set 
                    if($isticketPrice){
                        $cartDetails[$i]['consumptionTaxPer'] = $this->getConsumptionTax($entityIdSession,$SessionId,$ownerId);
                        $cartDetails[$i]['consumptionTaxName'] = $this->getTaxName($entityIdSession,$SessionId,$ownerId);			
                    }else{
                        $cartDetails[$i]['consumptionTaxPer'] = $this->getConsumptionTax($entityId,$elementId,$ownerId);
                        $cartDetails[$i]['consumptionTaxName'] = $this->getTaxName($entityId,$elementId,$ownerId);			
                    }
                        
                    $cartDetails[$i]['wishlistId']      =  $salesItemId;					
                    $cartDetails[$i]['elementId']       =  $elementId;
                    $cartDetails[$i]['entityId']        =  $entityId;
                    $cartDetails[$i]['purchaseType']    =  $purchaseType;							
                    $cartDetails[$i]['basePrice']       =  $basePrice;							
                    $cartDetails[$i]['sellerInfo']      =  $sellerInfo;
                    $cartDetails[$i]['sendpaypal']      =  $items->sendpaypal	;						
                    $i++;
                }
            }
            
            //get user billing information details
            $billingData      =  $this->getBillingInfo($thirdPartyCartId);
            //get buyer setting status
            $billing          =  $this->model_common->getDataFromTabel('UserBuyerSettings', 'billing_firstName,shipping_firstName',  array('tdsUid'=>$this->userId),'','','',1);	    
            //check billing status
            $isUserBilling    =  isset($billing[0]->billing_firstName)?$billing[0]->billing_firstName:'';
            //check shipping status
            $isUsershipping   =  isset($billing[0]->shipping_firstName)?$billing[0]->shipping_firstName:'';
            //currency type
            $OwnerCurrency    =  $this->getOwnerCurrency($ownerId);
            //total of product
            $cartProductTotal =  $this->model_cart->getBasketTotal($thirdPartyCartId);	
            
            //toad commsion
            $toadComm                   =  $this->model_cart->getToadCommision($thirdPartyCartId,$OwnerCurrency);
            //calculation of product and commision
            $cartGrandTotal             =  $cartProductTotal +  $toadComm;
            $data['globelBilling']      = $isUserBilling;
            $data['globelShipping']     = $billingData;
            $data['currency']           = $OwnerCurrency;
            $data['trackingId']         = $trackingId;
            $data['billingDetail']      = $billingData;
            $data['basketItems']        =$cartDetails;
            $data['cartGrandTotal']     = $cartGrandTotal;	 
            $data['packagestageheading']     =   $this->lang->line('shoppingcart');  #set package heading
            $data['shoppingCartStage']       =   'stage2';  #set package heading 
            $this->new_version->load('new_version','cart_new',$data);
        }
        else{
          redirect(base_url(lang().'/home'));			 
        } 
    }
    
    //----------------------------------------------------------------------
    
    /*
    * @description: This method is use to get product shipping details 
    * @param: $entityId
    * @param: $elementId
    * @modified by : lokendra meena
    * @return: void
    */ 
    
    function getProductShipping($entityId=0,$elementId=0){
        
        $userId             =   isLoginUser(); // get logged in userId
        $thirdPartyCartId   =   $this->session->userdata('thirdPartyCartId'); // get 
        
        // get billing details from customer basket
        $billingDetail      =   $this->model_cart->getBillingDetails($thirdPartyCartId);
        
        // check shipping details data 
        if(!empty($billingDetail->shippingdetails)){
            $shippingdetails    = json_decode($billingDetail->shippingdetails); // decode shipping details
            $buyerCountry       =  $shippingdetails; // get object of shipping
            $shippingCountry    = $buyerCountry->shipping_country; //get shipping country
        }else {
            //get buyer setting shipping country id
            $buyerCountry       = $this->model_common->getDataFromTabel('UserBuyerSettings', 'shipping_country',  array('tdsUid'=>$userId),'','','',1);

            // check data and get shipping country id
            if(!empty($buyerCountry)){
                $shippingCountry = (!empty($buyerCountry[0]->shipping_country))?$buyerCountry[0]->shipping_country:0;
            }else{
                $shippingCountry = 0;
            }
        }
         
        // assign country Id          
        if(!empty($shippingCountry)) {
            $countryId =  $shippingCountry;
        }else{ 
           $countryId = 0 ; 
        } 
        
        // get shipping amount
        $shipping = $this->model_cart->getShippingAmount($entityId,$elementId,$countryId);    
          
        if((!empty($shipping[0]->amount))){		  		
            $shippingAmount =  (!empty($shipping[0]->amount))?$shipping[0]->amount:0;  			
        }else {
            $shippingAmount =  0; 
        } 
        
        return $shippingAmount;
    }
  
    //-----------------------------------------------------------------------
    
    /*
    *  @description: this method is use to get seller 
    *  @param: $ownerId
    *  @modifid by: lokendra meena
    *  @return: void
    */ 
    
    function isConsumptionTaxApplied($ownerId=0){
    
        $isTaxApplied  = $this->model_common->getDataFromTabel('UserSellerSettings', 'chargeConsumptionTax',  array('tdsUid'=>$ownerId),'','','',1);
        
        if(isset($isTaxApplied[0]->chargeConsumptionTax) && ($isTaxApplied[0]->chargeConsumptionTax=='t')){
            return true;
        } else {
            return 0;
        }
    }   

    //---------------------------------------------------------------------

    /*
    *   @access: public
    *   @description: This method is use to get consumption tax
    *   @param: $entityId
    *   @param: $elementId
    *   @param: $ownerId
    *   @modified by: lokendra meena
    *   @return: int
    */ 
    
    public function getConsumptionTax($entityId=0,$elementId=0,$ownerId=0) {
    
    // get tax is applecable
    $isTaxApplecable    =   $this->isConsumptionTaxApplied($ownerId);
    
        if($isTaxApplecable){
                    
            $isProjTax  =   $this->model_common->getDataFromTabel('ConsumptionTaxSettings', 'taxSettings,taxPercentage',  array('entityId'=>$entityId,'elementId'=>$elementId,'projectId'=>$elementId,'userId'=>$ownerId),'','','',1);
            
            if(isset($isProjTax[0]->taxSettings) && ($isProjTax[0]->taxSettings!='') && ($isProjTax[0]->taxSettings==2)){  
                  return $taxPercentage = $isProjTax[0]->taxPercentage;			     
            }elseif(isset($isProjTax[0]->taxSettings) && ($isProjTax[0]->taxSettings!='') && ($isProjTax[0]->taxSettings==0)){
                return 0;	
            }else{
                return $this->buyerBasedConsumpTax($ownerId);				
            }                  
        }else{ 
            return 0;
        }  
    }
    
     
 function buyerBasedConsumpTax($ownerId=0) {				
        $userId = isLoginUser();		
        $thirdPartyCartId=$this->session->userdata('thirdPartyCartId');
        
        $sellerDetail=$this->model_common->getDataFromTabel('UserSellerSettings', 'territory,territoryCountryId',  array('tdsUid'=>$ownerId),'','','',1);
                //1:Eu 
        $sellerTerritory = (isset($sellerDetail[0]->territory) && ($sellerDetail[0]->territory!='')) ? $sellerDetail[0]->territory : 0;
        
        $sellerProfle=$this->model_common->getDataFromTabel('UserProfile', 'countryId',  array('tdsUid'=>$ownerId),'','','',1);		
        $sellerCountry = (isset($sellerProfle[0]->countryId) && ($sellerProfle[0]->countryId!='')) ? $sellerProfle[0]->countryId : 0;
        
// Check wheather user has diffrent address from global settings 		
        $billingDetail = $this->model_cart->getBillingDetails($thirdPartyCartId);
           if(isset($billingDetail->billingdetails) && $billingDetail->billingdetails!=''){
                $billingdetail = json_decode($billingDetail->billingdetails);
            //print_r($billingdetail);die;	
                $buyerBilling =  $billingdetail;
                $buyerBillingCountry = $buyerBilling->billing_country;
                $buyerBillingState = $buyerBilling->billing_state;
                $buyercountryGrP = $buyerBilling->countryGroup;
                $buyerEuIdntNo = $buyerBilling->EuVatIdentificationNumber;
            } else {				
                    $buyerBilling=$this->model_common->getDataFromTabel('UserBuyerSettings', 'billing_country,billing_state,EuVatIdentificationNumber',  array('tdsUid'=>$userId),'','','',1);
                   if($buyerBilling){
                       
                    $buyerBillingCountry = $buyerBilling[0]->billing_country;
                   // $buyerBillingCountry = $buyerBilling[0]->CountryEU_VAT;
                    $buyerBillingState = $buyerBilling[0]->billing_state;				    
                    $res = $this->model_cart->getUserCountryName($buyerBillingCountry);				    
                    $buyercountryGrP = (isset($res->countryGroup) && ($res->countryGroup!='')) ? $res->countryGroup :'';				    
                    $buyerEuIdntNo = $buyerBilling[0]->EuVatIdentificationNumber;
                    
                   }else{				   
                        $buyerBillingCountry = 0;
                        $buyerBillingState =0;
                        $buyercountryGrP='';
                        $buyerEuIdntNo=0;
                   }
            }
        
        
        
        
// Seller & Buyer must be from EU but not from same country 							
    if($sellerTerritory==1){		
        //echo 'BG'.$buyercountryGrP.'--EUI-'.$buyerEuIdntNo.'---SC--'.$sellerCountry.'-BC'.$buyerBillingCountry;die;				               
        if(($buyercountryGrP=='EU') && ($buyerEuIdntNo!='') && ($sellerCountry!=$buyerBillingCountry) ){						
            return 0;				
         }			
     }	
                   
                            
        if(isset($buyerBillingCountry) && ($buyerBillingCountry!='') && ($buyerBillingState!='') ){									   
                $buyerBillingCountry =$buyerBillingCountry ;
                $buyerBillingState =$buyerBillingState ;
              // echo $buyerBillingState = 0;die;
               $taxDetails=$this->model_common->getDataFromTabel('ConsumptionTax', 'taxPercentage',  array('countryId'=>$buyerBillingCountry,'stateId'=>$buyerBillingState,'userId'=>$ownerId,'isDeleted'=>'f'),'','','',1); 
                    
             // $taxPercentage = ;			   
               if(isset($taxDetails[0]->taxPercentage) && $taxDetails[0]->taxPercentage!=''){
                   $taxPercentage = $taxDetails[0]->taxPercentage;		   
                    return $taxPercentage;
               }else {
                      return 0;
                }			        			     
        }else{
            return 0;
        }
  } 
  
  
    
    //---------------------------------------------------------------------
    
    /*
    *  @description: This method is use to get taxname
    *  @param: entityId
    *  @param: elementId
    *  @param: ownerId
    */ 
 
    function getTaxName($entityId=0,$elementId=0,$ownerId=0){
     
        $userId = isLoginUser();		
        $thirdPartyCartId=$this->session->userdata('thirdPartyCartId');
            
            // Check wheather user has diffrent address from global settings 		
            $billingDetail = $this->model_cart->getBillingDetails($thirdPartyCartId);
               if(isset($billingDetail->billingdetails) && $billingDetail->billingdetails!=''){
                    $billingdetail = json_decode($billingDetail->billingdetails);
                    $buyerBilling =  $billingdetail;
                    $buyerBillingCountry = $buyerBilling->billing_country;
                    $buyerBillingState = $buyerBilling->billing_state;
                } else {				
                        $buyerBilling=$this->model_common->getDataFromTabel('UserBuyerSettings', 'billing_country,billing_state',  array('tdsUid'=>$userId),'','','',1);
                        if($buyerBilling){
                            $buyerBillingCountry = $buyerBilling[0]->billing_country;
                            $buyerBillingState = $buyerBilling[0]->billing_state;
                        }else{
                            $buyerBillingCountry = 0;
                            $buyerBillingState = 0;
                        }
             }
                       
                               
                    
            if(isset($buyerBillingCountry) && ($buyerBillingCountry!='') && ($buyerBillingState!='') ){									   
                    $buyerBillingCountry = $buyerBillingCountry ;
                    $buyerBillingState = $buyerBillingState ;
                    //$buyerBillingState = 0;
                   $taxDetails=$this->model_common->getDataFromTabel('ConsumptionTax', 'taxName',  array('countryId'=>$buyerBillingCountry,'stateId'=>$buyerBillingState,'userId'=>$ownerId,'isDeleted'=>'f'),'','','',1); 
                    $taxName = '';			   
                   if(isset($taxDetails[0]->taxName) && $taxDetails[0]->taxName!=''){
                       $taxName = $taxDetails[0]->taxName;		   
                   }else {
                         $taxNameDetails=$this->model_common->getDataFromTabel('ConsumptionTax', 'taxName',  array('userId'=>$ownerId,'isDeleted'=>'f'),'','','',1); 
                         if($taxNameDetails){
                             $taxName = $taxNameDetails[0]->taxName;
                         }		   
                         
                    }	
                    return $taxName;		        			     
            }
                 
    } 
 
 /* Get Media Type products image */

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
                    
                     $projectImage               =   getProjectCoverImage($elementId,'_m');
                   /* $imagePath = 'projBaseImgPath as imagepath';					
                    $whereId = 'projId';
                    
                    $selectfields =$imagePath;			
                    $where = array($whereId=>$elementId);
                    $getImage = $this->model_cart->getMediaImage($tableName,$selectfields,$where);		
                    if(empty($getImage)){
                        $image = getElementImageByType($elementId,$sectionId);
                    }else{
                        $image = $getImage;
                    }*/	
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
                    $eventImage = $this->model_cart-> getPnArtImage($tableName,'EventId',$elementId ,'FileId');
                    if(!empty($eventImage) && file_exists($eventImage)) {
                        $image = $eventImage;
                    } else {
                        $getProjectImage = getEventsPrimaryImage($elementId,'.eventId');
                        if($getProjectImage){
                            $image = $getProjectImage;
                        }else{
                            $image = '';				
                        }
                    }
                break;
                
                case 'TDS_LaunchEvent':
                    $launchImage = $this->model_cart-> getPnArtImage($tableName,'LaunchEventId',$elementId ,'FileId');
                    if(!empty($launchImage) && file_exists($launchImage)) {
                        $image = $launchImage;
                    } else {
                        $getProjectImage = getEventsPrimaryImage($elementId,'.launchEventId');
                        if($getProjectImage){
                            $image = $getProjectImage;
                        }else{
                            $image = '';				
                        }
                    }
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
            $image=addThumbFolder($image,$suffix='_m',$thumbFolder,$imageType); 
        } 	
        $image=getImage($image,$imageType);	
    }
    return $image;	  
      
  }
 
 
 function getOwnerCurrency($ownerId=0){
    
    $getCurrency=$this->model_common->getDataFromTabel('UserSellerSettings', 'seller_currency',  array('tdsUid'=>$ownerId),'','','',1);		
    $userCurrency = (isset($getCurrency[0]->seller_currency) && ($getCurrency[0]->seller_currency!='')) ? $getCurrency[0]->seller_currency :0;	
    
    return $userCurrency;	 
 }
    
    //----------------------------------------------------------------------
    
    /*
    *  @description : This method is use to get billing informatin of user
    *  @param: basetId
    *  @modified by: lokendra meena
    *  @return: void
    */ 
    
    function getBillingInfo($basketId) {
    
        // get billing details from sales customer basket
        $billingDetail = $this->model_cart->getBillingDetails($basketId);
        
        //get loggedIn user id
        $userId = isLoginUser();
     
        if(!empty($billingDetail->billingdetails)){
            $billingdetail   = json_decode($billingDetail->billingdetails);// decode json value array
            $userBillingData =  $billingdetail; //billing details object/array
        }else{
            // get user billing details
            $userBillingData =  $this->model_cart->getUserBillingDetails($userId);
        }
        
        // check shipping details exist
        if(!empty($billingDetail->shippingdetails)){
            $shippingdetails = json_decode($billingDetail->shippingdetails);//decode json value array
            $userShippingData =  $shippingdetails; // shipping details
        }else {
            // get uesr shipping details 
            $userShippingData =  $this->model_cart->getBillingShipDetails($userId);
        }
        
        // merge billing and shipping details array convert into object
        $billingData = (object) array_merge((array)$userBillingData, (array)$userShippingData);
        
        return $billingData; 
    }

      
function testipn(){
    
    $r = $this->buyerBasedConsumpTax(85);
    
    echo "<pre/>";
    print_r($r);die;
    
      $insert['info'] = 'test';
     $this->db->insert('test', $insert);
                      
    foreach ($_REQUEST as $key => $value) { $message .= "\n$key: $value<br>"; } 
    
    $message .= 'currentbasket'.$this->input->get('currentbasket') ; 
    $this->email->from('your@example.com', 'Your Name');
    $this->email->to('amitwali@cdnsol.com');
    $this->email->subject('subject');
    $this->email->message($message);
    $this->email->send();   
     echo "SEND";
      } 
    
    //---------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to genrate random number
    *  @modified by: lokendra meena
    *  @auther: lokendra meena
    */ 

    function createRandomNo($length=10) {
        $len        = $length;
        $base       = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
        $max        = strlen($base) - 1;
        $activatecode = '';
        mt_srand((double) microtime() * 1000000);
        while (strlen($activatecode) < $len + 1) {
            $activatecode.=$base{mt_rand(0, $max)};
        }
        return $activatecode;
    }
    
    //---------------------------------------------------------------------
    
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
    
    //-----------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use send data to paypal
    *  @modified by: lokendra meena
    */ 
    
    public function sendPaypalData(){
      
        $this->updateCart();

        $thirdPartyCartId=$this->session->userdata('thirdPartyCartId');	

        $trackId = $this->createRandomNo();
        $customerBasket['trackingId'] =$trackId;
        $this->model_common->editDataFromTabel('SalesCustomersBasket', $customerBasket, 'basketId', $thirdPartyCartId);

        $cartDetails = array();
        $userId = isLoginUser();  
        $basketItem=$this->model_cart->getUserBasketProducts($thirdPartyCartId);


        if(is_array($basketItem) && isset($basketItem) && count($basketItem)>0) {		 
            $i=0;	  	   
            foreach ($basketItem as $items) {
                         
                $cartDetails[$i]['price'] = $items->price;					
                $cartDetails[$i]['sellerPaypalId'] = $this->model_cart->sellerPaypalId($items->sellerId);
                $cartDetails[$i]['invoiceId'] = $this->model_cart->getUserInvoiceId($thirdPartyCartId,$items->sellerId);				
                $i++;			 		 
             }
                
                $getCurrency=$this->model_common->getDataFromTabel('SalesBasketItem', 'currency',  array('basketId'=>$thirdPartyCartId),'','','',1);	 	
                
                $data['senderEmail']= $this->model_cart->sellerPaypalId($userId);			
                $data['currency']  = $getCurrency[0]->currency; 
                
                        
                $data['basketItems']=$cartDetails;
                // Send data to paypal 						
                $this->Pay_parallel($data);			
         }
    }


/* Create Random Invoice Id */

  function createInvoiceId(){	
    
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
  $len = 8; 	
  $numericcode = '';  
  $numericbase = "123456789";
  $max = strlen($numericbase) - 1;
     mt_srand((double) microtime() * 1000000);

    while (strlen($numericcode) < $len + 1) {
        $numericcode.=$numericbase{mt_rand(0, $max)};        
    }
      return $alphacode.$numericcode; 

 }


 /* Send data to paypal */
 
 function Pay_parallel($data) {
    
      $currency = (isset($data['currency']) && $data['currency']==1) ? 'USD' :'EUR';  	 
      $thirdPartyCartId=$this->session->userdata('thirdPartyCartId');
      $senderEmail = (isset($senderEmail) && $senderEmail!='') ?$senderEmail :''; 
      $invoiceId =  (isset($data['invoiceId']) && $data['invoiceId']!='') ? $data['invoiceId'] :'';
      
     $res = $this->model_common->getDataFromTabel('SalesCustomersBasket', 'trackingId',  array('basketId' =>$thirdPartyCartId),'','','',1);
                
     if(isset($res[0]->trackingId) && $res[0]->trackingId !=''){
        $trackId =  $res[0]->trackingId;
     } 	 
      
    //  $trackId = $this->createRandomNo();	  
        
        // Load PayPal library
        $this->config->load('paypal');
        $config = array(
            'Sandbox' => $this->config->item('Sandbox'), 			// Sandbox / testing mode option.
            'APIUsername' => $this->config->item('APIUsername'), 	// PayPal API username of the API caller
            'APIPassword' => $this->config->item('APIPassword'), 	// PayPal API password of the API caller
            'APISignature' => $this->config->item('APISignature'), 	// PayPal API signature of the API caller
            'APISubject' => '', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
            'APIVersion' => $this->config->item('APIVersion'), 		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
            'DeviceID' => $this->config->item('DeviceID'), 
            'ApplicationID' => $this->config->item('ApplicationID'), 
            'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
        );
        $this->load->library('paypal/Paypal_adaptive', $config);				  
        
        $PayRequestFields = array(
                                'ActionType' => 'PAY', 								// Required.  Whether the request pays the receiver or whether the request is set up to create a payment request, but not fulfill the payment until the ExecutePayment is called.  Values are:  PAY, CREATE, PAY_PRIMARY
                                'CancelURL' => site_url('payment/process/cancel'), 									// Required.  The URL to which the sender's browser is redirected if the sender cancels the approval for the payment after logging in to paypal.com.  1024 char max.
                                'CurrencyCode' => $currency, 								// Required.  3 character currency code.
                                'FeesPayer' => 'EACHRECEIVER', 									// The payer of the fees.  Values are:  SENDER, PRIMARYRECEIVER, EACHRECEIVER, SECONDARYONLY
                                'IPNNotificationURL' =>site_url('payment/process/testipn/'.$trackId), 						// The URL to which you want all IPN messages for this payment to be sent.  1024 char max.
                                'Memo' => '', 										// A note associated with the payment (text, not HTML).  1000 char max
                                'Pin' => '', 										// The sener's personal id number, which was specified when the sender signed up for the preapproval
                                'PreapprovalKey' => '', 							// The key associated with a preapproval for this payment.  The preapproval is required if this is a preapproved payment.  
                                'ReturnURL' => site_url('payment/saveOrderDetails/'.$trackId), 									// Required.  The URL to which the sener's browser is redirected after approvaing a payment on paypal.com.  1024 char max.
                                'ReverseAllParallelPaymentsOnError' => '', 			// Whether to reverse paralel payments if an error occurs with a payment.  Values are:  TRUE, FALSE
                                'SenderEmail' => $senderEmail, 								// Sender's email address.  127 char max.
                                'TrackingID' => $trackId									// Unique ID that you specify to track the payment.  127 char max.
                                );
                                
        $ClientDetailsFields = array(
                                'CustomerID' => '', 								// Your ID for the sender  127 char max.
                                'CustomerType' => '', 								// Your ID of the type of customer.  127 char max.
                                'GeoLocation' => '', 								// Sender's geographic location
                                'Model' => '', 										// A sub-identification of the application.  127 char max.
                                'PartnerName' => ''									// Your organization's name or ID
                                );
                                
        //$FundingTypes = array('ECHECK', 'BALANCE', 'CREDITCARD');
        $FundingTypes = array();
        
       $Receivers = array();
       
       $toadAmount = $this->model_cart->getToadCommision($thirdPartyCartId,$data['currency']);
       
       
       $ReceiverAdmin = array(
                'Amount' => $toadAmount, 											// Required.  Amount to be paid to the receiver.
                'Email' => $this->config->item('toadAccount'), 												// Receiver's email address. 127 char max.
                'InvoiceID' => $this->createInvoiceId() , 											// The invoice number for the payment.  127 char max.
                'PaymentType' => 'SERVICE',							// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
                'PaymentSubType' => '',							// The transaction subtype for the payment.
                'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
                'Primary' => 'false'												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
            ); 
        array_push($Receivers,$ReceiverAdmin);
       
    foreach ($data['basketItems'] as $receiversdata ) {		
                        
            $Receiver = array(
                'Amount' => number_format($receiversdata['price'],2), 											// Required.  Amount to be paid to the receiver.
                'Email' => $receiversdata['sellerPaypalId'], 												// Receiver's email address. 127 char max.
                'InvoiceID' => $receiversdata['invoiceId'] , 											// The invoice number for the payment.  127 char max.
                'PaymentType' => 'SERVICE',							// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
                'PaymentSubType' => '',							// The transaction subtype for the payment.
                'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
                'Primary' => 'false'												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
            ); 
        array_push($Receivers,$Receiver);		
    }	
    
    //echo "<pre/>";
    //print_r($Receivers);die;
    
        $SenderIdentifierFields = array(
                                        'UseCredentials' => ''						// If TRUE, use credentials to identify the sender.  Default is false.
                                        );
                                        
        $AccountIdentifierFields = array(
                                        'Email' => '', 								// Sender's email address.  127 char max.
                                        'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => '')								// Sender's phone number.  Numbers only.
                                        );
                                        
        $PayPalRequestData = array(
                            'PayRequestFields' => $PayRequestFields, 
                            'ClientDetailsFields' => $ClientDetailsFields, 
                            'FundingTypes' => $FundingTypes, 
                            'Receivers' => $Receivers, 
                            'SenderIdentifierFields' => $SenderIdentifierFields, 
                            'AccountIdentifierFields' => $AccountIdentifierFields
                            );		
                            
        $PayPalResult = $this->paypal_adaptive->Pay($PayPalRequestData);		
            
        if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
        {  // echo "<pre/>";
            //print_r($PayPalResult);
            return redirect(base_url(lang().'/payment/process/paypalerror'));
        }
        else
        {
            // Successful call.  Load view or whatever you need to do here.
            header('Location: '.$PayPalResult['RedirectURL']);
            exit();
        }
    }
    
    
    function Payment_details($payKey='')
    { 
        $this->config->load('paypal');
        $config = array(
            'Sandbox' => $this->config->item('Sandbox'), 			// Sandbox / testing mode option.
            'APIUsername' => $this->config->item('APIUsername'), 	// PayPal API username of the API caller
            'APIPassword' => $this->config->item('APIPassword'), 	// PayPal API password of the API caller
            'APISignature' => $this->config->item('APISignature'), 	// PayPal API signature of the API caller
            'APISubject' => '', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
            'APIVersion' => $this->config->item('APIVersion'), 		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
            'DeviceID' => $this->config->item('DeviceID'), 
            'ApplicationID' => $this->config->item('ApplicationID'), 
            'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
        );
        $this->load->library('paypal/Paypal_adaptive', $config);	 
        //$this->testA();
        // Prepare request arrays
        $PaymentDetailsFields = array(
                                    'PayKey' => $payKey, 							// The pay key that identifies the payment for which you want to retrieve details.  
                                    'TransactionID' => '', 						// The PayPal transaction ID associated with the payment.  
                                    'TrackingID' => ''							// The tracking ID that was specified for this payment in the PayRequest message.  127 char max.
                                    );
                                    
        $PayPalRequestData = array('PaymentDetailsFields' => $PaymentDetailsFields);
        $PayPalResult = $this->paypal_adaptive->PaymentDetails($PayPalRequestData);
        
        if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
        {    echo "<pre/>";
            print_r($PayPalResult);die;
            $errors = array('Errors'=>$PayPalResult['Errors']);
            $this->load->view('paypal_error',$errors);
        }
        else
        {  echo "<pre/>";
            print_r($PayPalResult);
            // Successful call.  Load view or whatever you need to do here.	
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
    *  @description: This method is use to purchase action project/product
    *  @param: itemId
    *  @auther: lokendra meena
    *  @return: void
    */ 
 
    public function auctionpurcahse($itemId="0"){
        if(!empty($itemId)){
            $isloginUser        =   $this->isloginUser();
            $itemId             =    base64_decode($itemId);
            $sectionIdDetails         = $this->model_cart->purchaseOrderItemDetails($itemId);    
                
                
            if(!empty($sectionIdDetails)){
                $ordDateComplete            =   $sectionIdDetails->ordDateComplete;
                $remainingDayPurchase       =   daycountdown($ordDateComplete,"7");
                
                if($remainingDayPurchase > 0){
                
                    $entityId    =   $sectionIdDetails->entityId;
                    $elementId   =   $sectionIdDetails->elementId;
                    
                    $whereConditi       =    array('entityId'=>$entityId,'elementId'=>$elementId,'tdsUid'=>$isloginUser);
                    $wishlistData       =    getDataFromTabel('Wishlist', '*',  $whereConditi, '', $orderBy='', '', 1 );
                
                    if(!empty($wishlistData)){
                        $wishlistData       =       $wishlistData[0];
                       
                        $wishlistId = $wishlistData->itemId;
                        
                        //create customer basket id 
                        $thirdPartyCartId = $this->crfeateSalesCustomersBasket();  
                        
                        //call method for 
                        $isShippingStatus = $this->_wishlistitempurchase($isloginUser,$wishlistId,$thirdPartyCartId);
                        
                        $purchaseType = ($isShippingStatus)?"1":"2";
                        
                        redirect(base_url(lang().'/cart/shoppingcartbilling/'.$purchaseType)); 
                    }else{
                        $msg='wrong url entered.';
                        set_global_messages($msg, $type='error', $is_multiple=true);
                        redirect(base_url_lang('cart/mypurchases'));
                    }
                }else{
                    $msg='you can not buy it, purchase days finished.';
                    set_global_messages($msg, $type='error', $is_multiple=true);
                    redirect(base_url_lang('cart/mypurchases'));
                }
            }else{
                $msg='wrong url entered.';
                set_global_messages($msg, $type='error', $is_multiple=true);
                redirect(base_url_lang('cart/mypurchases'));
            }
        }else{
            $msg='wrong url entered.';
            set_global_messages($msg, $type='error', $is_multiple=true);
            redirect(base_url_lang('cart/mypurchases'));
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
    *  This function is used to show purchased history of logged in user
    * 
    */ 
        
    function purchase($limit='',$perPage='')
    {
        $userId=$this->isloginUser();
        $limit= (!empty($limit))? $limit :0 ;
        $perPage=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordPurchase');
        $countTotalArray=$this->model_cart->get_purchased_details($userId,0,0);
        $countTotal = $countTotalArray['get_num_rows'];
        $pages = new Pagination_ajax;
        $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
        //$pages->items_per_page=$perPage;
        
        // Add By Amit to check if cookie exists		
        $isCookie = getPerPageCookie('purchasePerPageVal',$perPage);		
        
        $pages->items_per_page=$isCookie ;
        
        $pages->paginate();
        $data['items_total'] = $pages->items_total;
        $data['items_per_page'] = $pages->items_per_page;
        $data['pagination_links'] = $pages->display_pages();	
        $data['countTotal'] = $countTotal;	
        
        $getPurchaseDetails = $this->model_cart->get_purchased_details($userId,$limit,$pages->items_per_page);
        
        //echo "<pre>";
        //print_r($getPurchaseDetails);die;
        $data['purchaseDetails'] = $getPurchaseDetails;
        $this->template->load('frontend','purchase_view',$data);
    }	
    
   
    //---------------------------------------------------------------------
   
    /*
    * @description: This method is use to show my purhcase listing 
    * @param: limit
    * @param: perpage
    * @auther: lokendra meena
    * @return: void  
    */ 
    
        
    public function mypurchases($limit='',$perPage='')
    {
        $userId=$this->isloginUser();
        $limit= (!empty($limit))? $limit :0 ;
        $perPage=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordPurchase');
        $countTotalArray=$this->model_cart->get_purchased_details($userId,0,0);
        $countTotal = $countTotalArray['get_num_rows'];
        $pages = new Pagination_ajax;
        $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
        //$pages->items_per_page=$perPage;
        
        // Add By Amit to check if cookie exists		
        $isCookie = getPerPageCookie('purchasePerPageVal',$perPage);		
        
        $pages->items_per_page=$isCookie ;
        
        $pages->paginate();
        $data['items_total']        =   $pages->items_total;
        $data['items_per_page']     =   $pages->items_per_page;
        $data['pagination_links']   =   $pages->display_pages();	
        $data['countTotal']         =   $countTotal;	
        
        $getPurchaseDetails = $this->model_cart->get_purchased_details($userId,$limit,$pages->items_per_page);
        
        //if auction project purchase then final price
        if(!empty($getPurchaseDetails['get_result'])){
            $srnumber = 0;
            foreach($getPurchaseDetails['get_result'] as $getPurchaseData){
                
                if($getPurchaseData->purchaseType=="6" && $getPurchaseData->isProductAuction=="t"){
                    $itemValue      =   $getPurchaseData->itemValue;
                    $ordCurrency    =   $getPurchaseData->ordCurrency;
                    $sellerId       =   $getPurchaseData->sellerId;
                    $entityId       =   $getPurchaseData->entityId;
                    $elementId       =   $getPurchaseData->elementId;
                    
                    // get project/product information 
                    $productPrice =  $this->getAuctionProductPrice($itemValue,$ordCurrency,$sellerId);
                    
                    // get shipping information
                    $shippingPrice       =  $this->getProductShipping($entityId,$elementId);
                    $itemValue           =  (!empty($productPrice['price']))?$productPrice['price']:0; 
                    $totalCommision      =  (!empty($productPrice['totalCommision']))?$productPrice['totalCommision']:0; 
                    
                    // get consumption tax information
                    $consumptionTaxPer   =  $this->getConsumptionTax($entityId,$elementId,$sellerId);
                    $vatPrice            =  ($itemValue*$consumptionTaxPer)/100;				
                    $finalPrice          =  $itemValue + $shippingPrice + $vatPrice + $totalCommision ;
                    $getPurchaseDetails['get_result'][$srnumber]->itemValue  =  $finalPrice;
                }
                
                $srnumber++;
            }
        }
        
       
              
        $data['purchaseDetails']            =   $getPurchaseDetails;
        $data['packagestageheading']        =   $this->lang->line('yourshoppingcart');  #set package heading
        
        //echo "<pre>";
        //print_r($data);die();
        
        $this->new_version->load('new_version','purchase_view_new',$data);
    }
    
    //---------------------------------------------------------------------
    
    /*
    *  This function is used to show purchased history of logged in user
    * 
    */ 

    function sales($limit='',$perPage='')
    {
        $userId=$this->isloginUser();
        $limit= (!empty($limit))? $limit :0 ;
        $perPage=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordSales');
        $countTotalArray=$this->model_cart->get_sales_details($userId,0,0);
        $countTotal = $countTotalArray['get_num_rows'];
        $pages = new Pagination_ajax;
        $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
        //$pages->items_per_page=$perPage;		
        
        // Add By Amit to check if cookie exists		
        $isCookie = getPerPageCookie('salesPerPageVal',$perPage);		
        
        $pages->items_per_page=$isCookie ;
        
        $pages->paginate();
        $data['items_total'] = $pages->items_total;
        $data['items_per_page'] = $pages->items_per_page;
        $data['pagination_links'] = $pages->display_pages();	
        $data['countTotal'] = $countTotal;	
        $getPurchaseDetails = $this->model_cart->get_sales_details($userId,$limit,$pages->items_per_page);
        
        //if auction project purchase then final price
        if(!empty($getPurchaseDetails['get_result'])){
            $srnumber = 0;
            foreach($getPurchaseDetails['get_result'] as $getPurchaseData){
                
                if($getPurchaseData->purchaseType=="6" && $getPurchaseData->isProductAuction=="t"){
                    $itemValue      =   $getPurchaseData->itemValue;
                    $ordCurrency    =   $getPurchaseData->ordCurrency;
                    $sellerId       =   $getPurchaseData->sellerId;
                    $entityId       =   $getPurchaseData->entityId;
                    $elementId       =   $getPurchaseData->elementId;
                    
                    // get project/product information 
                    $productPrice =  $this->getAuctionProductPrice($itemValue,$ordCurrency,$sellerId);
                    
                    // get shipping information
                    $shippingPrice       =  $this->getProductShipping($entityId,$elementId);
                    $itemValue           =  (!empty($productPrice['price']))?$productPrice['price']:0; 
                    $totalCommision      =  (!empty($productPrice['totalCommision']))?$productPrice['totalCommision']:0; 
                    
                    // get consumption tax information
                    $consumptionTaxPer   =  $this->getConsumptionTax($entityId,$elementId,$sellerId);
                    $vatPrice            =  ($itemValue*$consumptionTaxPer)/100;				
                    $finalPrice          =  $itemValue + $shippingPrice + $vatPrice + $totalCommision ;
                    $getPurchaseDetails['get_result'][$srnumber]->itemValue  =  $finalPrice;
                }
                
                $srnumber++;
            }
        }
        
        $data['purchaseDetails'] = $getPurchaseDetails;
        $this->template->load('frontend','sales_view',$data);
    }
    
    //---------------------------------------------------------------------
    
    /*
    *  @description: This method is use to show sales listing
    *  @param: $limit
    *  @param: $perpage
    *  @modifiedbyy: lokendra meena
    *  @return: void
    */ 
    
    function mysales($limit='',$perPage=''){
        $userId=$this->isloginUser();
        $limit= (!empty($limit))? $limit :0 ;
        $perPage=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordSales');
        $countTotalArray=$this->model_cart->get_sales_details($userId,0,0);
        $countTotal = $countTotalArray['get_num_rows'];
        $pages = new Pagination_new_ajax;
        $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
        //$pages->items_per_page=$perPage;		
        
        // Add By Amit to check if cookie exists		
        $isCookie = getPerPageCookie('salesPerPageVal',$perPage);		
        
        $pages->items_per_page=$isCookie ;
        
        $pages->paginate();
        $data['items_total'] = $pages->items_total;
        $data['items_per_page'] = $pages->items_per_page;
        $data['pagination_links'] = $pages->display_pages();	
        $data['countTotal'] = $countTotal;	
        $getPurchaseDetails = $this->model_cart->get_sales_details($userId,$limit,$pages->items_per_page);
        $data['purchaseDetails'] = $getPurchaseDetails;
        $this->new_version->load('new_version','sales_view_new',$data);
    }
    
    //----------------------------------------------------------------------
    
    /***
     *  
     *  This function will be call when ajax pagination will be call sales view
     * 
     ****/
    
    function sales_view()
    {
        $userId=$this->isloginUser();
        $countTotalArray=$this->model_cart->get_sales_details($userId,0,0);
        $countTotal = $countTotalArray['get_num_rows'];
        $pages = new Pagination_ajax;
        $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
        //$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$this->config->item('perPageRecordSales');		
        $perPage = $this->config->item('perPageRecordSales');
        // ADD by Amit to set cookie		
        $isSetCookie = setPerPageCookie('salesPerPageVal',$perPage);		
        
        $pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$isSetCookie;
        
        
        $pages->paginate();
        $data['items_total'] = $pages->items_total;
        $data['items_per_page'] = $pages->items_per_page;
        $data['pagination_links'] = $pages->display_pages();
        $data['countTotal'] = $countTotal;	
        $getPurchaseDetails = $this->model_cart->get_sales_details($userId,$pages->offst,$pages->items_per_page);
        $data['purchaseDetails'] = $getPurchaseDetails;
        $this->load->view("sales_view_container",$data);
    }
    
    /*
     ************************************************
     * This function update shipping details  
     ************************************************ 
     */  
     
     
    
    function shipping_details_submit()
    {
        $shipping_details_data = $this->input->post('shipping_details_data');
        $itemId = $this->input->post('item_id');
        $updateDate = array('shpStatus' => '1','shippingDetails'=>$shipping_details_data);
        $this->model_cart->shipping_update($itemId, $updateDate);
        echo '<div id="shipping_details_shipped">
                                    <div style="line-height: 17px;" class="fl ml20 clr_333 width_240">
                                    '.$shipping_details_data.'
                                    </div>	 
                            </div>';
    }
    
    
    //----------------------------------------------------------------------
    
     function productshipped()
    {
        $formId      = $this->input->post('formId');
        $itemId      = $this->input->post('item_id_'.$formId);
        $shipdetails = $this->input->post('shipdetails_'.$formId);
        $updateDate  = array('shpStatus' => '1','shippingDetails' => $shipdetails);
        $this->model_cart->shipping_update($itemId, $updateDate);
        echo "status updated"; 
    }
    
    
    /*
     ************************************************
     * This function update shipping item recieved
     ************************************************ 
     */  
    
    function shipping_recieved_submit()
    {
        $itemId = $this->input->post('item_id');
        $updateDate = array('shpStatus' => '2');
        $this->model_cart->shipping_update($itemId, $updateDate);
        $whereCondition=array('itemId'=>$itemId);
        $resLogSummary=getDataFromTabel('SalesItemShipping', 'shippingDetails',  $whereCondition, '', $orderBy='', '', 1 );
        echo '<div id="shipping_details_shipped">
                                    <div style="line-height: 17px;" class="fl ml20 clr_333 width_240">
                                    '.$resLogSummary[0]->shippingDetails.'
                                    </div>	 
                            </div>';
    }
    
    
    //-------------------------------------------------------------------------
    
    /*
    * @description: This method is use to update product recevied status and details
    * @auther: lokendra meena
    * @return: string
    */ 
    
    public function productrecevied(){
        $formId      = $this->input->post('formId');
        $itemId      = $this->input->post('item_id_'.$formId);
        $shipdetails = $this->input->post('shipdetails_'.$formId);
        $updateDate  = array('shpStatus' => '2','shippingDetails' => $shipdetails);
        $this->model_cart->shipping_update($itemId, $updateDate);
        echo "status updated"; 
    }
    
    
    
    
    
    /***
     *  
     *  This function will be call when ajax pagination will be call
     * 
     * ***/
    
    function purchase_view()
    {
        $userId=$this->isloginUser();
        $countTotalArray=$this->model_cart->get_purchased_details($userId,0,0);
        $countTotal = $countTotalArray['get_num_rows'];
        $pages = new Pagination_ajax;
        $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
        //$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$this->config->item('perPageRecordPurchase');
        
        $perPage = $this->config->item('perPageRecordPurchase');
        // ADD by Amit to set cookie		
        $isSetCookie = setPerPageCookie('purchasePerPageVal',$perPage);		
        
        $pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$isSetCookie;
        
        
        $pages->paginate();
        $data['items_total'] = $pages->items_total;
        $data['items_per_page'] = $pages->items_per_page;
        $data['pagination_links'] = $pages->display_pages();
        $data['countTotal'] = $countTotal;	
        $getPurchaseDetails = $this->model_cart->get_purchased_details($userId,$pages->offst,$pages->items_per_page);
        $data['purchaseDetails'] = $getPurchaseDetails;
        $this->load->view("purchase_view_container",$data);
    }
    
    /*
     * This function is used to show comment view 
     * 
     */
    
    
    function comment_on_purchase()
    {
        $userId=$this->isloginUser();
        $entityId = $this->input->get('val1');
        $elementId = $this->input->get('val2');
        $ordId = $this->input->get('val3');
        $itemId = $this->input->get('val4');
        $ownerId = $this->input->get('val5');
        
        //get purchase comment
        $getPurchaseComment = $this->model_cart->getPurchaseComment($ordId);
        
        /****************get product  image  start **************/
        
        $sectionWhere = array('itemId'=>$itemId);
        
        $sectionIdDetails=getDataFromTabel('SalesOrderItem', 'sectionId, itemName, sellerInfo, purchaseType',  $sectionWhere, '', $orderBy='', '', 1 );
        
        if($sectionIdDetails)
        {
            $sectionIdDetails = $sectionIdDetails[0];											
            $sectionId = $sectionIdDetails->sectionId;
            $itemTitle = $sectionIdDetails->itemName;
            $sellerInfoData = json_decode($sectionIdDetails->sellerInfo);
            $purchaseType = $sectionIdDetails->purchaseType;
            
            
        }else
        {										
            $sectionId = 0;
            $itemTitle = '';
            $sellerInfoData = $sectionIdDetails->sellerInfo;
            $purchaseType = $sectionIdDetails->purchaseType;
        }
    
        //this condition for if purchase type 5
        if($purchaseType=='5')
        {
            $entityId = $sellerInfoData->entityIdPE;
            $elementId = $sellerInfoData->eventORlaunchId;
        }
        
        $geMediaImage = $this->getImageInfo($entityId,$elementId,$sectionId);
        
        /****************get product  image  end **************/
        
        $data['getPurchaseComment'] = $getPurchaseComment;
        $data['entityId'] = $entityId;
        $data['elementId'] = $elementId;
        $data['geMediaImage'] = $geMediaImage;
        $data['projName'] = $itemTitle;
        $data['ownerId'] = $ownerId;
        $data['ordId'] = $ordId;
        $data['itemId'] = $itemId;
            
        $this->load->view('purchase_comment',$data);
    
    }
    
   //------------------------------------------------------------------------
    
    /*
    *  @description: This method is use to show comment purchase 
    *  @return: void
    *  @auther: lokendra meena
    */ 
    
    function commentonpurchase()
    {
        $userId=$this->isloginUser();
        $entityId = $this->input->get('val1');
        $elementId = $this->input->get('val2');
        $ordId = $this->input->get('val3');
        $itemId = $this->input->get('val4');
        $ownerId = $this->input->get('val5');
        
        //get purchase comment
        $getPurchaseComment = $this->model_cart->getPurchaseComment($ordId);
        
        /****************get product  image  start **************/
        
        $sectionWhere = array('itemId'=>$itemId);
        
        $sectionIdDetails=getDataFromTabel('SalesOrderItem', 'sectionId, itemName, sellerInfo, purchaseType',  $sectionWhere, '', $orderBy='', '', 1 );
        
        if($sectionIdDetails)
        {
            $sectionIdDetails = $sectionIdDetails[0];											
            $sectionId = $sectionIdDetails->sectionId;
            $itemTitle = $sectionIdDetails->itemName;
            $sellerInfoData = json_decode($sectionIdDetails->sellerInfo);
            $purchaseType = $sectionIdDetails->purchaseType;
            
            
        }else
        {										
            $sectionId = 0;
            $itemTitle = '';
            $sellerInfoData = $sectionIdDetails->sellerInfo;
            $purchaseType = $sectionIdDetails->purchaseType;
        }
    
        //this condition for if purchase type 5
        if($purchaseType=='5')
        {
            $entityId = $sellerInfoData->entityIdPE;
            $elementId = $sellerInfoData->eventORlaunchId;
        }
        
        $geMediaImage = $this->getImageInfo($entityId,$elementId,$sectionId);
        
        /****************get product  image  end **************/
        
        $data['getPurchaseComment'] = $getPurchaseComment;
        $data['entityId'] = $entityId;
        $data['elementId'] = $elementId;
        $data['geMediaImage'] = $geMediaImage;
        $data['projName'] = $itemTitle;
        $data['ownerId'] = $ownerId;
        $data['ordId'] = $ordId;
        $data['itemId'] = $itemId;
            
        $this->load->view('purchase_comment_new',$data);
    }
    
    /*
     **********************************************
     * This function is used to show seller info
     ******************************************** 
     */  
    
    
    function sellerInfo()
    {
        $itemId = $this->input->get('val1');
        
        $getResult = $this->model_cart->getInvoiceSellerInfo($itemId);
        $getSellerDetail = json_decode($getResult['get_result']->sellerInfo);
        
        $invoiceId =$this->getInvoice($itemId);
        $data['invoiceId'] = $invoiceId;
        
        $userCountryName = $this->model_cart->getUserCountryName($getSellerDetail->territoryCountryId);
        $getSellerDetail->territoryCountryId = $userCountryName->countryName;
        $getSellerDetail->seller_state = getstateName($getSellerDetail->seller_state);
        $data['getSellerDetail'] = $getSellerDetail;
        $data['PurchaseRecord'] = $getResult['get_result'];
        $this->load->view('seller_info',$data);
    }
    
    
   //--------------------------------------------------------------------------
   
    /*
     *  @description: This method is use to show seller info 
     *  @return: void
     *  @auther: lokendra meena
     */   
    
    
    function sellerInfoNew()
    {
        $itemId             =   $this->input->get('val1');
        
        $getResult          =   $this->model_cart->getInvoiceSellerInfo($itemId);
        $getSellerDetail    =   json_decode($getResult['get_result']->sellerInfo);
        
        //get sales invoice number
        $invoiceId          =   $this->getInvoice($itemId);
        $data['invoiceId']  =   $invoiceId;
        
        $userCountryName = $this->model_cart->getUserCountryName($getSellerDetail->territoryCountryId);
        $getSellerDetail->territoryCountryId = $userCountryName->countryName;
        $getSellerDetail->seller_state = getstateName($getSellerDetail->seller_state);
        $data['getSellerDetail'] = $getSellerDetail;
        $data['PurchaseRecord'] = $getResult['get_result'];
        $this->load->view('seller_info_new',$data);
    }
    
    /*
     **********************************************
     * This function is used to show seller info
     ******************************************** 
     */  
    
    
    function buyerInfo()
    {
        $itemId = $this->input->get('val1');
        $getResult = $this->model_cart->getInvoiceSellerInfo($itemId);
        
        $invoiceId =$this->getInvoice($itemId);
        $data['invoiceId'] = $invoiceId;			
        
        $data['PurchaseRecord'] = $getResult;
        $this->load->view('buyer_info',$data);
    }
    
    
    //---------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to show buyyer infomatin
    *  @auther: lokendra meena
    *  @return: string
    */ 
    
    function buyerInfoNew()
    {
        $itemId = $this->input->get('val1');
        $getResult = $this->model_cart->getInvoiceSellerInfo($itemId);
        
        $invoiceId =$this->getInvoice($itemId);
        $data['invoiceId'] = $invoiceId;			
        
        $data['PurchaseRecord'] = $getResult;
        $this->load->view('buyer_info_new',$data);
    }
    
    /*
     **********************************************
     *  This function is used to Open Popun Sign in to meeting point
     ******************************************** 
     */  
    
    
    function singInToMeetingPoint()
    {
        $userId=$this->isloginUser();
        $itemId = $this->input->get('val1');
        $sectionWhere = array('itemId'=>$itemId);
        $getSalesOrderDetails=getDataFromTabel('SalesOrderItem', 'sellerInfo',  $sectionWhere, '', $orderBy='', '', 1 );
        $sellerInfo = json_decode($getSalesOrderDetails[0]->sellerInfo);
        $SessionId = $sellerInfo->SessionId;
        $meetingCondtion = array('session_id'=>$SessionId,'user_id'=>$userId);
        
        $getMeetingPoingData=getDataFromTabel('MeetingPoint', 'session_id',  $meetingCondtion, '', $orderBy='', '', 1 );
        
        if($getMeetingPoingData)
        {
            $isShowClassButon ="dn";
            $isShowClassNotButton="";
        }else
        {
            $isShowClassButon ="";
            $isShowClassNotButton="dn";
        }
        $data['isShowClassButon'] = $isShowClassButon;
        $data['isShowClassNotButton'] = $isShowClassNotButton;
        $data['SessionId'] = $SessionId;
        $data['itemId'] = $itemId;
        $this->load->view('sign_in_meeting_point',$data);
    }
    
    
    /*
     *************************************** 
     * Meeting point insert 
     *************************************** 
     */ 
     
    function meetingPoingInsert()
    {
        $userId=$this->isloginUser();  
        $itemId = $this->input->post('item_id');
        $sectionWhere = array('itemId'=>$itemId);
        $getSalesOrderDetails=getDataFromTabel('SalesOrderItem', 'sellerInfo',  $sectionWhere, '', $orderBy='', '', 1 );
        $sellerInfo = json_decode($getSalesOrderDetails[0]->sellerInfo);
        //TDS_Events
        if($sellerInfo->entityIdPE==9)
        {
            $eventId = $sellerInfo->eventORlaunchId;
            $launchId = 0;
        }
        //this for TDS_LaunchEvent
        if($sellerInfo->entityIdPE==15)
        {
            $eventId = 0;
            $launchId = $sellerInfo->eventORlaunchId;
        }
        $SessionId = $sellerInfo->SessionId;
        $meetingPointData =array('event_id'=>$eventId,'launch_id'=>$launchId,'session_id'=>$SessionId,'user_id'=>$userId); 
        $meetingCondtion = array('session_id'=>$SessionId,'user_id'=>$userId);
        $getMeetingPoingData=getDataFromTabel('MeetingPoint', 'session_id',  $meetingCondtion, '', $orderBy='', '', 1 );
        //data already inserted 
        if($getMeetingPoingData)
        {
            echo "dn";
        }
        else
        {
            $this->model_cart->meetingPointInsert($meetingPointData);
            echo "dn";
        }
    }  
    
    /*
     * This function is used to insert user purchase commnet
     * 
     */ 

    function purchase_comment_insert()
    {
        $userId=$this->isloginUser();
        $ownerId = $this->input->post('ownerId');
        $ordId = $this->input->post('ordId');
        $itemId = $this->input->post('itemId');
        $rate_seller = $this->input->post('rate_seller');
        $user_comment = $this->input->post('user_comment');
        
        
        
        $comment_data =array('tdsUid'=>$userId,
        'ownerId'=>$ownerId,
        'orderId'=>$ordId,
        'itemId'=>$itemId,
        'rateSeller'=>$rate_seller,
        'comments'=>$user_comment);
            
        $this->model_cart->comments_insert($comment_data);	
    
        echo "Thank you.";
    }
    
    
    /*
     * This function is used to update purchase commnet
     * 
     */ 
    
    function purchase_comment_update()
    {
        //rate_seller=&user_comment=test&save=Save&ajaxHit=1
        $commentId = $this->input->post('commentId');
        $comment = $this->input->post('user_comment');
        $rate_seller = $this->input->post('rate_seller');
        
        $comment_data =array('rateSeller'=>$rate_seller,'comments'=>$comment);
        
        $this->model_cart->comments_update($commentId, $comment_data);	
        echo "Thank you.";	
    }
    
    /*
     *  This function is used to show sales records
     * 
     */ 
     
        
    function sales_record($getOrderId=0)
    {
        $userId=$this->isloginUser();
        $getPurchaseRecord = $this->model_cart->get_purchased_record($getOrderId,$userId);
        
        //echo "<pre>";
        //print_r($getPurchaseRecord);die;
        
        if($getPurchaseRecord['get_num_rows']==0)
        {
            redirect('cart/purchase');
        }
        
        $entityId = $getPurchaseRecord['get_result']->entityId;
        $elementId = $getPurchaseRecord['get_result']->elementId;
        $ownerId = $getPurchaseRecord['get_result']->sellerId;
        
        $getSellerDetail = json_decode($getPurchaseRecord['get_result']->sellerInfo);
        
        $userCountryName = $this->model_cart->getUserCountryName($getSellerDetail->territoryCountryId);
        
        $getSellerDetail->territoryCountryId = $userCountryName->countryName;
        
        $getSellerDetail->seller_state = getstateName($getSellerDetail->seller_state);
        
        $getItemsDetils = $this->model_cart->getItemsDetils($getOrderId);
        
        
        
        $data['getSellerDetail'] = $getSellerDetail;
        $data['getItemsDetils'] = $getItemsDetils;
        $data['PurchaseRecord'] = $getPurchaseRecord;
        $data['orderId'] = $getOrderId;
        $this->template->load('frontend','sales_record',$data);
        
        
        /*$getPurchaseRecord = $getPurchaseRecord['get_result'];
        
        $getItemsDetils = $getItemsDetils['get_result'];
        
        $where=array('purpose'=>'itempurchaseddetails','active'=>1);
        $purchasedItemTemplate=getDataFromTabel('EmailTemplates','templates',  $where, '','', '', 1 );
                
                
        $purchasedItemTemplate=$purchasedItemTemplate[0]->templates;
        $purchasedItem="";
        foreach($getItemsDetils as $getItemsDetils)
        {		
            $searchArray = array("{item_name}");
            $replaceArray = array('AKON');
            $purchasedItem.=str_replace($searchArray, $replaceArray, $purchasedItemTemplate);
        
        }
        
        
        $where=array('purpose'=>'itempurchasedtemplate','active'=>1);
        $purchasedTemplate=getDataFromTabel('EmailTemplates','templates',  $where, '','', '', 1 );
                
                
        $purchasedTemplate=$purchasedTemplate[0]->templates;
        
        
        $searchArray = array("{base_url}","{sale_order_date}", "{sale_order_no}","{item_body}");
        $replaceArray = array(base_url(),date("d F Y g:i A",strtotime($getPurchaseRecord->ordDateComplete)), $getPurchaseRecord->ordNumber,$purchasedItem);
        $detailsPurchaseTemplate=str_replace($searchArray, $replaceArray, $purchasedTemplate);
        
        echo $detailsPurchaseTemplate;*/
        
        
        
        
    }	
    
    
    /*
     * **********************************************
     *  This function only for testing purpose
     * **********************************************
     */ 
     
        
    function sales_record_email($getOrderId=0)
    {
        $getOrderId= 60;
        $userId=$this->isloginUser();
        $getPurchaseRecord = $this->model_cart->get_purchased_record($getOrderId,$userId);
        
        //echo "<pre>";
        //print_r($getPurchaseRecord);die;
        
        if($getPurchaseRecord['get_num_rows']==0)
        {
            redirect('cart/purchase');
        }
        
        $entityId = $getPurchaseRecord['get_result']->entityId;
        $elementId = $getPurchaseRecord['get_result']->elementId;
        $ownerId = $getPurchaseRecord['get_result']->sellerId;
        
        $getSellerDetail = json_decode($getPurchaseRecord['get_result']->sellerInfo);
        
        $userCountryName = $this->model_cart->getUserCountryName($getSellerDetail->territoryCountryId);
        
        $getSellerDetail->territoryCountryId = $userCountryName->countryName;
        
        $getSellerDetail->seller_state = getstateName($getSellerDetail->seller_state);
        
        $getItemsDetils = $this->model_cart->getItemsDetils($getOrderId);
        
        
        
        $data['getSellerDetail'] = $getSellerDetail;
        $data['getItemsDetils'] = $getItemsDetils;
        $data['PurchaseRecord'] = $getPurchaseRecord;
        $data['orderId'] = $getOrderId;
        //$this->template->load('frontend','sales_record',$data);
        
        
        $getPurchaseRecord = $getPurchaseRecord['get_result'];
        
        $getItemsDetils = $getItemsDetils['get_result'];
        
        $where=array('purpose'=>'itempurchaseddetails','active'=>1);
        $purchasedItemTemplate=getDataFromTabel('EmailTemplates','templates',  $where, '','', '', 1 );
                
                
        $purchasedItemTemplate=$purchasedItemTemplate[0]->templates;
        $purchasedItem="";
        foreach($getItemsDetils as $getItemsDetils)
        {		
            $searchArray = array("{item_name}");
            $replaceArray = array('AKON');
            $purchasedItem.=str_replace($searchArray, $replaceArray, $purchasedItemTemplate);
        
        }
        
        
        $where=array('purpose'=>'itempurchasedtemplate','active'=>1);
        $purchasedTemplate=getDataFromTabel('EmailTemplates','templates',  $where, '','', '', 1 );
                
                
        $purchasedTemplate=$purchasedTemplate[0]->templates;
        
        
        $searchArray = array("{base_url}","{sale_order_date}", "{sale_order_no}","{item_body}");
        $replaceArray = array(base_url(),date("d F Y g:i A",strtotime($getPurchaseRecord->ordDateComplete)), $getPurchaseRecord->ordNumber,$purchasedItem);
        $detailsPurchaseTemplate=str_replace($searchArray, $replaceArray, $purchasedTemplate);
        
        echo $detailsPurchaseTemplate;
        
        
        
        
    }
    
    
    /*
     *  This function is used to show sales records print view 
     * 
     */ 
     
        
    function sales_record_print($getItemId=0)
    {
        $getItemId= $getItemId;
        $userId=$this->isloginUser();
        $getPurchaseRecord = $this->model_cart->get_purchased_record($getItemId,$userId);
        
        
        //echo "<pre>";
        //print_r($getPurchaseRecord);die;
        
        // This check if record is not exist then rediect 
        if($getPurchaseRecord['get_num_rows']==0)
        {
            redirect('cart/sales_order');
        }
        // This check if login user id is not equal to customerUid and SellerID
        if($getPurchaseRecord['get_result']->customerUid!= $userId && $getPurchaseRecord['get_result']->sellerId!= $userId)
        {
            redirect('cart/sales_order');
        }
        $invoiceId = $getPurchaseRecord['get_result']->invoiceId;
        
        $entityId = $getPurchaseRecord['get_result']->entityId;
        $elementId = $getPurchaseRecord['get_result']->elementId;
        $ownerId = $getPurchaseRecord['get_result']->sellerId;
        $purchaseType = $getPurchaseRecord['get_result']->purchaseType;
        
        $getSellerDetail = json_decode($getPurchaseRecord['get_result']->sellerInfo);
        
        // if seller info blank then no show seller section
        if(!empty($getSellerDetail)){
            $userCountryName = $this->model_cart->getUserCountryName($getSellerDetail->territoryCountryId);
            $getSellerDetail->territoryCountryId = $userCountryName->countryName;
            $getSellerDetail->seller_state = getstateName($getSellerDetail->seller_state);
        }
        
        $getItemsDetils = $this->model_cart->getItemsDetils($invoiceId);
        
        $isTakingShipping = $this->model_cart->isTakingShipping($invoiceId);
        $isEvent = ($purchaseType=='5') ? 'yes': 'no';
        //get event type
        if($purchaseType=='5')
        {
            $getSessionId = $getSellerDetail->SessionId;
            $get_Session_Details = $this->model_cart->get_Session_Details($getSessionId);
            $data['getSessionDetails'] = $get_Session_Details['get_result'];
        }
        
        $data['getSellerDetail'] = $getSellerDetail;
        $data['getItemsDetils'] = $getItemsDetils;
        $data['PurchaseRecord'] = $getPurchaseRecord;
        $data['isShipping'] = $isTakingShipping;
        
        $data['isEventDate'] = $isEvent;
        
        
        //$this->template->load('frontend','sales_record',$data);
        $this->load->view('sales_record_print',$data);
        
        
    }
    
    
    
    /*
     ***********************
     * This function is used to show sales records
     *********************** 
     */ 
     
        
    function membership_print($getOrderId=0)
    {
        $userId=$this->isloginUser();
        $membershipOrderDetails = $this->model_cart->membership_order_details($getOrderId,$userId);
        
        //echo "<pre>";
        //print_r($membershipOrderDetails);die;
        
        // This check if record is not exist then rediect 
        if($membershipOrderDetails['get_num_rows']==0)
        {
            redirect(base_url('home'));
        }
        
        $get_membership_item = $this->model_cart->get_membership_item($getOrderId);
        
        $getBuyerDetail = json_decode($membershipOrderDetails['get_result']->buyerInfo);
        
        $userCountryName = $this->model_cart->getUserCountryName($getBuyerDetail->billing_country);
        
        $getBuyerDetail->billing_country = $userCountryName->countryName;
        
        $getBuyerDetail->billing_state = getstateName($getBuyerDetail->billing_state);
        
        $membershipOrderDetails['get_result']->buyerInfo = json_encode($getBuyerDetail);
        
        $membershipOrderDetails = $membershipOrderDetails['get_result'];
        
        $data['get_membership_item'] = $get_membership_item;
    
    
        $data['membershipOrderDetails'] = $membershipOrderDetails;
        
        //$this->template->load('frontend','sales_record',$data);
    //1 year and 3 year membership print
    if($membershipOrderDetails->orderType==3)
    { 
      $this->load->view('membership_print',$data);
    }else{
      // tool puchase print
      $this->load->view('tool_membership_print',$data);
    }
        
        
    }
    
    
    
    /*
     *  This function is used to show sales order
     * 
     */ 
     
        
    function sales_order()
    {
        $userId=$this->isloginUser();
        $from_date="";
        $to_date="";
        $elementId=0;
        
        //this for pagination get post value
        if($this->uri->segment('5') && $this->uri->segment('6'))
        {
            $from_date = base64_decode($this->uri->segment('5'));
            $to_date = base64_decode($this->uri->segment('6'));
        }
        
        //this for searched filter date 
        if($this->input->get('from_date') && $this->input->get('to_date'))
        {
            $from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');
        }
        if($this->input->get('elementId'))
        {
            $elementId = $this->input->get('elementId');
        }
        
        /**************get data for pagination*************/
        $countTotalArray=$this->model_cart->get_sales_record_by_invoice($userId,$from_date,$to_date,0,0,$elementId);
        //$countTotalArray=$this->model_cart->get_sales_record($userId,$from_date,$to_date,0,0,$elementId);
        $countTotal = $countTotalArray['get_num_rows'];
        $pages = new Pagination_ajax;
        $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
        $pages->paginate();
        $pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):10;
    
        $data['items_total'] = $pages->items_total;
        $data['items_per_page'] = $pages->items_per_page;
        $data['pagination_links'] = $pages->display_pages();
        $data['countTotal'] = $countTotal;
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['elementId'] = $elementId;
        
        $get_sales_record_by_invoice = $this->model_cart->get_sales_record_by_invoice($userId,$from_date,$to_date,$pages->offst,$pages->items_per_page,$elementId);
        
        //echo "<pre>";
        
        $get_sales_record['get_num_rows']='';
        $get_sales_record['get_result']=''; 
        
        
        if($get_sales_record_by_invoice['get_num_rows'] > 0)
        {
            $countAdd = 0;
            
            foreach($get_sales_record_by_invoice['get_result']  as $sales_record_by_invoice)
            {
                
                $getSalesRecord =  $this->model_cart->get_sales_record($sales_record_by_invoice->invoiceId);
                if($getSalesRecord['get_num_rows'] > 0)
                {
                    $get_sales_record['get_result'][$countAdd] = $getSalesRecord['get_result'];  
                    $countAdd++;
                }
            
            }
            $get_sales_record['get_num_rows'] =	$countAdd;
        }
        
        $data['get_sales_record'] = $get_sales_record;
        
        $checkIsView= $this->uri->segment('4');
         
        //show view if clicked on pagination 
        if($checkIsView=='yes')
        {
            $this->load->view('sales_order_container',$data);
            
        }else
        {
            $this->template->load('frontend','sales_order',$data);
        }	
    }	
    
    
    /*
     *  This function is used to show sales order
     * 
     */ 
     
        
    function sales_information()
    {
        $userId=$this->isloginUser();
        $from_date="";
        $to_date="";
        
        $show_by = "day";
        
        if($this->input->get('show_by'))
        {
            $show_by = $this->input->get('show_by');
        }
        
        //this for searched filter date 
        if($this->input->get('from_date') && $this->input->get('to_date'))
        {
            $from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');
        }
        
        //this for date post by pagination
        if($this->input->get('pagi_from_date') && $this->input->get('pagi_to_date'))
        {
            $from_date = base64_decode($this->input->get('pagi_from_date'));
            $to_date = base64_decode($this->input->get('pagi_to_date'));
        }
        
        //echo $from_date.'=='.$to_date;
        
        $showData = array();
        
            //show sales information by day wise
            if($show_by=="day")
            {
                $countTotalArray = $this->model_cart->get_sales_information($userId,$from_date,$to_date,0,0);
                
                
                /**********pagination code start here***********/
                
                $countTotal = $countTotalArray['get_num_rows'];
                
                $pages = new Pagination_ajax;
                $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
                
                //$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$this->config->item('perPageRecordSalesInfo');
                $data['perPageRecord'] = $this->config->item('perPageRecordSalesInfo');
                
                // Add by Amit to set cookie for Results per page
                if($this->input->post('ipp')!=''){
                    $isCookie = setPerPageCookie('salesInfoPerPageVal',$data['perPageRecord']);	
                }else {
                    $isCookie = getPerPageCookie('salesInfoPerPageVal',$data['perPageRecord']);		
                }

                $pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;			
                
                $pages->paginate();
                $data['items_total'] = $pages->items_total;
                $data['items_per_page'] = $pages->items_per_page;
                $data['pagination_links'] = $pages->display_pages();
                $data['countTotal'] = $countTotal;
                
                /**********pagination code end here***********/
                
                $get_sales_information = $this->model_cart->get_sales_information($userId,$from_date,$to_date,$pages->offst,$pages->items_per_page);
                
                if($get_sales_information['get_num_rows'] > 0)
                {   
                    $j=0;
                    
                    foreach($get_sales_information['get_result'] as  $sales_information)
                    {
                        if($sales_information->ordDateComplete!="")
                        {
                            $salesDate= $sales_information->ordDateComplete;
                            $sales_info_day_wise = $this->model_cart->sales_info_day_wise($userId, $salesDate);
                            $sales_info_day_wise['showDate'] = $salesDate;
                            $sales_info_day_wise['showType'] = 'day';
                            $showData[$j]  = $sales_info_day_wise;
                            $j++;
                        }	
                    }
                }
                
                $queryString ="show_by=$show_by&pagi_from_date=".base64_encode($from_date)."&pagi_to_date=".base64_encode($to_date); 
            }	
        
            //show sale information by month wise
            if($show_by=="month")
            {
                if($from_date=="" && $to_date=="")
                {
                    $from_date =  "1970-1-1";
                    $to_date =  date("Y-m-d");
                }
                
                $countTotalArray = $this->model_cart->salesInfoMonthWiseByDate($userId,$from_date,$to_date,0,0);
                
                /**********pagination code start here***********/
                
                $countTotal = $countTotalArray['get_num_rows'];
                
                $pages = new Pagination_ajax;
                $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
                $pages->paginate();
                $pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):10;
            
                $data['items_total'] = $pages->items_total;
                $data['items_per_page'] = $pages->items_per_page;
                $data['pagination_links'] = $pages->display_pages();
                $data['countTotal'] = $countTotal;
                
                /**********pagination code end here***********/
                
                
                $get_salesInfoMonthWiseByDate = $this->model_cart->salesInfoMonthWiseByDate($userId,$from_date,$to_date,$pages->offst,$pages->items_per_page);
                
                if($get_salesInfoMonthWiseByDate['get_num_rows'] > 0)
                {
                    $z=0;
                    foreach($get_salesInfoMonthWiseByDate['get_result'] as $salesInfoMonthWiseByDate)
                    {
                        $start_date =  date("Y-m-d",strtotime($salesInfoMonthWiseByDate->date_trunc));
                        $get_to_date=  date("Y-m-d",strtotime($salesInfoMonthWiseByDate->date_trunc));
                        $get_to_date_arr=explode("-",$get_to_date);
                        $end_date = $get_to_date_arr[0].'-'.$get_to_date_arr[1].'-'.'31';
                        
                        $getSalesInfoMonthWise = $this->model_cart->sales_info_month_wise($userId,$start_date,$end_date);
                            
                        if($getSalesInfoMonthWise['get_num_rows'] > 0)
                        {
                            $getSalesInfoMonthWise['showDate'] = $start_date;
                            $getSalesInfoMonthWise['showType'] = 'month';
                            $showData[$z] = $getSalesInfoMonthWise; 
                            $z++;
                        }
                        
                    }
                    
                }
                
                $queryString ="show_by=$show_by&pagi_from_date=".base64_encode($from_date)."&pagi_to_date=".base64_encode($to_date); 
            }	
        
            //show sale information by year wise
            if($show_by=="year")
            {
                if($from_date=="" && $to_date=="")
                {
                    $from_date =  "1970-1-1";
                    $to_date =  date("Y-m-d");
                    $from_date_year = $from_date;
                    $to_date_year = $to_date;
                }else
                {
                    $from_date_year = date("Y-m",strtotime($from_date))."-1";
                    $to_date_year = date("Y-m",strtotime($to_date))."-1";
                }
                
                $countTotalArray = $this->model_cart->salesInfoYearWiseByDate($userId,$from_date_year,$to_date_year,0,0);
                
                /**********pagination code start here***********/
                
                $countTotal = $countTotalArray['get_num_rows'];
                
                $pages = new Pagination_ajax;
                $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
                $pages->paginate();
                $pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):10;
            
                $data['items_total'] = $pages->items_total;
                $data['items_per_page'] = $pages->items_per_page;
                $data['pagination_links'] = $pages->display_pages();
                $data['countTotal'] = $countTotal;
                
                /**********pagination code end here***********/
                
                $get_salesInfoYearWiseByDate = $this->model_cart->salesInfoYearWiseByDate($userId,$from_date_year,$to_date_year,$pages->offst,$pages->items_per_page);
                
                if($get_salesInfoYearWiseByDate['get_num_rows'] > 0)
                {
                    $z=0;
                    foreach($get_salesInfoYearWiseByDate['get_result'] as $salesInfoYearWiseByDate)
                    {
                        $start_date =  date("Y-m-d",strtotime($salesInfoYearWiseByDate->date_trunc));
                        $get_to_date=  date("Y-m-d",strtotime($salesInfoYearWiseByDate->date_trunc));
                        $get_to_date_arr=explode("-",$get_to_date);
                        $end_date = $get_to_date_arr[0].'-'.'12-31';
                        
                        $getSalesInfoMonthWise = $this->model_cart->sales_info_month_wise($userId,$start_date,$end_date);
                            
                        if($getSalesInfoMonthWise['get_num_rows'] > 0)
                        {
                            $getSalesInfoMonthWise['showDate'] = $start_date;
                            $getSalesInfoMonthWise['showType'] = 'month';
                            $showData[$z] = $getSalesInfoMonthWise; 
                            $z++;
                        }
                        
                    }
                    
                }
                
                
                $queryString ="show_by=$show_by&pagi_from_date=".base64_encode($from_date)."&pagi_to_date=".base64_encode($to_date); 
            }
        
        
            //echo "<pre>";
            
            //show sale information by project wise
            if($show_by=="project")
            {
                $projID="";
                if($this->input->get('projId'))
                {
                    $projId = $this->input->get('projId');
                    $projID = $projId;
                    
                    $getProjectWiseSales = $this->model_cart->getProjectWiseSales($projId,$userId);
                    
                    $data['countTotal'] = $getProjectWiseSales['get_num_rows'];
                    
                    if($getProjectWiseSales['get_num_rows'] > 0)
                    {
                        $entityID = 	$getProjectWiseSales['get_result']->entityId;
                        
                        /*************Here check project Id available on element Id*********/
                        $check_projId_exist = $this->model_cart->check_projId_exist($userId,$projId);
                        
                        
                        if($check_projId_exist['get_num_rows'] > 0)
                        {
                            $getProjectWiseSales['get_result']->projItemName = $check_projId_exist['get_result'][0]->itemName;
                            $getProjectWiseSales['get_result']->isProjBlank = "no";
                            
                        }else
                        {
                            $getProjectWiseSales['get_result']->projItemName  = "";
                            $getProjectWiseSales['get_result']->isProjBlank = "yes";
                        }
                        
                        $getProjectWiseSales['get_result']->projType = $this->get_project_type($entityID,$projId);
                        
                        /******************Here get Element by projId********/
                        
                        
                        $get_elementwise_sales = $this->model_cart->get_elementwise_sales($userId,$projId);
                        if($get_elementwise_sales['get_num_rows'] > 0)
                        {
                            $getProjectWiseSales['get_result']->projElement = $get_elementwise_sales['get_result']; 
                            
                        }else
                        {
                            $getProjectWiseSales['get_result']->projElement = array();
                            
                        }
                    }
                    $getResultArray= array($getProjectWiseSales['get_result']);
                    $getProjectWiseSales['get_result'] = $getResultArray;
                    $showData = $getProjectWiseSales;
                    
                }else
                {
                
                    $countTotalArray = $this->model_cart->get_projectwise_sales($userId,0,0);
                
                    /**********pagination code start here***********/
                    
                    $countTotal = $countTotalArray['get_num_rows'];
                    $pages = new Pagination_ajax;
                    $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
                    $pages->paginate();
                    $pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):10;
                
                    $data['items_total'] = $pages->items_total;
                    $data['items_per_page'] = $pages->items_per_page;
                    $data['pagination_links'] = $pages->display_pages();
                    $data['countTotal'] = $countTotal;
                    
                    /**********pagination code end here***********/
                
                    $get_projectwise_sales = $this->model_cart->get_projectwise_sales($userId,$pages->offst,$pages->items_per_page);
                    
                    //print_r($get_projectwise_sales);
                    
                    if($get_projectwise_sales['get_num_rows'] > 0)
                    {
                    
                        foreach($get_projectwise_sales['get_result'] as $projectwise_sales)
                        {
                            $projId = 	$projectwise_sales->projId;
                            $entityID = 	$projectwise_sales->entityId;
                            
                            /*************Here check project Id available on element Id*********/
                            $check_projId_exist = $this->model_cart->check_projId_exist($userId,$projId);
                            
                            if($check_projId_exist['get_num_rows'] > 0)
                            {
                                $projectwise_sales->projItemName = $check_projId_exist['get_result'][0]->itemName;
                                $projectwise_sales->isProjBlank = "no";
                                
                            }else
                            {
                                $projectwise_sales->projItemName  = "";
                                $projectwise_sales->isProjBlank = "yes";
                            }
                            
                            
                            $projectwise_sales->projType = $this->get_project_type($entityID,$projId);
                            
                            
                            /******************Here get Element by projId********/
                            
                            
                            $get_elementwise_sales = $this->model_cart->get_elementwise_sales($userId,$projId);
                            if($get_elementwise_sales['get_num_rows'] > 0)
                            {
                                $projectwise_sales->projElement = $get_elementwise_sales['get_result']; 
                                
                            }else
                            {
                                $projectwise_sales->projElement = array();
                                
                            }
                        }
                    }	
                    
                    $showData = $get_projectwise_sales;
                }
                
                $queryString ="show_by=$show_by&pagi_from_date=".base64_encode($from_date)."&pagi_to_date=".base64_encode($to_date)."&projId=$projID"; 
            }	
        
        
        //echo "<pre>";	
        //print_r($showData);die;	
        
        if($this->input->get('from_date') && $this->input->get('to_date'))
        {
            $from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');
            /****************use dates for only date, month and year**************/
            
            $data['from_date']= date("d F Y",strtotime($from_date));
            
            $data['to_date']= date("d F Y",strtotime($to_date));
            
            /****************use dates for only month and year**************/
            
            $data['from_date_1']= date("F Y",strtotime($from_date));
            
            $data['to_date_1']= date("F Y",strtotime($to_date));
        }else
        {
            /****************use dates for only date, month and year**************/
            
            $data['from_date']= "";
            
            $data['to_date']= "";
            
            /****************use dates for only month and year**************/
            
            $data['from_date_1']= "";
            
            $data['to_date_1']= "";
        }
        
        
        $data['get_sales_information'] = $showData;
        
        $data['show_by']= $show_by;
        
        $data['queryString']= $queryString;
    
        
        if($this->input->get('isPagi'))
        {
            $isProjView = $this->input->get('isProjView');
            if($isProjView=="yes")
            {
                $this->load->view("sales_info_with_pro",$data);
            }else
            {
                $this->load->view("sales_info_without_pro",$data);
            }	
            
        }else
        {
            $this->template->load('frontend','sales_information',$data);
        }	
    }	
    
    
    //-----------------------------------------------------------------------
    
    /*
    * @description: This function is used to show sales order
    * @return: void
    * @auther: lokendra meena
    */ 
    
    function salesinformation()
    {
        $userId=$this->isloginUser();
        $from_date="";
        $to_date="";
        
        $show_by = "day";
        
        if($this->input->get('show_by'))
        {
            $show_by = $this->input->get('show_by');
        }
        
        //this for searched filter date 
        if($this->input->get('from_date') && $this->input->get('to_date'))
        {
            $from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');
        }
        
        //this for date post by pagination
        if($this->input->get('pagi_from_date') && $this->input->get('pagi_to_date'))
        {
            $from_date = base64_decode($this->input->get('pagi_from_date'));
            $to_date = base64_decode($this->input->get('pagi_to_date'));
        }
        
        //echo $from_date.'=='.$to_date;
        
        $showData = array();
        
            //show sales information by day wise
            if($show_by=="day")
            {
                $countTotalArray = $this->model_cart->get_sales_information($userId,$from_date,$to_date,0,0);
                
                
                /**********pagination code start here***********/
                
                $countTotal = $countTotalArray['get_num_rows'];
                
                $pages = new Pagination_new_ajax;
                $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
                
                //$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$this->config->item('perPageRecordSalesInfo');
                $data['perPageRecord'] = $this->config->item('perPageRecordSalesInfo');
                
                // Add by Amit to set cookie for Results per page
                if($this->input->post('ipp')!=''){
                    $isCookie = setPerPageCookie('salesInfoPerPageVal',$data['perPageRecord']);	
                }else {
                    $isCookie = getPerPageCookie('salesInfoPerPageVal',$data['perPageRecord']);		
                }

                $pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;			
                
                $pages->paginate();
                $data['items_total'] = $pages->items_total;
                $data['items_per_page'] = $pages->items_per_page;
                $data['pagination_links'] = $pages->display_pages();
                $data['countTotal'] = $countTotal;
                
                /**********pagination code end here***********/
                
                $get_sales_information = $this->model_cart->get_sales_information($userId,$from_date,$to_date,$pages->offst,$pages->items_per_page);
                
                if($get_sales_information['get_num_rows'] > 0)
                {   
                    $j=0;
                    
                    foreach($get_sales_information['get_result'] as  $sales_information)
                    {
                        if($sales_information->ordDateComplete!="")
                        {
                            $salesDate= $sales_information->ordDateComplete;
                            $sales_info_day_wise = $this->model_cart->sales_info_day_wise($userId, $salesDate);
                            $sales_info_day_wise['showDate'] = $salesDate;
                            $sales_info_day_wise['showType'] = 'day';
                            $showData[$j]  = $sales_info_day_wise;
                            $j++;
                        }	
                    }
                }
                
                $queryString ="show_by=$show_by&pagi_from_date=".base64_encode($from_date)."&pagi_to_date=".base64_encode($to_date); 
            }	
        
            //show sale information by month wise
            if($show_by=="month")
            {
                if($from_date=="" && $to_date=="")
                {
                    $from_date =  "1970-1-1";
                    $to_date =  date("Y-m-d");
                }
                
                $countTotalArray = $this->model_cart->salesInfoMonthWiseByDate($userId,$from_date,$to_date,0,0);
                
                /**********pagination code start here***********/
                
                $countTotal = $countTotalArray['get_num_rows'];
                
                $pages = new Pagination_new_ajax;
                $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
                $pages->paginate();
                $pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):10;
            
                $data['items_total'] = $pages->items_total;
                $data['items_per_page'] = $pages->items_per_page;
                $data['pagination_links'] = $pages->display_pages();
                $data['countTotal'] = $countTotal;
                
                /**********pagination code end here***********/
                
                
                $get_salesInfoMonthWiseByDate = $this->model_cart->salesInfoMonthWiseByDate($userId,$from_date,$to_date,$pages->offst,$pages->items_per_page);
                
                if($get_salesInfoMonthWiseByDate['get_num_rows'] > 0)
                {
                    $z=0;
                    foreach($get_salesInfoMonthWiseByDate['get_result'] as $salesInfoMonthWiseByDate)
                    {
                        $start_date =  date("Y-m-d",strtotime($salesInfoMonthWiseByDate->date_trunc));
                        $get_to_date=  date("Y-m-d",strtotime($salesInfoMonthWiseByDate->date_trunc));
                        $get_to_date_arr=explode("-",$get_to_date);
                        $end_date = $get_to_date_arr[0].'-'.$get_to_date_arr[1].'-'.'31';
                        
                        $getSalesInfoMonthWise = $this->model_cart->sales_info_month_wise($userId,$start_date,$end_date);
                            
                        if($getSalesInfoMonthWise['get_num_rows'] > 0)
                        {
                            $getSalesInfoMonthWise['showDate'] = $start_date;
                            $getSalesInfoMonthWise['showType'] = 'month';
                            $showData[$z] = $getSalesInfoMonthWise; 
                            $z++;
                        }
                        
                    }
                    
                }
                
                $queryString ="show_by=$show_by&pagi_from_date=".base64_encode($from_date)."&pagi_to_date=".base64_encode($to_date); 
            }	
        
            //show sale information by year wise
            if($show_by=="year")
            {
                if($from_date=="" && $to_date=="")
                {
                    $from_date =  "1970-1-1";
                    $to_date =  date("Y-m-d");
                    $from_date_year = $from_date;
                    $to_date_year = $to_date;
                }else
                {
                    $from_date_year = date("Y-m",strtotime($from_date))."-1";
                    $to_date_year = date("Y-m",strtotime($to_date))."-1";
                }
                
                $countTotalArray = $this->model_cart->salesInfoYearWiseByDate($userId,$from_date_year,$to_date_year,0,0);
                
                /**********pagination code start here***********/
                
                $countTotal = $countTotalArray['get_num_rows'];
                
                $pages = new Pagination_new_ajax;
                $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
                $pages->paginate();
                $pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):10;
            
                $data['items_total'] = $pages->items_total;
                $data['items_per_page'] = $pages->items_per_page;
                $data['pagination_links'] = $pages->display_pages();
                $data['countTotal'] = $countTotal;
                
                /**********pagination code end here***********/
                
                $get_salesInfoYearWiseByDate = $this->model_cart->salesInfoYearWiseByDate($userId,$from_date_year,$to_date_year,$pages->offst,$pages->items_per_page);
                
                if($get_salesInfoYearWiseByDate['get_num_rows'] > 0)
                {
                    $z=0;
                    foreach($get_salesInfoYearWiseByDate['get_result'] as $salesInfoYearWiseByDate)
                    {
                        $start_date =  date("Y-m-d",strtotime($salesInfoYearWiseByDate->date_trunc));
                        $get_to_date=  date("Y-m-d",strtotime($salesInfoYearWiseByDate->date_trunc));
                        $get_to_date_arr=explode("-",$get_to_date);
                        $end_date = $get_to_date_arr[0].'-'.'12-31';
                        
                        $getSalesInfoMonthWise = $this->model_cart->sales_info_month_wise($userId,$start_date,$end_date);
                            
                        if($getSalesInfoMonthWise['get_num_rows'] > 0)
                        {
                            $getSalesInfoMonthWise['showDate'] = $start_date;
                            $getSalesInfoMonthWise['showType'] = 'month';
                            $showData[$z] = $getSalesInfoMonthWise; 
                            $z++;
                        }
                        
                    }
                    
                }
                
                
                $queryString ="show_by=$show_by&pagi_from_date=".base64_encode($from_date)."&pagi_to_date=".base64_encode($to_date); 
            }
        
        
            //echo "<pre>";
            
            //show sale information by project wise
            if($show_by=="project")
            {
                $projID="";
                if($this->input->get('projId'))
                {
                    $projId = $this->input->get('projId');
                    $projID = $projId;
                    
                    $getProjectWiseSales = $this->model_cart->getProjectWiseSales($projId,$userId);
                    
                    $data['countTotal'] = $getProjectWiseSales['get_num_rows'];
                    
                    if($getProjectWiseSales['get_num_rows'] > 0)
                    {
                        $entityID = 	$getProjectWiseSales['get_result']->entityId;
                        
                        /*************Here check project Id available on element Id*********/
                        $check_projId_exist = $this->model_cart->check_projId_exist($userId,$projId);
                        
                        
                        if($check_projId_exist['get_num_rows'] > 0)
                        {
                            $getProjectWiseSales['get_result']->projItemName = $check_projId_exist['get_result'][0]->itemName;
                            $getProjectWiseSales['get_result']->isProjBlank = "no";
                            
                        }else
                        {
                            $getProjectWiseSales['get_result']->projItemName  = "";
                            $getProjectWiseSales['get_result']->isProjBlank = "yes";
                        }
                        
                        $getProjectWiseSales['get_result']->projType = $this->get_project_type($entityID,$projId);
                        
                        /******************Here get Element by projId********/
                        
                        
                        $get_elementwise_sales = $this->model_cart->get_elementwise_sales($userId,$projId);
                        if($get_elementwise_sales['get_num_rows'] > 0)
                        {
                            $getProjectWiseSales['get_result']->projElement = $get_elementwise_sales['get_result']; 
                            
                        }else
                        {
                            $getProjectWiseSales['get_result']->projElement = array();
                            
                        }
                    }
                    $getResultArray= array($getProjectWiseSales['get_result']);
                    $getProjectWiseSales['get_result'] = $getResultArray;
                    $showData = $getProjectWiseSales;
                    
                }else
                {
                
                    $countTotalArray = $this->model_cart->get_projectwise_sales($userId,0,0);
                
                    /**********pagination code start here***********/
                    
                    $countTotal = $countTotalArray['get_num_rows'];
                    $pages = new Pagination_new_ajax;
                    $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
                    $pages->paginate();
                    $pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):10;
                
                    $data['items_total'] = $pages->items_total;
                    $data['items_per_page'] = $pages->items_per_page;
                    $data['pagination_links'] = $pages->display_pages();
                    $data['countTotal'] = $countTotal;
                    
                    /**********pagination code end here***********/
                
                    $get_projectwise_sales = $this->model_cart->get_projectwise_sales($userId,$pages->offst,$pages->items_per_page);
                    
                    //print_r($get_projectwise_sales);
                    
                    if($get_projectwise_sales['get_num_rows'] > 0)
                    {
                    
                        foreach($get_projectwise_sales['get_result'] as $projectwise_sales)
                        {
                            $projId = 	$projectwise_sales->projId;
                            $entityID = 	$projectwise_sales->entityId;
                            
                            /*************Here check project Id available on element Id*********/
                            $check_projId_exist = $this->model_cart->check_projId_exist($userId,$projId);
                            
                            if($check_projId_exist['get_num_rows'] > 0)
                            {
                                $projectwise_sales->projItemName = $check_projId_exist['get_result'][0]->itemName;
                                $projectwise_sales->isProjBlank = "no";
                                
                            }else
                            {
                                $projectwise_sales->projItemName  = "";
                                $projectwise_sales->isProjBlank = "yes";
                            }
                            
                            
                            $projectwise_sales->projType = $this->get_project_type($entityID,$projId);
                            
                            
                            /******************Here get Element by projId********/
                            
                            
                            $get_elementwise_sales = $this->model_cart->get_elementwise_sales($userId,$projId);
                            if($get_elementwise_sales['get_num_rows'] > 0)
                            {
                                $projectwise_sales->projElement = $get_elementwise_sales['get_result']; 
                                
                            }else
                            {
                                $projectwise_sales->projElement = array();
                                
                            }
                        }
                    }	
                    
                    $showData = $get_projectwise_sales;
                }
                
                $queryString ="show_by=$show_by&pagi_from_date=".base64_encode($from_date)."&pagi_to_date=".base64_encode($to_date)."&projId=$projID"; 
            }	
        
        
        //echo "<pre>";	
        //print_r($showData);die;	
        
        if($this->input->get('from_date') && $this->input->get('to_date'))
        {
            $from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');
            /****************use dates for only date, month and year**************/
            
            $data['from_date']= date("d F Y",strtotime($from_date));
            
            $data['to_date']= date("d F Y",strtotime($to_date));
            
            /****************use dates for only month and year**************/
            
            $data['from_date_1']= date("F Y",strtotime($from_date));
            
            $data['to_date_1']= date("F Y",strtotime($to_date));
        }else
        {
            /****************use dates for only date, month and year**************/
            
            $data['from_date']= "";
            
            $data['to_date']= "";
            
            /****************use dates for only month and year**************/
            
            $data['from_date_1']= "";
            
            $data['to_date_1']= "";
        }
        
        
        $data['get_sales_information'] = $showData;
        
        $data['show_by']= $show_by;
        
        $data['queryString']= $queryString;
        
        $data['packagestageheading'] 	    =   'Your Shopping Cart';  #set package heading
    
        
        
        
        if($this->input->get('isPagi'))
        {
            $isProjView = $this->input->get('isProjView');
            if($isProjView=="yes")
            {
                $this->load->view("sales_info_with_pro_new",$data);
            }else
            {
                $this->load->view("sales_info_without_pro_new",$data);
            }	
            
        }else
        {
            $this->new_version->load('new_version','sales_information_new',$data);
        }	
    }
    
    /*
     *  This function project type by entity ID
     * 
     */ 
     
     
    
    
    function get_project_type($entityID,$projId)
    {
        if($entityID=="49")
        {
            $projType="Product";
        }
        
        if($entityID=="54")
        {
            
            $whereArr = array('projId'=>$projId);
            $getIndustryType=getDataFromTabel('Project', 'IndustryId',  $whereArr, '', $orderBy='', '', 1 );
            if($getIndustryType)
            {
                $getIndustryType = $getIndustryType[0];
                
                
                switch($getIndustryType->IndustryId)
                {
                    case 1:
                    case 10:
                    case 2:
                    case 3:
                    $projType = "Project";
                    break;
                    
                    case 4:
                    $projType = "Album";
                    break;
                    
                    default:
                    $projType = "No Type";
                }
                
            }else
            {
                $projType="No Type";
            }
        }
        
        if($entityID!="49" && $entityID!="54")
        {
            
            switch($entityID)
            {
                case 12:
                case 7:
                case 25:
                case 84:
                $projType = "Project";
                break;
                
                case 47:
                $projType = "Album";
                break;
                
                default:
                $projType = "No Type";
            }
            
            
        
        }	
        
        return $projType;
    }
    
    
    
    /*
     ********************************************
     *  This function is used to show Show ticekt AttendeesList
     ******************************************** 
     */ 
     
    //Generate ticket attendees listing
    function showAttendeesList($sessionId=0)
    {
        if($sessionId!=0){
            //Get sessions ticket transaction details
            $ticketSessionList = $this->model_common->ticketTransactionListing($sessionId);
            
            //Get session data
            $session_data = $this->model_common->ticket_session_data($sessionId);
            
            //Get Event details
            if(isset($session_data->eventId) && !empty($session_data->eventId)){
                $event_data = $this->model_common->ticket_event_data($session_data->eventId);
            }elseif(isset($session_data->launchEventId) && !empty($session_data->launchEventId)){
                $event_data = $this->model_common->ticket_launch_data($session_data->launchEventId);
            }else{
                $event_data = "";
            }
            $data['sessionVanue'] = isset($session_data->venueName) && !empty($session_data->venueName) ?$session_data->venueName:'';
            $ticketdata['eventTitle'] = isset($event_data->Title) && !empty($event_data->Title) ?$event_data->Title:'';
            $ticketdata['sessionDate'] = isset($ticketSessionList[0]->date) && !empty($ticketSessionList[0]->date) ?$ticketSessionList[0]->date:'';
            $ticketdata['ticketSessionList'] = $ticketSessionList;
            $ticketTransactionData[] = $ticketdata;
        } else{
            //Get all sessions ticket transaction details
            $sessionData = $this->model_common->ticketSession();
            //$ticketTransactionData = array();
            foreach($sessionData as $sessionData){
                $ticketSessionList = $this->model_common->ticketTransactionListing($sessionData->sessionId);
                //Get session data
                $session_data = $this->model_common->ticket_session_data($sessionData->sessionId);
                //Get Event details
                if(isset($session_data->eventId) && !empty($session_data->eventId)){
                    $event_data = $this->model_common->ticket_event_data($session_data->eventId);
                }else{
                    $event_data = $this->model_common->ticket_launch_data($session_data->launchEventId);
                }
                
                $ticketdata['eventTitle'] = $event_data->Title;
                $ticketdata['sessionDate'] = $sessionData->date;
                $ticketdata['ticketSessionList'] = $ticketSessionList;
                $ticketTransactionData[] = $ticketdata;
            }
        }
        
        $data['ticketTransactionData'] =  $ticketTransactionData;
        $this->load->view('ticketAttendeeList',$data) ;			
    } 
    
    
    
    
    /*
     ******************************************** 
     * This section for download event tickets
     ******************************************** 
     */ 
    
    function get_event_ticket_pdf($eventInvoiceId=0)
    {	
        if($eventInvoiceId != '0'){
            
            $eventInvoiceData = $this->model_common->ticket_invoice_data($eventInvoiceId);
            if(isset($eventInvoiceData) && !empty($eventInvoiceData)){
                $data['eventInvoiceData'] =  $eventInvoiceData;
                $data['isDownload'] =  'yes';
                $this->load->view('ticketPdf',$data) ;	
            }else{
                redirectToNorecord404();
            }
        }else{
            redirectToNorecord404();
        }
    }
    
    
    
    
    /*
     ***********************************************
     * This function is used to export sales into cvs file 
     ***********************************************  
     */ 

        function salesExportToCSV()
        {
            $this->load->helper('csv');
            $this->load->helper('inflector');
            $userId=$this->isloginUser();
            $getPurchaseDetails=$this->model_cart->salesDetailsForExport($userId);
            
            $RowArray="";
            $count=0;
            foreach($getPurchaseDetails['get_first_row']  as $rowOfHeader)
            {
                $RowArray[0][$count] =  humanize($rowOfHeader); 
                $count++;
            }
            $RowArray[0][$count] =  humanize("Total"); 
            // This code for  listing of record
            if($getPurchaseDetails['get_num_rows'] > 0)
            {
                $serialNumber=1;	
                $count=1;
                foreach($getPurchaseDetails['get_result']  as $resultPurchase)
                {
                    $itemPrice = ($resultPurchase['price']*$resultPurchase['qty']);
                    $totalAmount= $itemPrice + $resultPurchase['tsCommissionValue'];
                    $currencySign = ($resultPurchase['currency']==1)?"Dollar":"Euro";
                    $RowArray[$count][0] = date("d-F-Y",strtotime($resultPurchase['date']));
                    $RowArray[$count][1] = getInvoiceId($resultPurchase['invoice']);
                    $RowArray[$count][2] = ucwords($resultPurchase['buyer']);
                    $RowArray[$count][3] = $resultPurchase['item'];
                    $RowArray[$count][4] = $resultPurchase['qty'];
                    $RowArray[$count][5] = $currencySign;
                    $RowArray[$count][6] = $resultPurchase['price'];
                    $RowArray[$count][7] = $resultPurchase['taxName'];
                    $RowArray[$count][8] = $resultPurchase['taxPercent'];
                    $RowArray[$count][9] = $resultPurchase['taxValue'];
                    $RowArray[$count][10] = $resultPurchase['shipping'];
                    $RowArray[$count][11] = $resultPurchase['tsCommissionPercent'];
                    $RowArray[$count][12] = $resultPurchase['tsCommissionValue'];
                    $RowArray[$count][13] = $resultPurchase['tsVatPercent'];
                    $RowArray[$count][14] = $resultPurchase['tsVatValue'];
                    $RowArray[$count][15] = $resultPurchase['tsGrossCommision'];
                    $RowArray[$count][16] = getPurchaseType($resultPurchase['purchaseType']);
                    $RowArray[$count][17] = $totalAmount;
                    $count++;
                }
            }
            
            $filename="sales_".date("d_M_Y").".csv";
            array_to_csv($RowArray, $filename);
        }	
        
        
        
    /*
     ***********************************************
     * This function is used to all export sales for Admin
     ***********************************************  
     */ 

        function AllSalesExportToCSV()
        {
            $this->load->helper('csv');
            $this->load->helper('inflector');
            $userId=$this->isloginUser();
            $getPurchaseDetails=$this->model_cart->AllSalesDetailsForExport();
            
            $RowArray="";
            $count=0;
            foreach($getPurchaseDetails['get_first_row']  as $rowOfHeader)
            {
                $RowArray[0][$count] =  humanize($rowOfHeader); 
                $count++;
            }
            $RowArray[0][$count] =  humanize("Total"); 
            // This code for  listing of record
            if($getPurchaseDetails['get_num_rows'] > 0)
            {
                $serialNumber=1;	
                $count=1;
                foreach($getPurchaseDetails['get_result']  as $resultPurchase)
                {
                    $sellerInfo= json_decode($resultPurchase['sellername']);
                    if(isset($sellerInfo) && $sellerInfo!="") { $sellerName = $sellerInfo->firstName.' '.$sellerInfo->lastName; }else { $sellerName ==""; }
                    $itemPrice = ($resultPurchase['price']*$resultPurchase['qty']);
                    $totalAmount= $itemPrice + $resultPurchase['tsCommissionValue'];
                    $currencySign = ($resultPurchase['currency']==1)?"Dollar":"Euro";
                    $RowArray[$count][0] = date("d-F-Y",strtotime($resultPurchase['date']));
                    $RowArray[$count][1] = getInvoiceId($resultPurchase['invoice']);
                    $RowArray[$count][2] = ucwords($resultPurchase['buyer']);
                    $RowArray[$count][3] = $resultPurchase['item'];
                    $RowArray[$count][4] = $resultPurchase['qty'];
                    $RowArray[$count][5] = ucwords($sellerName);
                    $RowArray[$count][6] = $currencySign;
                    $RowArray[$count][7] = $resultPurchase['price'];
                    $RowArray[$count][8] = $resultPurchase['taxName'];
                    $RowArray[$count][9] = $resultPurchase['taxPercent'];
                    $RowArray[$count][10] = $resultPurchase['taxValue'];
                    $RowArray[$count][11] = $resultPurchase['shipping'];
                    $RowArray[$count][12] = $resultPurchase['tsCommissionPercent'];
                    $RowArray[$count][13] = $resultPurchase['tsCommissionValue'];
                    $RowArray[$count][14] = $resultPurchase['tsVatPercent'];
                    $RowArray[$count][15] = $resultPurchase['tsVatValue'];
                    $RowArray[$count][16] = $resultPurchase['tsGrossCommision'];
                    $RowArray[$count][17] = getPurchaseType($resultPurchase['purchaseType']);
                    $RowArray[$count][18] = $totalAmount;
                    $count++;
                }
            }
            
            $filename="sales_".date("d_M_Y").".csv";
            array_to_csv($RowArray, $filename);
        }	
    
    
    
    /*
     ***********************************************
     * This function is used to export sales information into cvs file 
     ***********************************************  
     */ 

        function salesInfoExportToCSV($from_date='',$to_date='')
        {
            $this->load->helper('csv');
            $this->load->helper('inflector');
            if($from_date!="" && $to_date!="")
            {
                $from_date =  base64_decode($from_date);
                $to_date =  base64_decode($to_date);
            }else
            {
                $from_date =  "";
                $to_date =  "";
            }
            
            $userId=$this->isloginUser();
            $getPurchaseDetails=$this->model_cart->salesInfoDetailsForExport($userId,$from_date,$to_date);
            
            $RowArray="";
            $count=0;
            foreach($getPurchaseDetails['get_first_row']  as $rowOfHeader)
            {
                $RowArray[0][$count] =  humanize($rowOfHeader); 
                $count++;
            }
            $RowArray[0][$count] =  humanize("Total"); 
            // This code for  listing of record
            if($getPurchaseDetails['get_num_rows'] > 0)
            {
                $serialNumber=1;	
                $count=1;
                foreach($getPurchaseDetails['get_result']  as $resultPurchase)
                {
                    $itemPrice = ($resultPurchase['price']*$resultPurchase['qty']);
                    $totalAmount= $itemPrice + $resultPurchase['tsCommissionValue'];
                    $currencySign = ($resultPurchase['currency']==1)?"Dollar":"Euro";
                    $RowArray[$count][0] = date("d-F-Y",strtotime($resultPurchase['date']));
                    $RowArray[$count][1] = getInvoiceId($resultPurchase['invoice']);
                    $RowArray[$count][2] = ucwords($resultPurchase['buyer']);
                    $RowArray[$count][3] = $resultPurchase['item'];
                    $RowArray[$count][4] = $resultPurchase['qty'];
                    $RowArray[$count][5] = $currencySign;
                    $RowArray[$count][6] = $resultPurchase['price'];
                    $RowArray[$count][7] = $resultPurchase['taxName'];
                    $RowArray[$count][8] = $resultPurchase['taxPercent'];
                    $RowArray[$count][9] = $resultPurchase['taxValue'];
                    $RowArray[$count][10] = $resultPurchase['shipping'];
                    $RowArray[$count][11] = $resultPurchase['tsCommissionPercent'];
                    $RowArray[$count][12] = $resultPurchase['tsCommissionValue'];
                    $RowArray[$count][13] = $resultPurchase['tsVatPercent'];
                    $RowArray[$count][14] = $resultPurchase['tsVatValue'];
                    $RowArray[$count][15] = $resultPurchase['tsGrossCommision'];
                    $RowArray[$count][16] = getPurchaseType($resultPurchase['purchaseType']);
                    $RowArray[$count][17] = $totalAmount;
                    $count++;
                }
            }
            
            $filename="sales_information_".date("d_M_Y").".csv";
            array_to_csv($RowArray, $filename);
        }
    
    
    
    
    
    
    function testMail(){
        
        // $r = $this->input->post('payment_status') ;;
              
        //  $r =  $this->input->post('payment_status') ; 	 
        $this->email->from('your@example.com', 'Your Name');
        $this->email->to('amitwali@cdnsol.com');
        $this->email->subject('subject');
        $this->email->message('r');
        $this->email->send();
        echo "MAIL SEND";
     }
     
     
     
/* Get attachment to  send attachment with mailto: in buyer_info */
     
    function getInvoice($itemId=0){		
        
        $invoiceId  = '0'; //set default
        $where = array('itemId'=>$itemId);
        $transId=getDataFromTabel('SalesOrderItem', 'receiverTransactionId',  $where , '', $orderBy='', '', 1 );

        $transId= (isset($transId[0]->receiverTransactionId) && ($transId[0]->receiverTransactionId!='')) ? $transId[0]->receiverTransactionId : 0;
       
        //check transaction id 
        if(!empty($transId)){
            $invoiceId = getInvoiceId($transId);		
            $data['invoiceId'] = $invoiceId;	
        }
        return $invoiceId;
        
    
    }
    
    
    function adminExport(){
        
        echo '<a href="'.base_url().'cart/AllSalesExportToCSV">All Sales Export</a>';
        echo '<br><br><a href="'.base_url().'package/allmembershipexporttocsv">All Membership Export</a>';
        
        
        }
        
        
  /* Delete Wishlist Item */		
     function deleteWishlistItem(){		
        $ID =  $this->input->post('val1');
        $tbl = $this->input->post('val2');
        $field = $this->input->post('val3');	
        $this->model_common->deleteRowFromTabel($tbl, $field, $ID);		 		
        return true;
        
     }
     
  
  /* TEST PARALLEL PAYMENT IN LIVE */   
    function testPay(){
        
        
        // Load PayPal library
        $this->config->load('paypal');
        $config = array(
            'Sandbox' => $this->config->item('Sandbox'), 			// Sandbox / testing mode option.
            'APIUsername' => $this->config->item('APIUsername'), 	// PayPal API username of the API caller
            'APIPassword' => $this->config->item('APIPassword'), 	// PayPal API password of the API caller
            'APISignature' => $this->config->item('APISignature'), 	// PayPal API signature of the API caller
            'APISubject' => '', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
            'APIVersion' => $this->config->item('APIVersion'), 		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
            'DeviceID' => $this->config->item('DeviceID'), 
            'ApplicationID' => $this->config->item('ApplicationID'), 
            'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
        );
        $this->load->library('paypal/Paypal_adaptive', $config);		
    
    
        // Prepare request arrays
        $PayRequestFields = array(
                                'ActionType' => 'PAY', 								// Required.  Whether the request pays the receiver or whether the request is set up to create a payment request, but not fulfill the payment until the ExecutePayment is called.  Values are:  PAY, CREATE, PAY_PRIMARY
                                'CancelURL' => site_url('paypal/adaptive_payments/pay_cancel'), 									// Required.  The URL to which the sender's browser is redirected if the sender cancels the approval for the payment after logging in to paypal.com.  1024 char max.
                                'CurrencyCode' => 'EUR', 								// Required.  3 character currency code.
                                'FeesPayer' => 'SENDER', 									// The payer of the fees.  Values are:  SENDER, PRIMARYRECEIVER, EACHRECEIVER, SECONDARYONLY
                                'IPNNotificationURL' =>base_url(lang().'/membershipcart/test'), 						// The URL to which you want all IPN messages for this payment to be sent.  1024 char max.
                                'Memo' => '', 										// A note associated with the payment (text, not HTML).  1000 char max
                                'Pin' => '', 										// The sener's personal id number, which was specified when the sender signed up for the preapproval
                                'PreapprovalKey' => '', 							// The key associated with a preapproval for this payment.  The preapproval is required if this is a preapproved payment.  
                                'ReturnURL' => site_url('paypal/adaptive_payments/pay_return'), 									// Required.  The URL to which the sener's browser is redirected after approvaing a payment on paypal.com.  1024 char max.
                                'ReverseAllParallelPaymentsOnError' => '', 			// Whether to reverse paralel payments if an error occurs with a payment.  Values are:  TRUE, FALSE
                                'SenderEmail' => '', 								// Sender's email address.  127 char max.
                                'TrackingID' => ''
                                                                    // Unique ID that you specify to track the payment.  127 char max.
                                );
                                
        $ClientDetailsFields = array(
                                'CustomerID' => '', 								// Your ID for the sender  127 char max.
                                'CustomerType' => '', 								// Your ID of the type of customer.  127 char max.
                                'GeoLocation' => '', 								// Sender's geographic location
                                'Model' => '', 										// A sub-identification of the application.  127 char max.
                                'PartnerName' => ''									// Your organization's name or ID
                                );
                                
        //$FundingTypes = array("ECHECK", "CREDITCARD", "BALANCE");
        $FundingTypes = array();
        
        $Receivers = array();
        $Receiver = array(
                        'Amount' => 10, 											// Required.  Amount to be paid to the receiver.
                        'Email' => 'accounts@toadsquare.com', 												// Receiver's email address. 127 char max.
                        'InvoiceID' => '101', 											// The invoice number for the payment.  127 char max.
                        'PaymentType' => 'SERVICE', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
                        'PaymentSubType' =>'' , 									// The transaction subtype for the payment.
                        'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
         'Primary' => False												
// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
                        );
        array_push($Receivers,$Receiver);
        
        $Receiver = array(
                        'Amount' => '10', 											// Required.  Amount to be paid to the receiver.
                        'Email' => 'saul.rudnick@optusnet.com.au', 												// Receiver's email address. 127 char max.
                        'InvoiceID' => '102', 											// The invoice number for the payment.  127 char max.
                        'PaymentType' => 'SERVICE', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
                        'PaymentSubType' => '', 									// The transaction subtype for the payment.
                        'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
    'Primary' => False												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
                        );
                        
        array_push($Receivers,$Receiver);
        
        
    //	print_r($Receivers);die;
        
        $SenderIdentifierFields = array(
                                        'UseCredentials' => 'TRUE'						// If TRUE, use credentials to identify the sender.  Default is false.
                                        );
                                        
        $AccountIdentifierFields = array(
                                        'Email' => 'test@test.com', 								// Sender's email address.  127 char max.
                                        'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => '')								// Sender's phone number.  Numbers only.
                                        );
                                        
        $PayPalRequestData = array(
                            'PayRequestFields' => $PayRequestFields, 
                            'ClientDetailsFields' => $ClientDetailsFields, 
                            'FundingTypes' => $FundingTypes, 
                            'Receivers' => $Receivers, 
                            'SenderIdentifierFields' => $SenderIdentifierFields, 
                            'AccountIdentifierFields' => $AccountIdentifierFields
                            );	
                            
        $PayPalResult = $this->paypal_adaptive->Pay($PayPalRequestData);
        
        if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
        {
echo "<pre/>";			
print_r($PayPalResult)	;die;	
            $errors = array('Errors'=>$PayPalResult['Errors']);
            $this->load->view('paypal_error',$errors);
        }
        else
        {
                       
            // Successful call.  Load view or whatever you need to do here.
            header('Location: '.$PayPalResult['RedirectURL']);
            exit();
        }
    
        
        }
    
    /*
     * date 28-aug-2013
     * datails: get session details from event and launch
     * auther: lokendra
     * access: public
     */  
    
    
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
    
    
    
    function testwork(){
        
        if(isset($_POST['ticketDetails'])){
            $ticketDetails=$_POST['ticketDetails'];
            echo $ticketDetails=trim($ticketDetails);
        }else{
            echo json_encode($_POST);
        }
    }
    
    /*
     * This function used to get sell type of product 
     */			
    function getSellType($entityId=0,$elementId=0,$userId=0) {
        if(isset($entityId) && !empty($entityId) && isset($elementId) && !empty($elementId) && isset($userId) && !empty($userId)) {
            $getElementTable = getMasterTableName($entityId);
            $getElementTable = $getElementTable[0];
            $isTable = true;
            //Set project where clause and fields name
            switch($getElementTable) {
                case 'TDS_Product':
                $sellTypeRes = $this->model_common->getDataFromTabel($getElementTable, 'productSellType',  array('tdsUid'=>$userId,'productId'=>$elementId),'','','','');
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
  
} 
