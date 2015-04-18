<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$fileMaxSize=isset($fileMaxSize)?$fileMaxSize:$this->config->item('videoSize');
$class = ($count >= $this->config->item('promo_max_upload'))?'promoImageCount':''; 	?>
<div>
<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
<div id="MyMediaForm" class="<?php echo $class ?>">
<?php $EntityIdToShow =  $currentEntityId;
$browseImgJs = $toggleId;

$promoMediaFormAttributes = array(
	'name'=>'mediaForm'.$browseImgJs,
	'id'=>'mediaForm'.$browseImgJs,
	'onafterupdate'=>"OnAfterUpdate();"
);


$postGalleryId = array(
'name' => 'postGalleryId',
'id' => 'postGalleryId',
'value' => 0,
'type' => 'hidden'); 
					
echo form_open_multipart('',$promoMediaFormAttributes);

?>
<div class="upload_media_left_box">	
<?php

if(isset($EntityIdToShow) && $EntityIdToShow>0)
	echo form_hidden('EntityId',$EntityIdToShow); 
	//echo form_hidden('LaunchEntityId',0); 
	echo form_hidden('fileType'.$browseImgJs,$mediaType); 
 


	
	$isExternal='f';
	
	$lastInsertedMediaId = array(
		'name'	=> 'lastInsertedMediaId',
		'value'	=> '',
		'id'	=> 'lastInsertedMediaId',
		'type'	=> 'hidden'
	);
		echo form_input($lastInsertedMediaId);
		echo '<input type="hidden" value="0" name="mediaId" id="mediaId'.$browseImgJs.'" />';
		echo '<input type="hidden" value="promoImage" name="formtype" />';
		echo '<input type="hidden" value="0" name="fileId" id="fileId'.$browseImgJs.'"/>'; 
						
		$galTitle =	array(
			'name'        => 'mediaTitle',
			'id'          => 'mediaTitle'.$browseImgJs,
			'value'		  => set_value('mediaTitle',''),
			'maxlength'   => 80,
			'size'	      => 30,
			'class'       => 'formTip frm_Bdr width548px required',
			'title'       => ''	
		);
		
		$galAltText =	array(
			'name'        => 'mediaDescription',
			'value'	      => set_value('mediaDescription',''),
			'id'          => 'mediaDescription'.$browseImgJs,
			'maxlength'   => 80,
			'size'	      => 30,
			'class'       => 'formTip frm_Bdr width548px',
			'title' => ''	
		);	
			
		$blankImage = getImage('',$this->config->item('defaultImg'));
		
		$img = "<img id='mediaSrc".$browseImgJs."' class='ma backgroundBlack' src='".$blankImage."'>";
				
		$fileImg = "fileInput".$browseImgJs;		
		
		$editFlag = '';
		$fileTypeFlag = '';
		$embedCode = '';
		$required = '';
		$reminingSize = 50;
		
		if(($browseImgJs == 'video') || ($browseImgJs == 2))	{
			$fileConfigType = 'videoAccept';$fileType = 2;$flag=0;
			$mediaLabel = 'video';
		}
		if(($browseImgJs == 'audio') || ($browseImgJs == 3))	{
			$fileConfigType = 'audioAccept';$fileType = 3;$flag=0;
			$mediaLabel = 'audio';
		}
		if(($browseImgJs == 'writMater') || ($browseImgJs == 'text') || ($browseImgJs == 4))	{
			$fileConfigType = 'writtenMaterialAccept';$fileType = 4; $flag=1;
			$mediaLabel = 'writtenMaterial';
		}
		if(strcmp($browseImgJs,'imageShowcase')==0)	{
			$fileConfigType = 'imageAccept';$fileType = 1; $flag=1;
			$mediaLabel = 'image';
		}
		
	//To show the extension allowed options
	//echo 'fileConfigType:'.$this->config->item($fileConfigType);
	
	if(strcmp($sectionHeading,'postLaunchPRImages')==0) $norefresh=0;
	else $norefresh=1;
	
	$fpLen=strlen($mediaPath);
	if($fpLen > 0 && substr($mediaPath,-1) != '/'){
				$mediaPath=$mediaPath.'/';
	}
	
	$data=array('typeOfFile'=>$fileType,'mediaFileTypes'=>$mediaFileTypes,'fileMaxSize'=>$fileMaxSize,'isEmbed'=>$isExternal,'fileName'=>'','fileSize'=>0,'filePath'=>$mediaPath,'embedCode'=>$embedCode, 'required'=>'required', 'label'=>$this->lang->line($mediaLabel),'editFlag'=>$editFlag,'fileTypeFlag'=>$fileTypeFlag,'flag'=>$flag,'browseId'=>$browseImgJs,'imgload'=>$imgload,'norefresh'=>$norefresh, 'view'=>'upload_ws_frm');
	echo Modules::run("common/formInputField",$data);
	//echo Modules::run("mediatheme/mediaFrmJs",$this->lang->line($browseImgJs),$img,'',$inputArray,$browseImgJs,$stockImageFlag,0);

