<?php

class Request_Rma_Block_Adminhtml_Request_Edit_Tab_Customer extends Mage_Core_Block_Template
{
  	protected $_customer;

    protected $_customerLog;
   
   
   public function __construct()
    {
        parent::__construct();
        $this->setTemplate('request_rma/request/customer.phtml');
    }
    
    public function getCustomer()
    {
        $id = $this->getRequest()->getParam('id');
		$requestModel = Mage::getModel('rma/items')->load($id);
		$Customer_id = $requestModel->getCustomer_id();
		$this->_customer = Mage::getModel('customer/customer')->load($Customer_id);
        return $this->_customer;
    }
    public function getFirstname()
    {
        return $this->getCustomer()->getFirstname();
    }
    public function getLastname()
    {
        return $this->getCustomer()->getLastname();
    }
    public function getEmail()
    {
        return $this->getCustomer()->getEmail();
    }
    public function getGroupName()
    {
        if ($groupId = $this->getCustomer()->getGroupId()) {
            return Mage::getModel('customer/group')
                ->load($groupId)
                ->getCustomerGroupCode();
        }
    }

    /**
     * Load Customer Log model
     *
     * @return Mage_Log_Model_Customer
     */
    public function getCustomerLog()
    {
        if (!$this->_customerLog) {
            $this->_customerLog = Mage::getModel('log/customer')
                ->loadByCustomer($this->getCustomer()->getId());
        }
        return $this->_customerLog;
    }

    /**
     * Get customer creation date
     *
     * @return string
     */
    public function getCreateDate()
    {
        return Mage::helper('core')->formatDate($this->getCustomer()->getCreatedAtTimestamp(),
            Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM, true);
    }

    public function getStoreCreateDate()
    {
        $date = Mage::app()->getLocale()->storeDate(
            $this->getCustomer()->getStoreId(),
            $this->getCustomer()->getCreatedAtTimestamp(),
            true
        );
        return $this->formatDate($date, Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM, true);
    }

    public function getStoreCreateDateTimezone()
    {
        return Mage::app()->getStore($this->getCustomer()->getStoreId())
            ->getConfig(Mage_Core_Model_Locale::XML_PATH_DEFAULT_TIMEZONE);
    }

    /**
     * Get customer last login date
     *
     * @return string
     */
    public function getLastLoginDate()
    {
        $date = $this->getCustomerLog()->getLoginAtTimestamp();
        if ($date) {
            return Mage::helper('core')->formatDate($date, Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM, true);
        }
        return Mage::helper('customer')->__('Never');
    }

    public function getStoreLastLoginDate()
    {
        if ($date = $this->getCustomerLog()->getLoginAtTimestamp()) {
            $date = Mage::app()->getLocale()->storeDate(
                $this->getCustomer()->getStoreId(),
                $date,
                true
            );
            return $this->formatDate($date, Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM, true);
        }
        return Mage::helper('customer')->__('Never');
    }

    public function getStoreLastLoginDateTimezone()
    {
        return Mage::app()->getStore($this->getCustomer()->getStoreId())
            ->getConfig(Mage_Core_Model_Locale::XML_PATH_DEFAULT_TIMEZONE);
    }

    public function getCurrentStatus()
    {
        $log = $this->getCustomerLog();
        if ($log->getLogoutAt() ||
            strtotime(now())-strtotime($log->getLastVisitAt())>Mage_Log_Model_Visitor::getOnlineMinutesInterval()*60) {
            return Mage::helper('customer')->__('Offline');
        }
        return Mage::helper('customer')->__('Online');
    }

    public function getIsConfirmedStatus()
    {
        $this->getCustomer();
        if (!$this->_customer->getConfirmation()) {
            return Mage::helper('customer')->__('Confirmed');
        }
        if ($this->_customer->isConfirmationRequired()) {
            return Mage::helper('customer')->__('Not confirmed, cannot login');
        }
        return Mage::helper('customer')->__('Not confirmed, can login');
    }

    public function getCreatedInStore()
    {
        return Mage::app()->getStore($this->getCustomer()->getStoreId())->getName();
    }

    public function getStoreId()
    {
        return $this->getCustomer()->getStoreId();
    }

    public function getBillingAddressHtml()
    {
        $html = '';
        if ($address = $this->getCustomer()->getPrimaryBillingAddress()) {
            $html = $address->format('html');
        }
        else {
            $html = Mage::helper('customer')->__('The customer does not have default billing address.');
        }
        return $html;
    }

    public function getAccordionHtml()
    {
        return $this->getChildHtml('accordion');
    }

    public function getSalesHtml()
    {
        return $this->getChildHtml('sales');
    }

    public function getTabLabel()
    {
        return Mage::helper('customer')->__('Customer View');
    }

    public function getTabTitle()
    {
        return Mage::helper('customer')->__('Customer View');
    }

    public function canShowTab()
    {
        if (Mage::registry('current_customer')->getId()) {
            return true;
        }
        return false;
    }

    public function isHidden()
    {
        if (Mage::registry('current_customer')->getId()) {
            return false;
        }
        return true;
    }
   
    protected function _toHtml()
    {
		return parent::_toHtml();
     }
 }
