<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 ?>
 <div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
	<div id="show_comment" class="dash_boxgradient min_height_125 width228px">
		<a target="_blank" href="<?php  echo base_url().'showcase/aboutme/'.$PurchaseRecord->sellerId; ?>">
		<div class="seprator_5"></div>
		<div class="row clr_888 pl10">
		<b><?php echo ucwords($getSellerDetail->firstName.' '.$getSellerDetail->lastName); ?></b><br>
		<?php echo $getSellerDetail->seller_address1; ?> <br>
		<?php echo $getSellerDetail->seller_city; ?>, <?php echo $getSellerDetail->seller_state; ?>  <?php echo $getSellerDetail->seller_zip; ?> <br>
		<?php echo $getSellerDetail->territoryCountryId; ?><br />
		<?php echo $getSellerDetail->seller_phone; ?><br />
		
<a class="hoverOrange" href="mailto:<?php echo $getSellerDetail->email; ?>?subject=InvoiceId:<?php echo $invoiceId ?>">		
		<?php echo $getSellerDetail->email; ?>
	</a>	
		
		
		</div>
		<a>	
	</div>

