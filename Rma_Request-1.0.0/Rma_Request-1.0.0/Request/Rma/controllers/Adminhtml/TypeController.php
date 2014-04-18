<?php
 
/* */
class Request_Rma_Adminhtml_TypeController extends Mage_Adminhtml_Controller_Action
{
 
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('rma/Type')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Request Type'), Mage::helper('adminhtml')->__('Request Type'));
        return $this;
    }   
   
    public function indexAction() {
        
        $this->_initAction();   
        $this->_addContent($this->getLayout()->createBlock('rma/adminhtml_type'));
        $this->renderLayout();
         
    }
 
	/**
     * Type grid for AJAX request.
     * Sort and filter type for example.
     */
     
    public function gridAction()
    {
      
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('rma/adminhtml_type_grid')->toHtml()
        );
    }
    
    public function newAction()
    { 
        $this->_forward('edit');
    }
    
    public function editAction(){  
        $typeId     = $this->getRequest()->getParam('id');
        $typeModel  = Mage::getModel('rma/type')->load($typeId);
 
        if ($typeModel->getId() || $typeId == 0) {
 
            Mage::register('type_data', $typeModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('request/type');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Type Manager'), Mage::helper('adminhtml')->__('Type Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Type'), Mage::helper('adminhtml')->__('Type'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('rma/adminhtml_type_edit'))
                 ->_addLeft($this->getLayout()->createBlock('rma/adminhtml_type_edit_tabs'));
               
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
                $typeModel = Mage::getModel('rma/type');
               
                $typeModel->setId($this->getRequest()->getParam('id'))
                    ->setType($postData['type'])
                    ->setIs_active($postData['is_active'])
                    ->save();
               
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Type was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setTypeData(false);
 
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setTypeData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
    
}
