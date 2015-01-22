<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class model_cart extends CI_Model { 

    

    
    private $tableProject 				= 'Project';
    private $tableProjectShipping		= 'TDS_ProjectShipping';
    
    private $tableSalesBasketItem		= 'SalesBasketItem';
    private $tableMembershipCartItem	= 'MembershipCartItem';
    private $tableMembershipOrder	    = 'MembershipOrder';	
    private $tableUserContainer			= 'UserContainer';
    private $tableUserMembershipItem	= 'UserMembershipItem';
    private $tableMasterIndustry	    = 'MasterIndustry';
    private $tableSalesCustomersBasket	= 'SalesCustomersBasket';
    private $tableSalesOrder			= 'SalesOrder';
    private $tableSalesOrderItem		= 'SalesOrderItem';
    private $tableSalesItemDownload		= 'SalesItemDownload';
    private $tableSalesItemShipping		= 'SalesItemShipping';
    private $tableBuyerComments		= 'BuyerComments';
    private $tableSalesItemPerView		= 'SalesItemPerView';
    private $tableUserSellerSettings	= 'UserSellerSettings';
    private $tablePaypalTransactionLog	= 'PaypalTransactionLog';
    private $tableEventSessions	= 'EventSessions';
    private $tableTickets	= 'Tickets';
    private $tableTicketPriceSchedule	= 'TicketPriceSchedule';
    private $tableMasterTicketCategories	= 'MasterTicketCategories';
    private $tableMeetingPoint	= 'MeetingPoint';
    
    
    
    function __construct(){
        parent::__construct();
    } 
    
    function getSessionDetails($tableName='',$elementId=0,$selectedField='',$whereField='',$whereSesField,$SessionId=0){	  
        $result=false;
        if($elementId > 0 && $SessionId>0){
            $this->db->select('date,startTime,endTime,venue,address,city,state,country,zip,url,venueName,address2,venueEmail,phoneNumber');	
            $this->db->select($selectedField);	
            $this->db->from($this->tableEventSessions);
            $this->db->join($tableName,$tableName.'.'.$whereField.' ='.$this->tableEventSessions.'.'.$whereSesField);
            $this->db->where($this->tableEventSessions.'.sessionId',$SessionId);
            
            $this->db->limit(1);
            $query = $this->db->get();
            $result=$query->result_array();
        }
        return $result;  
    } 
    function getTicketInfo($TicketId=0){	  
        $result=false;
        if($TicketId > 0){

            $this->db->select($this->tableTickets.'.Quantity as aviliableqty,'.$this->tableTickets.'.Price');	
            $this->db->select($this->tableTicketPriceSchedule.'.StartDate as earybirdstartdate,'.$this->tableTicketPriceSchedule.'.EndDate as earybirdenddate,'.$this->tableTicketPriceSchedule.'.Price as earybirdprice');	
            $this->db->select($this->tableEventSessions.'.date as sessiondate,'.$this->tableEventSessions.'.startTime,'.$this->tableEventSessions.'.endTime,'.$this->tableEventSessions.'.eventSellstatus,'.$this->tableEventSessions.'.earlyBirdStatus');		
            $this->db->select($this->tableMasterTicketCategories.'.Title as ticketcategory');	
            
            $this->db->from($this->tableTickets);
            $this->db->join($this->tableEventSessions,$this->tableEventSessions.'.sessionId ='.$this->tableTickets.'.SessionId');
            $this->db->join($this->tableTicketPriceSchedule,$this->tableTicketPriceSchedule.'.TicketId ='.$this->tableTickets.'.TicketId','left');
            $this->db->join($this->tableMasterTicketCategories,$this->tableMasterTicketCategories.'.TicketCategoryId ='.$this->tableTickets.'.TicketCategoryId','left');		
            
            $this->db->where($this->tableTickets.'.TicketId',$TicketId);
            
            $this->db->order_by('PriceScheduleId','DESC');		
            $this->db->limit(1);
            $query = $this->db->get();
            //echo $this->db->last_query();
            $result=$query->result();
        }
        return $result;  
    } 
    
    function getTransetionDetails($trackingId=''){	  
        $result=false;
        if($trackingId !=''){

            $this->db->select('*');	
            $this->db->from($this->tableSalesOrder);
            $this->db->join($this->tableSalesOrderItem,$this->tableSalesOrderItem.'.ordId ='.$this->tableSalesOrder.'.ordId');		
            //$this->db->join($this->tablePaypalTransactionLog,$this->tablePaypalTransactionLog.'.invoiceId ='.$this->tableSalesOrderItem.'.invoiceId','left');		
            $this->db->where($this->tableSalesOrder.'.trackingId',$trackingId);	
            $query = $this->db->get();
            //echo $this->db->last_query();
            $result=$query->result();
        }
        return $result;  
    } 	
    
 function getBasketId($id){	  
    $this->db->select('itemId');	
    $this->db->from($this->tableSalesBasketItem);			
    $this->db->where('basketId',$id);	
    $query = $this->db->get();
    //echo $this->db->last_query();
    $result=$query->result();
    if($result)
    return $result;
      
  } 	
    
    
 function getBasketItem($itemId){	  
    $this->db->select('itemId,itemName,itemPrice,itemShiping');	
    $this->db->from($this->tableSalesBasketItem);			
    $this->db->where('itemId',$itemId);	
    $query = $this->db->get();
    //echo $this->db->last_query();
    $result=$query->result();
    if($result)
    return $result[0];
      
  } 
 
 /* Get Items to insert in Sales Order Table */ 
 function getUserBasketItems($itemId=0,$currency=0){	  
    //$this->db->select('*,'.$this->tableSalesCustomersBasket.'.billingdetails,'.$this->tableSalesCustomersBasket.'.shippingdetails');	
    $this->db->select($this->tableSalesBasketItem.'.*,'.$this->tableSalesCustomersBasket.'.uId,'.$this->tableSalesCustomersBasket.'.trackingId,'.$this->tableSalesCustomersBasket.'.billingdetails');	
    $this->db->from($this->tableSalesBasketItem);
    $this->db->join($this->tableSalesCustomersBasket,$this->tableSalesCustomersBasket.'.basketId ='.$this->tableSalesBasketItem.'.basketId','left');			
    $this->db->where($this->tableSalesBasketItem.'.basketId',$itemId);	
    $this->db->where($this->tableSalesBasketItem.'.sendpaypal','t');
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    $result=$query->result();
    if($result)
    return $result;
      
  } 
    
   /* Get Items to insert in Sales Order Table */ 
 function getAllUserBasketItems($itemId=0,$currency=0){	  
    //$this->db->select('*,'.$this->tableSalesCustomersBasket.'.billingdetails,'.$this->tableSalesCustomersBasket.'.shippingdetails');	
    $this->db->select($this->tableSalesBasketItem.'.*,'.$this->tableSalesCustomersBasket.'.uId,'.$this->tableSalesCustomersBasket.'.trackingId,'.$this->tableSalesCustomersBasket.'.billingdetails');	
    $this->db->from($this->tableSalesBasketItem);
    $this->db->join($this->tableSalesCustomersBasket,$this->tableSalesCustomersBasket.'.basketId ='.$this->tableSalesBasketItem.'.basketId','left');			
    $this->db->where($this->tableSalesBasketItem.'.basketId',$itemId);	
    //$this->db->where($this->tableSalesBasketItem.'.sendpaypal','t');
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    $result=$query->result();
    if($result)
    return $result;
      
  } 	
    
    //---------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to get user billing details by user id
    *  @param: $userId
    *  @modified by: lokendra meena
    *  @return: void
    */ 
    
    public function getUserBillingDetails($userId){	  
        $this->db->select('bill.billing_firstName,bill.billing_lastName,bill.billing_companyName,bill.billing_lastName,bill.billing_address1,bill.billing_address2,bill.billing_city,bill.billing_state,bill.billing_country,bill.billing_zip,bill.billing_phone,bill.billing_email,bill.EuVatIdentificationNumber,MasterCountry.countryName,MasterCountry.countryGroup,EuVatIdentificationNumber');	
        $this->db->from('UserBuyerSettings as bill');
        $this->db->join('MasterCountry','MasterCountry.countryId = bill.billing_country','left');
        $this->db->join('ConsumptionTax','ConsumptionTax.countryId = bill.billing_country','left');	
        $this->db->where('bill.tdsUid',$userId);
        $query = $this->db->get();
        $result=$query->row();
        return $result;
    } 
  
  
  function getBillingShipDetails($id){	  
      
    $this->db->select('ship.shipping_firstName,ship.shipping_lastName,ship.shipping_companyName,ship.shipping_address1,ship.shipping_address2,ship.shipping_state,ship.shipping_country,ship.shipping_city,ship.shipping_zip,ship.shipping_phone,ship.shipping_email,MasterCountry.countryName as shippingcountryName');	
    $this->db->from('UserBuyerSettings as ship');	
    $this->db->join('MasterCountry','MasterCountry.countryId = ship.billing_country','left');
    $this->db->join('ConsumptionTax','ConsumptionTax.countryId = ship.billing_country','left');	
    $this->db->where('ship.tdsUid',$id);	
    $query = $this->db->get();
    //echo $this->db->last_query();
    $result=$query->result();
    if($result)
    return $result[0];
      
  } 
  
    //----------------------------------------------------------------------

    /*
    *   @description: This method is use to get billing details from sale customer basket
    *   @param: $cartId
    *   @modified by: lokendra meena
    *   @return: void
    */ 
  
    function getBillingDetails($cartId){   	  
       if(!empty($cartId)) { 
            $this->db->select('billingdetails,shippingdetails');	
            $this->db->from($this->tableSalesCustomersBasket);
            $this->db->where('basketId',$cartId);
            $query = $this->db->get();
            $result=$query->row();
            if($result){
                return $result;
            }else{
                return false;
            } 
        }else{
            return false;
        }
    }
  
  
    
 
  /* Get Shipping amount based on buyer settings of user */
  
  function getShippingAmount($entityId=0,$elementId=0,$countryId=0){	  	
    $field='|'.$countryId.'|';	  	  
    $fieldOr='|'.$countryId;	  	  
    $this->db->select('amount');	
    $this->db->from($this->tableProjectShipping);	
    $this->db->where('entityId',$entityId);
    $this->db->where('elementId',$elementId);	
    $this->db->like('countriesId',$field); 	
    $this->db->or_like('countriesId',$fieldOr); 	
    $query = $this->db->get();
    //echo $this->db->last_query();die();
    $result=$query->result();
    if($query->num_rows() > 0) {
                return $result;				  
     } else {
                return 0;
        }
  } 
  
 
 function getOwnerId($entityId,$elementId){
 $tableName = getMasterTableName($entityId);
 $tableName= $tableName[0]; 
     switch ($tableName){	
                            
        case 'TDS_Product':							
            $whereId = 'productId';														
            break;
                    
        case 'TDS_Project':						
            $whereId = 'projId';						
        break;
        default:			
      }
    
    $this->db->select('tdsUid');	
    $this->db->from($tableName);	
    $this->db->where($whereId,$elementId);		
    $query = $this->db->get();
    //echo $this->db->last_query();
    $result=$query->result();
    if($query->num_rows() > 0) {
            return $result[0];				  
     } else {
                 return 0;
       }
     
    } 
  
 /*
  * access:public
  * use: this function is return owner id by element id
  * 
  * */ 
function getItemOwnerId($entityId,$elementId){
        $tableName = getMasterTableName($entityId);
        $tableName = $tableName[0]; 
        
         switch ($tableName){	
                                
            case 'TDS_Product':							
                $whereArr = array('productId'=>$elementId);	
                $isJoin="no";													
                break;
                        
            case 'TDS_Project':						
                $whereArr = array('projId'=>$elementId);
                $isJoin="no";						
            break;
            
            case 'TDS_MaElement':						
                $whereArr = array(''.$tableName.'.elementId'=>$elementId);
                $isJoin="yes";						
            break;
            
            case 'TDS_FvElement':						
                $whereArr = array(''.$tableName.'.elementId'=>$elementId);
                $isJoin="yes";						
            break;
            
            case 'TDS_WpElement':						
                $whereArr = array(''.$tableName.'.elementId'=>$elementId);
                $isJoin="yes";						
            break;
            
            case 'TDS_PaElement':						
                $whereArr = array(''.$tableName.'.elementId'=>$elementId);
                $isJoin="yes";						
            break;
            
            case 'TDS_EmElement':						
                $whereArr = array(''.$tableName.'.elementId'=>$elementId);
                $isJoin="yes";						
            break;
            default:			
          }
        
        //if isJoin no then no required to join 
        if($isJoin=="no")
        {
            $this->db->select('tdsUid');	
            $this->db->from($tableName);	
            $this->db->where($whereArr);
        }
        
        //if isJoin yes then required to join 	
        
        if($isJoin=="yes")
        {
            $this->db->select('TDS_Project.tdsUid');		
            $this->db->from($tableName);
            $this->db->join('TDS_Project','TDS_Project.projId = '.$tableName.'.projId','left');
            $this->db->where($whereArr);
        }	
                
        $query = $this->db->get();
        $result=$query->result();
        if($query->num_rows() > 0) {
                return $result[0];				  
         } else {
                     return 0;
           }
     
    }
    
/*
  * access:public
  * use: this function is return title and image by element id
  * 
  * */ 
function getItemTitleImage($entityId,$elementId){
        $tableName = getMasterTableName($entityId);
        $tableName = $tableName[0]; 
        $isProductTable="";
        $tableType="";
        $isJoin="";
        
        echo $tableName;die;
        
         switch ($tableName){	
                                
            case 'TDS_Product':							
                $whereArr = array('productId'=>$elementId);	
                $isJoin=" ";
                $isProductTable="yes";
                $tableType="product";													
                break;
                        
            case 'TDS_Project':						
                $whereArr = array('projId'=>$elementId);
                $isJoin="no";	
                $tableType="project";					
            break;
            
            case 'TDS_MaElement':						
                $whereArr = array(''.$tableName.'.elementId'=>$elementId);
                $isJoin="yes";	
                $tableType="maelement";					
            break;
            
            case 'TDS_FvElement':						
                $whereArr = array(''.$tableName.'.elementId'=>$elementId);
                $isJoin="yes";	
                $tableType="fvelement";					
            break;
            
            case 'TDS_WpElement':						
                $whereArr = array(''.$tableName.'.elementId'=>$elementId);
                $isJoin="yes";	
                $tableType="wpelement";					
            break;
            
            case 'TDS_PaElement':						
                $whereArr = array(''.$tableName.'.elementId'=>$elementId);
                $isJoin="yes";	
                $tableType="paelement";					
            break;
            
            case 'TDS_EmElement':						
                $whereArr = array(''.$tableName.'.elementId'=>$elementId);
                $isJoin="yes";
                $tableType="emelement";							
            break;
            default:			
        }
        
        //if isJoin no then no required for join 
        if($isJoin=="no")
        {
            $this->db->select('projName, projBaseImgPath, IndustryId');	
            $this->db->from($tableName);	
            $this->db->where($whereArr);
        }
        
        //if isJoin yes then required for join 	
        
        if($isJoin=="yes")
        {
            $this->db->select(''.$tableName.'.title,'.$tableName.'.imagePath');		
            $this->db->from($tableName);
            $this->db->join('TDS_Project','TDS_Project.projId = '.$tableName.'.projId','left');
            $this->db->where($whereArr);
        }
        
        //if isProductTable yes then get data from produect table
        
        if($isProductTable=="yes")
        {
            $this->db->select(''.$tableName.'.productTitle,'.$tableName.'.catId,TDS_MediaFile.filePath,TDS_MediaFile.fileName');		
            $this->db->from($tableName);
            $this->db->join('TDS_ProductPromotionMedia','TDS_ProductPromotionMedia.prodId = '.$tableName.'.productId','left');
            $this->db->join('TDS_MediaFile','TDS_ProductPromotionMedia.fileId = TDS_MediaFile.fileId','left');
            $this->db->where($whereArr);
        }	
                
        $query = $this->db->get();
        
        if($query->num_rows() > 0) {
                $getresult=$query->result();
                $result['get_result'] = $getresult[0];
                $result['get_num_row'] = $query->num_rows();
                $result['get_type'] = $tableType;	
                return $result;			  
         } else {
                     return 0;
           }
     
    }	
    
    
    
    
    function getSellerDetails($ownerId)
    {
        
        $this->db->select('TDS_UserSellerSettings.seller_address1,TDS_UserSellerSettings.seller_city,TDS_UserSellerSettings.seller_state,TDS_UserSellerSettings.seller_zip,TDS_UserSellerSettings.seller_phone,TDS_UserSellerSettings.territoryCountryId,TDS_UserSellerSettings.territory,TDS_UserSellerSettings.identificationNumber,TDS_UserProfile.firstName,TDS_UserProfile.lastName,TDS_UserAuth.email');		
        $this->db->from('TDS_UserSellerSettings');
        $this->db->join('TDS_UserProfile','TDS_UserProfile.tdsUid = TDS_UserSellerSettings.tdsUid','left');
        $this->db->join('TDS_UserAuth','TDS_UserProfile.tdsUid = TDS_UserAuth.tdsUid','left');
        $this->db->where('TDS_UserSellerSettings.tdsUid',$ownerId);
        $query = $this->db->get();
        $result=$query->row();
        //echo $this->db->last_query();die();
        if($query->num_rows() > 0) {
                return $result;				  
         } else {
                     return false;
           }
    
    }
    
    
    function getSellerDetailsTicket($ownerId)
    {
        
        $this->db->select('TDS_UserSellerSettings.seller_address1,TDS_UserSellerSettings.seller_city,TDS_UserSellerSettings.seller_state,TDS_UserSellerSettings.seller_zip,TDS_UserSellerSettings.seller_phone,TDS_UserSellerSettings.territoryCountryId,TDS_UserSellerSettings.territory,TDS_UserSellerSettings.identificationNumber,TDS_UserProfile.firstName,TDS_UserProfile.lastName,TDS_UserAuth.email');		
        $this->db->from('TDS_UserAuth');
        $this->db->join('TDS_UserProfile','TDS_UserProfile.tdsUid = TDS_UserAuth.tdsUid','left');
        $this->db->join('TDS_UserSellerSettings','TDS_UserProfile.tdsUid = TDS_UserSellerSettings.tdsUid','left');
        $this->db->where('TDS_UserAuth.tdsUid',$ownerId);
        $query = $this->db->get();
        $result=$query->row();
        //echo $this->db->last_query();die();
        if($query->num_rows() > 0) {
                return $result;				  
         } else {
                     return false;
           }
    
    }
  
  
  
  /* Get Sum of duration /containersize */
  function getBasketTotal($basketId,$field='basketId',$sum='dispatchPrice'){	
            
        $this->db->select('SUM("'.$sum.'") AS total');		
        $this->db->where($field,$basketId);	
        $this->db->where('sendpaypal','t');	   
        $this->db->order_by($field,'desc');
        $this->db->group_by($field);
        $query = $this->db->get($this->tableSalesBasketItem);
        // echo $this->db->last_query();	die;
        $result=$query->result();
            if($result){
                 return $result[0]->total;
            }else{
                 return false;
            }		
    }
  
  
  
  /* Get data to send paypal */
  function getUserBasketProducts($basketId){	
            
        $this->db->select('SUM("dispatchPrice") AS price , sellerId');		
        $this->db->where('basketId',$basketId);	
        $this->db->where('sendpaypal','t');	   
        //$this->db->order_by('itemId','desc');
        $this->db->group_by('sellerId');
        $query = $this->db->get($this->tableSalesBasketItem);
        // echo $this->db->last_query();	die;
        $result=$query->result();
            if($result){
                 return $result;
            }else{
                 return false;
            }		
    }
  
  
  
   /* Get data to send paypal */
  function getUserInvoiceId($basketId,$sellerId){	
            
        $this->db->select('invoiceId');		
        $this->db->where('basketId',$basketId);	
        $this->db->where('sellerId',$sellerId);	   
        //$this->db->order_by('itemId','desc');
       // $this->db->group_by('sellerId');
        $query = $this->db->get($this->tableSalesBasketItem);
        // echo $this->db->last_query();	die;
        
        $result=$query->result();	
      if($query->num_rows() > 0) {
             return $result[0]->invoiceId;				  
      } else {
            return false;
        }
  }		
  
  
  /* getProductInfo */
  function getProductInfo($tableName,$selectfields,$where){	
      
        $this->db->select($selectfields);
        
        if(strstr($tableName,'Element')){
             $this->db->select('Project.projCategory as projcategory');
            $this->db->join('Project','Project.projId = '.$tableName.'.projId');
        }
            
        $this->db->where($where);
        
        if ($this->db->field_exists('isPublished', $tableName))
        {
          $this->db->where($tableName.'.isPublished','t');	
        } 
                    
        $query = $this->db->get($tableName);
        $result=$query->result();
        
        return $result;				
 }
 
 
 /* getProductImages */
  function getMediaImage($tableName,$selectfields,$where){
    $file ='';  
    $this->db->select($selectfields);
    $this->db->where($where);
    $this->db->where('isPublished','t');				
    $query = $this->db->get($tableName);
    $result=$query->result();
    if($result && isset($result[0]->imagepath)) {
        $file =trim($result[0]->imagepath);
    }
    return $file;
  }
    
  /* getProductImages */
  function getProductImage($elementId){
    $file = '';
    if($elementId > 0){  
        $this->db->select('MediaFile.filePath,MediaFile.fileName');
        $this->db->from('Product');	  	
        $this->db->join('ProductPromotionMedia','ProductPromotionMedia.prodId = Product.productId','left');
        $this->db->join('MediaFile','MediaFile.fileId = ProductPromotionMedia.fileId','left');
        $this->db->where('ProductPromotionMedia.isMain','t');	
        $this->db->where('Product.productId',$elementId);				
        $query = $this->db->get();
        // echo $this->db->last_query();	die;
        $result=$query->result();
        
        if($result && isset($result[0]->filePath) && isset($result[0]->fileName)) {		
            $filePath= trim($result[0]->filePath) ;				  
            $fileName = trim($result[0]->fileName);
            $fpLen=strlen($filePath);
            if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
                $filePath=$filePath.DIRECTORY_SEPARATOR;
            }       
            $file =$filePath.$fileName;
        }
    }
    return $file;
  }
    
    /* getImages for Photograph N Art */
  function getPnArtImage($table='',$field='',$elementId=0,$fileField=''){
      
    $file = '';
    if($table !='' && $table !='' && $elementId > 0 && $fileField !=''){
        $this->db->select('MediaFile.filePath,MediaFile.fileName');
        $this->db->from($table);	
        $this->db->join('MediaFile','MediaFile.fileId = '.$table.'.'.$fileField,'left');		
        $this->db->where($table.'.'.$field,$elementId);
        $this->db->where($table.'.isPublished','t');
        $this->db->limit(1);			
        $query = $this->db->get();
        $result=$query->result();
        if($result && isset($result[0]->filePath) && isset($result[0]->fileName)) {		
            $filePath= trim($result[0]->filePath) ;				  
            $fileName = trim($result[0]->fileName);
            $fpLen=strlen($filePath);
            if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
                $filePath=$filePath.DIRECTORY_SEPARATOR;
            }       
            $file =$filePath.$fileName;
        }
    }
    return $file;
 }
    
    
  
 /* Get Country name & Group based on country id */   	
