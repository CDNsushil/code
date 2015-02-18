<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	 * Description:
	 * The model_work class is meant to handle the processing of Work Profile section
	 * It include functionality to fetch/add/edit Videos,Images,Written Materials and Audios 
	 Author Name: Gurutva Singh
	 Date Created: 7 Februray 2012
	 Date Modified: 9 Februray 2012 	
*/
class model_work_wanted extends CI_Model {

	private $tablework = 'Work';
	private $tabelreviews ='ReviewLog';
	private $UserId = 1;
	
	// Constructor
	function __construct()
	{
		parent::__construct();
	}
	
	function workWanted()
	{	
		$field = 'workType';
		$workType = 'wanted';
		$this->db->where('workArchived','t');
		$this->db->where($field,$workType);
		$this->db->where($field,$workType);
		$this->db->order_by('workModifiedDate', 'desc');
		$workWantedQuery =  $this->db->get($this->tablework);		
		return $workWantedQuery;	
	}
	
	function workArchive($workType='offered')
	{
		$field = 'workType';	
		$this->db->where('workArchived','f');
		$this->db->where($field,$workType);
		$workArchivedQuery =  $this->db->get($this->tablework);	
		return $workArchivedQuery;	
	}
	
	/**
		* To Permanently Delete The Record
	**/
	function pDeleteWork($workId,$workType)
	{
		$fieldWorkType = 'workType';	
		$fieldWorkId = 'workId';
		$this->db->where($fieldWorkId,$workId);
		$this->db->where($fieldWorkType,$workType);
		$this->db->delete($this->tablework); 
	}
	/**
		* workWantedForm method fetches the records form work
		* giving the values in the options array priority.
		*
		* @param int $workId
		* @return array
	**/		
	function workWantedForm($workId)
	{	
		$table = $this->tablework;
		$field = 'workId';
		$this->db->where($field,$workId);
		$workResult = $this->db->get($table);	
		
		if($workResult->num_rows()>0)
		{					
			$workResultData  = $workResult->result_array();
		} 
		else
		{
			$workResultData[0] = array(
				'workTitle'=>$this->input->post('workTitle'),
				'workType'=>$this->input->post('workType'),
				'workOneLineDesc'=>$this->input->post('workOneLineDesc'),
				'workTagWords'=>$this->input->post('workTagWords'),
				'workDesc'=>$this->input->post('workDesc'),
				'workLocation'=>$this->input->post('workLocation'),
				'workCityId'=>$this->input->post('workCityId'),
				'workLang1'=>$this->input->post('workLang1'),
				'workLang2'=>$this->input->post('workLang2'),
				'workLang3'=>$this->input->post('workLang3'),
				'workRemuneration'=>$this->input->post('workRemuneration'),
				'workReview'=>$this->input->post('workReview'),
				'workRecommendation'=>$this->input->post('workRecommendation'),
				'workIndustry'=>$this->input->post('workIndustry'),	
				'workUrgent'=>$this->input->post('workUrgent'),	
				'offerWorkExp'=>$this->input->post('offerWorkExp'),	
				'workvideo'=>$this->input->post('workvideo'),
				'uploadVideoType'=>$this->input->post('uploadVideoType'),							
	   );
		}		
		return $workResultData;	
	}
	
	/**
		* insertPost method Inserts a record in the work table".
		*
		* Post: Values
		* --------------
		*	workTitle
		*	workOneLineDesc
		*	workTagsWords
		*	workDesc
		*	workLocation
		*	workLang1
		*	workLang2
		*	workLang3
		*	workRemuneration
		*	workReview
		*	workRecommendation
		*	workIndustry	
		*
		* @param int workId //last inserted work Id
	*/
	
	function insertWorkWanted($fileName)
	{		
	 //	$this->workId   = $_POST['workId']; 
	//echo "<pre />"; print_r($_POST);
	 $embeddedURL = $this->input->post('myUpload');
		$workVideo = '';
		//Embedded URL get saved if the checkbox(isEmbbededURL) is checked else the video file get uplaoded
		if(strcmp($embeddedURL,'url')==0) 
		{
			$workVideo = $this->input->post('workEmbbededURL');
		}
		else
		{
			if($fileName !='') $workVideo = $_FILES['userfile']['name'];
		}
		
		 $workUrgstatus = $this->input->post('workUrgent');
		 
		 $offerWorkExpstatus = $this->input->post('offerWorkExp');
		 if($offerWorkExpstatus =='accept') $offerWorkExp = 't';
		 else $offerWorkExp = 'f';
		 
		 $uploadVideoTypestatus = $this->input->post('myUpload');
		 if(($uploadVideoTypestatus =='video') && (count($_FILES)>0)) $uploadVideoType = 't';
		 else $uploadVideoType = 'f';
		 
		 
		 $workDateCreated = date("Y-m-d H:i:s");
		 $workModifiedDate = date("Y-m-d H:i:s");
		 // add 3 days to date
		  
		$insertWorkWanted  = array(
				'workTitle'=>$this->input->post('workTitle'),
				'workType'=>$this->input->post('workType'),
				'workOneLineDesc'=>$this->input->post('workOneLineDesc'),
				'workTagWords'=>$this->input->post('workTagWords'),
				'workDesc'=>$this->input->post('workDesc'),
				'workCityId'=>$this->input->post('workCityId'),
				'workLocation'=>$this->input->post('workLocation'),
				'workLang1'=>$this->input->post('workLang1'),
				'workLang2'=>$this->input->post('workLang2'),
				'workLang3'=>$this->input->post('workLang3'),
				'workRemuneration'=>$this->input->post('workRemuneration'),
				'workReview'=>$this->input->post('workReview'),
				'workRecommendation'=>$this->input->post('workRecommendation'),
				'workIndustry'=>$this->input->post('workIndustry'),
				'workVideo'=>$workVideo,
				'uploadVideoType'=>$uploadVideoType,
				'workDateCreated'=>$workDateCreated,
				'workModifiedDate'=>$workModifiedDate,
				);
			
		$field = 'workId';
		$this->db->insert($this->tablework, $insertWorkWanted); 
		return	$this->db->insert_id();	
	}	
	
