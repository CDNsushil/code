<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	 Description:
	 * The controller class "Dashboard" is meant to handle the processing of "Work Profile" section
	 * It include functionality to fetch/add/edit work address,sicaol media links,employment history,etc
	 *
	 * @package	Toadsquare
	 * @subpackage	Module
	 * @category	Controller
	 * Author Name: Sushil Mishra
	 * Date Created: 3 january 2013
*/

class dashboard extends MX_Controller {
	private $data = array();
	private $data1 = array();
	private $userId = null;
	private $dirUploadMedia = '';

	private $userContactsTable = 'UserContacts';

	function __construct(){
		$load = array(
					'model'		=> 'dashboard/model_dashboard + messagecenter/model_message_center ',
					'library' 	=> 'dashboard/lib_dashboard + messagecenter/lib_message_center',	 	
					'language' 	=> 'dashboard + tank_auth'
				);
				
		parent::__construct($load);	
		$this->userId=$this->isLoginUser();
		$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/'; 
				
	}
	public function index() {	
		$this->showcase();		
	}
	public function showcase($container='') {	
		
		$enterprise = LoginUserDetails('enterprise');
		$creative =  LoginUserDetails('creative');
		$associatedProfessional =  LoginUserDetails('associatedProfessional');
		
		$sectionId=($enterprise=='t')?$this->config->item('enterprisesSectionId'):($associatedProfessional=='t'?$this->config->item('associateprofessionalSectionId'):$this->config->item('creativesSectionId'));

		$this->data['sectionId']=$sectionId;
		$this->data['smSelected']='selected';
		$this->data['welcomePage']='welcome_showcase';
		$this->data['welcomeHeading']=$this->lang->line('welcomeShowcaseLH');
		$this->data['section']=$this->lang->line('showcaseHomepage');
		$this->data['usedSection']=$this->lang->line('showcaseHomepage');
		$this->data['noAvailablesection']=$this->lang->line('multilingualShowcase');
		$this->data['sectionImage']='members_xs.jpg';
		$this->data['noAvailableImage']='Multilingual-Showcase_110x73.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'showcase/';
		$this->data['formSubmitUrl']=base_url(lang().'/showcase/showcaseForm');
		$this->data['AdministrationSectionLink']=base_url(lang().'/showcase/showcaseForm/');
		$this->data['showcase_section']=$this->lang->line('showcaseHomepage');
		$this->data['administration_section']=$this->lang->line('showcaseAdmin');
		$this->data['edit_dashboard_link']=base_url(lang().'/showcase/showcaseForm');
		$this->data['edit_dashboard_type']= 'showcase_dashboard';
		$this->data['containerType']='freeContainer';
		//$this->data['containerType']='availableContainer';
		$this->data['containermultiType']='multilangualContainer';
		$this->data['submitButton']=$this->lang->line('create');
		//Set index circle data
		$this->data['indexPageData'] = $this->sectionIndexPages('showcase');
		//Set help page of showcase
		$this->data['helpPage'] = 'help_showcase';
		//Get users showcase details
		$showcaseRes = getUserShowcaseId($this->userId);
		//Set showcase view/preview link
		if(isset($showcaseRes->isPublished) && $showcaseRes->isPublished=='t') {
			$this->data['showcaseSectionLink']=base_url(lang().'/showcase/aboutme/'.$this->userId);
			$this->data['viewLabel'] = $this->lang->line('view');
		} else {
			$this->data['showcaseSectionLink']=base_url(lang().'/showcase/preview/'.$this->userId);
			$this->data['viewLabel'] = $this->lang->line('preview');
		}
		$userShowcaseId = isset($showcaseRes->showcaseId)?$showcaseRes->showcaseId:0;
		//Get multilangual showcase values
		$userShowcaseLang = $this->model_dashboard->getUserShowcaseLanguage($userShowcaseId);
		$this->data['countMeetingPoint']= $this->model_dashboard->getMettingPoint($this->userId);
		$this->data['workApplicationsSentCount']= $this->model_dashboard->getWorkAppliedFor($this->userId);
		$this->data['workApplicationsReceivedCount']= $this->model_dashboard->getWorkAppReceived($this->userId);
		
		if(isset($userShowcaseLang) && !empty($userShowcaseLang)){
			$this->data['userShowcaseMultiLang'] = $userShowcaseLang;
		}else{
			$this->data['userShowcaseMultiLang'] = '';
		}
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 )))){
			//$this->multilangualCollection();
			$this->getContainers();
		}else{
			//$this->loadPage('welcome_showcase');
			$this->loadWelcomePage('welcome_showcase');
		}
	}
	public function workprofile($container='') {	
		$sectionId=$this->config->item('workprofileSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['wpSelected']='selected';
		$this->data['welcomePage']='welcome_workprofile';
		$this->data['welcomeHeading']=$this->lang->line('welcomeWorkProfileLH');
		$this->data['section']=$this->lang->line('workprofile');
		$this->data['noAvailablesection']=$this->lang->line('workprofile');
		$this->data['usedSection']=$this->lang->line('workprofile');
		$this->data['sectionImage']='Work-Profile_110x73.jpg';
		$this->data['noAvailableImage']='Work-Profile_110x73.jpg';
		$this->data['hideNoAvailable']=true;
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'workProfile/';
		$this->data['formSubmitUrl']=base_url(lang().'/workprofile/workProfileForm');
		$this->data['showcaseSectionLink']=base_url(lang().'/showcase/aboutme/'.$this->userId);
		$this->data['AdministrationSectionLink']=base_url(lang().'/workprofile/index/');
		$this->data['previewSectionLink']=base_url(lang().'/workprofilefrontend');
		$this->data['showcase_section']=$this->lang->line('workProfile');
		$this->data['administration_section']=$this->lang->line('workProfileAdmin');
		$this->data['edit_dashboard_link']=base_url(lang().'/workprofile/workProfileForm');
		$this->data['submitButton']=$this->lang->line('newProfile');
		//$this->data['containerType']='freeContainer';
		$this->data['containerType']='newFreeContainer';
		$this->data['indexPageData'] = $this->sectionIndexPages('workprofile');
		$this->data['helpPage'] = 'help_workprofile';
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'workprofile', $userNavigations, $key='section', $is_object=0 )))){ 
			$this->getContainers();
		}else{ 
			//$this->loadPage('welcome_workprofile');
			$this->loadWelcomePage('welcome_workprofile');
			
		}
	}
	public function upcoming($container='') {	
		$sectionId=$this->config->item('upcomingSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['ucSelected']='selected';
		$this->data['welcomePage']='welcome_upcoming';
		$this->data['welcomeHeading']=$this->lang->line('welcomeUpcomingLH');
		$this->data['section']=$this->lang->line('upcoming');
		$this->data['noAvailablesection']=$this->lang->line('upcoming');
		$this->data['usedSection']=$this->lang->line('upcoming');
		$this->data['sectionImage']='Upcoming_110x73.jpg';
		$this->data['noAvailableImage']='Upcoming_110x73.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'upcomingProjects/';
		$this->data['formSubmitUrl']=base_url(lang().'/upcomingprojects/newupcomingprojects');
		$this->data['showcaseSectionLink']=base_url(lang().'/upcomingfrontend/upcoming/'.$this->userId);
		$this->data['previewSectionLink']=base_url(lang().'/upcomingfrontend/preview/'.$this->userId);
		
		$this->data['AdministrationSectionLink']=base_url(lang().'/upcomingprojects/index/');
		$this->data['showcase_section']=$this->lang->line('upcomingShowcase');
		$this->data['administration_section']=$this->lang->line('upcomingIndexPage');
		$this->data['edit_dashboard_link']=base_url(lang().'/upcomingprojects/newupcomingprojects');
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['indexPageData'] = $this->sectionIndexPages('upcomingprojects');
		$this->data['helpPage'] = 'help_upcoming';
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'upcoming', $userNavigations, $key='section', $is_object=0 )))){ 
			$this->getContainers();
		}else{ 
			//$this->loadPage('welcome_upcoming');
			$this->loadWelcomePage('welcome_upcoming');
		}
	}
	public function blog($container='') {	
		$sectionId=$this->config->item('blogsSectionId');
		
		$this->data['sectionId']=$sectionId;
		$this->data['blogSelected']='selected';
		$this->data['welcomePage']='welcome_blog';
		$this->data['welcomeHeading']=$this->lang->line('welcomeBlogLH');
		$this->data['section']=$this->lang->line('blog');
		$this->data['usedSection']=$this->lang->line('blog');
		$this->data['noAvailablesection']=$this->lang->line('blog');
		$this->data['sectionImage']='Blog_110x73.jpg';
		$this->data['noAvailableImage']='Blog_110x73.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'blog/';
		$this->data['formSubmitUrl']=base_url(lang().'/blog/blogForm');
		$this->data['AdministrationSectionLink']=base_url(lang().'/blog/index/');
		$this->data['showcase_section']=$this->lang->line('titleShowcase');
		$this->data['administration_section']=$this->lang->line('titleIndexPage');
		$this->data['edit_dashboard_link']=base_url(lang().'/blog/index/');
		//$this->data['containerType']='freeContainer';
		//$this->data['containerType']='newFreeContainer';
		$this->data['submitButton']=$this->lang->line('setUpBlog');
		$this->data['submitBtnclass']='orange gray_clr_hover';
		$this->data['newElementUrl']=base_url(lang().'/blog/postForm/');
		$this->data['indexPageData'] = $this->sectionIndexPages('blog');
		$this->data['countElementResult'] = countResult('Posts',array('custId'=>$this->userId,'postArchived'=>'f'));
		$this->data['elementCountLabel'] = $this->lang->line('posts');
		$this->data['helpPage'] = 'help_blog';
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'blog', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'post', $userNavigations, $key='section', $is_object=0 )))){ 
			$this->data['containers']=$this->getUserContainer($this->userId,$sectionId);
			$containers = $this->data['containers'];
			if(isset($containers[0]->entityId) && isset($containers[0]->elementId) && $containers[0]->entityId>0 && $containers[0]->elementId>0) {
				$whereField = array('entityid'=>$containers[0]->entityId,
							'elementid'=>$containers[0]->elementId,
						  );
				$elementResult = $this->model_common->getDataFromTabel('search','ispublished',$whereField,'');
				$this->data['isProjectPublished'] = $elementResult[0]->ispublished;
				$this->data['submitButton']=$this->lang->line('newContainerPost');
				if(isset($elementResult[0]->ispublished) && $elementResult[0]->ispublished=='t') {
					$this->data['showcaseSectionLink']=base_url(lang().'/blogshowcase/index/'.$this->userId);
					$this->data['viewLabel'] = $this->lang->line('view');
				}else{
					$this->data['showcaseSectionLink']=base_url(lang().'/blogshowcase/preview/'.$this->userId.'/'.$containers[0]->elementId.'/frontblog');
					$this->data['viewLabel'] = $this->lang->line('preview');
				}
			}
			$this->data['lifeTimeFreeContainer']=$this->load->view('newsReviewsContainer',$this->data, true);
			$this->getContainers();
			//$this->loadPage('container');
		}else{
			//$this->loadPage('welcome_blog');
			$this->loadWelcomePage('welcome_blog');
		}
	}
	public function filmNvideo($container='') {	
		$sectionId=$this->config->item('filmnvideoSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['fvSelected']='selected';
		$this->data['welcomePage']='welcome_filmvideo';
		$this->data['welcomeHeading']=$this->lang->line('welcomeFilmVideoLH');
		$this->data['section']=$this->lang->line('media');
		$this->data['noAvailablesection']=$this->lang->line('media');
		$this->data['usedSection']=$this->lang->line('filmNvideo');
		$this->data['sectionImage']='Media1_110x73.jpg';
		$this->data['noAvailableImage']='Media1_110x73.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'project/filmNvideo/';
		$this->data['formSubmitUrl']=base_url(lang().'/media/filmNvideo/newProject/projectDescription');
		$this->data['showcaseSectionLink']=base_url(lang().'/mediafrontend/filmvideo/'.$this->userId);
		$this->data['AdministrationSectionLink']=base_url(lang().'/media/filmNvideo/');
		$this->data['showcase_section']=$this->lang->line('titleShowcase');
		$this->data['administration_section']=$this->lang->line('titleIndexPage');
		$this->data['edit_dashboard_link']=base_url(lang().'/media/filmNvideo/editProject/projectDescription/');
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['mediaSection']='filmvideo';
		$this->data['mediaAddSection']='filmNvideo';
		$this->data['indexPageData'] = $this->sectionIndexPages('filmNvideo');
		$this->data['helpPage'] = 'help_filmvideo';
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'filmNvideo', $userNavigations, $key='section', $is_object=0 )))){ 
			$this->getContainers();
		}else{ 
			//$this->loadPage('welcome_filmvideo');
			$this->loadWelcomePage('welcome_filmvideo');
		}
	}
	public function musicNaudio($container='') {	
		$sectionId=$this->config->item('musicnaudioSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['maSelected']='selected';
		$this->data['welcomePage']='welcome_musicaudio';
		$this->data['welcomeHeading']=$this->lang->line('welcomeMusicAudioLH');
		$this->data['section']=$this->lang->line('media');
		$this->data['usedSection']=$this->lang->line('musicNaudio');
		$this->data['noAvailablesection']=$this->lang->line('media');
		$this->data['sectionImage']='Media1_110x73.jpg';
		$this->data['noAvailableImage']='Media1_110x73.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'project/musicNaudio/';
		$this->data['formSubmitUrl']=base_url(lang().'/media/musicNaudio/newProject/projectDescription');
		$this->data['showcaseSectionLink']=base_url(lang().'/mediafrontend/musicaudio/'.$this->userId);
		$this->data['AdministrationSectionLink']=base_url(lang().'/media/musicNaudio/');
		$this->data['showcase_section']=$this->lang->line('titleShowcase');
		$this->data['administration_section']=$this->lang->line('titleIndexPage');
		$this->data['edit_dashboard_link']=base_url(lang().'/media/musicNaudio/editProject/projectDescription/');
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['indexPageData'] = $this->sectionIndexPages('musicNaudio');
		$this->data['mediaSection']='musicaudio';
		$this->data['mediaAddSection']='musicNaudio';
		$this->data['helpPage'] = 'help_musicaudio';
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'musicNaudio', $userNavigations, $key='section', $is_object=0 ) ))){ 
			$this->getContainers();
		}else{ 
			//$this->loadPage('welcome_musicaudio');
			$this->loadWelcomePage('welcome_musicaudio');
		}
	}
	public function photographyNart($container='') {	
		$sectionId=$this->config->item('photographynartSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['paSelected']='selected';
		$this->data['welcomePage']='welcome_photographyart';
		$this->data['welcomeHeading']=$this->lang->line('welcomePhotographyArtLH');
		$this->data['section']=$this->lang->line('media');
		$this->data['usedSection']=$this->lang->line('photographyNart');
		$this->data['noAvailablesection']=$this->lang->line('media');
		$this->data['sectionImage']='Media1_110x73.jpg';
		$this->data['noAvailableImage']='Media1_110x73.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'project/photographyNart/';
		$this->data['formSubmitUrl']=base_url(lang().'/media/photographyNart/newProject/projectDescription');
		$this->data['showcaseSectionLink']=base_url(lang().'/mediafrontend/photographyart/'.$this->userId);
		$this->data['AdministrationSectionLink']=base_url(lang().'/media/photographyNart/');
		$this->data['showcase_section']=$this->lang->line('titleShowcase');
		$this->data['administration_section']=$this->lang->line('titleIndexPage');
		$this->data['mediaSection']='photographyart';
		$this->data['mediaAddSection']='photographyNart';
		$this->data['edit_dashboard_link']=base_url(lang().'/media/photographyNart/editProject/projectDescription/');
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['indexPageData'] = $this->sectionIndexPages('photographyNart');
		$this->data['helpPage'] = 'help_photographyart';
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'photographyNart', $userNavigations, $key='section', $is_object=0 ) ))){ 
			$this->getContainers();
		}else{ 
			//$this->loadPage('welcome_photographyart');
			$this->loadWelcomePage('welcome_photographyart');
		}
	}
	public function writingNpublishing($container='') {	
		$sectionId=$this->config->item('writingnpublishingSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['wnpSelected']='selected';
		$this->data['welcomePage']='welcome_writingpublishing';
		$this->data['welcomeHeading']=$this->lang->line('welcomeWritingPublishingLH');
		$this->data['section']=$this->lang->line('media');
		$this->data['usedSection']=$this->lang->line('writingNpublishing');
		$this->data['noAvailablesection']=$this->lang->line('media');
		$this->data['sectionImage']='Media1_110x73.jpg';
		$this->data['noAvailableImage']='Media1_110x73.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'project/writingNpublishing/';
		$this->data['formSubmitUrl']=base_url(lang().'/media/writingNpublishing/newProject/projectDescription');
		$this->data['showcaseSectionLink']=base_url(lang().'/mediafrontend/writingpublishing/'.$this->userId);
		$this->data['AdministrationSectionLink']=base_url(lang().'/media/writingNpublishing/');
		$this->data['edit_dashboard_link']=base_url(lang().'/media/writingNpublishing/editProject/projectDescription/');
		$this->data['showcase_section']=$this->lang->line('titleShowcase');
		$this->data['administration_section']=$this->lang->line('titleIndexPage');
		$this->data['mediaSection']='writingpublishing';
		$this->data['mediaAddSection']='writingNpublishing';
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['indexPageData'] = $this->sectionIndexPages('writingNpublishing');
		$this->data['helpPage'] = 'help_writingpublishing';
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'writingNpublishing', $userNavigations, $key='section', $is_object=0 ) ))){ 
			$this->newsCollection();
			$this->reviewsCollection();
			$this->getContainers();
		}else{ 
			//$this->loadPage('welcome_writingpublishing');
			$this->loadWelcomePage('welcome_writingpublishing');
		}
	}
	public function news() {	
		$this->writingNpublishing();
	}
	public function reviews() {	
		$this->writingNpublishing();
	}
	public function newsCollection() {	
		$sectionId=$this->config->item('newsSectionId');
		$this->data1['sectionId']=$sectionId;
		$this->data1['section']=$this->lang->line('newsCollectionHeading');
		$this->data1['sectionImage']='News_110x73.jpg';
		$this->data1['submitButton']=$this->lang->line('newArticle');
		$this->data1['dirUploadMedia']=$this->dirUploadMedia.'project/news/';
		$this->data1['formSubmitUrl']=base_url(lang().'/media/news/newProject/projectDescription');
		$this->data1['newElementUrl']=base_url(lang().'/media/news/editProject/uploadMedia/');
		$this->data1['edit_dashboard_container_link']=base_url(lang().'/media/news/editProject/projectDescription');
		$this->data1['dashboardCollection']= 'news';
		$userNavigations = $this->model_common->userNavigations($this->userId,false);
		$newsCount=0;
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 ){ 
			foreach($userNavigations as $key=>$val){
				if($val['section']=='news' && $val['sectionid']>0){
					$newsCount++;
				}
			}
		}
		$this->data1['countElementResult'] = $newsCount;
		$this->data1['elementCountLabel']=$this->lang->line('articlesCount');
		$this->data1['containers']=$this->getUserContainer($this->userId,$sectionId);
		$this->data['newsContainer']=$this->load->view('newsReviewsContainer',$this->data1, true);
	}
	public function reviewsCollection() {	
		$sectionId=$this->config->item('reviewsSectionId');
		$this->data1['sectionId']=$sectionId;
		$this->data1['section']=$this->lang->line('rewiewsCollectionHeading');
		$this->data1['sectionImage']='Review_110x73.jpg';
		$this->data1['submitButton']=$this->lang->line('newReview');
		$this->data1['dirUploadMedia']=$this->dirUploadMedia.'project/reviews/';
		$this->data1['formSubmitUrl']=base_url(lang().'/media/reviews/newProject/projectDescription');
		$this->data1['newElementUrl']=base_url(lang().'/media/reviews/editProject/uploadMedia/');
		$this->data1['edit_dashboard_container_link']=base_url(lang().'/media/reviews/editProject/projectDescription/');
		$this->data1['dashboardCollection']= 'review';
		$userNavigations = $this->model_common->userNavigations($this->userId,false);
		$reviewsCount=0;
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 ){ 
			foreach($userNavigations as $key=>$val){
				if($val['section']=='reviews' && $val['sectionid']>0){
					$reviewsCount++;
				}
			}
		}
		$this->data1['countElementResult'] = $reviewsCount;
		$this->data1['elementCountLabel']=$this->lang->line('reviewsCount');	
		$this->data1['containers']=$this->getUserContainer($this->userId,$sectionId);
		$this->data['reviewsContainer']=$this->load->view('newsReviewsContainer',$this->data1, true);
	}
	
	/*Function to load multilangual container */
	public function multilangualCollection() {	
		$this->data1['section']=$this->lang->line('multilingualShowcase');
		$this->data1['sectionImage']='Multilingual-Showcase_110x73.jpg';
		$this->data1['formSubmitUrl']=base_url(lang().'/dashboard');
		$this->data['multilangualContainer']=$this->load->view('multilangualContainer',$this->data1, true);
	}
	
	public function getUserContainer($userId=0,$sectionId='') {	
		$uc = new lib_userContainer();
		return $uc->getUserContainer($userId,$sectionId);
	}
	public function educationMaterial($container='') {	
		$sectionId=$this->config->item('educationmaterialSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['emSelected']='selected';
		$this->data['welcomePage']='welcome_educationalmaterial';
		$this->data['welcomeHeading']=$this->lang->line('welcomeEducationalMaterialLH');
		$this->data['section']=$this->lang->line('media');
		$this->data['usedSection']=$this->lang->line('educationMaterial');
		$this->data['noAvailablesection']=$this->lang->line('media');
		$this->data['sectionImage']='Media1_110x73.jpg';
		$this->data['noAvailableImage']='Media1_110x73.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'project/educationMaterial/';
		$this->data['formSubmitUrl']=base_url(lang().'/media/educationMaterial/newProject/projectDescription');
		$this->data['showcaseSectionLink']=base_url(lang().'/mediafrontend/educationmaterial/'.$this->userId);
		$this->data['AdministrationSectionLink']=base_url(lang().'/media/educationMaterial/');
		$this->data['edit_dashboard_link']=base_url(lang().'/media/educationMaterial/editProject/projectDescription/');
		$this->data['showcase_section']=$this->lang->line('titleShowcase');
		$this->data['administration_section']=$this->lang->line('titleIndexPage');
		
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['indexPageData'] = $this->sectionIndexPages('educationMaterial');
		$this->data['mediaSection']='educationmaterial';
		$this->data['mediaAddSection']='educationMaterial';
		$this->data['helpPage'] = 'help_educationalmaterial';
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'educationMaterial', $userNavigations, $key='section', $is_object=0 ) ))){ 
			$this->getContainers();
		}else{ 
			//$this->loadPage('welcome_educationalmaterial');
			$this->loadWelcomePage('welcome_educationalmaterial');
		}
	}
	public function work($container='') {	
		$sectionId=$this->config->item('worksSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['workSelected']='selected';
		$this->data['welcomePage']='welcome_work';
		$this->data['welcomeHeading']=$this->lang->line('welcomeWorkLH');
		$this->data['section']=$this->lang->line('work');
		$this->data['usedSection']=$this->lang->line('work');
		$this->data['noAvailablesection']=$this->lang->line('work');
		$this->data['sectionImage']='Work_110x73.jpg';
		$this->data['noAvailableImage']='Work_110x73.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'work/';
		$this->data['formSubmitUrl']=base_url(lang().'/work/offered/0/description');
		$this->data['showcaseSectionLink']=base_url(lang().'/workshowcase/works/'.$this->userId);
		$this->data['AdministrationSectionLink']=base_url(lang().'/work/');
		
		$this->data['showcase_section']=$this->lang->line('titleShowcase');
		$this->data['administration_section']=$this->lang->line('titleIndexPage');
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['indexPageData'] = $this->sectionIndexPages('work');
		$this->data['helpPage'] = 'help_work';
		$this->data['selectProjectType']=array(
											'workOfferred'=>base_url(lang().'/work/offered/0/description'),
											'workWanted'=>base_url(lang().'/work/wanted/0/description')
										);
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'work', $userNavigations, $key='section', $is_object=0 ) ))){ 
			$this->getContainers();
		}else{ 
			//$this->loadPage('welcome_work');
			$this->loadWelcomePage('welcome_work');
		}
	}
	public function products($container='') {	
		$sectionId=$this->config->item('productsSellSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['productsSelected']='selected';
		$this->data['welcomePage']='welcome_products';
		$this->data['welcomeHeading']=$this->lang->line('welcomeProductsLH');
		$this->data['section']=$this->lang->line('product');
		$this->data['usedSection']=$this->lang->line('products');
		$this->data['noAvailablesection']=$this->lang->line('products');
		$this->data['sectionImage']='Products_110x73.jpg';
		$this->data['noAvailableImage']='Products_110x73.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'product/';
		$this->data['formSubmitUrl']=base_url(lang().'/product/sell/0/description');
		$this->data['showcaseSectionLink']=base_url(lang().'/productshowcase/products/'.$this->userId);
		$this->data['AdministrationSectionLink']=base_url(lang().'/product/');
		$this->data['showcase_section']=$this->lang->line('titleShowcase');
		$this->data['administration_section']=$this->lang->line('titleIndexPage');
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['indexPageData'] = $this->sectionIndexPages('product');
		$this->data['helpPage'] = 'help_products';
		$this->data['selectProjectType']=array(
											'productsForSale'=>base_url(lang().'/product/sell/0/description'),
											'productsWanted'=>base_url(lang().'/product/wanted/0/description')
										);
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'product', $userNavigations, $key='section', $is_object=0 ) ))){ 
			$this->productClassifiedFree();
			$this->getContainers(array($sectionId,$this->config->item('productClassifiedFreeSectionId')));
		}else{ 
			//$this->loadPage('welcome_products');
			$this->loadWelcomePage('welcome_products');
		}
	}
	public function productClassifiedFree() {	
		$sectionId=$this->config->item('productClassifiedFreeSectionId');
		$this->data1['sectionId']=$sectionId;
		$this->data1['section']=$this->lang->line('productsFree');
		$this->data1['sectionImage']='73px-X-110px_Products-FREE_1.jpg';
		//$this->data1['submitButton']=$this->lang->line('newClassified');
		$this->data1['submitButton']=$this->lang->line('newClassifieds');
		$this->data1['countElementResult']=$this->model_common->countResult('Product',array('tdsUid'=>$this->userId,'catId'=>3,'productArchived'=>'f'));
		$this->data1['elementCountLabel']=$this->lang->line('productsFreeCount');
		$this->data1['dirUploadMedia']=$this->dirUploadMedia.'product/';
		$this->data1['formSubmitUrl']=base_url(lang().'/product/freeStuff/0/description');
		$this->data1['edit_dashboard_container_link']=base_url(lang().'/product/freeStuff');
		$this->data1['containers']=$this->getUserContainer($this->userId,$sectionId);
		$this->data['lifeTimeFreeContainer']=$this->load->view('newsReviewsContainer',$this->data1, true);
	}
	public function performancesevents($container='') {	
		$eventNotificationsSectionId=$this->config->item('eventNotificationsSectionId');
		$eventsSectionId=$this->config->item('eventsSectionId');
		$launchesSectionId=$this->config->item('launchesSectionId');
		$eventswithLaunchSectionId=$this->config->item('eventswithLaunchSectionId');
		$this->data['peSelected']='selected';
		$this->data['welcomePage']='welcome_performancesevents';
		$this->data['welcomeHeading']=$this->lang->line('welcomePerformancesEventsLH');
		$this->data['usedSection']=$this->lang->line('performacesEvents');
		$this->data['sectionImage']='Performances-and-Events_110x73.jpg';
		$this->data['noAvailableImage']='Performances-and-Events_110x73.jpg';
		$this->data['showcaseSectionLink']=base_url(lang().'/eventfrontend/eventnotification/'.$this->userId);
		$this->data['AdministrationSectionLink']=base_url(lang().'/event/');
		$this->data['showcase_section']=$this->lang->line('titleShowcase');
		$this->data['administration_section']=$this->lang->line('titleIndexPage');
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['dirUploadLaunch']=$this->dirUploadMedia.'launchevents/';
		$this->data['selectProjectType']=true;
		$this->data['indexPageData'] = $this->sectionIndexPages('PerformanceEvent');
		$this->data['helpPage'] = 'help_performancesevents';
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'event', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'launch', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'notification', $userNavigations, $key='section', $is_object=0 )))){ 
			$uc = new lib_userContainer();
			$this->data['usedContainer']=$uc->getUsedUserContainer($this->userId,array($eventNotificationsSectionId,$eventsSectionId,$launchesSectionId,$eventswithLaunchSectionId));
			$this->events();
			$this->launchs();
			$this->eventwithlaunchs();
			$this->eventnotification();
			$this->loadPage('container');
		}else{ 
			//$this->loadPage('welcome_performancesevents');
			$this->loadWelcomePage('welcome_performancesevents');
		}
	}
	public function events() {	
		$uc = new lib_userContainer();
		$sectionId=$this->config->item('eventsSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['section']=$this->lang->line('event');
		$this->data['noAvailablesection']=$this->lang->line('event');
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'events/';
		$this->data['formSubmitUrl']=base_url(lang().'/event/events/eventform');
		$this->data['availableContainer']=$uc->getAvailableUserContainer($this->userId,$this->data['sectionId']);
		//$this->data['events']=$this->load->view('availableContainer',$this->data, true);
		$this->data['events']=$this->load->view('newAvailableContainer',$this->data, true);
	}
	public function launchs() {	
		$uc = new lib_userContainer();
		$sectionId=$this->config->item('launchesSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['section']=$this->lang->line('launch');
		$this->data['noAvailablesection']=$this->lang->line('launch');
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'launchevents/';
		$this->data['formSubmitUrl']=base_url(lang().'/event/launch/launcheventform');
		$this->data['availableContainer']=$uc->getAvailableUserContainer($this->userId,$this->data['sectionId']);
		//$this->data['launches']=$this->load->view('availableContainer',$this->data, true);
		$this->data['launches']=$this->load->view('newAvailableContainer',$this->data, true);
	}
	public function eventwithlaunchs() {	
		$uc = new lib_userContainer();
		$sectionId=$this->config->item('eventswithLaunchSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['section']=$this->lang->line('eventwithLaunch');
		$this->data['noAvailablesection']=$this->lang->line('eventwithLaunch');
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'events/';
		
		$this->data['formSubmitUrl']=base_url(lang().'/event/eventwithlaunch/eventform');
		$this->data['availableContainer']=$uc->getAvailableUserContainer($this->userId,$this->data['sectionId']);
		//$this->data['eventwithlaunchs']=$this->load->view('availableContainer',$this->data, true);
		$this->data['eventwithlaunchs']=$this->load->view('newAvailableContainer',$this->data, true);
	}
	public function eventnotification() {	
		$sectionId=$this->config->item('eventNotificationsSectionId');
		$this->data1['sectionId']=$sectionId;
		$this->data1['section']=$this->lang->line('eventNotification');
		$this->data1['sectionImage']='Performances-and-Events_110x73.jpg';
		$this->data1['submitButton']=$this->lang->line('newNotification');
		$this->data1['dirUploadMedia']=$this->dirUploadMedia.'events/';
		$this->data1['formSubmitUrl']=base_url(lang().'/event/eventnotifications/eventform');
		$this->data1['edit_dashboard_container_link']=base_url(lang().'/event/eventnotifications');
		$this->data1['elementCountLabel'] = $this->lang->line('eventNotifications');
		$this->data1['countElementResult'] = countResult('Events',array('tdsUid'=>$this->userId,'EventArchive'=>'f','NatureId'=>1));
		$this->data1['containers']=$this->getUserContainer($this->userId,$sectionId);
		$this->data['lifeTimeFreeContainer']=$this->load->view('newsReviewsContainer',$this->data1, true);
	}
	public function competition($container='') {	
		$sectionId=$this->config->item('competitionSectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['competitionSelected']='selected';
		$this->data['welcomePage']='welcome_competition';
		$this->data['welcomeHeading']=$this->lang->line('welcomeCompetitionLH');
		$this->data['section']=$this->lang->line('competition');
		$this->data['noAvailablesection']=$this->lang->line('competition');
		$this->data['usedSection']=$this->lang->line('competitions');
		$this->data['sectionImage']='competition_73x110.jpg';
		$this->data['noAvailableImage']='competition_73x110.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'competition/';
		$this->data['formSubmitUrl']=base_url(lang().'/competition/description/language1');
		//$this->data['showcaseSectionLink']=base_url(lang().'/competition/showcase/'.$this->userId);
		$this->data['showcaseSectionLink']='javascript:void(o);';
		$this->data['AdministrationSectionLink']=base_url(lang().'/competition/competitionlist/');
		$this->data['showcase_section']=$this->lang->line('competitionShowcase');
		$this->data['administration_section']=$this->lang->line('competitionIndexPage');
		$this->data['edit_dashboard_link']=base_url(lang().'/competition/description/language1');
		$this->data['helpPage'] = 'help_competition';
		$this->data['indexPageData'] = $this->sectionIndexPages('competition');
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['renewNotRequired']=true;
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr('competition', $userNavigations, $key='section', $is_object=0 )))){ 
			
			// assign competition container to super-admin if super-admin has no competition-container. Starts
				$user_role = LoginUserDetails('user_role'); 
				if(is_numeric($user_role) && ($user_role == 4)){ // check is user super-admin?
					$tsProduct=$this->model_common->getDataFromTabel('MasterTsProduct', 'tsProductId',  array('allowedSections'=>'{16}'), '', '', '',1);
					if($tsProduct){
						$tsProductId=$tsProduct[0]->tsProductId;
						$uc = new lib_userContainer();
						$uc->checkPackageAssignToSuperAdmin($this->userId,$tsProductId);
					}
				}
			// assign competition container to super-admin if super-admin has no competition-container. End
			
			$this->getContainers();
		}else{ 
			//$this->loadPage('welcome_competition');
			$this->loadWelcomePage('welcome_competition');
		}
	}
	
	public function competitionentry($container='') {	
		$sectionId=$this->config->item('competitionEntrySectionId');
		$this->data['sectionId']=$sectionId;
		$this->data['competitionEntrySelected']='selected';
		$this->data['welcomePage']='welcome_competitionentry';
		$this->data['welcomeHeading']=$this->lang->line('welcomeCompetitionEntryLH');
		$this->data['section']=$this->lang->line('competitionEntry');
		$this->data['noAvailablesection']=$this->lang->line('competitionEntry');
		$this->data['usedSection']=$this->lang->line('competitionEntries');
		$this->data['sectionImage']='competitionentry_73x110.jpg';
		$this->data['noAvailableImage']='competitionentry_73x110.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'competitionentry/';
		$this->data['formSubmitUrl']=base_url(lang().'/competition/competitionentryinsert');
		//$this->data['showcaseSectionLink']=base_url(lang().'/competition/showcase/'.$this->userId);
		$this->data['showcaseSectionLink']='javascript:void(o);';
		$this->data['AdministrationSectionLink']=base_url(lang().'/competition/competitionentrylist/');
		$this->data['showcase_section']=$this->lang->line('competitionEntryShowcase');
		$this->data['administration_section']=$this->lang->line('competitionEntryIndexPage');
		$this->data['helpPage'] = 'help_competitionentry';
		$this->data['edit_dashboard_container_link']=base_url(lang().'/competition/competitionentrylist');
		$this->data['containerType']='newsReviewsContainer';
		$this->data['indexPageData'] = $this->sectionIndexPages('competitionentry');
		$this->data['renewNotRequired']=true;
		$this->data['notAllowtoDirectUse']=true;
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr('competitionentry', $userNavigations, $key='section', $is_object=0 )))){ 
			
			// assign free competition-entry container to user if user didn't get it registration time. Starts
				$tsProduct=$this->model_common->getDataFromTabel('MasterTsProduct', 'tsProductId',  array('allowedSections'=>'{16:1}'), '', '', '',1);
				if($tsProduct){
					$tsProductId=$tsProduct[0]->tsProductId;
					$uc = new lib_userContainer();
					$uc->checkPackageAssign($this->userId,$tsProductId);
				}
			// assign free competition-entry container to user if user didn't get it registration time. End
			
			$this->data['containers']=$this->getUserContainer($this->userId,$sectionId);
			$this->getContainers();
			
		}else{ 
			$this->loadPage('welcome_competitionentry');
		}
	}
	
	public function advertise($container='') {	
		$sectionId=$this->config->item('advertiseSectionId');
		
		$this->data['sectionId']=$sectionId;
		$this->data['adSelected']='selected';
		$this->data['welcomePage']='welcome_advertise';
		$this->data['welcomeHeading']=$this->lang->line('welcomeAdvertiseLH');
		$this->data['section']=$this->lang->line('advertise');
		$this->data['noAvailablesection']=$this->lang->line('advertise');
		$this->data['usedSection']=$this->lang->line('advertise');
		$this->data['sectionImage']='advertisewithus_icon.gif';
		$this->data['noAvailableImage']='advertisewithus_icon.gif';
		$this->data['dirUploadMedia']='openx/www/images/';
		$this->data['formSubmitUrl']=base_url(lang().'/advertising/description');
		$this->data['showcaseSectionLink']='#';
		$this->data['previewSectionLink']='#';
		
		$this->data['submitButton']=$this->lang->line('newAdvertise');
		
		$this->data['AdministrationSectionLink']=base_url(lang().'/advertising/index/');
		$this->data['showcase_section']=$this->lang->line('showcase');
		$this->data['administration_section']=$this->lang->line('advertiseIndexPage');
		$this->data['edit_dashboard_link']=base_url(lang().'/advertising/description');
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['indexPageData'] = $this->sectionIndexPages('advertise');
		$this->data['helpPage'] = 'help_advertise';
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'advertise', $userNavigations, $key='section', $is_object=0 )))){ 
			// assign competition container to super-admin if super-admin has no competition-container. Starts
				$user_role = LoginUserDetails('user_role'); 
				if(is_numeric($user_role) && ($user_role == 4)){ // check is user super-admin?
					$tsProduct=$this->model_common->getDataFromTabel('MasterTsProduct', 'tsProductId',  array('allowedSections'=>'{'.$sectionId.'}'), '', '', '',1);
					if($tsProduct){
						$tsProductId=$tsProduct[0]->tsProductId;
						$uc = new lib_userContainer();
						$uc->checkPackageAssignToSuperAdmin($this->userId,$tsProductId);
					}
				}
			// assign competition container to super-admin if super-admin has no competition-container. End
			$this->getContainers();
		}else{ 
			//$this->loadPage('welcome_upcoming');
			$this->loadWelcomePage('welcome_advertise');
		}
	}
	
	public function collaboration($container='') {	
		$sectionId=$this->config->item('collaborationSectionId');
		
		$this->data['sectionId']=$sectionId;
		$this->data['adSelected']='selected';
		$this->data['welcomePage']='welcome_collaboration';
		$this->data['welcomeHeading']=$this->lang->line('welcomeCollaborationLH');
		$this->data['section']=$this->lang->line('collaboration');
		$this->data['noAvailablesection']=$this->lang->line('collaboration');
		$this->data['usedSection']=$this->lang->line('collaboration');
		$this->data['sectionImage']='collaboration.jpg';
		$this->data['noAvailableImage']='collaboration.jpg';
		$this->data['dirUploadMedia']=$this->dirUploadMedia.'collaboration/';
		$this->data['formSubmitUrl']=base_url(lang().'/collaboration/description');
		$this->data['showcaseSectionLink']='#';
		$this->data['previewSectionLink']='#';
		
		$this->data['submitButton']=$this->lang->line('newCollaboration');
		
		$this->data['AdministrationSectionLink']=base_url(lang().'/collaboration/index/');
		$this->data['showcase_section']=$this->lang->line('showcase');
		$this->data['administration_section']=$this->lang->line('collaborationIndexPage');
		$this->data['edit_dashboard_link']=base_url(lang().'/collaboration/description');
		//$this->data['containerType']='availableContainer';
		$this->data['containerType']='newAvailableContainer';
		$this->data['indexPageData'] = $this->sectionIndexPages('collaboration');
		$this->data['helpPage'] = 'help_collaboration';
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		
		$assignedCollaboration = $this->model_dashboard->assignedCollaborationToUser(array('cm.userId'=>$this->userId,'cm.status'=>1,'clb.isPublished'=>'t'));
		if($assignedCollaboration){
			$this->data['assigned_collaboration']= $this->load->view('assigned_collaboration',array('clbData'=>$assignedCollaboration), true);
		}else{
			$this->data['assigned_collaboration']= false;
		}
		
		
		if($container=='containers' || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'collaboration', $userNavigations, $key='section', $is_object=0 )))){ 
			// assign competition container to super-admin if super-admin has no competition-container. Starts
				$user_role = LoginUserDetails('user_role'); 
				if(is_numeric($user_role) && ($user_role == 4)){ // check is user super-admin?
					$tsProduct=$this->model_common->getDataFromTabel('MasterTsProduct', 'tsProductId',  array('allowedSections'=>'{'.$sectionId.'}'), '', '', '',1);
					if($tsProduct){
						$tsProductId=$tsProduct[0]->tsProductId;
						$uc = new lib_userContainer();
						$uc->checkPackageAssignToSuperAdmin($this->userId,$tsProductId);
					}
				}
			// assign competition container to super-admin if super-admin has no competition-container. End
			$this->getContainers();
		}else{ 
			//$this->loadPage('welcome_upcoming');
			$this->loadWelcomePage('welcome_collaboration');
		}
	}
	
	public function getContainers($sectionId='') {	
		if(is_array($sectionId) && count($sectionId) > 0){
			$sectionId=$sectionId;
		}else{
			$sectionId=$this->data['sectionId'];
		}
		$uc = new lib_userContainer();
		
		$this->data['countMeetingPoint']= $this->model_dashboard->getMettingPoint($this->userId);
		$this->data['workApplicationsSentCount']= $this->model_dashboard->getWorkAppliedFor($this->userId);
		$this->data['workApplicationsReceivedCount']= $this->model_dashboard->getWorkAppReceived($this->userId);
		
		$this->data['usedContainer']=$uc->getUsedUserContainer($this->userId,$sectionId);
		
		$this->data['availableContainer']=$uc->getAvailableUserContainer($this->userId,$this->data['sectionId']);
		
		$this->loadPage('container');
	}
	
	public function loadPage($page='welcome_showcase') {	
		$this->data['innerPage']=$page;
		$this->data['cravesCount']=$this->model_craves->craveList($this->userId,'','','',0,true,true);	
		$this->data['craveMeCount']=$this->model_craves->craveList($this->userId,'','','',0,true,true,0,true);	
		
		$this->data['countMeetingPoint']= $this->model_dashboard->getMettingPoint($this->userId);
		$this->data['workApplicationsSentCount']= $this->model_dashboard->getWorkAppliedFor($this->userId);
		$this->data['workApplicationsReceivedCount']= $this->model_dashboard->getWorkAppReceived($this->userId);
		
		//$this->template->load('template','dashboard/dashboardPanel',$this->data);		
		$this->template->load('dashboard_template','dashboard/dashboardNewPanel',$this->data);		
	}
	
	public function loadWelcomePage($page='welcome_showcase') {	
		$this->data['innerWelcomePage'] = $page;
		if(!empty($page)) {
			$pageExp = explode('_',$page);
			$helpPage = 'help_'.$pageExp[1];
			$this->data['helpPage'] = $helpPage;
		}
		$this->data['cravesCount']=$this->model_craves->craveList($this->userId,'','','',0,true,true);	
		$this->data['craveMeCount']=$this->model_craves->craveList($this->userId,'','','',0,true,true,0,true);	
		
		$this->data['countMeetingPoint']= $this->model_dashboard->getMettingPoint($this->userId);
		$this->data['workApplicationsSentCount']= $this->model_dashboard->getWorkAppliedFor($this->userId);
		$this->data['workApplicationsReceivedCount']= $this->model_dashboard->getWorkAppReceived($this->userId);
		
		//$this->template->load('template','dashboard/dashboardPanel',$this->data);		
		$this->template->load('dashboard_template','dashboard/dashboardNewPanel',$this->data);		
	}
	
	public function getStatesList() {
		$countryId=$this->input->post('val1');
		$data['ConsumptionTax']=$this->input->post('val2');
		$data['statesList']=getStatesList($countryId);
		$this->load->view('dashboard/statesList',$data);
	}
	
	public function euCountiesTaxPercentage() {
		$data['euCountiesList']=$this->input->post('val1');
		$data['ConsumptionTax']=$this->input->post('val2');
		$data['territory']=$this->input->post('val3');
		$this->load->view('euCountiesTaxPercentage',$data);
	}
	public function stateWiseTaxPercentageShow() {
		$data['ConsumptionTax']=$this->input->post('val2');
		$data['territory']=$this->input->post('val3');
		$this->load->view('stateWiseTaxPercentage',$data);
	}
	function globalsettings($innerPage=1){
		if($this->input->post('sellerSettings')=='sellerSettings'){
			$this->sellerSettings();
		}
		$socialmh = $buyermh = $sellermh = $msmh = '';
		switch($innerPage){
			case 2: 
						$innerPage ='social_settings';
						$PageHeading ='Social Media Sites';
						$socialmh ='TabbedPanelsTabSelected';
			break;
			
			case 3: 
						$innerPage ='buyer_settings';
						$PageHeading ='Buyer Settings';
						$buyermh ='TabbedPanelsTabSelected';
			break;
			
			case 4: 
							$innerPage ='seller_settings';
							$PageHeading ='Seller Settings';
							$sellermh ='TabbedPanelsTabSelected';
			break;
			
			default: 
							$innerPage ='membership_settings';
							$PageHeading ='Membership Settings';
							$msmh ='TabbedPanelsTabSelected';
			break;
		}
		$userId = $this->userId;
		$data['countryList'] = getCountryList();
		$data['euCountiesList'] = euCountiesList();
		$data['countiesNotInEU'] = countiesNotInEU();
		$data['ConsumptionTax'] = $this->model_dashboard->ConsumptionTax(array('userId'=>$this->userId,'isDeleted'=>'f'));
		$data['innerPage'] = $innerPage ;
		$data['packagestageheading'] = $PageHeading ;
		$data['socialmh'] = $socialmh ;
		$data['buyermh'] = $buyermh ;
		$data['sellermh'] = $sellermh ;
		$data['msmh'] = $msmh ;
		$data['userId'] = $userId;
		$userProfileData = $this->model_dashboard->getUserProfileData($userId);
		$data['userProfileData']=isset($userProfileData[0])?$userProfileData[0]:false;
		$data['socialMediaData'] = $this->model_dashboard->getSocialMediaData($userId);			
		$data['shippingdetails']=$this->model_common->getDataFromTabel('ProjectShippingDomestic', '*',  array('userId'=>$this->userId),'','','',1);		
	
		$this->new_version->load('new_version','dashboard/globalsettingsPanel',$data);
	}
	
	
	function saveContactDetails(){
		$userId = $this->userId;
		$config = array(
               array(
                     'field'   => 'firstName',
                     'label'   => 'First Name',
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'lastName',
                     'label'   => 'Last Name',
                     'rules'   => 'trim|xss_clean'
                  ),   
               array(
                     'field'   => 'countryId',
                     'label'   => 'Country',
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'stateId',
                     'label'   => 'State',
                     'rules'   => 'trim|xss_clean'
                  ),
            );

		$this->form_validation->set_rules($config); 
		if($this->form_validation->run())
		{
			$countryId=set_value('countryId')>0?set_value('countryId'):0;
			$stateId=set_value('stateId')>0?set_value('stateId'):0;
			$firstName=set_value('firstName');
			$lastName=set_value('lastName');
			$userFullName=$firstName.' '.$lastName;
			
			$UserProfile = array(
				'tdsUid' => $this->userId,
				'firstName' => $firstName,
				'lastName' =>  $lastName,
				'countryId' => $countryId,
				'stateId' => $stateId,
			);
			$this->model_common->editDataFromTabel('UserProfile', $UserProfile, 'tdsUid', $this->userId);
            // update enterprise name if exists
            $enterpriseName = $this->input->post('enterpriseName');
            if(!empty($enterpriseName)) {
                $this->model_common->editDataFromTabel('UserShowcase', array('enterpriseName'=>$enterpriseName), 'tdsUid', $this->userId);
                // enterprise name in session
                $this->session->set_userdata('enterpriseName',$enterpriseName);
            }
			$countryName=getCountry($countryId);
			$this->session->set_userdata(array('firstName'=>$firstName,'lastName'=>$lastName,'userFullName'=>$userFullName, 'countryId'=>$countryId,'countryName'=>$countryName));
			$msg = $this->lang->line('contactDetailSave');
			echo json_encode(array('msg'=>$msg));
		}
	}
	
	function savePassword(){
		$userId = $this->userId;
		$config = array(
               array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'trim|required|xss_clean'
                  ),				
               array(
                     'field'   => 'confirmPassword',
                     'label'   => 'Confirm Password',
                     'rules'   => 'trim|required|xss_clean'
                  ),
            );

		$this->form_validation->set_rules($config); 
		if($this->form_validation->run())
		{
			$password=set_value('password');
			if(!empty($password)){
				$this->load->config('auth/tank_auth', TRUE);
				$this->load->library('auth/PasswordHash',$this->config->item('phpass_hash_strength', 'tank_auth'), $this->config->item('phpass_hash_portable', 'tank_auth'));
						
				$hasher = new PasswordHash(
					$this->config->item('phpass_hash_strength', 'tank_auth'),
					$this->config->item('phpass_hash_portable', 'tank_auth')
				);
					
				$hashed_password = $hasher->HashPassword($password);
				$UserAuth['password']= $hashed_password;
				$this->session->set_userdata('new_password',1);
				//send new password mail function call here
				$getUserEmail = $this->model_common->getDataFromTabel('UserAuth', 'email',  array('tdsUid'=>$this->userId),'','','',1);
				if(!empty($getUserEmail)){
					$userEmail = $getUserEmail[0]->email;
					$this->changedPassword($userEmail);
				}
				
				$this->model_common->editDataFromTabel('UserAuth', $UserAuth, 'tdsUid', $this->userId);
				
			}
			$msg = $this->lang->line('changePassword');
			echo json_encode(array('msg'=>$msg));
		}
	}
	
	function saveEmail(){
		$userId = $this->userId;
		$config = array(
               array(
                     'field'   => 'email',
                     'label'   => 'Email',
                     'rules'   => 'trim|required|email|xss_clean'
                  ),				
               array(
                     'field'   => 'confirmEmail',
                     'label'   => 'Confirm Email',
                     'rules'   => 'trim|required|email|xss_clean'
                  ),
            );

		$this->form_validation->set_rules($config); 
		if($this->form_validation->run())
		{
			$email=set_value('email');
			$UserAuth['email']= $email;
			$this->model_common->editDataFromTabel('UserAuth', $UserAuth, 'tdsUid', $this->userId);
			$this->session->set_userdata('email',$email);
			$msg = $this->lang->line('changeEmail');
			echo json_encode(array('msg'=>$msg,'email'=>$email));
		}
	}
	
	function saveSearchPreferences(){
		$userId = $this->userId;
		$config = array(
               array(
                     'field'   => 'firstLanguage',
                     'label'   => 'First Language',
                     'rules'   => 'trim|xss_clean'
                  ),				
               array(
                     'field'   => 'secondLanguage',
                     'label'   => 'Second Language',
                     'rules'   => 'trim|xss_clean'
                  ),				
               array(
                     'field'   => 'firstCountryId',
                     'label'   => 'First Country',
                     'rules'   => 'trim|xss_clean'
                  ),				
               array(
                     'field'   => 'secondCountryId',
                     'label'   => 'Second Country',
                     'rules'   => 'trim|xss_clean'
                  ),				
               array(
                     'field'   => 'suitableForGeneralAudiences',
                     'label'   => 'Suitable for General Audiences',
                     'rules'   => 'trim|xss_clean'
                  ),				
               array(
                     'field'   => 'suitableForChildren',
                     'label'   => 'Suitable for Children',
                     'rules'   => 'trim|xss_clean'
                  ),				
               array(
                     'field'   => 'suitableForYoungAdults',
                     'label'   => 'Suitable for Young Adults',
                     'rules'   => 'trim|xss_clean'
                  ),				
               array(
                     'field'   => 'someContentCouldBeOfens',
                     'label'   => 'Some Content Could be Ofensive',
                     'rules'   => 'trim|xss_clean'
                  )			
            );

		$this->form_validation->set_rules($config); 
		if($this->form_validation->run())
		{
			$UserSearchPreferences = array(
				'tdsUid' => $this->userId,
				'firstLanguage' => set_value('firstLanguage')>0?set_value('firstLanguage'):0,
				'secondLanguage' =>    set_value('secondLanguage')>0?set_value('secondLanguage'):0,
				'firstCountryId'=> set_value('firstCountryId')>0?set_value('firstCountryId'):0,
				'secondCountryId'=> set_value('secondCountryId')>0?set_value('secondCountryId'):0,
				'suitableForGeneralAudiences'=> set_value('suitableForGeneralAudiences')=='t'?'t':'f',
				'suitableForChildren'=> set_value('suitableForChildren')=='t'?'t':'f',
				'suitableForYoungAdults'=> set_value('suitableForYoungAdults')=='t'?'t':'f',
				'someContentCouldBeOfens'=> set_value('someContentCouldBeOfens')=='t'?'t':'f'
			);						  
			$res=$this->model_common->getDataFromTabel('UserSearchPreferences', 'id',  array('tdsUid'=>$this->userId),'','','',1);
			if(isset($res[0]->id) && $res[0]->id > 0){
				$this->model_common->editDataFromTabel('UserSearchPreferences', $UserSearchPreferences, 'id', $res[0]->id);
			}else{
				$this->model_common->addDataIntoTabel('UserSearchPreferences', $UserSearchPreferences);
			}
			$msg = $this->lang->line('updatedSearchPreferences');
			echo json_encode(array('msg'=>$msg));
		}
	}
	
	
	/*
	 * Function to manage Secondary Email
	 */
	function changedPassword($userEmail=''){
		
		/* while we don't remove restriction (username, password) in .htacess file  from live site*/
		$image_base_url = site_base_url().'images/email_images/';
		/* Set Follow us link*/
		$facebook_url = $this->config->item('facebook_follow_url');
		$linkedin_url = $this->config->item('linkedin_follow_url');
		$twitter_url = $this->config->item('twitter_follow_url');
		$gPlus_url = $this->config->item('google_follow_url');
		$crave_url = $this->config->item('crave_us');
		//Get secondary email subject and body
		$where=array('purpose'=>'reset_password','active'=>1);
		$secondaryTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
		if($secondaryTemplateRes) {
			
			$secondaryTemplate = $secondaryTemplateRes[0]->templates;
			$searchArray = array("{image_base_url}" , "{crave_us}", "{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
			$replaceArray = array($image_base_url,$crave_url,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
			$newEmailBody = str_replace($searchArray, $replaceArray, $secondaryTemplate);
			$newEmailSubject = $secondaryTemplateRes[0]->subject;
			//Send data at secondary email
			$from_email = $this->config->item('webmaster_email', '');
			$this->email->from($from_email, $this->config->item('website_name', ''));
			$this->email->to($userEmail);
			$this->email->subject(sprintf($newEmailSubject));
			$this->email->message($newEmailBody);
			$flag = $this->email->send();
		}
	}
	
	
	
	/*
	 * Function to manage Secondary Email
	 */
	function manageSecondaryEmail($UserAuthData='',$userId=0){
		
		/* while we don't remove restriction (username, password) in .htacess file  from live site*/
		$image_base_url = site_base_url().'images/email_images/';
		
		/* Set email activation link*/
		$email_activation_url = site_url('/dashboard/activateSecondaryEmail/'.$userId.'/'.$UserAuthData['new_email_key']);
		
		/* Set Follow us link*/
		$facebook_url = $this->config->item('facebook_follow_url');
		$linkedin_url = $this->config->item('linkedin_follow_url');
		$twitter_url = $this->config->item('twitter_follow_url');
		$gPlus_url = $this->config->item('google_follow_url');
		$crave_url = $this->config->item('crave_us');
		//Get secondary email subject and body
		$where=array('purpose'=>'secondaryemailactivate','active'=>1);
		$secondaryTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
		if($secondaryTemplateRes) {
			
			$secondaryTemplate = $secondaryTemplateRes[0]->templates;
			$searchArray = array("{image_base_url}" , "{crave_us}", "{email_activation_url}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
			$replaceArray = array($image_base_url,$crave_url,$email_activation_url,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
			$newEmailBody = str_replace($searchArray, $replaceArray, $secondaryTemplate);
			$newEmailSubject = $secondaryTemplateRes[0]->subject;
			
			//Send data at secondary email
			$from_email = $this->config->item('webmaster_email', '');
			$this->email->from($from_email, $this->config->item('website_name', ''));
			$this->email->to($UserAuthData['new_email']);
			$this->email->subject(sprintf($newEmailSubject));
			$this->email->message($newEmailBody);
			$flag = $this->email->send();
		}
		
		// Save secondary email data
		$this->model_common->editDataFromTabel('UserAuth', $UserAuthData, 'tdsUid', $userId);
	}
	
	function saveBuyerBilling(){
		
		$userId = $this->userId;
		$config = array(
			array(
				 'field'   => 'billing_firstName',
				 'label'   => 'First Name',
				 'rules'   => 'trim|xss_clean'
			  ),
			array(
				 'field'   => 'billing_lastName',
				 'label'   => 'Last Name',
				 'rules'   => 'trim|xss_clean'
			  ),   
			array(
				 'field'   => 'billing_companyName',
				 'label'   => 'Company Name',
				 'rules'   => 'trim|xss_clean'
			  ),   
						
			array(
				 'field'   => 'billing_address1',
				 'label'   => 'Address1',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'billing_address2',
				 'label'   => 'Address2',
				 'rules'   => 'trim|xss_clean'
			  ),
			  array(
				 'field'   => 'billing_city',
				 'label'   => 'City Name',
				 'rules'   => 'trim|xss_clean'
			  ),   
					
			array(
				 'field'   => 'billing_state',
				 'label'   => 'State',
				 'rules'   => 'trim|xss_clean'
			  ),
			  array(
				 'field'   => 'billing_country',
				 'label'   => 'Country',
				 'rules'   => 'trim|xss_clean'
			  ),					
			array(
				 'field'   => 'billing_zip',
				 'label'   => 'Zip',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'billing_phone',
				 'label'   => 'Phone',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'billing_email',
				 'label'   => 'Email',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'billing_isSameAsSeller',
				 'label'   => ' Same as Seller Details',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'payConsumptionTax',
				 'label'   => 'pay consumption tax',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'EuVatIdentificationNumber',
				 'label'   => 'EU VAT Identification Number',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'otherAboutConsumptionTax',
				 'label'   => 'Others',
				 'rules'   => 'trim|xss_clean'
			  )
			 );

		$this->form_validation->set_rules($config); 
		if($this->form_validation->run()) {
			$UserBuyerSettings = array(
				'tdsUid' => $this->userId,
				'billing_firstName'=> set_value('billing_firstName'),
				'billing_lastName' => set_value('billing_lastName'),
				'billing_companyName' => set_value('billing_companyName'),
				'billing_address1' => set_value('billing_address1'),
				'billing_address2' => set_value('billing_address2'),
				'billing_city' => set_value('billing_city'),
				'billing_state' => set_value('billing_state'),
				'billing_country' => set_value('billing_country')>0?set_value('billing_country'):0,
				'billing_zip' => set_value('billing_zip'),
				'billing_phone' => set_value('billing_phone'),
				'billing_email' => set_value('billing_email'),
				'billing_isSameAsSeller' => (set_value('billing_isSameAsSeller')=='t')?'t':'f', 
				'payConsumptionTax' => set_value('payConsumptionTax')=='f'?'f':'t',
				'EuVatIdentificationNumber' => set_value('EuVatIdentificationNumber'),
				'otherAboutConsumptionTax'=> set_value('otherAboutConsumptionTax')
			);
			$res=$this->model_common->getDataFromTabel('UserBuyerSettings', 'id',  array('tdsUid'=>$this->userId),'','','',1);
			if(isset($res[0]->id) && $res[0]->id > 0){
				$this->model_common->editDataFromTabel('UserBuyerSettings', $UserBuyerSettings, 'id', $res[0]->id);
			}else{
				$this->model_common->addDataIntoTabel('UserBuyerSettings', $UserBuyerSettings);
			}
			$msg = $this->lang->line('updatedBuyerBilling');
			echo json_encode(array('msg'=>$msg));
		}
	}
	function saveBuyershipping(){
		
		$userId = $this->userId;
		$config = array(
			array(
				 'field'   => 'shipping_firstName',
				 'label'   => 'First Name',
				 'rules'   => 'trim|xss_clean'
			  ),
			array(
				 'field'   => 'shipping_lastName',
				 'label'   => 'Last Name',
				 'rules'   => 'trim|xss_clean'
			  ),   
			array(
				 'field'   => 'shipping_companyName',
				 'label'   => 'Company Name',
				 'rules'   => 'trim|xss_clean'
			  ),   
						
			array(
				 'field'   => 'shipping_address1',
				 'label'   => 'Address1',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'shipping_address2',
				 'label'   => 'Address2',
				 'rules'   => 'trim|xss_clean'
			  ),
			  array(
				 'field'   => 'shipping_city',
				 'label'   => 'City Name',
				 'rules'   => 'trim|xss_clean'
			  ),   
					
			array(
				 'field'   => 'shipping_state',
				 'label'   => 'State',
				 'rules'   => 'trim|xss_clean'
			  ),
			  array(
				 'field'   => 'shipping_country',
				 'label'   => 'Country',
				 'rules'   => 'trim|xss_clean'
			  ),					
			array(
				 'field'   => 'shipping_zip',
				 'label'   => 'Zip',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'shipping_phone',
				 'label'   => 'Phone',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'shipping_email',
				 'label'   => 'Email',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'shipping_isSameAsSeller',
				 'label'   => 'Same as Seller Details',
				 'rules'   => 'trim|xss_clean'
			  ),
			 array(
				 'field'   => 'shipping_isSameAsBilling',
				 'label'   => 'Same as Billing Details',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'payConsumptionTax',
				 'label'   => 'pay consumption tax',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'EuVatIdentificationNumber',
				 'label'   => 'EU VAT Identification Number',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'otherAboutConsumptionTax',
				 'label'   => 'Others',
				 'rules'   => 'trim|xss_clean'
			  )
            );

		$this->form_validation->set_rules($config); 
		if($this->form_validation->run())
		{
			$shipping_isSameAsBilling=set_value('shipping_isSameAsBilling')=='t'?'t':'f';
			$shipping_isSameAsSeller=set_value('shipping_isSameAsSeller')=='t'?'t':'f';
				$shipping_firstName = set_value('shipping_firstName');
				$shipping_lastName = set_value('shipping_lastName');
				$shipping_address1 = set_value('shipping_address1');
				$shipping_address2 = set_value('shipping_address2');
				$shipping_city = set_value('shipping_city');
				$shipping_state = set_value('shipping_state');
				$shipping_country = set_value('shipping_country')>0?set_value('shipping_country'):0;
				$shipping_zip = set_value('shipping_zip');
				$shipping_phone = set_value('shipping_phone');
				$shipping_email = set_value('shipping_email');
			
			$UserBuyerSettings = array(
				'tdsUid' => $this->userId,
				'shipping_firstName' => $shipping_firstName,
				'shipping_lastName' 	=> $shipping_lastName,
				'shipping_companyName' => $shipping_companyName,
				'shipping_address1' => $shipping_address1,
				'shipping_address2' => $shipping_address2,
				'shipping_city' => $shipping_city,
				'shipping_state' => $shipping_state,
				'shipping_country' => $shipping_country,
				'shipping_zip' => $shipping_zip,
				'shipping_phone' => $shipping_phone,
				'shipping_email' => $shipping_email,
				'shipping_isSameAsBilling' => $shipping_isSameAsBilling,
				'shipping_isSameAsSeller' => $shipping_isSameAsSeller,
			);
			$res=$this->model_common->getDataFromTabel('UserBuyerSettings', 'id',  array('tdsUid'=>$this->userId),'','','',1);
			if(isset($res[0]->id) && $res[0]->id > 0){
				$this->model_common->editDataFromTabel('UserBuyerSettings', $UserBuyerSettings, 'id', $res[0]->id);
			}else{
				$this->model_common->addDataIntoTabel('UserBuyerSettings', $UserBuyerSettings);
			}
			
			$msg = $this->lang->line('updatedBuyerShipping');
			echo json_encode(array('msg'=>$msg));
		}
	}
	function sellerSettings(){
		$userId = $this->userId;
		$config = array(
			array(
				 'field'   => 'seller_address1',
				 'label'   => 'Address1',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'seller_address2',
				 'label'   => 'Address2',
				 'rules'   => 'trim|xss_clean'
			  ),
			  array(
				 'field'   => 'seller_city',
				 'label'   => 'City Name',
				 'rules'   => 'trim|xss_clean'
			  ),   
					
			array(
				 'field'   => 'seller_state',
				 'label'   => 'State',
				 'rules'   => 'trim|xss_clean'
			  ),
			  array(
				 'field'   => 'seller_zip',
				 'label'   => 'Zip',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'seller_phone',
				 'label'   => 'Phone',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'seller_isSameAsBuyer',
				 'label'   => 'Same as Buyer Details',
				 'rules'   => 'trim|xss_clean'
			  ),				
							
			array(
				 'field'   => 'seller_currency',
				 'label'   => 'Currency',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'chargeConsumptionTax',
				 'label'   => 'Charge consumption tax',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'territory',
				 'label'   => 'Territory',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'territoryCountryId',
				 'label'   => 'Territory Country',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'isTaxSameForAllStats',
				 'label'   => 'Is the tax the same for all States, Provinces or Regions?',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'identificationNumber',
				 'label'   => 'Identification Number',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'paypalId',
				 'label'   => 'paypal Id',
				 'rules'   => 'trim|xss_clean'
			  )
			  ,				
			array(
				 'field'   => 'paypalStreet',
				 'label'   => 'Address Line 1',
				 'rules'   => 'trim|xss_clean'
			  )
			  ,				
			array(
				 'field'   => 'paypalZip',
				 'label'   => 'ZIP or Post Code',
				 'rules'   => 'trim|xss_clean'
			  )
			  ,				
			array(
				 'field'   => 'allStateTaxName',
				 'label'   => 'Name of Tax',
				 'rules'   => 'trim|xss_clean'
			  )	
			   ,				
			array(
				 'field'   => 'allStateTaxPercentage',
				 'label'   => 'Tax Percentage',
				 'rules'   => 'trim|xss_clean'
			  )	
            );

		$this->form_validation->set_rules($config); 
		if($this->input->post('sellerSettings')=='sellerSettings' && $this->form_validation->run())
		{
			$seller_currency=set_value('seller_currency') > 0 ?set_value('seller_currency'):0;
			$territory=set_value('territory') > 0 ?set_value('territory'):0;
			$isTaxSameForAllStats=set_value('isTaxSameForAllStats')=='t'?'t':'f';
			$territoryCountryId=set_value('territoryCountryId') > 0 ?set_value('territoryCountryId'):0;
			
			$StateWise=$this->input->post('StateWise');
			//echo '<pre />';print_r($StateWise);
			$ConsumptionTax=array();
			if(is_array($StateWise) && count($StateWise) > 0){
				
				foreach($StateWise as $id){
					$countryId=($territory==0)?$territoryCountryId:$id;
					$stateId=($territory==0)?$id:0;
					$taxName=($isTaxSameForAllStats=='t')?$this->input->post('allStateTaxName'):$this->input->post('StateWiseTaxName'.$id);
					$taxPercentage=($isTaxSameForAllStats=='t')?$this->input->post('allStateTaxPercentage'):$this->input->post('StateWiseTaxPercentage'.$id);
					$ConsumptionTax[]=array(
											'userId'=>$this->userId,
											'countryId'=>$countryId,
											'stateId'=>$stateId,
											'taxName'=>$taxName,
											'taxPercentage'=>$taxPercentage,
											'lastModifyDate'=>currntDateTime()
									  );
				}
				//echo '<pre />';print_r($ConsumptionTax);
				$this->model_common->editDataFromTabel('ConsumptionTax', array('isDeleted'=>'t'), array('userId'=>$this->userId));
				$this->model_common->insertBatch('ConsumptionTax', $ConsumptionTax);
			}else{
				
				$taxName=$this->input->post('allStateTaxName');
				$taxPercentage=$this->input->post('allStateTaxPercentage');
				if(isset($taxPercentage)&& $$taxPercentage!=''){
				$ConsumptionTax[]=array(
											'userId'=>$this->userId,
											'countryId'=>$territoryCountryId,
											'stateId'=>0,
											'taxName'=>$taxName,
											'taxPercentage'=>$taxPercentage,
											'lastModifyDate'=>currntDateTime()
									  );
				$this->model_common->editDataFromTabel('ConsumptionTax', array('isDeleted'=>'t'), array('userId'=>$this->userId));
				$this->model_common->insertBatch('ConsumptionTax', $ConsumptionTax);
				}
			}
			
			$UserSellerSettings = array(
				'tdsUid' => $this->userId,
				'seller_address1' => set_value('seller_address1'),
				'seller_address2' => set_value('seller_address2'),
				'seller_city' => set_value('seller_city'),
				'seller_state' => set_value('seller_state'),
				'seller_zip' => set_value('seller_zip'),
				'seller_phone' => set_value('seller_phone'),
				'seller_isSameAsBuyer' => set_value('seller_isSameAsBuyer')=='t'?'t':'f', 
				'seller_currency' => $seller_currency,
				'chargeConsumptionTax' => set_value('chargeConsumptionTax')=='t'?'t':'f',  
				'territory' => set_value('territory') > 0 ?set_value('territory'):0,
				'territoryCountryId' => $territoryCountryId,
				'isTaxSameForAllStats' => $isTaxSameForAllStats,
				'identificationNumber' => set_value('identificationNumber'),
				'paypalId'=> set_value('paypalId'),
				'paypalZip'=> set_value('paypalZip'),
				'paypalStreet'=> set_value('paypalStreet'), 
				'verify_status'=> @$this->input->post('verify_status'), 
				'verify_detail'=>  @$this->input->post('verify_detail')
			);
			//echo '<pre />';print_r($UserSellerSettings);
			$res=$this->model_common->getDataFromTabel('UserSellerSettings', 'id',  array('tdsUid'=>$this->userId),'','','',1);
			if(isset($res[0]->id) && $res[0]->id > 0){				
				$this->model_common->editDataFromTabel('UserSellerSettings', $UserSellerSettings, 'id', $res[0]->id);
			}else{
				$this->model_common->addDataIntoTabel('UserSellerSettings', $UserSellerSettings);
			}
			$this->session->set_userdata(array('seller_currency'=> $seller_currency));
			$msg = $this->lang->line('updatedSellerSettings');
			set_global_messages($msg, $type='success', $is_multiple=true);
		}
	}
	
	function deleteAccount(){
		if($this->input->post('deleteAccount') == 'deleteAccount'){
			$this->userId=$this->isLoginUser();
			$userProjects=$this->findUserProjectsAndMoveInTrash($this->userId);
			$this->model_common->editDataFromTabel('UserAuth', array('active'=>2), array('tdsUid'=>$this->userId));
			redirect('auth/logout');
		}
	}
	
	private function findUserProjectsAndMoveInTrash($userId=0){
		if($userId > 0){
			$whereField=array('(item).userid'=>$userId,'isdeleted'=>'f');
			$userProjects=$this->model_common->getDataFromTabel('search','id,entityid,elementid,projectid,ispublished',  $whereField);
			$entityWiseProject=false;
			if($userProjects){
				$this->model_common->editDataFromTabel('search',array('ispublished'=>'f','isdeleted'=>'t','datemodified'=>currntDateTime()),  $whereField);
				foreach($userProjects as $k=>$projects){
					$entityWiseProject[$projects->entityid][]=$projects->elementid;
				}
			}
			
			if($entityWiseProject){
				foreach($entityWiseProject as $entityId=>$elementId){
					$projectField=getProjectField($entityId);
					if($projectField){
						$projectField['elementId']=$elementId;
						$this->model_dashboard->UserProjectsMoveInTrash($projectField);
					}
				}
			}
		}
	}
	
	function backUserAccount($userId=0){
		$this->userId=$this->isLoginUser();
		if(is_numeric($userId) && $userId > 0){
			
			$userProjects=$this->findUserProjectsAndMoveFromTrash($userId);
			//move user in deleted mode 
			$this->model_common->editDataFromTabel('UserAuth', array('active'=>1), array('tdsUid'=>$userId));
		}
	}
	
	private function findUserProjectsAndMoveFromTrash($userId=0){
		if($userId > 0){
			$whereField=array('(item).userid'=>$userId,'isdeleted'=>'t');
			$userProjects=$this->model_common->getDataFromTabel('search','id,entityid,elementid,projectid',  $whereField);
			$entityWiseProject=false;
			if($userProjects){
				$this->model_common->editDataFromTabel('search',array('ispublished'=>'t','isdeleted'=>'f','datemodified'=>currntDateTime()),  $whereField);
				foreach($userProjects as $k=>$projects){
					$entityWiseProject[$projects->entityid][]=$projects->elementid;
				}
			}
			
			if($entityWiseProject){
				foreach($entityWiseProject as $entityId=>$elementId){
					$projectField=getProjectField($entityId);
					if($projectField){
						$projectField['elementId']=$elementId;
						$this->model_dashboard->UserProjectsMoveFromTrash($projectField);
					}
				}
			}
		}
	}
	
	/*
	 * Function to check Secondary email with existing emails
	 */ 
	function checkEmail(){
		$secondaryEmail = $this->input->post('newEmail');
		//$emailResult = $this->model_dashboard->checNewEmail($secondaryEmail);
		
		//get login users secondary email
		$getSecondaryEmail = $this->model_common->getDataFromTabel('UserAuth', 'new_email',  array('tdsUid'=>$this->userId),'','','',1);
		if($getSecondaryEmail[0]->new_email!=$secondaryEmail){
			
			//Check email with existing emails
			$checkResult = $this->model_dashboard->checkExistingEmails($secondaryEmail);
			if ($checkResult) {
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 1;
		}
	}
	
	/*
	 * Function to activate secondary email address
	 */ 
	function activateSecondaryEmail($userId=0,$activeKey=0){
		if(isset($userId) && !empty($userId) && isset($activeKey) && !empty($activeKey)){
			$userData = $this->model_common->getDataFromTabel('UserAuth', '*',  array('tdsUid'=>$userId,'new_email_key'=>$activeKey),'','','',1);
			if(!empty($userData[0]->new_email_key) && isset($userData[0]->new_email_key) && $activeKey==$userData[0]->new_email_key){
				$updateSecondaryEmail = $this->model_common->editDataFromTabel('UserAuth', array('new_email_key'=>'verified'), array('tdsUid'=>$userId));
				if($updateSecondaryEmail){
					$msg = $this->lang->line('activeSecEmail');
					//set_global_messages($msg, $type='success', $is_multiple=true);
					$this->session->set_flashdata('verifiedEmailPopup',$msg);
					//$this->session->set_userdata('verifiedEmailMsg',$msg);
					redirect(site_url().'home');
					//redirect(site_url().'common/verifySecondaryEmail');
					
				}else{
					redirectToNorecord404();
				}
			}else{
				$msg = $this->lang->line('alreadyVerifiedSec');
				$this->session->set_flashdata('verifiedEmailPopup',$msg);
				//$this->session->set_userdata('verifiedEmailMsg',$msg);
				//set_global_messages($msg, $type='error', $is_multiple=true);
				redirect(site_url().'home');
				//redirect(site_url().'common/verifySecondaryEmail');
			}
		}else{
			redirectToNorecord404();
		}
	}
	
	/*
	 * Function to replace Emails
	 */ 
	function swapEmail(){
		$userId = $this->userId;
		$primaryEmail = $this->input->post('primaryEmail');
		$secondaryEmail = $this->input->post('secondaryEmail');
		if(isset($userId) && !empty($userId) && !empty($primaryEmail) && !empty($secondaryEmail)){
			$updateEmailPosition = $this->model_common->editDataFromTabel('UserAuth', array('email'=>$secondaryEmail,'new_email'=>$primaryEmail), array('tdsUid'=>$userId));
			$msg = $this->lang->line('successfullySwapEmail');
			if($updateEmailPosition){
				echo 1;
				set_global_messages($msg, $type='success', $is_multiple=true);
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	} 
	
	/*
	 * Function to get sections index pages
	 */
	function sectionIndexPages($section='') {
		switch($section) {
		case 'PerformanceEvent':
			$data[0]['pageLabel'] = 'Event <br />Index Page';
			$data[0]['pageUrl'] = site_url().'event/events/';
			$data[1]['pageLabel'] = 'Launch <br />Index Page';
			$data[1]['pageUrl'] = site_url().'event/launch/launchdetail/';
			$data[2]['pageLabel'] = 'Event <br /> with Launch <br />Index Page';
			$data[2]['pageUrl'] = site_url().'event/eventwithlaunch/eventwithlaunchdetail';
			$data[3]['pageLabel'] = 'Event <br /> Notification <br /> Index Page';
			$data[3]['pageUrl'] = site_url().'event/eventnotifications/notificationslist';
		break;
		case 'filmNvideo':
			$data[0]['pageLabel'] = 'Film & Video <br />Index Page';
			$data[0]['pageUrl'] = site_url().'media/filmNvideo';
		break;
		case 'musicNaudio':
			$data[0]['pageLabel'] = 'Music & Audio <br />Index Page';
			$data[0]['pageUrl'] = site_url().'media/musicNaudio';
		break;
		case 'photographyNart':
			$data[0]['pageLabel'] = 'Photography <br /> & Art <br />Index Page';
			$data[0]['pageUrl'] = site_url().'media/photographyNart';
		break;
		case 'writingNpublishing':
			$data[0]['pageLabel'] = 'Writing & Publishing <br />Index Page';
			$data[0]['pageUrl'] = site_url().'media/writingNpublishing';
			$data[1]['pageLabel'] = 'News Index Page';
			$data[1]['pageUrl'] = site_url().'media/news';
			$data[2]['pageLabel'] = 'Reviews Index  Page';
			$data[2]['pageUrl'] = site_url().'media/reviews';
		break;
		case 'educationMaterial':
			$data[0]['pageLabel'] = 'Educational Material <br />Index Page';
			$data[0]['pageUrl'] = site_url().'media/educationMaterial';
		break;
		case 'blog':
			$data[0]['pageLabel'] = 'Blog <br />Index Page';
			$data[0]['pageUrl'] = site_url().'blog/index';
		break;
		case 'showcase':
			$data[0]['pageLabel'] = 'Showcase  <br />Homepage';
			$data[0]['pageUrl'] = site_url().'showcase/showcaseForm';
		break;
		case 'workprofile':
			$data[0]['pageLabel'] = 'Work Profile <br />Index Page';
			$data[0]['pageUrl'] = site_url().'workprofile';
		break;
		case 'work':
			$data[0]['pageLabel'] = 'Work Offered <br />Index Page';
			$data[0]['pageUrl'] = site_url().'work';
			$data[1]['pageLabel'] = 'Work Wanted <br />Index Page';
			$data[1]['pageUrl'] = site_url().'work/wanted';
		break;
		case 'product':
			$data[0]['pageLabel'] = 'Products For Sale <br />Index Page';
			$data[0]['pageUrl'] = site_url().'product/sell';
			$data[1]['pageLabel'] = 'Products Wanted <br />Index Page';
			$data[1]['pageUrl'] = site_url().'product/wanted';
			$data[2]['pageLabel'] = 'Free Products <br />Index Page';
			$data[2]['pageUrl'] = site_url().'product/freeStuff';
		break;
		case 'upcomingprojects':
			$data[0]['pageLabel'] = 'Upcoming <br />Index Page';
			$data[0]['pageUrl'] = site_url().'upcomingprojects';
		break;
		case 'competition':
			$data[0]['pageLabel'] = 'Competition <br />Index Page';
			$data[0]['pageUrl'] = site_url().'competition/competitionlist';
		break;
		case 'competitionentry':
			$data[0]['pageLabel'] = 'Competition Entry <br />Index Page';
			$data[0]['pageUrl'] = site_url().'competition/competitionentrylist';
		break;
		case 'advertise':
			$data[0]['pageLabel'] = 'advertise <br />Index Page';
			$data[0]['pageUrl'] = site_url().'advertising/index';
		break;
		case 'collaboration':
			$data[0]['pageLabel'] = 'collaboration <br />Index Page';
			$data[0]['pageUrl'] = site_url().'collaboration/index';
		break;
		default:
		$data[0]['pageLabel'] = '';
		$data[0]['pageUrl'] = '';
		}
		return $data;
	}
	/**
	 * add social media links 
	 * @access public
	 */
	public function addSocialMedia() {
		
		/* set post values */
		$valuesArray = array(
			'socialLink'=>$this->input->post('socialLink'),
			'profileSocialLinkType'=>$this->input->post('profileSocialLinkType'),
			'entityId'=>0,
			'socialLinkArchived'=>'f',
			'position'=>$this->input->post('profileSocialLinkType')>0?$this->input->post('profileSocialLinkType'):1,
			'socialLinkDateCreated'=>date("Y-m-d H:i:s"),
			'socialLinkDateModified'=>date("Y-m-d H:i:s"),
			'userId'=>$this->userId,
		);
		
		$profileSocialLinkId = $this->input->post('profileSocialLinkId');
		if(!empty($profileSocialLinkId)) {
			$valuesArray['profileSocialLinkId'] = $profileSocialLinkId;
			$msg = 'You have successfully update Social Media';
		} else {
			$msg = 'You have successfully save Social Media';
		}
		/* manage social media data saving */
		$mediaId = $this->model_dashboard->addSocialMediaData($valuesArray);
		
		set_global_messages($msg, $type='success', $is_multiple=false);
		
	}
	
	/**
	 * remove social media data
	 * @access public
	 */
	public function removeSocialMedia() {
		/* set social link id */
		$profileSocialLinkId = $this->input->post('profileSocialLinkId');
		$removeData = $this->model_dashboard->removeSocialMediaData($profileSocialLinkId);
		echo $removeData;die;
	}
	
	/**
	 * manage profile and showcase section for social media
	 * @access public
	 */
	public function manageMediaSection() {
		/* set showcase id of user */
		$showcaseId = LoginUserDetails('showcaseId');
		/* set workprofile id of user */
		$workprofileData = getUserWorkProfileId($this->userId); 
		$workprofileId = $workprofileData[0]->workProfileId;
		
		/* set social media section ids */
		$sectionIds = $this->input->post('sectionIds');
		/* set social media section saved ids */
		$savedViewsectionIds = $this->input->post('savedViewsectionIds');
		if(!empty($savedViewsectionIds)) {
			$savedViewsectionIds = explode(',',$savedViewsectionIds);
		}
		/* get unmatched value of array */
		//$unmatchedArray = array_diff($sectionIds,$savedViewsectionIds);
		$unmatchedArray = $savedViewsectionIds;
		

		/* unset workprofile or shocase ids for social media data*/
		if(is_array($unmatchedArray) && count($unmatchedArray)>0) {
			
			for($j=0;$j<count($unmatchedArray);$j++) {
				/* saperate link id and type id */
				$expValues[$j] = explode('_',$unmatchedArray[$j]);
				if($expValues[$j][1] == 1) {
					$data[$j]['showcaseId'] = 0;
				} else {
					$data[$j]['workProfileId'] = 0;
				}
				/* update sections */
				$this->model_dashboard->updateSocialMediaSections($expValues[$j][0],$data[$j]);
			}
		}
		
		if(is_array($sectionIds) && count($sectionIds)>0) {
		
			for($i=0;$i<count($sectionIds);$i++) {
				/* saperate link id and type id */
				$expValue[$i] = explode('_',$sectionIds[$i]);
				
				if($expValue[$i][1] == 1) {
					$data[$i]['showcaseId'] = $showcaseId;
				} else {
					$data[$i]['workProfileId'] = $workprofileId;
				}
				/* update sections */
				$this->model_dashboard->updateSocialMediaSections($expValue[$i][0],$data[$i]);
			}
		}
		
		$msg = 'You have successfully save Social Media';
		set_global_messages($msg, $type='success', $is_multiple=false);
		
	}
	
	/* Save currency for seller */
	function saveSellerCurrency($currency=0){
		$userId = $this->userId;			
		$UserSellerSettings = array(
		'tdsUid' => $this->userId, 				
		'seller_currency' => $currency			
		);
		
		$res=$this->model_common->getDataFromTabel('UserSellerSettings', 'id',  array('tdsUid'=>$this->userId),'','','',1);
		if(isset($res[0]->id) && $res[0]->id > 0){				
			$this->model_common->editDataFromTabel('UserSellerSettings', $UserSellerSettings, 'id', $res[0]->id);
		}else{
			$this->model_common->addDataIntoTabel('UserSellerSettings', $UserSellerSettings);
		}
		$this->session->set_userdata(array('seller_currency'	=> $currency));
		$data['currency'] = $currency;
		$this->load->view('seller_saved_currency',$data);			
	}
	
	/* Save currency Form for seller */
	function showCurrencyForm(){
		$userId = $this->userId;
		$res=$this->model_common->getDataFromTabel('UserSellerSettings', 'seller_currency',  array('tdsUid'=>$this->userId),'','','',1);
		if(isset($res[0]->seller_currency) && $res[0]->seller_currency > 0){
			$data['seller_currency'] = $res[0]->seller_currency ;
		}else{
			$data['seller_currency'] = 0;
			}	
		$this->load->view('seller_currency_form.php',$data);	
	}
	
/* Save serrels Paypal Info */
	function savePaypalInfo(){	
		$paypalId=$this->input->post('val1');
		$paypalFirstName=$this->input->post('val2');	
		$paypalLastName=$this->input->post('val3');	
		$verify_detail=$this->input->post('val4');	
		$userId = $this->userId;
		/*$config = array(			
			array(
				 'field'   => 'paypalId',
				 'label'   => 'paypal Id',
				 'rules'   => 'trim|xss_clean'
			  )
			  ,				
			array(
				 'field'   => 'paypalStreet',
				 'label'   => 'Address Line 1',
				 'rules'   => 'trim|xss_clean'
			  )
			  ,				
			array(
				 'field'   => 'paypalZip',
				 'label'   => 'ZIP or Post Code',
				 'rules'   => 'trim|xss_clean'
			  )
            );
            
		$this->form_validation->set_rules($config); */
				$UserSellerSettings = array(
				'tdsUid' => $this->userId,				
				'paypalId'=> $paypalId,
				'paypalZip'=> $paypalFirstName,
				'paypalStreet'=> $paypalLastName, 
				'verify_status'=> 'TRUE', 
				'verify_detail'=>  $verify_detail
			  );			
			$res=$this->model_common->getDataFromTabel('UserSellerSettings', 'id',  array('tdsUid'=>$this->userId),'','','',1);
			if(isset($res[0]->id) && $res[0]->id > 0){				
				$this->model_common->editDataFromTabel('UserSellerSettings', $UserSellerSettings, 'id', $res[0]->id);
			}else{
				$this->model_common->addDataIntoTabel('UserSellerSettings', $UserSellerSettings);
			}
	
		}

 /* Save seller info */
 function saveSellerSettings(){
		$userId = $this->userId;
		$config = array(
			array(
				 'field'   => 'seller_address1',
				 'label'   => 'Address1',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'seller_address2',
				 'label'   => 'Address2',
				 'rules'   => 'trim|xss_clean'
			  ),
			  array(
				 'field'   => 'seller_city',
				 'label'   => 'City Name',
				 'rules'   => 'trim|xss_clean'
			  ),   
					
			array(
				 'field'   => 'seller_state',
				 'label'   => 'State',
				 'rules'   => 'trim|xss_clean'
			  ), 
			  array(
				 'field'   => 'seller_zip',
				 'label'   => 'Zip',
				 'rules'   => 'trim|xss_clean'
			  ),				
			array(
				 'field'   => 'seller_phone',
				 'label'   => 'Phone',
				 'rules'   => 'trim|xss_clean'
			  ),				
			
			array(
				 'field'   => 'seller_companyName',
				 'label'   => 'Company Name',
				 'rules'   => 'trim|xss_clean'
			  ),
			
			array(
				 'field'   => 'detail_type',
				 'label'   => 'Same as Buyer Details',
				 'rules'   => 'trim|xss_clean'
			  )
			
            );
            
            

		$this->form_validation->set_rules($config); 
		if($this->form_validation->run())
		{
			$UserSellerSettings = array(
				'tdsUid' => $this->userId,
				'seller_address1' => set_value('seller_address1'),
				'seller_address2' => set_value('seller_address2'),
				'seller_city' => set_value('seller_city'),
				'seller_state' => set_value('seller_state'),
				'seller_zip' => set_value('seller_zip'),
				'seller_phone' => set_value('seller_phone'),
				'seller_companyName' => set_value('seller_companyName'),
			);
			$detail_type =  set_value('detail_type') ;  
			if(isset($detail_type) && ($detail_type=='seller_isSameAsBuyer')){
				$UserSellerSettings['seller_isSameAsBuyer'] ='t';
				$UserSellerSettings['seller_isSameAsShipping'] ='f';
			}elseif(isset($detail_type) && ($detail_type=='seller_isSameAsShipping')){
				$UserSellerSettings['seller_isSameAsShipping'] ='t';
				$UserSellerSettings['seller_isSameAsBuyer'] ='f';
			}
			
			$res=$this->model_common->getDataFromTabel('UserSellerSettings', 'id',  array('tdsUid'=>$this->userId),'','','',1);
			if(isset($res[0]->id) && $res[0]->id > 0){				
				$this->model_common->editDataFromTabel('UserSellerSettings', $UserSellerSettings, 'id', $res[0]->id);
			}else{
				$this->model_common->addDataIntoTabel('UserSellerSettings', $UserSellerSettings);
			}
			$msg = 'You have successfully updated your Seller Settings';
			echo json_encode(array('msg'=>$msg));
		}
	}

	/**
	 * manage consumption tax data
	 * @access public
	 */	
	public function saveConsumptionTax() {
		
		$userSellerData = $this->model_common->getDataFromTabel('UserSellerSettings', 'id',  array('tdsUid'=>$this->userId),'','','',1);
		
		if($this->input->post('consumptionCharge')=='consumptionCharge') { 
			/* manage consumption charge data store */
			$this->manageConsumptionCharge($userSellerData);
			
		} else if($this->input->post('consumptionStateTax')=='consumptionStateTax') {
			/* manage states consumption tax data store */
			$this->manageConsumptionStateTax($userSellerData);
				
		} else {
			$UserSellerSettings = array('identificationNumber' => $this->input->post('identificationNumber'),'chargeConsumptionTax'=>'f');
			if(isset($userSellerData[0]->id) && $userSellerData[0]->id > 0){				
				$this->model_common->editDataFromTabel('UserSellerSettings', $UserSellerSettings, 'id', $userSellerData[0]->id);
			}else{
				$this->model_common->addDataIntoTabel('UserSellerSettings', $UserSellerSettings);
			}
		}
		$msg = $this->lang->line('updatedSellerSettings');
		set_global_messages($msg, $type='success', $is_multiple=true);
		redirect(site_url().'dashboard/globalsettings/4');
	}
	
	/**
	 * Manage consumption charge 
	 * @access private
	 */
	private function manageConsumptionCharge($userSellerData) {
		/* set  territory id */
		$territory = $this->input->post('territory');
		$territoryCountryId = $this->input->post('territoryCountryId');
		$taxName = $this->input->post('allStateTaxName');
		$taxPercentage = $this->input->post('allStateTaxPercentage');
		$StateWise = $this->input->post('states');
		if(!empty($taxName) && !empty($taxPercentage)) {
			if(is_array($StateWise) && count($StateWise) > 0 && $territory==0){
				
				foreach($StateWise as $id){
					$countryId=($territory==0)?$territoryCountryId:$id;
					$stateId=($territory==0)?$id:0;
					$ConsumptionTax[] = array(
											'userId'=>$this->userId,
											'countryId'=>$countryId,
											'stateId'=>$stateId,
											'taxName'=>$taxName,
											'taxPercentage'=>$taxPercentage,
											'lastModifyDate'=>currntDateTime()
									  );
				}
				
				$this->model_common->editDataFromTabel('ConsumptionTax', array('isDeleted'=>'t'), array('userId'=>$this->userId));
				$this->model_common->insertBatch('ConsumptionTax', $ConsumptionTax);
			} else if($territory==1) {
				/* get eu countries */
				$euCountiesList = euCountiesList();
				
				foreach($euCountiesList as $id=>$key){
					$ConsumptionTax[]=array(
											'userId'=>$this->userId,
											'countryId'=>$id,
											'stateId'=>0,
											'taxName'=>$taxName,
											'taxPercentage'=>$taxPercentage,
											'lastModifyDate'=>currntDateTime()
										  );
				}
					$this->model_common->editDataFromTabel('ConsumptionTax', array('isDeleted'=>'t'), array('userId'=>$this->userId));
					$this->model_common->insertBatch('ConsumptionTax', $ConsumptionTax);
			
			} else {
				$msg = 'Please select State, Provence, Region of country!';
				set_global_messages($msg, $type='error', $is_multiple=true);
				redirect(site_url().'dashboard/globalsettings/4');
			}
		} else {
			$msg = 'Please fill Tax name and pecentage details!';
			set_global_messages($msg, $type='error', $is_multiple=true);
			redirect(site_url().'dashboard/globalsettings/4');
			
		}
		
		/* update user seller territory data */
		$UserSellerSettings = array('territory' => $territory,'territoryCountryId' => $this->input->post('territoryCountryId'),'isTaxSameForAllStats'=>'t','chargeConsumptionTax'=>'t');
		if(isset($userSellerData[0]->id) && $userSellerData[0]->id > 0){				
			$this->model_common->editDataFromTabel('UserSellerSettings', $UserSellerSettings, 'id', $userSellerData[0]->id);
		} else {
			$this->model_common->addDataIntoTabel('UserSellerSettings', $UserSellerSettings);
		}
	}
	
	/**
	 * Manage consumption state tax charges 
	 * @access private
	 */
	private function manageConsumptionStateTax($userSellerData) {
		$StateWise = $this->input->post('StateWise');
		if(is_array($StateWise) && count($StateWise) > 0){
			
			foreach($StateWise as $id) {
				$countryId = $this->input->post('stateCountryId');
				$stateId = $id;
				$taxName = $this->input->post('StateWiseTaxName'.$id);
				$taxPercentage = $this->input->post('StateWiseTaxPercentage'.$id);
				if(!empty($taxName) && !empty($taxPercentage)) {
					$ConsumptionTax[]=array(
										'userId'=>$this->userId,
										'countryId'=>$countryId,
										'stateId'=>$stateId,
										'taxName'=>$taxName,
										'taxPercentage'=>$taxPercentage,
										'lastModifyDate'=>currntDateTime()
								);
				}
			}
			if(is_array($ConsumptionTax)) {
				$this->model_common->editDataFromTabel('ConsumptionTax', array('isDeleted'=>'t'), array('userId'=>$this->userId));
				$this->model_common->insertBatch('ConsumptionTax', $ConsumptionTax);
			} else {
				$msg = 'Please fill Tax name and pecentage details!';
				set_global_messages($msg, $type='error', $is_multiple=true);
				redirect(site_url().'dashboard/globalsettings/4');
			}
			/* update user seller territory data */
			$UserSellerSettings = array('territoryCountryId' => $this->input->post('stateCountryId'),'isTaxSameForAllStats'=>'f','chargeConsumptionTax'=>'t');
			if(isset($userSellerData[0]->id) && $userSellerData[0]->id > 0){				
				$this->model_common->editDataFromTabel('UserSellerSettings', $UserSellerSettings, 'id', $userSellerData[0]->id);
			}else{
				$this->model_common->addDataIntoTabel('UserSellerSettings', $UserSellerSettings);
			}
		}
	}
	
	/**
	 * set consumption tax charge form
	 * @access public
	 */
	public function consumptionStateTaxHtml() {
		$stateArray = $this->input->post('stateList');
		$stateHtml = '<ul class="fs13 width100_per overview slect_coustom slect_menu defaultP" >';
		 
		if(is_array($stateArray)) {
			for($i=0;$i<count($stateArray);$i++) {
				$stateData = $this->model_common->getDataFromTabel('MasterStates', 'stateName',  array('stateId'=>$stateArray[$i]),'','','',1);
				$taxStateData = $this->model_common->getDataFromTabel('ConsumptionTax', 'taxName,taxPercentage',  array('stateId'=>$stateArray[$i],'isDeleted'=>'f'),'','','',1);
				$taxName = '';
				$taxPercentage = '';
				$checked = '';
				if(!empty($taxStateData) && is_array($taxStateData)) {
					$taxName = $taxStateData[0]->taxName;
					$taxPercentage = $taxStateData[0]->taxPercentage;
					$checked = 'checked';
				}
				/* prepare state states html */
				$stateHtml .= '
				<li id="StateWiseTaxLI'.$stateArray[$i].'" class="StateWiseTaxLI">
					<label>
						<input '.$checked.' type="checkbox" name="StateWise[]" onclick="disbaleEnableRow(this, '.$stateArray[$i].');" id="checkboxStates'.$stateArray[$i].'" class="checkboxStatesTax ez-hide" value="'.$stateArray[$i].'" />
						<span>
						'.$stateData[0]->stateName.'
					  </span>
					</label>
					
					<input type="text" value="'.$taxName.'" class="font_wN mr15 width_175" name="StateWiseTaxName'.$stateArray[$i].'" id="StateWiseTaxName'.$stateArray[$i].'" />
					
					<input type="text" value="'.$taxPercentage.'" class="font_wN  width_65" name="StateWiseTaxPercentage'.$stateArray[$i].'" id="StateWiseTaxPercentage'.$stateArray[$i].'" />
					% 
				</li>';
			}
		}
		$stateHtml .= '</ul>';
		/* add default checkbox script */
		$stateHtml .= '<script type="text/javascript">runTimeCheckBox(); $("#slider7").tinycarousel({ axis: "y", display: 1});	</script>';
		echo $stateHtml;
	}
	
	/**
	 * get state list for seller setting
	 * @access public
	 */
	public function getConsumptionStatesList() {
		$countryId=$this->input->post('val1');
		$data['ConsumptionTax']=$this->input->post('val2');
		$data['statesList']=getStatesList($countryId);
		$this->load->view('dashboard/consumption_states_list',$data);
	} 

	/*Pickup details */	
	function shippingPickupInfo(){
		$userId = $this->userId;
		$config = array(
			array(
				 'field'   => 'seller_pickupcity',
				 'label'   => 'City',
				 'rules'   => 'trim|required|xss_clean'
			  ),				
			array(
				 'field'   => 'seller_pickupzip',
				 'label'   => 'Post Code or ZIP Code',
				 'rules'   => 'trim|required|xss_clean'
			  ),
			  array(
				 'field'   => 'seller_pickupsuberb',
				 'label'   => 'Suburb',
				 'rules'   => 'trim|required|xss_clean'
			  ),   
					
			array(
				 'field'   => 'seller_pickupdesc',
				 'label'   => 'Special Pickup Requirements',
				 'rules'   => 'trim|required|xss_clean'
			  )
            );

		$this->form_validation->set_rules($config); 
		if($this->form_validation->run())
		{			
			$UserPickupSettings = array(
				'tdsUid' => $this->userId,
				'pickup_country' => $this->input->post('seller_pickupcountry'),
				'pickup_state' => $this->input->post('seller_pickupstate'),
				'pickup_city' => set_value('seller_pickupcity'),
				'pickup_zip' => set_value('seller_pickupzip'),
				'pickup_subrub' => set_value('seller_pickupsuberb'),
				'pickup_requirements' => set_value('seller_pickupdesc'),				
			);
			
			$res=$this->model_common->getDataFromTabel('UserSellerSettings', 'id',  array('tdsUid'=>$this->userId),'','','',1);
			if(isset($res[0]->id) && $res[0]->id > 0){				
				$this->model_common->editDataFromTabel('UserSellerSettings', $UserPickupSettings, 'id', $res[0]->id);
			}else{
				$this->model_common->addDataIntoTabel('UserSellerSettings', $UserPickupSettings);
			}
			$msg = 'You have successfully updated your Pickup Shipping Details';
			echo json_encode(array('msg'=>$msg));
		}
	}

/*Pickup Domestic shipping */
function getDomesticState(){
	$data['domestic_country']=$this->input->post('domestic_shippingcountry') ;
	$data['deliveryInformation']=$this->input->post('delivery_information') ;	
	$states=$this->model_common->getDataFromTabel('ProjectShippingDomestic', 'stateId',  array('userId'=>$this->userId),'','','',1);
	if(isset($states[0]->stateId)){
		$states = $states[0]->stateId;
	} else {
		$states;
		}
	$data['states']=json_decode($states);	
	$this->load->view('seller_domestic_shipping',$data);	   
	}


/*Save domestic states  */
	function saveDomesticState(){
		
		$domesticStates = $this->input->post('state');
		$countryId = $this->input->post('countryId');
		$checked_all = $this->input->post('checked_all');
		$checked_all = isset($checked_all) ? $checked_all :'' ;
		$deliveryInformation = $this->input->post('deliveryInformation');
		if(isset($domesticStates) && is_array($domesticStates) && count($domesticStates)){
			
			$stateArray = array();
			foreach($domesticStates as $key=>$value){
				 if($value!=''){
					$stateArray[$key] = $value;
				 }			
				}
			if($checked_all==true){
				$stateArray['checked_all'] = 1;
				}			 
		    $states = json_encode($stateArray);
			$userDomesticStates = array(
				'userId' => $this->userId,
				'countryId' => $countryId,
				'stateId' => $states,
				'deliveryInformation' => $deliveryInformation
			);
			
			$res=$this->model_common->getDataFromTabel('ProjectShippingDomestic', 'id',  array('userId'=>$this->userId),'','','',1);
			if(isset($res[0]->id) && $res[0]->id > 0){
				$this->model_common->editDataFromTabel('ProjectShippingDomestic', $userDomesticStates, 'id', $res[0]->id);
			}else{
				$this->model_common->addDataIntoTabel('ProjectShippingDomestic', $userDomesticStates);
			}		
			$msg = 'You have successfully updated your Domestic Shipping States';
			echo json_encode(array('msg'=>$msg));
			}
		}
    
}//End Class
?>
