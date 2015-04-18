<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

    $formAttributes = array(
        'name'=>'showcaseVideoForm',
        'id'=>'showcaseVideoForm',
    );
    // set base url
    $baseUrl = base_url(lang().'/showcase/');
    $nextPage = '/showcase/communication';
    $videoTitleField = 'interviewTitle';
    $backPage = '/showcase/yourvideo/';
    if($videoType == 0) {
        $videoTitleField = 'introductoryTitle';
        $nextPage = '/showcase/yourvideo/1';
        $backPage = '/showcase/otherlanguage/';
    }
    $titleValue = set_value($videoTitleField)?set_value($videoTitleField):$showcaseRes->$videoTitleField;
    $titleValue = htmlentities($titleValue);

    $titleValueInput = array(
        'name'        =>  $videoTitleField,
        'id'          =>  $videoTitleField,
        'class'       =>  'required width527 min-height_25 mt14 bdr_adadad',
        //'title'     =>  $this->lang->line('TheseWordsImprove'),
        'value'       =>  html_entity_decode($titleValue),
        'wordlength'  =>  "1,15",
        'onkeyup'     =>  "checkWordLen(this,15,'titleLimit')",
        'placeholder' =>  "Video Title",
        'onBlur'      =>  "placeHoderHideShow(this,'Video Title','show')",
        'onClick'     =>  "placeHoderHideShow(this,'Video Title','hide')"
    );

    $browseId           =   '1';
    $fileSize           =   0;   
    $filePath           =   $dirUploadMedia;
    $imgload            =   0;    
    $fileName           =   isset($fileName)?$fileName:''; 
    $allowedMediaType   =   str_replace(',',', ',$this->config->item('videoType'));
    $mediaFileTypes     =   $this->config->item('videoAccept');

    // set embed path in edit
    if(isset($mediaFileData->isExternal) && $mediaFileData->isExternal == 't') {
        $embeddCode = $mediaFileData->filePath;
    }
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
        'class'	=> 'fl width472 p12 bdr_adadad mt0 uploadFile',
        'value'	=> '',
        'id'	=> 'fileInput'.$browseId,
        'type'	=> 'text',
        'readonly'	=> true
    );
    
    $embedArray = array(
        'id'	=> 'embbededURL'.$browseId,
        'name'	=> 'embbededURL'.$browseId,
        'class'	=> 'width610 min-height_25 mt14 bdr_adadad urlCheckClass',
        'rows' => 1,
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
    
    $browseIdField = array(
        'name'	=> 'browseId',
        'value'	=> $browseId,
        'id'	=> 'browseId',
        'type'	=> 'hidden'
    );
    
    $videoTypeField = array(
        'name'	=> 'videoType',
        'value'	=> $videoType,
        'id'	=> 'videoType',
        'type'	=> 'hidden'
    );

    $business = '';
    if(isset($isEnterprise)) {
        $business = 'Business';
    }
?>


<div class="content display_table overflow_hidden  TabbedPanelsContent width635 m_auto">
    <?php   
    echo form_open($baseUrl.'/setshowcasevideos/',$formAttributes); 
    ?>
       <div class="clearbox">
            <h3><?php echo $this->lang->line('showcaseVideoHead')?></h3>
            <div class="sap_15"></div>
            <div class="fs16 lineH18"><?php echo $this->lang->line('showcaseVideoNote');?></div>
            <ul class="form_img upload_showcase_video">
                <li>
                    <h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('videoTitle')?></h4>
                    <div class="width540">
                        <span class="fs13 pl10 fshel_midum">1 - 15 words</span> 
                        <span class="red fr fs13 fshel_midum">
                            <span id="titleLimit"><?php echo str_word_count($titleValue);?></span>  
                            <span>words</span> 
                        </span>
                    </div>
                    <?php echo form_input($titleValueInput); ?>
                </li>
                
                <li>
                    <h4 class="red fs21  bb_aeaeae">Upload Video</h4>
                        <?php  if(isset($mediaFileData->isExternal) && $mediaFileData->isExternal == 'f') { ?>
                        
                        <p class="fs14 font_weight pb10"><?php echo $mediaFileData->rawFileName;?></p>
                    <?php } ?>
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
    
                    <div id="uploadFileSection<?php echo $browseId;?>" >
      
                    <div>
                        <div class="<?php echo $VFS;?> <?php echo $UF;?><?php echo $imgLoadClass;?>" id="Uploadvideo<?php echo $browseId;?>">
                            <div id="FileUpload<?php echo $browseId;?>">
                                <?php echo form_input($inputArray); ?>
                                <div id="browsebtn<?php echo $browseId;?>" class="fileUpload fr btn fs11 fshel_bold text_alighC bg_dfdfdf bdr_adadad p14 width88"> <span><?php echo $this->lang->line('uploadStage_browse'); ?></span>
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
                </li>
                <li class="icon_2 pt0 mt25"><?php echo $this->lang->line('uploadStage_AcceptedFileTypes'); ?> <?php echo $allowedMediaType;?>.</li>
                <li class="or_text opens_light fs20 ml0">OR </li>
                <li class="pt0">
                    <h4 class="red fs21 bb_aeaeae">Embed Video</h4>
                      <?php echo form_textarea($embedArray); ?>
                </li>
                <li class="icon_2 pt0 mt25">
                    If you have photos on a photo sharing site, you can use the embed code from the image
                    on that site here. 
                </li>
            </ul>
        </div>
    <?php 
        echo form_input($fileNameInput);
        echo form_input($fileSizeInput);
        echo form_input($typeOfFileInput);
        echo form_input($isExternalInput);
        echo form_input($fileUploadPathInput);
        echo form_input($fileErrorInput);
        echo form_input($browseIdField);
        echo form_input($videoTypeField);
    echo form_close();?>
        <!-- Form buttons -->
        <?php 
        // set back page
        $data['backPage'] = $backPage;
        // set next form name
        $data['formName'] = 'showcaseVideoForm';
        // set skip url
        if(!empty($mediaFileData)) {
            $data['skipPage'] = $nextPage;
        }
        $this->load->view('wizardform/showcase_buttons',$data);
        ?>
</div>
<script type="text/javascript">
    
    //call upload method for files uploading
    uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $this->config->item('videoSize');?>','<?php echo $browseId;?>',1,1,0,'<?php echo $imgload;?>','','_xs','1','<?php echo  $baseUrl.$nextPage; ?>');
    
   
    //fire trigger for file uploading
    $(document).ready(function(){   
         $("#showcaseVideoForm").validate({
            submitHandler: function() {
                var fromData = $("#showcaseVideoForm").serialize();
                var fileInput = $('#fileInput1').val();
               
                if(fileInput != '') {
                    $('input[name=profile_img]:checked').val('');
                    $('input[name=stock_img]:checked').val('');
                }
            }
        });
        
        $('.uploadFileAction').click(function() {
            
            var fileInput       =  $("#fileInput<?php echo $browseId?>").val();
            var embbededURL     =  $("#embbededURL<?php echo $browseId?>").val();
            var fileErrorInput  =  $("#fileErrorInput<?php echo $browseId?>").val();
            var nextPageUrl     =  '<?php echo $baseUrl.$nextPage;?>';
          
            if(embbededURL == 0){ embbededURL = ''; }// Convert embeded url 0 to null
            
            if(fileInput!="" || embbededURL!="") {
                    
                if(fileErrorInput=="0") {
                        
                    var fromData=$("#showcaseVideoForm").serialize();
                    var url = '<?php echo $baseUrl;?>'+'/uploadfilepost';
                    
                    $.post(url,fromData, function(data) {
                      if(data){
                        
                        if(data.fileId != undefined &&  (data.fileId > 0)){
                          $("#MediaFileId").val(data.fileId);
                        }  
                         
                        $("#uploadFileByJquery<?php echo $browseId;?>").click();
                        
                        var fileName =  $("#fileName<?php echo $browseId?>").val();
                        if(fileName == undefined){
                            fileName = '';
                        }
                         
                        // redirect to next page 
                        if(data.isExternalFile==true){
                            window.location.href = data.nextUrl;
                        }
                        
                        }
                    },"json");
                }
            } else {
				customAlert('Please select Video');
			}
            
            return false;
        });
    });


   $('.urlCheckClass').blur(function(){
        var url = '<?php echo base_url_lang('media/embededVideoCheck');?>';
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
