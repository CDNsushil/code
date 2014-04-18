 <?php

class Request_Rma_Block_Adminhtml_Renderer_Date extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    { 
          $purchaceDate=$row->getData($this->getColumn()->getIndex());
          $image=Mage::helper('rma/request')->checkDateWithinYear($purchaceDate);
          return '<img src="'.$this->getSkinUrl($image).'" alt="">';
    }
    
}

?> 
