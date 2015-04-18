<?php

class Email_notification_model extends CI_Model{
	
    private $read_db;
	function __construct(){
		parent::__construct();
        $this->read_db = $this->load->database('read', TRUE);
	}
	
	function get_user_email($user_id){
		$this->read_db->select('email,firstname');
		$this->read_db->from('user');
		$this->read_db->where('user_id',$user_id);
		return $this->read_db->get()->row();
	}
		
}
