<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	 * Description:
	 * The model_workprofile class is meant to handle the processing of Work Profile section
	 * It include functionality to fetch/add/edit Videos,Images,Written Materials and Audios 
	 Author Name: Gurutva Singh
	 Date Created: 7 Februray 2012
	 Date Modified: 9 Februray 2012 	
*/
class model_workprofile extends CI_Model {

	private $tabelWorkprofile = 'WorkProfile';
	private $tableProfileSocialLink = 'profileSocialLink';
	private $tableProfileEmpHistory = 'profileEmpHistory';
	private $tableProfileRecommendation = 'profileRecommendation';
	private $tableUserContacts = 'UserProfile';
	private $tableUserAuth = 'UserAuth';
	private $tableprofileSocialMediaIcon = 'profileSocialMediaIcon';
	private $education = 'WorkProfileEducation';
	private $visaType = 'WorkProfileVisa';
	
	private $MasterLang = 'MasterLang';
	private $MasterCountry = 'MasterCountry';
	private $UserProfile	= 'UserProfile';
	private $UserShowcase	= 'UserShowcase';
	private $MasterIndustry	= 'MasterIndustry';
	private $MediaFile	= 'MediaFile';
	private $tableUserContainer	= 'UserContainer';
	private $tableRecommendation = 'Recommendations';	
	
	
	// Constructor
	function __construct()
	{
		parent::__construct();
	}

	function index($userId)
	{
		//$userId = 1;
		$field = 'tdsUid';
		$this->db->where($field,$userId);
		$workProfileResult = $this->db->get($this->tabelWorkprofile);
		return $workProfileResult->row();
	}

	/**
		* getWorkProfileID method fetches the workProfileId form WorkProfile on the basis of logged in userId
		* giving the ID in the options object priority.
		*
		* @param NULL
		* @return Object
	*/
	function getWorkProfileID($userId)
	{
		$workProfileResultID = $this->model_common->getDataFromTabel($this->tabelWorkprofile, 'workProfileId',  'tdsUid', (int)$userId, '', 'ASC', 0 );
		if($workProfileResultID!='')
			return $workProfileResultID;
		else
			return FALSE;
	}

	/**
		* WorkEmpHistory method fetches the Emp history record form ProfileEmpHistory on the basis of logged in userId
		* @param userId
		* @return Object
	*/

	function WorkEmpHistory($userId)
	{		
		$userWorkProfileID  = $this->getWorkProfileID($userId);
		if(empty($userWorkProfileID))  
		{
			$Upload_File_Name['error'] = 'Please Fill the Personal Information First';
			set_global_messages($Upload_File_Name['error'], 'error');
			//$this->workprofileMsg = '';
			redirect('workprofile/workProfileForm');
		}
		else {
			$workProfileId = $userWorkProfileID[0]->workProfileId;
			$field = 'workProfileId';
			$this->db->where($field,$workProfileId);
			$this->db->order_by('position','asc');
			$workEmpHistory = $this->db->get($this->tableProfileEmpHistory);
			return $workEmpHistory->result();
		}
	}

	function WorkReferenceRecommendation($userId)
	{		
		$userWorkProfileID  = $this->getWorkProfileID($userId);
		if(empty($userWorkProfileID))  
		{
			$Upload_File_Name['error'] = 'Please Fill the Personal Information First';
			set_global_messages($Upload_File_Name['error'], 'error');
			//$this->workprofileMsg = '';
			redirect('workprofile/workProfileForm');
		}
		else {
			$workProfileId = $userWorkProfileID[0]->workProfileId;
			$field = 'workProfileId';
			$this->db->where($field,$workProfileId);
			$this->db->order_by('position','asc');
			$workReferenceRecommendation = $this->db->get($this->tableProfileRecommendation);
			return $workReferenceRecommendation->result();
		}
	}

	/**
		* WorkProfileForm method fetches the records form WorkProfile
		* giving the values in the options array priority.
		*
		* @param int $workProfileId
		* @return array
	*/

