<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//competition entries cover image
$userCoverImage='';
$userdefCoverImage=$this->config->item('defaultcompetitonEntryImg_s'); 
$userCoverImage = addThumbFolder($showcaseEntries->coverImage, '_m');	
$imgSrc = getImage($userCoverImage,$userdefCoverImage);

// crave and view data
$craveCount = ($showcaseEntries->craveCount!='') ? $showcaseEntries->craveCount : 0;
$viewCount  = ($showcaseEntries->viewCount!='')  ? $showcaseEntries->viewCount  : 0;
$voteCount  = ($showcaseEntries->voteCount!='')  ? $showcaseEntries->voteCount  : 0;
$shortlistCount  = ($showcaseEntries->shortlistCount!='')  ? $showcaseEntries->shortlistCount  : 0;


// competition data 
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


// design class
$border4pxClass = $industryArray['4pxborderClass'];
$sortButton = $industryArray['sortButton'];


?>
<div class="<?php echo $border4pxClass; ?> bg_white ml15 mr15 mt10 position_relative global_shadow pall6">
	<div class="fl width295 pt2 ptr" onClick="window.open('<?php echo base_url('competition/entriesmedia/'.$userId.'/'.$showcaseEntries->competitionEntryId); ?>', '_self');">
		<div class="fl width_200 ml6">
			<div class="row font_museoSlab font_size14 clr_bb281c">
				<?php
					echo getSubString($showcaseEntries->title,20); 
				?>
			</div>
			<div class="row font_helveticaLight font_size13 clr_333 mt3 ml3 lineH16 height_36 overflow_h">
				<?php
					echo getSubString($showcaseEntries->onelineDescription,25); 
				?>
			</div>
		</div>
		<div class="sc_intryimg_cont">
			<div class="AI_table">
				<div class="AI_cell">
					<img src="<?php echo $imgSrc; ?>" alt="img">
				</div>
			</div>
			
		</div>
	</div>
	<div class="fr width_420 height59 bg_6c6c6c pr3 pt3">
		<div class="row font_opensans clr_white">
			<div class="fl font_size14 ml8">
				<?php
					$showName = $showcaseEntries->firstName.' '.$showcaseEntries->lastName;
					echo getSubString($showName,25); 
				?>
			</div>
			<div class="fr font_size10 mr3 mt2">
				<?php echo  date('d M Y',strtotime($showcaseEntries->createdDate)); ?>
			</div>
			<div class="fr lineH27 mr9 mt_minus_2 ">
				<div class="icon_view3_blog clr_white font_size14">
					<?php echo $viewCount; ?>
				</div>
			</div>
			<div class="clear">
			</div>
		</div>
		<div class="row">
			<?php if($votingStartDate <= $currentDate &&  $votingEndDate >= $currentDate) {  ?>
				<div class="font_opensans font_size14 clr_white width_114 bdr_8e8e8e text_alignR fl pr8 ml5 lineH24 bg_444 mt-2">
					 <?php echo $this->lang->line('compeEntriesShortListed'); ?> <span id="sortlist<?php echo $showcaseEntries->competitionEntryId; ?>" class="di"><?php echo $shortlistCount; ?></span>
				</div>
			<?php } ?>
			<?php 
			if($votingStartDate <= $currentDate &&  $votingEndDate >= $currentDate) {
				$buttonArray['buttonType']='shortlist';
				$buttonArray['buttonDivClass']=$sortButton;
				$buttonArray['buttonSection']='entriesSortView';
				$buttonArray['competitionEntryId']=$showcaseEntries->competitionId;
				$buttonArray['competitionEntryId']=$showcaseEntries->competitionEntryId;
				echo $this->load->view('competitionButton',$buttonArray);
			}	 
			?>
			<?php if($votingStartDate <= $currentDate &&  $votingEndDate >= $currentDate) {  ?>
				<div class="font_opensans font_size14 clr_white width_70 bdr_8e8e8e text_alignR fl pr8 ml15 lineH24 bg_444 mt-2">
					 <?php echo $this->lang->line('userCompetitionVotes'); ?>  <span id="vote<?php echo $showcaseEntries->competitionEntryId; ?>" class="di"><?php echo $voteCount; ?></span>
				</div>
			<?php } ?>
			<?php 
			if($votingStartDate <= $currentDate &&  $votingEndDate >= $currentDate) {
				$buttonArray['buttonType']='vote';
				echo $this->load->view('competitionButton',$buttonArray);
			}
			 ?>
			<div class="clear">
			</div>
		</div>
	</div>
	<div class="clear">
	</div>
</div>
