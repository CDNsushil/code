<?php 
/**
 * Request_Rma extension
 * Rma type form block
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */

class Request_Rma_Block_Request_RmaTypeForm extends Mage_Core_Block_Template {
	/**
	 * get the current enquiry
	 * @access public
	 * @return mixed (Reports_Rma_Model_Request|null)
	 * @author Tosif Qureshi
	 */
	public function getCurrentRmaData() {
		return Mage::registry('rma_post_data');
	}
	
	/**
	 * get the rma selected type
	 * @access public
	 * @return mixed (Reports_Rma_Model_Request|null)
	 * @author Tosif Qureshi
	 */
	public function getRmaTypeTitle() {
		return Mage::registry('rma_type_title');
	}
	
	/**
	 * get the product data
	 * @access public
	 * @return array of product data
	 * @author Tosif Qureshi
	 */
	public function getProductData() {
		return Mage::registry('product_data');
	}
	
	/**
	 * get session value of sku if exist
	 * @access public
	 * @return sku session value
	 * @author Tosif Qureshi
	 */
	public function getIsSkuExist() {
		return Mage::getSingleton('core/session')->getSkuNumber();
	}
	
	/**
	 * get order id
	 * @access public
	 * @return order id
	 * @author Tosif Qureshi
	 */
	public function getOrderId() {
		return Mage::registry('order_id');
	}
	
	/**
	 * get rma id
	 * @access public
	 * @return rma id
	 * @author Tosif Qureshi
	 */
	public function getRmaId() {
		return Mage::registry('rma_id');
	}
	
	/**
	 * get order details
	 * @access public
	 * @return mixed order data
	 * @author Tosif Qureshi
	 */
	public function getOrderDetails() {
		/* Get order id */
		$order_id = Mage::registry('order_id');
		/* Get order details by order id */
		$orderCollection = Mage::getModel('sales/order')->load($order_id);
		return $orderCollection;
	}
	
	/**
	 * get rma reasons data
	 * @access public
	 * @return rma reason mix data
	 * @author Tosif Qureshi
	 */
 	public function getRmaReasons() {
		/* Load rma reason model */
		$model = Mage::getModel('rma/reason');
		/* Get rma reason records */
		return $model->getCollection();
	}
	
	 /**
     * Return back url to rma form
     * @return string
     */
    public function getRmaBackUrl() {
        return Mage::getUrl('rma/request/rmaform',array('order_id'=>Mage::registry('order_id')));
    }

    /**
     * Return back title for rma form
     * @return string
     */
    public function getBackTitle()
    {
       return Mage::helper('sales')->__('Back to RMA Form');
    }
	
} 
