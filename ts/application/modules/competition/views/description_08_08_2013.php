<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$lang=lang();
$browseId1='_image';
$browseId2='_sample';
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
$sectionIdInput = array(
	'name'	=> 'sectionId',
	'id'	=> 'sectionId',
	'type'	=> 'hidden',
	'value'	=> $sectionId
);
$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'title',
	'class'	=> 'required width556px',
	'value'	=> $competitionData->title
);
$ageRequiresFromInput = array(
	'name'	=> 'ageRequiresFrom',
	'id'	=> 'ageRequiresFrom',
	'class'	=> 'width80px number',
	'value'	=> (is_numeric($competitionData->ageRequiresFrom) && ($competitionData->ageRequiresFrom > 0))?$competitionData->ageRequiresFrom:''
);
$ageRequiresToInput = array(
	'name'	=> 'ageRequiresTo',
	'id'	=> 'ageRequiresTo',
	'class'	=> 'width80px number',
	'value'	=> (is_numeric($competitionData->ageRequiresTo) && ($competitionData->ageRequiresTo > 0))?$competitionData->ageRequiresTo:''
);


/*$spacificationsInput = array(
	'name'	=> 'spacifications',
	'id'	=> 'spacifications',
	'class'	=> 'required width556px',
	'value'	=> $competitionData->spacifications
);*/

/*$dueDateInput = array(
	'name'	=> 'dueDate',
	'id'	=> 'dueDate',
	'class'       => 'date-input required width246px',
	'value'	=> !empty($competitionData->dueDate) ? dateFormatView($competitionData->dueDate,'d M Y') : '',
	'readonly' =>true
);*/

$submissionStartDateInput = array(
	'name'	=> 'submissionStartDate',
	'id'	=> 'submissionStartDate',
	'class'       => 'date-input required width_196',
	'value'	=> !empty($competitionData->submissionStartDate) ? dateFormatView($competitionData->submissionStartDate,'d M Y') : '',
	'readonly' =>true
);

$submissionEndDateInput = array(
	'name'	=> 'submissionEndDate',
	'id'	=> 'submissionEndDate',
	'class'       => 'date-input required width_196',
	'value'	=> !empty($competitionData->submissionStartDate) ? dateFormatView($competitionData->submissionEndDate,'d M Y') : '',
	'readonly' =>true
);

$votingStartDateInput = array(
	'name'	=> 'votingStartDate',
	'id'	=> 'votingStartDate',
	'class'       => 'date-input required width_196',
	'value'	=> !empty($competitionData->submissionStartDate) ? dateFormatView($competitionData->votingStartDate,'d M Y') : '',
	'readonly' =>true
);

$votingEndDateInput = array(
	'name'	=> 'votingEndDate',
	'id'	=> 'votingEndDate',
	'class'       => 'date-input required width_196',
	'value'	=> !empty($competitionData->submissionStartDate) ? dateFormatView($competitionData->votingEndDate,'d M Y') : '',
	'readonly' =>true
);

//-------round 2 submittion and voting section show-------//

$submissionStartDateRound2Input = array(
	'name'	=> 'submissionStartDateRound2',
	'id'	=> 'submissionStartDateRound2',
	'class'       => 'date-input required width_196',
	'value'	=> !empty($competitionData->submissionStartDateRound2) ? dateFormatView($competitionData->submissionStartDateRound2,'d M Y') : '',
	'readonly' =>true
);

$submissionEndDateRound2Input = array(
	'name'	=> 'submissionEndDateRound2',
	'id'	=> 'submissionEndDateRound2',
	'class'       => 'date-input required width_196',
	'value'	=> !empty($competitionData->submissionEndDateRound2) ? dateFormatView($competitionData->submissionEndDateRound2,'d M Y') : '',
	'readonly' =>true
);

$votingStartDateRound2Input = array(
	'name'	=> 'votingStartDateRound2',
	'id'	=> 'votingStartDateRound2',
	'class'       => 'date-input required width_196',
	'value'	=> !empty($competitionData->votingStartDateRound2) ? dateFormatView($competitionData->votingStartDateRound2,'d M Y') : '',
	'readonly' =>true
);

$votingEndDateRound2Input = array(
	'name'	=> 'votingEndDateRound2',
	'id'	=> 'votingEndDateRound2',
	'class'       => 'date-input required width_196',
	'value'	=> !empty($competitionData->votingEndDateRound2) ? dateFormatView($competitionData->votingEndDateRound2,'d M Y') : '',
	'readonly' =>true
);
$Round2MaxEntriesInput = array(
	'name'	=> 'Round2MaxEntries',
	'id'	=> 'Round2MaxEntries',
	'class'	=> 'width236px number',
	'value'	=> (is_numeric($competitionData->Round2MaxEntries) && ($competitionData->Round2MaxEntries > 0))?$competitionData->Round2MaxEntries:''
);

