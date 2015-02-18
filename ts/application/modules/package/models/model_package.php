<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}
/* =================================================================================================
  //Start Date: 19-01-12 Added by sushil for common select, insert, update, delee query  
====================================================================================================*/

class model_package extends CI_Model { 
  
  private $tableMasterPackage             =  'MasterPackage';
  private $tableMasterTsProduct           =  'MasterTsProduct';
  private $tableMasterPackgesRole         =  'MasterPackgesRole';
  private $tableUserContainer             =  'UserContainer';
  private $tableTsProductInfo             =  'TDS_TsProductInfo';
  private $tableUserDefaultTsProduct      =  'UserDefaultTsProduct';
  private $tableProject                   =  'Project';
  private $tableMasterIndustry            =  'MasterIndustry';
  private $tableUserAuth                  =  'UserAuth';
  private $tableUserProfile               =  'UserProfile';
  private $tableUserShowcase              =  'UserShowcase';
  private $tableStockImages               =  'StockImages';
  private $tableSalesOrder                =  'SalesOrder';
  private $tableUserSubscription          =  'UserSubscription';
  private $tableMediaFile                 =  'MediaFile';
  
  
  /**
   * Constructor
   */
  
  function __construct()
  {
    parent::__construct();
  }
  
  //----------------------------------------------------------------------
  
  
  /*
   * @access: public 
   * @description: This function will get package information
   * @return object
   */
  
  function packageinformation()
  {
    $this->db->select('pkg.pkgName,pkg.pkgValidity,pkg.pkgPrice,pkg.pkgType');
    $this->db->select('role.pkgRoleId,role.pkgId,role.tsProductId,role.qty,role.initialValidity');
    $this->db->select('prod.title,prod.price,prod.size,prod.duration,prod.allowedSections,prod.type,prod.defaultImage,prod.productSequence');
    $this->db->select('prodinfo.infoId,prodinfo.title as infotitle ,prodinfo.subTitle as infosubTitle,prodinfo.description as infodescription,prodinfo.notes as infonotes');
    $this->db->from($this->tableMasterPackage.' as pkg');
    $this->db->join($this->tableMasterPackgesRole.' as role', 'role.pkgId = pkg.pkgId','left');
    $this->db->join($this->tableMasterTsProduct.' as prod', 'prod.tsProductId = role.tsProductId','left');
    $this->db->join($this->tableTsProductInfo.' as prodinfo', 'prodinfo.tsProductId = prod.tsProductId','left');
    $where=array('pkg.pkgActiveStatus'=>'t');
    $packageId=$this->config->item('packageDBId');//available package id
    $this->db->where($where);
    $this->db->where_in('pkg.pkgId',$packageId);
    $this->db->order_by('prod.productSequence','ASC');
    $query = $this->db->get();
    if ($query->num_rows()) return $query->result_array();
    return False;
  }
  
  //----------------------------------------------------------------------
  
  function productListing(){
    $this->db->select('pkg.pkgName,pkg.pkgValidity,pkg.pkgPrice,pkg.pkgType');
    $this->db->select('role.pkgRoleId,role.pkgId,role.tsProductId,role.qty,role.initialValidity');
    $this->db->select('prod.title,prod.price,prod.size,prod.duration,prod.allowedSections,prod.type,prod.defaultImage');
    $this->db->from($this->tableMasterPackage.' as pkg');
    $this->db->join($this->tableMasterPackgesRole.' as role', 'role.pkgId = pkg.pkgId','left');
    $this->db->join($this->tableMasterTsProduct.' as prod', 'prod.tsProductId = role.tsProductId','left');
    $where=array('pkg.pkgActiveStatus'=>'t','pkg.isVisible'=>'t','pkg.isFree'=>'f','prod.type'=>'1');
    $this->db->where($where);
    $this->db->order_by('role.pkgId','ASC');
    $query = $this->db->get();
    if ($query->num_rows()) return $query->result_array();
    return False;
  }
  function freePkgDetails($tsProductId=0){
    $this->db->select('pkg.pkgName,pkg.pkgValidity');
    $this->db->select('role.pkgRoleId,role.pkgId,role.tsProductId,role.qty,role.initialValidity');
    $this->db->select('prod.title,prod.size,prod.duration,prod.allowedSections,prod.type');
    
    $this->db->from($this->tableMasterPackgesRole.' as role');
    $this->db->join($this->tableMasterPackage.' as pkg', 'pkg.pkgId=role.pkgId');
    $this->db->join($this->tableMasterTsProduct.' as prod', 'prod.tsProductId = role.tsProductId');
    
    
    $this->db->where('pkg.pkgActiveStatus','t');
    
    
    if(is_numeric($tsProductId) && ($tsProductId>0)){
      $this->db->where('prod.tsProductId',$tsProductId);
    }else{
      $this->db->where('pkg.isFree','t');
    }
    $this->db->order_by('role.pkgId','ASC');
    $this->db->order_by('role.tsProductId','ASC');
    $query = $this->db->get();
    //echo $this->db->last_query();
    if ($query->num_rows()) return $query->result_array();
    return False;
  }
  
