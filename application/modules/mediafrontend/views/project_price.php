<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row">
	<div class="cell position_relative hiddenspace">
	  <div class="huge_btn Price_btn_style"><?php echo $constant['product'];?> <br />
		<?php echo $this->lang->line('EURO').'&nbsp;'.number_format($project['projPrice'],2);?></div>
	  <div class="huge_btn shipping_btn_style"><?php echo $this->lang->line('shippingCharges');?></div>
	</div>
	<div class="cell position_relative ml18">
	  <div class="huge_btn Price_btn_style"><?php echo $constant['project_download'];?> <br />
		<?php echo $this->lang->line('EURO').'&nbsp;'.number_format($project['projDownloadPrice'],2);?></div>
	</div>
</div>
 
