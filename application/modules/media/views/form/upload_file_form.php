<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

    $browseId           =   '1';
    $fileSize           =   0;    
    $filePath           =   $dirUploadMedia;    
    $embedCode          =   '';    
    $imgload            =    0;    

    $isReloadPage           =   0;
    $uplodedfileName        =   isset($fileName)?$fileName:''; 
	
    $isUploadEmbedOption    =   isset($isUploadEmbedOption)?$isUploadEmbedOption:true; 
    $allowedMediaType       =   str_replace(',',', ',$allowedMediaType);
    
    $projSellstatus         =   (!empty($projData->projSellstatus))?$projData->projSellstatus:'f';
    $createWaterMarkFlag    =   ($projSellstatus=="t")?'1':'0';
    
    // set embed path in edit
    if(isset($isExternal) && $isExternal == 't') {
        $embeddCode = $filePath;
    }
    $isExternalInput = array(
        'name'	=> 'isExternal'.$browseId,
        'value'	=> 'f',
        'id'	=> 'isExternal'.$browseId,
        'type'	=> 'hidden'
    );
    
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
    
    $embedArray = array(
        'id'	=> 'embbededURL'.$browseId,
        'name'	=> 'embbededURL'.$browseId,
        'class'	=> 'fl width605 p14 min-height_25 bdr_adadad urlCheckClass ',
        'rows' => 2,
        'cols' => 45,
        'value'=> (isset($embeddCode))?$embeddCode:'',
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
        'value'	=> $projectId,
        'id'	=> 'projectId'.$browseId,
        'type'	=> 'hidden'
    );
    
    $elementIdField = array(
        'name'	=> 'elementId'.$browseId,
        'value'	=> $elementId,
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
    
	$uploadedFileField = array(
        'name'	=> 'uploadedFile',
        'value'	=> $uplodedfileName,
        'id'	=> 'uploadedFile',
        'type'	=> 'hidden'
    );
    

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
	echo form_input($uploadedFileField);
     
    if($indusrtyName=='photographyNart' && $projSellstatus=="t"){
        echo form_input($createWaterMarkFlagField);
    }
    // set base url
    $baseUrl = formBaseUrl(); 
    //next page url 
    $nextUrl  =  $baseUrl.'/setdisplayimage/'.$projectId.'/'.$elementId ;
    if($indusrtyName == 'photographyNart') {
        $nextUrl = $baseUrl.'/uploadtitle/'.$projectId.'/'.$elementId;
    }
   
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

 <div class="sap_50"></div>
        <h4 class="fs19 red  bb_aeaeae" >
            <?php 
            $fileHeading  = $this->lang->line('uploadStage_uploadFileHeading');
            $fileType = array("{{var fileType}}");
            $replaceFileType = array($fileFormateNames['fileType']);
            echo str_replace($fileType,$replaceFileType,$fileHeading);?>
        </h4>
    <div class="sap_30"></div>
    <?php  if(isset($isExternal) && $isExternal == 'f') { ?>
        <div class="fs14 font_weight pb10"><?php echo $uplodedfileName;?></div>
    <?php } ?>
    
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

    <ul class="org_list clearb">
        <li class="icon_2"><?php echo $this->lang->line('uploadStage_AcceptedFileTypes'); ?> <?php echo $allowedMediaType;?>. </li>
        <li>
            <?php echo $this->lang->line('uploadStage_uploadFileInfo'); ?>
        </li>
    </ul>
    <!------ Embedd media file ------>
    <?php 
    if($projData->projSellstatus == 'f' && $industry == 'filmNvideo') { ?>
        <div class="sap_15"></div>
        <p class="fshel_ultra fs28 text_alighC" > <?php echo $this->lang->line('uploadStage_OR'); ?></p>
        <div class="sap_15"></div>
        <div class="c_1 clearbdisplay_inline_block">
            <h4 class="fs19 red mb10  bb_aeaeae" > 
                <?php 
                $embeddHeading  = $this->lang->line('uploadStage_embedFileHeading');
                $embeddFileType = array("{{var fileName}}");
                $replaceEmbeddFileType = array(ucfirst($fileFormateNames['fileName']));
                echo str_replace($embeddFileType,$replaceEmbeddFileType,$embeddHeading);?>
             </h4>
             <div class="sap_30"></div>
            <?php echo form_textarea($embedArray); ?>
            <ul class="org_list fl">
                <li class="icon_2">
                    <?php 
                    $fileNameHeading  = $this->lang->line('uploadStage_embedFileInformation');
                    $fileName = array("{{var fileName}}");
                    $replaceFileType = array($fileFormateNames['fileName']);
                    echo str_replace($fileName,$replaceFileType,$fileNameHeading);?>
                </li>
            </ul>
        </div>
    <?php } ?>

<script type="text/javascript">

    //call upload method for files uploading
    uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $fileMaxSize;?>','<?php echo $browseId;?>',1,'<?php echo $isReloadPage;?>',0,'<?php echo $imgload;?>','','_xs','1','<?php echo  $nextUrl; ?>');

    //fire trigger for file uploading
    $(document).ready(function(){   
        $('.uploadFileAction').click(function() {
            
            var fileInput       =  $("#fileInput<?php echo $browseId?>").val();
            var fileName       =  $("#fileName<?php echo $browseId?>").val();
            var embbededURL     =  $("#embbededURL<?php echo $browseId?>").val();
            var fileErrorInput  =  $("#fileErrorInput<?php echo $browseId?>").val();
            var nextPageUrl     =  '<?php echo $baseUrl.$nextPage;?>';
            var projectId       =  '<?php echo $projectId ?>';
            
            if(fileInput!="" || embbededURL!= undefined){
                    
                if(fileErrorInput=="0"){
                        
                    var fromData=$("#mediaFileForm").serialize();
                    //var url = '<?php echo $baseUrl;?>'+'/uploadfilepost';
                    var url = baseUrl+language+'/media/uploadfilepost';
                    
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
                        if(data.isExternalFile==true){
                            window.location.href = '<?php echo $baseUrl ?>'+data.nextUrl;
                        }
                        
                        }
                    },"json");
                }
            } else {
				var uploadedFile = $('#uploadedFile').val();
				if(uploadedFile != '' && fileName == '' ) {
					window.location.href = '<?php echo $nextUrl ?>';
				} else {
					alert('Upload the file first.');
				}
				
			}
            
            return false;
        });
    });
    
    $('.urlCheckClass').blur(function(){
        var url = '<?php echo $baseUrl;?>'+'/embededVideoCheck';
        var val = $('.urlCheckClass').val();
        var fromData =  { 'val':val };
         $.post(url,fromData, function(data) {
                    if(data){
                        if(data.result == 0)
                        {
                            customAlert('Invalid Embed File');
                            $('.urlCheckClass').val('');
                        }
                    }
                },"json");
        
        });
    

</script>
