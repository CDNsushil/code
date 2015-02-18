<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
*/

class factory_profile   {

    // to hold current language set by user
    public   	$lang;
    // $view_data	= to hold any data related to view
    public		$view_data	=	array('login_error_message'=>'');




    public function __construct()
    {
        $this->CI =& get_instance();

        $this->lang 			= get_session_language();
        $this->init();
    }



    public function init()
    {
        // session start is used for commet chat
        session_start();
        /*------------------------------------------*/
        //Load required Model files
        $this->CI->load->model('user_profile');
        $this->CI->load->model('page_model');
        $this->CI->load->model('page_setting/page_setting_model');
        $this->CI->load->model('album_model');
        $this->CI->load->helper('common');
        $this->CI->load->library('point_calculation');
        $this->CI->load->library('display_advert');
        $this->CI->load->model('common_model');
        $this->CI->load->language('notification');
        $this->CI->load->language('user_profile');
        $this->CI->load->language('profile_template');
        $this->CI->load->model('oauth_model');
        $this->CI->load->helper('page_helper');

        /*--------------------------------------------------------
       * Comment: function for site is running in Iframe or not
       * -----------------------------------------------------*/
        check_site_reference();
        /*--------------------------------------------------------
       * Comment: function for check user login
       * -----------------------------------------------------*/
        loginCheck();
    }

    /*----------Factory method for profile setting page-----------*/
    public function profile_setting_process()
    {   
        $this->view_data['is_connected_to_facebook'] = $this->CI->facebook_library->getUser();
        
        $userProfile = $this->CI->user_profile->get_profile();
        $user_id     = $this->view_data['user_id'];
        $this->view_data['user_profile'] 	= 	$userProfile;
        $country_id  = $userProfile->country_id;
        $state_id    = $userProfile->state_id;
        $city_id     = $userProfile->city_id;

        // get country; state; city data
        $country_query = $this->CI->common_model->get_country();
        if($country_query!=false) $this->view_data['country_query'] = $country_query;

        if(isset($country_id) && $country_id>0)			{
            $state_query = $this->CI->common_model->get_states_by_country($country_id);
            if($state_query!=false) $this->view_data['state_query'] = $state_query;
        }else{
            $this->view_data['state_query'] = array();
        }

        if(isset($state_id) && $state_id>0 && $country_id>0){
            $city_query = $this->CI->common_model->get_cities_by_state($state_id);
            if($city_query!=false) $this->view_data['city_query'] = $city_query;
        }else{
            $this->view_data['city_query'] = array();
        }

        // get current user location
        $this->view_data['user_location'] = $this->CI->user_profile->get_user_location();

        //display adverts
        $page="profile";
        $result = $this->CI->display_advert->display_advert($page);
        if($result!=false){
            $this->view_data['display_advert'] = $result;
        }

        // Security setting variable access
        $this->view_data['secure_browsing']     = $this->CI->user_profile->get_security('secure_browsing');
        $this->view_data['secure_approvals']    = $this->CI->user_profile->get_security('login_approvals');
        $this->view_data['secure_notification'] = $this->CI->user_profile->get_security('login_notification');

        // Get login country detail
        $ip_data = $this->CI->session->userdata('time_zone_array');

        $this->view_data['cityName']    = strtolower($ip_data['cityName']);
        $this->view_data['regionName']  = strtolower($ip_data['regionName']);
        $this->view_data['countryName'] = strtolower($ip_data['countryName']);

        // Get device name for browser not mobile device
        $device_name = $this->CI->user_profile->getBrowser();
        $this->view_data['device_type'] =  $device_name['name'];
        $this->view_data['device_name'] =  $device_name['platform'];
        // Get
        $sessionDetail = $this->CI->user_profile->getSessionDetail();

        $this->view_data['sessionDetail'] = $sessionDetail;
        // End
        /*-- Get active account status */
        $this->view_data['active_status'] = $this->CI->user_profile->get_account_status();
		$this->view_data['security_question'] = $this->CI->user_profile->get_security_question($user_id);
        $id = $this->CI->session->userdata('user_user_id');
        $this->view_data['user_app_key'] = $this->CI->user_profile->retrieve_app_password($id);
        //check if the function call from index funciton then load user_profile view else load user_profile_setting view
        //if($is_index){
        //  $this->load_view('profile/user_profile',$this->view_data);
        //}else{
		
		//print_r($this->view_data);
		
         $this->load_view('profile/user_profile_setting',$this->view_data);
        // }
    }

    public function profile_manage_page_process()
    {

        // get country; state; city data
        $page_id = $this->view_data['page_id'];
        $user_id = $this->view_data['user_id'];
        $country_query = $this->CI->common_model->get_country();
        if($country_query!=false) $this->view_data['country_query'] = $country_query;

        if(isset($country_id) && $country_id>0)
        {
            $state_query = $this->CI->common_model->get_states_by_country($country_id);
            if($state_query!=false) $this->view_data['state_query'] = $state_query;
        }
        else
        {
            $this->view_data['state_query'] = array();
        }

        if(isset($state_id) && $state_id>0 && $country_id>0)
        {
            $city_query = $this->CI->common_model->get_cities_by_state($state_id);
            if($city_query!=false) $this->view_data['city_query'] = $city_query;
        }
        else
        {
            $this->view_data['city_query'] = array();
        }

        // get current user location
        $this->view_data['user_location'] = $this->CI->user_profile->get_user_location();

        // get page action category, page title and action category key
        $action_category_arr = $this->CI->page_setting_model->get_action_catid($page_id);
        $action_category_id = $action_category_arr->action_category_id;
        $this->view_data['action_category_id'] = $action_category_id;
        $this->view_data['action_category_key'] = $action_category_arr->action_category_key;
        $this->view_data['page_title'] = $action_category_arr->page_title;

        // Get concert page data
        $table_name = 'page_concert';
        $this->view_data['concert_list'] = $this->CI->page_setting_model->get_data_list($table_name,$page_id,$user_id);

        // get page profile album id and profile image
        $media_info = $this->CI->album_model->get_page_picture_data($action_category_id, $page_id);
        $this->view_data['media_info'] = $media_info;

    }

