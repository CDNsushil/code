<?php
class Admin_privacy_setting_model extends CI_model{
	private $read_db;	// private variable to store db read reference
	
	function __construct(){
		parent::__construct();
		// assign db read instance to read_db variable
		$this->read_db = $this->load->database('read', TRUE);	
	}
	
	/*---------------------------------------------------------
	| Function for get section list
	---------------------------------------------------------*/
	function get_user_account_section(){
			$this->read_db->where('status','1');
			$return = $this->read_db->get('admin_section');
			return $return->result();
	}
	
	
	/*---------------------------------------------------------
	| Function for get user privacy account setting
	---------------------------------------------------------*/
	function get_user_account_setting(){
			
			$this->read_db->select('section_id,user_role');			
			$return = $this->read_db->get('cc_admin_account_permission');
			$setting =$return->result();
			$data =array();
			if(count($setting)>0){
				foreach($setting AS $key=>$set){
					//$data['section_id'][$key]=$set->section_id;
					//$data['user_role'][$key]=$set->user_role;
					$data['previous_setting'][$set->user_role][$set->section_id]=true;
				}
			}
				//echo "<pre>";print_R($data);die;
			return $data;
	}
	
	/*---------------------------------------------------------
	| Function for save user privacy account setting
	---------------------------------------------------------*/
	function save_user_account_setting(){
		
		$section_list = $this->input->post('section');					
		//echo "<pre>";print_R($section_list);die;
		$result=$this->db->empty_table('cc_admin_account_permission');
		
		if($result){
			$query = "INSERT INTO cc_admin_account_permission(section_id,user_role) VALUES";
			$field_value="";
			foreach($section_list as $user_role=>$sectionArray){		
				foreach($sectionArray as $sectionId=>$sectionStatus){		
					$field_value .= ($field_value!=""?" , ":"");
					$field_value .="('".$sectionId."','".$user_role."')";	
				}			
			}
			$query.=$field_value;
			$this->db->query($query);		
		}
	}
	
	function get_section_list(){									
		$return = $this->read_db->get('admin_section');
		return $return->result();
	}
	
	
	function get_user_type(){
		$this->read_db->where('role_id !=','0');
		$this->read_db->where('role_id !=','1');
		$this->read_db->where('status','1');
		$return = $this->read_db->get('user_roll_type');
		return $return->result();
	}
}