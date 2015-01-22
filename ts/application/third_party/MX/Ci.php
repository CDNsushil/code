<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load MX core classes */
require_once dirname(__FILE__).'/Lang.php';
require_once dirname(__FILE__).'/Config.php';

class CI
{
	public static $APP;
	
	public function __construct() {
		
		/* assign the application instance */
		self::$APP = CI_Controller::get_instance();
		
		global $LANG, $CFG;
		
		/* re-assign language and config for modules */
		if ( ! is_a($LANG, 'MX_Lang')) $LANG = new MX_Lang;
		if ( ! is_a($CFG, 'MX_Config')) $CFG = new MX_Config;
		
		/* assign the core loader */
		self::$APP->load = new MX_Loader;
		
		/* autoload module items */
		self::$APP->load->_autoloader(array());
	}
}

/* create the application object */
new CI;