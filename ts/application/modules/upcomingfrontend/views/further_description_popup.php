<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $cravedALL = (@$craveCount>0)?'frontCravedALL':'';?>
<div class="cream_gradient width_776">
      <!--top_title-->
      <div class="row mr57 ml57 pt25">
        <div class="cell up_popup_title width_422"><?php echo getSubString($upcomingRecord['projTitle'],40);?></div>
        <div class="cell Fright mt5">
          <div class="icon_view5_blog cell pl26 mr24"><?php echo $this->lang->line('project_views').' '.@$viewCount;?></div>
          <div class="icon_crave4_blog icon_uncrave cell pl26 <?php echo $cravedALL;?>"><?php echo $this->lang->line('cravesLabel').' '.@$craveCount;?></div>
          <div class="cell ml10 mt6">
           <img  src="<?php echo base_url($ratingImg);?>" />
          </div>
          <div class="clear"></div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="seprator_30"></div>
      <!--text box-->
      <div class="trans_bdr_box ml52 mr52">
        <div class="bg_white pt25 pl20 pr20 pb25 font_opensans">
          <p><?php echo $upcomingRecord['proShortDesc'];?></p>
        </div>
      </div>
      <div class="seprator_52"></div>
    </div>

