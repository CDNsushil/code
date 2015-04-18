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
class model_work_offered extends CI_Model {

	private $tablework = 'Work';
	private $tabelreviews ='ReviewLog';
	private $tabelWorkApplication ='WorkApplication';
	private $MasterLang = 'MasterLang';
	private $MasterCountry = 'MasterCountry';
	private $UserShowcase	= 'UserShowcase';
	private $UserProfile	= 'UserProfile';
	private $MasterIndustry	= 'MasterIndustry';
	private $tableUserContainer	= 'UserContainer';
	
	// Constructor
	function __construct()
	{
		parent::__construct();
	}

	function getWork($userId=0,$workType,$deletedItems='',$workID=0,$limitFrom=0, $limitRecord=10)
	{
		//echo $deletedItems;
		$field = 'workType';
		$this->db->join("UserAuth", "UserAuth.tdsUid = Work.tdsUid", 'left');
		//$this->db->join("ProjActivity", "ProjActivity.workId = Work.workId", 'left');
		$this->db->where('Work.tdsUid',$userId);
		$this->db->where('Work.workType',$workType);
		
		if($deletedItems=='')
			$this->db->where('Work.workArchived','f');
		else
			$this->db->where('Work.workArchived','t');
		$this->db->order_by("Work.workId", "desc");
		$this->db->limit($limitRecord,$limitFrom);
		$workOfferedQuery =  $this->db->get($this->tablework);
		//echo $this->db->last_query();		
		return $workOfferedQuery->result();	  
	}
	
	

