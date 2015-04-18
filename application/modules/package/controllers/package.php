<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /*
    * Package Controller
    * 
    * @Description: This function is used to manage join free, 1-year and 3-year package 
    * purchase section
    *
    * @modified date: 17-July-2014
    * @auther: lokendra meena
    * @email: lokendrameena@cdnsol.com
    * 
    */ 

class Package extends MX_Controller {
        
    private $data     =  array(); # global data array
    private $userId   =  null; # defined userId variable

    /**
     * Constructor
     */
    function __construct() {
        $load         =   array(
            'model'     =>  'package/model_package + membershipcart/model_membershipcart',
            'language'  =>  'package',
            'library'   =>  'lib_package',
            'config'    =>  'package + media/media'
        );
        parent::__construct($load);		
        $this->userId = isLoginUser();
    }
    
    // --------------------------------------------------------------------	
    
    /**
     * @Description: Toadsquare package information free, 1-year and 3-year
     * @access:	public
     * @return:	string
     */ 
    
    public function index(){
        $this->packagestageone();
    }
    
    // --------------------------------------------------------------------	
    
    /**
     * Toadsquare package information free, 1-year and 3-year
     * 
     * @access	public
     * @return	string
     */ 
    
    public function packageinformation(){
        $this->packagestageone();
    }
    
    // --------------------------------------------------------------------	
    
    /**
     * Toadsquare package information free, 1-year and 3-year
     * @access	public
     * @return	string
     */ 
    
    public function information() {
        
        $this->packagestageone();
        
        /*$userId = $this->isLoginUser();
        //get logged user subscription details data
        $whereSubcrip 	 = array('tdsUid' => $userId);
        $packageDetails  = $this->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($packageDetails)) {
            $packageDetails  = $packageDetails[0];
        }

        $this->data['packageDetails']   =   $packageDetails;  #set package details
        $this->data['userId']           =   $userId;  #set user id
        //Load right side help view
        $leftData=array(
            'welcomelink'=>base_url(lang().'/dashboard'),
            'isDashButton'=>true,
        );
        
        $leftView='dashboard/help_package';
        $this->data['leftContent'] = $this->load->view($leftView,$leftData,true);
        $this->template->load('backend_template','package/package_information',$this->data);
        */
    }
 
    // --------------------------------------------------------------------	

    /**
     * Toadsquare package information free, 1-year and 3-year
     * @access	public
     * @return	string
     */

    public function packagestageone()
    {
        $userId     =  isLoginUser(); # get logged user id
     
        //unset tempary hold data session 
        $this->session->unset_userdata('selectedPacakge');
        $this->session->unset_userdata('packagesubstage');
        $this->session->unset_userdata('packageCartId');
        $this->session->unset_userdata('upgradepackage');
        /* unset package upgrade session value */
        $this->session->unset_userdata('isUpgradePackage');
        //call stage next method allowed  for user
        $this->_nextstageallowed(array('1'),'packagestage');
        
        $userSubscription 	= false;   # set default data
        //still no need this page
        //$packagesinfo				= $this->lib_package->packageinformation();

        if(!empty($userId)){
            //get logged user subscription details data
            $whereSubcrip 		= array('tdsUid' => $userId);
            $userSubscription  = $this->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
            $userSubscription  = $userSubscription[0];
        }
 
        //get prepare package info data	
        $this->data['userId'] 	   			    = $userId;  #set user id
        $this->data['userSubscription'] 	    = $userSubscription; #set user subcription
        $this->data['packagestage'] 	        = '1';  #set package stage
        $this->data['packagestageheading'] 	    = $this->_getpackageheadertitle();  #set package heading
        
        //load view in master template
        $this->new_version->load('new_version','package_selection/package_stage_1',$this->data);
    }
     
    //-----------------------------------------------------------------------
     
    /*
     * @access: public
     * @description: this function is used to upgrade user package
     * @return true
     */ 
     
    public function packagestageonepost(){
        
        if($this->input->is_ajax_request()){
            $userId     =  isLoginUser(); # get logged user id
            
            //call stage next method allowed  for user
            $this->_nextstageallowed('2','packagestage');
     
            //set selected package information
            $selectedPacakge       = $this->input->post('selectedPacakge'); # set package info
            $this->session->set_userdata('selectedPacakge',$selectedPacakge);
            
            $msg          =  'Pacakge selected';
            $redirecturl  =  '/package/packagestagetwo';
            $returnData   =  array('msg'=>$msg,'redirecturl'=>$redirecturl);
            echo json_encode($returnData);
        }else{
            $msg   = 'Pacakge not updated';
            echo $this->_errormessage($msg);
        }
    } 
    
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is use to package stage 2
     * bill information and terma and condition
     * @return string
     */ 

    public function packagestagetwo(){
        
        //unset tempary hold data session 
        $this->session->unset_userdata('packageCartId');
       
        $userId     =  isLoginUser(); # get logged user id
    
        //check package is selected
        $packagestage = $this->session->userdata('packagestage');
        
        if(!in_array('2',$packagestage)){
            $msg = 'Please select package.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/packagestageone');
        }
        
        //get term & condition data
        $pageKey            = 'termsconditions';
        $cms_content        = $this->model_common->get_cms_content($pageKey);
        if(!empty($cms_content[0]['description'])){
            $this->data['description'] = $cms_content[0]['description'];
        }else {
            $this->data['description'] = '';
        }
        
        $selectedPacakge  = $this->session->userdata('selectedPacakge'); # get package infor
		if(in_array('3',$packagestage)){
			$isBackStep = true;
		}
            
        //get prepare package info data	
        $this->data['userId'] 	   			   = $userId;  #set user id
        $this->data['packagestage'] 	       = '2'; #set package stage
        $this->data['selectedPacakge']         = $selectedPacakge; # selected package for join/next button show
        $this->data['isBackStep'] 	   		   = (isset($isBackStep))?$isBackStep:'';  #set back step status
        $this->data['packagestageheading'] 	   = $this->_getpackageheadertitle(); #set package heading

