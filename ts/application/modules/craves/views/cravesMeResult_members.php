<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$crave=htmlEntityDecode($crave);
?>
<a href="<?php echo $crave->link;?>" target="_blank" >
<div class="crave_result_list_wrapper <?php echo $craveBgClass;?> mb10 min-h78">
	<div class="crave_result_list_gradient ">
	  <div class="crave_result_img_box w336_h78 Fleft">
		<div class="AI_table">
		  <div class="AI_cell">
			  	<img class="max_w314_h193 bdr_bebebe" src="<?php echo $crave->craveImage;?>">
		   </div>
		</div>
	  </div>
	  <div class="Fleft width_405 bdr_L_C7C7C7">
		<div class="crave_title mt10 ml18 pb7 mr18 clr_white dash_link_hover">
		<?php
		if($crave->enterprise=='t'){
			$fullName=$crave->enterpriseName;
		}else{
			$fullName=$crave->firstName.' '.$crave->lastName;
		}
		echo getSubString($fullName,30);
		?></div>
		<div class="seprator_8"></div>
		
		<div class="crave_result_statusbar">
		<div class="crave_result_statusbar_shadow">
		<div class="cell mt1 ml20">
		<div class="searchpage_icon_set font_size11">
			  
			  <div class="clear"></div>
			</div>
		</div><div class="Fright mr5">
			<div class="crave_catagory mt5 ml18 mr5"><?php echo $this->lang->line('members');?></div>
		</div>
		
		
		<div class="clear"></div>
		</div>
		</div>
	  </div>
	  <div class="clear"></div>
	</div>
  </div>
</a>
