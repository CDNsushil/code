<?php
/**
 * Request_Rma extension
 * Reason model
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */

class Request_Rma_Model_Reason extends Mage_Core_Model_Abstract
{ 
    public function _construct() {
	    parent::_construct();
	    
       $this->_init('rma/reason');
       
    }
}
