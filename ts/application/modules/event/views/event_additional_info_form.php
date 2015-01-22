<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

//Variables for social media links
$formAttributes = array(
	'name'=>'eventaddinfoform',
	'id'=>'eventaddinfoform'
);

?>
<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $label['additionalInformation'];?></h1>
		</div>
		<!------- Top Most Menu Buttons ------->   
		<?php echo Modules::run("event/menuNavigation",$eventNatureId);

		 ?> 
		<!------ End Of Top Menu -------> 
	</div> <!--row -->

<!--listBoxWp START-->

<div id="listBoxWp" class="customAlert" style="display:none; width:800px; padding:19px 5px 19px 19px; height:auto; border:1px solid #999999; background-color:#FFFFFF;">
	<div id="close-listBox" title="" class="tip-tr close-customAlert"></div><!-- We have to define "id" in lightboxme-common.js -->
	<div class="listFormContainer" id="listFormContainer"></div>
</div>


<?php //echo Modules::run("additionalInfo/addInfoNewsPanel",$tableId,$eventId,$this->uri->uri_string()); ?> 

<?php //echo Modules::run("additionalInfo/addInfoReviewsPanel",$tableId,$eventId,$this->uri->uri_string()); ?> 

<?php //echo Modules::run("additionalInfo/addInfoInterviewsPanel",$tableId,$eventId,$this->uri->uri_string()); ?> 

<?php //echo Modules::run("additionalInfo/addInfoAssociatedMediaPanel",$tableId,$eventId,$this->uri->uri_string()); ?>

<?php /*
		  <div class="row">
		  <div class="cell">
			  <div class="Btn_wp">
			  <div class="btn_wp" style="padding-left:145px;">
				<div class="button_left">
				  <div class="button_right">
					<div class="button_text save" onclick="submitForm('SocialNetworking');">
						<?php echo form_submit('submit', 'Save', ' class="border0 backgroundNone white bold"'); ?>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		</div><!-- End class="cell" -->
		</div><!-- End Class="row" -->
		* */?>


<script language="javascript" type="text/javascript">

//To make div unhide onclick on addIcon
function showRelatedForm(showDiv,hideDiv){

document.getElementById(showDiv).style.display = 'block';
if(document.getElementById(hideDiv))
	document.getElementById(hideDiv).style.display = 'none';

}
function submitForm(saveType)
{ 
	if(saveType == 'News'){
		document.newsForm.formtype.value = saveType;
		document.newsForm.submit(); 
	} 
	
	if(saveType == 'Reviews'){
		document.reviewsForm.formtype.value = saveType;
		document.reviewsForm.submit(); 
	}	
}

</script>
