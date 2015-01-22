<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	 Description:
	 * The controller class "workShowcase" is meant to handle the processing of the "WorkShowcase" of "Work Profile" section
	 * It include functionality to fetch/add/edit Videos,Images,Written Material and Audios 
	 *
	 *  @package	Toadsquare
	 *  @subpackage	Module
	 *  @category	Controller
	 * Author Name: Gurutva Singh
	 * Date Created: 7 Februray 2012
	 * Date Modified: 8 Februray 2012	
*/

class workshowcase extends MX_Controller {
	
	private $workshowcaseMsg ='';//To show messages on views based on return values
	private $userId = NULL;
	private $workShowcaseMedia='TDS_ProfileMedia';
	private $mediaPath = '';
	function __construct()
	{
		$load = array(
			'model'		=> 'workprofile/model_workshowcase + workprofile/model_workprofile', //Assinging model name to get loaded
			'library' 	=> 'form_validation + upload + session',//This method will have the credentials validation 
			'language' 	=> 'workshowcase',//Assinging language file name.
			'helper' 	=> 'form + file'//Assinging helper file to get loaded
		);
		parent::__construct($load);		
		$this->userId= $this->isLoginUser();
		$this->mediaPath = "media/".LoginUserDetails('username')."/workProfile/" ;
	}
	
