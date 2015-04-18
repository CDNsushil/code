<?php
/**
 * Chatching Admin point page Controller Class
 * Manage Admin point page etc
 * @category	Controller
 * @author		CDN Solutions
 */
class Admin_point_page extends MX_Controller
{
	//Constructor
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$language = 'english';
		if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}
		$this->load->model('admin_model');
		$this->load->model('admin_point_page_model');
		$this->load->language('admin_template');
		$this->load->library('admin_template');
		$this->load->library('pagination');
		$this->load->helper('admin_common_helper');
		$this->load->model('admin_paging/pageing_model'); 
		$this->load->language('app_template'); 
	}
		
	/**
	* Author Lalit
	* Function for point page data 
	* Created date : 3-8-2012	
	**/
	function index() 
	{
	      //---- Check login status  -----
		if($this->login_check())
		{
			/*--------------- Paging configuration ----------------*/
				$config['base_url'] 			= 		BASEURL.'admin_point_page';
				//	$config['total_rows']   = 		$this->admin_model->get_num_invite_report();
				$config['total_rows'] 		= 		10;
				$config['per_page'] 			= 		20;
				$config['uri_segment'] 		= 		4;
				$this->pagination->initialize($config);
			/*--------------- End ----------------*/

				$template_data 					 = 	array();
				$template_data['point_pages']	 = $this->admin_point_page_model->get_point_page($config['per_page'], $this->uri->segment(4));
				$template_data['paging'] 		 =  $this->pagination->create_links();

				$this->admin_template->load('admin/admin_template','admin_point_page',$template_data); 
				//$this->admin_template->load('admin/admin_template','manage_country_stats_list',$template_data); 
		} 
		else 
		{
				redirect('admin/admin'); // redirect if user not login
		}		
		
	}


	/**
	* Function for get form for insert a new page
	*/
	function new_point_page()
	{
		
		   //---- Check login status  -----
		if($this->login_check())
		{
				$template_data 	= 	array();
				if($this->input->post('new')){
			
				/*
				 * set global xss filter to off while saving intro pages content
				 */
				$this->config->set_item('global_xss_filtering', false);
				
				$this->form_validation->set_rules('page_title','page_title','trim|required');
				if ($this->form_validation->run() == TRUE){
					$page_arr =  array(
						'page_title' 	  		=> $this->input->post('page_title'),
						'page_content'			=> $this->input->post('FCKeditor'),
					);
					$result = $this->admin_point_page_model->new_point_page($page_arr);

					/*
					 * set global xss filter to off while saving intro pages content
					 */
					$this->config->set_item('global_xss_filtering', true);
					
					if($result) {
						
					/*------------------------------------------------------------
										Code for Manage admin activities 
					Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
					--------------------- START ----------------------------------*/
						$user_array = $this->session->userdata('session_data');
						$userId    = $user_array['user_id'];

						$module_name 	   = "Point page";
						$module_action    = "Add new"; 
						$module_summary   = $this->input->post('page_title');
						$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
					/*-------------------- END -------------------------------*/							
						
						 $this->session->set_flashdata('edit_success','<span>Success!</span> Page saved Successfully');
						  redirect('admin_point_page');
					 }
				}else{
				$this->admin_template->load('admin/admin_template','point_page_new',$template_data);
				}
			} else {

		
				/*fck editor*/
				$this->load->library('fckeditor');
				$this->fckeditor->ToolbarSets = "MyToolbar";
				$this->fckeditor->BasePath = base_url().'templates/admin_template/fckeditor/';
				$this->fckeditor->Width  = '600';
				$this->fckeditor->Height = '500';
				$this->fckeditor->ToolbarSet = 'Default';
				$this->fckeditor->Value = "";

				$this->admin_template->load('admin/admin_template','point_page_new',$template_data);
		}	
		}	else	{
				redirect('admin/admin'); // redirect if user not login
		}
	}

	/*
	* Function for edit page content
	*/
	function edit_page()
	{
			  //---- Check login status  -----
		if($this->login_check()) {
			
		// If admin save edit form data 
		if($this->input->post('edit'))
		{
			
			/*
				 * set global xss filter to off while saving intro pages content
				 */
				$this->config->set_item('global_xss_filtering', false);
				
				$this->form_validation->set_rules('page_title','page_title','trim|required');
				if ($this->form_validation->run() == TRUE){
					$page_arr =  array(
						'page_title' 	  		=> $this->input->post('page_title'),
						'page_content'			=> $this->input->post('FCKeditor'),
					);
					$result = $this->admin_point_page_model->edit_point_page($page_arr);

					/*
					 * set global xss filter to off while saving intro pages content
					 */
					$this->config->set_item('global_xss_filtering', true);
					
					if($result) {
						
					/*------------------------------------------------------------
										Code for Manage admin activities 
					Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
					--------------------- START ----------------------------------*/
						$user_array = $this->session->userdata('session_data');
						$userId    = $user_array['user_id'];

						$module_name 	   = "Point page";
						$module_action    = "update"; 
						$module_summary   = $this->input->post('page_title');
						$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
					/*-------------------- END -------------------------------*/							
						
						 $this->session->set_flashdata('edit_success','<span>Success!</span> Page edit Successfully');
						  redirect('admin_point_page');
					 }
				}else{
				$this->admin_template->load('admin/admin_template','point_page_new',$template_data);
				}
	
		} else {			
			// If admin want to edit page data 
			
				$edit_id 		= 		$this->uri->segment(3);
	
				// Get page data by page id 				
				$data_set 		= 		$this->admin_point_page_model->getPageData($edit_id);
				
				// Assign page values for display in page form
				$template_data['page_name'] 		= 		$data_set[0]->page_name;
				$template_data['bubble_id'] 		= 		$data_set[0]->bubble_id;
				
				/*fck editor*/
				$this->load->library('fckeditor');
				$this->fckeditor->ToolbarSets 	= "MyToolbar";
				$this->fckeditor->BasePath 		= base_url().'templates/admin_template/fckeditor/';
				$this->fckeditor->Width 			= '600';
				$this->fckeditor->Height 			= '500';
				$this->fckeditor->ToolbarSet 		= 'Default';
				$this->fckeditor->Value 			= $data_set[0]->content;

				// Load template of page data form 
				$this->admin_template->load('admin/admin_template','point_page_edit',$template_data);
			}
	    } else {
	    	// If user not login then redirect 
			redirect('admin/admin');
		}
	}



	function page_delete()
	{
	  //---- Check login status  -----
		if($this->login_check()) {
			$delete_id = $this->uri->segment(3);
			/*--------------------------------------------
			* Common function for delete data 
			* First parameter - delete_id  
			* Second - delete key
			* Third - table name 
			* Fourth - table type 
			---------------------------------------------*/
			$this->admin_model->delete_common($delete_id,'bubble_id',"cc_bubbles",'custom');
			
		 $this->session->set_flashdata('edit_success','<span>Delete!</span> Page Deleted ');
			redirect('admin_point_page');
	    } else {
			redirect('admin/admin');
		}
	}

		
	/**
	* Function to check session for admin login	
	**/
	public function login_check(){
		if($this->session->userdata('session_data')){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * @Input :Null
	 * @Output: Return HTML view for bubbles 
	 * @Access: Public
	 * Comment: Show bubbles for point
	 * Author : Lalit 
	 */
	public function show_bubble()
	{
		$template_data 			= 	array();
		$template_data['msg'] 	= "";
		$step 						= $this->input->post('step');
		
		switch($step)
		{
			case "chatching point":
				 $template_data['page_content'] = $this->admin_point_page_model->getPageData($step);       
			$tpl = $this->load->view('bubble_layout',$template_data,true);
			break;

			case "chatching network":				
			 $template_data['page_content'] = $this->admin_point_page_model->getPageData($step);					
			   $tpl =  $this->load->view('bubble_layout',$template_data,true);
			break;
		}

		echo json_encode(array("tpl1"=>$tpl));
		die;
	}
	
	/**
	* Chatching point page check show again status
	* Param User_id , page name
	* Return boolean	
	*/
	function check_point_status()
	{
		// Get post variables values 
		$userId = $this->input->post('user_id');
		$step 	= $this->input->post('step');
		
	  $status = $this->admin_point_page_model->getPageStatus($userId,$step);

	  
	  if(count($status) > 0 ) {
	  			echo "no"; // no need to display 
	  }  else  {
	  	 echo "yes"; // Need to show
	  }
		die;
	}	
	
	
	function update_point_page()
	{
		$userId = $this->session->userdata('user_user_id');
		$step = $this->input->post('step');
		$status = $this->admin_point_page_model->update_point_page($userId,$step);
		die;
	}	
}
?>
