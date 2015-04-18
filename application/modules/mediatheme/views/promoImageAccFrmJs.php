<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
if(isset($browseId)||$browseId!='')  $browseImgJs = $browseId;

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
	
	$lastInsertedMediaId = array(
		'name'	=> 'lastInsertedMediaId',
		'value'	=> '',
		'id'	=> 'lastInsertedMediaId',
		'type'	=> 'hidden'
	);
	
	$isMain = array(
		'name'	=> 'isMain',
		'value'	=> 'f',
		'id'	=> 'isMain',
		'type'	=> 'hidden'
	);
	echo form_input($fileNameInput);
	echo form_input($isExternal);
	echo form_input($fileSize);
	echo form_input($lastInsertedMediaId);
	echo form_input($isMain);
	
	//echo 'Current Method:->'.$this->router->method;
?>


<div class="row">
	
	<div class="label_wrapper cell">
		<label <?php if($required==1){ ?> class="select_field"<?php } ?> ><?php echo $label;?> </label>
	</div><!--label_wrapper-->
	<div class="cell frm_element_wrapper">
		<div class="browse_box row">
			<div class="browse_thumb_wrapper cell ">
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
			<div class="browse_button_wrapper cell" id="Uploadvideo<?php echo @$browseImgJs;?>">				
				<input type="hidden" value="" id="stockImageId" name="stockImageId" />
				<div id="FileUpload<?php echo @$browseImgJs;?>" >
						<div class="tds-button" id="browsebtn<?php echo @$browseImgJs;?>">
							<a onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></a>  </div>
						<?php //echo form_upload($uploadArray); ?>
						<div class="clear"></div>
						<?php 						
							$inputArray['class'] = str_replace('formTip','',$inputArray['class']);
							echo form_input($inputArray); 
						?>
						<div class="clear"></div>
						<div class="font_size11"><?php echo $this->lang->line('allowedExt').'&nbsp;'.$this->config->item('imageTypeToShow');?></div>
						<div id="fileError<?php echo @$browseImgJs;?>" class="row wordcounter orange"></div>
				</div>
			</div>
			<div class="clear"></div>  
		</div><!--browse_box-->
	</div><!--from_element_wrapper--> 
 </div> 
<?php 

if(!isset($browseImgJs)){ $browseImgJs=''; }
	$fileImg="fileInput".@$browseImgJs;
	$fileNameImage="fileName".@$browseImgJs;
	$imageExt = $this->config->item('mediaXXSsuffix');
?>

<script type="text/javascript">
		$(document).ready(function(){
		<?php if(strcmp($browseImgJs,'_showcaseImgJs')!=0){ ?>
		$("#promotionalImageForm<?php echo $browseImgJs;?>").validate({
		
		submitHandler: function() {			
			var elementId = $('#mediaId').val();  
			var mediaDescription=$('#mediaDescription').val();  
			var mediaTitle=$('#mediaTitle').val(); 			
			var divId=$('#divId').val();			
			var promoElementTable = '<?php echo $promoElementTable;?>';  
			var promoElementFieldId = '<?php echo $promoElementFieldId;?>'; 	
			var promoImagePath = '<?php echo $promoImagePath;?>'; 
			var fileId =$('#mediafileId').val();
			var fieldName = '<?php echo $promoEntityField;?>'; 
			var fileSize=$('#fileSize<?php echo $browseImgJs?>').val();
			var isMain=$('#isMain').val();
			var browseId = '<?php echo $browseImgJs?>';
			var imgSrc = ''; 
			var elementCount=<?php echo $count;?>;
			var isDefaultElement='f';
			var entityMediaType='<?php echo $entityMediaType;?>';
			
			if(elementId == 0)
				var data = {"entityMediaType":entityMediaType,"entityField":fieldName,"entityId":"<?php echo $entityId;?>","mediaTitle":mediaTitle,"mediaDescription":mediaDescription,"mediaType":'1',"isMain":isMain}; 
			else
				var data = {"entityMediaType":entityMediaType,"entityField":fieldName,"entityId":"<?php echo $entityId;?>","mediaId":elementId,"mediaTitle":mediaTitle,"mediaDescription":mediaDescription,"mediaType":'1',"isMain":isMain}; 
						
			if($('#<?php echo $fileImg;?>').val()!='')
			{				
				var promofileData = {"filePath":promoImagePath,"rawFileName":$('#<?php echo $fileImg;?>').val(),"fileName":$('#<?php echo $fileNameImage;?>').val(),"fileSize":fileSize,"fileType":'1',"isExternal":'f',"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>};
			}
			else
			{
				var promofileData = '';
			}		
		if($('#fileError<?php echo @$browseImgJs;?>').text()=='')
			var returnFlag = AJAX('<?php echo base_url(lang()."/mediatheme/UpdatePromoImage");?>',divId,promofileData,data,fileId,elementId,promoElementTable,promoElementFieldId,imgSrc,isDefaultElement,'<?php echo $browseImgJs;?>'); 
			if(returnFlag){
				$("#uploadFileByJquery"+browseId).click();
				canceltoggle(0);
			}
		}
	});
	
	imagefileTypes = '<?php echo $this->config->item('imageAccept');?>';
	imagefileTypes = imagefileTypes.replace(/\|/g, ",");
	$('#browsebtn<?php echo $browseImgJs;?>').click(function(){		
		imagefileTypes = '<?php echo $this->config->item('imageAccept');?>';
		imagefileTypes = imagefileTypes.replace(/\|/g, ",");
				
	});
	// uploadMediaFiles(fileUploadPath,allowFileTypes,fileMaxSize,uniId,isMultipleForm,isReloadPage,norefresh,imgload,checksection)
	//Note : Last parameter is to replace the inserted record's image src so imgLoad ==1
    uploadMediaFiles('<?php echo $promoImagePath;?>',imagefileTypes,'<?php echo $this->config->item('imagemaxSize');?>','<?php echo $browseImgJs;?>',1,1,1,1,'','<?php echo $imageExt;?>');
  
    <?php } else{ ?>
	var thumbImgPath='<?php  echo @$promoImagePath; ?>';
    $('#browsebtn<?php echo $browseImgJs;?>').click(function(){
				
		imagefileTypes = '<?php echo $this->config->item('imageAccept');?>';
		//imagefileTypes = imagefileTypes.replace(/\|/g, ",");
		
		var mediaType = $('#fileType').val();	
		
		if(mediaType == 2)
		{					
			thumbImgPath='<?php  echo @$videoPath; ?>images';									
		}
		
		if(mediaType == 3)
		{
			thumbImgPath='<?php  echo @$audioPath; ?>images';
		}
		
		if(mediaType == 4)
		{
			thumbImgPath='<?php  echo @$documentsPath; ?>images';
		}	
		// uploadMediaFiles(fileUploadPath,allowFileTypes,fileMaxSize,uniId,isMultipleForm,isReloadPage,norefresh,imgload,checksection)

	});
	uploadMediaFiles(thumbImgPath,imagefileTypes,'<?php echo $this->config->item('imagemaxSize');?>','<?php echo $browseImgJs;?>',1,1,0,1);
	//Note : Last parameter is to replace the inserted record's image src so imgLoad ==1
   
    //uploadMediaFiles('<?php echo $promoImagePath;?>',imagefileTypes,'<?php echo $this->config->item('imagemaxSize');?>','<?php echo $browseImgJs;?>',1,'promoMedia','galImg_<?php echo @$elementId;?>');
	<?php } ?>
    });
 
 </script>
                      
