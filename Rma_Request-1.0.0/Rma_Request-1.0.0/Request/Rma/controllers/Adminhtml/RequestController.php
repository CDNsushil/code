<?php  
class Request_Rma_Adminhtml_RequestController extends Mage_Adminhtml_Controller_Action
{
 
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('rma/Request')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Request Manager'), Mage::helper('adminhtml')->__('Request Manager'));
        return $this;
    }   
   
    public function indexAction() {
        $this->_initAction();       
        $this->_addContent($this->getLayout()->createBlock('rma/adminhtml_request'));
        $this->renderLayout();
    }
 
	/**
     * Request grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('rma/adminhtml_request_grid')->toHtml()
        );
    }
    
    public function editAction(){
		
		
        $itemId     = $this->getRequest()->getParam('id');
        $requestModel  = Mage::getModel('rma/items')->load($itemId);
	
        if ($requestModel->getId() || $itemId == 0) {
 
            Mage::register('request_data', $requestModel);
 
 
            $this->loadLayout();
            $this->_setActiveMenu('rma/request');
        
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Request Manager'), Mage::helper('adminhtml')->__('Request Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Request'), Mage::helper('adminhtml')->__('Request'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            
            $this->_addContent($this->getLayout()->createBlock('rma/adminhtml_request_edit'))
                 ->_addLeft($this->getLayout()->createBlock('rma/adminhtml_request_edit_tabs'));
               
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('rma')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
   
    public function newAction()
    { 
        $this->_forward('edit');
    }
    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $requestModel = Mage::getModel('rma/items');
               
                $requestModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                   
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Request was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
    
    public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            try {
                $data['id'] = $this->getRequest()->getParam('id');
				$data['status'] = $this->getRequest()->getParam('status');
				$data['customer_id'] = $this->getRequest()->getParam('customer_id');
				$this->saveStatus($data);
				
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setRequestData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
   public function statusAction()
    {
		$data['id'] = $this->getRequest()->getParam('id');
		$data['status'] = $this->getRequest()->getParam('status');
		$data['customer_id'] = $this->getRequest()->getParam('cid');
		$this->saveStatus($data);
	}
	
	private function saveStatus($saveData)
    { 
		if(isset($saveData['id']) && $saveData['id'] > 0 && isset($saveData['status']) && $saveData['status'] > 0 && isset($saveData['customer_id']) && $saveData['customer_id'] > 0){
			
				$id = $saveData['id'];
				$customer_id = $saveData['customer_id'];
				$status = $saveData['status'];
				$statusString=($status==1)?'Approved':'Denied';
				
				$requestModel = Mage::getModel('rma/items');
				$requestModel->setItemId($saveData['id'])->setStatus($saveData['status'])->save();
                    
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Request was successfully '.$statusString));
                Mage::getSingleton('adminhtml/session')->setRequestData(false);
				
				if( is_numeric($id) && ($id > 0)  && is_numeric($customer_id) && ($customer_id > 0)){
					$mailFlag=true;
					$invoiceTemplate='';
					$attachPDF=false;
					switch ($status) {
						case 1: //Approved
							$emailTemplate='RMA Confirmation';
							$invoiceTemplate='RMA Invoice';
							$attachPDF=true;
						break;
						case 2: //Denied
							$emailTemplate='RMA Denied';
						break;
						default:
							$returnPathEmail = null;
							$mailFlag=false;
						break;
					}
					
					if($mailFlag){
						$data = array(
							'rmaId'=>$id,
							'customer_id'=>$customer_id,
							'emailTemplate'=>$emailTemplate,
							'invoiceTemplate'=>$invoiceTemplate,
							'attachPDF'=>$attachPDF
						);
						
						$this->prepareMailData($data);
					}
				}
				
                $this->_redirect('*/*/');
                return;
			
		}
	}
   
    private function prepareMailData($data=array()){
		
		$customer = Mage::getModel('customer/customer')->load($data['customer_id']);
		if($customer){
			$firstname = $customer->getFirstname();
			$lastname = $customer->getLastname();
			$email = $customer->getEmail();
			//$email = 'sushilmishra@cdnsol.com';
			if($email && !empty($email)){
				$data['name'] = $firstname;
				$data['fullName'] = $firstname.' '.$lastname;;
				$data['email'] = $email;
				
				if(!empty($data['invoiceTemplate']) && ($data['invoiceTemplate']!='') && ($data['invoiceTemplate']!=null)){
					$storeInformation = Mage::getStoreConfig('general/store_information');
					
					/*$billingAddress = '';
					if ($address = $customer->getPrimaryBillingAddress()) {
						$billingAddress = $address->format('html');
					}*/
					
					$rma_item_data = Mage::getModel('rma/request')->getRmaItemDetails($data['rmaId']);
					
					
					
					if(!$rma_item_data){
						return false;
					}
					$rmaDdata = $rma_item_data->getData();
					
					
					$rmaDdata=$rmaDdata[0];
					
					
					//$product = Mage::getModel('catalog/product')->loadByAttribute('sku',$rmaDdata['sku_number']);
					//$productName= $product->getName();
					
					$order = Mage::getModel('sales/order')->load($rmaDdata['order_id']);
					
					
					$invoiceId="";
					if ($order->hasInvoices()) {
						$invIncrementIDs = array();
						foreach ($order->getInvoiceCollection() as $inv) {
							$invIncrementIDs[] = $inv->getIncrementId();
						//other invoice details...
						} Mage::log($invIncrementIDs);
						$count=(count($invIncrementIDs)-1);
						$invoiceId=$invIncrementIDs[$count] ;
					}else{
					}
					
					$billingAddress = $order->getBillingAddress()->getFormated(true);
					$shippingAddress = $order->getShippingAddress()->getFormated(true);
					
						$price=$rowTotal=number_format(0, 2);
						$itemDescription='';
						foreach($order->getAllItems() as $item){
							if($rmaDdata['sku_number'] ==  $item->sku){
								$productId = $item->product_id;
								$sku = $item->sku;
								$qty = $item->getQtyOrdered()*1;
								$product = $item->getName();
								$OriginalPrice = number_format($item->getOriginalPrice(), 2);
								$price = number_format($item->getPrice(), 2);
								$rowTotal = number_format($item->getRowTotal(), 2);
								$subtotal = number_format($item->getSubTotal(), 2);
								$discountAmount = number_format($item->getDiscountAmount(), 2);
								$shippingAmount = number_format($item->getShippingAmount(), 2);
								$taxAmount = number_format($item->getTaxAmount(), 2);
								$taxPercent = $item->getTaxPercent();
								$GrandTotal= number_format($item->getGrandTotal(), 2);
								$itemDescription=$product.'<br>Regarding Invoice no: '.$invoiceId.' Requisition no.: MKJ';
							}
						}
					
					 
					//Mage::getModel('customer/address')->load($data['customer_id']);
					
					$data['rmaNumber'] = ($data['rmaId'] + 30000);
					$data['storeName'] = $storeInformation['name'];
					$data['storeAddress'] = $storeInformation['address'];
					$data['fax'] = '';
					$data['currentDate'] = date('d-m-Y');
					$data['barcodeImage'] = '<img src="'.Mage::helper('rma/request')->barcode($data['rmaNumber']).'">';
					$data['returnType'] = 'defect';
					$data['itemDescription'] = $itemDescription;
					$data['qty'] = $qty;
					$data['price'] = $price;
					$data['totalPrice'] = $rowTotal;
					$data['errorDescription'] = $rmaDdata['descriptions'];
					$data['shippingAddress'] = $shippingAddress;
					$data['billingAddress'] = $billingAddress;
					
					$invoiceTemplateId = Mage::getModel('core/email_template') ->loadByCode($data['invoiceTemplate'])->getTemplateId();
				}
				
				$this->sendMail($data);
			}
		}
	}
   
   
    
    private function sendMail($data){
		if(isset($data) && is_array($data) && count($data) > 0){
			// get the email template by name
			$mailTemplateId = Mage::getModel('core/email_template') ->loadByCode($data['emailTemplate'])->getTemplateId();
			
			if(!empty($data['invoiceTemplate']) && ($data['invoiceTemplate']!='') && ($data['invoiceTemplate']!=null)){
				$invoiceTemplateId = Mage::getModel('core/email_template') ->loadByCode($data['invoiceTemplate'])->getTemplateId();
			}else{
				$invoiceTemplateId = 0;
				$data['attachPDF'] = false;
			}
					
			// create the sender array containing the store name and email
			$sender  = array(
				'name' => Mage::getStoreConfig('trans_email/ident_support/name', Mage::app()->getStore()->getId()),
				'email' => Mage::getStoreConfig('trans_email/ident_support/email', Mage::app()->getStore()->getId())
			);
			
			// create the order object based on the orders ID, which was gathered previously
			//$order = Mage::getModel('sales/order')->load($order_id);

			
			// send the email using the default store
			Mage::getModel('core/email_template')->sendTransactional($mailTemplateId, $invoiceTemplateId, $sender, $data['email'], $data['name'],$data['attachPDF'],$data);
		
		}
	}

}
