<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
'name'=>'buyProducts',
'id'=>'buyProducts'
);

//To hide & remove vat box
$vatCharge=0;
$cartId=$this->session->userdata('currentCartId');  
 
 if($cartId==''){	
	redirect(base_url(lang().'/membershipcart/buyspaceinfo'));	
	}	?>

<div>
	
	<div class="seprator_6"></div>
		<div class="cart_top_header ml6 mr6">
			<div class="CSEprise_pattern">
			<div class="cart_top_header_heading"><?php echo $this->lang->line('membershipcart'); ?> </div>
			<div class="cart_main_nav_box font_opensans">
			<a class=" ml40 selected">
			<div class="CMN_count">1</div>
			<div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('choosespace'); ?> </div>
			</a> 

			<a class="ml40">
			<div class="CMN_count">2</div>
			<div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('confirmbilling'); ?></div>
			</a> 

			<a class="ml40">
			<div class="CMN_count">3</div>
			<div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('summary'); ?></div>
			</a>


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
		<div class="cart_container min_h558 pl30 pr30 pr30 pt20 pb20">
		  <div class=" font_size14 clr_474747">   <?php echo $this->lang->line('toolscomewithstandard'); ?> </div>
		  <div class="clear"></div>
		  <div class="seprator_25"></div>
		  
	<?php  $countProduct = count($productDetails); ?>	  
		   <input type="hidden" name="cartItemCount" id='cartItemCount' value="<?php echo $countProduct ?>">

