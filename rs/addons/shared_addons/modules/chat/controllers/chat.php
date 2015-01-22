<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  Piyush Jain
 * @package Chat\Controllers
 */
 class Chat extends Public_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('chat_model');
		$this->load->helper('frontend');
		$userId=is_logged_in();
	}
	
	public function checkLogged() {
		$userId=is_logged_in();
		$is_guest = $this->session->userdata('is_guest');
		if($userId){
			$username = ucwords($this->current_user->first_name.' '.$this->current_user->last_name);
			if(empty($this->current_user->first_name)){
				$username = ucwords($this->current_user->username);
			}
			$data['user'] = $this->chat_model->insert_user($userId,$username);
			echo json_encode(array('logged'=>true,"loggedAs"=>array("name"=>$username)));die;
		}
	}
	
	public static function getUser(){
		$userId=is_logged_in();
		$username = ucwords($this->current_user->first_name.' '.$this->current_user->last_name);
		$data['user'] = $this->chat_model->insert_user($userId,$username);
		if($userId){
			echo json_encode(array('logged'=>true));die;
		}
	}
	
	public function getChats($to_user_id=0,$return=false,$id=0,$is_guest=0){
		$all = 0;
		$user_type  = userGroup();
		$logged_in_user = is_logged_in();
		if($user_type==1){
			$user_type = "";
		}
		else{
			$user_type = 1;
		}
		if(empty($to_user_id)){
			$id			= $this->input->get('lastID');
			if($user_type=='')
			{
				$all = 1;
			}
			$to_user_id	= $logged_in_user;
		}
		$result		= $this->chat_model->getChats($id,$user_type,$to_user_id,$all,$is_guest,$logged_in_user);
		if($return){
			return $result;
		}
		else
		{
			echo json_encode($result);die;
		}
	}
	
	public function submitChat(){
		$chatText  = $this->input->post('chatText');
		$userType  = userGroup();
		$userId    = is_logged_in();
		$toUserId = $this->input->post('to_user_id');
		$result = $this->chat_model->submitChat($chatText,$userType,$userId,$toUserId);
		echo json_encode($result);die;
	}
	
	public function getUsers()
	{
		$to_user_id	= is_logged_in();
		$data = $this->chat_model->getUsers($to_user_id);
		echo json_encode($data);die;
	}
	
	public function loadUser(){
		$id  = $this->input->post('id');
		$is_guest  = $this->input->post('is_guest');
		$userName = $this->chat_model->getAuthorName($id);
		$userData = $this->getChats($id,true,0,$is_guest);
		$tpl = $this->load->view('loadUser',array('data'=>$userData,'user_id'=>$id,'userName'=>$userName,'is_guest'=>$is_guest),true);
		echo json_encode(array('tpl'=>$tpl));die;
	}
	
	public function guestLogin()
	{
		$data = $this->input->post();
		$dataArr = array('first_name'=>$data['name'],'email'=>$data['email'],'username'=>$data['name'],'last_name'=>'','password'=>'','salt'=>'','created_on'=>time(),'last_login'=>time(),'phone'=>'0','company'=>'','domain_name'=>'','membership_type'=>0,'is_guest'=>1);
		$res = $this->chat_model->saveGuestUser($dataArr);
		if($res){
			echo json_encode(array('status'=>1,'name'=>$data['name'],'id'=>$res));
		}
	}
}
?>
