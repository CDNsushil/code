<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Membership Modal
 * 
 * @Description: This class is use to manage user membership data
 * package selction and purchase space and upgrade plane 
 * 
 */ 

class model_membershipcart extends CI_Model { 
    
  private $tableMasterTsProduct         =  'MasterTsProduct';
  private $tableMasterPackgesRole       =  'MasterPackgesRole';
  private $tableTsProductInfo           =  'TDS_TsProductInfo';
  private $tableUserDefaultTsProduct    =  'UserDefaultTsProduct';
  private $tableProject                 =  'Project';
  private $tableMasterIndustry          =  'MasterIndustry';
  private $tableMembershipCart          =  'MembershipCart';
  private $tableMembershipCartItem      =  'MembershipCartItem';
  private $tableMembershipOrder	        =  'MembershipOrder';
  private $tableUserContainer           =  'UserContainer';
  private $tableUserMembershipItem      =  'UserMembershipItem';
  private $tableMasterPackage           =  'MasterPackage';
  private $tableUserAuth                =  'UserAuth';
  private $tableUserProfile             =  'UserProfile';
  private $tableUserShowcase            =  'UserShowcase'; # user profiles	
  private $UserBuyerSettings            =  'UserBuyerSettings'; # user profiles
  
  //---------------------------------------------------------------------------
 
  /*
   * Construct
   */ 
  
  function __construct(){
    parent::__construct();
  } 
  
  //---------------------------------------------------------------------------
  
 /* 
  * @Description: Get product details
  * @param: Int
  * @return: Object
  */
  
 function getProductDetails($productId) {
    $this->db->select('tsProductId,title,price,duration,size,defaultImage');
    $this->db->from($this->tableMasterTsProduct);
    $this->db->where('tsProductId',$productId);
    $query = $this->db->get();
    return $query->result();		
  }
  
  
  /* Get Product Details */
    
  function getAssociatedSpace($productId) {
    
    $this->db->select('associatedSpace');
    $this->db->from($this->tableMasterTsProduct);
    $this->db->where('tsProductId',$productId);
    $query = $this->db->get();
    $result = $query->row();
    $val =$result->associatedSpace;
    
    $value = preg_replace("/[^0-9]/",",",$val);		
    $value = explode(',',$value);
      $details = array();
       $i=1;
      foreach ($value as $val){
              
          if($val!=''){					
            $details[$i] = $this->getAssociatedSpaceDetails($val);					
          $i++; }			
        }
        
   return $details;
        
  }	
  
  /* Get Product Details */
    
  function getAssociatedSpaceDetails($productId) {
    
    $this->db->select($this->tableMasterTsProduct.'.tsProductId as extraspaceId,'.$this->tableMasterTsProduct.'.price,'.$this->tableMasterTsProduct.'.size');
    $this->db->select('MembershipCartItem.parentCartItemId');
    $this->db->from($this->tableMasterTsProduct);
    $this->db->join('MembershipCartItem','MembershipCartItem.tsProductId ='.$this->tableMasterTsProduct.'.tsProductId','left');
    $this->db->where($this->tableMasterTsProduct.'.tsProductId',$productId);
    $query = $this->db->get();
    return $query->result();		
  }
  
  
  
  function getCartItemDetails($productId,$parentId='',$cartId) {
    $this->db->select('tsProductId,cartItemId');
    $this->db->from($this->tableMembershipCartItem);
    $this->db->where('tsProductId',$productId);

    if($parentId!='')
    $this->db->where('parentCartItemId',$parentId);

    $this->db->where('cartId',$cartId);
    $query = $this->db->get();
    $result = $query->result();		
    if($result)
      return $result[0];		
  }
  
  
  function getUserContainerData($orderId) {
    $this->db->select('*');
    //$this->db->from($this->tableUserContainer);
    $this->db->from('UserContainer');
    $this->db->where('orderId',$orderId);		
    $query = $this->db->get();
    $result = $query->result();		
    if($result)
      return $result;		
  }	
  
  //---------------------------------------------------------------------------
  
