<?php
/**
 * Chatching admin user content status module Controller Class
 * View (Post,comment etc)
 * @category	Controller
 * @author	CDN Solutions
 */
class Admin_user_content_status extends MX_Controller{
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
		$this->load->model('admin_content_status_model');
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
		$total_posts = $this->admin_content_status_model->get_total_posts();
		$data['total_posts'] = $total_posts;

		$total_comments = $this->admin_content_status_model->get_total_comments();
		$data['total_comments'] = $total_comments;
		
		$total_wall_posts = $this->admin_content_status_model->get_total_wall_posts();
		$data['total_wall_posts'] = $total_wall_posts;
	
		$this->admin_template->load('admin/admin_template','admin_content_status',$data);
	}
		
	

}
/* End of file comment.php */
/* Location: ./application/modules/admin_content_modules/controllers/comment.php */
