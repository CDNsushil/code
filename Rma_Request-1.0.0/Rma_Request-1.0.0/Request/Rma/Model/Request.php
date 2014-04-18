<?php
/**
 * Request_Rma extension
 * Request model
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */

class Request_Rma_Model_Request extends Mage_Core_Model_Abstract{ 
		
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_productInstance = null;
	protected $_joinedFields = array();
	
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function _construct() {
		 
		parent::_construct();
		$this->_init('rma/request');
	}
	
	/**
	 * get rma item data 
	 * @access public
	 * @param Reports_Rma_Model_Item $customer_id
	 * @return Reports_Rma_Model_Resource_Item_Collection
	 * @author Tosif Qureshi
	 */
    public function getItemsRma($customer_id) {
        $data= $this->_getResource()->getItemsRma($customer_id);
        $this->setData($data);
         return $this;
    }
    
     /**
	 * get all rma of customer
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
    public function getRmaRecords($customer_id) {
        $data= $this->_getResource()->getRmaRecords($customer_id);
        $this->setData($data);
         return $this;
    }
    
    
    /**
	 * get all rma items of rma
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
    public function getRmaItemDetails($itemId) {
        $data= $this->_getResource()->getRmaItemDetails($itemId);
        $this->setData($data);
        return $this;
    }
    
    
     public function getRmaRequestDetails($itemId) {
        $data= $this->_getResource()->getRmaRequestDetails($itemId);
        $this->setData($data);
        return $this;
    }
	
	/**
	 * get all rma items of rma
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
    public function getRmaItemRecords($rma_id) {
        $data= $this->_getResource()->getRmaItemRecords($rma_id);
        $this->setData($data);
         return $this;
    }
	
	/**
	 * get rma user records
	 * @access public
	 * @param rma_id
	 * @return Reports_Rma_Model_Resource_Request_Collection
	 * @author Tosif Qureshi
	 */
	public function getRmaUserData($rma_id) {
		$data= $this->_getResource()->getRmaUserData($rma_id);
        $this->setData($data);
         return $this;
	}
	
	  /**
	 * Add filter by store
	 * @access public
	 * @param int|Mage_Core_Model_Store $store
	 * @param bool $withAdmin
	 * @return Reports_Rma_Model_Resource_Enquiry_Collection
	 * @author Tosif Qureshi
	 */
	public function addStoreFilter($store, $withAdmin = true) {
		
		if (!isset($this->_joinedFields['store'])){
			if ($store instanceof Mage_Core_Model_Store) {
				$store = array($store->getId());
			}
			if (!is_array($store)) {
				$store = array($store);
			}
			if ($withAdmin) {
				$store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
			}
			$this->addFilter('store', array('in' => $store), 'public');
			$this->_joinedFields['store'] = true;
		}
		return $this;
	}
}
