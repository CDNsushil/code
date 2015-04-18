<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
'name'=>'wishlist',
'id'=>'wishlist'
); ?>

        <div class="bg_fffaee cart_pattern">
          <div class="seprator_6"></div>
          <div class="cart_top_header ml6 mr6">
            
          <div class="CSEprise_pattern">
              <div class="cart_top_header_heading">Shopping Cart </div>
              <div class="cart_main_nav_box"> 
               <a class="ml40">
                <div class="CMN_count">1</div>
                <div class="ml60 mt9 mr30">Confirm Billing Details</div>
                </a>
                <a class="ml40">
                <div class="CMN_count">2</div>
                <div class="ml60 mt9 mr30">Summary</div>
                </a>
                
                 <a class="ml40 selected">
                <div class="CMN_count">3</div>
                <div class="ml60 mt9 mr30">Confirm Purchase</div>
                </a> <a class="ml40">
                <div class="CMN_count">4</div>
                <div class="ml60 mt9 mr30">Payment</div>
                </a> </div>
              <div class="clear"></div>
            </div>  
            
            
            
            
          </div>
          <div class="seprator_25"></div>
          <div class="cart_container_outer ">
          <div class="cart_container_thrirdparty">
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
            <!--list_box-->
 <?php echo form_open(base_url_secure(lang().'/cart/checkout'),$formAttributes);            
     if(isset($basketItems) && is_array($basketItems) && count($basketItems)>0 ) {
		     $cartTotal = 0;
		     $i=1;
		     foreach ($basketItems as $key =>$item) {
				
				 $title = $item[0]->title;
				 $basePrice = $item[0]->price; 
				 $description = $item[0]->description;
				 //$cartTotal = $cartTotal +  $basePrice;	
				 $image = $item['image'];	
				 $shippingPrice	= 	$item['shippingPrice']; 				 
				 $productPrice = $basePrice + $shippingPrice ;
				 
				 $wishlistId = $item['wishlistId']; 			 
				 
				 $checked = ($i<=2) ? 'checked="checked"' : '';					   
				 
				 ?>
					    
		     
            <div class="SCart_item_list_box mt18 ml28 pb25" id="wishllistitem_<?php echo $i ?>">
              <div class="SCart_item_left width500px">
                <div class="SCart_item_inner height_139 position_relative">
                <div class="SCart_item_fixed_checkbox dn"><div class="defaultP">
                <input type="checkbox" id="item_<?php echo $i ?>" name="wishlistitem[<?php echo $wishlistId ?>]"  value="<?php echo $productPrice ?>" <?php echo $checked ?>  onclick="calculatePrice('<?php echo $i ?>')" class="productpricechk" />
                
              </div></div>
                  <div class="SCart_item_thumb mt21 mb20 ml20"><img class="min_height64" src="<?php echo $image ?>" /></div>
                  <div class="Fleft mt21 width_298 ml46">
                    <div class="font_opensansSBold font_size14 clr_444 pb15 oh height_20"><?php echo $title ?></div>
                    <p class=" font_opensans clr_444 height_36 oh"><?php echo $description ?> </p>
                  </div>
                </div>
              </div>
              <div class="Thirdparty_item_price mt7">
                <div class="row pt11 bdrB_f4a78d height_30">
                  <div class="title">Price</div>
                  <div class="price"><?php echo '$'. $basePrice ?></div>
                </div>
                <div class="row pt11 bdrB_f4a78d height_30">
                  <div class="title"><span class="inline clr_999 pr10">Consumption tax</span> VAT 10%</div>
                  <div class="price">$ 0</div>
                </div>
                <div class="row pt11 bdrB_f4a78d height_30">
                  <div class="title">Shipping Cost</div>
                  <div class="price"><?php echo  $shippingPrice ?></div>
                </div>
              </div>
              <div class="clear"></div>
            </div>
            <!--list_box-->
  <?php $i++; }       
           } else {			   
					echo '<div class=" p10 mt20 font_opensansSBold font_size18">No Record </div>';			   
			   } ?>              
            
            <div class="seprator_16"></div>
            <div class="SCart_sep_shadow mb6"></div>
            <div class="Fright font_opensansSBold font_size18">
              <div class="width_126 Fleft mr36 text_alignR">
                <div><span class="inline ">Total</span></div>
                <div class="seprator_25"></div>
                
              </div>
              <div class="Fleft mr30 width_116 text_alignC">
                <div ><span class="inline" id="cartTotal"><?php echo '$ 0'  ; ?></span></div>
                <div class="seprator_25"></div>
                <div class="tds-button-orange ml3"> <a onclick="checkout();" onmousedown="mousedown_tds_button_orange(this)" onmouseup="mouseup_tds_button_orange(this)" ><span class=" font_OpenSansBold width_90" >CHECKOUT</span></a> </div>
              </div>
              <div class="clear"></div>
            </div>
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
	  $('#cartTotal').html('$' + totalPrice); 	  	
 });


 // When cicked on checkbox	
 function calculatePrice(id){
	 allowUserToCheck(id);	
	 var totalPrice = getTotalPrice();		
	 $('#cartTotal').html('$' + totalPrice);
	 
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
   // $("#productCart").attr('action','<?php echo base_url(lang()."/cart/buynow")?>');      
	$("#wishlist").submit();
	
 }  



</script>
