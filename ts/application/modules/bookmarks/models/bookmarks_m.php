<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bookmarks_m extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
    
    public function get_bookmarks($userID,$Type)
    {
		if($userID) 
		{
			$data = array();
			/*$this->db->select('*');
			
			$options = array(
				'bookmark_user_id' => $userID,
				'bookmark_replys' => '0',
			);
			
			$q = $this->db->get_where('forum_bookmarks', $options);
			*/
			$this->db->select('forum_bookmarks.*,forum_topics.CategoryID,forum_category.type');
			$this->db->from('forum_bookmarks');
			$this->db->join('forum_topics', 'forum_topics.TopicID = forum_bookmarks.bookmark_topic_id');
			$this->db->join('forum_category', 'forum_category.CategoryID = CAST("TDS_forum_topics"."CategoryID" as int)');
			$options = array(
				'bookmark_user_id' => $userID,
				'bookmark_replys' => '0',
				'forum_category.type' => $Type,
			);
			$this->db->where($options);
			$q = $this->db->get();
			
			//echo $this->db->last_query();die;
			
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
		else 
		{
			return "";
		}
    }
 }
