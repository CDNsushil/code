<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$fileNameInput = array(
		'name'	=> 'fileName'.$browseId,
		'value'	=> '',
		'id'	=> 'fileName'.$browseId,
		'type'	=> 'hidden'
	);
	$fileSizeInput = array(
		'name'	=> 'fileSize'.$browseId,
		'value'	=> '',
		'id'	=> 'fileSize'.$browseId,
		'type'	=> 'hidden'
	);
	echo form_input($fileNameInput);
	echo form_input($fileSizeInput);
?>
<div id="uploadFileByJquery<?php echo $browseId;?>"></div>
<div class="row" id="Uploadvideo<?php echo $browseId;?>">
	<div class="fr">
		<div class="fileInfo" id="fileInfo<?php echo $browseId;?>">
			<div id="progressBar<?php echo $browseId;?>" class="plupload_progress">
				<div class="progressBar_msg fl"><?php echo $this->lang->line('fileUploading');?></div>
				<div class="plupload_progress_container fl">
					<div id="plupload_progress_bar<?php echo $browseId;?>" class="plupload_progress_bar"></div>
				</div>
			</div>
			<span id="percentComplete<?php echo $browseId;?>" class="percentComplete fl"></span>
		</div>
		<div id="dropArea<?php echo $browseId;?>"></div>
	</div>
	<div class="label_wrapper cell">
		<label <?php if($required=='required'){ ?> class="select_field"<?php } ?> ><?php echo $label;?> </label>
	</div><!--label_wrapper-->
	<div class=" cell frm_element_wrapper">
		<div class="browse_box row">
			<div class="browse_thumb_wrapper cell">
				<table width="100%"  height="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td id="image<?php echo $browseId?>"><?php echo $imgSrc;?></td>
				  </tr>
				</table>
			</div><!--browse_thumb_wrapper-->
			
			<?php
			if(is_array($inputArray) && count($inputArray)>0){ ?>
				<div class="browse_button_wrapper cell">
					<div class="tds-button btn_span_hover">
						<a id="browsebtn<?php echo $browseId;?>" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></span></a></div>
					<div class="clear"></div>
					<?php 
					$inputArray['class'] = @$inputArray['class']." formTip ";
					$inputArray['title'] = $this->lang->line('imgTitleMsg');
					echo form_input($inputArray); 
					?>
					<div class="font_size11 row"><?php $mediaTypeToShow = 'imageTypeToShow';echo $this->lang->line('allowedExt').'&nbsp;'.$this->config->item($mediaTypeToShow);?></div>
					<?php
					if(isset($infoMsg) && strlen($infoMsg) > 5){
						?>
						<div class="row"><div class="cell">*&nbsp;</div><div class="cell"><?php echo $infoMsg;?></div></div>
						<?php
					}?>
					<div id="fileError<?php echo $browseId;?>" class="row wordcounter orange"></div>
				</div>
				<?php
			}
			?>
			<div class="clear"></div>  
		</div><!--browse_box-->
	</div><!--from_element_wrapper--> 
</div>
<script type="text/javascript">
		
		var fileUploadPath='<?php echo $fileUploadPath;?>';
		var max_file_size='<?php echo $fileMaxSize;?>';
		var fileTypes = '<?php echo $fileType;?>';
		
		var uniId = '<?php echo $browseId;?>';
		uploadMediaFiles(fileUploadPath,fileTypes,max_file_size,uniId,1,1);
</script>
