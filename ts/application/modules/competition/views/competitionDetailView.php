<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


	//get industry name
	$industryName = $industryArray['showHeading'];
	$sortButton = $industryArray['sortButton'];
	$bigButton = $industryArray['bigButton'];
	
	//get competition cover image
	if(!empty($competitionDetail->coverImage) && isset($competitionDetail->coverImage))
			$mainCoverImage = $competitionDetail->coverImage;
		else
			$mainCoverImage = '';
	$coverImage='';
	$defCoverImage=$this->config->item('defaultcompetitonImageListing');
	$coverImage = addThumbFolder($mainCoverImage,'_b');	
	$projectImage = getImage($coverImage,$defCoverImage);
	//  set submition and vote date according to round type
		
	$currentDate = strtotime(date("Y-m-d"));
	$createdDate = strtotime($competitionDetail->createdDate);
	$submissionStartDate = strtotime($competitionDetail->submissionStartDate);
	$submissionEndDate = strtotime($competitionDetail->submissionEndDate);
	$votingStartDate = strtotime($competitionDetail->votingStartDate);
	$votingEndDate = strtotime($competitionDetail->votingEndDate);
	$roundTypeLable = $this->lang->line('userCompetitionRound1');// set current round type
	$onGoingRound='1';// set current going round
	if($competitionDetail->competitionRoundType==2){
		
		if($votingEndDate <= $currentDate){
			$submissionStartDate = strtotime($competitionDetail->submissionStartDateRound2);
			$submissionEndDate = strtotime($competitionDetail->submissionEndDateRound2);
			$votingStartDate = strtotime($competitionDetail->votingStartDateRound2);
			$votingEndDate = strtotime($competitionDetail->votingEndDateRound2);
			$roundTypeLable = $this->lang->line('userCompetitionRound2');// set current round type
			$onGoingRound='2';// set current going round
		}
	}
	
	
	
	
	
	//get language 2 data if exist 	
	$languageSecondData  = getDataFromTabel('CompetitionLang', $field='title,onelineDescription,criteria',  $whereField=array('competitionId'=>$competitionId), '', '', 'ASC', $limit=1, $offset=0, $resultInArray=false);

	// set competition title,onelinedescription etc.
	$competitionTitle   = $competitionDetail->title;
	$onelineDescription = $competitionDetail->onelineDescription;
	$competitionCriteria = $competitionDetail->rules;

	// check selected lanauge 
	if($language=="language2" && $competitionDetail->isMultilingual=="t" && !empty($languageSecondData)){
		$language2Data      = $languageSecondData[0];
		$competitionTitle   = $language2Data->title;
		$onelineDescription = $language2Data->onelineDescription;
		$competitionCriteria = $language2Data->criteria;
	}

