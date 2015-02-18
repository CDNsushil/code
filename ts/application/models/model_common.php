<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}
/* =================================================================================================
	//Start Date: 19-01-12 Added by sushil for common select, insert, update, delee query  
====================================================================================================*/

class model_common extends CI_Model { 
	private $tableProject 						= 'Project'; //Private Variable(Table Name) to get used at class level only
	private $tableProjCategory					= 'ProjCategory';
	private $tableMasterIndustry				= 'MasterIndustry';
	private $tableGenre							= 'Genre';
	private $tableOffers						= 'Offers';
	private $tableMasterRating					= 'MasterRating';	
	private $tableElement						= 'Element';	
	private $tableFvMediaType					= 'MediaType';	
	private $tableMediaFile						= 'MediaFile';
		
	private $tableProjectPromotion 			    = 'ProjectPromotion';
	private $tableProjectShipping			    = 'ProjectShipping';
	
	private $tableAssociativeCreatives		    = 'AssociativeCreatives';
		
	private $tableLogSummary					= 'LogSummary';	
	private $tableLogInvite						= 'LogInvite';	
	private $tableLogCrave						= 'LogCrave';	
	private $tableLogRating						= 'LogRating';	
	private $tableLogShare						= 'LogShare';	
	private $tableLogShow						= 'LogShow';
	private $tableMediaEelementType				= 'MediaEelementType';
	private $tableProjectType				    = 'MasterProjectType';
	private $upcomingProjectMediaTableName      = 'TDS_UpcomingProjectMedia';
	private $upcomingProjectTableName 			= 'TDS_UpcomingProject';
	
	private $tableUserAuth						= 'UserAuth';
	private $tableUserProfile					= 'UserProfile';
	private $tableUserShowcase					= 'UserShowcase';	// user profiles
	private $tableStockImages					= 'StockImages';	// user profiles
	private $UserSearchPreferences	= 'UserSearchPreferences';	// user profiles
	private $UserBuyerSettings		= 'UserBuyerSettings';	// user profiles
	private $UserSellerSettings		= 'UserSellerSettings';	// user profiles
	
	private $tableUserContainer					= 'UserContainer';
	private $tableMasterCountry					= 'MasterCountry';
	private $tableAttachment  = 'tmail_attachment';
	private $tableMessages	  = 'tmail_messages';
	private $tableRequestUrl  = 'WorkProfileUrlRequest';
	private $UserProfile	  = 'UserProfile';
	
	private $tableShowProject	= 'ShowProject';
	private $tblContinent		= 'MasterContinent';
	private $tblFvElement		= 'FvElement';
	private $tableLogVisitors	= 'LogVisitors';
	
	private $tableEventMedia	= 'EventMedia';
	private $tableProfileSocialLink	= 'profileSocialLink';
	private $tableMeetingPoint	= 'MeetingPoint';
	private $tableEventSessions	= 'EventSessions';
    private $tableReviewsElement                ='ReviewsElement' ;
    private $socialLinkTable     = 'profileSocialLink';
    private $socialMediaIcon     = 'profileSocialMediaIcon';
	
	
	function __construct()
	{
		parent::__construct();
	}
	
	function getUserDetails($userId=0)
	{
		$this->db->select($this->tableUserAuth.'.*');
		$this->db->select($this->tableUserShowcase.'.optionAreaName,'.$this->tableUserShowcase.'.profileImageName,'.$this->tableUserShowcase.'.stockImageId,'.$this->tableUserShowcase.'.creative,'.$this->tableUserShowcase.'.associatedProfessional,'.$this->tableUserShowcase.'.enterprise,'.$this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.websiteUrl,'.$this->tableUserShowcase.'.showcaseId');
		$this->db->select($this->UserSellerSettings.'.seller_currency');
		$this->db->select($this->tableUserProfile.'.countryId,'.$this->tableUserProfile.'.image,'.$this->tableUserProfile.'.firstName,'.$this->tableUserProfile.'.lastName');
		$this->db->select($this->tableStockImages.'.stockImgPath,'.$this->tableStockImages.'.stockFilename');
		$this->db->select($this->tableMasterCountry.'.countryName');
		$this->db->from($this->tableUserAuth);
		
		$this->db->join($this->tableUserProfile, $this->tableUserProfile.'.tdsUid = '.$this->tableUserAuth.'.tdsUid','left');
		$this->db->join($this->UserSellerSettings, $this->UserSellerSettings.'.tdsUid = '.$this->tableUserAuth.'.tdsUid','left');
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableUserAuth.".tdsUid", 'left');
		$this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->tableUserShowcase.".stockImageId", 'left');
		$this->db->join($this->tableMasterCountry, $this->tableMasterCountry.".countryId = ".$this->tableUserProfile.".countryId", 'left');
		
