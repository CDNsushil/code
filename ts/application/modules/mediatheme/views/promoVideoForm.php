<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$EMC='black';
	$VFMC='';
	$EUS='dn';
	$VFS='';
	//echo '<pre />';
	//print_r($inputArray);
	//echo '<br />';
	//print_r($uploadArray);
	if( $videoType ==0) 
	{
		$EUS='';
		$VFS='dn';
		$EMC='black';
		$VFMC='';
		
	}
	else  {
		$EUS='dn';
		$VFS='';
		$EMC='';
		$VFMC='black';
		
	}

	if(strcmp($browseId,'_interview')==0)
	{
		$isExternalId = 'uploadInterviewType';
		$isExternal = array(
			'name'	=> 'uploadInterviewType',
			'value'	=> $videoType,
			'id'	=> 'uploadInterviewType',
			'type'	=> 'hidden'
		);
	}
	
	if(strcmp($browseId,'_introductory')==0)
	{
		$isExternalId = 'uploadIntroductoryType';
		$isExternal = array(
			'name'	=> 'uploadIntroductoryType',
			'value'	=> $videoType,
			'id'	=> 'uploadIntroductoryType',
			'type'	=> 'hidden'
		);
	}
	
	$fileNameInput = array(
		'name'	=> 'fileName'.$browseId,
		'value'	=> '',
		'id'	=> 'fileName'.$browseId,
		'type'	=> 'hidden'
	);
	
	$fileSize = array(
		'name'	=> 'fileSize'.$browseId,
		'value'	=> '',
		'id'	=> 'fileSize'.$browseId,
		'type'	=> 'hidden'
	);
		echo form_input($fileNameInput);
		echo form_input($isExternal);
		echo form_input($fileSize);
		
		
		
	?>
	<div id="FileContainer<?php echo @$browseId;?>" class="fr">
				<div class="fileInfo" id="fileInfo<?php echo @$browseId;?>">
					<div id="progressBar<?php echo @$browseId;?>" class="plupload_progress">
						<div class="progressBar_msg fl"><?php echo $this->lang->line('fileUploading');?></div>
						<div class="plupload_progress_container fl"><div id="plupload_progress_bar<?php echo @$browseId;?>" class="plupload_progress_bar"></div></div></div><span id="percentComplete<?php echo @$browseId;?>" class="percentComplete fl"></span>
				</div>
				<div id="dropArea<?php echo @$browseId;?>"></div>				
		</div>	
