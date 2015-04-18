<?php
/**
 * Chatching Common Model Class
 *
 * Manage get_country,get_states_by_country,get_cities_by_state,get_carrier,get_high_school_year,get_education_level,get_university
 *
 * @Category	Model
 * @Author		CDN Solutions
 */
class Common_model extends CI_model{
    
     private $read_db;   
	/**
	 * Constructor
	 */
	 
	function __construct()
	{
		parent::__construct();
        $this->read_db = $this->load->database('read', TRUE);
	}

	/**
	 * @Input: 
	 * @Output: Returns query (record source) of all country
	 * @Access: Public
	 * Comment: This function returns query (record source) of all country
	 */
	 
	function get_country()
	{
        /*--------------Get data from memcached-----------------*/
        /*$country_data_cached = $this->memcached_library->get('country_data_cached_'); 
        if(!$country_data_cached)
        {*/
            $this->read_db->select('country_id, country_name');
            $this->read_db->from('country');
            $this->read_db->order_by("country_id", "asc"); 
            $query =  $this->read_db->get();	
            if($query->num_rows() > 0)
            {
                /*--------------Set data from memcached-----------------*/
                //$this->memcached_library->add('country_data_cached_',$query,$this->config->item('memcache_country_data_time'));
                return $query;
            }
        /*}//memcache if
        else
        {
            return $country_data_cached;    
        }*/
	}

	/**
	 * @Input: $country_id
	 * @Output: Returns query (record source) of all states
	 * @Access: Public
	 * Comment: This function returns query (record source) of all states based on country_id
	 */
	 
	function get_states_by_country($country_id)
	{
		$this->read_db->select('state_id, state_name');
		$this->read_db->from('state');
		$this->read_db->where('country_id',$country_id);
		$this->read_db->order_by("state_name"); 

		$query =  $this->read_db->get();	
		if($query->num_rows() > 0)
		{
			return $query; 
		}
		return false;
	}

	/**
	 * @Input: $state_id
	 * @Output: Returns query (record source) of all cities
	 * @Access: Public
	 * Comment: This function returns query (record source) of all cities based on state_id
	 */
	 
	function get_cities_by_state($state_id)
	{
		$this->read_db->select('city_id, city_name');
		$this->read_db->from('city');
		$this->read_db->where('state_id',$state_id);
		$this->read_db->order_by("city_name"); 
		$query =  $this->read_db->get();	
		if($query->num_rows() > 0)
		{
			return $query; 
		}
		return false;		
	}
	
	/**
	 * @Input: 
	 * @Output: Returns query (record source) of all carrier
	 * @Access: Public
	 * Comment: This function returns query (record source) of all carrier
	 */
	 
	function get_carrier()
	{
        /*--------------Get data from memcached-----------------*/
        $carrier_data_cached = $this->memcached_library->get('carrier_data_cached');
        if(!$carrier_data_cached){
            $this->read_db->select('carrier_id, carrier_name');
            $this->read_db->from('carrier');
            $this->read_db->order_by("carrier_id", "asc"); 
            $query =  $this->read_db->get();	
            if($query->num_rows() > 0)
            {
				$result = $query->result();
                /*--------------Set data into memcached-----------------*/
                $this->memcached_library->add('carrier_data_cached',$result,$this->config->item('common_data_time'));
                return $result; 
            }
        }//memcache if
        else
        {
            return $carrier_data_cached;     
        }
	}
	
	/**
	 * @Input: 
	 * @Output: Returns query (record source) of all high school years
	 * @Access: Public
	 * Comment: This function returns query (record source) of all high school years
	 */
	 
	function get_high_school_year()
	{
        /*--------------Get data from memcached-----------------*/
        $high_school_data_cached = $this->memcached_library->get('high_school_data_cached');
        if(!$high_school_data_cached){
            $this->read_db->select('high_school_year_id, year');
            $this->read_db->from('high_school_year');
            $this->read_db->order_by("year", "asc"); 
            $query =  $this->read_db->get();	
			if($query->num_rows() > 0)
            {
				$result = $query->result();
				/*--------------Set data into memcached-----------------*/
				$this->memcached_library->add('high_school_data_cached',$result,$this->config->item('common_data_time'));
				return $result;
			}
        }
        else
        {
            return $high_school_data_cached;    
        }
	}

