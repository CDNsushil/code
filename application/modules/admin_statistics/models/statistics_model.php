<?php
/**
 * Users Model
 * Manage User record etc
 * @category	Users
 * @author	CDN Solutions
 */
class Statistics_model extends CI_Model
{
	private $read_db;	// private variable to store db read reference
	//Constructor
	function __construct(){
		parent::__construct();
		// assign db read instance to read_db variable
		$this->read_db = $this->load->database('read', TRUE);		
	}

	/** 
	*Get count of value of user
	*Params type {recent/all} 
	*Return number
	*Created : 15/05/2012
	*/			
	function getUsercount()
	{		
		$today_start_date =  date("Y-m-d 00:00:00");
		$today_end_date   =  date("Y-m-d 23:59:59");
		
		$this->read_db->where('created_at > ', $today_start_date);
		$this->read_db->where('created_at < ', $today_end_date);
		$this->read_db->where("user.user_role","1");			

		$this->read_db->from('user');
		$this->read_db->where('user.user_role','1');
		$res['today'] = $this->read_db->count_all_results();
	
		$this->read_db->from('user');
		$this->read_db->where('user.user_role','1');
		$res['all']   = $this->read_db->count_all_results();
	
		$last_week_datetime = date("Y-m-d H:i:s", strtotime("-8 days"));
		$this->read_db->from('user');
		$this->read_db->where('user.user_role','1');
		$this->read_db->where('created_at >=',$last_week_datetime);
		$res['week'] = $this->read_db->count_all_results();
	
		$last_month_datetime = date("Y-m-d H:i:s", strtotime("-1 month"));
		$this->read_db->from('user');
		$this->read_db->where('user.user_role','1');
		$this->read_db->where('created_at >=',$last_month_datetime);
		$res['month'] = $this->read_db->count_all_results();
	
		$last_year_datetime = date("Y-m-d H:i:s", strtotime("-1 year"));
		$this->read_db->from('user');
		$this->read_db->where('user.user_role','1');
		$this->read_db->where('created_at >=',$last_year_datetime);
		$res['year'] = $this->read_db->count_all_results();
		return $res;
	}
}
?>