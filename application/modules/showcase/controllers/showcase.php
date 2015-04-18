<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare showcase Controller Class
 *  Manage showcase details (Showcase Homepage, Additional Information, Recommendations)
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */
class showcase extends MX_Controller {
	private $dirCacheShowcase = '';	
	private $dirUploadMedia = '';	
	private $showcaseTableName = 'UserShowcase';	
	private $project = 'Project';
	private $projectNewsTable ='ProjectNews';
	private $mediaFile = 'MediaFile';
	private $projectReviewsTable ='ProjectReviews';	 
	private $projectWork = 'Work';	
	private $projectProduct  = 'product';
	private $projectWorkprofile = 'WorkProfile';
	private $projectProfileSocialLink = 'ProfileSocialLink';
	private $recordId;
	private $userId;
	private $data; 
    private $dirUploadProfileMedia = ''; 
    private $dirUser = '';
    private $workprofileImagePath = '';
	/**
		 * Constructor
	**/
	function __construct(){	
		 $load = array(
				'model'		=> 'showcase/model_showcase + media/model_media + membershipcart/model_membershipcart',
				'library' 	=> 'form_validation + upload + session + lib_sub_master_media',
				'language' 	=> 'showcase',
				'helper' 	=> 'form + file',
                'library' => 'pagination_new_ajax'
		 );
		parent::__construct($load);
		$this->userId= isLoginUser();
		$this->dirCacheShowcase = 'cache/showcase/'; 
		$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/showcase/'; 
        $this->dirUploadProfileMedia = 'media/'.LoginUserDetails('username').'/profile_image/'; 
        $this->dirUser = 'media/'.LoginUserDetails('username').'/'; 
        $this->workprofileImagePath = "media/".LoginUserDetails('username')."/workProfile/" ;
		if(is_dir(APPPATH.'modules/advertising')){
			$this->load->model(array('advertising/model_advertising'));
		}
	}
	
	public function preview($userId=0,$multilangId=0,$mathod='aboutme') 
	{
		$this->isLoginUser();
		if($this->userId > 0 && ($userId==$this->userId)){
			
		}else{
			redirect('home');
		}
		$this->$mathod($userId,$multilangId);
	}
    
    public function index($userId=0,$multilangId=0,$page=''){	
		
       
        //check preivew by chache
        if(previewModeActive() && $userId!=isLoginUser() && !empty($userId)){
           set_global_messages('You can see only your showcase preview.', 'error', $is_multiple=true);
           redirect(base_url_lang('home'));
        }
        
        $userId=$userId>0?$userId:$this->userId;
       
        if(!($userId > 0)){
			redirectToNorecord404();
		}
        
		$showcaseRes=getUserShowcaseId($userId);
	
		 $isExterF =  $showcaseRes->isPublished;
		
		if( $isExterF == 'f' && previewModeActive()===false)
		{
				redirect(base_url_lang('home'));
		}
		
		$showcaseId=$showcaseRes->showcaseId;
		
		if(!((int)$showcaseId > 0)){
			redirectToNorecord404();
		}
        
        $moduleMathod=$this->router->fetch_method();
        $preview=($moduleMathod == 'preview')?1:0;
		 $checkPublished=( ($userId==$this->userId) && isset($preview) && $preview ==1)?false:true;
        
        if((int)$multilangId > 0 && $preview == 0){
			$checkLanguagePublished = $this->model_showcase->checkLanguagePublished($multilangId);
			if(empty($checkLanguagePublished)){
				redirectToNorecord404();
			}
		}
		
        $entityId=getMasterTableRecord('UserShowcase');
		$creative=$showcaseRes->creative;
		$associatedProfessional=$showcaseRes->associatedProfessional;
		$enterprise=$showcaseRes->enterprise;
		$fans=$showcaseRes->fans;

        $this->getShowcaseData($userId,$showcaseId);
        
        if(!(isset($this->data['showcaseData']->isPublished)) || ( $checkPublished && $this->data['showcaseData']->isPublished != 't') ){
			//redirect('craves/craveslist/'.$userId);
		}
		
		
		if($creative=='t'){
			$showcaseType = 'creative';
            $crvmePT= 'creatives';
            $SHC='';
            $UNC='red';
            $PIC='creave_profile';
            $this->data['memberHeading']=$this->lang->line('associatedenterprise');
            $this->data['industryId']=$this->config->item('creativesSectionId');
            $this->data['enterPriseName']=$this->data['showcaseData']->firstName.' '.$this->data['showcaseData']->lastName;
            
			$this->data['industryType']='creatives';
		} elseif($associatedProfessional=='t'){
			$showcaseType = 'professional';
            $crvmePT= 'associatedprofessionals';
            $SHC='clr_663399';
            $UNC='clr_663399';
            $PIC='creave_profile';
            $this->data['industryId']=$this->config->item('associateprofessionalSectionId');
			$this->data['industryType']='associatedprofessionals';
            $this->data['memberHeading']=$this->lang->line('associatedenterprise');
            $this->data['enterPriseName']=$this->data['showcaseData']->firstName.' '.$this->data['showcaseData']->lastName;
            
		} elseif($enterprise=='t'){
			$showcaseType = 'business';
            $crvmePT= 'enterprises';
            $SHC='green';
            $UNC='green';
            $PIC='bussines_profile';
            $this->data['memberHeading']=$this->lang->line('associatedmembers');
            $this->data['industryId']=$this->config->item('enterprisesSectionId');
			$this->data['industryType']='enterprises';
			$this->data['enterPriseName']=$this->data['showcaseData']->enterpriseName;
		} else{
			$showcaseType = 'fan';
            $crvmePT= 'fans';	
            $SHC='green';
            $UNC='red';
            $PIC='creave_profile';
            $this->data['memberHeading']='fans';
            $this->data['industryId']=$this->config->item('fansSectionId');	
            $this->data['enterPriseName']=$this->data['showcaseData']->firstName.' '.$this->data['showcaseData']->lastName;
            			    
		}
        $this->data['crvmePT']=$crvmePT;
		/* Manage view count */
		if((!empty($entityId)) && (!empty($showcaseId)) && (isset($showcaseType)) && (!empty($showcaseType))){
			$sectionId = $this->config->item($showcaseType.'SectionId');
			$proId = $showcaseId;
			manageViewCount($entityId,$showcaseId,$userId,$proId,$sectionId);
		}
        
        $this->data['entityId']=$entityId;
		$this->data['userId']=$userId;
        $this->data['showcaseId']=$showcaseId;
        $this->data['mathod']=$moduleMathod;
        $this->data['checkPublished']=$checkPublished;
        $this->data['sectionHeading']=$this->lang->line($showcaseType);
        $this->data['showcaseType']=$showcaseType;
        $this->data['SHC']=$SHC;
        $this->data['UNC']=$UNC;
        $this->data['PIC']=$PIC;
        $this->data['creativeArea']=$this->data['showcaseData']->optionAreaName;
        $this->data['enterPriseName']=($enterprise=='t')?$this->data['showcaseData']->enterpriseName : $this->data['showcaseData']->firstName.' '.$this->data['showcaseData']->lastName;
        
        $wherplaylist = array(
                                'tdsUid'=>$userId,
                                'entityId'=>getMasterTableRecord('MaElement'),
                             );
        $this->data['countPlaylistSongs'] = $this->model_common->countResult('MediaPlaylist', $wherplaylist);

        //To show social icons of showcase
		$socialMediaCondition = array('userId'=>$userId,'showcaseId'=>$showcaseId,'socialLinkArchived'=>'f');
		$this->data['userSocialLinks'] = $this->model_showcase->getSocialMediaLinks($socialMediaCondition);
        
        if($this->data['showcaseData']->recommendMe == 't'){
            $this->data['recommendationList']= $this->model_common->recommendations(array('Recommendations.is_show_in_showcase'=>'t','to_userid'=>$userId));
        }else{
            $this->data['recommendationList'] = false;
        }
        if($this->data['showcaseData']->reviewMe == 't'){
            $this->data['reviewList']= $this->model_common->getUsersReview($entityId,$showcaseId);
        }else{
            $this->data['reviewList'] = false;
        }
        $whereReviewsNews = array('entityId' => $entityId,'elementId'=>$showcaseId);
        //$this->data['externalReviews'] = $this->model_common->getDataFromTabel('AddInfoReviews', '*',  $whereReviewsNews, '', 'reviewId', 'DESC');
        $this->data['externalNews'] = $this->model_common->getDataFromTabel('AddInfoNews', '*',  $whereReviewsNews, '', 'newsId', 'DESC');
        
        $this->data['multilingualList'] = $this->model_showcase->getUserMultiLangList($userId);
        $this->data['multilingualShowcaseId'] = (isset($multilangId) && (int)$multilangId>0)?$multilangId:0;
		if(empty($page)){
			if((isset($showcaseRes->promotionalsection)) && !empty($showcaseRes->promotionalsection)){
                $page = 'aboutme';
            }
            elseif((isset($showcaseRes->introductoryFileId)) && ($showcaseRes->introductoryFileId>0)){
				$page = 'videos';
			}elseif((isset($showcaseRes->interviewFileId)) && ($this->data['externalNewsFlag']<1) && ($this->data['externalReviewsFlag']<1) && (strlen($showcaseRes->creativePath) < 5) && (strlen($showcaseRes->promotionalsection) < 5) && ($showcaseRes->introductoryFileId==0)){
					$page = 'interview';
            }
            elseif(($showcaseRes->interviewFileId==0) && ($this->data['externalNewsFlag']==0) && ($this->data['externalReviewsFlag']==0) && (strlen($showcaseRes->creativePath) > 4) && (strlen($showcaseRes->promotionalsection) < 5) && ($showcaseRes->introductoryFileId==0)){
                $page = 'developementpath';
            }
            else{
                $page = 'aboutme';
            }
		}
		
		$this->data['page']=$page;
		$this->data['innerContent'] = '';
        
        if($page=='aboutme'){
            if((int)$multilangId > 0){
                $multilingualDetails = $this->model_showcase->getUserShowcaseLang($userId,$multilangId);
                if(isset($multilingualDetails->promotionalsection) && !empty($multilingualDetails->promotionalsection)){
                    $this->data['innerContent'] = $multilingualDetails->promotionalsection;
                }
            }else{
                $this->data['innerContent']=$this->data['showcaseData']->promotionalsection;
            }
            $this->data['pageheading'] = $this->lang->line('ABOUTME');
            $this->data['topHeader'] = 'showcase/showcase/multilingual_header';
            $this->data['innerPageData']=$this->load->view('showcase/showcase/aboutme',array('innerContent'=>$this->data['innerContent'],'page'=>$page),true);
        }
        elseif($page=='developementpath'){
            if((int)$multilangId > 0){
                $mypathData = $this->model_showcase->getUserShowcaseLang($userId,$multilangId);
            }else{
                $mypathData = $this->data['showcaseData'];
            }
            $this->data['pageheading'] = $this->lang->line('MYPATH');
            $this->data['topHeader'] = 'showcase/showcase/multilingual_header';
            $this->data['innerPageData']=$this->load->view('showcase/showcase/mypath',$mypathData,true);
		}elseif($page=='videos'){
            $fileId_In= array();
            $videoDataArray = false;
            if(is_numeric($this->data['showcaseData']->introductoryFileId) && (int)$this->data['showcaseData']->introductoryFileId > 0){
                $fileId_In[] = $this->data['showcaseData']->introductoryFileId;
                $videoDataArray['videoData']['introductoryFileId'] = true;
            }
            if(is_numeric($this->data['showcaseData']->interviewFileId) && (int)$this->data['showcaseData']->interviewFileId > 0){
                $fileId_In[] = $this->data['showcaseData']->interviewFileId;
                $videoDataArray['videoData']['interviewFileId'] = true;
            }
            if(is_array($fileId_In) && !empty($fileId_In)){
                 $videoData=$this->model_common->getDataFromTabelWhereIn('MediaFile', '*', 'fileId', $fileId_In);
            }else{
                 $videoData=false;
            }
            $videoDataArray['videoData']['entityId'] = $this->data['entityId'];
            $videoDataArray['videoData']['showcaseId'] = $this->data['showcaseId'];
            
            $videoDataArray['videoData']['videoData'] = $videoData;
            $this->data['innerPageData']=$this->load->view('showcase/showcase/videos',$videoDataArray,true);
		}
		elseif($page=='associatedmembers'){
			$this->data['associatedmembers'] = $this->model_showcase->getAssociatedMembers($showcaseId);
            $this->data['innerPageData']=$this->load->view('associatedprofessionals',array('associatedmembers'=>$this->data['associatedmembers']),true);
		}elseif($page=='mypaylist'){
            $this->mypaylistview($userId,0);
    	}elseif($page=='mycraves'){
			$this->cravedata($userId);
            $this->data['innerPageData']=$this->load->view('showcase/showcase/craves',$this->data,true);
		}elseif($page=='cravingme'){
			$this->cravedata($userId,true,$crvmePT);
            $this->data['innerPageData']=$this->load->view('showcase/showcase/cravingme',$this->data,true);
		}
        $this->new_version->load('new_version','showcase/showcase/index',$this->data);
	}
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to playlist show
    * @auther: lokendra meena
    * @return: void
    */ 
    
    public function mypaylistview($userId,$isPlayAll=0){
        
        //get auto play action 
        $action     =  ($this->input->get('action'))?$this->input->get('action'):"";
        if($action=="play"){
            $isPlayAll = 1;
        }
        
        $industryType = 'musicNaudio';
        $userPlaylistData                   =   $this->model_media->myplaylist($userId);
        $playlistData['userPlaylistData']   =   $userPlaylistData;
        $playlistData['tdsUid']             =   $userId;
        $playlistData['isPlayAll']          =   $isPlayAll;
        $playlistData['fileConfig']         =   $this->config->item($industryType.'FileConfig');
        $playlistData['imagetype_s']        =   $this->config->item('musicNaudioImage_s');
        if($this->input->is_ajax_request()){
            $this->load->view('showcase/showcase/myplaylist_view',$playlistData);
        }else{
            $this->data['innerPageData']        =   $this->load->view('showcase/showcase/myplaylist_view',$playlistData,true);
        }
    }
    
    
    
    private function cravedata($userId=0,$cravingme=false,$crvmePT=''){	
		
		$this->data['craves']=false;
		$this->data['userId']=$userId;
		$this->data['projectType'] =  $projectType = $this->input->post('projType');
        $this->data['projType2'] =  $projType2 = $this->input->post('projType2');
        if(!empty($projType2)){
             $projectType = $projType2;
        }
        $projectType=trim($projectType);
        $this->data['craveSearch']=$searchKey=(trim($this->input->post('craveSearch'))==$this->lang->line('keywords'))?'':trim($this->input->post('craveSearch'));
		
        //$this->data['craveDropDwon']=$this->model_showcase->craveDropDwon($userId,$cravingme);
		
		if((int)$userId > 0){
			$projectType=(empty($projectType) || ($projectType =='all') || ($projectType === 0))?'':$projectType;
           
			if($cravingme){
                $countResult = $this->data['cravingMeCount']=$this->model_showcase->cravingme($userId,$crvmePT,$projectType,$searchKey,0,0,true);
            }else{
                $countResult = $this->data['myCravesCount']=$this->model_showcase->craveList($userId,$projectType,$searchKey,0,0,true);
            }
			
			$pages = new Pagination_new_ajax;
			$pages->items_total = $countResult; // this is the COUNT(*) query that gets the total record count from the table you are querying
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
            $this->data['countResult']=$countResult;
            
			if($cravingme){
                $this->data['craves'] = $this->model_showcase->cravingme($userId,$crvmePT,$projectType,$searchKey,$pages->limit,$pages->offst);
            }else{
                $this->data['craves'] =  $this->model_showcase->craveList($userId,$projectType,$searchKey,$pages->limit,$pages->offst);
            }

		}else{
			$this->data['craves']=false;
		}
		
	}
    
    public function mycraves($userId=0){
        $userId=$userId>0?$userId:isloginUser();
		if(!((int)$userId >0)){
			redirect('home');
	    }else{
			$ajaxRequest = $this->input->post('ajaxRequest');
			if($ajaxRequest){
                
                $this->cravedata($userId);
                $this->data['ajaxRequest']=true;
                $this->load->view('showcase/showcase/mycraves_list',$this->data) ;
			}			   
			else{
				$this->data['ajaxRequest']=false;
                $this->data['topHeader'] = 'showcase/showcase/crave_header';
                $this->index($userId,0,'mycraves');
			}
		}
    }
    
    public function cravingme($userId=0,$crvmePT=''){
        $userId=$userId>0?$userId:isloginUser();
		if(!((int)$userId >0)){
			redirect('home');
	    }else{
			$ajaxRequest = $this->input->post('ajaxRequest');
			if($ajaxRequest){
                $this->cravedata($userId,true,$crvmePT);
                $this->data['ajaxRequest']=true;
                $this->data['crvmePT']=$crvmePT;
                $this->load->view('showcase/showcase/cravingme_list',$this->data);
			}			   
			else{
				$this->data['ajaxRequest']=false;
                $this->data['topHeader'] = 'showcase/showcase/crave_header';
                $this->index($userId,0,'cravingme');
			}
		}
    }
	