  /*
   * @description: This function is use to get user billing  details
   * @param: int 
   * @return: Object
   */ 
  
  function getUserBillingDetails($userId){	  
    $this->db->select('UserBuyerSettings.*,MasterCountry.countryName,MasterCountry.countryGroup,EuVatIdentificationNumber');	
    $this->db->from('UserBuyerSettings');	
    $this->db->join('MasterCountry','MasterCountry.countryId = UserBuyerSettings.billing_country','left');
    $this->db->join('ConsumptionTax','ConsumptionTax.countryId = UserBuyerSettings.billing_country','left');	
    $this->db->where('UserBuyerSettings.tdsUid',$userId);	
    $query = $this->db->get();
    $result=$query->row();
    return $result;
  }
  
  //----------------------------------------------------------------------------
  

 function getUserCountry($id)	{
   
  $this->db->select('MasterCountry.countryName,MasterCountry.countryGroup');	
  $this->db->from('UserProfile');	
  $this->db->join('MasterCountry','MasterCountry.countryId = UserProfile.countryId','left');		
  $this->db->where('UserProfile.tdsUid',$id);	
  $query = $this->db->get();
  //echo $this->db->last_query();
  $result=$query->result();
  if($result)
   return $result[0];
  }
  
 function addData($insert){
    
    $query = $this->db->insert($this->tableMembershipCart, $insert);	
    $ID=$this->db->insert_id();		
    //echo $this->db->last_query();die;	
    return $ID;
   }		
  
  
  function addDataMem($insert){	  
    $query = $this->db->insert($this->tableMembershipCartItem, $insert);	
    $ID=$this->db->insert_id();				
    return $ID;
   }
   
  function addOrderData($insert){
    
    $query = $this->db->insert($this->tableMembershipOrder, $insert);	
    $ID=$this->db->insert_id();				
    return $ID;
   }	 
   
  
 function getUserBuyData(){	
      $cartId=$this->session->userdata('currentCartId');  
      //$cartId=350;  
    $this->db->select('tsProductId,cartItemId,type,elementId');	
    $this->db->from($this->tableMembershipCartItem);
    $this->db->where('cartId',$cartId);	
    $this->db->where('parentCartItemId','0');
    $this->db->order_by('cartItemId','asc');	
    $query = $this->db->get();
    //echo $this->db->last_query();
    $result=$query->result();		
    return $result;
   }	
  
  //---------------------------------------------------------------------------
  
  /*
   * @Description: This function is use to  get user buy data
   * @return: object
   * @auther: lokendra 
   */ 
   
  function packagesuserbuydata(){	
    $cartId=$this->session->userdata('packageCartId');  
    $this->db->select('tsProductId,cartItemId,type,elementId');	
    $this->db->from($this->tableMembershipCartItem);
    $this->db->where('cartId',$cartId);	
    $this->db->where('parentCartItemId','0');
    $this->db->order_by('cartItemId','asc');	
    $query = $this->db->get();
    //echo $this->db->last_query();
    $result=$query->result();		
    return $result;
  }	
   
   
   function getExtraSpace($cartItemId){	
     
    $this->db->select('price,size');	
    $this->db->from($this->tableMembershipCartItem);
    $this->db->where('parentCartItemId',$cartItemId);			
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    $result=$query->result();		
      if($result){
           return $result[0];
      }else{
           return false;
        }		
   }	
   
   
 function deleteCartItem($Id){	   		
     $this->db->where('cartItemId',$Id);
     $this->db->or_where('parentCartItemId',$Id);		
     $this->db->delete($this->tableMembershipCartItem);
     return true;				
    }	
    
  function deleteCart($cartId,$ProductId,$cartItemId=''){		   		
     $this->db->where('cartId',$cartId);
     $this->db->where('tsProductId',$ProductId);	   	
     $this->db->delete($this->tableMembershipCartItem);
     
     $this->deleteChild($cartId,$cartItemId);
     return true;				
    }
    
