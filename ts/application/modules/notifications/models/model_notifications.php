<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

class model_notifications extends CI_Model {
private $userId = NULL;
private $LogCrave = 'LogCrave';
private $Notification = 'Notification';
private $NotificationParticipants = 'NotificationParticipants';
private $MasterIndustry = 'MasterIndustry';
private $Events = 'Events';
private $LaunchEvent = 'LaunchEvent';
private $EventSessions = 'EventSessions';
private $search = 'search';
	
	function __construct()
	{
		parent::__construct();
		$this->userId = isLoginUser();			
	}
	
	function notification_when_section_craved($whereClause){
		//echo '<pre />';print_r($whereClause);die;
		$this->db->select('distinct("'.$this->db->dbprefix($this->LogCrave).'"."tdsUid")');
		$this->db->from($this->LogCrave);
		$this->db->join(''.$this->LogCrave.' as lc' ,'lc.tdsUid = '.$this->LogCrave.'.tdsUid AND "lc"."entityId"=93', 'left');
		$this->db->where($whereClause);
		//$this->db->where($this->LogCrave.'.tdsUid != ', $this->userId);
		//$this->db->group_by('LogCrave.tdsUid'); 
		$query = $this->db->get();
		$all_user_who_craved = $query->result_array();
		//echo $this->db->last_query();
		//echo '<pre />';print_r($all_user_who_craved);
		//die;
		return	$all_user_who_craved;	
	}	
	
