<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
'name'=>'cartSummary',
'id'=>'cartSummary'
);

$userId=isloginUser();
$cartId=$this->session->userdata('currentCartId');

$vatCharge = $vatCharge;
$cartId=$this->session->userdata('currentCartId'); ?>
  <div>
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
                
                <a class="ml40">
                <div class="CMN_count">3</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('summary'); ?></div>
                </a>
                
               <!--  <a class="ml40">
                <div class="CMN_count">4</div>
                <div class="ml52 mt9 mr12">Confirm Purchase</div>
                </a>-->
                
                 <a class="ml40 selected">
                <div class="CMN_count">4</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('payment'); ?></div>
                </a>
                
                
                 </div>
              <div class="clear"></div>
            </div>
          </div>
         
          <div class="seprator_25"></div>
          <div class="cart_container_outer ">
          	<div class="cart_container min_h558 pl30 pr30 pr30 pt20 pb20">
				
	<div id="paymentMessage" class="p40 lH21 tac">
				<div class="font_museoSlab font_size24 orange"><?php echo $this->lang->line('ThankPurchase');?></div>
            </div>			
				
    
<?php 
echo form_open(base_url('membershipcart/payments_pro/sendPaypalData'),$formAttributes);
//echo form_open(base_url(lang().'/membershipcart/saveOrder'),$formAttributes); 

