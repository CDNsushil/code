<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('BASEURL', base_url());

/*------------- call global settings helper function starts ----------------*/
$global_setting_option = '__cloud_front_url__';
$global_setting_url = get_global_settings($global_setting_option);
//echo $global_setting_url; die();
define('CF_DEFAULT_TEMPLATE_URL', $global_setting_url);
//define('CF_DEFAULT_TEMPLATE_URL', 'https://chatching-templates.s3.amazonaws.com/');
define('CF_OPENSOCIAL_TEMPLATE_URL', base_url());
/*------------- call global settings helper function ends ----------------*/


/*---------------- Define the css dir path ----------------------*/
define('OPENSOCIAL_CSS', CF_OPENSOCIAL_TEMPLATE_URL.'templates/opensocial_template/css/');
/*---------------- Define the js dir path ----------------------*/
define('OPENSOCIAL_JS', CF_OPENSOCIAL_TEMPLATE_URL.'templates/opensocial_template/js/');

/*---------------- Define the images dir path ----------------------*/
define('OPENSOCIAL_IMG', CF_OPENSOCIAL_TEMPLATE_URL.'templates/opensocial_template/images/');

/*---------------- Define the css dir path ----------------------*/
define('CSS', CF_DEFAULT_TEMPLATE_URL.'templates/default/css/');
/*---------------- Define the js dir path ----------------------*/
define('JS', CF_DEFAULT_TEMPLATE_URL.'templates/default/javascript/');
/*---------------- Define the images dir path ----------------------*/
define('IMG', CF_DEFAULT_TEMPLATE_URL.'templates/default/images/');
/*---------------- Define the logo path  ----------------------*/

/*---------------- Define the pagination limit ----------------------*/
define('FANCYBOX', CF_DEFAULT_TEMPLATE_URL.'templates/default/fancybox/');
/*---------------- Define the pagination limit ----------------------*/
define('PAGGING', 5);

/*---------------- Define the css dir path ----------------------*/
define('ADMINCSS', BASEURL.'templates/admin_template/css/');
/*---------------- Define the js dir path ----------------------*/
define('ADMINJS', BASEURL.'templates/admin_template/js/');
/*---------------- Define the images dir path ----------------------*/
define('ADMINIMG', BASEURL.'templates/admin_template/img/');
/*---------------- Define the pagination limit ----------------------*/
//define('PAGGING', 5);

class Toad_admin_template 
{
	var $template_data = array();
	
	function Toad_admin_template(){
		
	}

	function set($name, $value)
	{
		$this->template_data[$name] = $value;
	}

	function load($template = '', $view = '' , $view_data = array(), $return = FALSE)
	{   
		$CI = get_instance();
		
		/* Admin page title */
		$config['site_title'] 	= $CI->lang->line('site_title');
		// Check user permission for requested page
		check_permission_for_requested_page();
		
		$currentModule = $CI->router->fetch_module();
		
		$data = $view_data;
		
		$config['admin_css'] 		= $CI->config->item('admin_css');
		$config['default_css'] 		= $CI->config->item('default_css');
		$config['system_css'] 		= $CI->config->item('system_css');
		
		//$CI->head->add_css($config['default_css'].'template.css');
		$CI->head->add_css($config['system_css'].'jquery-ui.css');
		$CI->head->add_css($config['admin_css'].'layout.css');
		$CI->head->add_css($config['admin_css'].'form.css');
		$CI->head->add_css($config['admin_css'].'wysiwyg.css');
		$CI->head->add_css($config['admin_css'].'themes/blue/styles.css');
		$CI->head->add_css($config['admin_css'].'style.css');
		$CI->head->add_css($config['admin_css'].'toad_admin_common.css');
		$CI->head->add_css($config['admin_css'].'update_password_validation.css');
		$CI->head->add_css($config['admin_css'].'jquery.alerts.css');

		//$CI->head->add_css($config['default_css'].'ui-datepicker/start/jquery-ui-1.8.23.custom.css');
		
		if($currentModule=="manage_news" || $currentModule=="manage_pressRelease")
		{
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
		}else
		{	
			$CI->head->add_inline_js("var BASEPATH= '".base_url()."' ; ");	
			$CI->head->add_inline_js("var baseUrl= '".base_url()."' ; ");	
			
			//$config['admin_system_js'] = $CI->config->item('admin_system_js');
				
			if($view !='manage_newsletter/compose_mail' && $view !='manage_countries/manage_country' && $view !='manage_eu_countries/manage_country' && $view !='manage_state/state_manage' && $view != 'manage_genre/genre_manage' && $view !='manage_continent/continent_manage' && $view !='manage_messaging/compose_mail' && $view !='manage_tmail/compose_tmail'){
				
				$CI->head->add_css($config['admin_css'].'styleLanguage.css');
			}
			$CI->head->add_css($config['admin_css'].'styleTips.css');
			$CI->head->add_css($config['admin_css'].'screen.css');
			
			/* Pagination JS AND CSS */
			$CI->head->add_css($config['system_css'].'pagination.css');
			$CI->head->add_css($config['admin_css'].'jquery-ui.css');
			$CI->head->add_css($config['system_css'].'project.css');
			
			$CI->head->add_js($CI->config->item('admin_system_js').'admin.js');	
			
			/* -- Tips Drag-Drop -- */
			if($currentModule == 'manage_tips'){	
				$CI->head->add_js($CI->config->item('system_js').'drag/jquery-1.3.2.min.js');
				$CI->head->add_js($CI->config->item('system_js').'drag/jquery-ui-1.7.1.custom.min.js');
				$config['defaults']			= $CI->config->item('admin_defaults');				
			}else{
				$config['jquery_file'] 		= $CI->config->item('jquery_file');
				$config['defaults']			= $CI->config->item('defaults');
				if($view !='manage_messaging/compose_mail' && $view !='manage_newsletter/compose_mail'  && $view !='manage_tmail/compose_tmail')			
				$CI->head->add_js($CI->config->item('commonJs'));
			}
			$config['packages']			= $CI->config->item('packages');	
			/* -- End Tip JS Files -- */
		
			//|| $view == 'manage_users/manage_user_list' commnet by lokendra
			
			if($view == 'manage_countries/country_listing' || $view == 'manage_eu_countries/country_listing' || $view == 'manage_state/state_listing' || $view == 'manage_templates/manage_templates_list' || $view == 'manage_suggestions/manage_suggestions_list' || $view == 'manage_templates_list' || $view == 'manage_genre/genre_listing' || $view == 'manage_continent/continent_listing' || $view == 'manage_lang/lang_listing' || $currentModule == 'manage_tips'){
				$CI->head->add_js($CI->config->item('system_js').'jquery-lib/jquery.js');
				$CI->head->add_js($CI->config->item('system_js').'jquery-ui.min.js');
			}
	
			$CI->head->add_js($CI->config->item('system_js').'jquery.multiselect.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery.ezmark.js');
			
			//add js for popup
			$CI->head->add_js($CI->config->item('system_js').'jquery-lib/jquery.zclip.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery-lib/zclip.min.js');
			
			$CI->head->add_js($CI->config->item('frontend_js').'jquery.tinycarousel.min.js');	
			$CI->head->add_css($CI->config->item('frontend_css').'anythingslider.css');
		}
		$data['head'] = $CI->head->render_head($config);	
		// Check user permission for requested page
		check_permission_for_requested_page();		
		
		$this->set('contents', $CI->load->view($view, $data, TRUE));		
		return $CI->load->view($template, $this->template_data, $return);
	}
}
/* End of file toad_admin_emplate.php */
/* Location: ./application/libraries/toad_admin_emplate.php */
