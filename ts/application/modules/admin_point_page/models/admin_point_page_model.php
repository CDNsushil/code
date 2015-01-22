<?php

/**
 * Admin point page model
 * Manage Point page template
 * @category	Point page 
 * @author	CDN Solution
 */
 
class Admin_point_page_model extends CI_Model
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
		* Get page point pages content	
		* Author Lalit
		**/
	function get_point_page()
	{
		$this->read_db->select('*');
		$this->read_db->from('bubbles');
	//	$this->read_db->limit($num,$offset);
		$result=$this->read_db->get();
		return $result->result();
	}

	/**
	* Function to save page point html
	**/
	public function new_point_page($page_arr)
	{
		

		$page_content = $page_arr['page_content'];

	
		$data = array(
   		'page_name' => $page_arr['page_title'] ,
   		'content' => $page_arr['page_content'] ,
   		'status' => '0'
		);
		
		

		$this->db->insert('bubbles', $data); 	
		return true;
	}
	
	/**
	* Function for save edit page
	*/	
	function edit_point_page($page_arr)
	{

		$bubble_id = $this->input->post('page_id');
		
		$data = array(
   		'page_name' => $page_arr['page_title'] ,
   		'content' => $page_arr['page_content'] 
            );

			$this->db->where('bubble_id', $bubble_id);
			$this->db->update('bubbles', $data); 
				return true;
	}
	
	function getPageData($step)
	{

	  if (is_numeric($step)) {
			$this->read_db->where('bubble_id',$step);
			$this->read_db->select('*');
   	 } else {
			$this->read_db->where('page_name',$step);
			$this->read_db->select('content');
   	 }
    
			$this->read_db->from('bubbles');

			$query = $this->read_db->get();
			return $query->result();
		}
	
	function getPageStatus($userId,$step)
	{
		$this->read_db->where('user_id',$userId);
		$this->read_db->where('page_name',$step);
		$this->read_db->select('*');
		$this->read_db->from('bubble_user_setting');

		$query = $this->read_db->get();
		return $query->result();
	}
	
	function update_point_page($userId,$step)
	{
		$data = array(
   		'page_name' => $step ,
   		'user_id' => $userId ,
   		'status' => '1'
		);
		$this->db->insert('bubble_user_setting', $data); 	
		return true;
	}
}
?>