        $this->new_version->load('new_version','package_selection/package_stage_2',$this->data);
        
    }
    
    function termsncondition() {
		
		//get term & condition data
        $pageKey            = 'termsconditions';
        $cms_content        = $this->model_common->get_cms_content($pageKey);
        if(!empty($cms_content[0]['description'])){
            $this->data['description'] = $cms_content[0]['description'];
        } else {
            $this->data['description'] = '';
        }
        
		$this->load->view('package_selection/package_terms',$this->data);
	}	

    //-----------------------------------------------------------------------
     
     /*
        * @access: public
        * @description: this function is used to upgrade user package
        * @return true
        */ 
     
    public function packagestagetwopost(){
        
        if($this->input->is_ajax_request()){
            $userId     =  isLoginUser(); # get logged user id
            
            //call stage next method allowed  for user
            $this->_nextstageallowed('3','packagestage'); 
         
            $selectedPacakge  = $this->session->userdata('selectedPacakge'); # get package info

            // if user selected free then redirect on join page
            //$selectedPacakge==$this->config->item('package_type_1')
            if($userId==false){
                $redirecturl  =  '/package/packagestagethree';
            }else{
                //call stage next method allowed  for user
                $this->_nextstageallowed('4','packagestage');
                $this->_nextstageallowed(array('1'),'packagesubstage');
                $redirecturl  =  '/package/membershipselected';
            }
            
            $msg = 'Pacakge selected';
            $returnData   =  array('msg'=>$msg,'redirecturl'=>$redirecturl);
            echo json_encode($returnData);
            
        }else{
            $msg = 'error';
            echo $this->_errormessage($msg);
        }
    } 

    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is use to selected membership and join 
     * for setup 3
     * @return string
     */ 

    public function packagestagethree(){
        
        $userId           = isLoginUser(); # get user id
        
        //check package is selected
        $packagestage = $this->session->userdata('packagestage');
        if(!in_array('3',$packagestage)){
            $msg = 'Please select package.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/packagestageone');
        }
        
        $selectedPacakge  = $this->session->userdata('selectedPacakge'); # get package infor
        
        //get prepare package info data	
        $this->data['userId']                    = $userId; # set user id 
        $this->data['packagestage']              = '3'; # set package stage 
        $this->data['selectedPacakge']           = $selectedPacakge; # selected package for join/next button show
        $this->data['packagestageheading']       = $this->_getpackageheadertitle(); #set package heading
        
        // if user selected free then show join button
        if($selectedPacakge==$this->config->item('package_type_1')){
            $this->data['isJoinButton']      = TRUE; # set join button show
        }

        $this->new_version->load('new_version','package_selection/package_stage_3',$this->data);
    } 
    
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: If user selected paid package then show this function
     * @return string
     */ 

    public function membershipselected(){
     
        $userId      =  isLoginUser(); # get user id
        
        //check package is selected
        $packagestage    = $this->session->userdata('packagestage'); #main stage array
        $packagesubstage = $this->session->userdata('packagesubstage'); #sub-stage array
        if(!in_array('4',$packagestage) || !in_array('1',$packagesubstage)){
            $msg = 'Please select package.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/packagestageone');
        }
        
        $selectedPacakge  = $this->session->userdata('selectedPacakge');
        
        //get prepare package info data	
        $this->data['userId']                    = $userId; # set user id 
        $this->data['packagestage']              = '4'; # set package stage 
        $this->data['packagestagesubmenu']       = '1'; # set package stage 
        $this->data['selectedPacakge']           = $selectedPacakge; # selected package for join/next button show
        $this->data['packagestageheading']       = $this->_getpackageheadertitle(); #set package heading

        $this->new_version->load('new_version','package_selection/package_stage_4_1',$this->data);
    }
    
    //-----------------------------------------------------------------------
     
     /*
        * @access: public
        * @description: this function is used to switch selected memberhsip to next stage
        * @return true
        */ 
     
    public function membershipselectedpost(){
        
        if($this->input->is_ajax_request()){
         
            //if user logged in then get id  
            if(isloginUser()){
                 $userId   =  isloginUser();
            }else{
                 $userId   =  $this->session->userdata('joinedUserId');
            } # get user id
         
            //get selected package id
            $selectedPacakge  =  $this->session->userdata('selectedPacakge');
            
            // get new membership titem type
            $itemType = $this->config->item('membership_item_type_4');
            
            //if use enter prome code then both (paid) package woulbe be free
            if(!isLoginUser() && $this->_promocodeuse($userId,$selectedPacakge,$itemType)){
                $msg          = 'Pacakge selected';
                $redirecturl  =  '/package/promocodejoined';
                $returnData   =  array('msg'=>$msg,'redirecturl'=>$redirecturl);
                echo json_encode($returnData);
                return true;
            }
            
            //add package data in temp tabel
            $this->_addpackage($userId,$selectedPacakge,$itemType);
         
            //call stage next method allowed  for user
            $this->_nextstageallowed('2','packagesubstage');
            // unset renew session value
            $this->session->unset_userdata('isRenewPackage');
            $msg          = 'Pacakge selected';
            $redirecturl  =  '/package/billingdetails';
            $returnData   =  array('msg'=>$msg,'redirecturl'=>$redirecturl);
            echo json_encode($returnData);
        }else{
            //error
            $msg = 'error';
            set_global_messages($msg, $type='success', $is_multiple=false);
            $returnData=array('msg'=>$msg);
            echo json_encode($returnData);
        }
    } 
    
    //----------------------------------------------------------------------
    
    /*
    * @access: private
    * @description: This method is use to promo code use
    * @auther: lokendra
    * @return: boolean
    */ 
    
    private function _promocodeuse($userId,$selectedPacakge,$itemType){
        
        $promoCode          =  $this->input->post('promoCode');
        $masterPromoCode    =  $this->config->item('master_promo_code');
        
         //get package id
        if($selectedPacakge==$this->config->item('package_type_2')) {
            $pakcageId            = $this->config->item('package_1_year_id');
            $masterPromoCode    =  $this->config->item('master_promo_code_1');
        }elseif($selectedPacakge==$this->config->item('package_type_3')){
            $pakcageId            = $this->config->item('package_3_year_id');
            $masterPromoCode    =  $this->config->item('master_promo_code_3');
        }
        
        if(!empty($promoCode)){
            if($promoCode==$masterPromoCode){
                
                //call stage next method allowed  for user
                //$this->_nextstageallowed('4','packagesubstage');
                
                //update user subscription with promo code 
                Modules::run("membershipcart/promocodesubcription",$userId,$pakcageId,$promoCode);
                
                return true;
            }else{
                $msg = 'You have entered wrong promo code.';
                //set_global_messages($msg, $type='error', $is_multiple=false);
                return false;
            }
        }
    }
    
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to package purchase billing information
     * @return string
     */ 

    public function billingdetails(){
        
        //check package is selected
        $packagestage    = $this->session->userdata('packagestage'); #main stage array
        $packagesubstage = $this->session->userdata('packagesubstage'); #sub-stage array
        if(!in_array('4',$packagestage) || !in_array('2',$packagesubstage)){
            $msg = 'Please select package.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/packagestageone');
        }
        
        //get new joined user id
        if(isLoginUser()){
                $userId     =  isLoginUser(); # get user id
         }else{
                $userId     =  $this->session->userdata('joinedUserId');
         }
        
        // get ordre billing details if already entered
        $cartId                 =   $this->session->userdata('packageCartId');
        $orderBillingDetails    =   $this->_orderBillingDetails($cartId);
        
        // if order billing details empty then use  buyer settings tabel
        if(empty($orderBillingDetails)){
            $orderBillingDetails =  $this->model_common->getDataFromTabel('UserBuyerSettings', '*',  array('tdsUid'=>$userId),'','','',1);

            if(!empty($orderBillingDetails)){
                $orderBillingDetails   =  $orderBillingDetails[0];
            }   
        }
        
        // get package information array
        $selectedPacakge  =  $this->session->userdata('selectedPacakge');
        
        //get prepare package info data	
        $this->data['userId']                    =  $userId; # set user id 
        $this->data['packagestage']              =  '4'; # set package stage 
        $this->data['packagestagesubmenu']       =  '2'; # set package stage 
        $this->data['orderBillingDetails']       =  $orderBillingDetails; # set buyer setting data 
        $this->data['selectedPacakge']           =  $selectedPacakge; # selected package for join/next button show
        $this->data['packagestageheading']       =  $this->_getpackageheadertitle(); #set package heading

        $this->new_version->load('new_version','package_selection/package_stage_4_2',$this->data);
    }
    
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to package purchase billing information
     * @return string
     */ 

    public function billingdetailspost(){
        
        if($this->input->is_ajax_request()){
            
            //get new joined user id
            if(isLoginUser()){
                
                    // set session for showing upgrade page
                    $this->session->set_userdata('upgradepackage','1');
                
                    $userId     =  isLoginUser(); # get user id
             }else{
                    $userId     =  $this->session->userdata('joinedUserId');
             }
            
            // get country details
            $countryId = $this->input->post('countriesList');	
            $countryName = $this->model_membershipcart->getUserCountryName($countryId);	
            
            $UserBuyerSettings            =   array(
                'tdsUid'                    =>  $userId,
                'billing_firstName'         =>  $this->input->post('firstName'),
                'billing_lastName'          =>  $this->input->post('lastName'),
                'billing_companyName'       =>  $this->input->post('companyName'),
                'billing_address1'          =>  $this->input->post('addressLine1'),
                'billing_address2'          =>  $this->input->post('addressLine2'),
                'billing_city'              =>  $this->input->post('townOrCity'),
                'billing_country'           =>  $this->input->post('countriesList'),
                'billing_state'             =>  $this->input->post('stateList'),
                'billing_zip'               =>  $this->input->post('zipCode'),
                'billing_email'             =>  $this->input->post('email'),
                'billing_phone'             =>  $this->input->post('phoneNumber'),
                //'countryName'               => $countryName->countryName,
                //'countryGroup'              => $countryName->countryGroup
            );
            
            // insert & udpate buyer data in user buyer table
            $buyerSettingData =  $this->model_common->getDataFromTabel('UserBuyerSettings', 'id',  array('tdsUid'=>$userId),'','','',1);
            
            // when user register then insert buyer settings 
            if(!isloginUser() || empty($buyerSettingData)){
                $this->model_common->addDataIntoTabel('UserBuyerSettings', $UserBuyerSettings);
            }
            
            // store billing details in cart tabel
            $cartId=$this->session->userdata('packageCartId'); 
            $json = array('billingdetails'=>json_encode($UserBuyerSettings));
            $this->model_common->editDataFromTabel('MembershipCart', $json, 'cartId', $cartId);
            
            //call stage next method allowed  for user
            $this->_nextstageallowed('3','packagesubstage');
            
            $msg          = 'Pacakge selected';
            $redirecturl  =  '/package/packagesummary';
            $returnData   =  array('msg'=>$msg,'redirecturl'=>$redirecturl);
            echo json_encode($returnData);
        }else{
            //error
            $msg = 'error';
            set_global_messages($msg, $type='success', $is_multiple=false);
            $returnData=array('msg'=>$msg);
            echo json_encode($returnData);
        }
    }
    
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to package purchase billing information
     * @return string
     */ 

    public function packagesummary(){
     
        //check package is selected
        $packagestage    =  $this->session->userdata('packagestage'); #main stage array
        $packagesubstage =  $this->session->userdata('packagesubstage'); #sub-stage array
        if(!in_array('4',$packagestage) || !in_array('3',$packagesubstage)){
            $msg =  'Please select package.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/packagestageone');
        }
        
        //get user id
        if(isLoginUser()){
                $userId     =  isLoginUser(); # get user id
         }else{
                $userId     =  $this->session->userdata('joinedUserId');
         }
        
        // order billing details
        $cartId                =   $this->session->userdata('packageCartId'); 
        $orderBillingDetails   =   $this->_orderBillingDetails($cartId);
    
        //get package info
        $selectedPacakge  =  $this->session->userdata('selectedPacakge');
        
        //get prepare package info data	
        $this->data['userId']                    =  $userId; # set user id 
        $this->data['packagestage']              =  '4'; # set package stage 
        $this->data['packagestagesubmenu']       =  '3'; # set package stage 
        $this->data['orderBillingDetails']       =  $orderBillingDetails; # set buyer setting data 
        $this->data['selectedPacakge']           =  $selectedPacakge; # selected package for join/next button show
        $this->data['packagestageheading']       =  $this->_getpackageheadertitle(); #set package heading
        $this->data['isPayNowButton']            =  TRUE; # set join button show
        

        $this->new_version->load('new_version','package_selection/package_stage_4_3',$this->data);
        
    }
    
    //----------------------------------------------------------------------
    
    /*
     * @Description: This method is use to get current order billing details
     * @return : object
     */ 
    
    private function _orderBillingDetails($cartId){
        $billingDetails  =   false; //set default value
        $orderBillingDetailsData  =   $this->model_common->getDataFromTabel('MembershipCart', 'billingdetails',  array('cartId'=>$cartId),'','','',1);
        // get buyer details data
        if(!empty($orderBillingDetailsData)){
            $orderBillingDetailsData = $orderBillingDetailsData[0];
            if(!empty($orderBillingDetailsData->billingdetails)){
               $billingDetails  = (object) json_decode($orderBillingDetailsData->billingdetails);
            }
        }
        return $billingDetails;
    }
    
    
    //----------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: promo code use registered user
    * @return: void
    */ 
    
    public function promocodejoined(){
        
        //unset tempary hold data session 
        $this->session->unset_userdata('selectedPacakge');
        $this->session->unset_userdata('packagesubstage');
        $this->session->unset_userdata('packageCartId');
  
        $this->freejoined();
    }
    
    //----------------------------------------------------------------------

    /*
    * @access: private
    * @description: This function is used to show join free success message
    * @return void
    */ 

    public function freejoined(){

        $userId      =  isLoginUser(); # get user id

        //get prepare package info data	
        $this->data['userId'] 	   			  = $userId;

        $this->new_version->load('new_version','package_selection/joined_free_welcome_screen',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to show join free success message
     * @return void
     */ 
    
    public function paidjoined(){
            
        if(isLoginUser()){
            $userId     =  isLoginUser(); # get user id
        }else{
            $userId     =  $this->session->userdata('joinedUserId');
        } 
        
        $whereUserCondition 		= array('tdsUid' => $userId);
        $getUserData    = $this->model_common->getDataFromTabel('UserAuth', 'fbUid, email',  $whereUserCondition, '', $orderBy='tdsUid', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        
        if(!empty($getUserData)){
            $getUserData = $getUserData[0];
            if(!empty($getUserData->fbUid) && isLoginUser() == false){
                // this condition for facecbook user
                $userEmail = $getUserData->email;
                //set session for fb user 
                $this->load->library('auth/tank_auth');
                $this->tank_auth->loginWithFacebook($userEmail);  
                redirect(base_url(lang().'/dashboard'));
            }else{
                // this condition for normal user
                $this->_paidwelcomescreen();
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @Description: welcome to screen for normal paid join and package upgrade
     * 
     * @return void
     */ 
    
    private function _paidwelcomescreen(){
            
        //check package is selected
        $packagestage    =  $this->session->userdata('packagestage'); #main stage array
        $packagesubstage =  $this->session->userdata('packagesubstage'); #sub-stage array
        if(!in_array('4',$packagestage) || !in_array('4',$packagesubstage)){
            $msg =  'Please select package.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/packagestageone');
        }

        if(isLoginUser()){
            $userId     =  isLoginUser(); # get user id
        }else{
            $userId     =  $this->session->userdata('joinedUserId');
        }

        //get prepare package info data	
        $this->data['userId'] 	   			  =  $userId;
        $this->data['packagestage']           =  '4'; # set package stage 
        $this->data['packagestagesubmenu']    =  '4'; # set package stage 
        $this->data['packagestageheading']    =  $this->_getpackageheadertitle(); #set package heading

        //get show view name 
        if($this->session->userdata('upgradepackage')){
            $viewName = "package_selection/package_stage_4_4_upgrade";
        }else{
            $viewName = "package_selection/package_stage_4_4_joined_message";
        }

        $this->new_version->load('new_version',$viewName,$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to show payment error view
     * @return void
     */ 
    
    public function paymenterror(){
            
        $userId     =  isLoginUser(); # get user id
        
        //get prepare package info data	
        $this->data['userId']                    =  $userId;
        $this->data['packagestageheading']       =  'Payment Error'; #set package heading
        
        $this->new_version->load('new_version','payment_error',$this->data);
    }
    
    //----------------------------------------------------------------------
    
    /*
    * @access: private
    * @description: This is globle error message method
    * @param = string 
    * @return array
    */ 
    private function _errormessage($message){
        set_global_messages($message, $type='error', $is_multiple=false);
        $returnData =array('msg'=>$message);
        return json_encode($returnData);
    }
    
    //-----------------------------------------------------------------------
    
    /*
    * @access: private
    * @description: This package stage switch 
    * @param = number 
    * @return bool
    */ 
    private function _nextstageallowed($stageNumber,$setKey){
        $packagestage   =  $this->session->userdata($setKey); # get stage array
        if(is_array($stageNumber)){
            $packagestage = $stageNumber;
        }else{
            array_push($packagestage,$stageNumber); # push stage next
        }
        $this->session->set_userdata($setKey,$packagestage); # set stage 
        return true;
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @access: priate
     * @description: This function is used to add package data in temp tabel
     * @param = number 
     * @return bool
     */ 	 
     
    private function _addpackage($userId,$selectedPacakge,$itemType){

        if($selectedPacakge==$this->config->item('package_type_2')){
            $packagePrice       = $this->config->item('package_1_year_price');
            $pkgId            = $this->config->item('package_1_year_id');
        }elseif($selectedPacakge==$this->config->item('package_type_3')){
            $packagePrice       = $this->config->item('package_3_year_price');
            $pkgId            = $this->config->item('package_3_year_id');
        }
        
        // get default vate percent
        $vatPercent      =  $this->config->item('package_vat_percent');
        $VatPrice        = (($packagePrice*$vatPercent)/100);
        
        //calculate total price  = totalPrice+ vatPrice
        $totalPrice =  $packagePrice + $VatPrice;
        
        //prepare package insert data
        $inserts = array('totalPrice'=>$totalPrice,'totalTaxAmt'=>$VatPrice,'tdsUid'=>$userId);

        // if package cart create then true true  
        if($this->session->userdata('packageCartId')){
            return true; 
        }
        
        // insert data in  temp membership cart tabel
        $cartId = $this->model_membershipcart->addData($inserts);

        $this->session->set_userdata('packageCartId',$cartId);

        // prepare membership cart item data
        $memItemInsert['cartId']        =  $cartId;
        $memItemInsert['tsProductId']   =  '0';
        $memItemInsert['price']         =  $packagePrice;
        $memItemInsert['size']          =  mbToBytes($this->config->item('package_membership_default_space'),'gb');
        $memItemInsert['pkgId']         =  $pkgId;
        $memItemInsert['pkgRoleId']     =  '0';
        $memItemInsert['totalPrice']    =  $totalPrice;
        $memItemInsert['taxAmt']        =  $VatPrice;
        $memItemInsert['type']          =  $itemType;

        // insert data in  temp membership cart item tabel
        $this->model_membershipcart->addDataMem($memItemInsert);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to renew first stage
     * @return array 
     */ 
    
    public function renewstageone($isFromRenew=0){

        $userId = $this->isLoginUser(); # get logged user id
        
        //unset degrade session if method call from renew section
        if($isFromRenew == 1) {
            $this->session->unset_userdata('isDegradePackage');
        }

        //get degrade session value if exist
        $isDowngradePackage = $this->session->userdata('isDegradePackage');
    
        if(empty($isDowngradePackage)) {
			//call renew page restrict
			$this->_packagerenewrestrict($userId);
        }
        
        //unset temprary holder
        $this->session->unset_userdata('renewstage');
        $this->session->unset_userdata('renewsubstage');
        $this->session->unset_userdata('packageCartId');
        $this->session->unset_userdata('selectedCampaignId');
        $this->session->unset_userdata('isRenewPackage'); 
		$this->session->unset_userdata('isUpgradePackage');
		 
        //call stage next method allowed  for user
        $this->_nextstageallowed(array('1'),'renewstage');
    
        //get renew compaign list
        $campaignList     =  $this->model_package->renew_campaign_list($userId);
        
        // if user have not campaign created then redirect on renew stage 2 
        if(empty($campaignList)){
            
            //skip stage first and redirect on stage 2
            $this->_nextstageallowed(array('1','2'),'renewstage');
            redirect(base_url('package/renewstagetwo'));
        }
                
        //get prepare package info data	
        $this->data['userId'] 	   			   = $userId;  #set user id
        $this->data['renewstage'] 	           = '1'; #set renew stage
        $this->data['campaignList'] 	       = $campaignList; #set renew stage
        $this->data['packagestageheading'] 	   = $this->_getrenewpackagetitle(); #set package heading

        $this->new_version->load('new_version','package_renew/renew_stage_1',$this->data);
    }
    
    //----------------------------------------------------------------------
    
    /*
     * @access: private
     * @description: This function is use to restrict renew page  
     */ 
    
    private function _packagerenewrestrict($userId="0"){
        //get logged user subscription details data and check package is allow for renew
        $whereSubcrip 		= array('tdsUid' => $userId);
        $packageDetails  = $this->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($packageDetails)){
            $packageDetails  = $packageDetails[0];
            $packageEndDate    =  (!empty($packageDetails->endDate))?$packageDetails->endDate:'';
            $renewDay                 =  $this->config->item('renew_button_before_day');
            $renewDate                =  date('Y-m-d', strtotime($renewDay, strtotime($packageEndDate)));
            $renewDateStrtotime       =  strtotime($renewDate);
            $currentDateStrtotime     =  time();

            // this section show only when renew button show
            if($renewDateStrtotime > $currentDateStrtotime){
                $msg =  'You can not access this page.';
                set_global_messages($msg, $type='error', $is_multiple=false);
                redirect('package');
            }
        }
    }
     
    //----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This function is used to renew first stage post
     * @return array 
     */ 
    
    public function renewstageonepost(){

     if($this->input->is_ajax_request()){
        $userId = $this->isLoginUser(); # get logged user id

        //call stage next method allowed  for user
        $this->_nextstageallowed('2','renewstage');

        //manage campaign while renew
        if($this->input->post('campaignId')){
            $campaignId= $this->input->post('campaignId');
            $this->session->set_userdata('selectedCampaignId',$campaignId);
        }

        $msg          = 'Save details successfully.';
        $redirecturl  =  '/package/renewstagetwo';
        $returnData   =  array('msg'=>$msg,'redirecturl'=>$redirecturl);
        echo json_encode($returnData);
     }else{
            $msg   = 'Don\'t have access this page.';
            echo $this->_errormessage($msg);
     }
        
    }
        
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is use to renew stage 2
     * terma and condition
     * @return string
     */ 

    public function renewstagetwo(){
     
        $userId     =  isLoginUser(); # get logged user id
        
		//unset temprary holder
		$this->session->unset_userdata('packageCartId');
	
        //check package is selected
        $renewstage    =  $this->session->userdata('renewstage'); #main stage array 
        
		//get degrade session value if exist
        $isDowngradePackage = $this->session->userdata('isDegradePackage');
       
        if(!in_array('2',$renewstage) && empty($isDowngradePackage)){
            $msg =  'You don\'t have access. directory';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/renewstageone');
        }
        
        if(empty($isDowngradePackage)) {
			// set session value for renew
			$this->session->set_userdata('isRenewPackage',1);
		}

        //get term & condition data
        $pageKey            = 'termsconditions';
        $cms_content        = $this->model_common->get_cms_content($pageKey);
        if(!empty($cms_content[0]['description'])){
            $this->data['description'] = $cms_content[0]['description'];
        }else {
            $this->data['description'] = '';
        }
        
        if(in_array('3',$renewstage)){
			$isBackStep = true;
		}

        //get prepare package info data
        $this->data['userId'] 	   			   = $userId;  #set user id
        $this->data['renewstage'] 	           = '2'; #set package stage
        $this->data['isBackStep'] 	   		   = (isset($isBackStep))?$isBackStep:'';  #set back step status
        $this->data['packagestageheading'] 	   = $this->_getrenewpackagetitle(); #set package heading

        $this->new_version->load('new_version','package_renew/renew_stage_2',$this->data);
    }
    
    //----------------------------------------------------------------------

    /*
    * @access: public
    * @description: This function is used to renew first stage post
    * @return array 
    */ 

    public function renewstagetwopost(){

        if($this->input->is_ajax_request()){
            $userId = $this->isLoginUser(); # get logged user id

            //call stage next method allowed  for user
            $this->_nextstageallowed('3','renewstage');
            $this->_nextstageallowed(array('1'),'renewsubstage');
            
            //get renew pacakge type
            $whereSubcrip 		= array('tdsUid' => $userId);
            $packageDetails  = $this->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
            if(!empty($packageDetails)){
                $packageDetails  = $packageDetails[0];

                //get degrade session value if exist
                $isDowngradePackage = $this->session->userdata('isDegradePackage');
                if(!empty($isDowngradePackage)) {
                    //set annual package type for degrade
                    $renewPackageType = $this->config->item('package_type_2');
                    // get new membership item type
                    $itemType = $this->config->item('membership_item_type_4');
                } else {
                    //renew package type
                    $renewPackageType = $packageDetails->subscriptionType;
                    // get new membership item type
                    $itemType = $this->config->item('membership_item_type_7');
                }

                //add package new data in temp tabel
                $this->_addpackage($userId,$renewPackageType,$itemType);

                /* get users subscription day difference */
                $dayDifference = getSubscriptionDayDiff();

                if(empty($isDowngradePackage)) {
                    // if user purchase extra space then add space item
                    $this->_renewaddextraspace($userId);	
                } 
                // if user have campaign then add cantainer in membership cart item
                $this->_renewselectedcampaign($userId);
            }

            $msg          =  'Save details successfully.';
            $redirecturl  =  '/package/renewbillingdetails';
            $returnData   =  array('msg'=>$msg,'redirecturl'=>$redirecturl);
            echo json_encode($returnData);
        }else{
            $msg   = 'Don\'t have access this page.';
            echo $this->_errormessage($msg);
        }
    }
    
    //----------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This function is used to add extra space renew item add
    * @return string
    */ 
    
    private function _renewaddextraspace($userId){

        $addSpaceType = $this->config->item('membership_item_type_2'); //renew extra space type
        $renewSpaceType = $this->config->item('membership_item_type_9'); //renew extra space type
        $whereSubcrip 	    	=  array('tdsUid' => $userId,'type' => $addSpaceType);
        $extraSpaceItemList   =  $this->model_common->getDataFromTabel('UserMembershipItem', '*',  $whereSubcrip, '', $orderBy='memItemId', $order='ASC');
     
        if(!empty($extraSpaceItemList)){
            
            $extraSpacePrice =  multiarraysum($extraSpaceItemList,'totalPrice');
            $extraSpaceSize  =  multiarraysum($extraSpaceItemList,'size');
            $tsProductId  = (!empty($extraSpaceItemList[0]->tsProductId))?$extraSpaceItemList[0]->tsProductId:'20'; // default product id for space
            
            // get current cart order id
            $packageCartId    = $this->session->userdata('packageCartId');
            
            // prepare membership cart item data
            $memCartItem['cartId']        =  $packageCartId;
            $memCartItem['tsProductId']   =  $tsProductId;
            $memCartItem['price']         =  $extraSpacePrice;
            $memCartItem['size']          =  $extraSpaceSize;
            $memCartItem['pkgId']         =  '0';
            $memCartItem['pkgRoleId']     =  '0';
            $memCartItem['totalPrice']    =  $extraSpacePrice;
            $memCartItem['taxAmt']        =  '0';
            $memCartItem['type']          =  $renewSpaceType;
        
            // insert data in  temp membership cart item tabel
            $this->model_membershipcart->addDataMem($memCartItem);
            
            //call method for membership cart price update 
            $this->_updatemembershipcartprice($packageCartId, $extraSpacePrice);
         
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @Description: update memebrship cart price 
     * @return void
     */
    
    private function _updatemembershipcartprice($packageCartId,$addPrice){
        
        //update price of membership cart
        $whereMemCart 	    	=  array('cartId' => $packageCartId);
        $MembershipCartData   =  $this->model_common->getDataFromTabel('MembershipCart', '*',  $whereMemCart, '', $orderBy='cartId', $order='ASC');

        if(!empty($MembershipCartData)){
            $membershipCartData         =  $MembershipCartData[0];  
            $memberTotalPrice           =  $membershipCartData->totalPrice;
            $memberTotalPrice          =  $memberTotalPrice  + $addPrice;

            //update price in membership cart
            $json = array('totalPrice'=>$memberTotalPrice);
            $this->model_common->editDataFromTabel('MembershipCart', $json, 'cartId', $packageCartId);
        }
    }
    
    //----------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This function is used to add campaign renew item add
    * @return string
    */ 
    
    private function _renewselectedcampaign($userId){
        
        // get selected campaign list
        $campaignIdArr =  $this->session->userdata('selectedCampaignId');
        $itemType = $this->config->item('membership_item_type_3');

        //get renew compaign list
        $selectedCampaignList     =  $this->model_package->selected_campaign_list($userId, $campaignIdArr);
        
        $campaignPrice = 0;
        if(!empty($selectedCampaignList)){
            foreach($selectedCampaignList as $selectedCampaign){
             
                // get current cart order id
                $packageCartId    = $this->session->userdata('packageCartId');
                
                // prepare membership cart item data
                $memCartItem['cartId']        =  $packageCartId;
                $memCartItem['tsProductId']   =  $selectedCampaign['tsProductId'];
                $memCartItem['price']         =  $selectedCampaign['basePrice'];
                $memCartItem['size']          =  $selectedCampaign['containerSize'];
                $memCartItem['pkgId']         =  $selectedCampaign['pkgId'];
                $memCartItem['pkgRoleId']     =  $selectedCampaign['pkgRoleId'];
                $memCartItem['totalPrice']    =  $selectedCampaign['totalPrice'];
                $memCartItem['entityId']      =  $selectedCampaign['entityId'];
                $memCartItem['elementId']     =  $selectedCampaign['elementId'];
                $memCartItem['taxAmt']        =  '0';
                $memCartItem['type']          =  $itemType;
         
                // insert data in  temp membership cart item tabel
                $this->model_membershipcart->addDataMem($memCartItem);
                
                //add each campaign price
                $campaignPrice =   $campaignPrice + $selectedCampaign['totalPrice'];
            }
            
            //call method for membership cart price update 
            $this->_updatemembershipcartprice($packageCartId, $campaignPrice);
        }
    }
    
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to package renew billing information
     * @return string
     */ 

    public function renewbillingdetails(){
        
        $userId     =  $this->isLoginUser(); # get logged user id
        
        //check package is selected
        $renewstage    =  $this->session->userdata('renewstage'); #main stage array
        $renewsubstage = $this->session->userdata('renewsubstage'); #sub-stage array
        if(!in_array('3',$renewstage) || !in_array('1',$renewsubstage)){  
            $msg =  'You don\'t have access directory.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/renewstageone');
        }
    
        // get buyer billing details
        $cartId                 =   $this->session->userdata('packageCartId'); 
        $orderBillingDetails    =   $this->_orderBillingDetails($cartId);
         
        if(empty($orderBillingDetails)){ 
            // get buyer details if already exist
            $orderBillingDetails =  $this->model_common->getDataFromTabel('UserBuyerSettings', '*',  array('tdsUid'=>$userId),'','','',1);

            if(!empty($orderBillingDetails)){
                $orderBillingDetails   =  $orderBillingDetails[0];
            }
        }
        
        //get prepare renew info data	
        $this->data['userId']                    =  $userId; # set user id 
        $this->data['renewstage']                =  '3'; # set renew stage 
        $this->data['renewstagesubmenu']         =  '1'; # set renew stage 
        $this->data['orderBillingDetails']       =  $orderBillingDetails; # set buyer setting data 
        $this->data['packagestageheading']       =  $this->_getrenewpackagetitle();; #set package heading

        $this->new_version->load('new_version','package_renew/renew_stage_3_1',$this->data);
    }
    
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to renew billing information
     * @return string
     */ 

    public function renewbillingdetailspost(){
        
        if($this->input->is_ajax_request()){
            
            $userId     =  $this->isLoginUser(); # get logged user id
            
            // get country details
            $countryId = $this->input->post('countriesList');	
            $countryName = $this->model_membershipcart->getUserCountryName($countryId);	
            
            $UserBuyerSettings            =   array(
                'tdsUid'                    =>  $userId,
                'billing_firstName'         =>  $this->input->post('firstName'),
                'billing_lastName'          =>  $this->input->post('lastName'),
                'billing_companyName'       =>  $this->input->post('companyName'),
                'billing_address1'          =>  $this->input->post('addressLine1'),
                'billing_address2'          =>  $this->input->post('addressLine2'),
                'billing_city'              =>  $this->input->post('townOrCity'),
                'billing_country'           =>  $this->input->post('countriesList'),
                'billing_state'             =>  $this->input->post('stateList'),
                'billing_zip'               =>  $this->input->post('zipCode'),
                'billing_email'             =>  $this->input->post('email'),
                'billing_phone'             =>  $this->input->post('phoneNumber'),
            );
            
            // store billing details in cart tabel
            $cartId=$this->session->userdata('packageCartId'); 
            $json = array('billingdetails'=>json_encode($UserBuyerSettings));
            $this->model_common->editDataFromTabel('MembershipCart', $json, 'cartId', $cartId);
            
            //call renew stage next method allowed  for user
            $this->_nextstageallowed('2','renewsubstage');
            
            $msg          = 'Pacakge selected';
            $redirecturl  =  '/package/renewsummary';
            $returnData   =  array('msg'=>$msg,'redirecturl'=>$redirecturl);
            echo json_encode($returnData);
        }else{
            //error
            $msg = 'error';
            set_global_messages($msg, $type='success', $is_multiple=false);
            $returnData=array('msg'=>$msg);
            echo json_encode($returnData);
        }
    }
    
     //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to renew summary list
     * @return string
     */ 

	public function renewsummary(){
	
		//check renew is selected
		$renewstage    =  $this->session->userdata('renewstage'); #main stage array
		$renewsubstage = $this->session->userdata('renewsubstage'); #sub-stage array


		if(!in_array('3',$renewstage) || !in_array('2',$renewsubstage)){  
			$msg =  'You don\'t have access directory.';
			set_global_messages($msg, $type='error', $is_multiple=false);
			redirect('package/renewstageone');
		}

		//get user id
		$userId     =  $this->isLoginUser(); # get logged user id

		// get buyer order billing details 
		$cartId                 =   $this->session->userdata('packageCartId'); 
		$orderBillingDetails    =   $this->_orderBillingDetails($cartId);

		// get selected campaign list
		$campaignIdArr =  $this->session->userdata('selectedCampaignId');

		//get renew compaign list
		$selectedCampaignList     =  $this->model_package->selected_campaign_list($userId, $campaignIdArr);

		// get user extra space price  
		$itemType             =  $this->config->item('membership_item_type_2');
		$whereSubcrip         =  array('tdsUid' => $userId,'type' => $itemType);
		$extraSpaceItemList   =  $this->model_common->getDataFromTabel('UserMembershipItem', '*',  $whereSubcrip, '', $orderBy='memItemId', $order='ASC');

		//get renew pacakge type
		$whereSubcrip 		=  array('tdsUid' => $userId);
		$packageDetails   =  $this->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);

		if(!empty($packageDetails)){
			$packageDetails  =  $packageDetails[0];
		}

		//get degrade session value if exist
		$isDowngradePackage = $this->session->userdata('isDegradePackage');
		
		if(!empty($isDowngradePackage)) {
			$selectedPacakge = $this->config->item('package_type_2');
			$extraSpaceItemList = '';
			
		} else {
			$selectedPacakge  =  $packageDetails->subscriptionType;
		}

		//get prepare package info data	
		$this->data['extraSpaceItemList']        =  $extraSpaceItemList; # extra space list
		$this->data['selectedCampaignList']      =  $selectedCampaignList; # selected campaign list
		$this->data['userId']                    =  $userId; # set user id 
		$this->data['renewstage']                =  '3'; # set renew stage 
		$this->data['renewstagesubmenu']         =  '2'; # set renew stage 
		$this->data['orderBillingDetails']       =  $orderBillingDetails; # set buyer setting data 
		$this->data['selectedPacakge']           =  $selectedPacakge; # selected package for join/next button show
		$this->data['packagestageheading']       =  $this->_getrenewpackagetitle(); #set package heading
		$this->data['isPayNowButton']            =  TRUE; # set renew button show

		$this->new_version->load('new_version','package_renew/renew_stage_3_2',$this->data);

	}
     
    //----------------------------------------------------------------------

    /*
    * @Description: This method is used to renew success message
    * @return void
    */ 

    public function renewsuccess(){

        //check renew is selected
        $renewstage    =  $this->session->userdata('renewstage'); #main renew stage array
        $renewsubstage = $this->session->userdata('renewsubstage'); #renew sub-stage array
    
        //get degrade session value if exist
        $isDowngradePackage = $this->session->userdata('isDegradePackage');
    
        if((!in_array('3',$renewstage) || !in_array('3',$renewsubstage)) && empty($isDowngradePackage)){  
            $msg =  'You don\'t have access directory.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/renewstageone');
        }

        //get user id
        $userId =  $this->isLoginUser(); # get logged user id

        
        //set success page heading
        $welcomeHeading = $this->lang->line('pack_renew_welcome_msg_heading_1');
        //set degrade package heading
        $packageHeading = $this->lang->line('pack_renew_heading_1');
        /* update user subscription */
        if(!empty($isDowngradePackage)) {
            /* Add degrade data in membership cart */
            $storeCartData = $this->_managedegradecartdata();
            if(!empty($storeCartData) && isset($storeCartData)) {
                $refundDegrade =  Modules::run("membershipcart/payments_pro/refundDegradeAmount");	
                if(isset($refundDegrade)) {
                    /* update user subscription */
                    //$this->_managedegradethreetoone($userId); //comment by lokendra 3-dec-2014 no need this
                }
            }
            //set success heading for degrade
            $welcomeHeading = $this->lang->line('pack_degrade_welcome_msg_heading_1');
            //set degrade package heading
            $packageHeading = $this->lang->line('pack_degrade_heading_1');
        }

        //get prepare package info data	
        $this->data['userId'] 	   			     = $userId;
        $this->data['renewstage']                =  '3'; # set renew stage 
        $this->data['renewstagesubmenu']         =  '3'; # set renew stage 
        $this->data['selectedPacakge']           =  $selectedPacakge; # selected package for join/next button show
        $this->data['packagestageheading']       =  $packageHeading; #set package heading
        $this->data['successMsg']                =  $welcomeHeading; # set success page header

        $this->new_version->load('new_version','package_renew/renew_stage_3_3_renew_success',$this->data);
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @Description: This function is use for membership refund
    * @return void
    */ 
    
    public function refundpackage(){
        $this->session->unset_userdata('isDegradePackage');
        $this->refundstageone();
    }
    
    //-----------------------------------------------------------------------
    
    /*
    * @Description: This function is use for membership refund
    * @return void
    */ 
    
    public function refundstageone(){
        
        // get logged in user Id
        $userId     =   $this->isLoginUser(); 
        
        // unset session
        $this->session->unset_userdata('selectionNumberId');  
        $this->session->unset_userdata('refundstage');
        $this->session->unset_userdata('refundsubstage');
        $this->session->unset_userdata('allContainerId');
        $this->session->unset_userdata('refundCartId');
        
        // get user subcription data 
        $usersubscriptiondetails = $this->_usersubscriptiondetails();
        
        //check subscription data
        if(!empty($usersubscriptiondetails)){
                $packageId        =  $usersubscriptiondetails->pkgId;
                $selectedPackage  =  $usersubscriptiondetails->subscriptionType;
                
                // check package should not be free
                if($packageId==1  && $selectedPackage==1){
                    $msg =  'You can not have access this page.';
                    set_global_messages($msg, $type='error', $is_multiple=false);
                    redirect('package');
                }
        }
    
        // media showcase project list
        $mediaprojectlist = $this->model_package->mediashowcaseprojectlist($userId);
        
        // get event launch project list
        $eventlaunchprojectlist = $this->model_package->eventlaunchprojectlist($userId);
        
        // get event launch project list
        $addcampaignprojectlist = $this->model_package->addcampaignprojectlist($userId);
        
        // get compeition project list
        $competitionprojectlist = $this->model_package->competitionprojectlist($userId);
        
        // get Product project list
        $collaborationprojectlist = $this->model_package->collaborationprojectlist($userId);
        
        // get Product project list
        $productprojectlist       = $this->model_package->productprojectlist($userId);
        
        // get Upcomming project list
        $upcommingprojectlist     = $this->model_package->upcommingprojectlist($userId);
        
        // get Work Profile  list
        $workprofileprojectlist   = $this->model_package->workprofileprojectlist($userId);
        
        //if user not created any container then direct redirect to billing details page
        if(empty($mediaprojectlist) && empty($eventlaunchprojectlist) && empty($addcampaignprojectlist) && empty($competitionprojectlist) &&
			empty($collaborationprojectlist) && empty($productprojectlist) && empty($upcommingprojectlist) && empty($workprofileprojectlist)){
			//call stage next method allowed  for user
			$this->_nextstageallowed(array('1','2','3'),'refundstage');
			$this->_nextstageallowed(array('1'),'refundsubstage');
             
			redirect('package/refundbillingdetails');
             
        }else{
             //call stage next method allowed  for user
            $this->_nextstageallowed(array('1'),'refundstage');
        }
        
        //get prepare package info data	
        $this->data['userId']                     =  $userId;
        $this->data['mediaprojectlist']           =  $mediaprojectlist;
        $this->data['eventlaunchproject']         =  $eventlaunchprojectlist;
        $this->data['addcampaignprojectlist']     =  $addcampaignprojectlist;
        $this->data['competitionprojectlist']     =  $competitionprojectlist;
        $this->data['collaborationprojectlist']   =  $collaborationprojectlist;
        $this->data['productprojectlist']         =  $productprojectlist;
        $this->data['upcommingprojectlist']       =  $upcommingprojectlist;
        $this->data['workprofileprojectlist']     =  $workprofileprojectlist;
        $this->data['refundtage']                 =  '1'; # set refund stage 
        $this->data['packagestageheading']        =  $this->_getrefundpackagetitle(); #set package refund heading
        
        $this->new_version->load('new_version','package_refund/refund_stage_1',$this->data);
    }
    
    function testEvent() {
		$test = $this->model_package->eventlaunchprojectlist($this->isLoginUser());
		echo "<pre>";
		print_r($test);die;
	}
        
    //-----------------------------------------------------------------------
    
    public function refundstageonepost(){
        
        if($this->input->post()){
         
            // selected contianer id
            $selectedContainerId 	=  $this->input->post('selectedContainerId'); 
            $allContainerId			=  $this->input->post('containerId'); 
            $selectionNumberId     	=  rand(); // get random number for selection
            $this->session->set_userdata('selectionNumberId',$selectionNumberId);  // set random number for selection number id
            
            // get logged in user Id
            $userId     =   $this->isLoginUser(); 
            
            if(!empty($selectedContainerId)){
                foreach($selectedContainerId as $containerId){
                    
                    $containerDefaultSize    =  $this->config->item('defaultContainerStorageSpace_Byets'); // default size of container
                    $industrySection         =  $this->input->post($containerId.'_industrySection');
                    $title                   =  $this->input->post($containerId.'_title');
                    $price                   =  $this->input->post($containerId.'_price');
                    $containerPrice          =  $this->input->post($containerId.'_containerPrice');
                    $extraSpacePrice         =  $this->input->post($containerId.'_extraSpacePrice');
                    $extraSpaceSize          =  $this->input->post($containerId.'_extraSpaceSize');
                    $projectId               =  $this->input->post($containerId.'_projectId');
                    $industryType              =  $this->input->post($containerId.'_industryType');
                    $containerTotalSize      =  $containerDefaultSize + $extraSpaceSize; //calculate total space
                    
                    $selectionDataAdd               =   array(
                            'industrySection'       =>  $industrySection,
                            'userContainerId'       =>  $containerId,
                            'title'                 =>  $title,
                            'description'           =>  NULL,
                            'totalPrice'            =>  $price,
                            'tdsUid'                =>  $userId,
                            'selectionNumber'       =>  $selectionNumberId,
                            'containerPrice'        =>  $containerPrice,
                            'extraSpacePrice'       =>  $extraSpacePrice,
                            'containerDefaultSize'  =>  $containerDefaultSize,
                            'ExtraSpaceSize'        =>  $extraSpaceSize,
                            'containerTotalSize'    =>  $containerTotalSize,
                            'projectId'             =>  $projectId,
                            'industryType'          =>  $industryType,
                            'createdDate'           =>  date("d-F-Y H:i:s"),
						);
                    $this->model_common->addDataIntoTabel('refundSelectionTemp', $selectionDataAdd);
                    unset($selectionDataAdd);
                }
            }
            
            if(!empty($allContainerId)){
                    $this->session->set_userdata('allContainerId',$allContainerId);
            }
            
            //call refund stage next method allowed  for user
            $this->_nextstageallowed('2','refundstage');
              
            //------- Apply changes after skip stage 2 
			//call refund stage next method allowed  for user
			$this->session->unset_userdata('refundCartId');
			$this->_nextstageallowed('3','refundstage');
			$this->_nextstageallowed(array('1'),'refundsubstage');
			
			//get selection number id
			$selectionNumberId      =  $this->session->userdata('selectionNumberId');
			
			//insert refund cart temp data
			$selectedContainerList   = $this->model_package->getSelectedContainerList($userId,$selectionNumberId);
			
			//total selected container price
			$totalPaidPrice           =  0;
			if(!empty($selectedContainerList)){ 
				$totalPaidPrice  =  multiarraysum($selectedContainerList,'totalPrice');
			}
			
			//check paid price to memebrhsip amount  while downgrade 
			$isPaypalPost        =  false;
			if($totalPaidPrice > 0){
				$isPaypalPost      =  true;
			}
			
			//pay downgrade package action
			if($isPaypalPost){
				$this->_paydowngradepackage($userId,$totalPaidPrice);
			} 
             //------- Apply changes after skip stage 2 
             
            redirect('package/refundbillingdetails'); 
        }else{
            $msg =  'You don\'t have access this page.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/refundstageone'); 
        }
    }
    
    
    //-----------------------------------------------------------------------
    
    /*
    * @Description: This function is use for manage selected cantainer
    * @return void
    */ 
 
    public function refundstagetwo(){
     
        //check refund is selected
        $refundstage    =  $this->session->userdata('refundstage'); #main stage array
        if(!in_array('2',$refundstage)){  
        $msg =  'You don\'t have access directory.';
        set_global_messages($msg, $type='error', $is_multiple=false);
        redirect('package/refundstageone');
        }

        // get logged in user Id
        $userId     =   $this->isLoginUser();   
            
        // get section number
        $selectionNumberId      =  $this->session->userdata('selectionNumberId');
        
        // get selected container list data
        $selectedContainerList   = $this->model_package->getSelectedContainerList($userId,$selectionNumberId);
        
        $this->data['selectedContainerList']      =  $selectedContainerList; # set refund stage 
        $this->data['refundtage']                 =  '2'; # set refund stage 
        $this->data['packagestageheading']        =  $this->_getrefundpackagetitle(); #set package refund heading

        $this->new_version->load('new_version','package_refund/refund_stage_2',$this->data);
    }
    
    //-----------------------------------------------------------------------
    
    /*
     * @Description: This function is used to delete selected container
     * @return void
     */ 
    
    public function refundselectiondelete(){
        if($this->input->is_ajax_request()){
           $selectionId = $this->input->post('selectionId');
           
            // refund selection data delete
            $this->model_common->deleteRowFromTabel('refundSelectionTemp','refundSelectionId',$selectionId);
           
            $msg          =  'Record deleted successfully.';
            $returnData   =  array('msg'=>$msg,'isDeleted'=>true);
            set_global_messages($msg, $type='success', $is_multiple=false);
            echo json_encode($returnData);
        }else{
            $msg =  'You don\'t have access this page.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/refundstageone'); 
        }
    }
    
    
    //-----------------------------------------------------------------------
    
    /*
    * @Description: This function is used post two stage for refund
    * @return array 
    *
    */ 
    
    public function refundstagetwopost(){
         
         if($this->input->is_ajax_request()){
             
				 $userId     =  $this->isLoginUser(); # get logged user id
             
                //call refund stage next method allowed  for user
                $this->session->unset_userdata('refundCartId');
                $this->_nextstageallowed('3','refundstage');
                $this->_nextstageallowed(array('1'),'refundsubstage');
                
                //get selection number id
                $selectionNumberId      =  $this->session->userdata('selectionNumberId');
                
                //insert refund cart temp data
             	$selectedContainerList   = $this->model_package->getSelectedContainerList($userId,$selectionNumberId);
             	
             	//total selected container price
             	$totalPaidPrice           =  0;
				if(!empty($selectedContainerList)){ 
					$totalPaidPrice  =  multiarraysum($selectedContainerList,'totalPrice');
				}
                
                //check paid price to memebrhsip amount  while downgrade 
				$isPaypalPost        =  false;
				if($totalPaidPrice > 0){
					$isPaypalPost      =  true;
				}
				
				//pay downgrade package action
				if($isPaypalPost){
					$this->_paydowngradepackage($userId,$totalPaidPrice);
				} 
                
                $msg          = 'Post successfully.';
                $redirecturl  =  '/package/refundbillingdetails';
                $returnData   =  array('msg'=>$msg,'redirecturl'=>$redirecturl);
                echo json_encode($returnData);
         }else{
                $msg =  'You don\'t have access this page.';
                set_global_messages($msg, $type='error', $is_multiple=false);
                redirect('package/refundstageone'); 
         }  
    }
    
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to package refund billing information
     * @return string
     */ 

    public function refundbillingdetails(){
        
        $userId     =  $this->isLoginUser(); # get logged user id
        
        //check package is selected
        $refundstage    =  $this->session->userdata('refundstage'); #main stage array
        $refundsubstage = $this->session->userdata('refundsubstage'); #sub-stage array
        if(!in_array('3',$refundstage) || !in_array('1',$refundsubstage)){  
            $msg =  'You don\'t have access directory.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/refundstageone');
        }
    
        // get ordre billing details if already entered
        $refundCartId                 =   $this->session->userdata('refundCartId');
        $orderBillingDetails    =   $this->_orderBillingDetails($refundCartId);
        
        // if order billing details empty then use  buyer settings tabel
        if(empty($orderBillingDetails)){
            $orderBillingDetails =  $this->model_common->getDataFromTabel('UserBuyerSettings', '*',  array('tdsUid'=>$userId),'','','',1);

            if(!empty($orderBillingDetails)){
                $orderBillingDetails   =  $orderBillingDetails[0];
            }   
        }
        
        //get prepare info data	
        $this->data['userId']                    =  $userId; # set user id 
        $this->data['refundtage']                =  '3'; # set renew stage 
        $this->data['stagesubmenu']              =  '1'; # set renew stage 
        $this->data['orderBillingDetails']          =  $orderBillingDetails; # set buyer setting data 
        $this->data['packagestageheading']       =  $this->_getrefundpackagetitle(); #set package heading

        $this->new_version->load('new_version','package_refund/refund_stage_3_1',$this->data);
    }
    
     //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to renew billing information
     * @return string
     */ 

    public function refundbillingdetailspost(){
        
        if($this->input->is_ajax_request()){
            
            $userId     =  $this->isLoginUser(); # get logged user id
            
            // get country details
            $countryId = $this->input->post('countriesList');	
            $countryName = $this->model_membershipcart->getUserCountryName($countryId);	
            
            $UserBuyerSettings            =   array(
                'tdsUid'                    =>  $userId,
                'billing_firstName'         =>  $this->input->post('firstName'),
                'billing_lastName'          =>  $this->input->post('lastName'),
                'billing_companyName'       =>  $this->input->post('companyName'),
                'billing_address1'          =>  $this->input->post('addressLine1'),
                'billing_address2'          =>  $this->input->post('addressLine2'),
                'billing_city'              =>  $this->input->post('townOrCity'),
                'billing_country'           =>  $this->input->post('countriesList'),
                'billing_state'             =>  $this->input->post('stateList'),
                'billing_zip'               =>  $this->input->post('zipCode'),
                'billing_email'             =>  $this->input->post('email'),
                'billing_phone'             =>  $this->input->post('phoneNumber'),
            );
            
            // store billing details in cart tabel
            $cartId=$this->session->userdata('refundCartId'); 
            $json = array('billingdetails'=>json_encode($UserBuyerSettings));
            $this->model_common->editDataFromTabel('MembershipCart', $json, 'cartId', $cartId);
            
            //call refund stage next method allowed  for user
            $this->_nextstageallowed('2','refundsubstage');
            
            $msg          = 'Post successfully.';
            $redirecturl  =  '/package/refundsummary';
            $returnData   =  array('msg'=>$msg,'redirecturl'=>$redirecturl);
            echo json_encode($returnData);
        }else{
            //error
            $msg = 'error';
            set_global_messages($msg, $type='success', $is_multiple=false);
            $returnData=array('msg'=>$msg);
            echo json_encode($returnData);
        }
    }
    
    //----------------------------------------------------------------------

    /*
     * @access: public
     * @description: This function is used to refund summary list
     * @return string
     */ 

    public function refundsummary(){

        //check refund is selected
        $refundstage    =  $this->session->userdata('refundstage'); #main stage array
        $refundsubstage = $this->session->userdata('refundsubstage'); #sub-stage array
        if(!in_array('3',$refundstage) || !in_array('2',$refundsubstage)){  
            $msg =  'You don\'t have access directory.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/refundstageone');
        }

        //get user id
        $userId     =  $this->isLoginUser(); # get logged user id

        // get buyer order billing details 
        $refundCartId                 =   $this->session->userdata('refundCartId'); 
        $orderBillingDetails  	      =   $this->_orderBillingDetails($refundCartId);
        
        // if order only for refund then get old order billing detail
        if(empty($orderBillingDetails)){
			//get user pacakge details
			$packageDetails 		 =  $this->_usersubscriptiondetails();

			//packge details
			$pkgId               =  $packageDetails->pkgId;
		
			//get user membership details 
			$membershipDetails   =  $this->model_package->getMembershipDetails($userId,$pkgId);
			
			if(!empty($membershipDetails)){
				$orderBillingDetails  	 =  (object) json_decode($membershipDetails['buyerInfo']);
			}
		}
     
	    // get section number
        $selectionNumberId      =  $this->session->userdata('selectionNumberId');

        // get selected container list data
        $selectedContainerList   = $this->model_package->getSelectedContainerList($userId,$selectionNumberId);
       
        /*
        //get renew pacakge type
        $whereSubcrip 		=  array('tdsUid' => $userId);
        $packageDetails     =  $this->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($packageDetails)){
            $packageDetails  =  $packageDetails[0];
        }
        
        $selectedPacakge  =  $packageDetails->subscriptionType;
        $packagePrice = 0;
		if($selectedPacakge == $this->config->item('package_type_2')){
            $packagePrice     = $this->config->item('package_1_year_price');
            $package_title     = $this->config->item('package_title_2');
        } elseif($selectedPacakge == $this->config->item('package_type_3')) {
            $packagePrice     = $this->config->item('package_3_year_price');
            $package_title     = $this->config->item('package_title_3');
        }*/
        //get prepare package info data	
        $this->data['selectedContainerList']     =  $selectedContainerList; # selected container data
        $this->data['userId']                    =  $userId; # set user id 
        $this->data['refundtage']                =  '3'; # set refund stage 
        $this->data['stagesubmenu']              =  '2'; # set refund stage 
        $this->data['orderBillingDetails']       =  $orderBillingDetails; # set buyer setting data 
        $this->data['selectedPacakge']           =  $selectedPacakge; # selected package for join/next button show
        //$this->data['package_title']             =  (isset($package_title))?$package_title:''; # set package title 
        //$this->data['packagePrice']              =  $packagePrice; # set package price 
        $this->data['packagestageheading']       =  $this->_getrefundpackagetitle(); #set package heading
        //$this->data['isRefundButton']            =  TRUE; # set renew button show

        $this->new_version->load('new_version','package_refund/refund_stage_3_2',$this->data);

    }
        
    //-----------------------------------------------------------------------

    /*
    * @Description: This function is used to get section details by section name
    * @return array 
    *
    */ 
    
    public function refundcalculate(){
            
        //get user id
        $userId     =  $this->isLoginUser(); # get logged user id

        // get keep selection number
        $selectionNumberId        =  $this->session->userdata('selectionNumberId');

        // get selected container list data
        $selectedContainerList    =  $this->model_package->getSelectedContainerList($userId,$selectionNumberId);

        $totalPaidPrice           =  0;
        if(!empty($selectedContainerList)){ 
            $totalPaidPrice  =  multiarraysum($selectedContainerList,'totalPrice');
        }
 
        //check paid price to memebrhsip amount  while downgrade 
        $isPaypalPost        =  false;
        if($totalPaidPrice > 0){
            $isPaypalPost      =  true;
        }
        
        //selected container amount is greater than zero "0" then  first post to paypal 
        //then refund
        if($isPaypalPost){
            //call refund post data to paypal for refund paypal payment downgrade 
			Modules::run("membershipcart/payments_pro/refunddowngradepackage");
        }
        
        //selected container amount is zero "0" then directly refund
        if($isPaypalPost===false){
            // refund action do  by paypal
            $this->refundactiondo();
        }
        
    }
    
    //----------------------------------------------------------------------
    
    /*
     *	@Description: This function is use move not selected  container associated project to archive 
     *	@return true
     *  @access: public
     */
    
    public function moveprojecttoarchive(){
        
        // get logged in user id
        $userId     =  $this->isLoginUser();
        
        // get section number
        $selectionNumberId        =  $this->session->userdata('selectionNumberId');
        
        // get all container data
        $allContainerId           =  $this->session->userdata('allContainerId');

        // get selected container list data
        $selectedContainerList  =  $this->model_package->getSelectedContainerList($userId,$selectionNumberId);
        
        if(!empty($allContainerId)){
            foreach($allContainerId as $containerId){
                if(!search_multi_array($containerId, $selectedContainerList)){
                    //move container to archive
                        $this->_projectmovetoarchive($containerId);
                }
            }
        }
    }
    
    //----------------------------------------------------------------------
    
    private function _projectmovetoarchive($containerId){
        
        $whereContainer 				=			array('userContainerId' => $containerId);
        $UserContainerDetails		=			$this->model_common->getDataFromTabel('UserContainer', 'entityId,elementId',  $whereContainer, '', $orderBy='userContainerId', $order='ASC', $limit=1, $offset=0, $resultInArray=true);
        
        if(!empty($UserContainerDetails)){
            
            $UserContainerDetails = 	$UserContainerDetails[0];
            $entityId							= 	$UserContainerDetails['entityId'];
            $projectId					  = 	$UserContainerDetails['elementId'];
            $tableName 						= 	getMasterTableName($entityId);
            $tableName 						= 	$tableName[0];
            $primeryField					=   '';
            switch($tableName){
                
                case 'TDS_Project':
                        $primeryField			= 'projId';
                        $updateData 			=  array('isArchive'=>'t');
                break;
                
                case 'TDS_Events':
                    $primeryField			= 'EventId';
                    $updateData 			=  array('EventArchive'=>'t');
                break;
                
                case 'TDS_LaunchEvent':
                    $primeryField			= 'LaunchEventId';
                    $updateData 			=  array('isArchive'=>'t');
                break;

                case 'TDS_Product':
                    $primeryField			= 'productId';
                    $updateData 			=  array('productArchived'=>'t');
                break;

                case 'TDS_WorkProfile':
                    $primeryField			= 'workProfileId';
                    $updateData 			=  array('isArchive'=>'t');
                break;


                case 'TDS_UpcomingProject':
                    $primeryField	= 'projId';
                    $updateData 			=  array('projArchived'=>'t');
                break;

                case 'TDS_Collaboration':
                    $primeryField	= 'collaborationId';
                    $updateData 			=  array('isArchive'=>'t');
                break;

                case 'TDS_Competition':
                    $primeryField	= 'competitionId';
                    $updateData 			=  array('isArchive'=>'t');
                break;
            }
            
            if(!empty($primeryField)){
                //update data in the database table for project move to archive
                $this->model_common->editDataFromTabel($tableName, $updateData, $primeryField, $projectId);
                $updateUserContainer = array('containerStatus'=>'f');
                $this->model_common->editDataFromTabel('UserContainer', $updateUserContainer, 'userContainerId', $containerId);
            }
        }
    }
    
    //----------------------------------------------------------------------
    
    /*
    * @Description: This function is use to refund paypal payment downgrade 
    * @return object
    */ 
    
    private function _paydowngradepackage($userId,$calculateAmount){
        
        // get default vate percent
        $VatPrice        =  '0';

        //vat calculate
        $vatPercent      =  $this->config->item('package_vat_percent');
        $VatPrice       = (($calculateAmount*$vatPercent)/100);
        
        //calculate total price  = totalPrice+ vatPrice
        //$totalPrice  =  $calculateAmount + $VatPrice;
        $totalPrice  =  $calculateAmount;

        //prepare package insert data
        $inserts = array(
            'totalPrice'        =>  $totalPrice,
            'totalTaxAmt'       =>  $VatPrice,
            'tdsUid'            =>  $userId,
            'orderType'         =>  '4',
        );

        // if package cart create then true true  
        if($this->session->userdata('refundCartId')){
            //return true; 
            $this->session->unset_userdata('refundCartId');
        }

        // insert data in  temp membership cart tabel
        $cartOrderId = $this->model_membershipcart->addData($inserts);

        $this->session->set_userdata('refundCartId',$cartOrderId);

        // prepare membership cart item data
        $memItemInsert['cartId']        =  $cartOrderId;
        $memItemInsert['tsProductId']   =  '0';
        $memItemInsert['price']         =  $totalPrice;
        $memItemInsert['size']          =  mbToBytes($this->config->item('package_membership_default_space'),'gb');
        $memItemInsert['pkgId']         =  '1';
        $memItemInsert['pkgRoleId']     =  '0';
        $memItemInsert['totalPrice']    =  $totalPrice;
        $memItemInsert['taxAmt']        =  $VatPrice;
        $memItemInsert['type']          =  '8'; // payment with downgrade

        // insert data in  temp membership cart item tabel
        $this->model_membershipcart->addDataMem($memItemInsert);
    }
    
    //----------------------------------------------------------------------
    
    /*
    * @access: public
    * @Description: This function is use to refund payment 
    * @return object
    */ 
    
    public function refundactiondo(){
        
        // get loggedIn user id
        $userId     =  $this->isLoginUser(); 
        
        //get user pacakge details
        $packageDetails 		 =  $this->_usersubscriptiondetails();
        
        //packge details
        $pkgId               =  $packageDetails->pkgId;
        $subscriptionType    =  $packageDetails->subscriptionType;
        
        //get user membership details 
        $membershipDetails   =  $this->model_package->getMembershipDetails($userId,$pkgId);

        if($subscriptionType == $this->config->item('package_type_2')){
            $membershipPrice = $this->config->item('package_1_year_price');
        }elseif($subscriptionType == $this->config->item('package_type_3')){
            $membershipPrice = $this->config->item('package_3_year_price');
        }
        
        $sendData           =   array(
            'transactionid' =>  $membershipDetails['ordNumber'],
            'orderId'       =>  $membershipDetails['orderId'],
            'sectionName'   =>  'Membership Refund',
            'totalPrice'    =>  $membershipPrice,
        );
        
        //call refund post data to paypal for refund
        $refundStatus = Modules::run("membershipcart/payments_pro/refundmembership",$sendData);
        
        // if refund success
        if($refundStatus){
            //move not selected  container associated project to archive 
            $this->moveprojecttoarchive();
            
            //move user to free membership 
            $this->usermovetofreemembership($userId);
            
            //call refund stage next method allowed  for user
            $this->_nextstageallowed('3','refundsubstage');

            //redirect to success page
            redirect('package/refundsuccess');
        }else{
            redirect('package/paymenterror');
        } 
    }
    
    //----------------------------------------------------------------------
    
    /*
    * @Description: This function is use to get user selected subscription package details
    * @return object
    */ 
    
    private function _usersubscriptiondetails(){
        $userId     =  isLoginUser(); # get logged user id
        $whereSubcrip     =  array('tdsUid' => $userId);
        $packageDetails   =  $this->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
        if(!empty($packageDetails)){
            $packageDetails  =  $packageDetails[0];
        }
        return $packageDetails;
    }
     
    //----------------------------------------------------------------------

    /*
    * @Description: This function is use move user to free membership
    * return false 
    */ 
     
     public function usermovetofreemembership($userId){
            
        $userSubscriptionData['startDate']        =  NULL;
        $userSubscriptionData['endDate']          =  NULL;
        $userSubscriptionData['packageSpace']     =  NULL;
        $userSubscriptionData['subscriptionType'] =  $this->config->item('package_type_1');
        $userSubscriptionData['pkgId']            =  $this->config->item('package_free_id');
        $userSubscriptionData['modifiedDate']     =   currntDateTime();
        $this->model_common->editDataFromTabel('UserSubscription', $userSubscriptionData, 'tdsUid', $userId);

        // insert user default container while move to free user
        $uc = new lib_userContainer();
        $uc->assignFreePackageToUaser($userId,$this->config->item('package_type_1'));
        
        //call method for temp delete data from refund selection temp table
        $this->_deletetempselection();
     }
     
    //----------------------------------------------------------------------
    
    /*
    * @Description: This function is use delete temp selection cotainer for keep 
    * afted success
    * return false 
    */ 
    
    private function _deletetempselection(){
        $selectionNumberId        =  $this->session->userdata('selectionNumberId');
        // refund selection data delete by selection number id
        $this->model_common->deleteRowFromTabel('refundSelectionTemp','selectionNumber',$selectionNumberId);
    }
            
    //----------------------------------------------------------------------

    /*
    * @Description: This method is used to renew success message
    * @return void
    */ 

    public function refundsuccess(){

        //check refund is selected
        /*$refundstage    =  $this->session->userdata('refundstage'); #main stage array
        $refundsubstage = $this->session->userdata('refundsubstage'); #sub-stage array
        if(!in_array('3',$refundstage) || !in_array('3',$refundsubstage)){  
            $msg =  'You don\'t have access directory.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            redirect('package/refundstageone');
        }*/

        // get logged in user Id
        $userId     =  $this->isLoginUser(); 

        //get prepare package info data	
        $this->data['userId']                    =  $userId;
        $this->data['refundtage']                =  '3'; # set refund stage 
        $this->data['stagesubmenu']              =  '3'; # set refund stage 
        $this->data['selectedPacakge']           =  $selectedPacakge; # selected package for join/next button show
        $this->data['packagestageheading']       =  $this->_getrefundpackagetitle(); #set package heading
        
        // get downgrade status
        $isDowngradePackage = $this->session->userdata('isDegradePackage');
        
        if($isDowngradePackage){
            $this->new_version->load('new_version','package_refund/refund_stage_3_3_downgrade_success',$this->data);
        }else{   
            $this->new_version->load('new_version','package_refund/refund_stage_3_3_refund_success',$this->data);
        }
    } 
    
    //----------------------------------------------------------------------
    
    public function packageinformationold(){
        $pkg = new lib_package();
        $this->data['packages']=$pkg->packageInformation();
        $this->template_front_end->load('template_front_end','package/package_information_frontend',$this->data);
    }
    
    //----------------------------------------------------------------------

    /*
    * @Description: This function is use to show all tool listing for tool buy
    * @return: void
    */  

    public function buytools(){
        $this->userId = $this->isLoginUser();
        $prod = new lib_udtsProduct();
        $this->data['packages']=$prod->productListing();
        //Load right side help view
        $leftData=array(
        'welcomelink'=>base_url(lang().'/dashboard'),
        'isDashButton'=>true,
        );
        $leftView='dashboard/help_package';
        $this->data['leftContent'] = $this->load->view($leftView,$leftData,true);
        $this->template->load('backend_template','package/product_listing',$this->data);
    }

    //----------------------------------------------------------------------

    /*
    * @Description: This function is use to show list of purchased tool and membership 
    * listing
    * @return: void
    */ 
    
    public function purchases($limit=0,$perPage=10){
        $userId=$this->isloginUser();

        $countTotal=$this->model_package->get_purchased_details($userId,0,0,true);

        $pages = new Pagination_ajax;
        $pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
        //$pages->items_per_page=$perPage;

        // Add by Amit to set cookie for Results per page
        if($this->input->post('ipp')!=''){
            $isCookie = setPerPageCookie('purchasePerPageVal',$perPage);	
        }else {
            $isCookie = getPerPageCookie('purchasePerPageVal',$perPage);		
        }

        $pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;		

        $pages->paginate();
        $data['items_total'] = $pages->items_total;
        $data['items_per_page'] = $pages->items_per_page;
        $data['pagination_links'] = $pages->display_pages();	
        $data['countTotal'] = $countTotal;	

        $getPurchaseDetails = $this->model_package->get_purchased_details($userId,$limit,$pages->items_per_page);

        $data['purchaseDetails'] = $getPurchaseDetails;
        //Load right side help view
        $leftData=array(
        'welcomelink'=>base_url(lang().'/dashboard'),
        'isDashButton'=>true,
        );
        $leftView='dashboard/help_package';
        $data['leftContent'] = $this->load->view($leftView,$leftData,true);
        $ajaxRequest = $this->input->post('ajaxRequest');
        if($ajaxRequest)
        {   
            $this->load->view('purchase_frame',$data) ;				
        }else{
            $this->template->load('backend_template','purchase_list',$data);
        }
    }

    //----------------------------------------------------------------------

    /*
    * @Description: This function is use to export purchased tool and membership 
    * record into csv of logged in user id
    * @return: void
    */ 

    function purchasedexporttocsv()
    {
        $this->load->helper('csv');
        $this->load->helper('inflector');
        $userId=$this->isloginUser();

        // get purchased data of package and container
        $getPurchaseDetails=$this->model_package->export_purchased_details($userId);

        $RowArray="";
        $count=0;
        foreach($getPurchaseDetails['get_first_row']  as $rowOfHeader)
        {
            $RowArray[0][$count] =  humanize($rowOfHeader); 
            $count++;
        }
        $RowArray[0][10] =  humanize('seller'); 
        // This code for  listing of record
        if($getPurchaseDetails['get_num_rows'] > 0)
        {
            $serialNumber=1;	
            $count=1;
            foreach($getPurchaseDetails['get_result']  as $resultPurchase)
            {
                $purchaseType =  membershipitemtitle($resultPurchase['type']);
                $RowArray[$count][0] = date("d-F-Y",strtotime($resultPurchase['date']));
                $RowArray[$count][1] = getInvoiceId($resultPurchase['invoice'],1);
                $RowArray[$count][2] = $resultPurchase['paypalEmail'];
                $RowArray[$count][3] = $resultPurchase['title'];
                $RowArray[$count][4] = bytestoMB($resultPurchase['size'] + getItemSize($resultPurchase['memItemId'])).' MB';
                $RowArray[$count][5] = $purchaseType;
                $RowArray[$count][6] = $resultPurchase['basePrice'];
                $RowArray[$count][7] = $resultPurchase['taxValue'];
                $RowArray[$count][8] = $resultPurchase['taxPercent'];
                $RowArray[$count][9] = $resultPurchase['totalPrice'];
                $RowArray[$count][10] = 'Toadsquare';
                $count++;
            }
        }
        $filename="purchase_".date("d_M_Y").".csv";
        array_to_csv($RowArray, $filename);
    }

    //----------------------------------------------------------------------

    /*
    * @Description: This function is use to export purchased tool and membership 
    * record into csv of logged in user id
    * @return: void
    */ 

    function allmembershipexporttocsv()
    {
        $this->load->helper('csv');
        $this->load->helper('inflector');
        $userId=$this->isloginUser();
        $getPurchaseDetails=$this->model_package->all_export_purchased_details();
        $RowArray="";
        $count=0;
        foreach($getPurchaseDetails['get_first_row']  as $rowOfHeader)
        {
            $RowArray[0][$count] =  humanize($rowOfHeader); 
            $count++;
        }
        $RowArray[0][10] =  humanize('seller'); 
        // This code for  listing of record
        if($getPurchaseDetails['get_num_rows'] > 0)
        {
            $serialNumber=1;	
            $count=1;
            foreach($getPurchaseDetails['get_result']  as $resultPurchase)
            {
                $RowArray[$count][0] = date("d-F-Y",strtotime($resultPurchase['date']));
                $RowArray[$count][1] = $resultPurchase['invoice'];
                $RowArray[$count][2] = $resultPurchase['customername'];
                $RowArray[$count][3] = $resultPurchase['paypalEmail'];
                $RowArray[$count][4] = $resultPurchase['title'];
                $RowArray[$count][5] = bytestoMB($resultPurchase['size'] + getItemSize($resultPurchase['memItemId'])).' MB';
                $RowArray[$count][6] = ($resultPurchase['type']=="1")?"Tool":"Space";
                $RowArray[$count][7] = $resultPurchase['totalPrice'];
                $RowArray[$count][8] = $resultPurchase['taxPercent'];
                $RowArray[$count][9] = $resultPurchase['taxValue'];
                $RowArray[$count][10] = 'Toadsquare';
                $count++;
            }
        }
        $filename="purchase_".date("d_M_Y").".csv";
        array_to_csv($RowArray, $filename);
    }

    //----------------------------------------------------------------------

    /*
    * @Description: This function is use to show available container listing
    * @return: void
    */ 

    function getAvailableUserContainer(){
        $this->userId             =  $this->isLoginUser();
        $this->data['sectionId']  =  $sectionId=$this->input->post('val1');
        $this->data['retunUrl']   =  $retunUrl=$this->input->post('val2');
        $this->data['isNotPopup'] =  $isNotPopup=$this->input->post('val3');
        $uc = new lib_userContainer();
        if($sectionId=='16:1'){
            $tsProduct=$this->model_common->getDataFromTabel('MasterTsProduct', 'tsProductId',  array('allowedSections'=>'{16:1}'), '', '', '',1);
            if($tsProduct){
                $tsProductId=$tsProduct[0]->tsProductId;
                $uc->checkPackageAssign($this->userId,$tsProductId);
            }
        }
        $this->data['userContainers']=$uc->getAvailableUserContainer($this->userId,$sectionId);
        $this->data['isContainerFree']=$uc->isContainerFree($sectionId);
        if($this->data['isContainerFree']){
            $this->load->view('user_freepackages',$this->data);
        }else{
            $this->load->view('user_packages',$this->data);
        }
    }

    //----------------------------------------------------------------------

    /*
    * @Description: This function is use to show no enough space check
    * @return: void
    */ 

    public function notEnoughSpace(){
        $userContainerId         =  ($this->input->post('val1')!='') ? $this->input->post('val1') :0;			
        $data['userContainerId'] =  $userContainerId;		
        $this->load->view('package/not_enough_space',$data);
    }
    
    //----------------------------------------------------------------------

     /**
    * Downgrade membership subscription 
    * @access public
    */
    
    public function degradepackage($degradeType) {
        if(!empty($degradeType) && ($degradeType == 1 || $degradeType == 2)) {
            /* set package degrade session value */
            $this->session->set_userdata('isDegradePackage',1);
            if($degradeType == 1) {
                /* manage refund for free type */
                $this->refundstageone();
            } else {
                /* get users subscription day difference */
                $dayDifference = getSubscriptionDayDiff();
                $degradeAfterDay = preg_replace("/[^0-9]/", '',$this->config->item('downgrade_button_after_day'));
                /* manage refund for 1 year subscription */
                if(!empty($dayDifference) && $dayDifference <= $degradeAfterDay) {
                    $this->renewstagetwo();
                } else {
                    $this->renewstageone();
                }
            }
        }else {
            /* set error msg */
            $msg =  'Please select degrade package.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            /* redirect to package information page */
            redirect('package');
        }
    }
    
    //----------------------------------------------------------------------
    
     /**
    * Manage downgrade data store from 3 to 1 year 
        * @access private
        */
        private function _managedegradethreetoone($userId) {
        
        //get user subscription id
        $whereSubcrip 	  =  array('tdsUid' => $userId);
        $subDetails   =  $this->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);

        if(!empty($subDetails)){
            $subDetails  =  $subDetails[0];
        }
        
        if(isset($subDetails->subId)) {
            
            //add membership order data for degrade
            //$this->_adddegradeorder();
            
            //set next year date
            $expiryDate = date('Y-m-d h:i:g', strtotime("+12 months ".$subDetails->endDate));
            
            //prepare package update data
            $subscriptionData     =   array(
                'startDate'       =>  currntDateTime(),
                'endDate'         =>  $expiryDate,
                'modifiedDate'    =>  currntDateTime(),
                //'packageSpace'  =>  mbToBytes($this->config->item('package_membership_default_space'),'gb'),
                'pkgId'			  =>  $this->config->item('package_1_year_id'),
                'subscriptionType'=>  $this->config->item('package_type_2'),
            );
            
            //update user subscription data for 1 year
            $effectSubId = $this->model_package->updateusersubscription($subDetails->subId,$subscriptionData);
            if(isset($effectSubId)) {
                /* unset degrade session id */
                $this->session->unset_userdata('isDegradePackage');
            }
        }
    }
    
    //----------------------------------------------------------------------
    
     /**
    * Add membership order data for degrade package
    * @access private
    */
    private function _adddegradeorder() {
        /* get users subscription day difference */
        $dayDifference = getSubscriptionDayDiff();
        $degradeAfterDay = preg_replace("/[^0-9]/", '',$this->config->item('downgrade_button_after_day'));

        if($dayDifference <= $degradeAfterDay) {
            $userId = $this->isLoginUser();
            $membershipPrice = $this->config->item('package_3_year_price');
            $vatPercent      =  $this->config->item('package_vat_percent');
            $VatPrice        = (($membershipPrice*$vatPercent)/100);

            $resultUserName = getDataFromTabel('UserProfile','firstName,lastName',  'tdsUid', $userId,'', 'ASC', $limit=1 );
            $userEmail = getDataFromTabel('UserAuth','email',  'tdsUid', $userId,'', 'ASC', $limit=1 );
            if($resultUserName)
                $userInfo = $resultUserName[0];

            $userEmail = ($userEmail[0]->email!='') ? $userEmail[0]->email:'';

            $custName=$userInfo->firstName.' '.$userInfo->lastName;	

            /*************get userinfo *************/

            $billingDetail = $this->model_membershipcart->getBillingDetails($userId);

            if(isset($billingDetail->billingdetails) && $billingDetail->billingdetails!=''){
                $billingdetails = json_decode($billingDetail->billingdetails);
            }else {	  
                $billingdetails =  $this->model_membershipcart->getUserBillingDetails($userId);
            }
            $billingdetails = json_encode($billingdetails);
            
             /*************get userinfo *************/
            
            //prepare package update data
            $orderData          =   array(
            'cartId'        =>  0,
            'grandTotal'    =>  number_format($this->config->item('package_3_year_price'),2),
            'totalTaxAmt'   =>  $VatPrice,
            'TotalPrice'    =>  number_format($this->config->item('package_3_year_price'),2),
            'paymentStatus'	=>  '1',
            'tdsUid'        =>  $userId,
            'totalPaid'     =>  number_format($this->config->item('package_3_year_price'),2),
            'custName'      =>  $custName,
            'custPhone'     =>  '',
            'custEmail'     =>  $userEmail,
            'buyerInfo'     =>  $billingdetails,
            'taxPercent'    =>  $vatPercent,
            'taxValue'      =>  $VatPrice,
            'orderType'     =>  $this->config->item('membership_order_type_4'),
            );
                
            /* add refund degrade data in membership order */
            $this->model_membershipcart->addOrderData($orderData);
        } 
    }
    
    //---------------------------------------------------------------------
    
    /*
     * @Description: This function is use to show membership invoice list
     * @return: void
     * 
     */ 
    
    public function membershipinvoices(){
        
        $userId     =  isLoginUser(); # get user id
        
        // get purchase membership invoice list 
        $purchasedList =$this->model_package->get_purchased_details($userId,0,0);
     
        //get prepare package info data	
        $this->data['userId']                    =  $userId;
        $this->data['purchasedList']             =  $purchasedList;
        $this->data['packagestageheading']       =  'Membership Invoices'; #set package heading

        $this->new_version->load('new_version','membership_invoices',$this->data);
        
    }
    
    //----------------------------------------------------------------------
    
    /**
    * Store membership cart data for degrade package 
    * @access private
    */
    private function _managedegradecartdata() {

        /* get users default billing data */
        $billingData =  getUserBillingDetails();

        $userId = $this->isLoginUser();
        $membershipPrice = $this->config->item('package_3_year_price');
        $vatPercent      =  $this->config->item('package_vat_percent');
        $vatPrice        = (($membershipPrice*$vatPercent)/100);
        $totalPrice      = number_format($this->config->item('package_3_year_price'),2) + $vatPrice;
        $packageSpace    = getPackageExtraSpace($userId); 
        //prepare cart data
        $cartData        =   array(
        'totalPrice'     =>  $totalPrice,
        'totalTaxAmt'    =>  $vatPrice,
        'billingdetails' =>  $billingData,
        'tdsUid'         =>  $userId,
        );
            
        /* add degrade package data in cart */
        $cartId = $this->model_membershipcart->addData($cartData);
        $cartItemId = 0;
        if(!empty($cartId)) {
            //prepare cart item data
            $cartItemData   =   array(
            'cartId'        =>  $cartId,
            'price'         =>  $membershipPrice,
            'taxAmt'        =>  $vatPrice, 
            'totalPrice'    =>  $totalPrice,
            'size'	        =>  mbToBytes($this->config->item('package_membership_default_space'),'gb'),
            'type'          =>  $this->config->item('membership_item_type_7'),
            'pkgId'         =>  $this->config->item('package_3_year_id')
            );
                
            /* add degrade cart item data */
            $cartItemId = $this->model_membershipcart->addDataMem($cartItemData);
        }
        return $cartItemId;
    }
    
    //----------------------------------------------------------------------
    
     /**
        * Upgrade users subscription package   
        * @access public
        */
        public function upgradepackage($selectedPacakge) {
        
        
        /* set subscription package session value */
        if($selectedPacakge ==  $this->config->item('package_type_2')) {
            $this->session->set_userdata('selectedPacakge',$selectedPacakge);	
        } elseif ($selectedPacakge ==  $this->config->item('package_type_3')) {
            $this->session->set_userdata('selectedPacakge',$selectedPacakge);
        } else {
            $selectedPacakge = 0;
        }
        /* manage upgration next sept */
        if( $selectedPacakge != 0 ) {
            /* call stage next method allowed  for user */
            $this->_nextstageallowed(array('1'),'packagestage');
            $this->_nextstageallowed('2','packagestage');
            /* forward to next step */
            $this->packagestagetwo();
            /* set package upgrade session value */
            $this->session->set_userdata('isUpgradePackage',1);
        } else {
            /* set error msg */
            $msg =  'Please select upgrade package.';
            set_global_messages($msg, $type='error', $is_multiple=false);
            /* redirect to package information page */
            redirect('package');
        }
    }
    
    //----------------------------------------------------------------------
    
    /**
    * Get page heading of join or upgrade 
    * @access private
    */
    private function _getpackageheadertitle() {
        
        // if user logged in then he is upgrading the membership
        if(isLoginUser()){
            /* set package upgrade session value */
            $this->session->set_userdata('isUpgradePackage',1);
        }
        
        /* set heading of join */
        $pageHeader = $this->lang->line('pack_stage_heading_2');
        /* get upgrade session value */
        $isUpgradePackage =  $this->session->userdata('isUpgradePackage');
        if(!empty( $isUpgradePackage)) {
        /* set heading of upgrade */
        $pageHeader = $this->lang->line('pack_updrade_heading_1');
        }
        return $pageHeader;
    }
    
    //----------------------------------------------------------------------
    
    /**
    * Get page heading of renew or downgrade    
    * @access private
    */
    private function _getrenewpackagetitle() {
        //get degrade session value if exist
        $isDowngradePackage = $this->session->userdata('isDegradePackage');

        if(!empty($isDowngradePackage)) { 
            $packageHeading = $this->lang->line('pack_degrade_heading_1'); #set renew package heading
        } else {
            $packageHeading = $this->lang->line('pack_renew_heading_1'); #set degrade package heading
        }
        return $packageHeading;
    }
    
    //----------------------------------------------------------------------

    /**
    * Get page heading of refund or downgrade    
    * @access private
    */
    private function _getrefundpackagetitle() {
        //get degrade session value if exist
        $isDowngradePackage = $this->session->userdata('isDegradePackage');

        if(!empty($isDowngradePackage)) { 
            $packageHeading = $this->lang->line('pack_degrade_free_heading_1'); #set renew package heading
        } else {
            $packageHeading = $this->lang->line('pack_refund_heading_1'); #set degrade package heading
        }
        return $packageHeading;
    }
    
	//----------------------------------------------------------------------

    /**
    * Check promotional code   
    * @access public
    */
    public function promocodeavailcheck() {
		if($this->input->is_ajax_request()) { 
			// get user id 
			$userId   =  $this->session->userdata('joinedUserId'); 
            //get selected package id
            $selectedPacakge  =  $this->session->userdata('selectedPacakge');
            // get new membership titem type
            $itemType = $this->config->item('membership_item_type_4');

			if($this->_promocodeuse($userId,$selectedPacakge,$itemType)){
				$errorMessage   =  $this->lang->line('packstage_promocode_success'); // set availabel email error message
				$errorStatus    =  true; // set email avaialble status
			}else{
                $errorMessage   =  $this->lang->line('packstage_promocode_error'); // set availabel email message
                $errorStatus    =  false; // set email avaialble status
			}
             echo json_encode(array('errorMessage'=>$errorMessage,'errorStatus'=>$errorStatus));
        }else{
            $errorMessage = "Invalid request.";
            $errorStatus  =  true;
            echo json_encode(array('errorMessage'=>$errorMessage,'errorStatus'=>$errorStatus));
        }
	}
    
    
}



    /* End of file package.php */
    /* Location: /application/modules/pacakge/controller/package.php */
