<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller (create_profile) 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
	@ Author - CDN Solutions
*/

class Factory_create_profile{

	// $view_data	= to hold any data related to view 
	public	$view_data			=	array();
	public	$step_to_open		=	'cp_personalinfo';
	public	$user_id			=	0;
	public	$user_state_id		=	0;
	public	$user_profile_id	=	0;
	
	public function __construct(){
		$this->CI =& get_instance();
		$this->init();		
	}
	

	public function init(){
		// session start is used for commet chat	
		session_start();
		
		$this->CI->load->language('create_profile');

		$this->CI->load->model('createprofile_model');
		$this->CI->load->model('common_model');
		$this->CI->load->model('incentive_invitation_system_model');
		$this->CI->load->model('home_model');
		$this->CI->load->model('user_model');
		$this->CI->load->model('user_profile');
		
		$this->CI->load->library('form_validation');	
		$this->CI->load->library('incentive_invitation_system');
		$this->CI->load->library('csimport');
		$this->CI->load->library('point_calculation');
		
		$this->step_to_open					=	$this->CI->session->userdata('step_to_open');
		$this->user_id 						= 	$this->CI->session->userdata('user_user_id');
		$this->user_state_id 				= 	$this->CI->session->userdata('incentive_program_state_id');
		$this->user_profile_id				=	$this->CI->session->userdata('user_profile_id');
	}
	
