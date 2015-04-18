<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/************this code get session date and time************/
$get_SellerDetail =  json_decode($purchaseData->sellerInfo);
$getSessionId = $get_SellerDetail->SessionId;
$whereCondition=array('sessionId'=>$getSessionId);
$resLogSummary=getDataFromTabel('EventSessions', 'date, startTime',  $whereCondition, '', $orderBy='', '', 1 );
$resLogSummary = $resLogSummary[0];	
$sessionDate = 	date("d M Y",strtotime($resLogSummary->date));	
$getTimeFormate= explode(":",$resLogSummary->startTime);
$sessionTime = 	$getTimeFormate[0].':'.$getTimeFormate[1];

/****************this code get seller info****************/
$sellerInfo = json_decode($purchaseData->sellerInfo);
$userId=isLoginUser();  
$SessionId = $sellerInfo->SessionId;
$meetingCondtion = array('session_id'=>$SessionId,'user_id'=>$userId);
$getMeetingPoingData=getDataFromTabel('MeetingPoint', 'session_id',  $meetingCondtion, '', $orderBy='', '', 1 );


$entityId = $get_SellerDetail->entityIdPE;
$elementId = $get_SellerDetail->eventORlaunchId;
$showCaseUrl = getFrontEndLink($entityId, $elementId);



 ?>

<div class="sale_box shadow_light">
    <!-- Half box white  --> 
    <div class="half_box verti_top">
       <div class="fs18 green lineH30  bb_F1592A font_bold">Ticket Purchase</div>
       <div class="font_bold pt10 pb15">  <?php echo $purchaseData->itemName; ?>
       </div>
       <div class="date_wrap"> <span class="width_120 fl">Date & Time</span> <span><b><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></b> <span class="fs11 pl10"> Luxembourg Time</span></span> </div>
       <div class="date_wrap pt8"><span class="width_120">Buyer</span><span class="font_bold"><a target="_blank" href="<?php echo base_url_lang('showcase/index/'.$purchaseData->customerUid)?>"><?php echo ucwords($buyerName); ?></a></span></div>
       <div class="sale_btnwrap">
          <a   href="<?php echo base_url('cart/sales_record_print').'/'.$purchaseData->itemId; ?>" target="_blank">
                <button class="sale_btn white_button" type="button">Sales Record</button>
            </a>
          <button class="sale_btn contact_buyer white_button" onclick="openLightBox('popupBoxWp','popup_box','/cart/buyerInfoNew','<?php echo $purchaseData->itemId; ?>');" type="button">Contact Buyer</button>
          <button class="light_btn opacityP5"  type="button">Buyer’s Comment</button>
       </div>
    </div>
    <!-- Half box gary  --> 
    <div class="half_box_second  verti_top">
       <div class="date_wrap"> <span class="width106 fl">Date</span> <span class="red"><b><?php echo $sessionDate; ?></b></span> </div>
       <div class="date_wrap pt8"><span class="width106">Time</span><span class="red"><b><?php echo $sessionTime; ?></b></span> <span class="fs11">Local Time</span></div>
       <div class="date_wrap pt8"><span class="width106">Town or City</span><span class="font_bold red">Johannesburg</span></div>
       <div class="sap_30"></div>
       <div class="cnt_sale fs13 pb10">
          <p> To see the complete list of Attendees and members using 
             Meeintg point select
          </p>
          <a href="">Edit  & Manage your Film & Video Events</a> from
          <p class="font_bold">Your Toadsquare > Your Performances & Events.</p>
       </div>
       <button class="green_btn fr green_sale" type="button">View Tickets</button>																															
    </div>
 </div>

