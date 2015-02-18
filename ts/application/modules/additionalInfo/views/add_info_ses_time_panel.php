<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php 
	$totalSessions= (isset($totalSessions) && is_numeric($totalSessions))?$totalSessions:0;
	$sessionId= (isset($sessionId) && is_numeric($sessionId))?$sessionId:0;
	$currentMethod = $this->router->method; //If method is launch will not show the list of session as only one session is allowed with launch event 
	$toggle_icon = 'toggle_icon';
	
	if($totalSessions==0 || $sessionId >0){
			$dn='';
	}else{
		$dn='dn';
	}
	//$eventUrl['indexUrl'] = site_url(lang()).'/event/'.$this->router->method.'/index/'.$eventId;
	/*Set index url*/
	switch($currentMethod){
		case 'events':
		$indexTitle = 'Events';
		$indexUrl = site_url(lang()).'/event/'.$this->router->method.'/eventdetail/'.$eventId;
		break;
		case 'launch':
		$indexTitle = 'Launch';
		$indexUrl = site_url(lang()).'/event/'.$this->router->method.'/launchdetail/'.$launchEventId;
		break;
		case 'launchwithevent':
		$indexTitle = 'Events with Launch';
		$indexUrl = site_url(lang()).'/event/'.$this->router->method.'/eventwithlaunchdetail/'.$eventId;
		break;
		case 'eventwithlaunch':
		$indexTitle = 'Events with Launch';
		$indexUrl = site_url(lang()).'/event/'.$this->router->method.'/eventwithlaunchdetail/'.$eventId;
		break;
		default:
		$indexTitle = '';
	}
?>
<div class="row form_wrapper">	
	<div class="row">
		<div class="cell frm_heading">
			<?php 
			 if(isset($launchEventId) && $launchEventId>0) { echo '<h1>'.$label['launchSession'].'</h1>';  } 
			 else { echo '<h1>'.$label['eventSession'].'</h1>'; } 
			 ?>
		</div>
<!------- Top Most Menu Buttons ------->   
	<?php 

	$navArray['NatureId'] = $eventNatureId;
	$navArray['EventId'] = (isset($eventId) && @$eventId!='')?$eventId:0;

	echo Modules::run("event/menuNavigation",$navArray);

	?> 
	<!------ End Of Top Menu -------> 
	<?php if($currentMethod == 'launchwithevent' || $currentMethod == 'launch') { ?>
	 <div class="row height24">
		<div class="cell bg_none">
			&nbsp;
		</div>
		<div class="fr mr20 font_opensans">	
			<div class="fr orange f12 "><?php echo $this->lang->line('previewPublishIndex');?> <a class="underline orgGreyonHover" href="<?php echo $indexUrl;?>"> <?php echo $indexTitle.$this->lang->line('indexPage');?></a></div>
		</div>
	</div>
	<?php }?>


	</div>
   <!--<div class="seprator_27 row"></div>-->
 
<?php 
//Show the toggle if event

