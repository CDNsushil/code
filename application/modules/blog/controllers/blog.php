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
	private $dirUser = '';
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
			'model'		=> 'model_blog + membershipcart/model_membershipcart',
			'library' 	=> 'form_validation + upload + session + lib_sub_master_media + pagination_new_ajax',
			'language' 	=> 'post + blog + common',
			'helper' 	=> 'form + file + archive'			
	  );
		
	parent::__construct($load);
	
	$this->dirCache = 'cache/blog/'; 	
	$this->load->config('auth/tank_auth');		
	$this->userId = $this->isLoginUser();	
	$this->dirUser = 'media/'.LoginUserDetails('username').'/'; 
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
	
	function index()
	{
		$this->editposts();
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
	function oldindex($isArchive='f')
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
		$this->oldindex($isArchive='t');
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
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog cover image
     * @access: public
     * @return void
     */ 
    public function blogcoverimage() {
       
		$userId = $this->isLoginUser();
        
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
       
		//call method for plupload css and js add
        $this->_pluploadjsandcss();
       
		$data = $this->model_blog->getUserBlog($userId);
		//echo "<pre>";
		//print_r($data);die;
		if(isset($data[0])) {
			$this->data['blogData'] = $data[0];
		} else {
			$this->data['blogData'] = '';
		}
		
		// check setup edit session value
		$isEditBlog = $this->session->userdata('isEditBlog');
		$pkgHeading  = $this->lang->line('createYourBlog');
		if(!empty($isEditBlog)) {
			$pkgHeading  = $this->lang->line('editBlogCoverPage');
		}
		
        // set data for blog form
        $this->data['dirUploadMedia']       =  $blogImageFileIdPath;
        $this->data['b1menu']               = 'TabbedPanelsTabSelected';
        $this->data['bCover1menu']          = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'blog/wizardform/blog_cover_menus';
        $this->data['subInnerPage']         = 'blog/wizardform/blog_cover_image';
		$this->data['packagestageheading']  = $pkgHeading;
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
      //------------------------------------------------------------------------
    
    /*
    * @Description: This method is used to added plupload require js and css
    * @access: private
    * @return: void
    * @author: lokendra
    */
    
    private function _pluploadjsandcss(){
        $this->head->add_css($this->config->item('system_css').'upload_file.css');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js'); 
    }
	
	
	//-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to stage "3" of media uploage stage - 1
    * @access: public
    * @return: void
    */
     
    public function uploadblogimage() {
        
        // get post values
        $postData = $this->input->post();
		
        //--------media data prepair for inserting------//
        $browseId         =  $this->input->post('browseId');
        $blogId           =  $this->input->post('blogId');
		$isFile           =  false;
		$media_fileName   =  $this->input->post('fileName'.$browseId);
		$isExternal       =  ($this->input->post('isExternal'.$browseId)=='t')?'t':'f';
		$embbededURL      =  $this->input->post('embbededURL');
		$isProfileCoverImage = $this->input->post('isProfileCoverImage');
		$isExternalFile   =  false;
		$mediaFileData    =  array();
		$blogImagePath    = 'media/'.LoginUserDetails('username').'/blog/';
		$userId = $this->isLoginUser();
		// set default redirect url
        $reditectUrl = base_url(lang().'/blog/blogcoverimage');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedBlog');
        $isStatus = false;
        
		if(!empty($postData)) {
			if($media_fileName && strlen($media_fileName)>3) {
				$isFile              =   true;
				$fileType            =   getFileType($media_fileName);
				$isExternalFile      =   false;
				$mediaFileData       =   array(
										'filePath'      =>  $blogImagePath,
										'fileName'      =>  $media_fileName,
										'fileType'      =>  $fileType,
										'tdsUid'        =>  $this->userId,
										'isExternal'    =>  'f',
										'fileSize'      =>  $this->input->post('fileSize'.$browseId),
										'rawFileName'   =>  $this->input->post('fileInput'.$browseId),
										'jobStsatus'    =>  'UPLOADING'
									);
				
			} elseif($embbededURL && strlen($embbededURL)>3) {
				$isFile             =   true;
				$fileType           =   $this->input->post('fileType'.$browseId);
				$embbededURL        =   getUrl($embbededURL);
				$isExternalFile     =   true;
				$mediaFileData      =   array(
										'filePath'      =>  $embbededURL,
										'tdsUid'        =>  $this->userId,
										'fileType'      =>  $fileType,
										'isExternal'    =>  't',
										'jobStsatus'    =>  'DONE'
									);
			}
			
			if($isFile){
				
				$fileId = $this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);
		
			} else {
				$fileId=0;
			}
			$isProfileCoverImage = (isset($postData['isProfileCoverImage']) && $fileId  == 0)?'t':'f';
			// set blog data for store
			$blogData = array('fileId'=> $fileId,'isProfileCoverImage'=> $isProfileCoverImage);
			
			// get blog ts product id
			$tsProductId     = $this->config->item('tsProductId_BlogShowcase');
			// get blog container id
			$containerRes = $this->model_common->getDataFromTabel('UserContainer', 'userContainerId,elementId',  array('tsProductId'=>$tsProductId,'tdsUid'=>$userId));
			// get user container id
			$userContainerId = (isset($containerRes[0]->userContainerId))?$containerRes[0]->userContainerId:0;
			// get blog element id
			$elementId = (isset($containerRes[0]->elementId))?$containerRes[0]->elementId:0;
				
			if(!empty($blogId) && $blogId > 0) {
				
				$this->model_common->editDataFromTabel('Blogs', $blogData, 'blogId', $blogId);
			} else {
				
				$blogData['userContainerId'] = $userContainerId;
				$blogData['custId'] = $userId;
				$blogData['dateCreated'] = date('Y-m-d h:i:g');
		
				// add blog data
				$blogId = $this->model_common->addDataIntoTabel($this->blogTable, $blogData);
				$entityId = getMasterTableRecord($this->blogTable);
				// update blog element data in container tbl
				if($elementId == 0 && $userContainerId > 0) {
					$this->model_common->editDataFromTabel('UserContainer', array('entityId'=>$entityId,'elementId'=>$blogId,'startDate'=>date('Y-m-d h:i:g')), 'userContainerId', $userContainerId);
				}
			}
			
			$reditectUrl = base_url(lang().'/blog/blogtitlendescription');
			$type = 'success';
			$msg = $this->lang->line('blogCoverSuccess');
			if($isProfileCoverImage == 'f') {
				$isStatus = true;
			}
		}  
        
        $returnData = array('nextUrl'=>$reditectUrl,'isStatus'=>$isStatus);
        echo json_encode($returnData);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog cover title and description
     * @access: public
     * @return void
     */ 
    public function blogtitlendescription() {
		
		$userId = $this->isLoginUser();
       
		$data = $this->model_blog->getUserBlog($userId);
		
		if(isset($data[0])) {
			$this->data['blodData'] = $data[0];
		} else {
			$this->data['blodData'] = '';
		}
		
        // set data for blog form
        $this->data['b1menu']               = 'TabbedPanelsTabSelected';
        $this->data['bCover2menu']          = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'blog/wizardform/blog_cover_menus';
        $this->data['subInnerPage']         = 'blog/wizardform/blog_title_description';
		$this->data['packagestageheading'] = $this->lang->line('createYourBlog');
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    /*
     * @description: This function is used to save blog title n description details
     * @access: public
     * @return void
     */ 
    public function setblogdescdetails() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/blog/blogtitlendescription');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedBlog');
        if(!empty($postData) && !empty($postData['blogId'])) {
            
            // update user's blog data
            $blogData = array(
				'blogTitle'       => $postData['blogTitle'],
				'blogOneLineDesc' => $postData['blogOneLineDesc'],
				'blogDesc'        => $postData['blogDesc'],
				'blogTagWords'    => $postData['blogTagWords']
			);
            $this->model_common->editDataFromTabel($this->blogTable, $blogData, 'blogId', $postData['blogId']);
            // set mext page url
            $reditectUrl = base_url(lang().'/blog/bloginformation');
            $type = 'success';
            $msg = $this->lang->line('blogCoverSuccess');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog cover information
     * @access: public
     * @return void
     */ 
    public function bloginformation() {
		
		$userId = $this->isLoginUser();
		// get blog data
		$data = $this->model_blog->getUserBlog($userId);
		
		if(isset($data[0])) {
			$this->data['blodData'] = $data[0];
		} else {
			$this->data['blodData'] = '';
		}
		$resultIndustries = getBlogIndustryList();		
		//Select Industries
		$this->data['workIndustryList'][''] =  $this->lang->language['selectMainFocus'];
				
		foreach ($resultIndustries as $resultIndustry) $this->data['workIndustryList'][$resultIndustry->IndustryId] = $this->lang->line($resultIndustry->IndustryKey);	
		
        // set data for blog form
        $this->data['b1menu']               = 'TabbedPanelsTabSelected';
        $this->data['bCover3menu']          = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'blog/wizardform/blog_cover_menus';
        $this->data['subInnerPage']         = 'blog/wizardform/blog_information';
        $this->data['packagestageheading'] = $this->lang->line('createYourBlog'); 
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
	
	/*
     * @description: This function is used to save blog information
     * @access: public
     * @return void
     */ 
    public function setblogInformation() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/blog/bloginformation');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedBlog');
        if(!empty($postData) && !empty($postData['blogId'])) {
            
            // update user's blog data
            $blogData = array(
				'blogIndustry' => $postData['blogIndustry'],
				'blogLanguage' => $postData['blogLanguage'],
				'rating'       => $postData['rating']
			);
            $this->model_common->editDataFromTabel($this->blogTable, $blogData, 'blogId', $postData['blogId']);
            // set mext page url
            $reditectUrl = base_url(lang().'/blog/blogsetup');
            $type = 'success';
            $msg = $this->lang->line('blogCoverSuccess');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog cover setup details
     * @access: public
     * @return void
     */ 
    public function blogsetup() {
		
		$userId = $this->isLoginUser();
		// get blog data
		$data = $this->model_blog->getUserBlog($userId);
		
		if(isset($data[0])) {
			$this->data['blogData'] = $data[0];
		} else {
			$this->data['blogData'] = '';
		}
		$resultIndustries = getBlogIndustryList();		
		//Select Industries
		$this->data['workIndustryList'][''] =  $this->lang->language['blogSelectThemes'];
				
		foreach ($resultIndustries as $resultIndustry) $this->data['workIndustryList'][$resultIndustry->IndustryId] = $resultIndustry->IndustryName;
		
		// check setup edit session value
		$isEditBlogSetup = $this->session->userdata('isEditBlog');
		$pkgHeading  = $this->lang->line('createYourBlog');
		if(!empty($isEditBlogSetup)) {
			$pkgHeading  = $this->lang->line('editBlogSetup');
		}
		
        // set data for blog form
        $this->data['addCatLine']           = $this->lang->line('addBlogCatText');
        $this->data['b1menu']               = 'TabbedPanelsTabSelected';
        $this->data['bCover4menu']          = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'blog/wizardform/blog_cover_menus';
        $this->data['subInnerPage']         = 'blog/wizardform/blog_setup';
        $this->data['packagestageheading']  = $pkgHeading; 
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
	}
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to get blog category
     * @access: public
     * @return void
     */ 
	function addblogcategory($blogId=0)
	{		
		$cat['blogId'] = $blogId;
		$cat['categoryValues'] = $this->model_blog->getBlogCategory($blogId);
		//echo '<pre />';print_r($cat['categoryValues']);
		$cat['countCat'] = count($cat['categoryValues']);		
		$this->load->view('wizardform/add_category',$cat);		
	}

	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to get blog category listing
     * @access: public
     * @return void
     */ 
	function categorylisting($blogId=0)
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
		$this->load->view('wizardform/list_category',$cat);	
	}
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save category
     * @access: public
     * @return void
     */ 
	function saveblogappendcat($blogId=0)
	{
		
		$cat['label'] = $this->lang->language;
		$catArray['blogId'] = $this->input->post('val1');
				
		$catArray['categoryTitle'] = $this->input->post('val2');
		
		$catArray['categoryId'] = $this->input->post('val3');
		
		$catArray['append'] = $this->input->post('val4');
		if(isset($catArray['categoryTitle']) && $catArray['categoryTitle']!='')
		{
			$catId = $this->model_blog->saveBlogCategory($catArray,$this->userId);
			$catEditButton = '<a title="'.$catArray['categoryTitle'].'" onclick="EditCategory(\''.$catArray['categoryTitle'].'\','.$catId.','.$catId.')">Edit</a>';	
			
			$catDelButton = '<a onclick="removeCategoryRow('.$catId.',\'0\')">Delete</a>';	
		
			$attr = array("onclick"=>"removeCategoryRow('$catId','0')");
		
			echo $newCatRecord = '<li id="removeID_ '.$catArray['categoryId'].'" class="pb5">	
									<span class="display_block font_bold ml25 bg_f9f9f9 pl18">							
										<b>'.$catArray['categoryTitle'].'</b>	
										<span class="red fs12 fr">
											'.$catEditButton.' / '.$catDelButton.'
											<input type="hidden" id="useDelId_'.$catId.'" value="'.$catId.'" />	
										</span>
									</span>
								</li>';
								
		}
	}
	
	/*
     * @description: This function is used to save blog setup data
     * @access: public
     * @return void
     */ 
    public function setblogsetup() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/blog/blogsetup');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedBlog');
        if(!empty($postData) && !empty($postData['blogId'])) {
            $blogToTwitter = (isset($postData['blogToTwitter']))?'t':'f';
            // update user's blog data
            $blogData = array(
				'blogTwitterLink' => $postData['blogTwitterLink'],
				'blogToDonate'    => $postData['blogToDonate'],
				'blogToTwitter'   => $blogToTwitter
			);
            $this->model_common->editDataFromTabel($this->blogTable, $blogData, 'blogId', $postData['blogId']);
            // set mext page url
            $reditectUrl = base_url(lang().'/blog/blogmediagallery');
            $type = 'success';
            $msg = $this->lang->line('blogCoverSuccess');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog media gallery
     * @access: public
     * @return void
     */ 
    public function blogmediagallery() {
		
		$userId = $this->isLoginUser();
		
		$this->data['blogGalleryList'] = $this->lib_sub_master_media->entitypromotionmedialist($this->postMediaTable,$this->galleryImageFileId,'userId',$userId,0,'mediaId');
		
		$this->data['blogId'] = $this->isblogcreated();
		$fileMaxSize = $this->config->item('defaultContainerSize');
		
		$this->data['containerDetails'] = $this->model_common->getContainerDetails('Blogs',array('blogId'=>$blogId));
		if(isset($this->data['containerDetails'][0]['containerSize']) && $this->data['containerDetails'][0]['containerSize'] > 0 ){
			$containerSize=$this->data['containerDetails'][0]['containerSize'];
			
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
		
		$this->data['fileMaxSize'] = $fileMaxSize;
		$this->data['userId'] = $this->userId;
		
		$blogImageFileIdPath = $this->galleryPath;
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
       
		//call method for plupload css and js add
        $this->_pluploadjsandcss();
		
		// check setup edit session value
		$isEditBlogGallery = $this->session->userdata('isEditBlog');
		$pkgHeading  = $this->lang->line('createYourBlog');
		if(!empty($isEditBlogGallery)) {
			$pkgHeading  = $this->lang->line('editBlogGallery');
		}
		
		
       // set data for blog form
        $this->data['dirUploadMedia']       =  $blogImageFileIdPath;
        $this->data['b2menu']               = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'blog/wizardform/blog_gallery';
        $this->data['packagestageheading']  = $pkgHeading; 
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
	}
	
	//-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to upload blog image in gallery
    * @access: public
    * @return: void
    */
    public function uploadbloggalleryimage() {
        
        // get post values
        $postData = $this->input->post();
		
        //--------media data prepair for inserting------//
        $browseId         =  $this->input->post('browseId');
        $blogId           =  $this->input->post('blogId');
		$isFile           =  false;
		$media_fileName   =  $this->input->post('fileName'.$browseId);
		$isExternal       =  ($this->input->post('isExternal'.$browseId)=='t')?'t':'f';
		$isExternalFile   =  false;
		$mediaFileData    =  array();
		$blogImagePath    = $this->galleryPath;
		$userId = $this->isLoginUser();
		// set default redirect url
        $reditectUrl = base_url(lang().'/blog/blogmediagallery');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedBlog');
        $isStatus = false;
        
		if(!empty($postData)) {
			if($media_fileName && strlen($media_fileName)>3) {
				$isFile              =   true;
				$fileType            =   getFileType($media_fileName);
				$isExternalFile      =   false;
				$mediaFileData       =   array(
										'filePath'      =>  $blogImagePath,
										'fileName'      =>  $media_fileName,
										'fileType'      =>  $fileType,
										'tdsUid'        =>  $this->userId,
										'isExternal'    =>  'f',
										'fileSize'      =>  $this->input->post('fileSize'.$browseId),
										'rawFileName'   =>  $this->input->post('fileInput'.$browseId),
										'jobStsatus'    =>  'UPLOADING'
									);
			}
			
			if($isFile) {
				$fileId = $this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);
			} else {
				$fileId=0;
			}
		
			$blogMediaData = array('mediaTitle'=> $postData['mediaTitle']);
			$mediaId = $postData['mediaId'];
			if(isset($mediaId) && !empty($mediaId)) {
				
				$this->model_common->editDataFromTabel($this->postMediaTable, $blogMediaData, 'mediaId', $mediaId);
			} else {
				// set blog data for store
				$blogMediaData['userId'] = $userId;
				$blogMediaData['fileId'] = $fileId;
				$blogMediaData['blogId'] = $blogId;
				$blogMediaData['isMain'] = 'f';
				$blogMediaData['mediaType'] = 1;
				if($fileId > 0) {
					// add blog media data
					$galleryMediaId = $this->model_common->addDataIntoTabel($this->postMediaTable, $blogMediaData);
				}
			}
			
			$reditectUrl = base_url(lang().'/blog/blogmediagallery');
			$type = 'success';
			$msg = $this->lang->line('blogCoverSuccess');
			$isStatus = true;
		}  
        
        $returnData = array('nextUrl'=>$reditectUrl,'isStatus'=>$isStatus);
        echo json_encode($returnData);
    }
    
    //-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to remove gallery media data
    * @access: public
    * @return: void
    */
    public function deletegallerymedia() {
		
		$mediaId = $this->input->post('mediaId');
		$deleted = 0;
		$countResult = 0 ;
		if($mediaId > 0) {
			$table = $this->postMediaTable;
			$where = array('mediaId'=>$mediaId);
			$this->model_common->deleteRowFromTabel($table, $where);
			$countResult = $this->model_common->countResult($table,$where,'',1);
			$deleted = 1;
		}
		echo  json_encode(array('deleted'=>$deleted, 'countResult'=>$countResult));
	}
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to add post details
     * @access: public
     * @return void
     */ 
    public function addpost($postId=0) {
		
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated(1);
		// get post data if exists
		$postData = $this->getpostdata($postId);
		// get post count
		$postCount   = $this->getpostcount();
		if($postCount > 0) {
			// set session value for app post
			$this->session->set_userdata('isAddPost',1);
		}
        
        //insert one time for managing your toadsquare menu for blog
        $inserData    =   array(
                    'entityid'              =>  getMasterTableRecord('Blogs'),
                    'elementid'             =>  $blogId,
                    'projectid'             =>  $blogId,
                    'section'               =>  $this->config->item('sectionId13'),
                    'sectionid'             =>  $this->config->item('blogsSectionId'),
                    'sectionParent'         =>  $this->config->item('sectionId13'),
                );
        yourToadsqureData($inserData);
        
		
        // set data for blog form
        $this->data['blogId']       = $blogId;
        $this->data['postData']     = $postData;
        $this->data['b3menu']       = 'TabbedPanelsTabSelected';
        $this->data['bPost1menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']    = 'blog/wizardform/blog_post_menus';
        $this->data['subInnerPage'] = 'blog/wizardform/post_description';
        $this->data['packagestageheading'] = $this->getpackageheading();
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
	}
	
	/*
     * @description: This function is used to save post description
     * @access: public
     * @return void
     */ 
    public function setpostdescription() {
        // get post values
        $postData = $this->input->post();
        $userId = $this->isLoginUser();
        // set default redirect url
        $reditectUrl = base_url(lang().'/blog/addpost');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedPost');
		if(!empty($postData) && !empty($postData['blogId']) && !empty($postData['postDesc'])) {
			if(!empty($postData['postId'])) {
				$postId = $postData['postId'];
				// update post data
				$setPostData = array(
					'postDesc' => $postData['postDesc'],
				);
				$this->model_common->editDataFromTabel($this->postTable, $setPostData, 'postId', $postData['postId']);
			} else {
				// add post data
				$setPostData = array(
					'postDesc' => $postData['postDesc'],
					'blogId'   => $postData['blogId'],
					'custId'   => $userId,
					'dateCreated'=>date('Y-m-d h:i:g'),
				);
				$postId = $this->model_common->addDataIntoTabel($this->postTable, $setPostData);
			}
           
            // set mext page url
            $reditectUrl = base_url(lang().'/blog/postdisplayimage/'.$postId);
            $type = 'success';
            $msg = $this->lang->line('blogPostSuccess');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to get post details
     * @access: private
     * @return void
     */ 
     private function getpostdata($postId=0) {
		 $postdata = '';
		 if(!empty($postId) && $postId > 0) {
			//get post data
			$postRes = $this->model_common->getDataFromTabel($this->postTable,'*','postId',$postId);
			if(!empty($postRes)) {
				$postdata = $postRes[0];
			}
		}
		return $postdata;
	 }
	 
	 //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to get post details
     * @access: private
     * @return void
     */ 
     private function isblogcreated($isFirstPost=0) {
		$userId = $this->isLoginUser();
		// get blog data
		$CurentBlogId = $this->model_blog->getBlogId($userId);
		$blogId = 0;
		if(count($CurentBlogId)<=0) {
			if($isFirstPost == 1) {
				// add blog data
				$setBlogData = array(
					'blogTitle' => 'Untitled',
					'custId'   => $userId,
					'dateCreated'=>date('Y-m-d h:i:g'),
				);
				$blogId = $this->model_common->addDataIntoTabel($this->blogTable, $setBlogData);
			} else {
				redirect('blog/blogcoverimage');
			}
		} else {
			$blogId = $CurentBlogId[0]->blogId;
		}
		return $blogId;
	 }
	 
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to get post count
     * @access: private
     * @return void
     */ 
     private function getpostcount() {
		$userId = $this->isLoginUser();
		// get blog data
		$CurentBlogId = $this->model_blog->getBlogId($userId);
		if(count($CurentBlogId)<=0) 
			redirect('blog/blogcoverimage');
		else 
			$blogId = $CurentBlogId[0]->blogId;
		
		//get post data
		$postRes = $this->model_common->getDataFromTabel($this->postTable,'postId','blogId',$blogId);
		// get post count	
		$postCount = (!empty($postRes))?count($postRes):0;
		return $postCount;
	 }
	 
	 //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage display image of post
     * @access: private
     * @return void
     */ 
     public function postdisplayimage($postId=0) {
		 
		$userId = $this->isLoginUser();
		// get post data
        $postData = $this->getpostdata($postId);
        // get blog id
        $blogId = $this->isblogcreated(); 
        
        // get post data
        $postData = $this->model_blog->postForm($blogId,$postId);
		
        if(!empty($postData)) {
			$postData = $postData[0];
		} else {
			redirect('blog/addpost');
		}
        
        //call current stage update for blog complete
        $dataArray = array('entityid'=>getMasterTableRecord('Blogs'),'projectid'=>$blogId);
        currentStage($dataArray);
        
		$userFolderName = LoginUserDetails('username');
		$dataBlog['promoImagePath'] = $blogImageFileIdPath = $this->postPath;
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
       
		//call method for plupload css and js add
        $this->_pluploadjsandcss();
		
        // set data for blog form
        $this->data['dirUploadMedia']  =  $blogImageFileIdPath;
        $this->data['postData']        =  $postData;
        //$this->data['postCount']       =  $this->getpostcount();
        $this->data['b3menu']          = 'TabbedPanelsTabSelected';
        $this->data['bPost2menu']      = 'TabbedPanelsTabSelected';
        $this->data['innerPage']       = 'blog/wizardform/blog_post_menus';
        $this->data['subInnerPage']    = 'blog/wizardform/post_display_image';
        $this->data['packagestageheading'] = $this->getpackageheading();
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
	 }
	 
	 //-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to stage "3" of media uploage stage - 1
    * @access: public
    * @return: void
    */
     
    public function uploadpostimage() {
        
        // get post values
        $postData = $this->input->post();
		
        //--------media data prepair for inserting------//
        $browseId         =  $this->input->post('browseId');
        $postId           =  $this->input->post('postId');
		$isFile           =  false;
		$media_fileName   =  $this->input->post('fileName'.$browseId);
		$isExternal       =  ($this->input->post('isExternal'.$browseId)=='t')?'t':'f';
		$embbededURL      =  $this->input->post('embbededURL');
		$isUserProfileImage = $this->input->post('isUserProfileImage');
		$isExternalFile   =  false;
		$mediaFileData    =  array();
		$postImagePath    = $this->postPath;
		$userId = $this->isLoginUser();
		// set default redirect url
        $reditectUrl = base_url(lang().'/blog/postdisplayimage/'.$postId);
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedPost');
        $isStatus = false;
        
		if(!empty($postData) && !empty($postId)) {
			if($media_fileName && strlen($media_fileName)>3) {
				$isFile              =   true;
				$fileType            =   getFileType($media_fileName);
				$isExternalFile      =   false;
				$mediaFileData       =   array(
										'filePath'      =>  $postImagePath,
										'fileName'      =>  $media_fileName,
										'fileType'      =>  $fileType,
										'tdsUid'        =>  $this->userId,
										'isExternal'    =>  'f',
										'fileSize'      =>  $this->input->post('fileSize'.$browseId),
										'rawFileName'   =>  $this->input->post('fileInput'.$browseId),
										'jobStsatus'    =>  'UPLOADING'
									);
				
			} elseif($embbededURL && strlen($embbededURL)>3) {
				$isFile             =   true;
				$fileType           =   $this->input->post('fileType'.$browseId);
				$embbededURL        =   getUrl($embbededURL);
				$isExternalFile     =   true;
				$mediaFileData      =   array(
										'filePath'      =>  $embbededURL,
										'tdsUid'        =>  $this->userId,
										'fileType'      =>  $fileType,
										'isExternal'    =>  't',
										'jobStsatus'    =>  'DONE'
									);
			}
			
			if($isFile){
				
				$fileId = $this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);
		
			} else {
				$fileId = 0;
			}
			$isUserProfileImage = (isset($postData['isUserProfileImage']) && $fileId == 0)?'t':'f';
			// set post data for store
			$postData = array('postFileId'=> $fileId,'isUserProfileImage'=> $isUserProfileImage);
				
			if(!empty($postId) && $postId > 0) {
				
				$this->model_common->editDataFromTabel($this->postTable, $postData, 'postId', $postId);
			}
			
			$reditectUrl = base_url(lang().'/blog/posttitlendescription/'.$postId);
			$type = 'success';
			$msg = $this->lang->line('blogPostSuccess');
			if($isUserProfileImage == 'f') {
				$isStatus = true;
			}
		}  
        
        $returnData = array('nextUrl'=>$reditectUrl,'isStatus'=>$isStatus);
        echo json_encode($returnData);
    }
	 
	 //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog cover title and description
     * @access: public
     * @return void
     */ 
    public function posttitlendescription($postId=0) {
		
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		// get post data if exists
		$postData = $this->getpostdata($postId);
		if(empty($postData)) {
			redirect('blog/addpost');
		}
        
        //call current stage update for blog complete
        $dataArray = array('entityid'=>getMasterTableRecord('Blogs'),'projectid'=>$blogId);
        currentStage($dataArray);
		
        // set data for blog form
        $this->data['blogId']        =  $blogId;
        $this->data['postData']      =  $postData;
        //$this->data['postCount']     =  $this->getpostcount();
		$this->data['b3menu']        = 'TabbedPanelsTabSelected';
        $this->data['bPost3menu']    = 'TabbedPanelsTabSelected';
        $this->data['innerPage']     = 'blog/wizardform/blog_post_menus';
        $this->data['subInnerPage']  = 'blog/wizardform/post_title_description';
        $this->data['packagestageheading'] = $this->getpackageheading();
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    } 
	 
	 /*
     * @description: This function is used to save post title n description details
     * @access: public
     * @return void
     */ 
    public function setpostdescdetails() {
        // get post values
        $postData = $this->input->post();
        // get post id 
        $postId = (isset($postData['postId']))?$postData['postId']:0;
        // set default redirect url
        $reditectUrl = base_url(lang().'/blog/posttitlendescription/'.$postId);
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedBlog');
        if(!empty($postData) && !empty($postData['postId'])) {
            
            // update user's post data
            $setPostData = array(
				'postTitle'       => $postData['postTitle'],
				'postOneLineDesc' => $postData['postOneLineDesc'],
				'postTagWords'    => $postData['postTagWords'],
			);
            $this->model_common->editDataFromTabel($this->postTable, $setPostData, 'postId', $postData['postId']);
            // set mext page url
            $reditectUrl = base_url(lang().'/blog/addpostcategory/'.$postId);
            $type = 'success';
            $msg = $this->lang->line('blogPostSuccess');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog post categories
     * @access: public
     * @return void
     */ 
    public function addpostcategory($postId=0) {
		
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		$categoryValues = $this->model_blog->getBlogCategory($blogId);
        
        //call current stage update for blog complete
        $dataArray = array('entityid'=>getMasterTableRecord('Blogs'),'projectid'=>$blogId);
        currentStage($dataArray);

        
		// set category list for drop down
		$categorydata[''] = 'Select Category*';
		if($categoryValues){
			foreach ($categoryValues as $category) {
				$categorydata[$category->categoryId] = $category->categoryTitle;
			}
		}
	
		// get post data if exists
		$postData = $this->getpostdata($postId);
		if(empty($postData)) {
			redirect('blog/addpost');
		}
		
        // set data for blog form
        $this->data['blogId']        =  $blogId;
        $this->data['postData']      =  $postData;
		$this->data['categoryList']  =  $categorydata;
		//$this->data['postCount']     =  $this->getpostcount();
		$this->data['addCatLine']    =  $this->lang->line('addPostCatText');
		$this->data['b3menu']        = 'TabbedPanelsTabSelected';
        $this->data['bPost4menu']    = 'TabbedPanelsTabSelected';
        $this->data['innerPage']     = 'blog/wizardform/blog_post_menus';
        $this->data['subInnerPage']  = 'blog/wizardform/post_category';
        $this->data['packagestageheading'] = $this->getpackageheading();
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    } 
    
     /*
     * @description: This function is used to save post blog category 
     * @access: public
     * @return void
     */ 
    public function setpostcategory() {
        // get post values
        $postData = $this->input->post();
        // get post id 
        $postId = (isset($postData['postId']))?$postData['postId']:0;
        // set default redirect url
        $reditectUrl = base_url(lang().'/blog/addpostcategory/'.$postId);
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedBlog');
        if(!empty($postData) && !empty($postData['postId'])) {
            
            // update user's post data
            $setPostData = array(
				'blogCategoryId' => $postData['blogCategoryId'],
			);
            $this->model_common->editDataFromTabel($this->postTable, $setPostData, 'postId', $postData['postId']);
            // set mext page url
            $reditectUrl = base_url(lang().'/blog/publiciseblog');
            // get post session value
			$isAddPost = $this->session->userdata('isAddPost'); 
			if(!empty($isAddPost)) {
				// set mext page url
				$reditectUrl = base_url(lang().'/blog/previewnpublishpost/'.$postId);
			}
            
            $type = 'success';
            $msg = $this->lang->line('blogPostSuccess');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog publish
     * @access: public
     * @return void
     */ 
    public function publiciseblog() {
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
        
        
        //call current stage update for blog complete
        $dataArray = array('entityid'=>getMasterTableRecord('Blogs'),'projectid'=>$blogId);
        currentStage($dataArray);

		
		// check setup edit session value
		$isEditBlogGallery = $this->session->userdata('isEditBlog');
		$pkgHeading  = $this->lang->line('createYourBlog');
		if(!empty($isEditBlogGallery)) {
			$pkgHeading  = $this->lang->line('editBlogPublicise');
		}
		
		// set data for blog form
        $this->data['blogId']        =  $blogId;
		$this->data['b4menu']        = 'TabbedPanelsTabSelected';
        $this->data['innerPage']     = 'blog/wizardform/publicise_blog';
        $this->data['packagestageheading'] = $pkgHeading;
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    } 
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog preview and publish
     * @access: public
     * @return void
     */ 
    public function previewnpublishblog() {
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		// check setup edit session value
		$isEditBlogGallery = $this->session->userdata('isEditBlog');
		$pkgHeading  = $this->lang->line('createYourBlog');
		if(!empty($isEditBlogGallery)) {
			$pkgHeading  = $this->lang->line('editBlogPublicise');
		}
		//get blog publish status
		$blogRes = $this->model_common->getDataFromTabel($this->blogTable,'isPublished','blogId',$blogId);
		if(!empty($blogRes)) {
			$blogData = $blogRes[0];
		}
		// set data for blog form
        $this->data['blogId']        =  $blogId;
        $this->data['blogPublished'] =  (isset($blogData)) ? $blogData->isPublished : 'f';
		$this->data['b4menu']        = 'TabbedPanelsTabSelected';
        $this->data['innerPage']     = 'blog/wizardform/preview_n_publish';
        $this->data['packagestageheading'] = $pkgHeading;
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    } 
    
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to load blog preview page
     * @access: public
     * @return void
     */ 
    public function previewblog() {
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		// set blog preview url
		$blogPreviewUrl = 'blogshowcase/preview/'.$userId.'/'.$blogId.'/frontblog';
		redirect($blogPreviewUrl);
    } 
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to load post preview page
     * @access: public
     * @return void
     */ 
    public function previewyourpost($postId=0) {
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		// get post data if exists
		$postData = $this->getpostdata($postId);
		if(empty($postData)) {
			redirect('blog/addpost');
		}
		// set post preview url
		$postPreviewUrl = 'blogshowcase/preview/'.$userId.'/'.$postId.'/frontPostDetail';
		redirect($postPreviewUrl);
    } 
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to publish blog and posts
     * @access: public
     * @return void
     */ 
    public function publishblognpost() {
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		//get blog publish status
		$blogRes = $this->model_common->getDataFromTabel($this->blogTable,'isPublished','blogId',$blogId);
		$isPublished = 't';
		$msg = $this->lang->line('blogPostPublishSuccess');
		if(!empty($blogRes)) {
			$blogData = $blogRes[0];
			if($blogData->isPublished == 't') {
				$isPublished = 'f';
				$msg = $this->lang->line('blogPostHideSuccess');
			}
		}
		// update blog publish status
		$this->model_common->editDataFromTabel($this->blogTable, array('isPublished' => $isPublished), 'blogId', $blogId);
		
		// update post publish status
		$this->model_common->editDataFromTabel($this->postTable, array('isPublished' => $isPublished), 'blogId', $blogId);
        
        
        //update is completed & publish in your toadsquare
        $UserShowcaseData   =   array('currentStage'=>'','isPublished'=>$isPublished,'isCompleted'=>'t'); 
        $whereCondi         =   array('entityid'=>getMasterTableRecord('Blogs'),'projectid'=>$blogId);
        $this->model_common->editDataFromTabel('YourToadsquare', $UserShowcaseData, $whereCondi);
		
		// insert blog data in to search table
		
        //$this->setblogsearchdata($blogId);
		
		// insert data into log summary table
		addDataIntoLogSummary($this->blogTable,$blogId);
		
		$type = 'success';
		
		set_global_messages($msg, $type, $is_multiple=true);
		redirect('blogs/index');
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to load blog post
     * @access: public
     * @return void
     */ 
    public function addblogpost() {
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		// set blog post url
		$addPostUrl = 'blog/addpost';
		// set session value for app post
		$this->session->set_userdata('isAddPost',1);
		redirect($addPostUrl);
    } 
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog preview and publish
     * @access: public
     * @return void
     */ 
    public function previewnpublishpost($postId=0) {
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		// get post data if exists
		$postData = $this->getpostdata($postId);
		if(empty($postData)) {
			redirect('blog/addpost');
		}
		// set data for blog form
        $this->data['postId']        =  $postId;
        $this->data['postData']      =  $postData;
		$this->data['b4menu']        = 'TabbedPanelsTabSelected';
		$this->data['bPost5menu']    = 'TabbedPanelsTabSelected';
        $this->data['innerPage']     = 'blog/wizardform/blog_post_menus';
        $this->data['subInnerPage']  = 'blog/wizardform/preview_n_publish_post';
        $this->data['packagestageheading'] = $this->getpackageheading();
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    } 
    
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to publish posts
     * @access: public
     * @return void
     */ 
    public function publishpost($postId=0) {
		// get login user id
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		// get blog data
		$blogData = $this->model_blog->getUserBlog($userId);
		
		$type = 'error';
		$msg = $this->lang->line('firstPublishBlog');
		$redirectUrl = 'blog/previewnpublishpost/'.$postId;
		
		if($blogData[0]->isPublished == 't') {
			// get post data if exists
			$postData = $this->getpostdata($postId);
			if(empty($postData)) {
				redirect('blog/addpost');
			}
			
			// set post publish status
			$postPublish = 't';
			$msg = $this->lang->line('postPublishSuccess');
			if($postData->isPublished == 't') {
				$postPublish = 'f';
				$msg = $this->lang->line('postHideSuccess'); 
			}
			// update post publish status
			$this->model_common->editDataFromTabel($this->postTable, array('isPublished' => $postPublish), 'postId', $postId);
			
			// insert post data in to search table
			
            //$this->setpostsearchdata($postId);
			
			// insert data into log summary table
			addDataIntoLogSummary($this->postTable,$postId);
			
			$type = 'success';
			$redirectUrl = 'blog/editposts';
		}
		// set redirect url and message
		set_global_messages($msg, $type, $is_multiple=true);
		redirectPage($redirectUrl);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to set header strip title
     * @access: public
     * @return void
     */ 
    private function getpackageheading() {
		 // get post session value
		$isAddPost = $this->session->userdata('isAddPost'); 
		// set heading for blog
		$pkgHead = $this->lang->line('createYourBlog');
		if(!empty($isAddPost)) {
			// set heading for post
			$pkgHead = $this->lang->line('createYourPost');
		}
		return $pkgHead;
	}
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage search tbl data for blog
     * @access: public
     * @return void
     */ 
	private function setblogsearchdata($elementId=0) {
		
		$primaryTable = $this->blogTable; // set table name 
		$sectionId = $this->config->item('blogsSectionId');
		if($elementId > 0) {
			$blogDetails = $this->model_blog->getBlogDetails($elementId);
			if($blogDetails && is_array($blogDetails) && count($blogDetails) > 0){
				$blogData = $blogDetails[0];
				$blogId = $blogData['blogId'];
				
				$enterpriseName = pg_escape_string($blogData['enterpriseName']);
				$enterpriseName = trim($enterpriseName);
				$creative_name = ($blogData['enterprise']=='t')?$enterpriseName:pg_escape_string($blogData['firstName'].' '.$blogData['lastName']);
				
				$cacheFile = $this->dirCache.'blog_'.$blogData['blogId'].'_'.$blogData['custId'].'.php'; 
				$entityId=getMasterTableRecord('Blogs');
				/*if($updateUserContainerFlag){
					$this->lib_package->updateUserContainer($userContainerId,$entityId,$blogId,$sectionId,$sectionId);
				}*/
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
	}

	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage search tbl data for post
     * @access: public
     * @return void
     */ 
	private function setpostsearchdata($elementId=0) {
		
		$primaryTable = $this->postTable; // set table name 
		$sectionId = $this->config->item('blogsSectionId');
		if($elementId > 0) {
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
	}
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage  edit blog setup 
     * @access: public
     * @return void
     */ 
    public function manageblogsetup() {
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		// set blog post url
		$blogSetupUrl = 'blog/blogsetup';
		// set session value for blog setup
		$this->session->set_userdata('isEditBlog',1);
		$this->session->set_userdata('isAddPost',1);

		redirect($blogSetupUrl);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage  edit blog media gallery 
     * @access: public
     * @return void
     */ 
    public function managemediagallery() {
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		// set blog post url
		$blogGalleryUrl = 'blog/blogmediagallery';
		// set session value for blog media gallery
		$this->session->set_userdata('isEditBlog',1);
		$this->session->set_userdata('isAddPost',1);
		redirect($blogGalleryUrl);
    }
    
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage  edit blog cover details
     * @access: public
     * @return void
     */ 
    public function managecoverdetails() {
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		// set blog post url
		$blogCoverUrl = 'blog/blogcoverimage';
		// set session value for blog cover details
		$this->session->set_userdata('isEditBlog',1);
		$this->session->set_userdata('isAddPost',1);
		redirect($blogCoverUrl);
    }
    
     /*
     * @description: This function is used to manage  edit blog publish 
     * @access: public
     * @return void
     */ 
    public function manageblogpublicise() {
		$userId = $this->isLoginUser();
		// get blog id
		$blogId = $this->isblogcreated();
		// set blog post url
		$blogPubliciseUrl = 'blog/publiciseblog';
		// set session value for blog setup
		$this->session->set_userdata('isEditBlog',1);
		$this->session->set_userdata('isAddPost',1);

		redirect($blogPubliciseUrl);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage post edit listing
     * @access: public
     * @return void
     */ 
    public function editposts($catId=0) {
		
		// get blog id
		$blogId = $this->isblogcreated();
		// get post listing
		//$this->data['postResults'] = $this->model_blog->getPosts($blogId,'postId','',-1,$userId);		
		// set data for blog form
        $this->data['blogId']      =  $blogId;
        $this->data['userId']      =  $this->isLoginUser();
        $this->data['isArchive']   =  'f';
        $this->data['catId']       =  $catId;
        $this->data['entityId']    = getMasterTableRecord($this->postTable);
        $this->data['editPostResult'] = $this->editpostresult(true,'f',$catId);
        $this->data['packagestageheading'] = $this->lang->line('editPosts');
        $this->new_version->load('new_version','wizardform/edit_post_listing',$this->data);
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage post publicise listing
     * @access: public
     * @return void
     */ 
    public function publiciseposts($catId=0) {
		
		// get blog id
		$blogId = $this->isblogcreated();
		// get post listing
		//$this->data['postResults'] = $this->model_blog->getPosts($blogId,'postId','',-1,$userId);		
		// set data for blog form
        $this->data['blogId']      =  $blogId;
        $this->data['userId']      =  $this->isLoginUser();
        $this->data['isArchive']   =  'f';
        $this->data['catId']       =  $catId;
        $this->data['entityId']    = getMasterTableRecord($this->postTable);
        $this->data['editPostResult'] = $this->editpostresult(true,'f',$catId);
        $this->data['packagestageheading'] = $this->lang->line('publicisePosts');
        $this->new_version->load('new_version','wizardform/edit_post_listing',$this->data);
    }
    
    
      //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get elements search 
     * @access: public
     * @return: void
     */
    public function editpostresult($loadView=false, $isArchive='f',$catId=0,$archiveMonth='',$archiveYear='') {
		// get blog id
		$blogId = $this->isblogcreated();
		$userId = $this->isLoginUser();
        $isSetCookie = setPerPageCookie('searchPerPageVal',$this->config->item('perPageRecordPosts'));	
        
        $pages = new Pagination_new_ajax;
        // get project's elements list
        $sortPostBy = 'dateModified';
      
		if(!empty($archiveMonth) && !empty($archiveYear) && $isArchive == 't') {
			$this->data['countResult']=$this->model_blog->previewArchivesPost($archiveMonth,$archiveYear,$blogId,$isArchive,0,0,true);	
		} else {
			$resultCounts = $this->model_blog->getPosts($blogId,$sortPostBy,'',-1,$userId,$isArchive,'','',$catId);
			$resultCounts = count($resultCounts);
		}
		
        $pages->items_total = $resultCounts;
        $this->data['perPageRecord'] = $this->config->item('perPageRecordPosts');
        $pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$isSetCookie;
        $pages->paginate();
        
		if(!empty($archiveMonth) && !empty($archiveYear) && $isArchive == 't') {
			// get archived post results
			$postResults = $this->model_blog->previewArchivesPost($archiveMonth,$archiveYear,$blogId,$isArchive,$pages->offst,$pages->limit);
		} else {
			// get post results
			$postResults = $this->model_blog->getPosts($blogId,$sortPostBy,$postAttr['limitPosts'],-1,$userId,$isArchive,$pages->offst,$pages->limit,$catId);
		}
       
        // set pagination links and pages
        $this->data['items_total'] = $pages->items_total;
        $this->data['items_per_page'] = $pages->items_per_page;
        $this->data['pagination_links'] = $pages->display_pages();
        $pages->paginate($isShowButton=true,$isShowNumbers=false);
        $this->data['postResults']   = $postResults;
        $postResultView = $this->load->view('wizardform/edit_post_results',$this->data,$loadView);
		if($loadView) {
            return $postResultView;
		}
    }
    
    
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog categories for wizard
     * @access: public
     * @return void
     */ 
	public function blogcategorylist($blogId=0,$showFlag,$userId=0,$isArchive='f') {	
	
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
		$this->load->view('wizardform/blogCategories',$catData);
	}	
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage blog archived list for wizard
     * @access: public
     * @return void
     */ 
	function blogarchivelist($blogId=0,$showFlag,$userId=0,$isArchive='f') {	
		if($isArchive !== 't'){$isArchive='f';}	
		if($userId==0) $userId = $this->userId;		
		$data['label'] = $this->lang->language ;		
		$data = $this->model_blog->fetchArchivesYears($blogId,$userId,$isArchive);	
		$data['showFlag'] = $showFlag;	
		$data['isArchive'] = $isArchive;		
		$data['postsTable'] = $this->postTable;
		$this->load->view('wizardform/blogArchive',$data);
	}
	
	//-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to move post in archive status
    * @access: public
    * @return: void
    */
    public function moveposttoarchive() {
		
		$postId = $this->input->post('postId');
		$isRemove = $this->input->post('isRemove');
		$deleted = 0;
		$countResult = 0 ;
		$type = 'error';
		$msg = $this->lang->line('postDeleteError');
		if($postId > 0) {
			if( $isRemove == true ) {
				// remove post data from db
				$where = array('postId'=>$postId);
				$this->model_common->deleteRowFromTabel($this->postTable, $where);
			} else {
				// move post data to archived status
				$this->model_common->editDataFromTabel($this->postTable, array('isPublished' => 'f','postArchived' => 't'), 'postId', $postId);
			}
			$deleted = 1;
			$type = 'success';
			$msg = $this->lang->line('postDeleteSuccess');
		}
		set_global_messages($msg, $type, $is_multiple=true);
		echo  json_encode(array('deleted'=>$deleted));
	}
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage post deleted listing
     * @access: public
     * @return void
     */ 
    public function deletedposts($archiveMonth='',$archiveYear='') {
		
		// get blog id
		$blogId = $this->isblogcreated();	
		// set data for blog form
        $this->data['blogId']      =  $blogId;
        $this->data['userId']      =  $this->isLoginUser();
        $this->data['isArchive']   =  'f';
		$this->data['archiveMonth']=  $archiveMonth;
		$this->data['archiveYear'] =  $archiveYear;
        $this->data['entityId']    = getMasterTableRecord($this->postTable);
        $this->data['isDeletedSection']  =  't';
        // set encoded archived month and year 
		$archiveMonth = (!empty($archiveMonth)) ? decode($archiveMonth) : '';
		$archiveYear = (!empty($archiveYear)) ? decode($archiveYear) : '';
        $this->data['editPostResult'] = $this->editpostresult(true,'t',0,$archiveMonth,$archiveYear);
        $this->data['packagestageheading'] = $this->lang->line('editPosts');
        $this->new_version->load('new_version','wizardform/edit_post_listing',$this->data);
    }   
    
     //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to show selected project
     * @access: public
     * @return: void
     */
     
    public function publiciseblogindex() {
		
		
		$userId = $this->isLoginUser();
		// get blog data
		$data = $this->model_blog->getUserBlog($userId);
		
		if(isset($data[0])) {
			$blogData = $data[0];
		} else {
			redirect('blogs');
		}
		
        // set blog Id
        $blogId = $blogData->blogId;
          
		// get blog log summary
		$blogEntityId = getMasterTableRecord($this->blogTable);
		$logSummryDta = $this->model_common->getDataFromTabel('LogSummary','craveCount,viewCount,ratingAvg,reviewCount',array('entityId'=>$blogEntityId,'elementId'=>$blogId), '','','',1);
		$logSummryDta = $logSummryDta[0];
		
		// get users subscription type
		$subscriptionType = getSubscriptionType();
		
		// get container details
		$containerInfo = getUserContainerSpace($this->dirUser, $userId, $subscriptionType);
		
		//get media file names
		$this->data['blogData']      = $blogData;
		$this->data['userId']        = $userId;
		$this->data['containerSize'] = (isset($containerInfo['containerSize']))?$containerInfo['containerSize']:'';
		$this->data['remainingSize'] = (isset($containerInfo['remainingSize']))?$containerInfo['remainingSize']:'';
		$this->data['subscriptionType']  = $subscriptionType;
		$this->data['viewCount']     = (isset($logSummryDta->viewCount))?$logSummryDta->viewCount:0;
		$this->data['craveCount']    = (isset($logSummryDta->craveCount))?$logSummryDta->craveCount:0;
		$this->data['ratingAvg']     = (isset($logSummryDta->ratingAvg))?$logSummryDta->ratingAvg:0;
		$this->data['reviewCount']   = (isset($logSummryDta->reviewCount))?$logSummryDta->reviewCount:0;
		$this->data['blogId']        = $blogId;
		$this->data['packagestageheading'] = $this->lang->line('editYourBlogShowcase');
		$this->new_version->load('new_version','wizardform/blog_edit_project',$this->data);
      
    } 
    
	//----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to manage membership cart under stage 1
     * @return void
     */ 
    public function membershipcart() {
        
        $userId = $this->isLoginUser();
		// get blog data
		$data = $this->model_blog->getUserBlog($userId);
		
		if(isset($data[0])) {
			$blogData = $data[0];
		} else {
			redirect('blogs');
		}
		
        // set blog Id
        $blogId = $blogData->blogId;
		// get entity id
		$entityId = getMasterTableRecord('Blogs');
		redirect('membershipcart/managecart/'.$entityId.'/'.$blogId);
		
        /*
        //----- start manage data for edit project's add space 
       
		// set project id in session for add space
		$this->session->set_userdata('addSpaceProjectId',$blogId);
		
		if(!empty($blogData->userContainerId)) {
			// set user container id in session for add space
			$this->session->set_userdata('projectContainerId',$blogData->userContainerId);
		}
        
        //----- end managing data for add space 
        
        //get logged user subscription details
        $whereSubcrip    = array('tdsUid' => $this->userId);
        $subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', 'subscriptionType',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($subcripDetails)) {
            $subscriptionType  = $subcripDetails[0]->subscriptionType;
        }
        // get blog session cart id if exists
        $blogCartId = $this->session->userdata('blogCartId');
        $mediaCartData = '';
        if(!empty($blogCartId)) {
            // get cart temp data
            $mediaCartData = $this->model_blog->getCurrentCartData($blogCartId);
        } 
        $this->data['mediaCartData']    = $mediaCartData;
		$this->data['blogData']         = $blogData;
        $this->data['subscriptionType'] = $subscriptionType;
        $this->data['blogId']           = $blogId;
        $this->data['innerPage']        = 'blog/wizardform/membership_cart';
        $this->data['s1menu']           = 'TabbedPanelsTabSelected';
        $this->data['membership2menu']  = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
        $this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);
        */
    }
    
     //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to manage membership temp cart data
     * @return string
     */ 
    public function membershipcartpost() {
       
        // get membership form post values 
        $data = $this->input->post();
        // set blog showcase product id
        $data['tsProductId'] = $this->config->item('tsProductId_BlogShowcase');
        // set cart values
        $cartValues  = $this->setcartvalues($data); 
        // get vat percentage
        $vatPercent  = $this->config->item('media_vat_percent');
        // set vat price of total 
        $vatPrice    = (($data['extraSpacePrice']*$vatPercent)/100);
        // set total price
        $totalPrice  = $vatPrice + $data['extraSpacePrice'];
        // insert data in  temp membership cart tabel
        $cartId = $this->addCartData($totalPrice,$cartValues['orderType'],$vatPrice);
       
        // set default next step as blank
        $nextStep = ''; 
        if(isset($cartId) && !empty($cartId)) {
            // set cart id in session
            $this->session->set_userdata('blogCartId',$cartId); 
            // set default values as 0
            $pkgId = 0;	
            $containerId = 0;
            $parentCartItem = 0;
            
            $nextStep = 'billingdetails'; // set next step as billing page
            // manage add space type if project id exists
            $projectContainerId = $this->session->userdata('projectContainerId'); 
            
            if(!empty($projectContainerId) && $data['subscriptionType'] != 1)  {
				// set element id as add space project
				$elementId   = $this->session->userdata('addSpaceProjectId');
				$containerId = $projectContainerId;
                $entityId    = getMasterTableRecord('Blogs');
                
            }
            
            // set vat price on extra space 
            $vatPrice    = (($data['extraSpacePrice']*$vatPercent)/100);
            // prepare membership cart item data
            $memItemInsert = array(
                'cartId'           => $cartId,
                'tsProductId'      => $cartValues['tsProductId'],
                'price'            => $data['extraSpacePrice'],
                'size'             => $cartValues['size'],
                'pkgId'            => $pkgId,
                'pkgRoleId'        => 0,
                'totalPrice'       => $data['extraSpacePrice'],
                'type'             => $cartValues['itemType'],
                'elementId'        => (isset($elementId))?$elementId:0,
                'entityId'         => (isset($entityId))?$entityId:0,
                'parentCartItemId' => $parentCartItem,
                'userContainerId'  => $containerId,
                );
               
            // insert data in  temp membership cart item tabel
            $this->model_membershipcart->addDataMem($memItemInsert);
      
        }
        redirect('blog/'.$nextStep);
    }
    
     /*
     * @access: private
     * @description: This function is used to add temp cart data
     * @return int
     */ 
    private function addCartData($cartTotalPrice,$orderType,$vatPrice) {
        
        //prepare cart insertion data
        $inserts = array(
            'totalPrice'  => $cartTotalPrice,
            'totalTaxAmt' => $vatPrice,
            'tdsUid'      => $this->userId,
            'orderType'   => $orderType
            );
        
        // insert data in  temp membership cart tabel
        $cartId = $this->model_membershipcart->addData($inserts);
        return $cartId; 
    }
    
    /*
     * @access: private
     * @description: This function is used to set cart values as subscription 
     * @return string
     */ 
    private function setcartvalues($data) {
        
        // manage add space type if container id exists
        $projectContainerId = $this->session->userdata('projectContainerId'); 
        
        if(!empty($projectContainerId)) {
            $itemType  = $this->config->item('membership_item_type_2'); // set add container space / membership space type
            $orderType = $this->config->item('membership_item_type_1'); // set add container space / membership space type
        }
        
        if($data['subscriptionType'] != 1) { // set values for paid user
        
            //$cartValues['parentContainerSize'] = mbToBytes($this->config->item('defaultUnitofStorageSpace_paidMember_GB'),'gb');
            $cartValues['parentContainerSize'] = 0;
            $cartValues['itemType']            = (isset($itemType))?$itemType:$this->config->item('membership_item_type_10'); // set type for paid member
            $cartValues['size']                = mbToBytes($data['extraspace'],'gb'); // set type for paid member
            $cartValues['orderType']           = (isset($orderType))?$orderType:$this->config->item('membership_order_type_3'); // set order type for paid member;
            $cartValues['tsProductId']         = $this->config->item('ts_product_id_paid_user'); // set ts product id 
            $cartValues['containerPrice']      = 0;
            
            
        } else { // set values for free user
        
            $cartValues['parentContainerSize'] = mbToBytes($this->config->item('defaultUnitofStorageSpace_freeMember_MB'),'kb');
            $cartValues['size']                = mbToBytes($data['extraspace'],'mb');  // convert mb unit to bytes
            $cartValues['itemType']            = (isset($itemType))?$itemType:$this->config->item('membership_item_type_2'); // set type for free member
            $cartValues['orderType']           = $this->config->item('membership_order_type_1'); // set order type for free member;
            //$cartValues['tsProductId']       = $this->config->item('ts_product_id_free_user'); // set ts product id
            $cartValues['tsProductId']         = $data['tsProductId'];
            // set container total price of item
            $containerPrice = $this->config->item('defaultPrice_per_unitofStorageSpace_freeMember_EURO');
            if(!empty($data['totalProductPrice'])) {
                $containerPrice = $data['totalProductPrice'];
            }
            $cartValues['containerPrice'] = $containerPrice;
        }
        return $cartValues;
    }
    
	//----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to manage billing information
     * @return string
     */ 
    public function billingdetails() {
       
        // get users profile details
        $userProfileData = $this->model_membershipcart->getUserProfileData($this->isLoginUser());
        $userProfileData =  (!empty($userProfileData[0]))?$userProfileData[0]:''; 
        
        $this->data['userProfileData']  = $userProfileData; # set user profile data 
        $this->data['innerPage']        = 'blog/wizardform/billing_details';
        $this->data['membership3menu']  = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
        $this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);
    }
    
     //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to manage billing data 
     * @return string
     */ 
    public function billingdetailspost() {
        
        // get billing form post values 
        $billingData = $this->input->post();
        $nextStep = ''; // set default next step as blank
        if(!empty($billingData)) {
            
            if(isset($billingData['isSameAsSeller']) && !empty($billingData['isSameAsSeller'])) { 
                
                // set seller details as billing data
                $billing_firstName   = (!empty($billingData['firstName']))?$billingData['firstName']:'';
                $billing_lastName    = (!empty($billingData['lastName']))?$billingData['lastName']:'';
                $billing_companyName = (!empty($billingData['seller_companyName']))?$billingData['seller_companyName']:'';
                $billing_address1    = (!empty($billingData['seller_address1']))?$billingData['seller_address1']:'';
                $billing_address2    = (!empty($billingData['seller_address2']))?$billingData['seller_address2']:'';
                $billing_city        = (!empty($billingData['seller_city']))?$billingData['seller_city']:'';
                $billing_country     = (!empty($billingData['seller_country']))?$billingData['seller_country']:'';
                $billing_state       = (!empty($billingData['seller_state']))?$billingData['seller_state']:'';
                $billing_zip         = (!empty($billingData['seller_zip']))?$billingData['seller_zip']:'';
                $billing_email       = (!empty($billingData['seller_email']))?$billingData['seller_email']:'';
                $billing_phone       = (!empty($billingData['seller_phone']))?$billingData['seller_phone']:'';
                
            } else { 
                
                // set billing details
                $billing_firstName   = (!empty($billingData['firstName']))?$billingData['firstName']:'';
                $billing_lastName    = (!empty($billingData['lastName']))?$billingData['lastName']:'';
                $billing_companyName = (!empty($billingData['companyName']))?$billingData['companyName']:'';
                $billing_address1    = (!empty($billingData['addressLine1']))?$billingData['addressLine1']:'';
                $billing_address2    = (!empty($billingData['addressLine2']))?$billingData['addressLine2']:'';
                $billing_city        = (!empty($billingData['townOrCity']))?$billingData['townOrCity']:'';
                $billing_country     = (!empty($billingData['countriesList']))?$billingData['countriesList']:'';
                $billing_state       = (!empty($billingData['stateList']))?$billingData['stateList']:'';
                $billing_zip         = (!empty($billingData['zipCode']))?$billingData['zipCode']:'';
                $billing_email       = (!empty($billingData['email']))?$billingData['email']:'';
                $billing_phone       = (!empty($billingData['phoneNumber']))?$billingData['phoneNumber']:'';
            }
            
            // set billing data array 
            $billingDataArray = array(
                'tdsUid'              => $this->userId,
                'billing_firstName'   => $billing_firstName,
                'billing_lastName'    => $billing_lastName, 
                'billing_companyName' => $billing_companyName,
                'billing_address1'    => $billing_address1,
                'billing_address2'    => $billing_address2,
                'billing_city'        => $billing_city,
                'billing_country'     => $billing_country,
                'billing_state'       => $billing_state,
                'billing_zip'         => $billing_zip,
                'billing_email'       => $billing_email,
                'billing_phone'       => $billing_phone,
                );
            
            // get membership card from session
            $cartId = $this->session->userdata('blogCartId');
           
            if(!empty($cartId)) {
                // manage buyer's billing data log
                $nextStep = $this->updatebuyerdata($billingDataArray,$billingData,$cartId);
            }
        }
        
        //redirect($this->redirectUrl.$nextStep);
        echo json_encode(array('nextStep'=>$nextStep));
    }
    
     //----------------------------------------------------------------------

    /*
     * @access: private
     * @description: This function is used to update buyer billing data
     * @return string
     */ 
    private function updatebuyerdata($billingDataArray,$billingData,$cartId) {
        // add billing data in cart 
        $this->model_blog->updateBillingData(array('billingdetails'=>json_encode($billingDataArray)), $cartId);
        // update or add buyer billing data for global setting
        if(isset($billingData['isSaveInBilling']) && !empty($billingData['isSaveInBilling'])) {
            // insert & udpate buyer data in user buyer table
            $buyerSettingData =  $this->model_common->getDataFromTabel('UserBuyerSettings', 'id',  array('tdsUid' => $this->userId),'','','',1);
            // push tax text value if exists
            if(!empty($billingData['otherAboutConsumptionTax'])) {
                $billingDataArray['otherAboutConsumptionTax'] = $billingData['otherAboutConsumptionTax'];
            }
            
            if(!empty($buyerSettingData)) {
                $buyerSettingData  =  $buyerSettingData[0];
                $buyerUserId       =  $buyerSettingData->id;
                // update buyer billing data
                $this->model_common->editDataFromTabel('UserBuyerSettings', $billingDataArray, 'id', $buyerUserId);
            } else {
                // add buyer billing data
                $this->model_common->addDataIntoTabel('UserBuyerSettings', $billingDataArray);
            }
            
        }
        $nextStep = '/purchasesummary'; // set next step as purchase summary
        return $nextStep;
    }
    
	//----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to show purchase summary
     * @return string
     */ 
    public function purchasesummary() {
       
        // get membership card from session
        $cartId = $this->session->userdata('blogCartId');

		// get blog data
		$data = $this->model_blog->getUserBlog($this->userId);
		
		if(isset($data[0])) {
			$blogData = $data[0];
		} else {
			redirect('blogs');
		}
		
        // set blog Id
        $blogId = $blogData->blogId;
        
        $spaceSize = '';
        $spaceUnit = '';
        $spacePrice = 0;
        $containerPrice = 0;
        if(!empty($cartId)) {
            // get membership cart data
            $cartData =  $this->model_common->getDataFromTabel('MembershipCart', '*',  array('cartId' => $cartId),'','','',1);
            $buyerBillingData = '';
            if(!empty($cartData)) {
                $cartData = $cartData[0];
                // set buyers billing data of cart
                $buyerBillingData = json_decode($cartData->billingdetails);
                // get membership cart item data
                $cartMemItemData =  $this->model_common->getDataFromTabel('MembershipCartItem', '*',  array('cartId' => $cartId),'','cartItemId','DESC');
                 
                if(!empty($cartMemItemData) && is_array($cartMemItemData)) {
                    $cartItemData = $cartMemItemData[0]; // get cart space data
                    //get logged user subscription details
                    $whereSubcrip 		= array('tdsUid' => $this->userId);
                    $subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', 'subscriptionType',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
                    if(!empty($subcripDetails)) {
                        $subscriptionType  = $subcripDetails[0]->subscriptionType; // set subscription type
                        if($subscriptionType == 1) { //set space values for free type
                            $spaceSize = bytestoMB($cartItemData->size,'mb');
                            $spaceUnit = $this->lang->line('mb');
                        } else { //set space values for paid type
                            $spaceSize = bytestoMB($cartItemData->size,'gb');
                            $spaceUnit = $this->lang->line('gb');
                        }
                        // set containers price if container exists
                        if(isset($cartMemItemData[1]) && !empty($cartMemItemData[1])) {
                            $containerPrice = $cartMemItemData[1]->totalPrice;
                        }
                    }	
                    // set space price
                    $spacePrice = $cartItemData->totalPrice;
                }
            }
        } else {
            redirect('blog/membershipcart');
        }
        
        // get users seller details 
        $userSellerData = $this->model_membershipcart->getUserProfileData($this->userId);
        // set wizard section
        $this->session->set_userdata('wizardMediaSection',$this->router->fetch_method()); 
        // get vat percentage	
        $vatPercent  = $this->config->item('media_vat_percent');
        // calculate total price
        $totalPrice  = $spacePrice + $containerPrice;
        // set vat price of total 
        $vatPrice    = (($totalPrice*$vatPercent)/100);
        $this->data['spaceSize']        = $spaceSize;
        $this->data['spaceUnit']        = $spaceUnit;	
        $this->data['spacePrice']       = $spacePrice;
        $this->data['totalPrice']       = $totalPrice;
        $this->data['vatPrice']         = $vatPrice;
        $this->data['containerPrice']   = $containerPrice;		
        $this->data['buyerSettingData'] = $buyerBillingData;
        $this->data['blogData']         = $blogData; 
        $this->data['userSellerData']   = (!empty($userSellerData[0]))?$userSellerData[0]:'';
		$this->data['innerPage']        = 'blog/wizardform/purchase_summary';
        $this->data['membership4menu']  = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
        $this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);
        
    }
    
      
    //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to show payment error view
     * @return void
     */ 
    
    public function paymenterror() {
        
        // manage payment error page display
        $this->data['innerPage']        = 'blog/wizardform/payment_error';
        $this->data['membership5menu']  = 'TabbedPanelsTabSelected';
        $this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);
       
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to show payment success view
     * @return void
     */ 
    
    public function paymentsuccess() {
		
        // get media container id
        $mediaContainerId = $this->session->userdata('mediaContainerId');
       
		$sectionId = $this->config->item('blogsSectionId');
        if(!empty($mediaContainerId)) {
             
            // set project id in session for add space
            $addSpaceProjectId  = $this->session->userdata('addSpaceProjectId');
			
            if(!empty($addSpaceProjectId)) {
                $projId = $addSpaceProjectId;
                // update space for free member
                $this->updatefreeaddpace();
                    
				// unset session values
				$this->session->unset_userdata('addSpaceProjectId');
				$this->session->unset_userdata('projectContainerId');
			}              

			$this->data['innerPage']       = 'blog/wizardform/payment_success';
			$this->data['membership5menu'] = 'TabbedPanelsTabSelected';
			$this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
			$this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);

        } else {
            redirect('blog/');
        }
    }
    
      //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to get update ad space of project
     * @return void
     */ 
    private function updatefreeaddpace() {
        // get media container id
        $mediaContainerId = $this->session->userdata('mediaContainerId');
        //get logged user subscription details
        $whereSubcrip    = array('tdsUid' => $this->userId);
        $subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', 'subscriptionType',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($subcripDetails) && !empty($mediaContainerId)) {
            $subscriptionType  = $subcripDetails[0]->subscriptionType; // set subscription type
            if( $subscriptionType == 1 ) { //set space values for free type
                // get item's space size  
                $itemMembershipRes = $this->model_media->getItemContainerSize($mediaContainerId);
                if(!empty($itemMembershipRes)) {
                    // add total space
                    $addSpace = intval($itemMembershipRes[0]->containerSize) + intval($itemMembershipRes[0]->size);
                    // update added space
                    $this->model_common->editDataFromTabel('UserContainer', array('containerSize'=>$addSpace), array('userContainerId' => $mediaContainerId));
                }
            }
        }
    }


	
}//End Class
?>
