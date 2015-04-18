<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * advertising class
 * CodeIgniter controller for advertising class
 * author => lokendra meena (lokendrameena@cdnsol.com)
 * description => this class is used to manage advertising 
 * create date october 17, 2013
 */

class advertising extends MX_Controller {
	private $data = array();
	private $userId = NULL;
	
	/**
	 * Constructor
	 */
	function __construct() { 
		//Load required Model, Library, language and Helper files
		$load = array(
			'model'		=> 'advertising/model_advertising',
			'language'	=> 'advertising',
		);
		parent::__construct($load);		
		
		$this->userId= isLoginUser();
		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
	}
	
	//--------------------------------------------------------------------//
	
	/*
	 * default load method
	 * description => show listing of Campaigns
	 * load view
	 * 
	 */ 

	function index($campaignId="0"){
		
		$this->userId	= $this->isLoginUser();
		$advirtiserId =  $this->createadvirtiser($this->userId);
		 
		$getCampaignLatest = $this->model_advertising->getCampaignLatest($advirtiserId,$campaignId);
		
		//echo "<pre>";
		//print_r($getCampaignLatest);die();
		
		$this->data['getCampaignLatest'] = $getCampaignLatest;
		$this->data['getCampaignList']   = $this->model_advertising->getCampaignList($advirtiserId);
		
		if($campaignId == "0" && $campaignId!=""){
			if($getCampaignLatest){
				$campaignId = $getCampaignLatest->campaignid;
			}
		}
		
		$this->data['oxAdvertDetails'] = $this->model_advertising->getAdvertDetails($campaignId);
		//Load help page on content section
		$this->data['leftContent']=$this->load->view('dashboard/help_advertise',$this->data,true);		
		
		$this->template->load('backend_template','campaignList',$this->data);
	}
	
	
	
	/*
	 * Description: This functino is used to check advertisting 
	 * @param : userId 
	 * @return advirtiserId
	 * 
	 */ 
	  
	function createadvirtiser($userId){
		
		$oxUserDetails = $this->model_advertising->getExistingUserId($userId);
		
		if(empty($oxUserDetails)){
			$advirtiserId = $this->createOxUser($userId);
		}else{
			$advirtiserId = $oxUserDetails[0]['advirtiserId'];
		}
		
		return $advirtiserId;
	}
	
	
	
	//--------------------------------------------------------------------//
	/*
	 * Description: This function is used create openx user  
	 * 
	 * 
	 */ 
	 
	 
	function createOxUser($userId=0){
		
		//Get login users details
		$userData = $this->model_advertising->getUserData($this->userId);
		//Insert data to create new ox user
		$oxUserData['contact_name']  = $userData[0]['firstName'];
		$oxUserData['email_address'] = $userData[0]['email'];
		$oxUserData['username']      = $userData[0]['firstName'];
		$oxUserData['password']      = $userData[0]['password'];
		$oxUserData['date_created']  = currntDateTime();
		$OxUser = $this->model_advertising->createOxUser($oxUserData);
		if(isset($OxUser) && !empty($OxUser)) {
			$oxAccountData['account_type'] = 'ADVERTISER';	
			$oxAccountData['account_name'] = $userData[0]['firstName'];
			//Insert data to add user account in ox 
			$accountId = $this->model_advertising->addOxAccount($oxAccountData);
			if(isset($accountId) && !empty($accountId)) {
				
				//Insert data to add user account assoc
				$oxUserAssocData['account_id'] =  $accountId;	
				$oxUserAssocData['user_id']    =  $OxUser;
				$oxUserAssocData['linked']     =  currntDateTime();
				$accountAssocId = $this->model_advertising->addAccountAssoc($oxUserAssocData);
				
				//Insert data to add account permission 
				$userPermissionData['account_id'] =  $accountId;	
				$userPermissionData['user_id']    =  $OxUser;
				$userPermissionData['permission_id'] = 10;
				$accountPermissionId = $this->model_advertising->addAccountPermission($userPermissionData);
				
				//Insert data to add new advertiser 
				$oxClientData['clientname'] = $userData[0]['firstName'];	
				$oxClientData['email']      = $userData[0]['email'];
				$oxClientData['account_id'] = $accountId;
				$oxClientData['agencyid']   = 1;
				$advirtiserId = $this->model_advertising->addAdvertiser($oxClientData);
				if(isset($advirtiserId) && !empty($advirtiserId)) {
					$userRecord['logginUserId'] = $userData[0]['tdsUid'];	
					$userRecord['advirtiserId'] = $advirtiserId;
					$userRecord['oxUserId']     = $OxUser;
					//Insert data to add users records
					$this->model_advertising->insertUsersRecord($userRecord);
					
					return $advirtiserId;
				}
			}
		}
	}

	
	//--------------------------------------------------------------------//
	
