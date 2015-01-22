<?php
/**
 * Chatching admin user content manage module Controller Class
 * Manage (Post,comment,image etc)
 * @category	Controller
 * @author	CDN Solutions
 */
class Admin_manage_user_interest extends MX_Controller{
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
		$this->load->model('admin_manage_user_interest_model');
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
			$interest_type_filter    = $this->input->get('filter_interest_type');
			$perpage             = 10;
			$page                = $this->input->get('per_page');
			$page                = ($page>0?$page:1);

			$result		     = $this->admin_manage_user_interest_model->get_user_interest_data($page,$perpage,$interest_type_filter);

			$all_interest_type	     = $this->admin_manage_user_interest_model->get_all_interest_type();

			$config              = $this->pageing_model->get_config_paging();			
			$config['base_url']  = base_url().'admin_manage_user_interest?filter_post_type='.$interest_type_filter;
			$config['total_rows']= $this->admin_manage_user_interest_model->get_user_interest_data($page,0,$interest_type_filter)->num_rows();
			$config['per_page']  = $perpage;
			$config['uri_segment'] = 4;
			$config['page_query_string'] = TRUE;

			$this->pagination->initialize($config);	
		
	$data['interest_type_filter']     = $interest_type_filter;
	$data['interest_result']         = $result->result();
	$data['all_interest_type'] 	      = $all_interest_type;
	$data['paging']               = $this->pagination->create_links();
	$this->admin_template->load('admin/admin_template','admin_manage_user_interest',$data);
	}
	
	function add_interest(){
		$cat_interest  = $this->input->post('cat_interest');
		$interest_text = $this->input->post('interest_text');
		$status		   = $this->input->post('status');
		$interest_arr  = array('type'=>$cat_interest,'text'=>$interest_text,'status'=>$status); 
		$res = $this->admin_manage_user_interest_model->add_interest($interest_arr);
		echo $res;die;
		}
  
   function update_interest(){
		$cat_interest  = $this->input->post('cat_interest');
		$interest_text = $this->input->post('interest_text');
		$status		   = $this->input->post('status');
		$id			   = $this->input->post('id');
		$interest_arr  = array('type'=>$cat_interest,'text'=>$interest_text,'status'=>$status); 
		$res = $this->admin_manage_user_interest_model->update_interest($interest_arr,$id);
		echo $res;die;
		}
   
   function delete_interest(){
	   $id = $this->input->post('id');
	   $res = $this->admin_manage_user_interest_model->delete_interest($id);
 	   echo $res;die;
 	   }
 	   
}
/* End of file comment.php */
/* Location: ./application/modules/comment/controllers/comment.php */
