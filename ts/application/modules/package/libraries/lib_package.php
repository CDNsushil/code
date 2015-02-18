<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * LIb_package class
 * 
 * Todasqre lib_package Class
 * manage lib_package details.
 * 
 * @package		Toadsqure
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Sushil Mishra
 * @link		http://www.cdnsol.com/
 **/

Class lib_package {
	
	protected 	$CI 			= NULL;
	protected 	$table 				= 'MasterPackage';
	protected 	$tableUserContainer = 'UserContainer';
	protected	$field				= 'pkgId';
	
	//define db colomn table
	var $keys = array
	(
		'pkgId' =>'',
		'pkgName' =>'',
		'pkgPrice' =>'',
		'pkgValidity' =>'',
		'pkgCreatedDate' =>'',
		'pkgDiscription' =>'',
		'pkgActiveStatus' =>'',
		'isVisible' =>'',
		'isFree' =>''	
	);
	 
	/**
	 * Constructor
	 */
	 
	function __construct()
	{
		// create core class object
		$this->CI =& get_instance();
		$this->CI->load->model('package/model_package');
		$this->CI->load->config('package/package');
	}
	
	//---------------------------------------------------------------------
	
	/*
	 * @access: public 
	 * @description: This function will get package information
	 * @return object
	 */
	
	function packageinformation()
	{
		return $this->CI->model_package->packageinformation();;
	}
	
	//----------------------------------------------------------------------
	
	function setUserContainerId($sectionId=''){
		$isUserContainer=false;
		$post=$this->CI->input->post();
		if(!(isset($post) && $post && is_array($post) && count($post) > 0) ){
			$post=$_POST; 
		}
		$userId=isLoginUser();
		if(($sectionId != '') && isset($post) && is_array($post) && count($post) > 0 && $userId > 0){
			$userContainerId=($this->CI->input->post('userContainerId')>0)?($this->CI->input->post('userContainerId')):$this->CI->session->userdata('user_'.$userId.'_section_'.$sectionId.'_ContainerId');
				
			if($userContainerId > 0){
				$countResult=$this->CI->model_common->countResult($table='UserContainer',$field=array('userContainerId'=>$userContainerId,'tdsUid'=>$userId,'entityId'=>0,'elementId'=>0),'', $limit=1);
				if($countResult > 0){
					$isUserContainer=true;
					$this->CI->session->set_userdata('user_'.$userId.'_section_'.$sectionId.'_ContainerId',$userContainerId);
					return $userContainerId;
				}
			}else{
				$userDefaultTsProductId=($this->CI->input->post('userDefaultTsProductId')>0)?($this->CI->input->post('userDefaultTsProductId')):$this->CI->session->userdata('user_'.$userId.'_section_'.$sectionId.'_userDefaultTsProductId');
				
				if($userDefaultTsProductId > 0){
					$countResult=$this->CI->model_common->countResult($table='UserDefaultTsProduct',$field=array('userDefaultTsProductId'=>$userDefaultTsProductId,'tdsUid'=>$userId),'', $limit=1);
					if($countResult > 0){
						$isUserContainer=true;
						$this->CI->session->set_userdata('user_'.$userId.'_section_'.$sectionId.'userDefaultTsProductId',$userDefaultTsProductId);
						return $userDefaultTsProductId;
					}
				}
			}
		}
		if(!$isUserContainer){
			set_global_messages($this->CI->lang->line('selctPackageFirst'),'error');
			switch($sectionId){
				case '6':
					$redirect='dashboard/showcase/containers';
				break;
				
				case '7':
					$redirect='dashboard/showcase/containers';
				break;
				
				case '8':
					$redirect='dashboard/showcase/containers';
				break;
				
				case '14':
					$redirect='dashboard/workprofile/containers';
				break;
				
				case '13':
					$redirect='dashboard/blog/containers';
				break;
				
				case '17':
					$redirect='dashboard/upcoming/containers';
				break;
				
				case '1':
					$redirect='dashboard/filmNvideo/containers';
				break;
				
				case '2':
					$redirect='dashboard/musicNaudio/containers';
				break;
				
				case '4':
					$redirect='dashboard/photographyNart/containers';
				break;
				
				case '3':
					$redirect='dashboard/writingNpublishing/containers';
				break;
				
				case '3:1':
					$redirect='dashboard/writingNpublishing/containers';
				break;
				
				case '3:2':
					$redirect='dashboard/writingNpublishing/containers';
				break;
				
				case '9:1':
					$redirect='dashboard/performancesevents/containers';
				break;
				
				case '9:2':
					$redirect='dashboard/performancesevents/containers';
				break;
				
				case '9:3':
					$redirect='dashboard/performancesevents/containers';
				break;
				
				case '9:4':
					$redirect='dashboard/performancesevents/containers';
				break;
				
				case '10':
					$redirect='dashboard/educationMaterial/containers';
				break;
				
				case '11':
					$redirect='dashboard/work/containers';
				break;
				
				case '12:1':
					$redirect='dashboard/products/containers';
				break;
				
				case '12:2':
					$redirect='dashboard/products/containers';
				break;
				
				case '12:3':
					$redirect='dashboard/products/containers';
				break;
				
				default:
					$redirect='dashboard';
				break;
				
			}
			
			redirect($redirect);
		}
	}
	function getUserContainerId($sectionId=''){
		$userId=isLoginUser();
		$isUserContainer=false;
		if($userId >0 && $sectionId !=''){
			$userContainerId=$this->CI->session->userdata('user_'.$userId.'_section_'.$sectionId.'_ContainerId');
			$this->CI->session->unset_userdata('user_'.$userId.'_section_'.$sectionId.'_ContainerId');
			if($userContainerId > 0){
				$countResult=$this->CI->model_common->countResult($table='UserContainer',$field=array('userContainerId'=>$userContainerId,'tdsUid'=>$userId,'entityId'=>0,'elementId'=>0),'', $limit=1);
				if($countResult > 0){
					$isUserContainer=true;
					return $userContainerId;
				}
			}
			else{
				$userDefaultTsProductId=$this->CI->session->userdata('user_'.$userId.'_section_'.$sectionId.'userDefaultTsProductId');
				$this->CI->session->unset_userdata('user_'.$userId.'_section_'.$sectionId.'userDefaultTsProductId');
				if($userDefaultTsProductId > 0){
					$result=$this->CI->model_common->getDataFromTabel('UserDefaultTsProduct', '*',  array('userDefaultTsProductId'=>$userDefaultTsProductId,'tdsUid'=>$userId), '', '','', 1, 0 );
					if($result){
						$isUserContainer=true;
						$result=$result[0];
						return $result;
					}
				}
			}
		}
		if(!$isUserContainer){
			set_global_messages($this->CI->lang->line('selctPackageFirst'),'error');
			switch($sectionId){
				case '6':
					$redirect='dashboard/showcase/containers';
				break;
				
				case '7':
					$redirect='dashboard/showcase/containers';
				break;
				
				case '8':
					$redirect='dashboard/showcase/containers';
				break;
				
				case '14':
					$redirect='dashboard/workprofile/containers';
				break;
				
				case '13':
					$redirect='dashboard/blog/containers';
				break;
				
				case '17':
					$redirect='dashboard/upcoming/containers';
				break;
				
				case '1':
					$redirect='dashboard/filmNvideo/containers';
				break;
				
				case '2':
					$redirect='dashboard/musicNaudio/containers';
				break;
				
				case '4':
					$redirect='dashboard/photographyNart/containers';
				break;
				
				case '3':
					$redirect='dashboard/writingNpublishing/containers';
				break;
				
				case '3:1':
					$redirect='dashboard/writingNpublishing/containers';
				break;
				
				case '3:2':
					$redirect='dashboard/writingNpublishing/containers';
				break;
				
				case '9:1':
					$redirect='dashboard/performancesevents/containers';
				break;
				
				case '9:2':
					$redirect='dashboard/performancesevents/containers';
				break;
				
				case '9:3':
					$redirect='dashboard/performancesevents/containers';
				break;
				
				case '9:4':
					$redirect='dashboard/performancesevents/containers';
				break;
				
				case '10':
					$redirect='dashboard/educationMaterial/containers';
				break;
				
				case '11':
					$redirect='dashboard/work/containers';
				break;
				
				case '12:1':
					$redirect='dashboard/products/containers';
				break;
				
				case '12:2':
					$redirect='dashboard/products/containers';
				break;
				
				case '12:3':
					$redirect='dashboard/products/containers';
				break;
				
				default:
					$redirect='dashboard';
				break;
				
			}
			redirect($redirect);
		}
	}
	
	function updateUserContainer($userContainerId=0,$entityId=0,$elementId=0,$sectionId=0,$industryId=0){
		if($userContainerId > 0 && $entityId > 0 && $elementId > 0){
			
			$userContainers=$this->CI->model_common->getDataFromTabel($this->tableUserContainer,'duration',array('userContainerId'=>$userContainerId),'','','',1);
			if($userContainers){
				$duration=$userContainers[0]->duration;
			
				$createdDate=currntDateTime();
				$industryId=(is_numeric($industryId))?$industryId:0;
				$updateData=array(
									'entityId'=>$entityId,
									'elementId'=>$elementId,
									'startDate'=>$createdDate,
									'IndustryId'=>$industryId,
									'pkgSections'=>'{'.$sectionId.'}'
								);
				if($duration > 0){
					$today = time();
					$expiryDate = strtotime("+".$duration." months", $today);
					$expiryDate = date('Y-m-d h:i:s',$expiryDate);
					$updateData['expiryDate']=$expiryDate;
				}
				
				$where = array('userContainerId' => $userContainerId);
				$this->CI->model_common->editDataFromTabel($this->tableUserContainer, $updateData, $where);
			}
		}
	}
	function addUserContainer($data='',$entityId=0,$elementId=0,$sectionId=0,$industryId=0,$table='',$primeryKey=''){
		if(isset($data->tdsUid) && $data->tdsUid > 0){
			$duration=$data->duration;
			$createdDate=currntDateTime();
			$industryId=(is_numeric($industryId))?$industryId:0;
			$UserContainerData=array(
											'tdsUid' =>$data->tdsUid,
											'entityId'=>$entityId,
											'elementId'=>$elementId,
											'containerSize' =>$data->containerSize,
											'createdDate' =>$createdDate,
											'startDate'=>$createdDate,
											'IndustryId'=>$industryId,
											'pkgSections'=>'{'.$sectionId.'}',
											'pkgId' =>$data->pkgId,
											'tsProductId' =>$data->tsProductId,
											'duration' =>$duration,
											'pkgRoleId' =>$data->pkgRoleId,
											'userDefaultTsProductId' =>$data->userDefaultTsProductId,
											'title' =>$data->title
									);
			if($duration > 0){
					$today = time();
					$expiryDate = strtotime("+".$duration." months", $today);
					$expiryDate = date('Y-m-d h:i:s',$expiryDate);
					$UserContainerData['expiryDate']=$expiryDate;
			}
			$userContainerId=$this->CI->model_common->addDataIntoTabel($this->tableUserContainer,$UserContainerData);
			if($userContainerId && $table != '' && $primeryKey != '' && $elementId > 0){
				$updateData=array('userContainerId'=>$userContainerId);
				$where = array($primeryKey => $elementId);
				$res=$this->CI->model_common->editDataFromTabel($table, $updateData, $where);
			}
		}
	}
}

