<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class facebook extends MX_Controller {
	function __construct(){
		parent::__construct();
	    parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
		$this->load->config("facebook",TRUE);
        $config = $this->config->item('facebook');
        $this->load->library('lib_facebook', $config);
	}
	function index(){
		$userId = $this->lib_facebook->getUser();
		if($userId == 0){
			$data['url'] = $this->lib_facebook->getLoginUrl(array('scope'=>'email')); 
			$this->load->view('facebook', $data);
		} else {
			$fql = 'SELECT uid, email,first_name,middle_name,last_name,name,religion,birthday_date,sex,hometown_location,current_location FROM user WHERE uid="'.$userId.'"';
                $user_result = $this->lib_facebook->api(array(
                            'method' => 'fql.query',
                            'query' => $fql
                ));
                
			$user = $user_result[0];
			//$user = $this->lib_facebook->api('/'.$userId);
			$picture = $this->lib_facebook->api('/me?fields=picture.height(500).width(500)');
			if(is_array($user) && count($user) > 0){
					$this->postedOnFB($user);
					echo "<pre>";
                print_r($user);
               echo "</pre>";
               echo "<pre>";
                print_r($picture);
               echo "</pre>";
			}else{
				
			}
		}
	}
	
	function postedOnFB($fbUser=array()){
		if($fbUser && is_array($fbUser) && isset($fbUser['uid']) && !empty($fbUser['uid']) ){
			$access_token = $this->lib_facebook->getAccessToken(); 
			$message     = 'Hello How R U fine?';
            
             $statusUpdate = $this->lib_facebook->api($fbUser['uid'].'/feed','POST',array(
				'access_token'=>$access_token,
				'message' => $message                             
			));
			echo "<pre>";print_r($statusUpdate);
			
			return $statusUpdate;
		}
				
	}
}	?>
