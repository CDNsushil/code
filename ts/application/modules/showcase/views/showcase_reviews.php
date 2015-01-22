<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$reviewList= Modules::run("mediafrontend/getShowcaseReviewList",$entityId,$showcaseId,'','','','',true);

?>

<div class="bdr_Bwhite seprator_1"></div>
<div class="Fleft width_165 height_16"></div>
<div class="Fleft width_610  memberreview " id="slider_review">
	<div class="seprator_29"></div>
	<div class="CSEprise_frame mr10">
	  <div class="bg_f7f6f4 global_shadow_light">
		<div class="showcase_link_hover">
			<ul class="CSEprise_nav_new">	
				<?php if(isset($reviewList) && count($reviewList)>0 && !empty($reviewList)) { ?>
					<li id="1"><a href="javascript:void(0)" class="CSEselected"><?php echo $this->lang->line('memeber_review');  ?></a></li>
				<?php } ?>
				
				<?php if(isset($externalReviews) && count($externalReviews)>0 && !empty($externalReviews)) { ?>
					<li class="bg-non" id="2"><a href="javascript:void(0)" ><?php echo $this->lang->line('reviews'); ?></a></li>	
				<?php } ?>
			</ul>			
		</div>
		  <div class="width_601 pb5 pt7 bg_light_gray">
                    <div class="viewport">
                    <ul class="overview">
					<?php 
					$countReview=0;
					if($showcaseData['reviewMe'] == 't' && $reviewList && is_array($reviewList) && count($reviewList)){
						$countReview=count($reviewList);
						foreach($reviewList as $data){
							$imagetype=$this->config->item('defaultReviewsImg_m');
							$reviewImage=$data->imagePath;
							$thumbImage = addThumbFolder($reviewImage,'_m',$imagetype);
							$reviewImage=getImage($thumbImage,$imagetype);
							$writerName=$data->firstName.' '.$data->lastName;
							$description=$data->description;
							
							$href=base_url(lang().'/mediafrontend/searchresult/'.$data->userId.'/'.$data->projId.'/'.$data->elementId.'/reviews');
							$target='target="_blank"';
							
							$showcaseLink = base_url('/showcase/index/'.$data->userId);
							?>
							<li>
								<div class="search_result_list_wrapper bg_SRFilm mb10 ml7 mr7 width_auto ">
								  <div class="search_result_list_gradient">
									<div class="search_result_img_box w167_h167 Fleft ptr" onclick="gotourl('<?php echo $href;?>',1);">
									  <div class="AI_table">
										<div class="AI_cell"> <img src="<?php echo $reviewImage;?>" class="max_w165_h165 bdr_whiteAll"></div>
									  </div>
									</div>
									<div class="Fleft width_370 ">
									  <div class="pr"> 
										  <div class="search_title ml24 mt5 bdr_Borange_D pb3 clr_444 ptr mH20" onclick="gotourl('<?php echo $showcaseLink;?>',1);">
											  <?php echo getSubString($data->title,100);?>
										  </div>
										   <div class="ml24 clr_444 ptr oh tar font_size12 font_opensansSBold" onclick="gotourl('<?php echo $href;?>',1);">
												  <?php echo getSubString(ucwords($writerName),50);?>
											</div>
										  
										  <div class="ml24 mt8 clr_444 height_75 ptr" onclick="gotourl('<?php echo $href;?>',1);">
											  <?php //echo changeToUrl(nl2br(getSubString($description,220)));?>
											   <?php echo changeToUrl(limit_words($description,25));?>
										  </div>
										   <div class="clear"></div>
									  </div>
									  <div class="search_detail position_relative mt_minus5 ml10">
										<div class="cell shadow_wp strip_absolute left_145">
										  <img src="<?php echo base_url('images/small_seprator_shade.png');?>">
										</div>
										<div class="width137 Fleft pt15 pl20">
										  <div class="search_result_file_detail_new min_h100per ">
											<span class="clr_444 font_size12 font_opensansSBold"><?php echo get_timestamp('d F Y',$data->createdDate) ;?></span>
										  </div>
										</div>
										<div class="Fleft mt11">
										  <div class="searchpage_icon_set font_size11">
											<div class="cell mt5"> <span class="blogS_crave_btn min_w24"><?php echo $data->viewCount>0?$data->viewCount:0;?></span> </div>
											<div class="cell mt5"> <span class="blogS_view_btn"><?php echo $data->craveCount>0?$data->craveCount:0;?></span> </div>
											<div class="cell mt5 font_size11 ptr width96px"  onclick="gotourl('<?php echo $href;?>',1);"> <span class="search_arrow_right font_size12 font_opensansSBold"> <?php echo $this->lang->line('See_full_review');?></span> </div>
										  	<div class="clear"></div>
										  </div>
										</div>
										<div class="clear"></div>
									  </div>
									</div>
									<div class="clear"></div>
								  </div>
								</div>
								<div class="clear"></div>
							</li>
							<?php
						}
					}
					if($countReview==0){
						echo "<li>".$this->lang->line('noRecord')."</li>";
					}
					?>
				</ul>
			
            </div>
                         
                         <div class="clear"></div>
                          </div>
	  </div>
      
      <div class="clear"></div>
	</div>
	<div class="seprator_20"></div>
					<div class="row font_opensans ml13 mr23"> <a class="cell pre_arrow clr_444 prev">Previous </a> <a class="cell Fright next_arrow clr_444 next" href="#">Next </a>
				<div class="clear"></div>
			</div>
				</div>


