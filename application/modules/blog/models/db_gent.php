<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare db_gent Model Class
 *
 *  Handel database communication db_gent for all type of Projects and there elements 
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Mr. Mayank Kanungo
 *  @link		http://toadsquare.com/
 */
class db_gent extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}
	
	
	/**
	*  Get project information form datbase 
	*
	*
	*@Access Public
	*@Param Project Id
	*@Return StdClass obnject of Project Values
	*
	**/
	public function getStrProject($projId){
			$this->db->select('*');
				$this->db->from('TDS_UpcomingProject');
				$this->db->where('projId',$projId);
			$query = $this->db->get();
			return $result=$query->result();
	}
	
	
	/**
	*  Get associative information form datbase 
	*
	*
	*@Access Public
	*@Param Project Id
	*@Return StdClass obnject of all Elements of given project (Id)
	*
	**/
	
	public function getStrAssociative($projId, $elementId, $associatveId){
			$this->db->select('*');
			$this->db->from('TDS_ASSOCIATIVES');
			
			if(isset($projId)){
				$this->db->where('projId',$projId);
			}
			if(isset($elementId)){
				$this->db->where('elementId',$elementId);
			}
			if(isset($associatveId)){
				$this->db->where('associativeId',$associatveId);
			}
			
			$this->db->order_by('associativeId', 'asc');
				
			$query = $this->db->get();
			return $result=$query->result();
	}
	
	/**
	*  Get additional information form datbase 
	*
	*
	*@Access Public
	*@Param Project Id
	*@Return StdClass obnject of all Elements of given project (Id)
	*
	**/
	
	public function getStrAdditionalInfo($tableName, $where, $orderBy){
			$this->db->select('*');
			$this->db->from($tableName);
			$this->db->where($where);
			$this->db->order_by('infoId','asc');

			$query = $this->db->get();
			return $result=$query->result();
	}
	
	
	/**
	*  DO Insert information to datbase 
	*
	*
	*@Access Public
	*@Param Table Name, Array of Project data
	*@Return last insert id
	*
	**/
	public function doInsert($table,$data){
		$this->db->insert($table , $data);
		//return $result =  $this->db->insert_id();
		return true;
	}

	
	/**
	*  Update Project information to datbase 
	*
	*
	*@Access Public
	*@Param Table Name, Array of Project data,Project Id
	*@Return True
	*
	**/
	public function updateProject($table,$data, $projId){
			$this->db->where('projId' , $projId);
			$this->db->update($table , $data);
			return true;
	}
	
	
	
	/**
	*  Update Element information to datbase  
	*
	*
	*@Access Public
	*@Param Table Name, Array of Elemet data,Project Id, Element Id
	*@Return True
	*
	**/
	public function updateElement($table,$data, $projId, $elementId){
			$this->db->where('projId' , $projId);
			$this->db->where('elementId' , $elementId);
			$this->db->update($table , $data);
			//print_r( $data);
			return true;
	}
	
	/**
	*  Update Associative information to datbase  
	*
	*
	*@Access Public
	*@Param Table Name, Array of Elemet data,Project Id, Element Id
	*@Return True
	*
	**/
	public function updateAssociative($table,$data, $associativeId){
			$this->db->where('associativeId' , $associativeId);
			$this->db->update($table , $data);
			return true;
	}
	
	public function updateAdditionalInfo($table,$data, $where){
			$this->db->where($where);
			$this->db->update($table , $data);
			return true;
	}
	
}
?>