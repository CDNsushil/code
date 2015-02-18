<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Todasquare frontend Controller Class
 *
 *  Manage Frontend Details (CMS)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */
class cms extends MY_Controller {
	private $data = array();
	
	function __construct() {
		
		parent::__construct();	
		//Load required Model, Library, language and Helper files	
		$this->load->model(array('model_cms','messagecenter/model_message_center','tmail/model_tmail'));
		$this->load->language('admin_template');
		$this->load->library(array('admin_template','language/lang_library','tmail/Tmail_messaging','messagecenter/lib_message_center','session'));//add advertising module if exists
		if(is_dir(APPPATH.'modules/advertising')){
			$this->load->model(array('advertising/model_advertising'));
		}				
	}
	
	public function index() 
	{
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		else{
		$this->cms_list();
		}	
	}
	
	
	/*
	 * Get content for Terms and Condition page 
	*/
	public function termsncondition($lang='english') 
	{	
		if($lang=='French' || $lang=='french'){
			$pageKey = 'termsnconditionfr';
		}
		elseif($lang=='German' || $lang=='german'){
			$pageKey = 'termsnconditiongr';
		}
		else{
			$pageKey = 'termsconditions';
		}
		$data = array();
        $data['pageKey'] = $pageKey;
		$cms_content = $this->model_common->get_cms_content($pageKey);
		if((!empty($cms_content[0]['title'])) && (!empty($cms_content[0]['description']))){
			$data['title'] = $cms_content[0]['title'];
			$data['description'] = $cms_content[0]['description'];
		} else {
			$data['title'] = '';
			$data['description'] = '';
		}
		$this->new_version->load('new_version','terms_condition',$data);			
	}
	
