<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
// set form url
$absoluteFormUrl =  formBaseUrl();
$renewProjectId = $this->session->userdata('renewProjectId');
?>
<div class="newlanding_container">
	<div class="wizard_wrap fs14">
		<div class="TabbedPanels " id="TabbedPanels1">
			<div class="TabbedPanelsContentGroup main_tab m_auto"> 
				<div class="TabbedPanelsContent  TabbedPanelsContentVisible tab_setting Upload_wrap" style="display: block;">   
					<ul class="TabbedPanelsTabGroup second_ul pt20 pb20">
						<li class="TabbedPanelsTab <?php echo isset($renew1menu)?$renew1menu:'';?>"><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('renewShowcaseStep1');?></span></li>
						<li class="TabbedPanelsTab <?php echo isset($renew2menu)?$renew2menu:'';?>"><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('renewShowcaseStep2');?></span></li>
						<li class="TabbedPanelsTab <?php echo isset($renew3menu)?$renew3menu:'';?>"><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('renewShowcaseStep3');?></span></li>
						<li class="TabbedPanelsTab <?php echo isset($renew4menu)?$renew4menu:'';?>"><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('renewShowcaseStep4');?></span></li>
					</ul>
					<?php $this->load->view($innerPage);?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--  content wrap  end --> 