	public function index_old($userId=0,$multilangId=0,$page='')
	{	
		$userId=$userId>0?$userId:$this->userId;
		
		if(!($userId > 0)){
			redirectToNorecord404();
		}
        $preview=($moduleMathod == 'preview')?1:0;
	
		/* Update view count */
		$viewEntityId = getMasterTableRecord('UserShowcase');
		$showcaseRes=getUserShowcaseId($userId);
		
		$showcaseId=$showcaseRes->showcaseId;
		if(!((int)$showcaseId > 0)){
			redirectToNorecord404();
		}
        
        if((int)$multilangId > 0 && $preview == 0){
			$checkLanguagePublished = $this->model_showcase->checkLanguagePublished($multilangId);
			if(empty($checkLanguagePublished)){
				redirectToNorecord404();
			}
		}
		
		$creative=$showcaseRes->creative;
		$associatedProfessional=$showcaseRes->associatedProfessional;
		$enterprise=$showcaseRes->enterprise;
		$fans=$showcaseRes->fans;
		$viewElementId=$showcaseRes->showcaseId;
		
		$moduleMathod=$this->router->fetch_method();
		$this->data['mathod']=$moduleMathod;
		
		$checkPublished=( ($userId==$this->userId) && isset($preview) && $preview ==1)?false:true;
		
		
		$this->config->set_item('index', $this->lang->line('showcaseHomepage'), 'replacer');
		
		$entityId=getMasterTableRecord('UserShowcase');
		$this->data['entityId']=$entityId;
		$this->data['userId']=$userId;

	
	/*Get Users showcase area */
		if($creative=='t'){
			$showcaseType = 'creatives';
		} elseif($associatedProfessional=='t'){
			$showcaseType = 'associateprofessional';
		} elseif($enterprise=='t'){
			$showcaseType = 'enterprises';					    
		} elseif($fans=='t'){
			$showcaseType = 'fans';					    
		}
			
		/* Manage view count */
		if((!empty($viewEntityId)) && (!empty($viewElementId)) && (isset($showcaseType)) && (!empty($showcaseType))){
			/*Get Section id */
			$sectionId = $this->config->item($showcaseType.'SectionId');
			/*Get Entity id */
			$proId = $viewElementId;
			manageViewCount($viewEntityId,$viewElementId,$userId,$proId,$sectionId);
		}
		
        $this->data['showcaseId']=$showcaseId;
		$this->getCacheFileData($userId,$showcaseId);
		
		if($checkPublished && $this->data['showcaseData']['isPublished']!='t'){
			redirect('craves/craveslist/'.$userId);
		}
		
		$this->data['checkPublished']=$checkPublished;
		
		$whereReviewsNews = array('entityId' => $entityId,'elementId'=>$showcaseId);
		$this->data['externalReviewsFlag'] = $this->model_common->countResult('AddInfoReviews',   $whereReviewsNews,'reviewId', '', 1);
		
		if(!$this->data['externalReviewsFlag']){
			$whereReviewsElement = array('entityId' => $entityId,'projectElementId'=>$showcaseId,'isPublished'=>'t');
			$this->data['externalReviewsFlag']=countResult('ReviewsElement',$whereReviewsElement);	
		}
		
		$this->data['externalNewsFlag'] = $this->model_common->countResult('AddInfoNews',  $whereReviewsNews, 'newsId','', 1);
		
        
        
		if(empty($page)){
			/* set Users Showcase home page default menu*/
			$getUserShowcase = $showcaseRes;
			//echo "<pre>";
			//print_r($getUserShowcase);die;
			if((isset($getUserShowcase->introductoryFileId)) && ($getUserShowcase->introductoryFileId>0)){
				$page = 'introductoryvideo';
			}else{
				if((isset($getUserShowcase->interviewFileId)) && ($this->data['externalNewsFlag']<1) && ($this->data['externalReviewsFlag']<1) && (strlen($getUserShowcase->creativePath) < 5) && (strlen($getUserShowcase->promotionalsection) < 5) && ($getUserShowcase->introductoryFileId==0)){
					$page = 'interview';
				}
				elseif(($getUserShowcase->interviewFileId==0) && ($this->data['externalNewsFlag']>0) && ($this->data['externalReviewsFlag']==0) && (strlen($getUserShowcase->creativePath) < 5) && (strlen($getUserShowcase->promotionalsection) < 5) && ($getUserShowcase->introductoryFileId==0)){
					$page = 'news';
				}
				elseif(($getUserShowcase->interviewFileId==0) && ($this->data['externalNewsFlag']==0) && ($this->data['externalReviewsFlag']>0) && (strlen($getUserShowcase->creativePath) < 5) && (strlen($getUserShowcase->promotionalsection) < 5) && ($getUserShowcase->introductoryFileId==0)){
					$page = 'reviews';
				}
				elseif(($getUserShowcase->interviewFileId==0) && ($this->data['externalNewsFlag']==0) && ($this->data['externalReviewsFlag']==0) && (strlen($getUserShowcase->creativePath) > 4) && (strlen($getUserShowcase->promotionalsection) < 5) && ($getUserShowcase->introductoryFileId==0)){
					$page = 'developementpath';
				}
				else{
					$page = 'aboutme';
				}
			}
		}
		
		$this->data['page']=$page;
		
		
		$breadcrumbItem=array('showcase','showcasehomepage',$page);
		$breadcrumbURL=array('showcase/aboutme/'.$userId,'showcase/aboutme/'.$userId,'showcase/'.$page.'/'.$userId);
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$this->data['breadcrumbString']=$breadcrumbString;
		
		
		
		//To show social icons of showcase
		$socialMediaCondition = array('userId'=>$userId,'for'=>'showcase');
		$this->data['userSocialLinks'] = $this->model_showcase->getSocialMediaIcon($socialMediaCondition);
		//echo '<pre />';print_r($this->data['showcaseData']);die;
		
		if($associatedProfessional=='t'){
			$this->data['headerClass']='bg_Show_enter_asso';
			$this->data['headingClass']='CSEprise_cat Fright clr_3f585f mr13 text_shadow30';
			$this->data['sectionHeading']=$this->lang->line('associatedprofessional'); 
			$this->data['enterPriseName']=$this->data['showcaseData']['firstName'].' '.$this->data['showcaseData']['lastName'];
			$this->data['creativeArea']=$this->data['showcaseData']['optionAreaName'];
			$this->data['memberHeading']=$this->lang->line('associatedenterprise');
			$this->data['industryId']=$this->config->item('associateprofessionalSectionId');
			$this->data['industryType']='associatedprofessionals';
			//$this->associatedprofessionals($userId,$showcaseId);
		}
		elseif($enterprise=='t'){
			$this->data['headerClass']='bg_Show_enter';
			$this->data['headingClass']='CSEprise_cat Fright clr_3e484a mr13';
			$this->data['sectionHeading']=$this->lang->line('enterpriseLower');
			$this->data['enterPriseName']=$this->data['showcaseData']['enterpriseName'];
			$this->data['creativeArea']=$this->data['showcaseData']['optionAreaName'];
			$this->data['memberHeading']=$this->lang->line('associatedmembers');
			$this->data['industryId']=$this->config->item('enterprisesSectionId');
			$this->data['industryType']='enterprises';
			//$this->enterprises($userId,$showcaseId);
		}else{
			$this->data['headerClass']='bg_Show_enter_dev';
			$this->data['headingClass']='CSEprise_cat Fright clr_484543 mr13';
			$this->data['sectionHeading']=$this->lang->line('creativeLower');
			$this->data['enterPriseName']=$this->data['showcaseData']['firstName'].' '.$this->data['showcaseData']['lastName'];
			$this->data['creativeArea']=$this->data['showcaseData']['optionAreaName'];
			$this->data['memberHeading']=$this->lang->line('associatedenterprise');
			$this->data['industryId']=$this->config->item('creativesSectionId');
			$this->data['industryType']='creatives';
		}
		$this->data['amSelected']=$this->data['ivSelected']=$this->data['mvSelected']=$this->data['nsSelected']=$this->data['rsSelected']=$this->data['dpSelected']='';
		if($page=='aboutme' || $page=='developementpath'){
			if($page=='aboutme'){
				if($multilangId!=0){
					$multilingualDetails = $this->model_showcase->getUserShowcaseLang($userId,$multilangId);
					if(isset($multilingualDetails->promotionalsection) && !empty($multilingualDetails->promotionalsection)){
						$this->data['innerContent'] = $multilingualDetails->promotionalsection;
						
					}else{
						$this->data['innerContent'] = '';
						
					}
					$this->data['amSelected']='CSEselected';
				}else{
					$this->data['innerContent']=$this->data['showcaseData']['promotionalsection'];
					$this->data['amSelected']='CSEselected';
				}
			}
			elseif($page=='developementpath'){
				if($multilangId!=0){
					$multilingualDetails = $this->model_showcase->getUserShowcaseLang($userId,$multilangId);
					if(isset($multilingualDetails->creativePath) && !empty($multilingualDetails->creativePath)){
						$this->data['innerContent'] = $multilingualDetails->creativePath;
					}else{
						$this->data['innerContent'] = '';
					}
					$this->data['dpSelected']='CSEselected';
				}else{
					$this->data['innerContent']=$this->data['showcaseData']['creativePath'];
					$this->data['dpSelected']='CSEselected';
				}
			}
			$this->data['innerContent']=trim($this->data['innerContent']);
			if($this->data['innerContent'] == ''){
				$this->data['innerPageData']=false;
			} 
			else{ 
				$this->data['innerPageData']=$this->load->view('showcase_aboutme_developementpth',array('innerContent'=>$this->data['innerContent'],'page'=>$page),true);
			}
			
		}elseif($page=='introductoryvideo' || $page=='interview'){
			$mediaFile=false;
			if($page=='introductoryvideo'){
				$this->data['ivSelected']='CSEselected';
				if($this->data['showcaseData']['introductoryFileId'] > 0){
					$mediaFile=getDataFromTabel($table='MediaFile', $field='*',  $whereField=array('fileId'=>$this->data['showcaseData']['introductoryFileId']), '', $orderBy='', $order='', $limit=1 );
				}
				$videoData=array(
									'fileId'=>$this->data['showcaseData']['introductoryFileId'],
									'videoTitle'=>@$this->data['showcaseData']['introductoryTitle'],
									'videoDescription'=>nl2br(@$this->data['showcaseData']['introductoryDescription']),
									'isVideoData'=>true
								);
			}
			elseif($page=='interview'){
				$this->data['mvSelected']='CSEselected';
				
				if($this->data['showcaseData']['interviewFileId'] > 0){
					$mediaFile=getDataFromTabel($table='MediaFile', $field='*',  $whereField=array('fileId'=>$this->data['showcaseData']['interviewFileId']), '', $orderBy='', $order='', $limit=1 );
				}
				$videoData=array(
									'fileId'=>$this->data['showcaseData']['interviewFileId'],
									'videoTitle'=>@$this->data['showcaseData']['interviewTitle'],
									'videoDescription'=>nl2br(@$this->data['showcaseData']['interviewDescription']),
									'isVideoData'=>true
								);		
			}
			if($mediaFile){
				$mediaFile=$mediaFile[0];
				$filePath=$mediaFile->filePath;
				$fileName=$mediaFile->fileName;
				$rawFileName=$mediaFile->rawFileName;
				$fileSize=$mediaFile->fileSize;
				$isExternal=$mediaFile->isExternal;
				$fileId=$videoData['fileId'];
				
				/******here assign all media data start***********/
					//$mediaArray['mediaId']=$fileId.'_full'; // media file Id
					$mediaId = $fileId;
					//$mediaArray['loginUserID']=isLoginUser(); // login user Id
					$entityId=$entityId; // entity Id
					$elementId=$showcaseId; //element id
					$projectId=$showcaseId; // project id
					$mediaArray['width']='660'; // width
					$mediaArray['height']='335'; // height
				/******here assign all media data end***********/
				if($isExternal=='t'){
					$fileType='external';
					$embedCode=$filePath;
					$file=urlencode($embedCode);
					$fileDirPath='';
					$videoData['rawFileName']='';
					$videoData['fileSize']=0;
					
					$iframeSrc=explode('src="',$filePath);
					if(isset($iframeSrc[1])){
						$iframeSrc=explode('"',$iframeSrc[1]);
						if(isset($iframeSrc[0])){
							$iframeSrc=$iframeSrc[0];
						}else{
							$iframeSrc="";
						}
					}else{
						$iframeSrc="";
					}
					
					//$videoData['videoFile'] = Modules::run("player/getPlayer", $mediaArray);
					
					/****************Show get introductry video code here************/
					
							$tableName = getMasterTableName('42');
								
								$mediaTableName= $tableName[0];
								
										 
								//get media file type 
								$getType = $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType,isExternal,filePath',  $whereField='fileId', $whereValue=$mediaId, $orderBy='fileId', $order='ASC', $whereNotIn=0);
								if($getType[0]['isExternal']=="t")
								{
									//this section is for external video
									$getMediaUrlData = getMediaUrl($getType[0]['filePath']);
									
									if($getMediaUrlData['isUrl'])
									{
										//url is valid 
										$headerDetails = @get_headers($getType[0]['filePath'],1);
										if(isset($headerDetails['X-Frame-Options']))
										{
											// This code will show error 
											$src = base_url().'en/player/videoError/';

										}else
										{
											// This code will play url 
											$src = $getType[0]['filePath'];

										}
										 
									}else
									{	
										$getSrc = $getMediaUrlData['getsource'];
										if($getMediaUrlData['embedtype'] == 'iframe')
										{
											 // This code will play embeded ifram code
											 $src = $getSrc;
										}else
										{
											// This code will play other type of embed code
											$src = base_url().'en/player/commonPlayerIframe/'.$mediaId.'_full/'.$elementEntityId.'/'.$elementId.'/'.$projectId;
										} 
									} 
									  
								}else
								{
									$src = base_url().'en/player/getPlayerIframe/'.$mediaId.'_full/'.$entityId.'/'.$elementId.'/'.$projectId;
								}
								
					$videoData['videoFile'] =   ' <iframe src="'.$src.'" width="660" height="335" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>';			
					/****************Show get introductry video code here************/
					
					
				}else{
					$fileType=2;
					$fileDirPath=$file=$filePath.$fileName;
					$embedCode='';
					$videoData['rawFileName']=$rawFileName;
					$videoData['fileSize']=$fileSize;
					
					//$videoData['videoFile'] = Modules::run("player/getPlayer", $mediaArray);
					
					/****************Show get introductry video code here************/
					
							$tableName = getMasterTableName('42');
								
								$mediaTableName= $tableName[0];
								
										 
								//get media file type 
								$getType = $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType,isExternal,filePath',  $whereField='fileId', $whereValue=$mediaId, $orderBy='fileId', $order='ASC', $whereNotIn=0);
								if($getType[0]['isExternal']=="t")
								{
									//this section is for external video
									$getMediaUrlData = getMediaUrl($getType[0]['filePath']);
									
									if($getMediaUrlData['isUrl'])
									{
										//url is valid 
										$headerDetails = @get_headers($getType[0]['filePath'],1);
										if(isset($headerDetails['X-Frame-Options']))
										{
											// This code will show error 
											$src = base_url().'en/player/videoError/';

										}else
										{
											// This code will play url 
											$src = $getType[0]['filePath'];

										}
										 
									}else
									{	
										$getSrc = $getMediaUrlData['getsource'];
										if($getMediaUrlData['embedtype'] == 'iframe')
										{
											 // This code will play embeded ifram code
											 $src = $getSrc;
										}else
										{
											// This code will play other type of embed code
											$src = base_url().'en/player/commonPlayerIframe/'.$mediaId.'_full/'.$elementEntityId.'/'.$elementId.'/'.$projectId;
										} 
									} 
									  
								}else
								{
									$src = base_url().'en/player/getPlayerIframe/'.$mediaId.'_full/'.$entityId.'/'.$elementId.'/'.$projectId;
								}
								
					$videoData['videoFile'] =   ' <iframe src="'.$src.'" width="660" height="335" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>';			
					/****************Show get introductry video code here************/
					
				}
				$videoData['fileType']=$fileType;
				$videoData['isExternal']='f';
				
			}else{
				$videoData['isVideoData']=false;
			}
			
			$this->data['innerPageData']=$this->load->view('showcase_introductory_video',$videoData,true);
		}
		elseif($page=='reviews'){
			$this->data['externalReviews'] = $this->model_common->getDataFromTabel('AddInfoReviews', '*',  $whereReviewsNews, '', 'reviewId', 'DESC');
			$this->data['rsSelected']='CSEselected';
			$this->data['innerPageData']=$this->load->view('showcase_reviews',$this->data,true);
		}
		elseif($page=='news'){
			$this->data['externalNews'] = $this->model_common->getDataFromTabel('AddInfoNews', '*',  $whereReviewsNews, '', 'newsId', 'DESC');
			$this->data['nsSelected']='CSEselected';
			$this->data['innerPageData']=$this->load->view('showcase_news',array('externalNews'=>$this->data['externalNews']),true);
		}
		elseif($page=='associatedmembers'){
			$this->data['associatedmembers'] = $this->model_showcase->getAssociatedMembers($showcaseId);
			$this->data['innerPageData']=$this->load->view('associatedprofessionals',array('associatedmembers'=>$this->data['associatedmembers']),true);
		}		
		

		/*Get multilingual language listing*/
		$multilingualList = $this->model_showcase->getUserMultiLangList($userId);
		if(isset($multilingualList) && !empty($multilingualList)) {
			$multiData= array();
			$dataLang['showcaseLangId'] = '';
			$dataLang['langId'] = 1;
			$multiData[] = $dataLang;
			foreach($multilingualList as $multilingualList){
				$dataLang['showcaseLangId'] = $multilingualList->showcaseLangId;
				$dataLang['langId'] = $multilingualList->langId;
				$multiData[] = $dataLang;
			}
			
			$this->data['multilingualList'] = $multiData;
		}else{
			$this->data['multilingualList'] = '';
		}
		
		/* Set multilingual showcase Id */
		if(isset($multilangId) && $multilangId!=0){
			$this->data['multilingualShowcaseId'] = $multilangId;
		}else{
			$this->data['multilingualShowcaseId'] = '';
		}
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')){
			
			//Set advert section id
			if($creative=='t'){
				$advertSectionId = $this->config->item('creativesSectionId');
			} elseif($associatedProfessional=='t'){
				$advertSectionId = $this->config->item('associateprofessionalSectionId');
			} elseif($enterprise=='t'){
				$advertSectionId = $this->config->item('enterprisesSectionId');				    
			}
		
			//Get banner records based on section and advert type
			$bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
			$this->data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>'','bannerType2'=>'','bannerType3'=>'','bannerType4'=>$bannerType4,'sectionId'=>$advertSectionId),true);	
		} 	
		
		/* Set Focus of mulilingual language */
		if($multilangId!=0){
			$multilingualDetails = $this->model_showcase->getUserShowcaseLang($userId,$multilangId);
			if(isset($multilingualDetails->creativeFocus) && !empty($multilingualDetails->creativeFocus)){
				$this->data['multilingualCreativeFocus'] = $multilingualDetails->creativeFocus;
			}
		}
		$this->template_front_end->load('template_front_end','showcase_detail',$this->data);
	}
	/*
	 * Function for check and update View count
	 */
	function checkViewCount() {
		
		if(!empty($this->userId)){
			$loggedUserId = $this->userId;
		}else{
			$loggedUserId = 0;
		}
		
		$session_id = $this->session->userdata('session_id');
		$entityId = getMasterTableRecord('UserShowcase');
		
		$CI = get_instance();
		$data['module'] = $CI->router->fetch_class();
		$data['moduleMethod'] = $CI->router->fetch_method();
		$pageView = $data['module'].'/'.$data['moduleMethod'];
		
		$checkSessionString = $loggedUserId.'_'.$session_id.'_'.$pageView;
		$checkSessionValue = $this->session->userdata('check_session_view_data');
		
		if($checkSessionValue !== $checkSessionString){
			
			$this->session->set_userdata('check_session_view_data',$checkSessionString);
			$elementId = 55;
			if((!empty($entityId)) && (!empty($elementId))) {
			$viewCount = $this->model_common->get_view_count($entityId,$elementId);
			$viewCountSum = $viewCount+1;
			
			//Update view count
			$data = array(
				'viewCount' => $viewCountSum,
			);
			$this->model_common->update_view_count($data,$entityId,$elementId);
			}
		}
	}
	
	function aboutme($userId=0,$multilangId=0){
		$this->index($userId,$multilangId,'aboutme');
	}
	
	function developementpath($userId=0,$multilangId=0){
		$this->index($userId,$multilangId,'developementpath');
	}
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to show user playlist
    * @auther: lokendra meena
    * @return: string
    */ 
    
    function mypaylist($userId=0,$multilangId=0){
        
        $this->head->add_css($this->config->item('player_js').'controls-hulu.css');
        $this->head->add_js($this->config->item('player_js').'flowplayer-3.2.12.js',NULL,'lastAdd');
        $this->head->add_js($this->config->item('player_js').'flowplayer.playlist-3.2.10.min.js',NULL,'lastAdd');
        $this->head->add_js($this->config->item('player_js').'flowplayer.controls-3.2.11.js',NULL,'lastAdd');
		$this->index($userId,$multilangId,'mypaylist');
	}
	
	public function videos($userId=0,$multilangId=0){
        $this->head->add_js($this->config->item('player_js').'flowplayer-3.2.12.js',NULL,'lastAdd');
        $this->index($userId,$multilangId,'videos');
	}
    
	
	public function interview($userId=0,$multilangId=0){
		$this->videos($userId,$multilangId);
	}
	
	public function introductoryvideo($userId=0,$multilangId=0){
		$this->videos($userId,$multilangId);
	}
	
	public function reviews($userId=0,$multilangId=0){
		$this->index($userId,$multilangId,'reviews');
	}
	
	public function news($userId=0,$multilangId=0){
		$this->index($userId,$multilangId,'news');
	}
	
	public function associatedmembers($userId=0){
		$this->index($userId,0,'associatedmembers');
	}
    
    public function getShowcaseData($userId=0,$showcaseId=0){
		$userId=$userId>0?$userId:$this->userId;
		if(!($userId > 0)){
			redirect('home');
		}
		$entityId=getMasterTableRecord('UserShowcase');
            
        if($userId==$this->userId){
            $showcaseId=loginUserDetails('showcaseId');
        }
        if(!$showcaseId > 0){
            $showcaseId=getUserShowcaseId($userId);
        }
        if(!($showcaseId > 0)){
            redirect('home');
        }
        
        $showcaseDetails=$this->model_showcase->getshowcasedetail($showcaseId,$userId);
        if(isset($showcaseDetails[0])){
            $this->data['showcaseData']=$showcaseDetails[0];
        }else{
            $this->data['showcaseData']=false;
        }
	}
	
	public function getCacheFileData($userId=0,$showcaseId=0){
		$userId=$userId>0?$userId:$this->userId;
		if(!($userId > 0)){
			redirect('home');
		}
		$entityId=getMasterTableRecord('UserShowcase');
		$cacheFile = $this->dirCacheShowcase.'showcase_'.$userId.'.php';
		$this->data['cacheFile']=$cacheFile;
		
		//if(!is_file($cacheFile)){
			
			if($userId==$this->userId){
				$showcaseId=loginUserDetails('showcaseId');
			}
			if(!$showcaseId > 0){
				$showcaseId=getUserShowcaseId($userId);
			}
			if(!($showcaseId > 0)){
				redirect('home');
			}
			
			if(!is_dir($this->dirCacheShowcase)){
				@mkdir($this->dirCacheShowcase, 777, true);
			}
			
			$cmd3 = 'chmod -R 777 '.$this->dirCacheShowcase;
			exec($cmd3);
			$showcaseDetails=$this->model_showcase->getshowcasedetail($showcaseId,$userId);
			$cacheFile = $this->dirCacheShowcase.'showcase_'.$userId.'.php';
			$data=str_replace("'","&apos;",json_encode($showcaseDetails));	//encode data in json format
			$stringData = '<?php $ProjectData=\''.$data.'\';?>';
			if (!write_file($cacheFile, $stringData)){					// write cache file
				echo 'Unable to write the file';
			}
		// }	
		if(is_file($cacheFile)){
			require_once ($cacheFile);
			$this->data['showcaseData']=json_decode($ProjectData, true);
			if(isset($this->data['showcaseData'][0])){
				$this->data['showcaseData']=$this->data['showcaseData'][0];
			}
			$logSummryDta=$this->model_common->getDataFromTabel('LogSummary','craveCount,viewCount,ratingAvg,reviewCount',array('entityId'=>$entityId,'elementId'=>$this->data['showcaseData']['showcaseId']), '','','',1);
			if($logSummryDta){
				$logSummryDta=$logSummryDta[0];
				$this->data['showcaseData']['craveCount']=$logSummryDta->craveCount;
				$this->data['showcaseData']['viewCount']=$logSummryDta->viewCount;
				$this->data['showcaseData']['ratingAvg']=$logSummryDta->ratingAvg;
				$this->data['showcaseData']['reviewCount']=$logSummryDta->reviewCount;
			}else{
				$this->data['showcaseData']['craveCount']=0;
				$this->data['showcaseData']['viewCount']=0;
				$this->data['showcaseData']['ratingAvg']=0;
				$this->data['showcaseData']['reviewCount']=0;
			}
		}
		
	}
	
	/**
		* Loads common menu on showcase related pages
	**/
	function menuNavigation($showcaseId=0)
	{
		$this->userId= $this->isLoginUser();
		$showcaseData['showcaseId'] = $showcaseId;
		$this->load->view('menu_navigation',$showcaseData);
	}
	
	function showcaseForm()
	{
		$this->userId= $this->isLoginUser();
		if(isset($this->userId) && $this->userId>0)	{
			$showcaseRes=getUserShowcaseId($this->userId);
			if(isset($showcaseRes->showcaseId) && $showcaseRes->showcaseId!='')
				$showcaseId = $showcaseRes->showcaseId;	
			else	
				$showcaseId = 0;
		}
		else{ 
			$showcaseId = 0;
		}
		$showcaseData['dirUploadMedia']=$this->dirUploadMedia;
		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		$this->userId= $this->isLoginUser();			
		
		$showcaseData['label'] = $this->lang->language;
		$showcaseData['values'] = $this->model_showcase->getGeneralShowcase();		
	
		if($showcaseData['values']) {
			$showcaseId = $showcaseData['values'][0]['showcaseId'];
			$showcaseData['values']=$showcaseData['values'][0];
			$userContainerId=$showcaseData['values']['userContainerId'];
		}else{
			$showcaseId = 0;
			$showcaseData['values']=false;
			$userContainerId=0;
		}
		
		$showcaseData['sectionId']=$sectionId=$this->input->post('sectionId');
		$showcaseData['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if($userContainerId > 0 || (isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 )))){ 
			$showcaseData['showcseIscreated']=true;
		}else{
			$showcaseData['showcseIscreated']=false;
			$showcaseData['userContainerId'] =$userContainerId = $this->lib_package->setUserContainerId($sectionId);
			$UserContainerData=$this->model_common->getDataFromTabel('UserContainer', 'containerSize',  array('userContainerId'=>$userContainerId,'tdsUid'=>$this->userId,'isExpired'=>'f'), '', '', '', 1);
			if($UserContainerData && isset($UserContainerData[0]->containerSize)){
				$containerSize = $UserContainerData[0]->containerSize;
				$showcaseData['values']['containerSize'] = $containerSize;
			}
		}
		
		
		$showcaseId = $this->input->post('showcaseId')>0?$this->input->post('showcaseId'):$showcaseId;//Checks if showcaseId is set or not
		$userFolderName = LoginUserDetails('username');
		$profileImagePath  = MEDIAUPLOADPATH.$userFolderName.'/profile_image';
		$interviewImagePath = MEDIAUPLOADPATH.$userFolderName.'/showcase/interview';
		$introductoryImagePath = MEDIAUPLOADPATH.$userFolderName.'/showcase/introductory';
		
		$cmd = 'chmod -R 777 '.MEDIAUPLOADPATH.$userFolderName;
		exec($cmd);

		//$showcaseData['language'] = getAbbrLangList('en');
		$showcaseData['langVal'] = 1;//For English
		$showcaseData['promoImagePath'] = $showcaseData['profileJsImagePath'] = 'media/'.$userFolderName.'/profile_image/';		
		$breadcrumbItem = array('showcasehomepage');
		$breadcrumbURL = array('showcase/showcaseForm');
		$breadcrumbString = set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$showcaseData['breadcrumbString'] = $breadcrumbString;		
		$this->config->set_item("showcase", $this->lang->line('showcaseHomepage'), $index="replacer");
		
		//$this->template->load('template','showcase/showcase_load',$showcaseData);
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/showcase'),
							'isDashButton'=>true
				  );
		$leftView='dashboard/help_showcase_homepage';
		$showcaseData['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','showcase/showcase_load',$showcaseData);
	}

