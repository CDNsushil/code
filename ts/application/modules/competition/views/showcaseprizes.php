<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

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


$industryArray = getIndustryClass($competitionDetail->industryId);
$borderClass = $industryArray['10pxborderClass'];
$sortButton = $industryArray['sortButton'];

?>
<td valign="top">
<div class="cell right_coloumn bg_2c2c2c bg-non margin_0 <?php echo $borderClass; ?> width778 pb10">
	<div class="row font_helvetica_L ml18 pt5 pr10">
		<div class="fl height_27">
			<span class="fl font_size36 font_HelReg clr_f1592a mt2 lineH28"> <?php echo $this->lang->line('competitionPrizesHeading'); ?> </span>
			<span class="fl font_opensansSBold font_size13 clr_c9c9c9 ml96 mt-2 letter_Spoint2"><?php echo $this->lang->line('headingUserCompetitionMsg'); ?></span>
		</div>
		<div class="fr bg_2c2c2c font_size17 font_helveticaLight text_alignR height_23 mr1 bdr_4c4c4c pl10 pr10 backtocomp_shedow mr5">
			<a href="<?php echo base_url('competition/showcase/'.$userId.'/'.$competitionId); ?>" class="clr_white lineH22"><?php echo $this->lang->line('CompBacktoCompetition'); ?></a>
		</div>
		<div class="clear">
		</div>
	</div>
	<div class="seprator_15">
	</div>

	<?php 
		$whereCondition = array('competitionId'=>$competitionId);
		$getEntriesCount = countResult('CompetitionPrizeLang',$whereCondition);
		if($competitionDetail->isMultilingual=='t' && $getEntriesCount > 0){ 
	?>
		<div class="font_helveticaLight font_size16 clr_white ml18 letter_spaceP-1 tar pr10 mr5">
			<a href="<?php echo base_url('competition/showcaseprizes/'.$userId.'/'.$competitionId.'/language1'); ?>" class="clr_white font_opensansSBold <?php echo ($language=='language1')?'clr_f1592a':''; ?> ">
			<?php 
				if($competitionDetail->criteriaLang1Id > 0){
					echo getLanguage($competitionDetail->criteriaLang1Id);
				}else{
					echo $this->lang->line('competitionLanguage1'); 
				}
			?></a> | 
			<a href="<?php echo base_url('competition/showcaseprizes/'.$userId.'/'.$competitionId.'/language2'); ?>" class="clr_white font_opensansSBold <?php echo ($language=='language2')?'clr_f1592a':''; ?>">
			<?php 
				if($competitionDetail->criteriaLang2Id > 0){
					echo getLanguage($competitionDetail->criteriaLang2Id);
				}else{
					echo $this->lang->line('competitionLanguage2'); 
				}
			?></a>
		</div>
	<?php } ?>

	<div class="font_helveticaLight font_size30 clr_white ml18 lineH35 letter_spaceP-1">
		<?php echo $competitionDetail->title; ?>
	</div>
	<?php if(!empty($competitionPrizes)) {
		
		$orderCount=1; 
		foreach($competitionPrizes as $prizesData){
			
			//get competition prize image
			if(!empty($prizesData->image) && isset($prizesData->image))
					$mainPrizeImage = $prizesData->image;
				else
					$mainPrizeImage = '';
			$Image='';
			$defPrizeImage=$this->config->item('defaultcompetitonImageListing');
			$prizeImage = addThumbFolder($mainPrizeImage,'_b');	
			$prizeImage = getImage($prizeImage,$defPrizeImage);
	
			$fontColorClass = '';
			// get font color
			switch($orderCount){
				case 1:
				$fontColorClass = 'clr1_8dc63f';
				break;
				case 2:
				$fontColorClass = 'clr2_f7941d';
				break;
				case 3:
				$fontColorClass = 'clr3_aba000';
				break;
				case 4:
				$fontColorClass = 'clr4_ed145b';
				break;
				case 5:
				$fontColorClass = 'clr4_00aeef';
				break;
			}
			
		?>
		<!-----prize row start ----->
		<div class="bdr6_676767 bg_white ml15 mr15 mt10 position_relative pt13 pb15 pl8 pr8 global_shadow">
			<div>
				<div class="fl position_relative bg_444 video_compbg_1 width_333" style="height: 220px; ">
					<img alt="img" src="<?php echo $prizeImage; ?>" class="maxh220 fr mr27 max_w306">
					<div class="comp_countpa <?php echo $fontColorClass; ?>">
						<?php echo $orderCount; ?>
					</div>
				</div>
				<div class="fl ml34 width_345 minh_220">
					<div class="row font_museoSlab font_size20 clr_bc231b lineH26 mt5">
						<?php echo getSubString($prizesData->title,20); ?>
					</div>
					<div class="seprator_16">
					</div>
					<div class="row font_helvetica_L font_size16">
						<?php echo getSubString($prizesData->onelineDescription,200); ?>
					</div>
					<div class="seprator_37">
					</div>
					<div class="row font_helvetica_L font_size13 lineH16">
						<?php echo getSubString($prizesData->description,250); ?>
					</div>
				</div>
				<div class="clear">
				</div>
			</div>
			<div class="clear"></div>
	</div>
		<!-----prize row end ----->
	<?php $orderCount++; }  } ?>
	<div class="seprator_15">
	</div>
	<div class="row">
		<div class="bdr_7E7E7E bg_444 bdr_radius2 global_shadow pt15 pb25 pl32 pr26 ml15 mr14">
			<div class="fl width_420">
				<div class="industry_type_wrapper font_opensansSBold pt5">
					<div class="summery_posted_wrapper bdr_T5a5a5aP">
						<span class="cell width_206 font_museoSlab font_size17 clr_white mr14"><?php echo $this->lang->line('userCompetitionEnter'); ?> </span>
						<span class="cell font_museoSlab font_size17 clr_white width_200"><?php echo $this->lang->line('userCompetitionVote'); ?> </span>
					</div>
					<div class="summery_posted_wrapper bdr_T5a5a5aP clr_f1592a font_opensansSBold font_size15">
						<span class="cell width_206 mr14"><?php echo date("d M y",$submissionStartDate); ?> <span class="display_inline clr_333">-</span> <?php echo date("d M y",$submissionEndDate); ?></span>
						<span class="cell width_200"><?php echo date("d M y",$votingStartDate); ?> <span class="display_inline clr_333">-</span> <?php echo date("d M y",$votingEndDate); ?></span>
					</div>
					<div class="bdr_T5a5a5aP">
					</div>
				</div>
			</div>
			<div class="fr mt24 mr6">
				<div class="fl lineH27 pt11">
					<div class="icon_crave4_blog <?php echo ($competitionDetail->craveId > 0)?'cravedALL':''; ?>  clr_888 font_size14">
						<?php echo $competitionDetail->craveCount; ?>
					</div>
				</div>
				<div class="fl lineH27 pt11 ml15">
					<div class="icon_view3_blog clr_888 font_size14">
						<?php echo $competitionDetail->viewCount; ?>
					</div>
				</div>
				<div class="<?php echo $sortButton; ?> fl ml15 mt12">
					<a href="<?php echo base_url('competition/showcaseentries/'.$userId.'/'.$competitionDetail->competitionId.'/1');?>" onmousedown="mousedown_tds_button_jludark(this)" onmouseup="mouseup_tds_button_jludark(this)"><span class="font_size14 lineH26 width_85 clr_black"><?php echo $this->lang->line('userCompetitionEntriesButton'); ?></span></a>
				</div>
			</div>
			<div class="clear">
			</div>
		</div>
	</div>
	<div class="seprator_13"></div>
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

</script>

