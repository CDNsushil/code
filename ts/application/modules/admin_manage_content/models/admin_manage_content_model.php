<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Chatching Admin manage user content(posts,images etc ) Model Class
 * It include functionality to fetch/ remove/email  
 * @category	Model
 * @author	CDN Solutions
 */
class Admin_manage_content_model extends CI_model{
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
	public function get_user_content($page=0,$perpage=0,$user_id,$post_type_filter,$post_type)
	{
		
		$total_count = 0;
		$start=0;
		if($page!=0){
			$start=($page-1)*$perpage;
		}
		$data	=	array();
		$this->read_db->join('action_type','action_type.action_type_id=action.post_type_id');
		$this->read_db->distinct('post_type_id,post_record_id');
		$this->read_db->order_by('datetime','desc');
		$this->read_db->group_by('post_record_id');
		$this->read_db->select('action_type.table,action_type.action_name,action.post_record_id,action.post_type_id,action.post_record_id,action.action_id,UNIX_TIMESTAMP(datetime) as actiondatetime, action.datetime');
		if($user_id!=''){
			$this->read_db->where('action.user_id',$user_id);
		}
		if($post_type_filter!=''){
			$this->read_db->where('action_type.action_name',$post_type_filter);
		} 	
		if($perpage!=0){		
			$this->read_db->limit($perpage,$start);
		}
		if(!empty($post_type)){
			if($post_type=="today"){
				$cur_date_time = date('Y-m-d');
				$this->read_db->like('action.datetime',$cur_date_time);
				}
			if($post_type=="week"){
				$last_week_datetime = date("Y-m-d H:i:s", strtotime("-8 days"));
				$this->read_db->where('action.datetime >=',$last_week_datetime);
				}
			if($post_type=="month"){
				$last_month_datetime = date("Y-m-d H:i:s", strtotime("-1 month"));
				$this->read_db->where('action.datetime >=',$last_month_datetime);
				}
			if($post_type=="year"){
				$last_year_datetime = date("Y-m-d H:i:s", strtotime("-1 year"));
				$this->read_db->where('action.datetime >=',$last_year_datetime);
				}
		}
		$query	=$this->read_db->get('action');
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $result)
			{
				if($result->post_type_id == 1)
				{
					$this->read_db->select('*');
					//$this->db->where('media.media_id',$result->post_record_id);
					$media	= 	$this->read_db->get('media');
					$data[$i]['actiondatetime']=	$result->actiondatetime;
					$data[$i]['table']	   =	$result->table;
					$data[$i]['action_name']	   =	$result->action_name;
					$data[$i]['post_record_id']=	$result->post_record_id;
					$data[$i]['datetime']	   =	$result->datetime;
					$data[$i]['location']	   =	$media->row()->location;
					$data[$i]['post_type']	   =	$result->post_type_id;
					$data[$i]['media_id']	   =	$media->row()->media_id;
					$data[$i]['media_name']    =	$media->row()->media_name;
					$data[$i]['media_text']	   =	$media->row()->media_text;
					$data[$i]['media_type']	   =	$media->row()->media_type;
					$data[$i]['user_id']	   =	$media->row()->user_id;
					$data[$i]['post_user_id']  =	$media->row()->user_id;
					$data[$i]['is_tagged']	   =	$media->row()->is_tagged;
					$total_count++;
					
				}
				else if($result->post_type_id == 2)
				{
					$this->read_db->where('wall.wall_id',$result->post_record_id);
					$media	= 	$this->read_db->get('wall');
					if($media->row()){
						$data[$i]['actiondatetime']	=	$result->actiondatetime;
						$data[$i]['table']	=	$result->table;
						$data[$i]['action_name']	   =	$result->action_name;
						$data[$i]['post_record_id']	=	$result->post_record_id;
						$data[$i]['datetime']	=	$result->datetime;
						$data[$i]['location']	=	$media->row()->location;
						$data[$i]['post_type']	=	$result->post_type_id;
						$data[$i]['wall_id']	=	$media->row()->wall_id;
						$data[$i]['wall_for_id']	=	$media->row()->wall_for_id;
						$data[$i]['user_id']	=	$media->row()->user_id;
						$data[$i]['wall_content']	=	$media->row()->wall_content;
						$data[$i]['wall_share_text']	=	$media->row()->wall_share_text;

						$data[$i]['wall_date']	=	$media->row()->wall_date;
						$total_count++;
					}
				}
				else if($result->post_type_id == 3)
				{
					// on progress
					// $this->db->where('wall_id',$result->post_record_id);
					// $media	= 	$this->db->get('wall');
					// $data[]	=	$media->row();
				}
				else if($result->post_type_id == 4)
				{
					$this->read_db->where('media.media_id',$result->post_record_id);
					$media	= 	$this->read_db->get('media');
					$data[$i]['actiondatetime']	=	$result->actiondatetime;
					$data[$i]['table']	=	$result->table;
					$data[$i]['action_name']	   =	$result->action_name;
					$data[$i]['post_record_id']	=	$result->post_record_id;
					$data[$i]['datetime']	=	$result->datetime;
					$data[$i]['location']	=	$media->row()->location;
					$data[$i]['post_type']	=	$result->post_type_id;
					$data[$i]['media_id']	=	$media->row()->media_id;
					$data[$i]['media_name']	=	$media->row()->media_name;
					$data[$i]['media_type']	=	$media->row()->media_type;
					$data[$i]['media_text']	=	$media->row()->media_text;
					$data[$i]['user_id']	=	$media->row()->user_id;
					$data[$i]['post_user_id']	=	$media->row()->user_id;
					$total_count++;
					// fetch like  
					// fetch dislike
				}
				else if($result->post_type_id == 5)
				{
					$this->read_db->where('users_comments.post_id',$result->post_record_id);
					$comments	= 	$this->read_db->get('users_comments');
					if($comments->row()){
						$data[$i]['actiondatetime']	=	$result->actiondatetime;
						$data[$i]['table']	=	$result->table;
						$data[$i]['action_name']	   =	$result->action_name;
						$data[$i]['post_record_id']	=	$result->post_record_id;
						$data[$i]['datetime']	=	$result->datetime;
						$data[$i]['post_type']	=	$result->post_type_id;
						$data[$i]['comments_id']	=	$comments->row()->comment_id;
						$data[$i]['post_id']	=	$comments->row()->post_id;
						$data[$i]['user_id']	=	$comments->row()->user_id;
						$data[$i]['comment']	=	$comments->row()->comment;
						$total_count++;
					}
				}
				$i++;
			}
			return $data;
		}
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
	function get_all_post_type() {
		$this->read_db->select('action_name,table,action_type_id');
		$this->read_db->from('action_type'); 
		$query = $this->read_db->get();
		$res   = $query->result(); 
		return $res;	
	}
	
	
}
/* End of file Admin_manage_content_model.php */
/* Location: ./application/modules/comment/model/comment_model.php */
