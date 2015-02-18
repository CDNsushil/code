<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Todasquare frontend Controller Class
 *
 *  Manage Frontend Details (news)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */
class settings extends MY_Controller {
	private $data = array();
	private $mediaPath = '';
	private $newsData=array(
								'id' => 0,
								'title' => '',
								'description' => '',
								'date' => '',
								'videoFile' => '',
								'source' => '',
								'url' => ''
								
							);
	
	function __construct() {
		parent::__construct();	
		//Load required Model, Library, language and Helper files
		$this->mediaPath = "media/admin/news/" ;
		$this->load->model('model_news');	
		$this->load->language('admin_template');
		$this->load->library(array('language/lang_library','lib_sub_master_media'));

	}
	
	
	function index($pressReleaseId=0){
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}	
		$data['pressReleaseId'] = $pressReleaseId;
		$whereCondition=array('type'=>2);
		$press_list = $this->model_common->getDataFromTabel('PressReleaseNews', '*',  $whereCondition, '', $orderBy='date', $order='DESC', $limit=0, $offset=0, $resultInArray=true  );
		$data['press_list'] = $press_list;
		$this->toad_admin_template->load('toad_admin_template','manage_news/admin_news_list', $data);
	}
	
	/**
	* Post all tip data to edit news page.
	*/
	function add_edit_news($pressReleaseId=0){ 	 
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
		$actionHeading=$this->lang->line('addnews');
        if(is_numeric($pressReleaseId) && $pressReleaseId > 0){
			$whereCondition=array('type'=>2,'id'=>$pressReleaseId);
			$news = $this->model_common->getDataFromTabel('PressReleaseNews', '*',  $whereCondition, '', $orderBy='id', $order='DESC', $limit=1, $offset=0, $resultInArray=true  );
			if($news){
				$this->newsData=$news[0];
				
				$actionHeading=$this->lang->line('updatenews');
				$PressReleaseNewsMaterial = $this->model_news->PressReleaseNewsMaterial($pressReleaseId);

				
				if(!empty($this->newsData['videoFile']) && $this->newsData['videoFile'] > 0)
				{
					$whereCondition=array('fileId'=>$this->newsData['videoFile']);
					$MediaFileData = $this->model_common->getDataFromTabel('MediaFile', '*',  $whereCondition, '', $orderBy='fileId', $order='DESC', $limit=1, $offset=0, $resultInArray=true  );
					if($MediaFileData)
					{
						$this->newsData['MediaFileData']=$MediaFileData[0];
					}else{
						$this->newsData['MediaFileData']=false;
					}
				}
				
			}
		}
		$this->newsData['pressReleaseId']=$pressReleaseId;
		$this->newsData['actionHeading']=$actionHeading;
		$this->newsData['PressReleaseNewsMaterial']=$PressReleaseNewsMaterial;
		$this->newsData['mediaPath']=$mediaPath;
		$this->newsData['fileMaxSize']=$fileMaxSize;
		$this->newsData['mediaFileTypes']=$mediaFileTypes;
	    $this->toad_admin_template->load('toad_admin_template','manage_news/add_edit_news', $this->newsData);
	}
    
	/**
	* news insert to db.
	**/	
	function save_news(){
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
                     'field'   => 'newsDate',
                     'label'   => 'Release Date',
                     'rules'   => 'trim|xss_clean'
                  ),
              array(
                     'field'   => 'source',
                     'label'   => 'Source',
                     'rules'   => 'trim|xss_clean'
                  ),
              array(
                     'field'   => 'url',
                     'label'   => 'Url',
                     'rules'   => 'trim|xss_clean'
                  )      
            );

		$this->form_validation->set_rules($config); 
		
		$pressReleaseId=$this->input->post('pressReleaseId');
		$pressReleaseId=is_numeric($pressReleaseId)?$pressReleaseId:0;
		$videoFile=$this->input->post('videoFile');
		$newsDate=$this->input->post('newsDate')==''?currntDateTime('Y-m-d'):$this->input->post('newsDate');
		$newsDate=date('Y-m-d',strtotime($newsDate));
		$title=$this->input->post('title');
		$description=$this->input->post('description');
		$source=$this->input->post('source');
		$url=$this->input->post('url');
		
		if($this->input->post('save')=='Save' && $this->form_validation->run()){
			
			$this->newsData=array(
			
										'title' => pg_escape_string($title),
										'description' => pg_escape_string($description),
										'date' => $newsDate,
										'type'=>2,
										'source'=>$source,
										'url'=>$url
								   );
								   
			if($pressReleaseId > 0){
				$this->model_common->editDataFromTabel('PressReleaseNews',$this->newsData, array('id'=>$pressReleaseId));
				$this->session->set_flashdata('msg',$this->lang->line('messagePRAdd'));
			}else{
				$pressReleaseId = $this->model_common->addDataIntoTabel('PressReleaseNews', $this->newsData);
				$this->session->set_flashdata('msg',$this->lang->line('messagePRUpdated'));
			}
			
			$redirect='admin/settings/manage_news/add_edit_news/'.$pressReleaseId;
			redirect($redirect);
		}else{
			$this->newsData=array(
										'id' => $pressReleaseId,
										'title' => $title,
										'description' => $description,
										'date' => $newsDate,
										'videoFile' => $videoFile
								   );
			$actionHeading=$this->lang->line('addnews');
			$this->newsData['actionHeading']=$actionHeading;
			$this->newsData['PressReleaseNewsMaterial']="";			
			$this->newsData['source']="";			
			$this->newsData['url']="";					   
			$this->toad_admin_template->load('toad_admin_template','manage_news/add_edit_news', $this->newsData);
		}
	}

	/**
	* Remove selected news.
	*/
	function delete_news($pressReleaseId){
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}	
		if($pressReleaseId > 0 )
		{
			$this->model_common->deleteRowFromTabel($table='PressReleaseNews', array('id'=>$pressReleaseId));
			$this->session->set_flashdata('msg',$this->lang->line('messagePRDelete'));
			redirect('admin/settings/manage_news');
		}
		else{
			$this->session->set_flashdata('msg',$this->lang->line('messagePRNotDelete'));
			redirect('admin/settings/manage_news');
		}
	}
	
	
	/*
	 *********************************** 
	 * add and edit news videos
	 ***********************************  
	 */
	
	
	
	
	function add_edit_news_video(){
		
		$pressReleaseId=$this->input->post('pressReleaseId');
		$post=$this->input->post();
		
		
		if(is_numeric($pressReleaseId) && ($pressReleaseId > 0) && $post && is_array($post) && count($post) > 0){
			
			
			$elements=false;
			$files=false;
			$mediaPath=$this->mediaPath.$pressReleaseId.'/';
			$fileType=getFileType($post['fileInput']);
			
			
			
			if($post['isExternal']=="t")
			{
				$mediaFileData=array(
										'filePath' => $post['embbededURL'],
										'fileName' => NULL,
										'fileType' => $fileType,
										'tdsUid' => isLoginUser(),
										'rawFileName' => NULL,
										'fileSize' => NULL,
										'isExternal' => $post['isExternal']
								);
				
			}else
			{
				$mediaFileData=array(
										'filePath' => $mediaPath,
										'fileName' => $post['fileName'],
										'fileType' => $fileType,
										'tdsUid' => isLoginUser(),
										'rawFileName' => $post['fileInput'],
										'fileSize' => $post['fileSize'],
										'isExternal' => $post['isExternal']
								);
			}
			
				
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
					}/*else{
						$mediaFileData=false;
					}*/
				}
				
				$mediaFileData['jobStsatus']='UPLOADING';
				if($mediaFileData){
					$this->model_common->editDataFromTabel('MediaFile', $mediaFileData, 'fileId', $post['fileId']);
				}
				
			}else
			{
				//insert news video
				$mediaFileData['jobStsatus']='UPLOADING';
				$post['fileId']=$this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);
				
				//update news video id
				$pressReleaseData = array('videoFile' => $post['fileId']);
				$this->model_common->editDataFromTabel('PressReleaseNews', $pressReleaseData, 'id', $pressReleaseId);
				
			}
			echo '<input type="hidden" name="MediaFileId" id="MediaFileId" value="'.$post['fileId'].'" />';
		}	
	}
	
	/*
	 ************************************** 
	 * This function is used to delete news video and update fileId
	 **************************************
	 */  
	
	public function deleteNewsVideoRowAdmin() {
		$ID = explode(',',$this->input->post('val1'));
		$tbl = trim($this->input->post('val2'));
		
		$field = trim($this->input->post('val3'));
		$fileId = $this->input->post('val4');
		$updateId = $this->input->post('val5');
		
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
		
		//update deleted video id
		$pressReleaseData = array('videoFile' => 0);
		$this->model_common->editDataFromTabel('PressReleaseNews', $pressReleaseData, 'id', $updateId);
		
	}
	
	
	
	
}
