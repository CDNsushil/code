<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$crave=htmlEntityDecode($crave);
?>
<a href="<?php echo $crave->link;?>" target="_blank" >
<div class="crave_result_list_wrapper <?php echo $craveBgClass;?> mb10">
	<div class="crave_result_list_gradient ">
	  <div class="crave_result_img_box w336_h215 Fleft">
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
		<div class="crave_detail position_relative clr_white">
		  <div class="cell shadow_wp strip_absolute left_251">
			<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
			  <tbody>
				<tr>
				  <td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
				</tr>
				<tr>
				  <td class="shadow_mid_small"></td>
				</tr>
				<tr>
				  <td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
				</tr>
			  </tbody>
			</table>
			<div class="clear"></div>
		  </div>
		  
		  <div class="Fleft width_225 pl20 mt10 overflowHid"><?php 
			$desLength=100;
				$desHeight='height75';
			?>
			
			<div class="seprator_13"></div>
			<div class="font_size13"><?php echo getSubString($crave->online_desctiption,135);?></div>
			<div class="seprator_18"></div>
			
		  </div>
		  <div class="width135px Fright pr10 mt10">
			<ul class="crave_result_file_detail mt3 ml15">
			  <?php 
				if($crave->creative_area != ''){?>
					<li><?php echo getSubString($crave->creative_area,15);?></li>
					<?php
				} if($crave->language != ''){?>
					<li><?php echo getSubString($crave->language,15);?></li>
					<?php
				} if($crave->country != ''){?>
					<li><?php echo getSubString($crave->country,15);?></li>
					<?php
				} if($crave->city != ''){?>
					<li><?php echo getSubString($crave->city,15);?></li>
					<?php
				}?>
			</ul>
			<div class="crave_result_subcat ml13 tac"><?php if(isset($crave->industry)) echo getSubString($crave->industry,25);?></div>
		  </div>
		  <div class="clear"></div>
		</div>
		<div class="crave_result_statusbar">
		<div class="crave_result_statusbar_shadow">
		<div class="cell mt1 ml20">
		<div class="searchpage_icon_set font_size11">
			  <div class="cell">
				<div class="icon_post3_blog lineH27 height_27"> <?php echo $crave->reviewCount;?></div>
			  </div>
			  <div class="cell pl13 mt5">
				<span class="blogS_view_btn"><?php echo $crave->viewCount;?></span>
			  </div>
			  <div class="cell mt5">
				<span class="blogS_crave_btn min_w24 <?php echo $crave->craveFClass?>"><?php echo $crave->craveCount;?></span>
			  </div>
			  <div class="cell width_auto mt10">
				<!-- news popup-->
				<img  src="<?php echo base_url($crave->ratingImg);?>" />
			  </div>
			  <div class="clear"></div>
			</div>
		</div><div class="Fright mr5">
			<div class="crave_catagory mt5 ml18 mr5"><?php echo $this->lang->line($crave->section);?></div>
		</div>
		
		
		<div class="clear"></div>
		</div>
		</div>
	  </div>
	  <div class="clear"></div>
	</div>
  </div>
</a>
