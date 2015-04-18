<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Todasquare blog Controller Class
 *
 *  Manage Share Functionality
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */

Class share extends MX_Controller {
    
    /**
     * Constructor
     */
    function __construct(){
      $this->load->helper('url');
        parent::__construct(); 		
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to share button show
    */ 
    
    function shareButton($url,$shareClass='',$viewType='',$isPublished='',$isPreview='')
    {
        $show['url'] = $url;
        
        if($shareClass!='')
        $show['shareClass'] = $shareClass;
        
        if($viewType!='')
        $show['viewType'] = $viewType;
        
        if($isPublished!='')
        $show['isPublished'] = $isPublished;
        
        if($isPreview)
        $show['isPreview'] = $isPreview;
        
        $this->load->view('share_button',$show);				
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to socialShare
    */
    
    function socialShare()
    {	
        $isAjaxHit = $this->input->get('ajaxHit');
        $url = $this->input->get('UrlToShare');	
        //$UrlToShare['UrlToShare'] = decode($url);
        
        $UrlToShare['UrlToShare'] = $url;
        
        if($isAjaxHit)
            $this->load->view('social_share',$UrlToShare);
        else
            $this->template->load('template','social_share',$UrlToShare);
                
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to shareEmail
    */
    
    function shareEmail()
    {	
        $isAjaxHit = $this->input->get('ajaxHit');
        $url = $this->input->get('UrlToShare');	
        //$UrlToShare['UrlToShare'] = decode($url);
        
        $UrlToShare['UrlToShare'] = $url;
        
        if($isAjaxHit)
            $this->load->view('email_join_popup',$UrlToShare);
        else
            $this->template->load('template','email_popup',$UrlToShare);
                
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to show share social media list  view
    * @param: array
    * @return: string
    * @auther: lokendra meena
    * @date: 5-nov-2014
    */ 
    
    public function sharesocialshowview($shareData){
    
        $shortlink          =  getShortLink($shareData['url']);
        $isPublished        =  $shareData['isPublished'];
        $shareDesignType    =  (!empty($shareData['designType']))?$shareData['designType']:1;

        //set load data array
        $loadData['UrlToShare']         =    $shareData;    
        $loadData['isPublished']        =    $isPublished;    
        $this->load->view('share_view/share_list_design_'.$shareDesignType,$loadData);
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to show share email button show 
    * @param: string
    * @return: string
    * @auther: lokendra meena
    * @date: 5-nov-2014
    */ 
    
    public function shareemailbutton($loadData){
        $this->load->view('email_view/email_share_button_new',$loadData);
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
    * @description: This method is use to show share email popup open
    * @param: string
    * @return: string
    * @auther: lokendra meena
    * @date: 5-nov-2014
    */ 
    
    public function shareemailpupupnew(){
        $url = $this->input->get('UrlToShare');	
        $UrlToShare['UrlToShare'] = $url;
        $this->load->view('email_view/email_social_list_design_1',$UrlToShare);
    }
    
     //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to show share email button show 
    * @param: string
    * @return: string
    * @auther: lokendra meena
    * @date: 5-nov-2014
    */ 
    
    public function sharesocialbutton($loadData){
        
        $designType = (!empty($loadData['designType']))?$loadData['designType']:'1';
        
        switch($designType){
            case '1':
                $this->load->view('share_view/share_social_button',$loadData);
            break;
            
            case '2':
                $this->load->view('share_view/share_social_button_1',$loadData);
            break;
            
            default:
            $this->load->view('share_view/share_social_button',$loadData);
        }
    }
    
     //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to show share email popup open
    * @param: string
    * @return: string
    * @auther: lokendra meena
    * @date: 5-nov-2014
    */ 
    
    public function sharesocialpupupnew(){
        $url = $this->input->get('UrlToShare');	
        $UrlToShare['UrlToShare'] = $url;
        $this->load->view('share_view/share_popup_list_design_1',$UrlToShare);
    }
    
      //---------------------------------------------------------------------
    
    /*
    * @description: This method is use to show share social media list  view
    * @param: array
    * @return: string
    * @auther: tosif qureshi
    * @date: 09-march-2015
    */ 
    
    public function sharesocialjoinbutton() {
    
        $sharelink          =  base_url(lang());
        //set load data array
        $loadData['UrlToShare']         =    $sharelink;  
        $this->load->view('share_view/share_list_design_5',$loadData);
    }
    
}
