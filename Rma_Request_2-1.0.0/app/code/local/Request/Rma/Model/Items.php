<?php
/**
 * Request_Rma extension
 * Item model
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
class Request_Rma_Model_Items extends Mage_Core_Model_Abstract
{ 
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
    public function _construct() {
	    parent::_construct();
	    
       $this->_init('rma/items');
       
    }
    
    /**
	 * get product sku data 
	 * @access public
	 * @param Reports_Rma_Model_Item $sku_number,$rma_id,$order_id
	 * @return Reports_Rma_Model_Resource_Item_Collection
	 * @author Tosif Qureshi
	 */
    public function loadByRmaSku($sku_number,$rma_id,$order_id)
    {
		
        $data= $this->_getResource()->loadByRmaSku($sku_number,$rma_id,$order_id);
        $this->setData($data);
         return $this;
    }
    
     /**
	 * get data as per loaded attribute
	 * @access public
	 * @param Reports_Rma_Model_Item $attribute, $value, $additionalAttributes
	 * @return Reports_Rma_Model_Resource_Item_Collection
	 * @author Tosif Qureshi
	 */
    public function loadByAttribute($attribute, $value, $additionalAttributes='*')
    {
        $collection = $this->getResourceCollection()
            ->addFieldToSelect($additionalAttributes)
            ->addFieldToFilter($attribute, $value);
		
        foreach ($collection as $object) {
            return $object;
        }
        return false;
    }
}
