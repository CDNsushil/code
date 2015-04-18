<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//class Welcome extends CI_Controller {
class Shipping extends MX_Controller {
	private $data = array();
	private $userId = null;
	
	/**
	 * Constructor
	 */
	function __construct() {
		//Load required Model, Library, language and Helper files
			$load = array(
				'model'		=> 'shipping/model_shipping',
				'library' 	=> 'form_validation',			 	
				'helper' 	=> 'form + file'	
			);
			parent::__construct($load);		
			//$this->userId= $this->isLoginUser();
			$this->userId= isLoginUser()?isLoginUser():0;
	}
	
	public function index(){
		$this->shippingList();
	}
	
	public function shippingform() {
		$data=$this->input->get('val1');
		$data['countryList']=$this->model_shipping->shippingCountry($data['elementId'],$data['entityId'],$data['zoneId']);
		$this->load->view('shippingForm',$data);
	}
	
	/**
	 * Shipping fucntion 
	 *
	 * function call by  new project view through ajax
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	public function shippingList($elementId=0,$entityId=0,$view='shipping',$loadView=false) {
		$data['elementId']=$elementId;
		$data['entityId']=$entityId;
		
		$data['shippingZones']=$this->model_shipping->shippingList($elementId,$entityId);
		$view=$this->load->view($view,$data,$loadView);
		
		if($loadView){
			return $view;
		}
	}
	
	
	public function shippingDelete() {
		$formData=$this->input->post('val1');
		$spId=$formData['spId'];
		if($spId > 0){
			$table='ProjectShipping';
			$where=array('spId'=>$spId);
			$this->model_common->deleteRowFromTabel($table, $where);
			
			$formData['spId']=0;
			$formData['amount']=0.00;
			$formData['countriesId']='';
			$formData['status']='f';
			$this->load->view('shippingDetails',array('zone'=>$formData));
		}
	}
	
	public function shippingEnableDisable() {
		$spId=$this->input->post('val1');
		$status=$this->input->post('val2');
		$shortDesc=$this->input->post('val3');
		if($spId > 0){
			$table='ProjectShipping';
			$data=array('status'=>$status,'shortDesc'=>$shortDesc);
			$where=array('spId'=>$spId);
			$this->model_common->editDataFromTabel($table,$data,$where);
			echo 1;
		}
	}
	
	/**
	 * Shipping fucntion 
	 *
	 * function call by  new project view through ajax
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	
	public function addEditshipping() {
		
		/*echo "<pre>";
		echo "hellooooo";
		print_r($this->input->post());
		echo "<pre>";
		die;*/
		
		$table='ProjectShipping';
		$field='spId';
		$unqueId=$this->input->post('unqueId');
		$spId = $this->input->post('spId');
		$zoneId = $this->input->post('zoneId');
		$entityId = $this->input->post('entityId');
		$elementId = $this->input->post('elementId');
		$countriesId=$this->input->post('countriesId');
		$amount=$this->input->post('amount');
		$status=@$this->input->post('status')=='t'?'t':'f';
		$title=@$this->input->post('title');
		$shortDesc=@$this->input->post('shortDesc');		
		
		$shippingData = array(
				'amount' => $amount,
				'status' => $status,
				'countriesId' => $countriesId,
				'shortDesc' => $shortDesc,
				'userId' => $this->userId
		);
		
		if($spId > 0){
			$shippingData['modifyDate']=currntDateTime();
			$this->model_common->editDataFromTabel($table, $shippingData, $field, $spId);			
		}else{
			$shippingData['status']='t';
			$shippingData['entityId']=$this->input->post('entityId');
			$shippingData['elementId']=$this->input->post('elementId');
			$shippingData['zoneId']=$this->input->post('zoneId');
			$shippingData['shortDesc']=$this->input->post('shortDesc');
			$shippingData['crreatedDate']=currntDateTime();
			$spId=$this->model_common->addDataIntoTabel($table, $shippingData);
		}
		
