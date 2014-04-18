<?php
 
class Request_Rma_Block_Adminhtml_Type_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'rma';
        $this->_controller = 'adminhtml_type';
 
        $this->_updateButton('save', 'label', Mage::helper('adminhtml')->__('Save Type'));
        //$this->_updateButton('delete', 'label', Mage::helper('adminhtml')->__('Delete Type'));
         $this->_removeButton('delete'); 
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('type_data') && Mage::registry('type_data')->getId() ) {
            return Mage::helper('adminhtml')->__("Edit RMA Type '%s'", $this->htmlEscape(Mage::registry('type_data')->getTitle()));
        } else {
            return Mage::helper('adminhtml')->__('Add RMA Type');
        }
    }
}
