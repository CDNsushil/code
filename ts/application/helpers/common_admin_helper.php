<?php

function sha2($ciphertext)
{
    return hash('sha256', $ciphertext);
}
if(! defined('BASEPATH')) exit('No direct script access allowed');
	
	
	/* add by dhananjay singh*/	
	function neat_trim($str, $n, $delim='<span class="morestring">...</span>') {
		$tempStr='';
	   $len = strlen($str);
	   if ($len > $n) {
		   preg_match('/(.{' . $n . '}.*?)\b/', $str, $matches);
		   $tempStr= rtrim($matches[1]) . $delim;
	   }
	   else {
		   $tempStr= $str;
	   }
	   return '<span class="tooltip_n" title="'.$str.'">'.$tempStr.'</span>';
	}
	/* -------------------- */	
	
	
	
	function genret_email_verify_code($user_account_detail){
		return encode($user_account_detail.time());	
	}
	
	function set_user_language($language){
		$CI = & get_instance();
		$language	=	explode("#",$language);
		$user_id		=	logged_user_id();
		if($user_id){	
			$CI->db->set('language',$language[0]);
			$CI->db->where('user_id',$user_id);
			$CI->db->update('user');
		}
		$CI->session->set_userdata('language_code',$language[2]);
		$CI->session->set_userdata('language',$language[1]);
		$CI->session->set_userdata('language_id',$language[0]);
		$CI->config->set_item('language', $language[1]);
	}

	/* ----- get language for a user----*/
	function get_user_language(){

		$CI = & get_instance();
		//set into session for further use.
		$language	    =	array();
		$language[0]	=	$CI->session->userdata('language_id');
		$language[1]	=	$CI->session->userdata('language');
		$language[2]	=	$CI->session->userdata('language_code');
			if($language[0]=='' && $language[1]=='' ){
						$language[2]	=	$CI->config->item("default_language_code");
						$language[1]	=	$CI->config->item("default_language");
						$language[0]	=	$CI->config->item("default_language_id");
						$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
						$l = $lang[0].$lang[1];
						$language_arr = get_language_by_code($l);
						if(empty($language_arr)){
							$CI->session->set_userdata('language_code',$language[2]);
							$CI->session->set_userdata('language',trim($language[1]));
							$CI->session->set_userdata('language_id',trim($language[0]));
						}
						else{
							$CI->session->set_userdata('language_code',$language_arr[0]->language_code);
							$CI->session->set_userdata('language',trim($language_arr[0]->language));
							$CI->session->set_userdata('language_id',trim($language_arr[0]->language_id));
						}
				}
				$CI->config->set_item('language', $language[1]);
				
				$CI->language_code	=	trim($language[2]);
			 	$CI->language			=	trim($language[1]);
				$CI->language_id		=	trim($language[0]);
	
				return $language;
	}
	
	function logged_user_id(){
		$CI = & get_instance();
		$user_id	=	$CI->session->userdata("user_user_id");
		
		if($user_id){
			if(check_is_logged_user_id_exist_in_db($user_id))
			return $user_id;
		}	
			return FALSE;
	}
	
	
	function check_is_logged_user_id_exist_in_db($user_id=0){
		if($user_id){
			$read_db=''; //define new variable for read db reference
			$CI = & get_instance();
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			$CI->read_db->select('user_id');
			$CI->read_db->where('user_id',$user_id);
			$CI->read_db->from('user');
			$count_user	=	$CI->read_db->count_all_results();
			if($count_user>0)
				return TRUE;
		}
			return FALSE;		
	}
	
	function isAjax() {
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
            return true;    
        }else{
            redirect(BASEURL);    
        }
	}
	
	/**-----------------------------------------
	 * comment:Function for check user session
	 * Input:NUll
	 * Output:NUll
	 ------------------------------------------*/
	if(!function_exists('loginCheck'))
	{
	    function loginCheck()
	    {
	        $CI =& get_instance();
	        if(!$CI->session->userdata('user_user_id'))
				redirect(base_url());
	    }
	}
	
	/**
	 * Function to get carrer detail from cc_carrier table
	 */
	if(!function_exists('get_career'))
	{
	    function get_career()
	    {
			$read_db=''; //define new variable for read db reference
			$CI = & get_instance();

            /*--------------Get data from memcached-----------------*/
            $carrier_data_cached = $CI->memcached_library->get('carrier_data_cached');
            if(!$carrier_data_cached){
                $CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
                $result = $CI->read_db->get('carrier');

                /*--------------Set data into memcached-----------------*/
                $CI->memcached_library->add('carrier_data_cached',$result->result(),$CI->config->item('common_data_time'));
                return $result->result();
            }
            else
            {
                return $carrier_data_cached;
            }
	    }
	}

	function get_education_level()
	{
		$read_db=''; //define new variable for read db reference
		$CI = & get_instance();
		
        /*--------------Get data from memcached-----------------*/
        $education_level_data_cached = $CI->memcached_library->get('education_level_data_cached');
        if(!$education_level_data_cached){
            $CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
            $result = $CI->read_db->get('education_level');

            /*--------------Set data into memcached-----------------*/

            $CI->memcached_library->add('education_level_data_cached',$result->result(),$CI->config->item('common_data_time'));
            return $result->result();
        }
        else
        {
            return $carrier_data_cached;
        }
		
	}
	
	function check_image_exists($bucket_url, $filename)
	{
		$CI =& get_instance();
		$CI->load->library('plupload');
		return $CI->plupload->check_image_exists($bucket_url, $filename);
	}
	
	/*function image_exists($url)
	{
		$handle = @fopen($url,'r');
		if($handle !== false)
		{
			return true;
		}
		else
		{
			return false;
		} 
	}
	
	function user_image_exists($user_id,$profile_picture){
		$url = "assets/user_images/user_". $user_id."/profile/thumb_image/".$profile_picture;
		if(image_exists($url)){
			return BASEURL.$url;
		}else{
			return USER_PROFILE_IMAGE."default/profile/thumb_image/picture_upload.png";
		}
	}*/
	
	/**
	* Function to get time ago 
	**/
	function get_timeago($ptime,$type=''){
		$etime = time() - $ptime;
		if( $etime < 1 ){
			return 'less than 1 second ago';
		}
		$a = array(	12 * 30 * 24 * 60 * 60	=>  'year',
					30 * 24 * 60 * 60		=>  'month',
					24 * 60 * 60			=>  'day',
					60 * 60				=>  'hour',
					60					=>  'minute',
					1					=>  'second'
		);
						
		foreach( $a as $secs => $str ){
			$d = $etime / $secs;
			
			if($type==''){				
				if( $d >= 1 ){
					$r = round( $d );
					
					if($str=='day' && $r == 1 ){
						return 'Yesterday at '.date('h:i',$ptime);
					}elseif($str=='hour'||$str=='minute'||$str=='second'){
						return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
					}else{					
						return date('F j , ',$ptime).' '.date(' g:i a',$ptime);						
					}				
				}
			}else{
				if( $d >= 1 ){
					$r = round( $d );					
					if($str=='hour'){
						return true;
					}else{					
						return false;
					}				
				}				
			}
		}
	}
	
	
	//OPTIMIZE
	function get_username($user_id,$limit='',$firstname='',$lastname='')
	{
		//id firstname and lastname exist
		if($firstname !='' && $lastname !=''){			
			return ucfirst($firstname)." ".ucfirst($lastname);
		}

		
		$CI =& get_instance();
		if($user_id == $CI->session->userdata('user_user_id')){
			$firstname = $CI->session->userdata('firstname');
			$lastname = $CI->session->userdata('lastname');
			if($limit==''){
				return ucfirst($CI->session->userdata('firstname'))." ".ucfirst($CI->session->userdata('lastname'));
			}
			else{
    			return substr(ucfirst($firstname)." ".ucfirst($lastname), 0, $limit)."....";
			}
		}else{
			$username='';
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
            /*------get Mem cached data--------*/
            $username_cached = $CI->memcached_library->get('username_cached_'.$user_id);
            if(!$username_cached){             
                $CI->read_db->where('user_id',$user_id);
                $CI->read_db->select('firstname,lastname');
                $result = $CI->read_db->get('user');
                if(count($result->row()) > 0)
                {
                    $firstname 	= $result->row()->firstname;
                    $lastname 	= $result->row()->lastname;
                    if($limit==''){
                        $username = ucfirst($firstname)." ".ucfirst($lastname);
                        /*------Set Mem cached data--------*/
                        $CI->memcached_library->add('username_cached_'.$user_id,$username,$CI->config->item('memcache_username_data_time'));
                        return $username;
                    }
                    else{
                        $username = substr(ucfirst($firstname)." ".ucfirst($lastname), 0, $limit)."...";
                        /*------Set Mem cached data--------*/
                        $CI->memcached_library->add('username_cached_'.$user_id,$username,$CI->config->item('memcache_username_data_time'));
                        return $username;
                    }
                }
            }else{
               return $username_cached;
            }
            
		}
	}
	//OPTIMIZE
	
	function get_firstname($user_id)
	{
		$CI =& get_instance();

		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
        
        /*------get Mem cached data--------*/
		$firstname_cached = $CI->memcached_library->get('firstname_cached_'.$user_id);
        if(!$firstname_cached)
        {
            $CI->read_db->where('user_id',$user_id);
            $CI->read_db->select('firstname');
            $result = $CI->read_db->get('user');
            if(count($result->row()) > 0)
            {
                $firstname 	= $result->row()->firstname;
                $firstname = ucfirst($firstname);

                /*------set Mem cached data--------*/
                $CI->memcached_library->add('firstname_cached_'.$user_id,$firstname,$CI->config->item('memcache_username_data_time'));//set data into memcache
                return $firstname;
            }
        }
        else
        {
            return $firstname_cached;
        }
	}
    
	/*-----Get user location from db using user id-------*/
	function get_location($user_id)
	{
		$CI =& get_instance();
        
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
        /*------get Mem cached data--------*/
        $user_location_data_cached = $CI->memcached_library->get('user_location_data_cached_'.$user_id);
        if(!$user_location_data_cached)
        {
            $sql = "SELECT cc_city.city_name,cc_state.state_name FROM cc_user_profile 
                    INNER JOIN cc_city ON cc_city.city_id	=	cc_user_profile.city_id
                    INNER JOIN cc_state ON	cc_state.state_id	=	cc_user_profile.state_id 
                    WHERE cc_user_profile.user_id = '".$user_id."'
                    " ;
            $result = $CI->read_db->query($sql);
            if(count($result->row()) > 0)
            {
                $city 	= $result->row()->city_name;
                $state 	= $result->row()->state_name;
                $return = ucfirst($city).", ".ucfirst($state);
                $CI->memcached_library->add('user_location_data_cached_'.$user_id,$return,$CI->config->item('memcache_user_location_data_time'));
                return $return;
            }
        }
        else
        {
            return $user_location_data_cached;    
        }
	}
	
    /*-----Get point of a user from db using user id-------*/
	function get_points($user_id,$duration="")
	{
		$CI =& get_instance();
		$CI->load->model('user_profile');
		return round($CI->user_profile->get_user_points($user_id,$duration));
	}
	
	
    /*-----Get username of a user from db using user id-------*/
	function get_user($user_id)
	{
		$CI =& get_instance();
        /*---- Get data from memcache -----*/
		$user_name_data_cached = $CI->memcached_library->get('user_name_data_cached_'.$user_id);
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
        if(!$user_name_data_cached)
        {
            $CI->read_db->where('user_id',$user_id);
            $CI->read_db->select('username');
            $result = $CI->read_db->get('user');
            if(count($result->row()) > 0)
            {
                $return = $result->row()->username;
                /*---- Set data to memcache -----*/
                $CI->memcached_library->add('user_name_data_cached_'.$user_id,$return,$CI->config->item('memcached_username_data_time'));
                return $return;
            }
        }
        else
        {
            return $user_name_data_cached;
        }
	}
	
	/*-------------------------------------------
	| For face book posts
	-------------------------------------------*/
	
	function getPostedSince($time2,$time1)
	{
		$difference = $time2 - $time1;
		$diffSeconds = $difference;
		$days = intval($difference / 86400);
		$difference = $difference % 86400;
		$hours = intval($difference / 3600);
		$difference = $difference % 3600;
		$minutes = intval($difference / 60);
		$difference = $difference % 60;
		$seconds = intval($difference);
		
		$retrun='';
		
		if($days>0)
		{
			$retrun = "$days Day";
			if($days>1)
				$retrun.= "s";
			return $retrun.' Ago';
		}	
		elseif($hours>0)
		{
			$retrun.= " $hours Hour";
			if($hours>1)
				$retrun.= "s";
			return $retrun.' Ago';			
		}	
		elseif($minutes>0)
		{
			$retrun.= " $minutes Minute";
			if($minutes>1)
				$retrun.= "s";
			return $retrun.' Ago';			
		}	
		elseif($seconds>0)
		{
			$retrun.= " $seconds Second";
			if($seconds>1)
				$retrun.= "s";
			return $retrun.' Ago';			
		}	
		return $retrun;
	}
	
    
    /* function to get user wall link for a user */
    function get_username_with_link($user_id,$linking=true)
	{
		$CI =& get_instance();

		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
        
        /*---- Get data from memcache -----*/
		$user_name_with_link_cached = $CI->memcached_library->get('user_name_with_link_cached_'.$user_id);
        if(!$user_name_with_link_cached)
        {
            $CI->read_db->where('user_id',$user_id);
            $CI->read_db->select('firstname,lastname');
            $result = $CI->read_db->get('user');
            if(count($result->row()) > 0)
            {
                $firstname 	= $result->row()->firstname;
                $lastname 	= $result->row()->lastname;
                $full_name	=	ucfirst($firstname)." ".ucfirst($lastname);
                if($linking == false)
                {
					return $full_name;
				}
                if(strlen($full_name) > 8)
                {
                    $name 	= 	substr($full_name,0,6)." ..";
                }
                else
                {
                    $name	=	$full_name;
                }
                $user_name = "<a href='{base_url}user_wall/get_wall/".encode($user_id)."'>".$name."</a>";
                
                /*---- Set data to memcache -----*/
                $CI->memcached_library->add('user_name_with_link_cached_'.$user_id,$user_name,$CI->config->item('memcached_username_data_time'));
                return $user_name;
            }
        }
        else
        {
            return $user_name_with_link_cached;    
        }
	}

    /*function to get user_id with respect to email id*/
	function get_user_id($email)
	{
		$CI =& get_instance();
        $user_id = logged_user_id();
		$read_db=''; //define new variable for read db reference
        
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
        /*---- Get data from memcache -----*/
		$user_id_by_email_cached = $CI->memcached_library->get('user_id_by_email_cached_'.$user_id);
        if(!$user_id_by_email_cached)
        {
            $CI->read_db->where('email',$email);
            $q = $CI->read_db->get('user');
            if($q->num_rows() > 0)
            {
                $return = $q->row()->user_id;
                /*---- Set data into memcache -----*/
                $CI->memcached_library->add('user_id_by_email_cached_'.$user_id,$return,$CI->config->item('memcached_username_data_time'));
            }
            else
            {
                /*---- Set data into memcache -----*/
                $CI->memcached_library->add('user_id_by_email_cached_'.$user_id,$return,$CI->config->item('memcached_username_data_time'));
                $return = false;
            }
            return $return;
        }//memcache if
        else
        {
            return $user_id_by_email_cached;
        }
	}
	
	/**
	 * Function to clean up html tags and return string
	 */
	if(!function_exists('stripHTMLtags'))
	{
		function stripHTMLtags($str)
		{
			$t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
			$t = htmlentities($t, ENT_QUOTES, "UTF-8");
			return $t;
		}
	}
	/**
	 * Function to check that user state is comes under incentive program or not, and show alert pop up acordingly
	 */
	if(!function_exists('is_under_incentive'))
	{	
		function is_under_incentive($user_id)
		{
			if($user_id != "")
			{
				$CI = & get_instance();
				
				$read_db=''; //define new variable for read db reference
				$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
				$sql = "SELECT `cc_user_profile`.`state_id`, `cc_state`.`is_under_incentive_program`
						FROM (`cc_user_profile`)
						JOIN `cc_state` ON `cc_state`.`state_id` = `cc_user_profile`.`state_id`
						WHERE `cc_user_profile`.`user_id` =  '".$user_id."'
						AND `cc_user_profile`.`is_register_for_points` != 1
						AND (last_alert <=DATE_SUB(CURDATE(),  INTERVAL (7)  DAY )
						OR `last_alert` =  ''
						OR `last_alert` =  '0000-00-00') ";
				
				$query = $CI->read_db->query($sql);
				if($query->num_rows() > 0)
				{
					if($query->row()->is_under_incentive_program == 1)
					{
						$CI->db->where('user_id',$user_id);
							$data	=	array(
							'last_alert'	=>	date('Y-m-d')
							);
						$CI->db->update('user_profile',$data);
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
			}
		}
	}
	
	/**
	 * 
	 */
	if(!function_exists('update_under_incentive'))
	{	
		function update_under_incentive($user_id)
		{
			if($user_id != "")
			{
				$CI = & get_instance();
				
				$CI->db->where('user_id',$user_id);
				$data	=	array(
					'last_alert'	=>	date('Y-m-d'),
					'is_register_for_points' => 1
				);
				$CI->db->update('user_profile',$data);
				return true;
			}
		}
	}
	
	/**
	 *  get user email
	 */
	 
        function get_email($user_id)
        {
            if($user_id != "")
            {
                $CI = & get_instance();		

                $read_db=''; //define new variable for read db reference
                $CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
                
                /*---- Get data from memcache -----*/
                $email_data_cached = $CI->memcached_library->get('email_data_cached_'.$user_id);
                if(!$email_data_cached){
                    $CI->read_db->where('user_id',$user_id);
                    $CI->read_db->select('email');
                    $q = $CI->read_db->get('user');
                    $return = @$q->row()->email;
                    /*---- Set data into memcache -----*/
                    $CI->memcached_library->add('email_data_cached_'.$user_id,$return,$CI->config->item('memcached_username_data_time'));
                    return $return;
                }
                else
                {
                    return $email_data_cached;
                }
            }
        }
		
	/*
	* Function to get album name by album id
	*/
	function get_album_name_by_id($album_id)
	{
		$CI 		 = & get_instance();
		$read_db	 = ''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		/*---- Get data from memcache -----*/
        $album_name_by_id_cached = $CI->memcached_library->get('album_name_by_id_cached_'.$album_id);
        
		if (!$album_name_by_id_cached) {
            $CI->read_db->where('album_id',$album_id);
            $CI->read_db->select('album_name');
            $CI->read_db->limit(1);
            $query 		= $CI->read_db->get('album');
            $result 	= $query->row();
            $album_name = $result->album_name;
            $CI->memcached_library->add('album_name_by_id_cached_'.$album_id,$album_name,$CI->config->item('memcache_user_report_data_time'));
            return $album_name;
        }
        else
        {
           return $album_name_by_id_cached;    
        }
	}
	
	// Function for get report status 	
	 function get_report_arr( $post_id_comma_sap = array(), $user_id='', $post_type_id_comma_sap = '' )
	 {
	    $CI 					 =	& get_instance();
	    $post_type_id_arr = array();
		 $post_id_arr 		 = explode(',',$post_id_comma_sap);
		 
		if (!empty($post_type_id_comma_sap)) {
			$post_type_id_arr 		= 		explode(',',$post_type_id_comma_sap);
		}
		
	 	$read_db		 =	''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable

			 $CI->read_db->where('user_id',$user_id);
          $CI->read_db->where('report_for_type',$post_type);

        if(!empty($post_id_arr)){
            $CI->read_db->where_in('report_for_id',$post_id_arr);
        }

            $report_num = $CI->read_db->get('report')->num_rows();
            if($report_num > 0) $return = true;else $return = false;
       
		
		
		}//end of like deslike array by post id
		
			

	
	/**
	* function to check if report is submitted
	**/
	function check_user_report($user_id,$post_id,$post_type){
		$CI = & get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
        
        /*---- Get data from memcache -----*/
		$check_user_report_cached = $CI->memcached_library->get('check_user_report_cached_'.$user_id.'_'.$post_id.'_'.$post_type);
        if(!$check_user_report_cached){
            $CI->read_db->where('user_id',$user_id);
            $CI->read_db->where('report_for_type',$post_type);
            $CI->read_db->where('report_for_id',$post_id);
            $report_num = $CI->read_db->get('report')->num_rows();
            if($report_num > 0) $return = true;else $return = false;
            /*---- Set data memcache -----*/
            $CI->memcached_library->add('check_user_report_cached_'.$user_id.'_'.$post_id.'_'.$post_type,$return,$CI->config->item('memcache_user_report_data_time'));
            return $return;
        }else{
            return $check_user_report_cached;     
        }
	}
	
	function getUserProfile($user_id,$status=0)
	{
	//OPTIMIZE
		if(!$status){
			$CI = & get_instance();
			
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			$CI->read_db->select('user_id');
			$CI->read_db->where('user_id',$user_id);
			$result = $CI->read_db->get('user');
			if($result->num_rows() > 0)
			{
				return BASEURL."user_wall/get_wall/".encode($user_id);
			}	 
			else
			{
				return BASEURL."profile";
			}
		}else{ 
				return BASEURL."user_wall/get_wall/".encode($user_id);
		}
		//OPTIMIZE
	}	
	
	/*
	* @Input: email function parameters with message
	* @Output: True or False
	* @access	public
	* Comment: This function send email to user
	*/
	function send_email($from,$from_name,$to,$subject,$message)
	{
		$CI = & get_instance();
		$CI->email->from($from,$from_name);
		$CI->email->to($to);
		$CI->email->subject($subject);
		$CI->email->message($message);

		if($CI->email->send())
		{
			return true;
		}
		else
		{
			return false;
		}
	}	

	
	/*
	| Function for get active frequency friends
	*/
	function get_active_user_frequency($user_id){
		$CI = & get_instance();
	
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
	
		$query 	 =" SELECT count(comment.user_id) as freq,wall.user_id AS Friend_id ,user.facebook_id ,ac.datetime";	
		$query	.=" FROM cc_action AS ac";		
		$query	.=" INNER JOIN cc_wall AS wall ON ac.post_record_id =wall.wall_id";				
		$query	.=" INNER JOIN cc_users_comments AS comment ON ac.post_record_id =comment.post_id";				
		$query	.=" INNER JOIN cc_user AS user ON user.user_id =wall.user_id";				
		$query	.="	WHERE wall.user_id!='".$user_id."' AND ac.post_type_id='2' AND comment.user_id='".$user_id."' AND ac.datetime >= '".date('Y-m-d h:i:s',mktime(0,0,0,date('m'),date('d')-15,date('Y')))."' ";		
		$query	.="	group by wall.user_id ORDER BY freq DESC,ac.datetime DESC";
		$commentResult=$CI->read_db->query($query);
		$commentResult =$commentResult->result();	
		$CI->session->set_userdata('friend_frequency',$commentResult);
	}
	
	function get_user_friends($user_id,$all='')
	{
	
		if($user_id!="")
		{
			$CI = & get_instance();
			
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			$status = "";
            if($all==1){
                $status = ' OR f1.status=0';
            } 			
			
			 $sql = "SELECT DISTINCT cc_user.user_id as friend_id,cc_user_profile.profile_picture as pic, cc_user.firstname as fname, cc_user.lastname as lname, f1.relationship_status, f1.relation_from, f1.relation_to,f1.status,f1.friends_id as f_id,f1.from_user_id,f1.to_user_id, cc_user.sex,cc_user.facebook_id, cc_city.city_name,cc_state.state_name 
					FROM cc_friends f1 
					JOIN cc_user_profile on cc_user_profile.user_id=(CASE 
						WHEN f1.from_user_id='".$user_id."' THEN f1.to_user_id
						WHEN f1.to_user_id='".$user_id."' THEN f1.from_user_id
						END) 
					JOIN cc_user on cc_user.user_id=(CASE 
						WHEN f1.from_user_id='".$user_id."' THEN f1.to_user_id
						WHEN f1.to_user_id='".$user_id."' THEN f1.from_user_id
						END) 
					LEFT JOIN cc_city ON cc_city.city_id	=	cc_user_profile.city_id
					LEFT JOIN cc_state ON	cc_state.state_id	=	cc_user_profile.state_id 
					WHERE (f1.from_user_id='".$user_id."' or f1.to_user_id='".$user_id."' ) AND cc_user.published=1 AND f1.status=1 $status group by cc_user.user_id";	

			$query = $CI->read_db->query($sql);
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
			else
			{
				return array();
			}	
		}
		else
		{
			return array();
		}		
	}

	function get_friends_birthday($user_id)
	{
		if($user_id!="")
		{
			$CI = & get_instance();
			
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			
			$friend_list = get_user_friends($user_id);
			
			if(count($friend_list) > 0)
			{
				$friend_ids = ''; $i=1;
				foreach($friend_list as $friend_data)
				{
					if(count($friend_list)==1)
					$friend_ids .= " user_id = ".$friend_data->friend_id." ";
					else
					{
						if(count($friend_list) == $i)
						$friend_ids .= " user_id = ".$friend_data->friend_id." ";
						else 
						$friend_ids .= " user_id = ".$friend_data->friend_id." OR ";
					}	
					$i++;
				}
				
				$sql1 = "SELECT dob as birthday, user_id as friend_id, firstname, lastname FROM cc_user 
					WHERE DATE_FORMAT(`dob`, '%m%d') >= DATE_FORMAT(NOW(), '%m%d') 
					AND DATE_FORMAT(`dob`, '%m%d') <= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 7 DAY), '%m%d') 
					AND (".$friend_ids.")
					ORDER BY DATE_FORMAT(`dob`, '%m%d') ASC";		
				
				$query1 = $CI->read_db->query($sql1);
				if($query1->num_rows() > 0)
				{
					return $query1->result();
				}
				else
				{
					return false;
				}
			}
		}
	}
	