?>	

	<div class="row mr46 bdr_Bgrey pb15 ml46">
		<div class=" font_opensansSBold font_size20 fl mt2 clr_444">
			<?php  
				echo $industryName;	
			?>
		</div>
		<?php 	
		
		//--------get competition language-------//
		$competitionLanguageFirst =  getLanguage($competitionDetail->languageId);
		if($competitionDetail->languageid2 > 0){
		  $competitionLanguageSecond =getLanguage($competitionDetail->languageid2);
		} 	
		
		if($competitionDetail->isMultilingual=="t" && !empty($languageSecondData)){ ?>	
			<div class="fr font_opensans font_size14 clr_444 mt4">
				<ul class="comp_tab">
					<li><a class="<?php echo ($language=='language1')?'active':''; ?>"    href="<?php echo base_url('competition/showcase/'.$userId.'/'.$competitionId.'/language1');?>" ><?php
					 //showl language first
					 if($competitionDetail->languageId > 0){
							echo $competitionLanguageFirst;
						}else{
							echo $this->lang->line('competitionLanguage1'); 
						}
					 ?></a></li>
					<li><a class="<?php echo ($language=='language2')?'active':''; ?>"    href="<?php echo base_url('competition/showcase/'.$userId.'/'.$competitionId.'/language2');?>"><?php
					 //showl language second	
						if($competitionDetail->languageid2 > 0){
							echo $competitionLanguageSecond;
						}else{
							echo $this->lang->line('competitionLanguage2');
						}
					  ?></a></li>
				</ul>
			</div>
		<?php } ?>
		<div class="clear">
		</div>
	</div>
	<div class="row mr46 ml46">
		<div class="text_alignC font_museoSlab font_size30 clr_bb281c lineh50 bdr_Bgrey word-spacing2 letter_spac2">
			<?php echo $competitionTitle; ?>
		</div>
		<div class="clear">
		</div>
	</div>
	<div class="row pl41">
		<div class="seprator_34">
		</div>
		<div class="compvideo_shedow fl mt3">
			<div class="AI_table">
				<div class="AI_cell">
					<img src="<?php echo $projectImage; ?>" alt="compvideo">
				</div>
			</div>
		</div>
		<div class="fl ml39 width_216 font_opensansLight font_size14">
			
			<?php if($competitionDetail->competitionRoundType==2){ ?>
				<div class="font_opensansSBold font_size16 clr_333 bdr_Bgrey pb7 mb12">
					<?php echo $roundTypeLable;  ?>
				</div>
			<?php } ?>
			
			<div class="lineH20 min_height_180">
				<?php echo getSubString($onelineDescription,290); ?>
			</div>
			<div class="seprator_18">
			</div>
			<div class="<?php echo $bigButton; ?> cell font_opensansSBold">
			<?php
			// show crave button
			if($currentDate < $submissionStartDate){
				?>
				<a onmousedown="mousedown_tds_compenter1(this)" onmouseup="mouseup_tds_compenter1(this)"><span class="width_206 clr_444 font_size22 comp_textS"><?php echo $this->lang->line('userCompetitionVoteCrave'); ?></span></a>
			<?php
				}
				 
				// show enter button
				if($submissionStartDate <= $currentDate && $submissionEndDate >= $currentDate )
					{ 
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
				<a href="javascript:void(0)"  onclick="<?php echo $function;?>" onmousedown="mousedown_tds_compenter1(this)" onmouseup="mouseup_tds_compenter1(this)"><span class="width_206 clr_444 font_size22 comp_textS"><?php echo $this->lang->line('userCompetitionEnterButton'); ?></span></a>
			<?php
			// show vote button
				} 
			if($votingStartDate <= $currentDate &&  $votingEndDate >= $currentDate )
				{  ?>
				<a href="<?php echo base_url('competition/showcaseentries/'.$userId.'/'.$competitionDetail->competitionId.'/'.$onGoingRound);?>" onmousedown="mousedown_tds_compenter1(this)" onmouseup="mouseup_tds_compenter1(this)"><span class="width_206 clr_444 font_size22 comp_textS"><?php echo $this->lang->line('userCompetitionVoteButton'); ?></span></a>
			<?php } 
			// show winner button
			if($votingEndDate < $currentDate ){
			?>
				<a href="<?php echo base_url('competition/showcaseentries/'.$userId.'/'.$competitionDetail->competitionId.'/'.$onGoingRound);?>" onmousedown="mousedown_tds_compenter1(this)" onmouseup="mouseup_tds_compenter1(this)"><span class="width_206 clr_444 font_size22 comp_textS"><?php echo $this->lang->line('userCompetitionVoteWinners'); ?></span></a>
			<?php }  ?>
			</div>
		</div>
		<div class="clear">
		</div>
	</div>
	<div class="seprator_52">
	</div>
	<div class="row">
		<div class="comp_shedow_bg">
			<div class="comp_shedow_img">
			</div>
			<div class="pt24 pl23 pb25 ">
				<div class="row font_museoSlab font_size28 clr_f1592a pl18">
					<?php echo $this->lang->line('competitionCriteria'); ?> <span class=" font_opensans clr_333 font_size12 inline"> <?php echo $this->lang->line('competitionCriteriaMsg'); ?></span>
				</div>
				<div class="seprator_27"> </div>
			
				<?php echo $competitionCriteria; ?>
				
				<div class="row lineH28 pl16">
					<div class="seprator_20"></div>
					<div class="row">
						<div class="colomboxLeft">
							<?php echo $this->lang->line('competitionAge'); ?>
						</div>
						<div class="colomboxRight">
							<?php echo $competitionDetail->ageRequiresFrom; ?> - <?php echo $competitionDetail->ageRequiresTo; ?>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="row">
						<div class="colomboxLeft">
							<?php echo $this->lang->line('competitionLanguage'); ?>
						</div>
						<div class="colomboxRight">
						<?php 
						// show language1 and language2
							echo $competitionDetail->criterilalang1;
							if($competitionDetail->isMultilingual=="t" && $competitionDetail->criteriaLang2Id > 0 && !empty($competitionDetail->criterilalang2)){
								echo '&nbsp; '.$competitionDetail->criterilalang2;
							} 		
						?>	
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="row">
						<div class="colomboxLeft">
							<?php echo $this->lang->line('competitionTeritory'); ?>
						</div>
						<div class="colomboxRight">
							<div>
								<?php echo $this->lang->line('userCompetitionEntries'); ?> <span class="font_opensans font_size13 clr_333 lineH18 mt3">
								<?php if($competitionDetail->competitionCountries!=NUll){
									echo zoneCountries($competitionDetail->competitionCountries);
								}else{
									echo 'Global';
								}?>
								</span>
							</div>
							<div class="mt10">
								<?php echo $this->lang->line('userCompetitionVotes'); ?> <span class="font_opensans font_size13 clr_333 lineH18 mt3">
									<?php if($competitionDetail->votesCountries!=NUll){
										echo zoneCountries($competitionDetail->votesCountries);
									}else{
										echo 'Global';
									}?>
									</span>
							</div>
							<div class="clear">
							</div>
							<div class="seprator_40">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="colomboxLeft">
							<?php echo $this->lang->line('userCompetitionEnterButton'); ?>
						</div>
						<div class="colomboxRight text_shedow_comp font_size18 font_opensansSBold">
							<?php echo date("d M ’y",$submissionStartDate); ?>&nbsp;&nbsp; - &nbsp;&nbsp;<?php echo date("d M ’y",$submissionEndDate); ?>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="row">
						<div class="colomboxLeft">
							<?php echo $this->lang->line('userCompetitionVoteButton'); ?>
						</div>
						<div class="colomboxRight font_size18 text_shedow_comp font_opensansSBold">
							<?php echo date("d M ’y",$votingStartDate); ?>&nbsp;&nbsp; - &nbsp;&nbsp;<?php echo date("d M ’y",$votingEndDate); ?>
						</div>
						<div class="clear">
						</div>
					</div>
				</div>
				<?php 
			
					// load media listing div
					$this->load->view('competitionDetailMediaList'); 
				?>
			</div>
			<div class="comp_shedow_img shedow_pos">
			</div>
		</div>
		<div class="clear">
		</div>
	</div>
	<div class="row">
		<div class="font_opensans clr_333 font_size13 mt2 pl190 pr25"><?php echo $this->lang->line('compoetitionMediaSizeMsg'); ?></div>
		<div class="seprator_10"></div>
			<div class="<?php echo $sortButton; ?> ml24">
				<a href="<?php echo base_url('competition/showcaseprizes/'.$userId.'/'.$competitionId ); ?>" onmousedown="mousedown_tds_button_jludark(this)" onmouseup="mouseup_tds_button_jludark(this)"><span class="font_size18 width_80"><?php echo $this->lang->line('competitionPrizesButton'); ?></span></a> 
			</div>
		  <div class="font_opensans font_size13 fr clr_444 mt10 mr30"><?php echo $this->lang->line('headingUserCompetitionMsg'); ?></div>
			<?php
			
				// show total entries count of each competition
				$whereCondition = array('competitionId'=>$competitionId,'isPublished'=>'t','isBlocked'=>'f','isArchive'=>'f');
				$getEntriesCount = countResult('CompetitionEntry',$whereCondition);
			if($getEntriesCount >0){
			?>
			<div class="font_opensansSBold font_size18 clr_666 mt8 fr mr10"><?php echo $this->lang->line('userCompetitionEntries'); ?> <span class="inline clr_f1592a"><?php echo $getEntriesCount; ?></span></div>
			<?php } ?>
		  <div class="clear"></div>
	</div>
