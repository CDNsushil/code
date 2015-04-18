<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$lang=lang();
$fileMaxSize = $this->config->item('defaultContainerSize');
$lang=lang();
$formAttributes = array(
	'name'=>'competetionPrize',
	'id'=>'competetionPrize'
);
$competitionIdInput = array(
	'name'	=> 'competitionId',
	'id'	=> 'competitionId',
	'type'	=> 'hidden',
	'value'	=> $competitionId
);

$compPrizeIdInput = array(
	'name'	=> 'compPrizeId',
	'id'	=> 'compPrizeId',
	'type'	=> 'hidden',
	'value'	=> 0
);
$prizeLangIdInput = array(
	'name'	=> 'prizeLangId',
	'id'	=> 'prizeLangId',
	'type'	=> 'hidden',
	'value'	=> 0
);
$orderInput = array(
	'name'	=> 'order',
	'id'	=> 'order',
	'type'	=> 'hidden',
	'value'	=> 0
);
$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'title',
	'class'	=> 'required width556px',
	'value'	=> ''
);

?>

<div class="row form_wrapper" >
	<?php echo $header; ?>
	<div class="row position_relative" >	
		
		<?php $this->load->view("common/strip");?>
		<div class="seprator_5 clear row"></div>
		<div class="row dn" id="competitionPrizeForm">
			<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
			<div class="upload_media_left_box">
				<?php echo form_open($lang.'/competition/savePrizelang2',$formAttributes); ?>
					
					<div class="row">
						<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
						<div class="cell frm_element_wrapper" >
							<?php echo form_input($titleInput); ?>
						</div>
					</div>
					
					<?php 	
					$data=array('name'=>'onelineDescription','id'=>'onelineDescriptionLabel','value'=>'', 'required'=>'required', 'labelText'=>'oneLineDescription');
					$this->load->view("common/oneline_description",$data);
					
					$data=array('name'=>'tagwords','id'=>'tagwords','value'=>'','required'=>'required', 'labelText'=>'tagWords');
					$this->load->view("common/tag_words",$data);
				
					$data=array('name'=>'description','id'=>'description','value'=>'', 'required'=>'', 'labelText'=>'description');
					$this->load->view("common/description",$data); ?>
						
					<div class="seprator_15 clear"></div>

					<div class="seprator_25 clear row"></div>
					<div class="row">
						<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
						<div class=" cell frm_element_wrapper">
							<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
							 <?php
								echo form_input($competitionIdInput);
								echo form_input($compPrizeIdInput);
								echo form_input($prizeLangIdInput);
								echo form_input($orderInput);
								
								if(isset($competitionId) && !empty($competitionId)){
									// if competition is published then can't be edit	
									if(isCompetitionPublished($competitionId)){
										$button=array('saveCompetition','cancelForm','buttonId'=>'PZ');
										$this->load->view("common/button_collection",array('button'=>$button)); 
									}else{
										$button=array('save','cancelForm','buttonId'=>'PZ');
										$this->load->view("common/button_collection",array('button'=>$button)); 
									}	
								}else{	
									$button=array('save','cancelForm','buttonId'=>'PZ');
									$this->load->view("common/button_collection",array('button'=>$button)); 
								}
								
							 ?>
							 <div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
						</div>
					</div>
					
				<?php echo form_close(); ?>
			</div>
			<div class="upload_media_left_bottom row"></div>
			<div class="seprator_25 clear row"></div>
		</div>
		
		<div id ="competitionPrizeListing">
			<?php $this->load->view('prize_lang_list'); ?> 
		</div>
	</div>
</div>
<div class="seprator_15 clear row"></div>

<script>
	$(document).ready(function(){
		$("#cancelButtonPZ").click(function(){
			$('#competetionPrize')[0].reset();
			$('#competitionPrizeForm form input[type=hidden]').val('');
			$("#competitionPrizeForm").slideToggle('slow');
		});
		$("#competetionPrize").validate({});
	});
	
	function fillFormValueCG(data,formId){ 
		
		if(!$(formId).is(":visible")){
				$(formId).slideToggle('slow');
		}
		if(data == '0'){
			$(formId+' form')[0].reset();
			$(formId+' form input[type=hidden]').val('');
			
		}else{
			$.each(data, function(key, value){
			  if($(formId+' form [name=' + key + ']') !='undefind'){
				  $(formId+' form [name=' + key + ']').val(value);
			  }
			});
		}
	}
	
	// when competition is published and it have one entry then can't be edit.
	function isBlockEdit()
	{
		customAlert('<?php echo $this->lang->line('cannotEditCompMsgPrize'); ?>');
		return false;
	}
	
	
	// when competition is published and it have one entry then can't be delete.
	function isDeleteBlock()
	{
		customAlert('<?php echo $this->lang->line('cannotDeleteCompMsgPrize'); ?>');
		return false;
	}
</script>