	/*
	 * description => This function is used to add form description
	 * load view
	 * 
	 */ 
	
	public function description($campaignId=0) {
		
		$this->userId= $this->isLoginUser();
		$sectionId=$this->config->item('advertiseSectionId');
		
		
		//Get users details
		$oxUserDetails = $this->model_advertising->getOxUsersData($this->userId);
		
		//Get users existing campaign data details
		if(!empty($campaignId) && $campaignId > 0) {
			
			$campaignData = $this->model_advertising->getCampaignDetails($oxUserDetails->advirtiserId,$campaignId);
			if($campaignData){
				$this->data['campaignData'] = $campaignData[0];
			}else{
				redirectToNorecord404();
			}
		} else {
			$this->data['campaignData'] = false;
			$this->lib_package->setUserContainerId($sectionId);
		}
		$this->data['sectionId']=$sectionId;
		$this->data['oxUserDetails']=$oxUserDetails;
		$this->data['userId']=$this->userId;
		$this->data['campaignId'] = $campaignId;
		$this->data['headerTitle']=$this->lang->line('DescriptionTitle');
		$this->data['currentPage']='description';
		//Load help page on content section
		$this->data['leftContent']=$this->load->view('dashboard/help_advertise',$this->data,true);	
		$this->template->load('backend_template','description',$this->data);
	}
	
	//---------------------------------------------------------------------//
	
	/*
	 * Description: This function is used to create compaign
	 */
	function saveDescription($campaignId=0) {
		
		//Check user is exist or not
		$this->userId = $this->isLoginUser();
		
		//Get post values
		$data['campaignname']  = $this->input->post('title');
		$data['comments']      = $this->input->post('tagwords');
		$data['activate_time'] = currntDateTime();
		$data['expire_time']   = $this->input->post('completionDate');
		$data['revenue_type']  = $this->input->post('revenueType');
		$campaignId            = $this->input->post('campaignId');
		$data['clientid']      = $this->input->post('advirtiserId');
		$data['target_impression']      = '1000';
		$data['viewed_impression']      = '1000';
		
		if(isset($campaignId) && !empty($campaignId)){
			//Update campaign record
			$campaignStore = $this->model_advertising->updateCampaign($data,$campaignId);
			$getCampaignId  = $campaignId;
			$msg = "campaign updated successfully.";
		}else{
			$insertFlag=false;
			$sectionId=$this->config->item('advertiseSectionId');
			$userContainerId=$this->lib_package->getUserContainerId($sectionId);
			
			if($userContainerId){
				$insertFlag=true;
				$data['userContainerId']=$userContainerId;
			}
			if($insertFlag){
				$campaignId = $this->model_advertising->addCampaign($data);
				$entityId=getMasterTableRecord('tds_ox_campaigns');
				$this->lib_package->updateUserContainer($userContainerId,$entityId,$campaignId,$sectionId,$sectionId);
			}
			//Add campaign record
			$getCampaignId  = $campaignId;
			$msg = "campaign created successfully.";
		}
		set_global_messages($msg, $type='success');
		$returnData=array('msg'=>$msg,'campaignId'=>$getCampaignId);
		echo json_encode($returnData);
	}

	//--------------------------------------------------------------------//
	
	/*
	 * description => This function is used to add form description
	 * load view
	 * 
	 */ 
	
