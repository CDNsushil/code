<?php

class Language_model extends CI_Model{
	
	function __construct(){
		parent::__construct();	
	}
	
	function update_user_language($language){
		$user_id = $this->session->userdata('user_user_id');
		$this->db->set('language',$language);
		$this->db->where('user_id',$user_id);
		return $this->db->update('user');
	}
}