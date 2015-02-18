<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!--eventPreviewBoxWp START-->
<div id="postPreviewBoxWp" class="postPreviewBoxWp heightAuto minWidth760px" style="display:none; ">
	<div id="close-reviewBox" title="" class="tip-tr close-customAlert"></div>			
	<div class="postPreviewFormContainer" id="postPreviewFormContainer"></div><!--End Div eventPreviewFormContainer-->
</div><!--End Div eventPreviewBoxWp-->

<!-- eventPreview option boc for four type of event START-->
<div id="mainTabBoxWp" class="mainTabBoxWp">
	<div id="close-postPreviewBox" title="" class="tip-tr close-customAlert"></div>			
	<div class="mainTabFormContainer" id="mainTabFormContainer"></div><!--End Div postPreviewFormContainer-->
</div><!--End Div postPreviewBoxWp-->

<?php 		
		echo Modules::run("event/indexNavigation");

		//defining common varaibles
		$live = '<span class="live">Live</span>';
		$online = '<span class="online">Online</span>';
		$totalRecords = count($listData);
		if($totalRecords > 0)
		{
			$flag =1;
			$delEventAction = 'event/deleteEvent';

			$eventFormAttr = array(
				'name'=>'eventForm',
				'id'=>'eventForm'
			);

			//Path for clock images
			$redClock = 'images/icons/clockred.png';
			$blueClock = 'images/icons/clockblue.png';
			$yellowClock = 'images/icons/clockyellow.png';

			//Path for category images
			$ticketA = 'images/icons/ticketA.png';
			$ticketB = 'images/icons/ticketB.png';
			$ticketC = 'images/icons/ticketC.png';
			
			echo form_open($delEventAction,$eventFormAttr); 	
				echo '<input id = "eventId" name = "eventId" value = "" type = "hidden" />';
				echo '<input id = "flag" name = "flag" value = "" type = "hidden" />';
			echo form_close();			
			
			$values['data'] = $listData;
				
			$this->load->view('event_list_element',$values);		
		
		}
		else{
			// MESSAGE: IF THERE IS NO RECORDS 
			echo '<div class="row heightSpacer">&nbsp;</div>';
			echo '<div class="norecordfound pt10">'.$label['noEvent'].'</div>';
			echo '<div class="row heightSpacer">&nbsp;</div>';			
		}	
?>
<script language="javascript" type="text/javascript">
	
function DeleteAction(eventId,flag)
{	 
	var conBox = confirm('<?php echo $this->lang->line('sureDelMsg')?>');
	if(conBox){
		document.eventFrom.eventId.value = eventId;
		document.eventFrom.submit();
	}
	else{
		return false;
	}		
}

$(document).ready(function() {
	//To delete
	$(".delImg").click(function() {
		var conBox = confirm('<?php echo $this->lang->line('sureDelMsg')?>');
		if(conBox)
		{		
			var eventId = $(this).attr('myeventid');
			var flag = $(this).attr('flag');
			//alert(eventId);
			$("#eventId").val(eventId);
			$("#flag").val(flag);
			$('#eventForm').submit();
			return true;
		}
		else
		{
			return false;
		}
	});
});

function delEvent(myEvent) 
{
	var conBox = confirm('<?php echo $this->lang->line('sureDelMsg')?>');
	if(conBox)
	{
		$("#eventId").val(myEvent);	
		$('#eventForm').submit();	
		return true;
	}
	else
	{
		return false;
	}
}
</script>
