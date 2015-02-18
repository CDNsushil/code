<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>


<div class="row ml28 mr28 mt7 bdr_cecece pr">
    <div class="fl SCart_item_purchaseleft">
        <div class="width384px  SCart_item_inner_purchase position_relative pt8 pb5 lineh_20 clr_666 font_opensans">
                <div class="cell shadow_wp strip_absolute_right left129">
                  <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                      <tr>
                        <td height="30"><img src="<?php echo base_url('templates/default'); ?>/images/cart_extraspacedivider_top.png"></td>
                      </tr>
                      <tr>
                        <td class="line_mid_extraspace">&nbsp;</td>
                      </tr>
                       <tr>
                        <td height="30"><img src="<?php echo base_url('templates/default'); ?>/images/cart_extraspacedivider_bottom.png"></td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="clear"></div>
                </div>
                
                <div class="row">
                    <div class="fl width119px text_alignR">Seller</div>
                    <div class="fl ml20 width235px clr_333"><?php echo ucwords(getUserName($purchaseData->sellerId)); ?></div>	 
                </div>
                
                <div class="row">
                    <div class="fl width119px text_alignR">Date</div>
                    <div class="fl ml20 width235px clr_f1592a"><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></div>	 
                </div>
                
                <div class="row">
                    <div class="fl width119px text_alignR">Type</div>
                    <div class="fl ml20 width235px clr_333"><?php echo getPurchaseType($purchaseData->purchaseType); ?></div>	 
                </div>
                
                <div class="cartbtn_pur ml10 mt6 fr">
                       <a  target="_blank" href="<?php echo base_url('cart/get_event_ticket_pdf').'/'.$purchaseData->invoiceId; ?>"  onmouseup="mouseup_tds_button_pur(this)" onmousedown="mousedown_tds_button_pur(this)"><span>Tickets</span></a>
                </div>
                
                
                <?php 
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
                if($getMeetingPoingData)
                    {
                ?>
                    <div class="ml10 mt6 fr pt5 meetingPoing_Id<?php echo $SessionId; ?>" id="meetingPoingId<?php echo $SessionId; ?>" >
                    
                        <?php if(date("Y-m-d",strtotime($sessionDate)) >= date("Y-m-d")) { ?>
                            <a class="underline" target="_blank" href="<?php echo base_url('event/usermeetingpoint'); ?>"> Signed In to Meeting Point</a>
                        <?php } ?>
                        
                     </div>
                <?php } else { ?> 
                        
                        <?php if(date("Y-m-d",strtotime($sessionDate)) >= date("Y-m-d")) { ?>
                            <div class="cartbtn_pur ml10 mt6 fr meetingPoing_Id<?php echo $SessionId; ?>" id="meetingPoingId<?php echo $SessionId; ?>" > <a href="javascript:openLightBox('popupBoxWp','popup_box','/cart/singInToMeetingPoint','<?php echo $purchaseData->itemId; ?>');" onmouseup="mouseup_tds_button_pur(this)" onmousedown="mousedown_tds_button_pur(this)"><span class="pr11">Sign In to Meeting Point</span></a> </div>
                        <?php } ?>
                
                <?php  } ?>
            <div class="clear"></div>
                
        </div>
    </div>
    
    <div class="fr height_89 pt2 pb5 ml-24 position_relative pr15 lineH22 font_size13" style="width: 425px;">
    
        <div class="row clr_f1592a">
            <div class="fl width_313 ml20">Item</div>
            
            <div class="clear"></div>
        </div>
                                    <div class="row price_trans_wp clr_444">
                <?php
                $entityId = $get_SellerDetail->entityIdPE;
                $elementId = $get_SellerDetail->eventORlaunchId;
                $showCaseUrl = getFrontEndLink($entityId, $elementId);
                ?>
                
                <div class="fl width_313 ml20">
                    <a target="_blank" class="underline" href="<?php echo $showCaseUrl; ?>"><?php echo $purchaseData->itemName; ?></a>
                </div>
            
             <div class="clear"></div>
            <div class="ml20 ">
            
                    <?php 
                    // Event is show data and time of session
                    echo 'Date <font class="orange_clr_imp">'.$sessionDate; 
                    echo '</font>&nbsp;&nbsp; Time <font class="orange_clr_imp">'.$sessionTime.'</font>';
                    ?>
            </div>	
            
            
            <div class="clear"></div>
        </div>
        
        
    </div>

    <div class="pa" style="bottom:5px; right:0px;">
        <?php //$this->load->view('purchase_view_button'); ?>
            <div class="cartbtn_pur ml10 mt6 fr"> <a  href="javascript:openLightBox('popupBoxWp','popup_box','/cart/comment_on_purchase','<?php echo $purchaseData->entityId; ?>','<?php echo $purchaseData->elementId; ?>','<?php echo $purchaseData->ordId; ?>','<?php echo $purchaseData->itemId; ?>','<?php echo $purchaseData->sellerId; ?>');"  onmousedown="mousedown_tds_button_pur(this)" onmouseup="mouseup_tds_button_pur(this)"><span><?php echo $this->lang->line('comment_on_purchase'); ?></span></a> </div>
        <?php 
        if($sellerInfo->isFree==0){ ?>
            <div class="cartbtn_pur ml10 mt6 fr"> <a onmouseup="mouseup_tds_button_pur(this)" onmousedown="mousedown_tds_button_pur(this)" href="<?php echo base_url('cart/sales_record_print').'/'.$purchaseData->itemId; ?>" target="_blank"><span><?php echo $this->lang->line('purchase_sales_record'); ?></span></a> </div>
        <?php } ?>
        <div class="cartbtn_pur ml10 mt6 fr"> <a  href="javascript:openLightBox('popupBoxWp','popup_box','/cart/sellerInfo','<?php echo $purchaseData->itemId; ?>');" onmouseup="mouseup_tds_button_pur(this)" onmousedown="mousedown_tds_button_pur(this)"><span><?php echo $this->lang->line('purchase_contact_seller'); ?></span></a> </div>
    
     </div>
    
    <div class="clear"></div>
    
    
</div>


