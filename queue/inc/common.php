<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Loads the main config.php file
* Function::&get_config()
* @access	private
* @return	array
*/
function renderjob($params) {
    if(count($params)>0)
	{
		if(array_key_exists("Type",$params) && array_key_exists("JobID",$params))
		{	if($fp = fopen(config::getInst()->getKeyValue("media_queue_inqueue").$params["JobID"].config::getInst()->getKeyValue("renderjob"),"w")){
				//fwrite($fp,"#[renderjob]#\n".Spyc::YAMLDump($params));
				fwrite($fp,Spyc::YAMLDump($params));
				fclose($fp);			
			return TRUE;
			
			}
		}else{
			return "ERROR in writing renderjob YAML File !!!";
		}	
	} else {
		return "ERROR in YAML config file Format !!!";
	}	
	
}

/*
	Loads the main config.php file
	Function::&get_config()
	@access	private
	@return	array
*/

function get_config() {
    if (file_exists(dirname(__FILE__).'/config'.EXT)) {
        $_config=config::getInst()->getSettings();
        return $_config;
    }
    else if (!file_exists(dirname(__FILE__).'/config'.EXT)) {
        exit('The configuration file config'.EXT.' does not exist.');
    }
    else if ( (!isset($_config)) || (!is_array($_config))) {
        exit('Your config file does not appear to be formatted correctly.');
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
    // Does the class exist?  If so, we're done...
    if (array_key_exists($class, $objects)){
        return $objects[$class];
    }
    if(isset($instantiate) && $instantiate != "") {
        $objects[$class] = new $class($instantiate);
    }
    else {
        $objects[$class] = new $class();
    }
    log_message("ALL",$class.":: Object Initiated Successfully ");
    return $objects[$class];
}

/**
* Error Logging Interface
* Function::log_message()
* We use this as a simple mechanism to access the logging
* class and send messages to be logged.
*
* @access	public
* @return	void
*/
function log_message($level = 'error', $message="", $php_error = FALSE) {
    global $wgLog;
    if(is_object($wgLog)) {
        $wgLog->write_log($level, $message, $php_error);
    }
    else {
        $wgLog=loadObject('log');
        $wgLog->write_log($level, $message, $php_error);
    }
}

function encode($kValue){
	return base64_encode($kValue);
}

function decode($kValue){
	return base64_decode($kValue);
}

function db_connect($db = ''){
	if(!is_object($db)){
		$con_string = "host=".config::getInst()->getKeyValue("db_hostname")." port=".config::getInst()->getKeyValue("db_port")." dbname=".config::getInst()->getKeyValue("db_name")." user=".config::getInst()->getKeyValue("db_username")." password=".config::getInst()->getKeyValue("db_password");
		$db = pg_connect($con_string);
		return $db;
	}else{
		return $db;
	}
}
/*
|* Include basic config file
|*
*/
if(file_exists(dirname(__FILE__)."/config.php"))
{
   include(dirname(__FILE__)."/config.php");
}
else
{
    die("Illegal use of Script!! Config file Missing!!!!");
}
/*
|* Include basic engine Logging File
|*
*/

if(file_exists(dirname(__FILE__)."/log.php"))
{
   include(dirname(__FILE__)."/log.php");
   log_message("ALL","log files include successfully");
}
else
{
    die("Illegal use of Script!! LOG files Missing!!!!");
}
/*
|* Include basic engine YAML File
|*
*/
if(file_exists(dirname(__FILE__)."/spyc.php"))
{
   include(dirname(__FILE__)."/spyc.php");
   log_message("ALL","spyc files include successfully");
}
else
{
    die("Illegal use of Script!! YAML files Missing!!!!");
}

/* End of file common.php */
/* Location: ./inc/common.php */
?>
