<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Todasquare frontend Controller Class
 *
 *  manage frontend details (Film & Video, Music & Audio, Photography & Art,
 *	 Writing & publishing, Education Material)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
 
class mediafrontend extends MX_Controller {
	private $data = array();
	private $dirCacheMedia = '';
	private $dirUploadMedia = '';
	private $userId = null;
	/**
	 * Constructor
	 */
	 function __construct() {
		//Load required Model, Library, language and Helper files
			$load = array(
				'model'		=> 'media/model_media',  	
				'language' 	=> 'media + reviews',						
				'library' 	=> 'pagination_new_ajax',						
				'config'	=>	'media/media + mediafrontend/mediafrontend'   		
			);
			parent::__construct($load);		
		    $this->userId= isLoginUser()?isLoginUser():0;
			// Load  path of css and cache file path
			$this->dirCacheMedia = 'cache/media/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/project/'; 
			$this->data['dirUploadMedia'] = $this->dirUploadMedia; 
			//this->head->add_css($this->config->item('frontend_css').'anythingslider.css');		
			//$this->head->add_js($this->config->item('frontend_js').'jquery-gallery-cdn.js');
			//add advertising module if exists
			if(is_dir(APPPATH.'modules/advertising')){
				$this->load->model(array('advertising/model_advertising'));
			}
	}

	/*============================Film and Video Section==================================================*/	
	/**
	 * Index fucntion by default call when Controller initialised
	 *
	 * by default call function for film & Video project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function index() {
		$this->writingpublishing();
	}



	//
	public function writingpublishing($userId=0, $projectId=0, $elementId=0,$method='writingpublishing') {
		
		$this->getProject($method,$userId,$projectId,$elementId,'writingNpublishing');
	}

	//
	public function filmvideo($userId=0, $projectId=0, $elementId=0,$method='filmvideo') {
		$this->getProject($method,$userId,$projectId,$elementId,'filmNvideo');
	}

	//
	public function musicaudio($userId=0, $projectId=0, $elementId=0,$method='musicaudio') {
		$this->getProject($method,$userId,$projectId,$elementId,'musicNaudio');
	}

	//
	public function photographyart($userId=0, $projectId=0, $elementId=0,$method='photographyart') {
		$this->getProject($method,$userId,$projectId,$elementId,'photographyNart');
	}

	//
	public function educationmaterial($userId=0, $projectId=0, $elementId=0,$method='educationmaterial') {
		$this->getProject($method,$userId,$projectId,$elementId,'educationMaterial');
	}

	public function news($userId=0, $projectId=0, $elementId=0,$method='news') {
		
		$this->getProject($method,$userId,$projectId,$elementId,'news');
	}


	public function reviews($userId=0, $projectId=0, $elementId=0,$method='reviews') {
		$this->getProject($method,$userId,$projectId,$elementId,'reviews');
	}


	public function searchresult($userId=0, $projectId=0, $elementId=0,$method='writingpublishing',$newsReviewSection='') {
		if(!is_numeric($elementId) &&  strlen($elementId)>5){
			$method=$elementId;
		}
		$industryType=@$this->config->item($method.'_projectType')?$this->config->item($method.'_projectType'):'writingpublishing';
		$this->getProject($method,$userId,$projectId,$elementId,$industryType,'media_project_search','',$newsReviewSection);
	}

	public function preview($userId=0, $projectId=0, $elementId=0,$method='filmvideo') {
		$this->isLoginUser();
		if($this->userId > 0 && ($userId==$this->userId)){
			
		}else{
			redirect('home');
		}
		if(!is_numeric($elementId) &&  strlen($elementId)>5){
			$method=$elementId;
		}
		$industryType=@$this->config->item($method.'_projectType')?$this->config->item($method.'_projectType'):'filmNvideo';
		$this->getProject($method,$userId,$projectId,$elementId,$industryType,$viewPage='media_project',$preview=1);
	}
	
	function downloadfile($fileDescription=''){
		$this->userId= $this->isLoginUser();
		
		
		$FD =  decode($fileDescription);
		$FD = explode('+',$FD);

		$userId=(isset($FD[0]) && ($FD[0] >0))?$FD[0]:0; 
		$projectId=(isset($FD[1]) && ($FD[0] >1))?$FD[1]:0; 
		$industryType=isset($FD[2])?$FD[2]:'';
		
		$buyerId=(isset($FD[3]) && ($FD[3] >0))?$FD[3]:0; 
		$dwnId=(isset($FD[4]) && ($FD[4] >0))?$FD[4]:0; 
		
		
		
		if($userId > 0 && $projectId > 0 && $industryType != ''){
			
			$industryType=$this->config->item($industryType.'Industry');
			$elementTblPrefix=$this->config->item($industryType.'Prifix'); 
			$elemetTable=$elementTblPrefix.'Element';

			$entityId=getMasterTableRecord($elemetTable);
			$this->data['elemetTable']=$elemetTable;
			$this->data['entityId']=$entityId;
			$this->data['userId']=$userId;
			$this->data['projectId']=$projectId;
			$this->data['industryType']=$industryType;
			$this->data['buyerId']=$buyerId;
			$this->data['dwnId']=$dwnId;
			$this->data['fileConfig']=$this->config->item($industryType.'FileConfig');	//load language data
			
			$FD=array(
				'entityId'=>$entityId,
				'projectId'=>$projectId,
				'userId'=>$userId,
				'elementTable'=>$elemetTable,
				'dwnId'=>$dwnId
			);
			
			$this->data['elements']=$this->model_media->getDownloadFile($FD);
			
			$moduleMethod=$this->router->fetch_method();
			$breadcrumbItem[]='showcase';
			$breadcrumbURL[]='showcase/aboutme/'.$userId;
			$breadcrumbItem[]='downloadfile';
			$breadcrumbURL[]='mediafrontend/downloadfile/'.$fileDescription;
	 
			$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
			$this->data['breadcrumbString']=$breadcrumbString;
			
			$this->template_front_end->load('template_front_end','download_file_list',$this->data);
		}else{
			redirect('home');
		}
	}
	
    
    //-----------------------------------------------------------------------
    
    /*
    *  @description: This method is use to show file for download
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    function downloadfilenew($fileDescription=''){
		$this->userId= $this->isLoginUser();
		
		$FD =  decode($fileDescription);
		$FD = explode('+',$FD);

		$userId=(isset($FD[0]) && ($FD[0] >0))?$FD[0]:0; 
		$projectId=(isset($FD[1]) && ($FD[0] >1))?$FD[1]:0; 
		$industryType=isset($FD[2])?$FD[2]:'';
		
		$buyerId=(isset($FD[3]) && ($FD[3] >0))?$FD[3]:0; 
		$dwnId=(isset($FD[4]) && ($FD[4] >0))?$FD[4]:0; 
		
		
		
		if($userId > 0 && $projectId > 0 && $industryType != ''){
			
			$industryType=$this->config->item($industryType.'Industry');
			$elementTblPrefix=$this->config->item($industryType.'Prifix'); 
			$elemetTable=$elementTblPrefix.'Element';

			$entityId=getMasterTableRecord($elemetTable);
			$this->data['elemetTable']=$elemetTable;
			$this->data['entityId']=$entityId;
			$this->data['userId']=$userId;
			$this->data['projectId']=$projectId;
			$this->data['industryType']=$industryType;
			$this->data['buyerId']=$buyerId;
			$this->data['dwnId']=$dwnId;
			$this->data['fileConfig']=$this->config->item($industryType.'FileConfig');	//load language data
			
			$FD=array(
				'entityId'=>$entityId,
				'projectId'=>$projectId,
				'userId'=>$userId,
				'elementTable'=>$elemetTable,
				'dwnId'=>$dwnId
			);
			
			$this->data['elements']=$this->model_media->getDownloadFile($FD);
			
			$moduleMethod=$this->router->fetch_method();
			$breadcrumbItem[]='showcase';
			$breadcrumbURL[]='showcase/aboutme/'.$userId;
			$breadcrumbItem[]='downloadfile';
			$breadcrumbURL[]='mediafrontend/downloadfile/'.$fileDescription;
	 
			$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
			$this->data['breadcrumbString']=$breadcrumbString;
            $this->data['packagestageheading']          =   'Download Video Files';
			
			$this->new_version->load('new_version','download_file_list_new',$this->data);
		}else{
			redirect('home');
		}
	}
    
    //-----------------------------------------------------------------------
    
    
	function ppvfile($fileDescription=''){
		$this->userId= $this->isLoginUser();
		
		$FD = decode($fileDescription);
		$FD = explode('+',$FD);

		$userId=(isset($FD[0]) && ($FD[0] >0))?$FD[0]:0; 
		$projectId=(isset($FD[1]) && ($FD[0] >1))?$FD[1]:0; 
		$industryType=isset($FD[2])?$FD[2]:'';
		
		$elementId=(isset($FD[3]) && ($FD[3] >0))?$FD[3]:0; 
		$buyerId=(isset($FD[4]) && ($FD[4] >0))?$FD[4]:0; 
		$dwnId=(isset($FD[5]) && ($FD[5] >0))?$FD[5]:0; 
		
		if($userId > 0 && $projectId > 0 && $industryType != ''){
			$industryType=$this->config->item($industryType.'Industry');
			$elementTblPrefix=$this->config->item($industryType.'Prifix'); 
			$elemetTable=$elementTblPrefix.'Element';

			$entityId=getMasterTableRecord($elemetTable);
			$this->data['elemetTable']=$elemetTable;
			$this->data['entityId']=$entityId;
			$this->data['userId']=$userId;
			$this->data['projectId']=$projectId;
			$this->data['industryType']=$industryType;
			$this->data['buyerId']=$buyerId;
			$this->data['dwnId']=$dwnId;
			$this->data['fileConfig']=$this->config->item($industryType.'FileConfig');	//load language data
			
			$FD=array(
				'entityId'=>$entityId,
				'projectId'=>$projectId,
				'userId'=>$userId,
				'elementTable'=>$elemetTable,
				'elementId'=>$elementId,
				'dwnId'=>$dwnId,
				'isPPV'=>1
			);
			
			$this->data['elements']=$this->model_media->getDownloadFile($FD);
			
			$moduleMethod=$this->router->fetch_method();
			$breadcrumbItem[]='showcase';
			$breadcrumbURL[]='showcase/aboutme/'.$userId;
			$breadcrumbItem[]='ppvfile';
			$breadcrumbURL[]='mediafrontend/ppvfile/'.$fileDescription;
	 
			$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
			$this->data['breadcrumbString']=$breadcrumbString;
			
			$this->template_front_end->load('template_front_end','ppv_file_list',$this->data);
		}else{
			redirect('home');
		}
	}
    
    //---------------------------------------------------------------------
    
    /*
    *   @access: public 
    *   @descrption: This method is use to show pay per view data list
    *   @return: string
    *   @auther: lokendra meena
    */ 
    
