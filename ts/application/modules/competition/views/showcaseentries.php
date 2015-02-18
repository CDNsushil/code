<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


	
	$industryArray = getIndustryClass($competitionDetail->industryId);
	$border10pxClass = $industryArray['10pxborderClass'];

	$currentDate = strtotime(date("Y-m-d"));
	$createdDate = strtotime($competitionDetail->createdDate);
	$submissionStartDate = strtotime($competitionDetail->submissionStartDate);
	$submissionEndDate = strtotime($competitionDetail->submissionEndDate);
	$votingStartDate = strtotime($competitionDetail->votingStartDate);
	$votingEndDate = strtotime($competitionDetail->votingEndDate);
	$roundTypeLable = $this->lang->line('userCompetitionRound1');// set current round type
	$onGoingRound='1';// set current going round
	if($roundType==2){
		
		if($votingEndDate <= $currentDate){
			$submissionStartDate = strtotime($competitionDetail->submissionStartDateRound2);
			$submissionEndDate = strtotime($competitionDetail->submissionEndDateRound2);
			$votingStartDate = strtotime($competitionDetail->votingStartDateRound2);
			$votingEndDate = strtotime($competitionDetail->votingEndDateRound2);
			$roundTypeLable = $this->lang->line('userCompetitionRound2');// set current round type
			$onGoingRound='2';// set current going round
		}
	}
	
	// current round type
	if($competitionDetail->competitionRoundType==2){
		if($votingEndDate <= $currentDate){
			$onGoingRound='2';// set current going round
		}
	}	
?>

