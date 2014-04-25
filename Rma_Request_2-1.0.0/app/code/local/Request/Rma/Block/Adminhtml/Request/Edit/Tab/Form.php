<?php
 
class Request_Rma_Block_Adminhtml_Request_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{ 
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('request_form', array('legend'=>Mage::helper('rma')->__('Request Information')));
       
        $fieldset->addField('customer_id', 'hidden', array(
            'name'      => 'customer_id',
        ));
        
        $fieldset->addField('sku_number', 'text', array(
            'label'     => Mage::helper('rma')->__('SkU Number'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'sku_number',
            'disabled'=>true
        ));
        
        $fieldset->addField('serial_number', 'text', array(
            'label'     => Mage::helper('rma')->__('Serial Number'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'serial_number',
            'disabled'=>true
        ));
 
        
       
        $fieldset->addField('descriptions', 'editor', array(
            'name'      => 'descriptions',
            'label'     => Mage::helper('rma')->__('Descriptions'),
            'title'     => Mage::helper('rma')->__('Descriptions'),
            'style'     => 'width:97%; height:100px;',
            'wysiwyg'   => false,
            'disabled'=>true,
            'required'  => true,
        ));
        
         $fieldset->addField('created_at', 'text', array(
            'label'     => Mage::helper('rma')->__('Date'),
            'class'     => 'required-entry',
            'name'      => 'created',
            'type'      => 'date',
            'disabled'=>true
        ));
        
        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('rma')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('rma')->__('Pending'),
                ),
 
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('rma')->__('Approved'),
                ),
                 array(
                    'value'     => 2,
                    'label'     => Mage::helper('rma')->__('Denied')
                ),
            ),
        ));
       
        if ( Mage::getSingleton('adminhtml/session')->getRequestData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getRequestData());
            Mage::getSingleton('adminhtml/session')->setRequestData(null);
        } elseif ( Mage::registry('request_data') ) {
            $form->setValues(Mage::registry('request_data')->getData());
        }
        return parent::_prepareForm();
    }
}
