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
 
class photographynart extends MX_Controller {
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
				'model'		=> 'photographynart/model_photographynart',  	
				'language' 	=> 'media + photographyNart',							
				'config'		=>	'media/media'   		
			);
			parent::__construct($load);		
			$this->dirCacheMedia = ROOTPATH.'cache/photographynart/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/photographynart/'; 
			$this->data['dirUploadMedia'] = $this->dirUploadMedia;
            $this->IndustryId = $this->config->item('photographynartSectionId'); 
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
        $catId = $this->config->item('PaAlbumCatId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageProject/'.$catId);
        $this->data['navigationHeading'] = $this->lang->line('PaAlbums');
        $this->data['comingsoon']= array('msg'=>$this->lang->line('BetheFirst'),'title'=>$this->lang->line('createYourMediaShowcase'),'url'=>base_url(lang().'/media/photographyart/'.$catId));
        $this->landingpage('countAlbum');
	}
    
    public function collections() {
        $catId = $this->config->item('PaCollectionCatId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageProject/'.$catId);
        $this->data['navigationHeading'] = $this->lang->line('PaCollections');
        $this->data['comingsoon']= array('msg'=>$this->lang->line('BetheFirst'),'title'=>$this->lang->line('createYourMediaShowcase'),'url'=>base_url(lang().'/media/photographyart/'.$catId));

        $this->landingpage('countCollection');
	}
    public function craved($cravedFor='') {
        
        if($cravedFor == 'photos'){
            $catId = $this->config->item('PaAlbumCatId');
            $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/cravedElements/'.$catId);
            $countString='countPhotos';
            $this->data['saprator'] = 'sap_15';
            $this->data['divClass'] = 'm_auto  clearb lp_pices_wrap pt30 pl25 pr25 pb5 bge5e7d9';
            $this->data['innerView'] = 'landingpage/one_column';
        }elseif($cravedFor == 'albums'){
            $catId = $this->config->item('PaAlbumCatId');
            $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/cravedProject/'.$catId);
            $countString='countAlbum';
        }
        elseif($cravedFor == 'artworks'){
            $catId = $this->config->item('PaCollectionCatId');
            $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/cravedElements/'.$catId);
            $countString='countArtworks';
             $this->data['saprator'] = 'sap_15';
            $this->data['divClass'] = 'm_auto  clearb lp_pices_wrap pt30 pl25 pr25 pb5 bge5e7d9';
            $this->data['innerView'] = 'landingpage/one_column';
        }else{
            $cravedFor = 'collections';
            $catId = $this->config->item('PaCollectionCatId');
            $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/cravedProject/'.$catId);
            $countString='countCollection';
        }
        $this->data['cravedFor'] = $cravedFor;
        $this->data['navigationHeading'] = $this->lang->line('PaAlbums');
        $this->data['scroll'] = false;
        $this->landingpage($countString);
	}
    
    public function upcoming() {
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageUpcoming');
        $this->data['navigationHeading'] = $this->lang->line('PaUpcoming');
        $this->landingpage('countUpcoming');
	}
    
    public function reviews() {
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageReviews');
        $this->data['navigationHeading'] = $this->lang->line('PaReviews');
        $this->data['innerView'] = 'landingpage/one_column';
        $this->landingpage('countReviews');
	}
    
    public function news() {
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPageNews');
        $this->data['navigationHeading'] = $this->lang->line('PaNews');
        $this->data['innerView'] = 'landingpage/one_column';
        $this->landingpage('countNews');
	}
    
    public function landingpage($cd = 'countAlbum') {
		$this->data['projectType'] = 'photographyNart';
        
        if(isset($this->data['cravedFor']) && ($this->data['cravedFor'] ==  'photos')){
             $this->data['craveHeading'] = $this->lang->line('PaTopCravedAlbumsElements');
        }
        elseif(isset($this->data['cravedFor']) && ($this->data['cravedFor'] ==  'artworks')){
             $this->data['craveHeading'] = $this->lang->line('PaTopCravedCollectionElements');
        }elseif(isset($this->data['cravedFor']) && ($this->data['cravedFor'] ==  'collections')){
             $this->data['craveHeading'] = $this->lang->line('PaTopCravedCollections');
        }else{
            $this->data['craveHeading'] = $this->lang->line('PaTopCravedAlbums');
        }
        
        $this->getNavigation($cd);
        if($this->data[$cd]){
            if(!isset($this->data['innerView'])){
                $this->data['innerView']= 'landingpage/photo_art_landing';
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
        $PaAlbumCatId = $this->config->item('PaAlbumCatId');
        $PaCollectionCatId = $this->config->item('PaCollectionCatId');
        
        $this->data['countCravedProject'] = $this->model_common->countProject('Project', array('isPublished'=>'t','isArchive'=>'f','projectType'=>$this->data['projectType']),true);
        $this->data['countCravedAlbum'] = $this->model_common->countProject('Project', array('projCategory'=>$PaAlbumCatId,'isPublished'=>'t','isArchive'=>'f','projectType'=>$this->data['projectType']),true);
        $this->data['countCravedCollection'] = $this->model_common->countProject('Project', array('projCategory'=>$PaCollectionCatId,'isPublished'=>'t','isArchive'=>'f','projectType'=>$this->data['projectType']),true);
        $this->data['countPhotos'] = $this->model_common->countProjectElements('PaElement', array('p.projCategory'=>$PaAlbumCatId,'p.isPublished'=>'t','p.isArchive'=>'f','e.isPublished'=>'t','e.isArchive'=>'f'),true);
        
        $this->data['countArtworks'] = $this->model_common->countProjectElements('PaElement', array('p.projCategory'=>$PaCollectionCatId,'p.isPublished'=>'t','p.isArchive'=>'f','e.isPublished'=>'t','e.isArchive'=>'f'),true);
        
        if($cd == 'countAlbum'){
            $this->data['countAlbum'] = $this->model_common->countProject('Project', array('projCategory'=>$PaAlbumCatId,'isPublished'=>'t','isArchive'=>'f','projectType'=>$this->data['projectType']));
        }
        if($cd == 'countCollection'){
            $this->data['countCollection'] = $this->model_common->countProject('Project', array('projCategory'=>$PaCollectionCatId,'isPublished'=>'t','isArchive'=>'f','projectType'=>$this->data['projectType']));
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
        
         
        
        if($this->data['countCravedAlbum']){
           $craveUrl = (isset($this->data['cravedFor']) && ($this->data['cravedFor']  == 'albums')) ? 'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'craved'.DIRECTORY_SEPARATOR.'albums');
           $this->data['craveNav']['albums'] = array('title'=>$this->lang->line('PaTopCravedAlbums'),'url'=>$craveUrl);
        }
        if($this->data['countCravedCollection']){
           $craveUrl = (isset($this->data['cravedFor']) && ($this->data['cravedFor']  == 'collections')) ? 'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'craved'.DIRECTORY_SEPARATOR.'collections');
           $this->data['craveNav']['collections'] = array('title'=>$this->lang->line('PaTopCravedCollections'),'url'=>$craveUrl);
        }
        if($this->data['countPhotos']){
           $craveUrl = (isset($this->data['cravedFor']) && ($this->data['cravedFor']  == 'photos'))?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'craved'.DIRECTORY_SEPARATOR.'photos');
           $this->data['craveNav']['photos'] = array('title'=>$this->lang->line('PaTopCravedAlbumsElements'),'url'=>$craveUrl);
        }
        if($this->data['countArtworks']){
           $craveUrl = (isset($this->data['cravedFor']) && ($this->data['cravedFor']  == 'artworks'))?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'craved'.DIRECTORY_SEPARATOR.'artworks');
           $this->data['craveNav']['artworks'] = array('title'=>$this->lang->line('PaTopCravedCollectionElements'),'url'=>$craveUrl);
        }
       $url = ($method == 'index' || $method == '')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'index');
       $this->data['navigations']['index'] = array('title'=>$this->lang->line('PaAlbums'),'url'=>$url);
       
       $url = ($method == 'collections')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'collections');
       $this->data['navigations']['collections'] = array('title'=>$this->lang->line('PaCollections'),'url'=>$url);
      
       $url = ($method == 'upcoming')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'upcoming');
       $this->data['navigations']['upcoming'] = array('title'=>$this->lang->line('PaUpcoming'),'url'=>$url);
       $url = ($method == 'reviews')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'reviews');
       $this->data['navigations']['reviews'] = array('title'=>$this->lang->line('PaReviews'),'url'=>$url);
       $url = ($method == 'news')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'news');
       $this->data['navigations']['news'] = array('title'=>$this->lang->line('PaNews'),'url'=>$url);
            
    }
    
    function cravedProject($catId=0){	
		$userId=0;
        $catId = (!empty($catId) && ($catId > 0)) ? $catId : $this->config->item('PaAlbumCatId');
        $where = array('Project.projCategory'=>$catId);
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		$projectElementEntityId = getMasterTableRecord('PaElement');
        $result= $this->model_common->getProjectRecord('photographyNart',$userId,$projectId=0,'projId,projSellstatus,projCategory,projName,projShortDesc,craveCount,imageFileCount,docFileCount,docCount,audioFileCount,cdCount,videoFileCount,dvdCount,ratingAvg,projCreateDate,projLastModifyDate,projBaseImgPath',$limit,$offset,'LogSummary.craveCount','DESC',$where); 
		$returnData = array();
		
		$projectData = array(
            'projectElementEntityId'=>$projectElementEntityId,
            'projectType'=>'photographyNart',
            'frontendMathod'=>'photographyart',
            'fileType_dwnld'=>$this->lang->line('imageFile')
        );
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
                if($data->projCategory == $this->config->item('PaAlbumCatId')){
                    $fileType_shipd = $this->lang->line('print');
                }else{
                    $fileType_shipd = $this->lang->line('Art');
                }
                $projectData['fileType_shipd']=$fileType_shipd;
                $projectData['data'] = $data;
				$returnData[]=$this->load->view('landingpage/photo_art_listing',$projectData, true);
			}
		}
		echo  json_encode($returnData);	
	}
    
    function cravedElements($catId=0){	
		$catId = (!empty($catId) && ($catId > 0)) ? $catId : $this->config->item('PaAlbumCatId');
        $where = array('Project.projCategory'=>$catId);
        
        $limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		$projectElementEntityId = getMasterTableRecord('PaElement');
		$result= $this->model_common->getProjectElementsLP('PaElement', $limit, $offset,$where); 


		$returnData = array();
        $projectData = array(
            'projectElementEntityId'=>$projectElementEntityId,
            'projectType'=>'photographyNart',
            'frontendMathod'=>'photographyart',
            'fileType_dwnld'=>$this->lang->line('imageFile'),
            'industry'=>$this->lang->line('PaIndustry'),
        );
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
                if($data->projCategory == $this->config->item('PaAlbumCatId')){
                    $fileType_shipd = $this->lang->line('print');
                }else{
                    $fileType_shipd = $this->lang->line('Art');
                }
                $projectData['fileType_shipd']=$fileType_shipd;
                $projectData['data'] = $data;
				$returnData[]=$this->load->view('landingpage/media_craved_listing',$projectData, true);
			}
		}
		echo  json_encode($returnData);	
	}
    
	function landingPageProject($catId=0){	
		$userId=0;
        $catId = (!empty($catId) && ($catId > 0)) ? $catId : $this->config->item('PaAlbumCatId');
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		$projectElementEntityId = getMasterTableRecord('PaElement');
        $where = array('Project.projCategory'=>$catId);
		$result= $this->model_common->getProjectRecord('photographyNart',$userId,$projectId=0,'projId,projSellstatus,projCategory,projName,projShortDesc,craveCount,imageFileCount,docFileCount,docCount,audioFileCount,cdCount,videoFileCount,dvdCount,ratingAvg,projCreateDate,projLastModifyDate,projBaseImgPath',$limit,$offset,'Project.projLastModifyDate','DESC',$where); 
        $returnData = array();
        
        if($catId == $this->config->item('PaAlbumCatId')){
            $fileType_shipd = array('printCount'=>$this->lang->line('print'));
        }else{
            $fileType_shipd = array('printCount'=>$this->lang->line('Art'));
        }
        
		$projectData = array(
            'projectElementEntityId'=>$projectElementEntityId,
            'projectType'=>'photographyNart',
            'frontendMathod'=>'photographyart',
            'fileType_dwnld'=>array('imageFileCount'=>$this->lang->line('image')),
            'fileType_shipd'=> $fileType_shipd,
            
        );
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
                $projectData['data'] = $data;
				$returnData[]=$this->load->view('landingpage/photo_art_listing',$projectData, true);
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
		
		$industryKey = $this->config->item('PATYPE');
		
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
		
		$industryKey = $this->config->item('PATYPE');
		
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
		$industryKey = $this->config->item('PATYPE');
		
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 10;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$result= $this->model_common->getUpcomingProjects($this->IndustryId,$this->config->item('mediaUpcomingTypeId'),$limit,$offset);
		$returnData = array();
		if($result && is_array($result) && count($result)>0){
			foreach($result as $data){
				$returnData[]=$this->load->view('landingpage/upcoming_listing',array('data'=>$data,'frontendMathod'=>'photographyart'), true);
			}
		}
		echo  json_encode($returnData);	
	}
	
}

/* End of file frontend.php */
/* Location: ./application/module/frontend/frontend.php */
