<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php   $class = ($count >= $this->config->item('promo_max_upload'))?'promoImageCount':''; 	?>


<div id="MyPromoForm" class="<?php echo $class ?>">
<div class="upload_media_left_top row"></div><!--upload_media_left_top-->


<?php
$EntityIdToShow =  $currentEntityId;
$promoMediaFormAttributes = array(
	'name'=>'promotionalImageForm',
	'id'=>'promotionalImageForm',
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
echo form_hidden('fileType',$mediaType); 
if(isset($eventNatureId) && $eventNatureId>0)
echo form_hidden('NatureId',$eventNatureId); 
$allowed_image_size='2048 ';
$image_size_unit='MB';
$eventMediaPathTrue = 'xyz';
$browseImgJs = '_imgJs';

$fileNameInput = array(
		'name'	=> 'fileName'.$browseImgJs,
		'value'	=> '',
		'id'	=> 'fileName'.$browseImgJs,
		'type'	=> 'hidden'
	);
	
	$fileSize = array(
		'name'	=> 'fileSize'.$browseImgJs,
		'value'	=> '123',
		'id'	=> 'fileSize'.$browseImgJs,
		'type'	=> 'hidden'
	);
	$isExternal = array(
			'name'	=> 'uploadIntroductoryType',
			'value'	=> 'f',
			'id'	=> 'uploadIntroductoryType',
			'type'	=> 'hidden'
		);
		echo form_input($fileNameInput);
		echo form_input($isExternal);
		echo form_input($fileSize);
		echo '<input type="hidden" value="0" name="mediaId" id="mediaId" />';
		echo '<input type="hidden" value="promoImage" name="formtype" />';
		echo '<input type="hidden" value="0" name="fileId" id="fileId"/>'; 
		echo '<input type="hidden" value="pagingContent" name="divId" id="divId"/>'; 
						
		$galTitle =	array(
			'name'        => 'mediaTitle',
			'id'          => 'mediaTitle',
			'value'		  => set_value('mediaTitle',''),
			'maxlength'   => 80,
			'size'	      => 30,
			'class'       => 'formTip frm_Bdr width548px required',
			'title'       => ''	
		);
		
		$galAltText =	array(
			'name'        => 'mediaDescription',
			'value'	      => set_value('mediaDescription',''),
			'id'          => 'mediaDescription',
			'maxlength'   => 80,
			'size'	      => 30,
			'class'       => 'formTip frm_Bdr width548px',
			'title' => ''	
		);	
			
		$blankImage=getImage('noimage');
		$img = "<img id='promoImage' class='ma' src='$blankImage'>";		
		$fileImg="fileInput".$browseImgJs;
		
		
		
		
		$inputArray = array(
			'name'	=> 'fileInput'.$browseImgJs,
			'class'	=> 'formTip width300px fl required',
			'title'=>  'Upload Image file',
			'value'	=> '',
			'id'	=> 'fileInput'.$browseImgJs,
			'type'	=> 'text',
			'readonly' => true
		);
		
		
		

		$fileUpload = array(
			'name'	=> 'userfileImage',
			'class'	=> 'btn_browse',
			'value'	=> '',
			'accept'=> $this->config->item('imageAccept'),
			'onchange'=> "$('#fileInput_imgJs').val(this.value)",
			'onmousedown'=> "mousedown_tds_button(getElementById('browsebtn_imgJs'));",
			'onmouseup'=> "mouseup_tds_button(getElementById('browsebtn_imgJs'));"
		);
		
		$stockImageFlag = 0;
					
	echo Modules::run("mediatheme/promoImgFrmJs",$this->lang->line('image'),$img,$fileUpload,$inputArray,$browseImgJs,$stockImageFlag,1);

?>

	<div class="row">	
		 <div class="label_wrapper cell">
			 <label class="select_field"><?php echo $label['PromoTitle'];?></label>
		 </div><!--label_wrapper-->		 

		 <div class="cell frm_element_wrapper">	
		 		 
		   <?php echo form_input($galTitle); ?>		   
		  
		  <div class="row wordcounter">	
		  		  
			<?php echo form_error($galTitle['name']); ?>
			<?php echo isset($errors[$galTitle['name']])?$errors[$galTitle['name']]:''; ?>	
					
		  </div> <!--row wordcounter--> 	
				
		</div><!--from_element_wrapper-->  
	</div> <!--row -->
		
	<div class="row"> 	
			<div class="label_wrapper cell">
				<label><? echo $this->lang->line('description');?></label>
			</div><!--label_wrapper-->

			<div class="cell frm_element_wrapper">
				
				<?php echo form_input($galAltText);  ?>
				
				<div class="row wordcounter">
					
					<?php echo form_error($galAltText['name']); ?>
					<?php echo isset($errors[$galAltText['name']])?$errors[$galAltText['name']]:''; ?>
					
			   </div> <!--row wordcounter--> 
		  </div> <!--from_element_wrapper-->
			<div class="seprator_10 row"></div>
				<div class="row mr10">
				<?php
					$button=array('cancelHide','MyPromoForm');
					echo Modules::run("common/loadButtons",$button); 
					
					$button=array('ajaxSave');
					echo Modules::run("common/loadButtons",$button); 
				?>	
				</div>
		</div><!--row -->
</div>
<?php 
	echo form_close();

?>



<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->

<!--upload_media_left_box-->
<div class="seprator_5 clear"></div>
</div>

<script>

$(document).ready(function()
{
	var needToConfirm = false;
	var status = true;
	var flag=0;	
	var ua = $.browser;
	$("select,input,textarea").blur(function ()
	{
		needToConfirm = true;
	})
		
	//alert(document.postGalleryId.submit.value);
	window.onbeforeunload = function() {
    if(ua.msie){ 
		if(needToConfirm == true){
			if (needToConfirm && document.postGalleryId.submit.value!='Save')
			{
				return "Do you want to save the modification before leaving the page.";
			} 
		}
	  }
	  else{
		if (needToConfirm && document.postGalleryId.submit.value!='Save')
		{
			return "Do you want to save the modification before leaving the page.";
		}
		else return null;	
		}		
	}



		
});

//To check for image type 
//customAlert("Coming Soon...",e);

function submitform()
{
    window.onbeforeunload = null;
	document.postGalleryId.save.value= 'Save'; 
	document.postGalleryId.submit();  
}

function canceltoggle(toggleFlag)
{
  if(toggleFlag==0)
  {
	var new_img_src = baseUrl+'images/no_images.jpg';
	$('#promoImage').attr('src',new_img_src);
	$('#mediaId').val(0);
	$('#<?php echo $fileImg ;?>').val('');
	$('#mediaTitle').val('');
	$('#mediaDescription').val('');
	$('#PromoForm-Content-Box').slideUp("slow");
	$('#<?php echo $fileImg ;?>').addClass('required');
  }
  
  if(toggleFlag ==1)
  {
	var new_img_src = baseUrl+'images/no_images.jpg';
	$('#promoImage').attr('src',new_img_src);
	$('#mediaId').val(0);
	$('#<?php echo $fileImg ;?>').val('');
	$('#mediaTitle').val('');
	$('#mediaDescription').val('');
	$('#PromoForm-Content-Box').slideDown("slow");
	$('#<?php echo $fileImg ;?>').addClass('required');
  }
  
}
</script>

