<?php

class Admin_message extends MX_Controller{

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$language = 'english';
		if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}
		// Loading necessary models
		$this->load->model('admin_message_model');	
		//$this->load->helper('common');			
		$this->load->language('admin_template');
		$this->load->library('admin_template');			
		$this->load->library('plupload');	
		$this->load->library('pagination');
		$this->load->language('wall');	
		
	}
	
	function index()
	{
		$this->messages();
	}
	
	function messageDetail()
	{				
		$msg_id=$this->uri->segment(3);
		$data['message']=$this->admin_message_model->getmessage($msg_id);
		$this->admin_template->load('admin/admin_template','admin/message/messageDetail',$data);
	}
	
	
	function messages()
	{
		
		$page=$this->uri->segment(3);
		$perPage =10;
		$userId=$this->uri->segment(4);
		$searchTxt =$this->input->post('searchTxt');
		
		$messages=array();
		
		$page = ($page==""?1:$page);
				
		$messages=$this->admin_message_model->getmessages($page,$perPage,$userId,$searchTxt);
		
		/*---------- Start pagging-------------------*/
			$config['base_url'] = base_url().'/admin_message/messages/';
			$config['total_rows'] = count($this->admin_message_model->getmessages('','',$userId,$searchTxt));
			$config['per_page'] = $perPage;
			$config['uri_segment'] = 3;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="page"><a>';
			$config['cur_tag_close'] = '</a></li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_link'] = '>>';
			$config['first_link'] = '<<';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$this->pagination->initialize($config);
		/*---------- end pagging-------------------*/
		
		$data['pagging'] = $this->pagination->create_links();
		
				
		$data['userId']=$userId;		
		$data['page']=$page;		
		$data['messages']=$messages;
		$data['searchTxt']=$searchTxt;
		$this->admin_template->load('admin/admin_template','admin/message/list',$data);
		
	}
	
	
	function composeFile(){
		$data=array();
		//$this->profile_template->load('profile_includes/profile_template','profile_includes/composeFile',$data);
		$this->load->view('composeFile', $data);
	}
	
	/**
	* Function to upload attachment
	**/
	function upload()
    {		
        echo $this->plupload->process_upload($_REQUEST,$_FILES,4);
    }
    
    function deleteMessage(){
		$id=$this->input->post('msgId');
		if($id >0 ){
			echo $result= $this->admin_message_model->deleteMessage($id);
		}
	}
	
	
	/*
	 * Function for search friend list for send message
	 * */
	function searchFriend($searchText){
		$data['limit']=7;
		$data['searchText']=$searchText;
		$data['userInfo']=$this->admin_message_model->search_friend_info($searchText,$data['limit']);
		echo $this->load->view('search_friend_list',$data,true);
		die;
	}
	
	/*
	 * Function for create message
	 * */
	function createMessage(){
		$data =array();
		echo $this->load->view('profile_includes/message/compose',$data,true);
		die;
	}
	
	
	/**
	* function to open confirm box for comment delete
	**/
	function message_delete_confirm(){
			$data['msg_id'] = $this->input->post('msg_id');			
			$tpl = $this->load->view('confirm_message_delete',$data,true);
			echo json_encode(array('tpl'=>$tpl));
	}
}

/* End of file companies.php */
/* Location: ./system/application/controllers/companies.php */
?>
