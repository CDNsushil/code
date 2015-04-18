<?php
/**
 * Mail Model
 * Manage mail box
 * @category	Mail
 * @author	CDN Solutions 
 */
class Manage_email_templates_model extends CI_Model
{
	private $read_db;	// private variable to store db read reference
	//Constructor
	function __construct(){
		parent::__construct();
		// assign db read instance to read_db variable
		$this->read_db = $this->load->database('read', TRUE);				
	}

	function create_mail_box() {	
		// Function for create mail box
	}	
	function view_email_list()
	{
		$this->read_db->select('*');
		$this->read_db->from('cc_email_template');
		return $this->read_db->get();
	}
	
	function update_email_list($key_val)
	{
		$this->read_db->select('*');
		$this->read_db->from('cc_email_template');
		$this->read_db->where('key',$key_val);
		return $this->read_db->get();
	}
		
	function edit_page($key,$data)
	{
		//echo "<pre>"; print_r($data);die;
		
		if($data['key'] != " "){
			$this->db->where('emailId',$key);
			return $this->db->update('email_template',$data);
		}
		else{echo "Error in updating Mail Template ";}
	}
}
?>
