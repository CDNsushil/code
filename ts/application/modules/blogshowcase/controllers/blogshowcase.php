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

Class blogshowcase extends MX_Controller {
	
	private $blogPath = '';
	private $postPath = '';
	private $dirCacheblog = '';
	private $dirCachePosts = '';
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
			'model'		=> 'model_blogshowcase',
			'library' 	=> 'form_validation + upload + session + lib_sub_master_media',
			'language' 	=> 'post +blog',
			'helper' 	=> 'form + file + archive'			
	  );
		
	parent::__construct($load); 
	
	$this->load->config('auth/tank_auth');
		
	$this->userId = isLoginUser();
	
	$this->config->load('image_config');
	$this->dirCacheblog = ROOTPATH.'cache/blogshowcase/'; 
	$this->dirCachePosts = ROOTPATH.'cache/posts/'; 
	$this->blogPath = "media/".LoginUserDetails('username')."/blog/" ;
	$this->postPath = "media/".LoginUserDetails('username')."/blog/post/" ;
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
	//$this->config->set_item('site_title', 'blog_settings');
	//add advertising module if exists
	if(is_dir(APPPATH.'modules/advertising')){
		$this->load->model(array('advertising/model_advertising'));
	}
	
	}

function index($userId=0,$blogId=0)
	{
		
		//echo $userId;die;
		if(! $userId > 0)
			$userId = $this->userId;	

		if(! $userId > 0) 
		{
			redirectToNorecord404();
		}

		$frontBlogData['userId'] = $userId;
		$frontBlogData['label'] = $this->lang->language ;

		$frontBlogData['blogDetail'] = $this->model_blogshowcase->getBlogDetail($userId);
		if(count($frontBlogData['blogDetail'])<=0)
		{
			$blogId = 0;

		}
		else
		{		
			$frontBlogData['blogId'] = $frontBlogData['blogDetail']['blogId'];
			$frontBlogData['blogTwitterLink'] = $frontBlogData['blogDetail']['blogTwitterLink'];
			$frontBlogData['blogToTwitter'] = $frontBlogData['blogDetail']['blogToTwitter'];
		}
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Get blog section id
			$sectionId = $this->config->item('blogsSectionId');
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($sectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($sectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($sectionId,3,1);
			$bannerType4 = $this->model_advertising->getBannerRecords($sectionId,4,1);
			$frontBlogData['advertSectionId'] = $sectionId; //set advert section id
			//Load view of advert js functions
			$frontBlogData['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'bannerType4'=>$bannerType4,'sectionId'=>$sectionId),true);
		} 
		
		$breadcrumbItem=array('showcase','frontblog','frontcatposts');
		$breadcrumbURL=array('showcase/aboutme/'.$userId, 'blogshowcase/frontblog/'.$userId, 'blogshowcase/index/'.$userId);
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$frontBlogData['breadcrumbString']=$breadcrumbString;
		$frontBlogData['entityId'] = getMasterTableRecord($this->postTable);
		
		if($frontBlogData['blogDetail']=='')
			redirectToNorecord404();
		else
			$this->template_front_end->load('template_front_end','front_blog_summary',$frontBlogData);	

	}
	
	/**
	 * 
	 * FOR FRONT PAGES
	 * 
	**/ 
	public function preview($userId=0,$id=0,$mathod='frontPostDetail',$extra='') 
	{
		$this->isLoginUser();
		if($this->userId > 0 && ($userId==$this->userId)){
			
		}else{
			redirectToNorecord404();
		}
		if(empty($extra)){
			if($mathod=='frontblog') {
				$this->$mathod($userId,$id,1);
			}else{
				$this->$mathod($userId,$id);
			}
		}else{
			$this->$mathod($userId,$id,$extra);
		}
	}


	function frontblog($userId=0,$blogId=0,$isPreview=0)
	{
		
		if($userId==0) $userId = $this->userId;
		if(@$userId=='') $userId = 0;

		//if($userId==0)
		//	redirectTohome($userId);

		$data['label'] = $this->lang->language ;
		$data['postSortBy'] = $this->input->post('sortPost');
		$data['query'] = $this->model_blogshowcase->getUserBlog($userId,$isPreview); 
		//echo '<pre />';print_r($data['query']);
		if(count($data['query']) == 0) 
		{
			redirectToNorecord404();
		}
		else
		{
			$data['totalPostsQuery']  = $this->model_blogshowcase->getPosts($data['query'][0]->blogId);
		
			//$blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry,blogLanguage,rating','blogId',$data['query'][0]->blogId);

			if((count($data['query'][0])>0) && $data['query'][0]!='')
			{
				if(isset($data['query'][0]->blogIndustry) && $data['query'][0]->blogIndustry!='')
				{
					$industryTitle = getIndustry($data['query'][0]->blogIndustry);
					$data['industryTitle'] = $industryTitle;
				}
				else
				$data['industryTitle'] = '';
			
				if($data['query'][0]->blogLanguage!='')
				{
					$blogLanguage = getLanguage($data['query'][0]->blogLanguage);
					$data['blogLanguage'] = $blogLanguage;
				}
				else
					$data['blogLanguage'] = '';
					
				if($data['query'][0]->rating!='')
				{
					$blogRating = getMasterRating($data['query'][0]->rating);
					$data['blogRating'] = $blogRating;
				}
				else
					$data['blogRating'] = '';
				
			}  

			$data['totalPosts']= count($data['totalPostsQuery']);

			$val1 = $this->input->post('val1'); 
			$data['entityId'] = getMasterTableRecord($this->blogTable);
			$blogId = $data['blogId'] = $data['query'][0]->blogId;
			$data['blogTwitterLink'] = $data['query'][0]->blogTwitterLink;
			$data['blogToTwitter'] = $data['query'][0]->blogToTwitter;
			/*if($userId>0){
				$cacheFileBlog = $this->dirCacheblog.'blog_'.$blogId.'_'.$userId.'.php';
				if(!is_file($cacheFileBlog))
				{							

					if(!is_dir($this->dirCacheblog)){
						@mkdir($this->dirCacheblog, 777, true);
					}

					$cmd3 = 'chmod -R 777 '.$this->dirCacheblog;
					exec($cmd3);

					//$refereshCacheWork  = LoginUserDetails('wanted_'.$workId.$userId);
					$refereshCacheBlog  = 1;
					if(1){				

						if(is_file($cacheFileBlog)){
						@unlink($cacheFileBlog);
						}

						$this->session->unset_userdata('blog_'.$blogId.'_'.$userId);

					}	

					if(!is_file($cacheFileBlog))
					{							

						if(!is_dir($this->dirCacheblog)){
							@mkdir($this->dirCacheblog, 777, true);
						}

						$cmd3 = 'chmod -R 777 '.$this->dirCacheblog;
						exec($cmd3);

						$dataBlog = str_replace("'","&apos;",json_encode( $data['query']));	//encode data in json format			
						$stringDataBlog = '<?php $blogs=\''.$dataBlog.'\';?>';

						if (!write_file($cacheFileBlog, $stringDataBlog)){					// write cache file
							echo 'Unable to write the file';
						}

					}

					require_once ($cacheFileBlog);		
					$BlogData = json_decode($blogs, true);	
				}
			}*/
			
			/* Update view counts */
			$viewEntityId = $data['entityId'];
			if((isset($viewEntityId)) && (isset($blogId))){
				$sectionId = $this->config->item('blogsSectionId');
				manageViewCount($viewEntityId,$blogId,$userId,$blogId,$sectionId);
			} 
			
			//manage advert types if exists
			if(is_dir(APPPATH.'modules/advertising')) {
				$sectionId   = $this->config->item('blogsSectionId'); 
				//Get banner records based on section and advert type
				$bannerType1 = $this->model_advertising->getBannerRecords($sectionId,1,1);
				$bannerType2 = $this->model_advertising->getBannerRecords($sectionId,2,1);
				$bannerType3 = $this->model_advertising->getBannerRecords($sectionId,3,1);
				$data['advertSectionId'] = $sectionId; //set advert section id
				//Load view of advert js functions
				$data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$sectionId),true);
			} 
			
			$breadcrumbItem=array('showcase','frontblog');
			$breadcrumbURL=array('showcase/aboutme/'.$userId,'blogshowcase/frontblog/'.$userId);
			$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
			$data['breadcrumbString']=$breadcrumbString;
			//echo '<pre />';  print_r($data);
			$this->template_front_end->load('template_front_end','front_blog',$data);

		}
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
		$data['parentPost'] = @$data['parentPost'][0];
		$data['blogId'] = $blogId ;
		$data['label'] = $this->lang->language ;
		$data['postsTable']=$this->postTable;
		$data['entityId'] = getMasterTableRecord($this->postTable);
		$this->template_front_end->load('template_front_end','child_posts',$data);
	}
	
	/**
	 * Show the Post Form with Parent Post detail
	 * @params: parentPostId (int)
	 * @return: Loads the post form
	 * */
	function postchild($userId=0,$parentPostId=0,$blogId=0)
	{
		if($userId==0 || $userId=='') $userId = $this->userId;		
		if(@$userId=='') $userId = 0;
		
		//if no userId is defined in url or not user is logged-in
		//if($userId==0)
		//	redirectTohome($userId);
	 
		$CurentBlogId = $this->model_blogshowcase->getBlogId($userId);  
		
		//Check if no blog is posted for logged-in user		
		if(count($CurentBlogId)<=0) $blogId = 0;					
		else $blogId = $CurentBlogId[0]->blogId;
					
		$parentPostdata['parentPost'] = $this->model_blogshowcase->getParentPost($parentPostId);
		$parentPostdata['parentPost'] = @$parentPostdata['parentPost'][0];
	//	echo '<pre />';		print_r($parentPostdata);
		$parentPostdata['values'] = $this->model_blogshowcase->postForm($blogId,0);		
		$parentPostdata['values'] = $parentPostdata['values'][0];		
		$blogCategoryId = $this->model_blogshowcase->getBlogCategory($this->userId); 
		
		$parentPostdata['catList'] = array('0'=>'Select Category');		
		while (list($catkey, $catvalue) = each($blogCategoryId)) 
		{
			$parentPostdata['catList'][$catvalue->categoryId] = $catvalue->categoryTitle;
		}
		
		$parentPostdata['label'] = $this->lang->language;	
		$parentPostdata['values']['postId'] = 0; //To get assinged as form element
		$parentPostdata['values']['blogId'] = $blogId; //To get assinged as form element
		//$parentPostdata['values']['custId'] = $userId; //To get assinged as form element
		//Counts the number of image for user gallery,if no image that donot show images
		$field = 'userId';
		$parentPostdata['countGalImg'] = countResult($this->postMediaTable,$field,$this->userId);
		$parentPostdata['promoImagePath'] = $parentPostdata['postPath'] = $this->postPath;
		$this->template->load('template','front_post_form',$parentPostdata);
	}

	/**
		*	All Posts related with parent post
	**/
	function posts($blogId=0,$sortPostBy = 'dateCreated',$postAttr = array(),$userId=0)
	{	
		 
	    $userId = ($userId>0)?$userId:$this->userId;		
		
		$this->data['blogId']=	$blogId;	
		$this->data['userId']=	$userId;		
		$this->data['label'] = $this->lang->language;
		
		if(count($postAttr) <=0 )
		{
			$postAttr['limitPosts'] = 0;
			$postAttr['showFlag'] = 0;
		}
	
		$this->data['countResult']=$this->model_common->countResult($this->postTable,array('blogId'=>$blogId,'custId'=>$userId,'isPublished'=>'t','postArchived'=>'f'));
		//if($this->data['countResult']<=0) redirect(base_url('blogshowcase/frontblog/'.$userId));
		$pages = new Pagination_ajax;
		$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$this->data['perPageRecord'] =$this->config->item('perPageRecordPosts');
		//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
		
		// Add by Amit to set cookie for Results per page
		if($this->input->post('ipp')!=''){
			$isCookie = setPerPageCookie('frontPostsPerPageVal',$this->data['perPageRecord']);	
		}else {
			$isCookie = getPerPageCookie('frontPostsPerPageVal',$this->data['perPageRecord']);		
		}
					
		$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;				
		
		$pages->paginate();
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		
		$this->data['postResults'] =  $this->model_blogshowcase->getPosts($blogId,$sortPostBy,$postAttr['limitPosts'],-1,$userId,$pages->offst,$pages->limit);	
			
		$blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$blogId);
		
		if((count($blogIndustry[0])>0) && $blogIndustry[0]!='')
		{
			if($blogIndustry[0]->blogIndustry!='')
			{
				$industryTitle = getIndustry($blogIndustry[0]->blogIndustry);
				$this->data['industryTitle'] = $industryTitle;
			}
			else
				$this->data['industryTitle'] = '';
		}
		$this->data['postsTable'] = $this->postTable;
		$this->data['currentPostId']=(isset($postAttr['currentPostId']) && $postAttr['currentPostId'] > 0)?$postAttr['currentPostId']:0;	
		
		$this->data['pagingLink'] = base_url(lang().'/blogshowcase/posts/'.$blogId);
		$this->data['entityId'] = getMasterTableRecord($this->postTable);
		
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
		
		$ajaxRequest = $this->input->post('ajaxRequest');			
		
		if($ajaxRequest) { 
			$this->load->view('front_posts',$this->data);	
		}	
		else{
			if($postAttr['showFlag'] == 1) {
				$this->load->view('front_posts',$this->data); 
			}
			
			if($postAttr['showFlag'] == 2)
				$this->load->view('front_recent_posts',$this->data);
		}
		
	}

	/**
		*	All Posts related related with blogArchive
		* 		
		***   Note: "showFlag" if 1: Display load the data on page else not ***
		* 
		* 
	**/
	
	function blogArchive($userId=0,$showFlag,$blogId=0)
	{		
		if(@$userId=='') 
			$userId = 0;	
		
		if($userId==0)
			$userId = $this->userId;
	
		if(@$userId=='') 
			$userId = 0;			
	
		//if no userId is defined in url or not user is logged-in
		//if($userId==0)
		//	redirectTohome($userId);
		
		/*
		$ValBlogId = $this->input->post('val1');
		
		$ValShowFlag = $this->input->post('val2');
		
		if(isset($ValShowFlag)) $showFlag = $ValShowFlag;
		if(isset($ValBlogId)) $blogId = $ValBlogId;		
		* */	
		
		$data['label'] = $this->lang->language ;
		
		$data = $this->model_blogshowcase->fetchArchivesYears($blogId,$userId);	
	    //echo $this->db->last_query();
		
		$data['showFlag'] = $showFlag;
		
		$data['postsTable']=$this->postTable;
		
		$this->load->view('blogArchive',$data);
	}
	
	/**
		*	All Posts related with blogArchive to show twitter,facebook icons on front top right corner
	**/
	
	function blogIcon($blogId=0,$showFlag)
	{	
		if(@$userId==0 || @$userId=='')
			$userId = $this->userId;
			
		if(@$userId=='') 
			$userId = 0;			
		
		//if no userId is defined in url or not user is logged-in
		//if($userId==0)
		//	redirectTohome($userId);
		
		$data['label'] = $this->lang->language ;
		$CurentBlogId = $this->model_blogshowcase->getBlogId($this->userId); 		
		
		//Check if no blog is posted for logged-in user
		
		if(count($CurentBlogId)<=0)
		{
			 $blogId = 0;					
		}
		else
		{			
			$blogId = $CurentBlogId[0]->blogId;
		}
		
		$data = $this->model_common->getDataFromTabel($this->blogTable,'blogToTwitter,blogToFacebook','blogId',$blogId);
		if(is_array($data))
		{
			if(isset($data[0])) $data['icons'] = $data[0];
		}else $data['icons'] = '';
		
		$data['showFlag'] = $showFlag;
		//echo '<pre />';print_r($data);
		//echo $this->db->last_query();
		
		$this->load->view('blogIcon',$data);
	}
	
	/**
		* All Posts related with blogCategories
		* Displays the categories which are elated with posts
		* @param int blogId		
		* Loads the categories 
	**/

	function blogCategories($userId=0,$showFlag,$blogId=0)
	{	
	
		if(@$userId==0 || @$userId=='') $userId = $this->userId;
		
		if(@$userId=='') $userId = 0;			
		//if no userId is defined in url or not user is logged-in
		//if($userId==0)
		//	redirectTohome($userId);
		
		$catData['label'] = $this->lang->language;
		
		$catData['blogId'] = $blogId;
		
		$catData['showFlag'] = $showFlag;
		
		$blogCategoryId = $this->model_blogshowcase->getPostsCategory($userId,$blogId); 
		//echo $this->db->last_query();
		$catData['catList'] = $blogCategoryId;
		
		$catData['postsTable'] = $this->postTable;
		
		$this->load->view('blogCategories',$catData);
	}	
	
	/**
		* Displays the categories which are elated with posts
		* @param int blogId		
		* Loads the categories 
	**/
	
	function postCategories($userId=0,$blogId=0)
	{	
		if(@$userId==0) $userId=$this->userId;
		if(@$userId=='') $userId = 0;			
		
		//if no userId is defined in url or not user is logged-in
		//if(@$userId==0)
		//	redirectTohome($userId);		
		
		$catData['label'] = $this->lang->language;
		
		$catData['blogId'] = $blogId;
		
		$blogCategoryId = $this->model_blogshowcase->getPostsCategory($userId,$blogId); 		
		
		if(count($blogCategoryId)<=0) 
			$catData['catList'] = $blogCategoryId;
		else
		{
			while (list($catkey, $catvalue) = each($blogCategoryId)) {
					$catData['catList'][$catvalue->categoryId]=$catvalue->categoryTitle;
			}
		}
		
		$this->load->view('blogCategories',$catData);
	}
		
	/**
		* Displays the Posts for selected Category
		* 		
		* Loads the template 
	**/	
	function categoryPosts()
	{			
		$sortPostBy = 'dateCreated';
		
		$blogId = decode($this->input->post('val1'));
		
		$catId = decode($this->input->post('val2'));
		
		if(!isset($catId) ||$catId =='') $catId = 0;
		
		$catPostsData  = $this->model_blogshowcase->getCatPosts($catId,$blogId,$sortPostBy);
		
		$catPostsData['blogId'] = $blogId;
		
		//echo '<pre />';print_r($catPostsData);
		
		$catPostsData['label'] = $this->lang->language;
		
		$catPostsData['postsTable'] = $this->postTable;
		
		$this->load->view('front_posts',$catPostsData);	
		
	}
	
	/**
		* Displays Post Form to insert/update the blog content
	**/	
	function postForm($postId=0)
	{
		$data['label'] = $this->lang->language; 
		
		$errorFlag = 0;
		
		$postId = $this->input->post('postId')>0?$this->input->post('postId'):$postId;//Checks if postId is set or not	
		
		$CurentBlogId = $this->model_blogshowcase->getBlogId($this->userId);  
		
		
		//Check if no blog is posted for logged-in user
		if(count($CurentBlogId)<=0)
		{
			 $blogId = 0;
			 $errorFlag = 1;			
		}
		else
		{			
			$blogId = $CurentBlogId[0]->blogId;
		}		
		
		$data['values'] = $this->model_blogshowcase->postForm($blogId,$postId);
		
		$data['values'] = $data['values'][0];	//To get assigned in form elements
		
		$blogCategoryId = $this->model_blogshowcase->getBlogCategory($blogId); 
			
		$data['catList'] = array('0'=>'Select Category');
		
		while (list($catkey, $catvalue) = each($blogCategoryId)) 
		{
			$data['catList'][$catvalue->categoryId] = $catvalue->categoryTitle;
		}
			
		$config = array(
		   array(
				 'field'   => 'postTitle',
				 'label'   =>  	$data['label']['postTitle'],
				 'rules'   => 'trim|required|xss_clean'
			  ),
		   array(
				 'field'   => 'postTagWords',
				 'label'   => 	$data['label']['postTagWords'],
				 'rules'   => 'trim|required|xss_clean'
			  ),
		   array(
				 'field'   => 'postDesc',
				 'label'   =>  	$data['label']['postDescription'],
				 'rules'   => 'trim|required'
			  )
		   );
		   
		  $this->form_validation->set_rules($config); 
		  
		  $this->form_validation->set_error_delimiters('<label class="validation_error red">', '</label>');
		 
		  if($this->form_validation->run())
		  {  
				if(strcmp($this->input->post('save'),'Save')==0)
				{
					 				
					if($blogId == 0)
					{
						$errorFlag = 1;					
					}
					else
					{							
						//Defining and creating folder to upload post image						

						$cmd = 'chmod -R 777 '.$this->blogPath;
						exec($cmd);

						if (!file_exists($this->blogPath)) {
							if (!mkdir($this->blogPath, 0777, true)) 
							{
								die('Failed to create folders...');
							}
						}
						
						$cmd = 'chmod -R 777 '.$this->blogPath;
						exec($cmd);
						
						$cmdPostPath = 'chmod -R 777 '.$this->postPath;
						exec($cmdPostPath);

						if (!file_exists($this->postPath)) 
						{
							if (!mkdir($this->postPath, 0777, true)) 
							{
								die('Failed to create folders...');
							}
						}
						
						$cmdPostPath = 'chmod -R 777 '.$this->postPath;
						exec($cmdPostPath);												
						
						$postFileId = $this->input->post('postFileId');
						
						$uploadArray = $_FILES;						
						
						//UPLOADING AND INSERTING IN MASTER MEDIA TABLE
						if(isset($uploadArray['userfile']['name']) && $uploadArray['userfile']['name']!='')
						{	
							if(isset($uploadArray['userfile']['name']))
							{
								if($uploadArray['userfile']['name'] == '')
								{
									$message = 'You did not select a file to upload';
									set_global_messages($message, 'error');
									redirect($returnUrl);
								}
								
								if($uploadArray['userfile']['name'] != '')
									$uploadedData = $this->lib_sub_master_media->do_upload($uploadArray,$this->postPath,'',1);
								
								//CHECK FOR ERROR AFTER UPLOAD PROMOTIONAL VIDEO
								if(!isset($uploadedData['error']))
								{
									$fileType = $this->input->post('filetype');
								
									$postImage['filePath'] = $this->postPath;
									$postImage['fileName'] = $uploadedData['upload_data']['file_name'];
									$postImage['fileSize'] = $uploadedData['upload_data']['file_size'];
									$postImage['fileType'] = $fileType;
									$postImage['fileCreateDate'] = date("Y-m-d H:i:s");
									
									if($postFileId != '' && $postFileId != 0)
									{
										//Get the value for Media File table to unlink the related file before update
										$mediaFileData = $this->model_common->getDataFromTabel($this->mediaFile,'filePath,fileName','fileId',$postFileId);

										//Update Media Data
										$this->model_common->editDataFromTabel($this->mediaFile, $postImage,'fileId',$postFileId);

										$unlinkImg = $mediaFileData[0]->filePath.'/'.$mediaFileData[0]->fileName;
										
										$fileDir=trim($mediaFileData[0]->filePath);
										$fileName=trim($mediaFileData[0]->fileName);
										if(is_dir($fileDir) && $fileName !=''){
											$fpLen=strlen($fileDir);
											if($fpLen > 0 && substr($fileDir,-1) != DIRECTORY_SEPARATOR){
												$fileDir=$fileDir.DIRECTORY_SEPARATOR;
											}
											findFileNDelete($fileDir,$fileName);
										}
										
										$postFileId = $postFileId;
									}
									else
									{
										//Insert data into main mediaFile. get the Id of mediaFile....
										$fileId = $this->model_common->addDataIntoTabel('MediaFile', $postImage);
									}

									if(isset($fileId) && $fileId!='')
										$postFileId = $fileId;										
								}
								else
								{
									$message = $uploadedData['error'];
									set_global_messages($message, 'error');
									
									//Go back to orignal page with error
									
									if(isset($_SERVER['HTTP_REFERER']))
									{
										$baclLink=$_SERVER['HTTP_REFERER'];
									}
									else
									{
										$baclLink = '';
									}

									redirect($baclLink);

							 }//End else
								
							} 
						}
						
					}
						
						$parentPostId = $this->input->post('parentPostId');
						
						if(!isset($parentPostId)) $parentPostId = 0;
						
						$postId = $this->savePost($postFileId);
						
						if($parentPostId>0)
						{
							$baclLink = 'blog/frontBlogSummary';									
						}
						else
						{
							$baclLink = 'blog';
						}
						
						set_global_messages($this->lang->line('postSuccessfully'), 'success');
						redirect($baclLink); 
				}
		  }
		  else
		  {		
				if(validation_errors())
				{
					$msg = array('errors' => validation_errors());	
					$data['values']['save'] = '';			
				}			
		  }
			
			
			$data['values']['postId'] = $postId; //To get assinged as form element
			$data['values']['blogId'] = $blogId; //To get assinged as form element
			$data['values']['custId'] = $this->userId; //To get assinged as form element
			$data['mediumWidth'] = $this->gallery_allowed_upload_img_medium_width;
			$data['mediumHeight'] = $this->gallery_allowed_upload_img_medium_height;
			$data['mediumSuffix'] = $this->gallery_allowed_upload_img_medium_suffix;
		
			//Counts the number of image for user gallery,if no image that donot show images
			$field = 'userId';
			$data['countGalImg'] = countResult($this->postMediaTable,$field,$this->userId);
			
			if($errorFlag == 1) {
				if(!isset($blogMessage) && $blogMessage == '')
					$blogMessage = $data['label']['blogError'];
				set_global_messages($blogMessage, 'error');
			}
			
		
			//Load the data in form 
			$this->template->load('template', 'post_form', $data);					 
	}
		

