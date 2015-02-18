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
                
             

                <div class="row">
                    <div class="fl width119px text_alignR">&nbsp;</div>
                    <div style="line-height: 17px;" class="fl ml20 clr_333"> &nbsp;</div>	 

                </div>

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
        <div class="pa" style="bottom:0px; right:0px;">
                <div class="cartbtn_pur ml10 mt6 fr"> <a onmouseup="mouseup_tds_button_pur(this)" onmousedown="mousedown_tds_button_pur(this)" href="<?php echo base_url('cart/sales_record_print').'/'.$purchaseData->itemId; ?>" target="_blank"><span>Sales Record</span></a> </div>
        </div>
    
    <div class="clear"></div>
    
    
</div>

