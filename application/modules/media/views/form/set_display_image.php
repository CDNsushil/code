<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    
    $displayImageForm  =  array(
        'name' =>  'displayImageForm',
        'id'   =>  'displayImageForm'
    );
   
    $browseId           =   '1';
    $fileSize           =   0;   
    $filePath           =   $dirUploadMedia.'/images';
    $imgload            =   0;    
    $fileName           =   isset($fileName)?$fileName:''; 
    $allowedMediaType   =   str_replace(',',', ',$this->config->item('imageType'));
    $mediaFileTypes     =   $this->config->item('imageAccept');
    
    $fileNameInput = array(
        'name'	=> 'fileName'.$browseId,
        'value'	=> $fileName,
        'id'	=> 'fileName'.$browseId,
        'type'	=> 'hidden',
    );
    
    $fileSizeInput = array(
        'name'	=> 'fileSize'.$browseId,
        'value'	=> $fileSize,
        'id'	=> 'fileSize'.$browseId,
        'type'	=> 'hidden'
    );
    
    $typeOfFileInput = array(
        'name'	=> 'fileType'.$browseId,
        'value'	=> 1,
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
        'name'	=> 'projectId',
        'value'	=> $projectId,
        'id'	=> 'projectId',
        'type'	=> 'hidden'
    );
    
    $elementIdField = array(
        'name'	=> 'elementId',
        'value'	=> $elementId,
        'id'	=> 'elementId',
        'type'	=> 'hidden'
    );
    
    $elementEntityIdField = array(
        'name'	=> 'elementEntityId',
        'value'	=> $elementEntityId,
        'id'	=> 'elementEntityId',
        'type'	=> 'hidden'
    );
    
    $displayImageTypeField = array(
        'name'  => 'displayImageType',
        'value' => $displayImageType,
        'id'    => 'displayImageType',
        'type'  => 'hidden'
    );
    
    $embedImage = array(
        'id'	=> 'embbededURL',
        'name'	=> 'embbededURL',
        'class'	=> 'fl width605 p14 min-height_25  bdr_adadad required urlCheckClass',
        'rows' => 2,
        'cols' => 45,
        'value'=> $embeddUrl,
    );
    
    // set base url
    $baseUrl = formBaseUrl(); 
    $uploadFiledisplay = 'dn';
    $embeddFiledisplay = '';
   if(isset($displayImageType) && $displayImageType == 1) {
       $uploadFiledisplay = '';
       $embeddFiledisplay = 'dn';
   } 
   
    //next page url 
    $nextUrl  =  $baseUrl.'/uploadtitle/'.$projectId.'/'.$elementId ;
    // set upload form title
    if(!empty($imagePath)) {
        $uploadHeadTitle = $this->lang->line('editMediaReplaceImage');
        $data['skipPage'] = '/uploadtitle/'.$projectId.'/'.$elementId ;
    } else {
        $uploadHeadTitle = $this->lang->line('addDisplayImage');
        $data['isSkipstep'] = $isSkipstep;
    }
?>

