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
		/* Load rma report model */
		$model = Mage::getModel('rma/request');
		/* Get rma reported records */
		$rma_data = $model->getCollection();
		/* Set all rma data */
		$this->setRmaData($rma_data);
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
	public function getRmaViewUrl($rma_data='') {

		return Mage::getUrl('rma/request/rmaView', array('id'=>$rma_data->getId()));
	}

} 
