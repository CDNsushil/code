<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$userInfo =showCaseUserDetails($sp->userid);
if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
	$sp->creative_name= $userInfo['enterpriseName'];
}?>
<a href="<?php echo $sp->link;?>" target="_blank" >
<div class="crave_result_list_wrapper <?php echo $spBgClass;?> mb10">
	<div class="crave_result_list_gradient ">
	  <div class="crave_result_img_box w336_h215 Fleft">
		<div class="AI_table">
		  <div class="AI_cell">
			  	<img class="max_w314_h193 bdr_bebebe" src="<?php echo $sp->spImage;?>">
		   </div>
		</div>
	  </div>
	  <div class="Fleft width_405 bdr_L_C7C7C7">
		<div class="crave_title mt10 ml18 pb7 mr18 clr_white dash_link_hover"><?php echo getSubString($sp->title,30);?></div>
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
		  
		  <div class="Fleft width_225 pl20 mt10 overflowHid">
			<?php if(!($sp->title == $sp->creative_name || $sp->sectionid == $this->config->item('enterprisesSectionId'))){
				$desLength=135;
				$desHeight='h54px';
			?>
			<div class="crave_postby pt3"><?php if(isset($sp->creative_name)) echo getSubString($sp->creative_name,25);?></div>
			<?php
			}
			else{
				$desLength=135;
				$desHeight='height75';
			} ?>
			
			<div class="seprator_13"></div>
			<div class="font_size13"><?php echo getSubString($sp->online_desctiption,$desLength);?></div>
			<div class="seprator_18"></div>
		  </div>
		  <div class="width_120 Fright pr10 mt10">
			<ul class="crave_result_file_detail mt3">
			  <?php 
				if($sp->creative_area != ''){?>
					<li><?php echo getSubString($sp->creative_area,15);?></li>
					<?php
				} if($sp->element_type != ''){?>
					<li><?php echo getSubString($sp->element_type,15);?></li>
					<?php
				} if($sp->projectCategory != ''){?>
					<li><?php echo getSubString($sp->projectCategory,15);?></li>
					<?php
				} if($sp->genreString != ''){?>
					<li><?php echo ucwords(getSubString($sp->genreString,15));?></li>
					<?php
				} if($sp->length != ''){
					/*?>
					<li><?php echo $sp->length;?></li>
					<?php */
				} if($sp->wordCount != ''){
					/*?>
					<li><?php echo $sp->wordCount;?></li>
					<?php */
				} if($sp->creation_date != ''){?>
					<li><?php echo get_timestamp('F Y',$sp->creation_date);?></li>
					<?php
				} if($sp->language != ''){?>
					<li><?php echo getSubString($sp->language,15);?></li>
					<?php
				} if($sp->country != ''){?>
					<li><?php echo getSubString($sp->country,15);?></li>
					<?php
				} if($sp->city != ''){?>
					<li><?php echo getSubString($sp->city,15);?></li>
					<?php
				}?>
			</ul>
			<div class="crave_result_subcat ml13"><?php if(isset($sp->projectTypeName)) echo getSubString($sp->projectTypeName,25);?></div>
		  </div>
		  <div class="clear"></div>
		</div>
		<div class="crave_result_statusbar">
		<div class="crave_result_statusbar_shadow">
		<div class="cell mt1 ml20">
		<div class="searchpage_icon_set font_size11">
			  <div class="cell">
				<div class="icon_post3_blog lineH27 height_27"> <?php echo $sp->reviewCount;?></div>
			  </div>
			  <div class="cell pl13 mt5">
				<span class="blogS_view_btn"><?php echo $sp->viewCount;?></span>
			  </div>
			  <div class="cell mt5">
				<span class="blogS_crave_btn min_w24 <?php echo $sp->spFClass?>"><?php echo $sp->craveCount;?></span>
			  </div>
			  <div class="cell width_auto mt10">
				<!-- news popup-->
				<img  src="<?php echo base_url($sp->ratingImg);?>" />
			  </div>
			  <div class="clear"></div>
			</div>
		</div><div class="Fright mr5">
			<div class="crave_catagory mt5 ml18 mr5"><?php echo $this->lang->line($sp->section);?></div>
		</div>
		<div class="clear"></div>
		</div>
		</div>
	  </div>
	  <div class="clear"></div>
	</div>
  </div>
</a>
