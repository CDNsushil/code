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
	
	private $dirCache = '';
	private $data = '';
	private $blogPath = '';
	private $galleryPath = '';
	private $postPath = '';
	private $userId = NULL;
	private $allowed_image_size = '';
	private $blogTable = 'Blogs';
	private $postTable = 'Posts';
	private $mediaFile = 'MediaFile';
	private $postMediaTable = 'PostGallery';
	private $blog_allowed_upload_image_size_unit = '';
	private $blog_allowed_image_type = '';
	private $galleryImageFileId = array('postGalleryId',
			'galPath',
			'userId',
			'mediaDescription',
			'galAltText',
			'galTitle',
			'fileId');
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
			'language' 	=> 'post + blog + common',
			'helper' 	=> 'form + file + archive'			
	  );
		
	parent::__construct($load);
	
	$this->dirCache = 'cache/blog/'; 	
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
	
	$this->blogPath = "media/".LoginUserDetails('username')."/blog/" ;
	$this->galleryPath = "media/".LoginUserDetails('username')."/blog/gallery/" ;
	$this->postPath = "media/".LoginUserDetails('username')."/blog/post/" ;
	
	$this->head->add_css($this->config->item('system_css').'upload_file.css');
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
	//$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.full.js');
	//$this->head->add_js("http://bp.yahooapis.com/2.4.21/browserplus-min.js");
	//$this->config->set_item('global_xss_filtering',FALSE);
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
	function index($isArchive='f')
	{
	  $userId = $this->userId;
	  
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'blog', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'post', $userNavigations, $key='section', $is_object=0 ))){ 
			
		}else{
			redirect('dashboard/blog');
		}
		
	  if($isArchive !== 't'){$isArchive='f' ;}
	  
	  $data['isArchive'] = $isArchive;
	  
	  $data['label'] = $this->lang->language ;
	  $data['postSortBy'] = $this->input->post('sortPost');
	  $data['query'] = $this->model_blog->getUserBlog($userId); 
	  $data['entityId'] = getMasterTableRecord($this->blogTable);
	  $data['userId'] = $userId;
	   
	  if(count($data['query']) == 0) 
	  {
		  $blogMessage = $data['label']['blogError'];
		  set_global_messages($blogMessage, 'error');
		  redirect('blog/blogForm/0');
	  }
	  else
	  {
		  $blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$data['query'][0]->blogId);
		
			if((count($blogIndustry[0])>0) && $blogIndustry[0]!='')
			{
				if($blogIndustry[0]->blogIndustry!='')
				{
					$industryTitle = getIndustry($blogIndustry[0]->blogIndustry);
					$data['industryTitle'] = $industryTitle;
				}
				else $data['industryTitle'] = '';
			}  
			
	
		  $data['totalPosts'] = $data['countResult']=$this->model_common->countResult($this->postTable,array('blogId'=>$data['query'][0]->blogId,'postArchived'=>'f'));	
		  $val1 = $this->input->post('val1'); 
		  
		  if(isset($val1) && $val1!='') {
			$this->load->view('front_blog',$data);
		  } else {
			//$this->template->load('template','blog',$data);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/blog'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_blog_index';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','blog',$data);
		}
	}
	}
	

	/*
		* Displays Blog form to insert/update the blog content
		* @access	public
		* @param	blogId
	*/ 
	function blogForm($blogId=0)
	{
		$dataBlog['userId']=$userId = $this->userId;
		$dataBlog['dirUploadMedia']=$this->blogPath;		
				
		$dataBlog['sectionId']=$sectionId=$this->input->post('sectionId');
		$dataBlog['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		
		//Redirect if user is trying to access post of another user
		if(isset($blogId) && $blogId >0 && isset($this->userId)){
			$userDataWhere = array('blogId'=>$blogId,'custId'=>$this->userId);
			checkUsersProjects('Blogs',$userDataWhere);
		}	
		
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'blog', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'post', $userNavigations, $key='section', $is_object=0 ))){ 
			
		}else{
			$this->lib_package->setUserContainerId($sectionId);
		}
		$this->head->add_js($this->config->item('system_js').'jquery_add_more.js');	
		$this->head->add_js($this->config->item('system_js').'add_more_js.js');
		$error=0;
		
		$userFolderName = LoginUserDetails('username');
		$dataBlog['promoImagePath'] = $blogImageFileIdPath = 'media/'.LoginUserDetails('username').'/blog/';
		$cmd = 'chmod -R 777 '.MEDIAUPLOADPATH.LoginUserDetails('username');
		exec($cmd);
		
		$cmd2 = 'chmod -R 777 '.$blogImageFileIdPath;
		
		exec($cmd2);
			
			if(!is_dir($blogImageFileIdPath))
			{
				mkdir($blogImageFileIdPath, 777, true);
			}

		$cmdblogFolderPath = 'chmod -R 0777 '.$blogImageFileIdPath;
		exec($cmdblogFolderPath);
			
		$Upload_File_Name = '';
		$data = $this->model_blog->getUserBlog($userId); 
	
		if(isset($data[0])){
			$dataBlog['values'] = $data[0];
		}else{
			$dataBlog['values'] = false;
		}
		
		$resultlangs = $this->model_blog->loadLanguage();		
		$dataBlog['workLang'] =  getlanguageList();		
		//$resultIndustries = loadIndustry();
		$resultIndustries = getBlogIndustryList();
		
		
		//Select Industries
		//$dataBlog['workIndustryList'][''] =  $this->lang->language['selectIndustry'];
		$dataBlog['workIndustryList'][''] =  $this->lang->language['blogSelectThemes'];
				
		foreach ($resultIndustries as $resultIndustry) $dataBlog['workIndustryList'][$resultIndustry->IndustryId] = $resultIndustry->IndustryName;
		
		$ratingList = getRatingList();		
		$dataBlog['ratingList'] = $ratingList;
		$dataBlog['label'] = $this->lang->language; 
		$dataBlog['allowed_image_size'] = $this->allowed_image_size;
		$dataBlog['image_size_unit'] = $this->blog_allowed_upload_image_size_unit;
		
		//$this->template->load('template','blog_form',$dataBlog);
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/blog'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_about_your_blog';
			$dataBlog['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','blog_form',$dataBlog);	   
	}

	function blogjquerysave()
	{		
		$this->userId= $this->isLoginUser();
		$elements = false; //to check whether to add or update the post data
		$files = false;		
	    $elementId = $this->input->post('val1');	    
	    $fileId = $this->input->post('val3');
	    $data['MediaFile'] = $this->input->post('val4');   
		$primaryKeyForTable = $this->input->post('val5');   
		$htmlValue = $this->input->post('val6',FALSE);
		
		$primaryTable = $this->blogTable;		
		$saveData = $this->input->post('val2');	
		$updateUserContainerFlag=false;
		$sectionId=$this->config->item('blogsSectionId');
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'blog', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'post', $userNavigations, $key='section', $is_object=0 ))){ 
				
		}else{
			$userContainerId=$this->lib_package->getUserContainerId($sectionId);
			$saveData['userContainerId']=$userContainerId;
			$updateUserContainerFlag=true;
		}    
		//
		
	    if(isset($primaryKeyForTable) && strcmp($primaryKeyForTable,'blogId')==0){ 
			$primaryTable = $this->blogTable; $primaryKeyForTable = 'blogId'; 
		}
	    else
	    { 
			$primaryTable = $this->postTable; $primaryKeyForTable = 'postId'; 
			$CurentBlogId = $this->model_blog->getBlogId($this->userId);  
			$saveData['postDesc'] = $htmlValue;
			//Check if no blog is posted for logged-in user		
			if(count($CurentBlogId)<=0)	 $blogId = 0;					
			else $blogId = $CurentBlogId[0]->blogId;	
			$saveData['blogId']= $blogId;		
	    }
	    
		//Set session for first blog save
		$getBlogId = $this->model_blog->getBlogId($this->userId);  
		$countBlogId = count($getBlogId);
		if($countBlogId==0){
			$this->session->set_userdata('isShowBlogPopup',1);
		}
	   
	    if($elementId>0)
		{
			$countResult = $this->model_common->countResult($primaryTable,$primaryKeyForTable,$elementId,1);
			if($countResult > 0){
				$elements=true;
			}
		}
				
		//Saving image data in mediafile
		if(is_array($data['MediaFile']) && count($data['MediaFile'])>0)
		{		
			if(!is_dir($data['MediaFile']['filePath']))
			{
				mkdir($data['MediaFile']['filePath'], 777, true);
			}
			$cmdFolderPath = 'chmod -R 0777 '.$data['MediaFile']['filePath'];
			exec($cmdFolderPath);
 			
			if($fileId > 0 && isset($data['MediaFile']['fileName']) && $data['MediaFile']['fileName']!=''){				
				$result = $this->model_common->getDataFromTabel('MediaFile','fileName,filePath,isExternal,fileType','fileId',$fileId,'','',1);
				if($result > 0){
					if($result[0]->isExternal != 't'){
						$filePath = trim($result[0]->filePath.$result[0]->fileName);
						if(!empty($filePath) && is_file($filePath)){							
							@unlink($filePath);							
						 
						 //If file is image
							 if($result[0]->fileType == 1 || strcmp($result[0]->fileType,'image')==0)
							 {
							 //Deleting the all vesion of file
							 $thumbImgversion_b = addThumbFolder(@$filePath,'_b');
							 if(!empty($thumbImgversion_b) && is_file($thumbImgversion_b)) @unlink($thumbImgversion_b);
							 
							 $thumbImgversion_l = addThumbFolder(@$filePath,'_l');
							 if(!empty($thumbImgversion_l) && is_file($thumbImgversion_l)) @unlink($thumbImgversion_l);
							
							 $thumbImgversion_m = addThumbFolder(@$filePath,'_m'); 
							 if(!empty($thumbImgversion_m) && is_file($thumbImgversion_m)) @unlink($thumbImgversion_m);
							 
							 $thumbImgversion_s = addThumbFolder(@$filePath,'_s');
							 if(!empty($thumbImgversion_s) && is_file($thumbImgversion_s)) @unlink($thumbImgversion_s);
							 
							 $thumbImgversion_xs = addThumbFolder(@$filePath,'_xs');
							 if(!empty($thumbImgversion_xs) && is_file($thumbImgversion_xs)) @unlink($thumbImgversion_xs);
							 
							 $thumbImgversion_xxs = addThumbFolder(@$filePath,'_xxs');
							 if(!empty($thumbImgversion_xxs) && is_file($thumbImgversion_xxs)) @unlink($thumbImgversion_xxs);
							}//End if fileType
						}
					}
					$files=true;
				}
				
			}
			
			if($files){
				if(isset($data['MediaFile']['fileName']) && $data['MediaFile']['fileName']!=''){
					$this->model_common->editDataFromTabel('MediaFile', $data['MediaFile'], 'fileId', $fileId);
				}
			}else{
				$fileId=$this->model_common->addDataIntoTabel('MediaFile', $data['MediaFile']);
				if($primaryTable==$this->postTable){
					$saveData['postFileId']=($fileId > 0)?$fileId:0;
				}else{
					$saveData['fileId']=($fileId > 0)?$fileId:0;
				}
			}
		}
		
		
		//if countResult is greater then 1 we have update the evnt else add the existing
		if($elements){
			$data['append'] = false;
			
			$this->model_common->editDataFromTabel($primaryTable, $saveData, $primaryKeyForTable, $elementId);
			
			$data['elementId'] = $elementId;		
		}else{
			$data['append'] = true;
			
		
			$data['elementId']= $elementId = $this->model_common->addDataIntoTabel($primaryTable, $saveData);
			addDataIntoLogSummary($primaryTable,$elementId);
		}		
		
		if(($primaryTable==$this->postTable) && ($elementId > 0)){
			$postDetails=$this->model_blog->getPostDetails($elementId);
			if($postDetails && is_array($postDetails) && count($postDetails) > 0){
					$postdata=$postDetails[0];
					
					$enterpriseName=pg_escape_string($postdata['enterpriseName']);
					$enterpriseName=trim($enterpriseName);
					$creative_name=($postdata['enterprise']=='t')?$enterpriseName:pg_escape_string($postdata['firstName'].' '.$postdata['lastName']);
					
					$blogId=$postdata['blogId'];
					$postId=$postdata['postId'];
					$cacheFile = $this->dirCache.'blog_post_'.$postdata['blogId'].'_'.$postdata['postId'].'_'.$postdata['custId'].'.php'; 
					
					$entityId=getMasterTableRecord('Posts');
					$searchDataInsert=array(
						"entityid"=>$entityId,
						"elementid"=>$postdata['postId'],
						"projectid"=>$postdata['blogId'],
						"sectionid"=>$sectionId, 
						"section"=>'blog',
						"ispublished"=>(isset($postdata['isPublished']) && $postdata['isPublished']=='t')?'t':'f',
						"cachefile"=>$cacheFile,
						"item.title"=>pg_escape_string($postdata['postTitle']), 
						"item.tagwords"=>pg_escape_string($postdata['postTagWords']), 
						"item.online_desctiption"=>pg_escape_string($postdata['postOneLineDesc']),
						"item.userid"=>$postdata['custId'], 
						"item.creative_name"=>$creative_name, 
						"item.creative_area"=>pg_escape_string($postdata['optionAreaName']),
						"item.languageid"=>$postdata['blogLanguage']>0?$postdata['blogLanguage']:0,  
						"item.language"=>$postdata['Language_local'],
						"item.countryid"=>$postdata['countryId']>0?$postdata['countryId']:0, 
						"item.country"=>$postdata['countryName'], 
						"item.industryid"=>$postdata['blogIndustry']>0?$postdata['blogIndustry']:0, 
						"item.industry"=>$postdata['IndustryName'], 
						"item.sell_option"=>'free',
						"item.creation_date"=>$postdata['dateCreated'], 
						"item.publish_date"=>$postdata['dateCreated']
						
					);
					$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
					
					if(!is_dir($this->dirCache)){
						@mkdir($this->dirCache, 777, true);
					}
					
					$cmd3 = 'chmod -R 777 '.$this->dirCache;
					exec($cmd3);
					
					$PostDataJson = str_replace("'","&apos;",json_encode($postDetails));	//encode data in json format			
					$stringDataupcoming = '<?php $ProjectData=\''.$PostDataJson.'\';?>';
						
					if (!write_file($cacheFile, $stringDataupcoming)){					// write cache file
						echo 'Unable to write the file';
					}
			}
		}
		elseif(($primaryTable==$this->blogTable) && ($elementId > 0)){
			$blogDetails=$this->model_blog->getBlogDetails($elementId);
			if($blogDetails && is_array($blogDetails) && count($blogDetails) > 0){
					$blogData=$blogDetails[0];
					$blogId=$blogData['blogId'];
					
					$enterpriseName=pg_escape_string($blogData['enterpriseName']);
					$enterpriseName=trim($enterpriseName);
					$creative_name=($blogData['enterprise']=='t')?$enterpriseName:pg_escape_string($blogData['firstName'].' '.$blogData['lastName']);
					
					
					$cacheFile = $this->dirCache.'blog_'.$blogData['blogId'].'_'.$blogData['custId'].'.php'; 
					$entityId=getMasterTableRecord('Blogs');
					if($updateUserContainerFlag){
						$this->lib_package->updateUserContainer($userContainerId,$entityId,$blogId,$sectionId,$sectionId);
					}
					$searchDataInsert=array(
						"entityid"=>$entityId,
						"elementid"=>$blogData['blogId'],
						"projectid"=>$blogData['blogId'],
						"sectionid"=>$sectionId, 
						"section"=>'blog',
						"ispublished"=>$blogData['isPublished'],
						"cachefile"=>$cacheFile,
						"item.title"=>pg_escape_string($blogData['blogTitle']), 
						"item.tagwords"=>pg_escape_string($blogData['blogTagWords']), 
						"item.online_desctiption"=>pg_escape_string($blogData['blogOneLineDesc']),
						"item.userid"=>$blogData['custId'], 
						"item.creative_name"=>$creative_name, 
						"item.creative_area"=>pg_escape_string($blogData['optionAreaName']),
						"item.languageid"=>$blogData['blogLanguage']>0?$blogData['blogLanguage']:0,  
						"item.language"=>$blogData['Language_local'],
						"item.countryid"=>$blogData['countryId']>0?$blogData['countryId']:0, 
						"item.country"=>$blogData['countryName'], 
						"item.industryid"=>$blogData['blogIndustry']>0?$blogData['blogIndustry']:0, 
						"item.industry"=>$blogData['IndustryName'],
						"item.sell_option"=>'free', 
						"item.creation_date"=>$blogData['dateCreated'], 
						"item.publish_date"=>$blogData['dateCreated']
						
					);
					$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
					
					if(!is_dir($this->dirCache)){
						@mkdir($this->dirCache, 777, true);
					}
					
					$cmd3 = 'chmod -R 777 '.$this->dirCache;
					exec($cmd3);
					
					$blogDataJson = str_replace("'","&apos;",json_encode($blogDetails));	//encode data in json format			
					$stringDataupcoming = '<?php $ProjectData=\''.$blogDataJson.'\';?>';
						
					if (!write_file($cacheFile, $stringDataupcoming)){					// write cache file
						echo 'Unable to write the file';
					}
			}
		}
		
		//echo 'elementId:=>'.$elementId;die;
		$currentEntityId = $elementId;
		$passArray = array('id'=>$currentEntityId);
		$returnJsonArray = json_encode($passArray);
		//echo '<pre />';print_r($returnJsonArray);
		echo $returnJsonArray;
	}
	
	/**
		* All Child Posts related functions
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
		//$this->template->load('template','childPosts',$data);
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/blog'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_blog';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','childPosts',$data);	
	}
	
	/*
	 * Show the Post Form with Parent Post detail
	 * @params: parentPostId (int)
	 * @return: Loads the post form
	 */
	function postchild($userId=0,$parentPostId=0,$blogId=0)
	{			
		
		if($userId==0 || $userId=='') $userId = $this->userId;
		$CurentBlogId = $this->model_blog->getBlogId($userId);  
		
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
		//$parentPostdata['values']['custId'] = $userId; //To get assinged as form element
		
		$this->template_front_end->load('template_front_end','front_post_form',$parentPostdata);
	}

	/**
		* All Posts related with parent post
	**/
	function posts($blogId=0,$sortPostBy ='dateCreated',$postAttr = array(),$isArchive='f')
	{	
		if($isArchive !== 't'){$isArchive='f';}
		
		
		$userId=$this->userId;
		$this->data['blogId']=	$blogId;	
		$this->data['userId']=	$this->userId;
		$this->data['isArchive']=$isArchive;
		
		
		$this->data['label'] = $this->lang->language; 
		
		if(!is_array($postAttr) || count($postAttr) <=0 )
		{
			$postAttr['limitPosts'] = 0;
			$postAttr['showFlag'] = 0;
		}
		
		$this->data['countResult']=$this->model_common->countResult($this->postTable,array('blogId'=>$blogId,'postArchived'=>$isArchive));	
			
		$pages = new Pagination_ajax;
		$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$this->data['perPageRecord'] =$this->config->item('perPageRecordPosts');
		//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
		
		// Add by Amit to set cookie for Results per page
		if($this->input->post('ipp')!=''){
			$isCookie = setPerPageCookie('PostPerPageVal',$this->data['perPageRecord']);	
		}else {
			$isCookie = getPerPageCookie('PostPerPageVal',$this->data['perPageRecord']);		
		}
					
		$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;		
		
		$pages->paginate();
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		
		$this->data['postResults'] = $this->model_blog->getPosts($blogId,$sortPostBy,$postAttr['limitPosts'],-1,$userId,$isArchive,$pages->offst,$pages->limit);			
		
		$blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$blogId);
		
		if((count($blogIndustry[0])>0) && $blogIndustry[0]!='')
		{
			if($blogIndustry[0]->blogIndustry!='')
			{
				$this->data['blogIndustry'] = $blogIndustry[0]->blogIndustry;
				$industryTitle = getIndustry($blogIndustry[0]->blogIndustry);
				$this->data['industryTitle'] = $industryTitle;
			}
			else{
				$this->data['blogIndustry'] = 0;
				$this->data['industryTitle'] = '';
			}
		}	
		
		$this->data['entityId'] = getMasterTableRecord($this->postTable);
		$this->data['pagingLink'] = base_url(lang().'/blog/posts/'.$blogId.'/dateCreated/0/'.$isArchive);
			
		$ajaxRequest = $this->input->post('ajaxRequest');			
			
		if($ajaxRequest) { 
			$this->load->view('posts',$this->data);	
		}	
		else{
			if($postAttr['showFlag'] == 0) {
				$this->load->view('posts',$this->data);
			}
			if($postAttr['showFlag'] == 1)
				$this->load->view('front_posts',$this->data);
			if($postAttr['showFlag'] == 2)
				$this->load->view('front_recent_posts',$this->data);	
		}
		
	}
	
	/**
	* 
	* Show the only posts treated as archived/deleted
	* 
**/
	function showArchives($blogId=0)
	{
		$this->index($isArchive='t');
	} 

	/**
		*	All Posts related related with blogArchive
		* 		
		***   Note: "showFlag" if 1: Display load the data on page else not ***
		* 
		* 
	**/
	
	function blogArchive($blogId=0,$showFlag,$userId=0,$isArchive='f')
	{	
		if($isArchive !== 't'){$isArchive='f';}	
		if($userId==0) $userId = $this->userId;		
		$data['label'] = $this->lang->language ;		
		$data = $this->model_blog->fetchArchivesYears($blogId,$userId,$isArchive);	
		$data['showFlag'] = $showFlag;		
		$data['postsTable'] = $this->postTable;
		$this->load->view('blogArchive',$data);
	}
	
	
	
	/**
		* All Posts related with blogCategories
		* Displays the categories which are elated with posts
		* @param int blogId		
		* Loads the categories 
	**/
	function blogCategories($blogId=0,$showFlag,$userId=0,$isArchive='f')
	{	
	
		if($isArchive !== 't'){$isArchive='f';}
		if($userId==0) $userId = $this->userId;	
		
		$catData['userId'] = $userId;
		$catData['isArchive'] = $isArchive;
		
		$catData['label'] = $this->lang->language;
		
		$catData['blogId'] = $blogId;
		
		$catData['showFlag'] = $showFlag;
		
		$blogCategoryId = $this->model_blog->getPostsCategory($blogId,$userId,$isArchive); 
		
		$catData['catList'] = $blogCategoryId;
		
		$catData['postsTable']=$this->postTable;
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
	function categoryPosts($blogid=0, $catid=0,$isArchive='f')
	{			
		
		
		$sortPostBy = 'dateCreated';
		
		if($blogid > 0){
			$blogId = $blogid;
			$catId = $catid;
		}else{
			$blogId = decode($this->input->post('val1'));
			$catId = decode($this->input->post('val2'));
			$isArchive = $this->input->post('val3');
		}
		
		if($isArchive !== 't'){$isArchive='f';}	
		
		if(!isset($catId) ||$catId =='')$catId = 0;
		
		$where=($catId > 0)?array('blogId'=>$blogId,'blogCategoryId'=>$catId,'postArchived'=>'f'):array('blogId'=>$blogId,'postArchived'=>$isArchive);
		$this->data['countResult']=$this->model_common->countResult($this->postTable,$where);	
			
		$pages = new Pagination_ajax;
		$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$this->data['perPageRecord'] =$this->config->item('perPageRecordPosts');
		//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
		
		// Add by Amit to set cookie for Results per page
		if($this->input->post('ipp')!=''){
			$isCookie = setPerPageCookie('categoryPostsPerPageVal',$this->data['perPageRecord']);	
		}else {
			$isCookie = getPerPageCookie('categoryPostsPerPageVal',$this->data['perPageRecord']);		
		}
					
		$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;		
		
		$pages->paginate();
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		
		
		$this->data['postResults']  = $this->model_blog->getCatPosts($catId,$blogId,$sortPostBy,$isArchive,$pages->offst,$pages->limit);
		
		$this->data['pagingLink'] = base_url(lang().'/blog/categoryPosts/'.$blogId.'/'.$catId.'/'.$isArchive);
		
		$this->data['blogId'] = $blogId;
		
		//echo '<pre />';print_r($this->data);
		
		$this->data['label'] = $this->lang->language;
		
		$this->data['postsTable']=$this->postTable;
		
		
		//echo '<pre />';print_r($this->data);die;
		$this->data['entityId'] = getMasterTableRecord($this->postTable);
		
		$userId = $this->userId;
		
		$this->data['userId'] = $userId;
		
		$blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$blogId);
		
		if((count($blogIndustry[0])>0) && $blogIndustry[0]!='')
		{
			if($blogIndustry[0]->blogIndustry!='')
			{
				$this->data['blogIndustry'] = $blogIndustry[0]->blogIndustry;
			}
			else{
				$this->data['blogIndustry'] = 0;
			}
		}	
		
		
		$this->load->view('posts',$this->data);	
		
	}
	
	/*
		* Displays the Archives Posts for particular month and year
		* @params int archiveMonth
		* @params int archiveYear
		
		* Loads the template 
	*/
	function previewArchive($month='',$year='',$blogid=0,$isArchive='f')
	{	
			
		$userId = $this->userId;
		if($blogid > 0){
			$archiveMonth =$month;
			$archiveYear =$year;
			$blogId=$blogid;
		}else{
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
			$isArchive = $this->input->post('val4');
		}
		
		if($isArchive !== 't'){$isArchive='f';}	
		
		$this->data['countResult']=$this->model_blog->previewArchivesPost($archiveMonth,$archiveYear,$blogId,$isArchive,0,0,true);
			
		$pages = new Pagination_ajax;
		$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$this->data['perPageRecord'] =$this->config->item('perPageRecordPosts');
		//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
		
		// Add by Amit to set cookie for Results per page
		if($this->input->post('ipp')!=''){
			$isCookie = setPerPageCookie('ArchivePerPageVal',$this->data['perPageRecord']);	
		}else {
			$isCookie = getPerPageCookie('ArchivePerPageVal',$this->data['perPageRecord']);		
		}
					
		$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
		
		
		$pages->paginate();
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
			
				
		$this->data['postResults'] = $this->model_blog->previewArchivesPost($archiveMonth,$archiveYear,$blogId,$isArchive,$pages->offst,$pages->limit);
		
		$this->data['pagingLink'] = base_url(lang().'/blog/previewArchive/'.$archiveMonth.'/'.$archiveYear.'/'.$blogId.'/'.$isArchive);
				
		$this->data['label'] = $this->lang->language;				
		$this->data['postsTable']=$this->postTable;
		$this->data['entityId'] = getMasterTableRecord($this->postTable);
		
		$this->data['userId'] = $userId;
		
		$blogIndustry = $this->model_common->getDataFromTabel('Blogs','blogIndustry','blogId',$blogId);
		
		if((count($blogIndustry[0])>0) && $blogIndustry[0]!='')
		{
			if($blogIndustry[0]->blogIndustry!='')
			{
				$this->data['blogIndustry'] = $blogIndustry[0]->blogIndustry;
			}
			else{
				$this->data['blogIndustry'] = 0;
			}
		}	
		
		$this->load->view('posts',$this->data);
	
	}
	
	/**
		* Displays Post Form to insert/update the blog content
	**/	
	function postForm($postId=0)
	{
		
		$errorFlag = 0;
		$postId = $this->input->post('postId')>0?$this->input->post('postId'):$postId;//Checks if postId is set or not	
		
		$CurentBlogId= $this->model_blog->getBlogId($this->userId);  
		
		
		//Check if no blog is posted for logged-in user
		if(count($CurentBlogId)<=0){
			 redirect('blog/index');	
		}
		else
		{			
			$blogId = $CurentBlogId[0]->blogId;
		}
		
		$data['label']=$this->lang->language; 
		$data['postId']=$postId; 
		$data['dirUploadMedia']=$this->blogPath;
		
		
		$data['values'] = $this->model_blog->postForm($blogId,$postId);
		
		//Redirect if user is trying to access post of another user
		if(isset($postId) && $postId >0 && isset($this->userId)){
			$userDataWhere = array('postId'=>$postId,'custId'=>$this->userId);
			checkUsersProjects('Posts',$userDataWhere);
		}	
		
		$data['values'] = isset($data['values'][0])?$data['values'][0]:false;	//To get assigned in form elements
		
		$blogCategoryId = $this->model_blog->getBlogCategory($blogId); 
		
		
		$data['catList'] = array('0'=>'Select Category');
		
		/*while (list($catkey, $catvalue) = each($blogCategoryId)) 
		{
			$data['catList'][$catvalue->categoryId] = $catvalue->categoryTitle;
		}*/
		
		foreach ($blogCategoryId as $resultBlogCategory) $data['catList'][$resultBlogCategory->categoryId] = $resultBlogCategory->categoryTitle;
		
		//echo "<pre>";
		//print_r($data['catList']);
		$data['values']['postId'] = $postId; //To get assinged as form element
		$data['values']['blogId'] = $blogId; //To get assinged as form element
		$data['values']['custId'] = $this->userId; //To get assinged as form element
		$data['mediumWidth'] = $this->gallery_allowed_upload_img_medium_width;
		$data['mediumHeight'] = $this->gallery_allowed_upload_img_medium_height;
		$data['mediumSuffix'] = $this->gallery_allowed_upload_img_medium_suffix;
		$data['promoImagePath'] = $data['postPath'] = $this->postPath;
	
		//Counts the number of image for user gallery,if no image that donot show images
		$field = 'userId';
		$data['countGalImg'] = countResult($this->postMediaTable,$field,$this->userId);
	
		if($errorFlag == 1) {
			if(!isset($blogMessage) && $blogMessage=='')
				$blogMessage = $data['label']['blogError'];
			set_global_messages($blogMessage, 'error');
		}
		//Load the data in form 
		//$this->template->load('template', 'post_form', $data);	
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/blog'),
							'isDashButton'=>true,
							'helpSection'=>'post'
				  );
			$leftView='dashboard/help_post';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','post_form',$data);
				 
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
		//$this->template->load('template', 'post_form', $dataPost);
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/blog'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_blog';
			$dataPost['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','post_form',$dataPost);
	}

