<?php
/**
 * Chatching admin user content manage module Controller Class
 * Manage (Post,comment,image etc)
 * @category	Controller
 * @author	CDN Solutions
 */
class Admin_manage_content extends MX_Controller{
	/**
	* Constructor
	**/	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$language = 'english';
		if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}
		$this->load->model('admin_manage_content_model');
		$this->load->model('admin_model');
		$this->load->language('admin_template');
		$this->load->library('admin_template');
		$this->load->library('pagination');
		$this->load->library('email');
		$this->load->model('admin_paging/pageing_model'); // Added by lalit - User for get user model
		$this->load->language('app_template'); // Added by lalit
		$this->load->model('comment/comment_model');
		$this->load->helper('common_helper.php');

	
	
	}
	/**
	* index function which called by default
	**/
	function index() {
			$get_user_filter     = $this->input->get('user');
			$post_type_filter    = $this->input->get('filter_post_type');
			$post_type = $this->input->get('type'); 
			$perpage             = 10;
			$page                = $this->input->get('per_page');
			$page                = ($page>0?$page:1);

			$result		     = $this->admin_manage_content_model->get_user_content($page,$perpage,$get_user_filter,$post_type_filter,$post_type);

			$all_users           = $this->admin_model->get_all_users();
			$all_post_type	     = $this->admin_manage_content_model->get_all_post_type();

			$config              = $this->pageing_model->get_config_paging();			
			$config['base_url']  = base_url().'admin_manage_content?user='.$get_user_filter.'&filter_post_type='.$post_type_filter.'&type='.$post_type;
			$config['total_rows']= count($this->admin_manage_content_model->get_user_content($page,0,$get_user_filter,$post_type_filter,$post_type));
			$config['per_page']  = $perpage;
			$config['uri_segment'] = 4;
			$config['page_query_string'] = TRUE;

			$this->pagination->initialize($config);	
		
	$data['post_type_filter']     = $post_type_filter;
	$data['posts_result']         = $result;
	$data['all_users']            = $all_users;
	$data['all_post_type'] 	      = $all_post_type;
	$data['user_filter_name']     = $get_user_filter;
	$data['paging']               = $this->pagination->create_links();
	$this->admin_template->load('admin/admin_template','admin_manage_content',$data);
	}
	
	/***
	* Author: Piyush jain
	* Created : 15-5-2012
	* Function for open posts confirm delete box
	* Params  	
	*/
	function posts_delete_confirm() {
		$post_record_id	=	$this->input->post('post_record_id');
		$table  	=	$this->input->post('table');
		$data		=	array();
		$data['post_record_id']	=  $post_record_id;
		$data['table']	=  $table;
		$tpl 		= $this->load->view('posts_delete_confirm',$data,true);
		echo json_encode(array('tpl'=>$tpl));
	}
	
	/***
	* Author: Piyush jain
	* Created : 15-5-2012
	* Function for disable post
	* Params  	
	*/	
	function disable_post() {
		$post_record_id	=	$this->input->post('post_record_id');
		$table  	=	$this->input->post('table');
		$res 		=	$this->admin_manage_content_model->disable_post(array('status'=>'0'),$post_record_id,$table);
		echo $res;
	}
	

}
/* End of file comment.php */
/* Location: ./application/modules/comment/controllers/comment.php */
