<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="seprator_10"></div>
<div class="font_museoSlab font_size24 clr_f1592a lineH38 pl20 height40"><?php echo $this->lang->line('collaborationAccess'); ?></div>
<div class="dashboard_topgbox_1 bdr_non width458 dashfvslider" id="clbSlider">
	<a class="buttons prev" href="#"></a>
		<div class="viewport dashvf_container height_515 ml6">
			<ul class="overview">
				<?php
				foreach($clbData as $k=>$data){ ?>
					<li class="heightAuto">
						<a href="<?php echo base_url(lang().'/collaboration/assignedCollaboration/'.$data->collaborationId)?>" ><div class="Members-Buy-Tools_shedow mt0 pr15 ml0">
							<div class="dash_Atool_list_box pb15 ml5 ">
								<div class="dash_headgrad font_opensansSBold font_size13 clr_444 pt7 pb8 pl20 org_anchor_hover">
									<?php echo $data->title?>  
								</div>
							   
								<div class="seprator_5"></div>
								
								<div class="pl20 pr5">
									<div class="row"> 
										<div class="fl width_50  font_opensans font_size12 clr_555">Start</div>
										<div class="fl width_130 font_opensansSBold font_size12 clr_555 ml15"><?php  echo date("d F Y", strtotime($data->startDate)); ?></div>
										<div class="fl width_50 font_opensans font_size12 clr_555 ml10">Assign</div>
										<div class="fl width_130 font_opensansSBold font_size12 clr_555 ml10"><?php  echo date("d F Y", strtotime($data->createdDate)); ?></div>
										<div class="clear"></div>
									</div>
									
									<div class="seprator_3"></div>
									
									<div class="row"> 
										<div class="fl width_50  font_opensans font_size12 clr_555"> End</div>
										<div class="fl width_130 font_opensansSBold font_size12 clr_f1592a ml15 clr_f1592a"><?php  echo date("d F Y", strtotime($data->endDate)); ?></div>
										<div class="fl width_50 font_opensans font_size12 clr_555 ml10">Members</div>
										<div class="fl width_130 font_opensansSBold font_size12 clr_555 ml10"><?php echo countResult('CollaborationMembers',array('collaborationId'=>$data->collaborationId,'status'=>1))?></div>
										<div class="clear"></div>
									</div>
								</div>
								
							</div>  
						</div></a> 
					</li>
					<?php
				} ?>
			</ul>
		</div>
	<a class="buttons next" href="#"></a>
</div>

<script type="text/javascript">
	/*tab function*/
	$(document).ready(function(){
		if($('#clbSlider'))	
		$('#clbSlider').tinycarousel({ axis: 'y', display: 5});	
	});
</script>