/**
	** Functions related with show button functionality **
*/

/**
	* To view user to get load to show posts 
	* This lists the user how are member of toadsquare 
	* and craved any project of logged in user
**/
function userToShowCraved()
{		

	$isAjaxHit = $this->input->get('ajaxHit');	
	
	$users['userInfo'] = $this->model_blogshowcase->userToShowCraved();
	$users['postId'] = $this->input->get('UrlToShare');
		
	if($isAjaxHit)
		$this->load->view('user_list',$users);
	else
		$this->template->load('template','user_list');
			
}

/**
	* To view user To get load to share posts
**/
function userToShareSave()
{		
	$users['userInfo'] = $this->model_blogshowcase->userToShowCraved();
	$users['postId'] = $this->input->get('postId');
	$this->load->view('user_share_save',$users);			
}

/**
	* To view user To get load to share posts
**/
function shareUser()
{		
	/* check how url hit */
	$save = $this->input->post('save');
	
	$userToSave['postId'] = decode($this->input->post('postId'));
	
	$userToSave['userInfo'] = $this->input->post('userInfo');
		
	if(strcmp('Save',$save) == 0)
	{
		$this->model_blogshowcase->saveShareToUser($userToSave); //Called save function
	}			
}

/**
	*** End of show button functionality ***
**/
function userToShare()
{	
	$isAjaxHit = $this->input->get('ajaxHit');	
	
	$users['postId'] = $this->input->get('postId');
		
	if($isAjaxHit)
		$this->load->view('social_share',$users);
	else
		$this->template->load('template','social_share');			
}