if(strcmp($currentMethod,'launch')!=0 && strcmp($currentMethod,'launchwithevent')!=0){?>

	<div class="row">
		<div class="cell tab_left">
			<div class="tab_heading">
				<?php if(isset($launchEventId) && $launchEventId>0) { echo $label['launchSession'];  } 
				 else { echo $label['eventSession']; }  ?>
			</div><!--tab_heading-->
		</div>
		<div class="cell tab_right">
			<div class="tab_btn_wrapper">
				<div class="tds-button-top"> 
					<!-- Post add Icon -->
					<a class="formTip formToggleIcon" title="<?php echo $label['add'];?>" toggleDivId="SESSIONTIME-Content-Box" toggleDivForm="SESSIONTIMEForm-Content-Box" >
						<span><div class="projectAddIcon"></div></span>
					</a>
					
				</div>
			</div>
		</div>
	</div><!--row-->
	<div class="clear"></div>
	<div class="form_wrapper toggle frm_strip_bg " >
	<div class="row"><div class="tab_shadow"></div></div>

	<!-- Set Index page line-->
	<?php if(!empty($indexTitle)){ ?>
	<div class="row height24">
		<div class="cell bg_none">
			&nbsp;
		</div>
		<div class="fr mr20 font_opensans">	
			<div class="fr orange f12  pb10"><?php echo $this->lang->line('previewPublishIndex');?> <a class="underline orgGreyonHover" href="<?php echo $indexUrl;?>"> <?php echo $indexTitle.$this->lang->line('indexPage');?></a></div>
		</div>
	</div>
	<?php }?>
	<!-- Set Index page line-->

	<div id="SESSIONTIME-Content-Box">
	<?php 
}
else {
	$dn = '';
	$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right right_580'));
	echo '<div class="form_wrapper toggle ">';
}
  
	$addSessionSttributes = '';
	foreach ($masterTickets as $i => $masterTicketsObj) {
		$addSessionSttributes .= ' ticketId'.$masterTicketsObj->TicketCategoryId.' = ""';
		$addSessionSttributes .= ' ticket'.$masterTicketsObj->TicketCategoryId.' = ""';
		$addSessionSttributes .= ' price'.$masterTicketsObj->TicketCategoryId.' = ""';
		$addSessionSttributes .= ' PriceScheduleId'.$masterTicketsObj->TicketCategoryId.' = ""';
		
		$addSessionSttributes .= ' speStartDate'.$masterTicketsObj->TicketCategoryId.' = ""';
		$addSessionSttributes .= ' speStartPrice'.$masterTicketsObj->TicketCategoryId.' = ""';
	
		$addSessionSttributes .= ' speEndDate'.$masterTicketsObj->TicketCategoryId.' = ""';
		$addSessionSttributes .= ' speEndPrice'.$masterTicketsObj->TicketCategoryId.' = ""';
	}
	//echo $addSessionSttributes;
	//echo anchor('javascript://void(0);', '<span><div class="projectAddIcon"></div></span>',array('class'=>'formTip','title'=>$label['add'],'onclick'=>'showSesTimeForm(\'SESSIONTIMEForm-Content-Box\',\'SESSIONTIME-No-Records\',\'SessionId\');$(\'#SESSIONTIME-Content-Box\').show();'));

$maxSessions = $this->config->item('maxSessions');
if($totalSessions <= $maxSessions){ ?>
	<div id="SESSIONTIMEForm-Content-Box" class="row <?php echo $dn;?>">
		<?php echo Modules::run("additionalInfo/sesTimeForm",$entityId,$elementId,$returnUrl,$entityType,$launchEventEntity,$launchEventId); ?>
	</div><!-- End Div SESSIONTIMEForm-Content-Box -->	
	<?php 
} //End Max Session

//If method is launch will not show the list of session as only one session is allowed with launch event 
if(strcmp($currentMethod,'launch')!=0 && strcmp($currentMethod,'launchwithevent')!=0){
	echo '</div><!-- End Div "SESSIONTIME-Content-Box"-->';
	?>
	<div id="SESSIONTIME-Content">		
		<div class="row">
		<!-- Show List Of SESSIONTIME -->
			<?php echo Modules::run("additionalInfo/listSesTime",$entityId,$elementId,$returnUrl,$entityType,$launchEventEntity,$launchEventId); ?> 
		</div><!-- END row -->
	</div><!-- End Div "SESSIONTIME-Content"-->

<?php 
} //End if(strcmp($currentMethod,'launch')==0) 

