<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$lang=lang();
$competitionMediaLimit = $this->config->item('competitionMediaLimit');

$formAttributes = array(
	'name'=>'competitionMediaForm',
	'id'=>'competitionMediaForm'
);

$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'competitionMediaTitle',
	'class'	=> 'required width556px',
	'value'	=> ''
);

$mediaLangIdInput = array(
	'name'	=> 'mediaLangId',
	'id'	=> 'mediaLangId',
	'type'	=> 'hidden',
	'value'	=> 0
);

$mediaIdInput = array(
	'name'	=> 'mediaId',
	'id'	=> 'mediaId',
	'type'	=> 'hidden',
	'value'	=> '0'
);
$competitionIdInput = array(
	'name'	=> 'competitionId',
	'id'	=> 'competitionId',
	'type'	=> 'hidden',
	'value'	=> $competitionId
);
$fileOrderInput = array(
	'name'	=> 'fileOrder',
	'id'	=> 'fileOrder',
	'type'	=> 'hidden',
	'value'	=> 0
);

$countMediaData = (isset($countMediaData) && is_numeric($countMediaData))?$countMediaData:0;


?>
			<div class="seprator_5 clear row"></div>
			<div class="row dn" id="competitionMediaFormDiv">	
				
				<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
				<div class="upload_media_left_box">
					<?php echo form_open($lang.'/competition/saveCompMedialang2',$formAttributes);
						echo form_input($mediaLangIdInput); 
						echo form_input($mediaIdInput); 
						echo form_input($competitionIdInput); 
						echo form_input($fileOrderInput); 
						
						?>

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
						
						
						<div class="seprator_25 clear row"></div>
							
						
						<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
						<div class=" cell frm_element_wrapper">
							<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
								<?php
								if(isset($competitionId) && !empty($competitionId)){
							
									// if competition is published then can't be edit	
									if(isCompetitionPublished($competitionId)){
										$button=array('saveCompetition','cancelForm','buttonId'=>'ML');
										$this->load->view("common/button_collection",array('button'=>$button)); 
									}else{
										$button=array('save','cancelForm','buttonId'=>'ML');
										$this->load->view("common/button_collection",array('button'=>$button)); 
									}	
								}else{	
									$button=array('save','cancelForm','buttonId'=>'ML');
									$this->load->view("common/button_collection",array('button'=>$button)); 
								}
							 ?>
							<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
						</div>
					<?php 
					echo form_close(); ?>
				</div>
				<div class="upload_media_left_bottom row"></div>
				
			</div>
<script>
	$(document).ready(function(){
		$("#cancelButtonML").click(function(){
		
			$('#competitionMediaForm')[0].reset();
			$('#competitionMediaForm form input[type=hidden]').val('');
			$("#competitionMediaFormDiv").slideToggle('slow');
		});
		$("#competitionMediaForm").validate({});
	});
	function fillFormValueML(data,formId){ 
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
		customAlert('<?php echo $this->lang->line('cannotEditCompMsgRequiredMedia'); ?>');
		return false;
	}
	
	// when competition is published and it have one entry then can't be delete.
	function isDeleteBlock()
	{
		customAlert('<?php echo $this->lang->line('cannotDeleteCompMsgRequiredMedia'); ?>');
		return false;
	}
</script>
