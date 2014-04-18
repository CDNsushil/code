<?php
/**
 * Request_Rma extension
 * Reason model
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
 
class Request_Rma_Model_Resource_Reason extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('rma/reason', 'id');
    }
}
