<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
'name'=>'wishlist',
'id'=>'wishlist'
);
$thirdPartyCartId=$this->session->userdata('thirdPartyCartId');

//echo "<pre/>";
//print_r($basketItems);

	?>
        <div class="bg_white">
          <div class="seprator_6"></div>
          <div class="cart_top_header ml6 mr6">
            <div class="CSEprise_pattern">
              <div class="cart_top_header_heading">Shopping Cart </div>
              <div class="cart_main_nav_box"> 
               <a class="ml40">
                <div class="CMN_count">1</div>
                <div class="ml60 mt9 mr30">Confirm Billing Details</div>
                </a>
                                
                 <a class="ml40 selected">
                <div class="CMN_count">2</div>
                <div class="ml60 mt9 mr30">Confirm Purchase</div>
                </a> <a class="ml40">
                <div class="CMN_count">3</div>
                <div class="ml60 mt9 mr30">Payment</div>
                </a> </div>
              <div class="clear"></div>
            </div>
          </div>
          <div class="seprator_25"></div>
            <div class="cart_container_outer ">
          <div class="cart_container_thrirdparty bg_dashbord_gred">
          <div class="overflow_hidden position_relative">
<?php $itemCount = ( (isset($basketItems)) && count($basketItems)>0 ) ? count($basketItems) : 0; 
  if($itemCount > 0) { ?>			  
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
     <?php } ?>       
            <!--list_box-->
            <div class="seprator_5"> </div>
     <div id="currentCurrency" class="dn"><?php  $selectcurrency = ($currency==1) ?'$':'€';	 echo $selectcurrency; ?></div> 
   
  <?php
    if($itemCount==0) {	 
	 	// redirect(base_url(lang().'/home'));
	 }    ?>  
	   
   <?php echo form_open(base_url_secure(lang().'/cart/checkout'),$formAttributes);            
     if(isset($basketItems) && is_array($basketItems) && count($basketItems)>0 ) {
		 
		//	$cartTotal = 0;
		     $i=1;
		     $isShippingDetails=false;
		     foreach ($basketItems as $key =>$item) {
				 				 
				 
				 $purchaseType = $item['purchaseType'];
				 $entityId = $item['entityId'];
				 if($purchaseType==1){
					 $isShippingDetails=true;
				 }
				 $tsCommission = $item['tsCommissionValue'];
				 $title = (isset($item[0]->title)) ? $item[0]->title : '' ;
				 $basePrice = (isset($item['itemValue'])) ? $item['itemValue'] : 0; 
				 
				 if($purchaseType==4){
					 $basePrice = $item['basePrice'];
				 }
				 
				 $isFree=0;
				 if(isset($item['sellerInfo']->isFree)){
					  $isFree=$item['sellerInfo']->isFree;
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
					 
					 case 5:
						if(isset($item['sellerInfo']->ticketcategory)){ 
							$purchaseString=$item['sellerInfo']->ticketcategory;
						}
					 break;
				  }
				 
				 $description = (isset($item[0]->description)) ? $item[0]->description :'';				 	
				 $image = $item['image'];	
				 $shippingPrice	= 	$item['shippingPrice'];
				 
				 $tsCommissionValue  = $item['tsCommissionValue'];
				 $tsVatValue         = $item['tsVatValue']; 				 
				 $productPrice = $basePrice + $shippingPrice + $tsCommissionValue + $tsVatValue   ;				  				 
								
								 
				 $wishlistId = $item['wishlistId'];				 
				 $checked = ($i<=0) ? 'checked="checked"' : '';					 
				 
				 $consumptionTaxPer =  $item['consumptionTaxPer'];
				 $consumptionTaxName = $item['consumptionTaxName'];
				 $purchaseType = $item['purchaseType'];	
				 
				 $currency  = $currency;						 
				 $selectcurrency = ($currency==1) ?'$':'€';						
				 $consumptionTaxName = ($consumptionTaxName!='') ? $consumptionTaxName : '';
				 $toggleClass = ($i>7) ? "toggle dn" : '';
				 
					if($consumptionTaxPer!=0){
						
							$taxName= $consumptionTaxName;
							$taxPercentage= $consumptionTaxPer;
							if($purchaseType==4){ //donate
								 $vatPrice = ($item['itemValue']*$taxPercentage)/100;
							}else{
								$vatPrice = ($basePrice*$taxPercentage)/100;
							}
							$productPrice = $productPrice + $vatPrice;
							$isShow="yes";
						 
						}else {
							$taxName= $consumptionTaxName;
							$taxPercentage = 0;
							$isShow="no";
							$vatPrice = 0;							
						}
						
						 $sendpaypal = $item['sendpaypal'];
						//$cartTotal = $cartTotal + $productPrice;				 
						$cartTotal = $cartGrandTotal;				 
				 ?>		    
		     
            <div class="SCart_item_list_box mt18 ml28 pb25 <?php echo $toggleClass ?> " id="wishllistitem_<?php echo $i ?>">
              <div class="SCart_item_left width500px">
                <div class="SCart_item_inner height_139 position_relative">
                <div class="SCart_item_fixed_checkbox dn"><div class="defaultP">
                <input type="checkbox" id="item_<?php echo $i ?>" name="wishlistitem[<?php echo $wishlistId ?>]"  value="<?php echo $productPrice ?>" <?php echo $checked ?>  onclick="calculatePrice('<?php echo $i ?>')" class="productpricechk" />
                
              </div></div>
                  <div class="SCart_item_thumb mt21 mb20 ml20"><img src="<?php echo $image ?>" /></div>
                  <div class="Fleft mt21 width_298 ml46">
                    <div class="font_opensansSBold font_size14 clr_444 pb15 oh">
						<?php echo $title; if($purchaseString != '') echo '<div class="f11 orange">&nbsp;('.$purchaseString.')</div>'; ?>
                    </div>
                    
                    <p class=" font_opensans clr_444 height_36 oh"><?php echo $description ?> </p>
                  </div>
              <?php if($sendpaypal=='f'){ ?>      
                 <div class="fr orgLabel pr10 mt5"> The seller is not shipping to your area</div>  
               <?php } ?>   
              </div> 
              </div>
              <div class="Thirdparty_item_price_new mt7">
                <div class="row height_25">
                  <div class="title">Price </div>
                  <div class="price"><?php echo $selectcurrency.'&nbsp;'.number_format($basePrice,2) ?></div>
                </div>
                <?php  if($isShow=="yes") {?>
                <div class="row height_25">
                  <div class="title"><span class="inline pr10"><?php echo $taxName; ?></span> <?php echo $taxPercentage; ?>%</div>
                  <div class="price"><?php echo $selectcurrency.'&nbsp;'.number_format($vatPrice,2) ?></div>
                </div>   
                             
                <?php } else { ?>
					
					 <div class="row height_25">
                     <div class="title"><span class="inline pr10"><?php echo $taxName; ?></span></div>
                      <div class="price"> ..... </div>
                   </div>					
					
				<?php } ?>
               
               <input type="hidden" name="vatprice" value="<?php $vatPrice ?>">                
                 
               <?php  if($shippingPrice!=0) { ?>
                  
                <div class="row bdrB_9C9C99 height_25">
                  <div class="title">Shipping Cost</div>
                  <div class="price"><?php echo $selectcurrency.'&nbsp;'. number_format($shippingPrice,2) ?></div>
                </div>
                
                <?php } else {?>
                
                 <div class="row bdrB_9C9C99 height_25">
                  <div class="title">Shipping Cost</div>
                  <div class="price"> ..... </div>
                </div>                
                <?php } ?>
                
                <div class="row height_25 pt5">
                  <div class="title"><div class="inline orange">* </div>Toadsquare Service Fee</div>
                  <div class="price"><?php echo $selectcurrency.'&nbsp;'. number_format($tsCommissionValue,2) ?></div>
                </div>
                
                <div class="row bdrB_f4a78d height_25">
                  <div class="title">VAT on Service Fee</div>
                  <?php if($tsVatValue>0){ ?>
                    <div class="price"><?php echo $selectcurrency.'&nbsp;'. number_format($tsVatValue,2) ?></div>
                  <?php } else { ?>
                   <div class="price"> .....</div>                  
                   <?php } ?>
                </div>
                
                
              </div>
              <div class="clear"></div>
            </div>
            <!--list_box-->
  <?php $i++; }       
           } else {			   
					echo '<div class=" tac p10 mt20 font_opensansSBold font_size18">No Record </div>';			   
			   } ?>  
           <?php if($itemCount>0){ ?>
             <div class="font_opensansSBold font_size11 mt2 Fleft pl25 width_577  orange">* The Toadsquare Service Fee is not refundable. </div>
            <?php } ?> 
            	<div class="seprator_16"></div> 
             <div class="clear"></div>
            	<div class="SCart_sep_shadow mb6">
                <div class="extract_button_box  Fleft fl ml_435 mt_minus10">
					<?php if($itemCount>=3){ ?>
                      <div class="small_btn"><a><div class="cat_smll_add_icon"></div></a></div>
                    <?php } ?>
           		 </div>
                </div>
         <?php if($itemCount>0){ ?>       
            <div class="Fright clr_666">
              <div class="Fleft mr36 text_alignR font_opensans font_size13 width_310">

			<div class="row pb_41 font_opensansSBold font_size18"><span class="title cell ml83">Cart Total</span> <span class="price fr" id="cartTotal"><?php echo $selectcurrency.'&nbsp;'. number_format($cartTotal,2) ?></span> </div>

                   
              </div>
              <div class="clear"></div>
            </div>
          <?php } ?>  
            
            <div class="clear"></div>
            <div class="seprator_32"></div>
            </div>
            
            <div class="fl ml40">
              <div class="seprator_258"></div>
              <?php
				if($isShippingDetails){
					  $changeUrl=base_url(lang().'/cart/confirmbilling/1');
				  }else{
					  $changeUrl=base_url(lang().'/cart/confirmbilling/2');
				  } 
              ?>
              
              </div>
            
            <div class="fr">
            <div class="detailbg position_relative">
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
          
           <?php
               if($billingDetail->billing_state!=''){
               $billingStateName = getstateName($billingDetail->billing_state);
               } else { $billingStateName=''; }
               
               if($billingDetail->shipping_state!=''){
               $shippingStateName = getstateName($billingDetail->shipping_state);
		       }else { $shippingStateName=''; }           
            ?> 
        
        	<div class="fl widht_230 bg_white pt20 pr15 pb20 pl15 bsdetailbdr mr34"> 
            	<div class="font_museoSlab font_size24 clr_444 bdr_898989"> Billing Details</div>
                <div class="seprator_30"> </div>
                <div class="lineH24 pl15"><?php echo $billingDetail->billing_firstName.' '.$billingDetail->billing_lastName; ?>  <br>
                <?php echo $billingDetail->billing_address1; ?><br>
                <?php echo $billingDetail->billing_city .', '. $billingStateName; ?><br>
                
                <?php echo $billingDetail->billing_zip; ?><br>
                <?php echo $billingCountry = (isset($billingDetail->countryName)) ? $billingDetail->countryName :''; ?><br> 
                <?php echo $billingDetail->billing_email; ?><br>
                <?php echo $billingDetail->billing_phone; ?>
                </div>                  
            </div>
            
           <?php 
           if($isShippingDetails){ ?> 
			   <div class="fl widht_230 bg_white pt20 pr15 pb20 pl15 bsdetailbdr"> 
					<div class="font_museoSlab font_size24 clr_444 bdr_898989"> Shipping Details</div>
					<div class="seprator_30"> </div>
				   <div class="lineH24 pl15"><?php echo $billingDetail->shipping_firstName.' '.$billingDetail->shipping_lastName; ?>  <br>
					<?php echo $billingDetail->shipping_address1; ?><br>
					<?php echo $billingDetail->shipping_city .', '. $shippingStateName; ?><br>
					
					<?php echo $billingDetail->shipping_zip; ?><br>
					<?php echo $billingCountry = (isset($billingDetail->shippingcountryname)) ? $billingDetail->shippingcountryname :''; ?><br> 
					<?php echo $billingDetail->shipping_email; ?><br>
					<?php echo $billingDetail->shipping_phone; ?>
					</div>   
				</div> <?php 
            } ?>
             
             <div class="clear"></div>
             <div class="seprator_10"> </div>
             <div class="tds-button-change mt5"> <a href="<?php echo $changeUrl; ?>" onmouseup="mouseup_tds_button_change(this)" onmousedown="mousedown_tds_button_change(this)"><span class=" font_opensansSBold width_60">Modify</span></a> </div> 
             <div class="clear"></div>
             
             <?php if ($cartTotal>1){ ?>
				 <div class="pt20">
						<div class="defaultP">
								<input type="checkbox" name="termsNCond"  value="" <?php //echo $checked ?>  onclick="showPaypal();" class="productpricechk" />
								<div class="inline pl10 "> I acknowledge to have read, understood and agreed the <a class= "underline dash_link_hover" target="_blank" href="<?php echo base_url(lang().'/cms/termsncondition') ?>"> Terms & Conditions  </a> of the Toadsquare &nbsp;&nbsp; &nbsp;&nbsp;website. </div>
							</div>    
							<div class="fr"><a class="underline dash_link_hover" target="_blank" href="<?php echo base_url(lang().'/cms/downloadtandc') ?>">Download the Terms of Services in PDF.</a></div>         
				  </div>
             <?php } ?>
            </div> <!-- /detailbg -->
            
             <div class="clear"></div>
             <div class="seprator_24"> </div>
             <?php
             if($isFree){ ?>
				 <div class="fr pr30">
					<div class="tds-button-orange ml3"> <a href="<?php echo base_url(lang().'/payment/saveOrderDetails/'.$trackingId.'/1')?>" onmouseup="mouseup_tds_button_orange(this)" onmousedown="mousedown_tds_button_orange(this)"><span class=" font_OpenSansBold width_90">CHECKOUT</span></a> </div>
				 </div>
				<?php
			  }else{ ?>
				  <div class="fl font_opensansSBold ml20">Pay securely using PayPal</div>
				  <div class="fl ml24"> <img src="<?php echo base_url('images/paypal_logo.png')?>" /> </div>
				  
				<?php if($cartTotal>1){ ?>  
				  <div class="tds-button-orange Fright mr40 mt_minus5 dn" id='paypalButton'> <a href="<?php echo base_url(lang().'/cart/sendPaypalData') ?>" onmousedown="mousedown_tds_button_orange(this)" onmouseup="mouseup_tds_button_orange(this)" ><span class=" font_OpenSansBold width_90" >Pay Now</span></a> </div>
				  
				  <div class="tds-button-orange Fright mr40 mt_minus5 opacity_4"id='sendPaypalButton'> <a href="javascript:void(0)" onmousedown="mousedown_tds_button_orange(this)" onmouseup="mouseup_tds_button_orange(this)" ><span class=" font_OpenSansBold width_90" >Pay Now</span></a> </div>
				  
				 <?php }else { ?> 
				   <div class="tds-button-orange Fright mr40 mt_minus5"> <a href="<?php echo base_url(lang().'/cart/wishlist') ?>" onmousedown="mousedown_tds_button_orange(this)" onmouseup="mouseup_tds_button_orange(this)" ><span class=" font_OpenSansBold" >Continue Shopping</span></a> </div>
				<?php  } 
				
			  }
             ?>
             </div>
              
              <div class="font_opensansSBold font_size11 mt2 Fleft width_577 pl10">*  You need a PayPal account to buy from third-party Sellers.</div>
            <!--  <div class="font_opensansSBold font_size11 mt2 Fleft width_577 pl10">* Consumption Tax (VAT, GST, Sales Tax etc.) will be added, if applicable, as you checkout.</div>
              <div class="font_opensansSBold font_size11 mt2 Fleft width_577 pl10">* The Shipping Charge, set by the Seller, will be added to the Product price as you checkout.</div>
              --->
              
            <div class="clear"></div>
             <div class="seprator_20"></div>
             
          </div>

          </div>
          <div class="seprator_20"></div>
        </div>
        <!--front_end_mani_content_wp-->
  <?php echo form_close(); ?>     