	function checkImageCount($workId,$workType)
	{
		$fieldworkId = 'workId';
		$this->db->where($fieldworkId,$workId);
		$this->db->where('workCategory',$workType);
		$this->db->where('workPrmotionMediaType','image');
		$getworkPromotionMedia = $this->db->get('workPromotionMedia');
		return $getworkPromotionMedia->num_rows();
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

	function checkWorkId($workId)
	{
		$field = 'workId';
		$this->db->where($field,$workId);
		$workOfferedQuery =  $this->db->get($this->tabelWorkApplication);	
		if($workOfferedQuery->num_rows()>0)
			return 1;
		else 
			return 0;
	}
	
	function pDeleteWork($workId,$workType)
	{
		$fieldWorkType = 'workType';	
		$fieldWorkId = 'workId';
		$this->db->where($fieldWorkId,$workId);
		$this->db->where($fieldWorkType,$workType);
		$this->db->delete($this->tablework); 
	}

	function workPromotionMediaRecordSet($workId,$workCategory,$workType)
	{
		$table = 'workPromotionMedia';
		$field = 'workId';
		$fieldworkType = 'mediaType';
		$this->db->where($field,$workId);
		$this->db->where($fieldworkType,2);
		$this->db->order_by('mediaId','asc');

		$datawork = $this->db->get($table);
		return $datawork->result();
	}

	/**
		* workForm method fetches the records form work
		* giving the values in the options array priority.
		*
		* @param int $workId
		* @return array
	*/

	function workOfferedForm($workId)
	{
		$table = $this->tablework;
		
		$field = 'workId';
		
		$this->db->where($field,$workId);
		
		$workResult = $this->db->get($table);
		
		if($workResult->num_rows()>0)
		{					
			$workResultData  = $workResult->row();
		} 
		else
		{
			$workResultData[0] = array(
			 	'workTitle'=>$this->input->post('workTitle'),
				'workType'=>$this->input->post('workType'),
				'workShortDesc'=>$this->input->post('workShortDesc'),
				'workTypeDesc'=>$this->input->post('workTypeDesc'),
				'workTag'=>$this->input->post('workTag'),
				'workDesc'=>$this->input->post('workDesc'),
				'workCountryId'=>$this->input->post('workCountryId'),
				'workCity'=>$this->input->post('workCity'),
				'workLang1'=>$this->input->post('workLang1'),
				'workLang2'=>$this->input->post('workLang2'),
				'workLang3'=>$this->input->post('workLang3'),
				'workRemuneration'=>$this->input->post('workRemuneration'),
				'workReview'=>$this->input->post('workReview'),
				'workRecommendation'=>$this->input->post('workRecommendation'),
				'workIndustryId'=>$this->input->post('workIndustryId'),	
				'isUrgent'=>$this->input->post('isUrgent'),	
				//'offerWorkExp'=>$this->input->post('offerWorkExp'),	
				'workExperiece'=>$this->input->post('workExperiece'),	
				'workvideo'=>$this->input->post('workvideo'),
				'uploadVideoType'=>$this->input->post('uploadVideoType'),	
							
	     );
		}
		return $workResultData;	
	}

	function deleteWork($workId, $workType)
	{
		$fieldworkId = 'workId';
		$fieldworkType = 'workType';
		$this->db->where($fieldworkId,$workId);
		$this->db->where($fieldworkType,$workType);
		$this->db->set('workArchived','t');
		$this->db->update('Work');
		return true;
	}
	
	function deletePermanently($workId, $workType)
	{
		//Check for the Media exists
		$result = $this->checkMediaExists($workId);

		if($result->num_rows() > 0)
		{
			$mediaId = $result->result();
		}
		else
		{
			$mediaId = 0;
		}

		if(is_array($mediaId)){

			foreach($mediaId as $id){
				$fileId = $this->getMediaFileId($id->mediaId);

				$this->deleteLocalMediaFile($id->mediaId);

				$this->deleteMasterMediaFile($fileId);
			}
		}
		$this->db->delete('Work', array('workId' => $workId)); 
		return true;
	}
	
	function getMediaFileId($mediaId)
	{
		$this->db->select('fileId');
		$this->db->where('mediaId',$mediaId);
		$query = $this->db->get('TDS_workPromotionMedia');
		return $query->row()->fileId;
	}
	
	function checkMediaExists($workId)
	{
		$this->db->where('workId',$workId);
		$query = $this->db->get('Work');
		return $query;
	}

	function deleteMasterMediaFile($fileId)
	{
		$this->db->delete('TDS_MediaFile', array('fileId' => $fileId)); 
		return true;
	}

	function deleteLocalMediaFile($mediaId)
	{
		$this->db->delete('TDS_workPromotionMedia', array('mediaId' => $mediaId)); 
		return true;
	}
	
	function restoreRecord($workId, $workType)
	{
		$fieldworkId = 'workId';
		$fieldworkType = 'workType';
		$this->db->where($fieldworkId,$workId);
		$this->db->where($fieldworkType,$workType);
		$this->db->set('workArchived','f');
		$this->db->set('isPublished','t');
		$this->db->update('Work');
		return true;
	}

	function saveworkPromotionMedia($insertData)
	{
		$this->db->insert('workPromotionMedia' , $insertData);
		return $this->db->insert_id();
		
	}

	function updateworkImage($workData,$workId)
	{
		$field = 'workId';
		$this->db->where($field,$workId);
		$this->db->update('Work',$workData);
		return true;
	}

	function updateworkPromotionVideo($updateData)
	{
		$this->db->where('workId',$updateData->workId);
		$this->db->where('workPrmotionMediaType','video');
		$this->db->update('workPromotionMedia' , $updateData);
		return true;
	}

	function insertworkPromotionVideo($insertData)
	{
		$this->db->insert('workPromotionMedia' , $insertData);
		$lastId =  $this->db->insert_id();

		$thisVideoId->workVideoId = $lastId; // Keeping the Video Id into the work table
		$workId = $insertData->workId;
		$this->db->where('workId',$workId);
		$this->db->update('Work' , $thisVideoId);
		return true;
	}

	function checkVideoCount($workId,$workType)
	{
		$fieldworkId = 'workId';
		$fieldworkCategory = 'workCategory';
		$this->db->where($fieldworkId,$workId);
		$this->db->where($fieldworkCategory,$workType);
		$this->db->where('workPrmotionMediaType','video');
		$getworkPromotionMedia = $this->db->get('workPromotionMedia');
		//echo $this->db->last_query();
		return $getworkPromotionMedia->num_rows();
	}

	function getVideoDetail($videoId,$productType)
	{		
		$table = 'workPromotionMedia';
		$field = 'mediaId';
		$fieldproductType = 'mediaType';
		$this->db->where($field,$videoId);
		$this->db->where($fieldproductType,$productType);
		$this->db->join('MediaFile', 'MediaFile.fileId = '.$table.'.fileId');
		$dataProduct = $this->db->get($table);
		
		//echo $this->db->last_query();
		return $dataProduct->row();
	}

	function updatePromotionImageStatus($workId,$workCategory)
	{
		$fieldworkCategory = 'workCategory';
		$this->db->where($fieldworkCategory,$workCategory);
		$this->db->where('workPrmotionMediaType','image');
		$this->db->where("workId", $workId);
		$this->db->limit(1);
		$query = $this->db->get('workPromotionMedia');
		$result =  $query->row();
		if(!empty($result)){
		$idToBeUpdated = $result->workPromotionMediaId;

		$this->db->set("workPromotionMediaStatus", 't');
		$this->db->where("workPromotionMediaId", $idToBeUpdated);
		$this->db->update("workPromotionMedia");

		$thiswork->workImageId = $idToBeUpdated;
		$field = 'workId';
		$this->db->where($field,$workId);
		$this->db->update('Work',$thiswork);		
			return true;
		}
		else
		{
			return false;
		}
	}

	function chcekForFeaturedImage($workId,$workCategory)
	{
		$fieldworkId = 'workId';
		$fieldworkCategory = 'workCategory';
		$fieldworkPromotionMediaStatus = 'workPromotionMediaStatus';
		$this->db->where($fieldworkId,$workId);
		$this->db->where($fieldworkCategory,$workCategory);
		$this->db->where('workPrmotionMediaType','image');
		$this->db->where($fieldworkPromotionMediaStatus,'t');
		$getworkPromotionMediaStatus = $this->db->get('workPromotionMedia');
		//
		$result =  $getworkPromotionMediaStatus->row();
		return $result->workPromotionMediaId;
	}

	function getImageDetail($workPromotionMediaId)
	{
		$fieldworkPromotionMediaId = 'workPromotionMediaId';
		$this->db->where('workPrmotionMediaType','image');
		$this->db->where($fieldworkPromotionMediaId,$workPromotionMediaId);

		$workworkPromotionMedia = $this->db->get('workPromotionMedia');
		return $workworkPromotionMedia->row();
	}
		
	function deleteworkPromotionMedia($workPromotionMediaId)
	{		
		$table = 'workPromotionMedia';
		$field = 'workPromotionMediaId';
		$this->db->where($field,$workPromotionMediaId);
		$this->db->delete($table);
		return true;
	}

	function chcekworkPromotionMediaExists($workPromotionMediaId,$workType)
	{
		$fieldworkPromotionMediaId = 'workPromotionMediaId';
		$fieldworkType = 'workCategory';
		$this->db->where($fieldworkType,$workType);
		$this->db->where('workPrmotionMediaType','image');
		$this->db->where($fieldworkPromotionMediaId,$workPromotionMediaId);
		$workworkPromotionMedia = $this->db->get('workPromotionMedia');
		if($workworkPromotionMedia->num_rows()<1)
		{
			return 0; // no record
		}
		else
		{
			return 1; // Having one record
		}
	}

	function chcekFeaturedImageChangeStatus($workId)
	{
		$fieldworkId = 'workId';
		$fieldworkPromotionMediaStatus = 'workPromotionMediaStatus';
		$this->db->where($fieldworkId,$workId);
		$this->db->where($fieldworkPromotionMediaStatus,'t');
		$getworkPromotionMediaStatus = $this->db->get('workPromotionMedia');
		//
		$result =  $getworkPromotionMediaStatus->row();
		//echo "<pre>"; print_r($result); die;
		$toBeupdatedImageId = $result->workPromotionMediaId;
		
		$this->workPromotionMediaStatus = 'f';
		$field = 'workPromotionMediaId';
		$this->db->where($field,$toBeupdatedImageId);
		$this->db->update('workPromotionMedia',$this);
		
		return true;
	}

	function changeworkPromotionMediaStatus($workPromotionMediaId,$workId)
	{
		$this->workPromotionMediaStatus = 't';
		$field = 'workPromotionMediaId';
		$this->db->where($field,$workPromotionMediaId);
		$this->db->update('workPromotionMedia',$this);

		$thiswork->workImageId = $workPromotionMediaId;
		$field = 'workId';
		$this->db->where($field,$workId);
		$this->db->update('Work',$thiswork);
	}
	/**
		* updateWorkOffered method Inserts a record in the "work" table.
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

	function updateWorkOffered($fileName)
	{
		//	echo "<pre />"; print_r($_POST);
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
		  
		 $updateWorkOffered = array(
				'workTitle'=>$this->input->post('workTitle'),
				'workType'=>$this->input->post('workType'),
				'workTypeDesc'=>$this->input->post('workTypeDesc'),
				'workOneLineDesc'=>$this->input->post('workOneLineDesc'),
				'workTagWords'=>$this->input->post('workTagWords'),
				'workDesc'=>$this->input->post('workDesc'),
				'workLocation'=>$this->input->post('workCountryId'),
				'workCity'=>$this->input->post('workCity'),
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
				if($fileName=='') unset($updateWorkOffered['workVideo']);
			}
		$workOfferedId = $this->input->post('workOfferedId');
	
		$field = 'workId';
		$this->db->where($field,$workOfferedId);
		$this->db->update($this->tablework,$updateWorkOffered);
		return $workOfferedId;		
	}

	/**
		* Preview for work wanted
	**/
	function workOfferedPreview($workId)
	{
		$workPreviewData = $this->workOfferedForm($workId);
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
		$recordsLanguage = $this->db->get('Language');	
		$language = $recordsLanguage->result();
		return $language;		
	}

	
	/**
		* Fetches all the reviews of logged in user
		* ****** Note: For now I have taken UserId as '1' ******
	**/
	function reviews()
	{ 
		$field = 'UserId';
		$UserId = 1;	
		$this->db->where($field,$UserId);	
		$reviewData = $this->db->get($this->tabelreviews);	
		return	$reviewData->result();
	}

	/**
		* Function  to renew the expiry date of work
	**/
	function renew($workId)
	{	
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
		
		$expiryUpdateQuery = 'UPDATE "'.$this->tablework.'"  set "workExpiryDate" = "workExpiryDate"+ cast(\''.$renewDays.'\' as interval) WHERE "'.$field.'" ='.$workId.'';
		
		$this->db->query($expiryUpdateQuery);
		
	}//End Function renew

	function getImages($imageId,$workType)
	{
		$table = 'workPromotionMedia';
		$field = 'workId';
		$fieldworkType = 'mediaType';
		$this->db->where($field,$imageId);
		$this->db->where($fieldworkType,1);
		$this->db->order_by('isMain','desc');
		$datawork = $this->db->get($table);
		//echo $this->db->last_query();
		return $datawork->result();
	}

	function workRecordSet($workId,$workType)
	{	
		$table = 'Work';
		$field = 'workId';
		$workTypeField = 'workType';
		$this->db->where($field,$workId);
		$this->db->where($workTypeField,$workType);
		$datawork = $this->db->get($table);
		echo ' ';
		return $datawork->row();
	}
	
	function getWorks($workType='offered')
	{	
		$this->db->select($this->tablework.'.workId,'.$this->tablework.'.tdsUid,workTitle,workType,isPublished,isUrgent,workExperiece,workExpireDate,workPublisheDate,workCreateDate,workIndustryId,workShortDesc,workTag,workRemuneration');
		$this->db->select('MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,MediaFile.fileType');
		$this->db->join("workPromotionMedia", "workPromotionMedia.workId = Work.workId", 'left');
		$this->db->join("MediaFile", "MediaFile.fileId = workPromotionMedia.fileId", 'left');
		$field = 'workType';
		$this->db->where('workPromotionMedia.isMain','t');
		$this->db->where('workArchived','f');
		$this->db->where($field,$workType);
		$this->db->where('isPublished','t');
		//$this->db->where('workExpireDate >=',date('Y-m-d'));	
		$this->db->order_by('workModifiedDate', 'desc');
		$workWantedQuery =  $this->db->get($this->tablework);	
		//echo $this->db->last_query();	print_r($workWantedQuery->result());die;
		return $workWantedQuery->result_array();	
	}
	
	function getworkdetail($userId=0,$workId=0,$workType='offered',$isPublished=0,$isArchive='f',$offset=0,$limit=0)
	{	
		$workPromotionMedia = $this->db->dbprefix('workPromotionMedia');
		$this->db->select($this->tablework.'.workId,'.$this->tablework.'.workLang1,'.$this->tablework.'.workCountryId,'.$this->tablework.'.tdsUid,workTitle,workType,'.$this->tablework.'.isPublished,isUrgent,workExperiece,workExpireDate,workPublisheDate,workCreateDate,workIndustryId,workShortDesc,workTag,workRemuneration,workTypeDesc,workCompany,workRenumUnit,workArchived,'.$this->tablework.'.isExpired,'.$this->tablework.'.isBlocked');
		$this->db->select('MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,MediaFile.fileType');
		$this->db->select($this->UserShowcase.'.optionAreaName,'.$this->UserShowcase.'.enterprise,'.$this->UserShowcase.'.enterpriseName');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');	
		$this->db->select($this->MasterLang.'.Language_local');
		$this->db->select($this->MasterCountry.'.countryName');
		$this->db->select($this->MasterIndustry.'.IndustryName');
		$this->db->select($this->tableUserContainer.'.*');
		
		$this->db->join($workPromotionMedia, "".$workPromotionMedia.".workId = ".$this->tablework.".workId and \"".$workPromotionMedia."\".\"isMain\"='t'", 'left');
		$this->db->join("MediaFile", "MediaFile.fileId = workPromotionMedia.fileId", 'left');
		$this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->tablework.".tdsUid", 'left');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tablework.".tdsUid", 'left');
		$this->db->join($this->MasterLang, $this->MasterLang.".langId = ".$this->tablework.".workLang1", 'left');		
		$this->db->join($this->MasterCountry, $this->MasterCountry.".countryId = ".$this->tablework.".workCountryId", 'left');
		$this->db->join($this->MasterIndustry, $this->MasterIndustry.".IndustryId = ".$this->tablework.".workIndustryId", 'left');
		$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->tablework.".userContainerId", 'left');
		
		$field = 'workType';
		$this->db->where('workArchived',$isArchive);
		
		if($userId>0)
			$this->db->where($this->tablework.'.tdsUid',$userId);
		
		if($workId>0)
			$this->db->where($this->tablework.'.workId',$workId);
			
		$this->db->where($this->tablework.'.workType',$workType);
		
		if($isPublished==0)
		$this->db->where($this->tablework.'.isPublished','t');
		
		//$this->db->where('workExpireDate >=',date('Y-m-d'));	
		$this->db->order_by('workModifiedDate', 'desc');
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		} 
		
		$workWantedQuery =  $this->db->get($this->tablework);	
		//echo $this->db->last_query();	
		return $workWantedQuery->result_array();	
	}
	
	
   /**
	    *Get classfied of user
	     
	**/
	
