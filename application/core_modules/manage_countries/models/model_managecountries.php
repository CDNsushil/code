<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter country files editor.
 *
 */
class Model_Managecountries extends CI_Model {
	 
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	* Get Country listing.
	*/
	public function get_country_listing($limit=0,$offset=0, $returnRow=false)
	{
		$this->db->select('MasterCountry.*');
		$this->db->select('MasterContinent.continent');
		$this->db->join('MasterContinent', 'MasterContinent.id = MasterCountry.continentId');
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('countryName asc');
		$options = array('countryGroup !=' => 'EU');
		$q = $this->db->get_where('MasterCountry', $options);
		//$q = $this->db->get_where('MasterCountry');
		return $q->result_array();
	}
	
	/**
	* Get Country data.
	*/
	public function get_country_details($countryId)
	{	$data = array(); 
		$this->db->select('*');
		$this->db->limit('1');
		$options = array('countryId' => $countryId);
		$q = $this->db->get_where('MasterCountry', $options);
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
	* Insert New Country .
	*/
	public function add_country($countryData)
	{ 	
		$this->db->insert('MasterCountry', $countryData);
		return $this->db->insert_id();	     
	}

	/**
	* Update Country data.
	*/
	public function update_country($countryData,$countryId)
	{ 
		$this->db->where('countryId', $countryId);
		$this->db->update('MasterCountry', $countryData);
	}
	
	/**
	* Get Continent Data List
	*/
	public function get_continent_list()
	{ 
		$this->db->select('*');
		$this->db->order_by('continent asc');
		$options = array('status' => 't');
		$q = $this->db->get_where('MasterContinent' , $options);
		return $q->result_array();
	}
	
	/*
	 ********************** 
	 * This for delete country
	 ********************* 
	 */ 
	
	function delete_country($countryId)  {	   		
	   $this->db->where('countryId', $countryId);
	   $this->db->delete('MasterCountry');
	   return true;				
		}	
	
}