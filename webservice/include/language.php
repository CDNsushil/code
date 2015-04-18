<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	final class lang
	{
		 /// -- Hold Static class object --
	    private static $ref;
		/// -- Hold Static private class members variables --
	    static private $_lang=array();
	    /**
	    * @method __construct
	    * @see private constructor to protect beign inherited
	    * @access private
	    * @return void
	    */
	    private function __construct()
	    {
			lang::$_lang['LOGOUT_SUCCESS'] = "You have logout successfully!";
			lang::$_lang['ALREADY_LOGOUT'] = "You are already logout!";
			lang::$_lang['LOGIN_SUCCESS'] = "Successfully logged in!";
			lang::$_lang['CHECK_PASSWORD'] = "Check your password";
			lang::$_lang['ACCOUNT_N_ACTIVE'] = "Account is not active";
			lang::$_lang['CHECK_EMAIL'] = "Please check you Email!";
			lang::$_lang['PASSWORD_CHANGE'] = "Your password successfully changed!";
			lang::$_lang['ALREADY_PASSWORD_CHANGE'] = "Your have already changed password!";
			lang::$_lang['CHECK_CRED'] = "Please check your credentials!";
			lang::$_lang['LOGIN'] = "Please login!";
		}
		 /**
	    *Config::getInst()
	    *Config::getInst()
	    *@Param Void
	    *@RETURN Static Object of Class
	    */
	    final public static function getInst()
	    {
	      if(!is_object(lang::$ref)){
	          lang::$ref=new lang();
	      }
	      return lang::$ref;
	    }
	    /**
	    *config::getKeyValue Array()
	    *@Param key STRING
	    *@RETURN Array of Settings
	    */
	    final public function getKeyValue($key)
	    {
	        if(array_key_exists($key,lang::$_lang))
	        {
	          return lang::$_lang[$key];
	        }
	    }
	}
?>
