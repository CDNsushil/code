<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';
//require dirname(dirname(dirname(__FILE__))).'/aana/Loadlibrary.php';

class MX_Controller 
{
	public $autoload = array();
	public $_errorMessage=array();
	
	public function __construct($load=array()) 
	{
		//if $load is defined load them
		foreach((array)$load as $k => $v){
			//explode files separated with +
			$v_array = explode('+', $v);

			//now load each files
			foreach($v_array as $w) $this->load->$k(trim($w));
		}
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->_init($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);
	
		/* Auto check for SPACE and PACKAGE Exp */
		$this->_errorMessage["package"]=$this->_is_valid_request();
		
		/* Auto check for Rights Management */
		$this->_errorMessage["view"]=$this->_is_visible_toUser();
	}
	
	public function __get($class) {
		return CI::$APP->$class;
	}
	
	
	public function __call($name, $arguments){
		// Note: value of $name is case sensitive.
		$flag=false;
		foreach(Modules::$registry["aanaBase"]->_aana_register as $key => $value)
		{
			if(method_exists($value,$name))
			{
				$flag=true;
				return $value::$name(implode(', ', $arguments));		
				break;
			}
		}
		if($flag==false)
		{
			return aanaBase::$name(implode(', ', $arguments));
		}
		
		//return CI_Loadlibrary::$name(implode(', ', $arguments));
	}
}