?>
<div class="clear"></div>
<?php
//If method is launch will not show the list of session as only one session is allowed with launch event 
if(strcmp($currentMethod,'launch')!=0 && strcmp($currentMethod,'launchwithevent')!=0){
	echo '<div class="row"><div class="tab_shadow"></div></div>';
	$popupSection='event';
	$eventUrl['descriptionUrl'] =  site_url(lang()).'/event/'.$this->router->method.'/eventFurtherDesc/'.$eventId;
	$eventUrl['prMaterialUrl'] =  site_url(lang()).'/event/'.$this->router->method.'/eventprmaterial/'.$eventId;
}
else{	
	$popupSection='launch';
	$eventUrl['descriptionUrl'] =  site_url(lang()).'/event/'.$this->router->method.'/launchpromomaterial/'.$launchEventId;
	$eventUrl['prMaterialUrl'] =  site_url(lang()).'/event/'.$this->router->method.'/launchprmaterial/'.$launchEventId;
}

?>
</div> <!-- row form_wrapper toggle-->




</div> <!-- row form_wrapper -->

<?php 
		$isShowEventPopup=$this->session->userdata('isShowEventPopup');
		
		if(isset($isShowEventPopup) && $isShowEventPopup==1 && $totalSessions==1 && $eventCountResult==1){
		
		$this->session->unset_userdata('isShowEventPopup');
		
		$eventUrl['indexUrl'] = site_url(lang()).'/event/'.$this->router->method.'/index';
		$eventUrl['popupSection'] = $popupSection;
		$popup_media = $this->load->view('common/afterSavePopup',$eventUrl,true);
		?>
	    <script>
			var popup_media = <?php echo json_encode($popup_media);?>;
			loadPopupData('popupBoxWp','popup_box',popup_media);
		</script>
		<?php
	}
	?>	
<script language="javascript" type="text/javascript">
	
//To make div unhide onclick on addIcon
function showSesTimeForm(showDiv,hideDiv,fieldId){

	document.getElementById(showDiv).style.display = 'block';

	if(document.getElementById(hideDiv))
		document.getElementById(hideDiv).style.display = 'none';

	document.getElementById(fieldId).value = 0;
	<?php
	foreach ($masterTickets as $i => $masterTicketsObj) {
	?>
			
		$('#<?php echo 'ticketId'.$masterTicketsObj->TicketCategoryId;?>').val(0);
		
		$('#<?php echo 'PriceScheduleId'.$masterTicketsObj->TicketCategoryId;?>').val(0);			
		
		$('#<?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>').val('');		
		
		$('#<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>').val('');		
		
		$('#<?php echo 'speStartDate'.$masterTicketsObj->TicketCategoryId;?>').val('');		
		
		$('#<?php echo 'speStartPrice'.$masterTicketsObj->TicketCategoryId;?>').val('');		
		
		$('#<?php echo 'speEndDate'.$masterTicketsObj->TicketCategoryId;?>').val('');		
		
		$('#<?php echo 'speEndPrice'.$masterTicketsObj->TicketCategoryId;?>').val('');
		
	<?php
	}
	?>
	$('#sessiondate').val('');
	$('#endhour').val(0);
	$('#starthour').val(0);
	$('#startmin').val(0);
	$('#endmin').val(0);
	$('#sessionendTime').val('');
	$('#sessionTitle').val('');
	$('#venueEmail').val('');
	$('#phoneNumber').val('');
	$('#sessionTitle').val('');
	$('#sessionaddress').val('');
	$('#sessioncity').val('');
	$('#sessionstate').val('');
	$('#country').val('');
	$('#sessionzip').val('');
	$('#sessionurl').val('');	
	$('#sessionId').val(0);
}

//Function called on cancel button of form
function commonCancel(formId,norecord){
//alert(formId);
//$('#'+formId).toggle();
$('#sessiondate').attr('dateGreaterThan','#currentDate');
	if($('#'+formId).is(':visible')) $('#'+formId).hide();
	else $('#'+formId).show();
if($('#'+norecord).length > 0)
	$('#'+norecord).show();
	
	al

$('html,body').animate({scrollTop:'200px'}, 'fast');
}

//if($('#sessionId').val()==0) $('#SESSIONTIMEForm-Content-Box').addClass('dn'); 
</script>
