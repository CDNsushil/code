<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<link href="<?php echo base_url().'templates/system/css/common.css'?>" type="text/css" rel="stylesheet"/>
<link href="<?php echo base_url().'templates/default/css/screen.css'?>" type="text/css" rel="stylesheet"/>
<div style="border: 1px solid #C9C9C9; width: 560px; background:#F9F9F9;margin-left: 1px; margin-top: 4x;">
	<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
	<div class="tmailtop_gradient minH60 bdr_e2e2e2 mt1 ml1 mr1">
		<div class="font_opensansSBold font_size14 clr_444 ml15 mr15 mt7">
			<div style="width:400px" >
				<?php echo $tmailSubject;?>											
			</div>
			<span style="float:right;font-size:11px;margin-top:-17px;">
			<?php echo date("d F  Y");?></span>
			<div class="clear"></div>
			<div class="dashbdrstrip"></div>
			<div style="font-size:13px;margin-left:1px; margin-top: 4px;">Toadsquare</div>
			<div style="float: right;margin-right: 15px;margin-top: -14px;">           
				<div style="float:left;"> <a href="javascript:void(none);" id="slide_up"> <img src="<?php echo site_base_url(); ?>images/tmail_aerrowup.png" alt=""></a></div>

				<div style="float:left;margin-left:5px;"><a href="javascript:void(none);" id="slide_down"> <img src="<?php echo site_base_url(); ?>images/tmail_aerrowdown.png" alt=""></a></div>

			</div>
		</div>
	</div> <!-- tmailtop_gradient minH60 -->
	<div id="show_hide" class="tmail_list">  												
		<div style="height: 14px;width: 100%;"></div>
		<div style="margin:0 10px 10px -7px; min-height:200px; color:#444444;">
			<table>
				<tbody><tr>
					<td style="padding:16px 0 0 0; color:#444444;">
						<?php echo $tmailBody;?>		
					</td>
				</tr>

				<tr>
					<td style="font-size:18px; color:#444444; padding:45px 0 0 32px;">
					</td>
				</tr>

			</tbody></table>														
			<div class="clear"></div>
		</div>
	</div>  <!-- Show Hide -->
	<div class="tmailtop_gradient min_h60 bdr_e2e2e2 mt1 ml1 mr1">
		<div class="tmail_bottomstrip fl">
		</div> 								
		<div style="float:right;margin-top:10px;margin-right:5px;">		

			<div class="tds-button" style="float:right;margin-top:5px;"> <button class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="button"><span><div class="Fleft">Print</div> <div class="print_button"></div> </span> </button>  </div>
			<div class="tds-button" style="float:right;margin-top:5px;"> <button class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"  type="button"><span><div style="float:right;">Delete</div> <div class="delete_button"></div> </span> </button>  </div>
		</div>	
		<div class="clear"></div>
	</div>
</div>
