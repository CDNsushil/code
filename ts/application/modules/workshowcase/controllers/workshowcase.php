<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 * Todasquare frontend Controller Class
 *
 *  Manage Showcase Details ( Workshowcase)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 *
 **/
 
class workshowcase extends MX_Controller {
	private $workData = array();
	private $dirCacheMedia = '';
	private $dirUploadMedia = '';
	private $userId = null;
	private $IndustryId = 0;
	private $ispublished = 1;
	private $work = 'Work';	
	private $workMediaTableName = 'workPromotionMedia';	
	private $promoImageField = array('mediaId',
			'mediaType',
			'mediaTitle',
			'mediaDescription',
			'fileId',
			'projId',
			'isMain');
	/**
	 * Constructor
	 */
	 
	 function __construct() {
		 
		//Load required Model, Library, language and Helper files
			$load = array(
				'model'		=> 'model_workshowcase',  	
				'language' 	=> 'work',							
				//'config'		=>	'media/media' 
				'library' 	=> 'lib_sub_master_media'  		
			);
			
			parent::__construct($load);		
			
			$this->head->add_css($this->config->item('system_css').'frontend.css');
			$this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
			//$this->head->add_js($this->config->item('frontend_js').'jquery.anythingslider.js');
			$this->head->add_js($this->config->item('frontend_js').'jquery.tinycarousel.min.js');
			$this->head->add_js($this->config->item('frontend_js').'jquery-gallery-cdn.js');
			
			$this->dirCacheMedia = ROOTPATH.'cache/workshowcase/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/workshowcase/'; 
			$this->workData['dirUploadMedia'] = $this->dirUploadMedia;
			$this->userId= isLoginUser()?isLoginUser():0;
			//add advertising module if exists
			if(is_dir(APPPATH.'modules/advertising')){
				$this->load->model(array('advertising/model_advertising'));
			}
	}
		
