<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
/*
	 Description:
	 * The model_upcommingproject class is meant to handle the processing of the Blog section
	 * It include functionality to fetch/add/edit Blog content for logged in user 
	 * @package	Toadsquare
	 * @subpackage	Module
	 * @category	Controller
	 * Author Name: Gurutva Singh
*/
class model_upcomingprojects extends CI_Model {
	private $tableName = 'UpcomingProject';
	private $MasterLang = 'MasterLang';
	private $MasterCountry = 'MasterCountry';
	private $UserShowcase	= 'UserShowcase';
	private $UserProfile	= 'UserProfile';
	private $MasterIndustry	= 'MasterIndustry';
	private $tableUserContainer	= 'UserContainer';
	function __construct()
	{
		parent::__construct();
		$this->userId = $this->isLoginUser();
	}

	function insertRecord($table,$data)
	{
		unset($data['mediaId']);
		$data['projCreateDate'] = date("Y-m-d H:i:s");
		$data['projModifiedDate'] = date("Y-m-d H:i:s");
		$this->db->insert($table, $data);
		$upcomingProjectId =  $this->db->insert_id();
		addDataIntoLogSummary('UpcomingProject',$upcomingProjectId);
		return $upcomingProjectId;
	}

	function updateRecord($table, $data, $where)
	{
		$data['projModifiedDate'] = date("Y-m-d H:i:s");
		unset($data['isPublished']);
		$this->db->update($table, $data, $where);
		return $data['projId'];
	}

	function getValuesFromUpcomingProjects($userId=0,$ispublished=0,$fetchFields="*")
	{
		
		if(!isset($userId) || $userId==0 || $userId=='')
			$userId = $this->userId;
		
		$this->db->select($fetchFields);
		$this->db->where('tdsUid',$userId);
		$this->db->where('UpcomingProject.projArchived','f');
		if($ispublished==1)
		$this->db->where('UpcomingProject.isPublished','t');
		$this->db->order_by('projModifiedDate','desc');
		$query = $this->db->get('UpcomingProject');
	//	echo $this->db->last_query();die;
		return $query->result_array();
	}
	
	function deletedItems($userId)
	{
		$this->db->where('tdsUid',$userId);
		$this->db->where('UpcomingProject.projArchived','t');
		$query = $this->db->get('UpcomingProject');
		return $query->result_array();
	}

	function getValueToUpdate($projId=0,$userId=0,$ispublished=0,$fetchFields="*")
	{
		
		if(!isset($userId) || $userId==0 || $userId=='')
			$userId = $this->userId;
			
		$this->db->select($fetchFields);
		$this->db->where('tdsUid',$userId);
		$this->db->where('projId',$projId);
		if($ispublished==1)
		$this->db->where('UpcomingProject.isPublished','t');
		$query = $this->db->get('UpcomingProject');
		return $query->row();
	}

	function deleteUpcomingProejctMedia($projId)
	{
		$this->db->delete('UpcomingProjectMedia', array('projId' => $projId)); 
	}
	
	function deleteUpcomingProejct($projId)
	{
		$fieldprojId = 'projId';
		$this->db->where($fieldprojId,$projId);
		$this->db->set('projArchived','t');
		$this->db->update('UpcomingProject');
		//$this->db->delete('UpcomingProject', array('projId' => $projId)); 
	}

	function deletePermanently($projId)
	{
		//Check for the Media exists
		$result = $this->checkMediaExists($projId);

		if($result->num_rows() > 0)
		{
			$mediaId = $result->result();
		}else{
			$mediaId = 0;
		}

		if(is_array($mediaId)){
			
			foreach($mediaId as $id){
				$fileId = $this->getMediaFileId($id->mediaId);

				$this->deleteLocalMediaFile($id->mediaId);

				$this->deleteMasterMediaFile($fileId);
			}
		}
		$this->db->delete('UpcomingProject', array('projId' => $projId)); 
		return true;
	}

	function getMediaFileId($mediaId)
	{
		$this->db->select('fileId');
		$this->db->where('mediaId',$mediaId);
		$query = $this->db->get('TDS_UpcomingProjectMedia');
		return $query->row()->fileId;
	}

	function checkMediaExists($projId)
	{
		$this->db->where('projId',$projId);
		$query = $this->db->get('TDS_UpcomingProjectMedia');
		return $query;
	}

	function deleteMasterMediaFile($fileId)
	{
		$this->db->delete('TDS_MediaFile', array('fileId' => $fileId)); 
		return true;
	}

	function deleteLocalMediaFile($mediaId)
	{
		$this->db->delete('TDS_UpcomingProjectMedia', array('mediaId' => $mediaId)); 
		return true;
	}

	function restoreRecord($projId)
	{
		$fieldprojId = 'projId';
		$this->db->where($fieldprojId,$projId);
		$this->db->set('projArchived','f');
		$this->db->update('UpcomingProject');
		return true;
	}

	function deleteTest($id)
	{
		$this->db->delete('MediaFile', array('fileId' => $id->fileId)); 
	}

	function projectPromotionMedia($projId,$mediaType,$flag)
	{
		$table = 'UpcomingProjectMedia';
		$field = 'projId';
		$fieldmediaType = 'mediaType';
		$this->db->join('MediaFile','MediaFile.fileId = UpcomingProjectMedia.fileId');
		$this->db->where($field,$projId);
		if($flag =='')
			$this->db->where($fieldmediaType,$mediaType);
		else
			$this->db->where('mediaType !=',$mediaType);
			
		$this->db->order_by('TDS_UpcomingProjectMedia.mediaId','desc');
		$dataProject = $this->db->get($table);
		//echo $this->db->last_query();
		//echo "<pre />"; print_r($dataProject->result());
		return $dataProject->result();
	}

