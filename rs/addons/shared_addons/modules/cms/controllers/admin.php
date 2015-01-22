<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package :Membership Type
 * @Author  :Rajendra Patidar
 */
 class Admin extends Admin_Controller {
	 
	protected $section = 'cms';
	protected $data = array(
        'cms' =>  array(
			'id' => 0,
			'title' => '',
			'description' => '',
			'status' => 1,
		)
    );
    
    private $validation_rules = array(
		'title' => array(
			'field' => 'title',
			'label' => 'lang:cms:title',
			'rules' => 'required'
		),
		'description' => array(
			'field' => 'description',
			'label' => 'lang:cms:content',
			'rules' => 'required'
		),
		'status' => array(
			'field' => 'status',
			'label' => 'lang:cms:status',
			'rules' => ''
		)
	);
    
    public function __construct(){
			parent::__construct();
			$this->lang->load('cms');
			$this->load->model('admin_model');
			$this->load->library('form_validation');
            $this->template->append_css('module::cms.css');
			
	}

 /**
	 * @Desc  :  get all paid unpaid cms
	 * @Author:  Rajendra patidar
	 * @Return:  array of cms
	 * @Param :  pay status
	 */
	function index() {
		
		$page=0;
		$userId=is_logged_in();
		//get all cms
		$countResult=$this->common_model->countResult('blocks');
		//to add pagination 
		$uri=base_url()."admin/cms/index?";
		$config=$this->common_model->getPagination($countResult,$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}
		$data["links"] = $this->pagination->create_links(); 
		$data['cms']=$this->admin_model->getBlocks($config["per_page"], $page);
		$this->template->build('index',$data);	
	}
    
    public function create()
	{
		$this->template
			->title($this->module_details['name'], lang('cms:add_cms'))
            ->append_metadata($this->load->view('fragments/wysiwyg', array() , true))
			->build('form',$this->data);
	}
    
    public function save()
	{
        $post = $this->input->post();
        
        echo "<pre>";
        print_r($post);
    }

	/**
	 * Edit an existing user
	 *
	 * @param int $id The id of the user.
	 */
	public function edit($id = 0)
	{
		
		$userDetails='';
		// Get the user's data
		$userData=$this->common_model->getDataFromTabel('users','*',array('id'=>$id));
		if(!empty($userData)){
			$userDetails=$userData[0];
		}
		//$this->ion_auth->get_user($id)
		if ( ! ($member =$userDetails))
		{
			$this->session->set_flashdata('error', lang('user:edit_user_not_found_error'));
			redirect('admin/users');
		}
		
		// Check to see if we are changing emails
		/*if ($member->email != $this->input->post('email'))
		{
			$this->validation_rules['email']['rules'] .= '|callback__email_check';
		}
		 */

		// Get the profile fields validation array from streams
		$this->load->driver('Streams');
		$validation=$this->setUserFormValidation();
		$profile_validation = $this->streams->streams->validation_array('profiles', 'users', 'edit', array(), $id);

		// Set the validation rules
		$this->form_validation->set_rules(array_merge($validation, $profile_validation));

		// Get user profile data. This will be passed to our
		// streams insert_entry data in the model.
		$assignments = $this->streams->streams->get_assignments('profiles', 'users');
		$profile_data = array();

		foreach ($assignments as $assign)
		{
			if (isset($_POST[$assign->field_slug]))
			{
				$profile_data[$assign->field_slug] = $this->input->post($assign->field_slug);
			}
			elseif (isset($member->{$assign->field_slug}))
			{
				$profile_data[$assign->field_slug] = $member->{$assign->field_slug};
			}
		}

		if ($this->form_validation->run() === true)
		{
			
			// Get the POST data
			//$update_data['email'] = $this->input->post('email');
			$update_data['first_name'] = $this->input->post('first_name');
			$update_data['last_name'] = $this->input->post('last_name');
			$update_data['phone'] = $this->input->post('phone');
			$update_data['email'] = $this->input->post('email');
			$update_data['company'] = $this->input->post('company');
			$update_data['group_id'] = $this->input->post('group_id');
			$update_data['domain_name'] = $this->input->post('domain_name');
			$update_data['membership_type'] = $this->input->post('membership_type');
			$update_data['sex'] = $this->input->post('sex');
			$update_data['date_of_birth'] = $this->input->post('date_of_birth');
			
			$update_data['address'] = $this->input->post('address');
		
			$update_data['active'] = $this->input->post('active');
			
			if($this->input->post('active')=='2'){
				$update_data['active']='1';
			}
			$update_data['user_block'] = $this->input->post('user_block');
	
			//$update_data['username'] = $this->input->post('username');
			// allow them to update their one group but keep users with user editing privileges from escalating their accounts to admin
			$update_data['group_id'] = ($this->current_user->group !== 'admin' and $this->input->post('group_id') == 1) ? $member->group_id : $this->input->post('group_id');
			
		
			// Grab the profile data
		/*	foreach ($assignments as $assign)
			{
				$update_data[$assign->field_slug] = $this->input->post($assign->field_slug);
			}

			// Some stream fields need $_POST as well.
			$update_data = array_merge($profile_data, $_POST);
			*/

			// We need to manually do display_name
			$update_data['first_name'] = $this->input->post('first_name');

			// Password provided, hash it for storage
			if($this->input->post('password'))
			{
				$update_data['password'] = $this->input->post('password');
			}
			
			$subject=lang('user:block_sub');
			$msg=lang('user:block_msg');
			
			if ($this->ion_auth->update_user($id, $update_data))
			{

				$preBlockStatus=$userDetails->user_block;
				$blockStatus=$this->input->post('user_block');
				
				$preActiveStatus=$userDetails->active;
				$activeStatus=$this->input->post('active');
				
				if($preActiveStatus!=$activeStatus){
					if($activeStatus==2){
						
						$subject=lang('user:active_sub');
						$msg=lang('user:active_msg');
					}
				}
				
				if($preBlockStatus!=$blockStatus){
					
					if($blockStatus==0){
						
						$subject=lang('user:unblock_sub');
						$msg=lang('user:unblock_msg');
					}
				}
				
				if($preBlockStatus!=$blockStatus || $preActiveStatus!=$activeStatus){
				
					if($preBlockStatus==$blockStatus && $activeStatus!=2){
					
						$subject=lang('user:unactive_sub');
						$msg=lang('user:unactive_msg');
					}
					else if($blockStatus!='1' || $activeStatus!='2'){
				
						$adminEmail=getAdminEmail();
						$siteurl=base_url();
						$fromName=$this->config->item('email_from_name');
						
						$to=$this->input->post('email');
		
						$emailData = array(
						'email_template'=>'activate_template',
						'name'=>$this->input->post('first_name'),
						'activation_url'=>$siteurl,
						'msg'=>$msg,
						'contactEmail'=>$adminEmail,
						'title'=>$subject,
						); 
						
						//function to send mail
						$this->user_m->sendMail($from, $to, $subject,$emailData,$fromName);
					}
				}
				

				$this->session->set_flashdata('success', $this->ion_auth->messages());
			}
			else
			{
				$this->session->set_flashdata('error', $this->ion_auth->errors());
			}

			// Redirect back to the form or main page
			$this->input->post('btnAction') === 'save_exit' ? redirect('admin/users') : redirect('admin/users/edit/'.$id);
		}
		else
		{
			// Dirty hack that fixes the issue of having to re-add all data upon an error
			if ($_POST)
			{
				$member = (object) $_POST;
			}
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== null)
			{
				$member->{$rule['field']} = set_value($rule['field']);
			}
		}

		// We need the profile ID to pass to get_stream_fields.
		// This theoretically could be different from the actual user id.
		if ($id)
		{
			$profile_id = $this->db->limit(1)->select('id')->where('user_id', $id)->get('profiles')->row()->id;
		}
		else
		{
			$profile_id = null;
		}

		$stream_fields = $this->streams_m->get_stream_fields($this->streams_m->get_stream_id_from_slug('profiles', 'users'));

		$profile = $this->db->limit(1)->where('user_id', $id)->get('profiles')->row();

		// Set Values
		$values = $this->fields->set_values($stream_fields, $profile, 'edit');

		// Run stream field events
		$this->fields->run_field_events($stream_fields, array(), $values);
	
		//get membership data
		$data['memberships']=$this->user_m->getMemberships();
		
		$this->template
			->title($this->module_details['name'], sprintf(lang('user:edit_title'), $member->first_name))
			->set('member', $member)
			->build('admin/form',$data);
	}
    
    
	 
 
}
?>
