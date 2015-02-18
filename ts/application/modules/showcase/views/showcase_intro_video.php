<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
$formAttributes = array(
	'name'=>'showcaseIntroVideoForm',
	'id'=>'showcaseIntroVideoForm'
);


?>

<div id="uploadFileByJquery<?php echo $browseId;?>"></div>
<?php 
if($loadFrmAjax=="1")
$dn='';
else
$dn='';?>
<div class="row <?php echo $dn;?>" >
	<div class="cell tab_left">
		<div class="tab_heading"><?php echo $this->lang->line('introductoryVideo');?></div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				
				<a class="formTip" >
					<span><div toggledivid="INTROVIDEOForm-Content-Box" id="introvideoToggleIcon" class="projectToggleIcon toggle_icon"></div></span>
				</a>
			</div>
		</div>
	</div>
	
</div>

<div id="contentBoxIntro">
<div class="frm_strip_bg mt35">
<div class="form_wrapper toggle" id="INTROVIDEO-Content-Box">
	
	<div class="row" id="INTROVIDEOForm-Content-Box">
		<div class="tab_shadow"></div>
		<?php 
		//-----Commom Promotional Video Upload-----
			$videoSize = $this->config->item('videoSize');
			$videoType = $this->config->item('videoAccept');
			
			
			$browseIntroId = '_introductory';
			//print_r($values);
			$videoLabel = $label['introductoryVideo'];
			
			
			 
			 if(isset($values[0]['uploadIntroductoryType']) && $values[0]['uploadIntroductoryType']!='')
			 $videoType = $values[0]['uploadIntroductoryType'];
			else
			 $videoType = 0;		
			
			if($videoType == 1 && isset($values[0]['introductoryFileId']) && $values[0]['introductoryFileId']>0)
			{  
				$introFileDetail = getMediaDetail($values[0]['introductoryFileId'],'fileName,filePath');
				
				if(is_array($introFileDetail)){
				 $file = $firstIntroVideoFile =  $introFileDetail[0]->filePath.'/'.$introFileDetail[0]->fileName;
				}
				else $file = $firstIntroVideoFile = '';
				
				$fileType = 2;
				
				if($file=='')
				{
					$imgIntroductorySrc = '<img class="ui-state-disabled" width="100" src="'.base_url().'images/stockphoto_FnV.jpg" />';
				}
				else
				{
					$imgIntroductorySrc = '<img  id ="showVideo'.$browseId.'"  width="100" src="'.base_url().'images/stockphoto_FnV.jpg" onclick="openLightBox(\'loginLightBoxWp\',\'loginFormContainer\',\'/common/playMediaFile\',\''.$file.'\',\''.$fileType.'\',5);" />';
				}				
			}			
			else if($videoType == 0 && isset($values[0]['introductoryEmbed']) && $values[0]['introductoryEmbed']!='')
			{
				$file=urlencode($values[0]['introductoryEmbed']);
				$fileType='external';
				$imgIntroductorySrc = '<img  width="100" id ="showVideo'.$browseId.'"  src="'.base_url().'images/stockphoto_FnV.jpg" onclick="openLightBox(\'loginLightBoxWp\',\'loginFormContainer\',\'/common/playMediaFile\',\''.$file.'\',\''.$fileType.'\',5);" />';
			}
			else 
			{
				$imgIntroductorySrc = '<img class="ui-state-disabled" width="100" src="'.base_url().'images/stockphoto_FnV.jpg" />';
			}
			
			$embedArray = '';
			
			$inputArray = array(
				'name'	=> 'introductoryFilename',
				'class'	=> 'width327px BdrCommon fl required',
				'value'	=> '',
				'id'	=> 'fileInput'.$browseId,
				'type'	=> 'text',
				'readonly' => true
			);
						
			$embedArray = array(
			'name'	=> 'introductoryEmbed',
			'id'	=> 'introductoryEmbed',
			'class'	=> 'dblBorder rz width405px required',
			'rows' => 2,
			'cols' => 45,
			'value' => @$values[0]['introductoryEmbed']		
			);
			
			$title = array(
				'name'	=> 'introductoryTitle',
				'id'	=> 'introductoryTitle',	
				'class'	=> 'width546px required',
				'value'	=>'',
				'minlength'	=> 2,
				'maxlength'	=> 50,
				'size'	=> 50
			);	
			
			
			$description = array(
				'name'	=> 'introductoryDescription',
				'id'	=> 'introductoryDescription',	
				'class'	=> 'dblBorder rz width405px required',
				'value'	=>'',
				'rows' => 5,
			    'cols' => 45
			);	
			
			
			

			$interData=array('checkButton'=>'1','videoLabel'=>'','imgInterviewSrc'=>$imgIntroductorySrc,'embedArray'=>$embedArray,'inputArray'=>$inputArray,'browseId'=>$browseId,'videoType'=>$videoType,'fileType'=>$this->config->item('videoUploadAccept'),'fileMaxSize'=>$this->config->item('videoMaxSize'),'fileSize'=>$this->config->item('videoSize'),'filePath'=>$introductoryVideoPathForm,'title'=>$title,'description' =>$description);
			?>
			
		<div class="clear"></div>
		<div class="upload_media_left_top row"></div>
		<?php echo form_open_multipart($this->uri->uri_string(),$formAttributes); ?>
			<div class="upload_media_left_box">
			<?php
			echo Modules::run("mediatheme/promoVideoForm",$interData);
			echo '</div>';
			echo form_close(); ?>
		<div class="clear"></div>
		<div class="upload_media_left_bottom row"></div>

		<input type="hidden" id="radioSelected" value="" name="radioSelected" />
		<input type="hidden" id="save" value="" name="save" />
		
		<div class="clear seprator_10"></div>
		

		
	</div><!-- End Div INTROVIDEOForm-Content-Box -->
		
	
	
