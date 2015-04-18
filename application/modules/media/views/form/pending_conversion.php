<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="newlanding_container">
	<div class="wizard_wrap fs14">
		<div id="TabbedPanels1" class="TabbedPanels ">
			<div class="TabbedPanelsContentGroup design_wrap width_665 m_auto ">
				<div class="TabbedPanelsContent width635 m_auto clearb TabbedPanelsContentVisible">
					 <div class="c_1 clearb">
						
						 <h3 class="fs19 red  bb_aeaeae" >
							<?php echo $this->lang->line('fileNotConverted');?>
						</h3>
						<?php 
						foreach ($pendingRecords as $elementdata) {
							
							$browseId           =   '1_'.$elementdata->elementId;
							$fileSize           =   0;    
							$filePath           =   $dirUploadMedia.$elementdata->projId.'/file';    
							$embedCode          =   '';    
							$imgload            =    0;    

							$isReloadPage           =   0;
							$fileName               =   isset($fileName)?$fileName:'';
							$isUploadEmbedOption    =   isset($isUploadEmbedOption)?$isUploadEmbedOption:true; 
							$allowedMediaType       =   str_replace(',',', ',$allowedMediaType);
							
							$projSellstatus         =   (!empty($projData->projSellstatus))?$projData->projSellstatus:'f';
							$createWaterMarkFlag    =   ($projSellstatus=="t")?'1':'0';
							
							$isExternalInput = array(
								'name'	=> 'isExternal'.$browseId,
								'value'	=> 'f',
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
							
							$inputArray = array(
								'name'	=> 'fileInput'.$browseId,
								'class'	=> 'fl width300 p12 bdr_adadad pb11 ',
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
							
							$indusrtyNameField = array(
								'name'	=> 'indusrtyName'.$browseId,
								'value'	=> $indusrtyName,
								'id'	=> 'indusrtyName'.$browseId,
								'type'	=> 'hidden'
							);


							$browseIdField = array(
								'name'	=> 'browseId',
								'value'	=> $browseId,
								'id'	=> 'browseId',
								'type'	=> 'hidden'
							);
							
							$projectIdField = array(
								'name'	=> 'projectId'.$browseId,
								'value'	=> $elementdata->projId,
								'id'	=> 'projectId'.$browseId,
								'type'	=> 'hidden'
							);
							
							$fileIdField = array(
								'name'	=> 'fileId'.$browseId,
								'value'	=> $elementdata->fileId,
								'id'	=> 'fileId'.$browseId,
								'type'	=> 'hidden'
							);
							
							$elementIdField = array(
								'name'	=> 'elementId'.$browseId,
								'value'	=> $elementdata->elementId,
								'id'	=> 'elementId'.$browseId,
								'type'	=> 'hidden'
							);
							
							$elementEntityIdField = array(
								'name'	=> 'elementEntityId'.$browseId,
								'value'	=> $elementEntityId,
								'id'	=> 'elementEntityId'.$browseId,
								'type'	=> 'hidden'
							);
							
							$indusrtyNameField = array(
								'name'	=> 'indusrtyName'.$browseId,
								'value'	=> $indusrtyName,
								'id'	=> 'indusrtyName'.$browseId,
								'type'	=> 'hidden'
							);
							
							$createWaterMarkFlagField = array(
								'name'	=> 'createWaterMarkFlag',
								'value'	=> $createWaterMarkFlag,
								'id'	=> 'createWaterMarkFlag',
								'type'	=> 'hidden'
							);
							
							$uploadedFilePathField = array(
								'name'	=> 'uploadedFilePath'.$browseId,
								'value'	=> $elementdata->filePath.$elementdata->fileName,
								'id'	=> 'uploadedFilePath'.$browseId,
								'type'	=> 'hidden'
							);
							
							if($indusrtyName=='photographyNart' && $projSellstatus=="t"){
								echo form_input($createWaterMarkFlagField);
							}
							// set base url
							$baseUrl = formBaseUrl(); 
							//next page url 
							$nextUrl  =  $baseUrl.'/pendingconversion/';
						echo '<div class="conversionDiv">';
						echo form_open($this->uri->uri_string(),array('name'=>'mediaFileForm_'.$browseId,'id'=>'mediaFileForm_'.$browseId)); 
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
						
						<div class="sap_25"></div>
					
						<h4 class="fs14 font_weight pt0"><?php echo $elementdata->title;?></h4>
				
						<div id="uploadFileSection<?php echo $browseId;?>">  
							<div class="fl width465">
								<div class="<?php echo $VFS;?> <?php echo $UF;?><?php echo $imgLoadClass;?>" id="Uploadvideo<?php echo $browseId;?>">
									<div id="FileUpload<?php echo $browseId;?>">
											<?php echo form_input($inputArray); ?>
											
											<div id="browsebtn<?php echo $browseId;?>" class="fileUpload fr btn btn-primary fs11 fshel_bold text_alighC bg_dfdfdf bdr_adadad p14 width88"> <span><?php echo $this->lang->line('uploadStage_browse'); ?></span>
												<input id="uploadBtn" type="button" class="upload" />
											</div>
											<div id="fileError<?php echo $browseId;?>" class="validation_error pt5"></div>
									</div>
									<div id="rawFileNameDiv<?php echo $browseId;?>"></div>
								</div>
							</div>  
							
							<div class="fr mt12 red">
								<span><a href="javascript:void(0)" onclick="uploadfile('<?php echo $browseId;?>')" >Upload Again</a></span> / 
								<span><a href="javascript:void(0)" onclick="deleteElement('<?php echo $elementdata->projId;?>','<?php echo $elementdata->elementId;?>')">Delete</a></span>
							</div>
							<div id="fileTypeRuntimeDiv<?php echo $browseId;?>">
								<input type="hidden" value="<?php echo $mediaFileTypes;?>" id="fileTypeRuntime<?php echo $browseId;?>" />
							</div>	
						</div>
						<script>
							 //call upload method for files uploading
							uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $fileMaxSize;?>','<?php echo $browseId;?>',1,'<?php echo $isReloadPage;?>',0,'<?php echo $imgload;?>','','_xs','1','<?php echo  $nextUrl; ?>');
						</script>
						
							<?php
							echo form_input($fileIdField);
							echo form_input($fileNameInput);
							echo form_input($fileSizeInput);
							echo form_input($typeOfFileInput);
							echo form_input($isExternalInput);
							echo form_input($fileUploadPathInput);
							echo form_input($fileErrorInput);
							echo form_input($browseIdField);
							echo form_input($indusrtyNameField);
							echo form_input($projectIdField);
							echo form_input($elementIdField);
							echo form_input($elementEntityIdField);
							echo form_input($indusrtyNameField);
							echo form_input($uploadedFilePathField);
						echo form_close();
						echo '</div>';
					  }?>
					
						<ul class="clearb org_list">
							<li class="icon_2"><?php echo $this->lang->line('footerConversionNote'); ?></li>
						</ul>
						<div class="sap_50"></div>
					</div>
				</div>	
			</div>
		</div>
	</div>	
</div>		
<script type="text/javascript">

   
    //fire trigger for file uploading  
	function uploadfile(browseId) {
		
		var fileInput       =  $("#fileInput"+browseId).val();
		var embbededURL     =  $("#embbededURL"+browseId).val();
		var fileErrorInput  =  $("#fileErrorInput"+browseId).val();
		var nextPageUrl     =  '<?php echo $baseUrl.$nextPage;?>';
		
		if( fileInput!="" ) {
				
			if(fileErrorInput=="0"){
					
				var fromData=$("#mediaFileForm_"+browseId).serialize();
				var url = baseUrl+language+'/media/uploadfilepost';
				
				$.post(url,fromData, function(data) {
				  if(data){
					
					if(data.fileId != undefined &&  (data.fileId > 0)){
					  $("#MediaFileId").val(data.fileId);
					}  
					 
					$("#uploadFileByJquery"+browseId).click();
					
					var fileName =  $("#fileName"+browseId).val();
					if(fileName == undefined){
						fileName = '';
					}
					}
				},"json");
			}
		} else {
			customAlert('Please select a file.');
		}
		return false;
	}
    
    
	function deleteElement(projectId,elementId) {
		var elementTable = '<?php echo $elementTable;?>';
		var sectionId    = '<?php echo $sectionId;?>';
		confirmBox("If you delete this, it will be deleted immediately.", function () {
				 var fromData='val1='+projectId+'&val2='+elementTable+'&val3='+elementId+'&val4='+sectionId;
				 $.post(baseUrl+language+'/media/moveMediaElementInTrash',fromData, function(data) {
					$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('deletedElementFile');?></div>');
					timeout = setTimeout(hideDiv, 5000);	
					refreshPge();
				});
			});
		}

</script>
