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
       <div class="fs18 red lineH30  bb_F1592A font_bold">Ticket Purchase</div>
       <div class="font_bold pt10 pb15"> <?php echo $purchaseData->itemName; ?>
       </div>
       <div class="date_wrap"> <span class="width_120 fl">Date & Time</span> <span><b><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></b> <span class="fs11 pl10"> Luxembourg Time</span></span> </div>
       <div class="date_wrap pt8"><span class="width_120">Seller</span><span class="font_bold"><a href="<?php echo base_url_lang('showcase/index/'.$purchaseData->sellerId); ?>" target="_blank"> <?php echo ucwords($purchaseData->firstName.' '.$purchaseData->lastName); ?></a></span></div>
       <div class="sale_btnwrap">
          
        <?php 
        if($sellerInfo->isFree==0){ ?>
            <a   href="<?php echo base_url('cart/sales_record_print').'/'.$purchaseData->itemId; ?>" target="_blank">
                <button class="sale_btn white_button" type="button">Sales Record</button>
            </a> 
        <?php }else{ ?>
                 <button class="sale_btn opacityP5" type="button">Sales Record</button>
        <?php } ?>
       
        <button onclick="openLightBox('popupBoxWp','popup_box','/cart/sellerInfoNew','<?php echo $purchaseData->itemId; ?>');" class="sale_btn contact_buyer white_button" type="button">Contact Seller</button>
     
        <button onclick="openLightBox('popupBoxWp','popup_box','/cart/commentonpurchase','<?php echo $purchaseData->entityId; ?>','<?php echo $purchaseData->elementId; ?>','<?php echo $purchaseData->ordId; ?>','<?php echo $purchaseData->itemId; ?>','<?php echo $purchaseData->sellerId; ?>');" class="light_btn white_button" type="button">Comment on Purchase</button>
       
       </div>
    </div>
    <!-- Half box gary  --> 
    <div class="half_box_second  verti_top">
       <div class="sap_40"></div>
       <div class="sale_thum fl">
          <img src="<?php echo $imgPath?>purchase_4.jpg" alt="" />
       </div>
       <div class="fr">
          <div class="date_wrap">
             <span class="width106 fl">Date</span>
             <span class="red">
             <b><?php echo $sessionDate; ?></b>
             </span>
          </div>
          <div class="date_wrap pt5">
             <span class="width106">Time</span>
             <span class="red">
             <b><?php echo $sessionTime; ?></b>
             </span>
             <span class="fs11">Local Time</span>
          </div>
          <div class="date_wrap pt5">
             <span class="width106">Town or City</span>
             <span class="font_bold red">Mexico</span>
          </div>
          <div class="sap_10"></div>
          <p>Creative-Industry Educational Event</p>
       </div>
       <div class="sap_45"></div>
        <?php 
        if($getMeetingPoingData)
            {
        ?>
            <span class="meetingPoing_Id<?php echo $SessionId; ?>" id="meetingPoingId<?php echo $SessionId; ?>" >
                <?php if(date("Y-m-d",strtotime($sessionDate)) >= date("Y-m-d")) { ?>
                    <a class="meeting_p pl5 fs16 clearb" target="_blank" href="<?php echo base_url('event/usermeetingpoint'); ?>"> Signed in to Meeting Point</a>
                <?php } ?>
             </span>
        
        <?php } else { ?> 
                
                <?php if(date("Y-m-d",strtotime($sessionDate)) >= date("Y-m-d")) { ?>
                    <span class=" meetingPoing_Id<?php echo $SessionId; ?>" id="meetingPoingId<?php echo $SessionId; ?>" > <a href="javascript:openLightBox('popupBoxWp','popup_box','/cart/singInToMeetingPoint','<?php echo $purchaseData->itemId; ?>');" class="meeting_p pl5 fs16 clearb" >Sign in to Meeting Point</a> </span>
                <?php } ?>

        <?php  } ?>
       
        <a  target="_blank" href="<?php echo base_url('cart/get_event_ticket_pdf').'/'.$purchaseData->invoiceId; ?>" >
            <button type="button" class="fr print_tick height32 bdr_aca">Print Tickets</button>
        </a>
    </div>
 </div>

                   
