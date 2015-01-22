<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$fileMaxSize=isset($fileMaxSize)?$fileMaxSize:$this->config->item('videoSize');
$browseId=$browseImgJs; 
if(@$promoImgTitle!='') $class = '';
else $class = ($count >= $this->config->item('promo_max_upload'))?'promoImageCount':'';
$userBrowser = get_user_browser();
$showFormIE=$showForm='dn';
if($userBrowser == 'ie'){
 $showFormIE='';
}
?>
<div id="uploadFileByJquery<?php echo $browseImgJs;?>"></div>
<div id="MyPromoForm<?php echo $browseImgJs;?>" class="<?php echo $class ?>">
<div class="row clear">	
		<div id="FileContainer<?php echo @$browseImgJs;?>" class="fr">
			<div class="fileInfo" id="fileInfo<?php echo @$browseImgJs;?>">
				<div id="progressBar<?php echo @$browseImgJs;?>" class="plupload_progress">
					<div class="progressBar_msg fl"><?php echo $this->lang->line('fileUploading');?></div>
						<div class="plupload_progress_container fl">
						<div id="plupload_progress_bar<?php echo @$browseImgJs;?>" class="plupload_progress_bar"></div>
						</div>
					</div>
		<span id="percentComplete<?php echo @$browseImgJs;?>" class="percentComplete fl">
		</span>
		</div>
		<div id="dropArea<?php echo $browseImgJs;?>"></div>
		</div>
</div>
<div id="PromoForm-Content-Box<?php echo $browseImgJs;?>" class="row <?php echo $showFormIE;?>">
<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
<?php
$EntityIdToShow =  @$currentEntityId;
$promoMediaFormAttributes = array(
	'name'=>'promotionalImageForm'.$browseId,
	'id'=>'promotionalImageForm'.$browseId,
	'onafterupdate'=>"OnAfterUpdate();"
);

$postGalleryId = array(
'name' => 'postGalleryId',
'id' => 'postGalleryId'.$browseId,
'value' => 0,
'type' => 'hidden'); 
			
echo form_open_multipart('',$promoMediaFormAttributes);
?>
<div class="upload_media_left_box">
<?php
 
