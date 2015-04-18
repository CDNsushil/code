<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 * Todasquare frontend Controller Class
 *
 *  Manage Frontend Details (Writing & Publishing)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 *	Date	23-05-2013
 **/
 
class filmnvideo extends MX_Controller {
	private $data = array();
	private $dirCacheMedia = '';
	private $dirUploadMedia = '';
	
	private $userId = null;
	private $IndustryId = 0;
	/**
	 * Constructor
	 */
	 
	 function __construct() {
		//Load required Model, Library, language and Helper files
			$load = array(
				'model'		=> 'filmnvideo/model_filmnvideo',  	
				'language' 	=> 'media + filmNvideo',							
				'config'		=>	'media/media'   		
			);
			parent::__construct($load);		
			$this->dirCacheMedia = ROOTPATH.'cache/filmnvideo/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/filmnvideo/'; 
			$this->data['dirUploadMedia'] = $this->dirUploadMedia;
            $this->IndustryId = $this->config->item('filmnvideoSectionId');
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
	
	
	public function index() {
		$this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageProject');
        $this->data['navigationHeading'] = $this->lang->line('FvCollections');
        $this->data['comingsoon']= array('msg'=>$this->lang->line('BetheFirst'),'title'=>$this->lang->line('createYourMediaShowcase'),'url'=>base_url(lang().'/media/filmvideo'));
        $this->landingpage('countProject');
	}
    
    public function craved($cravedFor='') {
        $cravedFor = ($cravedFor == 'video')?'video':'collections';
        $this->data['cravedFor'] = $cravedFor;
        if($cravedFor == 'video'){
            $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/cravedElements');
            $countString='countElement';
            $this->data['saprator'] = 'sap_15';
            $this->data['divClass'] = 'm_auto  clearb lp_pices_wrap pt30 pl25 pr25 pb5 bge5e7d9';
            $this->data['innerView'] = 'landingpage/one_column';
            
        }else{
            $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/cravedProject');
            $countString='countCravedProject';
        }
		
        $this->data['navigationHeading'] = $this->lang->line('FvCollections');
        $this->data['scroll'] = false;
        
        $this->landingpage($countString);
	}
    
    public function upcoming() {
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageUpcoming');
        $this->data['navigationHeading'] = $this->lang->line('FvCollectionUpcoming');
        $this->landingpage('countUpcoming');
	}
    
    public function reviews() {
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageReviews');
        $this->data['navigationHeading'] = $this->lang->line('FvCollectionReviews');
        $this->data['innerView'] = 'landingpage/one_column';
        $this->landingpage('countReviews');
	}
    
    public function news() {
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageNews');
        $this->data['navigationHeading'] = $this->lang->line('FvCollectionNews');
        $this->data['innerView'] = 'landingpage/one_column';
        $this->landingpage('countNews');
	}
    
    public function landingpage($cd = 'countProject') {
		$this->data['projectType'] = 'filmNvideo';
        if(isset($this->data['cravedFor']) && ($this->data['cravedFor'] == 'video')){
            $this->data['craveHeading'] = $this->lang->line('FvTopCravedCollectionElements');
        }else{
            $this->data['craveHeading'] = $this->lang->line('FvTopCravedCollections');
        }
        $this->getNavigation($cd);
        if($this->data[$cd]){
            if(!isset($this->data['innerView'])){
                $this->data['innerView']= 'landingpage/media_landing';
            }
        }else{
            if(!isset($this->data['comingsoon'])){
                $this->data['comingsoon']= array('msg'=>$this->lang->line('ComingSoon'));
            }
           $this->data['innerView'] = 'landingpage/comingsoon'; 
        }
		$this->new_version->load('new_version','landingpage/landingpage',$this->data);
	}
    
    function getNavigation($cd = 'countProject'){
        
        
        $this->data['countCravedProject'] = $this->model_common->countProject('Project', array('isPublished'=>'t','isArchive'=>'f','projectType'=>$this->data['projectType']),true);
        $this->data['countElement'] = $this->model_common->countProjectElements('FvElement', array('p.isPublished'=>'t','p.isArchive'=>'f','e.isPublished'=>'t','e.isArchive'=>'f'),true);
        
        if($cd == 'countProject'){
            $this->data['countProject'] = $this->model_common->countProject('Project', array('isPublished'=>'t','isArchive'=>'f','projectType'=>$this->data['projectType']));
        }
        if($cd == 'countUpcoming'){
            $this->data['countUpcoming'] = $this->model_common->countResult('UpcomingProject', array('isPublished'=>'t','projArchived'=>'f','projUpType'=>$this->config->item('mediaUpcomingTypeId'),'projIndustry'=>$this->IndustryId));
        }
        if($cd == 'countReviews'){
            $this->data['countReviews'] = $this->model_common->countResult('ReviewsElement', array('isPublished'=>'t','isArchive'=>'f','industryId'=>$this->IndustryId));
        }
        if($cd == 'countNews'){
            $this->data['countNews'] = $this->model_common->countResult('NewsElement', array('isPublished'=>'t','isArchive'=>'f','industryId'=>$this->IndustryId));
        }
        
        $module = $this->router->fetch_class();
        $method = $this->router->fetch_method();
        
        $this->data['module']=$module;
        $this->data['method']=$method;
        
        if($this->data['countCravedProject']){    
           $craveUrl = (isset($this->data['cravedFor']) && ($this->data['cravedFor']  == 'collections')) ? 'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'craved'.DIRECTORY_SEPARATOR.'collections');
           $this->data['craveNav']['collections'] = array('title'=>$this->lang->line('FvTopCravedCollections'),'url'=>$craveUrl);
        }
        if($this->data['countElement']){
           $craveUrl = (isset($this->data['cravedFor']) && ($this->data['cravedFor']  == 'video'))?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'craved'.DIRECTORY_SEPARATOR.'video');
           $this->data['craveNav']['video'] = array('title'=>$this->lang->line('FvTopCravedCollectionElements'),'url'=>$craveUrl);
        }
        
        $url = ($method == 'index' || $method == '')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'index');
        $this->data['navigations']['index'] = array('title'=>$this->lang->line('FvCollections'),'url'=>$url);
       