/*
	* Displays the Archives Posts for particular month and year
	* @params int archiveMonth
	* @params int archiveYear
	
	* Loads the template 
*/

function frontArchivesPost($userId=0,$month=0,$year=0)
{	
	//$year=$year==0?date('Y'):$year;
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
	
		
	$blogdetail = $this->model_blogshowcase->getBlogDetail($userId);
	
	$this->data['userId']=$userId;
	$this->data['countResult']=$this->model_blogshowcase->previewArchivesPost($archiveMonth,$archiveYear,$userId,0,0,true);
	
	//if($this->data['countResult']<=0) redirectToNorecord404();
		
	$pages = new Pagination_ajax;
	$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
	$this->data['perPageRecord'] =$this->config->item('perPageRecordPosts');
	//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
	
// Add by Amit to set cookie for Results per page
	if($this->input->post('ipp')!=''){
		$isCookie = setPerPageCookie('frontArchivesPostPerPageVal',$data['perPageRecord']);	
	}else {
		$isCookie = getPerPageCookie('frontArchivesPostPerPageVal',$data['perPageRecord']);		
	}
					
	$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
	
	$pages->paginate();
	$this->data['items_total'] = $pages->items_total;
	$this->data['items_per_page'] = $pages->items_per_page;
	$this->data['pagination_links'] = $pages->display_pages();
		
	$this->data['postResults'] = $this->model_blogshowcase->previewArchivesPost($archiveMonth,$archiveYear,$userId,$pages->offst,$pages->limit);
	$this->data['pagingLink'] = base_url(lang().'/blogshowcase/frontArchivesPost/'.$userId.'/'.$archiveMonth.'/'.$archiveYear);
	//print_r($this->data);
	$this->data['blogId'] = $blogdetail['blogId'];		
	$this->data['blogTwitterLink'] = $blogdetail['blogTwitterLink'];		
	$this->data['blogToTwitter'] = $blogdetail['blogToTwitter'];		
	$this->data['blogToDonate'] = $blogdetail['blogToDonate'];		
	$this->data['label'] = $this->lang->language;		
	$this->data['entityId'] = getMasterTableRecord($this->postTable);
	
	$ajaxRequest = $this->input->post('ajaxRequest');			
			
	if($ajaxRequest) { 
		$this->load->view('front_posts',$this->data);	
	}	
	else{
		$this->template_front_end->load('template_front_end','front_cat_posts',$this->data);
	}

}


	/**
		* Displays the Posts for selected Category
		* 		
		* Loads the template 
		* 
	**/

	function frontcatposts($userId=0,$catId=0,$blogId=0)
	{			
		$sortPostBy = 'dateCreated';
		
		$this->data['userId']=$userId;
		
		$where=($catId > 0)?array('custId'=>$userId,'blogCategoryId'=>$catId,'postArchived'=>'f'):array('custId'=>$userId,'postArchived'=>'f');
		$this->data['countResult']=$this->model_common->countResult($this->postTable,$where);	
		
		if($this->data['countResult']<=0) redirectToNorecord404();		
		
		$pages = new Pagination_ajax;
		$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$this->data['perPageRecord'] =$this->config->item('perPageRecordPosts');
		//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
		
		// Add by Amit to set cookie for Results per page
		if($this->input->post('ipp')!=''){
			$isCookie = setPerPageCookie('frontCatPostsPerPageVal',$this->data['perPageRecord']);	
		}else {
			$isCookie = getPerPageCookie('frontCatPostsPerPageVal',$this->data['perPageRecord']);		
		}
					
		$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;		
		
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
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Get blog section id
			$sectionId = $this->config->item('blogsSectionId');
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($sectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($sectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($sectionId,3,1);
			$this->data['advertSectionId'] = $sectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$sectionId),true);
		}  
		
		$ajaxRequest = $this->input->post('ajaxRequest');			
			
		if($ajaxRequest) { 
			$this->load->view('front_posts',$this->data);	
		}else{
			$breadcrumbItem=array('showcase','frontblog','frontcatposts');
			$breadcrumbURL=array('showcase/aboutme/'.$userId,'blogshowcase/frontblog/'.$userId,'blogshowcase/index/'.$userId);
			$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
			$this->data['breadcrumbString']=$breadcrumbString;	 
			$this->template_front_end->load('template_front_end','front_cat_posts',$this->data);
		}
		
	}

