<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>
 <div class="pt15 pl15 pb15 pr15 bg_darker bdr5_white">
<div style="padding:10px">
<div class="title-content">
	  <div class="title-content-left">
		<div class="title-content-right">
		  <div class="title-content-center">
			<div class="title-content-center-label"><?php //echo $this->lang->line('shareon');?></div><!--title-content-center-label-->			
		</div><!--title-content-center-->
	  </div><!--title-content-right-->
	</div><!--title-content-left-->
</div><!--title-content-->
<div class="clearfix"></div>



	<!-- To get short link used the common id (already presnet in dsscreen) for div adjust the css -->
			
						
				<div class="row">
					<div class="cell">
                        <input type="text" value="<?php echo $shareLink; ?>" id="gsInput" readonly name="getshortlink"  class="width405px" onfocus="this.select();" /></div> 
				</div>
				
				<div class="row pt10">
					<div class="tds-button Fright"> 
						<a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0);" id="copy-button" class="font_arial copylink black_link_hover"><span id="copy_button_id" class="orange_color_no_imp gray_clr_hover font_arial"><?php echo $this->lang->line('copy');?></span></a> 
					</div>
					
					<!--<div class="tds-button Fright ptr"> 
						<button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Copy" name="copy-button" type="button" id="copy-button" class="font_arial copylink"><span><div class="Fleft orange"><?php echo $this->lang->line('copy');?></div></span></button>
					</div>-->
					<div class="tds-button Fright mr10"> 
						<button type="button" onclick="javascript:$(this).parent().trigger('close');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span><div class="Fleft dash_link_hover">Cancel</div></span> </button> 
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="clear"></div>
	
<script type="text/javascript">
		$(document).ready(function(){
			copyClip.init('.copylink');
		});
		
		// mouse enter
		$("#copy-button").mouseenter(function(){
			$("#copy_button_id").removeClass();
			$("#copy_button_id").addClass('gray_clr_hover font_arial gray_clr_hover ptr');
		});
		
			// mouse leave
		$("#copy-button").mouseleave(function(){
			$("#copy_button_id").removeClass();
			$("#copy_button_id").addClass('orange_color_no_imp gray_clr_hover font_arial');
		});
		
</script>			
			
			
</div>
</div>
