<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Description	:This model only for backend membership module 
 * @author		:Rajendra Patidar
 * @package		:Mebership
 *
 */
class Membership_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
        
		$this->memberships = $this->db->dbprefix('memberships');
		$this->membership_features = $this->db->dbprefix('membership_features');
		$this->membership_access = $this->db->dbprefix('membership_access');

	}
	
	/**
	 * @Desc   :get all membership details
	 * @param  :array if required
	 * @return :array
	 */
	public function getMemberships($limit = NULL, $offset =0)
	{
		$this->db->order_by("id", "DESC");
		$query=$this->db->get($this->memberships,$limit,$offset); 
		//$this->db->last_query();  
		return $query->result();
	}
	
	/**
	 * @Desc   :insert membership details
	 * @param  :array $input The data to insert
	 * @return :array
	 */

	public function insert($input = array(), $skip_validation = false)
	{
		$insertId= parent::insert(array(
			'membership_title'			=> $input['membership_title'],
			'membership_price'			=> $input['membership_price'],
			'membership_status'			=> $input['membership_status'],
			'membership_days'			=> $input['membership_days'],
			'membership_description'	=> $input['membership_description'],
			'created_at'					=> date('Y-m-d H:i:s')
		));
		//to add select feature
		if(array_key_exists('membership_features', $input)){
			$featurs=$input['membership_features'];
			$data=array('membership_id'=>$insertId);
			if(count($featurs)>0){
				foreach($featurs as $feature){
					$data['feature_id']=$feature;
					$this->db->insert($this->membership_access,$data);
				}
			}
		}
		return $insertId;
	}
	/**
	 * @Desc   :update membership detail
	 * @param  :array $input The data to insert & id
	 * @return :array
	 */
	public function update($id = 0, $input = array(), $skip_validation = false)
	{
		$updateId= parent::update($id, array(
			'membership_title'			=> $input['membership_title'],
			'membership_price'			=> $input['membership_price'],
			'membership_status'			=> $input['membership_status'],
			'membership_days'			=> $input['membership_days'],
			'membership_description'	=> $input['membership_description'],
			'updated_at'				=> date('Y-m-d H:i:s')
		));
		$this->deleteSelectFeature($id);
		//to add select feature
		if(array_key_exists('membership_features', $input)){
			$featurs=$input['membership_features'];
			$data=array('membership_id'=>$id);
			if(count($featurs)>0){
				foreach($featurs as $feature){
					$data['feature_id']=$feature;
					$this->db->insert($this->membership_access,$data);
				}
			}
		}
		return $updateId;
	}

	/**
	 * Desc   :an array of features
	 * @param :void
	 * @return:array
	 */
	public function getFeatures()
	{
		$this->db->order_by("id", "DESC");
		$query = $this->db->get($this->membership_features);
        return $query->result();
	}
	/**
	 * Descrip:get membership feature details
	 * @param :id
	 * @return:object of feature
	 */
	public function getFeatureData($params = array())
	{
		$this->db->where($params); 
		$query = $this->db->get($this->membership_features);
        return $query->row();
	}
     
	/**
	 * @Desc  : Add membership featurs
	 * @param : array $input The data to insert
	 * @return: insertId
	 */
	public function insertFeature($input = array(), $skip_validation = false)
	{
        $data=array(
			'feature_title'			=> $input['feature_title'],
			'feature_status'		=> $input['feature_status'],
			'feature_description'	=> $input['feature_description'],
			
		); 
		$this->db->insert($this->membership_features,$data);
		return $this->db->insert_id();
	}

	/**
	 * @Desc  : update membership feature
	 * @param : array $input The data to update
	 * @return: array
	 */
	public function updateFeature($id = 0, $input = array(), $skip_validation = false)
	{
		
		 $data=array(
			'feature_title'			=> $input['feature_title'],
			'feature_status'		=> $input['feature_status'],
			'feature_description'	=> $input['feature_description']
		); 
		$this->db->where('id', $id);
        $this->db->update($this->membership_features,$data);
		return true;
	}

	/**
	 * @Desc  : remove feature
	 * @param : id
	 * @return: true/false
	 */
	public function deleteFeature($id = 0)
	{
		$this->db->where('id', $id)->delete($this->membership_features);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	/**
	 * @Desc  : remove select of membership feature
	 * @param : membershipId
	 * @return: true/false
	 */
	public function deleteSelectFeature($membershipId = 0)
	{
		$this->db->where('membership_id', $membershipId)->delete($this->membership_access);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	
	/**
	 * @Desc  :an array of selected features
	 * @param :param array
	 * @return:array
	 */
	public function getSelectFeatures($where)
	{
		$query = $this->db->get_where($this->membership_access,$where);
        return $query->result();
	}
	/**
	 * @Desc  :update status enabled and disabled for membership
	 * @param :eid (enabled id), did (disabled id)
	 * @return:array
	 */
	
	function membershipStatus($id=0,$did=0){
		$status='1';
		if($did){
			$id=$did;
			$status='0';
		} 
		 $updateId= parent::update($id, array(
			'membership_status'	=> $status
		));
		return $updateId;
	}
	/**
	 * @Desc  :update status enabled and disabled for feature
	 * @param :eid (enabled id), did (disabled id)
	 * @return:array
	 */
	
	function featureStatus($id=0,$did=0){
		$status='1';
		if($did){
			$id=$did;
			$status='0';
		} 
        $data=array(
			'feature_status'	=> $status
		); 
		$this->db->where('id', $id);
        $this->db->update($this->membership_features,$data);
		return true;
	}
	
	

	
}