$browseId1stInput = array(
	'name'	=> 'browseId1st',
	'value'	=> $browseId1,
	'id'	=> 'browseId1st',
	'type'	=> 'hidden'
);	

$browseId2ndInput = array(
	'name'	=> 'browseId2nd',
	'value'	=> $browseId2,
	'id'	=> 'browseId2nd',
	'type'	=> 'hidden'
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
		echo form_open($this->uri->uri_string(),$formAttributes);
		echo form_input($competitionIdInput);
		echo form_input($sectionIdInput);
		$languageList = $languageList1 = $languageList2 = getlanguageList();
		?>
		
			<div id="upload2ndFileDiv">
				<?php
					echo form_input($browseId1stInput);
					echo form_input($browseId2ndInput);
				?>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('language');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							echo form_dropdown('languageId', $languageList, $competitionData->languageId,'id="languageId" class="required" title="'.$this->lang->line('thisFieldIsReq').'"');
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
			
				/*$data=array('name'=>'description','id'=>'description','value'=>$competitionData->description, 'required'=>'required', 'labelText'=>'description');
				$this->load->view("common/description",$data);*/
			?>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('submissionDate');?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<div class="cell">
					<?php echo $this->lang->line('submissionstart'); ?>&nbsp;&nbsp;
					&nbsp;&nbsp;<?php echo form_input($submissionStartDateInput); ?></div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#submissionStartDate").focus();' /> </div>
					<div class="cell pl20">
					&nbsp;&nbsp;<?php echo $this->lang->line('submissionend'); ?>&nbsp;&nbsp;
					&nbsp;&nbsp;<?php echo form_input($submissionEndDateInput); ?></div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#submissionEndDate").focus();' /> </div>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('votingDate');?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<div class="cell">
					<?php echo $this->lang->line('submissionstarts'); ?>&nbsp;&nbsp;	
					<?php echo form_input($votingStartDateInput); ?></div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#votingStartDate").focus();' /> </div>
					<div class="cell pl20">
					&nbsp;&nbsp;<?php echo $this->lang->line('submissionends'); ?>&nbsp;&nbsp;	
					<?php echo form_input($votingEndDateInput); ?></div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#votingEndDate").focus();' /> </div>
				</div>
			</div>
			<div class="seprator_25 clear row"></div>
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('competitionNumberofRound');?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
						<?php
							$roundType = array(''=>'Select number of rounds','1'=>'1','2'=>'2');
							
							echo form_dropdown('competitionRoundType', $roundType, $competitionData->competitionRoundType,'id="competitionRoundType" class="competitionRound" style="width:254px;" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			
			</div>
				
			
			
			<?php 
			$getClassName = ($competitionData->competitionRoundType==2)?'':'dn';
			?>
			<div id="showRound2Div" class="<?php echo $getClassName; ?>">
				<div class="row">
					<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('submissionDateRound2');?></label></div>
					<!-- Day -->
					<div class="cell frm_element_wrapper">
						<div class="cell">
						<?php echo $this->lang->line('submissionstart'); ?>&nbsp;&nbsp;
						&nbsp;&nbsp;<?php echo form_input($submissionStartDateRound2Input); ?></div>
						<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#submissionStartDateRound2").focus();' /> </div>
						<div class="cell pl20">
						&nbsp;&nbsp;<?php echo $this->lang->line('submissionend'); ?>&nbsp;&nbsp;
						&nbsp;&nbsp;<?php echo form_input($submissionEndDateRound2Input); ?></div>
						<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#submissionEndDateRound2").focus();' /> </div>
					</div>
				</div>
				
				<div class="row">
					<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('votingDateRound2');?></label></div>
					<!-- Day -->
					<div class="cell frm_element_wrapper">
						<div class="cell">
						<?php echo $this->lang->line('submissionstarts'); ?>&nbsp;&nbsp;	
						<?php echo form_input($votingStartDateRound2Input); ?></div>
						<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#votingStartDateRound2").focus();' /> </div>
						<div class="cell pl20">
						&nbsp;&nbsp;<?php echo $this->lang->line('submissionends'); ?>&nbsp;&nbsp;	
						<?php echo form_input($votingEndDateRound2Input); ?></div>
						<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#votingEndDateRound2").focus();' /> </div>
					</div>
				</div>
				<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('MaxEntriesofRound2');?></label></div>
				<div class="cell frm_element_wrapper">
					<div class="cell"> <?php echo form_input($Round2MaxEntriesInput); ?>
					</div>
					<div class="cell pl10 pt5">
					<?php echo $this->lang->line('MaxEntriesNotes');?>
					</div>
					
				</div>
				
				</div>
			</div>
			<div class="seprator_25 clear row"></div>
			<?php
				if($competitionId > 0){
					$required='';
				}else{
					$required='required';
				}
				$competitonImage=$competitionData->coverImage;
				$defaultcompetitonImage=$this->config->item('defaultcompetitonImage');
				$competitonThumbImage = addThumbFolder($competitonImage,'_s');	
				$imgsrc = getImage($competitonThumbImage,$defaultcompetitonImage);
				
				$data=array('typeOfFile'=>1, 'imgSrc'=>$imgsrc,'mediaFileTypes'=>$this->config->item('imageType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$dirUpload,'embedCode'=>'', 'required'=>$required, 'label'=>$this->lang->line('coverImage'),'editFlag'=>0,'fileTypeFlag'=>0,'flag'=>1,'browseId'=>$browseId1,'imgload'=>1,'norefresh'=>0);
				$this->load->view("upload_form",$data);
			 ?>

			<div class="row" id="indusrtyIdDiv">
				 <div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('industry');?></label></div>
				 <div class="cell frm_element_wrapper">
						<div class="fl" id="indusrtyIdList">
							<?php 
								$industryList = getIndustryList();
								echo form_dropdown('industryId', $industryList, $competitionData->industryId,'id="industryId" class="required" ');
							?>
						</div>
				</div>
			</div>
			
			<div class="row">
				<div class="label_wrapper cell"><div class="lable_heading"><h1 class="orange_color"><?php echo $this->lang->line('showCriteria'); ?></h1></div></div><!--label_wrapper-->
				<div class=" cell frm_element_wrapper"></div>
			</div>
		
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
							  <input type="radio" <?php if($competitionData->votesCountries=='') echo 'checked';?> value="0"  name="voteTeritoryType" onclick="$('#voteCountryDiv').hide();" />
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('global');?></label>
							</div>
							
							<div class="cell defaultP">
							  <input type="radio" value="1" <?php if($competitionData->votesCountries!='') echo 'checked';?> name="voteTeritoryType" onclick="$('#voteCountryDiv').show();" />
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('selectVotesCountries');?></label>
							</div>
					</div>
				</div>
			</div>
			
			<?php if($competitionData->votesCountries!=''){$dn='';} else{$dn='dn';} ?>
			<div class="row <?php echo $dn;?>" id="voteCountryDiv">
				<div class="cell label_wrapper bg-non"></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<?php $this->load->view('votesCountryForm');?>
				</div>
			</div>
			
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('language_first');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							echo form_dropdown('criteriaLang1Id', $languageList, $competitionData->criteriaLang1Id,'id="criteriaLang1Id" class="" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label><?php echo $this->lang->line('language_second');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							echo form_dropdown('criteriaLang2Id', $languageList2, $competitionData->criteriaLang2Id,'id="criteriaLang2Id"  title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				<div id="same_lang_validate"  class="error dn"><?php echo $this->lang->line('same_lang_not_allow'); ?></div>		
				</div>
			</div>
			
			
			<div class="seprator_25 clear row"></div>
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('ageRequires');?></label></div>
				<div class="cell frm_element_wrapper">
					<div class="cell">
					<?php echo $this->lang->line('From'); ?>&nbsp;&nbsp;
					&nbsp;&nbsp;<?php echo form_input($ageRequiresFromInput); ?></div>
					<div class="cell">
					&nbsp;&nbsp;<?php echo $this->lang->line('To'); ?>&nbsp;&nbsp;
					&nbsp;&nbsp;<?php echo form_input($ageRequiresToInput); ?></div>
					<div id="age_criteria_check"  class="error dn"><?php echo $this->lang->line('this_is_required_field'); ?></div>		
				</div>
				
			 </div>
			<?php 
				//echo '<div class="seprator_25 clear row"></div>';
				if($competitionId > 0){
					$required='';
				}else{
					$required='required';
				}
				
				if($competitionData->isExternal == 't'){
					$embedCode=$competitionData->filePath;
				}else{
					$competitionData->isExternal = 'f';
					$embedCode='';
				}
				$data=array('typeOfFile'=>2, 'mediaFileTypes'=>$this->config->item('sampleAccept'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>$competitionData->isExternal,'fileName'=>'','fileSize'=>0,'filePath'=>$dirUpload,'embedCode'=>$embedCode, 'required'=>$required, 'label'=>$this->lang->line('sampleMaterial'),'editFlag'=>0,'fileTypeFlag'=>0,'flag'=>0,'browseId'=>$browseId2,'imgload'=>0,'norefresh'=>0,'isUploadEmbedOption'=>true);
				$this->load->view("upload_form",$data);
			?>
			<div class="seprator_25 clear row"></div>
			
			<div class="row">
				<div class="cell label_wrapper"><label><?php echo $this->lang->line('competitionGroup');?></label></div>
				<div class="cell frm_element_wrapper" id="competitionGroupDiv">
					<div class="row">
						<div class="cell">
							<?php
								$groups =array();
								$groups[0] = $this->lang->line('selectCompetitionGroup');
								$countGroup=count($competitionGroup);
								if(isset($competitionGroup) && is_array($competitionGroup) && $countGroup > 0){
									foreach ($competitionGroup as $group) {
											$groups[$group->competitionGroupId] = $group->title;
									}
								}
								echo form_dropdown('competitionGroupId', $groups, $competitionData->competitionGroupId,'id="competitionGroupIdSeleect" ');
							?>
						</div>
						<?php
						$competitionGroupLimit=$this->config->item('competitionGroupLimit');
						if($competitionGroupLimit > $countGroup){
							?>
							<div class="cell" id="competitionGroupAddButton">
								<div class="tds-button-top mr10 mt3">
									<a class="formTip" href="javascript:void(0);" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/competition/competitionGroupForm','','');" title="<?php echo $this->lang->line('addCompetitionsGroup');?>">
										<span><div class="projectAddIcon"></div></span>
								   </a>
								</div>
							</div>
							<?php
						}?>
					</div>	
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
						if(isset($competitionId) && !empty($competitionId)){
							$button=array('save');
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

<input type="hidden" name="totalFileToupload" id="totalFileToupload" value="0" />

<div id="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="0" /></div>
<input type="hidden" name="relocateId" id="relocateId" value="<?php echo base_url(lang().'/competition/description/language1/'.$competitionId);?>" />

<script>
	
	bkLib.onDomLoaded(function() {
		var myNicEditor = new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','hr','subscript','superscript','link','unlink']});
		myNicEditor.panelInstance('rules');
	});
	
	$(document).ready(function(){
		
		$("#competitionForm").validate({
			submitHandler: function() {
				var rules=$('.nicEdit-main').html().replace(/^\s+|\s+$/g,"");
				//----------validate Competition Criteria field code-------//	
				var checkBlank = rules.replace(/^\&nbsp\;|<br?\>*/gi, "").replace(/\&nbsp\;|<br?\>$/gi, "").trim();;
				var regex = /(<([^>]+)>)/ig;
				checkBlank = checkBlank.replace(regex, "");
				if(!checkBlank.length > 0) {
					$("#criteria_validate").show();
					return false;
				}else{
					$("#criteria_validate").hide();
				}
				
				//-----------check language selection----------//
				if($("#criteriaLang1Id").val()==$("#criteriaLang2Id").val()) {
					$("#same_lang_validate").show();
					return false;
				}else
				{
					$("#same_lang_validate").hide();
				}
				
				//----------age criteria check------//
				//
				if(($("#ageRequiresFrom").val()!='' && $("#ageRequiresTo").val()=='') || ($("#ageRequiresFrom").val()=='' && $("#ageRequiresTo").val()!='')) {
					$("#age_criteria_check").show();
					return false;
				}else
				{
					$("#age_criteria_check").hide();
				}
				
				
				$("#rules").val(rules);
				var fromData=$("#competitionForm").serialize();
				var url = baseUrl+language+'/competition/saveDescription';
				$.post(url,fromData, function(data) {
				  if(data){
					if(data.fileId){
					  $("#MediaFileId").val(data.fileId);
					}
					if(data.uploadedFile && data.uploadedFile > 0){
					  $("#totalFileToupload").val(data.uploadedFile);
					}
					var competitionId =  $("#competitionId").val();
					competitionId = parseInt(competitionId);
					if(data.competitionId && competitionId == 0){
						$("#relocateId").val(baseUrl+language+'/competition/prizes/'+data.competitionId);
						$("#fileUploadPath<?php echo $browseId1?>").val('<?php echo $dirMedia?>'+data.competitionId);
						$("#fileUploadPath<?php echo $browseId2?>").val('<?php echo $dirMedia?>'+data.competitionId);
					}
					var redirectUrl=$("#relocateId").val();
					$("#uploadFileByJquery<?php echo $browseId1?>").click();
					$("#uploadFileByJquery<?php echo $browseId2?>").click();
					
					var fileName1 =  $("#fileName<?php echo $browseId1?>").val();
					if(fileName1 == undefined){
						fileName1 = '';
					}
					var fileName2 =  $("#fileName<?php echo $browseId2?>").val();
					if(fileName2 == undefined){
						fileName2 = '';
					}
					
					if(fileName1.length < 4 && fileName2.length < 4){
						goTolink('',redirectUrl);
					}
				  }
				},"json");
			}
		});
		
		//---------this event for hide and show round 2 div--------//
		$(".competitionRound").change(function(){
			
			if($(this).val()==2)
			{
				$('#showRound2Div').show();
			}else
			{
				$('#showRound2Div').hide();
			}
			
		});
		
	});
</script>
