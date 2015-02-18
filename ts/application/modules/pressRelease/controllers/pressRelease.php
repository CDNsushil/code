<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Todasquare frontend Controller Class
 *
 *  Manage Frontend Details (pressRelease)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */
class pressRelease extends MY_Controller {
	private $data = array();
	private $mediaPath = '';
	private $pressReleaseData=array(
										'id' => 0,
										'title' => '',
										'description' => '',
										'date' => '',
										'videoFile' => ''
								   );
	
	function __construct() {
		
		parent::__construct();	
		//Load required Model, Library, language and Helper files
		$this->mediaPath = "media/admin/pressRelease/" ;	
		$this->load->model(array('model_pressrelease'));
		$this->load->language('admin_template');
		$this->load->library(array('admin_template','language/lang_library','lib_sub_master_media'));
				
	}
	
	function index($pressReleaseId=0){
		$this->head->add_css($this->config->item('system_css').'frontend.css');
		
		$data['pressReleaseId'] = $pressReleaseId;
		
		
		$get_press_news_list = $this->model_pressrelease->get_press_news_list();
		$press_listing="";
		if($get_press_news_list['get_num_rows'] > 0)
		{
			$count=0;
			foreach($get_press_news_list['get_result']  as $press_news_list)
			{
				$press_news_list_month = $this->model_pressrelease->press_news_list_month($press_news_list->date_trunc);
				$press_news_list_month['monthName'] = $press_news_list->date_trunc;
				$press_listing[$count] = $press_news_list_month;
				$count++;
			}
	
		}
		$data['press_list'] =$press_listing;
		
		$this->new_version->load("new_version",'pressRelease_list',$data);
	}
	
	function details($pressReleaseId=0){
		
		
		if(is_numeric($pressReleaseId) && $pressReleaseId > 0){
			$whereCondition=array('type'=>1,'id'=>$pressReleaseId);
			$pressRelease = $this->model_common->getDataFromTabel('PressReleaseNews', '*',  $whereCondition, '', $orderBy='id', $order='DESC', $limit=1, $offset=0, $resultInArray=true  );
			if($pressRelease){
				$this->head->add_css($this->config->item('system_css').'frontend.css');
				$this->pressReleaseData=$pressRelease[0];
				$PressReleaseNewsMaterial = $this->model_pressrelease->PressReleaseNewsMaterial($pressReleaseId);
				$this->pressReleaseData['PressReleaseNewsMaterial']=$PressReleaseNewsMaterial;
				
				$this->new_version->load("new_version",'pressRelease_details',$this->pressReleaseData);	
			}else{
				redirect('pressRelease/index');
			}
			
		}else{
			redirect('pressRelease/index');
		}
		
		
	}
	
	
	/**
	* Post all tip data to edit pressRelease page.
	*/
	function add_edit_pressRelease($pressReleaseId=0){ 	 
        if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		
		$mediaPath=$this->mediaPath.$pressReleaseId.'/';
		$fileMaxSize=$this->config->item('image5MBSize');
		$mediaFileTypes=$this->config->item('prNewsAccept');
		
		
		
		$PressReleaseNewsMaterial=false;
		$actionHeading=$this->lang->line('addPressRelease');
		
        if(is_numeric($pressReleaseId) && $pressReleaseId > 0){
			$whereCondition=array('type'=>1,'id'=>$pressReleaseId);
			$pressRelease = $this->model_common->getDataFromTabel('PressReleaseNews', '*',  $whereCondition, '', $orderBy='id', $order='DESC', $limit=1, $offset=0, $resultInArray=true  );
			if($pressRelease){
				$this->pressReleaseData=$pressRelease[0];
				$actionHeading=$this->lang->line('updatePressRelease');
				$PressReleaseNewsMaterial = $this->model_pressrelease->PressReleaseNewsMaterial($pressReleaseId);
				
					
			}
		}
		$this->pressReleaseData['pressReleaseId']=$pressReleaseId;
		$this->pressReleaseData['actionHeading']=$actionHeading;
		$this->pressReleaseData['PressReleaseNewsMaterial']=$PressReleaseNewsMaterial;
		$this->pressReleaseData['mediaPath']=$mediaPath;
		$this->pressReleaseData['fileMaxSize']=$fileMaxSize;
		$this->pressReleaseData['mediaFileTypes']=$mediaFileTypes;
        $this->admin_template->load('admin/admin_template','pressRelease/add_edit_pressRelease',$this->pressReleaseData);
    }
    
