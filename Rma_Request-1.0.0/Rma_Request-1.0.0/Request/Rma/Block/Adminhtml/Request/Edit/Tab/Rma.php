<?php

class Request_Rma_Block_Adminhtml_Request_Edit_Tab_Rma extends Mage_Core_Block_Template
{
  	protected $_customer;
    protected $_customerLog;
   
   
   public function __construct(){
        parent::__construct();
        
        $data=$this->rmaInformation();
        $this->assign('data', $data);
        $this->setTemplate('request_rma/request/rma.phtml');
    }
    
    public function rmaInformation()
    {
        $id = $this->getRequest()->getParam('id');
        $rma_item_data = Mage::getModel('rma/request')->getRmaRequestDetails($id);
        $data = $rma_item_data->getData();
        $data=isset($data[0])?$data[0]:$data;
        return $data;
    }
    
    public function getTabLabel()
    {
        return Mage::helper('rma')->__('RMA Request Information');
    }

    public function getTabTitle()
    {
        return Mage::helper('rma')->__('RMA Request Information');
    }

    public function canShowTab()
    {
        if (Mage::registry('current_rma')->getId()) {
            return true;
        }
        return false;
    }

    public function isHidden()
    {
        if (Mage::registry('current_rma')->getId()) {
            return false;
        }
        return true;
    }
   
    protected function _toHtml()
    {
		return parent::_toHtml();
     }
 }
