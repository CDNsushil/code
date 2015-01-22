<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$lang=lang();
$browseId1='_image';

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
	'title'       => 'End date must be after the start date.',
	'dategreaterthan'       => '#submissionStartDate',
	'value'	=> !empty($competitionData->submissionStartDate) ? dateFormatView($competitionData->submissionEndDate,'d M Y') : '',
	'readonly' =>true
);

$votingStartDateInput = array(
	'name'	=> 'votingStartDate',
	'id'	=> 'votingStartDate',
	'class'       => 'date-input required width_196',
	'title'       => 'This date must be after the Submissions end.',
	'dategreaterthan'       => '#submissionEndDate',
	'value'	=> !empty($competitionData->submissionStartDate) ? dateFormatView($competitionData->votingStartDate,'d M Y') : '',
	'readonly' =>true
);

$votingEndDateInput = array(
	'name'	=> 'votingEndDate',
	'id'	=> 'votingEndDate',
	'class'       => 'date-input required width_196',
	'title'       => 'End date must be after the start date.',
	'dategreaterthan'       => '#votingStartDate',
	'value'	=> !empty($competitionData->submissionStartDate) ? dateFormatView($competitionData->votingEndDate,'d M Y') : '',
	'readonly' =>true
);

//-------round 2 submittion and voting section show-------//

$submissionStartDateRound2Input = array(
	'name'	=> 'submissionStartDateRound2',
	'id'	=> 'submissionStartDateRound2',
	'class'       => 'date-input required width_196',
	'title'       =>'This date must be after the 1st round ends.',
	'dategreaterthan'       => '#votingEndDate',
	'value'	=> !empty($competitionData->submissionStartDateRound2) ? dateFormatView($competitionData->submissionStartDateRound2,'d M Y') : '',
	'readonly' =>true
);

$submissionEndDateRound2Input = array(
	'name'	=> 'submissionEndDateRound2',
	'id'	=> 'submissionEndDateRound2',
	'class'       => 'date-input required width_196',
	'title'       => 'End date must be after the start date.',
	'dategreaterthan'       => '#submissionStartDateRound2',
	'value'	=> !empty($competitionData->submissionEndDateRound2) ? dateFormatView($competitionData->submissionEndDateRound2,'d M Y') : '',
	'readonly' =>true
);

$votingStartDateRound2Input = array(
	'name'	=> 'votingStartDateRound2',
	'id'	=> 'votingStartDateRound2',
	'class' => 'date-input required width_196',
	'title' => 'This date must be after the Submissions End.',
	'dategreaterthan' => '#submissionEndDateRound2',
	'value'	=> !empty($competitionData->votingStartDateRound2) ? dateFormatView($competitionData->votingStartDateRound2,'d M Y') : '',
	'readonly' =>true
);

