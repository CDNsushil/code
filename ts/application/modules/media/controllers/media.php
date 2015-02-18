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
    private $dirUser = '';
    private $userId = null;
    private $IndustryId = 0;
    private $visitorsIP = null;
    private $redirectUrl = '';
    private $entityId = 0;
    /**
     * Constructor
     */
    function __construct() {
        //Load required Model, Library, language and Helper files
            $load = array(
                'model'		=> 'media/model_media + dashboard/model_dashboard + membershipcart/model_membershipcart',  	
                'language' 	=> 'media',							
                'config'	=>	'media/media',
                'library' => 'pagination_new_ajax'
            ); 
            parent::__construct($load);		
            
            $this->userId= $this->isLoginUser();
            // Load  path of css and cache file path
            $this->dirCacheMedia = 'cache/media/';  
            $this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/project/'; 
            $this->dirUser = 'media/'.LoginUserDetails('username').'/'; 
            $this->dirTrash = 'trash/'.LoginUserDetails('username').'/project/'; 
            $this->data['dirUploadMedia'] = $this->dirUploadMedia; 
            $this->IndustryId=$this->getIndustryId($this->router->fetch_method());
            $this->visitorsIP = str_replace('.','_',$_SERVER["REMOTE_ADDR"]);
            // set default redirect url
            $this->redirectUrl = $this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR;
            $this->entityId = getMasterTableRecord('Project');
                        
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
                    $entityId=$this->entityId;
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
        $this->data['entityId']=$entityId=$this->entityId;
        
        $this->data['filePath']=$filePath;	
        $this->data['fileConfig']=$this->config->item($indusrty.'FileConfig');
                
                
        $this->data['method']=$method; 
        $action="editProject";
        $this->load->language($indusrty);
        
        $elementTblPrefix=$this->config->item($indusrty.'Prifix');
        $this->data['elementTblPrefix']=$elementTblPrefix;
        $this->datphotographyarta['elemetTable']=$elementTblPrefix.'Element';
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
        $this->data['tableId'] = $this->entityId;
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
        
        $this->data['entityId']=$this->entityId;
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
    
    public function filmvideo() {
        $arg_list = func_get_args();
        $sectionId=$this->config->item('filmnvideoSectionId');
        $arg_list['sectionId'] = $sectionId;
        $arg_list['indusrty'] = 'filmNvideo';
        if(isset($arg_list[0])){
            // load industry typr lang file
            $this->load->language($arg_list['indusrty']);
            if (method_exists($this,$arg_list[0])) {
                $this->$arg_list[0]($arg_list);
                // check add space request
                $this->_isaddspacerequest($arg_list[0]);
            } else {
               redirectToNorecord404();
            }
        }else{
            $this->setupshowcase($arg_list);
        }
    }
    public function musicaudio() {
        $arg_list = func_get_args();
        $sectionId=$this->config->item('musicnaudioSectionId');
        $arg_list['sectionId'] = $sectionId;
        $arg_list['indusrty'] = 'musicNaudio';
        // get music n audio cat id
        $musicCatId = $this->config->item('MaAlbumCatId');
        $audioCatId = $this->config->item('MaCollectionCatId');
        if(isset($arg_list[0]) && $arg_list[0] != $musicCatId && $arg_list[0] != $audioCatId) {
            // load industry typr lang file
            $this->load->language($arg_list['indusrty']);
            if (method_exists($this,$arg_list[0])) {
                $this->$arg_list[0]($arg_list);
                // check add space request
                $this->_isaddspacerequest($arg_list[0]);
            } else {
               redirectToNorecord404();
            }
        }else{
            $this->setupshowcase($arg_list);
        }
    }
    public function writingpublishing() {
        $arg_list = func_get_args();
        $sectionId=$this->config->item('writingnpublishingSectionId');
        $arg_list['sectionId'] = $sectionId;
        $arg_list['indusrty'] = 'writingNpublishing';
        if(isset($arg_list[0])){
            // load industry typr lang file
            $this->load->language($arg_list['indusrty']);
            if (method_exists($this,$arg_list[0])) {
                $this->$arg_list[0]($arg_list);
                // check add space request
                $this->_isaddspacerequest($arg_list[0]);
            } else {
               redirectToNorecord404();
            }
        }else{
            $this->setupshowcase($arg_list);
        }
    }
    public function photographyart() {
        $arg_list = func_get_args();
        $sectionId=$this->config->item('photographynartSectionId');
        $arg_list['sectionId'] = $sectionId;
        $arg_list['indusrty'] = 'photographyNart';
        // get photo n art cat id
        $photoCatId = $this->config->item('PaAlbumCatId');
        $artCatId = $this->config->item('PaCollectionCatId');
        if(isset($arg_list[0]) && $arg_list[0] != $photoCatId && $arg_list[0] != $artCatId) {
            // load industry typr lang file
            $this->load->language($arg_list['indusrty']);
            if (method_exists($this,$arg_list[0])) {
                $this->$arg_list[0]($arg_list);
                // check add space request
                $this->_isaddspacerequest($arg_list[0]);
            } else {
               redirectToNorecord404();
            }
        }else{
            $this->setupshowcase($arg_list);
        }
    }
    public function educationmaterials() {
        $arg_list = func_get_args();
        $sectionId=$this->config->item('educationmaterialSectionId');
        $arg_list['sectionId'] = $sectionId;
        $arg_list['indusrty'] = 'educationMaterial';
        if(isset($arg_list[0])){
            // load industry typr lang file
            $this->load->language($arg_list['indusrty']);
            if (method_exists($this,$arg_list[0])) {
                $this->$arg_list[0]($arg_list);
                // check add space request
                $this->_isaddspacerequest($arg_list[0]);
            } else {
               redirectToNorecord404();
            }
        }else{
            $this->setupshowcase($arg_list);
        }
    }
    
    public function setupshowcase($arg_list) {
        // unset media cart id
        $this->session->unset_userdata('mediaCartId');
        // unset media container id
        $this->session->unset_userdata('mediaContainerId');
        $indusrty = $arg_list['indusrty'];
        if(!empty($indusrty)){
            $fileData = $this->getDataFromFile();
            if(!empty($fileData) && is_array($fileData)){
                $this->data = array_merge($fileData,$this->data);
            }
            $this->load->language($indusrty);
            $this->data['sectionId']=$arg_list['sectionId'];
            $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase') ;
            
            $elementTblPrefix=$this->config->item($indusrty.'Prifix');
            $this->data['elementTable']=$elementTblPrefix.'Element';
            $this->data['entityId']=$this->entityId;
            $this->data['elementEntityId']=getMasterTableRecord($this->data['elementTable']);
            $this->data['category']=getDataFromTabel('ProjCategory', 'catId,category', array('IndustryId'=>$this->IndustryId,'entityId'=>$this->data['elementEntityId']),'','catId','ASC');
            $subscriptionData = getUserSubscriptionInfo($this->userId,$arg_list['sectionId']);
            
            $containerInfo = false;
            if($subscriptionData['subscriptionType'] != 1){
             
                $containerInfo = getUserContainerSpace($this->dirUser, $this->userId, $subscriptionData['subscriptionType']);
                $this->data = array_merge($this->data, $containerInfo);
            }
            if($subscriptionData){
                $this->data = array_merge($this->data, $subscriptionData);
            }
            // set project category
            if(!empty($arg_list[0])) {
                $this->data['projCategory'] = $arg_list[0];
            }
            $this->data['innerPage'] = 'media/form/media_tool';
            $this->data['s1menu'] = 'frist_1 TabbedPanelsTabSelected';
            $this->new_version->load('new_version','form/wizard',$this->data);
        }
    }
    
    function saveMediaTools($arg_list){
        $post = $this->input->post();
        $nextStep='';
        if(!empty($post)){
            //set sell type selection in session
            $this->session->set_userdata('projSellStatus',$post['projSellstatus']);
            
            $post['sectionId']=$arg_list['sectionId'];
            $post['IndustryId']=$this->IndustryId;
            $post['entityId']=$this->entityId;
           
            // update data in cache file
            if($this->updateDataInFile($post)){
                if(($post['addSpace'] == 1) || ($post['subscriptionType']==1 && (empty($post['availableContainer']) || !$post['availableContainer']))){
                    $nextStep='membershipcart';
                }else{
                    if($projId = $this->saveProjectData()){
                        $nextStep='setupsales'.DIRECTORY_SEPARATOR.$projId;
                        if($post['projSellstatus'] == 'f'){
                            $nextStep='uploadfile'.DIRECTORY_SEPARATOR.$projId;
                        }
                    }
                }
            }
        }
        redirect($this->redirectUrl.$nextStep); 
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to add new project
     * @return void
     */ 
    
    public function saveProjectData() {
        
        $fileData = $this->getDataFromFile();
       
        if(!empty($fileData) && is_array($fileData)){
            $isertContainer = false;
            $userContainerId=0;
            if(isset($fileData['userContainerId']) && (int)$fileData['userContainerId'] > 0){
                $userContainerId=$fileData['userContainerId'];
            }elseif(isset($fileData['addSpace']) &&  ($fileData['addSpace'] == 0) ){
                if( isset($fileData['availableContainer']) && !empty($fileData['availableContainer'])){
                    $availableContainer = json_decode($fileData['availableContainer']);
                    if(isset($availableContainer[0]->userContainerId) && ((int)$availableContainer[0]->userContainerId > 0) && ($availableContainer[0]->tdsUid == $this->userId)){
                        $userContainerId=$availableContainer[0]->userContainerId;
                    }
                }
                
                if($userContainerId==0 && ((int)$fileData['subscriptionType'] != 1)){
                    $isertContainer = true;
                }
                
            }
            
            // set industry type
            $projectType = $this->config->item('industryForSectionId'.$fileData['IndustryId']);
            // set project category
            $projCatRes = $this->model_common->getDataFromTabel('ProjCategory', 'catId',  array('IndustryId'=>$fileData['IndustryId']),'','','',1);
            if(is_array($projCatRes) && count($projCatRes) > 0) {
                $projCat = $projCatRes[0]->projCategory;
            }
            // set project donation value
            if($fileData['projSellstatus'] == 'f') {
                $projDonations = 't';
                $hasDownloadableFileOnly = '1';
            }
           
            if(((int)$userContainerId > 0) || ($isertContainer == true)){
                $projCategory = (isset($projCat))?$projCat:$fileData['projCategory'];
                $projCategory = ((int)$projCategory > 0)?$projCategory:0;
                $savedata=array(		
                    'tdsUid'          => $this->userId,							
                    'IndustryId'      => $this->IndustryId,
                    'projName'        => 'Untitled',
                    'projCategory'    => $projCategory,
                    'projSellstatus'  => $fileData['projSellstatus'],
                    'userContainerId' => $userContainerId,
                    'isArchive'       => 'f',
                    'projectType'     => (!empty($projectType))?$projectType:'',
                    'projDonations'   => (isset($projDonations))?$projDonations:'f',
                    'hasDownloadableFileOnly' =>(isset($hasDownloadableFileOnly))?$hasDownloadableFileOnly:0,
                );

                $projId = $this->model_common->addDataIntoTabel('Project', $savedata);
                
                if((int)$projId > 0){
                    addDataIntoLogSummary('Project',$projId);
                    
                    if((int)$userContainerId > 0){
                        $this->lib_package->updateUserContainer($userContainerId,$fileData['entityId'],$projId,$fileData['sectionId'],$this->IndustryId);
                    }else{
                        $tsProductId = $this->config->item('tsProductId_MediaShowcase');
                        $tsProductTitle = $this->lang->line('tsProductTitle_MediaShowcase');
                        if($fileData['subscriptionType']==3){
                            $duration = $this->config->item('MS3Y_ContainerLife');
                            $pkgId = $this->config->item('MS3Y_PkgeId');
                            $pkgRoleId = $this->config->item('MS3Y_PkgeRoleId_MediaShowcase');
                           
                        }elseif($fileData['subscriptionType']==2){
                            $duration = $this->config->item('MS1Y_ContainerLife');
                            $pkgId = $this->config->item('MS1Y_PkgeId');
                            $pkgRoleId = $this->config->item('MS1Y_PkgeRoleId_MediaShowcase');
                        }else{
                            $duration = 0;
                            $pkgId = 0;
                            $pkgRoleId = 0;
                        }
                        
                        $cData = (object) array(
                                        'tdsUid'=>$this->userId,
                                        'duration'=>$duration,
                                        'containerSize'=>0,
                                        'pkgId'=>$pkgId,
                                        'tsProductId'=>$tsProductId,
                                        'pkgRoleId'=>$pkgRoleId,
                                        'userDefaultTsProductId'=>0,
                                        'title'=>$tsProductTitle,

                                      );
                        
                        $this->lib_package->addUserContainer($cData,$fileData['entityId'],$projId,$fileData['sectionId'],$this->IndustryId,'Project','projId');
                    }
                    $this->deleteCacheFile();
                    return $projId;	
                }
            }
        }
        return false;
    }
    
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to manage membership cart under stage 1
     * @return void
     */ 
    public function membershipcart($arg_list) {
        
        // set industry name
        $indusrtyName = $arg_list['indusrty'];
        // get project id
        $projectId = $arg_list[1];
        //----- start manage data for edit project's add space 
        if(!empty($indusrtyName) && !empty($projectId)) {
            // check project id is exists or not
            $projRes = $this->isprojectexists( $projectId, $indusrtyName);
            // set project id in session for add space
            $this->session->set_userdata('addSpaceProjectId',$projectId);
            // set project status in session
            $this->session->set_userdata('projSellStatus',$projRes->projSellstatus);
            if(!empty($projRes->userContainerId)) {
                // set user container id in session for add space
                $this->session->set_userdata('projectContainerId',$projRes->userContainerId);
            }
        } else {
            // unset session values
            $this->session->unset_userdata('addSpaceProjectId');
            $this->session->unset_userdata('projectContainerId');
            $this->session->unset_userdata('projSellStatus');
        }
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
            $mediaCartData = $this->model_media->getCurrentCartData($mediaCartId);
        } 
        $this->data['mediaCartData']    = $mediaCartData;
        $this->data['subscriptionType'] = $subscriptionType;
        $this->data['innerPage'] = 'media/form/membership_cart_header';
        $this->data['subInnerPage'] = 'media/form/membership_cart';
        $this->data['s1menu'] = 'TabbedPanelsTabSelected';
        $this->data['membership2menu'] = 'TabbedPanelsTabSelected';
        
        $this->loadMediaWizardView($arg_list);
    }
    
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to manage billing information
     * @return string
     */ 
    public function billingdetails($argList) {
        
        // get users profile details
        $userProfileData = $this->model_media->getUserProfileData($this->userId);
        $userProfileData =  (!empty($userProfileData[0]))?$userProfileData[0]:''; 
        
        $this->data['userProfileData'] = $userProfileData; # set user profile data 
        $this->data['innerPage'] = 'media/form/membership_cart_header';
        $this->data['subInnerPage'] = 'media/form/billing_details';
        $this->data['s1menu'] = 'TabbedPanelsTabSelected';
        $this->data['membership3menu'] = 'TabbedPanelsTabSelected';
        $this->loadMediaWizardView($argList);
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
        // get available media container
        $availableContainer = $this->getAvailableMediaContainer();
        // set cart values
        $cartValues  = $this->setcartvalues($data); 
        // get vat percentage
        $vatPercent  = $this->config->item('media_vat_percent');
        // set vat price of total 
        $vatPrice    = (($data['cartTotalPrice']*$vatPercent)/100);
        // set total price
        $totalPrice  = $vatPrice + $data['cartTotalPrice'];
        
        // insert data in  temp membership cart tabel
        $cartId = $this->addCartData($totalPrice,$cartValues['orderType'],$vatPrice);
       
        // set default next step as blank
        $nextStep = ''; 
        if(isset($cartId) && !empty($cartId)) {
            // set cart id in session
            $this->session->set_userdata('mediaCartId',$cartId); 
            // set default values as 0
            $pkgId = 0;	
            $containerId = 0;
            $parentCartItem = 0;
            
            
            // manage add space type if project id exists
            $projectContainerId = $this->session->userdata('projectContainerId'); 
            if(!empty($projectContainerId)) {
                $elementId   = $this->session->userdata('addSpaceProjectId'); 
                $entityId    = getMasterTableRecord('Project');
                $containerId = $projectContainerId;
            } else {
                if( !empty($availableContainer) && count($availableContainer) > 0 ) {
                    // set user container id
                    $containerId = $availableContainer->userContainerId; 
                } else {
                    // add container temp item data
                    $parentCartItem = $this->addContainerMediaItem($cartId,$data,$cartValues,$pkgRoleId);
                }
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

            $nextStep = 'billingdetails'; // set next step as billing page
        }
        redirect($this->redirectUrl.$nextStep);
    }
    
    //----------------------------------------------------------------------

    /*
     * @access: private
     * @description: This function is used to set cart values as subscription 
     * @return string
     */ 
    private function setcartvalues($data) {
        
        // manage add space type if container id exists
        $projectContainerId = $this->session->userdata('projectContainerId'); 
        if(!empty($projectContainerId)) {
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
            $cartValues['tsProductId']         = $this->config->item('ts_product_id_free_user'); // set ts product id
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
     * @access: private
     * @description: This function is used to insert media container item 
     * @return string
     */ 
    private function addContainerMediaItem($cartId,$data,$cartValues,$pkgRoleId) {
        // get package role id
        $where 	 = array('pkgId' => $this->config->item('package_media_id'),'tsProductId' => $this->config->item('ts_product_id_media'));
        $packageRoleData  = $this->model_common->getDataFromTabel('MasterPackgesRole', 'pkgRoleId',  $where, '', $orderBy='pkgRoleId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        $pkgRoleId = 0;
        if( is_array($packageRoleData) && count($packageRoleData) > 0 ) {
            $pkgRoleId = $packageRoleData[0]->pkgRoleId; // set package role id
        }	
        // prepare membership cart container item data 
        $memparentItemInsert = array(
            'cartId'      => $cartId,
            'tsProductId' => $this->config->item('ts_product_id_media'),
            'price'       => $data['totalProductPrice'],
            'size'        => $cartValues['parentContainerSize'],
            'pkgId'       => $this->config->item('package_media_id'),
            'pkgRoleId'   => $pkgRoleId,
            'totalPrice'  => $cartValues['containerPrice'],
            'type'        => $this->config->item('membership_item_type_1'),
            );
        // insert data in  temp membership cart item tabel
        $parentCartItem = $this->model_membershipcart->addDataMem($memparentItemInsert);
        return $parentCartItem;
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
     * @access: public
     * @description: This function is used to manage billing data 
     * @return string
     */ 
    public function billingdetailspost() {
        
        // get billing form post values 
        $billingData = $this->input->post();
        $nextStep = ''; // set default next step as blank
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
        
        redirect($this->redirectUrl.$nextStep);
    }
    
    //----------------------------------------------------------------------

    /*
     * @access: private
     * @description: This function is used to update buyer billing data
     * @return string
     */ 
    private function updatebuyerdata($billingDataArray,$billingData,$cartId) {
        // add billing data in cart 
        $this->model_media->updateBillingData(array('billingdetails'=>json_encode($billingDataArray)), $cartId);
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
    public function purchasesummary($argList) {
        
        // get membership card from session
        $cartId = $this->session->userdata('mediaCartId');
        
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
            redirect($this->redirectUrl);
        }
        
        // get users seller details 
        $userSellerData = $this->model_media->getUserProfileData($this->userId);
        // set wizard section
        $this->session->set_userdata('wizardMediaSection',$this->router->fetch_method()); 
        // get vat percentage	
        $vatPercent  = $this->config->item('media_vat_percent');
        // calculate total price
        $totalPrice  = $spacePrice + $containerPrice;
        // set vat price of total 
        $vatPrice    = (($totalPrice*$vatPercent)/100);
        $this->data['spaceSize']        = $spaceSize;
        $this->data['spaceUnit']        = $spaceUnit;	
        $this->data['spacePrice']       = $spacePrice;
        $this->data['totalPrice']       = $totalPrice;
        $this->data['vatPrice']         = $vatPrice;
        $this->data['containerPrice']   = $containerPrice;		
        $this->data['buyerSettingData'] = $buyerBillingData;	
        $this->data['userSellerData']   = (!empty($userSellerData[0]))?$userSellerData[0]:'';
        $this->data['innerPage'] = 'media/form/membership_cart_header';
        $this->data['subInnerPage'] = 'media/form/purchase_summary';
        $this->data['s1menu'] = 'TabbedPanelsTabSelected';
        $this->data['membership4menu'] = 'TabbedPanelsTabSelected';
        $this->loadMediaWizardView($argList);
        
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to show payment error view
     * @return void
     */ 
    
    public function paymenterror($arg_list) {
        
        // manage payment error page display
        $this->data['innerPage']       = 'media/form/payment_error';
        $this->data['s1menu']          = 'TabbedPanelsTabSelected';
        $this->loadMediaWizardView($arg_list);  
       
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to show payment success view
     * @return void
     */ 
    
    public function paymentsuccess($arg_list) {
        // get media container id
        $mediaContainerId = $this->session->userdata('mediaContainerId');
        $nextStep = '';
        if(!empty($mediaContainerId)) {
            $cacheData = array(
                'sectionId'       => $arg_list['sectionId'],
                'IndustryId'      => $this->IndustryId,
                'entityId'        => getMasterTableRecord('Project'),
                'userContainerId' => $mediaContainerId,
            );
            // update data in cache file
            $this->updateDataInFile($cacheData);
            
            // get sell type
            $projSellStatus  = $this->session->userdata('projSellStatus');
            
            // set project id in session for add space
            $addSpaceProjectId  = $this->session->userdata('addSpaceProjectId');
          
            if(!empty($addSpaceProjectId)) {
                $projId = $addSpaceProjectId;
                // update space for free member
                $this->updatefreeaddpace();
            } else {
                // add project data
                $projId = $this->saveProjectData();
            }
           
            if(!empty($projId)) {
                // set project id
                $this->session->set_userdata('mediaProjectId',$projId);
                
                $successContent  = $this->lang->line('nextSetupSell');
                $nextStep = 'setupsales'.DIRECTORY_SEPARATOR.$projId;
                if($projSellStatus == 'f') {
                    $successContent  = $this->lang->line('nextUploadMedia');
                    $nextStep = 'uploadfile'.DIRECTORY_SEPARATOR.$projId;
                }
                // set edit project page in add space case
                if(!empty($addSpaceProjectId)) {
                    $nextStep = 'editproject'.DIRECTORY_SEPARATOR.$projId;
                    // unset session values
                    $this->session->unset_userdata('addSpaceProjectId');
                    $this->session->unset_userdata('projectContainerId');
                    $this->session->unset_userdata('projSellStatus');
                }
                
            }
            
            // manage payment success page display
            $this->data['nextStep']        = $nextStep;
            $this->data['successContent']  = $successContent;
            $this->data['innerPage']       = 'media/form/payment_success';
            $this->data['s1menu']          = 'TabbedPanelsTabSelected';
            $this->loadMediaWizardView($arg_list);   
        } else {
            redirect($this->redirectUrl);
        }
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to get update ad space of project
     * @return void
     */ 
    private function updatefreeaddpace() {
        // get media container id
        $mediaContainerId = $this->session->userdata('mediaContainerId');
        //get logged user subscription details
        $whereSubcrip    = array('tdsUid' => $this->userId);
        $subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', 'subscriptionType',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($subcripDetails) && !empty($mediaContainerId)) {
            $subscriptionType  = $subcripDetails[0]->subscriptionType; // set subscription type
            if( $subscriptionType == 1 ) { //set space values for free type
                // get item's space size  
                $itemMembershipRes = $this->model_media->getItemContainerSize($mediaContainerId);
                if(!empty($itemMembershipRes)) {
                    // add total space
                    $addSpace = intval($itemMembershipRes[0]->containerSize) + intval($itemMembershipRes[0]->size);
                    // update added space
                    $this->model_common->editDataFromTabel('UserContainer', array('containerSize'=>$addSpace), array('userContainerId' => $mediaContainerId));
                }
            }
        }
    } 
     
    //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to get user's available container
     * @return void
     */ 
    
    private function getAvailableMediaContainer() {
        
        //get logged user subscription details
        $whereSubcrip 		= array('tdsUid' => $this->userId);
        $subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', 'subscriptionType',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        $availableContainer  = '';
        // set users subscription type
        if(!empty($subcripDetails)) {
            $this->data['subscriptionType'] = $subcripDetails[0]->subscriptionType;
            // get available container data 
            $uc = new lib_userContainer();
            $availableContainer = $uc->getAvailableUserContainer($this->userId,1); // get media containers by filmvideo type 
            if(!empty($availableContainer) && is_array($availableContainer)) {
                $availableContainer = $availableContainer[0];
            }
        } 
        return $availableContainer;
    }
    
    
    public function setupsales($arg_list) {
        $this->data['innerPage'] = 'media/form/setup_sales';
        $this->data['subInnerPage'] = 'media/form/currency';
        $this->data['s2menu'] = 'TabbedPanelsTabSelected';
        $this->data['salesSetupS1Menu'] = 'TabbedPanelsTabSelected';
        $this->data['s2menuCurrency'] = 'TabbedPanelsTabSelected';
        $this->data['sabNavigation'] = 'media/form/sales_navigation';
        $arg_list['mode']='edit';
        $this->loadMediaWizardView($arg_list);
    }
    
    public function saveCurrency($arg_list) {
        $post = $this->input->post();
        $nextStep='';
        if(isset($post['seller_currency']) && is_numeric($post['seller_currency'])){
            $currency = $post['seller_currency'];
            $projId = $post['projId'];
            $UserSellerSettings = array(
            'tdsUid' => $this->userId, 				
            'seller_currency' => $currency			
            );
            
            $res=$this->model_common->getDataFromTabel('UserSellerSettings', 'id',  array('tdsUid'=>$this->userId),'','','',1);
            if(isset($res[0]->id) && $res[0]->id > 0){				
                $this->model_common->editDataFromTabel('UserSellerSettings', $UserSellerSettings, 'id', $res[0]->id);
            }else{
                $this->model_common->addDataIntoTabel('UserSellerSettings', $UserSellerSettings);
            }
            $this->session->set_userdata(array('seller_currency'	=> $currency));
            $nextStep='setpriceformat'.DIRECTORY_SEPARATOR.$projId;
        }		
        redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.$nextStep); 
    }
    
    public function setpriceformat($arg_list) {
        $this->data['innerPage'] = 'media/form/setup_sales';
        $this->data['subInnerPage'] = 'media/form/set_price_format';
        $this->data['s2menu'] = 'TabbedPanelsTabSelected';
        $this->data['salesSetupS1Menu'] = 'TabbedPanelsTabSelected';
        $this->data['s2menuPF'] = 'TabbedPanelsTabSelected';
        $this->data['sabNavigation'] = 'media/form/sales_navigation';
        $arg_list['mode']='edit';
        $this->loadMediaWizardView($arg_list);
    }
    
    function savePriceformat($arg_list){
        $post = $this->input->post();
        $nextStep='';
        if(isset($post['projSellType']) && is_numeric($post['projSellType']) && (int)$post['projId'] > 0){
            $saveData=array('projSellType'=>$post['projSellType']);
            $this->model_common->editDataFromTabel('Project', $saveData, 'projId', $post['projId']);
            $nextStep='inventorytype'.DIRECTORY_SEPARATOR.$post['projId'];
        }
        redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.$nextStep); 
    }
    
    public function inventorytype($arg_list) {
        $this->data['innerPage'] = 'media/form/setup_sales';
        $this->data['subInnerPage'] = 'media/form/inventory_type';
        $this->data['s2menu'] = 'TabbedPanelsTabSelected';
        $this->data['salesSetupS1Menu'] = 'TabbedPanelsTabSelected';
        $this->data['s2menuIT'] = 'TabbedPanelsTabSelected';
        $this->data['sabNavigation'] = 'media/form/sales_navigation';
        $arg_list['mode']='edit';
        $this->loadMediaWizardView($arg_list);
    }
    
    function saveInventorytype($arg_list){
        $post = $this->input->post();
        $nextStep='';
        if(isset($post['hasDownloadableFileOnly']) && is_numeric($post['hasDownloadableFileOnly']) && (int)$post['projId'] > 0){
            $saveData=array('hasDownloadableFileOnly'=>$post['hasDownloadableFileOnly']);
            $this->model_common->editDataFromTabel('Project', $saveData, 'projId', $post['projId']);
            $nextStep='setuppricing';
            if(isset($post['projSellType']) && $post['projSellType']==2){
                $nextStep='setupauction';
            }
            $nextStep=$nextStep.DIRECTORY_SEPARATOR.$post['projId'];
        }
        redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.$nextStep); 
    }
    
    public function  setuppricing($arg_list) {
        $this->data['innerPage'] = 'media/form/setup_sales';
        $this->data['subInnerPage'] = 'media/form/setup_pricing';
        $this->data['s2menu'] = 'TabbedPanelsTabSelected';
        $this->data['salesSetupS1Menu'] = 'TabbedPanelsTabSelected';
        $this->data['s2menuSP'] = 'TabbedPanelsTabSelected';
        $this->data['sabNavigation'] = 'media/form/sales_navigation';
        $arg_list['mode']='edit';
        $this->loadMediaWizardView($arg_list);
    }
    
    function savePricing($arg_list){
        $post = $this->input->post();
        $nextStep='';
        if(isset($post['sellPriceType']) && is_numeric($post['sellPriceType']) && (int)$post['projId'] > 0){
            $saveData=array('sellPriceType'=>$post['sellPriceType']);
            $this->model_common->editDataFromTabel('Project', $saveData, 'projId', $post['projId']);
            
            $nextStep='pricing';
            if($post['sellPriceType'] ==3 ){
                $nextStep='pickupshipping';
                if(isset($post['hasDownloadableFileOnly']) && $post['hasDownloadableFileOnly']==1){
                    $nextStep='sellerconsumptiontax';
                }
            }
            $nextStep=$nextStep.DIRECTORY_SEPARATOR.$post['projId'];
        }
        redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.$nextStep); 
    }
    
    public function setupauction($arg_list) {
        $this->data['innerPage'] = 'media/form/setup_sales';
        $this->data['subInnerPage'] = 'media/form/setup_auction';
        $this->data['s2menu'] = 'TabbedPanelsTabSelected';
        $this->data['salesSetupS2Menu'] = 'TabbedPanelsTabSelected';
        $arg_list['mode']='edit';
        $projId=(isset($arg_list[1]) && (int)$arg_list[1] >= 1)?$arg_list[1]:0;
        $whereCondition = array(
            'projectId'=>$projId,
            'entityId'=>$this->entityId,
            'elementId'=>$projId,
            'tdsUid'=>$this->userId,
        );
        $auctionData=$this->model_common->getDataFromTabel('Auction', '*', $whereCondition, '', '', '', 1,0,1);
       
        if(isset($auctionData[0])){
           $this->data['auctionData'] = $auctionData[0];
        }
        $this->loadMediaWizardView($arg_list);
    }
    
    function saveAuctionPrice($arg_list){
        $post = $this->input->post();
        
        $nextStep='';
        if(isset($post['minBidPrice']) && is_numeric($post['minBidPrice']) && ((int)$post['projId'] > 0) ){
            $auctionId	= $post['auctionId'];
            $days	= $post['days'];
            $days= ((int)$days > 0)?$days:0;
            $startDate= ($post['startDate'] == '')?currntDateTime('Y-m-d'):$post['startDate'];
            $endDate = $startDate=date('Y-m-d H:i:s',strtotime($startDate));
            if($days > 0){
               $daySTring = $days.' day';
               $endDate =  getPreviousOrFututrDate($startDate, $daySTring, 'Y-m-d H:i:s');
            }
            
            $saveData=array(
                            'minBidPrice'=>$post['minBidPrice'],
                            'startDate'=>$startDate,
                            'endDate'=>$endDate,
                            'projectId'=>$post['projId'],
                            'entityId'=>$this->entityId,
                            'elementId'=>$post['projId'],
                            'tdsUid'=>$this->userId,
                            );
                            
                           
                            
            $this->load->model('auction/model_auction');    
            $auctionId = ((int)$auctionId > 0)?$auctionId:0;
            $this->model_auction->auctionInformationInsert($saveData,$auctionId);
            $nextStep='pickupshipping';
            if(isset($post['hasDownloadableFileOnly']) && $post['hasDownloadableFileOnly']==1){
                $nextStep='sellerconsumptiontax';
            }
            $nextStep=$nextStep.DIRECTORY_SEPARATOR.$post['projId'];
        }
        redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.$nextStep); 
    }
    
    public function pricing($arg_list) {
        $this->data['innerPage'] = 'media/form/setup_sales';
        $this->data['subInnerPage'] = 'media/form/project_price';
        $this->data['s2menu'] = 'TabbedPanelsTabSelected';
        $this->data['salesSetupS2Menu'] = 'TabbedPanelsTabSelected';
        $arg_list['mode']='edit';
        $this->loadMediaWizardView($arg_list);
    }
    
    function saveProjectPrice($arg_list){
        $post = $this->input->post();
        $nextStep='';
        $isPrice=false;
        if(isset($post['projPrice']) && is_numeric($post['projPrice']) ){
           $isPrice=true;
           $saveData=array('projPrice'=>$post['projPrice'],'isprojPrice'=>'t','isprojDownloadPrice'=>'f');
        }elseif(isset($post['projDownloadPrice']) && is_numeric($post['projDownloadPrice']) ){
           $isPrice=true;
           $saveData=array('projDownloadPrice'=>$post['projDownloadPrice'],'isprojPrice'=>'f','isprojDownloadPrice'=>'t');
        }
        
        if($isPrice && ((int)$post['projId'] > 0) ){
            $this->model_common->editDataFromTabel('Project', $saveData, 'projId', $post['projId']);
            $nextStep='pickupshipping';
            if(isset($post['hasDownloadableFileOnly']) && $post['hasDownloadableFileOnly']==1){
                $nextStep='sellerconsumptiontax';
            }elseif(($post['sellPriceType'] == 1) && ($post['hasDownloadableFileOnly']==0) ){
                $nextStep='inventory';
            }
            
            $nextStep=$nextStep.DIRECTORY_SEPARATOR.$post['projId'];
        }
        redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.$nextStep); 
    }
    
    public function inventory($arg_list) {
        $this->data['innerPage'] = 'media/form/setup_sales';
        $this->data['subInnerPage'] = 'media/form/inventory';
        $this->data['s2menu'] = 'TabbedPanelsTabSelected';
        $this->data['salesSetupS2Menu'] = 'TabbedPanelsTabSelected';
        $arg_list['mode']='edit';
        $this->loadMediaWizardView($arg_list);
    }
    
    function saveProjectInventory($arg_list){
        $post = $this->input->post();
        $nextStep='';
        if( isset($post['projQuantity']) && is_numeric($post['projQuantity']) && ((int)$post['projId'] > 0) ){
            $saveData=array('projQuantity'=>$post['projQuantity']);
            $this->model_common->editDataFromTabel('Project', $saveData, 'projId', $post['projId']);
            $nextStep='pickupshipping';
            if(isset($post['hasDownloadableFileOnly']) && $post['hasDownloadableFileOnly']==1){
                $nextStep='sellerconsumptiontax';
            }
            $nextStep=$nextStep.DIRECTORY_SEPARATOR.$post['projId'];
        }
        redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.$nextStep); 
    }
    
    public function previewpublish($arg_list) {
        $this->data['innerPage'] = 'media/form/preview_publish';
        $this->data['s5menu'] = 'TabbedPanelsTabSelected';
        $arg_list['mode']='edit';
        $this->loadMediaWizardView($arg_list);
    }
    
    public function publicise($arg_list) {
        $this->data['innerPage'] = 'media/form/publicise';
        $this->data['s5menu'] = 'TabbedPanelsTabSelected';
        $arg_list['mode']='edit';
        $this->loadMediaWizardView($arg_list);
    }
    
    function saveProjectStatus($arg_list){

        $post = $this->input->post();
        $nextStep=$this->config->item($this->router->fetch_method().'_bkendmathod').DIRECTORY_SEPARATOR.$post['projId'];
        if( isset($post['isPublished']) && ((int)$post['projId'] > 0) ) {
            $isPublished = ($post['isPublished']=='t') ? 't' : 'f';
            $saveData=array('isPublished'=>$isPublished);
            $this->model_common->editDataFromTabel('Project', $saveData, 'projId', $post['projId']);
            // update publish status of project elements
            $indusrtyName = $arg_list['indusrty'];
            if(!empty($indusrtyName)) {
                // get element's table name
                $elementTblPrefix = $this->config->item( $indusrtyName.'Prifix');
                $elementTable = $elementTblPrefix.'Element';
                $this->model_common->editDataFromTabel($elementTable, $saveData, 'projId', $post['projId']);
            }
            if($isPublished == 't'){
                redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'share'.DIRECTORY_SEPARATOR.$post['projId']); 
            }
        }
        redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$nextStep); 
    }
    
    public function share($arg_list) {
        $projId=(isset($arg_list[1]) && (int)$arg_list[1] >= 1)?$arg_list[1]:0;
        if($projId >= 1){
            
            // get industry name 
            $indusrtyName  =  $arg_list['indusrty']; 
            // check project id is exists or not
            $projRes = $this->isprojectexists( $projId,$indusrtyName );
            // prepare short link
            $shareURL = lang()."/mediafrontend/mediashowcases/$this->userId/$projId";
            $this->data['shortLink'] = $this->model_common->getShortLink($shareURL,$this->userId);
            $this->data['innerPage'] = 'share/share_with_social_media';
            $this->data['shareMenu'] = 'TabbedPanelsTabSelected';
            
            $this->data['backurl'] = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'publicise'.DIRECTORY_SEPARATOR.$projId);
            $this->data['nexturl'] = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'email'.DIRECTORY_SEPARATOR.$projId);
            $this->data['isShareMenu'] = 1; 
            $this->data['elementShortLink'] = $this->manageelementshortlink($arg_list,$projId);  // set  first elements short link
            //get media file types
            $this->data['fileFormateNames'] = $this->setfilename($indusrtyName,$projRes,0); 
            $arg_list['mode']='edit';
            $arg_list['loadPage'] = 'form/wizard_additionalInfo';
            $this->loadMediaWizardView($arg_list);
        }
        else{
            redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method());
        }
    }
    
    public function email($arg_list) {
        $projId=(isset($arg_list[1]) && (int)$arg_list[1] >= 1)?$arg_list[1]:0;
        if($projId >= 1){
             // get industry name 
            $indusrtyName  =  $arg_list['indusrty']; 
            // check project id is exists or not
            $projRes = $this->isprojectexists( $projId,$indusrtyName );
            // prepare short link
            $shareURL = lang()."/mediafrontend/mediashowcases/$this->userId/$projId";
            $this->data['shortLink'] = $this->model_common->getShortLink($shareURL,$this->userId);
            $this->data['innerPage'] = 'share/share_with_email';
            $this->data['emailMenu'] = 'TabbedPanelsTabSelected';
            
            $this->data['backurl'] = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'share'.DIRECTORY_SEPARATOR.$projId);
            $this->data['nexturl'] = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'prnews'.DIRECTORY_SEPARATOR.$projId);
            // set element's short link
            $this->data['elementShortLink'] = $this->manageelementshortlink($arg_list,$projId);
            //get media file types
            $this->data['fileFormateNames'] = $this->setfilename($indusrtyName,$projRes,0); 
            $arg_list['mode']='edit';
            $arg_list['loadPage']='form/wizard_additionalInfo';
            $this->loadMediaWizardView($arg_list);
        }
        else{
            redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method());
        }
        
    }
    
    
     public function prnews($arg_list) {
        $projId=(isset($arg_list[1]) && (int)$arg_list[1] >= 1)?$arg_list[1]:0;
        $this->data['innerPage'] = 'media/form/prmaterial';
        $this->data['PRMenu'] = 'TabbedPanelsTabSelected';
        $this->data['PRnewsMenu'] = 'TabbedPanelsTabSelected';
        $this->data['table'] = 'AddInfoNews';
        $this->data['backurl'] = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'email'.DIRECTORY_SEPARATOR.$projId);
        $this->data['nexturl'] = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'prreviews'.DIRECTORY_SEPARATOR.$projId);
        $arg_list['mode']='edit';
        $arg_list['loadPage']='form/wizard_additionalInfo';
        $this->loadMediaWizardView($arg_list);
    }
    
    public function prreviews($arg_list) {
        $projId=(isset($arg_list[1]) && (int)$arg_list[1] >= 1)?$arg_list[1]:0;
        $this->data['innerPage'] = 'media/form/prmaterial';
        $this->data['PRMenu'] = 'TabbedPanelsTabSelected';
        $this->data['PRreviewsMenu'] = 'TabbedPanelsTabSelected';
        $this->data['table'] = 'AddInfoReviews';
        $this->data['backurl'] = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'prnews'.DIRECTORY_SEPARATOR.$projId);
        $this->data['nexturl'] = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'prreinterviews'.DIRECTORY_SEPARATOR.$projId);
        $arg_list['mode']='edit';
        $arg_list['loadPage']='form/wizard_additionalInfo';
        $this->loadMediaWizardView($arg_list);
    }
    
    public function prreinterviews($arg_list) {
        $projId=(isset($arg_list[1]) && (int)$arg_list[1] >= 1)?$arg_list[1]:0;
        $this->data['innerPage'] = 'media/form/prmaterial';
        $this->data['PRMenu'] = 'TabbedPanelsTabSelected';
        $this->data['PRinterviewsMenu'] = 'TabbedPanelsTabSelected';
        $this->data['table'] = 'AddInfoInterview';
        $this->data['backurl'] = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'prreviews'.DIRECTORY_SEPARATOR.$projId);
        $this->data['nexturl'] = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->config->item($this->router->fetch_method().'_bkendmathod').DIRECTORY_SEPARATOR.$projId);
        $arg_list['mode']='edit';
        $arg_list['loadPage']='form/wizard_additionalInfo';
        $this->loadMediaWizardView($arg_list);
    }
    
    
    public function loadMediaWizardView($arg_list) {
       
        $isData = false;
        $projId = 0;
        $mode = (isset($arg_list['mode']) && $arg_list['mode']=='edit')?'edit':'add';
        if($mode == 'add' ){
           
            $fileData = $this->getDataFromFile();
            //if(!empty($fileData) && is_array($fileData)){
                array_merge($fileData,$this->data);
                //$this->data = array_merge($fileData,$this->data);
                $availableContainer = $this->getAvailableMediaContainer();
                $this->data['availableContainer'] = $availableContainer;
                // get media project id
                $mediaProjectId = $this->session->userdata('mediaProjectId'); 
                $projId = (isset($mediaProjectId) && (int)$mediaProjectId >= 1)?$mediaProjectId:0;
                // get media container id
                $mediaContainerId = $this->session->userdata('mediaContainerId');
                if(!empty($mediaContainerId)) {
                    // update container id in cache file
                    $this->updateDataInFile(array('containerId' => $mediaContainerId));
                    
                }
                $isData=true;
           // }
            
        }else{
            $projId=(isset($arg_list[1]) && (int)$arg_list[1] >= 1)?$arg_list[1]:0;
            if($projId >= 1){
                $projectData=$this->model_media->getProjectInfo($projId,$this->IndustryId,$this->userId);
                 if(isset($projectData[0])){
                    $this->data = array_merge($this->data,$projectData[0]);
                    //$this->data['projectIndexLink']=base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->config->item($this->router->fetch_method().'_bkendmathod').DIRECTORY_SEPARATOR.$projId);
                    // set base url
                    $baseUrl = formBaseUrl(); 
                    $this->data['projectIndexLink'] = $baseUrl.DIRECTORY_SEPARATOR.'editproject'.DIRECTORY_SEPARATOR.$projId;
                    $isData=true;
                }
            }
        }
        
        if($isData){
            $loadPage = (isset($arg_list['loadPage']) && !empty($arg_list['loadPage']))?$arg_list['loadPage']:'form/wizard';
            $indusrty = $arg_list['indusrty'];
            $this->load->language($indusrty);
            $this->data['industry']  = $indusrty;
            $this->data['sectionId'] = $arg_list['sectionId'];
            $this->data['entityId']  = $this->entityId;
            $this->data['projId']    = $projId;
            $this->data['userId']    = $this->userId;
            $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
            $this->new_version->load('new_version',$loadPage,$this->data);
        } else {
            redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method());
        }
    }
    
    function updateDataInFile($data= array()){
        
        $return = false;
        if(!empty($data)){
            $fileData = $this->getDataFromFile();
            if(!empty($fileData) && is_array($fileData)){
                $data = array_merge($fileData,$data);
            }
            $return = $this->saveDataInFile($data);
        }
        return $return;
    }
    
    function saveDataInFile($data=array()){
        if(!empty($data)){
            $cacheFile=$this->dirCacheMedia.$this->router->fetch_method().'_user_'.$this->userId.'_ip_'.$this->visitorsIP.'.php';
            if(!is_dir($this->dirCacheMedia)){
                @mkdir($this->dirCacheMedia, 777, true);
            }
            $cmd3 = 'chmod -R 777 '.$this->dirCacheMedia;
            exec($cmd3);
            $data=str_replace("'","&apos;",json_encode($data));	//encode data in json format
            $stringData = '<?php $ProjectData=\''.$data.'\';?>';
            if (!write_file($cacheFile, $stringData)){	// write cache file
                echo 'Unable to write the file'; die;
                return false;
            }else{
                return true;
            }
        }
    }
    
    function getDataFromFile($cacheFile=''){
        $cacheFile= trim($cacheFile);
        if(empty($cacheFile) || $cacheFile=''){
            $cacheFile=$this->dirCacheMedia.$this->router->fetch_method().'_user_'.$this->userId.'_ip_'.$this->visitorsIP.'.php';
        }
        if(is_file($cacheFile)){
            include($cacheFile);
            if(isset($ProjectData) && !empty($ProjectData)){
                return json_decode($ProjectData, true);
            }
        }else{
            return false;
        }
        
    }
    
    function deleteCacheFile($cacheFile=''){
        $fileData = false;
        $cacheFile= trim($cacheFile);
        if(empty($cacheFile) || $cacheFile=''){
            $cacheFile=$this->dirCacheMedia.$this->router->fetch_method().'_user_'.$this->userId.'_ip_'.$this->visitorsIP.'.php';
        }
        if(is_file($cacheFile)){
            if(unlink($cacheFile)){
                return true;
            }
        }else{
            return false;
        }
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

    //-----------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to review insert of any user
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    public function updateReview(){
        
        $loggedUserId   =   isloginUser(); 
        $title          =   $this->input->post('articleTitle');
        $editElementId  =   $this->input->post('editElementId');
        $editProjectId  =   $this->input->post('editProjectId');

        $isEdit         =   $this->input->post('isEdit');		      

        if(isset($title) && ($title=='')){  
            redirect(base_url()); 
        }

        $wordCnt = $this->input->post('wordCount');
        $wordCount=(!empty($wordCnt))? $wordCnt : '0' ;
                                  
        // Check Review		      		    
        $proId=$this->model_media->getReviewId($loggedUserId);
        $this->session->set_userdata('reviews_'.$this->userId,1);
      
        if($proId!=''){
            
            $getProjectData =  $this->model_common->getDataFromTabel('Project', 'isPublished',  array('projId'=>$proId),'','','',1);  
            
            if(!empty($getProjectData)){
                $getProjectData  =  $getProjectData[0];
                $isPublished     =  (!empty($getProjectData->isPublished))?$getProjectData->isPublished:'f';
            }
            
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
                'isPublished'       =>$isPublished
            );

            if($isEdit==''){					
                $elemId  = $this->model_media->addReview($data);						
                if($elemId)				
                $this->model_media->checkLogSummary($elemId,$proId);
            }	
            // if(isset($isEdit) && !empty($isEdit))
        }
    }
    
    //----------------------------------------------------------------------
      
              
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
                
                    $entityId=$this->entityId;
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
                    $entityId=$this->entityId;
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
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's shipping details
     * @access: public
     * @return void
     */ 
    public function shipping($arg_list) {
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // check project id is exists or not
        $projRes =  $this->isprojectexists( $projectId,$arg_list['indusrty'] );
        // set back url page
        $backPage = 'setuppricing';
        if($projRes->sellPriceType!= 3) {
            $backPage = 'pricing';
        }
        if(!empty($projRes->printDeliveryOptions)) {
            $deliveryOptions = json_decode($projRes->printDeliveryOptions);
            if(in_array('1',$deliveryOptions) && $arg_list[2] != 1 && $arg_list[2] != 2) {
                // manage pickup details
                $this->pickupshipping($arg_list);
            } else if(in_array('2',$deliveryOptions) && $arg_list[2] != 2) {
                // manage domestic shipping details
                $this->domesticshipping($arg_list);
            } else {
                // manage international shipping zone details
                $this->internationalshipping($arg_list);
            }
        } else {
            // set print delivery options form 
            $this->data['subInnerPage']     = 'media/form/shipping_delivery_options';
            $this->data['shippingNav']      = false; 
            $this->data['backPage']         = $backPage;
            $this->data['projectId']        = $projectId;
            $this->data['elementId']        = $elementId;
            $this->data['innerPage']        = 'media/form/setup_sales';
            $this->data['s2menu']           = 'TabbedPanelsTabSelected';
            $this->data['salesSetupS3Menu'] = 'TabbedPanelsTabSelected';
            $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
            $this->new_version->load('new_version','form/wizard',$this->data);
        }
    }

    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's pickup details
     * @access: public
     * @return void
     */ 
    public function pickupshipping($arg_list) {
        // get post data
        $postData = $this->input->post();
        // get user id
        $userId = $this->userId;
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
       
        // set pickup id
        $pickupId = 0;
        
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes =  $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
            // set prefix
            $elementTblPrefix = $this->config->item($arg_list['indusrty'].'Prifix');
            // get media element table name
            $mediaElementTbl = $elementTblPrefix.'Element';
            $entityId = getMasterTableRecord($mediaElementTbl);
            // get project's pickup data if exists
            $userPickupData = $this->model_media->getProjectPickupData($elementId,$userId,$entityId);
            // set shipping options
            $shippingOptions = $projRes->shippingOptions;
            // if not price and shipping charge allow
            $ispriceshippingcharge = $this->_ispriceshippingcharge($projRes);
    
            // set back url page
            $backPage = 'uploadtitle';
            if($ispriceshippingcharge == 3) {
                $backPage = 'priceshippingcharge';
            }
       
        } else {
            // check project id is exists or not
            $projRes =  $this->isprojectexists( $projectId,$arg_list['indusrty'] );
            $entityId = getMasterTableRecord('Project');
            // get project's pickup data if exists
            $userPickupData = $this->model_media->getProjectPickupData($projectId,$userId,$entityId);
            // set shipping options
            $shippingOptions = $projRes->printDeliveryOptions;
            // set back url page
            $backPage = 'setuppricing';
            if($projRes->sellPriceType != 3) {
                $backPage = 'pricing';
            }
        }
        
       
        if(!empty($postData) && $postData['isCopy'] == 't') {
            // get global pick data info
            $userPickupData = $this->model_media->getGlobalPickupData($userId);
            $userPickupData = $userPickupData[0];
        } else {
             if( is_array($userPickupData) && count($userPickupData)>0 ) {
                $userPickupData = $userPickupData[0];
                // set pickup id
                $pickupId = $userPickupData->pickupId;
            }
        }
        $deliveryOptions = json_decode($shippingOptions);
       
        
        if(!empty($shippingOptions)) {
            if(!empty($pickupId) || !empty($postData)) {
                $this->data['subInnerPage'] = 'media/form/pickup_shipping';
            } else {
                $this->data['subInnerPage'] = 'media/form/pickup_shipping_copy';
            }
        } else {
            // set print delivery options form 
            $this->data['subInnerPage'] = 'media/form/shipping_delivery_options';
            $this->data['shippingNav'] = false; 
        }
        // set print delivery options
        $this->data['deliveryOptions']  = $deliveryOptions;
        // prepare form data values
        $this->data['shippingNav']      = true; 
        $this->data['backPage']         = $backPage;
        $this->data['shippingS1Menu']   = 'TabbedPanelsTabSelected'; 
        $this->data['userProfileData']  = isset($userPickupData)?$userPickupData:false;
        $this->data['projectId']        = $projectId;
        $this->data['elementId']        = $elementId;
        $this->data['pickupId']         = $pickupId;
        $this->data['indusrty']         = $arg_list['indusrty'];
        $this->data['entityId']         = $entityId;
        
        $this->data['salesSetupS3Menu'] = 'TabbedPanelsTabSelected';
        if(!empty($elementId)) {
            $this->data['innerPage']        =  'media/form/upload_n_describe_images'; // set view of stage 3
            $this->data['s3menu']           = 'TabbedPanelsTabSelected';
            $this->data['uploadSubMenuShipping'] = 'TabbedPanelsTabSelected';
            $this->data['ispriceShippingCharge']   = $ispriceshippingcharge; // get price shipping page is show
        } else {
            $this->data['innerPage']        = 'media/form/setup_sales';
            $this->data['s2menu']           = 'TabbedPanelsTabSelected';
        }
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/wizard',$this->data);
            
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to store project's shipping pickup data
     * @access: public
     * @return void
     */ 
    public function saveshippingpickup($arg_list) {
        // get pickup form post data
        $pickupData = $this->input->post();
        
        $nextStep = '';
        $msg = $this->lang->line('errorDuringUpdation');
        $type = 'error';
        if(!empty($pickupData)) {
            // set pickup elemenet id
            $elementId = $pickupData['projectId'];
            if(!empty($pickupData['elementId'])) {
                $elementId = $pickupData['elementId'];
            }
            // get login user id 
            $userId = $this->userId;
            // prepare shipping pickup data
            $projPickupData = array(
                'pickupCountry' => $pickupData['pickupCountry'],
                'pickupState'   => $pickupData['stateList'],
                'pickupCity'    => $pickupData['pickupCity'],
                'pickupSubrub'  => $pickupData['pickupSuberb'],
                'pickupZip'     => $pickupData['pickupZip'],
                'pickupRequirements' => $pickupData['pickupRequirements'],
                'entityId'      => $pickupData['entityId'],
                'elementId'     => $elementId,
                'tdsUid'        => $userId
            );
            
            if(isset($pickupData['isSameAsGlobal']) && !empty($pickupData['isSameAsGlobal'])) {
                // manage global pickup data
                $this->manageGlobalPickup($projPickupData);
            }
           
            if(!empty($pickupData['projPickupId'])) {
                // add project pickup data
                $this->model_media->updatePickup($pickupData['projPickupId'],$projPickupData);
                //$nextStep = '/shipping/'.$pickupData['elementId'];
            } else {
                // add project pickup data
                $pickupId = $this->model_media->addPickup($projPickupData);
                if(!empty($pickupId)) {
                   // $nextStep = '/shipping/'.$pickupData['elementId'].'/1';
                }
            }
            
            if(!empty($pickupData['elementId'])) {
                // check project id is exists or not
                $projRes =  $this->isprojectelementexists( $pickupData['projectId'],$pickupData['elementId'],$arg_list['indusrty'] );
            } else  {
                // check project id is exists or not
                $projRes  = $this->isprojectexists( $pickupData['projectId'],$pickupData['indusrty'] );
            }
            
            // get next page url
            $nextStep = $this->manageshippingnexturl($projRes,$pickupData);
            
            $msg = $this->lang->line('successSavePickup');
            $type = 'success';
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$nextStep));
        //redirect($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.$nextStep);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to get shipping next url
     * @access: private
     * @return void
     */ 
    private function manageshippingnexturl($projRes,$pickupData,$isDomestic=0) {
        $nextStep = '';
        if(!empty($projRes->printDeliveryOptions)) {
            $deliveryOptions = json_decode($projRes->printDeliveryOptions);
            if(in_array('2',$deliveryOptions) && $isDomestic != 1 ) {
                // set domestic shipping url
                $nextStep = '/domesticshipping/'.$pickupData['projectId'];
                if(isset($projRes->elementId)) {
                    // set domestic shipping url
                    $nextStep = '/domesticshipping/'.$pickupData['projectId'].'/'.$pickupData['elementId'];
                }
                
            } else if(in_array('3',$deliveryOptions)) {
                // set international shipping url
                $nextStep = '/internationalshipping/'.$pickupData['projectId'];
                if(isset($projRes->elementId)) {
                    // set international shipping url
                    $nextStep = '/internationalshipping/'.$pickupData['projectId'].'/'.$pickupData['elementId'];
                }
                
            } else {
                // set default next url as consumption tax
                $nextStep = '/sellerconsumptiontax/'.$pickupData['projectId'];
                if(isset($projRes->elementId)) {
                    // set default next url as consumption tax
                    $nextStep = '/uploadimageinfo/'.$pickupData['projectId'].'/'.$pickupData['elementId'];
                }
            }
        }
        return $nextStep;
    }

    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to stage "3" of media uploage stage - 1
     * @access: public
     * @return: void
     * @author: lokendra
     */
     
    public function uploadfile($arg_list) {
        
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // get industry name 
        $indusrtyName  =  $arg_list['indusrty'];

        $mediaFileType = 0;
        //create first element of project
        $this->_firstmainelementcreate($arg_list);
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes =  $this->isprojectelementexists( $projectId,$elementId,$indusrtyName ); 
        } else {
            // check project id is exists or not
            $projRes = $this->isprojectexists( $projectId,$indusrtyName );
        }
       
        // get element's table name
        $elementTblPrefix = $this->config->item( $indusrtyName.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        $getValues = 'fileId';
        if($indusrtyName == 'educationMaterial') {
            $getValues = 'mediaFileType,fileId';
        }
        // get main element id if already created
        $elementData =  $this->model_common->getDataFromTabel($elementTable, $getValues,  array('elementId'=>$elementId,'projId'=>$projectId),'','','',1);
        
        //get element id
        if(!empty($elementData)) {
            $elementData    =    $elementData[0];
            $fileId         =    $elementData->fileId;
            if( !empty($fileId) && $fileId > 1 ) {
                // get media file data  if already created
                $mediaFileRes =  $this->model_common->getDataFromTabel('MediaFile', 'filePath,rawFileName,isExternal',  array('fileId'=>$fileId),'','','',1);
                if(!empty($mediaFileRes)) {
                    $this->data['filePath']   =  $mediaFileRes[0]->filePath;
                    $this->data['fileName']   =  $mediaFileRes[0]->rawFileName;
                    $this->data['isExternal'] =  $mediaFileRes[0]->isExternal;
                }
            }
            if($indusrtyName == 'educationMaterial') {
                // tosif
                $mediaFileType  =  $elementData->mediaFileType;
                
                if($mediaFileType == 0) {
                    redirect($this->redirectUrl.'uploadform/'.$projectId.'/'.$elementId);
                }
            }
        }
        //get media file types
        $fileFormateNames = $this->setfilename($indusrtyName,$projRes,$mediaFileType); 
        //create first element of project
        //$this->_firstmainelementcreate($arg_list);
        
        //call method for plupload css and js add
        $this->_pluploadjsandcss();
        
        //call method for required data for upload file
        $this->_uploadfilerequiredata($arg_list,$mediaFileType);
        
        //next page url
        $nextPageURL  = '/setdisplayimage/'.$projectId.'/'.$elementId;
        $this->data['projData']         =  $projRes; // set project data
        $this->data['innerPage']        =  'media/form/upload_n_describe_images'; // set view of stage 3
        $this->data['subInnerPage']     =  'media/form/upload_image'; // set view name of sub-menu stage 1
        $this->data['s3menu']           =  'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['uploadSubMenuS1']  =  'TabbedPanelsTabSelected'; // sub-menu selected 
        $this->data['fileId']           =  (isset($fileId))?$fileId:1; // set element file id
        $this->data['elementId']        =  (isset($elementId))?$elementId:''; // set element file id
        $this->data['fileType']         =  (isset($fileType))?$fileType:''; // set element file id
        $this->data['fileFormateNames'] = $fileFormateNames;
        $this->data['nextPage']         =  $nextPageURL; // current page url
        $this->data['indusrtyName']     =  $indusrtyName; // current page url
        if($projRes->elementType == 0) {
            $this->data['ispriceShippingCharge']   = $this->_ispriceshippingcharge($projRes); // get price shipping page is show
        }
        $arg_list['mode']               =   'edit'; // set mode of page
        
        //$this->_ispriceshippingcharge($projectId,$elementId);
        $this->loadMediaWizardView($arg_list);   
    }
    
    /*
    * @access: private
    * @description: This method is use to get project details by project id
    * @return: void
    * @auther: lokendra
    */ 
    
    private function _projectdetailsbyid($projectId,$arg_list){
        
        $projectData  = false;
        // get logged in userId
        $userId  = $this->userId;

        $whereCondition =   array('projId'=>$projectId,'tdsUid'=>$userId);
        $projectData    =   $this->model_common->getDataFromTabel('Project', '*', $whereCondition, '', '', '', 1, 0, true);
        if(!empty($projectData)) {
            $projectData    =   $projectData[0];
        }
        return $projectData ;
    } 
    
    /*
    * @access: private
    * @description: This method is use to get project element details by project id
    * @return: void
    * @auther: lokendra
    */ 
     
    private function _elementdetailsbyid($arg_list){
        
        $elementData    =   false;
        $projectId      =   $arg_list[1]; // get projrect id
        $elementId      =   $arg_list[2]; // get element id 
        $indusrtyName   =   $arg_list['indusrty']; // get industry id 
        
        // get element segment id for creating main element automatically first time method hit
        $elementIdSegment = $this->uri->segment('6');

        //get industry table and entity id details
        $indusrtyDetails     =  $this->_indusrtydetails($indusrtyName);
        
        //get element table name
        $elementEntityId     =  $indusrtyDetails['elementEntityId'];
        $elementTable        =  $indusrtyDetails['elementTable'];
        
        $this->data['elementEntityId']   =   $elementEntityId; // set element entity id
  
        // get main element id if already created
        $elementData    =   $this->model_common->getDataFromTabel($elementTable, '*',  array('projId'=>$projectId,'elementId'=>$elementId),'','','',1);

        if(!empty($elementData)){
            $elementData = $elementData[0];
        }
        
        return $elementData;
    }
    
    /*
    * @access: private
    * @description: This method is use to check price & shipping charge page show
    * @return: void
    * @auther: lokendra
    */ 
    
    private function _ispriceshippingcharge($projectDetails){
       
        $ispriceShippingCharge = 0;
        // get project details
        //$projectDetails = $this->_projectdetailsbyid($projectId);
        
        // get project price and shipping data
        $sellPriceType              =  $projectDetails->sellPriceType;
        $projSellstatus             =  $projectDetails->projSellstatus;
        $isprojPrice                =  $projectDetails->isprojPrice;  //
        $hasDownloadableFileOnly    =  $projectDetails->hasDownloadableFileOnly; //0: shippable & downloadable, 1: only downloadable
        $elementType                =  (isset($projectDetails->elementType) && $projectDetails->elementType == 1)?$projectDetails->elementType:0;
        
        // price should be one and allow shipping 
        if($sellPriceType!=1  && $hasDownloadableFileOnly == 1 && $projSellstatus == 't' && $elementType == 0){
            $ispriceShippingCharge = 1;
        } else if($hasDownloadableFileOnly == 0 && $sellPriceType == 3 && $projSellstatus == 't' && $projectDetails->isPrice == 'f' && $elementType == 0) {
            $ispriceShippingCharge = 1;
        } else if($hasDownloadableFileOnly == 0 && $sellPriceType == 1 && $projectDetails->isPrice == 't' && $projSellstatus == 't') {
            $ispriceShippingCharge = 2;
        } else if($hasDownloadableFileOnly == 0 && $sellPriceType == 3 && $projectDetails->isPrice == 't' && $projSellstatus == 't') {
            $ispriceShippingCharge = 3;
        }
        
        return $ispriceShippingCharge;
    }
    
    //-------------------------------------------------------------------------
    /*
    * @access: private
    * @description: This method is use to create main element for upload file and details
    * @return: void
    * @auther: lokendra
    */ 
    
     private  function _firstmainelementcreate($arg_list) {
   
        $projectId      =   $arg_list[1]; // get projrect id
        $getElementId   =   $arg_list[2]; // get element id
        $indusrtyName   =   $arg_list['indusrty']; // get industry id 
        
        // get element segment id for creating main element automatically first time method hit
        $elementIdSegment = $this->uri->segment('6');
        //get industry table and entity id details
        $indusrtyDetails     =  $this->_indusrtydetails($indusrtyName);
        
        $elementEntityId     =  $indusrtyDetails['elementEntityId'];
        $elementTable        =  $indusrtyDetails['elementTable'];
        // set base url
        $baseUrl = formBaseUrl();
        if(!empty($getElementId)) {
            $elementId = $getElementId;
            // get main element id if already created
            $elementData    =   $this->model_common->getDataFromTabel($elementTable, 'elementId',  array('elementId'=> $elementId,'projId'=>$projectId),'','','',1);
            
            if(empty($elementData)) {
                redirect($this->redirectUrl.'/uploadfile/'.$projectId);
            }
        } else {
            $elementPublished = 'f';
            // get main element id if already created
            $elementData    =   $this->model_common->getDataFromTabel($elementTable, 'elementId',  array('projId'=>$projectId,'elementType'=>'0'),'','','',1);
            //get element id
            if(!empty($elementData)) {
                $elementData    =    $elementData[0];
                $elementId      =    $elementData->elementId;
            } else {
                // get project publish status
                $projectResData    =   $this->model_common->getDataFromTabel('Project', 'isPublished',  array('projId'=>$projectId),'','','',1);
                // set element publish status
                if(!empty($projectResData) && $projectResData[0]->isPublished == 't') {
                    $elementPublished = 't';
                }
                // create first element 
                $elementAddData     =   array('projId'=>$projectId,'title'=>'Untitled','fileId'=>'1','mediaTypeId'=>NULL,'elementType'=>'0','isPublished'=>$elementPublished);
                $elementId          =   $this->model_common->addDataIntoTabel($elementTable, $elementAddData);
                if(!empty($elementId)) {
                    // add element record in summary log
                    addDataIntoLogSummary($elementTable,$elementId);
                    // manage log  count
                    mediaFileCount($this->entityId,$projectId,$indusrtyName);
                }
            }
        }
        
        //prepare redirect url
        $uploadFileUrl = base_url(lang().DIRECTORY_SEPARATOR.$this->redirectUrl.'uploadfile'.DIRECTORY_SEPARATOR.$projectId.DIRECTORY_SEPARATOR.$elementId);
        
        if(empty($elementIdSegment) || $getElementId!=$elementId){
            redirect($uploadFileUrl);
        }
    }     
    
     //------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to upload file require details get
    * @access: private
    * @return: void
    * @author: lokendra
    */
    
    private function _uploadfilerequiredata($arg_list,$mediaFileType=0){

        $projectId      =  $arg_list['1'];
        $elementId      =  $arg_list['2']; // get element id 
        $sectionId      =  $arg_list['sectionId'];
        $indusrtyName   =  $arg_list['indusrty'];
        
        $this->data['dirUploadMedia'] = $this->dirUploadMedia.$indusrtyName.DIRECTORY_SEPARATOR.$projectId.DIRECTORY_SEPARATOR.'file';
        //$this->data['dirUploadMedia'] = 'media/';
        
        switch ($indusrtyName)
        {
            
            case 'filmNvideo':
                $this->_setuploadfileparams(2);
                $indusrtyDetails     =  $this->_indusrtydetails($indusrtyName);
                $elementEntityId     =  $indusrtyDetails['elementEntityId'];
                
            break;
            
            case 'musicNaudio':
                $this->_setuploadfileparams(3);
                $indusrtyDetails     =  $this->_indusrtydetails($indusrtyName);
                $elementEntityId     =  $indusrtyDetails['elementEntityId'];
                
            break;
            
            case 'writingNpublishing':
                $this->_setuploadfileparams(4);
                $indusrtyDetails     =  $this->_indusrtydetails($indusrtyName);
                $elementEntityId     =  $indusrtyDetails['elementEntityId'];
                
            break;
            
            case 'photographyNart':
                $this->_setuploadfileparams(1);
                $indusrtyDetails     =  $this->_indusrtydetails($indusrtyName);
                $elementEntityId     =  $indusrtyDetails['elementEntityId'];
                
            break;
            
            case 'educationMaterial':
                $this->_setuploadfileparams($mediaFileType);
                $indusrtyDetails     =  $this->_indusrtydetails($indusrtyName);
                $elementEntityId     =  $indusrtyDetails['elementEntityId'];

            break;
            
            default:
            $mediaFileTypes      =  $this->config->item('imageAccept');
            $allowedMediaType    =  $this->config->item('imageType');
            $typeOfFile          =  '1';
            $fileMaxSize         =  $this->config->item('imageSize');
            $indusrtyDetails     =  $this->_indusrtydetails($indusrtyName);
            $elementEntityId     =  $indusrtyDetails['elementEntityId'];
        }
       
        $this->data['indusrtyName']          =  $indusrtyName; // industry name
        $this->data['projectId']             =  $projectId; // project id
        $this->data['elementId']             =  $elementId; // project id
        $this->data['elementEntityId']       =  $elementEntityId; // element id
       
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
        } elseif( $mediaFileType == 2) {
            $mediaFileTypes      =  $this->config->item('videoAccept');
            $allowedMediaType    =  $this->config->item('videoType');
            $typeOfFile          =  '2';
            $fileMaxSize         =  $this->config->item('videoSize');
        } elseif( $mediaFileType == 3 ) {
            $mediaFileTypes      =  $this->config->item('audioAccept');
            $allowedMediaType    =  $this->config->item('audioType');
            $typeOfFile          =  '3';
            $fileMaxSize         =  $this->config->item('audioSize');
        } elseif( $mediaFileType == 4 ) {
            $mediaFileTypes      =  $this->config->item('writtenMaterialAccept');
            $allowedMediaType    =  $this->config->item('writtenMaterialAccept');
            $typeOfFile          =  '4';
            $fileMaxSize         =  $this->config->item('writtenMaterialSize');
        }
        
        $this->data['mediaFileTypes']        =  $mediaFileTypes; // set media type show 
        $this->data['allowedMediaType']      =  $allowedMediaType; // allow media type
        $this->data['typeOfFile']            =  $typeOfFile; // type of file 
        $this->data['fileMaxSize']           =  $fileMaxSize; // upload max size
    }
    
    //-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to stage "3" of media uploage stage - 1
    * @access: public
    * @return: void
    * @author: lokendra
    */
     
    public function uploadfilepost(){
        
        if($this->input->is_ajax_request()) {

            $browseId           =   $this->input->post('browseId');
            $projectId          =   $this->input->post('projectId'.$browseId);
            $elementId          =   $this->input->post('elementId'.$browseId);
            $indusrtyName       =   $this->input->post('indusrtyName'.$browseId);
            
            //--------media data prepair for inserting------//
            $isFile             =   false;
            $media_fileName     =   $this->input->post('fileName'.$browseId);
            $isExternal         =   ($this->input->post('isExternal'.$browseId)=='t')?'t':'f';
            $embbededURL        =   $this->input->post('embbededURL'.$browseId);
            $isExternalFile     =   false;
            $mediaFileData=array();
            if($media_fileName && strlen($media_fileName)>3){
                $isFile              =   true;
                $fileType            =   getFileType($media_fileName);
                $isExternalFile      =   false;
                $mediaFileData       =   array(
                                        'filePath'      =>  $this->dirUploadMedia.$indusrtyName.'/'.$projectId.'/'.'file/',
                                        'fileName'      =>  $media_fileName,
                                        'fileType'      =>  $fileType,
                                        'tdsUid'        =>  $this->userId,
                                        'isExternal'    =>  'f',
                                        'fileSize'      =>  $this->input->post('fileSize'.$browseId),
                                        'rawFileName'   =>  $this->input->post('fileInput'.$browseId),
                                        'jobStsatus'    =>  'UPLOADING'
                                    );
                
            }elseif($embbededURL && strlen($embbededURL)>3){
                $isFile             =   true;
                $fileType           =   $this->input->post('fileType'.$browseId);
                $embbededURL        =   getUrl($embbededURL);
                $isExternalFile     =   true;
                $mediaFileData      =   array(
                                        'filePath'      =>  $embbededURL,
                                        'tdsUid'        =>  $userId,
                                        'fileType'      =>  $fileType,
                                        'isExternal'    =>  't',
                                        'jobStsatus'    =>  'DONE'
                                    );
                
            }
            
            if($isFile){
                
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
                
                $fileId = $this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);;
        
            }else{
                $fileId=0;
            }
            
            if($fileId > 0){
                //call element media insert method
                $this->_updateelementmedia($fileId,$browseId);
            }
            
            //next page url
            $nextUrl  = '/setdisplayimage/'.$projectId.'/'.$elementId ;
            
            $msg='Media file uploaded successfully';
            set_global_messages($msg, $type='success', $is_multiple=true);
            $returnData=array('msg'=>$msg,'fileId'=>$fileId,'nextUrl'=>$nextUrl,'isExternalFile'=>$isExternalFile);
            echo json_encode($returnData);
        }
        
    }
    
    //------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to insert media element industry wise
    * @access: private
    * @return: void
    * @author: lokendra
    */
    
    private function _updateelementmedia($fileId,$browseId){
        
        $indusrtyName       =   $this->input->post('indusrtyName'.$browseId);
        $projectId          =   $this->input->post('projectId'.$browseId);
        $elementId          =   $this->input->post('elementId'.$browseId);
        $elementEntityId    =   $this->input->post('elementEntityId'.$browseId);
        
        $tableName 	        =   getMasterTableName($elementEntityId);
        $tableName          =   $tableName[0];
        $elementUpdateData  =   array('fileId'=>$fileId);
        $this->model_common->editDataFromTabel($tableName, $elementUpdateData, array('projId'=>$projectId, 'elementId'=>$elementId));
    }
    
    //------------------------------------------------------------------------
    
    /*
    * @access: public
    * @Description: This method is use to get industry table and entity id 
    * @return: array
    * @auther: lokendra
    */ 
    
    private function _indusrtydetails($indusrtyName){
         switch ($indusrtyName)
        {
            
            case 'filmNvideo':
                $elementEntityId     =  getMasterTableRecord('FvElement');
                $elementTable        =  'FvElement';
                
            break;
            
            case 'musicNaudio':
                $elementEntityId     =  getMasterTableRecord('MaElement');
                $elementTable        =  'MaElement';
                
            break;
            
            case 'writingNpublishing':
                $elementEntityId     =  getMasterTableRecord('WpElement');
                $elementTable        =  'WpElement';
                
            break;
            
            case 'photographyNart':
     
                $elementEntityId    =  getMasterTableRecord('PaElement');
                $elementTable       =  'PaElement';
                
            break;
            
            case 'educationMaterial':
                $elementEntityId     =  getMasterTableRecord('EmElement');
                $elementTable        =  'EmElement';
                 
            break;
            
            default:
            $elementEntityId    =  getMasterTableRecord('PaElement');
            $elementTable       =  'PaElement';
        }
        
        return array('elementEntityId'=>$elementEntityId,'elementTable'=>$elementTable);
    }
    
     
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to stage "3" of media uploage stage - 2
     * @access: public
     * @return: void
     * @author: lokendra
     */
     
    public function uploadtitle($arg_list){
         
        // get project id
        $projectId = $arg_list[1];
        // get project element id
        $elementId = $arg_list[2];
        // check project id is exists or not
        $projRes =  $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] ); 
        // set category id
        $catId = (!empty($projRes->projCategory) && $projRes->projCategory != 12) ? $projRes->projCategory : '';   
        $this->data['innerPage']        =   'media/form/upload_n_describe_images'; // set view of stage 3
        $this->data['subInnerPage']     =   'media/form/upload_title_description'; // set view name of sub-menu stage 2
        $this->data['s3menu']           =   'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['uploadSubMenuS2']  =   'TabbedPanelsTabSelected'; // sub-menu selected
        $arg_list['mode']               =   'edit'; // set mode of page
        if($projRes->elementType == 0) {
            $this->data['ispriceShippingCharge']   = $this->_ispriceshippingcharge($projRes); // get price shipping page is show
        }
        $this->data['elementDetails']   =   $this->_elementdetailsbyid($arg_list); // get project element details
        $this->data['projectId']        =   $projectId; // get project element details
        $this->data['elementId']        =   $elementId; // get element id details
        $this->data['indusrtyName']     =   $arg_list['indusrty']; // set industry name
        $this->data['uploadTitle']     =   $this->lang->line('uploadTitle'.$catId); // set industry name uploadTitle
        $this->loadMediaWizardView($arg_list);
    } 
    
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save project's title n desc details
     * @access: public
     * @return void
     */ 
    public function uploadtitlepost( $arg_list ) {
        
        // get project id
        $projectId = $arg_list[1];

        // get element id
        $elementId = $arg_list[2];
        
        // check project id is exists or not
        $projRes =  $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
        // set default type
        $type = 'error';
        if($this->input->is_ajax_request()) {
            
            $elementEntityId    =  $this->input->post('elementEntityId');
            $albumTitle         =  $this->input->post('albumTitle');
            $projDescription    =  $this->input->post('projDescription');
            $projTag            =  $this->input->post('projTag');
          
            $tableName 	        =   getMasterTableName($elementEntityId);
            $tableName          =   $tableName[0];
            
            // prepare data
            $elementUpdateData = array(
                'title'         => $albumTitle,
                'description'   => $projDescription,
                'tags'           => $projDescription,
            );
            // set proj type id in element
            $projCategory = ((int)$projRes->projCategory > 0)?$projRes->projCategory:0;
            if($projCategory > 0) {
                $typeData  = $this->model_common->getDataFromTabel('MasterProjectType', 'typeId',  array('catId'=>$projCategory));
                if(isset($typeData[0]->typeId) && (count($typeData) == 1)){
                    $elementUpdateData['projType'] = $typeData[0]->typeId;
                }
            }
            // update element details
            $this->model_common->editDataFromTabel($tableName, $elementUpdateData, array('projId'=>$projectId, 'elementId'=>$elementId));
            $nextUrl = '/uploadimageinfo/'.$projectId.'/'.$elementId;
            if($projRes->elementType == 0) {
                $ispriceshippingcharge = $this->_ispriceshippingcharge($projRes);
                
                if($ispriceshippingcharge == 1 || $ispriceshippingcharge == 3) {
                    $nextUrl = '/priceshippingcharge/'.$projectId.'/'.$elementId;
                } elseif($ispriceshippingcharge == 2) {
                    $nextUrl = '/shippingcharge/'.$projectId.'/'.$elementId;
                }
            }
           
            $msg = $this->lang->line('successTitlenDesc');
            $type='success';
        } else {
            $nextUrl = '';
            $msg = $this->lang->line('errorDuringUpdation');
        }
         set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$nextUrl));
    }
     
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to stage "3" of media uploage stage - 3
     * @access: public
     * @return: void
     * @author: lokendra
     */
     
    public function priceshippingcharge($arg_list) {
        
        // get project id
        $projectId = $arg_list[1];
        $elementId = $arg_list[2];
        // check project id is exists or not
        $projRes = $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
        // if not price and shipping charge allow
        $ispriceshippingcharge = $this->_ispriceshippingcharge($projRes);
        if($ispriceshippingcharge == 0) {
            redirect($this->redirectUrl);
        }
        // get project element details
        $elementDetails = $this->_elementdetailsbyid($arg_list); 
         
        if(!empty( $elementDetails)) {
            $priceValue = $elementDetails->downloadPrice; // set default price as download
            
            if( $projRes->hasDownloadableFileOnly == 0 && $projRes->sellPriceType == 3 && $elementDetails->isPrice == 't' && $elementDetails->isDownloadPrice == 'f' ) {
                // set price value
                $priceValue = $elementDetails->price;
            } 
            // set price value
            $priceValue = (!empty($priceValue))?number_format($priceValue,2):'';
            
            // set pay per view price show option
            if($arg_list['indusrty'] == 'filmNvideo' && $elementDetails->isPrice == 'f' && $projRes->hasDownloadableFileOnly == 0) {
                $isPPV = 1;
                $this->data['perViewPrice']  =  $elementDetails->perViewPrice; // set ppv price
            }
        }
        
        // get seller currency
        $sellerCurrency = $this->config->item('currency1'); // set currency as euro
        $sellerRes = $this->model_common->getDataFromTabel('UserSellerSettings', 'seller_currency',  array('tdsUid'=>$this->userId),'','','');
        if(!empty($sellerRes)) {
            if( $sellerRes[0]->seller_currency == 0 ) {
                $sellerCurrency = $this->config->item('currency0'); // set currency as euro
            }
        }
            
        $this->data['innerPage']        =   'media/form/upload_n_describe_images'; // set view of stage 3
        $this->data['subInnerPage']     =   'media/form/upload_price_shipping'; // set view name of sub-menu stage 3
        $this->data['s3menu']           =   'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['uploadSubMenuS3']  =   'TabbedPanelsTabSelected'; // sub-menu selected
        $this->data['ispriceShippingCharge']   = $ispriceshippingcharge; // get price shipping page is show
        $this->data['elementDetails']   =   $elementDetails; // get project element details
        $this->data['projectId']        =   $projectId; // get project element details
        $this->data['sellerCurrency']   =   $sellerCurrency; // set seller currency
        $this->data['priceValue']       =   (isset($priceValue))? $priceValue:''; // get project element details
        $this->data['isPPV']            =   (isset($isPPV))? $isPPV:''; // set pay per view price option
        $this->data['elementId']        =   $elementId; // get project element details
        $this->data['indusrtyName']     =   $arg_list['indusrty']; // set industry name
        $arg_list['mode']               =   'edit'; // set mode of page
        $this->loadMediaWizardView($arg_list);
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save project's title n desc details
     * @access: public
     * @return void
     */ 
    public function priceshippingchargepost( $arg_list ) {
        
        // get project id
        $projectId = $arg_list[1];

        // get element id
        $elementId = $arg_list[2];
        // check project id is exists or not
        $elementRes = $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
        
        if($this->input->is_ajax_request()) {
            
            $elementEntityId  =  $this->input->post('elementEntityId');
            $albumPrice       =  $this->input->post('albumPrice');
          
            $tableName 	      =   getMasterTableName($elementEntityId);
            $tableName        =   $tableName[0];
            
            // set default element data
            $elementUpdateData = array( 'downloadPrice' => $albumPrice,'isDownloadPrice'=>'t','isPrice'=>'f');
                   
            if( $elementRes->hasDownloadableFileOnly == 0 && $elementRes->sellPriceType == 3 && $elementRes->isPrice == 't' && $elementRes->isDownloadPrice == 'f' ) {
                // prepare price update value
                $elementUpdateData = array( 'price' => $albumPrice);
            }  else if($arg_list['indusrty'] == 'filmNvideo' && $elementRes->isPrice == 'f') {  // set pay per view price
                $perViewPrice         =  $this->input->post('perViewPrice');
                // prepare price update value
                $elementUpdateData = array( 'downloadPrice' => $albumPrice,'perViewPrice' => $perViewPrice,'isDownloadPrice'=>'t','isPerViewPrice'=>'t','isPrice'=>'f');
            }
            
            // update element details
            $this->model_common->editDataFromTabel($tableName, $elementUpdateData, array('projId'=>$projectId, 'elementId'=>$elementId));
            
            $msg='You have successfully update project details.';
            set_global_messages($msg, $type='success', $is_multiple=true);
            
            // if not price and shipping charge allow
            $ispriceshippingcharge = $this->_ispriceshippingcharge($elementRes);
            if($ispriceshippingcharge == 2 || $ispriceshippingcharge == 3) {
                $nextUrl = '/shippingcharge/'.$projectId.'/'.$elementId;
            } else{
                $nextUrl = '/uploadimageinfo/'.$projectId.'/'.$elementId;
            }
        
        }else {
            $nextUrl = '';
        }
        echo json_encode(array('nextStep'=>$nextUrl));
    }
    
     //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to stage "3" of media uploage stage - 3
     * @access: public
     * @return: void
     */
     
    public function shippingcharge($arg_list) {
        
        // get project id
        $projectId = $arg_list[1];
        // get project id
        $elementId = $arg_list[2];
        // check project id is exists or not
        $projRes =  $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
        // if not price and shipping charge allow
        $ispriceshippingcharge = $this->_ispriceshippingcharge($projRes);
        // set back url page
        $backPage = 'setuppricing';
        if($ispriceshippingcharge == 3) {
            $backPage = 'pricing';
        }
       
        if(!empty($projRes->shippingOptions)) {
            $deliveryOptions = json_decode($projRes->shippingOptions);
            if(in_array('1',$deliveryOptions) && $arg_list[2] != 1 && $arg_list[2] != 2) {
                // manage pickup details
                $this->pickupshipping($arg_list);
            } else if(in_array('2',$deliveryOptions) && $arg_list[2] != 2) {
                // manage domestic shipping details
                $this->domesticshipping($arg_list);
            } else {
                // manage international shipping zone details
                $this->internationalshipping($arg_list);
            }
        } else {
            // set print delivery options form
            $this->data['innerPage']        =  'media/form/upload_n_describe_images'; // set view of stage 3
            $this->data['subInnerPage']     = 'media/form/shipping_delivery_options';
            //$this->data['subInnerPage']     = 'media/form/shipping_delivery_options';
            $this->data['shippingNav']      = false; 
            $this->data['backPage']         = $backPage;
            $this->data['projectId']        = $projectId;
            $this->data['elementId']        = $elementId;
            $this->data['ispriceShippingCharge']   = $ispriceshippingcharge; // get price shipping page is show
            $this->data['indusrtyName']     =   $arg_list['indusrty']; // set industry name
            $this->data['s3menu']           = 'TabbedPanelsTabSelected';
            $this->data['uploadSubMenuShipping'] = 'TabbedPanelsTabSelected';
            $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
            $this->new_version->load('new_version','form/wizard',$this->data);
        }
    }
     
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to stage "3" of media uploage stage - 3
     * @access: public
     * @return: void
     * @author: lokendra
     */
     
    public function uploadimageinfo($arg_list) {
         
        // get project id
        $projectId = $arg_list[1];
        $elementId = $arg_list[2];
    
        // check project id is exists or not
        $projRes =  $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
        
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        $this->data['entityId'] = getMasterTableRecord($elementTable);
        // get elements data of projects 
        $otherElementRes = $this->model_media->getMediaElementsGenres($projectId,$elementTable,$elementId);
        // set proj type id in element
        $projCategory = ((int)$projRes->projCategory > 0)?$projRes->projCategory:0;
        if($projCategory > 0) {
            $typeData  = $this->model_common->getDataFromTabel('MasterProjectType', 'typeId,projectTypeName',  array('catId'=>$projCategory));
            if(isset($typeData[0]->typeId) && (count($typeData) > 1)){
                $this->data['projTypes'] = $typeData;
            }
        }
        $this->data['elementData']      =  $projRes;
        $this->data['innerPage']        =  'media/form/upload_n_describe_images'; // set view of stage 3
        $this->data['subInnerPage']     =  'media/form/upload_image_information'; // set view name of sub-menu stage 3
        $this->data['s3menu']           =  'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['uploadSubMenuS4']  =  'TabbedPanelsTabSelected'; // sub-menu selected
        if($projRes->elementType == 0) {
            $this->data['ispriceShippingCharge'] = $this->_ispriceshippingcharge($projRes); // get price shipping page is show
        }
        $arg_list['mode']               = 'edit'; // set mode of page
        $this->data['sectionId']        = $arg_list['sectionId']; // set section id
        $this->data['projectId']        = $projectId; // set project id
        $this->data['industry']         = $indusrty; // set industry id
        $this->data['elementId']        = $elementId; // set project element id
        $this->data['otherElementRes']  = $otherElementRes; // set project element details
        $this->data['indusrtyName']     =   $arg_list['indusrty']; // set industry name
        $this->data['projCategory']     = (isset($projRes->projCategory))?$projRes->projCategory:0;
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/wizard',$this->data);
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save elements information
     * @access: public
     * @return void
     */ 
    public function setimageinformation() {
        // get form post data
        $postData = $this->input->post();
        if(!empty($postData) && !empty($postData['entityId']) && !empty($postData['elementId'])) {
            // prepare data
            $elementData = array(
                'projGenre'         => $postData['projGenre'],
                'projGenreFree'     => (!empty($postData['projGenreFree']))?$postData['projGenreFree']:'',
                'producedInCountry' => (!empty($postData['producedInCountry']))?$postData['producedInCountry']:0,
                'classification'    => (!empty($postData['classification']))?$postData['classification']:'',
            );
            // set realese date
            if(!empty($postData['releaseMonth']) && !empty($postData['releaseYear'])) {
                $projReleaseDate = date('Y-m-d',strtotime($postData['releaseMonth'].' '.$postData['releaseYear']));
                $elementData['projReleaseDate'] = $projReleaseDate;
            }
            // set proj type if exist
            if(isset($postData['projType']) && !empty($postData['projType'])) {
                $elementData['projType'] = $postData['projType'];
            }
            // get table name
            $elementTable = getMasterTableName($postData['entityId']);
            // update element information 
            $this->model_common->editDataFromTabel($elementTable[0], $elementData, 'elementId', $postData['elementId']);
            $nextUrl = '/uploadcreativeteam/'.$postData['projectId'].'/'.$postData['elementId'];
            // set msg and msg type
            $msg = 'You have successfully added element information.';
            $type = 'success';
        } else {
            $nextUrl = '';
             // set msg and msg type
            $msg = 'Error during element information saving.';
            $type = 'error';
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$nextUrl));
    }
     
    /*
     * @description: This function is used to copy projects element data 
     * @access: public
     * @return void
     */ 
    public function copyElementInfo() {
        // set post values
        $teamElementId  =  $this->input->post('teamElementId');
        $elementId      =  $this->input->post('elementId');
        $entityId       =  $this->input->post('entityId');
    
        $copyCount = 0;
        $type = 'error';
        $msg = $this->lang->line('errorCopyElementInfo');
        if(!empty($teamElementId) && !empty($elementId) && !empty($entityId)) {
            // get table name
            $elementTable = getMasterTableName($entityId);
            // get element's data
            $elementRes = $this->model_common->getDataFromTabel($elementTable[0], '*',  array('elementId'=>$teamElementId),'','','');
           
            if(!empty($elementRes) && count($elementRes) > 0)  {
                $elementRes = $elementRes[0];
                // prepare data
                $elementData = array(
                    'projGenre'         => $elementRes->projGenre,
                    'projGenreFree'     => $elementRes->projGenreFree,
                    'producedInCountry' => $elementRes->producedInCountry,
                    'classification'    => $elementRes->classification,
                    'projReleaseDate'   => $elementRes->projReleaseDate
                );
                // update element information 
                $this->model_common->editDataFromTabel($elementTable[0], $elementData, 'elementId', $elementId);
                $copyCount = 1;
                $type = 'success';
                $msg = $this->lang->line('successCopyElementInfo');
            }
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('countResult'=>$copyCount));
    } 
    
     //----------------------------------------------------------------------
    
     /*
     * @Description: This method is use to stage "3" of media uploage stage - 4
     * @access: public
     * @return: void
     * @author: lokendra
     */
     
    public function uploadcreativeteam($arg_list){
         
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // check project id is exists or not
        $projRes = $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        // get media element table name
        $mediaElementTbl = $elementTblPrefix.'Element';
        // get entity id
        $entityId = getMasterTableRecord($mediaElementTbl);
       
        // get elements data of creatives 
        $creativeElementRes = $this->model_media->getMediaCreativeElements($projectId,$elementTblPrefix,$elementId); 
       
        // get count of project's creative team 
        $creativesResultCount = $this->model_common->countResult('AssociativeCreatives',array('elementId' => $elementId,'entityId'  => $entityId));
        // set form parameteres
        $this->data['projData']         = $projRes;
        $this->data['creativeInvolved'] = $this->model_common->getDataFromTabel('AssociativeCreatives', '*',  array('elementId'=>$elementId,'entityId'=>$entityId,'tdsUid'=>0),'','','');
        $this->data['toadCreativeInvolved'] = $this->model_common->getDataFromTabel('AssociativeCreatives', '*',  array('elementId'=>$elementId,'entityId'=>$entityId,'tdsUid !='=>0),'','','');
        $this->data['creativeElementRes']   = $creativeElementRes;
        $this->data['elementId']         = $projectId;
        $this->data['projectElementId'] = $elementId;
        $this->data['entityId']         = $entityId;
        $this->data['indusrty']         = $indusrty;
        $this->data['creativesCount']   = $creativesResultCount;
        $this->data['indusrtyName']     =   $arg_list['indusrty']; // set industry name
        $this->data['innerPage']        =   'media/form/upload_n_describe_images'; // set view of stage 3
        $this->data['subInnerPage']     =   'media/form/upload_creative_team'; // set view name of sub-menu stage 4
        $this->data['s3menu']           =   'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['uploadSubMenuS5']  =   'TabbedPanelsTabSelected'; // sub-menu selected
        if($projRes->elementType == 0) {
            $this->data['ispriceShippingCharge'] = $this->_ispriceshippingcharge($projRes); // get price shipping page is show
        }
        $arg_list['mode']               =   'edit'; // set mode of page
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/wizard',$this->data);
        //$this->loadMediaWizardView($arg_list);
    } 
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage global pickup data
     * @access: private
     * @return void
     */ 
    private function manageGlobalPickup($pickupData) {
        // prepare shipping pickup data
        $UserPickupSettings = array(
            'pickup_country' => $pickupData['pickupCountry'],
            'pickup_state'   => $pickupData['pickupState'],
            'pickup_city'    => $pickupData['pickupCity'],
            'pickup_subrub'  => $pickupData['pickupSuberb'],
            'pickup_zip'     => $pickupData['pickupZip'],
            'pickup_requirements' => $pickupData['pickupRequirements'],
            'tdsUid'        => $userId
        );
        // get user seller global id 
        $res=$this->model_common->getDataFromTabel('UserSellerSettings', 'id',  array('tdsUid'=>$userId),'','','',1);
        if(isset($res[0]->id) && $res[0]->id > 0) {
            $this->model_common->editDataFromTabel('UserSellerSettings', $UserPickupSettings, 'id', $res[0]->id);
        } else {
            $this->model_common->addDataIntoTabel('UserSellerSettings', $UserPickupSettings);
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's domestic info
     * @access: public
     * @return void
     */ 
    public function domesticshipping($arg_list) {
        $postData = $this->input->post();
        // get user id
        $userId = $this->userId;
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes =  $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
            // set prefix
            $elementTblPrefix = $this->config->item($arg_list['indusrty'].'Prifix');
            // get media element table name
            $mediaElementTbl = $elementTblPrefix.'Element';
            $entityId = getMasterTableRecord($mediaElementTbl);
            // get domestic project data
            $statesRes = $this->model_common->getDataFromTabel('ProjectShippingDomestic', '*',  array('userId'=>$userId,'elementId'=>$elementId,'entityId'=>$entityId),'','','',1);
            // set shipping options
            $shippingOptions = $projRes->shippingOptions;
            // if not price and shipping charge allow
            $ispriceshippingcharge = $this->_ispriceshippingcharge($projRes);
        } else {
            // check project id is exists or not
            $projRes =  $this->isprojectexists( $projectId,$arg_list['indusrty'] );
            $entityId = getMasterTableRecord('Project');
            // get domestic project data
            $statesRes = $this->model_common->getDataFromTabel('ProjectShippingDomestic', '*',  array('userId'=>$userId,'elementId'=>$projectId,'entityId'=>$entityId),'','','',1);
            // set shipping options
            $shippingOptions = $projRes->printDeliveryOptions;
        }
        
        $states = '';
        $price  = 0;
        $domesticCountry = 0;
        $deliveryInformation = '';
          if(isset($statesRes[0]->id)) {
            $states = $statesRes[0]->stateId;
            $price = $statesRes[0]->price;
            $domesticId = $statesRes[0]->id;
            $domesticCountry = $statesRes[0]->countryId;
            $deliveryInformation = $statesRes[0]->deliveryInformation;
            $isAllRateSame = $statesRes[0]->isAllRateSame;
        } else {
            if(!empty($postData) && $postData['isCopy'] == 't') {
                // get users global shipping data
                $shippingdetails = $this->model_common->getDataFromTabel('ProjectShippingDomestic', 'countryId,deliveryInformation',  array('userId'=>$userId,'elementId'=>0),'','','',1);
                $domesticCountry = $shippingdetails[0]->countryId;
                $deliveryInformation = $shippingdetails[0]->deliveryInformation;
            }
            $domesticId = 0;
            $isAllRateSame = 0;
        }
        $deliveryOptions = json_decode($shippingOptions);
        // set print delivery options
        $this->data['deliveryOptions']  = $deliveryOptions;
        // prepare form data values
        $this->data['shippingNav']      = true; 
        $this->data['shippingS2Menu']   = 'TabbedPanelsTabSelected'; 
        $this->data['states']           = json_decode($states);	
        $this->data['price']            = $price;
        $this->data['projectId']        = $projectId;
        $this->data['elementId']        = $elementId;
        $this->data['pickupId']         = $pickupId;
        $this->data['domesticId']       = $domesticId;
        $this->data['isAllRateSame']    = $isAllRateSame;
        $this->data['entityId']         = $entityId;
        $this->data['domesticCountry']  = $domesticCountry;
        $this->data['deliveryInformation'] = $deliveryInformation;
        $this->data['indusrty']         = $arg_list['indusrty']; 
       
        if(!empty($shippingOptions)) {
            if(!empty($domesticId) || !empty($postData)) {
                $this->data['subInnerPage'] = 'media/form/domestic_shipping';
            } else {
                $this->data['subInnerPage'] = 'media/form/domestic_shipping_copy';
            }
        } else {
            // set print delivery options form 
            $this->data['subInnerPage'] = 'media/form/shipping_delivery_options';
            $this->data['shippingNav'] = false; 
        }
        
        if(!empty($elementId)) {
            $this->data['innerPage']        =  'media/form/upload_n_describe_images'; // set view of stage 3
            $this->data['s3menu']           = 'TabbedPanelsTabSelected';
            $this->data['uploadSubMenuShipping'] = 'TabbedPanelsTabSelected';
            $this->data['ispriceShippingCharge']   = $ispriceshippingcharge; // get price shipping page is show
        } else {
            $this->data['innerPage']        = 'media/form/setup_sales';
            $this->data['s2menu']           = 'TabbedPanelsTabSelected';
        }            
    
        $this->data['salesSetupS3Menu'] = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/wizard',$this->data);
           
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's domestic info
     * @access: public
     * @return void
     */ 
    public function domesticshippingstates($arg_list) {
        $data = $this->input->post();
        $states = '';
        $projectId = $arg_list[1];
        $elementId = $arg_list[2];
        
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes =  $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
            $projelementId = $elementId;
             // set prefix
            $elementTblPrefix = $this->config->item($arg_list['indusrty'].'Prifix');
            // get media element table name
            $mediaElementTbl = $elementTblPrefix.'Element';
            $entityId = getMasterTableRecord($mediaElementTbl);
             // if not price and shipping charge allow
            $ispriceshippingcharge = $this->_ispriceshippingcharge($projRes);
        } else {
            // check project id is exists or not
            $this->isprojectexists( $projectId,$arg_list['indusrty']);
            $projelementId = $projectId;
            $entityId = getMasterTableRecord('Project');
        }
        
        //if(!empty($data['elementId'])) {
            $statesRes = $this->model_common->getDataFromTabel('ProjectShippingDomestic', 'stateId',  array('userId'=>$this->userId,'elementId'=>$projelementId,'entityId'=>$entityId),'','','',1);
            if(isset($statesRes[0]->stateId)) {
                $states = $statesRes[0]->stateId;
            }
        //}
       
        if(!empty( $projectId) && is_numeric($projectId)) {
            // prepare form data values
            $this->data['shippingNav']      = true; 
            $this->data['shippingS2Menu']   = 'TabbedPanelsTabSelected'; 
            $this->data['states']           = (isset($states))?json_decode($states):'';	
            $this->data['price']            = $data['price'];
            $this->data['projectId']        = $projectId;
            $this->data['elementId']        = $elementId;
            $this->data['domesticId']       = $data['projDomesticId'];
            $this->data['isAllRateSame']    = $data['isAllRateSame'];
            $this->data['isSameAsGlobal']   = $data['isSameAsGlobal'];
            $this->data['entityId']         = $entityId;
            $this->data['domesticCountry']  = $data['domesticShippingcountry'];
            $this->data['deliveryInformation'] = $data['deliveryInformation'];
            $this->data['subInnerPage']     = 'media/form/domestic_state_charge';
           
            if(!empty($elementId)) {
                $this->data['innerPage']        =  'media/form/upload_n_describe_images'; // set view of stage 3
                $this->data['s3menu']           = 'TabbedPanelsTabSelected';
                $this->data['uploadSubMenuShipping'] = 'TabbedPanelsTabSelected';
                $this->data['ispriceShippingCharge']   = $ispriceshippingcharge; // get price shipping page is show
            } else {
                $this->data['innerPage']        = 'media/form/setup_sales';
                $this->data['s2menu']           = 'TabbedPanelsTabSelected';
            } 
            $this->data['salesSetupS3Menu'] = 'TabbedPanelsTabSelected';
            $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
            $this->new_version->load('new_version','form/wizard',$this->data);
            
        } else {
            redirect($this->redirectUrl);
        }    
    }
    
   //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to get domestic shipping state listing of country
     * @access: public
     * @return void
     */ 
    public function getDomesticState() {
        $data['domesticCountry'] = $this->input->post('domestic_country');
        $data['elementId']       = $this->input->post('elementId');
        $states = '';
        if(!empty($data['elementId'])) {
            $statesRes = $this->model_common->getDataFromTabel('ProjectShippingDomestic', 'stateId',  array('userId'=>$this->userId,'elementId'=>$data['elementId']),'','','',1);
            if(isset($statesRes[0]->stateId)) {
                $states = $statesRes[0]->stateId;
            }
        }
        $data['states'] = json_decode($states);	
        $this->load->view('form/domestic_state_charge',$data);	   
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to store domestic shipping data
     * @access: public
     * @return void
     */ 
    public function savedomesticshipping($arg_list) {
        $domesticStates = $this->input->post('state');
        $countryId      = $this->input->post('domesticShippingcountry');
        $checked_all    = $this->input->post('checked_all');
        $checked_all    = isset($checked_all) ? $checked_all :'' ;
        $deliveryInfo   = $this->input->post('deliveryInformation');
        $entityId       = $this->input->post('entityId');
        $projectId      = $this->input->post('projectId');
        $elementId      = $this->input->post('elementId');
        $isAllRateSame  = $this->input->post('isAllRateSame');
        $projDomesticId = $this->input->post('projDomesticId');
        $domesticStates = $this->input->post('state');
        $isSameAsGlobal = $this->input->post('isSameAsGlobal');
        $nextStep = '';
        $type = 'error';
        $msg = $this->lang->line('errorDuringUpdation');
        $projelementId = $projectId;
        if(!empty($elementId)) {
            $projelementId = $elementId;
        }
        // prepare domestic data
        $projDomesticData = array(
            'userId'              => $this->userId,
            'countryId'           => $countryId,
            'entityId'            => $entityId,
            'elementId'           => $projelementId,
            'isAllRateSame'       => $isAllRateSame,
            'deliveryInformation' => $deliveryInfo,
            'isGlobal'            => 'f'
        ); 
            
        if($isAllRateSame == 'f') {
            if(isset($domesticStates) && is_array($domesticStates) && count($domesticStates)) {
                $stateArray = array();
                foreach($domesticStates as $key=>$value) {
                    if($value!='') {
                        $stateArray[$key] = $value;
                    }
                }
                if($checked_all==true) {
                    $stateArray['checked_all'] = 1;
                }
                $states = json_encode($stateArray);
                $projDomesticData['stateId'] = $states;
            }
        } else {
            $projDomesticData['price'] = $this->input->post('price');
        }
            
        // manage domestic data store 
        if(isset($projDomesticId) && $projDomesticId > 0) {
            $this->model_common->editDataFromTabel('ProjectShippingDomestic', $projDomesticData, 'id', $projDomesticId);
        } else {
            $this->model_common->addDataIntoTabel('ProjectShippingDomestic', $projDomesticData);
        }
            
        // manage data storing in global setting
        if(isset($isSameAsGlobal) && !empty($isSameAsGlobal)) {
            $projDomesticData['entityId']  =  0;
            $projDomesticData['elementId'] =  0;
            $projDomesticData['isGlobal']  = 't';
            
            // get user seller global id 
            $res = $this->model_common->getDataFromTabel('ProjectShippingDomestic', 'id',  array('userId'=>$this->userId,'elementId'=>0),'','','',1);
            if(isset($res[0]->id) && $res[0]->id > 0) {
                $this->model_common->editDataFromTabel('ProjectShippingDomestic', $projDomesticData, 'id', $res[0]->id);
            } else {
                $this->model_common->addDataIntoTabel('ProjectShippingDomestic', $projDomesticData);
            }
        }
        $type = 'success';
        $msg = $this->lang->line('successSaveDomesticShipping');
        $postData = $this->input->post();
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes =  $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
        } else {
            // check project id is exists or not
            $projRes  = $this->isprojectexists( $projectId,$postData['indusrty'] );
        }
        
        $nextStep = $this->manageshippingnexturl($projRes,$postData,1);
        //$nextStep = '/shipping'.DIRECTORY_SEPARATOR.$elementId.'/2';
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$nextStep));
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's international shipping
     * @access: public
     * @return void
     */ 
    public function internationalshipping($arg_list) {
        // get post data
        $postData = $this->input->post();
        // get user id
        $userId = $this->userId;
        // set project id
        $projectId = $arg_list[1];
        // set element id
        $elementId = $arg_list[2];
        $ispriceshippingcharge = 0;
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes =  $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
            $projelementId = $elementId;
             // set prefix
            $elementTblPrefix = $this->config->item($arg_list['indusrty'].'Prifix');
            // get media element table name
            $mediaElementTbl = $elementTblPrefix.'Element';
             // set entity id
            $entityId = getMasterTableRecord($mediaElementTbl);
             // if not price and shipping charge allow
            $ispriceshippingcharge = $this->_ispriceshippingcharge($projRes);
        } else {
            // check project id is exists or not
            $projRes = $this->isprojectexists( $projectId,$arg_list['indusrty'] );
            $projelementId = $projectId;
            // set entity id
            $entityId = getMasterTableRecord('Project');
        }
        
        // unset check value
        $this->session->unset_userdata('isGlobalCheck');
       
        $spId = 0;
        if(!empty($postData) && $postData['isCopy'] == 't') {
            // get global shipping zone data
            $globalZoneRes = $this->model_common->getDataFromTabel('ProjectShipping', '*',  array('userId'=>$userId,'isGlobal'=>'t'),'','zoneId','',1);
        
            if(isset($globalZoneRes[0]->spId)) {
                // save project data same as global zone
                $spId = $this->savezoneasglobal($globalZoneRes[0],$projectId,$entityId,$elementId);
            } 
            if(isset($spId) && !empty($spId)) {
                redirect($this->redirectUrl.'addshippingzone/'.$projectId.'/'.$spId.'/'.$elementId);
            }
        }
        
        if($spId == 0) {
            // manage shipping form or listing
            $this->manageshippingform($userId,$projectId,$entityId,$projRes,$postData,$elementId,$ispriceshippingcharge);
        }
           
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save international shipping same as global
     * @access: private
     * @return void
     */ 
    private function savezoneasglobal($globalZoneRes,$projectId=0,$entityId=0,$elementId=0) {
        $projElementId = $projectId;
        if(!empty($elementId) && $elementId > 0) {
            $projElementId = $elementId;
        }
        // prepare zone data for storing
        $shippingData = array(
                    'countriesId' => $globalZoneRes->countriesId,
                    'userId'      => $globalZoneRes->userId,
                    'zoneTitle'   => $globalZoneRes->zoneTitle,
                    'amount'      => $globalZoneRes->amount,
                    'shortDesc'   => $globalZoneRes->shortDesc,
                    'entityId'    => $entityId,
                    'elementId'   => $projElementId,
            );
        // add zone data in shipping
        $spId = $this->model_common->addDataIntoTabel('ProjectShipping', $shippingData);
        return $spId;
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage shipping zone forms
     * @access: private
     * @return void
     */ 
    private function manageshippingform($userId,$projectId=0,$entityId=0,$projRes,$postData='',$elementId=0,$ispriceshippingcharge=0) {
        $projelementId = $projectId;
        
        // set shipping options
        $shippingOptions = $projRes->printDeliveryOptions;
       
        if(!empty($elementId)) {
            // set shipping options
            $shippingOptions = $projRes->shippingOptions;
            $projelementId = $elementId;
        }
        // get domestic project data
        $projsShipRes = $this->model_common->getDataFromTabel('ProjectShipping', '*',  array('userId'=>$userId,'elementId'=>$projelementId),'','','',1);
        if(isset($projsShipRes->spId)) {
            $spId = $projsShipRes->spId;
        } else {
            $spId = 0;
        }
       
        $this->data['innerPage'] = 'media/form/setup_sales';
        
         if(!empty( $shippingOptions )) {
            // get project's international records
            $interationalShipping = $this->model_media->globalShippingList($this->userId,$projectId);
            if(!empty($interationalShipping) || !empty($postData)) {
                $this->data['interationalShipping'] = $interationalShipping;
                $this->data['subInnerPage'] = 'media/form/international_shipping_listing';
            } else {
                $this->data['subInnerPage'] = 'media/form/international_shipping_copy';
            }
        } else {
            // set print delivery options form 
            $this->data['subInnerPage'] = 'media/form/shipping_delivery_options';
            $this->data['shippingNav'] = false; 
        }
        $deliveryOptions = json_decode($shippingOptions);
        // set print delivery options
        $this->data['deliveryOptions']  = $deliveryOptions;
        // prepare form data values
        $this->data['shippingNav']      = true; 
        $this->data['shippingS3Menu']   = 'TabbedPanelsTabSelected'; 
        $this->data['projectId']        = $projectId;
        $this->data['elementId']        = $elementId;
        if(!empty($elementId)) {
            $this->data['innerPage']        =  'media/form/upload_n_describe_images'; // set view of stage 3
            $this->data['s3menu']           = 'TabbedPanelsTabSelected';
            $this->data['uploadSubMenuShipping'] = 'TabbedPanelsTabSelected';
            $this->data['ispriceShippingCharge']   = $ispriceshippingcharge; // get price shipping page is show
        } else {
            $this->data['innerPage']        = 'media/form/setup_sales';
            $this->data['s2menu']           = 'TabbedPanelsTabSelected';
        } 
        $this->data['entityId']         = $entityId;
        $this->data['salesSetupS3Menu'] = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/wizard',$this->data);
    
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save international shipping zone data
     * @access: public
     * @return void
     */ 
    public function addshippingzone($arg_list ) {
        // set project id
        $projectId = $arg_list[1];
        // set element id
        $elementId = $arg_list[3];
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes =  $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
             // set prefix
            $elementTblPrefix = $this->config->item($arg_list['indusrty'].'Prifix');
            // get media element table name
            $mediaElementTbl = $elementTblPrefix.'Element';
            // set entity id
            $entityId = getMasterTableRecord($mediaElementTbl);
            // if not price and shipping charge allow
            $ispriceshippingcharge = $this->_ispriceshippingcharge($projRes);
            $projElementId = $elementId;
        } else {
            // check project id is exists or not
            $projRes = $this->isprojectexists( $projectId,$arg_list['indusrty']);
            // set entity id
            $entityId = getMasterTableRecord('Project');
            $projElementId = $projectId;
        }
       
        $spId = $arg_list[2]?$arg_list[2]:0;
        $interationalShipping = false;
        if(is_numeric($spId) &&  $spId > 0){
            $interationalShipping = $this->model_media->globalShippingList($this->userId,0,$spId,$entityId);
            $interationalShipping = isset($interationalShipping[0])?$interationalShipping[0]:false;
        } else {
            // get project's international records
            $projshippingData = $this->model_media->globalShippingList($this->userId,$projElementId,$entityId);
            if(count($projshippingData) == 0) {
                $isFistZone = 1;
            }
        }
        if(!$interationalShipping) {
            if($isFistZone) {
                $lastZoneId = 1;
            } else {
                $lastZoneId = $this->model_common->getMax('ProjectShipping','zoneId',array('userId'=>$this->userId,'isGlobal'=>'f'));
                $lastZoneId = (isset($lastZoneId[0]->zoneid) && !empty($lastZoneId[0]->zoneid))?($lastZoneId[0]->zoneid + 1):1;
            }
            $this->data['zoneTitle'] = 'Zone '.$lastZoneId;
        } 
     
        // prepare form data values
        $this->data['shippingNav']      = true; 
        $this->data['shippingS3Menu']   = 'TabbedPanelsTabSelected'; 
        $this->data['isFistZone']       = $isFistZone;
        $this->data['interationalShipping'] = $interationalShipping;
        $this->data['conitnentCountryList'] = $this->model_media->globalShippingCountryList($this->userId,0,$spId);
        $this->data['conitnentZoneCountryList'] = $this->model_media->globalShippingZoneCountryList($this->userId,$arg_list[1],$spId);
        $this->data['projectId']        = $arg_list[1]; 
        $this->data['elementId']        = $elementId; 
        $this->data['spId']             = $spId; 
        $this->data['deliveryOptions']  = json_decode($projRes->printDeliveryOptions);  // set print delivery options
        $this->data['entityId']         = $entityId;
        $this->data['salesSetupS3Menu'] = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        if(!empty($elementId)) {
            $this->data['innerPage']        =  'media/form/upload_n_describe_images'; // set view of stage 3
            $this->data['s3menu']           = 'TabbedPanelsTabSelected';
            $this->data['uploadSubMenuShipping'] = 'TabbedPanelsTabSelected';
            $this->data['ispriceShippingCharge']   = $ispriceshippingcharge; // get price shipping page is show
        } else {
            $this->data['innerPage']        = 'media/form/setup_sales';
            $this->data['s2menu']           = 'TabbedPanelsTabSelected';
        } 
        $this->data['subInnerPage']     = 'media/form/international_shipping_form';
        $this->new_version->load('new_version','form/wizard',$this->data);
            
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save international shipping zone data
     * @access: public
     * @return void
     */ 
    public function saveshippingzone($arg_list) {
        // get zone form's post data
        $zoneData = $this->input->post();
        if(!empty($zoneData)) {
            // prepare data for insertion
            $spId =  $zoneData['spId'];
            $countriesId = $zoneData['countriesId'];
            $entityId = $zoneData['entityId'];
            $projectId = $zoneData['projectId'];
            $elementId = $zoneData['elementId'];
            $projelementId =  $projectId;
            if(!empty($elementId)) {
                $projelementId =  $elementId;
            }
           
            $shippingData = array(
                    'countriesId' => $countriesId,
                    'userId'      => $this->userId,
                    'isGlobal'    => 'f',
                    'entityId'    => $entityId,
                    'elementId'   => $projelementId ,
            );
            
            if($spId > 0) {
                $shippingData['modifyDate'] = currntDateTime();
                $this->model_common->editDataFromTabel('ProjectShipping', $shippingData, 'spId', $spId);
            } else {
                $lastZoneId = $this->model_common->getMax('ProjectShipping','zoneId',array('userId'=>$this->userId,'isGlobal'=>'f','elementId'=> $elementId));
                $lastZoneId = (isset($lastZoneId[0]->zoneid) && !empty($lastZoneId[0]->zoneid))?($lastZoneId[0]->zoneid + 1):1;
                $shippingData['zoneId'] = $lastZoneId;
                $shippingData['zoneTitle'] = 'Zone '.$lastZoneId;
                $shippingData['crreatedDate'] = currntDateTime();
                $spId = $this->model_common->addDataIntoTabel('ProjectShipping', $shippingData);
            }
            
            if(!empty($spId)) {
                // add data in global settings if global option exists
                if(!empty($zoneData['isSameAsGlobal'])) {
                    // manage data saving in global setting
                    $this->saveglobalshipping($shippingData,$spId,1); // 1 : for zone detail type
                    // set global check in session
                    $this->session->set_userdata('isGlobalCheck',1);
                }
                redirect($this->redirectUrl.'addshippingzoneprice/'.$projectId.'/'.$spId.'/'.$elementId);
            } else {
                redirect($this->redirectUrl.'internationalshipping/'.$projectId.'/'.$elementId);
            }
        } else {
           redirect($this->redirectUrl.'internationalshipping/'.$arg_list[1].'/'.$arg_list[2]);
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save international shipping zone data
     * @access: public
     * @return void
     */ 
    public function addshippingzoneprice( $arg_list ) {
        $projectId = $arg_list[1];
        $spId = $arg_list[2];
        // set element id
        $elementId = $arg_list[3];
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes =  $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
             // set prefix
            $elementTblPrefix = $this->config->item($arg_list['indusrty'].'Prifix');
            // get media element table name
            $mediaElementTbl = $elementTblPrefix.'Element';
            // set entity id
            $entityId = getMasterTableRecord($mediaElementTbl);
            // if not price and shipping charge allow
            $ispriceshippingcharge = $this->_ispriceshippingcharge($projRes);
            $projElementId = $elementId;
            $shippingOptions = $projRes->shippingOptions;
        } else {
            // check project id is exists or not
            $projRes = $this->isprojectexists( $projectId,$arg_list['indusrty']);
            // set entity id
            $entityId = getMasterTableRecord('Project');
            $projElementId = $projectId;
            $shippingOptions = $projRes->printDeliveryOptions;
        }
       
        $interationalShipping = false;
       
        if(is_numeric($spId) &&  $spId > 0) {
            $interationalShipping = $this->model_media->globalShippingList($this->userId,$projElementId,$spId,$entityId);
            $interationalShipping = isset($interationalShipping[0])?$interationalShipping[0]:false;
        }
       
        if($interationalShipping) {
            // prepare form data values
            $this->data['shippingNav']          = true; 
            $this->data['shippingS3Menu']       = 'TabbedPanelsTabSelected'; 
            $this->data['interationalShipping'] = $interationalShipping;
            $this->data['conitnentCountryList'] = $this->model_media->globalShippingCountryList($this->userId,$elementId,$spId);
            $this->data['spId']                 = $spId;
            $this->data['projectId']            = $projectId;
            $this->data['elementId']            = $elementId;
            $this->data['entityId']             = $entityId;
            $this->data['zoneId']               = $interationalShipping['zoneId'];
            $this->data['zoneTitle']            = $interationalShipping['zoneTitle'];
            $this->data['amount']               = $interationalShipping['amount'];
            $this->data['countriesId']          = $interationalShipping['countriesId'];
            $this->data['shortDesc']            = $interationalShipping['shortDesc']; 
            $this->data['isGlobal']             = $interationalShipping['isGlobal'];
            $this->data['deliveryOptions']      = json_decode($shippingOptions);  // set print delivery options
            $this->data['salesSetupS3Menu']     = 'TabbedPanelsTabSelected';
            $this->data['packagestageheading']  = $this->lang->line('createYourMediaShowcase');
            if(!empty($elementId)) {
                $this->data['innerPage']        =  'media/form/upload_n_describe_images'; // set view of stage 3
                $this->data['s3menu']           = 'TabbedPanelsTabSelected';
                $this->data['uploadSubMenuShipping'] = 'TabbedPanelsTabSelected';
                $this->data['ispriceShippingCharge']   = $ispriceshippingcharge; // get price shipping page is show
            } else {
                $this->data['innerPage']        = 'media/form/setup_sales';
                $this->data['s2menu']           = 'TabbedPanelsTabSelected';
            } 
            $this->data['subInnerPage']         = 'media/form/international_shipping_price_form';
            $this->new_version->load('new_version','form/wizard',$this->data);
        } else {
            redirect($this->redirectUrl.'internationalshipping/'.$elementId);
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save international shipping zone data
     * @access: public
     * @return void
     */ 
    public function saveshippingzoneprice($arg_list) {
        // set post values
        $spId      = $this->input->post('spId');
        $amount    = $this->input->post('amount');
        $shortDesc = $this->input->post('shortDesc');
        $isSameAsGlobal = $this->input->post('isSameAsGlobal');
        $projectId = $arg_list[1];
        $elementId = $arg_list[2];
        // check project id is exists or not
        $this->isprojectexists( $projectId );
        $shippingData = array(
                'amount'    => $amount,
                'shortDesc' => $shortDesc,
                'modifyDate'=> currntDateTime()
        );
        
        if(is_numeric($spId) && $spId > 0) {
            // update zone price & desc information
            $this->model_common->editDataFromTabel('ProjectShipping', $shippingData, array('spId'=>$spId, 'userId'=>$this->userId));
            // add data in global settings if global option exists
            if(!empty($isSameAsGlobal)) {
                // manage data saving in global setting
                $this->saveglobalshipping($shippingData,$spId,2); // 2 : for zone price detail type
            }
            //$nextStep = '/internationalshipping'.DIRECTORY_SEPARATOR.$elementId;
        }
        $nextStep = '/sellerconsumptiontax/'.$projectId;
        if(!empty($elementId)) {
            $nextStep = '/uploadimageinfo/'.$projectId.DIRECTORY_SEPARATOR.$elementId;
        }
        
        echo json_encode(array('nextStep'=>$nextStep));
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save international shipping as global data
     * @access: private
     * @return void
     */ 
    private function saveglobalshipping($shippingData,$spId,$zoneType) {
       
        // get user's shipping zone data if exists
        $shippingRes = $this->model_common->getDataFromTabel('ProjectShipping', 'zoneId',  array('spId'=>$spId),'','','',1);
        if(isset($shippingRes[0]->zoneId) && !empty($shippingRes[0]->zoneId)) {
            if($zoneType == 1) {
                // prepare data for global shipping
                $shippingData['isGlobal']  = 't';
                $shippingData['entityId']  =  0;
                $shippingData['elementId'] =  0;
                $shippingData['zoneId']    =  $shippingRes[0]->zoneId;
            }
           
            // get user seller global shipping id 
            $res = $this->model_common->getDataFromTabel('ProjectShipping', 'spId',  array('userId'=>$this->userId,'isGlobal'=>'t','zoneId'=>$shippingRes[0]->zoneId),'','','',1);
            if(isset($res[0]->spId) && $res[0]->spId > 0) {
                $this->model_common->editDataFromTabel('ProjectShipping', $shippingData, 'spId', $res[0]->spId);
            } else {
                $this->model_common->addDataIntoTabel('ProjectShipping', $shippingData);
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage consumption tax 
     * @access: public
     * @return void
     */ 
    public function sellerconsumptiontax( $arg_list ) {
        $userId = $this->userId;
        // set project id
        $projectId = $arg_list[1];
        // check project id is exists or not
        $projRes = $this->isprojectexists( $projectId,$arg_list['indusrty'] );
        // set back url page
        $backPage = '';
        if($projRes->hasDownloadableFileOnly == 0) {
            $backPage = 'shipping';
        }
        // prepare form data values
        $this->data['sellerNav']      = true; 
        $this->data['sellerS1Menu']   = 'TabbedPanelsTabSelected'; 
        $this->data['countryList'] = getCountryList();
        $this->data['euCountiesList'] = euCountiesList();
        $this->data['countiesNotInEU'] = countiesNotInEU();
        $this->data['ConsumptionTax'] = $this->model_dashboard->ConsumptionTax(array('userId'=>$this->userId,'isDeleted'=>'f'));
        $this->data['userId'] = $userId;
        $userProfileData = $this->model_dashboard->getUserProfileData($userId);
        $this->data['userProfileData']=isset($userProfileData[0])?$userProfileData[0]:false;
        $this->data['socialMediaData'] = $this->model_dashboard->getSocialMediaData($userId);			
        $this->data['shippingdetails']=$this->model_common->getDataFromTabel('ProjectShippingDomestic', '*',  array('userId'=>$this->userId),'','','',1);		
        $this->data['elementId']            = $projectId; 
        $this->data['entityId']             = getMasterTableRecord('Project'); 
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['salesSetupS4Menu']     = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading']  = $this->lang->line('createYourMediaShowcase');
        $this->data['innerPage']            = 'media/form/setup_sales';
        $this->data['subInnerPage']         = 'media/form/seller_setting';
        $this->new_version->load('new_version','form/wizard',$this->data);
    }
    
   //-----------------------------------------------------------------------
    
    /*
     * @description: manage consumption tax data
     * @access public
     */	
    public function saveConsumptionTax($arg_list) {
        $data = $this->input->post(); 
        $userSellerData = $this->model_common->getDataFromTabel('UserSellerSettings', 'id',  array('tdsUid'=>$this->userId),'','','',1);
        
        if($this->input->post('consumptionCharge')=='consumptionCharge') { 
            /* manage consumption charge data store */
            $this->manageConsumptionCharge($userSellerData);
            
        } else if($this->input->post('consumptionStateTax')=='consumptionStateTax') {
            /* manage states consumption tax data store */
            $this->manageConsumptionStateTax($userSellerData);
                
        } else {
            $UserSellerSettings = array('identificationNumber' => $this->input->post('identificationNumber'),'chargeConsumptionTax'=>'f');
            if(isset($userSellerData[0]->id) && $userSellerData[0]->id > 0){
                $this->model_common->editDataFromTabel('UserSellerSettings', $UserSellerSettings, 'id', $userSellerData[0]->id);
            }else{
                $this->model_common->addDataIntoTabel('UserSellerSettings', $UserSellerSettings);
            }
        }
        $msg = $this->lang->line('updatedSellerSettings');
        set_global_messages($msg, $type='success', $is_multiple=true);
        // set base url
        $baseUrl = formBaseUrl();
        $consumptionCharge = $this->input->post('consumptionCharge');
        $consumptionStateTax = $this->input->post('consumptionStateTax');
        if(!empty($consumptionCharge) || !empty($consumptionStateTax)) {
            echo json_encode(array('nextStep'=> '/sellerpaypal/'.$arg_list[1]));
        } else {
            redirect($this->redirectUrl.'sellerpaypal/'.$arg_list[1]);
        }

        //echo json_encode(array('nextStep'=> $nextStep));
    }

    //-----------------------------------------------------------------------
    
    /*
     * @description: Manage consumption charge 
     * @access private
     */
    private function manageConsumptionCharge($userSellerData) {
        /* set  territory id */
        $territory = $this->input->post('territory');
        $territoryCountryId = $this->input->post('territoryCountryId');
        $taxName = $this->input->post('allStateTaxName');
        $taxPercentage = $this->input->post('allStateTaxPercentage');
        $StateWise = $this->input->post('states');
        if(!empty($taxName) && !empty($taxPercentage)) {
            if(is_array($StateWise) && count($StateWise) > 0 && $territory==0){
                
                foreach($StateWise as $id){
                    $countryId=($territory==0)?$territoryCountryId:$id;
                    $stateId=($territory==0)?$id:0;
                    $ConsumptionTax[] = array(
                        'userId'=>$this->userId,
                        'countryId'=>$countryId,
                        'stateId'=>$stateId,
                        'taxName'=>$taxName,
                        'taxPercentage'=>$taxPercentage,
                        'lastModifyDate'=>currntDateTime()
                  );
                }
                
                $this->model_common->editDataFromTabel('ConsumptionTax', array('isDeleted'=>'t'), array('userId'=>$this->userId));
                $this->model_common->insertBatch('ConsumptionTax', $ConsumptionTax);
            } else if($territory==1) {
                /* get eu countries */
                $euCountiesList = euCountiesList();
                
                foreach($euCountiesList as $id=>$key){
                    $ConsumptionTax[]=array(
                                            'userId'=>$this->userId,
                                            'countryId'=>$id,
                                            'stateId'=>0,
                                            'taxName'=>$taxName,
                                            'taxPercentage'=>$taxPercentage,
                                            'lastModifyDate'=>currntDateTime()
                                          );
                }
                    $this->model_common->editDataFromTabel('ConsumptionTax', array('isDeleted'=>'t'), array('userId'=>$this->userId));
                    $this->model_common->insertBatch('ConsumptionTax', $ConsumptionTax);
            
            } else {
                $msg = 'Please select State, Provence, Region of country!';
                set_global_messages($msg, $type='error', $is_multiple=true);
                redirect($this->redirectUrl);
            }
        } else {
            $msg = 'Please fill Tax name and pecentage details!';
            set_global_messages($msg, $type='error', $is_multiple=true);
            redirect($this->redirectUrl);
            
        }
        
        /* update user seller territory data */
        $UserSellerSettings = array('territory' => $territory,'territoryCountryId' => $this->input->post('territoryCountryId'),'isTaxSameForAllStats'=>'t','chargeConsumptionTax'=>'t');
        if(isset($userSellerData[0]->id) && $userSellerData[0]->id > 0){				
            $this->model_common->editDataFromTabel('UserSellerSettings', $UserSellerSettings, 'id', $userSellerData[0]->id);
        } else {
            $this->model_common->addDataIntoTabel('UserSellerSettings', $UserSellerSettings);
        }
    }

   //-----------------------------------------------------------------------
    
    /*
     * @description: Manage consumption state tax charges 
     * @access private
     */
    private function manageConsumptionStateTax($userSellerData) {
        $StateWise = $this->input->post('StateWise');
        if(is_array($StateWise) && count($StateWise) > 0){
            
            foreach($StateWise as $id) {
                $countryId = $this->input->post('stateCountryId');
                $stateId = $id;
                $taxName = $this->input->post('StateWiseTaxName'.$id);
                $taxPercentage = $this->input->post('StateWiseTaxPercentage'.$id);
                if(!empty($taxName) && !empty($taxPercentage)) {
                    $ConsumptionTax[] = array(
                            'userId'=>$this->userId,
                            'countryId'=>$countryId,
                            'stateId'=>$stateId,
                            'taxName'=>$taxName,
                            'taxPercentage'=>$taxPercentage,
                            'lastModifyDate'=>currntDateTime()
                    );
                }
            }
            if(is_array($ConsumptionTax)) {
                $this->model_common->editDataFromTabel('ConsumptionTax', array('isDeleted'=>'t'), array('userId'=>$this->userId));
                $this->model_common->insertBatch('ConsumptionTax', $ConsumptionTax);
            } else {
                $msg = 'Please fill Tax name and pecentage details!';
                set_global_messages($msg, $type='error', $is_multiple=true);
                redirect(site_url().'dashboard/globalsettings/4');
            }
            /* update user seller territory data */
            $UserSellerSettings = array('territoryCountryId' => $this->input->post('stateCountryId'),'isTaxSameForAllStats'=>'f','chargeConsumptionTax'=>'t');
            if(isset($userSellerData[0]->id) && $userSellerData[0]->id > 0){				
                $this->model_common->editDataFromTabel('UserSellerSettings', $UserSellerSettings, 'id', $userSellerData[0]->id);
            }else{
                $this->model_common->addDataIntoTabel('UserSellerSettings', $UserSellerSettings);
            }
        }
    }

   //-----------------------------------------------------------------------
    
    /*
     * @description: set consumption tax charge form
     * @access public
     */
    public function consumptionStateTaxHtml() {
        $stateArray = $this->input->post('stateList');
        $stateHtml = '<ul class="fs13 width100_per overview slect_coustom slect_menu defaultP" >';
         
        if(is_array($stateArray)) {
            for($i=0;$i<count($stateArray);$i++) {
                $stateData = $this->model_common->getDataFromTabel('MasterStates', 'stateName',  array('stateId'=>$stateArray[$i]),'','','',1);
                $taxStateData = $this->model_common->getDataFromTabel('ConsumptionTax', 'taxName,taxPercentage',  array('stateId'=>$stateArray[$i],'isDeleted'=>'f','userId'=>$this->userId),'','','',1);
                $taxName = '';
                $taxPercentage = '';
                $checked = '';
                if(!empty($taxStateData) && is_array($taxStateData)) {
                    $taxName = $taxStateData[0]->taxName;
                    $taxPercentage = $taxStateData[0]->taxPercentage;
                    $checked = 'checked';
                }
                /* prepare state states html */
                $stateHtml .= '
                <li id="StateWiseTaxLI'.$stateArray[$i].'" class="StateWiseTaxLI">
                    <label>
                        <input '.$checked.' type="checkbox" name="StateWise[]" onclick="disbaleEnableRow(this, '.$stateArray[$i].');" id="checkboxStates'.$stateArray[$i].'" class="checkboxStatesTax ez-hide" value="'.$stateArray[$i].'" />
                        <span>
                        '.$stateData[0]->stateName.'
                      </span>
                    </label>
                    
                    <input type="text" value="'.$taxName.'" class="font_wN mr15 width_175" name="StateWiseTaxName'.$stateArray[$i].'" id="StateWiseTaxName'.$stateArray[$i].'" />
                    
                    <input type="text" value="'.$taxPercentage.'" class="font_wN  width_65" name="StateWiseTaxPercentage'.$stateArray[$i].'" id="StateWiseTaxPercentage'.$stateArray[$i].'" />
                    % 
                </li>';
            }
        }
        $stateHtml .= '</ul>';
        /* add default checkbox script */
        $stateHtml .= '<script type="text/javascript">runTimeCheckBox(); $("#slider7").tinycarousel({ axis: "y", display: 1});	</script>';
        echo $stateHtml;
    }

   //-----------------------------------------------------------------------
    
    /*
     * @description: get state list for seller setting
     * @access public
     */
    public function getConsumptionStatesList() {
        $countryId=$this->input->post('val1');
        $data['ConsumptionTax']=$this->input->post('val2');
        $data['statesList']=getStatesList($countryId);
        $this->load->view('media/form/consumption_states_list',$data);
    } 
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: get state list for seller setting
     * @access public
     */
    public function euCountiesTaxPercentage() {
        $data['euCountiesList']=$this->input->post('val1');
        $data['ConsumptionTax']=$this->input->post('val2');
        $data['territory']=$this->input->post('val3');
        $this->load->view('media/form/euCountiesTaxPercentage',$data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage paypal seller setting
     * @access: public
     * @return void
     */ 
    public function sellerpaypal( $arg_list ) {
        $userId = $this->userId;
        // set project id
        $projectId = $arg_list[1];
        // check project id is exists or not
        $this->isprojectexists( $projectId,$arg_list['indusrty'] );
    
        // prepare form data values
        $this->data['sellerNav']      = true; 
        $this->data['sellerS2Menu']   = 'TabbedPanelsTabSelected'; 
        $this->data['userId'] = $userId;
        $userProfileData = $this->model_dashboard->getUserProfileData($userId);
        $this->data['userProfileData'] = isset($userProfileData[0])?$userProfileData[0]:false;
        $this->data['elementId']            = $projectId; 
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['salesSetupS4Menu']     = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading']  = $this->lang->line('createYourMediaShowcase');
        $this->data['innerPage']            = 'media/form/setup_sales';
        $this->data['subInnerPage']         = 'media/form/seller_paypal_setting';
        $this->new_version->load('new_version','form/wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage paypal seller address setting
     * @access: public
     * @return void
     */ 
    public function sellersetting( $arg_list ) {
        $userId = $this->userId;
        // set project id
        $projectId = $arg_list[1];
        // check project id is exists or not
        $this->isprojectexists( $projectId,$arg_list['indusrty'] );
        // get user's profile record
        $userProfileData = $this->model_dashboard->getUserProfileData($userId);
        // prepare form data values
        $this->data['sellerNav']            = true; 
        $this->data['sellerS3Menu']         = 'TabbedPanelsTabSelected'; 
        $this->data['userId']               = $userId;
        $this->data['userProfileData']      = isset($userProfileData[0])?$userProfileData[0]:false;
        $this->data['elementId']            = $projectId; 
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['salesSetupS4Menu']     = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading']  = $this->lang->line('createYourMediaShowcase');
        $this->data['innerPage']            = 'media/form/setup_sales';
        $this->data['subInnerPage']         = 'media/form/seller_address_setting';
        $this->new_version->load('new_version','form/wizard',$this->data);
          
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage shipping print delivery option
     * @access: public
     * @return void
     */ 
    public function setprintdeliveryoptions( $arg_list ) {
        // get post form data
        $data = $this->input->post(); 
        // set project id as element id
        $projId = $data['projectId'];
        // set project element id as element id
        $elementId = $data['elementId'];
        if(!empty($projId)) {
            $nextUrl = '';
            $deliveryOptions = array();
            if(!empty($data['isPickup'])) {
                $deliveryOptions[] = 1;
            }
            if(!empty($data['isDomesticShipping'])) {
                $deliveryOptions[] = 2;
            }
            if(!empty($data['isInternationalShipping'])) {
                $deliveryOptions[] = 3;
            }
            if(count($deliveryOptions) > 0) {
                $printDeliveryOptions = json_encode($deliveryOptions);
                if(!empty($elementId)) {
                    // set prefix
                    $elementTblPrefix = $this->config->item($arg_list['indusrty'].'Prifix');
                    // get media element table name
                    $mediaElementTbl = $elementTblPrefix.'Element';
                    // update print options in project
                    $this->model_common->editDataFromTabel($mediaElementTbl, array('shippingOptions'=>$printDeliveryOptions), 'elementId', $elementId);
                    $nextUrl = '/shippingcharge/'.$projId.'/'.$elementId;
                } else {
                    // update print options in project
                    $this->model_common->editDataFromTabel('Project', array('printDeliveryOptions'=>$printDeliveryOptions), 'projId', $projId); 
                    $nextUrl = '/shipping/'.$projId;
                }
            }
           
            echo json_encode(array('optionCount'=>count($deliveryOptions),'nextStep'=>$nextUrl));
        } else {
           echo json_encode(array('optionCount'=>0,'nextStep'=>''));
        } 
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to check project exists or not
     * @access: private
     * @return void
     */ 
    private function isprojectexists( $projectId , $industry = '') {
        
        $msg = 'Check your project values.'; // set default project error msg
        if(!empty($projectId) && is_numeric($projectId)) {
            // where conditions
            $where = array('projId'=>$projectId,'tdsUid'=>$this->userId,'isArchive'=>'f');
            if(!empty($industry)) {
                $where['projectType'] = $industry;
                $this->data['industry']  = $industry;
            }
           
            // get user's project data if exists
            $projRes = $this->model_common->getDataFromTabel('Project', '*',  $where,'','','',1);
            if(isset($projRes[0]->projId) && $projRes[0]->projId > 0)  {
                // set download options value
                $this->data['hasDownloadableFileOnly']  = $projRes[0]->hasDownloadableFileOnly;
                if($projRes[0]->hasDownloadableFileOnly == 0 || $industry == 'educationMaterial') {
                    // set media form availability
                    $this->data['isMediaForm']  = 1;
                }
                return $projRes[0];
             } else {
                set_global_messages($msg, $type='error', $is_multiple=true);
                redirect($this->redirectUrl);
            }
        } else {
            set_global_messages($msg, $type='error', $is_multiple=true);
            redirect($this->redirectUrl);
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project album cover
     * @access: public
     * @return void
     */ 
    public function selectcoverimage( $arg_list ) {
        // get project id
        $projectId = $arg_list[1];
        // check project id is exists or not
        $projRes =  $this->isprojectexists( $projectId ,$arg_list['indusrty']);
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // set prefix
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
       
        if(empty($elementTblPrefix)) {
            redirect($this->redirectUrl);
        }
    
        // set print delivery options form 
        $this->data['projectId']   = $projectId;
      
        // get media element table name
        $mediaElementTbl = $elementTblPrefix.'Element';
        $projElements  = $this->model_media->getPojectElementsNmedia($projectId,$mediaElementTbl);
          
        if(is_array($projElements) && count($projElements) > 0) {
            $this->data['projElements'] = $projElements;
        }
        
        $this->data['entityId']         = getMasterTableRecord($mediaElementTbl);
        $this->data['industry']         = $indusrty;
        $this->data['coverTitle']       = $this->lang->line('selectCoverImage');
        $this->data['innerPage']        = 'media/form/design_cover_page';
        $this->data['subInnerPage']     = 'media/form/select_cover_image';
        $this->data['s4menu']           = 'TabbedPanelsTabSelected';
        $this->data['coverPageS1Menu']  = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to set selected image 
     * @access: public
     * @return void
     */ 
    public function setselectedimage( $arg_list ) {
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
       
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes =  $this->checknewsnreview($indusrty,$projectId,$elementId);
        } else {
            // check project id is exists or not
            $projRes =  $this->isprojectexists( $projectId );
        }
        
        // get post data
        $imagePost = $this->input->post();
        if(!empty($imagePost) && !empty($imagePost['album_image'])) {
            
            if($imagePost['album_image'] == 'userImg') {
                // set user's profile img as cover
                $coverData = array('isProfileCoverImage'=>'t','elementImageId'=>0);
            } else {
                // set element id in cover data
                $coverData = array('elementImageId'=>$imagePost['album_image'],'isProfileCoverImage'=>'f');
            }
            // update cover image
            $this->model_common->editDataFromTabel('Project', $coverData, 'projId', $projectId);
            if(!empty($elementId)) {
                redirect($this->redirectUrl.'newsreviewtitlendesc/'.$projectId.'/'.$elementId);
            } else {
                redirect($this->redirectUrl.'selecttitlendesc/'.$projectId);
            }
        } else {
            redirect($this->redirectUrl);
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project Title and Description
     * @access: public
     * @return void
     */ 
    public function selecttitlendesc( $arg_list ) {
        // get project id
        $projectId = $arg_list[1];
        // check project id is exists or not
        $projRes = $this->isprojectexists( $projectId,$arg_list['indusrty'] );
        $this->data['projData']         = $projRes;
        $this->data['projectId']        = $projectId; 
        $this->data['industry']         = $arg_list['indusrty'];
        $this->data['innerPage']        = 'media/form/design_cover_page';
        $this->data['subInnerPage']     = 'media/form/select_title_n_desc';
        $this->data['s4menu']           = 'TabbedPanelsTabSelected';
        $this->data['coverPageS2Menu']  = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/wizard',$this->data);
    
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save project's title n desc details
     * @access: public
     * @return void
     */ 
    public function settitlendescription( $arg_list ) {
        // get form post data
        $postData = $this->input->post();
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes = $this->checknewsnreview( $indusrty,$projectId,$elementId );
            // check project id is exists or not
            //$projRes = $this->isprojectelementexists( $projectId,$elementId,$indusrtyName );
            $nextUrl = '/newsreviewcollectioninfo/'.$projectId.'/'.$elementId;
        } else {
            // check project id is exists or not
            $projRes =  $this->isprojectexists( $projectId,$indusrty );
            $nextUrl = '/selectcollectioninfo/'.$projectId;
        }
       
        if(!empty($postData)) {
            // prepare data
            $projData = array(
                'projName'        => $postData['projName'],
                'projShortDesc'   => $postData['projShortDesc'],
                'projDescription' => $postData['projDescription'],
                'projTag'         => $postData['projTag'],
            );
           
            // update cover image
            $this->model_common->editDataFromTabel('Project', $projData, 'projId', $projectId);
        } else {
            $nextUrl = '';
        }
        echo json_encode(array('nextStep'=>$nextUrl));
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's collection info
     * @access: public
     * @return void
     */ 
    public function selectcollectioninfo( $arg_list ) {
        // get project id
        $projectId = $arg_list[1];
        // check project id is exists or not
        $projRes = $this->isprojectexists( $projectId,$arg_list['indusrty'] );
        $this->data['projData']         = $projRes;
        $this->data['projectId']        = $projectId;
        $this->data['innerPage']        = 'media/form/design_cover_page';
        $this->data['subInnerPage']     = 'media/form/select_collection_info';
        $this->data['s4menu']           = 'TabbedPanelsTabSelected';
        $this->data['coverPageS3Menu']  = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/wizard',$this->data);
    
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save project's collection info
     * @access: public
     * @return void
     */ 
    public function setcollectioninfo( $arg_list ) {
        // get form post data
        $postData = $this->input->post();
        // get project id
        $projectId = $arg_list[1];
         // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        $type = 'error';
        $msg = $this->lang->line('errorCollectionInfo');
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes = $this->checknewsnreview( $indusrty,$projectId,$elementId );
            $nextStep = '/publishcollection/'.$projectId.'/'.$elementId;
        } else {
            // check project id is exists or not
            $projRes = $this->isprojectexists( $projectId,$indusrty );
            $nextStep = '/selectcreativeteam/'.$projectId;
        }
       
        if(!empty($postData)) {
            // prepare data
            $projData = array(
                'projRating' => $postData['projRating'],
            );
            // update cover data
            $this->model_common->editDataFromTabel('Project', $projData, 'projId', $projectId);
            $msg = $this->lang->line('successCollectionInfo');
            $type = 'success';
        }
        
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$nextStep,'editId'=>$postData['id']));
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's creative team
     * @access: public
     * @return void
     */ 
    public function selectcreativeteam( $arg_list ) {
        
        // get project id
        $projectId = $arg_list[1];
        // check project id is exists or not
        $projRes = $this->isprojectexists( $projectId,$arg_list['indusrty'] );
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        // get elements data of creatives 
        $creativeElementRes = $this->model_media->getMediaCreativeElements($projectId,$elementTblPrefix); 
        
        // get count of project's creative team 
        $creativesResultCount = $this->model_common->countResult('AssociativeCreatives',array('elementId' => $projectId,'entityId'  => $this->entityId));
        // set form parameteres
        $this->data['projData']         = $projRes;
        $this->data['creativeInvolved'] = $this->model_common->getDataFromTabel('AssociativeCreatives', '*',  array('elementId'=>$projectId,'entityId'=>$this->entityId,'tdsUid'=>0),'','','');
        $this->data['toadCreativeInvolved'] = $this->model_common->getDataFromTabel('AssociativeCreatives', '*',  array('elementId'=>$projectId,'entityId'=>$this->entityId,'tdsUid !='=>0),'','','');
        $this->data['creativeElementRes']   = $creativeElementRes;
        $this->data['elementId']        = $projectId;
        $this->data['entityId']         = $this->entityId;
        $this->data['indusrty']         = $indusrty;
        $this->data['creativesCount']   = $creativesResultCount;
        $this->data['innerPage']        = 'media/form/design_cover_page';
        $this->data['subInnerPage']     = 'media/form/select_creative_team';
        $this->data['s4menu']           = 'TabbedPanelsTabSelected';
        $this->data['coverPageS4Menu']  = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/wizard',$this->data);
    
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's creative team
     * @access: public
     * @return void
     */ 
    public function addEditAssociative() {
        // get form post data
        $postData = $this->input->post();
        
        $countResult = 0;
        $crtId = $postData['crtId'];
        // set data array for store
        $data = array (
            'crtDesignation' => $postData['crtDesignation'],
            'crtName'        => $postData['crtName'],
            'crtStatus'      => 't',
            'crtLastName'    => $postData['crtLastName'],
            'elementId'      => $postData['elementId'],
            'entityId'       => $postData['entityId']
        );
        // set user id if post tdsUid exists
        if(isset($postData['tdsUid']) && !empty($postData['tdsUid'])) {
            $data['tdsUid'] = $postData['tdsUid'];
        }
        if($crtId > 0) {
            $this->model_common->editDataFromTabel('AssociativeCreatives', $data, 'crtId', $crtId);
        } else {
            
            $addCreativeInvolvedLimit = $this->lang->line('addCreativeInvolvedLimit');
            $addCreativeInvolvedLimit = ($addCreativeInvolvedLimit > 0)?$addCreativeInvolvedLimit:10;
            
            $where = array(
                'elementId' => $postData['elementId'],
                'entityId'  => $postData['entityId']
            );
            
            $countResult=$this->model_common->countResult($table='AssociativeCreatives',$where);
            
            if($countResult < $addCreativeInvolvedLimit){
                $crtId = $this->model_common->addDataIntoTabel('AssociativeCreatives', $data);
            } else {
                $crtId = 0;
            }
        }
        // prepare member html row
        $creativeTeamHtml = '';
        if($crtId > 0) {
            $creativeTeamHtml = $this->manageMemberRowHtml($crtId,$postData,$postData['Membertype']);
        }
        echo json_encode(array('creativeTeamHtml'=>$creativeTeamHtml,'editId'=>$postData['crtId']));
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage team raw html
     * @access: private
     * @return void
     */ 
    private function manageMemberRowHtml($crtId,$postData,$Membertype=0) {
        // set row bg class
        $rowBgCls = 'bg_f9f9f9';
        $rowPLCls = 'pl23';
        if($Membertype == 1) {
            //$rowBgCls = '';
            //$rowPLCls = 'pl5';
        }
        // prepare creative member's data row  
        $creativeTeamHtml  = '';
        if($postData['crtId'] == 0) {
            $creativeTeamHtml .= '<li id = "creativeTeam_'.$crtId.'">';
        }
        $creativeTeamHtml .= '<span class="'.$rowBgCls.'"><span class=" fl width176 '.$rowPLCls.'">';
        $creativeTeamHtml .= $postData['crtDesignation'].'</span>';
        $creativeTeamHtml .= $postData['crtName'].' '.$postData['crtLastName'].'<span class="red fs12 fr">';
        if($Membertype == 1) {
            $creativeTeamHtml .= '<a href="javascript:void(0)" onclick="editToadAssociative(this)" crtId='.$crtId.' crtDesignation='.$postData['crtDesignation'].' crtName='.$postData['crtName'].' crtLastName='.$postData['crtLastName'].'> Edit</a> / ';
            $creativeTeamHtml .= '<a href="javascript:void(0)" onclick="deleteCreativeMember('.$crtId.');">Delete </a>';
        } else {
            $creativeTeamHtml .= '<a href="javascript:void(0)" onclick="editAssociative(this)" crtId='.$crtId.' crtDesignation='.$postData['crtDesignation'].' crtName='.$postData['crtName'].' crtLastName='.$postData['crtLastName'].'> Edit</a> / ';
            $creativeTeamHtml .= '<a href="javascript:void(0)" onclick="deleteToadCreativeMember('.$crtId.');">Delete </a>';
        }
        $creativeTeamHtml .= '</span></span>';
        if($postData['crtId'] == 0) {
            $creativeTeamHtml .= '</li>';
        }
        
        return $creativeTeamHtml;
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to remove project's creative team member
     * @access: public
     * @return void
     */ 
    public function deleteCreativeMember() {
        $crtId = $this->input->post('crtId');
        $deleted = 0;
        $countResult = 0 ;
        if($crtId > 0) {
            $table = 'AssociativeCreatives';
            $where = array('crtId'=>$crtId);
            $this->model_common->deleteRowFromTabel($table, $where);
            $countResult = $this->model_common->countResult($table,$where,'',1);
            $deleted = 1;
        }
        echo  json_encode(array('deleted'=>$deleted, 'countResult'=>$countResult));
    }
    
    /*
     * @description: This function is used to manage toad member search popup
     * @access: public
     * @return void
     */ 
    public function searchtoadmember() {
        // set first or last name if exists in post
        $firstName = $this->input->get('val1');
        $lastName = $this->input->get('val2');
        $firstName = (!empty($firstName))?$firstName:'';
        $lastName = (!empty($lastName))?$lastName:'';
        // get user's showcase records
        $this->data['usersData']    = $this->model_media->getToadUsersData(0,'',$firstName,$lastName);
        // load serch result view
        $this->data['searchResult'] = $this->load->view('media/form/creative_members_search_result', $this->data,true);
        $this->load->view('media/form/toad_creative_members_search', $this->data);
    }
    
    /*
     * @description: This function is used to manage toad member search result
     * @access: public
     * @return void
     */ 
    public function searchtoadmemberresult() {
        // set post values
        $profileType  =  $this->input->post('userProfileType');
        $keyWord      =  $this->input->post('keyWord');
        // get searching results basis of values
        $this->data['usersData'] = $this->model_media->getToadUsersData($profileType,$keyWord);
        $searchRes =  $this->load->view('media/form/creative_members_search_result', $this->data,true);
        // return searched result view in json 
        echo json_encode(array('searchRes'=>$searchRes));
    }
    
    /*
     * @description: This function is used to copy creative team data 
     * @access: public
     * @return void
     */ 
    public function copyCreativeTeam() {
        // set post values
        $teamElementId  =  $this->input->post('teamElementId');
        $projId         =  $this->input->post('projId');
        $indusrty       =  $this->input->post('indusrty');
        $isElement      =  $this->input->post('isElement');
    
        $crtIdCount = 0;
        if(!empty($teamElementId) && !empty($indusrty) && !empty($projId)) {
            $elementTblPrefix = $this->config->item($indusrty.'Prifix');
            // get entity id
            $entityId = getMasterTableRecord($elementTblPrefix.'Element');
            // get element's creative members data
            $creativeMmberRes = $this->model_common->getDataFromTabel('AssociativeCreatives', '*',  array('entityId'=>$entityId,'elementId'=>$teamElementId),'','','');
           
            if(!empty($creativeMmberRes) && count($creativeMmberRes) > 0)  {
                foreach($creativeMmberRes as $creativeMmberRes) {
                    // set data array for store
                    $data = array (
                        'crtDesignation' => $creativeMmberRes->crtDesignation,
                        'crtName'        => $creativeMmberRes->crtName,
                        'crtStatus'      => 't',
                        'crtLastName'    => $creativeMmberRes->crtLastName,
                        'tdsUid'         => $creativeMmberRes->tdsUid,
                        'elementId'      => $projId,
                        'entityId'       => $this->entityId
                    );
                    if(!empty($isElement) && $isElement == 1) {
                        $data['entityId'] = $entityId;
                    }
                    // insert data in table
                   $crtId = $this->model_common->addDataIntoTabel('AssociativeCreatives', $data);
                   unset($data);
                   if(!empty($crtId )) {
                        $crtIdCount++;
                   }
                }
            }
        }
        echo json_encode(array('countResult'=>$crtIdCount));
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's associated media
     * @access: public
     * @return void
     */ 
    public function selectassociatedmedia( $arg_list ) {
        
        // get project id
        $projectId = $arg_list[1];
        // check project id is exists or not
        $projRes = $this->isprojectexists( $projectId , $arg_list['indusrty']);
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        // get media element table name
        $mediaElementTbl = $elementTblPrefix.'Element';
        // get entity id
        $entityId = getMasterTableRecord($mediaElementTbl);
        $whereSuportLinks = array('entityid_to'=>$entityId,'elementid_to'=>$projectId);
        $this->data['suportLinks'] = $this->model_media->suportLinks($whereSuportLinks);
        
        // get count of project's creative team 
        $creativesResultCount = $this->model_common->countResult('AssociativeCreatives',array('elementId' => $projectId,'entityId'  => $this->entityId));
        // set form parameteres
        $this->data['projData']         = $projRes;
        $this->data['creativeInvolved'] = $this->model_common->getDataFromTabel('AssociativeCreatives', '*',  array('elementId'=>$projectId,'entityId'=>$this->entityId,'tdsUid'=>0),'','','');
        $this->data['toadCreativeInvolved'] = $this->model_common->getDataFromTabel('AssociativeCreatives', '*',  array('elementId'=>$projectId,'entityId'=>$this->entityId,'tdsUid !='=>0),'','','');
        $this->data['creativeElementRes']   = $creativeElementRes;
        $this->data['elementId']        = $projectId;
        $this->data['entityId']         = $entityId;
        $this->data['indusrty']         = $indusrty;
        $this->data['creativesCount']   = $creativesResultCount;
        $this->data['innerPage']        = 'media/form/design_cover_page';
        $this->data['subInnerPage']     = 'media/form/associated_media';
        $this->data['s4menu']           = 'TabbedPanelsTabSelected';
        $this->data['coverPageS5Menu']  = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/wizard',$this->data);
    
    }
    
    //-------------------------------------------------------------------------

    /*
     * @description: This method is used to get user subscription plane details
     * @access: private
     * @auther: lokendra
     * @return: object
     */ 
    
    private function _usersubscriptiondetails($userId="0"){
        $subscriptionDetails = false; //set default value
        $whereSubcrip    = array('tdsUid' => $userId);
        $subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($subcripDetails)) {
            $subscriptionDetails  = $subcripDetails[0];
        }
        
        return $subscriptionDetails;
    }
    
    /*
     * @description: This function is used to manage toad member search popup
     * @access: public
     * @return void
     */ 
    public function searchassociatedmedia() {
        // set keyword if exists in post
        $keyword = $this->input->get('val1');
        $keyword = (!empty($keyword))?$keyword:'';
    
        // get media records
        $this->data['mediaData']    = $this->model_media->getToadUsersData(0,'',$keyword);
        // load serch result view
        $this->data['searchResult'] = $this->load->view('media/form/associated_media_search_result', $this->data,true);
        $this->load->view('media/form/associated_media_search', $this->data);
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to remove supporting link
     * @access: public
     * @return void
     */ 
    public function deleteSupportedMedia() {
        $supportLinkId = $this->input->post('supportLinkId');
        $deleted = 0;
        $countResult = 0 ;
        $blankRowHtml = '';
        $type = 'error';
        $msg = $this->lang->line('errorInMediaRemove');
        if($supportLinkId > 0) {
            $table = 'SupportLink';
            $where = array('id'=>$supportLinkId);
            $this->model_common->deleteRowFromTabel($table, $where);
            $countResult = $this->model_common->countResult($table,$where,'',1);
            $deleted = 1;
            $blankRowHtml = '<li><span class="pl77"> <img class="short" src="'.site_url().'/images/short_2.jpg"><span class="colr_999899">Add Media or Performance</span></span></li>';
            $type = 'success';
            $msg = $this->lang->line('removeAssociatedLink');
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo  json_encode(array('deleted'=>$deleted, 'countResult'=>$countResult,'blankRowHtml'=>$blankRowHtml));
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's supporting media
     * @access: public
     * @return void
     */ 
    public function addSupportingLink() {
        // get form post data
        $postData = $this->input->post();
        
        $supportOrder = 0;
        $id = $postData['id'];
        
        // set data array for store
        $data = array (
            'entityid_from'  => $postData['entityid_from'],
            'elementid_from' => $postData['elementid_from'],
            'entityid_to'    => $postData['entityid_to'],
            'elementid_to'   => $postData['elementid_to'],
        );
        // set order only on insertion
        if($id == 0) {
            // set link order
            $where = array(
                'entityid_to'  => $postData['entityid_to'],
                'elementid_to' => $postData['elementid_to']
            );
            $supportRes  = $this->model_common->getDataFromTabel('SupportLink', 'order',  $where, '', $orderBy='order', $order='DESC', $limit=1, $offset=0, $resultInArray=false);
            if(!empty($supportRes)) {
                $supportOrder  = $supportRes[0]->order;
            }
            $data['order'] = $supportOrder+1;
        }
        
        if($id > 0) {
            $this->model_common->editDataFromTabel('SupportLink', $data, 'id', $id);
            $msg = $this->lang->line('updateAssociatedLink');
        } else {
            $id = $this->model_common->addDataIntoTabel('SupportLink', $data);
            $msg = $this->lang->line('addAssociatedLink'); 
        }
        // prepare member html row
        $supportingLinkHtml = '';
        $type = 'error';
        if($id > 0) {
            //$supportingLinkHtml = $this->manageSupportingRowHtml($id,$postData);
            $type = 'success';
        }
        
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('supportingLinkHtml'=>$supportingLinkHtml,'editId'=>$postData['id']));
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage Associated Media's link html
     * @access: private
     * @return void
     */ 
    private function manageSupportingRowHtml($id,$postData) {
       
        // prepare supported link data row  
        $supportingLinkHtml  = '';
        if($postData['id'] == 0) {
            $supportingLinkHtml .= '<li id = "supportingLi_'.$id.'">';
        }
        $supportingLinkHtml .= '<span class="pl77">';
        $supportingLinkHtml .= '<img src="'.site_url().'/images/short_2.jpg" alt="" class="short max_w_31 max_h_31" />';
        $supportingLinkHtml .= $postData['projName'];
        $supportingLinkHtml .= '<span class="red fs12 fr">';
        $supportingLinkHtml .= '<a href="javascript:void(0)" onclick="editSupportedMedia('.$id.','.$postData['projName'].')"> Edit</a> / ';
        $supportingLinkHtml .= '<a href="javascript:void(0)" onclick="deleteSupportedMedia('.$id.')">Delete </a>';
        $supportingLinkHtml .= '</span></span>';
        if($postData['id'] == 0) {
            $supportingLinkHtml .= '</li>';
        }
        
        return $supportingLinkHtml;
    }
    
    //------------------------------------------------------------------------
    
    /*
    * @Description: This method is used to added plupload require js and css
    * @access: private
    * @return: void
    * @author: lokendra
    */
    
    private function _pluploadjsandcss(){
        $this->head->add_css($this->config->item('system_css').'upload_file.css');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js'); 
    }
    
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to stage "3" of media uploage step 2 set display image
     * @access: public
     * @return: void
     */
     
    public function setdisplayimage($arg_list) {
         
        // get project id
        $projectId = $arg_list[1];
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // check project id is exists or not
        $projRes = $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
      
        if(($indusrty == 'photographyNart') || (!empty($arg_list[3]) && $arg_list[3] == 1)) {
            // set element's table prefix
            $elementTblPrefix = $this->config->item($indusrty.'Prifix');
           
            $elementTable = $elementTblPrefix.'Element';
            // elements entity id
            $this->data['entityId'] = getMasterTableRecord($elementTable);
            $imagePath        = $projRes->imagePath;
            $displayImageType = $projRes->displayImageType;
             
           
            //call method for plupload css and js add
            $this->_pluploadjsandcss();
            $this->data['dirUploadMedia']   =  $this->dirUploadMedia.$indusrty.DIRECTORY_SEPARATOR.$projectId;
            $this->data['indusrtyName']     =  $indusrty; // industry name
            $this->data['imagePath']        =  (isset($imagePath))?$imagePath:''; // set image path
            $this->data['displayImageType'] =  (isset($displayImageType))?$displayImageType:0; // set image upload type
            if($this->data['displayImageType'] == 2) {
                $embeddUrl = $this->data['imagePath'];
            }
            $this->data['embeddUrl'] = (isset($embeddUrl))?$embeddUrl:''; // set embedd image 
            $this->data['elementEntityId']  =  $this->data['entityId']; // element id
            $this->data['innerPage']        =  'media/form/upload_n_describe_images'; // set view of stage 3
            $this->data['subInnerPage']     =  'media/form/set_display_image'; // set view name of sub-menu stage 3
            $this->data['s3menu']           =  'TabbedPanelsTabSelected'; // main menu selected 
            $this->data['uploadSubMenuDisplayImg']  =  'TabbedPanelsTabSelected'; // sub-menu selected
            if($projRes->elementType == 0) {
                $this->data['ispriceShippingCharge']   = $this->_ispriceshippingcharge($projRes); // get price shipping page is show
            }
            $this->data['projectId']        = $projectId; // set project id 
            $this->data['elementId']        = $elementId; // set project element id 
            $this->data['indusrtyName']     = $indusrty; // set project indusrty Name
            $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
            $this->new_version->load('new_version','form/wizard',$this->data);
        } else {
            // manage display image options
            $this->displayimageoption($arg_list);
        }
    }
    
    
    //-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to stage "3" of media uploage stage - 1
    * @access: public
    * @return: void
    */
     
    public function uploadelementfilepost($arg_list) {
    
        $browseId           =   $this->input->post('browseId');
        $projectId          =   $this->input->post('projectId');
        $elementId          =   $this->input->post('elementId');
        $elementEntityId    =   $this->input->post('elementEntityId');
        $tableName          =   getMasterTableName($elementEntityId);
        $displayImageType   =   $this->input->post('displayImageType');
        $embbededURL        =   $this->input->post('embbededURL');
        $indusrtyName       =   $this->input->post('indusrtyName'.$browseId);
        $tableName          =   $tableName[0];
        $isExternalFile     =   false;
        //--------media data prepair for inserting------//
      
        $media_fileName     =   $this->input->post('fileName'.$browseId);
        
        if( $displayImageType == 2 && !empty($embbededURL)) {
             $isExternalFile     =   true;
            $imagePath           =   getUrl($embbededURL);
        } else {
            $isExternalFile     =   false;
            $imagePath          = $this->dirUploadMedia.$arg_list['indusrty'].'/'.$projectId.'/images/'.$media_fileName;
        } 
        
        $mediaFileData  =  array('imagePath' => $imagePath);
        
        $this->model_common->editDataFromTabel($tableName, $mediaFileData, 'elementId', $elementId);
        
        //next page url
        $nextUrl  = '/uploadtitle/'.$projectId.'/'.$elementId ;
        
        $msg='Media file uploaded successfully';
        set_global_messages($msg, $type='success', $is_multiple=true);
        $returnData = array('msg'=>$msg,'nextUrl'=>$nextUrl,'isExternalFile'=>$isExternalFile);
        echo json_encode($returnData);
    }
    
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to stage "3" of media uploage step 2 set display image
     * @access: public
     * @return: void
     */
     
    public function displayimageoption($arg_list) {
         
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        
        // check project id is exists or not
        $projRes = $this->isprojectelementexists( $projectId,$elementId,$arg_list['indusrty'] );
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // set industry table name
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        $displayImageType = $projRes->displayImageType;
        
        if( $elementTblPrefix != 'Fv' ) {
            $this->data['embeddImageOption'] = true;
        } else if( $elementTblPrefix == 'Em' || $elementTblPrefix == 'Wp' ) {
            $this->data['profileImageOption'] = true;
        }
        
        // set form parametres
        $this->data['defaultImageTitle']  = $this->config->item(strtoupper($elementTblPrefix));
        $this->data['displayImageType'] =  (isset($displayImageType))?$displayImageType:'';
        $this->data['innerPage']        =  'media/form/upload_n_describe_images'; // set view of stage 3
        $this->data['subInnerPage']     =  'media/form/display_image_options'; // set view name of sub-menu stage 3
        $this->data['s3menu']           =  'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['uploadSubMenuDisplayImg']  =  'TabbedPanelsTabSelected'; // sub-menu selected
        if($projRes->elementType == 0) {
            $this->data['ispriceShippingCharge']   = $this->_ispriceshippingcharge($projRes); // get price shipping page is show
        }
        $this->data['projectId']        = $projectId; // set project id 
        $this->data['elementId']        = $elementId; // set project element id
        $this->data['entityId']         =  getMasterTableRecord($elementTable);
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to update display image options
     * @access: public
     * @return void
     */ 
    public function setdisplayimageoption() {
       
        $nextUrl = '';
        // get form post data
        $postData = $this->input->post();
        if(!empty($postData)) {
            $tableName    =   getMasterTableName($postData['entityId']);
            // set image type
            $data = array (
                'displayImageType'  => $postData['displayImageType'],
            );
            $this->model_common->editDataFromTabel($tableName[0], $data, 'elementId', $postData['elementId']);
            if($postData['displayImageType'] == 3 || $postData['displayImageType'] == 4) {
                $nextUrl = 'uploadtitle/'.$postData['projectId'].'/'.$postData['elementId'];
            } else {
                $nextUrl = 'setdisplayimage/'.$postData['projectId'].'/'.$postData['elementId'].'/1';
            }
        }
        redirect($this->redirectUrl.$nextUrl);
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to open review popup
    * @auther: lokendra meena
    * @return: void
    */ 
    
    public function reviewsavedpopup() {
        $projId         =   $this->input->get('val1');
        $elemId         =   $this->input->get('val2');	
        $data['projId'] =   $projId;
        $data['elemId'] =   $elemId;	
        $this->load->view('review_after_save_new',$data);	 
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to show next stage options
    * @return: void
    */ 
    function nextmediaoptions($arg_list) {
      
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrtyName = $arg_list['indusrty'];
        // check project id is exists or not
        $projRes = $this->isprojectexists( $projectId,$indusrtyName );
       
        // set design cover page title
        $designCoverPage = $this->lang->line('designCoverPage');
        // get users subscription type
        $subscriptionType = getSubscriptionType();
        // get container details
        $containerInfo = getUserContainerSpace($this->dirUser, $this->userId, $subscriptionType);
        
        switch ($indusrtyName)
        {
            case 'filmNvideo':
                $addAnotherMedia = $this->lang->line('addAnotherMedia');
                // get samle element count
                $sampleElementCount = $this->getprojectelementcount($projectId,1,$indusrtyName);
                // set sample audio option
                if($projRes->projSellstatus == 't' && $sampleElementCount == 0) {
                    $addSampleMedia = $this->lang->line('addSampleCollection');
                    // set sample type id as 1
                    $isSample = 1;
                }
                // get trailer element count
                $trailerElementCount = $this->getprojectelementcount($projectId,2,$indusrtyName);
                if( $trailerElementCount == 0 ) {
                    $addTrailer = $this->lang->line('addTrailer');
                    // set trailer type id as 2
                    $isTrailer = 2;
                }
            break;
            
            case 'musicNaudio':
                // set new element's title option
                $addAnotherMedia = $this->lang->line('addAnotherMusicTrack');
                if( $projRes->projCategory == 5) {
                    $addAnotherMedia = $this->lang->line('addAnotherAudioTrack');
                }
                // get samle element count
                $sampleElementCount = $this->getprojectelementcount($projectId,1,$indusrtyName);
                // set sample audio option
                if($projRes->projSellstatus == 't' && $sampleElementCount == 0) {
                    
                    $addSampleMedia = $this->lang->line('addSampleAlbum');
                    if( $projRes->projCategory == 5 ) {
                        $addSampleMedia = $this->lang->line('addSampleCollection');
                    }
                    // set sample type id as 1
                    $isSample = 1;
                }
               
            break;
            
            case 'photographyNart':
                $addAnotherMedia = $this->lang->line('addAnotherMediaArt');
                if( $projRes->projCategory == 7 ) {
                    $addAnotherMedia = $this->lang->line('addAnotherMediaPhotography');
                }
               
                // set cover options label
                $designCoverPage = $this->lang->line('designCoverPagePaid');
                if($subscriptionType == 1) {
                    $designCoverPage = $this->lang->line('designCoverPageFree');
                }
            break;
            
            case 'writingNpublishing':
            case 'educationMaterial':
                $addAnotherMedia = $this->lang->line('addAnotherMedia');
                // get samle element count
                $sampleElementCount = $this->getprojectelementcount($projectId,1,$indusrtyName);
                // set sample audio option
                if($projRes->projSellstatus == 't' && $sampleElementCount == 0) {
                    $addSampleMedia = $this->lang->line('addSampleCollection');
                    // set sample type id as 1
                    $isSample = 1;
                }
            break;
            
            default:
                $addAnotherMedia = '';
        }
        
        $this->data['elementId']  = $projectId;
        $this->data['projElementId'] = $elementId;
        $this->data['addAnotherMedia'] = $addAnotherMedia;
        $this->data['remainingSize'] = $containerInfo['remainingSize'];
        $this->data['containerSize'] = $containerInfo['containerSize'];
        $this->data['designCoverPage'] = $designCoverPage;
        $this->data['addSampleMedia']  = (isset($addSampleMedia))?$addSampleMedia:'';
        $this->data['addTrailerMedia'] = (isset($addTrailer))?$addTrailer:'';
        $this->data['isSample']  = (isset($isSample))?$isSample:0;
        $this->data['isTrailer'] = (isset($isTrailer))?$isTrailer:0;
         $this->data['indusrtyName']  = $indusrtyName;
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/next_media_options',$this->data);
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to manage next selected option
    * @return: void
    */ 
    function movetonextstep($arg_list) {
        
        // get project id
        $projectId = $arg_list[1];
        // get media industry type
        $indusrtyName = $arg_list['indusrty'];
        // check project id is exists or not
        $projRes = $this->isprojectexists( $projectId,$indusrtyName );
        // set index page redirect url
        $redirectUrl = base_url('media/'.$indusrtyName.'/'.$projectId);
        
        // get post form data
        $postData = $this->input->post();
        if(!empty($postData)) {
          
            if($postData['nextOption'] == 1 || $postData['nextOption'] == 3 || $postData['nextOption'] == 4) {
                // manage element type sample or trailer 
                if($postData['isSample'] == 1 && $postData['nextOption'] == 4) {
                    $elementType = $postData['isSample'];
                } else if($postData['nextOption'] == 3 && $postData['isTrailer'] == 2) {
                    $elementType = $postData['isTrailer'];
                } else {
                    $elementType = 0;
                }
                
                // create element of project
                $elementId = $this->addprojectelement($projectId, $indusrtyName, $elementType);
               
                if(!empty($elementId)) {
                    $redirectUrl = base_url($this->redirectUrl.'uploadform/'.$projectId.'/'.$elementId);
                }
            } else {
                $redirectUrl = base_url($this->redirectUrl.'selectcoverimage/'.$projectId);
            }
        }
        redirect($redirectUrl);
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to manage next selected option
    * @return: void
    */ 
    private function addprojectelement($projId,$indusrtyName,$elementType=0) {
        
        // get element's table name
        $elementTblPrefix = $this->config->item( $indusrtyName.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        // get project publish status
        $projectResData =   $this->model_common->getDataFromTabel('Project', 'isPublished',  array('projId'=>$projId),'','','',1);
        $elementPublished = 'f';
        // set element publish status
        if(!empty($projectResData) && $projectResData[0]->isPublished == 't') {
            $elementPublished = 't';
        }
        // create element of project
        $elementAddData   =   array('projId'=>$projId,'fileId'=>'1','title'=>'Untitled','mediaTypeId'=>NULL,'elementType'=>$elementType,'isPublished'=>$elementPublished);
        $elementId        =   $this->model_common->addDataIntoTabel($elementTable, $elementAddData);
        if(!empty($elementId)) {
            // add element record in summary log
            addDataIntoLogSummary($elementTable,$elementId);
            // manage log  count
            mediaFileCount($this->entityId,$projId,$indusrtyName);
        }
        return $elementId;
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to get element data
    * @return: void
    */ 
    private function getprojectelementcount($projId,$elementType,$indusrty,$isReturnCount=1) {
       
        $elementResult = 0;
        // set industry table name
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        // get elements table info
        $elementRes = $this->model_common->getDataFromTabel($elementTable, 'elementId,displayImageType',  array('elementType'=>$elementType,'projId'=>$projId),'','','');
        if( $elementRes ) {
            if($isReturnCount == 0) { 
                $elementResult = $elementRes[0];
            } else {
                $elementResult = count($elementRes);
            }
            
        }
        
        return $elementResult;
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to stage "3" of media uploage stage - 1
     * @access: public
     * @return: void
     */
     
    public function uploadform($arg_list) {
        
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // set industry name
        $indusrtyName = $arg_list['indusrty'];
        if(!empty($elementId)) {
            // check project id is exists or not
            $projRes = $this->isprojectelementexists( $projectId,$elementId,$indusrtyName );
        } else {
            // check project id is exists or not
            $projRes = $this->isprojectexists( $projectId,$arg_list['indusrty'] );
        }
        // set base url
        $baseUrl = formBaseUrl();
        
        if($projRes->hasDownloadableFileOnly != 0 && $indusrtyName != 'educationMaterial') {
            $elementType = 0;
            if(empty($elementId)) {
                $elementId = $this->addprojectelement($projectId, $indusrtyName, $elementType);
            }
            // set upload file form url
            $uploadUrl = $baseUrl.'/uploadfile/'.$projectId.'/'.$elementId;
            redirect($uploadUrl);
        } elseif(isset($projRes->elementType) && $projRes->elementType != 0 && $indusrtyName != 'educationMaterial') {
            // set upload file form url
            $uploadUrl = $baseUrl.'/uploadfile/'.$projectId.'/'.$elementId;
            redirect($uploadUrl);
        }
        
        
        if($indusrtyName != 'educationMaterial') {
            switch ($indusrtyName) {
                case 'filmNvideo':
                    $fileType = 'Video';
                    $fileShipped = 'DVD';
                break;
                
                case 'musicNaudio':
                    $fileType = 'Audio';
                    $fileShipped = 'CD';
                break;
                
                case 'writingNpublishing':
                    $fileType = 'Text';
                    $fileShipped = 'Text';
                break;
                
                case 'photographyNart':
                    $fileType = 'Image';
                    $fileShipped = 'Print';
                    if( $projRes->projCategory == 7 ) {
                        $fileShipped = 'Artwork';
                    }
                    
                break;
                
                default:
                    $fileType = '';
                    $fileShipped = '';
            }
            // set option view page name
            $optionViewPage = 'media/form/upload_form_options';
        } else {
            
            if($projRes->hasDownloadableFileOnly == 0) {
                $emFileTypes = 1;
            }
            if($projRes->elementType == 1) {
                $elementType = $projRes->elementType;
            }
    
            // set edocational material option view page name
            $optionViewPage = 'media/form/upload_em_form_options';
            $this->data['typePrefix'] = 'An';
            // set media form availability
            $this->data['isMediaForm']  = 1;
        }
       
        if(!empty($elementId)) {
            // get element's table name
            $elementTblPrefix = $this->config->item( $indusrtyName.'Prifix');
            $elementTable = $elementTblPrefix.'Element';
            $fields = 'isDownloadPrice,isPrice';
            if($indusrtyName == 'educationMaterial') {
                $fields = 'isDownloadPrice,isPrice,mediaFileType';
            }
            // get project element data
            $elementRes = $this->model_common->getDataFromTabel($elementTable, $fields,  array('elementId'=>$elementId,'projId'=>$projectId),'','','');
           
            if( !empty($elementRes) && count($elementRes) > 0 ) {
                 
                $elementRes = $elementRes[0];
                if($elementRes->isDownloadPrice == 't') {
                    $formOption = 1;
                } elseif($elementRes->isPrice == 't') {
                    $formOption = 2;
                }
                if($indusrtyName == 'educationMaterial') {
                    $mediaFileType = $elementRes->mediaFileType;
                }
            }
        }
        
        $this->data['fileType']         = $fileType;
        $this->data['fileShipped']      = $fileShipped;
        $this->data['projectId']        = $projectId;
        $this->data['elementId']        = $elementId;
        $this->data['emFileTypes']      = (isset($emFileTypes))?$emFileTypes:0;
        $this->data['formOption']       = (isset($formOption))?$formOption:0;
        $this->data['mediaFileType']    = (isset($mediaFileType))?$mediaFileType:0;
        $this->data['elementType']      = (isset($elementType))?$elementType:0;
        $this->data['innerPage']        = 'media/form/upload_n_describe_images'; // set view of stage 3
        $this->data['subInnerPage']     = $optionViewPage; // set view name of sub-menu stage 1
        $this->data['indusrtyName']     =   $arg_list['indusrty']; // set industry name
        $this->data['s3menu']           = 'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['uploadSubMenuForm']  = 'TabbedPanelsTabSelected'; // sub-menu selected
        $this->data['ispriceShippingCharge']   =   $this->_ispriceshippingcharge($projRes); // get price shipping page is show
        $arg_list['mode']               =   'edit'; // set mode of page
        
        //$this->_ispriceshippingcharge($projectId,$elementId);
        $this->loadMediaWizardView($arg_list);   
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to create new element
    * @return: void
    */ 
    public function setuploadformoption($arg_list) {
        
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // set industry name
        $indusrtyName = $arg_list['indusrty'];
        // get element's table name
        $elementTblPrefix = $this->config->item( $indusrtyName.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        if(!empty($elementId)) {
            // get project element data
            $elementRes = $this->model_common->getDataFromTabel($elementTable, 'fileId,isShippable',  array('elementId'=>$elementId,'projId'=>$projectId),'','','');
            if( $elementRes && count($elementRes) > 0 ) {
                $elementCount = count($elementRes);
                // set element shippable status
                $shippableStatus = $elementRes[0]->isShippable;
            } else {
                // redirect if element not found
                redirect(base_url(lang().'/media/'.$indusrtyName.'/'.$projectId));
            }
        } else {
            // check project id is exists or not
            $projRes = $this->isprojectexists( $projectId, $indusrtyName);
        }
        
        // get post data
        $postData = $this->input->post();
        if(!empty($postData)) {
            // set media form option exept EM
            $formOption = $postData['formOption'];
            // create element of project
            $elementData   =   array('isDownloadPrice'=>'f','isPerViewPrice'=>'f','isPrice'=>'f');
           
             // set media file type for educational material
            if($indusrtyName == 'educationMaterial') {
                $elementData['mediaFileType'] = $postData['emFileType'];
                // set media form option for EM
                $formOption = $postData['formOption'.$postData['emFileType']];
            } 
            $isShippable = 0;
            // set form download and price options
            if( $formOption == 1 ) {
                $elementData['isDownloadPrice'] = 't';
                // set pay per view for filmsNvideo
                if($indusrtyName == 'filmNvideo') {
                    $elementData['isPerViewPrice'] = 't';
                }
                // set shippable type
                $elementData['isShippable'] = 'f';
            } elseif( $formOption == 2 ) {
                $elementData['isPrice'] = 't';
                // set shippable type
                $elementData['isShippable'] = 't';
                $isShippable = 1;
            }
            
            // manage data store
            if(!empty($elementId)) {
            
                // update element record
                $this->model_common->editDataFromTabel($elementTable, $elementData, 'elementId', $elementId);
                if(isset($shippableStatus) && $shippableStatus != $elementData['isShippable']) {
                    // update media file count in reverse order
                    mediaFileCount($this->entityId,$projectId,$indusrtyName,0,0,$shippableStatus);
                }
            } else {
                // create new element of project
                $elementType    = '0'; //default element type is "0"
                $elementData['projId'] = $projectId; 
                $elementData['fileId'] = 1;
                $elementData['mediaTypeId'] = NULL; 
                $elementData['elementType'] = $elementType;
                $elementId = $this->model_common->addDataIntoTabel($elementTable, $elementData);
                // add data into log summary
                addDataIntoLogSummary($elementTable,$elementId);
                // update media file count
                mediaFileCount($this->entityId,$projectId,$indusrtyName,$isShippable);
            }
            // set base url
            $baseUrl = formBaseUrl();
            // redirect to upload file form
            redirect($baseUrl.'/uploadfile/'.$projectId.'/'.$elementId);
        } else {
            // redirect if element not found
            redirect(base_url(lang().'/media/'.$indusrtyName.'/'.$projectId));
        }
        
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to check project exists or not
     * @access: private
     * @return void
     */ 
    private function isprojectelementexists( $projectId ,$elementId, $indusrtyName='') {
    
        $msg = 'Check your project values.'; // set default project error msg
        if(!empty($projectId) && is_numeric($projectId) && !empty($elementId) && !empty($indusrtyName)) {
           
            // set element's table prefix
            $elementTblPrefix = $this->config->item($indusrtyName.'Prifix');
            $elementTable = $elementTblPrefix.'Element';
            $projRes = $this->model_media->getprojelementrecord($elementTable,$projectId,$elementId);
           
            if(!empty($projRes)) {
                if(($projRes[0]->hasDownloadableFileOnly == 0 && $projRes[0]->elementType == 0) || $indusrtyName == 'educationMaterial') {
                    // set media form availability
                    $this->data['isMediaForm']  = 1;
                }
                return $projRes[0];
            } else {
                set_global_messages($msg, $type='error', $is_multiple=true);
                redirect(base_url(lang().'/media/'.$indusrtyName.'/'.$projectId));
            }
        } else {
            set_global_messages($msg, $type='error', $is_multiple=true);
            redirect($this->redirectUrl);
        }
    }
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get media unpublished collection for edit
     * @access: public
     * @return: void
     */
     
    public function publicisemediacollection($arg_list) {
        // set publicise section
        $this->data['isPubliciseSection'] = 1;
        // manage all unpublished media projects
        $this->getmediacollection($arg_list,1);
    }
    
     //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get media published collection for edit
     * @access: public
     * @return: void
     */
     
    public function viewmediacollection($arg_list) {
        // manage all published media projects
        $this->getmediacollection($arg_list,1);
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get media collection for edit
     * @access: public
     * @return: void
     */
     
    public function editmediacollection($arg_list) {
        // manage all media projects
        $this->getmediacollection($arg_list);
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get media collection for edit
     * @access: public
     * @return: void tosif
     */
     
    public function getmediacollection($arg_list,$isPublished='') {
        
        // set industry name
        $indusrtyName = $arg_list['indusrty'];
        // get industry id
        $industryId = $this->config->item($indusrtyName.'SectionId');
        if($indusrtyName != 'news' && $indusrtyName != 'reviews') {
           
            $this->data['packagestageheading'] = $this->lang->line('editYourMediaShowcase');
            $this->data['indusrty'] = $indusrtyName; // set media industry type
            $this->data['industryId'] = $industryId; // set media industry id
            $this->data['mediaCollectionResult'] = $this->getmediacollectionresult(true,$indusrtyName,$isPublished);
            $this->new_version->load('new_version','form/media_edit_collection',$this->data);
        } else {
            redirect(base_url(lang().'/home'));
        }
    }
    
     //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get elements search 
     * @access: public
     * @return: void
     */
    public function getmediacollectionresult($loadView=false,$indusrtyName='',$isPublished='') {
        
        $isSetCookie = setPerPageCookie('searchPerPageVal',$this->config->item('perPageRecord'));
        $pages = new Pagination_new_ajax;
        // get project's list
        $projResCounts = $this->model_media->getprojectrecords($indusrtyName,$isPublished);
        $pages->items_total = count($projResCounts);
        $this->data['perPageRecord'] = $this->config->item('perPageRecord');
        $pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$isSetCookie;
        $pages->paginate();
        // get project's records list
        $projRes = $this->model_media->getprojectrecords($indusrtyName,$isPublished,$pages->limit, $pages->offst);
        
        $this->data['items_total'] = $pages->items_total;
        $this->data['items_per_page'] = $pages->items_per_page;
        $this->data['pagination_links'] = $pages->display_pages();
        $pages->paginate($isShowButton=true,$isShowNumbers=false);
        $this->data['industryId'] = $industryId; // set media industry id
        $this->data['projList']   = (object)$projRes;
     
        $searchResultView = $this->load->view('form/media_edit_collection_result',$this->data,$loadView);
        if($loadView){
            return $searchResultView;
        }
    }
    
     //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to show selected project
     * @access: public
     * @return: void
     */
     
    public function publiciseproject($arg_list) {
        // set publicise section
        $this->data['isPubliciseSection'] = 1;
        // manage selected project
        $this->editproject($arg_list);
        
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to show selected project
     * @access: public
     * @return: void
     */
     
    public function editproject($arg_list) {
        // set industry name
        $indusrtyName = $arg_list['indusrty'];
        // get project id
        $projectId = $arg_list[1];
        // set section Id
        $sectionId = $arg_list['sectionId'];
       
        if(!empty($projectId) && $indusrtyName) {
            // check project id is exists or not
            $projRes = $this->isprojectexists( $projectId, $indusrtyName );
            
            // get projects log summary
            $projectEntityId = getMasterTableRecord('Project');
            $logSummryDta = $this->model_common->getDataFromTabel('LogSummary','craveCount,viewCount,ratingAvg,reviewCount',array('entityId'=>$projectEntityId,'elementId'=>$projectId), '','','',1);
            $logSummryDta = $logSummryDta[0];
            
            // manage sample and trailer media
            if($sectionId != 4 && $sectionId != '3:1' && $sectionId != '3:2') {
                // get samle element count
                $sampleElementCount = $this->getprojectelementcount($projectId,1,$indusrtyName,0);
                // set sample audio option
                if(!empty($sampleElementCount)) {
                    // set trailer element id
                    $sampleElementId = $sampleElementCount->elementId;
                } else {
                    // set sample type id as 1
                    $isSample = 1;
                }
                // get trailer element count
                $trailerElementCount = $this->getprojectelementcount($projectId,2,$indusrtyName,0);
                if(!empty($trailerElementCount)) {
                    // set trailer element id
                    $trailerElementId = $trailerElementCount->elementId;
                } else {
                    // set trailer type id as 2
                    $isTrailer = 2;
                }
            }
            // get element's table name
            $elementTblPrefix = $this->config->item( $indusrtyName.'Prifix');
            $elementTable = $elementTblPrefix.'Element';
            if($sectionId == '3:1' || $sectionId == '3:2') {
                // get project's element data list
                $projNewsOrReviewRes = $this->model_common->getDataFromTabel($elementTable, 'elementId',  array('projId'=>$projectId),'','','');
                if(!empty($projNewsOrReviewRes)) {
                    $elementId = $projNewsOrReviewRes[0]->elementId;
                }
            } else {
                // get project's download elements if exists
                $downloadFiles = $this->model_common->getDataFromTabel($elementTable, 'elementId',  array('projId'=>$projectId,'isDownloadPrice'=>'t'),'','','');
                // get project's non download elements if exists
                $nonDownloadFiles = $this->model_common->getDataFromTabel($elementTable, 'elementId',  array('projId'=>$projectId,'isDownloadPrice'=>'f'),'','','');
            
            }
            // get users subscription type
            $subscriptionType = getSubscriptionType();
            // get container details
            $containerInfo = getUserContainerSpace($this->dirUser, $this->userId, $subscriptionType);
            //get media file names
            $fileFormateNames = $this->setfilename($indusrtyName,$projRes);
            $this->data['projData']      = $projRes;
            $this->data['userId']        = $this->userId;
            $this->data['isSample']      = (isset($isSample))?$isSample:'';
            $this->data['isTrailer']     = (isset($isTrailer))?$isTrailer:''; 
            $this->data['trailerElementId'] = (isset($trailerElementId))?$trailerElementId:'';
            $this->data['sampleElementId']  = (isset($sampleElementId))?$sampleElementId:'';
            $this->data['containerSize'] = (isset($containerInfo['containerSize']))?$containerInfo['containerSize']:'';
            $this->data['remainingSize'] = (isset($containerInfo['remainingSize']))?$containerInfo['remainingSize']:'';
            $this->data['indusrtyName']  = $indusrtyName;
            $this->data['viewCount']     = (isset($logSummryDta->viewCount))?$logSummryDta->viewCount:0;
            $this->data['craveCount']    = (isset($logSummryDta->craveCount))?$logSummryDta->craveCount:0;
            $this->data['ratingAvg']     = (isset($logSummryDta->ratingAvg))?$logSummryDta->ratingAvg:0;
            $this->data['reviewCount']   = (isset($logSummryDta->reviewCount))?$logSummryDta->reviewCount:0;
            $this->data['downloadFiles']      = (!empty($downloadFiles))?count($downloadFiles):0;
            $this->data['nonDownloadFiles']   = (!empty($nonDownloadFiles))?count($nonDownloadFiles):0;
            $this->data['newsreviewCount']    = (isset($projNewsOrReviewRes))?count($projNewsOrReviewRes):0;
            $this->data['elementId']          = (isset($elementId))?$elementId:0;
            $this->data['sectionId']          = $arg_list['sectionId'];
            $this->data['fileFormateNames']   = $fileFormateNames;
            $this->data['packagestageheading'] = $this->lang->line('editYourMediaShowcase');
            $this->new_version->load('new_version','form/media_edit_project',$this->data);
        } else {
            redirect($this->redirectUrl.'/editmediacollection');
        }
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to add trailer or sample file
     * @access: public
     * @return: void
     */
     
    public function addtrailerorsamplefile($arg_list) {
        // set industry name
        $indusrtyName = $arg_list['indusrty'];
        // get project id
        $projectId = $arg_list[1];
        // get element type
        $elementType = $arg_list[2];
        // check project id is exists or not
        $projRes = $this->isprojectexists( $projectId, $indusrtyName);
       
        // create element of project
        $elementId = $this->addprojectelement($projectId, $indusrtyName, $elementType);
        // set base url
        $baseUrl = formBaseUrl();
        // redirect to upload file form
        redirect($baseUrl.'/uploadfile/'.$projectId.'/'.$elementId);
    }
    
     /*
     * @Description: This method is use to set file name and type
     * @access: public
     * @return: void
     */
    private function setfilename($indusrtyName,$projRes,$mediaFileType=0) {
          switch ($indusrtyName) {
            case 'filmNvideo':
                $fileType = 'Video File';
                $fileShipped = 'DVD';
                $fileName = 'video';
                $albumName = 'Video Album';
            break;
            
            case 'musicNaudio':
                $fileType = 'Audio File';
                $fileShipped = 'CD';
                $fileName = 'audio';
                $albumName = 'Audio Collection';
                if( $projRes->projCategory == 3 ) {
                    $fileType = 'Music File';
                    $fileName = 'music';
                    $albumName = 'Music Album';
                }
                
               
            break;
            
            case 'writingNpublishing':
                $fileType = 'Text File';
                $fileShipped = 'Text';
                $fileName = 'text';
                $albumName = 'Text Collection';
            break;
            
            case 'photographyNart':
                $fileType = 'Image File';
                $fileShipped = 'Prints';
                $fileName = 'image';
                $albumName = 'Photography Album';
                if( $projRes->projCategory == 7 ) {
                    $fileShipped = 'Artworks';
                    $fileName = 'artwork';
                    $albumName = 'Art Collection';
                }
                
            break;
            
             case 'educationMaterial':
               switch($mediaFileType) {
                    case 2:
                        $fileType = 'Video File';
                        $fileShipped = 'DVD';
                        $fileName = 'video';
                        break;
                    case 3:
                        $fileType = 'Audio File';
                        $fileShipped = 'CD';
                        $fileName = 'audio';
                        break;
                    case 4:
                        $fileType = 'Text File';
                        $fileShipped = 'Text';
                        $fileName = 'text';
                        break;
                    default :
                        $fileType = 'Video File';
                        $fileShipped = 'DVD';
                        $fileName = 'educational Media';
                        $albumName = 'Educational Media';
                        break;
                }
               
            break;
            
            
            default:
                $fileType = '';
                $fileShipped = '';
        }
        return array('fileType'=>$fileType,'fileShipped'=>$fileShipped,'fileName'=>$fileName,'albumName'=>$albumName);
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get media collection for edit
     * @access: public
     * @return: void
     */
     
    public function editmediaelements($arg_list) {
        
        // set industry name
        $indusrtyName = $arg_list['indusrty'];
        // get project id
        $projectId = $arg_list[1];
        // check project id is exists or not
        $projRes = $this->isprojectexists( $projectId, $indusrtyName);
        // get element's table name
        $elementTblPrefix = $this->config->item( $indusrtyName.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        // set where clause for collection
        $whereFields = array('projId'=>$projectId);
        if($indusrtyName != 'news' && $indusrtyName != 'reviews') {
            $whereFields['elementType'] = 0;
        }
        // get project's elements list
        $elementRes = $this->model_common->getDataFromTabel($elementTable, 'elementId,title,imagePath,displayImageType',  $whereFields,'','','');
      
        $this->data['elementList']   = $elementRes;
        $this->data['projectId']     = $projectId;
        $this->data['indusrtyName']  = $indusrtyName;
        $this->data['packagestageheading'] = $this->lang->line('editYourMediaShowcase');
        $this->new_version->load('new_version','form/media_element_edit_collection',$this->data);
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to edit project element
     * @access: public
     * @return: void
     */
     
    public function editprojectelement($arg_list) {
        // get project element id
        $projElementId = explode('_',$arg_list[1]);
        // set industry name
        $indusrtyName = $arg_list['indusrty'];
        if(!empty($projElementId) && is_array($projElementId)) {
            if($indusrtyName != 'news' && $indusrtyName != 'reviews') {
                // redirect to upload element form
                $redirectUrl = $this->redirectUrl.'uploadform/'.$projElementId[0].'/'.$projElementId[1];
            } else {
                // redirect to edit element form
                $redirectUrl = $this->redirectUrl.$projElementId[0].'/'.$projElementId[1];
            }
            redirect($redirectUrl);
        }
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to remove project from collection
     * @access: public
     * @return: void
     */
    public function deleteproject() {
        // get project id
        $projId = $this->input->post('projId');
        // set default msg and type as error
        $msg = $this->lang->line('errorInMediaRemove');
        $type = 'error';
        if(!empty($projId)) {
            // update project status
            $this->model_common->editDataFromTabel('Project', array('isPublished'=>'f','isArchive'=>'t'), 'projId', $projId);
            // set default msg and type for success
            $msg = $this->lang->line('removedProject');
            $type = 'success';
        } 
        
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>1));
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to manage news wizard
     * @access: public
     * @return: void
     */
    public function newswizard() {
        $arg_list = func_get_args();
        $sectionId=$this->config->item('newsSectionId');
        $arg_list['sectionId'] = $sectionId;
        $arg_list['indusrty'] = 'news';
        $arg_list['category'] = 'News Collection';
        $arg_list['projCategory'] = 15;
       
        if(isset($arg_list[0]) && !is_numeric($arg_list[0])) {
            // load industry typr lang file
            $this->load->language($arg_list['indusrty']);
            if (method_exists($this,$arg_list[0])) {
                $this->$arg_list[0]($arg_list);
                // check add space request
                $this->_isaddspacerequest($arg_list[0]);
            } else {
               redirectToNorecord404();
            }
        } else {
            $this->setupnewsorreviews($arg_list);
        }
    }
    
     //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to manage reviews wizard
     * @access: public
     * @return: void
     */
    public function reviewswizard() {
        $arg_list = func_get_args();
        $sectionId=$this->config->item('reviewsSectionId');
        $arg_list['sectionId'] = $sectionId;
        $arg_list['indusrty'] = 'reviews';
        $arg_list['category'] = 'Reviews Collection';
        $arg_list['projCategory'] = 16;
        if(isset($arg_list[0]) && !is_numeric($arg_list[0])) {
            // load industry typr lang file
            $this->load->language($arg_list['indusrty']);
            if (method_exists($this,$arg_list[0])) {
                $this->$arg_list[0]($arg_list);
                 // check add space request
                $this->_isaddspacerequest($arg_list[0]);
            } else {
                redirectToNorecord404();
            }
        } else {
            $this->setupnewsorreviews($arg_list);
        }
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to set news or reviews
     * @access: public
     * @return: void
     */
    public function setupnewsorreviews($arg_list) {
        // unset media cart id
        $this->session->unset_userdata('mediaCartId');
        // unset media container id
        $this->session->unset_userdata('mediaContainerId');
        $indusrty = $arg_list['indusrty'];
        // get project id
        $projectId = $arg_list[0];
        // get element id
        $elementId = $arg_list[1];

        if(!empty($indusrty)) {
            //get project data if exists
            if(!empty($projectId) && !empty($elementId)) {
                $projData = $this->checknewsnreview($indusrty,$projectId,$elementId);
            } else if (!empty($projectId) && empty($elementId)) {
                // check project id is exists or not
                $this->isprojectexists( $projectId,$indusrty );
            } else {
                // get project's list
                $projRes = $this->model_common->getDataFromTabel('Project', 'projId',  array('tdsUid'=>$this->userId,'isArchive'=>'f','projectType'=>$indusrty),'','','');
                if(!empty($projRes)) {
                    $projectId = $projRes[0]->projId;
                }
            }
            $this->load->language($indusrty);
            $this->data['projData'] = (isset($projData))?$projData:'';
            $this->data['projectId'] = $projectId;
            $this->data['elementId'] = $elementId;
            $this->data['sectionId'] = $arg_list['sectionId'];
            $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase') ;
            $this->data['innerPage'] = 'media/form/add_news_reviews';
            $this->data['s1menu'] = 'TabbedPanelsTabSelected';
            $this->data['subInnerPage'] = 'media/form/add_news_review_form';
            $this->data['addNewsReviewS1Menu'] = 'TabbedPanelsTabSelected';
            $this->new_version->load('new_version','form/news_review_wizard',$this->data);
        }
    }
    
    
    public function savenewsnreviews($arg_list) {
       
        // get project id
        $projectId = $arg_list[1];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // get form post data
        $postData = $this->input->post();
        $nextUrl = '';
        $pkgSection = '{'.$arg_list['sectionId'].'}';
        if(!empty($postData)) {
            if(!empty($projectId)) {
                $projectId = $projectId;
            } else {
                if(!empty($arg_list['sectionId'])) {
                    // get project's container id
                    $userContainerRes = $this->model_common->getDataFromTabel('UserContainer', 'userContainerId',  array('tdsUid'=>$this->userId,'pkgSections'=>$pkgSection),'','','');
                }
                // prepare project data
                $projCategory = ((int)$arg_list['projCategory'] > 0)?$arg_list['projCategory']:0;
                $projData = array(
                    'tdsUid'        => $this->userId,
                    'projCategory'  => $projCategory,
                    'projectType'   => $arg_list['indusrty'],
                    'projName'      => 'Untitled',
                    'userContainerId'=> (isset($userContainerRes[0]->userContainerId))?$userContainerRes[0]->userContainerId:0,
                );
       
                // add project data
                $projectId = $this->model_common->addDataIntoTabel('Project', $projData);
            }
           
            if(!empty($projectId)) {
                // get project's publish status 
                $projData = $this->model_common->getDataFromTabel('Project', 'isPublished',  array('tdsUid'=>$this->userId,'projId'=>$projectId),'','','');
                // set publish value
                $isPublished = (isset($projData[0]->isPublished))?$projData[0]->isPublished:'f';
                // prepare element data
                $elementData = array(
                    'projId'   => $projectId,
                    'title'    => $postData['title'],
                    'article'  => $postData['article'],
                    'tags'     => $postData['tags'],
                    'isPublished'=>$isPublished,
                );
                if($arg_list['industry'] == 'reviews') {
                    $elementData['articleSubject'] = $postData['articleSubject'];
                }
                // set element's table prefix
                $elementTblPrefix = $this->config->item($indusrty.'Prifix');
                $elementTable = $elementTblPrefix.'Element';
                // add element data
                $elementId = $this->model_common->addDataIntoTabel($elementTable, $elementData);
            }
            if(!empty($projectId) && !empty($elementId)) {
                $nextUrl = '/uploaddisplayimage/'.$projectId.'/'.$elementId;
            }
        }

        echo json_encode(array('nextStep'=>$nextUrl));
    
    }
    
     //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to set display image
     * @access: public
     * @return: void
     */
    public function uploaddisplayimage($arg_list) {
    
         // get project id
        $projectId = $arg_list[1];
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // check project id is exists or not
        $projData = $this->checknewsnreview($indusrty,$projectId,$elementId);
        
        if( !empty($arg_list[3]) && $arg_list[3] == 1 ) {
            // set image path
            $imagePath        = $projData->imagePath;
             // set display image type
            $displayImageType = $projData->displayImageType;
           
            //call method for plupload css and js add
            $this->_pluploadjsandcss();
            $this->data['dirUploadMedia']   =  $this->dirUploadMedia.$indusrty.DIRECTORY_SEPARATOR.$projectId;
            $this->data['indusrtyName']     =  $indusrty; // industry name
            $this->data['imagePath']        =  (isset($imagePath))?$imagePath:''; // set image path
            $this->data['displayImageType'] =  (isset($displayImageType))?$displayImageType:0; // set image upload type
            if($this->data['displayImageType'] == 2) {
                $embeddUrl = $this->data['imagePath'];
            }
             $this->data['projectId']       = $projectId; // set project id 
            $this->data['elementId']        = $elementId; // set project element id 
            $this->data['indusrtyName']     = $indusrty; // set project indusrty Name
            $this->data['embeddUrl']        = (isset($embeddUrl))?$embeddUrl:''; // set embedd image 
            $this->data['innerPage']        =  'media/form/add_news_reviews'; // set view of stage 3
            $this->data['subInnerPage']     =  'media/form/news_review_display_image'; // set view name of sub-menu stage 3
            $this->data['s1menu']           =  'TabbedPanelsTabSelected'; // main menu selected 
            $this->data['addNewsReviewS2Menu']  =  'TabbedPanelsTabSelected'; // sub-menu selected
            $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase') ;
            $this->new_version->load('new_version','form/news_review_wizard',$this->data);
        } else {
            // manage display image options
            $this->newsreviewimageoption($arg_list,$projData);
        }
    }
    
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to show news or reviews image options
     * @access: public
     * @return: void
     */
     
    public function newsreviewimageoption($arg_list,$projData) {
         
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // get elements table info
        $displayImageType = $projData->displayImageType;
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        // set form parametres
        $this->data['dirUploadMedia']      = $this->dirUploadMedia.$indusrty.DIRECTORY_SEPARATOR.$projectId.DIRECTORY_SEPARATOR.'file';
        $this->data['displayImageType']    =  $displayImageType;
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase') ;
        $this->data['innerPage'] = 'media/form/add_news_reviews';
        $this->data['s1menu'] = 'TabbedPanelsTabSelected';
        $this->data['subInnerPage'] = 'media/form/news_review_image_options';
        $this->data['addNewsReviewS2Menu'] = 'TabbedPanelsTabSelected';
        $this->data['projectId']        = $projectId; // set project id 
        $this->data['elementId']        = $elementId; // set project element id
        $this->data['entityId']         =  getMasterTableRecord($elementTable);
        $this->new_version->load('new_version','form/news_review_wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to update display image options
     * @access: public
     * @return void
     */ 
    public function setnewsreviewimageoption() {
       
        $nextUrl = '';
        // get form post data
        $postData = $this->input->post();
        if(!empty($postData)) {
            $tableName    =   getMasterTableName($postData['entityId']);
            // set image type
            $data = array (
                'displayImageType'  => $postData['displayImageType'],
            );
            $this->model_common->editDataFromTabel($tableName[0], $data, 'elementId', $postData['elementId']);
            if($postData['displayImageType'] == 3 || $postData['displayImageType'] == 4) {
                $nextUrl = 'articleinfo/'.$postData['projectId'].'/'.$postData['elementId'];
            } else {
                $nextUrl = 'uploaddisplayimage/'.$postData['projectId'].'/'.$postData['elementId'].'/1';
            }
        }
        redirect($this->redirectUrl.$nextUrl);
    }
    
     //-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to stage "3" of media uploage stage - 1
    * @access: public
    * @return: void
    */
     
    public function newsreviewfilepost($arg_list) {
    
        $browseId           =   $this->input->post('browseId');
        $projectId          =   $this->input->post('projectId');
        $elementId          =   $this->input->post('elementId');
        $displayImageType   =   $this->input->post('displayImageType');
        $embbededURL        =   $this->input->post('embbededURL');
        $indusrtyName       =   $this->input->post('indusrtyName'.$browseId);
        $isExternalFile     =   false;
        //--------media data prepair for inserting------//
      
        $media_fileName     =   $this->input->post('fileName'.$browseId);
        
        if( $displayImageType == 2 && !empty($embbededURL)) {
             $isExternalFile    = true;
            $imagePath          = getUrl($embbededURL);
        } else {
            $isExternalFile     = false;
            $imagePath          = $this->dirUploadMedia.$arg_list['indusrty'].'/'.$projectId.'/images/'.$media_fileName;
        } 
        
        $mediaFileData  =  array('imagePath' => $imagePath);
        // set element table
        $elementTblPrefix = $this->config->item($arg_list['indusrty'].'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        $this->model_common->editDataFromTabel($elementTable, $mediaFileData, 'elementId', $elementId);
        
        //next page url
        $nextUrl  = '/articleinfo/'.$projectId.'/'.$elementId ;
        
        $msg='Display image uploaded successfully';
        set_global_messages($msg, $type='success', $is_multiple=true);
        $returnData = array('msg'=>$msg,'nextUrl'=>$nextUrl,'isExternalFile'=>$isExternalFile);
        echo json_encode($returnData);
    }
    

    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to stage "3" of media uploage stage - 3
     * @access: public
     * @return: void
     * @author: lokendra
     */
     
    public function articleinfo($arg_list) {
         
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // check project id is exists or not
        $projData = $this->checknewsnreview($indusrty,$projectId,$elementId);
       
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        $this->data['entityId'] = getMasterTableRecord($elementTable);
        $this->data['innerPage']        =  'media/form/add_news_reviews'; // set view of stage 3
        $this->data['subInnerPage']     =  'media/form/news_review_information'; // set view name of sub-menu stage 3
        $this->data['s1menu']           =  'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['addNewsReviewS3Menu'] = 'TabbedPanelsTabSelected';
        $this->data['projectId']        = $projectId; // set project id 
        $this->data['elementId']        = $elementId; // set project element id
        $this->data['otherElementRes']  = $otherElementRes; // set project element details
        $this->data['sectionId']        = $arg_list['sectionId'];
        $this->data['projCategory']     = (isset($projData->projCategory))?$projData->projCategory:0;
        $this->data['elementData']      = $projData;
        $this->new_version->load('new_version','form/news_review_wizard',$this->data);
    }
    
     /*
     * @Description: This method is use to check news or reviews data
     * @access: private
     * @return: void
     */
    private function checknewsnreview($indusrty,$projectId,$elementId) {
        // set element's table prefix
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        $projRes = $this->model_media->getnewsnreviewdata($elementTable,$projectId,$elementId);
      
        if(!empty($projRes)) {
            return $projRes[0];
        } else {
            redirectToNorecord404();
        }
    }
    
    public function getgenrelisting() {
        $industryId = $this->input->post('industryId');
        $genre = getGenerList(0,$industryId,lang(),'selectGenre');
        $genreHtml = '<ul class="billing_form width169 mt2 pl10 fl">
                        <li class="select">';
        $genreHtml.= form_dropdown('genreId', $genre, '','id="genreId" class="required" ');
        $genreHtml.= '</li></ul>';
        $genreHtml.=" <script>$('SELECT').selectBox(); </script>";
        echo $genreHtml;
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save elements information
     * @access: public
     * @return void
     */ 
    public function setnewsreviewinformation() {
        // get form post data
        $postData = $this->input->post();
        if(!empty($postData) && !empty($postData['entityId']) && !empty($postData['elementId'])) {
            // prepare data
            $elementData = array(
                'industryId'         => $postData['industryId'],
                'genreId'            => (!empty($postData['genreId']))?$postData['genreId']:0,
                'wordCount'          => (!empty($postData['wordCount']))?$postData['wordCount']:0,
                'languageId'         => (!empty($postData['languageId']))?$postData['languageId']:0,
                'producedInCountry'  => (!empty($postData['producedInCountry']))?$postData['producedInCountry']:0,
                'classification'     => (!empty($postData['classification']))?$postData['classification']:'',
            );
            
            if($postData['entityId'] == 95) {
                $elementData['articleSubject'] = $postData['articleSubject'];
            }
            
            // get table name
            $elementTable = getMasterTableName($postData['entityId']);
            // update element information 
            $this->model_common->editDataFromTabel($elementTable[0], $elementData, 'elementId', $postData['elementId']);
            $nextUrl = '/nextnewsreviewoptions/'.$postData['projectId'].'/'.$postData['elementId'];
            // set msg and msg type
            $msg = 'You have successfully added element information.';
            $type = 'success';
        } else {
            $nextUrl = '';
             // set msg and msg type
            $msg = 'Error during element information saving.';
            $type = 'error';
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$nextUrl));
    }
    
    function nextnewsreviewoptions($arg_list) {
         // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // check project id is exists or not
        $projData = $this->checknewsnreview($indusrty,$projectId,$elementId);
       
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        $this->data['entityId'] = getMasterTableRecord($elementTable);
        $this->data['innerPage']        =  'media/form/add_news_reviews'; // set view of stage 3
        $this->data['subInnerPage']     =  'media/form/next_news_review_options'; // set view name of sub-menu stage 3
        $this->data['s1menu']           =  'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['addNewsReviewS3Menu'] = 'TabbedPanelsTabSelected';
        $this->data['projectId']        = $projectId; // set project id 
        $this->data['elementId']        = $elementId; // set project element id
        $this->data['sectionId']        = $arg_list['sectionId'];
        $this->new_version->load('new_version','form/news_review_wizard',$this->data);
    }
    
     /*
    * @access: public
    * @description: This method is use to manage next selected option
    * @return: void
    */ 
    function movetonextnewsreviewstep($arg_list) {
        
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrtyName = $arg_list['indusrty'];
        // check project id is exists or not
        $projRes = $this->checknewsnreview($indusrtyName,$projectId,$elementId);
        // set index page redirect url
        $redirectUrl = base_url('media/'.$indusrtyName.'/'.$projectId);
        
        // get post form data
        $postData = $this->input->post();
        if(!empty($postData)) {
            if( $postData['nextOption'] == 1 ) {
                if(!empty($projectId)) {
                    $redirectUrl = base_url($this->redirectUrl.$projectId);
                }
            } else {
                $redirectUrl = base_url($this->redirectUrl.'newsreviewcoverimage/'.$projectId.'/'.$elementId);
            }
        }
        redirect($redirectUrl);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project album cover
     * @access: public
     * @return void
     */ 
    public function newsreviewcoverimage( $arg_list ) {
        // get project id
        $projectId = $arg_list[1];
       
        // get media industry type
        $indusrty = $arg_list['indusrty'];
         // set prefix
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        // get media element table name
        $mediaElementTbl = $elementTblPrefix.'Element';
        if(!empty($arg_list[2]) && (int)$arg_list[2] ) {
            // get element id
            $elementId = $arg_list[2];
        } else {
            // get project's element data list
            $projelementRes = $this->model_common->getDataFromTabel($mediaElementTbl, 'elementId',  array('projId'=>$projectId,'projectType'=>$industry),'','','');
            if(!empty($projelementRes)) {
                $elementId = $projelementRes[0]->elementId;
            }
        }
        // check project id is exists or not
        $projData = $this->checknewsnreview($indusrty,$projectId,$elementId);
       
        if(empty($elementTblPrefix)) {
            redirect($this->redirectUrl);
        }
    
        $projElements  = $this->model_media->getPojectNewsNReview($projectId,$mediaElementTbl);
       
        if(is_array($projElements) && count($projElements) > 0) {
            $this->data['projElements'] = $projElements;
        }
        
        $this->data['projectId']        = $projectId;
        $this->data['elementId']        = $elementId;
        $this->data['industry']         = $indusrty;
        $this->data['innerPage']        =  'media/form/add_news_reviews'; // set view of stage 3
        $this->data['subInnerPage']     =  'media/form/select_cover_image'; // set view name of sub-menu stage 3
        $this->data['s2menu']           =  'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['addCoverPageS1Menu'] = 'TabbedPanelsTabSelected';
        $this->data['coverPageS1Menu']  = 'TabbedPanelsTabSelected';
        $this->data['coverTitle']       = $this->lang->line('selectCoverImage');
        $this->data['isStage2']         = true; // set project id 
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/news_review_wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project Title and Description
     * @access: public
     * @return void
     */ 
    public function newsreviewtitlendesc( $arg_list ) {
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // check project id is exists or not
        $projData = $this->checknewsnreview($indusrty,$projectId,$elementId);
        $this->data['projData']         = $projData;
        $this->data['projectId']        = $projectId;
        $this->data['elementId']        = $elementId;
        $this->data['industry']         = $indusrty;
        $this->data['innerPage']        = 'media/form/add_news_reviews'; // set view of stage 3
        $this->data['subInnerPage']     = 'media/form/select_title_n_desc';
        $this->data['s2menu']           = 'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['addCoverPageS2Menu']  = 'TabbedPanelsTabSelected';
        $this->data['isStage2']         = true; // set project id 
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/news_review_wizard',$this->data);
    
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's collection info
     * @access: public
     * @return void
     */ 
    public function newsreviewcollectioninfo( $arg_list ) {
        // get project id
        $projectId = $arg_list[1];
         // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // check project id is exists or not
        $projData = $this->checknewsnreview($indusrty,$projectId,$elementId);
        $this->data['projData']         = $projData;
        $this->data['elementId']        = $elementId;
        $this->data['projectId']        = $projectId;
        $this->data['industry']         = $indusrty;
        $this->data['innerPage']        = 'media/form/add_news_reviews';
        $this->data['subInnerPage']     = 'media/form/select_collection_info';
        $this->data['addCoverPageS3Menu']  = 'TabbedPanelsTabSelected';
        $this->data['isStage2']         = true; // set project id 
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/news_review_wizard',$this->data);
    
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's collection info
     * @access: public
     * @return void
     */ 
    public function publishcollection( $arg_list ) {
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // check project id is exists or not
        $this->checknewsnreview($indusrty,$projectId,$elementId);
       
        $this->data['elementId']        = $elementId;
        $this->data['projId']           = $projectId;
        $this->data['industry']         = $indusrty;
        $this->data['userId']           = $this->userId;
        $this->data['isNewsReview']     = true;
        $this->data['projCategory']     = $arg_list['projCategory']; 
        $this->data['category']         = $arg_list['category'];
        $this->data['innerPage']        = 'media/form/preview_publish';
        $this->data['s3menu']           = 'TabbedPanelsTabSelected'; // main menu selected 
        $this->data['addCoverPageS3Menu']  = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('createYourMediaShowcase');
        $this->new_version->load('new_version','form/news_review_wizard',$this->data);
    
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage project's publish status
     * @access: public
     * @return void
     */ 
    public function publicisecollection($arg_list) {
        // get project id
        $projectId = $arg_list[1];
        // get element id
        $elementId = $arg_list[2];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // check project id is exists or not
        $projData = $this->checknewsnreview($indusrty,$projectId,$elementId);
        
        // set publish value
        $isPublished = ($projData->projpublish=='f') ? 't' : 'f';
        $saveData = array('isPublished'=>$isPublished);
        // update project's publish
        $this->model_common->editDataFromTabel('Project', $saveData, 'projId', $projectId);
        // change status of elements
        // set element's table prefix
        $elementTblPrefix = $this->config->item($indusrty.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        $saveData = array('isPublished'=>$isPublished);
        // update project's publish
        $this->model_common->editDataFromTabel($elementTable, $saveData, 'projId', $projectId);
        // set msg and msg type
        $msg = $this->lang->line('projectUnpublished');
        if($isPublished == 't') {
            $msg = $this->lang->line('projectPublished');
        }
        $type = 'success';
        set_global_messages($msg, $type, $is_multiple=true);
        redirect(base_url(lang().'/media/'.$indusrty.'/'.$projectId));
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get elements search 
     * @access: public
     * @return: void
     */
    public function searchshareelements($arg_list) {
        // get project id
        $projectId = $arg_list[1];
        // get media industry type
        $indusrty = $arg_list['indusrty'];
        // check project id is exists or not
        $projRes = $this->isprojectexists($projectId, $indusrty);
        // get element's table name
        $elementTblPrefix = $this->config->item( $indusrty.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        $isShareMenu = $arg_list[2];
        // get project's elements list
        $sampleTrailElementRes = $this->model_common->getDataFromTabel($elementTable, 'elementId,title,description,imagePath,elementType,displayImageType',  array('projId'=>$projectId,'isPublished'=>'t','isArchive'=>'f','isBlocked'=>'f','elementType !='=>'0'),'','','');
        $this->data['sampleNTrailData']   = $sampleTrailElementRes;
        $this->data['searchResult'] = $this->searchshareelementsresult(true,$indusrty,$projectId);
        $this->data['isShareMenu'] = (!empty($isShareMenu))?$isShareMenu:'';
        $this->load->view('form/elements_share_search',$this->data);
    }
    
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get elements search 
     * @access: public
     * @return: void
     */
    public function searchshareelementsresult($loadView=false,$indusrtyName='',$projectId=0) {
        
        // get element's table name
        $elementTblPrefix = $this->config->item( $indusrtyName.'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        $isSetCookie = setPerPageCookie('searchPerPageVal',$this->config->item('perPageRecord'));	
        $pages = new Pagination_new_ajax;
        // get project's elements list
        $elementResCounts = $this->model_media->getprojectelementdata($elementTable, $projectId);
        $pages->items_total = count($elementResCounts);
        $this->data['perPageRecord'] = $this->config->item('perPageRecord');
        $pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$isSetCookie;
        $pages->paginate();
        // get project's elements list
        $elementRes = $this->model_media->getprojectelementdata($elementTable, $projectId, $pages->limit, $pages->offst);
        
        $this->data['projectId'] = $projectId;  // set project id
        $this->data['indusrty'] = $indusrtyName; // set media industry type
        $this->data['items_total'] = $pages->items_total;
        $this->data['items_per_page'] = $pages->items_per_page;
        $this->data['pagination_links'] = $pages->display_pages();
        $pages->paginate($isShowButton=true,$isShowNumbers=false);
        $this->data['elementList']   = $elementRes;
        $this->data['projectId'] = $projectId;
        $searchResultView = $this->load->view('form/elements_share_search_result',$this->data,$loadView);
       if($loadView){
            return $searchResultView;
        }
    }
    
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to get elements short link 
     * @access: public
     * @return: string
     */
    public function getelementshortlink() {
         // set post data
        $projectId = $this->input->post('projectId');
        $elementId = $this->input->post('elementId');
        $shortLink = '';
        if( !empty($projectId) && !empty($projectId) ) {
            // prepare short link
            $shareURL = lang()."/mediafrontend/mediadetails/$this->userId/$projectId/$elementId";
            // get short code
            $shortLink = $this->model_common->getShortLink($shareURL,$this->userId);
        }
        echo $shortLink;
    }
    
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to create elements short link 
     * @access: public
     * @return: string
     */
    public function manageelementshortlink($arg_list,$projId) {
        // get element id
        $elementId = (int)$arg_list[2];
        // get element's table name
        $elementTblPrefix = $this->config->item( $arg_list['indusrty'].'Prifix');
        $elementTable = $elementTblPrefix.'Element';
        $elementShortLink = '';
        
        if(!empty($elementId)) {
            // check project id is exists or not
            $this->checknewsnreview($arg_list['indusrty'],$projId,$elementId);
        } else {
            // get project's elements list
            $projElementRes = $this->model_common->getDataFromTabel($elementTable, 'elementId',  array('projId'=>$projId,'isPublished'=>'t','isArchive'=>'f','isBlocked'=>'f','elementType'=>'0'),'',$orderBy='elementId',$order='DESC', $limit=1);
            //print_r($projElementRes);die;
            if(!empty($projElementRes)) {
                $elementId = $projElementRes[0]->elementId;
            }
        }
        if(!empty($elementId)) {
            // set  first elements short link
            $shareURL = lang()."/mediafrontend/mediadetails/$this->userId/$projId/$elementId";
            $elementShortLink = $this->model_common->getShortLink($shareURL,$this->userId);
        }
        return $elementShortLink;
    }
    
     //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to manage collection of news or reviews
     * @access: public
     * @return: string
     */
    public function editwizardcollection($industry='news') {
        
        $editUrl =  base_url(lang().'/home');
        if((!empty($industry)) && ($industry == 'news' || $industry == 'reviews')) {
            $projectId = '';
            // set default news or review url
            $editUrl =  base_url(lang().'/media/reviewswizard');
            if($industry == 'news') {
               $editUrl =  base_url(lang().'/media/newswizard');
            }
           
            // get project's list
            //$projRes = $this->model_common->getDataFromTabel('Project', 'projId',  array('tdsUid'=>$this->userId,'projectType'=>$industry,'userContainerId > '=> 0),'','','');
            $projRes = $this->model_common->getDataFromTabel('Project', 'projId',  array('tdsUid'=>$this->userId,'projectType'=>$industry,'isArchive'=>'f'),'','','');
           
            if(!empty($projRes)) {
                $projectId = $projRes[0]->projId;
            }
            if(!empty($projectId)) {
                $editUrl =  base_url(lang().'/media/reviewswizard/editproject/'.$projectId);
                if($industry == 'news') {
                   $editUrl =  base_url(lang().'/media/newswizard/editproject/'.$projectId);
                }
            }
        }
        redirect($editUrl);
    } 
    
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to check methods for add space request
     * @access: public
     * @return: string
     */
    private function _isaddspacerequest($methodName='') {
        if($methodName != 'membershipcart' && $methodName != 'billingdetails' && $methodName != 'purchasesummary' ) {
            // unset session values
            $this->session->unset_userdata('addSpaceProjectId');
            $this->session->unset_userdata('projectContainerId');
            $this->session->unset_userdata('projSellStatus');
        }
    }
    
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to get genre listing based of selected proj type
     * @access: public
     * @return: string
     */
    public function getgenreselectbox() {
        // get proj type
        $projType = $this->input->post('projType');
        $stateHtml = '';
         if($projType > 0) {
            $subgenre = getGenerList($projType,'selectGenre');
            $genreHtml .= form_dropdown('projGenre', $subgenre,'','id="projGenre" class="required" ');
             /* add default checkbox script */
            $genreHtml .= '<script type="text/javascript">radioCheckboxRender();</script>';
        }
        echo $genreHtml;
    }

        
}

/* End of file media.php */
/* Location: ./application/module/media/media.php */
