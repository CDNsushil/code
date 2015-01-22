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

Class blog extends MX_Controller {
	
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
	
	private $gallery_thumb_version_folder = 'galversion';
	
	private $gallery_allowed_upload_img_orignal_suffix = '_orignal';
	
	private $gallery_allowed_upload_img_big_width = '480';
	private $gallery_allowed_upload_img_big_height = '480';
	private $gallery_allowed_upload_img_big_suffix = '_big';
	
	private $gallery_allowed_upload_img_medium_width = '240';
	private $gallery_allowed_upload_img_medium_height = '240';
	private $gallery_allowed_upload_img_medium_suffix = '_medium';
	
	private $gallery_allowed_upload_img_small_width = '160';
	private $gallery_allowed_upload_img_small_height = '160';
	private $gallery_allowed_upload_img_small_suffix = '_small';
	
	private $gallery_allowed_upload_img_extra_small_width = '100';
	private $gallery_allowed_upload_img_extra_small_height = '100';
	private $gallery_allowed_upload_img_extra_small_suffix = '_xsmall';	
	
	/**
	 * Constructor
	**/
	function __construct(){
	
	  //My own constructor code
	  $load = array(
			'model'		=> 'model_blog',
			'library' 	=> 'form_validation + upload + session + lib_sub_master_media',
			'language' 	=> 'post + blog',
			'helper' 	=> 'form + file + archive'			
	  );
		
	parent::__construct($load); 
	
	$this->load->config('auth/tank_auth');	
	
	$this->userId = $this->isLoginUser();
	
	$this->config->load('image_config');
		
	$this->allowed_image_size = $this->config->item('blog_allowed_upload_image_size');
	$this->blog_allowed_upload_image_size_unit = $this->config->item('blog_allowed_upload_image_size_unit');
	$this->blog_allowed_image_type = $this->config->item('blog_allowed_image_type');
	
	$this->gallery_thumb_version_folder = $this->config->item('gallery_thumb_version_folder');
	$this->gallery_allowed_upload_img_orignal_suffix = $this->config->item('gallery_allowed_upload_img_orignal_suffix');
	
	$this->gallery_allowed_upload_img_big_width = $this->config->item('gallery_allowed_upload_img_big_width');
	$this->gallery_allowed_upload_img_big_height = $this->config->item('gallery_allowed_upload_img_big_height');
	$this->gallery_allowed_upload_img_big_suffix = $this->config->item('gallery_allowed_upload_img_big_suffix');
	
	$this->gallery_allowed_upload_img_medium_width = $this->config->item('gallery_allowed_upload_img_medium_width');
	$this->gallery_allowed_upload_img_medium_height = $this->config->item('gallery_allowed_upload_img_medium_height');
	$this->gallery_allowed_upload_img_medium_suffix = $this->config->item('gallery_allowed_upload_img_medium_suffix');
	
	$this->gallery_allowed_upload_img_small_width = $this->config->item('gallery_allowed_upload_img_small_width');
	$this->gallery_allowed_upload_img_small_height = $this->config->item('gallery_allowed_upload_img_small_height');
	$this->gallery_allowed_upload_img_small_suffix = $this->config->item('gallery_allowed_upload_img_small_suffix');

	
	$this->gallery_allowed_upload_img_extra_small_width = $this->config->item('gallery_allowed_upload_img_extra_small_width');
	$this->gallery_allowed_upload_img_extra_small_height = $this->config->item('gallery_allowed_upload_img_extra_small_height');
	$this->gallery_allowed_upload_img_extra_small_suffix = $this->config->item('gallery_allowed_upload_img_extra_small_suffix');
	
	$this->blogPath = "media/".LoginUserDetails('username')."/project/blog/" ;
	$this->postPath = "media/".LoginUserDetails('username')."/project/blog/post" ;
	
	}
	/**
		* Loads common menu on pages
	**/
	function menuNavigation($blogId=0)
	{
		$menuData['blogId'] = $blogId;
		$this->load->view('menu_navigation',$menuData);
	}
	
	/**
	 * Index fucntion by default call when model get initialised
	 *
	 * by default call fetchs the blog data 
	 *
	 * @access	public
	 * @param	null
	 * @return	array
	**/
	function index()
	{
	  $userId = $this->userId;	 
	  $data['label'] = $this->lang->language ;
	  $data['postSortBy'] = $this->input->post('sortPost');
	  $data['query'] = $this->model_blog->getUserBlog($userId); 
	   
	  if(count($data['query']) == 0) 
	  {
		  $blogMessage = $data['label']['blogError'];
		  set_global_messages($blogMessage, 'error');
		  redirect('blog/blogForm/0');
	  }
	  else
	  {
		  $data['totalPostsQuery']  = $this->model_blog->getPosts($data['query'][0]->blogId);
		  $blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$data['query'][0]->blogId);
		
			if((count($blogIndustry[0])>0) && $blogIndustry[0]!='')
			{
				if($blogIndustry[0]->blogIndustry!='')
				{
					$industryTitle = getIndustry($blogIndustry[0]->blogIndustry);
					$data['industryTitle'] = $industryTitle;
				}
				else
				$data['industryTitle'] = '';
			}  
			
		  $data['totalPosts']= $data['totalPostsQuery']['postQuery']->num_rows;
		  
		  $val1 = $this->input->post('val1'); 
		  
		  if(isset($val1) && $val1!='') 
			$this->load->view('front_blog',$data);
		  else
			$this->template->load('template','blog',$data);
	  }
	}
	
	/**
	 * Index fucntion by default call when model get initialised
	 *
	 * by default call fetchs the blog data 
	 *
	 * @access	public
	 * @param	null
	 * @return	array
	**/
	
	function frontBlog($blogId=0)
	{
	  $userId = $this->userId;	 
	  $data['label'] = $this->lang->language ;
	  $data['postSortBy'] = $this->input->post('sortPost');
	  $data['query'] = $this->model_blog->getUserBlog($userId);  
	  if(count($data['query']) == 0) 
	  {
		  $blogMessage = $data['label']['blogError'];
		  set_global_messages($blogMessage, 'error');
		  redirect('blog/blogForm/0');
	  }
	  else
	  {		 
		  if($blogId>0)
		  {
				$data['totalPostsQuery']  = $this->model_blog->getPosts($blogId);
				$blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$blogId);
		  }
		  else
		  {
				$data['totalPostsQuery']  = $this->model_blog->getPosts($data['query'][0]->blogId);
				$blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$data['query'][0]->blogId);
		  }
		  
		  if((count($blogIndustry[0])>0) && $blogIndustry[0]!='')
		  {
				if($blogIndustry[0]->blogIndustry!='')
				{
					$industryTitle = getIndustry($blogIndustry[0]->blogIndustry);
					$data['industryTitle'] = $industryTitle;
				}
				else
					$data['industryTitle'] = '';
		  } 
		  else 
			$data['industryTitle'] = '';
			
		  $data['totalPosts']= $data['totalPostsQuery']['postQuery']->num_rows;
		  
		  $data['showRight'] = 1;
		  
		  $this->template->load('template','front_blog',$data);		  
	  }
	}

	function do_upload($blogImageFile='userfile',$imagePath)
	{
		$config['allowed_types'] = $this->blog_allowed_image_type;
		$config['max_size']    = $this->allowed_image_size;//The maximum size (in kilobytes) that the file can be.Usually 2 MB (or 2048 KB) 
		$this->upload->initialize($config);
		$this->upload->set_allowed_types($this->blog_allowed_image_type);
		$this->upload->set_upload_path($imagePath);

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($blogImageFile))
		{
			$data = array('error' => $this->upload->display_errors());
			//print_r($error);
			//$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$data['error'] = '';
			$data = $data['upload_data']['file_name'];
			return $data;
		}	
		return $data;		
	}

	function do_upload_image($blogImageFile='userfile',$imagePath)
	{
		
			$config['allowed_types'] = $this->blog_allowed_image_type;
			$config['max_size']    = $this->allowed_image_size;//The maximum size (in kilobytes) that the file can be.Usually 2 MB (or 2048 KB) 
			$this->upload->initialize($config);
			$this->upload->set_allowed_types('gif|jpg|jpeg|png');
			$this->upload->set_upload_path($imagePath);
			$this->load->library('upload', $config);
		
		   	if ( ! $this->upload->do_upload($blogImageFile))
			{
				$data = array('error' => $this->upload->display_errors());				
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				return $data;				
			}	
			return $data;		
	}

	/*
		* Displays Blog form to insert/update the blog content
		* @access	public
		* @param	blogId
	*/ 
	function blogForm($blogId=0)
	{
		$this->head->add_js($this->config->item('system_js').'jquery_add_more.js');	
		$this->head->add_js($this->config->item('system_js').'add_more_js.js');

		$userId = $this->userId;
		
		$error=0;
		
		$userFolderName = LoginUserDetails('username');
		
		$projectFolderPath = 'media/'.LoginUserDetails('username').'/project';
		
		$blogImageFileIdPath = 'media/'.LoginUserDetails('username').'/project/blog';
		
		$cmd = 'chmod -R 777 '.MEDIAUPLOADPATH.LoginUserDetails('username');
		exec($cmd);
		
		$cmdMain = 'chmod -R 0777 '.$projectFolderPath;
		exec($cmdMain);

			if(!is_dir($projectFolderPath))
			{
				mkdir($projectFolderPath, 777, true);
			}
			
		$cmdprojectFolderPath = 'chmod -R 0777 '.$projectFolderPath;
		exec($cmdprojectFolderPath);
			
		//------------------------------------------------------------
		$cmd2 = 'chmod -R 777 '.$blogImageFileIdPath;
		exec($cmd2);
			
			if(!is_dir($blogImageFileIdPath))
			{
				mkdir($blogImageFileIdPath, 777, true);
			}

		$cmdblogFolderPath = 'chmod -R 0777 '.$blogImageFileIdPath;
		exec($cmdblogFolderPath);
			
		//Check If File is there to get uploaded		
		$Upload_File_Name = '';
		$data = $this->model_blog->getUserBlog($userId); 
		$blogCount = $this->db->count_all_results();	

		if(count($data)<=0)
		{
			$dataBlog['values']->blogId = 0; 
			$dataBlog['values']->blogTitle = $this->input->post('blogTitle');
			$dataBlog['values']->blogOneLineDesc = $this->input->post('blogOneLineDesc');
			$dataBlog['values']->blogTagWords = $this->input->post('blogTagWords');
			$dataBlog['values']->blogDesc = $this->input->post('blogDesc');
			$dataBlog['values']->blogImgPath = $this->input->post('blogImgPath');
			$dataBlog['values']->blogIndustry = $this->input->post('blogIndustry');
			$dataBlog['values']->blogLanguage = $this->input->post('blogLanguage');
			$dataBlog['values']->blogToDonate = $this->input->post('blogToDonate');
			$dataBlog['values']->blogToTwitter = $this->input->post('blogToTwitter');
			$dataBlog['values']->blogToFacebook = $this->input->post('blogToFacebook');
			$dataBlog['values']->blogToShareOn = $this->input->post('blogToShareOn');
			$dataBlog['values']->blogToTwitFeed = $this->input->post('blogToTwitFeed');
			$dataBlog['values']->blogFor = $this->input->post('blogFor');
			$dataBlog['values']->blogCraveCount = $this->input->post('blogCraveCount');
			$dataBlog['values']->blogPublish = 't';
			$dataBlog['values']->blogShortLink = $this->input->post('blogShortLink');
			$dataBlog['values']->allowComments = $this->input->post('allowComments');
			$dataBlog['values']->dateCreated = date("Y-m-d H:i:s");
			$dataBlog['values']->dateModified= date("Y-m-d H:i:s");

		$blogToDonate = $this->input->post('blogToDonate');
		
		if(strcmp($blogToDonate ,'accept')==0) {
			$dataBlog['values']->blogToDonate = 't';			
		 }
		 else {
			$dataBlog['values']->blogToDonate = 'f';
		 }
		 
		 $blogToShareOn = $this->input->post('blogToShareOn');
		 
		if(strcmp($blogToShareOn ,'accept')==0) {
			 $dataBlog['values']->blogToShareOn = 't';			
		 }
		 else {
			 $dataBlog['values']->blogToShareOn = 'f';			 
		 }

		$blogToTwitter = $this->input->post('blogToTwitter');
		
		if(strcmp($blogToTwitter ,'accept')==0) {
			 $dataBlog['values']->blogToTwitter = 't';			
		 }
		 else {
			$dataBlog['values']->blogToTwitter = 'f';				 
		 }

		$blogToFacebook = $this->input->post('blogToFacebook');
		
		if(strcmp($blogToFacebook ,'accept')==0) {
			$dataBlog['values']->blogToFacebook = 't';	
			
		 }
		 else {
				$dataBlog['values']->blogToFacebook = 'f';
			 
		 }
		
		//This should be assinged on the basis of logged in userId
		$dataBlog['values']->custId = $this->userId;
		
		}

		if(count($data) > 0){

			$blogResult = $this->model_blog->getUserBlog($userId);
			$dataBlog['values'] = $blogResult[0];
			
		}
			 $dataBlog['constant'] = $this->lang->language ;
			 $config = array(
					   array(
							 'field'   => 'blogTitle',
							 'label'   =>  $dataBlog['constant']['blogTitle'],
							 'rules'   => 'trim|required|xss_clean'
					),
					  array(
							 'field'   => 'blogOneLineDesc',
							 'label'   =>  $dataBlog['constant']['blogOneLineDesc'],
							 'rules'   => 'trim|required|xss_clean'
					),
					  array(
							 'field'   => 'blogTagWords',
							 'label'   =>  $dataBlog['constant']['blogTagWords'],
							 'rules'   => 'trim|required|xss_clean'
					 )
			   );

				$this->form_validation->set_rules($config); 
				$this->form_validation->set_error_delimiters('<label class="validation_error red">', '</label>');
				
				if($this->input->post('submit') == 'Save')
				{
					if($this->form_validation->run())
					{							
						$uploadArray = $_FILES;
							
							if(isset($uploadArray['userfile']['name']) && $uploadArray['userfile']['name'] != '')
							{
																
								if($uploadArray['userfile']['name'] != '')
									$uploadedData = $this->lib_sub_master_media->do_upload($uploadArray,$blogImageFileIdPath,'',1);
								
								//CHECK FOR ERROR AFTER UPLOAD PROMOTIONAL VIDEO
								if(!isset($uploadedData['error']))
								{
									$fileType = 1;
								
									$blogImage['filePath'] = $blogImageFileIdPath;
									$blogImage['fileName'] = $uploadedData['upload_data']['file_name'];
									$blogImage['fileSize'] = $uploadedData['upload_data']['file_size'];
									$blogImage['fileType'] = $fileType;
									$blogImage['fileCreateDate'] = date("Y-m-d H:i:s");
									
									if($dataBlog['values']->fileId != '' && $dataBlog['values']->fileId > 0)
									{
										//Get the value for Media File table to unlink the related file before update
										$mediaFileData = $this->model_common->getDataFromTabel($this->mediaFile,'filePath,fileName','fileId',$dataBlog['values']->fileId );

										//Update Media Data
										$this->model_common->editDataFromTabel($this->mediaFile, $blogImage,'fileId',$dataBlog['values']->fileId);

										$unlinkImg = $mediaFileData[0]->filePath.'/'.$mediaFileData[0]->fileName;
										
										if(file_exists($unlinkImg))
										{
											unlink($unlinkImg);
										}
									}
									else
									{
										//Insert data into main mediaFile. get the Id of mediaFile....
										$fileId = $this->model_common->addDataIntoTabel('MediaFile', $blogImage);
									}

									if(isset($fileId) && $fileId!='')
										$dataBlog['values']->fileId  = $fileId;									
								}
								else
								{
									
										$message = $uploadedData['error'];
									
									set_global_messages($message, 'error');
									
									//Go back to orignal page with error
									
									if(isset($_SERVER['HTTP_REFERER']))
									{
										$baclLink = $_SERVER['HTTP_REFERER'];
									}
									else
									{
										$baclLink = 'blog';
									}

									redirect($baclLink);
								}
								
						} 							
					  $dataBlog['values'] = $this->model_blog->saveBlog($dataBlog['values']->fileId); 
					   
					  $catArray = array();
					  $dataBlog['values'] = $this->model_blog->saveBlogCategory($catArray,$this->userId);					  

					  redirect('blog');
					}				
				else
				{
					if(validation_errors())
					{
						$msg = array('errors' => validation_errors());	
						$data['values']['save'] = '';			
					}
				}
			}//End If Save

	 	//To load the languages form Language table

		$resultlangs = $this->model_blog->loadLanguage();
		
		$dataBlog['workLang'] =  getlanguageList();
		
		$resultIndustries = loadIndustry();
		
		//Select Industries
		$dataBlog['workIndustryList'][''] =  $this->lang->language['selectIndustry'];
				
		foreach ($resultIndustries as $resultIndustry)
		{
			$dataBlog['workIndustryList'][$resultIndustry->IndustryId] = $resultIndustry->IndustryName;
		}

		$dataBlog['label']=$this->lang->language; 
		$dataBlog['allowed_image_size'] = $this->allowed_image_size;
		$dataBlog['image_size_unit'] = $this->blog_allowed_upload_image_size_unit;

	 $this->template->load('template','blog_form',$dataBlog);  
	}

	/**
		*	All Child Posts related functions
	**/
	function childPosts($parentPostId=0)
	{	
		$CurentBlogId = $this->model_blog->getBlogId($this->userId);  
		
		//Check if no blog is posted for logged-in user
		
		if(count($CurentBlogId)<=0)
		{
			 $blogId = 0;					
		}
		else
		{			
			$blogId = $CurentBlogId[0]->blogId;
		}
		
		$data  = $this->model_blog->getChildPosts($parentPostId);
		$data['parentPost'] = $this->model_blog->getParentPost($parentPostId);
		$data['blogId'] = $blogId ;
		$data['label'] = $this->lang->language ;
		$data['postsTable']=$this->postTable;
		$this->template->load('template','childPosts',$data);
	}
	
	/**
	 * Show the Post Form with Parent Post detail
	 * @params: parentPostId (int)
	 * @return: Loads the post form
	 * */
	function postchild($parentPostId=0)
	{			
		
		$CurentBlogId = $this->model_blog->getBlogId($this->userId);  
		
		//Check if no blog is posted for logged-in user
		
		if(count($CurentBlogId)<=0)
		{
			 $blogId = 0;					
		}
		else
		{			
			$blogId = $CurentBlogId[0]->blogId;
		}
					
		$parentPostdata['parentPost'] = $this->model_blog->getParentPost($parentPostId);
		
		$parentPostdata['values'] = $this->model_blog->postForm($blogId,0);
		
		$parentPostdata['values'] = $parentPostdata['values'][0];
		
		$blogCategoryId = $this->model_blog->getBlogCategory($blogId); 
			
		$parentPostdata['catList'] = array('0'=>'Select Category');
		
		while (list($catkey, $catvalue) = each($blogCategoryId)) 
		{
			$parentPostdata['catList'][$catvalue->categoryId] = $catvalue->categoryTitle;
		}
		
		$parentPostdata['label'] = $this->lang->language;
	
		$parentPostdata['values']['postId'] = 0; //To get assinged as form element
		$parentPostdata['values']['blogId'] = $blogId; //To get assinged as form element
		$parentPostdata['values']['custId'] = $this->userId; //To get assinged as form element
		
		$this->template->load('template','post_form',$parentPostdata);
	}

	/**
		*	All Posts related with parent post
	**/
	function posts($blogId=0,$sortPostBy = 'dateCreated',$postAttr = array())
	{		
		$data['label'] = $this->lang->language;
		
		if(count($postAttr) <=0 )
		{
			$postAttr['limitPosts'] = 0;
			$postAttr['showFlag'] = 0;
		}
		
		if(isset($val1) && $val1 ==27)
			$data  =  $this->model_blog->getPosts($blogId,$sortPostBy,$postAttr['limitPosts']);	
		else
			$data  =  $this->model_blog->getPosts($blogId,$sortPostBy,$postAttr['limitPosts'],-1);		
		
		$data['postsTable']=$this->postTable;
		
		if($postAttr['showFlag'] == 0)
			$this->load->view('posts',$data);
		if($postAttr['showFlag'] == 1)
			$this->load->view('front_posts',$data);
		if($postAttr['showFlag'] == 2)
			$this->load->view('front_recent_posts',$data);
		
	}

	/**
		*	All Posts related related with blogArchive
		* 		
		***   Note: "showFlag" if 1: Display load the data on page else not ***
		* 
		* 
	**/
	
	function blogArchive($blogId=0,$showFlag)
	{		
		/*
		$ValBlogId = $this->input->post('val1');
		
		$ValShowFlag = $this->input->post('val2');
		
		if(isset($ValShowFlag)) $showFlag = $ValShowFlag;
		if(isset($ValBlogId)) $blogId = $ValBlogId;		
		* */	
		
		$data['label'] = $this->lang->language ;
		
		$data = $this->model_blog->fetchArchivesYears($blogId);	
		
		$data['showFlag'] = $showFlag;
		
		$data['postsTable']=$this->postTable;
		
		$this->load->view('blogArchive',$data);
	}
	
	/**
		*	All Posts related with blogArchive to show twitter,facebook icons on front top right corner
	**/
	
	function blogIcon($blogId=0,$showFlag)
	{	
	
		$data['label'] = $this->lang->language ;
		$CurentBlogId = $this->model_blog->getBlogId($this->userId);  
		
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

	function blogCategories($blogId=0,$showFlag)
	{	
	
		$catData['label'] = $this->lang->language;
		
		$catData['blogId'] = $blogId;
		
		$catData['showFlag'] = $showFlag;
		
		$blogCategoryId = $this->model_blog->getPostsCategory($blogId); 
		
		$catData['catList'] = $blogCategoryId;
		
		//	while (list($catkey, $catvalue) = each($blogCategoryId)) {
		//		echo $catkey;
		//		echo '<pre />';print_r($catvalue);
		//			$catData['catList'][$catvalue->categoryId]=$catvalue->categoryTitle;
		//			$catData['catList']['postCount'] = $catvalue->postcount;
		//}	
		$catData['postsTable']=$this->postTable;
		$this->load->view('blogCategories',$catData);
	}	
	
	/**
		* Displays the categories which are elated with posts
		* @param int blogId		
		* Loads the categories 
	**/
	function postCategories($blogId=0)
	{	
	
		$catData['label'] = $this->lang->language;
		
		$catData['blogId'] = $blogId;
		
		$blogCategoryId = $this->model_blog->getPostsCategory($blogId); 
		
			
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
		
		if(!isset($catId) ||$catId =='')$catId = 0;
		
		$catPostsData  = $this->model_blog->getCatPosts($catId,$blogId,$sortPostBy);
		
		$catPostsData['blogId'] = $blogId;
		
		//echo '<pre />';print_r($catPostsData);
		
		$catPostsData['label'] = $this->lang->language;
		
		$catPostsData['postsTable']=$this->postTable;
		
		$this->load->view('posts',$catPostsData);	
		
	}
	
	/*
		* Displays the Archives Posts for particular month and year
		* @params int archiveMonth
		* @params int archiveYear
		
		* Loads the template 
	*/
	function previewArchive()
	{		
		$val1 = $this->input->post('val1');
		if(isset($val1) && $val1 != '')
			$archiveMonth = decode($this->input->post('val1'));
		else
			$archiveMonth = 0;
		
		$val2 = $this->input->post('val2');
		if(isset($val2) && $val2 != 'undefined')
			$archiveYear = decode($this->input->post('val2'));
		else
		{
			$archiveYear = $archiveMonth;
			$archiveMonth = 0;
				
		}		
		
		$blogId = decode($this->input->post('val3'));
		
		$archivePostDetailResults = $this->model_blog->previewArchivesPost($archiveMonth,$archiveYear,$blogId);
		
		$archivePostDetailResults['label'] = $this->lang->language;		
		
		$archivePostDetailResults['postsTable']=$this->postTable;
		
		$this->load->view('posts',$archivePostDetailResults);
	
	}
	
	/**
		* Displays Post Form to insert/update the blog content
	**/	
	function postForm($postId=0)
	{
		$data['label']=$this->lang->language; 
		
		$errorFlag = 0;
		
		$postId = $this->input->post('postId')>0?$this->input->post('postId'):$postId;//Checks if postId is set or not	
		
		$CurentBlogId= $this->model_blog->getBlogId($this->userId);  
		
		
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
		
		$data['values'] = $this->model_blog->postForm($blogId,$postId);
		
		$data['values'] = $data['values'][0];	//To get assigned in form elements
		
		$blogCategoryId = $this->model_blog->getBlogCategory($blogId); 
			
		$data['catList'] = array('0'=>'Select Category');
		
		while (list($catkey, $catvalue) = each($blogCategoryId)) 
		{
			$data['catList'][$catvalue->categoryId]=$catvalue->categoryTitle;
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
									$message= 'You did not select a file to upload';
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
										
										if(file_exists($unlinkImg))
										{
											unlink($unlinkImg);
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
										$baclLink='';
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
				if(!isset($blogMessage) && $blogMessage=='')
					$blogMessage = $data['label']['blogError'];
				set_global_messages($blogMessage, 'error');
			}
			
		
			//Load the data in form 
			$this->template->load('template', 'post_form', $data);	
				 
	}
	

/**
	*
	* Loads the data in view to get updated
	*
**/		
	function updatePost($blogId=0,$postId=0)
	{		
		$CurentBlogId= $this->model_blog->getBlogId($this->userId);  
		
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
		
		$blogId = $this->input->post('blogId')>0?$this->input->post('blogId'):$blogId;
		$postId = $this->input->post('postId')>0?$this->input->post('postId'):0;
		
		//echo '<pre />';		print_r($this->input->post);die;
		
		if($postId==0) 
			$dataPost = $this->model_blog->savePost($blogId,$postId);
		else	
			$dataPost = $this->model_blog->updatePost($blogId,$postId);
		
		if(count($dataPost)>0)
			$dataPost['values'] = $dataPost[0];
		
		$dataPost['label']=$this->lang->language; //load language variable
		$this->template->load('template', 'post_form', $dataPost);
	}
	
/**
	*
	* Insert/Update a new row into post table from the common function
	*
**/		
	function savePost($postFileId=0)	
	{		
		$this->model_blog->savePost($postFileId);		 		
	}
	
/*
	* Calls the model functions to publish/unpublish the posts
*/
	function publishPost($postId)
	{  
		$data = $this->model_blog->publishPost($postId);
		redirect('blog');  
	}
	
/**
	* 
	* Calls the model functions to archive/unarhive the posts
	* 
**/	
	function archivePost($postId=0,$blogId=0)
	{
		$data = $this->model_blog->archivePost($postId,$blogId);
		redirect('blog');
	}
	
/**
	* 
	* Show the only posts treated as archived/deleted
	* 
**/
	function showArchives($blogId=0)
	{
		
		$CurentBlogId= $this->model_blog->getBlogId($this->userId);  
		
		//Check if no blog is posted for logged-in user
		if(count($CurentBlogId)<=0)
		{
			 $blogId = 0;			 
		}
		else
		{			
			$blogId = $CurentBlogId[0]->blogId;
		}
		$data = $this->model_blog->showArchives($blogId);
		$data['blogId'] = $blogId;
		$data['label'] = $this->lang->language; //load language variable
		$this->template->load('template','archive_post',$data);
	} 

/**
	* 
	* Show the only posts preview
	* 
**/
	function previewPost()
	{	
		$postId = $this->input->get('UrlToShare');
		$data['values'] = $this->model_blog->previewPost(decode($postId));
		$data['values'] = $data['values'][0];	
		$data['label'] = $this->lang->language; //load language variable
		$isAjaxHit = $this->input->get('ajaxHit');
		
		$CurentBlogId= $this->model_blog->getBlogId($this->userId);  
		
		//Check if no blog is posted for logged-in user
		if(count($CurentBlogId)<=0)
		{
			 $blogId = 0;
			 //if(!isset($blogMessage) && $blogMessage=='')
					//$blogMessage = 'Please fill the blog setting first preview post';
				//set_global_messages($blogMessage, 'error');
			 redirect('blog');
		}
		else
		{			
			$blogId = $CurentBlogId[0]->blogId;
		}
		
		$blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$blogId);
		
		if((count($blogIndustry[0])>0) && $blogIndustry[0]!='')
		{
			if($blogIndustry[0]->blogIndustry!='')
			{
				$industryTitle = getIndustry($blogIndustry[0]->blogIndustry);
				$data['industryTitle'] = $industryTitle;
			}
			else
			$data['industryTitle'] = '';
		}
		
		$data['postsTable'] = $this->postTable;
		
		if($isAjaxHit)
			$this->load->view('post_preview',$data);
		else
			$this->template->load('template','post_preview',$data);	
	}
	
/**
	* 
	* Show the only posts preview
	* 
**/
	function previewPostNew()
	{	
		$data['values']->uId = $this->userId;
		$CurentBlogId= $this->model_blog->getBlogId($this->userId);  
		
		//Check if no blog is posted for logged-in user
		if(count($CurentBlogId)<=0)
		{
			 $blogId = 0;
			 redirect('blog');
		}
		else
		{			
			$blogId = $CurentBlogId[0]->blogId;
		}
		
		$blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$blogId);
		
		if((count($blogIndustry[0])>0) && $blogIndustry[0]!='')
		{
			if($blogIndustry[0]->blogIndustry!='')
			{
				$industryTitle = getIndustry($blogIndustry[0]->blogIndustry);
				$data['industryTitle'] = $industryTitle;
			}
			else
			$data['industryTitle'] = '';
		}
		
		//$data['industryTitle'] = $industryTitle;
		
		$data['values']->blogId = $blogId;
		$data['values']->postId = 0;
		$data['values']->dateCreated = date("F d, Y");
		$data['values']->tdsUid = $this->userId;
		$data['values']->firstName = $this->userId;
		$data['values']->lastName = $this->userId;
		$data['values']->postDesc = $this->userId;
		$data['label'] = $this->lang->language; //load language variable
		$data['postsTable'] = $this->postTable;
		$this->load->view('post_preview',$data);
		
	}
	
	
