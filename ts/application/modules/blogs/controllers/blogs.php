<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Todasquare blog Controller Class
 *
 *  Manage blog details (Posts,Comments,Published/Unpublished,Archived/Unarchived,Insert/Update etc)
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */

Class blogs extends MX_Controller {
	
	private $blogPath = '';
	private $postPath = '';
	private $userId = NULL;
	private $allowed_image_size = '';
	private $blogTable = 'Blogs';
	private $postTable = 'Posts';
	private $mediaFile = 'MediaFile';
	private $postMediaTable = 'PostGallery';
	private $blog_allowed_upload_image_size_unit = '';
	private $blog_allowed_image_type = '';
	private $data;
	
	/**
	 * Constructor
	**/
	function __construct(){
	
	  //My own constructor code
	  $load = array(
			'model'		=> 'model_blogs + blogshowcase/model_blogshowcase',
			'library' 	=> 'form_validation + upload + session + lib_sub_master_media',
			'language' 	=> 'post +blog',
			'helper' 	=> 'form + file + archive'			
	  );
		
	parent::__construct($load); 
	
        $this->config->load('image_config');	
        $this->blogPath = "media/".LoginUserDetails('username')."/blog/" ;
        $this->postPath = "media/".LoginUserDetails('username')."/blog/post" ;
        //add advertising module if exists
        if(is_dir(APPPATH.'modules/advertising')){
            $this->load->model(array('advertising/model_advertising'));
        }
	}
	
	public function index() {
        $IndustryId = $this->config->item('filmnvideoSectionId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPagePost/'.$IndustryId);
        $this->data['navigationHeading'] = $this->lang->line('FvPost');
        $this->landingpage('countPostFv');
	}
    public function photographyart() {
        $IndustryId = $this->config->item('photographynartSectionId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPagePost/'.$IndustryId);
        $this->data['navigationHeading'] = $this->lang->line('PaPost');
        $this->landingpage('countPostPa');
	}
    
    public function musicaudio() {
        $IndustryId = $this->config->item('musicnaudioSectionId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPagePost/'.$IndustryId);
        $this->data['navigationHeading'] = $this->lang->line('MaPost');
        $this->landingpage('countPostMa');
	}
    
    public function writingpublishing() {
        $IndustryId = $this->config->item('writingnpublishingSectionId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPagePost/'.$IndustryId);
        $this->data['navigationHeading'] = $this->lang->line('WpPost');
        $this->landingpage('countPostWp');
	}
    
    public function educationmaterial() {
        $IndustryId = $this->config->item('educationmaterialSectionId');
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPagePost/'.$IndustryId);
        $this->data['navigationHeading'] = $this->lang->line('WpPost');
        $this->landingpage('countPostEm');
	}
    
    public function others() {
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/landingPagePost/'.$IndustryId);
        $this->data['navigationHeading'] = $this->lang->line('WpPost');
        $this->landingpage('countPostOthers');
	}
    
    public function craved() {
        $this->data['dataURL'] = base_url(lang().'/'.$this->router->fetch_class().'/cravedProject/');
        $this->data['navigationHeading'] = $this->lang->line('FvPost');
        $this->data['scroll'] = false;
        $this->landingpage('countCravedProject');
	}
    
    public function landingpage($cd = 'countPostFv') {
		$this->data['projectType'] = 'blog';
        $this->getNavigation($cd);
        
        if($this->data[$cd]){
            $this->data['innerView'] = 'landingpage/media_landing';
        }else{
           $this->data['comingsoon']= array('msg'=>$this->lang->line('ComingSoon'));
           $this->data['innerView'] = 'landingpage/comingsoon'; 
        }
		$this->new_version->load('new_version','landingpage/landingpage',$this->data);
	}
    
    
    function getNavigation($cd = 'countCravedProject'){
        $whereNotIn =array();
        $where=array('Posts.isPublished'=>'t', 'Posts.postArchived'=>'f');
        $this->data['countCravedProject'] = $this->model_blogs->countPost($where, '', '', 0,true);
        
        if($cd == 'countPostFv'){
            $whereNotIn[] = $where['Blogs.blogIndustry'] = $this->config->item('filmnvideoSectionId');
            $this->data['countPostFv'] = $this->model_blogs->countPost($where);
        }if($cd == 'countPostPa'){
            $whereNotIn[] = $where['Blogs.blogIndustry'] = $this->config->item('photographynartSectionId');
            $this->data['countPostPa'] = $this->model_blogs->countPost($where);
        }if($cd == 'countPostMa'){    
            $whereNotIn[] = $where['Blogs.blogIndustry'] = $this->config->item('musicnaudioSectionId');
            $this->data['countPostMa'] = $this->model_blogs->countPost($where);
       }if($cd == 'countPostWp'){     
            $whereNotIn[] = $where['Blogs.blogIndustry'] = $this->config->item('writingnpublishingSectionId');
            $this->data['countPostWp'] = $this->model_blogs->countPost($where);
        }if($cd == 'countPostEp'){    
            $whereNotIn[] = $where['Blogs.blogIndustry'] = $this->config->item('educationmaterialSectionId');
            $this->data['countPostEp'] = $this->model_blogs->countPost($where);
        }if($cd == 'countPostOthers'){    
            $where=array('Posts.isPublished'=>'t', 'Posts.postArchived'=>'f');
            $this->data['countPostOthers'] = $this->model_blogs->countPost($where,'Blogs.blogIndustry', $whereNotIn,1);
		}

        $module = $this->router->fetch_class();
        $method = $this->router->fetch_method();
        
        $this->data['module']=$module;
        $this->data['method']=$method;
        
        if($this->data['countCravedProject']){
            $craveUrl = ($method  == 'craved') ? 'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'craved');
            $this->data['craveNav']['craved'] = array('title'=>$this->lang->line('ViewTop10Craved'),'url'=>$craveUrl);
        }
        
       $url = ($method == 'index' || $method == '')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'index');
       $this->data['navigations']['index'] = array('title'=>$this->lang->line('FvPost'),'url'=>$url);
    
       $url = ($method == 'photographyart')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'photographyart');
       $this->data['navigations']['photographyart'] = array('title'=>$this->lang->line('PaPost'),'url'=>$url);
       $url = ($method == 'musicaudio')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'musicaudio');
       $this->data['navigations']['musicaudio'] = array('title'=>$this->lang->line('MaPost'),'url'=>$url);
    
       $url = ($method == 'writingpublishing')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'writingpublishing');
       $this->data['navigations']['writingpublishing'] = array('title'=>$this->lang->line('WpPost'),'url'=>$url);
   
       $url = ($method == 'reviews')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'educationmaterial');
       $this->data['navigations']['reviews'] = array('title'=>$this->lang->line('EmPost'),'url'=>$url);
   
       $url = ($method == 'news')?'javascript:void(0);':base_url(lang().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'others');
       $this->data['navigations']['news'] = array('title'=>$this->lang->line('othersPost'),'url'=>$url);
        
    }
	
	function cravedProject($industryId=0){	
		if(!is_numeric($industryId))  $industryId = 0;	 
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 9;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$postdata = $this->model_blogs->getMainPosts(0,0,$industryId,0,$limit,$offset);
		$returnData = array();
		if($postdata && is_array($postdata) && count($postdata)>0){
			foreach($postdata as $data){
				$returnData[]=$this->load->view('landingpage/post_listing',array('data'=>$data), true);
			}
		}
		echo  json_encode($returnData);		
	}
	
	function landingPagePost($industryId=0)
	{	
		if(!is_numeric($industryId))  $industryId = 0;	 
		$limit = $this->input->post('limit');
		$limit = is_numeric($limit) ? $limit : 9;
		$offset = $this->input->post('offset');
		$offset = is_numeric($offset) ? $offset : 0;
		
		$postdata = $this->model_blogs->getMainPosts(0,0,$industryId,0,$limit,$offset);
		$returnData = array();
		if($postdata && is_array($postdata) && count($postdata)>0){
			foreach($postdata as $data){
				$returnData[]=$this->load->view('landingpage/post_listing',array('data'=>$data), true);
			}
		}
		echo  json_encode($returnData);	
	}	
	
	function frontpost($userId=0,$postId=0)
	{
	 //redirectTohome($userId);	 
	 $frontPostDetail = $this->model_blogshowcase->getFrontPost($postId,$userId);
	 
	
	
	 if(isset($frontPostDetail[0])&&(count($frontPostDetail[0])>0) && $frontPostDetail[0]!='')
	 {
		if($frontPostDetail[0]->blogIndustry!='')
		{
			$industryTitle = getIndustry($frontPostDetail[0]->blogIndustry);
			$frontPostDetail['industryTitle'] = $industryTitle;
		}
		else
		$frontPostDetail['industryTitle'] = '';
		
		if($frontPostDetail[0]->blogLanguage!='')
		{
			$blogLanguage = getLanguage($frontPostDetail[0]->blogLanguage);
			$frontPostDetail['blogLanguage'] = $blogLanguage;
		}
		else
			$frontPostDetail['blogLanguage'] = '';
			
		if($frontPostDetail[0]->blogToDonate!='')
		{
			
			$frontPostDetail['blogToDonate'] = $frontPostDetail[0]->blogToDonate;
		}
		else
			$frontPostDetail['blogToDonate'] = '';
			
		if($frontPostDetail[0]->rating!='')
		{
			$blogRating = getMasterRating($frontPostDetail[0]->rating);
			$frontPostDetail['blogRating'] = $blogRating;
		}
		else
			$frontPostDetail['blogRating'] = '';
			
			$frontPostDetail['postData'] = $frontPostDetail[0];
	 }
	 else {
		 redirect(base_url('blogs/frontblog/'.$userId));
	 }
	 //print_r($frontPostDetail);
	 $frontPostDetail['label'] = $this->lang->language ;
	 $frontPostDetail['entityId'] = getMasterTableRecord($this->postTable);
	 $frontPostDetail['postsTable'] = $this->postTable;
	 
	 /* Update view count */
	$viewEntityId = $frontPostDetail['entityId'];
	if((!empty($viewEntityId)) && (!empty($postId))){
		$sectionId = $this->config->item('blogsSectionId');
		manageViewCount($viewEntityId,$postId,$userId,$postId,$sectionId);
	} 
	 
	//manage advert types if exists
	if(is_dir(APPPATH.'modules/advertising')) {
		//Get blog section id
		$sectionId = $this->config->item('blogsSectionId');
		//Get banner records based on section and advert type
		$bannerType1 = $this->model_advertising->getBannerRecords($sectionId,1,1);
		$bannerType2 = $this->model_advertising->getBannerRecords($sectionId,2,1);
		$bannerType3 = $this->model_advertising->getBannerRecords($sectionId,3,1);
		$frontPostDetail['advertSectionId'] = $sectionId; //set advert section id
		//Load view of advert js functions
		$frontPostDetail['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$sectionId),true);
	}  
	 
	 if($postId ==0){
		$breadcrumbItem = array('frontblog','frontcatposts');
		$breadcrumbURL = array('blogs/frontblog/'.$userId,'blogs/frontcatposts/'.$userId);
	 }
	 else{
		$breadcrumbItem = array('frontblog','frontpost');
		$breadcrumbURL = array('blogs/frontblog/'.$userId,'blogs/frontpost/'.$userId.'/'.$postId);
	 }		
	
	 $breadcrumbString = set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
	 $frontPostDetail['breadcrumbString'] = $breadcrumbString;
	 $this->template_front_end->load('template_front_end','blogshowcase/front_post_detail',$frontPostDetail);
	 		  
	}
	/**
		*	All Child Posts related functions
	**/
	function childposts($userId=0,$parentPostId=0)
	{	
		if($userId==0 || $userId=='') $userId = $this->userId;
		
		if(@$userId=='') $userId = 0;
		
		//if no userId is defined in url or not user is logged-in
		//if($userId==0)
		//	redirectTohome($userId);
	 
		
		$CurentBlogId = $this->model_blogshowcase->getBlogId($userId);  
		
		//Check if no blog is posted for logged-in user
		
		if(count($CurentBlogId)<=0)
		{
			 $blogId = 0;					
		}
		else
		{			
			$blogId = $CurentBlogId[0]->blogId;
		}
		
		$data  = $this->model_blogshowcase->getChildPosts($parentPostId);
		$data['parentPost'] = $this->model_blogshowcase->getParentPost($parentPostId);
		$data['parentPost']=@$data['parentPost'][0];
		$data['blogId'] = $blogId ;
		$data['label'] = $this->lang->language ;
		$data['postsTable']=$this->postTable;
		$data['entityId'] = getMasterTableRecord($this->postTable);
		$this->template_front_end->load('template_front_end','blogshowcase/child_posts',$data);
	}
	
/**
	* Displays the Posts for selected Category
	* 		
	* Loads the template 
**/

	function frontRight($frontRightData=array('userId'=>'0','blogId'=>'0'))
	{	
		
		$frontRightData['label'] = $this->lang->language;		
		//echo '<pre />';print_r($frontRightData);
		$this->load->view('front_post_right',$frontRightData);
	}
	
	
/**
	* Displays the categories which are elated with posts
	* @param int blogId		
	* Loads the categories 
**/
	
	function postCategories($userId=0,$blogId=0)
	{	
	
		$catData['label'] = $this->lang->language;		
		$catData['blogId'] = $blogId;		
		$blogCategoryId = $this->model_blogshowcase->getPostsCategory($userId); 
		
		$catData['catList'] =array();
		
		//echo count($blogCategoryId);
		
		if(count($blogCategoryId)>0) 
			$catData['catList'] = $blogCategoryId;
		else
		{
			while (list($catkey, $catvalue) = each($blogCategoryId)) {
					$catData['catList'][$catvalue->categoryId]=$catvalue->categoryTitle;
			}
		}
		
		//	echo '<pre />';		print_r($catData['catList'] );
		
		$this->load->view('post_categories',$catData);
	}
	
	
	function front_posts($userId=0,$industryId=0)
	{
	 
	 if($userId<0 && $userId!='')  $userId = 0;	 
	// redirectTohome($userId);
	 
	 $blogId = 0;
	 
	 $frontBlogData['label'] = $this->lang->language ;
	 
	 $resultIndustries = loadIndustry();
		
	//Select Industries
	$frontBlogData['industryList'][''] =  $this->lang->language['selectIndustry'];
			
	foreach ($resultIndustries as $resultIndustry)
	{
		$frontBlogData['industryList'][$resultIndustry->IndustryId] = $resultIndustry->IndustryName;
	}
	 
	 $frontBlogData['blogPostsData'] = $this->model_blogs->getPosts($userId,$blogId,$industryId);
	
	 $this->template->load('template_front_end','front_posts',$frontBlogData);	
	  
	}

/*
	* Displays the Archives Posts for particular month and year
	* @params int archiveMonth
	* @params int archiveYear
	
	* Loads the template 
*/
function frontArchivesPost($userId=0,$month=0,$year=0)
{
	
	if(isset($month) && $month > 0)
		$archiveMonth = $month;
	else
		$archiveMonth = 0;
	
	
	if(isset($year) && $year > 0)
		$archiveYear = $year;
	else
	{
		$archiveYear = $archiveMonth;
		$archiveMonth = 0;			
	}
		
	$this->data['blogPostsData'] = $this->data['postResults'] = $this->model_blogshowcase->previewArchivesPost($archiveMonth,$archiveYear,$userId);	
	if(count($this->data['blogPostsData'])<=0) redirectToNorecord404();
	//$archivePostDetailResults['blogPostsData']  = $archivePostDetailResults['postResults'];
	$blogdetail = $this->model_blogshowcase->getBlogDetail($userId);
	$this->data['blogId'] = $blogdetail['blogId'];		
	$this->data['blogTwitterLink'] = $blogdetail['blogTwitterLink'];		
	$this->data['blogToTwitter'] = $blogdetail['blogToTwitter'];	
	$this->data['blogToDonate'] = $blogdetail['blogToDonate'];	
	$this->data['label'] = $this->lang->language;		
	$this->data['entityId'] = getMasterTableRecord($this->postTable);
	$this->template_front_end->load('template_front_end','front_cat_posts',$this->data);

}

/**
	* Displays the Posts for selected Category
	* 		
	* Loads the template 
	* 
**/
function frontcatposts($userId=0,$catId=0,$blogId=0){			
	/*
	$sortPostBy = 'dateCreated';
		
		$catPostsData = $this->model_blogshowcase->getCatPosts($userId,$catId,$blogId,$sortPostBy);
		//print_r($catPostsData);
		$catPostsData['blogTwitterLink'] = @$catPostsData['postResults'][0]->blogTwitterLink;
		$catPostsData['blogToTwitter'] = @$catPostsData['postResults'][0]->blogToTwitter;
		$catPostsData['blogToDonate'] = @$catPostsData['postResults'][0]->blogToDonate;
		$catPostsData['blogId'] = $blogId;
		 	
		$catPostsData['label'] = $this->lang->language;
		$catPostsData['entityId'] = getMasterTableRecord($this->postTable);
		$breadcrumbItem = array('showcase','frontblog','frontcatposts');
		$breadcrumbURL = array('showcase/aboutme/'.$userId,'blogshowcase/frontblog/'.$userId,'blogshowcase/index/'.$userId);
		$breadcrumbString = set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$catPostsData['breadcrumbString'] = $breadcrumbString;	  
		$this->template_front_end->load('template_front_end','front_cat_posts',$catPostsData);
	*/
	$sortPostBy = 'dateCreated';
		
		$this->data['userId']=$userId;
		
		$where=($catId > 0)?array('custId'=>$userId,'blogCategoryId'=>$catId,'postArchived'=>'f'):array('custId'=>$userId,'postArchived'=>'f');
		$this->data['countResult']=$this->model_common->countResult($this->postTable,$where);	
		
		if($this->data['countResult']<=0) redirectToNorecord404();	
		
		$pages = new Pagination_ajax;
		$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$this->data['perPageRecord'] =$this->config->item('perPageRecordPosts');
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
		$pages->paginate();
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		
		$this->data['pagingLink'] = base_url(lang().'/blogshowcase/frontcatposts/'.$userId.'/'.$catId.'/'.$blogId);
		
		$this->data['postResults'] = $this->model_blogshowcase->getCatPosts($userId,$catId,$blogId,$sortPostBy,$pages->offst,$pages->limit);
		//print_r($this->data);
		$this->data['blogTwitterLink'] = @$this->data['postResults'][0]->blogTwitterLink;
		$this->data['blogToTwitter'] = @$this->data['postResults'][0]->blogToTwitter;
		$this->data['blogToDonate'] = @$this->data['postResults'][0]->blogToDonate;
		$this->data['blogId'] = $blogId;
		 	
		$this->data['label'] = $this->lang->language;
		$this->data['entityId'] = getMasterTableRecord($this->postTable);
	
		$breadcrumbItem=array('showcase','frontblog','frontcatposts');
		$breadcrumbURL=array('showcase/aboutme/'.$userId,'blogshowcase/frontblog/'.$userId,'blogshowcase/index/'.$userId);
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$this->data['breadcrumbString']=$breadcrumbString;	 
		$this->template_front_end->load('template_front_end','front_cat_posts',$this->data);
		
}


	function frontblog($userId=0,$blogId=0)
	{
		  //$userId=0;
		  $data['label'] = $this->lang->language;
		  $data['query'] = $this->model_blogshowcase->getUserBlog($userId); 
		  //$data['query'] =  @$data['query'][0]; 
		  //echo '<pre />';print_r($data['query']);
		  //echo $this->db->last_query();die;
				
			 // $totalPostsQuery  = $this->model_blogs->getPosts($data['query'][0]->blogId);
			//  $blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry,blogLanguage,rating','blogId',$data['query'][0]->blogId);
			
				if((count($data['query'][0])>0) && $data['query'][0]!='')
				{
					if(!empty($data['query'][0]->blogIndustry)) $data['industryTitle'] =  getIndustry($data['query'][0]->blogIndustry);						
					else $data['industryTitle'] = '';
					
					if(!empty($data['query'][0]->blogLanguage)) $data['blogLanguage'] = getLanguage($data['query'][0]->blogLanguage);						
					else $data['blogLanguage'] = '';
						
					if(!empty($data['query'][0]->rating)) $data['blogRating'] =  getMasterRating($data['query'][0]->rating);
					else $data['blogRating'] = '';
				}  
				else redirectToNorecord404();
				
				//$data['totalPosts']= count($totalPostsQuery);
				$data['entityId'] = getMasterTableRecord('Blogs');
				$breadcrumbItem = array('frontblog');
				$breadcrumbURL = array('blogs/frontblog/'.$userId);
				$breadcrumbString = set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
				$data['breadcrumbString'] = $breadcrumbString;
				
				/* Update view counts */
				$viewEntityId = $data['entityId'];
				if((isset($viewEntityId))){
					$sectionId = $this->config->item('blogsSectionId');
					manageViewCount($viewEntityId,$blogId,$userId,$blogId,$sectionId);
				} 
				
				if(!empty($data['query'][0]->blogTwitterLink)) $data['blogTwitterLink'] = $data['query'][0]->blogTwitterLink;
				else $data['blogTwitterLink'] = $data['query'][0]->blogTwitterLink;
				
				if(!empty($data['query'][0]->blogToTwitter)) $data['blogToTwitter'] = $data['query'][0]->blogToTwitter;
				else $data['blogToTwitter'] = 'f';
				
				//echo "<pre>";
				//print_r($data['query'][0]);die;
				$this->template_front_end->load('template_front_end','front_blog',$data);
			 // $this->template->load('frontend','front_blog',$data);	  
	}

}//End Class
?>
