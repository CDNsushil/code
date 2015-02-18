<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Todasquare imagegallery Controller Class
 *
 *  Manage imagegallery Functionality
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */

Class imagegallery extends MX_Controller {
	
	/**
	 * Constructor
	 */
	function __construct(){
	$this->load->helper('url');
	parent::__construct(); 		
	}
	
	function index()
	{	
		$this->load->view('index');				
	}
	
	function file_details($file)
	{	
		$data['imagename'] = $file;
		$this->load->view('file_details',$data);	
				
	}
	function file_upload()
	{	
		$this->load->view('file_upload');	
				
	}
	function jqueryFileTree()
	{	
		$this->load->view('jqueryFileTree');	
				
	}
}