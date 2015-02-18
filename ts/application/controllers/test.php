<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *  All email and tmail template manage controller
 * 
 *  @Description: This controller is use to see all email & 
 *  tmail template html
 *  @auther: lokendra
 *  @last modified: 4-Oct-2014
 * 
 */ 


class test extends MX_Controller{

    function __construct(){
        $load = array(
                'model' 	=> 'package/model_package + membershipcart/model_membershipcart + media/model_media + work/model_work_offered + product/model_product + blog/model_blog + upcomingprojects/model_upcomingprojects + showcase/model_showcase + workprofile/model_workprofile + event/model_event + tmail/model_tmail',
                'language' 	=> 'package',
                'config' 	=> 'package + media/media',
                'library' 	=> 'tmail/Tmail_messaging'
            );
            parent::__construct($load);	
        $this->dirCacheMedia = 'cache/test/';  
        $this->load->model(array('cms/model_cms'));
        $this->head->add_css($this->config->item('system_css').'frontend.css');
        $this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
        $this->head->site_title="Test Email";	
    }
    
    //-----------------------------------------------------------------------
    
    function index(){
        echo getFileType('abc.jpeg');
    }
    
    //-----------------------------------------------------------------------


    function send_email_template($body,$subject){
        //$email=array('sushilmishra@cdnsol.com','tosifqureshi@cdnsol.com','perminder@cdnsol.com');
        //$email=array('tosifqureshi@cdnsol.com','jane@toadsquare.comwww');
        $email=array('tosifqureshi@cdnsol.com');
        $this->email->from('noreply@toadsquare.com', $this->config->item('website_name', ''));
        //$this->email->reply_to('noreply@toadsquare.com');
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($body);
        
        if($this->email->send()){
            echo "Sent Message successfully";
        }
        else{
            echo "Error: <br/>";
            $msg=$this->email->print_debugger();
            echo $msg;
        }
    }
    
    //-----------------------------------------------------------------------
    
    //Email testing for forgot password
    