<div class="TabbedPanelsContentGroup design_wrap width_665 m_auto ">
    <div class="TabbedPanelsContent width635 m_auto clearb TabbedPanelsContentVisible">
        <?php echo form_open($baseUrl.'/uploadelementfilepost',$displayImageForm); ?>
            <div class="c_1 clearb">
                <?php //if(isset($displayImageType) && $displayImageType == 1) { ?>
                <div class="<?php echo  $uploadFiledisplay;?>"> 
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
                    <h4 class="red fs21  bb_aeaeae" > <?php echo $uploadHeadTitle; ?></h4>
                    <div class="sap_30"></div>
                    <?php if(!empty($imagePath) && !empty($displayImageType)) {
                        // get element image
                        $elementImage = getElementImage($displayImageType,$imagePath,$indusrtyName);?>
                        <div id="repalce_img">
                            <img src="<?php echo $elementImage;?>" /> 
                        </div>
                    <?php } ?>
                    <div class="sap_30"></div>
                    <div id="uploadFileSection<?php echo $browseId;?>" >
                        <div>
                            <div class="<?php echo $VFS;?> <?php echo $UF;?><?php echo $imgLoadClass;?>" id="Uploadvideo<?php echo $browseId;?>">
                                <div id="FileUpload<?php echo $browseId;?>">
                                    <?php echo form_input($inputArray); ?>
                                    <div id="browsebtn<?php echo $browseId;?>" class="fileUpload fr btn btn-primary fs11 fshel_bold text_alighC bg_dfdfdf bdr_adadad p14 width88"> 
                                        <span><?php echo $this->lang->line('uploadStage_browse'); ?></span>
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
                    </ul>
                    <div class="sap_15"></div>
                </div>
                <div class="<?php echo  $embeddFiledisplay;?>"> 
                    <?php// } else { ?>
                    <div class="sap_30"></div>
                    <div class="c_1 clearbdisplay_inline_block">
                        <h4 class="fs19 red mb10  bb_aeaeae" > <?php echo $this->lang->line('embedImage'); ?></h4>
                        <div class="sap_30"></div>
                        <?php echo form_textarea($embedImage); ?>
                        <ul class="org_list fl">
                            <li class="icon_2">
                                <?php echo $this->lang->line('embedFileInfo'); ?>
                            </li>
                        </ul>
                    </div>
                <?php //}?>
                </div>
            </div>
            <?php  
            echo form_input($fileNameInput);
            echo form_input($fileSizeInput);
            echo form_input($typeOfFileInput);
            echo form_input($fileUploadPathInput);
            echo form_input($fileErrorInput);
            echo form_input($browseIdField);
            echo form_input($indusrtyNameField);
            echo form_input($projectIdField);
            echo form_input($elementIdField);
            echo form_input($elementEntityIdField);
            echo form_input($displayImageTypeField);
             
        echo form_close(); ?>
        <!-- Form buttons -->
        <?php 
        // set back page
        $data['backPage'] = '/setdisplayimage/'.$projectId.'/'.$elementId;
        // set next form name
        $data['formName'] = 'displayImageForm';
        
        $this->load->view('common_view/upload_buttons',$data);
        ?>
    </div>
</div>
<script type="text/javascript">
    
    //call upload method for files uploading
    uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $this->config->item('imageSize');?>','<?php echo $browseId;?>',1,1,0,'<?php echo $imgload;?>','','_xs','1','<?php echo  $nextUrl; ?>');

    //fire trigger for file uploading
    $(document).ready(function() {
         $("#displayImageForm").validate({
            submitHandler: function() {
                var fromData=$("#displayImageForm").serialize();
                var displayImageType =  $("#displayImageType").val();
                
                if(displayImageType == 1) {
                    var fileVal = $('#fileName1').val();
                    if(fileVal == '') {
                        alert('Please upload file.');
                        return false;
                    }
                }
            }
        });
        
        $('.uploadFileAction').click(function() {
            var fileInput        =  $("#fileInput<?php echo $browseId?>").val();
            var fileErrorInput   =  $("#fileErrorInput<?php echo $browseId?>").val();
            var displayImageType =  $("#displayImageType").val();
            var embbededURL      =  $("#embbededURL").val();
           
            if((fileInput != '' || embbededURL != '') && (fileErrorInput=='0')) {
                var fromData = $("#displayImageForm").serialize();
                var url = '<?php echo $baseUrl;?>'+'/uploadelementfilepost';
                $.post(url,fromData, function(data) {
                    if(data){
                        if(displayImageType == 1) {
                         //   $("#uploadFileByJquery<?php echo $browseId;?>").click();
                            var fileName =  $("#fileName<?php echo $browseId?>").val();
                            if(fileName == undefined){
                                fileName = '';
                            }
                        }
                        
                        $("#uploadFileByJquery<?php echo $browseId;?>").click();
                    
                         // redirect to next page 
                        if(data.isExternalFile==true){
                         window.location.href = '<?php echo $baseUrl ?>' + data.nextUrl;
                        }
                    }
                },"json");
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