Class lib_packageRole {
	var $table = 'MasterPackgesRole';
	var	$field = 'pkgRoleId';
	
	var $keys = array
	(
		'pkgRoleId' =>'',
		'pkgId' =>'',
		'tsProductId' =>'',
		'qty' =>'',
		'createdDate' =>'',
		'initialValidity' =>''
	);
	function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->model('package/model_package');
		$this->CI->load->config('package/package');
	}
}

Class lib_tsProduct {
	var $table = 'MasterTsProduct';
	var	$field = 'tsProductId';
	var $keys = array
	(
		'tsProductId' =>'',
		'title' =>'',
		'type' =>'',
		'size' =>'',
		'price' =>'',
		'duration' =>'',
		'associatedSpace' =>'',
		'comment' =>'',
		'allowedSections' =>'',
		'date' =>''
	);
	function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->model('package/model_package');
		$this->CI->load->config('package/package');
	}
	
	function getProductDetails($sectionId=0, $field='*', $isfree=False){
		$data=false;
		if($sectionId !==''){
			$MasterTsProduct=$this->CI->db->dbprefix('MasterTsProduct');
			$table =' "'.$MasterTsProduct.'"';
			if($isfree){
				$AND = ' AND price = 0 ';
			}else{
				$AND = ' AND price > 0 ';
			}
			$LIMIT = ' LIMIT 1';
			$where ='WHERE \''.$sectionId.'\' = ANY ("allowedSections")'.$AND.$LIMIT;
			$data=$this->CI->model_common->getDataFromMixTabel($table,$field,$where);
		}
		return $data;
	}
	
}