		$this->db->where($this->tableUserAuth.'.tdsUid', $userId);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows()) return $query->result();
		return false;
	}
	
	//count get Max field value
	function getMax($table='',$field='',$where=''){
		
		$this->db->select_max($field);
		if(is_array($where) && count($where) > 0){
			$this->db->where($where);
		}
		$query = $this->db->get($table);
		$result=$query->result();
		return $result;
		 
	}
	function getSum($table='',$field='',$where=''){
		$result = false;
		if($table != '' && $field !=''){
			$this->db->select_sum($field);
			if(is_array($where) && count($where) > 0){
				$this->db->where($where);
			}
			$query = $this->db->get($table);
			$result=$query->result();
		}
		return $result;
	}
	//count Sql Result
	function countResult($table='',$field='',$value='', $limit=0){
	
		if(is_array($field)){
				$this->db->where($field);
		}
		elseif($field!='' && $value!=''){
			$this->db->where($field, $value);
		}
		$this->db->from($table);
		
		$res= $this->db->count_all_results();
		return $res;
		 
	}
    
	function countResult_whereIn($table='',$where='',  $whereInField='', $whereInValue='', $whereNotIn=0){
        $res = 0;
        if(!empty($table)){
            if(is_array($where) && !empty($where)){
                    $this->db->where($where);
            }
            if(!empty($whereInField) && !empty($whereInValue) && is_array($whereInValue)){
                if($whereNotIn==1){
                    $this->db->where_not_in($whereInField,$whereInValue);
                }else{
                    $this->db->where_in($whereInField,$whereInValue);
                }
            }
            
            $this->db->from($table);
            
            $res= $this->db->count_all_results();
        }
		return $res;
		 
	}
	
	//count Sql Result
	function countResultFirstInsert($table,$field){
	
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field);
		$query = $this->db->get();
		if ($query->num_rows()) 
		{
			$result = $query->row();
		}else
		{
			$result = 0;
		}
		// echo $this->db->last_query();die;
		 return $result;
		 
	}
	
	
	//Get Data From Mixed Tabel
	function getDataFromMixTabel($table='', $field='*',  $where="", $orderBy='', $limit='',$retrunRow=false ){
		$sql = 'SELECT '.$field.' FROM '.$table.'  '.$where.' '.$orderBy.' '.$limit.' ' ;
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		if($retrunRow)
			return $query->num_rows();
		else 
			return $query->result();
	}
	
	function runQuery($sql=''){
		if($sql!=''){
			$result = $this->db->query($sql);
			//echo $this->db->last_query();
			return $result;
		}
		return false;
	}
	
	
	//Get Data From Table
	function getDataFromTabelWhereIn($table='', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='ASC', $whereNotIn=0){
		 $this->db->select($field);
		 $this->db->from($table);
		 
		if($whereNotIn > 0){
			$this->db->where_not_in($whereField, $whereValue);
		}else{
			$this->db->where_in($whereField, $whereValue);
		}
		
		if(is_array($orderBy) && count($orderBy)){
			/* $orderBy treat as where condition if $orderBy is array  */
			$this->db->where($orderBy);
		}
		elseif(!empty($orderBy)){  
			$this->db->order_by($orderBy, $order);
		}
		
		$query = $this->db->get();
		
		$result = $query->result_array();
		if(!empty($result)){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	
	//Get Data From Table
	function getDataFromTabelWhereWhereIn($table='', $field='*',  $where='',  $whereinField='', $whereinValue='', $orderBy='', $whereNotIn=0){
		 $this->db->select($field);
		 $this->db->from($table);
		 
		if(is_array($where)){
			$this->db->where($where);
		}
		
		if($whereNotIn > 0){
			$this->db->where_not_in($whereinField, $whereinValue);
		}else{
			$this->db->where_in($whereinField, $whereinValue);
		}
		
		if(!empty($orderBy)){  
			$this->db->order_by($orderBy);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->result();
		if(!empty($result)){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	
	//Get Data From Table
	function getDataFromTabel($table='', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='ASC', $limit=0, $offset=0, $resultInArray=false,$isAssoMember=0 ){
		
		
		 $this->db->select($field);
		 $this->db->from($table);
		 
		if(is_array($whereField)){
			$this->db->where($whereField);
		}elseif(!empty($whereField) && $whereValue != ''){
			$this->db->where($whereField, $whereValue);
		} elseif($isAssoMember==1) {
            $this->db->where($whereField,NULL,FALSE);
        }
		if(!empty($orderBy)){  
			$this->db->order_by($orderBy, $order);
		}
		if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if($resultInArray){
			$result = $query->result_array();
		}else{
			$result = $query->result();
		}
		
		if(!empty($result)){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	//Get Data From Table
	function getLikeDataFromTabel($table='', $field='*',  $like='', $where='', $orderBy='', $order='ASC', $limit=0 ){
		//echo $table.', '.$field.', '.$whereField.', '.$whereValue.', '.$orderBy;
		 $this->db->select($field);
		 $this->db->from($table);
		 
		if(is_array($like)){
			$this->db->like($like);
		}elseif(is_array($where)){
			$this->db->where($where);
		}
		if(!empty($orderBy)){  
			$this->db->order_by($orderBy, $order);
		}
		if($limit >0){
			$this->db->limit($limit);
		}
		$query = $this->db->get();
		
		$result = $query->result();
		if(!empty($result)){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	//Get Data From emailTemplate
	function getMessageTemplate($purpose='', $lang='en'){
		 $this->db->select('subject,templates,from_email');
		 $this->db->from('EmailTemplates');
		 $this->db->where('purpose', $purpose);
		 $this->db->where('lang', $lang);
		 $this->db->where('active', 1);
		 $this->db->limit(1);
		 $query = $this->db->get();
		 return 	$query->result(); 
	}
	
	
	
	function getGenerList($typeId=0,$indstryId='',$lang='en',$entityId){
         
		$this->db->from('Genre');
		if($typeId > 0)
		$this->db->where('typeId', $typeId);
		if($indstryId>0)
		$this->db->where('industryId', $indstryId);
		if($entityId>0)
		$this->db->where('entityId', $entityId);
		$this->db->where('lang', $lang);
		$this->db->where('status', 't');
		$this->db->order_by('Genre');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function getRatingList($IndustryId=1, $lang='en'){

		 $this->db->select('ratId, otpion');
		 $this->db->from('MasterRating');
		 $this->db->where('IndustryId', $IndustryId);
		 $this->db->where('lang', $lang);
		 $this->db->order_by('ratId');
		 $query = $this->db->get();
		 //echo $this->db->last_query();
		 return 	$query->result();
	}

	//Add Data into Table
	function addDataIntoTabel($table='', $data=array()){
		if($table=='' || !count($data)){
			return false;
		}
		else{ 
			$inserted = $this->db->insert($table , $data);
			//echo $this->db->last_query();
			if($inserted){
				$ID = $this->db->insert_id();
				//echo "done with insert_id ". $ID."pre";
				//$ID =0;
				if(!($ID > 0)){
					$sql='SELECT LASTVAL() as ins_id';
					$res = $this->db->query($sql);
					$res =$res->result_array();
					$ID=$res[0]['ins_id'];
				}
			}
			$ID=($ID>0)?$ID:0;
			return $ID;
		}
	}
	
	function insertBatch($table='', $data=array()){
		if($table=='' || !count($data)>0){
			return false;
		}
		else{ 
			$this->db->insert_batch($table, $data); 
			return $this->db->insert_id();
		}
	}
	
	//Update Data into Table
	function editDataFromTabel($table='', $data=array(), $field='', $ID=0){
		
		if(empty($table) || !count($data)){
			return false;
		}
		else{
			if(is_array($field)){
				
				$this->db->where($field);
			}else{
				$this->db->where($field , $ID);
				
			}
			return $this->db->update($table , $data);
		}
	}
	
	//Update Data into Table
	function editDataFromTabelWhereIn($table='', $data=array(), $where=array(), $whereInField='', $whereIn=array(), $whereNotIn=false){
		
		if(empty($table) || !count($data)){
			return false;
		}
		else{
			if(is_array($where) && count($where) > 0){
				
				$this->db->where($where);
			}
			
			if(is_array($whereIn) && count($whereIn) > 0 && $whereInField != ''){
				if($whereNotIn){
					$this->db->where_not_in($whereInField,$whereIn);
				}else{
					$this->db->where_in($whereInField,$whereIn);
				}
			}
			return $this->db->update($table , $data);
		}
	}
	
	//Delete Particular row from Table
	function deleteRowFromTabel($table='', $field='', $ID=0, $limit=0){
		$Flag=false;
		if($table!='' && $field!=''){
			if(is_array($ID) && count($ID)){
				$this->db->where_in($field ,$ID);
			}elseif(is_array($field) && count($field) > 0){
				$this->db->where($field);
			}else{
				$this->db->where($field , $ID);
			}
			if($limit >0){
				$this->db->limit($limit);
			}
			if($this->db->delete($table)){
				$Flag=true;
			}
		}
		//echo $this->db->last_query();
		return $Flag;
	}
	
	function deletelWhereWhereIn($table='', $where='',  $whereinField='', $whereinValue='', $whereNotIn=0){
		
		if(is_array($where)){
			$this->db->where($where);
		}
		
		if($whereNotIn > 0){
			$this->db->where_not_in($whereinField, $whereinValue);
		}else{
			$this->db->where_in($whereinField, $whereinValue);
		}
		
		if($this->db->delete($table)){
				return true;
		}else{
			return false;
		}
	}
	
	//Delete rows from Table
	function deleteDataFromTabel($table='', $where=''){
		$SQl='DELETE FROM "'.$table.'" '.$where;
		$result = $this->db->query($SQl);
	}


/* =================================================================================================
	//Start Date: 26-04-12 Added by Gurutva for common promotional media related function
====================================================================================================*/

function entitypromotionmedialist($tableName,$entity_promo_media_array,$whereField,$whereValue,$mediaType,$orderBy,$flag,$postLaunchPR){

		$table = $tableName;		
		$fieldmediaType = 'mediaType';
		$this->db->from($table);
		$this->db->join('MediaFile','MediaFile.fileId = '.$tableName.'.fileId');
		$this->db->where($whereField,$whereValue);
		$eventSectionArray = array('eventId','launchEventId');
		if(strcmp($whereField,'eventId') ==0) $this->db->where('launchEventId IS NULL',null,true);
		
		if($mediaType>0){
			if($flag =='')
				$this->db->where($fieldmediaType,$mediaType);
			else
				$this->db->where('mediaType !=',$mediaType);			
		}
		if (in_array($whereField, $eventSectionArray) && @$postLaunchPR==0 ) {
			$this->db->where('launchPostPR','f');	
		}
		
		if (@$postLaunchPR==1) {
			$this->db->where('launchPostPR','t');	
		}

		 if(!empty($orderBy)){
			$this->db->order_by($orderBy, 'desc');
		 }
		 
		
		$entityMediaData = $this->db->get();
		//echo $this->db->last_query(); die;

		return $entityMediaData->result();
	}

	function updatePromoMedia($updateData,$mediaId,$tableName){
	 $this->db->where('mediaId',$mediaId);
	 $query = $this->db->update($tableName, $updateData);	
	}

	function insertPromoMedia($insertData,$tableName){

	 //$insertData['tdsUId'] = $this->userId;
	 $query = $this->db->insert($tableName, $insertData);	

	}

	function deletePromoMedia($mediaId,$tableName){
	 //$insertData['tdsUId'] = $this->userId;

	 $this->db->where('mediaId', $mediaId);
	 $this->db->delete($tableName); 
	}

	function countPromotionMedia($entityTableName,$entityFieldId,$entityFieldValue,$mediaType,$flag)
	{

		$fieldmediaType = 'mediaType';
		$this->db->from($entityTableName);
		$this->db->join('MediaFile','MediaFile.fileId = '.$entityTableName.'.fileId');

		$this->db->where($entityFieldId,$entityFieldValue);
		if(strcmp($entityFieldId,'eventId') ==0) $this->db->where('launchEventId IS NULL',null,true);
		if($flag =='')
			$this->db->where($fieldmediaType,$mediaType);
		else
		$this->db->where('mediaType !=',$mediaType);

		if(strcmp($entityTableName,'UpcomingProjectMedia') == 0)

		$this->db->order_by('isMain','desc');
		$dataProject = $this->db->get();
		return $dataProject->num_rows();
	}

//For Listing Additional Info	
public function listAdditionalInfo($addInfoTable,$whereArray,$orderBy='',$order='ASC',$limit=0,$flagPosition=0){

  $addInfo= $this->db->dbprefix($addInfoTable);
  if($flagPosition ==0){
	$this->db->order_by('position','ASC');
	}
  else{
	  if(is_array($orderBy))
		$this->db->order_by(key($orderBy),$orderBy[key($orderBy)]);
  }

  $this->db->select($addInfoTable.'.*');
  
  $this->db->from($addInfoTable);
  if(strstr($addInfoTable,'AddInfoNews')){
	  $this->db->select('ne.title as "newsElementTitle"');
	  $this->db->join('NewsElement as ne', 'ne.elementId = CAST("'.$addInfo.'"."associatedNewsElementId" as int)', 'left');
  }
  
  if(strstr($addInfoTable, 'EventSessions')){
	  $this->db->where('EventSessions.isDeleted', 0);
   }

   if(isset($whereArray) && $whereArray!=''){
	$this->db->where($whereArray);
	
   }
  $query = $this->db->get();
  return $query->result();
  
 }

 public function saveAdditionalInfo($addInfoTable,$fieldValues,$primaryKey,$flag=0,$valid=0)
 {
		if($flag==0)
		{
			$this->db->select_max('position');
			$this->db->from($addInfoTable);
			$addInfoMaxPos = $this->db->get();
			$result = $addInfoMaxPos->row();		
		}
   
		if($fieldValues[$primaryKey] > 0)
		{
			//echo "<pre />update".$fieldValues[$primaryKey];				
			//print_r($fieldValues);
			$this->db->where($primaryKey,$fieldValues[$primaryKey]);
			if($flag==0 && $valid==1)
			{			
			if(!isset($result->position) || $result->position =='')
			 $fieldValues['position'] = 1;
			else
			 $fieldValues['position'] = $result->position+1; 
			} 			
			$addInfoResult = $this->db->update($addInfoTable,$fieldValues);//Update post
			//echo '<br />'.$this->db->last_query();
			return $fieldValues[$primaryKey];
			
		} 
		else
		{	
			
			unset($fieldValues[$primaryKey]);
			if($flag==0)
			{			
			if(!isset($result->position) || $result->position =='')
			 $fieldValues['position'] = 1;
			else
			 $fieldValues['position'] = $result->position+1; 
			}
			
			$addInfoResult = $this->db->insert($addInfoTable, $fieldValues);//Insert new record for posts
			
			$ID = $this->db->insert_id();
			return $ID;	//inserted Id 
		}		
 }
 

	public function shiftCellAdditionalInfo($tableName,$primaryKey,$currentId,$currentPos,$swapId,$swapPos)
	{
	 $position ='position';		
		// If both rows exist then swap		
		$currentPosUpdate[$position] = $swapPos;
		$this->db->where($primaryKey,$currentId);	
		$queryUpdateCurrentRecord = $this->db->update($tableName,$currentPosUpdate);//Update Record			
		if($currentPos == '') $currentPos=0;
		$prevPosUpdate[$position] = $currentPos;
		$this->db->where($primaryKey,$swapId);	
		$queryUpdatePrevRecord = $this->db->update($tableName,$prevPosUpdate);//Update Record	
	}
	

	function chcekForFeaturedImage($localMediaTable,$mediaId,$entityIdFiled,$entityIdValue,$mediaType)
	{
		$fieldmediaId = 'mediaId';
		$fieldentityIdFiled = $entityIdFiled;
		$fieldmediaType = 'mediaType';
		$this->db->from($localMediaTable);
		$this->db->where($fieldmediaId,$mediaId);
		$this->db->where($fieldentityIdFiled,$entityIdValue);
		$this->db->where($fieldmediaType,$mediaType);
		$this->db->where('isMain','t');
		$getProductPromotionMediaStatus = $this->db->get();
		//echo $this->db->last_query();
		$result =  $getProductPromotionMediaStatus->row();
		return $result->mediaId;
	}
	
	function deleteMedia($localMediaTable,$mediaId, $entityIdFiled,$entityIdValue)
	{
		$fileId = $this->getFileId($localMediaTable, $mediaId, $entityIdFiled,$entityIdValue);
		$whereProjectMedia = array('mediaId' => $mediaId,$entityIdFiled =>$entityIdValue);
		$where = array('fileId' => $fileId);
		$this->deleteRow($localMediaTable, $whereProjectMedia);
		$this->deleteRow('MediaFile', $where);
		return true;
	}
	
	function getFileId($localMediaTable, $mediaId, $entityIdFiled,$entityIdValue)
	{
		$this->db->from($localMediaTable);
		$this->db->where('mediaId',$mediaId);
		$this->db->where($entityIdFiled,$entityIdValue);
		$query = $this->db->get();
		return $query->row()->fileId;
	}
	
	function updatePromotionImageStatus($localMediaTable,$entityIdFiled,$entityIdValue,$mediaType)
	{
		$fieldmediaType = 'mediaType';
		$this->db->from($localMediaTable);
		$this->db->where($fieldmediaType,$mediaType);
		$this->db->where($entityIdFiled,$entityIdValue);
		$this->db->limit(1);
		$query = $this->db->get();
		$result =  $query->row();

		if(!empty($result)){
		$idToBeUpdated = $result->mediaId;

		$this->db->set('isMain', 't');
		$this->db->where('mediaId', $idToBeUpdated);
		$this->db->update($localMediaTable);

		return true;
		}else
		{
			return false;
		}
	}
	
	function deleteRow($table,$where)
	{
		$this->db->delete($table, $where);
		return true;
	}
	
	function changePromotionMediaStatus($localMediaTable, $mediaId,$entityIdFiled,$entityIdValue)
	{
		$this->isMain = 't';
		$field = 'mediaId';
		$fieldentityIdFiled = $entityIdFiled;
		$this->db->where($field,$mediaId);
		$this->db->where($fieldentityIdFiled,$entityIdValue);
		$this->db->update($localMediaTable,$this);
		//echo $this->db->last_query();
		return true;
	}
	
	///////////// For video Section //////////////////////////////
	function PromotionVideoRecordSet($table,$whereFiled,$whereFiledValue,$mediaType)
	{
		//echo $table.','.$whereFiled.','.$whereFiledValue.','.$mediaType;
		$field = $whereFiled;
		$fieldmediaType = 'mediaType';

		$this->db->select('*');
		$this->db->from($table);
		$this->db->join("MediaFile", "MediaFile.fileId = ".$table.".fileId", 'left');		

		$this->db->where($field,$whereFiledValue);
		$this->db->where($fieldmediaType,$mediaType);
		$this->db->order_by($whereFiled,'asc');
		$dataProduct = $this->db->get();
		
		return $dataProduct->result();
	}

	function updatePromotionVideo($table,$updateData,$masterId,$masterVal)
		{
			$mediaId = $masterVal;
			$this->db->from($table);
			$this->db->where($masterId,$mediaId);
			$this->db->where('mediaType',2);
			$dataProduct = $this->db->get();
			$dataMedia = $dataProduct->result();
			$fileId = $dataMedia[0]->fileId;

			$Mediadata['filePath'] = $updateData->videoPromotionMediaPath;
			$Mediadata['fileName'] = $updateData->videoPromotionMediaName;
			$Mediadata['fileType'] = 2;

			$this->db->where('fileId',$fileId);
			$this->db->update('MediaFile',$Mediadata);
			//echo $this->db->last_query(); die;
			return true;
		}

	function insertPromotionVideo($table,$insertData,$masterId,$masterVal)
		{
			$localMediaData = '';
			$mediaFileData->filePath = $insertData->videoPromotionMediaPath;
			$mediaFileData->fileName = $insertData->videoPromotionMediaName;
			$mediaFileData->fileType = $insertData->videoPrmotionMediaType;
			$this->db->insert('MediaFile' , $mediaFileData);
			$fileId =  $this->db->insert_id();

			$localMediaData->fileId = $fileId;
			$localMediaData->$masterId = $masterVal;
			$localMediaData->mediaType = $insertData->videoPrmotionMediaType;
			$localMediaData->isMain = 't';
			$this->db->insert($table , $localMediaData);
		//	echo $this->db->last_query(); die;
			return true;
		}

//added by gurutva to make attribute for seesion time to get form filled on edit	

function getSessionTimeAtt($sesTimeId=0)
{
		//ticket attribute setting to fill the form on edit
		$ticketsArray = array('tableName'=>'Tickets');//AddInfoNews,AddInfoReviews,AddInfoInterview
				
		$ticketsfields = $this->db->list_fields($this->db->dbprefix($ticketsArray['tableName']));

		foreach ($ticketsfields as $field)
		{
			$ticketsArray['fieldKeys'][]=$field;
		} 		
	
		$ticketswhereArray = array('SessionId'=>$sesTimeId);		
		$tickOrderBy = '';
				

		$ticketsData = $this->listAdditionalInfo($this->db->dbprefix($ticketsArray['tableName']),$ticketswhereArray,$tickOrderBy,'','',1);
		
		//spe price schedule ticket attribute setting to fill the form on edit
		$speTicketsArray = array('tableName'=>'TicketPriceSchedule');
				
		$speTicketsfields = $this->db->list_fields($this->db->dbprefix($speTicketsArray['tableName']));

		foreach ($speTicketsfields as $field)
		{
			$speTicketsArray['fieldKeys'][]=$field;
		} 
	
		$speTicketsObject = new lib_additional_info($speTicketsArray) ;
		
		$sessionattribute = '';
		
		foreach ($ticketsData as $key =>$ticketAttrArray)
		{
			//echo '<pre />';
			//print_r($ticketAttrArray);
			$sessionattribute['ticketId'.$ticketAttrArray->TicketCategoryId] = $ticketAttrArray->TicketId;
			$sessionattribute['ticket'.$ticketAttrArray->TicketCategoryId] = $ticketAttrArray->Quantity;
			//$sessionattribute .= ' \'ticketId'.$ticketAttrArray->TicketCategoryId.'\' => '.$ticketAttrArray->TicketId.',';
			//$sessionattribute .= ' \'ticket'.$ticketAttrArray->TicketCategoryId.'\' => "'.$ticketAttrArray->Quantity.'"';
			//echo 'isCategoryA'.$ticketAttrArray->isCategoryA;
			//echo '<br />isCategoryB'.$ticketAttrArray->isCategoryB;
			//echo '<br />isCategoryC'.$ticketAttrArray->isCategoryC;
			if($ticketAttrArray->isCategoryA == 't' || $ticketAttrArray->isCategoryB == 't' || $ticketAttrArray->isCategoryC == 't'|| $ticketAttrArray->Free == 't')
			{
				$sessionattribute['ticketCheckBox'.$ticketAttrArray->TicketCategoryId] = 1;
			}
			
			
			$sessionattribute['price'.$ticketAttrArray->TicketCategoryId] = $ticketAttrArray->Price;
			//$sessionattribute .= ' \'price'.$ticketAttrArray->TicketCategoryId.'\' => "'.$ticketAttrArray->Price.'"';
			$speTicketswhereArray = array('TicketId'=>$ticketAttrArray->TicketId);
			$orderBy = '';
			
		$speTicketsData = $this->listAdditionalInfo($this->db->dbprefix($speTicketsArray['tableName']),$speTicketswhereArray,$orderBy,'','',1);
		
				
		foreach ($speTicketsData as $key =>$speTicketAttrArray)
		{
			//echo '<pre />';
			//print_r($ticketAttrArray);
			$sessionattribute['PriceScheduleId'.$ticketAttrArray->TicketCategoryId] = $speTicketAttrArray->PriceScheduleId;
			
			if(isset($speTicketAttrArray->StartDate) && $speTicketAttrArray->StartDate!='')
			{
				$subStartDate = substr($speTicketAttrArray->StartDate,0,-9);
				$sessionattribute['speStartDate'.$ticketAttrArray->TicketCategoryId] = $subStartDate;				
						
			}
			$sessionattribute['speStartPrice'.$ticketAttrArray->TicketCategoryId] =$speTicketAttrArray->Price;	
			if(isset($speTicketAttrArray->EndDate) && $speTicketAttrArray->EndDate!='')
			{
				$subEndDate = substr($speTicketAttrArray->EndDate,0,-9);
				$sessionattribute['speEndDate'.$ticketAttrArray->TicketCategoryId] = $subEndDate;				
				$sessionattribute['speEndPrice'.$ticketAttrArray->TicketCategoryId] = $speTicketAttrArray->Price;			
			}
		}
		}
	//echo '<pre />'; print_r($sessionattribute);die;
		
		return $sessionattribute;
}
//////////////// End ////////////////////////

	/**
	 * creativeInvolved fucntion 
	 *
	 * creativeInvolved call by  Media Controller 
	 *
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
	public function creativeInvolved($table='AssociativeCreatives', $recordId=0,$masterTableId=0){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where('elementId',$recordId);
			$this->db->where('crtStatus','t');
			$this->db->where('entityId',$masterTableId);
			$this->db->order_by('crtId','DESC');
			$query = $this->db->get();
			$this->db->last_query();
			return $result=$query->result();
	}


	/**
	 * Group Name fucntion 
	 *
	 * group_name call by  Trunk Controller 
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 * Author : Lalit
	 */
	function group_name($user_group)
	{
			$result = array();
			$this->db->select('name');
			$this->db->from('forum_groups');
			$this->db->where('id',$user_group);
			$query = $this->db->get();
			$result =$query->result();
			return $result[0]->name;
	}


	/**
	 * Get Category Segment function 
	 *
	 * getCategorySegment call by  libraries/template.php 
	 *
	 * @access	public
	 * @param	string
	 * @return	int
	 * Author : Lalit
	 */
	function getCategorySegment($category_segment)
	{
			$result = array();
			$this->db->select('CategoryID');
			$this->db->from('forum_category');
			$this->db->where('Menu',$category_segment);
			$query = $this->db->get();
			$result =$query->result();
			if(count($result) > 0 )
			{
				return $result[0]->CategoryID;
			} 
			else
			{
				return 0;
			}
		
	}
	
	
	/**
	 *  get category id of entity
	 *  @ return category id
	 *  Amit 
	 *  26June12
	**/
	
	function getEntityCategory($entityId)
	{			
			$this->db->select('catId');
			$this->db->from('ProjCategory');
			$this->db->where('entityId',$entityId);
			$query = $this->db->get();
			$result =$query->result();
			if(count($result) > 0 )
			{
				return $result[0]->catId;
			} 
			else
			{
				return 0;
			}
		
	}
	
	
	/**
	  *********** All functionalities related with Social Media Links ***********
	**/

	function getSocialMedia($entityId)
	{
		 $joinTable = 'profileSocialMediaIcon';
		 $tableProfileSocialLink='profileSocialLink';
		$userWorkProfileID  = $this->model_common->getWorkProfileID($entityId,$tableProfileSocialLink);
		
		if(empty($userWorkProfileID))  
		{
			//$Upload_File_Name['error'] = 'Please Fill the Personal Information First';
			//set_global_messages($Upload_File_Name['error'], 'error');
			//Commented to stop redirecting
			//redirect('addiditionalInfo/socialMediaForm');
		}
		else {
			$profileId = $userWorkProfileID[0]->entityId;
			$field = 'entityId';
			$this->db->join('profileSocialMediaIcon', 'profileSocialMediaIcon.profileSocialMediaId = profileSocialLink.profileSocialLinkType');
			$this->db->where($field,$profileId);
			$this->db->where('socialLinkArchived','f');
			$this->db->order_by('position','asc');
			
			$workSocialMedia = $this->db->get($tableProfileSocialLink);
			return $workSocialMedia->result();
		}
	}
	
	function getDetailSocialMedia($whereArray)
	{
		 $joinTable = 'profileSocialMediaIcon';
		 $tableProfileSocialLink='profileSocialLink';
		
			//$profileId = $userWorkProfileID[0]->entityId;
			//$field = 'entityId';
			$this->db->join('profileSocialMediaIcon', 'profileSocialMediaIcon.profileSocialMediaId = profileSocialLink.profileSocialLinkType');
			$this->db->where($whereArray);
			$this->db->where('socialLinkArchived','f');
			$this->db->order_by('position','asc');
			
			$workSocialMedia = $this->db->get($tableProfileSocialLink);
			return $workSocialMedia->result();
		
	}
	
	
	/**
		* getWorkProfileID method fetches the workProfileId form WorkProfile on the basis of logged in userId
		* giving the ID in the options object priority.
		*
		* @param NULL
		* @return Object
	*/
	function getWorkProfileID($entityId,$tableProfileSocialLink)
	{ 
		
		
		$ProfileResultID = $this->model_common->getDataFromTabel($tableProfileSocialLink, '*',  'entityId', $entityId, '', 'ASC', 0 );
		
		if($ProfileResultID!='')
			return $ProfileResultID;
		else
			return FALSE;
	}
		
		
		
		//Function to shift positions of social media links
		
	function shiftRecord($tableName,$fieldId,$currentId,$currentPos,$swapId,$swapPos)
	{
		$position ='position';
		// If both rows exist then swap
		$currentPosUpdate[$position] = $swapPos;
		$this->db->where($fieldId,$currentId);
		$queryUpdateCurrentRecord = $this->db->update($tableName,$currentPosUpdate);//Update Record
		
		$prevPosUpdate[$position] = $currentPos;
		$this->db->where($fieldId,$swapId);
		$queryUpdatePrevRecord = $this->db->update($tableName,$prevPosUpdate);//Update Record
	}
    
    function countMembers($where='', $craved=false)
	{			
		if(is_array($where) && count($where) > 0){
			$this->db->from($this->tableUserShowcase.' as sc');
            if($craved){
                $entityId=getMasterTableRecord($this->db->dbprefix($this->tableUserShowcase));
                $tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
                $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = sc.showcaseId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ');
                $this->db->where($this->tableLogSummary.'.craveCount >',0);
            }
			$this->db->where($where);
            $res= $this->db->count_all_results();
            return $res;
        
	  }else{
		 return 0;
	  }
	}
    
    function countProjectElements($table='', $where='', $craved=false)
	{			
		if(!empty($table) && is_array($where) && count($where) > 0){
			$this->db->from($table.' as e');
            $this->db->join($this->tableProject.' as p', 'p.projId = e.projId');
            if($craved){
                $entityId=getMasterTableRecord($this->db->dbprefix($table));
                $tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
                $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = e.elementId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ');
                $this->db->where($this->tableLogSummary.'.craveCount >',0);
            }
			$this->db->where($where);
            $res= $this->db->count_all_results();
            return $res;
	  }else{
		 return 0;
	  }
	}
    
    function countProject($table='', $where='', $craved=false)
	{			
		if(!empty($table) && is_array($where) && count($where) > 0){
            	
			$this->db->from($table);
            if($craved){
                $entityId=getMasterTableRecord($this->db->dbprefix($table));
                $tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
                $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$table.'.projId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ');
                $this->db->where($this->tableLogSummary.'.craveCount >',0);
            }
			$this->db->where($where);
            $res= $this->db->count_all_results();
            return $res;
	  }else{
		 return 0;
	  }
	}	
			
	/* Fornt end Landing Pages Functions */		
	function getMembers($where='',$limit=0,$offset=0)
	{			
		if(is_array($where) && count($where) > 0){
			$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
			$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
			
			$entityId=getMasterTableRecord($this->tableUserShowcase);
			
            $this->db->select('sc.profileImageName,sc.showcaseId,sc.optionSelected,sc.optionAreaName,sc.creativeFocus,sc.enterprise,sc.enterpriseName,sc.stockImageId');		
			$this->db->select('si.stockImgPath, si.stockFilename');		
			
			$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');		
			$this->db->select('u.username,u.tdsUid');	
			$this->db->select('up.firstName, up.lastName');
            $this->db->select('c.countryName');
		
		
			$this->db->from($this->tableUserShowcase.' as sc');
				
			$this->db->join($this->tableStockImages.' as si', 'si.stockImgId = sc.stockImageId', 'left');
			$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = sc.showcaseId AND ls."entityId"='.$entityId,'left');
			$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid = sc.tdsUid','left');
			$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = u.tdsUid','left');
            $this->db->join($this->tableMasterCountry.' as c', 'c.countryId = up.countryId', 'left');

			$loggedUserId=isloginUser();
			if($loggedUserId > 0){
				$this->db->select($this->tableLogCrave.'.craveId');
				$this->db->join($this->tableLogCrave, $this->tableLogCrave.'.elementId = sc.showcaseId AND  "'.$tableLogCrave.'"."entityId"='.$entityId.' AND  "'.$tableLogCrave.'"."tdsUid"='.$loggedUserId.' ', 'left');
			}
			
			$this->db->where($where);
			$this->db->order_by('sc.showcaseId','desc');
			if(is_numeric($limit) && ($limit > 0)){
				$this->db->limit($limit,$offset);
			}
			$query = $this->db->get();
			
			return $query->result();
		
	  }else{
		return false;  
	  }
	}
    
	function getMembersTopCraved($where='',$limit=0,$offset=0)
	{			
		if(is_array($where) && count($where) > 0){
			$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
			$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
			
			$entityId=getMasterTableRecord($this->tableUserShowcase);
			$this->db->select('sc.profileImageName,sc.showcaseId,sc.optionSelected,sc.optionAreaName,sc.creativeFocus,sc.enterprise,sc.enterpriseName,sc.stockImageId');		
			$this->db->select('si.stockImgPath, si.stockFilename');		
			
			$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');		
			$this->db->select('u.username,u.tdsUid');	
			$this->db->select('up.firstName, up.lastName');
		
			$this->db->from($this->tableUserShowcase.' as sc');
				
			$this->db->join($this->tableStockImages.' as si', 'si.stockImgId = sc.stockImageId', 'left');
			$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = sc.showcaseId AND ls."entityId"='.$entityId);
			$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid = sc.tdsUid','left');
			$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = u.tdsUid','left');
			
            $loggedUserId=isloginUser();
			if($loggedUserId > 0){
				$this->db->select($this->tableLogCrave.'.craveId');
				$this->db->join($this->tableLogCrave, $this->tableLogCrave.'.elementId = sc.showcaseId AND  "'.$tableLogCrave.'"."entityId"='.$entityId.' AND  "'.$tableLogCrave.'"."tdsUid"='.$loggedUserId.' ', 'left');
			}
			
			$this->db->where($where);
			$this->db->order_by('ls.craveCount','DESC');
            
            if(is_numeric($limit) && ($limit > 0)){
				$this->db->limit($limit,$offset);
			}
			$query = $this->db->get();
			
			return $query->result();
		
	  }else{
		return false;  
	  }
	}

 //To fetch the elements(news,reviews) for landing pages
 public function getProjectElements($projId=0,$elementTblPrefix='Fv', $elementId=0,$orderby='order',$order='ASC',$fetchElementFields='*',$industryType='',$entityId=0,$limit=0,$offset=0){
	    
	    $elementTable=$elementTblPrefix.$this->tableElement;
		$table=$this->db->dbprefix($elementTable);			
		$entityId=getMasterTableRecord($table);			
		$tableLogSummary = $this->db->dbprefix($this->tableLogSummary);
		$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
		$fetchElementFields="".$elementTable.".elementId, ".$elementTable.".fileId,title,description,imagePath,modifyDate,createdDate";
		if($elementTable=='NewsElement' || $elementTable=='ReviewsElement'){
			$fetchElementFields.=",".$elementTable.".article";
		}
		
		$this->db->select($fetchElementFields.', '.$this->tableProject.'.projId as projectid, '.$this->tableProject.'.projShortDesc as projshortdesc, '.$this->tableProject.'.tdsUid as projuserid,'.$tableLogSummary.'.craveCount,'.$tableLogSummary.'.viewCount,'.$tableLogSummary.'.ratingAvg');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName,'.$this->UserProfile.'.tdsUid');
		
		if($elementTable=='NewsElement' || $elementTable=='ReviewsElement'){
			$this->db->select($this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.enterprise,'.$this->tableUserShowcase.'.creative,'.$this->tableUserShowcase.'.associatedProfessional,'.$this->tableUserShowcase.'.profileImageName');
			$this->db->select($this->tableUserShowcase.'.stockImageId,'.$this->tableStockImages.'.stockImgPath,'.$this->tableStockImages.'.stockFilename');
			$this->db->select($this->tableUserAuth.'.username');
		}else{	
			$this->db->select($this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.enterprise');
		}
		
		$this->db->select($this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.ratingAvg,'.$this->tableLogSummary.'.viewCount');
		
		$this->db->from($elementTable);
		$this->db->join($this->tableProject, $this->tableProject.".projId = ".$elementTable.'.projId');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableProject.".tdsUid");
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableProject.".tdsUid");
		
		if($elementTable=='NewsElement' || $elementTable=='ReviewsElement'){
			$this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->tableUserShowcase.".stockImageId", 'left');
			$this->db->join($this->tableUserAuth, $this->tableUserShowcase.".tdsUid = ".$this->tableUserAuth.".tdsUid");
		}
		
		$this->db->join($this->tableMasterIndustry,$this->tableMasterIndustry.'.IndustryId = '.$elementTable.'.industryId', 'left');
		
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.".elementId = ".$elementTable.".elementId AND \"".$tableLogSummary."\".\"entityId\"=".$entityId." " ,'left');
		$loggedUserId=isloginUser();
		if($loggedUserId > 0){
			$this->db->select($this->tableLogCrave.'.craveId');
			$this->db->join($this->tableLogCrave, $this->tableLogCrave.'.elementId = '.$elementTable.'.elementId AND  "'.$tableLogCrave.'"."entityId"='.$entityId.' AND  "'.$tableLogCrave.'"."tdsUid"='.$loggedUserId.' ', 'left');
		}
		
		
		if($elementTable=='NewsElement' || $elementTable=='ReviewsElement'){
			$this->db->or_where(array('( "description" !='=>'','article !='=>''.')'));
			
		}else{
			$this->db->where($elementTable.'.description !=','');
		}
		$this->db->where($this->tableMasterIndustry.'.IndustryKey',$industryType);
		if($elementId>0){	
			$this->db->where($elementTable.'.elementId',$elementId);
		}	
		$this->db->where($this->tableProject.'.isPublished','t');	
		$this->db->where($this->tableProject.'.isArchive','f');		
		$this->db->where($elementTable.'.isPublished','t');	
		$this->db->where($elementTable.'.isArchive','f');	
		
		if($orderby=='order'){
			$this->db->order_by($this->tableMediaEelementType.".".$orderby, $order);
		}else{
			$this->db->order_by($elementTable.".".$orderby, $order);
		}
		
		if(is_numeric($limit) && ($limit > 0)){
			$this->db->limit($limit,$offset);
		}
		 
		$query = $this->db->get();
		
		$result=$query->result();
		
		return $result;
	}
    
    public function getProjectElementsLP($elementTable, $limit=0, $offset=0,$where=''){
	    
		$table=$this->db->dbprefix($elementTable);			
		$entityId=getMasterTableRecord($table);			
		$tableLogSummary = $this->db->dbprefix($this->tableLogSummary);
		$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
		
        $this->db->select($elementTable.".elementId,".$elementTable.".projId,".$elementTable.".title,".$elementTable.".imagePath,".$elementTable.".isDownloadPrice,".$elementTable.".isPerViewPrice,".$elementTable.".isPrice,".$elementTable.".createdDate,".$elementTable.".modifyDate,".$elementTable.".quantity,".$elementTable.".projType,".$elementTable.".projGenre,".$elementTable.".projGenreFree,".$elementTable.".projReleaseDate,".$elementTable.".displayImageType,".$elementTable.".isShippable");
		$this->db->select($this->tableProject.'.tdsUid, '.$this->tableProject.'.projSellstatus, '.$this->tableProject.'.projCategory');
		$this->db->select($this->tableProjectType.'.projectTypeName');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');
        $this->db->select($this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.enterprise,'.$this->tableUserShowcase.'.creative,'.$this->tableUserShowcase.'.associatedProfessional,'.$this->tableUserShowcase.'.profileImageName');
        $this->db->select($this->tableUserShowcase.'.stockImageId,'.$this->tableStockImages.'.stockImgPath,'.$this->tableStockImages.'.stockFilename');
       
        $this->db->select($this->tableGenre.'.Genre');
        $this->db->select('c1.countryName');
        $this->db->select($this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.ratingAvg,'.$this->tableLogSummary.'.viewCount');
		
        $this->db->from($elementTable);
		$this->db->join($this->tableProject, $this->tableProject.".projId = ".$elementTable.'.projId');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableProject.".tdsUid");
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableProject.".tdsUid");
		$this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->tableUserShowcase.".stockImageId", 'left');
        
        $this->db->join($this->tableProjectType, $this->tableProjectType.".typeId = ".$this->tableProject.'.projType', 'left');
        $this->db->join($this->tableGenre, $this->tableGenre.".GenreId = ".$elementTable.".projGenre", 'left');
        $this->db->join($this->tableMasterCountry." c1", "c1.countryId = ".$elementTable.".producedInCountry", 'left');
        $this->db->join($this->tableLogSummary, $this->tableLogSummary.".elementId = ".$elementTable.".elementId AND \"".$tableLogSummary."\".\"entityId\"=".$entityId);
       
        $loggedUserId=isloginUser();
		if($loggedUserId > 0){
			$this->db->select($this->tableLogCrave.'.craveId');
			$this->db->join($this->tableLogCrave, $this->tableLogCrave.'.elementId = '.$elementTable.'.elementId AND  "'.$tableLogCrave.'"."entityId"='.$entityId.' AND  "'.$tableLogCrave.'"."tdsUid"='.$loggedUserId.' ', 'left');
		}
		
		$this->db->where($this->tableProject.'.isPublished','t');	
		$this->db->where($this->tableProject.'.isArchive','f');	
        $this->db->where($elementTable.'.isPublished','t');
		$this->db->where($elementTable.'.isArchive','f');	
		$this->db->where($this->tableLogSummary.'.craveCount >',0);	
		if(is_array($where) && !empty($where)){
            $this->db->where($where);
        }
		$this->db->order_by($this->tableLogSummary.'.craveCount','DESC');
		
		if(is_numeric($limit) && ($limit > 0)){
			$this->db->limit($limit,$offset);
		}
		 
		$query = $this->db->get();
		
		$result=$query->result();
		
		return $result;
	}
    
 //To fetch the elements(news,reviews) for landing pages
 public function getProjectElementsImage($projId=0,$elementTblPrefix='Fv', $elementId=0,$orderby='order',$order='ASC',$fetchElementFields='*',$industryType='',$entityId=0,$limit=0)
	{
	   // Get Project elemnet data from table : (FvMedia, MaSong), ProjActivity, MediaFile
		$elementTable=$elementTblPrefix.$this->tableElement;
		$table=$this->db->dbprefix($elementTable);
		
		$tableLogSummary = $this->db->dbprefix($this->tableLogSummary);		
		
		$entityId=getMasterTableRecord($table);			

		
		if($fetchElementFields=='')
		$fetchElementFields="".$elementTable.".elementId, ".$elementTable.".fileId,title,description,imagePath,modifyDate,createdDate";
		else
		$fetchElementFields="".$elementTable.".elementId, ".$fetchElementFields;
		$this->db->select(''.$fetchElementFields.', '.$this->tableProject.'.projId as projectid, '.$this->tableProject.'.tdsUid as projUserId,'.$tableLogSummary.'.craveCount,'.$tableLogSummary.'.viewCount,'.$tableLogSummary.'.ratingAvg');
		
		$this->db->from($elementTable);
		
		$this->db->join($this->tableMediaFile, $this->tableMediaFile.".fileId = ".$elementTable.".fileId", 'left');
		$this->db->join($this->tableProject, $this->tableProject.".projId = ".$elementTable.'.projId', 'left');
		//$this->db->join($this->tableMasterIndustry,$this->tableMasterIndustry.'.IndustryId = '.$elementTable.'.industryId', 'left');
		//$this->db->where($this->tableMasterIndustry.'.IndustryName',$industryType);
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.".elementId = ".$this->tableProject.".projId AND \"".$tableLogSummary."\".\"entityId\"=".$entityId." " ,'left');
		$this->db->where($this->tableProject.'.isPublished','t');
		$this->db->where($elementTable.'.description !=','');
		//$this->db->where($this->tableLogSummary.'.entityId',$entityId);
		if($elementId>0){	
			$this->db->where($elementTable.'.elementId',$elementId);
		}		
		if($orderby=='order'){
			$this->db->order_by($this->tableMediaEelementType.".".$orderby, $order);
		}else{
			$this->db->order_by($elementTable.".".$orderby, $order);
		}
		$query = $this->db->get();
		$result=$query->result();
		return $result;
	}
	
	 
	public function getProject($UserId=0,$projectType='',$projectId=0,$elementTblPrefix='Fv',$orderby='order',$order='ASC',$fetchFields='*',$fetchElementFields='*',$elementOrderBy){		
		$result = $this->getProjectRecord($projectType,$UserId,$projectId,$fetchFields);
		if($result && (!empty($elementTblPrefix) )){
				foreach($result as $key=>$data){
					$result[$key]->elements=$this->getProjectElements($data->projectid,$elementTblPrefix,0,$elementOrderBy,$order);			
				}
		}
		return $result;
	}
	
	/**
	 * getProjectRecord fucntion 
	 *
	 * get Project detail from database
	 *
	 * @access	private
	 * @param	string
	 * @return	Object
	 */
	 
	public function getProjectRecord($projectType='',$UserId=0,$projectId=0,$fetchFields='*',$limit=0,$offset=0,$order_by='',$order='',$where=''){
			$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
			$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
			$table=$this->db->dbprefix($this->tableProject);			
			$entityId=getMasterTableRecord($table);			
			
			$this->db->select(''.$fetchFields.', '.$this->tableProject.'.projId as projectid');
			$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName,'.$this->UserProfile.'.tdsUid');
			$this->db->select($this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.enterprise');
			$this->db->select($this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.ratingAvg,'.$this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.reviewCount,'.$this->tableLogSummary.'.printCount');
			
            $this->db->from($this->tableProject);
			
			$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableProject.".tdsUid");
			$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableProject.".tdsUid");
			if($order_by == 'LogSummary.craveCount'){
                $joinType = '';
                $this->db->where($this->tableLogSummary.'.craveCount >',0);
            }else{
                $joinType = 'left';
            }
            $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->tableProject.'.projId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', $joinType);
			
			$loggedUserId=isloginUser();
			if($loggedUserId > 0){
				$this->db->select($this->tableLogCrave.'.craveId');
				$this->db->join($this->tableLogCrave, $this->tableLogCrave.'.elementId = '.$this->tableProject.'.projId AND  "'.$tableLogCrave.'"."entityId"='.$entityId.' AND  "'.$tableLogCrave.'"."tdsUid"='.$loggedUserId.' ', 'left');
			}
			
			
			if(!empty($projectType)){
				$this->db->where($this->tableProject.'.projectType',$projectType);				
			}
			if($UserId > 0){
				$this->db->where($this->tableProject.'.tdsUid',$UserId);						
			}
			if($projectId > 0){
				$this->db->where($this->tableProject.'.projId',$projectId);						
			}
            $this->db->where($this->tableProject.'.isArchive','f');
            $this->db->where($this->tableProject.'.isBlocked','f');
			$this->db->where($this->tableProject.'.isPublished','t');
            
            if(is_array($where) && !empty($where)){
                $this->db->where($where);
            }
			
            $order_by=($order_by == '') ? $this->tableProject.'.projLastModifyDate' : $order_by;
            $order = ($order == '') ? 'DESC' : $order;
			$this->db->order_by($order_by, $order); 
			if(is_numeric($limit) && ($limit > 0)){
				$this->db->limit($limit,$offset);
			}
			
			$query = $this->db->get();
            //echo $this->db->last_query();
			return $result=$query->result();
	}	
	
		
	function getUpcomingProjects($industryId=0,$projUpType,$limit=0,$offset=0)
	{			
		$entityId = getMasterTableRecord($this->upcomingProjectTableName);
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
		$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
		
		$this->db->select($this->upcomingProjectTableName.'.projId,projTitle,proShortDesc,'.$this->upcomingProjectTableName.'.tdsUid,  '.$this->upcomingProjectTableName.'.projIndustry, '.$this->upcomingProjectMediaTableName.'.projId as projectid, '.$this->upcomingProjectMediaTableName.'.fileId, MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,'.$this->upcomingProjectMediaTableName.'.isMain');
		
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName,'.$this->UserProfile.'.tdsUid');
		$this->db->select($this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.enterprise');
		$this->db->select($this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.ratingAvg,'.$this->tableLogSummary.'.viewCount');
		
		$this->db->join($this->upcomingProjectMediaTableName,$this->upcomingProjectMediaTableName.'.projId = '.$this->upcomingProjectTableName.'.projId', 'left');
		$this->db->join('MediaFile','MediaFile.fileId = '.$this->upcomingProjectMediaTableName.'.fileId', 'left');
		
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->upcomingProjectTableName.".tdsUid");
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->upcomingProjectTableName.".tdsUid");
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->upcomingProjectTableName.'.projId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
		
		$loggedUserId=isloginUser();
		if($loggedUserId > 0){
			$this->db->select($this->tableLogCrave.'.craveId');
			$this->db->join($this->tableLogCrave, $this->tableLogCrave.'.elementId = '.$this->upcomingProjectTableName.'.projId AND  "'.$tableLogCrave.'"."entityId"='.$entityId.' AND  "'.$tableLogCrave.'"."tdsUid"='.$loggedUserId.' ', 'left');
		}
		
		$this->db->where('MediaFile.fileType','1');
		$this->db->where($this->upcomingProjectMediaTableName.'.mediaType','1');
		$this->db->where($this->upcomingProjectMediaTableName.'.isMain','t');
		
		
		if(is_numeric($industryId) && ($industryId) > 0){
			$this->db->where('UpcomingProject.projIndustry',$industryId);
		}
		if(is_numeric($projUpType) && ($projUpType) > 0){
			$this->db->where('UpcomingProject.projUpType',$projUpType);
		}
		
		$this->db->where('UpcomingProject.projArchived','f');
		$this->db->where('UpcomingProject.isPublished','t');
		
		$this->db->order_by('projModifiedDate','desc');
		
		if(is_numeric($limit) && ($limit > 0)){
			$this->db->limit($limit,$offset);
		}
		
		$query = $this->db->get('UpcomingProject');
		return $query->result_array();
	}
	
	
	function addUpdateDataIntoObject($Table,$data=array()){
			$table=$this->db->dbprefix($Table);
			$countData=count($data);
			$field='';
			$fieldValue='';
			$entityid=$data['entityid'];
			$elementid=$data['elementid'];
			if(is_array($data) && $countData > 0){
				$i=0;
				foreach($data as $key=>$value){
					$i++;
					$field.="".trim($key)."";
					$fieldValue.="'".trim($value)."'";
					if($i < $countData){
						$field.=',';
						$fieldValue.=',';
					}
				}
				if($entityid > 0 && $elementid > 0){
					
					$whereField=array('entityid'=>$entityid,'elementid'=>$elementid);
					$res=$this->getDataFromTabel('search', 'id',  $whereField );
					if($res){
						foreach($res as $r){
							$id[]=$r->id;
						}
						if($id > 0){
							$this->deleteRowFromTabel($Table, 'id', $id);
						}
					}
					$insertsql = 'INSERT INTO "'.$table.'" ('.$field.') VALUES ('.$fieldValue.')' ;
					$query = $this->db->query($insertsql);
					return $this->db->insert_id();
				}else{
					return false;
				}
			}else{
				return false;
			}
	}
	
	function recommendations($where=''){
		if(is_array($where) && count($where) > 0){
			
			$this->db->select('Recommendations.*,'.$this->tableUserAuth.'.username,'.$this->tableUserShowcase.'.creative,'.$this->tableUserShowcase.'.associatedProfessional,'.$this->tableUserShowcase.'.enterprise,'.$this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.fans,'.$this->tableUserShowcase.'.profileImageName,'.$this->tableUserShowcase.'.stockImageId,'.$this->tableStockImages.'.stockImgPath,'.$this->tableStockImages.'.stockFilename');
			$this->db->select($this->tableUserProfile.'.firstName,'.$this->tableUserProfile.'.lastName');
			
			$this->db->from('Recommendations');
			
			if(isset($where['to_userid'])){
				$this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = Recommendations.from_userid','left');
				$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.'.tdsUid = Recommendations.from_userid','left');
			}elseif(isset($where['from_userid'])){
				$this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = Recommendations.to_userid','left');
				$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.'.tdsUid = Recommendations.to_userid','left');
			}
			$this->db->join($this->tableUserProfile, $this->tableUserProfile.'.tdsUid = '.$this->tableUserAuth.'.tdsUid','left');	
			$this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->tableUserShowcase.".stockImageId", 'left');
			$this->db->where($where);
			$this->db->order_by('Recommendations.created_date', 'DESC');
			$query = $this->db->get();
			if ($query->num_rows()) return $query->result();
			return FALSE;
		}
		else{
			return FALSE;
		}
		
	}
	
	function publishUnpublish($tbl='', $edtitData='', $field='',$fieldValue='')
	{
		if ($this->db->field_exists('publisheDate', $tbl))
		{
		   $edtitData['publisheDate']=currntDateTime();
		} 
		$this->editDataFromTabel($tbl, $edtitData, $field,$fieldValue);
	}
	
	function userNavigations($userId=0,$publishCheck=true, $sectionIn='')
	{
		if ($userId > 0){
		   $this->db->select('s.entityid,s.elementid,s.projectid,s.sectionid,s.section,s.ispublished');
		   $this->db->from('search as s');
		   if(is_array($sectionIn) && count($sectionIn)>0){
			   $this->db->where_in('s.section',$sectionIn);
		   }
		   $this->db->group_by(array('s.entityid','s.elementid','s.projectid','s.sectionid','s.section', 's.ispublished', '(item).userid'));
		   $this->db->having('(item).userid', $userId);
		   if($publishCheck){
			   $this->db->having('s.ispublished', 't');
		   }
		   $query = $this->db->get();
		   return $query->result_array();
		} else{
			return false;
		}
	}
	function getContainerDetails($table='',$where='', $field='')
	{
		if ($table != '' && $where !=''){
		   
		   if($field!=''){
			   $this->db->select($field);
		   }
		   $this->db->select('uc.userContainerId,uc.containerSize');
		   $this->db->from($table);
		   $this->db->join($this->tableUserContainer.' uc', "uc.userContainerId = ".$table.".userContainerId");
		   $this->db->where($where);
		   $query = $this->db->get();
		   
		   return $query->result_array();
		   
		} else{
			return false;
		}
	}
	
	
	 /**
	 * @Input: $pageKey
	 * @Output: Returns query (record source) of cms content
	 * @Access: Public
	 * Comment: This function returns query (record source) of cms content based on pageKey
	 */
	function get_cms_content($pageKey)
	{
		if ($pageKey != ''){
			$this->db->select('title, description');
			$this->db->from('CMS');
			$this->db->where('pageKey',$pageKey);
			$this->db->where('status','t');
			$query =  $this->db->get();	
			return $query->result_array();
		}else{
			return false;
		}
	}   
	/*
	function importCountryFromCSV(){
		$path = "country_state.csv";
		$row = 1;
		if (($handle = fopen($path, "r")) !== FALSE) {
			$i=0;
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				if($i){
				$insertData[]=array(
									'countryCode'=>$data[0],
									'countryName'=>pg_escape_string(trim(ucwords(strtolower($data[1])))),
									'countryLocalName'=>pg_escape_string(trim(ucwords(strtolower($data[2]))))
									);
				}
				$i++;
			}
			$this->insertBatch('MasterCountry', $insertData);
			fclose($handle);
		}
	} */
	
	/*function importstateFromCSV(){
		$path = "country_state.csv";
		$row = 1;
		if (($handle = fopen($path, "r")) !== FALSE) {
			$i=0;
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				if($i){
				$countryCode=trim(strtoupper($data[0]));
				
				$countryIdArray=	$this->getDataFromTabel('MasterCountry', 'countryId', array('upper(trim("countryCode"))'=>$countryCode),'','','',1);
				if($countryIdArray)	{
					$countryId=$countryIdArray[0]->countryId;
				}else{
					$countryId=0;
				}
				
				
				$insertData[]=array(
									'countryId'=>$countryId,
									'stateName'=>pg_escape_string(trim(ucwords(strtolower($data[1])))),
									'stateCode'=>trim($data[2]),
									'lang'=>trim($data[3])
									);
				}
				$i++;
			}
			$this->insertBatch('MasterStates', $insertData);
			fclose($handle);
		}
	}
	function updateContenent(){
		$datas=$this->getDataFromTabel('MasterCountry', 'continentId,countryName');
		foreach($datas as $data){
			$this->editDataFromTabel('MasterCountry1', array('continentId'=>$data->continentId), array('countryName'=>$data->countryName));
		}
	}*/
	

	
 /* Check is project exists for review */
	function isReviewProjects($userId){		
		$this->db->select('projId');
		$this->db->from($this->tableProject);				
		$this->db->where('projectType','reviews');
		$this->db->where('tdsUid',$userId);
		$query = $this->db->get();		
		if ($query->num_rows()>0)
		 {
			 return $query->row()->projId;
		 }else {
			  return 0;
		  }	 	
	   	
		} 	
		
	/*
	 * Get page View count 
	*/
	function get_view_count($entityId,$elementId)
	{
		
		$this->db->select('viewCount');
		$this->db->from('LogSummary');
		$this->db->where('entityId',$entityId);
		$this->db->where('elementId',$elementId);
		$query =  $this->db->get();	
		if ($query->num_rows()>0)
		{
			return $query->row()->viewCount;
		}else{
			return 0;
		}	
	} 
	
	/*
	 * Check Project view for today
	*/
	function check_project_view($entityId,$elementId,$projectId,$sectionId,$userId,$ipAddress)
	{
		
		$this->db->select('ViewId');
		$this->db->from('LogViews');
		$this->db->where('tdsUid',$userId);
		$this->db->where('projId',$projectId);
		$this->db->where('elementId',$elementId);
		$this->db->where('createDate',date('Y-m-d'));
		$this->db->where('entityId',$entityId);
		$this->db->where('sectionId',"$sectionId");
		$this->db->where('IP',$ipAddress);
		$query =  $this->db->get();
		//echo $this->db->last_query();die;
		if ($query->num_rows()>0)
		{
			return $query->row()->ViewId;
		}else{
			return 0;
		}	
	} 
	
	/*
	 * Update page View count 
	*/
	function update_view_count($data,$entityId,$elementId)
	{
		$this->db->where('entityId', $entityId);
		$this->db->where('elementId', $elementId);
		$this->db->update('LogSummary', $data);
	}
	
	/*
	 * Get entity Id  
	*/
	function get_entity_id($projectId,$elementId)
	{
		
		$this->db->select('entityid');
		$this->db->from('search');
		$this->db->where('elementid',$elementId);
		$this->db->where('projectid',$projectId);
		$query =  $this->db->get();	
		if ($query->num_rows()>0)
		{
			return $query->row()->entityid;
		}else{
			return 0;
		}	
	} 
	
	/* Get Product details */
	
	function getProductAttacment($userId,$productId) {
		
		   $tableMessages=$this->db->dbprefix($this->tableMessages);                   
           $tableAttachment = $this->db->dbprefix($this->tableAttachment);                 
          
			$sql=' SELECT count (m."id") as id				   																			
					FROM "'.$tableMessages.'" m														
					LEFT JOIN "'.$tableAttachment.'" ta ON (ta."msg_id" = m."id")																							
					WHERE m."sender_id" = '.$userId.' AND (attachment)."elementid" = '.$productId.'					
				';
			$query = $this->db->query($sql);
			$result = $query->result();
			if(!empty($result)){
			   return $result[0];	
			 }else{
			     return FALSE;
			}			
	}
	
	function executeQuery($qureyForexection){
		$query = $this->db->query($qureyForexection);
		$result = $query->result_array();
		if(!empty($result)){
			return $result[0];	
		}else{
			return FALSE;
		}
	}
	
	
	function getWorkProfileAttachment($tmailId,$currentUserId) {
		
		  $tableMessages=$this->db->dbprefix($this->tableMessages);         
          $tableAttachment = $this->db->dbprefix($this->tableAttachment);
          $tableRequestUrl = $this->db->dbprefix($this->tableRequestUrl);           
          
			$sql=' SELECT				   
					(attachment).elementid,
					tr."sender_id",
					tr."access_token"										
					FROM "'.$tableMessages.'" m
					LEFT JOIN "'.$tableAttachment.'" ta ON (ta."msg_id" = m.id) 
					LEFT JOIN "'.$tableRequestUrl.'" tr ON (attachment)."elementid" = tr."id"														
					WHERE m.id = '.$tmailId;
			$query = $this->db->query($sql);
			$res = $query->row_array();
			$this->db->last_query();
			return $res;		
	}

	//Get session details
	function ticket_session_data($sessionId)
	{
		$this->db->select('*');
		$this->db->from('EventSessions');
		$this->db->where('sessionId',$sessionId);
		$query =  $this->db->get();	
		if ($query->num_rows()>0)
		{
			return $query->row();
		}else{
			return 0;
		}	
	}
	
	//Get event details
	function ticket_event_data($eventId=0)
	{
		$this->db->select('*');
		$this->db->from('Events');
		$this->db->where('EventId',$eventId);
		$query =  $this->db->get();	
		if ($query->num_rows()>0)
		{
			return $query->row();
		}else{
			return 0;
		}	
	}
	//Get launch details
	function ticket_launch_data($launchEventId=0)
	{
		$this->db->select('*');
		$this->db->from('LaunchEvent');
		$this->db->where('LaunchEventId',$launchEventId);
		$query =  $this->db->get();	
		if ($query->num_rows()>0)
		{
			return $query->row();
		}else{
			return 0;
		}	
	}
	
	//Function to get ticket session transaction listing
	function ticketTransactionListing($sessionId='')
	{
		$this->db->select('*');
		$this->db->from('TicketTransectionLog');
		if(!empty($sessionId)){
			$this->db->where('sessionId',$sessionId);
		}
		$this->db->order_by("ticketNumber", "ASC"); 
		$query =  $this->db->get();	
		if ($query->num_rows()>0)
		{
			return $query->result();
		}else{
			return 0;
		}
	}  	
	
	function ticketSession()
	{
		$this->db->distinct();
		$this->db->select('sessionId,date');
		$this->db->from('TicketTransectionLog');
		$this->db->order_by("date", "ASC"); 
		$query =  $this->db->get();	
		if ($query->num_rows()>0)
		{
			return $query->result();
		}else{
			return 0;
		}
	}  	
	
	public function getelementsToBePublished($elementTable='',$elementWhere=array())
	{
	   
		$this->db->select($elementTable.'.elementId');
		$this->db->from($elementTable);
		$this->db->join($this->tableMediaFile, $this->tableMediaFile.".fileId = ".$elementTable.".fileId", 'left');
		$this->db->where($elementWhere);
		$query = $this->db->get();
		$result=$query->result();
		return $result;
	}
	
	
/*
 ***********
 * This functino return get shippping status
 *********** 
 */ 	
	function getShippingStatus($itemId)
	{
		
		$this->db->select('shpStatus');	
		$this->db->from('SalesItemShipping');			
		$this->db->where('itemId',$itemId);	
		$query = $this->db->get();
		//echo $CI->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->row()->shpStatus;
		}else
		{ $result = 0;	}
		return $result;
	}	
	 
/*
 ***********
 * This functino return download  and payper view status
 *********** 
 */		
  
  function getDownloadStatus($itemId)
	{
		$this->db->select('dwnStatus');	
		$this->db->from('SalesItemDownload');			
		$this->db->where('itemId',$itemId);	
		$query = $this->db->get();
		//echo $CI->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->row()->dwnStatus;
		}else
		{ $result = 0;	}
		return $result;
	}
	
	
