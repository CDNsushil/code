<?php
if(! defined('BASEPATH')) exit('No direct script access allowed');
	

	
	
	
	/*
	* @Access: public
	* @Input: user chatching post array , user fb post array
	* @Output: get  chathing and fb merge post according time
	* Comment:Function for merge user chatching and fb post
	*/
	function merge_facebook_chatching_feeds($chatChingArray,$fbArray){	
		$merge_array =array();
				
		$fbArray=std_object_to_assoc_array($fbArray);
		//$fbArray=(count($fbArray)>0?$fbArray[0]:array());
		//echo "<pre>";print_R($fbArray);echo "</pre>";		
		//if($chatChingArray!=false && count($chatChingArray)>0)
		if(count($chatChingArray)>0)
		{					
			foreach($chatChingArray as $key => $chat){	
				
				if(count($fbArray)>0){			
					foreach($fbArray as $fbkey => $fb){														
						if(strtotime($chat['datetime']) < strtotime($fb['updated_time'])){											
							$fb['fromFB'] =1;
							$merge_array[] =$fb;
							unset($fbArray[(int)$fbkey]);								
						}				
					}
				}	
				
				$chat['fromFB'] =0;
				$merge_array[] =$chat;											
			}
		}
		
		foreach($fbArray as $fbkey => $fb){									
			$fb['fromFB'] =1;
			$merge_array[] =$fb;									
		}			
		//echo "<pre>";print_R($fbArray);echo "</pre>";		
		//$freq_arrange_array = arrange_post_by_freq($merge_array);
		
		return $merge_array;	
	}
	
	/*
	* @Access: public
	* @Input: stdClass array
	* @Output: assoc array
	* Comment:function for convert stdclass array to assoc array
	*/
	function std_object_to_assoc_array($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		} 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}
	/*
	* @Access: public
	* @Input: get post data
	* @Output: get user post according interaction
	* Comment:Function for arrange data by user comments frequency
	*/
	
	function arrange_post_by_freq($freq_arrange_array){
		$read_db ='';
        $CI =& get_instance();
        $CI->read_db = $CI->load->database('read',TRUE);

		
		/*
		 * get new friends for latest show
		 * */
		$user_id=$CI->session->userdata('user_user_id');	
		 
	 	$query 	 =" SELECT user.user_id,user.facebook_id";	
		$query	.=" FROM cc_user AS user  ";		
		$query	.=" INNER JOIN cc_friends AS fri ON CASE WHEN fri.to_user_id='".$user_id."' THEN user.user_id =fri.from_user_id ELSE user.user_id =fri.to_user_id END";				
		$query	.="	WHERE fri.status='1'  AND fri.created_at >= '".date('Y-m-d h:i:s',mktime(0,0,0,date('m'),date('d')-7,date('Y')))."' ";		
		$query	.="	AND CASE WHEN fri.to_user_id='".$user_id."' THEN fri.to_user_id='".$user_id."' ELSE fri.from_user_id='".$user_id."' END";		
		$query	.="	 group by user.user_id order by fri.created_at DESC";		
		
		$result=$CI->read_db->query($query);
		$new_friends =$result->result();	
		//echo "<pre>";print_R($new_friends);die;
		$merge_array=array();
		if(count($new_friends)>0){

			foreach($new_friends As $fri)
			{
				if(count($freq_arrange_array)>0)
				{
					foreach($freq_arrange_array As $mkey=>$mArray)
					{
						if(isset($mArray['user_id']))
						{
							if($fri->user_id==$mArray['user_id'] )
							{
								$merge_array[] =$mArray;
								unset($freq_arrange_array[$mkey]);	
								continue;				
							}
						}
						if(isset($mArray['from']['id']))
						{
							if($fri->facebook_id == $mArray['from']['id'])
							{
								$merge_array[] =$mArray;
								unset($freq_arrange_array[$mkey]);					
								continue;
							}
						}
					}
				}
			}
			
			/*
			 * add remaining post in frequency array
			 * */
			if(count($freq_arrange_array)>0)
			{
				foreach($freq_arrange_array As $mkey=>$mArray)
				{									
					$merge_array[] =$mArray;						
				}
			}
		}else{
			$merge_array=$freq_arrange_array;						
		}
	
		
		
		$freq_arrange =array();
		$friend_frequency = $CI->session->userdata('friend_frequency');	
		if($friend_frequency !=false && count($friend_frequency)>0){
			foreach($friend_frequency As $friend){
                if(count($merge_array)>0){			
				    foreach($merge_array As $mkey=>$mArray){
					    if(isset($mArray['user_id'])){
						    if($friend->Friend_id==$mArray['user_id'] ){
							    $freq_arrange[] =$mArray;
							    unset($merge_array[$mkey]);	
							    break;				
						    }
					    }
					    if(isset($mArray['from']['id'])){
						    if($friend->facebook_id == $mArray['from']['id']){
							    $freq_arrange[] =$mArray;
							    unset($merge_array[$mkey]);					
							    break;				
						    }
					    }
				    }
				}
			}
			
			/*
			 * add remaining post in frequency array
			 * */
			 if(count($merge_array)>0){
			    foreach($merge_array As $mkey=>$mArray){									
							    $freq_arrange[] =$mArray;						
			    }
			   }else{
    			    $freq_arrange =array();
			   }
		}else{
			$freq_arrange=$merge_array;
		}	
		
		
		
		
		return $freq_arrange;
	}
	
	
	/*
	* @Access: public
	* @Input: city id
	* @Output: get city name
	* Comment: This function get city name by city id
	*/
	function get_city_name_by_city_id($city_id){
		$read_db ='';
        $CI =& get_instance();
        $CI->read_db = $CI->load->database('read',TRUE);
		$CI->read_db->select('city_name');
		$CI->read_db->where('city_id',$city_id);
		$CI->read_db->from('cc_city');
		$city_name = $CI->read_db->get()->row()->city_name;	
		return $city_name;
	}
	
	
	
	/*
	* @Access: public
	* @Input: user data array 
	* @Output: Array facebook user data
	* Comment: This function get facebook user information 
	*/
	function  get_facbook_user_data($facebook_id){
		@session_start();		
		$read_db ='';
        $CI =& get_instance();
        $CI->read_db = $CI->load->database('read',TRUE);
		$user_data =array();
		
		$selection="user.fb_access_token,user.fb_access_token_datetime,user.facebook_id,user.random_number,user.parent_approval,user.parent_email,user.language,user.user_id,user.theme_option,user.secure_browsing,user.is_notification_display,user.step_to_open,user.facebook_id,user.parent_id,user.theme_option,user.username,user.password,user.email,
					user.firstname,user.lastname,user.published,user_profile.user_profile_id,user_profile.country_id,user_profile.state_id,
					user_profile.city_id,user_profile.profile_picture,state.is_under_incentive_program,user_profile.is_register_for_points";
		
	
		$CI->read_db->select($selection);
		$CI->read_db->from('user');
		$CI->read_db->where('user.facebook_id',$facebook_id);
		$CI->read_db->join('user_profile', 'user_profile.user_id=user.user_id','left');
		$CI->read_db->join('state', 'user_profile.state_id=state.state_id','left');
		$user_data 		= $CI->read_db->get()->row();
		
		if(count($user_data) > 0){			
			$firstname 	= $user_data->firstname;
			$lastname 	= $user_data->lastname;
			$full_name	=	ucfirst($firstname)." ".ucfirst($lastname);
			if(strlen($full_name) > 8){
				$name 	= 	substr($full_name,0,6)." ..";
			}else{
				$name	=	$full_name;
			}			
			$user_image =BASEURL.'assets/user_images/default/profile/small_image/picture_upload.png';
			if($user_data->profile_picture!=''){
                // call get image helper function to get url of the image
                $profile_image_dimention = $CI->config->item('__78X78__');
                $user_image = getimage('user', 2, $user_data->user_id,'','','','',$profile_image_dimention);
				//$user_image =  getimage('user',2,$user_data->user_id);	
			}
			$user_data->user_image =$user_image;			
			$user_data->user_link = "<a href='".BASEURL."user_wall/get_wall/".$user_data->user_id."'>".$name."</a>";
			
			 /*
			 * Session for cometchat
			 * */
			$_SESSION['user_user_id'] =base64_encode($user_data->user_id); 
			$_SESSION['BASEURL'] =BASEURL;
			 
			
			$language 		= $CI->config->item('default_language');
			$CI->read_db->select('language');
			$CI->read_db->from('language');
			$CI->read_db->where('language_id', $user_data->language);
			if($lang 	=	$CI->read_db->get())
					$language 	= 	$lang->row()->language;
			
			$sessionData = array(																		
						'user_user_id'  => $user_data->user_id,
						'user_email'    => $user_data->email,
						'user_username'	=> $user_data->username,
						'firstname'		=> $user_data->firstname,
						'lastname'		=> $user_data->lastname,
						'lang_id'		=> $user_data->language,
						'lang'		=>$language
						);
			$CI->session->set_userdata($sessionData);		
			$CI->session->set_userdata('facebook_id',$facebook_id);		
			$CI->session->set_userdata('is_notification_display',$user_data->is_notification_display);		
			$CI->session->set_userdata('logged_user_account_status',$user_data->published);				
			$CI->session->set_userdata('secure_browsing',$user_data->secure_browsing);				
			$CI->session->set_userdata('user_theme_id',$user_data->theme_option);	
			$CI->session->set_userdata('is_register_for_points',$user_data->is_register_for_points);	
			$language_arr=array('language'=>$language,'language_id'=>$user_data->language,'language_code'=>'en');
			$CI->session->set_userdata($language_arr);	
			
			
			
		}	
		
		return $user_data;
	}
	
	/*
	* @Access: public
	* @Input:  
	* @Output: true or false
	* Comment: This function check site running by Iframe or not
	*/
	function check_site_reference(){
		$CI = & get_instance();		
		check_facebook_session_exist();
	
		/*if($CI->session->userdata('destroy_session')!='') {			
			$CI->session->set_userdata('destroy_session','');			
			$CI->load->library('facebook_library');
			$facebook_id        = $CI->facebook_library->getUser();			
			$facebook_ref ='apps.facebook.com';	
			if((strpos(@$_SERVER['HTTP_REFERER'],$facebook_ref)) > 0 || $facebook_id !=''){
				 get_facbook_user_data($facebook_id);
			}
		}*/
	}
	
	/*
	* @Access: public
	* @Input:  
	* @Output: 
	* Comment: Destroy facebook session if exist on logout
	*/
	function facebook_session_destroy(){
		/*$CI = & get_instance();
		 
		$CI->load->library('facebook_library');
		$facebook_id        = $CI->facebook_library->getUser();
		$session_facebook_id =$CI->session->userdata('facebook_id');		
		if($session_facebook_id){
				// unset cookies
				if (isset($_SERVER['HTTP_COOKIE'])) {
					$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
					foreach($cookies as $cookie) {
						$parts = explode('=', $cookie);
						$name = trim($parts[0]);
						setcookie($name, '', time()-1000);
						setcookie($name, '', time()-1000, '/');
					}
				}
			  //$CI->facebook_library->destroySession();
		}	
		*/
	}
	
	/*
	* @Access: public
	* @Input:  null
	* @Output: null
	* Comment: check facebook session exist or not
	*/
	function check_facebook_session_exist(){
		/*$CI = & get_instance();		 
		$CI->load->library('facebook_library');
		
		$facebook_id	        = 	$CI->facebook_library->getUser();
		
		$session_facebook_id	=	$CI->session->userdata('facebook_id');	
		$facebook_ref ='apps.facebook.com';	
		if((($session_facebook_id  !='' && $facebook_id !='' && $session_facebook_id != $facebook_id) || ((strpos(@$_SERVER['HTTP_REFERER'],$facebook_ref)) > 0 && $facebook_id !='')) && $CI->session->userdata('destroy_session')==''){				
			
				get_facbook_user_data($facebook_id);
		}
		*/
	}
	
	/* gets the data from a URL */
	function get_data_using_curl($url) {
	  $ch = curl_init();
	  $timeout = 5;
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  return $data;
	}
	/* end of file */
	
	/*
	* @Access: public
	* @Input:  user_id,facebook_id,fbaccesstoken, access token time
	* @Output: null
	* Comment: update fb access token
	*/
	function update_fb_access_token($user_Id='',$facebookId='',$fb_access_token='',$fb_access_token_datetime='',$flag=''){
		if($user_Id!=''){
			$CI = & get_instance();		 
			$CI->load->library('facebook_library');			
			$token_update_duration =50; // In days
			$current_datetime = strtotime(date('Y-m-d h:i:s'));
			$date_diff = ($fb_access_token_datetime==''?$token_update_duration:(($current_datetime-$fb_access_token_datetime)/(24*60*60)));
			
			if($fb_access_token=='' || $date_diff >= $token_update_duration || $fb_access_token_datetime==''){
				
				$fb_access_token_temp =$CI->facebook_library->getAccessToken();
				if($fb_access_token_temp !=''){
						$fb_access_token=$fb_access_token_temp;
				}
				// url for get facebook extended token 
				$extended_token_url='https://graph.facebook.com/oauth/access_token?client_id='.FACEBOOK_APP_ID.'&client_secret='.FACEBOOK_APP_SECRET.'&grant_type=fb_exchange_token&fb_exchange_token='.$fb_access_token;
				$extended_token_data=get_data_using_curl($extended_token_url);
				$extended_token_array=explode('&',$extended_token_data);
				if(count($extended_token_array)>0){
					$fb_access_token=str_replace('access_token=','',$extended_token_array[0]);
				}
				
				$CI->db->where('user_id', $user_Id);
				$CI->db->update('user',array('facebook_id'=>$facebookId,'fb_access_token'=>$fb_access_token,'fb_access_token_datetime'=>$current_datetime));						
			}
			if($flag==''){
				//echo $fb_access_token;die;
				$CI->session->set_userdata('facebook_id',$facebookId);	
				$CI->session->set_userdata('fb_access_token',$fb_access_token);	
				$CI->session->set_userdata('fb_access_token_datetime',$current_datetime);	
			}else{
				return $fb_access_token;
			}
		}
	}
	
	
?>
