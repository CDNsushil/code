
<?php 
$formAttributes = array(
	'name'=>'showcaseMainVideoForm',
	'id'=>'showcaseMainVideoForm'
);
?>

<div id="uploadFileByJquery<?php echo $browseId;?>"></div>
<?php 
if($loadFrmAjax=="1")
$dn='dn';
else
$dn='';?>
<div class="row <?php echo $dn;?>" >
	<div class="cell tab_left">
		<div class="tab_heading"><?php echo $this->lang->line('main');?></div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Post add Icon -->
				<!--<a toggledivicon="mainvideoToggleIcon" toggledivform="MAINVIDEOForm-Content-Box" toggledivid="MAINVIDEO-Content-Box" class="formTip formToggleIcon" title="<?php echo $label['add'];?>">
					<span><div class="projectAddIcon"></div></span>
				</a>-->
				<a class="formTip" >
					<span><div toggledivid="MAINVIDEOForm-Content-Box" id="mainvideoToggleIcon" class="projectToggleIcon toggle_icon"></div></span>
				</a>
			</div>
		</div>
	</div>
</div>
<div class="clear"></div>
<div id="contentBox">
<?php echo form_open_multipart($this->uri->uri_string(),$formAttributes); 
?>
<div class="form_wrapper toggle frm_strip_bg " id="MAINVIDEO-Content-Box">
	
	<div class="row dn" id="MAINVIDEOForm-Content-Box">
		<?php 
		//-----Commom Promotional Video Upload-----
			$videoSize = $this->config->item('videoSize');
			$videoType = $this->config->item('videoAccept');
			
			$browseId = '_interview';
			$browseIntroId = '_introductory';
			//print_r($values);
			$videoLabel = $label['interviews'];
			
			if(isset($values[0]['uploadInterviewType']) && $values[0]['uploadInterviewType']!='')
			 $videoType = $values[0]['uploadInterviewType'];
			else
			 $videoType = 0;			
			//echo $values[0]['interviewFileId'];
			if($videoType == 1 && isset($values[0]['interviewFileId']) && $values[0]['interviewFileId']>0)
			{  
				$interFileDetail = getMediaDetail($values[0]['interviewFileId'],'fileName,filePath');
				
				if(is_array($interFileDetail)){
				 $file = $firstInterviewVideoFile =  $interFileDetail[0]->filePath.'/'.$interFileDetail[0]->fileName;
				}
				else $file = $firstInterviewVideoFile = '';
				
				$fileType = 2;
				
				if($file=='')
				{
					$imgInterviewSrc = '<img class="ui-state-disabled" width="100" src="'.base_url().'images/stockphoto_FnV.jpg" />';
				}
				else
				{
					$imgInterviewSrc = '<img  id ="showVideo'.$browseId.'"  width="100" src="'.base_url().'images/stockphoto_FnV.jpg" onclick="openLightBox(\'loginLightBoxWp\',\'loginFormContainer\',\'/common/playMediaFile\',\''.$file.'\',\''.$fileType.'\',5);" />';
				}				
			}			
			else if($videoType == 0 && isset($values[0]['interviewEmbed']) && $values[0]['interviewEmbed']!='')
			{
				$file=urlencode($values[0]['interviewEmbed']);
				$fileType='external';
				$imgInterviewSrc = '<img  width="100" id ="showVideo'.$browseId.'"  src="'.base_url().'images/stockphoto_FnV.jpg" onclick="openLightBox(\'loginLightBoxWp\',\'loginFormContainer\',\'/common/playMediaFile\',\''.$file.'\',\''.$fileType.'\',5);" />';
			}
			else 
			{
				$imgInterviewSrc = '<img class="ui-state-disabled" width="100" src="'.base_url().'images/stockphoto_FnV.jpg" />';
			}
			
			$embedArray = '';
			
			$inputArray = array(
				'name'	=> 'interviewFilename',
				'class'	=> 'width327px BdrCommon fl',
				'value'	=> '',
				'id'	=> 'fileInput'.$browseId,
				'type'	=> 'text',
				'readonly' => true
			);
				
			$uploadArray = array(
			'id'	=> 'BrowserHidden'.$browseId,	
			'name'	=> 'interviewVideoPath',
			'class'	=> 'BrowserHidden btn_browse',
			'value'	=> '',
			'accept'=> $this->config->item('videoAccept'),
			'onchange'=> "getElementById('FileField".$browseId."').value = getElementById('BrowserHidden".$browseId."').value",
			'style'=>"width:385px;"
			);
			
			$embedArray = array(
			'name'	=> 'interviewEmbed',
			'id'	=> 'interviewEmbed',
			'title'=>  $label['profileImage'],
			'class'	=> 'dblBorder rz width405px',
			'rows' => 2,
			'cols' => 45,
			'value' => @$values[0]['interviewEmbed']	
			//'value' => $values['interviewEmbed']	
			);
			
			$interData=array('saveButton'=>'1','videoLabel'=>'','imgInterviewSrc'=>$imgInterviewSrc,'embedArray'=>$embedArray,'uploadArray'=>$uploadArray,'inputArray'=>$inputArray,'browseId'=>$browseId,'videoType'=>$videoType,'fileType'=>$this->config->item('videoUploadAccept'),'fileMaxSize'=>$this->config->item('videoMaxSize'),'fileSize'=>$this->config->item('videoSize'),'filePath'=>$interviewVideoPathForm);
			?>
			
			<div id="FileContainer<?php echo $browseId;?>" class="fr">
				<div class="fileInfo" id="fileInfo<?php echo $browseId;?>">
					<div id="progressBar<?php echo $browseId;?>" class="plupload_progress">
						<div class="progressBar_msg fl"><?php echo $this->lang->line('fileUploading');?></div>
						<div class="plupload_progress_container fl"><div id="plupload_progress_bar<?php echo $browseId;?>" class="plupload_progress_bar"></div></div></div><span id="percentComplete<?php echo $browseId;?>" class="percentComplete fl"></span>
				</div>
				<div id="dropArea<?php echo $browseId;?>"></div>
				
		</div>
		
		<?php
			echo Modules::run("mediatheme/promoVideoForm",$interData);
			?>
		<input type="hidden" id="radioSelected" value="" name="radioSelected" />
		<input type="hidden" id="save" value="" name="save" />
		
		<div class="clear seprator_10"></div>
		<?php echo form_close(); ?>
		
	</div><!-- End Div MAINVIDEOForm-Content-Box -->
		
	
	
