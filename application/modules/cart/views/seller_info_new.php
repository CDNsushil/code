<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
 <!--
<div class="poup_bx min_wi250 shadow">
<div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
<div class="row clr_444 pt10">
    <a target="_blank" class="color_444_imp td_imp" href="<?php  //echo base_url().'showcase/aboutme/'.$PurchaseRecord->sellerId; ?>">
    <b><?php //echo ucwords($getSellerDetail->firstName.' '.$getSellerDetail->lastName); ?></b> <br>
<br>
<?php //echo $getSellerDetail->seller_address1; ?> <br>
<?php //echo $getSellerDetail->seller_city; ?>, <?php //echo $getSellerDetail->seller_state; ?>  <?php //echo $getSellerDetail->seller_zip; ?> <br>
		<?php //echo $getSellerDetail->territoryCountryId; ?> <br>
<br>
<?php //echo $getSellerDetail->seller_phone; ?> <br>
</a> <a href="mailto:<?php //echo $getSellerDetail->email; ?>?subject=InvoiceId:<?php //echo $invoiceId ?>"> <?php //echo $getSellerDetail->email; ?></a> <br>
</div>
-->



<div class="poup_bx min_wi250 shadow">
<div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
            <div class="row clr_444 pt10"> 
	<a target="_blank" class="color_444_imp td_imp" href="<?php  echo base_url().'showcase/aboutme/'.$PurchaseRecord->sellerId; ?>">
    
	<p class="opens_light fs20 red"><?php echo ucwords($getSellerDetail->firstName.' '.$getSellerDetail->lastName); ?></p> 
        <br>
        <?php echo $getSellerDetail->seller_address1; ?> <br>
<?php echo $getSellerDetail->seller_city; ?>, <?php echo $getSellerDetail->seller_state; ?>  <?php echo $getSellerDetail->seller_zip; ?> <br>
<?php echo $getSellerDetail->territoryCountryId; ?><br>
        <br>
        <?php echo $getSellerDetail->seller_phone; ?>  <br>
     </a>  <a href="mailto:<?php echo $getSellerDetail->email; ?>?subject=InvoiceId:<?php echo $invoiceId ?>"> <?php echo $getSellerDetail->email; ?></a> <br>
      </div>
          </div>

