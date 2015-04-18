<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	// This popup for tmail unread message notification popup
	$isLoginUser=isLoginUser();
	if(isset($isLoginUser) && $isLoginUser > 0 ){
		
		if($this->session->userdata('isShowPopup'))
		{
			$this->session->set_userdata('isShowPopup','no');
		}else
		{
			$this->session->set_userdata('isShowPopup','yes');
		}
		
		if($this->session->userdata('isShowPopup')=="yes")
		{
			$getCount = Modules::run("common/getUserTmail",'getCount');
			if($getCount > 0)
			{ ?>
			<script>
				openLightBox('popupBoxWp','popup_box','/common/getUserTmail','');
			</script>
			<?php
			}
			$this->session->set_userdata('isShowPopup','no');
		}
	}
?>