	function getDetailToDelete($projId)
	{
		$tableProject = 'UpcomingProject';
		$tableProjectMedia = 'UpcomingProjectMedia';
		$tableMediaFile = 'MediaFile';
		$field = 'UpcomingProjectMedia.projId';
		$fieldnew = 'UpcomingProject.projId';

		$this->db->select('MediaFile.fileId,MediaFile.fileName,MediaFile.filePath');
		$this->db->join('UpcomingProjectMedia','UpcomingProject.projId = UpcomingProject.projId');
		$this->db->join('MediaFile','MediaFile.fileId = UpcomingProjectMedia.fileId');
		
		$this->db->where($field,$projId);
		$this->db->where($fieldnew,$projId);

		$dataProject = $this->db->get($tableProject);

		return $dataProject->result();
	}

		
	function getupcomingdetail($userId=0,$projId=0,$isPublished=0,$isArchive='f',$offset=0,$limit=0)
	{	
		$tableProject = $this->db->dbprefix('UpcomingProject');
		$tableProjectMedia = $this->db->dbprefix('UpcomingProjectMedia');
		
		
		$this->db->select($this->tableName.'.projId,'.$this->tableName.'.tdsUid,projTitle,proShortDesc,projTag,projDescription,projGenre,projLanguage,projCreateDate,projIndustry,projCountry,projCity,projReleaseDate,projAddress,projZip,projAddress2,projUpType,projGenreFree,projArchived,'.$this->tableName.'.isPublished,projModifiedDate,projType,'.$this->tableName.'.rating,projArchived,'.$this->tableName.'.isExpired,'.$this->tableName.'.isBlocked');
		$this->db->select('MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,MediaFile.fileType');
		$this->db->select($this->UserShowcase.'.optionAreaName,'.$this->UserShowcase.'.enterprise,'.$this->UserShowcase.'.enterpriseName');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');	
		$this->db->select($this->MasterLang.'.Language_local');
		$this->db->select($this->MasterCountry.'.countryName');
		$this->db->select($this->MasterIndustry.'.IndustryName');
		$this->db->select($this->tableUserContainer.'.*');
		
		$this->db->join($tableProjectMedia, $tableProjectMedia.".projId =".$tableProject.".projId AND \"".$tableProjectMedia."\".\"isMain\"='t' ", 'left');
		$this->db->join("MediaFile", "MediaFile.fileId = ".$tableProjectMedia.".fileId", 'left');
		$this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->tableName.".tdsUid", 'left');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableName.".tdsUid", 'left');
		$this->db->join($this->MasterLang, $this->MasterLang.'.langId = CAST("'.$tableProject.'"."projLanguage" as int)', 'left');		
		$this->db->join($this->MasterCountry, $this->MasterCountry.".countryId = ".$this->tableName.".projCountry", 'left');
		$this->db->join($this->MasterIndustry, $this->MasterIndustry.'.IndustryId = CAST("'.$tableProject.'"."projIndustry" as int)', 'left');
		$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->tableName.".userContainerId", 'left');
		
		//$this->db->where($tableProjectMedia.'.isMain','t');
		$this->db->where('projArchived',$isArchive);
		
		if($userId>0) $this->db->where($tableProject.'.tdsUid',$userId);
		if($projId>0) $this->db->where($tableProject.'.projId',$projId);
		
		//if($isPublished==0)
		 //$this->db->where($tableProject.'.isPublished','t');
		
		$this->db->order_by('projModifiedDate', 'desc');
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		} 
		
		$UpcomingProjectQuery =  $this->db->get($tableProject);	
		
		//echo $this->db->last_query();	print_r($UpcomingProjectQuery->result());die;
		
		return $UpcomingProjectQuery->result_array();	
	}

	function getFileId($mediaId, $projId)
	{
		$this->db->where('mediaId',$mediaId);
		$this->db->where('projId',$projId);
		$query = $this->db->get('UpcomingProjectMedia');
		return $query->row()->fileId;
	}

	function deleteRow($table,$where)
	{
		$this->db->delete($table, $where);
		return true;
	}

	function getImages($mediaId,$projId,$mediaType)
	{
		//$fileId = $this->getFileId($mediaId, $projId);
		$table = 'UpcomingProjectMedia';
		$field = 'projId';
		$fieldworkType = 'workPrmotionMediaType';
		$this->db->where($field,$imageId);
		$this->db->where($fieldworkType,$workType);
		$this->db->order_by('workPromotionMediaStatus','desc');
		$datawork = $this->db->get($table);
		//echo $this->db->last_query();
		return $datawork->result();
	}

	function getVideoDetail($videoId,$productType)
	{
		$table = 'UpcomingProjectMedia';
		$field = 'mediaId';
		$fieldproductType = 'mediaType';
		$this->db->where($field,$videoId);
		$this->db->where($fieldproductType,$productType);
		$this->db->join('MediaFile', 'MediaFile.fileId = '.$table.'.fileId');
		$dataProduct = $this->db->get($table);
		//echo $this->db->last_query();
		return $dataProduct->row();
	}
	
	}
?>
