<?php
/**
 * Chatching report Controller Class
 * Manage content reports etc
 * @category	Controller
 * @author		CDN Solutions
 */
class Report extends MX_Controller
{
		//Constructor
		function __construct()
		{
				parent::__construct();
				//Load the report model
				$this->load->model('report_model');
				$this->load->language('wall');
				$this->load->library('email_notification');
		}
		
		function report_form(){
			$data['report_type'] = $this->report_model->get_report_type();
			$data['post_type'] 	 = $this->input->post('post_type');
			$data['post_id']	 = $this->input->post('post_id');	
			$tpl = $this->load->view('report',$data,true);
			echo json_encode(array('tpl'=>$tpl));
		}
		
		function submit(){
			$user_id = $this->session->userdata('user_user_id');
			$post_type_id = $this->input->post('post_type_id');
			$post_id = 	$this->input->post('report_for_id');	
			$new_report['report_type_id'] = $this->input->post('report_type_id');
			$new_report['report_comment'] = $this->input->post('report_comment');
			$new_report['report_for_type']= $post_type_id;
			$new_report['report_for_id']  = $post_id;
			$new_report['user_id']			= $user_id;
			$this->report_model->create_report($new_report);
			$post_user_id = $this->report_model->get_report_detail($post_id,$post_type_id);
			$status = $this->email_notification->get_user_emails($post_user_id,$user_id,'');
			if($status){
				echo 1;	
			}
		}
		
		function report_confirm(){
			$data['post_id'] = $this->input->post('post_id');
			$data['post_type'] = $this->input->post('post_type');
			$tpl = $this->load->view('confirm_report',$data,true);
			echo json_encode(array('tpl'=>$tpl));
		}
		
		function report_success(){
			$tpl = $this->load->view('report_success','',true);
			echo json_encode(array('tpl'=>$tpl));
		}
}

?>