//OPTIMIZE
	/**
	* Function to get user friend list 
	* @input user_id, $all =1 to get all firends having request pending or approve
	* @output object of friend list or blank ar rayu in case of  no friend or error
	*
	*/
	function get_user_friends_name($user_id,$all='')
	{
		if($user_id!="")
		{
			$CI = & get_instance();
			
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			
			$status = "";
            if($all==1){
                $status = ' OR f1.status=0';
            } 		
			$sql = "SELECT DISTINCT cc_user.user_id as friend_id, cc_user.firstname as fname
					FROM cc_friends f1 
					JOIN cc_user on cc_user.user_id=(CASE 
						WHEN f1.from_user_id='".$user_id."' THEN f1.to_user_id
						WHEN f1.to_user_id='".$user_id."' THEN f1.from_user_id
						END) 
					WHERE (f1.from_user_id='".$user_id."' OR f1.to_user_id='".$user_id."') AND f1.status=1 $status";	

			$query = $CI->read_db->query($sql);
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
			else
			{
				return array();
			}	
		}
		else
		{
			return array();
		}	
	}
	
	/*
	 *  Function to get loop name of the user if exist in the any loop
	 **/
    function get_friend_loops ($session_user_id, $user_id='') 
	{
		$CI = & get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
        /*----Get memcache data-----*/
        $friends_loop_data_cached = $CI->memcached_library->get('friends_loop_data_cached_'.$session_user_id.'_'.$user_id);
        if(!$friends_loop_data_cached){
            $CI->read_db->select('sublist.sublist_name');
            $CI->read_db->from('sublist_member_list');
            $CI->read_db->distinct('sublist_member_list.sublist_id');
            $CI->read_db->group_by('sublist_member_list.sublist_id');
            $CI->read_db->where('sublist_member_list.member_user_id',$user_id);
            $CI->read_db->where('sublist.user_id',$session_user_id);
            $CI->read_db->join('sublist','sublist.sublist_id=sublist_member_list.sublist_id','left');
            $result = $CI->read_db->get();
            if($result->num_rows() > 0 )
            $return = $result->result();
            else $return = false;
            /*----Set memcache data-----*/
            $CI->memcached_library->add('friends_loop_data_cached_'.$session_user_id.'_'.$user_id,$return,$CI->config->item('memcache_friend_loop_data_time'));
            return $return;
        }
        else
        {
            return $friends_loop_data_cached;    
        }
    }	
    
    /*
     * Function for get top earner
     * */
     function get_top_network_earners()
	 {
		$CI = & get_instance();
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$user_id = logged_user_id();
        /*----Get memcache data-----*/
        $top_network_earners_data_cached = $CI->memcached_library->get('top_networks_earners_data_cached_'.$user_id);
        if(!$top_network_earners_data_cached)
        {
            $CI->read_db->where('parent_level.parent_id',$user_id);
            $CI->read_db->select('SUM(cc_point.point) as points');
            $CI->read_db->select('cc_parent_level.user_id as user_id');
            $CI->read_db->from('parent_level');
            $CI->read_db->join('point','point.user_id=parent_level.user_id','INNER');
            $CI->read_db->group_by('user_id');
            $CI->read_db->order_by('points','desc');
            $CI->read_db->limit(10);
            $result = $CI->read_db->get();
            $return = $result->result(); 
             /*----Set memcache data-----*/
            $CI->memcached_library->add('top_networks_earners_data_cached_'.$user_id,$return,$CI->config->item('memcache_top_network_data_time'));
            return $return;
        }//memcached if
        else
        {
           return $top_network_earners_data_cached;     
        }
	}
	
	
	/*
     * Function for get network total point
     * */
     function get_top_network_total_point()
	 {
		$CI = & get_instance();
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$user_id = $CI->session->userdata('user_user_id');  
		$CI->read_db->where('parent_level.parent_id',$user_id);
		$CI->read_db->select('SUM(cc_point.point) as points');		
		$CI->read_db->from('parent_level');
		$CI->read_db->join('point','point.user_id=parent_level.user_id');
		$result = $CI->read_db->get();
		$return = $result->row(); 		
		if(count($return)>0){ 
			return $return->points;        
		}else{
			return 0;
		}
	}
	
	
	 /*
     * Function for get top earner
     * Parameter : level - 1 for first
     * 					   2 for second
     * 					   3 for third
     * 					   4 for fourth
     * 					   5 for fifth
     * 					   6 for sixth
     * */
    function chatching_level_network($level='',$type='All')
	{
		$CI = & get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$user_id = $CI->session->userdata('user_user_id');
        /*----Get memcache data-----*/
        $chatching_level_network_data_cached = $CI->memcached_library->get('chatching_level_network_data_cached_'.$user_id.'_'.$level);
		if(!$chatching_level_network_data_cached)
        { 
            $CI->read_db->where('parent_level.parent_id',$user_id);            
			$CI->read_db->select('SUM(cc_point.point) as points');
            $CI->read_db->select('cc_parent_level.parent_id,cc_parent_level.level,cc_parent_level.user_id as user_id,cc_user_profile.profile_picture,cc_user.sex,cc_user.firstname,cc_user.lastname,cc_city.city_name,cc_state.state_name');
            $CI->read_db->from('parent_level');	
            $CI->read_db->join('point','point.user_id=parent_level.user_id','INNER');	
            $CI->read_db->join('user','parent_level.user_id=user.user_id','INNER');
            $CI->read_db->join('user_profile','user_profile.user_id=user.user_id','INNER');
            $CI->read_db->join('city','user_profile.city_id=city.city_id','LEFT');
            $CI->read_db->join('state','state.state_id=city.state_id','LEFT');
            $CI->read_db->order_by('cc_user.user_id','random');
            $CI->read_db->group_by('parent_level.user_id');
            if($level!=''){				
				$CI->read_db->where('cc_parent_level.level',$level);
				$CI->read_db->limit('2');
			}
            $result = $CI->read_db->get();
            $level_user_result=$result->result();
           /*-------------------------*/
            if(count($level_user_result)>0){
				if($level_user_result[0]->user_id==0){
					$level_user_result=array();
				}
			}
          
            /*----Set memcache data-----*/
            $CI->memcached_library->add('chatching_level_network_data_cached_'.$user_id.'_'.$level,$level_user_result,$CI->config->item('memcache_chatching_level_data_time'));	
            return $level_user_result; 
        }
        else
        {
            return $chatching_level_network_data_cached;
        }
	}
	
	
    function get_sublist_members($list_id=0){
		/*last update by dhananjay on 8 august*/
		if($list_id){
			$CI = & get_instance();
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			$user_id = logged_user_id();
			/*----Get memcache data-----*/
			$sublist_members_data_cached = $CI->memcached_library->get('sublist_members_data_cached_'.$list_id);
			if(!$sublist_members_data_cached){    
				$CI->read_db->select('*');
				$CI->read_db->from('sublist_member_list');
				$CI->read_db->limit(12);
				$CI->read_db->where('sublist_member_list.sublist_id',$list_id);
				$return_data = $CI->read_db->get()->result();
				/*----Set memcache data-----*/
				$CI->memcached_library->add('sublist_members_data_cached_'.$list_id,$return_data,$CI->config->item('memcache_private_loop_member_data_time'));
				return $return_data;
			}
			else
			{
				return $sublist_members_data_cached;    
			}
		}else{
				return array();
		}
	}
	
	function get_distinct_loop_members($loop_arr){
		$CI = & get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$where ='';
		$i=1;
		foreach($loop_arr as $loop_id){					
			if(count($loop_arr)>1){
				$where .= ' sublist_id='.$loop_id.' OR ';
			}if($i == count($loop_arr)){
				$where .= ' sublist_id='.$loop_id;
			}elseif(count($loop_arr)==1){
				$where .= ' sublist_id='.$loop_id;
			}	
			$i++;
		}
	 	$query = 'SELECT DISTINCT(member_user_id) FROM cc_sublist_member_list WHERE '.$where;
		$result = $CI->read_db->query($query)->result();
		//print_r($result);die;
		$memeber_ids = ''; 		
		$j=1;
		foreach($result as $member_id){
			if(count($result)>0){
				$memeber_ids .= $member_id->member_user_id.',';			
			}
			$j++;	
		}
		return $memeber_ids.$CI->session->userdata('user_user_id');
	}
	
		/**
		Function to get loop name of the user if exist in the any loop
	**/
	function check_user_loop ($user_id='') {
		$CI = & get_instance();
		$facebook_sublist=array();
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		/*----Get memcache data-----*/
        $memcache_user_loop_data_cached = $CI->memcached_library->get('memcache_user_loop_data_cached_'.$user_id);
        if(!$memcache_user_loop_data_cached){
            $CI->read_db->select('sublist.sublist_name,sublist.sublist_id');
            $CI->read_db->from('sublist');
            $CI->read_db->distinct('sublist.sublist_id');
            $CI->read_db->group_by('sublist.sublist_id');
            $CI->read_db->where('sublist.user_id',$user_id);
            $CI->read_db->or_where('sublist.status',1);
            $result = $CI->read_db->get();
            if($result->num_rows() > 0 ){
				$return_data = $result->result();
				/*--------Get fb sublist------*/
				/*if($CI->session->userdata('facebook_id')>0){
					try{	
							
							$fb_data =get_data_using_curl('https://graph.facebook.com/me/friendlists&access_token='.$CI->session->userdata('fb_access_token'));					
							$facebook_sublist = json_decode($fb_data);
							$facebook_sublist =(isset($facebook_sublist->data)?(array)$facebook_sublist->data:array());
					}catch(exception $e){						
						echo "<script>jAlert('Facebook not responding.','Error!');</script>";
						$facebook_sublist=array();									
					}
				}
				if (count($facebook_sublist) > 0){			
					foreach($facebook_sublist as $fb){
						$fb_to_cc = new stdClass;						
						$fb_to_cc->sublist_id 		=	$fb->id;
						$fb_to_cc->sublist_name		=	$fb->name;							
						
						$return_data[]=$fb_to_cc;
					}
				}*/
				//echo "<pre>";print_R($return_data);die;
				/*----------------------------*/
			}else{
				 $return_data = false;
			}
            /*----Set memcache data-----*/
            $CI->memcached_library->add('memcache_user_loop_data_cached_'.$user_id,$return_data,$CI->config->item('memcache_private_loop_member_data_time'));
            return $return_data;
        }
        else
        {
            return $memcache_user_loop_data_cached;   
        }
	}

	function is_incentive_user($user_id)
	{
		if($user_id!="")
		{
			$CI = & get_instance();
			
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			/*----Get memcache data-----*/
            $incentive_user_data_cached = $CI->memcached_library->get('incentive_user_data_cached_'.$user_id);
            if(!$incentive_user_data_cached){
                $CI->read_db->where('cc_user_profile.user_id',$user_id);
                $CI->read_db->select('user_profile.is_register_for_points');
                $CI->read_db->from('user_profile');
                $query	=	$CI->read_db->get();
                if($query->num_rows()>0)
                {
                    $result = $query->result();
                    $return_data = $result[0]->is_register_for_points;
                    /*----Set memcache data-----*/
                    $CI->memcached_library->add('incentive_user_data_cached_'.$user_id,$return_data,$CI->config->item('memcache_incentive_data_time'));
                    return $return_data;
                }
                else
                {
                    $return_data = false;
                    /*----Set memcache data-----*/
                    $CI->memcached_library->add('incentive_user_data_cached_'.$user_id,$return_data,$CI->config->item('memcache_incentive_data_time'));
                    return $return_data;
                }
            }//memcache if
            else
            {
                return $incentive_user_data_cached;    
            }
		}
	}
	
	function get_session_user_id()
	{
		$CI = & get_instance();
		return $CI->session->userdata('user_user_id');
	}


	/**
	* Function for check friend for user group	
	*/
	function validate_user_section_album( $viewed_user_id, $section_id ) {
	    $CI 		=	 & get_instance();
		$read_db	=	''; //define new variable for read db reference
	    $privacy_val = 0;
		
		$CI->read_db 	 = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable				
		$logged_user_id = $CI->session->userdata('user_user_id');
  		$CI->read_db->where("user_id",$viewed_user_id);
  		$CI->read_db->where("privacy_loop !=",$privacy_val);
		$CI->read_db->select("album_id,privacy_loop");
		$CI->read_db->from("album");
		$result_album_array =	$CI->read_db->get();
		if (( $result_album_array->num_rows() ) > 0 ) {
			// Check login use is available in group for view user 
				
		}
	 	die;
			 		
	}
	
	/*
	 * Comment :- Function for validate user section for other user
	 * Param :- viewed profile userId , section Id
	 * */
	 function validate_user_section($viewed_user_id,$section_id){
		 $CI = & get_instance();
		 $read_db=''; //define new variable for read db reference
		 $CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		 
		 $logged_user_id =$CI->session->userdata('user_user_id');
		 //Check user privacy setting available or not
		 $CI->read_db->from('cc_user_account_permission ');
		 $CI->read_db->where('cc_user_account_permission.user_id',$viewed_user_id);
		 $user_result =$CI->read_db->get();
		 if(($user_result->num_rows())>0){
			 
			 $CI->read_db->from('cc_user_account_permission ');
			 $CI->read_db->join('cc_sublist_member_list','cc_sublist_member_list.sublist_id=cc_user_account_permission.loop_id');
			 $CI->read_db->where('cc_sublist_member_list.member_user_id',$logged_user_id);
			 $CI->read_db->where('cc_user_account_permission.user_id',$viewed_user_id);
			 $CI->read_db->where('cc_user_account_permission.section_id',$section_id);
			 $result =$CI->read_db->get();
			 if(($result->num_rows())>0){
				 return true;
			 }else{
				 /*
				  * Check user in friend list or not
				  * */
				 $query  = " SELECT permission_id FROM cc_user_account_permission AS permisson ";			 
				 $query .= " WHERE (SELECT count(friends_id) FROM cc_friends WHERE ((from_user_id='".$viewed_user_id."' AND to_user_id='".$logged_user_id."') or (from_user_id='".$logged_user_id."' AND to_user_id='".$viewed_user_id."') ) AND  status='1' )>'0'";
				 $query .= " AND permisson.user_id='".$viewed_user_id."'";
				 $query .= " AND permisson.section_id='".$section_id."'";
				 $query .= " AND permisson.loop_id='2'";			 
				 
				 $friendResult =$CI->read_db->query($query);
				 if(($friendResult->num_rows())>0){
					return true;
				 }else{
					   /*
						* Check user  public permission
						* */
						 $CI->read_db->from('cc_user_account_permission ');					 					 
						 $CI->read_db->where('user_id',$viewed_user_id);
						 $CI->read_db->where('section_id',$section_id);	 
						 $CI->read_db->where('loop_id','1');	 
									 
						 $publicResult =$CI->read_db->get();
						 if(($publicResult->num_rows())>0){
							return true;
						 }
				}
				
                /*---- privacy setting for individual album ----*/
                $album_access = Modules::run('privacy/check_privacy_for_album',$logged_user_id,$viewed_user_id);
                if($album_access && $section_id==1){
                    return TRUE;    
                }
				return false;
			 }
		 }else{
			 return true;
		 }
			 
	 }
	 
	 /*
	  * Function for get limited text string
	  * */
	 function get_limit_string($string,$length){
		 $strLength = strlen($string);
		 return ($strLength >$length ? substr($string,0,$length)."...":$string);
	 }
	/*
	 * Function for get message attachment
	 * */
	 function get_message_attachment_list($msg_id){
		$CI = & get_instance();
			
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
        
        /*----Get memcache data-----*/
        $message_attach_data_cached = $CI->memcached_library->get('message_attach_data_cached_'.$msg_id);
        if(!$message_attach_data_cached)
        { 
			$CI->read_db->where('msg_id',$msg_id);			
			$CI->read_db->from('message_attachment');
			$query	=	$CI->read_db->get();
			if($query->num_rows()>0)
			{
				$result = $query->result();
				$attachmentList="";
				foreach($result as $attch){
					$attachmentList = "<div class='messageAttachment'><a href='".$attch->filepath."'>".$attch->filename."</a></div>";
				}
                /*----Set memcache data-----*/
                $CI->memcached_library->add('incentive_user_data_cached_'.$msg_id,$attachmentList,$CI->config->item('memcache_incentive_data_time'));
				return $attachmentList;
			}
			else
			{
                /*----Set memcache data-----*/
                $CI->memcached_library->add('incentive_user_data_cached_'.$msg_id,'',$CI->config->item('memcache_incentive_data_time'));
				return '';
			}
        }//memcache if
        else
        {
            return $message_attach_data_cached;    
        }
	 }
	 
	 
	 /*
	  * Function for check new incoming message
	  * */
	  function new_incoming_message_check(){
		 	$CI = & get_instance();
			
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			
		 	$user_id= $CI->session->userdata('user_user_id');
			$CI->read_db->where('to',$user_id);			
			$CI->read_db->where('viewed','0');			
			$CI->read_db->from('messages');
			$query	=	$CI->read_db->get();
			if($query->num_rows()>0)
			{				
				return 'message_tip';
			}
			else
			{
				return '';
			}
	  }
	  
	  /*
	  * Function for get total count of photos with respect to album Id
	  * */
	  function get_total_photo($album_id)
	  {
		$CI = & get_instance();

		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
        /*----Get memcache data-----*/
        $message_attach_data_cached = $CI->memcached_library->get('album_total_photo_data_cached_'.$album_id);
        if(!$message_attach_data_cached){ 
            $CI->read_db->where('album_id',$album_id);
            $query	=	$CI->read_db->get('media');
            $return_data = $query->num_rows();   
            /*----Set memcache data-----*/
            $CI->memcached_library->add('album_total_photo_data_cached_'.$album_id,$return_data,$CI->config->item('memcache_album_data_time'));
            return $return_data;
        }
        else
        {
            return $message_attach_data_cached;
        }
     }
	  
	/**
	* funciton to get photo count 
	* @input album_id, media_type
	* @output media count
	**/
	function get_media_count($user_id=0,$album_id=0,$media_type='')
	{	
		$CI = & get_instance();

		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
	
		if($user_id){
			$CI->read_db->select('count(media_id) as media_count');
			$CI->read_db->where(array('user_id'=>$user_id));
			if($album_id)
				$CI->read_db->where(array('album_id'=>$album_id));
			if($media_type != '')
				$CI->read_db->where(array('media_type'=>$media_type));
			
			$query = $CI->read_db->get('media');
			return $query->row()->media_count;
		}else{
			return 0;
		}
	}
	  /*
       * get all language for the footer language dropdown
       * */
	  function get_all_language(){
		$CI = & get_instance();
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
        /*-----Get memcached data--------*/
		$all_language_data_cached = $CI->memcached_library->get('all_language_data_cached');
        if(!$all_language_data_cached){
            $lang = $CI->read_db->get('language');
            $return_data = $lang->result();
            /*-----Set memcached data--------*/
            $CI->memcached_library->add('all_language_data_cached',$return_data,$CI->config->item('memcache_all_language_data_time'));
            return $lang->result(); 
        }
        else
        {
            return $all_language_data_cached;    
        }
	}
	
	function get_session_language(){
		$CI = & get_instance();
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		return "english";die;
		if($user_id = $CI->session->userdata('user_user_id')){
			//OPTIMIZE
				//$user_id = $CI->session->userdata('user_user_id');
			//OPTIMIZE
			$lang = $CI->session->userdata('lang');
			if($lang!=''){
				return strtolower($lang);
			}else 
			if(get_cookie('lang_id')!=''){
				$lang_id = get_cookie('lang_id');
				//set_user_language($lang_id,$user_id);
				return strtolower(get_cookie('lang'));
			}
			$CI->read_db->select('language.language as lang,language.language_id as lang_id');
			$CI->read_db->from('language');
			$CI->read_db->join('user','user.language = language.language_id');
			$CI->read_db->where('user.user_id',$user_id);
			$language = $CI->read_db->get()->row();
			$CI->language_id = @$language->lang_id; 
			$CI->language = @$language->lang; 
			return @$language->lang;
		}else{
		    $setCookielang  = get_cookie('lang');
		    $setCookielangId= get_cookie('lang_id');
		    if($setCookielang){	
			    $CI->language_id = $setCookielangId; 
			    $CI->language    = $setCookielang;
			    return strtolower($setCookielang);
	         }else{
	             $CI->language_id = 1; 
			     $CI->language    = 'english';
			     return 'english';
			 }
		}
	}
	
	/*function set_user_language($lang_id,$user_id){
		$CI = & get_instance();
		$CI->db->set('language',$lang_id);
		$CI->db->where('user_id',$user_id);
		return $CI->db->update('user');
	}*/
	
	function is_regPage(){
		$baseurl = base_url().'account/register';
		$cururl = curPageURL();
		
		$result = ($baseurl == $cururl) ? true : false;
		return $result;
	}
	function curPageURL() {
	 $pageURL = 'http';
	 if (isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
}

	function get_activity_thread($date)
	{
		$CI = & get_instance();

		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$user_id = $CI->session->userdata('user_user_id');
		$CI->read_db->where('user_id',$user_id);
		$CI->read_db->where('CAST(datetime AS DATE) =',$date);
		$CI->read_db->select('*');
		$CI->read_db->select('SUM(point) as total_activity_point');
		$CI->read_db->select('count(cc_point.activity_id) as activity_count');
		$CI->read_db->select('CAST(datetime AS DATE) as dateonly');
		$CI->read_db->from('point');
		$CI->read_db->join('activity','activity.activity_id=point.activity_id','INNER');
		$CI->read_db->group_by('activity.activity_id');
		$result = $CI->read_db->get(); 
		$queryObj = $result->result();
		$data = "";
		foreach($queryObj as $activity)
		{
		  if($activity->friend_id != $activity->user_id)
		  {
			$data  .= 	$activity->activity_name." <span class='greentxt'>".substr(get_username($activity->friend_id),0,13)."</span>,"; 
		  }
		}
		if($data != "")
		{
			return substr($data, 0, -1);
		}
		else
		{
		    return "No activity by friend";	
		}
	}
	/**
	* Function to get members of a group	
	**/
	function get_group_members($group_id){
		$CI = & get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
        /*-----Get memcached data--------*/
		$get_group_member_data_cached = $CI->memcached_library->get('get_group_member_data_cached_'.$group_id);
        if(!$get_group_member_data_cached){
            $CI->read_db->select('group_member.user_id,group_member.group_id');
            $CI->read_db->from('group_member');
            $CI->read_db->where('group_member.group_id',$group_id);
            $CI->read_db->limit(3);
            $return_data = $CI->read_db->get();
            /*-----Set memcached data--------*/
            $CI->memcached_library->add('get_group_member_data_cached_'.$group_id,$return_data,$CI->config->item('memcache_group_member_data_time'));
            return $return_data;
        }
        else
        {
            return $get_group_member_data_cached;
        }
	}
		
	/**
	* Function to check if a user member of a group	
	**/
	function check_user_group($group_id){
		$CI = & get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		$CI->read_db->where('group_id',$group_id);
		$CI->read_db->where('user_id',$CI->session->userdata('user_user_id'));
		$count = $CI->read_db->count_all_results('group_member');
		if($count > 0)
			return true;
		else return false;		
	}
	
	function get_first_image($url) 
	{
	   $content = '';
	    $ch = curl_init();
	    curl_setopt ($ch, CURLOPT_URL, $url);
	    curl_setopt ($ch, CURLOPT_HEADER, 0);
	    ob_start();
	    curl_exec ($ch);
	    curl_close ($ch);
	    $content = ob_get_contents();
	    //$content = file_get_contents();
	    $first_img = '';
	    ob_end_clean();
	    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
	    if(count($matches[1])>0) {
			$first_img = $matches[1][0]; 	  	
	    	if(substr($first_img,0,4)!="http"){
	 			 $first_img = $url.'/'.$matches[1][0];
	 		}
	    }
	    $title = get_title($content);
	    return $first_img.','.$title;
	}
	
	function get_title($content){
	    if(strlen($content)>0){
	        preg_match("/\<title\>(.*)\<\/title\>/",$content,$title);
	        if($title>0)
	        	return $title[1];
	        else return '';	
	    }
	}
	
		  /*************** Group Functions **************/
	  
	  /*
	  * Function to get total members of the group
	  */
	  function get_group_total_members($group_id)
	  {
		$CI = & get_instance();
        $read_db=''; //define new variable for read db reference
        $CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
        
        /*------Get data into memcache-----------*/
		$group_member_total_data_cached = $CI->memcached_library->get('group_member_total_data_cached_'.$group_id);
        if(!$group_member_total_data_cached){
            $CI->read_db->where('group_id',$group_id);
            $query	=	$CI->read_db->get('group_member');
            $return_data = $query->num_rows();

            /*------Set data into memcache-----------*/
            $CI->memcached_library->add('group_member_total_data_cached_'.$group_id,$return_data,$CI->config->item('memcache_group_member_data_time'));
        }
        else
        {
            return $group_member_total_data_cached;
        }
	  }
	  
	   /*
	  * Function to get members of the group
	  */
	  function group_members($group_id)
	  {
		$CI = & get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$CI->read_db->where('group_id',$group_id);
		$query	=	$CI->read_db->get('group_member');
		return $query->result();
	  }
	  
	  /*
	  * Function to get group profile of the group
	  */
	  function get_group_profile($group_id)
	  {
		return BASEURL."group/group_detail/".$group_id;
	  }
	  
      
      function get_group_name($group_id){
          if($group_id!=''){
              $CI = & get_instance();
              $read_db=''; //define new variable for read db reference
              $CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
              $CI->read_db->where('group_id',$group_id);
              $CI->read_db->select('group_name');
              $result	=	$CI->read_db->get('group');
              if($result->num_rows()>0){
                  return $result->row()->group_name;
              }else{ return FALSE;}
          }else{
              return FALSE;  
          }  
      }
	
	/*
	 * funtion for check permissin for requested page in ADmin Section
	 * */
	 function check_permission_for_requested_page(){
		 $CI = & get_instance();
		 $session_data =$CI->session->userdata('session_data');
		 $user_role =$session_data['user_role'];
		 $flag =true;
		 
		 if(@$CI->uri->segment(3)=="dashboard"){
			 $flag=validate_admin_section("dashboard");
		 }
		 
		 if(@$CI->uri->segment(2)=="advert" && $flag ==true){
			 $flag=validate_admin_section("advert");
		 }
		 if(@$CI->uri->segment(3)=="manage_states" && $flag ==true){
			 $flag=validate_admin_section("manage_states");
		 }			
		 if(@$CI->uri->segment(1)=="admin_message" && $flag ==true){
			 $flag=validate_admin_section("admin_message");
		 }				
		 if(@$CI->uri->segment(1)=="admin_users" && $flag ==true){
			 $flag=validate_admin_section("admin_users");
		 }		
		 if(@$CI->uri->segment(1)=="admin_manage_content" && $flag ==true){
			 $flag=validate_admin_section("admin_manage_content");
		 }	
		 if(@$CI->uri->segment(3)=="get_all_reports" && $flag ==true){
			 $flag=validate_admin_section("get_all_reports");
		 }		
		 if(@$CI->uri->segment(1)=="admin_mail" && $flag ==true){
			 $flag=validate_admin_section("admin_mail");
		 }		
		 if(@$CI->uri->segment(1)=="admin_point" && $flag ==true){
			 $flag=validate_admin_section("admin_point");
		 }	
		 if(@$CI->uri->segment(3)=="view_user_activity" && $flag ==true){
			 $flag=validate_admin_section("view_user_activity");
		 }					
		 if(@$CI->uri->segment(1)=="admin_user_content_status" && $flag ==true){
			 $flag=validate_admin_section("admin_user_content_status");
		 }	
		 	
		 if(@$CI->uri->segment(1)=="admin_privacy_setting" && $flag ==true){
			 if($user_role!=1){
				$flag=false;
			 }
		 }	
		
		
		 if(@$CI->uri->segment(3)=="view_support_q_a" && $flag ==true){
			 $flag=validate_admin_section("view_support_q_a");
		 }				
			
		
		if($flag==false){
			redirect(base_url().'admin_statistics');
		}
		
		
	 }
	 
	 

	

	/** functiom created to encode userid in url**/
	 function get_encode_id($userid)
	{
		$userid=encode($userid);
		return $userid;
	}

	/** End of functiom created to encode userid in url**/

	/** functiom created to decode userid **/
	function get_decode_id($userid)
	{
		$userid=decode($userid);
		return $userid;
	}  

	 
	/*
	* furntion to check is user below age 
	*  call from firend module when user send or resive firend request
	*/
	
	function is_below_age($user_id){
		$CI = & get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$CI->read_db->select('age,dob');
		$CI->read_db->where('user_id',$user_id);
		$result = $CI->read_db->get('cc_user');
		if($result){
				$age = $result->row()->age;
				if($age =='' && $result->row()->dob != '0000-00-00'){
					 $age = get_age_by_dob($result->row()->dob);
					return ($age != 0 && $age < 18) ?  true : false;
				}else if((int)$age >=18) return false;
				 else return true;
			
		}else return false;
	}
	/*
	* function to calculate age from date of birth
	**/
	function get_age_by_dob($dob) {

		list($y,$m,$d) = explode('-', $dob);
	   
		if (($m = (date('m') - $m)) < 0) {
			$y++;
		} elseif ($m == 0 && date('d') - $d < 0) {
			$y++;
		}
	   
		return date('Y') - $y;
	   
	}  

	/*image resize method*/
	function resizeImage($filename,$newRunTimeWidth,$newRunTimeHeight){
		//header('Content-type: image/jpeg');
		// Get new dimensions
		list($width, $height) = getimagesize($filename);
		if($width>$height){
			$new_width	=	$newRunTimeWidth;
			$new_height =  $height 	* ((($newRunTimeWidth*100)/$width)/100);
		}
		
		if($width<$height){
			$new_height=	$newRunTimeWidth;
			$new_width = 	$width 	* ((($newRunTimeHeight*100)/$height)/100);
		}
		
		
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($filename);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		// Output
		echo imagejpeg($image_p, null, 100);
	}  
	  
	/*
	 * Comment :- Function for validate admin section for other user
	 * Param :- viewed profile userId , section Id
	 * */
	 function validate_admin_section($section){
		 $CI = & get_instance();
		 
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		 
		 $session_data =$CI->session->userdata('session_data');
		 $user_role =$session_data['user_role'];
		 
		 if($user_role==1){
			 return true;
		 }
        $CI->read_db->select('section_id');
        $CI->read_db->where('section_name',$section);
        $section_Result=$CI->read_db->get('cc_admin_section');
        if($section_Result->num_rows() >0){
            $section_id = $section_Result->row()->section_id;
            
             $CI->read_db->from('cc_admin_account_permission');				 
             $CI->read_db->where('section_id',$section_id);
             $CI->read_db->where('user_role',$user_role);
             
             $result =$CI->read_db->get();
             
             if(($result->num_rows())>0){
                 return true;
             }else{
                 return false;
             }
         }				 		 
	 }	  
	  
	/*---------------------------------------------------------
	| Function for get parent user
	---------------------------------------------------------*/
	function is_parent($user_id)
	{
		$CI = & get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$parent_min_date = date('Y-m-d',strtotime('-18 year'));
		$CI->read_db->select('cc_user.email,cc_user.dob');
		$CI->read_db->from('cc_user');
		$CI->read_db->where('user_id',$user_id);
		$CI->read_db->where('dob <=',$parent_min_date);
		$query = $CI->read_db->get();
		$res1 = $query->result();
		$res = $query->num_rows();
		if($res==1){
			$CI->read_db->select('cc_user.email');
			$CI->read_db->from('cc_user');
			$CI->read_db->where('parent_email',$res1[0]->email);
			$query1 = $CI->read_db->get();
			$num_rows = $query1->num_rows();
				if($num_rows >0){return 1;}
				else{return 0;}
			}
  	}
  	
  	/*---------------------------------------------------------
	| Function to find friend relationship like Mother, Father, Brother, Sister etc...
	* @Input: friend_id (Primary Key of friend table)
	* 		   user_id (Logged in user Id)
	* 		   relation_id (Primary key of cc_friend_relation)
	-----------------------------------------------------------*/
  	 function send_friend_relation_request($friend_id,$user_id,$relation_id)
  	 {
		 $CI = & get_instance();

		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		 
		 $CI->read_db->where('friends_id',$friend_id);
		 $query = $CI->read_db->get('friends');
		 $db_from_id = $query->row()->from_user_id;
		 $db_to_id = $query->row()->to_user_id;
		 
		 $relation_from = "";
		 $relation_to = "";
		 $mail_send_to = "";
		 if($user_id == $db_from_id)
		 {
			 $relation_status = 1; // Request send by from_user_id
			 $relation_from = $relation_id;
			 $mail_send_to = $db_to_id;
		 }
		 else if($user_id == $db_to_id)
		 {
			 $relation_status = 2; // Request send by to_user_id
			 $relation_to = $relation_id;
			 $mail_send_to = $db_from_id;
		 }
		 
		 $data = array(
				'relationship_status' 	=>	$relation_status,
				'relation_from'		=>	$relation_from,
				'relation_to'		=>	$relation_to	
			);
		 $CI->db->where('friends_id',$friend_id);
		 $CI->db->update('friends',$data);
		 return $mail_send_to;
	 } 

	/*---------------------------------------------------------
	| Function to accept friend relationship request like Mother, Father, Brother, Sister etc...
	* @Input: friend_id (Primary Key of friend table)
	* 		   user_id (Logged in user Id)
	* 		   relation_id (Primary key of cc_friend_relation)
	---------------------------------------------------------*/
  	 function accept_friend_relation_request($friend_id,$relation_id) 
  	 {
		 $CI = & get_instance();
		 
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		 
		 $CI->read_db->where('friends_id',$friend_id);
		 $query = $CI->read_db->get('friends');
		 $relationship_status = $query->row()->relationship_status;
		 
		 $relation_to = $query->row()->relation_to;
		 $relation_from = $query->row()->relation_from;
		 
		 $from_user_id = $query->row()->from_user_id;
		 $touser_id = $query->row()->to_user_id;
		 
		 if($relationship_status == 1)
		 {
			 $relation_to  = $relation_id;
		 }
		 else if($relationship_status == 2)
		 {
			 $relation_from  = $relation_id;
		 }
		 
		 // relationship_status = 3 means request accepted
		 $data = array(
			'relationship_status' 	=>	3,
			'relation_from'		=>	$relation_from,
			'relation_to'		=>	$relation_to	
		 );
		 $CI->db->where('friends_id',$friend_id);
		 $CI->db->update('friends',$data);
		 
		 $CI->load->library('point_calculation');
		 /**---------------------------------------------------------
		 * Comment:for point calculation  						
		 * activity type  16 : special friends
		 * ---------------------------------------------------------**/							
		 $CI->point_calculation->add_point($from_user_id,$CI->config->item('_activity_special_friend_'),'',$touser_id);
		//$CI->point_calculation->add_point($from_user_id,16,0);
		 
		 
		  
		 return true;
	 } 
	 
	 function show_relation_dropdown()
	 {
		 $CI = & get_instance();
		 
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		 
		 $q = $CI->read_db->get('friend_relation');
		 return $q->result(); 
	 }
	 
	 function get_relation($relation_id)
	 {
		 if($relation_id)
		 {
			 $CI = & get_instance();
			 
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			 
			 $CI->read_db->where('id',$relation_id);
			 $q = $CI->read_db->get('friend_relation');
			 return $q->row()->relation; 
		 }
		 else
		 {
			 return "";
		 }
	 } 
	 
	 function get_unselected_theme_list($theme_id=0){
		 $CI = & get_instance();
		 
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		 
		 if($theme_id > 0){
			  $CI->read_db->where('id',$theme_id);
		 }
		
		 $CI->read_db->select('file_name');		
		 $CI->read_db->where('status',1);
		 $result = $CI->read_db->get('themes');
		 return $result_array= $result->result(); 		 
	 } 


	function getLatestMsg($id)
	{
		$CI = & get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$CI->read_db->where('to',$id);
		$CI->read_db->select('message,created');
		$CI->read_db->order_by('created','desc');
		$query = $CI->read_db->get('cc_messages');
		$result = $query->result();
		return $result;
	}
	
	//Function to check if giver string is have urlfunction isValidURL($url)
	/*function check_url($url){	
		preg_match_all('!https?://[\S]+!', $url, $matches);
		$all_urls = $matches[0];

	}*/
	
	/**
	 * Make clickable links from URLs in text.
 	*/
	function make_clickable($text) {
	  return preg_replace_callback(
	    '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', 
	    create_function(
	      '$matches',
	      'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
	    ),
	    $text
	  );
	}

	if(! function_exists('getDataFromTabel')){
		function getDataFromTabel($table='', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='ASC', $limit=0, $offset=0, $resultInArray=false ){
			$CI =& get_instance();
			$res =  $CI->model_common->getDataFromTabel($table, $field,  $whereField, $whereValue, $orderBy, $order, $limit, $offset, $resultInArray );
			return $res;
		}
	}
	
	/*-------function to check notification for user-------*/
		function check_notification($to_user_id,$notification_type_id) {
			$CI = & get_instance();
			
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			
			$CI->read_db->select('*');
			$CI->read_db->from('notification_setting');
			$CI->read_db->where('user_id',$to_user_id);
			$CI->read_db->where('notification_type_id',$notification_type_id);
			$CI->read_db->where('status','1');
			$query = $CI->read_db->get();
			$res = $query->result();
			return $res;
		}
	/*-----------------*/
	
	/*
	* @Access:public
	* @Input:registrant email, registrant user Id
	* @Output: 
	* Comment: This function insert all invitation to friend table with status zero, so that all invitation shows on the Chatching 
	* friend section after registration.
	*/
	function is_invitation()
	{
		$CI =& get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$user_id = $CI->session->userdata('user_user_id');
		$email = $CI->session->userdata('user_email');
		
		$CI->read_db->select('user_id');
		$CI->read_db->from('friend_invites');
		$CI->read_db->where('invite_email',$email);
		$query = $CI->read_db->get();
		
		$CI->read_db->select('user_id');
		$CI->read_db->from('incentive_request');
		$CI->read_db->where('email_to',$email);
		$query1 = $CI->read_db->get();
		
		if($query->num_rows() > 0 || $query1->num_rows() > 0 )
		{
			$res = $query->result();
			$res1 = $query1->result();
			$result = array_merge($res,$res1);
			return $result; 
		}
	}
	
	function check_parent_exist()
	{
		$CI =& get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$user_id = $CI->session->userdata('user_user_id');
		$CI->read_db->select('parent_id');
		$CI->read_db->where('user_id',$user_id);
		$r = $CI->read_db->get('user');
		if($r->row()->parent_id == 0)
			return true;
		else
			return false;
	}
	
	
	/*
	* @Access: public
	* Comment: This function get all activity for any particular date
	*@param 
	*@return database object 
	*/
	function get_activity_detail($date)
	{
		if($date != "")
		{
			$CI =& get_instance();
			
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			
			$user_id = $CI->session->userdata('user_user_id');
			$CI->read_db->where('CAST(datetime AS DATE)=',$date);
			$CI->read_db->where('user_id',$user_id);
			$CI->read_db->select('cc_activity.activity_name,cc_point.friend_id');
			$CI->read_db->from('point');
			$CI->read_db->join('activity','activity.activity_id=point.activity_id','INNER');
			$CI->read_db->group_by('point.activity_id');
			$result = $CI->read_db->get(); 
			return $result->result();
		} 
	}

	/*
	* @Access: public
	* Comment: Get unread  messages count
	*@param 
	*@return message count
	*/
	function get_unread_message_count($user_id='')
	{
		$CI =& get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		if($user_id==''){
			$user_id = $CI->session->userdata('user_user_id');
		}
		
		$CI->read_db->where('viewed','0');						
		$CI->read_db->where('to_delete','0');			
		$CI->read_db->where('to',$user_id);			
		$result=$CI->read_db->get('messages');		
		return count($result->result());			
	}

	/* Comment: This function gets carrier name by ID
	*@param 
	*@return database object 
	*/
	function get_carrier_by_id($id)
	{
		$CI =& get_instance();
		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		$CI->read_db->select('carrier_name');
		$CI->read_db->from('carrier');
		$CI->read_db->where("carrier_id", $id); 
		$query =  $CI->read_db->get();	
			
			return $query->result(); 		
	}
	/*
	* End of common_helper.php
	*/
	
	
	/*
	 * funtion for check permissin for requested page in User Section
	 * */
	 function check_permission_for_requested_page_on_userprofile(){
		 
		 $CI = & get_instance();	
		 
		 /*------------viewer get user id-----------------------*/	
		 	 	
			if($CI->uri->segment(1)=='message' || $CI->uri->segment(1)=="opensocial"){
			 	$user_id=$CI->session->userdata('user_user_id');			 	
			}else{
				
				if($CI->uri->segment(1) && $CI->uri->segment(1) == "profile" && $CI->uri->segment(2) && $CI->uri->segment(2) == "manage_page"){					
					// condition for profile sections of logged in user 
					$user_id=$CI->session->userdata('user_user_id');					
				}else if($CI->uri->segment(1) && $CI->uri->segment(1) == "album" && $CI->uri->segment(4)){					
					$user_id=decode($CI->uri->segment(4));
				}else if($CI->uri->segment(3) && is_numeric($CI->uri->segment(3)) && $CI->uri->segment('1')!="loop" && $CI->uri->segment('1')!="group" && $CI->uri->segment('2')!="record_month"){								
					$user_id=decode($CI->uri->segment(3));					
				}else{					
					$user_id=$CI->session->userdata('user_user_id');					
				}
			}
		 /*-----------------------------------------------------*/		 
			 if($user_id != $CI->session->userdata('user_user_id')){
				 $flag =true;			 
				
				 if(@$CI->uri->segment(1)=="user_wall"){
					 $flag=validate_user_section($user_id,2);
				 }
				 
				 if(@$CI->uri->segment(1)=="friend_list" && $flag==true){
					 $flag=validate_user_section($user_id,3);
				 }
				
				 if(@$CI->uri->segment(1)=="profile" && $flag==true){
					 $flag=validate_user_section($user_id,4);
				 }
				
				 if(@$CI->uri->segment(1)=="album" && $flag==true){
					 $flag=validate_user_section($user_id,1);
				 }
				
				if($flag==false){
					redirect(base_url().'profile');
				}
			}
		
	 }
	 
	function search_mutual($user_id,$login_user_id)   
	{

			// Get login user friends list

			$login_user_friends = get_friends_list($login_user_id);

			// Get search friends list
			$search_friends = get_friends_list($user_id);
			
			if(count($login_user_friends) > 0 && count($search_friends) > 0)
			{
				
				$array1 = objectToArray($login_user_friends);
		   	$array2 = objectToArray($search_friends);

				$result_array = array_intersect_assoc($array1, $array2);
				return $result_array;
			}
		

		 //   $view_data['page_type'] = "";
		//	$this->template->load('template', 'profilepage',$view_data);
	}//end of search_mutual
		
	/**
	 * Function for Get mutual friends list
	 */
	 function get_friends_list($user_id)
	 {
	 			$CI =& get_instance();
	 				
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		
		 $CI->read_db->select('to_user_id');
		 $CI->read_db->from('friends');
		 $CI->read_db->where('from_user_id',$user_id);
		 $CI->read_db->where('status','1');
		
		 $myfriends = $CI->read_db->get();
	
		 return $myfriends->result();
	 }//end of get_friends_list
	 
	function objectToArray($object)
	{
		$array=array();
		foreach($object as $obj)
		{
			$array[]=$obj->to_user_id;
		}
		return $array;
	}	
		
		
	/*-------------------------------------------------------- Code for auto updater -----------------------------------------------------------------------*/	
	/*
	* @Access: public
	* @Input:  user_id
	* @Output: true or false
	* Comment: This function get user file name
	*/
	function get_user_file_name($user_id=''){
		$user_range_for_file=1000;
		
		/*--------------Check which file belong user id  -------------*/
		$file_flag  = intval($user_id/$user_range_for_file);
		$file_name  = "user_".($file_flag*$user_range_for_file)."_".($file_flag*$user_range_for_file+($user_range_for_file-1)).".php";
		$file_path  = str_replace("index.php","",$_SERVER['SCRIPT_FILENAME'])."nodeSys/user_data/";
		$file_path .= $file_name;
		
		return $file_path;
	}//end of get_user_file_name
	/*
	* @Access: public
	* @Input:  action type,item id ,user_id ,
	* @Output: true or false
	* Comment: This function save user action in txt file
	*/
	function save_user_updates($action_type='',$id='',$user_id=''){
		/*try{ 
			$CI = & get_instance();		
			if($user_id == ''){
				$user_id =$CI->session->userdata('user_user_id');		
			}
			
			$db = new  SQLite3($CI->config->item('auto_updater_db_path'));
			$current_date=date("Ymd");	
				
			$results = $db->query('SELECT user_id,data,data_date FROM updater where user_id="'.$user_id.'"');			
			$user_data =array();
			$flag=2;
			
			if($results){
				$row = $results->fetchArray();							
				if(is_array($row)){
					$user_data =json_decode($row['data']);
					$flag=1;
				}
			}
			if(count($user_data)>0){
					$user_data = new RecursiveArrayIterator($user_data); 					
			}	
			
			if($id==''){
				/*---------------delete data-------------------/				
				unset($user_data[$action_type]);
			}else{
				/*---------------Make new data-------------------/	
                if(array_key_exists($action_type,$user_data)){
                    if(!in_array($id,$user_data[$action_type])){
                        $user_data[$action_type][]= $id;			
                    }
                }
			}
			
			$user_data = json_encode($user_data);
			/*------------------Update DB---------------------/
			$loopflag=false;	
		
			while($loopflag==false){
				try{
					if($flag==2){
						//$query_result = $db->exec("INSERT INTO updater (user_id,data,data_date) VALUES('".$user_id."','".$user_data."','".$current_date."') ");						
					}else{				
						//$query_result = $db->exec("UPDATE  updater SET data='".$user_data."',data_date='".$current_date."'  WHERE user_id='".$user_id."' ");		

					}
					$loopflag=true;
				}catch(exception $e){}
			}

		}catch(exception $e){
			//print_r($e);
		}
		
		/*
		
		$file_path= get_user_file_name($user_id);
		
		/*--------------Check  file exist or not  -------------/		
		if(!file_exists($file_path)){
			write_file($file_path, '');			
		}
		
		/*-------------- read data in file  -------------/
		$file_data =read_file($file_path);
		
		if($file_data != ""){
			$file_data =json_decode($file_data,true);
		}else{
			$file_data=array();
		} 
		if($id==''){
			/*---------------delete data-------------------/
			unset($file_data[date("Ymd")][$user_id][$action_type]);
		}else{
			/*---------------Make new data-------------------/
			@$file_data[date("Ymd")][$user_id][$action_type][]= $id;
		}
		$file_data = json_encode($file_data);
		
		$writeflag =true;
		while($writeflag == true){
			try{
				/*-------------- put data in file  -------------/
				write_file($file_path, $file_data);
				$writeflag =false;
			}catch(exception $e){ }
		}*/
	}//end of save_user_updates
	

	/*
	* @Access: public
	* @Input:  user_id ,action type =('ticker'= 1,)
	* @Output: true or false
	* Comment: This function write updater data  
	*/
	function reset_user_updates($user_id,$array,$type){
		if($user_id !='' && is_array($array) && $type!=''){
			/*$db = new  SQLite3($CI->config->item('auto_updater_db_path'));
			$current_date=date("Ymd");	
				
			$results = $db->query('SELECT user_id,data,data_date FROM updater where user_id="'.$user_id.'"');			
			$user_data =array();
			$flag=2;
			
			if($results){
				$row = $results->fetchArray();							
				if(is_array($row)){
					$user_data =json_decode($row['data']);
					$flag=1;
				}
			}
			if(count($user_data)>0){
					$user_data = new RecursiveArrayIterator($user_data); 					
			}
			$user_data[$action_type]=array();	
			$query_result = $db->exec("UPDATE  updater SET data='".$user_data."',data_date='".$current_date."'  WHERE user_id='".$user_id."' ");		
		*/
			//$file_path				= 	get_user_file_name($user_id);				
			//$array[$user_id][$type]	=	array();
			//write_file($file_path,$array);
		}		
	}//end of reset_user_updates
    /*--------------------------------------------------------End of Code for auto updater -----------------------------------------------------------------------*/	
    /*
	* @Access: public
	* @Input:  email_id
	* @Output: true or false
	* Comment: This function check the valid email address syntax  
	*/
    function check_valid_email($email){
        $reg_exp = '/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is';    
        if(preg_match($reg_exp,$email)) return TRUE;
        else return FALSE;
    }//end of check_valid_email
    
    
    /*
	* @Access: public
	* @Input:  user_id
	* @Output: user account link
	* Comment: This function return link
	*/
    function get_user_link($user_id){
        return BASEURL."user_wall/get_wall/".encode($user_id);
    }//end of get_user_link
    
    //OPTIMIZE
    /* @Access: public
     * @ function: get_user_currunt_time_zone_by_ip
	 * @ About	 : get user currunt time zone by IP
	 * @ param	 : null
	 * @ Output  : timeZone array
	 * */
	function get_user_current_time_zone_by_ip($my_ip=''){
		/* $CI = & get_instance();		
		$time_zone_array = $CI->session->userdata('time_zone_array');
		if((!is_array($time_zone_array)) || (!isset($time_zone_array['countryName']))){		
			date_default_timezone_set('America/Los_Angeles'); return ;
			try{
				if($my_ip=='') {	
					if (!empty($_SERVER['HTTP_CLIENT_IP'])){   //check ip from share internet				
					  $my_ip=$_SERVER['HTTP_CLIENT_IP'];
					}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){  //to check ip is pass from proxy				
					  $my_ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
					}else{
					  $my_ip=$_SERVER['REMOTE_ADDR'];
					}
				} 
				
			
			}catch(exception $e){		
				// default time zone setting			
				$time_zone_array =array('ipAddress'=>$_SERVER['REMOTE_ADDR'],'countryCode'=>'UM7','timeZone'=>'-07:00');
				$CI->session->set_userdata('time_zone_array',$time_zone_array);				
			}	
		}
		// set time zone
		if(!empty($time_zone_array['countryCode']) and $time_zone_array['countryCode'] != '-'){
			$timeZones = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $time_zone_array['countryCode']);
			if(count($timeZones)>0){
				date_default_timezone_set($timeZones[0]);
			}
		}*/
	}//end of get_user_current_time_zone_by_ip
	//OPTIMIZE
	
	/* @Access: public
	 * @ function: timezone_array
	 * @ About	 : get country code
	 * @ param	 : timezone
	 * @ Output  : countryCode 
	 * */
	function timezone_array($tz='') {
		$zones = array(
		"-12:00"=>		'UM12',
		"-11:00" =>	    'UM11',
		"-10:00"=>	    'UM10' ,
		"-09:00"=>		'UM9'  ,
		"-08:00"=>		'UM8',
		"-07:00"=>		'UM7',
		"-06:00"=>		'UM6',
		"-05:00"=>		'UM5',
		"-04:00"=>		'UM4',
		"-03:30"=>	    'UM35',
		"-03:00"=>		'UM3',
		"-02:00"=>		'UM2',
		"-01:00"=>		'UM1',
		"+01:00"=>	    'UP1',
		"+02:00"=>	    'UP2',
		"+03:00"=>	    'UP3' ,
		"+03:30"=>	    'UP35',
		"+04:00"=>	    'UP4'    ,
		"+04:30"=>	    'UP35',
		"+05:00"=>	    'UP5'   ,
		"+05:30"=>	    'UP55',
		"+06:00"=>	    'UP6'    ,
		"+07:00"=>	 	'UP7',
		"+08:00"=>	    'UP8',
		"+09:00"=>	    'UP9',
		"+09:30"=>	    'UP95',
		"+10:00"=>	    'UP10',
		"+11:00"=>	    'UP11',
		"+12:00"=>	    'UP12'
		);
		return ( ! isset($zones[$tz])) ? 0 : $zones[$tz];
	}//end of timezone_array
	
	
	/**
	 * Function for like deslike array by post id
	 */
	 function get_likes_deslikes($post_id_comma_sap=array(),$user_id='',$post_type_id_comma_sap='')
	 {
	    $post_type_id_arr = array();
		$post_id_arr = explode(',',$post_id_comma_sap);
		if(!empty($post_type_id_comma_sap)){
			$post_type_id_arr = explode(',',$post_type_id_comma_sap);
		}
		$CI =& get_instance();
	 	$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		$CI->read_db->select('post_id,like_dislike');
        if(!empty($post_id_arr)){
            $CI->read_db->where_in('post_id',$post_id_arr);
        }

        if(!empty($post_type_id_arr)){
            $CI->read_db->where_in('post_type',$post_type_id_arr);
        }
		$CI->read_db->where('user_id',$user_id);
		return $CI->read_db->get('users_like_dislike');
		}//end of like deslike array by post id
		
		
	  /**
		* Function for get album name
		*/
		function get_album_name($album_array)
		{

				// New added code l start ( OPTIMIZE)
					$counter = 0;	
					
					foreach($album_array as $img) {
						if(isset($img['album_id'])) {
							$album_id_counter[$counter] = $img['album_id'];
						}
						$counter++;
					}
					
					if(isset($album_id_counter)){
						$album_id_arr = array_unique($album_id_counter);
						$result_album = get_album_array($album_id_arr); // get album name by album id from getimage_helper 

						foreach($result_album as $album_str)
						{
							$img_arr[$album_str->album_id] 				= $album_str->album_id;
							$img_arr_name[$album_str->album_id]['name'] = $album_str->album_name;
						}
					}
					// New added code  l  end
		}

		
		function getUserFbAccessToken($user_id)
		{	
			$CI = & get_instance();								
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			$CI->read_db->select('facebook_id,fb_access_token,fb_access_token_datetime');
			$CI->read_db->where('user_id',$user_id);
			$result = $CI->read_db->get('user');
			if($result->num_rows() > 0){
				return $result->row();
			}else{
				return array();
			}
		}	

		/**
		* Function for check min profile data to award point :  Task no: 1912
		*/
		function check_profile_info()
		{
			$CI =& get_instance();
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			$user_id =$CI->session->userdata('user_user_id');
			$CI->read_db->select('country_id,state_id,home_phone,education_level_id,political_affiliation,general_interests,favorite_movies,favorite_singers,favorite_actors,favorite_authors,favorite_tv_shows,favorite_drinks,favorite_cousine,favorite_vacation');
			$CI->read_db->where('user_id',$user_id);
			$r =  $CI->read_db->get('user_profile');
			if($r->num_rows() > 0)
			{
				if($r->row()->country_id != '' && $r->row()->state_id != '' &&  $r->row()->home_phone != '')
				{
					$mobile ="";
					$carrier = "";
					$phone_array = json_decode($r->row()->home_phone);
                                        
                                        if(count($phone_array) > 0)
                                        { 
                                            foreach ($phone_array as $this_phone) {
                                                $mobile = $this_phone->number;
                                                
                                                $temp_pc = $this_phone->phone_carrier;
                                                $carrier = $temp_pc[0]->carrier;
                                            }
					}
					if($mobile != "" && $carrier != "")
					{
						$i = 0;
						if($r->row()->political_affiliation != '')
								$i++;
						if($r->row()->general_interests != '')
								$i++;
						if($r->row()->favorite_movies != '')
								$i++;
						if($r->row()->favorite_singers != '')
								$i++;
						if($r->row()->favorite_actors != '')
								$i++;
						if($r->row()->favorite_authors != '')
								$i++;
						if($r->row()->favorite_tv_shows != '')
								$i++;
						if($r->row()->favorite_drinks != '')
								$i++;
						if($r->row()->favorite_cousine != '')
								$i++;
						if($r->row()->favorite_vacation != '')
								$i++;
						if($i >= 3)  // check for minimum 3 interest fields
						{
							return true;
						}
					}
					else
					{
						return false;
					}
							
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
			
		}
  function get_gallery_image_helper($media_id, $user_id, $album_id, $type, $action_category_id='')
	{
		
		$CI =& get_instance();
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		$user_id =$CI->session->userdata('user_user_id');

		$CI->read_db->select('media_id, media_name,media_text');
		if($action_category_id != 1)
		{
			if($type==1)
			{
				$CI->read_db->where(array('media_id >'=>$media_id, 'album_id'=>$album_id, 'category_record_id'=>$user_id, 'action_category_id'=>$action_category_id));
			}
			else if($type==2)
			{
				$CI->read_db->where(array('media_id <'=>$media_id, 'album_id'=>$album_id, 'category_record_id'=>$user_id, 'action_category_id'=>$action_category_id));
			}
		}
		else
		{
			if($type==1)
			{
				$CI->read_db->where(array('media_id >'=>$media_id, 'album_id'=>$album_id, 'user_id'=>$user_id, 'post_user_id'=>$user_id, 'action_category_id'=>$action_category_id));
			}
			else if($type==2)
			{
				$CI->read_db->where(array('media_id <'=>$media_id, 'album_id'=>$album_id, 'user_id'=>$user_id, 'post_user_id'=>$user_id, 'action_category_id'=>$action_category_id));
			}
		}
		if($type == 1)
		$CI->read_db->order_by('media_id','asc');
		else if($type == 2)
		$CI->read_db->order_by('media_id','desc');
		
		$CI->read_db->limit(1);
		
		$query = $CI->read_db->get('media');
		
		if($query->num_rows()>0)
		{
			$result = $query->result();
			return $result;
		}
		else return false;
	}
	
	function cc_points_format($point){
		return (INT)$point;
	}
			
	function get_user_and_flag_type_for_privacy(){
			$CI =& get_instance();
			$flag = 2;
			
			/*
			 * check if message section call then remove userId
			 * */
			if($CI->uri->segment(1)=='message' || $CI->uri->segment(1)=='my_network'  || $CI->uri->segment(1)=="opensocial" || $CI->uri->segment(1)=='search_user')
			{
			 	$user_id		=	$CI->session->userdata('user_user_id');			 	
			}
			else
			{
				if($CI->uri->segment(1)=='user_wall' && $CI->uri->segment(3)){
					$user_id		 =	decode($CI->uri->segment(3));
					$flag = 1; 
				}elseif($CI->uri->segment(1)=='user_wall'){					
					$user_id	=	$CI->session->userdata('user_user_id');
					$flag 	=  2;
				}elseif($CI->uri->segment(1) && $CI->uri->segment(1) == "profile" && $CI->uri->segment(2) && $CI->uri->segment(2) == "manage_page")
				{
					// condition for profile sections of logged in user 
					$user_id	=	$CI->session->userdata('user_user_id');
					$flag 	= 2;									
				}else if($CI->uri->segment(1) && $CI->uri->segment(1) == "album" && $CI->uri->segment(4))
				{
					$user_id	=	decode($CI->uri->segment(4));
					if($user_id	==$CI->session->userdata('user_user_id')){
						$flag = 2; 
					}else{
						$flag = 1; 
					}
				}				
				else if($CI->uri->segment(3) && $CI->uri->segment('1')!="loop" && $CI->uri->segment('1')!="group" && $CI->uri->segment('2')!="record_month")
				{				
					$user_id		 =	decode($CI->uri->segment(3));
					if($user_id != $CI->session->userdata('user_user_id')){
						$flag = 1;  
					}else{
						$flag = 2;
					}
				}
				else
				{
					$user_id	=	$CI->session->userdata('user_user_id');
					$flag 	=  2;
				}
			}
			
			return array('user_id'=>$user_id,'flag'=>$flag);
	}
	
	
	function check_privacy_setting_for_site(){
		$CI =& get_instance();
		$site_page_array =array(
							'get_wall'=>'2',
							'friend_list'=>'3',
							'album'=>'1',
							'profile'=>'4'
						);
		$result_user =get_user_and_flag_type_for_privacy();
		$user_id=$result_user['user_id'];
		$page =$CI->uri->segment(1);			
		if($CI->session->userdata('user_user_id')!=$user_id && array_key_exists($page,$site_page_array)){			
			if(!validate_user_section($user_id,$site_page_array[$page])){			
				redirect(BASEURL.'user_wall/news_feeds');
			}
		}
	}
	/*
	 * This function is used to get all the record of donated point by user
	 * @param: date
	 * @output: record array, if success/ false if no records
	 * */
	function get_kity_point($date = "")
	{
		$CI =& get_instance();
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		$user_id =$CI->session->userdata('user_user_id');
		$activity_id = $CI->config->item('_activity_donate_');
		$CI->read_db->select('SUM(cc_point.point) as total_points,transaction.activity_record_id as page_id');
		$CI->read_db->from('point');
		$CI->read_db->join('transaction','transaction.transaction_id = point.transaction_id');
		$CI->read_db->where('cc_point.user_id',$user_id);
		$CI->read_db->where('cc_point.activity_id',$activity_id);
		if($date != "")
		{
			$CI->read_db->where('CAST(cc_point.datetime AS DATE)=',$date);
		}
		else
		{
			$CI->read_db->where('CAST(cc_point.datetime AS DATE)=','CURDATE()',false);
		}
		$CI->read_db->group_by('transaction.activity_record_id');
		$result = $CI->read_db->get();
		//echo $CI->read_db->last_query(); die();
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		return false;
	}
	
	function get_logged_user_friend_list(){
		$CI =& get_instance();
		$user_id =$CI->session->userdata('user_user_id');
		$sql = "SELECT DISTINCT cc_user.user_id as friend_id 
					FROM cc_friends f1 
					JOIN cc_user_profile on cc_user_profile.user_id=(CASE 
						WHEN f1.from_user_id='".$user_id."' THEN f1.to_user_id
						WHEN f1.to_user_id='".$user_id."' THEN f1.from_user_id
						END) 
					JOIN cc_user on cc_user.user_id=(CASE 
						WHEN f1.from_user_id='".$user_id."' THEN f1.to_user_id
						WHEN f1.to_user_id='".$user_id."' THEN f1.from_user_id
						END) 
					WHERE (f1.from_user_id='".$user_id."' OR f1.to_user_id='".$user_id."') AND f1.status=1 and cc_user.published=1 ";		
		$query = $CI->read_db->query($sql);
		$friend_result =$query->result();
		$friendList='';
		if(count($friend_result)>0){
				$friend_array=array();
				foreach($friend_result AS $row){
					$friend_array[]=$row->friend_id;
				}
				$friendList = implode(',',$friend_array);
		}
		return $friendList;	
	}
	/*
	* @Access: public
	* Comment: Get dender unread  messages count
	*@param 
	*@return message count
	*/
	function get_sender_unread_message_count($sender_id,$receiver_id)
	{
		$CI =& get_instance();		
		$read_db=''; //define new variable for read db reference
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable		
		$CI->read_db->where('viewed','0');						
		$CI->read_db->where('to_delete !=','1');						
		$CI->read_db->where('to',$receiver_id);			
		$CI->read_db->where('from',$sender_id);			
		$result=$CI->read_db->get('messages');		
		return count($result->result());			
	}
	
	/* @Access: public
	 * @ function: run_auto_updater
	 * @ About	 : run  node helper
	 * @ param	 : type : message=1,points=2,ticker=3
	 * @ Output  : countryCode 
	 * */
	function run_auto_updater($type='',$data=''){
		 $CI =& get_instance();
		 $updater_data='';
		 /*---------------------------------------
		 * Code for auto update messages
		 * --------------------------------------*/	
		 if($type==1){
			 $txtto=$CI->session->userdata('auto_updater_message_reciever');
			 if(count($txtto)>0 && $txtto!=''){
					$logged_user_id = $CI->session->userdata('user_user_id');
					$CI->session->set_userdata('auto_updater_message_reciever',array());	
					foreach($txtto AS $to){
						$receiver_array =array();
						$receiver_array['receiver_id'] =$to;
						$receiver_array['sender_id'] =$logged_user_id;
						
						$incomming_msg_count = get_unread_message_count($to);						
						$receiver_array['incomming_msg_count'] =$incomming_msg_count;
						$user_unread_msg_count = get_sender_unread_message_count($logged_user_id,$to);
						
						if($user_unread_msg_count==1){
							$receiver_array['encode_sender_id'] =encode($logged_user_id);
							$receiver_array['sender_name'] =ucfirst(get_username($logged_user_id));
							
							$user_image_dimention = $CI->config->item('__46X46__');
							$image_src = getimage('user', '', $logged_user_id,'','','','',$user_image_dimention);
							$receiver_array['sender_image'] =$image_src;
						}
						
						$receiver_array['user_unread_msg_count'] =$user_unread_msg_count;
						$updater_data=array('type'=>$type,'message_data'=>json_encode($receiver_array));																
					}
			}
			$CI->load->view('node/auto_updater_generator',$updater_data);
		}
		/*------------------------------------------*/
	}
	
	
	/* @Access: public
	 * @ function: save_ticker
	 * @ About	 : save_ticker
	 * @ param	 : 	  
	 * */	 
	 function save_ticker($from_user_id='',$to_user_id='',$action_record_id='',$action_type_id='',$ticker_message=''){
		  $CI =& get_instance();
		  $ticker_data	=	array(
				'user_id'	=>	$from_user_id,
				'to_user_id' =>	$to_user_id,
				'action_type' =>	$action_type_id,
				'ticker_message' =>	$ticker_message,
				'ticker_action_id'=>	$action_record_id
			);
			$CI->db->insert('ticker',$ticker_data);
	 }
	 /* @Access: public
	 * @ function: get_string
	 * @ About	 : cut string for given lentght
	 * @ param	 : string:string,length:lenght	  
	 * */	
	 function get_splict_string($string,$length){
		 $strLen =strlen($string);
		 if($strLen > $length){
			$string =substr($string,0,$length);
			$string =$string.'...';
		 }
		 return $string;		 
	 }
	 
	 function check_login_notification($username){
		 $CI =& get_instance();
		 $CI->db->select('login_notification,user_id');
		 $CI->db->where('username',$username);
		 $query = $CI->db->get('user');
		 return $res = $query->result();  
		 }
	
	function check_device_used($user_id){
		$CI =& get_instance();
		$CI->load->model('user_profile');
		$device_data = $CI->user_profile->getBrowser();
		$device_name = $device_data['platform'];
		$CI->db->select('user_id');
		$CI->db->where('user_id',$user_id);
		$CI->db->like('device_name',$device_name);
		$res = $CI->db->get('active_session');
		
		if($res->num_rows()>0){
			$ret_arr['rows'] = $res->num_rows();
			$ret_arr['device_name'] = '';
		}
		else{
			$ret_arr['device_name'] = $device_name;
			$ret_arr['rows'] = '';
			}
		return $ret_arr;
	}

    //common function to clear xss from user's input
    function clean_xss($content){
        $CI =& get_instance();
        $CI->form_validation->set_rules($content, $content, 'xss_clean');
        return $CI->form_validation->run();
    }
	
		function checkDateFormat($date)
		{
		
		//match the format of the date
		if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
		{
		//check weather the date is valid of not
		if(checkdate($parts[2],$parts[3],$parts[1]))
		//return true;
		return 1;
		else
		return 0;
		}
		else
		return 2;
		}
		
		function get_language_by_code($lang_code) {
			 $CI =& get_instance();
			 $CI->db->select('*');
			 $CI->db->where('language_code',$lang_code);
			 $query = $CI->db->get('language');
			 return $res = $query->result();
		}
		
		
	if ( ! function_exists('projAdminCategoryInRadio')){		 
	/* 
	 * function for get Proj Category.
	 */
		function projAdminCategoryInRadio($indusrtyId=0, $lang='en', $defaultOption='selectCategory',$entityId='',$catId=0){
			
			$lang=trim($lang);
			if(empty($lang)){
				$lang='en';
			}
			$catString='';
			$CI =& get_instance();
			
			$whereField = array(
							'lang'=>$lang
						  );
			if(is_numeric($entityId)){
				$whereField['entityId']=$entityId;
			}
			$res = $CI->model_common->getDataFromTabel('ProjCategory', 'catId, category',  $whereField, '', 'category','ASC');
			//return $res;
			if($res){
				foreach ($res as $k=>$category)
				{
					if($catId == $category->catId){
						$checked='checked';
						$toltipMsg=$CI->lang->line('collectionProjectInfo');
					}else{
						$checked='';
						$toltipMsg=$CI->lang->line('majorProjectInfo');
					}
					if($category->category)
					

					$catString.='
						<div class="cell defaultP formTip" title="'.$toltipMsg.'" >
							<input '.$checked.' type="radio" value="'.$category->catId.'" name="projCategory" onchange="getTypeListing(\'projectTypeList\',\'projGenre\','.$indusrtyId.','.$category->catId.',\''.$defaultOption.'\');"  >
						</div>
						<div class="cell mr8">
						  <label class="lH25">'.$category->category.'</label>
						</div>
						';
				}
				$catString.='<div class="clear"></div>';
				
			}
			return $catString;
		}
	}
	
	if ( ! function_exists('getAdminTypeList')){		 
	/* 
	* function for get Type List.
	*/
		function getAdminTypeList($IndustryId='', $lang='en', $defaultOption='selectProjectType',$catId=''){
			
			$lang=trim($lang);
			if(empty($lang)){
				$lang='en';
			}
			$CI =& get_instance();
			$data=array();
			$whereField = array(
							'lang'=>$lang 
						  );
			
			if($IndustryId > 0 && is_numeric($IndustryId)){
				$whereField['industryId']=$IndustryId;
			}
			
			if($catId>0){
				$whereField['catId']=$catId;
			}
			
			if($defaultOption)$data[''] = $CI->lang->line($defaultOption);
			
			if($IndustryId > 0 || $catId > 0 ){
				$res = $CI->model_common->getDataFromTabel('MasterProjectType', 'typeId, projectTypeName',  $whereField, '', 'projectTypeName','ASC');
				if($res){
					foreach ($res as $type)
					{
						$data[$type->typeId] = $type->projectTypeName;
					}
					
				}
			}
			return $data;
		}
	}
	
	/* 
	* function to fetch category details through type Id
	*/
	if ( ! function_exists('getTypeCatData')){		 
	/* 
	* function for get Type List.
	*/
		function getTypeCatData($typeId='',$industryId=''){
			
			$category = getDataFromTabel('MasterProjectType','catId',  'typeId', $typeId,'', 'ASC', $limit=1 );
		
			if($category) 
				return $category[0]->catId;
			else 
				return false;
		}
	}
	
	/* 
	* Function to get users showcase details
	*/
	if ( ! function_exists('getUserShowcaseDetails')){		 
		function getUserShowcaseDetails($userId=0){
			$res=getDataFromTabel('UserShowcase','*', array('tdsUid'=>$userId,'isArchive'=>'f'), '', '', '',1 );
			if($res){
				return $res[0];
			}else{
					return false;
			}
		}	
	}
?>
