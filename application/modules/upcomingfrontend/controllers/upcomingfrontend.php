<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Todasquare frontend Controller Class
 *
 *  Manage Frontend Details (Upcoming Projects)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */
class upcomingfrontend extends MX_Controller {
	private $data = array();
	private $userId = null;
	private $IndustryId = 0;
	private $ispublished = 1;
	private $upcomingProjectMediaTableName = 'TDS_UpcomingProjectMedia';	
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
				'model'		=> 'upcomingfrontend/model_upcomingfrontend',  	
				'language' 	=> 'upcomingprojects',		
				'library' 	=> 'lib_sub_master_media + pagination_new_ajax'		
			);
			parent::__construct($load);		
			
			$this->userId = isLoginUser();
			
			$this->dirUploadUpcoming = 'media/'.LoginUserDetails('username').'/upcomingfrontend/'; 
			$this->dirCacheUpcoming = ROOTPATH.'cache/upcomingfrontend/'; 			
			$this->head->add_js($this->config->item('frontend_js').'jquery.tinycarousel.min.js');
			$this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
			$this->head->add_js($this->config->item('frontend_js').'jquery-gallery-cdn.js');
			//$this->head->add_js($this->config->item('frontend_js').'jquery.anythingslider.js');
			//$this->IndustryId=$this->getIndustryId($this->router->fetch_method());
			
			//add advertising module if exists
			if(is_dir(APPPATH.'modules/advertising')){
				$this->load->model(array('advertising/model_advertising'));
			}
	}
	
	/**
	 * Index fucntion by default call when Controller initialised
	 *
	 * by default call function for upcoming project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function index() 
	{
		$userId = $this->isLoginUser();
		$this->upcoming($userId,0);
	}
	
	public function preview($userId=0,$id=0,$mathod='upcoming') 
	{
		$this->isLoginUser();
		if($this->userId > 0 && ($userId==$this->userId)){
			
		}else{
			redirectToNorecord404();
		}
		$this->$mathod($userId,$id);
	}
	
	public function upcoming($userId=0,$upcomingprojId=0) 
	{		
		$projectData = $this->getProject($userId,$upcomingprojId);
		/* Update view count */
		$viewEntityId = getMasterTableRecord('TDS_UpcomingProject');
		if((!empty($viewEntityId)) && (!empty($upcomingprojId))){
			$sectionId = $this->config->item('upcomingSectionId');
			manageViewCount($viewEntityId,$upcomingprojId,$userId,$upcomingprojId,$sectionId);
		}	
		$projectData['userId'] = $userId;	
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Get upcoming section id
			$sectionId = $this->config->item('upcomingSectionId');
			//Get banner records based on section and advert type
			$bannerType2 = $this->model_advertising->getBannerRecords($sectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($sectionId,3,1);
			$bannerType4 = $this->model_advertising->getBannerRecords($sectionId,4,1);
			$projectData['advertSectionId'] = $sectionId; //set advert section id
			//Load view of advert js functions
			$projectData['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'bannerType4'=>$bannerType4,'sectionId'=>$sectionId),true);
		} 
		
		$breadcrumbItem = array('showcase','upcoming');
		$breadcrumbURL = array('showcase/aboutme/'.$userId,'upcomingfrontend/upcoming/'.$userId);
		$breadcrumbString = set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$projectData['breadcrumbString'] = $breadcrumbString;
		$projectData['upcomingprojId'] = $upcomingprojId;
		$projectData['userId']=$userId;
		
		$this->template_front_end->load('template_front_end','upcoming_frontend',$projectData);
	}
	
	public function viewprojectold($userId=0,$upcomingprojId=0) 
	{		
		$projectData = $this->getProjectold($userId,$upcomingprojId);
		$projectData['userId']=$userId;
		/* Update view count */
		$viewEntityId = getMasterTableRecord('TDS_UpcomingProject');
		if((!empty($viewEntityId)) && (!empty($upcomingprojId))){
			$sectionId = $this->config->item('upcomingSectionId');
			manageViewCount($viewEntityId,$upcomingprojId,$userId,$upcomingprojId,$sectionId);
		}
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')){
			$sectionId = $this->config->item('upcomingSectionId');
			
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($sectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($sectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($sectionId,3,1);
			$projectData['advertSectionId'] = $sectionId; //set advert section id
			//Load view of advert js functions
			$projectData['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$sectionId),true);	
			
		} 	
		$this->template_front_end->load('template_front_end','view_project',$projectData);			
	}
	
	public function viewproject($userId=0,$upcomingprojId=0) 
	{		
		$projectData = $this->getProject($userId,$upcomingprojId);
		$projectData['userId']=$userId;
		/* Update view count */
		$viewEntityId = getMasterTableRecord('TDS_UpcomingProject');
		if((!empty($viewEntityId)) && (!empty($upcomingprojId))){
			$sectionId = $this->config->item('upcomingSectionId');
			manageViewCount($viewEntityId,$upcomingprojId,$userId,$upcomingprojId,$sectionId);
		}
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')){
			$sectionId = $this->config->item('upcomingSectionId');
			
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($sectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($sectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($sectionId,3,1);
			$projectData['advertSectionId'] = $sectionId; //set advert section id
			//Load view of advert js functions
			$projectData['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$sectionId),true);	
			
		} 	
		// get user's upcoming projects
		$upcomingRecord = $this->model_upcomingfrontend->getupcomingdetail($frontendUserId,$upcomingprojId);
		$projectData['upcomingProjData'] = $upcomingRecord[0];
		$this->new_version->load('new_version','new_version/view_project',$projectData);	
		 //call model for project data
        $projectDataList    =    $this->model_media->projectlist($frentendUserId,$industryType,0);		
	}
	
	
	public function getProject($userId=0,$upcomingprojId=0) 
	{		
		
		$moduleMathod=$this->router->fetch_method();
		$preview=($moduleMathod=='preview')?1:0;
		$this->ispublished=$checkPublished=( ($userId==$this->userId) && isset($preview) && $preview ==1)?false:true;
		
		$this->data['entityId'] = getMasterTableRecord('UpcomingProject');	
		$this->data['mediaEntityId'] = getMasterTableRecord('TDS_UpcomingProjectMedia');	
		
		$this->data['upcomingListing'] = $this->model_upcomingfrontend->getValuesFromUpcomingProjects($userId,$this->ispublished,'projId,projTitle');
		
		if($upcomingprojId == 0) $upcomingprojId = @$this->data['upcomingListing'][0]['projId'];
		
		//$this->data['upcomingRecord'] = $this->model_upcomingfrontend->getValueToUpdate($upcomingprojId,$userId,$this->ispublished);
		
		//if(count($this->data['upcomingRecord'])<=0) 	
			//redirectToNorecord404();
		
		$orderBy = '';
		$this->data['promoMedias'] = $this->lib_sub_master_media->entitypromotionmedialist($this->upcomingProjectMediaTableName,$this->promoImageField,'projId',$upcomingprojId,1,$orderBy,'flag');		
		
		$this->data['promoImages'] = $this->lib_sub_master_media->entitypromotionmedialist($this->upcomingProjectMediaTableName,$this->promoImageField,'projId',$upcomingprojId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		//echo '<pre />';print_r($this->data);
		
		$imagesExists = 0;
		if(!empty($this->data['promoImages'])) {
		$defaultImage_m = $this->config->item('defaultNoMediaImg');	
		$defaultImage_s = $this->config->item('defaultNoMediaImg');
			
		foreach($this->data['promoImages'] as $k=> $PUImg)
		{					
			$promoThumbImage_m = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_b');	
			if(!file_exists($promoThumbImage_m)) $this->data['promoImages'][$k]['noMedia'] = 1;
			else $this->data['promoImages'][$k]['noMedia'] = 0;
													
				$imagesExists = 1;
				$promoThumbImage_s = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_s');											
				$this->data['promoImages'][$k]['thumbFinalImg_m'] = getImage(@$promoThumbImage_m,$defaultImage_m);
				$this->data['promoImages'][$k]['thumbFinalImg_s'] = getImage(@$promoThumbImage_s,$defaultImage_s);
				//$this->data['promoImages'][$k]['mediaEntityId'] = $this->data['mediaEntityId'];
			
		}
		}
		$this->data['promoImages']['activeRecord'] = 	$upcomingprojId;
		
		//If no file exists in folder for the current record
		if($imagesExists ==0) $this->data['promoImages'] = array();
		//echo '<pre />';print_r($this->data['promoImages']);
		//$this->data['upcomingRecord'] = object2array($this->data['upcomingRecord']);	
		return $this->data;
					
	}
	
	public function getProjectold($userId=0,$upcomingprojId=0) 
	{		
		
		$moduleMathod=$this->router->fetch_method();
		$preview=($moduleMathod=='preview')?1:0;
		$this->ispublished=$checkPublished=( ($userId==$this->userId) && isset($preview) && $preview ==1)?false:true;
		
		$this->data['entityId'] = getMasterTableRecord('UpcomingProject');	
		$this->data['mediaEntityId'] = getMasterTableRecord('TDS_UpcomingProjectMedia');	
		
		$this->data['upcomingListing'] = $this->model_upcomingfrontend->getValuesFromUpcomingProjects($userId,$this->ispublished,'projId,projTitle');
		
		if($upcomingprojId == 0) $upcomingprojId = @$this->data['upcomingListing'][0]['projId'];
		
		$this->data['upcomingRecord'] = $this->model_upcomingfrontend->getValueToUpdate($upcomingprojId,$userId,$this->ispublished);
		
		if(count($this->data['upcomingRecord'])<=0) 	
			redirectToNorecord404();
		
		$orderBy = '';
		$this->data['promoMedias'] = $this->lib_sub_master_media->entitypromotionmedialist($this->upcomingProjectMediaTableName,$this->promoImageField,'projId',$upcomingprojId,1,$orderBy,'flag');		
		
		$this->data['promoImages'] = $this->lib_sub_master_media->entitypromotionmedialist($this->upcomingProjectMediaTableName,$this->promoImageField,'projId',$upcomingprojId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		//echo '<pre />';print_r($this->data);
		
		$imagesExists = 0;
		if(!empty($this->data['promoImages'])) {
		$defaultImage_m = $this->config->item('defaultNoMediaImg');	
		$defaultImage_s = $this->config->item('defaultNoMediaImg');
			
		foreach($this->data['promoImages'] as $k=> $PUImg)
		{					
			$promoThumbImage_m = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_b');	
			if(!file_exists($promoThumbImage_m)) $this->data['promoImages'][$k]['noMedia'] = 1;
			else $this->data['promoImages'][$k]['noMedia'] = 0;
													
				$imagesExists = 1;
				$promoThumbImage_s = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_s');											
				$this->data['promoImages'][$k]['thumbFinalImg_m'] = getImage(@$promoThumbImage_m,$defaultImage_m);
				$this->data['promoImages'][$k]['thumbFinalImg_s'] = getImage(@$promoThumbImage_s,$defaultImage_s);
				//$this->data['promoImages'][$k]['mediaEntityId'] = $this->data['mediaEntityId'];
			
		}
		}
		$this->data['promoImages']['activeRecord'] = 	$upcomingprojId;
		
		//If no file exists in folder for the current record
		if($imagesExists ==0) $this->data['promoImages'] = array();
		//echo '<pre />';print_r($this->data['promoImages']);
		$this->data['upcomingRecord'] = object2array($this->data['upcomingRecord']);
		
				
		return $this->data;
					
	}
	
	public function getPromoImages($imagearray=array()) 
	{		
		$this->data['promoImages'] = $imagearray;	
		
		$this->load->view('promo_images',$this->data['promoImages']);//load template with media view
			
	}
	
	public function popupimages() 
	{		
		$orderBy = '';
		
		$upcomingprojId = $this->input->get('val1');
		
		$activeRecord = $this->input->get('val2');
		$defaultImage = $this->config->item('defaultNoMediaImg');	
		$popupImages['popupImages'] = $this->lib_sub_master_media->entitypromotionmedialist($this->upcomingProjectMediaTableName,$this->promoImageField,'projId',$upcomingprojId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		foreach($popupImages['popupImages'] as $k=> $PUImg)
		{					
			$promoThumbImage_m = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_b');	
			if(!file_exists($promoThumbImage_m)) $popupImages['popupImages'][$k]['noMedia'] = 1;
			else $popupImages['popupImages'][$k]['noMedia'] = 0;
													
				$imagesExists = 1;
				$promoThumbImage_original= @$PUImg['filePath'].@$PUImg['fileName'];
				$promoThumbImage_l= addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_l');
				$promoThumbImage_xs = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_xs');											
				$promoThumbImage_s = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_s');											
				$popupImages['popupImages'][$k]['org'] = getImage(@$promoThumbImage_original,$defaultImage);
				$popupImages['popupImages'][$k]['l'] = getImage(@$promoThumbImage_l,$defaultImage);
				$popupImages['popupImages'][$k]['m'] = $popupImages['popupImages'][$k]['thumbFinalImg_m'] = getImage(@$promoThumbImage_m,$defaultImage);
				$popupImages['popupImages'][$k]['xs'] = getImage(@$promoThumbImage_xs,$defaultImage);
				$popupImages['popupImages'][$k]['thumbFinalImg_s'] = getImage(@$promoThumbImage_s,$defaultImage);							
		}
		
		$popupImages['activeRecord'] = 	$activeRecord;
		
		$this->load->view('popup_images',$popupImages);		   //load template with media view
			
	}
	
	public function popupFurDesc() 
	{
			
		$orderBy = '';
		
		$upcomingprojId = $this->input->get('val1');
		$userId = $this->input->get('val2');
		$craveCount = $this->input->get('val3');
		$viewCount = $this->input->get('val4');
		$ratingAvg = $this->input->get('val5');
		
		$upcomingRecord['upcomingRecord'] = $this->model_upcomingfrontend->getValueToUpdate($upcomingprojId,$userId,$this->ispublished,'projId,projTitle,proShortDesc');
		
		$ratingAvg=roundRatingValue($ratingAvg);
		$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';		
		$upcomingRecord['viewCount'] = $viewCount;
		$upcomingRecord['craveCount'] = $craveCount;
		$upcomingRecord['ratingImg'] = $ratingImg;
		$upcomingRecord['upcomingRecord'] = object2array($upcomingRecord['upcomingRecord']);
		
		$this->load->view('further_description_popup',$upcomingRecord);//load template with media view
			
	}
	
	public function popupMedia() 
	{		
		$orderBy = '';
		
		$mediaId = $this->input->get('val1');
		$promoMedias['mediaId']=$mediaId;
		
		$mediaType = $this->input->get('val2');
		$promoMedias['mediaType']=$mediaType;
		
		$promoMedias['mediaType']=$mediaType;
		
		$promoMedias['mediaEntityID']=$this->input->get('val3');
		
		$promoMedias['promoMedias'] = $this->lib_sub_master_media->entitypromotionmedialist($this->upcomingProjectMediaTableName,$this->promoImageField,'mediaId',$mediaId,$mediaType,$orderBy);
				
		if($mediaType==4)
			$this->load->view('upcoming_doc_popup',$promoMedias);//load template with media view
		else if($mediaType==3)	  
			$this->load->view('upcoming_audio_popup',$promoMedias);//load template with media view
		else
			$this->load->view('upcoming_video_popup',$promoMedias);//load template with media view
			
	}
	
	//----------------------------------------------------------------------
    
    /*
    *  @access: private
    *  @description: This method is use to manage edit listing of upcoming projects
    *  @auther: tosif qureshi
    *  @return: string
    */ 
    public function upcomingprojects($userId=0) {
		
        $this->data['projectCollectionResult'] = $this->upcomingprojectsresults(true,$userId);
        $this->data['packagestageheading'] = $this->lang->line('editYourMediaShowcase');
        $this->new_version->load('new_version','media_project_new',$this->data);
	}
	
	
	//-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get user's upcoming projects
     * @access: public
     * @return: void
     */
    public function upcomingprojectsresults($loadView=false,$frontendUserId=0) {
		
		 // check if correct uesrId entered 
        if(!$this->iscorrectuserid($frontendUserId)):
            redirectToNorecord404();
        else:
            //get user id
            $frontendUserId =  $this->iscorrectuserid($frontendUserId);
        endif;
		
        $isSetCookie = setPerPageCookie('searchPerPageVal',$this->config->item('perPageRecord'));	
        $pages = new Pagination_new_ajax;
        // get project's elements list
        // get user's upcoming projects
		$upcomingProjectsRes = $this->model_upcomingfrontend->getupcomingdetail($frontendUserId,0,1,'f');
    
        $pages->items_total = count($upcomingProjectsRes);
        $this->data['perPageRecord'] = $this->config->item('perPageRecord');
        $pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$isSetCookie;
        $pages->paginate();
        // get projects list
        $upcomingProjects = $this->model_upcomingfrontend->getupcomingdetail( $frontendUserId,0,1,'f',$pages->offst,$pages->limit);

        $this->data['items_total'] = $pages->items_total;
        $this->data['items_per_page'] = $pages->items_per_page;
        $this->data['pagination_links'] = $pages->display_pages();
        $pages->paginate($isShowButton=true,$isShowNumbers=false);
        $this->data['frontendUserId']       =   $frontendUserId; // set frentendUserId
        $this->data['projectListingData']   = $upcomingProjects;
        $this->data['loggedUserId']     =   isLoginUser()?isLoginUser():0;	//load language data
        
        $searchResultView = $this->load->view('media_project_new_view_list',$this->data,$loadView);
       if($loadView){
            return $searchResultView;
        }
    }
    
    //------------------------------------------------------------------------
    
    /*
     * @access: private
     * @description: This method is use to check userId is correct
     * @param:  $userId
     * @return: boolean (TRUE/FALSE)
     */  
    private function iscorrectuserid($userId=0){
               
        if(is_numeric($userId)):
            $userId    =   $userId>0?$userId:frentendUserId();
        else:
            $userId   =   0;    
        endif;
        return $userId;
    }
	
	
}

/* End of file upcomingfrontend.php */
/* Location: ./application/module/upcomingfrontend/upcomingfrontend.php */
