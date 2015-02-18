<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller for CodeIgniter report files editor.
 *
 * Idea:
 * Keys stored in database only as an information and simple way to communicate between files.
 * Edit translation for existing keys, Add new keys, Same keys for every tip.
 * @version		2.1
 */

class Report_a_problem extends MX_Controller{
	private $data = array();
	private $userId = null;
	/**
	 * Constructor
	 */
	function __construct(){
		
			
		//Load required Model, Library, language and Helper files
		$load = array(
			'model'		=> 'report_a_problem/model_reportproblem + tmail/model_tmail + messagecenter/model_message_center',  
			'library' 	=> 'tmail/Tmail_messaging + form_validation + upload + messagecenter/lib_message_center'										
		);
		parent::__construct($load);	
		$this->userId= $this->isLoginUser();	
		//$this->userId= isLoginUser()?isLoginUser():0;
		// Load  path of css and js file path
		$this->head->add_css($this->config->item('frontend_css').'anythingslider.css');		
		$this->head->add_js($this->config->item('frontend_js').'jquery-gallery-cdn.js');
		$this->load->library('template_front_end');
		//add advertising module if exists
		if(is_dir(APPPATH.'modules/advertising')){
			$this->load->model(array('advertising/model_advertising'));
		}
	}

	function index(){
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Get search section id
			$advertSectionId = $this->config->item('reportProblemSectionId');
			//Get banner records based on section and advert type
			$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
			$this->data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType2'=>$bannerType2,'sectionId'=>$advertSectionId),true);
		} 
		$this->template_front_end->load('template_front_end','report_a_problem/reportproblem_step1',$this->data);
	}
	/**
	 * Function to get report layouts depend on reason type
	 */
	function report_step2()
	{
		$data['reasonTypeId'] = $this->input->post('abusiveComplain');
		if($data['reasonTypeId']==6) {
			$this->load->view('report_a_problem/reportproblem_step2',$data);
		}
		else {
			 $this->load->view('report_a_problem/reportproblem_step3',$data);
		}
	}
	
	/**
	 * Function to insert report in db
	 */
	function save_abuse_report()
	{  
		$SupportingProjectName = $this->input->post('SupportingProjectName');
		$data['description'] = $this->input->post('reason_description');
		$data['abusiveType'] = $this->input->post('abuse_type');
		$data['entityId'] = $this->input->post('entityId');
		$data['elementId'] = $this->input->post('elementId');
		$data['projectId'] = $this->input->post('projectId');
		$data['ownerId'] = $this->input->post('ownerId');
		$data['abusiveByUserId'] = $this->userId;
		
		//get entity table name 
		$entity_tableName = getMasterTableName($data['entityId']);
		$tableName= $entity_tableName[0];
		$archived_field_name = '';
		$isTable = true;
		switch ($tableName)
		{
			case 'TDS_Blogs':
				$primary_field_name = 'blogId';
				$publish_field_name = 'isPublished';
			break;
			case 'TDS_Posts':
				$primary_field_name = 'postId';
				$publish_field_name = 'isPublished';
				$archived_field_name = 'postArchived';
			break;
			case 'TDS_UserShowcase':
				$primary_field_name = 'showcaseId';
				$publish_field_name = 'isPublished';
			break;
			case 'TDS_EmElement':
				$primary_field_name = 'elementId';
				$publish_field_name = 'isPublished';
			break;
			case 'TDS_FvElement':
				$primary_field_name = 'elementId';
				$publish_field_name = 'isPublished';
			break;
			case 'TDS_MaElement':
				$primary_field_name = 'elementId';
				$publish_field_name = 'isPublished';
			break;
			case 'TDS_Events':
				$primary_field_name = 'EventId';
				$publish_field_name = 'isPublished';
				$archived_field_name = 'EventArchive';
			break;
			case 'TDS_PaElement':
				$primary_field_name = 'elementId';
				$publish_field_name = 'isPublished';
			break;
			case 'TDS_Product':
				$primary_field_name = 'productId';
				$publish_field_name = 'isPublished';
				$archived_field_name = 'productArchived';
			break;
			case 'TDS_Work':
				$primary_field_name = 'workId';
				$publish_field_name = 'isPublished';
				$archived_field_name = 'workArchived';
			break;
			case 'TDS_WpElement':
				$primary_field_name = 'elementId';
				$publish_field_name = 'isPublished';
			break;
			case 'TDS_WorkProfile':
				$primary_field_name = 'workProfileId';
				$publish_field_name = 'isPublished';
				$archived_field_name = 'isArchive';
			case 'TDS_UpcomingProject':
				$primary_field_name = 'projId';
				$publish_field_name = 'isPublished';
				$archived_field_name = 'projArchived';	
			break;
			case 'TDS_LaunchEvent':
				$primary_field_name = 'LaunchEventId';
				$publish_field_name = 'isPublished';
				$archived_field_name = 'isArchive';	
			break;
			case 'TDS_NewsElement':
				$primary_field_name = 'elementId';
				$publish_field_name = 'isPublished';
			break;
			case 'TDS_ReviewsElement':
				$primary_field_name = 'elementId';
				$publish_field_name = 'isPublished';
			break;
			case 'TDS_Project':
				$primary_field_name = 'projId';
				$publish_field_name = 'isPublished';
				$archived_field_name = 'isArchive';
			break;
			default:
			$isTable = false;
		}
		
		$owner_details = $this->model_reportproblem->recipients_email($data['ownerId']);
		$abusiveByUser_details = $this->model_reportproblem->recipients_email($data['abusiveByUserId']);
		
		$recipients_email = array($data['ownerId'], $this->userId);
		/* Check user not deleted or banned */
		if($owner_details->active!=2 && $owner_details->banned!=1){
			$user_emails[] = $owner_details->email;
		}
		if($abusiveByUser_details->active!=2 && $abusiveByUser_details->banned!=1){
			$user_emails[] = $abusiveByUser_details->email;
		}
		$user_emails[] = $this->config->item('superadmin_email', '');
		//$user_emails = array($owner_details->email, $abusiveByUser_details->email, $this->config->item('superadmin_email', ''));
		
		$from_email = $this->config->item('webmaster_email', '');
		/* while we don't remove restriction (username, password) in .htacess file  from live site*/
		$image_base_url = site_base_url().'images/email_images/';
		$site_base_url = site_url('');
		$crave_url = $this->config->item('crave_us');
		/* Abusive users showcase link*/
		$user_showcase_url = site_url(lang()).'/showcase/aboutme/'.$data['abusiveByUserId'];
		/* Set Follow us link*/
		$facebook_url = $this->config->item('facebook_follow_url');
		$linkedin_url = $this->config->item('linkedin_follow_url');
		$twitter_url = $this->config->item('twitter_follow_url');
		$gPlus_url = $this->config->item('google_follow_url');
		
		/* Set showcase link of project*/
		$project_name = $this->model_reportproblem->get_search_project('section',$data['projectId'],$data['entityId'],$data['elementId']);
		switch ($project_name)
		{
			case 'filmNvideo':
				$project_showcase_url = site_url(lang()).'/mediafrontend/filmvideo/'.$data['ownerId'].'/'.$data['projectId'].'/'.$data['elementId'].'/filmvideo';
			break;
			case 'musicNaudio':
				$project_showcase_url = site_url(lang()).'/mediafrontend/musicaudio/'.$data['ownerId'].'/'.$data['projectId'].'/'.$data['elementId'].'/musicaudio';
			break;
			case 'photographyNart':
				$project_showcase_url = site_url(lang()).'/mediafrontend/photographyart/'.$data['ownerId'].'/'.$data['projectId'].'/'.$data['elementId'].'/photographyart';
			break;
			case 'writingNpublishing':
				$project_showcase_url = site_url(lang()).'/mediafrontend/writingpublishing/'.$data['ownerId'].'/'.$data['projectId'].'/'.$data['elementId'].'/writingpublishing';
			break;
			case 'notification':
				$project_showcase_url = site_url(lang()).'/eventfrontend/eventnotification/'.$data['ownerId'].'/'.$data['projectId'].'/'.$data['elementId'];
			break;
			case 'launch':
				$project_showcase_url = site_url(lang()).'/eventfrontend/eventlaunch/'.$data['ownerId'].'/'.$data['projectId'].'/'.$data['elementId'];
			break;
			case 'product':
				$project_showcase_url = site_url(lang()).'/productshowcase/products/'.$data['ownerId'].'/'.$data['projectId'].'/'.$data['elementId'];
			break;
			case 'work':
				$project_showcase_url = site_url(lang()).'/workshowcase/works/'.$data['ownerId'].'/'.$data['projectId'].'/'.$data['elementId'];
			break;
			case 'blog':
				$project_showcase_url = site_url(lang()).'/blogshowcase/frontPostDetail/'.$data['ownerId'].'/'.$data['elementId'];
			break;
			case 'associatedprofessionals':
				$project_showcase_url = site_url(lang()).'/showcase/index/'.$data['ownerId'];
			break;
			case 'creatives':
				$project_showcase_url = site_url(lang()).'/showcase/index/'.$data['ownerId'];
			break;
			case 'enterprises':
				$project_showcase_url = site_url(lang()).'/showcase/index/'.$data['ownerId'];
			break;
			default:
			$project_showcase_url = site_url(lang()).'/showcase/index/'.$data['ownerId'];
		}
		
		
		if($data['abusiveType']==3)
		{
			if($isTable == true)
			{  
				//Block project related elements from db
				if($tableName == 'TDS_Project')
				{
					//Get project type
					$project_type = $this->model_reportproblem->get_project_type('TDS_Project','projectType','projId',$data['elementId']);
					//Get table name basis of project type
					switch ($project_type)
					{
						case 'writingNpublishing':
						$element_tbl = 'TDS_WpElement';
						break;
						case 'photographyNart':
						$element_tbl = 'TDS_PaElement';
						break;
						case 'musicNaudio':
						$element_tbl = 'TDS_MaElement';
						break;
						case 'educationMaterial':
						$element_tbl = 'TDS_EmElement';
						break;
						case 'filmNvideo':
						$element_tbl = 'TDS_FvElement';
						break;
						case 'reviews':
						$element_tbl = 'TDS_ReviewsElement';
						break;
						case 'news':
						$element_tbl = 'TDS_NewsElement';
						break;
						default:
						$element_tbl = '';
					}
					
					if(!empty($element_tbl))
					{
						//Block project basis of project type
						$this->model_reportproblem->block_element($element_tbl,'projId','isPublished',$data['elementId'], '');
					
						//Block projects from search table
						$this->model_reportproblem->block_search_project($data['projectId'], $data['entityId']);
					}
				}
				
				//Block Blog related content from db
				elseif($tableName == 'TDS_Blogs')
				{   
					//Block posts along with blog
					$this->model_reportproblem->block_element('TDS_Posts','blogId','isPublished',$data['elementId'], 'postArchived');
					
					//Block projects from search table
					$this->model_reportproblem->block_search_project($data['projectId'], $data['entityId']);	
				}
				
				//Block element of tables
				$this->model_reportproblem->block_element($tableName,$primary_field_name,$publish_field_name,$data['elementId'], $archived_field_name);
			
				//Block element from search table
				$this->model_reportproblem->block_search_element($data['entityId'], $data['elementId']);
				
				//Send Tmail to owner and publisher
				
				//Switch case to get reason of report
				switch ($this->input->post('reasonType'))
				{
					case 1:
					  $reportType = "Infringement of third party’s legal rights, including intellectual property rights.";
					  break;
					case 2:
					   $reportType = "Defamatory material.";
					  break;
					case 3:
					   $reportType = "Material offending public morality (including discriminative, xenophobic or racist photos).";
					  break;
					case 4:
					   $reportType = "Any violent or pornographic material accessible for minors.";
					  break;
					case 5:
					   $reportType = "Privacy concerns.";
					  break;
					case 6:
					   $reportType = "Others.";
					  break;
				}
				
				//Get template body of report
				if($this->input->post('reasonType')==6){
					$where=array('purpose'=>'reportproblemblockcontentotheroption','active'=>1);
					$tmailWhere=array('purpose'=>'tmailreportproblemblockcontentotheroption','active'=>1);
				}else{
					$where=array('purpose'=>'reportproblemblockcontent','active'=>1);
					$tmailWhere=array('purpose'=>'tmailreportproblemblockcontent','active'=>1);
				}
				$reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
				
				if($reportTemplateRes) {
					$reportTemplate = $reportTemplateRes[0]->templates;
					$searchArray = array("{SupportingProjectName}" , "{reportType}" , "{description}" ,  "{abusiveByUser_firstName}" , "{abusiveByUser_lastName}" , "{abusiveByUser_email}" ,  "{image_base_url}" , "{site_base_url}" , "{crave_us}", "{user_showcase_url}", "{project_showcase_url}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
					$replaceArray = array($SupportingProjectName,$reportType, $data['description'],$abusiveByUser_details->firstName,$abusiveByUser_details->lastName,$abusiveByUser_details->email,$image_base_url,$site_base_url,$crave_url,$user_showcase_url,$project_showcase_url,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
					$abusiveReportTemplate = str_replace($searchArray, $replaceArray, $reportTemplate);
					$abusiveReportTemplateSubject = $reportTemplateRes[0]->subject;
					
					//Send Email to sender and publisher
					for($i=0;$i<count($user_emails);$i++) {
						$this->email->from($from_email, $this->config->item('website_name', ''));
						$this->email->to($user_emails[$i]);
						$this->email->subject(sprintf($abusiveReportTemplateSubject));
						$this->email->message($abusiveReportTemplate);
						$flag = $this->email->send();
					}
					//End Email functionality
				}
				
				$reportMsgType = 8;
				//Tmail section 
				$tmailReportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $tmailWhere, '','', '', 1 );
				if($tmailReportTemplateRes) {
					$tmailReportTemplate = $tmailReportTemplateRes[0]->templates;
					$tmailsearchArray = array("{SupportingProjectName}" , "{reportType}" , "{description}" ,  "{abusiveByUser_firstName}" , "{abusiveByUser_lastName}" , "{abusiveByUser_email}" ,  "{image_base_url}" , "{site_base_url}" , "{project_showcase_url}" , "{user_showcase_url}");
					$tmailReplaceArray = array($SupportingProjectName,$reportType, $data['description'],$abusiveByUser_details->firstName,$abusiveByUser_details->lastName,$abusiveByUser_details->email,$image_base_url,$site_base_url,$project_showcase_url,$user_showcase_url);
					$tmailAbusiveReportTemplate = str_replace($tmailsearchArray, $tmailReplaceArray, $tmailReportTemplate);
					$tmailAbusiveReportTemplateSubject = $tmailReportTemplateRes[0]->subject;
					
					//Send Tmail to sender and publisher
					$this->sendTmail($recipients_email,$tmailAbusiveReportTemplateSubject,$tmailAbusiveReportTemplate,$reportMsgType);
				}
							
				
				$data['reason'] = $this->input->post('reasonType');
				$insert_report = $this->model_reportproblem->insert_abuse_report($data);
				if(!empty($insert_report))
				{
					echo "Your message has been sent";
				}
				else
				{
					echo "Error during save abusive report data";
				}
			}
			else
			{
				echo "No Element Found";
			}
		}
		else
		{  
			//Send Tmail to owner and publisher
			//$subject = 'Problem reported - Personal opinion about content';
			
			$where=array('purpose'=>'reportproblempersonalopinion','active'=>1);
			//Get template body of report
			$reportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
			if($reportTemplateRes){
				$reportTemplate=$reportTemplateRes[0]->templates;
				$searchArray = array("{SupportingProjectName}" , "{description}" , "{abusiveByUser_firstName}" , "{abusiveByUser_lastName}" , "{abusiveByUser_email}" , "{image_base_url}" , "{site_base_url}", "{crave_us}","{user_showcase_url}","{project_showcase_url}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
				$replaceArray = array($SupportingProjectName, $data['description'],$abusiveByUser_details->firstName,$abusiveByUser_details->lastName,$abusiveByUser_details->email,$image_base_url,$site_base_url,$crave_url,$user_showcase_url,$project_showcase_url,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
				$abusiveReportTemplate = str_replace($searchArray, $replaceArray, $reportTemplate);
				$abusiveReportTemplateSubject = $reportTemplateRes[0]->subject;
				
				//Send Email to sender and publisher
				for($i=0;$i<count($user_emails);$i++) {
					//$this->email->from($owner_details->email, 'toadsquare');
					$this->email->from($from_email, $this->config->item('website_name', ''));
					$this->email->to($user_emails[$i]);
					$this->email->subject(sprintf($abusiveReportTemplateSubject));
					$this->email->message($abusiveReportTemplate);
					$flag = $this->email->send();
				}
				//End Email functionality
			}
			$tmailWhere=array('purpose'=>'tmailreportproblempersonalopinion','active'=>1);
			//Get template body of report
			$tmailReportTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $tmailWhere, '','', '', 1 );
			$reportMsgType = 7;
			if($tmailReportTemplateRes){
				$tmailReportTemplate=$tmailReportTemplateRes[0]->templates;
				$tmailSearchArray = array("{SupportingProjectName}" , "{description}" , "{abusiveByUser_firstName}" , "{abusiveByUser_lastName}" , "{abusiveByUser_email}" , "{site_base_url}" ,"{user_showcase_url}","{project_showcase_url}");
				$tmailReplaceArray = array($SupportingProjectName, $data['description'],$abusiveByUser_details->firstName,$abusiveByUser_details->lastName,$abusiveByUser_details->email,$site_base_url,$user_showcase_url,$project_showcase_url);
				$tmailAbusiveReportTemplate = str_replace($tmailSearchArray, $tmailReplaceArray, $tmailReportTemplate);
				$tmailAbusiveReportTemplateSubject = $tmailReportTemplateRes[0]->subject;
				//Tmail section
				$this->sendTmail($recipients_email,$tmailAbusiveReportTemplateSubject,$tmailAbusiveReportTemplate,$reportMsgType);
				//End Tmail functionality
			}
										
			$data['reason'] = 0;
			$insert_report = $this->model_reportproblem->insert_abuse_report($data);
			if(!empty($insert_report))
			{
				echo "Your message has been sent";
			}
			else
			{
				echo "Error during save abusive report data";
			}
		}	
	}
	
	/* Send Mail */
	function sendTmail($recipients,$subject,$body,$reportMsgType){
		
		//$type=$this->input->post("type");
		//$type=($type >0)?$type:1;
		$msg = $this->tmail_messaging->send_new_message($this->userId,$recipients, $subject,$body,'',$reportMsgType);
		if($msg){
			return 1;
		}else{
			return 0;
		}
	}
	
}
