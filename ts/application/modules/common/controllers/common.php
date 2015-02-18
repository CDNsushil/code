<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common extends MX_Controller {
	private $data = array();
	private $userId = null;
	private $tblShipping = 'ProjectShipping';
	
	/**
	 * Constructor
	 */
	function __construct() {
		//Load required Model, Library, language and Helper files
			$load = array(
				'model'		=> 'report_a_problem/model_reportproblem + tmail/model_tmail + messagecenter/model_message_center + workprofile/model_workprofile',  
				'library' 	=> 'tmail/Tmail_messaging + form_validation + upload + messagecenter/lib_message_center',			 	
				'helper' 	=> 'form + file',	
				'config' 	=> 'image_config'
			);
			parent::__construct($load);		
			//$this->userId= $this->isLoginUser();
			$this->userId= isLoginUser()?isLoginUser():0;
			//for setting from in email address in _send_email
			$this->load->config('auth/tank_auth');
	}
	
	public function index(){
		
	}
	
	public function checkIsUserLogin(){
		$data= array("userId"=>$this->userId);
		echo json_encode($data);
	}
	
	function reArrangeRecordsOrder(){
		$this->userId= $this->isLoginUser();
		
		$currentdata =  $this->input->post('val1');
		$swapData =  $this->input->post('val2');
		if(isset($currentdata['table']) && isset($currentdata['pKey']) && isset($currentdata['pValue']) && isset($currentdata['orderKey']) && isset($currentdata['orderValue']) && isset($swapData['swpId']) && isset($swapData['swpOrder']) ){
			$tbl = trim($currentdata['table']);
			$pKey = trim($currentdata['pKey']);
			$pValue = (int)($currentdata['pValue']);
			$orderKey = trim($currentdata['orderKey']);
			$orderValue = trim($currentdata['orderValue']);
			$swpId = (int)($swapData['swpId']);
			$swpOrder = (int)($swapData['swpOrder']);
			
			if(!empty($pKey) && !empty($orderKey) && ($pValue > 0) && ($swpId > 0) && ($orderValue > 0) && ($swpOrder > 0)){
				$setCurrentData=array($orderKey=>$swpOrder);
				$setSwapData=array($orderKey=>$orderValue);
				$setCurrentWhere=array($pKey=>$pValue);
				$setSwapWhere=array($pKey=>$swpId);
				$res=$this->model_common->editDataFromTabel($tbl, $setCurrentData, $setCurrentWhere);
				$res=$this->model_common->editDataFromTabel($tbl, $setSwapData, $setSwapWhere);
				$msg=$this->lang->line('reArrangeOrderMsg');
				set_global_messages($msg, $type='success', $is_multiple=true);
			}
		}
		
	}
	
	public function changeStatusAsDeleted() {
		
		$id =  $this->input->post('val1');
		$tbl = trim($this->input->post('val2'));
		$field = trim($this->input->post('val3'));
		$section = trim($this->input->post('val4'));
		if(is_numeric($id) && ($id > 0) && $tbl != ''  && $field != '' ){
			$entityId=getMasterTableRecord($tbl);
			$editData=array('isDeleted'=>1);
			$whereCondition=array($field=>$id);
			
			$res=$this->model_common->editDataFromTabel($tbl, $editData, $whereCondition);
			if($res){
				$whereSessCondition=false;
				if($tbl=='Events'){
					$whereSessCondition=array('eventId'=>$id);
				}elseif($tbl=='LaunchEvent'){
					$whereSessCondition=array('launchEventId'=>$id);
				}
				if($whereSessCondition){
					$res=$this->model_common->editDataFromTabel('EventSessions', $editData, $whereSessCondition);
				}
				$this->model_common->editDataFromTabel('search', array('ispublished'=>'f','isdeleted'=>'t','datemodified' => currntDateTime()), array('entityid'=>$entityId,'elementid'=>$id));
				
				/* Send Email and Tmail for Session tickets start*/
				if($tbl=='EventSessions'){
					$this->sendEmailTmail($tbl,$id,$section);
				}
				/* Send Email and Tmail for Session tickets end*/
				
				echo 'Updated Successfully';
			}else{
				echo 'There is some problem please check sql query !!';
			}
		}
	}
	
	public function sendEmailTmail($tbl='',$id=0, $section='event') {
		$isTableFound=true;
		$joinWithSessionTable=false;
		
		switch($tbl){
			case 'Events':
				$selectedField='Events.StartDate,Events.FinishDate,Events.EventId as "eventId", Events.Title as "title"';
				$where=array('Events.EventId'=>$id);
				$like='"entityIdPE":"9"';
			break;
			
			case 'LaunchEvent':
				$selectedField='LaunchEvent.LaunchEventId as "launchEventId",LaunchEvent.LaunchDate as "StartDate",EventSessions.date as "FinishDate", LaunchEvent.Title as "title"';
				$joinWithSessionTable=true;
				$where=array('LaunchEvent.LaunchEventId'=>$id);
				$like='"entityIdPE":"15"';
			break;
			
			case 'EventSessions':
			
				$selectedField='EventSessions.date as "FinishDate",EventSessions.eventId,EventSessions.launchEventId,EventSessions.sessionId, EventSessions.sessionTitle as "title"';
				$where=array('EventSessions.sessionId'=>$id);
			break;
			
			default:
				$isTableFound=false;
			break;
		}
	
		if($isTableFound){
			$res= $this->model_common->getEventLaunchSession($tbl, $selectedField, $where, $joinWithSessionTable);
			if($res){
				
				$res=$res[0];
				$projectTitle=$res->title;
				if(isset($res->StartDate)){
					$startDate=$res->StartDate;
				}else{
					$startDate=$res->FinishDate;
				}
				$startDate=strtotime($startDate);
				$FinishDate=$res->FinishDate;
				
				$FinishDate=strtotime($FinishDate);
				$currentDate=date('Y-m-d');
				$currentDate=strtotime($currentDate);
				
				if(($startDate > $currentDate) || ($FinishDate > $currentDate)){
					$like2=false;
					$projId=$id;
					if($tbl=='EventSessions'){
						if($section=='event'){
							$like='"entityIdPE":"9"';
						}else{
							$like='"entityIdPE":"15"';
						}
						$like2='"SessionId":"'.$id.'"';
						$projId=0;
					}
					
					$userDetails= $this->model_common->getTicketPurchaseUser($projId, $like, $like2);
				
					/* get delete email template*/
					$where=array('purpose'=>'eventwithlaunchdeleted','active'=>1);
					$deleteTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
					
					/* get delete Tmail template*/
					$deleteWhere=array('purpose'=>'tmaileventwithlaunchdeleted','active'=>1);
					$deleteTmailTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $deleteWhere, '','', '', 1 );
					
					/* while we don't remove restriction (username, password) in .htacess file  from live site*/
					$image_base_url = site_base_url().'images/email_images/';
					/* Set Crave link*/
					$crave_url = $this->config->item('crave_url');
					/* Set Follow us link*/
					$facebook_url = $this->config->item('facebook_follow_url');
					$linkedin_url = $this->config->item('linkedin_follow_url');
					$twitter_url = $this->config->item('twitter_follow_url');
					$gPlus_url = $this->config->item('google_follow_url');
					
					if($userDetails){
						foreach($userDetails as $user){
							if($user->active!=2 && $user->banned!=1){
								$sellerInfo=json_decode($user->sellerInfo);
								$ownerId=$user->sellerId;
								$ownerName=$sellerInfo->firstName.' '.$sellerInfo->lastName;
								$ownerEmail=$sellerInfo->email;
								
								$receiverId=$user->tdsUid;
								$receiverEmail=$user->email;
								$receiverName=$user->firstName.' '.$user->lastName;
								
								/* Set Event Email Body and Subject for Email*/
								if($deleteTemplateRes) {
									$deleteEmailTemplate=$deleteTemplateRes[0]->templates;
									/* owner showcase url */
									$owner_showcase = base_url().lang().'/showcase/aboutme/'.$ownerId;
									$searchArray = array("{launch_name}" , "{user_name}" , "{image_base_url}", "{crave_us}","{user_showcase}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
									$replaceArray = array($projectTitle, $ownerName,$image_base_url,$crave_url,$owner_showcase,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
									$deleteTemplateBody=str_replace($searchArray, $replaceArray, $deleteEmailTemplate);
									$deleteTemplateSubject=$deleteTemplateRes[0]->subject;
								
									$from_email = $this->config->item('webmaster_email', '');
									$this->email->from($from_email, $this->config->item('website_name', ''));
									$this->email->to($receiverEmail);
									$this->email->subject(sprintf($deleteTemplateSubject));
									$this->email->message($deleteTemplateBody);
									$flag = $this->email->send();
								}
								/* Send mail to receiver */
									
								/* Set Event Email Body and Subject for Tmail */	
								if($deleteTmailTemplateRes) {
									$deleteTmailTemplate=$deleteTmailTemplateRes[0]->templates;
									//owner showcase url 
									$owner_showcase = base_url().lang().'/showcase/aboutme/'.$ownerId;
									$searchArray = array("{launch_name}" , "{user_name}" ,"{user_showcase}");
									$replaceArray = array($projectTitle, $ownerName,$owner_showcase);
									$deleteTmailTemplateBody=str_replace($searchArray, $replaceArray, $deleteTmailTemplate);
									$deleteTmailTemplateSubject=$deleteTmailTemplateRes[0]->subject;
									$this->sendTmail($receiverId,$deleteTmailTemplateSubject,$deleteTmailTemplateBody,1);		
								}
								/* Send Tmail to receiver*/		
							}	
						}
					}
				}
			}
		}
	}
	
	/* Function to send TMail */
	function sendTmail($recipients,$subject,$body,$msgType){
		
		$msg = $this->tmail_messaging->send_new_message($this->userId,$recipients, $subject,$body,'',$msgType);
		if($msg){
			return 1;
		}else{
			return 0;
		}
	}
	
    public function deleteRecord() {
		$this->userId= $this->isLoginUser();
		$ID = explode(',',$this->input->post('val1'));
		$tbl = trim($this->input->post('val2'));
		$field = trim($this->input->post('val3'));
		$fileId = $this->input->post('val4');
		$entityId=getMasterTableRecord($tbl);
		if(!empty($tbl) && !empty($field) && (count($ID) > 0)){
			$this->model_common->deleteRowFromTabel($tbl, $field, $ID);
		}
	}
	
	public function deleteTabelRow() {
		
		$this->userId= $this->isLoginUser();
		$ID = explode(',',$this->input->post('val1'));
		$tbl = trim($this->input->post('val2'));
		$field = trim($this->input->post('val3'));
		$fileId = $this->input->post('val4');
		$filePath = trim($this->input->post('val5'));
		$isLogSummery = trim($this->input->post('val6'));
		$deleteCache = trim($this->input->post('val7'));
		
		$entityId=getMasterTableRecord($tbl);
		
		if(!empty($tbl) && !empty($field) && (count($ID) > 0)){
			if($deleteCache=='_interview'){
				
				$editData=array(
									'interviewFileId'=>0,
									'interviewTitle'=>'',
									'interviewDescription'=>''
								);
				$showcaseWhere=array(
									$field=>$this->input->post('val1')
								);
				$this->model_common->editDataFromTabel($tbl, $editData, $showcaseWhere);
				
			}elseif($deleteCache=='_Introductory'){
				$editData=array(
									'introductoryFileId'=>0,
									'introductoryTitle'=>'',
									'introductoryDescription'=>''
								);
				$showcaseWhere=array(
									$field=>$this->input->post('val1')
								);
				$this->model_common->editDataFromTabel($tbl, $editData, $showcaseWhere);
			}else{
				// usershowcase will never delete
				if($tbl != 'UserShowcase' &&  $tbl != 'TDS_UserShowcase'){
					$this->model_common->deleteRowFromTabel($tbl, $field, $ID);
				}
			}
			if($fileId > 0 || (is_array($fileId) && count($fileId) > 0 )){
				
				$fileRes=$this->model_common->getDataFromTabelWhereIn('MediaFile', 'fileName,filePath',  'fileId', $fileId);
				if($fileRes){
					foreach($fileRes as $file){
						$filePath=trim($file['filePath']);
						$fileName=trim($file['fileName']);
						if(is_dir($filePath) && $fileName !=''){
							$fpLen=strlen($filePath);
							if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
								$filePath=$filePath.DIRECTORY_SEPARATOR;
							}
							findFileNDelete($filePath,$fileName);
						}
					}
					$this->model_common->deleteRowFromTabel('MediaFile','fileId',$fileId);
				}
			}
			if($isLogSummery > 0){
				
				$elementId=$ID[0];
				if($entityId > 0 && $elementId>0){
					$field=array(
										'entityId'=>$entityId,
										'elementId'=>$elementId
								);
					$this->model_common->deleteRowFromTabel('LogSummary',$field);
				}
			}
			
			if(!empty($deleteCache) && !($deleteCache == '_interview' || $deleteCache == '_Introductory')){
				$sectionCache =$deleteCache;
				$this->session->set_userdata($sectionCache,1);
			}
			
			if($entityId > 0 && $elementId>0){
				$whereField=array('entityid'=>$entityId,'elementid'=>$elementId);
				$res=$this->model_common->getDataFromTabel('search', 'id',  $whereField, '', '', '', $limit=1 );
				if($res){
					$id=$res[0]->id;
					if($id > 0){
						$this->model_common->editDataFromTabel('search', array('ispublished'=>'f','isdeleted'=>'t','datemodified' => currntDateTime()), array('id'=>$id));
					}
				}
			}
		}
	
	}
	public function deleteTabelRowAdmin() {
		$ID = explode(',',$this->input->post('val1'));
		$tbl = trim($this->input->post('val2'));
		$field = trim($this->input->post('val3'));
		$fileId = $this->input->post('val4');
		if(!empty($tbl) && (count($ID) > 0)){
			$this->model_common->deleteRowFromTabel($tbl, $field, $ID);
		}
		if($fileId > 0 || (is_array($fileId) && count($fileId) > 0 )){
			
			$fileRes=$this->model_common->getDataFromTabelWhereIn('MediaFile', 'fileName,filePath',  'fileId', $fileId);
			if($fileRes){
				foreach($fileRes as $file){
					$filePath=trim($file['filePath']);
					$fileName=trim($file['fileName']);
					if(is_dir($filePath) && $fileName !=''){
						$fpLen=strlen($filePath);
						if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
							$filePath=$filePath.DIRECTORY_SEPARATOR;
						}
						findFileNDelete($filePath,$fileName);
					}
				}
				$this->model_common->deleteRowFromTabel('MediaFile','fileId',$fileId);
			}
		}
		
	}
	
	public function playMediaFile() 
	{
		$data['file'] = trim($this->input->get('val1'));
		$data['fileType'] = trim($this->input->get('val2'));
		$data['duration'] = trim($this->input->get('val3'));
		$this->load->view('media_play',$data);
	}
	
	public function loadButtons($button){
		$data['button']=$button;
		$this->load->view('button_collection',$data);
	}
	
	function formInputField($data=array()){
		$this->load->view($data['view'],$data);
	}
	
	function strip($view=''){
		$view=$view != ''?$view:'strip';
		$this->load->view($view);
	}
	
	public function loadRelations($relation){
		$data['relation']=$relation;
		$this->load->view('relation_to_share',$data);
	}
	
	public function loadFrontRelations($relation){
		$data['relation']=$relation;
		$this->load->view('front_relation_to_share',$data);
	}
	
	function profileImage($image=''){
		$data['image']=$image;
		$this->load->view('profileImage',$data);
	}
	
	/**
	 * getGenerList fucntion 
	 *
	 * function call by  new project view through ajax
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	public function getGenerList() {
		$ID=$this->input->post('val1');
		$IndsID=$this->input->post('val2');
		$name=$this->input->post('val3');
		$entityId=$this->input->post('val4');
		$setvalue=$this->input->post('val5');
		$name = ($name!='')?$name:'projGenre';
		$genere =getGenerList($ID,$IndsID,lang(),'selectGenre',$entityId);
		$html=form_dropdown($name, $genere, $setvalue,'id="projGenre" class="required width264px  selectBox"');
		$html.=" <script>selectBox();</script>";
		echo $html;
	}
	
	/**
	 * getTypeList fucntion 
	 *
	 * function call by  new project view through ajax
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	public function getTypeList() {
		$lang=lang();
		$indusrtyId=$this->input->post('val1');
		$catId=$this->input->post('val2');
		
		$projectType =getTypeList($indusrtyId, $lang, 'selectProjectType',$catId);
		$html=form_dropdown('projType', $projectType, '','id="projType" class="required selectBox" onchange="getGenerList(\'subGenreList\',this.value);"');
		$html.=" <script>selectBox();</script>";
		echo $html;
	}
	/**
	 * getIndustryList fucntion 
	 *
	 * function call by  new project view through ajax
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	public function getIndustryList() 
	{
		$lang=lang();
		$typeValue=$this->input->post('val2');
				
		$industryList = getIndustryList($lang,'',$typeValue,'selectIndustry');
		$html=form_dropdown('projIndustry', $industryList, '','id="IndustryList" class="required selectBox"');
		$html.=" <script>selectBox();</script>";
		echo $html;
	}
	
	
	/**
	 * count_words fucntion 
	 *
	 * function called for  count word 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	function count_words($string){
  
		   $string = trim(preg_replace("/\s+/"," ",$string));
		   $word_array = explode(" ", $string);
		   // print_r($word_array);
		   if($string!="")
			$num = count($word_array);
		   else
			$num =0;
		 return $num;
  
	}
	
	/**
	 * getTypeListGenre fucntion 
	 *
	 * function call by  event view through ajax
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	public function getTypeListGenre() {
		$lang=lang();
		$indusrtyId=$this->input->post('val1');
		$catId=$this->input->post('val2');
		$projectType =getTypeList($indusrtyId, $lang, 'selectProjectType',$catId);
		$html=form_dropdown('Type', $projectType, '','id="Genre" class="required selectBox" onchange="getGenerList(\'subGenreList\',this.value,'.$indusrtyId.',\'Genre\' );eventReqfields();"');	
		
		$html.=" <script>selectBox();</script>";
		echo $html;
	}
	
	
	
	/**
	 * getTypeList fucntion 
	 *
	 * function call by  new project view through ajax
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	public function getCategoryList() {
		$lang=lang();
		$indusrtyId=$this->input->post('val1');
		$entityId=$this->input->post('val2');
		$defaultOption=$this->lang->line('selectGenre');
		$categoryType=getProjCategoryList($indusrtyId, $lang, 'selectCategory',$entityId);
		$html=form_dropdown('projCategory', $categoryType, '','id="projCategory" class="required single selectBox" onchange="getTypeList(\'projectTypeList\',\'projGenre\','.$indusrtyId.',this.value,\''.$defaultOption.'\');"');
		$html.=" <script>selectBox();</script>";
		echo $html;
	}
	
	
	//-----------------------------------------------------------------------------------------------
	
	/**
	 * @access: public
	 * @description: This function is used to send invitation
	 * @modified: 14-07-2014 (lokendra Meena)
	 * @return void
	 */ 
	
	public function sendEmail()
	{
		//if required data not submited the show error message
		if($this->input->post('val1')==false || $this->input->post('val2')==false || $this->input->post('val3')==false || $this->input->post('val4')==false || $this->input->post('val5')==false ){
			echo '<div class="row mt20 pl10"><div class="cell">';
			echo '<div class="row lh40"><div class="cell">Required data not submited.</div></div>';
			echo '</div></div>';
			return true;
		}
		
		//get post data
		$toaddress 		 = $this->input->post('val1');
		$shared 		 = $this->lang->line('shared');
		$relationSubject = '['.$shared.' '.$this->input->post('val4').'] '.$this->input->post('val3');
	    $relationBody    =  $this->input->post('val2');
		
		//prepare email send data	
		$data['relationBody'] = $relationBody;
		$data['toAddress'] 	  = $toaddress;
		$data['sharedTitle']  = $this->input->post('val3');
		$data['sharedMsg3']   = $this->lang->line('sharedMsg3').$this->input->post('val4').': ';//$this->lang->line('sharedMsg3');
		$data['linkToShare']  = $this->input->post('val5');
		
		//call email send private member function
		$this->_send_email('shared_page',$toaddress,$data,$relationSubject);
		
		//show message after sent invitation
		echo '<div class="row mt20 pl10"><div class="cell">';
		echo '<div class="row lh40"><div class="cell">'.$this->lang->line('sharedMsg1').'</div></div>';
		echo '<div class="row lh40"><div class="cell">'.$this->lang->line('sharedMsg2').'</div></div>';
		echo '<div class="row lh40"><div class="cell">'.$toaddress.'</div></div>';
		echo '<div class="row lh40"><div class="cell"><div class="tds-button floatRight">'.anchor('javascript://void(0);', '<span>'.$this->lang->line('close').'</span>',array('id'=>'cancelemail','onclick'=>'hideAllRelationDiv();','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')).'</div></div></div>';
		echo '</div></div>';
	}
	
	//----------------------------------------------------------------------------------
	
	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	private function _send_email($type, $email, $data, $subject)
	{
		//load email library for sending email
		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email'), $this->config->item('website_name'));
		$this->email->reply_to($this->config->item('webmaster_email'), $this->config->item('website_name'));
		$this->email->to($email);
		$this->email->subject($subject);
		
		//apply conditon for logged in user
		if(isLoginUser()){
		
			$data['user_email'] = LoginUserDetails('email');
			$firstName = LoginUserDetails('firstName');
			$lastName = LoginUserDetails('firstName');
			
			//get logged user first name
			if(isset($firstName) && $firstName!='')
			$data['user_name'] =  LoginUserDetails('firstName');
			
			//check last if exist then get last name of logged in user
			if(isset($lastName) && $lastName!='')
			{
				if(isset($firstName) && $firstName!='')
					// set firstname and lastname in username
					$data['user_name'] =  LoginUserDetails('firstName').' '.LoginUserDetails('lastName');			
				else
					// set user lastname
					$data['user_name'] =  LoginUserDetails('lastName');
			}
		}else{
			//if not logged in then set entered emailid as usernamd and user email
			$data['user_email'] = $email;
			$data['user_name']  = $email;
		}
		
		//set email message
		$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		
		//send email 
		$this->email->send();
	}
	
	//-------------------------------------------------------------------------------
	
	function JqueryUploadMediaFile($fileUploadPath='temp',$isPosterImage=0)
	{
		$fileUploadPath=str_replace('+',DIRECTORY_SEPARATOR,$fileUploadPath);
		
		$targetDir = ROOTPATH.$fileUploadPath;
		
		$fpLen=strlen($targetDir);
		if($fpLen > 0 && substr($targetDir,-1) != DIRECTORY_SEPARATOR){
			$targetDir=$targetDir.DIRECTORY_SEPARATOR;
		}
		
		$cmd3 = 'chmod -R 777 '.MEDIAUPLOADPATH;
		exec($cmd3);
		 if(!is_dir($targetDir)){
			mkdir($targetDir, 0777, true);
		 }
		 
		 $convertedDIR=$targetDir.'converted';
			if(!is_dir($convertedDIR)){
				mkdir($convertedDIR, 0777, true);
			}

		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds

		// 5 minutes execution time
		set_time_limit(5 * 60);

		// Uncomment this one to fake upload time
		// usleep(5000);

		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

		// Clean the fileName for security reasons
		 $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
		
		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir.$fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);

			$count = 1;
			while (file_exists($targetDir.$fileName_a . '_' . $count . $fileName_b))
				$count++;

			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}
		
		

		$filePath = $targetDir.$fileName;
		
		

		
		$cmdtargetDir = 'chmod -R 777 '.$targetDir;
		exec($cmdtargetDir);
		//echo $cleanupTargetDir;
		//die;
		
		if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir.$file;

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
					@unlink($tmpfilePath);
				}
			}

			closedir($dir);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			

		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];

		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				
				if(is_numeric($isPosterImage) && $isPosterImage==1){
					$imagesize=getimagesize($_FILES['file']['tmp_name']);
					if(isset($imagesize[0]) && ($imagesize[0] >= 457 ) && isset($imagesize[1]) && ($imagesize[1] >= 640 )){
					
					}else{
						$posterImageInfo=$this->lang->line('posterImageInfo');
						die('{"jsonrpc" : "2.0", "error" : {"code": -100, "message": "'.$posterImageInfo.'"}, "id" : "id"}');
					}
				}
				
				// Open temp file
				$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");

					if ($in) {
						while ($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else
						die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		} else {
			// Open temp file
			$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");

				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

				fclose($in);
				fclose($out);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off 
			rename("{$filePath}.part", $filePath);
		}
		
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "filename" : "'.$fileName.'", "filepath" : "'.$targetDir.'"}');		
		
	}
	
	function createranderjob(){
		$targetDir=$this->input->post('val1');
		$targetDir=str_replace('+',DIRECTORY_SEPARATOR,$targetDir);
		$targetDir=ROOTPATH.$targetDir;
		$fileName=$this->input->post('val2');
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		$filenameOnly=explode(".".$ext, $fileName);
		$filenameOnly=$filenameOnly[0];
		$JobID=$filenameOnly.time();
		$Source=$targetDir.$fileName;
		$Destination=$targetDir.'converted'.DIRECTORY_SEPARATOR.$filenameOnly.'.mp4';
		$randerjobParams=array('JobID'=>$JobID,'Type'=>$ext,'Source'=>$Source,'Destination'=>$Destination,'Added'=>currntDateTime());
		renderjob($randerjobParams);
	}
	
	
	function UpdateMediaTable(){
		
		$elements=false;
		$files=false;
		
		$data['MediaFile']=$this->input->post('val1');
		$data['dataProject']=$this->input->post('val2');
		$data['fileId']=$this->input->post('val3');
		$data['elementId']=$this->input->post('val4');
		$data['elemetTable']=$this->input->post('val5');
		$data['elementFieldId']=$this->input->post('val6');
		$data['defaultImage']=$data['src']=$this->input->post('val7');
		$data['isDefaultElement']= $this->input->post('val8');		
		$loadView = $this->input->post('val9');		
		$data['deleteCache'] = $this->input->post('val10');		
		
		//-------check piece id already exist---------//
		if(isset($data['dataProject']['mediaTypeId']) && is_numeric($data['dataProject']['mediaTypeId']) && ($data['dataProject']['mediaTypeId'] > 0) && isset($data['elementId']) && $data['elementId']==0 && strstr($data['elemetTable'], 'Element')){
			$whereCondition=array('projId'=>$data['dataProject']['projId'],'mediaTypeId'=>$data['dataProject']['mediaTypeId']);
			$dataAlreadyExist = $this->model_common->getDataFromTabel($data['elemetTable'],'elementId,fileId', $whereCondition,'','',1);
			if($dataAlreadyExist && isset($dataAlreadyExist[0]->elementId)){
				$data['elementId']=$dataAlreadyExist[0]->elementId;
				$data['fileId']=$dataAlreadyExist[0]->fileId;
			}
		}
		
			
		//echo '<pre />MediaFile:<pre />';print_r($data);
		//echo '<pre />dataProject:';print_r($data['dataProject']);
	
		if(is_array($data['MediaFile']) && count($data['MediaFile'])>0){
			
			if($data['fileId']>0){
				
				$countResult=$this->model_common->countResult('MediaFile','fileId',$data['fileId'],1);
				if($countResult > 0){
					$files=true;
				}
			}
			
			if($files){
					$this->model_common->editDataFromTabel('MediaFile', $data['MediaFile'], 'fileId', $data['fileId']);
			}else{
				$data['MediaFile']['jobStsatus']='UPLOADING';
				$data['fileId']=$this->model_common->addDataIntoTabel('MediaFile', $data['MediaFile']);
			}
		}
		
		if($data['fileId']>0){
			$fileResult=$this->model_common->getDataFromTabel('MediaFile','*','fileId',$data['fileId'],'','',1, 0, $resultInArray=true);
		}
		
		
		if($data['elementId']>0){
			$countResult=$this->model_common->countResult($data['elemetTable'],$data['elementFieldId'],$data['elementId'],1);
			if($countResult > 0){
				$elements=true;
			}
		}		
		
		if($data['fileId'] > 0){
			
			if(isset($data['dataProject']['interviewFileId'])){
				$data['dataProject']['interviewFileId']=$data['fileId'];
			}elseif(isset($data['dataProject']['introductoryFileId'])){
				$data['dataProject']['introductoryFileId']=$data['fileId'];
			}else{
				$data['dataProject']['fileId']=$data['fileId'];
			}
		}		
		
		if($elements){
			$data['append']=false;
			$this->model_common->editDataFromTabel($data['elemetTable'], $data['dataProject'], $data['elementFieldId'], $data['elementId']);
			
		}else{
			$data['append']=true;
			
			/*******check if first piece then make as default image*******/
				/*
				 * no need first element true (9-sep-2013)
				 * if(isset($data['isDefaultElement']) && $data['isDefaultElement']=="f"){
					if(isset($data['dataProject']['mediaTypeId']) && is_numeric($data['dataProject']['mediaTypeId']) && ($data['dataProject']['mediaTypeId'] > 0) && isset($data['elementId']) && $data['elementId']==0 && strstr($data['elemetTable'], 'Element')){
						if($this->model_common->checkPieceAlreadyExit($data['dataProject']['projId'],$data['elemetTable'])==0){
							$data['dataProject']['isProjectImage']="t";
						}
					}else{
						if($data['dataProject']['mediaTypeId']==NULL){
							$whereCondition=array('projId'=>$data['dataProject']['projId']);
							$dataAlreadyExist = $this->model_common->getDataFromTabel($data['elemetTable'],'elementId', $whereCondition,'','',1);
							if(!$dataAlreadyExist && empty($dataAlreadyExist)){
								$data['dataProject']['isProjectImage']="t";
							}
						}
					}
				}*/
			/*******check if first piece then make as default image*******/
			$data['elementId']=$this->model_common->addDataIntoTabel($data['elemetTable'], $data['dataProject']);
			addDataIntoLogSummary($data['elemetTable'],$data['elementId']);
		}
		
		if(!empty($data['deleteCache'])){
				$sectionCache = $data['deleteCache'];
				$this->session->set_userdata($sectionCache,1);
		}
		
		
		if(isset($fileResult[0])){
			$data['MediaFile']= $fileResult[0];
		}else{
			$data['MediaFile']= false;
		}
		
		if(strstr($data['elemetTable'], 'Element')){
			$countResult=$this->model_common->countResult($data['elemetTable'],'projId',$data['dataProject']['projId']);
		}
	
		if($countResult==1){
			$this->session->set_userdata('isShowMediaPopup',1);
		}
		
		$this->load->view($loadView,$data);
		 
	}
	
	function UpdateSingleMedia()
	{		
		$elements=false;
		$files=false;
		$thumbImageExists=false;
		$flagDelAllThumbImg = 0;
		$data['MediaFile']=$this->input->post('val1');
		$data['dataProject']=$this->input->post('val2');
		$data['thumbData']=$this->input->post('val3');
		$data['fileId']=$this->input->post('val4');
		$data['thumbFileId']=$this->input->post('val5');
		$data['elementId']=$this->input->post('val6');
		$data['elemetTable']=$this->input->post('val7');
		$data['elementFieldId']=$this->input->post('val8');
		$data['src']=$this->input->post('val9');
		$data['isDefaultElement']= $this->input->post('val10');		
		$loadView = $this->input->post('val12');		
		$data['deleteCache'] = '';		
		
		if(is_array($data['thumbData']) && count($data['thumbData'])>0){
            $data['thumbData']['fileType'] = 1;
            $data['thumbData']['isExternal'] = 'f';
            $data['thumbData']['fileCreateDate'] = date("Y-m-d H:i:s");
            $data['thumbData']['tdsUid'] = $this->userId;
            
            if(isset($data['thumbFileId']) && $data['thumbFileId']>0){
				$thumbImageExists=$this->model_common->getDataFromTabel('MediaFile','fileName,filePath,isExternal','fileId',$data['thumbFileId'],'','',1);
			}
			
			if($thumbImageExists){
				if(isset($data['thumbData']['fileName']) && $data['thumbData']['fileName']!='' && isset($data['thumbData']['filePath']) && $data['thumbData']['filePath']!='') {				
					$flagDelAllThumbImg = 1;
					$this->model_common->editDataFromTabel('MediaFile', $data['thumbData'], 'fileId', $data['thumbFileId']);
				}
			}else{
					$flagDelAllThumbImg = 1;
					$data['thumbFileId'] = $data['dataProject']['thumbFileId']=$this->model_common->addDataIntoTabel('MediaFile', $data['thumbData']);
			}
			
			if($flagDelAllThumbImg != 0){				
				if($thumbImageExists > 0){
					if($thumbImageExists[0]->isExternal != 't'){
						$fileDir=trim($thumbImageExists[0]->filePath);
						$fileName=trim($thumbImageExists[0]->fileName);
						if(is_dir($fileDir) && $fileName !=''){
							$fpLen=strlen($fileDir);
							if($fpLen > 0 && substr($fileDir,-1) != DIRECTORY_SEPARATOR){
								$fileDir=$fileDir.DIRECTORY_SEPARATOR;
							}
							findFileNDelete($fileDir,$fileName);
						}
					}
				}
			}
		}
		
		if(is_array($data['MediaFile']) && count($data['MediaFile'])>0){
			if($data['fileId']>0){
				$countResult=$this->model_common->countResult('MediaFile','fileId',$data['fileId'],1);
				
				if($countResult > 0){
					$files=true;
				}
			}
			
			if($files){
				if(!isset($data['MediaFile']['fileName']) || $data['MediaFile']['fileName']==''){ unset($data['MediaFile']['fileName']);unset($data['MediaFile']['fileSize']);}
				$this->model_common->editDataFromTabel('MediaFile', $data['MediaFile'], 'fileId', $data['fileId']);
			}else{
				$data['MediaFile']['jobStsatus']='UPLOADING';
				$data['fileId']=$this->model_common->addDataIntoTabel('MediaFile', $data['MediaFile']);
			}
		}
		
		if($data['fileId']>0){
			$fileResult=$this->model_common->getDataFromTabel('MediaFile','*','fileId',$data['fileId'],'','',1, 0, $resultInArray=true);
		}
		
		
		if($data['elementId']>0){
			$countResult=$this->model_common->countResult($data['elemetTable'],$data['elementFieldId'],$data['elementId'],1);
			if($countResult > 0){
				$elements=true;
			}
		}		
		
		if($data['fileId'] > 0){
			$data['dataProject']['fileId']=$data['fileId'];
		}		
		if($data['thumbFileId'] > 0){
			$data['dataProject']['thumbFileId'] = $data['thumbFileId'];
		}		
		
		if($elements){
			$data['append']=false;
			$this->model_common->editDataFromTabel($data['elemetTable'], $data['dataProject'], $data['elementFieldId'], $data['elementId']);
		}else{
			$data['append']=true;
			$data['elementId']=$this->model_common->addDataIntoTabel($data['elemetTable'], $data['dataProject']);
			addDataIntoLogSummary($data['elemetTable'],$data['elementId']);
		}
		if(!empty($data['deleteCache'])){
				$sectionCache = $data['deleteCache'];
				$this->session->set_userdata($sectionCache,1);
		}
		if(isset($fileResult[0])){
			$data['MediaFile']= $fileResult[0];
		}else{
			$data['MediaFile']= false;
		}
		
		echo $this->load->view($loadView,$data);
	}
	
	function UpdateTable()
	{		
		$elements=false;
		$data['dataProject']=$this->input->post('val1');
		$data['elementId']=$this->input->post('val2');
		$data['elemetTable']=$this->input->post('val3');
		$data['elementFieldId']=$this->input->post('val4');		
		$data['src']=$this->input->post('val5');		
		$data['title']=$this->input->post('val6');
		$data['fileLength']=$this->input->post('val7');
		$data['imageField']=$this->input->post('val8');
		$loadView=$this->input->post('val9');		
		$data['deleteCache']=$this->input->post('val10');
		
		$data['entityId']=getMasterTableRecord($data['elemetTable']);
				
		if($data['elementId']>0){
			if(($data['imageField'] && !empty($data['imageField']))){
				$field=$data['imageField'];
			}else{
				$field=$data['elementFieldId'];
			}
			
			$result=$this->model_common->getDataFromTabel($data['elemetTable'],'*',$data['elementFieldId'],$data['elementId'],'','',1,0,true);
			if(isset($result[0])){
				$result=$result[0];
				if(isset($data['dataProject'][$data['imageField']]) && !empty($data['dataProject'][$data['imageField']])){
					if(($data['imageField'] && !empty($data['imageField']))){
						
						$filePath = trim($result[$data['imageField']]);
						$fileInfo=pathinfo($filePath);
						$fileDir=$fileInfo['dirname'];
						$fileName=$fileInfo['basename'];
						
						if(is_dir($fileDir) && $fileName !=''){
							$fpLen=strlen($fileDir);
							if($fpLen > 0 && substr($fileDir,-1) != DIRECTORY_SEPARATOR){
								$fileDir=$fileDir.DIRECTORY_SEPARATOR;
							}
							findFileNDelete($fileDir,$fileName);
						}
						
						//----------set isProjectImage false in element table in upload any project image---------//
						$getElementTable = getMasterTableName($data['dataProject']['elementEntityId']);
						$getElementTable = $getElementTable[0];
						$this->model_common->editDataFromTabelWhereIn($getElementTable, array('isProjectImage'=>'f'), array('projId'=>$data['elementId']));
					}
				}
				$elements=true;
			}
		}
		unset($data['dataProject']['elementEntityId']);
		if($elements){
		   $this->model_common->editDataFromTabel($data['elemetTable'], $data['dataProject'], $data['elementFieldId'], $data['elementId']);
			//$data['dataProject']=$result;
		}
		if(!empty($data['deleteCache'])){
				$sectionCache = $data['deleteCache'];
				$this->session->set_userdata($sectionCache,1);
		}
		$this->load->view($loadView,$data);
	}
	
	function copyProjectInformationIntoelement(){
		$data['projectId']=$this->input->post('val1');
		$data['projectEntityId']=$this->input->post('val2');
		$data['elemetTable']=$this->input->post('val3');
		$data['elementId']=$this->input->post('val4');
		$data['entityId']=$this->input->post('val5');
		$data['title']=$this->input->post('val6');
		$data['fileLength']=$this->input->post('val7');
		$data['src']=$this->input->post('val8');
		$loadView=$this->input->post('val9');		
		$data['deleteCache']=$this->input->post('val10');
				
		if($data['projectId'] > 0 && $data['projectEntityId'] > 0 &&  $data['elementId']>0 && $data['entityId'] > 0){
			
			$where=array('elementId'=>$data['projectId'],'entityId'=>$data['projectEntityId']);
			$creativeData=$this->model_common->getDataFromTabel('AssociativeCreatives','crtDesignation,crtName,crtEmail',$where);
			if($creativeData){
				foreach($creativeData as $crt){
					$CD = array(
						'crtDesignation' => $crt->crtDesignation,
						'crtName' => $crt->crtName,
						'crtStatus' =>   't',
						'crtEmail'=> $crt->crtEmail,
						'elementId' =>    $data['elementId'],
						'entityId' => $data['entityId']
					);
					$crtId=$this->model_common->addDataIntoTabel('AssociativeCreatives', $CD);
				}
			}
			$projectData=$this->model_common->getDataFromTabel('Project','projBaseImgPath,productionHouse,projTag,projDescription,rawFileName','projId',$data['projectId'],'','',1);
			if($projectData){
					$projectData=$projectData[0];
					$data['imageField']	='imagePath';
					if(@is_file($projectData->projBaseImgPath)){
						$filepathinfo = pathinfo($projectData->projBaseImgPath);
						$newFilePath  = $filepathinfo['dirname'].DIRECTORY_SEPARATOR.$filepathinfo['filename'].'_copy_'.$data['elementId'].'.'.$filepathinfo['extension'];
						copy ($projectData->projBaseImgPath,$newFilePath);
					}else{
							$newFilePath = '';
					}
					$data['dataProject']['imagePath']=$newFilePath;
					$data['dataProject']['rawFileName']=$projectData->rawFileName;
					$data['dataProject']['tags']=$projectData->projTag;
					$data['dataProject']['description']=$projectData->projDescription;
					$data['dataProject']['productionCompany']=$projectData->productionHouse;
					$this->model_common->editDataFromTabel($data['elemetTable'], $data['dataProject'], 'elementId', $data['elementId']);
			}
		}
		
		if(!empty($data['deleteCache'])){
				$sectionCache = $data['deleteCache'];
				$this->session->set_userdata($sectionCache,1);
		}
		$this->load->view($loadView,$data);
	}
	
	public function moveFromArchive($tbl='',$primeryField='',$primeryVal=0,$archiveField='') {	
		$tbl = $this->input->post('val1');
		$primeryField = $this->input->post('val2');
		$primeryVal = $this->input->post('val3');
		$archiveField = $this->input->post('val4');
		$deleteCache = $this->input->post('val5');
		$elementTable = $this->input->post('val6');
		$elementField = $this->input->post('val7');
		$elementArchiveField = $this->input->post('val8');
		
		if($tbl != '' && $primeryField !='' && $primeryVal > 0 && $archiveField !=''){
			$Where=array($primeryField=>$primeryVal);
			$editData=array($archiveField=>'f');
			
			$res=$this->model_common->editDataFromTabel($tbl, $editData, $Where);
			
			if($res){
				if(!empty($elementTable) && !empty($elementField) && !empty($elementArchiveField)){
					$editElementData[$elementArchiveField]='f';
					$res=$this->model_common->editDataFromTabel($elementTable, $editElementData, $elementField,$primeryVal);
				}
			}
			
			if(!empty($deleteCache)){
				$sectionCache =$deleteCache;
				$this->session->set_userdata($sectionCache,1);
			}
		}
	}
	public function moveInArchive($tbl='',$primeryField='',$primeryVal=0,$archiveField='',$publishField='') {	
		$tbl = $this->input->post('val1');
		$primeryField = $this->input->post('val2');
		$primeryVal = $this->input->post('val3');
		$archiveField = $this->input->post('val4');
		$publishField = $this->input->post('val5');
		$deleteCache = $this->input->post('val6');
		$elementTable = $this->input->post('val7');
		$elementField = $this->input->post('val8');
		$elementArchiveField = $this->input->post('val9');
		$elementPublishField = $this->input->post('val10');
		
		if($tbl != '' && $primeryField !='' && $primeryVal > 0 && $archiveField !='' && $publishField != ''){
			$Where=array($primeryField=>$primeryVal);
			$editData=array($archiveField=>'t',$publishField=>'f');
			$res=$this->model_common->editDataFromTabel($tbl, $editData, $Where);
			if($res){
				$entityid=getMasterTableRecord($tbl);
				$edtitSearchData=array('ispublished'=>'f');
				$this->model_common->editDataFromTabel('search', array('ispublished'=>'f','isdeleted'=>'t','datemodified' => currntDateTime()), array('entityid'=>$entityid, 'projectid'=>$primeryVal));
				if(!empty($elementTable) && !empty($elementField)){
					$editElementData=array($elementPublishField=>'f');
					if(!empty($elementArchiveField) && $elementArchiveField !=''){
						$editElementData[$elementArchiveField]='t';
					}
					$res=$this->model_common->editDataFromTabel($elementTable, $editElementData, $elementField,$primeryVal);
					$entityid=getMasterTableRecord($elementTable);
					
					$this->model_common->editDataFromTabel('search', array('ispublished'=>'f','isdeleted'=>'t','datemodified' => currntDateTime()), array('entityid'=>$entityid, 'projectid'=>$primeryVal));
				}
			}
			if((!empty($deleteCache)) && ($deleteCache!='notification')){
				$sectionCache =$deleteCache;
				$this->session->set_userdata($sectionCache,1);
			}
		}
		
		/*Send mail and Tmails for Event & Launch start*/
		if(($tbl=='LaunchEvent' || $tbl=='Events') && (isset($primeryVal)) && ($deleteCache!='notification')){
			if($tbl=='Events'){
				$section = 'event';
			}else{
				$section = 'launch';
			}
			$this->sendEmailTmail($tbl,$primeryVal,$section);
		}
		/*Send mail and Tmails for Event & Launch end*/
	}
	
	function publishUnpulish(){
		$userId= $this->isLoginUser();
		$publishUnpublishInfo=$this->input->post('val1');
		$tbl=$publishUnpublishInfo['tabelName'];
		$pulishField=$publishUnpublishInfo['pulishField'];
		$field=$publishUnpublishInfo['field'];
		$fieldValue=$publishUnpublishInfo['fieldValue'];
		$projectId=(isset($publishUnpublishInfo['projectId']) && is_numeric($publishUnpublishInfo['projectId']) && ($publishUnpublishInfo['projectId'] > 0))?$publishUnpublishInfo['projectId']:$fieldValue;
		$isElement=(isset($publishUnpublishInfo['isElement']) && is_numeric($publishUnpublishInfo['isElement']))?$publishUnpublishInfo['isElement']:0;
		
		$elementTable=trim($publishUnpublishInfo['elementTable']);
		$elementField=trim($publishUnpublishInfo['elementField']);
		$deleteCache=$publishUnpublishInfo['deleteCache'];
		$notificationArray=isset($publishUnpublishInfo['notificationArray'])?$publishUnpublishInfo['notificationArray']:'';
		
		$result=$this->model_common->getDataFromTabel($tbl,$pulishField,$field,$fieldValue,'','',1);
		
		$ispublished='t';
		if($result){
			$pulishFieldValue=$result[0]->$pulishField;
			if($pulishFieldValue == 't'){
				$ispublished='f';
				$edtitData=array($pulishField=>'f');
				$edtitSearchData=array('ispublished'=>'f');
			}else{
				$edtitData=array($pulishField=>'t');
				$edtitSearchData=array('ispublished'=>'t');
				$ispublished='t';
			}
			
			$entityid=getMasterTableRecord($tbl);
			
			$projectWhere=array($field=>$fieldValue);
			$searchProjWhere=array('entityid'=>$entityid, 'elementid'=>$fieldValue);
			if($edtitData[$pulishField]=='t'){
				$projectWhere['isBlocked']='f';
				$searchProjWhere['isblocked']='f';
			}
			
			$res=$this->model_common->editDataFromTabel($tbl, $edtitData, $projectWhere);
			$elementsToBePublished=false;
			if($res){
				
				$section = getSection($entityid,$projectId);
				$this->globalWriteCacheFile($userId,$section,$projectId);
				//To insert notification in NotificationQue Table, so that records get used by cron job
				if($ispublished=='t'){
					$this->send_notification_on_publish($notificationArray);
				}
				
				$this->model_common->editDataFromTabel('search', $edtitSearchData, $searchProjWhere);
				
				if(!empty($elementTable)){
					$elementEntityid=getMasterTableRecord($elementTable);
						$elementWhere=array($elementField=>$fieldValue);
						$searchWhere=array('entityid'=>$elementEntityid, 'projectid'=>$fieldValue);
						
						if($edtitData[$pulishField]=='t'){ // get elements which can be publish 
							if ( strstr($elementTable, "Element")) {
								//$whereNPE = '"'.$elementField.'" = \''.$fieldValue.'\' AND ("isBlocked"=\'t\' OR ("jobStsatus"!=\'DONE\' AND "isExternal"!=\'t\' AND "fileType"!=\'image\' AND "fileType"!=\'1\' ))';
								
								$wherePE = '"'.$elementField.'" = \''.$fieldValue.'\' AND "isBlocked" !=\'t\' AND ("jobStsatus" =\'DONE\' OR "isExternal"=\'t\' OR "fileType" = \'image\' OR "fileType" = \'1\' )';
								
								$resPE=$this->model_common->getelementsToBePublished($elementTable,$wherePE);
								if($resPE && isset($resPE[0]->elementId)){
									$elementsToBePublished=array();
									foreach($resPE as $PE){
										if($PE->elementId > 0){
											$elementsToBePublished[]=$PE->elementId;
										}
									}
								}
							}
							
							$elementWhere['isBlocked']='f';
							$searchWhere['isblocked']='f';
						}
						
						$res=$this->model_common->editDataFromTabelWhereIn($elementTable, $edtitData, $elementWhere, 'elementId', $elementsToBePublished);
						$this->model_common->editDataFromTabelWhereIn('search', $edtitSearchData, $searchWhere, 'elementid', $elementsToBePublished);
				}
			}
			
			if(!empty($deleteCache)){
				$sectionCache =$deleteCache;
				$this->session->set_userdata($sectionCache,1);
			}
		}
		$returnData=array('ispublished'=>$ispublished,
							'projectId'=>$projectId,
							'elementId'=>$fieldValue,
							'isElement'=>$isElement,
							'elementsToBePublishedId'=>(is_array($elementsToBePublished) && count($elementsToBePublished) >0)?$elementsToBePublished:0
						); 
	
		echo json_encode($returnData);
	}
	
	
	//Check if user is not craved if yes if yes send the notifications
	function send_notification_on_publish($notificationArray=array()){
		
		if(is_array($notificationArray) && count($notificationArray) > 0){
			$params = $notificationArray;
			
			$entityId = $params['entityId'];
			$elementId = $params['elementId'];
			$projectId = (isset($params['projectId']))?$params['projectId']:$params['elementId'];
			$projectType = $params['projectType'];
			$industryId = $params['industryId'];
			$alert_type = (isset($params['alert_type']))?$params['alert_type']:'';
			
			$ownerId = $this->userId; //any user craved the element
			
			$notificationsArray = array('notificationData'=>array('entityId'=>$entityId,
																	  'projectId'=>$projectId,
																	  'elementId'=>$elementId,
																	  'ownerId'=>$ownerId,
																	  'industryId'=>($industryId>0)?$industryId:0,
																	  'alert_type'=>$alert_type,				 
																	  'projectType'=>$projectType)									
								  );
			$countNotification = countResult('NotificationQue',$notificationsArray['notificationData'],'');
					
			if($countNotification<=0){
				$notificationQueId = $this->model_common->addDataIntoTabel('NotificationQue',$notificationsArray['notificationData']);
			}
			
			if(isset($notificationArray['yourReviews']) && is_array($notificationArray['yourReviews']) && count($notificationArray['yourReviews']) > 0){
				$yourReviews=$notificationArray['yourReviews'];
				
				$notificationsArray = array('notificationData'=>array('entityId'=>$yourReviews['entityId'],
																		  'projectId'=>$yourReviews['projectId'],
																		  'elementId'=>$yourReviews['elementId'],
																		  'ownerId'=>$yourReviews['reviewBy'],
																		  'industryId'=>$yourReviews['industryId'],
																		  'alert_type'=>$yourReviews['alert_type'],		 
																		  'projectType'=>$yourReviews['projectType']
																	  )									
									  );
				$countNotification = countResult('NotificationQue',$notificationsArray['notificationData'],'');
						
				if($countNotification<=0){
					$notificationQueId = $this->model_common->addDataIntoTabel('NotificationQue',$notificationsArray['notificationData']);
				}
			}
			
		}
		else{
				return false;
		}
	}
	
	function imageSlider($sliderImages,$uId,$defaultImage,$showDefaultImage=0)
	{
		$show['sliderImages'] = $sliderImages;
		$show['imageUniqueId']=$uId;
		$show['defaultImage']=$defaultImage;
		$show['showDefaultImage']=$showDefaultImage;
		$this->load->view('imageSlider',$show);
	}
	
	//Update Data into Table
	function editDataFromTabel(){
		$data['data']=$this->input->post('val1');
		$data['table']=$this->input->post('val2');
		$data['where']=$this->input->post('val3');
		
		$data['viewPage']=$this->input->post('val4');
		
		$result=$this->model_common->countResult($data['table'],$data['where'],'', 1);
		if($result > 0){
			$this->model_common->editDataFromTabel($data['table'], $data['data'], $data['where']);
		}
		
		if(strlen($data['viewPage']) > 4){
			$this->load->view($data['viewPage'],$data);
		}
	}
	
	function updateMediaFileJobStsatus(){
		$userId = isLoginUser();
		if(is_numeric($userId) && ($userId > 0)){
			$this->model_common->editDataFromTabel('MediaFile', array('jobStsatus'=>'NEW'), array('tdsUid'=>$userId,'jobStsatus'=>'UPLOADING','isExternal'=>'f'));
		}
	}
	
	
	
	///Added by vikas to check isMain while deleting
	
	
	
		public function deleteTabelRowMedia() 
		{
		//echo '<pre />';print_r($this->input->post());die;
		$tbl = trim($this->input->post('val2'));
		$field = trim($this->input->post('val3'));
		$ID = explode(',',$this->input->post('val1'));
		$fileId = trim($this->input->post('val4'));
		$filePath = trim($this->input->post('val5'));
		$isLogSummery = trim($this->input->post('val6'));
		
		$deleteCache = trim($this->input->post('val7'));
		$isMain = trim($this->input->post('val8'));
		$promoFieldId = trim($this->input->post('val9'));
		$promotionMediaTable = trim($this->input->post('val10'));
		$delBrowseId = trim($this->input->post('val12'));
		$reload = trim($this->input->post('val11'));
		
		?>
		<script>
		
		if($('.imgCount').length)		
			$('#addLink').addClass('dn');
		else
			$('#addLink').removeClass('dn');
			$('#addIcon').removeClass('dn');
		</script>
		<?php 
		if($ID[1]>0)
		$promoFieldVal = $ID[1];
		else
		$promoFieldVal ='';
		
		if(!empty($tbl) && !empty($field) && (count($ID) > 0)){
			
			$this->model_common->deleteRowFromTabel($tbl, $field, $fileId);
		
			if($fileId > 0){
				
				$res=$this->model_common->getDataFromTabel('MediaFile','fileName,filePath',array('fileId'=>$fileId),'','','',1);
				if(isset($res[0]->fileName)){
					$fileDir=trim($res[0]->filePath);
					$fileName=trim($res[0]->fileName);
					if(is_dir($fileDir) && $fileName !=''){
						$fpLen=strlen($fileDir);
						if($fpLen > 0 && substr($fileDir,-1) != DIRECTORY_SEPARATOR){
							$fileDir=$fileDir.DIRECTORY_SEPARATOR;
						}
						findFileNDelete($fileDir,$fileName);
					}
					$file=$fileDir.$fileName;
				}
				$this->model_common->deleteRowFromTabel('MediaFile','fileId',$fileId);
			}			
			//Deleting the image from folder
			if(!empty($filePath) && is_file($filePath)){
				@unlink($filePath);
			
				 $thumbImgversion_b = addThumbFolder(@$filePath,'_b');
				 if(!empty($thumbImgversion_b) && is_file($thumbImgversion_b)) @unlink($thumbImgversion_b);
				 
				 $thumbImgversion_l = addThumbFolder(@$filePath,'_l');
				 if(!empty($thumbImgversion_l) && is_file($thumbImgversion_l)) @unlink($thumbImgversion_l);
				
				 $thumbImgversion_m = addThumbFolder(@$filePath,'_m'); 
				 if(!empty($thumbImgversion_m) && is_file($thumbImgversion_m)) @unlink($thumbImgversion_m);
				 
				 $thumbImgversion_s = addThumbFolder(@$filePath,'_s');
				 if(!empty($thumbImgversion_s) && is_file($thumbImgversion_s)) @unlink($thumbImgversion_s);
				 
				 $thumbImgversion_xs = addThumbFolder(@$filePath,'_xs');
				 if(!empty($thumbImgversion_xs) && is_file($thumbImgversion_xs)) @unlink($thumbImgversion_xs);
				 
				 $thumbImgversion_xxs = addThumbFolder(@$filePath,'_xxs');
				 if(!empty($thumbImgversion_xxs) && is_file($thumbImgversion_xxs)) @unlink($thumbImgversion_xxs);
			
			}
			
			if($isLogSummery > 0){
				$entityId = getMasterTableRecord($tbl);
				$elementId = $ID[0];
				if($entityId > 0 && $elementId>0){
					$field = array(
						'entityId'=>$entityId,
						'elementId'=>$elementId
					);
					$this->model_common->deleteRowFromTabel('LogSummary',$field);
				}
			}
			
			if($isMain=='t')
			{	
			$where=array($promoFieldId=>$promoFieldVal,'mediaType'=>'1');
			
			$dataTable=$this->model_common->getDataFromTabel($promotionMediaTable,'',$where,'','','',1);
			//echo $this->db->last_query();
			//print_r($dataTable);
			if(is_array($dataTable))
			{
				$medId=$dataTable[0]->mediaId;
				$fId=$dataTable[0]->fileId;
				$this->model_common->changePromotionMediaStatus($promotionMediaTable,$medId,'fileId',$fId);				
			}
						
			?>
			<script>				
				$('#makeFeatureImg<?php echo $medId;?>').addClass('dn');
				$('#imgIsMain<?php echo $medId;?>').val('t');				
			</script>
			<?php
			}
		
			if(!empty($deleteCache)){
				$sectionCache =$deleteCache;
				$this->session->set_userdata($sectionCache,1);
			}
		} 
		
		if(isset($delBrowseId) && $delBrowseId=='promo'){
		$promoImgDeleted = $this->lang->language['promoImgDeleted'];
		set_global_messages($promoImgDeleted, 'error');
	}
		//$this->load->view('mediatheme/'.$delBrowseId.'MediaList.php');
	}
	
	
	//To create thumb nail for uploading images on completing the upload process using jquery upload
	//Called by uploadMediaFiles(common.js)
	public function createthumbimages()
	{		
		ini_set('memory_limit', '-1');
		$thumbFolder = $this->config->item('imgThumbVersionFolder');
		
		$targetDir = $this->input->post('val1');
		$filePath=str_replace('+',DIRECTORY_SEPARATOR,$targetDir);
		
		$fpLen=strlen($filePath);
		if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
			$filePath=$filePath.DIRECTORY_SEPARATOR;
		}
		
		$fileName = $this->input->post('val2');
		
		$filePathName = $filePath.$fileName;
		
		if(is_file($filePathName)){
			
			$createWaterMarkFlag = $this->input->post('val3');
			
			if($createWaterMarkFlag != 1){
				$createWaterMarkFlag = 0;
			}
		
            $thumb_config = $this->config->item('thumb_config');
            
			if(!@empty($filePath) && (@is_dir($filePath)))
			{
				$imgThumbFolder = $filePath.$thumbFolder;
				$orignalImagPath = $filePath;
				
				$cmdimgFolderPath = 'chmod -R 777 '.$orignalImagPath;
				exec($cmdimgFolderPath);
				
				$imagePath = $orignalImagPath.$fileName;
				if(!empty($thumb_config) && is_array($thumb_config)){
                    foreach($thumb_config  as $key=>$config){
                        $thumbConfig = array('filename'=>$fileName,'width'=>$config['width'],'height'=>$config['height'],'suffix'=>$config['suffix']);
                        createMultiThumb($thumbConfig,$orignalImagPath,$imgThumbFolder,$createWaterMarkFlag);
                    }
                }
			}
		}
	}
	
	public function createthumb(){
		ini_set('memory_limit', '-1');
		
		$imageData = $this->model_common->getDataFromTabel('MediaFile','filePath,fileName','fileType','1');
        if(!empty($imageData)){
            $thumb_config = $this->config->item('thumb_config');
            
            foreach($imageData as $imgcount =>$imgDetail)
            {	
                $imgDetail = object2array($imgDetail);
                
                $orgNameDetail = $imgDetail['filePath'].$imgDetail['fileName'];
                if(!@empty($orgNameDetail) && (@is_file($orgNameDetail)))
                {				
                    $thumbFolder = $this->config->item('imgThumbVersionFolder');	
                    $img = $orgNameDetail;
                    $break=explode('/', $img);
                    $pfile = $break[count($break) - 1];
                    $lf=explode('/'.$pfile, $img);
                    
                    $orignalImagPath = $lf[0].DIRECTORY_SEPARATOR;
                    
                    $cmdimgFolderPath = 'chmod -R 777 '.$orignalImagPath;
                    
                    exec($cmdimgFolderPath);
                    $imgThumbFolder = $orignalImagPath.$thumbFolder;
                    $imageName = end(explode('/',$img));
                    
                    if(!empty($thumb_config) && is_array($thumb_config)){
                        foreach($thumb_config  as $key=>$config){
                            $thumbConfig = array('filename'=>$fileName,'width'=>$config['width'],'height'=>$config['height'],'suffix'=>$config['suffix']);
                            createMultiThumb($thumbConfig,$orignalImagPath,$imgThumbFolder);
                        }
                    }
                }
            }
        }
}

  /**
   *  Function to save suggestions to admin
   * 
   * 
  **/
  function saveSuggestions()
	{		
			$data['subject'] = $this->input->post('subject');
			$data['suggestion_for'] = $this->input->post('currentUrl');
			$data['suggestion'] = $this->input->post('body');
			$data['sender_id'] = $this->userId;			
			
			$this->model_common->insertPromoMedia($data,'TDS_Suggestions');								
			
			if($this->input->post("ajaxHit")){					
				echo 1;
			}	
						
			/*****************suggesation email to toadsquare start**************/
						
				$getUserShowcase	= showCaseUserDetails($data['sender_id']);
				$username =  $getUserShowcase['userFullName'];
				$this->load->library('email');
				$this->email->from($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
				$this->email->reply_to($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
				$this->email->to($this->config->item('suggestions_email', ''));
				//$this->email->to('lokendrameena@cdnsol.com');	
				$this->email->subject(sprintf('Suggestion ', $this->config->item('website_name', '')));
				$where=array('purpose'=>'suggestion','active'=>1);
				$reportTemplateRes=getDataFromTabel('EmailTemplates','templates',  $where, '','', '', 1 );
				
				$reportTemplate=$reportTemplateRes[0]->templates;
				$searchArray = array("{suggestion_description}", "{user_name}");
				$replaceArray = array($data['suggestion'], $username);
				$abusiveReportTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
				$this->email->message($abusiveReportTemplate);
				$this->email->send();
				
			/*****************suggesation email to toadsquare end**************/					
		
	}
	
	function getDisplayPrice()
	{
		$price=$this->input->post('val1');
		$currency=$this->input->post('val2');
		$PriceDetails=getDisplayPrice($price,$currency);
		echo json_encode($PriceDetails);
	}
	
	function showDownloadButton($buttonProperty=array('price'=>0,'showFlag'=>'f','seller_currency'=>'','buttonClass'=>'ma','buttonStyle'=>'big'))
	{
		
		$flagArray = array('showFlag'=>$buttonProperty['showFlag']);
		
		//if any of condition is false then donot show the button
		$whetherToshowButton = in_array('f',$flagArray);
		
		if($whetherToshowButton ==0) {$buttonView['view'] = $this->load->view('show_download_button',$buttonProperty,true); return $buttonView;}
		else return '';
			
	}
		
	function showPPVButton($buttonProperty=array('price'=>0,'showFlag'=>'f','seller_currency'=>'','buttonClass'=>'ma','buttonStyle'=>'big'))
	{
		
		$flagArray = array('showFlag'=>$buttonProperty['showFlag']);
		
		//if any of condition is false then donot show the button
		$whetherToshowButton = in_array('f',$flagArray);
		
		if($whetherToshowButton ==0) {$buttonView['view'] = $this->load->view('show_ppv_button',$buttonProperty,true); return $buttonView;}
		else return '';
			
	}
    
    
		
	function showPriceButton($buttonProperty=array('price'=>0,'priceFlag'=>'f','quantity'=>0,'elementId'=>0,'entityId'=>0,'shippingFlag'=>'f','qunatityFlag'=>'f','seller_currency'=>'','buttonClass'=>'ma','buttonStyle'=>'big','fileType'=>'xyz','mediaId'=>'','mediaElementId'=>'','entityId'=>'','pieceTextClass'=>''))
	{
		
		$flagArray = array('priceFlag'=>$buttonProperty['priceFlag']);
		
		if($buttonProperty['shippingFlag']=='t') {
			
			//If shipping value exists for the current elementId 			
			$shippingCount = countResult($this->tblShipping,array('elementId'=>$buttonProperty['elementId'],'entityId'=>$buttonProperty['entityId'],'status'=>'t'),1);
			
			//if shippingCount>0 thsn show the button by having shippingFlag=t else  shippingFlag=f
			if($shippingCount>0) $flagArray = array_merge($flagArray,array('shippingFlag'=>'t'));
			else $flagArray = array_merge($flagArray,array('shippingFlag'=>'f'));
		}
		
		if($buttonProperty['qunatityFlag']=='t') $flagArray = array_merge($flagArray,array('qunatityFlag'=>'t'));
		//else $flagArray = array_merge($flagArray,array('qunatityFlag'=>''));
		//echo '<pre />';print_r($flagArray);
		//if any of condition is false then donot show the button
		$whetherToshowButton = in_array('f',$flagArray);
		
		
		if($whetherToshowButton ==0) {$buttonView['productButtonPresent'] = 1; $buttonView['view'] = $this->load->view('show_price_button',$buttonProperty,true); return $buttonView;}
		else return '';
			
	}	
	
	
	/*
	 * @access public
	 * @use This function is used to show swf files
	 * @paramter hint  mediaID/entityID/projectID/elementID
	 * @return 
	 * 
	 */ 
	
	public function swfVideo() 
	{			
		$tableName = getMasterTableName($this->input->get('val2'));
		
		$mediaTableName= $tableName[0];
		
		$getEmElementData= $this->model_common->getDataFromTabelWhereIn($mediaTableName, 'title, description, imagePath',  $whereField='elementId', $this->input->get('val4'), 'elementId', 'ASC', '');
		
		$Medias['mediaId'] = $this->input->get('val1');
		
		$Medias['entityID'] = $this->input->get('val2');
		
		$Medias['projectID'] = $this->input->get('val3');
		
		$Medias['elementID'] = $this->input->get('val4');
				
		
		//**********This code for getting article of news and reivew section start**********//
		
		if($Medias['entityID']=="94" || $Medias['entityID']=="95")
		{
		
			$tableName = getMasterTableName($Medias['entityID']);
								
			$articleTableName= $tableName[0];
		
			$getType = $this->model_common->getDataFromTabelWhereIn($articleTableName, $field='article',  $whereField='elementId', $whereValue=$Medias['elementID'], $orderBy='elementId', $order='ASC', $whereNotIn=0);
		
			if(isset($getType) && $getType!="")
			{
				$Medias['article'] = $getType[0]['article'];
			}else
			{
				$Medias['article'] = "";
			}
		}else
		{
			$Medias['article'] = "";
		}
		
		//**********This code for getting article of news and reivew section end**********//	
		
		$Medias['title'] = $getEmElementData[0]['title'];
		
		$Medias['description'] = $getEmElementData[0]['description'];
		
		if($Medias['entityID'] == 7)
		{
			$imagetype = $this->config->item('educationMaterialImage_xxs');
		}
		
		if($Medias['entityID'] == 84)
		{
			$imagetype = $this->config->item('writingNpublishingImage_xxs');
		}
		
		if($Medias['entityID'] == 94)
		{
			$imagetype = $this->config->item('defaultNewsImg_xxs');
		}
		
		if($Medias['entityID'] == 95)
		{
			$imagetype = $this->config->item('defaultReviewsImg_xxs');
		}
		
		$thumbImage = addThumbFolder($getEmElementData[0]['imagePath'],'_xxs','thumb',$imagetype);
		$projectImage = getImage($thumbImage,$imagetype,1);
		
		$Medias['imagePath'] = $projectImage;
		
		$this->load->view('swf_popup',$Medias);//load template with w
			
	}
	
	
	
	/*
	 * @access public
	 * @user this function is used to play video 
	 * @paramter hint  mediaId/entityId/projectId/elementId 
	 * @return player code
	 * 
	 */ 
	
	public function playCommonVideo() 
	{	
		
		$Medias['mediaId'] = $this->input->get('val1');
		
		$Medias['entityID'] = $this->input->get('val2');
		
		$Medias['projectID']=$this->input->get('val3');
		
		$Medias['elementID']=$this->input->get('val4');
		
		$Medias['loginUserID']=isLoginUser();
		
		/*************Here check exnternal video display code**************/ 
		$tableName = getMasterTableName('42');
		
		$mediaTableName= $tableName[0];
				 
		//get media file type 
		$getType = $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType,isExternal,filePath',  $whereField='fileId', $whereValue=$Medias['mediaId'], $orderBy='fileId', $order='ASC', $whereNotIn=0);
		
		//Array ( [0] => Array ( [fileType] => 2 [isExternal] => t [filePath] => http://youtu.be/fD0tiq5Z0AI ) ) 
		
		$Medias['isExternal']=$getType[0]['isExternal'];
		
		if($getType[0]['isExternal']=="t")
		{
			//this section is for external video
		
			$getMediaUrlData = getMediaUrl($getType[0]['filePath']);
		
			if($getMediaUrlData['isUrl'])
			{
				$Medias['embedType'] = 'iframe';
				$headerDetails = @get_headers($getType[0]['filePath'],1);
				
				if(isset($headerDetails['X-Frame-Options']))
				{
					// This code will show error 
					$src = base_url().'en/player/videoError/';

				}else
				{
					// This code will play url 
					$src = $getType[0]['filePath'];

				}
				
				$Medias['src'] = $src;
				
				$Medias['isValidUrl'] = 'yes';  
				$this->load->view('play_common_video',$Medias);	
				
			}else
			{
		
				$Medias['src'] = $getMediaUrlData['getsource'];
				//Check emebed code type iframe or not iframe
				if($getMediaUrlData['embedtype'] == 'iframe')
				{
					
					$Medias['embedType'] = 'iframe';
					
				
					//$Medias['src'] = getUrl($getType[0]['filePath']);
					
					if(!filter_var($Medias['src'], FILTER_VALIDATE_URL))
					  {
						 //URL is not valid 
						 $Medias['isValidUrl'] = 'no';
					  }else
					  {
						//URL is valid
						$Medias['isValidUrl'] = 'yes';  
						$this->load->view('play_common_video',$Medias);//this view for internal video
					  }
			
				}else
				{
					$Medias['embedType'] = 'embed';
					
					$this->load->view('play_common_video',$Medias);//this view for internal video
				}
			
			}
		
			  
		}else
		{
			$this->load->view('play_common_video',$Medias);//this view for internal video
		}
		
	}
	
	
	
	/*
	 * @access public
	 * @user this function is used to play audio 
	 * @paramter  mediaId/entityId/projectId/elementId 
	 * @return player code
	 */ 
	
	public function playCommonAudio() 
	{	
		
		$Medias['mediaId'] = $this->input->get('val1');
		$Medias['entityID'] = $this->input->get('val2');
		$Medias['projectID']=$this->input->get('val3');
		$Medias['elementID']=$this->input->get('val4');
		//$Medias['loginUserID']=isLoginUser(); 
		
		
		/*************Here check exnternal video display code**************/ 
		$tableName = getMasterTableName('42');
		
		$mediaTableName= $tableName[0];
				 
		//get media file type 
		$getType = $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType,isExternal,filePath',  $whereField='fileId', $whereValue=$Medias['mediaId'], $orderBy='fileId', $order='ASC', $whereNotIn=0);
		
		//Array ( [0] => Array ( [fileType] => 2 [isExternal] => t [filePath] => http://youtu.be/fD0tiq5Z0AI ) ) 
		
		$Medias['isExternal']=$getType[0]['isExternal'];
		
		if($getType[0]['isExternal']=="t")
		{
			//this section is for external audio
			$getMediaUrlData = getMediaUrl($getType[0]['filePath']);
		
			$Medias['src'] = $getMediaUrlData['getsource'];
			//Check emebed code type iframe or not iframe
			if($getMediaUrlData['embedtype'] == 'iframe')
			{
				$Medias['embedType'] = 'iframe';
				
				  if(!filter_var($Medias['src'], FILTER_VALIDATE_URL))
				  {
					 //URL is not valid 
					 $Medias['isValidUrl'] = 'no';
					 
				  }else
				  {
					//URL is valid
					$Medias['isValidUrl'] = 'yes';  
					$this->load->view('play_common_audio',$Medias);//this view for internal video
				  }
				
			}else
			{
				$Medias['embedType'] = 'embed';
				$this->load->view('play_common_audio',$Medias);
			}
			
		}else
		{
			$this->load->view('play_common_audio',$Medias);//this view for internal video
		}
		
		//$this->load->view('play_common_audio',$Medias);//load template with w
	}
	
	/*
	 * @access public
	 * @user this function is used to play audio 
	 * @paramter  mediaId/entityId/projectId/elementId 
	 * @return player code
	 */ 
	
	public function playCommonSwf() 
	{	
		$Medias['mediaId'] = $this->input->get('val1');
		$Medias['entityID'] = $this->input->get('val2');
		$Medias['projectID']=$this->input->get('val3');
		$Medias['elementID']=$this->input->get('val4');
		//$Medias['loginUserID']=isLoginUser(); 
		$this->load->view('play_common_swf',$Medias);//load template with w
	}


	
	
	/*
	 * @access public
	 * @user this function is used to play video 
	 * @paramter hint  mediaId/entityId/projectId/elementId 
	 * @return player code
	 * 
	 */ 
	
	public function openCommonImage() 
	{	
		
		$Medias['mediaId'] = $this->input->get('val1');
		
		$Medias['entityID'] = $this->input->get('val2');
		
		$Medias['projectID']=$this->input->get('val3');
		
		$Medias['elementID']=$this->input->get('val4');
		
		//$Medias['loginUserID']=isLoginUser();
		
		/*************Here check exnternal video display code**************/ 
		$tableName = getMasterTableName('42');
		
		$mediaTableName= $tableName[0];
				 
		//get media file type 
		$getType = $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType,fileName,isExternal,filePath',  $whereField='fileId', $whereValue=$Medias['mediaId'], $orderBy='fileId', $order='ASC', $whereNotIn=0);
		
		//Array ( [0] => Array ( [fileType] => 2 [isExternal] => t [filePath] => http://youtu.be/fD0tiq5Z0AI ) ) 
		
		$Medias['isExternal']=$getType[0]['isExternal'];
		
		
		if($getType[0]['isExternal']=="t")
		{
			//this section is for external video
		
			$getMediaUrlData = getMediaImageUrl($getType[0]['filePath']);
			
			$Medias['src'] = $getMediaUrlData['getsource'];
			
			//Check emebed code type iframe or not iframe
			if($getMediaUrlData['embedtype'] == 'iframe')
			{
				
				$Medias['embedType'] = 'iframe';
				
			
				//$Medias['src'] = getUrl($getType[0]['filePath']);
				
				if(!filter_var($Medias['src'], FILTER_VALIDATE_URL))
				  {
					 //URL is not valid 
					 $Medias['isValidUrl'] = 'no';
				  }else
				  {
					//URL is valid
					$Medias['isValidUrl'] = 'yes';  
					$this->load->view('play_common_video',$Medias);//this view for internal video
				  }
		
			}else
			{
				if($getMediaUrlData['embedtype'] == 'embed')
				{
				
					$Medias['embedType'] = 'embed';
				
					$this->load->view('play_common_video',$Medias);//this view for internal video
				}else
				{
					if($getMediaUrlData['embedtype'] == 'image')
					{
						$Medias['imageName'] = $Medias['src'] ;
						$this->load->view('open_common_image',$Medias);
					}else
					{
						$imagesThumbImage ='';
						$Medias['imageName'] = getImage($imagesThumbImage,$this->config->item('defaultNoMediaImg'));
						$this->load->view('open_common_image',$Medias);
					}	
				}
			}
		
		}
		else
		{
			$imagesFileName = $getType[0]['fileName'];
			$imagesFilePath = $getType[0]['filePath'];
			$imagesThumbImage = addThumbFolder($imagesFilePath.DIRECTORY_SEPARATOR.$imagesFileName,'_l');
			$Medias['imageName'] = getImage($imagesThumbImage,$this->config->item('defaultNoMediaImg'));
			$this->load->view('open_common_image',$Medias);//this view for internal video
		}
	}
	
	
	
	/*
	 * @access public
	 * @user this function is used to play embed audio and video files 
	 * @paramter  mediaId/entityId/projectId/elementId 
	 * @return player code
	 */ 
	
	/*public function playCommonEmbed($mediaId) 
	{	
		
		$Medias['mediaId'] = $mediaId;
		
		$tableName = getMasterTableName('42');
		
		$mediaTableName= $tableName[0];
				 
		//get media file type 
		$getType = $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType,isExternal,filePath',  $whereField='fileId', $whereValue=$Medias['mediaId'], $orderBy='fileId', $order='ASC', $whereNotIn=0);
		
		$Medias['src'] = $getType[0]['filePath'];
			
		$this->load->view('play_common_embed_song',$Medias);
			
	}*/

	
	public function getStateList() {
		$lang=lang();
		$countryId=$this->input->post('val1');
		$fieldName=$this->input->post('val2');
		
		$class = $this->input->post('val3');
		$stateId = $this->input->post('val4');
		
		$showClass = ($class!='') ? $class : 'l12';
		$stateId = (is_numeric($stateId) && ($stateId > 0) )?$stateId:0;
		
		$stateList =getStatesList($countryId,true);
		$html=form_dropdown($fieldName, $stateList, $stateId,'class="'.$showClass.'" ');
		$html.=" <script>$('SELECT').selectBox(); </script>";
		echo $html;
	}

	/*Function to load how to publish views */	
	public function howToPublish()
	{
		$data['industryType'] = $this->input->get('val1');
		if(isset($data['industryType']) && !empty($data['industryType'])){
			$this->load->view('howToPublish/'.$data['industryType'].'HowToPublish', $data) ;
		}				
	}  
	
	/*
	 *  Function to download event badges
	 */ 
	function download_event_badges()
	{
		 $filePath = 'images/event_badges/';
		 $fileName = 'Toadsquare Badges.pdf';
		 $file_path = $filePath.$fileName;
		 if(is_file($filePath.$fileName)){
				header('Content-type: application/pdf');
				header('Content-Disposition: attachment; filename="'.$fileName.'"');
				readfile($filePath.$fileName);
				return true;
			}else{
				return false;
			}
	}
	
	/* Verifing the paypal information from global setting */
	function checkPaypalaccount(){
		isLoginUser();	
		$paypalEmail = $this->input->post('val1');
		$paypalStreet = $this->input->post('val2');
		$paypalZip = $this->input->post('val3');
		$this->config->load('paypal');
		
		$config = array(
			'Sandbox' => $this->config->item('Sandbox'), 			// Sandbox / testing mode option.
			'APIUsername' => $this->config->item('APIUsernameCustom'), 	// PayPal API username of the API caller
			'APIPassword' => $this->config->item('APIPasswordCustom'), 	// PayPal API password of the API caller
			'APISignature' => $this->config->item('APISignatureCustom'), 	// PayPal API signature of the API caller
			'APISubject' => '', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
			'APIVersion' => $this->config->item('APIVersionCustom'), 		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
			'DeviceID' => $this->config->item('DeviceID'), 
			'ApplicationID' => $this->config->item('ApplicationID'), 
			'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
		);
		
		
		//$this->load->library('paypal/Paypal_pro', $config); 
		
		require_once(APPPATH.'libraries/paypal/Paypal_pro.php'); 
		
		$PayPal = new Paypal_pro($config);			
	
		$DataArray['AVFields']=array('EMAIL'=>$paypalEmail,'STREET'=>$paypalStreet,'ZIP'=>$paypalZip);
		$data['paypal']=$PayPal->AddressVerify($DataArray);
	
		if(!isset($data['paypal']['ACK'])){
			$data['paypal']['ACK']='Error';
		}
		
		if(!isset($data['paypal']['CONFIRMATIONCODE'])){
			$data['paypal']['CONFIRMATIONCODE']='Unconfirmed';
		}
		if($data['paypal']['ACK'] == 'Success' && $data['paypal']['CONFIRMATIONCODE'] == 'Confirmed') echo json_encode($data['paypal']);
		else {if($data['paypal']['ACK']!='Error') $data['paypal']['ACK']='Failure'; echo json_encode($data['paypal']);}
		
	}
		//Display tmail listing
	function tmail_listings()
	{
		//$this->template->load('template','login_form', $data);
		$this->load->view('tmail_listing') ;		
	}
	
	function set_userdata()
	{
		$var = $this->input->post('val1');
		$value = $this->input->post('val2');
		set_userdata($var, $value);
	}
	
	function downloadFile($fileId=0){ 
		$fileId = decode($fileId);
		$matreial=$this->model_common->getDataFromTabel('MediaFile','fileName,filePath,rawFileName',  'fileId', $fileId, '', 'ASC', 1, $offset=0, true );
		$matreial = $matreial[0];
		$fileDescription=encode($matreial['filePath'].'+'.$matreial['fileName'].'+'.$matreial['rawFileName']);
		$FD =  decode($fileDescription);
		$FD = explode('+',$FD);
		if(is_array($FD) && count($FD) >=1){
			$filePath=trim($FD[0]);
			$fileName=trim($FD[1]);
			$dwnFileName=isset($FD[2])?trim($FD[2]):$fileName;
			$file=$filePath.$fileName;
			if(is_file($file)){
				if($dwnFileName==''){
					$dwnFileName=$fileName;
				}
				$fsize = filesize($file);
				$fileInfo=pathinfo($file);
				$extension=$fileInfo['extension'];
				$extension = strtolower($extension);
				switch($extension) {
					case "pdf":
					$ctype = "application/pdf";
					break;
					case "exe":
					$ctype = "application/octet-stream";
					break;
					case "zip":
					$ctype = "application/zip";
					break;
					case "doc":
					$ctype = "application/msword";
					break;
					case "xls":
					$ctype = "application/vnd.ms-excel";
					break;
					case "ppt":
					$ctype = "application/vnd.ms-powerpoint";
					break;
					case "gif":
					$ctype = "image/gif";
					break;
					case "png":
					$ctype = "image/png";
					break;
					case "jpeg":
					$ctype = "image/jpg";
					break;
					case "jpg":
					$ctype = "image/jpg";
					break;
					case "mp3":
					$ctype = "audio/mp3";
					break;
					case "wav":
					$ctype = "audio/x-wav";
					break;
					case "wma":
					$ctype = "audio/x-wav";
					break;
					case "mpeg":
					$ctype = "video/mpeg";
					break;
					case "mpg":
					$ctype = "video/mpeg";
					break;
					case "mpe":
					$ctype = "video/mpeg";
					break;
					case "mov":
					$ctype = "video/quicktime";
					break;
					case "avi":
					$ctype = "video/x-msvideo";
					break;
					case "src":
					$ctype = "plain/text";
					break;
					default:
					$ctype = "application/force-download";
					break;
				}
				header('Content-Description: File Transfer');
				header('Content-Type: "'.$ctype.'"');
				header('Content-Disposition: attachment; filename="'.basename($dwnFileName).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header("Content-Transfer-Encoding: binary");
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header("Content-Length: ".$fsize);
				ob_clean();
				flush();
				readfile(trim($file));
				exit;
				
			}else{
				echo "file not found";
			}
		}
	}
	
	function downloadFileFrmOrigPath($path=0){ 
	
		$path = decode($path);
		$fileDescription=str_replace('+','/',$path);
		$fileDescriptionInfo=pathinfo($fileDescription);
		$fileDescription=encode($fileDescription.'+4rrrffff+'.$fileDescriptionInfo['basename']);
		$FD =  decode($fileDescription);		
		$FD = explode('+',$FD);
		//echo '<pre />';print_r($fileDescriptionInfo);die;
		if(is_array($FD) && count($FD) >=1){
			$filePath=trim($FD[0]);
			$fileName=trim($FD[1]);
			$dwnFileName=isset($FD[2])?trim($FD[2]):$fileName;
			$file=$filePath;
			if(is_file($file)){
				if($dwnFileName==''){
					$dwnFileName=$fileName;
				}
				$fsize = filesize($file);
				$fileInfo=pathinfo($file);
				$extension=$fileInfo['extension'];
				$extension = strtolower($extension);
				switch($extension) {
					case "pdf":
					$ctype = "application/pdf";
					break;
					case "exe":
					$ctype = "application/octet-stream";
					break;
					case "zip":
					$ctype = "application/zip";
					break;
					case "doc":
					$ctype = "application/msword";
					break;
					case "xls":
					$ctype = "application/vnd.ms-excel";
					break;
					case "ppt":
					$ctype = "application/vnd.ms-powerpoint";
					break;
					case "gif":
					$ctype = "image/gif";
					break;
					case "png":
					$ctype = "image/png";
					break;
					case "jpeg":
					$ctype = "image/jpg";
					break;
					case "jpg":
					$ctype = "image/jpg";
					break;
					case "mp3":
					$ctype = "audio/mp3";
					break;
					case "wav":
					$ctype = "audio/x-wav";
					break;
					case "wma":
					$ctype = "audio/x-wav";
					break;
					case "mpeg":
					$ctype = "video/mpeg";
					break;
					case "mpg":
					$ctype = "video/mpeg";
					break;
					case "mpe":
					$ctype = "video/mpeg";
					break;
					case "mov":
					$ctype = "video/quicktime";
					break;
					case "avi":
					$ctype = "video/x-msvideo";
					break;
					case "src":
					$ctype = "plain/text";
					break;
					default:
					$ctype = "application/force-download";
					break;
				}
				header('Content-Description: File Transfer');
				header('Content-Type: "'.$ctype.'"');
				header('Content-Disposition: attachment; filename="'.basename($dwnFileName).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header("Content-Transfer-Encoding: binary");
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header("Content-Length: ".$fsize);
				ob_clean();
				flush();
				readfile(trim($file));
				exit;
				
			}else{
				echo "file not found";
			}
		}
	}
	
	/*
	 ************************************ 
	 * This function is used to show alert to user for unread tmail
	 *********************************** 
	 */ 
	
	function getUserTmail($getCount='')
	{
		$getUserId= isLoginUser();
		$countInbox = $this->model_tmail->get_user_unread_tmail($getUserId);
		if($getCount=="")
		{
			$data['unread_tmail'] = $countInbox;
			$this->load->view('userTmailShow', $data);
		}else
		{
			return $countInbox;
		}
	}
	
	
	/* Verifing the paypal information from global setting method part of adaptive payment */
	function verifyPaypalaccount(){
		isLoginUser();	
		//$paypalEmail = 'saul.rudnick@optusnet.com.au';
	   // $paypalFirstName = 'Saul';
		//$paypalLastName = 'rudnick';
		
		$paypalEmail = $this->input->post('val1');
		$paypalFirstName = $this->input->post('val2');
		$paypalLastName = $this->input->post('val3');
		
		$this->config->load('paypal_pro');		
		$config = array(
			'Sandbox' => $this->config->item('Sandbox'), 			// Sandbox / testing mode option.
			'APIUsername' => $this->config->item('APIUsername'), 	// PayPal API username of the API caller
			'APIPassword' => $this->config->item('APIPassword'), 	// PayPal API password of the API caller
			'APISignature' => $this->config->item('APISignature'), 	// PayPal API signature of the API caller
			'APISubject' => '', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
			'APIVersion' => $this->config->item('APIVersion'), 		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
			'DeviceID' => $this->config->item('DeviceID'), 
			'ApplicationID' => $this->config->item('ApplicationID'), 
			'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
		);
				
		require_once(APPPATH.'libraries/paypal/Paypal_adaptive.php'); 
		
		$PayPal = new PayPal_Adaptive($config);	
		
		$GetVerifiedStatusFields = array(
										'EmailAddress' =>$paypalEmail, 					// Required.  The email address of the PayPal account holder.
										'FirstName' => $paypalFirstName, 						// The first name of the PayPal account holder.  Required if MatchCriteria is NAME
										'LastName' => $paypalLastName , 						// The last name of the PayPal account holder.  Required if MatchCriteria is NAME
										'MatchCriteria' => 'NAME'					// Required.  The criteria must be matched in addition to EmailAddress.  Currently, only NAME is supported.  Values:  NAME, NONE   To use NONE you have to be granted advanced permissions
										);
		
		$PayPalRequestData = array('GetVerifiedStatusFields' => $GetVerifiedStatusFields);

		$data['paypal'] = $PayPal->GetVerifiedStatus($PayPalRequestData);		
			
		if(!isset($data['paypal']['Ack'])){
			$data['paypal']['ACK']='Error';
		}
		
		if(!isset($data['paypal']['AccountStatus']) || ($data['paypal']['AccountStatus']=='') ){
			$data['paypal']['CONFIRMATIONCODE']='UNVERIFIED';
		}
						
		if($data['paypal']['Ack'] == 'Success' && $data['paypal']['AccountStatus'] == 'VERIFIED') echo json_encode($data['paypal']);
		else {if($data['paypal']['Ack']!='Error') $data['paypal']['Ack']='Failure'; echo json_encode($data['paypal']);}
			
		
	}
	
	
	/********************* Methods to write cache files start**********************/
	
	/*
	 * Write cache files for users
	 */
	function writeUsersCacheFiles($userId=0){
		
		//Get users listing
		$getUserDetails = $this->model_common->getDataFromTabel('UserAuth', 'tdsUid',  'active', 1, '', 'ASC', 0, 0, true);
		
		//Make array for diffrent sections
		$sections = array('filmNvideo','musicNaudio','photographyNart','writingNpublishing','educationMaterial','news','reviews','work','product','blog','post','upcoming','showcase','workprofile','event','launch');
		
		//Create cache files for user ,if userId null then for all active users
		if(isset($userId) && !empty($userId)){
			for($i=0;$i<count($sections);$i++){
					//Call methode to write cache files
					$this->globalWriteCacheFile($userId,$sections[$i],0);
				}
		}else{
			for($i=0;$i<count($getUserDetails);$i++){
				for($j=0;$j<count($sections);$j++){
					//Call methode to write cache files
					$this->globalWriteCacheFile($getUserDetails[$i]['tdsUid'],$sections[$j],0);
				}
			}
		}
	}
	
	/*
	 * Write cache file according to sections
	 */
	 
	function globalWriteCacheFile($userId=0,$section='',$projectId=0){
	
		//Call method to write cache files based on section
		switch($section){
			case 'filmNvideo':
			case 'musicNaudio':
			case 'photographyNart':
			case 'writingNpublishing':
			case 'educationMaterial':
			case 'news':
			case 'reviews':
				$this->mediaWriteCacheFile($userId,$section,$projectId);
			break;
			
			case 'work':
				$this->workWriteCacheFile($userId,$projectId);
			break;
			
			case 'product':
				$this->productWriteCacheFile($userId,$projectId);
			break;
			
			case 'blog':
			case 'post':
				$this->blogWriteCacheFile($userId,$section,$projectId);
			break;
			
			case 'upcoming':
				$this->upcomingWriteCacheFile($userId,$projectId);
			break;
			
			case 'showcase':
				$this->showcaseWriteCacheFile($userId,$projectId);
			break;
			
			case 'workprofile':
				$this->workprofileWriteCacheFile($userId,$projectId);
			break;
			
			case 'event':
				$this->eventWriteCacheFile($userId,$projectId);
			break;
			
			case 'launch':
				$this->launchWriteCacheFile($userId,$projectId);
			break;
			
			case 'competition':
				$this->writeCompetitionCacheFile($userId,$projectId);
			break;
			
			case 'competitionentry':
				$this->writeCompetitionEntryCacheFile($userId,$projectId);
			break;
			
			
			default:
				return false;
		}
	}
	
	/*
	 * Write cache file for media
	 */	
	function mediaWriteCacheFile($userId=0,$industryType,$projectId=0){
		$this->load->model('media/model_media');
		//set directory path
		$dirCachePath = 'cache/media/'; 
		if(!is_dir($dirCachePath)){
			@mkdir($dirCachePath, 777, true);
		}
		$cmd3 = 'chmod -R 777 '.$dirCachePath;
		exec($cmd3);
		
		//Get Media project data
		if($userId>0 && !empty($industryType)){
			$getUserName = $this->model_common->getDataFromTabel('UserAuth', 'username',  'tdsUid', $userId, '', 'ASC', 0, 0, true);
			$dirUploadMedia = 'media/'.$getUserName[0]['username'].'/project/'; 
			$projectData['dirUploadMedia'] = $dirUploadMedia;
			if($industryType!='news' || $industryType!='reviews'){
				$projectData['entityId'] = getMasterTableRecord('Project');
				$projectData['showCaseMethod'] = $this->config->item($industryType.'Sl');
				$projectData['sectionId'] = $this->config->item($industryType.'SectionId');
				$projectData['addNewProjectLink'] = '/media/'.$industryType.'/newProject/projectDescription';
				$projectData['industryType'] = $industryType;
				$projectData['indusrtyId'] =$projectData['sectionId'];
				$elementTblPrefix = $this->config->item($industryType.'Prifix');
				$projectData['elemetTable'] = $elementTblPrefix.'Element';
				$projectData['elementEntityId'] = getMasterTableRecord($projectData['elemetTable']);
				$projectData['userId'] = $userId;
			}
		}
		$elementTblPrefix = $this->config->item($industryType.'Prifix');

		$projectData['projects'] = $this->model_media->getProjectData($userId,$industryType,$projectId,$elementTblPrefix);
			
		if(!empty($projectData['projects']) && $userId>0 && !empty($industryType))
		{
			if(isset($projectId) && !empty($projectId))
			{
				$cacheFile = $dirCachePath.$industryType.'_'.$projectId.'_User_'.$userId.'.php';
				//Write data in cache file
				$this->writeDataInFile($projectData,$cacheFile);
			}
			else
			{
				for($i=0;$i<count($projectData['projects']);$i++)
				{
					$projectResult['dirUploadMedia'] = $dirUploadMedia;
					if($industryType!='news' || $industryType!='reviews'){
						$projectResult['entityId'] = getMasterTableRecord('Project');
						$projectResult['showCaseMethod'] = $this->config->item($industryType.'Sl');
						$projectResult['sectionId'] = $this->config->item($industryType.'SectionId');
						$projectResult['addNewProjectLink'] = '/media/'.$industryType.'/newProject/projectDescription';
						$projectResult['industryType'] = $industryType;	
						$projectResult['indusrtyId'] =$projectData['sectionId'];
						$projectResult['elemetTable'] = $elementTblPrefix.'Element';
						$projectResult['elementEntityId'] = getMasterTableRecord($projectData['elemetTable']);
						$projectResult['userId'] = $userId;
						$projectResult['projects']= array($projectData['projects'][$i]);
						
					}
					$cacheFile = $dirCachePath.$industryType.'_'.$projectData['projects'][$i]->projId.'_User_'.$userId.'.php';
					//Write data in cache file
					$this->writeDataInFile($projectResult,$cacheFile);	
				}//End loop
			}
		}else{
			return false;
		}
	}
	
	/*
	 * Write cache file for Work
	 */	
	function workWriteCacheFile($userId=0,$workId=0){
		
		$this->load->model('work/model_work_offered');
		
		//set directory path
		$dirCachePath = 'cache/work/'; 
		if(!is_dir($dirCachePath)){
			@mkdir($dirCachePath, 777, true);
		}
		$cmd3 = 'chmod -R 777 '.$dirCachePath;
		exec($cmd3);
		
		//Get Work result data
		$projectData['work'] = $this->model_work_offered->getworkData($userId,$workId);
		if(!empty($projectData['work']) && $userId>0){
			if(isset($workId) && !empty($workId))
			{
				$cacheFile = $dirCachePath.'work_'.$workId.'_'.$userId.'.php';
				//Write data in cache file
				$this->writeDataInFile($projectData,$cacheFile);
			}
			else
			{
				foreach($projectData['work'] as $pcount => $workDetail)
				{
					if($userId>0) {	
						$cacheFile = $dirCachePath.'work_'.$workDetail['workId'].'_'.$userId.'.php';	
						//Write data in cache file
						$this->writeDataInFile($workDetail,$cacheFile);
					}	
				}//End Foreach	
			}
		}else{
			return false;
		}
	}
	
	/*
	 * Write cache file for Product
	 */	
	function productWriteCacheFile($userId=0,$productId=0){
		
		$this->load->model('product/model_product');
		//set directory path
		$dirCachePath = 'cache/product/'; 
		if(!is_dir($dirCachePath)){
			@mkdir($dirCachePath, 777, true);
		}
		$cmd3 = 'chmod -R 777 '.$dirCachePath;
		exec($cmd3);
		
		//Get Work result data
		$projectData['products'] = $this->model_product->getproductdetail($userId,$productId);
		if(!empty($projectData['products']) && $userId>0){
			if(isset($productId) && !empty($productId))
			{
				$cacheFile = $dirCachePath.'product_'.$productId.'_'.$userId.'.php';
				//Write data in cache file
				$this->writeDataInFile($projectData,$cacheFile);
			}
			else
			{
				foreach($projectData['products'] as $pcount => $productDetail)
				{
					if($productDetail['catId']=1) $productDetail['productType']='Wanted';
					if($productDetail['catId']=2) $productDetail['productType']='For Sale';
					if($productDetail['catId']=3) $productDetail['productType']='Free';
					
					if($userId>0) {	
						$cacheFile = $dirCachePath.'product_'.$productDetail['productId'].'_'.$userId.'.php';	
						//Write data in cache file
						$this->writeDataInFile($productDetail,$cacheFile);
					}	
				}//End Foreach	
			}
		}else{
			return false;
		}
	}
	
	/*
	 * Write cache file for Blog/Post
	 */	
	function blogWriteCacheFile($userId=0,$section='',$projectId=0){
		$this->load->model('blog/model_blog');
		 //set directory path
		$dirCachePath = 'cache/blog/';
		if(!is_dir($dirCachePath)){
			@mkdir($dirCachePath, 777, true);
		}
		$cmd3 = 'chmod -R 777 '.$dirCachePath;
		exec($cmd3);
		
		//Get Work result data
		if($section=='blog'){
			$projectData['project'] = $this->model_blog->getBlogData($userId,$projectId);
		}else{
			$projectData['project'] = $this->model_blog->getPostData($userId,$projectId);
		}
		
		if(!empty($projectData['project']) && $userId>0){
			if(isset($projectId) && !empty($projectId))
			{
				if($section=='blog'){
					$cacheFile = $dirCachePath.'blog_'.$projectId.'_'.$userId.'.php'; 
				}else{
					$cacheFile = $dirCachePath.'blog_post_'.$projectData['project'][0]['blogId'].'_'.$projectId.'_'.$userId.'.php'; 
				}
				//Write data in cache file
				$this->writeDataInFile($projectData,$cacheFile);
			}
			else
			{
				foreach($projectData['project'] as $pcount => $projectDetail)
				{
					if($section=='blog'){
						$cacheFile = $dirCachePath.'blog_'.$projectDetail['blogId'].'_'.$userId.'.php'; 
					}else{
						$cacheFile = $dirCachePath.'blog_post_'.$projectDetail['blogId'].'_'.$projectDetail['postId'].'_'.$userId.'.php'; 
					}	
					
					//Write data in cache file
					$this->writeDataInFile($projectDetail,$cacheFile);
						
				}//End Foreach	
			}
		}else{
			return false;
		}
	}
	
	/*
	 * Write cache file for Upcoming projects
	 */	
	function upcomingWriteCacheFile($userId=0,$upcomingprojId=0){
		$this->load->model('upcomingprojects/model_upcomingprojects');
		//set directory path
		$dirCachePath = 'cache/upcoming/'; 
		if(!is_dir($dirCachePath)){
			@mkdir($dirCachePath, 777, true);
		}
		$cmd3 = 'chmod -R 777 '.$dirCachePath;
		exec($cmd3);
		
		//Get Upcoming projects data
		$projectData['upcoming'] = $this->model_upcomingprojects->getupcomingdetail($userId,$upcomingprojId);	
		if(!empty($projectData['upcoming']) && $userId>0){
			if(isset($upcomingprojId) && !empty($upcomingprojId))
			{
				$cacheFile = $dirCachePath.'upcoming_'.$upcomingprojId.'_'.$userId.'.php';
				//Write data in cache file
				$this->writeDataInFile($projectData,$cacheFile);
			}
			else
			{
				foreach($projectData['upcoming'] as $pcount => $upcomingProjDetail)
				{	
					if($userId>0) {	
						$cacheFile = $dirCachePath.'upcoming_'.$upcomingProjDetail['projId'].'_'.$userId.'.php';	
						//Write data in cache file
						$this->writeDataInFile($upcomingProjDetail,$cacheFile);
					}	
				}//End Foreach	
			}
		}else{
			return false;
		}		
	}
	
	/*
	 * Write cache file for Users showcase
	 */	
	function showcaseWriteCacheFile($userId=0,$showcaseId=0){
		$this->load->model('showcase/model_showcase');
		//set directory path
		$dirCachePath = 'cache/showcase/'; 
		if(!is_dir($dirCachePath)){
			@mkdir($dirCachePath, 777, true);
		}
		
		$cmd3 = 'chmod -R 777 '.$dirCachePath;
		exec($cmd3);
		
		//Get Users Showcase data
		$projectData['showcase'] = $this->model_showcase->userShowcaseData($showcaseId,$userId);
		if(!empty($projectData['showcase'])){
			if($userId>0 || $showcaseId>0)
			{
				$cacheFile = $dirCachePath.'showcase_'.$projectData['showcase'][0]['tdsUid'].'.php';
				//Write data in cache file
				$this->writeDataInFile($projectData,$cacheFile);
			}
			else
			{
				foreach($projectData['showcase'] as $pcount => $showcaseDetails)
				{	
					$cacheFile = $dirCachePath.'showcase_'.$showcaseDetails['tdsUid'].'.php';	
					//Write data in cache file
					$this->writeDataInFile($showcaseDetails,$cacheFile);
				}//End Foreach	
			}
		}else{
			return false;
		}
	}
	
	/*
	 * Write cache file for Users Workprofile 
	 */	
	function workprofileWriteCacheFile($userId=0,$workprofileId=0){
		$this->load->model('workprofile/model_workprofile');
		//set directory path
		$dirCachePath = 'cache/workProfile/'; 
		if(!is_dir($dirCachePath)){
			@mkdir($dirCachePath, 777, true);
		}
		$cmd3 = 'chmod -R 777 '.$dirCachePath;
		exec($cmd3);
		
		//Get Users WorkProfile data
		$projectData['workprofile'] = $this->model_workprofile->userWorkProfileData($workprofileId,$userId);
		if(!empty($projectData['workprofile'])){
			if($userId>0 || $workprofileId>0)
			{
				$cacheFile = $dirCachePath.'workprofile_'.$projectData['workprofile'][0]['tdsUid'].'_'.$projectData['workprofile'][0]['workProfileId'].'.php';
				//Write data in cache file
				$this->writeDataInFile($projectData,$cacheFile);
			}
			else
			{
				foreach($projectData['workprofile'] as $pcount => $workprofileDetails)
				{	
					$cacheFile = $dirCachePath.'workprofile_'.$workprofileDetails['tdsUid'].'_'.$workprofileDetails['workProfileId'].'.php';	
					//Write data in cache file
					$this->writeDataInFile($workprofileDetails,$cacheFile);
				}//End Foreach	
			}
		}else{
			return false;
		}
	}
	
	/*
	 * Write cache file for Event Sections
	 */	
	function eventWriteCacheFile($userId=0,$eventId=0){
		$this->load->model('event/model_event');
		//set directory path
		$dirCachePath = 'cache/event/'; 
		if(!is_dir($dirCachePath)){
			@mkdir($dirCachePath, 777, true);
		}
		$cmd3 = 'chmod -R 777 '.$dirCachePath;
		exec($cmd3);
		
		//Get Event data listing
		$projectData['eventDetails'] = $this->model_event->getEventFullDetails($eventId,$userId);
		if(!empty($projectData['eventDetails']))
		{
			if($eventId>0){
				//Check event is notification or normal event
				if($projectData['eventDetails'][0]['NatureId'] == 1){
					$cacheFile = $dirCachePath.'eventnotification_User_'.$projectData['eventDetails'][0]['tdsUid'].'_'.$eventId.'.php';
				}else{
					$cacheFile = $dirCachePath.'PEevent_User_'.$projectData['eventDetails'][0]['tdsUid'].'_event_'.$eventId.'.php';
				}
				
				//Write data in cache file
				$this->writeDataInFile($projectData,$cacheFile);
			}
			else
			{
				foreach($projectData['eventDetails'] as $pcount => $eventDetails)
				{	
					//Check event is notification or normal event
					if($eventDetails['NatureId'] == 1){
						$cacheFile = $dirCachePath.'eventnotification_User_'.$eventDetails['tdsUid'].'_'.$eventDetails['EventId'].'.php';
					}else{
						$cacheFile = $dirCachePath.'PEevent_User_'.$eventDetails['tdsUid'].'_event_'.$eventDetails['EventId'].'.php';
					}	
					//Write data in cache file
					$this->writeDataInFile($eventDetails,$cacheFile);
				}//End Foreach	
			}
		}else{
			return false;
		}
	}
	
	/*
	 * Write cache file for Launch 
	 */	
	function launchWriteCacheFile($userId=0,$launchId=0){
		$this->load->model('event/model_event');
		//set directory path
		$dirCachePath = 'cache/event/'; 
		if(!is_dir($dirCachePath)){
			@mkdir($dirCachePath, 777, true);
		}
		$cmd3 = 'chmod -R 777 '.$dirCachePath;
		exec($cmd3);
		
		//Get Launch data listing
		$projectData['launchDetails'] = $this->model_event->getLaunchEventFullDetails($launchId,$userId,'',1);
		if(!empty($projectData['launchDetails'])){
			if($launchId>0)
			{
				$cacheFile = $dirCachePath.'eventlaunch_User_'.$projectData['launchDetails'][0]['tdsUid'].'_event_'.$projectData['launchDetails'][0]['LaunchEventId'].'.php';
				//Write data in cache file
				$this->writeDataInFile($projectData,$cacheFile);
				
			}
			else
			{
				foreach($projectData['launchDetails'] as $pcount => $launchDetails)
				{	
					$cacheFile = $dirCachePath.'eventlaunch_User_'.$launchDetails['tdsUid'].'_event_'.$launchDetails['LaunchEventId'].'.php';	
					//Write data in cache file
					$this->writeDataInFile($launchDetails,$cacheFile);
				}//End Foreach	
			}
		}else{
			return false;
		}
	}
	
	function writeCompetitionCacheFile($userId=0, $competitionId = 0){
		if(is_numeric($competitionId) && ($competitionId) > 0){
			
			$this->load->model('competition/model_competition');
			$competitionData=$this->model_competition->getComptitionDetails(array('comp.competitionId'=>$competitionId,'comp.userId'=>$userId,'comp.isExpired'=>'f','comp.isBlocked'=>'f','comp.isArchive'=>'f'));
			
			if($competitionData && is_array($competitionData) && count($competitionData) > 0){
				
				/*create cache file start */
					$dirCache='cache/competition/';
					if(!is_dir($dirCache)){
						@mkdir($dirCache, 777, true);
					}
					$cmd3 = 'chmod -R 777 '.$dirCache;
					exec($cmd3);
					
					$cacheFile = $dirCache.'competition_'.$competitionId.'_'.$userId.'.php';
					$this->writeDataInFile($competitionData,$cacheFile);
				/*create cache file END */
			}
		}
	}
	
	function writeCompetitionEntryCacheFile($userId=0, $competitionEntryId = 0){
		if(is_numeric($competitionEntryId) && ($competitionEntryId) > 0){
			$this->load->model('competition/model_competition');
			$competitionEntry=$this->model_competition->competition_entry_list($userId,$competitionEntryId,'f');
			$competitionEntry=$competitionEntry['get_result'];

			if($competitionEntry && (is_array($competitionEntry) || is_object($competitionEntry)) && count($competitionEntry) > 0){
				/*create cache file start */
					$dirCache='cache/competition/';
					if(!is_dir($dirCache)){
						@mkdir($dirCache, 777, true);
					}
					$cmd3 = 'chmod -R 777 '.$dirCache;
					exec($cmd3);
					
					$cacheFile = $dirCache.'competitionentry_'.$competitionEntryId.'_'.$userId.'.php';
					
					$this->writeDataInFile($competitionEntry,$cacheFile);
				
				/*create cache file END */
			}
		}
	}
	 
	/*
	 * Write data into cache file 
	 */
	function writeDataInFile($projectResult,$cacheFile){
		$data=str_replace("'","&apos;",json_encode($projectResult));	//encode data in json format
		$stringData = '<?php $ProjectData=\''.$data.'\';?>';
		if (!write_file($cacheFile, $stringData)){	//write cache file
			echo 'Unable to write the file';
		}
	}
	/********************* Methods to write cache files End**********************/
	
	
	/*
	 * This function change isProjectImage status
	 */ 
	
	function makeElementProjectImage(){
	
		if($this->input->post('projectID')) {
			$elemetTable = $this->input->post('elemetTable');
			$projectID = $this->input->post('projectID');
			$elementId =  $this->input->post('elementId');
			//------------remove project cover image start----------//
			
			$projectData=$this->model_common->getDataFromTabel('Project', 'projBaseImgPath',  array('projId'=>$projectID),'','projId','ASC',1);
			if($projectData){
					$projectData = $projectData[0];
					if(file_exists($projectData->projBaseImgPath)){
						findFullPathFileNDelete($projectData->projBaseImgPath);
					}
					$this->model_common->editDataFromTabel('Project', array('projBaseImgPath'=>NULL), array('projId'=>$projectID));
				}
			//------------remove project cover image end-------//
			$this->model_common->editDataFromTabel($elemetTable, array('isProjectImage'=>'f'), array('projId'=>$projectID));
			$this->model_common->editDataFromTabel($elemetTable, array('isProjectImage'=>'t'), array('elementId'=>$elementId));
		}
	}
	
	/*
	 * This function change isMain status
	 */
	function makeEventPrimaryImage() {
		$eventType = $this->input->post('eventType');
		$projectEventId = $this->input->post('EventId');
		$mediaEventId =  $this->input->post('mediaEventId');
		$elemetTable = 'EventMedia';
		if(isset($mediaEventId) && !empty($mediaEventId) && isset($projectEventId) && !empty($projectEventId)) {
			if($eventType==9){
				$this->model_common->editDataFromTabel($elemetTable, array('isMain'=>'f'), array('eventId'=>$projectEventId));
			}else{
				$this->model_common->editDataFromTabel($elemetTable, array('isMain'=>'f'), array('launchEventId'=>$projectEventId));
			}
			$this->model_common->editDataFromTabel($elemetTable, array('isMain'=>'t'), array('mediaId'=>$mediaEventId));
		}else{
			echo 0;
		}
	} 
	
	/*
	 * This function copy social sites between showcase and workprofile
	 */
	function copyProfileSocialLinks($entityId=0) {
		$this->userId= $this->isLoginUser();
		$showcaseRes=getUserShowcaseId($this->userId);
		$showcaseId = $showcaseRes->showcaseId;		
		$userWorkProfileID  = $this->model_workprofile->checkForSetProfile($this->userId);
		
		if($entityId==86) {
			if(isset($showcaseId) && !empty($showcaseId)) {
				//Get Users showcase social links
				$socialLinkResult = $this->model_common->getProfileSocialMediaLinks(93,$showcaseId);	
				$workProfileId = $userWorkProfileID;
			}
		} else {
			if(isset($userWorkProfileID) && !empty($userWorkProfileID)) {
				//Get Users workprofile links
				$socialLinkResult = $this->model_common->getProfileSocialMediaLinks(86,$userWorkProfileID);
				$workProfileId = $showcaseId;
			}
		}
		
		$maxPosition =	$this->model_workprofile->getPostion('profileSocialLink',$workProfileId);
		
		if(is_array($socialLinkResult) && count($socialLinkResult) > 0) {
			foreach($socialLinkResult as $socialLinkResult) {
				$existLinkResult = $this->model_common->getProfileSocialMediaLinks($entityId,$workProfileId,$socialLinkResult->socialLink,$socialLinkResult->profileSocialLinkType);
				if(count($existLinkResult) == 0) {	
					$valuesArray['socialLink'] = $socialLinkResult->socialLink; 
					$valuesArray['profileSocialLinkType'] = $socialLinkResult->profileSocialLinkType; 
					$valuesArray['entityId'] = $entityId; 
					$valuesArray['workProfileId'] = $workProfileId; 
					$valuesArray['position'] = $maxPosition+1; 
					$valuesArray['socialLinkDateCreated'] = date("Y-m-d H:i:s"); 
					$valuesArray['socialLinkDateModified'] = date("Y-m-d H:i:s"); 
					$this->model_common->addSocialSitesCopy($valuesArray);
				}
			}
		}
		$msg=$this->lang->line('msgCopySocialLink');
		set_global_messages($msg, $type='success', $is_multiple=true);
		if($entityId==86) {
			$redirectLink = 'workprofile/socialMedia/'.$userWorkProfileID;
			redirect($redirectLink);
		} else {
			redirect("showcase/socialMedia");
		}
	}
	
	
	/*
	 ************************** 
	 *  This function is used to confirm popup 
	 ************************** 
	 */ 
	
	
	function confirmPopup(){
		
		$data = $this->input->get('val1');
		$this->load->view('confirm_popup',$data);	
	}
	
	function loadssl(){
		$this->load->view('ssl_certificate');	
	}
	
	/*
	 * 
	 * Description: This function is used to add create advert into openx table
	 * Auther:  tosif qureshi
	 * 
	 */ 
	
	
	function JqueryUploadAdvertFile($fileUploadPath='temp',$advertType=0)
	{
		$fileUploadPath=str_replace('+',DIRECTORY_SEPARATOR,$fileUploadPath);
		
		$targetDir = ROOTPATH.$fileUploadPath;
		
		$fpLen=strlen($targetDir);
		if($fpLen > 0 && substr($targetDir,-1) != DIRECTORY_SEPARATOR){
			$targetDir=$targetDir.DIRECTORY_SEPARATOR;
		}
		
		$cmd3 = 'chmod -R 777 '.MEDIAUPLOADPATH;
		exec($cmd3);
		 if(!is_dir($targetDir)){
			mkdir($targetDir, 0777, true);
		 }
		 
		 $convertedDIR=$targetDir.'converted';
			if(!is_dir($convertedDIR)){
				mkdir($convertedDIR, 0777, true);
			}

		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds

		// 5 minutes execution time
		set_time_limit(5 * 60);

		// Uncomment this one to fake upload time
		// usleep(5000);

		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

		// Clean the fileName for security reasons
		 $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
		
		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir.$fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);

			$count = 1;
			while (file_exists($targetDir.$fileName_a . '_' . $count . $fileName_b))
				$count++;

			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}
		
		$filePath = $targetDir.$fileName;
				
		$cmdtargetDir = 'chmod -R 777 '.$targetDir;
		exec($cmdtargetDir);
		
		
		if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir.$file;

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
					@unlink($tmpfilePath);
				}
			}

			closedir($dir);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			

		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];

		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				if(is_numeric($advertType) && $advertType>0){
					$imagesize=getimagesize($_FILES['file']['tmp_name']);
					$pathinfo=pathinfo($_FILES['file']['name']);
					$isAdvertType = true;
					switch($advertType)
					{
						case 1:
						$fileWidth = '250';
						$fileHeight = '250';
						$advertImageInfo = $this->lang->line('advert1Info');
						break;
						
						case 2:
						$fileWidth = '160';
						$fileHeight = '600';
						$advertImageInfo = $this->lang->line('advert2Info');
						break;
						
						case 3:
						$fileWidth = '468';
						$fileHeight = '60';
						$advertImageInfo = $this->lang->line('advert3Info');
						break;
						
						case 4:
						$fileWidth = '170';
						$fileHeight = '170';
						$advertImageInfo = $this->lang->line('advert4Info');
						break;
						
						case 5:
						$fileWidth = '728';
						$fileHeight = '90';
						$advertImageInfo = $this->lang->line('advert5Info');
						break;
						
						default:
						$isAdvertType = false;
					}
					
					if(isset($pathinfo['extension']))
					{
						$extension = strtolower($pathinfo['extension']);
						if($extension=="jpg" || $extension=="jpeg" || $extension=="gif" || $extension=="png"){
							if(isset($imagesize[0]) && ($imagesize[0] == $fileWidth ) && isset($imagesize[1]) && ($imagesize[1] == $fileHeight )){
						
							}else{
								die('{"jsonrpc" : "2.0", "error" : {"code": -100, "message": "'.$advertImageInfo.'"}, "id" : "id"}');
							}
						}
						
					}
				
				}
				
				// Open temp file
				$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");

					if ($in) {
						while ($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else
						die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		} else {
			// Open temp file
			$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");

				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

				fclose($in);
				fclose($out);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off 
			rename("{$filePath}.part", $filePath);
		}
		
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "filename" : "'.$fileName.'", "filepath" : "'.$targetDir.'"}');		
		
	}
  
    //--------------------------------------------------------------------------

    /*
    * @description: new version state list new css and js calling 
    * auther: lokendra
    * create: 13-aug-2014
    * return html
    */ 

    public function getCountryStateList() {
        $lang=lang();
        $countryId=$this->input->post('val1');
        $fieldName=$this->input->post('val2');

        $class = $this->input->post('val3');

        $showClass = ($class!='') ? $class : 'l12';

        $stateList =getStatesList($countryId,true);
        $html=form_dropdown($fieldName, $stateList, '','class="'.$showClass.'" ');
        $html.=" <script>$('SELECT').selectBox(); </script>";
        echo $html;
    }
  
    //-------------------------------------------------------------------------
    
     /*
    * @Description: This function is use to show your toadsquare 
    * menu for logged in user
    * @return: void
    * @auther: lokendra 
    */ 
   
    public function yourtoadsquaremenu($userId="0"){
        
        $this->lang->load('dashboard');
        
        // get logged in user id
        //$userId     =    $this->isLoginUser();
        
        //call your message center menu method
        $this->_yourmessagecentermenu($userId);
        
        //call your craves menu method
        $this->_yourcravesmenu($userId);
        
        //call your membership menu
        $this->_yourmembership($userId);
        
        //call project details for your showcase menu
        $showcaseMediaList = $this->_projectdetails($userId);
        
        
        //call your playlist count
        $this->data['myPlaylistCount']        =   getMyPlaylistCount($userId);
      
        $this->data['userId']                 =  $userId;
        
        $this->data['showcaseMediaList']      =  $showcaseMediaList;
        
        $this->load->view('your_toadsquare_menu',$this->data);
    }
    
    //----------------------------------------------------------------------
    
    /**
     * @access: private
     * @description: This method is use to show project details by userId
     * @return: void
     * @auther: lokendra meena
     */ 
    
    private function _projectdetails($userId){
        
        $mediaListArray     =   false;
        // get project details by userId
        $where              =   array('tdsUid'=>$userId,'isPublished'=>'t');
        $getProjectDetails  =   $this->model_common->getDataFromTabel($table='Project', $field='projId, projectType', $where, '', 'projId', 'DESC', 0,0,true);
         
        
        if(!empty($getProjectDetails)){
            foreach($getProjectDetails as $projectDetails){
                $mediaListArray[]   =    $projectDetails['projectType'];
            }    
        }
        
        return  $mediaListArray;
       
    }
    
    
    //-----------------------------------------------------------------------
    
    /**
    * @access: private
    * @Description: This function is use to show message center menu data
    * @param: userId
    * @return: void
    */  
    
    private function _yourmessagecentermenu($userId){
        
        // get unread & new tmail of user
        $unreadMsgCount     =   countResult('tmail_participants',array('user_id'=>$userId,'status'=>0,'is_sender'=>'f'));
        $unreadMsgCount     =   ($unreadMsgCount > 0)?$unreadMsgCount:0;

        // get notification count
        $notificationCount  =    countResult('NotificationParticipants',array('userId'=>$userId,'isSender'=>'f','status'=>0));

        // get user contact count
        $contactCount       =    countResult('UserContacts',array('tdsUid'=>$userId));
        
        $this->data['unreadMsgCount']         =  $unreadMsgCount;
        $this->data['notificationCount']      =  $notificationCount;
        $this->data['contactCount']           =  $contactCount;
    }
    
    //---------------------------------------------------------------------
    
    /**
    * @access: private
    * @Description: This function is use to show your craves menu data
    * @param: userId
    * @return: void
    */  
    
    private function _yourmembership($userId){
        //get logged user subscription details data
        $whereSubcrip 	 = array('tdsUid' => $userId);
        $packageDetails  = $this->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($packageDetails)) {
            $packageDetails  = $packageDetails[0];
        }
        
        $this->data['packageDetails']   =   $packageDetails;  #set package details
        $this->data['userId']           =   $userId;  #set user id
    }
    
    //-----------------------------------------------------------------------
    
    /**
    * @access: private
    * @Description: This function is use to show your craves menu data
    * @param: userId
    * @return: void
    */  
    
    private function _yourcravesmenu($userId){
        
        $this->load->language('craves');  // load lanauge of crave
        $this->load->model('craves/model_craves');  // load crave model
        
        // get crave category order listing from config
        $craveTypeOrder = $this->config->item('your_toadsquare_crave_menu');
        
        // get all other user liked my crave  list
        $myCravesList                   =    $this->model_craves->craveList($userId,'','','',0,false,'',0,true);
        
        $allCraveCount      =  0;
        if(!empty($myCravesList)){
            $myCraveCategory       =  array();
            foreach($myCravesList   as $myCraves){
                $projectType        =   $myCraves->projectType;
                $sectionId          =   $myCraves->sectionId;
                $entityId           =   $myCraves->entityId;
                $elementId          =   $myCraves->elementId;
                $craveId            =   $myCraves->craveId;
                
                //if check category is work and product then get sectionId udpate sectionId
                if($projectType=="work" || $projectType=="product"){
                    if(empty($sectionId)){
                        $upSectionId  = creaveSectionId($projectType,$entityId,$elementId);
                        $updateData=array(
                            'sectionId'=>$upSectionId
                        );
                        $this->model_common->editDataFromTabel('LogCrave', $updateData, 'craveId', $craveId);
                    }
                }
                
                //check project type one by one from config defined array category
                foreach($craveTypeOrder as $key=>$craveType){
                    //checn object into array
                    $craveType = (array)  $craveType;
                    
                    // if project type work and product then search by sub-category of 
                    if($projectType=="work" || $projectType=="product"){
                        // sectin id should not empty
                        if(!empty($sectionId)){
                            // assign section id in projectType
                            $projectType    =   $sectionId;
                        }
                    }
                    
                    // section data in defined confin array
                    if(in_array($projectType,$craveType)){
                       $myCraveCategory[$key][]=$projectType;
                       $allCraveCount++;
                    }
                }
            }
        }
       
        $this->data['myCraveCategory']     =  $myCraveCategory;
        $this->data['myCravesList']        =  $myCravesList;
        $this->data['userId']              =  $userId;
    }
    
    //-----------------------------------------------------------------------
    
    /*
    *  @description: This method is use to show buy collection button  for project 
    *  @param: array
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    public function buyCollectionButton($buttonProperty=array('price'=>0,'priceFlag'=>'f','quantity'=>0,'elementId'=>0,'entityId'=>0,'shippingFlag'=>'f','qunatityFlag'=>'f','seller_currency'=>'','buttonClass'=>'ma','buttonStyle'=>'big','fileType'=>'xyz','mediaId'=>'','mediaElementId'=>'','entityId'=>'','pieceTextClass'=>''))
    {
        $flagArray = array('priceFlag'=>$buttonProperty['priceFlag']);
        
        if($buttonProperty['shippingFlag']=='t') {
            
            //If shipping value exists for the current elementId 			
            $shippingCount = countResult($this->tblShipping,array('elementId'=>$buttonProperty['elementId'],'entityId'=>$buttonProperty['entityId'],'status'=>'t'),1);
            
            //if shippingCount>0 thsn show the button by having shippingFlag=t else  shippingFlag=f
            if($shippingCount>0) $flagArray = array_merge($flagArray,array('shippingFlag'=>'t'));
            else $flagArray = array_merge($flagArray,array('shippingFlag'=>'f'));
        }
        
        if($buttonProperty['qunatityFlag']=='t') $flagArray = array_merge($flagArray,array('qunatityFlag'=>'t'));
        
        $whetherToshowButton = in_array('f',$flagArray);
        
        if($whetherToshowButton ==0) {
            $this->load->view('show_price_button_new',$buttonProperty);
        }
   
    }
    
    //----------------------------------------------------------------------
    
    /*
    *  @description: This method is use to show DVD button for element
    *  @param: array
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    public function elementDVDButton($buttonProperty=false)
    {
        if(!empty($buttonProperty)){
            $this->load->view('dvd_price_button_new',$buttonProperty);
        }
    }
    
    //----------------------------------------------------------------------
    
    /*
    *  @description: This method is use to show payperview button
    *  @param: array
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    public function elementpayperview($buttonProperty=false)
    {
        if(!empty($buttonProperty)){
            $this->load->view('show_ppv_button_new',$buttonProperty);
        }
    }
    
}
