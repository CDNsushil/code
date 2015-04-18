<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
        <div class="bg_white">
          <div class="seprator_6"></div>
          <div class="cart_top_header ml6 mr6">
            <div class="CSEprise_pattern">
              <div class="cart_top_header_heading"><?php echo $this->lang->line('membershipcart'); ?> </div>
              <div class="cart_main_nav_box font_opensans">
               <a class=" ml40">
                <div class="CMN_count">1</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('choosespace'); ?></div>
                </a> 
                
                <a class="ml40">
                <div class="CMN_count">2</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('confirmbilling'); ?></div>
                </a> 
                
                <a class="ml40 selected">
                <div class="CMN_count">3</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('summary'); ?></div>
                </a>
                
               <!--  <a class="ml40">
                <div class="CMN_count">4</div>
                <div class="ml52 mt9 mr12">Confirm Purchase</div>
                </a>-->
                
                 <a class="ml40">
                <div class="CMN_count">4</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('payment'); ?></div>
                </a>
                
                
                 </div>
              <div class="clear"></div>
            </div>
          </div>
          
          
          <div class="seprator_25"></div>
            <div class="cart_container_outer ">
          <div class="cart_container bg_dashbord_gred">
          <div class="overflow_hidden position_relative">
			
			<div id="paymentMessage" class="p40 lH21 tac">
				<div class="font_museoSlab font_size24 orange"><?php echo $paymentMessage;?> <!--<a  class="underline fontsize12" href="<?php //echo base_url(); ?>">Continue Shopping</a> --></div>
            </div>
      <?php
     if(isset($purchaseItem) && is_array($purchaseItem) && count($purchaseItem)>0 ) { ?>
            <div class="pr">
            <div class="cell shadow_wp strip_absolute_right right_140">
              <!-- <img src="images/strip_blog.png"  border="0"/>-->
              <table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%">
                <tbody>
                  <tr>
                    <td height="102"><img src="<?php echo base_url('images/line_small_top.png')?>"></td>
                  </tr>
                  <tr>
                    <td class="line_mid">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="102"><img src="<?php echo base_url('images/line_small_bottom.png')?>"></td>
                  </tr>
                </tbody>
              </table>
              <div class="clear"></div>
            </div>
            <!--list_box-->
            <div class="seprator_5"> </div>
    
   <?php
       
     
		     $cartTotal = 0;
		     $i=1;
		     $isShippingDetails=false;
		     foreach ($purchaseItem as $key =>$item) {				 
				 
				 $purchaseType = $item->purchaseType;
				 
				 $paypalData=getDataFromTabel('PaypalTransactionLog', 'ack', 'invoiceId', $item->invoiceId, '', '', 1);
				 
				 if($paypalData){
					$ack = $paypalData[0]->ack;
				 }else{
					 $ack = '';
				 }
				 
				 if($ack == 'Success'){
					$paymentString=$this->lang->line('paymentConfirmed'); 
					$paymentClass='green'; 
				 }else{
					$paymentString=$this->lang->line('paymentNotProcessed');
					$paymentClass='red';  
				 }
				 
				 $purchaseString='';
				 switch($purchaseType){
					
					 case 1:
						$purchaseString=$this->lang->line('shipment');
					 break;
					 
					 case 2:
						$purchaseString=$this->lang->line('download');
					 break;
					 
					 case 3:
						$purchaseString=$this->lang->line('payPerView');
					 break;
					 
					 case 4:
						$purchaseString=$this->lang->line('donate');
					 break;
					 
				  }
				 
				 $tsCommission = $item->tsCommissionValue;
				 $title = (isset($item->title)) ? $item->title : '' ;
				 $basePrice = (isset($item->itemValue)) ? $item->itemValue : 0; 
				 
				 
				 
				 if($purchaseType==4){
					 $basePrice = $item->basePrice;
				 }
				
				 $description = (isset($item->description)) ? $item->description :'';				 	
				 $image = $item->image;	
				 $shippingPrice	= 	$item->shipping;
				 
				 $tsCommissionValue  = $item->tsCommissionValue;
				 $tsVatValue         = $item->tsVatValue; 				 
				 $productPrice = $basePrice + $shippingPrice + $tsCommissionValue + $tsVatValue   ;				  				 
								
								 
				
				 		 
							 
				 
				 $taxPercent =  $item->taxPercent;
				 $taxName = $item->taxName;
				 $currency  = $item->ordCurrency;						 
				 $selectcurrency = ($currency==1) ?'$':'€';						
				 $taxName = ($taxName!='') ? $taxName : '';
				 
				
				 
				 
					if($taxPercent!=0){
						
							$taxName= $taxName;
							$taxPercentage= $taxPercent;
							if($purchaseType==4){ //donate
								 $vatPrice = ($item->itemValue*$taxPercentage)/100;
							}else{
								$vatPrice = ($basePrice*$taxPercentage)/100;
							}
							$productPrice = $productPrice + $vatPrice;
							$isShow="yes";
						 
						}else {
							$taxName= $taxName;
							$taxPercentage = 0;
							$isShow="no";
							$vatPrice = 0;							
						}
						
						$cartTotal = $cartTotal + $productPrice;				 
				 
				 ?>		    
		     
            <div class="SCart_item_list_box mt18 ml28 pb25" id="wishllistitem_<?php echo $i ?>">
              <div class="SCart_item_left width500px">
                <div class="SCart_item_inner height176 position_relative">
                <div class="SCart_item_fixed_checkbox dn"><div class="defaultP">
                <input type="checkbox" id="item_<?php echo $i ?>" name="wishlistitem[<?php echo $wishlistId ?>]"  value="<?php echo $productPrice ?>" <?php echo $checked ?>  onclick="calculatePrice('<?php echo $i ?>')" class="productpricechk" />
                
              </div></div>
                  <div class="SCart_item_thumb mt21 mb20 ml20"><img src="<?php echo $image ?>" /></div>
                  <div class="Fleft mt21 width_298 ml46">
                    <div class="font_opensansSBold font_size14 clr_444 pb15 oh"> 
						<?php echo $title; if($purchaseString != '') echo '<div class="f11 orange">&nbsp;('.$purchaseString.')</div>'; ?>
					</div>
                    <p class=" font_opensans clr_444 height_36 oh"><?php echo $description ?> </p>
                    <p class=" font_opensans pt20 <?php echo $paymentClass?>"><?php echo $paymentString ?> </p>
                  </div>
                </div>
              </div>
              <div class="Thirdparty_item_price_new mt7">
                <div class="row bdrB_f4a78d height24 pt2">
                  <div class="title">Price </div>
                  <div class="price"><?php echo $selectcurrency.'&nbsp;'.number_format($basePrice,2) ?></div>
                </div>
                <?php  if($isShow=="yes") {?>
                <div class="row bdrB_f4a78d height24 pt2">
                  <div class="title"><span class="inline clr_999 pr10"><?php echo $taxName; ?></span> <?php echo $taxPercentage; ?>%</div>
                  <div class="price"><?php echo $selectcurrency.'&nbsp;'.number_format($vatPrice,2) ?></div>
                </div>   
                             
                <?php } else { ?>
					
					 <div class="row bdrB_f4a78d height24 pt2">
                     <div class="title"><span class="inline clr_999 pr10"><?php echo $taxName; ?></span></div>
                      <div class="price"> ..... </div>
                   </div>					
					
				<?php } ?>
               
               <input type="hidden" name="vatprice" value="<?php $vatPrice ?>">                
                 
               <?php  if($shippingPrice!=0) { ?>
                  
                <div class="row bdrB_f4a78d height24 pt2">
                  <div class="title">Shipping Cost</div>
                  <div class="price"><?php echo $selectcurrency.'&nbsp;'. number_format($shippingPrice,2) ?></div>
                </div>
                
                <?php } else {?>
                
                 <div class="row bdrB_f4a78d height24 pt2">
                  <div class="title">Shipping Cost</div>
                  <div class="price"> ..... </div>
                </div>                
                <?php } ?>
                
                <div class="row bdrB_f4a78d height24 pt2">
                  <div class="title">Toadsquare Service Fee</div>
                  <div class="price"><?php echo $selectcurrency.'&nbsp;'. number_format($tsCommissionValue,2) ?></div>
                </div>
                
                <div class="row bdrB_f4a78d height24 pt2">
                  <div class="title">VAT on Service Fee</div>
                  <?php if($tsVatValue>0){ ?>
                    <div class="price"><?php echo $selectcurrency.'&nbsp;'. number_format($tsVatValue,2) ?></div>
                  <?php } else { ?>
                   <div class="price"> .....</div>                  
                   <?php } ?>
                </div>
                
                <div class="row bdrB_f4a78d height24 pt2">
                  <div class="title b underline">Total</div>
                  <?php if($productPrice>0){ ?>
                    <div class="price b underline"><?php echo $selectcurrency.'&nbsp;'. number_format($productPrice,2) ?></div>
                  <?php } else { ?>
                   <div class="price"> .....</div>                  
                   <?php } ?>
                </div>
                
                
              </div>
              <div class="clear"></div>
            </div>
            <!--list_box-->
				<?php $i++; 
			}       
         
            ?>  
           
            
            	 <div class="seprator_10"> </div>
            	<div class="SCart_sep_shadow mb6">
                </div>
                
              <div class="Fright clr_666">
              <div class="Fleft mr36 text_alignR font_opensans font_size13 width_310">
				<div class="row pb_41 font_opensansSBold font_size18"><span class="width_165 Fleft pr16">Cart Total</span> <span class=" width_90 Fright pr5 " id="cartTotal"><?php echo $selectcurrency.'&nbsp;'. number_format($cartTotal,2) ?></span> </div>
              </div>
              <div class="clear"></div>
            </div>  
            
            
            
            <div class="clear"></div>
            <div class="seprator_32"></div>
            </div>
			
			<div class="fr">
            <div class="detailPaymentbg position_relative">
				  <div class="cell shadow_wp strip_absolute left-57 mt-65">
					<!-- <img src="images/strip_blog.png"  border="0"/>-->
					<table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%" class="minH280">
					  <tbody>
						<tr>
						  <td height="59"><img src="<?php echo base_url('images/shadow-top-small.png')?>"></td>
						</tr>
						<tr>
						  <td class="shadow_mid_small minH280">&nbsp;</td>
						</tr>
						<tr>
						  <td height="63"><img src="<?php echo base_url('images/shadow-bottom-small.png')?>"></td>
						</tr>
					  </tbody>
					</table>
					<div class="clear"></div>
				  </div>
				<div class="clear"></div>
            </div> <!-- /detailbg -->
             <div class="clear"></div>
             <div class="seprator_24"> </div>
            </div>
            
			<?php
      }?>     
            
            
              
           </div>
            <div class="clear"></div>
            
             
          </div>

          </div>
          <div class="seprator_20"></div>
        </div>
