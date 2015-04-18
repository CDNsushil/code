<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//define('BASEURL', base_url());

/*------------- call global settings helper function starts ----------------*/
$global_setting_option = '__cloud_front_url__';
$global_setting_url = get_global_settings($global_setting_option);
//echo $global_setting_url; die();
//define('CF_DEFAULT_TEMPLATE_URL', $global_setting_url);
//define('CF_DEFAULT_TEMPLATE_URL', 'https://chatching-templates.s3.amazonaws.com/');
//define('CF_OPENSOCIAL_TEMPLATE_URL', base_url());
/*------------- call global settings helper function ends ----------------*/


/*---------------- Define the css dir path ----------------------*/
//define('OPENSOCIAL_CSS', CF_OPENSOCIAL_TEMPLATE_URL.'templates/opensocial_template/css/');
/*---------------- Define the js dir path ----------------------*/
//define('OPENSOCIAL_JS', CF_OPENSOCIAL_TEMPLATE_URL.'templates/opensocial_template/js/');

/*---------------- Define the images dir path ----------------------*/
//define('OPENSOCIAL_IMG', CF_OPENSOCIAL_TEMPLATE_URL.'templates/opensocial_template/images/');

/*---------------- Define the css dir path ----------------------*/
//define('CSS', CF_DEFAULT_TEMPLATE_URL.'templates/default/css/');
/*---------------- Define the js dir path ----------------------*/
//define('JS', CF_DEFAULT_TEMPLATE_URL.'templates/default/javascript/');
/*---------------- Define the images dir path ----------------------*/
//define('IMG', CF_DEFAULT_TEMPLATE_URL.'templates/default/images/');
/*---------------- Define the logo path  ----------------------*/
//define('LOGO', CF_DEFAULT_TEMPLATE_URL.'templates/default/images/ChatChing.png');
/*---------------- Define the pagination limit ----------------------*/
//define('FANCYBOX', CF_DEFAULT_TEMPLATE_URL.'templates/default/fancybox/');
/*---------------- Define default user images ----------------------*/
//define('DEFAULT_USER_MAIN_IMAGE', base_url().'assets/user_images/default/profile/main_image/picture_upload.png');
//define('DEFAULT_USER_THUMB_IMAGE', base_url().'assets/user_images/default/profile/thumb_image/picture_upload.png');
//define('DEFAULT_USER_SMALL_IMAGE', base_url().'assets/user_images/default/profile/small_image/picture_upload.png');
/*---------------- Define the pagination limit ----------------------*/
//define('PAGGING', 5);

/*---------------- Define the css dir path ----------------------*/
//define('ADMINCSS', BASEURL.'templates/admin_template/css/');
/*---------------- Define the js dir path ----------------------*/
//define('ADMINJS', BASEURL.'templates/admin_template/js/');
/*---------------- Define the images dir path ----------------------*/
//define('ADMINIMG', BASEURL.'templates/admin_template/img/');
/*---------------- Define the pagination limit ----------------------*/
//this is admin
//define('PAGGING', 5);

class Admin_template 
{
	var $template_data = array();
	
	function set($name, $value)
	{
		$this->template_data[$name] = $value;
	}

	function load($template = '', $view = '' , $view_data = array(), $return = FALSE)
	{               
		$CI =& get_instance();
		
		// Check user permission for requested page
		check_permission_for_requested_page();
		
		$config['site_title'] 		= $CI->lang->line('site_title');
		$CI->config->item('templateCss');
			$CI->config->item('templateJs');
			
			$config['show_errors'] 		= $CI->config->item('show_errors');
			$config['meta_author'] 		= $CI->config->item('meta_author');
			$config['meta_description'] = $CI->config->item('meta_description');
		
			$config['template'] 		= $CI->config->item('template');
			$config['fontCss'] 			= $CI->config->item('fontCss');
			$config['templateCss'] 		= $CI->config->item('templateCss');
			$config['stylesheetCSS'] 	= $CI->config->item('stylesheetCSS');
			$config['templateJs'] 		= $CI->config->item('templateJs');
			$config['templateImages'] 	= $CI->config->item('templateImages');
			$config['system_css'] 		= $CI->config->item('system_css');
			$config['system_js'] 		= $CI->config->item('system_js');
			$config['system_images'] 	= $CI->config->item('system_images');
			$config['jquery_file'] 		= $CI->config->item('jquery_file');
			$config['defaults']			= $CI->config->item('defaults');			
			$config['packages']			= $CI->config->item('packages');	
			$data['imagePath']			= base_url().$CI->config->item('templateImages');			
			
			$CI->head->add_inline_js("var baseUrl= '".base_url()."' ; ");
			$CI->head->add_inline_js("var language= 'en' ; ");	
			$CI->head->add_jquery("$('.date-input').datepicker({});");
			$CI->head->add_css($CI->config->item('commonCSS'));
			
			
			$CI->head->add_css($CI->config->item('system_css').'jquery-ui.css');
			$CI->head->add_js($CI->config->item('system_js').'jquery-ui.min.js');
			$CI->head->add_js($CI->config->item('player_js').'flowplayer-3.2.12.js');
			$CI->head->add_js($CI->config->item('commonJs'));
			$CI->head->add_js($CI->config->item('system_js').'jquery.multiselect.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery.ezmark.js');
		
		$this->template_data['head'] = 	$CI->head->render_head($config);
		
		$this->set('contents', $CI->load->view($view, $view_data, TRUE));		
		return $CI->load->view($template, $this->template_data, $return);
	}
}
/* End of file admin_emplate.php */
/* Location: ./application/libraries/admin_emplate.php */
