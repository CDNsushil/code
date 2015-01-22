<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
/*
	 Description:
	 * The model_blog class is meant to handle the processing of the Blog section
	 * It include functionality to fetch/add/edit Blog content for logged in user 
	 * @package	Toadsquare
	 * @subpackage	Module
	 * @category	Controller
	 * Author Name: Gurutva Singh
	 * Date Created: 24 January 2012
	 * Date Modified: 9 Februray 2012 by Gurutva Singh	
*/
Class model_blog extends CI_Model {
	
	private $tableName = 'Blogs'; //Private Variable(Table Name) to get used at class level only
	private $postTable = 'Posts';
	private $postMediaTable = 'PostGallery';
	private $blogCatName = 'BlogCategory';
	private $MediaFile = 'MediaFile';
	private $share = 'Share';
	//private $userId = NULL;
	private $projType = 'BLOG';
	
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
	private $gallery_allowed_upload_img_extra_small_suffix = '_extra_small';
	/**
	 * Constructor
	 **/
	function __construct()
	{
		parent::__construct();
		// My own constructor code
		$this->config->load('image_config');
		
		$this->gallery_thumb_version_folder = $this->config->item('gallery_thumb_version_folder');
		
		$this->gallery_allowed_upload_img_orignal_suffix = $this->config->item('gallery_allowed_upload_img_orignal_suffix');
		
		//$this->gallery_allowed_upload_img_big_width = $this->config->item('gallery_allowed_upload_img_big_width');
		//$this->gallery_allowed_upload_img_big_height = $this->config->item('gallery_allowed_upload_img_big_height');
		$this->gallery_allowed_upload_img_big_suffix = $this->config->item('gallery_allowed_upload_img_big_suffix');
		
		//$this->gallery_allowed_upload_img_medium_width = $this->config->item('gallery_allowed_upload_img_medium_width');
		//$this->gallery_allowed_upload_img_medium_height = $this->config->item('gallery_allowed_upload_img_medium_height');
		$this->gallery_allowed_upload_img_medium_suffix = $this->config->item('gallery_allowed_upload_img_medium_suffix');
		
		//$this->gallery_allowed_upload_img_small_width = $this->config->item('gallery_allowed_upload_img_small_width');
		//$this->gallery_allowed_upload_img_small_height = $this->config->item('gallery_allowed_upload_img_small_height');
		$this->gallery_allowed_upload_img_small_suffix = $this->config->item('gallery_allowed_upload_img_small_suffix');
		
		//$this->gallery_allowed_upload_img_extra_small_width = $this->config->item('gallery_allowed_upload_img_extra_small_width');
		//$this->gallery_allowed_upload_img_extra_small_height = $this->config->item('gallery_allowed_upload_img_extra_small_height');
		$this->gallery_allowed_upload_img_extra_small_suffix = $this->config->item('gallery_allowed_upload_img_extra_small_suffix');
		$this->userId = $this->isLoginUser();
	}

	/**	
	 * Fetchs the blog ID only of logged in User 
	 * @access	public
	 * @param	userId
	 * @return	array	
	**/	
	
	function getBlogId($userId)
	{			
		 $this->db->select('blogId');
		 $this->db->where('custId',$userId);
		 $this->db->from($this->tableName);
		 $query = $this->db->get();
		 return $query->result();  	 
	}

	/*	
	 * Fetchs the blog data on the basis of logged in User 
	 * @access	public
	 * @param	userId
	 * @return	array	
	*/	
	
	function getUserBlog($userId)
	{
		 $this->db->select('blogId,blogTitle,blogOneLineDesc,blogTagWords,blogIndustry,blogLanguage,dateCreated,blogToFacebook,blogToTwitter,blogToShareOn,blogToDonate,blogFor,blogCraveCount,blogViewCount,blogPublish,dateModified,filePath,fileName');
		 $this->db->select($this->tableName.'.fileId');
		 $this->db->from($this->tableName);
		 $this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->tableName.'.fileId', 'left');
		 $this->db->where('custId',$userId);
		 $query = $this->db->get();
		 return $query->result();  	 
	}
	
	
	function getBlogCategory($blogId=0)
	{		
		 $this->db->select('*');
		 $this->db->from($this->blogCatName);
		 $this->db->where('blogId',$blogId);
		 $this->db->limit(10);
		 $this->db->order_by("categoryTitle", "asc"); //TO SHOW ALPHABETIC ORDER
		 $query = $this->db->get();
		 return $query->result();		 
	}
	
	function getPostsCategory($blogId=0)
	{		
		 
		 //QUERY WITH POSTS JOIN TO SHOW COUNT AS WELL WITH CATEGORIES
		 
		 $this->db->select('categoryId,categoryTitle,COUNT( "TDS_Posts"."postId" ) as postCount');
		 
		 $this->db->from($this->blogCatName);
		
		 $this->db->where($this->blogCatName.'.uId',$this->userId);
		 
		 $this->db->join($this->postTable,$this->postTable.'.blogCategoryId='.$this->blogCatName.'.categoryId','LEFT');
		 
		 $this->db->group_by("categoryId,categoryTitle"); 
		
		 $this->db->order_by("categoryTitle", "asc"); //TO SHOW ALPHABETIC ORDER
		
		 $query = $this->db->get();
		
		 return $query->result(); 
			 
	}
	
	
	function saveBlogCategory($catArray,$userId){
		
		//Get the blog Id to get inserted in category table
		$blogIdArray = $this->getBlogId($userId);	
		$blogId = $blogIdArray[0]->blogId;
		//echo '<pre />Blog Cat Save:';print_r($catArray);die;
		//Intialized to distingush the records to insert and update
		
		/*$updatecatArray = $catArray['categoryTitleEdit'];			*/
		if(is_array($catArray))
		{
			if(isset($catArray['categoryTitle']) && $catArray['categoryTitle']!='')
			{
				if($catArray['categoryId'] ==0){
					$catInsertRecord['blogId'] = $blogId;
					$catInsertRecord['uId'] = $userId;
					$catInsertRecord['categoryTitle'] = $catArray['categoryTitle'];
					$query = $this->db->insert($this->blogCatName, $catInsertRecord);
					$lastInsertId = $this->db->insert_id();
				}
				else{
					$updatekey = $catArray['categoryId'];
					$updatevalue = $catArray['categoryTitle'];
					$this->db->where('categoryId',$updatekey);
					$catUpdateRecord['blogId'] = $blogId;
					$catUpdateRecord['uId'] = $userId;
					$catUpdateRecord['categoryTitle'] = $updatevalue;
					$query = $this->db->update($this->blogCatName, $catUpdateRecord);
					$lastInsertId = $updatekey;
				}
			}
			
		}
		
		/*
		if(is_array($insertcatArray)){
			while (list($insertkey, $insertvalue) = each($insertcatArray)) {
				if($insertvalue!=''){
				$catInsertRecord['blogId'] = $blogId;
				$catInsertRecord['uId'] = $userId;
				$catInsertRecord['categoryTitle'] = $insertvalue;
				$query = $this->db->insert($this->blogCatName, $catInsertRecord);
			}
			}		
		}
		
		if(is_array($updatecatArray)){
			while (list($updatekey, $updatevalue) = each($updatecatArray)) {
				$this->db->where('categoryId',$updatekey);
				$catUpdateRecord['blogId'] = $blogId;
				$catUpdateRecord['uId'] = $userId;
				$catUpdateRecord['categoryTitle'] = $updatevalue;
				$query = $this->db->update($this->blogCatName, $catUpdateRecord);
			}
		}
		*/
		
		$delblogCategoryIds = $this->input->post('delCatId');
		
		if(isset($delblogCategoryIds) && $delblogCategoryIds!=''){
			if(!is_array($delblogCategoryIds)) {
				$delblogCategoryIds = explode(',',$delblogCategoryIds);
			}
			
			$this->db->where_in('categoryId',$delblogCategoryIds);
			$this->db->delete($this->blogCatName);
			//echo $this->db->last_query();die;
		}
	if(isset($lastInsertId))
	return $lastInsertId;
	}
	
	function getCatExistsInPost($userId){
		$this->db->select('blogCategoryId');
		$this->db->distinct('blogCategoryId');
		$disCatResult = $this->db->get($this->postTable)->result_array();
		return $disCatResult;
	}
	/*	
	 * Fetchs the blog data on the basis of blogId 
	 * @access	public
	 * @param	userId
	 * @return	array
	*/		
	function getBlog($blogId)
	{	
		$this->db->select('*');
		 $this->db->where('blogId',$blogId);
		 $query = $this->db->get($this->tableName);
		 return $query->result_array(); 	 
	}
	
	 /*
	  * Insert/Update a new row into the specified database table from the common function
	  * @access	public
	  * @param	null
	  * @return	null
	  *
	  */		
	function saveBlog($blogFileId=0)
	{	
		$blogRecord = $_POST;
		
		$blogRecord['fileId'] = $blogFileId;
		
		//Unset the array element as its not a field of table
		unset($blogRecord['save']);
		unset($blogRecord['submit']);
		unset($blogRecord['categoryTitle']);
		unset($blogRecord['delCatId']);
		unset($blogRecord['categoryTitleEdit']);
		unset($blogRecord['stockImageId']);
		
		
		 $blogToDonate = $this->input->post('blogToDonate');
		
		 if(strcmp($blogToDonate ,'accept')==0) 
		 {
			 $blogRecord['blogToDonate'] = 't';			
		 }
		 else 
		 {
			 $blogRecord['blogToDonate'] = 'f';			 
		 }
		 
		 $blogToShareOn = $this->input->post('blogToShareOn');
		 
		 if(strcmp($blogToShareOn ,'accept')==0) 
		 {
			 $blogRecord['blogToShareOn'] = 't';			
		 }
		 else 
		 {
			 $blogRecord['blogToShareOn'] = 'f';			 
		 }
		 
		$blogToTwitter = $this->input->post('blogToTwitter');
		 
		 if(strcmp($blogToTwitter ,'accept')==0) 
		 {
			 $blogRecord['blogToTwitter'] = 't';			
		 }
		 else 
		 {
			 $blogRecord['blogToTwitter'] = 'f';			 
		 }
		 
		$blogToFacebook = $this->input->post('blogToFacebook');
		if(strcmp($blogToFacebook ,'accept')==0) 
		{
			 $blogRecord['blogToFacebook'] = 't';			
		}
		else 
		{
			 $blogRecord['blogToFacebook'] = 'f';			 
		}
		 	
		
		//Checks if there is no record in table then only insert else update
		if ($blogRecord['blogId'] == 0) 
		{
		  
		  unset($blogRecord['blogId']);	  unset($blogRecord['txtflName']);	
	
		  if($_FILES['userfile']['size']>0  && $Upload_File_Name!='') 
		  {
			  $blogRecord['blogImgPath'] = $Upload_File_Name;
		  }
		  
		  $blogRecord['dateCreated'] = date("Y-m-d H:i:s");
		  $blogRecord['dateModified'] = date("Y-m-d H:i:s");
				
		$query = $this->db->insert($this->tableName, $blogRecord);	 		   
		  
		} 
		else 
		{			
			//A record does exist, update it.
			$blogRecord['dateModified'] = date("Y-m-d H:i:s");
			
			unset($blogRecord['fileInput']);	
			unset($blogRecord['custId']);
			
			$this->db->where('blogId',$blogRecord['blogId']);
			
			$query = $this->db->update($this->tableName,$blogRecord);
		} 
		
	//return $blogId;
	}
	
	
	/**
		* Fetches the Language for Language table to get displayed in dropdown of Languages
	**/	
	function loadLanguage()
	{	
		$this->db->select('*');
		$recordsLanguage = $this->db->get('MasterLang');	
		$language = $recordsLanguage->result();
		return $language;
	}
			
	/*
	 ************All Post related functions goes here************
	*/


	/**
	  * Displays single the post related with the blog
	  * @access	public
	  * @param	postId
	  * @return	object
	**/
	function getPost($postId){
	
		$this->db->where('postId', $postId);
		
		$data['postQuery'] = $this->db->get($this->postTable); 
		$data['postResults'] = $data['postQuery']->result(); 
	
		return $data;	
		
	}
	
	/**
	  * Displays single the post related with the blog
	  * @access	public
	  * @param	postId
	  * @return	object
	**/
	function getParentPost($postId){
	
		$this->db->select('postId,postTitle');
		$this->db->where('postId', $postId);
		$this->db->from($this->postTable);
		$postQuery = $this->db->get(); 
		$data['postResults'] = $postQuery->result(); 
	
		return $data;	
		
	}
	/**
	  * Displays single the post related with the blog
	  * @access	public
	  * @param	postId
	  * @return	object
	**/
	function getCatPosts($catId,$blogId){
	
	//To show all posts on click on category and Archive scetion's labels
		//echo $catId;die;
		$this->db->select('postId,blogId,postTitle,postDesc,dateCreated,blogCategoryId,postTagWords,postOneLineDesc,custId,postCraveCount,postViewCount,postPostCount,dateModified,postPublish,postFileId,filePath,fileName');
		$this->db->from($this->postTable);
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		
		if($catId ==0)
			$this->db->where('blogId', $blogId);
		else
			$this->db->where('blogCategoryId', $catId);
		
		$field = "postArchived";
				
		$this->db->where($field,'t');
		
		
		$orderByPosts= '"dateCreated" desc';
		$this->db->order_by($orderByPosts); 
		
		$data['postQuery'] = $this->db->get(); 
		
		$data['postResults'] = $data['postQuery']->result(); 
	
		return $data;	
		
	}
	/**
	  * Displays all the posts related with the blog
	  * @access	public
	  * @param	blogId
	  * @return	object
	**/
	function getPosts($blogId,$sortPostBy="dateCreated",$limitPosts=0,$postId=0)
	{
	
		$this->db->select('postId,blogId,postTitle,postDesc,dateCreated,blogCategoryId,postTagWords,postOneLineDesc,custId,postCraveCount,postViewCount,postPostCount,dateModified,postPublish,postFileId,filePath,fileName');
		$this->db->from($this->postTable);
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		
		$sortArray = array('dateModified');// valid values for the <select> field
		
		if($blogId>0)
			$this->db->where('blogId', $blogId);
		
		if($postId>0)
			$this->db->where('postId', $postId);
			
		if(strcmp($sortPostBy,'publish') ==0) $orderByPosts = '"postPublish" \=\'f\',"dateModified" desc';
		
		if(strcmp($sortPostBy,'unpublish') ==0) $orderByPosts = '"postPublish" \=\'t\',"dateModified" desc';	
		
		//Flag to show all the posts not accotiated with paarticular year
		
		if($postId != -1)
		{
			if($postId==0)
			{
			//TO FETCH THE RECORD FOR CURRENT YEAR ONLY AS DEFAULT
				$temp = getdate();
				$currentYear = $temp["year"]; 
				
				$this->db->where('date_part(\'YEAR\',"public"."TDS_Posts"."dateCreated")=', $currentYear);
			//END
			}
	    }
		
		$field = "postArchived";
				
		$this->db->where($field,'t');
		
		if(isset($orderByPosts) && $orderByPosts !='')
			$orderByPosts = str_replace("\\","",$orderByPosts);
		else
		{
			if( in_array($sortPostBy, $sortArray) ) 
			{ 
				// make sure the value is valid
			   $orderByPosts = '"'.$sortPostBy.'"'.' desc';
			} 
			else 
			{
			   $orderByPosts = '';
			}
		}		
		
		if(!isset($orderByPosts) || $orderByPosts=='') $orderByPosts= '"dateCreated" desc';
		$this->db->order_by($orderByPosts); 
		
		if($limitPosts>0)
			$this->db->limit($limitPosts);
		
		$data['postQuery'] = $this->db->get(); 		
		
		$data['postResults'] = $data['postQuery']->result(); 
		
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
		
		return $data;			
	}
	
	/**
		* Here fetches the posts according to month and year passed to function
		* @access public
		* @params archiveMonth
		* @params archiveYear
			
		* return array
	**/
	function previewArchivesPost($archiveMonth,$archiveYear,$blogId)
	{	
		$table = $this->db->dbprefix('Posts');
		
		$query = 'SELECT * FROM "'.$table.'" LEFT JOIN "TDS_MediaFile" ON "TDS_MediaFile"."fileId" = "TDS_Posts"."postFileId"
		WHERE date_part(\'YEAR\',"public"."TDS_Posts"."dateCreated")  =\''.$archiveYear.'\'';
		if(isset($archiveMonth) && $archiveMonth!=0) 
		$query .= ' AND date_part(\'Month\',"public"."TDS_Posts"."dateCreated")  =\''.$archiveMonth.'\'';
		
		$query .= ' AND "public"."TDS_Posts"."blogId" = '.$blogId;
		
		$postArchived = 't';
		
		$postPublish= 't';
		
		$query .=' AND "TDS_Posts"."postArchived" = \''.$postArchived.'\'';
		//$query .=' AND "TDS_Posts"."postPublish" = \''.$postPublish.'\'';
		$query .=' order by "TDS_Posts"."dateCreated" desc';
		
		$archivePostDetailResults['postQuery'] = $this->db->query($query); 
				
		$archivePostDetailResults['postResults'] = $archivePostDetailResults['postQuery']->result(); 
		
		return $archivePostDetailResults;
	}
	
	/**
	  * Displays all the posts related with the Parent Post
	  * @access	public
	  * @param	blogId
	  * @return	object
	**/
	function getChildPosts($parentPostId=0)
	{
	
		$this->db->select('postId,parentPostId,blogId,postTitle,postDesc,dateCreated,blogCategoryId,postTagWords,postOneLineDesc,custId,postCraveCount,postViewCount,postPostCount,dateModified,postPublish,postFileId,filePath,fileName');
		$this->db->from($this->postTable);
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		
		if($parentPostId == 0)$parentPostId=-1;
		$this->db->where('parentPostId', $parentPostId);
		
		$this->db->order_by('dateModified', 'desc'); 
		
		$data['postQuery'] = $this->db->get(); 
		
		$data['postResults'] = $data['postQuery']->result(); 
	
		return $data;			
	}
	
	/**
		*
		* Fill the post form with values form table to get edited
		* @access	public
		* @params $blogId
		* @params $postId
		
		* return array
	**/	
	
	function postForm($blogId,$postId=0)
	{
		$fieldBlogId = 'blogId';
		
		$fieldPostId = 'postId';
		
		$this->db->select('*');
		$this->db->from($this->postTable);
	
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		$this->db->where($fieldBlogId,$blogId);
		$this->db->where($fieldPostId,$postId);
		
		$postResult = $this->db->get();
		
		if($postResult->num_rows()>0)
		{					
			$postData  = $postResult->result_array();
			//echo '<pre />';print_r($postData);
		} 
		else
		{
			$postData[0] = array(
			 	'blogId'=>$this->input->post('blogId'),
				'postId'=>$this->input->post('postId'),
				'custId'=>$this->input->post('workOneLineDesc'),
				'postTitle'=>$this->input->post('postTitle'),
				'postDesc'=>$this->input->post('postDesc'),
				'postCraveCount'=>$this->input->post('postCraveCount'),
				'postPublish'=>'t',
				'postShortLink'=>$this->input->post('postShortLink'),
				'parentPostId'=>$this->input->post('parentPostId'),
				'allowComments'=>$this->input->post('allowComments'),
				'dateCreated'=>date("Y-m-d H:i:s"),
				'postTagWords'=>$this->input->post('postTagWords'),
				'postPostCount'=>$this->input->post('postPostCount'),
				'blogCategoryId'=>$this->input->post('blogCategoryId'),
				'postOneLineDesc'=>$this->input->post('postOneLineDesc'),
				'dateModified'=>date("Y-m-d H:i:s")						
	     );
		}
		
		return $postData;			
	}
	
	/**
		*
		* Fill the post form with values form table to get edited
		* @access	public
		* @params $blogId
		* @params $postId
		
		* return array
	**/		
	function updatePost($blogId,$postId=0)
	{
		$fieldBlogId = 'blogId';
		$fieldPostId = 'postId';
		
		if($postId!=0)
		{
			$this->db->where($fieldBlogId,$blogId);
			$this->db->where($fieldPostId,$postId);
			$postResult = $this->db->get($this->postTable) or die(mysql_error());
		} 
		
		return $postResult->result_array();		
	}
	
	/**
		*
		* Insert/Update a new row into post table from the common function
		* @access	public
		* @params $blogId
		* @params $postId
		
		* return array
	**/	
	function savePost($postFileId)
	{	
	
		$postData = array(
			 	'blogId'=>$this->input->post('blogId'),				
				'custId'=>$this->input->post('custId'),
				'postTitle'=>$this->input->post('postTitle'),
				'postDesc'=>$this->input->post('postDesc'),
				'postCraveCount'=>$this->input->post('postCraveCount'),
				'postPublish'=>'t',
				'postShortLink'=>$this->input->post('postShortLink'),
				'parentPostId'=>$this->input->post('parentPostId'),
				'allowComments'=>'t',
				'dateCreated'=>date("Y-m-d H:i:s"),
				'postTagWords'=>$this->input->post('postTagWords'),
				'postPostCount'=>$this->input->post('postPostCount'),
				'blogCategoryId'=>$this->input->post('blogCategoryId'),
				'postOneLineDesc'=>$this->input->post('postOneLineDesc'),
				'postFileId'=>$postFileId,
				'dateModified'=>date("Y-m-d H:i:s")						
	     );
				
		$blogId = $this->input->post('blogId');
		
		$postId = $this->input->post('postId');
		
		$fieldBlogId = 'blogId';
		
		$fieldPostId = 'postId';
		
		unset($postData['save']);
		
		if($postId!=0)
		{			
			$this->db->where($fieldBlogId,$blogId);
			$this->db->where($fieldPostId,$postId);
			$postData['dateModified'] = date("Y-m-d H:i:s"); 
			$postResult = $this->db->update($this->postTable,$postData);//Update post
		} 
		else
		{
			unset($postData['postId']);
			$postData['dateCreated'] = date("Y-m-d H:i:s"); 
			$postData['dateModified'] = date("Y-m-d H:i:s"); 
			$postResult = $this->db->insert($this->postTable, $postData);//Insert new record for posts 
		}
		
		return $postId;
	}
	
	
	/**
		* Publishing/Unpublishing the post 
		* @access	public
		* @params $postId
		
		* redirect
	**/	
	function publishPost($postId)
	{			
		$field = 'postId';
		
		$table=$this->db->dbprefix($this->postTable);
				
		$updatePost['postPublish'] = "FALSE";
		
		$togglePublishUpdateQuery ='update "'.$table.'" SET "dateModified"=\''.date("Y-m-d H:i:s").'\',"postPublish" =( CASE
							 WHEN ("postPublish" =  true) THEN false ELSE true END ) WHERE "'.$field.'" ='.$postId;
				
		$this->db->query($togglePublishUpdateQuery);
		
		redirect('blog/blog');		
	}
	
	/**
		* Archiving/Unarchiving the post functionality
		* @access	public
		* @params $postId
			
		* redirect
	**/
	function archivePost($postId,$blogId)
	{ 
		$table = $this->db->dbprefix($this->postTable);	
			
		$field = 'postId';		
		
		$toggleArchiveUpdateQuery ='update "'.$table.'" SET "postArchived" =( CASE
				WHEN ("postArchived" =  true) THEN false ELSE true END ) WHERE "'.$field.'" ='.$postId;
								
		$this->db->query($toggleArchiveUpdateQuery);
		
	}
	
	/**
		* Function to Get all records of the post table with adre archived/deleted i.e.,archived=false
		* @access	public
		* @params $blogId
					
		* return array

	**/
	function showArchives($blogId){
	
		$this->db->where('blogId', $blogId);
		
		$this->db->where('postArchived', 'f');
		
		$data['archivePostQuery'] = $this->db->get($this->postTable); 
		
		$data['archivePostResults'] = $data['archivePostQuery']->result(); 
		
		return $data;
	
	}
	
	/**
		* Display the Post preview 
		* @access	public
		* @params $postId
			
		* return array
	**/
	function previewPost($postId){
	
		$this->db->select('postId,postTitle,postDesc,postTagWords,dateCreated,blogId,postFileId,filePath,fileName');
		
		$this->db->from($this->postTable);
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		$this->db->where('postId', $postId);
		$data['previewPostQuery'] = $this->db->get(); 
		
		return $data['previewPostQuery']->result() ;
	
	}
	
	/**
		************All Archives Posts related functions**************
	**/
	
	/**
		* Here fetches the years to get shown the records
		* @access	public
		* @params $blogId
			
		* return array
	**/
	function fetchArchivesYears($blogId)
	{		
		$table=$this->db->dbprefix('Posts');
		
		$query = 'SELECT date_part(\'YEAR\',"dateCreated") as YearExtracted from "'.$table.'" where "blogId" = \''.$blogId.'\' group by YearExtracted 
		order by YearExtracted desc';	
		
		$data['archiveYearQuery'] = $this->db->query($query);
				
		return $data;	
	}
	
	/**
		* Here fetches the months from posts according  year passed to function
		* @access public
		* @params year
					
		* return array
	**/
	
	function showArchivesMonths($year)
	{
		$table = $this->db->dbprefix('Posts');
			
		$query = 'SELECT DISTINCT date_part(\'MONTH\',"public"."TDS_Posts"."dateCreated") AS month ,
		COUNT( "TDS_Posts"."postId" ) as postCount FROM "'.$table.'"
		WHERE date_part(\'YEAR\',"public"."TDS_Posts"."dateCreated")  = \''.$year.'\'  ';	
		
		$postArchived = 't';
		
		$postPublish = 't';
		
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
		
		$query .=' AND "TDS_Posts"."postArchived" = \''.$postArchived.'\'';
		$query .=' AND "TDS_Posts"."postPublish" = \''.$postPublish.'\'';
		$query .=' AND "TDS_Posts"."blogId" = \''.$blogId .'\'';
		$query .=' GROUP BY month order by month desc ';
		
		//$query .=' order by "TDS_Posts"."dateCreated" desc';
			
		$data['archivePostQuery'] = $this->db->query($query); 
		
		$archivePostResults = $data['archivePostQuery']->result_array(); 
		
		return $archivePostResults;
	}
	
	/**
	  * Displays all the media gallery 
	  * @access	public
	  * @return	object
	**/
	function mediaGallery($userId)
	{	
		$field = 'userId';
		
		$this->db->where($field,decode($userId));
		
		$this->db->order_by('attachedDate', 'desc');
		
		$data['postMediaQuery'] = $this->db->get($this->postMediaTable);
		 		
		$data['postMediaResults'] = $data['postMediaQuery']->result(); 
				
		return $data['postMediaResults'];	
	}
	
	
	/**
		* postMediaGalleryForm method fetches the records form  post Media Gallery
		* giving the values in the options array priority.
		*
		* @param int $postMediaGalleryId
		* @return array
	**/	
	function postMediaGalleryForm($postMediaGalleryId)
	{	
			//Checks if submit or not		
		$table = $this->postMediaTable;
		
		$field = 'postGalleryId';
		
		$this->db->where($field,$postMediaGalleryId);
		
		$postMediaGalleryResult = $this->db->get($table);	
		
		if($postMediaGalleryResult->num_rows()>0)
		{					
			$postMediaGalleryResultData  = $postMediaGalleryResult->result_array();
		} 
		else
		{
			$postMediaGalleryResultData[0] = array(
			'galPath' => $this->input->post('galPath'),
			'galTitle' => $this->input->post('galTitle'),
			'galAltText' => $this->input->post('galAltText'),
			'attachedDate' => $this->input->post('attachedDate'),
			);
		}	
			
		return $postMediaGalleryResultData;	
	}
	
	/**
		* insertMediaGallery method Inserts a record in the MediaGallery table".
		*
		* Post: Values
		* --------------

		* @param int postGalleryId
	**/	
	function insertMediaGallery($Upload_File_Name,$uploadCountFiles)
	{		
		$galPath = '';
		
		for($i=0; $i<$uploadCountFiles; $i++)
		{	
			$galPath = $Upload_File_Name['files']['name'][$i];
			$attachedDate = date("Y-m-d H:i:s");
				
			$insertMediaGallery  = array(	          
					'galPath'=>$galPath,
					'galTitle' => $this->input->post('galTitle'),
					'galAltText' => $this->input->post('galAltText'),
					'attachedDate'=>$attachedDate,				
			);			

			$this->db->insert($this->postMediaTable, $insertMediaGallery); 	
		}

		return true;
	}	
	
	
	/**
	* insertMediaGallery method Inserts a record in the MediaGallery table".
	*
	* Post: Values
	* --------------

	* @param int postGalleryId
	**/	
	function insertSingleMediaGallery($Upload_File_Name,$uploadCountFiles,$UserId)
	{		
		$galImageName = '';
	
		$galImageName = $Upload_File_Name;
		
		$attachedDate = date("Y-m-d H:i:s");
		
		if($this->input->post('galTitle')=='')
			$galTitle = $galImageName;		
		else 
			$galTitle =$this->input->post('galTitle');
			
		if($this->input->post('galAltText')=='')
			$galAltText = $galImageName;
		else 
			$galAltText = $this->input->post('galAltText');
			
		$insertMediaGallery  = array(	          
		'galPath'=>$galImageName,
		'galTitle' => $galTitle,
		'galAltText' => $galAltText,
		'attachedDate'=>$attachedDate,	
		'userId'=>$UserId	
	    );			
	
 	$this->db->insert($this->postMediaTable, $insertMediaGallery); 
 		
	return true;
	}	
	
	/**
		* updateMediaGallery method Inserts a record in the " post MediaGallery" table.
		*
		* Post: Values
		* --------------
		* @param int postGalleryId
	**/
	
	function updateMediaGallery()
	{	
	
		$attachedDate = date("Y-m-d H:i:s");
		$galDateModified = date("Y-m-d H:i:s");	
		$postGalleryId = $this->input->post('postGalleryId');	
		$galTitle = $this->input->post('galTitle');	
		$galAltText = $this->input->post('galAltText');
			
		$updateMediaGallery  = array(	         
			'galTitle' => $galTitle,
			'galAltText' => $galAltText,
			'attachedDate'=>$attachedDate,	
			'galDateModified'=>$galDateModified,			
	 ); 				  
	
		$field = 'postGalleryId';
		$this->db->where($field,$postGalleryId);
		$this->db->update($this->postMediaTable,$updateMediaGallery);
		return $postGalleryId;		
		
	}
	
	/**
		* loadGalleryImages method to load all gallery images in view to get inserted for post editor.
		*
		* --------------
		* @param nuul
		* @return  array
	**/	
	function loadGalleryImages($UserId)
	{
		
		$field = 'userId';
		
		$this->db->select('postGalleryId,galPath');
		
		$this->db->where($field,$UserId);
		
		$this->db->order_by('galDateModified', 'desc'); 
		
		$data['galleryQuery'] = $this->db->get($this->postMediaTable);
		 
		$data['galleryImgResults'] = $data['galleryQuery']->result(); 
			
		return $data['galleryImgResults'];	
		
	}//End loadGalleryImages method
	
	/**
		* This metohd list all the user for GeneralShowcase Table with firstName and Last name to get display 
		* to share posts to the desired user(who craved project of logged in user)
		
		* --------------
		* @param nuul
		* @return  array
	**/
	function userToShowCraved($UserId)
	{	
		$field = 'uId';
		
		$this->db->select('uId,firstName,lastName,profileImagePath');
		
		$this->db->where( 'uId != ',$UserId);
		
		$data['userQuery'] = $this->db->get('GeneralShowcase'); 
		
		$data['userQueryResults'] = $data['userQuery']->result();
		 	
		return $data['userQueryResults'];	
		
	}//End userToShare method

	/**
		* Save the selected user in Share table for the realted posts
	**/
	function saveShareToUser($userToSave)
	{
		$postId =  decode($this->input->post('postId'));
		
		$userData['elementId'] = $postId ;
		
		$userData['projType'] =  $this->projType; //Here projType is Blog
		
		$userData['fromUid'] = $this->UserId;
		
		$userData['shareDate'] = date("Y-m-d H:i:s");	
		
		$userData['createDate'] = date("Y-m-d H:i:s");
		
		foreach($userToSave['userInfo'] as $userIds)
		{
			$userData['toUid'] = $userIds;
			
			$this->db->insert($this->share, $userData); 	
		}
		
	}//End saveShareToUser method
	
	
	function deleteGalleryId($galIds)
	{
		
		$galleryFolderPath = MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/';
		
		$galleryThumbsFolderPath = MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/'.$this->gallery_thumb_version_folder.'/';
		
		$table = $this->db->dbprefix($this->postMediaTable);	
		
		//Select the galery to get deleted	
		$selectQuery ='select "galPath" from "'.$table.'" where "postGalleryId" in('.$galIds.')';
		
		$data['galleryImageNames'] = $this->db->query($selectQuery)->result(); 
		
		
		foreach($data['galleryImageNames'] as $galleryImageNames) {
		
			$imageOrgName = $galleryImageNames->galPath;
			
			// Use strrpos() & substr() to get the file extension
			$ext = substr($imageOrgName, strrpos($imageOrgName, "."));
			
			// Then stitch it together with the new string and file's basename
			$orgImageName = basename($imageOrgName, $ext) . $this->gallery_allowed_upload_img_orignal_suffix . $ext;
			
			$bigImageName = basename($imageOrgName, $ext) . $this->gallery_allowed_upload_img_big_suffix . $ext;
			
			$mediumImageName = basename($imageOrgName, $ext) . $this->gallery_allowed_upload_img_medium_suffix . $ext;
			
			$smallImageName = basename($imageOrgName, $ext) . $this->gallery_allowed_upload_img_small_suffix . $ext;
			
			$extraSmallImageName = basename($imageOrgName, $ext) . $this->gallery_allowed_upload_img_extra_small_suffix . $ext;
			//$this->delete_files($galleryFolderPath.$orgImageName);
			if(file_exists($galleryFolderPath.$imageOrgName)) unlink($galleryFolderPath.$imageOrgName);
			if(file_exists($galleryThumbsFolderPath.$orgImageName)) unlink($galleryThumbsFolderPath.$orgImageName);
			if(file_exists($galleryThumbsFolderPath.$bigImageName)) unlink($galleryThumbsFolderPath.$bigImageName);
			if(file_exists($galleryThumbsFolderPath.$mediumImageName)) unlink($galleryThumbsFolderPath.$mediumImageName);
			if(file_exists($galleryThumbsFolderPath.$smallImageName)) unlink($galleryThumbsFolderPath.$smallImageName);
			if(file_exists($galleryThumbsFolderPath.$extraSmallImageName)) unlink($galleryThumbsFolderPath.$extraSmallImageName);
		
		}  
		
		$delQuery ='delete from "'.$table.'" where "postGalleryId" in('.$galIds.')';
		$this->db->query($delQuery);	
			 
	}
}
?>
