<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<td valign="top">
           <div class="cell right_coloumn bg_black margin_0 bdr10_3b3b3b width778 height1568px">
              <div class="row pl15 pr10 pt7 font_helvetica_L">
              <div class="fl font_size28 clr_white width_420"><?php echo $this->lang->line('CompEntries'); ?></div>
              <div class="fr width_304 bg_303030 font_size22 text_alignR pr12 height_25"><a href="<?php echo base_url('competition/showcase/'.$userId.'/'.$competitionId); ?>" class="clr_white lineH22"><?php echo $this->lang->line('CompBacktoCompetition'); ?></a> </div>
              <div class="clear"></div>
              <div class="seprator_5"></div>
              <div class="font_size30 clr_white lineH35"><?php echo $competitionData[0]->title; ?></div>
              <div class="clear"></div>
              </div>
              
              <div class="seprator_5"></div>
			
			<?php 
				$numCount=1;
				if($competitionEntries) {
				foreach($competitionEntries as $competitionEntriesList){
					
					/*echo "<pre>";
					print_r($competitionEntriesList);*/
				
				
					$competitionId = $competitionEntriesList->competitionId;
					$competitionEntryId = $competitionEntriesList->competitionEntryId;
				
					/**********get user image************/		
					$creative=$competitionEntriesList->creative;
					$associatedProfessional=$competitionEntriesList->associatedProfessional;
					$enterprise=$competitionEntriesList->enterprise;
						
					$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg_xxs'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg_xxs'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):''));						
					$userImage="media/".$competitionEntriesList->username."/profile_image/".$competitionEntriesList->image;
					$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
					$userImage=getImage($userImage,$userDefaultImage);
					
					if(!empty($competitionEntriesList->coverImage) && isset($competitionEntriesList->coverImage))
							$mainCoverImage = $competitionEntriesList->coverImage;
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
				
              <div class="fl bdr6_676767 bg_white pall8 width_333 ml15 mr11 mt15 position_relative">
              
              <a href="javascript:openLightBox('popupBoxWp','popup_box','/competition/entriespopup','<?php echo $competitionId; ?>','<?php echo $competitionEntryId; ?>');">
              	<div class="position_absolute top8 right8"><img src="<?php echo base_url('templates/frontend/images/comp_addationbtn.png');?>" /></div>
				
				<div class="row">
                          	<div class="cell comp_thumb_effct">
                            	<img class="maxh54_maxw54" alt="smallthumb" src="<?php echo $userImage ?>">
                            </div>
                            
                            <div class="fl width_196 mt7 ml34">
								<div class="font_opensansSBold font_size14 clr_888 lineH14"><?php echo $competitionEntriesList->enterpriseName; ?></div>
								<div class="clear"></div>
								<div class="seprator_13"></div>
								<div>
								<div class="icon_crave5_blog cell pl28"> <?php echo $voteCount; ?></div>
								<div class="icon_view5_blog cell pl28 ml15"><?php echo $viewCount; ?></div>
								</div>
								</div>
								<div class="clear"></div>
                            </div>
                          
				<div class="row">
					<div class="seprator_16"></div>
					<div class="scentry_imgcont">
						<div class="AI_table">
						<div class="AI_cell">
						<img src="<?php echo $entryCoverImage; ?>" alt="img"/>
						</div>
						</div>
					</div>
					
					<div class="font_size10 text_alignR height_18"><?php echo date('d F Y'); ?> </div> 
				</div>
			 
            	<div class="row font_museoSlab font_size20 clr_bc231b lineH26"><?php echo $competitionEntriesList->title; ?></div> 
				<div class="seprator_8"></div>
				<div class="row font_size13"><?php echo $competitionEntriesList->description; ?>....</div>
				
				</a>
				 
				<div class="row">
                <div class="seprator_20"></div>
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
					
					<div class="votescrolldivbg1 showMainDiv<?php echo $numCount; ?>">
					  <div class="font_helvetica_L votescrolldiv showDiv<?php echo $numCount; ?>"><?php echo $this->lang->line('compti_vote_msg'); ?></div>
					</div>
					</li>
					<li> <a href="javascript:openLightBox('popupBoxWp','popup_box','/competition/shortlistNunshorlist','<?php echo $competitionId; ?>','<?php echo $competitionEntryId; ?>');" ><?php echo $this->lang->line('compti_showcase_shortlist'); ?></a> </li>
				</ul>
                </div>                   
              
             
              
              </div>
              
			<?php $numCount++; }  } ?> 	
              <div class="clear"></div>
              <div class="seprator_15"></div>
        </div>

</td>

<script> 
$(document).ready(function(){
  $(".vote").mouseover(function(){
	var divId = $(this).attr('showDivId');
    $(".showMainDiv"+divId).css('z-index','9999');
    $(".showDiv"+divId).animate({top:'-147px'});
	});
  
    $(".vote").mouseout(function(){
	var divId = $(this).attr('showDivId');
	$(".showDiv"+divId).animate({top:'0'});
	setTimeout(function(){
		$(".showMainDiv"+divId).css('z-index','-1');
		},600)
	
  });
});
</script>