<script>
	
	
 $(document).ready(function(){		
 	 // var totalPrice = getTotalPrice();	
 	 // var currentCurrency = $('#currentCurrency').html();	
	 // $('#cartTotal').html(currentCurrency+' '+ totalPrice);	  	
 });


 // When cicked on checkbox	
 function calculatePrice(id){
	 allowUserToCheck(id);	
	 var totalPrice = getTotalPrice();	 
	 var currentCurrency = $('#currentCurrency').html(); 		
	 $('#cartTotal').html(currentCurrency+' '+ totalPrice);
	 
	 itemtotal = checkedCount();
	 $('.itemtotal').html(itemtotal);
	 		
   }

// Calculate product price
function getTotalPrice(){	
	var val = [];
	var totalProductsPrice=0;
		
	$('.productpricechk:checked').each(function(i){			
		val[i] = parseFloat($(this).val());			   
		totalProductsPrice = (totalProductsPrice +  val[i]);							
	    totalProductsPrice;
	}); 	
	 return totalProductsPrice.toFixed(2);	
 }
 
 
 
  // Allow how many checkbox user can check*/
  function  allowUserToCheck(id){	
    var max_allowed = 2;    
    var checked = $("input:checked").size(); 
   
    if ( checked > max_allowed ) {        
		$('#item_'+id).prop("checked", false);     
        alert("Please select a maximum of " + max_allowed + " options.");
 
       }			
   }
 
 
 
 
 // check count on load
 function checkedCount(){	
	var val = [];
	var count=0;		
	$('.productpricechk:checked').each(function(i){	
		val[i] = 1;		
		count = count + val[i];			
	}); 		
	 return count;	
 }

 
  // Continue Shopping  
 function checkout(){
	 alert('aa');return false;
   // $("#productCart").attr('action','<?php echo base_url(lang()."/cart/buynow")?>');      
	$("#wishlist").submit();
	
 }  

$(".cat_smll_add_icon").click(function () {
$(this).parent().parent().parent().parent().parent().parent().parent().find('.toggle').slideToggle("slow");
//$(".toggle").toggle('fast');
if($(this).css("background-position")=='3px -25px'){
		$(this).css("background-position","3px -38px")
		
	}else{
		$(this).css("background-position","3px -25px");
		
	}
}); 



function mousedown_tds_button_orange(obj){
obj.style.backgroundPosition ='0px -76px';
obj.firstChild.style.backgroundPosition ='right -76px';
}
function mouseup_tds_button_orange(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}



// When cicked on checkbox	
 function showPaypal(){	
	var checked = $("input:checked").size();
	
	if(checked==true){
	  $('#paypalButton').removeClass('dn');
	  $('#sendPaypalButton').addClass('dn');
    }else{
	   $('#paypalButton').addClass('dn');
	    $('#sendPaypalButton').removeClass('dn');		
	  }  
   }







</script>
