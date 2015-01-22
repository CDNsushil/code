<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if(!$isVideoData){
		//echo $this->lang->line('noRecord');
	}else{ ?>
		<div class="popup_box width_729 height_386 mt15 ml13 pa">
			<div class="bg_222222 bdr_whiteAll height_386"> 
				<div class="mt25 ml34 iframe_container"> <?php echo $videoFile;?></div>
			</div>
		</div> <!-- /video bg -->


		<div class="bdr_Bwhite seprator_1"></div>
		<div class="Fleft width_165 height_16"></div>

		<div class="Fleft width_610">
			<div class="seprator_29"></div>
			<div class="CSEprise_frame mr10">
				<div class="bg_f7f6f4 global_shadow_light ">
					<div class="p15 pb25 min_h558">
						<div class="height_365"></div>
						<div class="clr_444">
							<p class="font_size18 pt25 font_OpenSansBold bdr_Borange_D pb15"><?php echo $videoTitle;?></p> 
							<p class="mt12 font_size13"><?php echo changeToUrl($videoDescription);?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="seprator_15"></div>
		</div>
		<?php
	}
?>
<div class="clear"></div>

        
   
      
