<?php
 
class Request_Rma_Adminhtml_ReasonController extends Mage_Adminhtml_Controller_Action
{
 
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('rma/Reason')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Request Reason'), Mage::helper('adminhtml')->__('Request Reason'));
        return $this;
    }   
   
    public function indexAction() {
        
        $this->_initAction();   
        $this->_addContent($this->getLayout()->createBlock('rma/adminhtml_reason'));
        $this->renderLayout();
         
    }
 
	/**
     * Reason grid for AJAX request.
     * Sort and filter reason for example.
     */
     
    public function gridAction()
    {
      
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('rma/adminhtml_reason_grid')->toHtml());
    }
    
    public function newAction()
    { 
        $this->_forward('edit');
    }
    
    public function editAction(){  
        $reasonId     = $this->getRequest()->getParam('id');
        $reasonModel  = Mage::getModel('rma/reason')->load($reasonId);
 
        if ($reasonModel->getId() || $reasonId == 0) {
 
            Mage::register('reason_data', $reasonModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('rma/reason');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Reason Manager'), Mage::helper('adminhtml')->__('Reason Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Reason'), Mage::helper('adminhtml')->__('Reason'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('rma/adminhtml_reason_edit'))
                 ->_addLeft($this->getLayout()->createBlock('rma/adminhtml_reason_edit_tabs'));
               
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
    
    public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                $reasonModel = Mage::getModel('rma/reason');
               
                $reasonModel->setId($this->getRequest()->getParam('id'))
                    ->setReason($postData['reason'])
                    ->setIs_active($postData['is_active'])
                    ->save();
               
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Reason was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setReasonData(false);
 
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setReasonData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
    
}
