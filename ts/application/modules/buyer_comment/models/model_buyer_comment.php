<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class model_buyer_comment extends CI_Model { 

    

	
	private $tableSalesOrder			= 'SalesOrder';
	private $tableSalesOrderItem		= 'SalesOrderItem';
	private $tableBuyerComments			= 'BuyerComments';
	
	
	
	function __construct(){
		parent::__construct();
	} 
	
	
	/*******
   * 
   * This function is used to get all comments by userId
   * 
   * *****/
  
  function get_buyer_comments($userId,$limit=0,$offset=0)
	{
		
		$this->db->select('BuyerComments.*,SalesOrder.custName,SalesOrderItem.entityId,SalesOrderItem.elementId,itemName');	
		$this->db->from($this->tableBuyerComments);	
		$this->db->join('SalesOrderItem','SalesOrderItem.itemId = BuyerComments.itemId','left');	
		$this->db->join('SalesOrder','SalesOrder.ordId = SalesOrderItem.ordId','left');
		$this->db->where('ownerId',$userId);
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('BuyerComments.id','desc');
			
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result['get_num_rows'] = $query->num_rows();
		$result['get_result'] = $query->result();
		return $result;
	}
	
	
	
 	
 
} 
