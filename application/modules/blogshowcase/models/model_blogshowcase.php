<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
/*
	 Description:
	 * The model_blogshowcase class is meant to handle the processing of the Blog section
	 * It include functionality to fetch/add/edit Blog content for logged in user 
	 * @package	Toadsquare
	 * @subpackage	Module
	 * @category	Controller
	 * Author Name: Gurutva Singh
	 * Date Created: 24 January 2012
	 * Date Modified: 9 Februray 2012 by Gurutva Singh	
*/
Class model_blogshowcase extends CI_Model {
	
	private $tableName = 'Blogs'; //Private Variable(Table Name) to get used at class level only
	private $postTable = 'Posts';
	private $postMediaTable = 'PostGallery';
	private $blogCatName = 'BlogCategory';
	private $MediaFile = 'MediaFile';
	private $tableLogSummary = 'LogSummary';	
	private $share = 'Share';
	//private $userId = NULL;
	private $projType = 'BLOG';
	
	/**
	 * Constructor
	 **/
	function __construct()
	{
		parent::__construct();
		// My own constructor code
		$this->config->load('image_config');
	
		//
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
	
	function getBlogDetail($userId=0)
	{			
		 $this->db->select('blogId,blogTwitterLink,blogToTwitter,blogToDonate');
		 $this->db->where('custId',$userId);
		 $this->db->from($this->tableName);
		 $query = $this->db->get();
		 $result = $query->result_array();
		 
		 if(!empty($result)){
			return 	$result[0];
		 }
		 else{
			return FALSE;
		} 	 
	}

	/*	
	 * Fetchs the blog data on the basis of logged in User 
	 * @access	public
	 * @param	userId
	 * @return	array	
	*/	
	
	function getUserBlog($userId,$isPreview=0)
	{
		 $this->db->select('blogId,custId,blogTitle,blogOneLineDesc,blogDesc,blogTagWords,blogIndustry,blogLanguage,dateCreated,blogToFacebook,blogToTwitter,blogToShareOn,blogToDonate,blogFor,blogCraveCount,isProfileCoverImage,blogViewCount,'.$this->tableName.'.isPublished,dateModified,filePath,fileName,blogTwitterLink,rating');
		 $this->db->select($this->tableName.'.fileId');
		 $this->db->from($this->tableName);
		 $this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->tableName.'.fileId', 'left');
		 $this->db->where('custId',$userId);
		 $this->db->where('isArchive','f');
		if(!isset($isPreview) && $isPreview!=1){
			$this->db->where($this->tableName.'.isPublished','t');
		}
		 $query = $this->db->get();
		 return $query->result();  	 
	}
	
	
	function getBlogCategory($userId=0)
	{		
		 $this->db->select('*');
		 $this->db->from($this->blogCatName);
		 $this->db->where('uId',$userId);
		 $this->db->limit(10);
		 $this->db->order_by("categoryTitle", "asc"); //TO SHOW ALPHABETIC ORDER
		 $query = $this->db->get();
		 
		 return $query->result();		 
	}
	
	function getPostsCategory($userId=0,$blogId=0)
	{			 
		 //QUERY WITH POSTS JOIN TO SHOW COUNT AS WELL WITH CATEGORIES
		 
		 $this->db->select('categoryId,categoryTitle,COUNT( "TDS_Posts"."postId" ) as postCount');
		 
		 $this->db->from($this->blogCatName);
				 
		 $this->db->join($this->postTable,$this->postTable.'.blogCategoryId='.$this->blogCatName.'.categoryId','LEFT');
		 
		 if($userId>0)
			$this->db->where($this->blogCatName.'.uId',$userId);
			$this->db->where($this->postTable.'.custId',$userId);
		
		$this->db->where($this->postTable.'.postArchived','f');		
		$this->db->where($this->postTable.'.isPublished','t');							 
		$this->db->group_by("categoryId,categoryTitle"); 		
		$this->db->order_by("categoryTitle", "asc"); //TO SHOW ALPHABETIC ORDER		
		$query = $this->db->get();
		 
		 //echo '<pre />';print_r($query->result());
		 //echo $this->db->last_query();
		 
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
		
		/*$updatecatArray = $catArray['categoryTitleEdit'];	*/
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
	function getParentPost($postId)
	{	
		$table=$this->db->dbprefix($this->postTable);			
		$entityId=getMasterTableRecord($table);
	
		$this->db->select('postId,'.$this->postTable.'.blogId,postTitle,'.$this->postTable.'.dateCreated,blogCategoryId,postOneLineDesc,'.$this->postTable.'.custId,categoryId,categoryTitle,blogCategoryId,'.$this->postTable.'.dateModified,'.$this->postTable.'.isPublished,postFileId,filePath,fileName,'.$this->tableName.'.blogIndustry,'.$this->tableName.'.blogToTwitter,'.$this->tableName.'.blogTwitterLink,'.$this->tableName.'.blogToDonate');
		$this->db->select($this->tableLogSummary.'.entityId,elementId,craveCount,viewCount');
		$this->db->from($this->postTable);
		$this->db->join($this->tableName,$this->tableName.'.blogId = '.$this->postTable.'.blogId', 'left');
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.".elementId = ".$this->postTable.".postId", 'left');
		$this->db->join($this->blogCatName,$this->postTable.'.blogCategoryId = '.$this->blogCatName.'.categoryId', 'left');
		
		if($postId > 0)
			$this->db->where('postId', $postId);
	
		
		$this->db->where($this->tableLogSummary.'.entityId',$entityId);
			
		$postQuery = $this->db->get(); 
		$data = $postQuery->result(); 
	
		return $data;			
	}
	
	
	
	function getFrontPost($postId=0,$userId,$checkPublished=true)
	{
		$this->db->select($this->postTable.'.postId,'.$this->postTable.'.blogId,'.$this->postTable.'.postTitle,'.$this->postTable.'.parentPostId,'.$this->postTable.'.postDesc,'.$this->postTable.'.dateCreated,'.$this->postTable.'.blogCategoryId,'.$this->postTable.'.postTagWords,'.$this->postTable.'.postOneLineDesc,'.$this->postTable.'.custId,'.$this->postTable.'.blogCategoryId,'.$this->postTable.'.dateModified,'.$this->postTable.'.isPublished,'.$this->postTable.'.postFileId,'.$this->blogCatName.'.categoryId,'.$this->blogCatName.'.categoryTitle,'.$this->tableName.'.blogIndustry,'.$this->tableName.'.rating,'.$this->tableName.'.blogLanguage,'.$this->tableName.'.blogToDonate,'.$this->tableName.'.blogToTwitter,'.$this->tableName.'.blogTwitterLink,'.$this->tableName.'.blogId ,'.$this->MediaFile.'.filePath,'.$this->MediaFile.'.fileName,'.$this->postTable.'.isUserProfileImage');
		$this->db->select('parentpost.postId as parentpostid,parentpost.postTitle as parentposttitle,parentpost.custId as parentcustid,parentpost.blogId as parentblogid');
		
		$this->db->join($this->tableName,$this->tableName.'.blogId = '.$this->postTable.'.blogId', 'left');
		$this->db->join($this->postTable." parentpost","parentpost.postId = ".$this->postTable.".parentPostId", 'left');//self join for parent detail for child posts
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		$this->db->join($this->blogCatName,$this->postTable.'.blogCategoryId = '.$this->blogCatName.'.categoryId', 'left');
		$this->db->where($this->postTable.'.postId',$postId);
		if($checkPublished==true){
			$this->db->where($this->postTable.'.isPublished','t');
		}
		
		if($userId>0) $this->db->where($this->postTable.'.custId',$userId);
		
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
	function getPosts($blogId,$sortPostBy="dateCreated",$limitPosts=0,$postId=0,$userId=0,$offset=0,$limit=0)
	{
		$table=$this->db->dbprefix($this->postTable);			
		$entityId=getMasterTableRecord($table);
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
	//	$this->db->select('postId,'.$this->postTable.'.blogId,postTitle,postDesc,dateCreated,blogCategoryId,postTagWords,postOneLineDesc,custId,postCraveCount,postViewCount,postPostCount,dateModified,isPublished,postFileId,filePath,fileName');
		$this->db->select('postId,'.$this->postTable.'.blogId,postTitle,postDesc,'.$this->postTable.'.dateCreated,blogCategoryId,postTagWords,postOneLineDesc,'.$this->postTable.'.custId,categoryId,isUserProfileImage,categoryTitle,blogCategoryId,'.$this->postTable.'.dateModified,'.$this->postTable.'.isPublished,postFileId,filePath,fileName,'.$this->tableName.'.blogIndustry,'.$this->tableName.'.blogToTwitter,'.$this->tableName.'.blogTwitterLink,'.$this->tableName.'.blogToDonate');
		$this->db->select($this->tableLogSummary.'.entityId,elementId,craveCount,viewCount');
		$this->db->from($this->postTable);
		$this->db->join($this->tableName,$this->tableName.'.blogId = '.$this->postTable.'.blogId', 'left');
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->postTable.'.postId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
		$this->db->join($this->blogCatName,$this->postTable.'.blogCategoryId = '.$this->blogCatName.'.categoryId', 'left');
		$sortArray = array('dateModified');// valid values for the <select> field
		
		if($blogId > 0)
			$this->db->where($this->postTable.'.blogId', $blogId);
		
		if($postId > 0)
			$this->db->where('postId', $postId);
		
		if($userId > 0)
			$this->db->where($this->postTable.'.custId', $userId);
		
		if(strcmp($sortPostBy,'publish') ==0) $orderByPosts = '"isPublished" \=\'f\',"dateModified" desc';
		
		if(strcmp($sortPostBy,'unpublish') ==0) $orderByPosts = '"isPublished" \=\'t\',"dateModified" desc';	
		
		//Flag to show all the posts not associated with particular year
		
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
		
		$this->db->where('postArchived','f');
		$this->db->where($this->postTable.'.isPublished','t');
		
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
		
		if(!isset($orderByPosts) || @$orderByPosts=='' || @$orderByPosts==0) $orderByPosts= '"dateCreated" desc';
		$this->db->order_by($orderByPosts); 
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		} 
		
		$data['postQuery'] = $this->db->get(); 		
		
		$data['postResults'] = $data['postQuery']->result(); 
		
				
		//return $data;	
		return 	$data['postQuery']->result();	
	}
	/**
	  * Displays single the post related with the blog
	  * @access	public
	  * @param	postId
	  * @return	object
	**/
	function getCatPosts($userId=0,$catId=0,$blogId=0,$sortPostBy='',$offSet=0,$limit=0)
	{	
		//To show all posts on click on category and Archive scetion's labels
		$this->db->select('postId,'.$this->postTable.'.blogId,postTitle,postDesc,'.$this->postTable.'.dateCreated,blogCategoryId,postTagWords,isUserProfileImage,postOneLineDesc,'.$this->postTable.'.custId,postCraveCount,postViewCount,postPostCount,categoryId,categoryTitle,blogCategoryId,'.$this->postTable.'.dateModified,'.$this->postTable.'.isPublished,postFileId,filePath,fileName,'.$this->tableName.'.blogIndustry,'.$this->tableName.'.blogToTwitter,'.$this->tableName.'.blogTwitterLink,'.$this->tableName.'.blogToDonate');
		$this->db->from($this->postTable);
		$this->db->join($this->tableName,$this->tableName.'.blogId = '.$this->postTable.'.blogId', 'left');
		$this->db->join($this->blogCatName,$this->postTable.'.blogCategoryId = '.$this->blogCatName.'.categoryId', 'left');
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		
		if($catId ==0 && $blogId>0)	$this->db->where($this->postTable.'.blogId', $blogId);
		if($catId>0) $this->db->where('blogCategoryId', $catId);
			
		if($userId<=0) $userId = $this->userId;		
		$this->db->where($this->postTable.'.custId', $userId);						
		$this->db->where('postArchived','f');
		
		$this->db->where($this->postTable.'.isPublished','t');		
			
		$orderByPosts= $this->postTable.'.dateCreated" desc';
		
		$this->db->order_by($orderByPosts); 
		
		if($limit > 0 || $offSet > 0){
			$this->db->limit($limit,$offSet);
		}
		$query = $this->db->get(); 
		
		//$data['postResults'] = $query->result(); 
		//echo '<pre />';
		//print_r($data['postResults']);
		//echo $this->db->last_query();die;
		//return $data;	
		
		return $query->result(); 
		
	}
	/**
		* Here fetches the posts according to month and year passed to function
		* @access public
		* @params archiveMonth
		* @params archiveYear
			
		* return array
	**/
	function previewArchivesPost($archiveMonth,$archiveYear,$userId, $offset=0,$limit=0,$returnCount=false)
	{	
		$table = $this->db->dbprefix($this->postTable);
		$blogCatPostTable = $this->db->dbprefix($this->blogCatName);
		$query = 'SELECT *,"'.$blogCatPostTable.'"."categoryId","'.$blogCatPostTable.'"."categoryTitle" FROM "'.$table.'"
		LEFT JOIN "'.$blogCatPostTable.'" ON "'.$blogCatPostTable.'"."categoryId" = "'.$table.'"."blogCategoryId" 
		LEFT JOIN "TDS_MediaFile" ON "TDS_MediaFile"."fileId" = "TDS_Posts"."postFileId"
		WHERE date_part(\'YEAR\',"public"."TDS_Posts"."dateCreated")  =\''.$archiveYear.'\'';
		if(isset($archiveMonth) && $archiveMonth!=0) 
		$query .= ' AND date_part(\'Month\',"public"."TDS_Posts"."dateCreated")  =\''.$archiveMonth.'\'';
		if($userId>0)
		$query .= ' AND "public"."TDS_Posts"."custId" = '.$userId;
		
		$postArchived = 'f';
		
		$isPublished= 't';
		
		$query .=' AND "TDS_Posts"."postArchived" = \''.$postArchived.'\'';
	   $query .=' AND "TDS_Posts"."isPublished" = \''.$isPublished.'\'';
		$query .=' order by "TDS_Posts"."dateCreated" desc';
		
		if($offset > 0 || $limit > 0){
			$limit=' LIMIT '.$limit.' OFFSET '.$offset.' ';
		}else{
			$limit='';
		}
		$query .=$limit;
		
		$postQuery = $this->db->query($query); 
		//echo 'previewArchivesPost:'.$this->db->last_query();		
		//$archivePostDetailResults['postResults'] = $postQuery->result(); 
		
		//return $archivePostDetailResults;
		if($returnCount){
			return $postQuery->num_rows(); 
		}else{
			return $postQuery->result(); 
		}
	}
	
	/**
	  * Displays all the posts related with the Parent Post
	  * @access	public
	  * @param	blogId
	  * @return	object
	**/
	function getChildPosts($parentPostId=0)
	{
	
		$this->db->select('postId,parentPostId,'.$this->postTable.'.blogId,postTitle,postDesc,dateCreated,blogCategoryId,postTagWords,postOneLineDesc,custId,isUserProfileImage,dateModified,'.$this->postTable.'.isPublished,postFileId,filePath,fileName,categoryId,categoryTitle,blogCategoryId');
		$this->db->from($this->postTable);
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		$this->db->join($this->blogCatName,$this->postTable.'.blogCategoryId = '.$this->blogCatName.'.categoryId', 'left');
		
		if($parentPostId == 0)$parentPostId=-1;
		$this->db->where('parentPostId', $parentPostId);
		$this->db->where($this->postTable.'.isPublished','t');
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
				'custId'=>$this->input->post('custId'),
				'postTitle'=>$this->input->post('postTitle'),
				'postDesc'=>$this->input->post('postDesc'),
				'postCraveCount'=>$this->input->post('postCraveCount'),
				'isPublished'=>'t',
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
		$custId =$this->input->post('custId');
		if(isset($custId) && $custId!='') 
		$custId=$custId;
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
		
		$table=$this->db->dbprefix($this->postTable);
				
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
	function fetchArchivesYears($blogId,$userId=0)
	{		
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
				$whereClause .=' where "postArchived" =\'f\'';
			else
				$whereClause .=' AND "postArchived" =\'f\'';
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
	
	function showArchivesMonths($year,$userId=0)
	{
		$table = $this->db->dbprefix('Posts');
			
		$query = 'SELECT DISTINCT date_part(\'MONTH\',"public"."TDS_Posts"."dateCreated") AS month ,
		COUNT( "TDS_Posts"."postId" ) as postCount FROM "'.$table.'"
		WHERE date_part(\'YEAR\',"public"."TDS_Posts"."dateCreated")  = \''.$year.'\'  ';	
		
		$postArchived = 'f';
		
		$isPublished = 't';
		
		$CurentBlogId= $this->model_blogshowcase->getBlogId($userId);  
		
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
