<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$EMC='';
	$VFMC='orange';
	$EUS='dn';
	$VFS='';
	$required=isset($required)?$required:'';
	$select_field=$required=='required'?'select_field':'';
	
	$editFlag=isset($editFlag)?$editFlag:false;
	$fileTypeFlag=isset($fileTypeFlag)?$fileTypeFlag:false;
	
	$SFT=$fileTypeFlag?'':'dn';
	
	$typeOfFile=isset($typeOfFile)?$typeOfFile:2; 
	
	$allowedMediaType=str_replace('|',',',$fileType);
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
	
	$isExternal = array(
		'name'	=> 'isExternal',
		'value'	=> $isEmbed,
		'id'	=> 'isExternal',
		'type'	=> 'hidden'
	);
	
	$fileNameInput = array(
		'name'	=> 'fileName',
		'value'	=> $fileName,
		'id'	=> 'fileName',
		'type'	=> 'hidden'
	);
	
	$fileSizeInput = array(
		'name'	=> 'fileSize',
		'value'	=> $fileSize,
		'id'	=> 'fileSize',
		'type'	=> 'hidden'
	);
	
	
	
	$typeOfFileInput = array(
		'name'	=> 'fileType',
		'value'	=> $typeOfFile,
		'id'	=> 'fileType',
		'type'	=> 'hidden'
	);
	
	$inputArray = array(
		'name'	=> 'fileInput',
		'class'	=> 'width480px '.$required,
		'value'	=> '',
		'id'	=> 'fileInput',
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
	echo form_input($fileSizeInput);
	echo form_input($typeOfFileInput);
	echo form_input($isExternal);
	
	if(!isset($flag))$flag=0;
	if(isset($flag) && $flag==1)  $VFS='';
	
	//Media after save popup
	if(isset($mediaAddPopup) && !empty($mediaAddPopup)){
		$mediaAddPopupValue = 1;
	}else{
		$mediaAddPopupValue = 0;
	}
?>
<div id="uploadFileByJquery"></div>
<div id="uploadFileSection" class="row <?php echo $UFS;?>">
	<div class="label_wrapper cell">
	  <label class="<?php echo $select_field;?>"><?php echo $label;?></label>
	</div>
<!--label_wrapper-->
	<div class=" cell frm_element_wrapper">
		<?php if($flag==0){?>
			<div id="selectFileTypeDiv" class="fl width420px <?php echo $SFT;?> pt5">
				<?php
					$SFT1=($typeOfFile=='audio visual' || $typeOfFile=='video' || $typeOfFile==2)?'checked':'';
					$SFT2=($typeOfFile=='audio' || $typeOfFile==3)?'checked':'';
					$SFT3=($typeOfFile=='text' || $typeOfFile==4)?'checked':'';
				?>
				<div class="cell defaultP" >
				  <input type="radio" id="selectFileType1" name="selectFileType"  class="selectFileType" value="2" <?php echo $SFT1;?>  />
				</div>
				
				<div class="cell mr8">
				  <label class="lH25"><?php echo $this->lang->line('audioVisual');?></label>
				</div>
				
				<div class="cell defaultP " >
					<input type="radio" id="selectFileType2" name="selectFileType" class="selectFileType"  value="3" <?php echo $SFT2;?> />
				</div>
				
				<div class="cell mr8">
				  <label class="lH25"><?php echo $this->lang->line('audio');?></label>
				</div>
				
				<div class="cell defaultP" >
					<input type="radio" id="selectFileType3" name="selectFileType" class="selectFileType"  value="4" <?php echo $SFT3;?> />
				</div>
				
				<div class="cell mr8">
				  <label class="lH25"><?php echo $this->lang->line('text');?></label>
				</div>
			</div>
			<div id="uploafFileButton" class="tds-button mr_8 fl <?php echo $UB;?>"> <a id="uploadSelected" href="javascript:void(0)" onclick="hideShow('EmbeddedURL','Uploadvideo','embedMenu','fileMenu','isExternal','f'); uploadMathod(this)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="fileMenu" class="<?php echo $VFMC;?>"><?php echo $this->lang->line('upload');?></span></a> </div>
			<?php //if(isset($projSellType) && isset($sellPriceType) && $projSellType!=2 && $sellPriceType!=1) {?>
			<div id="embedButton" class="tds-button fl <?php echo $EB;?>"> <a id="embedSelected" href="javascript:void(0)" onclick="hideShow('Uploadvideo','EmbeddedURL','fileMenu','embedMenu','isExternal','t'); uploadMathod(this)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="embedMenu" class="<?php echo $EMC;?>"><?php echo $this->lang->line('embed');?></span></a> </div>
			<?php //}?>
			<div class="row seprator_8"></div>
			<div class="<?php echo $EUS;?> <?php echo $EU;?>" id="EmbeddedURL"> <?php echo form_textarea($embedArray); ?> </div>
			
			<?php 
		} ?>
		<div class="<?php echo $VFS;?> <?php echo $UF;?>" id="Uploadvideo">
			<div id="FileUpload">
					<div class="fl"><?php echo form_input($inputArray); ?></div>
					<div class="tds-button fl ml5" id="browsebtn"> <a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></span></a></div>
					<div class="font_size11 row">
						<?php $mediaTypeToShow = $typeOfFile.'TypeToShow'; 
							echo '<div class="cell pr2">'.$this->lang->line('allowedExt').'</div><div class="cell"  id="allowedMediaType">'.$allowedMediaType.'</div>';?>
						</div>
					<div id="fileError" class="row wordcounter orange"></div>
					<?php /* if(!($typeOfFile == 'image' || $typeOfFile==1)){?>
						<div class="fl mt5 mb5"><?php echo $this->load->view('common/desktopAppMsg');?></div>
					<?php } */?>
			</div>
		</div>
		<div class="seprator_5"></div>
	</div>
</div>
<div id="fileTypeRuntimeDiv">
<input type="hidden" value="<?php echo $fileType;?>" id="fileTypeRuntime" />
</div>
<script type="text/javascript">
		$(document).ready(function(){
			$('.selectFileType').click(function(){
				$('#fileError').html('');
				var typeValue=$(this).val();
				var typeValueCurrent=$('#fileType').val();
				if(typeValueCurrent != typeValue){
					$('#fileName').val('');
					$('#fileInput').val('');
					$('#fileSize').val('');
					$('#fileType').val(typeValue);
					if(typeValue=='audio' || typeValue==3){
						$('#fileLengthDiv').show();
						$('#wordCountDiv').hide();
						$('#fileLengthLabel').html('Length');
						$('#allowedMediaType').html('<?php echo $this->config->item('audioType');?>');
						$('#fileTypeRuntime').val('<?php echo $this->config->item('audioType');?>');
					}else if(typeValue=='video' || typeValue==2){
						$('#fileLengthDiv').show();
						$('#wordCountDiv').hide();
						$('#fileLengthLabel').html('Duration');
						$('#allowedMediaType').html('<?php echo $this->config->item('videoType');?>');
						$('#fileTypeRuntime').val('<?php echo $this->config->item('videoType');?>');
					}else if(typeValue=='text' || typeValue==4){
						$('#fileLengthDiv').hide();
						$('#wordCountDiv').show();
						$('#allowedMediaType').html('<?php echo $this->config->item('writtenMaterialAccept');?>');
						$('#fileTypeRuntime').val('<?php echo $this->config->item('writtenMaterialAccept');?>');
					}
				}
				$('label.error').hide();
			});
				uploadMediaFiles('<?php echo $filePath;?>','<?php echo $fileType;?>','<?php echo $fileMaxSize;?>','',0,1);
			
		});
</script>
