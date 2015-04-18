<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$displayImageForm = array(
'name'=>'displayImageForm',
'id'=>'displayImageForm',
);

// set base url
$baseUrl = base_url(lang().'/workprofile/');
$stockChecked = '';

$browseId           =   '1';
$fileSize           =   0;   
$filePath           =   $dirUploadMedia;
$imgload            =   0;    
$fileName           =   ''; 
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
    
    $uploadedFileField = array(
        'name'	=> 'uploadedFile',
        'value'	=> (isset($workProfileDetails->fileName) && !empty($workProfileDetails->fileName)) ? $workProfileDetails->fileName : '',
        'id'	=> 'uploadedFile',
        'type'	=> 'hidden'
    );
    
    //next page url 
    $nextUrl  =  base_url(lang().'/workprofile/contactdetails');
    
	//get user showcase details
	$userInfo   =  showCaseUserDetails($userId);

	//get user first name
	$userFullName = $userInfo['userFullName'];
	$imageSize = '_m';
	if(!empty($userInfo['creative']) || !empty($userInfo['associatedProfessional']) || !empty($userInfo['enterprise'])){ 
		$userDefaultImage = ($userInfo['enterprise']=='t')?$this->config->item('defaultEnterpriseImg'.$imageSize):($userInfo['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg'.$imageSize):$this->config->item('defaultCreativeImg'.$imageSize));
	} else {
		$userDefaultImage = $this->config->item('defaultMemberImg'.$imageSize);
	}

	$userTemplateThumbImage = addThumbFolder($userInfo['userImage'],$imageSize);	
	$userImage = getImage($userTemplateThumbImage,$userDefaultImage);
    
    ?>
    
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <div class="c_1 clearb">
        <?php echo form_open($baseUrl.'/yourdetails',$displayImageForm); ?>
            <h3>Upload your Profile Image*</h3>
            <div class="sap_25"></div>
            <div class="clearbox">
                <?php
                if(isset($workProfileDetails->filePath) && !empty($workProfileDetails->filePath)) {
                   
                    $userDefaultImage = $this->config->item('sectionIdImage32');
 
                    $workprofileThumbImage = addThumbFolder($workProfileDetails->filePath.$workProfileDetails->fileName,'_m');	
                    $workprofileImage = getImage($workprofileThumbImage,$userDefaultImage);
                    ?>
                    <div class="thum fl display_table bc2c2c2 wh172x170">
                        <div class="table_cell"> <img src="<?php echo $workprofileImage;?>" class="max_172X170" /> </div>
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
                    <div class="sap_25"></div>
                    <p> Minimum recommended dimensions are:</p>
                    <p>Square: 175 x 175  pixels</p>
                </div>    
             </div>          
            <ul class="review">
                <li class="icon_2"><?php echo $this->lang->line('uploadStage_AcceptedFileTypes'); ?> <?php echo $allowedMediaType;?>. </li>
            </ul>
        
            <div class="or_text opens_light fs26imp">OR</div>

            <div class="clearbox width100_per defaultP">
                <div class="fl">
                    <label><input type="radio" name="isProfileImage" id="isProfileImage" value="1" <?php if($workProfileDetails->isProfileImage == 't') { echo 'checked="checked"';}?> />
                    <span class="pl5">Use a default image.</span></label>
                    <span><img src="<?php echo $userImage;?>" class="max_172X170"></span>
                </div>

               <div class="sap_50"></div>
			<div class="bb_aeaeae"></div>
			<div class="mb20 mt20"> You can use to hide your Profile image.</div>
            <ul class="clearb fl defaultP pr0">
                <li class="pb20 fl">
                    <input class="" type="checkbox" name="isHideImageFromOnlineWP" <?php if($workProfileDetails->isHideImageFromOnlineWP == 't') { ?> checked="checked" <?php } ?> />
                    <span class="fl width600">
                        <?php echo 'from online Work Profile';?>    
                    </span>
                </li>
                <li class="fl">
                    <input class="" type="checkbox" name="isHideImageFromCV" <?php if($workProfileDetails->isHideImageFromCV == 't') { ?> checked="checked" <?php } ?> />
                    <span class="fl width600">
                        <?php echo 'from your printed CV (PDF)';?>     
                    </span>                              
                </li>
            </ul>
            <ul class="clearb org_list">
				<li class="icon_2">Fill in the fileds in the Work Profile & Portfolio wizard as suit your cuscumstances.<br/>No fields are required.</li>
			</ul>
            
            </div>
            <?php  
            echo form_input($fileNameInput);
            echo form_input($fileSizeInput);
            echo form_input($typeOfFileInput);
            echo form_input($fileUploadPathInput);
            echo form_input($fileErrorInput);
            echo form_input($browseIdField);
            echo form_input($uploadedFileField);
             
        echo form_close(); ?>
    </div>
	<!-- Form buttons -->
	<?php 
    // set back url
    $data['backHistory'] =  '1';
    // set next form name
    $data['formName'] = 'displayImageForm';
    $this->load->view('workProfile/wizardform/common_buttons',$data);
    ?>
</div>
<script type="text/javascript">
    
    //call upload method for files uploading
    uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $this->config->item('imageSize');?>','<?php echo $browseId;?>',1,0,0,'<?php echo $imgload;?>','','_xs','0','<?php echo  $nextUrl; ?>','1','2');

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
                var fromData  = $("#displayImageForm").serialize();
                var fileInput = $('#fileInput1').val();
         
                if(fileInput != '') {
                    $('input[name=isProfileImage]:checked').val('');
                }
                
                if ($('#isProfileImage').is(':checked') || fileInput != ''){
                    return true;
                } 
            }
        });
       
        $('.uploadFileAction').click(function() {
            var fileInput =  $("#fileInput<?php echo $browseId?>").val();
			var fileName  =  $("#fileName<?php echo $browseId?>").val();
            var fileErrorInput   =  $("#fileErrorInput<?php echo $browseId?>").val();
            var profile_img =  $('input[name=isProfileImage]:checked').val();
           
            if((fileInput != '' || profile_img != undefined) && (fileErrorInput=='0')) {
                var fromData = $("#displayImageForm").serialize();
                var url = '<?php echo $baseUrl;?>'+'/setprofileimage';
                $.post(url,fromData, function(data) {
                    if(data){
                        if(fileInput != '') {
                           
                            if(fileName == undefined){
                                fileName = '';
                            }
                        }
                        
                        $("#uploadFileByJquery<?php echo $browseId;?>").click();
                    
                         // redirect to next page 
                        if(data.isProfileImg==true){
                         window.location.href = data.nextUrl;
                        }
                    }
                },"json");
            } else {
				var uploadedFile = $('#uploadedFile').val();
				if(uploadedFile != '' && fileName == '' ) {
					window.location.href = '<?php echo $nextUrl ?>';
				} else {
					 alert('Please select image first!');
					return false;
				}
			}  
            return false;
        });
    
    });
    
</script>