  function deleteChild($cartId,$cartItemId){		   		
     $this->db->where('cartId',$cartId);
     $this->db->where('parentCartItemId',$cartItemId);		   
     $this->db->delete($this->tableMembershipCartItem);
     // echo $this->db->last_query();	die;
     return true;				
    }	
    
  function getTotalPrice($cartItemId,$field='tsProductId',$sum){			
    $this->db->select("SUM($sum) AS total");		
    $this->db->where($field,$cartItemId);		   
    $this->db->order_by($field,'desc');
        $this->db->group_by($field);
    $query = $this->db->get($this->tableMembershipCartItem);
    // echo $this->db->last_query();	die;
    $result=$query->result();
      if($result){
           return $result[0];
      }else{
           return false;
        }		
  }		
          
  
  
 function getUserProfileData($userId){		
  $this->db->select($this->UserBuyerSettings.'.*');
  $this->db->select($this->tableUserProfile.'.*');
  $this->db->select('MasterCountry.countryName,MasterCountry.countryGroup');	
  $this->db->select($this->tableUserAuth.'.email');
  $this->db->from($this->tableUserProfile);
  $this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = '.$this->tableUserProfile.'.tdsUid','left');
  $this->db->join('MasterCountry','MasterCountry.countryId = UserProfile.countryId','left');
  
  $this->db->join($this->UserBuyerSettings, $this->UserBuyerSettings.'.tdsUid = '.$this->tableUserProfile.'.tdsUid','left');
  $this->db->where($this->tableUserProfile.'.tdsUid', $userId);
  $query = $this->db->get();
  //echo $this->db->last_query();
  if ($query->num_rows()) return $query->result();
  return false;
 }
    
    
  function getSelectedTools($cartId,$ProductId){
  
    $this->db->select("count(*) as count,tsProductId");
    $this->db->where('cartId',$cartId);
    $this->db->where('tsProductId',$ProductId);
        $this->db->order_by('tsProductId','desc');
        $this->db->group_by('tsProductId');
        
        $query = $this->db->get($this->tableMembershipCartItem);
     
    $result=$query->result();
      if($result){
       return $result[0];
      }else{
        return false;
         }
    }	 



    function getAllCartItems($cartId){
      
    $this->db->select($this->tableMembershipCartItem.'.*');		
    $this->db->where('cartId',$cartId);	
    $this->db->where('parentCartItemId','0'); 
    $this->db->order_by('cartItemId','asc');       
        $query = $this->db->get($this->tableMembershipCartItem);
     
    $result=$query->result();
      if($result){
         return $result;
      }else{
          return false;
      }
    }	 


 function getAllChildItems($cartItemId){	
    $this->db->select($this->tableMembershipCartItem.'.*');
    //$this->db->select('role.pkgRoleId,role.pkgId');
    //$this->db->join($this->tableMasterPackgesRole.' as role', 'role.tsProductId ='.$this->tableMembershipCartItem.'.tsProductId','left');		
    $this->db->where('parentCartItemId',$cartItemId);        
        $query = $this->db->get($this->tableMembershipCartItem);
     
    $result=$query->result();
      if($result){
         return $result;
      }else{
          return false;
      }
    }  



    
  function isExtraSpaceChecked($parentId,$ProductId){
     $cartId=$this->session->userdata('currentCartId');  
     // $cartId=3;  
    $this->db->select('cartItemId');	
    $this->db->from($this->tableMembershipCartItem);
    $this->db->where('cartId',$cartId);	
    $this->db->where('parentCartItemId',$parentId);	
    $this->db->where('tsProductId',$ProductId);	
    $query = $this->db->get();
    $result=$query->result();
      if($result){
            return true;
        }else{
             return false;
           }	  
    }		
    
  
  function getBillingDetails(){
   $cartId=$this->session->userdata('currentCartId');	  
   if($cartId) { 
    $this->db->select('billingdetails');	
    $this->db->from($this->tableMembershipCart);
    $this->db->where('cartId',$cartId);
    //$this->db->order_by('cartItemId','asc');			
    $query = $this->db->get();
    $result=$query->result();
    if($result){
        return $result[0];
      }else{
         return false;
      } 
   }	  
 }			


