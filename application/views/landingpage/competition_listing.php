<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($competition_array) && !empty($competition_array)){
	$upcomingCounter =0;
	$countproj = count($competition_array);
	?>
	<div class="row tabFrontEnd pl10 pr10 pb10 pt5 <?php echo $competitionDisplay;?>" id="competitionTab" >
		<div id="competitionProjectSlider" class="slider wp_project_scroll_btn_box  fv_btn_box">
			<div class="position_relative">
				<div class="z_index_2 position_relative">
					<a href="#" class="buttons next"></a><a href="#" class="buttons prev mr3 disable"></a>
				</div>
				<div class="fakebtn z_index_1">
					<span class="buttons next"></span><span class="buttons prev mr3"></span>
				</div>
				<?php echo $addCompetitionButton;?>
			</div>
					  
			<div class="viewport competitions_scroll_container">
			   <ul class="overview">
					<?php
					
					
					
					
					foreach($competition_array as $countupcoming => $competitionDetail){ 
						
						
						
						//$competitionDetailUrl = base_url(lang().'/upcomingfrontend/viewproject/'.$competitionDetail['tdsUid'].'/'.$competitionDetail['projId'].'/'.$frontendMathod);
						
						/*if($competitionDetail['enterprise']=='t'){
							$userFullName = $competitionDetail['enterpriseName'];
						}else{
							$userFullName = $competitionDetail['firstName'].' '.$competitionDetail['lastName'];
						}
						*/
						
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
						
						if(($countupcoming%18)==0){
								//echo '<li>';
						} ?>
					<li>	
					 <div class="comp_project_box">
                          
                          	<div class="comp_imgcontainer">
                            	<img src="<?php echo $imgSrc ?>" alt="comp1" class="comp_img" />
                                <div class="cpmp_imgdate_cont top0 left0 font_opensansSBold">
                                <span class="pl6 pr8 pt2 pb4"><?php echo dateFormatView($competitionDetail->createdDate,'d M Y') ?></span> 
                                </div>
                              <!--  
                                 <div class="cpmp_imgdate_cont left0 bottom6 font_opensansSBold text_alignR">
                                <span class="pl6 pr8 pt2 pb4"><?php //echo $industryType ?></span> 
                                </div>
                               --> 
                                
                            </div>
                            
                            
                          <div class="font_size14 font_museoSlab clr_bb281c mt14"><?php echo getSubString($competitionDetail->title,35)?></div>
                          <div class="font_size12 clr_333 font_opensansLight mt12 lineH18 height_90 overflow_hidden"><?php echo getSubString($competitionDetail->description,150)?> </div>
                        
                          <div class="seprator_20"></div>
                          <div class="row">
                          	<div class="cell comp_thumb_effct">
                            	<img class="max_h_50 cell" src="<?php echo $userImage ?>" alt="smallthumb" />
                            </div>
                            
                            <div class="fr bdr_td6d6d6 width_196">
                           	 <div class="font_opensansSBold font_size12 clr_888 mt3 ml10"><?php echo $competitionDetail->firstName.' '.$competitionDetail->lastName ?> </div>
                             <div class="clear"></div>
                             <div class="seprator_10"></div>
                             <div class="pl8">
                          <div class="icon_crave5_blog cell pl28"> <?php echo $craveCount?></div>
                          <div class="icon_view5_blog cell pl28 ml15"><?php echo $viewCount?></div>
                          <div class="cell ml15">Entries <?php echo $noEntry ?></div> 
                             </div>
                            </div>
                          </div>
                                                    
                        </div>	</li>
                        				
						<?php
						if((($countupcoming != 0) && (($countupcoming+1)%18)==0) || (count($competition_array)==($countupcoming+1)) ){
							//echo '</li>';
						} ?>
						
				<?	}?>
				</ul>
			</div>
		</div>
	</div>
	<?php 
}