	public function adverts($campaignId=0,$advertId=0) {
		
		//---------add css and js for wid--------//
		$this->head->add_css($this->config->item('system_js').'createAdvert/colorpicker/css/colorpicker.css');
		$this->head->add_css($this->config->item('system_js').'createAdvert/js/gradX.css');
		$this->head->add_css($this->config->item('system_js').'createAdvert/js/advert.css');
		//$this->head->add_js($this->config->item('system_js').'createAdvert/js/jquery-ui.js');
		$this->head->add_js($this->config->item('system_js').'createAdvert/colorpicker/js/colorpicker.js');
		$this->head->add_js($this->config->item('system_js').'createAdvert/js/dom-drag.js');
		$this->head->add_js($this->config->item('system_js').'createAdvert/jscolor/jscolor.js');
		$this->head->add_js($this->config->item('system_js').'createAdvert/js/gradX.js');
		$this->head->add_js($this->config->item('system_js').'createAdvert/js/advert.js');
		
		
		$this->userId = $this->isLoginUser();
		//Get users details
		$oxUserDetails = $this->model_advertising->getOxUsersData($this->userId);
	
		
		//Get users existing campaign data details
		if(!($campaignId > 0)){
			redirectToNorecord404(); //redirect to no record page
		}
		$campaignData = $this->model_advertising->getCampaignDetails($oxUserDetails->advirtiserId,$campaignId);
		
		//if enter wrong campignId then redirect
		if(empty($campaignData)){
			redirectToNorecord404(); //redirect to no record page
		}
		
		if(isset($campaignId) && !empty($campaignId)){
			//Get users Advert/Banner details
			$oxAdvertDetails = $this->model_advertising->getAdvertDetails($campaignId);
		    //$this->db->set_dbprefix('TDS_'); //Set custom prefix
			$this->data['advertListData'] = $oxAdvertDetails;
		}

		$this->data['userId']      = $this->userId;
		$this->data['campaignId']  = $campaignId;
		$this->data['advertId']    = $advertId;
		$this->data['headerTitle'] = $this->lang->line('AdvertsTitle');
		$this->data['currentPage'] = 'adverts';
		//Get Industry listing record
		$whereField = array('isAdvertSection'=>'t');
		$this->data['industrySections'] = $this->model_common->getDataFromTabel('MasterIndustry', 'IndustryId,IndustryName',  $whereField, '', 'IndustryName','ASC');
		//Load help page on content section
		$this->data['leftContent']=$this->load->view('dashboard/help_advertise',$this->data,true);	
		$this->template->load('backend_template','adverts',$this->data);	
	}
	
	//--------------------------------------------------------------------//
	/*
	 * description => This function is used to add advert
	 * load view
	 * 
	 */ 
	 
	public function advertsadd() {
		$this->userId= $this->isLoginUser();
		if($this->input->post('title')){
			
			$pathinfo = pathinfo($this->input->post('fileName_cm'));
			$campaignid  = $this->input->post('campaignId');
			$data['campaignid']  = $this->input->post('campaignId');
			$data['description'] = $this->input->post('title');
			
			$data['url']         = $this->input->post('url');
			$data['target']      = $this->input->post('target');
			$data['width']       = $this->input->post('filewidth');
			$data['height']      = $this->input->post('fileheight');
			
			if($this->input->post('sectionIds_cm')){
				//Set banner section
				$data['banner_sections'] = $this->input->post('sectionIds_cm');
			}
			if($pathinfo['extension']=='jpg') {
				$pathinfo['extension'] = 'jpeg';
			}
			$fileInput = $this->input->post('fileName_cm');
			if(!empty($fileInput)){
				$data['filename']    = $fileInput;
				$data['contenttype'] = $pathinfo['extension'];
			}
			
			$data['storagetype'] = 'web';
			$data['weight']      = '1';
			
			$bannerId = $this->input->post('bannerid');
			if(isset($bannerId ) && !empty($bannerId )) {
				$insertedAdvertId = $this->model_advertising->updateOxAdvert($data,$bannerId);
				$msg =array('msg'=>$this->lang->line('updateAdvertMsg'),'');
			}else{
				$data['advert_order'] = $this->input->post('uploadAdvertOrder');
				//Add advertise record
				$insertedAdvertId = $this->model_advertising->addOxAdvert($data);
				
				//update advert status in campaign table
				$updateDataCmp['is_advert'] = 't'; 
				$this->model_advertising->updateCampaign($updateDataCmp,$campaignid);
				
				//Add ad zone data
				$zoneData['zone_id'] = 0;
				$zoneData['ad_id'] = $insertedAdvertId;
				$this->model_advertising->addOxAdZone($zoneData);
				if(isset($insertedAdvertId) && !empty($insertedAdvertId))
					$msg =array('msg'=>$this->lang->line('addAdvertMsg'),'');
				else
					$msg =array('msg'=>$this->lang->line('errorAdvertMsg'),'');
			}
			echo json_encode($msg);
			
		}
	}
	
	//--------------------------------------------------------------------//
	/*
	 * description => This function is used to save created advert
	 * load view
	 * 
	 */ 
	
