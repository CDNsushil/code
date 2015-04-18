<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter CMS files editor.
 *
 */
class Model_cms extends CI_Model {
	 
	private $read_db;   
	function __construct()
	{
		parent::__construct();
        $this->read_db = $this->load->database('read', TRUE);
	}
	
	/**
	* Insert cms to db.
	*/
	public function insert_cms()
	{
		$Title= $this->input->post('title'); 
		$PageKey= $this->input->post('pageKey');        
		$Description = $this->input->post('description'); 
		
		$data = array(												
				'title' 		=> $Title,	
				'pageKey' 		=> $PageKey,											
				'description' 	=> $Description				
			);
		$this->db->insert('TDS_CMS', $data);
		return $this->db->insert_id();	      
		
	}
	
	/**
	* Get cms title values at admin side.
	*/
	public function get_all_cms()
	{                  
		$this->db->select('id, title');
		$this->db->order_by('id asc');
		$options = array('status' => 't');
		$q = $this->db->get_where('CMS',$options);
				
		if($q->num_rows() > 0)
		{
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		return $data;
	}
	
	/**
	* Get top order cms .
	*/
	public function get_top_cms()
	{                  
		$this->db->select('id,title,description,pageKey');
		$this->db->order_by('id asc');
		$this->db->limit('1');
		$options = array('status' => 't');
		$q = $this->db->get_where('CMS',$options);
				
		if($q->num_rows() > 0)
		{
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		return $data;
	}
	
	/**
	* Get cms description data.
	*/
	public function get_description($id)
	{                  
		$this->db->select('title,description');
		$options = array('id'=>$id);
		$q = $this->db->get_where('CMS', $options);		
		if($q->num_rows() > 0)
		{
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		return $data;
	}
	
	/**
	* Get cms description data.
	*/
	public function get_cms($cms_id)
	{	$data = array(); 
		$this->db->select('title, description, pageKey');
		$this->db->limit('1');
		$options = array('id' => $cms_id);
		$q = $this->db->get_where('CMS', $options);
		if($q->num_rows() >0)
        {
            foreach ($q->result_array() as $row)
            {
                $data[] = $row;
            }
            
            return $data;
        } else {
            return false;
        }
	}
	
	/**
	* Remove cms to db.
	*/
	public function remove_cms($titleId)
    {
		// If the admin is tryring to delete a topic then delete it.
		$data = array(
			'id' => $titleId,
		);
            
		$this->db->delete('CMS', $data);
            
		if($this->db->affected_rows() > 0)
		{
			return true;
		}else{
			return false;
		}       
	}
	
	/**
	* Function to get list of users emails.
	*/
	public function get_all_useremail()
	{
		$this->db->select('tdsUid,username,email');
		$options = array('active' => 1);
		$q = $this->db->get_where('UserAuth', $options);
				
		if($q->num_rows() > 0)
		{
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		return $data;
	}
}
