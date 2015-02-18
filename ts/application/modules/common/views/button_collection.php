<?php
	if($button){
		//echo '<pre />';print_r($button);
		if(!is_array($button)){
			$button[]=$button;
		}
		$buttonId=isset($button['buttonId'])?$button['buttonId']:'';
?>
			<div class="fr padding-right0 ">
				<?php
					 if(in_array('preview', $button)){
						if($buttonId=='_showcase'){
							if($button['isPublished']=='f'){
							?>
								<div class="tds-button Fleft opacity_4"><button id="previewButton<?php echo $buttonId;?>" type="button" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="preview" name="preview"><span class="pr5"><div class="Fleft font_size12"><?php echo $this->lang->line('preview');?></div><div class="preview_button"></div></span></button></div>	
							<?php
							}
							else{
								$previewUrl=isset($button['previewUrl'])?@$button['previewUrl']:'';
								
							 ?>
								<div class="tds-button Fleft fr "><button id="previewButton<?php echo $buttonId;?>" type="button" onclick="window.open('<?php echo $previewUrl;?>', '_blank');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="preview" name="preview"><span class="pr5"><div class="Fleft font_size12"><?php echo $this->lang->line('preview');?></div><div class="preview_button"></div></span></button></div>
								<?php
							}
						}else{ ?>
							<div class="tds-button Fleft"><button id="previewButton<?php echo $buttonId;?>" type="button" onclick="preview();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="preview" name="preview"><span class="pr5"><div class="Fleft font_size12"><?php echo $this->lang->line('preview');?></div><div class="preview_button"></div></span></button></div>
							<?php
						}
					
					 }
					 
					 if(in_array('viewButton', $button)){
						 $viewUrl=isset($button['viewUrl'])?@$button['viewUrl']:'';
						  ?>
						<div class="tds-button Fleft"><button id="viewButton<?php echo $buttonId;?>" type="button" onclick="window.open('<?php echo $viewUrl;?>', '_blank');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="view" name="view" class="dash_link_hover"><span class="pr5"><div class="Fleft font_size12"><?php echo $this->lang->line('view');?></div><div class="preview_button"></div></span></button></div>
						<?php
					 }
					 if(in_array('publish', $button)){
						  ?>
						<div class="tds-button Fleft"><button id="publishButton<?php echo $buttonId;?>" type="button"  onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php echo $this->lang->line('Publish');?></div> <div class="icon-publish-btn"></div></span></button></div>
						<?php
					 }
					 if(in_array('cancelForm', $button)){
						  ?>
						<div class="tds-button Fleft"><button id="cancelButton<?php echo $buttonId;?>" type="button" class="cancel dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"  onclick="calcelForm();"><span><div class="Fleft"><?php echo $this->lang->line('cancel');?></div> <div class="icon-form-cancel-btn"></div></span></button></div>
						<?php
					 }
					 if(in_array('cancel', $button)){
						  ?>
						<div class="tds-button Fleft"><button id="cancelButton<?php echo $buttonId;?>" type="button" class="cancel dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php echo $this->lang->line('cancel');?></div> <div class="icon-form-cancel-btn"></div></span></button></div>
						<?php
					 }
					 if(in_array('cancelVtoggle', $button)){
						  ?>
						<div class="tds-button Fleft"><button type="button" onclick="cancelVtoggle(0);" name="cancel" value="Cancel" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('button_close');?></div> <div class="icon-form-close-btn"></div></span></button></div>
						<?php
					 }
					 if(in_array('ajaxCancel', $button)){
						  ?>
						<div class="tds-button Fleft"><button id="AjaxcancelButton<?php echo $buttonId?>" type="button" class="ajaxCancelButton dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php echo $this->lang->line('button_close');?></div> <div class="icon-form-close-btn"></div></span></button></div>
						<?php
					 }
					
					  if(in_array('cancelHide', $button)){
						  ?>
						 <div class="tds-button Fleft"><button id="cancelHideButtonCommon<?php echo $buttonId;?>" type="button" onclick="canceltoggle(0);" name="cancel" value="Cancel" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('button_close');?></div> <div class="icon-form-close-btn"></div></span></button></div>
						<?php
					 }
					 
					 if(in_array('cancelMultipleHide', $button)){
						$divToToggle=$button['2'];
						  ?>
						 <div class="tds-button Fleft"><button id="cancelHideButtonCommon<?php echo $buttonId;?>" type="button" onclick="canceltoggle(0,'<?php echo $divToToggle;?>');" name="cancel" value="Cancel" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('button_close');?></div> <div class="icon-form-close-btn"></div></span></button></div>
						<?php
					 }
					 	if(in_array('save', $button)){
						?>
						 <div class="tds-button Fleft"><button id="submitButton<?php echo $buttonId;?>" type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('save');?></div> <div class="icon-save-btn"></div></span></button></div>
						<?php
					}
					
						if(in_array('saveCompetition', $button)){
						?>
						 <div class="tds-button Fleft"><button onclick="return isBlockEdit()" id="submitButton<?php echo $buttonId;?>" type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('save');?></div> <div class="icon-save-btn"></div></span></button></div>
						<?php
					}
					
					if(in_array('submit', $button)){
						?>
						 <div class="tds-button Fleft"><button id="SubmitButton<?php echo $buttonId;?>" type="submit" name="submit" value="Submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('submit');?></div> <div class="icon-save-btn"></div></span></button></div>
						<?php
					}
					if(in_array('submitSave', $button)){
						?>
						 <div class="tds-button Fleft"><button id="SubmitButton<?php echo $buttonId;?>" type="submit" name="submit" value="Submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('save');?></div> <div class="icon-save-btn"></div></span></button></div>
						<?php
					}
					 if(in_array('ajaxSave', $button)){
						?>
						 <div class="tds-button Fleft"><button id="saveButton<?php echo $buttonId;?>" type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('save');?></div> <div class="icon-save-btn"></div></span></button></div>
						<?php
					 }  
					 if(in_array('saveOnClick', $button)){
						  ?>
						<div class="tds-button Fleft"><button id="saveButtonCommon<?php echo $buttonId;?>" type="submit" onclick="return submitform();" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('save');?></div> <div class="icon-save-btn"></div></span></button></div>
						<?php
					 }
					 

				?>
			</div>
		<?php
	}
?>

