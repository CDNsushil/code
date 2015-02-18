<?php
if(! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Chatching Global Settings Helper File
 *
 * Manage get_global_settings
 *
 * @Category	Helper
 * @Author		CDN Solutions
 */

if(! function_exists('get_global_settings'))
{
	/**
	 * @Input: $option is the setting key 
	 * @Output: Returns setting value of key
	 * @Access: public
	 * Comment: This function takes takes option (key) and returns value of that setting key from global configuration
	 */
    function get_global_settings($option = ''){
	
	$CI = & get_instance();
	// get static content bucket from config file
	$admin_global_setting_option = $CI->config->item($option);
	return $admin_global_setting_option;
	
	/*
//	if(!$CI->session->userdata('global_setting_url')) {
		//memcache implementation for global setting
		$admin_global_setting_option = $CI->memcached_library->get('admin_global_setting_'.$option); 		
		if(!$admin_global_setting_option){
			// load global settings model			
			$CI->load->model('global_settings_model');		
			$result = $CI->global_settings_model->get_global_settings_by_option($option);
			$admin_global_setting_option	=$result->value;
			$CI->memcached_library->add('admin_global_setting_'.$option,$admin_global_setting_option,$CI->config->item('memcache_user_data_time'));
		}
		return $admin_global_setting_option;			
*/
   // }
    
    }
}
function get_s3_directory($suffix = '/')
{
    $CI = & get_instance();
    $CI->config->load('static_files');
    $config = $CI->config->config['static_files'];
    return empty($config['s3_directory']) ? '' : $config['s3_directory'].$suffix;
}
/* End of file menu_url_helper.php */
/* Location: ./application/helpers/menu_url_helper.php */
?>
