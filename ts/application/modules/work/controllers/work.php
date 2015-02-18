<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
	 Description:
	 * The controller class "work" is meant to handle the processing of "Work Profile" section
	 * It include functionality to fetch/add/edit work address,sicaol media links,employment history,etc
	 *
	 * @package	Toadsquare
	 * @subpackage	Module
	 * @category	Controller
	 * Author Name: Gurutva Singh
	 * Date Created: 7 Februray 2012
	 * Date Modified: 27 Februray 2012
*/

class work extends MX_Controller {
	private $data = array();
	private $dirCachework = '';
	private $userId = null;
	
	private $gallery_thumb_version_folder = 'imageVersion';
	private $gallery_allowed_upload_img_orignal_suffix = '_orignal';
	
	private $gallery_allowed_upload_img_big_width = '480';
	private $gallery_allowed_upload_img_big_height = '480';
	private $gallery_allowed_upload_img_big_suffix = '_big';
	
	private $gallery_allowed_upload_img_medium_width = '240';
	private $gallery_allowed_upload_img_medium_height = '240';
	private $gallery_allowed_upload_img_medium_suffix = '_medium';
	
	private $gallery_allowed_upload_img_small_width = '160';
	private $gallery_allowed_upload_img_small_height = '160';
	private $gallery_allowed_upload_img_small_suffix = '_small';
	
	private $gallery_allowed_upload_img_extra_small_width = '100';
	private $gallery_allowed_upload_img_extra_small_height = '100';
	private $gallery_allowed_upload_img_extra_small_suffix = '_xsmall';	
	
	private $mediaPath = '';
	private $workPromotionMediaTable = 'workPromotionMedia';
	private $promoImageField = array('mediaId',
			'mediaType',
			'mediaTitle',
			'mediaDescription',
			'fileId',
			'workId',
			'isMain');