if(isset($productDetails) && is_array($productDetails) && count($productDetails)>0) {
    $k=0;
    $cartTotal = 0;
    $itemno = 1;
	foreach ($productDetails as $key =>$item) {
						
	 //  $toggleClass = ($itemno>=3) ? "toggle dn" : '';
	   $toggleClass = '';
				
	   $cartItemId = $productDetails[$k]['cartItemId'];			
	   $size=bytestoMB($item[0]->size,'mb');
	   $size=number_format($size,0);  
	   
	   if(isset($item['extraSpace']->price) && ($item['extraSpace']->price!='')) {
	   $totalExtraPrice = number_format($item['extraSpace']->price,2);
	   $totalExtraSize = $item['extraSpace']->size; 
	   
	   $totalExtraSize=bytestoMB($totalExtraSize,'mb');
	   $totalExtraSize=number_format($totalExtraSize,0); 
	   
	   
       }else{
		     $totalExtraPrice =0;
	          $totalExtraSize  = 0;		   
		   }
	   
	           
           if(isset($totalExtraPrice) && $totalExtraPrice!=''){
			   $totalPrice =number_format(($totalExtraPrice + $item[0]->price),2);			   
			   $extraPrice =$totalExtraPrice;		   
			   } else {				   
				    $totalPrice = number_format($item[0]->price,2);
				    $extraPrice =0;
				   }
           
           if($vatCharge>0) {
			$vat = (($totalPrice*$vatCharge)/100) ;
			$priceAftrVat = ($totalPrice + $vat);
		   } else {
			   $vat = 0 ;
			   $priceAftrVat = ($totalPrice + $vat);			   
			   } 
             
             if($totalExtraSize){				
				$eSize=$totalExtraSize;                                    
				//$totalSize = number_format($eSize,0);
				$totalSize = $eSize;
				$totalSize = str_replace( ',', '', $totalSize );
				} else {  $totalSize='0'; }
             
                    
            // $cartTotal = $cartTotal + $priceAftrVat;            
            //  $totalSize = $totalSize + $size ;               
            $totalSize = $totalSize ;
             
           $purchaseType = ($item['purchaseType']!='') ? $item['purchaseType'] :'1';  
            $class = ""; 
            
   if($purchaseType==2){

		$vat = (($extraPrice*$vatCharge)/100) ;				 
		$priceAftrVat = $extraPrice +  $vat  ;
		$tSize = $item['extraSpace']->size;
		
		$tSize=bytestoMB($tSize,'mb');
		
		$totalSize = number_format($tSize,0);
		$totalSize = str_replace( ',', '', $totalSize );
		$class = "class = opacity_4";
	}                 
          
           $cartTotal = number_format(($cartTotal + $priceAftrVat),2);           
           $carTotal = (isset($cartTotal) && ($cartTotal!='')) ? $cartTotal : 0;
             
        ?>    
    
            <input type="hidden" name="item_name_<?php echo $itemno ?>" value="<?php echo $item[0]->title ?>">
			<input type="hidden" name="amount_<?php echo $itemno ?>" value="<?php echo $priceAftrVat ?>">
            	
               <div class="row <?php echo $toggleClass; ?>" id="summary_<?php echo $cartItemId; ?>">
               <div class="SCart_item_left fl">
           		 <div class="membershipdivbg width_490 bdr_9d9b99 pl1 pt1 height_auto min_h50">
                 
                 	<div class="cell shadow_wp strip_absolute_right left_354">
                <!-- <img src="images/strip_blog.png"  border="0"/>-->
                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                    <tr>
                      <td height="60"><img src="<?php echo base_url('images/summartlistdtop.png')?>"></td>
                    </tr>
                    <tr>
                      <td class="summaryshadow_mid">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="60"><img src="<?php echo base_url('images/summartlistdbottom.png')?>"></td>
                    </tr>
                  </tbody>
                </table>
                <div class="clear"></div>
              </div>
                    
                 	<div class="dash_Atool_fackleftbox heightAuto left7 width_90 bdr_white1 mb5"></div>
						<div class="dash_Atool_leftbox heightAuto left7 bdr_white1 width_90 bdr_bottom0 mt5">
							<div class="height_134">
							  <div class="AI_table">
								<div class="AI_cell"> <img class="max_w77_h118" src="<?php echo base_url('images/default_thumb/'.$item[0]->defaultImage)?>" alt="Media" class="bdr_white_allside max_w80_h120"> </div>
							  </div>
						  </div>
                    </div>       
                                   
        			<div class="dash_Atool_heading font_size20 pl_136"><?php echo $item[0]->title ?></div>
					<div class="dash_Atool_text min_h50 fontsize12 clr_444 pl36">
					<div class="seprator_10"></div>
					<div class="row pl_136 font_size14 clr_f58968 font_arial">
					<div class="fl width_142 text_alignR <?php echo $class ?>"> <?php echo $item[0]->duration ?> <?php echo $this->lang->line('months'); ?> (<?php echo $size ?> MB)  </div>
					<div class="fr text_alignR <?php echo $class ?>">
					<?php $itemPrice = number_format($item[0]->price,2);
                     if($itemPrice>0){ ?>
					   <div class="fl">€</div> <div class="fr pr30 mr5 <?php echo $class ?>"><?php echo $itemPrice ?></div>  
					<?php } else { ?>
					    <div class="fr pr30 mr5 <?php echo $class ?>">Free</div>   
					<?php } ?> 
					</div>
					<div class="clear"></div>
					</div>
					<div class="seprator_10"></div>
					<div class="row pl_136 font_size14 clr_f58968 font_arial">
					<div class="fl width_142 text_alignR"><?php echo $totalSize ?> MB </div>
					<div class="fr ml52 text_alignR">

					<div class="fl">€</div> <div class="fr pr30 mr5"><?php echo number_format($extraPrice,2) ?></div> 
		
	  </div>
      <div class="clear"></div>
        </div>
        
        	
        </div>
<div id="productprice_<?php echo $cartItemId; ?>" class="dn" ><?php echo $priceAftrVat ?></div>                        
         <div class="dash_Atool_footer pl46 pt0 pb0 minH50 font_stylen">  
		   <?php if($isFree=='t'){ ?>    
			 <p class="font_opensans pt20 green fr">Free Purchase </p>
			<?php } else { ?>
			 <p class="font_opensans pt20 green fr"><?php echo $this->lang->line('paymentConfirmed') ?> </p>
			<?php } ?> 
            
         </div>
         
            </div>
             <div class="clear"></div>
            </div>	
                        <div class=" fl width_270 ml-26">
              				<div class="seprator_40"></div>
                            <div class="position_relative"> 
                            <div class="cell shadow_wp strip_absolute_right right_60">
                                      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('images/cart_extraspacedivider_top.png') ?>"></td>
                                          </tr>
                                          <tr>
                                            <td class="line_mid_extraspace">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('images/cart_extraspacedivider_bottom.png') ?>"></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <div class="clear"></div>
                                    </div>
                                    <div class="seprator_10"></div>
                                    <div class="row pt11 bdrB_f4a78d height_30 bdrT_f4a78d">
                  <div class="width_180 mr24 text_alignR fl"><span class="inline clr_999 pr10"><?php echo $this->lang->line('consumptiontax'); ?></span><span class="font_opensansSBold display_inline"> <?php echo $this->lang->line('vat'); ?> <?php echo $vatCharge ?>%</span> </div>
                  
                  <div class=" width_48 fl text_alignR pr10 font_opensansSBold font_size13">
			<?php  if($vat>0) { ?>		  
                 <div class="fr" id="vatOnPrice_<?php echo $cartItemId; ?>"><?php echo number_format($vat,2) ?> </div>
                 <div class="fr pr2">€ </div> 
              <?php } else { ?>
                 <div class="dn" id="vatOnPrice_<?php echo $cartItemId; ?>"><?php echo $vat ?> </div>
                 <div class="fr"> .... </div>              
              <?php } ?>   
				               
                  
                  </div>
                </div>
                <div class="seprator_26"></div>
                <div class="row bg_f1592a font_size13 clr_white pt4 pb4 position_relative">
                            <div class="fl font_opensansSBold width_180 mr24 text_alignR"><?php echo $this->lang->line('TotalPrice'); ?></div>
                  			<div class="fl font_opensansSBold width_60">
								 <div class="fl pl14">€ </div>
									<div class="totalproductprice" id="totalproductprice_<?php echo $cartItemId; ?>">
									  <?php echo number_format($priceAftrVat,2) ?>
								 </div>
							</div>
                            <div class="clear"></div>
                            </div>
                            <div class="seprator_20"></div>
                            </div>
                            
                            </div>
                            <div class="clear"></div>
              			</div>
              			<div class="seprator_10"></div>
                        <div class="seprator_20"></div>
    <?php   
		$k++;$itemno++;	
	 }	 
	 
 }	  ?>     
           
              <div class="seprator_10"></div>           
                                             
			 <div class="toggles" style="display:none;">			
		 
			              <div class="seprator_10"></div>			
			</div>
                        
                        
                        <div class="clear"></div>
                <div class="seprator_30"></div>
               <div class="SCart_sep_shadow mb6">
                <div class="extract_button_box  Fleft fl ml_435 mt_minus10">
	              
           		 </div>
                </div>
                
                
                 <div class="fr pr20 mr24 font_opensansSBold font_size18">
                <span class="fl pr20 width_152 text_alignR"><?php echo $this->lang->line('carttotal'); ?></span> <span class="fl width_120 text_alignR ml18">
					
					
					
					<div class="fr" id="CartTotalPrice"> <?php echo number_format($cartTotal,2) ?> </div>
				    <div class="fl pl14">€ </div>
				    <input type="hidden" value="<?php echo $cartTotal ?>" id="carttotalPrice" name="amount" /> 					 
				</span>
               </div>
               <div class="clear"></div>

            <div class="clear"></div>