	function saveCreateAdvert(){
		if($this->input->post("show_generate_code")) {
			
			//prepare create advert filed data
			$textField = array();
			
			if($this->input->post('write_heading')!=""){
				$textField[0]['writeheading'] = $this->input->post('write_heading');
			}
			if($this->input->post('advertImgField')!=""){
				$textField[1]['advertimgfield'] = explode(",",$this->input->post('advertImgField'));
			}
			$fieldData = json_encode($textField);
			
			//--------if create advert any image then execute below code-------//	
			$this->load->library('upload');
			$config['upload_path'] = 'openx/www/images/';
			$config['allowed_types'] = '*';
			$config['encrypt_name'] = TRUE;
			$this->upload->initialize($config);
			
			
			// get random image store array
			$fileNameArray = array();
			
			if(count($_FILES > 0)){
				foreach($_FILES as $field => $file)
				{
					// No problems with the file
					if($file)
					{
						// So lets upload
						if ($this->upload->do_upload($field))
						{
							$data = $this->upload->data();
							if($field!='bg_image' && !empty($data)){
								$fileNameArray[] = $data['file_name'];
							}	
						}
						else
						{
							$errors = $this->upload->display_errors();
						}
					}
				}
			}
			
			$show_generate_code = base64_decode(($this->input->post("show_generate_code")));
			
			//get html code and replace temp image with rand genrate name 
			if($fileNameArray){
				foreach($fileNameArray as $key => $value){
					$imgPosiIndex = $textField[1]['advertimgfield'][$key];
					$pasePosiIndex = '{img_show_'.$imgPosiIndex.'}'; 
					echo $pasePosiIndex;
					$show_generate_code = str_replace($pasePosiIndex,$value,$show_generate_code);
				}
			}
			
			$campaign_id = $this->input->post("campaign_id");
			$title = $this->input->post("createAdvertTitle");
			$destination = $this->input->post("advertUrl");
			$width = $this->input->post("width");
			$height = $this->input->post("height");
			$advertOrder = $this->input->post("createAdvertOrder");
			$submitAction= $this->input->post("submitAction");
			
			if($this->input->post("sectionIds_cm")){
				//Set banner section
				$inserData['banner_sections'] = $this->input->post("sectionIds_cm");
			}
			
			$inserData['campaignid']     = $campaign_id;
			$inserData['description']    = $title;
			$inserData['htmltemplate']   = $show_generate_code;
			$inserData['url']            = $destination;
			$inserData['contenttype']    = '';
			$inserData['target']         = '';
			$inserData['width']          = $width;
			$inserData['height']         = $height;
			$inserData['storagetype']    = 'html';
			$inserData['weight']         = '1';	
			$inserData['advert_order']   = $advertOrder;	
			$inserData['html_template_field']   = $fieldData;	
			
			if($submitAction=="add"){
				$insertedAdvertId = $this->model_advertising->addOxAdvert($inserData);	
				$msg = 'Advert created successfully.';
			}else{
				$bannerId= $this->input->post("createAdvertId");
				$insertedAdvertId = $this->model_advertising->updateOxAdvert($inserData,$bannerId);
				$msg = 'Advert update successfully.';
			}
			//update advert status in campaign table
			$updateDataCmp['is_advert'] = 't'; 
			$this->model_advertising->updateCampaign($updateDataCmp,$campaign_id);
				
			set_global_messages($msg, $type='success');
			redirect(base_url('advertising/adverts/'.$campaign_id));
		}
	}
	
	/*
	 * Function to remove advert records 
	 */
	function deleteAdvert() {
		$advertId = $this->input->post('advertId');
		//get banner records
		$getBannerDetails = $this->model_advertising->getBannerDetails($advertId);
		if($getBannerDetails){
			$html = $getBannerDetails->htmltemplate;
			preg_match_all('/<img[^>]+>/i',$html, $result); 
			$img = array();
			// get all image from html
			foreach( $result as $img_tag)
			{
				preg_match_all('/(alt|title|src)=("[^"]*")/i',$img_tag, $img[$img_tag]);
			}

            // delete all image 
			foreach( $result as $img_tag)
			{
				if($img_tag){
					foreach($img_tag as $getImg){
						preg_match_all("/<img .*?(?=src)src=\"([^\"]+)\"/si", $getImg, $m);
						if($m[1]){
							$imgGetUrl = str_replace('{server_path}','',$m[1][0]); 
							unlink($imgGetUrl);
						}
					}
				}
			}
		}
		// banner file record delete 
		$this->model_advertising->deleteAdvertData('ox_banners','bannerid',$advertId);
		// banner ad zone record delete 
		$this->model_advertising->deleteAdvertData('ox_ad_zone_assoc','ad_id',$advertId);
		//$this->db->set_dbprefix('TDS_'); //Set custom prefix
		$msg = $this->lang->line('deleteAdvert');
		set_global_messages($msg, $type='success');
		$returnData=array('msg'=>$msg);
		echo json_encode($returnData);
	}
	
