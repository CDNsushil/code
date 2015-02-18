<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="fl ml16 newdashright width458">
	<div class="font_museoSlab font_size24 clr_f1592a lineH38 pl20 height40"><?php echo $usedSection;?></div>
	<div class="dash_nav dashboard_topgbox_1 bdr_non width458 pl0 pr0">
	<!--<div class="dash_nav dashboard_topgbox_1 bdr_non minH445 width458 pl0 pr0">-->
		<div class="row pl18 pt6 fr mr20">
			<!-- dashboard index pages circles -->
			<?php 
			if(is_array($indexPageData) && !empty($indexPageData)) {
			for($i=0;$i<count($indexPageData);$i++) { 
				if(!empty($indexPageData[$i]['pageUrl']) && !empty($indexPageData[$i]['pageLabel'])) { ?>
					<a href="<?php echo $indexPageData[$i]['pageUrl'];?>">
						<div class="dashperformance_eventcircle font_opensansSBold font_size12 clr_white fl mr10">
							<div class="AI_table">
								<div class="AI_cell dash_link_hover">
									<?php echo $indexPageData[$i]['pageLabel'];?>
								</div>
							</div>
						</div> 
					</a>
			<?php } } }?>
			<!-- dashboard index pages circles -->
			<div class="clear"></div>
		</div>
		<?php if(isset($sectionId) && $sectionId=='13') {?>
			<div class="seprator_10"></div>
			<div class="row pr15 pl6">
				<?php 
				if(isset($lifeTimeFreeContainer)){
					echo '<div class="seprator_10"></div>';
					echo $lifeTimeFreeContainer;
				}
				?>
			</div>
		<?php }?>
		<div class="seprator_10"></div>
		<div class="row">
			<?php
			$availableContainerFlag=true;
			if(isset($usedContainer) && is_array($usedContainer) && count($usedContainer) > 0){
				$this->load->view('newUsedContainer',array('usedContainer'=>$usedContainer,'section'=>$section));
			} 
			?>
		</div>
		<!--<div class="seprator_20"></div>-->
	</div>
	<div class="row">
		<?php
		if(isset($events)){
			$availableContainerFlag=false;
			echo $events;
		}
		if(isset($launches)){
			$availableContainerFlag=false;
			echo $launches;
		}
		if(isset($eventwithlaunchs)){
			$availableContainerFlag=false; 
			echo $eventwithlaunchs;
		}

		if(isset($containerType) && $availableContainerFlag && isset($availableContainer) && !empty($availableContainer) && !isset($notAllowtoDirectUse)){
			if($containerType == 'newsReviewsContainer')echo '<div class="seprator_14"></div>';
			$this->load->view($containerType,array('availableContainer'=>$availableContainer,'section'=>$section));
		}
		else if(isset($containerType) &&  $availableContainerFlag && isset($availableContainer) && $section!='Showcase Homepage' && !isset($containermultiType) && !isset($notAllowtoDirectUse)){
			if($containerType == 'newsReviewsContainer')echo '<div class="seprator_14"></div>';
			$this->load->view($containerType,array('availableContainer'=>$availableContainer,'section'=>$section));
		}
		if(isset($newsContainer)){
			echo '<div class="dash_seprator"></div>';
			echo $newsContainer;
		}

		if(isset($reviewsContainer)){
			echo '<div class="seprator_20"></div>';
			echo $reviewsContainer;
		}
		if(isset($lifeTimeFreeContainer) && $sectionId!='13'){
			if(isset($availableContainer)){
				echo '<div class="dash_seprator"></div>';
			}else{
				echo '<div class="seprator_20"></div>';
			}
			echo $lifeTimeFreeContainer;
		}
		
		if(isset($assigned_collaboration)){
			echo '<div class="seprator_14"></div>';
			echo $assigned_collaboration;
		}
		?>
		<?php //$this->load->view('dashboard/newUsedContainer');?>
		<div class="clear"></div> 
	</div>
	<div class="clear"></div>
	<div class="seprator_16"></div> 	
</div>
