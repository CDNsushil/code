<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 * Todasquare frontend Controller Class
 *
 *  Manage Frontend Details (Writing & Publishing)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 *
 **/
 
class photographynart extends MX_Controller {
	private $data = array();
	private $dirCacheMedia = '';
	private $dirUploadMedia = '';
	
	private $userId = null;
	private $IndustryId = 0;
	/**
	 * Constructor
	 */
	 
	 function __construct() {
		//Load required Model, Library, language and Helper files
			$load = array(
				'model'		=> 'photographynart/model_photographynart',  	
				'language' 	=> 'media/media',							
				'config'		=>	'media/media'   		
			);
			parent::__construct($load);		
			
			$this->head->add_css($this->config->item('system_css').'frontend.css');
			$this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
			$this->head->add_js($this->config->item('frontend_js').'jquery.anythingslider.js');
			$this->head->add_js($this->config->item('frontend_js').'jquery.tinycarousel.min.js');
			
			//$this->userId= $this->isLoginUser();
			// Load  path of css and cache file path
			$this->dirCacheMedia = ROOTPATH.'cache/photographynart/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/photographynart/'; 
			$this->data['dirUploadMedia'] = $this->dirUploadMedia; 
	}
		
	/**
	 * Index fucntion by default call when Controller initialised
	 *
	 * by default call function for Writing and Publishing project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function frontindex() {
		$this->template->load('frontend','frontindex');
	}
	public function index() {
		$this->template->load('frontend','frontindex');
	}
	
	
}

/* End of file frontend.php */
/* Location: ./application/module/frontend/frontend.php */
