<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter tips files editor.
 *
 */
class model_categories extends CI_Model {
	 
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	* Get Genre listing.
	*/
	public function get_categories_listing($type,$limit=0,$offset=0, $returnRow=false)
	{
		$this->db->select('*');
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('order asc');
		
		// check Where Condition for helper and Forum
		
			$options=array('parentID'=>'0','type'=>$type,'thrash'=>'0');
		
		
		$q = $this->db->get_where('forum_category',$options);
		return $q->result_array();
	}
	
	/**
	* Get Category data.
	*/
	public function get_categories_details($type,$catId)
	{	
		$data = array(); 
		$this->db->select('*');
		$this->db->limit('1');
		$options = array('parentID'=>'0','type'=>$type,'CategoryID' => $catId,'thrash'=>'0');
		$q = $this->db->get_where('forum_category', $options);
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
	
	/** Count _max_ order */
	
	public function count_max_order($type,$table,$filled)
	{
			$this->db->select_max($filled);
			$this->db->where('parentID','0');
			$this->db->where('type',$type);
			$this->db->where('thrash','0');
			$query = $this->db->get($table);
			$row = $query->row(); 
			echo $row->order;
	}		
	
	/**
	* Insert New Genre.
	*/
	public function add_category($catData)
	{ 	
		$this->db->insert('forum_category', $catData);
		return $this->db->insert_id();	     
	}
	
	/**
	* Update Genre.
	*/
	public function update_category($catData,$catId)
	{ 
		$this->db->where('CategoryID', $catId);
		$this->db->update('forum_category', $catData);
	}
	
/* -------------- Sub Category Section -------------------------/
 * get_subcategory_list
 * 
 * /	
	
	/**
	* Get Genre listing.
	*/
	public function get_subcategories_listing($type,$limit=0,$offset=0, $returnRow=false)
	{
		$this->db->select('*');
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('order asc');
		
		// check Where Condition for helper and Forum
		
		$options=array('parentID !='=>'0','type'=>$type,'thrash'=>'0');
		$q = $this->db->get_where('forum_category',$options);
		return $q->result_array();
	}
	
	/**
	* Get subCategory data.
	*/
	public function get_subcategories_details($type,$catId)
	{		
		$data = array(); 
		$this->db->select('*');
		$this->db->limit('1');
		$options = array('parentID !='=>'0','type'=>$type,'CategoryID' => $catId,'thrash'=>'0');
		$q = $this->db->get_where('forum_category', $options);
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
	
	/* Count max SubCate */
	
	public function sub_count_max_order($type,$table,$filled)
	{
			$this->db->select_max($filled);
			$this->db->where('parentID !=','0');
			$this->db->where('type',$type);
			$this->db->where('thrash','0');
			$query = $this->db->get($table);
			$row = $query->row(); 
			echo $row->order;
	}		
	

	
}
