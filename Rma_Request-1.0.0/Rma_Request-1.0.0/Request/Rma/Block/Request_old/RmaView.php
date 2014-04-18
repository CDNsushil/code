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
 * Rma view block
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
class Request_Rma_Block_Request_RmaView extends Mage_Core_Block_Template{
	/**
	 * get the current rma data
	 * @access public
	 * @return mixed (Reports_Rma_Model_Report|null)
	 * @author Tosif Qureshi
	 */
	public function getCurrentRmaData(){
		return Mage::registry('current_rma_data');
	}
} 