</div><!-- End Div "MAINVIDEOForm-Content-Box" -->
</div>
<?php $interJSPath = $interviewVideoPathForm.'/';?>


<script>
uploadMediaFiles('<?php echo $interJSPath?>','<?php echo $this->config->item('videoUploadAccept');?>','<?php echo $this->config->item('videoMaxSize');?>','<?php echo $browseId;?>',1,0);
			
	
$(document).ready(function(){
	
$("#showcaseMainVideoForm").validate({
				
		submitHandler: function() {	
				
			var goforsave = 1;						
			//To Check Is There Any Error While uploading the Video Files If So Do not Go For Save 
			//var interviewError = $('#fileError<?php echo $browseId;?>').is(":visible");
			//var introError = $('#fileError<?php echo $browseIntroId;?>').is(":visible");
			//alert(interviewError+':'+introError);
			//if((interviewError == false) && (introError == false)) var goforsave = 1;
			//else var goforsave = 0;
			

			if(goforsave==1)
			{
						
					 
					$('#save').val('Save');		
					var fileType = 2;	
					//End for editor value
						var elementId = <?php echo $showcaseId;?>;  
						var elementTable = '<?php echo $elementTable;?>';  
						var elementFieldId = '<?php echo $elementFieldId;?>';  
						var interviewfileId = '<?php echo $interviewfileId;?>';   					
						var interviewEmbed = $('#interviewEmbed').val();   
						var introductoryEmbed = $('#introductoryEmbed').val();  
						var numErrorItems = 0;
						var interviewType = $('#uploadInterviewType').val();  
						var stockImageId = 0;
						if(interviewType =='f'|| interviewType ==1) interviewType = 1;
						else interviewType = 0;
						
						var optionSelected = $('input:radio[name=optionSelected]:checked').val();	
					
						if(elementId ==0)
							var data = {"optionSelected":optionSelected,"interviewEmbed":interviewEmbed,"uploadInterviewType":interviewType,"stockImageId":stockImageId,"optionSelected":optionSelected,"tdsUid":<?php echo isLoginUser(); ?>,"dateCreated":'<?php echo date('Y-m-d h:i:s'); ?>',"dateModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 
						else
							var data = {"showcaseId":elementId,"optionSelected":optionSelected,"interviewEmbed":interviewEmbed,"uploadInterviewType":interviewType,"stockImageId":stockImageId,"tdsUid":<?php echo isLoginUser(); ?>,"dateModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 
							
						var interfilePath='<?php  echo $interviewVideoPathForm; ?>';
						
						
						
						if($('#isExternal<?php echo $browseId;?>').val() ==1) 
							var interIsExternal = 't';
						else 
							var interIsExternal = 'f';
						
							//alert('File Name:'+$('#fileName<?php echo $browseId;?>').val());
						if($('#FileField<?php echo $browseId;?>').val()!='')
						{
							var interfileData = {"filePath":interfilePath,"fileName":$('#fileName<?php echo $browseId;?>').val(),"fileSize":$('#fileSize<?php echo $browseId;?>').val(),"fileType":fileType,"isExternal":interIsExternal,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>};
						}
						else
						{
							var interfileData = '';
						} 
						
						if($('#isExternal<?php echo $browseIntroId;?>').val() ==1 ) var introIsExternal ='t';
						else var introIsExternal ='f';
						
						
							
						
						// Gets the number of elements with class yourClass
						numErrorItems = $('.error').length;
						
						if(numErrorItems>0)
						{ 
							return false;
						}
						else
						{
							var introfileData='';
							var introductoryFileId='';
							AJAX('<?php echo base_url(lang()."/showcase/UpdateShowcaseMainVideo");?>','contentBox',interfileData,introfileData,data,elementId,elementTable,elementFieldId,interviewfileId,introductoryFileId);	
							$("#uploadFileByJquery<?php echo $browseId;?>").click();
							$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('showcase').' '.$this->lang->line('recordSaveDeleted');?></div>');
							
							timeout = setTimeout(hideDiv, 5000);

							return true;
						}
									
		 }
		}
	});
});
	
function showstockimages()
	{
		$("#stockImagesBoxWp").lightbox_me('center:true');
	}

	function preview()
	{
		openLightBox('showcasePreviewBoxWp','showcasePreviewFormContainer','/showcase/showcasePreview');
	}
	
	function uploadMathod(obj){
		
		var Id = $(obj).attr('id');
		///alert(Id);
		if(Id == 'uploadSelected<?php echo $browseId; ?>'){
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
	
	function canceltoggle(toggleFlag)
{  
	if(toggleFlag==0)
  {
	$('#FileField_interview').val('');
	$('#MAINVIDEOForm-Content-Box').slideUp();
	}
  
  if(toggleFlag ==1)
  {
	$('#FileField_interview').val('');
	$('#MAINVIDEOForm-Content-Box').slideDown();
  }
 
}
</script>