	function workProfileForm($workProfileId,$userId)
	{ 
		if($workProfileId > 0 )
		{
			$recordSet = $this->workProfileRecordSet($workProfileId);
		
		
			$workProfile = array('profileStreet'=>$recordSet->profileStreet,
			'profileAdd'=>$recordSet->profileAdd,
			'profileLName'=>$recordSet->profileLName,
			'visaAvailable'=>$recordSet->visaAvailable,
			'profileZip'=>$recordSet->profileZip,
			'profileCity'=>$recordSet->profileCity,
			'profileEmail'=>$recordSet->profileEmail,
			'profilePhone'=>$recordSet->profilePhone,
			'synopsis'=>$recordSet->synopsis,
			'languagesKnown'=>$recordSet->languagesKnown,
			'nationality'=>$recordSet->nationality,
			'noticePeriod'=>$recordSet->noticePeriod,
			'remunerationRequired'=>$recordSet->remunerationRequired,
			'remunerationRate'=>$recordSet->remunerationRate,
			'education'=>$recordSet->education,
			'achievmentsAndAwards'=>$recordSet->achievmentsAndAwards,
			'fileId'=>$recordSet->fileId,
			'profileFName'=>$recordSet->profileFName,
			'availability'=>$recordSet->availability,
			'profileCountry'=>$recordSet->profileCountry,
			'profileState'=>$recordSet->profileState,
			'userContainerId'=>$recordSet->userContainerId,
			'containerSize'=>$recordSet->containerSize,
			'countriesInterestWorking'=>$recordSet->countriesInterestWorking,
			'minContractMonth'=>$recordSet->minContractMonth,
			'maxContractMonth'=>$recordSet->maxContractMonth,
			'isContractWork'=>$recordSet->isContractWork,
			);
			
			return $workProfile;
		
		}
		
		$table = $this->tabelWorkprofile;
		$field = 'workProfileId';
		$this->db->where($field,$workProfileId);
		$workProfileResult = $this->db->get($table);

		if($workProfileResult->num_rows()>0)
		{
			$workProfileResultData  = $workProfileResult->result_array();
		}
		else
		{
			$field = 'tdsUid';
			$this->db->where($field,$userId);
			$contactsData = $this->db->get($this->tableUserContacts);
			$contactsResultData = $contactsData->row();
			
			//To get Email Address
			$this->db->where($field,$userId);
			$contactsEmail = $this->db->get($this->tableUserAuth); 
			$contactsEmailResult = $contactsEmail->row();
			
			$workProfileResultData = array(
			'profileImgPath'=>$this->input->post('profileImgPath'),
			'profileFName'=>$contactsResultData->firstName,
			'profileLName'=>$contactsResultData->lastName,
			'profileAdd'=>$this->input->post('profileAdd'),
			'profileStreet'=>$this->input->post('profileStreet'),
			'profileZip'=>$this->input->post('profileZip'),
			'profileCountry'=>$contactsResultData->countryId,
			'profileCity'=>$contactsResultData->cityName,
			'profileEmail'=>$contactsEmailResult->email,
			/*'profileEmail'=>$this->input->post('profileEmail'),*/
			'profilePhone'=>$this->input->post('profilePhone'),
			'synopsis'=>$this->input->post('synopsis'),
			'languagesKnown'=>$this->input->post('languagesKnown'),
			'nationality'=>$this->input->post('nationality'),
			'visaAvailable'=>$this->input->post('visaAvailable'),
			'availability'=>$this->input->post('availability'),
			'education'=>$this->input->post('education'),
			'noticePeriod'=>$this->input->post('noticePeriod'),
			'remunerationRequired'=>$this->input->post('remunerationRequired'),
			'remunerationRate'=>$this->input->post('remunerationRate'),
			'achievmentsAndAwards'=>$this->input->post('achievmentsAndAwards'),
			'profileState'=>$this->input->post('profileState'),
			'fileId'=>$this->input->post('fileId')
	     );
		}
		return $workProfileResultData;	
	}

	function workProfileRecordSet($workProfileId)
	{
		$table = $this->tabelWorkprofile;
		$field = 'workProfileId';
		$this->db->select($this->tabelWorkprofile.'.*');
		$this->db->select($this->tableUserContainer.'.containerSize');
		$this->db->from($this->tabelWorkprofile);
		$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->tabelWorkprofile.".userContainerId", 'left');
		$this->db->where($field,$workProfileId);
		$workProfileResult = $this->db->get();
		$workProfileRecordSet = $workProfileResult->row();
		