/**
	* Archives Posts related functions
	* @params int $blogId
	
	* Loads the view to show archives post gourping according to year and month in which posts are posted
**/

	function archivesPost($blogId=0)
	{
		//echo 'Blog Id:'.$blogId;
		$data = $this->model_blog->fetchArchivesYears($blogId);
		$this->load->view('archives_post',$data);
	} 
	
	
	
/**
	* Displays Media Gallery Form And Listing Page
**/	
	function mediaGallery()
	{		
		$mediaGallery['label'] = $this->lang->language; //load language variable
		$field = 'userId';
		
		//Counts the number of image for user gallery,if no image that donot show images
		$mediaGallery['countGalImg'] = countResult($this->postMediaTable,$field,$this->userId);
		
		/*check how url hit*/
		$isAjaxHit = $this->input->get('ajaxHit');
		
		if($isAjaxHit)
			$this->load->view('show_media_gallery');
		else
			$this->template->load('template','show_media_gallery',$mediaGallery);
	}

/**
	* Displays Media Gallery Listing Page
**/	
	function mediaGalleryList(){
			
		$mediaGallery['label'] = $this->lang->language; //load language variable
		$mediaGallery['values'] = $this->model_blog->mediaGallery(encode($this->userId));
		$mediaGallery['suffix'] = $this->gallery_allowed_upload_img_extra_small_suffix;
		$mediaGallery['mediumSuffix'] = $this->gallery_allowed_upload_img_medium_suffix;
		$mediaGallery['gallery_thumb_version_folder'] = $this->gallery_thumb_version_folder;
		
		$CurentBlogId = $this->model_blog->getBlogId($this->userId);  		
		
		if(count($CurentBlogId)<=0)	 $blogId = 0;
		else $blogId = $CurentBlogId[0]->blogId;
		
		$mediaGallery['blogId']=$blogId;
		
		$this->load->view('media_gallery_list',$mediaGallery);
		
	}

	/**
		* For multiple upload images
	**/		
	public function uploadfile()
	{
	
		$this->load->library('upload');
		header('Pragma: no-cache');
		header('Cache-Control: private, no-cache');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');
			
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'OPTIONS':
				break;
			case 'HEAD':
			case 'GET':
		
				$this->upload->get();
				break;
			case 'POST':
	
				$this->upload->post('media/'.LoginUserDetails('username').'/project/blog/gallery/');
				
				break;
			case 'DELETE':
				$this->upload->delete();
				break;
			default:
				header('HTTP/1.1 405 Method Not Allowed');
		}
	}