		$formData=$shippingData;
		$formData['unqueId']=$unqueId;
		$formData['spId']=$spId;
		$formData['zoneId']=$zoneId;
		$formData['entityId']=$entityId;
		$formData['elementId']=$elementId;
		$formData['title']=$title;
		$this->load->view('shippingDetails',array('zone'=>$formData));
		//echo "<script>var parameter".$unqueId."=".json_encode($formData).";</script>";
	}
	
	public function globalShipping(){
		$data['interationalShipping'] = $this->model_shipping->globalShippingList($this->userId);
		
		if($data['interationalShipping']){
			$this->load->view('international_shipping_listing', $data);
		}else{
			$this->globalShippingform(true);
		}
		
	}
	
	public function globalShippingform($isFistZone=0) {
		$spId= $this->input->post('val1')?$this->input->post('val1'):0;
		$interationalShipping = false;
		if(is_numeric($spId) &&  $spId > 0){
			$interationalShipping = $this->model_shipping->globalShippingList($this->userId,$spId);
			$interationalShipping = isset($interationalShipping[0])?$interationalShipping[0]:false;
		}
		if(!$interationalShipping){
			if($isFistZone){
				$lastZoneId = 1;
			}else{
				$lastZoneId = $this->model_common->getMax('ProjectShipping','zoneId',array('userId'=>$this->userId,'isGlobal'=>'t'));
				$lastZoneId = (isset($lastZoneId[0]->zoneid) && !empty($lastZoneId[0]->zoneid))?($lastZoneId[0]->zoneid + 1):1;
			}
			$data['zoneTitle'] = 'Zone '.$lastZoneId;
		}
		$data['isFistZone'] = $isFistZone;
		$data['interationalShipping'] = $interationalShipping;
		$data['conitnentCountryList'] = $this->model_shipping->globalShippingCountryList($this->userId,$spId);
		$this->load->view('international_shipping_form',$data);
	}
	
	public function saveGlobalShipping() {
		$table='ProjectShipping';
		$field='spId';
		$spId = $this->input->post('spId');
		$countriesId=$this->input->post('countriesId');
		$shippingData = array(
				'countriesId' => $countriesId,
				'userId' => $this->userId,
				'isGlobal' => 't',
		);
		
		if($spId > 0){
			$shippingData['modifyDate']=currntDateTime();
			$this->model_common->editDataFromTabel($table, $shippingData, $field, $spId);			
		}else{
			$lastZoneId = $this->model_common->getMax('ProjectShipping','zoneId',array('userId'=>$this->userId,'isGlobal'=>'t'));
			$lastZoneId = (isset($lastZoneId[0]->zoneid) && !empty($lastZoneId[0]->zoneid))?($lastZoneId[0]->zoneid + 1):1;
			$shippingData['zoneId']=$lastZoneId;
			$shippingData['zoneTitle']='Zone '.$lastZoneId;
			$shippingData['crreatedDate']=currntDateTime();
			$spId=$this->model_common->addDataIntoTabel($table, $shippingData);
		}
		$this->globalShippingPriceform($spId);
	}
	
	public function globalShippingPriceform($spId=0) {
		$interationalShipping = false;
		if(is_numeric($spId) &&  $spId > 0){
			$interationalShipping = $this->model_shipping->globalShippingList($this->userId,$spId);
			$interationalShipping = isset($interationalShipping[0])?$interationalShipping[0]:false;
		}
		if($interationalShipping){
			$data['interationalShipping'] = $interationalShipping;
			$data['conitnentCountryList'] = $this->model_shipping->globalShippingCountryList($this->userId,$spId);
			$this->load->view('international_shipping_price_form',$data);
		}else{
			$this->globalShipping();
		}
	}
	
	public function saveGlobalShippingPrice($spId) {
		$table='ProjectShipping';
		$spId = $this->input->post('spId');
		$amount=$this->input->post('amount');
		$shortDesc=$this->input->post('shortDesc');
		
		$shippingData = array(
				'amount' => $amount,
				'shortDesc' => $shortDesc,
				'modifyDate' => currntDateTime()
		);
		
		if(is_numeric($spId) && $spId > 0){
			$this->model_common->editDataFromTabel($table, $shippingData, array('spId'=>$spId, 'userId'=>$this->userId));
		}
		
		$this->globalShipping();
	}
	
	public function deleteGlobalShipping() {
		$spId=$this->input->post('spId');
		$isGlobal=$this->input->post('isGlobal');
		$isGlobalStatus = 't';
		if(!empty($isGlobal)) {
			$isGlobalStatus = 'f';
		}
		$deleted=0;
		$countResult = 0 ;
		if($spId > 0){
			$table='ProjectShipping';
			$where=array('spId'=>$spId, 'userId'=>$this->userId, 'isGlobal'=>$isGlobalStatus);
			$this->model_common->deleteRowFromTabel($table, $where);
			$countResult = $this->model_common->countResult($table,$where,'',1);
			$deleted=1;
		}
		echo  json_encode(array('deleted'=>$deleted, 'countResult'=>$countResult));
	}
	
	
}