<div class="seprator_30"></div>

			<div class="fl dn">
              <div class="seprator_258"></div>
              <div class="tds-button-change Fright ml30"> <a href="<?php echo base_url(lang().'/membershipcart/confirmBilling') ?>" onmouseup="mouseup_tds_button_change(this)" onmousedown="mousedown_tds_button_change(this)"><span class=" font_opensansSBold width_60"><?php echo $this->lang->line('Change'); ?></span></a> </div> 
              </div>
              
              <div class="fr">
            <div class="detailbg position_relative mr30">
          <div class="cell shadow_wp strip_absolute left-57 mt-65">
            <!-- <img src="images/strip_blog.png"  border="0"/>-->
            <table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%" class="minH280">
              <tbody>
                <tr>
                  <td height="59"><img src="<?php echo base_url('images/shadow-top-small.png') ?>"></td>
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
          
                 <div class="fl width_232 bg_white pt20 pr15 pb20 pl15 bsdetailbdr"> 
            	<div class="font_museoSlab font_size24 clr_444 bdr_898989">  <?php echo $this->lang->line('BillingDetail'); ?> </div>
                <div class="seprator_30"> </div>
                <div class="lineH24 pl15"><?php echo $billingDetail->billing_firstName.' '.$billingDetail->billing_lastName; ?>  <br>
                <?php echo $billingDetail->billing_address1; ?><br>
               <?php echo $billingDetail->billing_city .', '. $billingDetail->billing_state; ?><br>
                
                <?php echo $billingDetail->billing_zip; ?><br>
                <?php echo $billingCountry = (isset($billingDetail->countryName)) ? $billingDetail->countryName :''; ?><br> 
                <?php echo $billingDetail->billing_email; ?><br>
                <?php echo $billingDetail->billing_phone; ?>
                </div>  
            </div>   
                       
            
             <div class="clear"></div>
            </div> <!-- /detailbg -->
             <div class="clear"></div>
             <div class="seprator_34"> </div>
             
              </div>

            </div> 
          </div><!-- /cart_container -->
          
          <div class="seprator_20"></div>
        </div>
   
 <script type="text/javascript">       

