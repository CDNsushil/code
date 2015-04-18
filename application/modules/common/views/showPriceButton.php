<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
if(@$price>0) { 
  $priceDetails = getDisplayPrice($price,$seller_currency);
if(strcmp($buttonStyle,'big')==0) {
?>       
<div class="<?php echo $buttonClass;?>">
  <div class="huge_btn Price_btn_style"><?php echo $this->lang->line('product');?> <br>
	<?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice'];?>
   </div>
  <?php echo $shippingView = $this->load->view('shipping/shipping_frontend_view',array('elementId'=>$elementId,'entityId'=>$entityId),true);?>
<div class="clear"></div>
</div> 
   
<?php }
else { ?>
<div class="tds-button01 cell mr3"> 
	<a onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)">
		<span>
			<?php echo $this->lang->line('product').'&nbsp;'.$priceDetails['currencySign'].'&nbsp;'.$priceDetails['displayPrice'];?>
		</span>
	</a> 
</div>
<?php }
} //end if price>0
?>
