<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'uploadImageForm',
    'id'=>'uploadImageForm',
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
	'class'	=> 'fl width472 p10 mt0 bdr_adadad pb8',
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

$mediaTitleValue = set_value('mediaTitle')?set_value('mediaTitle'):'';
$mediaTitleValue = htmlentities($mediaTitleValue);

$mediaTitleInput = array(
    'name'        =>  'mediaTitle',
    'id'          =>  'mediaTitle',
    'class'       =>  'required width_615 min-height_25 mt14 bdr_adadad',
    'value'       =>  html_entity_decode($mediaTitleValue),
    'wordlength'  =>  "1,15",
    'onkeyup'     =>  "checkWordLen(this,15,'mediaTitleBox')",
    'placeholder' =>  "Image Title",
    'onBlur'      =>  "placeHoderHideShow(this,'Image Title','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Image Title','hide')"
);

$mediaDescriptionValue = set_value('mediaDescription')?set_value('mediaDescription'):'';
$mediaDescriptionValue = htmlentities($mediaDescriptionValue);

$mediaDescriptionInput = array(
    'name'        =>  'mediaDescription',
    'id'          =>  'mediaDescription',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt16 height51',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($mediaDescriptionValue),
    'wordlength'  =>  "3,50",
    'onkeyup'     =>  "checkWordLen(this,50,'mediaDescriptionBox')",
    'placeholder' =>  "Image Description",
    'onBlur'      =>  "placeHoderHideShow(this,'Image Description','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Image Description','hide')"
);

$mediaIdField = array(
	'name'	=> 'mediaId', 
	'value'	=>  0,
	'id'	=> 'mediaId',
	'type'	=> 'hidden'
);

$promotionalImgCountField = array(
	'name'	=> 'promotionalImgCount', 
	'value'	=>  $promotionalImgCount,
	'id'	=> 'promotionalImgCount',
	'type'	=> 'hidden'
);


$projectIdField = array(
	'name'	=> 'projId',
	'value'	=> (!empty($projId)) ? $projId : 0,
	'id'	=> 'projId',
	'type'	=> 'hidden'
);
   
// set base url
$baseUrl = base_url(lang().'/upcomingprojects/');
//next page url 
$nextUrl  =  base_url(lang().'/upcomingprojects/promotionalimages/'.$projId);
// set default image 
$defaultImage = $this->config->item('defaultImg');
?>

<div class="content display_table TabbedPanelsContent width635 m_auto">
	<div class="c_1 clearb">
		<?php  echo form_open($nextUrl,$formAttributes); ?>
			<div id="promotionalImageform" class="dn">
				<ul class="form_img mt25 mb25">
					<li>
						<h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('imageUpload')?> </h4>
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
								<li class="icon_2 pt0">Accepted File Types: gif, jpeg, jpg, png, tiff, tif, raw, bmp, ppm, pgm, pmb, pnm, tga.</li>
							</ul>
						</div>
						<div id="uploadedImgName"></div>
					</li>
					
					<li>
						<h4 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('imageTitle')?> </h4>
						 <span class="pl10 fs13 fshel_midum">1 - 15 words</span> 
						 <span class="red fr fs13 fshel_midum">
							 <span id="mediaTitleBox"><?php echo str_word_count($mediaTitleValue);?></span>  
							 <span>words</span> 
						 </span>
						<?php echo form_input($mediaTitleInput); ?>
					</li>
					
					<li>
						<h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('imageDescription')?> </h4>
						<span class="pl10 fs13 fshel_midum">3 - 50 words</span> 
						<span class="red fr pr10 fs13 fshel_midum">
							<span id="mediaDescriptionBox"><?php echo str_word_count($mediaDescriptionValue);?></span>  <span>words</span> 
						</span>
						<?php echo form_textarea($mediaDescriptionInput); ?>
					</li>
				</ul>	
				<button class=" fr red height40 uploadFileAction" onclick="$('#uploadImageForm').submit();" >Save</button>	
				<input type="button" class=" fr red height40 bdr_a0a0a0 fshel_bold mr10" id="cancleFormBtn" onclick="cancleFormVal();" value="Cancle">
			</div>	
			<div class="sap_25"></div>
			
			<?php if(!empty($promotionalImages)) { ?>
				<div class="alt_wrap" id="galleryMediaListDiv">
					<div class="mb10 pl30">
						<span class=" width100_per lineH21">
							<span class="red fl pl15 width_50 pr25 height20"></span>
							<span class="red fl pl15 width388 ">Image Title</span>
							<span class="red mr20 fr"></span> 
						</span>
					</div>
					<ul class="list_box img_list  clearb">
						<?php 
						foreach($promotionalImages as $promotionalImage) { ?>
							<li class="mb10 pl30" id="media_<?php echo $promotionalImage['mediaId'];?>">
								<span class="bg_f9f9f9 gray_img ">
									<span class="fl img_title  "> 
										<span class="table_cell width_50 height51">
											<?php 
											// get media image
											$extraSmallImg = addThumbFolder($promotionalImage['filePath'].$promotionalImage['fileName'],'_xxs');										
											$promoImg = getImage($extraSmallImg,$defaultImage);	
											?>
											<img src="<?php echo $promoImg;?>" alt="" />
										</span>
									</span>
									<span class="fl width388 ml90">
										<?php echo $promotionalImage['mediaTitle'];?>
									</span>
									<span class=" mr10 fr ">
										<span class="fl red mr5">
											<a onclick="EditMediaImage('<?php echo $promotionalImage['mediaTitle'];?>','<?php echo $promotionalImage['mediaId'];?>','<?php echo $promotionalImage['rawFileName'];?>','<?php echo $promotionalImage['mediaDescription'];?>')"> Edit</a> / 
											<a onclick="deleteMedia('<?php echo $promotionalImage['mediaId'];?>')">Delete </a>
										</span>
										<span class="down_arrow comm_arow"></span> 
										<span class="up_arrow comm_arow"></span>
									</span>
								</span>	
							</li>
						<?php } ?> 
					</ul>
				</div>
			<?php }
			// get promotional image count
			$promo_max_upload = $this->config->item('promo_max_upload');
			if($promotionalImgCount > 0)
				$resultantEmpty = $promotionalImgCount;
			else
				$resultantEmpty = 0;
					
			if($promotionalImgCount != $promo_max_upload) {
				$isdata=true;?>
				<ul class="list_box img_list  clearb">
					<?php
					while ($resultantEmpty < $promo_max_upload) {
						$resultantEmpty++;?>
					
							<li class="mb10 pl30" id="rowDataAdd<?php echo $resultantEmpty;?>">
								<span class="bg_f9f9f9 gray_img ">
									<span class="fl img_title  "> 
										<span class="table_cell width_50 height51">
											<!--<img src="<?php //echo getImage('',$defaultImage);?>">-->
										</span>
									</span>
									<span class=" fl  width388 ml90">
										<?php echo $this->lang->line('addImage');?>
									</span>
									<span class=" mr10 fr ">
										<span class="fl red mr40"><a onclick="toggelContent('<?php echo $promotionalImage['mediaId'];?>')">Add </a></span>
										<!--<span class="down_arrow comm_arow"></span> 
										<span class="up_arrow comm_arow"></span>-->
									</span>
								</span>
								<input type="hidden" id="addVideo" name="addVideo" value="Add<?php echo $resultantEmpty;?>" />
							</li>
						<?php
						} ?>
					</ul>		
				<?php
				}
				
			
		echo form_input($projectIdField); 
		echo form_input($mediaIdField);
		echo form_input($promotionalImgCountField);
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
    // set next form name
    $data['isNextstep'] = '1';
	$data['nextPage'] = '/upcomingprojects/introductorymedia/'.$projId;
    $this->load->view('wizardform/donation_buttons',$data);
    ?>
