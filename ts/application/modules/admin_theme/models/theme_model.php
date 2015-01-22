<?php
/**
 * Mail Model
 * Manage mail box
 * @category	Mail
 * @author	Lalit 
 */
class Theme_model extends CI_Model
{
	private $read_db;	// private variable to store db read reference

	//Constructor
	function __construct(){
		parent::__construct();
		// assign db read instance to read_db variable
		$this->read_db = $this->load->database('read', TRUE);				
	}
/*
	* @Access: public
	* Comment: This function get user profile  DB 
	*/
	function get_theme_temp()
	{
		$this->read_db->select('*');
		$this->read_db->from('themes');
		$this->read_db->where('status','1');
		$result = $this->read_db->get();
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
	 * Function for update theme option
	 * created 21-5-2012
	 */
	function save_theme_data()
	{
		$theme = $this->input->post('theme');
		$userId = $this->session->userdata('user_user_id');
 
		$data = array(
					   'theme_option' => $theme
					);

		$this->db->where('user_id', $userId);
		$this->db->update('user', $data);
		$this->session->set_userdata('user_theme_id',$theme); 
	}
	 
	 /**
	  * Function for get active theme
	  * Created 21-5-2012
	  */
	function get_theme_active()
	{
		$userId = $this->session->userdata('user_user_id');

		$this->read_db->select('theme_option');
		$this->read_db->from('user');
		$this->read_db->where('user_id',$userId);
		$result = $this->read_db->get();
		if($result->num_rows() > 0)
		{
			$theme_arr =  $result->result();
			return $theme_arr[0]->theme_option;
		}
		else 
		{
			return false;
		}
	}
}
?>