	function index()
	{
		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		
		$imageFileType=1;
		$videoFileType=2;
		$audioFileType=3;
		$wmFileType=4;
		
		$data['label']=$this->lang->language; 
		$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
		if(empty($userWorkProfileID)) 
		{
			$Upload_File_Name['error'] = 'Please Fill the Personal Information First ';
			set_global_messages($Upload_File_Name['error'], 'error');
			redirect('workprofile/workProfileForm');
		}
		else 
		{
			$workProfileId  = $userWorkProfileID[0]->workProfileId;
		}
		$data['WorkProfile'] = $WorkProfileData= $this->model_workprofile->workProfileForm($workProfileId,$this->userId);
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
		$data['fileMaxSize']= $fileMaxSize;
		$userFolder = MEDIAUPLOADPATH.LoginUserDetails('username');
		$data['video']['tableName'] = $this->workShowcaseMedia;
		
		$data['video']['listValues']  = $this->model_workshowcase->showWorkShowcaseMedia($workProfileId,$videoFileType);
		//print_r($data['video']['listValues']);die;
		$data['video']['count'] = count($data['video']['listValues']);
		$data['video']['currentEntityId'] = $workProfileId;	
		$data['video']['mediaType'] = $videoFileType;
		$data['video']['toggleId'] = 'video';
		$data['video']['sectionHeading'] = 'video';
		$data['video']['elementTable'] = $this->workShowcaseMedia;
		$data['video']['elementFieldId'] = 'workProfileId';
		//$data['video']['mediaPath'] = $userFolder.'/workshowcase/Videos';
		$data['video']['mediaPath'] = "media/".LoginUserDetails('username').'/workshowcase/Videos/';
		$data['video']['entityId'] = $workProfileId;
		$data['video']['mediaFileTypes'] = $this->config->item('videoAccept');			
		$data['video']['imgload'] = 0;
		$data['video']['uploadSection'] = 'workshowcase';
		
		//$data['audio']['listValues']  = $this->model_workshowcase->showWorkShowcaseAudios($workProfileId);
		$data['audio']['listValues']  = $this->model_workshowcase->showWorkShowcaseMedia($workProfileId,$audioFileType);
		
		$data['audio']['count'] = count($data['audio']['listValues']);
		$data['audio']['currentEntityId'] = $workProfileId;	
		$data['audio']['mediaType'] = $audioFileType;
		$data['audio']['toggleId'] = 'audio';
		$data['audio']['sectionHeading'] = 'audio';
		$data['audio']['elementTable'] = $this->workShowcaseMedia;
		$data['audio']['elementFieldId'] = 'workProfileId';
		//$data['audio']['mediaPath'] = $userFolder.'/workshowcase/Audios';
		$data['audio']['mediaPath'] ="media/".LoginUserDetails('username').'/workshowcase/Audios/';
		
		$data['audio']['mediaFileTypes'] = $this->config->item('audioAccept');		
		$data['audio']['imgload'] = 0;
		
		//$data['writMater']['listValues']  = $this->model_workshowcase->showWorkShowcaseWrittenMaterial($workProfileId);
		$data['writMater']['listValues']  = $this->model_workshowcase->showWorkShowcaseMedia($workProfileId,$wmFileType);
		
		$data['writMater']['count'] = count($data['writMater']['listValues']);
		$data['writMater']['currentEntityId'] = $workProfileId;	
		$data['writMater']['mediaType'] = 4;
		$data['writMater']['toggleId'] = 'writMater';
		$data['writMater']['sectionHeading'] = 'writtenMaterial';
		$data['writMater']['elementTable'] = $this->workShowcaseMedia;
		$data['writMater']['elementFieldId'] = 'workProfileId';
		$data['writMater']['mediaPath'] = $userFolder.'/workshowcase/WrittenMaterial';
		$data['writMater']['mediaPath'] = "media/".LoginUserDetails('username').'/workshowcase/WrittenMaterial/';
		$data['writMater']['mediaFileTypes'] = $this->config->item('writtenMaterialAccept');
		$data['writMater']['imgload'] = 0;
		
		//$data['imageShowcase']['listValues']  = $this->model_workshowcase->showWorkShowcaseImages($workProfileId);
		$data['imageShowcase']['listValues']  =$this->model_workshowcase->showWorkShowcaseMedia($workProfileId,$imageFileType);	
	//print_r($data['imageShowcase']['listValues']);
		$data['imageShowcase']['count'] = count($data['imageShowcase']['listValues']);
		$data['imageShowcase']['currentEntityId'] = $workProfileId;	
		$data['imageShowcase']['mediaType'] = 1;
		$data['imageShowcase']['toggleId'] = 'imageShowcase';
		$data['imageShowcase']['last'] = 'last';
		$data['imageShowcase']['sectionHeading'] = 'images';
		$data['imageShowcase']['elementTable'] = $this->workShowcaseMedia;
		$data['imageShowcase']['elementFieldId'] = 'workProfileId';
		//$data['imageShowcase']['mediaPath'] = $userFolder.'/workshowcase/Images';
		$data['imageShowcase']['mediaPath'] = "media/".LoginUserDetails('username').'/workshowcase/Images/';
		$data['imageShowcase']['mediaFileTypes'] = $this->config->item('imageAccept');
		$data['imageShowcase']['imgload'] = 1;
		$data['header']=$this->load->view('workshowcase/navigationMenu','',true);
		
		//$this->template->load('template','workshowcase/index',$data);
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true,
							'helpSection'=>'portfolio'
				  );
			$leftView='dashboard/help_workprofile_sections';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workshowcase/index',$data);
	}	
	
	
	function addMoreVideos()
	{
		$workProfileId = '';
		$mediaType = 'Videos';
		$data['label']= $this->lang->language;
		$data['showcaseTitle'] = '';
		$data['showcaseDesc'] = '';
		$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
		//If no workprofile is there it will redirect us on Personal Information page with a message 
		if(count($userWorkProfileID)==0) 
		{
			redirect('workProfile/workProfileForm/flag');//calls the private methos to load the personal info page
		}
		else{
			$workProfileId  = $userWorkProfileID[0]->workProfileId;
		}
		$data['WorkProfileId'] = $workProfileId;
		if($this->input->post('save')){
			$errorConfig = array(
				   array(
						 'field'   => 'showcaseTitle',
						 'label'   =>  $data['label']['showcaseTitle'],
						 'rules'   => 'trim|required|xss_clean'
					  ),
					   array(
						 'field'   => 'showcaseDesc',
						 'label'   =>  $data['label']['showcaseDesc'],
						 'rules'   => 'trim|required|xss_clean'
					  ),
				);
			$this->form_validation->set_rules($errorConfig); //Setting rules for validation
			$this->form_validation->set_error_delimiters('<span class="required validation_error">', '</span>');
			if($this->form_validation->run())
			{
				$uploadedData = array();
				$mediaName = '';
				$mediaSize = '';
				$mediaFile = array();
				if($_FILES['userfile']['name'] !=''){
					$uploadedData = $this->do_upload($_FILES,'Videos');
				if(!isset($uploadedData['error'])){
						$mediaName = $uploadedData['upload_data']['file_name'];
						$mediaSize = $uploadedData['upload_data']['file_size'];
				}else{
					$Upload_File_Name['error'] = $uploadedData['error'];
					set_global_messages($Upload_File_Name['error'], 'error');
					redirect("workProfile/workshowcase/addMoreVideos");
				}
				}
				$mediaFile['mediaName'] = $mediaName;
				$mediaFile['mediaSize'] = $mediaSize;
				
				if($this->input->post('mediaId') != 0){
					$workProfileId = $this->model_workshowcase->EntryRecord($_POST, $mediaFile,$workProfileId,$mediaType);
					$Upload_File_Name['error'] = 'Video Updated successfully!!';
					set_global_messages($Upload_File_Name['error'], 'success');
					redirect("workProfile/workshowcase/showWorkShowcaseVideos");
				}else
				{
					$workProfileId = $this->model_workshowcase->EntryRecord($_POST, $mediaFile,$workProfileId,$mediaType);
					$Upload_File_Name['error'] = 'Video Inserted successfully!!';
					set_global_messages($Upload_File_Name['error'], 'success');
					redirect("workProfile/workshowcase/showWorkShowcaseVideos");
				}
			}
			else
			{
				$data['showcaseTitle'] = $this->input->post('showcaseTitle');
				$data['showcaseDesc'] = $this->input->post('showcaseDesc');
				if(validation_errors())
				{
					$msg = array('errors' => validation_errors());			
				}
			}
		}
		$data['label']= $this->lang->language;
		$mediaId =  $this->uri->segment(5);
		$data['recordSet'] = $this->model_workshowcase->videosRecordSet($mediaId);
		//$this->template->load('template','workshowcase/add_more_videos',$data);
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_workprofile';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workshowcase/add_more_videos',$data);
	}
	
	function addMoreAudios()
	{
		$workProfileId = '';
		$mediaType = 'Audios';
		$data['label']= $this->lang->language;
		$data['showcaseTitle'] = '';
		$data['showcaseDesc'] = '';
		$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
		//If no workprofile is there it will redirect us on Personal Information page with a message 
		if(count($userWorkProfileID)==0) 
		{
			redirect('workProfile/workProfileForm/flag');//calls the private methos to load the personal info page
		}
		else{
			$workProfileId  = $userWorkProfileID[0]->workProfileId;
		}
		$data['WorkProfileId'] = $workProfileId;
		if($this->input->post('save')){
			$errorConfig = array(
				   array(
						 'field'   => 'showcaseTitle',
						 'label'   =>  $data['label']['showcaseTitle'],
						 'rules'   => 'trim|required|xss_clean'
					  ),
					   array(
						 'field'   => 'showcaseDesc',
						 'label'   =>  $data['label']['showcaseDesc'],
						 'rules'   => 'trim|required|xss_clean'
					  ),
				);
			$this->form_validation->set_rules($errorConfig); //Setting rules for validation
			$this->form_validation->set_error_delimiters('<span class="required validation_error">', '</span>');
			if($this->form_validation->run())
			{
				$uploadedData = array();
				$mediaName = '';
				$mediaSize = '';
				$mediaFile = array();
				if($_FILES['userfile']['name'] !=''){
					$uploadedData = $this->do_upload($_FILES,'Audios');
				if(!isset($uploadedData['error'])){
						$mediaName = $uploadedData['upload_data']['file_name'];
						$mediaSize = $uploadedData['upload_data']['file_size'];
				}else{
					$Upload_File_Name['error'] = $uploadedData['error'];
					set_global_messages($Upload_File_Name['error'], 'error');
					redirect("workProfile/workshowcase/addMoreAudios");
				}
				}
				$mediaFile['mediaName'] = $mediaName;
				$mediaFile['mediaSize'] = $mediaSize;
				
				if($this->input->post('mediaId') != 0){
					$workProfileId = $this->model_workshowcase->EntryRecord($_POST, $mediaFile,$workProfileId,$mediaType);
					$Upload_File_Name['error'] = 'Audios Updated successfully!!';
					set_global_messages($Upload_File_Name['error'], 'success');
					redirect("workProfile/workshowcase/showWorkShowcaseAudios");
				}else
				{
					$workProfileId = $this->model_workshowcase->EntryRecord($_POST, $mediaFile,$workProfileId,$mediaType);
					$Upload_File_Name['error'] = 'Audios Inserted successfully!!';
					set_global_messages($Upload_File_Name['error'], 'success');
					redirect("workProfile/workshowcase/showWorkShowcaseAudios");
				}
			}
			else
			{
				$data['showcaseTitle'] = $this->input->post('showcaseTitle');
				$data['showcaseDesc'] = $this->input->post('showcaseDesc');
				if(validation_errors())
				{
					$msg = array('errors' => validation_errors());			
				}
			}
		}
		$data['label']= $this->lang->language;
		$mediaId =  $this->uri->segment(5);
		$data['recordSet'] = $this->model_workshowcase->videosRecordSet($mediaId);
		//$this->template->load('template','workshowcase/add_more_audios',$data);
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_workprofile';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workshowcase/add_more_audios',$data);
	}
	
	function addMoreWrittenMaterial()
	{
		$workProfileId = '';
		$mediaType = 'WrittenMaterial';
		$data['label']= $this->lang->language;
		$data['showcaseTitle'] = '';
		$data['showcaseDesc'] = '';
		$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
		//If no workprofile is there it will redirect us on Personal Information page with a message 
		if(count($userWorkProfileID)==0) 
		{
			redirect('workProfile/workProfileForm/flag');//calls the private methos to load the personal info page
		}
		else{
			$workProfileId  = $userWorkProfileID[0]->workProfileId;
		}
		$data['WorkProfileId'] = $workProfileId;
		if($this->input->post('save')){
			$errorConfig = array(
				   array(
						 'field'   => 'showcaseTitle',
						 'label'   =>  $data['label']['showcaseTitle'],
						 'rules'   => 'trim|required|xss_clean'
					  ),
					   array(
						 'field'   => 'showcaseDesc',
						 'label'   =>  $data['label']['showcaseDesc'],
						 'rules'   => 'trim|required|xss_clean'
					  ),
				);
			$this->form_validation->set_rules($errorConfig); //Setting rules for validation
			$this->form_validation->set_error_delimiters('<span class="required validation_error">', '</span>');
			if($this->form_validation->run())
			{
				$uploadedData = array();
				$mediaName = '';
				$mediaSize = '';
				$mediaFile = array();
				if($_FILES['userfile']['name'] !=''){
					$uploadedData = $this->do_upload($_FILES,'WrittenMaterial');
				if(!isset($uploadedData['error'])){
						$mediaName = $uploadedData['upload_data']['file_name'];
						$mediaSize = $uploadedData['upload_data']['file_size'];
				}else{
					$Upload_File_Name['error'] = $uploadedData['error'];
					set_global_messages($Upload_File_Name['error'], 'error');
					redirect("workProfile/workshowcase/addMoreWrittenMaterial");
				}
				}
				$mediaFile['mediaName'] = $mediaName;
				$mediaFile['mediaSize'] = $mediaSize;
				
				if($this->input->post('mediaId') != 0){
					$workProfileId = $this->model_workshowcase->EntryRecord($_POST, $mediaFile,$workProfileId,$mediaType);
					$Upload_File_Name['error'] = 'Written Material Updated successfully!!';
					set_global_messages($Upload_File_Name['error'], 'success');
					redirect("workProfile/workshowcase/showWorkShowcaseWrittenMaterial");
				}else
				{
					$workProfileId = $this->model_workshowcase->EntryRecord($_POST, $mediaFile,$workProfileId,$mediaType);
					$Upload_File_Name['error'] = 'Written Material Inserted successfully!!';
					set_global_messages($Upload_File_Name['error'], 'success');
					redirect("workProfile/workshowcase/showWorkShowcaseWrittenMaterial");
				}
			}
			else
			{
				$data['showcaseTitle'] = $this->input->post('showcaseTitle');
				$data['showcaseDesc'] = $this->input->post('showcaseDesc');
				if(validation_errors())
				{
					$msg = array('errors' => validation_errors());			
				}
			}
		}
		$data['label']= $this->lang->language;
		$mediaId =  $this->uri->segment(5);
		$data['recordSet'] = $this->model_workshowcase->videosRecordSet($mediaId);
		//$this->template->load('template','workshowcase/add_more_written_materials',$data);
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_workprofile';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workshowcase/add_more_written_materials',$data);
	}
	
	function addMoreImages()
	{
		$workProfileId = '';
		$mediaType = 'Images';
		$data['label']= $this->lang->language;
		$data['showcaseTitle'] = '';
		$data['showcaseDesc'] = '';
		$userWorkProfileID  = $this->model_workprofile->getWorkProfileID($this->userId);
		//If no workprofile is there it will redirect us on Personal Information page with a message 
		if(count($userWorkProfileID)==0) 
		{
			redirect('workProfile/workProfileForm/flag');//calls the private methos to load the personal info page
		}
		else{
			$workProfileId  = $userWorkProfileID[0]->workProfileId;
		}
		$data['WorkProfileId'] = $workProfileId;
		if($this->input->post('save')){
			$errorConfig = array(
				   array(
						 'field'   => 'showcaseTitle',
						 'label'   =>  $data['label']['showcaseTitle'],
						 'rules'   => 'trim|required|xss_clean'
					  ),
					   array(
						 'field'   => 'showcaseDesc',
						 'label'   =>  $data['label']['showcaseDesc'],
						 'rules'   => 'trim|required|xss_clean'
					  ),
				);
			$this->form_validation->set_rules($errorConfig); //Setting rules for validation
			$this->form_validation->set_error_delimiters('<span class="required validation_error">', '</span>');
			if($this->form_validation->run())
			{
				$uploadedData = array();
				$mediaName = '';
				$mediaSize = '';
				$mediaFile = array();
				if($_FILES['userfile']['name'] !=''){
					$uploadedData = $this->do_upload($_FILES,'Images');
				if(!isset($uploadedData['error'])){
						$mediaName = $uploadedData['upload_data']['file_name'];
						$mediaSize = $uploadedData['upload_data']['file_size'];
				}else{
					$Upload_File_Name['error'] = $uploadedData['error'];
					set_global_messages($Upload_File_Name['error'], 'error');
					redirect("workProfile/workshowcase/addMoreImages");
				}
				}
				$mediaFile['mediaName'] = $mediaName;
				$mediaFile['mediaSize'] = $mediaSize;
				
				if($this->input->post('mediaId') != 0){
					$workProfileId = $this->model_workshowcase->EntryRecord($_POST, $mediaFile,$workProfileId,$mediaType);
					$Upload_File_Name['error'] = 'Image Updated successfully!!';
					set_global_messages($Upload_File_Name['error'], 'success');
					redirect("workProfile/workshowcase/showWorkShowcaseImages");
				}else
				{
					$workProfileId = $this->model_workshowcase->EntryRecord($_POST, $mediaFile,$workProfileId,$mediaType);
					$Upload_File_Name['error'] = 'Image Inserted successfully!!';
					set_global_messages($Upload_File_Name['error'], 'success');
					redirect("workProfile/workshowcase/showWorkShowcaseImages");
				}
			}
			else
			{
				$data['showcaseTitle'] = $this->input->post('showcaseTitle');
				$data['showcaseDesc'] = $this->input->post('showcaseDesc');
				if(validation_errors())
				{
					$msg = array('errors' => validation_errors());			
				}
			}
		}
		$data['label']= $this->lang->language;
		$mediaId =  $this->uri->segment(5);
		$data['recordSet'] = $this->model_workshowcase->videosRecordSet($mediaId);
		//$this->template->load('template','workshowcase/add_more_images',$data);
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/workprofile'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_workprofile';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','workshowcase/add_more_images',$data);
	}

	
	function deleteMedia(){
		$mediaId = decode($this->input->post('mediaForm'));
		$mediaType = $this->input->post('mediaType');
		$deleteMediaType  = $this->model_workshowcase->deleteMediaType($mediaId);
		$Upload_File_Name['error'] = $mediaType.' have been deleted successfully.';
		set_global_messages($Upload_File_Name['error'], 'success');
		if($mediaType == 'Vieos')
			redirect('workProfile/workshowcase/showWorkShowcaseVideos');
		else if($mediaType == 'Audios')
			redirect('workProfile/workshowcase/showWorkShowcaseAudios');
		if($mediaType == 'WrittenMaterial')
			redirect('workProfile/workshowcase/showWorkShowcaseWrittenMaterial');
		if($mediaType == 'Images')
			redirect('workProfile/workshowcase/showWorkShowcaseImages');
		else
			redirect('workProfile/workshowcase/showWorkShowcaseVideos');
	}
	
	/**
		* Insert/Update a new row into the specified database table from the common function
		* @access public
	*/
	
	function do_upload($imageFiles,$mediaType)
	{
		//echo $mediaType;
		$data = '';
		$userFolder = MEDIAUPLOADPATH.LoginUserDetails('username');
	
		if(!is_dir($userFolder)){
			mkdir($userFolder, 0, true);
		}

		$FilePath = $userFolder.'/workshowcase/'.$mediaType;
		if(!is_dir($FilePath)){ 
					mkdir($FilePath, 0, true);}
					
		//	echo "<br />media type folder".$FilePath;
		
		$FilePathUpload = MEDIAUPLOADPATH.LoginUserDetails('username').'/workshowcase/'.$mediaType;

		
		$_FILES['userfile']['name']     = $imageFiles['userfile']['name'];
		$_FILES['userfile']['type']     = $imageFiles['userfile']['type'];
		$_FILES['userfile']['tmp_name'] = $imageFiles['userfile']['tmp_name'];
		$_FILES['userfile']['error']    = $imageFiles['userfile']['error'];
		$_FILES['userfile']['size']     = $imageFiles['userfile']['size'];
		
		if($mediaType =='Videos')
			$config['allowed_types'] = "flv";
		else if($mediaType =='Audios')
			$config['allowed_types'] = "mp3";
		else if($mediaType =='WrittenMaterial')
			$config['allowed_types'] = "txt";
		else if($mediaType =='Images')
			$config['allowed_types'] = "gif|jpg|png|jpeg";
		else
			$config['allowed_types'] = "flv";
			
        $config['remove_spaces']= TRUE;
        $config['max_size'] = "122880";
		
		$this->upload->initialize($config);
		$this->upload->set_upload_path($FilePathUpload);
		$this->load->library('my_upload', $config);
		if (!$this->upload->do_upload()){
			$data = array('error' => $this->upload->display_errors());
		}
		else{
			$data = array('upload_data' => $this->upload->data());
		}
		return $data;
	}	
	
}
?>
