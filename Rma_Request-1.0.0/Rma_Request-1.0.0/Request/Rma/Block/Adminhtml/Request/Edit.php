<?php
/* class: Request_Rma_Block_Adminhtml_Request_Edit
 * path: RMA/Request/Block/Adminhtml/Request/Edit.php
 * Author: Sushilmishra@cdnsol.com
 */
class Request_Rma_Block_Adminhtml_Request_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
           
        $this->_objectId = 'id';
        $this->_blockGroup = 'rma';
        $this->_controller = 'adminhtml_request';
 
        //$this->_updateButton('save', 'label', Mage::helper('rma')->__('Save Request'));
        $this->_updateButton('delete', 'label', Mage::helper('rma')->__('Delete Request'));
        $this->_removeButton('save');
        $this->_removeButton('reset');
          
    }
 
    public function getHeaderText()
    { 
        if( Mage::registry('request_data') && Mage::registry('request_data')->getId() ) {
            return Mage::helper('rma')->__("RMA Request Information", $this->htmlEscape(Mage::registry('request_data')->getTitle()));
        } else {
            return Mage::helper('rma')->__('Add RMA Request');
        }
    }
}
