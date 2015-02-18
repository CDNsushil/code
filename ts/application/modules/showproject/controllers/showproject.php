<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//class showproject extends MY_Controller{
class showproject extends MX_Controller{
	private $data = array();
	private $dirCacheMedia = '';
	private $userId = null;
	
	public function __construct(){
        
        
		$load = array(
				'model'		=> 'showproject/model_showproject + tmail/model_tmail',
                'language' 	=> 'media',					
			);
		parent::__construct($load);	
		$this->userId= isLoginUser()?isLoginUser():0;
		
		//add advertising module if exists
		if(is_dir(APPPATH.'modules/advertising')){
			$this->load->model(array('advertising/model_advertising'));
		}
	}
	function index($userId=0,$projectType=''){	
		$this->config->set_item('showproject', $this->lang->line('showcase'), 'replacer');
		$this->config->set_item('index', $this->lang->line('otherProjects'), 'replacer');
		
		$userId=$userId>0?$userId:isloginUser();
		if(!($userId >0)){
			redirect('home');
	    }
		$projectType=trim($projectType);
		if(strlen($projectType)==1){
			$startFromWord=	$projectType;
			$projectType='';
		}
		$this->data['showProjects']=false;
		$this->data['userId']=$userId;
		$this->data['projectType']=$projectType;
		$this->data['showProjectsSearch']=$showProjectsSearch= (trim($this->input->post('showProjectsSearch'))==$this->lang->line('keywordSearch'))?'':trim($this->input->post('showProjectsSearch'));
		$this->data['spDropDwon']=$this->model_showproject->spDropDwon($userId);
		$this->data['showProjects']=$this->model_showproject->showProjects($userId,$projectType,$showProjectsSearch,$limit=0,$retrunRow=false);
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			
			//Set advert section id
			$advertSectionId = $this->config->item('otherProjectsSectionId');				    
		
			//Get banner records based on section and advert type
			$bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
			$bannerType5 = $this->model_advertising->getBannerRecords($advertSectionId,5,1);
			
			$this->data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType4'=>$bannerType4,'bannerType5'=>$bannerType5,'sectionId'=>$advertSectionId),true);	
		} 
		
		$breadcrumbItem=array('showcase','index');
		$breadcrumbURL=array('showcase/aboutme/'.$userId,'showproject/index/'.$userId);
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$this->data['breadcrumbString']=$breadcrumbString;
		
		$this->template_front_end->load('template_front_end','showproject',$this->data);	
	}
    
    //----------------------------------------------------------------------
    
    /*
    *  @description: This method is use to show user other project
    *  @param: $userId
    *  @param: $projectType
    *  @return: void
    *  @auther: lokendra meena
    */ 
    
    function othercollections($userId=0,$projectType='filmNvideo'){	
        $this->config->set_item('showproject', $this->lang->line('showcase'), 'replacer');
        $this->config->set_item('index', $this->lang->line('otherProjects'), 'replacer');
        
        $userId=$userId>0?$userId:isloginUser();
        if(!($userId >0)){
            redirect('home');
        }
        $projectType=trim($projectType);
        if(strlen($projectType)==1){
            $startFromWord=	$projectType;
            $projectType='';
        }
        $this->data['showProjects']=false;
        $this->data['userId']=$userId;
        $this->data['projectType']=$projectType;
        $this->data['showProjectsSearch']=$showProjectsSearch= (trim($this->input->post('showProjectsSearch'))==$this->lang->line('keywordSearch'))?'':trim($this->input->post('showProjectsSearch'));
        $this->data['spDropDwon']=$this->model_showproject->spDropDwon($userId);
        $this->data['showProjects']=$this->model_showproject->showProjects($userId,$projectType,$showProjectsSearch,$limit=0,$retrunRow=false);
        
        //manage advert types if exists
        if(is_dir(APPPATH.'modules/advertising')) {
            
            //Set advert section id
            $advertSectionId = $this->config->item('otherProjectsSectionId');				    
        
            //Get banner records based on section and advert type
            $bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
            $bannerType5 = $this->model_advertising->getBannerRecords($advertSectionId,5,1);
            
            $this->data['advertSectionId'] = $advertSectionId; //set advert section id
            //Load view of advert js functions
            $this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType4'=>$bannerType4,'bannerType5'=>$bannerType5,'sectionId'=>$advertSectionId),true);	
        } 
        
        $breadcrumbItem=array('showcase','index');
        $breadcrumbURL=array('showcase/aboutme/'.$userId,'showproject/index/'.$userId);
        $breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
        $this->data['breadcrumbString']=$breadcrumbString;
        $this->data['packagestageheading']          =   $this->lang->line($projectType.'_showcase');
        
        $this->new_version->load('new_version','showproject_new',$this->data);	
    }
    
    //------------------------------------------------------------------------
    
    public function form($entityId=0,$elementId=0){
		$this->userId= $this->isLoginUser();
		$entityId=$this->input->post('val1');
		$elementId=$this->input->post('val2');
		$projectType=$this->input->post('val2');
        $this->data['userId']=$this->userId;
        $this->data['entityId']=$entityId;
        $this->data['elementId']=$elementId;
        $this->data['projectType']=$projectType;
        $this->data['associativeCreatives']=$this->model_showproject->associativeCreatives ($entityId,$elementId);
        $this->load->view('form',$this->data);
    }
    
    function acceptShowProjectRequest(){
		$this->userId= $this->isLoginUser();
		$msgid=$this->input->post('reply_msg_id');
		$receiverid=$this->input->post('receiverid');
		if($msgid > 0){
			$whereField=array('msgid'=>$msgid,'receiverid'=>$this->userId,'senderid'=>$receiverid);
			$res=$this->model_common->getDataFromTabel($table='ShowProject', $field='*',  $whereField, '', '','', $limit=1 );
			if($res){
				$id=$res[0]->id;
				$elementid=$res[0]->elementid;
				$countShow=$this->model_common->editDataFromTabel($table='ShowProject', $data=array('status'=>'t'), $field=array('id'=>$id));
				$subject=$this->lang->line('re').' '.$this->lang->line('showRequest');
				$body=$this->lang->line('requestAccepted');
				$msg_id =  $this->model_tmail->reply_to_message($msgid,$this->userId,$receiverid,$body,1,$subject,1);
				echo $msg_id;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}
    function sendRequest(){
		$this->userId= $this->isLoginUser();
		if($this->input->post("recipientsId") && $this->input->post("entityId") && $this->input->post("elementId")){
			$entityId=$this->input->post("entityId");
			$elementId=$this->input->post("elementId");
			$recipients=$this->input->post("recipientsId");
			$subject=$this->input->post("subject");
			$body=$this->input->post("body");
			$type=$this->input->post("type");
			$type=($type >0)?$type:1;
			$msg_id = $this->model_tmail->send_new_message($this->userId,$recipients, $subject,$body,$priority=1,$type);
			if($msg_id > 0){
				
				$delWhere=array('msgid'=>$msg_id,'entityid'=>$entityId,'elementid'=>$elementId);
				$whereinField='receiverid';
				$whereinValue=$recipients;
				
				$this->model_common->deletelWhereWhereIn($table='ShowProject', $delWhere,  $whereinField, $whereinValue, $whereNotIn=0);
				foreach($recipients as $key=>$receiverid){
					$insertShowData[]=array(
											'msgid'=>$msg_id,
											'entityid'=>$entityId,
											'elementid'=>$elementId,
											'receiverid'=>$receiverid,
											'senderid'=>$this->userId,
											'status'=>'f'
										 );
				}
				$id=$this->model_common->insertBatch($table='ShowProject', $insertShowData);
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}
 }
