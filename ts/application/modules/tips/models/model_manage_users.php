<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter tips files editor.
 *
 */
class Model_manage_users extends CI_Model {
	private $userAuth 					= 'UserAuth'; 
	private $tableSalesOrder			= 'SalesOrder';
	
	function __construct()
	{
		parent::__construct();  
		
	}
	
	public function get_users()
	{
		 $this->db->select('username,email,active,banned');
		 $this->db->from($this->userAuth);
		 $this->db->order_by('active','Desc');
		 $query = $this->db->get();
		 return $query->result_array();
	}
	
	
	/*
	 ************************************************ 
	 * This function is used to get all sales details for admin
	 ************************************************ 
	 */  
  
  
	function AllSalesDetailsForExport()
	{
		$this->db->select('SalesOrder.ordDateComplete as  Date, SalesOrderItem.receiverTransactionId as Invoice,SalesOrder.custName 
		as 	Buyer,SalesOrderItem.itemName as Item,SalesOrderItem.itemQty as 
		qty, SalesOrderItem.sellerInfo as 
		sellerName, SalesOrder.ordCurrency as Currency, SalesOrderItem.basePrice as price ,SalesOrderItem.taxName,SalesOrderItem.taxPercent,SalesOrderItem.taxValue,SalesOrderItem.shipping,SalesOrderItem.tsCommissionPercent,SalesOrderItem.tsCommissionValue,SalesOrderItem.tsVatPercent,SalesOrderItem.tsVatValue,SalesOrderItem.tsGrossCommision,SalesOrderItem.purchaseType');
		$this->db->from($this->tableSalesOrder);	  	
		$this->db->join('SalesOrderItem','SalesOrder.ordId = SalesOrderItem.ordId','left');
		$this->db->join('BuyerComments','SalesOrderItem.itemId = BuyerComments.itemId','left');
		$this->db->order_by('SalesOrder.ordId','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result['get_num_rows'] = $query->num_rows();
		$result['get_result'] = $query->result_array();
		$result['get_first_row']=$query->list_fields('array');
		return $result;
	}	
	
	
	/*
	 *************************************** 
	 * This method is used to get record for all membership export for admin
	 *************************************** 
	 */ 
	
	
	
		function all_export_purchased_details()
		{
			$this->db->select('o.createDate as Date, o.ordNumber as invoice, o.custName as customerName, o.paypalEmail');
			$this->db->select('c.title');
			$this->db->select('i.size, i.type, i.totalPrice, i.taxPercent, i.taxValue, i.memItemId');
			$this->db->from('MembershipOrder as o');	  	
			$this->db->join('UserMembershipItem as i','i.orderId = o.orderId','left');
			$this->db->join('UserContainer as c','c.userContainerId = i.userContainerId','left');
			$this->db->where('i.parentContId',0);	
			$this->db->order_by('o.orderId','desc');
			$query = $this->db->get();
			$result['get_num_rows'] =  $query->num_rows();
			$result['get_result'] =  $query->result_array();
			$result['get_first_row']=$query->list_fields('array');
			return $result;
		}

}
/* End of file model_tips.php */