/**
	* Displays Post Media Gallery Form to update the MediaGalleryForm content
**/	
	function postMediaGalleryForm($postGalleryId=0)
	{
		
		$data['label'] = $this->lang->language;
		
		$data['suffix'] = $this->gallery_allowed_upload_img_medium_suffix;
		$data['gallery_thumb_version_folder'] = $this->gallery_thumb_version_folder;
		$CurentBlogId = $this->model_blog->getBlogId($this->userId);  		

		if(count($CurentBlogId)<=0)	 
			$blogId = 0;
		else 
			$blogId = $CurentBlogId[0]->blogId;

		$data['blogId'] = $blogId;
		
		$galleryFolderPath = MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/';//defining the path to upload images
		$galImagePath = $galleryFolderPath;
		// To create the nested structure, the $recursive parameter 
		// to mkdir() must be specified.
		if (!file_exists($galleryFolderPath)) {
			if (!mkdir($galleryFolderPath, 0777, true)) {
				die('Failed to create folders...');
			}
		}

		$Upload_File_Name = '';  //declaring filename to get stored in DB

		//Check If File is there to get uploaded
		// if(count($_FILES)>0) $Upload_File_Name = $this->do_upload($_FILES,$galImagePath);//Function to upload the image for work
		if(count($_FILES)>0) $Upload_File_Name = $_FILES;

		//Checks if workOfferedId is set or not			
		$postGalleryId = $this->input->post('postGalleryId')>0?$this->input->post('postGalleryId'):$postGalleryId;
		//Checks if submit or not
		if($this->input->post('submit') == 'Save')
		{
			if($postGalleryId >0)
			{		
					$postGalleryId = $this->model_blog->updateMediaGallery(); 
					set_global_messages($data['label']['mediaSaved'], 'success'); 
					 
			}
			else
			{	
				if($_FILES['image']['name'] !='')
				{
					$uploadCount = count($_FILES['image']['name']);
					
					
					$Upload_File_Name_Gall = $this->do_upload_image('image',$galImagePath);					
					$orignalImgName = $Upload_File_Name_Gall['upload_data']['file_name'];
					if((isset($Upload_File_Name_Gall['error'])) && ($Upload_File_Name_Gall['error'] !=''))
					{			
						$data['postMediaGallery']['save'] = '';	
						set_global_messages($Upload_File_Name_Gall['error'], 'error');
						redirect('blog/postMediaGalleryForm/0');					
					}
					else
					{						 
					//Getting the orignal width and height of image
					$MediaGalleryAttribute = @getimagesize($galImagePath.$Upload_File_Name_Gall['upload_data']['file_name']); 
					$orgImagWidth = $MediaGalleryAttribute[0];
					$orgImagHeight = $MediaGalleryAttribute[1];

					$orgThumb['suffix'] = $this->gallery_allowed_upload_img_orignal_suffix;
					$orgThumb['width'] = $orgImagWidth;
					$orgThumb['height'] = $orgImagHeight;
					$orgThumb['filename'] = $orignalImgName ;

					$bigThumb['suffix'] = $this->gallery_allowed_upload_img_big_suffix;
					$bigThumb['width'] = $this->gallery_allowed_upload_img_big_width;
					$bigThumb['height'] = $this->gallery_allowed_upload_img_big_height;
					$bigThumb['filename'] = $orignalImgName ;

					//Check if the deifned width and heght of image is greater than orignal image than assing the big(width and height) to orignal(width and height) 
					if($bigThumb['width'] > $orgImagWidth)  $bigThumb['width'] = $orgImagWidth;
					if($bigThumb['height'] > $orgImagHeight)  $bigThumb['height'] = $orgImagHeight;

					$mediumThumb['suffix'] = $this->gallery_allowed_upload_img_medium_suffix;
					$mediumThumb['width'] = $this->gallery_allowed_upload_img_medium_width;
					$mediumThumb['height'] = $this->gallery_allowed_upload_img_medium_height;
					$mediumThumb['filename'] = $orignalImgName ;

					//Check if the deifned width and heght of image is greater than orignal image than assing the mediumThumb(width and height) to orignal(width and height) 
					if($mediumThumb['width'] > $orgImagWidth)  $mediumThumb['width'] = $orgImagWidth;
					if($mediumThumb['height'] > $orgImagHeight)  $mediumThumb['height'] = $orgImagHeight;

					$smallThumb['suffix'] = $this->gallery_allowed_upload_img_small_suffix;
					$smallThumb['width'] = $this->gallery_allowed_upload_img_small_width;
					$smallThumb['height'] = $this->gallery_allowed_upload_img_small_height;
					$smallThumb['filename'] = $orignalImgName ;

					//Check if the deifned width and heght of image is greater than orignal image than assing the smallThumb(width and height) to orignal(width and height) 
					if($smallThumb['width'] > $orgImagWidth)  $smallThumb['width'] = $orgImagWidth;
					if($smallThumb['height'] > $orgImagHeight)  $smallThumb['height'] = $orgImagHeight;

					$extraSmallThumb['suffix'] = $this->gallery_allowed_upload_img_extra_small_suffix;
					$extraSmallThumb['width'] = $this->gallery_allowed_upload_img_extra_small_width;
					$extraSmallThumb['height'] = $this->gallery_allowed_upload_img_extra_small_height;
					$extraSmallThumb['filename'] = $orignalImgName ;

					//Check if the deifned width and heght of image is greater than orignal image than assing the extraSmallThumb(width and height) to orignal(width and height) 
					if($extraSmallThumb['width'] > $orgImagWidth)  $extraSmallThumb['width'] = $orgImagWidth;
					if($extraSmallThumb['height'] > $orgImagHeight)  $extraSmallThumb['height'] = $orgImagHeight;

					$this->createMultiThumb($orgThumb);	
					$this->createMultiThumb($bigThumb);
					$this->createMultiThumb($mediumThumb);
					$this->createMultiThumb($smallThumb);
					$this->createMultiThumb($extraSmallThumb);

					$postGalleryId = $this->model_blog->insertSingleMediaGallery($orignalImgName,$uploadCount,$this->userId);redirect('blog/mediaGallery');
					set_global_messages($data['label']['mediaSaved'], 'success'); 
					}
				}			
			}
			
			redirect('blog/mediaGallery');
			
		}//End if Save

		$data['postMediaGallery'] = $this->model_blog->postMediaGalleryForm($postGalleryId);		
		$data['postMediaGallery'] = $data['postMediaGallery'][0];	//to get assigned in form elements
		$data['postMediaGallery']['postGalleryId'] = $postGalleryId; //to get assinged as form element	
		$data['allowed_image_size'] = $this->allowed_image_size;
		$data['image_size_unit'] = $this->blog_allowed_upload_image_size_unit; 
		$this->load->view('blog/post_media_gallery_form',$data); 	
	}


	function postMultipleMediaGallery()
	{
			
		$galleryFolderPath = MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/';
		$galImagePath = $galleryFolderPath;
		// To create the nested structure, the $recursive parameter 
		// to mkdir() must be specified.
		if (!file_exists($galleryFolderPath)) {
			if (!mkdir($galleryFolderPath, 0777, true)) {
				die('Failed to create folders...');
			}
		}
		if($this->input->post('save') == 'Save')
		{			
			$Upload_File_Name = '';  //declaring filename to get stored in DB
			
			//Check If File is there to get uploaded
			if(count($_FILES)>0) 
			{				
				//Check If File is there to get uploaded
				if(count($_FILES)>0) $Upload_File_Name = $this->do_upload_image('image',$galImagePath);//Function to upload the image for work		
				$orignalImgName = $Upload_File_Name['upload_data']['file_name'];
				
				$uploadCount = count($_FILES['files']['name']);
					
				if((isset($Upload_File_Name['error'])) && ($Upload_File_Name['error'] !=''))
				{			
						
					set_global_messages($Upload_File_Name['error'], 'error');
					redirect('blog/postMediaGalleryForm/0');
				
				}
				else
				{		
					//Getting the orignal width and height of image
					$MediaGalleryAttribute = @getimagesize($galImagePath.$Upload_File_Name['upload_data']['file_name']); 
					$orgImagWidth = $MediaGalleryAttribute[0];
					$orgImagHeight = $MediaGalleryAttribute[1];
					
					$orgThumb['suffix'] = $this->gallery_allowed_upload_img_orignal_suffix;
					$orgThumb['width'] = $orgImagWidth;
					$orgThumb['height'] = $orgImagHeight;
					$orgThumb['filename'] = $orignalImgName ;
	
					$bigThumb['suffix'] = $this->gallery_allowed_upload_img_big_suffix;
					$bigThumb['width'] = $this->gallery_allowed_upload_img_big_width;
					$bigThumb['height'] = $this->gallery_allowed_upload_img_big_height;
					$bigThumb['filename'] = $orignalImgName ;
					
					//Check if the deifned width and heght of image is greater than orignal image than assing the big(width and height) to orignal(width and height) 
					if($bigThumb['width'] > $orgImagWidth)  $bigThumb['width'] = $orgImagWidth;
					if($bigThumb['height'] > $orgImagHeight)  $bigThumb['height'] = $orgImagHeight;
					
					$mediumThumb['suffix'] = $this->gallery_allowed_upload_img_medium_suffix;
					$mediumThumb['width'] = $this->gallery_allowed_upload_img_medium_width;
					$mediumThumb['height'] = $this->gallery_allowed_upload_img_medium_height;
					$mediumThumb['filename'] = $orignalImgName ;
					
					//Check if the deifned width and heght of image is greater than orignal image than assing the mediumThumb(width and height) to orignal(width and height) 
					if($mediumThumb['width'] > $orgImagWidth)  $mediumThumb['width'] = $orgImagWidth;
					if($mediumThumb['height'] > $orgImagHeight)  $mediumThumb['height'] = $orgImagHeight;
					
					$smallThumb['suffix'] = $this->gallery_allowed_upload_img_small_suffix;
					$smallThumb['width'] = $this->gallery_allowed_upload_img_small_width;
					$smallThumb['height'] = $this->gallery_allowed_upload_img_small_height;
					$smallThumb['filename'] = $orignalImgName ;
					
					//Check if the deifned width and heght of image is greater than orignal image than assing the smallThumb(width and height) to orignal(width and height) 
					if($smallThumb['width'] > $orgImagWidth)  $smallThumb['width'] = $orgImagWidth;
					if($smallThumb['height'] > $orgImagHeight)  $smallThumb['height'] = $orgImagHeight;
					
					$extraSmallThumb['suffix'] = $this->gallery_allowed_upload_img_extra_small_suffix;
					$extraSmallThumb['width'] = $this->gallery_allowed_upload_img_extra_small_width;
					$extraSmallThumb['height'] = $this->gallery_allowed_upload_img_extra_small_height;
					$extraSmallThumb['filename'] = $orignalImgName ;
					
					//Check if the deifned width and heght of image is greater than orignal image than assing the extraSmallThumb(width and height) to orignal(width and height) 
					if($extraSmallThumb['width'] > $orgImagWidth)  $extraSmallThumb['width'] = $orgImagWidth;
					if($extraSmallThumb['height'] > $orgImagHeight)  $extraSmallThumb['height'] = $orgImagHeight;
					
					$this->createMultiThumb($orgThumb);	
					$this->createMultiThumb($bigThumb);
					$this->createMultiThumb($mediumThumb);
					$this->createMultiThumb($smallThumb);
					$this->createMultiThumb($extraSmallThumb);
					
					$test = $this->model_blog->insertSingleMediaGallery($orignalImgName,$uploadCount,$this->userId);	
				}
			}
		}
		$this->template->load('template','blog/multiple_gallery_image'); 	
	}
	
	/**
		* TO view Gallery To get load Images in editor
	**/
	function viewGallery()
	{		
		/*check how url hit*/
			$isAjaxHit = $this->input->get('ajaxHit');
			$imageonly['imagesGal'] = $this->model_blog->loadGalleryImages($this->userId);
			$imageonly['suffix'] = $this->gallery_allowed_upload_img_extra_small_suffix;
			$imageonly['gallery_thumb_version_folder'] = $this->gallery_thumb_version_folder;
			if($isAjaxHit)
			{
				$goToGallery['goToGalleryView'] = 0;
				$this->load->view('view_gallery',$imageonly);
			}
			else
			{
				$goToGallery['goToGalleryView'] = 1;
				$this->load->view('view_gallery',$imageonly);
					//$this->template->load('template','view_gallery',$goToGallery);
			}
			
	}

	
