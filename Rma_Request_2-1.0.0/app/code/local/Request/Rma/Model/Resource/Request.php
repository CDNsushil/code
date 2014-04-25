<?php
/**
 * Request_Rma extension
 * Request model
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
    
class Request_Rma_Model_Resource_Request extends Mage_Core_Model_Resource_Db_Abstract
{
	/**
     * rma table
     *
     * @var string
     */
    protected $_rma_table;
    protected $_rma_items_table;
    protected $_rma_type_table;
    protected $_rma_reason_table;
    
     public function _construct()
     {
		 $this->_init('rma/request','id');
		 $this->_rma_table  = $this->getTable('rma/request');
		 $this->_rma_items_table  = $this->getTable('rma/items');
		 $this->_rma_type_table  = $this->getTable('rma/type');
		 $this->_rma_reason_table  = $this->getTable('rma/reason');
         
     }
     
     /**
	 * get all rma items data of customer
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
    public function getItemsRma($customer_id) {
		$adapter = $this->_getReadAdapter();
		$select = $adapter->select()
			->from(array('rt' => $this->_rma_items_table), '*')
			->joinLeft(array('r' => $this->_rma_table), 'rt.rma_id = r.id', array('order_id' => 'r.order_id'))
			->where('rt.customer_id = :customer_id');
		$bind = array(':customer_id' => (string)$customer_id);
		/* Fetch all records of rma items */
		return $adapter->fetchAll($select, $bind);
    }
    
    /**
	 * get all rma of customer
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
    public function getRmaRecords($customer_id) {
		$adapter = $this->_getReadAdapter();
		$select = $adapter->select()
			->from(array('r'=>$this->_rma_table), '*')
			->where('r.customer_id = :customer_id');
		$bind = array(':customer_id' => (string)$customer_id);
		/* Fetch all records of rma */
		return $adapter->fetchAll($select, $bind);
    }
    
    /**
	 * get all rma items of rma
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
    public function getRmaItemRecords($rma_id) {
		
		$adapter = $this->_getReadAdapter();
		/* Get the customer data */
		$customer = Mage::getSingleton('customer/session')->getCustomer();
	
		$select = $adapter->select()
			->from(array('rt' => $this->_rma_items_table), '*')
			->joinLeft(array('r' => $this->_rma_table), 'rt.rma_id = r.id', array('rma_id' => 'r.id','order_id' => 'r.order_id'))
			->where('r.customer_id = :customer_id')
			->where('r.id = :id');
		$bind = array(':customer_id' => (string)$customer->Entity_id,':id' => (string)$rma_id);
		/* Fetch all records of rma items */
		return $adapter->fetchAll($select, $bind);
    }
    
    
    public function getRmaItemDetails($itemId) {
		
		
		
		$adapter = $this->_getReadAdapter();
		
		$select = $adapter->select()
			->from(array('i' => $this->_rma_items_table), '*')
			->joinLeft(array('r' => $this->_rma_table), 'r.id=i.rma_id', array('order_id' => 'r.order_id'))
			->joinLeft(array('rt' => $this->_rma_type_table), 'rt.id = i.type_id', array('type' => 'rt.type'))
			->joinLeft(array('rr' => $this->_rma_reason_table), 'rr.id = i.reason_id', array('reason' => 'rr.reason'))
			->where('i.item_id = :id');
		$bind = array(':id' => (string)$itemId);
		
		/* Fetch all records of rma items */
		return $adapter->fetchAll($select, $bind);
    }
    
    
    public function getRmaRequestDetails($itemId) {
		
		$adapter = $this->_getReadAdapter();
		$sales_order = Mage::getSingleton("core/resource")->getTableName('sales/order');
		
		$attributeTable = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'warranty_period')->getBackend()->getTable();
		$attributeId = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'warranty_period')->getAttributeId();
		
		$catalog_product_entity = Mage::getSingleton("core/resource")->getTableName('catalog_product_entity');
		$pName  = Mage::getResourceSingleton('catalog/product')->getAttribute('name'); 
		
		$select = $adapter->select()
			->from(array('i' => $this->_rma_items_table), '*')
			->joinLeft(array('r' => $this->_rma_table), 'r.id=i.rma_id', array('order_id' => 'r.order_id'))
			->joinLeft(array('rt' => $this->_rma_type_table), 'rt.id = i.type_id', array('type' => 'rt.type'))
			->joinLeft(array('rr' => $this->_rma_reason_table), 'rr.id = i.reason_id', array('reason' => 'rr.reason'))
			->joinLeft(
				array('cpe' =>$catalog_product_entity),
				'cpe.sku = i.sku_number',
				array('cpe_entity_id' => 'cpe.entity_id')
			 )
			 ->joinLeft(
				array('prod' =>$pName->getBackend()->getTable()),
				'prod.entity_id = cpe.entity_id AND prod.attribute_id = '.(int) $pName->getAttributeId() . '',
				array('pName' => 'prod.value')
			 )
			 ->joinLeft(
				 array('attr' => $attributeTable),
				 'prod.entity_id = attr.entity_id AND attr.attribute_id = '.$attributeId.'', 
				 array('warranty_period' => 'attr.value')
			)
			->joinLeft(
				array('so' =>$sales_order), 'so.entity_id = r.order_id',
				array('date_of_shipment' => 'so.created_at')
			 )
			->where('i.item_id = :id');
		$bind = array(':id' => (string)$itemId);
		
		/* Fetch all records of rma items */
		return $adapter->fetchAll($select, $bind);
    }
    
    /**
	 * get customer data of rma reporting
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
    public function getRmaUserData($rma_id) {
		$adapter = $this->_getReadAdapter();
		$select = $adapter->select()
			->from(array('rt' => $this->_rma_items_table), '*')
			->joinLeft(array('r' => $this->_rma_table), 'rt.rma_id = r.id', array('order_id' => 'r.order_id'))
			->where('rt.customer_id = :customer_id');
		$bind = array(':customer_id' => (string)$customer_id);
		/* Fetch all records of rma items */
		return $adapter->fetchAll($select, $bind);
    }
}
