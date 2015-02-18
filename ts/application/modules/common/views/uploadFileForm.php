<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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
		'id'	=> 'isExternal'.@$browseId,
		'type'	=> 'hidden'
	);
	
	$fileNameInput = array(
		'name'	=> 'fileName',
		'value'	=> $fileName,
		'id'	=> 'fileName'.@$browseId,
		'type'	=> 'hidden'
	);
	
	$fileSizeInput = array(
		'name'	=> 'fileSize',
		'value'	=> $fileMaxSize,
		'id'	=> 'fileSize'.@$browseId,
		'type'	=> 'hidden'
	);
	
	
	
	$typeOfFileInput = array(
		'name'	=> 'fileType',
		'value'	=> $typeOfFile,
		'id'	=> 'fileType',
		'type'	=> 'hidden'
	);
	
	if(isset($imgload) && $imgload==1){
		$imgLoadClass = "cell mt40 ";
		$inputWidth = 'width330px ';
	}
	else{
		$imgLoadClass = "";
		//$imgLoadClass = "browse_button_wrapper";
		$inputWidth = 'width480px ';
	}
	$inputArray = array(
		'name'	=> 'fileInput',
		'class'	=> $inputWidth.$required,
		'value'	=> '',
		'id'	=> 'fileInput'.@$browseId,
		'type'	=> 'text',
		'readonly'	=> true
	);
	
	$embedArray = array(
		'id'	=> 'embbededURL'.@$browseId,
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
	//echo 'sdjhjksdghbrowseId:'.$browseId.$typeOfFile;
?>

<div id="uploadFileByJquery<?php echo @$browseId;?>"></div>
<div id="uploadFileSection" class="row <?php echo $UFS;?>">
	<div class="label_wrapper cell">
	  <label class="<?php echo $select_field;?>"><?php echo $label;?></label>
	</div>
<!--label_wrapper-->
	<div class=" cell frm_element_wrapper  mb10">
		<?php
		if(isset($imgload) && $imgload==1){
		?>
		
		<div class="browse_box row">
		<div class="browse_thumb_wrapper cell">
				<table width="100%"  height="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td><img src="<?php echo getImage('no_images.jpg');?>"  class="ma" id="promoImage"></td>
				  </tr>
				</table>
			</div><!--browse_thumb_wrapper-->
		
		<?php } ?>
		<?php if($flag==0){?>
		<div id="selectFileTypeDiv" class="fl width420px <?php echo $SFT;?> pt5">
					<?php
						$SFT1=($typeOfFile=='audio visual' || $typeOfFile=='video')?'checked':'';
						$SFT2=$typeOfFile=='audio'?'checked':'';
						$SFT3=$typeOfFile=='text'?'checked':'';
					?>
					<div class="cell defaultP" >
					  <input type="radio" id="selectFileType1" name="selectFileType"  class="selectFileType" value="video" <?php echo $SFT1;?>  />
					</div>
					
					<div class="cell mr8">
					  <label class="lH25"><?php echo $this->lang->line('audioVisual');?></label>
					</div>
					
					<div class="cell defaultP " >
						<input type="radio" id="selectFileType2" name="selectFileType" class="selectFileType" checked  value="audio" <?php echo $SFT2;?> />
					</div>
					
					<div class="cell mr8">
					  <label class="lH25"><?php echo $this->lang->line('audio');?></label>
					</div>
					
					<div class="cell defaultP" >
						<input type="radio" id="selectFileType3" name="selectFileType" class="selectFileType" checked  value="text" <?php echo $SFT3;?> />
					</div>
					
					<div class="cell mr8">
					  <label class="lH25"><?php echo $this->lang->line('text');?></label>
					</div>
			</div>
			<div id="uploafFileButton" class="tds-button mr8 fl <?php echo $UB;?>"> <a id="uploadSelected" href="javascript:void(0)" onclick="hideShow('EmbeddedURL','Uploadvideo<?php echo @$browseId;?>','embedMenu','fileMenu','isExternal','f'); uploadMathod(this)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="fileMenu" class="<?php echo $VFMC;?>"><?php echo $this->lang->line('upload');?></span></a> </div>
			<div id="embedButton" class="tds-button fl <?php echo $EB;?>"> <a id="embedSelected" href="javascript:void(0)" onclick="hideShow('Uploadvideo<?php echo @$browseId;?>','EmbeddedURL','fileMenu','embedMenu','isExternal','t'); uploadMathod(this)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="embedMenu" class="<?php echo $EMC;?>"><?php echo $this->lang->line('embed');?></span></a> </div>
			<div class="row seprator_8"></div>
			<div class="<?php echo $EUS;?> <?php echo $EU;?>"  id="EmbeddedURL"> <?php echo form_textarea($embedArray); ?> </div>
			
			<?php 
		} ?>
		<div class="<?php echo $VFS;?> <?php echo $UF;?><?php echo $imgLoadClass;?>" id="Uploadvideo<?php echo @$browseId;?>">
			<div>
			<div id="FileUpload">
				<div class="fl"><?php echo form_input($inputArray); ?></div>
				<div class="tds-button fl <?php if(!isset($imgload) || $imgload==0) echo 'ml5';else echo '';?>" id="browsebtn<?php echo @$browseId;?>"> <a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></span></a></div>
				<div class="font_size11 row"><?php $mediaTypeToShow = @$mediaTypeToShow.'TypeToShow';echo $this->lang->line('allowedExt').'&nbsp;'.$this->config->item($mediaTypeToShow);?></div>
				<div id="fileError<?php echo @$browseId;?>" class="row wordcounter orange"></div>
				<?php /*if(!($typeOfFile == 'image' || $typeOfFile==1)){?>
					<div class="fl mt5 mb5"><?php echo $this->load->view('common/desktopAppMsg');?></div>
				<?php 
				} */?>
			</div>
			</div>
		</div>
		<div class="clear"></div>  
	</div>
	<?php
		if(isset($imgload) && $imgload==1) echo '</div>';
	?><div class="seprator_5"></div>
</div>
<?php if(@$nouploader!=0) { ?>
<script type="text/javascript">
$(document).ready(function(){
			
			/*if($('#availableRemainingSpace')){
				fileMaxSize=$('#availableRemainingSpace').val();
			}else{
				fileMaxSize='<?php echo $fileMaxSize;?>';
			}*/
			fileMaxSize = '<?php echo $fileMaxSize;?>';
			fileTypes<?php echo @$browseId;?> = '<?php echo $fileType;?>';

			$('#browsebtn<?php echo @$browseId;?>').click(function(){		
				var fileTypes<?php echo @$browseId;?> = '<?php echo $fileType;?>';
				//alert('<?php echo $fileType;?>'+'<?php echo $filePath;?>');
				fileTypes<?php echo @$browseId;?> = fileTypes<?php echo @$browseId;?>.replace(/\|/g, ",");		
			});
			//alert(fileTypes<?php echo @$browseId;?>);
			
	<?php  if(!isset($imgload) && (@$imgload=='')){ ?>
	
	//Note : Last parameter is to replace the inserted record's image src so imgload ==1
			uploadMediaFiles('<?php echo $filePath;?>',fileTypes<?php echo @$browseId;?>,fileMaxSize,'<?php echo @$browseId;?>',1,1,1,0);
	<?php }else { ?>
	//alert('I am here <?php echo @$browseId;?>');
			uploadMediaFiles('<?php echo $filePath;?>',fileTypes<?php echo @$browseId;?>,fileMaxSize,'<?php echo @$browseId;?>',0,1,1,'<?php echo @$imgload;?>');
	<?php } ?>
});
		
		//alert('path'+'<?php echo $filePath; ?>');
</script>
<?php } ?>
