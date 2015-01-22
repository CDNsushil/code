<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="bdr_Bwhite seprator_1"></div>
<div class="Fleft width_165 height_16"></div>
<div class="Fleft width_610">
	<div class="seprator_29"></div>
	<div class="CSEprise_frame mr10">
	  <div class="bg_f7f6f4 global_shadow_light">
		  <div class="width_601 pb5 pt7 bg_light_gray">
			<?php 
			if($externalNews && is_array($externalNews) && count($externalNews)){
				foreach($externalNews as $data){
					//echo '<pre />';print_r($data);
					if(isset($data->associatedNewsElementId) && $data->associatedNewsElementId >0){
						$href=base_url(lang().'/mediafrontend/searchresult/'.$data->tdsUid.'/'.$data->projId.'/'.$data->associatedNewsElementId.'/news');
						$target='target="_blank"';
					}
					elseif(!empty($data->newsExternalUrl)){
						$externalUrl=$data->newsExternalUrl;
						if(strstr($externalUrl,'+')){
							$externalUrl=urldecode($externalUrl); 
						}
						$href=$externalUrl;
						$target='target="_blank"';
					}
					elseif(!empty($data->newsEmbed)){
						$Embed=$data->newsEmbed;
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
					
					if(empty($data->newsWriter)) {
						$userShowcase = showCaseUserDetails($data->tdsUid);
						$data->newsWriter = $userShowcase['userFullName'];
					}
					?>
					
					<div class="search_result_list_wrapper bg_SRFilm mb10 ml7 mr7 width_auto">
					  <div class="search_result_list_gradient">
						<div class="search_result_img_box w167_h167 Fleft ptr" <?php if($href!="#") { ?> onclick="gotourl('<?php echo $href;?>',1);" <?php } ?> >
						  <div class="AI_table">
							<div class="AI_cell"> <img src="<?php echo base_url('images/default_thumb/news_s.jpg');?>" class="max_w165_h165 bdr_whiteAll"></div>
						  </div>
						</div>
						<div class="Fleft width_356 ">
						  <div class="pr">
						  <div class="search_title ml24 mt5 bdr_Borange_D pb3 clr_444 ptr mH20" onclick="gotourl('<?php echo $showcaseLink;?>',1);">
							  <?php echo getSubString($data->newsWriter,50);?>
						  </div>
						  <div class="ml24 clr_444 ptr oh" <?php if($href!="#") { ?> onclick="gotourl('<?php echo $href;?>',1);" <?php } ?> >
							  <?php  //$newsDescriptionShow=  changeToUrl(nl2br(getSubString(string_replace($data->newsDescription),220)));
								    // echo  string_decode($newsDescriptionShow);
							  ?>
							   <?php echo getSubString($data->newsTitle,100);?>
						  </div>
						   <div class="ml24 mt8 clr_444 height_75 ptr oh" <?php if($href!="#") { ?> onclick="gotourl('<?php echo $href;?>',1);" <?php } ?> >
							  <?php  $newsDescriptionShow=  changeToUrl(nl2br(getSubString(string_replace($data->newsDescription),200)));
								     echo  string_decode($newsDescriptionShow);
							  ?>
						  </div>
						   <div class="clear"></div>
						  <div class="pa orange right_0 bottom_0 font_size11 fr ptr bg_white pl10" <?php if($href!="#") { ?> onclick="gotourl('<?php echo $href;?>',1);" <?php } ?> >
							 <?php echo $this->lang->line('read');?>
						  </div>
						  </div>
						  <div class="search_detail position_relative mt_minus5 ml10">
							<div class="cell shadow_wp strip_absolute left_154">
							  <img src="<?php echo base_url('images/small_seprator_shade.png'); ?>">
							</div>
							<div class="width147 Fleft pt15 pl20">
							  <ul class="search_result_file_detail min_h100per">
								<li class="clr_444"><?php echo get_timestamp('d F Y',$data->newsCreatedDate) ;?></li>
							  </ul>
							</div>
							<div class="Fleft pl20 mt8">
							  <div class="searchpage_icon_set font_size11">
								<div class="cell mt5"> <span class="blogS_crave_btn min_w24">0</span> </div>
								<div class="cell pl13 mt5"> <span class="blogS_view_btn">0</span> </div>
								<div class="clear"></div>
							  </div>
							</div>
							<div class="clear"></div>
						  </div>
						</div>
						<div class="clear"></div>
					  </div>
					</div>
				
				<?php
				}
				
			}else{
				//echo $this->lang->line('noRecord');
			}
			?>
		  </div>
	  </div>
	</div>
	<div class="seprator_20"></div>
		<?php 
		if(count($externalNews) > 3){
			?>
			<div class="row font_opensans ml13 mr23"> <a class="cell pre_arrow clr_444">Previous </a> <a class="cell Fright next_arrow clr_444" href="#">Next </a>
				<div class="clear"></div>
			</div>
			<?php 
		}?>
	</div>
<div class="clear"></div>
