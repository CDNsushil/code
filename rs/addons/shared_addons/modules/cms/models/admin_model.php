<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Description	:This model only for request module 
 * @author		:Rajendra Patidar
 * @package		:Request
 *
 */
class Admin_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		
		$this->blocks_table = $this->db->dbprefix('blocks');
	}

	function getBlocks($limit=0,$offset=0)
	{
		$result = false;
        $userId=is_logged_in();
		$this->db->select('*');
		$this->db->from($this->blocks_table);
		$this->db->order_by("id", 'DESC');
		if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
        if($query){
            $result=$query->result();
        }
	
		return $result;
	}
}
