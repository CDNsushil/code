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
                <div class="fl width119px text_alignR">Buyer</div>
                <div class="fl ml20 width235px clr_333"><?php echo ucwords(getUserName($purchaseData->customerUid)); ?></div>	 
            </div>
            
            <div class="row">
                <div class="fl width119px text_alignR">Date</div>
                <div class="fl ml20 width235px clr_f1592a"><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></div>	 
            </div>
            
            <div class="row">
                <div class="fl width119px text_alignR">Type</div>
                <div class="fl ml20 width235px clr_333"><?php echo getPurchaseType($purchaseData->purchaseType); ?></div>	 
            </div>
            
            <div class="row">
                <div class="fl width119px text_alignR">Status</div>
                <div id="shippingStatus<?php echo $formId; ?>" class="fl ml20 clr_333" style="line-height: 17px;"><?php $getShippedStatus =  getStatusType($purchaseData->purchaseType,$purchaseData->itemId); 
                    echo $getShippedStatus;
                ?></div>	 
            </div>

<div class="row">
            <div class="fl width119px text_alignR">Shipping Details</div>
   
  
  <?php
    
    switch($getShippedStatus)
    {
    
    case 'Not Shipped':
   ?>
   <!--------shipping_details_div start----->    
   <div id="shipping_details_div<?php echo $formId; ?>">
        
        <?php
            echo form_open('cart/shipping_details_submit/', 'class="form" id="shipping_details'.$formId.'" name="shipping_details'.$formId.'"'); 
        ?>	
            
            <div style="line-height: 17px;" class="fl ml20 clr_333 width_240">
                        <textarea  onkeyup="checkWordLen(this,50,'contactmeMessageLimit<?php echo $formId ?>');checkFieldBlank(this);"  id="shipping_details_data<?php echo $formId ?>" name="shipping_details_data" class="textarea_small width227px height_45px required valid"  ></textarea>
                </div>	 
            <div class="show_shipping_note ml10 mt4 width_232">
                <div class="tag_word_orange fl clr_888 orange_clr_imp">
                  <span class="pt3">0 - 50 words</span> 
                     </div>
                <span class="five_words fr"> 
                <!--<span>Total </span>-->
                    <span class="inline mt3" id="contactmeMessageLimit<?php echo $formId ?>">0</span>
                    <span class="inline mt3">  words</span>
                </span>
            </div>
            

            <div class="cartbtn_pur ml10 mt6 fr">
                <a style="background-position: 0px 0px;" onclick="shipping_details_submit('<?php echo $formId; ?>')" onmouseup="mouseup_tds_button_pur(this)" onmousedown="mousedown_tds_button_pur(this)"><span style="background-position: right 0px;">Shipped</span></a> 
                
            </div>
        
        
        <input type="hidden" name="item_id" id="item_id" value="<?php echo $purchaseData->itemId;  ?>">
        
        <?php echo form_close(); ?>

    </div>
<!--------shipping_details_div end-----> 
<?php 
break;

case 'Shipped': 
?>

 <!--------shipping_details_div start----->    
   <div id="shipping_details_shipped">
            <div style="line-height: 17px;" class="fl ml20 clr_333 width_240">
            <?php 
                $whereCondition=array('itemId'=>$purchaseData->itemId);
                $resLogSummary=getDataFromTabel('SalesItemShipping', 'shippingDetails',  $whereCondition, '', $orderBy='', '', 1 );
                echo $resLogSummary[0]->shippingDetails;
            ?>
            </div>	 
    </div>
<!--------shipping_details_div end-----> 	
<?php 
break;

case 'Recieved':
?>
<!--------recived item div start----->    
   <div id="shipping_details_shipped">
            <div style="line-height: 17px;" class="fl ml20 clr_333 width_240">
            <?php 
                $whereCondition=array('itemId'=>$purchaseData->itemId);
                $resLogSummary=getDataFromTabel('SalesItemShipping', 'shippingDetails',  $whereCondition, '', $orderBy='', '', 1 );
                echo $resLogSummary[0]->shippingDetails;
            ?>
            </div>	 
    </div>
<!--------recived item div end-----> 	
<?php
break;

} ?>


</div>		

<div class="clear"></div>
            
    </div>
</div>

<div class="fr height_89 pt2 pb5 ml-24 position_relative pr15 lineH22 font_size13" style="width: 425px;">

        
            
            

    <div class="row clr_f1592a">
        <div class="fl width250px ml20">Item</div>
        
        <div class="fl width_130 ml20 tar">
            
            <?php echo $purchaseData->rateSeller;  ?>
            
        </div>
        
        <div class="clear"></div>
    </div>
                                <div class="row price_trans_wp clr_444">
        <?php
        $entityId = $purchaseData->entityId;
        $elementId = $purchaseData->elementId;
        $showCaseUrl = getFrontEndLink($entityId, $elementId);
        ?>
                                        
        <div class="fl width_313 ml20">
            <a target="_blank" class="underline" href="<?php echo $showCaseUrl; ?>">
                <?php echo $purchaseData->itemName; ?>
            </a>
        </div>
        
        
        
        <div class="clear"></div>
    </div>

</div>
    <div class="pa" style="bottom:5px; right:0px;">
        
            <?php $this->load->view('sales_view_button'); ?>
            
    </div>

<div class="clear"></div>


</div>

                   
