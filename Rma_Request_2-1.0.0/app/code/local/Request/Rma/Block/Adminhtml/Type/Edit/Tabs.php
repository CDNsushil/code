<?php
class Request_Rma_Block_Adminhtml_Type_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('type_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('adminhtml')->__('Request Type Information'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('adminhtml')->__('Request Type Information'),
            'title'     => Mage::helper('adminhtml')->__('Request Type Information'),
            'content'   => $this->getLayout()->createBlock('rma/adminhtml_type_edit_tab_form')->toHtml(),
        ));
       
        return parent::_beforeToHtml();
    }
}
