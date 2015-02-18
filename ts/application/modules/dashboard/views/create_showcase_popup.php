<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
	<div class="width_566 pt1">
		
		<div class="torcmsg_heading clr_white font_size24 pl70 font_opensans">
			<div class="fr mt13 mr23"><img src="<?php echo base_url('images/join-popup_logo.png');?>"></div>
		</div>	
		<div class="pop_bdr"></div>
	
		<div class="row">
		<div class="cell ml90">&nbsp;</div>
		<div class="cell createShowcaseTitle">
				<?php echo $this->lang->line('createShowcaseMessage');?>
		</div>
		</div>
		<div class="row">
		<div class="cell ml63"><img src="<?php echo base_url('images/popup_smallrepeater.png');?>" /></div>
		<div class="cell font_museoSlab font_size14 lineH27 pt30">
				<?php echo $this->lang->line('likeToDoThisNow');?>
		</div>
		</div>	
		
		 		  
		<div class="row">
		  <div class="cell ml90"><a class="Fright popup_link lineH13 mt9" href="<?php echo base_url('package/packageinformation');?>">	<?php echo $this->lang->line('membershipInformation');?></a> </div>
		  <div class="mr20">  
				<div class="tds-button  fr"> <a href="<?php echo base_url(lang().'/dashboard/showcase');?>" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" ><span class="font_size14 font_opensansSBold width_90 clr_f1592a"><?php echo $this->lang->line('setup');?></span></a></div>
				<div class="tds-button  fr "> <a href="javascript:void(0);" onclick="$(this).parent().trigger('close');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" ><span class="font_size14 font_opensansSBold width_90">Cancel</span></a></div>
		 </div>	 
			
			<div class="clear seprator_20"></div>
		
			</div>
			<div class="clear"></div>
	
	
	</div><!-- width_566 -->
</div><!-- popup_gredient -->
