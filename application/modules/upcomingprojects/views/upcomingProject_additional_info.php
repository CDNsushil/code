<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

//Variables for social media links
$socialFormAttributes = array(
	'name'=>'socialForm',
	'id'=>'socialForm'
);

?>

<!------- Top Most Menu Buttons ------->   
<?php echo $header;?>
<!------ End Of Top Menu -------> 
<!--listBoxWp START-->

<div id="listBoxWp" class="customAlert" style="display:none; width:800px; padding:19px 5px 19px 19px; height:auto; border:1px solid #999999; background-color:#FFFFFF;">
	<div id="close-listBox" title="" class="tip-tr close-customAlert"></div><!-- We have to define "id" in lightboxme-common.js -->
	<div class="listFormContainer" id="listFormContainer"></div>
</div>


<?php echo Modules::run("additionalInfo/addInfoNewsPanel",$tableId,$recordId,$this->uri->uri_string()); ?> 

<?php echo Modules::run("additionalInfo/addInfoReviewsPanel",$tableId,$recordId,$this->uri->uri_string()); ?> 

<?php echo Modules::run("additionalInfo/addInfoInterviewsPanel",$tableId,$recordId,$this->uri->uri_string()); ?> 

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
<?php echo Modules::run("upcomingprojects/eventForm"); ?>   
</div><!-- End Div EVENTSForm-Content-Box -->	
<!-- Show List Of EVENTS -->
<?php echo Modules::run("upcomingprojects/eventsList"); ?> 
</div>
</div><!-- End class="row" -->
<?php /*
<div class="row">
<div class="cell" style="width:100%;">
	<div class="title-content">
	<div class="title-content-left">
	<div class="title-content-right">
	<div class="title-content-center"  onmouseover="this.style.cursor='pointer'" >
	<div class="title-content-center-label"><?php echo $label['ASSOCIATEDMEDIAS']; ?></div>
	<div class="tds-button-top"> 
	<?php 
		echo anchor('javascript://void(0);', '<span><div class="projectAddIcon"></div></span>',array('class'=>'formTip','title'=>$label['add'],'onclick'=>'showRelatedForm(\'ASSOCIATEDMEDIAS-Content-Box\',\'ASSOCIATEDMEDIASForm-Content-Box\',\'ASSOCIATEDMEDIAS-No-Records\',\'title\',\'writerName\',\'newsLanguage\',\'publishDate\',\'newsEmbedDIv\',\'newsEmbbededVideo\',\'newsEmbbededURL\',\'showcaseNewsId\');$(\'#ASSOCIATEDMEDIAS-Content-Box\').show();'));
	?>
	</div>
	<div class="toggleAdditionalInfo" toggleDivId="ASSOCIATEDMEDIAS-Content-Box"  toggleDivRecords="ASSOCIATEDMEDIAS-No-Records" toggleDivForm="ASSOCIATEDMEDIASForm-Content-Box"  align="right">
	<img src="<?php echo base_url();?>images/icons/down_arrow.png" border="0" class="formTip" title="<?php echo $label['ASSOCIATEDMEDIAS']; ?>"/>
	</div>	
	</div><!-- End class="title-content-center" -->
	</div><!-- End class="title-content-right" -->
	</div><!-- End class="title-content-left" -->
	</div><!-- End class="title-content" -->
</div> 

<div id="ASSOCIATEDMEDIAS-Content-Box"  <?php echo $interviewDisplayStyle;?>>

<div id="ASSOCIATEDMEDIASForm-Content-Box" >
<?php echo Modules::run("event/associatedMediaForm"); ?>
</div><!-- End Div ASSOCIATEDMEDIASForm-Content-Box -->	

<!-- Show List Of ASSOCIATEDMEDIAS -->
<?php echo Modules::run("event/associatedMediasList"); ?> 
<div>

</div><!-- End Div "ASSOCIATEDMEDIASForm-Content-Box" -->

</div><!-- End Div "ASSOCIATEDMEDIAS-Content-Box"-->
</div><!-- End class="row" -->
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
*/?>


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
</script>
