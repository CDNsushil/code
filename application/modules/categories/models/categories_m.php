<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories_m extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	//----------------------------------------------------------------------------------
	
	/**
	 * @Access = public 
	 * @Use = This function is use to show all category 
	 * 
	 */
	 
    public function get_categories($Type)
    {
        // [HOOK] Run before categories are fetched
        do_action('pre.get.categories');
        
        $data = array();
        $this->db->select('CategoryID, parentID, type, Name, Description, Active,order');
        $this->db->order_by('order','asc');
        //$this->db->order_by('CategoryID');
		//  $options = array('type' => 'forums');
        //  $options = array('parentID' => '0');
        
        $options = array('type' => $Type,'Active' => '1');
        $q = $this->db->get_where('forum_category',$options);
        
        /*if($options) 
        {
				$q = $this->db->get_where('forum_category',$options);
		} 
		else 
		{
			$q = $this->db->get_where('forum_category');
		}*/
        
        if ($q->num_rows() >0)
        {
            foreach ($q->result_array() as $row)
            {
                $data[] = $row;
            }
        }
       
        
        $q->free_result();
        
        // [HOOK] Categories array returned from database
        $data = do_action('get.categories', $data);
        
        return $data;
        
        // [HOOK] Run after everything is finished
        do_action('post.get.categories');
    }
    
    
    /**
	 * @Access = public 
	 * @Use = This function is use to show all category 
	 * 
	 */
	 
    public function get_categories_new_topic($Type)
    {
        // [HOOK] Run before categories are fetched
        do_action('pre.get.categories');
        
        $data = array();
        $this->db->select('CategoryID, parentID, type, Name, Description, Active,order');
        //$this->db->order_by('order','asc');
        $this->db->order_by('CategoryID');
		//  $options = array('type' => 'forums');
        //  $options = array('parentID' => '0');
        
        $options = array('type' => $Type,'Active' => '1');
        $q = $this->db->get_where('forum_category',$options);
        
        /*if($options) 
        {
				$q = $this->db->get_where('forum_category',$options);
		} 
		else 
		{
			$q = $this->db->get_where('forum_category');
		}*/
        
        if ($q->num_rows() >0)
        {
            foreach ($q->result_array() as $row)
            {
                $data[] = $row;
            }
        }
       
        
        $q->free_result();
        
        // [HOOK] Categories array returned from database
        $data = do_action('get.categories', $data);
        
        return $data;
        
        // [HOOK] Run after everything is finished
        do_action('post.get.categories');
    }
    
    /*
     * @access : public
     * @use : this function is use to show all category for admin
     * 
     */ 
    
    public function categories_for_admin($options='')
    {
        // [HOOK] Run before categories are fetched
        do_action('pre.get.categories');
        
        $data = array();
        $this->db->select('CategoryID, parentID, type, Name, Description, Active');
        $this->db->order_by('CategoryID');
	//	$options = array('type' => 'forums', 'parentID' => '0');
      //  $options = array('parentID' => '0');
        
        if($options) 
        {
				$q = $this->db->get_where('forum_category',$options);
		} 
		else 
		{
			$q = $this->db->get_where('forum_category');
		}
        
        if ($q->num_rows() >0)
        {
            foreach ($q->result_array() as $row)
            {
                $data[] = $row;
            }
        }
       
        
        $q->free_result();
        
        // [HOOK] Categories array returned from database
        $data = do_action('get.categories', $data);
        
        return $data;
        
        // [HOOK] Run after everything is finished
        do_action('post.get.categories');
    }
	
	/**
     * @Access = public 
	 * @Use = This function is use to show sub category by parent id
     * 
     */ 
     
    function get_sub_categories($categoryID,$Type)
    {
		
		$data = array();
    	$this->db->select('CategoryID, parentID, Name, Description, type, Active');
    	$options = array('parentID' => $categoryID,'type' => $Type,'Active' => '1');
		
    	$q = $this->db->get_where('forum_category', $options);
		
        if ($q->num_rows() >0)
        {
            foreach ($q->result_array() as $row)
            {
                $data[] = $row;
            }
        }
		
        $q->free_result();

        return $data; 

    }
    
    /**
     * @Access = public 
	 * @Use = This function is use to show sub category by parent id for admin
     * 
     */ 
    
    function sub_categories_for_admin($categoryID)
    {
		
		$data = array();
    	$this->db->select('CategoryID, parentID, Name, Description, type, Active');
    	$options = array('parentID' => $categoryID);
		
    	$q = $this->db->get_where('forum_category', $options);
		
        if ($q->num_rows() >0)
        {
            foreach ($q->result_array() as $row)
            {
                $data[] = $row;
            }
        }
		
        $q->free_result();

        return $data; 

    }
    	
	function get_root_categories()
	{
		
		$data = array();
		
		$this->db->select('*');
		$this->db->where('type','Requested');
		$this->db->where('parentID !=','0');
		$this->db->where('Active','0');
    	$q = $this->db->get('forum_category');
		
        if ($q->num_rows() >0)
        {
            foreach ($q->result_array() as $row)
            {
                $data[] = $row;
            }
        }
		
        $q->free_result();
    
		
        return $data; 
	}
	
	
	
	public function count_topics($CategoryID)
    {
    	$options = array('CategoryID'=>$CategoryID, 'Active'=>'1');
    	$query = $this->db->get_where('forum_topics', $options);
    	return $query->num_rows();
    }
    
	public function count_posts($CategoryID)
	{
		$options = array('CategoryID'=>$CategoryID, 'Active'=>'1');
		$query = $this->db->get_where('forum_comments', $options);
		return $query->num_rows();
	}
	
    public function get_current_cat($id='') 
    {
		$data = array();
		$this->db->select('Name');
		$options = array('CategoryID' => $id);
		$q = $this->db->get_where('forum_category', $options, 1);
			   
	   	if($q->num_rows() > 0)
	   	{
			foreach ($q->result_array() as $row) 
			{
				$data[] = $row;
			}

            $name = $row['Name'];
    		
    		if(!$name)
    		{
    			return '0';			
    		}		
    		else		
    		{
    			return $row['Name'];		
    		}
		}
		$q->free_result();
    }
    
    public function getCurrentCatSubCat($id) 
    {
		$data = array();
		$this->db->select('*');
		$options = array('CategoryID' => $id,'Active'=>'1');
		$q = $this->db->get_where('forum_category', $options, 1);
			   
	   	if($q->num_rows() > 0)
	   	{
			return $q->row_array();
		}
		
    }
    
    function get_categories_count($CategoryID)
    {
			
			$this->db->from('forum_topics');
			$this->db->where('CategoryID',$CategoryID);
			$this->db->where('Active',1);
			return $this->db->count_all_results();
	}
    
    function get_parent_categories($CategoryID)
    {
		$data = array();
		$this->db->select('Name');
		$this->db->where('CategoryID',$CategoryID);
		$query = $this->db->get('forum_category');
		if ($query->num_rows() >0)
        {
           return $query->result_array(); 
        }
	}
	
	//----------------------------------------------------------------------------
	
	/**
	 * @access = public
	 * @use = this fuction is used to show category by type
	 * 
	 */ 
	
	/*function getCategoryByType($categoryType)
	{
		$data = array();
		$this->db->order_by('CategoryID');
		$this->db->select('CategoryID, parentID, Name, Description, type, Active');
		$this->db->where('type',$categoryType);
		$this->db->where('Active',1);
		$query = $this->db->get('forum_category');
		
		if ($query->num_rows() >0)
        {
           return $query->result_array(); 
        }
		
	}*/
	
    
}
