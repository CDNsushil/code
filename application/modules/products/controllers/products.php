<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 * Todasquare frontend Controller Class
 *
 *  Manage Frontend Details ( Products )
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 *	Date: 23-05-2013
 **/
 
class products extends MX_Controller {
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
				'model'		=> 'model_products',  	
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
			$this->dirCacheMedia = ROOTPATH.'cache/products/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/products/'; 
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
		
		$this->data['bodyClass'] = 'Product_Seamless';
		
		$this->data['projectType'] = 'product';
		$this->data['frontendMathod'] = 'productshowcase';
		$this->data['top_craved_view'] = 'top_craved_product';
		$this->data['bannerImage']=array('banner_front_products_trading-post_HR.jpg','banner_front_products_trash-treasure_HR.jpg');
		$this->data['dashbordButton']="<span>".$this->lang->line('uploadButtonAdvertise')."</span>";
		$this->data['defaultProfileImage'] = $this->config->item('defaultProductForSale_m');
		$this->data['bdr']='bdr_naviBlue10';
		$this->data['color_media']='clr_1d2f80';
		   
		$this->data['projectEntityId'] = getMasterTableRecord('Product');
		$this->data['newsEntityId'] = getMasterTableRecord('NewsElement');
		$this->data['reviewEntityId'] = getMasterTableRecord('ReviewsElement');
		
		
		$this->data['productSUrl'] = base_url(lang().'/products/landingPageProject/1');
		$this->data['productWUrl'] = base_url(lang().'/products/landingPageProject/2');
		$this->data['productFUrl'] = base_url(lang().'/products/landingPageProject/3');
		
		$this->data['newsUrl'] = base_url(lang().'/products/landingPageNews');
		$this->data['reviewssUrl'] = base_url(lang().'/products/landingPageReviews');
		
		$this->data['countSProduct'] = $this->model_common->countResult('Product', array('isPublished'=>'t','catId'=>1), '', 1);
		$this->data['countWProduct'] = $this->model_common->countResult('Product', array('isPublished'=>'t','catId'=>2), '', 1);
		$this->data['countFProduct'] = $this->model_common->countResult('Product', array('isPublished'=>'t','catId'=>3), '', 1);
		$this->data['countNews'] = $this->model_common->countResult('NewsElement', array('isPublished'=>'t','industryId'=>12), '', 1);
		$this->data['countReviews'] = $this->model_common->countResult('ReviewsElement', array('isPublished'=>'t','industryId'=>12), '', 1);
		
		if($this->data['countSProduct'] || $this->data['countWProduct'] || $this->data['countFProduct'] || $this->data['countNews'] || $this->data['countReviews']){
			$this->data['isdata']=true;
		}
        
        $this->data['navigationHeading'] = 'Product';
        $this->data['navigationListing'] = array('Product');
		
		$this->new_version->load('new_version','landingpage/landingpage',$this->data);
	}
	
	function landingPageProject($catId=0){	
		$userId=0;
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 9;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$catId=is_numeric($catId)?$catId:0;
		
		$result= $this->model_products->getProducts($catId,$limit,$offset);
		
		$returnData = array();
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
				$returnData[]=$this->load->view('landingpage/product_listing',array('data'=>$data), true);
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
		
		$industryKey = $this->config->item('ProductTYPE');
		
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
		
		$industryKey = $this->config->item('ProductTYPE');;
		
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
	
}

/* End of file frontend.php */
/* Location: ./application/module/frontend/frontend.php */
