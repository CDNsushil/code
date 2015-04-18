<?php
/**
 * Chatching user_profile Model Class
 *
 *  get user profile from DB
 *
 *  @category	Model
 *  @author		CDN Solutions
 *
 */
class User_profile extends MY_Model {

    private $read_db;
    protected $primary_key = 'profile_id';
    protected $_table = 'user_profile';
    private $completeness = array(
        'work_history'      => '10',
        'education_history' => '10',
        'addresses'         => '5',
        'phones'            => '5',
        'email_address'     => '5',
        'interest'          => '10',
        'langauge'          => '5',
    );
    /**
     * Constructor
     */
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->read_db = $this->load->database('read', TRUE);
        $this->validate[] = array(
            'field'   => 'country',
            'label'   => 'Country',
            'rules'   => 'required'
        );
        $this->validate[] = array(
            'field'   => 'city',
            'label'   => 'City',
            'rules'   => 'required'
        );
        $this->validate[] = array(
            'field'   => 'state',
            'label'   => 'State',
            'rules'   => 'required'
        );
    }

    /*
     * @Access: public
     * Comment: This function get user profile  DB
     *@param
     *@return database object of user profile data
     */
    public function get_profile($userId='')
    {
        if($userId=='')
            $userId = $this->session->userdata('user_user_id');
        /*----------------------------------------------------------------------
           * Comment : Memcached Implimentation  for user Profile
           *---------------------------------------------------------------------- */
        //$user_profile = $this->memcached_library->get('user_profile_'.$userId);
        $user_profile='';
        if(!$user_profile){
            $this->read_db->where('user_profile.user_id',$userId);
            $this->read_db->select('user.user_id,user.facebook_id, user.firstname, user.lastname, user.email, user_profile.*,country.country_id,country.country_name,state.state_id,state.state_name,city.city_id,city.city_name,carrier.carrier_id,carrier.carrier_name,high_school_year.high_school_year_id, high_school_year.year,education_level.education_level_id, education_level.education_level,university.university_id,university.year');
            $this->read_db->from('user_profile');
            $this->read_db->join('user', 'user.user_id = user_profile.user_id','left');
            $this->read_db->join('country', 'country.country_id = user_profile.country_id','left');
            $this->read_db->join('state', 'state.state_id = user_profile.state_id','left');
            $this->read_db->join('city', 'city.city_id = user_profile.city_id','left');
            $this->read_db->join('carrier', 'carrier.carrier_id = user_profile.carrier_id','left');
            $this->read_db->join('high_school_year', 'high_school_year.high_school_year_id = user_profile.high_school_year_id','left');
            $this->read_db->join('education_level',  'education_level.education_level_id = user_profile.education_level_id','left');
            $this->read_db->join('university',  'university.university_id = user_profile.university_id','left');
            $result	= $this->read_db->get();

            if($result->num_rows() > 0)
            {
                $user_result = $result->row();
                $user_result->work_history = json_decode(@$user_result->work_history);
                $user_result->education_history = json_decode(@$user_result->education_history);
                $user_result->phones = json_decode(@$user_result->phones);
                $user_result->addresses= json_decode(@$user_result->address);

                // Store the user data in memcashed varaible
                $this->memcached_library->add('user_profile_'.$userId, $user_result, $this->config->item('memcache_user_data_time'));
                return $user_result;

            }
            else
            {
                return false;
            }
        }else{
            return $user_profile;
        }
    }

    /**
     * Comment: This function udpate user profile in database
     * @param array $data
     * @param null $user_id
     * @return bool
     *
     */
    public function update_profile($data = array(), $user_id = null)
    {
        $this->load->model('user_model');
        if(empty($data))
        {
            return false;
        }
        $user_data		=	array(
            'firstname'	=>	@$data['firstname'],
            'lastname'	=>	@$data['lastname'],
        );
        $user_id = empty($user_id) ? $this->session->userdata('user_user_id'): $user_id;
        if(!$this->user_model->update($user_id, $user_data))
        {
            return false;
        }

        $profile_data	=	 array(
            'city_id'	            =>	@$data['city'],
            'state_id'	            =>	@$data['state'],
            'country_id'	        =>	@$data['country'],
            'secondary_email'	    =>	@$data['secondary_email'],
            'language_id'	        =>	@$data['language'],
            'language_level_id'	    =>	@$data['language_level'],
            'education_level_id'	=>  1,
        );
        $profile_data = $this->save_tags($profile_data, $data);

        if(!$this->update_by( array('user_id' => $user_id), $profile_data))
        {
            return false;
        }
        $this->user_model->update_session($user_id, array_merge($profile_data, $user_data));
        return true;
    }
    /**
     * @param $profile_data
     * @param $data
     * @return array
     */
    private function save_tags($profile_data, $data)
    {

        $user_interests = @empty($data['interest'])? array() :@$data['interest'];

        $this->load->model('user_interest_model');

        foreach($user_interests as $type => $interests )
        {
            foreach($interests as $interest)
            {
                $this->user_interest_model->save_interest(array('type' => $type, 'text' => $interest));
            }
            $profile_data[$type] = implode(', ', $interests);
        }
        //@todo need to save to another table;
        $work_history = @empty($data['work_history'])? array() :@$data['work_history'];
        foreach($work_history as $work)
        {
            $this->user_interest_model->save_interest(array('type' => 'employer', 'text' => @$work['employer']));
            $this->user_interest_model->save_interest(array('type' => 'employer_industry', 'text' => @$work['employer_industry']));
            $work['positions'] = @empty($work['positions']) ? array(): $work['positions'];
            foreach($work['positions'] as $position)
            {
                $this->user_interest_model->save_interest(array('type' => 'positions', 'text' => @$position));
            }
        }

        $profile_data['work_history'] = json_encode($work_history);

        //@todo need to save to another table;
        $education_history = @empty($data['education_history'])? array() :@$data['education_history'];
        foreach($education_history as $education)
        {
            $this->user_interest_model->save_interest(array('type' => 'institute_name', 'text' => @$education['institute_name']));
            $this->user_interest_model->save_interest(array('type' => 'institute_type', 'text' => @$education['institute_type']));
            $this->user_interest_model->save_interest(array('type' => 'degree_earned', 'text' => @$education['degree_earned']));
        }
        $profile_data['education_history'] = json_encode($education_history);

        //@todo need to save to another table;
        $phones = @empty($data['phones'])? array() :@$data['phones'];
        foreach($phones as $phone)
        {
            $this->user_interest_model->save_interest(array('type' => 'phone_carrier', 'text' => @$phone['phone_carrier']));
        }

        $profile_data['phones'] = json_encode($phones);

        //@todo need to save to another table;

        $main_address = @$data['main_address'];
        $addresses = @empty($data['addresses'])? array() :@$data['addresses'];
        if(is_numeric($main_address))
        {
            @$addresses[$main_address]['main_address'] = true;
        }
        foreach($addresses as $address)
        {
            $this->user_interest_model->save_interest(array('type' => 'address', 'text' => @$address['address']));
        }
        $profile_data['address'] = json_encode($addresses);
        return $profile_data;
    }

    /*
     * @Access: public
     * Comment: This function udpate user's currenmt location in database
     *@param user profile array, user id
     *@return flag true/false
     */
    public function update_location($profile_arr=array(), $user_id='')
    {
        if(count($profile_arr)>0 && $user_id!="")
        {
            $this->read_db->where('user_id',$user_id);
            $res=$this->read_db->update('user_profile',$profile_arr);
            return true;
        }
    }

    /*
     * @Access: public
     * Comment: This function udpate user incentive status in database
     *@param is_register_for_points in profile_arr variable
     *@return flag true/false
     */
    public function update_user_incentive_status($profile_arr=array(), $user_id='')
    {
        if(count($profile_arr)>0 && $user_id!="")
        {
            $this->read_db->where('user_id',$user_id);
            $this->read_db->update('user_profile',$profile_arr);
            return true;
        }
    }

    /*
     * @Access: public
     * Comment: This function get user current location from database
     *@param
     *@return database object of user profile data or flag false
     */
    public function get_user_location()
    {
        $user_id = $this->session->userdata('user_user_id');
        /*----------------------------------------------------------------------
           * Comment : Memcached Implimentation  for user location detail
           *---------------------------------------------------------------------- */
        $user_location = $this->memcached_library->get('user_location_'.$user_id);
        if(!$user_location || !isset($user_location[0]->country_id)){
            $this->read_db->select('city.city_name as user_city, state.state_id as state_id, country.country_id as country_id, state.state_name as user_state, country.country_name as user_country');
            $this->read_db->where('user_profile.user_id',$user_id);
            $this->read_db->from('user_profile');
            $this->read_db->join('user', 'user.user_id = user_profile.user_id');
            $this->read_db->join('country', 'country.country_id = user_profile.country_id','left');
            $this->read_db->join('state', 'state.state_id = user_profile.state_id','left');
            $this->read_db->join('city', 'city.city_id = user_profile.city_id','left');
            $result	= $this->read_db->get();
            if($result->num_rows() > 0)
            {
                $user_result = $result->result();
                // Store the user data in memcashed varaible
                $this->memcached_library->add('user_location_'.$user_id,$user_result,$this->config->item('memcache_user_data_time'));
                return $user_result;
            }
            else
            {
                return false;
            }
        }else{
            return $user_location;
        }
    }


    /*
     * @Access: public
     * Comment: This function to set user profile iamge path  in database
     *@param
     *@return flag true/false
     */
    public function edit_image()
    {
        $userId = $this->session->userdata('user_user_id');
        $profile_picture	=	$this->input->post('profile_picture');
        $data = array('profile_picture' => $profile_picture);
        $this->read_db->where('user_id',$userId);
        $this->read_db->update('user_profile',$data);
        return true;
    }

    /*
     * @Access: public
     * Comment: This function get user points from database
     *@param user_id, fileter value like today, week, month in variable day
     *@return user total point if any or 0
     */
    public function get_user_points($user_id,$day = "",$date = "",$child_id='')
    {
        /* //OPTIMIZATION
              I appriciate if you can use switch case instade of is else structure

          //OPTIMIZATION */
        $query = "";
        if($child_id != "")
        {
            $query = " AND child_id = ".$child_id;
            $this->read_db->where('child_id',$child_id);
        }
        if($day == 'today' && $date != "")
        {
            $this->read_db->where('CAST(cc_point.datetime AS DATE)=',$date);
            $this->read_db->where('user_id',$user_id);
            $this->read_db->select('SUM(point) as total_point');
            $result = $this->read_db->get('point');
        }
        else if($day == 'today')
        {
            $this->read_db->where('CAST(cc_point.datetime AS DATE)=','CURDATE()',false);
            $this->read_db->where('user_id',$user_id);
            $this->read_db->select('SUM(point) as total_point');
            $result = $this->read_db->get('point');
        }
        else if($day 	== 	'week')
        {
            $sql = "SELECT SUM(point) as total_point FROM cc_point WHERE point > 0 AND  user_id = '".$user_id."' AND CAST(datetime AS DATE) >= (SELECT DATE_SUB(CURDATE(),  INTERVAL (DAYOFWEEK(CURDATE())-1)  DAY ))".$query;
            $result = $this->read_db->query($sql);
        }
        else if($day	==	'month')
        {
            $sql = "SELECT SUM(point) as total_point FROM cc_point WHERE point > 0 AND  user_id = '".$user_id."' AND CAST(datetime AS DATE) >= (SELECT DATE_SUB(CURDATE(),  INTERVAL (DAYOFMONTH(CURDATE())-1)  DAY ))".$query;
            $result = $this->read_db->query($sql);
        }
        else
        {
            $this->read_db->where('user_id',$user_id);
            $this->read_db->select('SUM(point) as total_point');
            $result = $this->read_db->get('point');
        }

        if($result->row()->total_point > 0)
        {
            return $result->row()->total_point;
        }
        else
        {
            return '0';
        }

    }

    /*
     * @Access: public
     * Comment: This function get points earned by user with the help of network activity from database
     *@param
     *@return database object of user points data
     */
    public function get_network_earners()
    {
        $user_id = $this->session->userdata('user_user_id');

        $this->read_db->where('parent_level.parent_id',$user_id);
        $this->read_db->select('SUM(cc_point.point) as points');
        $this->read_db->select('cc_parent_level.user_id as user_id');
        $this->read_db->from('parent_level');
        $this->read_db->join('point','point.user_id=parent_level.user_id','INNER');
        $this->read_db->group_by('user_id');
        $this->read_db->order_by('points','desc');
        $this->read_db->limit(10);
        $result = $this->read_db->get();
        return $result->result();



    }

    /*
     * @Access: public
     * Comment: This function validate from entry for user prifle page
     *@param
     *@return flag true/false
     */
    public function check_profile_info()
    {
        $user_id = $this->session->userdata('user_user_id');
        $this->read_db->select('user_profile.*');
        $this->read_db->where('user_id',$user_id);
        $query = $this->read_db->get('user_profile');
        if($query->num_rows() > 0)
        {
            $result = $query->result();

            if($result[0]->country_id!="" && $result[0]->state_id!="" && $result[0]->city_id!=""
                && $result[0]->address!="" && $result[0]->zipcode!="" && $result[0]->secondary_email!=""
                && $result[0]->home_phone!="" && $result[0]->cell_phone!="" && $result[0]->carrier_id!=""
                && $result[0]->profile_picture!="" && $result[0]->political_affiliation!="" && $result[0]->religious_view!=""
                && $result[0]->general_interests!="" && $result[0]->favorite_movies!="" && $result[0]->favorite_singers!=""
                && $result[0]->favorite_actors!="" && $result[0]->education_level_id!="" && $result[0]->employment_industry!=""
                && $result[0]->employer!=""	&& $result[0]->facebook!="")
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }



    //get  earned points from intacting with friends(weekly)
    /*
     * @Access: public
     * Comment: This function get user all earned points weekly (from start week to current week) from database
     *@param
     *@return database object of user points data
     */
    public function get_earned_points_weekly()
    {

        $user_id = $this->session->userdata('user_user_id');
        $this->read_db->where('CAST(datetime AS DATE)>=','DATE_SUB(CURDATE(),  INTERVAL (DAYOFWEEK(CURDATE())-1)  DAY )',false);
        $this->read_db->where('user_id',$user_id);
        $this->read_db->select('*');
        $this->read_db->select('SUM(point) as total_activity_point');
        $this->read_db->select('count(cc_point.activity_id) as activity_count');
        $this->read_db->select('CAST(datetime AS DATE) as dateonly');
        $this->read_db->from('point');
        $this->read_db->join('activity','activity.activity_id=point.activity_id','INNER');
        $this->read_db->group_by('dateonly');
        $result = $this->read_db->get();
        return $result->result();
    }

    //get  earned points from intacting with friends(weekly)
    /*
     * @Access: public
     * Comment: This function return current week start date
     *@param
     *@return current_week_start_date
     */
    public function get_current_week_start_date()
    {
        $currnt_week = "SELECT DATE_SUB(CURDATE(), INTERVAL (DAYOFWEEK(CURDATE())-1) DAY) as current_week_start_date";
        $q = $this->read_db->query($currnt_week);
        return $q->row()->current_week_start_date;
    }


    /*
     * @Access: public
     * Comment: This function get earned intracting points of perticular date or current date ( when user intract with friends heshe earn points)
     *@param
     *@return database object of user profile data
     */
    public function get_earned_points($date="")
    {
        $user_id = $this->session->userdata('user_user_id');

        if($date == "")
        {
            $this->read_db->where('CAST(datetime AS DATE)=','CURDATE()',false);
        }
        else
        {
            $this->read_db->where('CAST(datetime AS DATE)=',$date);
        }

        /*----------------------------------------------------------------------
           * Comment : Memcached Implimentation  for user location detail
           *---------------------------------------------------------------------- */
        //$user_point = $this->memcached_library->get('user_'.$user_id.'_earned_point_by_date_'.strtotime($date));
        //if(!$user_point){
        $this->read_db->where('user_id',$user_id);
        $this->read_db->select('*');
        $this->read_db->from('point');
        $this->read_db->join('activity','activity.activity_id=point.activity_id','INNER');
        $result = $this->read_db->get();

        $earned_point_result	=	$result->result();
        // Store the user data in memcashed varaible
        //$this->memcached_library->add('user_'.$user_id.'_earned_point_by_date_'.strtotime($date),$earned_point_result,$this->config->item('memcache_user_data_time'));
        //echo "<pre>";
        //print_r($earned_point_result); die();
        return $earned_point_result;
        //}else{
        //	return $user_point;
        //}
    }


    /*
     * @Access: public
     * Comment: This function get earned points of perticular date or current week or current date
     *@param
     *@return database object of user profile data
     */
    public function get_points_activity_wise($duration="",$date="")
    {
        $user_id = $this->session->userdata('user_user_id');
        if($duration == 'today')
        {
            //$this->read_db->where('friend_id',0);
            $this->read_db->where_in('friend_id',array(0,$user_id));
            $this->read_db->where('CAST(datetime AS DATE)=','CURDATE()',false);
        }
        else if($duration == 'week')
        {
            $this->read_db->where('CAST(datetime AS DATE)>=','DATE_SUB(CURDATE(),  INTERVAL (DAYOFWEEK(CURDATE())-1)  DAY )',false);
        }
        else if($duration == "daywise") // record get for particular date
        {
            $this->read_db->where('friend_id',0);
            $this->read_db->where('CAST(datetime AS DATE)=',$date);
        }


        $this->read_db->where('user_id',$user_id);
        $this->read_db->select('*');
        $this->read_db->select('SUM(point) as total_activity_point');
        $this->read_db->select('count(cc_point.activity_id) as activity_count');
        $this->read_db->from('point');
        $this->read_db->join('activity','activity.activity_id=point.activity_id','INNER');
        $this->read_db->group_by('point.activity_id');
        $result = $this->read_db->get();
        //echo $this->read_db->last_query(); die();
        $earned_point_result	=	$result->result();
        // Store the user data in memcashed varaible
        //$this->memcached_library->add('user_'.$user_id.$duration.'_earned_point_by_date_'.strtotime($date),$earned_point_result,$this->config->item('memcache_user_data_time'));

        return $earned_point_result;

    }

    /**
     * @INPUT : LoggedIn UserId, startdate, enddate
     * @OUTPUT : Record set of points of user from startdate to enddate
     * Comment: This function used to fetch point of given month start date and end date
     */
    function get_current_month_point($user_id,$start_date,$end_date)
    {
        if($start_date != "")
        {
            $sql = "SELECT SUM(point) as total_point, CAST(datetime AS DATE)  as dateonly	FROM cc_point
				WHERE  user_id = '".$user_id."' AND CAST(datetime AS DATE)>= '".$start_date."'  AND CAST(datetime AS DATE)<= '".$end_date."' GROUP BY dateonly ORDER BY dateonly asc";
        }
        else
        {
            $sql = "SELECT SUM(point) as total_point, CAST(datetime AS DATE)  as dateonly	FROM cc_point
				WHERE  user_id = '".$user_id."' AND CAST(datetime AS DATE)>= (SELECT DATE_SUB(CURDATE(),  INTERVAL (DAYOFMONTH(CURDATE())-1)  DAY )) GROUP BY dateonly ORDER BY dateonly asc ";

        }
        $result = $this->read_db->query($sql);
        return $result->result();
    }

    /*
     * @Access: public
     * Comment:
     *@param
     *@return

     public function get_points_datewise($date)
     {
         $user_id = $this->session->userdata('user_user_id');
         $this->read_db->where('CAST(datetime AS DATE)=',$date,false);
         $this->read_db->where('user_id',$user_id);
     }*/

    /*
     * @Access: public
     * Comment: This function update milestones check like (user get alert of first steps or not)
     *@param
     *@return database object of user profile data
     */
    public function update_alert($user_id,$level)
    {
        $this->read_db->where('user_id',$user_id);
        $this->read_db->where('level',$level);
        $result = $this->read_db->get('show_alert');
        if($result->num_rows() > 0)
        {
            $res = false;
        }
        else
        {
            $data = array(
                'level' => $level,
                'user_id' => $user_id
            );
            $this->read_db->insert('show_alert',$data);
            $res = true;
        }
        return $res;
    }








    /**
     **Author - Piyush jain
     **Function to get users custom security questions
     **Params -
     **Return - Array() contain questions and questions id
     */
    public function get_security_question($user_id) {
        /*----------------------------------------------------------------------
           * Comment : Memcached Implimentation  for user security question
           *---------------------------------------------------------------------- */
        $user_security_question = $this->memcached_library->get('user_'.$user_id.'_security_question');
        if(!$user_security_question){
            $this->read_db->select('question_id,question');
            $this->read_db->from('cc_user_security_question');
            $question = array('0',$user_id);
            $this->read_db->where_in('user_id',$question);
            $query = $this->read_db->get();
            $res_q   = $query->result();
            // Store the user data in memcashed varaible
            $this->memcached_library->add('user_'.$user_id.'_security_question',$res_q,$this->config->item('memcache_user_data_time'));

            return $res_q;
        }else{
            return $user_security_question;
        }
    }

    /**
     **Author - Piyush jain
     **Function to get security questions,answer set in user table
     **Params -
     **Return - Array() contain questions and answer
     */
    public function get_security_question_answer($user_id) {
        /*----------------------------------------------------------------------
           * Comment : Memcached Implimentation  for user security question and answer
           *---------------------------------------------------------------------- */
        $user_security_question_answer = $this->memcached_library->get('user_'.$user_id.'_security_question_answer');
        if(!$user_security_question_answer){
            $this->read_db->select('cc_user.security_question ,cc_user.answer,cc_user.answer1,cc_user.answer2');
            $this->read_db->from('cc_user');
            $this->read_db->where('cc_user.user_id',$user_id);

            $query = $this->read_db->get();
            $res1  = $query->result();
            $secuity_question =  $res1['0']->security_question;

            $q_ids = explode(',',$secuity_question);

            $i=1;
            foreach($q_ids as $question_id)
            {
                $res_q[$i++] = $this->get_question_user($question_id);
            }
            $res_q['s_a'] = $res1;

            // Store the user data in memcashed varaible
            $this->memcached_library->add('user_'.$user_id.'_security_question_answer',$res_q,$this->config->item('memcache_user_data_time'));

            return $res_q;
        }else{
            return $user_security_question_answer;
        }

    }

    /**
     **Author - Piyush jain
     **Function to question by question id
     **Params - question id
     **Return - question array
     */
    public function get_question_user($q_id) {
        $this->read_db->select('question,question_id');
        $this->read_db->where_in('question_id',$q_id);
        $query = $this->read_db->get('cc_user_security_question');
        $res_q = $query->result();
        if(!empty($res_q)){
            $q = $res_q[0]->question;
            $a = $res_q[0]->question_id;
            $q_arr['q']= $q;
            $q_arr['a'] = $a;
            return $q_arr;
        }

    }

    /**
     **Author - Piyush jain
     **Function to update security questions and answer
     **Params - question and answer array
     **Return - bool[true,false]
     */
    public function update_security_qa($qa_arr,$user_id) {
        $res_q = $this->read_db->update('cc_user', $qa_arr, array('user_id' => $user_id));
        return $res_q;
    }

    /**
     **Author - Piyush jain
     **Function to Add custom question
     **Params - question and user id
     **Return - bool[true,false]
     */
    public function add_custom_question($data) {
        $this->read_db->insert('cc_user_security_question',$data);
        $id = $this->read_db->insert_id();
        return $id;
    }


    /**
     *Created : 17-5-2012
     *Function to  Save setting data
     *Params - field name and field val
     *Return - bool[true,false]
     */
    public function save_security($field_name,$user_id,$val)
    {

        // Need to update record
        $data = array(
            $field_name => $val
        );

        $this->read_db->where('user_id', $user_id);

        $this->read_db->update('user', $data);

        return "Setting Saved";

    }

    /**
     *Created : 17-05-2012
     *Function to Get security value
     *Params - field name
     *Return -  field val
     */
    public function get_security($field_name)
    {
        $user_id = $this->session->userdata('user_user_id');

        $this->read_db->where('user_id',$user_id);
        $this->read_db->select($field_name);
        $this->read_db->from('user');

        $result = $this->read_db->get();
        $secure_data =  $result->result();
        return $secure_data[0]->$field_name;
    }

    /**
     *Created : 18-5-2012
     *Function to store app password for a user
     *Params - app password from post array
     *Return -  string message
     */
    public function save_app_pass()
    {
        $user_id = $this->session->userdata('user_user_id');
        $app_password	=	sha2($this->input->post('app_pass'));

        // Need to update record
        $data = array(
            'app_password' => $app_password
        );

        $this->read_db->where('user_id', $user_id);

        $this->read_db->update('user', $data);

        return "Password Saved";

    }
    /**
     *Created : 19-5-2012
     *Function to get timezone list
     *Params -
     *Return -  timezone array
     */
    public function timezone_array($tz='') {
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
    }
    /**
     *Created : 19-5-2012
     *Function to get client Browser details
     *Params -
     *Return -  array contain browser details
     */
    public function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        $_SERVER['ALL_HTTP']='';
        $pattern='';
        /*****************Check for mobile browser**********************/
        $mobile_browser = '0';

        if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda','xda-');

        if(in_array($mobile_ua,$mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['ALL_HTTP']),'operamini')>0) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),' ppc;')>0) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows ce')>0) {
            $mobile_browser++;
        }
        else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {
            $mobile_browser=0;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'iemobile')>0) {
            $mobile_browser++;
        }

        /*****************Check for mobile browser**********************/
        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        if ($mobile_browser > 0) {
            $d1_name  = strstr($u_agent,')',true);
            $d2_name  = explode('(',$d1_name);
            $v  	  = explode(')',$u_agent);
            $bname  = @$v[2];
            $platform = 'Mobile-'.@$d2_name[1];
            $ub = 'Mobile-'.@$d2_name[1];
        }else{
            // Next get the name of the useragent yes seperately and for good reason
            if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
            {
                $bname = 'Internet Explorer';
                $ub = "MSIE";
            }
            elseif(preg_match('/Firefox/i',$u_agent))
            {
                $bname = 'Mozilla Firefox';
                $ub = "Firefox";
            }
            elseif(preg_match('/Chrome/i',$u_agent))
            {
                $bname = 'Google Chrome';
                $ub = "Chrome";
            }
            elseif(preg_match('/Safari/i',$u_agent))
            {
                $bname = 'Apple Safari';
                $ub = "Safari";
            }
            elseif(preg_match('/Opera/i',$u_agent))
            {
                $bname = 'Opera';
                $ub = "Opera";
            }
            elseif(preg_match('/Netscape/i',$u_agent))
            {
                $bname = 'Netscape';
                $ub = "Netscape";
            }

            // finally get the correct version number
            $known = array('Version', $ub, 'other');
            $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
            /*if (!preg_match_all($pattern, $u_agent, $matches)) {
                           // we have no matching number just continue
                       }*/



            // see how many we have
            if(!empty($matches)){
                $i = count($matches['browser']);
                if ($i != 1) {
                    //we will have two since we are not using 'other' argument yet
                    //see if version is before or after the name
                    if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                        $version= $matches['version'][0];
                    }
                    else {
                        $version= $matches['version'][1];
                    }
                }
                else {
                    $version= $matches['version'][0];
                }
            }

        }


        // check if we have a number
        if ($version==null || $version=="") {$version="?";}
        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }

    /**
     *Author : cdn
     *Function to get user all session detrail aaxcept last one
     *Params -
     *Return - database objecto of session details
     */

    public function getSessionDetail()
    {	/*-------- Get ACTIVE session id ------*/
        $active_session_id = "";
        $session_active = explode(" ",$_SERVER['HTTP_COOKIE']);
        $session_act_id = explode("=",$session_active[0]);
        if($session_act_id[0]=="PHPSESSID") { $active_session_id = $session_act_id[1]; }

        /*-------- End --------*/


        $userId = $this->session->userdata('user_user_id');

        $this->read_db->select('*');
        $this->read_db->where('session_id != (SELECT max( session_id ) AS session_id FROM cc_active_session WHERE user_id ='.$userId.' )');
        $this->read_db->from('active_session');
        $this->read_db->where('user_id',$userId);
        $this->read_db->where('is_active','1');
        $this->read_db->where('datetime > ',date('Y-m-d'));
        $this->read_db->where('active_session_id !=','');
        $this->read_db->order_by('session_id', 'desc');
		
        $result	= $this->read_db->get();
		//print_r($result); 
		
        if($result->num_rows() > 0)
        {
            return $result->result();
        }
        else
        {
            return false;
        }
    }

    /**
     **Author - cdnsol
     **Function to save address book
     **Params - name,address,email
     **Return - bool[true,false]
     */
    public function save_address_book_info($data) {
        $res = $this->read_db->insert('cc_address_book',$data);
        return $res;
    }

    /**
     * Function to Get current user password
     **Params - user_id
     **Return - database array contain password
     */
    public function get_user_password($user_id) {
        $this->read_db->select('password');
        $this->read_db->where('user_id', $user_id);
        $query=$this->read_db->get('cc_admin');
        return $query->result();
    }


    /**
     *Function to Update Password
     **Params - password, user_id
     **Return -
     */

    function update_password($password,$user_id){
        $this->read_db->update("cc_admin", $password, array('user_id' => $user_id));
    }

    /**
     * Function for update user account status Active / Deactive
     * Created 21-5-2012
     * Param INPUT
     **Return - message string
     */
    public function set_account_status()
    {
        $account_status_val = $this->input->post('account_status_val');
        $user_id = $this->session->userdata('user_user_id');

        $data = array(
            'published' => $account_status_val
        );

        $this->read_db->where('user_id', $user_id);
        $this->read_db->update('user', $data);
        if($account_status_val==0) { return "Status Deactivated"; } else { return "Account Activated"; }
    }

    /**
     * Function for get account status
     * Created 21-5-2012
     * Param
     **Return - published status or false
     */
    public function get_account_status()
    {
        $user_id = $this->session->userdata('user_user_id');

        $this->read_db->where('user_id',$user_id);
        $this->read_db->select('published');
        $this->read_db->from('user');

        $result = $this->read_db->get();
        if($result->num_rows() > 0 )
        {
            $status_arr = $result->result();
            return $status_arr[0]->published;
        } else {
            return false;
        }
    }


    /*---------------------------------------------------------
     | Function for get parent user
     ---------------------------------------------------------*/

    /**
     * Function for get parent user
     * Param  user_id
     **Return - databse object of child list
     */
    public function get_child_list($user_id)
    {
        $parent_min_date = date('Y-m-d',strtotime('-18 year'));
        $this->read_db->select('cc_user.email,cc_user.dob');
        $this->read_db->from('cc_user');
        $this->read_db->where('user_id',$user_id);
        $this->read_db->where('dob <=',$parent_min_date);
        $query = $this->read_db->get();
        $res1 = $query->result();
        $res = $query->num_rows();
        if($res==1){
            $this->read_db->select('*');
            $this->read_db->from('cc_user');
            $this->read_db->where('parent_email',$res1[0]->email);
            $query1 = $this->read_db->get();
            $child_arr = $query1->result();
            return $child_arr;
        }

    }

    /**
     * Function for udpate page concert status in database
     * Param  status_val,status_id
     **Return -
     */
    public function convert_status($status_val,$status_id_val)
    {

        $data = array(
            'concert_status' => $status_val
        );

        $this->read_db->where('id', $status_id_val);
        $this->read_db->update('page_concert', $data);


    }
    /*
     * @Access: public
     * Comment: This function get earned points of perticular date or current week or current date
     *@param
     *@return database object of user profile data
     */
    public function get_points_datewise($duration="",$date="")
    {
        $user_id = $this->session->userdata('user_user_id');
        if($duration == 'today')
        {
            $this->read_db->where('CAST(datetime AS DATE)=','CURDATE()',false);
        }
        else if($duration == 'week')
        {
            $this->read_db->where('CAST(datetime AS DATE)>=','DATE_SUB(CURDATE(),  INTERVAL (DAYOFWEEK(CURDATE())-1)  DAY )',false);
        }
        else if($duration == "daywise") // record get for particular date
        {
            $this->read_db->where('CAST(datetime AS DATE)=',$date);
        }
        $this->read_db->where('user_id',$user_id);
        $this->read_db->select('SUM(point) as total_point,CAST(cc_point.datetime AS DATE) as dateonly,count(cc_point.activity_id) as activity_count,cc_point.datetime');
        $this->read_db->from('point');
        $this->read_db->group_by('dateonly');
        $result = $this->read_db->get();
        return $result->result();
    }

    /*
     * @Access: public
     * Comment: This function get recent points of the user
     *@param
     *@return database object of user profile data
     */
    public function get_recent_points()
    {
        $user_id = $this->session->userdata('user_user_id');
        $this->read_db->where('user_id',$user_id);
        $this->read_db->select('SUM(point) as total_point,CAST(cc_point.datetime AS DATE) as dateonly,count(cc_point.activity_id) as activity_count,cc_point.datetime,cc_point.activity_id');
        $this->read_db->from('point');
        $this->read_db->group_by('point.activity_id');
        $result = $this->read_db->get();
        return $result->result();
    }


    /*----retrieve app password---*/
    public function retrieve_app_password($user_id){
        $this->read_db->select('*');
        $this->read_db->from('oauth_consumer');
        $this->read_db->where('user_id',$user_id);
        $query = $this->read_db->get();
        return $query->result();
    }


    /**
     * Check Invite Friends Mail is registered/unregistered
     * Amit Wali
     * 07-07-12
     **/

    function is_friend_registered($email) {

        $this->read_db->select('user_id');
        $this->read_db->where('email',$email);
        $this->read_db->from('user');
        $query=$this->read_db->get();

        if($query->num_rows() > 0) {

            $result=$query->row();
            $invite_user=$result->user_id;
            $this->update_friend_status($invite_user);

        }
        return true;

    }



    /**

     * Update Friend Table based on invitation email
     * Amit Wali
     * 07-07-12
     **/

    function update_friend_status($to_id) {

        $curDate = date ('Y-m-d H:m:s');
        $from_id = $this->session->userdata('user_user_id');
        // echo "FR". $from_id.'To'.$to_id;die;
        if(($from_id!=$to_id) && isset($from_id)):

            $data =array('from_user_id'=>$from_id,'to_user_id'=>$to_id,
                         'status'=>'0','created_at'=>$curDate,'parent_approval'=>'1',
                         'relationship_status'=>'0' ,'relation_from' =>'0'
            );

            $res = $this->read_db->insert('friends',$data );
            return $res;
        endif;
    }


    /********Get all languages*********/
    function get_all_languages(){
        $this->read_db->select('language_id,language');
        $this->read_db->from('language');
        $query = $this->read_db->get();
        return $query->result();
    }

    function password_check($pswd)
    {

        $user_id = $this->session->userdata('user_user_id');
        $this->read_db->select('user_id');
        $this->read_db->where('user_id',$user_id);
        $this->read_db->where_in('password', array(md5($pswd),encode($pswd), sha2($pswd)));
        $this->read_db->from('user');
        $query=$this->read_db->get();

        if($query->num_rows() > 0) {
            return "1";
        } else { return "0"; }
    }

    function delete_active_session($id){
        $session_id = $id;
        $data = array(
            'is_active' => 0
        );

        $this->read_db->where('active_session_id', $session_id);
         $res_active_session = $this->read_db->update('active_session', $data);

        $this->read_db->where('session_id', $session_id);
        $res_ci_session = $this->read_db->delete('ci_sessions');
        if($res_ci_session==1 && $res_active_session==1){
          
		   return true;
        }
        else{return false;}
    }

    /*
	* @Access: public
	* Comment: This function get recent points of the user
	*@param 
	*@return database object of user profile data
	*/
    public function get_recent_points_by_date($page_num='',$limit=5)
    {
        $user_id = $this->session->userdata('user_user_id');
        $this->read_db->where('user_id',$user_id);
        $this->read_db->select('CAST(cc_point.datetime AS DATE) as date_time');
        $this->read_db->from('point');
        $this->read_db->group_by('CAST(cc_point.datetime AS DATE)');
        $this->read_db->order_by('CAST(cc_point.datetime AS DATE)','desc');
        $start=0;
        if($page_num!='')
        {
            $start = ($page_num-1)*$limit;
        }
        $this->read_db->limit($limit,$start);
        $result = $this->read_db->get();
        return $result->result();
    }

    function get_recent_point_for_date($date_time){
        $this->read_db->where('CAST(cc_point.datetime AS DATE)=',$date_time);
        $user_id = $this->session->userdata('user_user_id');
        $this->read_db->where('user_id',$user_id);
        $this->read_db->select('*');
        $this->read_db->select('SUM(point) as total_activity_point');
        $this->read_db->from('point');
        $this->read_db->join('activity','activity.activity_id=point.activity_id','INNER');
        $this->read_db->group_by('point.activity_id');
        $result = $this->read_db->get();
        // print_r($result->result());
        return $result->result();
    }

    /*
      * function for search  user interest
      */
    function search_user_interest($searchtext,$limit=4,$interest_type,$selected_interest)
    {
        $user_id =$this->session->userdata('user_user_id');

        $this->read_db->select('type,id,text');
        $this->read_db->where('type',$interest_type);
        $this->read_db->where('status',1);
        if(!empty($selected_interest)){
            $this->read_db->where_not_in('text',$selected_interest);
        }
        $this->read_db->like('text',$searchtext);
        $query = $this->read_db->get('user_interest',4,0);
        /*$sql = "SELECT DISTINCT(type),id,text FROM cc_user_interest WHERE type='".$interest_type."' and
              status=1 and text like'".$searchtext."%' limit 0,4";*/
        //$query = $this->read_db->query($sql);

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }

    }
    
    function get_non_registered_friends($user_id){
         $this->read_db->distinct('incentive_request.email_to');
         $this->read_db->select('incentive_request.email_to');
         $this->read_db->from('incentive_request');
         $this->read_db->where('incentive_request.user_id',$user_id);
         $this->read_db->join('user','incentive_request.email_to!=user.email');
         $query_res = $this->read_db->get();
         if($query_res->num_rows()>0){
              return $query_res->result();
         }else{
              return FALSE;  
         }
    }



}// end of Model Class

/* end of model file User_profile */
