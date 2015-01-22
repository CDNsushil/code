<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	 Description:
	 * The controller class "workprofilefrontend" is meant to handle the processing of "Showcase" section
	 * It include functionality to fetch/add/edit workprofile address,sicaol media links,employment history,etc
	 *
	 * @package	Toadsquare
	 * @subpackage	Module
	 * @category	Controller
	 * Author Name: Amit Wali
	 * Date Created: 25 October 2012
	 	
*/
class workprofilefrontend extends MX_Controller {
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
			'model'		=> 'workprofilefrontend/model_workprofilefrontend',		
			
			'language' 	=> 'workprofile',	
			
			'helper' 	=> 'form + file',
			
			'library'  =>  'template_front_end'
 		);
		parent::__construct($load);	
		//$this->userId = $this->isLoginUser();		
		
		$this->head->add_css($this->config->item('frontend_css').'workprofile.css');
		$this->head->add_js($this->config->item('frontend_js').'jquery-gallery-cdn.js');
		
	}

  
  
   /***
	 
	 * 	Function to Get the Listing of Employe WorkProfile
	
	***/

   function index($viewProfileId='')
   {
		
			
	   	$norecord = true; 
	   	
	   	if(isset($viewProfileId) && ($viewProfileId!='')){
			$this->checkAuthenticaion($viewProfileId);
	        $data['accessUserProfile'] = $viewProfileId;			
		 }else
			{
			    $this->userId = $this->isLoginUser();
			}
	   	
	   	$currentWorkProfileId=$this->model_workprofilefrontend->checkForSetProfile($this->userId); 
	   	   
	    $data['workDetail']= $this->model_workprofilefrontend->getWorkDetails($this->userId);
			if($data['workDetail'])	{	
								
				$data['workDetail'] = $data['workDetail'][0];	
				$norecord = false;				
			}
				
		if(isset($data['workDetail']->countriesInterestWorking) && !empty($data['workDetail']->countriesInterestWorking)) {
			$InterestedCountry = explode('|',$data['workDetail']->countriesInterestWorking);
			$data['InterestedCountry'] = $InterestedCountry;
		}
	
		$data['education']= $this->model_workprofilefrontend->getEducation($this->userId);	
		
		$whereField=array(
					'workProfileId'=>$currentWorkProfileId
			);
			
		$data['getMediaData']= $this->getProfileMedia($currentWorkProfileId);	
		
		$data['getSummaryData'] = $this->checkHistoryReference($currentWorkProfileId);
		
		$data['WorkProfileVisa'] = $this->model_common->getDataFromTabel('WorkProfileVisa','countryId,visaType',$whereField);
		$userData= showCaseUserDetails($this->userId);	
		
		$data['userInfo'] = $userData;
			
	  // echo "<pre>";print_r($data);die;
	   if($norecord == true)
			//redirectToNorecord404();
			$this->template_front_end->load('workprofile_template','workprofile', $data);	 
	   else
			$this->template_front_end->load('workprofile_template','workprofile', $data);	  
	   
   }
   
   /***
	 
	 * 	Function to Get the Listing of Employe History
	
	***/
   
   
   function employeHistory($viewProfileId='')
	{
		$norecord = true; 
		if(isset($viewProfileId) && ($viewProfileId!='')){				
			//$this->userId = decode($viewProfileId);
			//$data['accessUserProfile'] = $this->userId;			
			$this->checkAuthenticaion($viewProfileId);
	        $data['accessUserProfile'] = $viewProfileId;
			
		 }else
			{
				$this->userId = $this->isLoginUser();
			}			 
		 		
		$currentWorkProfileId=$this->model_workprofilefrontend->checkForSetProfile($this->userId);		
		
		$data['empHistory']= $this->model_workprofilefrontend->empHistoryRecordSet($currentWorkProfileId);
		
		$data['getMediaData']= $this->getProfileMedia($currentWorkProfileId);
		
		$data['getSummaryData'] = $this->checkHistoryReference($currentWorkProfileId);
		
		
		if(count($data['empHistory'])>0)  $norecord = false;
					
		$data['workDetail']= $this->model_workprofilefrontend->getWorkDetails($this->userId);
			if($data['workDetail'])	{	
								
				$data['workDetail'] = $data['workDetail'][0];					
			}
		
		$userData= showCaseUserDetails($this->userId);
		$data['userInfo'] = $userData;
			
		if($norecord == true)
			//redirectToNorecord404();
			$this->template_front_end->load('workprofile_template','emp_history',$data);
	    else		
			$this->template_front_end->load('workprofile_template','emp_history',$data);	
		
	}
   
   
    /***
	 
	 * 	Function to Get the Listing of Employe Showcase
	
	***/

    function employeShowcase($viewProfileId='')
	{
		$norecord = true; 
		
		if(isset($viewProfileId) && ($viewProfileId!='')){
			$this->checkAuthenticaion($viewProfileId);
	          $data['accessUserProfile'] = $viewProfileId;
			
			}else
			{
				$this->userId = $this->isLoginUser();
			}
		
		$currentWorkProfileId=$this->model_workprofilefrontend->checkForSetProfile($this->userId);		
		
		$data['empHistory']= $this->model_workprofilefrontend->empHistoryRecordSet($currentWorkProfileId);
		
		$data['workDetail']= $this->model_workprofilefrontend->getWorkDetails($this->userId);
			if($data['workDetail'])	{	
								
				$data['workDetail'] = $data['workDetail'][0];					
			}
		
		$userData= showCaseUserDetails($this->userId);
		$data['userInfo'] = $userData;
		
		// // get References 
		$data['refrences']=$this->model_workprofilefrontend->getWorkRecommendation($currentWorkProfileId);	
		
		$data['getMediaData']= $this->getProfileMedia($currentWorkProfileId);
		
		$data['getSummaryData'] = $this->checkHistoryReference($currentWorkProfileId);
		
		$data['recomends']=$this->model_workprofilefrontend->getRecommendation($this->userId,$limit=0);		
		
		if(count($data['refrences'])>0 && count($data['recomends'])>0)  $norecord = false;	
		
		if($norecord == true)
		
			$this->template_front_end->load('workprofile_template','emp_showcase',$data);
			//	redirectToNorecord404();
	    else		
			$this->template_front_end->load('workprofile_template','emp_showcase',$data);	 	
	} 
	
	
	/***
	 
	 * 	Function to Get the Listing of Employe Portfolio
	
	***/

   
   function employePortfolio($viewProfileId='')
	{
		
		if(isset($viewProfileId) && ($viewProfileId!='')){
			$this->checkAuthenticaion($viewProfileId);
	          $data['accessUserProfile'] = $viewProfileId;
			
			}else
			{
			    $this->userId = $this->isLoginUser();
			}
		
		$currentWorkProfileId=$this->model_workprofilefrontend->checkForSetProfile($this->userId);			
		
		$data['workDetail']= $this->model_workprofilefrontend->getWorkDetails($this->userId);
			if($data['workDetail'])	{								
				$data['workDetail'] = $data['workDetail'][0];					
			}
		
		$userData= showCaseUserDetails($this->userId);
		$data['userInfo'] = $userData;
		
		$data['entityId']=getMasterTableRecord('ProfileMedia');		
		
		if(isLoginUser() == false)
		{
			$data['loginUserID']=0;
		}else
		{
			$data['loginUserID']=isLoginUser();
		}
		
		$data['video']=$this->model_workprofilefrontend->showWorkShowcaseMedia($currentWorkProfileId,2);	
		
		$data['getMediaData']= $this->getProfileMedia($currentWorkProfileId);	
		 
		$this->template_front_end->load('workprofile_template','emp_portfolio',$data);			
		
	}
   
   
	/***
	
	 * Function to Get the Listing of Employe Images
	
	***/

	function employeImages($viewProfileId='')
	{		
		if(isset($viewProfileId) && ($viewProfileId!='')){
			$this->checkAuthenticaion($viewProfileId);
	          $data['accessUserProfile'] = $viewProfileId;			
			}else
			{
			    $this->userId = $this->isLoginUser();
			}
		
		$currentWorkProfileId=$this->model_workprofilefrontend->checkForSetProfile($this->userId);		
		$data['workDetail']= $this->model_workprofilefrontend->getWorkDetails($this->userId);
			if($data['workDetail'])	{	
								
				$data['workDetail'] = $data['workDetail'][0];					
			}
		
		$userData= showCaseUserDetails($this->userId);
		$data['userInfo'] = $userData;		
		
		$data['entityId']=getMasterTableRecord('ProfileMedia');				
		$data['profileImages']=$this->model_workprofilefrontend->showWorkShowcaseMedia($currentWorkProfileId,1);
		$data['getMediaData']= $this->getProfileMedia($currentWorkProfileId);					
		$this->template_front_end->load('workprofile_template','emp_images',$data);		
		
	}
	

   /***
	 
	 * 	Function to Get the Listing of Employe Audio
	
	***/

  function employeAudio($viewProfileId='')
	{
		
		if(isset($viewProfileId) && ($viewProfileId!='')){
			$this->checkAuthenticaion($viewProfileId);
	          $data['accessUserProfile'] = $viewProfileId;
			
			}else
			{
			    $this->userId = $this->isLoginUser();
			}
		
		$currentWorkProfileId=$this->model_workprofilefrontend->checkForSetProfile($this->userId);			
		
		$data['workDetail']= $this->model_workprofilefrontend->getWorkDetails($this->userId);
			if($data['workDetail'])	{	
								
				$data['workDetail'] = $data['workDetail'][0];					
			}
		
		$userData= showCaseUserDetails($this->userId);
		$data['userInfo'] = $userData;
		
		$data['entityId']=getMasterTableRecord('ProfileMedia');		
		
		if(isLoginUser() == false)
		{
			$data['loginUserID']=0;
		}else
		{
			$data['loginUserID']=isLoginUser();
		}
		
		
		$data['profileAudio']=$this->model_workprofilefrontend->showWorkShowcaseMedia($currentWorkProfileId,3);	
		
		$data['getMediaData']= $this->getProfileMedia($currentWorkProfileId);	
				
		$this->template_front_end->load('workprofile_template','emp_audio',$data);	 		
		
	}


   /***
	 
	 * 	Function to Get the Listing of Employe Text
	
	***/


    function employeText($viewProfileId='')
	{
		
		if(isset($viewProfileId) && ($viewProfileId!='')){
			$this->checkAuthenticaion($viewProfileId);
	          $data['accessUserProfile'] = $viewProfileId;
			
			}else
			{
			    $this->userId = $this->isLoginUser();
			}
		
		$currentWorkProfileId=$this->model_workprofilefrontend->checkForSetProfile($this->userId);			
		
		
		$data['workDetail']= $this->model_workprofilefrontend->getWorkDetails($this->userId);
			if($data['workDetail'])	{	
								
				$data['workDetail'] = $data['workDetail'][0];					
			}
		
		$userData= showCaseUserDetails($this->userId);
		$data['userInfo'] = $userData;
		
		$data['entityId']=getMasterTableRecord('ProfileMedia');		
		
		if(isLoginUser() == false)
		{
			$data['loginUserID']=0;
		}else
		{
			$data['loginUserID']=isLoginUser();
		}
		
		$data['profileText']=$this->model_workprofilefrontend->showWorkShowcaseMedia($currentWorkProfileId,4);
		
		$data['getMediaData']= $this->getProfileMedia($currentWorkProfileId);	
		/*echo "<pre>";
		print_r($data);die;*/
		
		
				
		$this->template_front_end->load('workprofile_template','emp_text',$data);	 
		//print_r($a);die;
		
		
	}
	
	
	
	/***
	 
	 * 	Function to Get the Recommendations Listing based on ajax hit
	
	***/
	
	 function showRecommendations($count=''){
		 
		 $limit= (!empty($count))? $count :0 ;
		 $data['recomends']=$this->model_workprofilefrontend->getRecommendation($this->userId,$limit);		
				
		 $this->load->view('emp_recommendation',$data);	 
		 
		 }
		 
		 
		 
	function showProfile($viewProfile='')
       {  
	   	
	   if(isset($viewProfile) && ($viewProfile!='')) {
	     $this->checkAuthenticaion($viewProfile);
	     $data['accessUserProfile'] = $viewProfile;
	    }else
			{
			    $this->userId = $this->isLoginUser();
			}
	   	
	   	$currentWorkProfileId=$this->model_workprofilefrontend->checkForSetProfile($this->userId);	   	   
	    $data['workDetail']= $this->model_workprofilefrontend->getWorkDetails($this->userId);
			if($data['workDetail'])	{	
								
				$data['workDetail'] = $data['workDetail'][0];					
			}
		$data['education']= $this->model_workprofilefrontend->getEducation($this->userId);	
		
		$whereField=array(
					'workProfileId'=>$currentWorkProfileId
			);
		
		$data['getMediaData']= $this->getProfileMedia($currentWorkProfileId);
		
		$data['getSummaryData'] = $this->checkHistoryReference($currentWorkProfileId);
		
		$data['WorkProfileVisa'] = $this->model_common->getDataFromTabel('WorkProfileVisa','countryId,visaType',$whereField);
		$userData= showCaseUserDetails($this->userId);		
	    $data['userInfo'] = $userData;	   
	    $this->template_front_end->load('workprofile_template','workprofile', $data);	  
	   
   }
		 
		 
	
	function checkAuthenticaion ($viewProfile)	{
		if(isset($viewProfile) && ($viewProfile!='')){
			$userId = decode($viewProfile);
			$userInfo = explode('-',$userId);
			//print_r($userId);	
			$this->userId = $userInfo[0];

			$isValid =$this->model_workprofilefrontend->checkTokenValidity($userInfo[1],$userInfo[2]);

			if($isValid) {
			//$data['accessUserProfile'] = $viewProfile;
			} else { 
			    redirect(base_url().'workprofilefrontend/unauthorized/'.$viewProfile,'refresh');
			}	   
		}		
	}
		 
		 
	
	 function unauthorized ($viewProfile) {

        $viewInfo = decode($viewProfile);
		$userInfo = explode('-',$viewInfo);
		//print_r($userId);	
		$data['userId'] = $userInfo[0];		
		$data['userData']= showCaseUserDetails($userInfo[0]);		
		$userId = $data['userId'];		
		
		$data['workDetail']= $this->model_workprofilefrontend->getWorkDetails($userId);
		if($data['workDetail'])	{	
								
				$data['workDetail'] = $data['workDetail'][0];					
			}
			
		$userData= showCaseUserDetails($userId);		
		$data['userInfo'] = $userData;	
		$this->template_front_end->load('workprofile_template','unauthorizedView',$data);
		 
	}
	
	
	/* Shortlink redirection if workprofile*/
	
	function viewprofile($recordId) {		
		$recordId = decode($recordId);				
		$r= $this->model_workprofilefrontend->getUrlRequestId($recordId);	
		$userInfo = encode($r[0]->sender_id.'-'.$recordId.'-'.$r[0]->access_token);	
		redirect(base_url().'workprofilefrontend/showProfile/'.$userInfo,'refresh');		
		}
		 
		 
	function getProfileMedia($currentWorkProfileId)
	{
		$mediaData['getprofileImages']=$this->model_workprofilefrontend->showWorkShowcaseMedia($currentWorkProfileId,1);
		$mediaData['getvideo']=$this->model_workprofilefrontend->showWorkShowcaseMedia($currentWorkProfileId,2);
		$mediaData['getprofileAudio']=$this->model_workprofilefrontend->showWorkShowcaseMedia($currentWorkProfileId,3);	
		$mediaData['getprofileText']=$this->model_workprofilefrontend->showWorkShowcaseMedia($currentWorkProfileId,4);
		return $mediaData;
	}	
	
	
	function checkHistoryReference($currentWorkProfileId)
	{		
		$summaryData['getHistory']=  $this->model_workprofilefrontend->empHistoryRecordSet($currentWorkProfileId);
		$summaryData['getReference']=$this->model_workprofilefrontend->getWorkRecommendation($currentWorkProfileId);	
		$summaryData['getRecommandation']=$this->model_workprofilefrontend->getRecommendation($this->userId,'');
		return $summaryData;
		
	}
	
	
}
?>
