<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author : Anoop singh
 * Email  : anoop@cdnsol.com
 * Timestamp : Aug-29 06:11PM
 * Copyright : www.cdnsol.com
 *
 */
class server{
	public $_parents = array();
	public $_data = array();
	/*IMAGE URL CONSTANT*/
	
	/**
	* @method __construct
	* @see private constructor to protect beign inherited
	* @access private
	* @return void
	*/
	public function __construct(){
		/// -- Create Database Connection instance --
		$this->_db=env::getInst();
		date_default_timezone_set('Asia/Kolkata');
		define("IMAGE_URL","http://www.chatching.com/");
		/// SMTP DETAILS
		define("HOST","localhost");
		define("USERNAME","amitpaliwal");
		define("PASSWORD","Sr8a7bwRLbWC");
		define("PORT","25");
		
		
		if(isset($_REQUEST['userName']) && isset($_REQUEST['password']) ){
			if($_REQUEST['username'] == 'chatching' && $_REQUEST['password']=='1!2@3#4$5%6n7&8*9@#$'){
				  $this->_data["errorMsg"] = "username and password is correct.";
				  return false;
			}else{
				$this->_data["errorMsg"] = "unathorized access, Invalid username and password.";
			    return false;
			}		 
		}else{			
			  $this->_data["errorMsg"] = "unathorized access, Invalid username and password.";
			   return false;			
		}
	}
	
	/*
		-------------------- WEB SERVICE   getDateTime(); --------------------
	*/
	function getDateTime(){
		date_default_timezone_set('Asia/Kolkata');
		
		$data = array();
			$data['serverDate']= date("Y-m-d");
			$data['serverTime']= date("H:i:00");
		return $data;		
	}
	
	
	/**
	* @method login
	* @access private
	* @parameter uname, pass
	* @return success/failure.
	 
	**/
	public function login($uname='',$pass='')	{		
	  $records_array = array();	 
	  if($uname != "" && $pass != "")
	  {
		  $query = "SELECT id FROM rest_users WHERE username = '".$uname."' AND password = '".md5($pass)."' AND isVerified  = 1";
		  
		  $result = $this->_db->my_query($query);
		  if($this->_db->my_num_rows($result) >= 1)
		  {
			 $row = $this->_db->my_fetch_object($result);
			 $records_array['userId'] = $row->id;
			 $records_array['msg'] = "success";
		  }
		  else
		  {
			$records_array['msg'] = "failure";
		  }
	  }
	  else
	  {
	    $records_array['errorMsg'] = "username and password could not be blank";
	  }
	  return  $records_array;
	}// end function login
		
	
	/**
	* @method get_wall
	* @access public
	* @parameter user_id
	* @return success/failure.	 
	**/
	public function get_wall()	{
		$logged_user_id = $_REQUEST['user_id'];
		
		
	}// end function profile
	/**
	* @method profile
	* @access public
	* @parameter user_id
	* @return profile data.	 
	**/
	public function profile($user_id='')	{
		$user_id=$this->decode_data($user_id);
		$user_result=array();
		//$user_id = $_REQUEST['user_id'];
		 /*----------------------------------------------------------------------
        * Comment : Memcached Implimentation  for user Profile
        *---------------------------------------------------------------------- */        
		
		$query  = 'SELECT user.user_id,user.facebook_id, user.firstname, user.lastname, user.email, user_profile.*,country.country_id,country.country_name,state.state_id,state.state_name,city.city_id,city.city_name,carrier.carrier_id,carrier.carrier_name,high_school_year.high_school_year_id, high_school_year.year,education_level.education_level_id, education_level.education_level,university.university_id,university.year';
		$query .=' FROM cc_user_profile as user_profile';
		$query .=' LEFT JOIN cc_user as user ON user.user_id = user_profile.user_id';
		$query .=' LEFT JOIN cc_country as country ON country.country_id = user_profile.country_id';
		$query .=' LEFT JOIN cc_state as state ON state.state_id = user_profile.state_id';
		$query .=' LEFT JOIN cc_city as city ON city.city_id = user_profile.city_id';
		$query .=' LEFT JOIN cc_carrier as carrier ON carrier.carrier_id = user_profile.carrier_id';
		$query .=' LEFT JOIN cc_high_school_year as high_school_year ON high_school_year.high_school_year_id = user_profile.high_school_year_id';
		$query .=' LEFT JOIN cc_education_level as education_level ON education_level.education_level_id = user_profile.education_level_id';
		$query .=' LEFT JOIN cc_university as university ON university.university_id = user_profile.university_id';
		$query .=' WHERE user_profile.user_id="'.$user_id.'"';
	
		$result = $this->_db->my_query($query);
		if($this->_db->my_num_rows($result) >= 1){
			$user_result = $this->_db->my_fetch_object($result);	
			$user_result->address ='';	
						

			$user_address_array="";
			if($this->IsJsonString($user_result->address)){
				$user_address_array=json_decode($user_result->address);				
			}
			$user_result->addresses= $user_address_array;               
			$user_result->userProfile_address= $user_address_array;               			
			
			$work_history_array="";
			if($this->IsJsonString($user_result->work_history)){
				$work_history_array=json_decode($user_result->work_history);				
			}
			$user_result->work_history= $work_history_array;               
			
			$education_history_array="";
			if($this->IsJsonString($user_result->education_history)){
				$education_history_array=json_decode($user_result->education_history);				
			}
			$user_result->education_history= $education_history_array;               
			
			$phones_array="";
			if($this->IsJsonString($user_result->phones)){
				$phones_array=json_decode($user_result->phones);				
			}
			$user_result->phones= $phones_array;               
			
			$home_phone_array="";
			if($this->IsJsonString($user_result->home_phone)){
				$home_phone_array=json_decode($user_result->home_phone);				
			}
			$user_result->home_phone= $home_phone_array;               
			
			   
			$data['userProfile']=$user_result;
			$user_result=$data;
		}else{
			$user_result['errorMsg'] = "username and password could not be blank";
		}	
		
		return $user_result;
	}// end function profile
	
