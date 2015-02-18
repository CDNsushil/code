<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Todasquare frontend Controller Class
 *
 *  manage frontend details (Film & Video, Music & Audio, Photography & Art,
 *	 Writing & publishing, Education Material)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class frontend extends MX_Controller {
	private $data = array();
	/**
	 * Constructor
	 */
	function __construct() {
		//Load required Model, Library, language and Helper files
			$load = array(
				'library' 	=> 'form_validation',			 	
				'helper' 	=> 'form + file' 		
			);
			parent::__construct($load);
		
		$this->head->add_css($this->config->item('system_css').'frontend.css');
	}
/*============================Film and Video Section==================================================*/	
	/**
	 * Index fucntion by default call when Controller initialised
	 *
	 * by default call function for film & Video project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function index() {
		$this->template->load('template','frontend',$this->data);	
	}
}

/* End of file frontend.php */
/* Location: ./application/module/frontend/frontend.php */