  function get_purchased_details($userId=0,$offset=0,$limit=0,$returnRow=false)
  {
    $this->db->select('o.orderId,o.ordNumber,o.orderType,o.tdsUid');
    $this->db->select('i.*');
    $this->db->select('c.entityId,c.elementId,c.createdDate,c.expiryDate,c.startDate,c.IndustryId,c.pkgSections,c.duration,c.title,c.isExpired');
    
    $this->db->from('MembershipOrder as o');	  	
    $this->db->join('UserMembershipItem as i','i.orderId = o.orderId','left');
    $this->db->join('UserContainer as c','c.userContainerId = i.userContainerId','left');
    $this->db->where('o.tdsUid',$userId);	
    $this->db->where('i.parentContId',0);
    if($offset!=0 || $limit!=0){
      $this->db->limit($limit, $offset);
    }
    
    $this->db->order_by('o.orderId','desc');
    $query = $this->db->get();
    //echo $this->db->last_query();
    if($returnRow){
      return $query->num_rows();
    }else{
      return $query->result();
    }
    return $result;
  }
  
  
  /*
   *************************************** 
   * This method is used to get record for membership export by UserId
   *************************************** 
   */ 
  
  
  
  function export_purchased_details($userId=0)
  {
    $this->db->select('o.createDate as Date, o.ordNumber as invoice, o.paypalEmail');
    $this->db->select('c.title');
    $this->db->select('i.size, i.type, i.basePrice, i.taxValue, i.taxPercent, i.totalPrice, i.memItemId');
    $this->db->from('MembershipOrder as o');	  	
    $this->db->join('UserMembershipItem as i','i.orderId = o.orderId','left');
    $this->db->join('UserContainer as c','c.userContainerId = i.userContainerId','left');
    $this->db->where('o.tdsUid',$userId);
    $this->db->where('i.parentContId',0);	
    $this->db->order_by('o.orderId','desc');
    $query = $this->db->get();
    $result['get_num_rows'] =  $query->num_rows();
    $result['get_result'] =  $query->result_array();
    $result['get_first_row']=$query->list_fields('array');
    return $result;
  }
  
  
  /*
   *************************************** 
   * This method is used to get record for all membership export for admin
   *************************************** 
   */ 
  
  
  
  function all_export_purchased_details()
  {
    $this->db->select('o.createDate as Date, o.ordNumber as invoice, o.custName as customerName, o.paypalEmail');
    $this->db->select('c.title');
    $this->db->select('i.size, i.type, i.totalPrice, i.taxPercent, i.taxValue, i.memItemId');
    $this->db->from('MembershipOrder as o');	  	
    $this->db->join('UserMembershipItem as i','i.orderId = o.orderId','left');
    $this->db->join('UserContainer as c','c.userContainerId = i.userContainerId','left');
    $this->db->where('i.parentContId',0);	
    $this->db->order_by('o.orderId','desc');
    $query = $this->db->get();
    $result['get_num_rows'] =  $query->num_rows();
    $result['get_result'] =  $query->result_array();
    $result['get_first_row']=$query->list_fields('array');
    return $result;
  }
   
  //---------------------------------------------------------------------------
  
  /*
   * @Description: This function is used to get my all compaign list for 1/3 year
   * Membership while renew package
   * @auther: lokendra
   * @return object
   */ 
  
