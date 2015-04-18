<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$lang=lang();
$formAttributes = array(
	'name'=>'competitionForm',
	'id'=>'competitionForm'
);
$competitionIdInput = array(
	'name'	=> 'competitionId',
	'id'	=> 'competitionId',
	'type'	=> 'hidden',
	'value'	=> $competitionId
);
$competitionLangIdInput = array(
	'name'	=> 'competitionLangId',
	'id'	=> 'competitionLangId',
	'type'	=> 'hidden',
	'value'	=> $competitionLangId
);

$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'title',
	'class'	=> 'required width556px',
	'value'	=> $competitionData->title
);
?>

<div class="row form_wrapper">
	
	<?php echo $header; ?>
	
	<div class="row position_relative">	
		<?php $this->load->view("common/strip");
		echo form_open($lang.'/competition/saveCompetitionLang',$formAttributes);
			echo form_input($competitionIdInput);
			echo form_input($competitionLangIdInput);
			$languageList = getlanguageList();
			?>
		
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('language');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							echo form_dropdown('languageId', $languageList, $competitionData->languageId,'id="languageId" class="required NumGrtrZero" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
				<div class="cell frm_element_wrapper" >
					<?php echo form_input($titleInput); ?>
				</div>
			</div>
			
			<?php 
				$data=array('name'=>'tagwords','id'=>'tagwords','value'=>$competitionData->tagwords,'required'=>'required', 'labelText'=>'tagWords');
				$this->load->view("common/tag_words",$data);
			
				$data=array('name'=>'onelineDescription','id'=>'onelineDescription','value'=>$competitionData->onelineDescription, 'required'=>'required', 'labelText'=>'oneLineDescription');
				$this->load->view("common/oneline_description",$data);
				
			?>
			
			<div class="seprator_25 clear row"></div>
			<div class="row">
				<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class="cell frm_element_wrapper">
					<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
					 <?php
						
						if(isset($competitionId) && !empty($competitionId)){
							
							// if competition is published then can't be edit
							if(isCompetitionPublished($competitionId)){
								$button=array('saveCompetition');
							}else{
								$button=array('save','cancelForm');
							}	
						}else{
							$button=array('save','cancelForm');
						}
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
		$("#competitionForm").validate();
	});
	
	// when competition is published and it have one entry then can't be edit.
	function isBlockEdit()
	{
		customAlert('<?php echo $this->lang->line('cannotEditCompMsg'); ?>');
		return false;
	}
	
</script>