/*
 ***********
 * This functino return download period 
 *********** 
 */		
  
  function getDownloadPeriod($itemId)
	{
		$this->db->select('dwnDate, dwnMaxday');	
		$this->db->from('SalesItemDownload');			
		$this->db->where('itemId',$itemId);	
		$query = $this->db->get();
		//echo $CI->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->row();
		}else
		{ $result = 0;	}
		return $result;
	}	
	
/*
 ***********
 * This function is used to get item amount by itemId
 *********** 
 */		
  
  function getItemPrice($itemId)
	{
		$this->db->select('basePrice');	
		$this->db->from('UserMembershipItem');			
		$this->db->where('parentContId',$itemId);	
		$query = $this->db->get();
		//echo $CI->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->row()->basePrice;
		}else
		{ $result = 0;	}
		return $result;
	}	
	
/*
 ***********
 * This function is used to get item container size by itemId
 *********** 
 */		
  
  function get_Item_Size($itemId)
	{
		$this->db->select('size');	
		$this->db->from('UserMembershipItem');			
		$this->db->where('parentContId',$itemId);	
		$query = $this->db->get();
		//echo $CI->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->row()->size;
		}else
		{ $result = 0;	}
		return $result;
	}		
	
	//Function to get ticket event transaction listing
	function ticketEventListing($entityId='')
	{
		$this->db->select('*');
		$this->db->from('TicketTransectionLog');
		if(!empty($entityId)){
			$this->db->where('entityId',$entityId);
		}
		$this->db->order_by("ticketNumber", "ASC"); 
		$query =  $this->db->get();	
		if ($query->num_rows()>0)
		{
			return $query->result();
		}else{
			return 0;
		}
	}
	
	function eventTicketSession($entityId=0)
	{
		$this->db->distinct();
		$this->db->select('sessionId,date');
		$this->db->from('TicketTransectionLog');
		$this->db->order_by("date", "ASC"); 
		$query =  $this->db->get();	
		if ($query->num_rows()>0)
		{
			return $query->result();
		}else{
			return 0;
		}
	}
	
	
	/* Function to get invoice event data */
	function ticket_invoice_data($invoiceId=0){
	
		$this->db->select('*');
		$this->db->from('TicketTransectionLog');
		$this->db->where('invoiceId',$invoiceId);
		$this->db->order_by("ticketNumber", "ASC"); 
		$query =  $this->db->get();	
	    //  echo $this->db->last_query();
		if ($query->num_rows()>0)
		{
			return $query->result();
		}else{
			return 0;
		}
	}  	 
	
	
	/*
	 *************************************** 
	 * This function use for player module for view padi view
	 *************************************** 
	 */ 
	 
	 
	 function getSectionId($projectId)
		{
			$whereArr = array('projId'=>$projectId);
			$this->db->select('projectType');	
			$this->db->from('TDS_Project');	
			$this->db->where($whereArr);
			$query = $this->db->get();
			$result['get_num_rows'] = $query->num_rows();
			$result['get_result'] = $query->row();
			return $result;
		}
	
	/*
	 *************************************** 
	 * This function use for player module for view padi view
	 *************************************** 
	 */ 
	 
	 
	 function get_InvoiceId_Data($transactionId,$type=0)
		{
			$whereArr = array('receiverTransactionId'=>$transactionId,'type'=>$type);
			$this->db->select('id');	
			$this->db->from('TDS_SalesOrderInvoice');	
			$this->db->where($whereArr);
			$query = $this->db->get();
			$result['get_num_rows'] = $query->num_rows();
			$result['get_result'] = $query->row();
			return $result;
		}
	
	
	/*
	 *************************************** 
	 * This function used to get Country name by CountryId
	 *************************************** 
	 */ 
	
	 
	function userCountryName($id){
		 
		$this->db->select('countryName,countryGroup');	
		$this->db->from('MasterCountry');			
		$this->db->where('countryId',$id);	
		$query = $this->db->get();
		$result['get_num_rows'] = $query->num_rows();
		$result['get_result'] = $query->row();
		return $result;
	} 
	
	
	function getEventLaunchSession($tbl='', $selectedField='', $where='', $joinWithSessionTable=false){
		$result = false;
		
		if($tbl !='' && $selectedField !='' && is_array($where) && count($where) > 0 ){
			$this->db->select($selectedField);	
			$this->db->from($tbl);
			
			if($joinWithSessionTable){
				$this->db->join("EventSessions", "EventSessions.launchEventId = LaunchEvent.LaunchEventId");
			}
				
			$this->db->where($where);	
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
		
	} 
	function getTicketPurchaseUser($projId=0, $sellerInfolike1=false, $sellerInfolike2=false){
		$result = false;
		
		$this->db->select('SalesOrderItem.sellerId,SalesOrderItem.sellerInfo');	
		$this->db->select('UserAuth.tdsUid,UserAuth.email,UserAuth.active,UserAuth.banned');	
		$this->db->select('UserProfile.firstName,UserProfile.lastName');	
		
		$this->db->from('SalesOrderItem');
		$this->db->join("SalesOrder", "SalesOrder.ordId = SalesOrderItem.ordId");
		$this->db->join("UserAuth", "UserAuth.tdsUid = SalesOrder.customerUid");
		$this->db->join("UserProfile", "UserProfile.tdsUid = SalesOrder.customerUid");
		
		$this->db->where("SalesOrderItem.purchaseType",5);
		if($projId > 0 ){
			$this->db->where("SalesOrderItem.projId",$projId);	
		}
		if($sellerInfolike1){
			$this->db->like('sellerInfo', $sellerInfolike1);
		}
		if($sellerInfolike2){
			$this->db->like('sellerInfo', $sellerInfolike2);
		}
		$this->db->group_by(array('UserAuth.tdsUid', 'UserAuth.email', 'UserProfile.firstName', 'UserProfile.lastName', 'SalesOrderItem.sellerId', 'SalesOrderItem.sellerInfo')); 
		
		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
		
	}
	
	
	/*Function to insert view count in db*/
	function add_project_view ($viewData)
	{
		$this->db->insert('TDS_LogViews',$viewData);
		return $this->db->insert_id();
	}
	
	/*
	 * Function to get project details
	 * */
	function getProjectDetails($tableName,$elementId,$projectId=0,$fileFName,$elementFName,$projectFName)
	{
		$CI =&get_instance();
		$this->db->select($fileFName);	
		$this->db->from($tableName);		
		$this->db->where($elementFName,$elementId);	
		if((isset($projectFName)) && (isset($projectId)) && (!empty($projectFName))){
			$this->db->where($projectFName,$projectId);	
		}
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->row()->$fileFName;
		}else
		{ $result = 0;	}
		return $result;
	}
	
 /* Count Other Projects of User */
 
 public function showProjectsCount($userId=2){
		
		$tableShowProject=$this->db->dbprefix($this->tableShowProject);		
		$search=$this->db->dbprefix('search');
		
		$where['receiverid']=$userId;
		$where['status']='t';
		$where['search.ispublished']='t';		
		
		$this->db->select("COUNT(*)");
		
		$this->db->from($this->tableShowProject);		
		$this->db->join('search', 'search.entityid = '.$this->tableShowProject.'.entityid AND "'.$search.'"."elementid"="'.$tableShowProject.'"."elementid" ', 'left');		
		$this->db->where($where);
		$this->db->where('search.id >', 0);				
		$this->db->group_by("search.elementid",'DESC');
				
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if($query->num_rows() > 0){
			$result = $result= $query->row()->count;
		}else
		{ $result = 0;	}
		return $result;
		
	}	
	
	/*
	 * Get Media data
	 */
	public function getMediaDetails($userId=0,$projectType='',$projectId=0,$elementTbl='',$orderby='order',$order='ASC'){
		
	}
	
	function getContinentWiseCountry(){
		$where=array($this->tableMasterCountry.'.status'=>1,$this->tblContinent.'.status'=>'t');
		$this->db->select('countryName,countryId,continentId,continent');
		$this->db->from($this->tableMasterCountry);
		$this->db->join($this->tblContinent, $this->tblContinent.".id = ".$this->tableMasterCountry.".continentId");
		$this->db->where($where);
		$this->db->order_by('continent', 'ASC');
		$this->db->order_by('countryName', 'ASC');
		$query 	= $this->db->get();
		$res = $query->result();
		return $res;
	}
	
	
	/*
	 ************************** 
	 * This function is used to show capture image of uploaded video
	 **************************  
	 */ 
	
	function getProjectFilePathDetails($elementId,$projectId)
	{
		$where=array($this->tblFvElement.'.elementId'=>$elementId,$this->tblFvElement.'.projId'=>$projectId);
		$this->db->select('imagePath,fileName,filePath');
		$this->db->from($this->tblFvElement);
		$this->db->join($this->tableMediaFile, $this->tblFvElement.".fileId = ".$this->tableMediaFile.".fileId");
		$this->db->where($where);
		$query 	= $this->db->get();
		$res = $query->row();
		return $res;
	}
	

	
	/*
	 ************************** 
	 * This function is used get element data by project id and entityId
	 **************************  
	 */ 
	
	function getProjectElementImage($projId,$entityId,$elementId)
	{
		$tableName = getMasterTableName($entityId);
		$elementTableName= $tableName[0];
		if($projId!=0){
			$where=array($elementTableName.'.projId'=>$projId,'isProjectImage'=>'t');
		}
		if($elementId!=0){
			$where=array($elementTableName.'.elementId'=>$elementId);
		}
		
		$this->db->select('imagePath,fileName,filePath,isExternal');
		$this->db->from($elementTableName);
		$this->db->join($this->tableMediaFile, $elementTableName.".fileId = ".$this->tableMediaFile.".fileId","left");
		$this->db->where($where);
		$query 	= $this->db->get();
		$res = $query->row();
		return $res;
	}
	
	