Class lib_udtsProduct {
	var $table = 'UserDefaultTsProduct';
	var	$field = 'userDefaultTsProductId';
	var $keys = array
	(
		'userDefaultTsProductId' =>'',
		'tdsUid' =>'',
		'pkgId' =>'',
		'tsProductId' =>'',
		'pkgRoleId' =>'',
		'storageType' =>'',
		'containerSize' =>'',
		'qty' =>'',
		'createDate' =>'',
		'duration' =>''
	);
	function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->model('package/model_package');
		$this->CI->load->config('package/package');
	}
	function productListing(){
		$res=$this->CI->model_package->productListing();
		return $res;
	}
}

Class lib_userContainer {
	var $table 			= 'UserContainer';
	var $udtsp 			= 'UserDefaultTsProduct';
	var	$field 			= 'userContainerId';
	var	$userSubscr		= 'UserSubscription';
	
	var $keys = array
	(
		'userContainerId' =>'',
		'tdsUid' =>'',
		'entityId' =>'',
		'elementId' =>'',
		'containerSize' =>'',
		'usedSize' =>'',
		'createdDate' =>'',
		'expiryDate' =>'',
		'containerStatus' =>'',
		'startDate' =>'',
		'IndustryId' =>'',
		'orderId' =>'',
		'pkgId' =>'',
		'tsProductId' =>'',
		'pkgSections' =>'',	
		'duration' =>'',
		'pkgRoleId' =>'',
		'userDefaultTsProductId' =>''
	);
	
	var $pkg = '';
	var	$pkgRole = '';
	var	$tsProd = '';
	 
	function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->model('package/model_package');
		$this->CI->load->config('package/package');
		//$this->pkg = new lib_package();
		//$this->pkgRole = new lib_packageRole();
		//$this->tsProd = new lib_tsProduct();
	}
	
	function setValues($project_array){
		foreach($project_array as $k => $v){
			if(isset($this->keys[$k])){
					$this->keys[$k] = $v;
			}
		}
	}
	function getValues(){
		return $this->keys;
	}
	
	//-----------------------------------------------------------------------
	
	/*
	* @access: public
	* @Description: This function is use to insert user default product when 
	* register in the website
	* @param: userId
	* @param: userTypeId
	* @return: boolean
	* @last-modified: 14-sep-2014 (lokendra)
	*/ 
	
	function assignFreePackageToUaser($userId=0,$userTypeId="1"){
		$dataInsertFlag=false;
		if(!empty($userId)){
			
			//call user default package selected free
			$this->userDefaultSubscription($userId);

			// get user default free product list  
			$defaultPackageList	  =		$this->CI->model_package->freePkgDetails();
			
			// insert user default container by userTypeId
			$dataInsertFlag 			=		$this->_insertDefaultProduct($defaultPackageList,$userId,$userTypeId);
		}
		return $dataInsertFlag;
	}
	
	
	//-------------------------------------------------------------------------
	
	/*
	 * @Description: This function is use to insert user default free product 
	 * for free/ 1 and 3 year user 
	 * @param:	defaultPackageList
	 * @param:	userId
	 * @param:	userTypeId
	 * @return: boolean
	 * @auther: lokendra
	 */ 
	
	private function _insertDefaultProduct($defaultPackageList,$userId,$userTypeId){
		$dataInsertFlag=false;
		if(!empty($defaultPackageList)){
				
			$UserContainerData	=		false;
			
			// non activated product not allow in default product insert
			$notAllowPackage = $this->CI->config->item('not_activated_package_not_allow');
			
			if($userTypeId==$this->CI->config->item('package_type_1')){
				// free user default container array
				$defaultContainerArray	 =	 $this->CI->config->item('free_user_default_container');
			}else{
				// 1/3 year user default container array
				$defaultContainerArray	 =	 $this->CI->config->item('paid_user_default_container');
			}
			
			foreach($defaultPackageList as $k=>$data){

				if(!in_array($data['pkgRoleId'], $notAllowPackage))
				{
					if(in_array($data['tsProductId'], $defaultContainerArray))
					{
						// get user default product check is already exist
						$whereCondi 	 				= 	 array('tdsUid' => $userId, 'tsProductId'=>$data['tsProductId']);
						$defaultTsProductId   =  	 $this->CI->model_common->getDataFromTabel('UserDefaultTsProduct', 'userDefaultTsProductId',  $whereCondi, '', $orderBy='userDefaultTsProductId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
						
						if(empty($defaultTsProductId))
						{
							$duration		=	 ($data['initialValidity'] > 0)?$data['initialValidity']:(($data['pkgValidity'] > 0)?$data['pkgValidity']:$data['duration']);

							$UserDefaultContainerData=array(
							'tdsUid' 					=>	$userId,
							'pkgId' 					=>	$data['pkgId'],
							'tsProductId' 		=>	$data['tsProductId'],
							'pkgRoleId' 			=>	$data['pkgRoleId'],
							'storageType' 		=>	$data['type'],
							'containerSize' 	=>	$data['size'],
							'qty' 						=>	$data['qty'],
							'createDate' 			=>	currntDateTime(),
							'duration' 				=>	$duration,
							'allowedSection' 	=>	$data['allowedSections'],
							'title' 					=>	$data['title']
							);

							$userDefaultTsProductId=$this->CI->model_common->addDataIntoTabel($this->udtsp,$UserDefaultContainerData);
							if($userDefaultTsProductId > 0 && $data['qty'] > 0){
								 // check product quantity greater then create container multiple
								if($data['qty'] > 1){
									for($i=0; $i<$data['qty']; $i++){
										$UserContainerData[]=	array(
											'tdsUid' 				=>	$userId,
											'containerSize' =>	$data['size'],
											'createdDate' 	=>	currntDateTime(),
											'pkgId' 				=>	$data['pkgId'],
											'tsProductId' 	=>	$data['tsProductId'],
											'pkgSections' 	=>	$data['allowedSections'],
											'duration' 			=>	$duration,
											'pkgRoleId' 		=>	$data['pkgRoleId'],
											'userDefaultTsProductId' =>	$userDefaultTsProductId,
											'title' 				=>	$data['title']
										);
									}
								}else{
									$UserContainerData[]=		array(
										'tdsUid' 					=>	$userId,
										'containerSize' 	=>	$data['size'],
										'createdDate'			=>	currntDateTime(),
										'pkgId'						=>	$data['pkgId'],
										'tsProductId' 		=>	$data['tsProductId'],
										'pkgSections' 		=>	$data['allowedSections'],
										'duration' 				=>	$duration,
										'pkgRoleId' 			=>	$data['pkgRoleId'],
										'userDefaultTsProductId' =>	$userDefaultTsProductId,
										'title' 					=>	$data['title']
									);
								}
							}
						}
					}
				}
			}
			
			// insert data prepared then insert 
			if(!empty($UserContainerData)){
				$return=$this->CI->model_common->insertBatch($this->table,$UserContainerData);
				if($return){
					$dataInsertFlag=true;
				}
			}
		}
		return $dataInsertFlag;
	}
  
  //-------------------------------------------------------------------------

  /*
  * @access: public
  * @description: This function is use to insert default campaign for 1 year and 
  * 3 year 
  * @auhter: lokendra
  * @return void
  */ 
  
  public function packagedefaultcampaign($userId){
    
    for($i=1;$i<=$this->CI->config->item('package_default_campaign');$i++){
      $userDefaultContainerData =  array(
                'tdsUid'        =>  $userId,
                'containerSize' =>  '104857600',
                'createdDate'   =>  currntDateTime(),
                'pkgId'         =>  '14',
                'tsProductId'   =>  '23',
                'pkgSections'   =>  '{24}',
                'duration'      =>  '0',
                'pkgRoleId'     =>  '35',
                'userDefaultTsProductId'  =>  '0',
                'title'     =>  'Ad Campaigns'
            );
                
      $this->CI->model_common->addDataIntoTabel('UserContainer',$userDefaultContainerData);
      
      //unset the data
      unset($userDefaultContainerData);
    }
  }
  
  //-------------------------------------------------------------------------

  /*
	 * @access: private
	 * @description: This function is used to create default package subscription
	 * while join
	 * @auhter: lokendra
	 * @return true
	 */ 
	
  private function userDefaultSubscription($userId){
    
    $selectedPackageTypes = '0';
    $isPackageProcessDone = '0';
    if($this->CI->session->userdata('selectedPacakge')){
      //$selectedPackageTypes    =  $this->CI->session->userdata('selectedPacakge');
      $selectedPackageTypes      =  $this->CI->config->item('package_type_1');
      $isPackageProcessDone      =  '1';
      
    }
    
    //prepare insert data
    $subscriptionData       =   array(
    'tdsUid' 		        =>  $userId,
    //'startDate'	        =>  currntDateTime(),
    'pkgId'			        =>  $this->CI->config->item('package_free_id'),
    'modifiedDate'          =>  currntDateTime(),
    'subscriptionType'      =>  $selectedPackageTypes,
    'status'                =>  $isPackageProcessDone,
    );
    
    //user subscription data
    $whereSubcrip 		    =   array('tdsUid' => $userId);
    $subscriptionDetails    =   $this->CI->model_common->getDataFromTabel($this->userSubscr, '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
    
    // if not recrod exist then insert
    if(empty( $subscriptionDetails)){
        $this->CI->model_common->addDataIntoTabel($this->userSubscr,$subscriptionData);
    }
  }

	//---------------------------------------------------------------------------
	
	function checkPackageAssign($userId=0,$tsProductId=0){
		if($userId >0 && $tsProductId >0){
			$countResult=$this->CI->model_common->countResult('UserDefaultTsProduct',array('tdsUid'=>$userId,'tsProductId'=>$tsProductId));
			if($countResult==0){
				$this->assignExtraFreePackageToUaser($userId,$tsProductId,0);
			}
		}else{
				return false;
		}
	}
	
	function checkPackageAssignToSuperAdmin($userId=0,$tsProductId=0){
		if($userId >0 && $tsProductId >0){
			
			$countResult=$this->CI->model_common->countResult($this->table,array('tdsUid'=>$userId,'tsProductId'=>$tsProductId,'entityId'=>0,'elementId'=>0));
			if($countResult==0){
				$this->assignExtraFreePackageToUaser($userId,$tsProductId,1);
			}
		}else{
				return false;
		}
	}
	
	function assignExtraFreePackageToUaser($userId=0,$tsProductId=0,$quntity=0){
		$insertFlag=false;
		
		if($userId >0 && $tsProductId >0 ){
			
			$res=$this->CI->model_package->freePkgDetails($tsProductId);
			if($res && is_array($res) && count($res)>0){
				$UserContainerData=array();
				foreach($res as $k=>$data){
					$duration= ($data['initialValidity'] > 0)?$data['initialValidity']:(($data['pkgValidity'] > 0)?$data['pkgValidity']:$data['duration']);
					
					$quntity = (is_numeric($quntity) && ($quntity > 0))?$quntity:$data['qty'];
					
					
					$UserDefaultContainerData=array(
													'tdsUid' =>$userId,
													'pkgId' =>$data['pkgId'],
													'tsProductId' =>$data['tsProductId'],
													'pkgRoleId' =>$data['pkgRoleId'],
													'storageType' =>$data['type'],
													'containerSize' =>$data['size'],
													'qty' =>$quntity,
													'createDate' =>currntDateTime(),
													'duration' =>$duration,
													'allowedSection' =>$data['allowedSections'],
													'title' =>$data['title']
											  );
					
					$userDefaultTsProductId=$this->CI->model_common->addDataIntoTabel($this->udtsp,$UserDefaultContainerData);
					if($userDefaultTsProductId > 0 && $quntity > 0){
						if($quntity > 1){
							for($i=0; $i<$quntity; $i++){
								$UserContainerData[]=array(
																'tdsUid' =>$userId,
																'containerSize' =>$data['size'],
																'createdDate' =>currntDateTime(),
																'pkgId' =>$data['pkgId'],
																'tsProductId' =>$data['tsProductId'],
																'pkgSections' =>$data['allowedSections'],
																'duration' =>$duration,
																'pkgRoleId' =>$data['pkgRoleId'],
																'userDefaultTsProductId' =>$userDefaultTsProductId,
																'title' =>$data['title']
														  );
							}
						}else{
								$UserContainerData[]=array(
																'tdsUid' =>$userId,
																'containerSize' =>$data['size'],
																'createdDate' =>currntDateTime(),
																'pkgId' =>$data['pkgId'],
																'tsProductId' =>$data['tsProductId'],
																'pkgSections' =>$data['allowedSections'],
																'duration' =>$duration,
																'pkgRoleId' =>$data['pkgRoleId'],
																'userDefaultTsProductId' =>$userDefaultTsProductId,
																'title' =>$data['title']
														  );
						}
					}
				}
				$return=$this->CI->model_common->insertBatch($this->table,$UserContainerData);
				if($return){
					$insertFlag=true;
				}
			}
		}else{
			echo "please provede userId, tsProductId & quntity";
		}
		return $insertFlag;
	}
	
	function isContainerFree($sectionId=''){
		$isContainerFree=false;
		if($sectionId !==''){
			$MasterTsProduct=$this->CI->db->dbprefix('MasterTsProduct');
			$MasterPackage=$this->CI->db->dbprefix('MasterPackage');
			$MasterPackgesRole=$this->CI->db->dbprefix('MasterPackgesRole');
			$query='SELECT COUNT(*) AS "numrows" FROM "'.$MasterTsProduct.'" as mt, "'.$MasterPackage.'" as mp, "'.$MasterPackgesRole.'" as mpr   WHERE \''.$sectionId.'\' = ANY ("allowedSections") AND mp."pkgType" =3 AND mp."pkgId"= mpr."pkgId" AND mt."tsProductId"= mpr."tsProductId"';
			$result=$this->CI->model_common->runQuery($query);
			if($result){
				$result=$result->result_array();
				$num_rows=$result[0]['numrows'];
				$isContainerFree=($num_rows > 0)?false:true;
			}
		}
		return $isContainerFree;
	}
	function getAvailableUserContainer($userId=0,$sectionId=''){
		$userContainers=false;
		if($userId > 0 && $sectionId !==''){
			$table=$this->CI->db->dbprefix('UserContainer');
			$field='"'.$table.'".*';
			$table='"'.$table.'"';
			
			$where='WHERE \''.$sectionId.'\' = ANY ("pkgSections") AND "tdsUid" = '.$userId.' AND "entityId" = 0 AND "elementId" = 0 AND "containerStatus" = \'t\' ';
			$userContainers=$this->CI->model_common->getDataFromMixTabel($table,$field,$where);
			if(!$userContainers){
				$table=$this->CI->db->dbprefix('UserDefaultTsProduct');
				$table='"'.$table.'"';
				$field='"title","containerSize","duration","userDefaultTsProductId"';
				$where='WHERE \''.$sectionId.'\' = ANY ("allowedSection") AND "tdsUid" = '.$userId.' AND "qty" = 0 AND "storageType" = 1 ';
				$userContainers=$this->CI->model_common->getDataFromMixTabel($table,$field,$where);
			}
		}
		return $userContainers;
	}
	function getUsedUserContainer($userId=0,$sectionId=''){
		$userContainers=false;
		if($userId > 0 && $sectionId !==''){
			if(is_array($sectionId) && count($sectionId) > 0){
					$sectionIdString='(';
					foreach($sectionId as $k=>$id){
						if($k==0){
							$sectionIdString.=' \''.$id.'\' = ANY ("pkgSections") ';
						}else{
							$sectionIdString.=' OR \''.$id.'\' = ANY ("pkgSections") ';
						}
					}
					
					
					$sectionIdString.=')';
			}else{
					$sectionIdString=' \''.$sectionId.'\' = ANY ("pkgSections") ';
			}
			$UserContainer=$this->CI->db->dbprefix('UserContainer');
			$search=$this->CI->db->dbprefix('search');
			$table='"'.$UserContainer.'", "'.$search.'"';
			$field='"'.$UserContainer.'".*, "'.$search.'".isblocked as "isBlocked", (item).title as "projectTitle", (item).work_type, (item).is_urgent_work, (item).is_experience_work , (item).categoryid, (item).category ';
			$where='WHERE '.$sectionIdString.' AND "tdsUid" = '.$userId.' AND "entityId" > 0 AND "elementId" > 0 AND "containerStatus" = \'t\' AND  "'.$UserContainer.'"."entityId"="'.$search.'"."entityid" AND  "'.$UserContainer.'"."elementId"="'.$search.'"."elementid"';
			$userContainers=$this->CI->model_common->getDataFromMixTabel($table,$field,$where);
			
		return $userContainers;
			if(!$userContainers){
				$table=$this->CI->db->dbprefix('UserDefaultTsProduct');
				$table='"'.$table.'"';
				$field='"title","containerSize","duration","userDefaultTsProductId"';
				$where='WHERE \''.$sectionId.'\' = ANY ("allowedSection") AND "tdsUid" = '.$userId.' AND "qty" = 0 AND "storageType" = 1 ';
				$userContainers=$this->CI->model_common->getDataFromMixTabel($table,$field,$where);
			}
			
		}
		
		
	}
	
	function getUserContainer($userId=0,$sectionId=''){
		$userContainers=false;
		if($userId > 0 && $sectionId !==''){
			$UserContainer=$this->CI->db->dbprefix('UserContainer');
			$search=$this->CI->db->dbprefix('search');
			$table =' "'.$UserContainer.'" LEFT JOIN "'.$search.'" ON ("'.$search.'"."entityid" = "'.$UserContainer.'"."entityId" AND "'.$search.'"."elementid" = "'.$UserContainer.'"."elementId")';
			$field ='"'.$UserContainer.'".*, (item).title as "projectTitle"';
			$where ='WHERE \''.$sectionId.'\' = ANY ("pkgSections") AND "tdsUid" = '.$userId.' AND "containerStatus" = \'t\' ';
			$userContainers=$this->CI->model_common->getDataFromMixTabel($table,$field,$where);
			if(!$userContainers){
				$table=$this->CI->db->dbprefix('UserDefaultTsProduct');
				$table='"'.$table.'"';
				$field='"title","containerSize","duration","userDefaultTsProductId"';
				$where='WHERE \''.$sectionId.'\' = ANY ("allowedSection") AND "tdsUid" = '.$userId.' AND "qty" = 0 AND "storageType" = 1 ';
				$userContainers=$this->CI->model_common->getDataFromMixTabel($table,$field,$where);
			}
		}
		return $userContainers;
	}
	
	function getValueToUpdate($productId,$catId)
	{
		$data = $this->CI->model_product->productSellRecordSet($productId,$catId);
		$this->setValues($data);
	}
	function save($data)
	{
		if($this->CI->input->post('mode')=="new"){
			$id = $this->CI->model_common->addDataIntoTabel($table, $data);	
			addDataIntoLogSummary($table,$id);
		}else
		{	$ID = $data['productId'];
			$where = array('productId' => $data['productId']);
			$this->CI->model_common->editDataFromTabel($table, $data, $field, $ID);

			$id = $ID;
		}
		return $id;
	}
}
