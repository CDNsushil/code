<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<ul class="TabbedPanelsTabGroup font_weight">
   <li class="TabbedPanelsTab <?php echo ($renewstagesubmenu=='1')?'TabbedPanelsTabSelected':''; ?>" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('packrenewpayment_sept1_billing'); ?></span></a></li>
   <li class="TabbedPanelsTab <?php echo ($renewstagesubmenu=='2')?'TabbedPanelsTabSelected':''; ?>" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('packrenewpayment_sept2_summary'); ?></span></a></li>
   <li class="TabbedPanelsTab <?php echo ($renewstagesubmenu=='3')?'TabbedPanelsTabSelected':''; ?>" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('packrenewpayment_sept3_payment'); ?></span></a></li>
</ul>
