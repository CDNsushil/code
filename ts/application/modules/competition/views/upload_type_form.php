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


	$fileHeightInput = array(
		'name'	=> 'fileHeight',
		'id'	=> 'fileHeight',	
		'class'	=> 'width178px number ',
		'value'	=> '',
		'maxlength'	=> 10,
		'size'	=> 50,
		
		
	);		

	$fileWidthInput = array(
		'name'	=> 'fileWidth',
		'id'	=> 'fileWidth',	
		'class'	=> 'width178px number ',
		'value'	=> '',
		'maxlength'	=> 10,
		'size'	=> 50,
	);

	$wordCountInput = array(
		'name'	=> 'wordCount',
		'id'	=> 'wordCount',	
		'class'	=> 'width178px numberGreaterZero',
		'value'	=> '',
		'maxlength'	=> 11
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
	$fileTypeFlag=isset($fileTypeFlag)?$fileTypeFlag:false;
	$SFT=$fileTypeFlag?'':'dn';
	
	$hhList=numbersList($startFrom=0, $Upto=23, $interval=1);
	$mmList=$ssList=numbersList($startFrom=0, $Upto=59, $interval=1);	
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
			<?php if($flag==0){
				if($fileTypeFlag){ ?>
					<div id="selectFileTypeDiv<?php echo $browseId?>" class="fl width420px <?php echo $SFT;?> pt5">
						<?php
							$SFT1=($typeOfFile=='audio visual' || $typeOfFile=='video' || $typeOfFile==2)?'checked':'';
							$SFT2=($typeOfFile=='audio' || $typeOfFile==3)?'checked':'';
							$SFT3=($typeOfFile=='text' || $typeOfFile==4)?'checked':'';
							$SFT4=($typeOfFile=='image' || $typeOfFile==1)?'checked':'';
						?>
						<div class="cell defaultP" >
						  <input type="radio" id="selectFileType1<?php echo $browseId?>" name="selectFileType<?php echo $browseId?>"  onclick="selectedFileTypeShow('2');" class="selectFileType" value="2" <?php echo $SFT1;?>  />
						</div>
						
						<div class="cell mr8">
						  <label class="lH25"><?php echo $this->lang->line('audioVisual');?></label>
						</div>
						
						<div class="cell defaultP " >
							<input type="radio" id="selectFileType2<?php echo $browseId?>" name="selectFileType<?php echo $browseId?>" onclick="selectedFileTypeShow('3');"  class="selectFileType"  value="3" <?php echo $SFT2;?>  />
						</div>
						
						<div class="cell mr8">
						  <label class="lH25"><?php echo $this->lang->line('audio');?></label>
						</div>
						
						<div class="cell defaultP " >
							<input type="radio" id="selectFileType3<?php echo $browseId?>" name="selectFileType<?php echo $browseId?>" onclick="selectedFileTypeShow('1');"  class="selectFileType"  value="1" <?php echo $SFT4;?> />
						</div>
						
						<div class="cell mr8">
						  <label class="lH25"><?php echo $this->lang->line('image');?></label>
						</div>
						
						<div class="cell defaultP" >
							<input type="radio" id="selectFileType4<?php echo $browseId?>" name="selectFileType<?php echo $browseId?>" onclick="selectedFileTypeShow('4');"  class="selectFileType" value="4" <?php echo $SFT3;?> />
						</div>
						
						<div class="cell mr8">
						  <label class="lH25"><?php echo $this->lang->line('text');?></label>
						</div>
					</div>
					<div id="fileTypeRuntimeDiv<?php echo $browseId?>"><input type="hidden" value="<?php echo $mediaFileTypes;?>" id="fileTypeRuntime<?php echo $browseId?>" /></div>
					<?php 
				}
				if($isUploadEmbedOption){ ?>	
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
						<div class="font_size11 row width100percent"><?php $mediaTypeToShow = $browseId.'TypeToShow';echo '<div class="cell pr2">'.$this->lang->line('allowedExt').'</div><div class="cell"  id="allowedMediaType'.$browseId.'">'.$allowedMediaType.'</div>';?></div>
						<div class="font_size11 row width100percent">* The maximum size of en entry is 250 MB before the entrant will have to pay for Extra Space or embed the file rather than upload it.</div>
						<div id="fileError<?php echo $browseId;?>" class="row wordcounter orange"></div>
				</div>
				<div id="rawFileNameDiv<?php echo $browseId;?>"></div>
			</div>
			<div class="clear"></div>
		</div>  
	</div>
	
	<div class="seprator_5"></div>
	
	<div id="fileTypeRuntimeDiv<?php echo $browseId;?>"><input type="hidden" value="<?php echo $mediaFileTypes;?>" id="fileTypeRuntime<?php echo $browseId;?>" /></div>
</div>

<div id="fileLengthDiv<?php echo $browseId;?>" class="row ">
	<div class="label_wrapper cell">
	  <label id="fileLengthLabel<?php echo $browseId;?>">Duration</label>
	</div>
	<!--label_wrapper-->
	<div class=" cell frm_element_wrapper">
		<div class="row">
			<div class="cell">
				<div class="row pr">
					<?php echo form_dropdown('hh', $hhList, '00','id="hh" class="width80px l0px"');?>
				</div>
				<div class="greyMsg pt5 pl15">HH</div>
			</div>
			<div class="cell pr">
				<div class="row pr">
					<?php echo form_dropdown('mm', $mmList, '00','id="mm" class="width80px l0px"');?>
				</div>
				<div class="greyMsg pt5 pl15">MM</div>
			</div>
			<div class="cell pr">
				<div class="row pr">
					<?php echo form_dropdown('ss', $ssList, '00','id="ss" class="width80px l0px"');?>
				</div>
				<div class="greyMsg pt5 pl15">SS</div>
				
			</div>
		</div>
		
		<div class="row wordcounter"></div>
		<div class="seprator_5"></div>
	</div>
</div>
			

<div id="dimensionsDiv<?php echo $browseId;?>" class="row dn">
	<div class="label_wrapper cell">
	  <label>Dimensions</label>
	</div>
	<!--label_wrapper-->
	<div class=" cell frm_element_wrapper">
		<div class="cell">
			<?php echo form_input($fileHeightInput);  ?>												
		</div>	                                             
		<div class="cell ml20 mr20 mt5"> X </div>											 
		<div class="cell">
				 <?php echo form_input($fileWidthInput); ?>												 
		</div>
		<div class="cell ml15">
			<div class="small_select_wp_a">														
				<select id="fileUnit" name="fileUnit" class="width_122" onchange="checkUnit()" title="<?php echo $this->lang->line('requiredmSg');?>">
					<option value=""><?php echo $this->lang->line('selectUnits');?></option>
					<option value="px"><?php echo $this->lang->line('pixels');?></option>                                                            															
					<option value="mm"><?php echo $this->lang->line('millimeters');?></option>
					<option value="inch"><?php echo $this->lang->line('inch');?></option>
				</select>
				<div id="fileUnitError" class="dn error"><?php echo $this->lang->line('requiredmSg');?></div>
			</div>
		</div>
	<div class="clear"></div>
	<div class="seprator_13"></div>
	</div>
</div>
<div id="wordCountDiv<?php echo $browseId;?>" class="row dn">
	<div class="label_wrapper cell">
	  <label id="changeItAccFile"><?php echo $this->lang->line('wordCount');?></label>
	</div>
	<div class=" cell frm_element_wrapper pt3 ">
	  <?php 
	  echo form_input($wordCountInput);?>
	</div>
</div>
<script type="text/javascript">
	
		function selectedFileTypeShow(typeValue){
			var browseId = '<?php echo $browseId;?>';
			$('#fileError'+browseId).html('');
			//var typeValue=$(this).val();
			var typeValueCurrent=$('#fileType'+browseId).val();
			if(typeValueCurrent != typeValue){
				
				$('#fileLengthDiv'+browseId).hide();
				$('#wordCountDiv'+browseId).hide();
				$('#dimensionsDiv'+browseId).hide();
				
				$('#fileName'+browseId).val('');
				$('#fileInput'+browseId).val('');
				$('#fileSize'+browseId).val('');
				$('#fileType'+browseId).val(typeValue);
				if(typeValue=='audio' || typeValue==3){
					$('#fileLengthDiv'+browseId).show();
					$('#fileLengthLabel'+browseId).html('Length');
					$('#allowedMediaType'+browseId).html('<?php echo $this->config->item('audioType');?>');
					$('#fileTypeRuntime'+browseId).val('<?php echo $this->config->item('audioType');?>');
				}else if(typeValue=='video' || typeValue==2){
					$('#fileLengthDiv'+browseId).show();
					$('#fileLengthLabel'+browseId).html('Duration');
					$('#allowedMediaType'+browseId).html('<?php echo $this->config->item('videoType');?>');
					$('#fileTypeRuntime'+browseId).val('<?php echo $this->config->item('videoType');?>');
				}else if(typeValue=='text' || typeValue==4){
					$('#wordCountDiv'+browseId).show();
					$('#allowedMediaType'+browseId).html('<?php echo $this->config->item('competitionMediaAcceptText');?>');
					$('#fileTypeRuntime'+browseId).val('<?php echo $this->config->item('competitionMediaAcceptText');?>');
				}else if(typeValue=='image' || typeValue==1){
					$('#dimensionsDiv'+browseId).show();
					$('#allowedMediaType'+browseId).html('<?php echo $this->config->item('imageType');?>');
					$('#fileTypeRuntime'+browseId).val('<?php echo $this->config->item('imageType');?>');
				}
			}
			$('label.error').hide();
		}
		
		uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $fileMaxSize;?>','<?php echo $browseId;?>',1,'<?php echo $isReloadPage;?>',0,'<?php echo $imgload;?>','','_xs');
	
</script>