</div>
<script type="text/javascript">
      
    //call upload method for files uploading
    uploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $this->config->item('imageSize');?>','<?php echo $browseId;?>',1,1,0,'<?php echo $imgload;?>','','_xs','1','<?php echo  $nextUrl; ?>');

    //fire trigger for file uploading
    $(document).ready(function() {
       
		$("#uploadImageForm").validate({
			submitHandler: function() {
                var fromData   = $("#uploadImageForm").serialize();
                var fileInput  = $('#fileInput1').val();
				var mediaTitle = $('#mediaTitle').val();
				var mediaDescription = $('#mediaDescription').val();
				var mediaId    = $('#mediaId').val();
				
                
                if ( (fileInput != '' || mediaId > 0) && mediaTitle != '' && mediaDescription != '') {
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
			var mediaDescription     = $('#mediaDescription').val();
			var mediaId    = $('#mediaId').val();
			
            if( (fileInput != '' || mediaId > 0) && fileErrorInput=='0' && mediaTitle != '' && mediaDescription != '' ) {
				var fromData = $("#uploadImageForm").serialize();
				var url = '<?php echo $baseUrl;?>'+'/setpromotionalimagedata';
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
    
	function EditMediaImage(mediaTitle,mediaId,fileName,mediaDescription) {
		
		$('#promotionalImageform').fadeIn("slow");
		$('#mediaUploadImage').hide();	
		$('#cancleFormBtn').show();	
		$('#uploadedImgName').html(fileName);
		$('#mediaId').val(mediaId);
		$('#mediaTitle').val(mediaTitle);	
		$('#mediaDescription').val(mediaDescription);	
		
	}
	
	function cancleFormVal() {
		$('#promotionalImageform').fadeOut("slow");
		$('#mediaUploadImage').show();	
		$('#cancleFormBtn').hide();	
		$('#uploadedImgName').html('');
		$('#mediaId').val(0);
		$('#mediaTitle').val('');
		$('#mediaDescription').val('');	
	}
    
	function deleteMedia(mediaId) {
		confirmBox("Do you really want to delete this image?", function () {
			 var fromData='mediaId='+mediaId;
			 var mediaCount = '<?php echo $promotionalImgCount?>';
			 $.post(baseUrl+language+'/upcomingprojects/deletepromotionalmedia',fromData, function(data) {
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
	
	function toggelContent(mediaId) {
		cancleFormVal();
		$('#cancleFormBtn').show();	
		$('#promotionalImageform').fadeIn("slow");	
	}

</script>