<td valign="top">
	<div class="cell right_coloumn bg_2c2c2c bg-non margin_0 <?php echo $border10pxClass; ?> width778 pb10">
		<div class="row font_helvetica_L ml18 pt24 pr10">
			<div class="bdrb_a9a9a9 fl height_36">
				<span class="fl clr_white font_size30 text_alignC font_HelReg"> <?php  echo $this->lang->line('userCompetitionEntries'); ?> </span>
				<?php if($onGoingRound==2) { ?>
				<div class="fl ml68 font_size24">
					<ul class="entrytab clr_white">
						<li><a class="<?php echo ($roundType=='1')?'active':''; ?>" href="<?php echo base_url('competition/showcaseentries/'.$userId.'/'.$competitionId.'/1'); ?>" ><?php  echo $this->lang->line('userCompetitionRound1'); ?></a></li>
						 |
						<li><a class="<?php echo ($roundType=='2')?'active':''; ?>" href="<?php echo base_url('competition/showcaseentries/'.$userId.'/'.$competitionId.'/2'); ?>"><?php  echo $this->lang->line('userCompetitionRound2'); ?></a></li>
					</ul>
				</div>
				<?php } ?>	
			</div>
			<div class="fr bg_2c2c2c font_size17 font_helveticaLight text_alignR height_23 mr1 bdr_4c4c4c pl10 mt-4 pr10 backtocomp_shedow">
				<a class="clr_white lineH22" href="<?php echo base_url('competition/showcaseprizes/'.$userId.'/'.$competitionId); ?>"><?php  echo $this->lang->line('CompBacktoCompetition'); ?></a>
			</div>
			<div class="clear">
			</div>
		</div>
		<div class=" seprator_13">
		</div>
		<div class="row font_museoSlab font_size26 clr_f1592a ml18 pr10 lineH_32 text_shadow letter_spP6 height64">
			<?php echo $competitionDetail->title; ?>
		</div>
		<div class="seprator_18">
		</div>
		<div class="row">
			
			<div class="fr bg_2c2c2c height40 mr18 bdr_4c4c4c pl8 pr10 backtocomp_shedow width592">
				<div class="fl width455 height37 pt4">
					<div class="row font_opensans font_size18 clr_white">
						<div class="fl width_220">
							
							<?php echo $this->lang->line('userCompetitionEnter'); ?> <span class="clr_f1592a display_inline"><?php echo date("d/m/y",$submissionStartDate); ?> - <?php echo date("d/m/y",$submissionEndDate); ?> </span>
						</div>
						<div class="fl width_220 ml15">
							<?php echo $this->lang->line('userCompetitionVote'); ?> <span class="clr_f1592a display_inline ml7"><?php echo date("d/m/y",$votingStartDate); ?> - <?php echo date("d/m/y",$votingEndDate); ?></span>
						</div>
					</div>
					<div class="row font_opensansSBold font_size13 clr_c9c9c9 ml96 mt-4 letter_Spoint2 text_alignR pr5">
						 <?php echo $this->lang->line('headingUserCompetitionMsg'); ?>
					</div>
				</div>
				<div class="fr position_relative width_135 mt-2 comp_drop">
					<div class="cell comp_select_1">
						<?php
						$formAttributes = array(
							'name'=>'SortByForm',
							'id'=>'SortByForm',
						);
						
						echo form_open(base_url(lang().'/competition/showcaseentries/'.$userId.'/'.$competitionId.'/'.$roundType),$formAttributes);
						$sortByValue = ($this->input->post('sortBy'))?$this->input->post('sortBy'):'';
						$sortBy = array(
							'' => 'Sort By',
							'fullView'  => 'Full View',
							'sortView'  => 'Sort View',
							);
							$js= 'class="width70px" id="sortBy" onchange="this.form.submit()"';
							echo form_dropdown('sortBy', $sortBy, $sortByValue,$js);
						echo form_close(); ?>	
					</div>
				</div>
			</div>
			<div class="clear">
			</div>
			<div class="seprator_5">
			</div>
		</div>
		
		<?php 
		if(!empty($showcaseEntriesData)) {
		
			
			
			$entriesData['competitionDetail'] = $competitionDetail;
			$entriesData['industryArray'] = $industryArray;
			// load full view
			if($sortByValue=="" || $sortByValue=="fullView") {
				$entriesData['showcaseEntriesData'] = $showcaseEntriesData;
				echo $this->load->view('showcaseentrieslistfull',$entriesData);
			}
			// load sort view
			if($sortByValue=="sortView") {
				foreach($showcaseEntriesData as $showcaseEntries) { 
					$entriesData['showcaseEntries'] = $showcaseEntries;
					echo $this->load->view('showcaseentrieslistshort',$entriesData);
				}
			}
		} ?>
		<div class="clear">
		</div>
		<div class="seprator_8">
		</div>
	</div>
</td>


<script type="text/javascript">
	
	function mousedown_tds_button_jludark(obj){
	obj.style.backgroundPosition ='0px -43px';
	obj.firstChild.style.backgroundPosition ='right -43px';
	}
	function mouseup_tds_button_jludark(obj){
		obj.style.backgroundPosition ='0px 0px';
		obj.firstChild.style.backgroundPosition ='right 0px';
	}


	// competition vote insert
	function voteInsert(val1,val2,val3) {
	
		fromData = {
					userId:val1,
					competitionId:val2,
					competitionEntryId:val3
				}
				$.post(baseUrl+language+'/competition/competitionvoteinsert',fromData, function(data) {
					if(data){
						customAlert(data.msg);
						if(data.countShow==1){
							$('#vote'+val3).html(data.voteCount);
						}
					} 	
				},"json");
	}
	
	
	// comeptition sort list
	function sorlistNunshortlist(val1,val2,val3) {
	
				fromData = {
					userId:val1,
					competitionId:val2,
					competitionEntryId:val3
				}
				$.post(baseUrl+language+'/competition/shorlistNunshortlistInsert',fromData, function(data) {
					if(data){
						customAlert(data.msg);
						if(data.countShow==1){
							$('#sortlist'+val3).html(data.shortlistCount);
						}
					} 	
				},"json");
	}
</script>