  function renew_campaign_list($userId)
  {
    $this->db->select('oxc.campaignname, oxc.userContainerId, oxc.comments, umi.totalPrice');
    $this->db->from('UserContainer as uc');	 
    $this->db->set_dbprefix('tds_'); 	
    $this->db->join('ox_campaigns as oxc','oxc.userContainerId = uc.userContainerId','right');
    $this->db->set_dbprefix('TDS_'); 	
    $this->db->join('UserMembershipItem as umi','umi.memItemId = uc.orderitemid','right');
    $this->db->where('uc.tdsUid',$userId);	
    $this->db->where('uc.tsProductId','23');	
    //$this->db->where('uc.isExpired','t');	
    //$this->db->where('oxc.isExpired','t');	
    $this->db->order_by('uc.userContainerId','desc');
    $query = $this->db->get();
    return $query->result();
  }
  
  
  //---------------------------------------------------------------------------
  
  /*
   * @Description: This function is used to get my all compaign list for 1/3 year
   * Membership while renew package
   * @auther: lokendra
   * @return object
   */ 
  
  function selected_campaign_list($userId,$campaignArrId)
  {
    $this->db->select('oxc.campaignname, oxc.userContainerId, oxc.comments, umi.basePrice, umi.totalPrice, uc.*');
    $this->db->from('UserContainer as uc');	 
    $this->db->set_dbprefix('tds_'); 	
    $this->db->join('ox_campaigns as oxc','oxc.userContainerId = uc.userContainerId','right');
    $this->db->set_dbprefix('TDS_'); 	
    $this->db->join('UserMembershipItem as umi','umi.memItemId = uc.orderitemid','right');
    $this->db->where('uc.tdsUid',$userId);	
    $this->db->where('uc.tsProductId','23');	
    $this->db->where_in('oxc.userContainerId',$campaignArrId);
    $this->db->order_by('uc.userContainerId','desc');
    $query = $this->db->get();
    return $query->result_array();
  }
  
  //----------------------------------------------------------------------------
  
  /*
   * @description: This function is use to user created container section 
   * @return object
   */ 
  
  public function usercontainerlist($userId){
    $this->db->select('uc.pkgSections');
    $this->db->from('UserContainer as uc');	 
    $this->db->where('uc.tdsUid',$userId);	
    $this->db->where('uc.entityId !=','0');	
    $this->db->group_by("uc.pkgSections"); 
    $this->db->order_by("uc.pkgSections",'asc'); 
    $query = $this->db->get();
    return $query->result();
  } 
  
  //---------------------------------------------------------------------------- 
  
  /*
   * @Description: This function is used to get media showcase project list
   * @auther: lokendra
   * @return object
   */ 
   
  function mediashowcaseprojectlist($userId)
  {
    $this->db->select('uc.userContainerId,uc.IndustryId,uc.tdsUid,uc.entityId,uc.elementId,uc.containerSize,uc.usedSize,uc.pkgId,uc.pkgRoleId,uc.userDefaultTsProductId,uc.pkgSections');
    $this->db->select('mp.size,mp.price,mp.price, mp.duration');
    $this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,ls.reviewCount,ls.ratingCount,ls.ratingValue');
    $this->db->select('proj.projName,proj.projTag,proj.projPublisheDate,proj.projectType,proj.projBaseImgPath,proj.isExternalImageURL');
    $this->db->select('mc.countryName');
    $this->db->from('UserContainer as uc'); 
    $this->db->join('MasterTsProduct as mp','mp.tsProductId = uc.tsProductId','left');
    $this->db->join('LogSummary as ls','ls.entityId = uc.entityId AND "ls"."elementId" = "uc"."elementId"');
    $this->db->join('Project as proj','proj.userContainerId = uc.userContainerId','left');
    $this->db->join('MasterCountry as mc','mc.countryId = proj.producedInCountry','left');
    $this->db->where('uc.tdsUid',$userId);
    $this->db->where('uc.entityId','54'); // media showcase entity id
    $query = $this->db->get();
    return $query->result_array();
  }
   
  //---------------------------------------------------------------------------- 

  /*
  * @Description: This function is used to get event and launch project list
  * @auther: lokendra
  * @return array
  */ 