	/**
	* pressRelease insert to db.
	**/	
	function save_pressRelease()
	{
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}	
		$config = array(
               array(
                     'field'   => 'pressReleaseId',
                     'label'   => 'pressReleaseId',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'videoFile',
                     'label'   => 'videoFile',
                     'rules'   => 'trim|xss_clean'
                  ),   
               array(
                     'field'   => 'title',
                     'label'   => 'Title',
                     'rules'   => 'trim|xss_clean|required'
                  ),   
               array(
                     'field'   => 'description',
                     'label'   => 'Description',
                     'rules'   => 'trim|xss_clean|required'
                  )
				  ,   
               array(
                     'field'   => 'pressReleaseDate',
                     'label'   => 'Release Date',
                     'rules'   => 'trim|xss_clean'
                  )
            );

		$this->form_validation->set_rules($config); 
		
		$pressReleaseId=$this->input->post('pressReleaseId');
		$pressReleaseId=is_numeric($pressReleaseId)?$pressReleaseId:0;
		$videoFile=$this->input->post('videoFile');
		$pressReleaseDate=$this->input->post('pressReleaseDate')==''?currntDateTime('Y-m-d'):$this->input->post('pressReleaseDate');
		$pressReleaseDate=date('Y-m-d',strtotime($pressReleaseDate));
		$title=$this->input->post('title');
		$description=$this->input->post('description');
		