	/*
	 * Get content for Description of Services page 
	*/
	public function descofservices() 
	{	
		$pageKey = 'descriptionOfservices';
		$cms_content = $this->model_common->get_cms_content($pageKey);
		if((!empty($cms_content[0]['title'])) && (!empty($cms_content[0]['description']))){
			$data['title'] = $cms_content[0]['title'];
			$data['description'] = $cms_content[0]['description'];
		} else {
			$data['title'] = '';
			$data['description'] = '';
		}
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Get search section id
			$advertSectionId = $this->config->item('descriptionofServicesSectionId');
			//Get banner records based on section and advert type
			$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
			$data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType2'=>$bannerType2,'sectionId'=>$advertSectionId),true);
		}
		$this->new_version->load('new_version','description_of_services',$data);			
	}
	
	/*
	 * Get content for Apps page 
	*/
	public function apps() 
	{	
		$pageKey = 'apps';
		$cms_content = $this->model_common->get_cms_content($pageKey);
		if((!empty($cms_content[0]['title'])) && (!empty($cms_content[0]['description']))){
			$data['title'] = $cms_content[0]['title'];
			$data['description'] = $cms_content[0]['description'];
		} else {
			$data['title'] = '';
			$data['description'] = '';
		}
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Get search section id
			$advertSectionId = $this->config->item('workProfileAppSectionId');
			//Get banner records based on section and advert type
			$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
			$data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType2'=>$bannerType2,'sectionId'=>$advertSectionId),true);
		}
		$this->new_version->load('new_version','apps',$data);			
	}
	
	/*
	 * Download the Terms of Services in PDF
	*/
	public function downloadtandc() 
	{
		$this->template_front_end->load('template_front_end','download_tandc');
	}
	
	/*
	 *Manage cms listing at admin side
	*/
	function cms_list($id=FALSE) {
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
		
			if($id===FALSE)
			{
				$topDescription = $this->model_cms->get_top_cms();
				if(!empty($topDescription)){
					$data['topDescription'] = $topDescription;
				}else {
					$data['topDescription'] = '';
				}
				
				$cms_list = $this->model_cms->get_all_cms();
				if(!empty($cms_list)){
					$data['cms_list'] = $cms_list;
				}else {
					$data['cms_list'] = '';
				}
				$this->admin_template->load('admin/admin_template','cms/admin_cms_list',$data);
			}
			else
			{  
				//$data['cms_list'] = $this->model_cms->get_all_cms();
				$cms_list = $this->model_cms->get_all_cms();
				if(!empty($cms_list)){
					$data['cms_list'] = $cms_list;
				}else {
					$data['cms_list'] = '';
				}
				
				$description = $this->model_cms->get_description($id);
				if(!empty($description)){
					$data['description'] = $description;
				}else {
					$data['description'] = '';
				}
				$data['titleId'] = $id;
				$this->admin_template->load('admin/admin_template','cms/admin_cms_list',$data);
			}
		}
	}
	
	/**
	* Post all fields to create cms page.
	*/
	public function add_cms() {	
				
			/**
			* Build the form fields.
			**/	
			$title = array(			
				'name' 				=> 'title',
				'id' 				=> 'title',
				'type' 				=> 'text',
				'class' 			=> 'textbox width450px',
			);
			
			$pageKey = array(			
				'name' 				=> 'pageKey',
				'id' 				=> 'pageKey',
				'type' 				=> 'text',
				'class' 			=> 'textbox width450px',
			);				 								 		
	
			$description = array(			
				'name' 				=> 'description',			
				'id' 				=> 'description',	
				'size'				=> 30,
				'cols'				=> 70,
				'rows'				=> 20,
				'class'      		=> 'formTip textarea  frm_Bdr required'
			);
			
			$status = array(
				'name'        => 'status',
				'class'       => 'checkbox',
				'value'       => '1',
				'checked'     => FALSE,
			);	

			/**
			* Construct the data array for the page
			**/
			$data = array(				
				'Title' 				=> $title,
				'pageKey' 				=> $pageKey,				
				'Description' 			=> $description,	
				'Status' 				=> $status,	
				'errorMessageTitle' 	=> $this->errorTitle,
				'Error' 				=> $this->Error,
				'successMessageTitle' 	=> $this->messageTitle,
				'Message' 				=> $this->Message,		
                'navigation'            => $this->build_navigation(),
               
			);			

			/**
			* Send data to create Cms page
			**/
			$this->admin_template->load('admin/admin_template','cms/add_cms',$data);		
	}
	
	/**
	* Post all tip data to edit Cms page.
	*/
	public function edit_cms($cmsId)
    { 	 
        $cms = $this->model_cms->get_cms($cmsId);
        
        if(isset($cms) && !empty($cms))
        { 
			foreach($cms as $row)
			{   
				$pageKey = $row['pageKey'];
				$title = array(
					'name' 		=> 'title',
					'id' 		=> 'title',
					'type' 		=> 'text',
					'class' 	=> 'textbox width450px',
					'value' 	=> $row['title'],
					);
				
				$description = array(			
					'name' 		=> 'description',			
					'id' 		=> 'description',	
					'size'		=> 30,
					'cols'		=> 70,
					'rows'		=> 20,
					'class'     => 'formTip textarea  frm_Bdr required',
					'value' 	=> $row['description'],
				);		
					     
				$data = array(			
					'Title' 				=> $title,			
					'Description' 			=> $description,
					'PageKey' 				=> $pageKey,	
					'errorMessageTitle' 	=> $this->errorTitle,
					'Error' 				=> $this->Error,
					'successMessageTitle' 	=> $this->messageTitle,
					'Message' 				=> $this->Message,		
					'navigation'            => $this->build_navigation(),
					'cmsId'             	=> $cmsId,
				);
					
				$this->admin_template->load('admin/admin_template','cms/edit_cms',$data);
			} 
		}else {
			redirect("cms/cms_list");
		}     
    }
    
	/**
	* Cms insert to db.
	**/	
	function submit_cms()
	{
		if($this->input->post('title')!='' && $this->input->post('description')!='' && $this->input->post('pageKey')!='')
		{
			$this->model_cms->insert_cms();	
			$this->session->set_flashdata('msg',$this->lang->line('messageCmsAdd'));
			redirect("cms/cms_list");
		} else {
			$this->session->set_flashdata('error',$this->lang->line('cmsAddError'));
			redirect("cms/add_cms");
		}
		
	}
	
	/**
	* Update selected cms.
	*/
    public function update_cms($cmsId=FALSE)
    {
		
		$pageKey = $this->input->post('pageKey');
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		if((!empty($title)) && (!empty($description)) && (!empty($pageKey)))
		{
			$cms_data = array(
				'title' 		=> $title,
				'description'  	=> $description,
			);
			$this->db->where('id', $cmsId);
			$this->db->update('CMS', $cms_data);
			$this->session->set_flashdata('msg',$this->lang->line('messageCmsUpdated'));
			redirect('cms/cms_list/'.$cmsId);
		} else {
			$this->session->set_flashdata('error',$this->lang->line('cmsAddError'));
			redirect('cms/edit_cms/'.$cmsId);
		}
	}
	
	/**
	* Remove selected cms.
	*/
	public function delete_cms($titleId)
    {
		if($this->model_cms->remove_cms($titleId))
		{
			$this->session->set_flashdata('msg',$this->lang->line('messageCmsDelete'));
			redirect('cms/cms_list');
		}
		else{
			$this->session->set_flashdata('msg',$this->lang->line('messageCmsNotDelete'));
			redirect('cms/cms_list');
		}
	}
	
	/* Send Mail */
	function sendEmail($from,$to,$subject,$body){
		$this->email->from($from, 'toadsquare');
		$this->email->to($to);
		$this->email->subject(sprintf($subject));
		$this->email->message($body);
		$flag = $this->email->send();
	}
	
	/* Send Mail */
	function sendTmail($recipients,$subject,$body){
		//$type=$this->input->post("type");
		//$type=($type >0)?$type:1;
		$msg = $this->tmail_messaging->send_new_message(0,$recipients, $subject,$body,'',10);
		if($msg){
			return 1;
		}else{
			return 0;
		}
	}
	
	/*Function to send Email & Tmail to Users */
	function broadcast_mails($cmsId=''){
		
		if(isset($cmsId) && !empty($cmsId)){
			$description = $this->model_cms->get_description($cmsId);
			
			if(isset($description[0]['description']) && !empty($description[0]['description'])){
				$termsDescription = $description[0]['description'];
			}else {
				$termsDescription = '';
			}
			
			//Send mail to users
			$from = $this->config->item('webmaster_email', '');
			/* while we don't remove restriction (username, password) in .htacess file  from live site*/
			$image_base_url = site_base_url().'images/email_images/';
			$site_base_url = site_url('');
			/* Set Terms & Condition url */
			$terms_url = site_url(lang()).'/cms/downloadtandc';
			/* Set Crave url */
			$crave_url = $this->config->item('crave_us');
			/* Set Follow us link*/
			$facebook_url = $this->config->item('facebook_follow_url');
			$linkedin_url = $this->config->item('linkedin_follow_url');
			//Get all Users email and id list
			$user_email_list = $this->model_cms->get_all_useremail();
			if((isset($user_email_list)) && (!empty($user_email_list)) && (!empty($termsDescription))){
				//Email section
				$where=array('purpose'=>'termsandcondition','active'=>1);
				$cmsTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
				if($cmsTemplateRes) {
					/*remove BR from terms description*/
					$termNCondition = str_replace("<br>", "", $termsDescription);
					/*Set email body and subject*/
					$cmsTemplate=$cmsTemplateRes[0]->templates;
					$searchArray = array("{image_base_url}","{site_base_url}","{terms_url}","{crave_us}","{terms_description}","{facebook_url}","{linkedin_url}");
					$replaceArray = array($image_base_url,$site_base_url,$terms_url,$crave_url,$termNCondition,$facebook_url,$linkedin_url);
					$cmsTemplateBody = str_replace($searchArray, $replaceArray, $cmsTemplate);
					$cmsTemplateSubject = $cmsTemplateRes[0]->subject;
					echo $cmsTemplateBody;die;
					/*for($i=0;$i<count($user_email_list);$i++)
					{	
						//Send Email to users
						if(isset($user_email_list[$i]['email']) && !empty($user_email_list[$i]['email'])){
							$this->email->from($from, $this->config->item('website_name', ''));
							$this->email->to($user_email_list[$i]['email']);
							$this->email->subject(sprintf($cmsTemplateSubject));
							$this->email->message($cmsTemplateBody);
							$this->email->send();
						}	
					}*/	
				}
				
				//Tmail section
				$wheretmail = array('purpose'=>'tmailtermsandcondition','active'=>1);
				$tmailcmsTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $wheretmail, '','', '', 1 );
				if($tmailcmsTemplateRes) {
					$tmailcmsTemplate= $tmailcmsTemplateRes[0]->templates;
					$tmailsearchArray = array("{terms_url}");
					$tmailreplaceArray = array($terms_url);
					$tmailcmsTemplateBody = str_replace($tmailsearchArray, $tmailreplaceArray, $tmailcmsTemplate);
					$tmailcmsTemplateSubject = $tmailcmsTemplateRes[0]->subject;
					
					/*for($i=0;$i<count($user_email_list);$i++)
					{	
						//Send Tmail to users
						if(isset($user_email_list[$i]['tdsUid']) && !empty($user_email_list[$i]['tdsUid'])){
							//$this->sendTmail($user_email_list[$i]['tdsUid'],$tmailcmsTemplateSubject,$tmailcmsTemplateBody);
						}		
					}*/
				}
				$this->session->set_flashdata('msg',$this->lang->line('broadcasrmessagesuccess'));
				redirect('cms/cms_list');
			}else{
				$this->session->set_flashdata('msg',$this->lang->line('broadcasrmessageerror'));
				redirect('cms/cms_list');
			}
		}else{
			$this->session->set_flashdata('msg',$this->lang->line('broadcasrmessageerror'));
			redirect('cms/cms_list');
		}
	}
	

	
}
