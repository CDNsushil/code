<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 * Todasquare frontend Controller Class
 *
 *  Manage Frontend Details ( Enterprise)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 *
 **/
 
class enterprises extends MX_Controller {
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
				'model'		=> 'model_enterprises',  	
				'language' 	=> 'showcase',							
				'config'		=>	'media/media'   		
			);
			parent::__construct($load);		
			$this->dirCacheMedia = ROOTPATH.'cache/enterprises/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/enterprises/'; 
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
        $IndustryId = $this->config->item('filmnvideoSectionId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageProject/'.$IndustryId);
        $this->data['navigationHeading'] = $this->lang->line('FvBusinesses');
        $this->landingpage('countMemberFv');
	}
    public function photographyart() {
        $IndustryId = $this->config->item('photographynartSectionId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageProject/'.$IndustryId);
        $this->data['navigationHeading'] = $this->lang->line('PaBusinesses');
        $this->landingpage('countMemberPa');
	}
    
    public function musicaudio() {
        $IndustryId = $this->config->item('musicnaudioSectionId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageProject/'.$IndustryId);
        $this->data['navigationHeading'] = $this->lang->line('MaBusinesses');
        $this->landingpage('countMemberMa');
	}
    
    public function writingpublishing() {
        $IndustryId = $this->config->item('writingnpublishingSectionId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageProject/'.$IndustryId);
        $this->data['navigationHeading'] = $this->lang->line('WpBusinesses');
        $this->landingpage('countMemberWp');
	}
    
    public function performingarts() {
        $IndustryId = $this->config->item('performingartsSectionId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageProject/'.$IndustryId);
        $this->data['navigationHeading'] = $this->lang->line('ArtBusinesses');
        $this->landingpage('countMemberArt');
	}
    
    public function craved() {
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/cravedProject/');
        $this->data['navigationHeading'] = $this->lang->line('FvBusinesses');
        $this->data['scroll'] = false;
        $this->landingpage('countCravedProject');
	}
    
   
    public function reviews() {
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageReviews');
        $this->data['navigationHeading'] = $this->lang->line('reviewsBusinesses');
        $this->data['comingsoon']= array('msg'=>$this->lang->line('ComingSoon'));
        $this->data['innerView'] = 'landingpage/one_column';
        $this->landingpage('countReviews');
	}
    
    public function news() {
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageNews');
        $this->data['navigationHeading'] = $this->lang->line('newsBusinesses');
        $this->data['comingsoon']= array('msg'=>$this->lang->line('ComingSoon'));
        $this->data['innerView'] = 'landingpage/one_column';
        $this->landingpage('countNews');
	}
    
    public function landingpage($cd = 'countCravedProject') {
		$this->data['projectType'] = 'enterprises';
        $this->getNavigation($cd);
        if($this->data[$cd]){
            if(!isset($this->data['innerView'])){
                $this->data['innerView']= 'landingpage/business_four_column';
                $this->data['bgColor']= 'bge8e8e8';
                $this->data['saprator']= 'sap_25';
                $this->data['containerWidth']= 'width905';
            }
        }else{
            if(!isset($this->data['comingsoon'])){
                $loggedUserId=isloginUser(); 
                if($loggedUserId){
                    $this->data['comingsoon']= array('msg'=>$this->lang->line('ComingSoon'));
                }else{
                    $this->data['comingsoon']= array('msg'=>$this->lang->line('BetheFirst'),'title'=>$this->lang->line('createShowcase'),'url'=>base_url(lang().'/showcase/showcasetype'));
                }
            }
            $this->data['innerView'] =  'landingpage/comingsoon'; 
        }
		$this->new_version->load('new_version','landingpage/landingpage',$this->data);
	}
    
    
    function getNavigation($cd = 'countCravedProject'){
        $where=array('sc.isPublished'=>'t', 'sc.enterprise'=>'t');
        $industryId = $this->config->item('enterprisesSectionId');
        
		$this->data['countCravedProject'] = $this->model_common->countMembers($where,true);
		
        if($cd == 'countMemberFv'){
            $where['sc.industryId']=$this->config->item('filmnvideoSectionId');
            $this->data['countMemberFv'] = $this->model_common->countMembers($where);
        }
        if($cd == 'countMemberPa'){  
            $where['sc.industryId']=$this->config->item('photographynartSectionId');
            $this->data['countMemberPa'] = $this->model_common->countMembers($where);
        }
        if($cd == 'countMemberMa'){     
            $where['sc.industryId']=$this->config->item('musicnaudioSectionId');
            $this->data['countMemberMa'] = $this->model_common->countMembers($where);
        }
        if($cd == 'countMemberWp'){      
            $where['sc.industryId']=$this->config->item('writingnpublishingSectionId');
            $this->data['countMemberWp'] = $this->model_common->countMembers($where);
        }
        if($cd == 'countMemberArt'){      
            $where['sc.industryId']=$this->config->item('performingartsSectionId');
            $this->data['countMemberArt'] = $this->model_common->countMembers($where);
        }
        if($cd == 'countNews'){      
            $this->data['countNews'] = $this->model_common->countResult('NewsElement', array('isPublished'=>'t','industryId'=>$industryId));
        }
        if($cd == 'countReviews'){      
            $this->data['countReviews'] = $this->model_common->countResult('ReviewsElement', array('isPublished'=>'t','industryId'=>$industryId));
        }    

        $module = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        $this->data['module']=$module;
        $this->data['method']=$method;

        if($this->data['countCravedProject']){
            $craveUrl = ($method  == 'craved') ? 'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'craved');
            $this->data['craveNav']['craved'] = array('title'=>$this->lang->line('ViewTop10Craved'),'url'=>$craveUrl);
        }
        $url = ($method == 'index' || $method == '' )?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'index');
        $this->data['navigations']['index'] = array('title'=>$this->lang->line('FvBusinesses'),'url'=>$url);

        $url = ($method == 'performingarts')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'performingarts');
        $this->data['navigations']['performingarts'] = array('title'=>$this->lang->line('ArtBusinesses'),'url'=>$url);

        $url = ($method == 'photographyart')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'photographyart');
        $this->data['navigations']['photographyart'] = array('title'=>$this->lang->line('PaBusinesses'),'url'=>$url);

        $url = ($method == 'musicaudio')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'musicaudio');
        $this->data['navigations']['musicaudio'] = array('title'=>$this->lang->line('MaBusinesses'),'url'=>$url);

        $url = ($method == 'writingpublishing')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'writingpublishing');
        $this->data['navigations']['writingpublishing'] = array('title'=>$this->lang->line('WpBusinesses'),'url'=>$url);

        $url = ($method == 'reviews')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'reviews');
        $this->data['navigations']['reviews'] = array('title'=>$this->lang->line('reviewsBusinesses'),'url'=>$url);

        $url = ($method == 'news')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'news');
        $this->data['navigations']['news'] = array('title'=>$this->lang->line('newsBusinesses'),'url'=>$url);

    }
	
	function cravedProject(){	
		$userId=0;
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$defaultProfileImage = $this->config->item('defaultEnterpriseImg_m');
		
		$where=array('sc.isPublished'=>'t', 'sc.enterprise'=>'t');
		$result= $this->model_common->getMembersTopCraved($where,$limit,$offset); 
		
		$returnData = array();
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
				$returnData[]=$this->load->view('landingpage/member_listing',array('data'=>$data,'defaultProfileImage'=>$defaultProfileImage), true);
			}
		}
		echo  json_encode($returnData);	
	}
	
	function landingPageProject($IndustryId=0){	
		$userId=0;
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$defaultProfileImage = $this->config->item('defaultEnterpriseImg_m');
		
		$where=array('sc.isPublished'=>'t', 'sc.enterprise'=>'t');
        if($IndustryId > 0){
            $where['sc.industryId'] = $IndustryId;
        }
		$result= $this->model_common->getMembers($where,$limit,$offset); 
		
		$returnData = array();
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
				$returnData[]=$this->load->view('landingpage/enterprise_listing',array('data'=>$data,'defaultProfileImage'=>$defaultProfileImage), true);
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
		
		$industryKey = $this->config->item('EnterprisesTYPE');
		
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
		
		$industryKey = $this->config->item('EnterprisesTYPE');
		
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
	
	
}

/* End of file frontend.php */
/* Location: ./application/module/frontend/frontend.php */
