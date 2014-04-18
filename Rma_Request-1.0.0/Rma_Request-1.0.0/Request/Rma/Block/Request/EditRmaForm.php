<?php 
/**
 * Request_Rma extension
 * Rma edit form block
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */

class Request_Rma_Block_Request_editRmaForm extends Mage_Core_Block_Template {
	/**
	 * get the current rma data
	 * @access public
	 * @return mixed (rma data)
	 * @author Tosif Qureshi
	 */
	public function getCurrentRmaData() {
		/* Get item id */
		$item_id = Mage::registry('item_id');
		return Mage::getModel('rma/items')->load($item_id);
	}
	
	/**
	 * get the rma selected type
	 * @access public
	 * @return mixed (Reports_Rma_Model_Enquiry|null)
	 * @author Tosif Qureshi
	 */
	public function getRmaTypeTitle() {
		/* Get rma id */
		$rma_id   = Mage::registry('rma_id');
		$rma_data = Mage::getModel('rma/request')->load($rma_id);
		/* Set rma report type title */
		$rma_type_title = Mage::helper('rma/request')->setRmaTypeTitle($rma_data->getRma_type());
		return $rma_type_title;
	}
	
	/**
	 * get the product data
	 * @access public
	 * @return array of product data
	 * @author Tosif Qureshi
	 */
	public function getProductData($product_id=0) {
		return Mage::getModel('catalog/product')->load($product_id);
	}
	
	/**
	 * get order details
	 * @access public
	 * @return mixed order data
	 * @author Tosif Qureshi
	 */
	public function getOrderDetails($order_id=0) {
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
		/* Set default rma back url */
		$back_url = Mage::getUrl('rma/request/rmaform',array('order_id'=>Mage::registry('order_id')));
		/* Set rma back url if item data exist */
        if($this->getRequest()->getParam('item_id')) {
			$back_url = Mage::getUrl('rma/request/rmaReportDetail');
		}
		return $back_url;
    }

    /**
     * Return back title for rma form
     * @return string
     */
    public function getBackTitle() {
       return $this->__('Back');;
    }
    
    /**
	 * get the serial number data
	 * @access public
	 * @return array of serial numbers
	 * @author Tosif Qureshi
	 */
	public function getSerialNumbers($serial_number=0) {
		/* Make array of serial numbers */
		$serial_number_array = explode(',',$serial_number);
		return $serial_number_array;
	}
	
	/**
	 * get the json formatted invoice default number
	 * @access public
	 * @return json value
	 * @author Tosif Qureshi
	 */
	public function getInvoiceNumber($invioce_number=0) {
		$invoice_array = array();
		/* Set invoice id and name to array */
		$invoice_data['id']   = $invioce_number;
		$invoice_data['name'] = $invioce_number;
		$invoice_array[] = $invoice_data;
		/*Convert array to json responce*/
		$invoice_json = json_encode($invoice_array);
		return $invoice_json;
	}
	
	/**
     * get order id by item id
     * @return string
     */
    public function getOrderId($rma_id=0) {
		$rma = Mage::getModel('rma/request')->load($rma_id);
		return $rma->getOrder_id();
    }
    
    /**
     * get serial count 
     * @return int
     */
	 public function getSerialCount($serial_number=0) {
		 /* Count serail number records */
		$serial_count = count($serial_number);
		/* Set default serial number count as 1 */
		if($serial_count==0) {
			$serial_count = 1;
		}
		return $serial_count;
    }
} 
