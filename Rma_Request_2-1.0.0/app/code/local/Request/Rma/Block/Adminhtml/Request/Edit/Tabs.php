<?php
class Request_Rma_Block_Adminhtml_Request_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('request_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('rma')->__('Request Information'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('rma')->__('Request Information'),
            'title'     => Mage::helper('rma')->__('Request Information'),
            'content'   => $this->getLayout()->createBlock('rma/adminhtml_request_edit_tab_rma')->toHtml(),
        ));
        
        $this->addTab('customer', array(
            'label'     => Mage::helper('rma')->__('Customer Details'),
            'title'     => Mage::helper('rma')->__('Customer Details'),
            'content'   => $this->getLayout()->createBlock('rma/adminhtml_request_edit_tab_customer')->toHtml(),
        ));
        
        $this->addTab('orders', array(
            'label'     => Mage::helper('rma')->__('Order Details'),
            'title'     => Mage::helper('rma')->__('Order Details'),
            'content'   => $this->getLayout()->createBlock('rma/adminhtml_request_edit_tab_order')->toHtml(),
        ));
        
       return parent::_beforeToHtml();
    }
}



