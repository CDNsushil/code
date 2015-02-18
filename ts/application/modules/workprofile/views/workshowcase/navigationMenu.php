<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
$location2 = $this->uri->segment(2);
$location3 = $this->uri->segment(3);

if($location2 =='workprofile' || $location3 =='index' || $location3 ==''){
?>
	<div class="row  line1 mr10 width_435"></div>
<div class="row mr10 pb3 width405px">	
<div class="cell ml200 mr-3 pr mt-20">
	<a href="<?php echo base_url(lang().'/workprofile/workshowcase');?>">
		<div class="wp_orange_eventcircle font_opensansSBold font_size12 clr_white fl mr10">
			<div class="portfolio_index_icon mt5 ml22"></div>
			<div class="font_opensansSBold font_size13 text_alignC mt-5"><?php echo $this->lang->line('portfolioIndex');?></div>
		</div> 
	</a>
	</div>	
<div class="cell mr-3 pr mt-20">
	<a href="<?php echo base_url(lang().'/workprofile/workprofile');?>">
		<div class="wp_black_eventcircle font_opensansSBold font_size12 clr_white fl mr10 wp_orange_circle_hover">
			<div class="profile_index_icon mt5 ml28"></div>
			 <div class="font_opensansSBold font_size13 text_alignC mt-5 ml-5"><?php echo $this->lang->line('profileIndex');?></div>
		</div> 
	</a>
	</div>
	
</div>	
	
		
<!--<div class="cell mt5 ml12">
		
<div class="tds-button-big">
	<?php //echo anchor('workprofile/workprofile','<span>'.$this->lang->line('workProfile').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>

</div>
	
</div>
<div class="row line1 mr10"></div>-->
<div class="seprator_5 cell"></div>
<?php } ?>