	/**
	* @method IsJsonString
	* @access public
	* @parameter string
	* @return status string is jaon or not
	**/
	function IsJsonString($string) {
	 json_decode($string);
	 return (json_last_error() == JSON_ERROR_NONE);
	}// end function IsJsonString
	
	
	/*--------------------------------------------------------------------------
	 * Message - Function
	 *--------------------------------------------------------------------------*/
	 /**
	* @method messageuserlist
	* @access public
	* @parameter string
	* @return user messages list
	**/
	function messageuserlist($userid='',$type='') {		
		$data = array('errorMsg','Error!');
		if($userid!=''){
			$userid=$this->decode_data($userid);
			$data = array();
			$query  =" SELECT msg.*,fromU.user_id as from_user_id,fromU.firstname as from_firstname,fromU.lastname as from_lastname from cc_messages as msg ";
			$query .=" INNER JOIN cc_user as fromU ON CASE WHEN msg.to='".$userid."' THEN fromU.user_id=msg.from ELSE fromU.user_id=msg.to END   ";				
			
			$sent_or_received = "";
			if($type == 'recieved'){
				$sent_or_received = "AND (msg.to = ".$userid." AND msg.to_delete = 0)";
			}else if($type == 'sent'){
				$sent_or_received = "AND (msg.from = ".$userid." AND msg.from_delete = 0)";
			}
			$orderby	=" order by  msg.created DESC,msg.id DESC";
			$conditions =" (CASE WHEN msg.to='".$userid."' AND msg.to_delete='0' THEN msg.to='".$userid."' ELSE msg.from='".$userid."' AND msg.from_delete='0' END ) ";		
			$group_by 	=" GROUP By (CASE WHEN msg.to='".$userid."' THEN msg.from ELSE msg.to END ) ";
			
			$query .=" WHERE (msg.to='".$userid."'  OR  msg.from='".$userid."') AND ".$conditions." ".$sent_or_received;				
			$query .= $group_by.$orderby;		
			
			$result = $this->_db->my_query($query);
			
			if($this->_db->my_num_rows($result) >= 1){			
				while($msg_result = $this->_db->my_fetch_object($result)){
					$data['message_result'][]=$msg_result;
				}			
			}else{
				$data = array('errorMsg','No Message found.');
			}
			
		}
		return $data;
	}// end function messageuserlist
	
	/**
	* @method usermessages
	* @access public
	* @parameter string
	* @return user conversation message list with friend
	**/
	function usermessages($userid='',$friendid='') {		
		$data = array('errorMsg','Error!');
		if($userid!='' && $friendid!=''){
			$userid=$this->decode_data($userid);
			$friendid=$this->decode_data($friendid);
			$data = array();
			$query  =" SELECT msg.*,fromU.firstname as from_firstname,fromU.lastname as from_lastname,toU.firstname as to_firstname,toU.lastname as to_lastname from cc_messages as msg ";
			$query .=" INNER JOIN cc_user as fromU ON fromU.user_id=msg.from ";
			$query .=" INNER JOIN cc_user as toU ON toU.user_id=msg.to ";
			$query .=" WHERE (msg.from='".$friendid."' OR  msg.to='".$friendid."') AND  (msg.to='".$userid."' or  msg.from='".$userid."')";
			$query .=" AND (CASE WHEN msg.to='".$userid."' THEN msg.to_delete='0' ELSE  1 END)" ;
			$query .=" AND (CASE WHEN msg.from='".$userid."' THEN msg.from_delete='0' ELSE  1 END) " ;			
			$query .=" ORDER BY msg.created DESC";
			
			$result = $this->_db->my_query($query);			
			if($this->_db->my_num_rows($result) >= 1){			
				while($msg_result = $this->_db->my_fetch_object($result)){
					$data['user_message_result'][]=$msg_result;
				}			
			}else{
				$data = array('errorMsg','Now Conversation found.');
			} 
		}
		return $data;
	}// end function usermessages
	
	/**
	* @method deletemessage
	* @access public
	* @parameter string
	* @return delete user message
	**/
	function deletemessage($msg_id,$user_id) {		
		$data = array('errorMsg','Error!');
		if($msg_id!='' && $user_id!=''){
			$user_id=$this->decode_data($user_id);
			$msg_id=$this->decode_data($msg_id);
			$data = array();
			$query  =" Update cc_messages SET " ;
			$query .=" to_delete=(CASE WHEN `to`='".$user_id."' THEN '1' ELSE  `to_delete` END)" ;
			$query .=" ,from_delete=(CASE WHEN `from`='".$user_id."' THEN '1' ELSE  `from_delete` END)" ;
			$query .=" WHERE id='".$msg_id."' " ;
			$result = $this->_db->my_query($query);			
			if($result){							
				$data = array('errorMsg','Delete Succefully.');
			}else{
				$data = array('errorMsg','Error in delete message.');
			} 
		}
		return $data;
	}// end function deletemessage
	/*--------------------------------------------------------------------------
	 * Message - END Function
	 *-------------------------------------------------------------------------*/
	 
	 
	 /*--------------------------------------------------------------------------
	 * Common - Function
	 *--------------------------------------------------------------------------*/
	 function decode_data($data){
		 //return base64_decode($data);
		 return $data;
	 }
	 /*--------------------------------------------------------------------------
	 * END Common - Function
	 *--------------------------------------------------------------------------*/
} // end class
?>
