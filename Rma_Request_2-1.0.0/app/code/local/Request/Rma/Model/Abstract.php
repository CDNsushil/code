 <?php

abstract class Request_Rma_Model_Abstract extends Mage_Core_Model_Abstract
{
    public function loadByAttribute($attribute, $value, $additionalAttributes='*') {
        $collection = $this->getResourceCollection()
            ->addFieldToSelect($additionalAttributes)
            ->addFieldToFilter($attribute, $value);

        foreach ($collection as $object) {
            return $object;
        }
        return false;
    }

    

} 