/* LOG VISITOR ADD IP AND REMOVE AADED BY AMIT */
	
	function checkIpAddr($iPinfo){

		$this->db->select('tdsUid');
		$this->db->from($this->tableUserAuth);
		$this->db->where_in('last_ip',$this->input->ip_address());	
		$this->db->limit(1)	; 	
		$query = $this->db->get();
		
		$result = $query->result_array();		
		if($result){
			   $this->removeIpAddrLog();
		  }else{
			   $this->addIpAddrLog($iPinfo);
		  }		 		
	  }
		
	function addIpAddrLog($iPinfo){		
	 $currentDate = date("Y-m-d");
	 $res=$this->getDataFromTabel('LogVisitors', 'id',  array('ip_address'=>$this->input->ip_address(),'date'=>$currentDate),'','','',1);
	 $iPinfo = json_decode($iPinfo);
	 	
	 if(!isset($res[0]->id) && count($iPinfo)>0 ){	 
		
		$addIpData = array(
		                   'ip_address'=>$iPinfo->ipAddress,
		                   'country'=>$iPinfo->countryName,
		                   'region'=>$iPinfo->regionName,
		                   'city'=>$iPinfo->cityName,
		                   'latitude'=>$iPinfo->latitude,
		                   'longitude'=>$iPinfo->longitude
		                   );
		                   
		$query = $this->db->insert($this->tableLogVisitors, $addIpData);			
		return true;		
	   }
	   return true;	
	}  
	
	
	function removeIpAddrLog(){
	  $currentDate = date("Y-m-d");
	  $this->deleteRowFromTabel('LogVisitors',array('ip_address'=>$this->input->ip_address(),'date'=>$currentDate));	
	  return true;	
	 }
	 
	 
	function checkPieceAlreadyExit($projId,$elementTableName){
		$where=array($elementTableName.'.projId'=>$projId,$this->tableMediaEelementType.".default"=>'f');
		$this->db->select('elementId');
		$this->db->from($elementTableName);
		$this->db->join($this->tableMediaEelementType, $elementTableName.".mediaTypeId = ".$this->tableMediaEelementType.".elementTypeId");
		$this->db->where($where);
		$query 	= $this->db->get();
		$res = $query->num_rows();
		return $res;
	} 
	
	/*
	 ************************** 
	 * This function is used to get events primary image
	 **************************  
	 */ 
	
	function getEventPrimaryImage($projId,$fieldName,$entityId)
	{
		$where=array($this->tableEventMedia.$fieldName=>$projId,'isMain'=>'t');
		$this->db->select('fileName,filePath');
		$this->db->from($this->tableEventMedia);
		$this->db->join($this->tableMediaFile, $this->tableEventMedia.".fileId = ".$this->tableMediaFile.".fileId","left");
		$this->db->where($where);
		$query 	= $this->db->get();
		$res = $query->row();
		return $res;
	}
	
	
	// private $tableMeetingPoint	= 'MeetingPoint';
	// private $tableEventSessions	= 'EventSessions';
	
	/*
	 ************************** 
	 * This function is used to get session count by userId
	 **************************  
	 */ 
	
	function userSignInSessionCount($userId)
	{
		$where=array($this->tableMeetingPoint.'.user_id'=>$userId,$this->tableEventSessions.'.date > '=>date('Y-m-d'));
		$this->db->select('id');
		$this->db->from($this->tableMeetingPoint);
		$this->db->join($this->tableEventSessions, $this->tableEventSessions.".sessionId = ".$this->tableMeetingPoint.".session_id","left");
		$this->db->where($where);
		$query 	= $this->db->get();
		$res = $query->num_rows();
		//	echo $this->db->last_query();die();
		return $res;
	}
	
	
	/*
	 ************************** 
	 * This function is used to get social sites details
	 **************************  
	 */
	function getProfileSocialMediaLinks($entityId,$workProfileId,$socialLink=0,$linkType=0)
	{
		$this->db->select('socialLink,profileSocialLinkType,position');
		$this->db->from($this->tableProfileSocialLink);			
		$this->db->where('entityId',$entityId);
		$this->db->where('workProfileId',$workProfileId);
		if(isset($socialLink) && !empty($socialLink)) {
			$this->db->where('socialLink',$socialLink);
		}
		if(isset($linkType) && !empty($linkType)) {
			$this->db->where('profileSocialLinkType',$linkType);
		}
		$this->db->order_by('position','asc');
		$query 	= $this->db->get();
		$res = $query->result();
		return $res;
	}
	
	/*
	 ************************** 
	 * This function is used to add social site 
	 **************************  
	 */
	function addSocialSitesCopy($fieldValues) {
		$addInfoResult = $this->db->insert($this->tableProfileSocialLink, $fieldValues);//Insert new record for posts
		$ID = $this->db->insert_id();
		return $ID;	//inserted Id 
	}
    
    
    //----------------------------------------------------------------------
    
    /**
    * @access: public
    * @description: This method is use to get associative creatives list by entity and element id
    * @param: $entityId
    * @param: $elementId
    * @auther: lokendra meena
    */ 
    
    public function associativecreativeslist($entityId,$elementId){
        $this->db->select($this->tableAssociativeCreatives.'.*');
        $this->db->select($this->tableUserAuth.'.username');
        $this->db->select($this->tableUserShowcase.'.optionAreaName,'.$this->tableUserShowcase.'.profileImageName,'.$this->tableUserShowcase.'.stockImageId,'.$this->tableUserShowcase.'.creative,'.$this->tableUserShowcase.'.associatedProfessional,'.$this->tableUserShowcase.'.enterprise,'.$this->tableUserShowcase.'.enterpriseName');
        $this->db->select($this->tableStockImages.'.stockImgPath,'.$this->tableStockImages.'.stockFilename');
        $this->db->from($this->tableAssociativeCreatives);
        $this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = '.$this->tableAssociativeCreatives.'.tdsUid','left');
        $this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableAssociativeCreatives.".tdsUid", 'left');
        $this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->tableUserShowcase.".stockImageId", 'left');
        $this->db->where('entityId',$entityId);
        $this->db->where('elementId',$elementId);
        $this->db->where('crtStatus','t');
        $this->db->order_by('crtId','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
	
    
    /*
     ************************** 
     * This function is used to get genre data as per cat 
     **************************  
     */
    function getMediaGenerList($catId=0){
         
        $this->db->from('Genre');
        $this->db->where('catId', $catId);
        $this->db->where('status', 't');
        $this->db->order_by('Genre');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getPRmaterial($table='',$where='',$orderBy='', $joinTable='',$joinOn='')
	{
		$result =false;
        if($table !='' && is_array($where)){
            $this->db->select($table.'.*');
            if($joinTable != ''){
                $this->db->select($joinTable.'.title as prtitle,'.$joinTable.'.imagePath');
                $this->db->join($joinTable, $joinTable.".elementId = ".$table.".$joinOn","left");
            }
            $this->db->from($table);
            $this->db->where($where);
            if($orderBy != ''){
                $this->db->order_by($table.'.'.$orderBy, 'DESC');
            }
            $query 	= $this->db->get();
            $result=$query->result_array();
        }
		return $result;
	}
    
    public function getShortLink($longurl='',$userId=0) {        
       if(!empty($longurl)){     	
              $this->db->select('short_url');
              $this->db->from('Shortlinks');
              $this->db->where(array('url'=>$longurl));
              $this->db->where(array('date >='=>date('Y-m-d')));
              $this->db->order_by('date','DESC');
              $this->db->limit(1);
              $query 	= $this->db->get();
              if($query){
                 $result=$query->result_array();
                 if(isset($result[0]['short_url'])){
                     return $shortlink = base_url(lang().'/?url='.$result[0]['short_url']);	
                 }
              }
              
              $short = random_string('alnum', 8).random_string('alnum', 8);					   
              $userIP = $_SERVER['REMOTE_ADDR'];
              
              $data = array(
                    'user_id' => $userId,
                    'short_url' => $short,
                    'user_ip' => $userIP,
                    'url' => $longurl,                
              );        

              $this->db->insert('Shortlinks', $data);				
              return $shortlink = base_url(lang().'/?url='.$short);							
        }  
     }
     
    //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get project's pickup data data 
    * @return array
    */ 
    public function getToadUsersData($profileType=0,$keyword='',$firstName='',$lastName='',$limit=0,$offset=0) {
        
        $this->db->select($this->tableUserShowcase.'.*');
        $this->db->select($this->tableUserProfile.'.countryId');
        $this->db->select($this->tableUserAuth.'.active');
        $this->db->from($this->tableUserShowcase);
        $this->db->join($this->tableUserProfile, $this->tableUserProfile.'.tdsUid = '.$this->tableUserShowcase.'.tdsUid');
        $this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = '.$this->tableUserShowcase.'.tdsUid');
        // get result on the basis of profile type
        if($profileType == 6) {
            $this->db->where($this->tableUserShowcase.'.creative', 't');
        } else if($profileType == 7) {
            $this->db->where($this->tableUserShowcase.'.associatedProfessional', 't');
        } else if($profileType == 8) {
            $this->db->where($this->tableUserShowcase.'.enterprise', 't');
        }
        // get result by the keayword if exists 
        if(!empty($keyword)) {
            $keyword = explode(' ',$keyword);
            $firstName = pg_escape_string(trim(strtolower($keyword[0])));
            $this->db->like('LOWER("TDS_'.$this->tableUserShowcase.'"."firstName")', $firstName);
            if(!empty($keyword[1])) {
                $lastName = pg_escape_string(trim(strtolower($keyword[1])));
                $this->db->like('LOWER("TDS_'.$this->tableUserShowcase.'"."lastName")', $lastName);
            }
        }

        $this->db->where($this->tableUserShowcase.'.isBlocked', 'f');
        $this->db->where($this->tableUserAuth.'.active', 1);
        if(!empty($limit) && !empty($offset)) {
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
       
        $query = $this->db->get();
        return $query->result(); 
    }
    
    //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get user's showcase details
    * @return array
    */ 
    function getUserShowcaseDetails($showcaseId=0) {
        // get projects log summary
        $showcaseEntityId = getMasterTableRecord('UserShowcase');
		$this->db->select($this->tableUserShowcase.'.*');
		$this->db->select($this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.ratingAvg,'.$this->tableLogSummary.'.reviewCount');
		$this->db->from($this->tableUserShowcase);
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->tableUserShowcase.'.showcaseId');
		$this->db->where($this->tableUserShowcase.'.showcaseId', $showcaseId);
        $this->db->where($this->tableLogSummary.'.entityId', $showcaseEntityId);
		$query = $this->db->get();
		if ($query->num_rows()) return $query->result();
		return false;
	}
    
    //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get user's details for tmail
    * @return array
    */ 
    function gettmailuserdata($userId=0) {
        
		$this->db->select($this->tableUserAuth.'.email');
		$this->db->select($this->tableUserShowcase.'.firstName,'.$this->tableUserShowcase.'.lastName');
		$this->db->from($this->tableUserAuth);
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.'.tdsUid = '.$this->tableUserAuth.'.tdsUid');
		$this->db->where($this->tableUserAuth.'.tdsUid', $userId);
		$query = $this->db->get();
		if ($query->num_rows()) return $query->result();
		return false;
	}		

    
    function getUsersReview ($entityId,$projectElementId,$offSet=0,$perPage=0) {
		$this->db->select($this->tableReviewsElement.'.*, '.$this->tableUserAuth.'.username');		
		$this->db->select($this->tableUserShowcase.'.creative,'.$this->tableUserShowcase.'.associatedProfessional,'.$this->tableUserShowcase.'.enterprise,'.$this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.fans,'.$this->tableUserShowcase.'.profileImageName,'.$this->tableUserShowcase.'.stockImageId,'.$this->tableStockImages.'.stockImgPath,'.$this->tableStockImages.'.stockFilename');		
		$this->db->select($this->tableUserProfile.'.firstName,'.$this->tableUserProfile.'.lastName');	
		$this->db->from($this->tableReviewsElement);
		$this->db->join($this->tableProject, $this->tableProject.".projId = ".$this->tableReviewsElement.".projId", 'left');
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableReviewsElement.".userId", 'left');
		$this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->tableUserShowcase.".stockImageId", 'left');
        $this->db->join($this->tableUserProfile, $this->tableUserProfile.".tdsUid = ".$this->tableReviewsElement.".userId", 'left');
		$this->db->join($this->tableUserAuth, $this->tableUserAuth.".tdsUid = ".$this->tableReviewsElement.".userId", 'left');
		
        $this->db->where($this->tableProject.'.projectType','reviews');
		$this->db->where($this->tableReviewsElement.'.entityId',$entityId); 
		$this->db->where($this->tableReviewsElement.'.projectElementId',$projectElementId);
        $this->db->where($this->tableProject.'.isPublished','t');
		$this->db->where($this->tableReviewsElement.'.isPublished','t');
		$this->db->order_by($this->tableReviewsElement.'.elementId','desc'); 
		
		if($offSet>0 || $perPage>0){
			$this->db->limit($perPage,$offSet);
		}	
		$query = $this->db->get();
		return $result=$query->result();		 
	 }
     
    //---------------------------------------------------------------------
     
    /*
    *  @access: public
    *  @description: This method is use to get user social media data
    *  @auther: lokendra meena
    *  @return: void
    */  
    
    public function getSocialMediaLinks($where=''){		
        $result = false;
        if(!empty($where)){
            $this->db->select('psl.*');
            $this->db->select('smi.profileSocialMediaName,smi.profileSocialMediaPath');
            $this->db->from($this->socialLinkTable.' as psl');
            $this->db->join($this->socialMediaIcon.' as smi','smi.profileSocialMediaId = psl.profileSocialLinkType');
            $this->db->where($where);
            $result = $this->db->get()->result();
        }
        return $result;
	} 

/* END  */
	
}
