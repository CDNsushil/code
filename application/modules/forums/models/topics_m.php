<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Topics_m extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_topics($limit, $offset=NULL)
	{
		$data = array(); 	

       /* Old query 23-jan-2013
        * $this->db->select('forum_topics.TopicID, forum_topics.TopicName,UserProfile.firstName,UserShowcase.profileImageName, forum_topics.CreatedBy, forum_topics.LastPost, forum_topics.CategoryID, forum_topics.CreatedTime, forum_topics.LastPostTime, forum_topics.Sticky, forum_topics.Closed, forum_topics.Flagged, UserAuth.tdsUid, UserAuth.username, UserAuth.email,UserShowcase.stockImageId');
       	$this->db->join('UserAuth', 'UserAuth.username = forum_topics.CreatedBy'); // Joins UserAuth
		$this->db->join('UserProfile', 'UserProfile.tdsUid = UserAuth.tdsUid');
		$this->db->join('UserShowcase', 'UserShowcase.tdsUid = UserAuth.tdsUid');
	   	$this->db->order_by('forum_topics.Sticky desc, forum_topics.LastPostTime '.$this->session->userdata('topicsOrder').', forum_topics.Closed');
	   	$this->db->limit($limit, $offset); // For pagination

       	$options = array('forum_topics.Active'=>'1'); // Only get active topics*/
       	
       	$this->db->select('forum_topics.TopicID, forum_topics.TopicName,UserProfile.firstName,UserShowcase.profileImageName, forum_topics.CreatedBy, forum_topics.LastPost, forum_topics.CategoryID, forum_topics.CreatedTime, forum_topics.LastPostTime, forum_topics.Sticky, forum_topics.Closed, forum_topics.Flagged, UserAuth.tdsUid, UserAuth.username, UserAuth.email,UserShowcase.stockImageId,forum_category.CategoryID,forum_category.type');
       	$this->db->join('forum_category', 'forum_category.CategoryID = CAST("TDS_forum_topics"."CategoryID" as int)');
       	$this->db->join('UserAuth', 'UserAuth.username = forum_topics.CreatedBy'); // Joins UserAuth
		$this->db->join('UserProfile', 'UserProfile.tdsUid = UserAuth.tdsUid');
		$this->db->join('UserShowcase', 'UserShowcase.tdsUid = UserAuth.tdsUid');
	   	$this->db->order_by('forum_topics.Sticky desc, forum_topics.LastPostTime '.$this->session->userdata('topicsOrder').', forum_topics.Closed');
	   	$this->db->limit($limit, $offset); // For pagination

       	$options = array('forum_topics.Active'=>'1','forum_category.type' => 'forums'); // Only get active topics

	   	$q = $this->db->get_where('forum_topics', $options); 

		if($q->num_rows() >0)
		{
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}

			return $data;
		}
		else
		{
			return false;
			// There must have being a problem, create a error log
			log_message('error', 'get_topics function failed! - /modules/topics/models/topics_m/get_topics');
		}
	}
    
    public function get_topic($topic_id)
    {
        $data = array();
        
        $this->db->select('forum_topics.TopicID, forum_topics.TopicName, forum_topics.CreatedBy, forum_topics.LastPost, forum_topics.CategoryID, forum_topics.CreatedTime, forum_topics.LastPostTime, forum_topics.Sticky, forum_topics.Closed, forum_topics.Flagged, forum_comments.CommentID, forum_comments.Body');
        $this->db->join('forum_comments', 'forum_comments.Title = forum_topics.TopicName');
        $this->db->limit('1');
        
        $options = array('forum_topics.TopicID' => $topic_id);
        
        $q = $this->db->get_where('forum_topics', $options);
        
        if($q->num_rows() >0)
        {
            foreach ($q->result_array() as $row)
            {
                $data[] = $row;
            }
            
            return $data;
        } else {
            return false;
        }
    }

	public function count_topics()
	{
		$options = array('Active' => '1');

		$q = $this->db->get_where('forum_topics', $options);

		if($q->num_rows() >0)
		{
			return $q->num_rows();
		}
		else
		{
			return false;
		}
	}

	/**
    * Return a count of topics in a category
	*
	* @access public
	* @return $num_rows
	*/
    		
	public function count_cat_topics($category_id)
	{
		$options = array('CategoryID'=>$category_id, 'Active' => '1');
		$query = $this->db->get_where('forum_topics', $options);

		return $query->num_rows();	
	}
	
	//-----------------------------------------------------------------------------
	
	/**
    * 
	* @access public
	* @use this function is use to show  cateogry parent status 
	* @return $num_rows
	*/
    		
	public function getCategoryStatus($category_id)
	{
		$options = array('CategoryID'=>$category_id, 'Active' => '1');
		$query = $this->db->get_where('forum_category', $options);

		return $query->row()->parentID;	
	}	

	/**
    * Return all the topics in a category
	*
	* @access public
	* @param $category a string containing the category
	* @param $limit a string containing the limit
	* @param $offset a string containing the offset
	* @return $data
	*/		
	public function get_cat_topics($category_id, $limit, $offset=NULL)
	{
		$data = array(); 	

       	$this->db->select('forum_topics.TopicID, forum_topics.TopicName,UserProfile.firstName,UserShowcase.profileImageName, forum_topics.CreatedBy, forum_topics.LastPost, forum_topics.CategoryID, forum_topics.CreatedTime,forum_topics.LastPostTime, forum_topics.Sticky, forum_topics.Closed, forum_topics.Flagged, UserAuth.tdsUid, UserAuth.username, UserAuth.email,UserShowcase.stockImageId');
   		$this->db->join('UserAuth', 'UserAuth.username = forum_topics.CreatedBy');
		$this->db->join('UserProfile', 'UserProfile.tdsUid = UserAuth.tdsUid');
		$this->db->join('UserShowcase', 'UserShowcase.tdsUid = UserAuth.tdsUid');
   		$this->db->order_by('forum_topics.Sticky desc, forum_topics.LastPostTime '.$this->session->userdata('topicsOrder').'');
   		$this->db->limit($limit, $offset);

   		$options = array('forum_topics.CategoryID'=>$category_id, 'forum_topics.Active'=>'1');

   		$q = $this->db->get_where('forum_topics', $options);

		if($q->num_rows() >0)
		{
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}

		$q->free_result();

		return $data;
	}	

    public function count_posts($topic_id)
    {
    	$options = array('TopicID'=>$topic_id, 'Active'=>'1');
    	$query = $this->db->get_where('forum_comments', $options);
    	return $query->num_rows();
    }	

	public function submit_topic() 
	{
		// Store the page the user came from.

		$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
        
    	$this->form_validation->set_rules('title', 'Title', 'required|max_length[250]|htmlspecialchars');
    	//$this->form_validation->set_rules('search_tag', 'Tag Words', 'required|max_length[250]|htmlspecialchars');
    	$this->form_validation->set_rules('category', 'Category', 'required');
    	$this->form_validation->set_rules('comment', 'Comment', 'required|htmlspecialchars');

		if ($this->form_validation->run() == FALSE) 
		{
			set_global_messages(validation_errors(), 'error');
    		// Send the user back to the page they came from
			redirect($this->session->userdata('refered_from'));
		}
		else 
		{
		$TopicID = uniqid();					

		$data = array(			
			'username' => $this->session->userdata('username'),			
			'date' => time(),			
			'activity' => 'topic',			
			'topic_id' => $TopicID,			
			'category_id' => $this->input->post('category'),            		
		);		

		$this->db->insert('forum_activity', $data); // Insert activity into activity's table 

		if($this->input->post('Sticky') == '1')
		{
			$sticky = $this->input->post('Sticky');
		}
		else
		{
			$sticky = '0';
		}

		if($this->input->post('Close') == '1')
		{
			$close = $this->input->post('Close');
		}
		else
		{
			$close = '0';
		}

    	$data = array(
    		'TopicID' => $TopicID,
        	'TopicName'     =>  $this->input->post('title'),
        	'CreatedBy' => $this->session->userdata('username'),
        	'LastPost' => $this->session->userdata('username'),
        	'CategoryID'  =>  $this->input->post('category'),
        	'CreatedTime' => time(),
        	'LastPostTime' => time(),
            'Active' => '1',
			'Sticky'		=> $sticky,
			'Closed'			=> $close,
			'SearchTag'			=> $this->input->post('search_tag'),
    	);

    	$this->db->insert('forum_topics', $data); 

    	$data = '';    	

    	$CommentID = uniqid();

    	$data = array(
    		'CommentID' => $CommentID,
    		'TopicID' => $TopicID,
			'CategoryID' => $this->input->post('category'),
    		'Title' => $this->input->post('title'),
    		'Body' => $this->input->post('comment'),
    		'CreatedBy' => $this->session->userdata('username'),
			'CategoryID'  =>  $this->input->post('category'),
    		'PostTime' => time(),
            'Active' => '1',
   		);

   		$this->db->insert('forum_comments', $data); 

		// Insert comment into comments table				

		$data = '';		

		set_global_messages($this->lang->line('messageNewTopicSuccess'), 'success');
    	redirect('forums/posts/'.$this->input->post('category').'/'.$TopicID.'/');
		}
	} // End of submitTopic
    
	/**
	 * Return the Topic's Name
	 *
	 * @access public
	 * @param $TopicID a string containing the topic's ID
	 * @return $row
	 */		
	public function get_topic_name($topic_id)
	{
		
		$row = array();
		$this->db->select('TopicName');
		$options = array('TopicID'=>$topic_id);
		$q = $this->db->get_where('forum_topics', $options);

		
		if($q->num_rows() > 0)
		{
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		
		return $row['TopicName'];
	}
    
    public function get_topic_users($topic_id)
    {
        $emails = array();
        $this->db->select('UserAuth.email');
        $this->db->join('UserAuth', 'UserAuth.username = forum_comments.CreatedBy');
        
        $options = array(
            'TopicID' => $topic_id,
        );
        
        $q = $this->db->get_where('forum_comments', $options);
        
        if($q->num_rows() > 0)
        {
            foreach ($q->result_array() as $row)
            {
                $emails['emails'][] = $row['email'];
            }
        }
        return $emails;
    }
    
    public function get_cat_id($topic_id)
    {
        $this->db->select('CategoryID');
        $options = array(
            'TopicID' => $topic_id,
        );
        
        $q = $this->db->get_where('forum_topics', $options);
        
        if($q->num_rows() > 0)
        {
            foreach ($q->result_array() as $row)
            {
                $data[] = $row;
            }
        }
        
        
  	     //return $row['CategoryID']; // Need to change
    }
    
    
    
    /**
	 * Return all the posts in a category 
	 *
	 * @access public
	 * @param $topic_id a string contaning the category
	 * @return $data
	 */	
    
     public function getCategoryId($topic_id)
    {
        $this->db->select('*');;
		$this->db->where('TopicID', $topic_id);
		$query=$this->db->get('forum_topics');
		return $query->row()->CategoryID;
    }

	 /**
	 * Return all the posts in a category 
	 *
	 * @access public
	 * @param $category a string contaning the category
	 * @param $limit a string containing the limit
	 * @param $offset a string containing the offset
	 * @param $TopicID a string containing the topic's ID
	 * @return $data
	 */	   
    public function get_posts($limit, $topic_id, $offset=NULL)
    {
		$data = array();
	
		$this->db->select("UserAuth.*");
        $this->db->select("UserProfile.*");
        $this->db->select("UserShowcase.*");
        $this->db->select("forum_topics.*");
        $this->db->select("forum_comments.CommentID,"."forum_comments.TopicID,"."forum_comments.CategoryID,"."forum_comments.Body,"
        ."forum_comments.CreatedBy,"."forum_comments.PostTime,"."forum_comments.Active,"."forum_comments.reported");
	
	
	
		$this->db->join('UserAuth', 'UserAuth.username = forum_comments.CreatedBy');
		$this->db->join('UserProfile', 'UserProfile.tdsUid = UserAuth.tdsUid');
		$this->db->join('UserShowcase', 'UserShowcase.tdsUid = UserAuth.tdsUid');
		$this->db->join('forum_topics', 'forum_topics.TopicID = forum_comments.TopicID');
		$this->db->order_by('forum_comments.PostTime', 'desc'); 
//		$this->db->limit($limit, $offset);   

		$options = array('forum_comments.TopicID' => $topic_id, 'forum_comments.Active'=>'1');

		$q = $this->db->get_where('forum_comments', $options);

		if ($q->num_rows() > 0) 
		{
			foreach ($q->result_array() as $row) 
			{
				$data[] = $row;
			}
		}

		$q->free_result();
		return $data;
	}
    
    public function get_first_post($topic_id)
    {
        $data = array();
        	$this->db->select("UserAuth.*");
        $this->db->select("UserProfile.*");
        $this->db->select("UserShowcase.*");
        $this->db->select("forum_topics.*");
        $this->db->select("forum_comments.CommentID,"."forum_comments.TopicID,"."forum_comments.CategoryID,"."forum_comments.Body,"
        ."forum_comments.CreatedBy,"."forum_comments.PostTime,"."forum_comments.Active,"."forum_comments.reported");
	
        $this->db->join('UserAuth', 'UserAuth.username = forum_comments.CreatedBy');
		$this->db->join('UserProfile', 'UserProfile.tdsUid = UserAuth.tdsUid');
		$this->db->join('UserShowcase', 'UserShowcase.tdsUid = UserAuth.tdsUid');
        $this->db->join('forum_topics', 'forum_topics.TopicID = forum_comments.TopicID');
        $this->db->order_by('forum_comments.PostTime asc');
        $this->db->limit('1');
        
        $options = array('forum_comments.TopicID' => $topic_id, 'forum_comments.Active' => '1');
        
        $q = $this->db->get_where('forum_comments', $options);
        
        if($q->num_rows() > 0)
        {
            foreach($q->result_array() as $row)
            {
                $data[] = $row;
            }
        }
        
        $q->free_result();
        return $data;
    }

	public function get_settings()
	{
		
		$this->db->select('*');

		$this->db->join('forum_themes', 'forum_themes.themeID = forum_settings.themeID');

		$q = $this->db->get('forum_settings', 1);

		if($q->num_rows() > 0)
		{	
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}

		$q->free_result();

		return $data;
	}
    
    public function add_bookmark($topic_id, $topic_title)
    {
        // check and see if the user has already bookmarked this topic
        $user_id = $this->session->userdata('user_id');
        $check = $this->check_bookmark($topic_id, $user_id);

        if($check == false)
        {
            // The user already has this discussion bookmarked, let`s redirect them
         		set_global_successs($this->lang->line('errorTopicBookmarked'), 'error');

            redirect($this->session->userdata('refered_from'));
        }
        else
        {
            $data = array(
                'bookmark_topic_title' => $topic_title,
                'bookmark_topic_id' => $topic_id,
                'bookmark_user_id' => $user_id,
            );
            
            $this->db->insert('forum_bookmarks', $data);
            
            if($this->db->affected_rows() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    
    public function remove_bookmark($topic_id)
    {
        $user_id = $this->session->userdata('user_id');
        
        $data = array(
            'bookmark_topic_id' => $topic_id,
            'bookmark_user_id' => $user_id,
        );
        
        $this->db->delete('forum_bookmarks', $data);
        
        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function remove_discussion($topic_id)
    {
        if($this->ion_auth->is_admin() || $this->ion_auth->is_group('moderators'))
        {
            // If the admin is tryring to delete a topic then delete it.
            $data = array(
                'TopicID' => $topic_id,
            );
            
            $this->db->delete('forum_topics', $data);
            $this->db->delete('forum_comments', $data);
            
            if($this->db->affected_rows() > 0)
            {
                return true;
            }else{
                return false;
            }
        }else{
            // Perform checks
            $options = array(
                'TopicID' => $topic_id,
                'CreatedBy' => $this->session->userdata('username'),
            );
            
            $q = $this->db->get_where('forum_topics', $options);
            
            if($q->num_rows() > 0)
            {
                $data = array(
                    'TopicID' => $topic_id,
                );
                
                $this->db->delete('forum_comments', $data); 
                $this->db->delete('forum_topics', $data);
                return true;
                
            }else{
                
                return false;
                
            }

            if($this->db->affected_rows() > 0)
            {
                
                return true;
                
            }else{
                
                return false;
                
            }
        }
    }
    
    public function check_bookmark($topic_id, $user_id)
    {
        // check and see if the user has already bookmarked this topic
        if($user_id) {
				$this->db->select('*');
				$options = array(
					'bookmark_topic_id' => $topic_id,
					'bookmark_user_id' => $user_id,
				);
				
				$q = $this->db->get_where('forum_bookmarks', $options);
				
				if($q->num_rows() > 0)
				{
					return false;
				}
				else
				{
					return true;
				}      
		} else {
				return false;
		}  
    }
}
