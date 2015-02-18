<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
'name'=>'productCart',
'id'=>'productCart'
); 

$userId = isLoginUser();

$purchaseType = (isset($purchaseType) && ($purchaseType!='')) ? $purchaseType :1;
switch($purchaseType){	
	        
	        case 2: // IF PAYPAL RETURN CANCEl 
				$button ='Download';
				$downloadMsg =$this->lang->line('downloadAvalDays');
			break;
			
			case 3: // IF PAYPAL RETURN CANCEl 
				$button ='Pay Per View';
				$downloadMsg = $this->lang->line('downloadAvalDays');
			break;
			
			case 3: // IF PAYPAL RETURN CANCEl 
				$button ='Donate';
			break;
			
			
			default: 
				$button ='Buy now or later?';
				$downloadMsg='';
			break;
	
	}


?>

<?php echo form_open(base_url_secure('cart/buynow'),$formAttributes); ?>
    <div class="poup_bx width500 shadow ">
       <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
       <h3 class="red fs21  text_alighC pb19"><?php echo $button; ?></h3>
       <div class="bdrb_afafaf "></div>
       <div class=" pt10">
          <div class=" display_table buy_wrap text_alighC">
             <button type="button" class="green_button" onclick="buylater();" >Add to Wish List</button>
             <span class=" fs23 lineH33 mt32 mr40 ml40 fr"> or</span>
             <button type="button" class="green_button" onclick="buynow();">Buy Now</button>
             <div class="clearb"></div>
          </div>
           <?php switch ($currencySign) {				   
                    case '$':
                    $currencyType = 1;
                    break;
                    
                    default:
                    $currencyType = 0;				
                } ?>
            <input type="hidden" name ='entityId' value="<?php echo $entityId ?>" />
            <input type="hidden" name ='elementId' value="<?php echo $elementId ?>" />
            <input type="hidden" name ='projId' value="<?php echo $projId ?>" />  
            <input type="hidden" name ='sectionId' value="<?php echo $sectionId ?>" />  
            <input type="hidden" name ='userId' value="<?php echo $userId ?>" />  

            <input type="hidden" value="<?php echo $productBasePrice ?>" name="price" />
            <input type="hidden" value="<?php echo $currencyType ?>" name="currency" />
            <input type="hidden" value="<?php echo $purchaseType ?>" name="purchaseType" />
            <input type="hidden" value="<?php echo $ownerId ?>" name="ownerId" />

            <!--set fields for auction start here-->
            <?php if(isset($sellType) && !empty($sellType)) { ?>
                <input type="hidden" value="<?php echo $sellType ?>" name="sellType" />
            <?php } ?>
            <!--set fields for auction end here-->
            
          <p class=" font_weight textin-42 red text_alighC pt20 pb10 fs20 lineH33"  > <?php echo $currencySign .' '.$price ?> </p>
       </div>
        <?php
            $minimumComission0 = number_format($this->config->item('minimumComission0'),2) ; //=  0.40
            $minimumComission1 = number_format($this->config->item('minimumComission1'),2); 	//=  0.50 
            $commisionPercentage = $this->config->item('commisionPercentage'); 	//=  15;
            $setExpiryDays  = $this->config->item('setExpiryDays'); 
        ?>

       <ul class="fs13 donat_ul">
          <li class="icon_2"> You need a <a href="https://www.paypal.com/" target="_blank">PayPal</a> account to buy from third-party Sellers. </li>
          <?php if ($purchaseType==1){?> 
                <li>This price includes the Toadsquare Service Fee of EUR <?php echo 
                $minimumComission0 ?> (USD <?php echo $minimumComission1 ?>) or <?php echo $commisionPercentage ?> percent. It does not include Consumption Tax (VAT, GST, Sales Tax etc.). The Service Fee is not refundable.
                Taxes will be added, if applicable, as you checkout through the Cart. As will the applicable shipping charge.</li>
                <li>The Shipping Charges, set by the Seller, and the regions the Seller will ship to can be seen in the Shipping Charges popup.</li>
                <li>You need a PayPal account to buy from third-party Sellers.</li>
                <li>After your purchase, we will email you a Sales Record. You can also see it from your Purchases page in your Cart.</li>  
              
              <? } elseif ($purchaseType==2){?> 
                    <li>
                    This price includes the Toadsquare Service Fee of the greater of EUR <?php echo $minimumComission0 ?> (USD <?php echo $minimumComission1 ?>) or <?php echo $commisionPercentage ?> percent. It does not include Consumption Tax (VAT, GST, Sales Tax etc.). The Service Fee is not refundable.
                    Taxes will be added, if applicable, as you checkout.</li>
                    <li>Downloads are available for <?php echo $setExpiryDays ?> days.</li>
                    <li> You need a PayPal account to buy from third-party Sellers.</li>
                    <li> After your purchase, we will email you a Sales Record. You can also see it from your Purchases page in your Cart.</li>
             
              <? } elseif ($purchaseType==3){?> 
                    <li> This price includes the Toadsquare Service Fee of the greater of EUR <?php echo $minimumComission0 ?> (USD <?php echo $minimumComission1 ?>) or <?php echo $commisionPercentage ?> percent. It does not include Consumption Tax (VAT, GST, Sales Tax etc.). The Service Fee is not refundable.
                    Taxes will be added, if applicable, as you checkout.</li>
                    <li> Pay-Per-View (PPV) is available for <?php echo $setExpiryDays ?> days.</li>
                    <li> You need a PayPal account to buy from third-party Sellers.</li>  
                    <li> After your purchase, we will email you a Sales Record. You can also see it from your Purchases page in your Cart.</li>
            <? } ?>
         
       </ul>
    </div>

<?php echo form_close(); ?> 
    
 <script type="text/javascript">
     
    // Continue Shopping  
    function buynow(){
        $("#productCart").attr('action','<?php echo base_url_secure("/cart/buynow")?>');      
        $("#productCart").submit();
    }
    // Confirm Billing
    function buylater(){
        var baseUrl = '<?php echo base_url_secure("cart/buylater")?>';
        
        var fromData=$("#productCart").serialize();
        fromData = fromData+'&ajaxHit=1';
        
        loader();    
        $.post(baseUrl,fromData, function(data) {
            if(data){ 
                    refreshPge();
            }else{
                refreshPge();
            }
        });
    }
 </script>  
