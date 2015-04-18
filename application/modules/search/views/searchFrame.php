<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//$search=htmlEntityDecode($search);
?>
<a class="search_result_list_wrapper ml16 mb10 <?php echo $searchBgClass;?> display_block" href="<?php echo $search->link;?>" target="_blank" >
	<div class="search_result_list_gradient">
	  <div class="search_result_img_box w167_h169 Fleft">
		<div class="AI_table"> 
		  <div class="AI_cell">
			  <img class="max_w145_h145 bdr_whiteAll" src="<?php echo $search->searchImage;?>" />
		  </div>
		</div>
	  </div>
	  <div class="Fleft">
		<div class="search_title pl10 mt5 dash_link_hover"><?php echo getSubString($search->title,30);?></div>
		<div class="search_detail position_relative">
		  <div class="cell shadow_wp strip_absolute left_154">
			<!-- <img src="images/strip_blog.png"  border="0"/>-->
			<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
			  <tbody>
				<tr>
				  <td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
				</tr>
				<tr>
				  <td class="shadow_mid_small">&nbsp;</td>
				</tr>
				<tr>
				  <td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
				</tr>
			  </tbody>
			</table>
			<div class="clear"></div>
		  </div>
		  <div class="width150px Fleft pl12 ">
			<ul class="search_result_file_detail mt5">
				<?php if($search->industry && $search->industry != ''){?>
					<li><?php echo getSubString($search->industry,20);?></li>
					<?php
				}?>
				<?php if($search->sell_option && $search->sell_option != ''){?>
					<li><?php echo getSubString($search->sell_option,15);?></li>
					<?php
				}?>
				
				<?php if($search->genre && $search->genre != ''){?>
				  <li><?php echo ucwords(getSubString($search->genre,15));?></li>
					<?php
				}?>
				<?php if($search->length && $search->length != ''){
					/*?>
					<li><?php echo $search->length;?></li>
					<?php*/
				}?>
				<?php if($search->wordCount && $search->wordCount > 0){
					
					/*?>
					<li><?php echo $search->wordCount;?></li>
					<?php
					* */
				}?>

				<?php if($search->creation_date && $search->creation_date != ''){
					if($search->entityid==9 || $search->entityid==15 ){
						$dateFormate='d F Y';
					}else{
						$dateFormate='F Y';
					}
					?>
					<li>
						<?php echo get_timestamp($dateFormate,$search->creation_date);
						if($search->event_end_date && $search->event_end_date != '' && ($search->creation_date!=$search->event_end_date) && ($search->entityid==9 || $search->entityid==15 )){
							echo ' - <br/>';
							echo get_timestamp('d F Y',$search->event_end_date);
						}
						?>
					</li>
					<?php
				}?>
				
						

				<?php if($search->language && $search->language != ''){?>
					<li><?php echo getSubString($search->language,15);?></li>
					<?php
				}?>
				<?php if($search->country && $search->country != ''){?>
					<li><?php echo getSubString($search->country,15);?></li>
					<?php
				}?>
				<?php if($search->city && $search->city != ''){?>
					<li><?php echo getSubString($search->city,15);?></li>
					<?php
				}?>
			</ul>
			
			<div class="mr5">
					<div class="search_Subcatagory pb2"><?php if(isset($search->type) && $search->type != '') echo ucwords(getSubString($search->type,25)); else echo '&nbsp;';?></div>
                    <div class="search_catagory pt2"><?php echo $this->lang->line($search->section);?></div>
            </div>
			</div>
		  <div class="Fleft width_200 pl20 overflowHid">
			<?php 
			
			$userInfo =showCaseUserDetails($search->userid);
			if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
				$search->creative_name= $userInfo['enterpriseName'];
			}
			if($search->title != $search->creative_name){
				$desLength=100;
				$desHeight='h54px';
				
				
				?>
				<div class="search_postby pt3"><?php if(isset($search->creative_name)) echo getSubString($search->creative_name,25);?></div>
				<?php 
			}
			else{
				$desLength=135;
				$desHeight='height75';
			} ?>
			<div class="seprator_15 "></div>
			<div class="<?php echo $desHeight;?>"> <?php  if(isset($search->online_desctiption)) echo getSubString($search->online_desctiption,$desLength); ?> </div>
			<div class="seprator_18"></div>
			<div class="searchpage_icon_set font_size11">
			  <div class="cell">
				<div class="icon_post3_blog lineH27 height_27"> <?php echo $search->reviewCount>0?$search->reviewCount:0;?></div>
			  </div>
			  <div class="cell pl13 mt5">
				<span class="blogS_view_btn"><?php echo $search->viewCount>0?$search->viewCount:0;?></span>
			  </div>
			  <div class="cell mt5">
				<span class="blogS_crave_btn min_w24 <?php echo $search->craveFClass?>"><?php echo $search->craveCount>0?$search->craveCount:0;?></span>
			  </div>
			  <div class="cell width_auto mt10">
				<img  src="<?php echo base_url($search->ratingImg);?>" />
			  </div>
			  <div class="clear"></div>
			</div>
		  </div>
		  <div class="clear"></div>
		</div>
	  </div>
	  <div class="clear"></div>
	</div>
 </a>
