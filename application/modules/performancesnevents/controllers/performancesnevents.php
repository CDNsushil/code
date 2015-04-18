<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 * Todasquare frontend Controller Class
 *
 *  Manage Frontend Details ( Associate Professional )
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 *
 **/
 
class performancesnevents extends MX_Controller {
	private $data = array();
	private $dirCacheMedia = '';
	private $dirUploadMedia = '';
	private $tableUserShowcase					= 'UserShowcase';
	private $tableUserAuth						= 'UserAuth';
	
	private $userId = null;
	private $IndustryId = 0;
	/**
	 * Constructor
	 */
	 
	 function __construct() {
		//Load required Model, Library, language and Helper files
			$load = array(
				'model'		=> 'model_performancesnevents',  	
				'language' 	=> 'media',							
				'config'		=>	'media/media'   		
			);
			parent::__construct($load);		
			
			//$this->head->add_css($this->config->item('system_css').'frontend.css');
			//$this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
			//$this->head->add_js($this->config->item('frontend_js').'jquery.anythingslider.js');
			//$this->head->add_js($this->config->item('frontend_js').'jquery.tinycarousel.min.js');
			//$this->head->add_js($this->config->item('frontend_js').'jquery-gallery-cdn.js');
			
			//$this->userId= $this->isLoginUser();
			// Load  path of css and cache file path
			$this->dirCacheMedia = ROOTPATH.'cache/performancesnevents/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/performancesnevents/'; 
			$this->data['dirUploadMedia'] = $this->dirUploadMedia; 
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
		$industryKey = $this->config->item('PETYPE');
		
		$this->data['bodyClass'] = 'PE_Seamless';
		$this->data['mainClass'] = 'PE_main_red_texture';
		$this->data['section'] = $this->config->item('PE');
		
		$this->data['projectType'] = 'performancesevents';
		$this->data['frontendMathod'] = 'events';
		$this->data['top_craved_view'] = 'top_craved_performancesnevents';
		$this->data['bannerImage']=array('banner_front_performances-and-events_grow-audience_HR.jpg','banner_front_performances-and-events_what-doing-tonight_HR.jpg');
		$this->data['dashbordButton']="<span>".$this->lang->line('promote_event')."</span>";
		$this->data['defaultProfileImage'] = $this->config->item('defaultEventImg_l');
		$this->data['bdr']='bdr_Dred10';
		   
		$this->data['projectEntityId'] = getMasterTableRecord('Events');
		$this->data['upcomingEntityId'] = getMasterTableRecord('UpcomingProject');
		$this->data['newsEntityId'] = getMasterTableRecord('NewsElement');
		$this->data['reviewEntityId'] = getMasterTableRecord('ReviewsElement');
		
		$this->data['eventUrl'] = base_url(lang().'/performancesnevents/landingPageProject');
		$this->data['newsUrl'] = base_url(lang().'/performancesnevents/landingPageNews');
		$this->data['reviewssUrl'] = base_url(lang().'/performancesnevents/landingPageReviews');
		$this->data['upcomingUrl'] = base_url(lang().'/performancesnevents/landingPageUpcoming');
		
		
		$this->data['countEvent'] = $this->model_common->countResult('Events', array('isPublished'=>'t'), '', 1);
		$this->data['countNews'] = $this->model_common->countResult('NewsElement', array('isPublished'=>'t','industryId'=>9), '', 1);
		$this->data['countReviews'] = $this->model_common->countResult('ReviewsElement', array('isPublished'=>'t','industryId'=>9), '', 1);
		$this->data['countUpcoming'] = $this->model_common->countResult('UpcomingProject', array('isPublished'=>'t','projUpType'=>2), '', 1);
		$this->data['isdata']=false;
		if($this->data['countEvent'] || $this->data['countUpcoming'] || $this->data['countNews'] || $this->data['countReviews']){
			$this->data['isdata']=true;
		}
        
        $this->data['navigationHeading'] = 'Performances &amp; Events';
        $this->data['navigationListing'] = array('Film &amp; Video Events','Upcoming Film &amp; Video Events','Notices of Film &amp; Video Events','Reviews of Film &amp; Video Events',
        'News about Film &amp; Video Events');
        
		$this->new_version->load('new_version','landingpage/landingpage',$this->data);
	}
	
	function landingPageProject(){	
		$userId=0;
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 9;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$projectEntityId = getMasterTableRecord('Events');
		$result= $this->model_performancesnevents->getEvents($limit,$offset);
		$returnData = array();
		if($result && is_array($result) && count($result)>0){
			
			foreach($result as $data){
				$returnData[]=$this->load->view('landingpage/event_listing',array('data'=>$data,'projectEntityId'=>$projectEntityId), true);
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
		
		$industryKey = $this->config->item('PETYPE');
		
		$entityId = getMasterTableRecord('NewsElement');
		
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 9;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$result= $this->model_common->getProjectElements($userId,$this->config->item('newsPrifix'),0,$orderby,$order,$fetchElementFields,$industryKey,$entityId,$limit,$offset);
		$returnData = array();
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
				$returnData[]=$this->load->view('landingpage/news_listing',array('data'=>$data), true);
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
		
		$industryKey = $this->config->item('PETYPE');
		
		$entityId = getMasterTableRecord('ReviewsElement');
		
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 9;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$result= $this->model_common->getProjectElements($userId,$this->config->item('reviewsPrifix'),0,$orderby,$order,$fetchElementFields,$industryKey,$entityId,$limit,$offset);
		$returnData = array();
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
				$returnData[]=$this->load->view('landingpage/reviews_listing',array('data'=>$data), true);
			}
		}
		echo  json_encode($returnData);	
	}
	
	function landingPageUpcoming(){	
		$industryKey = $this->config->item('PETYPE');
		
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 9;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$result= $this->model_common->getUpcomingProjects($industryId=0,$projUpType=2,$limit,$offset);
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
