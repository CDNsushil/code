<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}
	$workType = (isset($workType) && ($workType!='')) ?$workType :'';
	$workLabel = ($workType=='offered') ? $this->lang->line('applyNOW') : $this->lang->line('requestWorkProfileRcv'); 
	$loggedUserId=isloginUser();
	$userInfo = showCaseUserDetails($loggedUserId,'frontend');
	$beforeContactmeIn=$this->lang->line('beforeContactmeIn');
	
	if($loggedUserId > 0){
		
		$where = array(
					'tdsUid'=>$loggedUserId,
					'workId'=>$workId						
				);
				
		$countResult=countResult('WorkApplication',$where);		
		if($countResult > 0){
			$rateAll='rateAll';
			$alreadyRate=$this->lang->line('alreadySendReqShowCase');
			$functionApplyNow="if(checkIsUserLogin('".$beforeContactmeIn."')){customAlert('".$alreadyRate."')}";
			$ref ='javascript:void(0)';
		}else {	
			$msg = $this->lang->line('applyNowMsg');
			$ref = ($senderId!=$loggedUserId) ? "javascript:void(0)" : "javascript:customAlert('".$msg."')";
			
			$userDefaultImage=($userInfo['creative']=='t')?$this->config->item('defaultCreativeImg'):($userInfo['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg'):$this->config->item('defaultEnterpriseImg'));
			if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m');
			$userTemplateThumbImage = addThumbFolder($userInfo['userImage'],'_m');	
			$userImage = getImage($userTemplateThumbImage,$userDefaultImage);
			
			$applyNow=$this->load->view('common/contactme_showcase',array('userId'=>$loggedUserId,'userFullName'=>@$userInfo['userFullName'],'userImage'=>@$userImage,'title'=>@$title,'isWorkProfile'=>$isWorkProfile,'workId'=>$workId,'senderId'=>$senderId), true);
			echo "<script>var applyOnWork=".json_encode($applyNow)."</script>";
			$functionApplyNow="if(checkIsUserLogin('".$beforeContactmeIn."')){loadPopupData('popupBoxWp','popup_box',applyOnWork)}";
			
			$loggedUserNavigations=userNavigations($loggedUserId,true, array('enterprises','associatedprofessionals','creatives'));
			if(isset($loggedUserNavigations) && is_array($loggedUserNavigations) && count($loggedUserNavigations)){ 
			}else{
				$create_showcase_popup=$this->load->view('dashboard/create_showcase_popup','',true);
				$create_showcase_popup=json_encode($create_showcase_popup);
				echo '<script>var create_showcase_popup='.$create_showcase_popup.';</script>';
				$href="javascript:loadPopupData('popupBoxWp','popup_box',create_showcase_popup);";
				$functionApplyNow = $href;
			}
		}
		
	} else{
		$ref ='javascript:void(0)';
		$functionApplyNow="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeContactmeIn."')";
	}
	
	if($senderId!=$loggedUserId) {
		$isShowCase= true;	} ?>
		<div class="mt15 Fright">
			 <a onmousedown="mousedown_apply_btn(this)" onmouseup="mouseup_apply_btn(this)" class="Apply_big_btn dash_link_hover" href="<?php echo $ref ?>" onclick="<?php echo $functionApplyNow;?>">
			 	 <?php echo $workLabel;  ?>
			 </a>             
		</div>
		 
	   
	<div class="clear"></div>