/**
	* Display image uploading interface and display uploaded image
**/

function display_upload() 
{

$goToGalleryView=$this->input->get('goToGalleryView');
if (isset($_FILES['image'])) {
$galleryFolderPath = MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/';

$gallery_thumbs_folder = $this->gallery_thumb_version_folder.'/';
$galleryThumbsFolderPath = MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/'.$gallery_thumbs_folder;
$galImagePath = $galleryFolderPath;
		// To create the nested structure, the $recursive parameter 
		// to mkdir() must be specified.
		if (!file_exists($galleryThumbsFolderPath)) {
			if (!mkdir($galleryThumbsFolderPath, 0777, true)) {
				die('Failed to create folders...');
			}
		}

$date = date("Ymdhis");

//$imageNewName = $date.'_'.$_FILES['image']['name'];
$imageNewName = $_FILES['image']['name'];


$upload = $this->do_upload_image('image',$galImagePath);
if((isset($upload['error'])) && ($upload['error'] !=''))
{			
		
	set_global_messages($upload['error'], 'error');
	//redirect('blog/postMediaGalleryForm/0');
	?>

<script type="text/javascript" language="javascript">

alert(eval('<?php echo $upload['error'];?>'));

</script>

<?php

}
else
{	

	$Upload_File_Name = $upload; //File Name after Upload for Gallery
	
	$uploadCount = count($_FILES['image']['name']);
	$orignalImgName = $Upload_File_Name['upload_data']['file_name'];
	//Getting the orignal width and height of image
	$MediaGalleryAttribute = @getimagesize($galImagePath.$Upload_File_Name['upload_data']['file_name']); 
	$orgImagWidth = $MediaGalleryAttribute[0];
	$orgImagHeight = $MediaGalleryAttribute[1];
	
	$orgThumb['suffix'] = $this->gallery_allowed_upload_img_orignal_suffix;
	$orgThumb['width'] = $orgImagWidth;
	$orgThumb['height'] = $orgImagHeight;
	$orgThumb['filename'] = $orignalImgName ;
	
	$bigThumb['suffix'] = $this->gallery_allowed_upload_img_big_suffix;
	$bigThumb['width'] = $this->gallery_allowed_upload_img_big_width;
	$bigThumb['height'] = $this->gallery_allowed_upload_img_big_height;
	$bigThumb['filename'] = $orignalImgName ;
	
	//Check if the deifned width and height of image is greater than orignal image than assing the big(width and height) to orignal(width and height) 
	if($bigThumb['width'] > $orgImagWidth)  $bigThumb['width'] = $orgImagWidth;
	if($bigThumb['height'] > $orgImagHeight)  $bigThumb['height'] = $orgImagHeight;
	
	$mediumThumb['suffix'] = $this->gallery_allowed_upload_img_medium_suffix;
	$mediumThumb['width'] = $this->gallery_allowed_upload_img_medium_width;
	$mediumThumb['height'] = $this->gallery_allowed_upload_img_medium_height;
	$mediumThumb['filename'] = $orignalImgName ;
	
	//Check if the deifned width and height of image is greater than orignal image than assing the mediumThumb(width and height) to orignal(width and height) 
	if($mediumThumb['width'] > $orgImagWidth)  $mediumThumb['width'] = $orgImagWidth;
	if($mediumThumb['height'] > $orgImagHeight)  $mediumThumb['height'] = $orgImagHeight;
	
	$smallThumb['suffix'] = $this->gallery_allowed_upload_img_small_suffix;
	$smallThumb['width'] = $this->gallery_allowed_upload_img_small_width;
	$smallThumb['height'] = $this->gallery_allowed_upload_img_small_height;
	$smallThumb['filename'] = $orignalImgName ;
	
	//Check if the deifned width and height of image is greater than orignal image than assing the smallThumb(width and height) to orignal(width and height) 
	if($smallThumb['width'] > $orgImagWidth)  $smallThumb['width'] = $orgImagWidth;
	if($smallThumb['height'] > $orgImagHeight)  $smallThumb['height'] = $orgImagHeight;
	
	$extraSmallThumb['suffix'] = $this->gallery_allowed_upload_img_extra_small_suffix;
	$extraSmallThumb['width'] = $this->gallery_allowed_upload_img_extra_small_width;
	$extraSmallThumb['height'] = $this->gallery_allowed_upload_img_extra_small_height;
	$extraSmallThumb['filename'] = $orignalImgName ;
	
	//Check if the deifned width and height of image is greater than orignal image than assing the extraSmallThumb(width and height) to orignal(width and height) 
	if($extraSmallThumb['width'] > $orgImagWidth)  $extraSmallThumb['width'] = $orgImagWidth;
	if($extraSmallThumb['height'] > $orgImagHeight)  $extraSmallThumb['height'] = $orgImagHeight;

	$this->createMultiThumb($orgThumb);
	$this->createMultiThumb($bigThumb);
	$medImageName = $this->createMultiThumb($mediumThumb);
	$this->createMultiThumb($smallThumb);
	$this->createMultiThumb($extraSmallThumb);

	$test = $this->model_blog->insertSingleMediaGallery($orignalImgName,$uploadCount,$this->userId);	
	
	if($goToGalleryView == 1) {$this->mediaGallery();}
	$gallery_thumbs_folder = $this->gallery_thumb_version_folder.'/';
$galleryThumbsFolderPath = MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/'.$gallery_thumbs_folder;	
?>
<script type="text/javascript" language="javascript">

window.parent.setUploadedImage('<?php echo $medImageName; ?>',
'<?php echo $this->config->item('base_url').'media/'.LoginUserDetails('username').'/project/blog/gallery/'.$gallery_thumbs_folder.$medImageName;?>',
'<?php echo $mediumThumb['width'];?>',
'<?php echo $mediumThumb['height'];?>');

</script>
<?php

}

}

else {

$err = true;

}

$this->load->view('uploading_interface');
//

}


