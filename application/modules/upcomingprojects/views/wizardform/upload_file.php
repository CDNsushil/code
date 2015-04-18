<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$fileSize           =   0;   
$filePath           =   ( $browseId == 1 ) ? $dirUploadImage : $dirUploadMedia;
$imgload            =   0;    
$fileName           =   ''; 
$allowedMediaType   =   str_replace(',',', ',$this->config->item($fileType.'Type'));
$mediaFileTypes     =   $this->config->item($fileType.'Accept');
$mediaSize          =   $this->config->item($fileType.'Size');
$fileNameInput = array(
	'name'	=> 'fileName'.$browseId,
	'value'	=> $fileName,
	'id'	=> 'fileName'.$browseId,
	'type'	=> 'hidden',
);
    
$fileSizeInput = array(
	'name'	=> 'fileSize'.$browseId,
	'value'	=> $fileSize,
	'id'	=> 'fileSize'.$browseId,
	'type'	=> 'hidden'
);

$typeOfFileInput = array(
	'name'	=> 'fileType'.$browseId,
	'value'	=> 1,
	'id'	=> 'fileType'.$browseId,
	'type'	=> 'hidden'
);

$inputArray = array(
	'name'	=> 'fileInput'.$browseId,
	'class'	=> 'fl width472 pb8 bdr_adadad p10 mt0',
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

$fileErrorInput = array(
	'name'	=> 'fileErrorInput'.$browseId,
	'value'	=> '0',
	'id'	=> 'fileErrorInput'.$browseId,
	'type'	=> 'hidden'
);

$browseIdField = array(
	'name'	=> 'browseId',
	'value'	=> $browseId,
	'id'	=> 'browseId',
	'type'	=> 'hidden'
);

echo form_input($fileNameInput);
echo form_input($fileSizeInput);
echo form_input($typeOfFileInput);
echo form_input($fileUploadPathInput);
echo form_input($fileErrorInput);
echo form_input($browseIdField); 

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
	
	<div class="input_box" id="uploadFileSection<?php echo $browseId;?>" >
		<div>
			<div class="<?php echo $VFS;?> <?php echo $UF;?><?php echo $imgLoadClass;?>" id="Uploadvideo<?php echo $browseId;?>">
				<div id="FileUpload<?php echo $browseId;?>">
					<?php echo form_input($inputArray); ?>
					<div id="browsebtn<?php echo $browseId;?>" class="fileUpload fr btn btn-primary fs11 ml18 fshel_bold text_alighC bg_dfdfdf bdr_adadad p14 width88"> 
						<span><?php echo $this->lang->line('uploadStage_browse'); ?></span>
						<input id="uploadBtn" type="button" class="upload" />
					</div>
					<div id="fileError<?php echo $browseId;?>" class="validation_error pt5"></div>
				</div>
				<div id="rawFileNameDiv<?php echo $browseId;?>"></div>
			</div>
		</div>  
		<div id="fileTypeRuntimeDiv<?php echo $browseId;?>">
			<input type="hidden" value="<?php echo $mediaFileTypes;?>" id="fileTypeRuntime<?php echo $browseId;?>" />
		</div>
	</div>

	<div class="sap_25"></div> 
	<ul class="org_list pt0">
		<li class="icon_2 pt0">Accepted File Types: <?php echo $allowedMediaType;?>.</li>
	</ul>

<script>
	//call upload method for files uploading
    uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $mediaSize;?>','<?php echo $browseId;?>',1,1,0,'<?php echo $imgload;?>','','_xs','1','<?php echo  $nextUrl; ?>');
</script>