		return $workProfileRecordSet;
	}

	/**
		* insertPost method Inserts a record in the WorkProfile table".
		*
	*/

	function insertWorkprofile($profileImgName,$profileImgPath,$data)
	{
		if($profileImgName!=''){
			$mediaInfo = array('filePath'=>$profileImgPath,
			'fileName'=>$profileImgName,
			'fileType'=>1
			);
			$this->db->insert('MediaFile', $mediaInfo); 
			$fileId = $this->db->insert_id();
			createthumbimages($profileImgPath,$profileImgName);
		}

		$data['fileId'] = (isset($fileId) && ($fileId > 0))?$fileId:0;

		if($profileImgPath ==''){
			unset($data['fileId']);
		}
		$field = 'empHistId';

		$this->db->insert($this->tabelWorkprofile, $data); 
		return $this->db->insert_id();
	}

	/**
		* updatePost method Update a record in the "WorkProfile" table.
	*/

	function updateWorkprofile($profileImgName,$profileImgPath,$data)
	{
		$fileId = $this->input->post('fileId');
		
		if($profileImgName!='')
		{
			$mediaInfo = array('filePath'=>$profileImgPath,
			'fileName'=>$profileImgName,
			'fileType'=>1
			);
			
			if($fileId > 0){
				$res=$this->model_common->getDataFromTabel('MediaFile', 'fileName,filePath',  'fileId', $fileId, '', 'ASC', 1 );
				if(isset($res[0]->fileName)){
					
					$fileDir=trim($res[0]->filePath);
					$fileName=trim($res[0]->fileName);
					if(is_dir($fileDir) && $fileName !=''){
						$fpLen=strlen($fileDir);
						if($fpLen > 0 && substr($fileDir,-1) != DIRECTORY_SEPARATOR){
							$fileDir=$fileDir.DIRECTORY_SEPARATOR;
						}
						findFileNDelete($fileDir,$fileName);
					}
					
					$this->db->where('fileId',$fileId);
					$this->db->update('MediaFile', $mediaInfo);
					$data['fileId'] = $fileId;
				}
				else{
					$this->db->insert('MediaFile', $mediaInfo);
					$data['fileId']= $this->db->insert_id();
				}
			}
			else{
				$this->db->insert('MediaFile', $mediaInfo);
				$data['fileId']= $this->db->insert_id();
			}
			
			createthumbimages($profileImgPath,$profileImgName);
		}
		
		$where = array('workProfileId' => $data['workProfileId']);
		if(!isset($data['fileId']) ||(isset($data['fileId']) && $data['fileId']=='')) unset($data['fileId']);
		if(isset($data['profileCountry']) && !$data['profileCountry'] > 0){
			$data['profileCountry']=0;
		}
		$this->model_common->editDataFromTabel($this->tabelWorkprofile,$data,$where);	

		$workProfileId = $this->input->post('workProfileId');
		return $workProfileId;
	}
	/**
		  *********** All functionalities related with Employment History ***********
	**/		
	function indexEmpHistory($EmpHistoryId)
	{			
		if($EmpHistoryId !=0){
			$empHistoryIdField = $EmpHistoryId;
			$table = $this->tableProfileEmpHistory;
			$field = 'empHistId';
			$this->db->where($field,$empHistoryIdField);
			$dataEmpHistory = $this->db->get($table);
			$dataEmpHistory = $dataEmpHistory->result_array();
			$dataEmpHistory = $dataEmpHistory[0];
		}  
		else{
			$dataEmpHistory['compName'] = '';
			$dataEmpHistory['empStartDate'] = '';
			$dataEmpHistory['empEndDate'] = '';
			$dataEmpHistory['compAdd'] = '';
			$dataEmpHistory['compCountry'] = '';
			$dataEmpHistory['compState'] = '';
			$dataEmpHistory['compCity'] = '';
			$dataEmpHistory['compZip'] = '';
			$dataEmpHistory['compDesc'] = '';
			$dataEmpHistory['empAchivments'] = '';
			$dataEmpHistory['empDesignation'] = '';
		}
		return $dataEmpHistory;	
	}

	/**
		* showWorkShowcaseVideos method fetches the records form Profile Media of Type Videos
		* giving the values in the options array priority.
		*
		* @param int $workProfileId
		* @return array
	*/

	function showEmpHistory($workProfileId){
		$table = $this->tableProfileEmpHistory;
		$field = 'workProfileId';
		$this->db->where($field,$workProfileId);
		$this->db->where('empArchived','f');
		$this->db->order_by('position','asc');
		$dataEmpHistory = $this->db->get($table);
		//echo $this->db->last_query();
		$dataEmpHistory = $dataEmpHistory->result_array();
		return $dataEmpHistory;
	}

	function checkTillDate($userId)
	{
		$userWorkProfileID  = $this->getWorkProfileID($userId);
		if(count($userWorkProfileID)==0) 
		{
			$workProfileId = 0; 
		}
		else 
		{
			$workProfileId = $userWorkProfileID[0]->workProfileId;
		}
		$field = 'empEndDate';
		$this->db->where($field,'0');
		$this->db->where('workProfileId',$workProfileId);
		$this->db->where('empArchived','f');
		$dataProfileEmpHistory = $this->db->get($this->tableProfileEmpHistory);
		$resultEmpHist = $dataProfileEmpHistory;
		if($resultEmpHist->num_rows()<1)
		{					
			return 0; // No till Date
		} 
		else
		{
			return 1;  // Already having a till date
		}
	}

	/**
		* showEmpHistoryPerRecord method fetches the records form Work Profile
		* giving the values in the options array priority.
		*
		* @param int $workProfileId
		* @return array
	*/

	function showEmpHistoryPerRecord($workProfileId=0){
	
		$table = $this->tableProfileEmpHistory;
		$field = 'workProfileId';
		$this->db->where($field,$workProfileId);
		$this->db->order_by('position','asc');
		$dataEmpHistory = $this->db->get($table);
		$dataEmpHistory = $dataEmpHistory->result_array();
		$dataEmpHistory['workProfileId'] = $workProfileId;
		return $dataEmpHistory;	
	}

	function empHistoryRecordSet($empHistoryId)
	{
		if($empHistoryId > 0){
			$table = $this->tableProfileEmpHistory;
			$field = 'empHistId';
			$this->db->where($field,$empHistoryId);
			$dataEmpHistory = $this->db->get($table);
			//echo "<pre />"; print_r($dataEmpHistory->row());
			return $dataEmpHistory->row();
		}
	}

	function showReferencesRecommendation($workProfileId){
		$table = $this->tableProfileRecommendation;
		$field = 'workProfileId';
		$this->db->where($field,$workProfileId);
		$this->db->where('refArchived','f');
		$this->db->order_by('position','asc');
		$dataReferencesRecommendations = $this->db->get($table);
		$dataReferencesRecommendationsResult = $dataReferencesRecommendations->result_array();
		return $dataReferencesRecommendationsResult;
	}

	function empReferencesRecommendationsRecordSet($empHistoryId)
	{
		if($empHistoryId > 0){
			$table = $this->tableProfileRecommendation;
			$field = 'refId';
			$this->db->where($field,$empHistoryId);
			$dataReferencesRecommendations = $this->db->get($table);
			//echo $this->db->last_query();
			return $dataReferencesRecommendations->row();
		}
	}
	
	function getPostion($table, $workProfileId)
	{
		$fieldworkProfileId = 'workProfileId';
		$this->workProfileId   = $workProfileId; 
		$this->db->select_max('position');
		$this->db->where($fieldworkProfileId,$workProfileId);
		$profileRecommendationMaxPosition = $this->db->get($table);
		$result = $profileRecommendationMaxPosition->row();
		return $result->position;
	}

	function deleteReferencesRecommendations($refId)
	{
		$fieldRefId = 'refId';
		$this->db->where($fieldRefId,$refId);
		$this->db->set('refArchived','t');
		$this->db->update($this->tableProfileRecommendation);
		//$this->db->delete($this->tableProfileRecommendation); 
		return true;
	}

	function deleteEmpHistory($empHistId)
	{
		$fieldempHistId = 'empHistId';
		$this->db->where($fieldempHistId,$empHistId);
		$this->db->set('empArchived','t');
		$this->db->update($this->tableProfileEmpHistory);
		//$this->db->delete($this->tableProfileEmpHistory); 
		return true;
	}

	/**
	  *********** All functionalities related with Social Media Links ***********
	**/

	function WorkSocialMedia($userId)
	{
		$joinTable = 'profileSocialMediaIcon';
		$userWorkProfileID  = $this->getWorkProfileID($userId);
		if(empty($userWorkProfileID))  
		{
			$Upload_File_Name['error'] = 'Please Fill the Personal Information First';
			set_global_messages($Upload_File_Name['error'], 'error');
			//$this->workprofileMsg = '';
			//redirect('workprofile/workProfileForm');
		}
		else {
			$workProfileId = $userWorkProfileID[0]->workProfileId;
			$field = 'entityId';
			$this->db->join('profileSocialMediaIcon', 'profileSocialMediaIcon.profileSocialMediaId = profileSocialLink.profileSocialLinkType');
			$this->db->where($field,$workProfileId);
			$this->db->where('socialLinkArchived','f');
			$this->db->order_by('position','asc');
			$workSocialMedia = $this->db->get($this->tableProfileSocialLink);
			return $workSocialMedia->result();
		}
	}

	function socialMediaIconList()
	{
		$SocialMediaIcon = $this->db->get($this->tableprofileSocialMediaIcon);
		return $SocialMediaIcon->result();
	}

	/**
		* Insert/Update a new row into the specified database table(ProfileSocialLink) from the common function
		* @access public
		* @data array
	**/	

	function saveSocialLinks($data)
	{		
		$field = 'profileSocialLinkId';
		foreach($data['profileSocialLinkId'] as $id =>$stats) {
		
			//echo $id; 
			$this->workProfileId   = $data['workProfileId']; 
			$this->profileSocialLinkType = $data['socialLinkType'][$id];
			$this->socialLink = $data['socialLink'][$id];
			
			if( $data['profileSocialLinkId'][$id] ==0) {
				$this->db->insert($this->tableProfileSocialLink , $this);
			}
			else{ 
				$this->db->where($field,$stats);
				$this->db->update($this->tableProfileSocialLink,$this);
			}
		}
	}

	function socialMediaLinkRecordSet($profileSocialLinkId){
		if($profileSocialLinkId > 0){
			$table = $this->tableProfileSocialLink;
			$field = 'profileSocialLinkId';
			$this->db->where($field,$profileSocialLinkId);
			$dataReferencesRecommendations = $this->db->get($table);
			$data =  $dataReferencesRecommendations->row();
		}
		return $data;
	}

	function deleteSocialLink($profileSocialLinkId)
	{
		$fieldprofileSocialLinkId = 'profileSocialLinkId';
		$this->db->where($fieldprofileSocialLinkId,$profileSocialLinkId);
		$this->db->set('socialLinkArchived','t');
		$this->db->update($this->tableProfileSocialLink);
		//$this->db->delete($this->tableProfileSocialLink); 
		return true;
	}

	function checkForSetProfile($userId)
	{
		$this->db->select('workProfileId');
		$fieldProfile = 'tdsUid';
		$this->db->where($fieldProfile,$userId);
		$workProfileResult = $this->db->get($this->tabelWorkprofile);
		//echo '<pre />workProfileId:';print_r($workProfileResult->result_array());
		if($workProfileResult->num_rows()<1)
		{
			return 0;
		}
		else
		{
			$currentWorkProfileId = $workProfileResult->result_array();
			return $currentWorkProfileId[0]['workProfileId'];
		}
	}

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
	
	
	
	function getEducation($workProfileId=0)
	{		
		 $this->db->select('*');
		 $this->db->from($this->education);
		 $this->db->where('workProfileId',$workProfileId);
		 $this->db->order_by("year_from", "asc"); //TO SHOW year ORDER
		 $query = $this->db->get();
		 return $query->result();		 
	}
	
	function getVisaType($workProfileId=0)
	{		
		 $this->db->select('*');
		 $this->db->from($this->visaType);
		 $this->db->where('workProfileId',$workProfileId);
		 $this->db->order_by("visaType", "asc"); //TO SHOW year ORDER
		 $query = $this->db->get();
		 return $query->result();		 
	}
	
	function saveEducation($educationArray,$userId){
		
		//Get the blog Id to get inserted in category table
		$WorkProfileID = $this->getWorkProfileID($userId);	
		$WorkProfileIDCurrent = $WorkProfileID[0]->workProfileId;
		//echo '<pre />Education Array:'.$WorkProfileIDCurrent;print_r($educationArray);die;
		//Intialized to distingush the records to insert and update
		
		/*$updatecatArray = $catArray['categoryTitleEdit'];*/
		
		if(is_array($educationArray))
		{
			if(isset($educationArray['year_from']) && $educationArray['year_from']!='')
			{
				if($educationArray['educationId'] ==0)
				{
					$eduInsertRecord['workProfileId'] = $WorkProfileIDCurrent;
					$eduInsertRecord['tdsUid'] = $userId;
					$eduInsertRecord['year_from'] = $educationArray['year_from'];
					$eduInsertRecord['year_to'] =$educationArray['year_to'];
					$eduInsertRecord['degree'] = $educationArray['degree'];
					$eduInsertRecord['university'] = $educationArray['university'];
					
					$query = $this->db->insert($this->education, $eduInsertRecord);
					$lastInsertId = $this->db->insert_id();
				}
				else
				{
					$updatekey = $educationArray['educationId'];
					$this->db->where('educationId',$updatekey);
					$eduUpdateRecord['workProfileId'] = $WorkProfileIDCurrent;
					$eduUpdateRecord['tdsUid'] = $userId;
					$eduUpdateRecord['year_from'] = $educationArray['year_from'];
					$eduUpdateRecord['year_to'] = $educationArray['year_to'];
					$eduUpdateRecord['degree'] = $educationArray['degree'];
					$eduUpdateRecord['university'] = $educationArray['university'];
					
					
					
					$query = $this->db->update($this->education, $eduUpdateRecord);
					$lastInsertId = $updatekey;
				}
			}
			
		}
						
		$delEducationIds = $this->input->post('delEducationId');
		
		if(isset($delEducationIds) && $delEducationIds!=''){
			if(!is_array($delEducationIds)) {
				$delEducationIds = explode(',',$delEducationIds);
			}
			
			$this->db->where_in('educationId',$delEducationIds);
			$this->db->delete($this->education);
			//echo $this->db->last_query();die;
		}
	if(isset($lastInsertId))
	return $lastInsertId;
	}
	
	
	function saveVisaType($dataArray,$userId){
		
		//Get the blog Id to get inserted in category table
		$WorkProfileID = $this->getWorkProfileID($userId);	
		$WorkProfileIDCurrent = $WorkProfileID[0]->workProfileId;
		
		//Intialized to distingush the records to insert and update
		
		if(is_array($dataArray))
		{
			if(isset($dataArray['countryId']) && $dataArray['countryId']!='')
			{
				if($dataArray['visaId'] == 0)
				{
					$InsertRecord['workProfileId'] = $WorkProfileIDCurrent;
					$InsertRecord['tdsUid'] = $userId;
					$InsertRecord['countryId'] = $dataArray['countryId'];
					$InsertRecord['visaType'] = $dataArray['visaType'];				
					$query = $this->db->insert($this->visaType, $InsertRecord);
					$lastInsertId = $this->db->insert_id();
				}
				else
				{
					//echo '<pre />';print_r($dataArray);die;
					$updatekey = $dataArray['visaId'];
					$this->db->where('visaId',$updatekey);
					$UpdateRecord['workProfileId'] = $WorkProfileIDCurrent;
					$UpdateRecord['tdsUid'] = $userId;
					$UpdateRecord['countryId'] = $dataArray['countryId'];
					$UpdateRecord['visaType'] = $dataArray['visaType'];
					$query = $this->db->update($this->visaType, $UpdateRecord);
					$lastInsertId = $updatekey;
					//echo $this->db->last_query();die;
				}
			}
			
		}
						
		$delIds = $this->input->post('delId');
		
		if(isset($delIds) && $delIds!=''){
			if(!is_array($delIds)) {
				$delIds = explode(',',$delIds);
			}
			
			$this->db->where_in('visaId',$delIds);
			$this->db->delete($this->visaType);
			//echo $this->db->last_query();die;
		}
	if(isset($lastInsertId))
	return $lastInsertId;
	}
	
	function getWorkProfileDetails($workProfileId=0)
	{
		if($workProfileId > 0){
			 $tabelWorkprofile = $this->db->dbprefix($this->tabelWorkprofile);
			 $this->db->select($this->tabelWorkprofile.'.*');
			 $this->db->select($this->UserShowcase.'.optionAreaName,'.$this->UserShowcase.'.enterprise,'.$this->UserShowcase.'.enterpriseName');
			 $this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');
			 $this->db->select($this->MediaFile.'.fileId,'.$this->MediaFile.'.filePath,'.$this->MediaFile.'.fileName');
			 $this->db->select($this->MasterCountry.'.countryName');
			
			 $this->db->from($this->tabelWorkprofile);
			 $this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->tabelWorkprofile.'.fileId', 'left');
			 $this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->tabelWorkprofile.".tdsUid", 'left');
			 $this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tabelWorkprofile.".tdsUid", 'left');
			 $this->db->join($this->MasterCountry, $this->MasterCountry.'.countryId = CAST("'.$tabelWorkprofile.'"."profileCountry" as int)', 'left');
			 $this->db->where($this->tabelWorkprofile.'.workProfileId',$workProfileId);
			 $query = $this->db->limit(1);
			 $query = $this->db->get();
			 return $query->result();  	 
		 }else{
			 return false;
		}
	}
	
	/***
	 * 	Function to Get the Employe History
	***/
	function employeHistoryRecordSet($workProfileId)
	{
		if($workProfileId > 0){
			$table = $this->tableProfileEmpHistory;
			$field = 'workProfileId';
			$this->db->where($field,$workProfileId);
			$this->db->where('empArchived','f');
			$dataEmpHistory = $this->db->get($table);
			//echo $this->db->last_query();
			//echo "<pre />"; print_r($dataEmpHistory->row());
			return $dataEmpHistory->result();
		}
	}
	
	function getUsersRecommendation($userId)
	{		
		 //$this->db->select('recommendations,created_date');
		 $this->db->select($this->tableRecommendation.'.recommendations, '.$this->tableRecommendation.'.created_date,'.$this->UserShowcase.'.tdsUid,'.$this->UserShowcase.'.firstName ,'.$this->UserShowcase.'.lastName , '.$this->UserShowcase.'.profileImageName, '.$this->tableUserAuth.'.username');
		 $this->db->from($this->tableRecommendation);
		 $this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->tableRecommendation.".from_userid", 'left');
		 $this->db->join($this->tableUserAuth, $this->tableUserAuth.".tdsUid = ".$this->tableRecommendation.".from_userid", 'left');		 
		 $this->db->where($this->tableRecommendation.'.to_userid',$userId);
		 $this->db->where($this->tableRecommendation.'.is_show_in_cv','t');
		 //$this->db->limit(1,$limit); //TO SHOW Limit
		 $this->db->order_by($this->tableRecommendation.'.id','asc'); 
		 $query = $this->db->get();		
		 //echo $this->db->last_query();
		//echo '<pre />Recommends:';print_r($query->result());	die;
		 return $query->result();		 
	}
	
	/*
	 * Function to get Users Workprofile data listing
	 */
	function userWorkProfileData($workProfileId=0,$userId=0)
	{
		$tabelWorkprofile = $this->db->dbprefix($this->tabelWorkprofile);
		$this->db->select($this->tabelWorkprofile.'.*');
		$this->db->select($this->UserShowcase.'.firstName,'.$this->UserShowcase.'.lastName,'.$this->UserShowcase.'.optionAreaName');
		$this->db->select($this->MediaFile.'.fileId,'.$this->MediaFile.'.filePath,'.$this->MediaFile.'.fileName');
		$this->db->select($this->MasterCountry.'.countryName');

		$this->db->from($this->tabelWorkprofile);
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->tabelWorkprofile.'.fileId', 'left');
		$this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->tabelWorkprofile.".tdsUid", 'left');
		$this->db->join($this->MasterCountry, $this->MasterCountry.'.countryId = CAST("'.$tabelWorkprofile.'"."profileCountry" as int)', 'left');
		if($workProfileId > 0)
		$this->db->where($this->tabelWorkprofile.'.workProfileId',$workProfileId);
		if($userId > 0)
		$this->db->where($this->tabelWorkprofile.'.tdsUid',$userId);
		$query = $this->db->get();
		return $query->result_array();	
	}

}
?>
