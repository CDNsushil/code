<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
    'name'  =>  'wishlist',
    'id'    =>  'wishlist'
);

//get currency type and sign
if($currency==1){
    $currencySelected   =  'dollar';
    $selectcurrency     =  '$';
}else{
    $currencySelected   =  'euro';
    $selectcurrency     =  '€';
} 


?>

<div class="row content_wrap blog_wrap" >
   <div class="bg_f3f3f3 fl width100_per  title_head">
      <h1 class="fs34 letrP-1 opens_light mb0  fl  textin30">Wish List</h1>
      <div class=" fl fs16 pt15">
         <?php if(!empty($dollarCount) && !empty($euroCount)){ ?>
             <ul class="cart_nav">
                <li class="<?php echo ($currencySelected=='euro')?'active':''; ?>"><a href="<?php  echo ($currencySelected=='euro')?'javascript:void(0)':base_url_lang('cart/mywishlist/euro'); ?>"><span class="cart_icon">&euro;</span>EURO Cart</a></li>
                <li class="<?php echo ($currencySelected=='dollar')?'active':''; ?>"><a href="<?php echo($currencySelected=='dollar')?'javascript:void(0)':base_url_lang('cart/mywishlist/dollar'); ?>"><span class="cart_icon">$</span>USD Cart</a> </li>
             </ul>
         <?php } ?>
      </div>
        <?php 
        //-------shopping cart menu navigation start----------//
            echo modules::run('cart/shoppingcartdata');
        //-------shopping cart menu navigation start----------//
        ?>  
   </div>
   
   <div class="blog_wrap clearb">
        <?php
            //---------form open start----------//
            echo form_open(base_url(lang().'/cart/wishlistcheckout'),$formAttributes);            
            if(!empty($basketItems)){ 
        ?>
        <div id="currentCurrency" class="dn"><?php echo $selectcurrency ?></div>       
        <div id="TabbedPanels1" class="TabbedPanels">
         <div class="m_auto width635">
            <div class="TabbedPanelsContent position_relative ">
               <h5 class="pt20 pb16 bb_aeaeae"> You can checkout up to 5 items in one transaction, in either Euros or US Dollars: <b class="red fs16 fr">  <span class="itemtotal">0</span>/5 selected </b></h5>
             
               <?php
                     $cartTotal = 0;
                     $i=1;
                     foreach ($basketItems as $key =>$item) {
                        
                        $displayPrice       = $item['displayPrice'];
                        $tsCommission       = $item['tsCommissionValue'];
                        $title              = $item['title'];
                        $basePrice          = $item['itemValue'];
                        $description        = $item['description'];
                        $aviliableqty       = $item['aviliableqty'];
                        $image              = $item['image'];	
                        $shippingPrice      =   $item['shippingPrice'];
                        $tsCommissionValue  =   $item['tsCommissionValue'];
                        $tsVatValue         =   $item['tsVatValue']; 				 
                       //$productPrice       =   $basePrice + $shippingPrice + $tsCommissionValue + $tsVatValue;
                        $productPrice       =   $basePrice;
                        $purchaseType       =   $item['purchaseType'];
                        $purchaseString='';
                        
                        $isAvailable=true;
                        $elementMediaType = 'Video File';
                        
                        
                       $sectionId = $item['sectionId'];
                        
                        
                        switch($purchaseType){
                            case 1:
                                $purchaseString=$this->lang->line('shipment');
                                if(!($aviliableqty >=1)){
                                    $isAvailable=false;
                                }
                                $elementMediaType = $this->lang->line('elementMediatype_1_'.$sectionId);//'DVD';
                            break;
                             
                            case 2:
                                $purchaseString=$this->lang->line('download');
                                $elementMediaType = $this->lang->line('elementMediatype_2_'.$sectionId);
                            break;
                             
                            case 3:
                                $purchaseString=$this->lang->line('payPerView');
                            break;
                             
                            case 4:
                                $purchaseString=$this->lang->line('donate');
                            break;
                        }
                         
                        $wishlistId             =   $item['wishlistId']; 			 
                        $checked                =   ($i<=0) ? 'checked="checked"' : '';		
                        $consumptionTaxPer      =   $item['consumptionTaxPer'];
                        $consumptionTaxName     =   $item['consumptionTaxName'];
                        $purchaseType           =   $item['purchaseType'];
                        
                        if($consumptionTaxPer!=0){
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
                        
                        
                    ?>
                        <div class=" collection_cart defaultP" id="wishllistitem_<?php echo $wishlistId; ?>">
                              <div class="sale_check">
                                 	<?php  if($isAvailable){    ?>
                                        <input type="checkbox" id="item_<?php echo $i ?>" name="wishlistitem[<?php echo $wishlistId ?>]"  value="<?php echo $productPrice ?>" <?php echo $checked ?>  onclick="calculatePrice('<?php echo $i ?>')" class="productpricechk" />
                                    <?php   }else{  ?>
                                        <div class="red pr10">NA</div>
                                    <?php    }  ?>
                              </div>
                              <ul class="total  purcharse bb_fac8b8  lineH18 clearb mt30" >
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
                                          			<div class="tds-button removeWishlist dn"> <a  onclick="deleteTabelRow('Wishlist','itemId','<?php echo $wishlistId;?>','','','#wishllistitem_','','','','','0','<?php echo $this->lang->line('deleteWishlistItem');?>');" ><span class=" font_opensansSBold"><?php echo $this->lang->line('remove');?></span></a> </div> 
                                                    
                                           <span class="price ver_m"> <?php echo $selectcurrency.'&nbsp;'.number_format($basePrice,2) ?> </span> 
                                           
                                           
                                 </li>
                                 
                                   <li class="clearb position_relative  " >
                                            <span class="purchace_img"><img src="<?php echo $image ?>" alt=""  /></span> 
                                        </li>
                                        
                                 <li class="clearb position_relative  " >
                                     
                                  <span class="display_cell fr"> <span class="p_head pr36 text_alignR  fs12 ">
                                     <?php if($purchaseString == 'Shipment') {?>
                                            A Shipping Charge will be added after you confirm your Shipping Details 
                                      <?php } ?>
                                    </span> <span class="price verti_top"> </span> </span> </li>
                                    <li class="clearb  space_1 "> 
                                        <span class="display_cell fr"> 
                                        
                                        <?php  if($isShow=="yes") {?>
                                            <span class="p_head pr36 text_alignR "><?php echo $taxName; ?> <?php echo $taxPercentage; ?>%</span> 
                                            <span class="price verti_top"><?php echo $selectcurrency.'&nbsp;'.number_format($vatPrice,2) ?> </span>
                                        <?php } else { ?>
                                            <span class="p_head pr36 text_alignR "></span> 
                                            <span class="price verti_top">  </span>
                                        <?php } ?>
                                           
                                        </span>
                                        
                                        
                                    </li>
                                 <li class="clearb total_last" > <span class="display_cell fr"><span class="red p_head font_bold pr36 text_alignR "> Item Total </span> <span class="price red font_bold verti_top"> <?php echo $selectcurrency.'&nbsp;'.number_format($productPrice,2) ?> </span> </span> </li>
                              </ul>
                        </div>
                            
                <?php $i++; }   ?>   
            
               <div class="grand_total clearb font_bold text_alignR pt10 pb10 bb_fac8b8 " > <span class="red   pr36  "> Purchase Total </span> <span class="price red pr15  verti_top"  id="cartTotal"> <?php echo $selectcurrency.'&nbsp; 0' ; ?> </span> </div>
               <hr class="bb_fac8b8" />
                <ul class="mt20 fl">
                    <li class="icon_2">
                        Taxes will be added, if applicable, after you confirm your Billing Details.
                    </li>
                </ul>
               <div class="fr option_btn btn_wrap display_block mt10 font_weight">
                    <a href="<?php echo base_url_lang(); ?>">
                        <button class="bg_ededed bdr_b1b1b1  mr5" type="button">Cancel </button>
                    </a>
                  <button class="b_F1592A  bdr_F1592A " type="button" onclick="checkout();">Next </button>
               </div>
            </div>
         </div>
      </div>
         <?php    
            }
        //-----form close here-----//
        echo form_close(); 
       ?>     
   </div>
</div>

<script type="text/javascript" language="javascript">


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
        var checked = $(".productpricechk:checked").size(); 
        //alert(checked);
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

</script>
