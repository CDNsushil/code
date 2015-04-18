<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//class Welcome extends CI_Controller {
class Creativeinvolved extends MX_Controller {
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
			//$this->userId= $this->isLoginUser();
			$this->userId= isLoginUser()?isLoginUser():0;
	}
	
	public function index(){
		
	}
	
	/**
	 * creativeInvolved fucntion 
	 *
	 * function call by  new project view through ajax
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	public function associativeCreatives($elementId=0,$entitytId=0,$heading='',$view='creativeInvolved',$loadView=false,$checkView=0) {
		
		if(empty($heading)){
			$heading=$this->lang->line('productionTeam');
		}
		$table='AssociativeCreatives';
		$data['heading']=$heading;
		$data['elementId']=$this->input->post('val1')>0?$this->input->post('val1'):$elementId;
		$data['entitytId']=$this->input->post('val2')>0?$this->input->post('val2'):$entitytId;
		
		if(strlen(@$this->input->post('val3')) > 2){
			$data['heading']=$this->input->post('val3');
		}
		
		$data['creativeInvolved']=$this->model_common->creativeInvolved($table,$data['elementId'],$data['entitytId']);
			
		$view =  $this->load->view($view,$data,$loadView);		
		if($loadView){
			return $view;
		}
	

	}
	
	/**
	 * addAssociative fucntion 
	 *
	 * function call by  new project view through ajax
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	public function addEditAssociative() {
		$countResult=0;
		$crtId = $this->input->post('val1');
		$entityId = $this->input->post('val6');
		$elementId = $this->input->post('val5');
		
		
		$data = array(
				'crtDesignation' => $this->input->post('val2'),
				'crtName' => $this->input->post('val3'),
				'crtStatus' =>   't',
				'crtEmail'=> $this->input->post('val4'),
				'elementId' => $elementId,
				'entityId' => $entityId
			);
		if($crtId > 0){
			$this->model_common->editDataFromTabel('AssociativeCreatives', $data, 'crtId', $crtId);
		}else{
			
			$addCreativeInvolvedLimit=$this->lang->line('addCreativeInvolvedLimit');
			$addCreativeInvolvedLimit=($addCreativeInvolvedLimit > 0)?$addCreativeInvolvedLimit:10;
			
			$where = array(
				'elementId' => $elementId,
				'entityId' => $entityId
			);
			$countResult=$this->model_common->countResult($table='AssociativeCreatives',$where);
			if($countResult < $addCreativeInvolvedLimit){
				$crtId=$this->model_common->addDataIntoTabel('AssociativeCreatives', $data);
			}else{
				$crtId=0;
			}
		}
		echo json_encode(array('crtId'=>$crtId,'countResult'=>$countResult));
	}
    
    //--------------------------------------------------------------------------
    
    /**
    * @access: public
    * @Description: This method is use to list of associative creatives project and element wise 
    * @param: entityId
    * @param: projectId/elementId
    * @return: void
    * @auther: lokendra meena
    * @email: lokendrameena@cdnsol.com
    */ 
    
    public function associativecreativeslist($entityId=0,$elementId=0){
        
        $associCreatList = $this->model_common->associativecreativeslist($entityId,$elementId);
        
        $this->data['associCreatList'] = $associCreatList;
        
        $this->load->view('associativeCreativesList',$this->data);
    }
	
	
}
