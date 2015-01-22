<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
	$(document).ready(function(){					
		$("#postMediaGalleryForm").validate();	
	});
</script>

<?php
$formAttributes = array(
'name'=>'postMediaGalleryForm',
'id'=>'postMediaGalleryForm',
);

$postGalleryId = array(
'name' => 'postGalleryId',
'id' => 'postGalleryId',
'value' => 0,
'type' => 'hidden');
					
echo form_open_multipart('blog/postMediaGalleryForm',$formAttributes);
if(isset($postMediaGallery['postGalleryId']))
echo form_input($postGalleryId);
echo form_hidden('save');
								
	$galTitle =	array(
	'name'        => 'galTitle',
	'id'          => 'galTitle',
	'value'	=> set_value('galTitle',$postMediaGallery['galTitle']),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip frm_Bdr width556px required',
	'title'       => $label['title']
	
	);
	$galAltText =	array(
	'name'        => 'galAltText',
	'value'	=> set_value('galAltText',$postMediaGallery['galAltText']),
	'id'          => 'galAltText',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip frm_Bdr width556px',
	'title' => $label['altText']
	
	);	
			
			//-----Commom Image View-----
			
			$imgsrc = getImage('');
			$img = '<img id="galImage" class="ma" src="'.$imgsrc.'">';

			$inputArray = array(
				'name'	=> 'fileInput',
				'class'	=> 'formTip width300px fl required',
				'value'	=> '',
				'id'	=> 'fileInput',
				'type'	=> 'text',
				'readonly' => true
			);

			$fileUpload = array(
				'name'	=> 'image',
				'class'	=> 'btn_browse',
				'value'	=> '',
				'accept'=> $this->config->item('imageAccept'),
				'onchange'=> "$('#fileInput').val(this.value)",
				'onmousedown'=> "mousedown_tds_button(getElementById('browse_btn'));",
				'onmouseup'=> "mouseup_tds_button(getElementById('browse_btn'));"
			);
			
			$stockImageFlag = 0;
?>
<div id="showGalForm">
<?php
		echo Modules::run("mediatheme/promoImageForm",$label['add'].' '.$label['image'],$img ,$fileUpload,$inputArray,0,$stockImageFlag);
?>

	<div class="row"> 
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['title'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<?php echo form_input($galTitle); ?>
			<div class="row wordcounter">
				<?php echo form_error($galTitle['name']); ?>
				<?php echo isset($errors[$galTitle['name']])?$errors[$galTitle['name']]:''; ?>
			</div>
		</div>
	</div><!--from_element_wrapper-->  
	
	<div class="row"> 
		<div class="label_wrapper cell">
			<label><?php echo $label['altText'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<?php echo form_input($galAltText);  ?>
			<div class="row wordcounter">
				<?php echo form_error($galAltText['name']); ?>
				<?php echo isset($errors[$galAltText['name']])?$errors[$galAltText['name']]:''; ?>
			</div>
		</div>
			
	</div><!--from_element_wrapper--> 

	<div class="row  ">
		<div class="label_wrapper cell bg_none"></div><!--label_wrapper-->
			<div class="cell frm_element_wrapper">
			<div class="cell Fleft">
				<div class="Req_fld cell"><?php echo $label['requiredFields'];?></div><!--Req_fld-->
				
			</div>
			
			<div class="fr">	
				
				<?php
				$button=array('save');
				echo Modules::run("common/loadButtons",$button); 
				?>	
				<?php
				$button=array('cancelHide','showGalForm');
				echo Modules::run("common/loadButtons",$button); 
				?>	
			</div>
	</div>
			
			
	</div>
	<div class="seprator_27 cell"></div>
</div>

	<?php
		echo form_close();
	?>
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
		
	//alert(document.postMediaGalleryForm.submit.value);
	window.onbeforeunload = function() {
		
		if(ua.msie){ 
			if(needToConfirm == true){
				if (needToConfirm && document.postMediaGalleryForm.submit.value!='Save')
				{
					return "Do you want to save the modification before leaving the page.";
				} 
			}
		  }
		  else
		  {
			if (needToConfirm && document.postMediaGalleryForm.submit.value!='Save')
			{
				return "Do you want to save the modification before leaving the page.";
			}
			else return null;	
		 }		
	}
		

	$('#BrowserHidden').bind('change', function() {
	
		var ext = $('#FileField').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
		{
			alert('Only gif,png,jpg,jpeg extensions are allowed');
			$('#BrowserHidden').attr({ value: '' }); 
			$('#FileField').attr({ value: '' }); 
		}
		
	});	

});

function canceltoggle(toggleFlag)
{
 
  if(toggleFlag==0)
  {
	var new_img_src = baseUrl+'images/no_images.jpg';
	$('#galImage').attr('src',new_img_src);
	$('#postGalleryId').val(0);
	$('#fileInput').val('');
	$('#galTitle').val('');
	$('#galAltText').val('');
	$('#showGalForm').hide();
	
  }
  
  if(toggleFlag ==1)
  {
	var new_img_src = baseUrl+'images/no_images.jpg';
	$('#galImage').attr('src',new_img_src);
	$('#postGalleryId').val(0);
	$('#fileInput').val('');
	$('#galTitle').val('');
	$('#galAltText').val('');
	$('#showGalForm').show();
	
  }
  
}
function submitform()
{
    window.onbeforeunload = null;
	document.postMediaGalleryForm.save.value= 'Save'; 
	document.postMediaGalleryForm.submit();  
}
</script>