	//-------------------------------------------------------//
	/*
	 * description => This function is used show created advert
	 * load view
	 * 
	 */ 
	function previewAdvert(){
		
		$bannerId = $this->input->get('val1');
		$bannerData = $this->model_advertising->getBannerDetails($bannerId);
	    $htmltemplate = $bannerData->htmltemplate;
	    $serverPath = base_url();
		
		$searchArray = array("{server_path}");
		$replaceArray = array($serverPath);
		$dataShow['showCode']=str_replace($searchArray, $replaceArray, $htmltemplate);
		$dataShow['bannerData']=$bannerData;
		$this->load->view('advertPreview',$dataShow);
	}
	
	//--------------------------------------------------------------------//
	
	/*
	 * description => This function is used show  upload and created advert by advert type
	 * load view
	 * 
	 */ 
	
	function showadverts($advertType=""){
		
		// show first advert
		if($advertType == 'advertfirst'){
			$this->advertview(1);
		}
		
		// show second advert
		if($advertType == 'advertsecond'){
			$this->advertview(2);
		}
		
		// show third advert
		if($advertType == 'advertthird'){
			$this->advertview(3);
		}
	}
	
	//--------------------------------------------------------------------//
	
	/*
	 * description: This function show all advert by type size
	 * 
	 */ 
	
	function advertview($advertType=0) {
		//get campaign records
		$getShowCampaign = $this->model_advertising->getShowCampaign($advertType);
		
		if($getShowCampaign){
			$bannerid = $getShowCampaign->bannerid;
			//this function call for impression count
			$this->countimpression($getShowCampaign->campaignid,$bannerid);
			//echo $getShowCampaign->campaignid;
			
			$htmltemplate = $getShowCampaign->htmltemplate;
			$serverPath = base_url();
			$searchArray = array("{server_path}");
			$replaceArray = array($serverPath);
			$dataShow['showCode']=str_replace($searchArray, $replaceArray, $htmltemplate);
			$dataShow['bannerData']=$getShowCampaign;
			$this->load->view('advertShow',$dataShow);
		}
	}
	
	//-------------------------------------------------------------------------------//
	
	
	/*
	 * description: This function is used count impression(view) of any campaign
	 * @param : $campaignid integer
	 * @bannerid : $campaignid integer
	 */ 
	
	function countimpression($campaignid=0,$bannerid=0){
		
		if($bannerid > 0){
			// get data from imprssion table
			$getimpression = $this->model_advertising->getimpression($bannerid);
			
			// get campaign data by campaign id
			$getCampaignData = $this->model_advertising->getCampaignData($campaignid);
			
			//update campaign impression
			if($getCampaignData){
				$viewed_impression = $getCampaignData->viewed_impression; 
				$viewed_impression = $viewed_impression - 1;
				$updateDataCmp['viewed_impression'] = $viewed_impression; 
				$this->model_advertising->updateCampaign($updateDataCmp,$campaignid);
			}
			// if data is blank then insert banner record otherwise update count
			if(empty($getimpression)){
			
				$impressionData['interval_start'] = date("Y-m-d H:i:s"); 
				$impressionData['creative_id'] = $bannerid; 
				$impressionData['zone_id'] = '0';
				$impressionData['count'] = '1';
				$impressionId = $this->model_advertising->insertimpression($impressionData);
			}else{
				$impressionCount = $getimpression->count + 1; 
				$updateData['count'] = $impressionCount;
				$this->model_advertising->updateimpression($updateData,$bannerid);
			}
		}
	}
	
	
	/*
	 * description: This function is used count click on advert of any campaign
	 */ 
	function clickadvert($bannerid="0"){
		$bannerid = $this->input->post('bannerid');
		$campaignid = $this->input->post('campaignid');
		if($bannerid > 0 && $campaignid > 0){
			//manage openx  click functionality
			$getclickadvert = $this->model_advertising->getclickadvert($bannerid);
			$getBannerDetails = $this->model_advertising->getBannerDetails($bannerid);
			
			// if data is blank then insert banner record
			if(empty($getclickadvert)){
				
				$insertData['interval_start'] = date("Y-m-d H:i:s"); 
				$insertData['creative_id'] = $bannerid; 
				$insertData['zone_id'] = '0';
				$insertData['count'] = '1';
				$insertId = $this->model_advertising->insertclickadvert($insertData);
			}else{
				$clickCount = $getclickadvert->count + 1; 
				$updateData['count'] = $clickCount;
				$this->model_advertising->updateclickadvert($updateData,$bannerid);
			}
			
			//manage campaign custom click log
			$clickData['campaign_id'] = $campaignid;
			$clickData['banner_id']   = $bannerid;
			//get campaign record if exists
			$campaignLog = $this->model_advertising->getCampaignLog($clickData['campaign_id'],$clickData['banner_id'] );
			if(!empty($campaignLog) && isset($campaignLog->campaign_log_id)) {
				$clickData['click_count'] = $campaignLog->click_count+1;
				$this->model_advertising->manageCampaignCountLog($clickData,$campaignLog->campaign_log_id);
			} else {
				$clickData['click_count'] = 1;
				$this->model_advertising->manageCampaignCountLog($clickData,'');
			}
			
			if(!empty($getBannerDetails->url)){
				redirect($getBannerDetails->url);
			}
		}
		
	}
	
