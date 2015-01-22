<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Chatching Admin view user content status(posts,comments etc ) Model Class
 * It include functionality to fetch/   
 * @category	Model
 * @author	CDN Solutions
 */
class Admin_content_status_model extends CI_model
{
	private $read_db;	// private variable to store db read reference
	
	/**
	* constructor
	**/
	function __construct(){
		parent::__construct();
		// assign db read instance to read_db variable
		$this->read_db = $this->load->database('read', TRUE);
	}

	/**
	*function to get total number of posts of today
	**/
	function get_total_posts() {
		/*get today's posts count*/
		$cur_date_time = date('Y-m-d');
		$this->read_db->select('action_id,datetime');
		$this->read_db->like('datetime',$cur_date_time);
		$this->read_db->from('cc_action');
		$query = $this->read_db->get();
		$res1 = $query->num_rows();
		$res['res1'] = $res1; 
	
		/*get week's posts count*/
		$last_week_datetime = date("Y-m-d H:i:s", strtotime("-8 days"));
		$this->read_db->select('action_id,datetime');
		$this->read_db->where('datetime >=',$last_week_datetime);
		$this->read_db->from('cc_action');
		$query = $this->read_db->get();
		$res2 = $query->num_rows();
		$res['res2'] = $res2;
	
		/*get month's posts count*/
		$last_month_datetime = date("Y-m-d H:i:s", strtotime("-1 month"));
		$this->read_db->select('action_id,datetime');
		$this->read_db->where('datetime >=',$last_month_datetime);
		$this->read_db->from('cc_action');
		$query = $this->read_db->get();
		$res3 = $query->num_rows();
		$res['res3'] = $res3;

		/*get year's posts count*/
		$last_year_datetime = date("Y-m-d H:i:s", strtotime("-1 Year"));
		$this->read_db->select('action_id,datetime');
		$this->read_db->where('datetime >=',$last_year_datetime);
		$this->read_db->from('cc_action');
		$query = $this->read_db->get();
		$res4 = $query->num_rows();
		$res['res4'] = $res4;

		/*get total posts count*/
		$this->read_db->select('action_id,datetime');
		$this->read_db->from('cc_action');
		$query = $this->read_db->get();
		$res5 = $query->num_rows();
		$res['res5'] = $res5; 
		return $res;
	}
	
	/**
	*function to get total number of comments 
	**/
	function get_total_comments() {
		/*get today's comments count*/
		$cur_date_time = date('Y-m-d');
		$this->read_db->select('comment_id,created_date');
		$this->read_db->where('comment_status','1');
		$this->read_db->like('created_date',$cur_date_time);
		$this->read_db->from('cc_users_comments');
		$query = $this->read_db->get();
		$res1 = $query->num_rows();
		$res['res1'] = $res1; 
	
		/*get week's comments count*/
		$last_week_datetime = date("Y-m-d H:i:s", strtotime("-8 days"));
		$this->read_db->select('comment_id,created_date');
		$this->read_db->where('comment_status','1');
		$this->read_db->where('created_date >=',$last_week_datetime);
		$this->read_db->from('cc_users_comments');
		$query = $this->read_db->get();
		$res2 = $query->num_rows();
		$res['res2'] = $res2;
	
		/*get month's comments count*/
		$last_month_datetime = date("Y-m-d H:i:s", strtotime("-1 month"));
		$this->read_db->select('comment_id,created_date');
		$this->read_db->where('comment_status','1');
		$this->read_db->where('created_date >=',$last_month_datetime);
		$this->read_db->from('cc_users_comments');
		$query = $this->read_db->get();
		$res3 = $query->num_rows();
		$res['res3'] = $res3;

		/*get year's comments count*/
		$last_year_datetime = date("Y-m-d H:i:s", strtotime("-1 Year"));
		$this->read_db->select('comment_id,created_date');
		$this->read_db->where('comment_status','1');
		$this->read_db->where('created_date >=',$last_year_datetime);
		$this->read_db->from('cc_users_comments');
		$query = $this->read_db->get();
		$res4 = $query->num_rows();
		$res['res4'] = $res4;

		/*get disabled comments count*/
		$this->read_db->select('comment_id,created_date');
		$this->read_db->from('cc_users_comments');
		$this->read_db->where('comment_status','0');
		$query = $this->read_db->get();
		$res6 = $query->num_rows();
		$res['res6'] = $res6; 
	
		/*get total comments count*/
		$this->read_db->select('comment_id,created_date');
		$this->read_db->from('cc_users_comments');
		$query = $this->read_db->get();
		$res5 = $query->num_rows();
		$res['res5'] = $res5; 
		return $res;
	}
	
	/**
	*function to get total number of wall status 
	**/
	function get_total_wall_posts() {
		/*get today's wall posts count*/
		$cur_date_time = date('Y-m-d');
		$this->read_db->select('wall_id,wall_date');
		$this->read_db->where('status','1');
		$this->read_db->like('wall_date',$cur_date_time);
		$this->read_db->from('cc_wall');
		$query = $this->read_db->get();
		$res1 = $query->num_rows();
		$res['res1'] = $res1; 
	
		/*get week's wall posts count*/
		$last_week_datetime = date("Y-m-d H:i:s", strtotime("-8 days"));
		$this->read_db->select('wall_id,wall_date');
		$this->read_db->where('status','1');
		$this->read_db->where('wall_date >=',$last_week_datetime);
		$this->read_db->from('cc_wall');
		$query = $this->read_db->get();
		$res2 = $query->num_rows();
		$res['res2'] = $res2;

		/*get month's wall posts count*/
		$last_month_datetime = date("Y-m-d H:i:s", strtotime("-1 month"));
		$this->read_db->select('wall_id,wall_date');
		$this->read_db->where('status','1');
		$this->read_db->where('wall_date >=',$last_month_datetime);
		$this->read_db->from('cc_wall');
		$query = $this->read_db->get();
		$res3 = $query->num_rows();
		$res['res3'] = $res3;

		/*get year's wall posts count*/
		$last_year_datetime = date("Y-m-d H:i:s", strtotime("-1 Year"));
		$this->read_db->select('wall_id,wall_date');
		$this->read_db->where('status','1');
		$this->read_db->where('wall_date >=',$last_year_datetime);
		$this->read_db->from('cc_wall');
		$query = $this->read_db->get();
		$res4 = $query->num_rows();
		$res['res4'] = $res4;

		/*get total wall posts count*/
		$this->read_db->select('wall_id,wall_date');
		$this->read_db->from('cc_wall');
		$query = $this->read_db->get();
		$res5 = $query->num_rows();
		$res['res5'] = $res5; 
	
		/*get disabled wall posts count*/
		$this->read_db->select('wall_id,wall_date');
		$this->read_db->from('cc_wall');
		$this->read_db->where('status','0');
		$query = $this->read_db->get();
		$res6 = $query->num_rows();
		$res['res6'] = $res6; 
		return $res;
	}
}
/* End of file Admin_content_status_model.php */
/* Location: ./application/modules/admin_user_content_status/model/Admin_content_status_model.php */
