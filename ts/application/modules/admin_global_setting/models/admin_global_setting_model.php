<?php
class Admin_global_setting_model extends CI_model{
	private $read_db;	// private variable to store db read reference
	
	function __construct(){
		parent::__construct();
		// assign db read instance to read_db variable
		$this->read_db = $this->load->database('read', TRUE);	
	}
	
	/*
	* @Input : None
	* @Output : Returns object array of global settings
	* Comment : Function to return global settings 
	*/
	function get_global_settings()
	{
		$this->read_db->select('*');
		$this->read_db->from('global_settings');
		$query=$this->read_db->get();
		if($query->num_rows()>0)
		return $query->result();
		else return false;
	} 

	/*
	* @Input : Setting values from admin configuration interface
	* @Output : Returns true if values inserted into db, false otherwise
	* Comment : Function to truncate existing setting table and insert updated setting values
	*/
	function save_global_setting()
	{
		$section_list = $this->input->post();					

		// insert setting data again 
		if(count($section_list)>0)
		{
			try
			{
				// empty setting table
				$result = $this->db->truncate('global_settings');
				if($result)
				{
					$count = 1;
					foreach($section_list as $key=>$value)
					{
						if(count($section_list) > $count)
						{
							$setting_arr = array('option'=>$key, 'value'=>$value);
							$this->db->insert('global_settings', $setting_arr);
						}
						$count++;
					}
					return true;
				}
				else return false;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}
		else return false;
	}
} // end of class Admin_global_setting_model
