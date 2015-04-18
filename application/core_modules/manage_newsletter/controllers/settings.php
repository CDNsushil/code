<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /*
    * @Description: This module is manage for news latter listing, compose email,
    * user listing
    * @auther: lokendra
    * @section: toadsquare admin
    * @date: 8-jan-2014
    */ 

class Settings extends MY_Controller{
    function __construct(){
        parent::__construct();
        
        $this->load->helper(array('url','file','language','form')); //load this helpers if youre not doing it in autoload
        $this->load->model(array('model_newsletter','admin_model','messagecenter/model_message_center','tmail/model_tmail'));
        $this->load->library(array('session','language/lang_library','messagecenter/lib_message_center','tmail/Tmail_messaging')); //load libraries if youre not doing it in autoload
        $this->load->language(array('admin_template')); //you can delete it if you have translation for you language
        $this->load->library('admin_template');
        $this->config->load('language_editor');
        $this->head->add_css($this->config->item('editable_plugins').'demo_page.css');
        $this->head->add_css($this->config->item('editable_plugins').'demo_table.css');
        $this->head->add_js($this->config->item('editable_plugins').'jquery.dataTables.js');
        
        //if user not admin then redirect to login page    
        if(!$this->lang_library->login_check()){
            redirect('toad_admin/toad_admin');
        }
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to show news latter listing
    * @auther: lokendra meena
    * @return: void
    */ 
    
    function index(){
        //call on news latter listing grid
        //$this->newslatter_msg_grid();
        // get newsletter listing
        $this->get_newsletters();
        // unset newsletter id in session
		$this->session->unset_userdata('newsletterId');
    }
    
    /*
     * Function to admins message logs
     */
    function get_message_log($limit='',$perPage=''){
        $limit= (!empty($limit))? $limit :  $this->config->item('limitPageRecordAdminUser');
        $perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdminUser');
        $userData = $this->model_newsletter->get_message_log();
        $countTotal = count($userData);
        
        $pages = new Pagination_ajax;
        $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
        $pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
        $pages->paginate();
        $data['items_total'] = $pages->items_total;
        $data['items_per_page'] = $pages->items_per_page;
        $data['pagination_links'] = $pages->display_pages();	
        $data['countTotal'] = $countTotal;
        $data['messageLog'] = $this->model_newsletter->get_message_log($pages->limit,$pages->offst);
        if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
            $this->load->view('manage_newsletter/message_listing', $data);
        }else{
            $this->toad_admin_template->load('toad_admin_template','manage_newsletter/message_listing_view', $data);
        }
    }
    
    
    //---------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to show add/edit message
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    function compose_mail($msgId=0){
		//unset newsletter id
		$this->session->unset_userdata('newsletterId');
        /*get message details*/
        if(isset($msgId) && !empty($msgId)){
            $data['messageDetails'] = $this->model_newsletter->get_msg_details($msgId);
            $data['participantsId'] = substr($data['messageDetails']->participantsId, 1, -1);
        }
        /* Get all users listing*/
        $data['users'] = $this->model_newsletter->get_users();
        // get newsletter data
        $data['newsletters'] = $this->model_newsletter->get_newsletter_list(); 
        $this->toad_admin_template->load('toad_admin_template','manage_newsletter/compose_mail', $data);
    }
    
    //----------------------------------------------------------------------
    
