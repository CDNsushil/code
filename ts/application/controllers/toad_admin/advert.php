<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Chatching Advert Controller Class
 * Manage (Advertisements)
 * @category	Controller
 * @author		CDN Solutions
 */
class Advert extends MX_Controller {

	/**
	* Constructor
	**/	
	public function __construct(){
		parent::__construct();
		$this->load->helper('admin_session_check_helper');
		// check if admin session exists
		login_check();
		
		date_default_timezone_set('Asia/Calcutta');
		$language = 'english';
		if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}
		$this->load->model('advert_model');
		$this->load->language('admin_template');
		$this->load->library('admin_template');
	}
	
	/**
	 * Function to display list of advertisements 
	 **/
	
	function index()
	{
		$template_data['result'] = $this->advert_model->get_advert_list();
		$this->admin_template->load('admin/admin_template','admin/advert/advert_list',$template_data);
	}
	
	function advert_add()
	{
		$data['advert_positions_query'] = $this->advert_model->get_advert_positions();
		$data['advert_pages_query'] = $this->advert_model->get_advert_pages();
		if($this->input->post())
		{
			$this->form_validation->set_rules('advert_title', 'Ad title', 'trim|required');
			$this->form_validation->set_rules('advert_code', 'Ad code', 'trim|required');
			$this->form_validation->set_rules('advert_positions', 'Ad positions', 'trim|required');
			$this->form_validation->set_rules('advert_page', 'Ad display page', 'trim|required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->template->load('admin/admin_template','admin/advert/advert_add',$data);
			}
			else
			{
				/*
				 * set global xss filter to off while saving intro pages content
				 */
				$this->config->set_item('global_xss_filtering', false);
				//gather posted data
				$advert_title = $this->input->post('advert_title');
				$advert_code = $this->input->post('advert_code');
				$advert_page = $this->input->post('advert_page');
				$advert_positions = $this->input->post('advert_positions');
			
				$advert_arr = array(
					"advert_title" => $advert_title, 
					"advert_code" => $advert_code,
					"user_id"	=> 1,
					"user_role"	=> 1,
					"advert_page_id"	=> $advert_page,
					"advert_position_id"	=> $advert_positions,
					"created_date"	=> date('Y-m-d H:i:s'),
					"updated_date"	=> date('Y-m-d H:i:s')
				);
				
				$this->advert_model->advert_insert($advert_arr);
				/*
				 * set global xss filter to off while saving intro pages content
				 */
				$this->config->set_item('global_xss_filtering', true);
				$this->session->set_flashdata('message',$this->lang->line('advert_inserted'));
				redirect('/admin/advert/', 'location');
			}
		}
		else
		{
			$this->template->load('admin/admin_template', 'admin/advert/advert_add', $data);
		}	
	}
	
	function advert_update($advert_id='')
	{
		$data['advert_positions_query'] = $this->advert_model->get_advert_positions();
		$data['advert_pages_query'] = $this->advert_model->get_advert_pages();

		$data['result'] = $this->advert_model->get_advert_by_id($advert_id);

		if($this->input->post())
		{
			$this->form_validation->set_rules('advert_title', 'Ad title', 'trim|required');
			$this->form_validation->set_rules('advert_code', 'Ad code', 'trim|required');
			$this->form_validation->set_rules('advert_positions', 'Ad positions', 'trim|required');
			$this->form_validation->set_rules('advert_page', 'Ad display page', 'trim|required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->template->load('admin/admin_template','admin/advert/advert_update/',$data);
			}
			else
			{
				//gather posted data
				$advert_id = $this->input->post('advert_id');
				$advert_title = $this->input->post('advert_title');
				$advert_code = $this->input->post('advert_code');
				$advert_page = $this->input->post('advert_page');
				$advert_positions = $this->input->post('advert_positions');

				$advert_arr = array(
					"advert_title" => $advert_title, 
					"advert_code" => $advert_code,
					"advert_page_id"	=> $advert_page,
					"advert_position_id"	=> $advert_positions,
					"updated_date"	=> date('Y-m-d H:i:s')
				);
				
				$this->advert_model->advert_update($advert_arr, $advert_id);
				
				$this->session->set_flashdata('message','Advertisement has been updated successfully.');
				redirect('/admin/advert/', 'location');
			}
		}
		else
		{
			$this->template->load('admin/admin_template', 'admin/advert/advert_update', $data);
		}
	}	
	
	function advert_delete($advert_id='')
	{
		$this->advert_model->advert_delete($advert_id);
		$this->session->set_flashdata('message','Advertisement has been deleted successfully.');
		redirect('/admin/advert/', 'location');
	}
	
}//End of Class Advert
 
/* End of file advert.php */
/* Location: ./application/controllers/admin/advert.php */