	function __construct(){
		$load = array(
				'model'		=> 'work/model_work_offered + tmail/model_tmail',
				'library' 	=> 'form_validation + upload + session + head + Lib_masterMedia + lib_sub_master_media + lib_image_config + lib_work',	 	
				'language' 	=> 'work + review',
				'helper' 	=> 'form + file'
			);
		parent::__construct($load);	
		//
		$this->dirCachework = 'cache/work/'; 
		$this->userId= $this->isLoginUser();
		$this->mediaPath = "media/".LoginUserDetails('username')."/work/" ;
	}
	/**
		* fetches the data to get shown as List for work type = 'offered' as default
	**/
	public function index($workType='offered',$isArchive='f') {
		
		$this->data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'work', $userNavigations, $key='section', $is_object=0 ))){ 
			
		}else{
			redirect('dashboard/work');
		}
		
		if($isArchive !== 't'){$isArchive='f' ;}
		$this->load->language('work'); // load language file for Film and Video
		$userId=$this->userId;
		$workId=0;
		$deletedItems='';
		
	
		//$this->data['countResult']=$this->model_common->countResult('Work',array('tdsUid'=>$userId,'workType'=>$workType,'workArchived'=>$isArchive,'workExpireDate >='=>date('Y-m-d')));
		$this->data['countResult']=$this->model_common->countResult('Work',array('tdsUid'=>$userId,'workType'=>$workType,'workArchived'=>$isArchive));
		 
		$pages = new Pagination_ajax;
		$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$this->data['perPageRecord'] =$this->config->item('perPageRecordWork');
		//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
		
		// Add by Amit to set cookie for Results per page
		if($this->input->post('ipp')!=''){
			$isCookie = setPerPageCookie($workType.'PerPageVal',$this->data['perPageRecord']);	
		}else {
			$isCookie = getPerPageCookie($workType.'PerPageVal',$this->data['perPageRecord']);		
		}
					
		$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
		
		
		
		$pages->paginate();
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		
		$work_data = $this->lib_work->getworkdetail($userId,0,$workType,1,$isArchive,$pages->offst,$pages->limit);
		
		$this->data['work'] = $work_data;
		$this->data['isArchive'] = $isArchive;
			
		if(!is_dir($this->dirCachework)){
			@mkdir($this->dirCachework, 0777, true);
		}
		$cmd3 ='chmod -R 777 '.$this->dirCachework;
		exec($cmd3);
		foreach($this->data['work'] as $pcount => $workDetail)
		{
			if($userId>0) {
				
			$cacheFile = $this->dirCachework.'work_'.$workDetail['workId'].'_'.$userId.'.php';
			$dataToWrite = 	$workDetail;
					
			if(!is_file($cacheFile)){	
				
				$data=str_replace("'","&apos;",json_encode($dataToWrite));	//encode data in json format
				$stringData = '<?php $ProjectData=\''.$data.'\';?>';
				if (!write_file($cacheFile, $stringData)){					// write cache file
					echo 'Unable to write the file';
				}
			}

			}	
		}//End Foreach					   
	
		$this->data['constant']=$this->lang->language ;		//load language data
		$this->data['workEntityId'] = getMasterTableRecord('Work');
		$this->data['workId'] = $workId ;
		$this->data['workType'] = $this->data['entityMediaType']= $workType ;

		//echo $this->data['workType'];
		$this->data['header']=$this->load->view('navigationMenu',$this->data,true);
		$this->data['mediumSuffix'] = $this->gallery_allowed_upload_img_medium_suffix;
		$this->data['suffix'] = $this->gallery_allowed_upload_img_small_suffix;
		$this->data['gallery_thumb_version_folder'] = $this->gallery_thumb_version_folder;
		//$this->data = $this->lib_work->keys;	

		
		$this->data['userId']=$this->userId;
		$this->data['workType'] = $workType ;
		
		$ajaxRequest = $this->input->post('ajaxRequest');
		if($ajaxRequest){
			
			 $this->load->view('work_listing',$this->data) ;
		}			   
		else{
			$this->data['header'] = $this->load->view('navigationMenu',$this->lib_work->keys,true);
			$breadcrumbItem=array('work',$workType);
			$breadcrumbURL=array('work/'.$workType,'');
			if($isArchive == 't'){
				$breadcrumbItem[]='deletedItems';
				$breadcrumbURL[]='work/'.$workType.'/deletedItems';
			}
			$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
			$this->data['breadcrumbString']=$breadcrumbString;
			//$this->template->load('template','workDetail',$this->data);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/work'),
							'isDashButton'=>true,
							'isWorkTool'=>1
				  );
			$leftView='dashboard/help_work';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workDetail',$this->data);
		}
	}

	public function deletedItems($workType='offered')
	{
		$this->index($workType,$isArchive='t');
	}

	public function offered($workId=0, $workInformation=''){
		if($workId === 'deletedItems'){
			$this->deletedItems('offered');
		}		
		else
		{
			if($workInformation == "description"){
				$this->addMoreWork($workId,'offered');
			}else if ($workInformation == "promotional_image"){
				$this->workPromotionalImages($workId,'offered');
			}else if ($workInformation == "promotional_video"){
				$this->workPromotionalVideo($workId,'offered');
			}else if ($workInformation == ''){
				$this->index('offered');
			}
		
		}
	}

	public function wanted($workId=0, $workInformation=''){
			if($workId === 'deletedItems'){
					$this->deletedItems('wanted');
			}
			else
			{
				if($workInformation == "description"){
					$this->addMoreWork($workId,'wanted');
				}else if ($workInformation == "promotional_image"){
					$this->workPromotionalImages($workId,'wanted');
				}else if ($workInformation == "promotional_video"){
					$this->workPromotionalVideo($workId,'wanted');
				}else if ($workInformation == ''){
					$this->index('wanted');
				}
	}
}
	/*
		* This function used to Insert/Update a record with validation of data
		* @access public
		* @params int workId,workType
		* Displays the form with filled value and if error displays the associated errors
	*/

	function addMoreWork($workId=0,$workType='offered')
	{
		
		$updateUserContainerFlag=false;
		$entityId=getMasterTableRecord('Work');	
		$sectionId=$this->config->item('worksSectionId');	
		$this->data['workType'] = $workType ;
		$userId = $this->userId;
		//If Users work project record not exist then redirect to nofound page
		if(isset($workId) && !empty($workId) && isset($userId)){
			$userDataWhere = array('workId'=>$workId,'tdsUid'=>$userId);
			checkUsersProjects('Work',$userDataWhere);
		}
		
		$data['constant']=$this->lang->language;
		
		if($this->input->post('save') == 'Save')
		{
		
		$workId = $this->input->post('workId')>0?$this->input->post('workId'):$workId;//Checks if workId is set or not
		//$embeddedURL = $this->input->post('isEmbbededURL');
		$embeddedURL = $this->input->post('myUpload');
		
		$remArr = array('field'  => 'workRemuneration','label'   =>  $data['constant']['workRemuneration'],'rules'   => 'trim|required|numeric|xss_clean');
		  
		$errorConfig = array(
		array(
			 'field'   => 'workTitle',
			 'label'   =>  $data['constant']['workTitle'],
			 'rules'   => 'trim|required|xss_clean'
		  ),
		  array(
			 'field'   => 'workCity',
			 'label'   =>  $data['constant']['workCity'],
			 'rules'   => 'trim|required|xss_clean'
		  ),
		   array(
			 'field'   => 'workShortDesc',
			 'label'   =>  $data['constant']['workOneLineDesc'],
			 'rules'   => 'trim|required|xss_clean'
		  ),
		   array(
			 'field'   => 'workTag',
			 'label'   =>  $data['constant']['workTagWords'],
			 'rules'   => 'trim|required|xss_clean'
		  ),
		   array(
			 'field'   => 'workDesc',
			 'label'   =>  $data['constant']['workDesc'],
			 'rules'   => 'trim|xss_clean'
		  ),
		   array(
			 'field'   => 'workTypeDesc',
			 'label'   =>  $data['constant']['workDesc'],
			 'rules'   => 'trim|xss_clean'
		  ),
		   array(
			 'field'   => 'workCountryId',
			 'label'   =>  $data['constant']['workCountry'],
			 'rules'   => 'trim|required|xss_clean'
		  ),
		   array(
			 'field'   => 'workLang1',
			 'label'   =>  $data['constant']['workLang1'],
			 'rules'   => 'trim|required|xss_clean'
		  ),
		  array(
			 'field'   => 'workIndustryId',
			 'label'   =>  $data['constant']['workRemuneration'],
			 'rules'   => 'trim|required|numeric'
		  ),
		  
		  array(
			 'field'   => 'workTypeAdditional',
			 'label'   =>  $data['constant']['workTypeAdditional'],
			 'rules'   => 'trim|xss_clean'
		  ),
		   array(
			 'field'   => 'workCompany',
			 'label'   =>  $data['constant']['workCompany'],
			 'rules'   => 'trim|xss_clean'
		  ),
		  
	);
		
				
		$this->form_validation->set_rules($errorConfig); //Setting rules for validation
		$this->form_validation->set_error_delimiters('<span class="validation_error">', '</span>');
		$fileName = '';
		if($this->form_validation->run())
		{	
				
			$dataSetValue = $this->lib_work->setValues($this->input->post());
			$data= $this->lib_work->getValues();
				
			$workUrgstatus = $this->input->post('isUrgent');
			$workExperieceWantedstatus = $this->input->post('workExperiece');

			if($workUrgstatus !=''){
				
				if($workUrgstatus =='accept') 
				{
					$workUrgent = 't';
					$workExpiryDate = date('Y-m-d  H:i:s', strtotime("+14 days"));
				}
				else 
				{
					$workUrgent = 'f';
					$workExpiryDate = date('Y-m-d  H:i:s', strtotime("+30 days"));
				}
				
				$data['isUrgent']  = $workUrgent;

				if($workExperieceWantedstatus !=''){
					if($workExperieceWantedstatus =='accept') 
					{
						$workExperiece = 't';
					}else 
					{
						 $workExperiece = 'f';
					}
					 $data['workExperiece']  = $workExperiece;
				}
			}
			else
			{
				$data['isUrgent']  = 'f';
				if($workExperieceWantedstatus =='accept') {
					$workExperieceWanted = 't';
					$workExpiryDate = date('Y-m-d  H:i:s', strtotime("+3 months"));
				}else
				{
					$workExperieceWanted = 'f';
					$workExpiryDate = date('Y-m-d  H:i:s', strtotime("+14 days"));
				}
				$data['workExperiece'] = $workExperieceWanted;
			}
				
			if($this->input->post('workRemuneration')=='')
				$data['workRemuneration'] = null;
				
			$offerWorkExpstatus = $this->input->post('workExperiece');
			 if($offerWorkExpstatus =='accept')
			 {
			  $offerWorkExp = 't';
			  $errorConfig=array_merge($errorConfig,$remArr);
			  $data['workRemuneration'] = null;
			 
			 }
			 else 
			 {
				 $offerWorkExp = 'f';
			 }

	
			 if($this->input->post('workLang3')=='')
				$data['workLang3'] = 0;
			 if($this->input->post('workLang2')=='')
				$data['workLang2'] = 0;

			$data['workTypeDesc'] = $this->input->post('workTypeDesc');
			$data['workCreateDate'] = date("Y-m-d H:i:s");
			$data['workPublisheDate'] =   date("Y-m-d H:i:s");
			$data['workEntryTime'] =   date("Y-m-d H:i:s");
			$data['workExpireDate'] =   $workExpiryDate;
			$data['workCityId'] =  0;
			$data['workCountry'] = '';
			$data['workPrice'] = '0.00';
			
			
			if($workId > 0) {
				unset($data['workCreateDate']);
				unset($data['workPublisheDate']);
				unset($data['workEntryTime']);
			   
				$data['workModifiedDate'] = date("Y-m-d H:i:s");			

			} else {
				
				$userContainerId=$this->lib_package->getUserContainerId($sectionId);
				$data['userContainerId']=$userContainerId;
				$updateUserContainerFlag=true;		
				unset($data['workId']);
				unset($data['workModifiedDate']);				
				
			}
			$inserteWorkId = $this->lib_work->save($data);
		
			if($updateUserContainerFlag && $inserteWorkId > 0){
				$this->lib_package->updateUserContainer($userContainerId,$entityId,$inserteWorkId,$sectionId,$sectionId);
			}
		
		//Creating cache file here
				
		if(!is_dir($this->dirCachework)){
			@mkdir($this->dirCachework, 777, true);
		}
		$cacheFile = $this->dirCachework.'work_'.$inserteWorkId.'_'.$userId.'.php';
		
		$dataToWrite = $this->writeWorkCache($workId,$workType);
		
		if($userId>0) {			
		
		if($dataToWrite && is_array($dataToWrite) && count($dataToWrite) > 0){
			
			$sectionid=11;
			$workData=$dataToWrite[0];
			
			$enterpriseName=pg_escape_string($workData['enterpriseName']);
			$enterpriseName=trim($enterpriseName);
			$creative_name=($workData['enterprise']=='t')?$enterpriseName:pg_escape_string($workData['firstName'].' '.$workData['lastName']);
				
			$searchDataInsert=array(
				"entityid"=>$entityId,
				"elementid"=>$workData['workId'],
				"projectid"=>$workData['workId'],
				"sectionid"=>$sectionid,
				"section"=>'work',
				"ispublished"=>$workData['isPublished']=='t'?'t':'f',
				"cachefile"=>$cacheFile,
				"item.title"=>pg_escape_string($workData['workTitle']), 
				"item.tagwords"=>pg_escape_string($workData['workTag']), 
				"item.online_desctiption"=>pg_escape_string($workData['workShortDesc']),
				"item.userid"=>$this->userId, 
				"item.creative_name"=>$creative_name, 
				"item.creative_area"=>pg_escape_string($workData['optionAreaName']),
				"item.languageid"=>$workData['workLang1']>0?$workData['workLang1']:0,  
				"item.language"=>$workData['Language_local'],
				"item.countryid"=>$workData['workCountryId']>0?$workData['workCountryId']:0, 
				"item.country"=>$workData['countryName'], 
				"item.industryid"=>$workData['workIndustryId']>0?$workData['workIndustryId']:0, 
				"item.industry"=>$workData['IndustryName'], 
				"item.creation_date"=>$workData['workCreateDate'], 
				"item.publish_date"=>$workData['workCreateDate'],
				"item.work_type"=>$workData['workType'],
				"item.sell_option"=>'free',
				"item.is_urgent_work"=>$workData['isUrgent']=='t'?'t':'f',
				"item.is_experience_work"=>$workData['workExperiece']=='t'?'t':'f'
			);
			$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
		}

		//require_once ($cacheFile);
		
		//$product_data = json_decode($product, true);
		}
				
				$msg = $this->lang->language['work'].' '.$workType.' '.$this->lang->language['workSavedSuccessfully'];
				set_global_messages($msg, 'success');
				
				if($workId > 0) {
					redirect("work/".$workType);
				}
			    else {
					//Set isShowWorkPopup session value
				 	//$workResultCount = $this->model_common->countResult('Work',array('tdsUid'=>$userId,'workType'=>$workType,'workArchived'=>'f','workExpireDate >='=>date('Y-m-d')));
				 	$workResultCount = $this->model_common->countResult('Work',array('tdsUid'=>$userId,'workType'=>$workType,'workArchived'=>'f'));
					if($workResultCount==1){
					$this->session->set_userdata('isShowWorkPopup',1);
					}
			    redirect("work/".$workType.'/'.$inserteWorkId.'/promotional_image');
				}
			
		}
		else
		{
			if(validation_errors())
			{
				$msg = array('errors' => validation_errors());
			}
		}
		}
		
		if($workId > 0)
		{
			$this->lib_work->keys['mode'] = 'edit';
		}
		else
		{
			$sectionId=$this->input->post('sectionId');
			$this->lib_package->setUserContainerId($sectionId);
			
			$this->lib_work->keys['mode'] = 'new';
			$this->lib_work->keys['workArchived'] = 'f';
		}
		
		$data1 = $this->lib_work->getValueToUpdate($workId);
		$data = $this->lib_work->keys;
		$data['constant']=$this->lang->language;
		$data['language'] = getlanguageList();
		$data['location'] = getCountryList();
		$industry = loadIndustry();
		$data['industry'][''] = 'Select Industry';
		foreach ($industry as $resultIndustry)
		{
			$data['industry'][$resultIndustry->IndustryId] = $resultIndustry->IndustryName;
		}
		$data['tdsUid']=$this->userId;
		$data['countries'] = getCountryList();
		$data['workId'] = $workId ;
		$data['entityMediaType']=$workType ;
		$data['workType']=$workType ;
		$data['header']=$this->load->view('navigationMenu',$data,true);
		//$this->template->load('template','addMoreWork',$data); 
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/work'),
						'isDashButton'=>true,
						'isWorkTool'=>1
			  );
		$leftView='dashboard/help_work';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','addMoreWork',$data);
				  
	}

	public function deleteWork()
	{
		$workId =  decode($this->input->post('workId'));
		$workType = $this->input->post('workType');
		
		$cacheFile = $this->dirCachework.'work_'.$workId.'_'.$this->userId.'.php';
		
		if(is_file($cacheFile)){
			@unlink($cacheFile);
		}
		
		$this->model_work_offered->deleteWork($workId,$workType);
		
		$entityId=getMasterTableRecord('Work');
		if($workId > 0 && $entityId > 0){
			$whereField=array('entityid'=>$entityId,'elementid'=>$workId);
			$res=$this->model_common->getDataFromTabel('search', 'id',  $whereField, '', '', '', $limit=1 );
			if($res){
				$id=$res[0]->id;
				if($id > 0){
					$this->model_common->deleteRow('search',$where=array('id'=>$id));
				}
			}
		}

		$this->session->set_userdata('work_'.$workType.'_user',1);
		$this->session->set_userdata('work_'.$workType.'_user_'.$this->userId,1);
		$this->session->set_userdata('work_'.$workType.'_'.$workId.'_user_'.$this->userId,1);
		
		$cacheFile=$this->dirCachework.'work_user_'.$this->userId.'_'.$workType.'_.php';
		@unlink($cacheFile);
		$msg = $this->lang->language['workDeletedSuccessfully'];
		set_global_messages($msg, 'success');
		if($workType=='offered')
			redirect('work/offered');
		else if($workType=='wanted')
			redirect('work/wanted');
		else
			redirect('work/offered');
	}

	public function workPromotionalImages($workId=0,$workType='offered')
	{
		//If User project record not exist then redirect to nofound page
		if(isset($workId) && !empty($workId) && isset($this->userId)){
			$userDataWhere = array('workId'=>$workId,'tdsUid'=>$this->userId);
			checkUsersProjects('Work',$userDataWhere);
		}
		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		$this->data['workType'] = $workType;
		$this->data['userId'] = $this->userId;
		$ImgConfig = $this->lib_image_config->getImgConfigValue();
		$formType = $this->input->post('formtype');
		if(strcmp($formType,'promoImage')==0){
			$workPromotionalImages['promoDisplayStyle'] = 'style="display:block;"';
		}
		else{
			$workPromotionalImages['promoDisplayStyle'] = 'style="display:none;"';
		}
		$this->data['workId'] = $workId;
		$this->data['workId'] = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$this->data['workId'];//Checks if eventId is set or not

		$workPromotionalImages['label'] = $this->lang->language;
		
		$imagePath = $this->mediaPath.$workType.'/'.$this->data['workId'].'/images/';
		$cmd = 'chmod -R 777 '.$imagePath;
		exec($cmd);
		
		if($this->data['workId']>0){
			$workPromotionalImages['count'] =  $this->lib_sub_master_media->countPromotionMedia($this->workPromotionMediaTable,'workId',$this->data['workId'],'1','');
			if(strcmp($this->input->post('submit'),'Save')==0){
				$fileType = $this->input->post('fileType');
				$promoMediaFieldValues['mediaId'] = $this->input->post('mediaId');
				$promoMediaFieldValues['mediaTitle'] = $this->input->post('mediaTitle');
				$promoMediaFieldValues['mediaDescription'] = $this->input->post('mediaDescription');
				$promoMediaFieldValues['mediaType'] = $fileType;
				$promoMediaFieldValues['workId'] = $this->data['workId'];			

				if(!is_dir($this->mediaPath)){
				mkdir($this->mediaPath, 777, true);
				}
				$cmd1 = 'chmod -R 777 '.$this->mediaPath;
				exec($cmd1);

				if(!is_dir($this->mediaPath.$workType)){
					mkdir($this->mediaPath.$workType, 777, true);
				}
				$cmd2 = 'chmod -R 777 '.$this->mediaPath.$workType;
				exec($cmd2);

				if(!is_dir($this->mediaPath.$workType.'/'.$this->data['workId'])){
					mkdir($this->mediaPath.$workType.'/'.$this->data['workId'], 777, true);
				}
				$cmd3 = 'chmod -R 777 '.$this->mediaPath.$workType.'/'.$this->data['workId'];
				exec($cmd3);

				if(!is_dir($this->mediaPath.$workType.'/'.$this->data['workId'].'/images/')){
					mkdir($this->mediaPath.$workType.'/'.$this->data['workId'].'/images/', 777, true);
				}
				$cmd = 'chmod -R 777 '.$this->mediaPath.$workType.'/'.$this->data['workId'].'/images/';
				exec($cmd);

				if($promoMediaFieldValues['mediaId'] > 0){
					$promoMediaFieldValues['isMain'] = $this->input->post('isMain');
					}
				else if($workPromotionalImages['count'] <=0){
					$promoMediaFieldValues['isMain'] = 't';
				}else
				{
					$promoMediaFieldValues['isMain'] = 'f';
				}
				$returnUrl = "work/".$workType."/".$this->data['workId'].'/promotional_image';
				//echo $returnUrl; ;
				$uploadArray = $_FILES;
				
				saveUploadPromoMedia($this->workPromotionMediaTable,$this->promoImageField,$promoMediaFieldValues,$imagePath,$uploadArray,$this->data['workId'],$fileType,$returnUrl,$ImgConfig);
				redirect("work/".$workType."/".$this->data['workId'].'/promotional_image');
			}
			
			$orderBy = 'isMain';
			$ImgConfig = $this->lib_image_config->getImgConfigValue();
			
			$workPromotionalImages['mediaType'] = $ImgConfig['mediaConfig']['mediaType'];
			$workPromotionalImages['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->workPromotionMediaTable,$this->promoImageField,'workId',$workId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
			$workPromotionalImages['workId'] = $workId;
			$workPromotionalImages['entityMediaType'] = $workType;
			$workPromotionalImages['header'] = $this->load->view('navigationMenu',$workPromotionalImages,true);
			$workPromotionalData['promoElementTable'] = $this->workPromotionMediaTable;
			$workPromotionalData['promoElementFieldId'] = 'mediaId';
			$workPromotionalImages['makeFeatured'] = 1;
			$workPromotionalImages['promoImageId'] = $workId;
			$workPromotionalData['promoImagePath'] = $imagePath;		
			$workPromotionalImages['label'] = $this->lang->language;
			
			if(strcmp($workType,'offered')==0)
				$workPromotionalImages['eventPromoImages']['defaultImage'] = $this->config->item('defaultWorkOffered_s');
			else 
				$workPromotionalImages['eventPromoImages']['defaultImage'] = $this->config->item('defaultWorkWanted_s');	
			
			$workPromotionalData['workPromotionalImages'] = $workPromotionalImages;
			$workPromotionalData['entityId'] = $workId;
			$workPromotionalData['promoEntityField'] = 'workId';
			$workPromotionalData['browseImgJs'] = 'image';	
			$workPromotionalData['entityMediaType'] = $workType;
			
			
			
			$fileMaxSize=$this->config->item('defaultContainerSize');
			$workPromotionalData['containerDetails'] = $this->model_common->getContainerDetails('Work',array('workId'=>$this->data['workId']));
			
			
			if(isset($workPromotionalData['containerDetails'][0]['containerSize']) && $workPromotionalData['containerDetails'][0]['containerSize'] > 0 ){
				$containerSize=$workPromotionalData['containerDetails'][0]['containerSize'];
				
				$dirname=$this->mediaPath;
				$dirSize=getFolderSize($dirname);
				$remainingBytes =($containerSize - $dirSize);
				if(!$remainingBytes > 0){
					$remainingBytes =0;
				}
				
				$containerSize=bytestoMB($containerSize,'mb');
				$dirSize=bytestoMB($dirSize,'mb');
				$remainingSize=($containerSize-$dirSize);
				if($remainingSize < 0){
						$remainingSize = 0;
				}
				$dirSize = number_format($dirSize,2,'.','');
				$remainingSize = number_format($remainingSize,2,'.','');
				$fileMaxSize=$remainingBytes;
			}
			$workPromotionalData['fileMaxSize']= $fileMaxSize;
			$workPromotionalData['workType'] = $workType;
			$workPromotionalData['userId'] = $this->userId;	
				
			//$this->template->load('template','workPromotionalImages',$workPromotionalData);
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/work'),
							'isDashButton'=>true,
							'isWorkTool'=>1
				  );
			$leftView='dashboard/help_work';
			$workPromotionalData['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workPromotionalImages',$workPromotionalData);
			
		} else {
			$msg = $this->lang->language['enterWork'];
			set_global_messages($msg, 'error');
			redirect("work/".$workType);
		}
	}
	
	/* For multiple images creation --- Not in use for now just as a backup*/
	function createMultiThumb($imageStuff,$workType='',$workId='')  //file name passed
	{  	
	
	$gallery_thumbs_folder = $this->gallery_thumb_version_folder.'/';
	
	//$galleryThumbsFolderPath = MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/'.$gallery_thumbs_folder;
	
	if(($workType!='') && ($workId!='')){
		$galleryThumbsFolderPath = MEDIAUPLOADPATH.LoginUserDetails('username').'/work/'.$workType.'/'.$workId.'/images/'.$gallery_thumbs_folder;
	}
	
	if (!file_exists($galleryThumbsFolderPath)) {
		if (!mkdir($galleryThumbsFolderPath, 0777, true)) {
			('Failed to create folders...');
		}
	}
		// Use strrpos() & substr() to get the file extension
		$ext = substr($imageStuff['filename'], strrpos($imageStuff['filename'], "."));
		// Then stitch it together with the new string and file's basename
		$orgImageName = $imageStuff['filename'];
		// this thumbnail created
		$config['image_library'] = 'gd2';
		if(($workType!='') && ($workId!='')){
			$config['source_image']    = MEDIAUPLOADPATH.LoginUserDetails('username').'/work/'.$workType.'/'.$workId.'/images/'.$orgImageName;
		}
		$config['create_thumb'] = FALSE;   
		$config['maintain_ratio'] = TRUE;
		$config['width']     = $imageStuff['width'];
		$config['height']   = $imageStuff['height'];
		
		// Then stitch it together with the new string and file's basename
		$newImageName = basename($imageStuff['filename'], $ext) . $imageStuff['suffix'] . $ext;

		$config['new_image'] = $galleryThumbsFolderPath.$newImageName;
		$this->load->library('image_lib', $config);
		$this->image_lib->initialize($config);
		if ( ! $this->image_lib->resize()){echo $this->image_lib->display_errors();}

		$this->image_lib->clear();
		return $newImageName;
	}


	public function workPromotionalVideo($entityId=0, $workType='offered')
	{
		//If User project record not exist then redirect to nofound page
		if(isset($entityId) && !empty($entityId) && isset($this->userId)){
			$userDataWhere = array('workId'=>$entityId,'tdsUid'=>$this->userId);
			checkUsersProjects('Work',$userDataWhere);
		}
			
		if($entityId>0){
			$workPromotionalVideo['workPromotionMediaRecordSet'] =  $this->model_common->PromotionVideoRecordSet($this->workPromotionMediaTable,'workId',$entityId,2);		
		}
	
		$this->data['workId'] = $entityId;
		$this->data['workId'] = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$this->data['workId'];//Checks if eventId is set or not

		$workPromotionalVideo['constant'] = $this->lang->language;
		$this->data['checkVideoCount'] =  $this->lib_sub_master_media->countPromotionMedia($this->workPromotionMediaTable,'workId',$this->data['workId'],'2','');
		
		if($entityId >0){
			$VideoPath = 'media/'.LoginUserDetails('username').'/work/'.$workType.'/'.$entityId.'/video/';
			if($this->input->post('save')=='Save'){
			
			if($this->input->post('embedVideo')==''){
				
				$uploadedData = array(); // File Upload code
				

				if(!is_dir($this->mediaPath)){
					mkdir($this->mediaPath, 777, true);
					}
				$cmd1 = 'chmod -R 777 '.$this->mediaPath;
				exec($cmd1);
					
				if(!is_dir($this->mediaPath.$workType)){
						mkdir($this->mediaPath.$workType, 777, true);
					}
				$cmd2 = 'chmod -R 777 '.$this->mediaPath.$workType;
				exec($cmd2);

				if(!is_dir($this->mediaPath.$workType.'/'.$entityId)){
						mkdir($this->mediaPath.$workType.'/'.$entityId, 777, true);
					}
				$cmd3 = 'chmod -R 777 '.$this->mediaPath.$workType.'/'.$entityId;
				exec($cmd3);

				if(!is_dir($this->mediaPath.$workType.'/'.$entityId.'/video/')){
						mkdir($this->mediaPath.$workType.'/'.$entityId.'/video/', 777, true);
					}
				$cmd = 'chmod -R 777 '.$this->mediaPath.$workType.'/'.$entityId.'/video/';
				exec($cmd);

				$uploadedData = $this->lib_sub_master_media->do_upload($_FILES,$VideoPath,$entityId,2);
				if($this->input->post('embedVideo')!='')
				{
					if(!isset($uploadedData['error'])){
							$workVideoName = $uploadedData['upload_data']['file_name'];
					}else{
						echo $message= $uploadedData['error'];
						$this->session->set_flashdata('error',$message);
						//redirect("work/".$workType.'/'.$entityId.'/promotional_video');
					}
				}
			}
						
			//echo '<pre />';print_r($_POST);
			
			$mediaData->workId = $entityId;
			$mediaData->userId = $this->userId;
			$mediaData->mediaTitle = $this->input->post('fileTitle');
			$mediaData->videoPrmotionMediaType = 2;
			$mediaData->videoCategory = $workType;
			if(isset($_POST['embedVideo']) && $_POST['embedVideo']!='')
			{
				$mediaData->videoPromotionMediaName = $_POST['embedVideo']; 
				$mediaData->videoPromotionMediaPath = '';
			}
			else
			{
				if(isset($workVideoName)){
				$mediaData->videoPromotionMediaName = $workVideoName;
				$mediaData->videoPromotionMediaPath = $VideoPath;
				}
				
			}
			//echo $this->data['checkVideoCount'];
			if($this->data['checkVideoCount'] > 0 )
			{
				$this->data['saveVideo'] = $this->model_common->updatePromotionVideo($this->workPromotionMediaTable,$mediaData,'workId',$entityId);
			}
			else
			{
				$this->data['saveVideo'] = $this->model_common->insertPromotionVideo($this->workPromotionMediaTable,$mediaData,'workId',$entityId);
			}

			$cacheFile=$this->dirCacheWork.'work_user_'.$this->userId.'_'.$workType.'_.php';
			@unlink($cacheFile); // Delete Cache file to show the image in FIrst page as work Image.

			$Upload_File_Name['error'] = $this->lang->language['workPromotionVideoSaved'];
			set_global_messages($Upload_File_Name['error'], 'success');
			redirect("work/".$workType.'/'.$entityId.'/promotional_video');
			}

			$orderBy = '';
			$ImgConfig = $this->lib_image_config->getImgConfigValue();

			$workPromotionalVideo['mediaType'] = $ImgConfig['mediaConfig']['mediaType'];
			$workPromotionalVideo['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->workPromotionMediaTable,$this->promoImageField,'workId',$entityId,1,$orderBy,'');
			
			$workPromotionalVideo['workId'] = $entityId;
			$workPromotionalVideo['workType'] = $workType;
			$workPromotionalVideo['entityMediaType'] = $workType;
			$workPromotionalVideo['header']=$this->load->view('navigationMenu',$workPromotionalVideo,true);
			
			$workPromotionalVideo['workVideoPath'] = $VideoPath;
			$workPromotionalVideo['totalMediaFile'] = $this->data['checkVideoCount'];
			$workPromotionalVideo['elementFieldId'] = 'mediaId';
			$workPromotionalVideo['tableName'] = $this->workPromotionMediaTable;
			$workPromotionalVideo['workType'] = $workType;			
			
			$workPromotionalVideoData['workPromotionalVideo'] = $workPromotionalVideo;
			$this->load->view('workPromotionalVideo',$workPromotionalVideo);
			}
			else {
				$msg = $this->lang->language['enterWork'];
				set_global_messages($msg, 'error');
				redirect("work/".$workType);
			}
		}

		
	function uploadMediaView()
	{		
		$mediaType = $this->input->post('val1');
		$fileSize = $this->input->post('val2');
		$fileType = $this->input->post('val3');
		$filePath = $this->input->post('val4');
		$isEmbed = $this->input->post('val5');
		$embedPath = $this->input->post('val6');
		$browseId = $this->input->post('val7')?$this->input->post('val7'):'';
		$mediaTypeToShow = 'video';
		$showEmbed = 0;
		if($isEmbed=='f') $embedPath='';
		$data = array('browseId'=>$browseId,'fileType'=>$fileType,'fileMaxSize'=>$fileSize,'isEmbed'=>$isEmbed,'fileName'=>'','required'=>'required','fileSize'=>$fileSize,'filePath'=>$filePath,'embedCode'=>$embedPath, 'label'=>$this->lang->line('file'), 'view'=>'uploadFileForm','flag'=>$showEmbed,'editFlag'=>false,'mediaTypeToShow'=>$mediaTypeToShow);
		echo Modules::run("common/formInputField",$data);
	}
	
	function deleteworkPromotionImage($promotionMediaId,$workId,$workCategory='offered',$workType)
	{
		$chcekForFeaturedImage = $this->model_work_offered->chcekForFeaturedImage($workId,$workCategory);
		//echo $chcekForFeaturedImage;
		$getDetails = $this->model_work_offered->getImageDetail($promotionMediaId);
		$imgPath = $getDetails->workPromotionMediaPath; 
		$imgName = $getDetails->workPromotionMediaName; 
		$this->model_work_offered->deleteworkPromotionMedia($promotionMediaId);
		if($chcekForFeaturedImage == $promotionMediaId)
		{
				$updatePromotionImageStatus = $this->model_work_offered->updatePromotionImageStatus($workId,$workCategory);
				$cacheFile=$this->dirCachework.'work_user_'.$this->userId.'_'.$workCategory.'_.php';
				@unlink($cacheFile);
		}
		
		@unlink($imgPath.$imgName);
		$Upload_File_Name['error'] = $this->lang->language['workImageDeleted'];
		set_global_messages($Upload_File_Name['error'], 'success');
		redirect("work/".$workCategory.'/'.$workId.'/promotional_image');
	}

	/*
	Function to Change the Image status from False(Non featured) to True(Featured)
	1. chcekworkPromotionMediaExists: Check For image Exists or not
	2. chcekFeaturedImageChangeStatus: Check for the already Featured image and than make it Non featured
	3. changeworkPromotionMediaStatus: Change the currunt Image status to the Featured
	4. Redirected to the addMoreImages
	Paramteres : ImageId, workId
	*/

	public function changeImageStatus($imageId,$workId,$workType='offered')
	{
		$promotionImageId =  $imageId;
		$chcekExists = $this->model_work_offered->chcekworkPromotionMediaExists($promotionImageId,$workType);
		if($chcekExists==1){
			$chcekFeaturedImageChangeStatus = $this->model_work_offered->chcekFeaturedImageChangeStatus($workId);
			$this->model_work_offered->changeworkPromotionMediaStatus($promotionImageId,$workId);

			$cacheFile=$this->dirCachework.'work_user_'.$this->userId.'_'.$workType.'_.php';
			@unlink($cacheFile);

			$Upload_File_Name['error'] = $this->lang->language['featuredImageChanged'];
			set_global_messages($Upload_File_Name['error'], 'success');
			//redirect("work/addMoreImages/".$workId."/".$workType);
			redirect("work/".$workType.'/'.$workId.'/promotional_image');
		}else
		{
			$Upload_File_Name['error'] = "not a valid Id";
			set_global_messages($Upload_File_Name['error'], 'error');
			//redirect("work/addMoreImages/".$workId."/".$workType);
			redirect("work/".$workType.'/'.$workId.'/promotional_image');
		}
	}

	function workArchiveOffered($workType='offered')
	{
		$workId = $this->input->post('workId');

		if(isset($workId) && $workId!='')
		$workId = decode($workId);
		$forUserWorkType = 'offered';

		$workAction = $this->input->post('workAction');		
		$workReturnAction = $this->router->method;	
			
		if(isset($workId) && $workId !='')
		{
			$this->session->set_userdata('work_'.$workType.'_user',1);
			$this->session->set_userdata('work_'.$workType.'_user_'.$this->userId,1);
			$this->session->set_userdata('work_'.$workType.'_'.$workId.'_user_'.$this->userId,1);
			
			if(strcmp('archiveWork',$workAction) == 0)
				$this->model_work_offered->archiveWork($workId);	
			if(strcmp('pDeleteWork',$workAction) == 0){
				$checkWorkIdInApplication = $this->model_work_offered->checkWorkId($workId);
			
				if($checkWorkIdInApplication > 0){
					//$this->session->set_flashdata('error_msg', "This Work can not be deleted!! Already in use with Work application.");
					$Upload_File_Name['error'] = 'This Work can not be deleted!! Already in use with Work application.';
					set_global_messages($Upload_File_Name['error'], 'error');
					redirect("work/workArchiveOffered");
				}else{
					$this->model_work_offered->pDeleteWork($workId,$forUserWorkType);
					//$this->session->set_flashdata('success_msg', "Work deleted permanently!!");
					$Upload_File_Name['error'] = 'Work deleted permanently!!';
					set_global_messages($Upload_File_Name['error'], 'success');
					redirect("work/workArchiveOffered");
				}
			}
		}
		
		$data['label'] = $this->lang->language;

		$data['work'] = $this->model_work_offered->workArchive($forUserWorkType);

		//$this->template->load('template','workoffered/work_offered',$data); 	
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/work'),
						'isDashButton'=>true,
						'isWorkTool'=>1
			  );
		$leftView='dashboard/help_work';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','workoffered/work_offered',$data);
		
	}

	function workArchiveWanted()
	{
		$workId = $this->input->post('workId');

		if(isset($workId) && $workId!='')
		$workId = decode($workId);

		$postWorkType = $this->input->post('workType');
		$forUserWorkType = 'wanted';

		$workAction = $this->input->post('workAction');		
		$workReturnAction = $this->router->method;		
		if(isset($workId) && $workId !='')
		{
			
		$this->session->set_userdata('work_'.$workType.'_user',1);
		$this->session->set_userdata('work_'.$workType.'_user_'.$this->userId,1);
		$this->session->set_userdata('work_'.$workType.'_'.$workId.'_user_'.$this->userId,1);
			
			if(strcmp('archiveWork',$workAction) == 0)
				$this->model_work_offered->archiveWork($workId);	
			if(strcmp('pDeleteWork',$workAction) == 0){
				$checkWorkIdInApplication = $this->model_work_offered->checkWorkId($workId);
			
				if($checkWorkIdInApplication > 0){
					//$this->session->set_flashdata('error_msg', "This Work can not be deleted!! Already in use with Work application.");
					$Upload_File_Name['error'] = 'This Work can not be deleted!! Already in use with Work application.';
					set_global_messages($Upload_File_Name['error'], 'success');
					redirect("work/workArchiveWanted");
				}else{
					$this->model_work_offered->pDeleteWork($workId,$forUserWorkType);
					//$this->session->set_flashdata('success_msg', "Work deleted permanently!!");
					$Upload_File_Name['error'] = 'Work deleted permanently!!';
					set_global_messages($Upload_File_Name['error'], 'success');
					redirect("work/workArchiveWanted");
				}
			}
		}
		$data['label'] = $this->lang->language;

		$data['work'] = $this->model_work_offered->workArchive($forUserWorkType);
		//$this->template->load('template','workwanted/work_wanted',$data); 
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/work'),
						'isDashButton'=>true,
						'isWorkTool'=>1
			  );
		$leftView='dashboard/help_work';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','workwanted/work_wanted',$data);
	}

	function get_cities($country){
		//header('Content-Type: application/x-json; charset=utf-8');
		$resultCities = json_encode($this->model_work_offered->get_cities($country));	
		echo($resultCities);
	}	

	/**
		* Display the list of records for work for which user has applied
	**/
	function workAppliedFor()
	{
		$userId = isLoginUser(); 
		$this->data['constant']=$this->lang->language ;		//load language data
		$this->data['workId'] = '';
		$this->data['entityMediaType'] = '';
		$this->data['header']=$this->load->view('navigationMenu',$this->data,true);
		$this->data['workApplied'] =$this->model_tmail->getWorkAppliedFor($userId);	
		$this->data['currentUserId'] = $userId;		
		//$this->template->load('template','work_applied_for',$this->data); 
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/work'),
						'isDashButton'=>true,
						'isWorkTool'=>1
			  );
		$leftView='dashboard/help_work';
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','work_applied_for',$this->data);
	}

	/**
		* Display the list of records for work for which user has applied
	**/
	function workApplicationsReceived()
	{
		$userId = isLoginUser(); 
		$this->data['constant']=$this->lang->language ;		//load language data
		$this->data['workId'] = '';
		$this->data['entityMediaType'] = '';
		$this->data['header']=$this->load->view('navigationMenu',$this->data,true);
		
		$this->data['workClassfied'] = $this->model_work_offered->getUserClassfied($userId);
		$this->data['currentUserId'] = $userId;
				
		//$this->template->load('template','work_application_received',$this->data);
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/work'),
						'isDashButton'=>true,
						'isWorkTool'=>1
			  );
		$leftView='dashboard/help_work';
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','work_application_received',$this->data);
		
	}

	function do_upload_video($videoFiles,$workId,$workType)
	{
		$data = '';
		$userFolder = MEDIAUPLOADPATH.LoginUserDetails('username').'/work/'.$workType.'/'.$workId.'/video';

		if(!is_dir($userFolder)){
			mkdir($userFolder, 0777, true);
		}
		//@chmod($userFolder,0777);
		$imagePath = 'media/'.LoginUserDetails('username').'/work/'.$workType.'/'.$workId.'/video';
		//	echo $imagePath;

		$_FILES['userfile']['name']     = $videoFiles['userfile']['name'];
		$_FILES['userfile']['type']     = $videoFiles['userfile']['type'];
		$_FILES['userfile']['tmp_name'] = $videoFiles['userfile']['tmp_name'];
		$_FILES['userfile']['error']    = $videoFiles['userfile']['error'];
		$_FILES['userfile']['size']     = $videoFiles['userfile']['size'];

		$config['allowed_types'] 	= 'flv|mpeg|mp4|avi';
		$config['max_size']		= '50000';
		$config['max_width']  		= '';
		$config['max_height']  		= '';

		$this->upload->initialize($config);
		$this->upload->set_upload_path($imagePath);
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload()){
			$data = array('error' => $this->upload->display_errors());
		}
		else{
			$data = array('upload_data' => $this->upload->data());
		}
		return $data;
	}

	function previewWork($workId,$workType) //workType = sale/wanted/freeStuff
	{
		$this->data['work'] = $this->model_work_offered->workRecordSet($workId,$workType);	
		$this->data['label'] = $this->lang->language; //load language variable
		$this->data['entityMediaType']=$workType ;
		$this->data['workId']=$workId ;
		$this->data['header']=$this->load->view('navigationMenu',$this->data,true);
		$isAjaxHit = $this->input->get('ajaxHit');
		if($isAjaxHit){
			$this->load->view('previewWork',$this->data);
		}	
		else {
			//$this->template->load('template','previewWork',$this->data);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/work'),
							'isDashButton'=>true,
							'isWorkTool'=>1
				  );
			$leftView='dashboard/help_work';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','previewWork',$this->data);
		}	
	}

	function previewVideo($videoId)
	{
		$this->data['getVideoDetail'] =  $this->model_work_offered->getVideoDetail($videoId,2);
		//echo "<pre />"; print_r($this->data['getVideoDetail']);
		$isAjaxHit = $this->input->get('ajaxHit');
		if($isAjaxHit){
			$this->load->view('previewVideoWork',$this->data);
		} else {
			//$this->template->load('template','previewVideoWork',$this->data);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/work'),
							'isDashButton'=>true,
							'isWorkTool'=>1
				  );
			$leftView='dashboard/help_work';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','previewVideoWork',$this->data);
		}
	}

	public function makeFeatured($mediaId,$entityId,$mediaType,$workType)
	{
		$promotionImageId =  $mediaId;
		$chcekFeaturedImage = chcekFeaturedImageChangeStatus($this->workPromotionMediaTable,'workId',$entityId,$mediaType);
		$this->model_common->changePromotionMediaStatus($this->workPromotionMediaTable,$promotionImageId,'workId',$entityId);
		
		$message = $this->lang->language['featuredImageChanged'];
		set_global_messages($message, 'success');
		redirect("work/".$workType.'/'.$entityId.'/promotional_image');
	}

	//////////////////////////////// Delete Image Functionality ///////////////////////////////////////
	
	function deletePromotionImage($mediaId, $entityId,$workType)
	{
		
		//$getFileType = getMediaFileType($this->workPromotionMediaTable,'mediaType', $mediaId); // Image or video
		$getFileType=2;
		$result = $this->model_common->deleteMedia($this->workPromotionMediaTable,$mediaId,'workId',$entityId);
		
		$this->session->set_userdata('work_'.$workType.'_user',1);
		$this->session->set_userdata('work_'.$workType.'_user_'.$this->userId,1);
		$this->session->set_userdata('work_'.$workType.'_'.$workId.'_user_'.$this->userId,1);
		
		if($getFileType==1){
			$message =  $this->lang->language['workImageDeleted'];			
		}else if($getFileType==2){
			$message =  $this->lang->language['workVideoDeleted']; 
			set_global_messages($message, 'success');
			//redirect("work/".$workType.'/'.$entityId.'/promotional_video');
		}
			
			//redirect("work/".$workType.'/'.$entityId.'/promotional_image');
			//$this->loadView();
			$listArray['currentEntityId'] ='';
			$listArray['delMediaAction'] = '';
			$listArray['showDelFlag'] = '';
			$listArray['returnUrl'] = '';
			$listArray['label'] = $this->lang->language;
			//$listArray['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($data['elemetTable'],$pKey,$data['dataProject']['entityField'],$data['dataProject']['entityId'],1,'','');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
			//Go back to orignal page with error
					
			if(isset($_SERVER['HTTP_REFERER']))
			{
				$baclLink=$_SERVER['HTTP_REFERER'];
			}
			else
			{
				$baclLink='';
			}

			redirect($baclLink);		
			
	}
	
	function deletePermanently($workId,$workType)
	{
		$this->model_work_offered->deletePermanently($workId,$workType);
		
		$this->session->set_userdata('work_'.$workType.'_user',1);
		$this->session->set_userdata('work_'.$workType.'_user_'.$this->userId,1);
		$this->session->set_userdata('work_'.$workType.'_'.$workId.'_user_'.$this->userId,1);
		
		$cacheFile=$this->dirCachework.'work_user_'.$this->userId.'_'.$workType.'_.php';
		@unlink($cacheFile);
		$msg = $this->lang->language['workDeletedSuccessfully'];
		set_global_messages($msg, 'success');
		if($workType=='offered')
			redirect('work/offered');
		else if($workType=='wanted')
			redirect('work/wanted');
		else
			redirect('work/offered');
	}

	
	function restoreRecord($workId,$workType)
	{
		$this->model_work_offered->restoreRecord($workId,$workType);
		
		//To make cache writable again
		
		$this->session->set_userdata('work_'.$workType.'_user',1);
		$this->session->set_userdata('work_'.$workType.'_user_'.$this->userId,1);
		$this->session->set_userdata('work_'.$workType.'_'.$workId.'_user_'.$this->userId,1);
		
		$msg = $this->lang->language['recordRestore'];
		set_global_messages($msg, 'success');
		if($workType=='offered')
			redirect('work/offered');
		else if($workType=='wanted')
			redirect('work/wanted');
		else
			redirect('work/offered');
	}
	
	
	
	function getReceivedData($workId)
	{	
		$userId = isLoginUser();	
		$data['appReceived'] =$this->model_tmail->getWorkAppReceived($workId);	
		$data['currentUserId'] = $userId;		
		$this->load->view('receivedView',$data);		
	 //echo "<pre/>";	
	 //print_r($res);	die;		
	}
	
/* Generate Cache file for Work */
	
   function writeWorkCache($workId,$workType){
	
	  $userId = $this->userId;	 
	  $dataToWrite = $this->model_work_offered->getworkdetail($userId,$workId,$workType,1);
		
		$cmd3 ='chmod -R 777 '.$this->dirCachework;
		exec($cmd3);		
		
		$cacheFile = $this->dirCachework.'work_'.$workId.'_'.$userId.'.php';
			$data=str_replace("'","&apos;",json_encode($dataToWrite));	//encode data in json format
			$stringData = '<?php $ProjectData=\''.$data.'\';?>';
			if (!write_file($cacheFile, $stringData)){					// write cache file
				echo 'Unable to write the file';
			}
			
	    return $dataToWrite;       
    }


}//End Class
?>