    public function update_location_process()
    {
        //gather posted data and set condition for non posted fields
        $country = $this->CI->input->post('country');
        $user_id = $this->CI->session->userdata('user_user_id');
        if($this->CI->input->post('country') != 233)
        {
            $state = NULL;
            $city  = NULL;
        }
        else{
            $state = $this->CI->input->post('state');
            $city  = $this->CI->input->post('city');
        }

        $profile_arr = array(
            "country_id" => $country,
            "state_id"   => $state,
            "city_id"    => $city
        );
        // check if state updated then only call this change
        $is_state_changed = $this->CI->common_model->check_state_changed($user_id, $state);

        $result = $this->CI->user_profile->update_location($profile_arr, $user_id);
        // if state changed then change the status of user registered for points
        if(!$is_state_changed)
        {
            // keep this to zero on state update because we offers alert to participate user in incentive program
            $is_register_for_points = 0;

            $profile_arr_new = array(
                "is_register_for_points" => $is_register_for_points
            );

            // if state is in incentive program then change user profile field to 1
            $this->CI->user_profile->update_user_incentive_status($profile_arr_new, $user_id);
        }
        return $result;
    }

    public function send_notification_process($user_id)
    {
        $to 			= get_email($user_id);
        $to_name		= get_username($user_id);
        $mail_head_data = array('to'=>$to);
        $mail_body_data = array('host_name'=>$to_name);
        /*--------------notification check----------------*/
        $notification_type_id = 47;
        $notification_post_user = check_notification($user_id,$notification_type_id);
        if(!empty($notification_post_user))
        {
            if($notification_post_user[0]->email==1){
                $this->CI->email_template->send_email('__milestone_point_reach_notification___',$mail_head_data,$mail_body_data);
            }
            if($notification_post_user[0]->sms==1){   /*--1 for check user had activated the sms notification--*/
                /*--sms code here--*/
            }
        }
        return true;
    }


    public function update_security_answer_process()
    {
        /*post security question 1 and answer*/
        $security_question1 = $this->CI->input->post('security_question1');
        $custom_q1          = $this->CI->input->post('custom_q1');
        $security_a1        = $this->CI->input->post('security_a1');

        /*post security question 2 and answer*/
        $security_question2 = $this->CI->input->post('security_question2');
        $custom_q2          = $this->CI->input->post('custom_q2');
        $security_a2        = $this->CI->input->post('security_a2');

        /*post security question 3 and answer*/
        $security_question3 = $this->CI->input->post('security_question3');
        $custom_q3          = $this->CI->input->post('custom_q3');
        $security_a3        = $this->CI->input->post('security_a3');

        $user_id            = $this->CI->session->userdata('user_user_id');

        if(!empty($custom_q1)) {
            $security_question1 = $this->CI->user_profile->add_custom_question(array('question'=>$custom_q1,'user_id'=>$user_id));
        }

        if(!empty($custom_q2)) {
            $security_question2 = $this->CI->user_profile->add_custom_question(array('question'=>$custom_q2,'user_id'=>$user_id));
        }

        if(!empty($custom_q3)) {
            $security_question3 = $this->CI->user_profile->add_custom_question(array('question'=>$custom_q3,'user_id'=>$user_id));
        }

        /*create array of security question and answer to update*/
        $security_qa_arr = array(
            "security_question" => ($security_question1.','.$security_question2.','.$security_question3),
            "answer" 	 => $security_a1,
            "answer1" 	 => $security_a2,
            "answer2" 	 => $security_a3
        );

        $result = $this->CI->user_profile->update_security_qa($security_qa_arr, $user_id);
        return $result;
    }


    public function edit_profile_process()
    {
        $this->CI->load->model('dropdown_model');
        $this->CI->load->helper('chatching_form');

        $this->view_data['all_languages']   = $this->CI->user_profile->get_all_languages();
        $this->view_data['userProfile']     = $this->CI->user_profile->get_profile();
        $this->view_data['countries']       = $this->CI->dropdown_model->get_country();
        $this->view_data['states']          = $this->CI->dropdown_model->get_states_by_country(@$this->view_data['userProfile']->country_id);
        $this->view_data['cities']          = $this->CI->dropdown_model->get_cities_by_state(@$this->view_data['userProfile']->state_id);
        $this->view_data['user_location']   = $this->CI->user_profile->get_user_location();
        $this->view_data['user_id']         = $this->CI->uri->segment(3);
        $this->view_data['user_id']         = empty($this->view_data['user_id']) ? $this->CI->session->userdata('user_user_id'):  $this->view_data['user_id'];

        $this->load_view('profile/edit_profile',$this->view_data);
    }


    public function load_view($view='profile/user_profile',$data){
        $this->CI->profile_template->load('profile_includes/profile_template',$view,$data);
    }

    function delete_active_session($session_id){
        $res = $this->CI->user_profile->delete_active_session($session_id);
        return $res;
    }
}
