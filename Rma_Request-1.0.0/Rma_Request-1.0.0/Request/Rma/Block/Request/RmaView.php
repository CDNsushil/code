<?php 
/**
 * Request_Rma extension
 * Rma view block
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
class Request_Rma_Block_Request_RmaView extends Mage_Core_Block_Template {
	
	/**
	 * initialize
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
 	public function __construct() {
		parent::__construct();
		/* Get the rma id */
		$rma_id = Mage::registry('rma_id');
		/* Get rma reported records */
		$rma_item_data = Mage::getModel('rma/request')->getRmaItemRecords($rma_id);
		/* Set all rma item data */
		$this->setRmaItemData($rma_item_data->getData());
	}
	
	/**
	 * get the current rma data
	 * @access public
	 * @return mixed (Reports_Rma_Model_Report|null)
	 * @author Tosif Qureshi
	 */
	public function getCurrentRmaData() {
		return Mage::registry('current_rma_data');
	}
	
	 /**
     * Return back url to rma listing
     * @return string
     */
    public function getRmaListBackUrl() {
        return Mage::getUrl('rma/request');
    }

    /**
     * Return back title for rma listing
     * @return string
     */
    public function getBackTitle() {
       return Mage::helper('sales')->__('Back to RMA List');
    }
    
    /**
	 * get the increamented real order id
	 * @access public
	 * @input $rma_id
	 * @return id string
	 * @author Tosif Qureshi
	 */
	public function getRealOrderId($rma_id=0) {
		/* Load items model and get order id */
		$rma_item = Mage::getModel('rma/request')->load($rma_id);
		/* Load order model and get order incremented id */
		$order = Mage::getModel('sales/order')->load($rma_item->getOrder_id());
		return $this->__('#').$order->getIncrement_id();
	}
    
    /**
     * get reason title of rma
     * @access public
     * @input $reason_id
     * @return string
     */
    public function getRmaReason($reason_id=0) {
		/* Load rma reason model and get reason */
		$rma_reason = Mage::getModel('rma/reason')->load($reason_id);
        return $rma_reason->getReason();
    }
	
} 
