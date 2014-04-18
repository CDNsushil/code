<?php
/**
 * Request_Rma extension
 * Type model
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
 
class Request_Rma_Model_Type extends Mage_Core_Model_Abstract
{ 
    public function _construct() {
	    parent::_construct();
	    
       $this->_init('rma/type');
       
    }
}
