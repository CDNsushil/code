<?php  //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*	@Class: Exception Handler
*	@Author: Anoop Singh
*	@Email: anoop.immortal@gmail.com
*	@Version: 1.0
*	@Usage: 	Put this is config file before using:
				$config["error-capture"]="path/to/error/handler/controller/"
				Configure HOOK for exception handling:
				$hook['post_controller_constructor'][] = array(
                   'class'    => 'ExceptionHook',
                   'function' => 'SetExceptionHandler',
                   'filename' => 'ExceptionHook.php',
                   'filepath' => 'hooks'
                  );
*/ 

class ExceptionHook
{
	/// --- CI core class Object ---
	public $ci="";
	
	/*
	* @Method: __construct()
	* @params: return void 
	*/
	public function __construct(){
		
		$this->ci=&get_instance();
		$this->ci->load->library("email");
		//,"perminder@cdnsol.com"
		$this->ci->email->to(array("sushilmishra@cdnsol.com","lokendrameena@cdnsol.com","tosifqureshi@cdnsol.com","amitneema@cdnsol.com"));
		$this->ci->email->from("noreply@toadsquare.com","Toadsquare Error");
		
	}/// --- FEND::__construct() ---
	
	/*
	* @Method: SetExceptionHandler()
	* @params: void 
	* @return: null
	*/
	public function SetExceptionHandler()
	{
		/// --- handling of internal exceptions by triggering errors and handling them with a user defined function ---
		set_error_handler('myErrorHandler');
		
		/// --- handling of Sets a user-defined exception handler function ---
		set_exception_handler(array($this, 'HandleExceptions'));
		
		/// --- handling of internal Break down by triggering errors and handling them with function ---
		register_shutdown_function('handleShutdown');
		
	}/// --- FEND::SetExceptionHandler() ---
	
	
	/*
	* @Method: HandleExceptions($exception)
	* @params: $exception as Object
	* @return: Void
	*/
	public function HandleExceptions($exception)
	{
		$msg ='Eroor Handler: Exception of type \''.get_class($exception).'\' occurred with Message: '.$exception->getMessage().' in File '.$exception->getFile().' at Line '.$exception->getLine();
		$msg .="\r\n Backtrace \r\n";
		$msg .=$exception->getTraceAsString();
		log_message('error', $msg, TRUE);
		$this->ci->email->subject("Toadsquare Error Occured!!".date("d-M-Y h:i:s"));
		$this->ci->email->message($msg);
        
        log_message('ERROR', $msg, TRUE);
		if(ENVIRONMENT != 'development' ){
				$this->ci->email->send();
		}else{
			echo $msg;
		}
        
		
		# from /error-capture, you can use another redirect, to e.g. home page
		if(ENVIRONMENT !='development'){
			//redirect($this->ci->config->item('error-capture'));
		}
        //exit();
		return;
	}/// --- FEND::HandleExceptions($exception) ---
}

	/*
	* @Function: handleShutdown()
	* @params: void 
	* @return: null
	*/
	function handleShutdown()
	{
		$ci=&get_instance();
		$ci->load->library("email");
		//,"perminder@cdnsol.com"
		$ci->email->to(array("sushilmishra@cdnsol.com","lokendrameena@cdnsol.com","tosifqureshi@cdnsol.com","amitneema@cdnsol.com"));
		$ci->email->from("noreply@toadsquare.com","Toadsquare Error");
        
        $error = error_get_last();
		if ($error && isset($error['message']) && !empty($error['message'])) {
            $buffer = ob_get_contents();
			ob_clean();
            
            $pos = strpos($error['message'], 'Undefined');
            if ($pos !== false) {
              return;
            } 
            $pos = strpos($error['message'], 'already loaded');
            if ($pos !== false) {
               return;
            } 
			
			# report the event, send email etc.
			//$msg= $buffer;
			
            
			$msg ='Eroor Handler: '.$error['message'];
			ob_start();
			$data=array();
			
			$ci->email->subject("Toadsquare Error Occured!!".date("d-M-Y h:i:s"));
			$ci->email->message($msg);
            log_message('ERROR', $msg, TRUE);
			if(ENVIRONMENT != 'development' && $msg !=''){
				$ci->email->send();
			}else{
				 echo $msg;
			}
			if(!$ci->config->item('DEBUG_PRINT'))
			{
				$msg='';
			}
			$data['print_msg'] =$msg;
			$data['um'] = 'Error Handler: ';
			$buffer = ob_get_contents();
			ob_end_clean();

			# from /error-capture, you can use another redirect, to e.g. home page
			if(ENVIRONMENT !='development'){
				//redirect($ci->config->item('error-capture'));
			}
			//exit();
		}
        return;
	}/// --- FEND::handleShutdown() ---

	/*
	* @Function: myErrorHandler()  error handler function
	* @params: void 
	* @return: null
	*/
	
	function myErrorHandler($errno, $errstr, $errfile, $errline)
	{
		$pos = strpos($errstr, 'Undefined');
        if ($pos !== false) {
           return;
        } 
            
        $ci=&get_instance();
		$ci->load->library("email");
		//,"perminder@cdnsol.com"
		$ci->email->to(array("sushilmishra@cdnsol.com","lokendrameena@cdnsol.com","tosifqureshi@cdnsol.com","amitneema@cdnsol.com"));
		$ci->email->from("noreply@toadsquare.com","Toadsquare Error");
        if (!(error_reporting() & $errno)) {
			// This error code is not included in error_reporting
			return;
		}
		$ci->email->subject("Toadsquare Error Occured!!".date("d-M-Y h:i:s"));
		switch ($errno) {
		case E_USER_ERROR:
			$msg="<b>Eroor Handler:</b> [$errno] $errstr<br />\n";
			$msg.="  on line $errline in file $errfile";
			$msg.=", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			$msg.="Aborting...<br />\n";
			$ci->email->message($msg);
            log_message('ERROR', $msg, TRUE);
			if(ENVIRONMENT != 'development' ){
				$ci->email->send();
			}else{
				 echo $msg;
			}
			
			
			if(ENVIRONMENT !='development'){
				//redirect($ci->config->item('error-capture'));
			}
			
			//exit(1);
			break;

		case E_USER_WARNING:
			$msg="<b>Eroor Handler:</b> [$errno] $errstr<br />\n";
			$msg.="  on line $errline in file $errfile";
			$msg.=", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			$msg.="Aborting...<br />\n";
			$ci->email->message($msg);
			if(ENVIRONMENT != 'development' ){
				$ci->email->send();
			}else{
				//echo $msg;
			}
			log_message('ERROR', $msg, TRUE);
			break;

		case E_USER_NOTICE:
			$msg="<b>Eroor Handler:</b> [$errno] $errstr<br />\n";
			$msg.="  on line $errline in file $errfile";
			$msg.=", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			$msg.="Aborting...<br />\n";
			$ci->email->message($msg);
			if(ENVIRONMENT != 'development' ){
				$ci->email->send();
			}else{
				//echo $msg;
			}
			log_message('ERROR', $msg, TRUE);
			break;

		default:
			$msg="<b>Eroor Handler:</b> [$errno] $errstr<br />\n";
			$msg.="  on line $errline in file $errfile";
			$msg.=", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			$msg.="Aborting...<br />\n";
			$ci->email->message($msg);
			if(ENVIRONMENT != 'development' ){
				$ci->email->send();
			}else{
				//echo $msg;
			}
			log_message('ERROR', $msg, TRUE);
			break;
		}

		/* Don't execute PHP internal error handler */
		return;
		
	}/// --- FEND::myErrorHandler() ---

/* End of file ExceptionHook.php */
/* Location: ./application/hook/ExceptionHook.php */	
