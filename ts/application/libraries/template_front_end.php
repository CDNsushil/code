<?php 
//error_reporting(0); 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
	class Template_front_end {		
		var $template_data = array();		
		function Template(){
		
		}

		function load($template = '', $view = '' , $view_data = array(), $return = FALSE){           
			
			$CI = get_instance();
			
			//$data 				= 	htmlEntityDecode( $view_data);
			$data 				= 	$view_data;
			//echo '<pre/>';print_r($data);		
			$data['module'] = $CI->router->fetch_class();
			$data['moduleMethod'] = $CI->router->fetch_method();
			
			$segment = 4;
			$urisegment = $CI->uri->segment_array();
			$key = array_keys($urisegment,$data['moduleMethod']);
			if(isset($key[0]) && $key[0] > 0 ){
				$segment = ($key[0]+1);
			}
			
			$loggedUserId=isLoginUser();			
			$userId=(($CI->uri->segment($segment) > 0)?$CI->uri->segment($segment):$loggedUserId);
			$userId=($userId>0)?$userId:0;
			
			$urlUsername = '';
			if(isset($userId) && $userId >0) {
				$userInfo = showCaseUserDetails($userId,'frontend');
				$urlUsername = strtolower(str_replace(' ','.','/'.$userInfo['userFullName'].$userId));					
			}else{
				$userInfo = false;
			}
			$data['userInfo'] = $userInfo;
			$data['urlUsername'] = $urlUsername;
			
			
			$site_title 		= '';
			$site_title_accord_method 		= '';
			
			if (in_array($data['module'], $CI->config->item('extraTabs')) || in_array($data['moduleMethod'], $CI->config->item('extraTabs'))){
				
				$site_title = $CI->config->item($data['module'].'_title');
				if(!empty($site_title))
					$site_title 		=  $CI->config->item($data['module'].'_title').':&nbsp;'.$CI->config->item('toadsquare');
				
				$site_title_accord_method 		= $CI->config->item($data['moduleMethod'].'_title').':&nbsp;'.$CI->config->item('toadsquare');	
			}			
			else if(isset($userId) && $userId >0){
				if($data['module']=="forums" || $data['module']=="help")
				{
					$site_title = $CI->config->item($data['module'].'_title').':&nbsp;'.$CI->config->item('toadsquare');				
					$site_title_accord_method	= $CI->config->item($data['moduleMethod'].'_title').':&nbsp;'.$CI->config->item('toadsquare');	
				}else
				{
					
					$userInfo = showCaseUserDetails($userId,'userBackend');	
					
					if($userInfo['enterprise'] == 't')
						$site_title = (isset($userInfo['enterpriseName']) && $userInfo['enterpriseName']!='')?$userInfo['enterpriseName'].':&nbsp;'.$CI->config->item('toadsquare'):$CI->config->item('toadsquare');
					else
						$site_title = (isset($userInfo['userFullName']) && $userInfo['userFullName']!='')?$userInfo['userFullName'].':&nbsp;'.$CI->config->item('toadsquare'):$CI->config->item('toadsquare');
				}		
			}			
			else{				
				
				$site_title = $CI->config->item($data['module'].'_title').':&nbsp;'.$CI->config->item('toadsquare');				
				$site_title_accord_method	= $CI->config->item($data['moduleMethod'].'_title').':&nbsp;'.$CI->config->item('toadsquare');						
			}
			
			if(isset($site_title) && $site_title != ''){
				 $showSiteTitle = $site_title;
			}
			else if(isset($site_title_accord_method) && $site_title_accord_method != ''){
				$showSiteTitle	= $site_title_accord_method;
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
			
			$CI->head->add_inline_js("var baseUrl= '".base_url()."' ; ");	
			$CI->head->add_inline_js("var language= '".$CI->uri->segment(1)."' ; ");	
			$CI->head->add_jquery("$('.date-input').datepicker({});");
			
			$CI->head->add_css($CI->config->item('system_css').'form.css');
			$CI->head->add_css($CI->config->item('default_css').'template.css');
			$CI->head->add_css($CI->config->item('default_css').'dsscreen.css');
			$CI->head->add_css($CI->config->item('frontend_css').'template_front_end.css');
			
			if ($CI->agent->browser() == 'Internet Explorer')
				$CI->head->add_css($CI->config->item('frontend_css').'styleiehack.css');
			
			$CI->head->add_css($CI->config->item('commonCSS'));
			$CI->head->add_css($CI->config->item('system_css').'pagination.css');
			$CI->head->add_css($CI->config->item('system_css').'jquery-ui.css');
			//For Fullscreen
			$CI->head->add_css($CI->config->item('system_css').'royalslider.css');
			$CI->head->add_css($CI->config->item('system_css').'rs-default.css');
      
      // add new version popup css  
      $CI->head->add_css($CI->config->item('template_new_font_css').'fonts.css');
      $CI->head->add_css($CI->config->item('template_new_css').'popup.css');
      
			$CI->head->add_js($CI->config->item('system_js').'jquery.royalslider.min.js');
			
			$CI->head->add_js($CI->config->item('system_js').'pagination.js');
			$CI->head->add_js($CI->config->item('system_js').'scroll_pagination.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery-ui.min.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery.multiselect.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery.ezmark.js');	
			//$CI->head->add_js($CI->config->item('system_js').'lazyload.js');	
			$CI->head->add_js($CI->config->item('system_js').'jquery-lib/jquery.ui.mouse.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery-lib/jquery.ui.draggable.js');
			$CI->head->add_js($CI->config->item('system_js').'jquery-lib/zclip.min.js');
			
			$CI->head->add_js($CI->config->item('frontend_js').'jquery.tinycarousel.min.js');	
			$CI->head->add_js($CI->config->item('frontend_js').'frontend.js');
			
			if(getOsName()=="mobile")
			{
				$CI->head->add_css($CI->config->item('html5_audio_player_css').'jplayer.blue.monday.css');
				$CI->head->add_js($CI->config->item('html5_audio_player_js').'jquery.jplayer.min.js');
				
			}else
			{	
				$CI->head->add_js($CI->config->item('player_js').'flowplayer-3.2.12.js');
				$CI->head->add_js($CI->config->item('player_js').'flowplayer.playlist-3.2.10.min.js');
			}
			
			
			$data['head'] 			= 	$CI->head->render_head($config);
			
			if($userId > 0){
				if(!isset($data['userNavigations'])) {
					//$publishCheck=($loggedUserId == $userId)?false:true;
					$publishCheck=true;
					$data['userNavigations']=$CI->model_common->userNavigations($userId,$publishCheck);
				}
				$data['cravesCount']=$CI->model_craves->craveList($userId,'','','',0,true,false);
				$data['cravingmeCount']=$CI->model_craves->cravingmeUserList($userId,'','','',0,0,true);
				//$data['userOtherProject']=$CI->model_common->countResult('ShowProject',$field=array('receiverid'=>$userId,'status'=>'t'),'', 1);
				$data['userOtherProject']=$CI->model_common->showProjectsCount($userId);
				$data['buyerCommentsCount']=$CI->model_common->countResult('BuyerComments',$field=array('ownerId'=>$userId,'status'=>'t'),'', 1);
			}else{
				$data['userNavigations']=false;
				$data['cravesCount']=false;
				$data['userOtherProject']=false;
			}
			
			$data['content']	 =	$CI->load->view($view, $data,true );
			$secect_class="select_".$CI->router->fetch_class().$CI->router->fetch_method();
			$data[$secect_class]	=	'LSM_select_front';
			$secectClass="select_".$CI->router->fetch_class();
			$data[$secectClass]		=	'LSM_select_front';
			$currentTopMenu="topMenu_".$CI->router->fetch_class();
			$data[$currentTopMenu]		=	'active';
			$CI->load->view($template, $data );					
		}
	}

?>
