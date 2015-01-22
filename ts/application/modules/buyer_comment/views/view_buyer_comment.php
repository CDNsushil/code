<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<td valign="top" class="rc_black">
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?> 
	<div class="CSEprise_TopBox mr9 ml9 mt3 <?php echo $headerClass;?> clr_bababa">
	  <div class="CSEprise_pattern">
		<div class="CSEprise_cat_box">
		  <div class="CSEprise_Subcat Fright mr14"><?php  echo $this->lang->line('english'); ?></div>
		  <div class="<?php echo $headingClass;?>"><?php echo $industryType; ?></div>
		  <div class="clear"></div>
		</div>
		<div class="CSEprise_heading bdr_Borange height_33 ml30 mr14">
		  <h1 class="Fleft clr_white"><?php echo $enterPriseName;?></h1>
		  <div class="Fright font_OpenSansBold pt12 font_size13 "><?php echo $cityName; ?></div>
		  <div class="clear"></div>
		</div>
		<div class="row pb13">
		  <div class="width_545 cell font_opensans font_size18 text_alignC pt10 clr_f6f7f2">
			  <?php 
			  echo $userArea;
			  ?>
		  </div>
		  <div class="Fright font_opensansSBold mr14 font_size13"><?php echo $countryName;?></div>
		  <div class="clear"></div>
		</div>
	  </div>
	  <div class="bdr_c2c3bf seprator_1"></div>
	</div>
	
	<div class="seprator_7"></div>
	
	<div id="showInbox">
	
		<?php $this->load->view('buyer_comment_container'); ?>
   
     </div>   

	<div class="clear seprator_14"></div>
</td>
