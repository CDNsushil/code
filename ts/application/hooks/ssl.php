<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend HTTP to HTTPS without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
function check_ssl()
{
    $CI =& get_instance();
    $class = $CI->router->fetch_class();
 
   // $ssl = array('checkout', 'cart','payment','membershipcart','purchases');
    $ssl = array('');
    $partial =  array('login','registration');
 
    if(in_array($class,$ssl))
    {
        force_ssl();
    }
    else if(in_array($class,$partial))
    {
        return;
    }
    else
    {
        unforce_ssl();
    }
}
 
function force_ssl()
{
    $CI =& get_instance();
    $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
    if ($_SERVER['SERVER_PORT'] != 443) redirect($CI->uri->uri_string());
}
 
function unforce_ssl()
{
    $CI =& get_instance();
    $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
    if ($_SERVER['SERVER_PORT'] == 443) redirect($CI->uri->uri_string());
}

?>
