<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row">
	<div class="label_wrapper cell">
		<label <?php if($required==1){ ?> class="select_field"<?php } ?> ><?php echo $label;?> </label>
	</div><!--label_wrapper-->
	<div class=" cell frm_element_wrapper">
		<div class="browse_box row">
			<div class="browse_thumb_wrapper cell">
				<table width="100%"  height="100%" border="0" cellspacing="0" cellpadding="0" class="backgroundBlack">
				  <tr>
					<td><?php echo $imgSrc;?></td>
				  </tr>
				</table>
			</div><!--browse_thumb_wrapper-->
			
			<?php
			if($stockImageFlag == 1)
			{?>
				
				<div class="click_here_wp" >
						<a href="javascript:void(0);" onclick="showstockimages();"><?php echo $this->lang->line('clickHere');?></a><?php echo $this->lang->line('chooseStockPhoto'); ?>
				</div>
				<?php
			}
			
			//$inputArray['class'] = $inputArray['class'].' formTip ';
			//$inputArray['title'] = $this->lang->line('imgTitleMsg');
		
			if(is_array($uploadArray) && count($uploadArray)>0){ ?>
				<div class="browse_button_wrapper cell" id="browse_button">
					
					<input type="hidden" value="" id="stockImageId" name="stockImageId" />
					<div id="FileUpload_imgJs" onmouseup="mouseup_tds_button(document.getElementById('browse_btn'))" onmousedown="mousedown_tds_button(document.getElementById('browse_btn'))">
							<div class="tds-button">
								<a id="browse_btn"><span><?php echo $this->lang->line('browse')?></a>  </div>
							<?php echo form_upload($uploadArray); ?>
							<div class="clear"></div>
							<?php echo form_input($inputArray); ?>
							<div class="font_size11 row"><?php $mediaTypeToShow = 'imageTypeToShow';echo $this->lang->line('allowedExt').'&nbsp;'.$this->config->item($mediaTypeToShow);?></div>
					</div>
				</div>
				<?php
			}
			?>
			<div class="clear"></div>  
		</div><!--browse_box-->
	</div><!--from_element_wrapper--> 
 </div> 
                            