<div class="Fleft width_610  externalreview dn" id="slider_review_external">
	<div class="seprator_29"></div>
	<div class="CSEprise_frame mr10">
	  <div class="bg_f7f6f4 global_shadow_light">
		<div class="showcase_link_hover">
			<ul class="CSEprise_nav_new">		
				
				<?php if(isset($reviewList) && count($reviewList)>0  && !empty($reviewList) ) { ?>
					<li  id="1"><a href="javascript:void(0)" ><?php echo $this->lang->line('memeber_review');  ?></a></li>
				<?php } ?>
				
				<?php if(isset($externalReviews) && count($externalReviews)>0 && !empty($externalReviews) ) { ?>
					<li class="bg-non" id="2"><a href="javascript:void(0)" class="CSEselected" ><?php echo $this->lang->line('reviews');  ?></a></li>	
				<?php } ?>
			</ul>			
		</div>
		  <div class="width_601 pb5 pt7 bg_light_gray">
					
                  
                    <div class="viewport">
                    <ul class="overview">
					<?php 
					
					
					
					$countReview=0;
					
					if($externalReviews && is_array($externalReviews) && count($externalReviews)){
						$countReview=($countReview+count($externalReviews));
						foreach($externalReviews as $data){
						
							if(isset($data->associatedNewsElementId) && $data->associatedNewsElementId >0){
								$href=base_url(lang().'/mediafrontend/searchresult/'.$data->tdsUid.'/'.$data->projId.'/'.$data->associatedNewsElementId.'/reviews');
								$target='target="_blank"';
							}
							elseif(!empty($data->reviewExternalUrl)){
								$externalUrl=$data->reviewExternalUrl;
								if(strstr($externalUrl,'+')){
									$externalUrl=urldecode($externalUrl); 
								}
								$href=$externalUrl;
								$target='target="_blank"';
							}
							elseif(!empty($data->reviewEmbed)){
								$Embed=$data->reviewEmbed;
								if(strstr($Embed,'+')){
									$Embed=urldecode($Embed); 
								}
								$externalUrl=getUrl($Embed);
								$externalUrl=urlencode($externalUrl);
								$href=$externalUrl;
								$target='target="_blank"';
							}
							else{
								$href='#';
								$target='';
							}					
							
							$showcaseLink = base_url('/showcase/index/'.$data->tdsUid);
							
							if(empty($data->reviewWriter)) {
								$userShowcase = showCaseUserDetails($data->tdsUid);
								$data->reviewWriter = $userShowcase['userFullName'];
							}
							
							?>
							<li>
								<div class="search_result_list_wrapper bg_SRFilm mb10 ml7 mr7 width_auto ">
								  <div class="search_result_list_gradient">
									<div class="Fleft width525px height167">
									<div class="pr"> 
										  <div class="search_title ml10 mt5 bdr_Borange_D pb3 clr_444 mH20 ptr" onclick="gotourl('<?php echo $showcaseLink;?>',1);">
											  <?php echo getSubString($data->reviewTitle,50);?>
										  </div>
										    <div class="ml10 clr_444 ptr oh tar font_size12 font_opensansSBold" onclick="gotourl('<?php echo $href;?>',1);">
												  <?php echo getSubString(ucwords($data->reviewWriter),50);?>
											</div>
										  <div class="ml10 clr_444 height70 mt10 ptr" onclick="gotourl('<?php echo $href;?>',1);">
											  <?php echo changeToUrl(nl2br(limit_words($data->reviewDescription,25)));?>		
										  </div>
									 </div>
									  <div class="search_detail position_relative mt_minus5 ml10">
										<div class="cell shadow_wp strip_absolute left_154">
										  <img src="<?php echo base_url('images/small_seprator_shade.png');?>">
										</div>
										<div class="width147 Fleft pt18 pl20">
										  <div class="search_result_file_detail min_h100per">
											<span class="clr_444 font_size12 font_opensansSBold"><?php echo get_timestamp('d F Y',$data->reviewCreatedDate) ;?></span>
										  </div>
										</div>
										<div class="Fleft pl20 mt13">
										  <div class="searchpage_icon_set font_size11">
											<div class="cell mt5"> <span class="blogS_crave_btn min_w24">0</span> </div>
											<div class="cell pl13 mt5"> <span class="blogS_view_btn">0</span> </div>
											<div class="cell mt5 font_size11 ptr width96px"  onclick="gotourl('<?php echo $href;?>',1);"> <span class="search_arrow_right font_size12 font_opensansSBold"> <?php echo $this->lang->line('See_full_review');?></span> </div>
											<div class="clear"></div>
										  </div>
										</div>
										<div class="clear"></div>
									  </div>
									</div>
									<div class="clear"></div>
								  </div>
								  <div class="clear"></div>
								</div>
								<div class="clear"></div>
							</li>
						<?php
						}
					}
					
					if($countReview==0){
						echo "<li>".$this->lang->line('noRecord')."</li>";
					}
					?>
				</ul>
			
            </div>
                         
                         <div class="clear"></div>
                          </div>
	  </div>
      
      <div class="clear"></div>
	</div>
	<div class="seprator_20"></div>
					<div class="row font_opensans ml13 mr23"> <a class="cell pre_arrow clr_444 prev">Previous </a> <a class="cell Fright next_arrow clr_444 next" href="#">Next </a>
				<div class="clear"></div>
			</div>
				</div>




<div class="clear"></div>
<script type="text/javascript">
	$(document).ready(function(){
		//set slider
		$('#slider_review').tinycarousel({ axis: 'y',display: 3});	
		$('#slider_review_external').tinycarousel({ axis: 'y',display: 3});	
		
		
		
		// set first tab show
		$(".externalreview").hide();
		$(".memberreview").show();
		
		<?php if(isset($reviewList) && count($reviewList)==0  && empty($reviewList) ) { ?>
		
			$(".externalreview").show();
			$(".memberreview").hide();
		<?php } ?>
		
		// show and hide tab
		$(".CSEprise_nav_new li").click(function(){
			
			if($(this).attr('id')==1){
				$(".externalreview").hide();
				$(".memberreview").show();
			}else{
				$(".memberreview").hide();
				$(".externalreview").show();
			}
		});
	});
</script>
