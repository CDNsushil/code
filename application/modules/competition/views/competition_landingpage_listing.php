<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row">  
		<div class="cell">
            <div class="<?php echo $competitionData['borderClass']; ?> global_shadow ml40 width_880 position_relative">
              	<div class="seprator_14"></div>
                <div id="competitionSlider<?php echo $competitionData['industryId']; ?>" class="slider competitions_scroll_container height452"> 
				  <a class="buttons next mr10 opacity_P7" href="#"></a>
				  <a class="buttons prev mr3 left-44 opacity_P7" href="#"></a>
                  <div class="viewport competitions_scroll_container ml7 height452">
                    <ul class="overview">
						
					<?php
					$competition_array = $competitionData['competitionData'];
				
					$showDivCount=1;
					foreach($competition_array as $countupcoming => $competitionDetail){ 
					
						$creative=$competitionDetail->creative;
						$associatedProfessional=$competitionDetail->associatedProfessional;
						$enterprise=$competitionDetail->enterprise;
							
						$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg_xxs'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg_xxs'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):''));						
						$userImage="media/".$competitionDetail->username."/profile_image/".$competitionDetail->image;
						$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
						$userImage=getImage($userImage,$userDefaultImage);					
					
						$userCoverImage='';
						$userdefCoverImage=$this->config->item('defaultcompetitonImageListing'); 
						
						$userCoverImage = addThumbFolder($competitionDetail->coverImage, '_m');	
						$imgSrc = getImage($userCoverImage,$userdefCoverImage);
										
											
						$craveCount = ($competitionDetail->craveCount!='') ? $competitionDetail->craveCount : 0;
						$viewCount  = ($competitionDetail->viewCount!='')  ? $competitionDetail->viewCount  : 0;
						$ratingAvg  = ($competitionDetail->ratingAvg!='')  ? $competitionDetail->ratingAvg  : 0;
						
						
						?>	
						<li>
						<a target="_blank" href="<?php echo base_url('competition/showcase/'.$competitionDetail->userId.'/'.$competitionDetail->competitionId); ?>">
						<div class="comp_project_box_new">
						<div class="comp_imgcontainer_1 ml2">
						<div class="compimgtitle font_opensansSBold clr_white font_size16 text_alignC">
							<?php
									$showName = $competitionDetail->firstName.' '.$competitionDetail->lastName;
									echo getSubString($showName,25); 
								?>
						</div>
						<div class="AI_table">
						<div class="AI_cell">
						<img class="max_h170_w255" src="<?php echo $imgSrc ?>">
						</div>
						</div>
						</div>

						<div class="comp_imgbtitle font_museoSlab font_size16 clr_white">

						
						<?php 
							if($competitionDetail->isMultilingual == "t" && isset($competitionDetail->title_lang2) && strlen($competitionDetail->title_lang2)>2){
								echo getSubString($competitionDetail->title,20);
								echo "<br />";
								echo getSubString($competitionDetail->title_lang2,20);
									
							}else{
								echo getSubString($competitionDetail->title,20);
							}
							?>
						

						</div>
						<div class="clear"></div>
						<div class="seprator_10"></div>
						<div class="font_size13 clr_333 font_helveticaLight mt3 lineH15 height_62 overflow_hidden pl8 pr5"><?php echo getSubString($competitionDetail->onelineDescription,70);?></div>
						<div class="seprator_1"></div> 
						<div class="font_opensansSBold clr_444 pl36 bg_f8f8f8 width_216 pt5 height_83">
						<div class="row"><span class="fl width_55 clr_f1592a">Entries:</span>  <?php echo date("d/m/y",strtotime($competitionDetail->submissionStartDate)); ?> - <?php echo date("d/m/y",strtotime($competitionDetail->submissionEndDate)); ?></div>
						<div class="row"><span class="fl width_55 clr_f1592a">Vote:</span>  <?php echo date("d/m/y",strtotime($competitionDetail->votingStartDate)); ?> - <?php echo date("d/m/y",strtotime($competitionDetail->votingEndDate)); ?></div>
						
						
						<?php  $this->load->view('competition_entry_button',array('userId'=>$competitionDetail->userId,'competitionId'=>$competitionDetail->competitionId,'competitionRoundType'=>$competitionDetail->competitionRoundType,'submissionEndDate'=>$competitionDetail->submissionEndDate,'label'=>'Enter','class'=>'width_220','mouse_down'=>'mousedown_tds_compenter(this)','mouse_up'=>'mouseup_tds_compenter(this)')); ?> 
						
						</div>

						<div class="clear"></div>
						</div>

						<div class="row">
						<div class="SMA_comp_status_bar ml1 pt2">
							<span class="blogS_view_btn Fright "><?php echo $viewCount?></span><span class="blogS_crave_btn Fright width_20 <?php echo ($competitionDetail->craveId > 0)?'craveAll_no_padding':''; ?>"><?php echo $craveCount?></span>
						</div>

						</div>

						</div>
						</a>
						</li>
						
						<?php 
					}  ?>		
                    </ul>
                  </div>
                </div>
                <div class="clear seprator_5"></div>
                <!--latest_project_slider_heading-->
              </div>
              
            <div class="seprator_45"></div>
            
		</div>
            <!--latest_project_and_upcoming_wp-->
            <div class="clear"></div>
    </div>
      
      <script>
		$(document).ready(function(){
			if($('#competitionSlider<?php echo $competitionData['industryId']; ?>')) $('#competitionSlider<?php echo $competitionData['industryId']; ?>').tinycarousel({ axis:'x', display:3, start:1});		
		});
	  </script>
