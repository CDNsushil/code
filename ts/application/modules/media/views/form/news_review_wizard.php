<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!--  content wrap  start end -->
<div class="newlanding_container">
	<div class="wizard_wrap fs14">
		<div class="TabbedPanels " id="TabbedPanels1"> 
			<ul id="man_haedtab" class="TabbedPanelsTabGroup pt16 mb10 position_relative z_index_3">
					<li class="TabbedPanelsTab <?php echo isset($s1menu)?$s1menu:'';?>"><span><?php echo $this->lang->line('stage1NewsReviewSetup');?></span></li>
					<li class="TabbedPanelsTab <?php echo isset($s2menu)?$s2menu:'';?>"><span><?php echo $this->lang->line('stage2NewsReviewSetup');?></span></li>
					<li class="TabbedPanelsTab <?php echo isset($s3menu)?$s3menu:'';?>"><span><?php echo $this->lang->line('stage3NewsReviewSetup');?></span></li>
			</ul>
			<!-- ================================main tab content  ======================= -->
			<div class="TabbedPanelsContentGroup main_tab m_auto a_one sale_yes"> 
				<div class="TabbedPanelsContent  TabbedPanelsContentVisible Upload_wrap" style="display: block;">
                    <?php $this->load->view($innerPage); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--  content wrap  end --> 
