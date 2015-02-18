<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//class Welcome extends CI_Controller {
class rating extends MX_Controller {
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
			$this->userId= isLoginUser()?isLoginUser():0;
	}
	
	public function index(){
		$this->ratingForm();
	}
	
	public function ratingForm($elementId=0,$entityId=0,$view='ratingForm',$loadView=false) {
		$data['elementId']=$elementId;
		$data['entityId']=$entityId;
		$view=$this->load->view($view,$data,$loadView);
		if($loadView){
			return $view;
		}
	}
	public function postRating($elementId=0,$entityId=0) {
		$ratingDone=false;                     
		$userId=isloginUser();
		$msg=$this->lang->line('sessionExpired');
		$ratingAvg=0;
		
		if($userId > 0){
			$data=$this->input->post('val1');
			if($data['elementId'] > 0 && $data['entityId'] >0){
				$inserdata=array(
					'tdsUid'=>$userId,
					'entityId'=>$data['entityId'],
					'elementId'=>$data['elementId'],
					'ratingValue'=>$data['ratingValue'],
					'createDate'=>currntDateTime()
					
				);
				
				$this->model_common->addDataIntoTabel('LogRating', $inserdata);
				
				$where=array(
					'entityId'=>$data['entityId'],
					'elementId'=>$data['elementId']
				);
				$res=$this->model_common->getDataFromTabel('LogSummary', 'actId,ratingAvg,ratingCount,ratingValue',  $where, '', $orderBy='', '', 1 );
				if($res){
					$res=$res[0];
					$actId=$res->actId;
					$ratingCount=($res->ratingCount+1);
					$ratingValue=($res->ratingValue+$data['ratingValue']);
					$ratingAvg=($ratingValue/$ratingCount);
					
					$updateData=array(
					'ratingCount'=>$ratingCount,
					'ratingValue'=>$ratingValue,
					'ratingAvg'=>$ratingAvg
					);
					$this->model_common->editDataFromTabel($table='LogSummary', $updateData, 'actId', $actId);
				}else{
					
					$ratingCount=1;
					$ratingValue=$data['ratingValue'];
					$ratingAvg=$data['ratingValue'];
					
					$insertData=array(
						'entityId'=>$data['entityId'],
						'elementId'=>$data['elementId'],
						'ratingCount'=>$ratingCount,
						'ratingValue'=>$ratingValue,
						'ratingAvg'=>$ratingAvg,
						'createDate'=>currntDateTime()
					);
					
					$this->model_common->addDataIntoTabel($table='LogSummary', $insertData);
					
				}
				$ratingDone=true;
				$msg=$this->lang->line('ratedSuccessfully');
			}
		}
		echo json_encode(array('ratingDone'=>$ratingDone,'ratingAvg'=>$ratingAvg,'msg'=>$msg));
	}
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to show rating button
    * @param: array
    * @return: void
    * @auther: lokendra meena
    */ 
    
    public  function  ratingbutton($ratingButtonData){
        
        $buttonDesigntype = (!empty($ratingButtonData['buttonDesigntype']))?$ratingButtonData['buttonDesigntype']:'1';
        
        switch($buttonDesigntype){
        
            case "1":
                $this->load->view('rating/rating_button_design',$ratingButtonData);
            break;
            
            case "2":
                $this->load->view('rating/rating_button_design_2',$ratingButtonData);
            break;
        
        }
    } 
    
    //---------------------------------------------------------------------
    
    /*
    *
    * @access: public
    * @description: This method is use to action for rating
    * @return: string
    * @auther: lokendra 
    */
    
    public function ratingaction(){
        
        $entityId       =    $this->input->post('entityId');
        $elementId      =    $this->input->post('elementId');
        $loggedUserId   =    isloginUser();
        $isUserLoggedIn =    (isloginUser())?true:false;
        
        $where=array(
            'tdsUid'    =>  $loggedUserId,
            'entityId'  =>  $entityId,
            'elementId' =>  $elementId
        );

        // check already rated 
        $countResult            =   countResult('LogRating',$where);
        $isRated                =   false;
        $alreadyRatedMessage    = null;
        if($countResult > 0){
            $isRated                =   true;
            $alreadyRatedMessage    =   $this->lang->line('alreadyRate');
        }
        
        $ratingArray = array(
            'isUserLoggedIn'            =>  $isUserLoggedIn,
            'isRated'                   =>  $isRated,
            'alreadyRatedMessage'       =>  $alreadyRatedMessage,
        );
        
        echo json_encode($ratingArray);
    }  
    
    //---------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to open rating popup open
    * @return: string
    * @auther: lokendra meena
    */
    
    public function ratingpopupopen(){
        
        $entityId       =    $this->input->get('val1');
        $elementId      =    $this->input->get('val2');
        $ratingLoadData['imgPath']      =   base_url().$this->config->item('template_new_images');
        $ratingLoadData['entityId']     =   $entityId;
        $ratingLoadData['elementId']    =   $elementId;
        $this->load->view('rating/rating_form_design',$ratingLoadData);
    }
    
}