/**
	* Function to delete the gallery entry for selected images only
**/
function deleteGalleryId(){
	
	$selectedGalleryId =  $this->input->post('galleryIds');
	if(isset($selectedGalleryId)){
	$allIds = implode (',', $selectedGalleryId);
	}
	$this->model_blog->deleteGalleryId($allIds);
	redirect('blog/mediaGallery');
	
}//End deleteGalleryId()


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
	
	$users['userInfo'] = $this->model_blog->userToShowCraved();
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
	$users['userInfo'] = $this->model_blog->userToShowCraved();
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
		$this->model_blog->saveShareToUser($userToSave); //Called save function
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

/**
 * //to load add category view in blog form section
 **/
function addCat($blogId=0)
{		
		$cat['blogId'] = $blogId;
		$cat['categoryValues'] = $this->model_blog->getBlogCategory($blogId);
		//echo '<pre />';print_r($cat['categoryValues']);
		$cat['countCat'] = count($cat['categoryValues']);		
		$this->load->view('add_category',$cat);	
		
}

/**
 * 
 * 
 **/
function categoryList($blogId=0)
{
				
		$cat['label'] = $this->lang->language;
		
		$cat['blogId'] = $blogId;
		
		$cat['categoryValues'] = $this->model_blog->getBlogCategory($blogId);
		
		$cat['countCat'] = count($cat['categoryValues']);
		
		$cat['depend'] = $this->model_blog->getCatExistsInPost($blogId);
		
		$icat =0;
		
		$catDependList = '';
		
		while (list($catDependkey, $catDependvalue) = each($cat['depend'])) 
		{
			//$data['catList'][$catkey]['categoryId']=$catvalue->categoryId;
			//echo '<pre />';print_r($catDependvalue);
			
			if($icat ==0)$catDependList = $catDependvalue['blogCategoryId'];
			if($icat>0) $catDependList .= ','.$catDependvalue['blogCategoryId'];
			$icat++;
			
		}
		$cat['existinCatId']  =  explode(",", $catDependList);
		$this->load->view('list_category',$cat);	
}
/**
 * 
 * 
 **/
	function saveAppendCat($blogId=0)
	{
		
		$cat['label'] = $this->lang->language;
		$catArray['blogId'] = $this->input->post('val1');
				
		$catArray['categoryTitle'] = $this->input->post('val2');
		
		$catArray['categoryId'] = $this->input->post('val3');
		
		$catArray['append'] = $this->input->post('val4');
		if(isset($catArray['categoryTitle']) && $catArray['categoryTitle']!='')
		{
		$catId = $this->model_blog->saveBlogCategory($catArray,$this->userId);		
			
		$catEditButton = '<div class="small_btn"><a class="formTip" title="'.$catArray['categoryTitle'].'" onclick="EditCategory(\''.$catArray['categoryTitle'].'\','.$catId.','.$catId.')"><span><div class="cat_smll_edit_icon"></div></span></a></div>';	
		$catDelButton = '<div class="small_btn"><a class="formTip" onclick="removeCategoryRow('.$catId.',\'0\')"><span><div class="cat_smll_plus_icon"></div></span></a></div>';	
		
		//$categoryTitleToEdit = $catArray['categoryTitle'];
		$attr = array("onclick"=>"removeCategoryRow('$catId','0')");
		echo $newCatRecord = '<div class="cell ml20" id="removeID_'.$catId.'" class="cell">								
											<div class="artist_type_frm_label">
												'.$catArray['categoryTitle'].'
											</div>	
											<div class="pro_btns">'.$catDelButton.$catEditButton.'</div>
										<input type="hidden" id="useDelId_'.$catId.'" value="'.$catId.'" />	
							</div>';
							
									
		}
	}