<div class="clear"></div>
<div class="row">
	<?php 
	if(@$videoLabel!="")
		$bgNone='';
	else
		$bgNone='bg_none';
	?>
	
	<div class="row">
		<div class="label_wrapper cell">
		<label class="select_field"><?php echo 'Titless';?></label>
		</div>
		<!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
		<?php echo form_input($title); ?>
		<div class="row wordcounter"><?php echo form_error($title['name']); ?></div>
		</div>
   </div>
   
   <div class="row">
		<div class="label_wrapper cell">
		<label class="select_field"><?php echo 'Description';?></label>
		</div>
		<!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
		<?php echo form_textarea($description); ?>
		
		</div>
   </div>
   
   
   
								  
	<div class="label_wrapper cell <?php echo $bgNone;?>">
	<?php
		if(@$videoLabel!=""){ ?>
	
		
		<label><?php echo $videoLabel;?></label>
		
	
	<?php } ?></div><!--label_wrapper-->
	<div class="cell frm_element_wrapper">
		<!--<div class="browse_box row upload_media_left_box" >-->
			<div class="row" >
			<div class="browse_thumb_wrapper cell">
				
				<table width="100%"  height="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td><div id="show<?php echo @$browseId;?>"><?php echo $imgSrc;?>	</div></td>
				  </tr>
				</table>
			
			</div><!--browse_thumb_wrapper-->			
			<div class="browse_button_video_wrapper cell ">
			<?php 
			if($browseId=="_interview")
			{
			?>	
	<div class="cell"><div class="tds-button"> <a id="uploadSelected<?php echo $browseId;?>" href="javascript:void(0)" onclick="hideShow('EmbeddedURL<?php echo $browseId;?>','Uploadvideo<?php echo $browseId;?>','embedMenu<?php echo $browseId;?>','videoMenu<?php echo $browseId;?>','<?php echo $isExternalId;?>','f'); uploadMathod(this)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="videoMenu<?php echo $browseId;?>"  class="<?php echo $VFMC;?>"><?php echo $this->lang->line('upload'); ?></span></a> </div></div>
	<div class="cell"><div class="tds-button"> <a id="embedSelected<?php echo $browseId;?>" href="javascript:void(0)" onclick="hideShow('Uploadvideo<?php echo $browseId;?>','EmbeddedURL<?php echo $browseId;?>','videoMenu<?php echo $browseId;?>','embedMenu<?php echo $browseId;?>','<?php echo $isExternalId;?>','t'); uploadMathod(this)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="embedMenu<?php echo $browseId;?>"  class="<?php echo $EMC;?>"><?php echo $this->lang->line('embed');?></span></a> </div></div>
		<?php }
				
		else { ?>
				<div class="cell"><div class="tds-button"> <a id="uploadSelected<?php echo $browseId;?>" href="javascript:void(0)" onclick="hideShow('EmbeddedURL<?php echo $browseId;?>','Uploadvideo<?php echo $browseId;?>','embedMenu<?php echo $browseId;?>','videoMenu<?php echo $browseId;?>','<?php echo $isExternalId;?>','f'); uploadMathodIntro(this)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="videoMenu<?php echo $browseId;?>"  class="<?php echo $VFMC;?>"><?php echo $this->lang->line('upload'); ?></span></a> </div></div>
	<div class="cell"><div class="tds-button"> <a id="embedSelected<?php echo $browseId;?>" href="javascript:void(0)" onclick="hideShow('Uploadvideo<?php echo $browseId;?>','EmbeddedURL<?php echo $browseId;?>','videoMenu<?php echo $browseId;?>','embedMenu<?php echo $browseId;?>','<?php echo $isExternalId;?>','t'); uploadMathodIntro(this)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="embedMenu<?php echo $browseId;?>"  class="<?php echo $EMC;?>"><?php echo $this->lang->line('embed');?></span></a> </div></div>
			<?php }?>
				<div class="row seprator_8"></div>
				<div class="<?php echo $EUS;?>"  id="EmbeddedURL<?php echo $browseId;?>"> <?php echo form_textarea($embedArray); ?> </div>
				<div class="<?php echo $VFS;?>" id="Uploadvideo<?php echo $browseId;?>">
								
				
				<div class="clear"></div>
						<div id="FileUpload<?php echo $browseId;?>"  onmouseup="mouseup_tds_button(document.getElementById('browse_btn<?php echo $browseId;?>'))" onmousedown="mousedown_tds_button(document.getElementById('browse_btn<?php echo $browseId;?>'))">
						
						<div class="fl"><?php echo form_input($inputArray); ?></div>
				
						<div class="tds-button Fright" id="browsebtn<?php echo $browseId;?>">
							<a id="browse_btn<?php echo $browseId;?>"><span><?php echo $this->lang->line('browse')?></a>  
						</div>
					<div>
						
						<?php //echo form_upload($uploadArray); ?>
				</div>
				<div id="fileError<?php echo $browseId;?>" class="row wordcounter orange"></div>
			</div>
			
			</div>
			<?php
			
			if(@$checkButton=="1"){
				
				echo '<div class="row seprator_8"></div>';
				echo '<div class="mr10">';
				$button=array('ajaxSave','cancelMultipleHide',$browseId);
				echo Modules::run("common/loadButtons",$button); 
				echo '</div>';
			}
			
			?>
			</div>
			<div class="clear"></div>  
		</div><!--browse_box-->
		
	</div><!--from_element_wrapper--> 
 
 </div> 
  			  
<?php

//$fileUploadPath=str_replace('/','+',$filePath);
//echo '<br />'.$fileMaxSize;
//echo '<br />'.$fileType;
//echo $this->config->item('videoUploadAccept');
?>	

