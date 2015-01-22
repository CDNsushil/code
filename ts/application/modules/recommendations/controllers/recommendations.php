<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//class Welcome extends CI_Controller {
class recommendations extends MX_Controller {
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
	
	public function index($where=''){
		if(is_array($where) && count($where) > 0){
			$recommendations=$this->model_common->recommendations($where);
			//echo $this->db->last_query();die;
			return $recommendations;
		}else{
			return false;
		}
	}
	
	public function postrecommendations($elementId=0,$entityId=0) {
		
		$msg=$this->lang->line('sessionExpired');
		$from_userid=$this->isLoginUser();
		$to_userid=$this->input->post('to_userid');
		$recommendations=$this->input->post('recommendations');
		$is_show_in_showcase=$this->input->post('is_show_in_showcase');
		$is_show_in_cv=$this->input->post('is_show_in_cv');
		$is_show_in_workrequestclassified=$this->input->post('is_show_in_workrequestclassified');
		if($from_userid > 0 && $to_userid > 0){
			
			$inserdata=array(
				'from_userid'=>$from_userid,
				'to_userid'=>$to_userid,
				'recommendations'=>pg_escape_string($recommendations),
				'is_show_in_showcase'=>$is_show_in_showcase,
				'is_show_in_cv'=>$is_show_in_cv,
				'is_show_in_workrequestclassified'=>$is_show_in_workrequestclassified,
				'created_date'=>currntDateTime()
			);
			$this->model_common->addDataIntoTabel('Recommendations', $inserdata);
			echo $this->lang->line('recommendedSuccessfully');
		}else{
			echo $msg;
		}
	}
	
	public function updaterecommendations(){
		$this->isLoginUser();
		$data=$this->input->post('val1');
		$where=$this->input->post('val2');
		if(is_array($data) && count($data) > 0 && is_array($where) && count($where) > 0){
			$recommendations=$this->model_common->editDataFromTabel('Recommendations',$data,$where);
		}
	}
}
