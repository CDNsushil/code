<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$galleryForm = array(
	'name'=>'galleryForm',
	'id'=>'galleryForm',
);

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
	'class'	=> 'fl width472 p12 bdr_adadad pb11',
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
	'value'	=>  (isset($blogId))?$blogId:0,
	'id'	=> 'blogId',
	'type'	=> 'hidden'
);

$mediaTitleInput = array(
    'name'        =>  'mediaTitle',
    'id'          =>  'mediaTitle',
    'class'       =>  'bdr_adadad clr_444 width612 required',
    'value'       =>  '',
    'placeholder' =>  "Alt Tags",
    'onBlur'      =>  "placeHoderHideShow(this,'Alt Tags','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Alt Tags','hide')"
);
 
$mediaIdField = array(
	'name'	=> 'mediaId', 
	'value'	=>  0,
	'id'	=> 'mediaId',
	'type'	=> 'hidden'
);
// get gallery media count
$galleryMediaCount = (!empty($blogGalleryList))?count($blogGalleryList):0;
 
// set base url
$baseUrl = base_url(lang().'/blog/');
//next page url 
$nextUrl  =  base_url(lang().'/blog/blogmediagallery');
?>
<div class="content TabbedPanelsContent width635 m_auto">
	
	<div class="c_1 clearb">
		<?php echo form_open($baseUrl.'/uploadbloggalleryimage',$galleryForm); ?>
			<h3>Add Images to your Media Gallery</h3>
			<div class="sap_25"></div>
			<div id="mediaUploadImage"> 
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
			
				<div class="sap_25"></div> 
				<ul class="org_list pt0">
					<li class="icon_2">Accepted File Types: gif, jpeg, jpg, png, tiff, tif, raw, bmp, ppm, pgm, pmb, pnm, tga. </li>
				</ul>
			</div>
			
			<div id="uploadedImgName"></div>
				
			<div class="sap_25"></div>
			<div class="clearbox">
				<h5 class="red pb5 fs15 font_bold pl5">Add Alt Tags</h5>
				<?php 
				echo form_input($mediaTitleInput);
				echo form_input($mediaIdField);?>
				
				<div class="sap_10"></div>
				<button class=" fr red height40 bdr_a0a0a0 fshel_bold uploadFileAction" onclick="$('#galleryForm').submit();" >Save</button>
				<input type="button" class=" fr red height40 bdr_a0a0a0 fshel_bold mr10 dn" id="cancleFormBtn" onclick="cancleFormVal();" value="Cancle">
				<div class="sap_25"></div>
				
				<?php if(!empty($blogGalleryList)) { ?>
				<div class="alt_wrap" id="galleryMediaListDiv">
					<div class="alt_title pt10 pb10 font_bold clearbox red text_alighC"><span class="width106 fl">Image</span> <span>Alt Tags</span></div>
						<?php 
						foreach($blogGalleryList as $blogMedia) { 
							// set image path
							$imagePath = 'images/no_images.png';
							if(file_exists($blogMedia['filePath'].$blogMedia['fileName'])) {
								$imagePath = $blogMedia['filePath'].$blogMedia['fileName'];
							}
							?>
							<div class="alt_cntwrap bdrcece " id="media_<?php echo $blogMedia['mediaId'];?>">
								<div class="width106 alt_img table_cell"><img src="<?php echo site_url($imagePath)?>" alt="" /></div>
								<div class=" table_cell width520 text_alighL">
									<p class="stripv fl"><?php echo $blogMedia['mediaTitle'];?></p>
									<span class="red pt10 fr"> 
									<a onclick="EditMediaImage('<?php echo $blogMedia['mediaTitle'];?>','<?php echo $blogMedia['mediaId'];?>','<?php echo $blogMedia['rawFileName'];?>')"> Edit</a> / 
									<a onclick="deleteMedia('<?php echo $blogMedia['mediaId'];?>')">Delete </a> </span>
								</div>
							</div>
						<?php } ?> 
					</div>
				</div>
			<?php } ?> 
		
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
	<div class="fr btn_wrap display_block font_weight">
		<a href="<?php echo base_url(lang().'/home');?>"><button class="bg_ededed bdr_b1b1b1 mr5">Cancel</button></a>
		<a href="<?php echo $baseUrl.'/blogsetup'?>"><button class=" back bdr_b1b1b1 mr5" >Back </button></a>
		<a href="<?php echo $baseUrl.'/addpost'?>"><button class="b_F1592A bdr_F1592A"> Next </button></a>
	</div>
</div>

<script type="text/javascript">
    
    //call upload method for files uploading
    uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $this->config->item('imageSize');?>','<?php echo $browseId;?>',1,1,0,'<?php echo $imgload;?>','','_xs','1','<?php echo  $nextUrl; ?>');

    //fire trigger for file uploading
    $(document).ready(function() {
       
		$("#galleryForm").validate({
			submitHandler: function() {
                var fromData   = $("#galleryForm").serialize();
                var fileInput  = $('#fileInput1').val();
				var mediaTitle = $('#mediaTitle').val();
				var mediaId    = $('#mediaId').val();
				
                
                if ( (fileInput != '' || mediaId > 0) && mediaTitle != '') {
                    return true;
                } else {
                    alert('Please select image first!');
                    return false;
                }
            }
        });
       
        $('.uploadFileAction').click(function() {
            var fileInput      = $("#fileInput<?php echo $browseId?>").val();
            var fileErrorInput = $("#fileErrorInput<?php echo $browseId?>").val();
			var mediaTitle     = $('#mediaTitle').val();
			var mediaId    = $('#mediaId').val();
			
            if( (fileInput != '' || mediaId > 0) && fileErrorInput=='0' && mediaTitle != '' ) {
				var fromData = $("#galleryForm").serialize();
				var url = '<?php echo $baseUrl;?>'+'/uploadbloggalleryimage';
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


	function EditMediaImage(mediaTitle,mediaId,fileName) {
		
		$('#mediaUploadImage').hide();	
		$('#cancleFormBtn').show();	
		$('#uploadedImgName').html(fileName);
		$('#mediaId').val(mediaId);
		$('#mediaTitle').val(mediaTitle);	
	}
	
	function cancleFormVal() {
		$('#mediaUploadImage').show();	
		$('#cancleFormBtn').hide();	
		$('#uploadedImgName').html('');
		$('#mediaId').val(0);
		$('#mediaTitle').val('');
	}
	
	function deleteMedia(mediaId) {
			confirmBox("Do you really want to delete this gallery image?", function () {
				 var fromData='mediaId='+mediaId;
				 var mediaCount = '<?php echo $galleryMediaCount?>';
				 $.post(baseUrl+language+'/blog/deletegallerymedia',fromData, function(data) {
					if(data.deleted){
						if(mediaCount > 1) {
							$("#media_"+mediaId).fadeOut("normal", function() {
								$(this).remove();
							});	
						} else {
							$("#galleryMediaListDiv").fadeOut("normal", function() {
								$(this).remove();
							});	
						}
					}
				},'json');
			});
		}
</script>
