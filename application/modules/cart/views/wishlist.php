<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
'name'=>'wishlist',
'id'=>'wishlist'
);

$thirdPartyCartId=$this->session->userdata('thirdPartyCartId');	?>


<div id="WishlistYesNo" class="customAlert" style="display:none; width:260px;z-index:999999;">	
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>		
	<div class="row">
		<div class="cell mb20  font_size15">You must select atleast one Product</div> 
	</div>
	<div class="row">		
		<div class="ml25">
			<div class="tds-button fr pl20">
				<?php echo anchor('javascript://void(0);', '<span>OK</span>',array('onclick'=>"$(this).parent().trigger('close');",'onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
	</div>
</div>	



        <div class="bg_white">
          <div class="seprator_6"></div>
          <div class="cart_top_header ml6 mr6">
            <div class="CSEprise_pattern">
              <div class="cell">
                <div class="cart_top_header_heading">Shopping Cart </div>
                
                <?php  if($currency==1){					
						 $selectedMenuDollar = 'selected';
						 $selectedMenuEuro = '';
						 $selectcurrency = '$';					
					} else{
						   $selectedMenuEuro = 'selected';
						   $selectedMenuDollar = '';
						   $selectcurrency = '€';						
						} ?>
                
                <div class="cart_main_nav_box"> <a class="ml40 sale_hover <?php echo  $selectedMenuDollar ?>" href="<?php echo base_url(lang().'/cart/wishlist/dollar') ?>">
                  <div class="CMN_count">$</div>
                  <div class="ml46 mt9 mr8">Cart</div>
                  </a> <a class="ml40 sale_hover <?php echo  $selectedMenuEuro ?>" href="<?php echo base_url(lang().'/cart/wishlist/euro') ?>">
                  <div class="CMN_count">€</div>
                  <div class="ml46 mt9 mr8">Cart</div>
                  </a> </div>
              </div>
 <?php $countBasketItems = (isset($basketItems) && is_array($basketItems) ) ? count($basketItems) : 0 ;
 
 if($countBasketItems==0) {	 
	 	 //redirect(base_url(lang().'/home'));
	  }
 ?>             
              <div class="Fright">
				 
                
                <div class="SCart_subMenu_outer mt10 mr10">
                  <div class="SCart_subMenu_inner">
                    <ul>
                      <li><a href="<?php echo base_url('cart/sales'); ?>">Sales</a></li>
                      <li><a href="<?php echo base_url('cart/purchase'); ?>">Purchases</a></li>
                      <li><a href="<?php echo base_url('cart/wishlist'); ?>" class="selected">Cart</a></li>
                    </ul>
                  </div>
                </div>
               
               
                <div class="seprator_30"></div>
                <div class="font_opensans font_size14 clr_white Fright mr20 ">You can checkout up to 5 items at a time: <div class="itemtotal inline"> <?php echo $countBasketItems ?></div>/<div class="itemtotala inline">5 selected </div></div>
              </div>
              <div class="clear"></div>
            </div>
          </div>
          <div class="seprator_25"></div>
          <div class="cart_container_outer ">
          <div class="cart_container_thrirdparty bg_dashbord_gred">
	 <?php echo form_open(base_url(lang().'/cart/checkout'),$formAttributes);            
     if(isset($basketItems) && is_array($basketItems) && count($basketItems)>0 ) { ?>		  
			  
            <div class="cell shadow_wp strip_absolute_right right_140">
              <!-- <img src="images/strip_blog.png"  border="0"/>-->
              <table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%">
                <tbody>
                  <tr>
                    <td height="271"><img src="<?php echo base_url('images/line-top.png')?>"></td>
                  </tr>
                  <tr>
                    <td class="line_mid">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="271"><img src="<?php echo base_url('images/line-bottom.png') ?>"></td>
                  </tr>
                </tbody>
              </table>
              <div class="clear"></div>
            </div>
    <div id="currentCurrency" class="dn"><?php echo $selectcurrency ?></div>        
            <!--list_box-->
<?php
		     $cartTotal = 0;
		     $i=1;
		     foreach ($basketItems as $key =>$item) {
				 
				 
				 $displayPrice = $item['displayPrice'];
				 $tsCommission = $item['tsCommissionValue'];
				 $title = $item[0]->title;
				 $basePrice = $item['itemValue'];
				 $description = $item[0]->description;
				 $aviliableqty = $item[0]->aviliableqty;
				 //$cartTotal = $cartTotal +  $basePrice;	
				 $image = $item['image'];	
				 $shippingPrice	= 	$item['shippingPrice'];
				 $tsCommissionValue  = $item['tsCommissionValue'];
				 $tsVatValue         = $item['tsVatValue']; 				 
				 $productPrice = $basePrice + $shippingPrice + $tsCommissionValue + $tsVatValue   ;
				
				 $purchaseType = $item['purchaseType'];
				$purchaseString='';
				
				$isAvailable=true;
				
				 switch($purchaseType){
					 case 1:
						$purchaseString=$this->lang->line('shipment');
						if(!($aviliableqty >=1)){
							$isAvailable=false;
						}
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
				 
				 $wishlistId = $item['wishlistId']; 			 
				 
				 $checked = ($i<=0) ? 'checked="checked"' : '';		
				 			   
				$consumptionTaxPer =  $item['consumptionTaxPer'];
				$consumptionTaxName = $item['consumptionTaxName'];
				$purchaseType = $item['purchaseType'];
				
				if($purchaseType==2){				
					$type = "Download";					
				}else if($purchaseType==3){
					$type = "Pay Per View";				
				}else {					
					$type = "Shipment";	
				} 		
				
				
				 if($consumptionTaxPer!=0)
					{
						$taxName= $consumptionTaxName;
						$taxPercentage= $consumptionTaxPer;
						$vatPrice = ($basePrice*$taxPercentage)/100;
						$productPrice = $productPrice + $vatPrice;
						$isShow="yes";
					 
					}else { 
						$taxName= $consumptionTaxName;
						$taxPercentage = 0;
						$isShow="no";						
					}
				 
				 $redBorder=''; 
				 if(!$isAvailable){
					$redBorder='redBorder1px'; 
				 }
				 ?>
					    
		     
            <div class="SCart_item_list_box mt18 ml28 pb25" id="wishllistitem_<?php echo $wishlistId; ?>">
              <div class="SCart_item_left width500px">
                <div class="SCart_item_inner min_height_139 position_relative">
                
                <div class="SCart_item_fixed_checkbox">
					<?php
					if($isAvailable){?>
						<div class="defaultP">
							<input type="checkbox" id="item_<?php echo $i ?>" name="wishlistitem[<?php echo $wishlistId ?>]"  value="<?php echo $productPrice ?>" <?php echo $checked ?>  onclick="calculatePrice('<?php echo $i ?>')" class="productpricechk" />
						</div>
						<?php
					}else{?>
						<div class="orgLabel pr10">NA</div>
						<?php
					}?>
                </div>
				
                  <div class="SCart_item_thumb mt21 mb20 ml20"><img src="<?php echo $image ?>" /></div>
                  <div class="Fleft mt21 width_298 ml46">
					<div class="font_opensansSBold font_size14 clr_444 pb15 oh">
						<?php echo $title; if($purchaseString != '') echo '<div class="f11 orange">&nbsp;('.$purchaseString.')</div>'; ?>
                    </div>
                    <p class=" font_opensans clr_444 height_36 oh"><?php echo $description ?> </p>
                    
                  </div>
					<div class="seprator_20 clear"></div>
					<div class="tds-button removeWishlist"> <a onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" onclick="deleteTabelRow('Wishlist','itemId','<?php echo $wishlistId;?>','','','#wishllistitem_','','','','','0','<?php echo $this->lang->line('deleteWishlistItem');?>');" ><span class=" font_opensansSBold"><?php echo $this->lang->line('remove');?></span></a> </div> 
                </div>
              </div>
              <div class="Thirdparty_item_price_new mt7">
                <div class="row height_25 pt2">
				  <div class="title">Price  </div>
                  <div class="price"><?php echo $selectcurrency.'&nbsp;'.number_format($basePrice,2) ?></div>
                </div>
                              
              <?php  if($isShow=="yes") {?>
                <div class="row height_25">
                  <div class="title"><span class="inline pr10"><?php echo $taxName; ?></span> <?php echo $taxPercentage; ?>%</div>
                  <div class="price"><?php echo $selectcurrency.'&nbsp;'.number_format($vatPrice,2) ?></div>
                </div>
                <?php } else { ?>
					
					 <div class="row height_25">
                     <div class="title"><span class="inline  pr10"><?php echo $taxName; ?></span></div>
                      <div class="price"> ..... </div>
                   </div>					
					
				<?php } ?>
                
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
                
                <div class="row  height_25 pt5">
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
  <?php $i++; }   ?>    
         <div class="font_opensansSBold font_size11 mt2 Fleft pl25 width_577  orange">* The Toadsquare Service Fee is not refundable. </div>
            <div class="seprator_16"></div> 
             <div class="clear"></div>
            <div class="SCart_sep_shadow mb6"></div>
            <div class="Fright font_opensansSBold font_size18">
              <div class="width_126 Fleft mr36 text_alignR">
                <div><span class="inline ">Total</span></div>
                <div class="seprator_25"></div>
                
              </div>
              
              <div class="Fleft mr30 width_116 text_alignC">
                <div class="text_alignR pr12">
					
					<span class="inline" id="cartTotal"><?php echo $selectcurrency.'&nbsp; 0' ; ?></span></div>
                <div class="seprator_25"></div>
              
                <div class="tds-button-orange ml3"> <a onclick="checkout();" onmousedown="mousedown_tds_button_orange(this)" onmouseup="mouseup_tds_button_orange(this)" ><span class=" font_OpenSansBold width_90" >CHECKOUT</span></a> </div>
             
              </div>
              <div class="clear"></div>
            </div>
      
  <?php    } else {			   
					echo '<div class="tac mt10 pt10 pb20 f16 orange_color"> </div>';			   
			   } ?>              
                      
             
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
 	  var totalPrice = getTotalPrice();	
 	  var currentCurrency = $('#currentCurrency').html(); 
 	  var checkCount = checkedCount();	
 	  $('.itemtotal').html(checkCount); 	
	  $('#cartTotal').html(currentCurrency+' '+ totalPrice); 	  	
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
    var max_allowed = 5;    
    var checked = $("input:checked").size(); 
   
    if ( checked > max_allowed ) {
		
		// Add code to remove class for chrome browser  
		$('#item_'+id).parent().removeClass("ez-checked");	
				  
		$('#item_'+id).prop("checked", false); 
		//$('#item_'+id).filter(':checkbox').removeAttr('checked');
		//$('#item_'+id).attr("checked", false);		
		//$('#item_'+id).prop({disabled: true});		    
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
	 var isCheckd = checkedCount();
	 if(isCheckd==0){
		customAlert('You must select at least one item.');		 
		return false;
		 }else {   
	       $("#wishlist").submit();
	      }
 }  

function mousedown_tds_button_orange(obj){
obj.style.backgroundPosition ='0px -76px';
obj.firstChild.style.backgroundPosition ='right -76px';
}
function mouseup_tds_button_orange(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}

</script>
