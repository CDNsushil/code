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
	private $tableprofileLanguage = 'WorkProfileLanguage';
	private $tableProfileMedia = 'ProfileMedia';
	private $tableWorkProfileLocation = 'WorkProfileLocation';

	function __construct(){
		$load = array(
				'model'		=> 'workprofile/model_workprofile + workprofile/model_workshowcase + membershipcart/model_membershipcart',
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
	
	function index() {
		$this->yourdetails();
	}

	function index_old()
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

			redirect('workprofile/employment');
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
	
	//-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage workprofile and portfolio selection
     * @access: public
     * @return void
     */ 
    public function setupaction() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
		
        // set data for upcoming form
		$this->wizardheadingtext(1); // set navigation bar heading
        $this->data['profileMediaData'] = (isset($profileMediaData)) ? $profileMediaData : '';
        $this->new_version->load('new_version','workProfile/wizardform/workprofile_next_step_options',$this->data);
    }
    
	//---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to manage next selected option
    * @return: void
    */ 
    function setworkprofilenextstep() {
        
        // set default redirect url
        $redirectUrl = base_url(lang().'/workprofile/setupaction');
        
        // get post form data
        $postData = $this->input->post();
       
        if(!empty($postData) && !empty($postData['wpActionType'])) {
          
			// manage redirect url
			$redirectUrl = base_url(lang().'/workprofile/setportfoliomediatype');
			if($postData['wpActionType'] == 1) {
				$redirectUrl = base_url(lang().'/workprofile/yourdetails');
			}
        }
        redirectPage($redirectUrl);
    }
	
	 
	
	 //----------------------------------------------------------------------
	
	 /*
     * @description: This function is used to manage donation
     * @access: public
     * @return void
     */ 
    public function yourdetails() {

	     //add full screen js
        $this->head->add_css($this->config->item('template_new_js').'jcrop/jquery.Jcrop.css');
        $this->head->add_js($this->config->item('template_new_js').'jcrop/jquery.Jcrop.js',NULL,'lastAdd');
     
		$userId = $this->userId;
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
		//call method for plupload css and js add
        $this->_pluploadjsandcss();
        // set data for upcoming form
        $this->wizardheadingtext(); // set navigation bar heading
        $profileImagePath  = $this->mediaPath;
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['dirUploadMedia']       =  $profileImagePath;
        $this->data['workProfileId']        =  $workProfileId;
        $this->data['userId']               =  $userId;
        $this->data['s1menu']               = 'TabbedPanelsTabSelected';
        $this->data['step1DetailsMenu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'workProfile/wizardform/your_details_menus';
        $this->data['subInnerPage']         = 'workProfile/wizardform/profile_image';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
    
    //----------------------------------------------------------------------
    
    /*
    *  @access: private
    *  @description: This method is use to manage wizard heading text
    *  @auther: tosif qureshi
    *  @return: string
    */ 
    public function wizardheadingtext($headingType=0) {
		// get session value of edit workprofile mode
		$isEditWP = $this->session->userdata('isEditWPMedia');
		$wpHeading = $this->lang->line('createYourWorkprofile'); 
		$editwpHeading = $this->lang->line('editYourWorkprofile');
		if($headingType == 1) { // set for Work Profile
			$wpHeading = $this->lang->line('createYourWorkprofileNPortfolio');
		} else if($headingType == 2) { // set for Portfolio
			$wpHeading = $this->lang->line('createYourPortfolio');
			$editwpHeading = $this->lang->line('editYourPortfolio');
		}
		$this->data['packagestageheading'] = (!empty($isEditWP)) ? $editwpHeading : $wpHeading;    
	} 
	
	  //------------------------------------------------------------------------
    
    /*
    * @Description: This method is used to added plupload require js and css
    * @access: private
    * @return: void
    * @author: lokendra
    */
    
    private function _pluploadjsandcss() {
        $this->head->add_css($this->config->item('system_css').'upload_file.css');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js'); 
    }
    
	//-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to set workprofile image
    * @access: public
    * @return: void
    */
     
    public function setprofileimage($arg_list) {
		
        $userId = $this->isLoginUser();
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/workprofile/yourdetails');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedWorkprofile');
        if(!empty($postData)) {
            $browseId      = $postData['browseId'];
            $isProfileImg  = false;
            //--------media data prepair for inserting------//
            $media_fileName = $this->input->post('fileName'.$browseId);
            // update user's showcase type id
            if(!empty($postData['isProfileImage'])) {
                $UserWorkprofileData = array('fileId'=>0,'isProfileImage'=>'t');
                $isProfileImg = true;
            } else {
				//--------media data prepair for inserting------//
				$browseId         =  $this->input->post('browseId');
				$projId           =  $this->input->post('projId');
				$isFile           =  false;
				$media_fileName   =  $this->input->post('fileName'.$browseId);
				$mediaFileData    =  array();
				$imagePath        = $this->mediaPath;
				
				if($media_fileName && strlen($media_fileName)>3) {
					$isFile              =   true;
					$fileType            =   getFileType($media_fileName);
					$isExternalFile      =   false;
					$mediaFileData       =   array(
											'filePath'      =>  $imagePath,
											'fileName'      =>  $media_fileName,
											'fileType'      =>  $fileType,
											'tdsUid'        =>  $this->userId,
											'isExternal'    =>  'f',
											'fileSize'      =>  $this->input->post('fileSize'.$browseId),
											'rawFileName'   =>  $this->input->post('fileInput'.$browseId),
											'jobStsatus'    =>  'UPLOADING'
										);
				}
			
				if($isFile) {
					$fileId = $this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);
				} else {
					$fileId=0;
				}

				$UserWorkprofileData = array('fileId'=>$fileId,'isProfileImage'=>'f');
            }
            
            // get blog ts product id
			$tsProductId     = $this->config->item('tsProductId_Workprofile');
			// get blog container id
			$containerRes = $this->model_common->getDataFromTabel('UserContainer', 'userContainerId,elementId',  array('tsProductId'=>$tsProductId,'tdsUid'=>$userId));
			// get user container id
			$userContainerId = (isset($containerRes[0]->userContainerId))?$containerRes[0]->userContainerId:0;
			// get blog element id
			$elementId = (isset($containerRes[0]->elementId))?$containerRes[0]->elementId:0;
            // get workprofile id
            $workprofileId = $this->getworkprofileid();
            
            // set update data fields
            $isHideImageFromOnlineWP = $this->input->post('isHideImageFromOnlineWP');
            $isHideImageFromCV = $this->input->post('isHideImageFromCV');
            $UserWorkprofileData['isHideImageFromOnlineWP'] = (!empty($isHideImageFromOnlineWP)) ? 't' : 'f';
            $UserWorkprofileData['isHideImageFromCV']       = (!empty($isHideImageFromCV)) ? 't' : 'f';
            
            if(!empty($workprofileId) && $workprofileId > 0) {
				
				$this->model_common->editDataFromTabel($this->tabelWorkprofile, $UserWorkprofileData, 'tdsUid', $this->userId);
			} else {
				
				$UserWorkprofileData['userContainerId'] = $userContainerId;
				$UserWorkprofileData['tdsUid'] = $userId;
				$UserWorkprofileData['dateCreated'] = date('Y-m-d h:i:g');
		
				// add workprofile data
				$workprofileId = $this->model_common->addDataIntoTabel($this->tabelWorkprofile, $UserWorkprofileData);
				$entityId = getMasterTableRecord($this->tabelWorkprofile);
				// update blog element data in container tbl
				if($elementId == 0 && $userContainerId > 0) {
					$this->model_common->editDataFromTabel('UserContainer', array('entityId'=>$entityId,'elementId'=>$workprofileId,'startDate'=>date('Y-m-d h:i:g')), 'userContainerId', $userContainerId);
				}
			}
            
            $reditectUrl = base_url(lang().'/workprofile/contactdetails');
            $type = 'success';
            $msg = $this->lang->line('successUpdatedWorkprofile');
        }
        $returnData = array('nextUrl'=>$reditectUrl,'isProfileImg'=>$isProfileImg);
        echo json_encode($returnData);
    }
    
    //-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to get workprofile id
    * @access: public
    * @return: int
    */
    private function getworkprofileid() {
		
		// get workprofile data
		$userWorkProfile = $this->model_workprofile->getWorkProfileID($this->userId);
		if(isset($userWorkProfile[0]->workProfileId) && $userWorkProfile[0]->workProfileId > 0) {
			$workProfileId = $userWorkProfile[0]->workProfileId;
			// set session value of edit workprofile
			$this->session->set_userdata('isWorkprofileEdit',1);
		} else {
			$workProfileId = 0; 
		}
		return $workProfileId;
	} 
	
	 //----------------------------------------------------------------------
	
	 /*
     * @description: This function is used to manage contact details
     * @access: public
     * @return void
     */ 
    public function contactdetails() {
     
		$userId = $this->userId;
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
		// get users's profile data
		$userProfileData = $this->model_common->getUserProfileData($userId);
        // set data for upcoming form
        $this->wizardheadingtext(); // set navigation bar heading
        $profileImagePath  = $this->mediaPath;
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['userProfileData']      = (isset($userProfileData[0])) ? $userProfileData[0]:'';
        $this->data['workProfileId']        = $workProfileId;
        $this->data['userId']               = $userId;
        $this->data['s1menu']               = 'TabbedPanelsTabSelected';
        $this->data['step2DetailsMenu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'workProfile/wizardform/your_details_menus';
        $this->data['subInnerPage']         = 'workProfile/wizardform/contact_details';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
	
	 /*
     * @description: This function is used to save contact details
     * @access: public
     * @return void
     */ 
	public function setcontactdetails() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/workprofile/contactdetails');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedWorkprofile');
        // get workprofile id
		$workProfileId = $this->getworkprofileid(); 
        if(!empty($postData) && !empty($workProfileId)) {
            
            // update user's workprofile data
            $workprofileData = array(
				'profileFName'    => $postData['profileFName'],
				'profileLName'    => $postData['profileLName'],
				'profileAdd'      => $postData['profileAdd'],
				'profileStreet'   => $postData['profileStreet'],
				'profileCity'     => $postData['profileCity'],
				'profileState'    => $postData['profileState'],
				'profileZip'      => $postData['profileZip'],
				'profileEmail'    => $postData['profileEmail'],
				'profileCountry'  => $postData['profileCountry'],
				'profilePhone'    => $postData['profilePhone'],
			);
            $this->model_common->editDataFromTabel($this->tabelWorkprofile, $workprofileData, 'workProfileId', $workProfileId);
            // set mext page url
            $reditectUrl = base_url(lang().'/workprofile/personaldetails');
            $type = 'success';
            $msg = $this->lang->line('successUpdatedWorkprofile');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
	
	//----------------------------------------------------------------------
	
	 /*
     * @description: This function is used to manage contact details
     * @access: public
     * @return void
     */ 
    public function personaldetails() {
  
		$userId = $this->userId;
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
		
		// get users's profile language data
		$userProfileLanguages = $this->model_workprofile->getProfileLanguage($workProfileId);
		// get users's profile visa data
		$userProfileVisas = $this->model_workprofile->getVisaType($workProfileId);
		
        // set data for upcoming form
        $this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['userProfileLanguages'] = $userProfileLanguages;
        $this->data['userProfileVisas']     = $userProfileVisas;
        $this->data['workProfileId']        = $workProfileId;
        $this->data['userId']               = $userId;
        $this->data['s1menu']               = 'TabbedPanelsTabSelected';
        $this->data['step3DetailsMenu']     = 'TabbedPanelsTabSelected';
		$this->data['personal1menu']        = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'workProfile/wizardform/your_details_menus';
        $this->data['subInnerPage']         = 'workProfile/wizardform/personal_details_menus';
        $this->data['subInnerPage1']        = 'workProfile/wizardform/personal_details';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
    
    //----------------------------------------------------------------------
	
	 /*
     * @description: This function is used to manage profile language
     * @access: public
     * @return void
     */ 
    public function addprofilelanguage() {
		$userId = $this->userId;
		// get post values
        $postData = $this->input->post();
		$countResult = 0;
        $profileLangId = $postData['profileLangId'];
        
        // get workprofile id
		$workProfileId = $this->getworkprofileid();
        if(!empty($postData) && !empty($workProfileId)) {
            
            // add user's workprofile language data
            $workprofileLangData = array(
				'tdsUid'         => $userId,
				'workProfileId'  => $workProfileId,
				'langId'         => $postData['langId'],
				'fluencyType'    => $postData['fluencyType']
			);
			if($profileLangId > 0) {
				// update workprofile language data
				$this->model_common->editDataFromTabel($this->tableprofileLanguage, $workprofileLangData, 'profileLangId', $profileLangId);
			} else {
				// add workprofile language data
				$profileLangId = $this->model_common->addDataIntoTabel($this->tableprofileLanguage, $workprofileLangData);
			}
        }
		// prepare member html row
		$languageHtml = '';
		if($profileLangId > 0) {
            $languageHtml = $this->manageLanguageRowHtml($profileLangId,$postData);
        }
        echo json_encode(array('languageHtml'=>$languageHtml,'editId'=>$postData['profileLangId']));
	}
	
	 //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage team raw html
     * @access: private
     * @return void
     */ 
    private function manageLanguageRowHtml($profileLangId,$postData) {
        // set row bg class
        $rowBgCls = 'bg_f9f9f9';
        $rowPLCls = 'pl23';
        $divId = 'creativeTeam_'.$profileLangId;
       
        // prepare language data row  
        $languageHtml  = '';
        if($postData['profileLangId'] == 0) {
            $languageHtml .= '<li id = "'.$divId.'">';
        }
        $languageHtml .= '<span class="'.$rowBgCls.'"><span class=" fl width176 '.$rowPLCls.'">';
        $languageHtml .= getLanguage($postData['langId']).'</span>';
        $languageHtml .= $postData['fluencyType'].'<span class="red fs12 fr">';
		$languageHtml .= '<a href="javascript:void(0)" onclick="editAssociative(this)" profileLangId='.$profileLangId.' langId='.$postData['langId'].' fluencyType='.$postData['fluencyType'].'> Edit</a> / ';
		$languageHtml .= '<a href="javascript:void(0)" onclick="deleteCreativeMember('.$profileLangId.');">Delete </a>';   
        $languageHtml .= '</span></span>';
        if($postData['profileLangId'] == 0) {
            $languageHtml .= '</li>';
        }
        return $languageHtml;
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to remove profile language
     * @access: public
     * @return void
     */ 
    public function deleteprofilelanguage() {
        $profileLangId = $this->input->post('profileLangId');
        $deleted = 0;
        $countResult = 0 ;
        if($profileLangId > 0) {
            $where = array('profileLangId'=>$profileLangId);
            $this->model_common->deleteRowFromTabel($this->tableprofileLanguage, $where);
            $countResult = $this->model_common->countResult($this->tableprofileLanguage,$where,'',1);
            $deleted = 1;
        }
        echo  json_encode(array('deleted'=>$deleted, 'countResult'=>$countResult));
    }
    
    /*
     * @description: This function is used to manage profile visa
     * @access: public
     * @return void
     */ 
    public function addprofilevisas() {
		$userId = $this->userId;
		// get post values
        $postData = $this->input->post();
		$countResult = 0;
        $visaId = $postData['visaId'];
        
        // get workprofile id
		$workProfileId = $this->getworkprofileid();
        if(!empty($postData) && !empty($workProfileId)) {
            
            // add user's workprofile visa data
            $workprofileVisaData = array(
				'tdsUid'         => $userId,
				'workProfileId'  => $workProfileId,
				'countryId'      => $postData['countryId'],
				'visaType'       => $postData['visaType']
			);
			if($visaId > 0) {
				// update workprofile language data
				$this->model_common->editDataFromTabel($this->tableprofileVisa, $workprofileVisaData, 'visaId', $visaId);
			} else {
				// add workprofile language data
				$visaId = $this->model_common->addDataIntoTabel($this->tableprofileVisa, $workprofileVisaData);
			}
        }
		// prepare member html row
		$languageHtml = '';
		if($visaId > 0) {
            $languageHtml = $this->manageVisaRowHtml($visaId,$postData);
        }
        echo json_encode(array('languageHtml'=>$languageHtml,'editId'=>$postData['visaId']));
	}
	
	 //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage visa raw html
     * @access: private
     * @return void
     */ 
    private function manageVisaRowHtml($visaId,$postData) {
        // set row bg class
        $rowBgCls = 'bg_f9f9f9';
        $rowPLCls = 'pl23';
        $divId = 'profileVisa_'.$visaId;
       
        // prepare visa data row  
        $profileVisaHtml  = '';
        if($postData['visaId'] == 0) {
            $profileVisaHtml .= '<li id = "'.$divId.'">';
        }
        $profileVisaHtml .= '<span class="'.$rowBgCls.'"><span class=" fl width176 '.$rowPLCls.'">';
        $profileVisaHtml .= getCountry($postData['countryId']).'</span>';
        $profileVisaHtml .= $postData['visaType'].'<span class="red fs12 fr">';
		$profileVisaHtml .= '<a href="javascript:void(0)" onclick="editvisas(this)" visaId='.$visaId.' countryId='.$postData['countryId'].' visaType='.$postData['visaType'].'> Edit</a> / ';
		$profileVisaHtml .= '<a href="javascript:void(0)" onclick="deleteVisa('.$visaId.');">Delete </a>';   
        $profileVisaHtml .= '</span></span>';
        if($postData['visaId'] == 0) {
            $profileVisaHtml .= '</li>';
        }
        return $profileVisaHtml;
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to remove profile visa
     * @access: public
     * @return void
     */ 
    public function deleteprofilevisa() {
        $visaId = $this->input->post('visaId');
        $deleted = 0;
        $countResult = 0 ;
        if($visaId > 0) {
            $where = array('visaId'=>$visaId);
            $this->model_common->deleteRowFromTabel($this->tableprofileVisa, $where);
            $countResult = $this->model_common->countResult($this->tableprofileVisa,$where,'',1);
            $deleted = 1;
        }
        echo  json_encode(array('deleted'=>$deleted, 'countResult'=>$countResult));
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage personal national data
     * @access: public
     * @return void
     */ 
    public function setpersonaldetails() {
		
		// get workprofile id
		$workProfileId = $this->getworkprofileid();
		// get post values
        $postData = $this->input->post();
		if($workProfileId > 0 && !empty($postData['nationality'])) {
			// update workprofile language data
			$this->model_common->editDataFromTabel($this->tabelWorkprofile, array('nationality'=>$postData['nationality']), 'workProfileId', $workProfileId);
			$type = 'success';
			$msg = $this->lang->line('successUpdatedWorkprofile');
			set_global_messages($msg, $type, $is_multiple=true);
		} 

		// set mext page url
		$reditectUrl = base_url(lang().'/workprofile/personalinterests');
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
    //----------------------------------------------------------------------
	
	 /*
     * @description: This function is used to manage personal intrest details
     * @access: public
     * @return void
     */ 
    public function personalinterests() {
  
		$userId = $this->userId;
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}

        // set data for upcoming form
        $this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['workProfileId']        = $workProfileId;
        $this->data['userId']               = $userId;
        $this->data['s1menu']               = 'TabbedPanelsTabSelected';
        $this->data['step3DetailsMenu']     = 'TabbedPanelsTabSelected';
		$this->data['personal2menu']        = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'workProfile/wizardform/your_details_menus';
        $this->data['subInnerPage']         = 'workProfile/wizardform/personal_details_menus';
        $this->data['subInnerPage1']        = 'workProfile/wizardform/personal_intrests';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage personal interest data
     * @access: public
     * @return void
     */ 
    public function setpersonalinterest() {
		
		// get workprofile id
		$workProfileId = $this->getworkprofileid();
		// get post values
        $postData = $this->input->post();
        $type = 'success';
		$msg = $this->lang->line('errorUpdatedWorkprofile');
		// set mext page url
		$reditectUrl = base_url(lang().'/workprofile/personalinterests');
		if($workProfileId > 0 && !empty($postData)) {
			// add user's workprofile data
            $workprofileData = array(
				'interests'      => $postData['interests'],
				'otherInterest'  => $postData['otherInterest'],
				'maritalStatus'  => $postData['maritalStatus'],
				'dateOfBirth'    => date('d F Y',strtotime($postData['dateOfBirth'])),
			);
			// update workprofile language data
			$this->model_common->editDataFromTabel($this->tabelWorkprofile, $workprofileData, 'workProfileId', $workProfileId);
			// set mext page url
			$reditectUrl = base_url(lang().'/workprofile/recommandations');
			$type = 'success';
			$msg = $this->lang->line('successUpdatedWorkprofile');
			
		} 
		set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
      //----------------------------------------------------------------------
	
	 /*
     * @description: This function is used to manage communications recommandations details
     * @access: public
     * @return void
     */ 
    public function recommandations() {
  
		$userId = $this->userId;
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}

        // set data for upcoming form
        $this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['workProfileId']        = $workProfileId;
        $this->data['userId']               = $userId;
        $this->data['s1menu']               = 'TabbedPanelsTabSelected';
        $this->data['step4DetailsMenu']     = 'TabbedPanelsTabSelected';
		$this->data['communication1menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'workProfile/wizardform/your_details_menus';
        $this->data['subInnerPage']         = 'workProfile/wizardform/communication_menus';
        $this->data['subInnerPage1']        = 'workProfile/wizardform/recommandations';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
	/*
     * @description: This function is used to manage communication add links
     * @access: public
     * @return void
     */ 
    public function addcommicationlinks() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['s1menu']               = 'TabbedPanelsTabSelected';
        $this->data['step4DetailsMenu']     = 'TabbedPanelsTabSelected';
		$this->data['communication2menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'workProfile/wizardform/your_details_menus';
        $this->data['subInnerPage']         = 'workProfile/wizardform/communication_menus';
        $this->data['subInnerPage1']        = 'workProfile/wizardform/communication_add_link';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
    
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save website link data
     * @access: public
     * @return void
     */ 
    public function setweblink() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/workprofile/addcommicationlinks');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedWorkprofile');
        // get workprofile id
		$workProfileId = $this->getworkprofileid(); 
        if(!empty($postData)) {
            
            // update user's showcase type id
            $workprofileData = array('websiteUrl'=>$postData['websiteUrl']);
            $this->model_common->editDataFromTabel($this->tabelWorkprofile, $workprofileData, 'workProfileId', $workProfileId);
            // set mext page url
            $reditectUrl = base_url(lang().'/workprofile/socialmedialinks');
            $type = 'success';
            $msg = $this->lang->line('successUpdatedWorkprofile');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage social media links
     * @access: public
     * @return void
     */ 
    public function socialmedialinks() {
        $this->userId = $this->isLoginUser();
        $entityId = getMasterTableRecord('UserShowcases');
        $showcaseId = LoginUserDetails('showcaseId');
        // get social media links
        $socialMediaData = $this->model_common->getDetailSocialMedia(array('userId'=>$this->userId));
		
		$this->wizardheadingtext(); // set navigation bar heading
		 $this->data['socialMediaData']      = $socialMediaData;
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['s1menu']               = 'TabbedPanelsTabSelected';
        $this->data['step4DetailsMenu']     = 'TabbedPanelsTabSelected';
		$this->data['communication3menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'workProfile/wizardform/your_details_menus';
        $this->data['subInnerPage']         = 'workProfile/wizardform/communication_menus';
        $this->data['subInnerPage1']        = 'workProfile/wizardform/communication_social_link';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
		
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage professional summary details
     * @access: public
     * @return void
     */ 
    public function professionsummary() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['step1SummaryMenu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'workProfile/wizardform/professional_summary_menus';
        $this->data['subInnerPage']         = 'workProfile/wizardform/summary';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }

	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save profession summary data
     * @access: public
     * @return void
     */ 
    public function setprofessionsummary() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/workprofile/professionsummary');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedWorkprofile');
        // get workprofile id
		$workProfileId = $this->getworkprofileid(); 
        if(!empty($postData)) {
            
            // update user's showcase type id
            $workprofileData = array('synopsis'=>$postData['synopsis']);
            $this->model_common->editDataFromTabel($this->tabelWorkprofile, $workprofileData, 'workProfileId', $workProfileId);
            // set mext page url
            $reditectUrl = base_url(lang().'/workprofile/skills');
            $type = 'success';
            $msg = $this->lang->line('successUpdatedWorkprofile');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
    //-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage skills & qualifications details
     * @access: public
     * @return void
     */ 
    public function skills() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['step2SummaryMenu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'workProfile/wizardform/professional_summary_menus';
        $this->data['subInnerPage']         = 'workProfile/wizardform/skills';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }

	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save skills & qualifications data
     * @access: public
     * @return void
     */ 
    public function setskills() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/workprofile/professionsummary');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedWorkprofile');
        // get workprofile id
		$workProfileId = $this->getworkprofileid(); 
        if(!empty($postData)) {
            
            // update user's showcase type id
            $workprofileData = array('skills'=>$postData['skills']);
            $this->model_common->editDataFromTabel($this->tabelWorkprofile, $workprofileData, 'workProfileId', $workProfileId);
            // set mext page url
            $reditectUrl = base_url(lang().'/workprofile/typeofworksort');
            $type = 'success';
            $msg = $this->lang->line('successUpdatedWorkprofile');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
     //-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage Type of Work Sort details
     * @access: public
     * @return void
     */ 
    public function typeofworksort() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['step3SummaryMenu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'workProfile/wizardform/professional_summary_menus';
        $this->data['subInnerPage']         = 'workProfile/wizardform/type_of_work_sort';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save type of work type data
     * @access: public
     * @return void
     */ 
    public function settypeofworksort() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/workprofile/typeofworksort');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedWorkprofile');
        // get workprofile id
		$workProfileId = $this->getworkprofileid(); 
        if(!empty($postData)) {
            
            // update user's showcase type id
            $workprofileData = array(
				'remunerationRequired' => $postData['remunerationRequired'],
				'remunerationRate'     => $postData['remunerationRate'],
				'availability'         => $postData['availability'],
				'isContractWork'       => (!empty($postData['isContractWork'])) ? 't' : 'f',
				'minContractMonth'     => $postData['minContractMonth'],
				'maxContractMonth'     => $postData['maxContractMonth'],
				'isHideWorkSortFromCV' => (!empty($postData['isHideWorkSortFromCV'])) ? 't' : 'f',
				'isHideWorkSortFromOnlineWP' => (!empty($postData['isHideWorkSortFromOnlineWP'])) ? 't' : 'f',
            );
            $this->model_common->editDataFromTabel($this->tabelWorkprofile, $workprofileData, 'workProfileId', $workProfileId);
            // set mext page url
            $reditectUrl = base_url(lang().'/workprofile/worklocation');
            $type = 'success';
            $msg = $this->lang->line('successUpdatedWorkprofile');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
    //-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage work location details
     * @access: public
     * @return void
     */ 
    public function worklocation() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
		// get continent list
		$this->data['continentList'] = $this->model_common->getDataFromTabel('MasterContinent','*',array('status'=>'t'));
		// get Location  list
		$this->data['locationList'] = $this->model_common->getDataFromTabel($this->tableWorkProfileLocation,'*',array('workProfileId'=>$workProfileId));
        // set data for upcoming form 
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails'] = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['conitnentCountryList'] = $this->model_common->getContinentWiseCountry();
        $this->data['s2menu']             = 'TabbedPanelsTabSelected';
        $this->data['step4SummaryMenu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']          = 'workProfile/wizardform/professional_summary_menus';
        $this->data['subInnerPage']       = 'workProfile/wizardform/worklocation';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage education details
     * @access: public
     * @return void
     */ 
    public function education() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']  = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['educationValues']      = $this->model_workprofile->getEducation($workProfileId);
        $this->data['s3menu']              = 'TabbedPanelsTabSelected';
        $this->data['education1menu']      = 'TabbedPanelsTabSelected';
        $this->data['innerPage']           = 'workProfile/wizardform/education_menus';
        $this->data['subInnerPage']        = 'workProfile/wizardform/education';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
    
      /*
     * @description: This function is used to manage profile education details
     * @access: public
     * @return void
     */ 
    public function addprofileeducation() {
		$userId = $this->userId;
		// get post values
        $postData = $this->input->post();
		$countResult = 0;
        $educationId = $postData['educationId'];
        
        // get workprofile id
		$workProfileId = $this->getworkprofileid();
        if(!empty($postData) && !empty($workProfileId)) {
            
            // add user's workprofile education data
            $workprofileEduData = array(
				'tdsUid'        => $userId,
				'workProfileId' => $workProfileId,
				'year_from'     => $postData['educationYear'],
				'year_to'       => $postData['educationYearTo'],
				'university'    => $postData['university'],
				'degree'        => $postData['degree']
			);
			if($educationId > 0) {
				// update workprofile education data
				$this->model_common->editDataFromTabel($this->tableprofileEdu, $workprofileEduData, 'educationId', $educationId);
			} else {
				// add workprofile education data
				$educationId = $this->model_common->addDataIntoTabel($this->tableprofileEdu, $workprofileEduData);
			}
        }
		// prepare member html row
		$educationHtml = '';
		if($educationId > 0) {
            $educationHtml = $this->manageeducationrowhtml($educationId,$postData);
        }
        echo json_encode(array('educationHtml'=>$educationHtml,'editId'=>$postData['educationId']));
	}
	
	 //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage visa raw html
     * @access: private
     * @return void
     */ 
    private function manageeducationrowhtml($educationId,$postData) {
        // set row bg class
        $rowBgCls = 'bg_f9f9f9';
        $rowPLCls = 'pl23';
        $divId = 'profileEducation_'.$educationId;
       
        // prepare visa data row  
        $educationHtml  = '';
        if($postData['educationId'] == 0) {
            $educationHtml .= '<li id = "'.$divId.'">';
        }
        $educationHtml .= '<span class="'.$rowBgCls.'"><span class=" fl width176 '.$rowPLCls.'">';
        $educationHtml .= $postData['university'].'</span>';
        $educationHtml .= $postData['degree'].'<span class="red fs12 fr">';
		$educationHtml .= '<a href="javascript:void(0)" onclick="editEducation(this)" educationId='.$educationId.' year_from='.$postData['educationYear'].' year_to='.$postData['educationYearTo'].' university='.$postData['university'].' degree='.$postData['degree'].'> Edit</a> / ';
		$educationHtml .= '<a href="javascript:void(0)" onclick="deleteEducation('.$educationId.');">Delete </a>';   
        $educationHtml .= '</span></span>';
        if($postData['educationId'] == 0) {
            $educationHtml .= '</li>';
        }
        return $educationHtml;
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to remove profile education entry
     * @access: public
     * @return void
     */ 
    public function deleteprofileeducation() {
        $educationId = $this->input->post('educationId');
        $deleted = 0;
        $countResult = 0 ;
        if($educationId > 0) {
            $where = array('educationId'=>$educationId);
            $this->model_common->deleteRowFromTabel($this->tableprofileEdu, $where);
            $countResult = $this->model_common->countResult($this->tableprofileEdu,$where,'',1);
            $deleted = 1;
        }
        echo  json_encode(array('deleted'=>$deleted, 'countResult'=>$countResult));
    }
    
     //-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage employment details
     * @access: public
     * @return void
     */ 
    public function employment() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}

        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']  = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['employmentHistory']   = $this->lib_work_emp_hist->getValuesFromDB($workProfileId);
		$this->data['positions']           = $this->model_workprofile->getPostion('profileEmpHistory',$workProfileId );
        $this->data['s3menu']              = 'TabbedPanelsTabSelected';
        $this->data['education2menu']      = 'TabbedPanelsTabSelected';
        $this->data['innerPage']           = 'workProfile/wizardform/education_menus';
        $this->data['subInnerPage']        = 'workProfile/wizardform/employment';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
    
    /*
     * @description: This function is used to manage profile education details
     * @access: public
     * @return void
     */ 
    public function addprofileemployment() {
		$userId = $this->userId;
		// get post values
        $postData = $this->input->post();
		$countResult = 0;
        $empHistId = $postData['empHistId'];
        
        // get workprofile id
		$workProfileId = $this->getworkprofileid();
        if(!empty($postData) && !empty($workProfileId)) {
           
            // add user's workprofile education data
            $workprofileEmpData = array(
				'workProfileId' => $workProfileId,
				'compName'      => $postData['compName'],
				'compCity'      => $postData['compCity'],
				'empDesignation'=> $postData['empDesignation'],
				'compCountry'   => $postData['compCountry'],
				'empStartDate'  => $postData['empStartDate'],
				'empEndDate'    => ( isset($postData['empEndDate']) && !empty($postData['empEndDate'])) ? 0 : $postData['empEndDate'],
				'empAchivments' => $postData['empAchivments']
			);
			if($empHistId > 0) {
				// update workprofile employment data
				$this->model_common->editDataFromTabel($this->tableProfileEmpHistory, $workprofileEmpData, 'empHistId', $empHistId);
			} else {
				// get last position 
				$position = $this->model_workprofile->getPostion('profileEmpHistory',$workProfileId);
				$workprofileEmpData['position'] = $position+1;
				// add workprofile employment data
				$empHistId = $this->model_common->addDataIntoTabel($this->tableProfileEmpHistory, $workprofileEmpData);
			}
        }
		// prepare member html row
		$employmentHtml = '';
		if($empHistId > 0) {
            $employmentHtml = $this->manageemploymentrowhtml($empHistId,$postData);
        }
        echo json_encode(array('employmentHtml'=>$employmentHtml,'editId'=>$postData['empHistId']));
	}
	
	 //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage employment raw html
     * @access: private
     * @return void
     */ 
    private function manageemploymentrowhtml($empHistId,$postData) {
        // set row bg class
        $rowBgCls = 'bg_f9f9f9';
        $rowPLCls = 'pl23';
        $divId = 'profileEmployment_'.$empHistId;
       
        // prepare visa data row  
        $employmentHtml  = '';
        if($postData['empHistId'] == 0) {
            $employmentHtml .= '<li id = "'.$divId.'">';
        }
        $employmentHtml .= '<span class="'.$rowBgCls.'"><span class=" fl width176 '.$rowPLCls.'">';
        $employmentHtml .= $postData['compName'].'</span>';
        $employmentHtml .= $postData['empDesignation'].'<span class="red fs12 fr">';
		$employmentHtml .= '<a href="javascript:void(0)" onclick="editEmployment(this)" empHistId='.$empHistId.' compName='.$postData['compName'].' compCity='.$postData['compCity'].' compCountry='.$postData['compCountry'].' empDesignation='.$postData['empDesignation'].' empStartDate='.$postData['empStartDate'].' empEndDate='.$postData['empEndDate'].' empAchivments='.$postData['empAchivments'].'> Edit</a> / ';
		$employmentHtml .= '<a href="javascript:void(0)" onclick="deleteEmployment('.$empHistId.');">Delete </a>';   
        $employmentHtml .= '</span></span>';
        if($postData['empHistId'] == 0) {
            $employmentHtml .= '</li>';
        }
        return $employmentHtml;
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to remove profile employment entry
     * @access: public
     * @return void
     */ 
    public function deleteprofileemployment() {
        $empHistId = $this->input->post('empHistId');
        $deleted = 0;
        $countResult = 0 ;
        if($empHistId > 0) {
            $where = array('empHistId'=>$empHistId);
            $this->model_common->deleteRowFromTabel($this->tableProfileEmpHistory, $where);
            $countResult = $this->model_common->countResult($this->tableProfileEmpHistory,$where,'',1);
            $deleted = 1;
        }
        echo  json_encode(array('deleted'=>$deleted, 'countResult'=>$countResult));
    }
    
      //-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage refrences details
     * @access: public
     * @return void
     */ 
    public function refrences() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}

        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']  = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['refrenceRes']      = $this->lib_recommandations->getValuesFromDB($workProfileId);
		$this->data['positions']        = $this->model_workprofile->getPostion('profileRecommendation',$workProfileId);
        $this->data['s3menu']           = 'TabbedPanelsTabSelected';
        $this->data['education3menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']        = 'workProfile/wizardform/education_menus';
        $this->data['subInnerPage']     = 'workProfile/wizardform/refrences';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
    
    /*
     * @description: This function is used to manage profile refrences details
     * @access: public
     * @return void
     */ 
    public function addprofilerefrences() {
		$userId = $this->userId;
		// get post values
        $postData = $this->input->post();
		$countResult = 0;
        $refId = $postData['refId'];
        
        // get workprofile id
		$workProfileId = $this->getworkprofileid();
        if(!empty($postData) && !empty($workProfileId)) {
            
            // add user's workprofile refrence data
            $workprofileRefData = array(
				'workProfileId' => $workProfileId,
				'refFName'      => $postData['refFName'],
				'refLName'      => $postData['refLName'],
				'refCompName'=> $postData['refCompName'],
				'refEmail'   => $postData['refEmail'],
				'refContact'  => $postData['refContact'],
			);
			// set referencePrintType
			if(!empty($postData['refFName'])) {
				
			}
			if($refId > 0) {
				// update workprofile employment data
				$this->model_common->editDataFromTabel($this->tableProfileRecommendation, $workprofileRefData, 'refId', $refId);
			} else {
				// add workprofile employment data
				$refId = $this->model_common->addDataIntoTabel($this->tableProfileRecommendation, $workprofileRefData);
			}
        }
		// prepare member html row
		$refrenceHtml = '';
		if($refId > 0) {
            $refrenceHtml = $this->managerefrencesrowhtml($refId,$postData);
        }
        echo json_encode(array('refrenceHtml'=>$refrenceHtml,'editId'=>$postData['refId']));
	}
	
	 //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage employment raw html
     * @access: private
     * @return void
     */ 
    private function managerefrencesrowhtml($refId,$postData) {
        // set row bg class
        $rowBgCls = 'bg_f9f9f9';
        $rowPLCls = 'pl23';
        $divId = 'profileRefrences_'.$refId;
       
        // prepare visa data row  
        $refrenceHtml  = '';
        if($postData['refId'] == 0) {
            $refrenceHtml .= '<li id = "'.$divId.'">';
        }
        $refrenceHtml .= '<span class="'.$rowBgCls.'"><span class=" fl width176 '.$rowPLCls.'">';
        $refrenceHtml .= $postData['refFName'].' '.$postData['refLName'].'</span>';
        $refrenceHtml .= $postData['refCompName'].'<span class="red fs12 fr">';
		$refrenceHtml .= '<a href="javascript:void(0)" onclick="editRefrence(this)" refId='.$refId.' refFName='.$postData['refFName'].' refLName='.$postData['refLName'].' refCompName='.$postData['refCompName'].' refEmail='.$postData['refEmail'].' refContact='.$postData['refContact'].'> Edit</a> / ';
		$refrenceHtml .= '<a href="javascript:void(0)" onclick="deleteRefrence('.$refId.');">Delete </a>';   
        $refrenceHtml .= '</span></span>';
        if($postData['refId'] == 0) {
            $refrenceHtml .= '</li>';
        }
        return $refrenceHtml;
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to remove profile employment entry
     * @access: public
     * @return void
     */ 
    public function deleteprofilerefrences() {
        $refId = $this->input->post('refId');
        $deleted = 0;
        $countResult = 0 ;
        if($refId > 0) {
            $where = array('refId'=>$refId);
            $this->model_common->deleteRowFromTabel($this->tableProfileRecommendation, $where);
            $countResult = $this->model_common->countResult($this->tableProfileRecommendation,$where,'',1);
            $deleted = 1;
        }
        echo  json_encode(array('deleted'=>$deleted, 'countResult'=>$countResult));
    }
    
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage refrence print CV type data
     * @access: public
     * @return void
     */ 
    public function setreferences() {
		
		// get workprofile id
		$workProfileId = $this->getworkprofileid();
		// get post values
        $postData = $this->input->post();
		if($workProfileId > 0 && !empty($postData['referencePrintType'])) {
			// update workprofile language data
			$this->model_common->editDataFromTabel($this->tabelWorkprofile, array('referencePrintType'=>$postData['referencePrintType']), 'workProfileId', $workProfileId);
			$type = 'success';
			$msg = $this->lang->line('successUpdatedWorkprofile');
			set_global_messages($msg, $type, $is_multiple=true);
		} 

		// set mext page url
		$reditectUrl = base_url(lang().'/workprofile/achivments');
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
    //-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage achivments & awards details
     * @access: public
     * @return void
     */ 
    public function achivments() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['s3menu']           = 'TabbedPanelsTabSelected';
        $this->data['education4menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']        = 'workProfile/wizardform/education_menus';
        $this->data['subInnerPage']     = 'workProfile/wizardform/achivments';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save achivments & awards data
     * @access: public
     * @return void
     */ 
    public function setachivments() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/workprofile/achivments');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedWorkprofile');
        // get workprofile id
		$workProfileId = $this->getworkprofileid(); 
        if(!empty($postData)) {
            
            // update user's showcase type id
            $workprofileData = array('achievmentsAndAwards'=>$postData['achievmentsAndAwards']);
            $this->model_common->editDataFromTabel($this->tabelWorkprofile, $workprofileData, 'workProfileId', $workProfileId);
            // set mext page url
            $reditectUrl = base_url(lang().'/workprofile/previewprofile');
            $type = 'success';
            $msg = $this->lang->line('successUpdatedWorkprofile');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
    //-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage portfolio media type details
     * @access: public
     * @return void
     */ 
    public function portfoliomediatype($mediaId=0) {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
		
		if($mediaId > 0) {
			// get profile media data
			$profileMediaData = $this->getprofilemediadata($mediaId,$workProfileId);
		}

        // set data for upcoming form
		$this->wizardheadingtext(2); // set navigation bar heading
        $this->data['profileMediaData'] = (isset($profileMediaData)) ? $profileMediaData : '';
        $this->data['mediaId']          = $mediaId;
        $this->data['s4menu']           = 'TabbedPanelsTabSelected';
        $this->data['portfolio1menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']        = 'workProfile/wizardform/portfolio_media_type';
        //$this->data['subInnerPage']     = 'workProfile/wizardform/portfolio_media_type';
        $this->new_version->load('new_version','workProfile/wizardform/portfolio_menus',$this->data);
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to set type of media type
     * @access: public
     * @return void
     */ 
    public function setportfoliomediatype() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = 'workprofile/portfoliomediatype';
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedWorkprofile');
        // get workprofile id
		$workProfileId = $this->getworkprofileid(); 
	
        if(!empty($postData)) {
			$reditectUrl = 'workprofile/uploadmedia/'.$postData['mediaId'].'/'.$postData['mediaType'];
        }
		redirect($reditectUrl);
    }
    
    //-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage portfolio media upload file
     * @access: public
     * @return void
     */ 
    public function uploadmedia($mediaId=0,$mediaType=0) {
		
		// check media type
		if($mediaType != 1 && $mediaType != 2 && $mediaType != 3 && $mediaType != 4 ) {
			redirect('workprofile/portfoliomediatype');
		}
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
		
		if($mediaId > 0) {
			// get profile media data
			$profileMediaData = $this->getprofilemediadata($mediaId,$workProfileId);	
		}

		//call method for plupload css and js add
        $this->_pluploadjsandcss();
        // set media file type
		$this->_setuploadfileparams($mediaType);
         
        // set data for upcoming form
		$this->wizardheadingtext(2); // set navigation bar heading
        $this->data['profileMediaData'] = (isset($profileMediaData)) ? $profileMediaData : '';
        $this->data['mediaId']          = $mediaId;
        $this->data['workProfileId']    = $workProfileId;
        $this->data['s4menu']           = 'TabbedPanelsTabSelected';
        $this->data['portfolio2menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']        = 'workProfile/wizardform/upload_file_form';
        //$this->data['subInnerPage']     = 'workProfile/wizardform/upload_file_form';
        $this->new_version->load('new_version','workProfile/wizardform/portfolio_menus',$this->data);
    }
    
     //-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use set upload file required data
    * @access: public
    * @return: void
    */
     
    private function _setuploadfileparams($mediaFileType=1) {
        
        if( $mediaFileType == 1) {
            $mediaFileTypes      =  $this->config->item('imageAccept');
            $allowedMediaType    =  $this->config->item('imageType');
            $typeOfFile          =  '1';
            $fileMaxSize         =  $this->config->item('imageSize');
            $uploadPath          = 'media/'.LoginUserDetails('username').'/workshowcase/Images/';
        } elseif( $mediaFileType == 2) {
            $mediaFileTypes      =  $this->config->item('videoAccept');
            $allowedMediaType    =  $this->config->item('videoType');
            $typeOfFile          =  '2';
            $fileMaxSize         =  $this->config->item('videoSize');
			$uploadPath          = 'media/'.LoginUserDetails('username').'/workshowcase/Videos/';
        } elseif( $mediaFileType == 3 ) {
            $mediaFileTypes      =  $this->config->item('audioAccept');
            $allowedMediaType    =  $this->config->item('audioType');
            $typeOfFile          =  '3';
            $fileMaxSize         =  $this->config->item('audioSize');
			$uploadPath          = 'media/'.LoginUserDetails('username').'/workshowcase/Audios/';
        } elseif( $mediaFileType == 4 ) {
            $mediaFileTypes      =  $this->config->item('writtenMaterialAccept');
            $allowedMediaType    =  $this->config->item('writtenMaterialAccept');
            $typeOfFile          =  '4';
            $fileMaxSize         =  $this->config->item('writtenMaterialSize');
			$uploadPath          = 'media/'.LoginUserDetails('username').'/workshowcase/WrittenMaterial/';
        }
        
        $this->data['mediaFileTypes']        =  $mediaFileTypes; // set media type show 
        $this->data['allowedMediaType']      =  $allowedMediaType; // allow media type
        $this->data['typeOfFile']            =  $typeOfFile; // type of file 
        $this->data['fileMaxSize']           =  $fileMaxSize; // upload max size
		$this->data['dirUploadMedia']        =  $uploadPath; // upload file path
    }
    
    //-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to stage "3" of media uploage stage - 1
    * @access: public
    * @return: void
    */
     
    public function uploadfilepost() {
        
        if($this->input->is_ajax_request()) {

            $browseId           =   $this->input->post('browseId');
            //--------media data prepair for inserting------//
            $isFile             =   false;
            $media_fileName     =   $this->input->post('fileName'.$browseId);
            $filePath           =   $this->input->post('fileUploadPath');
            $mediaFileData=array();
            if($media_fileName && strlen($media_fileName)>3){
                $isFile         =   true;
                $fileType       =   getFileType($media_fileName);
                $mediaFileData  =   array(
									'filePath'      =>  $filePath,
									'fileName'      =>  $media_fileName,
									'fileType'      =>  $fileType,
									'tdsUid'        =>  $this->userId,
									'isExternal'    =>  'f',
									'fileSize'      =>  $this->input->post('fileSize'.$browseId),
									'rawFileName'   =>  $this->input->post('fileInput'.$browseId),
									'jobStsatus'    =>  'UPLOADING'
                                    ); 
			}
            
            if($isFile) {
                
                $fileLength = $this->input->post('fileLength');
                switch($fileType)
                {
                    case 1:
                        $mediaFileData['fileHeight'] = ($this->input->post('fileHeight')=="")?Null:$this->input->post('fileHeight');
                        $mediaFileData['fileWidth'] = ($this->input->post('fileWidth')=="")?Null:$this->input->post('fileWidth');
                        $mediaFileData['fileUnit'] = ($this->input->post('fileUnit')=="")?Null:$this->input->post('fileUnit');
                    break;
                    
                    case 2:
                    case 3:
                        $mediaFileData['fileLength'] = $fileLength;
                        $mediaFileData['fileLength'] = $fileLength;
                    break;
                    
                    case 4:
                        $mediaFileData['fileLength'] = $this->input->post('wordCount');
                    break;
                }
                
                $fileId = $this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);
        
            } else {
                $fileId=0;
            }
            
            if($fileId > 0) {
                //add profile media data
                $profileMediaData = array(
									'workProfileId' => $this->input->post('workProfileId'),
									'fileId' => $fileId,
									'mediaType' => $fileType
									);
                $mediaId = $this->model_common->addDataIntoTabel($this->tableProfileMedia, $profileMediaData);
            }
            
             // remove previouse media file record
            if(!empty($prevfileId) && $prevfileId > 0) {
				$uploadedFilePath = $this->input->post('uploadedFilePath'.$browseId);
				unlink($uploadedFilePath);
				$this->model_common->deleteRowFromTabel('MediaFile',array('fileId'=>$prevfileId));
			}
            
            // set next page url
            $nextUrl = '/uploadmedia/0/'.$fileType;;
            if(isset($mediaId)) {
				$nextUrl = '/portfoliotitlendesc/'.$mediaId.'/'.$fileType;
			}
            
            $msg='Media file uploaded successfully';
            set_global_messages($msg, $type='success', $is_multiple=true);
            $returnData=array('fileId'=>$fileId,'nextUrl'=>$nextUrl);
            echo json_encode($returnData);
        }
        
    }
    
     //-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage portfolio media upload file
     * @access: public
     * @return void
     */ 
    public function portfoliotitlendesc($mediaId=0,$mediaType=0) {
		
		// check media type
		if($mediaType != 1 && $mediaType != 2 && $mediaType != 3 && $mediaType != 4 ) {
			redirect('workprofile/portfoliomediatype');
		}
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
		
		if($mediaId > 0) {
			// get profile media data
			$profileMediaData = $this->getprofilemediadata($mediaId,$workProfileId);
		} else {
			redirect('workprofile/setportfoliomediatype');
		}

         
        // set data for upcoming form
		$this->wizardheadingtext(2); // set navigation bar heading
        $this->data['profileMediaData'] = (isset($profileMediaData)) ? $profileMediaData : '';
        $this->data['mediaId']          = $mediaId;
        $this->data['workProfileId']    = $workProfileId;
        $this->data['s4menu']           = 'TabbedPanelsTabSelected';
        $this->data['portfolio3menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']        = 'workProfile/wizardform/portfolio_title_desc';
        //$this->data['subInnerPage']     = 'workProfile/wizardform/portfolio_title_desc';
        $this->new_version->load('new_version','workProfile/wizardform/portfolio_menus',$this->data);
    }
		
	 //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save media's title and description
     * @access: public
     * @return void
     */ 
    public function settitlendescription() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/workprofile/portfoliomediatype');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedWorkprofile');
        // get workprofile id
		$workProfileId = $this->getworkprofileid(); 
        if(!empty($postData) && !empty($postData['mediaId'])) {
            
            // update media data
            $mediaData = array('mediaTitle'=>$postData['mediaTitle'],'mediaDesc'=>$postData['mediaDesc']);
            $this->model_common->editDataFromTabel($this->tableProfileMedia, $mediaData, 'mediaId', $postData['mediaId']);
            // set next page url
            $reditectUrl = base_url(lang().'/workprofile/portfolionextstep/'.$postData['mediaId'].'/'.$postData['mediaType']);
            $type = 'success';
            $msg = $this->lang->line('successUpdatedWorkprofile');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
	
	 //-----------------------------------------------------------------------
    
     /*
     * @description: This function is used to manage portfolio media type next options
     * @access: public
     * @return void
     */ 
    public function portfolionextstep($mediaId=0,$mediaType=0) {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
		
		if($mediaId > 0) {
			// get profile media data
			$profileMediaData = $this->getprofilemediadata($mediaId,$workProfileId);
		}

        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['profileMediaData'] = (isset($profileMediaData)) ? $profileMediaData : '';
        $this->data['mediaId']          = $mediaId;
        $this->data['mediaType']        = $mediaType;
        $this->new_version->load('new_version','workProfile/wizardform/portfolio_next_step_options',$this->data);
    }
    
	//---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to manage next selected option
    * @return: void
    */ 
    function setportfolionextaction() {
        
        // set default redirect url
        $redirectUrl = base_url(lang().'/workprofile/portfoliomediatype');
        
        // get post form data
        $postData = $this->input->post();
       
        if(!empty($postData) && !empty($postData['mediaId'])) {
          
			// manage redirect url
			if($postData['mediaType'] == 5) {
				$redirectUrl = base_url(lang().'/workprofile/yourdetails');
			} else if($postData['mediaType'] == 6) {
				$redirectUrl = base_url(lang().'/workprofile/previewprofile');
			} else {
				$redirectUrl = base_url(lang().'/workprofile/uploadmedia/0/'.$postData['mediaType']); ;
			}
        }
       
        redirectPage($redirectUrl);
    }
    
	//-----------------------------------------------------------------------
    
	/*
	* @description: This function is used to manage portfolio media type details
	* @access: public
	* @return void
	*/ 
	private function getprofilemediadata($mediaId=0,$workProfileId=0) {
		
		// get profile media data
		$profileMediaData = $this->model_workshowcase->getproflemediainfo($mediaId,$workProfileId);
		if(!empty($profileMediaData)) {
			return $profileMediaData[0];
		} else {
			// set redirect msg and url if data is empty
			set_global_messages($this->lang->line('errorUpdatedWorkprofile'), 'error', $is_multiple=true);
			redirect('home');
		}
	}
	
	//-----------------------------------------------------------------------
    
	/*
	* @description: This function is used to manage profile preview 
	* @access: public
	* @return void
	*/ 
	public function previewprofile() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['s5menu']           = 'TabbedPanelsTabSelected';
        $this->data['publish1Menu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']        = 'workProfile/wizardform/publish_menus';
        $this->data['subInnerPage']     = 'workProfile/wizardform/preview_profile';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
	}
	
	//-----------------------------------------------------------------------
    
	/*
	* @description: This function is used to manage profile share by email 
	* @access: public
	* @return void
	*/ 
	public function emaillink() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['s5menu']           = 'TabbedPanelsTabSelected';
        $this->data['publish2Menu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']        = 'workProfile/wizardform/publish_menus';
        $this->data['subInnerPage']     = 'workProfile/wizardform/email_link';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
	}
    
    //-----------------------------------------------------------------------
    
	/*
	* @description: This function is used to manage profile share by email 
	* @access: public
	* @return void
	*/ 
	public function addbutton() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['s5menu']           = 'TabbedPanelsTabSelected';
        $this->data['publish3Menu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']        = 'workProfile/wizardform/publish_menus';
        $this->data['subInnerPage']     = 'workProfile/wizardform/add_button';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
	}
    
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save achivments & awards data
     * @access: public
     * @return void
     */ 
    public function setaddbutton() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/workprofile/downloadapp');
        // get workprofile id
		$workProfileId = $this->getworkprofileid();
		
		$btnStatus = (!empty($postData['isRequestBtnShowOnShowcase'])) ?  't' : 'f';
		// update user's showcase type id
		$workprofileData = array('isRequestBtnShowOnShowcase'=>$btnStatus);
		$this->model_common->editDataFromTabel($this->tabelWorkprofile, $workprofileData, 'workProfileId', $workProfileId);
		$type = 'success';
		$msg = $this->lang->line('successUpdatedWorkprofile');
        set_global_messages($msg, $type, $is_multiple=true);
        redirect($reditectUrl);
    }
    
    //-----------------------------------------------------------------------
    
	/*
	* @description: This function is used to manage doenload toad app
	* @access: public
	* @return void
	*/ 
	public function downloadapp() {
		
        $this->userId = $this->isLoginUser();
		// get workprofile id
		$workProfileId = $this->getworkprofileid(); 
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
		}
        // set data for upcoming form
		$this->wizardheadingtext(); // set navigation bar heading
        $this->data['workProfileDetails']   = (isset($workProfileDetails[0])) ? $workProfileDetails[0]:'';
        $this->data['s5menu']           = 'TabbedPanelsTabSelected';
        $this->data['publish4Menu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']        = 'workProfile/wizardform/publish_menus';
        $this->data['subInnerPage']     = 'workProfile/wizardform/download_app';
        $this->new_version->load('new_version','workProfile/wizardform/wizard',$this->data);
	}
	
	//-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage county html
     * @access: public
     * @return void
     */ 
    public function getcountries() {
		// get continent id
		$continentId = $this->input->post('continentId');
		// get location type
		$locationType = $this->input->post('locationType');
		// get country list
		$countryList = $this->model_common->getDataFromTabel('MasterCountry','*',array('status'=>'1','continentId'=>$continentId));
		// prepare data row
		$countryHtml = '<a class="buttons prev" href="#">left</a>';
		$countryHtml .= '<div class="viewport width207 height337">';
        $countryHtml .= '<ul class="defaultP overview work_list fs13  ">';
        $i = 0;
		foreach($countryList as $country) {
			
			if($i == 0) {
				$checked = 'checked';
			} else {
				$checked = '';
			}
			if($locationType == 2) {
				$countryHtml .= '<li><input type="checkbox" name="countryId[]" value="'.$country->countryId.'"/>'.$country->countryName.'</li>';
			} else {
				$countryHtml .= '<li><input type="radio" name="countryId" value="'.$country->countryId.'" '.$checked.' onclick="getStateList()"/>'.$country->countryName.'</li>';
			}
			$i++;
		}
		$countryHtml .= '</ul>';
		$countryHtml .= '</div>';
		$countryHtml .= '<a class="buttons next" href="#">left</a>';
		$countryHtml .= '<script>runTimeCheckBox();$(".slidervertical").tinycarousel({ axis: "y", display: 1});</script>';
        echo $countryHtml;
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage states html
     * @access: public
     * @return void
     */ 
    public function getstates() {
		// get country id
		$countryId = $this->input->post('countryId');
		// get state list
		$stateList = $this->model_common->getDataFromTabel('MasterStates','*',array('status'=>'t','countryId'=>$countryId));
		// prepare data row 
		$stateHtml = '<a class="buttons prev" href="#">left</a>';
		$stateHtml .= '<div class="viewport width207 height337">';
        $stateHtml .= '<ul class="defaultP overview work_list fs13  ">';
        if(!empty($stateList)) {
			$stateHtml .= '<li><input type="checkbox" id="checkAllStates" name="checkAllStates" value="" onclick="checkUncheckStates(this);"/><b>Select All </b></li>';
			foreach($stateList as $state) {
				$stateHtml .= '<li><input type="checkbox" name="countryId[]" value="'.$state->stateId.'"/>'.$state->stateName.'</li>';
			}
		}
		$stateHtml .= '</ul>';
		$stateHtml .= '</div>';
		$stateHtml .= '<a class="buttons next" href="#">left</a>';
		$stateHtml .= '<script>runTimeCheckBox();$(".slidervertical").tinycarousel({ axis: "y", display: 1});</script>';
        echo $stateHtml;
    }
    
     /*
     * @description: This function is used to manage profile work locations
     * @access: public
     * @return void
     */ 
    public function setworklocations() {
		$userId = $this->userId;
		// get post values
        $postData = $this->input->post();
        $type = 'error';
		$msg = $this->lang->line('errorAddLocation');
		$locationId = 0;
        // get workprofile id
		$workProfileId = $this->getworkprofileid();
        if(!empty($postData) && !empty($workProfileId)) {
			$locationIds = explode(',',$postData['locationIds']);
			for($i=0;$i<count($locationIds);$i++) {
				if(!empty($locationIds[$i])) {
					// add user's workprofile location data
					$workprofileLocationData = array(
						'workProfileId'     => $workProfileId,
						'workLocationType'  => $postData['locationType'],
						'locationId'        => $locationIds[$i]
					);
				
					// add workprofile education data
					$locationId = $this->model_common->addDataIntoTabel($this->tableWorkProfileLocation, $workprofileLocationData);
				}
			}
			$type = 'success';
			$msg = $this->lang->line('successAddLocation');
        }
       
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('locationId'=>$locationId));
	}
	
	  //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to remove work location
     * @access: public
     * @return void
     */ 
    public function deleteworklocation() {
        $workLocationId = $this->input->post('workLocationId');
        $deleted = 0;
        $countResult = 0 ;
        if($workLocationId > 0) {
            $where = array('workLocationId'=>$workLocationId);
            $this->model_common->deleteRowFromTabel($this->tableWorkProfileLocation, $where);
            $countResult = $this->model_common->countResult($this->tableWorkProfileLocation,$where,'',1);
            $deleted = 1;
        }
        echo  json_encode(array('deleted'=>$deleted, 'countResult'=>$countResult));
    }
    
	//----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to manage membership cart under stage 1
	 * @return void
	 */ 
	public function membershipcart() {
		// get work profile entity id
		$entityId    = getMasterTableRecord('WorkProfile');
		// get workprofile id
		$workProfileId = $this->getworkprofileid();
		redirect('membershipcart/managecart/'.$entityId.'/'.$workProfileId);
        
        /*$this->userId = $this->isLoginUser();
		
		$userContainerId = 0;
		if(!empty($workProfileId) && $workProfileId > 0) {
			// get workprofile data
			$workProfileDetails = $this->model_workprofile->getWorkProfileDetails($workProfileId);
			if(!empty($workProfileDetails)) {
				$workProfileDetails = $workProfileDetails[0];
				$userContainerId = $workProfileDetails->userContainerId;
			}
		}
    
        //----- start manage data for edit project's add space 
        // set project id in session for add space
        $this->session->set_userdata('addSpaceWorkProfileId',$workProfileId);
        // set user container id in session for add space
        $this->session->set_userdata('workprofileContainerId',$userContainerId);
       
        //----- end managing data for add space 
        
		//get logged user subscription details
		$whereSubcrip    = array('tdsUid' => $this->userId);
		$subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', 'subscriptionType',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
		if(!empty($subcripDetails)) {
			$subscriptionType  = $subcripDetails[0]->subscriptionType;
		}
		// get media session cart id if exists
		$mediaCartId = $this->session->userdata('mediaCartId');
		$mediaCartData = '';
		if(!empty($mediaCartId)) {
			// get cart temp data
			$mediaCartData = $this->model_common->getCurrentCartData($mediaCartId);
		} 	
		
        // load industry typr lang file
        $this->load->language('media');
		$this->data['mediaCartData']     = $mediaCartData;
		$this->data['subscriptionType']  = $subscriptionType;
        $this->data['innerPage']         = 'workProfile/wizardform/membership_cart';
		$this->data['s1menu']            = 'TabbedPanelsTabSelected';
        $this->data['membership2menu']   = 'TabbedPanelsTabSelected';
        $this->data['workprofileImage']   = $this->getprofileimage($workProfileDetails);
        $this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
		$this->new_version->load('new_version','workProfile/wizardform/membership_cart_header',$this->data);
		*/
	}
    
    //----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to manage membership temp cart data
	 * @return string
	 */ 
    public function membershipcartpost() {
		
        // get membership form post values 
        $data = $this->input->post();
        // set workprofile product id
        $data['tsProductId'] = $this->config->item('tsProductId_Workprofile');
		// set cart values
		$cartValues  = $this->setcartvalues($data); 
		// get vat percentage
		$vatPercent  = $this->config->item('media_vat_percent');
		// set vat price of total 
		$vatPrice    = (($data['extraSpacePrice']*$vatPercent)/100);
		// set total price
		$totalPrice  = $vatPrice + $data['extraSpacePrice'];
		
        // insert data in  temp membership cart tabel
        $cartId = $this->addCartData($totalPrice,$cartValues['orderType'],$vatPrice);
      
        // set default next step as blank
        $nextStep = 'showcase/editshowcase'; 
		if(isset($cartId) && !empty($cartId)) {
			// set cart id in session
			$this->session->set_userdata('mediaCartId',$cartId); 
			// set default values as 0
			$pkgId = 0;	
			$containerId = 0;
			$parentCartItem = 0;
			
            // manage add space type if project id exists
            $workprofileContainerId = $this->session->userdata('workprofileContainerId'); 
            if(!empty($workprofileContainerId) && $data['subscriptionType'] != 1 ) {
                $elementId   = $this->session->userdata('addSpaceWorkProfileId'); 
                $entityId    = getMasterTableRecord('WorkProfile');
                $containerId = $workprofileContainerId;
            }
			
			// set vat price on extra space 
			$vatPrice    = (($data['cartTotalPrice']*$vatPercent)/100);
			// prepare membership cart item data
			$memItemInsert = array(
				'cartId'           => $cartId,
				'tsProductId'      => $cartValues['tsProductId'],
				'price'            => $data['extraSpacePrice'],
				'size'             => $cartValues['size'],
				'pkgId'            => $pkgId,
				'pkgRoleId'        => 0,
				'totalPrice'       => $data['extraSpacePrice'],
				'type'             => $cartValues['itemType'],
                'elementId'        => (isset($elementId))?$elementId:0,
                'entityId'         => (isset($entityId))?$entityId:0,
				'parentCartItemId' => $parentCartItem,
				'userContainerId'  => $containerId,
				);
               
			// insert data in  temp membership cart item tabel
			$this->model_membershipcart->addDataMem($memItemInsert);

			$nextStep = 'workprofile/billingdetails'; // set next step as billing page
		}
        redirect($nextStep);
    }
    
     //----------------------------------------------------------------------

	/*
	 * @access: private
	 * @description: This function is used to add temp cart data
	 * @return int
	 */ 
    private function addCartData($cartTotalPrice,$orderType,$vatPrice) {
		
		//prepare cart insertion data
		$inserts = array(
			'totalPrice'  => $cartTotalPrice,
			'totalTaxAmt' => $vatPrice,
			'tdsUid'      => $this->userId,
			'orderType'   => $orderType
			);
        
        // insert data in  temp membership cart tabel
        $cartId = $this->model_membershipcart->addData($inserts);
        return $cartId; 
	}
    
    //----------------------------------------------------------------------

	/*
	 * @access: private
	 * @description: This function is used to set cart values as subscription 
	 * @return string
	 */ 
    private function setcartvalues($data) {
		
        // manage add space type if container id exists
        $workprofileContainerId = $this->session->userdata('workprofileContainerId'); 
        if(!empty($workprofileContainerId)) {
            $itemType  = $this->config->item('membership_item_type_2'); // set add container space / membership space type
            $orderType = $this->config->item('membership_item_type_1'); // set add container space / membership space type
        }
        
		if($data['subscriptionType'] != 1) { // set values for paid user
		
			//$cartValues['parentContainerSize'] = mbToBytes($this->config->item('defaultUnitofStorageSpace_paidMember_GB'),'gb');
			$cartValues['parentContainerSize'] = 0;
			$cartValues['itemType']            = (isset($itemType))?$itemType:$this->config->item('membership_item_type_10'); // set type for paid member
			$cartValues['size']                = mbToBytes($data['extraspace'],'gb'); // set type for paid member
			$cartValues['orderType']           = (isset($orderType))?$orderType:$this->config->item('membership_order_type_3'); // set order type for paid member;
			$cartValues['tsProductId']         = $this->config->item('ts_product_id_paid_user'); // set ts product id 
			$cartValues['containerPrice']      = 0;
			
			
		} else { // set values for free user
		
			$cartValues['parentContainerSize'] = mbToBytes($this->config->item('defaultUnitofStorageSpace_freeMember_MB'),'kb');
			$cartValues['size']                = mbToBytes($data['extraspace'],'mb');  // convert mb unit to bytes
			$cartValues['itemType']            = (isset($itemType))?$itemType:$this->config->item('membership_item_type_2'); // set type for free member
			$cartValues['orderType']           = $this->config->item('membership_order_type_1'); // set order type for free member;
			//$cartValues['tsProductId']       = $this->config->item('ts_product_id_free_user'); // set ts product id
			$cartValues['tsProductId']         = $data['tsProductId'];
			// set container total price of item
			$containerPrice = $this->config->item('defaultPrice_per_unitofStorageSpace_freeMember_EURO');
			if(!empty($data['totalProductPrice'])) {
				$containerPrice = $data['totalProductPrice'];
			}
			$cartValues['containerPrice'] = $containerPrice;
		}
		return $cartValues;
	}
    
     //----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to manage billing information
	 * @return string
	 */ 
	public function billingdetails() {
		
		// get users profile details
		$userProfileData = $this->model_common->getUserProfileData($this->userId);
		$userProfileData =  (!empty($userProfileData[0]))?$userProfileData[0]:''; 
		$this->load->language('media');
		$this->data['userProfileData'] = $userProfileData; # set user profile data 
        $this->data['innerPage'] = 'workProfile/wizardform/billing_details';
        $this->data['membership3menu'] = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
		$this->new_version->load('new_version','workProfile/wizardform/membership_cart_header',$this->data);
	}
    
    //----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to manage billing data 
	 * @return string
	 */ 
    public function billingdetailspost() {
		
		// get billing form post values 
		$billingData = $this->input->post();
		$nextStep = 'workprofile/billingdetails'; // set default next step as blank
       
		if(!empty($billingData)) {
			
			if(isset($billingData['isSameAsSeller']) && !empty($billingData['isSameAsSeller'])) { 
				
				// set seller details as billing data
				$billing_firstName   = (!empty($billingData['firstName']))?$billingData['firstName']:'';
				$billing_lastName    = (!empty($billingData['lastName']))?$billingData['lastName']:'';
				$billing_companyName = (!empty($billingData['seller_companyName']))?$billingData['seller_companyName']:'';
				$billing_address1    = (!empty($billingData['seller_address1']))?$billingData['seller_address1']:'';
				$billing_address2    = (!empty($billingData['seller_address2']))?$billingData['seller_address2']:'';
				$billing_city        = (!empty($billingData['seller_city']))?$billingData['seller_city']:'';
				$billing_country     = (!empty($billingData['seller_country']))?$billingData['seller_country']:'';
				$billing_state       = (!empty($billingData['seller_state']))?$billingData['seller_state']:'';
				$billing_zip         = (!empty($billingData['seller_zip']))?$billingData['seller_zip']:'';
				$billing_email       = (!empty($billingData['seller_email']))?$billingData['seller_email']:'';
				$billing_phone       = (!empty($billingData['seller_phone']))?$billingData['seller_phone']:'';
				
			} else { 
				
				// set billing details
				$billing_firstName   = (!empty($billingData['firstName']))?$billingData['firstName']:'';
				$billing_lastName    = (!empty($billingData['lastName']))?$billingData['lastName']:'';
				$billing_companyName = (!empty($billingData['companyName']))?$billingData['companyName']:'';
				$billing_address1    = (!empty($billingData['addressLine1']))?$billingData['addressLine1']:'';
				$billing_address2    = (!empty($billingData['addressLine2']))?$billingData['addressLine2']:'';
				$billing_city        = (!empty($billingData['townOrCity']))?$billingData['townOrCity']:'';
				$billing_country     = (!empty($billingData['countriesList']))?$billingData['countriesList']:'';
				$billing_state       = (!empty($billingData['stateList']))?$billingData['stateList']:'';
				$billing_zip         = (!empty($billingData['zipCode']))?$billingData['zipCode']:'';
				$billing_email       = (!empty($billingData['email']))?$billingData['email']:'';
				$billing_phone       = (!empty($billingData['phoneNumber']))?$billingData['phoneNumber']:'';
			}
			
			// set billing data array 
			$billingDataArray = array(
				'tdsUid'              => $this->userId,
				'billing_firstName'   => $billing_firstName,
				'billing_lastName'    => $billing_lastName, 
				'billing_companyName' => $billing_companyName,
				'billing_address1'    => $billing_address1,
				'billing_address2'    => $billing_address2,
				'billing_city'        => $billing_city,
				'billing_country'     => $billing_country,
				'billing_state'       => $billing_state,
				'billing_zip'         => $billing_zip,
				'billing_email'       => $billing_email,
				'billing_phone'       => $billing_phone,
				);
			
			// get membership card from session
			$cartId = $this->session->userdata('mediaCartId');
			
			if(!empty($cartId)) {
				// manage buyer's billing data log
				$nextStep = $this->updatebuyerdata($billingDataArray,$billingData,$cartId);
			}
		}
		
		redirect('workprofile/'.$nextStep);
	}
    
    //----------------------------------------------------------------------

	/*
	 * @access: private
	 * @description: This function is used to update buyer billing data
	 * @return string
	 */ 
    private function updatebuyerdata($billingDataArray,$billingData,$cartId) {
		// add billing data in cart 
		$this->model_common->updateBillingData(array('billingdetails'=>json_encode($billingDataArray)), $cartId);
		// update or add buyer billing data for global setting
		if(isset($billingData['isSaveInBilling']) && !empty($billingData['isSaveInBilling'])) {
			// insert & udpate buyer data in user buyer table
			$buyerSettingData =  $this->model_common->getDataFromTabel('UserBuyerSettings', 'id',  array('tdsUid' => $this->userId),'','','',1);
			// push tax text value if exists
			if(!empty($billingData['otherAboutConsumptionTax'])) {
				$billingDataArray['otherAboutConsumptionTax'] = $billingData['otherAboutConsumptionTax'];
			}
			
			if(!empty($buyerSettingData)) {
				$buyerSettingData  =  $buyerSettingData[0];
				$buyerUserId       =  $buyerSettingData->id;
				// update buyer billing data
				$this->model_common->editDataFromTabel('UserBuyerSettings', $billingDataArray, 'id', $buyerUserId);
			} else {
				// add buyer billing data
				$this->model_common->addDataIntoTabel('UserBuyerSettings', $billingDataArray);
			}
			
		}
		$nextStep = 'purchasesummary'; // set next step as purchase summary
		return $nextStep;
	}
	
	  //----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to show purchase summary
	 * @return string
	 */ 
	public function purchasesummary() {
		// get membership card from session
		$cartId = $this->session->userdata('mediaCartId');
		$this->load->language('media');
		$spaceSize = '';
		$spaceUnit = '';
		$spacePrice = 0;
		$containerPrice = 0;
		if(!empty($cartId)) {
			// get membership cart data
			$cartData =  $this->model_common->getDataFromTabel('MembershipCart', '*',  array('cartId' => $cartId),'','','',1);
			$buyerBillingData = '';
			if(!empty($cartData)) {
				$cartData = $cartData[0];
				// set buyers billing data of cart
				$buyerBillingData = json_decode($cartData->billingdetails);
				// get membership cart item data
				$cartMemItemData =  $this->model_common->getDataFromTabel('MembershipCartItem', '*',  array('cartId' => $cartId),'','cartItemId','DESC');
				
				if(!empty($cartMemItemData) && is_array($cartMemItemData)) {
					$cartItemData = $cartMemItemData[0]; // get cart space data
					//get logged user subscription details
					$whereSubcrip 		= array('tdsUid' => $this->userId);
					$subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', 'subscriptionType',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
					if(!empty($subcripDetails)) {
						$subscriptionType  = $subcripDetails[0]->subscriptionType; // set subscription type
						if($subscriptionType == 1) { //set space values for free type
							$spaceSize = bytestoMB($cartItemData->size,'mb');
							$spaceUnit = $this->lang->line('mb');
						} else { //set space values for paid type
							$spaceSize = bytestoMB($cartItemData->size,'gb');
							$spaceUnit = $this->lang->line('gb');
						}
						// set containers price if container exists
						if(isset($cartMemItemData[1]) && !empty($cartMemItemData[1])) {
							$containerPrice = $cartMemItemData[1]->totalPrice;
						}
					}	
					// set space price
					$spacePrice = $cartItemData->totalPrice;
				}
			}
		} else {
			redirect(base_url(lang().'/workprofile/'));
		}
		
		// get users seller details 
		$userSellerData = $this->model_common->getUserProfileData($this->userId);
		// set wizard section
		$this->session->set_userdata('wizardMediaSection',$this->router->fetch_method()); 
		// get vat percentage	
		$vatPercent  = $this->config->item('media_vat_percent');
		// calculate total price
		$totalPrice  = $spacePrice + $containerPrice;
		// set vat price of total 
		$vatPrice    = (($totalPrice*$vatPercent)/100);
		 // get user's showcase details
        $showcaseRes = getUserShowcaseId($this->userId);
		$this->data['spaceSize']        = $spaceSize;
		$this->data['spaceUnit']        = $spaceUnit;	
		$this->data['spacePrice']       = $spacePrice;
		$this->data['totalPrice']       = $totalPrice;
		$this->data['vatPrice']         = $vatPrice;
		$this->data['containerPrice']   = $containerPrice;		
		$this->data['buyerSettingData'] = $buyerBillingData;	
		$this->data['userSellerData']   = (!empty($userSellerData[0]))?$userSellerData[0]:'';
		$this->data['showcaseImagePath'] = $this->getprofileimage($showcaseRes);
        $this->data['innerPage'] = 'workProfile/wizardform/purchase_summary';
        $this->data['membership4menu'] = 'TabbedPanelsTabSelected';
		$this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
		$this->new_version->load('new_version','workProfile/wizardform/membership_cart_header',$this->data);
		
	}
	
	
    
    
    /**
     * Get user's profile image
     * @access: private
     * 
     */
     private function getprofileimage($workProfileDetails='') {
		//set image path
		$imagePath = (!empty($workProfileDetails->filePath) && !empty($workProfileDetails->fileName)) ? $workProfileDetails->filePath.$workProfileDetails->fileName : '';
		$userDefaultImage = $this->config->item('sectionIdImage32');
 
		$workprofileThumbImage = addThumbFolder($imagePath,'_m');	
		$workprofileImage = getImage($workprofileThumbImage,$userDefaultImage);
		return $workprofileImage;
	 }
    
    //----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to move positions of employment history
	 * @return string
	 */ 
	public function moveempposition() {
		$currentId =  decode($this->input->post('currentId'));
		$currentPos =  $this->input->post('currentPosition');
		$swapId =  decode($this->input->post('swapId'));
		$swapPos =  $this->input->post('swapPosition');
		$getPostion = $this->model_workprofile->shiftRecord($this->tableProfileEmpHistory,'empHistId',$currentId,$currentPos,$swapId,$swapPos);
		echo $getPostion;
	}
     
}
?>
