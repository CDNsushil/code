<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	// set bigViewPort Div height according to the record
	if($isCompetitionList){
		$competitionListCount = count($competition_array);
		if($competitionListCount <= 3){
			$bigViewHeight="bigViewHeight432px";
		}elseif($competitionListCount <= 6){
			$bigViewHeight="bigViewHeight870px";
		}elseif($competitionListCount <= 9){
			$bigViewHeight="bigViewHeight1310px";
		}else{
			$bigViewHeight="bigViewHeight1750px";
		}
	}else{
		$bigViewHeight="bigViewHeight432px";
	}
?>
	<div class="row">  
            <div class="cell">
            <div class="bdr_grey10 global_shadow bg_white ml40 width_880 position_relative">
                <div class="seprator_15"></div>
                <div id="slider<?php echo $competitionData['industryId']; ?>" class="slider competitions_scroll_container heightAuto " > 
                <a href="javascript:void(0)" class="buttons next mr10 disable"></a>
                <a href="javascript:void(0)" class="buttons prev mr3 left-44"></a>
                <div class="viewport competitions_scroll_container ml7 bigviewport <?php echo $bigViewHeight; ?> overflow_inherit minH430">
                <ul class="overview" style="width: 1772px; left: 0px; ">
					
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
						
						$noEntry = countResult('TDS_CompetitionEntry','competitionId',$competitionDetail->competitionId);
						$noEntry = ($noEntry!='') ? $noEntry : 0;				
						
						$upcomingCounter++;	
						
						if($showDivCount==1){
							echo '<li>';
						}
						?>			
		            
                        <!--box start-->
                    <a target="_blank" href="<?php echo base_url('competition/showcase/'.$competitionDetail->userId.'/'.$competitionDetail->competitionId); ?>">
						  <div class="comp_project_box <?php echo $competitionData['borderClass']; ?> fl mr11">
                          
                          	<div class="comp_bordergradient mt4">
                          	<div class="row comt_topcontainer">
                          	<div class="cell comp_thumb_effct ml3">
                            	<img src="<?php echo $userImage ?>" alt="smallthumb" class="max_h_41 max_w_41">
                            </div>
                            
                            <div class="fr width_200">
                           	 <div class="font_opensansSBold font_size11 clr_888 lineH14">
								<?php
									$showName = $competitionDetail->firstName.' '.$competitionDetail->lastName;
									echo getSubString($showName,25); 
								?>
                             <span class="fr clr_f1592a font_size16 mr5 font_arial">
								<?php 
									// show total entries count of each competition
									$whereCondition = array('competitionId'=>$competitionDetail->competitionId,'isPublished'=>'t','isBlocked'=>'f','isArchive'=>'f');
									$getEntriesCount = countResult('CompetitionEntry',$whereCondition);
									echo $getEntriesCount;
								?>	
                             </span>
                             </div>
                             <div class="clear"></div>
                             <div class="seprator_5"></div>
                             <div>
                          <div class="icon_no_crave4_blog_no_padding <?php echo ($competitionDetail->craveId > 0)?'craveAll_no_padding':''; ?>  cell pl28"><?php echo $craveCount?></div>
                          <div class="icon_view_competition cell pl28 ml15"><?php echo $viewCount?></div>
                           <span class="fr clr_474747 font_size14 mr5">entries</span>
                             </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          </div>
                          
                          <div class="seprator_6"></div>
                          	<div class="comp_imgcontainer ml2">
                            	<div class="AI_table">
                                    <div class="AI_cell">
                                    <img class="max_h166_w250" src="<?php echo $imgSrc ?>">
                                    </div>
								</div>
                            </div>
                            
                            <div class="font_size14 font_museoSlab clr_bb281c mt8 pl5"><?php echo getSubString($competitionDetail->title,25)?></div>
							<?php 
								
								$languageSecondData  = getDataFromTabel('CompetitionLang', $field='title',  $whereField=array('competitionId'=>$competitionDetail->competitionId), '', '', 'ASC', $limit=1, $offset=0, $resultInArray=false);
								
								if($competitionDetail->isMultilingual!="t" && !empty($languageSecondData)){
									
									echo '<div class="mt3 height39 overflow_hidden pl8 pr5">
										  <div class="font_size14 font_museoSlab clr_bb281c mt12">';
									echo getSubString($languageSecondData[0]->title,25);
									echo '</div></div>';
								}else{	
									echo '<div class="font_size13 clr_333 font_helveticaLight mt3 lineH15 height48 overflow_hidden pl8 pr5">';
									echo getSubString($competitionDetail->onelineDescription,70);
									echo '</div>';
								}
							?>	
							<div class="seprator_10"></div>
                          
                         <div class="font_opensansSBold clr_444 pl36">
                          	<div class="row"><span class="fl width55px">Entries: </span>  <?php echo date("d/m/y",strtotime($competitionDetail->submissionStartDate)); ?> - <?php echo date("d/m/y",strtotime($competitionDetail->submissionEndDate)); ?></div>
                            <div class="row"><span class="fl width55px">Vote: </span>  <?php echo date("d/m/y",strtotime($competitionDetail->votingStartDate)); ?> - <?php echo date("d/m/y",strtotime($competitionDetail->votingEndDate)); ?></div>
                          </div>
                          
                          
                        	<div class="<?php echo $competitionData['buttonClass']; ?> cell mt15 ml4">
								<?php  $this->load->view('competition_entry_button',array('userId'=>'','competitionId'=>$competitionDetail->competitionId,'label'=>'Enter','class'=>'width_220','mouse_down'=>'mousedown_tds_compenter(this)','mouse_up'=>'mouseup_tds_compenter(this)')); ?>         
							</div>
                        
                        </div>
                        
                         </a>
					<?php  
					
						if($showDivCount==$totalDivShow){
							echo '</li>';
							$showDivCount=1;
						}else{
							$showDivCount++;
						}
					
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
      
      
