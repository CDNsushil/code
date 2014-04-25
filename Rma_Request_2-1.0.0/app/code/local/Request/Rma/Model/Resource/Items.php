<?php
/**
 * Request_Rma extension
 * Item model
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
class Request_Rma_Model_Resource_Items extends Mage_Core_Model_Mysql4_Abstract
{
	/**
     * rma table
     *
     * @var string
     */
    protected $_rma_table;
    
    /**
     * rma items table
     *
     * @var string
     */
    protected $_rma_items_table;
	
    public function _construct()
    {   
        $this->_init('rma/items', 'item_id');
        $this->_rma_table  = $this->getTable('rma/request');
		$this->_rma_items_table  = $this->getTable('rma/items');
    }
    
   /**
	 * get rma record of product
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
    public function loadByRmaSku($sku_number,$rma_id,$order_id,$customer_id) {
		$adapter = $this->_getReadAdapter();
		/* Get the customer data */
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		$select = $adapter->select()
			->from(array('rt' => $this->_rma_items_table), '*')
			->joinLeft(array('r' => $this->_rma_table), 'rt.rma_id = r.id', array('order_id' => 'r.order_id'))
			->where('r.order_id = :order_id')
			->where('rt.sku_number = :sku_number')
			->where('r.customer_id = :customer_id');	
		$bind = array(':sku_number' => (string)$sku_number,':order_id' => (string)$order_id,':customer_id' => (string)$customer->Entity_id);
		return $adapter->fetchRow($select, $bind);
    }
}
