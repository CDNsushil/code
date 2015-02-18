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

		
?>

<div class="row form_wrapper">
	
	<?php echo $header; ?>
	
	<div class="row position_relative">	
		<?php $this->load->view("common/strip");
		echo form_open($lang.'/competition/saveCompetitionCriteriaLang',$formAttributes);
		echo form_input($competitionIdInput);
		echo form_input($competitionLangIdInput);
		
		?>
		
			
			<div class="row">
				<div id="descrules" class="cell label_wrapper">
					<label class="select_field"><?php echo $this->lang->line('competitionCriteria');?></label>
				</div>
				<div class="cell frm_element_wrapper">
					<textarea  class="width556px rz required" id="criteria" rows="8" cols="90" name="criteria"><?php echo $competitionData->criteria; ?></textarea>
					<div id="criteria_validate"  class="error dn"><?php echo $this->lang->line('this_is_required_field'); ?></div>
				</div>
			</div>
			
			<div class="seprator_25 clear row"></div>
			<div class="row">
				<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class="cell frm_element_wrapper">
					<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
					 <?php
					 	$isEditBlock=false;
						if(isset($competitionId) && !empty($competitionId)){
							$button=array('save');
							// if competition is published then can't be edit
							if(isCompetitionPublished($competitionId)){
								$isEditBlock=true;
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
	
	bkLib.onDomLoaded(function() {
		var myNicEditor = new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','hr','subscript','superscript','link','unlink']});
		myNicEditor.panelInstance('criteria');
	});
	
	$(document).ready(function(){
		
		// when competition is published and it have one entry then can't be edit
		var isBlockEdit = '<?php echo ($isEditBlock)?"1":"0"; ?>';
		
		$("#competitionForm").validate({
				submitHandler: function() {
				var returnFlag = true;
				var criteria=$('.nicEdit-main').html().replace(/^\s+|\s+$/g,"");
				//----------validate Competition Criteria field code-------//	
				var checkBlank = criteria.replace(/^\&nbsp\;|<br?\>*/gi, "").replace(/\&nbsp\;|<br?\>$/gi, "").trim();;
				var regex = /(<([^>]+)>)/ig;
				checkBlank = checkBlank.replace(regex, "");
				if(!checkBlank.length > 0) {
					$("#criteria_validate").show();
					returnFlag = false;
				}else{
					$("#criteria_validate").hide();
				}
				
				if(returnFlag){
					$("#criteria").val(criteria);
					var fromData=$("#competitionForm").serialize();
					var url = baseUrl+language+'/competition/saveCompetitionCriteriaLang';
					if(isBlockEdit=='0'){
						$.post(url,fromData, function(data) {
							if(data.msg){
								$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
								timeout = setTimeout(hideDiv, 5000);
							}
						},"json");
					}else{
						customAlert('<?php echo $this->lang->line('cannotEditCompMsgCriteria'); ?>');
					}
				}
			}
		});
	});
</script>
