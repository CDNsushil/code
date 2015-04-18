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

$ageRequiresFromInput = array(
	'name'	=> 'ageRequiresFrom',
	'id'	=> 'ageRequiresFrom',
	'class'	=> 'width80px number ',
	'value'	=> (is_numeric($competitionData->ageRequiresFrom) && ($competitionData->ageRequiresFrom > 0))?$competitionData->ageRequiresFrom:''
);
$ageRequiresToInput = array(
	'name'	=> 'ageRequiresTo',
	'id'	=> 'ageRequiresTo',
	'class'	=> 'width80px number ',
	'value'	=> (is_numeric($competitionData->ageRequiresTo) && ($competitionData->ageRequiresTo > 0))?$competitionData->ageRequiresTo:''
);


$competitionCountriesIdInput = array(
	'name'	=> 'competitionCountriesId',
	'id'	=> 'competitionCountriesId',
	'type'	=> 'hidden',
	'value'	=> $competitionData->competitionCountries
);
$votesCountriesIdInput = array(
	'name'	=> 'votesCountriesId',
	'id'	=> 'votesCountriesId',
	'type'	=> 'hidden',
	'value'	=> $competitionData->votesCountries
);		
?>

<div class="row form_wrapper">
	
	<?php echo $header; ?>
	
	<div class="row position_relative">	
		<?php $this->load->view("common/strip");
		echo form_open($lang.'/competition/saveCompetitionCriteria',$formAttributes);
		echo form_input($competitionIdInput);
		
		$languageList = $languageList1 = $languageList2 = getlanguageList();
		?>
		
			
			<div class="row">
				<div id="descrules" class="cell label_wrapper">
					<label class="select_field"><?php echo $this->lang->line('competitionCriteria');?></label>
				</div>
				<div class="cell frm_element_wrapper">
					<textarea  class="width556px rz required" id="rules" rows="8" cols="90" name="rules"><?php echo $competitionData->rules; ?></textarea>
					<div id="criteria_validate"  class="error dn"><?php echo $this->lang->line('this_is_required_field'); ?></div>
				</div>
			</div>
			
				
				
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('mediatoSubmit');?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<div class="row pt5">
							
							<div class="cell defaultP">
							  <input type="radio" <?php if($competitionData->mediaType==2) echo 'checked';?> value="2"  name="mediaType" >
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('audio_visual');?></label>
							</div>
							
							<div class="cell defaultP">
							  <input type="radio" value="3" <?php if($competitionData->mediaType==3) echo 'checked';?> name="mediaType" >
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('audio');?></label>
							</div>
							
							<div class="cell defaultP">
							  <input type="radio" value="1" <?php if($competitionData->mediaType==1) echo 'checked';?> name="mediaType" >
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('image');?></label>
							</div>
							
							
							
							<div class="cell defaultP">
							  <input type="radio" value="4" <?php if($competitionData->mediaType==4) echo 'checked';?> name="mediaType" >
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('text');?></label>
							</div>
							
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('submission_teritory');?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<div class="row pt5">
							
							<div class="cell defaultP">
							  <input type="radio" <?php if($competitionData->teritoryType==0) echo 'checked';?> value="0"  name="teritoryType" onclick="$('#competitionCountryDiv').hide();" />
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('global');?></label>
							</div>
							
							<div class="cell defaultP">
							  <input type="radio" value="1" <?php if($competitionData->teritoryType==1) echo 'checked';?> name="teritoryType" onclick="$('#competitionCountryDiv').show();" />
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('selectCompetitionCountries');?></label>
							</div>
					</div>
				</div>
			</div>
			
			<?php if($competitionData->teritoryType==1){$dn='';} else{$dn='dn';} ?>
			<div class="row <?php echo $dn;?>" id="competitionCountryDiv">
				<div class="cell label_wrapper bg-non"></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<?php $this->load->view('competitionCountryForm');?>
				</div>
			</div>
			<!---show votes countries--->
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('votes_teritory');?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<div class="row pt5">
							
							<div class="cell defaultP">
							  <input type="radio" <?php if($competitionData->voteTeritoryType != 1) echo 'checked';?> value="0"  name="voteTeritoryType" onclick="$('#voteCountryDiv').hide();" />
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('global');?></label>
							</div>
							
							<div class="cell defaultP">
							  <input type="radio" value="1" <?php if($competitionData->voteTeritoryType == 1) echo 'checked';?> name="voteTeritoryType" onclick="$('#voteCountryDiv').show();" />
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('selectVotesCountries');?></label>
							</div>
					</div>
				</div>
			</div>
			
			<?php if($competitionData->voteTeritoryType == 1){$dn='';} else{$dn='dn';} ?>
			<div class="row <?php echo $dn;?>" id="voteCountryDiv">
				<div class="cell label_wrapper bg-non"></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<?php $this->load->view('votesCountryForm');?>
				</div>
			</div>
			
			
			<div class="row">
				<div class="cell label_wrapper"><label><?php echo $this->lang->line('language1');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							echo form_dropdown('criteriaLang1Id', $languageList, $competitionData->criteriaLang1Id,'id="criteriaLang1Id" ');
						?>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label><?php echo $this->lang->line('language2');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							echo form_dropdown('criteriaLang2Id', $languageList2, $competitionData->criteriaLang2Id,'id="criteriaLang2Id" ');
						?>
					<div id="same_lang_validate"  class="error dn"><?php echo $this->lang->line('same_lang_not_allow'); ?></div>
					<div class="font_size11 row">* Entries need to be in: (drop down title Language 1) and (drop down title Language 2)</div>		
				</div>
				
			</div>
			
			
			<div class="seprator_25 clear row"></div>
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('ageRequires');?></label></div>
				<div class="cell frm_element_wrapper">
					<div class="row">
						<?php if($competitionData->ageRestriction == 't'){$daftShow='';} else{$daftShow='dn';} ?>
						<div class="cell pt5 defaultP">
							 <input type="radio" <?php if($competitionData->ageRestriction == 'f') echo 'checked';?> value="f"  name="ageRestriction" onclick="$('#divAgeFromTo').hide();"  />
						</div>
						
						<div class="cell pl5 pr20 pt7">
							All
						</div>
						
						<div class="cell pt5 defaultP">
							 <input type="radio" <?php if($competitionData->ageRestriction == 't') echo 'checked';?> value="t"  name="ageRestriction" onclick="$('#divAgeFromTo').show();"  />
						</div>
						
						<div class="cell pt7"><?php echo $this->lang->line('From'); ?></div>
						<div class="cell <?php echo $daftShow;?>" id="divAgeFromTo">
							<div class="row">
								<div class="cell pl10">
									<?php echo form_input($ageRequiresFromInput); ?>
								</div>
								<div class="cell pt7 pl10 pr5"><?php echo $this->lang->line('To'); ?></div>
								<div class="cell pl7">
									<?php echo form_input($ageRequiresToInput); ?>
								</div>
							</div>
						</div>
					</div>
					<div id="age_criteria_check"  class="row error dn"><?php echo $this->lang->line('this_is_required_field'); ?></div>	
				</div>
			 </div>
			
			
			<div class="seprator_25 clear row"></div>
			<div class="row">
				<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class="cell frm_element_wrapper">
					<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
					 <?php
						echo form_input($competitionCountriesIdInput);
						echo form_input($votesCountriesIdInput);
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
		myNicEditor.panelInstance('rules');
	});
	
	$(document).ready(function(){
		
		// when competition is published and it have one entry then can't be edit
		var isBlockEdit = '<?php echo ($isEditBlock)?"1":"0"; ?>';
		
		$("#competitionForm").validate({
				submitHandler: function() {
				var returnFlag = true;
				var rules=$('.nicEdit-main').html().replace(/^\s+|\s+$/g,"");
				//----------validate Competition Criteria field code-------//	
				var checkBlank = rules.replace(/^\&nbsp\;|<br?\>*/gi, "").replace(/\&nbsp\;|<br?\>$/gi, "").trim();;
				var regex = /(<([^>]+)>)/ig;
				checkBlank = checkBlank.replace(regex, "");
				if(!checkBlank.length > 0) {
					$("#criteria_validate").show();
					returnFlag = false;
				}else{
					$("#criteria_validate").hide();
				}
				
				var lang1=$("#criteriaLang1Id").val();
				var lang2=$("#criteriaLang2Id").val();
				//-----------check language selection----------//
				if((lang1==lang2) && (lang1 > 0 && lang2 > 0)) {
					$("#same_lang_validate").show();
					returnFlag = false;
				}
				else{
					$("#same_lang_validate").hide();
				}
				
				//----------age criteria check------//
				//
				var ageRequiresFrom=$("#ageRequiresFrom").val();
				ageRequiresFrom= $.trim(ageRequiresFrom);
				var ageRequiresTo=$("#ageRequiresTo").val();
				ageRequiresTo= $.trim(ageRequiresTo);
				
				if(ageRequiresFrom =='' || ageRequiresTo==''){
					$("#age_criteria_check").show();
					returnFlag = false;
				}else if(ageRequiresFrom >= ageRequiresTo){
					$("#age_criteria_check").html('Age from should be grater then Age to');
					$("#age_criteria_check").show();
					returnFlag = false;
				}else
				{
					$("#age_criteria_check").hide();
				}
				if(returnFlag){
					$("#rules").val(rules);
					var fromData=$("#competitionForm").serialize();
					var url = baseUrl+language+'/competition/saveCompetitionCriteria';
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
