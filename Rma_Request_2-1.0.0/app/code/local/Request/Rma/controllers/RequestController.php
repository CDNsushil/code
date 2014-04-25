<?php 
/**
 * Request_Rma extension
 * Report front controller
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
class Request_Rma_RequestController extends Mage_Core_Controller_Front_Action {
	/**
 	 * default action
 	 * @access public
 	 * @return void
 	 * @author Tosif Qureshi
 	 */
 	public function indexAction() {
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		/* Load layout of rma form */
		$this->loadLayout();
		/* Set head values for rma listing */
		$head_block = $this->getLayout()->getBlock('head');
		
		if ($head_block) {
			$head_block->setTitle(Mage::getStoreConfig('rma/request/meta_title'));
			$head_block->setKeywords(Mage::getStoreConfig('rma/request/meta_keywords'));
			$head_block->setDescription(Mage::getStoreConfig('rma/request/meta_description'));
		}
		
		/* Render layout of rma listing */
		$this->renderLayout();
	}
	
	/**
	 * check user  is login or not
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	 public function isUserLogin() {
		/* Check if the customer is logged in or not */
		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
			return true;
		} else {
			/* Redirect to login page */
			$this->_redirect('customer/account/login'); 
		}
	 }
	
	/**
	 * rma form to select report type
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function rmaformAction() {
		
		/* Check if the customer is logged in or not */
		$this->isUserLogin();

		/* Get order id */
		$order_id = $this->getRequest()->getParam('order_id',0);
		if(!empty($order_id)) {
			/* Set order id */
			Mage::register('order_id',$order_id);
			/* Get rma id */
			$rma_id = $this->getRequest()->getParam('rma_id',0);
			/* Set order id */
			Mage::register('rma_id',$rma_id);
			/* Load layout of rma form */
			$this->loadLayout();
			/* Render layout of rma form */
			$this->renderLayout();
		} else {
			/* Redirect to rma page */
			$this->_redirect('rma/request');
		}
	}
	
	/**
	 * load rma type form after selection
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function rmaTypeFormAction() {
		
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		/* Set post values */
		Mage::register('rma_post_data', $this->getRequest()->getPost());
		/* Set rma report type title */
		$rma_type_title = Mage::helper('rma/request')->setRmaTypeTitle($this->getRequest()->getPost('rma_type'));
		/* Set order id */
		Mage::register('order_id',$this->getRequest()->getPost('order_id'));
		/* Set rma id */
		Mage::register('rma_id',$this->getRequest()->getPost('rma_id'));
		/* Get sku number from post */
		$sku_number = $this->getRequest()->getPost('sku_number');
		
		/* Get product item details */
		$product_item_data = Mage::helper('rma/request')->getProductItemData($this->getRequest()->getPost('order_id'));
		
		$product_data = array();
		$is_set_sku = false; //Set default sku status
		if(!empty($product_item_data) && is_array($product_item_data)) {
			for($i=0;$i<count($product_item_data);$i++) {
				if($product_item_data[$i]['product_sku']==$sku_number) {
					$product_data['product_id']   = $product_item_data[$i]['product_id'];
					$product_data['product_name'] = $product_item_data[$i]['product_name'];
					$is_set_sku = true;
				}
			}	
		}
		
		/* Set sku value and return massage */
		if($is_set_sku==true) {
			/* Set session value of sku */
			Mage::getSingleton('core/session')->setSkuNumber($sku_number);
		}  else {
			Mage::getSingleton('core/session')->addError('Enter a valid Sku number.');
			/* Set session value of sku as blank */
			Mage::getSingleton('core/session')->setSkuNumber('');
		}
		
		/* get record of rma sku if exist */
		$load_rma_sku =Mage::getModel('rma/items')->loadByRmaSku($sku_number,$this->getRequest()->getPost('rma_id'),$this->getRequest()->getPost('order_id'));
		if($load_rma_sku->getItem_id()) {
			/* Redirect to rma form page */
			Mage::getSingleton('core/session')->addError('You have already RMA for this product');
			$this->_redirect('rma/request/rmaform/order_id/'.$this->getRequest()->getPost('order_id'));
		}
		
		/* Set product data */
		Mage::register('product_data', $product_data);
		/* Load layout of rma report type form */
		$this->loadLayout();
		/* Render layout of rma type form */
		$this->renderLayout();
	}
	
	/**
	 * load rma edit type form
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function editRmaFormAction() {
		
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		/* Get rma id */
		$item_id = $this->getRequest()->getParam('item_id',0);
		if(!empty($item_id)) {
			/* Set item id */
			Mage::register('item_id',$item_id);	
			/* Load layout of rma edit type form */
			$this->loadLayout();
			/* Render layout of rma  edit type form */
			$this->renderLayout();
		} else {
			/* Redirect to rma page */
			$this->_redirect('rma/request');
		}
	}
	
	/**
	 * load detail page after rma reporting
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function rmaReportDetailAction() {
		
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		/* Check if the rma id is set or not */
		if(Mage::getSingleton('core/session')->getLastRmaId()) {
			/* Load layout of rma report forms */
			$this->loadLayout();
			$this->renderLayout();
		} else {
			$this->_redirect('rma/request');
		}
	}
	
	/**
 	 * view rma action
 	 * @access public
 	 * @return void
 	 * @author Tosif Qureshi
 	 */
	public function rmaViewAction() {
		
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		/* Get rma id */
		$rma_id = $this->getRequest()->getParam('id',0);
		if(!empty($rma_id)) {
			/* Set rma id */
			Mage::register('rma_id',$rma_id);
			/* Load layout of rma view */
			$this->loadLayout();
			/* Render layout of rma view */
			$this->renderLayout();
		} else {
			$this->_redirect('rma/request');
		}
	}
	
	/**
	 * save rma data - action
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function saveAction() {
		
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		if ($data = $this->getRequest()->getPost()) {
			if($this->getRequest()->getPost('rma_id')) {
				/* Set rma id */
				$rma_id = $this->getRequest()->getPost('rma_id');
				/* Insert data into rma item records */
				$insert_item = $this->saveRmaItem($rma_id,$data);
			} else {
				/* Get the customer data */
				$customer = Mage::getSingleton('customer/session')->getCustomer();
				/* Set post values for data insertion */
				$set_data = array('customer_id'    => $customer->Entity_id,
								  'order_id'       => $data['order_id']);
				/* Load module and add rma data for edit*/				 
				$rma_model = Mage::getModel('rma/request')->addData($set_data);
				/* Save post data of rma form */
				$rma_model->save();
				/* Insert data into rma item records */
				$insert_item = $this->saveRmaItem($rma_model->getId(),$data);
				/* Set rma id */
				$rma_id = $rma_model->getId();
			}
			
			if($insert_item == TRUE) {
				/* Set inserted rma id for detail page */
				Mage::getSingleton('core/session')->setLastRmaId($rma_id);
				/* Set sku number of rma for detail page */
				Mage::getSingleton('core/session')->setSkuNumber($data['sku_number']);
				/* Set success message after save */
				Mage::getSingleton('core/session')->addSuccess('You have successfully added Item on RMA');
				/* Redirect to rma detail grid. */
				$this->_redirect('rma/request/rmaReportDetail'); 
			} else {
				//if there is an error return to order
				Mage::getSingleton('core/session')->addError('Error during RMA report.');
				$this->_redirect('sales/order/history'); 
			}
		} else {
			$this->_redirect('rma/request');
		}    
	}
	
	/**
	 * save rma item records
	 * @access public
	 * @return void
	 */
	 public function saveRmaItem($rma_id=0,$rma_data='') {
		 
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		/* set default return status as false */ 
		$return = FALSE;
		if ($rma_data) {
			/* Get the customer data */
			$customer = Mage::getSingleton('customer/session')->getCustomer();
			/* change serial numbers to string */
			$serial_number = implode(',',$rma_data['serial_number']);
			/* Set post values for data insertion */
			$set_data = array('rma_id'         => $rma_id,
							  'product_id'     => $rma_data['product_id'],
							  'type_id'        => $rma_data['rma_type'],
							  'customer_id'    => $customer->Entity_id,
							  'reason_id'      => $rma_data['reason_id'],
							  'sku_number'     => $rma_data['sku_number'],
							  'invoice_number' => $rma_data['invoice_number'],
							  'descriptions'   => $rma_data['error_description'],
							  'serial_number'  => $serial_number);
			/* Load module and add rma data for edit*/				 
			$rma_items_model = Mage::getModel('rma/items')->addData($set_data);
			try {
				/* Save post data of rma form */
				$rma_items_model->save();
				$return = TRUE;
			} catch (Exception $e) {
				$return = FALSE;
			}	
		}
		return $return; 
	 }
	
	/**
	 * update rma data - action
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function editRmaAction() {
		
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		if ($data = $this->getRequest()->getPost()) {
			/* change serial numbers to string */
			$serial_number = implode(',',$data['serial_number']);
			/* Get the rma id */
			$rma_item_id = $data['rma_item_id'];
			/* Set values for update */
			$set_data = array('reason_id'      => $data['reason_id'],
							  'sku_number'     => $data['sku_number'],
							  'invoice_number' => $data['invoice_number'],
							  'descriptions'   => $data['error_description'],
							  'serial_number'  => $serial_number);
			/* Load module and add rma data for edit*/				 
			$rma_model = Mage::getModel('rma/items')->load($rma_item_id)->addData($set_data);
			
			try {
				$rma_model->setId($rma_item_id)->save();
				/* Set inserted rma id for detail page */
				Mage::getSingleton('core/session')->setLastRmaId($data['rma_id']);
				/* Set sku number of rma for detail page */
				Mage::getSingleton('core/session')->setSkuNumber($data['sku_number']);
				/* Set success message after save */
				Mage::getSingleton('core/session')->addSuccess('Successfully Updated RMA');
				/* Redirect to rma detail grid. */
				$this->_redirect('rma/request/rmaReportDetail'); 

			} catch (Exception $e) {
				//if there is an error return to edit
				Mage::getSingleton('core/session')->addError('Not Saved. Error:'.$e->getMessage());
				$this->_redirect('rma/request'); 
			}
		} else {
			$this->_redirect('rma/request');
		}   
	}
	
	/**
	 * view rma edit shipping form
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	 public function editShippingAddressAction() {
		 
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		/* Get order id */
		$order_id = $this->getRequest()->getParam('order_id',0);
		if(!empty($order_id)) {
			/* Set order id */
			Mage::register('order_id', $order_id);
			/* Load layout of rma view */
			$this->loadLayout();
			/* Render layout of rma view */
			$this->renderLayout();
		} else {
			$this->_redirect('rma/request');
		} 
	 }
	 
	 /**
	 * update rma shipping data - action
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function updateShippingAction() {
		
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		if ($data = $this->getRequest()->getPost()) {
			/* Get the shipping address id */
			$shipping_address_id = $data['address_id'];
			/* Set values for update */
			$set_data = array('firstname'    => $data['firstname'],
							  'lastname'     => $data['lastname'],
							  'company'      => $data['company'],
							  'street'       => $data['street'],
							  'city'     	 => $data['city'],
							  'telephone'    => $data['telephone'],
							  'country_id'   => $data['country_id']);
			/* Load module and add shipping data for edit */				 
			$address = Mage::getModel('sales/order_address')->load($shipping_address_id);
			$address->addData($set_data);
			try {
				$address->save();
				Mage::getSingleton('core/session')->addSuccess('Successfully Updated Shipping Address');
				/* Redirect to rma detail grid. */
				$this->_redirect('rma/request/rmaReportDetail'); 
			} catch (Exception $e) {
				//if there is an error return to edit
				Mage::getSingleton('core/session')->addError('Not Saved. Error:'.$e->getMessage());
				$this->_redirect('rma/request'); 
			}
		}
	}
	 
	 /**
	 * view rma edit billing form
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	 public function editBillingAddressAction() {
		 
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		/* Get order id */
		$order_id = $this->getRequest()->getParam('order_id');
		if(!empty($order_id)) {
			/* Set order id */
			Mage::register('order_id',$order_id);
			 
			/* Load layout of rma view */
			$this->loadLayout();
			/* Render layout of rma view */
			$this->renderLayout();
		} else {
			$this->_redirect('rma/request');
		}
	 }
	 
	 /**
	 * update rma billing data - action
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function updateBillingAction() {
		
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		if ($data = $this->getRequest()->getPost()) {
			/* Get the billing address id */
			$billing_address_id = $data['address_id'];
			/* Set values for update */
			$set_data = array('firstname'    => $data['firstname'],
							  'lastname'     => $data['lastname'],
							  'company'      => $data['company'],
							  'street'       => $data['street'],
							  'city'     	 => $data['city'],
							  'telephone'    => $data['telephone'],
							  'country_id'   => $data['country_id']);
			/* Load module and add billing data for edit */				 
			$address = Mage::getModel('sales/order_address')->load($billing_address_id);
			$address->addData($set_data);
			try {
				$address->save();
				Mage::getSingleton('core/session')->addSuccess('Successfully Updated Billing Address');
				/* Redirect to rma detail grid. */
				$this->_redirect('rma/request/rmaReportDetail'); 
			} catch (Exception $e) {
				//if there is an error return to edit
				Mage::getSingleton('core/session')->addError('Not Saved. Error:'.$e->getMessage());
				$this->_redirect('rma/request'); 
			}
		}
	}
	
	/**
	 * check product is exist on order or not
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	public function checkItemExistAction() {
		
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		/* get sku number */
		$sku_number = $this->getRequest()->getPost('sku_number');
		/* get rma id */
		$rma_id = $this->getRequest()->getPost('rma_id');
		/* get sku number */
		$order_id = $this->getRequest()->getPost('order_id');
		/* get record of rma sku if exist */
		$load_rma_sku =Mage::getModel('rma/items')->loadByRmaSku($sku_number,$rma_id,$order_id);
		$status = array('isExist'=> FALSE); //set exist status as true
		if($load_rma_sku->getItem_id()) {
			$status = array('isExist'=> TRUE); //set exist status as false
		}
		echo json_encode($status);
	}
	
	/**
	 * final submit the rma report
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	 public function submitRmaRequestAction() {
		 
		/* Check if the customer is logged in or not */
		$this->isUserLogin();
		if ($rma_id = $this->getRequest()->getPost('rma_id')) {
			/* Set values for update */
			$set_data = array('is_submitted' => 1,'is_email_sent' => 1);
			/* Load module and add rma data for edit */				 
			$rma_model = Mage::getModel('rma/request')->load($rma_id);
			$rma_model->addData($set_data);
			try {
				$rma_model->save();
				Mage::getSingleton('core/session')->addSuccess('Successfully Submitted your RMA');
				/* Get customer details */
				$customer = Mage::getSingleton('customer/session')->getCustomer();
				/* Set incremented rma id */
				$rma_id = $rma_id + 30000;
				/* Set admin general email */
				//$admin_general_email =  Mage::getStoreConfig('trans_email/ident_general/email');
				/* Set array of data set */
				$data = array('rmaId'=>$rma_id,
					'name'=>$customer->Firstname.' '.$customer->Lastname,
					'email'=>array($customer->Email),
					'emailTemplate'=>'Rma Request');
				
				if(!empty($rma_id)) {
					/* Send email to after rma */
					$this->sendRmaEmail($data);
				}
				/* Redirect to rma detail grid. */
				$this->_redirect('rma/request'); 
			} catch (Exception $e) {
				//if there is an error return to edit
				Mage::getSingleton('core/session')->addError('Not Saved. Error:'.$e->getMessage());
				$this->_redirect('rma/request'); 
			}
		} else {
			//if there is an error return to rma
			Mage::getSingleton('core/session')->addError('Error during RMA Request');
			$this->_redirect('rma/request'); 
		}
	 }
	 
	 /**
	 * send email after reporting rma
	 * @access private
	 * @return void
	 * @author Tosif Qureshi
	 */
	private function sendRmaEmail($data) {
		
		if(isset($data) && is_array($data) && count($data) > 0) {
			
			// get the email template by name
			$template = Mage::getModel('core/email_template') ->loadByCode($data['emailTemplate'])->getTemplateId();
				
			// create the sender array containing the store name and email
			$sender  = array(
				'name' => Mage::getStoreConfig('trans_email/ident_support/name', Mage::app()->getStore()->getId()),
				'email' => Mage::getStoreConfig('trans_email/ident_support/email', Mage::app()->getStore()->getId())
			);
			
			$vars = Array( 'rmaId'=> $data['rmaId'], 'name' => $data['name'] );
			// send the email using the default store
			Mage::getModel('core/email_template')->sendTransactional($template, $sender, $data['email'], $data['name'], $vars);
		}
	}
	
}
