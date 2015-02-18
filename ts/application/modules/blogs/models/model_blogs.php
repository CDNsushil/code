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
Class model_blogs extends CI_Model {
	
	private $tableName = 'Blogs'; //Private Variable(Table Name) to get used at class level only
	private $postTable = 'Posts';
	private $postMediaTable = 'PostGallery';
	private $blogCatName = 'BlogCategory';
	private $MediaFile = 'MediaFile';
	private $tableLogSummary = 'LogSummary';
	private $tableLogCrave	 = 'LogCrave';	
	private $share = 'Share';
	//private $userId = NULL;
	private $projType = 'BLOG';
	private $UserShowcase	= 'UserShowcase';
	private $UserAuth	= 'UserAuth';
	private $tableUserShowcase = 'UserShowcase';
	private $tableUserProfile = 'UserProfile';
	private $tableMasterIndustry = 'MasterIndustry';
	
	/**
	 * Constructor
	 **/
	function __construct()
	{
		parent::__construct();
		// My own constructor code
		$this->config->load('image_config');	
	}

	/**	
	 * Fetchs the blogs of all User 
	 * @access	public
	 * @param	userId
	 * @return	array	
	**/	
	public function fetchBlogPosts($userId=0){	
	$result = $this->getBlogs($userId);
		//echo $this->db->last_query(); die;
		if($result && (!empty($result) )){
				// Call getProjectElements function to get project element data
				foreach($result as $key=>$data){
					$result[$key]->elements=$this->getPosts($userId,$data->blogId);			
				}
		}
		return $result;
	}
	
	public function getBlog($userId=0,$blogId=0)
	{				
		$this->db->select('blogId,custId,blogTitle,blogOneLineDesc,blogTagWords,blogIndustry,blogLanguage,dateCreated,blogToFacebook,blogToTwitter,blogToShareOn,blogToDonate,blogFor,blogCraveCount,blogViewCount,isPublished,dateModified,filePath,fileName');
		$this->db->select($this->tableName.'.fileId');
		$this->db->from($this->tableName);
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->tableName.'.fileId', 'left');
		
		if(isset($userId) && ($userId >=0 && $userId !='')) $this->db->where('custId',$userId);				
		if($blogId > 0)	$this->db->where('blogId',$blogId);		
		
		$query = $this->db->get();				
		//echo $this->db->last_query();die;		
		return $query->result();  	 
	}
	
	/**
	  * Displays single the post related with the blog
	  * @access	public
	  * @param	postId
	  * @return	object
	**/
	function getMainPosts($userId=0,$blogId=0,$industryId=0,$catId=0, $limit=0, $offset=0){
		$table=$this->db->dbprefix($this->postTable);
			
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
		$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
		
		$entityId=getMasterTableRecord($this->postTable);
		
		$this->db->select($this->postTable.'.postId,'.$this->postTable.'.postTitle,'.$this->postTable.'.postOneLineDesc,'.$this->postTable.'.custId,'.$this->postTable.'.postFileId,'.$this->postTable.'.dateCreated,'.$this->postTable.'.dateModified');
		if($industryId>0 && $industryId!='')
			$this->db->select($this->tableName.'.blogIndustry');
		$this->db->select($this->MediaFile.'.filePath,'.$this->MediaFile.'.fileName');
		$this->db->select($this->tableLogSummary.'.entityId,'.$this->tableLogSummary.'.elementId,'.$this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.ratingAvg');
		$this->db->select('up.firstName, up.lastName');
		$this->db->select($this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.enterprise');
		
		$this->db->from($this->postTable);	
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->postTable.'.postId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = '.$this->postTable.'.custId','left');
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->postTable.".custId");
		
		$loggedUserId=isloginUser();
		if(is_numeric($loggedUserId) && $loggedUserId > 0){
			$this->db->select($this->tableLogCrave.'.craveId');
			$this->db->join($this->tableLogCrave, $this->tableLogCrave.'.elementId = '.$this->postTable.'.postId AND  "'.$tableLogCrave.'"."entityId"='.$entityId.' AND  "'.$tableLogCrave.'"."tdsUid"='.$loggedUserId.' ', 'left');
		}
		
		if($industryId>0 && $industryId!='') $this->db->join($this->tableName,$this->tableName.'.blogId = '.$this->postTable.'.blogId', 'left');	
		
		if($userId!=0 && $userId!='') $this->db->where('custId', $userId);		
		if($blogId!=0 && $blogId!='') $this->db->where('blogId', $blogId);		
		if($catId!=0 && $catId!='') $this->db->where('blogCategoryId', $catId);			
		if($industryId!=0 && $industryId!='') $this->db->where('blogIndustry', $industryId);
				
		$this->db->where($this->postTable.'.isPublished', 't');		
		$this->db->where('postArchived', 'f');	
		$this->db->order_by($this->postTable.'.dateModified','desc');	
		
		if(is_numeric($limit) && ($limit > 0)){
			$this->db->limit($limit,$offset);
		}
		
		$query = $this->db->get(); 	
		//echo $this->db->last_query();
		return $query->result();	
		
	}
    
    function countPost($where='',  $whereInField='', $whereInValue='', $whereNotIn=0,$craved=false){
		$res = 0;
        if(!empty($this->postTable)){
            if(is_array($where) && !empty($where)){
                    $this->db->where($where);
            }
            if(!empty($whereInField) && !empty($whereInValue) && is_array($whereInValue)){
                if($whereNotIn==1){
                    $this->db->where_not_in($whereInField,$whereInValue);
                }else{
                    $this->db->where_in($whereInField,$whereInValue);
                }
            }
            
            $this->db->from($this->postTable);
            $this->db->join($this->tableName, $this->tableName.'.blogId = '.$this->postTable.'.blogId');
            
            if($craved){
                $entityId=getMasterTableRecord($this->db->dbprefix($this->postTable));
                $tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
                $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->postTable.'.postId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ');
                $this->db->where($this->tableLogSummary.'.craveCount >',0);
            }
            
            
            $res= $this->db->count_all_results();
        }
		return $res;
        
		
	}
	/**
	  * Displays single the post related with the blog
	  * @access	public
	  * @param	postId
	  * @return	object
	**/
	function getPosts($userId=0,$blogId=0,$industryId=0,$catId=0){
	
	$this->db->select($this->postTable.'.*');
	
	if($industryId>0 && $industryId!='')
		$this->db->select($this->tableName.'.blogIndustry');
	
	$this->db->select($this->MediaFile.'.filePath,'.$this->MediaFile.'.fileName');
	$this->db->from($this->postTable);
	
	if($userId!=0 && $userId!='') $this->db->where('custId', $userId);		
	if($blogId!=0 && $blogId!='') $this->db->where('blogId', $blogId);		
	if($catId!=0 && $catId!='') $this->db->where('blogCategoryId', $catId);
			
	$this->db->where('isPublished', 't');		
	$this->db->where('postArchived', 'f');	
	
	if($industryId>0 && $industryId!='') $this->db->join($this->tableName,$this->tableName.'.blogId = '.$this->postTable.'.blogId', 'left');	
	
	$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');	
	
	if($industryId!=0 && $industryId!='') $this->db->where('blogIndustry', $industryId);	
	$this->db->order_by('dateModified','desc');	
	$this->db->limit(18);	
	$query = $this->db->get(); 	
	//echo $this->db->last_query();die;
	//$data['postResults'] = $query->result(); 
	
	return $query->result();	
		
	}
	
	function getFrontPost($userId=0,$postId=0)
	{
		$this->db->select($this->postTable.'.*,'.$this->tableName.'.blogIndustry,'.$this->tableName.'.blogId ,'.$this->MediaFile.'.filePath,'.$this->MediaFile.'.fileName ');
		$this->db->join($this->tableName,$this->tableName.'.blogId = '.$this->postTable.'.blogId', 'left');
		$this->db->join($this->MediaFile,$this->MediaFile.'.fileId = '.$this->postTable.'.postFileId', 'left');
		$this->db->where('postId',$postId);
		if($userId>0)$this->db->where($this->postTable.'.custId',$userId);
		$query = $this->db->get($this->postTable); 
		//print_r($query->result()); 
		//echo 'Last Query:'.$this->db->last_query();die;
		return $query->result();
	}
	
	function getPostsCategory($blogId=0)
	{			 
		 //QUERY WITH POSTS JOIN TO SHOW COUNT AS WELL WITH CATEGORIES
		 
		 $this->db->select('categoryId,categoryTitle,COUNT( "TDS_Posts"."postId" ) as postCount');
		 
		 $this->db->from($this->blogCatName);
				 
		 $this->db->join($this->postTable,$this->postTable.'.blogCategoryId='.$this->blogCatName.'.categoryId','LEFT');
		 
		 if($blogId>0)
			$this->db->where($this->blogCatName.'.blogId',$blogId);
		
		$this->db->where($this->postTable.'.isPublished', 't');		
		$this->db->where($this->postTable.'.postArchived', 'f');	
		 
		 $this->db->group_by("categoryId,categoryTitle"); 
		
		 $this->db->order_by("categoryTitle", "asc"); //TO SHOW ALPHABETIC ORDER
		
		 $query = $this->db->get();
		 
		 //echo '<pre />';print_r($query->result());
		 //echo $this->db->last_query();
		 
		 return $query->result(); 
			 
	}
	
	function getPostsForFeed($userId)
	{	
		$this->db->select('blogId,blogTitle,blogOneLineDesc');
		$this->db->select($this->UserAuth.'.email');
		$this->db->from($this->tableName);
		$this->db->join($this->UserAuth, $this->UserAuth.".tdsUid = ".$this->tableName.".custId", 'left');
		$this->db->where('custId',$userId);		
		$blogQuery = $this->db->get(); 		
		$data['blogDetail'] = $blogQuery->result_array(); 	
		
		
		$this->db->select('postId,blogId,postTitle,'.$this->postTable.'.dateCreated,blogCategoryId,postOneLineDesc,custId,'.$this->postTable.'.dateModified,'.$this->postTable.'.isPublished');
		//$this->db->select($this->UserShowcase.'.firstName,'.$this->UserShowcase.'.lastName');	
		$this->db->from($this->postTable);
		//$this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->postTable.".custId", 'left');		
		$this->db->where($this->postTable.'.isPublished','t');
		$this->db->where('postArchived','f');			
		$orderByPosts = '"dateModified" desc';		
		$this->db->where('custId', $userId);
		$this->db->order_by($orderByPosts); 		
		$this->db->limit(10);		
		$postQuery = $this->db->get(); 		
		
		$data['posts'] = $postQuery->result_array(); 				
		return $data;			
	}
	
	function getUsedIndustry()
	{	
		$blog= $this->db->dbprefix($this->tableName);
		$this->db->distinct();
		$this->db->select($this->tableName.'.blogIndustry');
		$this->db->select('i.IndustryName,i.IndustryOrder');
		
		
		$this->db->from($this->tableName);	
	    $this->db->join($this->tableMasterIndustry.' as i', 'i.IndustryId = CAST("'.$blog.'"."blogIndustry" as int)');
		
				
		$this->db->where($this->tableName.'.isPublished', 't');		
		$this->db->order_by('i.IndustryOrder','ASC');	
		
		$query = $this->db->get(); 	
		return $query->result();			
	}
	
	
}
?>
