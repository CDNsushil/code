<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
$browseId='';
?>

<div class="row">
	<div class="cell frm_heading">
		<h1><?php echo $this->lang->line('promotionalMaterial');?></h1>
	</div>
	<?php echo $header;?>
</div>
<!-- Accordin Started -->
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('promotionalVideo'); ?>
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
<?php
$values['uploadInterviewType']='';
if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	$workVideoTitle = array(
			'name'	=> 'mediaTitle',
			'id'	=> 'videoMediaTitle',
			'value'	=> '',
			'size'	=> 30,
			'maxlength'  => 30,
			'class' => 'width548px  required'
		);
		
//echo "<pre />"; print_r($productPromotionMediaRecordSet);
	if(!empty($productPromotionMediaRecordSet)){
		foreach($productPromotionMediaRecordSet as $productPromotionMedia){
			$videoStatus = $productPromotionMedia->isMain;
			$videoId = $productPromotionMedia->mediaId;
			$videoPath = $productPromotionMedia->filePath;
			$videoName = $productPromotionMedia->fileName;
			$videoProductId = $productPromotionMedia->prodId;
			$productPromotionMediaPath = base_url().$videoPath.$videoName;
			$videoCategory = $productPromotionMedia->mediaType;
		}
	}
	
?>
<div  class="frm_strip_bg">
<div id="PromoVideo-Content-Box">		
<div class="row"><div class="tab_shadow"></div></div>
	<div id="PromoVideoForm-Content-Box" class="row dn">
		<div class="clear"></div>
		<div class="upload_media_left_top row"></div>	
		
		
		<?php 
		$attr = array('name'=>'WPsupportedMedia','id'=>'WPsupportedMedia');
		echo form_open_multipart($this->uri->uri_string(),$attr);
		
		?>
		<div class="upload_media_left_box">
		<div class="row ">
		
		<input type="hidden" value="0" id="videoMediaId" name="mediaId" />
		<input type="hidden" value="<?php echo $productId;?>" id="productId" name="productId" />
		<input type="hidden" value="0" id="fileId" />
		<input type="hidden" value="f" id="isExternal" />
		<input type="hidden" value="" id="filePath" />
		<input type="hidden" value="2" id="mediaType" />
			<div class="row">
				<div class="label_wrapper cell">
					<label class="select_field"><?php echo $this->lang->line('title'); ?></label>
				</div><!--label_wrapper-->
				<div class=" cell frm_element_wrapper">
					<?php echo form_input($workVideoTitle); ?>
					<?php echo form_error($workVideoTitle['name']); ?>
					<?php echo isset($errors[$workVideoTitle['name']])?$errors[$workVideoTitle['name']]:''; ?>
				</div>
			</div><!--from_element_wrapper-->
			
			<?php 
				$data=array('typeOfFile'=>2,'mediaFileTypes'=>$this->config->item('videoType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$videoPath,'embedCode'=>'', 'required'=>'required', 'label'=>$this->lang->line('file'),'editFlag'=>'','fileTypeFlag'=>'','flag'=>0,'browseId'=>$browseId,'imgload'=>0,'norefresh'=>0, 'view'=>'upload_ws_frm');
				echo Modules::run("common/formInputField",$data);
			?>
			
			<div class="row dn" id="rawFileNameContainerDiv<?php echo $browseId;?>">
				<div class="label_wrapper cell">
				  <label class="select_field"><?php echo $this->lang->line('file');?></label>
				</div>
				<!--label_wrapper-->
				<div class=" cell frm_element_wrapper mt5" id="rawFileNameDiv<?php echo $browseId;?>">
				</div>
			 </div>
			 
			<div class="row">
				<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class=" cell frm_element_wrapper">
					<div class="Req_fld cell">Required fields</div><!--Req_fld-->
					<div class="frm_btn_wrapper padding-right0 ">
						<?php						
						$button=array('ajaxSave','cancelVtoggle','buttonId'=>$browseId);
						echo Modules::run("common/loadButtons",$button); 
						?>						
					</div>
				</div>
			</div><!--from_element_wrapper-->
		<div class="seprator_27 row"></div>
		</div>
		
		</div>

		<?php echo form_close(); ?>
		<div class="upload_media_left_bottom row"></div>

		</div>
		
		<div id="WorkPromo-Content">
	<?php
				
					if(!empty($productPromotionMediaRecordSet))
					{
							foreach($productPromotionMediaRecordSet as $productPromotionMedia)
							{
								$imageStatus = $productPromotionMedia->isMain;
								$mediaId 	 = $productPromotionMedia->mediaId;
								$imagePath 	 = $productPromotionMedia->filePath;
								$imageName   = $productPromotionMedia->fileName;
								$mediaTitle  = $productPromotionMedia->mediaTitle;
								$projID = $productPromotionMedia->prodId;
								$fileId = $productPromotionMedia->fileId;
								$isExternal = $productPromotionMedia->isExternal;

								$mediaType = 'video';
								$fileType = $productPromotionMedia->fileType;
								$videoCategory = $productPromotionMedia->mediaType;
								
								$embedCode=$isExternal=='t'?str_replace(array('&lt;','&gt;'),array('<','>'),$imagePath):'';
								 
								$Data=array(
									'mediaId'=>$mediaId,
									'mediaTitle'=>$mediaTitle,
									'isExternal'=>$isExternal,
									'fileId'=>$fileId,
									'mediaType'=>$mediaType,
									'filePath'=>$imagePath,
									'rawFileName'=>$productPromotionMedia->rawFileName,
									'embbededURL'=>$embedCode,
									'browseId'=>$browseId
								);
								$jsonData=json_encode($Data);
								
								$convsrsionFlag=false;
									$convsrsionFileType=$this->config->item('convsrsionFileType');
									if($productPromotionMedia->isExternal=='f' && in_array($productPromotionMedia->fileType,$convsrsionFileType)){
										$convsrsionFlag=true;
										if($productPromotionMedia->jobStsatus == 'DONE'){
											$conversionStatusClass='icon_filesent';
											$conversionStatusToolTip=$this->lang->line('Converted');
										}elseif($productPromotionMedia->jobStsatus == 'FAILS'){
											$conversionStatusClass='icon_filetransfer';
											$conversionStatusToolTip=$this->lang->line('conversionFailed');
										}else{
											$conversionStatusClass='icon_inprocess';
											$conversionStatusToolTip=$this->lang->line('converting');
										}
									}
								?>
							<script>
								var data<?php echo $mediaId;?>=<?php echo $jsonData;?>;
							</script>
							   <div class="label_wrapper cell bg-non">								
							   </div>								  
								<div class=" cell frm_element_wrapper extract_content_bg" id="rowData<?php echo $mediaId;?>">
								<div class="extract_img_wp"> 
								<?php 
									
									$previewUrl = '/products/previewVideo/'.$mediaId;
									$fileDirPath='';
								    $deleteCache='product_'.$productPromotionMedia->prodId.'_'.$userId;
									if($isExternal=='t')
									{
										$file=urlencode($imagePath);
										$fileType='external';
									}
									else
									{
										$filePath=$imagePath;
										$fpLen=strlen($filePath);
										if($fpLen > 0 && substr($filePath,-1) != '/'){
											$filePath=$filePath.'/';
										}
										$fileDirPath=$file=$filePath.$imageName;
										$fileType=2;
									}	
									$entityId= getMasterTableRecord('Product');				
									echo '<img class="formTip ptr maxWH30 ma" src="'.getImage('',$this->config->item('defaultVideoImg')).'" title="'.$mediaTitle.'" onclick="openPlayerLightBox(\'popupBoxWp\',\'popup_box\',\'/common/playCommonVideo\',\''.$fileId.'\',\''.$entityId.'\',\''.$projID.'\',\''.$projID.'\');" />';
								
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
									<?php if($imageStatus != 't') { ?>
											<div class="small_btn dn"><a style="cursor:pointer" onclick="makeFeatured('<?php echo $mediaId;?>','<?php echo $productId?>','image');"></div>
											</a>
									<?php } ?>
								
								 <div class="small_btn"><a href="javascript:void(0)" onclick="deleteTabelRow('ProductPromotionMedia','mediaId','<?php echo $mediaId;?>','','','','<?php echo $fileId;?>','<?php echo $fileDirPath;?>',1,'<?php echo $deleteCache;?>',1);" class="formTip" title="<?php echo $this->lang->line('delete');?>"><div class="cat_smll_plus_icon"></div></a></div>
								 <div class="small_btn"><a onclick ="editMediaFile(data<?php echo $mediaId;?>);" href="javascript:void(0)" class="formTip" title="<?php echo $this->lang->line('edit');?>"><div class="cat_smll_edit_icon"></div></a></div>
								</div>
								</div>
						<?php 			
						
						} 				
				}
				
				$maxWorkVideo = $this->config->item('maxWorkVideo');

				if($count>0)
				$resultantVideoEmpty = $maxWorkVideo -  $count;
				else
					$resultantVideoEmpty = 0;	
				
				if($count != $maxWorkVideo)
				{
					while ($resultantVideoEmpty < $maxWorkVideo) {
						$resultantVideoEmpty++;
						?>
						<div class="label_wrapper cell bg-non">					
						</div>
						<div class=" cell frm_element_wrapper extract_content_bg " id="rowDataAdd<?php echo $resultantVideoEmpty;?>">
							<div class="extract_img_wp opacity_4"> 
								<img src="<?php echo getImage('',$this->config->item('defaultVideoImg'));?>" class="formTip ptr maxWH30 ma" original-title="">
							</div>
							<!-- extract_img_wp -->
							<div class="extract_heading_box opacity_4">
								<?php echo $this->lang->line('add').'&nbsp;'.$this->lang->line('promoVideo');?></div>
							<!-- extract_heading_box -->
							<div class="extract_button_box">
							  <div class="small_btn"><a onclick="cancelVtoggle(1)" href="javascript:void(0)" class="formTip" title="<?php echo $this->lang->line('add');?>"><div class="cat_smll_add_icon"></div></a></div>
							</div>
						</div>
						<input type="hidden" id="addVideo" name="addVideo" value="Add<?php echo $resultantVideoEmpty;?>" />
						<?				
						
					}			
				}
		
	?>
	</div>
	<div class="seprator_27 row"></div>
	</div>
</div>
</div>

<div class="videoLightBoxWp" id="videoLightBoxWp" style="display:none;">
	<div id="close-postPreviewBox" class="tip-tr close-customAlert" original-title=""></div>
	<div class="productFormContainer" id="productFormContainer"></div>
</div>

<script type="text/javascript" charset="utf-8">


function editMediaFile(objMedia)
{
	var rawFileName = objMedia.rawFileName;
	var isExternal  = objMedia.isExternal;
	var embbededURL  = objMedia.embbededURL;
	var browseId  = objMedia.browseId;
	
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
	
	var val1 = objMedia.mediaId;
	var val2 = objMedia.mediaType;
	var val3 = objMedia.mediaTitle;
	var val4 = objMedia.fileId;
	var val5 = objMedia.isExternal;
	var val6 = objMedia.filePath;
	
	$('#videoMediaId').val(val1);
	$('#fileType').val(val2);	
	$('#videoMediaTitle').val(val3);
	$('#fileId').val(val4);
	$('#isExternal').val(val5);
	$('#filePath').val(val6);
	
	$('#fileInput'+browseId).removeClass('required');
	$('#PromoVideoForm-Content-Box').slideDown("slow");
}

function cancelVtoggle(showFlag){
	
	var val1 = 0;
	var val2 = '';
	var val3 = '';	
	var val4 = '';	
	
	
	$('#videoMediaId').val(val1);
		
	$('#videoMediaTitle').val(val3);
	
	$('#fileInput').val(val4);
	selectBox();
	
	if(showFlag == 1)
	{	
				
		$('#PromoVideoForm-Content-Box').slideDown("slow");			
	}
	else
	{
			
		$('#PromoVideoForm-Content-Box').slideUp("slow");		

	}
		
}

function calcelAddMode(videoId)
{
	location.href=baseUrl+language+"/product/addMoreSaleVideo/"+videoId+"/sale";
}

function deleteVideo(productVideoId,productId)
{
		var conBox = confirm(areYouSure);
		if(conBox){
			location.href=baseUrl+language+"/product/deleteproductPromotionVideo/"+productVideoId+"/"+productId;
		return true;
		}
		else{
		return false;
		}
}



$(document).ready(function(){		
		var uniId = '<?php echo $browseId;?>';
		
		$("#WPsupportedMedia").validate({
			submitHandler: function() {
				
				var loadView = 'uploadPromoVideo';
				var isExternal = $('#isExternal').val();
				
				var mediaType = $('#mediaType').val();				
				var elementId = $('#videoMediaId').val();
				var addVideo = $('#addVideo').val();
				var imgSrc = '';
				
				if(elementId==0)
					var divId='rowData'+addVideo;
				else
					var divId='rowData'+elementId;
									
				var elemetTable = '<?php echo $tableName;?>';
				var elementFieldId = '<?php echo $elementFieldId;?>';
				
				var fileId = $('#fileId').val();
				var isDefaultElement = 'f';					
								
				var fileType=2;
				var filePath='<?php  echo $videoPath; ?>';
				imgSrc = '<?php echo getImage('',$this->config->item('defaultVideoImg'));?>';			
								
				if($('#videoMediaId').val() ==0)
					var data = {"prodId":$('#productId').val(),"mediaType":$('#mediaType').val(),"mediaTitle":$('#videoMediaTitle').val()}; 
				else
					var data = {"mediaId":$('#videoMediaId').val(),"prodId":$('#productId').val(),"mediaType":$('#mediaType').val(),"mediaTitle":$('#videoMediaTitle').val()}; 
				
				var fileData = {"filePath":filePath,"fileName":$('#fileName'+uniId).val(),"fileLength":$('#fileLength').val(),"fileSize":$('#fileSize'+uniId).val(),"fileType":fileType,"isExternal":isExternal,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>}; 
								
				if(isExternal=='t'){
					var fileData = {"rawFileName":'', "filePath":$('#embbededURL').val(),"fileName":'',"fileLength":$('#fileLength').val(),"fileSize":0,"fileType":fileType,"isExternal":isExternal,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>}; 
				}else{
					if(elementId==0){
						var fileData = {"rawFileName":$('#fileInput'+uniId).val(),"filePath":filePath,"fileName":$('#fileName'+uniId).val(),"fileLength":$('#fileLength').val(),"fileSize":$('#fileSize'+uniId).val(),"fileType":fileType,"isExternal":isExternal,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>}; 
					}else{
						var fileData = '';
					}
				}					
				if($('#fileError<?php echo @$browseId;?>').text()=='')
				var returnFlag = AJAX('<?php echo base_url(lang()."/common/UpdateMediaTable");?>',divId,fileData,data,fileId,elementId,elemetTable,elementFieldId,imgSrc,isDefaultElement,loadView);
				
				if(returnFlag)
				{
					$("#uploadFileByJquery<?php echo $browseId;?>").click();
					if(elementId > 0 || isExternal=='t'){
						$("#PromoVideoForm-Content-Box").slideToggle('slow');
					}
				}
				
			 }
		});	
	});
	
</script>
