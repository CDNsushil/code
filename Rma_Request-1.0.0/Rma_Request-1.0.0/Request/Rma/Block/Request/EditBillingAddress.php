<?php 
/**
 * Request_Rma extension
 * edit billing adress block
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */

class Request_Rma_Block_Request_editBillingAddress extends Mage_Core_Block_Template {
	/**
	 * get the billing details of order
	 * @access public
	 * @return order data
	 * @author Tosif Qureshi
	 */
	public function getOrderBillingDetails() {
		/* Get order id */
		$order_id   = Mage::registry('order_id');
		/* Load order model and get order data */
		$order_data =  Mage::getModel('sales/order')->load($order_id);
		return $order_data->getBillingAddress();
	}
	
	/**
	 * get billing update action url
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getSaveUrl() {
		return $this->getUrl('rma/request/updateBilling');
	}
	
	/**
	 * get rma detail page url
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getRmaDetailUrl() {
		return $this->getUrl('rma/request/rmaReportDetail');
	}
	
	/**
	 * get rma detail page title
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getBackTitle() {
		return $this->__('Back to RMA');
	}
	
} 
