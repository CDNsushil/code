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
				$button ='Buy';
				$downloadMsg='';
			break;
	
	}


?>

<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>

<?php echo form_open(base_url(lang().'/cart/buynow'),$formAttributes); ?>
	<div class="popup_gredient ">

		<div class="width_400">
			<div class="seprator_26"></div>
			 <div class="pl10 text_alignC width_366 buypopupheading font_size24 clr_888"><?php echo $button ?> </div>
			<div class="seprator_26"></div>

			<div class="row">
			<div class=" m0auto width_263">
			<div class="donate_btn_styleA ml5 buypopupbtn mr30 width_105"><a onclick="buynow();" href="javascript:void(0);" class="tds-button_new " onmouseup="mouseup_tds_button_new(this)" onmousedown="mousedown_tds_button_new(this)" href="#"><span>Buy Now</span></a> </div>

			<div class="donate_btn_styleA ml5 buypopupbtn width_105"><a onclick="buylater();" href="javascript:void(0);" class="tds-button_new" onmouseup="mouseup_tds_button_new(this)" onmousedown="mousedown_tds_button_new(this)" href="#"><span>Buy Later</span></a> </div>
			</div>
			
			
			<div class="clear"> </div>
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
			
			<div class="seprator_26"></div>
			<div class="text_alignC width_366 font_size24 clr_888 font_opensansSBold"> <?php echo $currencySign .' '.$price ?> </div>
			<div class="seprator_15"></div>
	
<div class="width_366 ma font_size11 lH14 pl10 pr5 pb5"><?php //echo $this->lang->line('buyNowConsumMsg')?></div>			

<div class="width_366 ma font_size11 lH14 pl10 pr5 pb5"> <?php //echo $this->lang->line('buyNowCheckout')?> </div>

<div class="width_366 ma font_size11 lH14 pl10 pr5 pb10 orange"><?php //echo $this->lang->line('havePaypalAcnt')?> </div>			

<?php if ($downloadMsg!=''){ ?>
<div class="width_366 ma font_size11 lH14 pl10 pr5 pb10 orange"> <?php //echo $downloadMsg ?> </div>			
<?php } ?>
</div>

<?php
$minimumComission0 = number_format($this->config->item('minimumComission0'),2) ; //=  0.40
$minimumComission1 = number_format($this->config->item('minimumComission1'),2); 	//=  0.50 
$commisionPercentage = $this->config->item('commisionPercentage'); 	//=  15;
$setExpiryDays  = $this->config->item('setExpiryDays'); 
?>


  <?php if ($purchaseType==1){?> 
<div class="tal width_366 ma font_size11 lH14 pl10 pr5 pb5">  
 <span class="fl"> *</span> <span class="pl10 pb7">This price includes the Toadsquare Service Fee of EUR <?php echo 
  $minimumComission0 ?> (USD <?php echo $minimumComission1 ?>) or <?php echo $commisionPercentage ?> percent. It does not include Consumption Tax (VAT, GST, Sales Tax etc.). The Service Fee is not refundable.
  Taxes will be added, if applicable, as you checkout through the Cart. As will the applicable shipping charge.</span>
<div class="clear"></div>
  <span class="fl"> *</span>  
  
  <span class="pl10">The Shipping Charges, set by the Seller, and the regions the Seller will ship to can be seen in the Shipping Charges popup.</span></div>
 <div class="tal width_366 ma font_size11 lH14 pl10 pr5 pb5"> 
  <span class="fl"> *</span> <span class="pl10">You need a PayPal account to buy from third-party Sellers.</span></div>
<div class="tal width_366 ma font_size11 lH14 pl10 pr5 pb5">
<span class="fl"> *</span> <span class="pl10">After your purchase, we will email you a Sales Record. You can also see it from your Purchases page in your Cart.</span>  </div>  

  
  <? } elseif ($purchaseType==2){?> 
<div class="width_366 ma font_size11 lH14 pl10 pr5 pb5">  
 <span class="fl"> *</span>  <span class="pl10"> This price includes the Toadsquare Service Fee of the greater of EUR <?php echo $minimumComission0 ?> (USD <?php echo $minimumComission1 ?>) or <?php echo $commisionPercentage ?> percent. It does not include Consumption Tax (VAT, GST, Sales Tax etc.). The Service Fee is not refundable.
 
  Taxes will be added, if applicable, as you checkout.</span></div>
 <div class="width_366 ma font_size11 lH14 pl10 pr5 pb5"> 
	<span class="fl"> *</span>  <span class="pl10 pb7"> Downloads are available for <?php echo $setExpiryDays ?> days.</span>
	<span class="fl"> *</span>  <span class="pl10"> You need a PayPal account to buy from third-party Sellers.</span>
	 </div>  
<div class="width_366 ma font_size11 lH14 pl10 pr5 pb5">
	<span class="fl"> *</span>  <span class="pl10"> After your purchase, we will email you a Sales Record. You can also see it from your Purchases page in your Cart.</span>
</div>

  
  <? } elseif ($purchaseType==3){?> 
<div class="width_366 ma font_size11 lH14 pl10 pr5 pb5">  
 <span class="fl"> *</span>  <span class="pl10"> This price includes the Toadsquare Service Fee of the greater of EUR <?php echo $minimumComission0 ?> (USD <?php echo $minimumComission1 ?>) or <?php echo $commisionPercentage ?> percent. It does not include Consumption Tax (VAT, GST, Sales Tax etc.). The Service Fee is not refundable.
 
  Taxes will be added, if applicable, as you checkout.</span></div>
 <div class="width_366 ma font_size11 lH14 pl10 pr5 pb5"> 
<span class="fl"> *</span>  <span class="pl10 pb7"> Pay-Per-View (PPV) is available for <?php echo $setExpiryDays ?> 
days.</span>
<span class="fl"> *</span>  <span class="pl10"> You need a PayPal account to buy from third-party Sellers.</span></div>  
<div class="width_366 ma font_size11 lH14 pl10 pr5 pb5">
<span class="fl"> *</span>  <span class="pl10"> After your purchase, we will email you a Sales Record. You can also see it from your Purchases page in your Cart.</span>
</div>

<? } ?>

	
	<div class="clear"> </div>
</div>	
	
<?php echo form_close(); ?> 
    
 <script>
 
  // Continue Shopping  
 function buynow(){
    $("#productCart").attr('action','<?php echo base_url(lang()."/cart/buynow")?>');      
	$("#productCart").submit();
 }
 
  // Confirm Billing
 function buylater(){
		//$("#productCart").attr('action','<?php echo base_url(lang()."/cart/buylater")?>');
		//$('#popup_box').hide();
		var baseUrl = '<?php echo base_url(lang()."/cart/buylater")?>';
		
		var fromData=$("#productCart").serialize();
		fromData = fromData+'&ajaxHit=1';
		$('#popup_box').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
		
		$.post(baseUrl,fromData, function(data) {
	  if(data){ 
					refreshPge();
					//$('#popup_box').html(data);
		  }
		});
				
				 
	//$("#productCart").submit();
	//histroy.go(-1);
 }
 
  
 </script>  
