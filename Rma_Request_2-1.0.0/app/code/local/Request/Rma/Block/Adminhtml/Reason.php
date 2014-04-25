<?php
class Request_Rma_Block_Adminhtml_Reason extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct(){
       $this->_blockGroup = 'rma';
       $this->_controller = 'adminhtml_reason';
       $this->_headerText = Mage::helper('adminhtml')->__('Reason Manager');
       $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add Reason');
       parent::__construct();
    }
}
