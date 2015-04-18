<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}

	$btnLabel = (isset($btnLabel) && ($btnLabel!='')) ?$btnLabel :'';
	
	$loggedUserId=isloginUser();
	
	
	 $loggedUserId=isloginUser();
	if($loggedUserId > 0){
		$sentCount = isRequestAlreadySent($loggedUserId,$productId);
		$countResult = $sentCount->id;
		} else {
			$countResult = 0;
			}
	
	$userInfo = showCaseUserDetails($loggedUserId,'frontend');
	$beforeOfferProduct=$this->lang->line('beforeContactmeIn');
	
		$creative=$userInfo['creative'];
		$associatedProfessional=$userInfo['associatedProfessional'];
		$enterprise=$userInfo['enterprise'];
		$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
		if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m');
		
		if($userInfo['userImage']!='') {
			 $userImage=$userInfo['userImage'];
	    }
	    //echo $userImage;
		$userImage=addThumbFolder($userImage,$suffix='_xxx',$thumbFolder ='thumb',$userDefaultImage);  	
		$userImage=getImage($userImage,$userDefaultImage);
				
	if($loggedUserId > 0){
		
		if($countResult > 0){
				$rateAll='rateAll';
				$alreadyRate=$this->lang->line('alreadySendReqShowCase');
				$functionOfferProduct="if(checkIsUserLogin('".$beforeOfferProduct."')){customAlert('".$alreadyRate."')}";
				$ref ='javascript:void(0)';
		} 
		else {		
		$msg = $this->lang->line('ownProductBuyReq');
		$ref = ($ownerId!=$loggedUserId) ? "javascript:void(0)" : "javascript:customAlert('".$msg."')";
		$offerProduct=$this->load->view('product_offer_popup',array('userId'=>$loggedUserId,'userFullName'=>@$userInfo['userFullName'],'userImage'=>@$userImage,'title'=>@$title,'isWorkProfile'=>$isWorkProfile,'productId'=>$productId,'ownerId'=>$ownerId), true);
		echo "<script>var offerProduct=".json_encode($offerProduct)."</script>";
		$functionOfferProduct="if(checkIsUserLogin('".$beforeOfferProduct."')){loadPopupData('popupBoxWp','popup_box',offerProduct)}";
	  }
	}
	else{
		$ref='javascript:void(0)';
		$functionOfferProduct="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeOfferProduct."')";
	}
	//if($ownerId!=$loggedUserId) {
		//$isShowCase= true;	?>
		<div class="mt15 Fright btn_share_wrapper">			
           <a onmousedown="mousedown_apply_btn(this)" onmouseup="mouseup_apply_btn(this)" class="Apply_big_btn" href="<?php echo $ref ?>" onclick="<?php echo $functionOfferProduct;?>"><?php echo $btnLabel ?></a>						 
		</div>
		<?php 
	//} ?>    
	<div class="clear"></div>
