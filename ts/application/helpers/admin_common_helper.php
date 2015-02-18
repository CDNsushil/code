<?php
if(! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* Function to check get country total user by country id
	**/
	function get_country_total_user($country_id)
	{
		$read_db=''; //define new variable for read db reference
		$CI =& get_instance();
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		$CI->read_db->select('count(cc_user.user_id) as total_users');
		$CI->read_db->from('cc_user');
		$CI->read_db->join('cc_user_profile',"cc_user_profile.user_id=cc_user.user_id and cc_user_profile.country_id='$country_id'");
		$query = $CI->read_db->get();
		$res = $query->result();
		return $res[0]->total_users;
	}
	
	function get_country_total_genders($country_id)
	{
		$read_db=''; //define new variable for read db reference
		$CI =& get_instance();
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		$CI->read_db->select('cc_user.sex');
		$CI->read_db->from('cc_user');
		$CI->read_db->join('cc_user_profile',"cc_user_profile.user_id=cc_user.user_id and cc_user_profile.country_id='$country_id'");
		$query = $CI->read_db->get();
		$res = $query->result();
		$i=0;
		$male=array();
		$female=array();
		$other=array();
		foreach($res as $result){
				if($result->sex==0){
					$female[$i++] =$result->sex;
					}
				if($result->sex==1){
					$male[$i++] =$result->sex;
					}
				if($result->sex==2){
					$other[$i++] =$result->sex;
					}  
			}
		$count['male']=count($male);
		$count['female']=count($female);
		$count['other']=count($other);
		return $count;
	}
	
	function get_count_user_detail()
	{
		$read_db=''; //define new variable for read db reference
		$CI =& get_instance();
		$CI->read_db = $CI->load->database('read', TRUE);  //load read db and assign to read_db variable
		$CI->read_db->select('user_id,sex,dob');
		$CI->read_db->where("user.user_role","1");	
		$CI->read_db->from('user');
		$query = $CI->read_db->get();
		$res = $query->result();
		$i=0;
		$male=array();
		$female=array();
		$other=array();
		$dob=array();
		$datetime_before_20_year = date("Y-m-d", strtotime("-20 Year"));
		$datetime_before_29_year = date("Y-m-d", strtotime("-29 Year"));
		$datetime_before_30_year = date("Y-m-d", strtotime("-30 Year"));
		$datetime_before_39_year = date("Y-m-d", strtotime("-39 Year"));
		$datetime_before_40_year = date("Y-m-d", strtotime("-40 Year"));
		$datetime_before_49_year = date("Y-m-d", strtotime("-49 Year"));
		$datetime_before_50_year = date("Y-m-d", strtotime("-50 Year"));
		$datetime_before_59_year = date("Y-m-d", strtotime("-59 Year"));
		$datetime_before_60_year = date("Y-m-d", strtotime("-60 Year"));
		$datetime_before_69_year = date("Y-m-d", strtotime("-69 Year"));
		$datetime_before_70_year = date("Y-m-d", strtotime("-70 Year"));
		foreach($res as $result){
				if($result->sex==0){
					$female[$i++] =$result->sex;
					}
				if($result->sex==1){
					$male[$i++] =$result->sex;
					}
				if($result->sex==2){
					$other[$i++] =$result->sex;
					} 
				if($result->dob >= $datetime_before_20_year){
					$dob['under20'][$i++] = $result->dob;
					}
				if($result->dob <= $datetime_before_20_year && $result->dob >= $datetime_before_29_year){
					$dob['under30'][$i++] = $result->dob;
					}
				if($result->dob <= $datetime_before_30_year && $result->dob >= $datetime_before_39_year){
					$dob['under40'][$i++] = $result->dob;
					}
				if($result->dob <= $datetime_before_40_year && $result->dob >= $datetime_before_49_year){
					$dob['under50'][$i++] = $result->dob;
					}
				if($result->dob <= $datetime_before_50_year && $result->dob >= $datetime_before_59_year){
					$dob['under60'][$i++] =$result->dob;
					}
				if($result->dob <= $datetime_before_60_year && $result->dob >= $datetime_before_69_year){
					$dob['under70'][$i++] = $result->dob;
					}
				if($result->dob <= $datetime_before_70_year){
					$dob['over70'][$i++] = $result->dob;
					}	 
			}
		$count['male']		= count($male);
		$count['female']	= count($female);
		$count['other']		= count($other);
		$count['dob'] 		= $dob;
		return $count;
	}	
	
	
	function AdminLoginUserCheck(){
		if($this->session->userdata('session_data')){
			return true;
		}else{
			return false;
		}
	}
		
	
?>
