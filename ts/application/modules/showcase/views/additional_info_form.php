<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
//Variables for social media links
$socialFormAttributes = array(
	'name'=>'socialForm',
	'id'=>'socialForm'
);
$socialLink = array(
	'name'	=> 'socialLink',
	'id'	=> 'socialLink',
	'value'	=> '',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr4',
	'title'       =>  $label['socialLink'],
	'style' =>'width:461px;'
);

$socialLinkType = array(
	'name'	=> 'socialLinkType',
	'value'	=> set_value('socialLinkType'),
	'id'	=> 'socialLinkType',
	'class'       => 'formTip Bdr4',
	'title' =>  $label['socialLinkType'],
);
$optionsSocialLinkType = array(
	'' => 'Select Option',
	'1' => 'Toad Square',
	'2' => 'Facebook',
	'3' => 'Twitter',
	'4' => 'Linkedin',
	'5' => 'Other'	 
);

if(isset($recordId)) $showcaseId = $recordId;
else $showcaseId = 0;

echo Modules::run("showcase/menuNavigation", $showcaseId);
?>
<!------ End Of Top Menu -------> 
<!--listBoxWp START-->

<div id="listBoxWp" class="customAlert" style="display:none; width:800px; padding:19px 5px 19px 19px; height:auto; border:1px solid #999999; background-color:#FFFFFF;">
	<div id="close-listBox" title="Close it" class="tip-tr close-customAlert"></div><!-- We have to define "id" in lightboxme-common.js -->
	<div class="listFormContainer" id="listFormContainer"></div>
</div>

<!--listBoxWp END-->
<?php  echo Modules::run("additionalInfo/addInfoNewsPanel",$tableId,$recordId,$this->uri->uri_string()); ?> 

<?php echo Modules::run("additionalInfo/addInfoReviewsPanel",$tableId,$recordId,$this->uri->uri_string()); ?> 

<div class="row">
<div class="cell" style="width:100%;">
	<div class="title-content">
	<div class="title-content-left">
	<div class="title-content-right">
	<div class="title-content-center"  onmouseover="this.style.cursor='pointer'">
	<div class="title-content-center-label"><?php echo $label['EVENTS']; ?></div>
	
	<div class="toggleAdditionalInfo" toggleDivId="EVENTS-Content-Box" toggleDivRecords="EVENTS-No-Records" toggleDivForm="EVENTSForm-Content-Box"   align="right">
	<img src="<?php echo base_url();?>images/icons/down_arrow.png" border="0" class="formTip" title="<?php echo $label['EVENTS']; ?>"/></div>
	
	
	</div><!-- End class="title-content-center" -->
	</div><!-- End class="title-content-right" -->
	</div><!-- End class="title-content-left" -->
	</div><!-- End class="title-content" -->
</div>
<div id="EVENTS-Content-Box" style="display:none;">
<div id="EVENTSForm-Content-Box"  style="display:none;">
<?php echo Modules::run("showcase/eventForm"); ?>   
</div><!-- End Div EVENTSForm-Content-Box -->	
<!-- Show List Of EVENTS -->
<?php echo Modules::run("showcase/eventsList"); ?> 
</div>
</div><!-- End class="row" -->
<div class="row">
<div class="cell" style="width:100%;">
	<div class="title-content">
	<div class="title-content-left">
	<div class="title-content-right">
	<div class="title-content-center"  onmouseover="this.style.cursor='pointer'">
	<div class="title-content-center-label"><?php echo $label['WORK']; ?></div>
	
	<div class="toggleAdditionalInfo" toggleDivId="WORKS-Content-Box" toggleDivRecords="WORKS-No-Records" toggleDivForm="WORKSForm-Content-Box"   align="right">
	<img src="<?php echo base_url();?>images/icons/down_arrow.png" border="0" class="formTip" title="<?php echo $label['WORK']; ?>"/></div>	
	</div><!-- End class="title-content-center" -->
	</div><!-- End class="title-content-right" -->
	</div><!-- End class="title-content-left" -->
	</div><!-- End class="title-content" -->
</div>
<div id="WORKS-Content-Box" style="display:none;">
<div id="WORKSForm-Content-Box"  style="display:none;">
<?php echo Modules::run("showcase/workForm"); ?>   
</div><!-- End Div WORKSForm-Content-Box -->	
<!-- Show List Of WORK -->
<?php echo Modules::run("showcase/worksList"); ?>
</div>
</div><!-- End class="row" -->

<div class="row">
<div class="cell" style="width:100%;">
	<div class="title-content">
	<div class="title-content-left">
	<div class="title-content-right">
	<div class="title-content-center"  onmouseover="this.style.cursor='pointer'">
	<div class="title-content-center-label"><?php echo $label['PRODUCTS']; ?></div>
	
	<div class="toggleAdditionalInfo" toggleDivId="PRODUCTS-Content-Box" toggleDivRecords="PRODUCTS-No-Records" toggleDivForm="PRODUCTSForm-Content-Box" align="right">
	<img src="<?php echo base_url();?>images/icons/down_arrow.png" border="0" class="formTip" title="<?php echo $label['PRODUCTS']; ?>"/></div>
	
	
	</div><!-- End class="title-content-center" -->
	</div><!-- End class="title-content-right" -->
	</div><!-- End class="title-content-left" -->
	</div><!-- End class="title-content" -->
