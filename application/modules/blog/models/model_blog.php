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
	
	private $MasterLang = 'MasterLang';
	private $MasterCountry = 'MasterCountry';
	private $UserProfile	= 'UserProfile';
	private $UserShowcase	= 'UserShowcase';
	private $MasterIndustry	= 'MasterIndustry';
	private $tableUserContainer	= 'UserContainer';
	private $tableMembershipCart	 = 'MembershipCart';
	private $tableMembershipCartItem = 'MembershipCartItem';
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
		$this->userId = isLoginUser();
	}

	/**	
	 * Fetchs the blog ID only of logged in User 
	 * @access	public
	 * @param	userId
	 * @return	array	
	**/	
	
	function getBlogId($userId=0)
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
		 $this->db->select('blogId,blogTitle,blogOneLineDesc,blogTagWords,blogDesc,blogIndustry,blogLanguage,dateCreated,blogToFacebook,blogToTwitter,blogTwitterLink,blogToShareOn,blogToDonate,blogFor,blogCraveCount,isProfileCoverImage,custId,blogViewCount,'.$this->tableName.'.isPublished,dateModified,filePath,fileName,rating');
		 $this->db->select($this->tableName.'.fileId');
		 $this->db->select($this->tableUserContainer.'.*');
		 $this->db->from($this->tableName);
		 $this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->tableName.'.fileId', 'left');
		 $this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->tableName.".userContainerId", 'left');
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
	
	function getPostsCategory($blogId=0,$userId=0,$isArchive='f')
	{		 
		if($isArchive !== 't'){$isArchive='f';}
		 //QUERY WITH POSTS JOIN TO SHOW COUNT AS WELL WITH CATEGORIES
		 $postTable=$this->db->dbprefix($this->postTable);
		 $this->db->select('categoryId,categoryTitle,COUNT( "TDS_Posts"."postId" ) as postCount');		 
		 $this->db->from($this->blogCatName);
		 
		 if($userId>0)
			$this->db->where($this->blogCatName.'.uId',$userId);
		 else
			$this->db->where($this->blogCatName.'.uId',$this->userId);
		 
		 $this->db->join($this->postTable,$this->postTable.'.blogCategoryId='.$this->blogCatName.'.categoryId  AND "'.$postTable.'"."blogId"='.$blogId.' AND "'.$postTable.'"."postArchived"=\''.$isArchive.'\'','LEFT');		 
		 
		// $this->db->having("postArchived",$isArchive);
		 $this->db->group_by("categoryId,categoryTitle");		
		 $this->db->order_by("categoryTitle", "asc"); //TO SHOW ALPHABETIC ORDER		
		 $query = $this->db->get();
		// echo $this->db->last_query();
		 return $query->result(); 
	}
	
	function saveBlogCategory($catArray,$userId){
		
		//Get the blog Id to get inserted in category table
		$blogIdArray = $this->getBlogId($userId);	
	
		//Check if no blog is posted for logged-in user
		if(!isset($blogIdArray[0]->blogId) && count($$blogIdArray[0]->blogId)<=0)
		{
			 $blogId = 0;
			 //if(!isset($blogMessage) && $blogMessage=='')
				//$blogMessage = 'Please fill the blog setting first preview post';
			//set_global_messages($blogMessage, 'error');
			 redirect('blog');
		}
		else
		{			
			$blogId = $blogIdArray[0]->blogId;
		}
		//echo '<pre />Blog Cat Save:';print_r($catArray);die;
		//Intialized to distingush the records to insert and update
		
		/* $updatecatArray = $catArray['categoryTitleEdit']; */
		if(is_array($catArray))
		{
			if(isset($catArray['categoryTitle']) && $catArray['categoryTitle']!='')
			{
				if($catArray['categoryId'] ==0) {
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
		
		$delblogCategoryIds = $this->input->post('delCatId');
		
		if(isset($delblogCategoryIds) && $delblogCategoryIds!='')
		{
			if(!is_array($delblogCategoryIds)) 
			{
				$delblogCategoryIds = explode(',',$delblogCategoryIds);
			}
			
			$this->db->where_in('categoryId',$delblogCategoryIds);
			$this->db->delete($this->blogCatName);
			//echo $this->db->last_query();die;
		}
	if(isset($lastInsertId))
	return $lastInsertId;
	}
	
	function getCatExistsInPost($userId)
	{
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
		unset($blogRecord['fileInput']);
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
		
		$blogId = $this->db->insert_id();
		} 
		else 
		{			
			//A record does exist, update it.
			$blogRecord['dateModified'] = date("Y-m-d H:i:s");
			
			unset($blogRecord['fileInput']);	
			unset($blogRecord['custId']);
			
			$this->db->where('blogId',$blogRecord['blogId']);
			$blogId = $blogRecord['blogId'];
			$query = $this->db->update($this->tableName,$blogRecord);
		} 
		
		return $blogId;
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
		$this->db->where('isPublished','t');		
		$this->db->where('postArchived','f');		
		
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
	
		$this->db->select('postId,postTitle,blogCategoryId');
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
	function getCatPosts($catId,$blogId,$userId,$isArchive='f',$offSet=0,$limit=0){
	
	//To show all posts on click on category and Archive scetion's labels
		if($isArchive !== 't'){$isArchive='f';}	
		$this->db->select('postId,blogId,postTitle,postDesc,dateCreated,blogCategoryId,postTagWords,postOneLineDesc,custId,postCraveCount,postViewCount,postPostCount,dateModified,isPublished,postFileId,filePath,fileName,postArchived,'.$this->postTable.'.isBlocked');
		$this->db->from($this->postTable);
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		
		if($catId ==0)
			$this->db->where('blogId', $blogId);
		else
			$this->db->where('blogCategoryId', $catId);
					
		//$this->db->where('isPublished','t');		
		
		$this->db->where('postArchived',$isArchive);		
		
		$orderByPosts= '"dateCreated" desc';
		$this->db->order_by($orderByPosts); 
		if($limit > 0 || $offSet > 0){
			$this->db->limit($limit,$offSet);
		}
		$data['postQuery'] = $this->db->get(); 
		//echo $this->db->last_query();
		$data['postResults'] = $data['postQuery']->result(); 
	
		//return $data;	
		return $data['postQuery']->result();
		
	}
	
	function getFrontPost($postId=0){
		$this->db->select($this->postTable.'.*,'.$this->tableName.'.blogIndustry,'.$this->tableName.'.blogId ,'.$this->MediaFile.'.filePath,'.$this->MediaFile.'.fileName,'.$this->postTable.'.isBlocked ');
		$this->db->join($this->tableName,$this->tableName.'.blogId = '.$this->postTable.'.blogId', 'left');
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		$this->db->where('postId',$postId);
		$query = $this->db->get($this->postTable); 
		//$data['postResults'] = $query->result(); 
		//echo 'Last Query:'.$this->db->last_query();die;
		return $query->result();
	}
	/**
	  * Displays all the posts related with the blog
	  * @access	public
	  * @param	blogId
	  * @return	object
	**/
	function getPosts($blogId,$sortPostBy="dateCreated",$limitPosts=0,$postId=0,$userId=0,$isArchive,$offset=0,$limit=0,$catId=0)
	{
		if($isArchive !== 't'){$isArchive='f';}
		$this->db->select('postId,blogId,postTitle,postDesc,dateCreated,blogCategoryId,postTagWords,postOneLineDesc,custId,postCraveCount,postViewCount,postPostCount,dateModified,isPublished,postFileId,isUserProfileImage,filePath,fileName,isExternal,postArchived,'.$this->postTable.'.isBlocked');
		$this->db->from($this->postTable);
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		
		$sortArray = array('dateModified');// valid values for the <select> field
		
		if($blogId > 0)
			$this->db->where('blogId', $blogId);
		
		if($postId > 0)
			$this->db->where('postId', $postId);
		
		if($catId > 0)
			$this->db->where('blogCategoryId', $catId);
		
		if($blogId > 0)
			$this->db->where('blogId', $blogId);
			
		if(strcmp($sortPostBy,'publish') ==0) $orderByPosts = '"isPublished" \=\'f\',"dateModified" desc';
		
		if(strcmp($sortPostBy,'unpublish') ==0) $orderByPosts = '"isPublished" \=\'t\',"dateModified" desc';	
		
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
		
		$this->db->where("postArchived",$isArchive);
		
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
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		} 
		$result = $this->db->get(); 		
		return $result->result(); 
	}
	
	/**
		* Here fetches the posts according to month and year passed to function
		* @access public
		* @params archiveMonth
		* @params archiveYear
			
		* return array
	**/
	function previewArchivesPost($archiveMonth,$archiveYear,$blogId, $isArchive='f',$offset=0,$limit=0,$returnCount=false)
	{	
		$table = $this->db->dbprefix('Posts');
		
		$query = 'SELECT * FROM "'.$table.'" LEFT JOIN "TDS_MediaFile" ON "TDS_MediaFile"."fileId" = "TDS_Posts"."postFileId"
		WHERE date_part(\'YEAR\',"public"."TDS_Posts"."dateCreated")  =\''.$archiveYear.'\'';
		if(isset($archiveMonth) && $archiveMonth!=0) 
		$query .= ' AND date_part(\'Month\',"public"."TDS_Posts"."dateCreated")  =\''.$archiveMonth.'\'';		
		$query .= ' AND "public"."TDS_Posts"."blogId" = '.$blogId;
		
		$postArchived = $isArchive;		
		$isPublished= 't';
		
		$query .=' AND "TDS_Posts"."postArchived" = \''.$postArchived.'\'';
		//$query .=' AND "TDS_Posts"."isPublished" = \''.$isPublished.'\'';
		$query .=' order by "TDS_Posts"."dateCreated" desc';
		
		if($offset > 0 || $limit > 0){
			$limit=' LIMIT '.$limit.' OFFSET '.$offset.' ';
		}else{
			$limit='';
		}
		$query .=$limit;
		//echo $query;
		$archivePostDetailResults['postQuery'] = $this->db->query($query);				
		$archivePostDetailResults['postResults'] = $archivePostDetailResults['postQuery']->result(); 
		
		if($returnCount){
			return $archivePostDetailResults['postQuery']->num_rows(); 
		}else{
			return $archivePostDetailResults['postQuery']->result(); 
		}
		//return $archivePostDetailResults;
		
	}
	
	/**
	  * Displays all the posts related with the Parent Post
	  * @access	public
	  * @param	blogId
	  * @return	object
	**/
	function getChildPosts($parentPostId=0)
	{	
		$this->db->select('postId,parentPostId,blogId,postTitle,postDesc,dateCreated,blogCategoryId,postTagWords,postOneLineDesc,custId,postCraveCount,postViewCount,postPostCount,dateModified,isPublished,postFileId,filePath,fileName,postArchived,'.$this->postTable.'.isBlocked');
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
	
	function postForm($blogId=0,$postId=0)
	{
		$this->db->select($this->postTable.'.*');
		$this->db->select($this->MediaFile.'.*');
		$this->db->select($this->tableUserContainer.'.*');
		$this->db->from($this->postTable);	
		$this->db->join($this->tableName,$this->tableName.'.blogId = '.$this->postTable.'.blogId', 'left');
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->tableName.".userContainerId", 'left');
				

		$this->db->where($this->postTable.'.blogId',$blogId);
		$this->db->where('postId',$postId);
		
		$postResult = $this->db->get();
		
		$postData  = $postResult->result_array();
		
		return $postData;			
	}
	
	/**
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
		* Insert/Update a new row into post table from the common function
		* @access	public
		* @params $blogId
		* @params $postId		
		* return array
	**/	
	function savePost($postFileId)
	{	
		$custId =$this->input->post('custId');
		if(isset($custId) && $custId!='') $custId = $custId;
		else $custId = 0;
		$postData = array(
			 	'blogId'=>$this->input->post('blogId'),				
				'custId'=>$custId,
				'postTitle'=>$this->input->post('postTitle'),
				'postDesc'=>$this->input->post('postDesc'),
				'postCraveCount'=>$this->input->post('postCraveCount'),
				'isPublished'=>'t',
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
		
		$table = $this->db->dbprefix($this->postTable);
				
		$updatePost['isPublished'] = "FALSE";
		
		$togglePublishUpdateQuery ='update "'.$table.'" SET "dateModified"=\''.date("Y-m-d H:i:s").'\',"isPublished" =( CASE
							 WHEN ("isPublished" =  true) THEN false ELSE true END ) WHERE "'.$field.'" ='.$postId;
				
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
				WHEN ("postArchived" =  true) THEN false ELSE true END ),"isPublished" =( CASE
				WHEN ("isPublished" =  true) THEN false ELSE true END ) WHERE "'.$field.'" ='.$postId;
								
		$this->db->query($toggleArchiveUpdateQuery);
		
	}
	
	/**
		* Function to Get all records of the post table with adre archived/deleted i.e.,archived=false
		* @access	public
		* @params $blogId					
		* return array
	**/
	function showArchives($blogId)
	{			
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
	
		$this->db->select('postId,postTitle,postDesc,postTagWords,dateCreated,blogId,postFileId,filePath,fileName,postArchived,'.$this->postTable.'.isBlocked');
		
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
	function fetchArchivesYears($blogId,$userId=0,$isArchive='f')
	{		
		if($isArchive !== 't'){$isArchive='f';}
		$table=$this->db->dbprefix('Posts');
		$whereClause='';
		$query = 'SELECT date_part(\'YEAR\',"dateCreated") as YearExtracted from "'.$table.'" ';
		if($blogId>0) {
			if($whereClause=='')
				$whereClause .='where "blogId" = \''.$blogId.'\'';
		}
		
		if($userId>0) {
			if($whereClause=='')
				$whereClause .=' where "custId" =\''.$userId.'\'';
			else
				$whereClause .=' AND "custId" =\''.$userId.'\'';
			
		}
		
		if($whereClause=='')
				$whereClause .=' where "postArchived" =\''.$isArchive.'\'';
			else
				$whereClause .=' AND "postArchived" =\''.$isArchive.'\'';
		$query .= $whereClause;
		
		$query .=' group by YearExtracted order by YearExtracted desc';	
		
		$data['archiveYearQuery'] = $this->db->query($query);
		//echo '<pre />';print_r($data['archiveYearQuery']);
		//echo 'Last Archive Query:'.$this->db->last_query();	
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
			WHERE ';	
		
		
		if(isset($year) && !empty($year)) {	
		
		$query .= 'date_part(\'YEAR\',"public"."TDS_Posts"."dateCreated")  = \''.$year.'\' ';
		}
		$postArchived = 'f';	
		$isPublished = 't';
		
		$CurentBlogId= $this->model_blog->getBlogId($this->userId);  
		
		//Check if no blog is posted for logged-in user
		if(count($CurentBlogId)<=0) $blogId = 0;
		else $blogId = $CurentBlogId[0]->blogId;
		if(isset($year) && !empty($year)) {	
		$query .=' AND "TDS_Posts"."postArchived" = \''.$postArchived.'\'';
		} else {
		$query .='"TDS_Posts"."postArchived" = \''.$postArchived.'\'';
		}
		$query .=' AND "TDS_Posts"."isPublished" = \''.$isPublished.'\'';
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
		
		$field = 'mediaId';
		
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
		$this->db->select('mediaId,filePath,fileName,mediaTitle');
		$this->db->join('MediaFile','MediaFile.fileId = '.$this->postMediaTable.'.fileId', 'left');
		$this->db->where($this->postMediaTable.'.userId', $UserId);
		
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
	
	
	
	function getPostDetails($postId=0)
	{
		if($postId > 0){
			 $tableBlogs = $this->db->dbprefix($this->tableName);
			 $this->db->select($this->postTable.'.*');
			 $this->db->select($this->tableName.'.blogLanguage, '.$this->tableName.'.blogIndustry');
			 $this->db->select($this->MediaFile.'.fileId,'.$this->MediaFile.'.filePath,'.$this->MediaFile.'.fileName');
			 $this->db->select($this->UserShowcase.'.optionAreaName,'.$this->UserShowcase.'.enterprise,'.$this->UserShowcase.'.enterpriseName');
			 $this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName,'.$this->UserProfile.'.countryId');
			 $this->db->select($this->MasterLang.'.Language_local');
			 $this->db->select($this->MasterCountry.'.countryName');
			 $this->db->select($this->MasterIndustry.'.IndustryName');
			
			 $this->db->from($this->postTable);
			
			 $this->db->join($this->tableName,$this->tableName.'.blogId = '.$this->postTable.'.blogId', 'left');
			 $this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
			 
			 $this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->postTable.".custId", 'left');
			 $this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->postTable.".custId", 'left');
			 $this->db->join($this->MasterLang, $this->MasterLang.'.langId = CAST("'.$tableBlogs.'"."blogLanguage" as int)', 'left');
			 $this->db->join($this->MasterCountry, $this->MasterCountry.'.countryId = '.$this->UserProfile.'.countryId', 'left');
			 $this->db->join($this->MasterIndustry, $this->MasterIndustry.'.IndustryId = CAST("'.$tableBlogs.'"."blogIndustry" as int)', 'left');
			
			 $this->db->where($this->postTable.'.postId',$postId);
			 $query = $this->db->limit(1);
			 $query = $this->db->get();
			 return $query->result_array();  	 
		 }else{
			 return false;
		}
	}
	function getBlogDetails($blogId=0)
	{
		if($blogId > 0){
			 $tableBlogs = $this->db->dbprefix($this->tableName);
			 $this->db->select($this->tableName.'.*');
			 $this->db->select($this->UserShowcase.'.optionAreaName,'.$this->UserShowcase.'.enterprise,'.$this->UserShowcase.'.enterpriseName');
			 $this->db->select($this->MediaFile.'.fileId,'.$this->MediaFile.'.filePath,'.$this->MediaFile.'.fileName');
			 $this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName,'.$this->UserProfile.'.countryId');
			 $this->db->select($this->MasterLang.'.Language_local');
			 $this->db->select($this->MasterCountry.'.countryName');
			 $this->db->select($this->MasterIndustry.'.IndustryName');
			
			 $this->db->from($this->tableName);
			 $this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->tableName.'.fileId', 'left');
			 $this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->tableName.".custId", 'left');
			 $this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableName.".custId", 'left');
			 $this->db->join($this->MasterLang, $this->MasterLang.'.langId = CAST("'.$tableBlogs.'"."blogLanguage" as int)', 'left');
			 $this->db->join($this->MasterCountry, $this->MasterCountry.'.countryId = '.$this->UserProfile.'.countryId', 'left');
			 $this->db->join($this->MasterIndustry, $this->MasterIndustry.'.IndustryId = CAST("'.$tableBlogs.'"."blogIndustry" as int)', 'left');
			 $this->db->where($this->tableName.'.blogId',$blogId);
			 $query = $this->db->limit(1);
			 $query = $this->db->get();
			 return $query->result_array();  	 
		 }else{
			 return false;
		}
	}
	
	/*
	 * Get Post Data Result
	 */
	function getPostData($userId=0,$postId=0)
	{
		$tableBlogs = $this->db->dbprefix($this->tableName);
		$this->db->select($this->postTable.'.*');
		$this->db->select($this->tableName.'.blogLanguage, '.$this->tableName.'.blogIndustry');
		$this->db->select($this->MediaFile.'.fileId,'.$this->MediaFile.'.filePath,'.$this->MediaFile.'.fileName');
		$this->db->select($this->UserShowcase.'.optionAreaName');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName,'.$this->UserProfile.'.countryId');
		$this->db->select($this->MasterLang.'.Language_local');
		$this->db->select($this->MasterCountry.'.countryName');
		$this->db->select($this->MasterIndustry.'.IndustryName');

		$this->db->from($this->postTable);

		$this->db->join($this->tableName,$this->tableName.'.blogId = '.$this->postTable.'.blogId', 'left');
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');

		$this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->postTable.".custId", 'left');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->postTable.".custId", 'left');
		$this->db->join($this->MasterLang, $this->MasterLang.'.langId = CAST("'.$tableBlogs.'"."blogLanguage" as int)', 'left');
		$this->db->join($this->MasterCountry, $this->MasterCountry.'.countryId = '.$this->UserProfile.'.countryId', 'left');
		$this->db->join($this->MasterIndustry, $this->MasterIndustry.'.IndustryId = CAST("'.$tableBlogs.'"."blogIndustry" as int)', 'left');

		if($postId>0)
			$this->db->where($this->postTable.'.postId',$postId);
		if($userId>0)
			$this->db->where($this->postTable.'.custId',$userId);
		
		$query = $this->db->get();
		return $query->result_array();  	 
	}
	
	/*
	 * Get Blog Data Result
	 */
	function getBlogData($userId=0,$blogId=0)
	{
		$tableBlogs = $this->db->dbprefix($this->tableName);
		$this->db->select($this->tableName.'.*');
		$this->db->select($this->UserShowcase.'.optionAreaName');
		$this->db->select($this->MediaFile.'.fileId,'.$this->MediaFile.'.filePath,'.$this->MediaFile.'.fileName');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName,'.$this->UserProfile.'.countryId');
		$this->db->select($this->MasterLang.'.Language_local');
		$this->db->select($this->MasterCountry.'.countryName');
		$this->db->select($this->MasterIndustry.'.IndustryName');

		$this->db->from($this->tableName);
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->tableName.'.fileId', 'left');
		$this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->tableName.".custId", 'left');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableName.".custId", 'left');
		$this->db->join($this->MasterLang, $this->MasterLang.'.langId = CAST("'.$tableBlogs.'"."blogLanguage" as int)', 'left');
		$this->db->join($this->MasterCountry, $this->MasterCountry.'.countryId = '.$this->UserProfile.'.countryId', 'left');
		$this->db->join($this->MasterIndustry, $this->MasterIndustry.'.IndustryId = CAST("'.$tableBlogs.'"."blogIndustry" as int)', 'left');
		if($blogId>0)
			$this->db->where($this->tableName.'.blogId',$blogId);
		if($userId>0)
			$this->db->where($this->tableName.'.custId',$userId);
		$query = $this->db->get();
		return $query->result_array();  	 
	}
	
	//----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to get current cart details
	 * @return array
	 */ 
	function getCurrentCartData($cartId) {	
		
		$this->db->select($this->tableMembershipCart.'.totalPrice,'.$this->tableMembershipCart.'.totalTaxAmt');
		$this->db->select($this->tableMembershipCartItem.'.price,'.$this->tableMembershipCartItem.'.size');	
		$this->db->from($this->tableMembershipCart);
		$this->db->join($this->tableMembershipCartItem,$this->tableMembershipCartItem.'.cartId = '.$this->tableMembershipCart.'.cartId');
		$this->db->where($this->tableMembershipCart.'.cartId',$cartId);	
		$this->db->where($this->tableMembershipCartItem.'.type','2');
		$this->db->order_by('cartItemId','asc');	
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->row();		
		return $result;
   }
   
   //----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to update cart billing data 
	 * @return array
	 */ 
	public function updateBillingData($billingData,$cartId) {
		$this->db->where('cartId', $cartId);		
		$this->db->update($this->tableMembershipCart, $billingData);
		return true;
	}

}
?>
