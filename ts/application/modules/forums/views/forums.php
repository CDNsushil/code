	
	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	/**	*	* Forums View 	*	**/	?>	<div class="pb0">            <div class="row bdr_c1c1c1 pb5 ml10 mr10">                <div class="cell font_museoSlab font_size22 clr_f1592a lineH27 mt18" ><?php                 if($getCatSubCat['parentID']!=0)                {					echo $this->categories_m->get_current_cat($getCatSubCat['parentID']);                 }else                {					if($this->categories_m->get_current_cat($getCatSubCat['CategoryID'])!="")					{						echo $this->categories_m->get_current_cat($getCatSubCat['CategoryID']);					}else					{						echo $category;					}					}?></div>								<!---------add new disscussion start button------>								<?php					if($this->uri->segment(4))					{						$catego_id= $this->uri->segment(4);					}else					{						$catego_id = 0;					}									if(isLoginUser()) {										if($this->uri->segment(2)=="forums")					{						//echo '<div id="newTopicButton"><div class="content"><img src="'.base_url().'templates/assets/images/discussion_icon.png" /><a href="'.site_url().'/forums/new_topic">'.$this->lang->line('addNewDiscussion').'</a></div></div>'; 						echo '<div class="tds-button fr mt12"><a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)"  href="'.site_url().'forums/new_topic/'.$catego_id.'" style="background-position: 0px -38px;" ><span style="background-position: right -38px;">'.$this->lang->line('addNewDiscussion').'</span></a></div>';										}				 }else				 {?>					<div  onclick="openLightBox('popupBoxWp','popup_box','/auth/login','You must be logged in to comment.')"  class="tds-button fr mt12"><a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)"  style="background-position: 0px -38px;" ><span style="background-position: right -38px;"><?php echo $this->lang->line('addNewDiscussion'); ?></span></a></div>				<?php  } ?>				                <div class="fr mt12"> <a href="<?php echo site_url(); ?>forums/update_order/asc"  ><div class="forum_btnup fl"></div></a> <a href="<?php echo site_url(); ?>forums/update_order/desc" ><div class="forum_btndown fl"></div></a></div>                 <div class="clear"></div>                 </div>                                                </div>             <div class="font_opensansSBold font_size14 clr_444 pl68 mt2 mb5"> <?php             if($getCatSubCat['parentID']!=0)                {					echo $this->categories_m->get_current_cat($getCatSubCat['CategoryID']);				}else				{					echo "&nbsp;";				} ?>            </div>   		<!--removed class="edit_post_wp" to adjust the overall width of container. date: 13 feb 2013-->	<div >				<div class="page_list">						<ul class="topics">								<!---<div class="general">					<div class="general_inner_border">						<strong>Order:</strong>&nbsp;&nbsp<?php //echo anchor('help/update_order/asc', $this->lang->line('discussionsAscending'), 'title="'.$this->lang->line('discussionsSortAscending').'"'); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php //echo anchor('help/update_order/desc', $this->lang->line('discussionsDescending'), 'title="'.$this->lang->line('discussionsSortDescending').'"'); ?>					</div>				</div>---->																				<?php					$counter = 1;					if (!$topics) 					{						echo '<p ><a class="orange_color"  href="'.site_url().'forums/new_topic/'.$catego_id.'" >'.$this->lang->line('noDiscussions').'</a></p>';					} 					else					{										foreach($topics as $row)					{																								$UserAuth		=	$this->db->dbprefix('UserAuth');						$UserProfile	=	$this->db->dbprefix('UserProfile');						$res	=	getDataFromMixTabel('"'.$UserAuth.'" ua, "'.$UserProfile.'" up', $field='"ua"."tdsUid","up"."firstName","up"."lastName"','WHERE "ua"."username"=\''.$row['LastPost'].'\' AND "up"."tdsUid"="ua"."tdsUid"', 'limit 1');												$postedBy	=	'';						if($res){							$postedBy=getEnterpriseName($res[0]->tdsUid);						}						if($row['Sticky'] == '1') 						{							$sticky = $this->lang->line('discussionsSticky');						} 						else 						{							$sticky = '';						}						if($row['Closed'] == '1') 						{							$closed = $this->lang->line('discussionsClosed');						} 						else 						{							$closed = '';						}												$counter++;						$posts 		= $this->posts_m->get_latest_5_posts($row['TopicID']);						$userImage	=	userProfileImage();						$userImage  = 	getImage($userImage,'user');						$getFirstPost = $this->posts_m->getFirstPost($row['TopicID']);						$getLastPost = $this->posts_m->getLastPost($row['TopicID']);					?>			<div class="row">								<diV class="pr">				<a href="<?php echo base_url().'forums/posts/'.$row['CategoryID'].'/'.$row['TopicID']; ?>">								<div class="pll bdr_cecece minH140 forumbox_sheadow">										<div class="row bdrB_f4a78d ml10 mr10 mt5 pb5">						<div class="fl font_opensans font_size16 clr_222 mt5 width_445 dash_link_hover"><?php //echo $sticky.''.$closed.' '.anchor('forums/posts/'.$row['CategoryID'].'/'.$row['TopicID'].'', ''.word_limiter(ucfirst($row['TopicName']), '5').'', 'title="'.$row['TopicName'].'"'); 						echo word_limiter(ucfirst($row['TopicName']), '5');?></div>						<div class="fr height_21 bg_f1592a font_opensansSBold font_size16 clr_white pl5 pr5 pt5 pt5 lineH13"><?php echo $this->posts_m->count_posts($row['TopicID']);?></div>						<div class="clear"></div>					</div>												<div class="row font_arial font_size13 clr_333 pl10 pr10 pt18 pb25">					   <?php echo changeToUrl($getLastPost->Body); ?>					   <div class="clear"></div>						</div>																								<div class="row height_26 gradient_commentB bdrT_e2e2e2 ml1 mr1 mb1 font_opensansSBold font_size12 clr_555">						<div class="fl ml10 mt3">First Comment<span class="clr_f1592a display_inline ml4 f11"> <?php 												if($this->timeword->convert($getFirstPost->PostTime, time()) == "less than 5 seconds" || $this->timeword->convert($getFirstPost->PostTime, time()) == "less than 10 seconds" || 						$this->timeword->convert($getFirstPost->PostTime, time()) == "less than 20 seconds" || $this->timeword->convert($getFirstPost->PostTime, time()) == "less than a minute")						{						    echo $this->lang->line('JustNow');						}else						{							$getTimeShowFirst = $this->timeword->convert($getFirstPost->PostTime, time());							echo $getTimeShowFirst.' ago';							/*$TimeShow = explode(" ",$getTimeShowFirst);							if(isset($TimeShow[2]))							{								if($TimeShow[2]=='days'){ echo ' ago';};							}*/						}						?></span></div>						<div class="fr  mt3 ml6 word-wrap chagne_align"><?php echo substr($postedBy, 0, 12); 						                                                    if(strlen($postedBy)>12) {echo '..'; }?>&nbsp;</div>							<div class="fr mt3">Last Comment  <span class="clr_f1592a display_inline ml4 f11"><?php 						if($this->timeword->convert($row['LastPostTime'], time()) == "less than 5 seconds" || $this->timeword->convert($row['LastPostTime'], time()) == "less than 10 seconds" || 						$this->timeword->convert($row['LastPostTime'], time()) == "less than 20 seconds" || $this->timeword->convert($row['LastPostTime'], time()) == "less than a minute")						{						    echo $this->lang->line('JustNow');						}else						{							$getTimeShowSecond =  $this->timeword->convert($row['LastPostTime'], time());							echo $getTimeShowSecond.' ago';							/*$TimeShowSecond = explode(" ",$getTimeShowSecond);														if(isset($TimeShowSecond[2]))							{								if($TimeShowSecond[2]=='days'){ echo ' ago';};							}*/						}						?></span> </div>																							</div>					</div>				</a>								<!--------edit and delete topic------->						<div class="post_icons mt1">				<?php 					if($this->ion_auth->is_admin())					{						//echo ''.anchor('help/edit_topic/'.$userId.'/'.$row['TopicID'].'', '<img src="'.base_url().'templates/assets/images/edit_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsEditTitle').'" />').'';						echo '<div class="small_btn mr5 fl">									<a onmousedown="mousedown_small_button(this)" onmouseup="mouseup_small_button(this)" href="'.site_url().'forums/edit_topic/'.$userId.'/'.$row['TopicID'].'" title="'.$this->lang->line('discussionsEditTitle').'" class="formTip">										<span><div class="cat_smll_edit_icon"></div></span>									</a>								</div>';						echo '<div class="small_btn mr5 fl">									<a onmousedown="mousedown_small_button(this)" onmouseup="mouseup_small_button(this)" href="'.site_url().'forums/delete_topic/'.$row['TopicID'].'" title="'.$this->lang->line('discussionsDeleteTitle').'" onClick="return confirm(\'Are you sure you want to delete?\')" class="formTip">										<span><div class="cat_smll_plus_icon"></div></span>									</a>								</div>';								//echo ''.anchor('help/delete_topic/'.$row['TopicID'].'', '<img src="'.base_url().'templates/assets/images/delete_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsDeleteTitle').'" onClick="return confirm(\'Are you sure you want to delete?\')" />').'&nbsp;&nbsp;&nbsp;&nbsp;';											}					elseif($this->ion_auth->logged_in())					{						if($this->ion_auth->is_group('members'))						{                    							// Did the user create the topic ?							if($row['CreatedBy'] == $this->session->userdata('username'))							{								if($editOwnDiscussions == '1')								{																echo '<div class="small_btn mr5 fl">									<a onmousedown="mousedown_small_button(this)" onmouseup="mouseup_small_button(this)" href="'.site_url().'forums/edit_topic/'.$userId.'/'.$row['TopicID'].'" title="'.$this->lang->line('discussionsEditTitle').'" class="formTip">										<span><div class="cat_smll_edit_icon"></div></span>									</a>								</div>';									//echo ''.anchor('help/edit_topic/'.$userId.'/'.$row['TopicID'].'', '<img src="'.base_url().'templates/assets/images/edit_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsEditTitle').'" />').'';								}								if($deleteOwnDiscussions == '1')								{								echo '<div class="small_btn mr5 fl">									<a onmousedown="mousedown_small_button(this)" onmouseup="mouseup_small_button(this)" href="'.site_url().'forums/delete_topic/'.$row['TopicID'].'" title="'.$this->lang->line('discussionsDeleteTitle').'" onClick="return confirm(\'Are you sure you want to delete?\')" class="formTip">										<span><div class="cat_smll_plus_icon"></div></span>									</a>								</div>';									//echo ''.anchor('help/delete_topic/'.$row['TopicID'].'', '<img src="'.base_url().'templates/assets/images/delete_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsDeleteTitle').'" onClick="return confirm(\'Are you sure you want to delete?\')" />').'&nbsp;&nbsp;&nbsp;&nbsp;';								}															}						}						if($this->ion_auth->is_group('moderators'))						{							if($modsEditDiscussions == '1')							{								echo '<div class="small_btn mr5 fl">									<a onmousedown="mousedown_small_button(this)" onmouseup="mouseup_small_button(this)" href="'.site_url().'forums/edit_topic/'.$userId.'/'.$row['TopicID'].'" title="'.$this->lang->line('discussionsEditTitle').'" class="formTip">										<span><div class="cat_smll_edit_icon"></div></span>									</a>								</div>';								//echo ''.anchor('help/edit_topic/'.$row['TopicID'].'', '<img src="'.base_url().'templates/assets/images/edit_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsEditTitle').'" />').'';    							}							if($modsDeleteDiscussions == '1')							{								//echo ''.anchor('help/delete_topic/'.$row['TopicID'].'', '<img src="'.base_url().'templates/assets/images/delete_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsDeleteTitle').'" onClick="return confirm(\'Are you sure you want to delete?\')" />').'&nbsp;&nbsp;&nbsp;&nbsp;';    								echo '<div class="small_btn mr5 fl">									<a onmousedown="mousedown_small_button(this)" onmouseup="mouseup_small_button(this)" href="'.site_url().'forums/delete_topic/'.$row['TopicID'].'" title="'.$this->lang->line('discussionsDeleteTitle').'" onClick="return confirm(\'Are you sure you want to delete?\')" class="formTip">										<span><div class="cat_smll_plus_icon"></div></span>									</a>								</div>';							}													}					}?>					</div>															</diV>					<div class="seprator_10"></div>				            </div>                    	<?php         				}		}	?>			</ul>		</div>	</div>				
	<!-- <div style="padding-left:144px;"> -->



<!--/* OpenX Javascript Tag v2.8.9 */-->

<!--/*
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  * to
  *
  * This noscript section of this tag only shows image banners. There
  * is no width or height in these banners, so if you want these tags to
  * allocate space for the ad before it shows, you will need to add this
  * information to the <img> tag.
  *
  * If you do not want to deal with the intricities of the noscript
  * section, delete the tag (from <noscript>... to </noscript>). On
  * average, the noscript tag is called from less than 1% of internet
  * users.
  */-->
<?php /* //commentend by sushil 20-09-2012 to close openx-2.8.9 
<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=="<?php echo base_url('openx/www/delivery/ajs.php');?>");
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?campaignid=4");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href="<?php echo base_url('openx/www/delivery/ck.php?n=a8548db6&amp;cb=INSERT_RANDOM_NUMBER_HERE');?>" target='_blank'><img src='<?php echo base_url();?>openx/www/delivery/avw.php?campaignid=4&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a8548db6' border='0' alt='' /></a></noscript>
 //commentend by sushil 20-09-2012 to close openx-2.8.9 */?>
<!--</div> -->		<!--<div id="pagination">		<?php //echo $links; ?>	</div> -->