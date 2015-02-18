<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
	
	if(!function_exists('check_image_exists')){
		function check_image_exists($bucket_url, $filename){
			$CI =& get_instance();
			$CI->load->library('plupload');
			return $CI->plupload->check_image_exists($bucket_url, $filename);
		}
	}
	
	/**
	 * @Input: $image is the image, $type is the type of image ie user, wall_image, wall_video, $flag is the which image need to display ie 1 for profile, 2 for wall, 3 for network (under type user)
	 * @Output: Return uploaded file information in json
	 * @Access: Public
	 * Comment: This function uploads files and returns uploaded file information in json format
	 */	
	if(!function_exists('getimage')){
		function getimage($type='', $flag='', $user_id='', $media_name='', $media_image_type='',$facebook_id='',$album_id='', $dimension='', $album_name='',$page_front=''){
	
			
			$CI = & get_instance();
			
			// following bucket and uploadURL will be configurable
			$bucketName = $CI->config->item('bucketName');		
			$host = $CI->config->item('amazon_host');
			
			$uploadURL = 'https://' . $bucketName . "." . $host;
			
			/*------------- call global settings helper function starts ----------------*/
			// $global_setting_url = get_global_settings($global_setting_option); now it is coll in factory_account_helper.php file
			$global_setting_url = $CI->session->userdata('global_setting_url');
			/*------------- call global settings helper function ends ----------------*/
			
			if($type!=''){
				if($type == "user"){ 
					// return user profile image
					$image_url = get_cc_user_image_url($user_id,$flag,$facebook_id,$dimension);
					set_image_count($media_name, $image_url);
					return $image_url;
				}
				else if($type == "media"){
					$image_url = get_cc_media_image_url($user_id,$media_name,$media_image_type,$flag,$album_id,$dimension,$album_name);
					set_image_count($media_name, $image_url);
					return $image_url;
				}
				else if($type == "group"){
					if($flag == 1)
					set_image_count($media_name, $image_url);
					return $global_setting_url.'templates/assets/user_images/group/default.jpg';
				}
				else if($type == "page"){
					$page_id = $user_id;
					$image_url = get_cc_page_image_url($page_id,$media_name,$media_image_type,$flag,$album_id,$dimension,$album_name);
					if($image_url==false){
                        if($page_front){
                            return FALSE;    
                        }
								set_image_count($media_name, $image_url);
                        return $global_setting_url.'templates/assets/user_images/page/default.jpg';
                    }
					else
								set_image_count($media_name, $image_url);
								return $image_url;
				}
				else if($type == "ad"){
					$image_url = get_cc_ad_image_url($user_id,$media_name,$flag);
					set_image_count($media_name, $image_url);
					return $image_url;
				}
			}
		}
	}
	
	/**
	 * @Input: $user_id, $media_name, $flag
	 * @Output: Return ad image depends on various parameters
	 * @Access: Public
	 * Comment: This function returns page image depends on various parameters
	 */		
	if(!function_exists('get_cc_ad_image_url'))
	{
		function get_cc_ad_image_url($user_id,$media_name,$flag){
			$CI = & get_instance();
			
			$bucketName = $CI->config->item('bucketName');	// following bucket and uploadURL will be configurable	
			$host = $CI->config->item('amazon_host');
			$uploadURL = 'https://' . $bucketName . "." . $host;	
			
			/*------------- call global settings helper function starts ----------------*/
			//$global_setting_option = '__cloud_front_url__';
		//	$global_setting_url = get_global_settings($global_setting_option);
					$global_setting_url = $CI->session->userdata('global_setting_url');
		/*------------- call global settings helper function ends ----------------*/
		
			if($media_name != ""){
				if($flag == 1){ // flag 1 for media picture
					$url = $uploadURL.'/'."user_".$user_id."/"."advert"."/".$media_name;
					$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."advert";
					
					if(check_image_exists($bucket_url, $media_name))
					return $url;
					else
					return $global_setting_url.'templates/assets/user_images/page/default.jpg';
				}
			}
			else
			return false;
		}
	}
	
	/** 
	 * @Input:  $media_name, $media_url
	 * @Output: None
	 * @Access: Public
	 * Comment: This function set image count into the DB on daily basis which is served from S3
	 */		
	if(!function_exists('set_image_count'))
	{
		 
		 function set_image_count($media_name, $media_url)
		 {
		 	
			 $CI = & get_instance();
			 $CI->load->model('common_model');
			 $CI->common_model->set_s3_image_count($media_name, $media_url);	
		 }
	}
	
	/**
	 * @Input: $page_id, $media_name, $media_name, $image_type, $flag, $album_id
	 * @Output: Return page image depends on various parameters
	 * @Access: Public
	 * Comment: This function returns page image depends on various parameters
	 */		
	if(!function_exists('get_cc_page_image_url'))
	{
		function get_cc_page_image_url($page_id,$media_name,$media_image_type,$flag,$album_id,$dimension,$album_name){
			$CI = & get_instance();
			$bucketName = $CI->config->item('bucketName');	// following bucket and uploadURL will be configurable
			$host = $CI->config->item('amazon_host');
			$uploadURL = 'https://' . $bucketName . "." . $host;

			/*------------- call global settings helper function starts ----------------*/
	//		$global_setting_option = '__cloud_front_url__';
	//		$global_setting_url = get_global_settings($global_setting_option);
				$global_setting_url = $CI->session->userdata('global_setting_url');
			/*------------- call global settings helper function ends ----------------*/
		
			if($media_name != ""){
				if($flag == 1){ // flag 1 for media picture
					$url = $uploadURL.'/'."page_".$page_id."/"."wall"."/".$media_name;
					$bucket_url = "/".$bucketName.'/'."page_".$page_id."/"."wall";
					
					if(check_image_exists($bucket_url, $media_name))
					return $url;
					else
					return $global_setting_url.'templates/assets/user_images/page/default.jpg';
				}
				if($flag == 2){ // flag 2 for media picture
					$url = $uploadURL.'/'."page_".$page_id."/"."video"."/".$media_name;
					$bucket_url = "/".$bucketName.'/'."page_".$page_id."/"."video";
					
					if(check_image_exists($bucket_url, $media_name))
					return $url;
					else
					return $global_setting_url.'templates/assets/user_images/page/default.jpg';
				}
				if($flag == 3){ // flag 3 for page profile image
                $url = $uploadURL.'/'."page_".$page_id."/"."profile"."/".$media_name;
                if($dimension!=''){
                    $url = $uploadURL.'/'."page_".$page_id."/"."profile"."/".$media_name."_".$dimension;
                }
					$bucket_url = "/".$bucketName.'/'."page_".$page_id."/"."profile";			
					if(check_image_exists($bucket_url, $media_name))
					return $url;
					else
					return $global_setting_url.'templates/assets/user_images/page/default.jpg';
				}	
				
				if($flag == 5)
				{
                    
                    // ----------- Code to return image with specific dimension start -------------
                $image = $media_name;
				if($dimension!=''){
					$image_part = explode('.',$image);
					if(count($image_part) > 0){
						$image_url = $image_part[0];
						$image_ext = $image_part[1];
						$image = $image_url."_".$dimension.".".$image_ext; // create new image URL
                        if($album_name=="")
						{
							$album_name = get_album_name_by_id($album_id);
						}
                        
                        $url = $uploadURL.'/'."page_".$page_id."/album_".$album_id."/".$image;
						$bucket_url = "/".$bucketName."/"."page_".$page_id."/album_".$album_id;
                        
						if($album_name == "Profile Pictures"){
							// get dimention near to album image dimention because this is user's image and resized different format than album images
							if($flag == 'profile_thumb')
							$user_profile_image_diemention = $CI->config->item('__215X225__');
							else if($flag == 'profile')
							$user_profile_image_diemention = $CI->config->item('__1024X768__');
							else $user_profile_image_diemention = $CI->config->item('__215X225__');
							
							$user_profile_image = $image_url."_".$user_profile_image_diemention.".".$image_ext;
							
							$url = $uploadURL.'/'."page_".$page_id."/profile/".$user_profile_image;
							$bucket_url = "/".$bucketName.'/'."page_".$page_id."/"."profile";
                            
							if(check_image_exists($bucket_url, $user_profile_image)){
								return $url;
							}
						}
						else if($album_name == "Wall Photos"){
							$url = $uploadURL.'/'."page_".$page_id."/wall/".$image;
							$bucket_url = "/".$bucketName."/"."page_".$page_id."/wall";
						}
						else{
							$url = $uploadURL.'/'."page_".$page_id."/album_".$album_id."/".$image;
							$bucket_url = "/".$bucketName."/"."page_".$page_id."/album_".$album_id;
						}
						if(check_image_exists($bucket_url, $image)){
							return $url;
						}
					}
				}
				// ----------- Code to return image with specific dimension end -------------
				}
				if($flag == 6){ // flag 6 for page banner image for business page
					$url = $uploadURL.'/'."page_".$page_id."/"."banner"."/".$media_name;
					if($dimension!=''){
						$url = $uploadURL.'/'."page_".$page_id."/"."banner"."/".$media_name."_".$dimension;
					}
					$bucket_url = "/".$bucketName.'/'."page_".$page_id."/"."banner";
					
					if(check_image_exists($bucket_url, $media_name))
					return $url;
					else
					return $global_setting_url.'templates/assets/user_images/page/default.jpg';
				}		
				
				
				if($flag == 7){ // flag 7 for page news image for business page
					
					 $url = $uploadURL.'/'."page_".$page_id."/"."newsimage"."/".$media_name;
					if($dimension!=''){
					
						$url = $uploadURL.'/'."page_".$page_id."/"."newimage"."/".$media_name."_".$dimension;
					}
					 $bucket_url = "/".$bucketName.'/'."page_".$page_id."/"."newsimage";
					
					if(check_image_exists($bucket_url, $media_name))
					return $url;
					else
					return $global_setting_url.'templates/assets/user_images/page/default.jpg';
				}


				if($flag == 8){ // flag 8 for charity page project image section
					
					 $url = $uploadURL.'/'."page_".$page_id."/"."project"."/".$media_name;
					if($dimension!=''){
					
						$url = $uploadURL.'/'."page_".$page_id."/"."project"."/".$media_name."_".$dimension;
					}
					 $bucket_url = "/".$bucketName.'/'."page_".$page_id."/"."project";
					
					if(check_image_exists($bucket_url, $media_name))
					return $url;
					else
					return $global_setting_url.'templates/assets/user_images/page/default.jpg';
				}	
				
				
				
			}
			else
			return false;
		}	
	}
	
	/**
	 * @Input: $user_id, $image, $facebook_id, $sex, $flag, $dimension
	 * @Output: Return image of user (user_id) 
	 * @Access: Public
	 * Comment: This function returns image of user by argument passed
	 */		
	
	if(!function_exists('get_friend_image'))
	{
		function get_friend_image($user_id,$image='',$facebook_id=0,$sex=1,$flag=1,$dimension=''){
			$CI = & get_instance();
			$bucketName = $CI->config->item('bucketName');	// following bucket and uploadURL will be configurable	
			$host = $CI->config->item('amazon_host');
			$uploadURL = 'https://' . $bucketName . "." . $host;
			
			if($image!=''){
				if($dimension!=''){
					$image_part = explode('.',$image);
					if(count($image_part) > 0){
						$image_url = $image_part[0];
						$image_ext = $image_part[1];
						
						$image = $image_url."_".$dimension.".".$image_ext; // create new image URL
						$url = $uploadURL.'/'."user_".$user_id."/"."profile"."/".$image;
						$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."profile";
						
						if(check_image_exists($bucket_url, $image))
						return $url;
						else
						return get_user_default_image_by_gender($flag, $sex, $dimension);
					}
				}
			}
			else if($facebook_id!=0){			
				return $url="https://graph.facebook.com/".$facebook_id."/picture?type=large";	
			}else{
				return get_user_default_image_by_gender($flag, $sex, $dimension);
			}
		}
	}
	
	/**
	 * @Input: $flag is the type of image (profile/thumb), $user_id is the id of user
	 * @Output: Return default image by gender
	 * @Access: Public
	 * Comment: This function returns image by image type
	 */		
	if(!function_exists('get_cc_user_image_url'))
	{
		function get_cc_user_image_url($user_id,$flag,$facebook_wall_id='',$dimension){
			$CI = & get_instance();
			$read_db=''; //define new variable for read db reference
			$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
			
			// following bucket and uploadURL will be configurable
			$bucketName = $CI->config->item('bucketName');		
			$host = $CI->config->item('amazon_host');
			
			$uploadURL = 'https://' . $bucketName . "." . $host;	
			$CI->read_db->from('user');
			$CI->read_db->where('user.user_id',$user_id);
			//if($facebook_wall_id!=''){
			//	$CI->read_db->or_where('user.facebook_id',$facebook_wall_id);
			//}	
			$CI->read_db->select('user.sex,user.facebook_id');
			$result = $CI->read_db->get();
			if($result->num_rows() > 0){
				$sex = $result->row()->sex;
				$facebook_id = $result->row()->facebook_id;
				//$user_id = $result->row()->user_id;
				
				$CI->read_db->from('user_profile');
				$CI->read_db->where('user_profile.user_id',$user_id);
				$CI->read_db->select('user_profile.profile_picture');
				$result1 = $CI->read_db->get();
				
				if($result1->num_rows() > 0){
					$image_url = '';  $image_ext = '';
					$image = $result1->row()->profile_picture;

					if($image != ""){
						// ----------- Code to return image with specific dimension start -------------
						if($dimension!=''){
							$image_part = explode('.',$image);
							if(count($image_part) > 0){
								$image_url = $image_part[0];
								$image_ext = $image_part[1];
								
								$image = $image_url."_".$dimension.".".$image_ext;  // create new image URL
								$url = $uploadURL.'/'."user_".$user_id."/"."profile"."/".$image;
								$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."profile";
								
								if(check_image_exists($bucket_url, $image))
								return $url;
								else
								return get_user_default_image_by_gender($flag, $sex, $dimension);
							}
						}
						// ----------- Code to return image with specific dimension end -------------

						if($flag == 1){
							$url = $uploadURL.'/'."user_".$user_id."/"."profile"."/".$image;
							$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."profile";
							
							if(check_image_exists($bucket_url, $image))
							return $url;
							else
							return get_user_default_image_by_gender($flag, $sex);
						}	
						else{ 
							$url = $uploadURL.'/'."user_".$user_id."/"."profile"."/"."thumb"."/".$image;
							$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."profile"."/"."thumb";
							$bucket_url_profile = "/".$bucketName.'/'."user_".$user_id."/"."profile";
							$url_profile = $uploadURL.'/'."user_".$user_id."/"."profile"."/".$image;
							
							if(check_image_exists($bucket_url, $image))
							return $url;
							else if(check_image_exists($bucket_url_profile, $image))
							return $url_profile;
							else
							return get_user_default_image_by_gender($flag, $sex);
						}	
					}
					elseif($facebook_id > 0){
						//$CI =& get_instance();
						//$CI->load->library('facebook_library');
						$url = 'https://graph.facebook.com/'.$facebook_id.'/picture?type=large';
						return $url;
					}
					else
					return get_user_default_image_by_gender($flag, $sex, $dimension);	
				}
				else
				return get_user_default_image_by_gender($flag, $sex, $dimension);
			}
			elseif($facebook_wall_id!=''){
					$url="https://graph.facebook.com/".$facebook_wall_id."/picture?type=large";				
					return $url;
			}
		}
	}

	/**
	 * @Input: $flag is the type of image (profile/thumb), $sex is the gender of user
	 * @Output: Return default image by gender
	 * @Access: Public
	 * Comment: This function returns default image by gender and image type
	 */	
	if(!function_exists('get_user_default_image_by_gender'))
	{
		function get_user_default_image_by_gender($flag, $sex='1', $dimension=''){
		$CI = & get_instance();
			/*------------- call global settings helper function starts ----------------*/
		//	$global_setting_option = '__cloud_front_url__';
		//	$global_setting_url = get_global_settings($global_setting_option);
			
			$global_setting_url = $CI->session->userdata('global_setting_url');
			if($global_setting_url == ''){
				$global_setting_url = "https://chatching-templates.s3.amazonaws.com/";
			}
			/*------------- call global settings helper function ends ----------------*/
			
			if($dimension!=''){
				if($sex == 1)
				return $global_setting_url.'templates/assets/user_images/profile/male'.'_'.$dimension.'.jpg';
				else if($sex == 0)
				return $global_setting_url.'templates/assets/user_images/profile/female'.'_'.$dimension.'.jpg';
			}
		
			if($flag == 1){
				if($sex == 1)
				return $global_setting_url.'templates/assets/user_images/profile/male.jpg';
				else if($sex == 0)
				return $global_setting_url.'templates/assets/user_images/profile/female.jpg';
			}
			else{
				if($sex == 1)
				return $global_setting_url.'templates/assets/user_images/profile/male_thumb.jpg';
				else if($sex == 0)
				return $global_setting_url.'templates/assets/user_images/profile/female_thumb.jpg';
			}
		}
	}
	
	if(!function_exists('get_album_array'))
	{
		function get_album_array($album_id_arr)
		{
			$CI = & get_instance();
			$CI->read_db->from('album');
			$CI->read_db->where_in('album_id', $album_id_arr);
			$CI->read_db->select('album_name,album_id');
			$result = $CI->read_db->get();
			if($result->num_rows() > 0){
				return $result->result();
			}
				
		}
	}
	
	/**
	 * @Input: $user_id is logged in user_id, $media_name, $media_type (full/thumb), $flag to distinguish media sections, $album_id, $dimention
	 * @Output: Return media name
	 * @Access: Public
	 * Comment: This function returns media image depends upon parameters passed
	 */		
	if(!function_exists('get_cc_media_image_url'))
	{
		function get_cc_media_image_url($user_id,$media_name,$media_image_type,$flag,$album_id='',$dimension='',$album_name){
			

			$CI = & get_instance();
			// following bucket and uploadURL will be configurable
			$bucketName = $CI->config->item('bucketName');		
			$host = $CI->config->item('amazon_host');
			$uploadURL = 'https://' . $bucketName . "." . $host;	
		   
			if($media_name != ""){
			   $image = $media_name;
				// ----------- Code to return image with specific dimension start -------------
				if($dimension!=''){
					$image_part = explode('.',$image);
					if(count($image_part) > 0){
						$image_url = $image_part[0];
						$image_ext = $image_part[1];
						$image = $image_url."_".$dimension.".".$image_ext; // create new image URL
						if($album_name=="")
						{
							$album_name = get_album_name_by_id($album_id);
						}
						if($album_name == "Profile Pictures"){
						
							// get dimention near to album image dimention because this is user's image and resized different format than album images
							if($flag == 'profile_thumb')
							$user_profile_image_diemention = $CI->config->item('__215X225__');
							else if($flag == 'profile')
							$user_profile_image_diemention = $CI->config->item('__1024X768__');
							else $user_profile_image_diemention = $CI->config->item('__215X225__');
							
							$user_profile_image = $image_url."_".$user_profile_image_diemention.".".$image_ext;
							
							$url = $uploadURL.'/'."user_".$user_id."/profile/".$user_profile_image;
							$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."profile";
							
							if(check_image_exists($bucket_url, $user_profile_image)){
								return $url;
							}
						}
						else if($album_name == "Wall Photos"){	  
							$url = $uploadURL.'/'."user_".$user_id."/wall/".$image;
							$bucket_url = "/".$bucketName."/"."user_".$user_id."/wall";
						}
						else{					
							$url = $uploadURL.'/'."user_".$user_id."/album_".$album_id."/".$image;
							$bucket_url = "/".$bucketName."/"."user_".$user_id."/album_".$album_id;
						}	
	
						$url = $uploadURL.'/'."user_".$user_id."/album_".$album_id."/".$image;
						$bucket_url = "/".$bucketName."/"."user_".$user_id."/album_".$album_id;
						if(check_image_exists($bucket_url, $image)){
							return $url;
						}
						else
						{
							if($album_name == "Profile Pictures"){
								// get dimention near to album image dimention because this is user's image and resized different format than album images
								if($flag == 'profile_thumb')
								$user_profile_image_diemention = $CI->config->item('__215X225__');
								else if($flag == 'profile')
								$user_profile_image_diemention = $CI->config->item('__1024X768__');
								else $user_profile_image_diemention = $CI->config->item('__215X225__');
								
								$user_profile_image = $image_url."_".$user_profile_image_diemention.".".$image_ext;
								
								$url = $uploadURL.'/'."user_".$user_id."/profile/".$user_profile_image;
								$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."profile";
								
								if(check_image_exists($bucket_url, $user_profile_image)){
									return $url;
								}
							}
							else if($album_name == "Wall Photos"){	  
								$url = $uploadURL.'/'."user_".$user_id."/wall/".$image;
								$bucket_url = "/".$bucketName."/"."user_".$user_id."/wall";
							}
							/*else{					
								$url = $uploadURL.'/'."user_".$user_id."/album_".$album_id."/".$image;
								$bucket_url = "/".$bucketName."/"."user_".$user_id."/album_".$album_id;
							}*/	
							
							if(check_image_exists($bucket_url, $image)){
								return $url;
							}
							else{
								//return get_media_default_image($dimension, $flag);
								return '';
							}
						}
					}
				}
				// ----------- Code to return image with specific dimension end -------------

				if($flag==1){
					if($media_image_type == "thumb"){
						if($album_id!='')
						$url = $uploadURL.'/'."user_".$user_id."/"."album_".$user_id."/"."thumb"."/".$media_name;
						else
						$url = $uploadURL.'/'."user_".$user_id."/"."wall"."/"."thumb"."/".$media_name;
					}
					else{
						$url = $uploadURL.'/'."user_".$user_id."/"."wall"."/".$media_name;
					}
					
					$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."wall";
		
					if(check_image_exists($bucket_url, $media_name))
					return $url;
					else
					return false;
				}
				
				if($flag == 2){ // flag 2 for media picture
				
					// check if its video image request then return video image else return video
					if($media_image_type == "thumb"){
						//$url = $uploadURL.'/'."user_".$user_id."/"."video"."/".$media_name;
						$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."video";
						
						$video_name = substr($media_name,0,-3);
						$video_image_name = $video_name."jpg"; 
						
						$video_image_url = $uploadURL.'/'."user_".$user_id."/"."video"."/".$video_image_name;
						
						if(check_image_exists($bucket_url, $video_image_name))
						return $video_image_url;
						else
						return false;
					}
					else
					{
						$video_cloud_front_url = $CI->config->item("user_assets_cloud_front_distribution");
						$url = $video_cloud_front_url."/user_".$user_id."/"."video"."/".$media_name;
						$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."video";
							
						if(check_image_exists($bucket_url, $media_name))
						return $url;
						else
						return false;
					}
				}
				
				if($album_id!='') 
				$url = $uploadURL.'/'."user_".$user_id."/"."album_".$user_id."/"."thumb"."/".$media_name;
				else 
				$url = $uploadURL.'/'."user_".$user_id."/"."wall"."/"."thumb"."/".$media_name;
				
				if($flag == 5){
					$album_name = get_album_name_by_id($album_id);
					
					if($album_name == "Profile Pictures"){
						if($media_image_type == "thumb")
						$url = $uploadURL.'/'."user_".$user_id."/profile/thumb/".$media_name;
						else
						$url = $uploadURL.'/'."user_".$user_id."/profile/".$media_name;
						
						$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."profile";
					}
					else if($album_name == "Wall Photos"){	  
						if($media_image_type == "thumb"){
							$url = $uploadURL.'/'."user_".$user_id."/wall/thumb/".$media_name;
							$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."wall/thumb";
						}
						else{ 
							echo $url = $uploadURL.'/'."user_".$user_id."/wall/".$media_name;
							$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."wall";
						} 
					}
					else
					{
						if($media_image_type == "thumb")
						$url = $uploadURL.'/'."user_".$user_id."/"."album_".$user_id."/"."thumb"."/".$media_name;
						else
						$url = $uploadURL.'/'."user_".$user_id."/album_".$album_id."/".$media_name;
						
						$bucket_url = "/".$bucketName.'/'."user_".$user_id."/"."album_".$album_id;
					}
					if(check_image_exists($bucket_url, $media_name))
					return $url;
					else
					return false;
				}				
			}
			else
			return PROFILE_IMG.'no-imagess.png';
		}	
	}
	
	/**
	 * @Input: $dimention
	 * @Output: Return media URL
	 * @Access: Public
	 * Comment: This function returns media image url depends upon dimention
	 */	
	if(!function_exists('get_media_default_image')){
		function get_media_default_image($dimension){
			$CI = & get_instance();
			/*------------- call global settings helper function starts ----------------*/
			$global_setting_url = $CI->session->userdata('global_setting_url');
			/*------------- call global settings helper function ends ----------------*/
			
			if($dimension!='')
			return $global_setting_url.'templates/assets/user_images/media/default'.'_'.$dimension.'.jpg';
		}
	}
?>
