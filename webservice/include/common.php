<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Author : Anoop singh
 * Email  : anoop@cdnsol.com
 * Timestamp : Aug-29 06:11PM
 * Copyright : www.cdnsol.com
 *
 */
	
	/**
	* Error Logging Interface
	* Function::log_message()
	* We use this as a simple mechanism to access the logging
	* class and send messages to be logged.
	* @access	public
	* @return	void
	*/
	function log_message($level = "error", $message="", $php_error = FALSE) {
			global $wgLog;
	    if(is_object($wgLog)) {
	        $wgLog->write_log($level, $message, $php_error);
	    }
	    else {
	        $wgLog=loadObject("log");
	        $wgLog->write_log($level, $message, $php_error);
	    }
	}
	
	/**
	* Class registry
	*
	* This function acts as a singleton.  If the requested class does not
	* exist it is instantiated and set to a static variable.  If it has
	* previously been instantiated the variable is returned.
	*
	* @access	public
	* @param	string	the class name being requested
	* @param	bool	optional flag that lets classes get loaded but not instantiated
	* @return	object
	*/
	function loadObject($class, $instantiate = "") {
	    static $objects = array();
	    // Does the class exist?  If so, we"re done...
	    if (array_key_exists($class, $objects)){
	        return $objects[$class];
	    }
	    if(isset($instantiate) && $instantiate != "") {
	        $objects[$class] = new $class($instantiate);
	    }
	    else {
	        $objects[$class] = new $class();
	    }
	    log_message("debug",$class.":: Object Initiated Successfully ");
	    
	    return $objects[$class];
	}
	/**
	* Loads the main config.php file
	* Function::&get_config()
	* @access	private
	* @return	array
	*/
	function &get_config() {
		  if (file_exists(BASEPATH.DS.LIBPATH.DS."config".EXT)) {
	        $_config=config::getInst()->getSettings();
	        return $_config;
	    }
	    else if (!file_exists(BASEPATH.DS.LIBPATH.DS."config".EXT)) {
	        exit("The configuration file config.php. does not exist.");
	    }
	    else if ( (!isset($_config)) || (!is_array($_config))) {
	        exit("Your config file does not appear to be formatted correctly.");
	    }
	}
	
	function setEnv(){
		
		if ( ! isset($_SERVER['REQUEST_URI']) OR ! isset($_SERVER['SCRIPT_NAME']))
		{
			return '';
		}

		$uri = $_SERVER['REQUEST_URI'];
    
		if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
		{
			$uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
		}
		elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
		{
			$uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
		}

		// This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
		// URI is found, and also fixes the QUERY_STRING server var and $_GET array.
		if (strncmp($uri, '?/', 2) === 0)
		{
			$uri = substr($uri, 2);
		}
		
		$parts = preg_split('#\&#i', $uri, 2);
		$parts1 = preg_split('#\&#i', $parts[1], 2);
		$parts2 = preg_split('#\=#i', $parts1[0], 2);	
		//$uri = $parts[0];
		$uri = $parts2[1];
		 
		if (isset($parts[1]))
		{ 
			$_SERVER['QUERY_STRING'] = $parts[1];
			parse_str($_SERVER['QUERY_STRING'], $_REQUEST);
		}
		else
		{
			$_SERVER['QUERY_STRING'] = '';
			$_GET = array();
		}
   
		if ($uri == '/' || empty($uri))
		{
			return '/';
		}

		$uri = parse_url($uri, PHP_URL_PATH);

		// Do some final cleaning of the URI and return it
		str_replace(array('//', '../'), '/', trim($uri, '/'));
	

		$search=strtolower(dirname($_SERVER['PHP_SELF']))."/<br>";
		$uri=str_ireplace(dirname($_SERVER['PHP_SELF']), "/", (string)$uri);


		foreach (explode("/", preg_replace("|/*(.+?)/*$|", "\\1", $uri)) as $val)
		{
			// Filter segments for security
			$val = trim($val);

			if ($val != '')
			{
				$segments[] = $val;
			}
		}
			
		return $segments;
	}
	
	/*
	|* Include basic engine core i8E_engine
	|*
	*/
	if(file_exists(BASEPATH.DS.LIBPATH.DS."core_i8e_engine.php"))
	{
	    include(BASEPATH.DS.LIBPATH.DS."core_i8e_engine.php");
	}
	else
	{
	    die("Illegal use of Script!! Main COnfig files Missing!!!!");
	}
?>
