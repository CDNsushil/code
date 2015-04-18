<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$continerSize=isset($values->containerSize)?$values->containerSize:$this->config->item('defaultContainerSize');
$continerSize=bytestoMB($continerSize,'mb');
$dirname=$dirUploadMedia;
$dirSize=bytestoMB(getFolderSize($dirname),'mb');
$reminingSize=($continerSize-$dirSize);
if($reminingSize < 0){
		$reminingSize = 0;
}
$dirSize = number_format($dirSize,2,'.','');
$reminingBytes = mbToBytes($reminingSize,'mb');
$reminingSize = number_format($reminingSize,2,'.','');
$fileMaxSize=$reminingBytes;
/* First save Blog popup Start*/
$isShowBlogPopup=$this->session->userdata('isShowBlogPopup');
if(isset($isShowBlogPopup) && $isShowBlogPopup==1) {
	$this->session->unset_userdata('isShowBlogPopup');
	$blogUrl['indexUrl'] = site_url(lang()).'/blog';
	$blogUrl['popupSection'] = 'blog';
	$popup_media = $this->load->view('common/afterSavePopup',$blogUrl,true);
	?>
		<script>
			var popup_media = <?php echo json_encode($popup_media);?>;
			loadPopupData('popupBoxWp','popup_box',popup_media);
		</script>
	<?php
}
/* First save Blog popup End*/

$displayImageForm = array(
	'name'=>'displayImageForm',
	'id'=>'displayImageForm',
);

// set base url
$baseUrl = base_url(lang().'/blog/');
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
    
	$blodIdField = array(
        'name'	=> 'blogId', 
        'value'	=>  (isset($blogData))?$blogData->blogId:0,
        'id'	=> 'blogId',
        'type'	=> 'hidden'
    );
     
	$embedImage = array(
        'id'	=> 'embbededURL',
        'name'	=> 'embbededURL',
        'class'	=> 'fl width605 p14 min-height_25 bdr_adadad',
        'rows' => 2,
        'cols' => 45,
        'value'=> $embeddUrl,
    );
    
    //next page url 
    $nextUrl  =  base_url(lang().'/blog/blogtitlendescription');
   
?>

<div class="content TabbedPanelsContent width635 m_auto">
	<div class="c_1 clearb">
		<?php echo form_open($baseUrl.'/uploadblogimage',$displayImageForm); ?>
			<h3>Upload Display Image</h3>
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
			
			<?php 
			if($blogData->isExternal == 'f' && !empty($blogData->fileName)) {
				// get blog image
				$blogImagePath = getBlogImage($blogData,1);?>
				<div id="repalce_img">
					<img src="<?php echo $blogImagePath;?>" /> 
				</div>
				<div class="sap_30"></div>
			<?php } ?>
			
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
			
			<div class="sap_35"></div>
			<ul class="org_list pt0">
				<li class="icon_2">Accepted File Types: gif, jpeg, jpg, png, tiff, tif, raw, bmp, ppm, pgm, pmb, pnm, tga. </li>
				<li>
					Minimum recommended dimensions are:
					<p>Landscape and Square: 1000 pixels wide</p>
					<p>Portrait:  720 pixels high.</p>
				</li>
			</ul>
			<div class="sap_25"></div>
			<div class="fl fs28" > OR</div>
			<div class="sap_15"></div>
			<div class="c_1 clearb">
				<h4 class="fs21 red bb_b7b7b7" >Embed Display Image</h4>
				<div class="sap_30"></div>
				<?php echo form_textarea($embedImage); ?>
				<div class="sap_35"></div>
				<ul class="org_list pt0">
					<li class="icon_2">
						If you have photos on a photo sharing site, you can use the embed to code from that site
						<p>here. </p>
					</li>
				</ul>
			</div>
			<div class="sap_25"></div>
			<div class="fl fs28" > OR</div>
			<div class="sap_30"></div>
			<div class="c_1 clearb">
				<div class="defaultP">
					<label>
						<?php
						if(isset($blogData->isProfileCoverImage) && $blogData->isProfileCoverImage == 't') {
							$profileChecked = 'checked';
						}
						?>
						<input type="radio" name="isProfileCoverImage" id="isProfileCoverImage" value="1" <?php echo $profileChecked?> />
						Use your Profile Image.
					</label>
				</div>
			</div>
			
			<?php  
			echo form_input($fileNameInput);
			echo form_input($fileSizeInput);
			echo form_input($typeOfFileInput);
			echo form_input($fileUploadPathInput);
			echo form_input($fileErrorInput);
			echo form_input($browseIdField);  
			echo form_input($blodIdField); 
		echo form_close(); ?>
	</div>
	<!-- Form buttons -->
    <?php 
    // set back url
    $data['backPage'] = '/blog/blogcoverimage';
	// set skip url
	if(!empty($blogData->fileId) || !empty($blogData->rawFileName)) {
        $data['skipPage'] = '/blog/blogtitlendescription';
    }
    // set next form name
    $data['formName'] = 'displayImageForm';
    $this->load->view('wizardform/blog_buttons',$data); ?>
</div>

<script type="text/javascript">
    
    //call upload method for files uploading
    uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $this->config->item('imageSize');?>','<?php echo $browseId;?>',1,1,0,'<?php echo $imgload;?>','','_xs','1','<?php echo  $nextUrl; ?>');

    //fire trigger for file uploading
    $(document).ready(function() {
       
         $("#displayImageForm").validate({
            submitHandler: function() {
                var fromData = $("#displayImageForm").serialize();
                var fileInput = $('#fileInput1').val();
                var embbededURL   = $('#embbededURL').val();
                if(fileInput != '') {
                    $('input[name=isProfileCoverImage]:checked').val('');
                }
                
                if ($('#isProfileCoverImage').is(':checked') || fileInput != '' || embbededURL != ''){
                    return true;
                } else {
                    alert('Please select image first!');
                    return false;
                }
            }
        });
       
        $('.uploadFileAction').click(function() {
            var fileInput       =  $("#fileInput<?php echo $browseId?>").val();
            var fileErrorInput  =  $("#fileErrorInput<?php echo $browseId?>").val();
            var profile_img     =  $('input[name=isProfileCoverImage]:checked').val();
			var embbededURL     =  $('#embbededURL').val();
			
            if((fileInput != '' || embbededURL != '' || profile_img != undefined) && (fileErrorInput=='0')) {
                var fromData = $("#displayImageForm").serialize();
                var url = '<?php echo $baseUrl;?>'+'/uploadblogimage';
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
                        if(data.isStatus==false) {
							window.location.href = data.nextUrl;
                        }
                    }
                },"json");
            }
            return false;
        });
        
   
    });
</script>
