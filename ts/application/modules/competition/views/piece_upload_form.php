<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$EMC='';
	$VFMC='black';
	$EUS='dn';
	$VFS='';
	$required=isset($required)?$required:'';
	$select_field=$required=='required'?'select_field':'';
	
	$editFlag=isset($editFlag)?$editFlag:false;

	$browseId=isset($browseId)?$browseId:'';
	$fileName=isset($fileName)?$fileName:''; 
	
	$allowedMediaType=str_replace('|',',',$mediaFileTypes);
	$allowedMediaType=str_replace(',',', ',$allowedMediaType);
	
	$UFS=$EB=$EU=$UB=$UF='';
	if( $isEmbed =='t'){
		$EMC='black';
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
	
	$fileUploadPathInput = array(
		'name'	=> 'fileUploadPath'.$browseId,
		'value'	=> $filePath,
		'id'	=> 'fileUploadPath'.$browseId,
		'type'	=> 'hidden'
	);

	echo form_input($fileNameInput);
	echo form_input($fileSizeInput);
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
		<div class="<?php echo $VFS;?> <?php echo $UF;?><?php echo $imgLoadClass;?>" id="Uploadvideo<?php echo $browseId;?>">
			<div id="FileUpload<?php echo $browseId;?>">
					<div class="fl"><?php echo form_input($inputArray); ?></div>					
					<div class="tds-button fl btn_span_hover <?php if(!isset($imgload) || $imgload==0) echo 'ml5';else echo '';?>" id="browsebtn<?php echo $browseId;?>"> <a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></span></a></div>
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
			uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $fileMaxSize;?>','<?php echo $browseId;?>',1,1,0,'<?php echo $imgload;?>','','_xs');
		});
	</script>
</div>
