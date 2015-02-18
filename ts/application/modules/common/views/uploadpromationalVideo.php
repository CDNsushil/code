<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	$browseId=@$browseId?$browseId:'';
	$EMC='';
	$VFMC='black';
	$EUS='dn';
	$VFS='';
	$required=@$required?'required':'';
	$select_field=$required=='required'?'select_field':'';
	
	$editFlag=@$editFlag?true:false;
	$fileTypeFlag=@$fileTypeFlag?true:false;
	
	$SFT=$fileTypeFlag?'':'dn';
	
	
	
	$typeOfFile=isset($typeOfFile)?$typeOfFile:2; 
	
	
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
	
	$isExternal = array(
		'name'	=> 'isExternal',
		'value'	=> $isEmbed,
		'id'	=> 'isExternal',
		'type'	=> 'hidden'
	);
	
	$fileNameInput = array(
		'name'	=> 'fileName'.$browseId,
		'value'	=> $fileName,
		'id'	=> 'fileName'.$browseId,
		'type'	=> 'hidden'
	);
	
	$fileSize = array(
		'name'	=> 'fileSize'.$browseId,
		'value'	=> $fileSize,
		'id'	=> 'fileSize'.$browseId,
		'type'	=> 'hidden'
	);
	
	
	
	$inputArray = array(
		'name'	=> 'fileInput'.$browseId,
		'class'	=> 'width480px '.$required,
		'value'	=> '',
		'id'	=> 'fileInput'.$browseId,
		'type'	=> 'text',
		'readonly'	=> true
	);
	
	$embedArray = array(
		'id'	=> 'embbededURL',
		'name'	=> 'embbededURL',
		'class'	=> 'width546px rz embededURL '.$required,
		'rows' => 2,
		'cols' => 45,
		'value'=>$embedCode
	);
	//file type to get dynamically changed based on selection
	echo form_input($fileNameInput);
	echo form_input($fileSize);
	echo form_input($isExternal);
	if(!isset($flag))$flag=0;
	if(isset($flag) && $flag==1)  $VFS='';
?>


<div id="uploadFileSection" class="row <?php echo $UFS;?>">
	<div class="label_wrapper cell">
	  <label class="<?php echo $select_field;?>"><?php echo $label;?></label>
	</div>
<!--label_wrapper-->
	<div class=" cell frm_element_wrapper">
		
			<div id="uploadFileButton" class="tds-button mr8 fl <?php echo $UB;?>"> <a id="uploadSelected" href="javascript:void(0)" onclick="hideShow('EmbeddedURL','Uploadvideo','embedMenu','fileMenu','isExternal','f'); uploadMathod(this)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="fileMenu" class="<?php echo $VFMC;?>"><?php echo $this->lang->line('upload');?></span></a> </div>
			<div id="embedButton" class="tds-button fl <?php echo $EB;?>"> <a id="embedSelected" href="javascript:void(0)" onclick="hideShow('Uploadvideo','EmbeddedURL','fileMenu','embedMenu','isExternal','t'); uploadMathod(this)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="embedMenu" class="<?php echo $EMC;?>"><?php echo $this->lang->line('embed');?></span></a> </div>
			<div class="row seprator_8"></div>
			<div class="<?php echo $EUS;?> <?php echo $EU;?>"  id="EmbeddedURL"> <?php echo form_textarea($embedArray); ?> </div>
		
		
					<div class="<?php echo $VFS;?> <?php echo $UF;?>" id="Uploadvideo<?php echo $browseId; ?>">
						
						<div id="FileUpload<?php echo $browseId; ?>">
								<div class="fl"><?php echo form_input($inputArray); ?></div>
								<div  class="tds-button fl ml5" id="browsebtn<?php echo $browseId; ?>"> <a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></span></a></div>
								<div id="fileError<?php echo $browseId; ?>" class="row wordcounter orange"></div>
								<div class="pro_li_content fl pl20 mt5 mb5"><?php echo $this->lang->line('fileSizeMSG'); ?></div>
						</div>
						
					</div>
		<div class="seprator_5"></div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#browsebtn_video').click(function(){
			
			fileTypes = '<?php echo $fileType;?>';
			fileTypes = fileTypes.replace(/\|/g, ",");
			
		});
		
		uploadMediaFiles('<?php echo $filePath;?>',fileTypes,'<?php echo $fileMaxSize;?>','<?php echo $browseId;?>',0);
	});
	
	function uploadMathod(obj){
		
		var Id = $(obj).attr('id');
		
		if(Id == 'uploadSelected'){
			if($('#isExternal').val()=='f'){
				if('#Uploadvideo<?php echo $browseId; ?>'){
					$('#Uploadvideo<?php echo $browseId; ?>').show();
				}
			}
		}else{
			if('#Uploadvideo<?php echo $browseId; ?>'){
				$('#Uploadvideo<?php echo $browseId; ?>').hide();
			}
		}
	}
</script>
