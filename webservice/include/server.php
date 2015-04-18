<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require('PasswordHash.php');
require('language.php');
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
		$this->_msg=lang::getInst();
		date_default_timezone_set('Asia/Kolkata');		
	}
	
	/**
	 * @Input :Null
	 * @Output: Null
	 * @Access: Public
	 * Comment: function to User login
    */
	function login_user() {
		
		$useremail = $_REQUEST['useremail'];
		$password = $_REQUEST['password'];
		$check = $this->user_login_check($useremail,$password);	
		if($check==1) {
			$userdata['user_id'] = $_SESSION['user_id'];
			$userdata['username'] = $_SESSION['username'];
			$userdata['email'] = $_SESSION['email'];
			$userdata['workProfileId'] = $_SESSION['workProfileId'];
			$userdata['profileFName'] = $_SESSION['profileFName'];
			$userdata['profileLName'] = $_SESSION['profileLName'];
			$userdata['status'] = 1;
			$userdata['msg'] = $this->_msg->getKeyValue("LOGIN_SUCCESS");
			return $userdata;
			
		}
		else if ($check==2) {
			$error_msg['msg'] = $this->_msg->getKeyValue("CHECK_PASSWORD");
			$error_msg['status'] = 0;
		}
		else {
			$error_msg['msg'] = $this->_msg->getKeyValue("ACCOUNT_N_ACTIVE");
			$error_msg['status'] = 0;
			return $error_msg;
		}
	}
	
	/*
	 * Function for check user login cradentials
	*/	
	function user_login_check($userEmail,$password) {
	
		$hasher = new PasswordHash(8,TRUE);				
		$query = 'SELECT * FROM "TDS_UserAuth" WHERE email = \'' . $userEmail . '\' AND active=1';
		$result=$this->_db->my_query($query);
		
		$rows = pg_num_rows($result);
		if($rows==1) {
			$rs = pg_fetch_assoc($result);	
			$profile_query = 'SELECT * FROM "TDS_WorkProfile" WHERE "tdsUid" = \'' . $rs['tdsUid'] . '\'';
			$profile_result = pg_fetch_assoc($this->_db->my_query($profile_query));		
			if ($hasher->CheckPassword($password,$rs['password'])) {
				$_SESSION['user_id'] = 	$rs['tdsUid'];
				$_SESSION['username'] = $rs['username'];
				$_SESSION['email'] = $rs['email'];
				$_SESSION['workProfileId'] = $profile_result['workProfileId'];
				$_SESSION['profileFName'] = $profile_result['profileFName'];
				$_SESSION['profileLName'] = $profile_result['profileLName'];
				return 1;
			}
			else {
				return 2;
			}	
		}
		else {
			return 3;
		}									
	}
	
	/*
	 *Function for logout user 
	*/
	function logout_user() {
		
		if(!empty($_SESSION['user_id'])) {
			session_destroy();
			$userLogout['msg'] = $this->_msg->getKeyValue("LOGOUT_SUCCESS");
			$userLogout['status'] = 1;
			return $userLogout;
		}
		else {
			$userLogout['msg'] = $this->_msg->getKeyValue("ALREADY_LOGOUT");
			$userLogout['status'] = 0;
			return $userLogout;
		}
	}
	
	/* 
	 *Function for get activation email key forgot password 
	*/
	function forgot_password_key() {
		
		$useremail = $_REQUEST['useremail'];
		$query = 'SELECT * FROM "TDS_UserAuth" WHERE email = \'' . $useremail . '\' AND active=1';
		$rows = pg_num_rows($this->_db->my_query($query));
		if($rows==1) {
			$rs = pg_fetch_assoc($this->_db->my_query($query));
			$new_password_key = md5(rand().microtime());
			
			$query = 'UPDATE "TDS_UserAuth" SET new_password_key = \'' .$new_password_key . '\' WHERE "tdsUid" = \'' . $rs['tdsUid'] . '\'';
			$flag = $this->forgot_password_email($new_password_key, $useremail, $rs['tdsUid']);	
			if(pg_affected_rows($this->_db->my_query($query)) && $flag==1) {	
			//$flag = $this->forgot_password_email($new_password_key, $useremail, $rs['tdsUid']);					
		 	$userdata['user_id'] = $rs['tdsUid'];
		 	$userdata['new_password_key'] = $new_password_key;
		 	$userdata['status'] = 1;
		 	$userdata['msg'] = "We have sent you an email with instructions for creating your new password.";
		 	return $userdata;
			}
		} else {
			$userdata['status'] = 0;
		 	$userdata['msg'] = $this->_msg->getKeyValue("CHECK_EMAIL");
		 	return $userdata;
		}
	}
	
	/*
	 * Function for add new password in forgot passwoed 
	*/
	function get_new_password() {
		
		$user_id = $_REQUEST['user_id'];
		$new_password = $_REQUEST['new_password'];
		$confirm_password = $_REQUEST['confirm_password'];
		$new_password_key = $_REQUEST['new_password_key'];
		
		$query = 'SELECT * FROM "TDS_UserAuth" WHERE "tdsUid" = \'' . $user_id . '\' AND active=1';
		$rs = pg_fetch_assoc($this->_db->my_query($query));
		
		if($new_password==$confirm_password && $rs['new_password_key']==$new_password_key) {
			$hasher = new PasswordHash(8,TRUE);	
			$hashed_password = $hasher->HashPassword($new_password);
			$query = 'UPDATE "TDS_UserAuth" SET password = \'' . $hashed_password . '\' ,  new_password_key = NULL WHERE "tdsUid" = \'' . $user_id . '\'';
			if(pg_affected_rows($this->_db->my_query($query))) {
				$data['username'] = $rs['username'];
				$data['email'] = $rs['email'];	
				$data['msg'] = $this->_msg->getKeyValue("PASSWORD_CHANGE");
				$data['status'] = 1;
				return $data;
			}
			else {
				$data['msg'] = $this->_msg->getKeyValue("ALREADY_PASSWORD_CHANGE");
				return $data;
			}
			
		} else {
			$data['msg'] = $this->_msg->getKeyValue("CHECK_CRED");
			$data['status'] = 0;
			return $data;
		}
	}
	
	/*
	 * Function for get workprofile details 
	*/
	function workprofile_details() {
		
		if(!empty($_SESSION['user_id'])) {
			
			/*get basic profile details */
			$rs = $this->profile_details();
		
			/*get Education details */
			$education_query = 'SELECT "year_from","year_to","university","degree" FROM "TDS_WorkProfileEducation" WHERE "tdsUid" = \'' . $_SESSION['user_id'] . '\'';
			$rs_edu = pg_fetch_all($this->_db->my_query($education_query));
		
			/*get Work history details */
			$rs_work_history = $this->work_history_details($rs['workProfileId']);
		
			/*get Recommendation details */
			$refrance_query = 'SELECT "refFName","refLName","refCompName","refEmail","refContact" FROM "TDS_profileRecommendation" WHERE "workProfileId" = \'' . $rs['workProfileId'] . '\' AND "refArchived" = \' f \'';
			$rs_refrance = pg_fetch_all($this->_db->my_query($refrance_query));
		
			$data['profile_info'] = $rs;
			$data['edu_details'] = $rs_edu;
			$data['refrance_details'] = $rs_refrance;
			$data['work_history_details'] = $rs_work_history;
			$data['status'] = 1;
		
			return $data;
		
		} else {
			$data['msg'] = $this->_msg->getKeyValue("LOGIN");
			$data['status'] = 0;
			return $data;
		}
	}
	
	/*
	 *Function to get basic profile details 
	*/
	function profile_details() {
		
		$query = 'SELECT * FROM "TDS_WorkProfile" WHERE "tdsUid" = \'' . $_SESSION['user_id'] . '\'';
		$rs = pg_fetch_assoc($this->_db->my_query($query));
		$profile_array = array();
		$profile_array['workProfileId'] = $rs['workProfileId'];
		$profile_array['workProfileId'] = $rs['workProfileId'];
		$profile_array['profileCity'] = $rs['profileCity'];
		$profile_array['profilePhone'] = $rs['profilePhone'];
		$profile_array['profileFName'] = $rs['profileFName'];
		$profile_array['profileLName'] = $rs['profileLName'];
		$profile_array['synopsis'] = $rs['synopsis'];
		$profile_array['languagesKnown'] = $rs['languagesKnown'];
		$profile_array['nationality'] = $rs['nationality'];
		$profile_array['availability'] = $rs['availability'];
		$profile_array['noticePeriod'] = $rs['noticePeriod'];
		$profile_array['remunerationRequired'] = $rs['remunerationRequired'];
		$profile_array['achievmentsAndAwards'] = strip_tags($rs['achievmentsAndAwards']);
		$profile_array['profileAdd'] = $rs['profileAdd'];
		$profile_array['profileStreet'] = $rs['profileStreet'];
		$profile_array['profileZip'] = $rs['profileZip'];
		$profile_array['profileEmail'] = $rs['profileEmail'];
		$profile_array['fileId'] = $rs['fileId'];
		$profile_array['profileState'] = $rs['profileState'];
		return $profile_array;
	}
	
	/*
	 * Function to get Work history details
	*/
	function work_history_details($workProfileId) {
		
		$workhistory_query = 'SELECT "empStartDate","empEndDate","empDesignation","compName","compCity","empAchivments" FROM "TDS_profileEmpHistory" WHERE "workProfileId" = \'' . $workProfileId . '\' AND "empArchived" = \' f \'';
		$history_inforesult=$this->_db->my_query($workhistory_query);
		$rs_work_history = pg_fetch_all($history_inforesult);
		
		$workhistory_array = array();
		for($i=0;$i<count($rs_work_history);$i++) {
			$dd = array();
			$dd['empStartDate'] = $rs_work_history[$i]['empStartDate'];
			$dd['empEndDate'] = $rs_work_history[$i]['empEndDate'];
			$dd['empDesignation'] = $rs_work_history[$i]['empDesignation'];
			$dd['compName'] = $rs_work_history[$i]['compName'];
			$dd['compCity'] = $rs_work_history[$i]['compCity'];
			$dd['empAchivments'] = strip_tags($rs_work_history[$i]['empAchivments']);
			$workhistory_array[] = $dd;
		}
		return $workhistory_array;
	}
	
	/*
	 *Function to get Portfolio listings 
	*/
	function portfolio_listing() {
		
		if(!empty($_SESSION['user_id'])) {
			
			$query1 = 'SELECT * FROM "TDS_ProfileMedia" WHERE "workProfileId" = \'' . $_SESSION['workProfileId'] . '\'';
			$rs1 = pg_fetch_all($this->_db->my_query($query1));
			$profilemedia_array = array();
			
			/*Get all images*/
			$profilemedia_array_image = array();	
			for($i=0;$i<count($rs1);$i++)
			{
				$media_image = array();
				if($rs1[$i]['mediaType']==1)
				{	
					$media_image['mediaName'] = $rs1[$i]['mediaName'];
					$media_image['mediaLength'] = $rs1[$i]['mediaLength'];
					$media_image['mediaSize'] = $rs1[$i]['mediaSize'];
					$media_image['mediaTitle'] = $rs1[$i]['mediaTitle'];
					$media_image['mediaDesc'] = $rs1[$i]['mediaDesc'];				
					if(!empty($rs1[$i]['fileId'])) {
						$filePath_query = 'SELECT "filePath", "fileName" FROM "TDS_MediaFile" WHERE "fileId" = \'' . $rs1[$i]['fileId'] . '\'';
						$result_file_path = pg_fetch_assoc($this->_db->my_query($filePath_query));
						$media_image['filePath'] = $result_file_path['filePath'].'/'.$result_file_path['fileName'];
					}
				}
				if(!empty($media_image)) {
					$profilemedia_array_image[] = $media_image;
				}
			}
			$profilemedia_array['images'] = $profilemedia_array_image;
			
			/*Get all videos*/
			$profilemedia_array_video = array();	
			for($ii=0;$ii<count($rs1);$ii++)
			{
				$media_video = array();
				if($rs1[$ii]['mediaType']==2)
				{		
					$media_video['mediaName'] = $rs1[$ii]['mediaName'];
					$media_video['mediaLength'] = $rs1[$ii]['mediaLength'];
					$media_video['mediaSize'] = $rs1[$ii]['mediaSize'];
					$media_video['mediaTitle'] = $rs1[$ii]['mediaTitle'];
					$media_video['mediaDesc'] = $rs1[$ii]['mediaDesc'];				
					if(!empty($rs1[$ii]['fileId'])) {
						$filePath_query = 'SELECT "filePath", "fileName" FROM "TDS_MediaFile" WHERE "fileId" = \'' . $rs1[$ii]['fileId'] . '\'';
						$result_file_path = pg_fetch_assoc($this->_db->my_query($filePath_query));
						$exp_name = explode('.',$result_file_path['fileName']);
						$media_video['filePath'] = $result_file_path['filePath'].'converted/'.$exp_name[0].'.mp4';
					}
				}
				if(!empty($media_video)) {
					$profilemedia_array_video[] = $media_video;
				}
			}
			$profilemedia_array['video'] = $profilemedia_array_video;
			
			/*Get all sound*/
			$profilemedia_array_sound = array();	
			for($i=0;$i<count($rs1);$i++)
			{
				$media_audio = array();
				if($rs1[$i]['mediaType']==3)
				{
					$media_audio['mediaName'] = $rs1[$i]['mediaName'];
					$media_audio['mediaLength'] = $rs1[$i]['mediaLength'];
					$media_audio['mediaSize'] = $rs1[$i]['mediaSize'];
					$media_audio['mediaTitle'] = $rs1[$i]['mediaTitle'];
					$media_audio['mediaDesc'] = $rs1[$i]['mediaDesc'];				
					if(!empty($rs1[$i]['fileId'])) {
						$filePath_query = 'SELECT "filePath", "fileName" FROM "TDS_MediaFile" WHERE "fileId" = \'' . $rs1[$i]['fileId'] . '\'';
						$result_file_path = pg_fetch_assoc($this->_db->my_query($filePath_query));
						
						$exp_name = explode('.',$result_file_path['fileName']);
						$media_audio['filePath'] = $result_file_path['filePath'].'converted/'.$exp_name[0].'.mp3';
						$media_audio['thumbFilePath'] = $result_file_path['filePath'].'converted/'.$exp_name[0].'_preview.mp3';
					}
				}
				if(!empty($media_audio)) {
					$profilemedia_array_sound[] = $media_audio;
				}
			}
			$profilemedia_array['sound'] = $profilemedia_array_sound;
			
			/*Get all text files*/
			$profilemedia_array_text = array();	
			for($i=0;$i<count($rs1);$i++)
			{
				$media_text = array();
				if($rs1[$i]['mediaType']==4)
				{
					$media_text['mediaName'] = $rs1[$i]['mediaName'];
					$media_text['mediaLength'] = $rs1[$i]['mediaLength'];
					$media_text['mediaSize'] = $rs1[$i]['mediaSize'];
					$media_text['mediaTitle'] = $rs1[$i]['mediaTitle'];
					$media_text['mediaDesc'] = $rs1[$i]['mediaDesc'];				
					if(!empty($rs1[$i]['fileId'])) {
						$filePath_query = 'SELECT "filePath", "fileName" FROM "TDS_MediaFile" WHERE "fileId" = \'' . $rs1[$i]['fileId'] . '\'';
						$result_file_path = pg_fetch_assoc($this->_db->my_query($filePath_query));
						$media_text['filePath'] = $result_file_path['filePath'].'/'.$result_file_path['fileName'];
					}
				}
				if(!empty($media_text)) {
					$profilemedia_array_text[] = $media_text;
				}
			}
			$profilemedia_array['text'] = $profilemedia_array_text;
			$profilemedia_array['status'] = 1;
			return $profilemedia_array;
		}
		else {
			$data['msg'] = $this->_msg->getKeyValue("LOGIN");
			$data['status'] = 0;
			return $data;
		}
	}
	
	/*
	 * Function for send email to forgot password
	*/
	function forgot_password_email($new_pass_key, $useremail, $user_id) {
		
		$to = $useremail;
		$subject = 'Forgot your password on toadsquare?';
				
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: toadsquare' . "\r\n";
		
		$user_id = $user_id;
		$site_url = "http://115.113.182.141/toadsquare_branch/dev";
		$new_pass_key = $new_pass_key;
		//echo $url = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']); die;
		//$msg = include_once("mail_body.php");
		$msg = '<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Create a new password</h2>
		Forgot your password, huh? No big deal.<br />
		To create a new password, just follow this link:<br />
		<br />
		<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="'.$site_url.'/en/auth/reset_password/'.$user_id.'/'.$new_pass_key.'" style="color: #3366cc;">Create a new password</a></b></big><br />
		<br />
		Link doesnt work? Copy the following link to your browser address bar:<br />
		<nobr><a href="'.$site_url.'/en/auth/reset_password/'.$user_id.'/'.$new_pass_key.'" style="color: #3366cc;">"'. $site_url.'/en/auth/reset_password/'.$user_id.'/'.$new_pass_key.'</a></nobr><br />
		<br />
		<br />
		You received this email, because it was requested by a <a href="" style="color: #3366cc;">toadsquare</a> user. This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same.<br />
		<br />
		<br />
		Thank you,<br />';
		
		$flag = mail($to,$subject,$msg,$headers);
		return $flag;
	}
		
	/*
	 * Function for Meeting point manager
	*/
	function meeting_point_manager($a='', $b='') {
		
		if(!empty($_SESSION['user_id'])) {
			$current_date = date("Y-m-d H:i:s");
			
			$query = 'SELECT * FROM "TDS_MeetingPoint" WHERE "user_id" = \'' . $_SESSION['user_id'] . '\'';
			$rs = pg_fetch_all($this->_db->my_query($query));
		
			$event_array = array();
			for($i=0;$i<count($rs);$i++)
			{ 	$event = array();
				$session_query = 'SELECT * FROM "TDS_EventSessions" WHERE "sessionId" = \'' . $rs[$i]['session_id'] . '\'';
				$event = pg_fetch_all($this->_db->my_query($session_query));
				
				for($j=0 ;$j<count($event);$j++) 
				{ 
					$exp_date = explode(' ' , $event[$j]['date']);
					$session_date = $exp_date[0].' '.$event[$j]['endTime'];
					if($session_date >= $current_date) 
					{
						$event_details = array();
						$event_details['sessionId'] = $event[$j]['sessionId'];
						$event_details['dateTime'] = $session_date;
						$event_details['startTime'] = $event[$j]['startTime'];
						$event_details['venue'] = $event[$j]['venue'];
						if($event[$j]['launchEventId']!=0) {
							$filePath_query = 'SELECT * FROM "TDS_LaunchEvent" WHERE "LaunchEventId" = \'' . $event[$j]['launchEventId'] . '\'';
							$result = pg_fetch_assoc($this->_db->my_query($filePath_query));
							} else {
							$filePath_query = 'SELECT * FROM "TDS_Events" WHERE "EventId" = \'' . $event[$j]['eventId'] . '\'';
							$result = pg_fetch_assoc($this->_db->my_query($filePath_query));
						}
						$event_details['eventId'] = $event[$j]['eventId'];
						$event_details['launchEventId'] = $event[$j]['launchEventId'];
						$event_details['address'] = $event[$j]['address'];
						$event_details['city'] = $event[$j]['city'];
						$event_details['state'] = $event[$j]['state'];
						if(!empty($event[$j]['country'])) {
							$val = 'countryName';
							$table = 'TDS_MasterCountry';
							$where = '"countryId" = \'' . $event[$j]['country'] . '\'';
							$result_country=$this->_db->select_assoc($val, $table, $where);
						}
						if(!empty($result['tdsUid'])) {
							$user_name = 'SELECT "profileFName","profileLName" FROM "TDS_WorkProfile" WHERE "tdsUid" = \'' . $result['tdsUid'] . '\'';
							$result_user_name = pg_fetch_assoc($this->_db->my_query($user_name));
						}
						$event_details['country'] = $result_country['countryName'];
						$event_details['zip'] = $event[$j]['zip'];
						$event_details['url'] = $event[$j]['url'];
						$event_details['Event_title'] = $result['Title'];
						$event_details['Event_desc'] = $result['OneLineDescription'];
						$event_details['venueName'] = $event[$j]['venueName'];
						$event_details['address2'] = $event[$j]['address2'];
						$event_details['venueEmail'] = $event[$j]['venueEmail'];
						$event_details['phoneNumber'] = $event[$j]['phoneNumber'];
						$event_details['user_name'] = $result_user_name['profileFName'] .' '. $result_user_name['profileLName'];
						$event_array[] = $event_details;
					}
				}
			}
			$event_array['status'] = 1;
			/*get array sort by date */
			foreach ($event_array as $key => $row) {
			$mid[$key]  = $row['dateTime'];
			}
			array_multisort($mid, SORT_DESC, $event_array);
			
			return $event_array;
		}
		else {
			$data['msg'] = $this->_msg->getKeyValue("LOGIN");
			$data['status'] = 0;
			return $data;
		}
	}
		
	/*
	 * Function for get Meeting  Event details 
	*/
	function event_details() {
		
		if(!empty($_REQUEST['session_id']) && !empty($_SESSION['user_id'])) {
			$session_id = $_REQUEST['session_id'];
			$session_query = 'SELECT * FROM "TDS_EventSessions" WHERE "sessionId" = \'' . $_REQUEST['session_id'] . '\'';
			$result_session_info = pg_fetch_assoc($this->_db->my_query($session_query));
		
			$user_name = 'SELECT "profileFName","profileLName" FROM "TDS_WorkProfile" WHERE "tdsUid" = \'' . $_SESSION['user_id'] . '\'';
			$result_user_name = pg_fetch_assoc($this->_db->my_query($user_name));
			
			if($result_session_info['launchEventId']!=0) {
				$event_query = 'SELECT * FROM "TDS_LaunchEvent" WHERE "LaunchEventId" = \'' . $result_session_info['launchEventId'] . '\'';
				$result_event_info = pg_fetch_assoc($this->_db->my_query($event_query));	
			} else {
				$event_query = 'SELECT "Title","OneLineDescription" FROM "TDS_Events" WHERE "EventId" = \'' . $result_session_info['eventId'] . '\'';
				$result_event_info = pg_fetch_assoc($this->_db->my_query($event_query));
			}
			
			$session_users = 'SELECT * FROM "TDS_MeetingPoint" WHERE "session_id" = \'' . $_REQUEST['session_id'] . '\'';
			$result_session_users = pg_fetch_all($this->_db->my_query($session_users));
			$users_details = array();
			for($i=0;$i<count($result_session_users);$i++) {
				$user_array = array();
				$user_details_query = 'SELECT "profileFName","profileLName","fileId" FROM "TDS_WorkProfile" WHERE "tdsUid" = \'' . $result_session_users[$i]['user_id'] . '\'';
				$result_user_details = pg_fetch_assoc($this->_db->my_query($user_details_query));
				
				$user_array['profileFName'] = $result_user_details['profileFName'];
				$user_array['profileLName'] = $result_user_details['profileLName'];
				if(!empty($result_user_details['fileId'])) {
					$user_prof_img = 'SELECT "filePath","fileName" FROM "TDS_MediaFile" WHERE "fileId" = \'' . $result_user_details['fileId'] . '\'';
					$result_user_prof_img = pg_fetch_assoc($this->_db->my_query($user_prof_img));
					$user_array['filePath'] = $result_user_prof_img['filePath'].$result_user_prof_img['fileName'];
				}
				if($result_session_users[$i]['user_id'] != $_SESSION['user_id']) {
					$users_details[] = $user_array;
				}
			}
			$exp_date = explode(' ' , $result_session_info['date']);
			$session_date = $exp_date[0].' '.$result_session_info['endTime'];
			
			$session_event_details['sessionId'] = $result_session_info['sessionId'];
			$session_event_details['dateTime'] = $session_date;
			$session_event_details['startTime'] = $result_session_info['startTime'];
			$session_event_details['venue'] = $result_session_info['venue'];
			$session_event_details['eventId'] = $result_session_info['eventId'];
			$session_event_details['launchEventId'] = $result_session_info['launchEventId'];
			$session_event_details['address'] = $result_session_info['address'];
			$session_event_details['city'] = $result_session_info['city'];
			$session_event_details['state'] = $result_session_info['state'];
			if(!empty($result_session_info['country'])) {
				$val = 'countryName';
				$table = 'TDS_MasterCountry';
				$where = '"countryId" = \'' . $result_session_info['country'] . '\'';
				$result_country=$this->_db->select_assoc($val, $table, $where);
			}
			$session_event_details['country'] = $result_country['countryName'];
			$session_event_details['zip'] = $result_session_info['zip'];
			$session_event_details['Event_title'] = $result_event_info['Title'];
			$session_event_details['Event_desc'] = $result_event_info['OneLineDescription'];
			$session_event_details['venueName'] = $result_session_info['venueName'];
			$session_event_details['address2'] = $result_session_info['address2'];
			$session_event_details['venueEmail'] = $result_session_info['venueEmail'];
			$session_event_details['phoneNumber'] = $result_session_info['phoneNumber'];
			$session_event_details['user_name'] = $result_user_name['profileFName'] .' '. $result_user_name['profileLName'];
			
			$data['users_details'] = $users_details;
			//$data['event_information'] = $result_event_info;
			$data['session_details'] = $session_event_details;
			$data['status'] = 1;
			return $data;
		}
		else {
			$data['msg'] = $this->_msg->getKeyValue("LOGIN");
			$data['status'] = 0;
			return $data;
		}
	}
	
} // end class
?>
