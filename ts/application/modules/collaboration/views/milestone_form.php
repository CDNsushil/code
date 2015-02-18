<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//$browseId='_cm';
$formAttributes = array(
	'name'=>'collaborationmilestoneForm',
	'id'=>'collaborationmilestoneForm'
);
$milestoneIdInput = array(
	'name'	=> 'milestoneId',
	'id'	=> 'milestoneId',
	'type'	=> 'hidden',
	'value'	=> '0'
);
$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'collaborationmilestoneTitle',
	'class'	=> 'required width556px',
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
if(isset($milestoneData) && count($milestoneData) > 0 && !empty($milestoneData) ) {
	$displayForm="dn";
}

?>

<div class="row <?php echo $displayForm;?>" id="collaborationmilestoneFormDiv">
	<div class="row"><div class="tab_shadow"></div></div>
	<div class="seprator_5 clear row"></div>
	<div class="clear"></div>
	
	<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
	<div class="upload_media_left_box">
		<?php
		echo form_open($this->uri->uri_string(),$formAttributes); 
			echo form_input($milestoneIdInput);
			echo form_input($collaborationIdInput);?>

			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
				<div class="cell frm_element_wrapper" >
					<?php echo form_input($titleInput); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('milestone');?></label></div>
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
			
			<?php
				$data=array('name'=>'description','id'=>'description','value'=>'', 'required'=>'', 'labelText'=>'description');
				$this->load->view("common/description",$data);
			?>
			
			
			<div class="seprator_25 clear row"></div>
 			<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class=" cell frm_element_wrapper">
					<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
						<div class="tds-button Fright mr10"> <button name="savemilestone" value="savemilestone" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="submit"><span><div class="Fleft"><?php echo $this->lang->line('submit'); ?></div> <div class="icon-publish-btn"></div></span> </button> </div>
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
			$('#collaborationmilestoneForm')[0].reset();
			$('#collaborationmilestoneForm form input[type=hidden]').val('');
			$('#collaborationId').val('<?php echo $collaborationId;?>');
			$('#milestoneId').val('0');
			$("#collaborationmilestoneFormDiv").slideToggle('slow');
		});
		
		$("#collaborationmilestoneForm").validate({
			submitHandler: function() {
				var fromData=$("#collaborationmilestoneForm").serialize();
				var url = baseUrl+language+'/collaboration/saveMilestones/';
				$.post(url,fromData, function(data) {
				  if(data){
					  refreshPge();
				  }
				},"json");
			}
		});
	});
	
</script>
