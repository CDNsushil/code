<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  Rajendra
 * @package membership\Controllers
 */
 class Membership extends Public_Controller {
        public function __construct(){
			parent::__construct();
	
		$this->load->library('form_validation');
		$this->load->model('frontend_model');
        $this->load->model('membership_model');
		$this->lang->load('membership');
		$this->load->helper('captcha');
		$this->load->helper('frontend');
		$this->template->append_css('module::membership.css');
		$this->template->append_js('module::membership.js');
		$userId=is_logged_in();
		if(!empty($userId)){
			//check for valid user
			//isMerchantUser();
		}
    }

	function index() {
	
		//get all membership
		$data['memberships']=$this->frontend_model->getMemberships();
		$data['features']=$this->frontend_model->getFeatures();
		$data['selectFeatures']=$this->frontend_model->getAllSelectFeatures();
		
		$this->template
		->build('membership',$data); 
		
		/*$this->template
		->build('test/test',$data); */
	
	}
	

	/*
	 * @Description	:To get selected membership by register user
	 * @param		:post membership id
	 * @return		:details about membership
	*/
	function getSelectMembership()
	{
		$membershipId=$this->input->post('id');
		$features=$this->frontend_model->getFeaturesByMembershipId($membershipId);
		$featureData='';
		$amt=0;
		if(!empty($features)){
			$featureData='<ul class="plan_list">';

			foreach($features as $feature){
				$featureData=$featureData.'<li class="feature_disc">'.$feature->feature_title.'</li>';
				$amt=$feature->membership_price;
			}
			 $featureData=$featureData.'</ul>';
		}
		echo $featureData;
		return true;
	}
	/*
	 * @Description	:To view package details
	 * @param		:
	 * @return		:void
	*/
	function packageview($membershipId='')
	{	
		$membershipId=decode($membershipId);
		// Make sure we found data
		$membershipId or redirect('users/membership');
			
		$data['membershipId']=$membershipId;	
		$features=$this->frontend_model->getFeaturesByMembershipId($membershipId);
		if(!empty($features)){
			foreach($features as $feature){ 
				$data['m_price']=$feature->membership_price;
				break;
			}
		}
		$data['features']=$features;
		$data['memberships']=$this->frontend_model->getMemberships();
		$this->template
			->build('package_view',$data);
	}

	
	function test_email()
	{
		
		
		 $config = Array( 
		  'protocol' => 'smtp', 
		  'smtp_host' => 'mail.cdnsol.com', 
		  'smtp_port' => 25, 
		  'smtp_user' => 'admin@cdnsol.com', 
		  'smtp_pass' => '[NXCzT[3q?8*kd3S4=d$Q6dh', ); 	

		  $this->load->library('email'); 
		  $this->email->from('tosifqureshi@cdnsol.com', 'Tosif');
		  $this->email->to('sushilmishra@cdnsol.com'); 
		  $this->email->subject('Test from Syrecohk'); 
		  $this->email->message('Hello How r u');
		 
		  if (!$this->email->send()) {
			echo "<pre>";
			print_r($this->email->print_debugger());  die;
		  }
		  else {
			echo 'Your e-mail has been sent!';
		  }

	}
    public function membershipForm(){
       $id = $this->input->post('id');
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
        $data['membership']=$membership;
        $data['features']=$this->membership_model->getFeatures();
		$this->load->view('membership_form',$data);
    }
    
    public function saveMembership(){
       $id = $this->input->post('id');
       $post = $this->input->post();
		$this->validateMembershipFormFields();
		if ($post)
		{
			
			$this->form_validation->set_rules($this->validation_rules);
		
			if ($this->form_validation->run())
			{
				if ($success = $this->membership_model->update($id, $post))
				{
					$this->session->set_flashdata('success', sprintf(lang('membership:edit_success'), $this->input->post('membership_title')));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('membership:edit_error'), $this->input->post('membership_title')));
				}
                echo 1;
			}
		}
    }
    
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
				'rules' => 'trim'
			),
			array(
				'field' => 'membership_days',
				'label' => lang('membership:membership_days'),
				'rules' => 'trim|required|'
			)
		);
	}
}
?>
