<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//class Welcome extends CI_Controller {
class counsumptiontax extends MX_Controller {
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
			$this->userId = $this->isLoginUser();
	}
	
	public function index(){
		$this->counsumptiontaxForm();
	}
	
	public function counsumptiontaxForm($entityId=0,$elementId=0,$projectId=0,$view='consumptionTaxSettingsForm',$loadView=false) {
		$userId=$this->userId;
		$data['entityId']=$entityId;
		$data['elementId']=$elementId;
		$data['projectId']=$projectId;
		$where = array('userId'=>$userId,'entityId'=>$entityId,'elementId'=>$elementId);
		$res=$this->model_common->getDataFromTabel('ConsumptionTaxSettings', '*',  $where, '', '', '', 1 );
		$data['CTS']=isset($res[0])?$res[0]:false;
		$view=$this->load->view($view,$data,$loadView);
		if($loadView){
			return $view;
		}
	}
	public function counsumptiontaxSettings() {
		$userId=$this->userId;
		$counsumptiontaxDone=false;                     
		$msg=$this->lang->line('sessionExpired');
		if($userId > 0){
			$entityId=$this->input->post('entityId');
			$elementId=$this->input->post('elementId');
			$projectId=$this->input->post('projectId');
			$taxSettings=$this->input->post('taxSettings');
			$taxPercentage=$this->input->post('taxPercentage');
			
			if($entityId > 0 && $elementId >0){
				$updateData=array(
					'userId'=>$userId,
					'entityId'=>$entityId,
					'elementId'=>$elementId,
					'projectId'=>$projectId,
					'taxSettings'=>$taxSettings,
					'taxPercentage'=>$taxPercentage,
					'dateLastModify'=>currntDateTime()
				);
				$where=array(
					'userId'=>$userId,
					'entityId'=>$entityId,
					'elementId'=>$elementId
				);
				$res=$this->model_common->getDataFromTabel('ConsumptionTaxSettings', 'id',  $where, '', '', '', 1 );
				if($res){
					$res=$res[0];
					$id=$res->id;
					$this->model_common->editDataFromTabel('ConsumptionTaxSettings', $updateData, 'id', $id);
				}else{
					$this->model_common->addDataIntoTabel('ConsumptionTaxSettings', $updateData);
				}
				$counsumptiontaxDone=true;
				$msg=$this->lang->line('ratedSuccessfully');
			}
		}
	}
}
