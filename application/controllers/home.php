<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//class Welcome extends CI_Controller {
class Home extends MX_Controller {
    private $data = array();
    private $userId = null;
    
    /**
     * Constructor
     */
    function __construct() {
        //Load required Model, Library, language and Helper files
            $load = array(
                'library' 	=> 'form_validation',			 	
                'helper' 	=> 'form + file'	
            );
            parent::__construct($load);	
            
    }
    
    public function index(){
        $this->load->library('parallax');
        $url= $this->input->get('url');		
        if(isset($url) && ($url!='')){
            $this->load->model('shortlink/url_model'); 			
            $full = $this->url_model->get_full_url($url);				   
            redirect($full->url);						
        }else{ 
            $activate_account=$this->session->userdata('activateAccount');
            $this->session->unset_userdata('activateAccount');
            if($activate_account=='activateAccount'){
                $this->data['loadLoinPopup'] = true;
                $this->data['message'] = $this->lang->line('auth_message_activation_completed');
            }else{
                $this->data['loadLoinPopup'] = false;
                $this->data['message'] = '';
            }
            
            // get bundle of image records
            $this->data['imageCollection'] =  $this->mixedelementdata(); 
        /* End */
            //$this->load->view('home_parallax',$userDeatil);
            // $this->parallax->load("template_parallax",'home_parallax',$userDeatil);
            $this->new_version->load("new_version",'home_parallax',$this->data);
            
        }
    }
    
    
    //------------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to show mixed element data
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    
    public function mixedelementdata(){
        
        $mixedDataArray = array();
        $keyVal = 0;
        $recordLimit = 7;
        $imageSize = '_m';
        $thumbFolder = 'thumb';
        
        //-----creative user random data----//
        $creativeData = $this->model_common->randomuserdata($userType="creative",$recordLimit);	
        if(!empty($creativeData)){
			foreach($creativeData as $creativeUserData) {
				$imagePath = 'media/'.$creativeUserData['username'].'/profile_image/'.$creativeUserData['profileImageName'];
				if(file_exists(ROOTPATH.$imagePath)) { 
					
					$imageType = $this->config->item('defaultCreativeImg'.$imageSize);
                 	$thumbImage = addThumbFolder($imagePath,$imageSize,$thumbFolder);	
                    $projectImage=getImage($thumbImage,$imageType);
					
                	$linkPrepare =   base_url_lang('showcase/index/'.$creativeUserData['tdsUid']);
					$mixedDataArray[$keyVal]['link']        =   $linkPrepare;
					$mixedDataArray[$keyVal]['username']    =   $creativeUserData['firstName'].' '.$creativeUserData['lastName'];
					$mixedDataArray[$keyVal]['imagePath']   =   $projectImage;
					$mixedDataArray[$keyVal]['lableText']   =   "<br> Creative";
					$keyVal++;
				}
			}
			
        }
        
         //-----associatedProfessional user random data----//
        $associateData = $this->model_common->randomuserdata($userType="associatedProfessional",$recordLimit);	
		if(!empty($associateData)){
			foreach($associateData as $associateUserData) {
				$imagePath = 'media/'.$associateUserData['username'].'/profile_image/'.$associateUserData['profileImageName'];
				if(file_exists(ROOTPATH.$imagePath)) { 
					$imageType = $this->config->item('defaultEnterpriseImg'.$imageSize);
					$thumbImage = addThumbFolder($imagePath,$imageSize,$thumbFolder);	
					$projectImage=getImage($thumbImage,$imageType);
					$linkPrepare =   base_url_lang('showcase/index/'.$associateUserData['tdsUid']);
					$mixedDataArray[$keyVal]['link']        =   $linkPrepare;
					$mixedDataArray[$keyVal]['username']    =   $associateUserData['firstName'].' '.$associateUserData['lastName'];
					$mixedDataArray[$keyVal]['imagePath']   =    $projectImage;
					$mixedDataArray[$keyVal]['lableText']   =   "<br> Professionals";
					$keyVal++;
				}
			}
        }
        
        //-----enterprise user random data----//
        $enterpriseData = $this->model_common->randomuserdata($userType="enterprise",$recordLimit);	
        if(!empty($enterpriseData)){
			foreach($enterpriseData as $enterpriseUserData) {
				$imagePath = 'media/'.$enterpriseUserData['username'].'/profile_image/'.$enterpriseUserData['profileImageName'];
				if(file_exists(ROOTPATH.$imagePath)) {
					$imageType = $this->config->item('defaultEnterpriseImg'.$imageSize);
					$thumbImage = addThumbFolder($imagePath,$imageSize,$thumbFolder);	
					$projectImage=getImage($thumbImage,$imageType);
					$linkPrepare =   base_url_lang('showcase/index/'.$enterpriseUserData['tdsUid']);
					$mixedDataArray[$keyVal]['link']        =   $linkPrepare;
					$mixedDataArray[$keyVal]['username']    =   $enterpriseUserData['firstName'].' '.$enterpriseUserData['lastName'];
					$mixedDataArray[$keyVal]['imagePath']   =    $projectImage;
					$mixedDataArray[$keyVal]['lableText']   =   "<br> Business";
					$keyVal++;
				}
			}
        }
        
		//-----fans user random data----//
        $fansData = $this->model_common->randomuserdata($userType="fans",$recordLimit);
		if(!empty($fansData)) {
			foreach($fansData as $fansUserData) {
				$imagePath = 'media/'.$fansUserData['username'].'/profile_image/'.$fansUserData['profileImageName'];
				if(file_exists(ROOTPATH.$imagePath)) {
					$imageType = $this->config->item('defaultEnterpriseImg'.$imageSize);
					$thumbImage = addThumbFolder($imagePath,$imageSize,$thumbFolder);	
					$projectImage=getImage($thumbImage,$imageType,'');
					$linkPrepare =  base_url_lang('showcase/index/'.$fansUserData['tdsUid']);
					$mixedDataArray[$keyVal]['link']         =   $linkPrepare;
					$mixedDataArray[$keyVal]['username']     =   $fansUserData['firstName'].' '.$fansUserData['lastName'];
					$mixedDataArray[$keyVal]['imagePath']    =    $projectImage;
					$mixedDataArray[$keyVal]['lableText']    =   "<br> Fans";
					$keyVal++;
				}
			}
        }
        
        //--------film & video random data--------//
        $fvResData = $this->model_common->getmediaprojectrecord('FvElement',$recordLimit,'filmNvideo');
        if(!empty($fvResData)) {
			foreach($fvResData as $fvData) {
				 if(file_exists(ROOTPATH.$fvData['imagePath'])) {
					 // set project image
					$imageType = $this->config->item('filmNvideoImage'.$imageSize);
					$thumbImage = addThumbFolder($fvData['imagePath'],$imageSize,$thumbFolder);	
					$projectImage=getImage($thumbImage,$imageType,'');
					$linkPrepare =  base_url_lang('mediafrontend/mediashowcases/'.$fvData['tdsUid'].'/'.$fvData['projId']);
					
					$mixedDataArray[$keyVal]['link']       =   $linkPrepare;
					$mixedDataArray[$keyVal]['username']   =   $fvData['firstName'].' '.$fvData['lastName'];
					$mixedDataArray[$keyVal]['imagePath']  =   $projectImage;
					$mixedDataArray[$keyVal]['lableText']  =   "<br> Film & Video Collection";
					$keyVal++;
				}	
			}
           
        }
       
        //--------music & audio random data--------//
        $maResData = $this->model_common->getmediaprojectrecord('MaElement',$recordLimit,'musicNaudio');
		if(!empty($maResData)) {
			foreach($maResData as $maData) {
				if(file_exists(ROOTPATH.$maData['imagePath'])) {
					// set project image
					$imageType = $this->config->item('musicNaudioImage'.$imageSize);
					$thumbImage = addThumbFolder($maData['imagePath'],$imageSize,$thumbFolder);	
					$projectImage=getImage($thumbImage,$imageType,'');
					
					$linkPrepare =  base_url_lang('mediafrontend/aboutalbum/'.$maData['tdsUid'].'/'.$maData['projId']);
					
					$mixedDataArray[$keyVal]['link']        =   $linkPrepare;
					$mixedDataArray[$keyVal]['username']    =   $maData['firstName'].' '.$maData['lastName'];
					$mixedDataArray[$keyVal]['imagePath']   =   $projectImage;
					$mixedDataArray[$keyVal]['lableText']   =   "<br> Music Album";
					$keyVal++;
				}
			}
        }
        
        //--------photography random data--------//
        $paResData = $this->model_common->getmediaprojectrecord('PaElement',$recordLimit,'photographyNart');
		if(!empty($paResData)) {
			foreach($paResData as $paData) {
				if(file_exists(ROOTPATH.$paData['imagePath'])) {
					// set project image
					$imageType = $this->config->item('photographyNartImage'.$imageSize);
					$thumbImage = addThumbFolder($paData['imagePath'],$imageSize,$thumbFolder);	
					$projectImage=getImage($thumbImage,$imageType,'');
					$linkPrepare =  base_url_lang('mediafrontend/photoartdetails/'.$paData['tdsUid'].'/'.$paData['projId']);
		
					$mixedDataArray[$keyVal]['link']        =   $linkPrepare;
					$mixedDataArray[$keyVal]['username']    =   $paData['firstName'].' '.$paData['lastName'];
					$mixedDataArray[$keyVal]['imagePath']   =   $projectImage;
					$mixedDataArray[$keyVal]['lableText']   =   "<br> Photography Album";
					$keyVal++;
				}
			}			
        }

        //--------writing & publishing randon data--------//
        $wpResData = $this->model_common->getmediaprojectrecord('WpElement',$recordLimit,'writingNpublishing');
        if(!empty($wpResData)) {
			foreach($wpResData as $wpData) {
				if(file_exists(ROOTPATH.$wpData['imagePath'])) {
					// set project image
					$imageType = $this->config->item('writingNpublishingImage'.$imageSize);
					$thumbImage = addThumbFolder($wpData['imagePath'],$imageSize,$thumbFolder);	
					$projectImage = getImage($thumbImage,$imageType,'');
					$linkPrepare =  base_url_lang('mediafrontend/writingdetails/'.$wpData['tdsUid'].'/'.$wpData['projId']);
					
					$mixedDataArray[$keyVal]['link']        =   $linkPrepare;
					$mixedDataArray[$keyVal]['username']    =   $wpData['firstName'].' '.$wpData['lastName'];
					$mixedDataArray[$keyVal]['imagePath']   =   $projectImage;
					$mixedDataArray[$keyVal]['lableText']   =   "<br> Writing Collection";
					$keyVal++;
				}
			}
        }
        
        
         //--------Educational material randon data--------//
        $eduResData = $this->model_common->getmediaprojectrecord('EmElement',$recordLimit,'educationMaterial');
        if(!empty($eduResData)) {
			foreach($eduResData as $eduRes) {
				if(file_exists(ROOTPATH.$eduRes['imagePath'])) {
					// set project image
					$imageType = $this->config->item('educationMaterialImage'.$imageSize);
					$thumbImage = addThumbFolder($eduRes['imagePath'],$imageSize,$thumbFolder);	
					$projectImage = getImage($thumbImage,$imageType,'');
					$linkPrepare =  base_url_lang('mediafrontend/educationdetails/'.$eduRes['tdsUid'].'/'.$eduRes['projId']);
					
					$mixedDataArray[$keyVal]['link']        =   $linkPrepare;
					$mixedDataArray[$keyVal]['username']    =   $eduRes['firstName'].' '.$eduRes['lastName'];
					$mixedDataArray[$keyVal]['imagePath']   =   $projectImage;
					$mixedDataArray[$keyVal]['lableText']   =   "<br> Creative-Industry Education";
					$keyVal++;
				}
			}
        }
        
        //--------review project random data--------//
        $reviewResData = $this->model_common->getmediaprojectrecord('ReviewsElement',$recordLimit,'reviews');
        if(!empty($reviewResData)) {
			foreach($reviewResData as $reviewRes) {
				if(file_exists(ROOTPATH.$reviewRes['imagePath'])) {
					// set project image
					$imageType = $this->config->item('defaultReviewsImg'.$imageSize);
					$thumbImage = addThumbFolder($reviewRes['imagePath'],$imageSize,$thumbFolder);	
					$projectImage = getImage($thumbImage,$imageType,'');
					$linkPrepare =  base_url_lang('mediafrontend/reviewscollection/'.$reviewRes['tdsUid'].'/'.$reviewRes['projId']);
					
					$mixedDataArray[$keyVal]['link']        =   $linkPrepare;
					$mixedDataArray[$keyVal]['username']    =   $reviewRes['firstName'].' '.$reviewRes['lastName'];
					$mixedDataArray[$keyVal]['imagePath']   =   $projectImage;
					$mixedDataArray[$keyVal]['lableText']   =   "<br> Reviews";
					$keyVal++;
				}
			}
        }
        
        
         //--------news project random data--------//
        $newsResData = $this->model_common->getmediaprojectrecord('NewsElement',$recordLimit,'news');
        if(!empty($newsResData)) {
            foreach($newsResData as $newsRes) {
                if(file_exists(ROOTPATH.$newsRes['imagePath'])) {
                    // set project image
                    $imageType = $this->config->item('defaultNewsImg'.$imageSize);
                    $thumbImage = addThumbFolder($newsRes['imagePath'],$imageSize,$thumbFolder);	
                    $projectImage = getImage($thumbImage,$imageType,'');
                    $linkPrepare =  base_url_lang('mediafrontend/newscollection/'.$newsRes['tdsUid'].'/'.$newsRes['projId']);
                    
                    $mixedDataArray[$keyVal]['link']        =   $linkPrepare;
                    $mixedDataArray[$keyVal]['username']    =   $newsRes['firstName'].' '.$newsRes['lastName'];
                    $mixedDataArray[$keyVal]['imagePath']   =   $projectImage;
                    $mixedDataArray[$keyVal]['lableText']   =   "<br> Articles";
                    $keyVal++;
                }
            }
        }
        
        //---------------get post random data-----------//
        $postResData = $this->model_common->getramdonpostrecord($recordLimit);
        if(!empty($postResData)) {
            foreach($postResData as $postRes) {
                $postImage = $postRes['filePath'].'/'.$postRes['fileName'];
                if(file_exists(ROOTPATH.$postImage)) {
                    // set project image
                    $imageType = $this->config->item('defaultPostImg'.$imageSize);
                    $thumbImage = addThumbFolder($postImage,$imageSize,$thumbFolder);	
                    $projectImage = getImage($thumbImage,$imageType,'');
                    $linkPrepare =  base_url_lang('blogshowcase/frontPostDetail/'.$postRes['custId'].'/'.$postRes['postId']);
                    
                    $mixedDataArray[$keyVal]['link']        =   $linkPrepare;
                    $mixedDataArray[$keyVal]['username']    =   $postRes['firstName'].' '.$postRes['lastName'];
                    $mixedDataArray[$keyVal]['imagePath']   =   $projectImage;
                    $mixedDataArray[$keyVal]['lableText']   =   "<br> Blogs";
                    $keyVal++;
                }
            }
        }
        
        shuffle($mixedDataArray); // Shuffle the array
        //echo "<pre>";
        //print_r($mixedDataArray);die;
       return $mixedDataArray;
       
    }
    
