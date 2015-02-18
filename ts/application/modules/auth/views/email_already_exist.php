<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
		<div class="popup_gredient ">
			<div class="width_487">
				<div class="joinpopup_msg_box"> <div class="Fright mr13"><img alt="logo" src="<?echo base_url()?>images/join-popup_logo.png"></div> <div class="clear"> </div></div> 
				<div class="join_heading ml96 pt10 #5C5C5C lineH27"><?php echo $this->lang->line('auth_label_emailAddAssoc')?></div>
				<div class="pop_bdr"></div>
					<div class="position_relative">			
						<div class="cell shadow_wp strip_absolute left_65">
						<!-- <img src="images/strip_blog.png"  border="0"/>-->
							<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr>
									   <td height="59"><img src="<?echo base_url()?>images/shadow-top-small.png"></td>
									</tr>
									<tr>
									    <td class="shadow_mid_small height_68">&nbsp;</td>
									</tr>
									<tr>
									   <td height="63"><img src="<?echo base_url()?>images/shadow-bottom-small.png"></td>
									</tr>
								</tbody>
							</table>
						   <div class="clear"></div>
						</div>

					   <div class=" seprator_27"></div>

						<div class="Fright width_390">											
							<div class="mt20 underline">						
								<a href="javascript:openLightBox('popupBoxWp','popup_box','/auth/forgot_password/')">
								<?php echo $this->lang->line('auth_label_youForgetPass'); ?>
								</a>
							</div>	

						    <div class="mt20">	<?php echo $this->lang->line('auth_label_Or'); ?> 	</div>	

							<div class="mt20 underline">
								<a href="<?php echo base_url(lang().'/package/packagestageone');  ?>">
								<?php echo $this->lang->line('auth_label_joinwthAnother')?>
								</a>							
							</div>							   
						</div>							

					<div class="clear"></div>
					</div>

				<div class="row">
				<div class="tds-button Fright mr10"> <a onclick="$(this).parent().trigger('close');" href="javascript:void(0);" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" ><span class="orange_clr_imp font_opensans" ><?php echo $this->lang->line('continue')?></span></a> </div>
				<div class="clear"></div>
			</div>
			<div class="seprator_25 clear"></div>

			</div>
		</div>