  public function eventlaunchprojectlist($userId){
    $this->db->select('uc.userContainerId, uc.IndustryId, uc.title as containerType,uc.pkgSections,uc.tdsUid,uc.entityId,uc.elementId,uc.containerSize,uc.usedSize,uc.pkgId,uc.pkgRoleId,uc.userDefaultTsProductId,uc.pkgSections');
    $this->db->select('mp.size,mp.price,mp.price, mp.duration');
    $this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,ls.reviewCount,ls.ratingCount,ls.ratingValue');
    $this->db->select('e.NatureId as eventNatureId,e.Title as eventTitle,e.StartDate,e.Type as eventType');
    $this->db->select('le.NatureId as LaunchNatureId,le.Title as lunchTitle,le.LaunchEventCreated,le.Type as launchType');
    $this->db->select('mc.countryName');
    $this->db->select('mf.filePath,mf.fileName,mf.fileId');
    $this->db->from('UserContainer as uc'); 
    $this->db->join('MasterTsProduct as mp','mp.tsProductId = uc.tsProductId','left');
    $this->db->join('LogSummary as ls','ls.entityId = uc.entityId AND "ls"."elementId" = "uc"."elementId"');
    $this->db->join('Events as e','e.userContainerId = uc.userContainerId','left');
    $this->db->join('LaunchEvent as le','le.EventId = e.EventId OR "le"."userContainerId" = "uc"."userContainerId"','left');
    $this->db->join('MasterCountry as mc','mc.countryId = e.OrgCountry','left');
    $this->db->join('MediaFile as mf','mf.fileId = e.FileId ','left'); //OR "mf"."fileId" = "le"."FileId"
    $this->db->where('uc.tdsUid',$userId);
    $entityIdArray = array('9','15'); // for event and launch with event
    $this->db->where_in('uc.entityId',$entityIdArray); 
    $query = $this->db->get();
    //echo $this->db->last_query();die();
    return $query->result_array();
  }
  
  
  //---------------------------------------------------------------------------
  
  /*
   * @Description: This function is used to get campaign project list
   * @return array
   */ 
  
  function addcampaignprojectlist($userId)
  {
    $this->db->select('uc.userContainerId,uc.IndustryId, uc.title as containerType,uc.pkgSections,uc.tdsUid,uc.entityId,uc.elementId,uc.containerSize,uc.usedSize,uc.pkgId,uc.pkgRoleId,uc.userDefaultTsProductId,uc.pkgSections');
    $this->db->select('oxc.campaignname, oxc.userContainerId, oxc.comments, umi.totalPrice');
    $this->db->from('UserContainer as uc');	 
    $this->db->set_dbprefix('tds_'); 	
    $this->db->join('ox_campaigns as oxc','oxc.userContainerId = uc.userContainerId','left');
    $this->db->set_dbprefix('TDS_'); 	
    $this->db->join('UserMembershipItem as umi','umi.memItemId = uc.orderitemid','left');
    $this->db->where('uc.tdsUid',$userId);	
    $this->db->where('uc.entityId','104'); // campaign entity id
    $this->db->order_by('uc.userContainerId','desc');
    $query = $this->db->get();
    return $query->result_array();
  }

  //-------------------------------------------------------------------------
   
  /*
   *  @Description: update membership package subscription
   *  @return: number 
   */
   
  function updateusersubscription($subscriptionId,$subscriptionData)
    {		
    $this->db->set($subscriptionData);	
    $this->db->where('subId',$subscriptionId);	
    $query = $this->db->update($this->tableUserSubscription);
    return $this->db->affected_rows() > 0;
  }
  
  /*
   * @Description: This function is used to get competition project list
   * @return array
   */ 
  
