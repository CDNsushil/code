<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$seller_currency=LoginUserDetails('seller_currency');
$seller_currency=($seller_currency>0)?$seller_currency:0;
$currencySign=$this->config->item('currency'.$seller_currency);
$countRecord =  count($sesTimes)-1;
//check if any session exits or not

//Variables for news form

$section='event';
if($moduleMethod=='launchsession'){
	$projectId=$launchEventId;
}else{
	$projectId=$eventId;
}
$isesTimesFormAttributes = array(
	'name'=>'sesTimesListForm',
	'id'=>'sesTimesListForm'
);
$currentId = array(
	'name'=>'currentId',
	'id'=>'sessioncurrentId',        
	'type'=>'hidden'
);
$swapId = array(
	'name'=>'swapId',
	'id'=>'sessionswapId',
	'type'=>'hidden'
);
$currentPosition = array(
	'name'=>'currentPosition',
	'id'=>'sessioncurrentPosition',
	'type'=>'hidden'
);
$swapPosition = array(
	'name'=>'swapPosition',
	'id'=>'sessionswapPosition',
	'type'=>'hidden'
);

$sessionIdForSwap = array(
	'name'=>'sessionIdForSwap',
	'id'=>'sessionIdForSwap',
	'type'=>'hidden'
);
$sessionIdForDelete = array(
	'name'=>'sessionIdForDelete',
	'id'=>'sessionIdForDelete',
	'type'=>'hidden'
);

