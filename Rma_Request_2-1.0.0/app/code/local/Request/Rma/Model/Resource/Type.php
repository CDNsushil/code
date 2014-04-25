<?php
/**
 * Request_Rma extension
 * Type model
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
 
class Request_Rma_Model_Resource_Type extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('rma/type', 'id');
    }
}