function createMultiThumb($imageStuff)  //file name passed
{  	
	$gallery_thumbs_folder = $this->gallery_thumb_version_folder.'/';
	$galleryThumbsFolderPath = MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/'.$gallery_thumbs_folder;

	if (!file_exists($galleryThumbsFolderPath)) {
		if (!mkdir($galleryThumbsFolderPath, 0777, true)) {
			die('Failed to create folders...');
		}
	}
	// Use strrpos() & substr() to get the file extension
	$ext = substr($imageStuff['filename'], strrpos($imageStuff['filename'], "."));
	// Then stitch it together with the new string and file's basename
	$orgImageName = $imageStuff['filename'];
    // this thumbnail created
    $config['image_library'] = 'gd2';
    $config['source_image']    = MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/'.$orgImageName;
    $config['create_thumb'] = FALSE;   
	$config['maintain_ratio'] = TRUE;
    $config['width']     = $imageStuff['width'];
    $config['height']   = $imageStuff['height'];
	
	// Then stitch it together with the new string and file's basename
	$newImageName = basename($imageStuff['filename'], $ext) . $imageStuff['suffix'] . $ext;

    $config['new_image'] = $galleryThumbsFolderPath.$newImageName;
    $this->load->library('image_lib', $config);
	$this->image_lib->initialize($config);
    if ( ! $this->image_lib->resize()){echo $this->image_lib->display_errors();}

    $this->image_lib->clear();
	return $newImageName;
   
}

