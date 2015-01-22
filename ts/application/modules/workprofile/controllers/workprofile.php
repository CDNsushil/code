<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	 Description:
	 * The controller class "workprofile" is meant to handle the processing of "Work Profile" section
	 * It include functionality to fetch/add/edit workprofile address,sicaol media links,employment history,etc
	 *
	 * @package	Toadsquare
	 * @subpackage	Module
	 * @category	Controller
	 * Author Name: Gurutva Singh
	 * Date Created: 7 Februray 2012
	 * Date Modified: 8 Februray 2012	
*/
class workprofile extends MX_Controller {
	private $dirCache = '';	
	private $data = array();
	private $userId = NULL;
	private $workprofileMsg =''; //To show messages on views based on return values
	private $allowed_image_size = '';
	private $blog_allowed_upload_image_size_unit = '';
	private $blog_allowed_image_type = '';
	private $mediaPath = '';

	private $tabelWorkprofile = 'WorkProfile';
	private $tableProfileSocialLink = 'profileSocialLink';
	private $tableProfileEmpHistory = 'profileEmpHistory';
	private $tableProfileRecommendation = 'profileRecommendation';
	private $tableUserContacts = 'UserProfile';
	private $tableprofileSocialMediaIcon = 'profileSocialMediaIcon';
	private $tableprofileEdu = 'WorkProfileEducation';
	private $tableprofileVisa = 'WorkProfileVisa';

	function __construct(){
		$load = array(
				'model'		=> 'workprofile/model_workprofile',
				'library' 	=> 'session + lib_sub_master_media + lib_workprofile + lib_work_emp_hist + lib_recommandations + lib_social_media',
				'language' 	=> 'workprofile + socialmedialinks + employment_history + employmentReferencesRecommendations',
				'helper' 	=> 'form + file'
		);
		parent::__construct($load);	
		$this->userId = $this->isLoginUser();
		$this->allowed_image_size = $this->config->item('workProfile_allowed_upload_image_size');
		$this->blog_allowed_upload_image_size_unit = $this->config->item('workProfile_allowed_upload_image_size_unit');
		$this->blog_allowed_image_type = $this->config->item('workProfile_allowed_image_type');
		$this->mediaPath = "media/".LoginUserDetails('username')."/workProfile/" ;
		$this->dirCache = 'cache/workprofile/';	
		$this->load->model('workprofilefrontend/model_workprofilefrontend');
		//$this->load->library('newtcpdf/tcpdf');
		//$this->load->library('newtcpdf/config/lang/eng');
		$this->head->add_css($this->config->item('frontend_css').'workprofile.css');
	}