  function competitionprojectlist($userId)
  {
    $this->db->select('uc.userContainerId, uc.IndustryId, uc.title as containerType,uc.pkgSections,uc.tdsUid,uc.entityId,uc.elementId,uc.containerSize,uc.usedSize,uc.pkgId,uc.pkgRoleId,uc.userDefaultTsProductId,uc.pkgSections');
    $this->db->select('comp.title, comp.tagwords,comp.onelineDescription,comp.createdDate,comp.coverImage');
    $this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,ls.reviewCount,ls.ratingCount,ls.ratingValue');
    $this->db->select('umi.totalPrice as price');
    $this->db->select('mc.countryName');
    $this->db->from('UserContainer as uc');	 
    $this->db->join('Competition as comp','comp.userContainerId = uc.userContainerId','left');
    $this->db->join('LogSummary as ls','ls.entityId = uc.entityId AND "ls"."elementId" = "uc"."elementId"','left');
    $this->db->join('UserMembershipItem as umi','umi.memItemId = uc.orderitemid','left');
    $this->db->join('MasterCountry as mc','mc.countryId = comp.countryId','left');
    $this->db->where('uc.tdsUid',$userId);	
    $this->db->where('uc.entityId','102'); // competition entity id
    $this->db->order_by('uc.userContainerId','desc');
    $query = $this->db->get();
    return $query->result_array();
  }
  
  //---------------------------------------------------------------------------
  
  /*
  * @Description: This function is used to Collaboration project list
  * @return array
  */ 
  
  function collaborationprojectlist($userId)
  {
    $this->db->select('uc.userContainerId, uc.IndustryId, uc.title as containerType,uc.pkgSections,uc.tdsUid,uc.entityId,uc.elementId,uc.containerSize,uc.usedSize,uc.pkgId,uc.pkgRoleId,uc.userDefaultTsProductId,uc.pkgSections');
    $this->db->select('coll.title, coll.tagwords,coll.shortDescription,coll.createDate,coll.coverImage');
    $this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,ls.reviewCount,ls.ratingCount,ls.ratingValue');
    $this->db->select('umi.totalPrice as price');
    $this->db->select('mc.countryName');
    $this->db->from('UserContainer as uc');	 
    $this->db->join('Collaboration as coll','coll.userContainerId = uc.userContainerId','left');
    $this->db->join('LogSummary as ls','ls.entityId = uc.entityId AND "ls"."elementId" = "uc"."elementId"','left');
    $this->db->join('UserMembershipItem as umi','umi.memItemId = uc.orderitemid','left');
    $this->db->join('MasterCountry as mc','mc.countryId = coll.countryId','left');
    $this->db->where('uc.tdsUid',$userId);	
    $this->db->where('uc.entityId','105'); // competition entity id
    $this->db->order_by('uc.userContainerId','desc');
    $query = $this->db->get();
    return $query->result_array();
  }
  
  //---------------------------------------------------------------------------
  
  /*
  * @Description: This function is used to Product Classifides project list
  * @return array
  */ 
  
  function productprojectlist($userId)
  {
    $this->db->select('uc.userContainerId, uc.IndustryId, uc.title as containerType,uc.pkgSections,uc.tdsUid,uc.entityId,uc.elementId,uc.containerSize,uc.usedSize,uc.pkgId,uc.pkgRoleId,uc.userDefaultTsProductId,uc.pkgSections');
    $this->db->select('prod.productTitle as title, prod.productDescription,prod.productDateCreated as createDate');
    $this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,ls.reviewCount,ls.ratingCount,ls.ratingValue');
    $this->db->select('umi.totalPrice as price');
    $this->db->select('mc.countryName');
    $this->db->from('UserContainer as uc');	 
    $this->db->join('Product as prod','prod.userContainerId = uc.userContainerId','left');
    $this->db->join('LogSummary as ls','ls.entityId = uc.entityId AND "ls"."elementId" = "uc"."elementId"','left');
    $this->db->join('UserMembershipItem as umi','umi.memItemId = uc.orderitemid','left');
    $this->db->join('MasterCountry as mc','mc.countryId = prod.productCountryId','left');
    $this->db->where('uc.tdsUid',$userId);	
    $this->db->where('uc.entityId','49'); // Product Classifides entity id
    $this->db->order_by('uc.userContainerId','desc');
    $query = $this->db->get();
    return $query->result_array();
  }
  
  //---------------------------------------------------------------------------
  
  /*
  * @Description: This function is used to Upcomming project list
  * @return array
  */ 
  
