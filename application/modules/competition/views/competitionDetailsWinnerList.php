<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
// get current time and vote end date
$currentDate = strtotime(date("Y-m-d"));
$votingEndDate       = strtotime($competitionDetail->votingEndDate);

if(!empty($competitionWinnerList) && is_array($competitionWinnerList) && $votingEndDate <= $currentDate  ){ ?>	
<div class="seprator_25"></div>
<div class="bdr6_666 bg_white pt12 pb6 bg_444 global_shadow ml6 mr6">
	<div class="row font_helveticaLight font_Size42 clr_6c6c6c text_alignC lineH_32"><?php echo $this->lang->line('competitionDetailsWinners'); ?></div>
		<div id="slider1" class="slider"> 
		  <div id="slider-code">
			<a class="buttons prev disable" href="javascript:void(0)">left</a>
			<div class="viewport">
			<ul class="overview" style="width: 1248px; left: 0px; ">
				<?php
				$divCount=1;
				$winnerPositionCount=1;
				foreach($competitionWinnerList as $competitionWinner) {
				switch($divCount){
					case 1:
					$fontColorClass = "clr_f1592a";
					break;
					case 2:
					$fontColorClass = "clr_AACC29";
					break;
					case 3:
					$fontColorClass = "clr_ed1c24";
					break;
				}
				
				//get competition prize winner cover image
				if(!empty($competitionWinner->coverImage) && isset($competitionWinner->coverImage))
						$mainPrizeImage = $competitionWinner->coverImage;
					else
						$mainPrizeImage = '';
				$prizeImage='';
				$defPrizeImage=$this->config->item('defaultcompetitonEntryImg73X110');
				$prizeImage = addThumbFolder($mainPrizeImage,'_s');	
				$prizeImage = getImage($prizeImage,$defPrizeImage);	
				?>
				 	<li>
						<div class="comp_smslider_list position_relative  fl mr11">
							<div class="comp_countpa font_size60 lineh50 right5 top-25 <?php echo $fontColorClass; ?> "><?php echo $winnerPositionCount; ?></div>
							<div class="compscroll_imgdiv">
								<img src="<?php echo $prizeImage; ?>" alt="img1" class="max_height_72">
							</div>
							<div class="font_opensans font_size12 pl16 pr16 lineH14 mt8 clr_444"><?php echo getSubString($competitionWinner->title,30); ?></div>
						</div>
					</li> 
				<?php if($divCount==3){
				   $divCount=1;
				}else{
					$divCount++;
				}   $winnerPositionCount++; } ?>
			</ul>
		 </div>
			<a class="buttons next" href="javascript:void(0)">right</a>
		</div>
		
		</div>

 </div>	
<?php } ?> 	