function mousedown_tds_button_orange(obj){
obj.style.backgroundPosition ='0px -76px';
obj.firstChild.style.backgroundPosition ='right -76px';
}
function mouseup_tds_button_orange(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}

function mousedown_tds_button(obj){
obj.style.backgroundPosition ='0px -76px';
obj.firstChild.style.backgroundPosition ='right -76px';
}
function mouseup_tds_button(obj){
	obj.style.backgroundPosition ='0px -38px';
	obj.firstChild.style.backgroundPosition ='right -38px';
}

function mousedown_tds_button_change(obj){
obj.style.backgroundPosition ='0px -88px';
obj.firstChild.style.backgroundPosition ='right -88px';
}
function mouseup_tds_button_change(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}


$(function() {
	$('.defaultP input').ezMark();
	$('.customP input[type="checkbox"]').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked-green'})
});	


$(".cat_smll_add_icon").click(function () {
$(this).parent().parent().parent().parent().parent().parent().parent().find('.toggle').slideToggle("slow");
//$(".toggle").toggle('fast');
if($(this).css("background-position")=='3px -25px'){
		$(this).css("background-position","3px -38px")
		
	}else{
		$(this).css("background-position","3px -25px");
		
	}
}); 


 function deleteProduct(delId){	
      if(confirm('Are you sure you want to remove item from cart')){ 	
	var cartTotal =parseFloat($('#carttotalPrice').val());		
	var vat   = parseFloat($('#vatOnPrice_'+delId).html());
	var productprice   = parseFloat($('#productprice_'+delId).html());	 	
	//productprice =  (productprice + vat); 		
	cartTotal = (cartTotal-productprice).toFixed(2);
	
	$.ajax
		({     
			type: "POST",
			url: "<?php echo base_url() ?>membershipcart/deleteCartItem/"+delId,
			success: function(msg)
			{  				
				if(cartTotal>=1) {
											
					$('#CartTotalPrice').html(cartTotal);	 
					$('#carttotalPrice').val(cartTotal);	 
					$('#summary_'+delId).remove();	 
				 } 
				 else {					  
						window.location.href="<?php echo base_url(lang().'/package/buytools') ?>";		   	 
					  }	
			}
		});
   }	 
 }


 // Confirm Billing
 function saveForm(){    
	$("#cartSummary").submit();	
 }

function addExtraSpace(){
	
	openLightBox('popupBoxWp','popup_box','/shortlink/shortlinkPopup',msg.shortlink,textBoxId);
	
	
	}



</script>
