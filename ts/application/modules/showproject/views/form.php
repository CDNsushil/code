<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array( 'name'=>'showprojectFrom', 'id'=>'showprojectFrom');
$fullName=LoginUserDetails('firstName').' '.LoginUserDetails('lastName');
$userImage=LoginUserDetails('imagePath');
$creative=LoginUserDetails('creative');
$associatedProfessional=LoginUserDetails('associatedProfessional');
$enterprise=LoginUserDetails('enterprise');
$imageType=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$imageType);
$userImage=getImage($userImage);
if($projectType=='filmNvideo'){
	$heading=$this->lang->line('showOnKeyCastCrewShowcase');
	$addKeyMsg=$this->lang->line('addKeyCastCrewMsg');
	$RequestSentToAllKeypersonnel=$this->lang->line('RequestSentToAllKeyCastKrew');
}elseif($projectType=='musicNaudio'){
	$heading=$this->lang->line('showOnKeyBandMembersShowcase');
	$addKeyMsg=$this->lang->line('addKeyBandMembersMsg');
	$RequestSentToAllKeypersonnel=$this->lang->line('RequestSentToAllBandMembers');
}else{
	$heading=$this->lang->line('showOnKeyPersonelShowcase');
	$addKeyMsg=$this->lang->line('addKeyPersonnelMsg');
	$RequestSentToAllKeypersonnel=$this->lang->line('RequestSentToAllKeyPersonal');
}
?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
	<div class="widht_570 bg_f3f3f3" id="showProjectDiv">
		<?php 
		if($associativeCreatives && is_array($associativeCreatives) && count($associativeCreatives) > 0){
			$showprojectUser=false;
			foreach($associativeCreatives as $ac){ 
				if(!$ac['showprojectid'] >0){
					$showprojectUser[]=$ac;
				}
			}
			if($showprojectUser){
			  echo form_open(base_url(lang().'/showproject/sendRequest'),$formAttributes); ?>
				<div class="Contact_form_topbox bdr_d2d2d2" >
					<div class="row">
						<div class="cell font_opensans font_size18 pt20 height_16 widht_515 ml_25 bdr_c1c1c1">
							<div class="clr_666 font_opensans"><?php echo $heading;?></div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="seprator_10"></div>
					<div class="position_relative">
						<div class="cell shadow_wp strip_absolute left_220">
							<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr>
										<td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
									</tr>
									<tr>
										<td class="shadow_mid_small">&nbsp;</td>
									</tr>
									<tr>
										<td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
									</tr>
								</tbody>
							</table>
							<div class="clear"></div>
						</div>
						<div class="seprator_20"></div>
						<div class="cell mt10 widht_120">
							<div class="w69_h66 margin_auto">
								<div class="AI_table">
									<div class="AI_cell">
										<img class="Contact_form_thumb" src="<?php echo $userImage;?>">
									</div>
								</div>
							</div>
						</div>
						
						<div class="cell ml15 ">
							<div class="row">
								<div class="contact_label_wrapper cell">
									<label class="select_field"><?php echo $this->lang->line('from');?></label>
								</div>
								<div class="cell contact_frm_element_wrapper">
									<span class="pt7 font_opensansSBold"><?php echo $fullName;?></span>	
								</div>
							</div>	
							<!-- row01-->
							<div class="row">
								<div class="contact_label_wrapper cell">
									<label class="select_field"><?php echo $this->lang->line('message');?></label>
								</div>
								<div class="cell contact_frm_element_wrapper">
									<input type="hidden" name="subject" class="required" value="<?php echo $this->lang->line('showRequest');?>">
									<input type="hidden" name="type" class="required" value="5">
									<input type="hidden" name="entityId" class="required" value="<?php echo $entityId;?>">
									<input type="hidden" name="elementId" class="required" value="<?php echo $elementId;?>">
									<input class="widht_304" type="text" name="body" class="required" readonly value="<?php echo $this->lang->line('showRequest');?>">
								</div>
							</div>
							<div class="row">
								<div class="contact_label_wrapper cell">
									<label class="select_field"><?php echo $this->lang->line('Date');?></label>
								</div>
								<div class="cell contact_frm_element_wrapper">
									<span class="pt7 font_opensansSBold"><?php echo currntDateTime('d F Y');?></span>
								</div>
							</div>
							
							<div class="row">
								<div class="seprator_25"> </div>
								<div class="contact_label_wrapper cell">
								<label class="select_field"><?php echo $this->lang->line('sendTo');?></label>
								</div>
								<div class="cell contact_frm_element_wrapper">
									<?php
										foreach($showprojectUser as $ac){?>
											<div class="row pt10">
												<div class="cell defaultP  pr10"><input type="checkbox" name="recipientsId[]"  value="<?php echo $ac['tdsUid'];?>"></div>
												<div class="cell font_opensansSBold"><?php echo $ac['crtName'];?></div>
											</div>
											<?php
										}
									 ?>
									<div class="clear"> </div>
									<div class="seprator_45 pr10"> </div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="seprator_10"></div>
				</div>
				<div class="clear"></div>
				<div class="seprator_10"> </div>
				<div class="row">
					<div class="Fright mt14">
						<div class="tds-button Fright mr9"> <button onclick="javascript:$(this).parent().trigger('close');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span><div class="Fleft">Close</div> <div class="icon-save-btn"></div> </span> </button>  </div>
						<div class="tds-button Fright"><button type="submit" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span><div class="Fleft">Send</div> <div class="icon-publish-btn"></div></span> </button> </div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="seprator_15 clear"></div>
			 <?php echo form_close();
			}else{
				echo '<div class="p15">'.$RequestSentToAllKeypersonnel.'</div>';
			}
		}
		else{
			echo '<div class="p15">'.$addKeyMsg.'</div>';
		}?>
		
	</div>
</div>
<script>
	$(document).ready(function(){	
		runTimeCheckBox();
		$("#showprojectFrom").validate({
			  submitHandler: function() {
				var fromData=$("#showprojectFrom").serialize();
				fromData = fromData+'&ajaxHit=1';
				$.post(baseUrl+language+'/showproject/sendRequest/',fromData, function(data) {
				  if(data){
					  $('#showProjectDiv').html('<div class="p15"><?php echo $this->lang->line("requestSent");?></div>');
				  }else{
					alert("<?php echo $this->lang->line('sessionExpired');?>");  
				  }
				});
			 }
		});
	});
</script>
