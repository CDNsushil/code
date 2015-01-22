<?php

// Path to BotDetect shared library

$outerLib = realpath(FCPATH . '../lib/botdetect.php');
$innerRootDirLib = FCPATH . 'lib' . DIRECTORY_SEPARATOR . 'botdetect.php';
$innerAppDirLib = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'botdetect.php';

if (is_readable($outerLib)) {
	require_once($outerLib);
	define('BDCLIB_RELATIVE_PATH', "../");
} else if (is_readable($innerAppDirLib)) {
	define('IS_INNER_APP', true);
	require_once($innerAppDirLib);
} else {
	define('BDCLIB_RELATIVE_PATH', "");
	if (is_readable($innerRootDirLib)) {
		require_once($innerRootDirLib);
	} else {
		$destination_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib';
		echo "You have downloaded our CodeIgniter sample, but you are missing BotDetect Captcha library which comes as a separate download. To resolve the issue:
		
			<br><br>1) Download BotDetect PHP CAPTCHA Library from here: <a href=\"http://captcha.com/captcha-download.html?version=php&amp;utm_source=installation&amp;utm_medium=php&amp;utm_campaign=CodeIgniter\">http://captcha.com/captcha-download.html?version=php</a>

			<br><br>2) Copy (all contents of the directory)
			<br>from: &lt;BDLIB&gt;/lib
			<br>to: " . $destination_path . "
			<br><i>* where &lt;BDLIB&gt; stands for the downloaded and extracted contents of the BotDetect PHP Captcha library</i>

			<br><br>Here is where you can find more details: <a href=\"http://captcha.com/doc/php/howto/codeigniter-captcha.html?utm_source=installation&amp;utm_medium=php&amp;utm_campaign=CodeIgniter\">http://captcha.com/doc/php/howto/codeigniter-captcha.html</a>
			<br>";
		die;
	} 
}

require_once("CICaptchaConfig.php");

class BotDetectCaptcha extends Captcha {

	function __construct($config = array()) {
		if (!isset($_SESSION)) {
			session_start();
		} 
		if (count($config) > 0) {
			$this->initialize($config);
		}
	}

	public function initialize($config = array()) {
		foreach ($config as $key => $val) {
			$method = 'set_'.$key;
			if (method_exists($this, $method)) {
				$this->$method($val);
			} else {
				$this->$key = $val;
			}
		}
		parent::__construct($config['CaptchaId']);
    
		return $this;
	}
  
	// Captcha plugin version info
	public static $ProductInfo;
  
	public static function GetProductInfo() {
		return BotDetectCaptcha::$ProductInfo;
	}
}


// static field initialization
BotDetectCaptcha::$ProductInfo = array( 
	'name' => 'BotDetect CodeIgniter Captcha Library', 
	'version' => '3.0.Beta3.0'
);
