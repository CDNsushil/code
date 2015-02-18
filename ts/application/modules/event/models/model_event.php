<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

class model_event extends CI_Model {
private $userId = NULL;
private $eventTableName = 'Events';
private $launchEventTableName = 'LaunchEvent';
private $eventMediaTableName = 'EventMedia';
private $eventSessionTableName = 'EventSessions';
private $MasterCountry	= 'MasterCountry';
private $MasterIndustry = 'MasterIndustry';
private $MasterRating = 'MasterRating';
private $MTC = 'MasterTicketCategories';
private $TPS = 'TicketPriceSchedule';
private $Tickets = 'Tickets';
private $MasterLang = 'MasterLang';
private $UserShowcase	= 'UserShowcase';
private $UserProfile	= 'UserProfile';
private $tableLogSummary = 'LogSummary';
private $tableUserContainer	= 'UserContainer';
private $tableUserAuth = 'UserAuth';
private $LogCrave = 'LogCrave';
private $meetingPoint = 'MeetingPoint';
private $MediaFile = 'MediaFile';
private $tableTicketTransectionLog	= 'TicketTransectionLog';

	/**
	 * Constructor
	**/
	function __construct()
	{
		parent::__construct();
		// My own constructor code
		$this->userId = isLoginUser();
		// $this->userId= '2';
	}
	
	//Insert Event Record
	function insertEvent($insertData){
		
		$insertData['tdsUid'] = $this->userId;
		unset($insertData['EventId']);
		$insertData['EventDateCreated'] = date("Y-m-d H:i:s");	
		$insertData['EventDateModified'] = date("Y-m-d H:i:s");
		$query = $this->db->insert($this->eventTableName, $insertData);	
		$ID=$this->db->insert_id();
				
		return $ID;
	}
	
	//Update Event record on the basis of eventId
	function updateEvent($insertData,$eventId)
	{
		$this->db->where('EventId',$eventId);
		$insertData['tdsUid'] = $this->userId;
		$insertData['EventDateModified'] = date("Y-m-d H:i:s");
		//echo '<pre />';print_r($insertData);die;
		$query = $this->db->update($this->eventTableName, $insertData);			
	}
	
