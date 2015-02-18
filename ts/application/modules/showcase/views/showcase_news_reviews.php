<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $reviewList= Modules::run("mediafrontend/getReviewList",54,2,'','',true); 
?>

<div class="bdr_Bwhite seprator_1"></div>
<div class="Fleft width_165 white_horLine height_695"></div>
<div class="Fleft width_610">
<div class="seprator_29"></div>
<div class="CSEprise_frame mr10">
  <div class="bg_f7f6f4 global_shadow_light">
	<div class="min_h580">
	  <div class="width_601 pb5 pt7 bg_light_gray">
		<?php 
		if($reviewList && is_array($reviewList) && count($reviewList)){
			foreach($reviewList as $review){?>
				<div class="search_result_list_wrapper bg_SRFilm mb10 ml7 mr7 width_auto ">
				  <div class="search_result_list_gradient">
					<div class="search_result_img_box w167_h167 Fleft">
					  <div class="AI_table">
						<div class="AI_cell"> <img src="images/temp_img26.jpg" class="max_w165_h165 bdr_whiteAll"></div>
					  </div>
					</div>
					<div class="Fleft width_356 ">
					  <div class="search_title ml24 mt5 bdr_Borange_D pb3 clr_444">Reinhardt Michael Michael</div>
					  <div class="ml24 mt8 clr_444">This is the one line description going here and Jane says a few more words to go on and.This is the one line description going here and Jane says a few more words to go on and This is the one line description going here and Jane says a few more words to go on and on again.<a href="#" class="Fright orange_color font_size11 pt2"><?php echo $this->lang->line('read');?> <img src="images/tag_arrow.png" class="inline pl5" /></a></div>
					  <div class="search_detail position_relative mt_minus5 ml10">
						<div class="cell shadow_wp strip_absolute left_154">
						  <img src="images/small_seprator_shade.png">
						</div>
						<div class="width147 Fleft pt18 pl20">
						  <ul class="search_result_file_detail min_h100per">
							<li class="clr_444">20 July 2011</li>
						  </ul>
						</div>
						<div class="Fleft pl20 mt8">
						  <div class="searchpage_icon_set font_size11">
							<div class="cell mt5"> <span class="blogS_crave_btn min_w24">12</span> </div>
							<div class="cell pl13 mt5"> <span class="blogS_view_btn">172</span> </div>
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
</div>
<div class="seprator_20"></div>
<div class="row font_opensans ml13 mr23"> <a class="cell pre_arrow clr_444">Previous </a> <a class="cell Fright next_arrow clr_444" href="#">Next </a>
  <div class="clear"></div>
</div>
</div>
<div class="clear"></div>