    /*function ppvfile($fileDescription=''){
        $this->userId= $this->isLoginUser();
        
        $FD = decode($fileDescription);
        $FD = explode('+',$FD);

        $userId=(isset($FD[0]) && ($FD[0] >0))?$FD[0]:0; 
        $projectId=(isset($FD[1]) && ($FD[0] >1))?$FD[1]:0; 
        $industryType=isset($FD[2])?$FD[2]:'';
        
        $elementId=(isset($FD[3]) && ($FD[3] >0))?$FD[3]:0; 
        $buyerId=(isset($FD[4]) && ($FD[4] >0))?$FD[4]:0; 
        $dwnId=(isset($FD[5]) && ($FD[5] >0))?$FD[5]:0; 
        
        if($userId > 0 && $projectId > 0 && $industryType != ''){
            $industryType=$this->config->item($industryType.'Industry');
            $elementTblPrefix=$this->config->item($industryType.'Prifix'); 
            $elemetTable=$elementTblPrefix.'Element';
            
            $entityId=getMasterTableRecord($elemetTable);
            $this->data['elemetTable']=$elemetTable;
            $this->data['entityId']=$entityId;
            $this->data['userId']=$userId;
            $this->data['projectId']=$projectId;
            $this->data['industryType']=$industryType;
            $this->data['buyerId']=$buyerId;
            $this->data['dwnId']=$dwnId;
            $this->data['fileConfig']=$this->config->item($industryType.'FileConfig');	//load language data
            
            $FD=array(
                'entityId'=>$entityId,
                'projectId'=>$projectId,
                'userId'=>$userId,
                'elementTable'=>$elemetTable,
                'elementId'=>$elementId,
                'dwnId'=>$dwnId,
                'isPPV'=>1
            );
            
            $this->data['elements']=$this->model_media->getDownloadFile($FD);
            
            $moduleMethod=$this->router->fetch_method();
            $breadcrumbItem[]='showcase';
            $breadcrumbURL[]='showcase/aboutme/'.$userId;
            $breadcrumbItem[]='ppvfile';
            $breadcrumbURL[]='mediafrontend/ppvfile/'.$fileDescription;
     
            $breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
            $this->data['breadcrumbString']=$breadcrumbString;
            
            $this->new_version->load('new_version','ppv_file_list_new',$this->data);
        }else{
            redirect('home');
        }
    }*/
    