function getUserCountryName($id){
     
    $this->db->select('countryName,countryGroup');	
    $this->db->from('MasterCountry');			
    $this->db->where('countryId',$id);	
    $query = $this->db->get();
    //echo $this->db->last_query();
    $result=$query->result();
    if($result)
     return $result[0];
    } 
    
    
/* Get Country name & Group based on country id */   	
function sellerPaypalId($id){
     
    $this->db->select('paypalId');	
    $this->db->from($this->tableUserSellerSettings);			
    $this->db->where('tdsUid',$id);	
    $query = $this->db->get();
    //echo $this->db->last_query();
    $result=$query->result();	
      if($query->num_rows() > 0) {
             return $result[0]->paypalId;				  
      } else {
            return false;
        }	 
  } 	
    
function getToadCommision($basketId,$currency=0){	
        
    $this->db->select('SUM("tsGrossCommision") AS price ');		
    $this->db->where('basketId',$basketId);	
    $this->db->where('currency',$currency);	
    $this->db->where('sendpaypal','t');	   
    //$this->db->order_by('itemId','desc');
    $this->db->group_by('basketId');
    $query = $this->db->get($this->tableSalesBasketItem);
    // echo $this->db->last_query();	die;
    $result=$query->result();
        if($result){
             return $result[0]->price;
        }else{
             return false;
        }		
    
 }	
    


