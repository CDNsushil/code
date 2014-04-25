 <?php

class Request_Rma_Block_Adminhtml_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
          
         //$link= Mage::helper('adminhtml')->getUrl('adminhtml/catalog_product/edit/') .'id/$entity_id';
    
		 $getData = $row->getData();
		 $item_id=$getData['item_id'];
		 $customer_id=$getData['customer_id'];
		 
		 $link= Mage::helper('adminhtml')->getUrl('adminhtml/request/status/') ."id/$item_id/cid/$customer_id/status/";  
        
          $status=$row->getData($this->getColumn()->getIndex());
          $statusLink=Mage::helper('rma/request')->getStatusLink($status, $link);
          return $statusLink;
    }
}

?> 


