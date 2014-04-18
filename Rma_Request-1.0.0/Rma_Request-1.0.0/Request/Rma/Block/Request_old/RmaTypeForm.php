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
	 * @return mixed (Reports_Rma_Model_Enquiry|null)
	 * @author Tosif Qureshi
	 */
	public function getCurrentRmaData() {
		return Mage::registry('rma_post_data');
	}
	
	/**
	 * get the rma selected type
	 * @access public
	 * @return mixed (Reports_Rma_Model_Enquiry|null)
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
	public function getProductData(){
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
} 
