<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<ul class="TabbedPanelsTabGroup mb10 position_relative z_index_3 " id="man_haedtab">
  <li class="TabbedPanelsTab <?php echo ($packagestage=='1')?'TabbedPanelsTabSelected':''; ?>  "><a href="javascript:void(0);"><span><?php echo $this->lang->line('pack_stage_1'); ?></span></a></li>
  <li class="TabbedPanelsTab <?php echo ($packagestage=='2')?'TabbedPanelsTabSelected':''; ?>" tabindex="0"><a href="javascript:void(0);"><span><?php echo $this->lang->line('pack_stage_2'); ?></span></a></li>
  <li class="TabbedPanelsTab <?php echo ($packagestage=='3')?'TabbedPanelsTabSelected':''; ?>" tabindex="0"><a href="javascript:void(0);"><span><?php echo $this->lang->line('pack_stage_3'); ?></span></a></li>
  <?php  if($selectedPacakge!=$this->config->item('package_type_1')){  ?>
    <li class="TabbedPanelsTab <?php echo ($packagestage=='4')?'TabbedPanelsTabSelected':''; ?>" ><a href="javascript:void(0);"><span><?php echo $this->lang->line('pack_stage_4'); ?></span></a></li>
  <?php } ?>
</ul>