if(isset($EntityIdToShow) && $EntityIdToShow>0)
echo form_hidden('EntityId',$EntityIdToShow); 
//echo form_hidden('LaunchEntityId',0); 
echo form_hidden('fileType',$mediaType); 
if(isset($eventNatureId) && $eventNatureId>0) echo form_hidden('NatureId',$eventNatureId); 
$allowed_image_size='2048 ';
$image_size_unit='MB';
$eventMediaPathTrue = 'xyz';
	
		echo '<input type="hidden" value="0" name="mediaId" id="mediaId'.$browseImgJs.'" />';
		echo '<input type="hidden" value="promoImage" name="formtype" />';
		echo '<input type="hidden" value="0" name="fileId" id="fileId'.$browseImgJs.'"/>'; 
		echo '<input type="hidden" value="pagingContent" name="divId" id="divId'.$browseImgJs.'"/>'; 
						
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
			
		$blankImage=getImage('noimage');
		$img = "<img id='promoImage".$browseImgJs."' class='ma backgroundBlack' src='$blankImage'>";		
		$fileImg="fileInput".$browseImgJs;
		
		$stockImageFlag = 0;
		$data=array('typeOfFile'=>1,'mediaFileTypes'=>$this->config->item('imageType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$promoImagePath,'embedCode'=>'', 'required'=>'required', 'label'=>$this->lang->line('image'),'editFlag'=>0,'fileTypeFlag'=>0,'flag'=>1,'browseId'=>$browseImgJs,'imgload'=>1,'norefresh'=>0, 'view'=>'upload_ws_frm');
	    echo Modules::run("common/formInputField",$data);
	    
	//echo Modules::run("mediatheme/promoImageAccFrmJs",$this->lang->line('image'),$img,$fileUpload,$inputArray,$browseImgJs,$stockImageFlag,1);
	?>
	<div class="row dn" id="rawFileNameContainerDiv<?php echo $browseImgJs;?>">
		<div class="label_wrapper cell">
		  <label class="select_field"><?php echo $this->lang->line('image');?></label>
		</div>
		<!--label_wrapper-->
		<div class=" cell frm_element_wrapper mt5" id="rawFileNameDiv<?php echo $browseImgJs;?>">
		</div>
	 </div>

	<div class="row">	
		 <div class="label_wrapper cell">
			 <label class="select_field"><?php echo (@$promoImgTitle!='')?@$promoImgTitle:$this->lang->line('PromoTitle');?></label>
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
	if((@$promoImgTitle=='')){				
		$wordOption=array('minVal'=>0,'maxVal'=>50);
		$data=array('name'=>'mediaDescription'.$browseImgJs,'value'=>'', 'view'=>'oneline_description','wordOption'=>$wordOption,'labelText'=>'description');
		echo Modules::run("common/formInputField",$data);
	}
	?>
		<div class="row"> 
	
			<div class="label_wrapper cell bg_none"></div><!--label_wrapper-->
			<div class="cell frm_element_wrapper">	
				<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
				<div class="frm_btn_wrapper padding-right0">
				<?php					
					$button=array('ajaxSave');
					echo Modules::run("common/loadButtons",$button); 
					$button=array('cancelHide','MyPromoForm'.$browseImgJs);
					echo Modules::run("common/loadButtons",$button); 
				?>	
				</div>
				<?php 
				if(@$showaddbutton==1){ ?>
					<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
					<?php 
				}
				else{ ?>
				<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('upcomingPromoMatReqFieldMsg');?></div></div>
				<?php } ?>
			</div> <!--from_element_wrapper-->
			
		</div><!--row -->
</div>
<?php 
	echo form_close();
?>
<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->
<div class="seprator_5 clear"></div>
</div>
</div>
<?php
// browser is IE Start
	if(isset($showForm) && $showForm=='dn' && $userBrowser == 'ie'){?>
		<script> toggleWithDelay("#PromoForm-Content-Box<?php echo $browseImgJs;?>");</script>
		<?php 
	}
// browser is IE END
?>
<script>
$(document).ready(function(){
		$("#promotionalImageForm<?php echo $browseImgJs;?>").validate({			
			submitHandler: function() {			
			var elementId = $('#mediaId<?php echo $browseImgJs;?>').val();  
			var mediaDescription=$('#mediaDescription<?php echo $browseImgJs;?>').val(); 
			var mediaTitle=$('#mediaTitle<?php echo $browseImgJs;?>').val(); 			
			var divId=$('#divId<?php echo $browseImgJs;?>').val();			
			var promoElementTable = '<?php echo $promoElementTable;?>';  
			var promoElementFieldId = '<?php echo $promoElementFieldId;?>'; 	
			var promoImagePath = '<?php echo $promoImagePath;?>'; 
			var fileId =$('#fileId<?php echo $browseImgJs;?>').val();
			var fieldName = '<?php echo $promoEntityField;?>'; 
			var fileSize=$('#fileSize<?php echo $browseImgJs?>').val();
			var isMain=$('#isMain<?php echo $browseImgJs;?>').val();
			var browseId = '<?php echo $browseImgJs?>';
			var imgSrc = ''; 
			var elementCount=<?php echo $count;?>;
			var isDefaultElement='f';
			var entityMediaType='<?php echo $entityMediaType;?>';
			
			if(elementId == 0)
				var data = {"entityMediaType":entityMediaType,"entityField":fieldName,"entityId":"<?php echo $entityId;?>","mediaTitle":mediaTitle,"mediaDescription":mediaDescription,"mediaType":'1',"isMain":isMain}; 
			else
				var data = {"entityMediaType":entityMediaType,"entityField":fieldName,"entityId":"<?php echo $entityId;?>","mediaId":elementId,"mediaTitle":mediaTitle,"mediaDescription":mediaDescription,"mediaType":'1',"isMain":isMain}; 
						
			if($('#<?php echo $fileImg;?>').val()!='')
			{				
				var promofileData = {"filePath":promoImagePath,"rawFileName":$('#<?php echo $fileImg;?>').val(),"fileName":$('#fileName'+browseId).val(),"fileSize":fileSize,"fileType":"1","isExternal":'f',"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>};
			}
			else
			{
				var promofileData = '';
			}		
			if($('#fileError<?php echo @$browseImgJs;?>').text()=='')
				var returnFlag = AJAX('<?php echo base_url(lang()."/mediatheme/UpdatePromoImage");?>',divId,promofileData,data,fileId,elementId,promoElementTable,promoElementFieldId,imgSrc,isDefaultElement,'<?php echo $browseImgJs;?>'); 
				if(returnFlag){
					$("#uploadFileByJquery"+browseId).click();
					if(elementId > 0){
						canceltoggle(0);
					}
				}
			}
		});
});

</script>
