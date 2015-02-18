<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller for CodeIgniter messages files editor.
 *
 * Idea:
 * Keys stored in database only as an information and simple way to communicate between files.
 * Edit translation for existing keys, Add new keys, Same keys for every tip.
 * @version		2.1
 */

class Settings extends MY_Controller{
	function __construct(){
		parent::__construct();
			
		$this->load->helper(array('url','file','language','form')); //load this helpers if youre not doing it in autoload
		$this->load->model(array('model_messaging','admin_model','messagecenter/model_message_center','tmail/model_tmail'));
		$this->load->library(array('session','language/lang_library','messagecenter/lib_message_center','tmail/Tmail_messaging')); //load libraries if youre not doing it in autoload
		$this->load->language(array('admin_template')); //you can delete it if you have translation for you language
		$this->load->library('admin_template');
		$this->config->load('language_editor');
		$this->head->add_css($this->config->item('editable_plugins').'demo_page.css');
		$this->head->add_css($this->config->item('editable_plugins').'demo_table.css');
		$this->head->add_js($this->config->item('editable_plugins').'jquery.dataTables.js');
	}
	
	function index(){
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			$this->manage_msg_grid();
		}
	}
	
	/*
	 * Function to admins message logs
	 */
	function get_message_log($limit='',$perPage=''){
			if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit :  $this->config->item('limitPageRecordAdminUser');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdminUser');
		$userData = $this->model_messaging->get_message_log();
		$countTotal = count($userData);
		
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		$data['messageLog'] = $this->model_messaging->get_message_log($pages->limit,$pages->offst);
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_messaging/message_listing', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_messaging/message_listing_view', $data);
		}
	}
	
	/*
	 * Function to load compose mail view 
	 **/
	function compose_mail($msgId=0){
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		/*get message details*/
		if(isset($msgId) && !empty($msgId)){
			$data['messageDetails'] = $this->model_messaging->get_msg_details($msgId);
			$data['participantsId'] = substr($data['messageDetails']->participantsId, 1, -1);
		}
		/* Get all users listing*/
		$data['users'] = $this->model_messaging->get_users();
		$this->toad_admin_template->load('toad_admin_template','manage_messaging/compose_mail', $data);
	}
	
	/*
	 * Function to load user listing view 
	 **/
	function add_user($limit='',$perPage=''){
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit :  $this->config->item('limitPageRecordAdminUser');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdminUser');
		$userData = $this->model_messaging->get_users();
		$countTotal = count($userData);
		
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		$data['users'] = $this->model_messaging->get_users($pages->limit,$pages->offst);
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('add_user_view', $data);
			
		}else{
			$this->load->view('add_user', $data);
		}
	}
	
	/*
	 * Function to send mail 
	 **/
	function send_mail(){
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$user_array = $this->session->userdata('session_data');
		$data['senderId']   = $user_array['user_id'];
		$data['subject'] 	= $this->input->post('mailSubject');
		$data['message']    = $this->input->post('mBody');
		$data['type'] 		= 0;
		$userIds = $this->input->post('userIds');
		$userAry = explode(',',$userIds);
		$data['participantsId']  = '{'.$userIds.'}';

		$from_email = $this->config->item('webmaster_email', '');
		/* while we don't remove restriction (username, password) in .htacess file  from live site*/
		$image_base_url = site_base_url().'images/email_images/';
		$crave_url = $this->config->item('crave_us');
		/* Set Follow us link*/
		$facebook_url = $this->config->item('facebook_follow_url');
		$linkedin_url = $this->config->item('linkedin_follow_url');
		$twitter_url = $this->config->item('twitter_follow_url');
		$gPlus_url = $this->config->item('google_follow_url');
		$site_email = 'info@toadsquare.com';
		$site_link = 'www.toadsquare.com';
		$where=array('purpose'=>'adminmailing','active'=>1);
		$adminTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
		if($adminTemplateRes) {
			$adminTemplate = $adminTemplateRes[0]->templates;
			$searchArray = array("{mailBody}","{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{site_email}","{site_link}","{twitter_url}","{gPlus_url}");
			$replaceArray = array($data['message'],$image_base_url,$crave_url,$facebook_url,$linkedin_url,$site_email,$site_link,$twitter_url,$gPlus_url);
			$adminMailTemplate = str_replace($searchArray, $replaceArray, $adminTemplate);
			for($i=0;$i<count($userAry);$i++){
				if(isset($userAry[$i]) && !empty($userAry[$i])){
					/* Send Email to users */
					$userEmail =  $this->model_messaging->get_user_email($userAry[$i]);
					if(!empty($userEmail)){
						$this->email->from($from_email, $this->config->item('website_name', ''));
						$this->email->to($userEmail);
						$this->email->subject(sprintf($data['subject']));
						$this->email->message($adminMailTemplate);
						$flag = $this->email->send();
					}
				}
			}
		}
		
		/* Insert messaging log */
		$addMsgLog = $this->model_messaging->insert_email_log($data);
		if(isset($addMsgLog)){
			echo $addMsgLog;
		}else{
			echo 0;
		}
	}
	
	/*
	 * Function to set email in user field
	 */
	function setEmails(){
		$userIds = $this->input->post('userIds');
		for($i=0;$i<count($userIds);$i++){
			$res =  $this->model_messaging->get_user_email($userIds[$i]);
			if($i==0){
				echo '<'.$res.'>';
			}else{
				echo ',<'.$res.'>';
			}
		}
		die;
	}
	
	/*
	 * Function to view admin message
	 */
	function view_message($messageId=0){
		
		/*get message details*/
		if(isset($messageId) && !empty($messageId)){
			$messageDetails = $this->model_messaging->get_msg_details($messageId);
			if(!empty($messageDetails) && isset($messageDetails)){
				$data['messageId'] = $messageDetails->id;
			 	$data['subject'] = $messageDetails->subject;
				$data['msgBody'] = $messageDetails->message;
				$data['sentDate'] = $messageDetails->sentDate;
				$participantsId = substr($messageDetails->participantsId, 1, -1);
				$data['participantsId'] = explode(',',$participantsId);
			}else{
				$data[] = '';
			}
			$this->toad_admin_template->load('toad_admin_template','manage_messaging/view_message', $data);
		}else
		{
			redirectToNorecord404();
		}
	}
	
	/*
	 * Function to delete message
	 */
	function delete_msg($msgId){
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		//get message id from post val
		$msgId = $this->input->post('msgId');
		if(isset($msgId) && !empty($msgId)){
			$this->model_messaging->remove_message($msgId);
		}
	}
	
	/*
	 * Function to load user listing for js grid
	 */
	public function manage_users_grid($messageId=0) {
		/*get message details*/
		if(isset($messageId) && !empty($messageId)){
			$messageDetails = $this->model_messaging->get_msg_details($messageId);
			$data['participantsId'] = substr($messageDetails->participantsId, 1, -1);
		}		
		$data['users'] = $this->model_messaging->get_users_listing(2);
		$data['getUserType'] = 'allUser';
		$this->load->view('manage_messaging/user_grid_listing', $data);
	}
	
	/*
	 * Function to load messages listing for js grid
	 */
	public function manage_msg_grid() {		
		$data['messageLog'] = $this->model_messaging->get_message_log();
		$this->toad_admin_template->load('toad_admin_template','manage_messaging/message_grid_listing', $data);
		
	}
}
