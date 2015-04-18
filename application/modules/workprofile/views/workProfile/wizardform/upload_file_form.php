<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$mediaFileForm  =   array(
    'name'      =>  'mediaFileForm',
    'id'        =>  'mediaFileForm'
);
    $browseId           =   '1';
    $fileSize           =   0;    
    $filePath           =   $dirUploadMedia;    
    $embedCode          =   '';    
    $imgload            =   0;    

    $isReloadPage       =   0;
    $uplodedfileName    =   isset($fileName)?$fileName:'';
    $allowedMediaType   =   str_replace(',',', ',$allowedMediaType);
    
    $fileNameInput = array(
        'name'	=> 'fileName'.$browseId,
        'value'	=> '',
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
        'class'	=> 'fl width472 p12 bdr_adadad pb11 ',
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
    
	$uploadedFileField = array(
        'name'	=> 'uploadedFile',
        'value'	=> $uplodedfileName,
        'id'	=> 'uploadedFile',
        'type'	=> 'hidden'
    );
    
    $workProfileIdField = array(
        'name'	=> 'workProfileId',
        'value'	=> $workProfileId,
        'id'	=> 'workProfileId',
        'type'	=> 'hidden'
    );
    
	// set next url
	$nextUrl=  '/workprofile/portfoliotitlendesc/'.$mediaId.'/'.$typeOfFile;
	// set base url
	$baseUrl = base_url_lang('/workprofile');  
	?>
	<div class="TabbedPanelsContentGroup design_wrap width_665 m_auto ">
		<div class="TabbedPanelsContent width635 m_auto clearb TabbedPanelsContentVisible">
			<?php echo form_open($baseUrl.'/uploadmedia/'.$mediaId.'/'.$typeOfFile,$mediaFileForm); ?>
				<div class="c_1 clearb">
					<h3 class="fs19 red  bb_aeaeae" >
						<?php echo $this->lang->line('uploadFile'.$typeOfFile);?>
					</h3>
					<?php  
					if(isset($profileMediaData->rawFileName) && !empty($profileMediaData->rawFileName)) { ?>
						<h4 class="fs14 font_weight pb10"><?php echo $profileMediaData->rawFileName;?></h4>
						<?php 
						// set next form url
						$data['isNextstep'] = '1';
						$data['nextPage'] = '/workprofile/portfoliotitlendesc/'.$mediaId.'/'.$typeOfFile;
					} else { ?>
					
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

						<div class="sap_30"></div>
						<div id="uploadFileSection<?php echo $browseId;?>" >
							<div>
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

							<div id="fileTypeRuntimeDiv<?php echo $browseId;?>">
								<input type="hidden" value="<?php echo $mediaFileTypes;?>" id="fileTypeRuntime<?php echo $browseId;?>" />
							</div>
						</div>

						<ul class="clearbox">
							<li class="icon_2 pt0 mt25"><?php echo $this->lang->line('uploadStage_AcceptedFileTypes'); ?> <?php echo $allowedMediaType;?>. </li>
							<li>
								<?php echo $this->lang->line('uploadStage_uploadFileInfo'); ?>
							</li>
						</ul>
						<?php
						// set next form name
						$data['formName'] = 'mediaFileForm';
					} ?>
				</div>
			<?php
				echo form_input($fileNameInput);
				echo form_input($fileSizeInput);
				echo form_input($typeOfFileInput);
				echo form_input($fileUploadPathInput);
				echo form_input($fileErrorInput);
				echo form_input($browseIdField);
				echo form_input($uploadedFileField);
				echo form_input($workProfileIdField);
			 echo form_close();?>
			 <!-- Form buttons -->
			<?php
			// set cancle url
			$data['cancleUrlType'] = 2;
			// set back url
			$data['backPage'] = '/workprofile/portfoliomediatype/'.$mediaId.'/'.$typeOfFile;
			$this->load->view('workProfile/wizardform/common_buttons',$data);
			?>
		</div>
	</div>	
<script type="text/javascript">

    //call upload method for files uploading
    uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $fileMaxSize;?>','<?php echo $browseId;?>',1,'<?php echo $isReloadPage;?>',0,'<?php echo $imgload;?>','','_xs','0','<?php echo  $nextUrl; ?>');

    //fire trigger for file uploading
    $(document).ready(function() {   
		$('.uploadFileAction').click(function() {
            
            var fileInput       =  $("#fileInput<?php echo $browseId?>").val();
            var fileName        =  $("#fileName<?php echo $browseId?>").val();
            var fileErrorInput  =  $("#fileErrorInput<?php echo $browseId?>").val();
            
            if(fileInput != "") {
                    
                if(fileErrorInput == "0") {
                        
                    var fromData=$("#mediaFileForm").serialize();
                    var url = baseUrl+language+'/workprofile/uploadfilepost';
                    
                    $.post(url,fromData, function(data) {
                      if(data){
                        
                        if(data.fileId != undefined &&  (data.fileId > 0)){
                          $("#MediaFileId").val(data.fileId);
                        }  
                         
                        $("#uploadFileByJquery<?php echo $browseId;?>").click();
                        
                        if(fileName == undefined){
                            fileName = '';
                        }
                         
                        // redirect to next page 
						window.location.href = '<?php echo $baseUrl; ?>'+data.nextUrl;
                        }
                    },"json");
                }
            } else {
				alert('Upload the file first.');
			}
            
            return false;
        });
    });

</script>
