<?php

/**
 * Users Model
 * Manage User record etc
 * @category	Users
 * @author	CDN Solution
 */
class Manage_country_stats_model extends CI_Model
{
        private $read_db;
        /**
        * Constructor
        */
        function __construct()
        {
            // Call the Model constructor
            parent::__construct();
            $this->read_db = $this->load->database('read', TRUE);
		}

		/**
		* function to get Country listing with users count
		* Author CDNSOL
		**/
		function get_country_list($search_country='',$page='',$perpage=''){
			$start=0;
			$start=($page-1)*$perpage;
			if(!empty($search_country)){
				$this->read_db->like('country_name',$search_country);
				}
			$this->read_db->select('cc_country.country_id,cc_country.country_name');
			$this->read_db->from('cc_country');
			if($perpage!=0){		
				$this->read_db->limit($perpage,$start);
			}	 
			$query = $this->read_db->get();
			return $res = $query;
			}

		/**
		* function to get Country listing with users count
		* Author CDNSOL
		**/
		function get_user_list($country_id,$search_user='',$gender='',$page='',$perpage=''){
			$start=0;
			$start=($page-1)*$perpage;
			if(!empty($search_user)){
				$this->read_db->like('firstname',$search_user);
				$this->read_db->or_like('lastname',$search_user);
				}
			if(!empty($gender)){
				if($gender=="male"){
						$this->read_db->where('cc_user.sex','1');
					}
				if($gender=="female"){
						$this->read_db->where('cc_user.sex','0');
					}
				if($gender=="other"){
						$this->read_db->where('cc_user.sex','2');
					}
				}
			$this->read_db->select('cc_user.user_id,cc_user.username,cc_user.firstname,cc_user.lastname');
			$this->read_db->from('cc_user');
			$this->read_db->join('cc_user_profile',"cc_user_profile.user_id=cc_user.user_id and cc_user_profile.country_id='$country_id'");
			if($perpage!=0){		
				$this->read_db->limit($perpage,$start);
			}	 
			$query = $this->read_db->get();
			return $res = $query;
			}


}
?>
