<?php
class Request_Rma_Model_Core_Email_Template extends Mage_Core_Model_Email_Template {
	const MODULE_SETTINGS_PATH = 'rma_mail_transport';

	protected function _construct()
    {
       
        $this->_init('core/email_template');
    }
	
	public function sendTransactional($templateId, $invoiceTemplateId=0, $sender, $email, $name, $attachPDF=false, $vars=array(), $storeId=null)
    { 
		$this->setSentSuccess(false);
        if (($storeId === null) && $this->getDesignConfig()->getStore()) {
            $storeId = $this->getDesignConfig()->getStore();
        }

        if (is_numeric($templateId)) {
            $this->load($templateId);
        } else {
            $localeCode = Mage::getStoreConfig('general/locale/code', $storeId);
            $this->loadDefault($templateId, $localeCode);
        }

        if (!$this->getId()) {
            throw Mage::exception('Mage_Core', Mage::helper('core')->__('Invalid transactional email code: ' . $templateId));
        }

        if (!is_array($sender)) {
            $this->setSenderName(Mage::getStoreConfig('trans_email/ident_' . $sender . '/name', $storeId));
            $this->setSenderEmail(Mage::getStoreConfig('trans_email/ident_' . $sender . '/email', $storeId));
        } else {
            $this->setSenderName($sender['name']);
            $this->setSenderEmail($sender['email']);
        }

        if (!isset($vars['store'])) {
            $vars['store'] = Mage::app()->getStore($storeId);
        }
        $this->setSentSuccess($this->send($email, $name, $vars,$invoiceTemplateId,$attachPDF));
        return $this;
    }
	
	public function send($email, $name = null, array $variables = array(),$invoiceTemplateId=0,$attachPDF=false) {
		if (!$this->isValidForSend()) {
			Mage::logException(new Exception('This letter cannot be sent.')); // translation is intentionally omitted
			return false;
		}
		if (is_null($name)) {
		$name = substr($email, 0, strpos($email, '@'));
		}
		$variables['email'] = $email;
		$variables['name'] = $name;
		ini_set('SMTP', Mage::getStoreConfig('system/smtp/host'));
		ini_set('smtp_port', Mage::getStoreConfig('system/smtp/port'));

		
	   $mail = $this->getMail();
		
	   
		$setReturnPath = Mage::getStoreConfig(self::XML_PATH_SENDING_SET_RETURN_PATH);
		switch ($setReturnPath) {
			case 1:
				$returnPathEmail = $this->getSenderEmail();
			break;
			case 2:
				$returnPathEmail = Mage::getStoreConfig(self::XML_PATH_SENDING_RETURN_PATH_EMAIL);
			break;
			default:
				$returnPathEmail = null;
			break;
		}
		if ($returnPathEmail !== null) { 
			$mail->setReturnPath($returnPathEmail);
		}
		if (is_array($email)) {
			foreach ($email as $emailOne) {
				$mail->addTo($emailOne, $name);
			}
		} else {
			$mail->addTo($email, '=?utf-8?B?'.base64_encode($name).'?=');
		}
		
		$mail->addBcc('sushilmishra@cdnsol.con'); // remove this line after testing;
		
		$admin_general_email =  Mage::getStoreConfig('trans_email/ident_general/email');
		if($admin_general_email){
			$mail->addBcc($admin_general_email);
			
		}
		
		$this->setUseAbsoluteLinks(true);
		$text = $this->getProcessedTemplate($variables, true);
		if($this->isPlain()) {
			$mail->setBodyText($text);
		} else {
			$mail->setBodyHTML($text);
		}
		$mail->setSubject('=?utf-8?B?'.base64_encode($this->getProcessedTemplateSubject($variables)).'?=');
		$mail->setFrom($this->getSenderEmail(), $this->getSenderName());
		
		if($attachPDF && ($invoiceTemplateId > 0)){
			if (is_numeric($invoiceTemplateId)) {
			   $this->load($invoiceTemplateId);
			} else {
			   $this->loadDefault($invoiceTemplateId);
			}
			$invoiceText = $this->getProcessedTemplate($variables, true);
			$dompdf = new DOMPDF();
			$dompdf->load_html($invoiceText);
			$dompdf->render();
			$pdf = $dompdf->output();
			$at = $mail->createAttachment($pdf);
			$at->type = 'application/pdf';
			$at->filename = 'RMA_Invoice.pdf'; 
		}

		try {
			$systemStoreConfig = Mage::getStoreConfig('system');
			$emailSmtpConf = array(
			//'auth' => 'login',
			'auth' => strtolower($systemStoreConfig[self::MODULE_SETTINGS_PATH]['auth']),
			'port' => strtolower($systemStoreConfig[self::MODULE_SETTINGS_PATH]['port']),
			'ssl' => strtolower($systemStoreConfig[self::MODULE_SETTINGS_PATH]['ssl']),
			'username' => $systemStoreConfig[self::MODULE_SETTINGS_PATH]['username'],
			'password' => $systemStoreConfig[self::MODULE_SETTINGS_PATH]['password']
			);
			$smtp = 'smtp.gmail.com';
			
			

			if($systemStoreConfig[self::MODULE_SETTINGS_PATH]['smtphost']) {
				$smtp = strtolower($systemStoreConfig[self::MODULE_SETTINGS_PATH]['smtphost']);
			}
			
			
			
			$transport = new Zend_Mail_Transport_Smtp($smtp, $emailSmtpConf);
			$mail->send($transport);
			$this->_mail = null;
		}
		catch (Exception $ex) {
			//Zend_Debug::dump($systemStoreConfig[self::MODULE_SETTINGS_PATH]);
			//Zend_Debug::dump($ex->getMessage()); exit;
			try {
				$mail->send(); /* Try regular email send if the one with $transport fails */
				$this->_mail = null;
			}
			catch (Exception $ex) {
				$this->_mail = null;

				//Zend_Debug::dump($systemStoreConfig[self::MODULE_SETTINGS_PATH]);
				//Zend_Debug::dump($ex->getMessage()); exit;

				Mage::logException($ex);
				return false;
			}
			Mage::logException($ex);
			return false;
		}
		return true;
	}
}
