<?php
class Request_Rma_Block_Adminhtml_Reason_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('reason_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('adminhtml')->__('Request Reason Information'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('adminhtml')->__('Request Reason Information'),
            'title'     => Mage::helper('adminhtml')->__('Request Reason Information'),
            'content'   => $this->getLayout()->createBlock('rma/adminhtml_reason_edit_tab_form')->toHtml(),
        ));
       
        return parent::_beforeToHtml();
    }
}
