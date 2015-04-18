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
class model_upcomingfrontend extends CI_Model {
	private $tableName = 'UpcomingProject';
	
	private $MasterLang      = 'MasterLang';
	private $MasterCountry   = 'MasterCountry';
	private $UserShowcase	 = 'UserShowcase';
	private $UserProfile	 = 'UserProfile';
	private $MasterIndustry	 = 'MasterIndustry';
	private $tableLogSummary = 'LogSummary';
	private $tableMasterRating = 'MasterRating';	
	
	function __construct()
	{
		parent::__construct();
	}

	function getValuesFromUpcomingProjects($userId=0,$ispublished=0,$fetchFields="*",$excludeUserID=0)
	{
		
			
		$this->db->select($fetchFields);
		if($excludeUserID==0) $this->db->where('tdsUid',$userId);
		$this->db->where('UpcomingProject.projArchived','f');
		if($ispublished==1)
		$this->db->where('UpcomingProject.isPublished','t');
		$this->db->order_by('projModifiedDate','desc');
		$query = $this->db->get('UpcomingProject');
	//	echo $this->db->last_query();die;
		return $query->result_array();
	}
	
	function getValueToUpdate($projId=0,$userId=0,$ispublished=0,$fetchFields="*")
	{
		
				
		$this->db->select($fetchFields);
		$this->db->where('tdsUid',$userId);
		$this->db->where('projId',$projId);
		if($ispublished==1)
		$this->db->where('UpcomingProject.isPublished','t');
		$query = $this->db->get('UpcomingProject');
		return $query->row();
	}
	
	function getupcomingdetail($userId=0,$projId=0,$isPublished=0,$isArchive='f',$offset=0,$limit=0,$projIndustry='')
	{	
		$tableProject = $this->db->dbprefix('UpcomingProject');
		$tableProjectMedia = $this->db->dbprefix('UpcomingProjectMedia');
	
        $entityId           =   getMasterTableRecord($tableProject);	// get entityId of project table
		$tableLogSummary    =   $this->db->dbprefix($this->tableLogSummary); // get db prefix
		
		$this->db->select($this->tableName.'.projId,'.$this->tableName.'.tdsUid,projTitle,proShortDesc,projTag,projDescription,projGenre,projLanguage,projCreateDate,projIndustry,projCountry,projCity,askForDonation,projReleaseDate,projAddress,projZip,projAddress2,thumbFileId,projUpType,projGenreFree,projArchived,'.$this->tableName.'.isPublished,projModifiedDate,projType,'.$this->tableName.'.rating,projArchived,'.$this->tableName.'.isExpired,'.$this->tableName.'.isBlocked');
		$this->db->select('MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,MediaFile.fileType');
		$this->db->select($this->UserShowcase.'.optionAreaName,'.$this->UserShowcase.'.enterprise,'.$this->UserShowcase.'.enterpriseName');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');	
		$this->db->select($this->MasterLang.'.Language_local');
		$this->db->select($this->MasterCountry.'.countryName');
		$this->db->select($this->tableMasterRating.'.otpion as ratingOption');
		$this->db->select($this->MasterIndustry.'.IndustryName');
		$this->db->select($tableProjectMedia.'.mediaTitle');
		$this->db->select($this->tableLogSummary.'.*');
		
		$this->db->join($tableProjectMedia, $tableProjectMedia.".projId =".$tableProject.".projId AND \"".$tableProjectMedia."\".\"isMain\"='t' ", 'left');
		$this->db->join("MediaFile", "MediaFile.fileId = ".$tableProjectMedia.".fileId", 'left');
		$this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->tableName.".tdsUid", 'left');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableName.".tdsUid", 'left');
		$this->db->join($this->MasterLang, $this->MasterLang.'.langId = CAST("'.$tableProject.'"."projLanguage" as int)', 'left');		
		$this->db->join($this->MasterCountry, $this->MasterCountry.".countryId = ".$this->tableName.".projCountry", 'left');
		$this->db->join($this->tableMasterRating, $this->tableMasterRating.".ratId = ".$this->tableName.".rating", 'left');
		$this->db->join($this->MasterIndustry, $this->MasterIndustry.'.IndustryId = CAST("'.$tableProject.'"."projIndustry" as int)', 'left');
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$tableProject.'.projId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
       
		//$this->db->where($tableProjectMedia.'.isMain','t');
		$this->db->where('projArchived',$isArchive);
		
		if($userId>0) $this->db->where($tableProject.'.tdsUid',$userId);
		if($projId>0) $this->db->where($tableProject.'.projId',$projId);
		
		if($isPublished == 1) {
			$this->db->where($tableProject.'.isPublished','t');
		} elseif($isPublished == 2) {
			$this->db->where($tableProject.'.isPublished','f');
		}
		
		if(!empty($projIndustry)) $this->db->where($tableProject.'.projIndustry',$projIndustry);
		
		$this->db->order_by('projModifiedDate', 'desc');
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		} 
		
		$UpcomingProjectQuery =  $this->db->get($tableProject);	
		
		//echo $this->db->last_query();	print_r($UpcomingProjectQuery->result());die;
		
		return $UpcomingProjectQuery->result_array();	
	}
	
}
?>