//Update the showcase data and two video files related with that
function UpdateShowcaseTable()
{	
		$this->userId= $this->isLoginUser();
		$elements = false;
		$files = false;
		$updateUserContainerFlag=false;
		$entityId=getMasterTableRecord('UserShowcase');
		$data['dataShowcase'] = $this->input->post('val3');
		$data['elementId'] = $this->input->post('val5');
		$data['elementTable'] = $this->input->post('val6');
		$data['elementFieldId'] = $this->input->post('val7');
		
		
		
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
				
		}else{
			$sectionId=$this->config->item('creativesSectionId');
			$userContainerId=$this->lib_package->getUserContainerId($sectionId);
			$data['dataShowcase']['userContainerId']=$userContainerId;
			$updateUserContainerFlag=true;
		}
		$sectionId=($data['dataShowcase']['enterprise']=='t')?$this->config->item('enterprisesSectionId'):($data['dataShowcase']['associatedProfessional']=='t'?$this->config->item('associateprofessionalSectionId'):$this->config->item('creativesSectionId'));
		
		if($data['elementId']>0){
			$countResult=$this->model_common->countResult($data['elementTable'],$data['elementFieldId'],$data['elementId'],1);
			if($countResult > 0){
				$elements=true;
			}
		}
		
		$dataFormValue['values'] = $data['dataShowcase'];		
		
		$userFolderName = LoginUserDetails('username');
		$userId = LoginUserDetails('user_id');
		$cacheFile = $this->dirCacheShowcase.'showcase_'.$userId.'.php';
		
		if(is_file($cacheFile)){
			@unlink($cacheFile);
		}
		$dataFormValue['profileJsImagePath'] = 'media/'.$userFolderName.'/profile_image/';	
		if(isset($dataFormValue['values']['profileImageName']) && $dataFormValue['values']['profileImageName']!='')
		{
			$files = glob($dataFormValue['profileJsImagePath'].'*'); // get all file names
			
			$CurrentProfileImage = $dataFormValue['profileJsImagePath'].$dataFormValue['values']['profileImageName'];
		}
		else
		{
			$stockImagePath = "images/stock_images/profile/";
			if(isset($dataFormValue['values']['stockImageId']) && $dataFormValue['values']['stockImageId'] > 0)
			{ 	
				$stockImageName = getFieldValueFrmTable('stockFilename','StockImages','stockImgId',$dataFormValue['values']['stockImageId']);
				if(count($stockImageName[0])>0) 
					$CurrentStockFileName = $stockImagePath.$stockImageName[0]->stockFilename;
				else
					$CurrentStockFileName = $stockImagePath.'no.jpg';
					
				$CurrentProfileImage = $CurrentStockFileName;

		   }
		  else{
			$CurrentProfileImage=($data['dataShowcase']['enterprise']=='t')?$this->config->item('defaultEnterpriseImg_152_210'):($data['dataShowcase']['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg_152_210'):$this->config->item('defaultCreativeImg_152_210'));
		  }
		}	
		if((!isset($data['dataShowcase']['profileImageName']) || $data['dataShowcase']['profileImageName'] == '') && (!isset($dataFormValue['values']['stockImageId'])||$dataFormValue['values']['stockImageId']==0) ){
			unset($data['dataShowcase']['profileImageName']);
		}
		
		$this->session->set_userdata(array(
				'creative'	=> $data['dataShowcase']['creative'],
				'associatedProfessional'=> $data['dataShowcase']['associatedProfessional'],
				'enterprise' => $data['dataShowcase']['enterprise'],
				'userArea'	=>$data['dataShowcase']['optionAreaName'],
				'imagePath'	=> $CurrentProfileImage
		));
		
		
		
		if($elements){
			$data['append']=false;
			$this->model_common->editDataFromTabel($data['elementTable'], $data['dataShowcase'], $data['elementFieldId'], $data['elementId']);
			$showcaseId=$data['elementId'];
			if($showcaseId){
				
				$showcaseDetails=$this->model_showcase->getshowcasedetail($showcaseId);
				$cacheFile = $this->dirCacheShowcase.'showcase_'.$userId.'.php';
		
				$data=str_replace("'","&apos;",json_encode($showcaseDetails));	//encode data in json format
				$stringData = '<?php $ProjectData=\''.$data.'\';?>';
				if (!write_file($cacheFile, $stringData)){					// write cache file
					echo 'Unable to write the file';
				}				
				
				if($showcaseDetails){
					$SD=$showcaseDetails[0];
					$sectionId=($SD->creative=='t')?6:($SD->associatedProfessional=='t'?7:8);
					if($updateUserContainerFlag){
						$this->lib_package->updateUserContainer($userContainerId,$entityId,$showcaseId,$sectionId,$sectionId);
					}
					$enterpriseName=pg_escape_string($SD->enterpriseName);
					$enterpriseName=trim($enterpriseName);
					$projectType=($SD->creative=='t')?'creatives':($SD->associatedProfessional=='t'?'associatedprofessionals':'enterprises');
					
					$title=($SD->enterprise=='t')?$enterpriseName:pg_escape_string($SD->firstName.' '.$SD->lastName);
					$searchDataInsert=array(
						"entityid"=>$entityId>0?$entityId:0,
						"elementid"=>$showcaseId>0?$showcaseId:0,
						"projectid"=>$showcaseId>0?$showcaseId:0,
						"section"=>$projectType,
						"sectionid"=>$sectionId>0?$sectionId:0,
						"ispublished"=>$SD->isPublished=='t'?'t':'f',
						"cachefile"=>$cacheFile,
						"item.title"=>$title, 
						"item.tagwords"=>pg_escape_string($SD->tagwords), 
						"item.online_desctiption"=>pg_escape_string($SD->creativeFocus),
						"item.userid"=>isLoginUser()>0?isLoginUser():0, 
						"item.creative_name"=>$title, 
						"item.creative_area"=>pg_escape_string($SD->optionAreaName),
						"item.languageid"=>1,  //langId hard coded implemented  
						"item.language"=>'English', //lang hard coded implemented  
						"item.countryid"=>$SD->countryId>0?$SD->countryId:0, 
						"item.country"=>$SD->countryName, 
						"item.city"=>pg_escape_string($SD->cityName), 
						"item.industryid"=>$SD->IndustryId>0?$SD->IndustryId:0,
						"item.industry"=>$SD->IndustryName, 
						"item.sell_option"=>'free',
						"item.creation_date"=>$SD->dateCreated!=''?$SD->dateCreated:currntDateTime(), 
						"item.publish_date"=>$SD->dateCreated!=''?$SD->dateCreated:currntDateTime()
					);
					$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
				}
			}
		}else{
			$data['append']=true;
			$showcaseId=$data['elementId']=$this->model_common->addDataIntoTabel($data['elementTable'], $data['dataShowcase']);
			addDataIntoLogSummary('UserShowcase',$showcaseId);
		}
		$AEdata = $this->input->post('val1'); 
		if(is_array($AEdata) && isset($AEdata['from_showcaseid']) && ($AEdata['from_showcaseid'] > 0) && isset($AEdata['to_showcaseid']) && ($AEdata['to_showcaseid'] > 0)){
			$sd=$this->input->post('val3');
			 $whereAE= array('to_showcaseid'=>$AEdata['to_showcaseid']);
			 $countAE=$this->model_common->countResult('AssociatedEnterprise',   $whereAE,'from_showcaseid', '', 1);
			 if($countAE > 0){
				if($sd['enterprise']=='t'){
					$this->model_common->deleteRowFromTabel('AssociatedEnterprise', $whereAE);
				}else{ 
					$this->model_common->editDataFromTabel('AssociatedEnterprise', $AEdata, $whereAE);
				}
			 }elseif($sd['enterprise'] != 't'){
				$this->model_common->addDataIntoTabel('AssociatedEnterprise', $AEdata);
			 }
		}
}
	
	/**
		* Loads Additional Information Form on page
	**/
	function additionalInfoForm($type='News')
	{
		$this->userId= $this->isLoginUser();
		if(isset($this->userId) && $this->userId>0)	{
			$showcaseRes=getUserShowcaseId($this->userId);
			$showcaseId = $showcaseRes->showcaseId;		
		}
		else{ 
			$showcaseId = 0;
		}
		
		if(!$showcaseId > 0){
			redirect('showcase/showcaseForm');
		}
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		$additionalInfoData['label'] = $this->lang->language;
		$additionalInfoData['tableId'] = getMasterTableRecord('UserShowcase');
		$additionalInfoData['recordId'] = $additionalInfoData['showcaseId'] =  $showcaseId;
		$additionalInfoData['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		$additionalInfoData['header']= $this->load->view('showcase/menu_navigation',$additionalInfoData, true);
		$breadcrumbItem = array('showcasehomepage','additionalInfoForm');
		$breadcrumbURL = array('showcase/showcaseForm','showcase/additionalInfoForm');
		$breadcrumbString = set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$additionalInfoData['breadcrumbString'] = $breadcrumbString;
		$additionalInfoData['socialMediaIconList'] = getIconList();
		$additionalInfoData['additionalInfoSection']=array('addInfoIntroVideo','addInfoInterviewVideo','addInfoNewsPanel','addInfoReviewsPanel'); 
		
		//$this->template->load('template','additionalInfo/additional_info',$additionalInfoData);
		
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/showcase'),
							'isDashButton'=>true,
							'isIntroducrory'=>1
				  );
		$leftView='dashboard/help_pr_material';
		$additionalInfoData['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','additionalInfo/additional_info',$additionalInfoData);
	}
	
	
	
	
	function viewStockImages($showcaseId)
	{			
		$this->userId= $this->isLoginUser();
			
		$isAjaxHit = $this->input->get('ajaxHit');
		$stockimageonly['showcaseId'] = $showcaseId;
		$stockimageonly['stockImages'] = $this->model_showcase->loadStockImages();
		$this->load->view('stock_images',$stockimageonly);		
	}
	
	//To show preview for showcase section
	
	function showcasePreview($showCaseFlag=0)
	{	
	 $this->userId= $this->isLoginUser();
			
	 $isAjaxHit = $this->input->get('ajaxHit');

	 $this->model_showcase->showcasePreviewData();
	 $unserializeData['label'] = $this->lang->language;
	 $unserializeData['object'] = unserialize($this->session->userdata('serializedData'));

	if($unserializeData['object']['optionSelected']==1) {
	 $labelOption = $unserializeData['label']['creative'].$unserializeData['label']['area'];
	 $labelFocus =  $unserializeData['label']['creativeFocus'];
	 $labelPath = $unserializeData['label']['creativePath'];
	 $enterpriseStyle =  'style="display:none;"';
	}

	if($unserializeData['object']['optionSelected']==2) {
	 $labelOption = $unserializeData['label']['associatedProfessional'].' '.$unserializeData['label']['area'];
	 $labelFocus = $unserializeData['label']['associatedProfessional'].' '.$unserializeData['label']['focus'];
	 $labelPath = $unserializeData['label']['associatedProfessional'].' '.$unserializeData['label']['path'];
	 $enterpriseStyle =  'style="display:none;"';
	}

	if($unserializeData['object']['optionSelected']==3) {
	 $labelOption = $unserializeData['label']['enterprise'].' '.$unserializeData['label']['area'];
	 $labelFocus = $unserializeData['label']['enterprise'].' '.$unserializeData['label']['focus'];
	 $labelPath = $unserializeData['label']['enterprise'].' '.$unserializeData['label']['path'];
	 $enterpriseStyle =  'style="display:block;"';
	}

	if($unserializeData['object']['optionSelected']==4) {
	 $labelOption = $unserializeData['label']['artist'].' '.$unserializeData['label']['area'];
	 $labelFocus = $unserializeData['label']['artist'].' '.$unserializeData['label']['focus'];
	 $labelPath = $unserializeData['label']['artist'].' '.$unserializeData['label']['path'];
	 $enterpriseStyle =  'style="display:none;"';
	}
	else 
	{
	 $labelOption = $unserializeData['label']['creative'].$unserializeData['label']['area'];
	 $labelFocus =  $unserializeData['label']['creativeFocus'];
	 $labelPath = $unserializeData['label']['creativePath'];
	 $enterpriseStyle =  'style="display:none;"';
	}

	$unserializeData['labelOption'] = $labelOption;
	$unserializeData['labelFocus'] = $labelFocus;
	$unserializeData['labelPath'] = $labelPath;	

	if($showCaseFlag == 1){
		//$this->template->load('template','showcase_detail',$unserializeData);
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/showcase'),
							'isDashButton'=>true
				  );
		$leftView='dashboard/help_showcase';
		$unserializeData['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','showcase_detail',$unserializeData);
	}else
		$this->load->view('showcase_preview',$unserializeData);		
	}
	
	

	function showcaseNewsPreview()
	{
	
	 $this->userId = $this->isLoginUser();
			
	 $unserializeData['label'] = $this->lang->language;
	 $this->model_showcase->showcasePreviewNewsData();	
	 $unserializeData['news'] = unserialize($this->session->userdata('serializedNewsData'));
	 $this->load->view('showcase_news_preview',$unserializeData);	
	}
	
	function showcaseReviewsPreview()
	{
	
	$this->userId = $this->isLoginUser();
			
	$unserializeData['label'] = $this->lang->language;
	if($this->session->userdata('serializedReviewsData'))		
 	{
		$unserializeData['reviews'] = unserialize($this->session->userdata('serializedReviewsData'));
	}
	else{		
		$res=  $this->model_showcase->showcasePreviewReviewsData();	
		$unserializeData['reviews'] =  $res;
		$this->session->set_userdata('serializedReviewsData',serialize($res));
	}	
	
	  $this->load->view('showcase_reviews_preview',$unserializeData);	
	}

	function showcaseAwardsPreview()
	{
	 $this->userId = $this->isLoginUser();
			
	 $unserializeData['label'] = $this->lang->language;
	 $this->model_showcase->showcasePreviewAwardsData();	
	 $unserializeData['awards'] = unserialize($this->session->userdata('serializedAwardsData'));
	 $this->load->view('showcase_awards_preview',$unserializeData);	
	}

	function showcaseSocialNetPreview()
	{
	 $this->userId = $this->isLoginUser();
			
	 $unserializeData['label'] = $this->lang->language;
	 $this->model_showcase->showcasePreviewSocialNetData();	
	 $unserializeData['socialnet'] = unserialize($this->session->userdata('serializedSocialNetData'));
	 $this->load->view('showcase_socialnet_preview',$unserializeData);	
	}

	function recommendations()
	{
		 $this->data['userId'] = $this->isLoginUser();
		 //$this->template->load('template','recommendations',$this->data);
		 
		 $leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/showcase'),
							'isDashButton'=>true,
							'helpSection'=>'recommendationsReceive'
				  );
		$leftView='dashboard/help_recommendations';
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','recommendations',$this->data);
	}
	
	function recommendationsgiven()
	{
		 $this->data['userId'] = $this->isLoginUser();
		 //$this->template->load('template','recommendations_given',$this->data);
		 $leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/showcase'),
							'isDashButton'=>true,
							'helpSection'=>'recommendationsGiven'
				  );
		$leftView='dashboard/help_recommendations';
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','recommendations_given',$this->data);
	}
	
	
	function socialMedia()
	{
		
		$this->userId = $this->isLoginUser();
		if(isset($this->userId) && $this->userId>0)	{
		$showcaseRes=getUserShowcaseId($this->userId);
		$showcaseId = $showcaseRes->showcaseId;
		$viewElementId=$showcaseRes->showcaseId;
		}
		else{ 
			$showcaseId = $viewElementId = 0;
		}
		
		$additionalInfoData['additionalInfoSection'] = array('addInfoSocialMediaPanel');
		//$additionalInfoData['tableId']=$this->projectProfileSocialLink;
		$additionalInfoData['tableId'] = getMasterTableRecord('UserShowcase');
		$additionalInfoData['sectionheading'] = $this->lang->line('socialLinks');
		$additionalInfoData['elementId'] = $additionalInfoData['recordId'] = $showcaseId;
		$additionalInfoData['label'] = $this->lang->language;
		$additionalInfoData['showcaseId'] = $showcaseId;
		$additionalInfoData['userNavigations'] = $userNavigations = $this->model_common->userNavigations($this->userId,false);
		$breadcrumbItem = array('showcasehomepage','socialMedia');
		$breadcrumbURL = array('showcase/showcaseForm/'.$this->userId,'showcase/socialMedia/'.$this->userId);
		$breadcrumbString = set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$additionalInfoData['breadcrumbString'] = $breadcrumbString;
		$additionalInfoData['header'] = $this->load->view('showcase/menu_navigation',$additionalInfoData, true);
		
		
		$this->config->set_item("showcase", $this->lang->line('showcaseHomepage'), $index="replacer");
		//$this->template->load('template','additionalInfo/additional_info',$additionalInfoData);	
		
		 $leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/showcase'),
							'isDashButton'=>true
				  );
		$leftView='dashboard/help_social_link';
		$additionalInfoData['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','additionalInfo/additional_info',$additionalInfoData);	
	}
	
	
	/*
	 * Function to get Socila icons of user
	 * 
	 */
	function showUserSocialLinks($socialMediaCondtion=array('userId'=>0,'for'=>''))
	{
		
		$data['userSocialLinks'] = $this->model_showcase->getSocialMediaIcon($socialMediaCondtion);
		$this->load->view('social_icons_left',$data);
		
	}
	
	
	function multilingaul_showcase_form($userId=0,$langAbbr=0)
	{
		$this->userId = $this->isLoginUser();			
		
		$multilingualShowcaseData['label'] = $this->lang->language;
		$multilingualShowcaseData['langAbbr'] = $langAbbr;
		
		$multilingualShowcaseData['defaultValues'] = $this->model_showcase->getGeneralShowcase();	
		$multilingualShowcaseData['langValues'] = $this->model_showcase->getShowcaseMultiLangData($langAbbr);
		if(!empty($langAbbr) && empty($multilingualShowcaseData['langValues'])){
			redirectToNorecord404();
		}
		
		if($multilingualShowcaseData['defaultValues']) {
			$showcaseId = $multilingualShowcaseData['defaultValues'][0]['showcaseId'];
			$multilingualShowcaseData['defaultValues'] = $multilingualShowcaseData['defaultValues'][0];
			$userContainerId = $multilingualShowcaseData['defaultValues']['userContainerId'];
		}else{
			$showcaseId = 0;
			$multilingualShowcaseData['defaultValues'] = false;
			$userContainerId = 0;
		}
		if($multilingualShowcaseData['langValues']) {
			$multilingualShowcaseData['langValues'] = $multilingualShowcaseData['langValues'][0];			
		}else{
			$multilingualShowcaseData['langValues'] = false;
		}
		$multilingualShowcaseData['elementFieldId'] = 'showcaseLangId';
		$multilingualShowcaseData['elementTable'] = 'UserShowcaseLang';
		
		

		//$this->template->load('template','multilingual_showcase_form',$multilingualShowcaseData);
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/showcase'),
							'isDashButton'=>true
				  );
		$leftView='dashboard/help_multilingual';
		$multilingualShowcaseData['leftContent']=$this->load->view($leftView,$leftData,true);
		$this->template->load('backend_template','multilingual_showcase_form',$multilingualShowcaseData);	
	}
	
	/*
	 * Function to save data in db
	 * 
	 */
	function save_multilangual_form(){
		$entityId = getMasterTableRecord('UserShowcaseLang');
		$showcaseLangId = $this->input->post('showcaseLangId');
		$data['tdsUid'] = $this->userId;
		$data['langId'] = $this->input->post('showcaseLanguage');
		if(isset($showcaseLangId) && !empty($showcaseLangId)){
			$showcaseLangId = $showcaseLangId;
			$userLangId = $this->model_showcase->getUserShowcaseLang($data['tdsUid'],$showcaseLangId);
			if((isset($userLangId->langId)) && ($this->input->post('showcaseLanguage')!=$userLangId->langId)){
				$langCheckExist = '';
			}else{
				$langCheckExist = 1;
			}
		}else{
			$showcaseLangId = 0;
			$langCheckExist = $this->model_showcase->checkUserShowcaseLang($data['tdsUid'],$data['langId']);
		}
		
		$showcaseRes = getUserShowcaseId($this->userId);
		$userShowcaseId = $showcaseRes->showcaseId;
		$data['showcaseId'] = $userShowcaseId;	
		$data['lang'] = $this->input->post('lang');
		$data['optionAreaName'] = $this->input->post('optionAreaName');
		$data['tagwords'] = $this->input->post('tagwords');
		$data['creativeFocus'] = $this->input->post('creativeFocus');
		$data['creativePath'] = $this->input->post('creativePath');
	 	$data['promotionalsection'] = $this->input->post('promotionalsection1');
	 	$isPublished = $this->input->post('isPublished');
		$formSave = $this->model_showcase->multilingaul_form_save($data,$showcaseLangId);
		if(isset($formSave) && !empty($formSave)){
			$elementid = $formSave;
		}else{
			$elementid = $showcaseLangId;
		}
		if(is_numeric($elementid) && $elementid > 0){
			//Get showcase details of user
			$showcaseDetails=$this->model_showcase->getshowcasedetail($userShowcaseId);
			$cacheFile = $this->dirCacheShowcase.'showcase_'.$data['tdsUid'].'.php';
			$SD=$showcaseDetails[0];
			$sectionId=($SD->creative=='t')?6:($SD->associatedProfessional=='t'?7:8);
			$enterpriseName=pg_escape_string($SD->enterpriseName);
			$enterpriseName=trim($enterpriseName);
			$projectType=($SD->creative=='t')?'creatives':($SD->associatedProfessional=='t'?'associatedprofessionals':'enterprises');
			if(isset($showcaseLangId) && !empty($showcaseLangId)){
				$multilingualShowcaseData = $this->model_showcase->getShowcaseMultiLangData($showcaseLangId);
				$publishDate = $multilingualShowcaseData[0]['publisheDate'];
				$dateCreated = $multilingualShowcaseData[0]['dateCreated'];
			}
			
			$langName = getLanguage($data['langId']);
			
			$title=($SD->enterprise=='t')?$enterpriseName:pg_escape_string($SD->firstName.' '.$SD->lastName);
			$searchDataInsert=array(
				"entityid"=>$entityId>0?$entityId:0,
				"elementid"=>$elementid>0?$elementid:0,
				"projectid"=>$userShowcaseId>0?$userShowcaseId:0,
				"section"=>$projectType,
				"sectionid"=>$sectionId>0?$sectionId:0,
				"ispublished"=>($isPublished=='t')?'t':'f',
				"cachefile"=>$cacheFile,
				"item.title"=>$title, 
				"item.tagwords"=>pg_escape_string($data['tagwords']), 
				"item.online_desctiption"=>pg_escape_string($data['creativeFocus']),
				"item.userid"=>isLoginUser()>0?isLoginUser():0, 
				"item.creative_name"=>$title, 
				"item.creative_area"=>pg_escape_string($data['optionAreaName']),
				"item.languageid"=>$data['langId']>0?$data['langId']:0,    
				"item.language"=>isset($langName)?$langName:'',
				"item.countryid"=>$SD->countryId>0?$SD->countryId:0, 
				"item.country"=>$SD->countryName, 
				"item.city"=>pg_escape_string($SD->cityName), 
				"item.industryid"=>$SD->IndustryId>0?$SD->IndustryId:0,
				"item.industry"=>$SD->IndustryName, 
				"item.sell_option"=>'free',
				"item.creation_date"=>isset($dateCreated)?$dateCreated:currntDateTime(), 
				"item.publish_date"=>isset($publishDate)?$publishDate:currntDateTime()
			);
			
			$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
		}
		if(!empty($formSave)){
			echo $formSave;
		}else{
			echo $formSave;
		}	
	}
	
	function updateShowcaseLangSearch(){
		
		$result=$this->model_common->getDataFromTabel($table='UserShowcaseLang', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='', $limit=0, $offset=0, $resultInArray=true  );
		if($result){
			$entityId = getMasterTableRecord('UserShowcaseLang');
			foreach($result as $data){
				$elementid=$showcaseLangId =$data['showcaseLangId'];
				$userShowcaseId=$showcaseLangId =$data['showcaseId'];
				
				if(is_numeric($elementid) && $elementid > 0 && $userShowcaseId > 0){
					$showcaseDetails=$this->model_showcase->getshowcasedetail($userShowcaseId);
					$cacheFile = $this->dirCacheShowcase.'showcase_'.$data['tdsUid'].'.php';
					$SD=$showcaseDetails[0];
					
					$sectionId=($SD->creative=='t')?6:($SD->associatedProfessional=='t'?7:8);
					
					$enterpriseName=pg_escape_string($SD->enterpriseName);
					$enterpriseName=trim($enterpriseName);
					
					$projectType=($SD->creative=='t')?'creatives':($SD->associatedProfessional=='t'?'associatedprofessionals':'enterprises');
					
					$publishDate = $data['publisheDate'];
					$dateCreated = $data['dateCreated'];
					$isPublished = $data['isPublished'];
					
					$langName = getLanguage($data['langId']);
					
					$title=($SD->enterprise=='t')?$enterpriseName:pg_escape_string($SD->firstName.' '.$SD->lastName);
					
					$searchDataInsert=array(
						"entityid"=>$entityId>0?$entityId:0,
						"elementid"=>$elementid>0?$elementid:0,
						"projectid"=>$userShowcaseId>0?$userShowcaseId:0,
						"section"=>$projectType,
						"sectionid"=>$sectionId>0?$sectionId:0,
						"ispublished"=>($isPublished=='t')?'t':'f',
						"cachefile"=>$cacheFile,
						"item.title"=>$title, 
						"item.tagwords"=>pg_escape_string($data['tagwords']), 
						"item.online_desctiption"=>pg_escape_string($data['creativeFocus']),
						"item.userid"=>$data['tdsUid']>0?$data['tdsUid']:0, 
						"item.creative_name"=>$title, 
						"item.creative_area"=>pg_escape_string($data['optionAreaName']),
						"item.languageid"=>$data['langId']>0?$data['langId']:0,    
						"item.language"=>pg_escape_string($langName),
						"item.countryid"=>$SD->countryId>0?$SD->countryId:0, 
						"item.country"=>pg_escape_string($SD->countryName), 
						"item.city"=>pg_escape_string($SD->cityName), 
						"item.industryid"=>$SD->IndustryId>0?$SD->IndustryId:0,
						"item.industry"=>pg_escape_string($SD->IndustryName), 
						"item.sell_option"=>'free',
						"item.creation_date"=>isset($dateCreated)?$dateCreated:currntDateTime(), 
						"item.publish_date"=>isset($publishDate)?$publishDate:currntDateTime()
					);
					$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
				}
			}
			
		}
	}
	
	/**
	* Remove Multilingual showcase.
	*/
	public function deleteMultilingualShowcase($mutiLangId)
    {
		if($this->model_showcase->removeMultiLangShowcase($mutiLangId))
		{
			$this->session->set_flashdata('msg','');
			redirectPage('dashboard');
		}
		else{
			$this->session->set_flashdata('msg','');
			redirect('dashboard');
		}
	}
    
    //--------------------New Version Methods Start--------------------------//
    
    
    /**
    * @Description: This method is use to show user showcase menu
    * @return: void
    * @auther: lokendra 
    */ 
    
    public function usershowcasemenu($userId="0"){
        
        // get logged in user id
        //$userId     =  $this->isLoginUser();
        $this->data['userNavigations']      =   $this->model_common->userNavigations($userId,true);
        $this->data['cravesCount']          =   $this->model_craves->craveList($userId,'','','',0,true,false);
        $this->data['cravingmeCount']       =   $this->model_craves->cravingmeUserList($userId,'','','',0,0,true);
        $this->data['userOtherProject']     =   $this->model_common->showProjectsCount($userId);
        $this->data['buyerCommentsCount']   =   $this->model_common->countResult('BuyerComments',$field=array('ownerId'=>$userId,'status'=>'t'),'', 1);
        
        /*
        echo "<pre>";
            print_r($this->data['userNavigations']);
        die();*/
        
        // get user showcase id
        $showcaseRes  =   getUserShowcaseId($userId);
        
        $showcaseId   =   0;
        if(!empty($showcaseRes->showcaseId)){
            $showcaseId     =   $showcaseRes->showcaseId;
        }else{
            return true;
        }
        
        // get entity id
        $entityId           =   getMasterTableRecord('UserShowcase');
        
        // get enternal review data
        $whereReviewsNews       =  array('entityId' => $entityId,'elementId'=>$showcaseId);
        $externalReviewsFlag    =  $this->model_common->countResult('AddInfoReviews',   $whereReviewsNews,'reviewId', '', 1);
        
        // get enternal review data empty
        if(empty($externalReviewsFlag)){
            $whereReviewsElement    =  array('entityId' => $entityId,'projectElementId'=>$showcaseId,'isPublished'=>'t');
            $externalReviewsFlag    =  countResult('ReviewsElement',$whereReviewsElement);	
        }
        
        // get external new data
        $externalNewsFlag    =  $this->model_common->countResult('AddInfoNews',  $whereReviewsNews, 'newsId','', 1);
        
        $this->data['externalReviewsFlag']  =  $externalReviewsFlag;
        $this->data['externalNewsFlag']     =  $externalNewsFlag;
        $this->data['userId']               =  $userId;
        
        // get current open method name
        $moduleMathod           =   $this->router->fetch_method();
        $this->data['mathod']   =   $moduleMathod;
        
        //get showcase data
        $this->showcasemenudata($userId,$showcaseId,$entityId);
        
        $this->load->view('user_showcase_menu',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    
    /*
    *  @description: This method is use to show user navigation data
    *  @auther: lokendra 
    *  @return: void
    */ 
    
    public function showcasemenudata($userId=0,$showcaseId=0,$entityId=0){
        
        //get loggedIn or frontend userId
        $userId     =   $userId>0?$userId:$this->userId;
        
         //if not exist then return true
        if(empty($userId)){
            return true;
        }
        
        //get loggedIn user showcaseId
        if($userId==$this->userId){
            $showcaseId =   loginUserDetails('showcaseId');
        }
       
        //if not exist then return true
        if(empty($showcaseId)){
            return true;
        }
        
        //get showcase details  by showaseId and userId
        $showcaseDetails    =   $this->model_showcase->getshowcasedetail($showcaseId,$userId);
        
        
        //echo "<pre>";
        //print_r($showcaseDetails);die();
        
        //check data 
        if(!empty($showcaseDetails[0])){
          $showcaseDetails  =  (array) $showcaseDetails[0];
        }
        
        //data send on view
        $this->data['showcaseData'] =  $showcaseDetails;
        
        //get logsummary data for crave data
        $logSummryDta=$this->model_common->getDataFromTabel('LogSummary','craveCount,viewCount,ratingAvg,reviewCount',array('entityId'=>$entityId,'elementId'=>$this->data['showcaseData']['showcaseId']), '','','',1);
        
        $craveCount = 0;
        $viewCount = 0;
        $ratingAvg = 0;
        $reviewCount = 0;
        
        //get logsummary data
        if($logSummryDta){
            $logSummryDta   =   $logSummryDta[0];
            $this->data['showcaseData']['craveCount']   =   $logSummryDta->craveCount;
            $this->data['showcaseData']['viewCount']    =   $logSummryDta->viewCount;
            $this->data['showcaseData']['ratingAvg']    =   $logSummryDta->ratingAvg;
            $this->data['showcaseData']['reviewCount']  =   $logSummryDta->reviewCount;
        }
        
        $this->data['showcaseData']['craveCount']   =   $craveCount;
        $this->data['showcaseData']['viewCount']    =   $viewCount;
        $this->data['showcaseData']['ratingAvg']    =   $ratingAvg;
        $this->data['showcaseData']['reviewCount']  =   $reviewCount;
        
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage showcase type form
     * @access: public
     * @return void
     */ 
    public function showcasetype( ) {
       
        $this->userId = $this->isLoginUser();
        
        $showcaseId = 0;
        if(isset($this->userId) && $this->userId>0)	{
            $showcaseRes = getUserShowcaseId($this->userId);
            if(isset($showcaseRes->showcaseId) && $showcaseRes->showcaseId!='') {
                $showcaseId = $showcaseRes->showcaseId;	
            }
        }
        if($showcaseId > 0) {
            /*Get Users showcase area */
            if($showcaseRes->creative == 't') {
                $showcaseType = 'Creative';
                $showcaseTypeVal = 1;
                $isShowcaseTypeSet = true;
                $sectionId = "6";
            } elseif($showcaseRes->associatedProfessional == 't'){
                $showcaseType = 'Professional';
                $showcaseTypeVal = 2;
                $isShowcaseTypeSet = true;
                $sectionId = "7";
            } elseif($showcaseRes->enterprise == 't'){
                $showcaseType = 'Business';
                $showcaseTypeVal = 3;
                $isShowcaseTypeSet = true;
                 $sectionId = "8";
            } elseif($showcaseRes->fans == 't'){
                $showcaseType = 'Fan';
                $showcaseTypeVal = 4;
                $sectionId = "34";
            }
        }
        
       
        
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        // set form data
        $this->wizardheadingtext();
        $this->data['showcaseType']         = (isset($showcaseType))?$showcaseType:'';
        $this->data['showcaseTypeVal']      = (isset($showcaseTypeVal))?$showcaseTypeVal:'';
        $this->data['isShowcaseTypeSet']    = (isset($isShowcaseTypeSet))?$isShowcaseTypeSet:false;
        $this->data['s1menu']               = 'TabbedPanelsTabSelected';
        $this->data['showcaseType1menu']    = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/showcase_type_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/showcase_type';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save showcase type
     * @access: public
     * @return void
     */ 
    public function setshowcasetype() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/showcase/showcasetype');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedShowcaseType');
        if(!empty($postData)) {
            // set update showcase type field
            if($postData['showcase_type'] == 1) {
                $showcaseArea = 'creative';
                // session values
                $this->session->set_userdata('creative','t');
            } elseif($postData['showcase_type'] == 2) {
                $showcaseArea = 'associatedProfessional';
                // session values
                $this->session->set_userdata('associatedProfessional','t');
            } elseif($postData['showcase_type'] == 3) {
                $showcaseArea = 'enterprise';
                // session values
                $this->session->set_userdata('enterprise','t');
            } elseif($postData['showcase_type'] == 4) {
                $showcaseArea = 'fans';
                // session values
                $this->session->set_userdata('fans','t');
            }
            
            
            
            if(isset($showcaseArea)) {
                // update user's showcase type id
                $UserShowcaseData = array($showcaseArea=>'t');
                
                if($this->session->userdata('fans') == 't' && $postData['showcase_type'] != 4)
                {
                    $UserShowcaseData['fans'] = 'f'; 
                    $this->session->set_userdata('fans','f');
                }
                
                $this->model_common->editDataFromTabel('UserShowcase', $UserShowcaseData, 'tdsUid', $this->userId);
                // set mext page url
                $reditectUrl = base_url(lang().'/showcase/showcaselanguage');
                $type = 'success';
                $msg = $this->lang->line('updatedShowcaseType');
            } 
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage showcase language
     * @access: public
     * @return void
     */ 
    public function showcaselanguage() {
        
        $this->userId = $this->isLoginUser();
       
        $showcaseId = 0;
        $showcaseRes = getUserShowcaseId($this->userId);
        if(isset($showcaseRes->showcaseId) && $showcaseRes->showcaseId!='') {
          
            $showcaseId = $showcaseRes->showcaseId;
            $langaugeId = $showcaseRes->langaugeId;
        }
        
        if($showcaseId > 0) {
            /*Get Users showcase area */
            if($showcaseRes->creative == 't') {
                $sectionId = "6";
            } elseif($showcaseRes->associatedProfessional == 't'){
                $sectionId = "7";
            } elseif($showcaseRes->enterprise == 't'){
                 $sectionId = "8";
            } elseif($showcaseRes->fans == 't'){
                $sectionId = "34";
            }
        }
        
        //insert one time for managing your toadsquare menu for showcase
        $inserData    =   array(
                    'entityid'              =>  getMasterTableRecord('UserShowcase'),
                    'elementid'             =>  $showcaseId,
                    'projectid'             =>  $showcaseId,
                    'section'               =>  $this->config->item('sectionId'.$sectionId),
                    'sectionid'             =>  $sectionId,
                    'sectionParent'         =>  $this->config->item('showcaseParentName'),
                );
        yourToadsqureData($inserData);
        
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        // set form data
        $this->wizardheadingtext();
        $this->data['langaugeId']           = (isset($langaugeId))?$langaugeId:'';
        $this->data['isShowcaseTypeSet']    = (isset($isShowcaseTypeSet))?$isShowcaseTypeSet:false;
        $this->data['s1menu']               = 'TabbedPanelsTabSelected';
        $this->data['showcaseType2menu']    = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/showcase_type_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/showcase_preferred_language';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save showcase language
     * @access: public
     * @return void
     */ 
    public function setshowcaselanguage() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/showcase/showcaselanguage');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedShowcaseLang');
        if(!empty($postData)) {
            
            // update user's showcase type id
            $UserShowcaseData = array('langaugeId'=>$postData['langaugeId']);
            $this->model_common->editDataFromTabel('UserShowcase', $UserShowcaseData, 'tdsUid', $this->userId);
            // set mext page url
            $reditectUrl = base_url(lang().'/showcase/creativeindustry');
            $type = 'success';
            $msg = $this->lang->line('updatedShowcaseLang');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage enterprise creative industry
     * @access: public
     * @return void
     */ 
    public function creativeindustry() {
       
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);

        // get user's showcase data
        $showcaseRes = getUserShowcaseId($this->userId);
        // set creative industry
        $creativeIndustry = $showcaseRes->industryId;
        // set creative head titles
        $creativeIndustryHead = $this->lang->line('creativeIndustryHead');
        $creativeIndustryHeadNote = $this->lang->line('creativeIndustryHeadNote');
        if($showcaseRes->enterprise == 't') {
           $creativeIndustryHead = $this->lang->line('creativeIndustryBHead');
           $creativeIndustryHeadNote = $this->lang->line('creativeIndustryBHeadNote');
        }
        $this->wizardheadingtext();
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        $this->data['creativeIndustry']     = (isset($creativeIndustry))?$creativeIndustry:0;
        $this->data['creativeIndustryHead']        = $creativeIndustryHead;
        $this->data['creativeIndustryHeadNote']    = $creativeIndustryHeadNote;
        $this->data['s1menu']               = 'TabbedPanelsTabSelected';
        $this->data['showcaseType3menu']    = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/showcase_type_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/showcase_creative_industry';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save showcase creative industry
     * @access: public
     * @return void
     */ 
    public function setcreativeindustry() {
        // get post values
        $postData = $this->input->post();
        
        // set default redirect url
        $reditectUrl = base_url(lang().'/showcase/creativeindustry');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedCreativeIndustry');
        if(!empty($postData)) {
            
            // update user's showcase type id
            $UserShowcaseData = array('industryId'=>$postData['industryId']);
            $this->model_common->editDataFromTabel('UserShowcase', $UserShowcaseData, 'tdsUid', $this->userId);
            // set mext page url
            $reditectUrl = base_url(lang().'/showcase/aboutyou');
            $type = 'success';
            $msg = $this->lang->line('UpdatedCreativeIndustry');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
      //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage showcase about you details
     * @access: public
     * @return void
     */ 
    public function aboutyou() {
       
        //add full screen js
        $this->head->add_css($this->config->item('template_new_js').'jcrop/jquery.Jcrop.css');
        $this->head->add_js($this->config->item('template_new_js').'jcrop/jquery.Jcrop.js',NULL,'lastAdd');
       
        $this->userId = $this->isLoginUser();
        
         //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        $showcaseId = 0;
        $showcaseRes = getUserShowcaseId($this->userId);
        if(isset($showcaseRes->showcaseId) && $showcaseRes->showcaseId!='') {
            $showcaseId = $showcaseRes->showcaseId;
             /*Get Users showcase area */
            if($showcaseRes->creative == 't') {
                $showcaseType = 1;
            } elseif($showcaseRes->associatedProfessional == 't'){
                $showcaseType = 2;
            } elseif($showcaseRes->enterprise == 't'){
                $showcaseType = 3;
            } elseif($showcaseRes->fans == 't'){
                $showcaseType = 1;
            }
               
            // get stock img data
            $stockImgRes = $this->model_common->getDataFromTabel('StockImages', 'stockFilename,stockImgPath,stockImgId',  array('type'=>$showcaseType),'',$orderBy='stockImgId',$order='ASC', $limit=2);
            if(!empty($stockImgRes)) {
                $stockImgRes = $stockImgRes;
            }
        }
        //call method for plupload css and js add
        $this->_pluploadjsandcss();
        $userFolderName    = LoginUserDetails('username');
        $profileImagePath  = $this->dirUploadProfileMedia;
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        $this->wizardheadingtext();
        $this->data['dirUploadMedia']       =  $profileImagePath;
        $this->data['showcaseRes']          = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['stockImgRes']          = (isset($stockImgRes))?$stockImgRes:'';
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['aboutYou1menu']        = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/about_you_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/profile_image';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
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
    * @Description: This method is use to stage "3" of media uploage stage - 1
    * @access: public
    * @return: void
    */
     
    public function uploadelementfilepost($arg_list) {
        
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/showcase/aboutyou');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedCreativeIndustry');
        if(!empty($postData)) {
            $browseId        = $postData['browseId'];
            $isStockImg  = false;
            //--------media data prepair for inserting------//
            $media_fileName    = $this->input->post('fileName'.$browseId);
            // update user's showcase type id
            if(!empty($postData['profile_img']) && !empty($postData['stock_img'])) {
                $UserShowcaseData = array('profileImageName'=>'','stockImageId'=>$postData['stock_img']);
                $isStockImg = true;
                // get stock img data
                $stockImgRes = $this->model_common->getDataFromTabel('StockImages', 'stockFilename,stockImgPath',  array('stockImgId'=>$postData['stock_img']),'','','', $limit=1);
                $stockImgRes = $stockImgRes[0];
                // set image path
                $imagePath = $stockImgRes->stockImgPath.'/'.$stockImgRes->stockFilename;
            } else {
                $UserShowcaseData = array('profileImageName'=>$media_fileName,'stockImageId'=>'0');
                // set image path
                $imagePath = $this->dirUploadProfileMedia.'/'.$media_fileName;
            }
            // session values
            $this->session->set_userdata('imagePath',$imagePath);
           
            $this->model_common->editDataFromTabel('UserShowcase', $UserShowcaseData, 'tdsUid', $this->userId);
            
            $reditectUrl = base_url(lang().'/showcase/showcasedetails');
            $type = 'success';
            $msg = $this->lang->line('UpdatedCreativeIndustry');
        }
        $returnData = array('nextUrl'=>$reditectUrl,'isStockImg'=>$isStockImg);
        echo json_encode($returnData);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage enterprise creative industry
     * @access: public
     * @return void
     */ 
    public function showcasedetails() {
       
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        $showcaseRes = getUserShowcaseId($this->userId);
        // get user's profile record
        $userProfileData = $this->model_common->getDataFromTabel('UserProfile', 'firstName,lastName,countryId',  array('tdsUid'=>$this->userId),'','',$order='ASC', $limit=1);
        // set data for showcase form
        $this->wizardheadingtext();
        $this->isbusinessarea($showcaseRes);
        $this->data['userProfileData'] = (isset($userProfileData[0]))?$userProfileData[0]:'';
        $this->data['showcaseRes']     = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['aboutYou2menu']        = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/about_you_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/showcase_details';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    /*
     * @description: This function is used to manage about section
     * @access: public
     * @return void
     */ 
    public function aboutsection() {
       
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        
        $showcaseRes = getUserShowcaseId($this->userId);
        // get user's profile record
        $userProfileData = $this->model_common->getDataFromTabel('UserProfile', 'firstName,lastName,countryId',  array('tdsUid'=>$this->userId),'','',$order='ASC', $limit=1);
       
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        $this->wizardheadingtext();
        $this->data['userProfileData'] = (isset($userProfileData[0]))?$userProfileData[0]:'';
        $this->data['showcaseRes']     = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['aboutYou3menu']        = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/about_you_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/about_section';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save showcase creative industry
     * @access: public
     * @return void
     */ 
    public function setaboutsectiondetails() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/showcase/aboutsection');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedAboutSection');
        if(!empty($postData)) {
            
            // update user's showcase type id
            $UserShowcaseData = array('tagwords'=>$postData['tagwords'],'promotionalsection'=>$postData['promotionalsection']);
            $this->model_common->editDataFromTabel('UserShowcase', $UserShowcaseData, 'tdsUid', $this->userId);
            // set mext page url
            $reditectUrl = base_url(lang().'/showcase/developmentpath');
            $type = 'success';
            $msg = $this->lang->line('UpdatedAboutSection');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
    /*
     * @description: This function is used to manage development section
     * @access: public
     * @return void
     */ 
    public function developmentpath() {
       
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        
        $showcaseRes = getUserShowcaseId($this->userId);
        // redirect to next step if member is fan
        if($showcaseRes->fans == 't') {
            redirect(base_url(lang().'/showcase/otherlanguage'));
        }
        $this->wizardheadingtext();
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        $this->data['showcaseRes']          = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['aboutYou4menu']        = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/about_you_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/development_section';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    /*
     * @description: This function is used to update showcase details from ajax request
     * @access: public
     * @return void
     */ 
    public function updateShowcaseDetails() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/showcase/showcasedetails');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedAboutSection');
        if(!empty($postData)) {
            // set update table name
            $updateTable = 'UserProfile';
            if(isset($postData['enterpriseName']) && !empty($postData['enterpriseName'])) {
                // update showcase business data
                $this->model_common->editDataFromTabel('UserShowcase',  array('enterpriseName'=>$postData['enterpriseName']), 'tdsUid', $this->userId);
                // set enterprise name in session values
                $this->session->set_userdata('enterpriseName',$postData['enterpriseName']);
            }
            // set update field and value 
            // update user's profile data
            $profileData = array('firstName'=>$postData['firstName'],'lastName'=>$postData['lastName'],'countryId'=>$postData['countryId']);
            $this->model_common->editDataFromTabel('UserProfile', $profileData, 'tdsUid', $this->userId);
            
            // set update field and value
            // update user's showcase data
            $userprofileData = array('firstName'=>$postData['firstName'],'lastName'=>$postData['lastName']);
            $this->model_common->editDataFromTabel('UserShowcase', $userprofileData, 'tdsUid', $this->userId);
            
            $userFullName   = $postData['firstName']." ".$postData['lastName']; // Full name Update
            
            // set data in session values
            // set data in session values
            $this->session->set_userdata(array('firstName'=>$postData['firstName'],'lastName'=>$postData['lastName'],'countryId'=>$postData['countryId'],'countryName'=>getCountry($postData['countryId']),'userFullName'=>$userFullName));
            // set mext page url
            $reditectUrl = base_url(lang().'/showcase/aboutsection');
            $type = 'success';
            $msg = $this->lang->line('UpdatedAboutSection');
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save development details
     * @access: public
     * @return void
     */ 
    public function setdevelopmentdetails() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/showcase/developmentpath');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedAboutSection');
        if(!empty($postData)) {
            
            // update user's showcase type id
            $UserShowcaseData = array('optionAreaName'=>$postData['optionAreaName'],'creativeFocus'=>$postData['creativeFocus'],'creativePath'=>$postData['creativePath']);
            $this->model_common->editDataFromTabel('UserShowcase', $UserShowcaseData, 'tdsUid', $this->userId);
            // set mext page url
            $reditectUrl = base_url(lang().'/showcase/otherlanguage');
            $type = 'success';
            $msg = $this->lang->line('UpdatedAboutSection');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
    /*
     * @description: This function is used to manage showcase in other language
     * @access: public
     * @return void
     */ 
    public function otherlanguage() {
       
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        
        // get post data
        $postData = $this->input->post();
        if(!empty($postData)) {
            if($postData['other_lang_type'] == 1) {
                redirect(base_url(lang().'/showcase/yourvideo'));
            } else {
                redirect(base_url(lang().'/showcase/addotherlanguage'));
            }
            
        }
        $showcaseRes = getUserShowcaseId($this->userId);
        $this->wizardheadingtext();
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        $this->data['showcaseRes']          = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['aboutYou5menu']        = 'TabbedPanelsTabSelected';
        $this->data['innerPage']           = 'showcase/wizardform/about_you_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/other_language_options';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    /*
     * @description: This function is used to manage showcase in other language
     * @access: public
     * @return void
     */ 
    public function addotherlanguage($showcaseLangId=0) {
       
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        
        $showcaseRes  = getUserShowcaseId($this->userId);
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        if(!empty($showcaseLangId) && (int)$showcaseLangId) {
            // set multilingual data
           $multilingualData =  $this->getMultilingualData($showcaseLangId);
        }
        $this->wizardheadingtext();
        // set form data
        $this->data['showcaseRes']         = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['multilingualData']    = (isset($multilingualData))?$multilingualData:'';
        $this->data['showcaseLangId']      = $showcaseLangId;
        $this->data['showcaseId']          = $showcaseRes->showcaseId;
        $this->data['s2menu']              = 'TabbedPanelsTabSelected';
        $this->data['aboutYou5menu']       = 'TabbedPanelsTabSelected';
        $this->data['innerPage']           = 'showcase/wizardform/multilingual_header';
        $this->data['subInnerPage']        = 'showcase/wizardform/multilingual_language';
        $this->data['multilingual1menu']   = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('createYourShowcase');
        
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    /*
     * @description: This function is used get showcase language data
     * @access: private
     * @return void
     */ 
    private function getMultilingualData($showcaseLangId=0) {
        if(!empty($showcaseLangId) && is_numeric($showcaseLangId)) {
            // where conditions
            $where = array('showcaseLangId'=>$showcaseLangId,'tdsUid'=>$this->userId,'isArchive'=>'f');
            // get showcase language data if exists
            $showcaseLangRes = $this->model_common->getDataFromTabel('UserShowcaseLang', '*',  $where,'','','',1);
            if(isset($showcaseLangRes[0]->showcaseLangId) && $showcaseLangRes[0]->showcaseLangId > 0)  {
               $showcaseLangRes =  $showcaseLangRes[0];
            }
        } 
        // set return values 
        if(isset($showcaseLangRes)) {
            return $showcaseLangRes;
        } else { // redirect to option page if data not exist
            $msg = $this->lang->line('multilangNotExist');
            set_global_messages($msg, $type='error', $is_multiple=true);
            redirect(base_url(lang().'/showcase/otherlanguage'));
        }
    }
    
     /*
     * @description: This function is used to save multilingual data
     * @access: public
     * @return void
     */ 
    public function setmutilingualdata() {
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/showcase/otherlanguage');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedAboutSection');
        if(!empty($postData)) {
            // set post values
            $showcaseLangId = $postData['showcaseLangId'];
            $langSection    = $postData['langSection']; 
            $showcaseId     = $postData['showcaseId'];
            $nextStep       = $postData['nextStep'];
            
            if($langSection == 'otherlanguage') {
                // update user's showcase type id
                $showcaseData = array('showcaseId'=>$showcaseId,'tdsUid'=>$this->userId,'langId'=>$postData['langaugeId'],'isPublished'=>'t');
            } elseif($langSection == 'aboutSection') {
                $showcaseData = array('showcaseId'=>$showcaseId,'tdsUid'=>$this->userId,'tagwords'=>$postData['tagwords'],'promotionalsection'=>$postData['promotionalsection']);
            } elseif($langSection == 'developmentSection') {
                $showcaseData = array('showcaseId'=>$showcaseId,'tdsUid'=>$this->userId,'optionAreaName'=>$postData['optionAreaName'],'creativeFocus'=>$postData['creativeFocus'],'creativePath'=>$postData['creativePath']);
            }
           
            if(!empty($showcaseLangId) && $showcaseLangId > 0) {
                // edit multilang data 
                $this->model_common->editDataFromTabel('UserShowcaseLang', $showcaseData, 'showcaseLangId', $showcaseLangId);
            } else {
                // add another lang data
                $showcaseLangId =  $this->model_common->addDataIntoTabel('UserShowcaseLang', $showcaseData);
            }
			// set user area in session
			if(!empty($postData['optionAreaName'])) {
				$this->session->set_userdata('userArea', $postData['optionAreaName']);
			}
            // set mext page url
            $reditectUrl = base_url(lang().'/showcase/'.$nextStep.'/'.$showcaseLangId);
            $type = 'success';
            $msg = $this->lang->line('UpdatedAboutSection');
        
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
    /*
     * @description: This function is used to manage about section
     * @access: public
     * @return void
     */ 
    public function aboutothersection($showcaseLangId=0) {
       
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        // set multilingual data
        $multilingualData =  $this->getMultilingualData($showcaseLangId);
        $this->wizardheadingtext();
        // set form data
        $this->data['showcaseRes']          = (isset($multilingualData))?$multilingualData:'';
        $this->data['showcaseLangId']       = $showcaseLangId;
        $this->data['showcaseId']           = $showcaseRes->showcaseId;
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['aboutYou5menu']        = 'TabbedPanelsTabSelected';
        $this->data['multilingual2menu']    = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/multilingual_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/multilang_about_section';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    /*
     * @description: This function is used to manage about section
     * @access: public
     * @return void
     */ 
    public function otherdevelopmentsection($showcaseLangId=0) {
       
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        
        $showcaseRes = getUserShowcaseId($this->userId);
        // redirect to next step if member is fan
        if($showcaseRes->fans == 't') {
            redirect(base_url(lang().'/showcase/yourvideo'));
        }
        $this->wizardheadingtext();
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        // set multilingual data
        $multilingualData =  $this->getMultilingualData($showcaseLangId);
       
        $this->data['showcaseRes']          = (isset($multilingualData))?$multilingualData:'';
        $this->data['showcaseLangId']       = $showcaseLangId;
        $this->data['showcaseId']           = $showcaseRes->showcaseId;
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['aboutYou5menu']        = 'TabbedPanelsTabSelected';
        $this->data['multilingual3menu']    = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/multilingual_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/multilingual_development_section';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    /*
     * @description: This function is used to manage next stage option
     * @access: public
     * @return void
     */ 
    public function whatnext($showcaseLangId=0) {
       
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        // set multilingual data
        
        $multilingualData =  $this->getMultilingualData($showcaseLangId);
        $this->wizardheadingtext();
        $this->data['showcaseLangId']       = $showcaseLangId;
        $this->data['s2menu']               = 'TabbedPanelsTabSelected';
        $this->data['aboutYou5menu']        = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/about_you_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/multilang_next_option';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
     /*
     * @description: This function is used to manage next step after add multi lang
     * @access: public
     * @return void
     */ 
    public function movenextoption() {
       
        $this->userId = $this->isLoginUser();
        // get post data
        $postData = $this->input->post();
        $redirectUrl = base_url(lang().'/showcase/yourvideo');
        if(!empty($postData)) {
            if($postData['next_step_type'] == 1) {
                $redirectUrl = base_url(lang().'/showcase/addotherlanguage');
            }
        }
        redirect($redirectUrl);
    }
    
     /*
     * @description: This function is used to manage showcase in other language
     * @access: public
     * @return void
     */ 
    public function yourvideo($videoType=0) {
        
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        //call method for plupload css and js add
        $this->_pluploadjsandcss();
       
        // set form data
        $this->data['showcaseRes']          = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['showcaseId']           = $showcaseRes->showcaseId;
        $this->data['videoType']            = $videoType;
        $this->data['s3menu']               = 'TabbedPanelsTabSelected';
        if($videoType == 0) {
            $this->data['yourVideo1menu']   = 'TabbedPanelsTabSelected';
            $this->data['dirUploadMedia']   = 'media/'.loginUserDetails('username').'/showcase/introductory/';
            if(!empty($showcaseRes->introductoryFileId)) {
                // where conditions
                $where = array('fileId'=>$showcaseRes->introductoryFileId);
            }
           
        } else {
            $this->data['yourVideo2menu']   = 'TabbedPanelsTabSelected';
            $this->data['dirUploadMedia']   = 'media/'.loginUserDetails('username').'/showcase/interview/';
            if(!empty($showcaseRes->interviewFileId)) {
                // where conditions
                $where = array('fileId'=>$showcaseRes->interviewFileId);
            }
        }
       
        // set media file data
        if(isset($where) && (!empty($showcaseRes->introductoryFileId) || !empty($showcaseRes->interviewFileId))) {
            // get media file data 
            $mediaFileData = $this->model_common->getDataFromTabel('MediaFile', 'filePath,rawFileName,isExternal',  $where,'','','',1);
            if(!empty($mediaFileData))  {
                $mediaFileData =  $mediaFileData[0];
            }
        }
        
        $this->wizardheadingtext();
        // set form data
        $this->data['mediaFileData']        = (isset($mediaFileData))?$mediaFileData:'';
        $this->data['innerPage']            = 'showcase/wizardform/video_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/add_video_form';
        print_r($this->data);
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    //-------------------------------------------------------------------------
    
    /*
    * @Description: This method is use to stage "3" of media uploage stage - 1
    * @access: public
    * @return: void
    * @author: lokendra
    */
     
    public function uploadfilepost() {
        
        if($this->input->is_ajax_request()) {

            $browseId           =   $this->input->post('browseId');
            
            //--------media data prepair for inserting------//
            $isFile             =   false;
            $media_fileName     =   $this->input->post('fileName'.$browseId);
            $isExternal         =   ($this->input->post('isExternal'.$browseId)=='t')?'t':'f';
            $embbededURL        =   $this->input->post('embbededURL'.$browseId);
            $fileUploadPath        =   $this->input->post('fileUploadPath'.$browseId);
            $videoType = $this->input->post('videoType');
            $isExternalFile     =   false;
            $mediaFileData=array();
            $nextUrl  = base_url_lang('showcase/yourvideo/'.$videoType) ;
            $msg = 'Check your uploaded file url';
            $type = 'error';
            
            if($media_fileName && strlen($media_fileName)>3){
                $isFile              =   true;
                //$fileType            =   getFileType($media_fileName);
                $fileType = 2;
                $isExternalFile      =   false;
                $mediaFileData       =   array(
                                        'filePath'      =>  $fileUploadPath,
                                        'fileName'      =>  $media_fileName,
                                        'fileType'      =>  $fileType,
                                        'tdsUid'        =>  $this->userId,
                                        'isExternal'    =>  'f',
                                        'fileSize'      =>  $this->input->post('fileSize'.$browseId),
                                        'rawFileName'   =>  $this->input->post('fileInput'.$browseId),
                                        'jobStsatus'    =>  'UPLOADING'
                                    );
                
            }elseif($embbededURL && strlen($embbededURL)>3){
                $isExternalFile = true;
                $embeddUrlStatus = getUrl($embbededURL); // check status of embedd url status
                if($embeddUrlStatus == true) {        
                $isFile             =   true;
                $fileType           =   2;
                $embbededURL        =   getUrl($embbededURL);
                $isExternalFile     =   true;
                $mediaFileData      =   array(
                                        'filePath'      =>  $embbededURL,
                                        'tdsUid'        =>  $this->userId,
                                        'fileType'      =>  $fileType,
                                        'isExternal'    =>  't',
                                        'jobStsatus'    =>  'DONE'
                                    );
                }
            }
            
            if($isFile){
                
                $fileLength = $this->input->post('fileLength');
                $mediaFileData['fileHeight'] = ($this->input->post('fileHeight')=="")?Null:$this->input->post('fileHeight');
                $mediaFileData['fileWidth'] = ($this->input->post('fileWidth')=="")?Null:$this->input->post('fileWidth');
                $mediaFileData['fileUnit'] = ($this->input->post('fileUnit')=="")?Null:$this->input->post('fileUnit');
                
                $fileId = $this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);
        
            }else{
                $fileId=0;
            }
            //next page url
           
            if($fileId > 0){
                 $nextUrl  = base_url(lang().'/showcase/communication') ;
                $interviewTitle = $this->input->post('interviewTitle');
                $introductoryTitle = $this->input->post('introductoryTitle');
                $videoType = $this->input->post('videoType');
                // update video fields
                $updateData = array('interviewFileId'=>$fileId,'interviewTitle'=>$interviewTitle);
                if($videoType == 0) {
                    // update video fields
                    $updateData = array('introductoryFileId'=>$fileId,'introductoryTitle'=>$introductoryTitle);
                    //next page url
                    $nextUrl  = base_url(lang().'/showcase/yourvideo/1') ;
                }
                // edit multilang data 
                $this->model_common->editDataFromTabel('UserShowcase', $updateData, 'tdsUid', $this->userId);
                 $msg='Media file uploaded successfully';
                  $type='success';
                 
            }
            
           
            
           
            set_global_messages($msg, $type, $is_multiple=true);
            $returnData=array('msg'=>$msg,'fileId'=>$fileId,'nextUrl'=>$nextUrl,'isExternalFile'=>$isExternalFile);
            echo json_encode($returnData);
        }
    }
    
    /*
     * @description: This function is used to manage communication section
     * @access: public
     * @return void
     */ 
    public function communication() {
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
      
        $this->isbusinessarea($showcaseRes);
        $this->wizardheadingtext();
      
        $this->data['showcaseRes']          = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['s4menu']               = 'TabbedPanelsTabSelected';
        $this->data['communication1menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/communication_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/communication_add_button';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to save communication contact options
     * @access: public
     * @return void
     */ 
    public function setcommcontactoption() {
        // get post values
        $postData = $this->input->post();
       
        // set default redirect url
        $reditectUrl = base_url(lang().'/showcase/communication');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedAboutSection');
        // set communication options status
        $showcaseData = array('memberReviewMe'=>'f','recommendMe'=>'f','reviewMe'=>'f');
        if($postData['memberReviewMe']) {
            $showcaseData['memberReviewMe'] = 't';
        }
        if($postData['recommendMe']) {
            $showcaseData['recommendMe'] = 't';
        }
        if($postData['reviewMe']) {
            $showcaseData['reviewMe'] = 't';
        }
        
        // update user's showcase type id
        $this->model_common->editDataFromTabel('UserShowcase', $showcaseData, 'tdsUid', $this->userId);
        // set mext page url
        $reditectUrl = base_url(lang().'/showcase/addcommicationlinks');
        $type = 'success';
        $msg = $this->lang->line('UpdatedAboutSection');
        set_global_messages($msg, $type, $is_multiple=true);
        redirectPage($reditectUrl);
    }
    
    /*
     * @description: This function is used to manage communication add links
     * @access: public
     * @return void
     */ 
    public function addcommicationlinks() {
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        $this->wizardheadingtext();
        
        $this->data['showcaseRes']          = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['s4menu']               = 'TabbedPanelsTabSelected';
        $this->data['communication2menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/communication_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/communication_add_link';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
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
        $reditectUrl = base_url(lang().'/showcase/addcommicationlinks');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedAboutSection');
        if(!empty($postData)) {
            
            // update user's showcase type id
            $UserShowcaseData = array('websiteUrl'=>$postData['websiteUrl']);
            $this->model_common->editDataFromTabel('UserShowcase', $UserShowcaseData, 'tdsUid', $this->userId);
            // set mext page url
            $reditectUrl = base_url(lang().'/showcase/socialmedialinks');
            $type = 'success';
            $msg = $this->lang->line('UpdatedAboutSection');
        
        }
      
     
        set_global_messages($msg, $type, $is_multiple=true);
        echo json_encode(array('nextStep'=>$reditectUrl));
    }
    
     /*
     * @description: This function is used to manage social media links
     * @access: public
     * @return void
     */ 
    public function socialmedialinks() {
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        
      
        
        $entityId = getMasterTableRecord('UserShowcases');
        $showcaseId = LoginUserDetails('showcaseId');
        // get social media links
        $socialMediaData = $this->model_showcase->getSocialMediaData($this->userId);
         $this->wizardheadingtext();
        $this->data['socialMediaData']      = $socialMediaData;
        $this->data['showcaseRes']          = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['s4menu']               = 'TabbedPanelsTabSelected';
        $this->data['communication3menu']   = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/communication_header';
        $this->data['subInnerPage']         = 'showcase/wizardform/communication_social_link';
        $this->data['packagestageheading']  = $this->lang->line('createYourShowcase');
        
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage showcase edit view
     * @access: public
     * @return void
     */ 
    public function editshowcase() {
       
        $this->userId = $this->isLoginUser();
        // get showcase records
        $showcaseRes = getUserShowcaseId($this->userId);
        
        //if user isCompleted is "true" then show this section
        /*if($showcaseRes->isCompleted!="t"){
            $msg = "Your showcase not complete.";
            set_global_messages($msg, "error", true);
            redirect(base_url_lang("home"));
        }*/
        
       
        
        // set edit showcase value session
        $this->session->set_userdata('isShowcaseEdit',1);
        
        $this->data['packagestageheading']  = $this->lang->line('editYourShowcase');
        // set data for showcase form
        if($showcaseRes->enterprise == 't') {
            $this->data['isEnterprise'] = true;
            $this->data['packagestageheading']  = $this->lang->line('editYourBusinessShowcase');
        }
        $showcaseId = LoginUserDetails('showcaseId');
        // get projects log summary
        $showcaseEntityId = getMasterTableRecord('UserShowcase');
        $logSummryDta = $this->model_common->getDataFromTabel('LogSummary','craveCount,viewCount,ratingAvg,reviewCount',array('entityId'=>$showcaseEntityId,'elementId'=>$showcaseId), '','','',1);
        $logSummryDta = $logSummryDta[0];
        // get users subscription type
        $subscriptionType = getSubscriptionType();
        // get container details
        $containerInfo = getUserContainerSpace($this->dirUser, $this->userId, $subscriptionType);
        // get multilang data
        $multilangData = $this->model_common->getDataFromTabel('UserShowcaseLang','langId,showcaseLangId',array('showcaseId'=>$showcaseId), '','','','');
        // set form data
         $this->wizardheadingtext();
        $this->data['showcaseRes']   = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['multilangData'] = $multilangData;
        $this->data['userId']        = $this->userId;
        $this->data['subscriptionType'] = $subscriptionType;
        $this->data['viewCount']     = (isset($logSummryDta->viewCount))?$logSummryDta->viewCount:0;
        $this->data['craveCount']    = (isset($logSummryDta->craveCount))?$logSummryDta->craveCount:0;
        $this->data['ratingAvg']     = (isset($logSummryDta->ratingAvg))?$logSummryDta->ratingAvg:0;
        $this->data['reviewCount']   = (isset($logSummryDta->reviewCount))?$logSummryDta->reviewCount:0;
        $this->data['containerSize'] = (isset($containerInfo['containerSize']))?$containerInfo['containerSize']:'';
        $this->data['remainingSize'] = (isset($containerInfo['remainingSize']))?$containerInfo['remainingSize']:'';
        $this->data['packagestageheading']  = $this->lang->line('editYourShowcase');
        $this->new_version->load('new_version','wizardform/showcase_edit',$this->data);
    }
    
    /**
     * add social media links 
     * @access public
     */
    public function addSocialMedia() {
        
       /* set post values */
        $valuesArray = array(
            'socialLink'=>$this->input->post('socialLink'),
            'profileSocialLinkType'=>$this->input->post('profileSocialLinkType'),
            'entityId'=>0,
            'socialLinkArchived'=>'f',
            'position'=>$this->input->post('profileSocialLinkType')>0?$this->input->post('profileSocialLinkType'):1,
            'socialLinkDateCreated'=>date("Y-m-d H:i:s"),
            'socialLinkDateModified'=>date("Y-m-d H:i:s"),
            'userId'=>$this->userId,
        );
        
        $profileSocialLinkId = $this->input->post('profileSocialLinkId');
        if(!empty($profileSocialLinkId)) {
            $valuesArray['profileSocialLinkId'] = $profileSocialLinkId;
            $msg = 'You have successfully update Social Media';
        } else {
            $msg = 'You have successfully save Social Media';
        }
        /* manage social media data saving */
        $mediaId = $this->model_showcase->addSocialMediaData($valuesArray);
        
        set_global_messages($msg, $type='success', $is_multiple=false);
        
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage showcase preview n publish page
     * @access: public
     * @return void
     */ 
    public function previewnpublishhowcase() {
        $this->userId = $this->isLoginUser();
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
      
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        // set form data
         $this->wizardheadingtext();
        $this->data['showcaseRes']          = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['s5menu']               = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/prev_n_publish';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage showcase publish
     * @access: public
     * @return void
     */ 
    public function publishshowcase() {
        $this->userId = $this->isLoginUser();
        
        /* To check Showcase Publish Status */
        $getShowcaseData =  $this->model_common->getDataFromTabel($this->showcaseTableName, 'isPublished',  array('tdsUid'=>$this->userId),'','','',1); 
        if($getShowcaseData[0]->isPublished == 'f')
        {
            $type = 'error';
            $msg = 'Before publicise , publish your showcase first ';
            set_global_messages($msg, $type, $is_multiple=true);
            $redirectUrl = base_url(lang().'/showcase/previewnpublishhowcase');
            redirect($redirectUrl);
            
        }
        
        //call current stage update for showcase complete
        $dataArray = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
        currentStage($dataArray);
        
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
        $this->isbusinessarea($showcaseRes);
        // set form data
        $this->wizardheadingtext();
        $this->data['isPublished']          = $showcaseRes->isPublished;
        $this->data['s5menu']               = 'TabbedPanelsTabSelected';
        $this->data['innerPage']            = 'showcase/wizardform/publish_showcase';
        $this->new_version->load('new_version','wizardform/wizard',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage showcase publish
     * @access: public
     * @return void
     */ 
    public function managepublishstatus($showcaseId) {
                
                $this->userId = $this->isLoginUser();
                // get showcase records
                $showcaseRes = getUserShowcaseId($this->userId);
                // get post values
                $postData = $this->input->post();
                // set default redirect url
                $reditectUrl = base_url(lang().'/showcase/editshowcase');
                $type = 'error';
                $msg = $this->lang->line('errorUpdatedAboutSection');
                $getShowcaseData =  $this->model_common->getDataFromTabel($this->showcaseTableName, 'isPublished',  array('showcaseId'=>$showcaseId),'','','',1); 
                if(!empty($getShowcaseData)) {
           
                    $getProjectData = $getShowcaseData[0];
                    $isPublished = ($getProjectData->isPublished == 'f') ? 't' : 'f'; // set publish value
                    $UserShowcaseData = array('isPublished'=>$isPublished);
                   
                    if($showcaseRes->userContainerId == 0) {
                        // set container id in showcase 
                        $entityId = getMasterTableRecord('UserShowcase');
                        // get showcase product id
                        $tsProductId = $this->config->item('tsProductId_ShowcaseHomepage');
                        // get container record
                        $containerRes = $this->model_common->getDataFromTabel('UserContainer','userContainerId',array('tsProductId'=>$tsProductId,'tdsUid'=>$this->userId), '','','','');
                        
                        if(!empty($containerRes)) {
                            $userContainerId = $containerRes[0]->userContainerId;
                            $this->lib_package->updateUserContainer($userContainerId,$entityId,$showcaseRes->showcaseId,$tsProductId,'');
                            $UserShowcaseData['userContainerId'] = $userContainerId ;
                        }
                    }
                    
                    $yourToadSquare = array('isPublished'=>$isPublished);
                    
                    
                    // update user's showcase type id
                    $this->model_common->editDataFromTabel('UserShowcase', $UserShowcaseData, 'tdsUid', $this->userId);
                   
                   
                    //if showcase published then current stage will be blank and isCompleted is true
                    if($isPublished == "t"){
                        $yourToadSquare['currentStage'] = '';
                        $yourToadSquare['isCompleted'] = 't';
                        
                        // set mext page url
                        $reditectUrl = base_url(lang().'/showcase/publishshowcase');
                    }
                    //update is completed & publish in your toadsquare
                    $whereCondi = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
                    $this->model_common->editDataFromTabel('YourToadsquare', $yourToadSquare, $whereCondi);
                    
                    
                   
                    $type = 'success';
                    $msg = $this->lang->line('UpdatedAboutSection');
                }
                set_global_messages($msg, $type, $is_multiple=true);
                redirectPage($reditectUrl);
           
    }
    
    //-----------------------------------------------------------------------
    /*
     * @description: This function is used to save showcase publish status
     * @access: public
     * @return void
     * Tosif sir 
     */ 
    public function setpubliciseOld() {
		$this->userId = $this->isLoginUser();
		// get showcase records
		$showcaseRes = getUserShowcaseId($this->userId);
        // get post values
        $postData = $this->input->post();
        // set default redirect url
        $reditectUrl = base_url(lang().'/showcase/publishshowcase');
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedAboutSection');
        
        if(!empty($postData)) {
			$UserShowcaseData = array('isPublished'=>$postData['isPublished']);
			
			if($showcaseRes->userContainerId == 0) {
				// set container id in showcase 
				$entityId = getMasterTableRecord('UserShowcase');
				// get showcase product id
				$tsProductId = $this->config->item('tsProductId_ShowcaseHomepage');
				// get container record
				$containerRes = $this->model_common->getDataFromTabel('UserContainer','userContainerId',array('tsProductId'=>$tsProductId,'tdsUid'=>$this->userId), '','','','');
				
				if(!empty($containerRes)) {
					$userContainerId = $containerRes[0]->userContainerId;
					$this->lib_package->updateUserContainer($userContainerId,$entityId,$showcaseRes->showcaseId,$tsProductId,'');
					$UserShowcaseData['userContainerId'] = $userContainerId ;
				}
			}
            
            $yourToadSquare = array('isPublished'=>$postData['isPublished']);
			
            
            // update user's showcase type id
            $this->model_common->editDataFromTabel('UserShowcase', $UserShowcaseData, 'tdsUid', $this->userId);
           
           
            //if showcase published then current stage will be blank and isCompleted is true
            if($postData['isPublished']=="t"){
                $yourToadSquare['currentStage'] = '';
                $yourToadSquare['isCompleted'] = 't';
            }
            //update is completed & publish in your toadsquare
            $whereCondi = array('entityid'=>getMasterTableRecord('UserShowcase'),'projectid'=>LoginUserDetails('showcaseId'));
            $this->model_common->editDataFromTabel('YourToadsquare', $yourToadSquare, $whereCondi);
            
            
            // set mext page url
            $reditectUrl = base_url(lang().'/showcase/editshowcase');
            $type = 'success';
            $msg = $this->lang->line('UpdatedAboutSection');
        }
        set_global_messages($msg, $type, $is_multiple=true);
        redirectPage($reditectUrl);
    }
    
    
    // -----------------------------------------------------
    /*
     * @description: This function is used to save showcase publish status
     * @access: public
     * @return void
     * modified Date - 17-04-15
     */ 
    public function setpublicise() {
		// get form post data
        $postData = $this->input->post();
		$nextStep = base_url(lang().'/showcase/editshowcase');
        if( isset($postData['isPublished']) ) {
            $isPublished = ($postData['isPublished']=='t') ? 't' : 'f'; // set publish status
            $projId = $postData['showcaseId']; // set upcoming project id
            $projData = array('isPublished'=>$isPublished); // set update fields
            
            // set next url
            if($isPublished == 't') {
				$nextStep = base_url_lang('showcase/share'); 
            }
        }
       
        redirect($nextStep); 
    }
    
    //-----------------------------------------------------------------------
    
    
    public function share()
    {
        $baseUrl = base_url(lang().'/showcase');
        $this->userId = $this->isLoginUser();
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
        $shareURL = lang()."/showcase/index/$this->userId";
        // set form data
        $this->wizardheadingtext();
        
        $this->data['showcaseRes']          = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['backurl']              = $baseUrl.'/publishshowcase';
		$this->data['nexturl']              = $baseUrl.'/email';
        $this->data['shareMenu']            = 'TabbedPanelsTabSelected';
        $this->data['shortLink']            = $this->model_common->getShortLink($shareURL,$this->userId);
        $this->data['innerPage']            = 'share/share_with_social_media';
        $this->new_version->load('new_version','wizardform/wizard_additionalInfo',$this->data);
        
    }
    
    
    
    /*
     * @description: This function is used manage showcase email
     * @access: public
     * @return void
     */ 
    public function email() {
       
		// set base url
		$baseUrl = base_url(lang().'/showcase');
		// prepare short link
        $shareURL = lang()."/showcase/index/$this->userId";
        // set data for upcoming form
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
        $shareURL = lang()."/showcase/index/$this->userId";
        // set form data
        $this->wizardheadingtext();
        $this->data['showcaseRes']          = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['backurl']              = $baseUrl.'/share';
		$this->data['nexturl']              = $baseUrl.'/prnews';   
        $this->data['shortLink']      = $this->model_common->getShortLink($shareURL,$this->userId);
        $this->data['emailMenu']      = 'TabbedPanelsTabSelected';
        $this->data['innerPage']      = 'share/share_with_email';
        $this->new_version->load('new_version','wizardform/wizard_additionalInfo',$this->data);
    }
    
     
     /*
     * @description: This function is used manage upcoming pr material
     * @access: public
     * @return void
     */ 
    public function prnews() {
       
		// get upcoming project data
		$baseUrl = base_url(lang().'/showcase');
		// prepare short link
        $shareURL = lang()."/showcase/index/$this->userId";
        // set data for upcoming form
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
        $shareURL = lang()."/showcase/index/$this->userId";
        $entityId=getMasterTableRecord('UserShowcase');
        // set data for upcoming form
        $this->wizardheadingtext(); // set navigation bar heading
		$this->data['backurl']        = $baseUrl.'/email';
		$this->data['nexturl']        = $baseUrl.'/prreviews';
        $this->data['table']          = 'AddInfoNews';   
        $this->data['shortLink']      = $this->model_common->getShortLink($shareURL,$this->userId);
        $this->data['showcaseRes']    = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['entityId']       = $entityId;
        $this->data['projectIndexLink']  = base_url($shareURL);
         $this->data['PRMenu']         = 'TabbedPanelsTabSelected';
        $this->data['PRnewsMenu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']      = 'wizardform/prmaterial';
        $this->new_version->load('new_version','wizardform/wizard_additionalInfo',$this->data);
    }
    
    
    
    
    
    /*
     * @description: This function is used manage upcoming pr material
     * @access: public
     * @return void
     */ 
    public function prreviews($upcomingprojId=0) {
       
       	// get upcoming project data
		$baseUrl = base_url(lang().'/showcase');
		// prepare short link
        $shareURL = lang()."/showcase/index/$this->userId";
        // set data for upcoming form
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
        $shareURL = lang()."/showcase/index/$this->userId";
        // set data for upcoming form
        $this->wizardheadingtext(); // set navigation bar heading
		$this->data['backurl']        = $baseUrl.'/prnews';
		$this->data['nexturl']        = $baseUrl.'/prreinterviews';
        $this->data['table']          = 'AddInfoReviews';   
        $this->data['shortLink']      = $this->model_common->getShortLink($shareURL,$this->userId);
        $this->data['showcaseRes']    = (isset($showcaseRes))?$showcaseRes:'';
        $this->data['projectIndexLink']  = base_url($shareURL);
    $this->data['PRMenu']         = 'TabbedPanelsTabSelected';
        $this->data['PRreviewsMenu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']      = 'wizardform/prmaterial';
        $this->new_version->load('new_version','wizardform/wizard_additionalInfo',$this->data);
		
      
    }
    
    /*
     * @description: This function is used manage upcoming pr material
     * @access: public
     * @return void
     */ 
    public function prreinterviews($upcomingprojId=0) {
       
	    
       	// get upcoming project data
		$baseUrl = base_url(lang().'/showcase');
		// prepare short link
        $shareURL = lang()."/showcase/index/$this->userId";
        // set data for upcoming form
        $showcaseRes = getUserShowcaseId($this->userId);
        // set data for showcase form
        $shareURL = lang()."/showcase/index/$this->userId";
        // set data for upcoming form
        $this->wizardheadingtext(); // set navigation bar heading
		$this->data['backurl']        = $baseUrl.'/prreviews';
		$this->data['nexturl']        = base_url($shareURL);
        $this->data['table']          = 'AddInfoInterview';   
        $this->data['shortLink']      = $this->model_common->getShortLink($shareURL,$this->userId);
      $this->data['showcaseRes']    = (isset($showcaseRes))?$showcaseRes:'';
          $this->data['PRMenu']         = 'TabbedPanelsTabSelected';
        $this->data['PRinterviewsMenu']     = 'TabbedPanelsTabSelected';
        $this->data['innerPage']      = 'wizardform/prmaterial';
        $this->new_version->load('new_version','wizardform/wizard_additionalInfo',$this->data);
    }
    
     
    //-----------------------------------------------------------------------
        /*
     * @description: This function is used to manage enterprise area
     * @access: private
     * @return void
     */ 
    private function isbusinessarea($showcaseRes='') {
        // set data for showcase form
        $this->data['packagestageheading']  = $this->lang->line('createYourShowcase');
        if($showcaseRes->enterprise == 't') {
            $this->data['isEnterprise'] = true;
            $this->data['packagestageheading']  = $this->lang->line('createYourBusinessShowcase');
        } elseif($showcaseRes->fans == 't') {
            $this->data['isFans'] = true;
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage received recommandations
     * @access: public
     * @return void
     */ 
    public function managerecommendations() {
        $this->data['userId'] = $this->isLoginUser();
        // set form data
        $this->data['packagestageheading']  = $this->lang->line('manageRecommendation');
        $this->new_version->load('new_version','wizardform/recommendation_received',$this->data);
	}
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage given recommandations
     * @access: public
     * @return void
     */ 
    public function givenrecommendations() {
        $this->data['userId'] = $this->isLoginUser();
        // set form data 
        $this->data['packagestageheading']  = $this->lang->line('manageRecommendation');
        $this->new_version->load('new_version','wizardform/recommendation_given',$this->data);
	}
    
    //----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to manage membership cart under stage 1
	 * @return void
	 */ 
	public function membershipcart() {
        
        $this->userId = $this->isLoginUser();
		// get showcase id
        $showcaseId = LoginUserDetails('showcaseId');
		// get entity id
		$entityId    = getMasterTableRecord('UserShowcase');
		redirect('membershipcart/managecart/'.$entityId.'/'.$showcaseId);
		/*
		// get user's showcase details
        $showcaseRes = getUserShowcaseId($this->userId);
        
        $userContainerId = $showcaseRes->userContainerId;
    
        //----- start manage data for edit project's add space 
        // set project id in session for add space
        $this->session->set_userdata('addSpaceShowcaseId',$showcaseId);
        // set user container id in session for add space
        $this->session->set_userdata('showcaseContainerId',$userContainerId);
       
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
		
        // load industry typr lang file
        $this->load->language('media');
		$this->data['mediaCartData']    = $mediaCartData;
		$this->data['subscriptionType'] = $subscriptionType;
        $this->data['innerPage'] = 'wizardform/membership_cart';
		$this->data['s1menu'] = 'TabbedPanelsTabSelected';
        $this->data['membership2menu'] = 'TabbedPanelsTabSelected';
        $this->data['showcaseImagePath'] = $this->getprofileimage($showcaseRes);
        $this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
		$this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);
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
		// set showcase product id
        $data['tsProductId'] = $this->config->item('tsProductId_ShowcaseHomepage');
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
            $showcaseContainerId = $this->session->userdata('showcaseContainerId'); 
            if(!empty($showcaseContainerId) && $data['subscriptionType'] != 1 ) {
                $elementId   = $this->session->userdata('addSpaceShowcaseId'); 
                $entityId    = getMasterTableRecord('UserShowcase');
                $containerId = $showcaseContainerId;
            } else {
                /*if( !empty($availableContainer) && count($availableContainer) > 0 ) {
                    // set user container id
                    $containerId = $availableContainer->userContainerId; 
                } else {
                    // add container temp item data
                    $parentCartItem = $this->addContainerMediaItem($cartId,$data,$cartValues,$pkgRoleId);
                }*/
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

			$nextStep = 'showcase/billingdetails'; // set next step as billing page
		}
        redirect($nextStep);
    }
    
    //----------------------------------------------------------------------

	/*
	 * @access: private
	 * @description: This function is used to set cart values as subscription 
	 * @return string
	 */ 
    private function setcartvalues($data) {
		
        // manage add space type if container id exists
        $showcaseContainerId = $this->session->userdata('showcaseContainerId'); 
        if(!empty($showcaseContainerId)) {
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
	 * @description: This function is used to manage billing information
	 * @return string
	 */ 
	public function billingdetails() {
		
		// get users profile details
		$userProfileData = $this->model_media->getUserProfileData($this->userId);
		$userProfileData =  (!empty($userProfileData[0]))?$userProfileData[0]:''; 
		$this->load->language('media');
		$this->data['userProfileData'] = $userProfileData; # set user profile data 
        $this->data['innerPage'] = 'showcase/wizardform/billing_details';
        $this->data['membership3menu'] = 'TabbedPanelsTabSelected';
        $this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
		$this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);
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
		$nextStep = 'showcase/billingdetails'; // set default next step as blank
       
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
		
		redirect('showcase/'.$nextStep);
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
			redirect(base_url(lang().'/showcase/editshowcase'));
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
        $this->data['innerPage'] = 'wizardform/purchase_summary';
        $this->data['membership4menu'] = 'TabbedPanelsTabSelected';
		$this->data['packagestageheading'] = $this->lang->line('addStorageSpace');
		$this->new_version->load('new_version','wizardform/membership_cart_header',$this->data);
		
	}
    
      //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to show payment success view
     * @return void
     */ 
    
    public function paymentsuccess() {
        // get showcase container id
        $showcaseContainerId = $this->session->userdata('showcaseContainerId');
        $nextStep = '';
        $type = 'error';
        $msg = $this->lang->line('errorUpdatedAddSpace');
        if(!empty($showcaseContainerId)) {
            
            // set showcase id in session for add space
            $addSpaceShowcaseId  = $this->session->userdata('addSpaceShowcaseId');
          
            if(!empty($addSpaceShowcaseId)) {

                // update space for free member
                $this->updatefreeaddpace();
                $nextStep = 'showcase/editshowcase';
                // unset session values
                $this->session->unset_userdata('addSpaceShowcaseId');
                $this->session->unset_userdata('showcaseContainerId');
                $type = 'success';
                $msg = $this->lang->line('successUpdatedAddSpace');
            }
        }
        set_global_messages($msg, $type, $is_multiple=true);
        redirect($nextStep);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to get update ad space of project
     * @return void
     */ 
    private function updatefreeaddpace() {
        // get showcase container id
        $showcaseContainerId = $this->session->userdata('showcaseContainerId');
        //get logged user subscription details
        $whereSubcrip    = array('tdsUid' => $this->userId);
        $subcripDetails  = $this->model_common->getDataFromTabel('UserSubscription', 'subscriptionType',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($subcripDetails) && !empty($showcaseContainerId)) {
            $subscriptionType  = $subcripDetails[0]->subscriptionType; // set subscription type
            if( $subscriptionType == 1 ) { //set space values for free type
                // get item's space size  
                $itemMembershipRes = $this->model_media->getItemContainerSize($showcaseContainerId);
                if(!empty($itemMembershipRes)) {
                    // add total space
                    $addSpace = intval($itemMembershipRes[0]->containerSize) + intval($itemMembershipRes[0]->size);
                    // update added space
                    $this->model_common->editDataFromTabel('UserContainer', array('containerSize'=>$addSpace), array('userContainerId' => $showcaseContainerId));
                }
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to manage association with you
     * @access: public
     * @return void
     */ 
    public function associateshowcase() {
        // check user is login
        $this->isLoginUser();
        // get showcase id
        $showcaseId = LoginUserDetails('showcaseId');
        //get associated data
        $whereSubcrip    = array('to_showcaseid' => $showcaseId);
        $associatedDetails  = $this->model_common->getDataFromTabel('AssociatedEnterprise', '*',  $whereSubcrip, '', $orderBy='id', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($associatedDetails)) {
            $associatedDetails  = $associatedDetails[0];
            $from_showcaseid = $associatedDetails->from_showcaseid;
            // get user's showcase details
            $showcaseData = $this->model_common->getUserShowcaseDetails($from_showcaseid);
        }
      
        // set form data
        $this->data['associateShowcaseData'] = (isset($showcaseData))?$showcaseData[0]:'';
        $this->data['packagestageheading']   = $this->lang->line('associateShowcase');
        $this->new_version->load('new_version','wizardform/associated_with',$this->data);
	}
    
     /*
     * @Description: This method is use to get elements search 
     * @access: public
     * @return: void
     */
    public function searchenterprises() {
        // check user is login
        $this->isLoginUser();
        // set post data
        $keyword = $this->input->post('val1');
        $this->data['keyword']=$keyword;
        // get industry list
        $this->data['sectionList']  =  getIndustryList();
        $this->data['searchResult'] = $this->searchenterprisesresult(true,$keyword);
        $this->load->view('wizardform/associated_member_search',$this->data);
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get elements search 
     * @access: public
     * @return: void
     */
    public function searchenterprisesresult($loadView=false,$keyword='') {
        // get showcase id
        $showcaseId = LoginUserDetails('showcaseId');
        // get industry section id
        $sectionId = $this->input->post('sectionId')?$this->input->post('sectionId'):'';
        // set keyword value
        if(empty($keyword)) {
            $keyword = $this->input->post('keyWord')?$this->input->post('keyWord'):'';
        }
        $isSetCookie = setPerPageCookie('searchPerPageVal',$this->config->item('perPageRecord'));	
        $pages = new Pagination_new_ajax;
        // get project's elements list
        $resultCounts = $this->model_showcase->getenterprisedata($keyword);
        $pages->items_total = count($resultCounts);
        $this->data['perPageRecord'] = $this->config->item('perPageRecord');
        $pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$isSetCookie;
        $pages->paginate();
        // get project's elements list
        $searchData = $this->model_showcase->getenterprisedata($keyword, $pages->limit, $pages->offst, $sectionId);
        // set pagination links and pages
        $this->data['items_total'] = $pages->items_total;
        $this->data['items_per_page'] = $pages->items_per_page;
        $this->data['pagination_links'] = $pages->display_pages();
        $pages->paginate($isShowButton=true,$isShowNumbers=false);
        $this->data['searchData']   = $searchData;
        $searchResultView = $this->load->view('wizardform/enterprise_members_search_result',$this->data,$loadView);
       if($loadView){
            return $searchResultView;
        }
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to add association data
     * @access: public
     * @return: void
     */
    public function setassociatedenterprise() {
        // get post values
        $postData = $this->input->post();
        $type = 'error';
        $msg = $this->lang->line('errorSaveAssociate');
        if(!empty($postData)) {
            // get showcase id
            $showcaseId = LoginUserDetails('showcaseId');
            // manage insert data
            $associationData = array('from_showcaseid'=>$postData['showcaseId'],'to_showcaseid'=>$showcaseId);
            $this->model_common->addDataIntoTabel('AssociatedEnterprise', $associationData);
            // set success msg
            $type = 'success';
            $msg = $this->lang->line('addAssociate');
        }
        set_global_messages($msg, $type, $is_multiple=true);
    }
    
     //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get association
     * @access: public
     * @return: void
     */
    public function association() {
        // check user is login
        $this->isLoginUser();
        // get showcase id
        $showcaseId = LoginUserDetails('showcaseId');
        //get non active associated data
        $nonActiveAssociation  = $this->model_showcase->getassociatedshowcasedata($showcaseId,0);
        //get active associated data
        $activeAssociation  = $this->model_showcase->getassociatedshowcasedata($showcaseId,1);
         // set form data
        $this->data['nonActiveAssociation']  = (isset($nonActiveAssociation))?$nonActiveAssociation:'';
        $this->data['activeAssociation']     = (isset($activeAssociation))?$activeAssociation:'';
        $this->data['packagestageheading']   = $this->lang->line('associateShowcase');
        $this->new_version->load('new_version','wizardform/association',$this->data);
    }
    
     //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to change enterprise status
     * @access: public
     * @return: void
     */
    public function setassociatestatus() {
        // get post values
        $postData = $this->input->post();
        $type = 'error';
        $msg = $this->lang->line('errorSaveAssociate');
        if(!empty($postData)) {
            // get showcase id
            $showcaseId = LoginUserDetails('showcaseId');
            // set associate id
            $associateId = $postData['associateId'];
            // set status type
            $statusType = $postData['statusType'];
            if($statusType == 1 || $statusType == 2) {
                // manage insert data
                $associationData = array('status'=>$statusType);
                // update buyer billing data
                $this->model_common->editDataFromTabel('AssociatedEnterprise', $associationData, 'id', $associateId);
                 $msg = $this->lang->line('changeAssociate');
            } else {
                $whereAE= array('id'=>$associateId);
                $countAE=$this->model_common->countResult('AssociatedEnterprise', $whereAE,'from_showcaseid', '', 1);
                if($countAE > 0){
                    $this->model_common->deleteRowFromTabel('AssociatedEnterprise', $whereAE); 
                }
                $msg = $this->lang->line('removeAssociate');
            }
            // set success msg
            $type = 'success';
            
        }
        set_global_messages($msg, $type, $is_multiple=true);
    }
    
     /*
     * @Description: This method is use to get members search 
     * @access: public
     * @return: void
     */
    public function searchmembers() {
        // check user is login
        $this->isLoginUser();
        // set post data
        $keyword = $this->input->post('val1');
        $this->data['keyword']=$keyword;
        // get industry list
        $this->data['sectionList']  =  getIndustryList();
        $this->data['searchResult'] = $this->searchmembersresult(true,$keyword);
        $this->load->view('wizardform/member_search',$this->data);
    }
    
    //-------------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get elements search 
     * @access: public
     * @return: void
     */
    public function searchmembersresult($loadView=false,$keyword='') {
        // set showcase id
        $showcaseId = LoginUserDetails('showcaseId');
        // set industry section id
        $sectionId = $this->input->post('sectionId')?$this->input->post('sectionId'):'';
        // set user type
        $userType = $this->input->post('usertype')?$this->input->post('usertype'):'';
        // set keyword value
        if(empty($keyword)) {
            $keyword = $this->input->post('keyWord')?$this->input->post('keyWord'):'';
        }
         // set user type value
        if(empty($userType)) {
            $userType = $this->input->post('userType')?$this->input->post('userType'):'';
        }
        $isSetCookie = setPerPageCookie('searchPerPageVal',$this->config->item('perPageRecord'));	
        $pages = new Pagination_new_ajax;
        // get project's elements list
        $resultCounts = $this->model_showcase->getmemberdata($keyword);
        $pages->items_total = count($resultCounts);
        $this->data['perPageRecord'] = $this->config->item('perPageRecord');
        $pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$isSetCookie;
        $pages->paginate();
        // get project's elements list
        $searchData = $this->model_showcase->getmemberdata($keyword, $pages->limit, $pages->offst, $sectionId,$userType);
        // set pagination links and pages
        $this->data['items_total'] = $pages->items_total;
        $this->data['items_per_page'] = $pages->items_per_page;
        $this->data['pagination_links'] = $pages->display_pages();
        $pages->paginate($isShowButton=true,$isShowNumbers=false);
        $this->data['searchData']   = $searchData;
        $searchResultView = $this->load->view('wizardform/members_search_result',$this->data,$loadView);
       if($loadView){
            return $searchResultView;
        }
    }
    
     //-----------------------------------------------------------------------
    
    /*
     * @description: This function is used to remove associate data
     * @access: public
     * @return void
     */ 
    public function removeassociate() {
        $from_showcaseid = $this->input->post('from_showcaseid');
        $deleted = 0;
        $countResult = 0 ;
        $type = 'error';
        $msg = $this->lang->line('errorRemove');
        if($from_showcaseid > 0) {
            $table = 'AssociatedEnterprise';
            $where = array('from_showcaseid'=>$from_showcaseid);
            $this->model_common->deleteRowFromTabel($table, $where);
            $countResult = $this->model_common->countResult($table,$where,'',1);
            $deleted = 1;
            $type = 'success';
            $msg = $this->lang->line('removeSuccessfully');
        }
        set_global_messages($msg, $type, $is_multiple=true);
        echo  json_encode(array('deleted'=>$deleted, 'countResult'=>$countResult));
    }
    
    //------------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This medhod is use to edit user playlist
    *  @auther: lokendra meena
    *  @return: void
    */
    
    public function mypaylisteditold(){
        $this->head->add_css($this->config->item('player_js').'controls-hulu.css');
        $this->head->add_js($this->config->item('player_js').'flowplayer-3.2.12.js',NULL,'lastAdd');
        $this->head->add_js($this->config->item('player_js').'flowplayer.playlist-3.2.10.min.js',NULL,'lastAdd');
        $this->head->add_js($this->config->item('player_js').'flowplayer.controls-3.2.11.js',NULL,'lastAdd');
        $userId                             =   $this->isLoginUser();
        $industryType                       =   'musicNaudio';
        $userPlaylistData                   =   $this->model_media->myplaylist($userId);
        $playlistData['userPlaylistData']   =   $userPlaylistData;
        $playlistData['tdsUid']             =   $userId;
        $playlistData['fileConfig']         =   $this->config->item($industryType.'FileConfig');
        $playlistData['imagetype_s']        =   $this->config->item('musicNaudioImage_s');
        $playlistData['packagestageheading'] 	    = 'Edit Playlist';  #set heading
        $this->new_version->load('new_version','showcase/showcase/myplaylist_view_edit',$playlistData);
    }
    
    
    
    //-----------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to delete playlist
    * @auther: lokendra meena
    * @return: void
    */ 
    
    public function playlistdelete(){
        $playlistid = $this->input->post('playlistid');
        $whereCondi= array('id'=>$playlistid);
        $this->model_common->deleteRowFromTabel('MediaPlaylist', $whereCondi);
        $msg = "Playlist music file removed successfully.";
        $type = 'success';
        set_global_messages($msg, $type, $is_multiple=true);
        echo "Playlist music file removed successfully.";
    }
    
    
    //-------------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to image crop functionality
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    public function profileimagecrop(){
        
        $this->isLoginUser();
        
        $dirUploadMedia   =  $this->dirUploadProfileMedia;
        $data['userId']   =  $this->userId;
       
        // get val1 as section type 1: showcase, 2: workprofile
        $cropSectionType = $this->input->get('val1');
       
        if($cropSectionType == 2) {
			$dirUploadMedia   =  $this->workprofileImagePath;
			// get workprofile details
			$workprofileRes = $this->model_common->getWorkProfileDetails($this->userId);
	
			$userDefaultImage = $this->config->item('sectionIdImage32');
			$userTemplateThumbImage = addThumbFolder($workprofileRes->filePath.$workprofileRes->fileName,'_l');	
			$userImage = getImage($userTemplateThumbImage,$userDefaultImage);
			// set next url
			$nextUrl =  base_url(lang().'/workprofile/contactdetails');	
			$profileImageName = $workprofileRes->fileName; 
			
		} else {
			
			// get showcase details
			$showcaseRes  =  getUserShowcaseId($this->userId);
			
			$userDefaultImage = $this->config->item('defaultMemberImg_l');
			$userTemplateThumbImage = $dirUploadMedia.'/'.$showcaseRes->profileImageName;	
			$userImage = getImage($userTemplateThumbImage,$userDefaultImage);

			if(isset($showcaseRes->profileImageName) && !empty($showcaseRes->profileImageName)) {
			   
				if(!empty($showcaseRes->creative) || !empty($showcaseRes->associatedProfessional) || !empty($showcaseRes->enterprise)) {
				   
					$userDefaultImage=($showcaseRes->enterprise=='t')?$this->config->item('defaultEnterpriseImg_l'):($showcaseRes->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_l'):$this->config->item('defaultCreativeImg_l'));
				}
				
				$userTemplateThumbImage = addThumbFolder($dirUploadMedia.'/'.$showcaseRes->profileImageName,'_l');	
				$userImage = getImage($userTemplateThumbImage,$userDefaultImage);
			}
			// set next url
			$nextUrl =  base_url(lang().'/showcase/showcasedetails');	
			$profileImageName = $showcaseRes->profileImageName; 
		}
		
        $data['dirUploadMedia']           =  $dirUploadMedia;
		$data['userTemplateThumbImage']   =  $userTemplateThumbImage;
        $data['userImage']                =  $userImage;
        $data['nextUrl']                  =  $nextUrl;
        $data['profileImageName']         =  (isset($profileImageName) && !empty($profileImageName)) ? $profileImageName : '';
         
        $this->load->view('wizardform/profileimagecrop',$data);
    }
    
    
    //---------------------------------------------------------------------------
    

    /*
    * @access: public
    * @description: This method is use to post croped image data
    * @auther: lokedra meena
    * @return: void
    */ 
    
    public function profileimagecroppost(){
        
        //get profile directory
        $targetDir   = $this->input->post('dirUploadProfileMedia');
      
        $thumbFolder = $this->config->item('cropImgThumbVersionFolder');
        
        //make directory
        $cropimageDIR=$targetDir.$thumbFolder;
        if(!is_dir($cropimageDIR)){
            mkdir($cropimageDIR, 0777, true);
        }
        
        $cmdtargetDir = 'chmod -R 777 '.$targetDir;
		exec($cmdtargetDir);
       
        $profileImageName = $this->input->post('imagename');
        $userTemplateThumbImage = addThumbFolder($targetDir.'/'.$profileImageName,'_l');	
        
        //get source and destination image
        $sourceImage = $userTemplateThumbImage;
        $destImage  = $targetDir.$thumbFolder.$profileImageName;
        
        // this thumbnail created
        $config_crop['image_library']   =  'gd2';
        $config_crop['source_image']    =  $sourceImage;
        $config_crop['create_thumb']    =  FALSE;   
        $config_crop['maintain_ratio']  =  TRUE;
        $config_crop['width']           =  $this->input->post('w');
        $config_crop['height']          =  $this->input->post('h');
        $config_crop['x_axis']          =  $this->input->post('x');
        $config_crop['y_axis']          =  $this->input->post('y');
        $config_crop['new_image']       =  $destImage;

        if(!is_file($destImage)){
          
            $this->load->library('image_lib', $config_crop);
            $this->image_lib->clear();
            $this->image_lib->initialize($config_crop);
            
            if (!$this->image_lib->image_process_gd('crop')){
                 $this->image_lib->display_errors();
            }
            $this->image_lib->clear();
        }

        /*$sourceImage = $userTemplateThumbImage;
        $destImage = $targetDir.$thumbFolder.$profileImageName;
        $img_r = imagecreatefromjpeg($sourceImage);
        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
        imagecopyresampled($dst_r,$img_r,0,0,$this->input->post('x'),$this->input->post('y'),
        $targ_w,$targ_h,$this->input->post('w'),$this->input->post('h'));
        imagejpeg($dst_r, $destImage,$jpeg_quality);*/

        //create thumb of croped image 
        echo  Modules::run("common/createthumbcropimages", $cropimageDIR,$profileImageName,0);
        echo json_encode(array("success"=>true));
        exit;
    }
    
    /**
    * Get user's profile image
    * @access: private
    * 
    */
    
    private function getprofileimage($showcaseRes='') {
		$userFolderName = LoginUserDetails('username');
		$profileJsImagePath = 'media/'.$userFolderName.'/profile_image/';	
		// set user profile image
		if(isset($showcaseRes->profileImageName) && $showcaseRes->profileImageName!='' && file_exists(ROOTPATH.$profileJsImagePath.$showcaseRes->profileImageName))
		{
			$files = glob($dataFormValue['profileJsImagePath'].'*'); // get all file names
			
			$currentProfileImage = $profileJsImagePath.$showcaseRes->profileImageName;
		}
		else
		{
			$stockImagePath = "images/stock_images/profile/";
			if(isset($showcaseRes->stockImageId) && $showcaseRes->stockImageId > 0)
			{ 	
				$stockImageName = getFieldValueFrmTable('stockFilename','StockImages','stockImgId',$showcaseRes->stockImageId);
				if(count($stockImageName[0])>0) 
					$CurrentStockFileName = $stockImagePath.$stockImageName[0]->stockFilename;
				else
					$CurrentStockFileName = $stockImagePath.'no.jpg';
					
				$currentProfileImage = $CurrentStockFileName;

		   } else { 
				$currentProfileImage = ($showcaseRes->enterprise=='t')?$this->config->item('defaultEnterpriseImg_152_210'):($showcaseRes->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_152_210'):$this->config->item('defaultCreativeImg_152_210'));
		  }
		}
		return $currentProfileImage;
    }
    
    //----------------------------------------------------------------------
    
    /*
    *  @access: private
    *  @description: This method is use to manage wizard heading text
    *  @auther: tosif qureshi
    *  @return: string
    */ 
    public function wizardheadingtext() {
		// get session value of edit media mode
		$isShowcaseEdit = $this->session->userdata('isShowcaseEdit');
		$this->data['packagestageheading'] = (!empty($isShowcaseEdit)) ? $this->lang->line('editYourShowcase') : $this->lang->line('createYourShowcase');    
	}
	

}//End Class

?>