function deleteCartItem($Id,$entityId,$elementId,$purchaseType)  {	   		
       $this->db->where('basketId',$Id);
       $this->db->where('entityId',$entityId);	
       $this->db->where('elementId',$elementId);
       $this->db->where('purchaseType',$purchaseType);	   	    	
       $this->db->delete($this->tableSalesBasketItem);
       // echo $this->db->last_query();	die;
       return true;				
        }		
    
  
    /*
     * This function is used to get purchased details 
     * 
     */   
  
  
    function get_purchased_details($userId,$offset=0,$limit=0)
    {
        $this->db->select('SalesOrder.ordId,SalesOrder.ordNumber,SalesOrder.ordDateComplete,SalesOrder.ordCurrency,SalesOrderItem.sectionId,
        SalesOrderItem.itemId,SalesOrderItem.entityId,SalesOrderItem.sellerId,SalesOrderItem.elementId,SalesOrderItem.projId,
        SalesOrderItem.itemQty,SalesOrderItem.basePrice,SalesOrderItem.itemName,SalesOrderItem.transactionId,SalesOrderItem.invoiceId,
        SalesOrderItem.purchaseType,SalesOrderItem.sellerInfo,SalesOrderItem.isProductAuction,SalesOrderItem.itemValue');
        $this->db->select('SalesItemDownload.dwnId,SalesItemDownload.dwnDate,SalesItemDownload.dwnMaxday,SalesItemDownload.dwnStatus,SalesItemDownload.userId,SalesItemDownload.ownerId,SalesItemDownload.purchaseType as itempurchasetype');
        $this->db->select('SalesItemShipping.shpStatus,SalesItemShipping.shippingDetails');	  	
        $this->db->select('LogSummary.*');	  	
        $this->db->select('ProjCategory.IndustryId, ProjCategory.category, ProjCategory.entityId as elemententityid');	  	
        $this->db->select('UserProfile.firstName, UserProfile.lastName');	  	
        $this->db->from($this->tableSalesOrder);	  	
        $this->db->join('SalesOrderItem','SalesOrderItem.ordId = SalesOrder.ordId','left');
        $this->db->join('UserProfile','UserProfile.tdsUid = SalesOrderItem.sellerId','left');
        $this->db->join('ProjCategory','ProjCategory.catId = SalesOrderItem.projCategory','left');
        $this->db->join('SalesItemDownload','SalesItemDownload.itemId = SalesOrderItem.itemId','left');
        $this->db->join('SalesItemShipping','SalesItemShipping.itemId = SalesOrderItem.itemId','left');
         $this->db->join('LogSummary', 'LogSummary.elementId =  SalesOrderItem.elementId AND  "TDS_LogSummary"."entityId"="TDS_SalesOrderItem"."entityId" ', 'left');
        
        $this->db->where('SalesOrder.customerUid',$userId);	
        
        if($offset!=0 || $limit!=0)
        {
            $this->db->limit($limit, $offset);
        }
        
        $this->db->order_by('SalesOrder.ordId','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    }
    
    /*
    * This function is used to get sales details 
    * 
    */   
  
  
    function get_sales_details($userId,$offset=0,$limit=0)
    {
        $this->db->select('SalesOrder.ordId,SalesOrder.customerUid,SalesOrder.ordNumber,SalesOrder.ordDateComplete,SalesOrder.ordCurrency,SalesOrderItem.sectionId,SalesOrderItem.itemId,
        SalesOrderItem.entityId,SalesOrderItem.sellerId,SalesOrderItem.elementId,SalesOrderItem.itemQty,SalesOrderItem.basePrice,SalesOrderItem.itemName,
        SalesOrderItem.invoiceId,SalesOrderItem.purchaseType,BuyerComments.rateSeller,BuyerComments.comments,SalesOrderItem.sellerInfo,SalesOrderItem.isProductAuction,SalesOrderItem.itemValue');
         $this->db->select('SalesItemDownload.dwnId,SalesItemDownload.dwnDate,SalesItemDownload.dwnMaxday,SalesItemDownload.dwnStatus,SalesItemDownload.userId,SalesItemDownload.ownerId,SalesItemDownload.purchaseType as itempurchasetype');
        $this->db->select('SalesItemShipping.shpStatus,SalesItemShipping.shippingDetails');	    	
        $this->db->select('LogSummary.*');
         $this->db->select('ProjCategory.IndustryId, ProjCategory.category, ProjCategory.entityId as elemententityid');	  	
        $this->db->select('UserProfile.firstName,UserProfile.lastName');
        $this->db->select('UserShowcase.enterpriseName,UserShowcase.enterprise');
        $this->db->from($this->tableSalesOrder);
        $this->db->join('SalesOrderItem','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->join('ProjCategory','ProjCategory.catId = SalesOrderItem.projCategory','left');
        $this->db->join('BuyerComments','SalesOrderItem.itemId = BuyerComments.itemId','left');
        $this->db->join('SalesItemDownload','SalesItemDownload.itemId = SalesOrderItem.itemId','left');
        $this->db->join('SalesItemShipping','SalesItemShipping.itemId = SalesOrderItem.itemId','left');
        $this->db->join('LogSummary', 'LogSummary.elementId =  SalesOrderItem.elementId AND  "TDS_LogSummary"."entityId"="TDS_SalesOrderItem"."entityId" ', 'left');
        
        $this->db->join('UserProfile','SalesOrder.customerUid = UserProfile.tdsUid','left');
        $this->db->join('UserShowcase','SalesOrder.customerUid = UserShowcase.tdsUid','left');
        
        
        $this->db->where('SalesOrderItem.sellerId',$userId);	
        
        if($offset!=0 || $limit!=0)
        {
            $this->db->limit($limit, $offset);
        }
        
        $this->db->order_by('SalesOrder.ordId','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    }	
    
    
    
    /*
     ************************************************ 
     * This function is used to return all column value by userId
     ************************************************ 
     */  
  
  
    function salesDetailsForExport($userId)
    {
        $this->db->select('SalesOrder.ordDateComplete as  Date, SalesOrderItem.receiverTransactionId as Invoice,SalesOrder.custName 
        as 	Buyer,SalesOrderItem.itemName as Item,SalesOrderItem.itemQty as 
        qty, SalesOrder.ordCurrency as Currency, SalesOrderItem.basePrice as price ,SalesOrderItem.taxName,SalesOrderItem.taxPercent,SalesOrderItem.taxValue,SalesOrderItem.shipping,SalesOrderItem.tsCommissionPercent,SalesOrderItem.tsCommissionValue,SalesOrderItem.tsVatPercent,SalesOrderItem.tsVatValue,SalesOrderItem.tsGrossCommision,SalesOrderItem.purchaseType');
        $this->db->from($this->tableSalesOrder);	  	
        $this->db->join('SalesOrderItem','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->join('BuyerComments','SalesOrderItem.itemId = BuyerComments.itemId','left');
        $this->db->where('SalesOrderItem.sellerId',$userId);	
        $this->db->order_by('SalesOrder.ordId','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result_array();
        $result['get_first_row']=$query->list_fields('array');
        return $result;
    }	
    
    
    
    /*
     ************************************************ 
     * This function is used to get all sales details for admin
     ************************************************ 
     */  
  
  
    function AllSalesDetailsForExport()
    {
        $this->db->select('SalesOrder.ordDateComplete as  Date, SalesOrderItem.receiverTransactionId as Invoice,SalesOrder.custName 
        as 	Buyer,SalesOrderItem.itemName as Item,SalesOrderItem.itemQty as 
        qty, SalesOrderItem.sellerInfo as 
        sellerName, SalesOrder.ordCurrency as Currency, SalesOrderItem.basePrice as price ,SalesOrderItem.taxName,SalesOrderItem.taxPercent,SalesOrderItem.taxValue,SalesOrderItem.shipping,SalesOrderItem.tsCommissionPercent,SalesOrderItem.tsCommissionValue,SalesOrderItem.tsVatPercent,SalesOrderItem.tsVatValue,SalesOrderItem.tsGrossCommision,SalesOrderItem.purchaseType');
        $this->db->from($this->tableSalesOrder);	  	
        $this->db->join('SalesOrderItem','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->join('BuyerComments','SalesOrderItem.itemId = BuyerComments.itemId','left');
        $this->db->order_by('SalesOrder.ordId','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result_array();
        $result['get_first_row']=$query->list_fields('array');
        return $result;
    }	
    
        /*
     ************************************************ 
     * This function is used to return all column value  for sales infr
     ************************************************ 
     */  
  
  
    function salesInfoDetailsForExport($userId,$from_date='',$to_date='')
    {
        if($from_date!="" && $to_date!="")
        {
            $from_date = date("Y-m-d",strtotime($from_date));
            $to_date = date("Y-m-d",strtotime($to_date));
            $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) >=',$from_date);	
            $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) <=',$to_date);	
        }
        
        $this->db->select('SalesOrder.ordDateComplete as Date, SalesOrderItem.receiverTransactionId as Invoice,SalesOrder.custName 
        as 	Buyer,SalesOrderItem.itemName as Item,SalesOrderItem.itemQty as 
        qty, SalesOrder.ordCurrency as Currency, SalesOrderItem.basePrice as price ,SalesOrderItem.taxName,SalesOrderItem.taxPercent,SalesOrderItem.taxValue,SalesOrderItem.shipping,SalesOrderItem.tsCommissionPercent,SalesOrderItem.tsCommissionValue,SalesOrderItem.tsVatPercent,SalesOrderItem.tsVatValue,SalesOrderItem.tsGrossCommision,SalesOrderItem.purchaseType');
        $this->db->from($this->tableSalesOrder);	  	
        $this->db->join('SalesOrderItem','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->join('BuyerComments','SalesOrderItem.itemId = BuyerComments.itemId','left');
        $this->db->where('SalesOrderItem.sellerId',$userId);	
        $this->db->order_by('SalesOrder.ordDateComplete','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result_array();
        $result['get_first_row']=$query->list_fields('array');
        return $result;
    }
    
    /*function get_purchased_details_count($userId)
    {
        $this->db->select('SalesOrder.ordId,SalesOrder.ordNumber,SalesOrder.ordDateComplete,SalesOrder.ordCurrency,SalesOrderItem.itemId,SalesOrderItem.entityId,SalesOrderItem.ownerId,SalesOrderItem.elementId,SalesOrderItem.itemQty,SalesOrderItem.itemPrice,SalesOrderItem.itemName,SalesOrderItem.purchaseType');
        $this->db->from($this->tableSalesOrder);	  	
        $this->db->join('SalesOrderItem','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->where('SalesOrder.customerUid',$userId);	
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->num_rows();
    }*/		
    
/******This function show purchased record by orderId and userId****/	
    
    function get_purchased_record($getOrderId,$userId)
    {
        $this->db->select('SalesOrder.*,SalesOrderItem.itemId,SalesOrderItem.invoiceId,SalesOrderItem.entityId,SalesOrderItem.elementId,SalesOrderItem.itemQty,SalesOrderItem.sellerId,SalesOrderItem.sellerInfo,SalesOrderItem.basePrice,SalesOrderItem.itemName,SalesOrderItem.purchaseType,SalesOrderItem.registrationId,SalesOrderItem.receiverTransactionId');
        $this->db->from($this->tableSalesOrder);	  	
        $this->db->join('SalesOrderItem','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->where('SalesOrderItem.itemId',$getOrderId);
        //$this->db->where('SalesOrder.customerUid',$userId);	
        //$this->db->or_where('SalesOrderItem.sellerId',$userId);	
        $query = $this->db->get();
         //echo $this->db->last_query();	die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->first_row();
        return $result;
    }	
  
    /*
     ***********************************
     *  This function is used to show seller info by itemId 
     *********************************** 
     */ 
    
    function getInvoiceSellerInfo($itemId)
    {
        $this->db->select('SalesOrder.*,SalesOrderItem.sellerInfo,SalesOrderItem.registrationId,SalesOrderItem.sellerId');
        $this->db->from($this->tableSalesOrder);	  	
        $this->db->join('SalesOrderItem','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->where('SalesOrderItem.itemId',$itemId);
        $query = $this->db->get();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->first_row();
        return $result;
        
    }
    
    
  
  /*******
   * 
   * This function is used to get all items details by orderId
   * 
   * *****/
  
  function getItemsDetils($invoiceId)
    {
        $this->db->select('*');	
        $this->db->from('SalesOrderItem');			
        $this->db->where('invoiceId',$invoiceId);	
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    }
    
  
    
  /*******
   * 
   * This function is used to get status of shipping service
   * 
   * *****/
  
  function isTakingShipping($invoiceId)
    {
        $this->db->select('itemId');	
        $this->db->from('SalesOrderItem');			
        $this->db->where('invoiceId',$invoiceId);	
        $this->db->where('purchaseType',1);	
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows() > 0)
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
   * This function is used to get session date and time
   * 
   * *****/
  
  function get_Session_Details($sessionId)
    {
        $this->db->select('date, startTime');	
        $this->db->from($this->tableEventSessions);			
        $this->db->where('sessionId',$sessionId);	
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->row();
        return $result;
    }
    
    
    
  
  
  /***********This function is used to insert buyyer comments***************/
  
  function comments_insert($comments)
    {
        $this->db->insert($this->tableBuyerComments, $comments); 
        return 	$this->db->insert_id();
    }
    
    
    /*
     ******************************************* 
     * This function is used to insert meeting poing
     ******************************************* 
     */
  function meetingPointInsert($meetingPointData)
    {
        $this->db->insert($this->tableMeetingPoint, $meetingPointData); 
        return 	$this->db->insert_id();
    }
    
    
    
/* Get purchase comment show */   	
function getPurchaseComment($orderId){
     
        $this->db->select('id,comments,rateSeller');	
        $this->db->from('BuyerComments');			
        $this->db->where('orderId',$orderId);	
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->row();
        return $result;
    } 
  
  
  
  /*  This function is used to update purchase comment */  
     
    function comments_update($commentId, $user_comment)
    {		
    $this->db->set($user_comment);	
    $this->db->where('id',$commentId);	
    $query = $this->db->update($this->tableBuyerComments);
    return $this->db->affected_rows() > 0;
    }
    
    
    
    /*
     *****************************************
     *This shipping details update
     ***************************************** 
     */  
     
    function shipping_update($itemId, $updateDate)
    {		
    $this->db->set($updateDate);	
    $this->db->where('itemId',$itemId);	
    $query = $this->db->update($this->tableSalesItemShipping);
    return $this->db->affected_rows() > 0;
    }
    
    /*
     * This function is used to show sales records invoice id by Invoiceid
     * 
     */   
  
  
    function get_sales_record_by_invoice($userId,$from_date,$to_date,$offset=0,$limit=0,$elementId=0)
    {
        
        if($from_date!="" && $to_date!="")
        {
            $from_date = date("Y-m-d",strtotime($from_date));
            $to_date = date("Y-m-d",strtotime($to_date));
            $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) >=',$from_date);	
            $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) <=',$to_date);	
        }
        if($offset!=0 || $limit!=0)
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->group_by('SalesOrderItem.invoiceId'); 
        $this->db->select('SalesOrderItem.invoiceId');
        $this->db->from($this->tableSalesOrderItem);	  	
        $this->db->join('SalesOrder','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->where('SalesOrderItem.sellerId',$userId);
        if($elementId!="0")
        {
            $this->db->where('SalesOrderItem.elementId',$elementId);	
        }
        //$this->db->order_by('SalesOrder.ordDateComplete','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();	die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    
    }
    
    
    /*
     * This function is used to show sales records details by invoice id
     * 
     */   
  
  
    function get_sales_record($invoiceId)
    {
        
        
        $this->db->select('SalesOrder.ordId,SalesOrder.custName,SalesOrder.ordNumber,SalesOrder.ordDateComplete,SalesOrder.ordCurrency,SalesOrderItem.itemId,SalesOrderItem.entityId,SalesOrderItem.sellerId,SalesOrderItem.invoiceId,SalesOrderItem.elementId,SalesOrderItem.itemQty,SalesOrderItem.basePrice,SalesOrderItem.itemName,SalesOrderItem.itemName,SalesOrderItem.purchaseType,SalesOrderItem.dispatchPrice,SalesOrderItem.tsGrossCommision,BuyerComments.rateSeller');
        $this->db->from($this->tableSalesOrderItem);	  	
        $this->db->join('SalesOrder','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->join('BuyerComments','SalesOrderItem.itemId = BuyerComments.itemId','left');
        $this->db->where('SalesOrderItem.invoiceId',$invoiceId);
        $query = $this->db->get();
        //echo $this->db->last_query();	die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->row();
        return $result;
    
    }
    
    
    
    
    /*
     * This function is used to show sales records 
     * 
     */   
  
  
    function get_sales_information($userId,$from_date,$to_date,$offset=0,$limit=0)
    {
        if($from_date!="" && $to_date!="")
        {
            $from_date = date("Y-m-d",strtotime($from_date));
            $to_date = date("Y-m-d",strtotime($to_date));
            $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) >=',$from_date);	
            $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) <=',$to_date);	
        }
        
        if($offset!=0 || $limit!=0)
        {
            $this->db->limit($limit, $offset);
        }
        
        $this->db->select('CAST("TDS_SalesOrder"."ordDateComplete" as DATE)');
        $this->db->group_by('CAST("TDS_SalesOrder"."ordDateComplete" as DATE)'); 
        //$this->db->select('SalesOrder.ordDateComplete,SalesOrderItem.itemId,SalesOrderItem.entityId,SalesOrderItem.elementId,SalesOrderItem.itemName');
        $this->db->from($this->tableSalesOrderItem);	  	
        $this->db->join('SalesOrder','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->join('BuyerComments','SalesOrderItem.itemId = BuyerComments.itemId','left');
        $this->db->where('SalesOrderItem.sellerId',$userId);	
        $this->db->order_by('CAST("TDS_SalesOrder"."ordDateComplete" as DATE)','DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();	die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    
    }
    
    
    /*
     * This function is used to show sales records 
     * 
     */   
  
  
    function get_projectwise_sales($userId,$offset=0,$limit=0)
    {
        if($offset!=0 || $limit!=0)
        {
            $this->db->limit($limit, $offset);
        }
        
        
        //$this->db->select('COUNT("TDS_SalesOrderItem"."elementId"), SalesOrder.ordCurrency, SalesOrderItem.tsCommissionValue, SalesOrderItem.basePrice,SalesOrderItem.taxValue, SalesOrderItem.elementId, SalesOrderItem.entityId, SalesOrderItem.itemName');
       // $this->db->group_by('SalesOrderItem.elementId, SalesOrder.ordCurrency, SalesOrderItem.tsCommissionValue,SalesOrderItem.basePrice, SalesOrderItem.taxValue, SalesOrderItem.itemName, SalesOrderItem.entityId'); 

        
        $this->db->select('COUNT("TDS_SalesOrderItem"."projId"), SalesOrderItem.projId, SalesOrderItem.entityId');
        $this->db->group_by('SalesOrderItem.projId, SalesOrderItem.entityId');  
        //$this->db->select('SalesOrder.ordDateComplete,SalesOrderItem.itemId,SalesOrderItem.entityId,SalesOrderItem.elementId,SalesOrderItem.itemName');
        $this->db->from($this->tableSalesOrderItem);	  	
        $this->db->join('SalesOrder','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->where('SalesOrderItem.sellerId',$userId);	
        $query = $this->db->get();
        //echo $this->db->last_query();	die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    
    }
    
    
    /*
     * This function is used to show sales records 
     * 
     */   
  
  
    function getProjectWiseSales($projId,$userId)
    {
        
        $this->db->select('COUNT("TDS_SalesOrderItem"."projId"), SalesOrderItem.projId, SalesOrderItem.entityId');
        $this->db->group_by('SalesOrderItem.projId, SalesOrderItem.entityId');  
        //$this->db->select('SalesOrder.ordDateComplete,SalesOrderItem.itemId,SalesOrderItem.entityId,SalesOrderItem.elementId,SalesOrderItem.itemName');
        $this->db->from($this->tableSalesOrderItem);	  	
        $this->db->join('SalesOrder','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->where('SalesOrderItem.sellerId',$userId);
        $this->db->where('SalesOrderItem.projId',$projId);	
        $query = $this->db->get();
        //echo $this->db->last_query();	die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->row();
        return $result;
    
    }
    
    
    /*
     * This function is used to show sales records 
     * 
     */   
  
  
    function get_elementwise_sales($userId,$projId)
    {
        $this->db->select('COUNT("TDS_SalesOrderItem"."elementId"), SalesOrderItem.elementId, SalesOrderItem.entityId, SalesOrderItem.itemName');
        $this->db->group_by('SalesOrderItem.elementId, SalesOrderItem.itemName, SalesOrderItem.entityId');  
        //$this->db->select('SalesOrder.ordDateComplete,SalesOrderItem.itemId,SalesOrderItem.entityId,SalesOrderItem.elementId,SalesOrderItem.itemName');
        $this->db->from($this->tableSalesOrderItem);	  	
        $this->db->join('SalesOrder','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->where('SalesOrderItem.sellerId',$userId);	
        $this->db->where('SalesOrderItem.projId',$projId);
        $this->db->where('SalesOrderItem.elementId !=',$projId);
        $query = $this->db->get();
        //echo $this->db->last_query();	die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    
    }
    
    
    /*
     *  This function check project id available
     * 
     * 
     */ 
    
    function check_projId_exist($userId,$projId)
    {
        
        $this->db->select('projId, itemName');	
        $this->db->from('SalesOrderItem');			
        $this->db->where('sellerId',$userId);
        $this->db->where('elementId',$projId);	
        $query = $this->db->get();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
        
    }
    
    /*
     *  This function check project id available
     * 
     * 
     */ 
    
    /*function testing_query($from_date,$to_date)
    {
        
        $this->db->select('ordDateComplete');	
        $this->db->from('SalesOrder');	
        $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) >=',$from_date);	
        $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) <=',$to_date);		
        $query = $this->db->get();
        echo $this->db->last_query();die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
        
    }*/
    
    /*
     * 
     * function get_sales_information($userId,$from_date,$to_date,$show_by)
        {
            if($from_date!="" && $to_date!="")
            {
                $from_date = date("Y-m-d",strtotime($from_date));
                $to_date = date("Y-m-d",strtotime($to_date));
                $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) >=',$from_date);	
                $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) <=',$to_date);	
            }
            
            
            
            $this->db->select('CAST("TDS_SalesOrder"."ordDateComplete" as DATE)');
            $this->db->group_by('CAST("TDS_SalesOrder"."ordDateComplete" as DATE)'); 
            //$this->db->select('SalesOrder.ordDateComplete,SalesOrderItem.itemId,SalesOrderItem.entityId,SalesOrderItem.elementId,SalesOrderItem.itemName');
            $this->db->from($this->tableSalesOrderItem);	  	
            $this->db->join('SalesOrder','SalesOrder.ordId = SalesOrderItem.ordId','left');
            $this->db->join('BuyerComments','SalesOrderItem.itemId = BuyerComments.itemId','left');
            $this->db->where('SalesOrderItem.ownerId',$userId);	
            $this->db->order_by('CAST("TDS_SalesOrder"."ordDateComplete" as DATE)','DESC');
            $query = $this->db->get();
            //echo $this->db->last_query();	die;
            $result['get_num_rows'] = $query->num_rows();
            $result['get_result'] = $query->result();
            return $result;
        
        }
     * */
    
    
    
    /*
     * This function is used to show sales records 
     * 
     */   
  
  
    function sales_info_day_wise($userId,$salesDate)
    {
        
        $this->db->select('COUNT("TDS_SalesOrderItem"."elementId"), SalesOrder.ordCurrency, SalesOrderItem.tsCommissionValue, SalesOrderItem.basePrice,SalesOrderItem.taxValue, SalesOrderItem.elementId, SalesOrderItem.entityId, SalesOrderItem.itemName');
        $this->db->group_by('SalesOrderItem.elementId, SalesOrder.ordCurrency, SalesOrderItem.tsCommissionValue,SalesOrderItem.basePrice, SalesOrderItem.taxValue, SalesOrderItem.itemName, SalesOrderItem.entityId'); 
        //$this->db->select('SalesOrder.ordDateComplete,SalesOrderItem.itemId,SalesOrderItem.entityId,SalesOrderItem.elementId,SalesOrderItem.itemName');
        $this->db->from($this->tableSalesOrderItem);	  	
        $this->db->join('SalesOrder','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->join('BuyerComments','SalesOrderItem.itemId = BuyerComments.itemId','left');
        $this->db->where('SalesOrderItem.sellerId',$userId);	
        $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) =',$salesDate);	
        //$this->db->order_by('SalesOrderItem.elementId','ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();	die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    
    }
    
    
    
    
    /*
     ***************************************
     *  This function is used to show sales records by  start and end 
     * date after get month wise and year wise date
     *************************************** 
     */   
  
  
    function sales_info_month_wise($userId,$from_date,$to_date)
    {
        
        if($from_date!="" && $to_date!="")
        {
            $from_date = date("Y-m-d",strtotime($from_date));
            $to_date = date("Y-m-d",strtotime($to_date));
            $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) >=',$from_date);	
            $this->db->where('CAST("TDS_SalesOrder"."ordDateComplete" as DATE) <=',$to_date);	
        }
        
        
        $this->db->select('COUNT("TDS_SalesOrderItem"."elementId"), SalesOrder.ordCurrency, SalesOrderItem.tsCommissionValue, SalesOrderItem.basePrice,SalesOrderItem.taxValue, SalesOrderItem.elementId, SalesOrderItem.entityId, SalesOrderItem.itemName');
        $this->db->group_by('SalesOrderItem.elementId, SalesOrder.ordCurrency, SalesOrderItem.tsCommissionValue,SalesOrderItem.basePrice, SalesOrderItem.taxValue, SalesOrderItem.itemName, SalesOrderItem.entityId'); 
        //$this->db->select('SalesOrderItem.elementId, SalesOrderItem.entityId, SalesOrderItem.itemName, COUNT("TDS_SalesOrderItem"."elementId")');
        //$this->db->group_by('SalesOrderItem.elementId, SalesOrderItem.entityId, SalesOrderItem.itemName'); 
        //$this->db->select('SalesOrder.ordDateComplete,SalesOrderItem.itemId,SalesOrderItem.entityId,SalesOrderItem.elementId,SalesOrderItem.itemName');
        $this->db->from($this->tableSalesOrderItem);	  	
        $this->db->join('SalesOrder','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->join('BuyerComments','SalesOrderItem.itemId = BuyerComments.itemId','left');
        $this->db->where('SalesOrderItem.sellerId',$userId);	
        //$this->db->order_by('CAST("TDS_SalesOrder"."ordDateComplete" as DATE)','DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    
    }
    
    
    
    /*
     ******************************* 
     * This function is used to show sales records by  month wise  
     * with limit 
     ******************************* 
     */   
  
  
    function salesInfoMonthWiseByDate($userId,$from_date,$to_date,$offset=0,$limit=0)
    {
        
        $tableSalesOrderItem=$this->db->dbprefix($this->tableSalesOrderItem);		  
        $tableSalesOrder=$this->db->dbprefix($this->tableSalesOrder);
          
        if($offset!=0 || $limit!=0)
        {
            $isLimit = 'LIMIT '.$limit.' OFFSET '.$offset.'';
        }else
        {
                $isLimit = ' ';
        }  
           
        $sql = 'SELECT 
        date_trunc(\'month\',"'.$tableSalesOrder.'"."ordDateComplete"),  
        COUNT("'.$tableSalesOrder.'"."ordDateComplete") from   
        "'.$tableSalesOrderItem.'" LEFT JOIN "'.$tableSalesOrder.'" ON 
        "'.$tableSalesOrder.'"."ordId" = 
        "'.$tableSalesOrderItem.'"."ordId"  WHERE 
        CAST("'.$tableSalesOrder.'"."ordDateComplete" as DATE) >= 
        \''.$from_date.'\' AND CAST("'.$tableSalesOrder.'"."ordDateComplete" as 
        DATE) <= \''.$to_date.'\' AND "'.$tableSalesOrderItem.'"."sellerId" = 
        \''.$userId.'\' GROUP BY 
        date_trunc(\'month\',"'.$tableSalesOrder.'"."ordDateComplete")  order 
        by  date_trunc(\'month\',"'.$tableSalesOrder.'"."ordDateComplete") 
        DESC '.$isLimit.' ';
       
        $query = $this->db->query($sql); 
        
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    
    }
    
    
    /*
     ******************************* 
     * This function is used to show sales records by  year wise  
     * with limit 
     ******************************* 
     */   
  
  
    function salesInfoYearWiseByDate($userId,$from_date,$to_date,$offset=0,$limit=0)
    {
        
        $tableSalesOrderItem=$this->db->dbprefix($this->tableSalesOrderItem);		  
        $tableSalesOrder=$this->db->dbprefix($this->tableSalesOrder);
          
         if($offset!=0 || $limit!=0)
        {
            $isLimit = 'LIMIT '.$limit.' OFFSET '.$offset.'';
        }else
        {
                $isLimit = ' ';
        }    
           
        $sql = 'SELECT 
        date_trunc(\'year\',"'.$tableSalesOrder.'"."ordDateComplete"),  
        COUNT("'.$tableSalesOrder.'"."ordDateComplete") from   
        "'.$tableSalesOrderItem.'" LEFT JOIN "'.$tableSalesOrder.'" ON 
        "'.$tableSalesOrder.'"."ordId" = 
        "'.$tableSalesOrderItem.'"."ordId"  WHERE 
        CAST("'.$tableSalesOrder.'"."ordDateComplete" as DATE) >= 
        \''.$from_date.'\' AND CAST("'.$tableSalesOrder.'"."ordDateComplete" as 
        DATE) <= \''.$to_date.'\' AND "'.$tableSalesOrderItem.'"."sellerId" = 
        \''.$userId.'\' GROUP BY 
        date_trunc(\'year\',"'.$tableSalesOrder.'"."ordDateComplete")  order 
        by  date_trunc(\'year\',"'.$tableSalesOrder.'"."ordDateComplete") DESC '.$isLimit.' ';
       
        $query = $this->db->query($sql); 
        
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    
    }
    
    
    /*
     ************************
     * This function  is used to get membership details by order id
     ************************
     */	
    
    function membership_order_details($getOrderId,$userId)
    {
        $this->db->select('*');
        $this->db->from($this->tableMembershipOrder);	  	
        $this->db->where('orderId',$getOrderId);
        $this->db->where('tdsUid',$userId);
        $query = $this->db->get();
        //echo $this->db->last_query();	die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->first_row();
        return $result;
    }
    
    
 /*******
   * 
   * This function is used to get all items details by orderId
   * 
   * *****/
  
  function get_membership_item($orderId)
    {
        $this->db->select('UserMembershipItem.*,MasterTsProduct.title');	
        $this->db->from($this->tableUserMembershipItem);
        $this->db->join('MasterTsProduct','MasterTsProduct.tsProductId = UserMembershipItem.tsProductId','left');			
        $this->db->where('orderId',$orderId);	
        $this->db->where('parentContId',0);
        
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    }
    
    
    
    
    /*
     ****************************************************
     *  This funciton get invoice listing by orderid 
     ***************************************************** 
     */   
  
  
    function get_invoice_by_orderId($orderId)
    {
        
        $this->db->group_by('SalesOrderItem.invoiceId'); 
        $this->db->select('SalesOrderItem.invoiceId');
        $this->db->from($this->tableSalesOrderItem);	  	
        $this->db->join('SalesOrder','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->where('SalesOrderItem.ordId',$orderId);
        $query = $this->db->get();
        //echo $this->db->last_query();	die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->result();
        return $result;
    
    }
    
    
    /*
     ********************************************** 
     *  This function is used to get purchase details by itemId
     ********************************************** 
     */ 
    
    
    
    function purchased_details_by_itemId($itemId)
    {
        $this->db->select('SalesOrder.*,SalesOrderItem.itemId,SalesOrderItem.registrationId,SalesOrderItem.invoiceId,SalesOrderItem.entityId,SalesOrderItem.elementId,SalesOrderItem.itemQty,SalesOrderItem.sellerId,SalesOrderItem.sellerInfo,SalesOrderItem.basePrice,SalesOrderItem.itemName,SalesOrderItem.purchaseType,SalesOrderItem.receiverTransactionId');
        $this->db->from($this->tableSalesOrder);	  	
        $this->db->join('SalesOrderItem','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->where('SalesOrderItem.itemId',$itemId);
        //$this->db->where('SalesOrder.customerUid',$userId);	
        //$this->db->or_where('SalesOrderItem.sellerId',$userId);	
        $query = $this->db->get();
         //echo $this->db->last_query();	die;
        $result['get_num_rows'] = $query->num_rows();
        $result['get_result'] = $query->first_row();
        return $result;
    }	
    
    
    
    /*
     ********************************************** 
     *  This function is used update invoice email status change
     ********************************************** 
     */ 
     
     
    function isInvoiceSent($orderId)
    {		
        
        $this->db->set('isInvoiceSent','t');	
        $this->db->where('ordId',$orderId);	
        $query = $this->db->update($this->tableSalesOrder);
        //echo $this->db->last_query();	die;
        return $this->db->affected_rows() > 0;
    }
    
    
    
    
    function getBuyerInfo($trackingId){
        
        $this->db->select('*');
        $this->db->from($this->tableSalesOrder);	  			
        $this->db->where('trackingId',$trackingId);	
        $query = $this->db->get();	
        //echo $this->db->last_query();	die;
        $result=$query->result(); 
      if($query->num_rows() > 0) {
             return $result;				  
      } else {
            return false;
        }	
        
        }
    

    //-----------------------------------------------------------------------
    
    /*
    *  @description: This method is use to delete item table data by order customerid
    *  @prama: loggedIn userId
    *  @prama: entityId
    *  @prama: elementId
    *  @auther: lokendra meena
    *  @return: void
    */
    
    public function getauctiontempdata($tdsUid,$entityId,$elementId){
        
        $this->db->select('SalesOrder.ordId,SalesOrderItem.itemId');
        $this->db->from($this->tableSalesOrder);	  	
        $this->db->join('SalesOrderItem','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->or_where('SalesOrder.customerUid',$tdsUid);	
        $this->db->where('SalesOrderItem.elementId',$elementId);
        $this->db->where('SalesOrderItem.entityId',$entityId);	
        $this->db->where('SalesOrderItem.purchaseType',6);	
        $query = $this->db->get();
        $result = $query->result();
        return $result;
        
    } 
    
    //-----------------------------------------------------------------------
    
    /*
    *  @description: This method is use to delete item table data by order customerid
    *  @prama: loggedIn userId
    *  @prama: entityId
    *  @prama: elementId
    *  @auther: lokendra meena
    *  @return: void
    */
    
    public function purchaseOrderItemDetails($itemId){
        
        $this->db->select('SalesOrder.ordDateComplete,SalesOrderItem.entityId,SalesOrderItem.elementId');
        $this->db->from($this->tableSalesOrder);	  	
        $this->db->join('SalesOrderItem','SalesOrder.ordId = SalesOrderItem.ordId','left');
        $this->db->where('SalesOrderItem.itemId',$itemId);	
        $this->db->where('SalesOrderItem.purchaseType',6);	
        $query = $this->db->get();
        $result = $query->row();
        return $result;
        
    } 
    
} 