?>
  <div class="row dn" id="rawFileNameContainerDiv<?php echo $toggleId;?>">
	<div class="label_wrapper cell">
	  <label class="select_field"><?php echo $this->lang->line($mediaLabel);?></label>
	</div>
	<!--label_wrapper-->
	<div class=" cell frm_element_wrapper mt5" id="rawFileNameDiv<?php echo $toggleId;?>">
	</div>
 </div>

	<div class="row">		
		 <div class="label_wrapper cell">			 
			 <label class="select_field"><?php echo $this->lang->line('PromoTitle');?></label>			 
		 </div><!--label_wrapper-->		 

		 <div class="cell frm_element_wrapper">			 		 
		   <?php echo form_input($galTitle); ?>			  
		  <div class="row wordcounter">			  		  
			<?php echo form_error($galTitle['name']); ?>
			<?php echo isset($errors[$galTitle['name']])?$errors[$galTitle['name']]:''; ?>					
		  </div> <!--row wordcounter--> 					
		</div><!--from_element_wrapper-->  
	</div> <!--row -->
	<?php				
		
		$wordOption=array('minVal'=>0,'maxVal'=>200);
		$data=array('name'=>'mediaDescription','value'=>'', 'view'=>'description','wordOption'=>$wordOption,'labelText'=>'description','id' => 'mediaDescription'.$browseImgJs,'cols'=>'20','rows'=>'2','required'=>'','addclass'=>'width548px');
		$this->load->view("common/description",$data);
	?>			
	
	<div class="row">	
		<div class="label_wrapper cell bg_none"></div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">	
			<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
			<div class="frm_btn_wrapper padding-right0">
			<!--<div class="tds-button fl"><button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Cancel" name="cancel" onclick="cancelMediatoggle('<?php //echo $browseImgJs;?>',0);" type="button" id="cancelHideButtonCommon<?php //echo $browseImgJs;?>" style="background-position: 0px -38px;" class="dash_link_hover"><span style="background-position: right -38px;"><div class="Fleft">Cancel</div> <div class="icon-form-cancel-btn"></div></span></button></div>-->
			
			<div class="tds-button Fleft"><button id="cancelHideButtonCommon<?php echo $browseImgJs;?>" type="button" class="ajaxCancelButton dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" onclick="cancelMediatoggle('<?php echo $browseImgJs;?>',0);" style="background-position: 0px -38px; "><span style="background-position: 100% -38px; "><div class="Fleft">Close</div><div class="icon-form-close-btn"></div></span></button></div>
			
			
			<?php
			$button=array('ajaxSave');
			echo Modules::run("common/loadButtons",$button); 
			?>	
			</div>
			<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('allReqFieldMsg');?></div></div>
		</div> <!--from_element_wrapper-->			
	</div><!--row -->
</div>
<?php 
	echo form_close();
?>
<div class="upload_media_left_bottom row"></div>
<div class="seprator_5 clear"></div>
</div>
<?php 

	if(!isset($browseImgJs)){
		$browseImgJs='video';
	}
	
	$fileImg="fileInput".@$browseImgJs;
	$fileNameImage="fileName".@$browseImgJs;
	