if(count($sesTimes)>0){
?>
<!--<div class="row seprator_27"></div>-->
<div class="label_wrapper cell bg_none">
</div><!--label_wrapper-->
<div class="small_frm_wp">
<?php
	echo form_open('additionalInfo/shiftSessionTime',$isesTimesFormAttributes);
	echo form_input($sessionIdForDelete);	
	echo form_input($sessionIdForSwap);
	echo form_input($currentId);	
	echo form_input($swapId);
	echo form_input($currentPosition);
	echo form_input($swapPosition);

	
	$isesTimes = 0; 

	?>
	<input type="hidden" value="<?php echo $returnUrl;?>" name="returnUrl" id="returnUrl" />
	<div class="row">
	<div class="cell orng_left minMaxWidth80 pl15"> <?php echo $label['eventDates']; ?></div>
	<div class="cell pr40">&nbsp;</div>
	<div class="cell orng_left width90px pl6"> <?php echo $label['eventStartTime']; ?></div>
	<div class="cell pr40">&nbsp;</div>
	<div class="cell orng_left minMaxWidth80 pl5" > <?php echo $label['eventEndTime']; ?></div>
	</div>
	<span class="clear_seprator"></span>
	<?php
	foreach($sesTimes as $k=>$sesTimesItem)
	{
	if(@$sesTimesItem->date!='') $sessionDate = date("d F Y", strtotime(substr(@$sesTimesItem->date,0,-9)));
	// $sessionDate = substr($sesTimesItem->date,0,-9);

	?>		
	<div class="row extract_content_bg_PR">
	<!--<div class="cell"><input id="NewsId" class="NewsId" value="<?php echo $sesTimesItem->sessionId;?>" type="checkbox" name="NewsId" /></div> -->
	<!--<div class="cell" style="padding-left:10px;">&nbsp;</div>-->
	<div class="cell title_small_frm  padding_left_20 width120px"><?php echo @$sessionDate; ?></h3></div>
	<div class="cell writer_name_small_frm width110px"><?php echo substr($sesTimesItem->startTime,0,-3);?></div>
	<div class="cell date_small_frm width110px"><?php 
	$sessionEndTime = substr($sesTimesItem->endTime,0,-3);
	echo ($sessionEndTime=='00:00')?'':$sessionEndTime;
	
	?></div> 
	<div class="cell" style="padding-left:10px;">&nbsp;</div>
	<div class="cell title-content title-content-right title-content-center tds-button-top">
	<?php
		
		$extraAttr = getSessionTimeAtt($sesTimesItem->sessionId);
		
		list($starthour, $startmin, $startsec) = explode(":", $sesTimesItem->startTime);
		
		if(substr($starthour,0,1) ==0) $starthour = substr($starthour,1);
		if(substr($startmin,0,1) ==0) $startmin = substr($startmin,1);
		
		list($endhour, $endmin, $endsec) = explode(":", $sesTimesItem->endTime);
		
		if(substr($endhour,0,1) ==0) $endhour = substr($endhour,1);
		if(substr($endmin,0,1) ==0) $endmin = substr($endmin,1);	
		
		$newStartTime = explode(":", $sesTimesItem->startTime,-1);
		$startime = $newStartTime[0].':'.$newStartTime[1];	
		
		$newEndTime = explode(":", $sesTimesItem->endTime,-1);
		$endtime = $newEndTime[0].':'.$newEndTime[1]; 
		
		$editArr = array('title'=>$label['edit'],
		'class'=>"formTip SessionId",
		'id'=>"SessionId", 
		'sessiondate'=>@$sessionDate, 
		'starttime'=> $startime, 
		'endtime'=> $endtime, 	
		'venueName'=> $sesTimesItem->venueName, 
		'address'=> $sesTimesItem->address, 
		'address2'=> $sesTimesItem->address2, 
		'city'=> $sesTimesItem->city, 
		'state'=> $sesTimesItem->state, 
		'venueEmail'=> $sesTimesItem->venueEmail,
		'phoneNumber'=> $sesTimesItem->phoneNumber,
		'zip'=> $sesTimesItem->zip,
		//'country'=> getLanguage($sesTimesItem->country), 
		'country'=> $sesTimesItem->country, 
		'url'=> $sesTimesItem->url, 
		'eventId'=> $sesTimesItem->eventId, 
		'launchEventId'=> $sesTimesItem->launchEventId, 
		'mySessionId'=>$sesTimesItem->sessionId,
		'eventSellstatus'=>$sesTimesItem->eventSellstatus,	
		'earlyBirdStatus'=>$sesTimesItem->earlyBirdStatus,
		'sessionTitle'=>$sesTimesItem->sessionTitle,
		'onclick'=>'removeStartDateAttr();'	
		);
		
		if(is_array($extraAttr)){
			$meregedEditAttr = array_merge($editArr,$extraAttr);
		}
		else
			$meregedEditAttr = $editArr;
		//echo '<pre />';print_r($meregedEditAttr);		
	?>		
	</div>

	<?php 
	if($showDelOption==0)
	{
			echo '<div class="cell pro_btns pt4 fr">';
						
			$duplicateSession = base_url('event/duplicatesession/'.$sesTimesItem->sessionId);
			$duplicateAttr = array('onmousedown'=>'mousedown_small_button(this)','onmouseup'=>'mouseup_small_button(this)');
			echo '<div class="small_btn_d fr">';			
				echo anchor($duplicateSession, '<span>Duplicate</span>',$duplicateAttr);	
			echo '</div>';
			
			echo '<div class="small_btn">';
				if($isesTimes != 0)
				{
					$moveUp = array('title'=>$label['moveDown'],'class'=>'formTip moveSession','sessioncurrentId'=>encode($sesTimesItem->sessionId),'sessionswapId'=>encode(@$sesTimes[$k-1]->sessionId),'sessioncurrentPosition'=>$sesTimesItem->position,'sessionswapPosition'=>@$sesTimes[$k-1]->position);
					echo anchor('javascript://void(0);', '<div class="smll_up_arrow_icon"></div>',$moveUp);
				}
				else
				{
					$moveUp = array('title'=>$label['notMovable'],'class'=>'formTip');
					echo anchor('javascript://void(0);', '<div class="smll_up_arrow_icon"></div>',$moveUp);
				}
			echo '</div>';
			
			echo '<div class="small_btn">';
				if($isesTimes != $countRecord)
				{
					$moveDown = array('title'=>$label['moveUp'],'class'=>'formTip moveSession','sessioncurrentId'=>encode($sesTimesItem->sessionId),'sessionswapId'=>encode(@$sesTimes[$k+1]->sessionId),'sessioncurrentPosition'=>$sesTimesItem->position,'sessionswapPosition'=>@$sesTimes[$k+1]->position);
					echo anchor('javascript://void(0);','<div class="smll_down_arrow_icon"></div>',$moveDown);
				}
				else
				{
					$moveDown = array('title'=>$label['notMovable'],'class'=>'formTip');
					echo anchor('javascript://void(0);','<div class="smll_down_arrow_icon"></div>',$moveDown);
				}
			echo '</div>';
				
			/*$attr = array("title"=>$label['delete']."",'class'=>'formTip delSess','myDelSessionId'=>encode($sesTimesItem->sessionId));
			
			echo '<div class="small_btn">';
				echo anchor('javascript://void(0);','<div class="cat_smll_plus_icon"></div>',$attr);
			echo '</div>';*/
			
			$deleteFunction="changeStatusAsDeleted('EventSessions','sessionId','".$sesTimesItem->sessionId."','".$section."','".$this->lang->line('sureDelMsg')."');";
				?> 
			<div class="small_btn"><a href="javascript:void(0);" class="formTip" onclick="<?php echo $deleteFunction;?>" title="<?php echo $this->lang->line('delete');?>"><div class="cat_smll_plus_icon"></div></a></div>
			<?php	
			
			echo '<div class="small_btn">';
				echo anchor('javascript://void(0);', '<div class="cat_smll_edit_icon"></div>',$meregedEditAttr);	
			echo '</div>';
			
				
		
		echo '</div>';
			
		}
	?>
<div class="clear"></div>
</div>
<?php
$isesTimes++;

//if the inserted seesion reached max value assigned in head.php then stop pracesssing further
if($isesTimes >= $this->config->item('maxSessions')) break;

echo '</form>';
}

?>
<div  class="row heightSpacer">&nbsp;</div>
<div class="fr mr20 pl20 pb10">
	<?php
	echo '<div>* '.$this->lang->line('noteMaxSession1').$this->config->item('maxSessions').$this->lang->line('noteMaxSession2').'</div>';
	echo '<div>'.$this->lang->line('noteMaxSession3').'</div>';
	?>
</div>
</div><!-- END cell frm_element_wrapper -->
<?php
}
else{
?>
	<div id="sessionNoRecords-Box">
		<div class="label_wrapper cell bg_none">
		
		</div><!--label_wrapper-->
		<div class=" pl20 cell frm_element_wrapper" id="sessionNoRecords">
				<?php //echo anchor('javascript://void(0);', $label['clickHere'].$label['associateElements'].'&nbsp;'.$label['NEWS'],array('class'=>'formTip','title'=>$label['NEWS'],'onclick'=>"$('#NEWSForm-Content-Box').show();"));?>
				<?php echo anchor('javascript://void(0);', $label['add'],array('class'=>'a_orange','onclick'=>"canceltoggle(1)"));?>
		</div>
	</div>
<?php
}
$entityIdSession=getMasterTableRecord('EventSessions')
?>