    /*
     * Function to load user listing view 
     **/
    function add_user($limit='',$perPage=''){
       
        $limit= (!empty($limit))? $limit :  $this->config->item('limitPageRecordAdminUser');
        $perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdminUser');
        $userData = $this->model_newsletter->get_users();
        $countTotal = count($userData);
        
        $pages = new Pagination_ajax;
        $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
        $pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
        $pages->paginate();
        $data['items_total'] = $pages->items_total;
        $data['items_per_page'] = $pages->items_per_page;
        $data['pagination_links'] = $pages->display_pages();	
        $data['countTotal'] = $countTotal;
        $data['users'] = $this->model_newsletter->get_users($pages->limit,$pages->offst);
        if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
            $this->load->view('add_user_view', $data);
            
        }else{
            $this->load->view('add_user', $data);
        }
    }
    
    //---------------------------------------------------------------------
    
    /*
     * Function to send mail 
     **/
    function send_mail() {
		
		// get post data
		$postData = $this->input->post();
		if(!empty($postData['newsletter'])) {
			$user_array = $this->session->userdata('session_data');
			$data['senderId']   = $user_array['user_id'];
			$data['subject'] 	= ''; 
			$data['newsletterId'] 	= $postData['newsletter'];
			$data['participantsType'] = '0';
			$userIds = $postData['userIds'][0];
			$userAry = explode(',',$userIds);
			//$userIds = implode(',',$userAry);
			$data['participantIds']  = '{'.$userIds.'}';
			/* Get newsletter content from id */
			$whereNewsletter = array('id'=>$postData['newsletter']);
			$newsletterRes = getDataFromTabel('EmailNewsletter','title,content',  $whereNewsletter, '','', '', 1 );
			$data['message'] = '';
		   
			if(!empty($newsletterRes)) {
				// get template content
				$content = $newsletterRes[0]->content;
				// get template title
				$title = $newsletterRes[0]->title;
				
				/* Insert messaging log */
				$getMessageId = $this->model_newsletter->insert_email_log($data);
				
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
				$message_date   =   date('F Y');
				$view_online    =   base_url('en/home/viewonline/'.base64_encode($data['newsletterId']));
				$where=array('purpose'=>'newslettertemplate','active'=>1);
				$adminTemplateRes = getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
				if($adminTemplateRes) {
					$adminTemplate = $adminTemplateRes[0]->templates;
					$searchArray = array("{view_online}","{message_date}","{mailBody}","{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{site_email}","{site_link}","{twitter_url}","{gPlus_url}");
					$replaceArray = array($view_online,$message_date,$content,$image_base_url,$crave_url,$facebook_url,$linkedin_url,$site_email,$site_link,$twitter_url,$gPlus_url);
					$adminMailTemplate = str_replace($searchArray, $replaceArray, $adminTemplate);
					
					for($i=0;$i<count($userAry);$i++) {
						if(isset($userAry[$i]) && !empty($userAry[$i])) {
							/* Send Email to users */
							$userEmail =  $this->model_newsletter->get_user_email($userAry[$i]);
							if(!empty($userEmail)) {
								$this->email->from($from_email, $this->config->item('website_name', ''));
								$this->email->to($userEmail);
								$this->email->subject(sprintf($title));
								$this->email->message($adminMailTemplate);
								$flag = $this->email->send();
							}
						}
					}
				}
			}
			// set global msg
			$msg = $this->lang->line('send_newsletter_success');
			$type='success';
		} else {
			// set global msg
			$msg = $this->lang->line('no_exist_newsletter');
			$type = 'error';
		}
		set_global_messages($msg, $type, $is_multiple=true);
		if(!isset($postData['newsletterAjax'])) {
			redirect(base_url_lang('settings/manage_newsletter'));
		}
        
        /*
        if(isset($getMessageId)){
            echo '1';
        }else{
            echo '0';
        }*/
    }
    
    //---------------------------------------------------------------------
    
    /*
     * Function to set email in user field
     */
    function setEmails(){
        $userIds = $this->input->post('userIds');
        for($i=0;$i<count($userIds);$i++){
            $res =  $this->model_newsletter->get_user_email($userIds[$i]);
            if($i==0){
                echo '<'.$res.'>';
            }else{
                echo ',<'.$res.'>';
            }
        }
        die;
    }
    
    //---------------------------------------------------------------------
    
    /*
     * Function to view admin message
     */
    function view_message($messageId=0){
        
        /*get message details*/
        if(isset($messageId) && !empty($messageId)){
            $messageDetails = $this->model_newsletter->get_msg_details($messageId);
            if(!empty($messageDetails) && isset($messageDetails)){
                $data['messageId'] = $messageDetails->id;
                $data['subject'] = $messageDetails->subject;
                $data['msgBody'] = $messageDetails->message;
                $data['sentDate'] = $messageDetails->sentDate;
                $participantsId = substr($messageDetails->participantIds, 1, -1);
                $data['participantsId'] = explode(',',$participantsId);
             
            }else{
                $data[] = '';
            }
            $this->toad_admin_template->load('toad_admin_template','manage_newsletter/view_message', $data);
        }else
        {
            redirectToNorecord404();
        }
    }
    
     //---------------------------------------------------------------------
    
    /*
     * Function to view admin newsletter
     */
    function view_newsletter($newsletterId=0){
        
        /*get message details*/
        if(isset($newsletterId) && !empty($newsletterId)){
			// set newsletter id in session
			$this->session->set_userdata('newsletterId',$newsletterId);
			// set  participant array 
			$participantsIds = array();
			// get sent newsletter log 
            $sentNewletterLog = $this->model_newsletter->get_sent_newletter_log($newsletterId);
            if(!empty($sentNewletterLog) && count($sentNewletterLog) > 0) {
				$participantsId = '';
				foreach ($sentNewletterLog as $sentNewletterLog) {
					// remove extra characters from ids
					$participantsId .= substr($sentNewletterLog['participantIds'], 1, -1);
					$participantsId .= ',';
				}
				// set unique values Id array
				$participantsIds = array_filter(array_unique(explode(',',$participantsId)));
			}
			
            // get newsletter details
			$newsletter = $this->model_newsletter->get_newsletter_detail($newsletterId);
            if(!empty($newsletter) && isset($newsletter)){
				$newsletterContent = '';
				// get core template content
				$where = array('purpose'=>'newslettertemplate','active'=>1);
				$adminTemplateRes = getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
				
				// set data values
                $data['newsletterId']   = $newsletter->id;
                $data['title']          = $newsletter->title;
                $data['content']        = $newsletter->content;
                $data['createdAt']      = $newsletter->createdAt;
                $data['newsletterDate'] = (!empty($newsletter->newsletterDate)) ? date('F Y',strtotime($newsletter->newsletterDate)) : date('F Y');
                $data['participantsId'] = $participantsIds;
                if($adminTemplateRes) {
					
					$data['adminTemplateRes'] = $adminTemplateRes[0];
					// get newsletter view content
					$newsletterContent = $this->load->view('manage_newsletter/preview_newsletter',$data,true);
				}
				$data['newsletterContent'] = $newsletterContent;
				
            }else{
                $data[] = '';
            }
            $this->toad_admin_template->load('toad_admin_template','manage_newsletter/view_message', $data);
        }else
        {
            redirectToNorecord404();
        }
    }
    
    //---------------------------------------------------------------------
    
    /*
     * Function to delete message
     */
    function delete_msg($msgId){
      
        //get message id from post val
        $msgId = $this->input->post('msgId');
        if(isset($msgId) && !empty($msgId)){
            $this->model_newsletter->remove_message($msgId);
        }
    }
    
	//---------------------------------------------------------------------
    
    /*
     * Function to delete newsletter
     */
    function delete_newsletter($newsletterId){
      
        //get newsletter id from post val
        $newsletterId = $this->input->post('newsletterId');
        if(isset($newsletterId) && !empty($newsletterId)){
            $this->model_newsletter->remove_newsletter($newsletterId);
        }
    }
    
    //---------------------------------------------------------------------
    
    /*
     * Function to load user listing for js grid
     */
    public function manage_users_grid($messageId=0) {
        /*get message details*/
        if(isset($messageId) && !empty($messageId)){
            $messageDetails = $this->model_newsletter->get_msg_details($messageId);
            $data['participantsId'] = substr($messageDetails->participantsId, 1, -1);
        }		
        $data['users'] = $this->model_newsletter->get_users_listing(2);
        $data['getUserType'] = 'allUser';
        $this->load->view('manage_newsletter/user_grid_listing', $data);
    }
    
    //---------------------------------------------------------------------
    
    /*
     * Function to load user listing for js grid
     */
    public function manage_newsletter_users_grid($newsletterId=0) {
		 $newsletterId = $this->session->userdata('newsletterId');
        /*get message details*/
        if(isset($newsletterId) && !empty($newsletterId)){
            $messageDetails = $this->model_newsletter->get_msg_details($newsletterId);
            $data['participantsId'] = substr($messageDetails->participantsId, 1, -1);
        }		
        $data['users'] = $this->model_newsletter->get_users_listing(2);
        $data['newsletterId'] = $newsletterId;
        $data['getUserType'] = 'allUser';
		$data['isComposeSection']   =  1;
        $this->load->view('manage_newsletter/user_grid_listing', $data);
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to show news latter listing 
    * @auther: lokendra meena
    * @return: void
    */ 
    
    public function newslatter_msg_grid(){
        $data['messageLog'] = $this->model_newsletter->get_message_log();
        $this->toad_admin_template->load('toad_admin_template','manage_newsletter/message_grid_listing', $data);
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to get all newsletters
    * @auther: tosif qureshi
    * @return: void
    */ 
    
    public function get_newsletters() {
		// get newsletter listing
        $data['newsletterList'] = $this->model_newsletter->get_newsletter_list();
        $this->toad_admin_template->load('toad_admin_template','manage_newsletter/newsletter_grid_listing', $data);
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to add newsletter template
    * @auther: tosif qureshi
    * @return: void
    */ 
    
    public function set_newsletter($newsletterId=0) {
		// set page heading as add form
		$form_heading = $this->lang->line('add_newsletter');
		// get newsletter listing
		if(!empty($newsletterId) && $newsletterId > 0) {
			$data['newsletter'] = $this->model_newsletter->get_newsletter_detail($newsletterId);
			// set page heading as add form
			$form_heading = $this->lang->line('update_newsletter');
			if(empty($data['newsletter'])) {
				// set global msg
				$msg = $this->lang->line('no_exist_newsletter');
				set_global_messages($msg, $type='error', $is_multiple=true);
				// set redirect url
				redirect(base_url_lang('settings/manage_newsletter'));
			}
		}
		$data['form_heading'] = $form_heading;
        $this->toad_admin_template->load('toad_admin_template','manage_newsletter/set_newsletter', $data);
    }
    
	//---------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to add/edit newsletter 
    *  @auther: Tosif Qureshi
    *  @return: void
    */ 
    
    function save_newsletter(){
		// get newsletter post data
		$postData = $this->input->post();
		
        $data['title']   = $postData['title'];
        $data['content'] = $postData['mBody'];
        $data['modifiedAt'] = date('Y-m-d h:i:g');
        $newsletterDate =$postData['newsletterDate']==''?currntDateTime('Y-m-d'):$postData['newsletterDate'];
		$newsletterDate = date('Y-m-d',strtotime($newsletterDate));
		$data['newsletterDate'] = $newsletterDate;
		if(!empty($postData['newsletterId']) && $postData['newsletterId'] > 0) {
			/* Update newsletter log */
			$this->model_newsletter->update_newsletter($data,$postData['newsletterId']);
			$msg = $this->lang->line('update_newsletter_success');
			
		} else {
			/* Insert newsletter log */
			$getMessageId = $this->model_newsletter->insert_newsletter($data);
			$msg = $this->lang->line('add_newsletter_success');
		}
		set_global_messages($msg, $type='success', $is_multiple=true);
		redirect(base_url_lang('settings/manage_newsletter'));
    }
    
     
	//---------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to display preview of newsletter 
    *  @auther: Tosif Qureshi
    *  @return: void
    */ 
    
    function preview_newsletter($newsletterId=0){
		
		$status = false;
		// get newsletter listing
		if(!empty($newsletterId) && $newsletterId > 0) {
			// get newsletter details
			$newsletter = $this->model_newsletter->get_newsletter_detail($newsletterId);
			
			if(!empty($newsletter)) {
				// get core template content
				$where = array('purpose'=>'newslettertemplate','active'=>1);
				$adminTemplateRes = getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
				if($adminTemplateRes) {
					// set data values
					$data['newsletterId'] = $newsletterId;
					$data['content'] = $newsletter->content;
					$data['adminTemplateRes'] = $adminTemplateRes[0];
					$data['newsletterDate'] = (!empty($newsletter->newsletterDate)) ? date('F Y',strtotime($newsletter->newsletterDate)) : date('F Y');
					$this->load->view('manage_newsletter/preview_newsletter',$data);
					$status = true;
				}
			}
		} 
		// redirect when status false
		if($status == false) {
			// set global msg
			$msg = $this->lang->line('no_exist_newsletter');
			set_global_messages($msg, $type='error', $is_multiple=true);
			// set redirect url
			redirect(base_url_lang('settings/manage_newsletter'));
		}
	}
    
   
}
