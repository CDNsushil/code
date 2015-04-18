<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$EMC='';
	$VFMC='orange';
	$EUS='dn';
	$VFS='';
	$required=isset($required)?$required:'';
	$isReloadPage=(isset($isReloadPage) && is_numeric($isReloadPage) && ($isReloadPage ==0))?0:1;
	$select_field=($required=='required')?'select_field':'';
	
	$editFlag=isset($editFlag)?$editFlag:false;

	$typeOfFile=isset($typeOfFile)?$typeOfFile:2; 
	$browseId=isset($browseId)?$browseId:'';
	$fileName=isset($fileName)?$fileName:''; 
	$isUploadEmbedOption=isset($isUploadEmbedOption)?$isUploadEmbedOption:true; 
	
	$imgSrc=(isset($imgSrc) && $imgSrc != '')?$imgSrc:base_url('images/profile_icon.png'); 
	
	$allowedMediaType=str_replace('|',',',$mediaFileTypes);
	$allowedMediaType=str_replace(',',', ',$allowedMediaType);
	
	$UFS=$EB=$EU=$UB=$UF='';
	if( $isEmbed =='t'){
		$EMC='orange';
		$VFMC='';
		$EUS='';
		$VFS='dn';
		if($editFlag){
			$UB=$UF='dn'; 
		}
	}else{
		
		if($editFlag){
			$UFS='dn';
			$EB=$EU='';
		}
	}
	$isExternalInput = array(
		'name'	=> 'isExternal'.$browseId,
		'value'	=> (isset($isEmbed) && $isEmbed=='t')?'t':'f',
		'id'	=> 'isExternal'.$browseId,
		'type'	=> 'hidden'
	);
	
	$fileNameInput = array(
		'name'	=> 'fileName'.$browseId,
		'value'	=> $fileName,
		'id'	=> 'fileName'.$browseId,
		'type'	=> 'hidden'
	);
	
	$fileSizeInput = array(
		'name'	=> 'fileSize'.$browseId,
		'value'	=> $fileSize,
		'id'	=> 'fileSize'.$browseId,
		'type'	=> 'hidden'
	);
	
	$typeOfFileInput = array(
		'name'	=> 'fileType'.$browseId,
		'value'	=> $typeOfFile,
		'id'	=> 'fileType'.$browseId,
		'type'	=> 'hidden'
	);
	
	if(isset($imgload) && $imgload==1)
	{
		$imgLoadClass = ' cell mt20';
		$inputWidth = 'width330px ';
		$browse_box="browse_box row";
	}
	else
	{
		$imgLoadClass = '';
		$inputWidth = 'width480px ';
		$browse_box="row";
	}
	
	$inputArray = array(
		'name'	=> 'fileInput'.$browseId,
		'class'	=> $inputWidth.$required,
		'value'	=> '',
		'id'	=> 'fileInput'.$browseId,
		'type'	=> 'text',
		'readonly'	=> true
	);
	
	$embedArray = array(
		'id'	=> 'embbededURL'.$browseId,
		'name'	=> 'embbededURL'.$browseId,
		'class'	=> 'width546px rz embededURL '.$required,
		'rows' => 2,
		'cols' => 45,
		'value'=>$embedCode
	);
	
	$fileUploadPathInput = array(
		'name'	=> 'fileUploadPath'.$browseId,
		'value'	=> $filePath,
		'id'	=> 'fileUploadPath'.$browseId,
		'type'	=> 'hidden'
	);

	echo form_input($fileNameInput);
	echo form_input($fileSizeInput);
	echo form_input($typeOfFileInput);
	echo form_input($isExternalInput);
	echo form_input($fileUploadPathInput);
	
	if(!isset($flag))$flag=0;
	if(isset($flag) && $flag==1)  $VFS='';
	
	$fpLen=strlen($filePath);
	if($fpLen > 0 && substr($filePath,-1) != '/'){
		$filePath=$filePath.'/';
	}
	
?>

