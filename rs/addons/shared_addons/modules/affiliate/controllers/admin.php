<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package :Membership Type
 * @Author  :Rajendra Patidar
 */
 class Admin extends Admin_Controller {
	 
	public function __construct(){
			parent::__construct();
			$this->lang->load('membership');
			$this->load->model('membership_model');

            $this->load->library("pagination");
			$this->load->library('form_validation');
			$this->template
			->append_css('module::membership.css');
	}

	function index($id = 0) {
			
		//get all membership
		$memberships=$this->membership_model->getMemberships();
		//to add pagination 
		$uri=base_url()."admin/membership/index/";
		$config=$this->getPagination(count($memberships),$uri);
	
		$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data["memberships"] = $this->membership_model->getMemberships($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links(); 
		$this->template
		->title($this->module_details['name'], lang('membership:add_title'))
		->build('admin/membership',$data);
	}
	
    /**
	 * @Desc  :  Add new membership type
	 * @Author:  Rajendra patidar
	 * @Return:  Message
	 * @Param :  void
	 */
	public function add()
	{
		//validation for add membershipform
		 $this->validateMembershipFormFields();
	
		$membership = new stdClass();
		if ($_POST)
		{
			 $this->form_validation->set_rules($this->validation_rules);
			
			if ($this->form_validation->run())
			{
				if ($id = $this->membership_model->insert($this->input->post()))
				{
					$this->session->set_flashdata('success', sprintf(lang('membership:add_success'), $this->input->post('membership_title')));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('membership:add_error'), $this->input->post('membership_title')));
				}
				redirect('admin/membership');
			}
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$membership->{$rule['field']} = set_value($rule['field']);
		} 
	
        //get all features
        $data['features']=$this->membership_model->getFeatures();
		$this->template
			->title($this->module_details['name'], lang('member:add_title'))
			->set('membership', $membership)
			->build('admin/add_membership',$data);
	}
	
	
	 /**
	 * @Desc  :  Edit membership type
	 * @Author:  Rajendra patidar
	 * @Return:  Message
	 * @Param :  id
	 */
	public function edit($id = 0)
	{
		$membership = $this->membership_model->get($id);

		// Make sure we found something
		$membership or redirect('admin/groups');

        //validation for edit membershipform
		$this->validateMembershipFormFields();
		
		if ($_POST)
		{
			
			$this->form_validation->set_rules($this->validation_rules);
		
			if ($this->form_validation->run())
			{
				if ($success = $this->membership_model->update($id, $this->input->post()))
				{
				
					$this->session->set_flashdata('success', sprintf(lang('membership:edit_success'), $this->input->post('membership_title')));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('membership:edit_error'), $this->input->post('membership_title')));
				}

				redirect('admin/membership');
			}
		}
        //get Select Features
        $data['selectFeatures']=$this->membership_model->getSelectFeatures(array('membership_id'=>$id));
         //get all features
        $data['features']=$this->membership_model->getFeatures();
		$this->template
			->title(sprintf(lang('membership:edit_title'), $membership->membership_title))
			->set('membership', $membership)
			->build('admin/add_membership',$data);
	}
	
	 /**
	 * @Desc  :  Validation for add membership form fields 
	 * @Author:  Rajendra patidar
	 * @Return:  Message
	 */
	function validateMembershipFormFields()
	{
		 // Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'membership_title',
				'label' => lang('membership:title'),
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'membership_price',
				'label' => lang('membership:price'),
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'membership_status',
				'label' => lang('membership:status'),
				'rules' => ''
			),
			array(
				'field' => 'membership_description',
				'label' => lang('membership:description'),
				'rules' => 'trim|'
			),
			array(
				'field' => 'membership_days',
				'label' => lang('membership:membership_days'),
				'rules' => 'trim|required|'
			)
		);
	}
	 /**
	 * @Desc  :  Manage membership featurs
	 * @Author:  Rajendra patidar
	 * @Return:  void
	 */
	function features()
	{
		$features=$this->membership_model->getFeatures();
		$this->template
			->title(lang('membership:add_featurs'))
			->set('features', $features)
			->build('admin/features');
	}
	/**
	 * @Desc  :  Add membership featurs
	 * @Author:  Rajendra patidar
	 * @Return:  void
	 */
	function addfeature()
	{
	    //features form fields validation
		$this->validateFeatursFormFields();
			
		$features = new stdClass();
         
		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			if ($this->form_validation->run())
			{
				$dd=$this->input->post(); 
			
				if ($id = $this->membership_model->insertFeature($this->input->post()))
				{
					$this->session->set_flashdata('success', sprintf(lang('membership:add_success'), $this->input->post('feature_title')));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('membership:add_error'), $this->input->post('feature_title')));
				}

				redirect('admin/membership/features');
			}
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$features->{$rule['field']} = set_value($rule['field']);
		}   
		
		  $this->template
			->title(lang('membership:add_feature'))
			->set('feature', $features)
			->build('admin/add_feature');
	}
	/**
	 * @Desc  :  Edit membership features
	 * @Author:  Rajendra patidar
	 * @Return:  void
	 */
	public function editfeature($id = 0)
	{
		
		$feature = $this->membership_model->getFeatureData(array('id'=>$id));
		
		// Make sure we found membership data
		$feature or redirect('admin/membership/features');
       
		if ($_POST)
		{
			 
			 //features form fields validation
		     $this->validateFeatursFormFields();
		     
		     $this->form_validation->set_rules($this->validation_rules);
          
			if ($this->form_validation->run())
			{
				
				if ($success = $this->membership_model->updateFeature($id, $this->input->post()))
				{
					// Fire an event. A feature has been updated.
					Events::trigger('feature_updated', $id);
					$this->session->set_flashdata('success', sprintf(lang('membership:edit_success'), $this->input->post('feature_title')));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('membership:edit_error'), $this->input->post('feature_title')));
				}

				redirect('admin/membership/features');
			}
		}
		
		$this->template
			->title($this->module_details['name'], sprintf(lang('groups:edit_title'), $feature->feature_title))
			->set('feature', $feature)
			->build('admin/add_feature');
	}
	 /**
	 * @Desc  :  Validation for add featurs form fields 
	 * @Author:  Rajendra patidar
	 * @Return:  Message
	 */
	function validateFeatursFormFields()
	{
		 // Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'feature_title',
				'label' => lang('membership:title'),
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'feature_description',
				'label' => lang('membership:description'),
				'rules' => 'trim|required|max_length[250]'
			),
			array(
				'field' => 'feature_status',
				'label' => lang('membership:feature_status'),
				'rules' => ''
			),
		
		);
	}
	/**
	 * @Desc  :  Remove feature  
	 * @Author:  Rajendra patidar
	 * @param :  id
	 * @Return:  Message
	 */
	public function deleteFeature($id = 0)
	{
		if ($success = $this->membership_model->deleteFeature($id))
		{
			
			$this->session->set_flashdata('success', lang('membership:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('membership:delete_error'));
		}
		redirect('admin/membership/features');
	}
	/**
	 * @Desc  :  update membership status  
	 * @Author:  Rajendra patidar
	 * @param :  eid(enabled),did(disabled)
	 * @Return:  Message
	 */
	public function membershipStatus($eid = 0)
	{
	    $did=0; 
		if(strpos($eid,'did_') !== false)
		{
			$did= str_replace("did_","",$eid);
		}
       
		if ($success = $this->membership_model->membershipStatus($eid,$did))
		{
			$msg=lang('membership:status_enabled');
			if($eid>0){
				$msg=lang('membership:status_disabled');
			}
			$this->session->set_flashdata('success',$msg);
		}
		else
		{
			$this->session->set_flashdata('error', lang('membership:status_error'));
		}
		redirect('admin/membership');
	}
	/**
	 * @Desc  :  update feature status  
	 * @Author:  Rajendra patidar
	 * @param :  eid(enabled),did(disabled)
	 * @Return:  Message
	 */
	public function featureStatus($eid = 0)
	{
	    $did=0; 
		if(strpos($eid,'did_') !== false)
		{
			$did= str_replace("did_","",$eid);
		}
       
		if ($success = $this->membership_model->featureStatus($eid,$did))
		{
			$msg=lang('membership:feature_enabled');
			if($eid>0){
				$msg=lang('membership:feature_disabled');
			}
			$this->session->set_flashdata('success',$msg);
		}
		else
		{
			$this->session->set_flashdata('error', lang('membership:status_error'));
		}
		redirect('admin/membership/features');
	}
	
	/**
	 * @Desc  :  add pagination in table 
	 * @Author:  Rajendra patidar
	 * @param :  total_rows ,uri
	 * @Return:  Message
	 */
	function getPagination($total_rows,$url)
	{
		$config = array();
		$config["base_url"] = $url;
		$config["total_rows"] = $total_rows;
		$config["per_page"] = 10;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = round($choice);
		$config['use_page_numbers']  = TRUE;
		return $config;
	}
	 
}
?>
