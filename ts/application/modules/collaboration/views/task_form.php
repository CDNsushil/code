<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//$browseId='_cm';
$formAttributes = array(
	'name'=>'collaborationtaskForm',
	'id'=>'collaborationtaskForm'
);
$taskIdInput = array(
	'name'	=> 'taskId',
	'id'	=> 'taskId',
	'type'	=> 'hidden',
	'value'	=> '0'
);
$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'collaborationtaskTitle',
	'class'	=> 'required width556px',
	'value'	=> ''
);
$estimatedTimeInput = array(
	'name'	=> 'estimatedTime',
	'id'	=> 'estimatedTime',
	'class'	=> 'width238px number',
	'value'	=> ''
);

$startDateInput = array(
	'name'	=> 'startDate',
	'id'	=> 'startDate',
	'class'       => 'date-input required width_196',
	'value'	=> '',
	'readonly' =>true
);

$endDateInput = array(
	'name'	=> 'endDate',
	'id'	=> 'endDate',
	'class'       => 'date-input required width_196',
	'title'       => 'End date must be after the start date.',
	'dategreaterthan'       => '#startDate',
	'value'	=>  '',
	'readonly' =>true
);
$collaborationIdInput = array(
	'name'	=> 'collaborationId',
	'value'	=> $collaborationId,
	'id'	=> 'collaborationId',
	'type'	=> 'hidden'
);
$displayForm="";
if(isset($taskData) && count($taskData) > 0 && !empty($taskData) ) {
	$displayForm="dn";
}

?>

		
<div class="row <?php echo $displayForm;?>" id="collaborationtaskFormDiv">	
	<div class="row"><div class="tab_shadow"></div></div>
	<div class="seprator_5 clear row"></div>
	<div class="clear"></div>

	<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
	<div class="upload_media_left_box">
		<?php
		echo form_open($this->uri->uri_string(),$formAttributes); 
			echo form_input($taskIdInput);
			echo form_input($collaborationIdInput);?>

			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
				<div class="cell frm_element_wrapper" >
					<?php echo form_input($titleInput); ?>
				</div>
			</div>
			
			<?php
				$data=array('name'=>'description','id'=>'description','value'=>'', 'required'=>'', 'labelText'=>'description');
				$this->load->view("common/description",$data);
			?>
			
			<div class="row">
				<div class="cell label_wrapper"><label class=""><?php echo $this->lang->line('milestone');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							if(isset($milestonData) && is_array($milestonData) && count($milestonData) > 0){
								$milestonList= array('0'=>'Select Milestone');
								foreach($milestonData as $ms){
									if(is_numeric($ms->milestoneId) && ($ms->milestoneId >=1)){
										$milestonList[$ms->milestoneId]=$ms->title;
									}
								}
							}
							echo form_dropdown('milestoneId', $milestonList, 0,'id="milestoneId" class="width_254" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			</div>
			
			<!-- <div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('status');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							$statusList= array('0'=>'New', '1'=>'In Progress', '2'=>'Pending', '3'=>'Compeleted', '4'=>'FeedBack', '5'=>'Closed');
							echo form_dropdown('status', $statusList, 0,'id="status" class="width_254 required" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			</div> -->
			
			
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('priority');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php 
							$priorityList= array('0'=>'Low', '1'=>'Normal', '2'=>'Hiegh', '3'=>'Urgent', '4'=>'Immediate', '5'=>'Closed');
							echo form_dropdown('priority', $priorityList, 0,'id="priority" class="width_254 required" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			</div>
			
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('assignee');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							if(isset($membersData) && is_array($membersData) && count($membersData) > 0){
								$membresList= array('0'=>'All Members');
								foreach($membersData as $md){
									if(is_numeric($md->tdsUid) && ($md->tdsUid >=1)){
										$memberName= ($md->enterprise == 't')?$md->enterpriseName:$md->firstName.' '.$md->lastName;
										$membresList[$md->memberId]=$memberName;
									}
								}
							}
							echo form_dropdown('memberId', $membresList, 0,'id="memberId" class="width_254 required" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('task');?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<div class="cell pt5 width_40">
						<?php echo $this->lang->line('start'); ?>
					</div>
					<div class="cell">
						<?php echo form_input($startDateInput); ?>
					</div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#startDate").focus();' /> </div>
					<div class="cell pl25 pt5 width_40">
						<?php echo $this->lang->line('end'); ?>
					</div>
					<div class="cell">
						<?php echo form_input($endDateInput); ?>
					</div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#endDate").focus();' /> </div>
				</div>
			</div>
			<!--<div class="row">
				<div class="cell label_wrapper"><label class=""><?php echo $this->lang->line('estimatedTime');?></label></div>
				<div class="cell frm_element_wrapper width260px" >
					<?php echo form_input($estimatedTimeInput); ?>
				</div>
				<div class="cell pt10" >Hours</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('perDone');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							
							$perDone= array();
							for($i=0; $i<=100; $i=$i+10){
									$perDone[$i]=$i.' %';
							}
							
							echo form_dropdown('completePercentage', $perDone, 0,'id="completePercentage" class="width_254 required" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			</div>-->
			
			
			<div class="seprator_25 clear row"></div>
 			<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class=" cell frm_element_wrapper">
					<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
						<div class="tds-button Fright mr10"> <button name="savetask" value="savetask" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="submit"><span><div class="Fleft"><?php echo $this->lang->line('submit'); ?></div> <div class="icon-publish-btn"></div></span> </button> </div>
						<div class="tds-button Fright mr18"><button id="CGcancelButton" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="button"><span><div class="Fleft"><?php echo $this->lang->line('cancel'); ?></div> <div class="icon-cancel-btn-new"></div> </span> </button> </div>
					<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
				</div>
				<?php echo form_close(); ?>
			</div>
	<div class="upload_media_left_bottom row"></div>
	<div class="seprator_25 clear"></div>	
</div>
<div id="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="0" /></div>	
<div class="row">
	<div class="tab_shadow"></div>
</div>		
<script>
	$(document).ready(function(){
		
		$("#CGcancelButton").click(function(){
			var browseId = '<?php echo $browseId;?>';
			$('#collaborationtaskForm')[0].reset();
			$('#collaborationtaskForm form input[type=hidden]').val('');
			$('#collaborationId').val('<?php echo $collaborationId;?>');
			$('#taskId').val('0');
			$("#collaborationtaskFormDiv").slideToggle('slow');
		});
		
		$("#collaborationtaskForm").validate({
			submitHandler: function() {
				var fromData=$("#collaborationtaskForm").serialize();
				var url = baseUrl+language+'/collaboration/saveTodos/';
				$.post(url,fromData, function(data) {
				  if(data){
					  refreshPge();
				  }
				},"json");
			}
		});
	});
	
</script>
