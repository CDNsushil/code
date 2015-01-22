<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 * Todasquare frontend Controller Class
 *
 *  Manage Frontend Details ( Creatives)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 *
 **/
 
class works extends MX_Controller {
	private $data = array();
	private $dirCacheMedia = '';
	private $dirUploadMedia = '';
	private $tableUserShowcase = 'UserShowcase';
	private $tableUserAuth = 'UserAuth';
	
	private $userId = null;
	private $IndustryId = 0;
	/**
	 * Constructor
	 */
	 
	 function __construct() {
		//Load required Model, Library, language and Helper files
			$load = array(
				'model'		=> 'model_works'  	
				//'language' 	=> 'media/media',							
				//'config'		=>	'media/media'   		
			);
			parent::__construct($load);		
			
			//$this->head->add_css($this->config->item('system_css').'frontend.css');
			//$this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
			//$this->head->add_js($this->config->item('frontend_js').'jquery.anythingslider.js');
			//$this->head->add_js($this->config->item('frontend_js').'jquery.tinycarousel.min.js');
			//$this->head->add_js($this->config->item('frontend_js').'jquery-gallery-cdn.js');
			
			//$this->userId= $this->isLoginUser();
			// Load  path of css and cache file path
			$this->dirCacheMedia = ROOTPATH.'cache/works/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/works/'; 
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
		
		$this->data['bodyClass'] = 'Work_Seamless';
		
		$this->data['projectType'] = 'work';
		$this->data['frontendMathod'] = 'workshowcase';
		$this->data['top_craved_view'] = 'top_craved_work';
		$this->data['bannerImage']=array('banner_front_work_find-colleagues_HR.jpg','banner_front_work_get-working-copy_HR.jpg');
		$this->data['dashbordButton']="<span>".$this->lang->line('uploadButtonAdvertise')."</span>";
		$this->data['defaultProfileImage'] = $this->config->item('defaultWorkOffered_m');
		$this->data['bdr']='bdr_Dgreen10';
		   
		$this->data['projectEntityId'] = getMasterTableRecord('Work');
		
		$this->data['workOurl'] = base_url(lang().'/works/landingPageProject/offered');
		$this->data['work0Uurl'] = base_url(lang().'/works/landingPageProject/offered/0/1');
		$this->data['workOEurl'] = base_url(lang().'/works/landingPageProject/offered/1');
		$this->data['workWurl'] = base_url(lang().'/works/landingPageProject/wanted');
		$this->data['workWEurl'] = base_url(lang().'/works/landingPageProject/wanted/1');
		
		$this->data['countOwork'] = $this->model_common->countResult('Work', array('workArchived'=>'f','isPublished'=>'t', 'workType'=>'offered'), '', 1);
		$this->data['countUOwork'] = $this->model_common->countResult('Work', array('workArchived'=>'f','isPublished'=>'t', 'isUrgent'=>'t', 'workType'=>'offered'), '', 1);
		$this->data['countEOwork'] = $this->model_common->countResult('Work', array('workArchived'=>'f','isPublished'=>'t', 'workExperiece'=>'t', 'workType'=>'offered'), '', 1);
		$this->data['countEWwork'] = $this->model_common->countResult('Work', array('workArchived'=>'f','isPublished'=>'t', 'workExperiece'=>'t', 'workType'=>'wanted'), '', 1);
		$this->data['countWwork'] = $this->model_common->countResult('Work', array('workArchived'=>'f','isPublished'=>'t','workType'=>'wanted'), '', 1);
		
		$this->data['isdata']=false;
		if($this->data['countOwork'] || $this->data['countWwork']){
			$this->data['isdata']=true;
		}
		
        $this->data['navigationHeading'] = 'Work';
        $this->data['navigationListing'] = array('Work');

		$this->new_version->load('new_version','landingpage/landingpage',$this->data);
	}
	
	function landingPageProject($workType='',$workExperiece=0,$isUrgent=0){	
		$userId=0;
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 9;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$where=array('w.workArchived'=>'f','w.isPublished'=>'t');
		if($workType!=''){
			$where['w.workType']=$workType;
		}
		if(is_numeric($workExperiece) && $workExperiece ==1){
			$where['w.workExperiece']='t';
		}
		if(is_numeric($isUrgent) && $isUrgent ==1){
			$where['w.isUrgent']='t';
		}
		
		$result= $this->model_works->getWorks($where,$limit,$offset);
		
		$returnData = array();
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
				$returnData[]=$this->load->view('landingpage/work_listing',array('data'=>$data,'defaultProfileImage'=>$defaultProfileImage), true);
			}
		}
		echo  json_encode($returnData);	
	}
		
	public function frontworks($userId=0,$section=array('news','reviews')) {
		
		$orderby='elementId';
		
		$elementOrderBy='modifyDate';
		
		$order='DESC';
		
		$fetchFields = 'projId,projBaseImgPath';
		
		$fetchElementFields = '';
		
		$this->data['workOffered_array'] =  $this->model_works->getWorks(array('w.workArchived'=>'f','w.isPublished'=>'t'));
		
		$this->data['workWanted_array'] =  $this->model_works->getWorks(array('w.workArchived'=>'f','w.isPublished'=>'t','w.workType'=>'wanted'));
		
		$this->data['workEntityId'] = getMasterTableRecord('Work');
		
		$this->template->load('frontend','works',$this->data);
		
	}
	
		
}