?>
<script type="text/javascript">
		$(document).ready(function(){
			
		$("#mediaForm<?php echo $browseImgJs;?>").validate({
		submitHandler: function() {	
			var browseImgJs = '<?php echo $browseImgJs?>';
			var browseId = '<?php echo $browseImgJs?>';
			var elementId = $('#mediaId<?php echo $browseImgJs?>').val();
			var mediaDescription=$('#mediaDescription<?php echo $browseImgJs?>').val();  
			var mediaTitle=$('#mediaTitle<?php echo $browseImgJs?>').val(); 			
			var promoElementTable = '<?php echo $elementTable;?>';  
			var promoElementFieldId = 'mediaId';
			var promoImagePath = '<?php echo $mediaPath;?>'; 
			var isExternal = $('#isExternal<?php echo $browseImgJs?>').val();
			var fileId =$('#fileId<?php echo $browseImgJs?>').val();
			var fieldName = '<?php echo $elementFieldId;?>'; 
			var fileSize=$('#fileSize<?php echo $browseImgJs?>').val();
			
			var imgSrc = ''; 
			var elementCount=<?php echo $count;?>;
			var isDefaultElement='f';
			var entityMediaType='<?php echo $mediaType;?>';
			if('<?php echo $elementFieldId;?>' == 'launchEventId'){
			if(elementId == 0)
				var data = {"entityMediaType":entityMediaType,"entityField":fieldName,"entityId":<?php echo $entityId;?>,"mediaTitle":mediaTitle,"mediaDescription":mediaDescription,"mediaType":entityMediaType,"launchPostPR":'t'}; 
			else
				var data = {"entityMediaType":entityMediaType,"entityField":fieldName,"entityId":<?php echo $entityId;?>,"mediaId":elementId,"mediaTitle":mediaTitle,"mediaDescription":mediaDescription,"mediaType":entityMediaType,"launchPostPR":'t'}; 
			}
			else{
				if(elementId == 0)
					var data = {"entityMediaType":entityMediaType,"entityField":fieldName,"entityId":<?php echo $entityId;?>,"mediaTitle":mediaTitle,"mediaDesc":mediaDescription,"mediaType":entityMediaType}; 
				else
					var data = {"entityMediaType":entityMediaType,"entityField":fieldName,"entityId":<?php echo $entityId;?>,"mediaId":elementId,"mediaTitle":mediaTitle,"mediaDesc":mediaDescription,"mediaType":entityMediaType}; 
			}		
			if($('#<?php echo $fileImg;?>').val()!=''){
				
				if(isExternal=='t'){
					var promofileData = {"filePath":$('#embbededURL'+browseImgJs).val(),"fileName":'',"fileSize":0,"fileType":entityMediaType,"isExternal":isExternal,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>}; 
				}else{			
					var promofileData = {"filePath":promoImagePath,"rawFileName":$('#<?php echo $fileImg;?>').val(),"fileName":$('#<?php echo $fileNameImage;?>').val(),"fileSize":fileSize,"fileType":entityMediaType,"isExternal":'f',"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>};
				}
			}
			else{
				if(isExternal=='t'){
					var promofileData = {"filePath":$('#embbededURL'+browseImgJs).val(),"fileName":'',"fileSize":0,"fileType":entityMediaType,"isExternal":isExternal,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>}; 
				}else{			
					var promofileData = '';
				}
				
			}		
		
		if($('#fileError<?php echo @$browseImgJs;?>').text()=='')
		var returnFlag = AJAX('<?php echo base_url(lang()."/mediatheme/UpdatePromoMedia");?>','pagingContent<?php echo $browseImgJs?>',promofileData,data,fileId,elementId,promoElementTable,promoElementFieldId,imgSrc,isDefaultElement,'<?php echo $browseImgJs;?>'); 
		
		if(returnFlag){
				
				$("#uploadFileByJquery"+browseImgJs).click();
				if(elementId > 0 || isExternal=='t'){
					cancelMediatoggle('<?php echo $browseImgJs;?>',0);
				}
			}
			return true;
		}
	});

});





function cancelMediatoggle(browseId,toggleFlag)
{	
 
	
	var imgsrcload = '<?php echo $imgload;?>';	    
	var new_img_src = '<?php echo $blankImage;?>';	
	
	if($('#rawFileNameContainerDiv'+browseId))
		$('#rawFileNameContainerDiv'+browseId).hide()
	if($('#uploadFileSection'+browseId))
		$('#uploadFileSection'+browseId).show()
	if($('#rawFileNameDiv'+browseId))
		$('#rawFileNameDiv'+browseId).html('');
		
	if('#uploafFileButton'+browseId)
		$('#uploafFileButton'+browseId).show();
	if('#Uploadvideo'+browseId)
		$('#Uploadvideo'+browseId).show();
	
	if('#embedButton'+browseId)
		$('#embedButton'+browseId).show();
	if('#EmbeddedURL'+browseId)
		$('#EmbeddedURL'+browseId).hide();
				
	$('#mediaSrc'+browseId).attr('src',new_img_src);
	$('#'+browseId+'promoImage').attr('src',new_img_src);
	$('#mediaId'+browseId).val(0);
	$('#fileName'+browseId).val('');
	$('#fileSize'+browseId).val('');
	$('#fileId'+browseId).val(0);
	$('#<?php echo $fileImg ;?>').val('');
	$('#mediaTitle'+browseId).val('');
	$('#mediaDescription'+browseId).val('');
	$('#embbededURL'+browseId).val('');
	$('#<?php echo $fileImg ;?>').addClass('required'); 
	if(toggleFlag){
		$('#'+browseId+'Form-Content-Box').slideDown("slow");
	}else{
		$('#'+browseId+'Form-Content-Box').slideUp("slow");
	}
}

function uploadMathod(obj){
	var Id = $(obj).attr('id');
	if(Id == 'uploadSelected'){
		if($('#isDefaultElement').val()=='f'){
			if('#showInUploadCase'){
				$('#showInUploadCase').show();
			}
		}
	}else{
		if('#showInUploadCase'){
			$('#showInUploadCase').hide();
		}
	}
}
</script>
</div>
