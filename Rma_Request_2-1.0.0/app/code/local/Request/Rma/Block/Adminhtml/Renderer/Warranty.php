 <?php

class Request_Rma_Block_Adminhtml_Renderer_Warranty extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
		 $getData = $row->getData();
		 $purchaceDate=$getData['pDate'];
		 $warranty_period=$getData['warranty_period'];
		 $image=Mage::helper('rma/request')->checkWarranty_period($purchaceDate,$warranty_period);
         return '<img src="'.$this->getSkinUrl($image).'" alt="">';
    }
}

?> 


