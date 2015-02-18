<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$displayImageForm = array(
'name'=>'displayImageForm',
'id'=>'displayImageForm',
);

// set base url
$baseUrl = base_url(lang().'/showcase/');
$stockChecked = '';
$stockImageId = 0;

$browseId           =   '1';
$fileSize           =   0;   
$filePath           =   $dirUploadMedia;
$imgload            =   0;    
$fileName           =   isset($showcaseRes->profileImageName)?$showcaseRes->profileImageName:''; 
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
        'class'	=> 'fl width_280 p12 bdr_adadad pb11 ',
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
    
    //next page url 
    $nextUrl  =  base_url(lang().'/showcase/showcasedetails');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <div class="c_1 clearb">
        <?php echo form_open($baseUrl.'/uploadelementfilepost',$displayImageForm); ?>
            <h3>Upload your Profile Image*</h3>
            <div class="sap_25"></div>
            <div class="clearbox">
                <?php 
                if(isset($showcaseRes->profileImageName) && !empty($showcaseRes->profileImageName)) {
                   
                    if(!empty($showcaseRes->creative) || !empty($showcaseRes->associatedProfessional) || !empty($showcaseRes->enterprise)) {
                       
                        $userDefaultImage=($showcaseRes->enterprise=='t')?$this->config->item('defaultEnterpriseImg_m'):($showcaseRes->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_m'):$this->config->item('defaultCreativeImg_m'));
                    } else {
                        $userDefaultImage=$this->config->item('defaultMemberImg_m');
                    }
                    
                    $userTemplateThumbImage = addThumbFolder($dirUploadMedia.'/'.$showcaseRes->profileImageName,'_m');	
                    $userImage = getImage($userTemplateThumbImage,$userDefaultImage);
                    ?>
                    <div class="thum fl display_table bdr7474 wh172x170">
                        <div class="table_cell"> <img src="<?php echo $userImage;?>" class="max_172X170" /> </div>
                    </div>
                <?php 
                } ?>
                <div class="pl18 fl">
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
                    <div class="input_box" id="uploadFileSection<?php echo $browseId;?>" >
                        <div>
                            <div class="<?php echo $VFS;?> <?php echo $UF;?><?php echo $imgLoadClass;?>" id="Uploadvideo<?php echo $browseId;?>">
                                <div id="FileUpload<?php echo $browseId;?>">
                                    <?php echo form_input($inputArray); ?>
                                    <div id="browsebtn<?php echo $browseId;?>" class="fileUpload fr btn btn-primary fs11 ml18 fshel_bold text_alighC bg_dfdfdf bdr_adadad p14 width88"> 
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
                    <div class="sap_40"></div>
                    <p> Minimum recommended dimensions are:</p>
                    <p>Square: 175 x 175  pixels</p>
                </div>    
             </div>          
            <ul class="review">
                <li class="icon_2"><?php echo $this->lang->line('uploadStage_AcceptedFileTypes'); ?> <?php echo $allowedMediaType;?>. </li>
            </ul>
        
            <div class="or_text opens_light fs26imp">OR</div>

            <div class="clearbox width100_per defaultP">
                <?php
                if(isset($showcaseRes->stockImageId) && !empty($showcaseRes->stockImageId)) {
                    $stockChecked = 'checked';
                    $stockImageId = $showcaseRes->stockImageId;
                }
                ?>
                <div class="fl">
                    <label><input type="radio" name="profile_img" id="profile_img" value="1" <?php echo $stockChecked?>/>
                    <span class="pl5">Use a default image.</span></label>
                </div>

                <div class="fr display_table">
                    <?php
                    $i = 1;
                    foreach($stockImgRes as $stockImgRes) { ?>
                        <div class="fl <?php echo ($i==2)?'ml46':'';?>">
                            <span class="mt85 fl">		
                            <input type="radio" name="stock_img" id="stock_img<?php echo $i;?>" value="<?php echo $stockImgRes->stockImgId;?>" <?php echo ($stockImgRes->stockImgId==$stockImageId)?'checked':'';?>/></span>
                            <div class="display_table fl">
                                <span class="p3 bdrccc table_cell wh122X182"><img src="<?php echo base_url($stockImgRes->stockImgPath.'/'.$stockImgRes->stockFilename);?>" alt="" class="bdrccc" /></span>
                            </div>	
                        </div>
                    <?php 
                    $i++;
                    } ?>
                </div> 
            </div>
            <?php  
            echo form_input($fileNameInput);
            echo form_input($fileSizeInput);
            echo form_input($typeOfFileInput);
            echo form_input($fileUploadPathInput);
            echo form_input($fileErrorInput);
            echo form_input($browseIdField);
             
        echo form_close(); ?>
    </div>
   <!-- Form buttons -->
    <?php 
    // set back url
    $data['backPage'] =  '/showcase/creativeindustry';
    // set skip url
    if(!empty($showcaseRes->stockImageId) || !empty($showcaseRes->profileImageName)) {
        $data['skipPage'] = '/showcase/showcasedetails';
    }
    // set next form name
    $data['formName'] = 'displayImageForm';
    $this->load->view('wizardform/showcase_buttons',$data);
    ?>
</div>
<script type="text/javascript">
    
    //call upload method for files uploading
    uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $this->config->item('imageSize');?>','<?php echo $browseId;?>',1,1,0,'<?php echo $imgload;?>','','_xs','1','<?php echo  $nextUrl; ?>');

    //fire trigger for file uploading
    $(document).ready(function() {
       
        $('#profile_img').click(function() {
            if ($('#profile_img').is(':checked')){
                $("#stock_img1").attr('checked', 'checked');
            }
            runTimeCheckBox();
        });
        
        $("input[name='stock_img']").click(function() {
            $("#profile_img").attr('checked', 'checked');
            runTimeCheckBox();
        });
        
    
        
         $("#displayImageForm").validate({
            submitHandler: function() {
                var fromData = $("#displayImageForm").serialize();
                var fileInput = $('#fileInput1').val();
                
                if(fileInput != '') {
                    $('input[name=profile_img]:checked').val('');
                    $('input[name=stock_img]:checked').val('');
                }
                
                if ($('#profile_img').is(':checked') || fileInput != ''){
                    return true;
                } else {
                    alert('Please select image first!');
                    return false;
                }
            }
        });
       
        $('.uploadFileAction').click(function() {
            var fileInput        =  $("#fileInput<?php echo $browseId?>").val();
            var fileErrorInput   =  $("#fileErrorInput<?php echo $browseId?>").val();
            var profile_img =  $('input[name=profile_img]:checked').val();
           
            if((fileInput != '' || profile_img != undefined) && (fileErrorInput=='0')) {
                var fromData = $("#displayImageForm").serialize();
                var url = '<?php echo $baseUrl;?>'+'/uploadelementfilepost';
                $.post(url,fromData, function(data) {
                    if(data){
                        if(fileInput != '') {
                            var fileName =  $("#fileName<?php echo $browseId?>").val();
                            if(fileName == undefined){
                                fileName = '';
                            }
                        }
                        
                        $("#uploadFileByJquery<?php echo $browseId;?>").click();
                    
                         // redirect to next page 
                        if(data.isStockImg==true){
                         window.location.href = data.nextUrl;
                        }
                    }
                },"json");
            }
            return false;
        });
        
   
    });
</script>
