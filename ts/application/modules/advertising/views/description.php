<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$formAttributes = array(
	'name'=>'descriptionForm',
	'id'=>'descriptionForm'
);
$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'title',
	'class'	=> 'required width556px',
	'value'	=> set_value('title',@$campaignData['campaignname']),	
);
if(isset($campaignData['expire_time']) && !empty($campaignData['expire_time'])) $expireTime = date("d F Y", strtotime(substr(@$campaignData['expire_time'],0,-9)));
$completionDate = array(
	'name'	=> 'completionDate',
	'id'	=> 'completionDate',
	'class' => 'date-input required width_196',
	'value'	=> set_value('completionDate',@$expireTime),	
	'readonly' =>true
);

$campaignIdInput = array(
		'name'	=> 'campaignId',
		'id'	=> 'campaignId',
		'type'	=> 'hidden',
		'value'	=> set_value('campaignId',@$campaignData['campaignid']),	
	);

$revenueTypeInput = array(
		'name'	=> 'revenueType',
		'id'	=> 'revenueType',
		'type'	=> 'hidden',
		'value'	=> '1'
	);
$advirtiserId = array(
		'name'	=> 'advirtiserId',
		'id'	=> 'advirtiserId',
		'type'	=> 'hidden',
		'value'	=> $oxUserDetails->advirtiserId,
	);	

?>

<div class="row form_wrapper">
	<div id="descSuccessMsg" class="f16 ml34 orange_color fm_os tac"></div>
	<?php echo $this->load->view('advertHeader'); ?>
	
	<div class="row position_relative">	
		<?php $this->load->view("common/strip");
		echo form_open($this->uri->uri_string(),$formAttributes); ?>
			 
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
				<div class="cell frm_element_wrapper" >
					<?php echo form_input($titleInput); ?>
				</div>
			</div>
			
			<?php 
				$data=array('name'=>'tagwords','id'=>'tagwords','value'	=> set_value('tagwords',@$campaignData['comments']),'required'=>'required', 'labelText'=>'tagWords');
				$this->load->view("common/tag_words",$data);
			?>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('CompletionDate');?></label></div>
				<div class="cell frm_element_wrapper" >
					<div class="cell">
						<?php echo form_input($completionDate); ?>
					</div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#completionDate").focus();' /> </div>
				</div>
			</div>
			
			<div class="seprator_25 clear row"></div>
			<div class="row">
				<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class="cell frm_element_wrapper">
					<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
						<?php
						//set hidden fields
						echo form_input($campaignIdInput);
						echo form_input($revenueTypeInput);
						echo form_input($advirtiserId);
						
						//$button=array('save','cancelForm');
						$button=array('save');
						$this->load->view("common/button_collection",array('button'=>$button)); 
					 ?>
					 <div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
				</div>
			</div>
		<?php echo form_close(); ?>
		<div class="seprator_25 clear row"></div>
	</div>
</div>

<script>
	$(document).ready(function(){
	$("#descriptionForm").validate({
		 submitHandler: function() {
			var fromData=$("#descriptionForm").serialize(); 	
			openLightBoxWithoutAjax('popupBoxWp','popup_box'); 
			$.post(baseUrl+language+'/advertising/saveDescription',fromData, function(data) {
			  if(data){
					var getObj = $.parseJSON(data);
					var  campaignId= getObj.campaignId;
					window.location.href = baseUrl+language+'/advertising/description/'+campaignId;
				}
			});
		 }
	});
});
</script>
