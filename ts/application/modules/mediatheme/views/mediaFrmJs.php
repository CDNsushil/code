<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

$browseImgJs = $toggleId;
	$fileNameInput = array(
		'name'	=> 'fileName'.$browseImgJs,
		'value'	=> '',
		'id'	=> 'fileName'.$browseImgJs,
		'type'	=> 'hidden'
	);
	
	$fileSize = array(
		'name'	=> 'fileSize'.$browseImgJs,
		'value'	=> '',
		'id'	=> 'fileSize'.$browseImgJs,
		'type'	=> 'hidden'
	);
	
	$isExternal = array(
			'name'	=> 'isExternal',
			'value'	=> 'f',
			'id'	=> 'isExternal',
			'type'	=> 'hidden'
	);
	echo form_input($fileNameInput);
	echo form_input($isExternal);
	echo form_input($fileSize);
	
?>
<div id="uploadFileByJquery<?php echo $browseImgJs;?>"></div>
<div class="row">	
	<div class="label_wrapper cell">
		<label <?php if($required==1){ ?> class="select_field"<?php } ?> ><?php echo $label;?> </label>
	</div><!--label_wrapper-->
	<div class="cell frm_element_wrapper">
		<div class="browse_box row">
			<div class="browse_thumb_wrapper cell">
				<table width="100%"  height="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td><?php echo $imgSrc;?></td>
				  </tr>
				</table>
			</div><!--browse_thumb_wrapper-->
			
			<?php
			if($stockImageFlag == 1)
			{
			?>
			<div class="click_here_wp" >
				<a href="javascript:void(0);" onclick="showstockimages();" class="b"><?php echo $this->lang->line('clickHere');?></a><?php echo $this->lang->line('chooseStockPhoto'); ?>
			</div>
			<?php
			}
			?>						
			<div class="browse_button_wrapper cell" id="Uploadvideo<?php echo $browseId;?>">				
				<div>
					<div class="tds-button" id="browsebtn<?php echo $browseId;?>">
						<a onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></a>  </div>
					<?php //echo form_upload($uploadArray); ?>
					<div class="clear"></div>
					<?php echo form_input($inputArray); ?>
					<div id="fileError<?php echo $browseId;?>" class="row wordcounter orange"></div>
				</div>
			</div>
		
			<div id="FileContainer<?php echo @$browseImgJs;?>" class="fr">
				<div class="fileInfo" id="fileInfo<?php echo @$browseImgJs;?>">
					<div id="progressBar<?php echo @$browseImgJs;?>" class="plupload_progress">
						<div class="progressBar_msg fl"><?php echo $this->lang->line('fileUploading');?></div>
							<div class="plupload_progress_container fl">
							<div id="plupload_progress_bar<?php echo @$browseImgJs;?>" class="plupload_progress_bar"></div>
							</div>
						</div>
					<span id="percentComplete<?php echo @$browseImgJs;?>" class="percentComplete fl"></span>
					</div>
				<div id="dropArea<?php echo @$browseImgJs;?>"></div>
			</div>
			<div class="clear"></div>  
		</div><!--browse_box-->
	</div><!--from_element_wrapper--> 
 </div> 
<?php 

if(!isset($browseImgJs)){
	$browseImgJs='video';
	}
	$fileImg="fileInput".@$browseImgJs;
	$fileNameImage="fileName".@$browseImgJs;
	
?>
<script type="text/javascript">
		$(document).ready(function(){
			
		$("#mediaForm<?php echo $browseImgJs;?>").validate({
		
		submitHandler: function() {	
			
			var elementId = $('#mediaId<?php echo $browseImgJs?>').val();
			
			var mediaDescription=$('#mediaDescription<?php echo $browseImgJs?>').val();  
			var mediaTitle=$('#mediaTitle<?php echo $browseImgJs?>').val(); 			
			
			var promoElementTable = '<?php echo $elementTable;?>';  
			//var promoElementFieldId = '<?php echo $elementFieldId;?>'; 	
			var promoElementFieldId = 'mediaId';
			
			var promoImagePath = '<?php echo $mediaPath;?>'; 
			var fileId =''; 
			var fieldName = '<?php echo $elementFieldId;?>'; 
			var fileSize=$('#fileSize<?php echo $browseImgJs?>').val();
			var browseId = '<?php echo $browseImgJs?>';
			var imgSrc = ''; 
			var elementCount=<?php echo $count;?>;
			var isDefaultElement='f';
			var entityMediaType='<?php echo $mediaType;?>';
			
			if(elementId == 0)
				var data = {"entityMediaType":entityMediaType,"entityField":fieldName,"entityId":<?php echo $entityId;?>,"mediaTitle":mediaTitle,"mediaDesc":mediaDescription,"mediaType":entityMediaType}; 
			else
				var data = {"entityMediaType":entityMediaType,"entityField":fieldName,"entityId":<?php echo $entityId;?>,"mediaId":elementId,"mediaTitle":mediaTitle,"mediaDesc":mediaDescription,"mediaType":entityMediaType}; 
						
			if($('#<?php echo $fileImg;?>').val()!='')
			{				
				var promofileData = {"filePath":promoImagePath,"rawFileName":$('#<?php echo $fileImg;?>').val(),"fileName":$('#<?php echo $fileNameImage;?>').val(),"fileSize":fileSize,"fileType":entityMediaType,"isExternal":'f',"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>};
			}
			else
			{
				var promofileData = '';
			}		
		
		AJAX('<?php echo base_url(lang()."/mediatheme/UpdatePromoMedia");?>','pagingContent<?php echo $browseImgJs?>',promofileData,data,fileId,elementId,promoElementTable,promoElementFieldId,imgSrc,isDefaultElement,'<?php echo $browseImgJs;?>'); 
		
		$("#uploadFileByJquery"+browseId).click();
		canceltoggle(0);		
		}
	});
	
	$('#browsebtn<?php echo $browseImgJs;?>').click(function(){		
		fileTypes = '<?php echo $mediaFileTypes;?>';
		fileTypes = fileTypes.replace(/\|/g, ",");		
	});

	
    uploadMediaFiles('<?php echo $mediaPath;?>',fileTypes,'<?php echo $this->config->item('imagemaxSize');?>','<?php echo $browseImgJs;?>',1,1,1,1);
  
    });
 
 </script>
                            
