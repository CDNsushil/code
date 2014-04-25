<?php 
/**
 * Request_Rma extension
 * Report detail block
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
class Request_Rma_Block_Request_RmaList extends Mage_Core_Block_Template {
	
	/**
	 * initialize
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
 	public function __construct() {
		parent::__construct();
		/* Get the customer data */
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		/* Get all reported RMA of customer */
		$collection = Mage::getModel('rma/request')->getCollection()->addFieldToFilter('customer_id', $customer->Entity_id);
		/* Set all rma data */
		$this->setCollection($collection);
	}
	
	/**
	 * prepare the pagination view of listing
	 * @access protected
	 * @return void
	 * @author Tosif Qureshi
	 */
	protected function _prepareLayout() { 
		
		parent::_prepareLayout(); 
		$pager = $this->getLayout()->createBlock('page/html_pager', 'rma.request.rmalist.pager'); 
		$pager->setAvailableLimit(array(5=>5, 10=>10, 20=>20, 'all'=>'all')); 
		$pager->setCollection($this->getCollection()); 
		$this->setChild('pager', $pager); 
		$this->getCollection(); 
		return $this; 
	} 
		
	public function getPagerHtml() { 
		return $this->getChildHtml('pager');
	}
	
	/**
	 * get the current rma details
	 * @access public
	 * @return mixed (Reports_Rma_Model_data|null)
	 * @author Tosif Qureshi
	 */
	public function getCurrentReportedRmaData() {
		/* Load rma report model */
		$model = Mage::getModel('rma/request');
		/* Get last saved rma Id from session*/
		$rma_id = Mage::getSingleton('core/session')->getLastRmaId();
		
		/* Get rma reported detail */
		$reported_rma_data = $model->load($rma_id);
		return $reported_rma_data;
	}
	
	/**
	 * get the current reported product name data
	 * @access public
	 * @return product name
	 * @author Tosif Qureshi
	 */
	public function getReportedProductName() {
		
		/* Get sku number from session*/
		$sku_number = Mage::getSingleton('core/session')->getSkuNumber();
		
		/* Set rma product name by sku */
		$product = Mage::getModel('catalog/product')->loadByAttribute('sku',$sku_number); 
		return $product->getName();
	}
	
	/**
	 * get the current rma view url with rma id
	 * @access public
	 * @return product name
	 * @author Tosif Qureshi
	 */
	public function getRmaViewUrl($rma_id='') {

		return Mage::getUrl('rma/request/rmaView', array('id'=>$rma_id));
	}
	
	/**
	 * get the rma edit url
	 * @access public
	 * @return product name
	 * @author Tosif Qureshi
	 */
	public function getRmaEditUrl($rma_id='') {
		/* Set inserted rma id for detail page */
		Mage::getSingleton('core/session')->setLastRmaId($rma_id);
		return Mage::getUrl('rma/request/rmaReportDetail');
	}
	
	/**
	 * get real formatted order id
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getRealOrderId($rma_id=0) {

		return Mage::helper('rma/request')->getRealOrderId($rma_id);
	}
	
	/**
	 * get create data formate
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getCreatedDate($created='') {

		return date('d/m/Y',strtotime($created));
	}
	
	/**
	 * get RMA item count
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getRmaItemCount($rma_id=0) {
		/* Get rma reported records */
		$rma_item_data = Mage::getModel('rma/request')->getRmaItemRecords($rma_id);
		return count($rma_item_data->getData());
	}

} 
