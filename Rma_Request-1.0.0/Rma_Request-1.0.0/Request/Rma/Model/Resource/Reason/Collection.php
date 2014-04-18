<?php 
class Request_Rma_Model_Resource_Reason_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {  
		parent::_construct();
        $this->_init('rma/reason');
    }
}
