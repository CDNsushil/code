<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter Language files editor.
 *
 */
class Model_Lang extends CI_Model {
	 
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	* Get Language listing.
	*/
	public function get_language_listing($limit=0,$offset=0)
	{
		$this->db->select('*');
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('Language asc');
		$q = $this->db->get_where('MasterLang');
		return $q->result_array();
	}
	
	/**
	* Get Language data.
	*/
	public function get_language_details($langId)
	{	$data = array(); 
		$this->db->select('*');
		$this->db->limit('1');
		$options = array('langId' => $langId);
		$q = $this->db->get_where('MasterLang', $options);
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
	* Insert New Language.
	*/
	public function add_language($langData)
	{ 	
		$this->db->insert('MasterLang', $langData);
		return $this->db->insert_id();	     
	}
	
	/**
	* Update Language.
	*/
	public function update_language($langData,$langId)
	{ 
		$this->db->where('langId', $langId);
		$this->db->update('MasterLang', $langData);
	}
	
}
