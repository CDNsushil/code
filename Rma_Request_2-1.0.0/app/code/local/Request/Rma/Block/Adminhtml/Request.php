<?php
class Request_Rma_Block_Adminhtml_Request extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {

        $this->_controller = 'adminhtml_request';
        $this->_blockGroup = 'rma';
        $this->_headerText = Mage::helper('rma')->__('Request Manager');
        //$this->_addButtonLabel = Mage::helper('rma')->__('Add Request');
        parent::__construct();
        $this->removeButton('add');
    }
}
