<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="row pr">
	<div class="seprator_6"></div>
	<ul class="wp_news_tab work_tab_box bdrL_white ml16 fl" id="tabs_link">
		<?php 
		$activeApplied=false;
		$aciveClass='wp_tab_selected';
		if(isset($countProject) && is_numeric($countProject) && ($countProject > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="latestProjectsTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover width128px <?php echo $aciveClass?>">Latest Projects </li>
			<?php 
		}
		if(isset($countMember) && is_numeric($countMember) && ($countMember > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="LatestMembersTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover width140px <?php echo $aciveClass?>">Latest Members </li>
			<?php 
		}
		if(isset($countEvent) && is_numeric($countEvent) && ($countEvent > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="LatestEventsTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover width115px <?php echo $aciveClass?>">Latest Events</li>
			<?php 
		}
		if(isset($countFProduct) && is_numeric($countFProduct) && ($countFProduct > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="latestFreeProductsTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover width_173px <?php echo $aciveClass?>">Latest Free Products</li>
			<?php 
		}
		if(isset($countSProduct) && is_numeric($countSProduct) && ($countSProduct > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="latestProductTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover width204px <?php echo $aciveClass?>">Latest Products For Sale</li>
			<?php 
		}
		
		if(isset($countWProduct) && is_numeric($countWProduct) && ($countWProduct > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="latestProductsWantedTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover width202px <?php echo $aciveClass?>">Latest Products Wanted </li>
			<?php 
		}
		
		
		
		
		
		if(isset($countUOwork) && is_numeric($countUOwork) && ($countUOwork > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="latestWorkTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover f17 width56px <?php echo $aciveClass?>">Urgent</li>
			<?php 
		}
		if(isset($countOwork) && is_numeric($countOwork) && ($countOwork > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="latestWorkOfferedTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover f17 width110px<?php echo $aciveClass?>">Work Offered </li>
			<?php 
		}
		
		if(isset($countEOwork) && is_numeric($countEOwork) && ($countEOwork > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="latestWorkOfferedExpTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover f17 width211px <?php echo $aciveClass?>">Work Experienced Offered</li>
			<?php 
		}
		if(isset($countWwork) && is_numeric($countWwork) && ($countWwork > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="latestWorkWantedTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover f17 width110px <?php echo $aciveClass?>">Work Wanted</li>
			<?php 
		}
		
		if(isset($countEWwork) && is_numeric($countEWwork) && ($countEWwork > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="latestWorkWantedExpTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover f17 width210px<?php echo $aciveClass?>">Work Experienced Wanted</li>
			<?php 
		}
		
		if((isset($countPost) && is_numeric($countPost) && ($countPost > 0))){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="postTab" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover width103px <?php echo $aciveClass?>">Latest Posts</li>
			<?php 
		}
		
		if(isset($countUpcoming) && is_numeric($countUpcoming) && ($countUpcoming > 0)){ 
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="tabLUP" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover width220px <?php echo $aciveClass?>">Latest Upcoming Projects </li>
			<?php
		}
		if(isset($countNews) && is_numeric($countNews) && ($countNews > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="tabNews" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover width48px <?php echo $aciveClass?>">News </li>
			<?php
		}
		if(isset($countReviews) && is_numeric($countReviews) && ($countReviews > 0)){
			if($activeApplied){
				$aciveClass='';
			}
			$activeApplied=true;
			?>
			<li tab="tabReviews" class="tabMenuFrontEnd wp_tab pl10 pr10 clr_white bdrR_white Semibold_hover width69px <?php echo $aciveClass?>"> Reviews </li>
			<?php
		}
		
		
		
		?>
	<!--review_box_tab-->
	</ul>
	
</div>
<div class="clear"></div>
       