	//---------------------------------------------------------------------//
	
	/*
	 * description: This function is used to show all size adverts
	 * load: demo view
	 * 
	 */ 
	function showdemoadvert(){
		
		$this->load->view('demoview');
	}
	
	//---------------------------------------------------------------------//
	
	/*
	 * description: This function is used to published and unpublished campaign
	 * param: campaignId
	 * 
	 */ 
	function publisheandunpublishe(){
		
		$data['is_published']= $this->input->post('is_published');
		$campaignId= $this->input->post('campaignId');
		$this->model_advertising->updateCampaign($data,$campaignId);
		if($data['is_published']=="t"){
			$bannerData['status'] = '0';
		}else{
			$bannerData['status'] = '1';
		}
		$this->model_advertising->updateAdvertByCampaignId($bannerData,$campaignId);
		
		$msg = 'campaign updated.';
		set_global_messages($msg, $type='success');
		$returnData=array('msg'=>$msg);
		echo json_encode($returnData);
		
	}
	
	/*
	 * This function used to get banner records
	 */
	function getAdvertRecords($data) {
		if($this->input->post('sectionId')) { //load advert if it comes from ajax
			$data['sectionId']  = $this->input->post('sectionId');
			//$data['advertType'] = $this->input->post('advertType');
		
			//get random banner data row
			$bannerData = $this->model_advertising->getBannerRecords($data['sectionId'],$data['advertType']);
			
            //-------------commented by lokendra (10-oct-2014)-------//
            //$this->load->view('common/advert',array('bannerData'=>$bannerData,'advertType'=>$data['advertType'],'sectionId'=>$data['sectionId']));
            
            //added by lokendra (10-oct-2014)
            if(!empty($bannerData)) {
				//manage campaign impression count
				$this->manageCampaignLog($bannerData);
			}
			return $bannerData;
            
		
		} else { //return advert data to display page
			//get random banner data row
			$bannerData = $this->model_advertising->getBannerRecords($data['sectionId'],$data['advertType']);
			if(!empty($bannerData)) {
				//manage campaign impression count
				$this->manageCampaignLog($bannerData);
			}
			return $bannerData;
		}
	}
	
	/*
	 * this function used to manage campaign log
	 */
	function manageCampaignLog($bannerData) {
		$impressionData['campaign_id'] = $bannerData->campaignid;
		$impressionData['banner_id']   = $bannerData->bannerid;
		//get campaign record if exists
		$campaignLog = $this->model_advertising->getCampaignLog($impressionData['campaign_id'],$impressionData['banner_id'] );
		if(!empty($campaignLog) && isset($campaignLog->campaign_log_id)) {
			$impressionData['impression_count'] = $campaignLog->impression_count+1;
			$this->model_advertising->manageCampaignCountLog($impressionData,$campaignLog->campaign_log_id);
		} else {
			$impressionData['impression_count'] = 1;
			$this->model_advertising->manageCampaignCountLog($impressionData,'');
		}
		return true;
	}
}