function navigationMenu($blogId=0)
{
	$this->load->view('navigation_menu',$blogId);	
}

/**
 * 
 * FOR FRONT PAGES
 * 
**/ 

function frontBlogSummary($blogId=0)
{
  
  $userId = $this->userId;	 
  $frontBlogData['label'] = $this->lang->language ;
 
  $frontBlogData['blogId'] = $this->model_blog->getBlogId($userId);
	if(count($frontBlogData['blogId'])<=0)
	{
		 $blogId = 0;
		
	}
	else
	{			
		$frontBlogData['blogId'] = $frontBlogData['blogId'][0];
	}
  
  $this->template->load('template','front_blog_summary',$frontBlogData);	
  
}

/*
	* Displays the Archives Posts for particular month and year
	* @params int archiveMonth
	* @params int archiveYear
	
	* Loads the template 
*/

function frontArchivesPost()
{		
	$val1 = $this->input->post('val1');
	
	if(isset($val1) && $val1 != '')
		$archiveMonth = decode($this->input->post('val1'));
	else
		$archiveMonth = 0;
	
	$val2 = $this->input->post('val2');
	
	if(isset($val2) && $val2 != 'undefined')
		$archiveYear = decode($this->input->post('val2'));
	else
	{
		$archiveYear = $archiveMonth;
		$archiveMonth = 0;
			
	}		

	$blogId = decode($this->input->post('val3'));
	
	$archivePostDetailResults = $this->model_blog->previewArchivesPost($archiveMonth,$archiveYear,$blogId);
	
	$archivePostDetailResults['label'] = $this->lang->language;		

	$this->load->view('front_posts',$archivePostDetailResults);

}


