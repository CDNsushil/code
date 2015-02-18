<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


 $methodName=  $this->uri->segment(3);
 $salesActive="";
 $cartActive="";
 $purchaseActive="";
 	switch($methodName)
	{
    case 'sales_information':
    case 'sales_order':
    case 'sales':
         $salesActive ='class="selected"'; 
    break;
    case 'sales_record':
    case 'purchase':
       $purchaseActive ='class="selected"'; 
    break;
    default;
         $cartActive ='class="selected"'; 
    break;
	}
?>


<div class="SCart_subMenu_inner">
                    <ul>
                      <li><a href="<?php echo base_url('cart/sales'); ?>" <?php echo $salesActive; ?> ><?php echo $this->lang->line('menu_sales'); ?></a></li>
                      <li><a href="<?php echo base_url('cart/purchase'); ?>"  <?php echo $purchaseActive; ?>><?php echo $this->lang->line('menu_purchases'); ?></a></li>
                      <li><a href="<?php echo base_url('cart/wishlist'); ?>" <?php echo $cartActive; ?>><?php echo $this->lang->line('menu_cart'); ?></a></li>
                    </ul>
</div>
               
