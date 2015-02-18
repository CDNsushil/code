<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Set Event or Launch date 

$eventIsExpired = 'f';
$sessionDate = date("Y-m-d ",strtotime($sessionData['date'])).$sessionData['endTime'];

$sessionExpireDate = strtotime($sessionDate);
$currentDate = time();
if($sessionExpireDate < $currentDate )
{
	$eventIsExpired = 't';
}
//Set onclick event for join meeting 
$loggedUserId=isloginUser();
//get purchase  ticket data
$whereCondition=array(
					'sessionId'=>$sessionData['sessionId'],
					'userId'=>$loggedUserId
			);
$getData=getDataFromTabel('TicketTransectionLog', 'id',  $whereCondition, '', $orderBy='', '', 1 );
$getTicketCount=0;
if(!empty($getData) && count($getData) > 0)
{
	$getTicketCount=count($getData);
}

//get meeting point data
$whereCondition=array(
					'session_id'=>$sessionData['sessionId'],
					'user_id'=>$loggedUserId
			);
$getMeetingData=getDataFromTabel('MeetingPoint', 'id',  $whereCondition, '', $orderBy='', '', 1 );
$meetingPointCount=0;
if(!empty($getMeetingData) && count($getMeetingData) > 0)
{
	$meetingPointCount=count($getMeetingData);
}
$sessionTicketId = $sessionData['sessionId'];
$beforeJoinMeetingLoggedIn=$this->lang->line('beforeJoinMeetingPointLoggedIn');
$missedEvent = $this->lang->line('missedSession');
$joinMeetingSuccess = $this->lang->line('joinMeetingSuccess');
$purchaseTicketFirst = $this->lang->line('purchaseTicketFirst');
$alreadyMeetingJoin = $this->lang->line('alreadyMeetingJoinNewMsg');
echo "<script>
sendData = {'message':'".$alreadyMeetingJoin."','linkUrl':'".base_url("event/usermeetingpoint")."','widthClass':'width500px'}
</script>";
if($loggedUserId > 0){
	if($eventIsExpired=='t'){
		$functionJoinMeeting="if(checkIsUserLogin('".$beforeJoinMeetingLoggedIn."')){customAlert('".$missedEvent."')}";
	}else{
		if($getTicketCount > 0 || (isset($isDetailVal) && $isDetailVal > 0)){
			if($meetingPointCount > 0){
				$functionJoinMeeting="if(checkIsUserLogin('".$beforeJoinMeetingLoggedIn."')){confirmPopup(sendData)}";
			}else{
				$functionJoinMeeting="joinMeetingPoint('".$sessionTicketId."')";
			}
		}else{
			$functionJoinMeeting="if(checkIsUserLogin('".$beforeJoinMeetingLoggedIn."')){customAlert('".$purchaseTicketFirst."')}";
		}
	}
}else{
	$functionJoinMeeting = "openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeJoinMeetingLoggedIn."')";
} 
?>
<div class="ml10 cell <?php echo $mt12; ?>">
	<a class="Dgrey_btn black_link_hover" onclick="<?php echo $functionJoinMeeting;?>" onmouseup="mouseup_Dgrey_btn(this)" onmousedown="mousedown_Dgrey_btn(this)"><?php echo $this->lang->line('joinMeetingPoint');?></a>
</div>
								
<div class="clear"></div>
<div class="seprator_10"></div>

<script type="text/javascript">
/* Function to manage Meeting Point joining */
function joinMeetingPoint(sessionId){
	var BASEPATH = "<?php echo base_url(lang());?>";
	var form_data = {sessionId: sessionId};
	$.ajax
	({
		type: "POST",
		url: BASEPATH+"/eventfrontend/joinMeetingPoint",
		data: form_data,
		success: function(data)
		{
			if(data==1){
				if(checkIsUserLogin('<?php echo $beforeJoinMeetingLoggedIn;?>')){
					customAlert('<?php echo $joinMeetingSuccess;?>')
				}
			}
			else if(data==2){
				if(checkIsUserLogin('<?php echo $beforeJoinMeetingLoggedIn;?>')){
					customAlert('<?php echo $alreadyMeetingJoin;?>')
				}
			}
			else{
				return false;
			}	
		}
	});
	return false;	
}
	
	
</script>
