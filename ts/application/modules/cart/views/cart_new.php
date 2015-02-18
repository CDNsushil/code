<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//get shopping cart id
$thirdPartyCartId=$this->session->userdata('thirdPartyCartId');

//get item count
$itemCount = (!empty($basketItems))?count($basketItems):0; 
?>

<div class="row content_wrap blog_wrap" >
   <div class="blog_wrap">
      <div id="TabbedPanels1" class="TabbedPanels">
        <?php 
            //---------shopping cart progress bar steps----------//
                $this->load->view('common_view/shoppingcart_steps');
            //---------shopping cart progress bar steps----------//
        ?>
         <div class="m_auto width635">
            <div class="TabbedPanelsContent position_relative">
               <h3> Purchase Summary </h3>
               <div class="sap_10"></div>
              
             <?php
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
                             $title = (isset($item['title'])) ? $item['title']: '' ;
                             $basePrice = (isset($item['itemValue'])) ? $item['itemValue'] : 0; 
                             
                             if($purchaseType==4){
                                 $basePrice = $item['basePrice'];
                             }
                             
                             $isFree=0;
                             if(isset($item['sellerInfo']->isFree)){
                                  $isFree=$item['sellerInfo']->isFree;
                             }
                             
                             $elementMediaType = 'Video File';
                             $purchaseString='';
                             switch($purchaseType){
                                 case 1:
                                    $purchaseString=$this->lang->line('shipment');
                                    $elementMediaType = 'DVD';
                                 break;
                                 
                                 case 2:
                                    $purchaseString=$this->lang->line('download');
                                    $elementMediaType = 'Video File';
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
              
                                <ul class="total  purcharse bb_fac8b8 pb41 lineH18 clearb mt30" id="wishllistitem_<?php echo $i ?>">
                                      <li class="clearb space_1 BB_dadada" >
                                        <span class="display_cell p_head"> 
                                            <span class="red  fl font_bold width100 pr12 pl5"><?php echo $elementMediaType; ?></span> 
                                            <span class="font_bold fs16 width390 ">
                                                <?php
                                                    echo $title; 
                                                
                                                    if($purchaseString != ''){
                                                        echo '<span class="fs11 display_block red">('.$purchaseString.')</span>';
                                                    }
                                                ?>
                                            </span>
                                        </span>
                                         
                                         <span class="price ver_m"> <?php echo $selectcurrency.'&nbsp;'.number_format($basePrice,2) ?> </span> 
                                      </li>
                                      
                                        <li class="clearb position_relative  " >
                                            <span class="purchace_img"><img src="<?php echo $image ?>" alt=""  /></span> 
                                        </li>
                                          
                                        <?php  if($shippingPrice!=0) { ?>
                                            <li class="clearb position_relative  " >
                                                <span class="display_cell fr">  <span class="p_head pr36 text_alignR ">Shipping Charge </span>
                                                <span class="price verti_top"> <?php echo $selectcurrency.'&nbsp;'. number_format($shippingPrice,2) ?> </span> </span>
                                            </li>
                                        <?php }else{  ?>
                                            <li class="clearb position_relative  " >
                                                <span class="display_cell fr">  <span class="p_head pr36 text_alignR "> </span>
                                                <span class="price verti_top">  </span> </span>
                                            </li>
                                        <?php  }?>    
                                     
                                      
                                        <?php  if($isShow=="yes") {?>
                                            <li class="clearb  space_1 " >
                                                <span class="display_cell fr"> 
                                                    <span class="p_head pr36 text_alignR "> <?php echo $taxName; ?> <?php echo $taxPercentage; ?>%</span> </span>
                                                    <span class="price verti_top"> <?php echo $selectcurrency.'&nbsp;'.number_format($vatPrice,2) ?> </span> 
                                                </span>
                                            </li>
                                        <?php } ?>
                                       
                                       <input type="hidden" name="vatprice" value="<?php $vatPrice ?>">  
                                       
                                        <li class="clearb position_relative  " >
                                            <span class="display_cell fr">  <span class="p_head pr36 text_alignR ">Toadsquare Service Fee </span>
                                            <span class="price verti_top"> <?php echo $selectcurrency.'&nbsp;'. number_format($tsCommissionValue,2) ?> </span> </span>
                                        </li>
                                        <?php if($tsVatValue>0){ ?>
                                            <li class="clearb position_relative  " >
                                                <span class="display_cell fr">  <span class="p_head pr36 text_alignR ">Shipping Charge </span>
                                                <span class="price verti_top"> <?php echo $selectcurrency.'&nbsp;'. number_format($tsVatValue,2) ?> </span> </span>
                                            </li>
                                        <?php  }?>
                                      
                                        <li class="clearb total_last" >
                                            <span class="display_cell fr">
                                                <span class="red p_head font_bold pr36 text_alignR "> Item Total </span>
                                                <span class="price red font_bold verti_top"> <?php echo $selectcurrency.'&nbsp;'. number_format($productPrice,2) ?> </span> 
                                            </span>
                                        </li>
                                   </ul>
               
                    <?php         $i++; }       
                            } else {			   
                                    echo '<div class=" tac p10 mt20 font_opensansSBold font_size18">No Record </div>';			   
                            } ?> 
              
               <div class="grand_total font_bold text_alignR pt10 pb10 bb_fac8b8 " >
                  <span class="red   pr36  "> Purchase Total
                  </span>
                  <span class="price red pr15  verti_top"> <?php echo $selectcurrency.'&nbsp;'. number_format($cartTotal,2) ?> </span> 
               </div>
               <hr class="bb_fac8b8" />
               <div class="sap_50"></div>
               <div class="bill_detail clearb color_666 ">
                <?php
                    if($billingDetail->billing_state!=''){
                            $billingStateName = getstateName($billingDetail->billing_state);
                    }else{  
                            $billingStateName=''; 
                        }

                    if($billingDetail->shipping_state!=''){
                            $shippingStateName = getstateName($billingDetail->shipping_state);
                    }else { 
                            $shippingStateName=''; 
                        }           
                ?> 
                  <span class="fl billcontent">
                     <h4 class="fs21 fl red clearb "> Billing Details</h4>
                     <div class="sap_15"></div>
                     <p><?php echo $billingDetail->billing_firstName.' '.$billingDetail->billing_lastName; ?></p>
                     <p><?php echo $billingDetail->billing_address1; ?></p>
                     <p><?php echo $billingDetail->billing_city .', '. $billingStateName; ?></p>
                     <p><?php echo $billingDetail->billing_zip; ?></p>
                     <p><?php echo $billingCountry = (isset($billingDetail->countryName)) ? $billingDetail->countryName :''; ?></p>
                     <p> <?php echo $billingDetail->billing_email; ?></p>
                     <p><?php echo $billingDetail->billing_phone; ?></p>
                  </span>
                   <?php if($isShippingDetails){ ?> 
                      <span class="fr shipcontent mr60">
                         <h4 class="fs21 fl red clearb "> Shipping Details</h4>
                         <div class="sap_15"></div>
                         <p><?php echo $billingDetail->shipping_firstName.' '.$billingDetail->shipping_lastName; ?> </p>
                         <p><?php echo $billingDetail->shipping_address1; ?></p>
                         <p><?php echo $billingDetail->shipping_city .', '. $shippingStateName; ?></p>
                         <p><?php echo $billingDetail->shipping_zip; ?></p>
                         <p><?php echo $billingCountry = (isset($billingDetail->shippingcountryname)) ? $billingDetail->shippingcountryname :''; ?></p>
                         <p><?php echo $billingDetail->shipping_email; ?></p>
                         <p><?php echo $billingDetail->shipping_phone; ?></p>
                      </span>
                  <?php  }  ?>
                  <div class="sap_30"></div>
                  
                <?php
                    if($isShippingDetails){
                        $changeUrl=base_url(lang().'/cart/shoppingcartbilling/1');
                    }else{
                        $changeUrl=base_url(lang().'/cart/shoppingcartbilling/2');
                    } 
                ?>
                  <p>
                     <a href="<?php echo $changeUrl; ?>"><button type="button" class=" fr  back_click_1 bg_F0F0F0 bdr_b1b1b1 ">Modify Purchase</button></a>
                  </p>
               </div>
               <div class=" sap_50"></div>
               <div class="bdr_non clearb fl">
                  <label class="defaultP ml0">
                  <input class="ez-hide width_auto" id="termncoditi" type="checkbox"  value="agree" name="termncoditi" />
                    I acknowledge to have read, understood and agreed the <a href="<?php echo base_url(lang().'/cms/termsncondition'); ?>" target="_blank">Terms &amp; Conditions</a> of the Toadsquare
                    website.
                    </label>
               </div>
                <div class="validation_error dn pt_15 pl30" id="payment_term_error" >
                    <?php echo $this->lang->line('termncondition_pay_message'); ?>
                </div>
                          
               <div class="clearb download_pdf mt15 fl pl30">
                  <span class="fl pr10">Download the Terms & Conditions in PDF.</span>
                  <ul class="fl fs13">
                     <li>
                        <a href="<?php echo base_url('images/Terms and Conditions_18.04.2013.pdf'); ?>" target="_blank">English</a>
                     </li>
                     <li>
                        <a href="javascript:void(0)">Francias</a>
                     </li>
                     <li>
                        <a href="javascript:void(0)">Deutcsh</a>
                     </li>
                  </ul>
               </div>
               <div class=" sap_25"></div>
               <ul class="fl lineH20 pt3 fs12 ul_wrap pl30">
                  <li class="  mt3 "> <span class="fl">Pay Securely using PayPal or Credit Card </span><img src="<?php echo base_url('images/paypal_logo.png')?>" alt="paypal logo" class=" fl display_inline pl15 lineH24" /></li>
               </ul>
               <div class="fr option_btn btn_wrap display_block mt10 font_weight">
                  <button  type="button"  class="bg_ededed bdr_b1b1b1  mr5">Cancel </button>
                  <a href="<?php echo  $changeUrl; ?>">
                    <button   type="button" class="bg_ededed back  bdr_b1b1b1 mr5"> Back </button>
                  </a>
                   <?php
                     if($isFree){ ?>
                            <a href="<?php echo base_url(lang().'/payment/saveOrderDetails/'.$trackingId.'/1')?>" >
                                <button  type="button" class="b_F1592A  bdr_F1592A ">CHECKOUT </button>
                            </a> 
                    <?php
                      }else{ ?>
                          
                        <?php if($cartTotal>1){ ?>  
                             <button  type="button" class="b_F1592A  paynow bdr_F1592A ">Pay Now </button>
                         <?php }else { ?> 
                            <a href="<?php echo base_url(lang().'/cart/mywishlist') ?>"  ><button  type="button" class="b_F1592A  bdr_F1592A ">Continue Shopping </button> </a> 
                        <?php  } 
                      }
                     ?>
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</div>  

<script>
  /**
   * @Description: This function for billing form validation
   */
   $(".paynow").click(function(){
        var getChkStatus= $('#termncoditi').is(":checked");
        if(getChkStatus){
          $('#payment_term_error').hide();
          window.location.href="<?php echo base_url(lang().'/cart/sendPaypalData') ?>";		
        }else{
         $('#payment_term_error').show();
        }
        return false;
   });

</script>
