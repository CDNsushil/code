<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$EMC='';
	$VFMC='active';
	$EUS='dn';
	$VFS='';
	$required=isset($required)?$required:'';
	$select_field=$required=='required'?'select_field':'';
	
	$browseId=isset($browseId)?$browseId:''; 
	
	$UFS=$EB=$UB='';
	if( $isEmbed =='t'){
		$EMC='active';
		$EB='';
		$EUS='';
		$VFMC='';
		$UB='dn';
		$VFS='dn';
		
	}else{
		$EMC='';
		$EB='';
		$EUS='dn';
		
		$VFMC='active';
		$UB='';
		$VFS='';
	}
	
	$isExternal = array(
		'name'	=> 'isExternal',
		'value'	=> $isEmbed,
		'id'	=> 'isExternal'.$browseId,
		'type'	=> 'hidden'
	);
	
	$fileNameInput = array(
		'name'	=> 'fileName',
		'value'	=> $fileName,
		'id'	=> 'fileName'.$browseId,
		'type'	=> 'hidden'
	);
	
	$fileSizeInput = array(
		'name'	=> 'fileSize',
		'value'	=> $fileMaxSize,
		'id'	=> 'fileSize'.$browseId,
		'type'	=> 'hidden'
	);
	
	$inputArray = array(
		'name'	=> 'fileInput',
		'class'	=> $class,
		'value'	=> '',
		'id'	=> 'fileInput'.$browseId,
		'type'	=> 'text',
		'readonly'	=> true
	);
	
	$embedArray = array(
		'id'	=> 'embedCode'.$browseId,
		'name'	=> 'embedCode',
		'class'	=> 'width546px rz embededURL '.$required,
		'rows' => 2,
		'cols' => 45,
		'value'=>html_entity_decode($embedCode)
	);
	//file type to get dynamically changed based on selection
	echo form_input($fileNameInput);
	echo form_input($fileSizeInput);
	echo form_input($isExternal);
	
	$allowedMediaType=str_replace('|',',',$this->config->item('videoAccept'));
	$allowedMediaType=str_replace(',',', ',$allowedMediaType);
?>

<div id="uploadFileByJquery<?php echo $browseId;?>"></div>
<div  class="row">
	<div class="label_wrapper cell">
	  <label class="<?php echo $select_field;?>"><?php echo $FieldHeading;?></label>
	</div>
<!--label_wrapper-->
	<div id="uploadFileSection<?php echo $browseId;?>" class="cell frm_element_wrapper">
		<div id="uploafFileButton<?php echo $browseId;?>" class="tds-button mr8 fl <?php echo $UB;?>"> <a id="uploadSelected<?php echo $browseId;?>" href="javascript:void(0)" onclick="isEmbed(0,'<?php echo $browseId;?>')" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="fileMenu<?php echo $browseId;?>" class="<?php echo $VFMC;?> gray_clr_hover"><?php echo $this->lang->line('upload');?></span></a> </div>
		<div id="embedButton<?php echo $browseId;?>" class="tds-button fl <?php echo $EB;?>"> <a id="embedSelected" href="javascript:void(0)" onclick="isEmbed(1,'<?php echo $browseId;?>')" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="embedMenu<?php echo $browseId;?>" class="<?php echo $EMC;?> dash_link_hover"><?php echo $this->lang->line('embed');?></span></a> </div>
		<div class="row seprator_8"></div>
		
		<div class="<?php echo $EUS;?>"  id="EmbeddedURL<?php echo $browseId;?>"> <?php echo form_textarea($embedArray); ?> </div>
		
		<div class="<?php echo $VFS;?>" id="Uploadvideo<?php echo $browseId;?>">
			<div id="FileUpload">
					<div class="fl"><?php echo form_input($inputArray); ?></div>
					<div class="tds-button fl btn_span_hover" id="browsebtn<?php echo $browseId;?>"> <a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></span></a></div>
					<div class="font_size11 row width500px"><div class="cell pr2"><?php echo $this->lang->line('allowedExt');?></div><div id="allowedMediaTypevideo" class="cell"><?php echo $allowedMediaType;?></div></div>					<div id="fileError<?php echo $browseId;?>" class="row wordcounter orange"></div>
					<!--<div class="pro_li_content fl pl20 mt5 mb5"><?php //echo $this->lang->line('fileSizeMSG'); ?></div>-->
			</div>
		</div>
		<div class="clear"></div>
		
	</div>
	<div class="seprator_5"></div>
</div>
