<?php 
/*
 * Dashboard Manage template
 * 
 * @Description: This function is used to manage new version html showing template
 * 
 * @auther: lokendra meena
 * @email: lokendrameena@cdnsol.com
 * @create date: 17-07-2014
 */ 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');	

    /*
     * Template_new class
     */

    class New_version {		
        
        //define array for template data storing
        var $template_data  = array();
        var $CI 			= NULL;
    
       /*
        * @access: public
        * @description: This function is used to load view in template 
        * @return: string
        */
         
        public function load($template = '', $view = '' , $view_data = array(), $return = FALSE){           
            
            //create 
            $CI = get_instance();

            //asign view data in data varible
            $data 			= 	$view_data;

            //send current open class name
            $data['module'] = $CI->router->fetch_class();

            //send current open method name
            $data['moduleMethod'] = $CI->router->fetch_method();

            //get logged in user id
            /*$loggedUserId	=	isLoginUser();			
            $userId			=	(($CI->uri->segment(4) > 0)?$CI->uri->segment(4):$loggedUserId);
            $userId			=	($userId>0)?$userId:0;

            if(isset($userId) && $userId >0) {
                $userInfo = showCaseUserDetails($userId,'frontend');							
            }else{
                $userInfo = false;
            }

            $data['userInfo']           = $userInfo;*/
         
            $config['site_title']       = $CI->config->item('toadsquare');			
            $config['doctype']          = 'transitional';			

            $config['show_errors'] 		  = $CI->config->item('show_errors');
            $config['meta_author'] 		  = $CI->config->item('meta_author');
            $config['meta_description'] = $CI->config->item('meta_description');

            //---------------------inline js ---------------------
            $CI->head->add_inline_js("var baseUrl= '".base_url()."' ; ");	
            $CI->head->add_inline_js("var language= '".$CI->uri->segment(1)."' ; ");	

            //---------------------css add------------------------
            $CI->head->add_css($CI->config->item('template_new_css').'reset.css');
            $CI->head->add_css($CI->config->item('template_new_css').'jquery-ui.css');
            $CI->head->add_css($CI->config->item('template_new_font_css').'fonts.css');
            $CI->head->add_css($CI->config->item('template_new_css').'popup.css');
            $CI->head->add_css($CI->config->item('template_new_css').'common.css');
            $CI->head->add_css($CI->config->item('template_new_css').'style_main.css');
            $CI->head->add_css($CI->config->item('template_new_css').'custom_developer.css');
             
            //---------------------js add-------------------------- 
            $CI->head->add_js($CI->config->item('template_new_js').'jquery.min.js');
            // $CI->head->add_js($CI->config->item('template_new_js').'jquery-1.9.1.min.js');
            $CI->head->add_js($CI->config->item('template_new_js').'jquery.stellar.min.js');
            $CI->head->add_js($CI->config->item('template_new_js').'waypoints.min.js');
            $CI->head->add_js($CI->config->item('template_new_js').'jquery.easing.1.3.js');
            $CI->head->add_js($CI->config->item('template_new_js').'jquery.mousewheel.js');
            $CI->head->add_js($CI->config->item('template_new_js').'scripts1.js');
            $CI->head->add_js($CI->config->item('template_new_js').'tinynav.min.js');
            $CI->head->add_js($CI->config->item('template_new_js').'jquery.selectBox.js');
            $CI->head->add_js($CI->config->item('template_new_js').'jquery.multiselect.js');

            $CI->head->add_js($CI->config->item('template_new_valiation').'jquery.validate.js');
            $CI->head->add_js($CI->config->item('template_new_valiation').'additional-methods.js');

            $CI->head->add_js($CI->config->item('template_new_js').'jquery.anythingslider.js');
            $CI->head->add_js($CI->config->item('template_new_js').'jquery.ezmark.min.js');
            $CI->head->add_js($CI->config->item('template_new_js').'eye.js');
            $CI->head->add_js($CI->config->item('template_new_js').'SpryTabbedPanels.js');

            $CI->head->add_js($CI->config->item('template_new_js').'jquery.tinycarousel.min.js');
            $CI->head->add_js($CI->config->item('template_new_js').'dropdown-menu.min.js');
            $CI->head->add_js($CI->config->item('template_new_js').'jquery-ui.js');
            $CI->head->add_js($CI->config->item('template_new_js').'jquery_customscroll.js');
            $CI->head->add_js($CI->config->item('template_new_js').'jquery.flexslider.js');
            //$CI->head->add_js($CI->config->item('template_new_js').'menuslide_scroll.js');

            //-----lightbox------//
            $CI->head->add_js($CI->config->item('template_new_lightbox').'jquery-plugin/lightboxme-2.3/jquery.lightboxme.js');
            $CI->head->add_js($CI->config->item('template_new_lightbox').'common/lightboxme-common.js');
            $CI->head->add_js($CI->config->item('template_new_lightbox').'R&D/localization/messages_en.js');	
            $CI->head->add_js($CI->config->item('template_new_lightbox').'scroll_pagination.js');	
            
            $CI->head->add_js($CI->config->item('template_new_lightbox').'/jquery-lib/jquery.ui.core.js');	
            $CI->head->add_js($CI->config->item('template_new_lightbox').'/jquery-lib/jquery.ui.widget.js');	
            $CI->head->add_js($CI->config->item('template_new_lightbox').'/jquery-lib/jquery.ui.mouse.js');	
            $CI->head->add_js($CI->config->item('template_new_lightbox').'/jquery-lib/jquery.ui.draggable.js');	
            $CI->head->add_js($CI->config->item('template_directory').'/system/javascript/jquery-lib/zclip.min.js');	
            $CI->head->add_js($CI->config->item('template_directory').'/system/javascript/jquery-plugin/datepicker/js/jq-datepicker_monthyear.js');	
           
            //if preivew mode then no share functionality work
            if(previewModeActive()===false){
                $CI->head->add_js($CI->config->item('template_directory').'/frontend/js/addthis_widget.js');	
            }
            
            $CI->head->add_js($CI->config->item('template_new_js').'common.js');	
            $CI->head->add_js($CI->config->item('template_new_js').'custom_plugins.js');	
            $CI->head->add_js($CI->config->item('template_new_js').'custom_developer.js');	
            
            $CI->head->add_js($CI->config->item('template_new_js').'jquery.menu-aim.js');	
            $CI->head->add_js($CI->config->item('template_new_js').'jquery.simplyscroll.js');	
            //----CK Editor------//
            $CI->head->add_js($CI->config->item('template_directory').'/new_version/ckeditor/ckeditor.js');	
             
            $data['head'] 			    =   $CI->head->render_head($config);	
           
            // new version image path
            $data['imgPath']		    =   base_url().$CI->config->item('template_new_images');		

            // js path if require js in footer
            $data['jsPath']			    =   base_url().$CI->config->item('template_new_js');		

            //render content in master template
            $data['content']	      =	  $CI->load->view($view, $data,true );

            $data['methodName']		  =	  $CI->router->fetch_method();
            $data['className']	    =	  $CI->router->fetch_class();

            $CI->load->view($template, $data);					
        }
    }

?>