	//Get event List according to natureId for left section
	function eventLeftList($natureId=1,$userId=0,$isArchive='f')
	{
		$userId=$userId>0?$userId:$this->userId;	
		$event['eventNavData'] = array();	
		if($natureId!=3){
			$eventFields = "EventId as compeventid,NatureId,Title,EventDateCreated,EventDateModified";
			$orderBy = 'EventDateModified';
			$order = 'desc';
			$this->db->select($eventFields);
			$this->db->from($this->eventTableName);	
			$this->db->where('NatureId',$natureId);
			$this->db->where('tdsUid',$userId);
			$this->db->where('EventArchive', $isArchive);
			$this->db->where('isDeleted', 0);
			$this->db->order_by('EventDateCreated', 'desc');
		}
		else{
			$eventFields = "LaunchEventId as compeventid,NatureId,Title,LaunchDate,LaunchEventModified";
			$orderBy = 'LaunchEventModified';
			$order = 'desc';
			$this->db->select($eventFields);
			$this->db->from($this->launchEventTableName);	
			$this->db->where('NatureId',$natureId);
			$this->db->where('tdsUid',$userId);
			$this->db->where('isArchive', $isArchive);
			$this->db->where('isDeleted', 0);
			$this->db->order_by('LaunchEventModified', 'desc');
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		
		if($query->result_array())
			$event['eventNavData'] =	$query->result_array();		
		
		return $event['eventNavData'];
	}
	
	//Event Records List
	function eventList($natureId='',$userId=0, $isPublished='',$isArchive='f', $offset=0,$limit=0)
	{
		$userId=$userId>0?$userId:$this->userId;		
		$event['data'] = array();	
		if($natureId != 3)
		{
			$field = 'EventId,'.$this->eventTableName.'.*,'.$this->eventTableName.'.tdsUid as "tdsUid",filePath,fileName';
			$fieldmediaType = 'mediaType';
			//$orderBy = 'StartDate';
			$orderBy = 'EventDateModified';
			$order = 'DESC';
			$currentDateTime= currntDateTime();
			$eventTableName = $this->db->dbprefix($this->eventTableName);
			
			$this->db->select($field);
			$this->db->select($this->MasterCountry.'.countryName');
			$this->db->select($this->MasterIndustry.'.IndustryName');
			$this->db->select($this->tableUserContainer.'.*');
			$this->db->from($this->eventTableName);				
			
			$this->db->join('MediaFile','MediaFile.fileId = '.$this->eventTableName.'.FileId', 'left');
			$this->db->join($this->MasterIndustry, $this->MasterIndustry.'.IndustryId = CAST("'.$eventTableName.'"."Industry" as int)', 'left');
			$this->db->join($this->MasterCountry, $this->MasterCountry.'.countryId = CAST("'.$eventTableName.'"."Country" as int)', 'left');
			$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->eventTableName.".userContainerId", 'left');
			
			$this->db->where($this->eventTableName.'.tdsUid', $userId);
			$this->db->where($this->eventTableName.'.EventArchive', $isArchive);
			$this->db->where($this->eventTableName.'.isDeleted', 0);
			
			if(!empty($isPublished)){
				$this->db->where_in('isPublished',$isPublished);
			}
			
			if($natureId) $this->db->where('NatureId',$natureId);			
					
			 if(!empty($orderBy)){  
				$this->db->order_by($orderBy, $order);
			 }
			 
			 if($limit > 0 || $offset > 0){
				$this->db->limit($limit,$offset);
			 }

			 $query = $this->db->get();
			 if($query->result_array()){
				$event['eventData'] =	$query->result_array();
			 }
			//echo $this->db->last_query();die;
		}
		else
		{	 
			$field = 'LaunchEventId,NatureId,Title,EventType,OneLineDescription,Tagwords,LaunchDate,Time,Description,Image,URL,Address,City,State,Country,Zip,Type,isPublished,EventId';
			$fieldmediaType = 'mediaType';
		   
			$order = 'desc';
			$limit = 0;
			
			$this->db->select($field);
			$this->db->select($this->tableUserContainer.'.*');
			$this->db->from($this->launchEventTableName);
			$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->launchEventTableName.".userContainerId", 'left');
			
			//$this->db->join($this->eventMediaTableName, $this->eventMediaTableName.'.launchEventId = '.$this->launchEventTableName.'.LaunchEventId', 'left');
			//$this->db->where('isMain', 't');
				
			$this->db->where_in('EventId',NULL);
			$this->db->where($this->launchEventTableName.'.isDeleted', 0);
			
			if(!empty($isPublished)){
				//if($isPublished == 'f') $isPublished = 'f,Null';
				$this->db->where_in('isPublished',$isPublished);
				//if($isPublished == 't')
				//	$this->db->where("(\"StartDate\" > '".$currentDateTime."' OR \"FinishDate\" > '".$currentDateTime."')", null, false);
			}		 
			if($limit > 0 || $offset > 0){
				$this->db->limit($limit,$offset);
			}
			
			 $querydatalaunch = $this->db->get();
			 
			 if($querydatalaunch->result_array()){
				$event['launchEventData'] =	$querydatalaunch->result_array();
			 }			
		}
		
		if(!isset($event['eventData']) && (isset($event['launchEventData']) && count($event['launchEventData'])>0))
			$event['data'] = $event['launchEventData'];
			
		if((isset($event['eventData']) && count($event['eventData'])>0) && !isset($event['launchEventData']))
			$event['data'] = $event['eventData'];
			
		if((isset($event['eventData']) && count($event['eventData'])>0) && (isset($event['launchEventData']) && count($event['launchEventData'])>0))
			$event['data'] = array_merge($event['eventData'], $event['launchEventData']);
		
		//echo '<pre />';print_r($event['data']);die;
		//echo $this->db->last_query();die;
		
