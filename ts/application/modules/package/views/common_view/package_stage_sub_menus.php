<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<ul class="TabbedPanelsTabGroup font_weight">
   <li class="TabbedPanelsTab <?php echo ($packagestagesubmenu=='1')?'TabbedPanelsTabSelected':''; ?>" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('packpayment_sept1_membership_cart'); ?></span></a></li>
   <li class="TabbedPanelsTab <?php echo ($packagestagesubmenu=='2')?'TabbedPanelsTabSelected':''; ?>" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('packpayment_sept2_billing_details'); ?></span></a></li>
   <li class="TabbedPanelsTab <?php echo ($packagestagesubmenu=='3')?'TabbedPanelsTabSelected':''; ?>" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('packpayment_sept3_summary'); ?></span></a></li>
   <li class="TabbedPanelsTab <?php echo ($packagestagesubmenu=='4')?'TabbedPanelsTabSelected':''; ?>" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('packpayment_sept4_payment'); ?></span></a></li>
</ul>
