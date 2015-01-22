<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 ?>
<div class="width_451 sub_col_middle global_shadow height600">
	<div>
		<div class="row pr">
			<ul id="tabs_link" class="wp_news_tab lborder0">
				<li tab="tab1" class="tabMenuFrontEnd wp_tab pr10 dash_link_hover wp_tab_selected f24"><?php echo $this->lang->line('entries'); ?> </li>
				<li tab="tab2" class="tabMenuFrontEnd wp_tab pl10 pr10 dash_link_hover f24"><?php echo $this->lang->line('prizes'); ?> </li>
						<!--review_box_tab-->
			</ul>
		</div>
		<h1 class="sumRtnew_strip width185px fontN fr lh40 orange mt-5">
			<?php echo $this->lang->line('View_All_Entries'); ?>
			<div class="Fright mt9">
				<a onmousedown="mousedown_plus_icon(this)" onmouseup="mouseup_plus_icon(this)" class="ma_plus_icon" style="background-position: 0px 0px; "></a>
			</div>
		</h1>
	</div>
	<!--------Competition Entry list div----------->
	<div class="row tabFrontEnd pl10 pr10 pb10 pt5 " id="tab1" style="display: block; ">
		<div class="Entrieslistingtoggle">
		  <div >
			<div id="EntriesCollectionSlider" class="slider pt10"> <a class="buttons prev disable" href="#"></a>
			  <div class="viewport mh477 width_440">
				<ul class="overview" style="height: 620px; top: 0px; "> 
				<?php 
					if($competitionEntries) {
					foreach($competitionEntries as $competitionEntriesList){
						
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
					?>
						<li style="">
							<div class="row pr white bg_leftMenu">
							  <div class="row">
								<div class="cell recent_thumb_PApage thumb_absolute01">
								  <div class="AI_table">
									<div class="AI_cell"> 
									<a href="javascript:void(0)">
										<img src="<?php echo $entryCoverImage; ?>" class="bdr_cecece max_w68_h68">
									 </a></div> 
								  </div>
								</div>
								<div class="cell ml71 width355px ">
									<div class="recent_two_line01 bdr_B_7E7E7E height_42  width270px ml50 white"><?php echo $competitionEntriesList->title; ?></div>
									<div class="recent_two_line01 height33 ml50 width270px tac ">
									    <a href="javascript:void(0)" class="orange_color dash_link_hover">
										 <?php echo $this->lang->line('compti_showcase_view'); ?>  </a> | 
										<?php if($daysLeft > 0) { ?>
									  	<a href="javascript:openLightBox('popupBoxWp','popup_box','/competition/competitionentryvote','<?php echo $competitionId; ?>','<?php echo $competitionEntryId; ?>');" class="orange_color dash_link_hover">
										<?php echo $this->lang->line('compti_showcase_vote'); ?>   </a> | 
										<?php } ?> 
										<a href="javascript:openLightBox('popupBoxWp','popup_box','/competition/shortlistNunshorlist','<?php echo $competitionId; ?>','<?php echo $competitionEntryId; ?>');" class="orange_color dash_link_hover">
										 <?php echo $this->lang->line('compti_showcase_shortlist'); ?>  </a>
										 <div class="cell comp_thumb_effct fr">
											<img class="minMaxHeight27px cell" src="<?php echo $userImage ?>" alt="smallthumb">
										</div>
									</div>
								  <div class="clear"></div>
								</div>
							  </div>
							  <div class="clear"></div>
							</div>
						  </li>
					<?php } } ?> 	
				</ul>
			  </div>
			  <a class="buttons next" href="#"></a> </div>
		  </div>
		</div>
	</div>	
	<!--------Prizes list div----------->
	<div class="row tabFrontEnd pl10 pr10 pb10 pt5 " id="tab2" style="display: none; ">  
		<div class="Prizeslistingtoggle">
		  <div >
			<div id="prizesCollectionSlider" class="slider pt10"> <a class="buttons prev disable" href="#"></a>
			  <div class="viewport mh477 width_440">
				<ul class="overview" style="height: 620px; top: 0px; "> 
					
				<?php 
					if($competitionPrizes){
					foreach($competitionPrizes as $competitionPrizesList) {
						if(!empty($competitionPrizesList->image) && isset($competitionPrizesList->image))
								$mainCoverImage = $competitionPrizesList->image;
							else
								$mainCoverImage = '';
						$coverImage='';
						$defCoverImage=$this->config->item('defaultcompetitonImg73X110');
						$coverImage = addThumbFolder($mainCoverImage);	
						$prizesImage = getImage($coverImage,$defCoverImage);	
					?>	
					<li style="">
							<div class="row pr white bg_leftMenu">
							  <div class="row">
								<div class="cell recent_thumb_PApage thumb_absolute01">
								  <div class="AI_table">
									<div class="AI_cell"> <a href="javascript:void(0)"><img src="<?php echo $prizesImage; ?>" class="bdr_cecece max_w68_h68"> </a></div>
								  </div>
								</div>
								<div class="cell ml71 width355px ">
									<div class="recent_two_line01 bdr_B_7E7E7E height_42  width270px ml50 white"><?php echo $competitionPrizesList->title; ?></div>
									<div class="recent_two_line01 height33 ml50 width270px tac ">
										<br>
									  <a href="javascript:void(0)" class="orange_color dash_link_hover">
										 <?php echo $this->lang->line('compti_showcase_view'); ?> </a>
									</div>
								  <div class="clear"></div>
								</div>
							  </div>
							  <div class="clear"></div>
							</div>
						  </li>
					<?php } } ?>  	
				 </ul>
			  </div>
			  <a class="buttons next" href="#"></a> </div>
		  </div>
		</div>
	</div>	
</div>
				