	/**
		* updateWorkWanted method Inserts a record in the "work" table.
		*
		* Post: Values
		* --------------
		*	workTitle
		*	workOneLineDesc
		*	workTagsWords
		*	workDesc
		*	workLocation
		*	workLang1
		*	workLang2
		*	workLang3
		*	workRemuneration
		*	workReview
		*	workRecommendation
		*	workIndustry
	*/
	function updateWorkWanted($fileName)
	{ 
		//echo "<pre>"; print_r($_POST);
		$embeddedURL = $this->input->post('myUpload');
		$workVideo = '';
		//Embedded URL get saved if the checkbox(isEmbbededURL) is checked else the video file get uplaoded
		if(strcmp($embeddedURL,'url')==0) 
		{
			$workVideo = $this->input->post('workEmbbededURL');
		}
		else
		{
			if($fileName!='') $workVideo = $fileName;
		}
		
		 $workUrgstatus = $this->input->post('workUrgent');
		 if($workUrgstatus =='accept') $workUrgent = 't';
		 else $workUrgent = 'f';
		 
		 $offerWorkExpstatus = $this->input->post('offerWorkExp');
		 if($offerWorkExpstatus =='accept') $offerWorkExp = 't';
		 else $offerWorkExp = 'f';
		 
		 $uploadVideoTypestatus = $this->input->post('myUpload');
		 if(($uploadVideoTypestatus =='video') && (count($_FILES)>0)) $uploadVideoType = 't';
		 else $uploadVideoType = 'f';
		
		 $workModifiedDate = date("Y-m-d H:i:s");
		  		
		 $updateWorkWanted = array(
				'workTitle'=>$this->input->post('workTitle'),
				'workType'=>$this->input->post('workType'),
				'workOneLineDesc'=>$this->input->post('workOneLineDesc'),
				'workTagWords'=>$this->input->post('workTagWords'),
				'workDesc'=>$this->input->post('workDesc'),
				'workCityId'=>$this->input->post('workCityId'),
				'workLocation'=>$this->input->post('workLocation'),
				'workLang1'=>$this->input->post('workLang1'),
				'workLang2'=>$this->input->post('workLang2'),
				'workLang3'=>$this->input->post('workLang3'),
				'workRemuneration'=>$this->input->post('workRemuneration'),
				'workReview'=>$this->input->post('workReview'),
				'workRecommendation'=>$this->input->post('workRecommendation'),
				'workIndustry'=>$this->input->post('workIndustry'),
				'workUrgent'=>$workUrgent,
				'offerWorkExp'=>$offerWorkExp,
				'workVideo'=>$workVideo,
				'uploadVideoType'=>$uploadVideoType,
				'workModifiedDate'=>$workModifiedDate,
				);
				if(strcmp($embeddedURL,'url')!=0) 
				{
					if($fileName=='') unset($updateWorkWanted['workVideo']);
				}
	
		$workWantedId = $this->input->post('workWantedId');
	
		$field = 'workId';
		$this->db->where($field,$workWantedId);
		$this->db->update($this->tablework,$updateWorkWanted);
		return $workWantedId;		
	}
	
	function workWantedPreview($workId)
	{
		$workPreviewData = $this->workWantedForm($workId);
		return $workPreviewData;
	}
	
	/**
		* Fetches the loaction for Location table to get displayed in dropdown of Location
	**/	
	function loadLocation()
	{
		
		
		$recordsLocation = $this->db->get('Location');	
		$location = $recordsLocation->result();
		return $location;
	}
	
	/**
		* Fetches the Language for Language table to get displayed in dropdown of Languages
	**/	
	function loadLanguage()
	{
		$this->db->select('langId,Language_local');
		$recordsLanguage = $this->db->get('Language');	
		$language = $recordsLanguage->result();
		return $language;
	}
		
