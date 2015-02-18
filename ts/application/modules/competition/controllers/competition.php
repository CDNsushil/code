<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Todasquare competition Controller Class
 *
 *  manage competition details (Film & Video, Music & Audio, Photography & Art,
 *	 Writing & publishing, Education Material)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class competition extends MX_Controller {
	private $data = array();
	private $dirCache = '';
	private $dirUpload = '';
	private $dirEntry = '';
	private $userId = null;
	private $competitionData = array();
	/**
	 * Constructor
	 */
	function __construct() { 
			//Load required Model, Library, language and Helper files
			$load = array(
				'language'	=> 'competition',
				'model'		=> 'model_competition',
				'library'	=> 'lib_competition',
				'helper'   => 'competition',
			);
			parent::__construct($load);		
			
			$this->userId= isLoginUser();
			
			$this->dirCache = 'cache/competition/';  
			$this->dirUpload = 'media/'.LoginUserDetails('username').'/competition/'; 
			$this->dirEntry = 'media/'.LoginUserDetails('username').'/competitionentry/'; 
			$this->dirTrash = 'trash/'.LoginUserDetails('username').'/competition/'; 
			$this->competitionData = $this->lib_competition->getValues();
			
			$this->head->add_css($this->config->item('system_css').'upload_file.css');
			$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
			$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
			$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
			
			
			
			$this->head->add_css($this->config->item('system_css').'frontend.css');
			//$this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
			//$this->head->add_js($this->config->item('frontend_js').'jquery.anythingslider.js');
			$this->head->add_js($this->config->item('frontend_js').'jquery.tinycarousel.min.js');
			$this->head->add_js($this->config->item('frontend_js').'jquery-gallery-cdn.js');	
			
			//add advertising module if exists
			if(is_dir(APPPATH.'modules/advertising')){
				$this->load->model(array('advertising/model_advertising'));
			}
			 			
	}

/*============================Film and Video Section==================================================*/	
	/**
	 * Index fucntion by default call when Controller initialised
	 *	
	 * @details : landing page of competition
	 * @access	public
	 * @param	
	 * @return	
	 */
	 
	 public function index() {
		
		$loggedUserId=0; 
		if(isloginUser()){
			$loggedUserId=isloginUser();
		}	
		$orderby='elementId';
		$isPublished = 1;
		$elementOrderBy='modifyDate';
		$order='DESC';
		$fetchElementFields = '';
		
		$this->data['label'] = $this->lang->load('common');	
		
		$industryType = $this->config->item('FV');
		$industryKey = $this->config->item('FVTYPE');
		
		$isCompetitionList = false;
		$isSearchData = '';
		if($this->input->post()){
			$isCompetitionList = ($this->input->post('selectIndustry')=="")?false:true;
			$isSearchData = array('selectIndustry'=>$this->input->post('selectIndustry'),
									'sortBy'=>$this->input->post('sortBy'));
		}
		
		$this->data['isCompetitionList'] = $isCompetitionList;
		$this->data['competition_array'] =$this->model_competition->getCompetitionProjectsList($isSearchData,$loggedUserId);
		
		$this->template_front_end->load('template_front_end','competition_landingpage',$this->data);
		
		
	}
	 
	/*
	 ********************* 
	 * This function is used to showcase of competition
	 ******************** 
	 */ 

	public function showcase($userId=0,$competitionId=0,$language='language1'){	
		
		$userId=$userId>0?$userId:$this->userId;
		
		if(!($userId > 0)){
			redirect('competition');
		}
		
		if($competitionId==0)
		{
			$latestComp = $this->model_competition->getUserProjects($userId);	
			if($latestComp)
			{
				$latestComp = $latestComp[0];
				$competitionId = $latestComp->competitionId;
			}
		}else
		{
			$latestComp = $this->model_competition->getDataByCompetitionId($userId,$competitionId);
			if($latestComp)
			{
				$latestComp = $latestComp[0];
				$competitionId = $latestComp->competitionId;
			}
		}
		
		// if no data for this competition id then redirect to home
		
		if(!$latestComp)
		{
				redirect('competition');
		}
		
		
		$currentDate = strtotime(date("Y-m-d"));
		$round1VotingEndDate = strtotime($latestComp->votingEndDate);
		$roundType = $latestComp->competitionRoundType;
		if($roundType==2){
			$round2VotingEndDate = strtotime($latestComp->votingEndDateRound2);
		}
		
		// get closed second round
		if($round1VotingEndDate < $currentDate){
			$closedRound='1';
		}
		
		// get closed second round 
		if(isset($round2VotingEndDate)) {
			if($round2VotingEndDate < $currentDate){
				$closedRound='2';
			}
		}
		
		// here get winnins list of competition entry
		$this->data['competitionWinnerList']=$this->model_competition->getCurrentPlacing($competitionId,$closedRound);
	
		//set media details by selected language
		if($language=='language2'){
			$this->data['competitionMediaData']	= $this->model_competition->comptitionMediaDetailsLang2($competitionId);
		}else{
			$this->data['competitionMediaData']	= $this->model_competition->getComptitionMediaDetails(array('media.competitionId'=>$competitionId));
		}
	
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')){
			
			//Set advert section id
			$advertSectionId = $this->config->item('competitionSectionId');				    
		
			//Get banner records based on section and advert type
			$bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
			$this->data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType4'=>$bannerType4,'sectionId'=>$advertSectionId),true);	
		} 
	
		$this->data['competitionDetail']	= $latestComp;		
		$this->data['userId']				= $userId;	
		$this->data['competitionId']		= $competitionId;	
		$this->data['language']				= $language;	
		$this->template_front_end->load('template_front_end','competition',$this->data);
	}
	
	
	/*
	 ****************************** 
	 * This function is used to show prize of competition by userId and competition Id
	 ******************************
	 */  
	
	public function prizeslist($userId=0,$competitionId=0){	
				
		$userId=$userId>0?$userId:$this->userId;
		
		if(!($userId > 0) || !($competitionId > 0)){
			redirect('home');
		}
		
		$this->data['userId']	= $userId;	
		$this->data['competitionId']	= $competitionId;	
		
		//get competition data
		$whereCondition = array('competitionId' => $competitionId);	
		$this->data['competitionData']  = $this->model_common->getDataFromTabel($table='Competition', 'title',  $whereCondition, '', $orderBy='competitionId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
		if(empty($this->data['competitionData'])){
			redirect('home');
		}
		
		//get competition prizes data
		$whereCondition = array('competitionId' => $competitionId);	
		$this->data['competitionPrizes']  = $this->model_common->getDataFromTabel($table='CompetitionPrizes', '*',  $whereCondition, '', $orderBy='order', $order='ASC', $limit=0, $offset=0, $resultInArray=false);
		$this->template_front_end->load('template_front_end','competition_prizes_list',$this->data);
	}
	
	
	/*
	 ****************************** 
	 * This function is used to show prize of competition by userId and competition Id
	 ******************************
	 */  
	
	public function entrieslist($userId=0,$competitionId=0){	
				
		$userId=$userId>0?$userId:$this->userId;
		
		if(!($userId > 0) && !($competitionId > 0)){
			redirect('home');
		}
		
		$this->data['userId']	= $userId;	
		$this->data['competitionId']	= $competitionId;	
		$this->data['entityId']=getMasterTableRecord('Competition');
		//get competition data
		$whereCondition = array('competitionId' => $competitionId);	
		$this->data['competitionData']  = $this->model_common->getDataFromTabel($table='Competition', 'title,votingStartDate,votingEndDate',  $whereCondition, '', $orderBy='competitionId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
		
		if(empty($this->data['competitionData'])){
			redirect('home');
		}
		//get competition prizes data
		$competitionEntries = $this->model_competition->getCompetitionEntries($competitionId);
		$this->data['competitionEntries'] = $competitionEntries;
		
		$this->template_front_end->load('template_front_end','competition_entries_list',$this->data);
	}
	
	
	/*
	 ****************************** 
	 * This function is used to show popup of competition entries details data
	 ******************************
	 */  
	
	public function entriespopup(){
		
		$competitionId = $this->input->get('val1');
		$competitionEntryId = $this->input->get('val2');
		$whereCondition = array('competitionId' => $competitionId);	
		$this->data['competitionData']  = $this->model_common->getDataFromTabel($table='Competition', 'title,votingStartDate,votingEndDate',  $whereCondition, '', $orderBy='competitionId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
		
		if(empty($this->data['competitionData'])){
			redirect('home');
		}
		$getCompetitionEntriesData = $this->model_competition->getCompetitionEntriesData($competitionEntryId);
		$this->data['competitionEntriesData'] = $getCompetitionEntriesData;	
		$this->data['entityId']=getMasterTableRecord('Competition');
		$this->load->view('competition_entries_popup',$this->data);
	}		
				
	/*
	 ********************************************** 
	 * This function is used to show competition listing
	 ********************************************** 
	 */ 

	public function competitiondeleteditems($competitionId=0) {
		$this->competitionlist($competitionId,$isArchive='t');
	}
	
	public function competitionlist($competitionId=0,$isArchive='f') {
	
		$userId = $this->isLoginUser();
		$competitionId= is_numeric($competitionId)?$competitionId:0;
		
		if($isArchive == 't'){
			$currentMethod='competitiondeleteditems';
		}else{
			$isArchive = 'f';
			$currentMethod='competitionlist';
		}
		
		
		if($competitionId > 0){
			$whereCondition = array('competitionId'=>$competitionId,'userId' => $userId,'isArchive' => $isArchive);
		}else{
			$whereCondition = array('userId' => $userId,'isArchive' => $isArchive);
		}
		
		$competition_data  = $this->model_common->getDataFromTabel('Competition', 'competitionId',  $whereCondition, '', 'competitionId', 'DESC', 1);
		
		if(isset($competition_data[0]->competitionId)){
			$competitionId = $competition_data[0]->competitionId;
		}
		else{
			if($competitionId > 0){
				redirect('competition/'.$currentMethod);
			}else{
				$competitionId = 0;
			}
		}
		
		if($competitionId > 0){
			$competition_data=$this->model_competition->getComptitionDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$userId,'comp.isArchive'=>$isArchive));
		}
		
		
		
		/**********get competition entry data**********/
		$whereCondition = array('competitionId'=>$competitionId,'isPublished'=>'t');
		$competition_entries_count = $this->model_common->countResult('CompetitionEntry', $whereCondition);
		
		$pages = new Pagination_ajax;
		$pages->items_total = $competition_entries_count;
		$perPage = $this->config->item('competitionEntryPerPage');
		
		// ADD by Amit to set cookie		
		$isSetCookie = setPerPageCookie('competitionEntryView',$perPage);		
		$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$isSetCookie;
		$pages->paginate();
		$data['entityId']=getMasterTableRecord('Competition');
		$data['perPageRecord'] = $pages->items_per_page;
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();
		$data['countTotal'] = $competition_entries_count;	
		$competition_entries_data  = $this->model_common->getDataFromTabel('CompetitionEntry', '*',  $whereCondition, '', $orderBy='competitionEntryId', $order='DESC', $pages->items_per_page, $pages->offst);
		
		$data['sectionId'] = $this->config->item('competitionSectionId');
		$data['section'] = $section = 'competition';
		$data['dirMedia']=$this->dirUpload.$competitionId;
		$data['userId'] = $userId;
		$data['competitionId'] = $competitionId;
		$data['isArchive'] = $isArchive;	
		$data['currentMethod'] = $currentMethod;
		
		$data['competition_data'] = $competition_data;
		$data['competition_entries_data'] = $competition_entries_data;
		
		$breadcrumbItem[]='competitionlist';
		$breadcrumbURL[]='competition/competitionlist/';
		if($isArchive=='t'){
			$breadcrumbItem[]='competitiondeleteditems';
			$breadcrumbURL[]='competitionen/competitiondeleteditems/';
		}
 
		$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
		$data['breadcrumbString']=$breadcrumbString;
		
		$deleteCache=$section.'_'.$competitionId.'_'.$userId;
		$refereshCashe=LoginUserDetails($deleteCache);
		if($refereshCashe==1){				
			$this->writeCompetitionCacheFile($competitionId);
		}
			
		if($this->input->post('ajaxRequest'))
		{
			$this->load->view('competition_entries_view',$data);
		}else
		{
			
			$leftView=$this->config->item('competitionHelpPage'); 
			$data['leftContent']=$this->load->view($leftView,'',true);
			$this->template->load('backend_template','competition_list',$data);
			//$this->template->load('template','competition_list', $data);
		}
		
	}
	
	public function compMedialang1($competitionId=0) {
		$this->userId= $this->isLoginUser();
		
		if(!is_numeric($competitionId) || $competitionId==0){
			redirect('competition/competitionlist');
		}
		
		$isMultilingual=false;
		$languageLink1='javascript:void(0);';
		$languageLink2='javascript:void(0);';
		$activeLang1 = 'orange';
		$activeLang2 = 'grey';
		$language1 = $this->lang->line('language1');
		$language2 = $this->lang->line('language2');
		
		$competitionData=$this->model_competition->getComptitionDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$this->userId));
		
		if($competitionData && isset($competitionData[0]->containerSize)){
			
			$this->competitionData=$competitionData=$competitionData[0];
			$competitionLangId = (isset($competitionData->competitionLangId) && is_numeric($competitionData->competitionLangId))?$competitionData->competitionLangId:0;
			$isMultilingual = (isset($competitionData->isMultilingual) && ($competitionData->isMultilingual == 't'))?true:false;
			$languageId1 = (isset($competitionData->languageId) && is_numeric($competitionData->languageId))?$competitionData->languageId:0;
			if($languageId1 > 0){
				$language1 = $competitionData->Language_local;
			}
			$languageId2 = (isset($competitionData->languageId2) && is_numeric($competitionData->languageId2))?$competitionData->languageId2:0;
			
			if($isMultilingual && ($languageId2 > 0)){
				$langRes=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId2,'', '', $limit=1 );
				if($langRes && isset($langRes[0]->Language_local)){
					$language2 = $langRes[0]->Language_local;
				}
			}else{
				$isMultilingual = false;
			}
			
			$languageLink2=base_url(lang().'/competition/competitionMedia/language2/'.$competitionId);
			$activeLang2 = 'dash_link_hover';

			
			$containerSize = $this->competitionData->containerSize;
			
			$dirname=$this->dirUpload.$competitionId;
			$dirSize=getFolderSize($dirname);
			$fileMaxSize =($containerSize - $dirSize);
			if(!$fileMaxSize > 0){
				$fileMaxSize =0;
			}
			
		}else{
			redirect('competition/competitionlist');
		}
		
		
		
		$countMediaData=0;
		$competitionMediaData=$this->model_competition->getComptitionMediaDetails(array('media.competitionId'=>$competitionId));
		if($competitionMediaData){
			$countMediaData=count($competitionMediaData);
		}
		
		$this->data['isMultilingual']=$isMultilingual;
		$this->data['competitionLangId']=$competitionLangId;
		$this->data['languageLink1']=$languageLink1;
		$this->data['languageLink2']=$languageLink2;
		$this->data['activeLang1']=$activeLang1;
		$this->data['activeLang2']=$activeLang2;
		$this->data['language1']=$language1;
		$this->data['language2']=$language2;
		
		$this->data['heading']='Required Media';
		$this->data['currentMathod']='competitionMedia';
		
		$this->data['competitionId']=$competitionId;
		$this->data['userId']=$this->userId;
		$this->data['countMediaData']=$countMediaData;
		$this->data['competitionMediaData']=$competitionMediaData;
		$this->data['dirUpload'] = $this->dirUpload.$competitionId;;
		$this->data['containerSize'] = $containerSize;
		
		$this->data['header']=$this->load->view('backendTab',$this->data, true);
		$this->data['competitionMediaForm']=$this->load->view('competition_media_form', $this->data,true);
		$this->data['competitionMediaList']=$this->load->view('competition_media_list', $this->data,true);
		
		$leftView=$this->config->item('competitionHelpPage');
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','competition_media',$this->data);
			
		//$this->template->load('template','competition_media',$this->data);	
	}
	
	public function compMedialang2($competitionId=0,$competitionLangId=0) {
		
		$userId = $this->isLoginUser();
		$competitionId = (isset($competitionId) && ($competitionId>0)) ? $competitionId :$this->input->post('competitionId'); 
		
		if(!is_numeric($competitionId) || $competitionId==0){
			redirect('competition/competitionlist');
		}
		
		$isMultilingual=false;
		$languageLink1='javascript:void(0);';
		$languageLink2='javascript:void(0);';
		$activeLang1 = 'grey';
		$activeLang2 = 'orange';
		$language1 = $this->lang->line('language1');
		$language2 = $this->lang->line('language2');
		
		$competitionData=$this->model_competition->getComptitionLangDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$this->userId));
		if($competitionData){
			
			$competitionData=$competitionData[0];
			$competitionLangId = (isset($competitionData->competitionLangId) && is_numeric($competitionData->competitionLangId))?$competitionData->competitionLangId:0;
			$isMultilingual = (isset($competitionData->isMultilingual) && ($competitionData->isMultilingual == 't'))?true:false;
			
			if($isMultilingual &&$competitionLangId > 0){
			
				$languageId2 = (isset($competitionData->languageId) && is_numeric($competitionData->languageId))?$competitionData->languageId:0;
				if($languageId2 > 0){
					$language2 = $competitionData->Language_local;
				}
				
			}else{
				redirect('competition/competitionMedia/language1/'.$competitionId);
			}
			
			$languageId1 = (isset($competitionData->languageId1) && is_numeric($competitionData->languageId1))?$competitionData->languageId1:0;
				
			if($isMultilingual && ($languageId1 > 0)){
				$langRes=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId1,'', '', $limit=1 );
				if($langRes && isset($langRes[0]->Language_local)){
					$language1 = $langRes[0]->Language_local;
				}
			}
			
			$languageLink1=base_url(lang().'/competition/competitionMedia/language1/'.$competitionId);
			$activeLang1 = 'dash_link_hover';
		
		}else{
			redirect('competition/competitionlist');
		}
		
		$countMediaData=0;
		$competitionMediaData=$this->model_competition->getComptitionMediaLangDetails(array('media.competitionId'=>$competitionId));
		if($competitionMediaData){
			$countMediaData=count($competitionMediaData);
		}
		
		$this->data['isMultilingual']=$isMultilingual;
		$this->data['competitionLangId']=$competitionLangId;
		$this->data['languageLink1']=$languageLink1;
		$this->data['languageLink2']=$languageLink2;
		$this->data['activeLang1']=$activeLang1;
		$this->data['activeLang2']=$activeLang2;
		$this->data['language1']=$language1;
		$this->data['language2']=$language2;
		
		$this->data['heading']='Required Media';
		$this->data['currentMathod']='competitionMedia';
		
		$this->data['competitionId']=$competitionId;
		$this->data['userId']=$this->userId;
		$this->data['countMediaData']=$countMediaData;
		$this->data['competitionMediaData']=$competitionMediaData;
		$this->data['dirUpload'] = $this->dirUpload.$competitionId;;
		$this->data['containerSize'] = $containerSize;
		
		$this->data['header']=$this->load->view('backendTab',$this->data, true);
		$this->data['competitionMediaForm']=$this->load->view('competition_mediaLang_form', $this->data,true);
		$this->data['competitionMediaList']=$this->load->view('competition_mediaLang_list', $this->data,true);
		
		$leftView=$this->config->item('competitionHelpPage');
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','competition_media',$this->data);
		
		//$this->template->load('template','competition_media',$this->data);		
	}
	
	public function saveCompMedialang2() {
		
		$this->userId= $this->isLoginUser();
		$config = array(
              array(
                     'field'   => 'mediaLangId',
                     'label'   => 'mediaLangId',
                     'rules'   => 'trim|xss_clean'
                  ),
              array(
                     'field'   => 'mediaId',
                     'label'   => 'mediaId',
                     'rules'   => 'trim|xss_clean'
                  ),
              array(
                     'field'   => 'competitionId',
                     'label'   => 'competitionId',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'title',
                     'label'   => 'Title',
                     'rules'   => 'trim|required|xss_clean'
                  ),
			   array(
				 'field'   => 'description',
				 'label'   => 'Description',
				 'rules'   => 'trim|xss_clean'
			  )
			  ,
			   array(
				 'field'   => 'fileOrder',
				 'label'   => 'fileOrder',
				 'rules'   => 'trim|xss_clean'
			  )     
            );
		
		$this->form_validation->set_rules($config);
		
		if($this->input->post('submit')=='Save'  && $this->form_validation->run()){
			
			$competitionId=set_value('competitionId');
			$mediaLangId=set_value('mediaLangId');
			$mediaId=set_value('mediaId');
			$fileOrder=set_value('fileOrder');
			
			
			$competitionId=is_numeric($competitionId)?$competitionId:0;
			$mediaId=is_numeric($mediaId)?$mediaId:0;
			$mediaLangId=is_numeric($mediaLangId)?$mediaLangId:0;
			$fileOrder=is_numeric($fileOrder)?$fileOrder:0;
			
			
			
			
			if(is_numeric($competitionId) &&  ($competitionId > 0) && is_numeric($mediaId) &&  ($mediaId > 0) ){
				
				$countResult=$this->model_common->countResult('CompetitionMedia',array('mediaId'=>$mediaId,'competitionId'=>$competitionId));
				
				if(is_numeric($countResult) && ($countResult > 0)){
				
					
					$dataCompetition = array(
						'mediaId' => $mediaId,
						'title' => pg_escape_string(set_value('title')),
						'description' => pg_escape_string(set_value('description')),
						'fileOrder' => $fileOrder,
						'modifyDate' => currntDateTime('Y-m-d h:i:s')
					);
					
					if(is_numeric($mediaLangId) &&  ($mediaLangId > 0)){
						$this->model_common->editDataFromTabel('CompetitionMediaLang', $dataCompetition, array('mediaLangId'=>$mediaLangId,'mediaId'=>$mediaId));
						$msg=$this->lang->line('updatedCompetition');
					}else{
						$dataCompetition['createdDate'] = currntDateTime(); 
						$competitionLangId=$this->model_common->addDataIntoTabel('CompetitionMediaLang', $dataCompetition);
						$msg=$this->lang->line('addedCompetitionLang');
					}
					set_global_messages($msg, $type='success', $is_multiple=true);
			
					/*$returnData=array('competitionId'=>$competitionId,'fileId'=>$com_sampleFileId,'uploadedFile'=>$uploadedFile);
					echo json_encode($returnData);
					*/
				}
			}
			redirect('competition/competitionMedia/language2/'.$competitionId);
		}else{
			redirect('competition/competitionlist');
		}
		
	}
	
	
	/*
	 ************************************
	 * This method is used to save competition media and show list
	 *********************************** 
	 */  
	 
	 

	public function competitionMediaSave() {
		
		
		
		if($this->input->post('saveMedia')=='saveMedia'){
			
			$userId= $this->isLoginUser();
			
			//------------piece add section------------//
			if($this->input->post('mediaFormAction')=='mediaAdd') {
				
				$competitionId = $this->input->post('competitionId');
				$title = $this->input->post('title');
				$fileOrder = $this->input->post('mediaOrder');
				$browseId = $this->input->post('browseId');
				$description = $this->input->post('description');
				$insertData = array('competitionId'=>$competitionId,'title'=>$title,'fileOrder'=>$fileOrder,'description'=>$description);
				$competitionMediaId = $this->model_common->addDataIntoTabel('CompetitionMedia', $insertData);
				
				//--------media data prepair for inserting------//
				$isFile=false;
				$media_fileName=$this->input->post('fileName'.$browseId);
				$isExternal=($this->input->post('isExternal'.$browseId)=='t')?'t':'f';
				$embbededURL=$this->input->post('embbededURL'.$browseId);
				$mediaFileData=array();
				if($media_fileName && strlen($media_fileName)>3){
					$isFile=true;
					$fileType=getFileType($media_fileName);
					$mediaFileData=array(
											'filePath'=>$this->dirUpload.$competitionId.'/',
											'fileName'=>$media_fileName,
											'fileType'=>$fileType,
											'tdsUid'=>$userId,
											'isExternal'=>'f',
											'fileSize'=>$this->input->post('fileSize'.$browseId),
											'rawFileName'=>$this->input->post('fileInput'.$browseId),
											'jobStsatus'=>'UPLOADING'
										);
					
				}elseif($isExternal == 't' && $embbededURL && strlen($embbededURL)>3){
					$isFile=true;
					$fileType=$this->input->post('fileType'.$browseId);
					$embbededURL=getUrl($embbededURL);
					$mediaFileData=array(
											'filePath'=>$embbededURL,
											'tdsUid'=>$userId,
											'fileType'=>$fileType,
											'isExternal'=>'t',
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
					
					$fileId=$this->manageCompetitionMediaFile(0,$mediaFileData);
			
				}else{
					$fileId=0;
				}
				if($fileId > 0){
					$updateData = array('fileId'=>$fileId);
					$this->model_common->editDataFromTabel('CompetitionMedia', $updateData, array('mediaId'=>$competitionMediaId));	
				}
				$msg=$this->lang->line('addedCompetitionMedia');
				set_global_messages($msg, $type='success', $is_multiple=true);
				$returnData=array('msg'=>$msg,'competitionMediaId'=>$competitionMediaId,'fileId'=>$fileId);
				echo json_encode($returnData);
			}
			//------------competition media update section------------//
			if($this->input->post('mediaFormAction')=='mediaEdit') {
				
				$title = $this->input->post('title');
				$description = $this->input->post('description');
				$mediaId = $this->input->post('mediaId');
				$updateData = array('title'=>$title,'description'=>$description);
				$this->model_common->editDataFromTabel('CompetitionMedia', $updateData, array('mediaId'=>$mediaId));	
				
				//---------media file data update---------//
				
				$fileId = $this->input->post('fileId');
				if($fileId > 0) {
					$browseId = $this->input->post('browseId');
					$fileType=$this->input->post('fileType'.$browseId);
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
					
					$isExternal=($this->input->post('isExternal'.$browseId)=='t')?'t':'f';
					$embbededURL=$this->input->post('embbededURL'.$browseId);
					// if type is external then update file
					if($isExternal=="t"){
						$mediaFileData['filePath'] = $embbededURL;
					}
					
					$this->model_common->editDataFromTabel('MediaFile', $mediaFileData, array('fileId'=>$fileId));
				}
				$msg=$this->lang->line('updatedCompetitionMedia');
				set_global_messages($msg, $type='success', $is_multiple=true);
				$returnData=array('msg'=>$msg);
				echo json_encode($returnData);
			}
		}
	}
	
	
	
	/*
	 ******************************** 
	 * This function is used to delete competition media delete
	 ******************************** 
	 */ 
	function competitionMediaDelete(){
		
		$mediaId = $this->input->post('mediaId');
		$fileId=$this->input->post('fileId');
		
		$fileData  = $this->model_common->getDataFromTabel('MediaFile', $field='filePath,fileName,isExternal',  $whereField=array('fileId'=>$fileId), '', '', '',1);

		// delete all images with associated with thie prize id
		if($fileData)
		{
			if($fileData[0]->isExternal=="f"){	
					$mediaImage = $fileData[0]->filePath.$fileData[0]->fileName;
					if($mediaImage && strlen($mediaImage)>3 && is_file($mediaImage)){
					$fileInfo=pathinfo($mediaImage);
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
		}
		// media file record delete 
		$this->model_common->deleteRowFromTabel('MediaFile','fileId',$fileId);
		// competition media delete 
		$this->model_common->deleteRowFromTabel('CompetitionMedia','mediaId',$mediaId);
		$msg=$this->lang->line('deleteCompetitionMedia');
		set_global_messages($msg, $type='success');
		$returnData=array('msg'=>$msg);
		echo json_encode($returnData);
	}

	
	public function competitiongroups($competitionId=0) {
		$userId = $this->isLoginUser();
		$this->data['sectionId'] = $this->config->item('competitionSectionId');
		$this->data['competitionId'] = $competitionId;
		$this->data['currentMathod'] = 'competitiongroups';
		$this->data['heading'] = $this->lang->line('competitionsGroup');
		$this->data['header']=$this->load->view('competitionGroup_header',$this->data, true);
		$this->data['countGroup'] = $this->model_common->countResult('CompetitionGroup', array('userId'=>$userId));
		$this->competitionGroupForm();
		$this->competitiongroupsList();
		
		$leftView=$this->config->item('competitionHelpPage');
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','competition_group',$this->data);
		
		//$this->template->load('template','competition_group',$this->data);
	}
	
	public function competitiongroupsList() {
		$userId= $this->isLoginUser();
		$this->data['CompetitionGroupsData']=$this->model_common->getDataFromTabel('CompetitionGroup', '*',  array('userId'=>$userId),'','order','ASC' );
		$this->data['competitiongroupsList']=$this->load->view('competition_group_list', $this->data,true);
	}
	
	public function competitionGroupForm() {
		
		$userId= $this->isLoginUser();
		$ajaxHit=$this->input->post('ajaxHit');
		$this->data['dirUpload']=$this->dirUpload;
		$this->data['fileMaxSize']=$this->config->item('defaultContainerSize');
		$this->data['userId']=$userId;
		$this->data['ajaxHit']=$ajaxHit;
		
		if($ajaxHit==1){
			$this->load->view('competition_group_add_edit', $this->data);
		}else{
			$this->data['competitionGroupForm']=$this->load->view('competition_group_add_edit', $this->data,true);
		}
	}
	
	public function competitionGroupSave() {
		
		$this->userId= $this->isLoginUser();
		$config = array(
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
                     'field'   => 'onelineDescription',
                     'label'   => 'One Line Description',
                     'rules'   => 'trim|xss_clean'
                  ),    
                    
				array(
					'field'   => 'description',
					'label'   => 'description',
					'rules'   => 'trim|xss_clean'
				) 
              
            );
		
		$this->form_validation->set_rules($config);
		
		if($this->input->post('saveGroup')=='saveGroup'  && $this->form_validation->run()){
			$ajaxHit=$this->input->post('ajaxHit');
			$saveMode='add';
			
			$competitionGroupId=$this->input->post('competitionGroupId');
			$competitionGroupId=(is_numeric($competitionGroupId) && ($competitionGroupId > 0))?$competitionGroupId:0;
			$browseId = $this->input->post('browseId');
			$com_coverImage='';
			$sampleFile= false;
			
			if($competitionGroupId > 0){
				
				$CompetitionGroupData=$this->model_common->getDataFromTabel('CompetitionGroup', 'coverImage',  array('competitionGroupId'=>$competitionGroupId,'userId'=>$this->userId), '','','', 1);
				
				if($CompetitionGroupData && is_array($CompetitionGroupData) && count($CompetitionGroupData) > 0){
					$CompetitionGroupData=$CompetitionGroupData[0];
					$saveMode='edit';
					$com_coverImage=$CompetitionGroupData->coverImage;
				}else{
					$msg='You do not have permision to update this.';
				}
			}else{
				$saveMode='add';
				$competitionGroupId=0; 
			}	
			
			$uploadedFile=0;
			
			$dataCompetition = array(
				'userId' => $this->userId,
				'title' => pg_escape_string(set_value('title')),
				'tagwords' => pg_escape_string(set_value('tagwords')),
				'onelineDescription' => pg_escape_string(set_value('onelineDescription')),
				'description' => pg_escape_string(set_value('description'))
			);
			
			$coverImage=$this->input->post('fileName'.$browseId);
			if($coverImage && strlen($coverImage)>3){
				$uploadedFile++;
				$dataCompetition['coverImage']= $this->dirUpload.$coverImage;
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
			
			$countGroup = $this->model_common->countResult('CompetitionGroup', array('userId'=>$this->userId));
			
			if($saveMode=='add'){
				$competitionGroupLimit=$this->config->item('competitionGroupLimit');
				if($competitionGroupLimit > $countGroup){
					$dataCompetition['createdDate'] = currntDateTime(); 
					$dataCompetition['order'] =$countGroup; 
					$competitionGroupId=$this->model_common->addDataIntoTabel('CompetitionGroup', $dataCompetition);
					$msg=$this->lang->line('addedCompetitionGroup');
				}else{
					$msg=$this->lang->line('You have already added '.$competitionGroupLimit.' Competition Group.');
				}
				
			}
			
			if($saveMode=='edit'){
				$dataCompetition['modifyDate'] = currntDateTime(); 
				$this->model_common->editDataFromTabel('CompetitionGroup', $dataCompetition, array('competitionGroupId'=>$competitionGroupId));
				$msg=$this->lang->line('updatedCompetitionGroup');
			}
			
			
			
			$returnData=array('competitionGroupId'=>$competitionGroupId,'uploadedFile'=>$uploadedFile,'msg'=>$msg,'saveMode'=>$saveMode,'countGroup'=>$countGroup);
			echo json_encode($returnData);
			
			if($ajaxHit==0 || empty($ajaxHit)){
				set_global_messages($msg, $type='success', $is_multiple=true);
			}
			
		}
		else{
			redirect('competition/competitionlist');
		}
	}

	
	public function description($language='language1', $competitionId=0, $competitionLangId=0) {
		if($language != 'language2'){
			$language = 'language1';
		}
		$this->data['currentLang']=$language;
		
		$this->$language($competitionId,$competitionLangId);
	}
	
	public function criteria($language='language1', $competitionId=0) {
		if($language != 'language2'){
			$language = 'language1';
		}
		$this->data['currentLang']=$language;
		if($language=='language1'){
			$this->criterialang1($competitionId);
		}else{
			$this->criterialang2($competitionId);
		}
		
	}
	
	public function prizes($language='language1', $competitionId=0) {
		if($language != 'language2'){
			$language = 'language1';
		}
		$this->data['currentLang']=$language;
		if($language=='language1'){
			$this->prizelang1($competitionId);
		}else{
			$this->prizelang2($competitionId);
		}
	}
	
	public function competitionMedia($language='language1', $competitionId=0) {
		if($language != 'language2'){
			$language = 'language1';
		}
		$this->data['currentLang']=$language;
		if($language=='language1'){
			$this->compMedialang1($competitionId);
		}else{
			$this->compMedialang2($competitionId);
		}
	}
	
	public function language1($competitionId=0,$competitionLangId=0) {
		$this->userId= $this->isLoginUser();
		if(!is_numeric($competitionId)){
			$competitionId=0;
		}
		$sectionId=$this->input->post('sectionId'); 
		
		$isMultilingual=false;
		$languageLink1='javascript:void(0);';
		$languageLink2='javascript:void(0);';
		$activeLang1 = 'orange';
		$activeLang2 = 'grey';
		
		$language1 = $this->lang->line('language1');
		$language2 = $this->lang->line('language2');
		
		$fileMaxSize = $this->config->item('defaultContainerSize');
		if($competitionId==0){
			$userContainerId=$this->lib_package->setUserContainerId($sectionId);
			$UserContainerData=$this->model_common->getDataFromTabel('UserContainer', 'containerSize',  array('userContainerId'=>$userContainerId,'tdsUid'=>$this->userId,'isExpired'=>'f'), '', '', '', 1);
			if($UserContainerData && isset($UserContainerData[0]->containerSize)){
				$fileMaxSize = $UserContainerData[0]->containerSize;
			}
			
		}else{
			if($competitionId > 0){
				$competitionData=$this->model_competition->getComptitionDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$this->userId));
				
				if($competitionData && isset($competitionData[0]->containerSize)){
					
					$this->competitionData=$competitionData=$competitionData[0];
					$competitionLangId = (isset($competitionData->competitionLangId) && is_numeric($competitionData->competitionLangId))?$competitionData->competitionLangId:0;
					$isMultilingual = (isset($competitionData->isMultilingual) && ($competitionData->isMultilingual == 't'))?true:false;
					$languageId1 = (isset($competitionData->languageId) && is_numeric($competitionData->languageId))?$competitionData->languageId:0;
					if($languageId1 > 0){
						$language1 = $competitionData->Language_local;
					}
					$languageId2 = (isset($competitionData->languageId2) && is_numeric($competitionData->languageId2))?$competitionData->languageId2:0;
					
					if($isMultilingual && ($languageId2 > 0)){
						$langRes=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId2,'', '', $limit=1 );
						if($langRes && isset($langRes[0]->Language_local)){
							$language2 = $langRes[0]->Language_local;
						}
					}
					
					$languageLink2=base_url(lang().'/competition/description/language2/'.$competitionId);
					$activeLang2 = 'dash_link_hover';
		
					
					$containerSize = $this->competitionData->containerSize;
					
					$dirname=$this->dirUpload.$competitionId;
					$dirSize=getFolderSize($dirname);
					$fileMaxSize =($containerSize - $dirSize);
					if(!$fileMaxSize > 0){
						$fileMaxSize =0;
					}
					
				}else{
					redirect('competition/competitionlist');
				}
			}else{
				redirect('competition/competitionlist');
			}
		}
		
		$this->data['isMultilingual']=$isMultilingual;
		$this->data['competitionLangId']=$competitionLangId;
		$this->data['languageLink1']=$languageLink1;
		$this->data['languageLink2']=$languageLink2;
		$this->data['activeLang1']=$activeLang1;
		$this->data['activeLang2']=$activeLang2;
		$this->data['language1']=$language1;
		$this->data['language2']=$language2;
		
		$this->data['competitionGroup'] = $this->model_common->getDataFromTabel('CompetitionGroup', 'competitionGroupId,title',  array('userId'=>$this->userId), '', 'title', 'ASC');
		
		$this->data['dirMedia']=$this->dirUpload;
		$this->data['dirUpload']=$this->dirUpload.$competitionId.'/';
		$this->data['fileMaxSize']=$fileMaxSize;
		$this->data['heading']='Description';
		$this->data['currentMathod']='description';
		$this->data['sectionId']=$sectionId;
		$this->data['entityId']=getMasterTableRecord('Competition');
		$this->data['competitionId']=$competitionId;
		$this->data['userId']=$this->userId;
		$this->data['competitionData']=$this->competitionData;
		$this->data['countryList'] = getCountryList();
		$this->data['header']=$this->load->view('backendTab',$this->data, true);
		
		
		$breadcrumbItem=array('competition','description','language1');
		$breadcrumbURL=array('competition/competitionlist','competition/description/language1/'.$competitionId,'competition/description/language1/'.$competitionId);
		
 
		$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
		$this->data['breadcrumbString']=$breadcrumbString;
		
		$leftView=$this->config->item('competitionHelpPage');
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','description',$this->data);
		
		//$this->template->load('template','description',$this->data);	
	}
	
	public function language2($competitionId=0,$competitionLangId=0) {
		$this->userId= $this->isLoginUser();
		
		if(!is_numeric($competitionId) || $competitionId==0){
			redirect('competition/competitionlist');
		}
		
		$isMultilingual=false;
		$language1 = $this->lang->line('language1');
		$language2 = $this->lang->line('language2');
		
		$competitionData=$this->model_competition->getComptitionLangDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$this->userId));
		if($competitionData){
			$competitionData=$competitionData[0];
			
			$isMultilingual = (isset($competitionData->isMultilingual) && ($competitionData->isMultilingual == 't'))?true:false;
			$languageId2 = (isset($competitionData->languageId) && is_numeric($competitionData->languageId))?$competitionData->languageId:0;
			if($languageId2 > 0){
				$language2 = $competitionData->Language_local;
			}
			$languageId1 = (isset($competitionData->languageId1) && is_numeric($competitionData->languageId1))?$competitionData->languageId1:0;
			
			if($isMultilingual && ($languageId1 > 0)){
				$langRes=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId1,'', '', $limit=1 );
				if($langRes && isset($langRes[0]->Language_local)){
					$language1 = $langRes[0]->Language_local;
				}
			}
			
			$competitionLangId = (isset($competitionData->competitionLangId) && is_numeric($competitionData->competitionLangId))?$competitionData->competitionLangId:0;
			if($competitionLangId==0 || !is_numeric($competitionLangId) ){
				$competitionData=false;
			}else{
				$this->competitionData=$competitionData;
			}
			
		}else{
			redirect('competition/competitionlist');
		}
		
	
		$this->data['isMultilingual']=$isMultilingual;
		$this->data['competitionLangId']=$competitionLangId;
		$this->data['languageLink1']= base_url(lang().'/competition/description/language1/'.$competitionId);
		$this->data['languageLink2']='javascript:void(0);';
		$this->data['activeLang1']= '';
		$this->data['activeLang2']= 'orange';
		$this->data['language1']=$language1;
		$this->data['language2']=$language2;
		
		$this->data['heading']='Description';
		$this->data['currentMathod']='description';
		$this->data['sectionId']=$this->config->item('competitionSectionId');
		$this->data['entityId']=getMasterTableRecord('Competition');
		$this->data['competitionId']=$competitionId;
		$this->data['userId']=$this->userId;
		$this->data['competitionData']=$this->competitionData;
		$this->data['header']=$this->load->view('backendTab',$this->data, true);
		
		$leftView=$this->config->item('competitionHelpPage');
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','description_language2',$this->data);
		
		//$this->template->load('template','description_language2',$this->data);	
	}
	
	public function criterialang1($competitionId=0) {
		$this->userId= $this->isLoginUser();
		
		if(!is_numeric($competitionId) || $competitionId==0){
			redirect('competition/competitionlist');
		}
		
		$isMultilingual=false;
		$language1 = $this->lang->line('language1');
		$language2 = $this->lang->line('language2');
	
		$competitionData=$this->model_competition->getComptitionDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$this->userId));
		if($competitionData){
			
			$this->competitionData=$competitionData=$competitionData[0];
			$competitionLangId = (isset($competitionData->competitionLangId) && is_numeric($competitionData->competitionLangId))?$competitionData->competitionLangId:0;
			$isMultilingual = (isset($competitionData->isMultilingual) && ($competitionData->isMultilingual == 't'))?true:false;
			
			if($competitionLangId > 0){
			
				$languageId1 = (isset($competitionData->languageId) && is_numeric($competitionData->languageId))?$competitionData->languageId:0;
				if($languageId1 > 0){
					$language1 = $competitionData->Language_local;
				}
				$languageId2 = (isset($competitionData->languageId2) && is_numeric($competitionData->languageId2))?$competitionData->languageId2:0;
				
				if($isMultilingual && ($languageId2 > 0)){
					$langRes=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId2,'', '', $limit=1 );
					if($langRes && isset($langRes[0]->Language_local)){
						$language2 = $langRes[0]->Language_local;
					}
				}
			}else{
				$isMultilingual = false;
			}
			
		
		}else{
			redirect('competition/competitionlist');
		}
		
		$this->data['continentWiseCountry'] = $this->model_common->getContinentWiseCountry();
		$this->data['isMultilingual']=$isMultilingual;
		$this->data['competitionLangId']=$competitionLangId;
		$this->data['languageLink1']='javascript:void(0);';
		$this->data['languageLink2']= base_url(lang().'/competition/criteria/language2/'.$competitionId);
		$this->data['activeLang1']= 'orange';
		$this->data['activeLang2']= '';
		$this->data['language1']=$language1;
		$this->data['language2']=$language2;
		
		$this->data['heading']='Criteria';
		$this->data['currentMathod']='criteria';
		$this->data['sectionId']=$this->config->item('competitionSectionId');
		$this->data['entityId']=getMasterTableRecord('Competition');
		$this->data['competitionId']=$competitionId;
		$this->data['userId']=$this->userId;
		$this->data['competitionData']=$this->competitionData;
		$this->data['header']=$this->load->view('backendTab',$this->data, true);
		
		$leftView=$this->config->item('competitionHelpPage');
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','criteria_from',$this->data);
		
		//$this->template->load('template','criteria_from',$this->data);	
	}
	
	public function criterialang2($competitionId=0) {
		$this->userId= $this->isLoginUser();
		
		if(!is_numeric($competitionId) || $competitionId==0){
			redirect('competition/competitionlist');
		}
		
		$isMultilingual=false;
		$language1 = $this->lang->line('language1');
		$language2 = $this->lang->line('language2');
		
		$competitionData=$this->model_competition->getComptitionLangDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$this->userId));
		if($competitionData){
			
			$this->competitionData=$competitionData=$competitionData[0];
			$competitionLangId = (isset($competitionData->competitionLangId) && is_numeric($competitionData->competitionLangId))?$competitionData->competitionLangId:0;
			$isMultilingual = (isset($competitionData->isMultilingual) && ($competitionData->isMultilingual == 't'))?true:false;
			
			if($competitionLangId > 0){
			
				$languageId2 = (isset($competitionData->languageId) && is_numeric($competitionData->languageId))?$competitionData->languageId:0;
				if($languageId2 > 0){
					$language2 = $competitionData->Language_local;
				}
				$languageId1 = (isset($competitionData->languageId1) && is_numeric($competitionData->languageId1))?$competitionData->languageId1:0;
				
				if($isMultilingual && ($languageId1 > 0)){
					$langRes=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId1,'', '', $limit=1 );
					if($langRes && isset($langRes[0]->Language_local)){
						$language1 = $langRes[0]->Language_local;
					}
				}
			}else{
				redirect('competition/criteria/language1/'.$competitionId);
			}
			
		
		}else{
			redirect('competition/competitionlist');
		}
		
		$this->data['isMultilingual']=$isMultilingual;
		$this->data['competitionLangId']=$competitionLangId;
		
		
		$this->data['languageLink1']= base_url(lang().'/competition/criteria/language1/'.$competitionId);
		$this->data['languageLink2']='javascript:void(0);';
		
		$this->data['activeLang1']= '';
		$this->data['activeLang2']= 'orange';
		$this->data['language1']=$language1;
		$this->data['language2']=$language2;
		
		$this->data['heading']='Criteria';
		$this->data['currentMathod']='criteria';
		$this->data['sectionId']=$this->config->item('competitionSectionId');
		$this->data['entityId']=getMasterTableRecord('Competition');
		$this->data['competitionId']=$competitionId;
		$this->data['userId']=$this->userId;
		$this->data['competitionData']=$this->competitionData;
		$this->data['header']=$this->load->view('backendTab',$this->data, true);
		
		$leftView=$this->config->item('competitionHelpPage');
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','criteria_from_lang2',$this->data);
		
		//$this->template->load('template','criteria_from_lang2',$this->data);	
	}
	
	public function prizelang1($competitionId=0) {
		
		$this->userId= $this->isLoginUser();
		
		if(!is_numeric($competitionId) || $competitionId==0){
			redirect('competition/competitionlist');
		}
		
		
		
		$isMultilingual=false;
		$language1 = $this->lang->line('language1');
		$language2 = $this->lang->line('language2');
		
		$competitionData=$this->model_competition->getComptitionLangDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$this->userId));
		if($competitionData){
			
			$competitionData=$competitionData[0];
			$competitionLangId = (isset($competitionData->competitionLangId) && is_numeric($competitionData->competitionLangId))?$competitionData->competitionLangId:0;
			$isMultilingual = (isset($competitionData->isMultilingual) && ($competitionData->isMultilingual == 't'))?true:false;
			
			$languageId1 = (isset($competitionData->languageId1) && is_numeric($competitionData->languageId1))?$competitionData->languageId1:0;
				
			if($isMultilingual && ($languageId1 > 0)){
				$langRes=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId1,'', '', $limit=1 );
				if($langRes && isset($langRes[0]->Language_local)){
					$language1 = $langRes[0]->Language_local;
				}
			}
			
			if($isMultilingual &&$competitionLangId > 0){
			
				$languageId2 = (isset($competitionData->languageId) && is_numeric($competitionData->languageId))?$competitionData->languageId:0;
				if($languageId2 > 0){
					$language2 = $competitionData->Language_local;
				}
				
			}else{
				$isMultilingual = false;
			}
			
		
		}else{
			redirect('competition/competitionlist');
		}
		
		$prizeData ='';
		
		$prizeData=$this->model_common->getDataFromTabel($table='CompetitionPrizes', $field='*',  array('competitionId'=>$competitionId), $whereValue='', $orderBy='order', $order='asc', '', $offset=0, $resultInArray=false  );		
		if($prizeData){
			$languageLink2=base_url(lang().'/competition/prizes/language2/'.$competitionId);
			$activeLang2='dash_link_hover';
		}else{
			$languageLink2='javascript:void(0);';
			$activeLang2='grey';
		}
			
		$userName=LoginUserDetails();
		
		if($this->input->post('submit') =='Save') {
			
			$prizesImg = '';
			if($this->input->post('fileName'))
			{
				$prizesImg = $this->dirUpload.$competitionId.'/'.$this->input->post('fileName');
			}
				
			$data=array(		
			'competitionId'     =>$this->input->post('competitionId'),							
			'title'             =>$this->input->post('title'),
			'tagwords'          =>$this->input->post('tagwords'),
			'onelineDescription'=>$this->input->post('onelineDescription'),
			'description'       =>$this->input->post('description'),
			'order'       =>$this->input->post('prizeOrder')		
			);
			if(!empty($prizesImg))
			{
				$data['image'] =  $prizesImg;
			}
			
		  $competitionId = $this->input->post('competitionId'); 		
		  $compPrizeId = $this->input->post('compPrizeId');		
		  $userName = $this->input->post('userName');		
		  $isEdit = $this->input->post('isEdit');
		  if($isEdit==0){
			$maxOrder=$this->model_common->getMax('CompetitionPrizes','order',array('competitionId'=>$competitionId));
			if($maxOrder && isset($maxOrder[0]->order) && ($maxOrder[0]->order > 0)){
				$data['order']=($maxOrder[0]->order + 1);
			}else{
				$data['order']=1;
			}
			 $this->model_competition->addCompetitionPrize($data);	
		  }else {
					if(!empty($prizesImg)) {
						$get_competition_data  = $this->model_common->getDataFromTabel('CompetitionPrizes', $field='image',  $whereField=array('compPrizeId'=>$compPrizeId), '', '', '',1);
						// delete all images with associated with thie prize id
						if($get_competition_data) {	
							$prizesImage = $get_competition_data[0]->image;
							if($prizesImage && strlen($prizesImage)>3 && is_file($prizesImage)){
							$fileInfo=pathinfo($prizesImage);
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
					}
					$this->model_common->editDataFromTabel('TDS_CompetitionPrizes', $data, 'compPrizeId',$compPrizeId);
				}
				  
			$prizeData=$this->model_common->getDataFromTabel($table='CompetitionPrizes', $field='*',  array('competitionId'=>$competitionId,'isBlocked'=>'f','isArchive'=>'f'), $whereValue='', $orderBy='', $order='', '', $offset=0, $resultInArray=false  );		
						
			$data['prizeData']=$prizeData;	  
			$data['userName']=$userName;	  
			return $this->load->view('prize_list',$data);	  
					  
		}	
							
		$this->data['isMultilingual']=$isMultilingual;
		$this->data['languageLink1']='javascript:void(0);';
		$this->data['languageLink2']=$languageLink2;
		$this->data['activeLang1']='orange';
		$this->data['activeLang2']=$activeLang2;
		$this->data['language1']=$language1;
		$this->data['language2']=$language2;
		
		$this->data['dirUpload']=$this->dirUpload.$competitionId;		
		$this->data['heading']='Prizes';
		$this->data['currentMathod']='prizes';
		
		$this->data['entityId']=getMasterTableRecord('Competition');
		$this->data['competitionId']=$competitionId;
		$this->data['prizeData']=$prizeData;
		$this->data['userName']=$userName;
		$this->data['header']=$this->load->view('backendTab',$this->data, true);
		
		$leftView=$this->config->item('competitionHelpPage');
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','prizes',$this->data);
		
		//$this->template->load('template','prizes',$this->data);	
	}
	
	public function prizelang2($competitionId=0) {
		
		$userId = $this->isLoginUser();
		$competitionId = (isset($competitionId) && ($competitionId>0)) ? $competitionId :$this->input->post('competitionId'); 
		
		if(!is_numeric($competitionId) || $competitionId==0){
			redirect('competition/competitionlist');
		}
		
		$isMultilingual=false;
		$language1 = $this->lang->line('language1');
		$language2 = $this->lang->line('language2');
		
		$competitionData=$this->model_competition->getComptitionLangDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$this->userId));
		if($competitionData){
			
			$competitionData=$competitionData[0];
			$competitionLangId = (isset($competitionData->competitionLangId) && is_numeric($competitionData->competitionLangId))?$competitionData->competitionLangId:0;
			$isMultilingual = (isset($competitionData->isMultilingual) && ($competitionData->isMultilingual == 't'))?true:false;
			
			if($isMultilingual &&$competitionLangId > 0){
			
				$languageId2 = (isset($competitionData->languageId) && is_numeric($competitionData->languageId))?$competitionData->languageId:0;
				if($languageId2 > 0){
					$language2 = $competitionData->Language_local;
				}
				
			}else{
				redirect('competition/prizes/language1/'.$competitionId);
			}
			
			$languageId1 = (isset($competitionData->languageId1) && is_numeric($competitionData->languageId1))?$competitionData->languageId1:0;
				
			if($isMultilingual && ($languageId1 > 0)){
				$langRes=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId1,'', '', $limit=1 );
				if($langRes && isset($langRes[0]->Language_local)){
					$language1 = $langRes[0]->Language_local;
				}
			}
		
		}else{
			redirect('competition/competitionlist');
		}
		$prizeData=$this->model_competition->getComptitionPrizeDetails(array('prize.competitionId'=>$competitionId));
		
		if($prizeData){
			$this->data['prizeLang1Data']=$prizeData;
		}else{
			redirect('competition/prizes/language1/'.$competitionId);
		}
		
		$this->data['isMultilingual']=$isMultilingual;
		$this->data['languageLink1']=base_url(lang().'/competition/prizes/language1/'.$competitionId);
		$this->data['languageLink2']='javascript:void(0);';
		$this->data['activeLang1']='';
		$this->data['activeLang2']='orange';
		$this->data['language1']=$language1;
		$this->data['language2']=$language2;
		
		$this->data['dirUpload']=$this->dirUpload.$competitionId;		
		$this->data['heading']='Prizes';
		$this->data['currentMathod']='prizes';
		
		$this->data['entityId']=getMasterTableRecord('Competition');
		$this->data['competitionId']=$competitionId;
		$this->data['prizeData']=$prizeData;
		$this->data['userName']=$userName;
		$this->data['header']=$this->load->view('backendTab',$this->data, true);
		
		$leftView=$this->config->item('competitionHelpPage');
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','prizes_lang',$this->data);
		
		//$this->template->load('template','prizes_lang',$this->data);
		
	}
	
	public function savePrizelang2() {
		
		$this->userId= $this->isLoginUser();
		$config = array(
              array(
                     'field'   => 'prizeLangId',
                     'label'   => 'prizeLangId',
                     'rules'   => 'trim|xss_clean'
                  ),
              array(
                     'field'   => 'compPrizeId',
                     'label'   => 'compPrizeId',
                     'rules'   => 'trim|xss_clean'
                  ),
              array(
                     'field'   => 'competitionId',
                     'label'   => 'competitionId',
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
                     'field'   => 'onelineDescription',
                     'label'   => 'One Line Description',
                     'rules'   => 'trim|xss_clean'
                  ),
			   array(
				 'field'   => 'description',
				 'label'   => 'Description',
				 'rules'   => 'trim|xss_clean'
			  )
			  ,
			   array(
				 'field'   => 'order',
				 'label'   => 'order',
				 'rules'   => 'trim|xss_clean'
			  )     
            );
		
		$this->form_validation->set_rules($config);
		
		if($this->input->post('submit')=='Save'  && $this->form_validation->run()){
			
			$competitionId=set_value('competitionId');
			$prizeLangId=set_value('prizeLangId');
			$compPrizeId=set_value('compPrizeId');
			$order=set_value('order');
			
			
			$competitionId=is_numeric($competitionId)?$competitionId:0;
			$compPrizeId=is_numeric($compPrizeId)?$compPrizeId:0;
			$prizeLangId=is_numeric($prizeLangId)?$prizeLangId:0;
			$order=is_numeric($order)?$order:0;
			
			
			
			
			if(is_numeric($competitionId) &&  ($competitionId > 0) && is_numeric($compPrizeId) &&  ($compPrizeId > 0) ){
				
				$countResult=$this->model_common->countResult('CompetitionPrizes',array('compPrizeId'=>$compPrizeId,'competitionId'=>$competitionId));
				
				if(is_numeric($countResult) && ($countResult > 0)){
				
					
					$dataCompetition = array(
						'compPrizeId' => $compPrizeId,
						'title' => pg_escape_string(set_value('title')),
						'tagwords' => pg_escape_string(set_value('tagwords')),
						'onelineDescription' => pg_escape_string(set_value('onelineDescription')),
						'description' => pg_escape_string(set_value('description')),
						'order' => $order,
						'modifyDate' => currntDateTime('Y-m-d h:i:s')
					);
					
					if(is_numeric($prizeLangId) &&  ($prizeLangId > 0)){
						$this->model_common->editDataFromTabel('CompetitionPrizeLang', $dataCompetition, array('prizeLangId'=>$prizeLangId,'compPrizeId'=>$compPrizeId));
						$msg=$this->lang->line('updatedCompetition');
					}else{
						$dataCompetition['createdDate'] = currntDateTime(); 
						$competitionLangId=$this->model_common->addDataIntoTabel('CompetitionPrizeLang', $dataCompetition);
						$msg=$this->lang->line('addedCompetitionLang');
					}
					set_global_messages($msg, $type='success', $is_multiple=true);
			
					/*$returnData=array('competitionId'=>$competitionId,'fileId'=>$com_sampleFileId,'uploadedFile'=>$uploadedFile);
					echo json_encode($returnData);
					*/
				}
			}
			redirect('competition/prizes/language2/'.$competitionId);
		}else{
			redirect('competition/competitionlist');
		}
		
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
                     'field'   => 'competitionGroupId',
                     'label'   => 'Competition GroupId',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'languageId',
                     'label'   => 'Language',
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
                     'field'   => 'onelineDescription',
                     'label'   => 'One Line Description',
                     'rules'   => 'trim|xss_clean'
                  ),    
                    
               array(
                     'field'   => 'submissionStartDate',
                     'label'   => 'submission Start Date',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'submissionEndDate',
                     'label'   => 'submission End Date',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'votingStartDate',
                     'label'   => 'voting Start Date',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'votingEndDate',
                     'label'   => 'voting End Date',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'submissionStartDateRound2',
                     'label'   => 'submission Start Date Round 2',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'submissionEndDateRound2',
                     'label'   => 'submission End Date Round 2',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'votingStartDateRound2',
                     'label'   => 'voting Start Date Round 2',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'votingEndDateRound2',
                     'label'   => 'voting End Date Round 2',
                     'rules'   => 'trim|xss_clean'
                  ), 
               array(
                     'field'   => 'Round2MaxEntries',
                     'label'   => 'Round 2 Max Entries',
                     'rules'   => 'trim|xss_clean'
                  ), 
               array(
                     'field'   => 'competitionRoundType',
                     'label'   => 'competition Round Type',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'isMultilingual',
                     'label'   => 'Multilinguage',
                     'rules'   => 'trim|xss_clean'
                  )
            );
		
		$this->form_validation->set_rules($config);
		
		if($this->input->post('submit')=='Save'  && $this->form_validation->run()){
			$saveMode='add';
			$sectionId=$this->input->post('sectionId');
			$competitionId=$this->input->post('competitionId');
			
			$browseId1st = $this->input->post('browseId1st');
			$com_coverImage='';
			
			if($competitionId && is_numeric($competitionId) &&  ($competitionId > 0) ){
				$competitionData=$this->model_competition->getComptitionDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$this->userId));
				
				if($competitionData && is_array($competitionData) && count($competitionData) > 0){
					$competitionData=$competitionData[0];
					$saveMode='edit';
					$com_coverImage=$competitionData->coverImage;
				}else{
					redirect('competition/');
				}
			}else{
				$saveMode='add';
				$competitionId=0; 
			}
			
			
			$submissionStartDate=set_value('submissionStartDate')==''?currntDateTime('Y-m-d h:i:s'):set_value('submissionStartDate');
			$submissionStartDate=date('Y-m-d',strtotime($submissionStartDate));
			
			$submissionEndDate=set_value('submissionEndDate')==''?currntDateTime('Y-m-d h:i:s'):set_value('submissionEndDate');
			$submissionEndDate=date('Y-m-d',strtotime($submissionEndDate));
			
			$votingStartDate=set_value('votingStartDate')==''?currntDateTime('Y-m-d h:i:s'):set_value('votingStartDate');
			$votingStartDate=date('Y-m-d',strtotime($votingStartDate));
			
			$votingEndDate=set_value('votingEndDate')==''?currntDateTime('Y-m-d h:i:s'):set_value('votingEndDate');
			$votingEndDate=date('Y-m-d',strtotime($votingEndDate));
			
			//-----------round 2 submission date section start----------------//
			
			if(set_value('competitionRoundType')==2){
			$submissionStartDateRound2=set_value('submissionStartDateRound2')==''?'':set_value('submissionStartDateRound2');
			$submissionStartDateRound2=date('Y-m-d',strtotime($submissionStartDateRound2));
			
			$submissionEndDateRound2=set_value('submissionEndDateRound2')==''?'':set_value('submissionEndDateRound2');
			$submissionEndDateRound2=date('Y-m-d',strtotime($submissionEndDateRound2));
			
			$votingStartDateRound2=set_value('votingStartDateRound2')==''?'':set_value('votingStartDateRound2');
			$votingStartDateRound2=date('Y-m-d',strtotime($votingStartDateRound2));
			
			$votingEndDateRound2=set_value('votingEndDateRound2')==''?'':set_value('votingEndDateRound2');
			$votingEndDateRound2=date('Y-m-d',strtotime($votingEndDateRound2));
			
			$Round2MaxEntries=set_value('Round2MaxEntries');
			$Round2MaxEntries=is_numeric($Round2MaxEntries)?$Round2MaxEntries:0;
			}else
			{
				$submissionStartDateRound2=NULL;
				$submissionEndDateRound2=NULL;
				$votingStartDateRound2=NULL;
				$votingEndDateRound2=NULL;
				$Round2MaxEntries=NULL;
			}
			
			
			$competitionRoundType=set_value('competitionRoundType');
			$isMultilingual=set_value('isMultilingual');
			$isMultilingual=($isMultilingual=='t')?'t':'f';
			
			//--------round 2 submission date section end------------------//
			
			
			
			$dataCompetition = array(
				'userId' => $this->userId,
				'title' => pg_escape_string(set_value('title')),
				'tagwords' => pg_escape_string(set_value('tagwords')),
				'onelineDescription' => pg_escape_string(set_value('onelineDescription')),
				'submissionStartDate' => $submissionStartDate,
				'submissionEndDate' => $submissionEndDate,
				'votingStartDate' => $votingStartDate,
				'votingEndDate' => $votingEndDate,
				'industryId' => set_value('industryId'),
				'competitionGroupId' => set_value('competitionGroupId'),
				'languageId' => set_value('languageId'),
				'prizeQuantity' => $this->config->item('competitionprizeQuantity'),
				'modifyDate' => currntDateTime('Y-m-d h:i:s'),
				'competitionRoundType' => $competitionRoundType,
				'Round2MaxEntries' => $Round2MaxEntries,
				'submissionStartDateRound2' => $submissionStartDateRound2,
				'submissionEndDateRound2' => $submissionEndDateRound2,
				'votingStartDateRound2' => $votingStartDateRound2,
				'votingEndDateRound2' => $votingEndDateRound2,
				'isMultilingual' => $isMultilingual
			);
			
			$editCompetition = array();
		
			
			if($saveMode=='add'){
				$dataCompetition['createdDate'] = currntDateTime(); 
				$userContainerId=$this->lib_package->getUserContainerId($sectionId);
				if($userContainerId && is_numeric($userContainerId) &&  ($userContainerId > 0) ){
					$dataCompetition['userContainerId']=$userContainerId;
				}else{
					redirect('competition/');
				}
				
				$competitionId=$this->model_common->addDataIntoTabel('Competition', $dataCompetition);
				$entityId=getMasterTableRecord('Competition');
				$this->lib_package->updateUserContainer($userContainerId,$entityId,$competitionId,$sectionId,$sectionId);
				$msg=$this->lang->line('addedCompetition');
			}
			
			
			$coverImage=$this->input->post('fileName'.$browseId1st);
			if($coverImage && strlen($coverImage)>3){
				$uploadedFile++;
				$editCompetition['coverImage']= $dataCompetition['coverImage']= $this->dirUpload.$competitionId.'/'.$coverImage;
				
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
			
			if($saveMode=='add' && $competitionId > 0 && is_array($editCompetition) && count($editCompetition) > 0){
				$this->model_common->editDataFromTabel('Competition', $editCompetition, array('competitionId'=>$competitionId));
			}
			
			if($saveMode=='edit'){
					$this->model_common->editDataFromTabel('Competition', $dataCompetition, array('competitionId'=>$competitionId));
					$msg=$this->lang->line('updatedCompetition');
			}
			
			set_global_messages($msg, $type='success', $is_multiple=true);
			
			addDataIntoLogSummary('Competition',$competitionId);
			$this->writeCompetitionCacheFile($competitionId);
			
			$returnData=array('competitionId'=>$competitionId,'fileId'=>$com_sampleFileId,'uploadedFile'=>$uploadedFile);
			echo json_encode($returnData);
			
			
		}
		else{
			redirect('competition/');
		}
	}
	
	public function saveCompetitionLang() {
		$this->userId= $this->isLoginUser();
		$config = array(
              array(
                     'field'   => 'competitionLangId',
                     'label'   => 'competitionLangId',
                     'rules'   => 'trim|xss_clean'
                  ),
              array(
                     'field'   => 'competitionId',
                     'label'   => 'competitionId',
                     'rules'   => 'trim|xss_clean'
                  ),
              array(
                     'field'   => 'languageId',
                     'label'   => 'Language',
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
                     'field'   => 'onelineDescription',
                     'label'   => 'One Line Description',
                     'rules'   => 'trim|xss_clean'
                  )    
            );
		
		$this->form_validation->set_rules($config);
		
		if($this->input->post('submit')=='Save'  && $this->form_validation->run()){
			
			$competitionId=set_value('competitionId');
			$competitionLangId=set_value('competitionLangId');
			$languageId=set_value('languageId');
			
			
			$whereCondition=array('comp.competitionId'=>$competitionId,'comp.userId'=>$this->userId);
			
			$languageId=is_numeric($languageId)?$languageId:0;
			$competitionLangId=is_numeric($competitionLangId)?$competitionLangId:0;
			if($competitionLangId > 0){
				$whereCondition['complang.competitionLangId']=$competitionLangId;
			}
			
			
			
			if($competitionId && is_numeric($competitionId) &&  ($competitionId > 0) ){
				$competitionData=$this->model_competition->getComptitionLangDetails($whereCondition);
				if($competitionData && is_array($competitionData) && count($competitionData) > 0){
					$competitionData=$competitionData[0];
					
					$dataCompetition = array(
						'competitionId' => $competitionId,
						'title' => pg_escape_string(set_value('title')),
						'tagwords' => pg_escape_string(set_value('tagwords')),
						'onelineDescription' => pg_escape_string(set_value('onelineDescription')),
						'languageId' => $languageId,
						'modifyDate' => currntDateTime('Y-m-d h:i:s')
					);
					
					$competitionLangId = (isset($competitionData->competitionLangId) && is_numeric($competitionData->competitionLangId))?$competitionData->competitionLangId:0;
					if(is_numeric($competitionLangId) &&  ($competitionLangId > 0)){
						$this->model_common->editDataFromTabel('CompetitionLang', $dataCompetition, array('competitionLangId'=>$competitionLangId));
						$msg=$this->lang->line('updatedCompetition');
					}else{
						$dataCompetition['createdDate'] = currntDateTime(); 
						$competitionLangId=$this->model_common->addDataIntoTabel('CompetitionLang', $dataCompetition);
						$msg=$this->lang->line('addedCompetitionLang');
					}
					set_global_messages($msg, $type='success', $is_multiple=true);
			
					/*$returnData=array('competitionId'=>$competitionId,'fileId'=>$com_sampleFileId,'uploadedFile'=>$uploadedFile);
					echo json_encode($returnData);
					*/
					redirect('competition/language2/'.$competitionId);
				}else{
					redirect('competition/');
				}
			}else{
				redirect('competition/competitionlist');
			}
			
		}
		else{
			redirect('competition/competitionlist');
		}
	}
	
	public function saveCompetitionCriteria() {
		$this->userId= $this->isLoginUser();
		$config = array(
              array(
                     'field'   => 'competitionId',
                     'label'   => 'competitionId',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'criteriaLang1Id',
                     'label'   => 'Language',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'criteriaLang2Id',
                     'label'   => 'Language',
                     'rules'   => 'trim|xss_clean'
                  ),  
               array(
                     'field'   => 'mediaType',
                     'label'   => 'Media to Submit',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'teritoryType',
                     'label'   => 'Teritory',
                     'rules'   => 'trim|xss_clean'
                  ),
                  array(
                     'field'   => 'competitionCountriesId',
                     'label'   => 'competitionCountriesId',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'votesCountriesId',
                     'label'   => 'votesCountriesId',
                     'rules'   => 'trim|xss_clean'
                  )   
				,
				array(
					'field'   => 'ageRestriction',
					'label'   => 'Age Restriction',
					'rules'   => 'trim|xss_clean'
				) 
				,
				array(
					'field'   => 'ageRequiresFrom',
					'label'   => 'Age Requires From',
					'rules'   => 'trim|xss_clean'
				) 
				,
				array(
					'field'   => 'ageRequiresTo',
					'label'   => 'Age Requires To',
					'rules'   => 'trim|xss_clean'
				) 
				,
				array(
					'field'   => 'rules',
					'label'   => 'rules',
					'rules'   => 'trim|xss_clean'
				) 
            );
		
		$this->form_validation->set_rules($config);
		
		if($this->input->post('submit')=='Save'  && $this->form_validation->run()){
			
			$competitionId=set_value('competitionId');
			if($competitionId && is_numeric($competitionId) &&  ($competitionId > 0) ){
				$teritoryType=$this->input->post('teritoryType');
				$voteTeritoryType=$this->input->post('voteTeritoryType');
				
				$competitionRoundType=set_value('competitionRoundType');
				
				$competitionCountries = ($teritoryType==0)?'':set_value('competitionCountriesId');
				$votesCountries = ($voteTeritoryType==0)?'':set_value('votesCountriesId');
				
				$ageRestriction=set_value('ageRestriction');
				$ageRestriction=($ageRestriction=='t')? 't' : 'f';
				
				$ageRequiresFrom=set_value('ageRequiresFrom');
				$ageRequiresFrom=is_numeric($ageRequiresFrom)?$ageRequiresFrom:0;
				
				$ageRequiresTo=set_value('ageRequiresTo');
				$ageRequiresTo=is_numeric($ageRequiresTo)?$ageRequiresTo:0;
				
				$dataCompetition = array(
					'criteriaLang1Id' => set_value('criteriaLang1Id'),
					'criteriaLang2Id' => set_value('criteriaLang2Id'),
					'mediaType' => set_value('mediaType'),
					'teritoryType' => $teritoryType,
					'voteTeritoryType' => $voteTeritoryType,
					'competitionCountries' => pg_escape_string($competitionCountries),
					'votesCountries' => pg_escape_string($votesCountries),
					'ageRestriction' => $ageRestriction,
					'ageRequiresFrom' => $ageRequiresFrom,
					'ageRequiresTo' => $ageRequiresTo,
					'rules' => pg_escape_string(set_value('rules')),
					'modifyDate' => currntDateTime('Y-m-d h:i:s')
					
				);
						
					$this->model_common->editDataFromTabel('Competition', $dataCompetition, array('competitionId'=>$competitionId,'userId'=>$this->userId));
					
					$msg=$this->lang->line('updatedCompetition');
					/*set_global_messages($msg, $type='success', $is_multiple=true);
					redirect('competition/language2/'.$competitionId);*/
			
					$returnData=array('competitionId'=>$competitionId,'msg'=>$msg);
					echo json_encode($returnData);
					
					
					
				
			}else{
				redirect('competition/competitionlist');
			}
			
		}
		else{
			redirect('competition/competitionlist');
		}
	}
	
	public function saveCompetitionCriteriaLang() {
		$this->userId= $this->isLoginUser();
		
		$config = array(
		  array(
				 'field'   => 'competitionId',
				 'label'   => 'competitionId',
				 'rules'   => 'trim|xss_clean'
			  ),
		   array(
				 'field'   => 'competitionLangId',
				 'label'   => 'competitionLangId',
				 'rules'   => 'trim|xss_clean'
			  ),
			array(
				'field'   => 'criteria',
				'label'   => 'criteria',
				'rules'   => 'trim|xss_clean'
			) 
		);
		
		$this->form_validation->set_rules($config);
		
		if($this->input->post('submit')=='Save'  && $this->form_validation->run()){
			
			$competitionId=set_value('competitionId');
			$competitionLangId=set_value('competitionLangId');
			
			if($competitionId && is_numeric($competitionId) &&  ($competitionId > 0) && $competitionLangId && is_numeric($competitionLangId) &&  ($competitionLangId > 0) ){
				
				
				$dataCompetition = array(
					'criteria' => pg_escape_string(set_value('criteria')),
					'modifyDate' => currntDateTime('Y-m-d h:i:s')
					
				);
						
				$this->model_common->editDataFromTabel('CompetitionLang', $dataCompetition, array('competitionLangId'=>$competitionLangId,'competitionId'=>$competitionId));
				
				$msg=$this->lang->line('updatedCompetition');
				/*set_global_messages($msg, $type='success', $is_multiple=true);
				redirect('competition/language2/'.$competitionId);*/
		
				$returnData=array('competitionId'=>$competitionId,'msg'=>$msg);
				echo json_encode($returnData);
				
			}else{
				redirect('competition/competitionlist');
			}
			
		}
		else{
			redirect('competition/');
		}
	}
	

	
	
	function writeCompetitionCacheFile($competitionId = 0){
		if(is_numeric($competitionId) && ($competitionId) > 0){
			$this->userId= $this->isLoginUser();
			$competitionData=$this->model_competition->getComptitionDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$this->userId));
			
			if($competitionData && is_array($competitionData) && count($competitionData) > 0){
				
				/*create cache file start */
					if(!is_dir($this->dirCache)){
						@mkdir($this->dirCache, 777, true);
					}
					$cmd3 = 'chmod -R 777 '.$this->dirCache;
					exec($cmd3);
					
					$cacheFile = $this->dirCache.'competition_'.$competitionId.'_'.$this->userId.'.php';
					$data=str_replace("'","&apos;",json_encode($competitionData));	//encode data in json format
					$stringData = '<?php $ProjectData=\''.$data.'\';?>';
					
					if (!write_file($cacheFile, $stringData)){	// write cache file
						echo 'Unable to write the file'; 
					}
				/*create cache file END */
				
				/*Update Search Table Start*/
					$entityId=getMasterTableRecord('Competition');
					$competitionData=$competitionData[0];
					$sectionId=$this->config->item('competitionSectionId');
					
					$createdDate=($competitionData->createdDate!='')?$competitionData->createdDate:currntDateTime();
				
					$searchDataInsert=array(
						"entityid"=>$entityId,
						"elementid"=>$competitionId,
						"projectid"=>$competitionId,
						"section"=>'competition',
						"sectionid"=>$sectionId,
						"ispublished"=>$competitionData->isPublished=='t'?'t':'f',
						"cachefile"=>$cacheFile,
						"item.title"=>pg_escape_string($competitionData->title), 
						"item.tagwords"=>pg_escape_string($competitionData->tagwords), 
						"item.online_desctiption"=>pg_escape_string($competitionData->onelineDescription),
						"item.userid"=>$this->userId, 
						"item.creative_name"=>LoginUserDetails('userFullName'), 
						"item.creative_area"=>LoginUserDetails('userArea'), 
						"item.languageid"=>$competitionData->criteriaLang1Id>0?$competitionData->criteriaLang1Id:0,  
						"item.language"=>pg_escape_string($competitionData->Language_local),
						"item.countryid"=>$competitionData->countryId>0?$competitionData->countryId:0, 
						"item.country"=>pg_escape_string($competitionData->countryName), 
						"item.sell_option"=>'paid',
						"item.industryid"=>$competitionData->industryId>0?$competitionData->industryId:0, 
						"item.industry"=>pg_escape_string($competitionData->IndustryName), 
						"item.creation_date"=>$createdDate
					);
					$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
				/*Update Search Table  END*/
				
			}
		}
	}
	
	/*
 	**************************************
 	*  This function is used to show home page of competition module
 	*************************************** 
 	*/ 
	
	public function entrydeleteditems($competitionEntryId=0) {
		$this->competitionentrylist($competitionEntryId,$isArchive='t');
	}
	
	function competitionentrylist($competitionEntryId=0,$isArchive='f'){
		$userId = $this->isLoginUser();
		
		$competitionEntryId= is_numeric($competitionEntryId)?$competitionEntryId:0;
		
		if($isArchive == 't'){
			$currentMethod='entrydeleteditems';
		}else{
			$isArchive = 'f';
			$currentMethod='competitionentrylist';
		}
		
		if($competitionEntryId > 0){
			$whereCondition = array('competitionEntryId'=>$competitionEntryId,'userId' => $userId,'isArchive' => $isArchive);
		}else{
			$whereCondition = array('userId' => $userId,'isArchive' => $isArchive);
		}
		
		
		
		$CompetitionEntry  = $this->model_common->getDataFromTabel('CompetitionEntry', 'competitionId,competitionEntryId',  $whereCondition, '', 'competitionEntryId', 'DESC', 1);
		
		
		if(isset($CompetitionEntry[0]->competitionEntryId)){
			$competitionEntryId = $CompetitionEntry[0]->competitionEntryId;
			// get competitionId 
			$competitionId = $CompetitionEntry[0]->competitionId;
			$whereCmpCondition = array('competitionId' => $competitionId);
			$CompetitionData  = $this->model_common->getDataFromTabel('Competition', 'competitionId,userId',  $whereCmpCondition, '', 'competitionId', 'DESC', 1);
			
			// competition data not exist then redirect 
			if(!($CompetitionData)){
				redirect('competition/');
			}
			
			$CompetitionData = $CompetitionData[0];
			$data['compUserId'] = $CompetitionData->userId;
		}
		else{
			if($competitionEntryId > 0){
				redirect('competition/'.$currentMethod);
			}else{
				$competitionEntryId = 0;
			}
		}
		
		if($competitionEntryId > 0){
			$competition_entry_details = $this->model_competition->competition_entry_list($userId,$competitionEntryId,$isArchive);
		}else{
			$competition_entry_details = false;
		}
		
		$data['entityId'] = getMasterTableRecord('Competition');
		$data['sectionId'] = $this->config->item('competitionEntrySectionId');
		$data['section'] = $section = 'competitionentry';
		$data['dirEntry'] = $this->dirEntry.$competitionEntryId;
		$data['userId'] = $userId;
		$data['competitionEntryId'] = $competitionEntryId;
		$data['entityId'] = getMasterTableRecord('CompetitionEntry');
		$data['isArchive'] = $isArchive;
		$data['currentMethod'] = $currentMethod;
		$data['competition_entry_details'] = $competition_entry_details['get_result'];
		$data['get_num_rows'] = $competition_entry_details['get_num_rows'];
		
		$breadcrumbItem[]='competitionentrylist';
		$breadcrumbURL[]='competition/competitionentrylist/';
		if($isArchive=='t'){
			$breadcrumbItem[]='entrydeleteditems';
			$breadcrumbURL[]='competition/entrydeleteditems/';
		}
 
		$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
		$data['breadcrumbString']=$breadcrumbString;
		
		$deleteCache=$section.'_'.$competitionEntryId.'_'.$userId;
		$refereshCashe=LoginUserDetails($deleteCache);
		if($refereshCashe==1){				
			$this->writeCompetitionEntryCacheFile($competitionEntryId);
		}
	
		$leftView=$this->config->item('competitionHelpPage');
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','competition_entry_list',$data);
		
		//$this->template->load('template','competition_entry_list', $data);
	}
	
  
	/*
 	**************************************
 	*  This new function is used to compition entry add
 	*************************************** 
 	*/ 
	
	
	function competitionentry($competitionId=0) { 
		$userId = $this->isLoginUser();
		$competitionId= is_numeric($competitionId)?$competitionId : 0;
		
		if( !($competitionId > 0)){
			redirect('competition/competitionlist');
		}
		
		$sectionId=$this->input->post('sectionId'); 
		$userContainerId=$this->lib_package->setUserContainerId($sectionId);
		
		$fileMaxSize = $this->config->item('defaultContainerSize');
		
		$getCompetitionData  = $this->model_competition->getComptitionCriteria(array('c.competitionId'=>$competitionId));
		
		if(!$getCompetitionData || empty($getCompetitionData))
		{
			redirect('competition/competitionlist');
		}
		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		
		
		$data['sectionId'] = $sectionId;
		$data['competitionId'] = $competitionId;
		$data['mediaPath'] = $this->dirEntry;
		$data['dirMedia'] = $this->dirEntry.$competitionId;
		$data['fileMaxSize'] = $fileMaxSize;
		//----------set file accepted type and max size--------//
		if(!empty($getCompetitionData) && isset($getCompetitionData))
		{
			$mediaType = $getCompetitionData[0]->mediaType;
		}
		switch($mediaType) {
			case 1:
				$data['mediaFileTypes'] = $this->config->item('imageAccept');	
				$data['fileLable'] = $this->lang->line('competition_dimensions');
			break;
			case 2:
				$data['mediaFileTypes'] = $this->config->item('videoAccept');	
				$data['fileLable'] = $this->lang->line('competition_duration');
			break;
			case 3:
				$data['mediaFileTypes'] = $this->config->item('audioAccept');	
				$data['fileLable'] = $this->lang->line('competition_length');
			break;
			case 4:
				$data['mediaFileTypes'] = $this->config->item('writtenMaterialAccept');	
				$data['fileLable'] = $this->lang->line('competition_wordcount');
			break;
			
		}
		
		$data['fileType'] = $mediaType;
		$data['competitionData'] = $getCompetitionData[0];
		
		$leftView=$this->config->item('competitionHelpPage');
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','competition_entry',$data);
		
		//$this->template->load('template','competition_entry', $data);
	}
	
	
	public function competitionentryedit($language='language1', $competitionEntryId=0) {
		
		$methodName = 'entryeditlanguage2';
		if($language != 'language2'){
			$language = 'language1';
			$methodName = 'entryeditlanguage1';
		}
	
		$this->$methodName($competitionEntryId,$language);
	}
	
	
	
	
	/*
 	**************************************
 	*  This new function is used to compition entry edit
 	*************************************** 
 	*/ 
	
	
	function entryeditlanguage1($competitionEntryId=0,$language)
	{ 
		$userId = $this->isLoginUser();
		$sectionId=$this->config->item('competitionEntrySectionId');
		
		$competitionEntryId=is_numeric($competitionEntryId)?$competitionEntryId:0;
		
		if($competitionEntryId==0){
			redirect('competition/competitionentrylist');
		}
		
		$competition_entry_data= $this->model_competition->competition_entry_list($userId,$competitionEntryId);
		
		if($competition_entry_data['get_num_rows'] == 0)
		{
			redirect('competition/competitionentrylist');
		}
		$competitionId=$competition_entry_data['get_result']->competitionId;
		
		
		$competitionId= is_numeric($competitionId)?$competitionId : 0;
		if( !($competitionId > 0)){
			redirect('competition/competitionlist');
		}
		
		//-----------set multilanguage start--------//
		
			
		$isMultilingual=false;
		$languageLink1='javascript:void(0);';
		$languageLink2='javascript:void(0);';
		$activeLang1 = 'orange';
		$activeLang2 = 'grey';
		
		$language1 = $this->lang->line('language1');
		$language2 = $this->lang->line('language2');
		
		$competitionData= $this->model_common->getDataFromTabel('Competition','*',  'competitionId', $competitionId,'', '', $limit=1 );
		/*	
		echo "<pre>";
		print_r($competitionData);die();
		*/	
		
		if($competitionData){
			$competitionData=$competitionData[0];
			$isMultilingual = (isset($competitionData->isMultilingual) && ($competitionData->isMultilingual == 't'))?true:false;
		}else{
			redirect('competition/competitionlist');
		}
			
		if($competition_entry_data){
			
			$competitionEntry=$competition_entry_data['get_result'];
			$languageId1 = (isset($competitionEntry->languageId) && is_numeric($competitionEntry->languageId))?$competitionEntry->languageId:0;
			if($languageId1 > 0){
				$langRes1=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId1,'', '', $limit=1 );
				if($langRes1 && isset($langRes1[0]->Language_local)){
					$language1 = $langRes1[0]->Language_local;
				}
			}
			
			$CompetitionEntryLang= $this->model_common->getDataFromTabel('CompetitionEntryLang','languageId',  'competitionEntryId', $competitionEntryId,'', '', $limit=1 );
			$CompetitionEntryLang = $CompetitionEntryLang[0];
			
			$languageId2 = (isset($CompetitionEntryLang->languageId) && is_numeric($CompetitionEntryLang->languageId))?$CompetitionEntryLang->languageId:0;
			
			if($isMultilingual && ($languageId2 > 0)){
				$langRes=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId2,'', '', $limit=1 );
				if($langRes && isset($langRes[0]->Language_local)){
					$language2 = $langRes[0]->Language_local;
				}
			}
			
			$languageLink2=base_url(lang().'/competition/competitionentryedit/language2/'.$competitionEntryId);
			$activeLang2 = 'dash_link_hover';
		}
		
		
		$data['isMultilingual']=$isMultilingual;
		$data['languageLink1']=$languageLink1;
		$data['languageLink2']=$languageLink2;
		$data['activeLang1']=$activeLang1;
		$data['activeLang2']=$activeLang2;
		$data['language1']=$language1;
		$data['language2']=$language2;
		
		//-----------set multilanguage end--------//
			
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		
		$supportingMaterialData=$this->model_competition->getCESupportingMaterail($competitionEntryId);
		
		$competitionData  = $this->model_competition->getComptitionCriteria(array('c.competitionId'=>$competitionId));
		if($competitionData && isset($competitionData[0])){
			$competitionData = $competitionData[0];
		}
		$data['competitionData'] = $competitionData;
		
		$get_competition_data = $competition_entry_data['get_result'];
		
		
		$data['currentLang']=$language;
		$data['sectionId'] = $sectionId;
		$data['competi_entry_data'] = $competition_entry_data;
		$data['mediaPath'] = $this->dirEntry;
		$data['dirMedia'] = $this->dirEntry.$competitionEntryId;
		$data['supportingMaterialData'] = $supportingMaterialData;
		$data['header']=$this->load->view('backendTab',$data, true);
			
		//----------set file accepted type and max size--------//
		if(!empty($get_competition_data) && isset($get_competition_data))
		{
			$data['fileType'] = $get_competition_data->mediaType;
			switch($data['fileType'])
			{
				case 1:
				$data['mediaFileTypes'] = $this->config->item('imageAccept');	
				$data['fileMaxSize'] = $this->config->item('image5MBSize');
				$data['fileLable'] = $this->lang->line('competition_dimensions');
				break;
				case 2:
				$data['mediaFileTypes'] = $this->config->item('videoAccept');	
				$data['fileMaxSize'] = $this->config->item('videoSize');
				$data['fileLable'] = $this->lang->line('competition_duration');
				break;
				case 3:
				$data['mediaFileTypes'] = $this->config->item('audioAccept');	
				$data['fileMaxSize'] = $this->config->item('audioSize');
				$data['fileLable'] = $this->lang->line('competition_length');
				break;
				case 4:
				$data['mediaFileTypes'] = $this->config->item('writtenMaterialAccept');	
				$data['fileMaxSize'] = $this->config->item('writtenMaterialSize');
				$data['fileLable'] = $this->lang->line('competition_wordcount');
				break;
				
			}
		}
		
		$leftView=$this->config->item('competitionHelpPage');
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','competition_entry',$data);
		
		//$this->template->load('template','competition_entry', $data);
	}
	
	
	
	
	/*
 	**************************************
 	*  This new function is used to compition entry edit
 	*************************************** 
 	*/ 
	
	
	function entryeditlanguage2($competitionEntryId=0,$language)
	{ 
		$userId = $this->isLoginUser();
		$sectionId=$this->config->item('competitionEntrySectionId');
		
		$competitionEntryId=is_numeric($competitionEntryId)?$competitionEntryId:0;
		
		if($competitionEntryId==0){
			redirect('competition/competitionentrylist');
		}
		
		$competition_entry_data= $this->model_competition->competition_entry_list($userId,$competitionEntryId);
		
		if($competition_entry_data['get_num_rows'] == 0)
		{
			redirect('competition/competitionentrylist');
		}
		$competitionId=$competition_entry_data['get_result']->competitionId;
		
		
		$competitionId= is_numeric($competitionId)?$competitionId : 0;
		if( !($competitionId > 0)){
			redirect('competition/competitionlist');
		}
		
		//-----------set multilanguage start--------//
		
			
		$isMultilingual=false;
		$languageLink1='javascript:void(0);';
		$languageLink2='javascript:void(0);';
		$activeLang1 = 'grey';
		$activeLang2 = 'orange';
		
		$language1 = $this->lang->line('language1');
		$language2 = $this->lang->line('language2');
		
		$competition_entry_lang2 = $this->model_common->getDataFromTabel('CompetitionEntryLang','*',  'competitionEntryId', $competitionEntryId,'', '', $limit=1 );
		$competitionData= $this->model_common->getDataFromTabel('Competition','*',  'competitionId', $competitionId,'', '', $limit=1 );
		
		
		
		if($competitionData){
			$competitionData=$competitionData[0];
			$isMultilingual = (isset($competitionData->isMultilingual) && ($competitionData->isMultilingual == 't'))?true:false;
		}else{
			redirect('competition/competitionlist');
		}
			
		if($competition_entry_data){
			
			$competitionEntry=$competition_entry_data['get_result'];
			$languageId1 = (isset($competitionEntry->languageId) && is_numeric($competitionEntry->languageId))?$competitionEntry->languageId:0;
			if($languageId1 > 0){
				$langRes1=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId1,'', '', $limit=1 );
				if($langRes1 && isset($langRes1[0]->Language_local)){
					$language1 = $langRes1[0]->Language_local;
				}
			}
			
			$CompetitionEntryLang= $this->model_common->getDataFromTabel('CompetitionEntryLang','languageId',  'competitionEntryId', $competitionEntryId,'', '', $limit=1 );
			$CompetitionEntryLang = $CompetitionEntryLang[0];
			
			$languageId2 = (isset($CompetitionEntryLang->languageId) && is_numeric($CompetitionEntryLang->languageId))?$CompetitionEntryLang->languageId:0;
			
			if($isMultilingual && ($languageId2 > 0)){
				$langRes=  $this->model_common->getDataFromTabel('MasterLang','Language,Language_local',  'langId', $languageId2,'', '', $limit=1 );
				if($langRes && isset($langRes[0]->Language_local)){
					$language2 = $langRes[0]->Language_local;
				}
			}
			
			$languageLink1=base_url(lang().'/competition/competitionentryedit/language1/'.$competitionEntryId);
			$activeLang1 = 'dash_link_hover';
		}
		
			
		
				
		$data['competitionEntryLang2']=$competition_entry_lang2;
		$data['isMultilingual']=$isMultilingual;
		$data['languageLink1']=$languageLink1;
		$data['languageLink2']=$languageLink2;
		$data['activeLang1']=$activeLang1;
		$data['activeLang2']=$activeLang2;
		$data['language1']=$language1;
		$data['language2']=$language2;
		$data['competitionEntryId']=$competitionEntryId;
		
		//-----------set multilanguage end--------//
			
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		
		$supportingMaterialData=$this->model_competition->getCESupportingMaterail($competitionEntryId);
		
		$competitionData  = $this->model_competition->getComptitionCriteria(array('c.competitionId'=>$competitionId));
		if($competitionData && isset($competitionData[0])){
			$competitionData = $competitionData[0];
		}
		$data['competitionData'] = $competitionData;
		
		$get_competition_data = $competition_entry_data['get_result'];
		
		
		$data['currentLang']=$language;
		$data['sectionId'] = $sectionId;
		$data['competi_entry_data'] = $competition_entry_data;
		$data['mediaPath'] = $this->dirEntry;
		$data['dirMedia'] = $this->dirEntry.$competitionEntryId;
		$data['supportingMaterialData'] = $supportingMaterialData;
		$data['header']=$this->load->view('backendTab',$data, true);
			
		//----------set file accepted type and max size--------//
		if(!empty($get_competition_data) && isset($get_competition_data))
		{
			$data['fileType'] = $get_competition_data->mediaType;
			switch($data['fileType'])
			{
				case 1:
				$data['mediaFileTypes'] = $this->config->item('imageAccept');	
				$data['fileMaxSize'] = $this->config->item('image5MBSize');
				$data['fileLable'] = $this->lang->line('competition_dimensions');
				break;
				case 2:
				$data['mediaFileTypes'] = $this->config->item('videoAccept');	
				$data['fileMaxSize'] = $this->config->item('videoSize');
				$data['fileLable'] = $this->lang->line('competition_duration');
				break;
				case 3:
				$data['mediaFileTypes'] = $this->config->item('audioAccept');	
				$data['fileMaxSize'] = $this->config->item('audioSize');
				$data['fileLable'] = $this->lang->line('competition_length');
				break;
				case 4:
				$data['mediaFileTypes'] = $this->config->item('writtenMaterialAccept');	
				$data['fileMaxSize'] = $this->config->item('writtenMaterialSize');
				$data['fileLable'] = $this->lang->line('competition_wordcount');
				break;
				
			}
		}
		
		$leftView=$this->config->item('competitionHelpPage');
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','competition_entry_lang2',$data);
		
		//$this->template->load('template','competition_entry_lang2', $data);
	}
	
	
	function entrylanginsertupdate(){
		
		$competitionEntryLangId=$this->input->post('competitionEntryLangId');
		$competitionEntryId=$this->input->post('competitionEntryId');
		$title=$this->input->post('title');
		$onelineDescription=$this->input->post('onelineDescription');
		$tagwords=$this->input->post('tagwords');
		$description=$this->input->post('description');
		$languageId=$this->input->post('languageId');
		
		$prepareData = array(
				'competitionEntryId' => $competitionEntryId,
				'title' => pg_escape_string($title),
				'onelineDescription' => pg_escape_string($onelineDescription),
				'tagwords' => pg_escape_string($tagwords),
				'description' => pg_escape_string($description),
				'languageId' => pg_escape_string($languageId),
				);
				
		// update competition entry language 2
		if($competitionEntryLangId >0){
			$competitionEntryId = $this->model_common->editDataFromTabel('CompetitionEntryLang', $prepareData, array('competitionEntryLangId'=>$competitionEntryLangId));
			$msg='Competition entry language2 updated';
		}else{
			// insert competition entry language 2
			$competitionEntryId = $this->model_common->addDataIntoTabel('CompetitionEntryLang', $prepareData);
			$msg='Competition entry language2 inserted';
		}
		set_global_messages($msg, $type='success');
		$returnData=array('message'=>$msg);
		echo json_encode($returnData);
	}
	
	
	/*
	 **************************************** 
	 *  This function is used to insert compitition entry
	 **************************************** 
	 */ 
	
	
	function competitionentryinsert(){
		
		
		$uploadedFile=0;
		$userId = $this->isLoginUser();
		$competitionId=$this->input->post('competitionId');
		if($this->input->post('submit')=='Save' && is_numeric($competitionId) > 0 && ($competitionId > 0)){
			$sectionId=$this->input->post('sectionId');
			$userContainerId=$this->lib_package->getUserContainerId($sectionId);
			$addUserContainerFlag=true;
			
			$browseId1st = $this->input->post('browseId1st');
			$browseId2nd = $this->input->post('browseId2nd');
			
			$title=$this->input->post('title');
			$onelineDescription=$this->input->post('onelineDescription');
			$tagwords=$this->input->post('tagwords');
			$description=$this->input->post('description');
			$languageId=$this->input->post('languageId');
			$ageCriteria=$this->input->post('ageCriteria');
			$countriesCriteria=$this->input->post('countriesCriteria');
			$entryRoundType=$this->input->post('competitionRoundType');
			$isMeetCriteria=$this->input->post('isMeetCriteria');
			$isMeetCriteria=($isMeetCriteria=='t')?'t':'f';
			
			$coverImage = ' ';
			$dataEntry = array(
				'userId' => $userId,
				'competitionId' => $competitionId,
				'title' => pg_escape_string($title),
				'onelineDescription' => pg_escape_string($onelineDescription),
				'tagwords' => pg_escape_string($tagwords),
				'description' => pg_escape_string($description),
				'languageId' => pg_escape_string($languageId),
				'ageCriteria' => pg_escape_string($ageCriteria),
				'countriesCriteria' => pg_escape_string($countriesCriteria),
				'isMeetCriteria' => $isMeetCriteria,
				'userContainerId' => $userContainerId,
				'entryRoundType' => $entryRoundType,
				'coverImage' => $coverImage
				
			);
			
			$competitionEntryId = $this->model_common->addDataIntoTabel('CompetitionEntry', $dataEntry);
			
			
			if($this->input->post('fileName'.$browseId1st))
			{
				$uploadedFile++;
				// update cover image data in competition entry table
				$dataEntry = array('coverImage' => $this->dirEntry.$competitionEntryId .'/'.$this->input->post('fileName'.$browseId1st));
				$this->model_common->editDataFromTabel('CompetitionEntry', $dataEntry, array('competitionEntryId'=>$competitionEntryId,'userId'=>$userId));		
			}
			
			$entityId=getMasterTableRecord('CompetitionEntry');
			
			if($addUserContainerFlag && $competitionEntryId > 0){
				$this->lib_package->addUserContainer($userContainerId,$entityId,$competitionEntryId,$sectionId,$sectionId,'CompetitionEntry','competitionEntryId');
			}
			//update usercontainer table
			//$this->lib_package->updateUserContainer($userContainerId,$entityId,$competitionEntryId,$sectionId,$sectionId);
			
			$isFile=false;
			$media_fileName=$this->input->post('fileName'.$browseId2nd);
			$isExternal=($this->input->post('isExternal'.$browseId2nd)=='t')?'t':'f';
			$embbededURL=$this->input->post('embbededURL'.$browseId2nd);
			$mediaFileData=array();
			if($media_fileName && strlen($media_fileName)>3){
				$uploadedFile++;
				$isFile=true;
				$fileType=getFileType($media_fileName);
				$mediaFileData=array(
										'filePath'=>$this->dirEntry.$competitionEntryId.'/',
										'fileName'=>$media_fileName,
										'fileType'=>$fileType,
										'tdsUid'=>$userId,
										'isExternal'=>'f',
										'fileSize'=>$this->input->post('fileSize'.$browseId2nd),
										'rawFileName'=>$this->input->post('fileInput'.$browseId2nd),
										'jobStsatus'=>'UPLOADING'
									);
				
			}elseif($isExternal == 't' && $embbededURL && strlen($embbededURL)>3){
				$isFile=true;
				$fileType=$this->input->post('fileType'.$browseId2nd);
				$embbededURL=getUrl($embbededURL);
				$mediaFileData=array(
										'filePath'=>$embbededURL,
										'tdsUid'=>$userId,
										'isExternal'=>'t',
									);
				
			}
			
			$editCompetitionEntry = array();
			
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
				
				$fileId=$this->manageCompetitionMediaFile(0,$mediaFileData);
				$editCompetitionEntry['fileId']=$fileId;
				
				if($isExternal=="f")
				{
					// update cover image data in competition entry table
					//	$mediaFileData = array('filePath' => $this->dirEntry.$competitionEntryId .'/'.$media_fileName);
					$mediaFileData = array('filePath' => $this->dirEntry.$competitionEntryId .'/');
					$this->manageCompetitionMediaFile($fileId,$mediaFileData,false);
				}	
				
			}else{
				$fileId=0;
			}
			
			if(is_array($editCompetitionEntry) && count($editCompetitionEntry) > 0){
				$this->model_common->editDataFromTabel('CompetitionEntry', $editCompetitionEntry, array('competitionEntryId'=>$competitionEntryId));
			}
			$msg=$this->lang->line('addedCompetitionEntery');
			set_global_messages($msg, $type='success', $is_multiple=true);
			
			addDataIntoLogSummary('CompetitionEntry',$competitionEntryId);
			$this->writeCompetitionEntryCacheFile($competitionEntryId);
			
			$returnData=array('competitionEntryId'=>$competitionEntryId,'fileId'=>$fileId,'uploadedFile' => $uploadedFile);
			echo json_encode($returnData);

		}
		
		
		
	}
	
	/*
	 **************************************** 
	 *  This function is used to update compitition entry data
	 **************************************** 
	 */ 
	
	
	function competitionentryupdate()
	{
		$uploadedFile=0;
		$userId = $this->isLoginUser();
		$competitionId=$this->input->post('competitionId');
		$competitionEntryId=$this->input->post('competitionEntryId');
		
		if($this->input->post('submit')=='Save' && $this->input->post('formAction')=='competitionDetails' && is_numeric($competitionEntryId) > 0 && ($competitionEntryId > 0)){
			
			
			$languageId=$this->input->post('languageId');
			$ageCriteria=$this->input->post('ageCriteria');
			$countriesCriteria=$this->input->post('countriesCriteria');
			
			$browseId1st = $this->input->post('browseId1st');
			$browseId2nd = $this->input->post('browseId2nd');
		
			$file= false;
			$fileId=0;
			$entryData=$this->model_competition->competition_entry_data($competitionId,$userId,$competitionEntryId);
			
			
			$entryData=$entryData['get_result'];
			
			if($entryData && (is_array($entryData) || is_object($entryData) ) && count($entryData) > 0){
			
				$fileId=$entryData->fileId;
				$fileType=$entryData->fileType;
				
				if($entryData->isExternal=='f' && is_dir($entryData->filePath) && $entryData->fileName !=''){
					$filePath=$entryData->filePath;
					$fpLen=strlen($filePath);
					if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
						$filePath=$filePath.DIRECTORY_SEPARATOR;
					}
					$fileName=$entryData->fileName;
					$file=array('filePath'=>$filePath,'fileName'=>$fileName);
				}
				
				$title=$this->input->post('title');
				$onelineDescription=$this->input->post('onelineDescription');
				$tagwords=$this->input->post('tagwords');
				$description=$this->input->post('description');
				$isMeetCriteria=$this->input->post('isMeetCriteria');
				$isMeetCriteria=($isMeetCriteria=='t')?'t':'f';
				$dataEntry = array(
					'userId' => $userId,
					'title' => pg_escape_string($title),
					'onelineDescription' => pg_escape_string($onelineDescription),
					'tagwords' => pg_escape_string($tagwords),
					'languageId' => pg_escape_string($languageId),
					'ageCriteria' => pg_escape_string($ageCriteria),
					'countriesCriteria' => pg_escape_string($countriesCriteria),
					'description' => pg_escape_string($description),
					'isMeetCriteria' => $isMeetCriteria,
					'modifyDate' => currntDateTime('Y-m-d h:i:s'),
					
				);
				
				if($this->input->post('fileName'.$browseId1st))
				{
						$uploadedFile++;
						// get old image name remove it
						$com_coverImage = $entryData->coverImage;
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
					// update cover image data in competition entry table
					$dataEntry = array('coverImage' => $this->dirEntry.$competitionEntryId .'/'.$this->input->post('fileName'.$browseId1st));
					$this->model_common->editDataFromTabel('CompetitionEntry', $dataEntry, array('competitionEntryId'=>$competitionEntryId,'userId'=>$userId));		
				}
				
				$isFile=false;
				$media_fileName=$this->input->post('fileName'.$browseId2nd);
				$isExternal=($this->input->post('isExternal'.$browseId2nd)=='t')?'t':'f';
				$embbededURL=$this->input->post('embbededURL'.$browseId2nd);
				$mediaFileData=array();
				if($media_fileName && strlen($media_fileName)>3){
					$isFile=true;
					$fileType=getFileType($media_fileName);
					$mediaFileData=array(
											'filePath'=>$this->dirEntry.$competitionEntryId.'/',
											'fileName'=>$media_fileName,
											'fileType'=>$fileType,
											'tdsUid'=>$userId,
											'isExternal'=>'f',
											'fileSize'=>$this->input->post('fileSize'.$browseId2nd),
											'rawFileName'=>$this->input->post('fileInput'.$browseId2nd),
											'jobStsatus'=>'UPLOADING'
										);
					
				}elseif($isExternal == 't' && $embbededURL && strlen($embbededURL)>3){
					$isFile=true;
					$fileType=$this->input->post('fileType'.$browseId2nd);
					$embbededURL=getUrl($embbededURL);
					$mediaFileData=array(
											'filePath'=>$embbededURL,
											'tdsUid'=>$userId,
											'isExternal'=>'t',
										);
					
				}
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
				
				$fileId=$this->manageCompetitionMediaFile($fileId,$mediaFileData,$file);
				$dataEntry['fileId']=$fileId;
			}
				
			$this->model_common->editDataFromTabel('CompetitionEntry', $dataEntry, array('competitionEntryId'=>$competitionEntryId,'userId'=>$userId));		
			
			$msg=$this->lang->line('updatedCompetitionEntery');
			set_global_messages($msg, $type='success', $is_multiple=true);
			
			addDataIntoLogSummary('CompetitionEntry',$competitionEntryId);
			$this->writeCompetitionEntryCacheFile($competitionEntryId);
			
			$returnData=array('competitionEntryId'=>$competitionEntryId,'fileId'=>$fileId,'uploadedFile'=>$uploadedFile);
			echo json_encode($returnData);

		}
		
		
		if($this->input->post('submit')=='Save' && $this->input->post('formAction')=='pieceUpload' && is_numeric($competitionEntryId) > 0 && ($competitionEntryId > 0)){
		
			//------------piece add section------------//
			if($this->input->post('pieceFormAction')=='pieceAdd') {
				//print_r($this->input->post());
				$fileTitle = $this->input->post('fileTitle');
				$pieceOrder = $this->input->post('pieceOrder');
				$browseId3rd = $this->input->post('browseId3rd');
				$insertData = array('competitionEntryId'=>$competitionEntryId,'title'=>$fileTitle,'fileOrder'=>$pieceOrder);
				$ceSupportingId = $this->model_common->addDataIntoTabel('CESupportingMaterial', $insertData);
				$isFile=false;
				$media_fileName=$this->input->post('fileName'.$browseId3rd);
				$isExternal=($this->input->post('isExternal'.$browseId3rd)=='t')?'t':'f';
				$embbededURL=$this->input->post('embbededURL'.$browseId3rd);
				$mediaFileData=array();
				if($media_fileName && strlen($media_fileName)>3){
					$uploadedFile++;
					$isFile=true;
					$fileType=getFileType($media_fileName);
					$mediaFileData=array(
											'filePath'=>$this->dirEntry.$competitionEntryId.'/',
											'fileName'=>$media_fileName,
											'fileType'=>$fileType,
											'tdsUid'=>$userId,
											'isExternal'=>'f',
											'fileSize'=>$this->input->post('fileSize'.$browseId3rd),
											'rawFileName'=>$this->input->post('fileInput'.$browseId3rd),
											'jobStsatus'=>'UPLOADING'
										);
					$fileId=$this->manageCompetitionMediaFile(0,$mediaFileData);					
				}
				$updateData = array('fileId'=>$fileId);
				$this->model_common->editDataFromTabel('CESupportingMaterial', $updateData, array('CESupportingMaterialid'=>$ceSupportingId));	
				$msg=$this->lang->line('updatedCompetitionEntery');
				set_global_messages($msg, $type='success', $is_multiple=true);
				$returnData=array('ceSupportingId'=>$ceSupportingId,'fileId'=>$fileId,'uploadedFile'=>$uploadedFile);
				echo json_encode($returnData);
			}
			//------------piece update section------------//
			if($this->input->post('pieceFormAction')=='pieceEdit') {
				$ceSupportingId = $this->input->post('ceSupportingId');
				$fileTitle = $this->input->post('fileTitle');
				$updateData = array('title'=>$fileTitle);
				$this->model_common->editDataFromTabel('CESupportingMaterial', $updateData, array('CESupportingMaterialid'=>$ceSupportingId));	
				$msg=$this->lang->line('updatedCompetitionEntery');
				set_global_messages($msg, $type='success', $is_multiple=true);
				$returnData=array('ceSupportingId'=>$ceSupportingId,'fileId'=>0,'uploadedFile'=>$uploadedFile);
				echo json_encode($returnData);
			}
		}
	}
	
	
	function writeCompetitionEntryCacheFile($competitionEntryId = 0){
		if(is_numeric($competitionEntryId) && ($competitionEntryId) > 0){
			$this->userId = $this->isLoginUser();
			$competitionEntry=$this->model_competition->competition_entry_list($this->userId,$competitionEntryId,'f');
			$competitionEntry=$competitionEntry['get_result'];
			
			
			
			if($competitionEntry && (is_array($competitionEntry) || is_object($competitionEntry)) && count($competitionEntry) > 0){
					
				/*create cache file start */
					if(!is_dir($this->dirCache)){
						@mkdir($this->dirCache, 777, true);
					}
					$cmd3 = 'chmod -R 777 '.$this->dirCache;
					exec($cmd3);
					
					$cacheFile = $this->dirCache.'competitionentry_'.$competitionEntryId.'_'.$this->userId.'.php';
					$data=str_replace("'","&apos;",json_encode($competitionEntry));	//encode data in json format
					$stringData = '<?php $ProjectData=\''.$data.'\';?>';
					
					if (!write_file($cacheFile, $stringData)){	// write cache file
						echo 'Unable to write the file'; 
					}
				
				/*create cache file END */
				
				/*Update Search Table Start*/
					$entityId=getMasterTableRecord('CompetitionEntry');
					$sectionId=$this->config->item('competitionSectionId');
					
					$createdDate=($competitionEntry->createdDate!='')?$competitionEntry->createdDate:currntDateTime();
				
					$searchDataInsert=array(
						"entityid"=>$entityId,
						"elementid"=>$competitionEntryId,
						"projectid"=>$competitionEntry->competitionId,
						"section"=>'competitionentry',
						"sectionid"=>$sectionId,
						"ispublished"=>$competitionEntry->isPublished=='t'?'t':'f',
						"cachefile"=>$cacheFile,
						"item.title"=>pg_escape_string($competitionEntry->title), 
						"item.tagwords"=>pg_escape_string($competitionEntry->tagwords), 
						"item.online_desctiption"=>pg_escape_string($competitionEntry->onelineDescription),
						"item.userid"=>$this->userId, 
						"item.creative_name"=>LoginUserDetails('userFullName'), 
						"item.creative_area"=>LoginUserDetails('userArea'), 
						"item.languageid"=>$competitionEntry->languageId>0?$competitionEntry->languageId:0,  
						"item.language"=>pg_escape_string($competitionEntry->Language_local),
						"item.countryid"=>$competitionEntry->countryId>0?$competitionEntry->countryId:0, 
						"item.country"=>pg_escape_string($competitionEntry->countryName), 
						"item.industryid"=>$competitionEntry->industryId>0?$competitionEntry->industryId:0, 
						"item.industry"=>pg_escape_string($competitionEntry->IndustryName), 
						"item.creation_date"=>$createdDate
					);
					$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
					
				/*Update Search Table  END*/
				
			}
		}
	}
	
	
		
	/* Delete Prize from Competition Prize table */	
	public function deleteCompetition($prizeId,$compId){	
	
	$get_competition_data  = $this->model_common->getDataFromTabel('CompetitionPrizes', $field='image',  $whereField=array('compPrizeId'=>$prizeId), '', '', '',1);
	
		// delete all images with associated with thie prize id
		if($get_competition_data)
		{	
				$prizesImage = $get_competition_data[0]->image;
				if($prizesImage && strlen($prizesImage)>3 && is_file($prizesImage)){
				$fileInfo=pathinfo($prizesImage);
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
	
	$this->model_common->deleteRowFromTabel('TDS_CompetitionPrizes','compPrizeId',$prizeId);
	$voteData=$this->model_common->getDataFromTabel($table='CompetitionPrizes', $field='*',  array('competitionId'=>$compId,'isBlocked'=>'f','isArchive'=>'f'), $whereValue='', $orderBy='', $order='', '', $offset=0, $resultInArray=false  );		
	$userName = $this->input->post('userName');
	$data['userName']=$userName; 
	$data['competitionId']=$compId; 
	$data['voteData']=$voteData;	  
	return $this->load->view('prize_list',$data);	
	}
  
  
  
	public function showCompetition(){
	 
	 $data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
	 $data['label']=$this->lang->language;	 
	
	$leftView=$this->config->item('competitionHelpPage');
	$data['leftContent']=$this->load->view($leftView,$leftData,true);
	$this->template->load('backend_template','test',$data);
		
	 //$this->template->load('template','test',$data);	 
	 
	} 
	
	
	
	
	/*
	 ************************************** 
	 *  This function is used to give vote to any competition entries
	 ************************************** 
	 */ 
	
	public function competitionentryvote() {
		$userId = $this->isLoginUser();
		$competitionId = $this->input->get('val1');	
		$competitionEntryId = $this->input->get('val2');	
		
		// check isUserId exist in competition
		$whereCondition = array('competitionId'=>$competitionId,'userId'=>$userId);
		$enteredCompetitionCount = $this->model_common->countResult('Competition', $whereCondition);
		if($enteredCompetitionCount > 0){
			$data['errorMsg'] = "You cannot vote your self competition.";
			$data['isError'] = true;
		}else {
			// check isUserId exist in competition entry
			$whereCondition = array('competitionEntryId'=>$competitionEntryId,'userId'=>$userId);
			$enteredCompetitionEntryCount = $this->model_common->countResult('CompetitionEntry', $whereCondition);
			if($enteredCompetitionEntryCount > 0){
				$data['errorMsg'] = "You cannot vote your self competition entry.";
				$data['isError'] = true;
			}else{
				// check is user already voted in this competition entries
				$whereCondition = array('competitionId'=>$competitionId,'userId'=>$userId);
				$getVotedCount = $this->model_common->countResult('CompetitionVote', $whereCondition);	
				if($getVotedCount  > 0){
					$data['errorMsg'] = "You have already voted for this competition.";
					$data['isError'] = true;
				}else
				{
					$data['errorMsg'] = 'You are about to vote for in this competition.';
					$data['isError'] = false;
				}
			}
		}
		$data['userId'] = $userId ;
		$data['competitionId'] = $competitionId;
		$data['competitionEntryId'] = $competitionEntryId;
		$this->load->view('competitionEntryVote',$data);
	}
	
	
	
	/*
	 ****************************** 
	 *  This function is used to insert competition vote
	 ****************************** 
	 */ 
	
	function competitionvoteinsert() {
		$userId = $this->input->post('userId');
		$competitionId = $this->input->post('competitionId');
		$competitionEntryId = $this->input->post('competitionEntryId');
		
		if($userId) {
			$round = competitionRound($competitionId);
			$voteData = array(
			'userId' => $userId,
			'round' => $round,
			'competitionId' => $competitionId,
			'competitionEntryId' => $competitionEntryId );
			$where = array(
			'userId' => $userId,
			'round' => $round,
			'competitionId' => $competitionId);
			$getVoteData=$this->model_common->getDataFromTabel('CompetitionVote', 'voteId',  $where, '', $orderBy='', '', 1 );
			if($getVoteData){
				$msg = "You have already voted for this competition.";
				$showMessage = array('msg'=>$msg,'countShow'=>0);
			}else{	
				$this->model_common->addDataIntoTabel('CompetitionVote', $voteData);
				//-------------update vote count------------//
				$where=array('competitionEntryId'=>$competitionEntryId);
				$res=$this->model_common->getDataFromTabel('CompetitionEntry', 'voteCount',  $where, '', $orderBy='', '', 1 );
				if($res){
					$res=$res[0];
					$voteCount = $res->voteCount+1;
					$updateData=array(
						'voteCount'=>$voteCount
					);
					$this->model_common->editDataFromTabel('CompetitionEntry', $updateData, 'competitionEntryId', $competitionEntryId);
				}
				$msg = "You have successfully vote for this competition.";
				$showMessage = array('msg'=>$msg,'countShow'=>1,'voteCount'=>$voteCount);
			}
		}else{
			$msg = "You have logged out.";
			$showMessage = array('msg'=>$msg,'countShow'=>0);
		}	
		echo json_encode($showMessage);
	}
	
	
	
	/*
	 ********************************** 
	 *  This function is used to shortlist and unshortlist
	 ********************************** 
	 */ 
	 
	public function shortlistNunshorlist()
	{
		
		$userId = $this->isLoginUser();
		$competitionId = $this->input->get('val1');	
		$competitionEntryId = $this->input->get('val2');	
		
		// check is user already voted in this competition entries
		$whereCondition = array('competitionId'=>$competitionId,'competitionEntryId'=>$competitionEntryId,'userId'=>$userId);
		$getShorlistData=$this->model_common->getDataFromTabel('CompetitionShortlist', 'shortlistId',  $whereCondition, '', $orderBy='', '', 1 );
		
		if($getShorlistData){
			$getShorlistData = $getShorlistData[0];
			$data['isShortlist'] = true;
			$data['shortlistId'] = $getShorlistData->shortlistId;
		}else
		{
			$data['isShortlist'] = false;
			$data['shortlistId'] = 0;
		}
		
		$data['userId'] = $userId ;
		$data['competitionId'] = $competitionId;
		$data['competitionEntryId'] = $competitionEntryId;
		$this->load->view('competitionShortlistNUnshortlist',$data);
	} 
	
	
	/*
	 ****************************** 
	 *  This function is used to insert shortlist and update sortlist count
	 ****************************** 
	 */ 
	
	function shorlistNunshortlistInsert() {
		$userId = $this->input->post('userId');
		$competitionId = $this->input->post('competitionId');
		$competitionEntryId = $this->input->post('competitionEntryId');
		if($userId) {
			$fieldData = array(
				'userId' => $userId,
				'competitionId' => $competitionId,
				'competitionEntryId' => $competitionEntryId );
			$getShorlistData=$this->model_common->getDataFromTabel('CompetitionShortlist', 'shortlistId',  $fieldData, '', $orderBy='', '', 1 );
			if($getShorlistData){
				$msg = "You have already shortlisted for this competition entries.";
				$showMessage = array('msg'=>$msg,'countShow'=>0);
			}else{	
				$this->model_common->addDataIntoTabel('CompetitionShortlist', $fieldData);
				//---------update sort list count--------//
				$where=array('competitionEntryId'=>$competitionEntryId);
				$res=$this->model_common->getDataFromTabel('CompetitionEntry', 'shortlistCount',  $where, '', $orderBy='', '', 1 );
				if($res){
					$res=$res[0];
					$shortlistCount = $res->shortlistCount+1;
					$updateData=array(
						'shortlistCount'=>$shortlistCount
					);
					$this->model_common->editDataFromTabel('CompetitionEntry', $updateData, 'competitionEntryId', $competitionEntryId);
				}
				$msg = "You have successfully shortlist for this competition entries.";
				$showMessage = array('msg'=>$msg,'countShow'=>1,'shortlistCount'=>$shortlistCount);
			}
		}else{
			$msg = "You have logged out.";
			$showMessage = array('msg'=>$msg,'countShow'=>0);
		}	
		
		echo json_encode($showMessage);
		
	}
	
	
	public function manageCompetitionMediaFile($fileId=0,$mediaFileData=array(),$File=false){
		if(is_numeric($fileId) && $fileId > 0){
			$this->model_common->editDataFromTabel('MediaFile', $mediaFileData, array('fileId'=>$fileId));
			if($File && is_array($File) && count($File) > 0){
				findFileNDelete($File['filePath'],$File['fileName']);
			}
		}else{
			$fileId=$this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);
		}
		return $fileId;
	}
	
	
	/*
	 *************************************
	 * This function is used to show competition by userId
	 ************************************* 
	 */  
	 
	function associatedcompetition($userId=0,$competitionId=0,$groupId=0){
		$get_all_competition_count = $this->model_competition->getUserCompetition($userId,$groupId);
		$competition_count =  count($get_all_competition_count);;
		$pages = new Pagination_ajax;
		$pages->items_total = $competition_count;
		$perPage = $this->config->item('competitionUserPerPage');
		
		// ADD by Amit to set cookie		
		$isSetCookie = setPerPageCookie('competitionEntryView',$perPage);		
		$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$isSetCookie;
		$pages->paginate();
		$this->data['perPageRecord'] = $pages->items_per_page;
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		$this->data['countTotal'] = $competition_count;
		$this->data['userId'] = $userId;
		$whereCondition = array('competitionGroupId' => $groupId);	
		$competitionGroupDetail  = $this->model_common->getDataFromTabel($table='CompetitionGroup', 'title,onelineDescription',  $whereCondition, '', $orderBy='order', $order='ASC', $limit=0, $offset=0, $resultInArray=false);
		// if entered group not exist then redirect
		if(empty($competitionGroupDetail)){
			redirect('competition');
		}
		$this->data['competitionGroupDetail']  = $competitionGroupDetail[0];
		$this->data['competition_array'] =$this->model_competition->getUserCompetition($userId,$groupId,$pages->offst,$pages->items_per_page);
	
		if($this->input->post()){
			$this->load->view('associatedcompetitionframe',$this->data);
		}else{
			$this->template_front_end->load('template_front_end','associatedcompetition',$this->data);
		}
	} 
	
	/*
	 ******************************** 
	 * This function is used to showcase prize list
	 ******************************** 
	 */ 
	
	function showcaseprizes($userId=0,$competitionId=0,$language='language1'){	
	
		if($competitionId==0)
			redirect('home');
		$userId=$userId>0?$userId:$this->userId;
		$latestComp = $this->model_competition->getDataByCompetitionId($userId,$competitionId);
		
		// if competition not exist then return to comeptition index page
		if(!($latestComp))
			redirect('competition');
		
		$whereCondition = array('competitionId' => $competitionId);	
		if($language=="language2"){
			$this->data['competitionPrizes']  = $this->model_competition->prizeListLanguage2($competitionId);
		}else{	
			$this->data['competitionPrizes']  = $this->model_common->getDataFromTabel($table='CompetitionPrizes', '*',  $whereCondition, '', $orderBy='order', $order='ASC', $limit=0, $offset=0, $resultInArray=false);
		}
		$this->data['competitionDetail']	= $latestComp[0];		
		$this->data['userId']				= $userId;	
		$this->data['competitionId']		= $competitionId;	
		$this->data['language']				= $language;	
		$this->template_front_end->load('template_front_end','showcaseprizes',$this->data);
	} 
	
	
	/*
	 *********************************
	 *  This function is used to show competition media listing section
	 *********************************
	 */ 
	 
	function sampleentry($userId=0,$competitionId=0,$language='language1'){
		
		if($competitionId==0)
			redirect('home');
		$userId=$userId>0?$userId:$this->userId;
		$competitionData  = $this->model_competition->getDataByCompetitionId($userId,$competitionId);
		
		// if competitionData data not exit then return to competition index page 
		if(!($competitionData))
			redirect('competition');
		
		$this->data['competitionData'] = $competitionData[0];
		
		//set media details by selected language
		if($language=='language2'){
			$this->data['competitionMediaData']	= $this->model_competition->comptitionMediaDetailsLang2($competitionId);
		}else{
			$this->data['competitionMediaData']	= $this->model_competition->getComptitionMediaDetails(array('media.competitionId'=>$competitionId));
		}
	
		$this->data['industryData']					= getIndustryClass($competitionData[0]->industryId);	
		
		/*
		echo "<pre>";
		print_r($this->data['competitionData']);die();*/
		
		$this->data['userId']					= $userId;	
		$this->data['competitionId']		= $competitionId;	
		$this->data['language']					= $language;		
		$this->template_front_end->load('template_front_end','showcasecompetitionmedia',$this->data);
	} 
	
	
	
	
	/**
	 *
	 *   This function is used to show competition entery details and media listing 
	 *   @param Integer $userId  set default value is  0 
	 *   @param Integer $competitionEntryId set default value is 0
	 *   @param Integer $language show default language is language1
	 * 
 	 */ 
	 
	function entriesmedia($userId=0,$competitionEntryId=0,$language='language1'){
		
		if($competitionEntryId==0)
			redirect('home');
		$userId=$userId>0?$userId:$this->userId;
		$competitionEntriesData  = $this->model_competition->getCompetitionEntriesData($userId,$competitionEntryId);
		
		// if competition entries data not exist then redirect to competition
		if(!($competitionEntriesData))
			redirect('competition');
		
		$this->data['competitionEntriesData']  = $competitionEntriesData;
		
		$this->data['CESupportingMaterial']  =$this->model_competition->getCESupportingMaterail($competitionEntryId);
		$reviewData = $this->model_competition->gerReviewData($competitionEntryId,$pages->offst,$pages->items_per_page);
		$reviewCount =  count($reviewData);;
		
		$pages = new Pagination_ajax;
		$pages->items_total = $reviewCount;
		$perPage = $this->config->item('competitionReviewlist');
		$isSetCookie = setPerPageCookie('reviewlist',$perPage);		
		$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$isSetCookie;
		$pages->paginate();
		$this->data['perPageRecord'] = $pages->items_per_page;
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		$this->data['countTotal'] = $reviewCount;
		
		$this->data['reviewData']  =$this->model_competition->gerReviewData($competitionEntryId,$pages->offst,$pages->items_per_page);
		$this->data['CESupportingMaterial']['4']['filePath'] = 'test';
		$this->data['userId']					= $userId;	
		$this->data['competitionEntryId']		= $competitionEntryId;	
		$this->data['language']		= $language;	
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')){
			//Set advert section id
			$advertSectionId = $this->config->item('competitionSectionId');				    
		
			//Get banner records based on section and advert type
			$bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
			$this->data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType4'=>$bannerType4,'sectionId'=>$advertSectionId),true);	
		}
		
		$ajaxRequest = $this->input->post('ajaxRequest');
		if($ajaxRequest){
			$this->data['ajaxRequest']=true;
			$this->load->view('reviewList',$this->data) ;
		}			   
		else{
			$this->template_front_end->load('template_front_end','showcasecompetitionentriesmedia',$this->data);
		}
	}
	
	
	
	/*
	 **************************************
	 * This function is used to show  
	 ************************************** 
	 */   
	
	function showcaseentries($userId=0,$competitionId=0,$roundType='1') {

		$userId=$userId>0?$userId:$this->userId;
		$competitionDetail 	= $this->model_competition->getCompetitionDetail($userId,$competitionId);
		if(empty($competitionDetail)){
			redirect('competition');
		}
		$competitionDetail = $competitionDetail[0];
				
		
		//--------------competition round1 & round2 vote date details--------------//
		 
		$currentDate = strtotime(date("Y-m-d"));
		$createdDate = strtotime($competitionDetail->createdDate);
		$votingStartDate = strtotime($competitionDetail->votingStartDate);
		$votingEndDate = strtotime($competitionDetail->votingEndDate);
		if($roundType==2){
			if($votingEndDate <= $currentDate){
				$votingStartDate = strtotime($competitionDetail->votingStartDateRound2);
				$votingEndDate = strtotime($competitionDetail->votingEndDateRound2);
			}
		}
		
		 if($votingEndDate >= $currentDate ){
			$isShowResult=false;
		}else{
			$isShowResult=true;
		}
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')){
			
			//Set advert section id
			$advertSectionId = $this->config->item('competitionSectionId');				    
		
			//Get banner records based on section and advert type
			$bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
			$this->data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType4'=>$bannerType4,'sectionId'=>$advertSectionId),true);	
		}
		
		//--------------competition round1 & round2 vote date details--------------//	
				
				
		$this->data['showcaseEntriesData']  = $this->model_competition->getShowcaseEntries($competitionId,$roundType,$isShowResult);
		
		$this->data['competitionDetail'] 	= $competitionDetail;
		
		$this->data['userId']					= $userId;	
		$this->data['competitionId']			= $competitionId;	
		$this->data['roundType']			= $roundType;	
		$this->template_front_end->load('template_front_end','showcaseentries',$this->data);
	} 
	 
	 
	
	/*
	 ************************ 
	 * This function is used to listing of shortlist entry list by competition id
	 ************************ 
	 */ 
	
	
	public function shortlist($competitionId=0){
		$userId=$this->isloginUser();
		
		$shortListData = $this->model_competition->getCompetitionShortData($userId,$competitionId);
	
		$shortListCount =  count($shortListData);;
		
		$pages = new Pagination_ajax;
		$pages->items_total = $shortListCount;
		$perPage = $this->config->item('competitionShortlist');
		
		$isSetCookie = setPerPageCookie('shortlist',$perPage);		
		$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$isSetCookie;
		$pages->paginate();
		$this->data['perPageRecord'] = $pages->items_per_page;
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		$this->data['countTotal'] = $shortListCount;
		
		$shortListData = $this->model_competition->getCompetitionShortData($userId,$competitionId,$pages->offst,$pages->items_per_page);
		$competitionData = $this->model_competition->getCompetitionData($userId);
		$this->data['activeheading']= 'Competition Shortlist';	
		$this->data['myCraves']= 'My Craves';
		$this->data['shortListData']=$shortListData;
		$this->data['competitionData']=$competitionData;
		$this->data['heading']='Competition Shortlist';
		$this->data['currentMathod']='competitionShortList';
		$this->data['userId']=$userId;
		$ajaxRequest = $this->input->post('ajaxRequest');
		if($ajaxRequest){
			$this->data['ajaxRequest']=true;
			 $this->load->view('shortlist_listing',$this->data) ;
		}			   
		else{
			$this->data['ajaxRequest']=false;
			
			$leftView=$this->config->item('competitionHelpPage');
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			$this->template->load('backend_template','shortList',$this->data);
	
			//$this->template->load('template','shortList',$this->data);	   //load template with media view
		}
	}
	 
	
	
}
