<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller for CodeIgniter tip files editor.
 *
 * Idea:
 * Keys stored in database only as an information and simple way to communicate between files.
 * Edit translation for existing keys, Add new keys, Same keys for every tip.
 * @version		2.1
 */


class Tips extends MY_Controller{

	function __construct(){
		parent::__construct();
			
		$this->load->helper(array('url','file','language','form')); //load this helpers if youre not doing it in autoload
		$this->load->model(array('model_tips','admin_model'));
		$this->load->library(array('session','language/lang_library')); //load libraries if youre not doing it in autoload
		$this->load->language(array('admin_template','tip')); //you can delete it if you have translation for you language
		$this->load->library('admin_template');
		$this->head->add_css($this->config->item('system_css').'frontend.css');
		$this->head->add_css($this->config->item('system_css').'tips_front.css');
		$this->config->load('language_editor');
		//$this->head->add_js($this->config->item('system_js').'jquery-plugin/niceditor/nicEdit.js');
	}

	function index(){
		if(!$this->lang_library->login_check()){
		redirect('toad_admin/toad_admin');
		}else{
			$this->tips_list();
		}
	}

	/**
	 * Get tips list.
	 *
	 * @return void
	 */
	function tips_list($id=FALSE) {
		
		if($id===FALSE)
		{
			$topDescription = $this->model_tips->get_top_tip();
			if(!empty($topDescription)){
				$data['topDescription'] = $topDescription;
			}else {
				$data['topDescription'] = '';
			}
			$tips = $this->model_tips->get_tips();
			if(!empty($tips)){
				$data['tips'] = $tips;
			}else {
				$data['tips'] = '';
			}
			$this->admin_template->load('admin/admin_template','tips/tip_list', $data);
		}
		else
		{  
			$tips = $this->model_tips->get_tips();
			if(!empty($tips)){
				$data['tips'] = $tips;
			}else {
				$data['tips'] = '';
			}
			$description = $this->model_tips->get_description($id);
			if(!empty($description)){
				$data['description'] = $description;
			}else {
				$data['description'] = '';
			}
			$data['titleId'] = $id;
			$this->admin_template->load('admin/admin_template','tips/tip_list', $data);
		}
	}
	
	/**
	* Post all fields to create tip page.
	*/
	public function add_tip() {	
				
			/**
			* Build the form fields.
			**/	
			$title = array(			
				'name' 				=> 'title',
				'id' 				=> 'title',
				'type' 				=> 'text',
				'class' 			=> 'textbox width450px',
			);			 		
			
			$subtitle = array(			
				'name' 				=> 'subtitle',
				'id' 				=> 'subtitle',
				'type' 				=> 'text',
				'class' 			=> 'textbox width450px',
			);							 		
	
			$description = array(			
				'name' 				=> 'description',			
				'id' 				=> 'description',	
				'size'				=> 30,
				'cols'				=> 70,
				'rows'				=> 20,
				'class'      		=> 'formTip textarea  frm_Bdr required'
			);
			
			$status = array(
				'name'        => 'status',
				'class'       => 'checkbox',
				'value'       => '1',
				'checked'     => FALSE,
			);	

			/**
			* Construct the data array for the page
			**/
			$data = array(				
				'Title' 				=> $title,		
				'Subtitle'				=> $subtitle,
				'Description' 			=> $description,	
				'Status' 				=> $status,	
				'errorMessageTitle' 	=> $this->errorTitle,
				'Error' 				=> $this->Error,
				'successMessageTitle' 	=> $this->messageTitle,
				'Message' 				=> $this->Message,		
                'navigation'            => $this->build_navigation(),
               
			);			

			/**
			* Send data to create tip page
			**/
			$this->admin_template->load('admin/admin_template','tips/add_tip',$data);		
	}
	
	/**
	* Submit tip to db.
	*/
	function submit_tip()
	{
		/**
		* Tip insert to db.
		**/	
		if($this->input->post('title')!='' && $this->input->post('subtitle')!='')
		{
			$this->model_tips->submit_tips();	
			$this->session->set_flashdata('msg',$this->lang->line('messageTipAdd'));
			redirect("tips/tips_list");
		} else {
			$this->session->set_flashdata('error',$this->lang->line('tipAddError'));
			redirect("tips/add_tip");
		}
		
	}
	