</div><!-- End Div "INTROVIDEOForm-Content-Box" -->
</div>
</div>
<?php $introJSPath = $introductoryVideoPathForm.'/';?>


<script>
	$('#browsebtn<?php echo @$browseId;?>').click(function(){		
		fileTypes = '<?php echo $this->config->item('videoAccept');?>';
		fileTypes = fileTypes.replace(/\|/g, ",");		
	});
uploadMediaFiles('<?php echo $introJSPath?>',fileTypes,'<?php echo $this->config->item('videoMaxSize');?>','<?php echo @$browseId;?>',1,1,1);
			
	
$(document).ready(function(){
	
$("#showcaseIntroVideoForm").validate({
				
		submitHandler: function() {	
				
			var goforsave = 1;	
			
			if(goforsave==1)
			{
					$('#save').val('Save');		
					var fileType = 2;	
					//End for editor value
						var elementId = <?php echo $showcaseId;?>;  
						var elementTable = '<?php echo $elementTable;?>';  
						var elementFieldId = '<?php echo $elementFieldId;?>';  
						var introductoryfileId = '<?php echo $introductoryfileId;?>'; 
						var introductoryEmbed = $('#introductoryEmbed').val();  
						var numErrorItems = 0;
						var introductoryType = $('#uploadIntroductoryType').val();  
						var stockImageId = 0;
						if(introductoryType =='f'|| introductoryType ==1) introductoryType = 1;
						else introductoryType = 0;
						
						var optionSelected = $('input:radio[name=optionSelected]:checked').val();	
					
						if(elementId ==0)
							var data = {"optionSelected":optionSelected,"introductoryEmbed":introductoryEmbed,"uploadIntroductoryType":introductoryType,"stockImageId":stockImageId,"optionSelected":optionSelected,"tdsUid":<?php echo isLoginUser(); ?>,"dateCreated":'<?php echo date('Y-m-d h:i:s'); ?>',"dateModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 
						else
							var data = {"showcaseId":elementId,"optionSelected":optionSelected,"introductoryEmbed":introductoryEmbed,"uploadIntroductoryType":introductoryType,"stockImageId":stockImageId,"tdsUid":<?php echo isLoginUser(); ?>,"dateModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 
							
						var introductoryfilePath='<?php  echo $introductoryVideoPathForm; ?>';
						
						if($('#isExternal<?php echo $browseId;?>').val() ==1) 
							var introductoryIsExternal = 't';
						else 
							var introductoryIsExternal = 'f';
						
							//alert('File Name:'+$('#fileName<?php echo $browseId;?>').val());
						if($('#fileInput<?php echo $browseId;?>').val()!='')
						{
							var introfileData = {"filePath":introductoryfilePath,"fileName":$('#fileName<?php echo $browseId;?>').val(),"fileSize":$('#fileSize<?php echo $browseId;?>').val(),"fileType":fileType,"isExternal":introductoryIsExternal,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>};
						}
						else
						{
							var introfileData = '';
						} 
						
						if($('#isExternal<?php echo $browseIntroId;?>').val() ==1 ) var introductoryIsExternal ='t';
						else var introductoryIsExternal ='f';
						
						// Gets the number of elements with class yourClass
						numErrorItems = $('.error').length;
						
						if(numErrorItems>0 && $('#fileInput<?php echo $browseId;?>').val()=="" && $('introductoryEmbed').val()=="")
						{ 
							return false;
						}
						else
						{
							var interfileData='';
							
							var interviewfileId='';
							
							if($('#fileError<?php echo @$browseImgJs;?>').text()=='')
							var returnFlag = AJAX('<?php echo base_url(lang()."/showcase/UpdateShowcaseIntroVideo");?>','show<?php echo @$browseId;?>',introfileData,interfileData,data,'loadVideo',elementTable,elementFieldId,interviewfileId,introductoryfileId,elementId);	
													
							if(returnFlag){
								
								$("#uploadFileByJquery<?php echo $browseId;?>").click();
								
								$("#fileInput<?php echo $browseId;?>").val('');
								
								if(introductoryType!=0) $("#introductoryEmbed").val('');
								
								$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('showcase').' '.$this->lang->line('recordSaveDeleted');?></div>');
							}							
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
	
	function uploadMathodIntro(obj){
		
		var Id = $(obj).attr('id');
		
		if(Id == 'uploadSelected<?php echo $browseId; ?>'){
			if($('#isExternal<?php echo $browseId; ?>').val()=='f'){
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

