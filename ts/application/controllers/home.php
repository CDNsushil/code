<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//class Welcome extends CI_Controller {
class Home extends MX_Controller {
    private $data = array();
    private $userId = null;
    
    /**
     * Constructor
     */
    function __construct() {
        //Load required Model, Library, language and Helper files
            $load = array(
                'library' 	=> 'form_validation',			 	
                'helper' 	=> 'form + file'	
            );
            parent::__construct($load);	
            
    }
    
    public function index(){
        $this->load->library('parallax');
        $url= $this->input->get('url');		
        if(isset($url) && ($url!='')){
            $this->load->model('shortlink/url_model'); 			
            $full = $this->url_model->get_full_url($url);				   
            redirect($full->url);						
        }else{ 
            $activate_account=$this->session->userdata('activateAccount');
            $this->session->unset_userdata('activateAccount');
            if($activate_account=='activateAccount'){
                $userDeatil['loadLoinPopup'] = true;
                $userDeatil['message'] = $this->lang->line('auth_message_activation_completed');
            }else{
                $userDeatil['loadLoinPopup'] = false;
                $userDeatil['message'] = '';
            }
                
        /* End */
            //$this->load->view('home_parallax',$userDeatil);
            $this->parallax->load("template_parallax",'home_parallax',$userDeatil);
            
        }
    }
    
    public function index_back(){
        $this->head->add_css($this->config->item('system_css').'frontend.css');
            $this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
            $this->head->add_js($this->config->item('system_js').'jstween-1.1.min.js');
            // This css add only for mobile os
            if(getOsName()=="mobile")
            {
                $this->head->add_css($this->config->item('html5_player_css').'video-js.css');
                $this->head->add_js($this->config->item('html5_player_js').'video.js');
            }	
        $url= $this->input->get('url');		
        if(isset($url) && ($url!='')){
            $this->load->model('shortlink/url_model'); 			
            $full = $this->url_model->get_full_url($url);				   
            redirect($full->url);						
        }else{ 
            $activate_account=$this->session->userdata('activateAccount');
            $this->session->unset_userdata('activateAccount');
            if($activate_account=='activateAccount'){
                $userDeatil['loadLoinPopup'] = true;
                $userDeatil['message'] = $this->lang->line('auth_message_activation_completed');
            }else{
                $userDeatil['loadLoinPopup'] = false;
                $userDeatil['message'] = '';
            }
                
        /* End */			
             $userDeatil['registerdUser'] = countResult('UserAuth','tdsUid');
             $this->template->load("frontend",'home',$userDeatil);
        }
    }
    
    public function indextest(){
        $url= $this->input->get('url');		
        if(isset($url) && ($url!=''))
        {
            $this->load->model('shortlink/url_model'); 			
            $full = $this->url_model->get_full_url($url);				   
            redirect($full->url);						
        } 	
         $this->template->load("frontend",'indextest');
    }
    public function help(){
     $this->index();
    }
    
    function test_tcpdf()
    {
        $this->load->view('example_001');
    }
    
    //----------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to show online news letter view
    * @auther: lokendra meena
    * @return: void
    */ 
    
    public function viewonline($newsletterId){
        
        $newsletterId = base64_decode($newsletterId);
        //get message data
        $whereCond         =   array('id'=>$newsletterId);
        $newsletterRes     =   getDataFromTabel('EmailNewsletter','*',  $whereCond, '','', '', 1 );
        
        if(!empty($newsletterRes)){
            $newsletterRes   =   $newsletterRes[0];
            $messageBody        =   (!empty($newsletterRes->content))?$newsletterRes->content:'';
            $sentDate           =   (!empty($newsletterRes->createdAt))?$newsletterRes->createdAt:'';
        
            $from_email = $this->config->item('webmaster_email', '');
            /* while we don't remove restriction (username, password) in .htacess file  from live site*/
            $image_base_url = site_base_url().$this->config->item('template_new_images');
            $crave_url = $this->config->item('crave_us');
            /* Set Follow us link*/
            $facebook_url = $this->config->item('facebook_follow_url');
            $linkedin_url = $this->config->item('linkedin_follow_url');
            $twitter_url = $this->config->item('twitter_follow_url');
            $gPlus_url = $this->config->item('google_follow_url');
            $site_email = 'info@toadsquare.com';
            $site_link = 'www.toadsquare.com';
			$message_date= (!empty($newsletterRes->newsletterDate)) ? date('F Y',strtotime($newsletterRes->newsletterDate)) : date('F Y');
            $view_online    =   base_url_lang('home/viewonline/'.base64_encode($newsletterId));
            $where=array('purpose'=>'newslettertemplate','active'=>1);
            $adminTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
            
            if($adminTemplateRes) {
                $adminTemplate = $adminTemplateRes[0]->templates;
                $searchArray = array("{view_online}","{message_date}","{mailBody}","{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{site_email}","{site_link}","{twitter_url}","{gPlus_url}");
                $replaceArray = array($view_online,$message_date,$messageBody,$image_base_url,$crave_url,$facebook_url,$linkedin_url,$site_email,$site_link,$twitter_url,$gPlus_url);
                $adminMailTemplate = str_replace($searchArray, $replaceArray, $adminTemplate);
                echo $adminMailTemplate;
            }
        }else{
            redirectToNorecord404();
        }
    }
    
    
    
}
