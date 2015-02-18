<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<?php

$action = $this->router->class.'/'.$this->router->method;
$formAttributes = array(
	'name'=>'eventNotificationForm',
	'id'=>'EventEditForm',
	'section' => '#EventEdit',
	'toggleDivForm' =>'Events-Content-Box'
);

$eventPromoCompanyName = array(
	'name'	=> 'CompanyName',
	'id'	=> 'CompanyName',
	'class'	=> 'width556px formTip required ',
	'value'	=> $data['CompanyName'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$eventDescription = array(
	'name'	=> 'Description',
	'id'	=> 'Description',
	'class'	=> 'width556px rz  required ',
	'value'	=> $data['Description'],
	'wordlength'=>"50,100",
	'onkeyup'=>"checkWordLen(this,100,'eventdescriptionLimit')",
	'rows'	=> 3
);

$promotionalVideo = array(
	'name'	=> 'promotionalVideo',
	'id'	=> 'promotionalVideo',
	'class'	=> 'width556px  required error',
	'value'	=> set_value('promotionalVideo'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$linkFacebook = array(
	'name'	=> 'linkFacebook',
	'id'	=> 'linkFacebook',
	'class'	=> 'width556px  required error',
	'value'	=> set_value('linkFacebook'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$creativeInvolved = array(
	'name'	=> 'creativeInvolved',
	'id'	=> 'creativeInvolved',
	'class'	=> 'width556px  required error',
	'value'	=> set_value('creativeInvolved'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$showProfileImage = '';
?>

<div class="row form_wrapper">
	
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $this->lang->line('promotionalMaterial');?></h1>
		</div>
<!------- Top Most Menu Buttons ------->   
  <?php 
	$navArray['NatureId'] = $eventNatureId;
	$navArray['EventId'] = (isset($data['EventId']) && is_numeric($data['EventId']) )?$data['EventId']:0;
	$navArray['LaunchEventId'] = (isset($data['LaunchEventId']) && is_numeric($data['LaunchEventId']) )?$data['LaunchEventId']:0;
	$navArray['currentMathod'] = 'eventFurtherDesc';
	echo Modules::run("event/menuNavigation",$navArray);
 ?> 
 
<!------ End Of Top Menu -------> 

	</div> <!--row -->

<?php
if(isset($data['EventId']) || $data['EventId'] !='' || $data['EventId'] !=0)
{ 
	
	$eventPromotionalImages['strip']=1;
	echo $this->load->view('mediatheme/promoImgAccordView',$eventPromotionalImages);
} //end if EventId is set to some existing Id 
?>
</div><!--row form_wrapper-->


<script language="javascript" type="text/javascript">
function showRelatedForm(showDiv,hideDiv,titleValue,mediaId,BrowserHiddenPromo,PromoFileField,PromoDesc){
	//alert(showDiv);
	document.getElementById(showDiv).style.display = 'block';
	if(document.getElementById(hideDiv))
	document.getElementById(hideDiv).style.display = 'none';
	document.getElementById(mediaId).value = 0;
	document.getElementById(titleValue).value = '';
	document.getElementById(BrowserHiddenPromo).value = '';
	document.getElementById(PromoFileField).value = '';
	document.getElementById(PromoDesc).value = '';
	$('#currentPromotionalImage').attr('src',baseUrl+'images/no_images.jpg');
}

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
function submitMainForm(saveType)
{
	if(saveType == 'mainEvent'){
		document.eventNotificationForm.formtype.value = saveType;	
		document.eventNotificationForm.submit(); 
	} 
}


$(document).ready(function()
{	
	$('#BrowserHidden').bind('change', function() {
	
		var ext = $('#FileField').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
		{
			alert('Only gif,png,jpg,jpeg extensions are allowed');
			$('#BrowserHidden').attr({ value: '' }); 
			$('#FileField').attr({ value: '' }); 
		}		
	});
	
	
	$(".cancel").click(function(){
		    var toggleDivForm = $(this).closest("form").attr('toggleDivForm');
			var toggleDivId = $(this).closest("form").attr('id');
			var section =$(this).closest("form").attr('section');
			
			$("#"+toggleDivId)[0].reset();	
					
			$("#"+toggleDivForm).slideToggle('slow');
		});
	
	
	// Show Promo image form in event session
	
	$(".GalId").click(function(){			
			
			$("#EventPromoForm-Content-Box").show();			
		});
		
	
	
	
	$('.projectToggle').click(function(){
		
		if($(this).css("background-position")=='-1px -121px'){
			$(this).css("background-position","-1px -144px")
			
		}else{
			$(this).css("background-position","-1px -121px");
		}		
			
		    $('#Events-Content-Box').slideToggle(1700);
		
	}); 
	
	
});
</script>
