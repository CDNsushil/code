<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<ul class="TabbedPanelsTabGroup mb10 position_relative z_index_3 " id="man_haedtab">
  <li class="TabbedPanelsTab <?php echo ($refundtage=='1')?'TabbedPanelsTabSelected':''; ?>  " tabindex="1"><a href="javascript:void(0);"><span><?php echo $this->lang->line('pack_refund_stage_1'); ?></span></a></li>
  <li class="TabbedPanelsTab <?php echo ($refundtage=='2')?'TabbedPanelsTabSelected':''; ?>"   tabindex="2"><a href="javascript:void(0);"><span> <?php echo $this->lang->line('pack_refund_stage_2'); ?> </span></a></li>
  <li class="TabbedPanelsTab <?php echo ($refundtage=='3')?'TabbedPanelsTabSelected':''; ?>"   tabindex="2"><a href="javascript:void(0);"><span> <?php echo $this->lang->line('pack_refund_stage_3'); ?> </span></a></li>
</ul>
