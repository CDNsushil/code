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
 * @author 		Sushil Mishra
 */
class Request_Rma_Model_Resource_Type_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{
	protected $_joinedFields = array();
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('rma/type');
	}
}
