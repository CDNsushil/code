<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


	// prepare user profile image
	$creative=$showcaseEntries->creative;
	$associatedProfessional=$showcaseEntries->associatedProfessional;
	$enterprise=$showcaseEntries->enterprise;
	$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg_xxs'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg_xxs'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):''));						
	$userImage="media/".$showcaseEntries->username."/profile_image/".$showcaseEntries->image;
	$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
	$userImage=getImage($userImage,$userDefaultImage);

	//competition entries cover image
	$userCoverImage='';
	$userdefCoverImage=$this->config->item('defaultcompetitonEntryImg180X210'); 
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
	$border6pxClass = $industryArray['6pxborderClass'];
	$sortButton = $industryArray['sortButton'];

?>
	<div  class="fl <?php echo $border6pxClass; ?> bg_white pl8 pr8 pt8 width_333 mr0 mt15 mb2 position_relative global_shadow pb2 ">
		<div onClick="window.open('<?php echo base_url('competition/entriesmedia/'.$userId.'/'.$showcaseEntries->competitionEntryId); ?>', '_self');" class="ptr">
		<div class="row">
			<div class="comp_bordergradient">
				<div class="row comt_topcontainer">
					<div class="cell comp_thumb_effct">
						<img src="<?php echo $userImage; ?>" alt="smallthumb" class="maxh54_maxw54">
					</div>
					<div class="fl width_250 mt5 ml12">
						<div class="font_opensansSBold font_size14 clr_444 lineH20 bdr_Bgray">
							<?php
								$showName = $showcaseEntries->firstName.' '.$showcaseEntries->lastName;
								echo getSubString($showName,25); 
							?>
						</div>
						<div class="clear"></div>
						<div class="seprator_8"></div>
						 <div class="icon_no_crave4_blog_no_padding <?php echo ($competitionDetail->craveId > 0)?'craveAll_no_padding':''; ?>  cell pl28"><?php echo $craveCount?></div>
                         <div class="icon_view_competition cell pl28 ml15"><?php echo $viewCount?></div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="seprator_16">
			</div>
			<div class="scentry_imgcont">
				<div class="AI_table">
					<div class="AI_cell">
						<img alt="img" src="<?php echo $imgSrc; ?>">
					</div>
				</div>
			</div>
			<div class="seprator_18">
			</div>
		</div>
		<div class="row font_museoSlab font_size20 clr_bc231b lineH26 ml8">
			<?php
				echo getSubString($showcaseEntries->title,25); 
			?>
		</div>
		<div class="seprator_3">
		</div>
		
		<?php if(!empty($showcaseEntries->competitionEntryLangId)){ ?>
		
			<div class="row font_size13 height_30 overflow_h ml8">
				<?php
					echo getSubString($showcaseEntries->onelineDescription,25); 
				?>
			</div>
			
			<div class="row font_museoSlab font_size20 clr_bc231b lineH26 ml8">
				<?php
					echo getSubString($showcaseEntries->titlelang2,25); 
				?>
			</div>
			<div class="seprator_3"></div>
			<div class="row font_size13 height_30 overflow_h ml8">
				<?php
					echo getSubString($showcaseEntries->onelinedescriptionlang2,25); 
				?>
			</div>
		
		<?php  }else { ?>
			<div class="row font_size13 height80 overflow_h ml8">
				<?php
					echo $showcaseEntries->onelineDescription; 
				?>
			</div>
		<?php } ?>
		
		</div>
		
		<div class="row">
 
		<!---------sortlig and vote section-------->
			<?php if($votingStartDate <= $currentDate &&  $votingEndDate >= $currentDate ) { ?>	
				<ul class="comp_entrylist bg_6c6c6c height48 width_345 ml-6">
					<?php 
						$buttonArray['buttonType']='shortlist';
						$buttonArray['buttonSection']='entriesFullView';
						$buttonArray['buttonDivClass']=$sortButton;
						$buttonArray['competitionId']=$showcaseEntries->competitionId;
						$buttonArray['competitionEntryId']=$showcaseEntries->competitionEntryId;
						echo $this->load->view('competitionButton',$buttonArray);
					?>
					<div id="sortlist<?php echo $showcaseEntries->competitionEntryId; ?>" class="font_opensans font_size14 clr_white width_40 bdr_8e8e8e text_alignR fl pr8 ml-18 lineH24 mt14 bg_333333">
						<?php echo $shortlistCount; ?>
					</div>
					<?php 
						$buttonArray['buttonType']='vote'; // set for vote button
						echo $this->load->view('competitionButton',$buttonArray); ?>
					<div  id="vote<?php echo $showcaseEntries->competitionEntryId; ?>" class="font_opensans font_size14 clr_white width_40 bdr_8e8e8e text_alignR fl pr8 ml-18 lineH24 mt14 bg_333333">
						<?php echo $voteCount; ?>
					</div>
				</ul>
			<?php } ?>	
				
		<!---------winnings result postition section-------->
			<?php if($votingEndDate < $currentDate ) { ?>	
			
				<ul class="comp_entrylist bg_6c6c6c height48 width_345 ml-6">
									   
				   <div class="font_opensans font_size14 clr_white width_116 bdr_8e8e8e text_alignR fl pr8 ml18 lineH24 mt14 bg_333333"><?php echo $this->lang->line('compeEntriesShortListed'); ?> <?php echo $shortlistCount; ?>
					</div>
					
					<div class="font_opensans font_size16 clr_white width_90 bdr_8e8e8e text_alignR fl pr8 ml28 lineH24 mt14 bg_333333"><?php echo $this->lang->line('userCompetitionVotes'); ?> <?php echo $voteCount; ?>
					</div>

					<div class="fr font_size30 clr_white font_helvetica_L font_weight text_shedow mt16 mr20"><?php echo $position; ?><span class="display_inline font_size19">st</span></div>
				</ul>
			
			<?php } ?>	
			
		</div>
	</div>


