<?php  //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*	@Class: MY_Exceptions
*	@Author: Anoop Singh
*	@Email: anoop.immortal@gmail.com
*	@Version: 1.0
*/
class MY_Exceptions extends CI_Exceptions {
 
	/*
	* @Method: __construct()
	* @params: return void 
	*/
    public $ci;
	public function __construct()
	{
		parent::__construct();
        $this->ci =& get_instance();
	}
 
	/*
	* @Method: show_php_error()
	* @params: $severity as String
	* @params: $message as String
	* @params: $filepath as String
	* @params: $line as String
	*/
	public function show_php_error($severity, $message, $filepath, $line)
	{	
		$severity = ( ! isset($this->levels[$severity])) ? $severity : $this->levels[$severity];
        $pos = strpos($severity, 'Undefined');
        if ($pos !== false) {
           return;
        } 
		$filepath = str_replace("\\", "/", $filepath);
		// For safety reasons we do not show the full file path
		if (FALSE !== strpos($filepath, '/'))
		{
			$x = explode('/', $filepath);
			$filepath = $x[count($x)-2].'/'.end($x);
		}
		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();	
		}
		
		ob_start();
		@include(APPPATH.'errors/error_php'.EXT);
		$buffer = ob_get_contents();
		ob_end_clean();
		$msg = 'Severity: '.$severity.' --> '.$message. ' '.$filepath.' '.$line;
		log_message('ERROR: ', $msg , TRUE);
		
		if(ENVIRONMENT != 'development' ){
			//redirect($this->ci->config->item('error-capture'));
		}else{
			echo $msg;
		}
		
		//exit();
       return;
		
	}/// --- FEND::show_php_error() ---
}
/* End of file MY_Exceptions.php */
/* Location: ./application/core/MY_Exceptions.php */	