	function fetch_notifications($whereClause,$limit=0,$offset=0){
		
		//$projEntityId=0;
		//echo 'projEntityId'.$whereClause['type'].''.$projEntityId = getMasterTableRecord($this->db->dbprefix('Project'));die;
		//echo '<pre />';print_r($whereClause);
		$notInclude = array('news','upcoming','reviews');		
		
		$NotificationParticipants=$this->db->dbprefix($this->NotificationParticipants);
		$Notification=$this->db->dbprefix($this->Notification);
		$EventSessions=$this->db->dbprefix($this->EventSessions);
		//$search=$this->db->dbprefix($this->search);		
		$this->db->select($this->Notification.'.projectType,'.$this->Notification.'.entityId,'.$this->Notification.'.elementId,'.$this->Notification.'.projectId,'.$this->Notification.'.industryId,'.$this->Notification.'.message,'.$this->Notification.'.createdDate,'.$this->Notification.'.ownerId,'.$this->NotificationParticipants.'.notificationId,'.$this->NotificationParticipants.'.id,'.$this->NotificationParticipants.'.userId,'.$this->NotificationParticipants.'.isSender,'.$this->NotificationParticipants.'.status');		
		
		//if(isset($whereClause['entityId']) && ($whereClause['entityId']==9 || $whereClause['entityId']==15 || $whereClause['entityId']==10)){
			
			$this->db->select($EventSessions.'.eventId as sessionEventId, '.$EventSessions.'.launchEventId as sessionlaunchEventId');			
			$this->db->select($this->Events.'.NatureId as EventNautreId');
			$this->db->select($this->LaunchEvent.'.NatureId as LaunchNautreId');
				
		//}
		//$this->db->select('entityid, elementid as ei, projectid,section,(item).title,(item).userid,(item).creative_name,(item).category,(item).categoryid,(item).work_type,(item).industryid,(item).industry');
		$this->db->from($this->NotificationParticipants);
		$this->db->join($this->Notification ,$this->NotificationParticipants.'.notificationId = '.$this->Notification.'.id', 'left');		
		
		//if(isset($whereClause['entityId']) && ($whereClause['entityId']==9 || $whereClause['entityId']==15 || $whereClause['entityId']==10)) {
			
				$this->db->join($EventSessions,$this->Notification.'.elementId = '.$EventSessions.'.sessionId', 'left');			
				$this->db->join($this->Events,$this->Notification.'.elementId = '.$this->Events.'.EventId', 'left');			
				$this->db->join($this->LaunchEvent ,$this->Notification.'.elementId = '.$this->LaunchEvent.'.LaunchEventId', 'left');
			
		//}		
		//$this->db->join($this->search ,$this->search.'.entityid = '.$this->Notification.'."entityId" AND "'.		$search.'".elementid = "'.$Notification.'"."elementId"', 'left');						
		//$this->db->join($this->MasterIndustry ,$this->MasterIndustry.'.IndustryId = '.$this->Notification.'.industryId', 'left');		
		if(isset($whereClause['type']) && $whereClause['type']!='all')
		{
			if($whereClause['type']=='performancesevents') $projectType = array('performancesevents','postLaunch');
			else $projectType = $whereClause['type'];
				$this->db->where_in('projectType',$projectType);		
		}
		
		
		if(isset($whereClause['entityId']) && $whereClause['entityId']>0)
			$where_entity = '"'.$Notification.'"."entityId"='.$whereClause['entityId'];
			
		if(isset($whereClause['elementEntityId']) && $whereClause['elementEntityId']>0){
			if($where_entity !='') $where_entity .= ' OR "'.$Notification.'"."entityId"='.$whereClause['elementEntityId'];
			else $where_entity = '"'.$Notification.'"."entityId"='.$whereClause['elementEntityId'];
		}
		
		if(isset($whereClause['sessionEntityId']) && $whereClause['sessionEntityId']>0)
		{
			if($where_entity !='') $where_entity .= ' OR "'.$Notification.'"."entityId"='.$whereClause['sessionEntityId'];
			else $where_entity = $where_entity = '"'.$Notification.'"."entityId"='.$whereClause['sessionEntityId'];
		}
		
		if(isset($where_entity) && $where_entity!='') $this->db->where('('.$where_entity.')', NULL, FALSE);
		
		//$this->db->where('ownerId',$this->userId);		
		$this->db->where($this->NotificationParticipants.'.userId',$this->userId);		
		$this->db->where($this->NotificationParticipants.".status !=",3);		
		$this->db->order_by($this->Notification.".projectType");		
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		} 
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$section_craved_list = $query->result_array();
		//echo '<pre />';print_r($section_craved_list);
		return	$section_craved_list;	
		
	}
	
	function count_fetched_notifications($whereClause){		
		
		$notInclude = array('news','upcoming','reviews');
		$Notification=$this->db->dbprefix($this->Notification);
		$NotificationParticipants=$this->db->dbprefix($this->NotificationParticipants);
		$search=$this->db->dbprefix($this->search);
		$where_entity = '';
		$this->db->select($this->Notification.'.projectType,'.$this->Notification.'.entityId,'.$this->Notification.'.elementId,'.$this->Notification.'.projectId,'.$this->Notification.'.industryId,'.$this->Notification.'.message,'.$this->Notification.'.createdDate,'.$this->Notification.'.ownerId,'.$this->NotificationParticipants.'.notificationId,'.$this->NotificationParticipants.'.id,'.$this->NotificationParticipants.'.userId,'.$this->NotificationParticipants.'.isSender,'.$this->NotificationParticipants.'.status');		
		
		$this->db->from($this->NotificationParticipants);
		$this->db->join($this->Notification ,$this->NotificationParticipants.'.notificationId = '.$this->Notification.'.id', 'left');		
		
		if(isset($whereClause['type']) && $whereClause['type']!='all'){
			if($whereClause['type']=='performancesevents') $projectType = array('performancesevents','postLaunch');
			else $projectType = $whereClause['type'];
				$this->db->where_in('projectType',$projectType);
			}		
		
		if(isset($whereClause['entityId']) && $whereClause['entityId']>0)
			$where_entity = '"'.$Notification.'"."entityId"='.$whereClause['entityId'];
			
		if(isset($whereClause['elementEntityId']) && $whereClause['elementEntityId']>0){
			if($where_entity !='') $where_entity .= ' OR "'.$Notification.'"."entityId"='.$whereClause['elementEntityId'];
			else $where_entity = '"'.$Notification.'"."entityId"='.$whereClause['elementEntityId'];
		}
		
		if(isset($whereClause['sessionEntityId']) && $whereClause['sessionEntityId']>0)
		{
			if($where_entity !='') $where_entity .= ' OR "'.$Notification.'"."entityId"='.$whereClause['sessionEntityId'];
			else $where_entity = $where_entity = '"'.$Notification.'"."entityId"='.$whereClause['sessionEntityId'];
		}
		
		if($where_entity!='') $this->db->where('('.$where_entity.')', NULL, FALSE);
		
		if(isset($whereClause['industryId']) && $whereClause['industryId']>0)		
			$this->db->where('industryId',$whereClause['industryId']);		
		
		$this->db->where($this->NotificationParticipants.'.userId',$this->userId);		
		$this->db->where($this->NotificationParticipants.".status !=",3);
		$this->db->order_by($this->Notification.".projectType");	
		$query = $this->db->get();
		//echo $this->db->last_query();
		$section_craved_list = $query->result_array();
		//echo '<pre />';print_r($section_craved_list);die;
		return	$section_craved_list;	
	}
	
	function count_notifications(){
		
		$this->db->select($this->NotificationParticipants.'.userId,'.$this->Notification.'.projectType,'.$this->Notification.'.industryId,'.$this->Notification.'.entityId');			
		$this->db->from($this->NotificationParticipants);				
		$this->db->join($this->Notification ,$this->NotificationParticipants.'.notificationId = '.$this->Notification.'.id', 'left');		
				
		//$this->db->where('ownerId',$this->userId);	
		$this->db->where($this->NotificationParticipants.'.userId',$this->userId);			
		$this->db->where($this->NotificationParticipants.".status !=",3);		
		$this->db->order_by($this->Notification.'.projectType');
		
		$query = $this->db->get();		
		//echo $this->db->last_query();
		$section_craved_list = $query->result_array();
		//echo '<pre />';print_r($section_craved_list);die;
		return	$section_craved_list;	
	}
	
	function trashNotificationMessage($Id,$currentUserId){	
			
			$status = array('status'=>3);							
			$this->db->where('id',$Id);		
			$this->db->update($this->NotificationParticipants,$status);			
			
	}
		
}