/**
	* Displays the Posts for selected Category
	* 		
	* Loads the template 
	* 
**/

function frontCategoryPosts()
{			
	$sortPostBy = 'dateCreated';
	
	$blogId = decode($this->input->post('val1'));
	
	$catId = decode($this->input->post('val2'));
	
	$catPostsData  = $this->model_blog->getCatPosts($catId,$blogId,$sortPostBy);
	
	$catPostsData['blogId'] = $blogId;
	
	$catPostsData['label'] = $this->lang->language;
	
	$this->load->view('front_posts',$catPostsData);
}

/**
	* Displays the Posts for selected Category
	* 		
	* Loads the template 
**/

function frontRight($blogId=0)
{			
	
	$frontRightData['label'] = $this->lang->language;
	$frontRightData['blogId'] = $blogId;
	
	$this->load->view('front_blog_right',$frontRightData);
}

/**
	* Displays the Posts for selected Category
	* 		
	* Loads the template 
**/

function frontPostDetail($postId=0)
{		
	
$userId = $this->userId;	
	 
	$frontBlogData['blogId'] = $this->model_blog->getBlogId($userId);
	
	$CurrentBlogId = $frontBlogData['blogId'];
	
	//Check if no blog is posted for logged-in user
	if(count($CurrentBlogId)<=0)
	{
			 $blogId = 0;
	}
	else
	{			
			$blogId = $CurrentBlogId[0]->blogId;
	}
	
	$frontPostDetail  =  $this->model_blog->getPosts($blogId,'','',$postId);	
	
	$blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$blogId);
		
		if((count($blogIndustry[0])>0) && $blogIndustry[0]!='')
		{
			if($blogIndustry[0]->blogIndustry!='')
			{
				$industryTitle = getIndustry($blogIndustry[0]->blogIndustry);
				$frontPostDetail['industryTitle'] = $industryTitle;
			}
			else
			$frontPostDetail['industryTitle'] = '';
		}
	
	$frontPostDetail  =  $this->model_blog->getPosts($blogId,'','',$postId);	
	
	$frontPostDetail['postData'] = $frontPostDetail['postResults'][0];
	
	$frontPostDetail['label'] = $this->lang->language;
	
	$frontPostDetail['postsTable'] = $this->postTable;
	
	$this->template->load('template','front_post_detail',$frontPostDetail);
}

}//End Class
?>
