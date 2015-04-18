<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>
<div class="popup_gredient ">
	<?php if(isset($popupSection) && $popupSection=='blog'){$width='width_520';} else{$width='width_545';} ?>
      <div class="<?php echo $width;?>">
        <div class="joinpopup_msg_box"> <div class="Fright mr13"><img alt="logo" src="<?echo base_url()?>images/join-popup_logo.png"></div> <div class="clear"> </div></div>
       
        <div class="pop_bdr"></div>
        <div class="position_relative">
			<div class="seprator_27"></div>
			<div class="font_opensans clr_666 font_size13">             
				<div class="row">
					<div class="defaultP pl25 pr_54">
						<div class="font_opensans mediaupload_popup width500px">
							<ul class=" ml15">
								<!--li load for Products for Sale start -->
								<?php if(isset($sellSettingUrl) && !empty($sellSettingUrl)){?>
									<li>Don't forget to fill in the Sales section and make sure your <a href="<?php echo $sellSettingUrl;?>">Seller Settings</a> are up to date.
									</li>	
								<?php }?>
								<!--li load for Products for Sale end -->
								
								<!--li load for work, product, upcoming and media start -->
								<?php 
								if(isset($descriptionUrl) && !empty($descriptionUrl)){
									if(isset($popupSection) && $popupSection!='work' && $popupSection!='product'){ ?>
									<li><?php echo $this->lang->line('makeShowcaseBetterMsgChange');?> <a href="<?php echo $descriptionUrl;?>" class="underline"><?php if($popupSection=='media') { echo "Further Description";}else{ echo "Promotional Material";} ?></a> or <a href="<?php echo $prMaterialUrl;?>" class="underline">PR Material</a>.</li>
									<?php }?>
									
									<?php if(isset($popupSection) && $popupSection!='upcoming' && $popupSection!='media' && $popupSection!='event' && $popupSection!='launch'){ ?>
									<li><?php echo $this->lang->line('makeShowcaseBetterMsgChange');?> <a href="<?php echo $descriptionUrl;?>" onclick="$(this).parent().trigger('close');"  class="underline" >Promotional Material</a>.</li>
									<?php }
								}
								?>
								<!--li load for work, product, upcoming and media end -->
								<?php if(isset($popupSection) && $popupSection!='event' && $popupSection!='launch' && $popupSection!='blog'){ ?>
								<!--li load to show index page url start -->
								<li><?php echo $this->lang->line('previewPublishInfoChange');?> <a href="<?php echo $indexUrl;?>" <?php if(isset($isFreeProduct) && $popupSection=='product'){?> onclick="$(this).parent().trigger('close');" <?php }?> class="underline">Index page</a> .</li>
								<!--li load to show index page url end -->
								<?php } ?>
								<!--li load for media types start -->
								<?php if(isset($popupSection) && $popupSection!='upcoming' && $popupSection!='work' && $popupSection!='product' && $popupSection!='event' && $popupSection!='launch' && $popupSection!='blog'){ ?>
								<li>
									<a href="javascript:void(0)" onclick="$(this).parent().trigger('close');" class="underline">Upload</a>
									 more content. If you want to sell this work, fill in the 
									<a href="javascript:void(0)" onclick="$(this).parent().trigger('close');" class="underline">Sales section</a> and make sure your 
									<a href="<?php echo site_url(lang()).'/dashboard/globalsettings';?>" class="underline">Seller Settings</a> are up to date.
								</li>
								<?php } ?>
								<!--li load for media types end -->
								<!--li load for media types start -->
								<?php if(isset($popupSection) && ($popupSection=='event' || $popupSection=='launch')){ ?>
								<li>
									<?php echo $this->lang->line('previewPublishInfoChange');?> <a href="<?php echo $indexUrl;?>" onclick="$(this).parent().trigger('close');" class="underline">Index page</a>.<br />
								</li>
								<?php if(isset($popupSection) && $popupSection!='launch'){ ?>
								<li>
								  <a href="javascript:void(0)" onclick="$(this).parent().trigger('close');" class="underline">Add</a> another Session.
								</li>
								<?php 
									} 								
								} 
								?>
								<!--li load for media types end -->
							</ul>
							<!--Load popup for Blog section-->
							<?php if(isset($popupSection) && $popupSection=='blog'){ ?>
								<div class="cell font_opensansSBold">
									<?php echo $this->lang->line('afterSaveBlog');?>
								</div>
								
								<div class="row">	
									<div class="tds-button Fright mr14 mt5" id="redirectButton"> <a href="<?php echo $indexUrl; ?>" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="orange_color gray_clr_hover  font_opensansSBold width_60"><?php echo $this->lang->line('yes')?></span></a>
										<div class="clear"></div>
									</div>
									<div class="tds-button Fright mr5 mt5" id="redirectButton"> <a onclick="$(this).parent().trigger('close');" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="dash_link_hover  font_opensansSBold width_60"><?php echo $this->lang->line('cancel')?></span></a>
										<div class="clear"></div>
									</div>
								</div>
							<?php }?>
							<!--Load popup for Blog section-->
						</div>
					</div>
				</div>  
			</div>
			<div class="clear"> </div>
        </div>
        <div class="seprator_27 clear"></div>
    </div>
    </div>
