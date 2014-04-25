<?php
 
class Request_Rma_Block_Adminhtml_Reason_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'rma';
        $this->_controller = 'adminhtml_reason';
 
        $this->_updateButton('save', 'label', Mage::helper('adminhtml')->__('Save Reason'));
        //$this->_updateButton('delete', 'label', Mage::helper('adminhtml')->__('Delete Reason'));
         $this->_removeButton('delete'); 
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('reason_data') && Mage::registry('reason_data')->getId() ) {
            return Mage::helper('adminhtml')->__("Edit RMA Reason '%s'", $this->htmlEscape(Mage::registry('reason_data')->getTitle()));
        } else {
            return Mage::helper('adminhtml')->__('Add RMA Reason');
        }
    }
}