<?php 
echo form_open(base_url(lang().'/membershipcart/buyspace'),$formAttributes);
if(isset($productDetails) && is_array($productDetails) && count($productDetails)>0) {
    $k=0;
	foreach ($productDetails as $key =>$item) {				
	 
	   $cartItemId = $productDetails[$k]['cartItemId'];		 
	   	 
	   if(isset($item['extraSpace']->price) && ($item['extraSpace'])) {
	   $totalExtraPrice = $item['extraSpace']->price;
	   $eExtraSize = $item['extraSpace']->size;
       }else{
		      $totalExtraPrice =0;
	          $eExtraSize = 0;		   
		   }
		   
	 $purchaseType = ($item['purchaseType']!='') ? $item['purchaseType'] :'1';
	 $cartTotal = getTotalPrice ($cartId,'cartId','price');                                    
	 $cartTotal = isset($cartTotal->total)? $cartTotal->total :0;	   
	 $class ='';
	 $additionalSpacePerPrice = $item['additionalSpacePrice']; // Space of 1 MB as per db 
	 $isAddSpace = '';
	 
	  $startAddSpace =0; // Limit for Additional space in case of renew
	  	   
	  if($purchaseType == 1){
		  
	  $size=bytestoMB($item[0]->size,'mb');
	  $size=number_format($size,0);               
	  $vat = (($item[0]->price*$vatCharge)/100) ;
	  $priceAftrVat = ($item[0]->price + $vat);
	  $priceAftrVat = $priceAftrVat +  $totalExtraPrice;	  
	  $productPrice = $item[0]->price;	  
	  
	  $totalProductSize =  $size + $eExtraSize ;
	  $usedSpace=0;
		  
		  }	   
		   
	   if($purchaseType == 2){
		   
		  $containerSize = ($item['containerSize']!='') ? $item['containerSize'] :'0';	 
		  $containerSize=bytestoMB($containerSize,'mb');
	      $containerSize=number_format($containerSize,0);	      
	      
	      $size=bytestoMB($item[0]->size,'mb');
	      $size=number_format($size,0);
	      
	      
	      // Client requirement show only extra space
	       $containerSize = str_replace( ',', '', $containerSize );
	       $containerSize = $containerSize - $size;	      
	      
	      $vat = 0;   		  
		  $priceAftrVat = 0;
		  $priceAftrVat = $priceAftrVat +  $totalExtraPrice;
		  $productPrice = $item[0]->price;		  
		  $class = "class = opacity_4";			  
		  $totalProductSize =  $eExtraSize ;
		  $usedSpace=0;
		  $isAddSpace = 'add_space';
		  				  	  
		  } 
		  
		  
		  
	   if($purchaseType == 3){
		   
		  $containerSize = ($item['containerSize']!='') ? $item['containerSize'] :'0';	 
		  $containerSize=bytestoMB($containerSize,'mb');
	      $containerSize=number_format($containerSize,0);	      	      
		   
		   $size=bytestoMB($item[0]->size,'mb');
	       $size=number_format($size,0);               
	       $vat = (($item[0]->price*$vatCharge)/100) ;
	     	      
	       $productPrice = $item[0]->price;
	       
	       $contPreSize = str_replace( ',', '', $containerSize );
           $contPreSize = $contPreSize - $size;      
	       
	       $eSize =($eExtraSize>0)?$eExtraSize:$contPreSize;
	       $eExtraSize = $eSize;
	       
	       $inputExtraSize = ($eExtraSize % 100) ;

			 if($inputExtraSize > 0) {  
				$lessExtraSpace = (100 - $inputExtraSize);
				$eExtraSize = $eExtraSize + $lessExtraSpace;
			   }
	       
	       
	       $totalExtraPrice =  $eExtraSize * $additionalSpacePerPrice; 
	       
	       $priceAftrVat = ($item[0]->price + $vat);
	       $priceAftrVat = $priceAftrVat +  $totalExtraPrice;
	       
	       // Client requirement show only extra space
	       $containerSize = str_replace( ',', '', $containerSize );
	       $containerSize = $containerSize - $size;
	       
	      // $size = $eExtraSize;
	       
	      // $productPrice =  $productPrice + $totalExtraPrice;
	       $productPrice =  $productPrice ;	       	      
	       $totalProductSize =  $size + $eExtraSize ;	       
		   
		 //$usedSpace = 430;
		  $usedSpace = ($item['usedSpace']!='') ? $item['usedSpace'] :'0';	   
			if($usedSpace > $size){
				$usedSpace = $usedSpace-$size;					
				$startSpace = ($usedSpace % 100) ;

				if($startSpace > 0) {  
					$lessSpace = (100 - $startSpace);
					$startAddSpace = $usedSpace + $lessSpace;
				}
			}  
	 }	
	 
	  $totalExtraPrice = number_format($totalExtraPrice,2);
	 	  
	 ?>
	        
	 
	 
               <input type="hidden" id='usedSpace' value="<?php echo $usedSpace ?>">
				<div class="row" id="buyproduct_<?php echo $cartItemId; ?>">
		        <input type="hidden" name="addSpacelimit" id='addSpaceLimit_<?php echo $cartItemId; ?>' value="<?php echo $startAddSpace ?>">	
				 <input type="hidden" id='additionalSpacePerPrice' value="<?php echo $additionalSpacePerPrice ?>">
				 
				 <input type="hidden" name='purType' class="purchase_type" value='<?php echo $purchaseType; ?>' /> 
				
					<div class="extraspacelistsheadow fl">
						<div class="membershipdivbg width550 bdr_9d9b99 pl1 pt1 height_auto">
							<div class="popup_close_btn mt12 mr14" onclick="deleteProduct('<?php echo $cartItemId; ?>');"></div> 
							 
					 <?php if($purchaseType == 2){ ?>		
							<div class="dash_Atool_heading font_size20 pl40"><?php echo $item[0]->title ?> -  <?php echo $this->lang->line('addspace'); ?> </div> 
							
					  <?php } if($purchaseType == 3) { ?>
					  
						  <div class="dash_Atool_heading font_size20 pl40"><?php echo $item[0]->title ?> - <?php echo $this->lang->line('renewtoolnspace'); ?> </div> 
						  
						<?  } else if($purchaseType == 1) {?>
					        <div class="dash_Atool_heading font_size20 pl_210"><?php echo $item[0]->title ?> </div> 					  
					  <?php } ?>							
							
							<div class="dash_Atool_text mH40 fontsize12 clr_444 pl36">
								<div class="fl width_130">
									<div class="seprator_18"></div>
									
									<div class=" bg_444 pt20 pl23 pr23 pb20 fl height_120 width_80 <?php echo $class?> ">
										<div class="AI_table">
										  <div class="AI_cell"> <img class="max_w77_h118" src="<?php echo base_url('images/default_thumb/'.$item[0]->defaultImage)?>"  alt="upcoming" class="bdr_white_allside"> </div>
										</div>
									</div>
									
									<div class="clear"></div>
									<div class="seprator_20"></div>
									
									<div class="position_relative">

									<div class="cell shadow_wp strip_absolute_right right48">
										<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
											<tbody>
												<tr>
												  <td height="30"><img src="<?php echo base_url('images/cart_extraspacedivider_top.png')?>"></td>
												</tr>
												<tr>
												   <td class="line_mid_extraspace">&nbsp;</td>
												</tr>
												<tr>
												   <td height="30"><img src="<?php echo base_url('images/cart_extraspacedivider_bottom.png')?>"></td>
												</tr>
											</tbody>
										</table>
									<div class="clear"></div>
									</div>

									<div class="row font_weight font_size14 clr_888">
										<div class="fl width_52 text_alignR pr12"> <?php echo $this->lang->line('space'); ?>
</div>
										<div class="fl width_52 pl14"><?php echo $this->lang->line('price'); ?></div>
									</div>
									<div class="clear"></div>
									<div class="seprator_10"></div>

									<div class="seprator_8"></div>
									</div>
								</div>
               
               
                <div class="fl width_220 ml124">
          <div class="seprator_6"></div>
         <?php if($purchaseType == 3){ ?>
          <div class="font_opensansSBold clr_f1592a font_size15 tac"><?php echo $this->lang->line('thistoolhas'); ?> <span class=" font_opensansSBold dark_Grey inline"><?php echo $containerSize?> MB </span> <?php echo $this->lang->line('ofextraspace'); ?></div>
          <div class="seprator_5 bdr_Borange"></div>
         <?php } else 
         
         if($purchaseType == 2){ ?>
          <div class="font_opensansSBold clr_f1592a font_size15 tac"><?php echo $this->lang->line('thistoolhas'); ?> <span class=" font_opensansSBold dark_Grey inline"><?php echo $containerSize?> MB </span> <?php echo $this->lang->line('ofextraspace'); ?></div>
          <div class="seprator_5 bdr_Borange"></div>
         <?php } else { ?>         
        
         <div class="font_opensansSBold clr_f1592a font_size15 ml40 pr10 tac"><?php echo $this->lang->line('addextraspace'); ?></div>   
           <div class="seprator_5 bdr_Borange"></div>   
         <?php } ?> 
          
         <?php if($purchaseType != 3){ ?>  
          <div class="font_opensans font_size11 pl20 ml46"><?php echo $this->lang->line('spacewxpires'); ?></div>
         <?php } ?> 
         
         <?php if($purchaseType == 3){ ?>  
          <div class="font_opensans font_size11">You must renew with enough space to fit your current content.</div>
          <div class="font_opensans font_size11"><?php echo $this->lang->line('spacewxpires'); ?></div>
         <?php } ?> 
         
          <div class="position_relative overflowH">
                      
                                	<div class="cell shadow_wp strip_absolute_right right_75">
                                      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('images/cart_extraspacedivider_top.png')?>"></td>
                                          </tr>
                                          <tr>
                                            <td class="line_mid_extraspace">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('images/cart_extraspacedivider_bottom.png')?>"></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <div class="clear"></div>
                                    </div>
                                   
                                  <div class="row font_weight font_size14 clr_888">
                                  <div class="seprator_25"></div>
                                    <div class="fl width_102 text_alignR pr12"> <?php echo $this->lang->line('space'); ?></div>
                                    <div class="fl width_48 ml54"><?php echo $this->lang->line('price'); ?></div>
                                  </div>
                                  <div class="clear"></div>
                                  <div class="seprator_16"></div>
                                   <div class="row mb3">
                                    	<div class="price_trans_wp">  
                                    	<div class="fl width_131">                                     	
                                            <input class="extra_input  number width_58"  maxlength="4" type="text" name="extraspace[<?php echo $cartItemId; ?>]" value="<?php echo $eExtraSize ?>" id="extraSpace_<?php echo $cartItemId; ?>" placeholder="0" onblur="placeHoderHideShow(this,'0','show')" onclick="placeHoderHideShow(this,'0','hide')" onkeyup="calculatePrice('<?php echo $cartItemId; ?>')"  />
                                            <div class="fr mt5 dark_Grey pr2">MB</div>                                            
                                            </div>
                                          	 <div id="extraPrice_<?php echo $cartItemId; ?>" itemTitle="<?php echo $item[0]->title ?>"  divTotalExtraSpae="<?php echo $eExtraSize?>"  divSpaceId='extraSpace_<?php echo $cartItemId; ?>' class="extra_spaceinput fr pt3 pr15 <?php echo $isAddSpace?>">
                                          	   <?php echo number_format($totalExtraPrice,2)?>
                                          	  </div>
                                          	 <div class="fr pt5 pl14 gray_color-2">€  </div>
                                        </div>
                                  </div>
                                  
                                  <div class="clear"></div>
                                  <div class="seprator_20"></div>
                                   
                                  <div class="seprator_8"></div>
                        </div>
                        
          </div>
								<div class="clear"></div>

								<div class="row">
									
							<?php  if($purchaseType!=2){ ?>		
									
										<div class="fl font_weight font_size14 clr_f1592a bdr_Borange height_15">
											<div id="productspace_<?php echo $cartItemId; ?>" class="fl text_alignR pl8 pr8"><?php echo $size.' '.$this->lang->line('mb');?></div>
											<div class="fl pl5 ml5 width_52">
												
												<?php $productPrice = number_format($productPrice,2);
												if($productPrice>0){ ?>		
												<div class="fl">€ </div> <div  class="fl ml1"><?php echo $productPrice  ?></div>
												<?php } else { ?>
												<div  class="fl ml1">Free</div>
												<?php } ?>
											 												
											 <div id="productprice_<?php echo $cartItemId; ?>" class="dn"><?php echo $productPrice ?></div>													
												
											
											</div>
										</div>
					        <?php } else { ?>
					        
					                  <div class="fl font_weight font_size14 clr_f1592a bdr_Borange height_15 <?php echo $class  ?>">
					                  
					                   <div id="productspace_<?php echo $cartItemId; ?>" class="dn">0</div>
					                   
											<div  class="fl width_52 text_alignR pr12"><?php echo $size.' '.$this->lang->line('mb');?></div>
											<div class="fl pl5 width_52">
										<?php $productPrice = number_format($productPrice,2);
										 if($productPrice>0){ ?>		
											<div class="fl">€ </div> <div  class="fl ml1"><?php echo $productPrice  ?></div>
										<?php } else { ?>
										     <div  class="fl ml1">Free</div>
										  <?php } ?>
											<div id="productprice_<?php echo $cartItemId; ?>" class="dn">0</div>
											</div>
										</div>
					        
					        
					        <?php } ?>
					        
					        
										<div class="fl ml65">
										   <div><img src="<?php echo base_url('images/plus_icon.png')?>" alt="plus"/></div>
										</div>

										<div class="fl font_weight font_size14 clr_f1592a bdr_Borange height_15 ml68 mr10 pr">
												<div class="cell shadow_wp strip_absolute_right right58 top-25">
										<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
											<tbody>
												<tr>
												  <td height="30"><img src="<?php echo base_url('images/cart_extraspacedivider_top.png')?>"></td>
												</tr>
												<tr>
												   <td class="line_mid_extraspace">&nbsp;</td>
												</tr>
												<tr>
												   <td height="30"><img src="<?php echo base_url('images/cart_extraspacedivider_bottom.png')?>"></td>
												</tr>
											</tbody>
										</table>
									<div class="clear"></div>
									</div>
									
													
											<div class="fl width_70 text_alignR pr12" id="totalextraspace_<?php echo $cartItemId; ?>">
												<?php echo $eExtraSize.' '.$this->lang->line('mb');?>
											</div>
											<div id="totalextraprice_<?php echo $cartItemId; ?>" class="fl width_48 ml34 ml30 text_alignR mr10">
										    	€<?php echo $totalExtraPrice = (isset($totalExtraPrice))? $totalExtraPrice:0.00; ?>                                    
											</div>
										</div>
										
										<div class="clear"></div>
								  </div>

								<div class="clear"></div>
							</div>

							<div class="dash_Atool_footer boxshedow_common pl46 pt0 pb10 minH50">
							   <div class="font_opensans font_size11 fl mt10 font_stylen clr_444"> <?php echo $this->lang->line('validfor'); ?>
 <?php echo $item[0]->duration ?> <?php echo $this->lang->line('months'); ?>
 <div id="showMsg_<?php echo $cartItemId; ?>" class="fl width_700 orange_color">You can only buy space in multiples of 100 MB. Each 100 MB costs €0.80.</div>
 <div id="showUsedMsg_<?php echo $cartItemId; ?>" class="fl width_700 green"></div>
 </div>
							</div>

						</div>
						
						<div class="clear"></div>
					</div>
					
					<div class=" fl width_270 ml-26">
						<div class="seprator_74"></div>
						<div class="row bg_f1592a font_size13 clr_white pt4 pb4">
							<div class="fl font_opensansSBold width_180 mr24 text_alignR"> <?php echo $this->lang->line('totalspace'); ?></div>
							<div class="fl font_opensansSBold width_65" id="totalproductspace_<?php echo $cartItemId; ?>">
							   <?php echo $totalProductSize.' '.$this->lang->line('mb');?>
							</div>
							<div class="clear"></div>
						</div>

						<div class="seprator_35"></div>
						
						<div class="position_relative"> 
							<div class="cell shadow_wp strip_absolute_right right_60 dn">
								<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
									<tbody>
										<tr>
										   <td height="30"><img src="<?php echo base_url('images/cart_extraspacedivider_top.png')?>"></td>
										</tr>
										<tr>
										   <td class="line_mid_extraspace">&nbsp;</td>
										</tr>
										<tr>
										   <td height="30"><img src="<?php echo base_url('images/cart_extraspacedivider_bottom.png')?>"></td>
										</tr>
									</tbody>
								</table>							
								<div class="clear"></div>						
							</div>
							
							<div class="seprator_10"></div>
							
							<div class="row pt11 bdrB_f4a78d height_30 bdrT_f4a78d dn">
								<div class="width_180 mr24 text_alignR fl dn"><span class="inline clr_999 pr10"> <?php echo $this->lang->line('consumptiontax'); ?>
</span><span class="font_opensansSBold display_inline">  <?php echo $this->lang->line('vat'); ?> <?php echo $vatCharge.'%' ?></span> </div>
								<div class=" width_48 fl text_alignR pr10 font_opensansSBold font_size13 dn">
									<div class="fr" id="vatOnPrice_<?php echo $cartItemId; ?>"><?php echo number_format($vat,2) ?> </div>
				                     <div class="fr pr2">€ </div>
								</div>
							</div>
							
							<div class="seprator_26 min_h142 "></div>
							
							<div class="row bg_f1592a font_size13 clr_white pt4 pb4 zindex_999 position_relative">
								<div class="fl font_opensansSBold width_180 mr24 text_alignR"> <?php echo $this->lang->line('totalprice'); ?></div>
								<div class="fl font_opensansSBold width_65">
									 <div class="fl pl8">€</div>

									 <div class="totalproductprice" id="totalproductprice_<?php echo $cartItemId; ?>">
									 <?php echo number_format($priceAftrVat,2) ?>
									 </div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="seprator_30"></div>
							</div>

						</div>
					
				  </div> 
				<div class="clear"></div>

				<div class="seprator_20"></div>
<?php   
		$k++;	
	 }
	 
 }	  ?>
			
			<div class="SCart_sep_shadow"></div>
			
		<div class="fr mr24 font_opensansSBold font_size18">
			<span class="fl width_152 text_alignR"> <?php echo $this->lang->line('carttotal'); ?></span>
			  <span class="fl width_120 text_alignR ml18">				
				 <div class="fr" id="CartTotalPrice"> <?php echo $cartTotal ?> </div>
				 <div class="fl pl14"> <div class="fl pr2">€</div>  </div>
				<input type="hidden" value="<?php echo number_format($cartTotal,2) ?>" id="carttotalPrice" name="carttotalPrice" /> 
			  </span>
			</div>
			<div class="clear"></div>
		<div class="seprator_55"></div>

		<div class="fr">
		
			<div class="tds-button fl width_141"> <a onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" onclick="continueShopping();"><span class=" font_opensans  width_109"> <?php echo $this->lang->line('continueshoping'); ?></span></a> </div>
       
			<div class="tds-button-orange ml3 fr ml20"> <a onclick="buymore();" onmouseup="mouseup_tds_button_orange(this)" onmousedown="mousedown_tds_button_orange(this)"><span class=" font_OpenSansBold width_90"><?php echo $this->lang->line('checkout'); ?></span></a> </div>
		</div>
		
	<div class="clear"></div>
	<div class="seprator_10"></div>    
    <div class="font_opensansSBold font_size11 mt2 Fleft">* We will refund the price of a Tool and its Extra Space until you save it.</div>	
    <div class="clear"></div>
    <div class="font_opensansSBold font_size11 mt2 Fleft">* VAT will be added, if applicable, as you checkout.</div>	
    

		</div> <!-- /cart_container -->
	</div>
	
	<input type="hidden" name='purchaseType'  id="purchaseType" value='<?php echo $purchaseType; ?>' /> 

	<div class="seprator_20"></div>
