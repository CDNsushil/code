<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Todasquare media Controller Class
 *
 *  manage media details (Film & Video, Music & Audio, Photography & Art,
 *	 Writing & publishing, Education Material)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class media extends MX_Controller {
	private $data = array();
	private $dirCacheMedia = '';
	private $dirUploadMedia = '';
	private $userId = null;
	private $IndustryId = 0;
	/**
	 * Constructor
	 */
	function __construct() { 
		//Load required Model, Library, language and Helper files
			$load = array(
				'model'		=> 'media/model_media',  	
				'language' 	=> 'media',							
				'config'	=>	'media/media'   		
			);
			parent::__construct($load);		
			
			$this->userId= $this->isLoginUser();
			// Load  path of css and cache file path
			$this->dirCacheMedia = 'cache/media/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/project/'; 
			$this->dirTrash = 'trash/'.LoginUserDetails('username').'/project/'; 
			$this->data['dirUploadMedia'] = $this->dirUploadMedia; 
			$this->IndustryId=$this->getIndustryId($this->router->fetch_method());
			 			
			//D:/xampp/htdocs/toadsquare/dev/media/cdnsm121/project/filmNvideo/file/15/
	}
/*============================Film and Video Section==================================================*/	
	/**
	 * Index fucntion by default call when Controller initialised
	 *
	 * by default call function for film & Video project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function index() {
		$this->filmNvideo();  
	}
	
	public function getIndustryId($IndustryKey='filmNvideo'){
		$IndustryKey=$this->config->item($IndustryKey)?$this->config->item($IndustryKey):'';
		$where=array('IndustryKey'=>$IndustryKey);
		$Industry=$this->model_common->getDataFromTabel($table='MasterIndustry', $field='IndustryId',  $where, $whereValue='', $orderBy='', $order='', $limit=1 );
		$IndustryId=0;		
		if($Industry){
			$IndustryId=$Industry[0]->IndustryId;	
		}		
		return $IndustryId;
	}
	/**
	 * projectDescription fucntion 
	 *
	 * function call by  film & Video project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function projectDescription($indusrty='filmNvideo',$projectId=0,$action="",$method='',$projectElementId='') {
		$insertFlag=false;
		$this->data['indusrty']=$indusrty;
		$this->data['indusrtyId']=$this->IndustryId;
		$this->data['sectionId']=$sectionId=$this->input->post('sectionId'); 
		if($action=='newProject'){
			$this->lib_package->setUserContainerId($sectionId);
		}else{
			if($projectId > 0){
				$isProject=$this->model_common->countResult('Project',array('projId'=>$projectId,'tdsUid'=>$this->userId),'',1);
				if(!$isProject > 0){
					redirect('media/'.$indusrty);
				}		
			}else{
				redirect('media/'.$indusrty);
			}
		}
		$this->load->language($indusrty);
		
		$elementTblPrefix=$this->config->item($indusrty.'Prifix');
		$elementTable=$elementTblPrefix.'Element';
		$this->data['entityId']=$entityId=getMasterTableRecord($elementTable);
		
		if($indusrty=='news' || $indusrty=='reviews' || $indusrty=='educationMaterial'){
			
			$catRes=getDataFromTabel('ProjCategory', 'catId,category', 'entityId', $this->data['entityId'], '', '', 1 );
			$catId=$catRes[0]->catId;
			@$this->data['LID']->category= $catRes[0]->category;
		}else{
			$catId=0;
		}		
		
		$this->data['method']=$method; 
		$this->data['projectElementId']=$projectElementId; 
		$this->data['label']=$this->lang->language; 
		$this->data['LID']->projCategory=$catId;
		$this->data['action']=$action;
		$this->data['projectId']=$projectId;
		$this->data['projId']=0;
		$this->data['projectDescription']='black';
			
		$config = array(
               array(
                     'field'   => 'projName',
                     'label'   => 'title',
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'projShortDesc',
                     'label'   => 'One Line Description',
                     'rules'   => 'trim|required'
                  ),   
               array(
                     'field'   => 'projTag',
                     'label'   => 'Tag Words',
                     'rules'   => 'trim|required'
                  ),   
               array(
                     'field'   => 'projLanguage',
                     'label'   => 'Original Language',
                     'rules'   => 'trim|required'
                  )
				  ,   
               array(
                     'field'   => 'projReleaseDate',
                     'label'   => 'Release Date',
                     'rules'   => 'trim'
                  ),   
               array(
                     'field'   => 'projCategory',
                     'label'   => 'Project Category',
                     'rules'   => 'trim'
                  )
				  ,   
               array(
                     'field'   => 'projType',
                     'label'   => 'Project Type',
                     'rules'   => 'trim'
                  )
				  ,   
               array(
                     'field'   => 'projGenre',
                     'label'   => 'Genre',
                     'rules'   => 'trim'
                  )
				  ,   
               array(
                     'field'   => 'projGenreFree',
                     'label'   => 'Genre2',
                     'rules'   => 'trim'
                  )
				  ,   
               array(
                     'field'   => 'projSellstatus',
                     'label'   => 'Sales Information',
                     'rules'   => 'trim'
                  )
				  ,   
               array(
                     'field'   => 'producedInCountry',
                     'label'   => 'Produced In Country',
                     'rules'   => 'trim'
                  )
                  ,   
               array(
                     'field'   => 'classification',
                     'label'   => 'Classification',
                     'rules'   => 'trim'
                  )
                  ,   
               array(
                     'field'   => 'classifiedBy',
                     'label'   => 'Classified By',
                     'rules'   => 'trim'
                  )
                  ,   
               array(
                     'field'   => 'projSubtitle1',
                     'label'   => 'Sub Titles',
                     'rules'   => 'trim'
                  )
				  ,   
               array(
                     'field'   => 'projSubtitle1',
                     'label'   => 'Sub Titles',
                     'rules'   => 'trim'
                  )
				  ,   
               array(
                     'field'   => 'projSubtitle2',
                     'label'   => 'Sub Titles',
                     'rules'   => 'trim'
                  ),   
               array(
                     'field'   => 'projDubbing1',
                     'label'   => 'Dubbing',
                     'rules'   => 'trim'
                  )
				  ,   
               array(
                     'field'   => 'projDubbing2',
                     'label'   => 'Dubbing',
                     'rules'   => 'trim'
                  )
				  ,   
               array(
                     'field'   => 'projectid',
                     'label'   => 'projectid',
                     'rules'   => 'trim'
                  )
                  ,   
               array(
                     'field'   => 'projDonations',
                     'label'   => 'project Donations',
                     'rules'   => 'trim'
                  )
            );

		$this->form_validation->set_rules($config); 
		
		if($this->input->post('submit')=='Save' && $this->form_validation->run())
		{
			$projReleaseDate=set_value('projReleaseDate')==''?currntDateTime('Y-m-d'):set_value('projReleaseDate');
			$projReleaseDate=date('Y-m-d',strtotime($projReleaseDate));
			$projectId=set_value('projectid');
			$projType=set_value('projType');
			if(!is_numeric($projType)) $projType=NULL;
			$projGenre=set_value('projGenre');
			if(!is_numeric($projGenre)) $projGenre=NULL;
			$IndusrtyId=($this->input->post('IndustryId') > 0)?$this->input->post('IndustryId'):$this->data['indusrtyId']; 
			$projSellType=($this->input->post('projSellType') > 0)?$this->input->post('projSellType'):0; 
			$sellPriceType=($this->input->post('sellPriceType') > 0)?$this->input->post('sellPriceType'):0; 
			$dataProject = array(
				'IndustryId' => $IndusrtyId,
				'tdsUid' => $this->userId,
				'projName' => pg_escape_string(set_value('projName')),
				'projectType' => $indusrty,
				'projShortDesc' =>   pg_escape_string(set_value('projShortDesc')),
				'projTag' =>    pg_escape_string(set_value('projTag')),
				'projCategory'=> set_value('projCategory'),
				'projType' => $projType,
				'projGenre' => $projGenre,
				'projLanguage' => set_value('projLanguage'),
				'projGenreFree' => pg_escape_string(set_value('projGenreFree')),
				'projSellstatus' => set_value('projSellstatus')=='t'?'t':'f',
				'projDonations' => set_value('projDonations')?set_value('projDonations'):'f',
				'projLastModifyDate' => currntDateTime(),
				'projReleaseDate' => $projReleaseDate,
				'producedInCountry' =>   set_value('producedInCountry')>=0?set_value('producedInCountry'):0,
				'classification' =>   pg_escape_string(set_value('classification')),
				'classifiedBy' =>   pg_escape_string(set_value('classifiedBy')),
				'projSubtitle1' =>   set_value('projSubtitle1')>0?set_value('projSubtitle1'):0,
				'projSubtitle2' =>   set_value('projSubtitle2')>0?set_value('projSubtitle2'):0,
				'projDubbing1' => set_value('projDubbing1')>0?set_value('projDubbing1'):0,
				'projDubbing2'=> set_value('projDubbing2')>0?set_value('projDubbing2'):0,
				'projSellType'=> $projSellType,
				'sellPriceType'=> $sellPriceType
			);
			
			if($projectId > 0){
				//echo $projectId; die;
				$this->model_common->editDataFromTabel('Project', $dataProject, 'projId', $projectId);
				$msg = $this->lang->line('updatedProject');
			}else{
				
				$dataProject['projCreateDate'] = currntDateTime(); 
				$userContainerId=$this->lib_package->getUserContainerId($sectionId);
				if($userContainerId){
					$insertFlag=true;
					$dataProject['userContainerId']=$userContainerId;
				}
				if($insertFlag){
					$projectId=$this->model_common->addDataIntoTabel('Project', $dataProject);
					$entityId=getMasterTableRecord('Project');
					$this->lib_package->updateUserContainer($userContainerId,$entityId,$projectId,$sectionId,$sectionId);
					$msg=$this->lang->line('addedProject');
				}
			}
			addDataIntoLogSummary('Project',$projectId);
			set_global_messages($msg, $type='success', $is_multiple=true);
			if($projectId>0){
				$this->writeCacheFile($indusrty,$projectId,$offSet=0,$perPage=15);
			}
			if($insertFlag){
				redirect('media/'.$indusrty.'/editProject/uploadMedia/'.$projectId);
			}
		}
		if($projectId > 0){
			$res=$this->mediaLastInsertDtaData($projectId,$elementTblPrefix);
			if($res){
				$this->data['projectId']=$res[0]->projectid;
				$this->data['LID']=$res[0];
			}
		}
		$this->data['userId']=$this->userId;
		$this->data['header']=$this->load->view('newProjectHeader',$this->data, true);

		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/'.$indusrty),
						'indexlink'=>base_url(lang().'/media/'.$indusrty),
						'section'=>$this->lang->line($indusrty),
						'indusrty'=>$indusrty,
						'isDashButton'=>true
						);
		if($indusrty=='reviews' || $indusrty=='news') {
			$leftData['isnewsReview']=1;
		}
		if($indusrty=='writingNpublishing'){
			$leftData['isWriting']=1;
		}	
		$leftView=$this->config->item($indusrty.'HelpPage');
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','newProject',$this->data);	
	}
	
	public function mediaLastInsertDtaData($projectId=0,$elementTblPrefix='Fv') {
		if(!$projectId > 0){
			$res=$this->model_common->getDataFromTabel('Project','projId',  'tdsUid', $this->userId, 'projId', 'DESC',1 );
			if($res){
				$projectId = $res[0]->projId;
			}else{
				return false;
			}
		}
		$res=$this->model_media->mediaLastInsertDtaData($projectId,$this->userId,$elementTblPrefix);
		return $res;
	}
	
	/**
	 * uploadMedia fucntion 
	 *
	 * function call by  film & Video project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	 

	public function uploadMedia($indusrty='filmNvideo',$projectId=0,$action="",$method='',$projectElementId='') {
		
		if(!$projectId > 0){
			redirect('media/'.$indusrty.'/newProject/projectDescription');
		}
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		
		$filePath=$this->dirUploadMedia.$indusrty.'/'.$projectId.'/file/';
		
		$this->data['userId']=$this->userId;
		$this->data['entityId']=$entityId=getMasterTableRecord('Project');
		
		$this->data['filePath']=$filePath;	
		$this->data['fileConfig']=$this->config->item($indusrty.'FileConfig');
				
				
		$this->data['method']=$method; 
		$action="editProject";
		$this->load->language($indusrty);
		
		$elementTblPrefix=$this->config->item($indusrty.'Prifix');
		$this->data['elementTblPrefix']=$elementTblPrefix;
		$this->data['elemetTable']=$elementTblPrefix.'Element';
		$this->data['elemetEntityId']=getMasterTableRecord($this->data['elemetTable']);
		$this->data['elementFieldId']='elementId';
		$this->data['projectElementId']=$projectElementId;
		$this->data['LID']=false;
		$this->data['action']=$action;
		$this->data['projId']=0;
		$this->data['projectId']=$projectId;
		$this->data['uploadMedia']='black';
		$this->data['indusrty']=$indusrty;
		$this->data['label']=$this->lang->language; 
		$this->data['indusrtyId']=$this->IndustryId;
		//$this->data['header']=$this->load->view('newProjectHeader',$this->data, true);
		$res=$this->mediaLastInsertDtaData($projectId,$elementTblPrefix);
		if(!$res){
			redirect('media/'.$indusrty);
		}
		else{
			
			if(!is_dir($filePath)){
				if (!mkdir($filePath,0777, true)) {
					die('Failed to create folders...');
				}
			}
			$cmd = 'chmod -R 777 '.$filePath;
			exec($cmd);
			
			
			$this->data['projId']=$res[0]->projectid;
			$this->data['LID']=$res[0];
			
			if($indusrty=='news' || $indusrty=='reviews'){
						$orderby='elementId';
						$order='DESC';
			}else{
				$orderby='order';
				$order='ASC';
			}
			
			if(isset($this->data['LID']->projSellstatus) && $this->data['LID']->projSellstatus=='t') {
				$this->data['topBtnClass'] = 'mt12';
			}
			$this->data['header']=$this->load->view('newProjectHeader',$this->data, true);
			
			
			// GET COUNT FOR PAGINATION
		    $this->data['countResult']=$this->model_common->countResult($this->data['elemetTable'],array('projId'=>$projectId));				
		   
			$pages = new Pagination_ajax;
			$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
			$this->data['perPageRecord'] =$this->config->item('perPageRecordMediaUpload');
			$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
			$pages->paginate();
			$this->data['items_total'] = $pages->items_total;
			$this->data['items_per_page'] = $pages->items_per_page;
			$this->data['pagination_links'] = $pages->display_pages();
		
			$this->data['elements']=$this->model_media->getProjectElements($projectId,$elementTblPrefix,0,$orderby,$order,$pages->offst,$pages->limit);
			
			/* AJAX REQUEST FOR PAGINATION*/
			$ajaxRequest = $this->input->post('ajaxRequest');
			if($ajaxRequest)
			{   
				$this->load->view('newsReviewList',$this->data) ;				
			}else{
				if($projectElementId > 0){
					$this->data['projectElement']=$this->model_media->getProjectElements($projectId,$elementTblPrefix,$projectElementId);
				}else{
					$this->data['projectElement']=false;
				}
				if($indusrty=='news' || $indusrty=='reviews'){
					$loadView='uploadNewsReviews';
					$this->data['EelementType']=false;
				}else{
					$this->data['EelementType']=getDataFromTabel('MediaEelementType','*', 'catId', $this->data['LID']->projCategory, 'order', 'ASC');
					$loadView='uploadMeda';
				}

				
				$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/'.$indusrty),
						'indexlink'=>base_url(lang().'/media/'.$indusrty),
						'section'=>$this->lang->line($indusrty),
						'indusrty'=>$indusrty,
						'isDashButton'=>true
						);
				if($indusrty=='reviews' || $indusrty=='news') {
					$leftData['isnewsReview']=1;
				}
				if($indusrty=='writingNpublishing'){
					$leftData['isWriting']=1;
				}		
				$leftView=$this->config->item($indusrty.'HelpPage');
				$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
				
				$this->template->load('backend_template',$loadView,$this->data);
				      
				//$this->template->load('template',$loadView,$this->data);
			}						
		}							
	}
	   
	
	public function updateProjectPrice() {
		$dataProject = $this->input->post('val1');
		$projId = $this->input->post('val2');
		$deleteCache = $this->input->post('val3');
		if($projId>0 && is_array($dataProject) && count($dataProject) > 0){
			$countResult = $this->model_common->countResult('Project','projId',$projId,1);
			if($countResult > 0){
				$this->model_common->editDataFromTabel('Project', $dataProject, 'projId', $projId);
			}
			$this->session->set_userdata($deleteCache,1);
		}
	}
	
	public function furtherDescription($indusrty='filmNvideo',$projectId=0,$action="",$method='',$projectElementId='') {
		
		if(!$projectId > 0){
			redirect('media/'.$indusrty);
		}
		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		
		$this->data['method']=$method;
		$this->data['projectElementId']=$projectElementId;
		$this->data['fileConfig']=$this->config->item($indusrty.'FileConfig');
		$action="editProject";
		$elementTblPrefix=$this->config->item($indusrty.'Prifix');
		
		$this->data['elementTbl']=$elementTblPrefix.'Element';
		$this->data['entityId']=$entityId=getMasterTableRecord($this->data['elementTbl']);
		$this->data['elementFieldId']='elementId';
		$fileUploadPath=$this->dirUploadMedia.$indusrty.'/'.$projectId.'/images/';
		$this->data['fileUploadPath']=$fileUploadPath;	
		$this->load->language($indusrty);
		$this->data['indusrtyId']=$this->IndustryId;
		$this->data['action']=$action;
		$this->data['projectId']=$projectId;
		$this->data['furtherDescription']='black';
		$this->data['indusrty']=$indusrty;
		$this->data['label']=$this->lang->language; 
		
		$res=$this->mediaLastInsertDtaData($projectId,$elementTblPrefix);
		if(!$res){
				redirect('media/'.$indusrty);
		}
		else{
			$this->data['projId']=$res[0]->projectid;
			$this->data['LID']=$res[0];
			if($indusrty=='news' || $indusrty=='reviews'){
						$orderby='elementId';
						$order='DESC';
			}else{
				$orderby='order';
				$order='ASC';
			}
			// GET COUNT FOR PAGINATION
			$this->data['countResult']=$this->model_common->countResult($this->data['elementTbl'],array('projId'=>$projectId));
			
			
			$pages = new Pagination_ajax;
			$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
			$this->data['perPageRecord'] =$this->config->item('perPageRecordMediaUpload');
			$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
			$pages->paginate();
			$this->data['items_total'] = $pages->items_total;
			$this->data['items_per_page'] = $pages->items_per_page;
			$this->data['pagination_links'] = $pages->display_pages();
			$this->data['elements']=$this->model_media->getProjectElements($projectId,$elementTblPrefix,0,$orderby,$order,$pages->offst,$pages->limit);
			$this->data['userId'] = $this->userId;
			
			
			$ajaxRequest = $this->input->post('ajaxRequest');
			if($ajaxRequest){   
				$this->load->view('furtherDescriptionNewsList',$this->data) ;
			}else{
				
				$this->data['header'] = $this->load->view('newProjectHeader',$this->data, true);
				
				if($projectElementId > 0){
					$this->data['projectElement'] = $this->model_media->getProjectElements($projectId,$elementTblPrefix,$projectElementId);
				}else{
					$this->data['projectElement'] = false;
				}
			
				if($indusrty=='news' || $indusrty=='reviews'){
					$this->data['EelementType']=false;
					$loadView='furtherDescriptionNewsReviews';
				}else{
					$this->data['EelementType']=getDataFromTabel('MediaEelementType','*', 'catId', $this->data['LID']->projCategory, 'order', 'ASC');
					$loadView='furtherDescription';
				}
				
				$whereSuportLinks=array('entityid_to'=>$entityId,'elementid_to'=>$projectId);
				$this->data['suportLinks']=$this->model_media->suportLinks($whereSuportLinks);

				
				$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/'.$indusrty),
						'indexlink'=>base_url(lang().'/media/'.$indusrty),
						'section'=>$this->lang->line($indusrty),
						'indusrty'=>$indusrty,
						'isDashButton'=>true
						);
				if($indusrty=='reviews' || $indusrty=='news') {
					$leftData['isnewsReview']=1;
				}
				if($indusrty=='writingNpublishing'){
					$leftData['isWriting']=1;
				}	
				$leftView=$this->config->item($indusrty.'HelpPage');
				$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
				
				$this->template->load('backend_template',$loadView,$this->data);
				
				//$this->template->load('template',$loadView,$this->data);
			}
			
		}
		
			
		
			
		
			
	}
	
	public function additionalInformation($indusrty='filmNvideo',$projectId=0,$action="",$method="",$projectElementId='') {
		
		if(!$projectId > 0){
			redirect('media/'.$indusrty);
		}
		$this->data['method']=$method;
		$this->data['projectElementId']=$projectElementId;
		$action="editProject";
		$this->data['action']=$action;
		$this->data['projectId']=$projectId;
		$this->data['additionalInformation']='black';
		$this->data['indusrty']=$indusrty;
		$this->load->language($indusrty);
		$this->data['label']=$this->lang->language; 
		$this->data['header'] = $this->load->view('newProjectHeader',$this->data, true);
		$this->data['additionalInfoSection']=array('addInfoNewsPanel','addInfoReviewsPanel','addInfoInterviewsPanel'); 
		$natureId = 1;
		$this->data['recordId'] = $projectId;
		$this->data['eventNatureId'] = $natureId;
		$this->data['tableId'] = getMasterTableRecord('Project');
		$this->data['userId']=$this->userId;
		

		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/'.$indusrty),
						'indexlink'=>base_url(lang().'/media/'.$indusrty),
						'section'=>$this->lang->line($indusrty),
						'indusrty'=>$indusrty,
						'isDashButton'=>true,
						'isMedia'=>1
						);
		$leftView=$this->config->item($indusrty.'HelpPage');
		$this->data['leftContent']=$this->load->view('dashboard/help_pr_material',$leftData,true);
		
		$this->template->load('backend_template','additionalInfo/additional_info',$this->data);
		
		//$this->template->load('template','additionalInfo/additional_info',$this->data);
		
	}
	
	
	
	public function getProject($action='',$method='', $projectId=0,$industryType='filmNvideo',$isArchive='f',$elementId=0) {
		$projectId=$projectId>0?$projectId:($action>0?$action:0);
		if($action=='deletedItems'){
				$isArchive='t';
				$action='';
				$projectId=(is_numeric($method))?$method:0;
				$method='';
		}
		
		$ajaxRequest = $this->input->post('ajaxRequest');
		$pagingRequest = $this->input->post('pagingRequest');
		
		$this->data['entityId']=getMasterTableRecord('Project');
		$this->data['showCaseMethod']=$this->config->item($industryType.'Sl');
		$this->data['sectionId']=$this->config->item($industryType.'SectionId');
		$this->data['addNewProjectLink']='/media/'.$industryType.'/newProject/projectDescription';
		$this->data['industryType']=$industryType;
		$this->data['indusrtyId']=$this->IndustryId;
		
		$elementTblPrefix=$this->config->item($industryType.'Prifix');
		$this->data['elemetTable']=$elementTblPrefix.'Element';
		$this->data['elementEntityId']=$elementEntityId=getMasterTableRecord($this->data['elemetTable']);
		
		if(!empty($action) && !empty($method)){
			$this->$method($industryType,$projectId,$action,$method,$elementId);
		}
		else{			
			$this->load->language($industryType); // load language file for Film and Video
			$userId=$this->userId;
			$this->data['userId']=$userId;
			if(!$projectId > 0){
				$where=array('projectType'=>$industryType,'isArchive'=>$isArchive,'tdsUid'=>$userId);
				
				$res=$this->model_common->getDataFromTabel($table='Project', $field='projId', $where, '', 'projLastModifyDate', 'DESC', $limit=1 );
				if($res){
					$projectId=$res[0]->projId;
				}
			}
			
			$cacheFile=$this->dirCacheMedia.$industryType.'_'.$projectId.'_User_'.$userId.'.php';
			$refereshCashe=LoginUserDetails($industryType.'_'.$projectId.'_'.$this->userId);
			$refereshCashe1=LoginUserDetails($industryType.'_'.$this->userId);
			if($refereshCashe==1){				
				if(is_file($cacheFile)){
					@unlink($cacheFile);
				}
				$this->session->unset_userdata($industryType.'_'.$projectId.'_'.$this->userId);
			}elseif($refereshCashe1==1){				
				if(is_file($cacheFile)){
					@unlink($cacheFile);
				}
				$this->session->unset_userdata($industryType.'_'.$this->userId);
			}
			
			if((!is_file($cacheFile)|| is_file($cacheFile)) && $pagingRequest != 1){
				$this->writeCacheFile($industryType,$projectId,$isArchive);
			}
			if(is_file($cacheFile)){
				require_once ($cacheFile);
				$this->data = json_decode($ProjectData, true);
			}
			
			if($industryType=='news' || $industryType=='reviews'){
					$orderby='createdDate';
					$order='DESC';
			}else {
				$orderby='order';
				$order='ASC';
			}
			$countResult=$this->model_common->countResult($this->data['elemetTable'],array('projId'=>$projectId));
			$this->data['isArchive']=$isArchive;
			$this->data['countResult']=$countResult;
			$pages = new Pagination_ajax;
			$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
			$this->data['perPageRecord'] =$this->config->item('perPageRecordMedia');
			//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
			
			// Add by Amit to set cookie for Results per page
			if($this->input->post('ipp')!=''){
				$isCookie = setPerPageCookie($industryType.'PerPageVal',$this->data['perPageRecord']);	
			}else {
				$isCookie = getPerPageCookie($industryType.'PerPageVal',$this->data['perPageRecord']);		
			}
						
			$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
			
			$pages->paginate();
			$this->data['projectElements']=$this->model_media->getProjectElements($projectId,$elementTblPrefix,0,$orderby,$order,$pages->offst,$pages->limit,true);
			
			$this->data['items_total'] = $pages->items_total;
			$this->data['items_per_page'] = $pages->items_per_page;
			$this->data['pagination_links'] = $pages->display_pages();
			
			$this->data['userId'] = $userId;
			$this->data['projectId'] = $projectId;
			$this->data['constant'] = $this->lang->language ;	
			$this->data['fileConfig'] = $this->config->item($industryType.'FileConfig');
			
			//decode data in arry format from json
			/* AJAX REQUEST FOR PAGINATION*/
          
			if($ajaxRequest){
				 $this->load->view('elements',$this->data) ;
			}			   
			else{

				$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/'.$industryType),
						'indexlink'=>base_url(lang().'/media/'.$industryType),
						'section'=>$this->lang->line($industryType),
						'indusrty'=>$industryType,
						'isDashButton'=>true
						);
				if($industryType=='reviews' || $industryType=='news') {
					$leftData['isnewsReview']=1;
				}
				if($industryType=='writingNpublishing'){
					$leftData['isWriting']=1;
				}	
				$leftView=$this->config->item($industryType.'HelpPage');
				$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
				
				$this->template->load('backend_template','media',$this->data);
				
				//$this->template->load('template','media',$this->data);		   //load template with media view
			}
		}		
	}
	
	function writeCacheFile($industryType='',$projectId=0,$isArchive='f'){
	
		$userId=$this->userId;
		$cacheFile=$this->dirCacheMedia.$industryType.'_'.$projectId.'_User_'.$userId.'.php';
		if(!is_dir($this->dirCacheMedia)){
			@mkdir($this->dirCacheMedia, 777, true);
		}
		$cmd3 = 'chmod -R 777 '.$this->dirCacheMedia;
		exec($cmd3);
		$elementTblPrefix=$this->config->item($industryType.'Prifix');
		if($industryType=='news' || $industryType=='reviews'){
				$orderby='createdDate';
				$order='DESC';
		}else {
			$orderby='order';
			$order='ASC';
		}
		$this->data['projects'] = $this->model_media->getProject($userId,$industryType,$projectId,$elementTblPrefix,$orderby,$order,$limit=1,$cacheFile,$isArchive);
		if(!$this->data['projects'] && $isArchive=='f'){
				$projectTotalCount=$this->model_common->countResult('Project',array('tdsUid'=>$userId,'projectType'=>$industryType,'isArchive'=>'f'));
				//echo "projectTotalCount==>".$projectTotalCount;die;
				if($projectTotalCount>0){
					
						redirect('media/'.$industryType);
				}
		}
		$data=str_replace("'","&apos;",json_encode($this->data));	//encode data in json format
		$stringData = '<?php $ProjectData=\''.$data.'\';?>';
		if (!write_file($cacheFile, $stringData)){	// write cache file
			echo 'Unable to write the file'; die;
		}
		
		
	}
	
	/**
	 * filmNvideo fucntion 
	 *
	 * function call by  film & Video project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	function deletedItems($industryType='filmNvideo',$projectId=0){		  
		$this->getProject('', '', $projectId,$industryType,'t',0);
    }
	
	public function filmNvideo($action='',$method='', $projectId=0, $elementId='') {
		$this->getProject($action, $method, $projectId,'filmNvideo','f',$elementId);
	}
	
    /*============================Music and Audio Section==================================================*/
	/**
	 * musicNaudio fucntion 
	 *
	 * function call by  Music & Audio project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	public function musicNaudio($action='',$method='', $projectId=0, $elementId='') {

		$this->getProject($action,$method, $projectId,'musicNaudio','f', $elementId);
	}
	
	/*============================Writing and publishing Section==================================================*/
	/**
	 * writingNpublishing fucntion 
	 *
	 * function call by  Writing & Publishing project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	public function writingNpublishing($action='',$method='', $projectId=0, $elementId=0) {
		$this->getProject($action,$method, $projectId,'writingNpublishing','f',$elementId);
	}
	
	public function news($action='',$method='', $projectId=0, $elementId=0) {
		$this->getProject($action,$method, $projectId,'news','f',$elementId);
	}
	
	public function reviews($action='',$method='', $projectId=0, $elementId=0) {		
		$this->getProject($action,$method, $projectId,'reviews','f',$elementId);
	}
	
	/*============================Photography and Art Section==================================================*/
	/**
	 * photographyNArt fucntion 
	 *
	 * function call by  Photography & Art project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function photographyNArt($action='',$method='', $projectId=0,$elementId=0) {
		$this->getProject($action,$method, $projectId,'photographyNart','f',$elementId);
	}
	
	/*============================Education Material Section==================================================*/
	/**
	 * photographyNArt fucntion 
	 *
	 * function call by  Education & Material project type 
	 *
	 * @access	public
	 * @param	
	 * @return	this function load view media for project Education Material 
	 *
	 */
	public function educationMaterial($action='',$method='', $projectId=0,$elementId=0) {
		$this->getProject($action,$method, $projectId,'educationMaterial','f',$elementId);
	}
	
	

    /**
	 * Function to Add review
	 *
	 * Amit Wali
	 *
	 * @access	public
	 * @param	integer
	 * @return	
	 */	
	
	
	public function updateReview (){
		
	  $loggedUserId=isloginUser(); 
	  $title = $this->input->post('articleTitle');
	  $editElementId = $this->input->post('editElementId');
	  $editProjectId = $this->input->post('editProjectId');
	  
	  $isEdit = $this->input->post('isEdit');		      
	  
	  if(isset($title) && ($title==''))
		{	redirect(base_url()); }  
	  
		$wordCnt = $this->input->post('wordCount');
		$wordCount=(!empty($wordCnt))? $wordCnt : '0' ;
								  
	  // Check Review		      		    
	  $proId=$this->model_media->getReviewId($loggedUserId);
	  $this->session->set_userdata('reviews_'.$this->userId,1);
	  
	if($proId!=''){  
		
	  $curDate  =  date('Y-m-d h:i:s');
	  $data=array(		
		'projId'            =>$proId,							
		'title'             =>$this->input->post('articleTitle'),
		'articleSubject'    =>$this->input->post('articleSubject'),
		'article'           =>$this->input->post('article'),
		'entityId'          =>$this->input->post('entityId'),
		'projectElementId'  =>$this->input->post('elementId'),
		'industryId'        =>$this->input->post('industryId'),	
		'languageId'        =>$this->input->post('languageId'),
		'wordCount'         =>$wordCount,
		'createdDate'       =>$curDate,
		'projectId'         =>$this->input->post('projectid'),
		'userId'            =>$this->userId,
		'isPublished'       =>'f'		
		);
		
			if($isEdit==''){					
				$elemId  = $this->model_media->addReview($data);						
				if($elemId)				
				$this->model_media->checkLogSummary($elemId,$proId);
			}	
		 // if(isset($isEdit) && !empty($isEdit))
		} 			    
	  }
	  
			  
	function suportLinksAdd(){		  
		 $suportLinks=$this->input->post('val1');
		 if($suportLinks && is_array($suportLinks) && count($suportLinks)>0){
			 foreach($suportLinks as $links){
				if($links && is_array($links) && count($links)>0){
					$insertData[]=$links;
					$entityid_to=$links['entityid_to'];
					$elementid_to=$links['elementid_to'];
				}
			  }
			  $whereDel=array('entityid_to'=>$entityid_to,'elementid_to'=>$elementid_to);
			  $this->model_common->deleteRowFromTabel($table='SupportLink', $whereDel);
			  $this->model_common->insertBatch('SupportLink',$insertData);
		 }
    }
	  
	/*Function to load after save popup */	
	public function uploadMediaPopup()
	{
		$data['industryType'] = $this->input->get('val1');
		$data['projectId'] = $this->input->get('val2');
		$this->load->view('afterSavePopup',$data) ;
	}    
	
    
    public function moveMediaProjectInTrash() {
		$projectId = $this->input->post('val1');
		$elementTable = trim($this->input->post('val2'));
		$sectionId = trim($this->input->post('val3'));
		$section = trim($this->input->post('val4'));
		$userId=$this->userId;
		$username=LoginUserDetails('username');
		if(strlen($elementTable) > 2 && is_numeric($projectId) && $projectId > 0){
			if ($this->db->table_exists($elementTable) ){ // table exists
				
				$whereCondition=array('projId'=>$projectId,'tdsUid'=>$userId);
				$countProject=$this->model_common->countResult('Project',$whereCondition,'',1);
				
				if (is_numeric($countProject) && $countProject >  0 ){
				
					$entityId=getMasterTableRecord('Project');
					$elementEntityId=getMasterTableRecord($elementTable);
					
					$projectData=$this->model_common->getDataFromTabel('Project', '*', $whereCondition, '', '', '', 1, 0, true);
					$projectData=$projectData[0];
					$projectData=str_replace("'","&apos;",json_encode($projectData));
					
					$elements=$this->model_media->getPojectElementsNmedia($projectId,$elementTable);
					if($elements && is_array($elements) && count($elements) > 0 ){
						$elementData=str_replace("'","&apos;",json_encode($elements));
					}else{
						$elementData='';
					}
					
					$trashData=array(
						'entityId'=>$entityId,
						'elementId'=>$projectId,
						'projectId'=>$projectId,
						'userId'=>$userId,
						'trashfolder'=>$username,
						'sectionId'=>$sectionId,
						'projectData'=>$projectData,
						'elementData'=>$elementData
					);
					$trashId=$this->model_common->addDataIntoTabel('Trash',$trashData);
					if($trashId > 0){
						$sectionIdString=str_replace(':','_',$sectionId);
						$indusrty=$this->config->item('industryForSectionId'.$sectionIdString);
						$dirMedia=$this->dirUploadMedia.$indusrty.'/'.$projectId;
						$dirTrash=$this->dirTrash.$indusrty.'/'.$projectId;
						
						copyFolder($dirMedia,$dirTrash);
						removeDir($dirMedia);
						
						$cacheFile=$this->dirCacheMedia.$indusrty.'_'.$projectId.'_User_'.$userId.'.php';
						@unlink($cacheFile);
						
						if($elements && is_array($elements) && count($elements) > 0 ){
							foreach($elements as $element){
								$fileId =  $element['fileId'];
								if(is_numeric($fileId) && ($fileId > 0)){
									$this->model_common->deleteRowFromTabel('MediaFile',array('fileId'=>$fileId));
								}
							}
						}
						$this->model_common->deleteRowFromTabel('search', array('entityid'=>$entityId,'projectid'=>$projectId));
						$this->model_common->deleteRowFromTabel('search', array('entityid'=>$elementEntityId,'projectid'=>$projectId));
						$this->model_common->deleteRowFromTabel($elementTable, array('projId'=>$projectId));
						$this->model_common->deleteRowFromTabel('Project', array('projId'=>$projectId));
					}
				}
			}
		}
	}
	
	public function moveMediaElementInTrash() {
		$projectId = $this->input->post('val1');
		$elementTable = trim($this->input->post('val2'));
		$elementId = trim($this->input->post('val3'));
		$sectionId = trim($this->input->post('val4'));
		$userId=$this->userId;
		$username=LoginUserDetails('username');
		if(strlen($elementTable) > 2 && is_numeric($projectId) && $projectId > 0 && $elementId > 0){
			if ($this->db->table_exists($elementTable) ){ // table exists
				
				$whereCondition=array('projId'=>$projectId,'tdsUid'=>$userId);
				$countProject=$this->model_common->countResult('Project',$whereCondition,'',1);
				
				if (is_numeric($countProject) && $countProject >  0 ){
					$entityId=getMasterTableRecord('Project');
					$elementEntityId=getMasterTableRecord($elementTable);
					
					$elements=$this->model_media->getPojectElementsNmedia($projectId,$elementTable,$elementId);
					if($elements && is_array($elements) && count($elements) > 0 ){
						$elementData=str_replace("'","&apos;",json_encode($elements));
						
						$trashData=array(
							'entityId'=>$elementEntityId,
							'elementId'=>$elementId,
							'projectId'=>$projectId,
							'sectionId'=>$sectionId,
							'userId'=>$userId,
							'trashfolder'=>$username,
							'elementData'=>$elementData
						);
						$trashId=$this->model_common->addDataIntoTabel('Trash',$trashData);
						if($trashId > 0){
							$sectionIdString=str_replace(':','_',$sectionId);
							$indusrty=$this->config->item('industryForSectionId'.$sectionIdString);
							$dirMedia=$this->dirUploadMedia.$indusrty.'/'.$projectId;
							$dirTrash=$this->dirTrash.$indusrty.'/'.$projectId;
							$deleteCache=$indusrty.'_'.$projectId.'_'.$userId;
							$sectionCache =$deleteCache;
							$this->session->set_userdata($sectionCache,1);
							
							foreach($elements as $element){
								$imagePath = trim($element['imagePath']);
								if(is_file($imagePath)){
									$path_parts = pathinfo($imagePath);
									$imageDir=$path_parts['dirname'];
									$fpLen=strlen($imageDir);
									if($fpLen > 0 && substr($imageDir,-1) != DIRECTORY_SEPARATOR){
										$imageDir=$imageDir.DIRECTORY_SEPARATOR;
									}
									$imageName=$path_parts['basename'];
									findFileNnovieInTrash($imageDir, $imageName);
									@unlink($imageDir.$imageName);
								}
								$fileId =  $element['fileId'];
								if(is_numeric($fileId) && ($fileId > 0)){
									$filePath=trim($element['filePath']);
									$fileName=trim($element['fileName']);
									if(is_dir($filePath) && $fileName !=''){
										$fpLen=strlen($filePath);
										if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
											$filePath=$filePath.DIRECTORY_SEPARATOR;
										}
										if(is_file($filePath.$fileName)){
											findFileNnovieInTrash($filePath,$fileName);
											@unlink($filePath.$fileName);
										}
									}
									$this->model_common->deleteRowFromTabel('MediaFile',array('fileId'=>$fileId));
								}
							}
							$this->model_common->deleteRowFromTabel('search', array('entityid'=>$elementEntityId,'elementid'=>$elementId));
							$this->model_common->deleteRowFromTabel($elementTable, array('elementId'=>$elementId));
						}
					}
				}
			}
		}
	}
	
 function afterSaveReview() {					
	 
		$projId = $this->input->get('val1');
		$elemId = $this->input->get('val2');	
				
		$data['projId'] = $projId;
		$data['elemId'] = $elemId;	
				
		$this->load->view('review_after_save',$data);	 
	 		
	     }	
	

}

/* End of file media.php */
/* Location: ./application/module/media/media.php */
