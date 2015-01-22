<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Chatching Admin manage user content(posts,images etc ) Model Class
 * It include functionality to fetch/ remove/email  
 * @category	Model
 * @author	CDN Solutions
 */
class Admin_manage_user_interest_model extends CI_model
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
	*function to get user posts
	**/
	function get_user_content1(){
		$this->read_db->select('cc_action.user_id,cc_action.post_record_id,cc_action.datetime,cc_action.post_type_id,cc_action_type.action_name
		,cc_action_type.table');
		$this->read_db->from('cc_action');
		$this->read_db->join('cc_action_type','cc_action.post_type_id=cc_action_type.action_type_id');
		$query = $this->read_db->get();
		return $res   = $query->result();
	}

	/**
	*function to get user content 
	**/
	public function get_user_interest_data($page=0,$perpage=0,$interest_type_filter)
	{
		$total_count = 0;
		$start=0;
		if($page!=0){
			$start=($page-1)*$perpage;
		}
		$data	=	array();
		$this->read_db->select('*');
		if($interest_type_filter!=''){
			$this->read_db->where('type',$interest_type_filter);
		} 	
		if($perpage!=0){		
			$this->read_db->limit($perpage,$start);
		}
		$query	=$this->read_db->get('user_interest');
		return $query;
	}
	
	/**
	*update post  (disable by admin)
	*@Params action id
	*@return bool
	*/
	function disable_post($action_arr,$post_record_id,$table) {
		$res = $this->db->delete($table, array($table.'_id' => $post_record_id)); 
		return $res;	
	}
	
	/**
	*Get all post types
	*@Params 
	*@return array()
	*/
	function get_all_interest_type() {
		$this->read_db->select('id,type');
		$this->read_db->from('interest'); 
		$query = $this->read_db->get();
		$res   = $query->result(); 
		return $res;	
	}
	
	function add_interest($interest_arr){
		return $res=$this->db->insert('user_interest',$interest_arr);
	}
	
	function update_interest($interest_arr,$id){
		$this->db->where('id',$id);
		return $res=$this->db->update('user_interest',$interest_arr);
	}
	
	function delete_interest($id){
		$this->db->where('id', $id);
		return $res=$this->db->delete('user_interest');
	}
}
/* End of file Admin_manage_content_model.php */
/* Location: ./application/modules/comment/model/comment_model.php */