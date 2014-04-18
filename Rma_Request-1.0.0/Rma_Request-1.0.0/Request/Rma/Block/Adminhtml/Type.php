<?php
class Request_Rma_Block_Adminhtml_Type extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct(){
       $this->_blockGroup = 'rma';
       $this->_controller = 'adminhtml_type';
       $this->_headerText = Mage::helper('adminhtml')->__('Type Manager');
       $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add Type');
       parent::__construct();
    }
}
