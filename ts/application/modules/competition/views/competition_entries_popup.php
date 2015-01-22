<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$competitionId = $competitionEntriesData->competitionId;
$competitionEntryId = $competitionEntriesData->competitionEntryId;

/**********get user image************/		
$creative=$competitionEntriesData->creative;
$associatedProfessional=$competitionEntriesData->associatedProfessional;
$enterprise=$competitionEntriesData->enterprise;
	
$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg_xxs'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg_xxs'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):''));						
$userImage="media/".$competitionEntriesData->username."/profile_image/".$competitionEntriesData->image;
$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
$userImage=getImage($userImage,$userDefaultImage);

if(!empty($competitionEntriesData->coverImage) && isset($competitionEntriesData->coverImage))
		$mainCoverImage = $competitionEntriesData->coverImage;
	else
		$mainCoverImage = '';
$coverImage='';
$defCoverImage=$this->config->item('defaultcompetitonEntryImg73X110');
$coverImage = addThumbFolder($mainCoverImage);	
$entryCoverImage = getImage($coverImage,$defCoverImage);

//---------get crave count----------//

$log_summary  = getDataFromTabel('LogSummary', $field='voteCount,viewCount,lastViewDate',  $whereField=array('entityId'=>$entityId,'elementId' => $competitionEntryId), '', '', 'ASC', $limit=1, $offset=0, $resultInArray=false);
	if($log_summary)
	{
		$voteCount = $log_summary[0]->voteCount;
		$viewCount  = $log_summary[0]->viewCount;
	}else
	{
		$voteCount = '0';
		$viewCount  = '0';
	}

?>	
	<div class="bdr6_676767 bg_white pl50 pt15 width684 pb50 position_relative">
		<div class="position_absolute top8 right8"><a href="javascript:void(0)" onclick="$(this).parent().trigger('close');"><img src="<?php echo base_url('templates/frontend/images/comp_close.png');?>"></a></div>
		  <div class="row bdr_Bgrey width640">
					<div class="cell comp_thumb_effct">
						<img src="<?php echo $userImage ?>" alt="smallthumb" class="maxh54_maxw54">
					</div>
						<div class="fl ml16 width_566 mt2">
						 <div class="font_opensansSBold font_size14 clr_666 lineH14"><?php echo $this->lang->line('compti_entries_entered_by'); ?></div>
						 <div class="clear"></div>
						 <div class="seprator_22"></div>
						  <div class="font_helvetica_L font_size18 clr_888 lineH14 fl"><?php echo $competitionEntriesData->enterpriseName; ?></div>
						 <div class="fr">
					  <div class="icon_crave5_blog cell pl28"> <?php echo $voteCount; ?></div>
					  <div class="icon_view5_blog cell pl28 ml15"><?php echo $viewCount; ?></div>
						 </div>
						</div>
					   
						<div class="clear"></div>
						 <div class="seprator_15"></div>
					    </div>
					  
					  <div class="seprator_14"></div>
					  <div class="row font_museoSlab font_size24 clr_bc231b lineH26 pr15"><?php echo $competitionEntriesData->title; ?></div>
					  
					  
					  <div class="row">
						<div class="seprator_26"></div>
						<div class="scentry_imgcontbig compvideobg fl">
							<div class="AI_table">
							<div class="AI_cell">
							<img alt="img" src="<?php echo $entryCoverImage; ?>">
							</div>
							</div>
						</div>
						
						<div class="font_size12 height_18 font_opensans fl ml28"><?php echo date("d F Y") ?> </div> 
						<div class="clear"></div>
					  </div>
						
						<div class="seprator_42"></div>
						
					 <div class="row font_helvetica_L font_size16 pr36 wordsp1 letterSp2"><?php echo $competitionEntriesData->tagwords; ?></div>

					<div class="seprator_24"></div>

					 <div class="row font_size14 font_helvetica_L pr36 wordsp1 letterSp2 clr_black"><?php echo $competitionEntriesData->description; ?></div>

			<div class="row">
			<div class=" seprator_74"></div>
			<ul class="comp_entrylist">
				<?php 
					$votingStart = strtotime($competitionData[0]->votingStartDate);
					$votingEnd = strtotime($competitionData[0]->votingEndDate);
					$currentTime = strtotime(date("Y-m-d"));
					if($votingStart >= $currentTime && $votingEnd <= $currentTime )
					{	
				?>
					<li class="w170"> <a class="mr8 position_relative vote" href="javascript:openLightBox('popupBoxWp','popup_box','/competition/competitionentryvote','<?php echo $competitionId; ?>','<?php echo $competitionEntryId; ?>');" onclick="return confirm('Are you sure vote for this entry?');"  id="vote" showDivId='<?php echo $numCount; ?>'><?php echo $this->lang->line('compti_showcase_vote'); ?></a> 
				<?php }else { ?>	
					<li class="w170"> <a class="mr8 position_relative vote" href="javascript:void(0)"  id="vote" showDivId='<?php echo $numCount; ?>'><?php echo $this->lang->line('compti_showcase_vote'); ?></a> 
				<?php } ?>	
			
				<div class="votescrolldivbg">
				  <div class="font_helvetica_L votescrolldiv"><?php echo $this->lang->line('compti_vote_msg'); ?></div>
				</div>
			 	</li>
				<li> <a href="javascript:openLightBox('popupBoxWp','popup_box','/competition/shortlistNunshorlist','<?php echo $competitionId; ?>','<?php echo $competitionEntryId; ?>');" ><?php echo $this->lang->line('compti_showcase_shortlist'); ?></a> </li>
			</ul>
			<a href="javascript:void(0)" class="fl ml115 mt7 font_size18 font_helvetica_L"><?php echo $this->lang->line('compti_showcase_view'); ?></a>
		</div>                   
	</div>
<script> 
$(document).ready(function(){
  $("#vote").mouseover(function(){
    $(".votescrolldiv").animate({top:'-147px'});
  });
  
   $("#vote").mouseout(function(){
    $(".votescrolldiv").animate({top:'0'});
  });
});
</script>
