<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="Fleft ml8 width_490 pt15 minH702">
	<div>
		<div class="font_museoSlab font_size24 clr_D45730 ml20 fl width_280 mt5"><?php echo $usedSection;?></div>
		<div class=" width_152 fr text_alignR mr20  ">
			<?php
			if((isset($usedContainer) && $usedContainer && is_array($usedContainer) && count($usedContainer) >0) || ((isset($lifeTimeFreeContainer[0]->elementId) && $lifeTimeFreeContainer[0]->elementId > 0))){ ?>
				<a class="font_opensans font_size13 clr_f1592a" href="<?php echo $showcaseSectionLink;?>"><?php echo $showcase_section;?> </a><br/>
				<a class="font_opensans font_size13 clr_f1592a" href="<?php echo $AdministrationSectionLink;?>"><?php echo $administration_section;?></a>
				<?PHP
			}?>
		</div>
		<div class="clear"></div>
	</div>
	
	<?php
	$availableContainerFlag=true;
	if(isset($usedContainer) && is_array($usedContainer) && count($usedContainer) > 0){
		$this->load->view('usedContainer',array('usedContainer'=>$usedContainer,'section'=>$section));
	} 
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
		echo '<div class="seprator_14"></div>';
		echo $reviewsContainer;
	}
	if(isset($lifeTimeFreeContainer)){
		if(isset($availableContainer)){
			echo '<div class="dash_seprator"></div>';
		}else{
			echo '<div class="seprator_14"></div>';
		}
		echo $lifeTimeFreeContainer;
	}
	if(isset($assigned_collaboration)){
		echo '<div class="seprator_14"></div>';
		echo $assigned_collaboration;
	}
	
	?>
	<div class="clear"></div>
	<div class="seprator_20"></div>
	<div class="font_opensans font_size12 clr_666 text_alignR dash_welcome_hover"><a class="orange" href="<?php echo base_url(lang().'/dashboard/loadPage/'.$welcomePage);?>"><?php echo $welcomeHeading;?></a></div>
</div>