/**
	* Displays the Posts for selected Category
	* 		
	* Loads the template 
**/

	function frontRight($frontRightData=array('userId'=>'0','blogId'=>'0'))
	{			
		if(@$frontRightData['userId']==0 || @$frontRightData['userId']==''){ $userId = 0; } 
		else $userId = @$frontRightData['userId'];
		$frontRightData['label'] = $this->lang->language;			
		$this->load->view('front_blog_right',$frontRightData);
	}

	
	function twitter($screen_name = '')
	{				
		if($screen_name=='') $screen_name = $this->input->post('val1');
		$screen_name = preg_replace('(https://twitter.com/)','', $screen_name);
		
		$this->load->config('twitter');
		$settings = array('oauth_access_token' => $this->config->item('oauth_access_token'),
						  'oauth_access_token_secret' => $this->config->item('oauth_access_token_secret'),
						  'consumer_key' => $this->config->item('consumer_key'),
						  'consumer_secret' => $this->config->item('consumer_secret')
						  );
						  
		
		$this->load->library('twitter',$settings);
		
		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$getfield = '?screen_name='.$screen_name;
		$requestMethod = 'GET';
		
		$feed =  $this->twitter->setGetfield($getfield)
					 ->buildOauth($url, $requestMethod)
					 ->performRequest();
					 
		if($feed){
			$feed =json_decode($feed,1);
		}
		$this->load->view('user_twitters',array('feed_data'=>$feed));
	}

	/**
		* Displays the Posts for selected Category 		
		* Loads the template 
	**/

	function frontPostDetail($userId=0,$postId=0)
	{		
		//if(!isset($userId) || $userId==0|| $userId=='')
		//$userId = $this->userId;		 
		 if(@$userId==0 || @$userId=='')
		  $userId = $this->userId;	
		 if(@$userId=='') $userId = 0;			
		
			
		$moduleMathod = $this->router->fetch_method();
		$preview = ($moduleMathod=='preview')?1:0;
		$checkPublished = ( ($userId==$this->userId) && isset($preview) && $preview ==1)?false:true;
		
		$frontPostDetail  =  $this->model_blogshowcase->getFrontPost($postId,$userId,$checkPublished);	
		
		/*		
		echo '<pre />';print_r($frontPostDetail);die;		
		$blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$blogId);				
		*/
		
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
				
			if($frontPostDetail[0]->rating!='')
			{
				$blogRating = getMasterRating($frontPostDetail[0]->rating);
				$frontPostDetail['blogRating'] = $blogRating;
			}
			else
				$frontPostDetail['blogRating'] = '';
				
			$blogId = $frontPostDetail[0]->blogId;
			$frontPostDetail['postData'] = $frontPostDetail[0];			
		} 
		else {
		 redirectToNorecord404();
		}
		
		$frontPostDetail['label'] = $this->lang->language;		
		$frontPostDetail['postsTable'] = $this->postTable;		
		$frontPostDetail['entityId'] = getMasterTableRecord($this->postTable);
		/*
		$cacheFileBlogPost = $this->dirCachePosts.'post_'.$blogId.'_'.$postId.'_'.$userId.'.php';
			
		if(!is_file($cacheFileBlogPost))
		{			
			if(!is_dir($this->dirCachePosts)){
				@mkdir($this->dirCachePosts, 777, true);
			}
		}
		
		$cmd3 = 'chmod -R 777 '.$this->dirCachePosts;
		exec($cmd3);
		
		$refereshCacheWork = LoginUserDetails('post_'.$blogId.'_'.$postId.'_'.$userId);
		
		if($refereshCacheWork==1)
		{				
			if(is_file($cacheFileBlogPost)){
				@unlink($cacheFileBlogPost);
			}			
			$this->session->unset_userdata('post_'.$blogId.'_'.$postId.'_'.$userId,1);
		}
			
		if(!is_file($cacheFileBlogPost))
		{			
			$datafrontPostDetail=str_replace("'","&apos;",json_encode($frontPostDetail));	//encode data in json format
			$stringData = '<?php $blogpost=\''.$datafrontPostDetail.'\';?>';
			if (!write_file($cacheFileBlogPost, $stringData)){					// write cache file
				echo 'Unable to write the file';
			}
		}

		require_once ($cacheFileBlogPost);
		
		$blogpost_data = json_decode($blogpost, true);	
		* */	
		
		/* Update view counts */
		$viewEntityId = $frontPostDetail['entityId'];
		if((isset($viewEntityId)) && (isset($postId))){
			$sectionId = $this->config->item('blogsSectionId');
			manageViewCount($viewEntityId,$postId,$userId,$postId,$sectionId);
		} 
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Get blog section id
			$sectionId   = $this->config->item('blogsSectionId');
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($sectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($sectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($sectionId,3,1);
			$frontPostDetail['advertSectionId'] = $sectionId; //set advert section id
			//Load view of advert js functions
			$frontPostDetail['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$sectionId),true);
		}  
				
		$breadcrumbItem=array('showcase','frontblog','frontPostDetail');
		$breadcrumbURL=array('showcase/aboutme/'.$userId,'blogshowcase/frontblog/'.$userId,'blogshowcase/frontPostDetail/'.$userId.'/'.$postId);
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$frontPostDetail['breadcrumbString']=$breadcrumbString;
		
		$this->template_front_end->load('template_front_end','front_post_detail',$frontPostDetail);		
	}

}//End Class
?>