  function upcommingprojectlist($userId)
  {
    $this->db->select('uc.userContainerId, uc.IndustryId, uc.title as containerType,uc.pkgSections,uc.tdsUid,uc.entityId,uc.elementId,uc.containerSize,uc.usedSize,uc.pkgId,uc.pkgRoleId,uc.userDefaultTsProductId,uc.pkgSections');
    $this->db->select('up.projTitle, up.projPublisheDate');
    $this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,ls.reviewCount,ls.ratingCount,ls.ratingValue');
    $this->db->select('umi.totalPrice as price');
    $this->db->select('mc.countryName');
    $this->db->select('mi.IndustryName');
    $this->db->from('UserContainer as uc');	 
    $this->db->join('UpcomingProject as up','up.userContainerId = uc.userContainerId','left');
    $this->db->join('LogSummary as ls','ls.entityId = uc.entityId AND "ls"."elementId" = "uc"."elementId"','left');
    $this->db->join('UserMembershipItem as umi','umi.memItemId = uc.orderitemid','left');
    $this->db->join('MasterCountry as mc','mc.countryId = up.projCountry','left');
    $this->db->join('MasterIndustry as mi','mi.IndustryId = up.projIndustry','left');
    $this->db->where('uc.tdsUid',$userId);	
    $this->db->where('uc.entityId','71'); // Upcomming entity id
    $this->db->order_by('uc.userContainerId','desc');
    $query = $this->db->get();
    return $query->result_array();
  }
  
  //---------------------------------------------------------------------------
  
  /*
  * @Description: This function is used to Work Profile & Work Profile App project list
  * @return array
  */ 
  
  function workprofileprojectlist($userId)
  {
    $this->db->select('uc.userContainerId, uc.IndustryId, uc.title as containerType,uc.pkgSections,uc.tdsUid,uc.entityId,uc.elementId,uc.containerSize,uc.usedSize,uc.pkgId,uc.pkgRoleId,uc.userDefaultTsProductId,uc.pkgSections');
    $this->db->select('wp.synopsis, wp.dateCreated');
    $this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,ls.reviewCount,ls.ratingCount,ls.ratingValue');
    $this->db->select('umi.totalPrice as price');
    $this->db->select('mc.countryName');
    $this->db->select('mf.filePath,mf.fileName');
    $this->db->from('UserContainer as uc');	 
    $this->db->join('WorkProfile as wp','wp.userContainerId = uc.userContainerId','left');
    $this->db->join('LogSummary as ls','ls.entityId = uc.entityId AND "ls"."elementId" = "uc"."elementId"','left');
    $this->db->join('UserMembershipItem as umi','umi.memItemId = uc.orderitemid','left');
    $this->db->join('MasterCountry as mc','mc.countryId = wp.profileCountry','left');
	$this->db->join('MediaFile as mf','mf.fileId = wp.fileId','left');
    $this->db->where('uc.tdsUid',$userId);	
    $this->db->where('uc.entityId','86'); // Work Profile entity id
    $this->db->order_by('uc.userContainerId','desc');
    $query = $this->db->get();
    return $query->result_array();
  }
  
  //---------------------------------------------------------------------------
  
  /*
  * @Description: This function is use to get selected container list
  * @return array
  */ 
  
  function getSelectedContainerList($userId,$selectionNumberId)
  {
    $this->db->select('rs.*');
    $this->db->from('refundSelectionTemp as rs');	 
    $this->db->where('rs.tdsUid',$userId); 
    $this->db->where('rs.selectionNumber',$selectionNumberId); 
    $this->db->order_by('rs.refundSelectionId','desc');
    $query = $this->db->get();
    return $query->result_array();
  }
  
  //---------------------------------------------------------------------------
  
 /*
  * @Description: This function is use get membership item details
  * @return array
  */ 
  
  function getMembershipDetails($userId,$pkgId)
  {
    $this->db->select('mo.orderId,mo.ordNumber,mo.buyerInfo');
    $this->db->from('UserMembershipItem as umi');	 
    $this->db->join('MembershipOrder as mo','mo.orderId = umi.orderId','left');
    $this->db->where('umi.tdsUid',$userId); 
    $this->db->where('umi.pkgId',$pkgId); //current pkg membership type
    $this->db->order_by('umi.memItemId','desc');
    $this->db->limit(1);
    $query = $this->db->get();
   // echo $this->db->last_query();die();
    return $query->row_array();
  }
  
  
  
}
