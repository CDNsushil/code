<?php
 
class Request_Rma_Block_Adminhtml_Type_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('type_form', array('legend'=>Mage::helper('adminhtml')->__('Type Information')));
       
        $fieldset->addField('type', 'text', array(
            'label'     => Mage::helper('adminhtml')->__('Type'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'type',
        ));
 
        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('adminhtml')->__('Status'),
            'name'      => 'is_active',
            'values'    => array(
               array(
                    'value'     => 1,
                    'label'     => Mage::helper('adminhtml')->__('Enable'),
                ),
			   array(
					'value'     => 0,
					'label'     => Mage::helper('adminhtml')->__('Disable'),
				),
            ),
        ));
       
        if ( Mage::getSingleton('adminhtml/session')->getTypeData() ) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getTypeData());
            Mage::getSingleton('adminhtml/session')->setTypeData(null);
        } elseif ( Mage::registry('type_data') ) {
            $form->setValues(Mage::registry('type_data')->getData());
        }
        return parent::_prepareForm();
    }
}
