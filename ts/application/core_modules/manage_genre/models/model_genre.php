<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter tips files editor.
 *
 */
class Model_Genre extends CI_Model {
	 
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	* Get Genre listing.
	*/
	public function get_genre_listing($limit=0,$offset=0, $returnRow=false)
	{
		$this->db->select('Genre.*');
		$this->db->select('MasterProjectType.projectTypeName');
		$this->db->join('MasterProjectType', 'MasterProjectType.typeId = Genre.typeId');
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('Genre asc');
		$q = $this->db->get_where('Genre');
		return $q->result_array();
	}
	
	/**
	* Get Genre data.
	*/
	public function get_genre_details($genreId)
	{	
		$data = array(); 
		$this->db->select('*');
		$this->db->limit('1');
		$options = array('GenreId' => $genreId);
		$q = $this->db->get_where('Genre', $options);
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
	* Insert New Genre.
	*/
	public function add_genre($genreData)
	{ 	
		$this->db->insert('Genre', $genreData);
		return $this->db->insert_id();	     
	}
	
	/**
	* Update Genre.
	*/
	public function update_genre($genreData,$genreId)
	{ 
		$this->db->where('GenreId', $genreId);
		$this->db->update('Genre', $genreData);
	}
	
}
