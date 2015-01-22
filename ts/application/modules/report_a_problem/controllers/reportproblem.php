<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller for CodeIgniter tip files editor.
 *
 * Idea:
 * Keys stored in database only as an information and simple way to communicate between files.
 * Edit translation for existing keys, Add new keys, Same keys for every tip.
 * @version		2.1
 */


class Reportproblem extends MX_Controller{
	private $data = array();
	private $dirCacheMedia = '';
	private $dirUploadMedia = '';
	private $userId = null;
	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
			
		//Load required Model, Library, language and Helper files
			$load = array(
				'model'		=> 'reportproblem/model_reportproblem',  	
				'language' 	=> 'media'										
			);
			parent::__construct($load);		
		    $this->userId= isLoginUser()?isLoginUser():0;
			// Load  path of css and cache file path
			$this->dirCacheMedia = 'cache/media/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/project/'; 
			$this->data['dirUploadMedia'] = $this->dirUploadMedia; 
			$this->head->add_css($this->config->item('frontend_css').'anythingslider.css');		
			$this->head->add_js($this->config->item('frontend_js').'jquery-gallery-cdn.js');
			$this->load->library('template_front_end');
		
	}

	function index(){
			$this->template_front_end->load('template_front_end','reportproblem/reportproblem_step1','');
	}
	function report_second_step($U=FALSE,$id=FALSE)
	{
		$data['CheckId']=$id;
		$this->template_front_end->load('template_front_end','reportproblem/reportproblem_step2',$data);
	}

		
}