    function test_forgot_template($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'forgot_password','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $site_name = 'toadsquare';
        $userId = 21;
        $new_pass_key = 'test123';
        
        $site_base_url = site_url('');
        
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        //$site_url = site_url('auth/reset_password/'.$userId.'/'.$new_pass_key);
        $site_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/toadsquare/en/auth/reset_password/90/8f93d0558b271e798f125f73b9d32915';
        
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{site_name}", "{new_pass_key}" , "{site_url}", "{site_base_url}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}");
            $replaceArray = array($site_name,$new_pass_key,$site_url,$site_base_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);			
            }
        }
                
    }
    
    //-----------------------------------------------------------------------
    
    function test_welcome_template($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'welcome','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $site_name = 'toadsquare';
        $email = 'tosifqureshi@cdnsol.com';
        $username = 'Test Name';
        $site_url = site_url('auth/login/'); 
        $site_base_url = site_url('');
    
        $activation_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/auth/activate/155/d1901ab93261d9d517fab864819a740f';
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        $password = 'cdn123';
        $register_date = date("j F Y") . ' at ' . date("G:i");
        $term_link = site_url(lang()).'/cms/downloadtandc';
        $activation_period = $this->config->item('email_activation_expire', 'tank_auth') / 3600;
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{site_name}", "{email}" , "{password}" , "{site_url}" , "{site_base_url}", "{activation_url}", "{activation_period}", "{image_base_url}","{crave_us}","{register_date}","{term_link}","{facebook_url}","{linkedin_url}");
            $replaceArray = array($site_name, $email, $password,$site_url, $site_base_url, $activation_url,"48",$image_base_url,$crave_us,$register_date,$term_link,$facebook_url,$linkedin_url);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    function test_activate_template($html='')
    {
        //Get template body of report
                $where=array('purpose'=>'activate','active'=>1);
                $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
                $site_name = 'toadsquare';
                $user_id = 21;
                $new_email_key = 'test123';
                $activation_period = 5;
                $email = 'tosifqureshi@cdnsol.com';
                $password = 'cdn12345';
                $site_base_url = site_url('');
                
                $site_url = site_url('/auth/activate/'.$user_id.'/'.$new_email_key); 
                
                /* while we don't remove restriction (username, password) in .htacess file  from live site*/
                $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
                $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
                /* Set Follow us link*/
                $facebook_url = $this->config->item('facebook_follow_url');
                $linkedin_url = $this->config->item('linkedin_follow_url');
                if($reportTemplateRes) {
                    $reportTemplate=$reportTemplateRes[0]->templates;
                    $searchArray = array("{site_name}", "{email}" , "{password}" , "{site_url}" , "{site_base_url}", "{activation_url}", "{activation_period}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}");
                    $replaceArray = array($site_name, $email, $password,$site_url, $site_base_url, $site_base_url,"48",$image_base_url,$crave_us,$facebook_url,$linkedin_url);
                    $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
                    $forgotPasswordSubject=$reportTemplateRes[0]->subject;
                }
                else {
                    $forgotPasswordTemplate='';
                    $forgotPasswordSubject='';
                }
                if($html=='html'){
                    echo $forgotPasswordTemplate;
                }else{
                    if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                        $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
                    }
                }
    }
    
    //-----------------------------------------------------------------------
    function test_reset_template($html='')
    {
        //Get template body of report
                $where=array('purpose'=>'reset_password','active'=>1);
                $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
                $site_name = 'toadsquare';
                $email = 'tosifqureshi@cdnsol.com';
                $username = 'Test Name';
                $site_base_url = site_url('');
                $site_url = site_url('');
                /* while we don't remove restriction (username, password) in .htacess file  from live site*/
                $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
                $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
                /* Set Follow us link*/
                $facebook_url = $this->config->item('facebook_follow_url');
                $linkedin_url = $this->config->item('linkedin_follow_url');
                if (strlen($username) > 0) {
                    $yourName = '<tr style="padding-top:9px;">
                            <td style="font-size:13px; font-weight:bold; color:#444444; padding-left:32px; width:110px;">User Name	:</td>
                            <td style="color:#f15921;font-size:13px; font-weight:bold;"> '.$username.' </td>
                          </tr>';
                }
                else{
                    $yourName = '';
                }
                if($reportTemplateRes) {
                    $reportTemplate=$reportTemplateRes[0]->templates;
                    $searchArray = array("{site_name}", "{email}" , "{username}" , "{site_base_url}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}");
                    $replaceArray = array($site_name, $email, $yourName, $site_base_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url);
                    $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
                    $forgotPasswordSubject=$reportTemplateRes[0]->subject;
                }
                else {
                    $forgotPasswordTemplate='';
                    $forgotPasswordSubject='';
                }
                if($html=='html'){
                    echo $forgotPasswordTemplate;
                }else{
                    if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                        $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
                    }
                }
    }
    
    //-----------------------------------------------------------------------
        
    function test_admin_template($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'adminmailing','active'=>1);
        $adminTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );

        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_url = 'http://www.toadsquare.com/en/showcase/index/4';
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        
        if($adminTemplateRes) {
            $adminTemplate = $adminTemplateRes[0]->templates;
            $searchArray = array("{mailBody}","{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{site_email}","{site_link}");
            $replaceArray = array('What is Toadsquare? It’s your one-stop shop for talent and entertainment. Your online showcase, job centre and marketplace. Like Montparnasse in early 20th-century Paris, Toadsquare is the heart of creativity in all its modes… ',$image_base_url,$crave_url,$facebook_url,$linkedin_url,'info@toadsquare.com','www.toadsquare.com');
            $adminMailTemplate = str_replace($searchArray, $replaceArray, $adminTemplate);
        }
        echo $adminMailTemplate;
    }
    
    //-----------------------------------------------------------------------
    
    function secondary_template($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'secondaryemailactivate','active'=>1);
        $adminTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );

        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_url = 'http://www.toadsquare.com/en/showcase/index/4';
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        $activation_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/auth/activate/155/d1901ab93261d9d517fab864819a740f';
        if($adminTemplateRes) {
            $adminTemplate = $adminTemplateRes[0]->templates;
            $searchArray = array("{email_activation_url}","{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}");
            $replaceArray = array($activation_url,$image_base_url,$crave_url,$facebook_url,$linkedin_url);
            $adminMailTemplate = str_replace($searchArray, $replaceArray, $adminTemplate);
        }
        echo $adminMailTemplate;
    }
    
    //-----------------------------------------------------------------------
    
    function PriceUpdate($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'emailupdateprice','active'=>1);
        $adminTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );

        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_url = 'http://www.toadsquare.com/en/showcase/index/4';
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        $activation_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/auth/activate/155/d1901ab93261d9d517fab864819a740f';
        $membership_info_url = site_url('package/information'); 	
        if($adminTemplateRes) {
            $adminTemplate = $adminTemplateRes[0]->templates;
            $searchArray = array("{membership_info_url}","{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}");
            $replaceArray = array($membership_info_url,$image_base_url,$crave_url,$facebook_url,$linkedin_url);
            $adminMailTemplate = str_replace($searchArray, $replaceArray, $adminTemplate);
            $forgotPasswordSubject = $adminTemplateRes[0]->subject;
        }
        if($html=='html'){
                    echo $adminMailTemplate;
                }else{
                    if((!empty($adminMailTemplate)) && (!empty($forgotPasswordSubject))){
                        $this->send_email_template($adminMailTemplate,$forgotPasswordSubject);	
                    }
                }
    }
       
    //-----------------------------------------------------------------------
            
    //Event with launch deleted
    function event_delete($html='')
    {
        //echo $from_email = $this->config->item('facebook_follow_url');die;
        //Get template body of report
        $where=array('purpose'=>'eventwithlaunchdeleted','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $site_url = site_url('');
        $launch_name = 'Extract of AKON';
        $user_name = 'Perminder Singh';

        $user_showcase = base_url().lang().'/showcase/aboutme/21';
        $site_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
    
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        $facebook_url = 'http://www.facebook.com/pages/Toadsquare/121921117888970';
        $linkedin_url = 'http://www.linkedin.com/company/toadsquare?trk=hb_tab_compy_id_3001132';
        $launch_show_url ='http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/mediafrontend/filmvideo/21/2/268/filmvideo';
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;

            $searchArray = array("{launch_name}", "{launch_showcase_url}" , "{user_name}" , "{site_url}" , "{site_base_url}", "{image_base_url}", "{crave_us}","{user_showcase}","{facebook_url}","{linkedin_url}");
            $replaceArray = array($launch_name,$launch_show_url, $user_name, $site_url,$site_base_url,$image_base_url,$crave_us,$user_showcase,$facebook_url,$linkedin_url,$facebook_url,$linkedin_url);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    //Date change of launch
    function launch_change($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'launchdatechange','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $launch_name = "Australia's sporting launch events";
        $start_at = '14 May 2013 ';
        $end_at = '16 May 2013';
        $site_url = site_url('');
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        $showcase_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/eventfrontend/eventlaunch/21/65';
        /* Set Follow us link*/
                $facebook_url = $this->config->item('facebook_follow_url');
                $linkedin_url = $this->config->item('linkedin_follow_url');
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{launch_name}", "{start_at}" , "{end_at}" , "{site_url}" , "{site_base_url}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{showcase_url}");
            $replaceArray = array($launch_name, $start_at,$end_at, $site_url,$site_base_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url,$showcase_url);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
        
    }
    
    //-----------------------------------------------------------------------
    
    //Date change of launch
    function time_change($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'timechange','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $event_name = "Australia's sporting launch events";
        $start_at = '18:00';
        $end_at = '17:00';
        $on_date = '7 March 2013';
        $site_url = site_url('');
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        $showcase_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/eventfrontend/eventlaunch/21/65';
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{event_name}", "{start_time}" , "{end_time}" , "{on_date}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{event_showcase_url}");
            $replaceArray = array($event_name, $start_at,$end_at,$on_date,$image_base_url,$crave_us,$facebook_url,$linkedin_url,$showcase_url);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
        
    }
    
    //-----------------------------------------------------------------------
    
    //Membership refund
    function membership_refund($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'membershiprefund','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $refund_cost = '5.00';
        $memdership_type = 'Tool Work';
        $space = '150';
        $paypal_email = 'test@cdnsol.com';
        $site_url = site_url('');
        
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        $purchase_link = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/package/purchases';
        /* Set Follow us link*/
                $facebook_url = $this->config->item('facebook_follow_url');
                $linkedin_url = $this->config->item('linkedin_follow_url');
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{refund_cost}", "{memdership_type}" , "{space}" , "{paypal_email}", "{site_url}" , "{site_base_url}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{purchase_page_url}");
            $replaceArray = array($refund_cost, $memdership_type,$space,$paypal_email,$site_url,$site_base_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url,$purchase_link);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    //Purchase on toadsquare
    function purchase($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'purchaseontoadsquare','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $purchase_title = 'Test purchase';
        $site_url = site_url('');
        $purchase_link = site_url(lang()).'/cart/purchase';
        $record_url = site_url(lang()).'/cart/sales_record_print/243';
        $comment_url =site_url(lang()).'/cart/purchase';
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        $item_body = '<a      href="http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/mediafrontend/searchresult/21/2/filmvideo" style="color:#848484;">AKON2</a>';
        $purchase_page='http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/cart/purchase';
        /* Set Follow us link*/
                $facebook_url = $this->config->item('facebook_follow_url');
                $linkedin_url = $this->config->item('linkedin_follow_url');
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{purchase_title}", "{site_url}" , "{site_base_url}", "{image_base_url}","{crave_us}","{purchase_link}","{record_url}","{comment_url}","{facebook_url}","{linkedin_url}","{item_body}","{purchase_page_url}");
            $replaceArray = array($purchase_title, $site_url,$site_base_url,$image_base_url,$crave_us,$purchase_link,$record_url,$comment_url,$facebook_url,$linkedin_url,$item_body,$purchase_page);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    // Tool Purchase on toadsquare
    function tool_purchase($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'toolpurchase','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $purchase_title = 'Test purchase';
        $site_url = site_url(lang()).'/dashboard';
        
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        $purchase_link = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/package/purchases';
        /* Set Follow us link*/
                $facebook_url = $this->config->item('facebook_follow_url');
                $linkedin_url = $this->config->item('linkedin_follow_url');
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{dashboard_url}" , "{site_base_url}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{invoice_name}","{purchase_page_url}");
            $replaceArray = array($site_url,$site_base_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url,'Purchases',$purchase_link);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    //Reminder of Event
    function event_reminder($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'reminderofevent','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $launch_name = "Australia's sporting events";
        $site_url = site_url('');
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        $launch_showcase_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/eventfrontend/event/21/179';
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{launch_name}", "{site_url}" , "{site_base_url}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{launch_showcase_url}");
            $replaceArray = array($launch_name, $site_url,$site_base_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url,$launch_showcase_url);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    //Sale on toad
    function sale($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'salesontoadsquare','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $item_title = 'Test Title';
        $site_url = site_url('');
        
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        $salepage_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/cart/sales';
        $item_body = '<a href="http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/mediafrontend/searchresult/85/62/filmvideo" style="color:#848484;">Water Project</a>';
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{item_title}", "{site_url}" , "{site_base_url}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{salespage_url}","{item_body}");
            $replaceArray = array($item_title, $site_url,$site_base_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url,$salepage_url,$item_body);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    //Membership expiring
    function membership_expiring($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'membershipexpiring','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $site_url = site_url('');
        
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{site_url}" , "{site_base_url}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}");
            $replaceArray = array($site_url,$site_base_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    //Tool expiring
    function tool_expiring($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'toolexpiring','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $tool_title = 'Test offered';
        $site_url = site_url('');
        $dashboard_url = site_url('').lang().'/dashboard';
        $tool_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/dashboard/work';
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{tool_title}" , "{dashboard_url}" , "{site_url}" , "{site_base_url}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{tool_url}");
            $replaceArray = array($tool_title,$dashboard_url,$site_url,$site_base_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url,$tool_url);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    //Report problem personal opinion
    function report_personal_opinion($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'reportproblempersonalopinion','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $abusiveByUser_firstName = 'Perminder';
        $abusiveByUser_lastName = 'Singh'; 
        $SupportingProjectName = 'Main Movie of Rex and Rooty';
        $description = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.';

        $email = 'test@cdnsol.com';
        $site_url = site_url('');
        
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        $user_showcase_url = site_url(lang()).'/showcase/aboutme/21';
        $project_showcase_url = site_url(lang()).'/mediafrontend/filmvideo/85/29/284/filmvideo';
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;

            $searchArray = array("{abusiveByUser_firstName}" , "{abusiveByUser_lastName}" , "{SupportingProjectName}" , "{description}" , "{abusiveByUser_email}" , "{site_base_url}" , "{site_url}" , "{image_base_url}","{crave_us}","{user_showcase_url}","{project_showcase_url}","{facebook_url}","{linkedin_url}");
            $replaceArray = array($abusiveByUser_firstName,$abusiveByUser_lastName,$SupportingProjectName,$description,$email,$site_base_url,$site_url,$image_base_url,$crave_us,$user_showcase_url,$project_showcase_url,$facebook_url,$linkedin_url);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    //Report problem Block content
    function report_block_content($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'reportproblemblockcontent','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $abusiveByUser_firstName = 'Perminder';
        $abusiveByUser_lastName = 'Singh'; 
        $SupportingProjectName = 'Water Project';

        $description = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.';
        $email = 'test@cdnsol.com';
        $reportType = 'Privacy concerns.';
        $site_url = site_url('');

        
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        $user_showcase_url = site_url(lang()).'/showcase/aboutme/21';
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        $project_showcase_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/mediafrontend/filmvideo/21/2/270/filmvideo';
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;

            $searchArray = array("{abusiveByUser_firstName}" , "{abusiveByUser_lastName}" , "{SupportingProjectName}"  , "{reportType}" , "{description}" , "{abusiveByUser_email}" , "{site_base_url}" , "{site_url}" , "{image_base_url}","{crave_us}","{user_showcase_url}","{facebook_url}","{linkedin_url}","{project_showcase_url}");
            $replaceArray = array($abusiveByUser_firstName,$abusiveByUser_lastName,$SupportingProjectName,$reportType,$description,$email,$site_base_url,$site_url,$image_base_url,$crave_us,$user_showcase_url,$facebook_url,$linkedin_url,$project_showcase_url );
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    //Report problem Block with other option content
    function report_block_other_type($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'reportproblemblockcontentotheroption','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $abusiveByUser_firstName = 'Perminder';
        $abusiveByUser_lastName = 'Singh'; 
        $SupportingProjectName = 'Water Project';
        $description = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.';
        $email = 'test@cdnsol.com';
        $site_url = site_url('');
        
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        $project_showcase_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/mediafrontend/filmvideo/21/2/270/filmvideo';
        $user_showcase_url = site_url(lang()).'/showcase/aboutme/21';
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{abusiveByUser_firstName}" , "{abusiveByUser_lastName}" , "{SupportingProjectName}"  , "{description}" , "{abusiveByUser_email}" , "{site_base_url}" , "{site_url}", "{image_base_url}","{crave_us}","{user_showcase_url}","{facebook_url}","{linkedin_url}","{project_showcase_url}");
            $replaceArray = array($abusiveByUser_firstName,$abusiveByUser_lastName,$SupportingProjectName,$description,$email,$site_base_url,$site_url,$image_base_url,$crave_us,$user_showcase_url,$facebook_url,$linkedin_url,$project_showcase_url);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    //terms Tmail
    function terms($html='')
    {
        $description = $this->model_cms->get_description(1);
        $terms_description = str_replace("<br>", "", $description[0]['description']);
        $download_link ='http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/cms/downloadtandc';
        //$terms_description  ='Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa q';
        $where=array('purpose'=>'termsandcondition','active'=>1);
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
            $searchArray = array("{terms_description}","{image_base_url}","{terms_url}","{facebook_url}","{linkedin_url}","{crave_us}");
            $replaceArray = array($terms_description,$image_base_url,$download_link,$facebook_url,$linkedin_url,$crave_us);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        if($html=='html'){
            //echo $forgotPasswordSubject;
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }	
            
    }
    
    //-----------------------------------------------------------------------
    
    //Welcome_tmail
    function welcome_tmail($html='')
    {
        $register_date = date("j F Y") . ' at ' . date("G:i");
        $where=array('purpose'=>'welcomemessage','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        
        $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{siteName}","{register_date}");
            $replaceArray = array($this->config->item('website_name', ''),$register_date );
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //Reminder Tmail
    function reminder_tmail($html='')
    {
        $where=array('purpose'=>'tmailreminderofevent','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{launch_name}");
            $replaceArray = array('Test Launch');
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //launch date Tmail
    function date_tmail($html='')
    {
        $where=array('purpose'=>'tmaillaunchdatechange','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{event_name}","{start_at}","{end_at}");
            $replaceArray = array('Test Launch','7 March 2013','8 March 2013');
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //launch date Tmail
    function delete_event_tmail($html='')
    {
        $where=array('purpose'=>'tmaileventwithlaunchdeleted','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{launch_name}","{user_name}");
            $replaceArray = array('Test Launch','Perminder singh');
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //launch date Tmail
    function refund_tmail($html='')
    {
        $where=array('purpose'=>'tmailmembershiprefund','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{refund_cost}","{memdership_type}","{space}","{paypal_email}");
            $replaceArray = array('&euro;10','Tool Work','50','test@gmail.com');
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //launch date Tmail
    function membership_expire_tmail($html='')
    {
        $where=array('purpose'=>'tmailmembershipexpiring','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{refund_cost}","{memdership_type}","{space}","{paypal_email}");
            $replaceArray = array('1000','Standard','50','test@gmail.com');
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //Tool  Tmail
    function tool_expire_tmail($html='')
    {
        $where=array('purpose'=>'tmailtoolexpiring','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{tool_title}","{tool_text}","{tool_item_title}");
            $replaceArray = array('Test Tool','Dhoom 2',"5");
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //launch date Tmail
    function purchase_tmail($html='')
    {
        $where=array('purpose'=>'tmailpurchaseontoadsquare','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $item_body = '<a href="http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/mediafrontend/searchresult/85/62/filmvideo" style="color:#848484;text-decoration: underline;">Water Project</a>';
        $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{purchase_title}","{record_url}","{site_url}","{comment_url}","{item_body}");
            $replaceArray = array('TestPurchase',site_url(lang()),site_url(lang()),site_url(lang()),$item_body);
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //ticket date Tmail
    function ticket_tmail($html='')
    {
        $where=array('purpose'=>'tmaileventicket','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{event_title}","{purchase_page_url}");
            $replaceArray = array('Test Event',site_url(lang()));
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //launch date Tmail
    function sale_tmail($html='')
    {
        $where=array('purpose'=>'tmailsalesontoadsquare','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $item_body = '<a href="http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/mediafrontend/searchresult/85/62/filmvideo" style="color:#848484;text-decoration: underline;">Water Project</a>';
        $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{item_title}","{item_body}");
            $replaceArray = array('Test Title',$item_body);
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //Personal report Tmail
    function personal_tmail($html='')
    {
        $where=array('purpose'=>'tmailreportproblempersonalopinion','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
            $searchArray = array("{abusiveByUser_firstName}","{abusiveByUser_lastName}","{SupportingProjectName}","{description}","{abusiveByUser_email}","{image_base_url}");
            $replaceArray = array('Perminder','Singh','Test Project','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.','test@gmail.com',$image_base_url);
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //illegal report Tmail
    function illegal_tmail($html='')
    { 	$reportType = 'Privacy concerns.';
        $where=array('purpose'=>'tmailreportproblemblockcontent','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
            $searchArray = array("{abusiveByUser_firstName}","{abusiveByUser_lastName}","{SupportingProjectName}","{description}","{abusiveByUser_email}","{image_base_url}","{reportType}");
            $replaceArray = array('Perminder','Singh','Test Project','This is test desc','test@gmail.com',$image_base_url,$reportType);
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //illegal report Tmail
    function other_illegal_tmail($html='')
    {
        $where=array('purpose'=>'tmailreportproblemblockcontentotheroption','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
            $searchArray = array("{abusiveByUser_firstName}","{abusiveByUser_lastName}","{SupportingProjectName}","{description}","{abusiveByUser_email}","{image_base_url}");
            $replaceArray = array('Perminder','Singh','Test Project','This is test desc','test@gmail.com',$image_base_url);
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);

            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //terms Tmail
    function terms_tmail($html='')
    {
        $where=array('purpose'=>'tmailtermsandcondition','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
            $searchArray = array("{description}","{image_base_url}");
            $replaceArray = array('Testing desc',$image_base_url);
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    function update_price_tmail($html='')
    {
        $where=array('purpose'=>'tmailpriceupdate','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
        $membership_info_url = site_url().'package/packageinformation';
            $searchArray = array("{membership_info_url}");
            $replaceArray = array($membership_info_url);
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    function tool_purchase_tmail($html='')
    {
        $where=array('purpose'=>'tmailtoolpurchase','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
        $dashboard_url = site_url().'dashboard';
            $searchArray = array("{tool_name}","{dashboard_url}");
            $replaceArray = array('Test Tool',$dashboard_url);
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //Membership purchase
    function membership_purchase($html='')
    {
        $where=array('purpose'=>'membershippurchase','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $site_base_url = site_url('');
        $purchase_record_url = site_url('');
            $searchArray = array("{purchase_record_url}","{site_base_url}","{image_base_url}");
            $replaceArray = array($purchase_record_url,$site_base_url,$image_base_url);
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //Membership purchase
    function tmail_membership_purchase($html='')
    {
        $where=array('purpose'=>'tmailmembershippurchase','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
        $purchase_record_url = site_url('');
            $searchArray = array("{purchase_record_url}");
            $replaceArray = array($purchase_record_url);
            $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
            $recipients_email = array(134);
            if(!empty($html)){
                $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
            }else{
                echo $forgotPasswordTemplate['body'];
            }
    }
    
    //-----------------------------------------------------------------------
    
    //Event ticket & meeting
    function event_ticket_meeting($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'event_ticket','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $tool_title = 'Test Title';
        $site_url = site_url('');
        $event_url = site_url('').lang().'/dashboard';
        
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        $event_name = "Australia's sporting launch events";
        $event_showcase_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/en/eventfrontend/eventlaunch/21/65';
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        $purchase_link = site_url(lang()).'/cart/purchase';
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{tool_title}" , "{event_url}" , "{site_url}" , "{site_base_url}", "{image_base_url}","{crave_us}","{event_name}","{event_showcase_url}","{facebook_url}","{linkedin_url}","{purchase_page_url}");
            $replaceArray = array($tool_title,$event_url,$site_url,$site_base_url,$image_base_url,$crave_us,$event_name,$event_showcase_url,$facebook_url,$linkedin_url,$purchase_link);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
    
    
    //-----------------------------------------------------------------------
    
    //Tool Expried  Tmail
    function tmail_tool_expired($html='')
    {
        $where=array('purpose'=>'tmailtoolexpired','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
        $searchArray = array("{tool_title}","{tool_text}","{tool_item_title}",'{subject}');
        $replaceArray = array('Test Tool','Dhoom 2',"5",'Your Toadsquare Tool Has Expired');
        $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
        $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
        $recipients_email = array(134);
        if(!empty($html)){
            $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
        }else{
            echo $forgotPasswordTemplate['body'];
        }
    }
    
    
    //-----------------------------------------------------------------------
    
    //Get Tmail Testing function
    function tmail_get($html='')
    {
        $where=array('purpose'=>'contactme','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        $reportTemplate=$reportTemplateRes[0]->templates;
        
         echo $reportTemplateRes[0]->subject;
        echo "<br><br>";
        echo $reportTemplate;
       
        
        $searchArray = array("{tool_title}","{tool_text}","{tool_item_title}",'{subject}');
        $replaceArray = array('Test Tool','Dhoom 2',"5",'Your Toadsquare Tool Has Expired');
        $forgotPasswordTemplate['body']=str_replace($searchArray, $replaceArray, $reportTemplate);
        $forgotPasswordTemplate['subject']=$reportTemplateRes[0]->subject;
        $recipients_email = array(134);
        if(!empty($html)){
            $this->sendTmail($recipients_email,$forgotPasswordTemplate['subject'],$forgotPasswordTemplate['body']);
        }else{
            echo $forgotPasswordTemplate['body'];
        }
    }
    
    
    //-----------------------------------------------------------------------
    
    //Generate ticket Pdf
    function ticket_pdf()
    {
        $session_data = $this->model_common->ticket_session_data(233);
        if(isset($session_data->eventId) && !empty($session_data->eventId)){
            $event_data = $this->model_common->ticket_event_data($session_data->eventId);
        }else{
            $event_data = $this->model_common->ticket_launch_data($session_data->launchEventId);
        }
        $data['session_data'] =  $session_data;
        $data['event_data'] =  $event_data;
        $this->load->view('ticketPdf',$data) ;			
    }
    
    //-----------------------------------------------------------------------
    
    //Generate Event ticket Pdf
    function event_ticket_pdf($eventInvoiceId=0)
    {	
        if($eventInvoiceId != '0'){
            
            $eventInvoiceData = $this->model_common->ticket_invoice_data($eventInvoiceId);
            if(isset($eventInvoiceData) && !empty($eventInvoiceData)){
                $data['eventInvoiceData'] =  $eventInvoiceData;
                $data['eventInvoiceId'] =  $eventInvoiceId;
                $this->load->view('ticketPdf',$data) ;	
            }else{
                redirectToNorecord404();
            }
        }else{
            redirectToNorecord404();
        }
    }
    
    //-----------------------------------------------------------------------
    
    //Generate ticket attendees listing
    function ticketAttendeesList($sessionId=0)
    {
        if($sessionId!=0){
            //Get sessions ticket transaction details
            $ticketSessionList = $this->model_common->ticketTransactionListing($sessionId);
            
            //Get session data
            $session_data = $this->model_common->ticket_session_data($sessionId);
            
            //Get Event details
            if(isset($session_data->eventId) && !empty($session_data->eventId)){
                $event_data = $this->model_common->ticket_event_data($session_data->eventId);
            }elseif(isset($session_data->launchEventId) && !empty($session_data->launchEventId)){
                $event_data = $this->model_common->ticket_launch_data($session_data->launchEventId);
            }else{
                $event_data = "";
            }
            $data['sessionVanue'] = isset($session_data->venueName) && !empty($session_data->venueName) ?$session_data->venueName:'';
            $ticketdata['eventTitle'] = isset($event_data->Title) && !empty($event_data->Title) ?$event_data->Title:'';
            $ticketdata['sessionDate'] = isset($ticketSessionList[0]->date) && !empty($ticketSessionList[0]->date) ?$ticketSessionList[0]->date:'';
            $ticketdata['ticketSessionList'] = $ticketSessionList;
            $ticketTransactionData[] = $ticketdata;
        } else{
            //Get all sessions ticket transaction details
            $sessionData = $this->model_common->ticketSession();
            //$ticketTransactionData = array();
            foreach($sessionData as $sessionData){
                $ticketSessionList = $this->model_common->ticketTransactionListing($sessionData->sessionId);
                //Get session data
                $session_data = $this->model_common->ticket_session_data($sessionData->sessionId);
                //Get Event details
                if(isset($session_data->eventId) && !empty($session_data->eventId)){
                    $event_data = $this->model_common->ticket_event_data($session_data->eventId);
                }else{
                    $event_data = $this->model_common->ticket_launch_data($session_data->launchEventId);
                }
                
                $ticketdata['eventTitle'] = $event_data->Title;
                $ticketdata['sessionDate'] = $sessionData->date;
                $ticketdata['ticketSessionList'] = $ticketSessionList;
                $ticketTransactionData[] = $ticketdata;
                echo "<pre>";
                print_r($ticketTransactionData);die;
            }
        }
        
        $data['ticketTransactionData'] =  $ticketTransactionData;
        $this->load->view('ticketAttendeeList',$data) ;			
    }
    
    //-----------------------------------------------------------------------
    
    function checkPaypalaccount(){
        
        $this->config->load('paypal');
        
        $config = array(
            'Sandbox' => $this->config->item('Sandbox'), 			// Sandbox / testing mode option.
            'APIUsername' => $this->config->item('APIUsernameLive'), 	// PayPal API username of the API caller
            'APIPassword' => $this->config->item('APIPasswordLive'), 	// PayPal API password of the API caller
            'APISignature' => $this->config->item('APISignatureLive'), 	// PayPal API signature of the API caller
            'APISubject' => '', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
            'APIVersion' => $this->config->item('APIVersionLive'), 		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
            'DeviceID' => $this->config->item('DeviceID'), 
            'ApplicationID' => $this->config->item('ApplicationID'), 
            'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
        );
        
        //$this->load->library('paypal/Paypal_pro', $config); 
        
        require_once(APPPATH.'libraries/paypal/Paypal_pro.php'); 
        
        $PayPal = new Paypal_pro($config);
            
        //$DataArray['AVFields']=array('EMAIL'=>'sushilmca2007@gmail.com','STREET'=>'','ZIP'=>'452001');
        $DataArray['AVFields']=array('EMAIL'=>'per@toadsquare.com','STREET'=>'1 Main St','ZIP'=>'95131');
        $data=$PayPal->AddressVerify($DataArray);
        
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        
    }
    
    //-----------------------------------------------------------------------
          
function testipn(){
                      
    foreach ($_REQUEST as $key => $value) { $message .= "\n$key: $value<br>"; } 
    
    $message .= 'currentbasket'.$this->input->get('currentbasket') ; 
    $this->email->from('your@example.com', 'Your Name');
    $this->email->to('amitwali@cdnsol.com');
    $this->email->subject('subject');
    $this->email->message($message);
    $this->email->send();   
     echo "SEND";
      } 
      
    //Get Ticket Log listings
    function ticketLogListing($eventId=0)
    {
        
    }
    
    //Set tmail view
    function tmail_display()
    {
        $method = $this->input->get('val1');
        $templateData = $this->$method();
        $data['tmailSubject'] = $templateData['subject'];
        $data['tmailBody'] = $templateData['body'];
        
        //echo $data['tmailBody'];
        $this->load->view('tmail_display',$data) ;		
    }
    
    //Display tmail listing
    function tmail_listing()
    {
        $this->load->view('tmail_listing') ;		
    }
    
    function assignExtraFreePackageToUaser($userId=0,$tsProductId=0,$quntity=0){
            if($userId >0 && $tsProductId >0 && $quntity >0){
                $uc = new lib_userContainer();
                $uc->assignExtraFreePackageToUaser($userId,$tsProductId,$quntity);
            }else{
                    echo "please provede userId, tsProductId & quntity";
            }
    }
    
    // Send mail to paypal based on these credentials 	
    function verifyAddress(){

        $this->config->load('paypal');
        
        $config = array(
            'Sandbox' => FALSE, 			// Sandbox / testing mode option.
            'APIUsername' => 'accounts_api1.toadsquare.com', 	// PayPal API username of the API caller
            'APIPassword' => 'VDX9V5CPUGAARJF8', 	// PayPal API password of the API caller
            'APISignature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31ADJTKr7LS5OkGqfsP8A4V85v7TeB', 	// PayPal API signature of the API caller
            'APISubject' => '', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
            'APIVersion' => '94.0', 		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
            'DeviceID' => '', 
            'ApplicationID' => '', 
            'DeveloperEmailAccount' => 'APP-2E454556LR591923K'
        );
    
        //$this->load->library('paypal/Paypal_pro', $config); 
        
        require_once(APPPATH.'libraries/paypal/Paypal_pro.php'); 
        
        $PayPal = new Paypal_pro($config);
            
        //$DataArray['AVFields']=array('EMAIL'=>'sushilmca2007@gmail.com','STREET'=>'','ZIP'=>'452001');
        $DataArray['AVFields']=array('EMAIL'=>'saul.rudnick@optusnet.com.au','STREET'=>'8 Dent Street','ZIP'=>'2019');
        $data=$PayPal->AddressVerify($DataArray);
        
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        
    }

    function downloadFileList(){
        $userId=$this->isLoginUser();
        $this->template_front_end->load('template_front_end','test/file_list');
    }
    
    function download($FD=''){
        $this->load->model('download/model_download');
        $userId=isLoginUser();
        $FD =  ucfirst($FD);
        $FD =  decode($FD);
        $FD = explode('+',$FD);
        $isfileFound=false;
        $sellstatus=false;
        if(isset($FD[0]) && ($FD[0] >0) && isset($FD[1]) && ($FD[1] >0) && isset($FD[2]) && ($FD[2] >0) && isset($FD[3]) && ($FD[3] >0) && isset($FD[4]) && is_numeric($FD[4]) && isset($FD[5]) && (strlen($FD[5])>1) && isset($FD[6]) && (strlen($FD[6])>1) && isset($FD[7]) && isset($FD[8]) && isset($FD[9]) && is_numeric($FD[9])){
            $buyerId=(isset($FD[10]) && ($FD[10] >0))?$FD[10]:0; 
            $dwnId=(isset($FD[11]) && ($FD[11] >0))?$FD[11]:0;
            
            $FD=array(
                        'ownerId'=>$FD[0],
                        'entityId'=>$FD[1],
                        'elementId'=>$FD[2],
                        'projectId'=>$FD[3],
                        'fileId'=>$FD[4],
                        'tableName'=>$FD[5],
                        'primeryField'=>$FD[6],
                        'elementTable'=>$FD[7],
                        'elementPrimeryField'=>$FD[8],
                        'isElement'=>$FD[9],
                        'buyerId'=>$FD[10],
                        'dwnId'=>$FD[11]
            );
            
            $fileDetails=$this->model_download->getDownloadFile($FD);
            if($fileDetails && isset($fileDetails[0]['fileId']) && $fileDetails[0]['fileId'] > 0){
                if($FD['isElement']==1 && ($fileDetails[0]['projCategory'] !=1 &&  $fileDetails[0]['projCategory'] !=6)){ //projCategory==1 =>major F&V and projCategory==6 =>major W&P
                    
                    $fileName=trim($fileDetails[0]['fileName']);
                    $filePath=trim($fileDetails[0]['filePath']);
                    $fpLen=strlen($filePath);
                    if($fpLen > 0 && substr($filePath,-1) != '/'){
                        $filePath=$filePath.'/';
                    }
                    $file=$filePath.$fileName;
                    if(is_file($file)){
                        $isfileFound=true;
                        if($fileDetails[0]['projSellstatus']=='f' || $fileDetails[0]['isDownloadPrice']=='f'){
                            
                        }else{
                            $sellstatus=true;
                        }
                    }else{
                        
                    }
                }else{
                    $isfileFound=true;
                    if($fileDetails[0]['projSellstatus']=='t' && $fileDetails[0]['isprojDownloadPrice']=='t'){
                        $sellstatus=true;
                    }
                }
                if($isfileFound){
                    if($sellstatus){
                        $authorisedUser=false;
                        $buyerId=$userId;
                        
                        if($dwnId > 0){
                            $whereField=array('dwnId'=>$dwnId,'userId'=>$buyerId);
                            $purchaseData=$this->model_common->getDataFromTabel('SalesItemDownload', $field='*',  $whereField, '', '', 'ASC', 1 );
                            
                            
                            
                            if($purchaseData && isset($purchaseData[0])){
                                    $purchaseData=$purchaseData[0];
                                    
                                    $dwnMaxday = $purchaseData->dwnMaxday;
                                    $expiryDate= getPreviousOrFututrDate($purchaseData->dwnDate, '+'.$dwnMaxday.' day' ,$format='Y-m-d');
                                    $currentDate=date('Y-m-d');
                                    if(strtotime($currentDate) <= strtotime($expiryDate)){
                                        $authorisedUser=true;
                                    }
                            }
                            
                        }
                        if(!$authorisedUser){
                            $msg=$this->lang->line('notAuthorisedToDownload');
                            set_global_messages($msg, $type='error', $is_multiple=true);
                            redirect('home');
                            exit;
                        }
                    }
                    $inserData=array();
                    $isfileFound=false;
                    if((strlen($FD['elementTable']) > 1) && (strlen($FD['elementPrimeryField']) > 1)){
                        $entityId=getMasterTableRecord($FD['elementTable']);
                    }else{
                        $entityId=$FD['entityId'];
                    }
                    foreach($fileDetails as $k=>$files){
                        $fileName=trim($files['fileName']);
                        $copyFileName=trim($files['rawFileName']);
                        $copyFileName=($copyFileName!='')?$copyFileName:$fileName;
                        $copyFileName=str_replace(' ','_',$copyFileName);
                        $filePath=trim($files['filePath']);
                        $fpLen=strlen($filePath);
                        if($fpLen > 0 && substr($filePath,-1) != '/'){
                            $filePath=$filePath.'/';
                        }
                        $file=$filePath.$fileName;
                        if(is_file($file)){
                            $isfileFound=true;
                            if((strlen($FD['elementTable']) > 1) && (strlen($FD['elementPrimeryField']) > 1)){
                                $elementId=$files['elementId'];
                            }else{
                                $elementId=$FD['elementId'];
                            }
                            $inserData[]=array(
                                            'downloadByUser'=>$userId,
                                            'entityId'=>$entityId,
                                            'elementId'=>$elementId,
                                            'projectId'=>$FD['projectId'],
                                            'ownerId'=>$FD['ownerId'],
                                            'fileId'=>$files['fileId'],
                                            'date'=>currntDateTime()
                                        );
                            $dwnWhere=array(
                                'entityId'=>$entityId,
                                'elementId'=>$elementId
                            );
                            $dwnRes=$this->model_common->getDataFromTabel('LogSummary', 'actId,dwnCount',  $dwnWhere, '', '', '', 1 );
                            if($dwnRes){
                                $dwnRes=$dwnRes[0];
                                $actId=$dwnRes->actId;
                                $dwnCount=($dwnRes->dwnCount+1);
                                $updateData=array(
                                    'dwnCount'=>$dwnCount
                                );
                                $this->model_common->editDataFromTabel('LogSummary', $updateData, 'actId', $actId);
                            }else{
                                $dwnCount=1;
                                $dwnData=array(
                                    'entityId'=>$entityId,
                                    'elementId'=>$elementId,
                                    'dwnCount'=>$dwnCount,
                                    'createDate'=>currntDateTime()
                                );
                                $this->model_common->addDataIntoTabel('LogSummary', $dwnData);
                            }
                        }
                    }
                    if(count($inserData) > 0){
                        $this->model_common->insertBatch($table='LogDownload', $inserData);
                        $this->downloadFile($filePath,$fileName,$copyFileName);
                        return true;
                    }
                } 
                if(!$isfileFound){
                    $msg=$this->lang->line('fileNotFound');
                    set_global_messages($msg, $type='error', $is_multiple=true);
                    redirect('home');
                    exit;
                }
            }
        }
    }
    
    function downloadFile($filePath='',$fileName='',$dwnFileName=''){ 
        $file=$filePath.$fileName;
        if(is_file($file)){
            if($dwnFileName==''){
                $dwnFileName=$fileName;
            }
            $fsize = filesize($file);
            $fileInfo=pathinfo($file);
            $extension=$fileInfo['extension'];
            $extension = strtolower($extension);
            switch($extension) { case 'jar': $mime = "application/java-archive"; break; case 'zip': $mime = "application/zip"; break; case 'jpeg': $mime = "image/jpeg"; break; case 'jpg': $mime = "image/jpg"; break; case 'jad': $mime = "text/vnd.sun.j2me.app-descriptor"; break; case "gif": $mime = "image/gif"; break; case "png": $mime = "image/png"; break; case "pdf": $mime = "application/pdf"; break; case "txt": $mime = "text/plain"; break; case "doc": $mime = "application/msword"; break; case "ppt": $mime = "application/vnd.ms-powerpoint"; break; case "wbmp": $mime = "image/vnd.wap.wbmp"; break; case "wmlc": $mime = "application/vnd.wap.wmlc"; break; case "mp4s": $mime = "application/mp4"; break; case "ogg": $mime = "application/ogg"; break; case "pls": $mime = "application/pls+xml"; break; case "asf": $mime = "application/vnd.ms-asf"; break; case "swf": $mime = "application/x-shockwave-flash"; break; case "mp4": $mime = "video/mp4"; break; case "m4a": $mime = "audio/mp4"; break; case "m4p": $mime = "audio/mp4"; break; case "mp4a": $mime = "audio/mp4"; break; case "mp3": $mime = "audio/mpeg"; break; case "m3a": $mime = "audio/mpeg"; break; case "m2a": $mime = "audio/mpeg"; break; case "mp2a": $mime = "audio/mpeg"; break; case "mp2": $mime = "audio/mpeg"; break; case "mpga": $mime = "audio/mpeg"; break; case "wav": $mime = "audio/wav"; break; case "m3u": $mime = "audio/x-mpegurl"; break; case "bmp": $mime = "image/bmp"; break; case "ico": $mime = "image/x-icon"; break; case "3gp": $mime = "video/3gpp"; break; case "3g2": $mime = "video/3gpp2"; break; case "mp4v": $mime = "video/mp4"; break; case "mpg4": $mime = "video/mp4"; break; case "m2v": $mime = "video/mpeg"; break; case "m1v": $mime = "video/mpeg"; break; case "mpe": $mime = "video/mpeg"; break; case "mpeg": $mime = "video/mpeg"; break; case "mpg": $mime = "video/mpeg"; break; case "mov": $mime = "video/quicktime"; break; case "qt": $mime = "video/quicktime"; break; case "avi": $mime = "video/x-msvideo"; break; case "midi": $mime = "audio/midi"; break; case "mid": $mime = "audio/mid"; break; case "amr": $mime = "audio/amr"; break; default: $mime = "application/octet-stream"; } header('Content-Description: File Transfer'); header('Content-Type: '.$mime); header('Content-Disposition: attachment; filename='.basename($dwnFileName)); header('Content-Transfer-Encoding: binary'); header('Expires: 0'); header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); header('Pragma: public'); header('Content-Length: ' . filesize($file)); ob_clean(); flush(); readfile($file);
        }
    }
    
    /*function authenticate() {
        //put in header
        if((!isset($_SERVER['PHP_AUTH_USER'])) && (!isset($_SERVER['PHP_AUTH_PW']))) { authenticate(); }else{}
        
        header('WWW-Authenticate: Basic realm="Restricted Area Need Login Credentials."');
        header('HTTP/1.0 401 Unauthorized');
        echo "You must enter a valid login ID and password to get access to this area\n";
        exit;
    }*/
    function testTmail(){
        $recipients = array(134);
        $msg = $this->tmail_messaging->send_new_message(0,$recipients, 'test Tmail','Testing','',9);
        if($msg){
            echo  1;
        }else{
            echo 0;
        }
    }
    
    
    function test_download()
    {
        
        downloadFile($filePath='media/DwVTSO0m/showcase/introductory/converted/',$fileName='p17uhpihv11u89k9tnqj7edm297.mp4',$dwnFileName='test.mp4');
    }
    
    /* Send Mail */
    function sendTmail($recipients,$subject,$body){
        
        //$type=$this->input->post("type");
        //$type=($type >0)?$type:1;
        //$msg = $this->tmail_messaging->send_new_message(0,$recipients, $subject,$body,'',9);
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }
    
    
    function serverinfo(){
        echo phpversion();
        
        echo '<br><pre>';
        print_r($_SERVER);
    }
    
    

    function auctionMail($html='')
    {
        //Get template body of report
        $where=array('purpose'=>'auctionwinmail','active'=>1);
        $reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
        if($_SERVER["SERVER_NAME"]=='localhost'){
            $site_base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev';
        }else{
            $site_base_url = site_url('');
        }
        $site_url = site_url('');
        
        /* while we don't remove restriction (username, password) in .htacess file  from live site*/
        $image_base_url = site_base_url().'images/email_images/';
        $crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
        /* Set Follow us link*/
        $facebook_url = $this->config->item('facebook_follow_url');
        $linkedin_url = $this->config->item('linkedin_follow_url');
        $twitter_url = $this->config->item('twitter_follow_url');
        $gPlus_url = $this->config->item('google_follow_url');
        $crave_url = $this->config->item('crave_us');
        
        $project_title = "My Test Product";
        $end_date = date("Y-m-d H:i:g");
        if($reportTemplateRes) {
            $reportTemplate=$reportTemplateRes[0]->templates;
            $searchArray = array("{project_title}","{end_date}","{invitation_accept_url}","{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
            $replaceArray = array($project_title,$end_date,$invitation_accept_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
            $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
            $forgotPasswordSubject=$reportTemplateRes[0]->subject;
        }
        else {
            $forgotPasswordTemplate='';
            $forgotPasswordSubject='';
        }
        if($html=='html'){
            echo $forgotPasswordTemplate;
        }else{
            if((!empty($forgotPasswordTemplate)) && (!empty($forgotPasswordSubject))){
                $this->send_email_template($forgotPasswordTemplate,$forgotPasswordSubject);	
            }
        }
    }
    
}

