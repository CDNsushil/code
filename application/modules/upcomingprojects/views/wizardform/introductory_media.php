<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'uploadMediaForm',
    'id'=>'uploadMediaForm',
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
    'onBlur'      =>  "placeHoderHideShow(this,'Media Title','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Media Title','hide')"
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
    'onBlur'      =>  "placeHoderHideShow(this,'Media Description','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Media Description','hide')"
);

$mediaIdField = array(
	'name'	=> 'mediaId', 
	'value'	=>  0,
	'id'	=> 'mediaId',
	'type'	=> 'hidden'
);

$introductoryMediaCountField = array(
	'name'	=> 'introductoryMediaCount', 
	'value'	=>  $introductoryMediaCount,
	'id'	=> 'introductoryMediaCount',
	'type'	=> 'hidden'
);
$imagebrowseId = 1;
$imagebrowseIdField = array(
	'name'	=> 'imagebrowseId',
	'value'	=> $imagebrowseId,
	'id'	=> 'imagebrowseId',
	'type'	=> 'hidden'
);

$selectedMediabrowseIdField = array(
	'name'	=> 'selectedMediabrowseId',
	'value'	=> 2,
	'id'	=> 'selectedMediabrowseId',
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
$nextUrl  =  base_url(lang().'/upcomingprojects/introductorymedia/'.$projId);
// set default image 
$defaultImage = $this->config->item('defaultImg');
?>

<div class="content display_table TabbedPanelsContent width635 m_auto">
	<div class="c_1 clearb">
		<?php  echo form_open($nextUrl,$formAttributes); ?>
			<div id="promotionalImageform" class="dn">
				<ul class="form_img mt25 mb25">
					
					<li>
						<div id="mediaUploadImage"> 
							<h4 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('whatTypeOfMediaAdd');?> </h4>
							<div class="ml0 mt28 fs16 lineH18 mb30"> 
								<span class="defaultP table_cell fs14 pr50">	
									<label>
										<input type="radio" value="2" name="uploadMediaType" id="uploadMediaTypeVideo" checked  >
										<?php echo $this->lang->line('video');?> 
									</label>
								</span> 
								<span class="defaultP table_cell fs14 pr50">	
									<label>
										<input type="radio" value="3" name="uploadMediaType" id="uploadMediaTypeAudio" >
										<?php echo $this->lang->line('audio');?> 
									</label>
								</span> 
								<span class="defaultP table_cell fs14 pr50">	
									<label>
										<input type="radio" value="4" name="uploadMediaType" id="uploadMediaTypeText" >
										<?php echo $this->lang->line('text');?> 
									</label>
								</span> 
							</div>		
						
							<h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('mediaUpload')?> </h4>
							<div id="videoFormLi"> 
								<?php 
								$videoFileData = array(
												'browseId'=>2,
												'fileType'=>'video',
												'nextUrl'=>$nextUrl);	
								$this->load->view('wizardform/upload_file',$videoFileData);?>
							</div>
							
							<div id="audioFormLi" class="dn"> 
								<?php 
								$audioFileData = array(
												'browseId'=>3,
												'fileType'=>'audio',
												'nextUrl'=>$nextUrl);	
								$this->load->view('wizardform/upload_file',$audioFileData);?>
							</div>
							
							<div id="textFormLi" class="dn"> 
								<?php 
								$textFileData = array(
												'browseId'=>4,
												'fileType'=>'writtenMaterial',
												'nextUrl'=>$nextUrl);	
								$this->load->view('wizardform/upload_file',$textFileData);?>
							</div>
						</div>
						<!-- Show media file name on edit -->
						<div id="editMediaBox" class="dn">
							<h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('mediaUpload')?> </h4>
							<div id="uploadedImgName"></div>	
						</div>
					</li>
					
					<li>
						<h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('imageUpload')?> </h4>
						<?php 
						$imageFileData = array(
											'browseId'=>$imagebrowseId,
											'fileType'=>'image',
											'nextUrl'=>$nextUrl);	
						$this->load->view('wizardform/upload_file',$imageFileData);?>
					</li>
					
					<li>
						<h4 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('mediaTitle');?> </h4>
						 <span class="pl10 fs13 fshel_midum">1 - 15 words</span> 
						 <span class="red fr fs13 fshel_midum">
							 <span id="mediaTitleBox"><?php echo str_word_count($mediaTitleValue);?></span>  
							 <span>words</span> 
						 </span>
						<?php echo form_input($mediaTitleInput); ?>
					</li>
					
					<li>
						<h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('mediaDescription')?> </h4>
						<span class="pl10 fs13 fshel_midum">3 - 50 words</span> 
						<span class="red fr pr10 fs13 fshel_midum">
							<span id="mediaDescriptionBox"><?php echo str_word_count($mediaDescriptionValue);?></span>  <span>words</span> 
						</span>
						<?php echo form_textarea($mediaDescriptionInput); ?>
					</li>
				</ul>	
				<button class=" fr red height40 uploadFileAction" onclick="$('#uploadImageForm').submit();" >Save</button>	
				<input type="button" class=" fr red height40 bdr_a0a0a0 mr10" id="cancleFormBtn" onclick="cancleFormVal();" value="Cancle">
			</div>	
			<div class="sap_25"></div>
			<?php if(!empty($introductoryMedia)) { ?>
				<div class="alt_wrap" id="galleryMediaListDiv">
					<div class="mb10 pl30">
						<span class=" width100_per lineH21">
							<span class="red fl pl15 width_50 pr25 height20"></span>
							<span class="red fl pl15 width388 ">Media Title</span>
							<span class="red mr20 fr"></span> 
						</span>
					</div>
					<ul class="list_box img_list  clearb">
						<?php 
						foreach($introductoryMedia as $introductoryMedia) { ?>
							<li class="mb10 pl30" id="media_<?php echo $introductoryMedia['mediaId'];?>">
								<span class="bg_f9f9f9 gray_img ">
									<span class="fl img_title  "> 
										<span class="table_cell width_50 height51">
											<?php 
											// get image data of media
											$thumbImageData = getMediaDetail($introductoryMedia['thumbFileId']);
										
											$thumbImgPath = (!empty($thumbImageData)) ? $thumbImageData[0]->filePath : '';
											$thumbImgName = (!empty($thumbImageData)) ? $thumbImageData[0]->fileName : '';
																		
											// get media image
											$extraSmallImg = addThumbFolder($thumbImgPath.$thumbImgName,'_xxs');										
											$promoImg = getImage($extraSmallImg,$defaultImage);	
											?>
											<img src="<?php echo $promoImg;?>" alt="" />
										</span>
									</span>
									<span class="fl width388 ml90">
										<?php echo $introductoryMedia['mediaTitle'];?>
									</span>
									<span class=" mr10 fr ">
										<span class="fl red mr5">
											<a onclick="EditMediaImage('<?php echo $introductoryMedia['mediaTitle'];?>','<?php echo $introductoryMedia['mediaId'];?>','<?php echo $introductoryMedia['rawFileName'];?>','<?php echo $introductoryMedia['mediaDescription'];?>')"> Edit</a> / 
											<a onclick="deleteMedia('<?php echo $introductoryMedia['mediaId'];?>')">Delete </a>
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
			$promo_max_upload = $this->config->item('maxSupportedMedia');
			if($introductoryMediaCount > 0)
				$resultantEmpty = $introductoryMediaCount;
			else
				$resultantEmpty = 0;
					
			if($introductoryMediaCount != $promo_max_upload) {
				$isdata=true;
				?>
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
									<?php echo $this->lang->line('add').'&nbsp;'.$this->lang->line('introductoryMedia');?>
								</span>
								<span class=" mr10 fr ">
									<span class="fl red mr40"><a onclick="toggelContent('<?php echo $resultantEmpty;?>')">Add </a> </span></span>
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
		echo form_input($imagebrowseIdField);
		echo form_input($selectedMediabrowseIdField);
		echo form_input($mediaIdField);
		echo form_input($introductoryMediaCountField);
		 
		echo form_close(); ?>
	</div>
    <!-- Form buttons -->
    <?php 
    // set next form name
    $data['isNextstep'] = '1';
	$data['nextPage'] = '/upcomingprojects/previewpublish/'.$projId;
    $this->load->view('wizardform/donation_buttons',$data);
    ?>
</div>
<script type="text/javascript">
      
    //fire trigger for file uploading
    $(document).ready(function() {
       
		$("#uploadMediaForm").validate({
			submitHandler: function() {
                var fromData   = $("#uploadMediaForm").serialize();
                var imagebrowseId = $('#imagebrowseId').val();
                var selectedMediabrowseId = $('#selectedMediabrowseId').val();
                var imageFileInput  = $('#fileInput'+imagebrowseId).val();
				var mediaFileInput  = $('#fileInput'+selectedMediabrowseId).val();
				var mediaTitle = $('#mediaTitle').val();
				var mediaDescription = $('#mediaDescription').val();
				var mediaId    = $('#mediaId').val();
				
                
                if ( (mediaFileInput != '' || mediaId > 0) && imageFileInput != '' && mediaTitle != '' && mediaDescription != '') {
                    return true;
                } else {
                    alert('Please select image first!');
                    return false;
                }
            }
        });
       
        $('.uploadFileAction').click(function() {
			
			var ImagebrowseId         = $('#imagebrowseId').val();
			var selectedMediabrowseId = $('#selectedMediabrowseId').val();
			var imageFileInput        = $('#fileInput'+ImagebrowseId).val();
			var mediaFileInput        = $('#fileInput'+selectedMediabrowseId).val();
            var ImagefileErrorInput   = $("#fileErrorInput"+ImagebrowseId).val();
            var mediaFileErrorInput   = $("#fileErrorInput"+selectedMediabrowseId).val();
			var mediaTitle            = $('#mediaTitle').val();
			var mediaDescription      = $('#mediaDescription').val();
			var mediaId               = $('#mediaId').val();
			
            if( (mediaFileInput != '' || mediaId > 0) && imageFileInput != '' && mediaFileErrorInput =='0' && mediaTitle != '' && mediaDescription != '' ) {
				var fromData = $("#uploadMediaForm").serialize();
				var url = '<?php echo $baseUrl;?>'+'/setintroductorymediadata';
				$.post(url,fromData, function(data) {
					if(data){
						
						$("#uploadFileByJquery"+ImagebrowseId).click();
						$("#uploadFileByJquery"+selectedMediabrowseId).click();
					
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
		$('#editMediaBox').show();
		$('#uploadedImgName').html(fileName);
		$('#mediaId').val(mediaId);
		$('#mediaTitle').val(mediaTitle);	
		$('#mediaDescription').val(mediaDescription);	
		
	}
	
	function cancleFormVal() {
		$('#promotionalImageform').fadeOut("slow");
		$('#mediaUploadImage').show();	
		$('#cancleFormBtn').hide();	
		$('#editMediaBox').hide();
		$('#uploadedImgName').html('');
		$('#mediaId').val(0);
		$('#mediaTitle').val('');
		$('#mediaDescription').val('');	
	}
    
	function deleteMedia(mediaId) {
		confirmBox("Do you really want to delete this image?", function () {
			 var fromData='mediaId='+mediaId;
			 var mediaCount = '<?php echo $introductoryMediaCount?>';
			 $.post(baseUrl+language+'/upcomingprojects/deletepromotionalmedia',fromData, function(data) {
				if(data.deleted){
					refreshPge();
					/*if(mediaCount > 1) {
						$("#media_"+mediaId).fadeOut("normal", function() {
							$(this).remove();
						});	
					} else {
						$("#galleryMediaListDiv").fadeOut("normal", function() {
							$(this).remove();
						});	
					}*/
				}
			},'json');
		});
	}
	
	function toggelContent(mediaId) {
		cancleFormVal();
		$('#cancleFormBtn').show();	
		$('#promotionalImageform').fadeIn("slow");	
	}
	
	$("input[name=uploadMediaType]:radio").change(function () {
		
		if ($("#uploadMediaTypeAudio").attr("checked")) {
			$('#videoFormLi').hide();	
			$('#audioFormLi').show();	
			$('#textFormLi').hide();	
			$('#selectedMediabrowseId').val(3);
		} else if ($("#uploadMediaTypeText").attr("checked")) {
			$('#videoFormLi').hide();	
			$('#audioFormLi').hide();
			$('#textFormLi').show();	
			$('#selectedMediabrowseId').val(4);	
		} else {
			$('#videoFormLi').show();	
			$('#audioFormLi').hide();
			$('#textFormLi').hide();
			$('#selectedMediabrowseId').val(2);
		}
	});

</script>
