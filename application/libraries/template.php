<?php 
//error_reporting(0); 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
	class Template {		
		var $template_data = array();		
		function Template(){
		
		}

		function load($template = '', $view = '' , $view_data = array(), $return = FALSE){           
			$CI = get_instance();
			//$data 				= 	htmlEntityDecode($view_data);	
			$data 				= 	$view_data;
			$addAdministration ='';			
			$data['module']=$CI->router->fetch_class();
			$data['moduleMethod']=$CI->router->fetch_method();
			
			$userId=isLoginUser();
			$userId=($userId>0)?$userId:0;
			$site_title = '';
			$site_title_accord_method = '';
			
			
			if (in_array($data['module'], $CI->config->item('adminModules')) || in_array($data['moduleMethod'], $CI->config->item('adminModules'))){
				$site_title 		= $CI->config->item($data['module'].'_admin_title');
				$site_title_accord_method 		= $CI->config->item($data['moduleMethod'].'_admin_title');	
			}
			else {
				$site_title 		= $CI->config->item($data['module'].'_title');
				$site_title_accord_method 		= $CI->config->item($data['moduleMethod'].'_title');	
			}	
			
			if(isset($site_title) && $site_title != '' ){
				 $showSiteTitle = $site_title.':&nbsp;'.$CI->config->item('toadsquare');
			}
			else if(isset($site_title_accord_method) && $site_title_accord_method != ''){
				$showSiteTitle	= $site_title_accord_method.':&nbsp;'.$CI->config->item('toadsquare');
			}
			else $showSiteTitle = $CI->config->item('toadsquare');			
			
			$config['site_title'] 		= $showSiteTitle;			
			
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
			
				
			$CI->head->add_js($CI->config->item('commonJs'));
			$CI->head->add_js($config['templateJs']);
			
			//$CI->head->add_css($CI->config->item('fontCss'));
			$CI->head->add_css($CI->config->item('templateCss'));
			$CI->head->add_css($CI->config->item('projectCSS'));
			
			
			//$CI->head->add_jquery('bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });');
			
			$CI->head->add_inline_js("var baseUrl= '".base_url()."' ; ");	
			$CI->head->add_inline_js("var language= '".$CI->uri->segment(1)."' ; ");	
			$CI->head->add_jquery("$('.date-input').datepicker({});");
			
			$CI->head->add_css($CI->config->item('system_css').'form.css');
			$CI->head->add_css($CI->config->item('default_css').'template.css');
			//$CI->head->add_css($CI->config->item('system_css').'frontend.css');
			
			//Css for IE 			
			if ($CI->agent->browser() == 'Internet Explorer' || $CI->agent->browser() == 'IE')
				$CI->head->add_css($CI->config->item('frontend_css').'styleiehack.css');
			
			$CI->head->add_css($CI->config->item('commonCSS'));
			$CI->head->add_css($CI->config->item('system_css').'pagination.css');
			$CI->head->add_css($CI->config->item('system_css').'jquery-ui.css');
			$CI->head->add_css($CI->config->item('system_css').'landingpage_slider.css');
      
      // add new version popup css  
      $CI->head->add_css($CI->config->item('template_new_font_css').'fonts.css');
      $CI->head->add_css($CI->config->item('template_new_css').'popup.css');
			
			$CI->head->add_js($CI->config->item('system_js').'pagination.js');
			$CI->head->add_js($CI->config->item('system_js').'scroll_pagination.js');
			//$CI->head->add_js($CI->config->item('system_js').'lazyload.js');	
			$CI->head->add_js($CI->config->item('system_js').'jquery-lib/jquery.easyPaginate.js');		
			$CI->head->add_js($CI->config->item('system_js').'workProfile.js');	
			$CI->head->add_js($CI->config->item('system_js').'jquery-ui.min.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery.multiselect.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery.ezmark.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery-lib/jquery.ui.mouse.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery-lib/jquery.ui.draggable.js');	
			$CI->head->add_js($CI->config->item('system_js').'mask.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery-lib/zclip.min.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery-lib/jquery.zclip.js');
			//$CI->head->add_js($CI->config->item('system_js').'ZeroClipboard.js'); // ADD BY AMIT FOR COPY FUNCTION 

			$CI->head->add_js($CI->config->item('system_js').'jquery.cycle.all.min.js');		
			$CI->head->add_js($CI->config->item('frontend_js').'jquery.tinycarousel.min.js');	
			$CI->head->add_css($CI->config->item('frontend_css').'anythingslider.css');
			$CI->head->add_js($CI->config->item('frontend_js').'jquery-gallery-cdn.js');
			//$CI->head->add_js($CI->config->item('player_js').'flowplayer-3.2.12.min.js');
			
			
			if(getOsName()=="mobile")
			{
				$CI->head->add_css($CI->config->item('html5_player_css').'video-js.css');
				$CI->head->add_js($CI->config->item('html5_player_js').'video.js');
			}else
			{
				$CI->head->add_js($CI->config->item('player_js').'flowplayer-3.2.12.js');
			}
			
			$data['head'] = $CI->head->render_head($config);			
			
			if($userId > 0 ){
				$seller_currency=LoginUserDetails('seller_currency');
				$seller_currency=($seller_currency>0)?$seller_currency:0;
				$currencySign=$CI->config->item('currency'.$seller_currency);
				$data['seller_currency']=$seller_currency;
				$data['currencySign']=$currencySign;
				
				if(!isset($data['userNavigations'])) {
					$data['userNavigations']=$CI->model_common->userNavigations($userId,$publishCheck=false);
				}
				//$data['cravesCount']=$CI->model_craves->craveList($userId,$projectType='',$retrunRow=true,1);
			}else{
				$data['userNavigations']=false;
				//$data['cravesCount']=false;
			}
			
			$data['content']		=	$CI->load->view($view, $data,true );
			
			$secect_class="select_".$CI->router->fetch_class().$CI->router->fetch_method();
			$data[$secect_class]	=	'LSM_select';
			
			$secectClass="select_".$CI->router->fetch_class();
			$data[$secectClass]		=	'LSM_select';
			
			$currentTopMenu="topMenu_".$CI->router->fetch_class();
			$data[$currentTopMenu]		=	'active';
			
			$currentFooterMenu="footerMenu_".$CI->router->fetch_class();
			$data[$currentFooterMenu]		=	'active';
			$data['module']=$CI->router->fetch_class();
			$data['moduleMethod']=$CI->router->fetch_method();
 			$CI->load->view($template, $data );					
		}
	}

?>