/**
	* 
	* Calls the model functions to archive/unarhive the posts
	* 
**/	
	function archivePost($postId=0,$blogId=0)
	{
		$data = $this->model_blog->archivePost($postId,$blogId);
		$entityId=getMasterTableRecord('Blogs');
		if($postId > 0 && $entityId > 0){
			$whereField=array('entityid'=>$entityId,'elementid'=>$postId);
			$res=$this->model_common->getDataFromTabel('search', 'id',  $whereField, '', '', '', $limit=1 );
			if($res){
				$id=$res[0]->id;
				if($id > 0){
					$this->model_common->deleteRow('search',$where=array('id'=>$id));
				}
			}
		}
		
		redirect('blog');
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
		
		if($isAjaxHit){
			$this->load->view('post_preview',$data);
		}else{
			//$this->template->load('template','post_preview',$data);
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/blog'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_blog';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','post_preview',$data);
			
		}	
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
		
		if($isAjaxHit){
			$this->load->view('show_media_gallery');
		}else{
			//$this->template->load('template','show_media_gallery',$mediaGallery);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/blog'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_blog';
			$mediaGallery['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','show_media_gallery',$mediaGallery);
			
		}
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
						$extraSmallThumb['filename'] = $orignalImgName;

						//Check if the deifned width and heght of image is greater than orignal image than assing the extraSmallThumb(width and height) to orignal(width and height) 
						if($extraSmallThumb['width'] > $orgImagWidth)  $extraSmallThumb['width'] = $orgImagWidth;
						if($extraSmallThumb['height'] > $orgImagHeight)  $extraSmallThumb['height'] = $orgImagHeight;

						$this->createMultiThumb($orgThumb);	
						$this->createMultiThumb($bigThumb);
						$this->createMultiThumb($mediumThumb);
						$this->createMultiThumb($smallThumb);
						$this->createMultiThumb($extraSmallThumb);
						
						$postGalleryId = $this->model_blog->insertSingleMediaGallery($orignalImgName,$uploadCount,$this->userId);
						redirect('blog/mediaGallery');						
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
		//$this->template->load('template','blog/multiple_gallery_image'); 	
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/blog'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_blog';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','blog/multiple_gallery_image',$data);
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
	else{
		//$this->template->load('template','user_list');
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/blog'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_blog';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','user_list',$data);
	}
			
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
		
	if($isAjaxHit){
		$this->load->view('social_share',$users);
	}else{
		//$this->template->load('template','social_share');
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/blog'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_blog';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','social_share',$data);
	}			
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
		/*echo $newCatRecord = '<div class="cell ml20" id="removeID_'.$catId.'" class="cell">								
											<div class="artist_type_frm_label">
												'.$catArray['categoryTitle'].'
											</div>	
											<div class="pro_btns">'.$catDelButton.$catEditButton.'</div>
										<input type="hidden" id="useDelId_'.$catId.'" value="'.$catId.'" />	
							</div>';
		*/
		echo $newCatRecord = '<div>								
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



function frontRight($frontRightData=array('userId'=>0,'blogId'=>0))
{	
	$frontRightData['label'] = $this->lang->language;		
	$this->load->view('front_blog_right',$frontRightData);
}

function galleryimages($blogId=0)
{
	$userId = $this->userId;	
	$gallery['label'] = $this->lang->language;	 
	$gallery['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->postMediaTable,$this->galleryImageFileId,'userId',$userId,0,'mediaId');
	//echo '<pre />';print_r($gallery['eventPromoImages']['listValues']);
	//echo 'Gallery Image:'.$this->db->last_query();
	$gallery['eventPromoImages']['nomain'] = 1;	
	$gallery['count'] = count($gallery['eventPromoImages']['listValues']);
				
	$CurentBlogId = $this->model_blog->getBlogId($this->userId);
	if(count($CurentBlogId)<=0)	 
		redirect('blog/index');
	else 
		$blogId = $CurentBlogId[0]->blogId;
			
	$gallery['promoElementTable'] = $this->postMediaTable;
	$gallery['promoElementFieldId'] = 'mediaId';	
	$gallery['blogId'] = $blogId;
	$gallery['entityId'] = $gallery['promoImageId'] = $userId;
	$gallery['userId'] =  $gallery['promoImageId'] = $userId;
	$gallery['promoImagePath'] = $this->galleryPath;
	$gallery['entityId'] =$blogId;		
	$gallery['promoEntityField'] = 'blogId';
	$gallery['browseImgJs'] = '_imgJs';	
	$gallery['entityMediaType'] = $gallery['mediaType'] = 1;	
	$gallery['galleryImages'] = $gallery;
	$gallery['galleryImages']['promoheading'] = $this->lang->line('images');
	$gallery['galleryImages']['addPromoheading'] = $this->lang->line('add').'&nbsp'.$this->lang->line('image');
	$gallery['galleryImages']['eventPromoImages']['defaultImage'] = $this->config->item('defaultBlogImg_s');
	
	$fileMaxSize=$this->config->item('defaultContainerSize');
	
	$gallery['containerDetails'] = $this->model_common->getContainerDetails('Blogs',array('blogId'=>$blogId));
	if(isset($gallery['containerDetails'][0]['containerSize']) && $gallery['containerDetails'][0]['containerSize'] > 0 ){
		$containerSize=$gallery['containerDetails'][0]['containerSize'];
		
		$dirname=$this->blogPath;
		$dirSize=getFolderSize($dirname);
		$remainingBytes =($containerSize - $dirSize);
		if(!$remainingBytes > 0){
			$remainingBytes =0;
		}
		
		$containerSize=bytestoMB($containerSize,'mb');
		$dirSize=bytestoMB($dirSize,'mb');
		$remainingSize=($containerSize-$dirSize);
		if($remainingSize < 0){
				$remainingSize = 0;
		}
		$dirSize = number_format($dirSize,2,'.','');
		$remainingSize = number_format($remainingSize,2,'.','');
		$fileMaxSize=$remainingBytes;
	}
	$gallery['fileMaxSize']= $fileMaxSize;
	$gallery['userId'] = $this->userId;
		
	//$this->template->load('template','galleryImages',$gallery);
	
	$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/blog'),
							'isDashButton'=>true,
							'helpSection'=>'mediaGallery'
				  );
			$leftView='dashboard/help_post';
			$gallery['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','galleryImages',$gallery);
}

function viewtwits($twitUrl='')
	{			
		//echo '<pre />';print_r($_POST);die;
		$twitUrl['twitUrl'] = decode($twitUrl);
		$this->load->view('blogshowcase/user_twitters',$twitUrl);
	}
}//End Class
?>