		return $event['data'];
			
	}
	
	function getEventToUpdate($eventId,$natureId=0,$isPublished='',$userId=0, $isArchive='f')
	{		
		 $field = 'EventId,NatureId,'.$this->eventTableName.'.isExpired as eventexpired,'.$this->eventTableName.'.isBlocked,Title,EventType,OneLineDescription,Tagwords,Industry,Genre,OtherGenre,Language,Type,StartDate,FinishDate,Time,Category,Description,Rating,CompanyName,Image,URL,Address,Address2,City,State,Country,Zip,isPublished,filePath,fileName,FileId,OrgURL,OrgAddress,OrgAddress2,OrgCity,OrgState,OrgCountry,OrgZip,OrgEmail,OrgPhone,EventDateCreated,VenueName,VenuePhone,VenueEmail,OrgName,FileId,EventDateCreated';	 	
		 $whereField = 'EventId';
		 $whereValue = $eventId;
		 $orderBy = '';
		 $limit = 1;
		
		 $this->db->select($field);
		 $this->db->select($this->tableUserContainer.'.*');
		
		 $this->db->from($this->eventTableName);
		 $this->db->join('MediaFile','MediaFile.fileId = '.$this->eventTableName.'.FileId', 'left');
		 $this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->eventTableName.".userContainerId", 'left');
			
		 if($whereValue>0){
			 if(!empty($whereField)){
				 $this->db->where($whereField, $whereValue);
			 }
		 }
		 
		 if(!empty($isPublished)) $this->db->where_in('isPublished',$isPublished);
		 
		 if($natureId>0) $this->db->where('NatureId', $natureId);	
		 
		 if($userId>0)	$this->db->where($this->eventTableName.'.tdsUid', $userId);	
		 
		 $this->db->where($this->eventTableName.'.EventArchive', $isArchive);
		 $this->db->where($this->eventTableName.'.isDeleted', 0);
		 
		 $this->db->order_by('EventDateCreated', 'desc');
		 
		 if($limit >0)	$this->db->limit($limit);

		 $query = $this->db->get();
		
		 if($query->result_array()){
			return 	$query->result_array();
		 }
		 
	}
	
	function getLaunchEvent($launchEventId=0,$natureId=0,$userId=0,$isPublished='',$eventId=0,$isArchive='f')
	{
		$currentDateTime= currntDateTime();
		$launchEventTableName = $this->db->dbprefix($this->launchEventTableName);
		
		$field = 'LaunchEventId,'.$this->launchEventTableName.'.isBlocked,'.$this->launchEventTableName.'.isExpired as launchexpired,Title,OneLineDescription,Tagwords,Time,Genre,Rating,LaunchDate,Description,NatureId,isPublished,Industry,Language,LaunchEventCreated,LaunchEventModified,OrgName,OrgAddress2,OrgURL,OrgAddress,OrgCity,OrgState,OrgCountry,OrgZip,OrgEmail,OrgPhone,Type,OtherGenre,EventId,'.$this->launchEventTableName.'.tdsUid as "tdsUid", FileId,MediaFile.filePath,MediaFile.fileName';
		$fieldmediaType = 'LaunchDate';
		$order = 'ASC';

		$limit = 0;
		$eventMediaTableName = $this->db->dbprefix($this->eventMediaTableName);
		
		$this->db->select($field);
		$this->db->select($this->tableUserContainer.'.*');
		
		$this->db->from($this->launchEventTableName);
		$this->db->join('MediaFile','MediaFile.fileId = '.$this->launchEventTableName.'.FileId', 'left');
		$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->launchEventTableName.".userContainerId", 'left');
				
		if(isset($natureId) && $natureId>0) $this->db->where('NatureId', $natureId);	 
		if($eventId>0) $this->db->where('EventId', $eventId);	 
		if($launchEventId>0) $this->db->where('LaunchEventId', $launchEventId);	 
		if($userId>0) $this->db->where($this->launchEventTableName.'.tdsUid', $userId);	 
		if(!empty($isPublished)) $this->db->where($this->launchEventTableName.'.isPublished', $isPublished);
		$this->db->where($this->launchEventTableName.'.isArchive', $isArchive);	
		
		 $this->db->where($this->launchEventTableName.'.isDeleted', 0); 
		 
		 $this->db->order_by('LaunchEventModified', 'desc');
		 
		 if($limit >0){
			$this->db->limit($limit);
		 }
		
		 $querydatalaunch = $this->db->get();
		 
		 if($querydatalaunch->result_array()){
			return $querydatalaunch->result_array();	 
		 }
		// echo '<pre />';print_r($querydatalaunch->result_array());
	}	
	
	function eventPromotionMediaList($eventId,$mediaType)
	{
		$table = $this->eventMediaTableName;
		$whereField = 'eventId';
 		$whereValue = $eventId;
		$fieldmediaType = 'mediaType';
		$orderBy = 'mediaId';
		$limit = 0;	
		
		$this->db->from($table);
		$this->db->join('MediaFile','MediaFile.fileId = EventMedia.fileId');
		$this->db->where($whereField,$whereValue);
		$this->db->where($fieldmediaType,$mediaType);				
		
		 if(!empty($orderBy)){  
			$this->db->order_by($orderBy, 'desc');
		 }
		 if($limit >0){
			$this->db->limit($limit);
		 }

		$eventMediaData = $this->db->get();
		return $eventMediaData->result();
	}

	function deleteEvent($eventId,$tableName,$primaryKey)
	{
		 //	echo 'eventId'.$eventId;die;
		 $delQuery = 'delete from "'. $this->db->dbprefix($tableName).'" where "'.$primaryKey.'" ='.$eventId.'';	 
		 $this->deletePromoMediaEventRelated($eventId,$primaryKey);
		 if(strcmp($primaryKey,'EventId') == 0)
		 $this->deleteLaunchEvent($eventId,$primaryKey);		
		 $this->db->query($delQuery);
	}
	
	function deletePromoMediaEventRelated($eventId,$primaryKey)
	{		
	   $tables = array($this->eventMediaTableName);				
	   $this->db->where(lcfirst($primaryKey),$eventId);		
	   $this->db->delete($this->eventMediaTableName);
	}
	
	function deleteLaunchEvent($eventId,$primaryKey)
	{
	  $delQuery = 'delete from "'. $this->db->dbprefix($this->launchEventTableName).'" where "'.$primaryKey.'" ='.$eventId.'';	 
	  $this->db->query($delQuery);
	}	
	
	/** 
		* Publishing/Unpublishing the event 
		* @access	public
		* @params $eventId
		* 		
		* redirect
	**/
	function publishItem($entityId,$tableName,$primaryKey)
	{			
		$field = $primaryKey;				
		$updatePost['isPublished'] = "FALSE";
		echo $togglePublishUpdateQuery ='update "'. $this->db->dbprefix($tableName).'" SET "isPublished" =( CASE
							 WHEN ("isPublished" =  true) THEN false ELSE true END ) WHERE "'.$field.'" ='.$entityId.'';
		
		$this->db->query($togglePublishUpdateQuery);		
	}
	
	
	/**
		* Display the Post preview 
		* @access	public
		* @params $postId
			
		* return array
	**/
	function previewEvent($eventId,$flag=0){
		
		if($flag==0){
			$whereField = 'EventId';
			$field = 'EventId,NatureId,EventType,Title,OneLineDescription,Tagwords,Industry,Genre,OtherGenre,Language,Type,StartDate,FinishDate,Time,Category,Description,Rating,CompanyName,Image,URL,Address,City,State,Country,Zip,isPublished';	 	
			$this->db->select($field);	
			$this->db->from($this->eventTableName);	
			$this->db->where($whereField, $eventId);
			$this->db->where($this->eventTableName.'.isDeleted', 0); 
		}else{
			$whereField = 'LaunchEventId';
			$field = 'EventId,NatureId,EventType,Title,OneLineDescription,Tagwords,Type,Time,Description,Image,URL,Address,City,State,Country,Zip';	 	
			$this->db->select($field);	
			$this->db->from($this->launchEventTableName);	
			$this->db->where($whereField, $eventId);
			 $this->db->where($this->launchEventTableName.'.isDeleted', 0); 
		}	
		$data['previewEventQuery'] = $this->db->get(); 
		return $data['previewEventQuery']->result_array() ;
	
	}
	
	function getLaunchEventFullDetails($launchEventId=0,$userId=0,$isPublished='',$cache=0)
	{
		$launchEventTableName = $this->db->dbprefix($this->launchEventTableName);
		$eventSessionTableName = $this->db->dbprefix($this->eventSessionTableName);
		$field = $this->launchEventTableName.'.*';
		
		$this->db->select($field);
		$this->db->select($this->eventTableName.'.isPublished as iseventpublish');
		$this->db->select($this->eventSessionTableName.'.*');
		$this->db->select('c2.countryName');
		$this->db->select('c1.countryName as "orgniserCountry"');
		$this->db->select($this->MasterIndustry.'.IndustryName');
		$this->db->select('MediaFile.*');
		$this->db->select($this->MasterRating.'.otpion');
		$this->db->select('l.Language_local');
		$this->db->select( $this->launchEventTableName.'.tdsUid as "tdsUid"');
		$this->db->select($this->UserShowcase.'.optionAreaName,'.$this->UserShowcase.'.enterprise,'.$this->UserShowcase.'.enterpriseName');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');	
		
		$this->db->from($this->launchEventTableName);
		$this->db->join($this->eventTableName, $this->eventTableName.'.EventId = CAST("'.$launchEventTableName.'"."EventId" as int)', 'left');
		$this->db->join($this->eventSessionTableName, $this->eventSessionTableName.'.launchEventId = '.$this->launchEventTableName.'.LaunchEventId', 'left');
		$this->db->join('MediaFile','MediaFile.fileId = '.$this->launchEventTableName.'.FileId', 'left');
		$this->db->join($this->MasterIndustry, $this->MasterIndustry.'.IndustryId = CAST("'.$launchEventTableName.'"."Industry" as int)', 'left');
		$this->db->join($this->MasterCountry.' as c1','c1.countryId = CAST("'.$launchEventTableName.'"."OrgCountry" as int)', 'left');
		$this->db->join($this->MasterCountry.' as c2','c2.countryId = CAST("'.$eventSessionTableName.'"."country" as int)', 'left');
		$this->db->join($this->MasterLang.' as l','l.langId = CAST("'.$launchEventTableName.'"."Language" as int)', 'left');
		$this->db->join($this->MasterRating, $this->MasterRating.".ratId = ".$this->launchEventTableName.".Rating", 'left');
		$this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->launchEventTableName.".tdsUid", 'left');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->launchEventTableName.".tdsUid", 'left');
		
		if($launchEventId>0) $this->db->where('LaunchEventId', $launchEventId);	 
		if($userId>0) $this->db->where($this->launchEventTableName.'.tdsUid', $userId);	 
		if(!empty($isPublished)) $this->db->where($this->launchEventTableName.'.isPublished', $isPublished);	 
		
		$this->db->where($this->launchEventTableName.'.isDeleted', 0); 
		
		if($cache==0) $this->db->limit(1);  
		
		$querydatalaunch = $this->db->get();
		return $querydatalaunch->result_array();
		
	}
	
	function getEventFullDetails($EventId=0,$userId=0,$isPublished='',$natureId=0,$offset=0,$limit=0)
	{
		$eventTableName = $this->db->dbprefix($this->eventTableName);
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
		$field = $this->eventTableName.'.*';	
		
		$entityId=getMasterTableRecord($this->eventTableName); 
		
		$currentDateTime= currntDateTime();
		$interval=$this->config->item('eventShownForExtraDays');
		$eventShownForExtraDays=getPreviousOrFututrDate($currentDateTime, $interval ,$format='Y-m-d H:i:s');	
		
		$this->db->select($field);
		$this->db->select($this->launchEventTableName.'.LaunchEventId,'.$this->launchEventTableName.'.isPublished as islaunchpublish');
		$this->db->select('MediaFile.*');
		$this->db->select('c2.countryName');
		$this->db->select('c1.countryName as "orgniserCountry"');
		$this->db->select($this->MasterRating.'.otpion');
		$this->db->select($this->MasterIndustry.'.IndustryName');
		$this->db->select('l.Language_local');
		$this->db->select( $this->eventTableName.'.tdsUid as "tdsUid"');
		$this->db->select($this->UserShowcase.'.optionAreaName,'.$this->UserShowcase.'.enterprise,'.$this->UserShowcase.'.enterpriseName');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');
		
		$this->db->select('log.craveCount,log.viewCount,log.ratingAvg,log.reviewCount,log.saleCount,log.dwnCount,log.ppvCount,log.lastViewDate,log.fileCount,log.shippedCount,log.ratingCount,log.ratingValue');
		
		$this->db->from($this->eventTableName);
		$this->db->join($this->launchEventTableName,$this->launchEventTableName.'.EventId = '.$this->eventTableName.'.EventId', 'left');
		$this->db->join('MediaFile','MediaFile.fileId = '.$this->eventTableName.'.FileId', 'left');
		$this->db->join($this->MasterCountry.' as c1','c1.countryId = CAST("'.$eventTableName.'"."OrgCountry" as int)', 'left');
		$this->db->join($this->MasterCountry.' as c2','c2.countryId = CAST("'.$eventTableName.'"."Country" as int)', 'left');
		$this->db->join($this->MasterRating, $this->MasterRating.".ratId = ".$this->eventTableName.".Rating", 'left');
		$this->db->join($this->MasterIndustry, $this->MasterIndustry.'.IndustryId = CAST("'.$eventTableName.'"."Industry" as int)', 'left');
		$this->db->join($this->MasterLang.' as l','l.langId = CAST("'.$eventTableName.'"."Language" as int)', 'left');
		$this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->eventTableName.".tdsUid", 'left');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->eventTableName.".tdsUid", 'left');
		
		$this->db->join($this->tableLogSummary.' log', 'log.elementId = '.$this->eventTableName.'.EventId AND  log."entityId"='.$entityId.' ', 'left');
		
		if($EventId>0) $this->db->where($this->eventTableName.'.EventId', $EventId);	 
		if($userId>0) $this->db->where($this->eventTableName.'.tdsUid', $userId);	 
		if(!empty($isPublished)){
			$this->db->where($this->eventTableName.'.isPublished', $isPublished);
			//$this->db->where(array('FinishDate >= '=>$eventShownForExtraDays));
		}
		if($natureId > 0){
			$this->db->where($this->eventTableName.'.NatureId',$natureId);
		}
		
		$this->db->where($this->eventTableName.'.isDeleted', 0); 
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		}	 
		 
		$querydatalaunch = $this->db->get();
		$result=$querydatalaunch->result_array();
		
		return $result;
	}
	
	function getEventPromotionalImages($where='')
	{
		
		if(is_array($where) && count($where) > 0 )
		{
			$field = 'mediaId,isMain,mediaTitle,mediaDescription,launchPostPR';
			$orderBy = 'mediaId';
			$order = 'DESC';

			$this->db->select($field);
			$this->db->select('MediaFile.*');
			$this->db->from($this->eventMediaTableName);
			$this->db->join('MediaFile','MediaFile.fileId = '.$this->eventMediaTableName.'.fileId', 'left');
			$this->db->where($where);
			$this->db->order_by($orderBy,$order);
			
			$querydatalaunch = $this->db->get();
			return $querydatalaunch->result_array();
		 }
		 else{
			return false;  
		 }
	}
	
	function geteventSessions($where='')
	{		
		if(is_array($where) && count($where) > 0 ){
			// $MTC TPS  Tickets
			$orderBy = $this->eventSessionTableName.'.position';
			$order = 'ASC';
			$eventSessionTableName = $this->db->dbprefix($this->eventSessionTableName);
			$this->db->select($this->eventSessionTableName.'.*');
			$this->db->select($this->MasterCountry.'.countryName');
			$this->db->from($this->eventSessionTableName);
			$this->db->join($this->MasterCountry, $this->MasterCountry.'.countryId = CAST("'.$eventSessionTableName.'"."country" as int)', 'left');
			$this->db->where($where);
			$this->db->where($this->eventSessionTableName.'.isDeleted', 0);
			$this->db->order_by($orderBy,$order);
			
			$querydatalaunch = $this->db->get();
			return $querydatalaunch->result_array();
	  }else{
		return false;  
	  }
		
	}
	
	function getMeetingPointSessions($where='')
	{		
		$currentDateTime= currntDateTime();
		//To generalize the function
		$keyField = key($where);
		$valueField = $where[$keyField];
		if(strcmp($keyField,'eventId')==0){
		$tableKeyField = 'EventId';
		$tableName = $this->db->dbprefix($this->eventTableName);
		}
		else{
		$tableKeyField = 'LaunchEventId';
		$tableName = $this->db->dbprefix($this->launchEventTableName);
		}
		if(is_array($where) && count($where) > 0 ){
		
			$orderBy = 'date';
			$order = 'ASC';
			$eventSessionTableName = $this->db->dbprefix($this->eventSessionTableName);
			
			$this->db->select($this->eventSessionTableName.'.*');			
			$this->db->select($tableName.'.Title,'.$tableName.'.NatureId');
			$this->db->from($this->eventSessionTableName);
			$this->db->join($tableName, $tableName.".".$tableKeyField." =". $eventSessionTableName.".".$keyField." AND \"".$tableName."\".\"".$tableKeyField."\"=".$valueField." ", 'left');
			$this->db->where($where);
			$this->db->where($this->eventSessionTableName.'.isDeleted', 0);
			//$this->db->where("(\"date\" >= '".$currentDateTime."')", null, false);
			$this->db->order_by($orderBy,$order);
			
			$querydatalaunch = $this->db->get();
			//echo $this->db->last_query();
			//echo '<pre />';print_r($querydatalaunch->result_array());
			return $querydatalaunch->result_array();
			
	  }else{
		return false;  
	  }
		
	}
	
	/**
	* This function gets event_id and launch_id for session data
	**/
	function getEventAndLuanchData($user_id=0,$offSet=0,$perPage=0)
	{
			$currentDateTime= currntDateTime();
			$this->db->select('event_id,launch_id,user_id, e.Title as eventTitle, l.Title as launchTitle,s.date,session_id');
			$this->db->from('MeetingPoint');
			$this->db->join($this->eventTableName.' as e' ,'e.EventId = MeetingPoint.event_id', 'left');
			$this->db->join($this->launchEventTableName.' as l', 'l.LaunchEventId = MeetingPoint.launch_id', 'left');
			$this->db->join($this->eventSessionTableName.' as s', 's.sessionId = MeetingPoint.session_id ', 'left');
			$this->db->having('s.date >=', $currentDateTime); 
			$this->db->having('user_id', $user_id); 
			$this->db->group_by("event_id, launch_id,user_id,e.Title, l.Title,s.date ,session_id");
			//$perPage=1;
			//$offSet=3;
			$this->db->order_by('event_id','asc');
			if($perPage!=0)	$this->db->limit($perPage,$offSet);
			$query = $this->db->get();
			//echo $this->db->last_query();
			//print_r($query->result_array());die;			
			return $query->result_array();	
	}
	
	
	function getSessionsTickets($sessionIds='')
	{		
		if(is_array($sessionIds) && count($sessionIds) > 0 ){
			$orderBy = 't.SessionId';
			$order = 'DESC';
			
			$this->db->select('t.TicketId as "TicketId",t.SessionId as "SessionId",t.Quantity,t.Price,t.isCategoryA,t.isCategoryB,t.isCategoryC,t.Free');
			$this->db->select('tps.StartDate as "beforeDate",tps.Price as "spacialPrice"');
			$this->db->select('mtc.Title as "categoryTitle"');
			
			$this->db->from($this->Tickets.' as t ');
			
			$this->db->join($this->TPS.' as tps', 'tps.TicketId = t.TicketId', 'left');
			$this->db->join($this->MTC.' as mtc', 'mtc.TicketCategoryId = t.TicketCategoryId', 'left');
			
			$this->db->where_in('t.SessionId',$sessionIds);
			$this->db->where('t.Quantity >',0);
			$this->db->order_by($orderBy,$order);
			
			$querydatalaunch = $this->db->get();		
			return $querydatalaunch->result_array();
	  }else{
		return false;  
	  }
		
	}
	
	function getLaunchDetails($userId=0,$checkPublished=true)
	{		
		$orderBy = 'LaunchDate';
		$order = 'ASC';
		$entityId = getMasterTableRecord('LaunchEvent');
		$eventMediaTableName = $this->db->dbprefix($this->eventMediaTableName);
		$LogSummary = $this->db->dbprefix('LogSummary');
		$field = 'LaunchEventId,LaunchDate,Title,OneLineDescription';
		
		$this->db->select($field);
		$this->db->select('MediaFile.*');
		$this->db->select('craveCount,viewCount,ratingAvg,reviewCount');
		
		$this->db->from($this->launchEventTableName);
		$this->db->join('LogSummary', 'LogSummary.elementId = '.$this->launchEventTableName.'.LaunchEventId AND  "'.$LogSummary.'"."entityId"='.$entityId.' ', 'left');
		$this->db->join('MediaFile','MediaFile.fileId = '.$this->launchEventTableName.'.FileId', 'left');
		if($userId>0) $this->db->where($this->launchEventTableName.'.tdsUid', $userId);
		
		if($checkPublished == true)
		$this->db->where($this->launchEventTableName.'.isPublished', 't');
		$this->db->where($this->launchEventTableName.'.isDeleted', 0);
		$this->db->order_by($orderBy,$order); 	
		
		$querydatalaunch = $this->db->get();
		return $querydatalaunch->result();
		
	}
	
	function getEventDetails($userId=0,$checkPublished=true){
		
		$orderBy = 'EventDateModified';
		$order = 'DESC';
		$entityId = getMasterTableRecord('Events');
		
		$currentDateTime= currntDateTime();
		$interval=$this->config->item('eventShownForExtraDays');
		$eventShownForExtraDays=getPreviousOrFututrDate($currentDateTime, $interval ,$format='Y-m-d H:i:s');
		
		
		$eventMediaTableName = $this->db->dbprefix($this->eventMediaTableName);
		
		$LogSummary = $this->db->dbprefix('LogSummary');
		$field = 'EventId,Title,OneLineDescription';
		
		$this->db->select($field);
		$this->db->select('MediaFile.*');
		$this->db->select('craveCount,viewCount,ratingAvg,reviewCount');
		
		$this->db->from($this->eventTableName);
		$this->db->join('LogSummary', 'LogSummary.elementId = '.$this->eventTableName.'.EventId AND  "'.$LogSummary.'"."entityId"='.$entityId.' ', 'left');
		$this->db->join('MediaFile','MediaFile.fileId = '.$this->eventTableName.'.FileId', 'left');
		if($userId>0) $this->db->where($this->eventTableName.'.tdsUid', $userId);
		$this->db->where_in($this->eventTableName.'.NatureId', array(2,4));
		
		if($checkPublished==true){
			$this->db->where($this->eventTableName.'.isPublished', 't');
			//$this->db->where(array('FinishDate >= '=>$eventShownForExtraDays));	
		}
		$this->db->where($this->eventTableName.'.isDeleted', 0);
		$this->db->order_by($orderBy,$order);
		$querydatalaunch = $this->db->get();
		return $querydatalaunch->result();
	}
	
	function getNotificationDetails($userId=0,$natureId=1,$isPublished='t'){
		
		$orderBy = 'StartDate';
		$order = 'ASC';
		$currentDateTime= currntDateTime();
		$interval=$this->config->item('eventShownForExtraDays');
		$eventShownForExtraDays=getPreviousOrFututrDate($currentDateTime, $interval ,$format='Y-m-d H:i:s');
						
		$field = $this->eventTableName.'.tdsUid as "tdsUid",'.$this->eventTableName.'.EventId';	 	
		$this->db->select($field);
		$this->db->from($this->eventTableName);
		
		if($userId>0) $this->db->where($this->eventTableName.'.tdsUid', $userId);	 
		if(!empty($isPublished)){
			$this->db->where($this->eventTableName.'.isPublished', $isPublished);
			//$this->db->where(array('FinishDate >= '=>$eventShownForExtraDays));
		}
		if($natureId > 0)$this->db->where($this->eventTableName.'.NatureId',$natureId);
	    
	    $this->db->where($this->eventTableName.'.isDeleted', 0);
		$this->db->order_by($orderBy, $order);
		
		$querydatalaunch = $this->db->get();
		
		return $querydatalaunch->result();
	}
	
	function getMeetingSessions($where='')
	{
		
		if(is_array($where) && count($where) > 0 ){
			// $MTC TPS  Tickets
			$orderBy = 'date';
			$order = 'ASC';
			$this->db->select('s.*');
			$this->db->from('MeetingPoint');
			$this->db->join($this->eventSessionTableName.' as s' ,'s.sessionId = MeetingPoint.session_id', 'left');
			$this->db->where($where);
			$this->db->where($this->eventSessionTableName.'.isDeleted', 0);
			//$this->db->order_by($orderBy,$order);
			$querydatalaunch = $this->db->get();
			//echo $this->db->last_query();
			
			return $querydatalaunch->result_array();
	  }else{
		return false;  
	  }
		
	} 
	
	function launchPostPrImages($launchId=0)
	{
		$this->db->from($this->eventMediaTableName);
		$this->db->join('MediaFile','MediaFile.fileId = '.$this->eventMediaTableName.'.fileId');
		$this->db->where($this->eventMediaTableName.'.launchEventId ',$launchId);
		$this->db->where_in('launchPostPR','t');
		$launchPostPrImages = $this->db->get();
		
		//echo 'Last Query'.$this->db->last_query();
		//die;
		if(count($launchPostPrImages)>0)
			$launchPostPrImages = $launchPostPrImages->result_array();
		else
			$launchPostPrImages = 0;
			
		return $launchPostPrImages;		
	}
	
	
	function getCravedUserAnyEvent($launchId){
			
		   $LogSummary = $this->db->dbprefix($this->tableLogSummary);
		   $LogCrave = $this->db->dbprefix($this->LogCrave);		   
           $launchEventTableName = $this->db->dbprefix($this->launchEventTableName);
           $tableUserAuth = $this->db->dbprefix($this->tableUserAuth);
           $projectType ="'performancesevents'";
		   //$where ='Where c."ownerId" ='.$this->userId.' AND c."projectType"='.$projectType.' AND  c."elementId"='.$launchId;	          
		   $where ='Where c."ownerId" ='.$this->userId.' AND c."projectType"='.$projectType.' ';	          
         
           //$sql=' SELECT c."tdsUid",a."email",c."tdsUid",c."craveId",c."entityId",c."elementId",c."projectType" FROM "'.$LogCrave.'" c LEFT JOIN "'.$launchEventTableName.'" l ON (l."LaunchEventId" = c."elementId")	JOIN "'.$tableUserAuth.'" a ON (a."tdsUid" = c."tdsUid") LEFT JOIN "'.$LogSummary.'" s ON (s."entityId" = c."entityId" AND s."elementId" = c."elementId" )	'.$where.' 	';			
           $sql=' SELECT  a."tdsUid"								
					FROM "'.$LogCrave.'" c
					LEFT JOIN "'.$launchEventTableName.'" l ON (l."LaunchEventId" = c."elementId")					
					JOIN "'.$tableUserAuth.'" a ON (a."tdsUid" = c."tdsUid") 
					LEFT JOIN "'.$LogSummary.'" s ON (s."entityId" = c."entityId" AND s."elementId" = c."elementId" )					
					'.$where.' 				
				';			
			$query = $this->db->query($sql);	
			//echo '<pre />xdg';print_r($query->result());
			//die;		
			return $result=$query->result_array();	
		
	}
	
	/*
	 * Function to insert meeting point  
	 */ 
	function joinMeetingData($meetingData){
		$query = $this->db->insert($this->meetingPoint, $meetingData);	
		$meetingInsertId=$this->db->insert_id();		
		return $meetingInsertId;
	}
	
	function getfurtherdescription($table='',$where=array(),$fields=''){
		$this->db->select($fields);
		$this->db->select($this->tableUserContainer.'.containerSize,'.$this->tableUserContainer.'.userContainerId');
		$this->db->select($this->MediaFile.'.*');
		
		$this->db->from($table);
		$this->db->join($this->MediaFile, $this->MediaFile.'.fileId = '.$table.'.FileId', 'left');
		$this->db->join($this->tableUserContainer, $this->tableUserContainer.'.userContainerId = '.$table.'.userContainerId', 'left');
				
		$this->db->where($where); 
		$this->db->limit(1);
		$result = $this->db->get();
		
		return $result->result();;
	}
	
	
	
	/*
	 **********************
	 *  This function is used to get purchase ticket list
	 ********************** 
	 */   
  
  
	function get_purchase_session($userId,$offset=0,$limit=0)
	{
		$this->db->select('ticketInfo,sessionId');
		$this->db->from($this->tableTicketTransectionLog);	  	
		$this->db->where($this->tableTicketTransectionLog.'.userId',$userId);	
		
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		
		$this->db->order_by($this->tableTicketTransectionLog.'.id','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->result();
		return $result;
	}
		
	
}//End Class model_event