    function array_randsort($array,$preserve_keys=false) {

		if(!is_array($array)):

			exit('Supplied argument is not a valid array.');

		else:

			$i = NULL;

		// how long is the array?
		$array_length = count($array); 

		// Sorts the array keys in a random order. 
		$randomize_array_keys = array_rand($array,$array_length);

		// if we are preserving the keys ...
		if($preserve_keys===true) {		

			// reorganize the original array in a new array 
			foreach($randomize_array_keys as $k=>$v){
				$randsort[$randomize_array_keys[$k]] = $array[$randomize_array_keys[$k]];
			}
		} else {
			// reorganize the original array in a new array 
			for($i=0; $i < $array_length; $i++){
				$randsort[$i] = $array[$randomize_array_keys[$i]];
			}
		}
		return $randsort;

		endif;

	}
    
    public function index_back(){
        $this->head->add_css($this->config->item('system_css').'frontend.css');
            $this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
            $this->head->add_js($this->config->item('system_js').'jstween-1.1.min.js');
            // This css add only for mobile os
            if(getOsName()=="mobile")
            {
                $this->head->add_css($this->config->item('html5_player_css').'video-js.css');
                $this->head->add_js($this->config->item('html5_player_js').'video.js');
            }	
        $url= $this->input->get('url');		
        if(isset($url) && ($url!='')){
            $this->load->model('shortlink/url_model'); 			
            $full = $this->url_model->get_full_url($url);				   
            redirect($full->url);						
        }else{ 
            $activate_account=$this->session->userdata('activateAccount');
            $this->session->unset_userdata('activateAccount');
            if($activate_account=='activateAccount'){
                $userDeatil['loadLoinPopup'] = true;
                $userDeatil['message'] = $this->lang->line('auth_message_activation_completed');
            }else{
                $userDeatil['loadLoinPopup'] = false;
                $userDeatil['message'] = '';
            }
                
        /* End */			
             $userDeatil['registerdUser'] = countResult('UserAuth','tdsUid');
             $this->template->load("frontend",'home',$userDeatil);
        }
    }
    
