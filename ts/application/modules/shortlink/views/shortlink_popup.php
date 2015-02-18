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
					<div class="cell"><input type="text" value="<?php echo $shareLink; ?>" id="gsInput" readonly name="getshortlink"  class="width405px" onfocus="this.select();" /></div> 
				</div>
				<div class="row pt10">
					<?php 
					/*<div class="cell">
						<div class="tds-button floatRight">
							<?php echo anchor('javascript://void(0);', '<span>Ok</span>',array('id'=>'okgetshortlink','class'=>'getshortlink','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
						</div>
					</div>*/
					?>
					<div class="cell">
						<div class="tds-button floatRight pr">
							<button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Copy" name="copy-button" type="button" id="copy-button" class="font_arial copylink"><span class="pr5"><div class="Fleft"><?php echo $this->lang->line('copy');?></div><div class="copy_button"></div></span></button>
							
							<!--<a id="copy-button" class ="copylink" href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" ><span> <?php //echo $this->lang->line('copy');?> </span></a>-->
							
							<button class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" onclick="$(this).parent().trigger('close');" type="button"><span><div class="Fleft"><?php echo $this->lang->line('cancel');?></div><div class="icon-cancel-btn-new"></div> </span></button>
							
							<!--<a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span onclick="$(this).parent().trigger('close');"> <?php //echo $this->lang->line('cancel');?> </span></a>-->
							<?php //echo anchor('javascript://void(0);', '<span>'.$this->lang->line('cancel').'</span>',array('id'=>'cancelgetshortlink','onclick'=>'hideRelationDiv(\'getshortlink'.$id.'\');','class'=>'getshortlink','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				
	

<script type="text/javascript">
	$(document).ready(function(){
		copyClip.init('.copylink');
	});
</script>			
			
			
</div>
</div>
