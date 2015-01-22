<?php
if(! defined('BASEPATH')) exit('No direct script access allowed');
	
	/**-----------------------------------------
	 * comment:Function for rest video conversion
	 * Input:@video_file_name, @media_id
	 * Output:NUll
	 ------------------------------------------*/
	if(!function_exists('process_video_conversion'))
	{
	    function process_video_conversion($video_file_name, $media_id) {
		
	        $CI =& get_instance();
			
			// load ffmpeg and node related config settings (utility)
			$CI->load->config('utility');
			$user_id = $CI->session->userdata('user_user_id');
	        
			$file_arr = explode(".",$video_file_name);
			if(count($file_arr)>0) {
				$orig_video_ext = $file_arr[count($file_arr)-1];
				$orig_video_file = $file_arr[count($file_arr)-2];
			}
			
				// ------ Code to send video information for conversion (video format other than mp4) start -----
				// if video is in other format then send request to ffmpeg server to process other formats video
				$job_id = $media_id;
				$time = date('Y-m-d H:i:s');
				$ffmpeg_server_url = $CI->config->item('ffmpeg_server_url');
				$cloud_front_distribution = $CI->config->item('user_assets_cloud_front_distribution');
				$secure_key = $CI->config->item('ffmpeg_key');
				$ffmpeg_server_temp_url = $CI->config->item('ffmpeg_server_temp_url');
				
				$action = "__restvideoconversion__";
				$targetdir = '/user_'.$user_id.'/video';
				$new_video_file_name = $orig_video_file.".mp4";
				
				$source = $cloud_front_distribution.$targetdir."/".$video_file_name;
				$destination = $ffmpeg_server_temp_url.$new_video_file_name;
				
				// following bucket and uploadURL will be configurable
				$bucketName = $CI->config->item('bucketName');
				$amazon_bucket_url = "/".$bucketName.$targetdir;
				
				// send SITE URL in job file
				$video_return_process_url = $CI->config->item('ffmpeg_host_request_url');
				
				$jobFile_arr = json_encode(array(
								"JobID"=>$job_id,
								"Type"=>$orig_video_ext,
								"Source"=>$source,
								"Destination"=>$destination,
								"Added"=>$time,
								"amazon_bucket_url"=>$amazon_bucket_url,
								"video_filename"=>$video_file_name,
								"video_return_process_url"=>$video_return_process_url
							));
				$vars = "action=".$action."&key=".$secure_key."&jobFile=".$jobFile_arr."";
				$result = get_web_page( $ffmpeg_server_url, $vars );
				// ------- Code to send video information for conversion (video format other than mp4) end -----
		}
	}
	
	/**-----------------------------------------
	 * comment:Function to send CURL request to remote server
	 * Input:@url, @vars
	 * Output:@header 
	 ------------------------------------------*/
	if(!function_exists('get_web_page'))
	{
		function get_web_page( $url, $vars ) {
			$ch      = curl_init( $url );
			curl_setopt($ch, CURLOPT_POST      ,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS    ,$vars);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
			curl_setopt($ch, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS
			curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
			$content = curl_exec( $ch );

			$err     = curl_errno( $ch );
			$errmsg  = curl_error( $ch );
			$header  = curl_getinfo( $ch );
			curl_close( $ch );

			$header['errno']   = $err;
			$header['errmsg']  = $errmsg;
			$header['content'] = $content;
			return $header;
		}
	}
	
	/**-----------------------------------------
	 * comment:Function to generate mp4 video thumb image
	 * Input:@url, @vars
	 * Output:@header 
	 ------------------------------------------*/	
	/*if(!function_exists('generate_video_thumb_image'))
	{
		function generate_video_thumb_image($video_file_name){
			
			$file_arr = explode(".",$video_file_name);
			if(count($file_arr)>0)
			$orig_video_ext = $file_arr[count($file_arr)-1];
			
			// only mp4 video thumb generation allowed on the fly
			if(strtolower($orig_video_ext) == "mp4") {
				
				$CI =& get_instance();
				
				if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')) {
					die('ERROR: CURL extension not loaded!');
				}

				// following bucket and uploadURL will be configurable
				$bucketName = $CI->config->item('bucketName');

				if(!$bucketName) {
					die('ERROR: Bucket name not found!');
				}

				$host = $CI->config->item('amazon_host');

				if(!$host) {
					die('ERROR: Host name not found!');
				}
				
				// load ffmpeg and node related config settings (utility)
				$CI->load->config('utility');
				$user_id = $CI->session->userdata('user_user_id');
				
				// ------ Code to send video information for conversion (video format other than mp4) start -----
				// if video is in other format then send request to ffmpeg server to process other formats video
				$ffmpeg_server_url = $CI->config->item('ffmpeg_server_url');
				$cloud_front_distribution = $CI->config->item('user_assets_cloud_front_distribution');
				$secure_key = $CI->config->item('ffmpeg_key');
				$action = "__videothumbgeneration__";
				$targetdir = '/user_'.$user_id.'/video/';
				
				$source = $cloud_front_distribution.$targetdir.$video_file_name;
				
				// bucket name
				$amazon_bucket_url = "/".$bucketName.$targetdir;
				
				$jobFile_arr = json_encode(array(
								"video_filename"				=>	$video_file_name,
								"cloud_front_dist_video_url"	=>	$source,
								"amazon_bucket_url"				=>	$amazon_bucket_url
							));
				
				$vars = "action=".$action."&key=".$secure_key."&jobFile=".$jobFile_arr."";
				$result = get_web_page( $ffmpeg_server_url, $vars );
				print_r($result);
			}
		}
	}*/
	
	
	
	/*
     * Function to save video
    */
    if(!function_exists('save_video_procass'))
	{
		function save_video_procass($image_name)
		{
			$CI =& get_instance();
			$user_id = $CI->session->userdata('user_user_id');
			$location = get_location($user_id);	
			if(!$location) $location = "";	
			
			//$image_name  = $this->CI->input->post('media_name');
			
			$status  = $CI->input->post('status');
			if(!isset($status)) $status = 1;
			
			// code to get video duration starts
			$video_complete_url = getimage('media', 2, $user_id, $image_name, '', '', '');
			$duration = '';
			
			/*ob_start();
			passthru("ffmpeg -i \"{$video_complete_url}\" 2>&1 | grep \"Duration\" | cut -d ' ' -f 4 | sed s/,//");
			$duration = ob_get_contents();
			ob_end_clean();
			
			if($duration!=''){
				$duration_parts = explode(":",$duration);
				if(count($duration_parts)>0){
					if($duration_parts[2] < 10) $duration_parts[2] = "0".(int)$duration_parts[2];
					else $duration_parts[2] = (int)$duration_parts[2];
				
					if($duration_parts[0] == "00")
					$duration = $duration_parts[1].":".$duration_parts[2];
					else
					$duration = $duration_parts[0].":".$duration_parts[1].":".(int)$duration_parts[2];
				}
			}
			// code to get video duration ends
			*/
			$media_arr = array(
						'media_name'    =>$image_name,
						'user_id'	    =>$user_id,
						'post_user_id'	=>$user_id,
						//'media_text'    =>$this->CI->input->post('media_text'),
						'media_type'    => 4,
						'location'	    =>$location,
						'action_category_id'	 => '1',
						'video_duration'	 => $duration,
						'status'	 => $status
				);
			$media_id = $CI->video_model->store_media($media_arr);
			
			// call helper function to send request on remote server for video conversion process
			process_video_conversion($image_name, $media_id);
			return  $media_id;
		}
	}
?>