</div>
<!--front_end_mani_content_wp-->
 <?php echo form_close(); ?>     
<script>
	
	$(document).ready(function(){		
		runTimeCheckBox();
		
		cartTotal = getCartTotal();								
		$('#CartTotalPrice').html(cartTotal);   
		$('#carttotalPrice').val(cartTotal); 
		
			
		checkSpaceOnRefresh();
		$("#buyProducts").validate();
              
		$(window).keydown(function(event){
		  if(event.keyCode == 13) {
		   event.preventDefault();
		   return false;
		  }
	       });

		});
		
	function checkSpaceOnRefresh(){		
		$('.extra_spaceinput').each(function(i){
		 var val = parseFloat($(this).html());
		 
		   if(val>0){
			    var extraSpaceTotal= parseInt($(this).attr('divTotalExtraSpae'));
			    var spaceId= $(this).attr('divSpaceId');					
			    $('#'+spaceId).val(extraSpaceTotal); 
			   			 
			} else { 				   
			   var spaceId= $(this).attr('divSpaceId');					
			   $('#'+spaceId).val('0');				   
			}
	    });
	}
		
		
  //timeout = setTimeout(calculatePrice(cartId), 1000);  
  			
 function calculatePrice(cartId){	  
			 
  setTimeout(function(){
	 
	// $('#showMsg_'+cartId).html(''); 
	  
	 var countSpace=0;
	 var countPrice=0;
	 var lessSpace =0;
	 var newSpace=0;
	 var totalProductSpace=0;
	 var totalProductPrice=0;	
	 var extraSpace = parseFloat($('#extraSpace_'+cartId).val());
	 var productspace   = parseInt($('#productspace_'+cartId).html());	
	 var vat   = parseFloat($('#vatOnPrice_'+cartId).html()); 
	 var productprice   = parseFloat($('#productprice_'+cartId).html());	 	 
	 var addSpaceLimit = parseFloat($('#addSpaceLimit_'+cartId).val());
	 var perSpacePrice =  parseFloat($('#additionalSpacePerPrice').val());
	 var usedSpace =  parseFloat($('#usedSpace').val());
	 
	 if(extraSpace==9999){
		customAlert('Please enter no more than 4 characters.You can only buy space in multiples of 100 MB.');	 
		extraSpace = 9900;
		$('#extraSpace_'+cartId).val(extraSpace);					 
		 }
		
	 if(extraSpace < addSpaceLimit ){
		 
		 $('#showUsedMsg_'+cartId).html('You have used '+usedSpace+ ' MB space, Minimum '+addSpaceLimit+' MB of Add Space required ' );
		 $('#extraSpace_'+cartId).val(0);
		 $('#extraPrice_'+cartId).html(0);		    
		 $('#totalextraspace_'+cartId).html('0 MB');
		 $('#totalextraprice_'+cartId).html('€0');		 
		 $('#totalproductspace_'+cartId).html(productspace + ' MB');
		 $('#totalproductprice_'+cartId).html(productprice);
		   
		   cartTotal = getCartTotal();								
		   $('#CartTotalPrice').html(cartTotal);   
		   $('#carttotalPrice').val(cartTotal); 		   
			return false;	 
		 }
	 
	 productprice =  (productprice + vat);	 
	 countSpace = (extraSpace % 100) ;	 
	 
	 if(countSpace==0){	//alert('fine');	 
		 countPrice = (extraSpace * perSpacePrice);
		 totalProductSpace = (extraSpace + productspace);
		 totalProductPrice = (productprice + countPrice);			
		 
		 $('#extraPrice_'+cartId).html(countPrice.toFixed(2));
		 
		 $('#totalextraspace_'+cartId).html(extraSpace+ ' MB');
		 $('#totalextraprice_'+cartId).html('€'+countPrice.toFixed(2));
		 
		 // Total Product Box Calculations				
		   $('#totalproductspace_'+cartId).html(totalProductSpace+' MB');		   
		   $('#totalproductprice_'+cartId).html(totalProductPrice.toFixed(2));
		   
		   cartTotal = getCartTotal();								
		   $('#CartTotalPrice').html(cartTotal);   
		   $('#carttotalPrice').val(cartTotal); 		 
		 		 
		 } else if(countSpace > 0) {
			 
			// $('#showMsg_'+cartId).html('You can only buy space in multiples of 100 MB. Each 100 MB costs €0.80.');
			 	 
			  lessSpace = (100 - countSpace);
			  newSpace = extraSpace+lessSpace;
			  countPrice = (newSpace * perSpacePrice);			  
			  totalProductSpace = (newSpace + productspace);
			  totalProductPrice = (productprice + countPrice);
			  
		      $('#extraSpace_'+cartId).val(newSpace);
			  $('#extraPrice_'+cartId).html(countPrice.toFixed(2));
			   
			  $('#totalextraspace_'+cartId).html(newSpace + ' MB');
			  $('#totalextraprice_'+cartId).html('€'+countPrice.toFixed(2));
			  
			  
			  // Total Product Box Calculations				
				$('#totalproductspace_'+cartId).html(totalProductSpace+' MB');
				$('#totalproductprice_'+cartId).html(totalProductPrice.toFixed(2));
			  
			    cartTotal = getCartTotal();	
				$('#CartTotalPrice').html(cartTotal);   
				$('#carttotalPrice').val(cartTotal); 			  			   
		 }		 
	  }, 1500);
   }	
		

 function deleteProduct(delId){
	 	
	if(confirm('Are you sure you want to remove this from your Cart? ')){ 
	var cartTotal = getCartTotal();		
	var vat   = parseFloat($('#vatOnPrice_'+delId).html()); 
	var productprice   = parseFloat($('#productprice_'+delId).html()); 	
	var totalproductprice = parseFloat($('#totalproductprice_'+delId).html());
		
	productprice =  (productprice + vat); 		
	cartTotal = (cartTotal-totalproductprice).toFixed(2);	
	
	var cartItemTotal = $('#cartItemCount').val();	
	var remaingCartItem;
	remaingCartItem = (cartItemTotal-1);
	
	$.ajax
		({     
		type: "POST",
		url: "<?php echo base_url() ?>membershipcart/deleteCartItem/"+delId,

		success: function(msg)
		{			
			if(remaingCartItem>0) {						
				$('#CartTotalPrice').html(cartTotal);	 
				$('#carttotalPrice').val(cartTotal);	 
				$('#buyproduct_'+delId).remove();	
				
				$('#cartItemCount').val(remaingCartItem);				
				 
			 } else {
					window.location.href="<?php echo base_url(lang().'/package/buytools') ?>";		   	 
			}	
		 }
	});	 
  }
 }
 
 
 
 // Calculate Cart Total 
 function getCartTotal(){	 
	var val = [];
	var totalProductsPrice=0;
		
	$('.totalproductprice').each(function(i){			
		val[i] = parseFloat($(this).html());			   
		totalProductsPrice = (totalProductsPrice +  val[i]);							
	    totalProductsPrice;
	}); 
	 return totalProductsPrice.toFixed(2);	 
 }
 
 
 // Continue Shopping  
 function continueShopping(){
    $("#buyProducts").attr('action','<?php echo base_url(lang()."/membershipcart/updateCart")?>');
    
    cartTotal = $("#carttotalPrice").val();
		 if(cartTotal==0){
			// customAlert('Cart total should be more than zero.');		  	 
           //return false;
         }
    
	$("#buyProducts").submit();
	
 }
 
  // Confirm Billing
 function buymore(){
	
	 var iteminfo = isAddSpaceBlank();
	 var itemNewVal = iteminfo.newVal;  
	 var itemName = iteminfo.name; 
	 
	 if(itemNewVal==0){
		 customAlert('You need to add Extra Space to your '+itemName+' Tool');
		 return false; 
	 }
	 
    $("#buyProducts").attr('action','<?php echo base_url(lang()."/membershipcart/confirmBilling")?>');    
       
    var cartItemTotal = $('#cartItemCount').val();	
	//var remaingCartItem;
	//remaingCartItem = (cartItemTotal-1);  
	
  // Check purchase type, if type is Renew alow checkout with free purchase 
	 var purchaseType = getPurchaseType();	
     
     cartTotal = $("#carttotalPrice").val();
     if((cartTotal==0) && (purchaseType!=3)){
		 customAlert('You need to add an item to your Cart.');
       return false;
     }
     
	$("#buyProducts").submit();
	//histroy.go(-1);
 }
 
 


function mousedown_tds_button_orange(obj){
obj.style.backgroundPosition ='0px -76px';
obj.firstChild.style.backgroundPosition ='right -76px';
}
function mouseup_tds_button_orange(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}


function isAddSpaceBlank(){		
	//var newVal=1 ;
	var item = new Array();	
	item['newVal'] = 1;
		$('.add_space').each(function(i){
			var val = new Array();		  		 
			val = parseFloat($(this).html());
			var itemTitle = $(this).attr('itemTitle');						  		 		 		 			  
			if(val==0){
				
				item['newVal'] = 0;
				item['name'] = itemTitle;
				
			} 			  	 
		});		
	return item;
	}



/* Get purchase type of items */
 function getPurchaseType(){	
	var purchaseType = 0;	
		$('.purchase_type').each(function(i){
			var val = new Array();		  		 
			val = parseFloat($(this).val());										  		 		 		 			  
			if(val==3){
				purchaseType = val;				
			} 			  	 
		});		
	return purchaseType;
	}



</script>