	public function getProject($method='',$userId=0, $projectId=0,$elementId=0,$industryType='filmNvideo',$viewPage='media_project',$preview=0,$newsReviewSection ='') {
		
		$userId=$userId>0?$userId:$this->userId;
		$projectId=is_numeric($projectId)?$projectId:0;
		
		if(!($userId > 0)){
			redirect('home');
		}
		
		if(!is_numeric($elementId) &&  strlen($elementId)>3){
			$industryType=$elementId;			
			$elementId=0;
		}
		if($method=='news' || $method=='reviews'){
			$industryType=$method;
		}
		
		$loggedUserId=$this->userId>0?$this->userId:0;
		$checkPublished=( ($userId==$loggedUserId) && $preview ==1)?false:true;
		
		$industryType=$this->config->item($industryType.'Industry');
		
		$elementTblPrefix=$this->config->item($industryType.'Prifix'); 
		$elementTbl = $elementTblPrefix.'Element';
		
		if(is_numeric($elementId) && $elementId>0){
			$mediaElementId = $elementId;
			$viewEntityId = getMasterTableRecord($elementTbl);
		}else{
			$mediaElementId = $projectId;
			$viewEntityId = getMasterTableRecord('Project');
		}
		
		/*For Manage view counts */
		if((isset($projectId)) && (!empty($projectId)) && (isset($viewEntityId)) && (isset($mediaElementId)) && (isset($industryType)) && (!empty($industryType))){
			/*Get section Id*/
			$sectionId = $this->config->item($industryType.'SectionId');
			manageViewCount($viewEntityId,$mediaElementId,$userId,$projectId,$sectionId);
		}	
		
		$langFile=$this->config->item($industryType.'Lang');
		$this->load->language($langFile); // load language file for Film and Video
		
		if(!$projectId > 0){
		
			$where=array('projectType'=>$industryType,'tdsUid'=>$userId,'isPublished'=>'t');
			$res=$this->model_common->getDataFromTabel($table='Project', $field='projId', $where, '', 'projLastModifyDate', 'DESC', $limit=1 );
			if($res){
				$projectId=$res[0]->projId;
			}else{
				if($industryType=='writingNpublishing'){
					$where=array('projectType'=>'reviews','tdsUid'=>$userId,'isPublished'=>'t');
					$res=$this->model_common->getDataFromTabel($table='Project', $field='projId', $where, '', 'projLastModifyDate', 'DESC', $limit=1 );
					if($res && isset($res[0]->projId)){
						$projectId=$res[0]->projId;
						redirect('mediafrontend/writingpublishing/'.$userId.'/'.$projectId.'/reviews');
					}else{
						$where=array('projectType'=>'news','tdsUid'=>$userId,'isPublished'=>'t');
						$res=$this->model_common->getDataFromTabel($table='Project', $field='projId', $where, '', 'projLastModifyDate', 'DESC', $limit=1 );
						if($res && isset($res[0]->projId)){
							$projectId=$res[0]->projId;
							redirect('mediafrontend/writingpublishing/'.$userId.'/'.$projectId.'/news');
						}
					}
				}
			}
		}else{
			
			//$where=array('projId'=>$projectId,'projectType'=>$industryType,'tdsUid'=>$userId,'isPublished'=>'t');
			if($preview==1){
				$where=array('projId'=>$projectId,'projectType'=>$industryType,'tdsUid'=>$userId);
			} else {
				$where=array('projId'=>$projectId,'projectType'=>$industryType,'tdsUid'=>$userId,'isPublished'=>'t');
			}
			
			$countResult=$this->model_common->countResult('Project',$where);
			if(is_numeric($countResult) && $countResult >0){
				
			}else{
				redirectToNorecord404();
			}
		}
		
		$cacheFile=$this->dirCacheMedia.$industryType.'_'.$projectId.'_User_'.$userId.'.php';
		
		@unlink($cacheFile);
		$this->writeCacheFile($userId,$industryType,$projectId);
		
		if(is_file($cacheFile)){
			require_once ($cacheFile);
			$this->data=json_decode($ProjectData, true);
		}	
		
		$this->data['loggedUserId']=$loggedUserId ;
		$this->data['checkPublished']=$checkPublished ;
		$this->data['industryType']=$industryType;
		$this->data['constant']=$this->lang->language ;
		$this->data['fileConfig']=$this->config->item($industryType.'FileConfig');	//load language data
		$this->data['method']=$this->config->item($industryType.'Sl');;
		$this->data['userId']=$userId;
		$this->data['projectId']=$projectId;
		$this->data['elementId']=$elementId;
		$this->data['projEntityId']=$this->data['entityId']=$entityId=getMasterTableRecord('Project');
		$this->data['elemetTable']=$elementTbl;
		$this->data['elementEntityId']=$elementEntityId=getMasterTableRecord($this->data['elemetTable']);
		
		/* Send section id to header to change BG color for News/Reviews */
		$currentModuleSegment = end($this->uri->segments);	
		//echo 'industryType'.$industryType;
		if($industryType=='news' || $industryType=='reviews'){
			 $this->data['newsReviewSectionBg'] = $newsReviewSection;
			 			   
		 }else{
			$this->supportingmaterial($elementEntityId, $elementId=$projectId) ;
		 }		
		$this->data['cacheFile']=$cacheFile;
	
		$moduleMethod=$this->router->fetch_method();
		$this->data['urlUsername']='';
		if(isset($this->data['projects'][0]['firstName'])){
			
			$firstName = $this->data['projects'][0]['firstName'];
			$lastName = $this->data['projects'][0]['lastName'];
			$this->data['urlUsername']=strtolower('/'.$firstName.'.'.$lastName.$userId);
			$breadcrumbItem[]=$firstName.' '.$lastName;
			$breadcrumbURL[]='showcase/aboutme/'.$userId;
		}
		
		
		
		$breadcrumbItem[]='showcase';
		$breadcrumbURL[]='showcase/aboutme/'.$userId;
		if($moduleMethod == 'searchresult'){
			$breadcrumbItem[]=$method;
			$breadcrumbURL[]='mediafrontend/'.$moduleMethod.'/'.$userId.'/'.$projectId.'/'.$method;
		}elseif($moduleMethod != $method){
			$breadcrumbItem[]=$moduleMethod;
			$breadcrumbURL[]='mediafrontend/'.$moduleMethod.'/'.$userId.'/'.$projectId;
			$breadcrumbItem[]=$method;
			$breadcrumbURL[]='mediafrontend/'.$moduleMethod.'/'.$userId.'/'.$projectId.'/'.$elementId.'/'.$method;
		}
		else{
			$breadcrumbItem[]=$moduleMethod;
			$breadcrumbURL[]='mediafrontend/'.$moduleMethod.'/'.$userId.'/'.$projectId;
		}
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Get section id
			$sectionId = $this->config->item($industryType.'SectionId');
			if($sectionId=='3:1'){
				$advertSectionId = 18; //assign advert section id for news
			} else if($sectionId=='3:2'){
				$advertSectionId = 19; //assign advert section id for reviews
			} else {
				$advertSectionId = $sectionId; 
			}
			
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($advertSectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($advertSectionId,3,1);
			$bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
			$this->data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'bannerType4'=>$bannerType4,'sectionId'=>$advertSectionId),true);
		} 
		
		
		
		$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
		$this->data['breadcrumbString']=$breadcrumbString;
		//echo $viewPage;die; 
		//echo '<pre />';print_r($this->data);
		
		
		$this->template_front_end->load('template_front_end',$viewPage,$this->data);
	}
	
	
	
	function writeCacheFile($userId,$industryType='',$projectId=0){
		$cacheFile=$this->dirCacheMedia.$industryType.'_'.$projectId.'_User_'.$userId.'.php';
		if(!is_dir($this->dirCacheMedia)){
				@mkdir($this->dirCacheMedia, 777, true);
			}
			$cmd3 = 'chmod -R 777 '.$this->dirCacheMedia;
			exec($cmd3);
			$elementTblPrefix=$this->config->item($industryType.'Prifix');
			if($industryType=='news' || $industryType=='news'){
					$orderby='elementId';
					$order='DESC';
			}else{
				$orderby='order';
				$order='ASC';
			}
			$this->data['projects']=$this->model_media->getProject($userId,$industryType,$projectId,$elementTblPrefix,$orderby,$order,$limit=1,$cacheFile);         // call getProject mathod from model:model_media 
			
			$data=str_replace("'","&apos;",json_encode($this->data));	//encode data in json format
			$stringData = '<?php $ProjectData=\''.$data.'\';?>';
			if (!write_file($cacheFile, $stringData)){					// write cache file
				 echo 'Unable to write the file';
			}
	}
	
	function getReviewList($entityId='',$projectElementId='',$craveCount='',$viewCount='',$offSet='',$perPage='',$notload=false) {
		
		$entityId=($entityId!='')?$entityId:$this->input->post('entityId');
		$projectElementId= ($projectElementId!='') ? $projectElementId : $this->input->post('projectElementId');
		$craveCount= ($craveCount!='') ? $craveCount : $this->input->post('craveCount');
		$viewCount= ($viewCount!='') ? $viewCount :$this->input->post('viewCount');
		$industryId= (isset($industryId) && $industryId!='') ?$this->input->post('industryId'):'';
		$perPage=$this->input->post('perPage');
		$offSet=$this->input->post('offSet');

		$where = array('entityId' =>$entityId,'projectElementId'=>$projectElementId,'isPublished'=>'t');
		$data['countReview']=countResult('ReviewsElement',$where);

		$data['perPage'] = $perPage;

		$data['entityId'] = $entityId;
		$data['projectElementId'] = $projectElementId;
		$data['craveCount'] =$craveCount;
		$data['viewCount'] =$viewCount;
		$data['industryId'] =$industryId;
		
		//Paginaation functionality
		$pages = new Pagination_ajax;
		$pages->items_total = $data['countReview']; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$data['perPageRecord'] = $this->config->item('perPageRecordReviews');
		//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$data['perPageRecord'];
		
		// Add by Amit to set cookie for Results per page
		if($this->input->post('ipp')!=''){
			$isCookie = setPerPageCookie('reviewPerPageVal',$data['perPageRecord']);	
		}else {
			$isCookie = getPerPageCookie('reviewPerPageVal',$data['perPageRecord']);		
		}
					
		$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
		
		$pages->paginate();
		
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();
		$data ['result']= $this->model_media->getAllReview($entityId,$projectElementId,$pages->offst,$pages->limit);
		$ajaxRequest = $this->input->post('ajaxRequest');
		if($ajaxRequest){
			$this->load->view('reviewList',$data);
		}else{
			if($notload){
				return $data['result'];
			}else{
				$this->load->view('reviewList',$data);
			}
		}
	}
	
	function getShowcaseReviewList($entityId='',$projectElementId='') {
		
		$entityId=($entityId!='')?$entityId:$this->input->post('entityId');
		$projectElementId= ($projectElementId!='') ? $projectElementId : $this->input->post('projectElementId');
		$where = array('entityId' =>$entityId,'projectElementId'=>$projectElementId,'isPublished'=>'t');
		$data['countReview']=countResult('ReviewsElement',$where);
		$data['entityId'] = $entityId;
		$data['projectElementId'] = $projectElementId;
		
		$data ['result']= $this->model_media->getAllReview($entityId,$projectElementId,$pages->offst,$pages->limit);
		return $data['result'];
	}
	
	function supportingmaterial($entityId=0, $elementId=0){
		$whereSuportLinks=array('entityid_to'=>$entityId,'elementid_to'=>$elementId);
		$res=$this->model_media->suportLinks($whereSuportLinks);
		
		if($res){
			$this->data['suportLinks']=$res;
		}else{
			$this->data['suportLinks']=false;
		}
	}
	
	function externalnews($userId=0, $externalurl=''){
		$userId=$userId>0?$userId:$this->userId;
		if(!($userId > 0 )){
			redirect('home');
		}
		$externalUrl=$this->input->get('externalurl');
		$breadcrumbItem=array('showcase','externalnews');
		$breadcrumbURL=array('showcase/aboutme/'.$userId,'mediafrontend/externalnews/'.$userId.'/?externalurl='.$externalUrl);
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$this->data['breadcrumbString']=$breadcrumbString;
		$this->data['externalUrl']=urldecode($externalUrl);
		$this->template_front_end->load('template_front_end','externalnews',$this->data);
	}
	
	function playmedia(){
		$fileDetails=$this->input->post('val1');
		$this->load->view('play_media_file',$fileDetails);
	}
	
	
	
	/*
	 * date: 3-sep-2013
	 * use: show user creaved music playlist 
	 * @return void
	 * auther: Lokendra
	 * 
	 */ 
	
	function myplaylist($userId){
		$userId=$userId>0?$userId:$this->userId;
		$userPlaylistData=$this->model_media->getUserCravedData($userId);
		$this->data['userPlaylistData']=$userPlaylistData;
		$this->data['tdsUid']=$userId;
		$this->data['fileConfig']=$this->config->item($industryType.'FileConfig');
		
		/*echo "<pre>";
		print_r($this->data);die();*/

		$this->template_front_end->load('template_front_end','my_playlist',$this->data);
	}
    
    //------------------------------------------------------------------------
        
    /*
    * @Description: This method is use to show project listing of film and video
    * @param: $userId
    * @return: string
    */ 

    public function filmvideocollection($userId=0) {
  
        //set require data
        $this->data['navigationLink1']                =   'filmvideocollection';
        $this->data['navigationLink2']                =   'deletedcollection';
  
        $this->_getprojectcollection($userId,'filmNvideo','media_project_new_view_list');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @Description: This method is use to show project listing of music and audio
    * @param: $userId
    * @return: string
    */ 

    public function musicaudiocollection($userId=0) {
        //set require data
        $this->data['navigationLink1']                =   'musicaudiocollection';
        $this->data['navigationLink2']                =   'musicaudiodeleted';
        
        $this->_getprojectcollection($userId,'musicNaudio','music_audio_project_list');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @Description: This method is use to show project listing of photography & art
    * @param: $userId
    * @return: string
    */ 

    public function photoartcollection($userId=0) {
        //set require data
        $this->data['navigationLink1']                =   'photoartcollection';
        $this->data['navigationLink2']                =   'photoartdeleted';
        
        $this->_getprojectcollection($userId,'photographyNart','photography_art_project_list');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @Description: This method is use to show project listing of writing & publishing
    * @param: $userId
    * @return: string
    */ 

    public function writingpubcollection($userId=0) {
        //set require data
        $this->data['navigationLink1']                =   'writingpubcollection';
        $this->data['navigationLink2']                =   'writingpubdeleted';
        
        $this->_getprojectcollection($userId,'writingNpublishing','writing_publishing_project_list');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @Description: This method is use to show project listing of education material
    * @param: $userId
    * @return: string
    */ 

    public function educationalcollection($userId=0) {
        //set require data
        $this->data['navigationLink1']                =   'educationalcollection';
        $this->data['navigationLink2']                =   'educationaldeleted';
        
        $this->_getprojectcollection($userId,'educationMaterial','educational_project_list');
    }
    
    
    //-------------------------------------------------------------------------
    
    /*
    * @access: private
    * @Description: This method is use to media project collection user wise
    * @prama: $userId
    * @prama: $industryType
    * @return: string
    * @auther: lokendra meena
    */ 
    
    private function _getprojectcollection($frentendUserId=0,$industryType="filmNvideo",$innerViewName){
       
        // check if correct uesrId entered 
        if(!$this->iscorrectuserid($frentendUserId)):
            redirectToNorecord404();
        else:
            //get user id
            $frentendUserId =  $this->iscorrectuserid($frentendUserId);
        endif;
        
        $projectId = 0; // set zero for all project
                    
        //call model for project data
        $this->data['projectListingData']           =   $this->model_media->projectlist($frentendUserId,$industryType,$projectId); 
        $this->data['frentendUserId']               =   $frentendUserId; // set frentendUserId
        $this->data['industryType']                 =   $industryType; // set industryType
        $this->data['fileConfig']                   =   $this->config->item($industryType.'FileConfig');	//load language data
        $this->data['loggedUserId']                 =   isLoginUser()?isLoginUser():0;	//load language data
        $this->data['packagestageheading']          =   $this->lang->line($industryType.'_showcase');
        $this->data['innerViewName']                =   $innerViewName;
        $this->data['navigationMenu1']              =   true;
        $this->data['isDeleteView']                 =   false;
        
        $this->new_version->load('new_version','media_project_new',$this->data);
    }
    
    
    //------------------------------------------------------------------------
        
    /*
    * @Description: This method is use to show deleted project collection
    * @return:  void
    * @auther: lokendra meena
    */ 

    public function deletedcollection() {
        //set require data
        $this->data['navigationLink1']                =   'filmvideocollection';
        $this->data['navigationLink2']                =   'deletedcollection';
        
        $this->_getdeletedcollection('filmNvideo','media_project_new_view_list');
    }
    
    
    //------------------------------------------------------------------------
        
    /*
    * @Description: This method is use to show deleted project collection
    * @return:  void
    * @auther: lokendra meena
    */ 

    public function musicaudiodeleted() {

        //set require data
        $this->data['navigationLink1']                =   'musicaudiocollection';
        $this->data['navigationLink2']                =   'musicaudiodeleted';
        
        $this->_getdeletedcollection('musicNaudio','music_audio_project_list');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @Description: This method is use to show deleted project collection of photography & art
    * @return:  void
    * @auther: lokendra meena
    */ 

    public function photoartdeleted() {

        //set require data
        $this->data['navigationLink1']                =   'photoartcollection';
        $this->data['navigationLink2']                =   'photoartdeleted';
        
        $this->_getdeletedcollection('photographyNart','photography_art_project_list');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @Description: This method is use to show deleted project collection of writting & publishing
    * @return:  void
    * @auther: lokendra meena
    */ 

    public function writingpubdeleted() {

        //set require data
        $this->data['navigationLink1']                =   'writingpubcollection';
        $this->data['navigationLink2']                =   'writingpubdeleted';
        
        $this->_getdeletedcollection('photographyNart','writing_publishing_project_list');
    }
    
    
    //------------------------------------------------------------------------
        
    /*
    * @Description: This method is use to show deleted project collection of educational deleted
    * @return:  void
    * @auther: lokendra meena
    */ 

    public function educationaldeleted() {

        //set require data
        $this->data['navigationLink1']                =   'educationalcollection';
        $this->data['navigationLink2']                =   'educationaldeleted';
        
        $this->_getdeletedcollection('educationMaterial','educational_project_list');
    }
    
    //-------------------------------------------------------------------------
    
    /*
    * @access: private
    * @Description: This method is use to show deleted project collection
    * @prama: $industryType
    * @return: string
    * @auther: lokendra meena
    */ 
    
    private function _getdeletedcollection($industryType,$innerViewName){

        //get user id
        $loggedUserId =  isLoginUser()?isLoginUser():0;
        
        $projectId = 0; // set zero for all project
                    
        //call model for project data
        $this->data['projectListingData']           =   $this->model_media->projectlist($loggedUserId,$industryType,$projectId,'f'); 
        $this->data['frentendUserId']               =   $loggedUserId; // set frentendUserId
        $this->data['industryType']                 =   $industryType; // set industryType
        $this->data['fileConfig']                   =   $this->config->item($industryType.'FileConfig');	//load language data
        $this->data['loggedUserId']                 =   isLoginUser()?isLoginUser():0;	//load language data
        $this->data['packagestageheading']          =   $this->lang->line($industryType.'_showcase');
        $this->data['innerViewName']                =   $innerViewName;
        $this->data['navigationMenu2']              =   true;
        $this->data['isDeleteView']                 =   true;
        
        $this->new_version->load('new_version','media_project_new',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
    * @access: private 
    * @description: This method is use to get project details if exist 
    * otherwise it will redirect on 404 page
    * @param: $userId
    * @param: $projectId
    * @return: string
    * @auther: lokendra meena
    */ 
    
    
    public function _projectdata($userId,$projectId){
        
        $industryType       =   false;
        
        if(!$this->iscorrectuserid($userId) || !$this->iscorrectprojectid($projectId)){
            redirectToNorecord404();
        }
        
        // get project details by projectId and userId
        $where              =   array('tdsUid'=>$userId,'projId'=>$projectId,'isPublished'=>'t');
        $getProjectDetails  =   $this->model_common->getDataFromTabel($table='Project', $field='projId, projectType', $where, '', 'projId', 'DESC', $limit=1 );

        if(!empty($getProjectDetails)){
            $getProjectDetails   =    $getProjectDetails['0'];
            $industryType        =    $getProjectDetails->projectType; 
        }else{
            redirectToNorecord404();
        }
        
        return $industryType;
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @access: public 
    * @Description: This method is use to show film & video project details 
    * @param: $userId
    * @param: $projectId
    * @auther: lokendra meena
    */ 

    public function mediashowcases($frentendUserId=0, $projectId=0){
        
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call project details methos 
        $this->_mediashowcasesdetails($frentendUserId, $projectId, $industryType,'film_video_project_details');
    }
    
    //-----------------------------------------------------------------------
    
    /*
    * @access: public 
    * @Description: This method is use to show music & audio project details 
    * @param: $userId
    * @param: $projectId
    * @auther: lokendra meena
    */ 
    
    public function aboutalbum($frentendUserId=0, $projectId=0){
        
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call project details methos 
        $this->_mediashowcasesdetails($frentendUserId, $projectId, $industryType,'music_audio_about_details');
    }
    
    //-----------------------------------------------------------------------
    
    /*
    * @access: public 
    * @Description: This method is use to show photography & art project details 
    * @param: $userId
    * @param: $projectId
    * @auther: lokendra meena
    */ 
    
    public function photoartdetails($frentendUserId=0, $projectId=0){
        
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call project details methos 
        $this->_mediashowcasesdetails($frentendUserId, $projectId, $industryType,'photo_art_about_details');
    }
    
    //-----------------------------------------------------------------------
    
    /*
    * @access: public 
    * @Description: This method is use to show writing & publishing project details 
    * @param: $userId
    * @param: $projectId
    * @auther: lokendra meena
    */ 
    
    public function writingdetails($frentendUserId=0, $projectId=0){
        
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call project details methos 
        $this->_mediashowcasesdetails($frentendUserId, $projectId, $industryType,'writing_about_details');
    }
    
    //-----------------------------------------------------------------------
    
    /*
    * @access: public 
    * @Description: This method is use to show writing & publishing project details 
    * @param: $userId
    * @param: $projectId
    * @auther: lokendra meena
    */ 
    
    public function educationdetails($frentendUserId=0, $projectId=0){
        
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call collection media list 
        $this->collectionmedialist($frentendUserId,$projectId);
        
        //call project details methos 
        $this->_mediashowcasesdetails($frentendUserId, $projectId, $industryType,'education_about_details');
    }
    
    //------------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This method is use to list of collection media list
     * @auther: lokendra meena
     * 
     */ 
    
    public function collectionmedialist($frentendUserId,$projectId){
        
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //get element tableName and entityId
        $elementTblPrefix                       =   $this->config->item($industryType.'Prifix'); 

        $elementTbl                             =   $elementTblPrefix.'Element';
        $elementEntityId                        =   getMasterTableRecord($elementTbl);
        
        $perPage            =   ($this->input->post('perPage'))?$this->input->post('perPage'):8;
        $offSet             =   ($this->input->post('offSet'))?$this->input->post('offSet'):0;
        
        $this->data['perPage']         =    $perPage;
        $countReview                   =    $this->model_media->projectelementslist($projectId,$elementTbl,0);
        $this->data['countReview']     =    count($countReview);
        
        $pages                  =  new Pagination_new_ajax;
        $pages->mid_range       =  1;
        $pages->items_total     =  $this->data['countReview']; // this is the COUNT(*) query that gets the total record count from the table you are querying
        $this->data['perPageRecord']  =  $perPage;

         // Add by Amit to set cookie for Results per page
        if($this->input->post('ipp')!=''){
            $isCookie = setPerPageCookie('collectionmediaPerPageVal',$this->data['perPage']);	
        }else {
            $isCookie = getPerPageCookie('collectionmediaPerPageVal',$this->data['perPage']);		
        }
        
        $pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
        $pages->paginate();
        
        $this->data['items_total']        =  $pages->items_total;
        $this->data['items_per_page']     =  $pages->items_per_page;
        $this->data['pagination_links']   =  $pages->display_pages();
        
        $this->data['frentendUserId']     =  $frentendUserId;
        $this->data['projectId']          =  $projectId;
        $this->data['elementEntityId']          =  $elementEntityId;
        $this->data['loggedUserId']             =   isLoginUser()?isLoginUser():0;	//load language data
         
        //call educational elment list
        $this->data['collectionMediaList']          =   $this->model_media->collectionmedialist($projectId,$elementTbl,0,'order','ASC',$pages->offst,$pages->limit);
        
        $ajaxRequest                =  $this->input->post('ajaxRequest');
        if($ajaxRequest){
            $this->load->view('collectionmedialistview',$this->data);
        }
        
    }
    
    //------------------------------------------------------------------------
    
    /*
    * @access: private
    * @Description: This method is use to show project details get data
    * @param: $userId
    * @param: $projectId
    * @param: $industryType
    * @auther: lokendra meena
    */ 
    
    private function _mediashowcasesdetails($frentendUserId=0, $projectId=0,$industryType,$viewName,$offSet=0,$perPage=0){
        
        // check if correct uesrId entered 
        if(!$this->iscorrectuserid($frentendUserId) || !$this->iscorrectprojectid($projectId)):
            redirectToNorecord404();
        else:
            //get user id
            $frentendUserId =  $this->iscorrectuserid($frentendUserId);
        endif;

        //call model for project data
        $projectDataList                            =    $this->model_media->projectlist($frentendUserId,$industryType,0);
        
        //check project is not empty
        if(empty($projectDataList)):
            redirectToNorecord404();
        endif;
       
        // get section Id
        $sectionId                              =   $this->config->item($industryType.'SectionId');
        
        //get element tableName and entityId
        $elementTblPrefix                       =   $this->config->item($industryType.'Prifix'); 
        
        $elementTbl                             =   $elementTblPrefix.'Element';
        $elementEntityId                        =   getMasterTableRecord($elementTbl);
        
        if($sectionId=='3:1'){
            $advertSectionId = 18; //assign advert section id for news
        } else if($sectionId=='3:2'){
            $advertSectionId = 19; //assign advert section id for reviews
        } else {
            $advertSectionId = $sectionId; 
        }
        
        //view require data set
        $this->data['projectDataList']          =   $projectDataList; // set project data
        $this->data['projectId']                =   $projectId; // set userId
        $this->data['frentendUserId']           =   $frentendUserId; // set userId
        $this->data['loggedUserId']             =   isLoginUser()?isLoginUser():0;	//load language data
        $this->data['industryType']             =   $industryType; // set industryType
        $this->data['fileConfig']               =   $this->config->item($industryType.'FileConfig');	//load language data
        $this->data['packagestageheading']      =   $this->lang->line($industryType.'_showcase');
        $this->data['advertSectionId']          =   $advertSectionId; //consider sectionId as a advertSectionId
        $this->data['sectionId']                =   $sectionId; // set sectionId
        $this->data['entityId']                 =   getMasterTableRecord('Project');
        $this->data['elementEntityId']          =   $elementEntityId;
        $this->data['elemetTable']              =   $elementTbl;
        
        //get project element list by project id
        if($elementTbl=='NewsElement' || $elementTbl=='ReviewsElement'){
            $this->data['elementDataList']          =   $this->model_media->newsreviewelementslist($projectId,$elementTbl,0,$offSet,$perPage);
        }else{
             $this->data['elementDataList']         =   $this->model_media->projectelementslist($projectId,$elementTbl,0);
        }
        
        //get ajax request status
        $ajaxRequest                =  $this->input->post('ajaxRequest');
        
        if($ajaxRequest){
            $this->load->view($viewName,$this->data);
        }else{
           $this->new_version->load('new_version',$viewName,$this->data);
        }
    }
    
    
    //-----------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use show album play list
    *  @return: void
    *  @auther: lokendra meena
    */ 
    
    public function albumplaylist(){
        
        $projectId               =    $this->input->get('val1');
        $elementTbl              =    'MaElement';
        $elementEntityId         =    getMasterTableRecord($elementTbl);
        
        $where                   =   array('projId'=>$projectId,'isPublished'=>'t');
        $getProjectDetails       =   $this->model_common->getDataFromTabel($table='Project', $field='projId, projCategory', $where, '', 'projId', 'DESC', $limit=1 );
        
        if(!empty($getProjectDetails[0])){
            $getProjectDetails =  $getProjectDetails[0];
        }
        
        
        //get project element list
        $this->data['elementDataList']          =   $this->model_media->projectelementslist($projectId,$elementTbl,0);
        $this->data['loggedUserId']             =   isLoginUser()?isLoginUser():0;	//load language data
        $this->data['elementEntityId']          =   $elementEntityId;	//load language data
        $this->data['projectId']                =   $projectId;	//load language data
        $this->data['getProjectDetails']        =   $getProjectDetails;	//load language data
        
        $this->load->view('album_play_list',$this->data);
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @access: public
    * @Description: This method is use to show element details 
    * @param: $userId
    * @param: $projectId
    * @param: $elementId
    * @auther: lokendra meena
    */ 

    public function mediadetails($frentendUserId=0, $projectId=0, $elementId=0){
        
         //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call method for media
        $this->_mediadetailsdata($frentendUserId, $projectId, $elementId, $industryType,'film_video_element_details');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @access: public
    * @Description: This method is use to show music and audio track list 
    * @param: $userId
    * @param: $projectId
    * @param: $elementId
    * @auther: lokendra meena
    */ 

    public function tracklist($frentendUserId=0, $projectId=0, $elementId=0){
        
         //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call method for media
        $this->_mediadetailsdata($frentendUserId, $projectId, $elementId, $industryType,'track_list_details');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @access: public
    * @Description: This method is use to show photography & art element details
    * @param: $userId
    * @param: $projectId
    * @param: $elementId
    * @auther: lokendra meena
    */ 

    public function photoartelement($frentendUserId=0, $projectId=0, $elementId=0){
        
         //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call method for media
        $this->_mediadetailsdata($frentendUserId, $projectId, $elementId, $industryType,'photo_art_element_details');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @access: public
    * @Description: This method is use to show writing element details
    * @param: $userId
    * @param: $projectId
    * @param: $elementId
    * @auther: lokendra meena
    */ 

    public function writingelement($frentendUserId=0, $projectId=0, $elementId=0){
        
         //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call method for media
        $this->_mediadetailsdata($frentendUserId, $projectId, $elementId, $industryType,'writing_element_details');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @access: public
    * @Description: This method is use to show education element details
    * @param: $userId
    * @param: $projectId
    * @param: $elementId
    * @auther: lokendra meena
    */ 

    public function educationelement($frentendUserId=0, $projectId=0, $elementId=0){
        
         //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call method for media
        $this->_mediadetailsdata($frentendUserId, $projectId, $elementId, $industryType,'education_element_details');
    }
    
    //------------------------------------------------------------------------
    
    /*
    * @access: private
    * @Description: This method is use to show element details get data
    * @param: $userId
    * @param: $projectId
    * @param: $elementId
    * @param: $industryType
    * @auther: lokendra
    */ 
    
    private function _mediadetailsdata($frentendUserId, $projectId,$elementId,$industryType,$viewName){
        
        // check if correct uesrId entered 
        if(!$this->iscorrectuserid($frentendUserId) || !$this->iscorrectprojectid($projectId)):
            redirectToNorecord404();
        else:
            //get user id
            $frentendUserId =  $this->iscorrectuserid($frentendUserId);
        endif;

        //call model for project data
        $projectData                            =    $this->model_media->projectlist($frentendUserId,$industryType,$projectId);
        
        //check project is not empty
        if(empty($projectData)):
            redirectToNorecord404();
        endif;
       
        // get section Id
        $sectionId                              =   $this->config->item($industryType.'SectionId');
        
        //get element tableName and entityId
        $elementTblPrefix                       =   $this->config->item($industryType.'Prifix'); 
        $elementTbl                             =   $elementTblPrefix.'Element';
        $elementEntityId                        =   getMasterTableRecord($elementTbl);
        
        if($sectionId=='3:1'){
            $advertSectionId = 18; //assign advert section id for news
        } else if($sectionId=='3:2'){
            $advertSectionId = 19; //assign advert section id for reviews
        } else {
            $advertSectionId = $sectionId; 
        }
        
        //view require data set
        $this->data['projectData']              =   $projectData; // set project data
        $this->data['projectId']                =   $projectId; // set projectId
        //$this->data['elementId']                =   $elementId; // set elementId
        $this->data['frentendUserId']           =   $frentendUserId; // set userId
        $this->data['industryType']             =   $industryType; // set industryType
        $this->data['fileConfig']               =   $this->config->item($industryType.'FileConfig');	//load language data
        $this->data['loggedUserId']             =   isLoginUser()?isLoginUser():0;	//load language data
        $this->data['packagestageheading']      =   $this->lang->line($industryType.'_showcase');
        $this->data['advertSectionId']          =   $advertSectionId; //consider sectionId as a advertSectionId
        $this->data['sectionId']                =   $sectionId; // set sectionId
        $this->data['entityId']                 =   getMasterTableRecord('Project');
        $this->data['elementEntityId']          =   $elementEntityId;
        
        //get project element list by project id
        if($elementTbl=='NewsElement' || $elementTbl=='ReviewsElement'){
             $elementDataList                =   $this->model_media->newsreviewelementslist($projectId,$elementTbl,0);
        }else{
             $elementDataList                =   $this->model_media->projectelementslist($projectId,$elementTbl,0);
        }
        
        //check project is not empty
        if(empty($elementDataList)):
            redirectToNorecord404();
        endif;
        
        //if no element id passed then get last elementId 
        if($elementId==0){
           $elementId = (isset($elementDataList[0]['elementId']))?$elementDataList[0]['elementId']:0;
        }
        
        
        $this->data['elementId']                =   $elementId; // set elementId
        
        $this->data['elementDataList']              =   $elementDataList; // set element data
        
        $this->new_version->load('new_version',$viewName,$this->data);
    }
    
    //------------------------------------------------------------------------

    /*
    * @access: public
    * @Description: This method is use to show supporting material listing show
    * @param: $entityId
    * @param: $elementId
    * @auther: lokendra method
    */ 

    public function supportingmaterialshow($entityId=0, $elementId=0){
        
        $whereSuportLinks   =   array('entityid_to'=>$entityId,'elementid_to'=>$elementId);
        $suportLinks        =   $this->model_media->suportLinks($whereSuportLinks);
        
        if(!empty($suportLinks)):
            $this->load->view('supporting_material_new',array('suportLinks'=>$suportLinks));
        endif;
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
    
    
    //------------------------------------------------------------------------
    
    /*
     * @access: private
     * @description: This method is use to check projectId is correct
     * @param:  $projectId
     * @return: boolean (TRUE/FALSE)
     */  
    private function iscorrectprojectid($projectId=0){
               
        if(is_numeric($projectId)):
            $projectId    =   $projectId>0?$projectId:0;
        else:
            $projectId   =   0;    
        endif;
        return $projectId;
    }
    
    //------------------------------------------------------------------------
    
    /*
     * @access: private
     * @description: This method is use to check elementId is correct
     * @param:  $elementId
     * @return: boolean (TRUE/FALSE)
     */  
    private function iscorrectelementid($elementId=0){
               
        if(is_numeric($elementId)):
            $elementId    =   $elementId>0?$elementId:0;
        else:
            $elementId   =   0;    
        endif;
        return $elementId;
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @access: public 
    * @Description: This method is use to show project gallery list 
    * @param: $userId
    * @param: $projectId
    * @auther: lokendra meena
    */ 

    public function mediagallery($frentendUserId=0, $projectId=0, $elementId=0){
   
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call method for film and video
        $this->_mediagallerydata($frentendUserId, $projectId, $elementId, $industryType,'media_gallery_list');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @access: public 
    * @Description: This method is use to show photoartgallery
    * @param: $userId
    * @param: $projectId
    * @auther: lokendra meena
    */ 

    public function photoartgallery($frentendUserId=0, $projectId=0, $elementId=0){
        
        //js add for isotop
        $this->head->add_js($this->config->item('template_new_js').'isotope.js',NULL,'lastAdd');
        //add full screen js
        $this->head->add_js($this->config->item('template_new_js').'jquery.fullscreen-0.4.1.min.js',NULL,'lastAdd');
    
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call method for film and video
        $this->_mediagallerydata($frentendUserId, $projectId, $elementId, $industryType,'photo_art_gallery_list');
    }
    
    //------------------------------------------------------------------------
        
    /*
    * @access: public 
    * @Description: This method is use to show writinggallery
    * @param: $userId
    * @param: $projectId
    * @auther: lokendra meena
    */ 

    public function writinggallery($frentendUserId=0, $projectId=0, $elementId=0){
        
        //add full screen js
        $this->head->add_js($this->config->item('template_new_js').'jquery.fullscreen-0.4.1.min.js',NULL,'lastAdd');
        
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        //call method for film and video
        $this->_mediagallerydata($frentendUserId, $projectId, $elementId, $industryType,'writing_gallery_list');
    }
    
    //------------------------------------------------------------------------
    
    /*
    * @access: private
    * @Description: This method is use to show gallery list data 
    * @param: $userId
    * @param: $projectId
    * @param: $industryType
    * @auther: lokendra
    */ 
    
    private function _mediagallerydata($frentendUserId, $projectId,$elementId,$industryType,$viewName){
        
        // check if correct uesrId entered 
        if(!$this->iscorrectuserid($frentendUserId) || !$this->iscorrectprojectid($projectId)):
            redirectToNorecord404();
        else:
            //get user id
            $frentendUserId =  $this->iscorrectuserid($frentendUserId);
        endif;

        //call model for project data
        $projectData                            =    $this->model_media->projectlist($frentendUserId,$industryType,$projectId);
        
        //check project is not empty
        if(empty($projectData)):
            redirectToNorecord404();
        endif;
       
        // get section Id
        $sectionId                              =   $this->config->item($industryType.'SectionId');
        
        //get element tableName and entityId
        $elementTblPrefix                       =   $this->config->item($industryType.'Prifix'); 
        $elementTbl                             =   $elementTblPrefix.'Element';
        $elementEntityId                        =   getMasterTableRecord($elementTbl);
        
        //view require data set
        $this->data['projectData']              =   $projectData; // set project data
        $this->data['projectId']                =   $projectId; // set projectId
       
        $this->data['frentendUserId']           =   $frentendUserId; // set userId
        $this->data['industryType']             =   $industryType; // set industryType
        $this->data['fileConfig']               =   $this->config->item($industryType.'FileConfig');	//load language data
        $this->data['loggedUserId']             =   isLoginUser()?isLoginUser():0;	//load language data
        $this->data['packagestageheading']      =   $this->lang->line($industryType.'_showcase');
        $this->data['advertSectionId']          =   $sectionId; //consider sectionId as a advertSectionId
        $this->data['sectionId']                =   $sectionId; // set sectionId
        $this->data['entityId']                 =   getMasterTableRecord('Project');
        $this->data['elementEntityId']          =   $elementEntityId;
        
        //get project element list by project id
        $elementDataList                            =   $this->model_media->projectelementslist($projectId,$elementTbl,0);
       
        //check project is not empty
        if(empty($elementDataList)):
            redirectToNorecord404();
        endif;
        
         //if no element id passed then get last elementId 
        if($elementId==0){
           $elementId = (isset($elementDataList[0]['elementId']))?$elementDataList[0]['elementId']:0;
        }
        
        
        $this->data['elementId']                =   $elementId; // set elementId
  
        
        $this->data['elementDataList']              =   $elementDataList; // set element data
        
        $this->new_version->load('new_version',$viewName,$this->data);
    }
    
    //-------------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to show user review listing
    * @return: string
    */
     
    public function getReviewListNew($entityId='',$projectElementId='',$perPage=''){
        
        $entityId           =   (!empty($entityId))?$entityId:$this->input->post('entityId');
        $projectElementId   =   (!empty($projectElementId))?$projectElementId : $this->input->post('projectElementId');
        $perPage            =   $this->input->post('perPage');
        $offSet             =   $this->input->post('offSet');
    
        //-----get total review count -------//
        $reviewEntityId             =  getMasterTableRecord('ReviewsElement'); // get review entityId
        $reviewAllRecord            =  $this->model_media->getAllReviewNew($entityId,$projectElementId,$reviewEntityId);
        $data['countReview']        =   count($reviewAllRecord);
         
        $data['perPage']            =  $perPage;
        $data['entityId']           =  $entityId;
        $data['projectElementId']   =  $projectElementId;
        $data['srNumber']           =  '1';
        
        //Paginaation functionality
        $pages                  =  new Pagination_new_ajax;
        $pages->items_total     =  $data['countReview']; // this is the COUNT(*) query that gets the total record count from the table you are querying
        $data['perPageRecord']  =  $this->config->item('perPageRecordReviews');
        
        // Add by Amit to set cookie for Results per page
        if($this->input->post('ipp')!=''){
            $isCookie = setPerPageCookie('reviewPerPageVal',$data['perPageRecord']);	
        }else {
            $isCookie = getPerPageCookie('reviewPerPageVal',$data['perPageRecord']);		
        }
                    
        $pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
        $pages->paginate();
        
        $data['items_total']        =  $pages->items_total;
        $data['items_per_page']     =  $pages->items_per_page;
        $data['pagination_links']   =  $pages->display_pages();
        $data ['result']            =  $this->model_media->getAllReviewNew($entityId,$projectElementId,$reviewEntityId,$pages->offst,$pages->limit);
        
        $ajaxRequest                =  $this->input->post('ajaxRequest');
        if($ajaxRequest){
            $this->load->view('reviewList_new',$data);
        }else{
            $this->load->view('reviewList_new',$data);
        }
    }
    
    //---------------------------------------------------------------------
    
    /*
    *   @access: public
    *   @description: This method is use to add audio media to playlist
    *   @auther: lokendra meena
    *   @return: void
    */ 
    
    public function addtoplaylist(){
        
        $loggedUserId       =   $this->isLoginUser();
        $projectId          =   $this->input->post('projectId'); 
        $elementId          =   $this->input->post('elementId'); 
        $entityId           =   $this->input->post('elementEntityId'); 
        
        $inserData =   array('entityId'=>$entityId,'projectId'=>$projectId,'elementId'=>$elementId,'tdsUid'=>$loggedUserId);
        $getPlaylistData =  $this->model_common->getDataFromTabel('MediaPlaylist', 'id',  $inserData,'','','',1);
       
        //if not added then addd in the playlist
        if(empty($getPlaylistData)){
            $this->model_common->addDataIntoTabel('MediaPlaylist', $inserData);
            $returnData = array('issuccess'=>true);
        }else{
            $returnData = array('issuccess'=>false);
        }
        
        echo json_encode($returnData);
    }
    
    //----------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use sample media
    *  @auther: lokendra
    */ 
    
    public function samplemediafile(){
        
        $mediaId     =  $this->input->get('val1');
        $entityId    =  $this->input->get('val2');
        $elementId   =  $this->input->get('val3');
        $projectId   =  $this->input->get('val4');
        
        $data['mediaId']    = $mediaId;
        $data['entityId']   = $entityId;
        $data['elementId']  = $elementId;
        $data['projectId']  = $projectId;
        $this->load->view('sample_media_view',$data);
    }
    
    //----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This method is use to news review data
     * @auther: lokendra meena
     * @return: void
     */
    
    public function newscollection($frentendUserId,$projectId="0",$perPage=''){
        
        if(empty($projectId)){
            //get user news project
            $inserData          =   array('tdsUid'=>$frentendUserId,'projectType'=>'news','isPublished'=>'t');
            $getPlaylistData    =  $this->model_common->getDataFromTabel('Project', 'projId,projectType',  $inserData,'','','',1);
            
            if(empty($getPlaylistData)){
                redirectToNorecord404();
            }else{
                $getPlaylistData    =   $getPlaylistData[0];
                $projectId          =   $getPlaylistData->projId;
                $industryType       =   $getPlaylistData->projectType;
            }
        }
        
        //get pagination request data
        $perPage            =   $this->input->post('perPage');
        $offSet             =   $this->input->post('offSet');
        
        
        $elementTbl                       =  'NewsElement'; 
        $reviewAllRecord                  =  $this->model_media->newsreviewelementslist($projectId,$elementTbl,0);
        $this->data['countReview']        =   count($reviewAllRecord);
        
        $this->data['perPage']            =  $perPage;
        
         //Paginaation functionality
        $pages                  =  new Pagination_new_ajax;
        $pages->items_total     =  $this->data['countReview']; // this is the COUNT(*) query that gets the total record count from the table you are querying
        $this->data['perPageRecord']  =  $this->config->item('perPageRecord');
        
        // Add by Amit to set cookie for Results per page
        if($this->input->post('ipp')!=''){
            $isCookie = setPerPageCookie('newsElementPerPageVal',$this->data['perPageRecord']);	
        }else {
            $isCookie = getPerPageCookie('newsElementPerPageVal',$this->data['perPageRecord']);		
        }
                    
        $pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
        $pages->paginate();
        
        
        $this->data['items_total']        =  $pages->items_total;
        $this->data['items_per_page']     =  $pages->items_per_page;
        $this->data['pagination_links']   =  $pages->display_pages();
        
        
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        if($industryType!="news"){
            redirectToNorecord404();
        }
        
        //get view name
        $ajaxRequest                =  $this->input->post('ajaxRequest');
        if($ajaxRequest){
            $viewName = 'news_collections_element_list';
        }else{
           $viewName = 'news_collections';
        }
        
        //call project details methos 
        $this->_mediashowcasesdetails($frentendUserId, $projectId, $industryType,$viewName,$pages->offst,$pages->limit);
    }
    
    
     //------------------------------------------------------------------------
        
    /*
    * @access: public
    * @Description: This method is use to show news element details
    * @param: $userId
    * @param: $projectId
    * @param: $elementId
    * @auther: lokendra meena
    */ 

    public function articledetails($frentendUserId=0, $projectId=0, $elementId=0){
        
        if(empty($projectId)){
            //get user news project
            $inserData          =   array('tdsUid'=>$frentendUserId,'projectType'=>'news','isPublished'=>'t');
            $getPlaylistData    =  $this->model_common->getDataFromTabel('Project', 'projId,projectType',  $inserData,'','','',1);
            
            if(empty($getPlaylistData)){
                redirectToNorecord404();
            }else{
                $getPlaylistData    =   $getPlaylistData[0];
                $projectId          =   $getPlaylistData->projId;
                $industryType       =   $getPlaylistData->projectType;
            }
        }
        
         //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        if($industryType!="news"){
            redirectToNorecord404();
        }
        
        //call method for media
        $this->_mediadetailsdata($frentendUserId, $projectId, $elementId, $industryType,'news_element_details');
    }
    
    
     //----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This method is use to reviews data
     * @auther: lokendra meena
     * @return: void
     */
    
    public function reviewscollection($frentendUserId,$projectId,$perPage=''){
        
        if(empty($projectId)){
            //get user news project
            $inserData          =   array('tdsUid'=>$frentendUserId,'projectType'=>'reviews','isPublished'=>'t');
            $getPlaylistData    =  $this->model_common->getDataFromTabel('Project', 'projId,projectType',  $inserData,'','','',1);
            
            if(empty($getPlaylistData)){
                redirectToNorecord404();
            }else{
                $getPlaylistData    =   $getPlaylistData[0];
                $projectId          =   $getPlaylistData->projId;
                $industryType       =   $getPlaylistData->projectType;
            }
        }
        
        //get pagination request data
        $perPage            =   $this->input->post('perPage');
        $offSet             =   $this->input->post('offSet');
        
        
        $elementTbl                       =  'ReviewsElement'; 
        $reviewAllRecord                  =  $this->model_media->newsreviewelementslist($projectId,$elementTbl,0);
        $this->data['countReview']        =   count($reviewAllRecord);
        
        $this->data['perPage']            =  $perPage;
        
         //Paginaation functionality
        $pages                  =  new Pagination_new_ajax;
        $pages->items_total     =  $this->data['countReview']; // this is the COUNT(*) query that gets the total record count from the table you are querying
        $this->data['perPageRecord']  =  $this->config->item('perPageRecord');
        
        // Add by Amit to set cookie for Results per page
        if($this->input->post('ipp')!=''){
            $isCookie = setPerPageCookie('reviewElementPerPageVal',$this->data['perPageRecord']);	
        }else {
            $isCookie = getPerPageCookie('reviewElementPerPageVal',$this->data['perPageRecord']);		
        }
                    
        $pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
        $pages->paginate();
        
        
        $this->data['items_total']        =  $pages->items_total;
        $this->data['items_per_page']     =  $pages->items_per_page;
        $this->data['pagination_links']   =  $pages->display_pages();
        
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        if($industryType!="reviews"){
            redirectToNorecord404();
        }
        
        //get view name
        $ajaxRequest                =  $this->input->post('ajaxRequest');
        if($ajaxRequest){
            $viewName = 'reviews_collections_element_list';
        }else{
           $viewName = 'reviews_collections';
        }
        
        //call project details methos 
        $this->_mediashowcasesdetails($frentendUserId, $projectId, $industryType,$viewName,$pages->offst,$pages->limit);
    }
    
    
    //------------------------------------------------------------------------
        
    /*
    * @access: public
    * @Description: This method is use to show reviews element details
    * @param: $userId
    * @param: $projectId
    * @param: $elementId
    * @auther: lokendra meena
    */ 

    public function reviewsdetails($frentendUserId=0, $projectId=0, $elementId=0){
        
        if(empty($projectId)){
            //get user news project
            $inserData          =   array('tdsUid'=>$frentendUserId,'projectType'=>'reviews','isPublished'=>'t');
            $getPlaylistData    =  $this->model_common->getDataFromTabel('Project', 'projId,projectType',  $inserData,'','','',1);
            
            if(empty($getPlaylistData)){
                redirectToNorecord404();
            }else{
                $getPlaylistData    =   $getPlaylistData[0];
                $projectId          =   $getPlaylistData->projId;
                $industryType       =   $getPlaylistData->projectType;
            }
        }
        
        //call method & get industry type
        $industryType   = $this->_projectdata($frentendUserId,$projectId);
        
        if($industryType!="reviews"){
            redirectToNorecord404();
        }
        
        //call method for media
        $this->_mediadetailsdata($frentendUserId, $projectId, $elementId, $industryType,'reviews_element_details');
    }
    
    
    

}
/* End of file frontend.php */
/* Location: ./application/module/frontend/frontend.php */