$votingEndDateRound2Input = array(
	'name'	=> 'votingEndDateRound2',
	'id'	=> 'votingEndDateRound2',
	'class'       => 'date-input required width_196',
	'title' => 'End date must be after the start date.',
	'dategreaterthan' => '#votingStartDateRound2',
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

?>

<div class="row form_wrapper">
	
	<?php echo $header; ?>
	
	<div class="row position_relative">	
		<?php $this->load->view("common/strip");
		echo form_open($this->uri->uri_string(),$formAttributes);
		echo form_input($competitionIdInput);
		echo form_input($sectionIdInput);
		echo form_input($browseId1stInput);
		$languageList = getlanguageList();
		?>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('multilinguage');?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<div class="row pt5">
							
							<div class="cell defaultP">
							  <input type="radio" <?php if($competitionData->isMultilingual=='t') echo 'checked';?> value="t"  name="isMultilingual"  />
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('yes');?></label>
							</div>
							
							<div class="cell defaultP">
							  <input type="radio" value="1" <?php if($competitionData->isMultilingual!='t') echo 'checked';?> name="isMultilingual" />
							</div>
							
							<div class="cell mr20">
							  <label class="lH25"><?php echo $this->lang->line('no');?></label>
							</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('language');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							echo form_dropdown('languageId', $languageList, $competitionData->languageId,'id="languageId" class="width_254 required NumGrtrZero" title="'.$this->lang->line('thisFieldIsReq').'"');
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
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('submissions');?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<div class="cell pt5 width_40">
						<?php echo $this->lang->line('submissionstart'); ?>
						
					</div>
					<div class="cell">
						<?php echo form_input($submissionStartDateInput); ?>
					</div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#submissionStartDate").focus();' /> </div>
					<div class="cell pl25 pt5 width_40">
						<?php echo $this->lang->line('submissionend'); ?>
					</div>
					<div class="cell">
						<?php echo form_input($submissionEndDateInput); ?>
					</div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#submissionEndDate").focus();' /> </div>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('votingDate');?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<div class="cell ">
						<?php echo $this->lang->line('submissionstart'); ?>
						&nbsp;&nbsp;&nbsp;
						<?php echo form_input($votingStartDateInput); ?>
					</div>
					
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#votingStartDate").focus();' /> </div>
					<div class="cell pl25 pt5 width_40">
						<?php echo $this->lang->line('submissionends'); ?>
					</div>
					<div class="cell">
						<?php echo form_input($votingEndDateInput); ?>
					</div>
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
							
							echo form_dropdown('competitionRoundType', $roundType, $competitionData->competitionRoundType,'id="competitionRoundType" class="width_254 competitionRound" title="'.$this->lang->line('thisFieldIsReq').'"');
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
							<?php echo $this->lang->line('submissionstart'); ?>
							&nbsp;&nbsp;&nbsp;
							<?php echo form_input($submissionStartDateRound2Input); ?>
						</div>
						
						<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#submissionStartDateRound2").focus();' /> </div>
						<div class="cell pl25 pt5 width_40">
							<?php echo $this->lang->line('submissionend'); ?>
						</div>
						<div class="cell">
							<?php echo form_input($submissionEndDateRound2Input); ?>
						</div>
						<div class="cell pt5 pl5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#submissionEndDateRound2").focus();' /> </div>
					</div>
				</div>
				
				<div class="row">
					<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('votingDateRound2');?></label></div>
					<!-- Day -->
					<div class="cell frm_element_wrapper">
						<div class="cell ">
							<?php echo $this->lang->line('submissionstarts'); ?>
							&nbsp;							
							<?php echo form_input($votingStartDateRound2Input); ?>
						</div>
						
						<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#votingStartDateRound2").focus();' /> </div>
						<div class="cell pl25 pt5 width_40">
							<?php echo $this->lang->line('submissionends'); ?>
						</div>
						<div class="cell">
							<?php echo form_input($votingEndDateRound2Input); ?>
						</div>
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
			<div class="row" id="indusrtyIdDiv">
				 <div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('industry');?></label></div>
				 <div class="cell frm_element_wrapper">
						<div class="fl" id="indusrtyIdList">
							<?php 
								$industryList = getIndustryList();
								echo form_dropdown('industryId', $industryList, $competitionData->industryId,'id="industryId" class="width_254 required" ');
							?>
						</div>
				</div>
			</div>
			
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
								echo form_dropdown('competitionGroupId', $groups, $competitionData->competitionGroupId,'id="competitionGroupIdSeleect" class="width_254" ');
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


<input type="hidden" name="relocateId" id="relocateId" value="<?php echo base_url(lang().'/competition/description/language1/'.$competitionId);?>" />

<script>
	$(document).ready(function(){
	
		// when competition is published and it have one entry then can't be edit
		var isBlockEdit = '<?php echo ($isEditBlock)?"1":"0"; ?>';
		
		$("#competitionForm").validate({
			submitHandler: function() {
				var fromData=$("#competitionForm").serialize();
				var url = baseUrl+language+'/competition/saveDescription';
				if(isBlockEdit=='0'){
					$.post(url,fromData, function(data) {
					  if(data){
						
						var competitionId =  $("#competitionId").val();
						competitionId = parseInt(competitionId);
						if(data.competitionId && competitionId == 0){
							$("#relocateId").val(baseUrl+language+'/competition/description/language1/'+data.competitionId);
							$("#fileUploadPath<?php echo $browseId1?>").val('<?php echo $dirMedia?>'+data.competitionId);
						}
						var redirectUrl=$("#relocateId").val();
						$("#uploadFileByJquery<?php echo $browseId1?>").click();
						
						var fileName1 =  $("#fileName<?php echo $browseId1?>").val();
						if(fileName1 == undefined){
							fileName1 = '';
						}
						if(fileName1.length < 4 ){
							goTolink('',redirectUrl);
						}
					  }
					},"json");
				}else{
					customAlert('<?php echo $this->lang->line('cannotEditCompMsg'); ?>');
				}
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
