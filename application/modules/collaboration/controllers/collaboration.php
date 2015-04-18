<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare Collaboration Controller Class
 *
 *  manage Collaboration details
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
Class Collaboration extends MX_Controller{
	
	var $userId;
	var $data;
	private $dirCache = '';
	private $dirUpload = '';
	private $collaborationData = array();
	
	function __construct() { 
		$load = array(
			'language'	=> 'collaboration',
			'helper'   => 'collaboration',
			'config'   => 'collaboration',
			'model'		=> 'model_collaboration + tmail/model_tmail + messagecenter/model_message_center',
			'library'	=> 'lib_collaboration + tmail/Tmail_messaging + messagecenter/lib_message_center'
		);
		parent::__construct($load);
		
		$this->userId= isLoginUser();
			
		$this->dirCache = 'cache/collaboration/';  
		$this->dirUpload = 'media/'.LoginUserDetails('username').'/collaboration/'; 
		$this->dirTrash = 'trash/'.LoginUserDetails('username').'/collaboration/'; 
		$this->collaborationData = $this->lib_collaboration->getValues();
		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
	}
	
	public function index($collaborationId=0, $isArchive='f') {
		$this->userId= $this->isLoginUser();
		
	
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$isArchive = ($isArchive=='t')?'t':'f';
		
		$where['clb.isArchive']=$isArchive;
		$where['clb.userId']=$this->userId;
		if($collaborationId > 0){
			$where['clb.collaborationId']=$collaborationId;
		}
		$this->data['collaborationData'] = $this->model_collaboration->getCollaborationDetails($where);
		if(isset($this->data['collaborationData'][0]->collaborationId)){
			$collaborationId = $this->data['collaborationData'][0]->collaborationId;
		}
		
		$this->data['assignedCollaborationList'] = $this->model_collaboration->assignedCollaborationToUser(array('clb.isPublished'=>'t', 'cm.status'=>1, 'cm.userId'=>$this->userId));
		$this->data['collaborationList'] = $this->model_common->getDataFromTabel('Collaboration', 'title,collaborationId', array('userId' => $this->userId,'isArchive' => $isArchive), '', 'collaborationId', 'DESC');
		
		$this->data['entityId']=getMasterTableRecord('Collaboration');
		$this->data['collaborationId'] = $collaborationId;
		$this->data['isArchive'] = $isArchive;
		$this->data['sectionId'] = $this->config->item('collaborationSectionId');
		$this->data['section'] = 'collaboration';
		$this->data['currentMethod']='index';
		$this->data['welcomelink']=base_url(lang().'/dashboard/collaboration/');
		$this->data['userId']=$this->userId;
		$this->data['ownerId']=$this->userId;
		
		$leftView=$this->config->item('collaborationHelpPage');
		$this->data['header']=$this->load->view('collaboration_header',$this->data,true);
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
				
		$this->template->load('backend_template','index',$this->data);
	}
	
	public function deleteditems($collaborationId=0) {
		$this->index($collaborationId, 't');
	}
	
	function settings($method='description',$collaborationId=0){
		$this->data['mainHeader']='settings';
		$this->$method($collaborationId);
	}
	
	public function description($collaborationId=0) {
		$this->userId= $this->isLoginUser();
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$sectionId=$this->config->item('collaborationSectionId');
		
		$fileMaxSize = $this->config->item('defaultContainerSize');
		if($collaborationId==0){
			$userContainerId=$this->lib_package->setUserContainerId($sectionId);
			$UserContainerData=$this->model_common->getDataFromTabel('UserContainer', 'containerSize',  array('userContainerId'=>$userContainerId,'tdsUid'=>$this->userId,'isExpired'=>'f'), '', '', '', 1);
			if($UserContainerData && isset($UserContainerData[0]->containerSize)){
				$fileMaxSize = $UserContainerData[0]->containerSize;
			}
			
		}else{
			if($collaborationId > 0){
				
				$where['clb.userId']=$this->userId;
				$where['clb.collaborationId']=$collaborationId;
				
				$collaborationData=$this->model_collaboration->getCollaborationDetails($where);
				
				if($collaborationData && isset($collaborationData[0]->containerSize)){
					
					$this->collaborationData=$collaborationData=$collaborationData[0];
					$containerSize = $this->collaborationData->containerSize;
					$dirname=$this->dirUpload.$collaborationId;
					$dirSize=getFolderSize($dirname);
					$fileMaxSize =($containerSize - $dirSize);
					if(!$fileMaxSize > 0){
						$fileMaxSize =0;
					}
					
				}else{
					redirect('collaboration');
				}
			}else{
				redirect('collaboration');
			}
		}
		
		$this->data['dirMedia']=$this->dirUpload;
		$this->data['dirUpload']=$this->dirUpload.$collaborationId.'/';
		$this->data['fileMaxSize']=$fileMaxSize;
		$this->data['heading']='Description';
		$this->data['currentMathod']='description';
		$this->data['sectionId']=$sectionId;
		$this->data['entityId']=getMasterTableRecord('Collaboration');
		$this->data['collaborationId']=$collaborationId;
		$this->data['userId']=$this->userId;
		$this->data['ownerId']=$this->userId;
		$this->data['collaborationData']=$this->collaborationData;
		$this->data['countryList'] = getCountryList();
		$this->data['industryList'] = getIndustryList();
		$this->data['languageList'] = getlanguageList();
		
		$header=($this->router->fetch_method()=='settings')?'manage_header':'backendTab';
		$this->data['header']=$this->load->view($header,$this->data, true);
		
		$breadcrumbItem=array('collaboration','description');
		$breadcrumbURL=array('collaboration/index','collaboration/description'.$collaborationId);
		
		$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
		$this->data['breadcrumbString']=$breadcrumbString;
		$this->data['welcomelink']=base_url(lang().'/dashboard/collaboration/');
		
		$leftView=$this->config->item('collaborationHelpPage');
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		 
		
		$this->template->load('backend_template','description',$this->data);
		
	}
	
	
	public function saveDescription() {
		$this->userId= $this->isLoginUser();
		$config = array(
               array(
                     'field'   => 'industryId',
                     'label'   => 'Industry',
                     'rules'   => 'trim|xss_clean'
                  ),
				array(
                     'field'   => 'langId1',
                     'label'   => 'Language',
                     'rules'   => 'trim|xss_clean'
                  ),
				array(
                     'field'   => 'langId2',
                     'label'   => 'Language',
                     'rules'   => 'trim|xss_clean'
                  ),
				array(
                     'field'   => 'countryId',
                     'label'   => 'Country',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'title',
                     'label'   => 'Title',
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'tagwords',
                     'label'   => 'Tag Words',
                     'rules'   => 'trim|xss_clean'
                  ), 
                  
               array(
                     'field'   => 'shortDescription',
                     'label'   => 'One Line Description',
                     'rules'   => 'trim|xss_clean'
                  ),    
                    
               array(
                     'field'   => 'startDate',
                     'label'   => 'Start Date',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'endDate',
                     'label'   => 'End Date',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'isEvent',
                     'label'   => 'Is Event',
                     'rules'   => 'trim|xss_clean'
                  ), 
               array(
                     'field'   => 'isEducationalMaterial',
                     'label'   => 'Is EducationalMaterial',
                     'rules'   => 'trim|xss_clean'
                  ), 
               
            );
		
		$this->form_validation->set_rules($config);
		
		if($this->input->post('submit')=='Save'  && $this->form_validation->run()){
			$saveMode='add';
			$sectionId=$this->input->post('sectionId');
			$collaborationId=$this->input->post('collaborationId');
			
			$browseId1st = $this->input->post('browseId1st');
			$com_coverImage='';
			
			if($collaborationId && is_numeric($collaborationId) &&  ($collaborationId > 0) ){
				$where['clb.userId']=$this->userId;
				$where['clb.collaborationId']=$collaborationId;
				
				$collaborationData=$this->model_collaboration->getCollaborationDetails($where);
				
				
				if($collaborationData && is_array($collaborationData) && count($collaborationData) > 0){
					$collaborationData=$collaborationData[0];
					$saveMode='edit';
					$com_coverImage=$collaborationData->coverImage;
				}else{
					redirect('collaboration/');
				}
			}else{
				$saveMode='add';
				$collaborationId=0; 
			}
			
			
			$startDate=set_value('startDate')==''?currntDateTime('Y-m-d h:i:s'):set_value('startDate');
			$startDate=date('Y-m-d',strtotime($startDate));
			
			$endDate=set_value('endDate')==''?currntDateTime('Y-m-d h:i:s'):set_value('endDate');
			$endDate=date('Y-m-d',strtotime($endDate));
			
			$isEvent=set_value('isEvent')=='t'?'t':'f';
			$isEducationalMaterial=set_value('isEducationalMaterial')=='t'?'t':'f';
			
			$datacollaboration = array(
				'userId' => $this->userId,
				'title' => pg_escape_string(set_value('title')),
				'tagwords' => pg_escape_string(set_value('tagwords')),
				'shortDescription' => pg_escape_string(set_value('shortDescription')),
				'startDate' => $startDate,
				'endDate' => $endDate,
				'industryId' => set_value('industryId'),
				'langId1' => set_value('langId1'),
				'langId2' => set_value('langId2'),
				'countryId' => set_value('countryId'),
				'isEvent' => $isEvent,
				'isEducationalMaterial' => $isEducationalMaterial
			);
			
			
			if($saveMode=='add'){
				$userContainerId=$this->lib_package->getUserContainerId($sectionId);
				if($userContainerId && is_numeric($userContainerId) &&  ($userContainerId > 0) ){
					$datacollaboration['userContainerId']=$userContainerId;
				}else{
					redirect('collaboration/');
				}
				
				$collaborationId=$this->model_common->addDataIntoTabel('Collaboration', $datacollaboration);
				$entityId=getMasterTableRecord('Collaboration');
				$this->lib_package->updateUserContainer($userContainerId,$entityId,$collaborationId,$sectionId,$sectionId);
				$msg=$this->lang->line('addedcollaboration');
			}
			
			$coverImage=$this->input->post('fileName'.$browseId1st);
			if($coverImage && strlen($coverImage)>3){
				$uploadedFile++;
				$datacollaboration['coverImage']= $editcollaboration['coverImage']= $this->dirUpload.$collaborationId.'/'.$coverImage;
				
				if($com_coverImage && strlen($com_coverImage)>3 && is_file($com_coverImage)){
					$fileInfo=pathinfo($com_coverImage);
					$dirname=$fileInfo['dirname'];
					$basename=$fileInfo['basename'];
					
					if(is_dir($dirname) && $basename !=''){
						$fpLen=strlen($dirname);
						if($fpLen > 0 && substr($dirname,-1) != DIRECTORY_SEPARATOR){
							$dirname=$dirname.DIRECTORY_SEPARATOR;
						}
						findFileNDelete($dirname,$basename);
					}
				}
			}
			
			if($saveMode=='add' && $collaborationId > 0 && is_array($editcollaboration) && count($editcollaboration) > 0){
				$this->model_common->editDataFromTabel('Collaboration', $editcollaboration, array('collaborationId'=>$collaborationId));
			}
			
			
			if($saveMode=='edit'){
					$this->model_common->editDataFromTabel('Collaboration', $datacollaboration, array('collaborationId'=>$collaborationId));
					$msg=$this->lang->line('updatedcollaboration');
			}
			
			set_global_messages($msg, $type='success', $is_multiple=true);
			
			addDataIntoLogSummary('Collaboration',$collaborationId);
			$this->writecollaborationCacheFile($collaborationId);
			
			$returnData=array('collaborationId'=>$collaborationId,'uploadedFile'=>$uploadedFile);
			echo json_encode($returnData);
			
			
		}
		else{
			redirect('collaboration/');
		}
	}
	
	function writecollaborationCacheFile($collaborationId = 0){
		if(is_numeric($collaborationId) && ($collaborationId) > 0){
			$this->userId= $this->isLoginUser();
			
			$where['clb.userId']=$this->userId;
			$where['clb.collaborationId']=$collaborationId;
			
			$collaborationData=$this->model_collaboration->getCollaborationDetails($where);
			
			if($collaborationData && is_array($collaborationData) && count($collaborationData) > 0){
				
				/*create cache file start */
					if(!is_dir($this->dirCache)){
						@mkdir($this->dirCache, 777, true);
					}
					$cmd3 = 'chmod -R 777 '.$this->dirCache;
					exec($cmd3);
					
					$cacheFile = $this->dirCache.'collaboration_'.$collaborationId.'_'.$this->userId.'.php';
					$data=str_replace("'","&apos;",json_encode($collaborationData));	//encode data in json format
					$stringData = '<?php $ProjectData=\''.$data.'\';?>';
					
					if (!write_file($cacheFile, $stringData)){	// write cache file
						echo 'Unable to write the file'; 
					}
				/*create cache file END */
				
				/*Update Search Table Start*/
					$entityId=getMasterTableRecord('Collaboration');
					$collaborationData=$collaborationData[0];
					$sectionId=$this->config->item('collaborationSectionId');
					
					$createdDate=($collaborationData->createdDate!='')?$collaborationData->createdDate:currntDateTime();
				
					$searchDataInsert=array(
						"entityid"=>$entityId,
						"elementid"=>$collaborationId,
						"projectid"=>$collaborationId,
						"section"=>'collaboration',
						"sectionid"=>$sectionId,
						"ispublished"=>$collaborationData->isPublished=='t'?'t':'f',
						"cachefile"=>$cacheFile,
						"item.title"=>pg_escape_string($collaborationData->title), 
						"item.tagwords"=>pg_escape_string($collaborationData->tagwords), 
						"item.online_desctiption"=>pg_escape_string($collaborationData->shortDescription),
						"item.userid"=>$this->userId, 
						"item.creative_name"=>LoginUserDetails('userFullName'), 
						"item.creative_area"=>LoginUserDetails('userArea'), 
						"item.languageid"=>$collaborationData->langId1>0?$collaborationData->langId1:0,  
						"item.language"=>pg_escape_string($collaborationData->Language_local),
						"item.countryid"=>$collaborationData->countryId>0?$collaborationData->countryId:0, 
						"item.country"=>pg_escape_string($collaborationData->countryName), 
						"item.sell_option"=>'paid',
						"item.industryid"=>$collaborationData->industryId>0?$collaborationData->industryId:0, 
						"item.industry"=>pg_escape_string($collaborationData->IndustryName), 
						"item.creation_date"=>$createdDate
					);
					$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
				/*Update Search Table  END*/
				
			}
		}
	}
	
	public function prMaterial($collaborationId=0) {
		$this->userId= $this->isLoginUser();
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$sectionId=$this->config->item('collaborationSectionId');
		
		if(!$collaborationId > 0){
			redirect('collaboration/index');
		}
		
		$containerWhere=array('collaborationId'=>$collaborationId);
		$containerDetails = $this->model_common->getContainerDetails('Collaboration',$containerWhere, 'Collaboration.title as collab_title, Collaboration.userId');
		if($containerDetails){
			
			if($this->userId == $containerDetails[0]['userId']){
					$userId=$this->userId;
			}else{
					$md=$this->model_common->getDataFromTabel('CollaborationMembers', 'memberId',  array('collaborationId'=>$collaborationId,'userId'=>$this->userId, 'status'=>1), '', '', '', 1);
					if($md && isset($md[0]->memberId) && ($md[0]->memberId > 0)){
						$userId=$containerDetails[0]['userId'];
					}
			}
		
			$this->data['currentMathod']='prMaterial';
			$this->data['collaborationId']=$collaborationId;
			$this->data['userId']=$this->userId;
			$this->data['ownerId']=$userId;
			
			
			$header=($this->router->fetch_method()=='settings')?'manage_header':'backendTab';
			$this->data['header']=$this->load->view($header,$this->data, true);
			
			$this->data['additionalInfoSection']=array('addInfoNewsPanel','addInfoReviewsPanel','addInfoInterviewsPanel'); 
			$natureId = 1;
			$this->data['recordId'] = $collaborationId;
			$this->data['eventNatureId'] = 1;
			$this->data['tableId'] = getMasterTableRecord('Collaboration');
			
			$this->data['label']=$this->lang->language; 
			

			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/collaboration'),
							'indexlink'=>base_url(lang().'/collaboration/'),
							'section'=>'collaboration'
							);
			$leftView=$this->config->item('collaborationHelpPage');
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','additionalInfo/additional_info',$this->data);
			//$this->template->load('backend_template','description',$this->data);
		}else{
			set_global_messages('error', $this->lang->line('pageNotExist'));
			redirect('collaboration');
		}
	}
	
	
	
	public function uploadMedia($collaborationId=0) {
		
		$this->userId= $this->isLoginUser();
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$sectionId=$this->config->item('collaborationSectionId');
		
		if($collaborationId==0){
			redirect('collaboration');			
		}else{
			$containerWhere=array('collaborationId'=>$collaborationId);
			$containerDetails = $this->model_common->getContainerDetails('Collaboration',$containerWhere, 'Collaboration.title as collab_title, Collaboration.userId');
			if($containerDetails){
				if($this->userId == $containerDetails[0]['userId']){
						$userId=$this->userId;
				}else{
						$md=$this->model_common->getDataFromTabel('CollaborationMembers', 'memberId',  array('collaborationId'=>$collaborationId,'userId'=>$this->userId, 'status'=>1), '', '', '', 1);
						if($md && isset($md[0]->memberId) && ($md[0]->memberId > 0)){
							$userId=$containerDetails[0]['userId'];
						}
				}
				$containerSize = $containerDetails[0]['containerSize'];
				
				$where['clb.userId']=$userId;
				$where['clb.collaborationId']=$collaborationId;
				$this->data['mediaData']=$this->model_collaboration->getCollaborationMedia($where);
				
				$dirname=$this->dirUpload.$collaborationId;
				$dirSize=getFolderSize($dirname);
				$fileMaxSize =($containerSize - $dirSize);
				if(!$fileMaxSize > 0){
					$fileMaxSize =0;
				}
				
				$this->data['sectionId']=$sectionId;
				$this->data['collaborationId']=$collaborationId;
				$this->data['elementId'] = $collaborationId;
				$this->data['entityId'] = getMasterTableRecord('Collaboration');
				$this->data['dirMedia']=$this->dirUpload;
				$this->data['dirUpload']=$this->dirUpload.$collaborationId.'/';
				$this->data['fileMaxSize']=$fileMaxSize;
				$this->data['heading']='Upload Media';
				$this->data['currentMathod']='uploadMedia';
				$this->data['userId']=$this->userId;
				$this->data['ownerId']=$userId;
				$this->data['welcomelink']=base_url(lang().'/dashboard/collaboration/');
				
				$header=($this->router->fetch_method()=='settings')?'manage_header':'backendTab';
				$this->data['header']=$this->load->view($header,$this->data, true);
				
				$this->data['mediaForm']=$this->load->view('media_form', $this->data,true);
				$this->data['mediaList']=$this->load->view('media_list', $this->data,true);
				
				$leftView=$this->config->item('collaborationHelpPage');
				$this->data['leftContent']=$this->load->view($leftView,'',true);
				$this->template->load('backend_template','upload_media',$this->data);
				
			}else{
				set_global_messages('error', $this->lang->line('pageNotExist'));
				redirect('collaboration');
			}
		}
		
		
	}
	
	public function mediaSave() {
		$this->userId=$userId=$this->isLoginUser();
		
		$collaborationId = $this->input->post('collaborationId');
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		
		if($collaborationId > 0){
			
			$title = $this->input->post('title');
			$browseId = $this->input->post('browseId');
			$description = $this->input->post('description');
			$mediaId = $this->input->post('mediaId');
			$mediaId = is_numeric($mediaId)?$mediaId:0;
			$fileId = $this->input->post('fileId');
			$fileId = is_numeric($fileId)?$fileId:0;
			
			$isFile=true;
			$media_fileName=$this->input->post('fileName'.$browseId);
			$isExternal=($this->input->post('isExternal'.$browseId)=='t')?'t':'f';
			$embbededURL=$this->input->post('embbededURL'.$browseId);
			
			$fileType=$this->input->post('fileType'.$browseId);
			
			$mediaFileData=array();
			
			if($media_fileName && strlen($media_fileName)>3){
				
				$fileType=getFileType($media_fileName);
				$mediaFileData=array(
										'filePath'=>$this->dirUpload.$collaborationId.'/',
										'fileName'=>$media_fileName,
										'fileType'=>$fileType,
										'tdsUid'=>$userId,
										'isExternal'=>'f',
										'fileSize'=>$this->input->post('fileSize'.$browseId),
										'rawFileName'=>$this->input->post('fileInput'.$browseId),
										'jobStsatus'=>'UPLOADING'
									);
				
			}elseif($isExternal == 't' && $embbededURL && strlen($embbededURL)>3){
				
				
				$embbededURL=getUrl($embbededURL);
				$mediaFileData=array(
										'filePath'=>$embbededURL,
										'tdsUid'=>$userId,
										'fileType'=>$fileType,
										'isExternal'=>'t',
									);
				
			}else{
				$mediaFileData=array(
					'tdsUid'=>$userId,
					'fileType'=>$fileType,
					'isExternal'=>'f'
				);
				
			}
			
			if($isFile){
				
				$fileLength = $this->input->post('fileLength');
				switch($fileType)
				{
					case 1:
						$mediaFileData['fileHeight'] = ($this->input->post('fileHeight')=="")?Null:$this->input->post('fileHeight');
						$mediaFileData['fileWidth'] = ($this->input->post('fileWidth')=="")?Null:$this->input->post('fileWidth');
						$mediaFileData['fileUnit'] = ($this->input->post('fileUnit')=="")?Null:$this->input->post('fileUnit');
					break;
					
					case 2:
					case 3:
						$mediaFileData['fileLength'] = $fileLength;
						$mediaFileData['fileLength'] = $fileLength;
					break;
					
					case 4:
						$mediaFileData['fileLength'] = $this->input->post('wordCount');
					break;
				}
				
				$fileId=$this->manageMediaFile($fileId,$mediaFileData);
			}
			
			//------------piece add section------------//
			if($mediaId > 0) {
				$updateData = array('title'=>$title,'description'=>$description);
				$this->model_common->editDataFromTabel('CollaborationMedia', $updateData, array('mediaId'=>$mediaId));	
				$msg=$this->lang->line('updatedCollaborationMedia');
			}
			else {
				
				$insertData = array('collaborationId'=>$collaborationId,'title'=>$title,'description'=>$description,'fileId'=>$fileId);
				$mediaId = $this->model_common->addDataIntoTabel('CollaborationMedia', $insertData);
				$msg=$this->lang->line('addedCollaborationMedia');
			}
			set_global_messages($msg, $type='success', $is_multiple=true);
			$returnData=array('msg'=>$msg,'mediaId'=>$mediaId,'fileId'=>$fileId);
			echo json_encode($returnData);
		}
	}
	
	public function manageMediaFile($fileId=0,$mediaFileData=array(),$File=false){
		if(is_numeric($fileId) && $fileId > 0){
			if(isset($mediaFileData['fileName']) && (strlen($mediaFileData['fileName']) > 3) &&  isset($mediaFileData['filePath']) && (strlen($mediaFileData['filePath']) > 3) ){
				$fileData = $this->model_common->getDataFromTabel('MediaFile', 'fileName,filePath', array('fileId'=>$fileId));
				if(isset($fileData[0]->fileName)){
					findFileNDelete($fileData[0]->filePath,$fileData[0]->fileName);
				}
			}
			$this->model_common->editDataFromTabel('MediaFile', $mediaFileData, array('fileId'=>$fileId));
			
		}else{
			if(isset($mediaFileData['filePath']) && (strlen($mediaFileData['filePath']) > 3) ){
				$fileId=$this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);
			}
		}
		return $fileId;
	}

	
	public function members($collaborationId=0){
		$this->userId= $this->isLoginUser();
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$sectionId=$this->config->item('collaborationSectionId');
		$this->data['collaborationId']=$collaborationId;
		if($collaborationId==0){
			redirect('collaboration');			
		}else{
			$containerWhere=array('collaborationId'=>$collaborationId);
			$containerDetails = $this->model_common->getContainerDetails('Collaboration',$containerWhere, 'Collaboration.title as collab_title, Collaboration.userId');
			if($containerDetails){
				
				if($this->userId == $containerDetails[0]['userId']){
						$userId=$this->userId;
				}else{
						$md=$this->model_common->getDataFromTabel('CollaborationMembers', 'memberId',  array('collaborationId'=>$collaborationId,'userId'=>$this->userId, 'status'=>1), '', '', '', 1);
						if($md && isset($md[0]->memberId) && ($md[0]->memberId > 0)){
							$userId=$containerDetails[0]['userId'];
						}
				}
				
				$where['clb.userId']=$userId;
				$where['clb.collaborationId']=$collaborationId;
				$this->data['membersData']=$this->model_collaboration->getCollaborationMembers($where);
				$this->data['access']=$this->model_common->getDataFromTabel('CollaborationAccess', '*',  array('status'=>'t'),'','accessId','ASC');
			
				$dirname=$this->dirUpload.$collaborationId;
				
				$this->data['sectionId']=$sectionId;
				$this->data['collaborationId'] = $collaborationId;
				$this->data['elementId'] = $collaborationId;
				$this->data['entityId'] = getMasterTableRecord('Collaboration');
				$this->data['dirMedia']=$this->dirUpload;
				$this->data['dirUpload']=$this->dirUpload.$collaborationId.'/';
				$this->data['heading']='Members';
				$this->data['currentMathod']='members';
				$this->data['userId']=$this->userId;
				$this->data['ownerId']=$userId;
				$this->data['welcomelink']=base_url(lang().'/dashboard/collaboration/');
				
				$header=($this->router->fetch_method()=='settings')?'manage_header':'backendTab';
				$this->data['header']=$this->load->view($header,$this->data, true);
				
				$leftView=$this->config->item('collaborationHelpPage');
				$this->data['leftContent']=$this->load->view($leftView,'',true);
				$this->template->load('backend_template','members',$this->data);
			}else{
				set_global_messages('error', $this->lang->line('pageNotExist'));
				redirect('collaboration');
			}
		}
		
	}

	
	/*
	 * Function used to manage users listing
	 */
	public function getToadUsers($like='') {
		$like =  utf8_decode(urldecode($like));
		$isAjaxLike = $this->input->get('val1'); //get ajax like value
		$isAjaxLike =  utf8_decode(urldecode($isAjaxLike));
		if(!empty($isAjaxLike) && $isAjaxLike!='Keyword Search...') {
			$like = $isAjaxLike;
			
		}
		//Set pagination values
		$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdminUser');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdminUser');
		//$where = array('isBlocked'=>'f','isExpired'=>'f','isArchive'=>'f');
		//$userData = getDataFromTabel('UserShowcase','*',  $where, '','', '', '' ); 
		$userData = $this->model_collaboration->getUsersListing($like);
		$countTotal = count($userData);
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();	
		$this->data['countTotal'] = $countTotal;
		$this->data['like'] = $like;
		//Get users records
		$userRes = $this->model_collaboration->getUsersListing($like,$pages->limit,$pages->offst);
		
		//assign users data in userList
		if(isset($userRes) && !empty($userRes)){
			$this->data['usersList'] = $userRes;
		}else {
			$this->data['usersList'] = '';
		}
		
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('collaboration/user_listing_view', $this->data); //load view on pagination
		}else{
			$this->load->view('user_list',$this->data);	//load user listing view
		}		   
	}
	
	/*
	 * function used to insert collaboration member
	 */
	public function saveColMember($member_id=0,$collaboration_id=0) {
		$data = array(												
				'collaborationId' => $collaboration_id,						
				'userId'	 	=> $member_id,									
			);
		//insert member record
		$insertedMemberId = $this->model_collaboration->insertMember($data);
		if(isset($insertedId) && !empty($insertedId)) {
			$return = true;
			//$msg =array('msg'=>$this->lang->line('addedCollaborationMember'),''); //set update msg
		} else {
			$return = true;
			//$msg =array('msg'=>$this->lang->line('ErrorCollaborationMember'),''); //set update msg
		}
		echo $return;
		//echo json_encode($msg);
	}
	
	/*
	 * function used to remove collaboration member
	 */
	public function removeCollaborationMember($member_id=0) {
		//remove member record
		$this->model_collaboration->removeColMember($member_id);
		$msg =array('msg'=>$this->lang->line('removeCollaborationMember'),''); //set remove msg
		echo json_encode($msg);
	}
	
	/*
	 * function used to check member exist in collaboration
	 */
	public function checkColMember($member_id=0,$collaboration_id=0) {
		//Get colllaboration record
		$where = array('userId'=>$member_id,'collaborationId'=>$collaboration_id);
		$colMemberRes   = getDataFromTabel('CollaborationMembers','*', $where, '','', '', 1 );
		if(is_array($colMemberRes) && count($colMemberRes)>0) {
			$return = false;
		} else {
			$return = true;
		}
		echo $return;
	}
	
	public function milestones($collaborationId=0){
		
		$this->userId= $this->isLoginUser();
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$sectionId=$this->config->item('collaborationSectionId');
		
		if($collaborationId==0){
			redirect('collaboration');			
		}else{
			
			$containerWhere=array('collaborationId'=>$collaborationId);
			$containerDetails = $this->model_common->getContainerDetails('Collaboration',$containerWhere, 'Collaboration.title as collab_title, Collaboration.userId');
			if($containerDetails){
				if($this->userId == $containerDetails[0]['userId']){
						$userId=$this->userId;
				}else{
						$md=$this->model_common->getDataFromTabel('CollaborationMembers', 'memberId',  array('collaborationId'=>$collaborationId,'userId'=>$this->userId, 'status'=>1), '', '', '', 1);
						if($md && isset($md[0]->memberId) && ($md[0]->memberId > 0)){
							$userId=$containerDetails[0]['userId'];
						}
				}
				
				$containerSize = $containerDetails[0]['containerSize'];
				$where['clb.userId'] = $userId;
				$where['clb.collaborationId']=$collaborationId;
				$this->data['milestoneData']=$this->model_collaboration->getCollaborationMilestones($where);
			
				$dirname=$this->dirUpload.$collaborationId;
				$dirSize=getFolderSize($dirname);
				$fileMaxSize =($containerSize - $dirSize);
				if(!$fileMaxSize > 0){
					$fileMaxSize =0;
				}
				
				if($userId==$this->userId){
					$this->data['userCollabAccess']=array('all');
				}else{
					$this->getMembersAccess($collaborationId);
				}
				
				$this->data['sectionId']=$sectionId;
				$this->data['collaborationId']=$collaborationId;
				$this->data['elementId'] = $collaborationId;
				$this->data['entityId'] = getMasterTableRecord('Collaboration');
				$this->data['dirMedia']=$this->dirUpload;
				$this->data['dirUpload']=$this->dirUpload.$collaborationId.'/';
				$this->data['fileMaxSize']=$fileMaxSize;
				$this->data['heading']=$containerDetails[0]['collab_title'];
				$this->data['currentMathod']='milestones';
				$this->data['userId']=$this->userId;
				$this->data['ownerId']=$userId;
				$this->data['welcomelink']=base_url(lang().'/dashboard/collaboration/');
				$this->data['header']=$this->load->view('manage_header',$this->data, true);
				
				$this->data['milestoneForm']=$this->load->view('milestone_form', $this->data,true);
				$this->data['milestoneList']=$this->load->view('milestone_list', $this->data,true);
				
				$leftView=$this->config->item('collaborationHelpPage');
				$this->data['leftContent']=$this->load->view($leftView,'',true);
				$this->template->load('backend_template','milestone',$this->data);
				
			}else{
				set_global_messages('error', $this->lang->line('pageNotExist'));
				redirect('collaboration');
			}
		}
	}
	
	public function saveMilestones(){
		$this->userId=$userId=$this->isLoginUser();
		
		$collaborationId = $this->input->post('collaborationId');
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		
		if($collaborationId > 0){
			
			$title = $this->input->post('title');
			$description = $this->input->post('description');
			$milestoneId = $this->input->post('milestoneId');
			$milestoneId = is_numeric($milestoneId)?$milestoneId:0;
			
			$startDate=$this->input->post('startDate')==''?currntDateTime('Y-m-d h:i:s'):$this->input->post('startDate');
			$startDate=date('Y-m-d',strtotime($startDate));
			
			$endDate=$this->input->post('endDate')==''?currntDateTime('Y-m-d h:i:s'):$this->input->post('endDate');
			$endDate=date('Y-m-d',strtotime($endDate));
			
			//------------piece add section------------//
			if($milestoneId > 0) {
				$updateData = array('title'=>$title,'description'=>$description,'startDate'=>$startDate,'endDate'=>$endDate);
				$this->model_common->editDataFromTabel('CollaborationMilestoones', $updateData, array('milestoneId'=>$milestoneId));	
				$msg=$this->lang->line('updatedCollaborationMilestone');
			}
			else {
				$insertData = array('collaborationId'=>$collaborationId,'title'=>$title,'description'=>$description,'startDate'=>$startDate,'endDate'=>$endDate);
				$milestoneId = $this->model_common->addDataIntoTabel('CollaborationMilestoones', $insertData);
				$msg=$this->lang->line('addedCollaborationMilestone');
			}
			set_global_messages($msg, $type='success', $is_multiple=true);
			$returnData=array('msg'=>$msg,'milestoneId'=>$milestoneId);
			echo json_encode($returnData);
		}
	}
	
	public function todos($collaborationId=0){
	
		$this->userId= $this->isLoginUser();
		
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$sectionId=$this->config->item('collaborationSectionId');
		
		if($collaborationId==0){
			redirect('collaboration');			
		}else{
			$containerWhere=array('collaborationId'=>$collaborationId);
			$containerDetails = $this->model_common->getContainerDetails('Collaboration',$containerWhere, 'Collaboration.title as collab_title, Collaboration.userId');
			if($containerDetails){
				if($this->userId == $containerDetails[0]['userId']){
						$userId=$this->userId;
				}else{
						$md=$this->model_common->getDataFromTabel('CollaborationMembers', 'memberId',  array('collaborationId'=>$collaborationId,'userId'=>$this->userId, 'status'=>1), '', '', '', 1);
						if($md && isset($md[0]->memberId) && ($md[0]->memberId > 0)){
							$userId=$containerDetails[0]['userId'];
						}
				}
				
				if($userId==$this->userId){
					$this->data['userCollabAccess']=array('all');
				}else{
					$this->getMembersAccess($collaborationId);
				}
				
				$containerSize = $containerDetails[0]['containerSize'];
				$where['clb.userId'] = $userId;
				$where['clb.collaborationId']=$collaborationId;
				$this->data['taskData']=$this->model_collaboration->getCollaborationTodos($where);
				
				$this->data['membersData']=$this->model_collaboration->getCollaborationMembers($where);
				$this->data['milestonData']=$this->model_collaboration->getCollaborationMilestones($where,'cm.title');
				
				$this->data['assignedMilestonData']=$this->model_collaboration->getAssignedMilestonData(array('clb.userId'=>$userId, 'clb.collaborationId'=>$collaborationId, 'cm.status'=>0));
				
				
				$this->data['completedMilestonData']=$this->model_collaboration->getAssignedMilestonData(array('clb.userId'=>$userId, 'clb.collaborationId'=>$collaborationId, 'cm.status'=>3));
				
				$dirname=$this->dirUpload.$collaborationId;
				$dirSize=getFolderSize($dirname);
				$fileMaxSize =($containerSize - $dirSize);
				if(!$fileMaxSize > 0){
					$fileMaxSize =0;
				}
				
				$this->data['sectionId']=$sectionId;
				$this->data['collaborationId']=$collaborationId;
				$this->data['elementId'] = $collaborationId;
				$this->data['entityId'] = getMasterTableRecord('Collaboration');
				$this->data['dirMedia']=$this->dirUpload;
				$this->data['dirUpload']=$this->dirUpload.$collaborationId.'/';
				$this->data['fileMaxSize']=$fileMaxSize;
				$this->data['heading']=$containerDetails[0]['collab_title'];
				$this->data['currentMathod']='todos';
				$this->data['userId']=$this->userId;
				$this->data['ownerId']=$userId;
				$this->data['welcomelink']=base_url(lang().'/dashboard/collaboration/');
				$this->data['header']=$this->load->view('manage_header',$this->data, true);
				
				$this->data['taskForm']=$this->load->view('task_form', $this->data,true);
				$this->data['taskList']=$this->load->view('task_list', $this->data,true);
				
				$leftView=$this->config->item('collaborationHelpPage');
				$this->data['leftContent']=$this->load->view($leftView,'',true);
				$this->template->load('backend_template','task',$this->data);
				
			}else{
				set_global_messages('error', $this->lang->line('pageNotExist'));
				redirect('collaboration');
			}
		}
	}
	
	public function saveTodos(){
		$this->userId=$userId=$this->isLoginUser();
		
		$collaborationId = $this->input->post('collaborationId');
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		
		if($collaborationId > 0){
			
			$title = $this->input->post('title');
			$description = $this->input->post('description');
			$taskId = $this->input->post('taskId');
			$taskId = is_numeric($taskId)?$taskId:0;
			
			$milestoneId = $this->input->post('milestoneId');
			$milestoneId = is_numeric($milestoneId)?$milestoneId:0;
			
			$status = $this->input->post('status');
			$status = is_numeric($status)?$status:0;
			
			$priority = $this->input->post('priority');
			$priority = is_numeric($priority)?$priority:0;
			
			$estimatedTime = $this->input->post('estimatedTime');
			$estimatedTime = is_numeric($estimatedTime)?$estimatedTime:0;
			
			$completePercentage = $this->input->post('completePercentage');
			$completePercentage = is_numeric($completePercentage)?$completePercentage:0;
			
			$memberId = $this->input->post('memberId');
			$memberId = is_numeric($memberId)?$memberId:0;
			
			
			$startDate=$this->input->post('startDate')==''?currntDateTime('Y-m-d h:i:s'):$this->input->post('startDate');
			$startDate=date('Y-m-d',strtotime($startDate));
			
			$endDate=$this->input->post('endDate')==''?currntDateTime('Y-m-d h:i:s'):$this->input->post('endDate');
			$endDate=date('Y-m-d',strtotime($endDate));
			
			//------------piece add section------------//
			$saveData = array('title'=>$title,
							  'description'=>$description,
							  'startDate'=>$startDate,
							  'endDate'=>$endDate,
							  'milestoneId'=>$milestoneId,
							  'priority'=>$priority,
							  
							/*  'status'=>$status,
							  'estimatedTime'=>$estimatedTime,
							  'completePercentage'=>$completePercentage*/
							 );
			
			if($taskId > 0) {
				$this->model_common->editDataFromTabel('CollaborationTasks', $saveData, array('taskId'=>$taskId));	
				$msg=$this->lang->line('updatedCollaborationTask');
			}
			else {
				$saveData['collaborationId'] = $collaborationId;
				$taskId = $this->model_common->addDataIntoTabel('CollaborationTasks', $saveData);
				$msg=$this->lang->line('addedCollaborationTask');
			}

			$assignTask=array('taskId'=>$taskId,'milestoneId'=>$milestoneId,'collaborationId'=>$collaborationId,'memberId'=>$memberId);
			$taskWhere=array('taskId'=>$taskId,'collaborationId'=>$collaborationId);
			$assignId = $this->assignTask($assignTask,$taskWhere);
			
			set_global_messages($msg, $type='success', $is_multiple=true);
			$returnData=array('msg'=>$msg,'taskId'=>$taskId);
			echo json_encode($returnData);
		}
	}
	
	private function assignTask($saveData,$where){
		$assignId = 0;
		if(isset($saveData) && is_array($saveData) && count($saveData) > 0 ) {
			$assigData=$this->model_common->getDataFromTabel('CollaborationTaskAssignee', 'assignId',  $where, '', '', '', 1);
			if(isset($assigData[0]->assignId)){
				$assignId = $assigData[0]->assignId;
				$this->model_common->editDataFromTabel('CollaborationTaskAssignee', $saveData, array('assignId'=>$assignId));	
				
			}else{
				$assignId = $this->model_common->addDataIntoTabel('CollaborationTaskAssignee', $saveData);
			}
		}
		return $assignId;
	}
	
	public function mediaExchange($collaborationId=0){
		$this->userId= $this->isLoginUser();
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$sectionId=$this->config->item('collaborationSectionId');
		
		if($collaborationId==0){
			redirect('collaboration');			
		}else{
			$containerWhere=array('collaborationId'=>$collaborationId);
			$containerDetails = $this->model_common->getContainerDetails('Collaboration',$containerWhere, 'Collaboration.title as collab_title, Collaboration.userId');
			if($containerDetails){
				if($this->userId == $containerDetails[0]['userId']){
						$userId=$this->userId;
				}else{
						$md=$this->model_common->getDataFromTabel('CollaborationMembers', 'memberId',  array('collaborationId'=>$collaborationId,'userId'=>$this->userId, 'status'=>1), '', '', '', 1);
						if($md && isset($md[0]->memberId) && ($md[0]->memberId > 0)){
							$userId=$containerDetails[0]['userId'];
						}
				}
				$containerSize = $containerDetails[0]['containerSize'];
				
				//$where['cm.senderId']=$this->userId;
				$where['cm.collaborationId']=$collaborationId;
				$this->data['mediaData']=$this->model_collaboration->getMediaExchange($where);
				
				$this->data['membersData']=$this->model_collaboration->getCollaborationMembers(array('clb.userId'=>$this->userId,'clb.collaborationId'=>$collaborationId));
				
				//manage members used ids 
				if(is_array($this->data['membersData']) && count($this->data['membersData'])>0) {
					$memberIds =array();
					$memberData = $this->data['membersData'];
					foreach($memberData as $k=>$member){
						array_push($memberIds,$member->userId);
					}
					$this->data['memberIds'] = implode(',',$memberIds);
				}
				
				
				$dirname=$this->dirUpload.$collaborationId;
				$dirSize=getFolderSize($dirname);
				$fileMaxSize =($containerSize - $dirSize);
				if(!$fileMaxSize > 0){
					$fileMaxSize =0;
				}
				
				$this->data['sectionId']=$sectionId;
				$this->data['collaborationId']=$collaborationId;
				$this->data['elementId'] = $collaborationId;
				$this->data['entityId'] = getMasterTableRecord('Collaboration');
				$this->data['dirMedia']=$this->dirUpload;
				$this->data['dirUpload']=$this->dirUpload.$collaborationId.'/';
				$this->data['fileMaxSize']=$fileMaxSize;
				$this->data['heading']=$containerDetails[0]['collab_title'];
				$this->data['currentMathod']='mediaExchange';
				$this->data['userId']=$this->userId;
				$this->data['ownerId']=$userId;
				$this->data['welcomelink']=base_url(lang().'/dashboard/collaboration/');
				$this->data['header']=$this->load->view('manage_header',$this->data, true);
				
				$this->data['mediaForm']=$this->load->view('mediaExchange_form', $this->data,true);
				$this->data['mediaList']=$this->load->view('mediaExchange_list', $this->data,true);
				
				$leftView=$this->config->item('collaborationHelpPage');
				$this->data['leftContent']=$this->load->view($leftView,'',true);
				$this->template->load('backend_template','media_exchange',$this->data);
				
			}else{
				set_global_messages('error', $this->lang->line('pageNotExist'));
				redirect('collaboration');
			}
		}
	}
	
	public function savemediaExchange($collaborationId=0){
		$this->userId=$userId=$this->isLoginUser();
		
		$collaborationId = $this->input->post('collaborationId');
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		
		if($collaborationId > 0){
				
				$title = $this->input->post('title');
				$browseId = $this->input->post('browseId');
				$description = $this->input->post('description');
				$exchangeId = $this->input->post('exchangeId');
				$exchangeId = is_numeric($exchangeId)?$exchangeId:0;	
				
				$fileId = $this->input->post('fileId');
				$fileId = is_numeric($fileId)?$fileId:0;
				$isAllMember = $this->input->post('isAllMember');
				if($isAllMember==1) {
					$memberIds = $this->input->post('memberIds');
					//$recipients = explode(',',$memberIds);
					$userIdArray = explode(',',$memberIds);	
					$memberIdArray = array();
					for($i=0;$i<count($userIdArray);$i++) {
						$userResult = getDataFromTabel('CollaborationMembers','memberId',  array('userId'=>$userIdArray[$i]), '','', '', 1 );
						array_push($memberIdArray,$userResult[0]->memberId);
					}	
				} else {
					$memberIdArray = $this->input->post('membersId');
				}
				
				$membersId='{';
				if(isset($memberIdArray) && is_array($memberIdArray) && count($memberIdArray) > 0){
					$counts = count($memberIdArray);
					foreach($memberIdArray as $k=>$memberId){
						$membersId.=$memberId;
						if($k < ($counts-1)){
							$membersId.=',';
						}
					}
				}else{
					$membersId.='0';
				}
				$membersId.='}';
				
				
				$isFile=true;
				$media_fileName=$this->input->post('fileName'.$browseId);
				$isExternal=($this->input->post('isExternal'.$browseId)=='t')?'t':'f';
				$embbededURL=$this->input->post('embbededURL'.$browseId);
				
				$fileType=$this->input->post('fileType'.$browseId);
				
				$mediaFileData=array();
				
				if($media_fileName && strlen($media_fileName)>3){
					
					$fileType=getFileType($media_fileName);
					$mediaFileData=array(
											'filePath'=>$this->dirUpload.$collaborationId.'/',
											'fileName'=>$media_fileName,
											'fileType'=>$fileType,
											'tdsUid'=>$userId,
											'isExternal'=>'f',
											'fileSize'=>$this->input->post('fileSize'.$browseId),
											'rawFileName'=>$this->input->post('fileInput'.$browseId),
											'jobStsatus'=>'UPLOADING'
										);
					
				}elseif($isExternal == 't' && $embbededURL && strlen($embbededURL)>3){
					
					
					$embbededURL=getUrl($embbededURL);
					$mediaFileData=array(
											'filePath'=>$embbededURL,
											'tdsUid'=>$userId,
											'fileType'=>$fileType,
											'isExternal'=>'t',
										);
					
				}else{
					$mediaFileData=array(
						'tdsUid'=>$userId,
						'fileType'=>$fileType,
						'isExternal'=>'f'
					);
					
				}
				
				if($isFile){
					
					$fileLength = $this->input->post('fileLength');
					switch($fileType)
					{
						case 1:
							$mediaFileData['fileHeight'] = ($this->input->post('fileHeight')=="")?Null:$this->input->post('fileHeight');
							$mediaFileData['fileWidth'] = ($this->input->post('fileWidth')=="")?Null:$this->input->post('fileWidth');
							$mediaFileData['fileUnit'] = ($this->input->post('fileUnit')=="")?Null:$this->input->post('fileUnit');
						break;
						
						case 2:
						case 3:
							$mediaFileData['fileLength'] = $fileLength;
							$mediaFileData['fileLength'] = $fileLength;
						break;
						
						case 4:
							$mediaFileData['fileLength'] = $this->input->post('wordCount');
						break;
					}
					
					$fileId=$this->manageMediaFile($fileId,$mediaFileData);
				}
				
				//Send tmail to members start here
				if($this->input->post('membersId'))
				{
					$memberArray = array();
					foreach($memberIdArray as $k=>$memberId){
						$memberResult = getDataFromTabel('CollaborationMembers','userId',  array('memberId'=>$memberId), '','', '', 1 );
						array_push($memberArray,$memberResult[0]->userId);
					}
					$recipients = $memberArray;	//put members user Id to member array
					$type = 12; //set media exchanges default type
					$msg = $this->tmail_messaging->send_new_message($this->userId,$recipients, $title,$description,'',$type,$fileId);
				}	
				//Send tmail to members end here	
				
				
				//------------piece add section------------//
				$saveData = array('title'=>$title,'description'=>$description,'membersId'=>$membersId);
				if($exchangeId > 0) {
					$this->model_common->editDataFromTabel('CollaborationMediaExchange', $saveData, array('exchangeId'=>$exchangeId));	
					$msg=$this->lang->line('updatedCollaborationMedia');
				}
				else {
					$saveData['collaborationId']=$collaborationId;
					$saveData['fileId']=$fileId;
					$saveData['senderId']=$userId;
					$exchangeId = $this->model_common->addDataIntoTabel('CollaborationMediaExchange', $saveData);
					$msg=$this->lang->line('addedCollaborationMedia');
				}
				
				
				set_global_messages($msg, $type='success', $is_multiple=true);
				$returnData=array('msg'=>$msg,'exchangeId'=>$exchangeId,'fileId'=>$fileId);
				echo json_encode($returnData); 
		}
	}

	public function changeTaskStatus(){
		$taskId = $this->input->post('taskId');
		$taskId = is_numeric($taskId)?$taskId:0;
		
		$action = $this->input->post('action');
		$action = is_numeric($action)?$action:0;
		
		if($action ==0){
			$saveData['status']=0;
		}else{
			$saveData['status']=3;
		}
		if($taskId > 0){
			$this->model_common->editDataFromTabel('CollaborationTasks', $saveData, array('taskId'=>$taskId));
			$returnData=array('statuschanged'=>1);
		}else{
			$returnData=array('statuschanged'=>0);
		}
		echo json_encode($returnData);
	}
	
	public function taskDetails($taskId=0, $collaborationId=0){
		$this->userId= $this->isLoginUser();
		
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$taskId = is_numeric($taskId)?$taskId:0;
		
		$sectionId=$this->config->item('collaborationSectionId');
		
		if($collaborationId==0 || $taskId==0){
			redirect('collaboration');			
		}else{
			$containerWhere=array('collaborationId'=>$collaborationId);
			$containerDetails = $this->model_common->getContainerDetails('Collaboration',$containerWhere, 'Collaboration.title as collab_title, Collaboration.userId');
			if($containerDetails){
				if($this->userId == $containerDetails[0]['userId']){
						$userId=$this->userId;
				}else{
						$md=$this->model_common->getDataFromTabel('CollaborationMembers', 'memberId',  array('collaborationId'=>$collaborationId,'userId'=>$this->userId, 'status'=>1), '', '', '', 1);
						if($md && isset($md[0]->memberId) && ($md[0]->memberId > 0)){
							$userId=$containerDetails[0]['userId'];
						}
				}
				$containerSize = $containerDetails[0]['containerSize'];
				
				$where['clb.userId'] = $userId;
				$where['clb.collaborationId']=$collaborationId;
				$where['ct.taskId']=$taskId;
				
				$taskData=$this->model_collaboration->getCollaborationTodos($where);
				
				
				if(!$taskData){
					set_global_messages('error', $this->lang->line('pageNotExist'));
					redirect('collaboration');
				}
				$this->data['taskData']= $taskData[0];
				$this->data['commentsData']=$this->model_collaboration->getTodosComments(array('tc.elementId'=>$taskId,'tc.entityId'=>getMasterTableRecord('CollaborationTasks')));
				
				$dirname=$this->dirUpload.$collaborationId;
				$dirSize=getFolderSize($dirname);
				$fileMaxSize =($containerSize - $dirSize);
				if(!$fileMaxSize > 0){
					$fileMaxSize =0;
				}
				
				$this->data['sectionId']=$sectionId;
				$this->data['collaborationId']=$collaborationId;
				$this->data['taskId']=$taskId;
				$this->data['elementId'] = $taskId;
				$this->data['entityId'] = getMasterTableRecord('CollaborationTasks');
				$this->data['dirMedia']=$this->dirUpload;
				$this->data['dirUpload']=$this->dirUpload.$collaborationId.'/';
				$this->data['fileMaxSize']=$fileMaxSize;
				$this->data['heading']=$containerDetails[0]['collab_title'];
				$this->data['currentMathod']='taskDetails';
				$this->data['userId']=$this->userId;
				$this->data['ownerId']=$userId;
				$this->data['welcomelink']=base_url(lang().'/dashboard/collaboration/');
				$this->data['header']=$this->load->view('manage_header',$this->data, true);
				
				
				$this->data['commentList']=$this->load->view('comment_list', $this->data,true);
				$this->data['commentForm']=$this->load->view('comment_form', $this->data,true);
				
				$leftView=$this->config->item('collaborationHelpPage');
				$this->data['leftContent']=$this->load->view($leftView,'',true);
				$this->template->load('backend_template','task_details',$this->data);
				
			}else{
				set_global_messages('error', $this->lang->line('pageNotExist'));
				redirect('collaboration');
			}
		}
	}
	
	
	/*
	 * This function used to reply tmail of communication
	 */ 
	public function saveComments() {
		
		$this->userId=$userId=$this->isLoginUser();
		
		$collaborationId = $this->input->post('collaborationId');
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		
		$elementId = $this->input->post('elementId');
		$elementId = is_numeric($elementId)?$elementId:0;
		
		$entityId = $this->input->post('entityId');
		$entityId = is_numeric($elementId)?$entityId:0;
		
		if($collaborationId > 0 && $elementId > 0 && $entityId > 0){
				
				$title = $this->input->post('title');
				$browseId = $this->input->post('browseId');
				$description = $this->input->post('description');
				$media_fileName=$this->input->post('fileName'.$browseId);
				$fileId = 0;
				if($media_fileName && strlen($media_fileName)>3){
					$fileType=$this->input->post('fileType'.$browseId);
					$fileType=getFileType($media_fileName);
					$mediaFileData=array(
											'filePath'=>$this->dirUpload.$collaborationId.'/',
											'fileName'=>$media_fileName,
											'fileType'=>$fileType,
											'tdsUid'=>$userId,
											'isExternal'=>'f',
											'rawFileName'=>$this->input->post('fileInput'.$browseId),
											'jobStsatus'=>'UPLOADING'
										);
					$fileId=$this->manageMediaFile(0,$mediaFileData);
					
				}
				
				//------------piece add section------------//
				$saveData = array('elementId'=>$elementId,'entityId'=>$entityId,'title'=>$title,'description'=>$description,'userId'=>$userId,'fileId'=>$fileId);
				
				$commentId = $this->model_common->addDataIntoTabel('CollaborationComments', $saveData);
				$msg=$this->lang->line('postComment');
				
				set_global_messages($msg, $type='success', $is_multiple=true);
				$returnData=array('msg'=>$msg,'commentId'=>$commentId,'fileId'=>$fileId);
				echo json_encode($returnData); 
		}
	}
	
	public function changeMilestoneStatus(){
		$milestoneId = $this->input->post('milestoneId');
		$milestoneId = is_numeric($milestoneId)?$milestoneId:0;
		
		$action = $this->input->post('action');
		$action = is_numeric($action)?$action:0;
		
		if($action ==0){
			$saveData['status']=0;
		}else{
			$saveData['status']=3;
		}
		if($milestoneId > 0){
			$this->model_common->editDataFromTabel('TDS_CollaborationMilestoones', $saveData, array('milestoneId'=>$milestoneId));
			$returnData=array('statuschanged'=>1);
		}else{
			$returnData=array('statuschanged'=>0);
		}
		echo json_encode($returnData);
	}
	
	public function milestoneDetails(){
		$data = $this->input->post('val1');
		$this->load->view('milestone_details',$data);
		
	}
	
	public function mediaExchangeDetails(){
		$data = $this->input->post('val1');
		$this->load->view('mediaExhange_details',$data);
		
	}
	
	/*
	 * This function used to manage communication
	 */
	 /* commented by sushil: date: 07-02-2014
	public function communications_backup($collaborationId=0,$isCompose=0,$limit='',$perPage='') {
		
		$this->userId= $this->isLoginUser();
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$sectionId=$this->config->item('collaborationSectionId');
		
		if($collaborationId==0){
			redirect('collaboration');			
		}else{
			$containerWhere=array('collaborationId'=>$collaborationId);
			$containerDetails = $this->model_common->getContainerDetails('Collaboration',$containerWhere, 'Collaboration.title as collab_title, Collaboration.userId');
			if($containerDetails){
				if($this->userId == $containerDetails[0]['userId']){
						$userId=$this->userId;
				}else{
						$md=$this->model_common->getDataFromTabel('CollaborationMembers', 'memberId',  array('collaborationId'=>$collaborationId,'userId'=>$this->userId, 'status'=>1), '', '', '', 1);
						if($md && isset($md[0]->memberId) && ($md[0]->memberId > 0)){
							$userId=$containerDetails[0]['userId'];
						}
				}
				$containerSize = $containerDetails[0]['containerSize'];
				
				$where['cm.senderId']=$userId;
				$where['cm.collaborationId']=$collaborationId;
				$this->data['mediaData']=$this->model_collaboration->getMediaExchange($where);
				
				$this->data['membersData']=$this->model_collaboration->getCollaborationMembers(array('clb.userId'=>$userId,'clb.collaborationId'=>$collaborationId));
				
				//Set pagination values
				$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdminUser');
				$perPageI=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordInbox');		
				$perPageS=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordSend');	
				
				//  manage Inbox data
				//Get tmail count
				$tmailData = $this->model_collaboration->getCommunicationTmail($userId);
				$countTotal = count($tmailData);
				$pages = new Pagination_ajax;
				$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
				$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPageI;
				$pages->paginate();
				$this->data['items_total']      = $pages->items_total;
				$this->data['items_per_page']   = $pages->items_per_page;
				$this->data['pagination_links'] = $pages->display_pages();	
				$this->data['countTotal']       = $countTotal;
				//Get users communication tmail data
				$this->data['comTmailData'] = $this->model_collaboration->getCommunicationTmail($userId,$pages->limit,$pages->offst);
				
				// manage Sent box data
				$sent = new Pagination_ajax;
				$tmailData = $this->model_collaboration->getCommunicationSentTmail($this->userId);
				$countSent = count($tmailData);
				$sent->items_total = $countSent ; 
				$sent->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPageS;
				$sent->paginate(); 
				$this->data['items_total_sent']      = $sent->items_total;
				$this->data['items_per_page_sent']   = $sent->items_per_page;
				$this->data['pagination_links_sent'] = $sent->display_pages();	
				$this->data['countSentTotal']      	 = $countSent;
				//Get users communication sent tmail data 
				$this->data['comSentTmailData']      = $this->model_collaboration->getCommunicationSentTmail($this->userId,$sent->limit,$sent->offst);
				//manage members used ids
				if(is_array($this->data['membersData']) && count($this->data['membersData'])>0) {
					$memberIds =array();
					$memberData = $this->data['membersData'];
					foreach($memberData as $k=>$member){
						array_push($memberIds,$member->userId);
					}
					$this->data['memberIds'] = implode(',',$memberIds);
				}
				
				$dirname=$this->dirUpload.$collaborationId;
				$dirSize=getFolderSize($dirname);
				$fileMaxSize =($containerSize - $dirSize);
				if(!$fileMaxSize > 0){
					$fileMaxSize =0;
				}
				

				$this->data['userId']=$this->userId;
				$this->data['ownerId']=$userId;
				$this->data['sectionId']             = $sectionId;
				$this->data['elementId']             = $collaborationId;
				$this->data['entityId']              = getMasterTableRecord('Collaboration');
				$this->data['collaborationId']       = $collaborationId;
				$this->data['dirMedia']              = $this->dirUpload;
				$this->data['dirUpload']             = $this->dirUpload.$collaborationId.'/';
				$this->data['fileMaxSize']           = $fileMaxSize;
				$this->data['heading']               = $this->lang->line('communications');
				$this->data['currentMathod']         = 'communications';
				$this->data['welcomelink']           = base_url(lang().'/dashboard/collaboration/');
				$this->data['header']          	     = $this->load->view('manage_header',$this->data, true);
				$this->data['isCompose']             = $isCompose;
				$this->data['communicationForm']     = $this->load->view('communication_form', $this->data,true);
				$this->data['communicationList']     = $this->load->view('communication_list', $this->data,true);
				$this->data['communicationSentList'] = $this->load->view('communication_sent_list', $this->data,true);

				
				$leftView=$this->config->item('collaborationHelpPage');
				$this->data['leftContent']=$this->load->view($leftView,'',true);
				
				if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1 && $isCompose==2) {
					$this->load->view('communication_list', $this->data); //load view on pagination
				} elseif (isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1 && $isCompose==3) {
					$this->load->view('communication_sent_list', $this->data); //load view on pagination
				} else{
					$this->template->load('backend_template','communication',$this->data);
				}
			}else{
				set_global_messages('error', $this->lang->line('pageNotExist'));
				redirect('collaboration');
			}
		}
	}
	*/
	
	public function communications($collaborationId=0,$isCompose=0,$limit='',$perPage='') {
		
		$this->userId= $this->isLoginUser();
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$sectionId=$this->config->item('collaborationSectionId');
		
		if($collaborationId==0){
			redirect('collaboration');			
		}else{
			$containerWhere=array('collaborationId'=>$collaborationId);
			$containerDetails = $this->model_common->getContainerDetails('Collaboration',$containerWhere, 'Collaboration.title as collab_title, Collaboration.userId');
			if($containerDetails){
				if($this->userId == $containerDetails[0]['userId']){
						$userId=$this->userId;
				}else{
						$md=$this->model_common->getDataFromTabel('CollaborationMembers', 'memberId',  array('collaborationId'=>$collaborationId,'userId'=>$this->userId, 'status'=>1), '', '', '', 1);
						if($md && isset($md[0]->memberId) && ($md[0]->memberId > 0)){
							$userId=$containerDetails[0]['userId'];
						}
				}
				$containerSize = $containerDetails[0]['containerSize'];
				
				$where['cm.senderId']=$userId;
				$where['cm.collaborationId']=$collaborationId;
				
				$this->data['membersData']=$this->model_collaboration->getCollaborationMembers(array('clb.userId'=>$userId,'clb.collaborationId'=>$collaborationId));
				
				
				$members=false;
				if($this->data['membersData']){
					$members=array();
					foreach($this->data['membersData'] as $md){
						$members[]=$md->tdsUid;
					}
				}
				
				//Set pagination values
				$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdminUser');
				$perPageI=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordInbox');		
				$perPageS=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordSend');	
				
				/* manage Inbox data*/
				//Get tmail count
				
				$countTotal = countResult('tmail_messages',array('type'=>11,'elementId'=>$collaborationId));
				$pages = new Pagination_ajax;
				$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
				$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPageI;
				$pages->paginate();
				$this->data['items_total']      = $pages->items_total;
				$this->data['items_per_page']   = $pages->items_per_page;
				$this->data['pagination_links'] = $pages->display_pages();	
				$this->data['countTotal']       = $countTotal;
				//Get users communication tmail data
				$this->data['comTmailData'] = $this->model_collaboration->getCommunication(array('tm.elementId'=>$collaborationId),$pages->limit,$pages->offst);
				
				
				//manage members used ids
				if(is_array($this->data['membersData']) && count($this->data['membersData'])>0) {
					$memberIds =array();
					$memberData = $this->data['membersData'];
					foreach($memberData as $k=>$member){
						array_push($memberIds,$member->userId);
					}
					$this->data['memberIds'] = implode(',',$memberIds);
				}
				
				$dirname=$this->dirUpload.$collaborationId;
				$dirSize=getFolderSize($dirname);
				$fileMaxSize =($containerSize - $dirSize);
				if(!$fileMaxSize > 0){
					$fileMaxSize =0;
				}
				

				$this->data['userId']=$this->userId;
				$this->data['ownerId']=$userId;
				$this->data['sectionId']             = $sectionId;
				$this->data['elementId']             = $collaborationId;
				$this->data['entityId']              = getMasterTableRecord('Collaboration');
				$this->data['collaborationId']       = $collaborationId;
				$this->data['dirMedia']              = $this->dirUpload;
				$this->data['dirUpload']             = $this->dirUpload.$collaborationId.'/';
				$this->data['fileMaxSize']           = $fileMaxSize;
				$this->data['heading']               = $this->lang->line('communications');
				$this->data['currentMathod']         = 'communications';
				$this->data['welcomelink']           = base_url(lang().'/dashboard/collaboration/');
				$this->data['header']          	     = $this->load->view('manage_header',$this->data, true);
				$this->data['isCompose']             = $isCompose;
				$this->data['communicationForm']     = $this->load->view('communication_form', $this->data,true);
				$this->data['communicationList']     = $this->load->view('communication_list', $this->data,true);
				$this->data['communicationSentList'] = $this->load->view('communication_sent_list', $this->data,true);

				
				$leftView=$this->config->item('collaborationHelpPage');
				$this->data['leftContent']=$this->load->view($leftView,'',true);
				
				if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1 && $isCompose==2) {
					$this->load->view('communication_list', $this->data); //load view on pagination
				} elseif (isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1 && $isCompose==3) {
					$this->load->view('communication_sent_list', $this->data); //load view on pagination
				} else{
					$this->template->load('backend_template','communication',$this->data);
				}
			}else{
				set_global_messages('error', $this->lang->line('pageNotExist'));
				redirect('collaboration');
			}
		}
	}
	
	public function communicationsDetails($msgId=0, $collaborationId=0){
		$this->userId= $this->isLoginUser();
		
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		$msgId = is_numeric($msgId)?$msgId:0;
		
		$sectionId=$this->config->item('collaborationSectionId');
		
		if($collaborationId==0 || $msgId==0){
			redirect('collaboration');			
		}else{
			$containerWhere=array('collaborationId'=>$collaborationId);
			$containerDetails = $this->model_common->getContainerDetails('Collaboration',$containerWhere, 'Collaboration.title as collab_title, Collaboration.userId');
			if($containerDetails){
				if($this->userId == $containerDetails[0]['userId']){
						$userId=$this->userId;
				}else{
						$md=$this->model_common->getDataFromTabel('CollaborationMembers', 'memberId',  array('collaborationId'=>$collaborationId,'userId'=>$this->userId, 'status'=>1), '', '', '', 1);
						if($md && isset($md[0]->memberId) && ($md[0]->memberId > 0)){
							$userId=$containerDetails[0]['userId'];
						}
				}
				$containerSize = $containerDetails[0]['containerSize'];
				
				$where['tm.id'] = $msgId;
				$where['tm.elementId']=$collaborationId;
				
				
				$communicationData = $this->model_collaboration->getCommunication($where);
				
				
				
				
				if(!$communicationData){
					set_global_messages('error', $this->lang->line('pageNotExist'));
					redirect('collaboration');
				}
				$this->data['communicationData']= $communicationData[0];
				$this->data['commentsData']=$this->model_collaboration->getTodosComments(array('tc.elementId'=>$msgId,'tc.entityId'=>getMasterTableRecord('tmail_messages')));
				
				$dirname=$this->dirUpload.$collaborationId;
				$dirSize=getFolderSize($dirname);
				$fileMaxSize =($containerSize - $dirSize);
				if(!$fileMaxSize > 0){
					$fileMaxSize =0;
				}
				
				$this->data['sectionId']=$sectionId;
				$this->data['collaborationId']=$collaborationId;
				
				$this->data['msgId']=$msgId;
				$this->data['elementId'] = $msgId;
				$this->data['entityId'] = getMasterTableRecord('tmail_messages');
				
				$this->data['dirMedia']=$this->dirUpload;
				$this->data['dirUpload']=$this->dirUpload.$collaborationId.'/';
				$this->data['fileMaxSize']=$fileMaxSize;
				$this->data['heading']=$containerDetails[0]['collab_title'];
				$this->data['currentMathod']='communicationsDetails';
				$this->data['userId']=$this->userId;
				$this->data['ownerId']=$userId;
				$this->data['welcomelink']=base_url(lang().'/dashboard/collaboration/');
				$this->data['header']=$this->load->view('manage_header',$this->data, true);
				
				
				$this->data['commentList']=$this->load->view('comment_list', $this->data,true);
				$this->data['commentForm']=$this->load->view('comment_form', $this->data,true);
				
				$leftView=$this->config->item('collaborationHelpPage');
				$this->data['leftContent']=$this->load->view($leftView,'',true);
				$this->template->load('backend_template','communication_details',$this->data);
				
			}else{
				set_global_messages('error', $this->lang->line('pageNotExist'));
				redirect('collaboration');
			}
		}
	}
	
	/*
	 * This function used to send tmail
	 */
	public function sendCommunicationTmail(){
		$collaborationId = $this->input->post('collaborationId');
		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		if($this->input->post('recipientsId') && $collaborationId > 0)
		{
			$browseId = $this->input->post('browseId');
			$fileId = $this->input->post('fileId');
			$fileId = is_numeric($fileId)?$fileId:0;
			
			$isFile=true;
				$media_fileName=$this->input->post('fileName'.$browseId);
				$isExternal=($this->input->post('isExternal'.$browseId)=='t')?'t':'f';
				$embbededURL=$this->input->post('embbededURL'.$browseId);
				$fileType=$this->input->post('fileType'.$browseId);
				$mediaFileData=array();
				
				if($media_fileName && strlen($media_fileName)>3){
					
					$fileType=getFileType($media_fileName);
					$mediaFileData=array(
											'filePath'=>$this->dirUpload.$collaborationId.'/',
											'fileName'=>$media_fileName,
											'fileType'=>$fileType,
											'tdsUid'=>$userId,
											'isExternal'=>'f',
											'fileSize'=>$this->input->post('fileSize'.$browseId),
											'rawFileName'=>$this->input->post('fileInput'.$browseId),
											'jobStsatus'=>'UPLOADING'
										);
					
				}elseif($isExternal == 't' && $embbededURL && strlen($embbededURL)>3){
					
					
					$embbededURL=getUrl($embbededURL);
					$mediaFileData=array(
											'filePath'=>$embbededURL,
											'tdsUid'=>$userId,
											'fileType'=>$fileType,
											'isExternal'=>'t',
										);
					
				}else{
					$mediaFileData=array(
						'tdsUid'=>$userId,
						'fileType'=>$fileType,
						'isExternal'=>'f'
					);
					
				}
				
				if($isFile){
					
					$fileLength = $this->input->post('fileLength');
					switch($fileType)
					{
						case 1:
							$mediaFileData['fileHeight'] = ($this->input->post('fileHeight')=="")?Null:$this->input->post('fileHeight');
							$mediaFileData['fileWidth'] = ($this->input->post('fileWidth')=="")?Null:$this->input->post('fileWidth');
							$mediaFileData['fileUnit'] = ($this->input->post('fileUnit')=="")?Null:$this->input->post('fileUnit');
						break;
						
						case 2:
						case 3:
							$mediaFileData['fileLength'] = $fileLength;
							$mediaFileData['fileLength'] = $fileLength;
						break;
						
						case 4:
							$mediaFileData['fileLength'] = $this->input->post('wordCount');
						break;
					}
					
					$fileId=$this->manageMediaFile($fileId,$mediaFileData);
				}
			
			$isAllMember = $this->input->post('isAllMember');
			if($isAllMember==1) {
				$memberIds = $this->input->post('memberIds');
				$recipients = explode(',',$memberIds);
			} else {
				$recipients = $this->input->post('recipientsId');
			}
			
			$subject = $this->input->post('subject');
			$body = $this->input->post('body');
			$type = 11; //set communication's default type
			$msg = $this->tmail_messaging->send_new_message($this->userId,$recipients, $subject,$body,'',$type,$fileId,$collaborationId);
			if($this->input->post('ajaxHit')){
				$msg = $this->lang->line('sendCommunicationTmail');
				set_global_messages($msg, $type='success', $is_multiple=true);
				$returnData=array('msg'=>$msg,'value'=>1,'fileId'=>$fileId);
			}else{
				$msg = $this->lang->line('errorCommunicationTmail');
				set_global_messages($msg, $type='error', $is_multiple=true);
				$returnData=array('msg'=>$msg,'value'=>0);
			}
			echo json_encode($returnData); 
		}
	}
	
	/*
	 * This function used to view tmail of communication
	 */
	public function communicationTmail($collaborationId=0,$msgId=0) {
		$this->userId= $this->isLoginUser();
		if(!empty($msgId) && !empty($collaborationId)) {
			//update participants status
			$this->model_tmail->isRead($msgId,$this->userId);
			$this->data['collaborationId'] = $collaborationId;
			$this->data['section']         = $section; //1:Inbox, 2:Sent
			$this->data['type']            = 'Inbox';
			//Get tmail msg records
			$this->data['mailThreadData']  = $this->model_collaboration->getTmailData($msgId,$this->userId);
			//Get attachment data
			$this->data['attachmentData']  = $this->model_collaboration->getAttachmentData($msgId);
			//Set help view on side
			$leftView                      = $this->config->item('collaborationHelpPage');
			$this->data['leftContent']     = $this->load->view($leftView,'',true);
			//Load view of view tmail
			$this->template->load('backend_template','viewTmail',$this->data);
		} else {
			redirectToNorecord404();
		}
	}
	
	/*
	 * This function used to reply tmail of communication
	 */ 
	public function replyTmail() {
		
		$currentUser            = isLoginUser(); 
		$data['senderId']       = $currentUser; 			 
		$data['subject']        = $this->input->post('subject');
		$data['reply_msg_id']   = $this->input->post('reply_msg_id');
		$receiverid             = $this->input->post('receiverid'); 				
		$data['collaborationId']= $this->input->post('collaborationId'); 
		$data['msgType']        = $this->input->post('msgType');
		$threadId               = $this->input->post('threadId');
		$data['viewType']       = $this->input->post('viewType');				
		$data['replyEmailId']   = $this->model_tmail->getEmailId($receiverid);
		$msg_id                 = $this->input->post('reply_msg_id');
		$data['status_id']      = $this->input->post('currentRecordId');
		
		if( isset($data['replyEmailId'][0]->email) && $data['replyEmailId'][0]->email!='') {
			$data['replyrName'] = isGetUserName($receiverid); 
			$data['replyEmailId'] = $data['replyEmailId'][0]->email;	
		} else {			
			redirect(base_url(lang().'/collaboration'));
		}
		
		$data['receiverid']     = $receiverid;		
		$data['mailThreadData'] = $this->model_tmail->getMailThread($threadId,$currentUser,$msg_id);				
		$data['threadId']       = $threadId;
	
		$leftView=$this->config->item('collaborationHelpPage');
		$data['leftContent']=$this->load->view($leftView,'',true);
		
		$this->template->load('backend_template','tmail_reply',$data);
	}
	

	/*
	 * This function used to view tmail of communication
	 */
	public function communicationSentTmail($collaborationId=0,$msgId=0,$userId=0) {
		$this->userId= $this->isLoginUser();
		if(isset($userId) && !empty($userId) && !empty($msgId) && !empty($collaborationId)) {
			//update participants status
			$this->model_tmail->isRead($msgId,$userId);
			$this->data['collaborationId'] = $collaborationId;
			$this->data['section']         = $section; //1:Inbox, 2:Sent
			$this->data['type']            = 'Sent';
			//Get sent tmail msg records
			$this->data['mailThreadData']  = $this->model_collaboration->getSentTmailData($msgId,$userId);
			//Get attachment data
			$this->data['attachmentData']  = $this->model_collaboration->getAttachmentData($msgId);
			//Set help view on side
			$leftView                      = $this->config->item('collaborationHelpPage');
			$this->data['leftContent']     = $this->load->view($leftView,'',true);
			//Load view of view tmail
			$this->template->load('backend_template','viewTmail',$this->data);
		} else {
			redirectToNorecord404();
		}
	}

	
	public function assignedCollaboration($collaborationId=0){
		
		$this->userId= $this->isLoginUser();

		$collaborationId = is_numeric($collaborationId)?$collaborationId:0;
		
		if($collaborationId == 0){
			set_global_messages('error', $this->lang->line('pageNotExist'));
			redirect('dashboard/collaboration/containers');
		}
		
		$where['clb.collaborationId']=$collaborationId;
		$where['clb.isPublished']='t';
		$where['cm.userId']=$this->userId;
		$where['cm.status']=1;
		$this->data['collaborationData'] = $this->model_collaboration->assignedCollaborationToUser($where);
		
		if(!$this->data['collaborationData']){
			set_global_messages('error', $this->lang->line('pageNotExist'));
			redirect('dashboard/collaboration/containers');
		}
		
		
		$userId = $this->data['collaborationData'][0]->userId;
		
		$this->data['assignedCollaborationList'] = $this->model_collaboration->assignedCollaborationToUser(array('clb.isPublished'=>'t', 'cm.status'=>1, 'cm.userId'=>$this->userId));
		$this->data['collaborationList'] = $this->model_common->getDataFromTabel('Collaboration', 'title,collaborationId', array('userId' => $this->userId,'isArchive' => 'f'), '', 'collaborationId', 'DESC');
		
		$this->data['entityId']=getMasterTableRecord('Collaboration');
		$this->data['collaborationId'] = $collaborationId;
		$this->data['isArchive'] = 't';
		$this->data['sectionId'] = $this->config->item('collaborationSectionId');
		$this->data['section'] = 'collaboration';
		$this->data['currentMethod']='assignedCollaboration';
		$this->data['welcomelink']=base_url(lang().'/dashboard/collaboration/');
		
		$this->data['userId']=$this->userId;
		$this->data['ownerId']=$userId;
	
		$leftView=$this->config->item('collaborationHelpPage');
		$this->data['header']=$this->load->view('collaboration_header',$this->data,true);
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
		$this->template->load('backend_template','assigned_collaboration',$this->data);
	}
	
	public function changeMembersAccess(){
		$this->userId= $this->isLoginUser();
		
		$saveData['accessId']='{'.$this->input->post('val1').'}';
		$saveData['memberId']=$memberId=$this->input->post('val2');
		$saveData['collaborationId']=$collaborationId=$this->input->post('val3');
		$saveData['assignedBy']=$this->userId;
		
		$ma=$this->model_common->getDataFromTabel('CollaborationMembersAccess', 'memberAccessId',  array('collaborationId'=>$collaborationId,'memberId'=>$memberId), '', '', '', 1);
		if(isset($ma[0]->memberAccessId) && ($ma[0]->memberAccessId > 0)){
			$memberAccessId=$ma[0]->memberAccessId;
			$this->model_common->editDataFromTabel('CollaborationMembersAccess', $saveData, array('memberAccessId'=>$memberAccessId));

		}else{
			$memberAccessId=$this->model_common->addDataIntoTabel('CollaborationMembersAccess', $saveData);
		}				
		
		$returnData=array('memberAccessId'=>$memberAccessId,'success'=>1);
		echo json_encode($returnData);
		
	}
	
	private function getMembersAccess($collaborationId=0){
		$this->userId= $this->isLoginUser();
		$data=$this->model_collaboration->getMembersAccess(array('cm.userId'=>$this->userId,'cm.collaborationId'=>$collaborationId));
		if($data){
			$data=$data[0];
			$accessId=$data->accessId;
			$accessId=explode('{',$accessId);
			$accessId=$accessId[1];
			$accessId=explode('}',$accessId);
			$accessId=$accessId[0];
			$accessId=explode(',',$accessId);
			
			$this->data['userCollabAccess']=$this->model_common->getDataFromTabelWhereIn('CollaborationAccess', 'key',  'accessId', $accessId);
			
		}else{
			$this->data['userCollabAccess']=array('none');
		}
		
	}
}
