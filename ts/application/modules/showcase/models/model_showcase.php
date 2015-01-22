<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
class model_showcase extends CI_Model {
private $userId = NULL;
private $project = 'Project';
private $newsTable ='ShowcaseNews';
private $reviewsTable ='ShowcaseReviews';	 
private $awardsTable ='ShowcaseAwards';	
private $projectWork = 'Work';	
private $projectProduct  = 'product';
private $projectWorkprofile = 'WorkProfile';
private $socialNetworkTable = 'ShowcaseSocialLink';
private $showcaseTableName = 'UserShowcase';
private $tableUserProfile  = 'UserProfile';
private $tableUserAuth	 = 'UserAuth';
private $tableStockImages	= 'StockImages';
private $tableMasterLang	= 'MasterLang';
private $tableMasterCountry	= 'MasterCountry';
private $tableMasterIndustry = 'MasterIndustry';
private $tableLogSummary	 = 'LogSummary';
private $tableLogCrave 		= 'LogCrave'; 
private $socialLinkTable     = 'profileSocialLink';
private $socialMediaIcon     = 'profileSocialMediaIcon';
private $tableUserContainer	= 'UserContainer';
private $tableUserShowcaseLang	= 'UserShowcaseLang';
private $tableAssociatedEnterprise	= 'AssociatedEnterprise';
	 /**
		 * Constructor
	 **/
	function __construct()
	{
		parent::__construct();
		// My own constructor code
	}
	
	function getGeneralShowcase($userId=0){
		if(!isset($userId) || $userId<=0) $userId = $this->isLoginUser();
		$this->db->from($this->showcaseTableName);
		$this->db->join('AssociatedEnterprise',"AssociatedEnterprise.to_showcaseid = ".$this->showcaseTableName.".showcaseId", 'left');		
		$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->showcaseTableName.".userContainerId", 'left');	
		$this->db->where($this->showcaseTableName.'.tdsUid',$userId);		
		$data['userShowcaseQuery'] = $this->db->get();
		$data['userShowcaseResults'] = $data['userShowcaseQuery']->result_array();
		return $data['userShowcaseResults'];		
	}
	
	
	/*function getShowcaseMultiLangData($langAbbr=0)
	{
		
		if(!isset($userId) || $userId<=0) $userId = $this->isLoginUser();
				
		$this->db->select($this->tableUserShowcaseLang.'.tagwords,'.$this->tableUserShowcaseLang.'.tagwords,'.$this->tableUserShowcaseLang.'.creativeFocus,'.$this->tableUserShowcaseLang.'.creativePath,'.$this->tableUserShowcaseLang.'.promotionalsection,'.$this->tableUserShowcaseLang.'.optionAreaName,'.$this->tableUserShowcaseLang.'.lang,'.$this->tableUserShowcaseLang.'.isPublished,'.$this->tableUserShowcaseLang.'.showcaseLangId');
		//$this->db->select('tagwords,creativeFocus,creativePath,promotionalsection,optionAreaName,lang');
		$this->db->from($this->tableUserShowcaseLang);	
		$this->db->where('lang',$langAbbr);		
		$userShowcaseQuery = $this->db->get();		
		$data['userShowcaseResults'] = $userShowcaseQuery->result_array();
		return $data['userShowcaseResults'];		
	}*/
	
	/* */
	function getShowcaseMultiLangData($langAbbr=0){
		$userId = $this->isLoginUser();
				
		$this->db->select($this->tableUserShowcaseLang.'.tagwords,'.$this->tableUserShowcaseLang.'.tagwords,'.$this->tableUserShowcaseLang.'.creativeFocus,'.$this->tableUserShowcaseLang.'.creativePath,'.$this->tableUserShowcaseLang.'.promotionalsection,'.$this->tableUserShowcaseLang.'.optionAreaName,'.$this->tableUserShowcaseLang.'.lang,'.$this->tableUserShowcaseLang.'.isPublished,'.$this->tableUserShowcaseLang.'.showcaseLangId,'.$this->tableUserShowcaseLang.'.langId,'.$this->tableUserShowcaseLang.'.promotionalsection,'.$this->tableUserShowcaseLang.'.publisheDate,'.$this->tableUserShowcaseLang.'.dateCreated,'.$this->tableUserShowcaseLang.'.tdsUid,'.$this->tableUserShowcaseLang.'.showcaseId');
		//$this->db->select('tagwords,creativeFocus,creativePath,promotionalsection,optionAreaName,lang');
		$this->db->from($this->tableUserShowcaseLang);	
		$this->db->where('showcaseLangId',$langAbbr);	
		$this->db->where('tdsUid',$userId);	
		$userShowcaseQuery = $this->db->get();		
		$data['userShowcaseResults'] = $userShowcaseQuery->result_array();
		return $data['userShowcaseResults'];		
	}
	
	function getGeneralShowcaseForm($showcaseId=0)
	{		
		
		$this->userId = $this->isLoginUser();
		$this->db->where('tdsUid',$this->userId);
		$this->db->from($this->showcaseTableName);	
		$data['userShowcaseQuery'] = $this->db->get();
		
		$data['userShowcaseResults'] = $data['userShowcaseQuery']->result_array();
		
		return $data['userShowcaseResults'][0];		
	}
	
	function generalShowcaseSave($dataArray,$showcaseId)
	{		
	//echo '<pre />';
	//print_r($dataArray);die;
		$this->userId = $this->isLoginUser();
		
		$serialized = serialize($dataArray);
		$this->session->set_userdata('serializedData',$serialized);
		
		
		//echo 'I am in save:<pre />';print_r($this->input->post());
		//echo '<br />'.print_r($_FILES);
		
		if($dataArray['showcaseId'] ==0)
		{					
			$dataArray['dateCreated'] = date("Y-m-d H:i:s"); 
			 $dataArray['dateModified'] = date("Y-m-d H:i:s"); 
			 unset($dataArray['showcaseId']);
			 $this->db->insert($this->showcaseTableName, $dataArray);//Insert new record for posts			
		} 
		else
		{
			//echo '<pre />In Update'.$dataArray['showcaseId'];die;
			//print_r($dataArray);
			$field = 'showcaseId';
			unset($dataArray['tdsUid']);
			
			$dataArray['dateModified'] = date("Y-m-d H:i:s"); 
			$this->db->where($field , $dataArray['showcaseId']);	
			unset($dataArray['showcaseId']);
			$this->db->update($this->showcaseTableName,$dataArray);//Update post
			//echo $this->db->last_query(); die;			 
		}		
		return $dataArray;		
	}
	
	/**
		* Get the project Ids for logged in user only
		* @param NULL
		* @return comma seperated string of projectIds for logged in user(ID1,ID2,ID3,ID4,.....)
	**/
	function getUserProjectIds()
	{		
		$this->userId = $this->isLoginUser();
		$field = 'tdsUid';
		$this->db->select('projId');
		$this->db->where($field,$this->userId);
		$projectQuery = $this->db->get($this->project);	
			
		if($projectQuery->num_rows()>0){
			$projectResults = $projectQuery->result_array();
			//Get the project Ids for logged in user only
			foreach($projectResults as $key =>$value) $projectIds[] = $value['projId'];	
			$allProjectIds = implode (',',$projectIds);
		}
		else $allProjectIds = 0;
	
		return $allProjectIds;
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
		
		$field = 'custId';
		$this->db->select('workProfileId');		
		$this->db->where($field,$userId);
		$workProfileResultID = $this->db->get($this->projectWorkprofile);
		return $workProfileResultID->result();
	}
	
	/**
		* Loads ProfileSocialLink Listing on page for logged in User
		*
		* @param NULL
		* @return Object
	**/
	function getSocialLinksList()
	{	
		$joinTable = 'profileSocialMediaIcon';
		$this->db->join('profileSocialMediaIcon', 'profileSocialMediaIcon.profileSocialMediaId = ShowcaseSocialLink.socialLinkType');
		$this->db->where('tdsUid',$this->userId);
		$this->db->order_by('position','asc');
		$workSocialMedia = $this->db->get($this->socialNetworkTable);	
		$workSocialMediaResult = $workSocialMedia->result();
		return $workSocialMediaResult ;
	}
	
	/**
		* To get the number of records present in any given table for given field name present in table
	**/
	function getNumRowsCommon($anyTabelName,$anyPrimaryId){
        $this->db->select($anyPrimaryId);
        $query = $this->db->get($anyTabelName);
        $numrows = $query->num_rows();
        return $numrows;
    }  

