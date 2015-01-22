<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core_m extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	function get_settings()
	{
        // [HOOK] Run before settings are fetched
        do_action('pre.get.settings');
        
		$this->db->select('*');
		$this->db->join('themes', 'themes.themeID = settings.themeID');

		$q = $this->db->get('settings', 1);

		if($q->num_rows() > 0)
		{	
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		$q->free_result();
        
        // [HOOK] Settings array returned from database
        $data = do_action('get.settings', $data);
        
		return $data;
        
        // [HOOK] Run after everything is finished
        do_action('post.get.settings');  
	}
    
	function search($query_array, $limit, $offset='')
    {
        // [HOOK] Run before search is  fetched
        do_action('pre.get.search');
        
		$data = array(); 	
       	$this->db->select('forum_topics.TopicID, forum_topics.TopicName, forum_topics.CreatedBy, forum_topics.LastPost, forum_topics.CategoryID, forum_topics.CreatedTime, forum_topics.LastPostTime, forum_topics.Sticky, forum_topics.Closed, forum_topics.Flagged, UserAuth.tdsUid, UserAuth.username, UserAuth.email,UserProfile.firstName,UserShowcase.profileImageName,UserShowcase.stockImageId');
       	$this->db->join('UserAuth', 'UserAuth.username = forum_topics.CreatedBy'); // Joins users
		$this->db->join('UserProfile', 'UserProfile.tdsUid = UserAuth.tdsUid');
		$this->db->join('UserShowcase', 'UserShowcase.tdsUid = UserAuth.tdsUid');
	   	$this->db->order_by('forum_topics.Sticky desc, forum_topics.LastPostTime desc'); // Ordered by latest reply
	   	$this->db->limit($limit, $offset); // For pagination
		$this->db->like('lower("TDS_forum_topics"."TopicName")', strtolower($query_array['search']));
		$this->db->or_like('lower("TDS_forum_topics"."SearchTag")', strtolower($query_array['search']));
		$options = array('forum_topics.Active'=>'1'); // Only get active topics
	   	$q = $this->db->get_where('forum_topics', $options);

		if($q->num_rows() >0)
		{
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
            
            // [HOOK] Search array returned from database
            $data = do_action('get.search', $data);
            
			return $data;
		}
		else
		{
			return false;
		}
        
        // [HOOK] Run after everything is finished
        do_action('post.get.search'); 
        	
	}
	
	
	//--------------------------------------------------------------------------------
	
	/**
	 * @access = public
	 * @use = this function is used to search forums topics
	 * 
	 */ 
	
	function search_forums($query_array, $limit, $offset='')
    {
        // [HOOK] Run before search is  fetched
        do_action('pre.get.search');
        
		$data = array(); 	
       	$this->db->select('forum_topics.TopicID, forum_topics.TopicName, forum_topics.CreatedBy, forum_topics.LastPost, forum_topics.CategoryID, forum_topics.CreatedTime, forum_topics.LastPostTime, forum_topics.Sticky, forum_topics.Closed, forum_topics.Flagged, UserAuth.tdsUid, UserAuth.username, UserAuth.email,UserProfile.firstName,UserShowcase.profileImageName,UserShowcase.stockImageId,forum_category.CategoryID,forum_category.type');
		$this->db->join('forum_category', 'forum_category.CategoryID = CAST("TDS_forum_topics"."CategoryID" as int)');
       	$this->db->join('UserAuth', 'UserAuth.username = forum_topics.CreatedBy'); // Joins users
		$this->db->join('UserProfile', 'UserProfile.tdsUid = UserAuth.tdsUid');
		$this->db->join('UserShowcase', 'UserShowcase.tdsUid = UserAuth.tdsUid');
	   	$this->db->order_by('forum_topics.Sticky desc, forum_topics.LastPostTime '.$this->session->userdata('topicsOrder').''); // Ordered by latest reply
	   	$this->db->limit($limit, $offset); // For pagination
		$this->db->like('lower("TDS_forum_topics"."TopicName")', strtolower($query_array['search']));
		$this->db->or_like('lower("TDS_forum_topics"."SearchTag")', strtolower($query_array['search']));
		$options = array('forum_topics.Active'=>'1','forum_category.type' => 'forums'); // Only get active topics
	   	$q = $this->db->get_where('forum_topics', $options);

		if($q->num_rows() >0)
		{
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
            
            // [HOOK] Search array returned from database
            $data = do_action('get.search', $data);
            
			return $data;
		}
		else
		{
			return false;
		}
        
        // [HOOK] Run after everything is finished
        do_action('post.get.search'); 
        	
	}
	
	
	//--------------------------------------------------------------------------------
	
	/**
	 * @access = public
	 * @use = this function is used to search help topics
	 * 
	 */ 
	
	function search_help($query_array, $limit, $offset='')
    {
        // [HOOK] Run before search is  fetched
        do_action('pre.get.search');
        
		$data = array(); 	
       	$this->db->select('forum_topics.TopicID, forum_topics.TopicName, forum_topics.CreatedBy, forum_topics.LastPost, forum_topics.CategoryID, forum_topics.CreatedTime, forum_topics.LastPostTime, forum_topics.Sticky, forum_topics.Closed, forum_topics.Flagged, UserAuth.tdsUid, UserAuth.username, UserAuth.email,UserProfile.firstName,UserShowcase.profileImageName,UserShowcase.stockImageId,forum_category.CategoryID,forum_category.type');
		$this->db->join('forum_category', 'forum_category.CategoryID = CAST("TDS_forum_topics"."CategoryID" as int)');
       	$this->db->join('UserAuth', 'UserAuth.username = forum_topics.CreatedBy'); // Joins users
		$this->db->join('UserProfile', 'UserProfile.tdsUid = UserAuth.tdsUid');
		$this->db->join('UserShowcase', 'UserShowcase.tdsUid = UserAuth.tdsUid');
	    $this->db->order_by('forum_topics.Sticky desc, forum_topics.LastPostTime '.$this->session->userdata('topicsOrder').''); // Ordered by latest reply
	   	$this->db->limit($limit, $offset); // For pagination
		$this->db->like('lower("TDS_forum_topics"."TopicName")', strtolower($query_array['search']));
		$this->db->or_like('lower("TDS_forum_topics"."SearchTag")', strtolower($query_array['search']));
		$options = array('forum_topics.Active'=>'1','forum_category.type' => 'help'); // Only get active topics
	   	$q = $this->db->get_where('forum_topics', $options);

		if($q->num_rows() >0)
		{
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
            
            // [HOOK] Search array returned from database
            $data = do_action('get.search', $data);
            
			return $data;
		}
		else
		{
			return false;
		}
        
        // [HOOK] Run after everything is finished
        do_action('post.get.search'); 
        	
	}
	
    
    public function install_plugin($name)
    {
        // Store the page the user came from.
        $this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
                
        $this->db->select('plugin_system_name');
        $options = $this->db->options = array('plugin_system_name' => $name);
        $q = $this->db->get_where('plugins', $options);
        
        if($q->num_rows() >0)
        {
            $this->session->set_flashdata('error', 'The plugin has already being installed');
            redirect($this->session->userdata('refered_from'));
        }
        else
        {
            $data = array(
                'plugin_system_name' => $name,
            );
    
            $this->db->insert('plugins', $data);
            $this->session->set_flashdata('message', 'The plugin has being installed');
            redirect($this->session->userdata('refered_from'));      
        }
    }
    
    public function uninstall_plugin($name)
    {
 
         // Store the page the user came from.
        $this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
           
        $options = array(
            'plugin_system_name' => $name,
        );
        $q = $this->db->delete('plugins', $options);
        
        $this->plugins->trigger_uninstall_plugin($name);
        
        $this->session->set_flashdata('message', 'The plugin has being removed');
        redirect($this->session->userdata('refered_from'));            
    }
    
    public function get_all_plugins()
    {
        $data = array();
        $this->plugins_dir = FCPATH . "plugins/";   
        $plugins = directory_map($this->plugins_dir, 1);
        
        if($plugins !== false)
        {
            foreach($plugins as $key => $name)
            {
                $name = strtolower(trim($name));
                
                if ( file_exists($this->plugins_dir.$name."/".$name.".php") )
                {
                   $data[]['name'] = $name;
                }
            }
            return $data;
        }
    }
	
}