		if($this->input->post('save')=='Save' && $this->form_validation->run()){
			
			$this->pressReleaseData=array(
			
										'title' => pg_escape_string($title),
										'description' => pg_escape_string($description),
										'date' => $pressReleaseDate,
										'videoFile' => $videoFile,
										'type' => 1,
								   );
								   
			if($pressReleaseId > 0){
				$this->model_common->editDataFromTabel('PressReleaseNews',$this->pressReleaseData, array('id'=>$pressReleaseId));
				$this->session->set_flashdata('msg',$this->lang->line('messagePRUpdated'));
			}else{
				$pressReleaseId = $this->model_common->addDataIntoTabel('PressReleaseNews', $this->pressReleaseData);
				
				$this->session->set_flashdata('msg',$this->lang->line('messagePRAdd'));
			}
			
			/*if(isset($_FILES)){
				$mediaPath=$this->mediaPath.$pressReleaseId.'/';
				$fileMaxSize=$this->config->item('image5MBSize');
				$PressReleaseNewsMaterial=false;
				foreach($_FILES as $k=>$file){
					if(isset($_FILES[$k]['name']) && ($_FILES[$k]['name'] !='') &&  ($_FILES[$k]['error'] == 0)){
						$uploadedData = $this->lib_sub_master_media->do_upload($_FILES, $mediaPath,'','pressRelease',$k,$fileMaxSize);
						if(!isset($uploadedData['error'])){			
								$fileName = $uploadedData['upload_data']['file_name'];
								$rawFileName=$uploadedData['upload_data']['raw_name'].'.'.$uploadedData['upload_data']['file_ext'];
								$fileTitle = $this->input->post($k.'Title');
								
								if(strstr($uploadedData['upload_data']['file_type'],'application')){
									$fileType=4;
								}elseif(strstr($uploadedData['upload_data']['file_type'],'image')){
									$fileType=1;
								}elseif(strstr($uploadedData['upload_data']['file_type'],'video')){
									$fileType=2;
								}elseif(strstr($uploadedData['upload_data']['file_type'],'audio')){
									$fileType=3;
								}else{
									$fileType=0;
								}
								
								$mediaFileData=array(
										'filePath' => $mediaPath,
										'fileName' => $fileName,
										'fileType' => $fileType,
										'rawFileName' => $rawFileName,
										'fileSize' => $uploadedData['upload_data']['file_size']
								);
								
								$fileId = $this->model_common->addDataIntoTabel('TDS_MediaFile', $mediaFileData);
								
								$PressReleaseNewsMaterial[]=array(
										'pressReleaseNewsId' => $pressReleaseId,
										'fileId' => $fileId,
										'fileTitle' => $fileTitle
								);
								
						}
					}
				}
				
				if($PressReleaseNewsMaterial){
					$this->model_common->insertBatch('PressReleaseNewsMaterial', $PressReleaseNewsMaterial);
				}
				
			}*/
			
		
			$redirect='pressRelease/add_edit_pressRelease/'.$pressReleaseId;
			redirect($redirect);
			
		}else{
			$this->pressReleaseData=array(
										'id' => $pressReleaseId,
										'title' => $title,
										'description' => $description,
										'date' => $pressReleaseDate,
										'videoFile' => $videoFile
								   );
			$actionHeading=$this->lang->line('addPressRelease');
			$this->pressReleaseData['actionHeading']=$actionHeading;	
			$this->pressReleaseData['PressReleaseNewsMaterial']="";				   
			
			$this->admin_template->load('admin/admin_template','pressRelease/add_edit_pressRelease',$this->pressReleaseData);
		}
	}
	
	
	function add_edit_PressReleaseNewsMaterial(){
		
		$pressReleaseId=$this->input->post('pressReleaseId');
		$section=$this->input->post('section');
		$post=$this->input->post();
		
		if(is_numeric($pressReleaseId) && ($pressReleaseId > 0) && $post && is_array($post) && count($post) > 0){
			
			
			$elements=false;
			$files=false;
			if($section=='news'){
				$mediaPath= "media/admin/news/".$pressReleaseId.'/';	
			}else{
				$mediaPath=$this->mediaPath.$pressReleaseId.'/';
			}
			$fileType=getFileType($post['fileInput']);
			
			$mediaFileData=array(
										'filePath' => $mediaPath,
										'fileName' => $post['fileName'],
										'fileType' => $fileType,
										'rawFileName' => $post['fileInput'],
										'fileSize' => $post['fileSize']
								);
				
			if(is_numeric($post['fileId']) && ($post['fileId']>0) ){
				$fileRes=$this->model_common->getDataFromTabel('MediaFile','fileName,filePath',  'fileId', $post['fileId'], '', 'ASC', 1, $offset=0, true );
				if($fileRes){
					$files=true;
					if(strlen($post['fileName']) >=4 && strlen($post['fileInput']) >=4){
						$file=$fileRes[0];
						$filePath=trim($file['filePath']);
						$fileName=trim($file['fileName']);
						if(is_dir($filePath) && $fileName !=''){
							$fpLen=strlen($filePath);
							if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
								$filePath=$filePath.DIRECTORY_SEPARATOR;
							}
							findFileNDelete($filePath,$fileName);
						}
					}else{
						$mediaFileData=false;
					}
				}
			}
			
			if($mediaFileData){
				if($files){
					$this->model_common->editDataFromTabel('MediaFile', $mediaFileData, 'fileId', $post['fileId']);
				}else{
					$mediaFileData['jobStsatus']='UPLOADING';
					$post['fileId']=$this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);
				}
			}
			
			$PressReleaseNewsMaterial=array(
					'pressReleaseNewsId' => $pressReleaseId,
					'fileId' => $post['fileId'],
					'fileTitle' => $post['fileTitle']
			);
			
			if(is_numeric($post['id']) && ($post['id']>0) ){
				$countResult=$this->model_common->countResult('PressReleaseNewsMaterial','id',$post['id'],1);
				if($countResult > 0){
					$elements=true;
				}
			}
			
			$PressReleaseNewsMaterial=array(
					'pressReleaseNewsId' => $pressReleaseId,
					'fileId' => $post['fileId'],
					'fileTitle' => $post['fileTitle']
			);
			
			if($elements){
				$this->model_common->editDataFromTabel('PressReleaseNewsMaterial', $PressReleaseNewsMaterial, 'id', $post['id']);
			}else{
				$mediaFileData['jobStsatus']='UPLOADING';
				$this->model_common->addDataIntoTabel('PressReleaseNewsMaterial', $PressReleaseNewsMaterial);
			}
			echo '<input type="hidden" name="MediaFileId" id="MediaFileId" value="'.$post['fileId'].'" />';
		}	
	}
	
	/**
	* Remove selected pressRelease.
	*/
	function delete_pressRelease($pressReleaseId)
    {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}	
		if($pressReleaseId > 0 )
		{
			$this->model_common->deleteRowFromTabel($table='PressReleaseNews', array('id'=>$pressReleaseId));
			$this->session->set_flashdata('msg',$this->lang->line('messagePRDelete'));
			redirect('pressRelease/listing');
		}
		else{
			$this->session->set_flashdata('msg',$this->lang->line('messagePRNotDelete'));
			redirect('pressRelease/listing');
		}
	}
	
	function listing($pressReleaseId=0) 
	{
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}	
		$data['pressReleaseId'] = $pressReleaseId;
		$whereCondition=array('type'=>1);
		$press_list = $this->model_common->getDataFromTabel('PressReleaseNews', '*',  $whereCondition, '', $orderBy='date', $order='DESC', $limit=0, $offset=0, $resultInArray=true  );
		$data['press_list'] = $press_list;
		$this->admin_template->load('admin/admin_template','pressRelease/admin_pressRelease_list',$data);
	}
	
	
}
