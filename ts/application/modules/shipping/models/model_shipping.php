<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}
/* =================================================================================================
	//Start Date: 27-08-12 Added by sushil for common select, insert, update, delee query  
====================================================================================================*/

class model_shipping extends CI_Model {

	private $tblShipping 		= 'ProjectShipping'; //Private Variable(Table Name) to get used at class level only
	private $tblShippingZone	= 'ProjectShippingZone';
	private $tblCountry			= 'MasterCountry';
	private $tblContinent		= 'MasterContinent';
	
	function __construct(){
		parent::__construct();
	}
	
	//shippingList
	function shippingCountry($elementId=0,$entityId=0,$zoneId=0){
		
		//$countirsNotIn[]=LoginUserDetails('countryId');
		$countirsNotIn[]=0;
		$where=array(
			'elementId'=>$elementId,
			'entityId'=>$entityId,
		);
		
		$this->db->select('countriesId');
		$this->db->from($this->tblShipping);
		$this->db->where($where);
		$this->db->where_not_in('zoneId',$zoneId);
		$this->db->limit(6);
		$query 	= $this->db->get();
		$result = $query->result();
		if($result){
			foreach($result as $countries){
				$countriesId=$countries->countriesId;
				$countriesId=explode('|',$countriesId);
				$countirsNotIn = array_merge((array)$countirsNotIn, (array)$countriesId);
			}
		}
		$countirsNotIn=array_diff($countirsNotIn, array(''));

		
		$countries=false;
		$tblCountry=$this->db->dbprefix($this->tblCountry);
		$where=array($tblCountry.'.status'=>1);
		
		$this->db->select('countryName,countryId,continentId,continent');
		$this->db->from($this->tblCountry);
		$this->db->join($this->tblContinent, $this->tblContinent.".id = ".$this->tblCountry.".continentId");
		$this->db->where($where);
		$this->db->where_not_in('countryId',$countirsNotIn);
		$this->db->order_by('continent', 'ASC');
		$this->db->order_by('countryName', 'ASC');
		$query 	= $this->db->get();
		//echo $this->db->last_query(); die;
		$res = $query->result();
		return $res;
	}
	
	function globalShippingCountryList($userId=0,$spId=0){
		
		$countirsInZone=false;
		$where=array(
			'userId'=>$userId,
			'isGlobal'=>'t',
		);
		
		$this->db->select('countriesId');
		$this->db->from($this->tblShipping);
		$this->db->where($where);
		if(is_numeric($spId) && ($spId>0) ){
			$this->db->where_not_in('spId',$spId);
		}
		
		$query 	= $this->db->get();
		$result = $query->result();
		if($result){
			foreach($result as $k=>$countries){
				$countriesId=$countries->countriesId;
				$countriesId=explode('|',$countriesId);
				if($k==0){
					$countirsInZone=$countriesId;
				}else{
					$countirsInZone = array_merge((array)$countirsInZone, (array)$countriesId);
				}
			}
			$countirsInZone=array_diff($countirsInZone, array(''));
		}
		

		
		$tblCountry=$this->db->dbprefix($this->tblCountry);
		$where=array($tblCountry.'.status'=>1);
		
		$this->db->select('countryName,countryId,continentId,continent');
		$this->db->from($this->tblCountry);
		$this->db->join($this->tblContinent, $this->tblContinent.".id = ".$this->tblCountry.".continentId");
		$this->db->where($where);
		if($countirsInZone && is_array($countirsInZone) && !empty($countirsInZone)){
			$this->db->where_not_in('countryId',$countirsInZone);
		}
		$this->db->order_by('continent', 'ASC');
		$this->db->order_by('countryName', 'ASC');
		$query 	= $this->db->get();
		//echo $this->db->last_query(); die;
		$res = $query->result();
		return $res;
	}
	
	//shippingList
	function shippingList($elementId=0,$entityId=0){
		$result = false;
		if($elementId > 0 &&  $entityId > 0){
			$whereField=array(
				'lang'=>lang()
			);
			$tblShipping=$this->db->dbprefix($this->tblShipping);
			$tblShippingZone=$this->db->dbprefix($this->tblShippingZone);
			$this->db->select('*,'.$tblShippingZone.'.zoneId as "zoneId"');
			$this->db->from($this->tblShippingZone);
			$this->db->join($this->tblShipping, $this->tblShipping.'.zoneId = '.$this->tblShippingZone.'.zoneId AND "'.$tblShipping.'"."entityId" ='.$entityId.' AND "'.$tblShipping.'"."elementId" ='.$elementId, 'left'); 
			$this->db->where($whereField);
			$this->db->order_by($this->tblShippingZone.'.zoneId', 'ASC');
			
			$query 	= $this->db->get();
			//echo $this->db->last_query();
			$result = $query->result_array();
		}
		if($result){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	
	function globalShippingList($userId=0,$spId=0){
		$result = false;
		if($userId > 0){
			$whereField=array(
				'userId'=>$userId,
				'isGlobal'=>'t',
			);
			if($spId ){
				$whereField['spId']=$spId;
		  }
			$this->db->select('*');
			$this->db->from($this->tblShipping);
			$this->db->where($whereField);
			$this->db->order_by('spId', 'ASC');
			
			$query 	= $this->db->get();
			$result = $query->result_array();
	  }
		return 	$result;
	}
}
?>
