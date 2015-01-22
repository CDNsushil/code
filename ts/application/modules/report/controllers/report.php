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
        loginCheck();
        //Load the report model
        $this->load->model('report_model');
        $this->load->language('wall');
        $this->load->library('email_notification');
    }

    /*
     * Function to store report, reported by user
     * */
    function submit(){
        isAjax();
        $user_id      = $this->session->userdata('user_user_id');
        $post_type_id = $this->input->post('post_type_id');
        $post_id      = $this->input->post('report_for_id');	
        $report_comment = $this->input->post('report_comment');
        $report_type_id = $this->input->post('report_type_id');
        $new_report['report_type_id'] = $report_type_id;
        $new_report['report_comment'] = $report_comment;
        $new_report['report_for_type']= $post_type_id;
        $new_report['report_for_id']  = $post_id;
        $new_report['user_id']		  = $user_id;
        $this->report_model->create_report($new_report);
        $post_user_id = $this->report_model->get_report_detail($post_id,$post_type_id);
        $post_content = '';
        if($post_type_id==2){
            $post_content = $this->get_post($post_id);
        }
        $status = $this->email_notification->get_user_emails($post_user_id,$user_id,'report',$post_content);
        if($status){
            echo 1;	
        }
    }

	/*
     * Function to store report, reported by user
     **/	
    function report_confirm(){
        isAjax();
        $data['post_id']        = $this->input->post('post_id');
        $data['report_type_id'] = $this->input->post('report_type_id');
        $tpl = $this->load->view('confirm_report',$data,true);
        echo json_encode(array('tpl'=>$tpl));
    }

    /*
     * Function to display report suucess message
     **/
    function report_success(){
        isAjax();
        $tpl = $this->load->view('report_success','',true);
        echo json_encode(array('tpl'=>$tpl));
    }

    private function get_post($post_id){
        return $this->report_model->get_post_content($post_id);	
    }
    
	/*
     * function to update the status of the report
     **/	
	function update_report_status(){
		$data=array();
		$data['report_id']=$this->input->post('report_id');
		$loggedData=$this->session->userdata('session_data');
		$data['logged_user_role']= $loggedData['user_role']; 
		$data['report_info']=$this->report_model->get_report_list($data['report_id']);
		$data['user_roll']=$this->report_model->get_user_roll();
		$list_tpl = $this->load->view('update_report_status',$data,true);
		echo json_encode(array('tpl'=>$list_tpl));
	}

	function update_report(){
		echo $data['user_roll']=$this->report_model->save_report_status();
	}
	
	function index(){
		$data['report_type'] = $this->report_model->get_report_type();		
		$this->load->view('report',$data);		
	}
	
	function spam_request()
	{
		$data=array();
		$report_id=$this->input->post('report_id');
		$this->report_model->spam_request_chg($report_id);
	//	echo json_encode(array('tpl'=>$list_tpl));
		echo "Hidden";		
		die;
	}
}

?>
