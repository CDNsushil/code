<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$userContainerId = (isset($userContainerId) && ($userContainerId!='')) ? $userContainerId  : 0 ?>
<div class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
	<div class="width_355 pt24 pl20 pb20 pr20">
		<div class="row font_museoSlab font_size24 lineH27 text_alignC pl10 pr10 clr_888">
			<?php echo $this->lang->line('notEnoughSpace');?>
		</div>
		<div class=" seprator_34"></div>
		<div class="row ml132">
			<div class="tds-button"> <a href="<?php echo base_url(lang().'/membershipcart/addspace/'.$userContainerId); ?>" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)"><span class="font_size14 font_opensansSBold width_90 hoverOrange"><?php echo $this->lang->line('buySpace');?></span></a></div>
		</div>
		<div class="row ml120 pt5">
			<div class="font_opensans"><a class="hoverOrange" href="<?php echo base_url(lang().'/package/information'); ?>"><?php echo $this->lang->line('membershipInformation');?></a></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
