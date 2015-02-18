<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

 if(!empty($competition_array) && is_array($competition_array)){ 
		foreach($competition_array as $competitionData)	{ 
			
		// This condition for set border class according to industry type	
		switch($competitionData->industryId){
			  
				case 1:
					$borderClass = 'border_FilmNVideo_Indus';//border class
							break;  
				case 2:
					$borderClass = 'border_musicNaudio_Indus';//border class
				break; 
				case 3:
					$borderClass = 'border_writtingNPubli_Indus';
				break;  
				case 4:
					$borderClass = 'border_photographynart_Indus';
				break; 
				case 5:
					$borderClass = '';
				break; 
				default:
					$borderClass = 'border_FilmNVideo_Indus';
				break; 
			}
		
		//  set submition and vote date according to round type
		
		$currentDate = strtotime(date("Y-m-d"));
		$createdDate = strtotime($competitionData->createdDate);
		$submissionStartDate = strtotime($competitionData->submissionStartDate);
		$submissionEndDate = strtotime($competitionData->submissionEndDate);
		$votingStartDate = strtotime($competitionData->votingStartDate);
		$votingEndDate = strtotime($competitionData->votingEndDate);
		$roundTypeLable = $this->lang->line('userCompetitionRound1');// set current round type
		$onGoingRound='1';// set current going round
		if($competitionData->competitionRoundType==2){
			
			if($votingEndDate <= $currentDate){
				$submissionStartDate = strtotime($competitionData->submissionStartDateRound2);
				$submissionEndDate = strtotime($competitionData->submissionEndDateRound2);
				$votingStartDate = strtotime($competitionData->votingStartDateRound2);
				$votingEndDate = strtotime($competitionData->votingEndDateRound2);
				$roundTypeLable = $this->lang->line('userCompetitionRound2');// set current round type
				$onGoingRound='2';// set current going round
			}
		}
			
		$sortButton = $industryArray['sortButton'];		
		?>
		<!----row start--->
		<a target="_blank" href="<?php echo base_url('competition/showcase/'.$competitionData->userId.'/'.$competitionData->competitionId); ?>">
			<div class="<?php echo $borderClass ?> bg_white ml15 mr12 mt10 position_relative pt10 pb10 pl8 pr8">
			<div class="width375 height280 fl">
				<div class="comp_bordergradient">
					<div class="row comt_topcontainer font_size19 clr_f1592a font_museoSlab pl15 pr15 pb5 lineH20 min_height_66">
						<div class="font_opensans font_size10 clr_444 text_alignR mb6">
						<?php echo date("d F Y",$createdDate); ?>	
						</div>
						 <?php echo getSubString($competitionData->title,50); ?>
						<div class="clear">
						</div>
					</div>
				</div>
				<div class="bg_white clr_333 font_helveticaLight font_size14 pt18 pb15 ml5 mr5 pl8 pr8 bdrB_d3d3d3 lineH17 min_height_66">
					 <?php echo getSubString($competitionData->onelineDescription,200); ?>
				</div>
				<div class="row bdrB_d3d3d3 font_museoSlab font_size18 ml5 mr5 clr_333 lineH30">
					<div class="fl width182">
						<?php echo $this->lang->line('userCompetitionEnter'); ?>
					</div>
					<div class="fl width182">
						<?php echo $this->lang->line('userCompetitionVote'); ?>
					</div>
					<div class="clear">
					</div>
				</div>
				<div class="row bdrB_d3d3d3 font_opensansSBold font_size14 ml5 mr5 clr_f1592a lineH30">
					<div class="fl width182">
						<?php echo date("d M Y",$submissionStartDate); ?> <span class="display_inline clr_333">-</span> <?php echo date("d M Y",$submissionEndDate); ?>
					</div>
					<div class="fl width182">
						<?php echo date("d M Y",$votingStartDate); ?> <span class="display_inline clr_333">-</span> <?php echo date("d M Y",$votingEndDate); ?>
					</div>
					<div class="clear">
					</div>
				</div>
				<div class="comp_bordergradient">
					<div class="row comt_topcontainer font_size19 clr_f1592a font_museoSlab pl15 pr15 pb5 height_36 mt1">
						<?php 
						// This div show only on that condition when round type is two 
						if($competitionData->competitionRoundType==2){ ?>
						<div class="font_size14 bdrb_f15921 font_arial fr lineH14 mt18 ml_25">
							<span class="clr_f1592a underline"> 
							<?php echo $roundTypeLable; ?></span>
						</div>
						<?php 	} ?>
						<div class="fr lineH27 pt11">
							<div class="icon_view3_blog clr_888 font_size14">
								<?php echo $competitionData->viewCount; ?>
							</div>
						</div>
						<div class="fr lineH27 pt11 mr24">
							<div class="icon_crave4_blog <?php echo ($competitionData->craveId > 0)?'cravedALL':''; ?>  clr_888 font_size14">
								<?php echo $competitionData->craveCount; ?>
							</div>
						</div>
						<div class="clear">
						</div>
					</div>
				</div>
			</div>
			<div class="width_330 height280 fr">
				<div class="row">
					<div class="bg_444 height220">
						<div class="AI_table">
							<div class="AI_cell">
							<?php 
								$userCoverImage='';
								$userdefCoverImage=$this->config->item('defaultcompetitonImageListing'); 
								$userCoverImage = addThumbFolder($competitionData->coverImage, '_m');	
								$imgSrc = getImage($userCoverImage,$userdefCoverImage);
							?>	
								<img class="maxh220" src="<?php echo $imgSrc; ?>" alt="img">
							</div>
						</div>
					</div>
				</div>
				<div class="seprator_8">
				</div>
				<div class="row">
					<div class="bg_6c6c6c height51">
						<div class="font_opensans font_size16 clr_white width_173 bdr_8e8e8e text_alignR fl pr8 ml10 lineH24 mt14">
						<?php echo $this->lang->line('userCompetitionEntries'); ?> 
						<?php 
							// show total entries count of each competition
							$whereCondition = array('competitionId'=>$competitionData->competitionId,'isPublished'=>'t','isBlocked'=>'f','isArchive'=>'f');
							$getEntriesCount = countResult('CompetitionEntry',$whereCondition);
							echo $getEntriesCount;
						?>		 
						</div>
						<div class="<?php echo  $sortButton; ?> fr mr18 mt12">
						<?php  
						
						
						// show crave button
						if($currentDate < $submissionStartDate){
							?>
							<a href="javascript:void(0)" onmouseup="mouseup_tds_button_jludark(this)" onmousedown="mousedown_tds_button_jludark(this)"><span class="font_size18 lineH26 width_65 clr_black"><?php echo $this->lang->line('userCompetitionVoteCrave'); ?></span></a>
						<?php
							}
						// show enter button
						if($submissionStartDate <= $currentDate && $submissionEndDate >= $currentDate )
							{ 
							$competitionId = $competitionData->competitionId;
							//*****condition for competition entry button****//
							$loggedUserId=isloginUser();
							if(is_numeric($loggedUserId) && ($loggedUserId > 0) && is_numeric($competitionId) && ($competitionId > 0)){
								if($userId==$loggedUserId){
									$cannotEnterComptition=$this->lang->line('cannotEnterComptition');
									$function="customAlert('".$cannotEnterComptition."')";
								}else{
									$sectionId=$this->config->item('competitionEntrySectionId');
									$function="javascript:getUserContainers('".$sectionId."','competition/competitionentry/".$competitionId."');";
								}
							}else{
								$beforeEnterComptition=$this->lang->line('beforeEnterComptition');
								$function="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeEnterComptition."')";
							}
						?>	
							<a href="javascript:void(0)"  onclick="<?php echo $function;?>" onmouseup="mouseup_tds_button_jludark(this)" onmousedown="mousedown_tds_button_jludark(this)"><span class="font_size18 lineH26 width_65 clr_black"><?php echo $this->lang->line('userCompetitionEnterButton'); ?></span></a>
						<?php
						// show vote button
							} 
						if($votingStartDate <= $currentDate && $votingEndDate >= $currentDate &&  $submissionStartDate <= $votingStartDate)
							{  ?>
							<a href="<?php echo base_url('competition/showcaseentries/'.$userId.'/'.$competitionData->competitionId.'/'.$onGoingRound);?>" onmouseup="mouseup_tds_button_jludark(this)" onmousedown="mousedown_tds_button_jludark(this)"><span class="font_size18 lineH26 width_65 clr_black"><?php echo $this->lang->line('userCompetitionVoteButton'); ?></span></a>
						<?php } 
						// show winner button
						if($votingEndDate < $currentDate){
						?>
							<a href="<?php echo base_url('competition/showcaseentries/'.$userId.'/'.$competitionData->competitionId.'/'.$onGoingRound);?>" onmouseup="mouseup_tds_button_jludark(this)" onmousedown="mousedown_tds_button_jludark(this)"><span class="font_size18 lineH26 width_65 clr_black"><?php echo $this->lang->line('userCompetitionVoteWinners'); ?></span></a>
						<?php }  ?>
						</div>
						
					</div>
				</div>
			</div>
			<div class="clear">
			</div>
		</div>
		</a>
		<!--- row end--->
		<?php }
		//load pagination view	
			if($countTotal>5){
				echo '<div class="seprator_10"></div><div class="clear"></div>';
				echo '<div class="ml15 mr12">';
				$this->load->view('pagination_multi',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/competition/usercompetition/'.$userId),"divId"=>"showCompetition","formId"=>"composeForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design'));
				echo '</div>';
			}
		   ?>
	<?php } ?>