	/**********************  Functions of step 1 starts *********************************/
	public function personalinfo_validation(){
		$required_validation = "";
		$skip = $this->CI->input->post('skip_val');
		if(isset($skip) && $skip==1){
			$required_validation = "";
		}		
	
		//required validations
		$this->CI->form_validation->set_rules('country', 'Country', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('state', 'State', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('city', 'City', 'trim'.$required_validation);
		
		//non required elements
		$this->CI->form_validation->set_rules('address', 'Address', 'trim');
		$this->CI->form_validation->set_rules('address2', 'Address 2', 'trim');
		$this->CI->form_validation->set_rules('zipcode', 'zipcode', 'trim|numeric|min_length[5]|max_length[6]');
		$this->CI->form_validation->set_rules('home_phone', 'Home phone', 'trim');
		$this->CI->form_validation->set_rules('cell_phone', 'Cell phone', 'trim');
		$this->CI->form_validation->set_rules('carrier', 'Carrier', 'trim');
		
		if ($this->CI->form_validation->run() == FALSE){
			return FALSE;
		}
		else{
			return TRUE;
		}	
	}
	
	public function personalinfo_load_data(){
		$view_data['country_query'] = $this->CI->common_model->get_country();
		$view_data['carrier_result'] = $this->CI->common_model->get_carrier();
               
		$current_country =$this->CI->session->userdata('time_zone_array');
		$country_id = $this->CI->common_model->get_country_id($current_country['countryName']);

		if(!empty($country_id)):
		$view_data['user_country'] = $current_country ; 
		$view_data['country_id'] = $country_id;
		$current_states= $this->CI->common_model->get_states_by_country($country_id);
		endif;

		if(!empty($current_states))
		$view_data['user_states'] = $current_states; 
		
		return $view_data;
	}
	
	public function personalinfo_process(){
		// make posted address container data into json encode format
//		$address_container_address_type = $this->CI->input->post('address_container_address_type');
//		$address_container_address = $this->CI->input->post('address_container_address');
//		$address_container_address2 = $this->CI->input->post('address_container_address2');
//		$address_container_main_address_arr = $this->CI->input->post('address_container_main_address_arr');
//		
//		if(count($address_container_address_type)>0){
//			foreach($address_container_address_type as $key=>$val){
//				$address_info[] = array(
//					'type'=>$address_container_address_type[$key],
//					'address'=>$address_container_address[$key],
//					'address2'=>$address_container_address2[$key],
//					'is_main_address'=>$address_container_main_address_arr[$key]	
//				);
//			}
//		}
                
		$address_info = array();
                $address_info[1]['address'] = $this->CI->input->post('address1') . ' ' . $this->CI->input->post('address2');
                $address_info[1]['zip'] = $this->CI->input->post('zipcode');
            
		$address_info = json_encode($address_info);
	
//		$mobile_container_mobile = $this->CI->input->post('mobile_container_mobile');
//		$mobile_container_cell_phone = $this->CI->input->post('mobile_container_cell_phone');
//		$mobile_container_carrier = $this->CI->input->post('mobile_container_carrier');	
//
//		if(count($mobile_container_mobile)>0){				
//			foreach($mobile_container_mobile as $key=>$val){
//				$mobile_info[] = array(
//					'type'=>$mobile_container_mobile[$key],
//					'number'=>$mobile_container_cell_phone[$key],
//					'carrier'=>$mobile_container_carrier[$key]
//				);
//			}
//		}
		
		$mobile_info = array();
                
                $mobile_info[1]['type'] = '1';
                $mobile_info[1]['number'] = $this->CI->input->post('mobile1');
                $mobile_info[1]['phone_carrier'] = $this->CI->input->post('mobile_container_carrier');
                
                if ($this->CI->input->post('mobile2')) {
                    $mobile_info[2]['type'] = '2';
                    $mobile_info[2]['number'] = $this->CI->input->post('mobile2');
                    $mobile_info[2]['phone_carrier'] = $this->CI->input->post('mobile_container_carrier');
                }
                
		$mobile_info = json_encode($mobile_info);
	
		//gather posted data and set condition for non posted fields
		$country = $this->CI->input->post('country');
		if(!isset($country) || $country=="") $country = NULL;
		if($address_info == "") $address = NULL; else $address = $address_info;
		$zipcode = $this->CI->input->post('zipcode');
		if(!isset($zipcode)) $zipcode = NULL;
		$state = $this->CI->input->post('state');
		if(!isset($state) || $state=="") $state = NULL;
		$city = $this->CI->input->post('city');
		if(!isset($city) || $city==""){
			$city_name = $this->CI->input->post('city_custom');
			$city = $this->CI->createprofile_model->insert_custom_city($city_name,$state);
			}
			else{ $city = NULL;}

		if($mobile_info == "") $home_phone = NULL; else $home_phone = $mobile_info;

		$profile_picture = $this->CI->input->post('profile_picture');
		if(!isset($profile_picture) || $profile_picture=="") $profile_picture = NULL;
		if(!empty($profile_picture)){
					$profile_picture_arr=array('profile_picture'=>$profile_picture);
					$this->CI->session->set_userdata($profile_picture_arr);
				}
		$user_id = $this->CI->session->userdata('user_user_id');
		$create_profile_arr = array(
			"user_id" => $user_id, 
			"country_id" => $country, 
			"address" => $address,
			"zipcode" => $zipcode, 
			"state_id" => $state, 
			"city_id" => $city, 
			"home_phone" => $home_phone, 
			"carrier_id" => "1",
			"profile_picture" => $profile_picture,
                        "phones" => $home_phone,
			"is_step1_completed" => 1
		);
		
		//$user_profile_id = $this->createprofile_model->user_create_profile1($create_profile_arr);
		$user_profile_id = $this->CI->createprofile_model->user_create_profile($create_profile_arr);
		
		// update step to open field in user table and set next method
		$step_to_open_arr = array('step_to_open'=>'cp_interests');
		$this->CI->createprofile_model->update_step_to_open($step_to_open_arr, $user_id);
		
		// set create profile id into session
		$this->CI->session->set_userdata('user_profile_id', $user_profile_id);
		
		// check if state selected by user, is in incentive program section
		$state_result = $this->CI->common_model->check_state_under_incentive_program($state);
		if($state_result != false){
			$this->CI->session->set_userdata('incentive_program_state_id', $state);
		}
	}
	
	public function load_view($view = '', $data = array()){
		$this->CI->template->load('template', $view, $data);
	}
	
	/**********************  Functions of step 1 ends  *********************************/
	
	/**********************  Functions of step 2 starts  *********************************/
	public function cp_interests_validations(){
		$required_validation = "";
		$skip = $this->CI->input->post('skip_val');
		if(isset($skip) && $skip==1)
		{
			$required_validation = "";
		}

		//non required validations and set condition for non posted fields
		$this->CI->form_validation->set_rules('political_affiliation', 'Political affiliation', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('religious_view', 'Religious view', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('general_interests', 'General interests', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('favorite_movies', 'Favorite movies', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('favorite_singers', 'Favorite singers', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('favorite_actors', 'Favorite actors', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('favorite_authors', 'Favorite authors', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('favorite_tv_shows', 'Favorite tv shows', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('favorite_drinks', 'Favorite drinks', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('favorite_cousine', 'Favorite cousine', 'trim'.$required_validation);
		$this->CI->form_validation->set_rules('favorite_vacation', 'Favorite vacation', 'trim'.$required_validation);
		
		if ($this->CI->form_validation->run() == FALSE){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	public function cp_interests_process(){
		//gather posted data
		$political_affiliation = $this->CI->input->post('political_affiliation');
		if(!isset($political_affiliation)) $political_affiliation = NULL;
		$religious_view = $this->CI->input->post('religious_view');
		if(!isset($religious_view)) $religious_view = NULL;
		$general_interests = $this->CI->input->post('general_interests');
		if(!isset($general_interests)) $general_interests = NULL;
		$favorite_movies = $this->CI->input->post('favorite_movies');
		if(!isset($favorite_movies)) $favorite_movies = NULL;
		$favorite_singers = $this->CI->input->post('favorite_singers');
		if(!isset($favorite_singers)) $favorite_singers = NULL;
		$favorite_actors = $this->CI->input->post('favorite_actors');
		if(!isset($favorite_actors)) $favorite_actors = NULL;
		$favorite_authors = $this->CI->input->post('favorite_authors');
		if(!isset($favorite_authors)) $favorite_authors = NULL;
		$favorite_tv_shows = $this->CI->input->post('favorite_tv_shows');
		if(!isset($favorite_tv_shows)) $favorite_tv_shows = NULL;
		$favorite_drinks = $this->CI->input->post('favorite_drinks');
		if(!isset($favorite_drinks)) $favorite_drinks = NULL;
		$favorite_cousine = $this->CI->input->post('favorite_cousine');
		if(!isset($favorite_cousine)) $favorite_cousine = NULL;
		$favorite_vacation = $this->CI->input->post('favorite_vacation');
		if(!isset($favorite_vacation)) $favorite_vacation = NULL;

		$create_profile_arr = array(
			"political_affiliation" => $political_affiliation, 
			"religious_view" => $religious_view,
			"general_interests" => $general_interests, 
			"favorite_movies" => $favorite_movies, 
			"favorite_singers" => $favorite_singers, 
			"favorite_actors" => $favorite_actors, 
			"favorite_authors" => $favorite_authors, 
			"favorite_tv_shows" => $favorite_tv_shows, 
			"favorite_drinks" => $favorite_drinks, 
			"favorite_cousine" => $favorite_cousine,
			"favorite_vacation" => $favorite_vacation,
			"is_step2_completed" => 1
		);
		
		$user_id = $this->CI->session->userdata('user_user_id');
		
		$user_profile_id = $this->CI->session->userdata('user_profile_id');
		//$this->createprofile_model->user_create_profile2($create_profile_arr, $user_profile_id);
		$this->CI->createprofile_model->user_create_profile($create_profile_arr, $user_profile_id);
		
		// update step to open field in user table and set next method
		$step_to_open_arr = array('step_to_open'=>'cp_education');
		$this->CI->createprofile_model->update_step_to_open($step_to_open_arr, $user_id);
	}
	
	/**********************  Functions of step 2 starts  *********************************/
	
	/**********************  Functions of step 3 starts  *********************************/
	public function cp_education_validations(){
		$required_validation = "|required";
		$skip = $this->CI->input->post('skip_val');
		if(isset($skip) && $skip==1)
		{
			$required_validation = "";
		}		
		//non required validations
		$this->CI->form_validation->set_rules('education_level', 'Education level', 'trim'.$required_validation.'');
		$this->CI->form_validation->set_rules('high_school_year', 'High school class of', 'trim');
		$this->CI->form_validation->set_rules('university', 'University class of', 'trim');
		$this->CI->form_validation->set_rules('post_grad_university', 'Post grad university class of', 'trim');
		$this->CI->form_validation->set_rules('employment_industry', 'Employment industry', 'trim'.$required_validation.'');
		$this->CI->form_validation->set_rules('employer', 'Employer', 'trim'.$required_validation.'');
		
		if($this->CI->form_validation->run() == FALSE){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}	
		
	public function cp_education_load_data(){
		// Gather data from master tables
		$view_data['high_school_year_result'] = $this->CI->common_model->get_high_school_year();
		$view_data['education_level_result'] = $this->CI->common_model->get_education_level();
		$view_data['university_result'] = $this->CI->common_model->get_university();
		$view_data['post_grad_university_result'] = $this->CI->common_model->get_post_grad_university();

        /*$this->CI->load->model('education_model');

		$view_data['high_school_years'] = $this->CI->education_model->get_high_school_year();
		$view_data['education_levels'] = $this->CI->education_model->get_levels();
		$view_data['universities'] = $this->CI->education_model->get_university();
		$view_data['post_grad_universities'] = $this->CI->education_model->get_post_grad_university();*/

		return $view_data;
	}
	
	public function cp_education_process(){
		//gather posted data and set condition for non posted fields
		$high_school_year = $this->CI->input->post('high_school_year');
		if(!isset($high_school_year) || $high_school_year=="") $high_school_year = NULL;
		$education_level = $this->CI->input->post('education_level');
		if(!isset($education_level) || $education_level=="") $education_level = NULL;
		$university = $this->CI->input->post('university');
		if(!isset($university) || $university=="") $university = NULL;
		$post_grad_university = $this->CI->input->post('post_grad_university');
		if(!isset($post_grad_university) || $post_grad_university=="") $post_grad_university = NULL;
		$employment_industry = $this->CI->input->post('employment_industry');
		if(!isset($employment_industry) || $employment_industry=="") $employment_industry = NULL;
		$employer = $this->CI->input->post('employer');
		if(!isset($employer) || $employer=="") $employer = NULL;

		$create_profile_arr = array(
			"high_school_year_id" => $high_school_year, 
			"education_level_id" => $education_level,
			"university_id" => $university, 
			"post_grad_university_id" => $post_grad_university, 
			"employment_industry" => $employment_industry, 
			"employer" => $employer, 
			"is_step3_completed" => 1
		);
		
		$user_id = $this->CI->session->userdata('user_user_id');
		$user_profile_id = $this->CI->session->userdata('user_profile_id');
		$this->CI->createprofile_model->user_create_profile($create_profile_arr, $user_profile_id);
		
		// update step to open field in user table and set next method
		$step_to_open_arr = array('step_to_open'=>'cp_becomequalified');
		$this->CI->createprofile_model->update_step_to_open($step_to_open_arr, $user_id);
	}
	/**********************  Functions of step 3 ends  *********************************/
	
	/**********************  Functions of step 4 starts  *********************************/
	public function cp_becomequalified_process(){
		//gather posted data
		// added by 16 June for policing system start
		$website_link = $this->CI->input->post('website_link');
		$about_chatching = $this->CI->input->post('about_chatching');
		if($website_link != ""){
			$this->CI->createprofile_model->invite_report($website_link,$about_chatching);
		}
		
		$parent_id =  $this->CI->input->post('inviter_list');
		$user_id = $this->CI->session->userdata('user_user_id');
		if($parent_id != ""){
			$this->CI->createprofile_model->add_parent($user_id,$parent_id);
			$this->CI->user_model->save_parent_level($user_id,$parent_id,1);
		}

		// added by 16 June for policing system end
		$is_register_for_points = $this->CI->input->post('is_register_for_points');
		$create_profile_arr = array(
			"is_register_for_points" => $is_register_for_points, 
			"is_step4_completed" => 1
		);
		
		$user_profile_id = $this->CI->session->userdata('user_profile_id');
		$this->CI->createprofile_model->user_create_profile($create_profile_arr, $user_profile_id);
		
		// update step to open field in user table and set next method
		$step_to_open_arr = array('step_to_open'=>'cp_invitefriends');
		$this->CI->createprofile_model->update_step_to_open($step_to_open_arr, $user_id);
	}
	
	public function cp_becomequalified_ni_process(){
		// added by 16 June for policing system start
		$website_link = $this->CI->input->post('website_link');
		$about_chatching = $this->CI->input->post('about_chatching');
		if($website_link != "")
		{
			$this->CI->createprofile_model->invite_report($website_link,$about_chatching);
		}
		// added by 16 June for policing system end
		
		// user does not belongs to incentive therefore set is_register_for_points to 0
		$is_register_for_points = 0;
		
		$create_profile_arr = array(
			"is_register_for_points" => $is_register_for_points, 
			"is_step4_completed" => 1
		);
		
		$user_profile_id = $this->CI->session->userdata('user_profile_id');
		$user_id = $this->CI->session->userdata('user_user_id');
		
		//$this->createprofile_model->user_create_profile4($create_profile_arr, $user_profile_id);
		$this->CI->createprofile_model->user_create_profile($create_profile_arr, $user_profile_id);
		
		// update step to open field in user table and set next method
		$step_to_open_arr = array('step_to_open'=>'cp_invitefriends');
		$this->CI->createprofile_model->update_step_to_open($step_to_open_arr, $user_id);
	}
	
	public function cp_becomequalified_ni_load_data_process(){
		$user_id = $this->CI->session->userdata('user_user_id');
		$state_name = array();
		$state_name = explode(',', get_location($user_id));
		if(count($state_name) > 0){
			@$data['state_name'] =  $state_name[1];
		}
		else{
			$data['state_name'] =  "";
		}
		return $data;
	}
	
	/**********************  Functions of step 4 ends  *********************************/
	
	
	/**********************  Functions of step 5 starts  *********************************/
	public function cp_invitefriends_process()
	{
		$mail_arr 			=	array();
		$ers					=	array(); 
		$oks					=	array();
		$import_ok			=	false; 
		$done					=	false; 
		$data					=	array();
		$mail_count 		=	0;
		$data['contacts']	=	array();
		$data['ragister_emails'] = array();
                
		$incentive_program_state_id = $this->CI->session->userdata('incentive_program_state_id');

		if(isset($incentive_program_state_id) && $incentive_program_state_id!="")
		{		
			// unset incentive program state session
			$this->CI->session->unset_userdata('incentive_program_state_id');
		}	
		
		$contacts_area = $this->CI->input->post('contacts_area');

		$step 		= 	$this->CI->uri->segment(3);
		$step_pr 	= 	$this->CI->input->post('step');
		
		
		if($this->CI->input->post())
		{
					// added by 16 June for policing system start
					$website_link 			= 	$this->CI->input->post('website_link');
					$about_chatching 		= 	$this->CI->input->post('about_chatching');
					$this->CI->createprofile_model->invite_report($website_link,$about_chatching);
					$parent_id 				=  $this->CI->input->post('inviter_list');
			
					$user_id 				= 	$this->CI->session->userdata('user_user_id');
			
					if($parent_id != "")
					{
						$this->CI->createprofile_model->add_parent($user_id,$parent_id);
						$this->CI->user_model->save_parent_level($user_id,$parent_id,1);
					}
			
					// update step to open field in user table and set next method
					$step_to_open_arr 	= 		array('step_to_open'=>'profile');
			
					$this->CI->createprofile_model->update_step_to_open($step_to_open_arr, $user_id);

					$skip 		= 		$this->CI->input->post('skip_val');
			
					if(isset($skip) && $skip==1)
					{       
						redirect('/profile', 'location');
					}		
		}

		if($step)
		{
			$skip 	=	 $this->CI->input->post('skip_val');
			if(isset($skip) && $skip==1)
			{
				redirect('/profile', 'location');
			}		
		
			if($step	==	'import_id')
			{
				// require_once 'cloudsponge/csimport.php';
			
				$step_val 	= 	$this->CI->uri->segment(4);
				$import_id 	= 	$step_val;
				$continue 	= 	false;
				$reload 		= 	true;
				$events 		= 	$this->CI->csimport->get_events($import_id);
						
				foreach ($events as $event)
				{
						// look for an error event... 
						if ($event['status'] == 'ERROR'){ 
							$reload 		=	 false;
							$event['description'];
						}
					
						// look for the COMPLETED/COMPLETE event... this indicates the import is completely done
						if ($event['event_type'] == "COMPLETE" && $event['status'] == "COMPLETED" && $event['value'] == 0)
						{
								$continue 	= 	true;
								$reload 		= 	false;
						}
				}

				if(!is_null($events)){} 

				if ($reload)
				{
					$timeout = 2000; 
				?>
					<script type="text/javascript"> 
					// only execute the timeout if the popup is still open, if the user canceled by closing it, then we are done...
					// This could be cleaned up by using ajax, instead of an entire page refresh
					setTimeout("window.location = '<?php echo $import_id; ?>'", <?php echo $timeout; ?>);
					</script>
				<?php 
				}
				else if($continue)
				{
						// redirect the page to the final step.
						/****** Step 3 ****/
						$contacts_result 	= 		$this->CI->csimport->get_contacts($import_id);
						$contacts 		 	=		$contacts_result['contacts'];

						if(!is_null($contacts) && count($contacts)>0)
						{
							foreach($contacts as $con)
							{
								$email 				 = @$con->emails[0]['value'];
								$contacts1[$email] = $con->first_name;
							}
							$data['contacts'] 	 = 	$contacts1;
							
					/*--------------------------------------------------------
						Check fetched email adderess already reagisterd or not 										
					----------------------------------------------------------*/
						foreach($contacts1 as $key => $val)
						{
							$mail_arr[$mail_count] 	=	 $key;
							$mail_count++;
						}
						// $email_separated 			= implode(",", $mail_arr);
						$data['ragister_emails'] 	=	$this->CI->createprofile_model->ragister_email($mail_arr);

						
						
						//--------- End ---------- 

					/*--------------------------------------------------------
									 Import emails into database table 
					--------------------------------------------------------*/
						$user_id 		= 		$this->CI->session->userdata('user_user_id'); // Get user id
						$this->CI->createprofile_model->import_address($contacts1,$user_id); // Function for import emails
					//------- End --------
						?>
						
							<script type="text/javascript">
							popup = window.open('', '_popupWindow');
							if (undefined != popup) {
							popup.close();
							}
							</script>
							<?php
							}
						}
			
						if(isset($ers) && count($ers)>0)
						{
							$this->CI->template->load('template','createprofile/createprofile5',$ers);
						}
						else
						{
								$this->CI->template->load('template','createprofile/createprofile6',$data);			
						}
					}
				}
			elseif ($step_pr == 'send_invites')
			{
				// get invitation limit
				$invite_friend_limit 	=	 $this->CI->config->item('invite_friend_limit');
				
				if(isset($invite_friend_limit) && $invite_friend_limit!="") {
					$data['invite_friend_limit'] 	=	 $invite_friend_limit;
				}
	
				$contacts 				= 	$this->CI->input->post('contacts');
				$contacts 				= 	(count($contacts)>0?$contacts:array());
				
				// keep data to return array
				$data['contacts'] 	= 	$contacts;
				$selected_contacts	=	array();
				$contacts				=	array();

				foreach ($this->CI->input->post() as $key=>$val)
				if (strpos($key,'check_')!==false)
					$selected_contacts[$this->CI->input->post('email_'.$val)]	=	$this->CI->input->post('name_'.$val);
				elseif (strpos($key,'email_')!==false)
				{
					$temp			=	explode('_',$key);
					$counter		=	$temp[1];
					if (is_numeric($temp[1])) $contacts[$val]	=	$this->CI->input->post('name_'.$temp[1]);
				}

				// Check wheather invite friend mail is registered or not if reg insert data in friend table
				$this->check_invitefriend_mail($selected_contacts);

				if (count($selected_contacts)==0)
				{
					$data['error_contacts'] 	= $this->CI->lang->line('create_profile_you_havent_selected_any_contacts');
					$ers['error_contacts'] 		= $this->CI->lang->line('create_profile_you_havent_selected_any_contacts');
					$this->CI->template->load('template','createprofile/createprofile6',$data);
				}
				else if(count($selected_contacts)>$invite_friend_limit)
				{
					$data['error_contacts'] 	= $this->CI->lang->line('create_profile_you_havent_selected_any_contacts');
					$ers['error_contacts']  	= $this->CI->lang->line('create_profile_you_havent_selected_any_contacts');
					$this->template->load('template','createprofile/createprofile6',$data);
				}
				else{
					//call function to send invitation / friend request
					$user_id	 = $this->CI->session->userdata('user_user_id');
					$filtered_contacts_new 	= array(); 
					$get_flag = '';
					
					//call function to send invitation / friend request
					$counter = 0; // counter initilized
					foreach ($selected_contacts as $email=>$name):
					$get_flag 	= $this->CI->incentive_invitation_system->send_invitation($user_id,$email);
					if($get_flag==1)
					{
						$filtered_contacts_new[1][]=$email;
						$counter++;
					}
					else if($get_flag==2)
					{
						$filtered_contacts_new[2][]=$email;
						$counter++;
					}
					else if($get_flag==3)
					$filtered_contacts_new[3][]=$email;
					else if($get_flag==4)
					$filtered_contacts_new[4][]=$email;
					else if($get_flag==5)
					$filtered_contacts_new[5][]=$email;
					else if($get_flag==6)
					$filtered_contacts_new[6][]=$email;							
					endforeach;
					if($counter >= 50)
					{
						/**---------------------------------------------------------
						* Comment:for point calculation for more than 50 invitation sent
						* activity type  24 : bonus point for more than 50 invitation 
						* ---------------------------------------------------------**/							
						$this->CI->point_calculation->add_point($this->CI->session->userdata('user_user_id'),24,0);
					}
					
					$data['filtered_contacts'] 	= $filtered_contacts_new;
					if($get_flag==3) {
						$data['incentive_exists']	=	$this->CI->lang->line('create_profile_there_are_some_emails_already_having_incentive_invitation');
					}	
					if(check_profile_info()){
							$this->point_calculation->add_point($user_id,26,'');
						}
					$data['mails']	=	$this->CI->lang->line('create_profile_invitation_emails_have_been_sent');
					$this->CI->template->load('template','createprofile/createprofile7',$data);
				}
			}
			else if($contacts_area !=""){
                                        $contacts_list = explode(",", $contacts_area);
                                        $contacts = array();
                                        
                                        foreach($contacts_list as $value){
                                            $value = trim($value);
                                            if ($this->is_valid_email($value)) {
                                                $contacts[$value] = $value;
                                            }
                                        }	

                                        $data['oi_session_id'] = '';
                                        $data['provider_box'] = 'custom_user_contacts';

                                        $email = 'info@chatching.com'; // just for testing no effect on emails going; sender will be the user (inviter)
                                        $data['email_box'] = $email;

                                        if(isset($data['contacts']) && count($data['contacts'])>0)
                                        $data['contacts'] = array_merge($contacts, $data['contacts']);
                                        else
                                        $data['contacts'] = $contacts;

					if(isset($ers) && count($ers)>0){
						$this->CI->template->load('template','createprofile/createprofile5',$ers);
					}
					else{
						
						//if ($inviter->showContacts()){
							$this->CI->template->load('template','createprofile/createprofile6',$data);			
						//}
					}
				} 
				else{
					$this->CI->template->load('template','createprofile/createprofile5');
				}	
	}
	
	function check_invitefriend_mail($email=''){
		 $res = $this->CI->createprofile_model->is_friend_registered($email);
		 return $res; 
	}	
	
	function is_valid_email($email) {
            $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
            if (preg_match($regex, $email)) {
                 return TRUE;
            } else { 
                 return FALSE;
            } 
        }
	/**********************  Functions of step 5 ends  *********************************/
}