	/**
	 * @Input: 
	 * @Output: Returns query (record source) of all education levels
	 * @Access: Public
	 * Comment: This function returns query (record source) of all education levels
	 */
	 
	function get_education_level()
	{
        /*--------------Get data from memcached-----------------*/
        $education_level_data_cached = $this->memcached_library->get('education_level_data_cached');
  //      var_dump($education_level_data_cached);
        if(!$education_level_data_cached){
            $this->read_db->select('education_level_id, education_level');
            $this->read_db->from('education_level');
            $this->read_db->order_by("education_level_id", "asc"); 
            $query =  $this->read_db->get();
			if($query->num_rows() > 0)
            {
				$result = $query->result();
				/*--------------Set data into memcached-----------------*/
				$this->memcached_library->add('education_level_data_cached',$result,$this->config->item('common_data_time'));
				return $result;
			}	
        }
        else
        {
            return $education_level_data_cached;    
        }
	}	
	
	/**
	 * @Input: 
	 * @Output: Returns query (record source) of all universities
	 * @Access: Public
	 * Comment: This function returns query (record source) of all universities
	 */
	 
	function get_university()
	{
        /*--------------Get data from memcached-----------------*/
        $university_data_cached = $this->memcached_library->get('university_data_cached');
		if(!$university_data_cached){
            $this->read_db->select('university_id, year');
            $this->read_db->from('university');
            $this->read_db->order_by("year", "asc"); 
            $query =  $this->read_db->get();	
			if($query->num_rows() > 0)
            {
				$result = $query->result();
				/*--------------Set data into memcached-----------------*/
				$this->memcached_library->add('university_data_cached',$result,$this->config->item('common_data_time'));
				return $result;
			}	
        }
        else
        {
            return $university_data_cached;
        }
	}

	/**
	 * @Input: 
	 * @Output: Returns query (record source) of post grad universities id,year
	 * @Access: Public
	 * Comment: This function returns query (record source) of post grad universities id,year
	 */
	 
	function get_post_grad_university()
	{
        /*--------------Get data from memcached-----------------*/
        $post_grad_university_data_cached = $this->memcached_library->get('post_grad_university_data_cached');
        if(!$post_grad_university_data_cached){
            $this->read_db->select('post_grad_university_id, year');
            $this->read_db->from('post_grad_university');
            $this->read_db->order_by("year", "asc"); 
            $query = $this->read_db->get();
			if($query->num_rows() > 0)
            {
				$result = $query->result();
				/*--------------Set data into memcached-----------------*/
				$this->memcached_library->add('post_grad_university_data_cached',$result,$this->config->item('common_data_time'));
				return $result;
			}	
        }
        else
        {
            return $post_grad_university_data_cached;    
        }
	}	
	
	function check_state_under_incentive_program($state_id='')
	{
		if($state_id!="")
		{
			$this->read_db->select('state_id');
			$this->read_db->from('state');
			$this->read_db->where(array("state_id"=>$state_id, 'is_under_incentive_program'=>1)); 
			$query = $this->read_db->get();	
			if($query->num_rows()>0)
			return true; 		
			else
			return false;			
		}	
	}
	
	/*function get_create_profile_last_step($user_id='')
	{
		$this->read_dbselect('user_profile_id');
		$this->read_dbfrom('user_profile');
		$this->read_dbwhere(array("user_id"=>$user_id)); 
		$query = $this->read_dbget();	
		if($query->num_rows()>0)
		return true; 		
		else
		return false;			
	}*/
	
	function check_state_changed($user_id, $state)
	{
		if($user_id!="" && $state!="")
		{
			$this->read_db->select('state_id');
			$this->read_db->from('user_profile');
			$this->read_db->where(array("state_id"=>$state, 'user_id'=>$user_id)); 
			$query = $this->read_db->get();	
			if($query->num_rows()>0)
			return true; 		
			else
			return false;			
		}	
	}	
	
