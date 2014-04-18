<?php
 
class Request_Rma_Block_Adminhtml_Reason_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('reason_form', array('legend'=>Mage::helper('adminhtml')->__('Reason Information')));
       
        $fieldset->addField('reason', 'text', array(
            'label'     => Mage::helper('adminhtml')->__('Reason'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'reason',
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
       
        if ( Mage::getSingleton('adminhtml/session')->getReasonData() ) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getReasonData());
            Mage::getSingleton('adminhtml/session')->setReasonData(null);
        } elseif ( Mage::registry('reason_data') ) {
            $form->setValues(Mage::registry('reason_data')->getData());
        }
        return parent::_prepareForm();
    }
}