    public function indextest(){
        $url= $this->input->get('url');		
        if(isset($url) && ($url!=''))
        {
            $this->load->model('shortlink/url_model'); 			
            $full = $this->url_model->get_full_url($url);				   
            redirect($full->url);						
        } 	
         $this->template->load("frontend",'indextest');
    }
    public function help(){
     $this->index();
    }
    
    function test_tcpdf()
    {
        $this->load->view('example_001');
    }
    
    
    //----------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to show online news letter view
    * @auther: lokendra meena
    * @return: void
    */ 
    
    public function viewonline($newsletterId){
        
        $newsletterId = base64_decode($newsletterId);
        //get message data
        $whereCond         =   array('id'=>$newsletterId);
        $newsletterRes     =   getDataFromTabel('EmailNewsletter','*',  $whereCond, '','', '', 1 );
        
        if(!empty($newsletterRes)){
            $newsletterRes   =   $newsletterRes[0];
            $messageBody        =   (!empty($newsletterRes->content))?$newsletterRes->content:'';
            $sentDate           =   (!empty($newsletterRes->createdAt))?$newsletterRes->createdAt:'';
        
            $from_email = $this->config->item('webmaster_email', '');
            /* while we don't remove restriction (username, password) in .htacess file  from live site*/
            $image_base_url = site_base_url().$this->config->item('template_new_images');
            $crave_url = $this->config->item('crave_us');
            /* Set Follow us link*/
            $facebook_url = $this->config->item('facebook_follow_url');
            $linkedin_url = $this->config->item('linkedin_follow_url');
            $twitter_url = $this->config->item('twitter_follow_url');
            $gPlus_url = $this->config->item('google_follow_url');
            $site_email = 'info@toadsquare.com';
            $site_link = 'www.toadsquare.com';
			$message_date= (!empty($newsletterRes->newsletterDate)) ? date('F Y',strtotime($newsletterRes->newsletterDate)) : date('F Y');
            $view_online    =   base_url_lang('home/viewonline/'.base64_encode($newsletterId));
            $where=array('purpose'=>'newslettertemplate','active'=>1);
            $adminTemplateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
            
            if($adminTemplateRes) {
                $adminTemplate = $adminTemplateRes[0]->templates;
                $searchArray = array("{view_online}","{message_date}","{mailBody}","{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{site_email}","{site_link}","{twitter_url}","{gPlus_url}");
                $replaceArray = array($view_online,$message_date,$messageBody,$image_base_url,$crave_url,$facebook_url,$linkedin_url,$site_email,$site_link,$twitter_url,$gPlus_url);
                $adminMailTemplate = str_replace($searchArray, $replaceArray, $adminTemplate);
                echo $adminMailTemplate;
            }
        }else{
            redirectToNorecord404();
        }
    } 
    
    
    //------------------------View Terms & condition  Function----------------------------------------------
    
    /*
    * @access: public
    * @description: View Terms & condition  Function
    * @auther: lokendra meena
    * @return: void
    */ 
    
    public function termsncondition($lang="en")
    {
		if(!empty($lang))
		{
			switch($lang)
			{
				case "en":
				$url = 'images/Toadsquare’s Terms & Conditions.pdf';
				break;	
				case "fr":
				$url = '';
				break;	
				case "de":
				$url = '';
				break;	
				default:
				$url = 'images/Toadsquare’s Terms & Conditions.pdf';
			}
			$url = base_url(htmlentities($url));
			$data['url'] = $url;
			$this->load->view('terms_condition_view',$data);
		}
		
	}
	
	//------------------------------------Global Coming Soon-----------------------------------
	
	/*
    * @access: public
    * @description: View Global Coming Soon page Function
    * @auther: lokendra meena
    * @return: void
    */ 
    
    public function comingsoon()
    {
			   $this->data['comingsoon']['msg']=$this->lang->line('ComingSoon_msg');
			   $this->new_version->load("new_version",'landingpage/comingsoon',$this->data);
	}
    
}