<script language="javascript" type="text/javascript">
$(document).ready(function() {

	$('.SessionId').click(function(){
		
		var date = $(this).attr('sessiondate');
		var venuename = $(this).attr('venuename');			
		var address = $(this).attr('address');
		var address2 = $(this).attr('address2');	
		var city = $(this).attr('city');
		var state = $(this).attr('state');
		var country = $(this).attr('country');
		var zip = $(this).attr('zip');
		var venueEmail = $(this).attr('venueEmail');
		var phoneNumber = $(this).attr('phoneNumber');
		var url = $(this).attr('url');
		var eventId = $(this).attr('eventId');
		var launchEventId = $(this).attr('launchEventId');
		var starthour = $(this).attr('starthour');
		var startmin = $(this).attr('startmin');
		var endhour = $(this).attr('endhour');
		var endmin = $(this).attr('endmin');
		var starttime = $(this).attr('starttime');
		var endtime = $(this).attr('endtime');			
		var endtime = $(this).attr('endtime');			
		var eventSellstatus = $(this).attr('eventSellstatus');			
		var earlyBirdStatus = $(this).attr('earlyBirdStatus');			
		var sessionTitle = $(this).attr('sessionTitle');			
		//alert('eventSellstatus:'+eventSellstatus);
		//var speendprice1 = $(this).attr('speendprice1');
		<?php
		foreach ($masterTickets as $i => $masterTicketsObj) {
			
		?>
		var <?php echo 'ticketId'.$masterTicketsObj->TicketCategoryId;?> = $(this).attr('<?php echo 'ticketId'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'ticketId'.$masterTicketsObj->TicketCategoryId;?>').val(<?php echo 'ticketId'.$masterTicketsObj->TicketCategoryId;?>);
		
		var <?php echo 'PriceScheduleId'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo 'PriceScheduleId'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'PriceScheduleId'.$masterTicketsObj->TicketCategoryId;?>').val(<?php echo 'PriceScheduleId'.$masterTicketsObj->TicketCategoryId;?>);
			
			
		var <?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>').val(<?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>);
		
		var <?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>').val(<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>);
		
		getDisplayPrice(<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>,'<?php echo $seller_currency;?>','#totalCommision<?php echo $masterTicketsObj->TicketCategoryId;?>','#displayPrice<?php echo $masterTicketsObj->TicketCategoryId;?>');
		
		var <?php echo 'speStartDate'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo'speStartDate'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'speStartDate'.$masterTicketsObj->TicketCategoryId;?>').val(<?php echo 'speStartDate'.$masterTicketsObj->TicketCategoryId;?>);
		
		
		var <?php echo 'speStartPrice'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo'speStartPrice'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'speStartPrice'.$masterTicketsObj->TicketCategoryId;?>').val(<?php echo 'speStartPrice'.$masterTicketsObj->TicketCategoryId;?>);
		getDisplayPrice(<?php echo 'speStartPrice'.$masterTicketsObj->TicketCategoryId;?>,'<?php echo $seller_currency;?>','#totalCommisionSP<?php echo $masterTicketsObj->TicketCategoryId;?>','#displayPriceSP<?php echo $masterTicketsObj->TicketCategoryId;?>');
		
		
		
		var <?php echo 'speEndDate'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo 'speEndDate'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'speEndDate'.$masterTicketsObj->TicketCategoryId;?>').val(<?php echo 'speEndDate'.$masterTicketsObj->TicketCategoryId;?>);
		
		
		var <?php echo 'speEndPrice'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo 'speEndPrice'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'speEndPrice'.$masterTicketsObj->TicketCategoryId;?>').val(<?php echo 'speEndPrice'.$masterTicketsObj->TicketCategoryId;?>);
		
		var <?php echo 'ticketCheckBox'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo 'ticketCheckBox'.$masterTicketsObj->TicketCategoryId;?>');
		if(<?php echo 'ticketCheckBox'.$masterTicketsObj->TicketCategoryId;?> == 1){
		$('#<?php echo 'ticketCheckBox'.$masterTicketsObj->TicketCategoryId;?>').attr('checked','checked');
		$('#<?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>').removeClass('price_input_disable');
		$('#<?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>').addClass('price_input required NumGrtrZero ');
		$('#<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>').removeClass('price_input_disable ');
		$('#<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>').addClass('price_input required NumGrtrZero ');
		$('#<?php echo 'ticketCheckBox'.$masterTicketsObj->TicketCategoryId;?>').attr('checked','checked');
		$('#<?php echo 'speStartPrice'.$masterTicketsObj->TicketCategoryId;?>').removeAttr('disabled');
		
		
		
		}else{
		$('#<?php echo 'ticketCheckBox'.$masterTicketsObj->TicketCategoryId;?>').removeAttr('checked');
		$('#<?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>').removeClass('price_input required NumGrtrZero ');
		$('#<?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>').addClass('price_input_disable');
		$('#<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>').removeClass('price_input required NumGrtrZero ');
		$('#<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>').addClass('price_input_disable');
		$('#<?php echo 'speStartPrice'.$masterTicketsObj->TicketCategoryId;?>').attr('disabled', 'disabled');
		}
		
		<?php
		}
		?>
		var mySessionId = $(this).attr('mySessionId');
		
		
		$('#sessiondate').val(date);
		$('#sessionstartTime').val(starttime);
		$('#sessionendTime').val(endtime);
		$('#sessionaddress').val(address);
		$('#venueName').val(venuename);
		$('#sessionaddress2').val(address2);
		$('#sessioncity').val(city);
		$('#sessionstate').val(state);
		$('#country').val(country);
		$('#sessionzip').val(zip);
		$('#venueEmail').val(venueEmail);
		$('#phoneNumber').val(phoneNumber);
		$('#sessionurl').val(url);
		$('#eventId').val(eventId);
		$('#launchEventId').val(launchEventId);
		$('#starthour').val(starthour);
		$('#startmin').val(startmin);
		$('#endhour').val(endhour);
		$('#endmin').val(endmin);
		
		$('#starttime').val(starttime);
		$('#endtime').val(endtime);
		
		$('#sessionId').val(mySessionId);
		$('#elementId').val(mySessionId);
		$('#sessionTitle').val(sessionTitle);
		$('#sessioncountry').parent().find('.abc').text(country);
		
		//if any of the category checkbox is checked then date field get activated
		if($( '.cat:checked' ).length>0) $('#speStartDate1').removeAttr('disabled');
		else  $('#speStartDate1').attr('disabled','disabled');
		
		checkTicket();
		
		
		if(eventSellstatus == 't'){
			$('#eventSellstatus').attr('checked','checked');
			$('#eventSellstatusf').removeAttr('checked');
			$('#eventNoTicket').removeAttr('checked');
			$("#freeticket").hide();
			$("#sellticket").show();
			$("#earlyBird").show();
			$("#earlyBirdComplete").show();
		}
		else if(eventSellstatus == 'f'){
			$('#eventSellstatus').removeAttr('checked');
			$('#eventNoTicket').removeAttr('checked');
			$('#eventSellstatusf').attr('checked','checked');
			$("#sellticket").hide();
			$("#earlyBird").hide();
			$("#earlyBirdComplete").hide();
			$("#freeticket").show();
			free();
		}
		else{
			$('#eventSellstatus').removeAttr('checked');
			$('#eventSellstatusf').removeAttr('checked');
			$('#eventNoTicket').attr('checked','checked');
			$("#sellticket").hide();
			$("#earlyBird").hide();
			$("#earlyBirdComplete").hide();
			$("#freeticket").hide();
			$("#consumptionTaxDiv").hide();	
			noTicket();
		}
		
		if(earlyBirdStatus == 't'){
			$('#earlyBirdStatus').attr('checked','checked');	
			$("#earlyBird").show();		
		}
		else{
			$('#earlyBirdStatus').removeAttr('checked');
			$("#earlyBird").hide();
		}
		var url=baseUrl+language+'/counsumptiontax/counsumptiontaxForm/<?php echo $entityIdSession;?>/'+mySessionId+'/<?php echo $projectId;?>';
		var data = AJAX(url,'consumptionTaxSettingsDiv','','');
		
	runTimeCheckBox();
	document.getElementById('SESSIONTIMEForm-Content-Box').style.display = 'block';
	document.getElementById('SESSIONTIME-Content-Box').style.display = 'block';
	$('#SESSIONTIMEForm-Content-Box').removeClass('dn');	
	});

});
</script>
<script language="javascript" type="text/javascript">
function sessionDeleteAction(sessionIdForDelete)
{	
	var conBox = confirm(areYouSure);
	if(conBox){
		document.sesTimesListForm.sessionIdForDelete.value = sessionIdForDelete;
		document.sesTimesListForm.submit();
	}
	else{
		return false;
	}	
}


