<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	
	
 <div class="bg_f3f3f3 cerative_title clearbox">
                  <h1 class="opens_light fs30 fl">Buyers’ Comments</h1>
                  <div class="head_list fr pt27 pr25">
<!--        <div class="icon_view3_blog fs11 icon_so"><?php //echo $viewCount;?></div>
        <div class="icon_crave4_blog fs11 icon_so"><?php //echo $craveCount;?></div>
        <div class="rating fl pr3 pt6"> <img class="max_w29" alt="" src="<?php //echo ratingImagePath($ratingAvg);?>" /> </div>
        <div class="btn_share_icon fs11 icon_so"><?php //echo $reviewCount;?></div>
 --> 
      </div>
   </div>
	
	<div class="seprator_7"></div>
	
    <div class=" clearbox buyer_commentwrap ">
                  <div class="sap_55"></div>
                  <div class="wid920 pr30 pl50" id="showbuyercomments">
	
					<?php $this->load->view('buyer_comment_container'); ?>
				
				
	</div>   
				<div class="sap_30"></div>
  </div>   

	<div class="clear seprator_14"></div>
