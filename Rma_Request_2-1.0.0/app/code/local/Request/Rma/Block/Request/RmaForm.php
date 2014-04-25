<?php 
/**
 * Request_Rma extension
 * Rma form block
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
 
class Request_Rma_Block_Request_RmaForm extends Mage_Core_Block_Template {
	/**
	 * get the order id
	 * @access public
	 * @return int order_id
	 * @author Tosif Qureshi
	 */
	public function getOrderId() {
		return Mage::registry('order_id');
	}
	
	/**
	 * get rma type
	 * @access public
	 * @return rma type data
	 * @author Tosif Qureshi
	 */
 	public function getRmaType() {
		/* Load rma type model */
		$model = Mage::getModel('rma/type');
		/* Get rma type records */
		return $model->getCollection();
	}
	
	/**
     * Return back url to my order
     * @return string
     */
    public function getOrderBackUrl() {
		
		/* Set default rma back url */
		$back_url = Mage::getUrl('sales/order/history');
		/* Set rma back url if rma data exist */
        if($this->getRequest()->getParam('rma_id')) {
			$back_url = Mage::getUrl('rma/request/rmaReportDetail');
		}
		return $back_url;
    }

    /**
     * Return back title for order form
     * @return string
     */
    public function getBackTitle() {
		/* Set default rma back lable */
		$back_lbl = $this->__('Back to My Order');
		/* Set rma back url if rma data exist */
        if($this->getRequest()->getParam('rma_id')) {
			$back_lbl = $this->__('Back to RMA detail');
		}
       return $back_lbl;
    }
    
    /**
	 * get the rma id
	 * @access public
	 * @return int rma_id
	 * @author Tosif Qureshi
	 */
	public function getRmaId() {
		return Mage::registry('rma_id');
	}
	
} 
