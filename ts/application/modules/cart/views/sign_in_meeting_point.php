<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 ?>
 <div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
	<div id="show_comment" class="dash_boxgradient width_545">
		 <div class="row">
				<div class="ml18 pt25 mr18 sessionT_heading">
				  <div class="cell clr_444">Meeting Point</div>
				  <div class="cell mt_minus18 ml_minus_5"><img src="<?php echo base_url('templates/default') ?>/images/headingaerow.png"> </div>
				  <div class="clear"></div>
				</div>
				<div class="clear"></div>
			  </div>
			  <div class="seprator_10"></div>
			  <div class="position_relative">
				<div class="cell shadow_wp strip_absolute_1">
				  <!-- <img src="images/strip_blog.png"  border="0"/>-->
				  <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					  <tr>
						<td height="59"><img src="<?php echo base_url('templates/default') ?>/images/shadow-top-small_meeting_point.png"></td>
					  </tr>
					  <tr>
						<td class="shadow_mid_small">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="63"><img src="<?php echo base_url('templates/default') ?>/images/shadow-bottom-small_meeting_point.png"></td>
					  </tr>
					</tbody>
				  </table>
				  <div class="clear"></div>
				</div>
				<div class="seprator_20"></div>
				<div class="row">
				  <div class="aerowimgbg ml18 cell"> </div>
				  <div class="seprator_10"></div>
				 
				 <!----------meeting poing button area start--------->
				 	 <div id="meeting_point_button_area" class="<?php echo  $isShowClassButon?>">
					  <?php
							echo form_open('cart/meetingPoingInsert/', 'class="form" id="meeting_point_form" name="meeting_point_form"'); 
						?>	
					 
					  <div class="cell pt10 width_356 pl46">
						<div id="sign_button_show" class="tds-button mr10 ml30 "> <a href="javascript:void(0)" onclick="meeting_poing_insert(<?php echo $itemId; ?>)"   href="#" onmouseup="mouseup_tds_button_pur(this)" onmousedown="mousedown_tds_button_pur(this)"><span class="font_opensans font_size18 width_225">
						  <p class="Fleft mt_minus2 pr5 pl9">Sign In to</p>
						  <p class="clr_ee5a34 font_opensansSBold Fleft mt_minus2 pr5">Meeting Point </p>
						  </span></a> </div>
					  </div>
						<input type="hidden" name="item_id" id="item_id" value="<?php echo $itemId; ?>">
					<?php echo form_close(); ?>
					</div>
				
				
				<div id="meeting_point_not_button_area" class="<?php echo  $isShowClassNotButton?>">
					<div class="cell pt10 width_356 pl46">
						<p class="font_size18 font_opensans clr_Lgrey"> You have Signed in to<span class="inline orange_color font_opensansSBold "> Meeting Point</span> </p>
						<div class="seprator_20"></div>
						<p class="mr47 font_size14 font_opensans clr_Lgrey clr_Lgrey tar"> 
						 <a class="underline" target="_blank" href="<?php echo base_url('event/usermeetingpoint'); ?>">
						See your Meeting Point(s) </a></p>
					 </div>
				</div>
				
				<!---------meeting poing button area end-------->
				
				
				  <div class="clear"></div>
				</div>
				<div class="row">
				   <div class="tds-button Fright mr52"> <a target="_blank"  href="<?php echo base_url('tips/front_tips/34'); ?>" onmouseup="mouseup_tds_button_pur(this)" onmousedown="mousedown_tds_button_pur(this)"><span class="width_225">More about Meeting Point</span></a> </div>
				  <div class="clear"></div>
				</div>
				<div class="seprator_5 clear"></div>
	  </div>
		

	</div>

<script>
		function meeting_poing_insert(itemId)
		{
				var fromData=$("#meeting_point_form").serialize();
					fromData = fromData+'&ajaxHit=1';
					$.post(baseUrl+language+'/cart/meetingPoingInsert',fromData, function(data) {
					  if(data){
							$('#meeting_point_button_area').addClass(data);
							$('#meeting_point_not_button_area').addClass('db');
							$('.meetingPoing_Id<?php echo $SessionId; ?>').html('<a class="underline" target="_blank" href="<?php echo base_url('event/usermeetingpoint'); ?>"> Signed In to Meeting Point</a>');
							$('.meetingPoing_Id<?php echo $SessionId; ?>').removeClass('cartbtn_pur');
						//	$('#meetingPoingId<?php echo $SessionId; ?>').addClass('ml10 mt6 fr pt5');
					  }
				
					});
		}	
</script>