	function index()
	{
		
		$this->data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'workprofile', $userNavigations, $key='section', $is_object=0 ))){ 
			
		}else{
			redirect('dashboard/workprofile');
			
		}
		$this->data['label']=$this->lang->language; 
		$checkForSetProfile =  $this->model_workprofile->checkForSetProfile($this->userId);
		
		if($checkForSetProfile == 0){
			//$this->template->load('template','workProfile/workprofileDummyNew',$this->data); 
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/welcome_workprofile';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workProfile/workprofileDummyNew',$this->data); 
		}
		else {
			
			$currentWorkProfileId = $checkForSetProfile;
			$this->data['workProfile'] = $this->lib_workprofile->getValuesFromDB($this->userId);
			$this->data['workProfile']['countriesInterestWorking'];
			if(isset($this->data['workProfile']['countriesInterestWorking']) && !empty($this->data['workProfile']['countriesInterestWorking'])) {
				$InterestedCountry = explode('|',$this->data['workProfile']['countriesInterestWorking']);
				$this->data['InterestedCountry'] = $InterestedCountry;
			}
			
			$whereField=array(
					'workProfileId'=>$currentWorkProfileId
			);
		
			$this->data['WorkProfileEducation'] = $this->model_common->getDataFromTabel('WorkProfileEducation','year_from,year_to,university,degree',$whereField);
			$this->data['WorkProfileVisa'] = $this->model_common->getDataFromTabel('WorkProfileVisa','countryId,visaType',$whereField);
			
			$this->data['WorkEmpHistory'] = $this->lib_work_emp_hist->getValuesFromDB($currentWorkProfileId);

			$this->data['WorkRecommendation'] = $this->lib_recommandations->getValuesFromDB($currentWorkProfileId);
			
			$this->data['WorkSocialMedia'] = $this->lib_social_media->getValuesFromDB($this->userId);

			$this->data['label']=$this->lang->language; 	
			$this->data['header']=$this->load->view('workProfile/navigationMenu',$this->data,true);
			//$this->template->load('template','workProfile/workprofile',$this->data); 	 
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_workprofile_index';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workProfile/workprofile',$this->data); 
		}
	}
	/*
		* This function used to Insert/Update a record with validation of data
		* @access public
		* @params int workProfileId
		* Displays the form with filled value and if error displays the associated errors
	*/
	function workProfileForm($workProfileId=0)
	{
		/*$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		*/
		$profileImgPath = $this->mediaPath ;
		$sectionId=$this->config->item('workprofileSectionId');
		$entityId=getMasterTableRecord('WorkProfile');
		$data['label']=$this->lang->language;
		
		$userId=$this->userId;
		$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
		if(isset($userWorkProfileID[0]->workProfileId) && $userWorkProfileID[0]->workProfileId > 0) {
			$workProfileId = $userWorkProfileID[0]->workProfileId;
		}else{
			$workProfileId = 0; 
		}
		$data['WorkProfile'] = $WorkProfileData= $this->model_workprofile->workProfileForm($workProfileId,$this->userId);
		
		if($this->input->post('save')){
			$educationArray = array();
			$educationArray['educationId'] = 0;
			$educationArray['workProfileId'] = $workProfileId;
			$educationArray['degree'] = $this->input->post('degree');		
			$educationArray['year'] = $this->input->post('educationYear');		
			$educationArray['university'] = $this->input->post('university');
			//$this->model_workprofile->saveEducation($educationArray,$this->userId);
			
			$visaTypeArray = array();
			$visaTypeArray['visaId'] = 0;
			$visaTypeArray['workProfileId'] = $workProfileId;;
			$visaTypeArray['countryId'] = $this->input->post('countryId');		
			$visaTypeArray['visaType'] = $this->input->post('visaType');
				//$this->model_workprofile->saveVisaType($visaTypeArray,$this->userId);
			
			$errorConfig = array(
				   array(
						 'field'   => 'profileFName',
						 'label'   =>  $data['label']['profileFName'],
						 'rules'   => 'trim|required|xss_clean'
					  ),
					   array(
						 'field'   => 'synopsis',
						 'label'   =>  $data['label']['synopsis'],
						 'rules'   => 'trim|required|xss_clean'
					  )
			);
		 /*
			if($this->input->post('levels') =='level1') {
			$new_array = array( array(
						 'field'   => 'visaType[1]',
						 'label'   =>  $data['label']['visaType'],
						 'rules'   => 'trim|required|xss_clean'
					  ));
			$errorConfig = array_merge($new_array,$errorConfig);		
			}
			* * */
			
			$this->form_validation->set_rules($errorConfig); //Setting rules for validation
			$this->form_validation->set_error_delimiters('<span class="required validation_error">', '</span>');
			
			$intrestedCountryType = $this->input->post('intrestedCountryType');
			if($intrestedCountryType == 0) {
				$_POST['countriesInterestWorking'] = '';  
			}
			$dataSetValue = $this->lib_workprofile->setValues($this->input->post());
			$data= $this->lib_workprofile->getValues();

			$data['remunerationRate']=(isset($data['remunerationRate']) && is_numeric($data['remunerationRate']))?$data['remunerationRate']:0;
			
			if($this->form_validation->run()){
				
				$fileMaxSize=$this->config->item('image5MBSize');
				if(isset($WorkProfileData['containerSize']) && $WorkProfileData['containerSize'] > 0 ){
					$containerSize=$WorkProfileData['containerSize'];
					
					$dirname=$this->mediaPath;
					$dirSize=getFolderSize($dirname);
					$remainingBytes =($containerSize - $dirSize);
					if(!$remainingBytes > 0){
						$remainingBytes =0;
					}
					
					$containerSize=bytestoMB($containerSize,'mb');
					$dirSize=bytestoMB($dirSize,'mb');
					$remainingSize=($containerSize-$dirSize);
					if($remainingSize < 0){
							$remainingSize = 0;
					}
					$dirSize = number_format($dirSize,2,'.','');
					$remainingSize = number_format($remainingSize,2,'.','');
					$fileMaxSize=$remainingBytes;
				}
				
				$uploadedData = array(); // File Upload code
				$profileImgName = '';
				
				if(isset($_FILES['userfile']['name']) && $_FILES['userfile']['name'] !=''){
					$uploadedData = $this->lib_sub_master_media->do_upload($_FILES,$profileImgPath,'',1,'userfile',$fileMaxSize);
					if(!isset($uploadedData['error'])){			
							$profileImgName = $uploadedData['upload_data']['file_name'];
					}else{					
						$Upload_File_Name['error'] = $uploadedData['error'];
						set_global_messages($Upload_File_Name['error'], 'error');
						redirect("workprofile");
					}
				}
				if($this->input->post('workProfileId') > 0){
					$data['visaAvailable'] = '';
					$data['education'] = '';
					
					$workProfileId = $this->model_workprofile->updateWorkprofile($profileImgName,$profileImgPath,$data);
					$msg = 'Personal Information updated successfully';
					set_global_messages($msg, 'success');
				}else{
					  
					$sectionId=$this->config->item('workprofileSectionId');
					$userContainerId=$this->lib_package->getUserContainerId($sectionId);
					$data['userContainerId']=$userContainerId;
					$updateUserContainerFlag=true;
					unset($data['workProfileId']);
					$workProfileId = $this->model_workprofile->insertWorkprofile($profileImgName,$profileImgPath,$data);
					$this->lib_package->updateUserContainer($userContainerId,$entityId,$workProfileId,$sectionId,$sectionId);
					$msg =   'Personal Information Inserted successfully.';
					set_global_messages($msg, 'success');
				}
				if(is_numeric($workProfileId) && $workProfileId > 0){
					$workProfileDetails=$this->model_workprofile->getWorkProfileDetails($workProfileId);
					$cacheFile = $this->dirCache.'workprofile_'.$userId.'_'.$workProfileId.'.php';
					$data=str_replace("'","&acute;",json_encode($workProfileDetails));	//encode data in json format
					$stringData = '<?php $ProjectData=\''.$data.'\';?>';
					if (!write_file($cacheFile, $stringData)){					// write cache file
						echo 'Unable to write the file';
					}				
					
					if($workProfileDetails){
						$SD=$workProfileDetails[0];
						$sectionId=$this->config->item('workprofileSectionId');
						$searchDataInsert=array(
							"entityid"=>$entityId>0?$entityId:0,
							"elementid"=>$SD->workProfileId,
							"projectid"=>$SD->workProfileId,
							"section"=>'workprofile',
							"sectionid"=>$sectionId,
							"ispublished"=>(isset($SD->isPublished)&&($SD->isPublished=='f'))?'f':'t',
							"cachefile"=>$cacheFile,
							"item.title"=>$SD->profileFName.' '.$SD->profileLName,
							"item.online_desctiption"=>$SD->synopsis,
							"item.userid"=>$SD->tdsUid, 
							"item.creative_name"=>pg_escape_string($SD->firstName.' '.$SD->lastName), 
							"item.creative_area"=>pg_escape_string($SD->optionAreaName),
							"item.languageid"=>1,  //langId hard coded implemented  
							"item.language"=>'English', //lang hard coded implemented  
							"item.countryid"=>$SD->profileCountry>0?$SD->profileCountry:0, 
							"item.country"=>$SD->countryName, 
							"item.city"=>pg_escape_string($SD->profileCity),
							"item.sell_option"=>'free',
							"item.creation_date"=>$SD->dateCreated!=''?$SD->dateCreated:currntDateTime(), 
							"item.publish_date"=>$SD->dateCreated!=''?$SD->dateCreated:currntDateTime()
						);
						$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
					}
				}
				
				//redirect("workprofile/index");
				redirect("workprofile/workProfileForm");
				
			}
			else
			{
				if(validation_errors())
				{
					// echo "<pre />"; print_r($errorConfig);
					$msg = array('errors' => validation_errors());	
					$data['values']['save'] = '';			
					//echo '<pre />';print_r($msg);die;
				}
			}
		}

		
		$sectionId=$this->input->post('sectionId');
		$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'workprofile', $userNavigations, $key='section', $is_object=0 ) && is_numeric($workProfileId) && ($workProfileId > 0))){ 
			
		}else{
			$this->lib_package->setUserContainerId($sectionId);
			
		}
		
		
		$data['WorkProfile']['workProfileId'] = $workProfileId;
		
		
		$dataSetValue = $this->lib_workprofile->setValues($data['WorkProfile']);
		$data= $this->lib_workprofile->getValues();
		$data['WorkProfile']=$WorkProfileData;
		$data['label']=$this->lang->language;

		
		if($data['workProfileId'] > 0){
			$data['mode'] = 'edit';
		}else
		{
			$data['mode'] = 'new';
		}
	
		if( strcmp($this->uri->segment(4),'flag')==0) {
			//$this->workprofileMsg = $data['label']['errorMsgNoRecord'];
			$Upload_File_Name['error'] = 'Please Fill the Personal Information First';
			set_global_messages($Upload_File_Name['error'], 'error');
			redirect("workprofile");
		}
		//If error msg is difned
		if($this->workprofileMsg != '') 
		$data['WorkProfile']['Msg'] = $this->workprofileMsg; // to get displayed in view
		$data['allowed_image_size'] = $this->allowed_image_size;
		$data['image_size_unit'] = $this->blog_allowed_upload_image_size_unit; 
		$data['countries'] = getCountryList();
		$data['tdsUid'] = $this->userId;
		$data['educationTableName'] = $this->tableprofileEdu;		
		$data['eduElementId'] = 'educationId';		
		$data['visaTableName'] = $this->tableprofileVisa;
		$data['visaElementId'] = 'visaId';
		$data['userNavigations']=$userNavigations;
		$data['continentWiseCountry'] = $this->model_common->getContinentWiseCountry();
		//$this->template->load('template','workProfile/workprofile_form',$data); 	
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true,
							'helpSection'=>'personalDetails'
				  );
			$leftView='dashboard/help_workprofile_sections';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workProfile/workprofile_form',$data);	  
	}
	
	function addEducation($workProfileId=0)
	{		
			$education['workProfileId'] = $workProfileId;
			$education['educationValues'] = $this->model_workprofile->getEducation($workProfileId);
			$education['countEducation'] = count($education['educationValues']);		
			$this->load->view('workProfile/add_education',$education);				
	}
	
	function educationList($workProfileId=0)
	{
		$education['label'] = $this->lang->language;
		
		$education['workProfileId'] = $workProfileId;
		
		$education['educationValues'] = $this->model_workprofile->getEducation($workProfileId);
		
		$education['countEducation'] = count($education['educationValues']);				
		
		$this->load->view('workProfile/list_education',$education);
	}
	
	
	function saveEducation($workProfileId=0)
	{
		
		$cat['label'] = $this->lang->language;
		$educationArray['educationId'] = $this->input->post('val1');
		$educationArray['workProfileId'] = $this->input->post('val2');
		$educationArray['degree'] = $this->input->post('val5');		
		$educationArray['year_from'] = $this->input->post('val3');
		$educationArray['year_to'] = $this->input->post('val8');		
		$educationArray['university'] = $this->input->post('val6');
		$educationArray['append'] = $this->input->post('val7');	
		//echo '<pre />';print_r($educationArray);die;
		if(isset($educationArray['year_from']) && $educationArray['year_from']!='')
		{
		
		$educationId = $this->model_workprofile->saveEducation($educationArray,$this->userId);		
			
		$editButton = '<div class="small_btn"><a class="formTip" title="Edit" onclick="EditEducation(\''.$educationArray['year_from'].'\',\''.$educationArray['year_to'].'\',\''.$educationId.'\',\''.$educationArray['university'].'\',\''.$educationArray['degree'].'\',\''.$educationId.'\')"><span><div class="cat_smll_edit_icon"></div></span></a></div>';	
		//$delButton = '<div class="small_btn"><a class="formTip" onclick="removeEducationRow(\''.$educationId.'\')"><span><div class="cat_smll_plus_icon"></div></span></a></div>';	
		
		$delButton = '<div class="small_btn"><a class="formTip" title="Delete" onclick="deleteTabelRow(\''.$this->tableprofileEdu.'\',\'educationId\',\''.$educationId.'\',\'\',\'\',\'#removeID_\',\'\',\'\',0,\'\',1)"><span><div class="cat_smll_plus_icon"></div></span></a></div>';
		//$categoryTitleToEdit = $catArray['categoryTitle'];
		$attr = array("onclick"=>"removeCategoryRow('$educationId','0')");
		
		if(isset($educationArray['university']) && $educationArray['university']!='')
			$newUniversity = $educationArray['university'];
		else 
			$newUniversity = '&nbsp;';
			
		if(isset($educationArray['degree']) && $educationArray['degree']!='')
			$newDegree = $educationArray['degree'];
		else 
			$newDegree = '&nbsp;';
			
		$newCatRecord = '';
		
		if($educationArray['educationId'] ==0)
			$newCatRecord = '<li id="removeID_'.$educationId.'">';
										
			$newCatRecord .= '<div class="cell pro_li_content_wp extract_content_bg_PR width_567px pt5" >
								<div class="cell width70px  ml40">
								 '.$educationArray['year_from'].'
								  </div>
								  <div class="cell width70px">
								 '.$educationArray['year_to'].'
								  </div>
								  <div class="cell width170px">
								  '.$newUniversity.'
								  </div>
								  <div class="cell width170px">
								  '.$newDegree.'
								  </div>
								<div class="pro_btns">'.$delButton.$editButton.'</div>
								<input type="hidden" id="useDelId_'.$educationId.'" value="'.$educationId.'" />
							</div>';
									
		if($educationArray['educationId'] ==0)
			$newCatRecord .= '</li></div>';
		
		echo $newCatRecord;												
		}
	}
	
	function visaDetailSection($workProfileId=0)
	{
		$visaType['label']=$this->lang->language;
		$visaType['workProfileId'] = $workProfileId;
		$visaType['visaTypeValues'] = $this->model_workprofile->getVisaType($workProfileId);
		$visaType['countVisaType'] = count($visaType['visaTypeValues']);
		$this->load->view('workProfile/add_visa_type',$visaType);
	}
		
	function visaTypeList($workProfileId=0)
	{
		$visaType['label'] = $this->lang->language;
		
		$visaType['workProfileId'] = $workProfileId;
		
		$visaType['visaTypeValues'] = $this->model_workprofile->getVisaType($workProfileId);
		
		$visaType['countVisaType'] = count($visaType['visaTypeValues']);				
		
		$this->load->view('workProfile/list_visa_type',$visaType);
	}
	
	function saveVisaType($workProfileId=0)
	{
		
		$cat['label'] = $this->lang->language;
		$visaTypeArray['visaId'] = $this->input->post('val1');
		$visaTypeArray['workProfileId'] = $this->input->post('val2');
		$visaTypeArray['countryId'] = $this->input->post('val3');		
		$visaTypeArray['visaType'] = $this->input->post('val5');		
		
		$visaTypeArray['append'] = $this->input->post('val6');	
		
		if(isset($visaTypeArray['countryId']) && $visaTypeArray['countryId']!='')
		{
		
		$visaTypeId = $this->model_workprofile->saveVisaType($visaTypeArray,$this->userId);		
			
		$editButton = '<div class="small_btn"><a class="formTip" title="Edit" onclick="EditVisaType(\''.$visaTypeId.'\',\''.$visaTypeArray['countryId'].'\',\''.$visaTypeArray['visaType'].'\',\''.$visaTypeId.'\')"><span><div class="cat_smll_edit_icon"></div></span></a></div>';	
		
		//$editButton = '<div class="small_btn"><a class="formTip" title="'.$this->config->item('edit').'" onclick="EditEducation(\''.$educationArray['year_from'].'\',\''.$educationArray['year_to'].'\',\''.$educationId.'\',\''.$educationArray['university'].'\',\''.$educationArray['degree'].'\',\''.$educationId.'\')"><span><div class="cat_smll_edit_icon"></div></span></a></div>';	
		
		$qoutes= "''";
		$delButton = '<div class="small_btn"><a class="formTip" title="Delete" onclick="deleteTabelRow(\''.$this->tableprofileVisa.'\',\'visaId\',\''.$visaTypeId.'\',\'\',\'\',\'#removeVisaID_\',\'\',\'\',0,\'\',1)"><span><div class="cat_smll_plus_icon"></div></span></a></div>';
		
		//$categoryTitleToEdit = $catArray['categoryTitle'];
		$attr = array("onclick"=>"removeVisaTypeRow('$visaTypeId','0')");
		
		if(isset($visaTypeArray['countryId']) && $visaTypeArray['countryId']!='')
			$newCountryId = getCountry($visaTypeArray['countryId']);
		else 
			$newCountryId = '&nbsp;';
			
		if(isset($visaTypeArray['visaType']) && $visaTypeArray['visaType']!='')
			$newVisaType = $visaTypeArray['visaType'];
		else 
			$newVisaType = '&nbsp;';
			
		$newVisaTypeRecord = '';
		
		if($visaTypeArray['visaId'] ==0)
			$newVisaTypeRecord = '<li id="removeVisaID_'.$visaTypeId.'">';
										
			$newVisaTypeRecord .= '<div class="cell pro_li_content_wp extract_content_bg_PR width_567px pt5" >
			                      <div class="cell width228px  ml40">
								  '.$newCountryId.'
								  </div>
								  <div class="cell width174px">
								  '.$newVisaType.'
								  </div>
								  <div class="pro_btns width_216 fr mr12">'.$delButton.$editButton.'</div>
								  <input type="hidden" id="useDelId_'.$visaTypeId.'" value="'.$visaTypeId.'" /></div>';
									
		if($visaTypeArray['visaId'] ==0)
			$newVisaTypeRecord .= '</li></div>';
		
		echo $newVisaTypeRecord;												
		}
	}
