<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Todasquare notifications Controller Class
 *
 *  Manage Craves Functionality
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */

Class craves extends MX_Controller {
	
	/**
	 * Constructor
	 */
	 
	private $data = array();
	 
	function __construct(){
		parent::__construct();
		$this->load->language('craves'); 
		$this->load->model('craves/model_craves');	
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		//add advertising module if exists
		if(is_dir(APPPATH.'modules/advertising')){
			$this->load->model(array('advertising/model_advertising'));
		}
	}
	
	function index($projectType='all',$startFromWord=''){	
		$userId=$this->isloginUser();
		$this->cravedata($userId,$projectType,$startFromWord,true);
		
		$this->config->set_item("craves", $this->lang->line('myCraves'), $index="replacer");
		
		$ajaxRequest = $this->input->post('ajaxRequest');
		
		$this->data['activeheading']=$this->lang->line('myCraves');
		$this->data['myCraves']=$this->lang->line('myCraves');
		$this->data['cravingMe']=$this->lang->line('cravingMe');
		$this->data['currentMathod']='index';
		
		if($ajaxRequest){
			$this->data['ajaxRequest']=true;
			 $this->load->view('crave_list',$this->data) ;
		}			   
		else{
			$this->data['ajaxRequest']=false;
			//$this->template->load('template','craves',$this->data);	   //load template with media view
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_craves';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->new_version->load('new_version','craves',$this->data);
		}
	}
	
	function cravingme($projectType='all',$startFromWord=''){	
		$userId=$this->isloginUser();
		
		$this->cravedata($userId,$projectType,$startFromWord,true,true);
		
		$this->config->set_item("craves", $this->lang->line('myCraves'), $index="replacer");
		
		$ajaxRequest = $this->input->post('ajaxRequest');
		
		//$this->data['allCount']=$this->model_craves->craveList($userId,'','','',0,true,true,0,true);
		$this->data['activeheading']=$this->lang->line('cravingMe');
		$this->data['myCraves']=$this->lang->line('myCraves');
		$this->data['cravingMe']=$this->lang->line('cravingMe');
		$this->data['currentMathod']='cravingme';
		
		if($ajaxRequest){
			$this->data['ajaxRequest']=true;
			 $this->load->view('cravingme_list',$this->data) ;
		}			   
		else{
			$this->data['ajaxRequest']=false;
			//$this->template->load('template','cravingme',$this->data);	   //load template with media view
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_craves';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','cravingme',$this->data);
		}

	}
	
	function craveslist($userId=0,$projectType='',$startFromWord=''){	
		$this->config->set_item('craves', $this->lang->line('showcase'), 'replacer');
		
		$userId=$userId>0?$userId:isloginUser();
		
		if(!($userId >0)){
			redirect('home');
	    }else{
			$this->cravedata($userId,$projectType,$startFromWord,false);
			
			$breadcrumbItem=array('showcase','craveslist');
			$breadcrumbURL=array('showcase/aboutme/'.$userId,'craves/craveslist/'.$userId);
			$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
			
			$this->data['activeheading']=$this->lang->line('myCraves');
			$this->data['myCraves']=$this->lang->line('myCraves');
			$this->data['cravingMe']=$this->lang->line('cravingMe');
			$this->data['currentMathod']='craveslist'; 
			
			//manage advert types if exists
			if(is_dir(APPPATH.'modules/advertising')) {
				//Set advert section id
				$advertSectionId = $this->config->item('cravesSectionId');				    
			
				//Get banner records based on section and advert type
				$bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
				$bannerType5 = $this->model_advertising->getBannerRecords($advertSectionId,5,1);
				
				$this->data['advertSectionId'] = $advertSectionId; //set advert section id
				//Load view of advert js functions
				$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>'','bannerType2'=>'','bannerType3'=>'','bannerType4'=>$bannerType4,'bannerType5'=>$bannerType5,'sectionId'=>$advertSectionId),true);	
			} 
			
			$this->data['breadcrumbString']=$breadcrumbString;
			$ajaxRequest = $this->input->post('ajaxRequest');
			if($ajaxRequest){
				$this->data['ajaxRequest']=true;
				$this->load->view('craves_frontend_list',$this->data) ;
			}			   
			else{
				$this->data['ajaxRequest']=false;
				$this->template_front_end->load('template_front_end','craves/craves_frontend',$this->data);	
			}
			
		}
	}
	
	function cravingmefrontend($userId=0,$projectType='',$startFromWord=''){	
		
		$this->config->set_item('craves', $this->lang->line('showcase'), 'replacer');
		
		$userId=$userId>0?$userId:isloginUser();
		
		if(!($userId >0)){
			redirect('home');
	    }else{
			$this->cravingmeUser($userId,$projectType,$startFromWord);
			
			$breadcrumbItem=array('showcase','cravingmefrontend');
			$breadcrumbURL=array('showcase/aboutme/'.$userId,'craves/cravingmefrontend/'.$userId);
			$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
			
			$this->data['activeheading']=$this->lang->line('cravingMe');
			$this->data['myCraves']=$this->lang->line('myCraves');
			$this->data['cravingMe']=$this->lang->line('cravingMe');
			$this->data['currentMathod']='cravingmefrontend';
			
			//manage advert types if exists
			if(is_dir(APPPATH.'modules/advertising')) {
				//Set advert section id
				$advertSectionId = $this->config->item('cravesSectionId');				    
			
				//Get banner records based on section and advert type
				$bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
				$bannerType5 = $this->model_advertising->getBannerRecords($advertSectionId,5,1);
				
				$this->data['advertSectionId'] = $advertSectionId; //set advert section id
				//Load view of advert js functions
				$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType4'=>$bannerType4,'bannerType5'=>$bannerType5,'sectionId'=>$advertSectionId),true);	
			} 
			
			$this->data['breadcrumbString']=$breadcrumbString;
			$ajaxRequest = $this->input->post('ajaxRequest');
			if($ajaxRequest){
				$this->data['ajaxRequest']=true;
				$this->load->view('cravingme_frontend_list',$this->data);
			}			   
			else{
				$this->data['ajaxRequest']=false;
				$this->template_front_end->load('template_front_end','craves/cravingme_frontend',$this->data);	
			}
			
		}
	}
	
	function cravingmeUser($userId=0,$projectType='',$startFromWord=''){	
		$projectType=trim($projectType);
		if(strlen($projectType)==1){
			$startFromWord=	$projectType;
			$projectType='';
		}
		
		$this->data['craves']=false;
		$this->data['userId']=$userId;
		$this->data['projectType']=$projectType;
		$this->data['startFromWord']=$startFromWord;
		$this->data['craveSearch']=$searchKey=(trim($this->input->post('craveSearch'))==$this->lang->line('searchCraves') || trim($this->input->post('craveSearch'))==$this->lang->line('searchMembers'))?'':trim($this->input->post('craveSearch'));
		
		if($userId > 0){
			$projectType=($projectType=='all')?'':$projectType;
			
			$this->data['cravingMeCount']=$countResult=$this->model_craves->cravingmeUserList($userId,$projectType,$startFromWord,$searchKey,0,0,true);
			$this->data['myCravesCount']=$this->model_craves->craveList($userId,$projectType,$startFromWord,$searchKey,0,true);
			
			$this->data['countResult']=$countResult;
			$pages = new Pagination_ajax;
			$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
			$this->data['perPageRecord'] =$this->config->item('perPageRecordCraves');
			
			if($this->input->post('ipp')!=''){
				$isCookie = setPerPageCookie('cravesPerPageVal',$this->data['perPageRecord']);	
			}else {
				$isCookie = getPerPageCookie('cravesPerPageVal',$this->data['perPageRecord']);		
			}
			$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;			
			$pages->paginate();
			$this->data['items_total'] = $pages->items_total;
			$this->data['items_per_page'] = $pages->items_per_page;
			$this->data['pagination_links'] = $pages->display_pages();
			$this->data['craves']=$this->model_craves->cravingmeUserList($userId,$projectType,$startFromWord,$searchKey,$pages->limit,$pages->offst,false);
		}else{
			$this->data['craves']=false;
		}
		
	}
	
	function cravedata($userId=0,$projectType='',$startFromWord='',$work='',$cravingme=false){	
		$projectType=trim($projectType);
		if(strlen($projectType)==1){
			$startFromWord=	$projectType;
			$projectType='';
		}
		
		$this->data['projectWork']=$userId;
		
		
		$this->data['craves']=false;
		$this->data['userId']=$userId;
		$this->data['projectType']=$projectType;
		$this->data['startFromWord']=$startFromWord;
		$this->data['craveSearch']=$searchKey=(trim($this->input->post('craveSearch'))==$this->lang->line('searchCraves') || trim($this->input->post('craveSearch'))==$this->lang->line('searchMembers'))?'':trim($this->input->post('craveSearch'));
		$this->data['craveDropDwon']=$this->model_craves->craveDropDwon($userId,$cravingme);
		
		if($userId > 0){
			$projectType=($projectType=='all')?'':$projectType;
			
			$this->data['cravingMeCount']=$this->model_craves->cravingmeUserList($userId,$projectType,$startFromWord,$searchKey,0,0,true);
			$this->data['myCravesCount']=$countResult=$this->model_craves->craveList($userId,$projectType,$startFromWord,$searchKey,$limit=0,true,$work,0,$cravingme);
			
			
			$this->data['countResult']=$countResult;
			$pages = new Pagination_ajax;
			$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
			$this->data['perPageRecord'] =$this->config->item('perPageRecordCraves');
			//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
			
			// Add by Amit to set cookie for Results per page
			if($this->input->post('ipp')!=''){
				$isCookie = setPerPageCookie('cravesPerPageVal',$this->data['perPageRecord']);	
			}else {
				$isCookie = getPerPageCookie('cravesPerPageVal',$this->data['perPageRecord']);		
			}
						
			$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;			
			
			$pages->paginate();
			
			$this->data['items_total'] = $pages->items_total;
			$this->data['items_per_page'] = $pages->items_per_page;
			$this->data['pagination_links'] = $pages->display_pages();
			
			$this->data['craves']=$this->model_craves->craveList($userId,$projectType,$startFromWord,$searchKey,$pages->limit,$retrunRow=false,$work,$pages->offst,$cravingme);

		}else{
			$this->data['craves']=false;
		}
		
	}
	public function postCrave($elementId=0,$entityId=0) {
		$craveDone=false;                     
		$userId=isloginUser();
		$msg=$this->lang->line('sessionExpired');
		$craveCount=0;
		$cravedStatus=1;
		
		if($userId > 0){
			$data=$this->input->post('val1');
			if($data['elementId'] > 0 && $data['entityId'] >0){
				
				$where=array(
					'tdsUid'=>$userId,
					'entityId'=>$data['entityId'],
					'elementId'=>$data['elementId']
				);
				
				$res=$this->model_common->getDataFromTabel('LogCrave', 'craveId',  $where, '', $orderBy='', '', 1 );
				
				if($res){
					$res=$res[0];
					$craveId=$res->craveId;
					$this->model_common->deleteRowFromTabel('LogCrave', 'craveId',$craveId);
					$cravedStatus=0;
				}else{
					$inserdata=array(
						'tdsUid'=>$userId,
						'entityId'=>$data['entityId'],
						'elementId'=>$data['elementId'],
						'ownerId'=>$data['ownerId'],
						'projectType'=>$data['projectType'],
						'furteherDetails'=>$data['furteherDetails'],
						'sectionId'=>creaveSectionId($data['projectType'],$data['entityId'],$data['elementId']),
						'createDate'=>currntDateTime()
					);
					$this->model_common->addDataIntoTabel('LogCrave', $inserdata);
					$cravedStatus=1;
                    
                    if($data['entityId'] != 93){
                        $this->craveShowcase($userId,$data['ownerId']);
                    }
				}
				
				$where=array(
					'entityId'=>$data['entityId'],
					'elementId'=>$data['elementId']
				);
				$res=$this->model_common->getDataFromTabel('LogSummary', 'actId,craveCount',  $where, '', $orderBy='', '', 1 );
				if($res){
					$res=$res[0];
					$actId=$res->actId;
					$craveCount=($cravedStatus==1)?($res->craveCount+1):($res->craveCount-1);
					$updateData=array(
						'craveCount'=>$craveCount
					);
					$this->model_common->editDataFromTabel('LogSummary', $updateData, 'actId', $actId);
				}else{
					$craveCount=1;
					$insertData=array(
						'entityId'=>$data['entityId'],
						'elementId'=>$data['elementId'],
						'craveCount'=>$craveCount,
						'createDate'=>currntDateTime()
					);
					$this->model_common->addDataIntoTabel('LogSummary', $insertData);
				}
				$craveDone=true;
				$msg=$this->lang->line('cravedSuccessfully');
			}
		}
		echo json_encode(array('craveDone'=>$craveDone,'craveCount'=>$craveCount,'cravedStatus'=>$cravedStatus,'msg'=>$msg));
	}
    
    function craveShowcase($fromUserId=0, $toUserId=0){
        if((int)$fromUserId > 0 && (int)$toUserId > 0){
            $scData = $this->model_common->getDataFromTabel('UserShowcase', 'showcaseId,creative,associatedProfessional,enterprise,fans',  array('tdsUid'=>$toUserId) );
            if(isset($scData[0]->showcaseId)){
                $showcaseId = $scData[0]->showcaseId;
                $where=array(
					'tdsUid'=>$fromUserId,
					'entityId'=>93,
					'ownerId'=>$toUserId,
					'elementId'=>$showcaseId
				);
                $countResult = $this->model_common->countResult('LogCrave',  $where);
                if(!$countResult){
                    if($scData[0]->creative=='t'){
                        $projectType = 'creatives';
                    }elseif($scData[0]->associatedProfessional=='t'){
                        $projectType = 'associatedprofessionals';
                    }
                    elseif($scData[0]->enterprise=='t'){
                        $projectType = 'enterprises';
                    }else{
                        $projectType = 'fans';
                    }
                    $inserdata=array(
                        'tdsUid'=>$fromUserId,
                        'entityId'=>93,
                        'elementId'=>$showcaseId,
                        'ownerId'=>$toUserId,
                        'projectType'=>$projectType,
                        'furteherDetails'=>'{"projectId":"'.$showcaseId.'","table":"UserShowcase","primeryField":"showcaseId","fieldSet":"showcaseId as id,profileImageName as craveImage, firstName as craveTitle, creativeFocus as craveShortDescription, tagwords as tagwords","cacheFilePath":"cache/showcase/showcase_'.$toUserId.'.php"}',
                        'sectionId'=>creaveSectionId($projectType,93,$showcaseId),
                        'createDate'=>currntDateTime()
                    );
                    $this->model_common->addDataIntoTabel('LogCrave', $inserdata); 
                    $where=array(
                        'entityId'=>93,
                        'elementId'=>$showcaseId
                    );
                    $res=$this->model_common->getDataFromTabel('LogSummary', 'actId,craveCount',  $where, '', $orderBy='', '', 1 );
                    if(isset($res[0]->actId)){
                        $res=$res[0];
                        $actId=$res->actId;
                        $craveCount=($res->craveCount+1);
                        $updateData=array(
                            'craveCount'=>$craveCount
                        );
                        $this->model_common->editDataFromTabel('LogSummary', $updateData, 'actId', $actId);
                    }else{
                        $insertData=array(
                            'entityId'=>93,
                            'elementId'=>$showcaseId,
                            'craveCount'=>1,
                            'createDate'=>currntDateTime()
                        );
                        $this->model_common->addDataIntoTabel('LogSummary', $insertData);
                    }
                }
            }
        }
    }

    function test(){
        $sectionId  = creaveSectionId('product','49','242');
        var_dump($sectionId);
    }

    /*
	 ***********************************
	 *  This function is used to show myplaylist
	 *********************************** 
	 */ 
	
	function myplaylist(){
		
		$userId=$this->isloginUser();
		$getMyPlaylistCount = $this->model_craves->getMyPlaylistData($userId);
		$getMyPlaylistCount =  count($getMyPlaylistCount);;
		
		$pages = new Pagination_ajax;
		$pages->items_total = $getMyPlaylistCount;
		$perPage = $this->config->item('myPlaylistPerPage');
		
		$isSetCookie = setPerPageCookie('competitionEntryView',$perPage);		
		$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$isSetCookie;
		$pages->paginate();
		$this->data['perPageRecord'] = $pages->items_per_page;
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		$this->data['countTotal'] = $getMyPlaylistCount;
		
		$ajaxRequest = $this->input->post('ajaxRequest');
		
		$getMyPlaylistData = $this->model_craves->getMyPlaylistData($userId,$pages->offst,$pages->items_per_page);
		
		$this->data['activeheading']=$this->lang->line('myplaylist');
		$this->data['myCraves']=$this->lang->line('myplaylist');
		$this->data['cravingMe']=$this->lang->line('myplaylist');
		$this->data['currentMathod']='myplaylist';
		$this->data['myPlaylistData']=$getMyPlaylistData;
		$this->data['userId']=$userId;
		
		/* echo "<pre>";
		print_r($this->data['myPlaylistData']);die();*/
		
		if($ajaxRequest){
			$this->data['ajaxRequest']=true;
			 $this->load->view('myplaylist_frame',$this->data) ;
		}			   
		else{
			$this->data['ajaxRequest']=false;
			//$this->template->load('template','myplaylist',$this->data);	   //load template with media view
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_craves';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','myplaylist',$this->data);
		}
		
	}
	
	/*
	 *************************** 
	 * This function is used to remove music from playlist
	 *************************** 
	 */ 
	
	
	public function removeMusic() {
	
		$data=$this->input->post('val1');
		$elementId = $data['elementId'];
		$entityId = $data['entityId'];
		$ownerId = $data['ownerId'];
		$updateData = array(
						'deletedPlayList' => 't'
						);
		$this->model_common->editDataFromTabel('LogCrave', $updateData, array('elementId'=>$elementId,'entityId'=>$entityId,'tdsUid'=>$ownerId));
		$msg = 'Music removed Successfully.';
		echo json_encode(array('msg'=>$msg));
	}
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to show creave button method
    * @param: array
    * @return: string
    * @auther: lokendra
    */ 
    
    public function creavebutton($craveData){
        
       $buttonDesigntype = (!empty($craveData['buttonDesigntype']))?$craveData['buttonDesigntype']:'1';
        
        switch($buttonDesigntype){
        
            case "1":
                $this->load->view('crave_button_design',$craveData);
            break;
            
            case "2":
                $this->load->view('crave_button_design_2',$craveData);
            break;
        
        }
        
    }
	
	
}
