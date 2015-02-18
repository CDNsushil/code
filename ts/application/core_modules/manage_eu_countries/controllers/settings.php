<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller for CodeIgniter tip files editor.
 *
 * Idea:
 * Keys stored in database only as an information and simple way to communicate between files.
 * Edit translation for existing keys, Add new keys, Same keys for every tip.
 * @version		2.1
 */

class Settings extends MY_Controller{
	function __construct(){
		parent::__construct();
			
		$this->load->helper(array('url','file','language','form')); //load this helpers if youre not doing it in autoload
		$this->load->model(array('model_eucountries','admin_model'));
		$this->load->library(array('session','language/lang_library')); //load libraries if youre not doing it in autoload
		$this->load->language(array('admin_template')); //you can delete it if you have translation for you language
		$this->load->library('admin_template');
		$this->config->load('language_editor');
		$this->head->add_css($this->config->item('default_css').'template.css');
		$this->head->add_css($this->config->item('editable_plugins').'demo_page.css');
		$this->head->add_css($this->config->item('editable_plugins').'demo_table.css');
		$this->head->add_js($this->config->item('editable_plugins').'jquery.dataTables.js');
	}
	
	function index(){
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			$this->eu_country_list();
		}
	}
	
	/**
	 * Get Users list.
	 *
	 * @return void
	 */
	function country_list() {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit : 10;
		$perPage=(!empty($perPage)) ? $perPage : 10;
		$countTotal = $this->model_common->countResult('MasterCountry','countryGroup','EU');
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		
		$countryList = $this->model_eucountries->get_country_listing($pages->limit,$pages->offst);
		if(isset($countryList) && !empty($countryList)){
			$data['countryList'] = $countryList;
		}else {
			$data['countryList'] = '';
		}
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_eu_countries/country_listing_view', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_eu_countries/country_listing', $data);
		}
	}
	
	/**
	* Function to Manage country.
	*/
	public function manage_country($countryId=0)
    { 	
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/* Get country data*/
			$data['countryData'] = $this->model_eucountries->get_country_details($countryId);	
			$this->toad_admin_template->load('toad_admin_template','manage_eu_countries/manage_country',$data);
		}
	}
	
	
	/**
	* Post all country data to edit country page.
	*/
	public function edit_country($countryId)
    { 	
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			$countryData = $this->model_eucountries->get_country_details($countryId);
			foreach($countryData as $row)
			{   
				$countryName = array(
					'name' 		=> 'countryName',
					'id' 		=> 'countryName',
					'type' 		=> 'text',
					'class' 	=> 'textbox width450px required',
					'value' 	=> $row['countryName'],
					);
				
				$countryLocalName = array(
					'name' 		=> 'countryLocalName',
					'id' 		=> 'countryLocalName',
					'type' 		=> 'text',
					'class' 	=> 'textbox width450px required',
					'value' 	=> $row['countryLocalName'],
				);
		
				if($row['status'] == 1)
				{
					$checkStatus = TRUE;
					$checkVal = 1;
				} else {
					$checkStatus = FALSE;
					$checkVal = '';
				}
					
				$status = array(
					'name'        => 'status',
					'class'       => 'checkbox',
					'value'       => $checkVal ,
					'checked'     => $checkStatus,
				);	
						 
				$data = array(			
					'countryName' 			=> $countryName,			
					'countryLocalName' 		=> $countryLocalName,	
					'Status' 				=> $status,	   				
					'countryId'             => $countryId,
				);  
				$this->toad_admin_template->load('toad_admin_template','manage_eu_countries/edit_country',$data);
			}  
		}    
    }
    
    /**
	* Update Country details.
	*/
    public function update_country()
    {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/*Get Post values*/
			$countryId 					= $this->input->post('countryId');
			$data['countryName'] 		= $this->input->post('countryName');
			$data['countryLocalName'] 	= $this->input->post('countryLocalName');
			$data['countryCode']		= $this->input->post('countryCode');
			$data['countryGroup']		= 'EU';
			$data['vatPercentage'] 		= $this->input->post('vatPercentage');
			$data['continentId']		= $this->input->post('continentId');
			if($this->input->post('status') == '1')
			{
				$data['status'] = '1';  
			} else {
				$data['status'] = '0';
			}
			
			/*Insert or Update country*/
			if(isset($countryId) && !empty($countryId)){
				$updateCountry = $this->model_eucountries->update_country($data,$countryId);
			}else{
				$addCountry = $this->model_eucountries->add_country($data);
			}
		}
	}
	
	/**
	* Update Status of Country.
	*/
	function updateCountryStatus()
	{
		$countryId = $this->input->post('countryId');
		$data['status'] = $this->input->post('status');
		
		if(isset($countryId)){
			$updateActiveStatus = $this->model_eucountries->update_country($data,$countryId);
		}else{
			return false;
		}
	}
	
	/*
	 *********************************** 
	 *  This function is used to show eu country grid
	 *********************************** 
	 */ 
	 
	function eu_country_list() {
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$countyListing = $this->model_eucountries->get_country_listing();
		$data['countyListing'] = $countyListing;
		$this->toad_admin_template->load('toad_admin_template','country_listing_new', $data);
	}
	
	/*
	 *********************************** 
	 *  This function is used to update country record
	 *********************************** 
	 */ 
	
	function eu_country_update()
	{
		//Get continent id for Europe
		$contiWhereCondi=array('continent'=>'Europe');
		$euContinentData = getDataFromTabel('MasterContinent','id',  $contiWhereCondi, '','', '', 1 );
		if(isset($euContinentData[0]->id) && !empty($euContinentData[0]->id)){
			$euContinentId = $euContinentData[0]->id;
		}else{
			$euContinentId = '3';
		}
		// This section for update records
		if($this->input->post('countryId'))
		{
			$countryId = $this->input->post('countryId');
			$data['countryName'] = $this->input->post('countryName');
			$data['countryLocalName'] = $this->input->post('countryLocalName');
			$data['countryCode'] = $this->input->post('countryCode');
			$data['vatPercentage'] = $this->input->post('vatPercentage');
			$data['continentId'] = $euContinentId;
			$data['countryGroup'] = 'EU';
			if($this->input->post('status') == '1')
			{
				$data['status'] = '1';  
			} else {
				$data['status'] = '0';
			}
			
			$updateCountry = $this->model_eucountries->update_country($data,$countryId);
			//echo "Record updated.";
		}else
		{
			// This section add new record
			$data['countryName'] = $this->input->post('countryName');
			$data['countryLocalName'] = $this->input->post('countryLocalName');
			$data['countryCode'] = $this->input->post('countryCode');
			$data['vatPercentage'] = $this->input->post('vatPercentage');
			$data['continentId'] = $euContinentId;
			$data['countryGroup'] = 'EU';
			if($this->input->post('status') == '1')
			{
				$data['status'] = '1';  
			} else {
				$data['status'] = '0';
			}
			$addCountry = $this->model_eucountries->add_country($data);
			echo $addCountry;
		}
	}
	
	
	
}