/* Save Functions */

	function saveNews(){
		
		$showcaseNewsId = $this->input->post('showcaseNewsId');
		$this->db->select_max('position');
		$newsTableMaxPosition = $this->db->get($this->newsTable);
		$result = $newsTableMaxPosition->row();
		
		$newsData = array(
			 	'tdsUid'=>$this->userId,
				'newsTitle'=>$this->input->post('title'),
				'newsWriter'=>$this->input->post('writerName'),
				'newsPublishDate'=>$this->input->post('publishDate'),
				'newsLanguage'=>$this->input->post('newsLanguage'),
				'newsDescription'=>$this->input->post('newsDescription'),
				'tableId'=>'270',//to changed with result form query
				'recordId'=>'0'//to changed with result form query								
	     );
		 
		 if(strcmp($this->input->post('myUpload'),'video')==0) {
			 $newsData['uploadVideoType']='t';
			 $newsData['newsEmbed'] = $this->input->post('newsEmbbededVideo'); 
		 }
		 else {
			 $newsData['uploadVideoType']='f';
			 $newsData['newsEmbed'] = $this->input->post('newsEmbbededURL');
		 }
		 
		if($showcaseNewsId!=0)
		{			
			$this->db->where('showcaseNewsId',$showcaseNewsId);			
			$newsData['newsModifiedDate'] = date("Y-m-d H:i:s"); 
			$newsResult = $this->db->update($this->newsTable,$newsData);//Update post
		} 
		else
		{
			$newsData['newsCreateDate'] = date("Y-m-d H:i:s"); 
			$newsData['newsModifiedDate'] = date("Y-m-d H:i:s"); 
			$newsData['position'] = $result->position+1; 
			$newsResult = $this->db->insert($this->newsTable, $newsData);//Insert new record for posts 
		}	
		//echo $newsResult;die;
	 $newsSerialized = serialize($newsData);
	 $this->session->set_userdata('serializedNewsData',$newsSerialized);
	 return	$newsResult;
	}
	
	function saveReviews(){
		
		$showcaseReviewsId = $this->input->post('showcaseReviewsId');
		$this->db->select_max('position');
		$reviewsTableMaxPosition = $this->db->get($this->reviewsTable);
		$result = $reviewsTableMaxPosition->row();
		
		$reviewsData = array(
			 	'tdsUid'=>$this->userId,
				'reviewsTitle'=>$this->input->post('reviewstitle'),
				'reviewsWriter'=>$this->input->post('reviewswriterName'),
				'reviewsPublishDate'=>$this->input->post('reviewsPublishDate'),
				'reviewsLanguage'=>$this->input->post('reviewsLanguage'),
				'reviewsDescription'=>$this->input->post('reviewsDescription'),
				'tableId'=>'270',//to changed with result form query
				'recordId'=>'0'//to changed with result form query								
	   );
		 
		 if(strcmp($this->input->post('myUpload'),'video')==0) {
			 $reviewsData['uploadVideoType']='t';
			 $reviewsData['reviewsEmbed'] = $this->input->post('reviewsEmbbededVideo'); 
		 }
		 else {
			 $reviewsData['uploadVideoType']='f';
			 $reviewsData['reviewsEmbed'] = $this->input->post('reviewsEmbbededURL');
		 }
		 
		if($showcaseReviewsId!=0)
		{			
			$this->db->where('showcaseReviewsId',$showcaseReviewsId);			
			$reviewsData['reviewsModifiedDate'] = date("Y-m-d H:i:s"); 
			$reviewsResult = $this->db->update($this->reviewsTable,$reviewsData);//Update post
		} 
		else
		{
			$reviewsData['reviewsCreateDate'] = date("Y-m-d H:i:s"); 
			$reviewsData['reviewsModifiedDate'] = date("Y-m-d H:i:s"); 
			$reviewsData['position'] = $result->position+1; 
			$reviewsResult = $this->db->insert($this->reviewsTable, $reviewsData);//Insert new record for posts 
		}	
		//echo $reviewsResult;die;
		return	$reviewsResult;
	}
	
	function saveAwards(){
	
		$showcaseAwardsId = $this->input->post('showcaseAwardsId');	
		$this->db->select_max('position');
		$awardsTableMaxPosition = $this->db->get($this->awardsTable);
		$result = $awardsTableMaxPosition->row();
	
		$awardsData = array(
			 	'tdsUid'=>$this->userId,
				'awardsTitle'=>$this->input->post('awardsTitle'),
				'awardsUrl'=>$this->input->post('awardsUrl'),
				'awardsPublishDate'=>$this->input->post('awardsPublishDate'),
				'awardsDescription'=>$this->input->post('awardsDescription'),
				'tableId'=>'270',//to changed with result form query
				'recordId'=>'0'//to changed with result form query
								
	     );	 
			
		
		if($showcaseAwardsId!=0)
		{			
			$this->db->where('showcaseAwardsId',$showcaseAwardsId);			
			$awardsData['awardsModifiedDate'] = date("Y-m-d H:i:s"); 
			$awardsResult = $this->db->update($this->awardsTable,$awardsData);//Update post
		} 
		else
		{
			$awardsData['awardsCreateDate'] = date("Y-m-d H:i:s"); 
			$awardsData['awardsModifiedDate'] = date("Y-m-d H:i:s");
			$awardsData['position'] = $result->position+1; 
		
			$awardsResult = $this->db->insert($this->awardsTable, $awardsData);//Insert new record for posts 
		}	
		return	$awardsResult;
	}
	
	function saveSocialNetworking(){
			
		$showcaseSocialLinkId = $this->input->post('showcaseSocialLinkId');	
		$this->db->select_max('position');
		$socialNetworkMaxPosition = $this->db->get($this->socialNetworkTable);
		$result = $socialNetworkMaxPosition->row();
				
		$socialNetworkData = array(
			'tdsUid'=>$this->userId,
			'socialLink'=>$this->input->post('socialLink'),
			'socialLinkType'=>$this->input->post('socialLinkType'),
			'tableId'=>'270',//to changed with result form query
			'recordId'=>'0'//to changed with result form query								
	     );		
		
		if($showcaseSocialLinkId!=0)
		{			
			$this->db->where('showcaseSocialLinkId',$showcaseSocialLinkId);	
					
			$socialNetworkData['socialLinkDateCreated'] = date("Y-m-d H:i:s"); 
			$SocialNetworkDataResult = $this->db->update($this->socialNetworkTable,$socialNetworkData);//Update post
		} 
		else
		{
			$socialNetworkData['socialLinkDateCreated'] = date("Y-m-d H:i:s"); 
			$socialNetworkData['socialLinkDateModified'] = date("Y-m-d H:i:s"); 
			$socialNetworkData['position'] = $result->position+1;
			$socialNetworkDataResult = $this->db->insert($this->socialNetworkTable, $socialNetworkData);//Insert new record for posts 
		}	
		//return	$socialNetworkDataResult;
	}
	
	function shiftNews(){
	
		//To delete the selected record
		if($this->input->post('newsIdForDelete'))
		{
			$newsIdForDelete = decode($this->input->post('newsIdForDelete'));
			$this->db->where('showcaseNewsId', $newsIdForDelete);
			$this->db->delete($this->newsTable);
			$this->session->unset_userdata('serializedNewsData');//Unset the serilized data used for object	
			
		}
		
		if($this->input->post('newsIdForSwap') ==1)
		{
			$currentId =  decode($this->input->post('currentId'));
			$currentPos =  $this->input->post('currentPosition');
			$swapId =  decode($this->input->post('swapId'));
			$swapPos =  $this->input->post('swapPosition');
			
			$getPostion = $this->shiftCell($this->newsTable,'showcaseNewsId',$currentId,$currentPos,$swapId,$swapPos);
			
			
		}
		
	}
	
	function shiftReviews(){
	
		//To delete the selected record
		if($this->input->post('reviewsIdForDelete'))
		{
			$reviewsIdForDelete = decode($this->input->post('reviewsIdForDelete'));
			$this->db->where('showcaseReviewsId', $reviewsIdForDelete);
			$this->db->delete($this->reviewsTable);
			$this->session->unset_userdata('serializedReviewsData');//Unset the serilized data used for object
			
		}
	
		if($this->input->post('reviewsIdForSwap') ==1)
		{
			$currentId =  decode($this->input->post('reviewCurrentId'));
			$currentPos =  $this->input->post('reviewCurrentPosition');
			$swapId =  decode($this->input->post('reviewSwapId'));
			$swapPos =  $this->input->post('reviewSwapPosition');
			$getPostion = $this->shiftCell($this->reviewsTable,'showcaseReviewsId',$currentId,$currentPos,$swapId,$swapPos);
					
		}
	}
	
	function shiftAwards(){
	
		if($this->input->post('awardsIdForDelete'))
		{
			$showcaseAwardsId =  decode($this->input->post('awardsIdForDelete'));
			$this->db->where('showcaseAwardsId', $showcaseAwardsId);
			$this->db->delete($this->awardsTable);
                        $this->session->unset_userdata('serializedAwardsData');//Unset the serilized data used for object			
		}
		if($this->input->post('awardsIdForSwap') == 1)
		{
			$currentId =  decode($this->input->post('awardsCurrentId'));
			$currentPos =  $this->input->post('awardsCurrentPosition');
			$swapId =  decode($this->input->post('awardsSwapId'));
			$swapPos =  $this->input->post('awardsSwapPosition');
			$getPostion = $this->shiftCell($this->awardsTable,'showcaseAwardsId',$currentId,$currentPos,$swapId,$swapPos);			
		}
	}
	
	function shiftSocialLink(){
	
		if($this->input->post('socialLinkIdForDelete'))
		{
			$showcaseSocialLinkId =  decode($this->input->post('socialLinkIdForDelete'));
			$this->db->where('showcaseSocialLinkId', $showcaseSocialLinkId);
			$this->db->delete($this->socialNetworkTable);
			$this->session->unset_userdata('serializedSocialNetData');//Unset the serilized data used for object
		}
		
		if($this->input->post('socialLinkIdForSwap') == 1)
		{
			$currentId =  decode($this->input->post('socialLinkCurrentId'));
			$currentPos =  $this->input->post('socialLinkCurrentPosition');
			$swapId =  decode($this->input->post('socialLinkSwapId'));
			$swapPos =  $this->input->post('socialLinkSwapPosition');
			$showcaseSocialLinkId =  decode($this->input->post('socialLinkIdForUp'));
			$getPostion = $this->shiftCell($this->socialNetworkTable,'showcaseSocialLinkId',$currentId,$currentPos,$swapId,$swapPos);
		}
		
	}
	
	/*****
	Function to Move the record Up and Down Side
	Input Parameters: table name, Where clause filed Id Name, Where clause current Id Value, swap Id Value with relative position values where to move (Up Or Down)
	*****/

	function shiftCell($tableName,$fieldId,$currentId,$currentPos,$swapId,$swapPos)
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
	
	function loadStockImages()
	{	
		$this->db->select('stockImgId,stockImgPath,stockFilename');
		$this->db->order_by('stockImgId', 'asc'); 
		$data['stockQuery'] = $this->db->get('StockImages'); 
		$data['stockImgResults'] = $data['stockQuery']->result(); 	
		return $data['stockImgResults'];	
	}
	
		
	function getshowcasedetail($showcaseId=0,$userId=0)
	{	
			$userId = ($userId>0)?$userId:isLoginUser();
			
			if($showcaseId > 0 || $userId>0){
				$entityId=getMasterTableRecord('UserShowcase');
				$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
				
                $this->db->select('*,'.$this->showcaseTableName.'.tdsUid as "tdsUid",'.$this->showcaseTableName.'.creativePath as "creativePath",'.$this->showcaseTableName.'.creativeFocus as "creativeFocus",'.$this->showcaseTableName.'.enterpriseName as "enterpriseName" ,'.$this->showcaseTableName.'.tagwords as "tagwords",'.$this->showcaseTableName.'.creativePath as "creativePath"');
				$this->db->select($this->tableUserProfile.'.firstName as "firstName",'.$this->tableUserProfile.'.lastName as "lastName"');
				
                $this->db->from($this->showcaseTableName);
				$this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->showcaseTableName.".stockImageId", 'left');
				$this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = '.$this->showcaseTableName.'.tdsUid','left');
				$this->db->join($this->tableUserProfile, $this->tableUserProfile.'.tdsUid = '.$this->showcaseTableName.'.tdsUid','left');
				$this->db->join("MediaFile", "MediaFile.fileId = ".$this->showcaseTableName.".interviewFileId", 'left');	
				$this->db->join($this->tableMasterCountry, $this->tableMasterCountry.".countryId = ".$this->tableUserProfile.".countryId", 'left');
				$this->db->join($this->tableMasterIndustry, $this->tableMasterIndustry.".IndustryId = ".$this->showcaseTableName.".industryId", 'left');
				$this->db->join('AssociatedEnterprise',"AssociatedEnterprise.to_showcaseid = ".$this->showcaseTableName.".showcaseId", 'left');	
				$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->showcaseTableName.'.showcaseId AND "'.$tableLogSummary.'"."entityId"='.$entityId.'', 'left');
				
				if($showcaseId > 0){
					$this->db->where($this->showcaseTableName.'.showcaseId', $showcaseId);
				}
				if($userId > 0){
					$this->db->where($this->showcaseTableName.'.tdsUid',$userId);
				}
				
				$query = $this->db->limit(1);
				$query = $this->db->get();
				//echo $this->db->last_query();
				if ($query->num_rows() > 0){
					return $query->result();
				}else{
					return false;
				}
			}else{
				return false;
			}
	}
	
	
	function showcasePreviewData(){
	//Fetch the data from DB if session is not set
	
	$this->userId = $this->isLoginUser();
	
	if(!$this->session->userdata('serializedData'))		
	{
		
		$this->db->where('tdsUid',$this->userId);
		$this->db->from($this->showcaseTableName);			
		$data['GSPQuery'] = $this->db->get();//GSP:General Showcase Preview
		$data['GSPResults'] = $data['GSPQuery']->result_array();
		$serialized = serialize($data['GSPResults'][0]);
		$this->session->set_userdata('serializedData',$serialized);
	
	}		
	}

	function showcasePreviewNewsData(){ //Fetch the data from DB if session is not set
	$this->userId = $this->isLoginUser();
		if(!$this->session->userdata('serializedNewsData'))		
		{
		 $this->db->where('tdsUid',$this->userId);		
		 $data['GSPNewsQuery'] = $this->db->get('ShowcaseNews');//GSP:General Showcase Preview
		 $data['GSPNewsResults'] = $data['GSPNewsQuery']->result_array();
		 $newsSerialized = serialize($data['GSPNewsResults']);
		 $this->session->set_userdata('serializedNewsData',$newsSerialized);
		}	
	}
	
	function showcasePreviewReviewsData(){
	$this->userId = $this->isLoginUser();
	//Fetch the data from DB if session is not set
		
		 $this->db->where('tdsUid',$this->userId);		
		 $data['GSPReviewsQuery'] = $this->db->get('ShowcaseReviews');//GSP:General Showcase Preview
		 $data['GSPReviewsResults'] = $data['GSPReviewsQuery']->result_array();
	 	 return $data['GSPReviewsResults'];	 
	}

	function showcasePreviewAwardsData(){
	$this->userId = $this->isLoginUser();
	//Fetch the data from DB if session is not set
	if(!$this->session->userdata('serializedAwardsData'))		
	{
	 $this->db->where('tdsUid',$this->userId);		
	 $data['GSPAwardsQuery'] = $this->db->get('ShowcaseAwards');//GSP:General Showcase Preview
	 $data['GSPAwardsResults'] = $data['GSPAwardsQuery']->result_array();
 	 $awardsSerialized = serialize($data['GSPAwardsResults']);
	 $this->session->set_userdata('serializedAwardsData',$awardsSerialized);
	}	
	 
	}

	function showcasePreviewSocialNetData(){
		$this->userId = $this->isLoginUser();
		//Fetch the data from DB if session is not set
		if(!$this->session->userdata('serializedSocialNetData'))		
		{
		 $this->db->where('tdsUid',$this->userId);		
		 $data['GSPSocialNetQuery'] = $this->db->get('ShowcaseSocialLink');//GSP:General Showcase Preview
		 $data['GSPSocialNetResults'] = $data['GSPSocialNetQuery']->result_array();
		 $socialNetSerialized = serialize($data['GSPSocialNetResults']);
		 $this->session->set_userdata('serializedSocialNetData',$socialNetSerialized);
		}
	}
	
	function getAssociatedMembers($from_showcaseid=0){
		if($from_showcaseid > 0)		
		{
			$this->db->select('AssociatedEnterprise.*,'.$this->tableUserAuth.'.username,'.$this->showcaseTableName.'.firstName,'.$this->showcaseTableName.'.lastName,'.$this->showcaseTableName.'.optionAreaName,'.$this->showcaseTableName.'.profileImageName,'.$this->showcaseTableName.'.stockImageId,'.$this->tableStockImages.'.stockImgPath,'.$this->tableStockImages.'.stockFilename');
			$this->db->from('AssociatedEnterprise');
			
			$this->db->join($this->showcaseTableName, $this->showcaseTableName.'.showcaseId = AssociatedEnterprise.to_showcaseid','left');
			$this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = '.$this->showcaseTableName.'.tdsUid','left');
			$this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->showcaseTableName.".stockImageId", 'left');
			
			$this->db->where('AssociatedEnterprise.from_showcaseid', $from_showcaseid);
			$this->db->where('UserShowcase.isPublished', 't');
			$query = $this->db->get();
			//echo $this->db->last_query();die();
			if ($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}
	
	
	/* Function to get Socila icons for profile  */
    
    function getSocialMediaLinks($where=''){		
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
	
	function getSocialMediaIcon ($socialMediaCondition)
	{		

	 if(!empty($socialMediaCondition['for'])){
		 
		 if(strcmp($socialMediaCondition['for'],'showcase')==0){
			 $socialEntityId='showcaseId';
			 $socialEntitytable='UserShowcase';	
		 }
		 
		else
		 {			
			 $socialEntityId='workProfileId';
			 $socialEntitytable='WorkProfile';
		 }
		 $getentityId=getMasterTableRecord($socialEntitytable);
		 $socialResult = getDataFromTabel($socialEntitytable,$socialEntityId,'tdsUid',$socialMediaCondition['userId']);
		 if(!empty($socialResult[0]->$socialEntityId)) $elementId = $socialResult[0]->$socialEntityId;
	 }  
	    
	 if(isset($socialMediaCondition['userId']) && ($socialMediaCondition['userId']>0) && !empty($elementId)) {     
		 $this->db->select($this->socialLinkTable.'.socialLink,'.$this->socialMediaIcon.'.profileSocialMediaPath,'.$this->socialMediaIcon.'.profileSocialMediaName');
		
		 $this->db->from($this->socialLinkTable);	
		 $this->db->join($this->socialMediaIcon, $this->socialMediaIcon.'.profileSocialMediaId = '.$this->socialLinkTable.'.profileSocialLinkType','left');
		 $this->db->where($this->socialLinkTable.'.workProfileId',$elementId );		
		 $this->db->where($this->socialLinkTable.'.socialLinkArchived','f' );	
		 $this->db->where($this->socialLinkTable.'.entityId',$getentityId);
		 $this->db->order_by($this->socialLinkTable.'.position','ASC');
		 $query = $this->db->get();
		 //echo $this->db->last_query();die;
		 $result=$query->result();
		 return $result;
		//echo "<pre/>";	
	  	//print_r($result);die;	
	
		} else {
            return 0;
        }	
		
	}
	
	/* Manage mutilangual form values */
	function multilingaul_form_save($dataArray,$showcaseLangId)
	{
		if($showcaseLangId == 0)
		{	
			$dataArray['dateCreated'] = date("Y-m-d H:i:s"); 
			$dataArray['dateModified'] = date("Y-m-d H:i:s"); 
			$this->db->insert('UserShowcaseLang',$dataArray);
			return $this->db->insert_id();
		}else
		{ //print_r($dataArray);die;
			$dataArray['dateModified'] = date("Y-m-d H:i:s"); 
			$this->db->where('showcaseLangId', $showcaseLangId);	
			$this->db->update('UserShowcaseLang',$dataArray);
			return 0;
		}
	}
	
	/* Check language in user showcase */
	function checkUserShowcaseLang($userId=0,$langId=0)
	{
		$this->db->select('*');
		$this->db->from('UserShowcaseLang');
		$this->db->where('tdsUid',$userId);
		$this->db->where('langId',$langId);
		return $this->db->get()->row();
	}
		
	/* get language of user showcase */
	function getUserShowcaseLang($userId=0,$showcaseLangId=0)
	{
		$this->db->select('*');
		$this->db->from('UserShowcaseLang');
		$this->db->where('tdsUid',$userId);
		$this->db->where('showcaseLangId',$showcaseLangId);
		return $this->db->get()->row();
	}
	
	/* get Users multilingual language listing*/
	function getUserMultiLangList($userId=0){
		$return = false;
        if((int)$userId >0){
            $this->db->select('usl.showcaseLangId,usl.langId');
            $this->db->select('l.Language,l.Language_local');
            $this->db->from($this->tableUserShowcaseLang.' as usl');
            $this->db->join($this->tableMasterLang.' as l', 'l.langId = usl.langId', 'left');
            $this->db->where('usl.tdsUid',$userId);
            $this->db->where('usl.langId >',0);
            $this->db->where('usl.isPublished','t');
            $this->db->order_by('usl.showcaseLangId', 'ASC'); 
            $return = $this->db->get()->result();
        }
        return $return;
	}
	
	/* Check Language Published*/
	function checkLanguagePublished($multilangId=0)
	{
		$this->db->select('*');
		$this->db->from('UserShowcaseLang');
		$this->db->where('isPublished','t');
		$this->db->where('showcaseLangId',$multilangId);
		return $this->db->get()->row();
	}
	
	/* Function to delete users mutilingual showcase */
	public function removeMultiLangShowcase($mutiLangId)
    {
		$data = array(
			'showcaseLangId' => $mutiLangId,
		);
            
		$this->db->delete($this->tableUserShowcaseLang, $data);
            
		if($this->db->affected_rows() > 0)
		{
			return true;
		}else{
			return false;
		}       
	}
	
	/*
	 * Function to get Users Showcase data listings 
	 */
	function userShowcaseData($showcaseId=0,$userId=0)
	{	
		$entityId=getMasterTableRecord('UserShowcase');
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
		$this->db->select('*,'.$this->showcaseTableName.'.tdsUid as "tdsUid",'.$this->showcaseTableName.'.creativePath as "creativePath",'.$this->showcaseTableName.'.creativeFocus as "creativeFocus",'.$this->showcaseTableName.'.enterpriseName as "enterpriseName" ,'.$this->showcaseTableName.'.tagwords as "tagwords",'.$this->showcaseTableName.'.creativePath as "creativePath"');
		$this->db->select($this->tableUserProfile.'.firstName as "firstName",'.$this->tableUserProfile.'.lastName as "lastName"');
		$this->db->from($this->showcaseTableName);
		$this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->showcaseTableName.".stockImageId", 'left');
		$this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = '.$this->showcaseTableName.'.tdsUid','left');
		$this->db->join($this->tableUserProfile, $this->tableUserProfile.'.tdsUid = '.$this->showcaseTableName.'.tdsUid','left');
		$this->db->join("MediaFile", "MediaFile.fileId = ".$this->showcaseTableName.".interviewFileId", 'left');	
		$this->db->join($this->tableMasterCountry, $this->tableMasterCountry.".countryId = ".$this->tableUserProfile.".countryId", 'left');
		$this->db->join($this->tableMasterIndustry, $this->tableMasterIndustry.".IndustryId = ".$this->showcaseTableName.".industryId", 'left');
		$this->db->join('AssociatedEnterprise',"AssociatedEnterprise.to_showcaseid = ".$this->showcaseTableName.".showcaseId", 'left');	
		
		if($showcaseId > 0){
			$this->db->where($this->showcaseTableName.'.showcaseId', $showcaseId);
		}
		if($userId > 0){
			$this->db->where($this->showcaseTableName.'.tdsUid',$userId);
		}
		$query = $this->db->get();
		return $query->result_array();
	}
	
    /**
	 * Function to get users social media data  
	 */
	function getSocialMediaData($userId,$entityId='')
	{
		$this->db->select('psl.*');
		$this->db->select('smi.profileSocialMediaName,smi.profileSocialMediaPath');
		$this->db->from($this->socialLinkTable.' as psl');
		$this->db->join($this->socialMediaIcon.' as smi','smi.profileSocialMediaId = psl.profileSocialLinkType');
		$this->db->where('userId',$userId);
        //$this->db->where('entityId',$entityId);
		return $this->db->get()->result();
	}
    
    /**
	 * Function to insert social media data
	 */
	function addSocialMediaData($data)
	{
		if(isset($data['profileSocialLinkId']) && !empty($data['profileSocialLinkId'])) {
			$socialUpdateData = array(
				'socialLink'=>$data['socialLink'],
				'profileSocialLinkType'=>$data['profileSocialLinkType'],
				'socialLinkDateModified'=>date("Y-m-d H:i:s"),							
			);	
			$this->db->where('profileSocialLinkId',$data['profileSocialLinkId']);	
			$this->db->update($this->socialLinkTable,$socialUpdateData);
		} else {
			$this->db->insert($this->socialLinkTable,$data);
		}
		return true;
	}
    
    
	/**
	* Remove social media link data
	*/
	public function removeSocialMediaData($socialMediaId)
    {
		$data = array('profileSocialLinkId' => $socialMediaId,);   
		$this->db->delete($this->socialLinkTable, $data);
            
		if($this->db->affected_rows() > 0)
		{
			return true;
		}else{
			return false;
		}       
	}
	
	/**
	 * Function to update social media section
	 */
	function updateSocialMediaSections($socialLinkId,$data)
	{
		$this->db->where('profileSocialLinkId',$socialLinkId);	
		$this->db->update($this->socialLinkTable,$data);
		return true;
	}
    
     //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get enterprise users data 
    * @return array
    */ 
    public function getenterprisedata($keyword='',$limit=0,$offset=0,$sectionId='') {
        // set showcase tabel name with prefix
        $tableUserShowcase = $this->db->dbprefix('UserShowcase');
        // get showcase id
        $showcaseId = LoginUserDetails('showcaseId');
        // get projects log summary
        $showcaseEntityId = getMasterTableRecord('UserShowcase');
        $this->db->select($this->showcaseTableName.'.*');
        $this->db->select($this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.ratingAvg,'.$this->tableLogSummary.'.reviewCount');
        $this->db->from($this->showcaseTableName);
        $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->showcaseTableName.'.showcaseId','left');
        $this->db->where($this->showcaseTableName.'.enterprise', 't');
        $this->db->where($this->showcaseTableName.'.isPublished', 't');
        $this->db->where($this->showcaseTableName.'.isArchive', 'f');
        $this->db->where($this->showcaseTableName.'.showcaseId !=', $showcaseId); 
        $this->db->where($this->tableLogSummary.'.entityId', $showcaseEntityId);
        if(!empty($sectionId)) {
            $this->db->where($this->showcaseTableName.'.industryId', $sectionId);
        }
         // get result by the kyeword if exists 
        if(!empty($keyword)) {
            $keyword = pg_escape_string(trim(strtolower($keyword)));  
            $this->db->like('LOWER("'.$tableUserShowcase.'"."firstName")', $keyword);
            $this->db->or_like('LOWER("'.$tableUserShowcase.'"."lastName")', $keyword);
            $this->db->or_like('LOWER("'.$tableUserShowcase.'"."enterpriseName")', $keyword);
        }
       
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
    function getassociatedshowcasedata($showcaseId=0,$status='t') {
        // get projects log summary
        $showcaseEntityId = getMasterTableRecord('UserShowcase');
        $this->db->select($this->tableAssociatedEnterprise.'.*');
        $this->db->select($this->showcaseTableName.'.enterpriseName,'.$this->showcaseTableName.'.creativeFocus,'.$this->showcaseTableName.'.profileImageName');
        $this->db->select($this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.ratingAvg,'.$this->tableLogSummary.'.reviewCount');
        $this->db->from($this->tableAssociatedEnterprise);
        $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->tableAssociatedEnterprise.'.to_showcaseid','left');
        $this->db->join($this->showcaseTableName, $this->showcaseTableName.'.showcaseId = '.$this->tableAssociatedEnterprise.'.to_showcaseid','left');
        $this->db->where($this->tableLogSummary.'.entityId', $showcaseEntityId);
        $this->db->where($this->tableAssociatedEnterprise.'.from_showcaseid', $showcaseId);
        $this->db->where($this->tableAssociatedEnterprise.'.status', $status);
        $query = $this->db->get();
        if ($query->num_rows()) return $query->result();
        return false;
    }
    
      //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get members data 
    * @return array
    */ 
    public function getmemberdata($keyword='',$limit=0,$offset=0,$sectionId='',$userType='') {
        // set showcase tabel name with prefix
        $tableUserShowcase = $this->db->dbprefix('UserShowcase');
        // get showcase id
        $showcaseId = LoginUserDetails('showcaseId');
        // get projects log summary
        $showcaseEntityId = getMasterTableRecord('UserShowcase');
        $this->db->select($this->showcaseTableName.'.*');
        $this->db->select($this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.ratingAvg,'.$this->tableLogSummary.'.reviewCount');
        $this->db->from($this->showcaseTableName);
        $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->showcaseTableName.'.showcaseId','left');
        //$this->db->where($this->showcaseTableName.'.isPublished', 't');
        $this->db->where($this->showcaseTableName.'.isArchive', 'f');
        $this->db->where($this->showcaseTableName.'.showcaseId !=', $showcaseId); 
        $this->db->where($this->tableLogSummary.'.entityId', $showcaseEntityId);
        if(!empty($sectionId)) {
            $this->db->where($this->showcaseTableName.'.industryId', $sectionId);
        }
        // manage data on the basis of user type
        if(!empty($userType)) {
            switch($userType) {
                case 1 :
                    $userField = $this->showcaseTableName.'.creative';
                    break;
                case 2 :
                    $userField = $this->showcaseTableName.'.associatedProfessional';
                    break;
                case 3 :
                    $userField = $this->showcaseTableName.'.enterprise';
                    break;
                case 4 :
                    $userField = $this->showcaseTableName.'.fans';
                    break;
                default:
                    $userField = '';
                
            }
            if(!empty($userField)) {
                $this->db->where($userField, 't');
            }
        }
         // get result by the keayword if exists 
        if(!empty($keyword)) {
            $keyword = pg_escape_string(trim(strtolower($keyword)));  
            $this->db->like('LOWER("'.$tableUserShowcase.'"."firstName")', $keyword);
            $this->db->or_like('LOWER("'.$tableUserShowcase.'"."lastName")', $keyword);
            $this->db->or_like('LOWER("'.$tableUserShowcase.'"."enterpriseName")', $keyword);
        }
       
        if(!empty($limit) && !empty($offset)) {
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
        $query = $this->db->get();
        return $query->result(); 
    }
    
    public function craveList($userId=0, $projectType='',$searchKey='',$limit=0, $offset=0, $retrunRow=false){
		$search=$this->db->dbprefix('search');
		
		$this->db->select('lc.*');
		$this->db->select('search.*');
		$this->db->select('(item).*');
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,ls.reviewCount,ls.imageFileCount,ls.printCount,ls.docFileCount,ls.docCount,ls.audioFileCount,ls.cdCount,ls.videoFileCount,ls.dvdCount');
		$this->db->select('sc.profileImageName, sc.stockImageId, sc.creative, sc.associatedProfessional, sc.enterprise, sc.enterpriseName, sc.isPublished');
		$this->db->select('up.firstName,up.lastName');
		$this->db->select('si.stockImgPath, si.stockFilename');
        $this->db->select('ua.username');
		
		$this->db->from($this->tableLogCrave.' as lc');
		$this->db->join('search', 'search.entityid = lc.entityId AND "'.$search.'"."elementid"="lc"."elementId" ');
        $this->db->join($this->tableLogSummary.' ls', 'ls.entityId = lc.entityId AND "ls"."elementId"="lc"."elementId" ', 'left');
        $this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = lc.ownerId');
		$this->db->join($this->showcaseTableName.' as sc', 'sc.tdsUid = lc.ownerId');
		$this->db->join($this->tableStockImages.' as si', 'si.stockImgId = sc.stockImageId', 'left');
        $this->db->join($this->tableUserAuth.' as ua', 'ua.tdsUid = lc.ownerId','left');
		
        $searchKey=trim($searchKey);
		$searchKey=strtolower($searchKey);
        if(!empty($searchKey)){
            $array = array('LOWER((item).title)' => $searchKey, 'LOWER((item).tagwords)' => $searchKey, 'LOWER((item).online_desctiption)' => $searchKey, 'LOWER((item).creative_name)' => $searchKey, 'LOWER((item).creative_area)' => $searchKey);
            $this->db->or_like($array); 
        }
       
        $where['lc.tdsUid']=$userId;
        $where['search.ispublished']='t';
        $projectType=trim($projectType);
       
        
        $this->db->where($where);
        if(!empty($projectType)){
			if($projectType == 'media'){
                $projectType = array('filmNvideo','musicNaudio','photographyNart','writingNpublishing','educationMaterial');
            }elseif($projectType == 'member'){
                 $projectType = array('creatives','associatedprofessionals','enterprises','fans',);
            }
            $this->db->where_in('lc.projectType',$projectType);
		}
         
		$this->db->order_by("lc.craveId",'DESC');
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($retrunRow){
			$result=$query->num_rows();
        }else{ 
			$result=$query->result();
        }
		return $result;
	}
    
    public function cravingme($userId=0,$crvmePT='', $projectType='', $searchKey='', $limit=0, $offset=0, $retrunRow=false ){
		
        $entityId=getMasterTableRecord('UserShowcase');
			
		$this->db->select('lc.*');
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,ls.reviewCount');
		$this->db->select('sc.promotionalsection,sc.profileImageName, sc.stockImageId, sc.creative, sc.associatedProfessional, sc.enterprise, sc.enterpriseName, sc.isPublished');
		$this->db->select('up.firstName,up.lastName,up.tdsUid');
		$this->db->select('si.stockImgPath, si.stockFilename');
        $this->db->select('ua.username');
        $this->db->select('ind.IndustryName');
		
		$this->db->from($this->tableLogCrave.' as lc');
        $this->db->join($this->tableUserAuth.' as ua', 'ua.tdsUid = lc.tdsUid','left');
		$this->db->join($this->showcaseTableName.' as sc', 'sc.tdsUid = lc.tdsUid');
		$this->db->join($this->tableStockImages.' as si', 'si.stockImgId = sc.stockImageId', 'left');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = lc.tdsUid');
        $this->db->join($this->tableMasterIndustry.' as ind', 'ind.IndustryId = sc.industryId', 'left');

		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId=sc.showcaseId AND "ls"."entityId" = '.$entityId.' ', 'left');
		
		$searchKey=trim($searchKey);
        if(!empty($searchKey)){
            $searchKey=strtolower($searchKey);
            $array = array('LOWER(up."firstName")' => $searchKey, 'LOWER(up."lastName")' => $searchKey, 'LOWER(sc."enterpriseName")' => $searchKey);
			$this->db->or_like($array); 
        }
        
        $where['lc.ownerId']=$userId;
        $where['lc.projectType']=$crvmePT;
        $projectType=trim($projectType);
        if(!empty($projectType) && $projectType !== 0 && strlen($projectType) >=4){
			$where['sc.'.$projectType]='t';
		}
       
        $where['sc.isPublished']='t';	
		$this->db->where($where);
		$this->db->order_by("lc.craveId",'DESC');
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		}
		
		$query = $this->db->get();
		
		if($retrunRow){
			$result=$query->num_rows();
        }else{ 
			$result=$query->result();
            //echo $this->db->last_query();
        }  
		return $result;
	}
    
    public function craveDropDwon($userId=0,$cravingme=false){
		$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
		$search=$this->db->dbprefix('search');
		
		if($cravingme){
			$having['ownerId']=$userId;
			// ADD BY AMIT FOR DISTINCT SECTIONS CRAVED BY USER issue 1066
			//$this->db->distinct(' "'.$this->db->dbprefix($this->tableLogCrave).'"."projectType" ,"'.$this->db->dbprefix($this->tableLogCrave).'"."tdsUid" ');
		}else{
			$having['tdsUid']=$userId;
		}
		
		$this->db->select($this->tableLogCrave.'.projectType');
		$this->db->from($this->tableLogCrave);
		$this->db->join('search', 'search.entityid = '.$this->tableLogCrave.'.entityId AND "'.$search.'"."elementid"="'.$tableLogCrave.'"."elementId" ', 'left');
		
		$this->db->where('search.id >', 0);
		
		$this->db->where('search.ispublished','t');
		
		$this->db->group_by(array('search.section', 'search.entityid', 'search.elementid', 'ownerId' , 'tdsUid', 'projectType')); 
		
		$this->db->having($having); 
		
		$this->db->order_by($this->tableLogCrave.'.projectType','ASC');
		
		//if($cravingme)		
		// $this->db->order_by($this->tableLogCrave.'.tdsUid','ASC'); // ADD BY AMIT FOR DISTINCT SECTIONS CRAVED BY USER issue 1066
		
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		return $result=$query->result();
	}
    
}
?>