/*
	 *********** All functionalities related with Employment History ***********
*/		
	function indexEmpHistory()
	{
		$isAjaxHit=$this->input->post('ajaxHit');
		$WorkProfileId=$this->input->post('WorkProfileId');
		$EmpHistoryId=$this->input->post('EmpHistoryId');
		$Action=$this->input->post('Action');
		$data  = $this->model_workprofile->index($EmpHistoryId);
		$data['label']= $this->lang->language;
		$data['WorkProfileId'] = $WorkProfileId;
		$data['EmpHistoryId'] = $EmpHistoryId;
		$data['Action'] = $Action;

		$this->load->view('workprofile/indexEmpHistory',$data);		
	}

   /*
    * Function to get Employe History Listing
    * 
    * 
    * 
    * */

	function empHistoryListing()
	{
		$data['label']= $this->lang->language;
		$data['Action'] = 'Default';
		$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
		//print_r($userWorkProfileID);
		if(empty($userWorkProfileID))  
		{
			$Upload_File_Name['error'] = 'Please Fill the Personal Information First';
			set_global_messages($Upload_File_Name['error'], 'error');
			//$this->workprofileMsg = '';
			redirect('workprofile/workProfileForm');
		}
		else {
			$data['workProfileId'] = $userWorkProfileID[0]->workProfileId;
			$data['values'] = $this->lib_work_emp_hist->getValuesFromDB($data['workProfileId']);
			//echo '<pre />';print_r($data['values']);
			$position = $this->model_workprofile->getPostion('profileEmpHistory',$data['workProfileId'] );		
			$data['position'] = $position;
			$data['mode'] = 'new';
			$data['countries'] = getCountryList();
			$data['tillDate'] = '';
			$data['checkTillDate'] = $this->model_workprofile->checkTillDate($this->userId);
			//$this->template->load('template','workProfile/empHistoryListing',$data);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true,
							'helpSection'=>'employmentHistory'
				  );
			$leftView='dashboard/help_workprofile_sections';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workProfile/empHistoryListing',$data);
		}
	}

	function addMoreEmpHistory($empHistId=0){
		
			
		$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
			if(count($userWorkProfileID)==0) 
			{
				$workProfileId = 0; 
			}
			else 
			{
				$workProfileId = $userWorkProfileID[0]->workProfileId;
			}

	$data['label']=$this->lang->language;
	if($this->input->post('submit') =='Save')
	{
	$errorConfig = array(
		  array(
				 'field'   => 'compName',
				 'label'   =>  $data['label']['compName'],
				 'rules'   => 'trim|required|xss_clean'
			),
		/*array(
			 'field'   => 'empStartDate',
			 'label'   =>  $data['label']['empStartDate'],
			 'rules'   => 'trim|required|xss_clean'
		  ),
		 */
			array(
				 'field'   => 'empDesignation',
				 'label'   =>  $data['label']['empDesignation'],
				 'rules'   => 'trim|required|xss_clean'
			)
		  );
		
		/*
		if($this->input->post('empEndDate') != '' && $this->input->post('empEndDate') != 0)
		{
			$new_array = array( array(
						'field'   => 'empEndDate',
						'label'   =>  $data['label']['empEndDate'],
						'rules'   => 'trim|required|xss_clean'
					  ),);
			
		}else
		{
			$new_array = array( array(
						'field'   => 'tillDate',
						'label'   =>  $data['label']['tillDate'],
						'rules'   => 'trim|required|xss_clean|callback_verify_checkbox'
					  ),);
		}
		$errorConfig = array_merge($new_array,$errorConfig);
		*/

		$this->form_validation->set_rules($errorConfig); //Setting rules for validation
		$this->form_validation->set_error_delimiters('<span class="required validation_error">', '</span>');

		$dataSetValue = $this->lib_work_emp_hist->setValues($this->input->post());
		$data= $this->lib_work_emp_hist->getValues();
		

		unset($data['empStatus']);
		unset($data['empPublish']);
		
		$data['compCountry'] = $this->input->post('compCountry');
		
		if($this->input->post('tillDate')=='accept')
			$data['empEndDate']=0;

		if($this->form_validation->run())
		{
			//echo '<pre /> Data';print_r($data);
			$position = $this->model_workprofile->getPostion('profileEmpHistory',$workProfileId);
			if($data['empHistId'] > 0 ){
			
				$this->lib_work_emp_hist->save($this->tableProfileEmpHistory, $data);
			}
			else
			{
				unset($data['empHistId']);
				$data['position'] = $position+1;

				$this->lib_work_emp_hist->save($this->tableProfileEmpHistory, $data);
			}
			//$workProfileId = $this->model_workprofile->updateEmpHistory($workProfileId);
			$msg = 'Employment History have been saved successfully.';
			set_global_messages($msg, 'success');
			redirect('workprofile/empHistoryListing');
		}else
		{
			if(validation_errors())
			{
				$msg = array('errors' => validation_errors());				
			}
		}
	}

		//echo 'emp history';print($this->lib_work_emp_hist->keys['empAchivments']);
	redirect('workprofile/empHistoryListing');
		
		
	}

	function deleteEmpHistory()
	{
		if($this->input->post('empIdForSwap')==1)
		{
			$currentId =  decode($this->input->post('currentId'));
			$currentPos =  $this->input->post('currentPosition');
			$swapId =  decode($this->input->post('swapId'));
			$swapPos =  $this->input->post('swapPosition');
			$getPostion = $this->model_workprofile->shiftRecord($this->tableProfileEmpHistory,'empHistId',$currentId,$currentPos,$swapId,$swapPos);

			redirect('workprofile/empHistoryListing');
		}

		if($this->input->post('delEmpHistId'))
		{
			$empHistId =  decode($this->input->post('delEmpHistId'));
			$userWorkProfileID  = $this->model_workprofile->deleteEmpHistory($empHistId);
			$Upload_File_Name['error'] = 'Employment History have been deleted successfully.';
			set_global_messages($Upload_File_Name['error'], 'success');
			redirect('workprofile/empHistoryListing');
		}
	}

	function referencesRecommendations(){
		$data['label']= $this->lang->language;
		$data['Action'] = 'Default';
		$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
		//print_r($userWorkProfileID);
		if(empty($userWorkProfileID))  
		{
			$Upload_File_Name['error'] = 'Please Fill the Personal Information First';
			set_global_messages($Upload_File_Name['error'], 'error');
			redirect('workprofile/workProfileForm');
		} else {
			$data['workProfileId'] = $userWorkProfileID[0]->workProfileId;
			$data['values'] = $this->lib_recommandations->getValuesFromDB($data['workProfileId']);
			$data['countries'] = getCountryList();
			$data['mode'] = 'new';
			$position = $this->model_workprofile->getPostion('profileRecommendation',$data['workProfileId']);
			$data['position'] = $position;
			//$this->template->load('template','workProfile/empReferencesRecommendations',$data);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true,
							'helpSection'=>'references'
				  );
			$leftView='dashboard/help_workprofile_sections';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workProfile/empReferencesRecommendations',$data);
			
			
		}
	}

	function addMoreReferencesRecommendations()
	{
	$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
	if(count($userWorkProfileID)==0) 
	{
		$workProfileId = 0; 
	}else {
		$workProfileId = $userWorkProfileID[0]->workProfileId;
	}

	$data['label']=$this->lang->language;	

	if($this->input->post('submit') =='Save'){
		
		$errorConfig = array(
               array(
                     'field'   => 'refFName',
                     'label'   =>  $data['label']['refFName'],
                     'rules'   => 'trim|required|xss_clean'
                  ),
				array(
                     'field'   => 'refLName',
                     'label'   =>  $data['label']['refLName'],
                     'rules'   => 'trim|required|xss_clean'
                  ),
				array(
                     'field'   => 'refCompName',
                     'label'   =>  $data['label']['refCompName'],
                     'rules'   => 'trim|xss_clean'
                  ),
				);
		$this->form_validation->set_rules($errorConfig); //Setting rules for validation
		$this->form_validation->set_error_delimiters('<span class="required validation_error">', '</span>');
		$dataSetValue = $this->lib_recommandations->setValues($this->input->post());
		$data= $this->lib_recommandations->getValues();

		if($this->form_validation->run())
		{
			
			$position = $this->model_workprofile->getPostion('profileRecommendation',$workProfileId);
			if($data['refId'] > 0 ||!(isset($data['refId'])) || $data['refId']==''){
				$this->lib_recommandations->save($this->tableProfileRecommendation, $data);
			}
			else
			{
				unset($data['refId']);
				$data['position'] = $position+1;
				$this->lib_recommandations->save($this->tableProfileRecommendation, $data);
			}
			$msg = 'References & Recommendations have been saved successfully.';
			set_global_messages($msg, 'success');
			redirect('workprofile/referencesRecommendations');
		}else
		{
			//echo "else<pre />"; print_r($_POST); die;
			if(validation_errors())
			{
				$msg = array('errors' => validation_errors());
				set_global_messages($msg, 'success');
			redirect('workprofile/referencesRecommendations');				
			}
		}
	}
	$this->lib_recommandations->keys['mode'] = 'new';
		

		$this->lib_recommandations->keys['label']= $this->lang->language;
		$this->lib_recommandations->keys['workProfileId']= $workProfileId;
		$this->lib_recommandations->keys['countries'] = getCountryList();
		redirect('workprofile/referencesRecommendations');
	}

	function deleteReferencesRecommendations()
	{
		if($this->input->post('refIdForSwap')==1)
		{
			$currentId =  decode($this->input->post('currentId'));
			$currentPos =  $this->input->post('currentPosition');
			$swapId =  decode($this->input->post('swapId'));
			$swapPos =  $this->input->post('swapPosition');
			$getPostion = $this->model_workprofile->shiftRecord('profileRecommendation','refId',$currentId,$currentPos,$swapId,$swapPos);

			redirect('workprofile/referencesRecommendations');
		}
		
		if($this->input->post('delRefId'))
		{
			$refId =  decode($this->input->post('delRefId'));
			$userWorkProfileID  = $this->model_workprofile->deleteReferencesRecommendations($refId);
			$Upload_File_Name['error'] = 'References & Recommendations have been deleted successfully.';
			set_global_messages($Upload_File_Name['error'], 'success');
			redirect('workprofile/referencesRecommendations');
		}
	}

	/*
	 *********** All functionalities related with Social Media Links ***********
	*/
	function indexSocialLink()
	{		
		$isAjaxHit = $this->input->post('ajaxHit');
		$WorkProfileId = $this->input->post('WorkProfileId');		
		$Action = $this->input->post('Action');
		$data  = $this->model_workprofile->index($profileSocialLinkId);		
		$data['label']= $this->lang->language;
		$data['WorkProfileId'] = $WorkProfileId;
		$data['profileSocialLinkId'] = $profileSocialLinkId;
		$data['Action'] = $Action;
		//$this->template->load('template','workprofile/index',$data);
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_workprofile';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workProfile/index',$data);		
	}
	/**
		* showSocialMediaLinks method fetches the records form Work Profile using model function
		* giving the values in the options array priority.
		*
		* @param int $workProfileId
		* Display the loaded the template with view loaded with data in it
	*/

	function showSocialMediaLinks($workProfileId=0)	
	{
		$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
		
		if(count($userWorkProfileID)==0) 
			{
				$workProfileId = 0; 
			}
			else 
			{
				$workProfileId = $userWorkProfileID[0]->workProfileId;
			}
		$data['workProfileId'] = $workProfileId;
		$data['socialLinkType'] = '';
		$data['socialLink'] = '';

		$data['socialMediaIconList'] = getIconList();
		
		$data['mode'] = 'new';
		
		
		$data['label']= $this->lang->language;
		
		if(empty($userWorkProfileID))  
		{
			$msg = 'Please Fill the Personal Information First';
			set_global_messages($msg, 'error');
			redirect('workprofile/workProfileForm');
		}
		else {
			
			$data['values'] = $this->lib_social_media->getValuesFromDB($this->userId);
			//$this->template->load('template','workProfile/show_socialmedialinks',$data);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_workprofile';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workProfile/show_socialmedialinks',$data);	
		}
	}

	/**
		* Insert/Update a new row into the specified database table from the common function
		* @access public
	*/

	function addMoreSocialLinks(){

	$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
	
	if(count($userWorkProfileID)==0) 
	{
		$workProfileId = 0; 
	}
	else 
	{
		$workProfileId = $userWorkProfileID[0]->workProfileId;
	}

	$profileSocialLinkId = $this->uri->segment(4);

	$data['label']=$this->lang->language;

	$data['socialLinkType'] = '';
	$data['socialLink'] = '';

	if($this->input->post('save') =='Save'){

	$errorConfig = array(
				array(
                     'field'   => 'socialLink',
                     'label'   =>  $data['label']['socialLink'],
                     'rules'   => 'trim|required|xss_clean'
                  ),
				array(
                     'field'   => 'profileSocialLinkType',
                     'label'   =>  $data['label']['socialLinkType'],
                     'rules'   => 'trim|required|xss_clean'
                  ),);
		$this->form_validation->set_rules($errorConfig); //Setting rules for validation
		$this->form_validation->set_error_delimiters('<span class="required validation_error">', '</span>');

		$dataSetValue = $this->lib_social_media->setValues($this->input->post());
		$data= $this->lib_social_media->getValues();

		if($this->form_validation->run())
		{
			$position = $this->model_workprofile->getPostion('profileSocialLink',$workProfileId);
			unset($data['profileSocialMediaPath']);
			unset($data['profileSocialMediaName']);
			unset($data['profileSocialMediaId']);

			if($data['profileSocialLinkId'] > 0 ){
				$data['socialLinkDateModified'] = date("Y-m-d H:i:s");
				unset($data['socialLinkDateCreated']);
				unset($data['position']);
				
				$this->lib_social_media->save($this->tableProfileSocialLink, $data);
			} else	{
				$data['socialLinkDateCreated'] = date("Y-m-d H:i:s");
				unset($data['socialLinkDateModified']);
				unset($data['profileSocialLinkId']);
				$data['position'] = $position+1;
				$this->lib_social_media->save($this->tableProfileSocialLink, $data);
			}
			$msg = 'Social Media Links have been saved successfully.';
			set_global_messages($msg, 'success');
			redirect('workprofile/showSocialMediaLinks');
		}else
		{
			$data['socialLinkType'] = $this->input->post('socialLinkType');
			$data['socialLink'] = $this->input->post('socialLink');

			if(validation_errors())
			{
				$msg = array('errors' => validation_errors());				
			}
		}
	}
	$this->lib_social_media->keys['label']= $this->lang->language;
	
	$profileSocialLinkId = $this->input->post('profileSocialLinkId');

	if($profileSocialLinkId > 0){
		$data = $this->lib_social_media->getValueToUpdate($profileSocialLinkId);
		$this->lib_social_media->keys['mode'] = 'edit';
	}else
	{
		$this->lib_social_media->keys['mode'] = 'new';
	}
	$this->lib_social_media->keys['workProfileId'] = $workProfileId;
	$this->lib_social_media->keys['socialMediaIconList'] = getIconList();

	//$this->template->load('template','workProfile/add_more_socialmedialink',$this->lib_social_media->keys);
	$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_workprofile';
			$this->lib_social_media->keys['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workProfile/add_more_socialmedialink',$this->lib_social_media->keys);
	}

	function deleteSocialLink()	{

		if($this->input->post('profileSocialLinkIdForSwap')==1)
		{
			$currentId =  decode($this->input->post('currentId'));
			$currentPos =  $this->input->post('currentPosition');
			$swapId =  decode($this->input->post('swapId'));
			$swapPos =  $this->input->post('swapPosition');
			$getPostion = $this->model_workprofile->shiftRecord($this->tableProfileSocialLink,'profileSocialLinkId',$currentId,$currentPos,$swapId,$swapPos);
			redirect('workprofile/showSocialMediaLinks');
		}
		if($this->input->post('delProfileSocialLinkId'))
		{
			$profileSocialLinkId =  decode($this->input->post('delProfileSocialLinkId'));

			$userWorkProfileID  = $this->model_workprofile->deleteSocialLink($profileSocialLinkId);
			$Upload_File_Name['error'] = 'Social Link have been deleted successfully.';
			set_global_messages($Upload_File_Name['error'], 'success');
			redirect('workprofile/showSocialMediaLinks');
		}
	}

	/**
	CallBack function To validate Checkbox
	**/
	function verify_checkbox($str) {
        if($str !== 'yes') {
            $this->validation->set_message('verify_checkbox', 'zomg error!');
            return false;
        } else {
            return true;
        }
    }

	/***
	Generates the Country DropDown
	File:- workProfile.js / workProfile_form 	
	***/
	function getCountryList($visaCountId)
	{
		$countries = getCountryList();

		$html = '';
		$html.= "<select name='visaCountry[".$visaCountId."]' id='visaCountry_".$visaCountId."' onclick='selectBox();'>";
		foreach($countries as $c){
		$html.="<option value='".$c."'>".$c."</option>";
		}
		$html.= "</select>";
		$html.=" <script>selectBox();</script>";
		echo $html;
	}
	/***
	Funcation to Get the Listing of years Starting From 1962 to Current Year
	File:- workProfile.js / workProfile_form 
	***/

	function getYear($education_count)
	{
		$year = array();
		for($i=1962;$i <= date("Y");$i++)
		{
			$year[$i] = $i;
		}
		$html = '';
		$html.= "<select onclick='selectBox()' id='educationYear_".$education_count."' name='educationYear[".$education_count."]'><option value=''>Select Year</option>";
		foreach($year as $y){
		$html.="<option value='".$y."'>".$y."</option>";
		}
		$html.= "</select>";
		$html.=" <script>selectBox();</script>";
		echo $html;
	}
	
	
	function education_insert()
	{
		$data['label']=$this->lang->language;
		$this->load->view('workProfile/add_education',$data);
	}
	
	function education_edit()
	{
		$data['label']=$this->lang->language;
		$this->load->view('workProfile/add_education',$data);
	}
	
	function socialMedia($workProfileId)
	{
	 $this->userId = $this->isLoginUser();
	 
	 //Redirect if user is trying to access post of another user
		if(isset($workProfileId) && $workProfileId >0 && isset($this->userId)){
			$userDataWhere = array('workProfileId'=>$workProfileId,'tdsUid'=>$this->userId);
			checkUsersProjects('WorkProfile',$userDataWhere);
		}	
			
	 $userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
	
	if(count($userWorkProfileID)==0) 
	{
		$workProfileId = 0; 
	}
	else 
	{
		$workProfileId = $userWorkProfileID[0]->workProfileId;
	}
		$checkForSetProfile =  $this->model_workprofile->checkForSetProfile($this->userId);
		
		if($checkForSetProfile == 0){
			//$this->template->load('template','workProfile/workprofileDummyNew',$this->data); 
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_workprofile';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workProfile/workprofileDummyNew',$this->data);
		}
		else {
			
			$currentWorkProfileId = $checkForSetProfile;
		}
		$whereField=array(
					'workProfileId'=>$currentWorkProfileId
			);
		
		$additionalInfoData['additionalInfoSection']=array('addInfoSocialMediaPanel');
		//$additionalInfoData['tableId']=$this->tableProfileSocialLink;
		$additionalInfoData['entityId'] = $additionalInfoData['tableId'] = getMasterTableRecord($this->tabelWorkprofile);
		$additionalInfoData['sectionheading'] = $this->lang->line('socialLinks');
		$additionalInfoData['elementId'] = $additionalInfoData['recordId'] = $workProfileId;
		$additionalInfoData['label'] = $this->lang->language;
		$additionalInfoData['workProfileId'] = $workProfileId;
		
		$additionalInfoData['WorkProfileEducation'] = $this->model_common->getDataFromTabel('WorkProfileEducation','year_from,year_to,university,degree',$whereField);
		$additionalInfoData['WorkProfileVisa'] = $this->model_common->getDataFromTabel('WorkProfileVisa','countryId,visaType',$whereField);
		$additionalInfoData['WorkEmpHistory'] = $this->lib_work_emp_hist->getValuesFromDB($currentWorkProfileId);
		$additionalInfoData['WorkRecommendation'] = $this->lib_recommandations->getValuesFromDB($currentWorkProfileId);
		$additionalInfoData['WorkSocialMedia'] = $this->lib_social_media->getValuesFromDB($this->userId);
		$additionalInfoData['header']=$this->load->view('workProfile/navigationMenu',$additionalInfoData, true);
		//$this->template->load('template','additionalInfo/additional_info',$additionalInfoData);
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true,
							'helpSection'=>'mediaLinks'
				  );
			$leftView='dashboard/help_workprofile_sections';
			$additionalInfoData['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','additionalInfo/additional_info',$additionalInfoData);
		
		}
		
	/*generate profile pdf */		
	function pdf_generate($tokenUserID=FALSE)
	{	
		if($tokenUserID===FALSE) {
			$checkForSetProfile =  $this->model_workprofile->checkForSetProfile($this->userId);
			$currentWorkProfileId = $checkForSetProfile;
			$whereField=array(
						'workProfileId'=>$currentWorkProfileId
				);
		} else {
			
			$viewInfo = decode($tokenUserID);
			$userInfo = explode('-',$viewInfo);
			$dataUserId = $userInfo[0];
			
			$checkForSetProfile =  $this->model_workprofile->checkForSetProfile($dataUserId);
			$currentWorkProfileId = $checkForSetProfile;
			$whereField=array(
						'workProfileId'=>$currentWorkProfileId
				);
		}
		
		$data['WorkProfileVisa'] = $this->model_common->getDataFromTabel('WorkProfileVisa','countryId,visaType',$whereField);
		
		//Get all visa type & visa country
		$workprovisa= $data['WorkProfileVisa'];
		
		if(!empty($workprovisa)) {
			$workProfile1 = array();
			for($i=0;$i<count($workprovisa);$i++)
			{
				$wpv = array();
				$wpv['visaType']	= $workprovisa[$i]->visaType;
				$wpv['visaCountry']	= getCountry($workprovisa[$i]->countryId);
				$workProfile1[]=$wpv;
				
			}
			$profileData['visas']=$workProfile1;
		} else {
			$profileData['visas']='';
		}
		//Get all education details
		$data['education'] = $this->model_common->getDataFromTabel('WorkProfileEducation','year_from,year_to,university,degree',$whereField);
		
		//Get Employment history details
		$data['WorkEmpHistory'] = $this->model_workprofile->employeHistoryRecordSet($currentWorkProfileId);
		//$data['WorkEmpHistory'] = $this->lib_work_emp_hist->getValuesFromDB($currentWorkProfileId);
		
		//Get Users Refrance
		$data['WorkRefrance'] = $this->lib_recommandations->getValuesFromDB($currentWorkProfileId);
		
		//Get Users Workprofile listings
		$data['workProfile']=$this->model_workprofile->getWorkProfileDetails($currentWorkProfileId);
		
		//Get Users Recommandation listings
		$data['WorkRecommendation'] = $this->model_workprofile->getUsersRecommendation($this->userId);
		
		//Get all work history of user
		$wh=$data['WorkEmpHistory'];
		//print_r($wh);die;
		$workProfile = array();
		for($i=0;$i<count($wh);$i++)
		{
			$dd = array();
			//$startDate = $wh[$i]->empStartDate;
			//if($wh[$i]->empEndDate==0){
				//$wh[$i]->empEndDate = 'Till Date';
			//}else{
				//$endDate = date("F Y", strtotime($wh[$i]->empEndDate));
			//	$wh[$i]->empEndDate;
			//}
			
			$dd['empStartDate'] 	= $wh[$i]->empStartDate;;
			$dd['empEndDate']		= $wh[$i]->empEndDate;
			$dd['empDesignation']	= $wh[$i]->empDesignation;
			$dd['compName']			= $wh[$i]->compName;
			$dd['compCity']			= $wh[$i]->compCity;
			$dd['empAchivments']	= $wh[$i]->empAchivments;
			
			$workProfile[] = $dd;
		}
		
		$profileData['proval']=$data['workProfile'];
		
		$profileData['educations']=$data['education'];
		$profileData['workHistory']=$workProfile;
		$profileData['refrance']=$data['WorkRefrance'];
		$profileData['recommandation']=$data['WorkRecommendation'];
		//$profileData['userInfo'] = $userdata;
		$this->load->view('profilePdf',$profileData);
	}
	/*Function to load how to publish popup */
	function howToPublish()
	{
		$this->load->view('workprofileHowToPublish') ;				
	}   
	
	
}
?>