<div id="uploadFileByJquery<?php echo $browseId;?>"></div>
<div id="FileContainer<?php echo $browseId;?>" class="fr">
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
<div id="uploadFileSection<?php echo $browseId;?>" class="row <?php echo $UFS;?>">
	<div class="label_wrapper cell">
	  <label class="<?php echo $select_field;?>"><?php echo $label;?></label>
	</div>
<!--label_wrapper-->
	<div class=" cell frm_element_wrapper">
		<div class="<?php echo $browse_box;?>">
		<?php
		if(isset($imgload) && $imgload==1){
		?>
			<div class="browse_thumb_wrapper  cell">
				<table width="100%"  height="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td><img id="galImg_<?php echo $browseId;?>" src="<?php echo $imgSrc;?>" class="ma backgroundBlack" id="<?php echo $browseId;?>promoImage"></td>
				  </tr>
				</table>
			</div><!--browse_thumb_wrapper-->
		<?php } ?>
		<?php if($flag==0){?>
			<?php if($isUploadEmbedOption){ ?>	
				<div id="uploafFileButton<?php echo $browseId;?>" class="tds-button mr8 fl <?php echo $UB;?> btn_span_hover"> <a id="uploadSelected<?php echo $browseId;?>" href="javascript:void(0)" onclick="hideShow('EmbeddedURL<?php echo $browseId;?>','Uploadvideo<?php echo $browseId;?>','embedMenu<?php echo $browseId;?>','fileMenu<?php echo $browseId;?>','isExternal<?php echo $browseId;?>','f'); " onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="fileMenu<?php echo $browseId;?>" class="<?php echo $VFMC;?>"><?php echo $this->lang->line('upload');?></span></a> </div>
				<div id="embedButton<?php echo $browseId;?>" class="tds-button fl <?php echo $EB;?> btn_span_hover"> <a id="embedSelected<?php echo $browseId;?>" href="javascript:void(0)" onclick="hideShow('Uploadvideo<?php echo $browseId;?>','EmbeddedURL<?php echo $browseId;?>','fileMenu<?php echo $browseId;?>','embedMenu<?php echo $browseId;?>','isExternal<?php echo $browseId;?>','t'); " onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="embedMenu<?php echo $browseId;?>" class="<?php echo $EMC;?>"><?php echo $this->lang->line('embed');?></span></a> </div>
				<div class="row seprator_8"></div>
				<div class="<?php echo $EUS;?> <?php echo $EU;?>"  id="EmbeddedURL<?php echo $browseId;?>"> <?php echo form_textarea($embedArray); ?> </div>
			<?php
			}else{
					echo '<div class="row seprator_8"></div>';
			}
		} ?>
		<div class="<?php echo $VFS;?> <?php echo $UF;?><?php echo $imgLoadClass;?>" id="Uploadvideo<?php echo $browseId;?>">
			<div id="FileUpload<?php echo $browseId;?>">
					<div class="fl"><?php echo form_input($inputArray); ?></div>					
					<div class="tds-button fl btn_span_hover <?php if(!isset($imgload) || $imgload==0) echo 'ml5';else echo '';?>" id="browsebtn<?php echo $browseId;?>"> <a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></span></a></div>
					<div class="font_size11 row width410px"><?php $mediaTypeToShow = $browseId.'TypeToShow';echo '<div class="cell pr2">'.$this->lang->line('allowedExt').'</div><div class="cell"  id="allowedMediaType'.$browseId.'">'.$allowedMediaType.'</div>';?></div>
					<div id="fileError<?php echo $browseId;?>" class="row wordcounter orange"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>  
	</div>
	<div class="seprator_5"></div>
	<div id="fileTypeRuntimeDiv<?php echo $browseId;?>"><input type="hidden" value="<?php echo $mediaFileTypes;?>" id="fileTypeRuntime<?php echo $browseId;?>" /></div>
	<script type="text/javascript">
		$(document).ready(function(){
			uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $fileMaxSize;?>','<?php echo $browseId;?>',1,'<?php echo $isReloadPage;?>',0,'<?php echo $imgload;?>','','_xs');
		});
	</script>
</div>
