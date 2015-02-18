<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends MY_Controller{
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->language('categories');
		$this->load->model('categories_m');
	}
	
	//-------------------------------------------------------------------------
	
	/**
	 * Show all the categories of forum type
	 * 
	 */ 
	
	public function index()
	{				
		$data['categories'] = $this->categories_m->get_categories('forums');	
		$this->load->view('categories', $data);		
	}
	
	//-------------------------------------------------------------------------
	
	/**
	 * Show all the categories of help type
	 * 
	 */ 
	
	public function helpcategories()
	{				
		$data['categories'] = $this->categories_m->get_categories('help');	
		$this->load->view('categories_help', $data);		
	}
	
	
}
