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
 * Rma lform block
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
 
class Request_Rma_Block_Request_RmaForm extends Mage_Core_Block_Template {
	/**
	 * get the current enquiry
	 * @access public
	 * @return mixed (Reports_Rma_Model_Enquiry|null)
	 * @author Tosif Qureshi
	 */
	public function getCurrentEnquiry(){
		return Mage::registry('current_rma_enquiry');
	}
} 