</div>
<div id="PRODUCTS-Content-Box" style="display:none;">
<div id="PRODUCTSForm-Content-Box"  style="display:none;">
<?php echo Modules::run("showcase/productForm"); ?>   
</div><!-- End Div PRODUCTSForm-Content-Box -->

<!-- Show List Of PRODUCTS -->
<?php echo Modules::run("showcase/productsList"); ?> </div>
</div><!-- End class="row" -->
	
<div class="row">
<div class="cell" style="width:100%;">
	<div class="title-content">
	<div class="title-content-left">
	<div class="title-content-right">
	<div class="title-content-center"  onmouseover="this.style.cursor='pointer'">
	<div class="title-content-center-label"><?php echo $label['FORUM']; ?></div>
	
	<div class="toggleAdditionalInfo" toggleDivId="FORUMS-Content-Box" toggleDivRecords="FORUMS-No-Records" toggleDivForm="FORUMSForm-Content-Box"  align="right">
	<img src="<?php echo base_url();?>images/icons/down_arrow.png" border="0" class="formTip" title="<?php echo $label['FORUM']; ?>" />
	</div>	
	
	</div><!-- End class="title-content-center" -->
	</div><!-- End class="title-content-right" -->
	</div><!-- End class="title-content-left" -->
	</div><!-- End class="title-content" -->
</div>
<div id="FORUMS-Content-Box" style="display:none;">
<div id="FORUMSForm-Content-Box"  style="display:none;">
<?php echo Modules::run("showcase/forumForm"); ?>   
</div><!-- End Div WORKSForm-Content-Box -->
<!-- Show List Of PRODUCTS -->
<?php echo Modules::run("showcase/forumsList"); ?> 
</div>
</div><!-- End class="row" -->
<script language="javascript" type="text/javascript">
function showAwardsRelatedForm(showDiv,hideDiv,titleValue,url,publishDate,description,fieldId)
{
document.getElementById(showDiv).style.display = 'block';

if(document.getElementById(hideDiv))
document.getElementById(hideDiv).style.display = 'none';

document.getElementById(titleValue).value = '';

document.getElementById(url).value = '';

document.getElementById(publishDate).value = '';

document.getElementById(description).value = '';

document.getElementById(fieldId).value = 0;
}

function showSocialRelatedForm(showDiv,hideDiv,socialtype,sociallink,fieldId)
{
document.getElementById(showDiv).style.display = 'block';

if(document.getElementById(hideDiv))
document.getElementById(hideDiv).style.display = 'none';

document.getElementById(sociallink).value = '';

$('#'+socialtype).parent().find('.abc').text('Select Media Icon');

document.getElementById(socialtype).value = 0;

document.getElementById(fieldId).value = 0;
}

//To make div unhide onclick on addIcon
function showRelatedForm(showDiv,hideDiv,titleValue,writerName,langValue,publishDate,showDivEmbed,embbededVideo,embbededURL,fieldId){
//alert(showDiv);
document.getElementById(showDiv).style.display = 'block';
if(document.getElementById(hideDiv))
document.getElementById(hideDiv).style.display = 'none';

document.getElementById(titleValue).value = '';

document.getElementById(writerName).value = '';

$('#'+langValue).parent().find('.abc').text('Select Language');

document.getElementById(langValue).value = '';

document.getElementById(publishDate).value = '';

document.getElementById(embbededVideo).value = '';

document.getElementById(embbededURL).value = '';

document.getElementById(fieldId).value = 0;

document.getElementById(showDivEmbed).style.display = 'block';
}

$(document).ready(function(){

  $(".radio").click(function(){

  var radio_id = $(this).attr('id');
  var radio_name= $(this).attr('name');
  
  if(radio_name == 'news'){
  var showVideoDiv = 'showNewsVideo';
  var showURLDiv = 'showNewsURL';
  }
  
  if(radio_name == 'reviews'){
  var showVideoDiv = 'showReviewVideoUpload';	 
  var showURLDiv = 'showReviewEmbbededURL';
  }
  
  if(radio_id=='video') {
    $("#"+showVideoDiv).show();
     $("#"+showURLDiv).hide();
  }
  else if(radio_id=='url') {
   $("#"+showURLDiv).show();
    $("#"+showVideoDiv).hide();
   }
  });
		
		
			
});

//Function called on cancel button of form
function commonCancel(formId,norecord){
//alert(formId);
//$('#'+formId).toggle();
	if($('#'+formId).is(':visible')) $('#'+formId).hide();
		else $('#'+formId).show();
if($('#'+norecord).length > 0)
	$('#'+norecord).show();
	
$('html, body').animate({scrollTop:'200px'}, 'fast');
}
</script>

<script language="javascript" type="text/javascript">
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
	
	if(saveType == 'Awards'){
		document.awardsForm.formtype.value = saveType;
		document.awardsForm.submit(); 
	}
	
	if(saveType == 'Events'){
		document.eventsForm.formtype.value = saveType;
		document.eventsForm.submit(); 
	}
	if(saveType == 'SocialNetworking'){
		document.socialForm.formtype.value = saveType;
		document.socialForm.submit(); 
	}
	
}

</script>