/*	function getUserClassfied($userId)
	{
		$this->db->select('workId,workTitle');
		$this->db->where('workArchived','f');
		$this->db->where('tdsUid',$userId);
		$this->db->order_by('workId','asc');
		$query =  $this->db->get($this->tablework);	
		$result = $query->result();
		
		return $result;	
		
		
	}  */	
	
	
	function getUserClassfied($userId)
	{
		$field = 'workType'; 
		$this->db->distinct();
		$this->db->select($this->tablework.'.workId ,'.$this->tablework.'.workTitle');
		$this->db->join($this->tabelWorkApplication,$this->tabelWorkApplication.".workId = ".$this->tablework.".workId");
		$this->db->where('workArchived','f');
		//$this->db->where($field,'offered');
		$this->db->where($this->tablework.'.tdsUid',$userId);
		$this->db->order_by($this->tablework.'.workId','asc');
		$this->db->order_by($this->tablework.'.workId ,'.$this->tablework.'.workTitle');
		$query =  $this->db->get($this->tablework);	
		//echo $this->db->last_query();die;
		$result = $query->result();			
		
		return $result;	
		
		
		}
		
		
	/*
	 * Get Work data listing
	 */
	function getworkData($userId=0,$workId=0,$workType='',$isPublished=0,$isArchive='f',$offset=0,$limit=0)
	{	
		$workPromotionMedia = $this->db->dbprefix('workPromotionMedia');
		$this->db->select($this->tablework.'.workId,'.$this->tablework.'.workLang1,'.$this->tablework.'.workCountryId,'.$this->tablework.'.tdsUid,workTitle,workType,'.$this->tablework.'.isPublished,isUrgent,workExperiece,workExpireDate,workPublisheDate,workCreateDate,workIndustryId,workShortDesc,workTag,workRemuneration,workTypeDesc,workCompany,workRenumUnit,workArchived,'.$this->tablework.'.isExpired,'.$this->tablework.'.isBlocked');
		$this->db->select('MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,MediaFile.fileType');
		$this->db->select($this->UserShowcase.'.optionAreaName');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');	
		$this->db->select($this->MasterLang.'.Language_local');
		$this->db->select($this->MasterCountry.'.countryName');
		$this->db->select($this->MasterIndustry.'.IndustryName');
		$this->db->select($this->tableUserContainer.'.*');
		
		$this->db->join($workPromotionMedia, "".$workPromotionMedia.".workId = ".$this->tablework.".workId and \"".$workPromotionMedia."\".\"isMain\"='t'", 'left');
		$this->db->join("MediaFile", "MediaFile.fileId = workPromotionMedia.fileId", 'left');
		$this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->tablework.".tdsUid", 'left');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tablework.".tdsUid", 'left');
		$this->db->join($this->MasterLang, $this->MasterLang.".langId = ".$this->tablework.".workLang1", 'left');		
		$this->db->join($this->MasterCountry, $this->MasterCountry.".countryId = ".$this->tablework.".workCountryId", 'left');
		$this->db->join($this->MasterIndustry, $this->MasterIndustry.".IndustryId = ".$this->tablework.".workIndustryId", 'left');
		$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->tablework.".userContainerId", 'left');
		
		$field = 'workType';
		$this->db->where('workArchived',$isArchive);
		
		if($userId>0)
			$this->db->where($this->tablework.'.tdsUid',$userId);
		
		if($workId>0)
			$this->db->where($this->tablework.'.workId',$workId);
			
		if(!empty($workType))	
		$this->db->where($this->tablework.'.workType',$workType);
		
		if($isPublished==0)
		$this->db->where($this->tablework.'.isPublished','t');
		
		// $this->db->where('workExpireDate >=',date('Y-m-d'));	
		$this->db->order_by('workModifiedDate', 'desc');
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		} 
		
		$workResultQuery =  $this->db->get($this->tablework);	
		return $workResultQuery->result_array();	
	}
	
	
	
	
	
}//End Class
?>