  function getCartItemId($productId,$cartId){	
      
    $this->db->select('cartItemId');	
    $this->db->from($this->tableMembershipCartItem);
    $this->db->where('cartId',$cartId);	
    $this->db->where('tsProductId',$productId);
    $this->db->order_by('cartItemId','desc');	
    $query = $this->db->get();
    //echo $this->db->last_query();
    $result=$query->result();		
    return $result;
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
  
  
/* Get PackageId & Role */	
function getRoleId($productId) {
  
//	$this->db->select('pkg.pkgName,pkg.pkgValidity,pkg.pkgPrice,pkg.pkgType');
    $this->db->select('role.pkgRoleId,role.pkgId');
  //	$this->db->select('prod.title,prod.price,prod.size,prod.duration,prod.allowedSections,prod.type,prod.defaultImage');
    $this->db->from($this->tableMasterPackage.' as pkg');
    $this->db->join($this->tableMasterPackgesRole.' as role', 'role.pkgId = pkg.pkgId','left');
    $this->db->join($this->tableMasterTsProduct.' as prod', 'prod.tsProductId = role.tsProductId','left');
    $where=array('pkg.pkgActiveStatus'=>'t','pkg.isFree'=>'f','prod.type'=>'1','prod.tsProductId'=>$productId);
    $this->db->where($where);
    //$this->db->where($this->tableMasterPackgesRole.'.tsProductId',$productId);
    $this->db->order_by('role.pkgId','ASC');
    $query = $this->db->get();
    if ($query->num_rows()) return $query->result_array();
    return False;
  
  
  
  
  
    
    $this->db->select($this->masterPackageRoles.'.pkgId,'.$this->masterPackageRoles.'.pkgRoleId');
    //$this->db->select('MembershipCartItem.parentCartItemId');
    $this->db->from($this->masterPackageRoles);
    $this->db->join('MasterPackage','MasterPackage.pkgId ='.$this->masterPackageRoles.'.pkgId','left');
    
    $where=array('pkg.pkgActiveStatus'=>'t','pkg.isFree'=>'f','prod.type'=>'1');
    $this->db->where($where);
    $this->db->where($this->masterPackageRoles.'.tsProductId',$productId);
    $query = $this->db->get();
    return $query->result();		
  }	
  
  
  /*
   ************************** 
   * This function is used to get container expire date
   ************************** 
   */ 
  
  function getContainerExpireDate($pkgRoleId){
    
    $this->db->select('role.initialValidity');
    $this->db->select('pkg.pkgValidity');
    $this->db->select('prod.duration');
    $this->db->from($this->tableMasterPackgesRole.' as role');
    $this->db->join($this->tableMasterPackage.' as pkg', 'role.pkgId = pkg.pkgId','left');
    $this->db->join($this->tableMasterTsProduct.' as prod', 'prod.tsProductId = role.tsProductId','left');
    $where=array('role.pkgRoleId'=>$pkgRoleId);
    $this->db->where($where);
    $this->db->order_by('role.pkgRoleId','ASC');
    $query = $this->db->get();
    //echo $this->db->last_query();die();
    $result=$query->row();
    return $result;
  }
  
  
  
  
  /* Get item container space with add space */   	
 function getContainerPrice($memItemId){		
  $this->db->select("SUM(size) AS total");		
  $this->db->where('memItemId',$memItemId);
  $this->db->or_where('parentContId',$memItemId);	
  $query = $this->db->get($this->tableUserMembershipItem);		
  $result=$query->result();
    if($result){
       return $result[0];
    }else{
        return false;
    }			
 }
  
  
 function getMembershipItem($orderId){	 
  $this->db->select($this->tableUserMembershipItem.'.*');	
  $this->db->select('master.allowedSections,master.duration,master.title');		 
  $this->db->join($this->tableMasterTsProduct.' as master', 'master.tsProductId ='.$this->tableUserMembershipItem.'.tsProductId','left');	
  $this->db->where('orderId',$orderId);	
  //$this->db->where('parentContId','0');
  $this->db->order_by('memItemId','asc');	
  $query = $this->db->get($this->tableUserMembershipItem);
  //echo $this->db->last_query();
  $result=$query->result();		
     return $result;
  }	
  
  
  /* Get Sum of duration /containersize */
  function getContainerTotal($orderId,$field='orderId',$sum='containerSize'){	
        
    $this->db->select('SUM("'.$sum.'") AS total');		
    $this->db->where($field,$orderId);		   
    $this->db->order_by($field,'desc');
        $this->db->group_by($field);
    $query = $this->db->get('UserContainer');
    // echo $this->db->last_query();	die;
    $result=$query->result();
      if($result){
           return $result[0];
      }else{
           return false;
        }		
  }
  
  
 /* Get data from Container Table */
 
  function getContainerData($orderId){	  		
  $this->db->select('userContainerId,tsProductId');		
  $this->db->where('orderId',$orderId);		   
  $this->db->order_by('userContainerId','asc');	
  $query = $this->db->get('UserContainer');
  // echo $this->db->last_query();	die;
  $result=$query->result();
    if($result){
       return $result;
    }else{
       return false;
    }		
  }		


  /* GET Current Cart Id of User */
  function getCurrentCartId ($userId){
  $this->db->select('cartId');		
  $this->db->where('tdsUid',33);	
  $query = $this->db->get($this->tableMembershipCart);
  $result = $query->row();
  
  if ($query->num_rows()) {
     return $val =$result->cartId;
   }
   else {
    return 0;  
     }  
    
  }
  
  
  /* Get Element Id & Product inbo based on userContainerID */
  
  function getUserContainerInfo($userContainerId) {
  $this->db->select('*');
  $this->db->from($this->tableUserContainer);	
  $this->db->join($this->tableMasterTsProduct.' as master', 'master.tsProductId ='.$this->tableUserContainer.'.tsProductId','left');
  $this->db->where($this->tableUserContainer.'.userContainerId',$userContainerId);		
  $query = $this->db->get();
  $result = $query->result();		
  if($result)
    return $result;		
  }
  
  /* Get project Id & industry type to check user folder space */ 
   function getSizeCalculation($userContainerId){	
      $this->db->select('proj.projId,proj.projectType');	
    $this->db->from($this->tableUserContainer);	
      $this->db->join($this->tableProject.' as proj', 'proj.userContainerId ='.$this->tableUserContainer.'.userContainerId','left');
    $this->db->where($this->tableUserContainer.'.userContainerId',$userContainerId);			
    $query = $this->db->get();
    //echo $this->db->last_query();
    if ($query->num_rows()) {
        $result=$query->result();
        return $result[0];
    } else {
      return 0;  
      } 		
    }
    
  /* Calculate Price based on Space product id in db */
  
 function getSpaceInfo(){
   $this->db->select('size,price');
   $this->db->from($this->tableMasterTsProduct);
   $this->db->where('tsProductId',20);	
   $query = $this->db->get();
   if ($query->num_rows()) {
     $result=$query->result();
     $result = $result[0];
     if(($result->size!='') && ($result->price!='') ){			 
       $size=bytestoMB($result->size,'mb');
       $price =   $result->price / $size;
       return $price;			 
       }		 
  } else {
    return 0;  
  } 	 
 }   
    
  function getMembershipSpacePrice($itemId)
  {
    $this->db->select('price');	
    $this->db->from('MembershipCartItem');			
    $this->db->where('parentCartItemId',$itemId);	
    $query = $this->db->get();
    //echo $this->db->last_query();
    if($query->num_rows() > 0){
      $result = $query->row()->price;
    }else
    { $result = 0;	}
    return $result;
  }	  
  
  //-------------------------------------------------------------------------
    
  /*
   *  @Description: This function is used to delete data
   *  from membership cart and  membership cart item
   *  @return: void 
   */ 	
  
  function delete_temp_membership_item($itemId)
  {
    // record delete from membershipCart
    $this->db->where('cartId', $itemId);
    $this->db->delete($this->tableMembershipCart);
    $this->db->where_in('cartId', $itemId);
    $this->db->delete($this->tableMembershipCartItem); 
    
  }
  
  //-------------------------------------------------------------------------
   
  /*
   *  @Description: This function is used update invoice membership order
   *  @return: number 
   */
   
  function membershipInvoiceNumberUpdate($itemId,$invoiceData)
    {		
    $this->db->set($invoiceData);	
    $this->db->where('cartId',$itemId);	
    $query = $this->db->update($this->tableMembershipOrder);
    return $this->db->affected_rows() > 0;
  }
  
  //-------------------------------------------------------------------------
  
  /*
   * @Description: This function  is used to membership order details 
   * for preparing invoice 
   * @param: orderId
   * @return: object
   *
   */	
  
  function membership_order_details($orderId)
  {
    $this->db->select('*');
    $this->db->from($this->tableMembershipOrder);
    $this->db->where('orderId',$orderId);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  //-------------------------------------------------------------------------
  
  /*
   ******************************************* 
   * This function is used to get all items details by orderId
   ******************************************* 
   */
  
  function get_membership_item($orderId)
  {
    $this->db->select('UserMembershipItem.*,MasterTsProduct.title');	
    $this->db->from($this->tableUserMembershipItem);
    $this->db->join('MasterTsProduct','MasterTsProduct.tsProductId = UserMembershipItem.tsProductId','left');			
    $this->db->where('orderId',$orderId);	
    $this->db->where('parentContId',0);
    $query = $this->db->get();
    return $query->result_array();
  }
  
  //-------------------------------------------------------------------------
  
  /*
   ************************************ 
   * this function is used to get item name by container id
   ************************************ 
   */ 
  
  
  function get_Item_Membership($tableUserContainer){	
     
    $this->db->select('UserContainer.userContainerId,MasterTsProduct.title');	
    $this->db->from($this->tableUserContainer);
    $this->db->join('MasterTsProduct','MasterTsProduct.tsProductId = UserContainer.tsProductId','left');
    $this->db->where('userContainerId',$tableUserContainer);			
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    $result['get_num_rows'] = $query->num_rows();
    $result['get_result'] = $query->row();
    return $result;	
   }
   
  //-------------------------------------------------------------------------
  
/* PAYPAL TRANSACTION DETAILS */	
  
  function getOrderdDetails($orderId=''){	  
    $result=false;
    if($orderId !=''){

      $this->db->select('*');	
      $this->db->from($this->tableMembershipOrder);
      $this->db->join($this->tableUserMembershipItem,$this->tableUserMembershipItem.'.orderId ='.$this->tableMembershipOrder.'.orderId');					
      $this->db->where($this->tableUserMembershipItem.'.parentContId','0');
      $this->db->where($this->tableMembershipOrder.'.orderId',$orderId);	
      $query = $this->db->get();
      //echo $this->db->last_query();
      $result=$query->result();
    }
    return $result;  
  } 	
  
  //-------------------------------------------------------------------------
  
  function getOrderSpace($cartItemId){	
     
    $this->db->select('basePrice as price,size');	
    $this->db->from($this->tableUserMembershipItem);
    $this->db->where('parentContId',$cartItemId);			
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    $result=$query->result();		
      if($result){
           return $result[0];
      }else{
           return false;
        }		
   }	
   
   //-------------------------------------------------------------------------
   
   function getAddSpace($prodId){	
     
    $this->db->select('basePrice as price,size');	
    $this->db->from($this->tableUserMembershipItem);
    $this->db->where('memItemId',$prodId);			
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    $result=$query->result();		
      if($result){
           return $result[0];
      }else{
           return false;
        }		
   }
   
   //-------------------------------------------------------------------------
   
  
  function getOrderProductDetails($productId,$orderId) {
    
    $this->db->select($this->tableMasterTsProduct.'.tsProductId,'.$this->tableMasterTsProduct.'.title,'.$this->tableMasterTsProduct.'.defaultImage,'.$this->tableMasterTsProduct.'.duration');
    $this->db->select($this->tableUserMembershipItem.'.basePrice as price,'.$this->tableUserMembershipItem.'.size');
    
    $this->db->from($this->tableUserMembershipItem);
    $this->db->join($this->tableMasterTsProduct,$this->tableMasterTsProduct.'.tsProductId ='.$this->tableUserMembershipItem.'.tsProductId');					
    $this->db->where($this->tableUserMembershipItem.'.tsProductId',$productId);
    $this->db->where($this->tableUserMembershipItem.'.orderId',$orderId);
    $this->db->limit(1);
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    return $query->result();		
  }
  
  //-------------------------------------------------------------------------
  
  
  function Sal(){
    
    $this->db->select('orderId,ordNumber');
    $this->db->from($this->tableMembershipOrder);			
    $query = $this->db->get();	
    //$this->db->order_by('itemId','DESC');
    //echo $this->db->last_query();	die;
    $result=$query->result(); 
    if($query->num_rows() > 0) {
         return $result;				  
      } else {
        return false;
      }	
    
    
    
    }
  
  //-------------------------------------------------------------------------
  
  /* Refund */
  
  
  /* Get item container space with add space */   	
 function getRefundItemPrice($userContainerId,$orderId){		
  $this->db->select('SUM("totalPrice") AS price');		
  $this->db->where('userContainerId',$userContainerId);
  $this->db->where('orderId',$orderId);	
  $query = $this->db->get($this->tableUserMembershipItem);	
  //echo $this->db->last_query();die;	
  $result=$query->result();
    if($result){
       return $result[0];
    }else{
        return 0;
    }			
 }
  
  //-------------------------------------------------------------------------
  
 /* Get item container space with add space */   	
 function getRefundItemSize($userContainerId,$orderId){		
  $this->db->select('SUM(size) AS size');		
  $this->db->where('userContainerId',$userContainerId);
  $this->db->where('orderId',$orderId);	
  $query = $this->db->get($this->tableUserMembershipItem);	
  //echo $this->db->last_query();die;	
  $result=$query->result();
    if($result){
       return $result[0];
    }else{
        return 0;
    }			
 }
  
  //-------------------------------------------------------------------------
  
	/**
	 * Get users last third year order details
	 */
	function getLastThirdYearOrder($userId,$pkgId)	{
   
		$this->db->select($this->tableUserMembershipItem.'.orderId,'.$this->tableUserMembershipItem.'.basePrice as price,'.$this->tableUserMembershipItem.'.memItemId');
		$this->db->select($this->tableMembershipOrder.'.ordNumber as transactionid');
		
		$this->db->from($this->tableUserMembershipItem);
		$this->db->join($this->tableMembershipOrder,$this->tableMembershipOrder.'.orderId ='.$this->tableUserMembershipItem.'.orderId');					
		$this->db->where($this->tableUserMembershipItem.'.tdsUid',$userId);
		$this->db->where($this->tableUserMembershipItem.'.pkgId',$pkgId);
		$this->db->order_by($this->tableUserMembershipItem.'.memItemId','desc');
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		return $query->row();	
	}

	//--------------------------------------------------------------------------
	
	/*
	 * @access: public
	 * @description: This function is use to get user not used container listing
	 * @return array
	 */ 
	function userNotUsedDefaultProduct($userId)
  {
    $this->db->select('udtp.userDefaultTsProductId, udtp.tsProductId, uc.userContainerId');
    $this->db->from('UserDefaultTsProduct as udtp');	 
    $this->db->join('UserContainer as uc','uc.userDefaultTsProductId = udtp.userDefaultTsProductId','left');
    $this->db->where('udtp.tdsUid',$userId); 
    $this->db->where('uc.containerSize','104857600'); //default container size for not add space
    $this->db->where('uc.entityId','0'); //entity id should be  0 for not used container
    $this->db->where('uc.elementId','0'); //elementId id should be  0 for not used container
    $this->db->order_by('udtp.userDefaultTsProductId','desc');
    $query = $this->db->get();
    return $query->result_array();
  }

} 