	/**
	 * Index fucntion by default call when Controller initialised
	 *
	 * by default call function for Writing and Publishing project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function index($userId=0,$workId=0) {
		$this->isLoginUser();
		$userId = ($userId==0)?isLoginUser():$userId;
		//echo $userId;die;
		$passWorkData = $this->getWorks($userId,$workId);
		$this->template_front_end->load('template_front_end','work',$passWorkData);
	}
	
	public function preview($userId=0,$id=0,$mathod='works') 
	{
		if($this->userId > 0 && ($userId==$this->userId)){
			
		}else{
			redirect('home');
		}
		$this->$mathod($userId,$id,$preview=1);
	}
	
	
	public function works($userId=0,$workId=0,$preview=0) {
		//echo "replacer==".$this->config->item("wanted", $index = "replacer");
		//$this->config->set_item("wanted", "sushil", $index="replacer");
		$userId = ($userId==0)?isLoginUser():$userId;
		$passWorkData = $this->getWorks($userId,$workId,$preview);
		$norecord = true;
		$passWorkData['currentWorkDetail'] = array();
		if($workId==0){
			$passWorkData['currentWorkDetail'] = isset($passWorkData['work_array'][0])?$passWorkData['work_array'][0]:null;
			$norecord = false;
		}
		else{
			foreach ($passWorkData['work_array'] as $key =>$work_array_record) {
				if($work_array_record['workId'] == $workId) { 
					$passWorkData['currentWorkDetail'] = $work_array_record;
					$norecord = false;
				}
			}
		}
		/*Get section id */
		$sectionId = $this->config->item('worksSectionId');
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($sectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($sectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($sectionId,3,1);
			$passWorkData['advertSectionId'] = $sectionId; //set advert section id
			//Load view of advert js functions
			$passWorkData['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$sectionId),true);
		} 
		
		$breadCrumWorkType='';
		if(isset($passWorkData['currentWorkDetail']['workType']) && ($passWorkData['currentWorkDetail']['workType']!=''))
		$breadCrumWorkType = ucfirst($passWorkData['currentWorkDetail']['workType']);		
		$passWorkData['workProfileId']=$this->model_workshowcase->checkWorkProfile($userId);		
		$this->config->set_item("works", 'Work '.$breadCrumWorkType, $index="replacer");
		$breadcrumbItem=array('showcase','works');
		$breadcrumbURL=array('showcase/aboutme/'.$userId,'workshowcase/works/'.$userId);
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$passWorkData['breadcrumbString']=$breadcrumbString;
		$passWorkData['userId']=$userId;
		
		if($norecord == true)
			redirectToNorecord404();
		else
			$this->template_front_end->load('template_front_end','work',$passWorkData);
		
	}
	
	public function viewproject($userId=0,$workId=0) {
		
		$userId = ($userId==0)?isLoginUser():$userId;
		/*Get section id */
		$sectionId = $this->config->item('worksSectionId');
		/*Get Entity id */
		$viewEntityId = getMasterTableRecord('TDS_Work');
		/* Update view count */
		if((!empty($viewEntityId)) && (!empty($workId))){
			$proId = $workId;
			manageViewCount($viewEntityId,$workId,$userId,$proId,$sectionId);
		}
		
		$passWorkData = $this->getWorks($userId,$workId);
		$norecord = true;
		$passWorkData['currentWorkDetail'] = array();
		if($workId==0){
			$passWorkData['currentWorkDetail'] = $passWorkData['work_array'][0];
			$norecord = false;
		}
		else{
			foreach ($passWorkData['work_array'] as $key =>$work_array_record) {
				if($work_array_record['workId'] == $workId) { 
					$passWorkData['currentWorkDetail'] = $work_array_record;
					$norecord = false;			
				}
			}
		}
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($sectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($sectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($sectionId,3,1);
			$passWorkData['advertSectionId'] = $sectionId; //set advert section id
			//Load view of advert js functions
			$passWorkData['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$sectionId),true);
			
		} 
		
		$breadCrumWorkType='';
		if(isset($passWorkData['currentWorkDetail']['workType']) && ($passWorkData['currentWorkDetail']['workType']!=''))
		$breadCrumWorkType = ucfirst($passWorkData['currentWorkDetail']['workType']);
		
		$this->config->set_item("viewproject", 'Work '.$breadCrumWorkType, $index="replacer");
				
		$passWorkData['workProfileId']=$this->model_workshowcase->checkWorkProfile($userId);
		$passWorkData['userId']=$userId;
		if($norecord == true)
			redirectToNorecord404();
		else
			$this->template_front_end->load('template_front_end','work',$passWorkData);
		
	}
	
	public function getWorks($userId=0,$workId=0,$preview=0) {		
	
		$loggedUserId=$this->userId>0?$this->userId:0;
		$checkPublished=( ($userId==$loggedUserId) && isset($preview) && $preview ==1)?false:true;
		
		$orderby = 'elementId';		
		$elementOrderBy = 'modifyDate';		
		$orderBy = '';		
		$order = 'DESC';
		
		$fetchFields = 'projId,projBaseImgPath';		
		$fetchElementFields = '';
		
		$this->workData['workEntityId'] = getMasterTableRecord($this->work);
		$this->workData['mediaEntityId'] = getMasterTableRecord($this->workMediaTableName);
		$this->workData['work_array'] =  $this->model_workshowcase->getWorks($userId,$checkPublished);
		
		if($workId==0) $workId = @$this->workData['work_array'][0]['workId'];
		
		$defaultImage_m = $defaultImage_s = $this->config->item('defaultNoMediaImg');
		
		/*
		 if(strcmp(@$this->workData['work_array'][0]['workType'],'wanted')==0){
			$defaultImage_m = $this->config->item('defaultWorkWanted_m');
			$defaultImage_s = $this->config->item('defaultWorkWanted_s');
		}
		else{
			$defaultImage_m = $this->config->item('defaultWorkOffered_m');
			$defaultImage_s = $this->config->item('defaultWorkOffered_s');
		}
		*/
				
		$this->workData['defaultWorkId'] = $workId;
				
		$this->workData['promo_images'] = $this->lib_sub_master_media->entitypromotionmedialist($this->workMediaTableName,$this->promoImageField,'workId',$workId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		$imagesExists = 0;
		if(!empty($this->workData['promo_images'])){
			foreach($this->workData['promo_images'] as $k=> $PUImg)
				{					
					$promoThumbImage_m = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_m');
					if(!file_exists($promoThumbImage_m)) $this->workData['promo_images'][$k]['noMedia'] = 1;
					else $this->workData['promo_images'][$k]['noMedia'] = 0;	
						$imagesExists = 1;
						$promoThumbImage_s = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_s');											
						$this->workData['promo_images'][$k]['thumbFinalImg_m'] = getImage(@$promoThumbImage_m,$defaultImage_m);
						$this->workData['promo_images'][$k]['thumbFinalImg_s'] = getImage(@$promoThumbImage_s,$defaultImage_s);
					
				}
			
			$this->workData['promo_images']['workType'] = @$this->workData['work_array'][0]['workType'];
		}
		if($imagesExists ==0) $this->workData['promo_images'] =array();
		//echo '<pre />';print_r($this->workData['promo_images']);die;
		$this->workData['promo_video'] = $this->lib_sub_master_media->entitypromotionmedialist($this->workMediaTableName,$this->promoImageField,'workId',$workId,2,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		//$whereClause = array('workId'=>$workId,'mediaType'=>2);
		//$this->workData['promo_video'] = getDataFromTabel($this->workMediaTableName,'fileId',$whereClause);
		return $this->workData;		
	}
	
	public function popupimages() {
		
		$orderBy = '';		
		$workId = $this->input->get('val1');
		$activeRecord = $this->input->get('val2');
		$workType = $this->input->get('val3');
		/*
		if(strcmp(@workType,'wanted')==0){
			$defaultImage_m = $this->config->item('defaultWorkWanted_m');
			$defaultImage_s = $this->config->item('defaultWorkWanted_s');
		}
		else{
			$defaultImage_m = $this->config->item('defaultWorkOffered_m');
			$defaultImage_s = $this->config->item('defaultWorkOffered_s');
		}
		*/
		$defaultImage_m = $defaultImage_s = $this->config->item('defaultNoMediaImg');		
		$imagesExists = 0;		
		$popupImages['promo_images'] = $this->lib_sub_master_media->entitypromotionmedialist($this->workMediaTableName,$this->promoImageField,'workId',$workId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		
		/*
		foreach($popupImages['promo_images']  as $upcomingPUImg)
		{
			$promoThumbImage = addThumbFolder(@$upcomingPUImg['filePath'].@$upcomingPUImg['fileName'],'_m');											
		//	$popupImages['thumbFinalImg'] = getImage(@$promoThumbImage,$defaultImage);
		}
		*/
		foreach($popupImages['promo_images'] as $k=> $PUImg)
		{					
			$promoThumbImage_m = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_b');	
			if(!file_exists($promoThumbImage_m)) $popupImages['promo_images'][$k]['noMedia'] = 1;
			else $popupImages['promo_images'][$k]['noMedia'] = 0;										
				$imagesExists = 1;
				$promoThumbImage_s = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_s');											
				$popupImages['promo_images'][$k]['thumbFinalImg_m'] = getImage(@$promoThumbImage_m,$defaultImage_m);
				$popupImages['promo_images'][$k]['thumbFinalImg_s'] = getImage(@$promoThumbImage_s,$defaultImage_s);
			
		}
		
		$popupImages['activeRecord'] = 	$activeRecord;
		
		//If no file exists in folder for the current record
		if($imagesExists ==0) $popupImages['promo_images'] = array();
		$this->load->view('popup_images',$popupImages);//load template with media view
			
	}	
}

