<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
$browseId = 'video';
$browseImgMain='videoImage';
$deleteCache='upcoming_'.$projId.'_'.$userId;
?>
<div class="row">
	<div class="cell frm_heading">
		<h1><?php echo $label['promotionalMaterial']?></h1>
	</div>
	<?php echo $header;?>
</div>
<!-- Accordin Started -->
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('introductoryMedia'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Post add Icon -->
								
				<a  class="formTip" >					
					<span><div class="projectToggleIcon" id="workpromoToggleIcon" toggleDivId="PromoVideo-Content-Box" ></div></span>
				</a>
			</div>
		</div>
	</div>
</div><!--row-->	
<div class="clear"></div>
<!-- Accordin Ended -->
	
	<div id="PromoVideo-Content-Box" class="frm_strip_bg">		
		<div class="row"><div class="tab_shadow"></div></div>
		<div id = "upProVideoForm-Content-Box" class="dn width800px">
		
			<?php 
			
			$attr = array('name'=>'WPsupportedMedia','id'=>'WPsupportedMedia');

			$supportedMediaTitle = array(
				'name'	=> 'mediaTitle',
				'id'	=> 'videoMediaTitle',
				'value'	=> '',
				'size'	=> 30,
				'class' => 'width548px required'
			);
			
			
			$browseId1stInput = array(
				'name'	=> 'browseId1st',
				'value'	=> $browseId,
				'id'	=> 'browseId1st',
				'type'	=> 'hidden'
			);	
			
			$browseId2ndInput = array(
				'name'	=> 'browseId2nd',
				'value'	=> $browseImgMain,
				'id'	=> 'browseId2nd',
				'type'	=> 'hidden'
			);		
			echo form_open_multipart($this->uri->uri_string(),$attr);  
			?>
			<div id="upload2ndFileDiv">
				<?php
					echo form_input($browseId1stInput);
					echo form_input($browseId2ndInput);
				?>
			</div>
		<div class="upload_media_left_top row"></div>	
		<div class="upload_media_left_box">
			<input type="hidden" value="0" id="videoMediaId" name="mediaId" />
			<input type="hidden" value="<?php echo $projId;?>" id="projId" name="projId" />
			<input type="hidden" value="0" id="videofileId" />
			<input type="hidden" value="0" id="thumbFileId" />
		
			<div class="row">
				<div class="label_wrapper cell">
					<label class="select_field"><?php echo $this->lang->line('title'); ?></label>
				</div><!--label_wrapper-->
				<div class="cell frm_element_wrapper">
					<?php echo form_input($supportedMediaTitle); ?>
				</div>
			</div><!-- row -->
			
			<div class="row dn" id="rawFileNameContainerDiv<?php echo $browseId;?>">
				<div class="label_wrapper cell">
				  <label class="select_field"><?php echo $this->lang->line('file');?></label>
				</div>
				<!--label_wrapper-->
				<div class=" cell frm_element_wrapper mt5" id="rawFileNameDiv<?php echo $browseId;?>">
				</div>
			 </div>
			
			<?php 
				$data=array('typeOfFile'=>2,'mediaFileTypes'=>$this->config->item('videoType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$filePath,'embedCode'=>'', 'required'=>'required', 'label'=>$this->lang->line('file'),'editFlag'=>'','fileTypeFlag'=>1,'flag'=>0,'browseId'=>$browseId,'browseId2'=>$browseImgMain,'imgload'=>0,'norefresh'=>0,'isUploadEmbedOption'=>false, 'view'=>'upload_ws_frm');
				
				echo Modules::run("common/formInputField",$data);
			
				echo '<div class="row seprator_25"></div>';
				
				$data=array('typeOfFile'=>1,'mediaFileTypes'=>$this->config->item('imageType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$filePath.'images/','embedCode'=>'', 'required'=>'required', 'label'=>$this->lang->line('image'),'editFlag'=>'','fileTypeFlag'=>0,'flag'=>1,'browseId'=>$browseImgMain,'imgload'=>1,'norefresh'=>0,'isUploadEmbedOption'=>false, 'view'=>'upload_ws_frm');
				echo Modules::run("common/formInputField",$data);
				
				echo '<div class="row seprator_10"></div>';
				$wordOption=array('minVal'=>0,'maxVal'=>50);
				$data = array('name'=>'mediaDescription','value'=>'', 'view'=>'description','wordOption'=>$wordOption,'id'=>'videoMediaDescription');				
				echo Modules::run("common/formInputField",$data);
			?>
			
			<div class="row">
				<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class=" cell frm_element_wrapper">
					<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
					<div class="frm_btn_wrapper padding-right0">						
						<?php
						
							$button=array('ajaxSave','cancelVtoggle');
							echo Modules::run("common/loadButtons",$button); 
							
						?>							
					</div>
					<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('upcomingPromoMatReqFieldMsg');?></div></div>
				</div>
			</div><!--from_element_wrapper-->		
		
		
		</div><!-- row -->
		<div class="upload_media_left_bottom row"></div>
		<?php echo form_close(); ?>
		
		
	</div><!-- upload_media_left_box -->		
		<div class="row">
			
			<div id="ProjectPromo-Content" >
			<?php			
						if(!empty($projectPromotionVideo))
						{
								foreach($projectPromotionVideo as $upcomingProductPromotionMedia)
								{							
									//echo '<pre />';print_r($upcomingProductPromotionMedia);
									$imageStatus = $upcomingProductPromotionMedia['isMain'];
									$mediaId = $upcomingProductPromotionMedia['mediaId'];
									$imagePath = $upcomingProductPromotionMedia['filePath'];
									$imageName = $upcomingProductPromotionMedia['fileName'];
									$mediaTitle = $upcomingProductPromotionMedia['mediaTitle'];
									$mediaDescription = $upcomingProductPromotionMedia['mediaDescription'];
									$projId = $upcomingProductPromotionMedia['projId'];
									$fileId = $upcomingProductPromotionMedia['fileId'];
									$thumbFileId = $upcomingProductPromotionMedia['thumbFileId'];
									$isExternal = $upcomingProductPromotionMedia['isExternal'];
									$rawFileName = $upcomingProductPromotionMedia['rawFileName'];
									$embedCode=$isExternal=='t'?str_replace(array('&lt;','&gt;'),array('<','>'),$imagePath):'';

									$mediaType = $upcomingProductPromotionMedia['mediaType'];
									$fileType = $upcomingProductPromotionMedia['fileType'];
									 
									 $mediaDetail = getMediaDetail(@$thumbFileId);
									
									if(is_array($mediaDetail) && !empty($mediaDetail))
									{
										$thumbImgPath = $mediaDetail[0]->filePath;
										$thumbImgName = $mediaDetail[0]->fileName;
									}else
									{
										$thumbImgPath = '';
										$thumbImgName = '';
									}							
									
									$thumbSrc = $thumbImgPath.'/'.$thumbImgName;
									$smallImg = addThumbFolder(@$thumbSrc,'_xxs');
									$formthumbFinalImg = getImage($smallImg,$this->config->item('defaultImg'));
									
									if($mediaType==2) {
										$thumbFinalImg = getImage($smallImg,$this->config->item('defaultVideoImg'));
										$previewUrl = '/upcomingprojects/previewVideo/'.$mediaId;
										$mediaTypeValue = 'Video';
										$mediaClass = ' film_icon ';
									}
									else if($mediaType==3) {
										$thumbFinalImg = getImage($smallImg,$this->config->item('defaultAudioImg'));
										$previewUrl = '/upcomingprojects/previewAudio/'.$mediaId;
										$mediaTypeValue = 'Audio';
										$mediaClass = ' audio_icon ';
									}
									else{
										$thumbFinalImg = getImage($smallImg,$this->config->item('defaultDocImg'));
										$previewUrl = '/upcomingprojects/previewVideo/'.$mediaId;
										$mediaTypeValue = 'Text';
										$mediaClass = ' writing_icon ';
									}
									 
									$uploadName = @$upcomingProductPromotionMedia['rawFileName'];
									
									if($isExternal=='t')
									{
										$file=urlencode($imagePath);
										if(!isset($uploadName) || $uploadName=='')
											$uploadName = urlencode($imagePath);
										$fileType='external';
									}
									else
									{
										$file=$imagePath.$imageName;
										if(!isset($uploadName) || $uploadName=='')
											$uploadName=$imageName;
										$fileType=$fileType;								
									}							
									
									$Data = array(
									'mediaId'=>$mediaId,
									'mediaTitle'=>$mediaTitle,
									'mediaDescription'=>$mediaDescription,
									'isExternal'=>$isExternal,
									'videofileId'=>$fileId,
									'thumbFileId'=>$thumbFileId,
									'mediaType'=>$mediaType,
									'fileType'=>$upcomingProductPromotionMedia['fileType'],
									'filePath'=>$file,
									'rawFileName'=>$rawFileName,
									'embbededURL'=>$embedCode,
									'uploadName'=>$uploadName,
									'mediaTypeValue'=>$mediaTypeValue,
									'thumbSrc'=>$formthumbFinalImg,
									'browseId'=>$browseId,
									'browseImgMain'=>$browseImgMain,
									
									
									
									);
									
									$jsonData=json_encode($Data);
									
									$jsonfileId=json_encode(array($fileId,$thumbFileId));
									
									$convsrsionFlag=false;
									$convsrsionFileType=$this->config->item('convsrsionFileType');
									if($upcomingProductPromotionMedia['isExternal']=='f' && in_array($upcomingProductPromotionMedia['fileType'],$convsrsionFileType)){
										$convsrsionFlag=true;
										if($upcomingProductPromotionMedia['jobStsatus'] == 'DONE'){
											$conversionStatusClass='icon_filesent';
											$conversionStatusToolTip=$this->lang->line('Converted');
										}elseif($upcomingProductPromotionMedia['jobStsatus'] == 'FAILS'){
											$isconverted=false;
											$conversionStatusClass='icon_filetransfer';
											$conversionStatusToolTip=$this->lang->line('conversionFailed');
										}else{
											$isconverted=false;
											$conversionStatusClass='icon_inprocess';
											$conversionStatusToolTip=$this->lang->line('converting');
										}
									}				
								?>
								<script>
									var data<?php echo $mediaId;?>=<?php echo $jsonData;?>;
									var fileIds<?php echo $mediaId;?>=<?php echo $jsonfileId;?>;
								</script>
								<?php //echo '<pre />';print_r($Data);?>
								<div class="label_wrapper cell bg-non"></div>
								 
									<div  id="rowData<?php echo $mediaId;?>" class=" cell frm_element_wrapper extract_content_bg" >			  
									
									<div class="extract_img_wp"> 
									<?php 
										$entityId= getMasterTableRecord('UpcomingProject');			
										if($mediaType==2)							
											echo '<img class="formTip ptr maxWH30 ma" src="'.$thumbFinalImg.'" title="'.$mediaTitle.'" onclick="openPlayerLightBox(\'popupBoxWp\',\'popup_box\',\'/common/playCommonVideo\',\''.$fileId.'\',\''.$entityId.'\',\''.$projId.'\',\''.$projId.'\');" />';							
										else if($mediaType==3)		
										///	echo '<img onclick="openUserLightBox(\'videoLightBoxWp\',\'productFormContainer\',\''.$previewUrl.'\',\''.encode($mediaId).'\');" src="'.$thumbFinalImg.'" class="formTip ptr maxWH30 ma" title="'.$imageName.'">';
												echo '<img class="formTip ptr maxWH30 ma" src="'.$thumbFinalImg.'" title="'.$imageName.'" onclick="openPlayerLightBox(\'popupBoxWp\',\'popup_box\',\'/common/playCommonAudio\',\''.$fileId.'\',\''.$entityId.'\',\''.$projId.'\',\''.$projId.'\');" />';	
										else 
											//echo '<a href="javascript://void(0);"><img src="'.$thumbFinalImg.'" class="formTip ptr maxWH30 ma" /></a>';
											echo '<img class="formTip ptr maxWH30 ma" src="'.$thumbFinalImg.'" title="'.$imageName.'" onclick="openPlayerLightBox(\'popupBoxWp\',\'popup_box\',\'/common/playCommonSwf\',\''.$fileId.'\',\''.$entityId.'\',\''.$projId.'\',\''.$projId.'\');" />';	
										//else echo '<a href='.base_url().$imagePath.$imageName.'><img src="'.getImage($this->config->item('defaultDocImg'),$this->config->item('defaultVideoImg')).'" class="formTip ptr maxWH30 ma" /></a>';
																	
									?>
									</div>
									
									<div class="extract_heading_box"><?php echo $mediaTitle;?></div>					
									
									<div class="extract_button_box" >
										<?php
											if($convsrsionFlag){ ?>
												<div class="fl mr30 formTip <?php echo $conversionStatusClass;?>" title="<?php echo $conversionStatusToolTip;?>"> </div>											
												<?
											}
										?>
										<?php if($imageStatus != 't'){ ?>
												<div class="small_btn dn"><a style="cursor:pointer" onclick="makeFeatured('<?php echo $mediaId;?>','<?php echo $projId?>','image');"></div>
												</a>
										<?php } ?>
										
															
									
									<div class="small_btn"><a onclick="deleteTabelRow('UpcomingProjectMedia','mediaId','<?php echo $mediaId;?>','','','',fileIds<?php echo $mediaId;?>,'',1,'<?php echo $deleteCache;?>',1);" href="javascript:void(0)" class="formTip" title="<?php echo $this->lang->line('delete');?>">
									<div class="cat_smll_plus_icon"></div></a></div>
									<div class="small_btn"><a onclick ="editMediaFile(data<?php echo $mediaId;?>);" href="javascript:void(0)" class="formTip" title="<?php echo $this->lang->line('edit');?>"><div class="cat_smll_edit_icon"></div></a></div>
									</div>
									</div>
									<div class="clear"></div>
								
								
							<?php 						
							} 			
					} 	
							
					$maxSupportedMedia = $this->config->item('maxSupportedMedia');
					
					if($totalMediaFile>0)
						$resultantSupportedMediaEmpty = $maxSupportedMedia -  $totalMediaFile;
					else
						$resultantSupportedMediaEmpty = $maxSupportedMedia;				
					
					$totalRem = 0;
					
					if($totalMediaFile != $maxSupportedMedia)
					{
						for ($totalRem = 0; $totalRem <= $resultantSupportedMediaEmpty-1; $totalRem++) 
						{

					?>
					<div class="label_wrapper cell bg-non"></div>
					<div class="cell extract_content_bg width_569  mt7 frm_element_wrapper" id="rowDataAdd<?php echo $totalRem;?>">
						<div class="extract_img_wp opacity_4"> 
							<div class="formTip ptr maxWH30 ma multimedia_icon" title=""></div>
						</div>
						<!-- extract_img_wp -->
						<div class="extract_heading_box opacity_4">
							<?php echo $this->lang->line('add').'&nbsp;'.$this->lang->line('introductoryMedia');?></div>
						<!-- extract_heading_box -->
						<div class="extract_button_box">
						  <div class="small_btn"><a onclick="cancelVtoggle(1)" href="javascript:void(0)" class="formTip" title="<?php echo $this->lang->line('add');?>"><div class="cat_smll_add_icon"></div></a></div>
						</div>
					</div>
					<input type="hidden" id="addVideo" name="addVideo" value="Add<?php echo $totalRem;?>" />					
				
					<?	
						}			
					}
					?>
		</div>
			<div class="seprator_27 row"></div>
		</div>
</div>
<div class="videoLightBoxWp" id="videoLightBoxWp" style="display:none;">
	<div id="close-upcomingProjectBox" class="tip-tr close-customAlert" title=""></div>
	<div class="productFormContainer" id="productFormContainer"></div>
</div>
<?php
 
	$rawFileImg = "fileInput".@$browseImgMain;
	$rawFileVideo = "fileInput".@$browseId;
	
?>
<script  type="text/javascript">
var ImageThumbImgPath = '<?php  echo $videoPath; ?>images/';	
function editMediaFile(objMedia)
{
	var browseId = objMedia.browseId;
	var browseImgMain = objMedia.browseImgMain;
	var rawFileName = objMedia.rawFileName;
	var isExternal  = objMedia.isExternal;
	var embbededURL  = objMedia.embbededURL;
	
	var mediaId = objMedia.mediaId;
	var mediaType = objMedia.mediaType;
	var fileType = objMedia.fileType;
	var mediaTitle = objMedia.mediaTitle;
	var videofileId = objMedia.videofileId;
	var filePath = objMedia.filePath;
	var thumbFileId = objMedia.thumbFileId;
	var thumbSrc = objMedia.thumbSrc;
	var mediaDescription = objMedia.mediaDescription;
	var uploadName = objMedia.uploadName;
	var mediaTypeValue = objMedia.mediaTypeValue;
	
	embbededURL  = embbededURL.replace(/\&lt;/g, "<");
	embbededURL  = embbededURL.replace(/\&gt;/g, ">");
	if(rawFileName != '' && rawFileName != null && (rawFileName.length > 4) && (isExternal != 't')){
		if($('#uploadFileSection'+browseId))
			$('#uploadFileSection'+browseId).hide()
		if($('#rawFileNameContainerDiv'+browseId))
			$('#rawFileNameContainerDiv'+browseId).show()
		if($('#rawFileNameDiv'+browseId))
			$('#rawFileNameDiv'+browseId).html(rawFileName);
	}else{
		if($('#rawFileNameContainerDiv'+browseId))
			$('#rawFileNameContainerDiv'+browseId).hide()
		if($('#uploadFileSection'+browseId))
			$('#uploadFileSection'+browseId).show()
		if($('#rawFileNameDiv'+browseId))
			$('#rawFileNameDiv'+browseId).html('');
	}
	if(isExternal=='f'){
		$('#isExternal'+browseId).val('f');
		if('#uploadFileSection'+browseId)
		$('#uploadFileSection'+browseId).hide();
	}else{
		$('#isExternal'+browseId).val('t');
		if('#uploafFileButton'+browseId)
			$('#uploafFileButton'+browseId).hide();
		if('#Uploadvideo'+browseId)
			$('#Uploadvideo'+browseId).hide();
		
		if('#embedButton'+browseId)
			$('#embedButton'+browseId).show();
		if('#EmbeddedURL'+browseId)
			$('#EmbeddedURL'+browseId).show();
	}
	if($('#embbededURL'+browseId))
	$('#embbededURL'+browseId).val(embbededURL);
	
	$('#'+browseImgMain+'promoImage').attr('src',thumbSrc);
		
	$('#videoMediaId').val(mediaId);
	$('#fileType'+browseId).val(fileType);	
	$('#videoMediaTitle').val(mediaTitle);	
	$('#videoMediaDescription').val(mediaDescription);	
	$('#videofileId').val(videofileId);	
	$('#thumbFileId').val(thumbFileId);
	$('#isExternal'+browseId).val(isExternal);	
	$('#filePath'+browseId).val(filePath);
	
		
	$('#fileInput'+browseId).removeClass('required');
	$('#fileInput'+browseImgMain).removeClass('required');
	$('#fileInput'+browseId).val('');
	$('#fileInput'+browseImgMain).val('');
	$('#fileName'+browseId).val('');
	$('#fileName'+browseImgMain).val('');
	
	
	$('#upProVideoForm-Content-Box').slideDown("slow");	
}


	
function cancelVtoggle(showFlag)
{
	var browseId = '<?php echo $browseId;?>';
	var browseImgMain = '<?php echo $browseImgMain;?>';
	
	$('label.error').remove();
			
	$('input.error').each(function(index){
			var inputClass =$(this).attr('class').replace('error', '');
			$(this).attr('class',inputClass);
	});
	$('textarea.error').each(function(index){
			var inputClass =$(this).attr('class').replace('error', '');
			$(this).attr('class',inputClass);
	});
	
	$('#fileError'+browseId).html('');
	$('#fileError'+browseImgMain).html('');
	
	if($('#rawFileNameContainerDiv'+browseId))
		$('#rawFileNameContainerDiv'+browseId).hide()
	if($('#uploadFileSection'+browseId))
		$('#uploadFileSection'+browseId).show()
	if($('#rawFileNameDiv'+browseId))
		$('#rawFileNameDiv'+browseId).html('');
			
	$('#videoMediaId').val(0);	
	$('#videofileId').val(0);
	$('#thumbFileId').val(0);
	$('#videoMediaTitle').val('');
	$('#videoMediaDescription').val('');
	$('#fileType'+browseId).val('2');
	$('#isExternal'+browseId).val('f');
	$('#embbededURL'+browseId).val('');
	$('#fileTypeRuntime'+browseId).val('<?php echo $this->config->item('videoType'); ?>');
	$('#fileTypeRuntime'+browseImgMain).val('<?php echo $this->config->item('imageType'); ?>');
	$('#allowedMediaType'+browseId).html('<?php echo $this->config->item('videoType'); ?>');
	$('#selectFileType1'+browseId).val('checked',true);
	$('#'+browseImgMain+'promoImage').attr('src','<?php echo base_url('images/profile_icon.png');?>');
	
	
	$('#fileInput'+browseId).addClass('required');
	$('#fileInput'+browseImgMain).addClass('required');
	$('#fileInput'+browseId).val('');
	$('#fileInput'+browseImgMain).val('');
	$('#fileName'+browseId).val('');
	$('#fileName'+browseImgMain).val('');
	
	if(showFlag == 1)
	{		
		$('#upProVideoForm-Content-Box').slideDown("slow");			
	}
	else
	{
		$('#upProVideoForm-Content-Box').slideUp("slow");		

	}		
}

$(document).ready(function(){	
	$("#WPsupportedMedia").validate({
		submitHandler: function() {				
			var loadView = 'uploadPromoVideo';
			var isExternal = $('#isExternal<?php echo $browseId;?>').val();				
					
			var elementId = $('#videoMediaId').val();
			var addVideo = $('#addVideo').val();
			var imgSrc = '';
			
			if(elementId==0)
				var divId='rowData'+addVideo;
			else
				var divId='rowData'+elementId;
			
			var elemetTable = '<?php echo $elementTable;?>';
			var elementFieldId = '<?php echo $elementFieldId;?>';
			
			var fileId = $('#videofileId').val();
			var thumbFileId = $('#thumbFileId').val();
			var isDefaultElement = 'f';					
			
			
			var fileType=$('#fileType<?php echo $browseId;?>').val();
			var mediaType=(fileType=='video' || fileType==2)?2:((fileType=='audio' || fileType==3)?3:((fileType=='text' || fileType==4)?4:1));
			
			var fileSize=$('#fileSize<?php echo $browseId;?>').val();
			var filePath='<?php  echo $filePath; ?>';
			
			
			
			imgSrc = '<?php echo getImage('',$this->config->item('defaultDocImg'));?>';	
			
							
			if($('#videoMediaId').val() ==0)
				var data = {"projId":$('#projId').val(),"mediaType":mediaType,"mediaTitle":$('#videoMediaTitle').val(),"mediaDescription":$('#videoMediaDescription').val()}; 
			else
				var data = {"mediaId":$('#videoMediaId').val(),"projId":$('#projId').val(),"mediaType":mediaType,"mediaTitle":$('#videoMediaTitle').val(),"mediaDescription":$('#videoMediaDescription').val()}; 
			
			var thumbdata = {"fileName":$('#fileName<?php echo $browseImgMain;?>').val(),"filePath":filePath+'images/',"fileSize":$('#fileSize<?php echo $browseImgMain;?>').val(),"rawFileName":$('#fileInput<?php echo $browseImgMain;?>').val(),"fileType":'1'}	
			if(fileId > 0){
					var fileData = false;
			}else{
				var fileData = {"filePath":filePath,"fileName":$('#fileName<?php echo $browseId;?>').val(),"fileSize":$('#fileSize<?php echo $browseId;?>').val(),"fileType":fileType,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>,"rawFileName":$('#fileInput<?php echo $browseId;?>').val()}; 						
			}
			if($('#fileError<?php echo @$browseId;?>').text()==''){	
				var returnFlag = AJAX('<?php echo base_url(lang()."/common/UpdateSingleMedia");?>',divId,fileData,data,thumbdata,fileId,thumbFileId,elementId,elemetTable,elementFieldId,imgSrc,isDefaultElement,'',loadView);
			}								
		
			if(returnFlag)
			{					
				$("#uploadFileByJquery<?php echo $browseImgMain;?>").click();
				$("#uploadFileByJquery<?php echo $browseId;?>").click();
				
				if(elementId > 0){
					$("#upProVideoForm-Content-Box").slideToggle('slow');
				}
			}
		 }
	});	
});
		
</script>  
