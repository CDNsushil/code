<?php
/**
 * Request_Rma extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Request
 * @package		Request_Rma
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Enquiry collection resource model
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
class Request_Rma_Model_Resource_Items_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{
	protected $_joinedFields = array();
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('rma/items');
		$this->_map['fields']['store'] = 'store_table.store_id';
	}
	/**
	 * get enquiries as array
	 * @access protected
	 * @param string $valueField
	 * @param string $labelField
	 * @param array $additional
	 * @return array
	 * @author Tosif Qureshi
	 */
	protected function _toOptionArray($valueField='entity_id', $labelField='report', $additional=array()){
		return parent::_toOptionArray($valueField, $labelField, $additional);
	}
	/**
	 * get options hash
	 * @access protected
	 * @param string $valueField
	 * @param string $labelField
	 * @return array
	 * @author Tosif Qureshi
	 */
	protected function _toOptionHash($valueField='entity_id', $labelField='report'){
		return parent::_toOptionHash($valueField, $labelField);
	}
	/**
	 * Add filter by store
	 * @access public
	 * @param int|Mage_Core_Model_Store $store
	 * @param bool $withAdmin
	 * @return Reports_Rma_Model_Resource_Enquiry_Collection
	 * @author Tosif Qureshi
	 */
	public function addStoreFilter($store, $withAdmin = true){
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
	/**
	 * Join store relation table if there is store filter
	 * @access protected
	 * @return Reports_Rma_Model_Resource_Enquiry_Collection
	 * @author Tosif Qureshi
	 */
	protected function _renderFiltersBefore(){
		if ($this->getFilter('store')) {
			$this->getSelect()->join(
				array('store_table' => $this->getTable('rma/enquiry_store')),
				'main_table.entity_id = store_table.enquiry_id',
				array()
			)->group('main_table.entity_id');
			/*
			 * Allow analytic functions usage because of one field grouping
			 */
			$this->_useAnalyticFunction = true;
		}
		return parent::_renderFiltersBefore();
	}
	/**
	 * Get SQL for get record count.
	 * Extra GROUP BY strip added.
	 * @access public
	 * @return Varien_Db_Select
	 * @author Tosif Qureshi
	 */
	public function getSelectCountSql(){
		$countSelect = parent::getSelectCountSql();
		$countSelect->reset(Zend_Db_Select::GROUP);
		return $countSelect;
	}
	/**
	 * add the product filter to collection
	 * @access public
	 * @param mixed (Mage_Catalog_Model_Product|int) $product
	 * @return Reports_Rma_Model_Resource_Enquiry_Collection
	 * @author Tosif Qureshi
	 */
	public function addProductFilter($product){
		if ($product instanceof Mage_Catalog_Model_Product){
			$product = $product->getId();
		}
		if (!isset($this->_joinedFields['product'])){
			$this->getSelect()->join(
				array('related_product' => $this->getTable('rma/enquiry_product')),
				'related_product.enquiry_id = main_table.entity_id',
				array('position')
			);
			$this->getSelect()->where('related_product.product_id = ?', $product);
			$this->_joinedFields['product'] = true;
		}
		return $this;
	}
}
