<?php

$CI =& get_instance();
$CI_Base_Url = $CI->config->base_url();

if (defined('IS_INNER_APP')) {
    $LBD_Resource_Url = $CI_Base_Url . 'captcharesources/get/';
} else {
	$LBD_Resource_Url = ResolveUrl($CI_Base_Url . BDCLIB_RELATIVE_PATH . 'lib/botdetect/public/');
}

$LBD_CaptchaConfig = CaptchaConfiguration::GetSettings();

$LBD_CaptchaConfig->HandlerUrl = $CI_Base_Url . 'index.php/captchahandler/index';
$LBD_CaptchaConfig->ReloadIconUrl = $LBD_Resource_Url . 'lbd_reload_icon.gif';
$LBD_CaptchaConfig->SoundIconUrl = $LBD_Resource_Url . 'lbd_sound_icon.gif';
$LBD_CaptchaConfig->LayoutStylesheetUrl = $LBD_Resource_Url . 'lbd_layout.css';
$LBD_CaptchaConfig->ScriptIncludeUrl = $LBD_Resource_Url . 'lbd_scripts.js';


function ResolveUrl($url){
	$pos = strpos($url, "/..");
	if ($pos === FALSE) return $url;	
	return ResolveUrl(dirname(substr($url, 0, $pos)) . substr($url, $pos+3));
}