	/**
		* Archiving/Unarchiving the Work Wanted functionality
		* @access	public
		* @params $workWantedId
			
		* redirect
	**/
	function archiveWorkWanted($workWantedId)
	{ 
		$field = 'workId';		
		$toggleArchiveUpdateQuery ='update "'.$this->tablework.'" SET "workArchived" =( CASE
				WHEN ("workArchived" =  true) THEN false ELSE true END ) WHERE "'.$field.'" ='.$workWantedId;		
		//echo 		$toggleArchiveUpdateQuery;
		$this->db->query($toggleArchiveUpdateQuery);
		
	}
	/**
		* Fetches all the reviews of logged in user
		* ****** Note: For default I have taken UserId as '1' ******
	**/
	function reviews()
	{ 
		$field = 'UserId';
		
		$this->db->where($field,$this->UserId);	
		$reviewData = $this->db->get($this->tabelreviews);	
		return	$reviewData->result();
	}	
	/**
		* Function  to renew the expiry date of work
	**/
	function renew($workId){
		//workExpiryDate
		$field = 'workId';
		
	//To fetch that work is uregnt or not this for future use may be on the basis of urgent/normal the expiry days update may vary
			$this->db->select('workUrgent'); //selects only workUrgent from Work table
			$this->db->where($field,$workId);
			$workResultUrgent = $this->db->get($this->tablework);			
			$resultWorkUrgent = $workResultUrgent->result_array();					
			$flagUrgentWork = $resultWorkUrgent[0]['workUrgent'] == 't'?1:0;		
		
		//If $flagUrgentWork is equal to '0' it means work is not urgent so renew it for defined days
		if($flagUrgentWork == 1) $renewDays = '14 days';
		else $renewDays = '30 days';
		
		//If $flagUrgentWork is equal to '0' its means work is not urgent so renew it for defined days
		$expiryUpdateQuery = 'UPDATE "'.$this->tablework.'"  set "workExpiryDate" = "workExpiryDate"+ cast(\''.$renewDays.'\' as interval) WHERE "'.$field.'" ='.$workId.'';
		
		$this->db->query($expiryUpdateQuery);
	}
	
	/**
		* List the detail for Work Applied Listing Page
	**/
	function workAppliedFor()
	{		
	
		$this->db->select('WorkApplication.appId,WorkApplication.workId,WorkApplication.tdsUid,WorkApplication.dateApplied,WorkApplication.tmailId,Work.workTitle,Work.workIndustry,Work.workUserId,Work.workDateCreated,Work.workExpiryDate,GeneralShowcase.firstName,GeneralShowcase.lastName');
		$this->db->from('Work');
		$this->db->join('WorkApplication', 'Work.workId = WorkApplication.workId ');
		$this->db->join('GeneralShowcase', 'WorkApplication.tdsUid=GeneralShowcase.uId ');//to fetch the user name who posted the WORK
		$this->db->where('WorkApplication.tdsUid', $this->UserId );

		$resultAppliedFor = $this->db->get();
		
		return $resultAppliedFor->result();
		
	}//End function work applied for
	
	/**
		* List the detail for Work Received Listing Page
	**/
	function workApplicationReceived()

	{					
		$this->db->select('WorkApplication.appId,WorkApplication.workId,WorkApplication.tdsUid,WorkApplication.dateApplied,WorkApplication.workId as appworkid,WorkApplication.tmailId,Work.workTitle,Work.workIndustry');

		$this->db->from('Work');
		$this->db->join('WorkApplication', 'Work.workId = WorkApplication.workId','left');
		//$this->db->join('GeneralShowcase', 'WorkApplication.tdsUid=GeneralShowcase.uId ');//to fetch the user name who posted the WORK
		$this->db->where('Work.workUserId', $this->UserId );
		$this->db->where('WorkApplication.tdsUid <>', $this->UserId );
		
		$resultWorkId = $this->db->get();
		$workApp['info'] = $resultWorkId->result_array();
		
		//generating Comma sepearted WorkIds to get fetched by putting it in where_in clause	
		$countInt = 0;
		foreach ($workApp['info'] as $row)
		{
			$workAppDetailInfo[$row['workId']]['appId'][] = $row['appId'];
			$workAppDetailInfo[$row['workId']]['workTitle'] = $row['workTitle'];
			$workAppDetailInfo[$row['workId']]['username'][] = getUserName($row['tdsUid']);
			$workAppDetailInfo[$row['workId']]['dateApplied'][] = $row['dateApplied'];
			$workAppDetailInfo[$row['workId']]['tmail'][] = $row['tmailId'];
			$workAppDetailInfo[$row['workId']]['workIndustry'][] = getIndustry($row['workIndustry']);
				
		}
	return $workAppDetailInfo; //This will return the array with the detail reqiured values for  workprofile and related user name and info
		
	}//End function work applied for
	
	/**
		*Delete the selcted Ids fpr Work Application table
	**/
	function deleteWorkApp($appIds)
	{
		
		$delQuery ='delete from "WorkApplication" where "appId" in('.$appIds.')';
		$this->db->query($delQuery);
			 
	}//End deleteWorkApp
}
?>
