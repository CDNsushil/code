<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter tips files editor.
 *
 */
class Model_tips extends CI_Model {
	 
	private $read_db;   
	function __construct()
	{
		parent::__construct();
        $this->read_db = $this->load->database('read', TRUE);
	}
	
	/**
	* Insert tip to db.
	*/
	public function submit_tips()
	{
		$Title= $this->input->post('title');        
		$Subtitle = $this->input->post('subtitle');		
		$Description = $this->input->post('description'); 
		if($this->input->post('status') == '1')
          	{
            	$status = '1';  
          	} else {
                $status = '0';
          	}
		$data = array(												
				'title' 		=> $Title,						
				'subtitle'	 	=> $Subtitle,						
				'description' 	=> $Description,	
				'status' 		=> $status,				
			);
		$this->db->insert('TDS_Tips', $data);
		return $this->db->insert_id();	      
		
	}
	
	/**
	* Get tips title and subtitle values at admin side.
	*/
	public function get_tips()
	{                  
		$this->db->select('id, title, subtitle');
		$this->db->order_by('priority asc');
		$q = $this->db->get_where('Tips');
				
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
	* Get tips description data.
	*/
	public function get_description($id)
	{                  
		$this->db->select('title,subtitle ,description');
		$options = array('id'=>$id);
		$q = $this->db->get_where('Tips', $options);		
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
	* Get tips description data.
	*/
	public function get_tip($tip_id)
	{	$data = array(); 
		$this->db->select('title, subtitle, description, status');
		$this->db->limit('1');
		$options = array('id' => $tip_id);
		$q = $this->db->get_where('Tips', $options);
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
	* Remove tips to db.
	*/
	public function remove_tip($titleId)
    {
		// If the admin is tryring to delete a topic then delete it.
		$data = array(
			'id' => $titleId,
		);
            
		$this->db->delete('Tips', $data);
            
		if($this->db->affected_rows() > 0)
		{
			return true;
		}else{
			return false;
		}       
	}
	
	/**
	* Get Active tips title and subtitle values at front side.
	*/
	public function get_front_tips()
	{                  
		$this->db->select('id, title, subtitle');
		$this->db->order_by('priority asc');
		$options = array('status' => 't');
		$q = $this->db->get_where('Tips',$options);
				
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
	* Get top order tip .
	*/
	public function get_top_tip()
	{                  
		$this->db->select('id,title,subtitle, description');
		$this->db->order_by('priority asc');
		$this->db->limit('1');
		$options = array('status' => 't');
		$q = $this->db->get_where('Tips',$options);
				
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
	* Get front tips description data.
	*/
	public function get_front_description($id)
	{                  
		$this->db->select('id,title,subtitle ,description');
		$options = array('id'=>$id ,'status'=>'t');
		$q = $this->db->get_where('Tips', $options);		
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
/* End of file model_tips.php */
