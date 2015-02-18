<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
	<div id="auctionBidFormDiv" class="width_566">
        <div class="row">
			<div class="cell join_heading ml18 mr2 pt10 width_157 text_alignR"><?php echo ""; ?></div>
			<div class="cell font_opensans font_size18 pt20 bdr_Borange height_16 width_366">
				<div class="clr_666 pl20"><?php echo $projectTitle; ?></div>
			</div>
			<div id="next_steps"></div>
            <div class="clear"></div>
		</div>
		<div class="seprator_10"></div>
		<!--Display bid listing of users-->
		<div id="showBidList">
			<?php echo $this->load->view("auction/bidPagingView");?>
		</div>
		<div class="seprator_15 clear"></div>  
    </div>
</div>
