<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//echo "<pre>";
//print_r($PurchaseRecord['get_result']);

//get currency type
 
$currencyType =  getCurrencyType($PurchaseRecord['get_result']->ordCurrency); ?>
<!------- for print --------->
<style>
@media print
{
	body * { visibility: hidden; }
	.main_print_div * { visibility: visible; }
	.main_print_div { position: absolute; top: 150px; left: 80px; }
}
</style>


        <div class="bg_white cart_pattern">
          <div class="seprator_6"></div>
          <div class="cart_top_header ml6 mr6">
            <div class="CSEprise_pattern minH110">
              <div class="cell">
                <div class="cart_top_header_heading">Shopping Cart </div>
                
                
               
              </div>
              <div class="Fright">
                <div class="SCart_subMenu_outer mt10 mr10">
                  
                  <?php $this->load->view('purchase_common_menu'); ?>  
                  
                </div>
                <div class="seprator_30"></div>
                
                
              </div>
              
               <div class="cart_main_nav_box fl mt7"> 
              		<a class="ml40 selected height37 ptr">
                  <div class="mt9 mr8">Sales Record</div>
                  </a>
                  <div class="clear"></div>
                  </div>
              
             
              
				<div class="fr mr10">
					
					&nbsp;
					
                </div>
              
              
            </div>
          </div>
          
         
        
          <div class="seprator_25"></div>
          <div class="cart_container_outer main_print_div" >
         <!------------container start here--------->
        
        <!--<div class="cart_container mh390">--> 
         
         <div class="cart_container show_gradiant_inner">
                    	<div class="seprator_27"></div>
                        	<div class="fl widht_300 ml65 font_opensansSBold font_size13 lineH24">
                            <div class="font_museoSlab clr_f1592a font_size24">Sales Record</div>
                            <div class="seprator_20"></div>
                            <div class="clr_333 font_opensansSBold"><?php echo date("d F Y",strtotime($PurchaseRecord['get_result']->ordDateComplete)); ?></div>
                            <div class="clr_f1592a font_opensansSBold"><?php echo $PurchaseRecord['get_result']->ordNumber; ?></div>
                            <div class="clr_555 font_opensansSBold">Registration Number</div>
                            </div>
                            
                            <div class="fr width_250 bdrL5_f15921 font_opensans clr_666 pl20 font_size12">
                            <div class="font_size18 font_museoSlab clr_888">Seller</div>
                            <div class="seprator_13"></div>
                            <div class="font_opensansSBold"><?php echo $getSellerDetail->firstName.' '.$getSellerDetail->lastName; ?></div>
                            <div class="lineH24">
                               <?php echo $getSellerDetail->seller_address1; ?> <br>
                                <?php echo $getSellerDetail->seller_city; ?>, <?php echo $getSellerDetail->seller_state; ?>  <?php echo $getSellerDetail->seller_zip; ?> <br>
                                <?php echo $getSellerDetail->territoryCountryId; ?> <br>
                                <?php echo $getSellerDetail->seller_phone; ?> <br>
                                <?php echo $getSellerDetail->email; ?>
							</div>
                            </div>
                            
                            <div class="clear"></div>
                            <div class="seprator_30"></div>
                            
                            <div class="fl width_304 bdrL5_717171 font_opensans clr_666 pl10 font_size12 ml50">
                            <div class="font_size18 font_museoSlab clr_888">Buyer</div>
                            <div class="seprator_13"></div>
                            <div class="font_opensansSBold"><?php echo $PurchaseRecord['get_result']->custName; ?></div>
                            <div class="lineH24">
                                <?php echo $PurchaseRecord['get_result']->custStreetAddress; ($PurchaseRecord['get_result']->custStreetAddress!="")?','.$PurchaseRecord['get_result']->custSuburb:''; ?> <br>
                                <?php echo $PurchaseRecord['get_result']->custCity; ?>, <?php echo $PurchaseRecord['get_result']->custState; ?>  <?php echo $PurchaseRecord['get_result']->custZip; ?> <br>
                                <?php echo $PurchaseRecord['get_result']->custCountry; ?> <br>
                                <?php echo $PurchaseRecord['get_result']->custPhone; ?> <br>
                                <?php echo $PurchaseRecord['get_result']->custEmail; ?>
							</div>
                            </div>
                            <div class="clear"></div>
                            <div class="seprator_45"></div>
                            	<div class="bdr_cecece fr mr30 position_relative">
                                	
                                    		<div class="cell shadow_wp strip_absolute_right left0">
                                      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                          <tr>
                                            <td height="51"><img src="<?php echo base_url('templates/default'); ?>/images/cartpurchase_lineshedow_top.png"></td>
                                          </tr>
                                          <tr>
                                            <td class="line_mid_selllineShedow">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="51"><img src="<?php echo base_url('templates/default'); ?>/images/cartpurchase_lineshedow_btm.png"></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <div class="clear"></div>
                                    </div>
                                    
                                    
                                <div class="pr10 width_540">
                                	<div class="position_relative">
                                    
                                    	<div class="cell shadow_wp strip_absolute_right right100">
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
                                    
                                    
                                    <div class="cell shadow_wp strip_absolute_right right48">
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
                                    
                                    	<div class="row font_weight font_size12 clr_333 lineH_32">
                                        	<div class="fl width_330 ml24">Description</div>
                                            <div class="fl width_70 text_alignC">Price</div>
                                            <div class="fl width_52 text_alignC">Qty.</div>
                                            <div class="fl width_60 text_alignC">Total</div>
                                        </div>
                                          
                                        <?php //print_r($getItemsDetils); 
                                        if($getItemsDetils['get_num_rows'] > 0){
										$addTotal=0;		
										foreach($getItemsDetils['get_result'] as $itemsDetils)	
										{
											
											//print_r($itemsDetils);
                                        ?>  
                                          <div class="row">
                                        	<div class="price_trans_wp_sale font_size12 lineH24 clr_444">
												<div class="fl width_330 ml24"><?php echo $itemsDetils->itemName.'('.getStatusType($itemsDetils->purchaseType,$itemsDetils->itemId).')'; ?></div>
													<div class="fl width_70 text_alignC"> <?php echo $currencyType.' '.$itemsDetils->basePrice; ?></div>
													<div class="fl width_52 text_alignC"><?php echo $itemsDetils->itemQty; ?></div>
													<div class="fl width_60 text_alignC"><?php 
														$itemPrice = $itemsDetils->basePrice; 
														$itemQty = $itemsDetils->itemQty;
														$priceTotal = ($itemQty*$itemPrice);
														$mainPriceTotal = $addTotal+$priceTotal;
														echo  $currencyType.' '.$priceTotal;
														?>
													</div>
                                                </div>
                                                <div class="seprator_3"></div>
                  						  </div>
										<?php } } ?>
                                   
                                    </div>
                                    
                                    <div class="seprator_10"></div>
                                    	<div class="row">
                                        	<div class="fl width_330 ml24 font_opensans text_alignR"><?php //echo getPurchaseType($PurchaseRecord['get_result']->purchaseType); ?> Consumption Tax</div>
                                            <div class="fl width_90 text_alignC font_weight">VAT &nbsp; 15%</div>
                                                <div class="fl width_60 text_alignC clr_444 font_weight ml30"><?php $vatPrice = ($mainPriceTotal*15)/100; echo $currencyType.' '.$vatPrice; ?></div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="seprator_5"></div>
                                        
                                        <div class="row">
                                        	<div class="fl width_330 ml24 font_opensans"><?php //echo getStatusType($PurchaseRecord['get_result']->purchaseType,$PurchaseRecord['get_result']->itemId); ?></div>
                                            <div class="fr width_173 height_33 sale_total_g font_size13 clr_white font_weight lineH_32">
                                            	<div class="fl width_75 text_alignC">Total</div>
                                                <div class="fl width_80 text_alignR"><?php $mainPriceTota = $mainPriceTotal+$vatPrice; echo $currencyType.' '.$mainPriceTota; ?></div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="bdrB2_9e0c0c"></div>
                                        <div class="seprator_1"></div>
                                </div>
                            
                            <div class="clear"></div>
                            <div class="seprator_27"></div>
                    </div>
         
         
        
        <!-------------container end here----------> 
          </div>
          <div class="seprator_20"></div>
          
			<div class="row">
                	<!---- <div class="tds-button Fright mr36"> <a  href="<?php echo base_url('cart/purchase'); ?>" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)"><span class="font_opensans min_widht63">Print</span></a> </div>-->
                      <div class="tds-button Fright mr36"> &nbsp;</div>
                      <div class="tds-button Fright mr6"> <a target="_blank"  href="#" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)"><span class="font_opensans min_widht63">Print</span></a> </div>
            </div>
			<div class="clear"></div>
			<div class="seprator_10"></div>
			
        </div>
        <!--front_end_mani_content_wp-->
 <script>
 function mousedown_tds_button_pur(obj){
obj.style.backgroundPosition ='0px -42px';
obj.firstChild.style.backgroundPosition ='right -42px';
}
function mouseup_tds_button_pur(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}

 </script> 
