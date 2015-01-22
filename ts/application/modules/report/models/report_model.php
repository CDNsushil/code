<?php

/**
 * report Model
 * Manage content reports etc
 * @category	Model
 * @author		CDN Solution
 */
class Report_model extends CI_Model
{
		//Constructor
		function __construct(){
            parent::__construct();
            $this->read_db = $this->load->database('read', TRUE); 
		}

		function create_report($new_report){
			$this->db->set('report_date', 'NOW()', false);
			$this->db->set($new_report);
			$this->db->insert('report');
			return true;
		}
		
		function get_report_type(){
			$report_type = $this->read_db->get('report_type');
			return $report_type->result();
			
		}
		
		/**
		* function to get report list
		**/
		function get_report_list($report_id='',$page='',$perPage='',$searchTxt='',$searchReportType='',$issue_type='',$assign_to=''){
			
			if($page !=''){
				$start =($page-1)*$perPage;
				$this->read_db->limit($perPage,$start);
			}
			
			$loggedData=$this->session->userdata('session_data');
			$user_role =$loggedData['user_role'];
			if($user_role > 1 ){
					$this->read_db->where('user_roll_type.role_id',$user_role);
			}
			if($report_id!=''){
				$this->read_db->where('report.report_id',$report_id);
			}
			
			if(trim($searchTxt)!='' AND trim($searchTxt)!='Enter Member Name'){
				$this->read_db->like('user.firstname',$searchTxt,'after');
			}
			if($searchReportType!='' AND $searchReportType!='0'){
				$this->read_db->where('report.issue_status',$searchReportType);
			}
			if($issue_type!=''){
				$this->read_db->where('report.report_type_id',$issue_type);
			}
			if($assign_to!=''){
				$this->read_db->where('report.issue_to',$assign_to);
			}			
			
			$this->read_db->select('report.report_comment,report.spam_status,report.report_id,report.issue_to,report.issue_status,user_roll_type.user_type, user.firstname as username,user.firstname,user.lastname, report_type.report_type,report.report_for_id,report.report_for_type,action_type.action_name,report.report_date,user.user_id, media.media_name,media.post_user_id,media.album_id,wall.wall_content,wall.user_id');
			$this->read_db->from('report');
			$this->read_db->join('report_type', 'report.report_type_id = report_type.report_type_id', 'left');
			$this->read_db->join('user', 'report.user_id = user.user_id', 'left');
			$this->read_db->join('user_roll_type', 'user_roll_type.role_id = report.issue_to', 'left');
			$this->read_db->join('wall', 'wall.wall_id = report.report_for_id', 'left');
			$this->read_db->join('action_type','report.report_for_type = action_type.action_type_id','left');
			$this->read_db->join('media','media.media_id= report.report_for_id','left');
			$this->read_db->order_by('report.report_date','desc');
			$reports_query = $this->read_db->get();
			
			if ($reports_query->num_rows() > 0){//echo "<pre>"; print_r($reports_query->result());die;
				return $reports_query->result();
			}
			else  return false;
		}
		
		/*
		 * Function get roll for user
		 * */
		 function get_user_roll(){			 
			 $this->read_db->select('role_id,user_type');
			 $this->read_db->where('role_id > ','1');
			 $this->read_db->where('status ','1');
			 $result =$this->read_db->get('user_roll_type');
			 return $result->result();
		 }
		
		/*
		 * Function for save report status
		 * */
		function save_report_status(){
			$report_id=$this->input->post('report_id');
			$status=$this->input->post('status');
			$issue_id=$this->input->post('issue_id');
			
			$data = array(               
               'issue_to' => $issue_id,
               'issue_status' => $status
            );

			$this->db->where('report_id ',$report_id);
			return $result =$this->db->update('report',$data);			
		}
		
		/**
		* function to get report detail
		**/

		function get_report_detail($post_id,$post_type_id){
			if($post_type_id==1 || $post_id == 4){
				$this->read_db->where('media_id',$post_id);
				$result = $this->read_db->get('media');
				return $result->row()->post_user_id;
			}
			if($post_type_id == 2){
				$this->read_db->where('wall_id',$post_id);
				$result = $this->read_db->get('wall');
				return $result->row()->user_id;
			}
			if($post_type_id == 5){
				$this->read_db->where('comment_id',$post_id);
				$result = $this->read_db->get('users_comments');
				return $result->row()->user_id;
			}
		}
		
		function get_post_content($post_id){
			$this->read_db->where('wall_id',$post_id);
			$this->read_db->select('wall_content');
			$this->read_db->from('wall');
			$result = $this->read_db->get()->row();
			return $result->wall_content;
		}
		
		function spam_request_chg( $report_id ) {
			$data = array(               
               'spam_status' => '1',
            );

			$this->db->where('report_id ',$report_id);
			return $result =$this->db->update('report',$data);			

		}
}
?>
