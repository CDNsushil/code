<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @description: This controller is use to manage short link 
 * @last modified: 5-Nov-2014
 * @auther: lokendra 
 */ 

class Shortlink extends MX_Controller {
    
    
    /**
    * constructor define 
    */ 
     
    public function __construct() {
        parent::__construct();
        $this->load->model('url_model'); // load url model
    }
    
    //---------------------------------------------------------------------
    
    /*
    *  @description: This method is use to  short link button
    */ 
    
    function shortlinkButton($data){						

        $this->load->view('short_link',$data);
    } 
    
    //---------------------------------------------------------------------
    
    /*
    * Function to load short link view for frontend sections
    */
    
    public function shortlinkFrontButton($data){						

        $this->load->view('short_link_frontend',$data);
    } 
    
    //---------------------------------------------------------------------
    
    /*
    * This method is use to create short  link 
    */

    public function create_short_url()	{ 			
        //We generate a random string, based our our settings
        $short = random_string('alnum', 8);

        while($this->url_model->is_url_unique($short) == FALSE){
            $short = random_string('alnum', 8);
        }

        return $short;
    }  
    
    //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to addShortLink
    */ 
    
    public function addShortLink() {

        $longurl= $this->input->post('url'); 
        $url = urldecode($longurl);
        //We generate the short version
        $short = $this->create_short_url();
        //Grab the owners IP address
        $user_ip = $_SERVER['REMOTE_ADDR'];
        //Check to see if a user is logged in
        $userId = isLoginUser();
        if($userId != FALSE){  
            $user_id = $userId;
        } else { 
            $user_id = 0;
        }

        if(isset($url) && $url!='') {
            $this->url_model->addShortLink($short, $url,$user_ip, $user_id);

            $shortlink = base_url(lang().'/?url='.$short);
            $data = array('shortlink'=>$shortlink);
            echo json_encode($data);
        }

        return true;       
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to showlink
    */ 

    public function showlink($short) {        
        $full = $this->url_model->get_full_url($short);				   
        redirect($full->url);			
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to shortlinkPopup 
    */ 

    function shortlinkPopup() {				
        $url = $this->input->get('val1');
        $txtId = $this->input->get('val2');	
                
        $data['shareLink'] = $url;
        $data['id'] = $txtId;	
        $this->load->view('shortlink_popup',$data);
    } 
    
    //---------------------------------------------------------------------
   
    /*
    * @description: This method is use to workProfileShortLink 
    */ 
            
    public function workProfileShortLink() {
        $userId = isLoginUser();     
        $this->load->model('tmail/model_tmail');
        $currentRecordId = $this->model_tmail->insert_work_request($userId,$receiverId='0'); 
        $currentRecordId = encode($currentRecordId); 
        $longurl= $this->input->post('url'); 
        $url = urldecode($longurl.'/'.$currentRecordId);
        //We generate the short version
        $short = $this->create_short_url();
        //Grab the owners IP address
        $user_ip = $_SERVER['REMOTE_ADDR'];
        //Check to see if a user is logged in
        
        if($userId != FALSE){
                $user_id = $userId;
            } else {
                $user_id = 0;
              }
        
                if(isset($url) && $url!='') {
                      $this->url_model->addShortLink($short, $url,$user_ip, $user_id);
                        
                      $shortlink = base_url(lang().'/?url='.$short);
                      $data = array('shortlink'=>$shortlink);
                      echo json_encode($data);
                }
        
        return true;
    }
    
    //---------------------------------------------------------------------
   
    /*
    * @description: This method is use to test 
    */ 
    
    public function test() {

        $data2 = array('shortlink'=>'BcHRCcAgDAXAXVzgUSkU7DSmNbE/QSMKcfrecbpiClPkSYBTU5/EAiHt/FYtBsvY1peOQlksd7BpabMYVxfEAyfG8v2tbhTuHw==');       
        echo json_encode($data2);	
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to shortlinkFrontPopup 
    */ 
    function shortlinkFrontPopup() {				

        $url = $this->input->get('val1');
        $txtId = $this->input->get('val2');	

        $data['shareLink'] = $url;
        $data['id'] = $txtId;	

        $this->load->view('shortlink_frontend_popup',$data);			
    }
    
    //----------------------------------------------------------------------
    
    /*
     * @access: public
     * @description: This method is use to get short link for frontend
     * @auther: lokendra meena
     * @return: string
     */ 
    
    public function frentendshortlink(){
        $short = $this->create_short_url();
        $shortlink = base_url(lang().'/?url='.$short);
        return $shortlink;
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @descrioptin: This methos is use to show frentend shortlink button for 
    * create short link
    * @auther: lokendra meena
    * @return: void
    */
    
    public function shortlinkfrontbuttonnew($loadData){
    
        $this->load->view('short_link_frontend_new',$loadData);
    } 
    
    //---------------------------------------------------------------------
    
   /*
    * @access: public
    * @descrioptin: This methos is use to get created short link
    * @auther: lokendra meena
    * @return: void
    */ 
    
    public function getshortlink() {

        $longurl    = $this->input->post('url'); // get post url
        $url        = urldecode($longurl); // decode post url
       
        // get short link
        $shortlink = getShortLink($url);
       
        if(isset($url) && $url!='') {
            $data = array('shortlink'=>$shortlink);
            echo json_encode($data);
        }
        return true;       
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to shortlinkFrontPopupNew 
    */ 
    function shortlinkfrontpopupnew() {				

        $shareLink          =   $this->input->get('val1'); // short link get
        $data['shareLink']  = $shareLink;
        $this->load->view('shortlink_frontend_popup_new',$data);			
    }
    
 } //endclass 		