	function get_session_language()
	{
		if($this->session->userdata('user_user_id'))
		{
			$user_id = $this->session->userdata('user_user_id');
			if(get_cookie('lang_id')!='')
			{
				$lang_id = get_cookie('lang_id');
				$this->set_user_language($lang_id,$user_id);
				return strtolower(get_cookie('lang'));
			}
			$this->read_db->select('language.language as lang,language.language_id as lang_id');
			$this->read_db->from('language');
			$this->read_db->join('user','user.language = language.language_id');
			$this->read_db->where('user.user_id',$user_id);
			$language = $this->read_db->get()->row();
			return @$language->lang;
		}
		else
		{
			$setCookielang=get_cookie('lang');
			if($setCookielang)		
			return strtolower($setCookielang);
		
			return 'english';
		}
	}
	
	function set_user_language($lang_id,$user_id)
	{
		$this->read_dbset('language',$lang_id);
		$this->read_dbwhere('user_id',$user_id);
		return $this->read_dbupdate('user');
	}


       
	/**
	 * @Input: $country_id
	 * @Output: Returns country id based on ip address based country
	 * @Access: Public
	 * Amit Wali
         * 07-07-12  
	 */
	 
	function get_country_id($countryName='')
	{
		$this->read_db->select('country_id');
		$this->read_db->from('country');
		$this->read_db->where('country_name',$countryName);		
		$query =  $this->read_db->get();	
		if($query->num_rows() > 0)
		{
			$result=$query->row(); 
                        return $result->country_id; 
		}
		return false;		
	}

	function is_availible_country($iso_code){
            $this->read_db->from('country');
            $this->read_db->where('ccode',$iso_code);		
            $query =  $this->read_db->get()->result();
            
            if (count($query)) {
                $country = $query[0];
                $availible_date = strtotime($country->availible_from);
                $this->session->set_userdata(array('country_availible_from' => $country->availible_from));
                
                if ($availible_date <= time()) {
                    return true;
                } else {
                    return false; 
                }
            } else {
		return false;
            }
        }
        
	function is_availible_country_by_id($country_id){
            $this->read_db->from('country');
            $this->read_db->where('country_id',$country_id);		
            $query =  $this->read_db->get()->result();
            
            if (count($query)) {
                $country = $query[0];
                $availible_date = strtotime($country->availible_from);
                $this->session->set_userdata(array('country_availible_from' => $country->availible_from));
                
                if ($availible_date <= time()) {
                    return true;
                } else {
                    return false; 
                }
            } else {
		return false;
            }
        }
        
        function get_all_countries(){
            $this->read_db->from('country');
            return $this->read_db->get()->result();
        }
        
        function update_country_availible_date($id, $date){
            $this->read_db->where('country_id', $id);
            $this->read_db->set('availible_from', $date);
            $this->read_db->update('country');
        }
        
        /**
         * This function is used for set count into the DB of images served from s3 daywise
         *  Entries filled by this function in to the DB is used for mobile app web services
         * */
        function set_s3_image_count($media_name, $media_url){
			if($media_name) { 
        		$current_date = date("Y-m-d");

            $this->read_db->select('row_id,media_name,count');
            $this->read_db->from('statistics_s3_images');
            $this->read_db->where('media_name',$media_name);
            $this->read_db->where('created_at',$current_date);
            $query = $this->read_db->get();
            if($query->num_rows() > 0)
            {
				$result = $query->row();
				$row_id = $result->row_id;
/*				$this->read_db->where('row_id', $row_id);
				$this->read_db->set('count', 'count++');
				$this->read_db->update('statistics_s3_images');
	         $query_exe = $this->read_db->get(); */
				$new_count = $result->count+1;
				$data = array(
          			'count' => $new_count
	            );
				$this->read_db->where('row_id', $row_id);
				$this->read_db->update('statistics_s3_images', $data);	
			}
			else
			{
				$data = array(
				               'media_name' =>  $media_name,
				               'media_url'	=>  $media_url,
				               'created_at'		=>  $current_date,
				               'count'		=>  1
								);
                if($media_url){
                    $this->read_dbinsert('statistics_s3_images',$data);
                }
			} 
        }
        }                        
        
}//end of common model class

/* End of file common_model.php */
/* Location: ./application/models/common_model.php */
?>