	/**
	* Post all tip data to edit tip page.
	*/
	public function edit_tip($tipId)
    { 	
        $tips = $this->model_tips->get_tip($tipId);
        foreach($tips as $row)
        {   
			$title = array(
				'name' 		=> 'title',
				'id' 		=> 'title',
				'type' 		=> 'text',
				'class' 	=> 'textbox width450px',
				'value' 	=> $row['title'],
				);
			
			$subtitle = array(
				'name' 		=> 'subtitle',
				'id' 		=> 'subtitle',
				'type' 		=> 'text',
				'class' 	=> 'textbox width450px',
				'value' 	=> $row['subtitle'],
			);
			
			$description = array(			
				'name' 		=> 'description',			
				'id' 		=> 'description',	
				'size'		=> 30,
				'cols'		=> 70,
				'rows'		=> 20,
				'class'     => 'formTip textarea  frm_Bdr required',
				'value' 	=> $row['description'],
			);
				
			if($row['status'] == 't')
			{
				$status = TRUE;
			} else {
				$status = FALSE;
			}
                
			$status = array(
				'name'        => 'status',
				'class'       => 'checkbox',
				'value'       => '1',
				'checked'     => $status,
			);	
				     
            $data = array(			
				'Title' 				=> $title,			
				'Subtitle' 				=> $subtitle,	
				'Description' 			=> $description,
				'Status' 				=> $status,	   				
				'errorMessageTitle' 	=> $this->errorTitle,
				'Error' 				=> $this->Error,
				'successMessageTitle' 	=> $this->messageTitle,
				'Message' 				=> $this->Message,		
				'navigation'            => $this->build_navigation(),
				'tipId'             	=> $tipId,
			);
                
            $this->admin_template->load('admin/admin_template','tips/edit_tip',$data);
		}      
    }
    
    /**
	* Update selected tip.
	*/
    public function update_tip($tipId=FALSE)
    {
		if($this->input->post('title')!='' && $this->input->post('subtitle')!='')
		{
		if($this->input->post('status') == '1')
		{
			$status = '1';  
		} else {
			$status = '0';
		}
		$tip_data = array(
			'title' 		=> $this->input->post('title'),
			'subtitle'  	=> $this->input->post('subtitle'),
			'description'  	=> $this->input->post('description'),
			'status'  		=> $status,
		);
	  
		$this->db->where('id', $tipId);
		$this->db->update('Tips', $tip_data);
		$this->session->set_flashdata('msg',$this->lang->line('messageTipUpdated'));
		redirect('tips/tips_list/'.$tipId);
		} else {
			$this->session->set_flashdata('error',$this->lang->line('tipAddError'));
			redirect('tips/edit_tip/'.$tipId);
		}
	}
	
	/**
	* Remove selected tip.
	*/
	public function delete_tip($titleId)
    {
		if($this->model_tips->remove_tip($titleId))
		{
			$this->session->set_flashdata('msg',$this->lang->line('messageTipDelete'));
			redirect('tips');
		}
		else{
			$this->session->set_flashdata('msg',$this->lang->line('messageTipNotDelete'));
			redirect('tips');
		}
	}
	
	/**
	* Arrange tip listing order.
	*/
	function update_tip_order()
	{
		
		$updateRecordsArray = $this->input->post('recordsArray');
		$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue) {
			$tip_data = array(
		    'priority' 		=> $listingCounter,
		  	);
		  
		$this->db->where('id', $recordIDValue);
		$this->db->update('Tips', $tip_data);
		$listingCounter = $listingCounter + 1;	
		}
		
	}
	
	/**
	* Get & Display tip listing to front end.
	*/
	function front_tips($id=FALSE)
	{
		if($id===FALSE)
		{
			$topDescription = $this->model_tips->get_top_tip();
			if(!empty($topDescription)){
				$data['topDescription'] = $topDescription;
				$data['titleId']        = (!empty($topDescription[0]['id']))?$topDescription[0]['id']:'0';
			}else {
				$data['topDescription'] = '';
			}
			
			$tips = $this->model_tips->get_front_tips();
           
			if(!empty($tips)){
				$data['tips'] = $tips;
			}else {
				$data['tips'] = '';
			}
			$this->new_version->load('new_version','front_tips', $data);
		}
		else
		{   
			$tips = $this->model_tips->get_front_tips();
			if(!empty($tips)){
				$data['tips'] = $tips;
			}else {
				$data['tips'] = '';
			}
			
			$description = $this->model_tips->get_front_description($id);
			if(!empty($description)){
				$data['description'] = $description;
			}else {
				$data['description'] = '';
			}
			$data['titleId'] = $id;
			$this->new_version->load('new_version','front_tips', $data);
		}
		
	}
	
	function get_tip_data(){
		
		 $d = $this->input->post('tips_ids');
		echo $d;
		die;
	}
		
}

