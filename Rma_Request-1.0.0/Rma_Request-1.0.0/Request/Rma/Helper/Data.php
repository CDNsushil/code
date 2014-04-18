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
 * Rma default helper
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
class Request_Rma_Helper_Data extends Mage_Core_Helper_Abstract{
	/**
	 * get the url to the enquiry list page
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getEnquiriesUrl(){
		return Mage::getUrl('rma/request/index');
	}
}