$(document).ready(function() {

	$(".delSess").click(function() {
		var conBox = confirm(areYouSure);
		if(conBox)
		{			
			var myDelSessionId = $(this).attr('myDelSessionId');
			$("#sessionIdForDelete").val(myDelSessionId);
			$('#sesTimesListForm').submit();
			return true;
		}
		else
		{
			return false;
		}
	});

	$(".moveSession").click(function() {

		var sessioncurrentId = $(this).attr('sessioncurrentId');
		$("#sessioncurrentId").val(sessioncurrentId);

		var sessionswapId = $(this).attr('sessionswapId');
		$("#sessionswapId").val(sessionswapId);

		var sessioncurrentPosition = $(this).attr('sessioncurrentPosition');
		$("#sessioncurrentPosition").val(sessioncurrentPosition);

		var sessionswapPosition = $(this).attr('sessionswapPosition');
		$("#sessionswapPosition").val(sessionswapPosition);

		$('#sessionIdForSwap').val(1);

		$("#sessionIdForDelete").val('');//no delete

		$('#sesTimesListForm').submit();
		
	});
});

function canceltoggle(toggleFlag)
{
 // alert(toggleFlag);
  if(toggleFlag==0)
  {
		$('#sessiondate').attr('dateGreaterThan','#currentDate');
		$('#sessiondate').val('');
		$('#starttime').val('00:00');
		$('#endtime').val('00:00');
		$('#sessionaddress').val('');
		$('#venueName').val('');
		$('#sessionaddress2').val('');
		$('#sessioncity').val('');
		$('#sessionstate').val('');
		$('#country').val('');
		$('#sessionzip').val('');
		$('#sessionurl').val('');
		$('#sessionTitle').val('');
		$('#venueEmail').val('');
		$('#phoneNumber').val('');
		$('#eventId').val(0);
		$('#launchEventId').val(0);
		$('#eventSellstatus').attr('checked','checked');
			$("#freeticket").hide();
			$("#sellticket").show();
			$("#earlyBird").show();		
		
		<?php
		foreach ($masterTickets as $i => $masterTicketsObj) {
			
		?>
		var <?php echo 'ticketId'.$masterTicketsObj->TicketCategoryId;?> = $(this).attr('<?php echo 'ticketId'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'ticketId'.$masterTicketsObj->TicketCategoryId;?>').val('');
		
		var <?php echo 'PriceScheduleId'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo 'PriceScheduleId'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'PriceScheduleId'.$masterTicketsObj->TicketCategoryId;?>').val('');
			
			
		var <?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'ticket'.$masterTicketsObj->TicketCategoryId;?>').val('');
		
		var <?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>').val('0');
		$('#<?php echo 'price'.$masterTicketsObj->TicketCategoryId;?>').val('0');
		
		getDisplayPrice(0,'<?php echo $seller_currency;?>','#totalCommision<?php echo $masterTicketsObj->TicketCategoryId;?>','#displayPrice<?php echo $masterTicketsObj->TicketCategoryId;?>');
		
		var <?php echo 'speStartDate'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo'speStartDate'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'speStartDate'.$masterTicketsObj->TicketCategoryId;?>').val('');
		
		
		var <?php echo 'speStartPrice'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo'speStartPrice'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'speStartPrice'.$masterTicketsObj->TicketCategoryId;?>').val('');
		getDisplayPrice(0,'<?php echo $seller_currency;?>','#totalCommisionSP<?php echo $masterTicketsObj->TicketCategoryId;?>','#displayPriceSP<?php echo $masterTicketsObj->TicketCategoryId;?>');
		
		
		var <?php echo 'speEndDate'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo 'speEndDate'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'speEndDate'.$masterTicketsObj->TicketCategoryId;?>').val('');
		
		
		var <?php echo 'speEndPrice'.$masterTicketsObj->TicketCategoryId;?>=$(this).attr('<?php echo 'speEndPrice'.$masterTicketsObj->TicketCategoryId;?>');
		$('#<?php echo 'speEndPrice'.$masterTicketsObj->TicketCategoryId;?>').val('');
		$('#<?php echo 'ticketCheckBox'.$masterTicketsObj->TicketCategoryId;?>').removeAttr('checked');
		<?php } ?>
		runTimeCheckBox();
	
	$('#SESSIONTIMEForm-Content-Box').addClass('dn');
	$('#SESSIONTIMEForm-Content-Box').slideUp('slow');
	$('#SESSIONTIME-Content-Box').slideUp('slow');
	checkTicket();
	}
  
  if(toggleFlag ==1)
  {
	if($('#sessionId').val()=='' || $('#sessionId').val()=='0' ) $('#sessiondate').attr('dateGreaterThan','#currentDate');
    else $('#sessiondate').removeAttr('dateGreaterThan');
	$('#SESSIONTIMEForm-Content-Box').removeClass('dn');
	$('#SESSIONTIME-Content-Box').slideDown('slow');
	$('#sessionNoRecords-Box').slideToggle('slow');
	
	//$('#SESSIONTIMEForm-Content-Box').slideDown('slow')

  }
  
}

function removeStartDateAttr(){
	$('#sessiondate').removeAttr('dateGreaterThan');
}
</script>
