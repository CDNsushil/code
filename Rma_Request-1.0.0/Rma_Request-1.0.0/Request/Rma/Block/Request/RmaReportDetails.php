<?php 
/**
 * Request_Rma extension
 * Rma report detail block
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
class Request_Rma_Block_Request_RmaReportDetails extends Mage_Core_Block_Template {
	
	/**
	 * initialize
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
 	public function __construct(){
		parent::__construct();
		/* Load rma report model */
		$model = Mage::getModel('rma/request');
		/* Get rma reported records */
		$rma_data = $model->getCollection();
		
		$this->setRmaData($rma_data);
	}
	
	/**
	 * get the current rma details
	 * @access public
	 * @return mixed (Reports_Rma_Model_data|null)
	 * @author Tosif Qureshi
	 */
	public function getCurrentReportedRmaData(){
		/* Load rma report model */
		$model = Mage::getModel('rma/request');
		/* Get last saved rma Id from session*/
		$rma_id = Mage::getSingleton('core/session')->getLastRmaId();
		/* Get rma reported detail */
		$reported_rma_data = $model->load($rma_id);
		/* Set order id */
		Mage::register('order_id',$reported_rma_data->getOrder_id());
		
		return $reported_rma_data;
	}
	
	/**
	 * get the all items records of rma
	 * @access public
	 * @return mixed (Reports_Rma_Model_data|null)
	 * @author Tosif Qureshi
	 */
	public function getRmaItemsData(){
		
		/* Load rma report model */
		$model = Mage::getModel('rma/items');
		/* Get last saved rma Id from session*/
		$rma_id = Mage::getSingleton('core/session')->getLastRmaId();
		/* temparary set all data for items */
		$rma_items = $model->getCollection()->load();
		return $rma_items;
	}
	
	/**
	 * get the current reported product name data
	 * @access public
	 * @return product name
	 * @author Tosif Qureshi
	 */
	public function getReportedProductName($sku_number='') {
		/* Set rma product name by sku */
		$product = Mage::getModel('catalog/product')->loadByAttribute('sku',$sku_number); 
		return $product->getName();
	}
	
	/**
	 * get the order details
	 * @access public
	 * @return order data
	 * @author Tosif Qureshi
	 */
	public function getOrderDetails() {
		/* Get order id */
		$order_id = Mage::registry('order_id');
		return Mage::getModel('sales/order')->load($order_id);
	}
	
	/**
	 * get the invoice details
	 * @access public
	 * @return order data
	 * @author Tosif Qureshi
	 */
	public function getInvoices() {
        $invoices = Mage::getResourceModel('sales/invoice_collection')->setOrderFilter($this->getOrderDetails()->getId())->load();
        return $invoices;
    }
    
    /**
	 * get edit rma form url
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getRmaEditUrl($item_id=0) {
        return Mage::getUrl('rma/request/editRmaForm',array('item_id'=>$item_id));
    }
    
     /**
	 * get shipping detail edit url
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getShippingEditUrl($order_id=0) {
        return Mage::getUrl('rma/request/editShippingAddress',array('order_id'=>$order_id));
    }
    
    /**
	 * get billing detail edit url
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getBillingEditUrl($order_id=0) {
        return Mage::getUrl('rma/request/editBillingAddress',array('order_id'=>$order_id));
    }
    
    /**
	 * get rma form url
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getRmaFormUrl($order_id=0,$rma_id=0) {
        return Mage::getUrl('rma/request/rmaform',array('order_id'=>$order_id,'rma_id'=>$rma_id));
    }
    
    /**
	 * get rma id
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getRmaId() {
        return Mage::getSingleton('core/session')->getLastRmaId();
    }
    
    /**
	 * get the cms terms and condition page data
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getTermsPageData() {
        return Mage::getModel('cms/page')->load('terms','identifier');
    } 
	
} 
