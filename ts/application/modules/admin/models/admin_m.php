<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_m extends CI_Model {
    
	public function __construct() 
	{
		parent::__construct();
	}

	public function count_discussions()
	{
		$options = array('Active' => '1');
		$query = $this->db->get_where('forum_topics', $options);
		return $query->num_rows();	
	}

	public function count_posts()
	{
		$options = array('Active' => '1');
		$query = $this->db->get_where('forum_comments', $options);
		return $query->num_rows();
	} 

	public function count_users()
	{
		$options = array('active' => '1');
		$query = $this->db->get_where('UserAuth', $options);
		return $query->num_rows();
	}

	public function get_users()
	{
        $data = array();
		$this->db->select('tdsUid, username, email, created, last_visit, active');
    	$this->db->order_by('active desc, tdsUid asc');

		$q = $this->db->get('UserAuth');

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

	public function get_categories()
	{
        $data = array();
		$this->db->select('*');
		$this->db->order_by('CategoryID', 'asc');
        
		$q = $this->db->get('forum_category');

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

	public function get_category($categoryID)
	{
        $data = array();
		$this->db->select('*');
		$this->db->limit('1');
		$this->db->where('CategoryID', $categoryID);

		$q = $this->db->get('forum_category');
		
		if ($q->num_rows() > 0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		
		$q->free_result();
		return $data;
	}

	public function get_user($userID)
	{
		
        $data = array();
		$this->db->select('*');
		$this->db->join('forum_meta', 'forum_meta.user_id = UserAuth.tdsUid');
		$this->db->limit('1');
		$this->db->where('UserAuth.tdsUid', $userID);

		$q = $this->db->get('UserAuth');

		if ($q->num_rows() > 0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
    
	public function get_groups()
	{
	   $data = array();
		$this->db->select('*');
		$q = $this->db->get('forum_groups');

		if ($q->num_rows() > 0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		
		$q->free_result();
		return $data;
	}
	
	public function get_discussions()
	{
        $data = array();
		$this->db->select('*');
		$this->db->order_by('Flagged desc, Sticky desc, Closed asc');
		$q = $this->db->get('forum_topics');

		if ($q->num_rows() > 0)
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
		$this->db->limit('1');
		$q = $this->db->get('forum_settings');

		if ($q->num_rows() > 0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}

		$q->free_result();
		return $data;
	}
	
	public function get_themes()
	{
		$this->db->select('*');
		$this->db->where('themeActive', '1');
		$q = $this->db->get('forum_themes');

		if ($q->num_rows() > 0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}

		$q->free_result();
		return $data;
	}
}