        $url = ($method == 'upcoming')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'upcoming');
        $this->data['navigations']['upcoming'] = array('title'=>$this->lang->line('FvCollectionUpcoming'),'url'=>$url);
        
        $url = ($method == 'reviews')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'reviews');
        $this->data['navigations']['reviews'] = array('title'=>$this->lang->line('FvCollectionReviews'),'url'=>$url);
    
        $url = ($method == 'news')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'news');
        $this->data['navigations']['news'] = array('title'=>$this->lang->line('FvCollectionNews'),'url'=>$url);
    }
	
    function cravedProject(){	
		$userId=0;
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		$projectElementEntityId = getMasterTableRecord('FvElement');
		$result= $this->model_common->getProjectRecord('filmNvideo',$userId,$projectId=0,'projId,projSellstatus,projCategory,projName,projShortDesc,craveCount,imageFileCount,docFileCount,audioFileCount,cdCount,videoFileCount,dvdCount,ratingAvg,projCreateDate,projLastModifyDate,projBaseImgPath',$limit,$offset,'LogSummary.craveCount','DESC'); 
		$returnData = array();
        $projectData = array(
            'projectElementEntityId'=>$projectElementEntityId,
            'projectType'=>'filmNvideo',
            'frontendMathod'=>'filmvideo',
            'fileType_dwnld'=>array('videoFileCount'=>$this->lang->line('videoFile')),
            'fileType_shipd'=>array('dvdCount'=>$this->lang->line('DVD')),
        );
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
                $projectData['data'] = $data;
				$returnData[]=$this->load->view('landingpage/media_listing',$projectData, true);
			}
		}
		echo  json_encode($returnData);	
	}
    
    function cravedElements(){	
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		$projectElementEntityId = getMasterTableRecord('FvElement');
		$result= $this->model_common->getProjectElementsLP('FvElement', $limit, $offset); 
		$returnData = array();
        $projectData = array(
            'projectElementEntityId'=>$projectElementEntityId,
            'projectType'=>'filmNvideo',
            'frontendMathod'=>'filmvideo',
            'fileType_dwnld'=>$this->lang->line('videoFile'),
            'fileType_shipd'=>$this->lang->line('DVD'),
            'industry'=>$this->lang->line('FvIndustry'),
            
        );
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
                $projectData['data'] = $data;
				$returnData[]=$this->load->view('landingpage/media_craved_listing',$projectData, true);
			}
		}
		echo  json_encode($returnData);	
	}
    
	function landingPageProject(){	
		$userId=0;
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		$projectElementEntityId = getMasterTableRecord('FvElement');
		$result= $this->model_common->getProjectRecord('filmNvideo',$userId,$projectId=0,'projId,projSellstatus,projCategory,projName,projShortDesc,craveCount,imageFileCount,docFileCount,docCount,audioFileCount,cdCount,videoFileCount,dvdCount,ratingAvg,projCreateDate,projLastModifyDate,projBaseImgPath',$limit,$offset); 
		
        $projectData = array(
            'projectElementEntityId'=>$projectElementEntityId,
            'projectType'=>'filmNvideo','frontendMathod'=>'filmvideo',
            'fileType_dwnld'=>array('videoFileCount'=>$this->lang->line('videoFile')),
            'fileType_shipd'=>array('dvdCount'=>$this->lang->line('DVD')),
        );
        
        $returnData = array();
		if($result && is_array($result) && count($result)>0){
			
			foreach($result as $data){
                $projectData['data'] = $data;
				$returnData[]=$this->load->view('landingpage/media_listing',$projectData,true);
			}
		}
		echo  json_encode($returnData);	
	}
    
	function landingPageNews(){	
		$userId=0;
		$orderby='elementId';
		$elementOrderBy='modifyDate';
		$order='DESC';
		$fetchElementFields = '';
		
		$industryKey = $this->config->item('FVTYPE');
		
		$entityId = getMasterTableRecord('NewsElement');
		
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$result= $this->model_common->getProjectElements($userId,$this->config->item('newsPrifix'),0,$orderby,$order,$fetchElementFields,$industryKey,$entityId,$limit,$offset);
		$returnData = array();
		if($result && is_array($result) && count($result)>0){
			foreach($result as $k=>$data){
                $border = ($k % 2 ==0)?'gray_news':'bdr_aeaeae';
				$returnData[]=$this->load->view('landingpage/news_listing',array('data'=>$data,'border'=>$border), true);
			}
		}
		echo  json_encode($returnData);	
	}
	
	function landingPageReviews(){	
		$userId=0;
		$orderby='elementId';
		$elementOrderBy='modifyDate';
		$order='DESC';
		$fetchElementFields = '';
		
		$industryKey = $this->config->item('FVTYPE');
		
		$entityId = getMasterTableRecord('ReviewsElement');
		
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$result= $this->model_common->getProjectElements($userId,$this->config->item('reviewsPrifix'),0,$orderby,$order,$fetchElementFields,$industryKey,$entityId,$limit,$offset);
		$returnData = array();
		if($result && is_array($result) && count($result)>0){
			foreach($result as $k=>$data){
                $border = ($k % 2 ==0)?'gray_news':'bdr_aeaeae';
				$returnData[]=$this->load->view('landingpage/reviews_listing',array('data'=>$data,'border'=>$border), true);
			}
		}
		echo  json_encode($returnData);	
	}
	
	function landingPageUpcoming(){	
		$industryKey = $this->config->item('FVTYPE');
		
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$result= $this->model_common->getUpcomingProjects($this->IndustryId,$this->config->item('mediaUpcomingTypeId'),$limit,$offset);
		
        $returnData = array();
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
				$returnData[]=$this->load->view('landingpage/upcoming_listing',array('data'=>$data,'frontendMathod'=>'filmvideo'), true);
			}
		}
		echo  json_encode($returnData);	
	}
    
}

/* End of file frontend.php */
/* Location: ./application/module/frontend/frontend.php */
