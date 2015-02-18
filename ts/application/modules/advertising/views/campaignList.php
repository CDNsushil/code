<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if($getCampaignLatest) {
	$campaignName = $getCampaignLatest->campaignname;
	$campaignId = $getCampaignLatest->campaignid;
	$is_published = $getCampaignLatest->is_published;
}

echo $this->load->view('advertHeader',array("headerTitle"=>'Advertising')) ?>

<div class="row seprator_5"></div>
<div class="row">
	<div class="main_project_heading">
		<div class="Main_heading_new fl"><?php echo $campaignName; ?></div>
	</div>
</div>
<div class="clear"></div>
<div class="row mt6 position_relative">
	<?php echo Modules::run("common/strip"); ?>
    <div class="cell width_200">
		<div class="box-min-height">
			<div class="liquid_box_wrapper">
				<table border="0" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td valign="top"><img src="http://localhost/toadsquare/images/liquied_top1.png"></td>
							<td class="liquid_top_mid1">&nbsp;</td>
							<td valign="top"><img src="http://localhost/toadsquare/images/liquied_top3.png"></td>
						</tr>
						<tr>
							<td class="liquid_mid1">&nbsp;</td>
							<td><img class="maxWidth165px maxHeight200px" src="http://localhost/toadsquare/images/default_thumb/no_image_73x110.jpg" border="0"></td>
							<td class="liquid_mid2">&nbsp;</td>
						</tr>
						<tr>
							<td><img src="http://localhost/toadsquare/images/liquied_bottom1.png"></td>
							<td class="liquid_bottom_mid">&nbsp;</td>
							<td><img src="http://localhost/toadsquare/images/liquied_bottom3.png"></td>
						</tr>
					</tbody>
				</table>
				<div class="liquid_box_shadow"> </div>
			</div>
		</div>
		<div class=" cell frm_heading mt85">
			<h2>Campaigns</h2>
		</div>
		<div class="clear"></div>
			<div class="Cat_wrapper">
				<?php if($getCampaignList){ ?>
					<ul>
						<?php foreach($getCampaignList as $campaignList) { ?>	
						<li class="width200px oh"> 
							<a class="<?php echo ($campaignId==$campaignList->campaignid)?'orange':''; ?>" href=<?php echo site_url(lang()).'/advertising/index/'.$campaignList->campaignid;?>><?php echo $campaignList->campaignname; ?></a>
						</li>
						<?php } ?>
					</ul>
				<?php } ?>
			</div><!--row-end-->
			<div class="seprator_20"></div>
			<!--How to publish popup -->
			<div class="ml20 mt10">
				<a href="javascript:void(0)" onclick="openLightBox('popupBoxWp','popup_box','/common/howToPublish','Competition')">
					<div class="how_publistbtn">
						<span class="fr width_60 font_museoSlab font_size15 clr_f1592a mt6 mr18">How to Publish</span>
					</div>
				</a>
			</div>
			<!--End How to publish popup -->
        </div>
         
        <div class="cell width_569 padding_left16">
			<!------Entries details------>
			<div class="row blog_wrapper new_theme_blog_box_gray ">
				<div class="toggle_btn"></div>
				<div class="blog_box bg-non-color">
              		<div class="one_side_small_shadow">
						<table width="100%" height="100% " border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td height="97"><img src="http://localhost/toadsquare/images/published_shadow_top.png"></td>
								</tr>
								<tr>
									<td class="publish_shad_mid">&nbsp;</td>
								</tr>
								<tr>
									<td height="97"><img src="http://localhost/toadsquare/images/published_shadow_bottom.png"></td>
								</tr>
							</tbody>
						</table>
                    </div><!--one_side_small_shadow-->
                    
					<div class="cell blog_left_wrapper width_395  pr16">
						<div class="row">
							<div class="published_box_wp ">
								<div class="published_heading">Active</div> 
								<div class="published_date"><?php echo dateFormatView($getCampaignLatest->activate_time) ?></div>
								<div class="clear"></div>
								 
								<div class="published_heading">Expire</div> 
								<div class="published_date "><?php echo dateFormatView($getCampaignLatest->expire_time) ?></div>
								
								 <div class="clear"></div>
								 
								<div class="published_heading">Free Space</div> 
								<div class="published_date">
									250.00 MB out of&nbsp;250.00 MB									
								</div>
								<div class="clear"></div>
									
								</div><!--published_box_wp-->
						</div>
						<div class="seprator_10 row"></div>
							<div class="row"> 
								<div class="cell width115px">
									<b class="orange_color"><?php echo $this->lang->line('impression');?></b>
								</div>
							
								<div class="cell width150px">
									<?php echo $getCampaignLatest->target_impression;?>
								</div>
							
								<div class="cell width50px">
									<b class="orange_color"><?php echo $this->lang->line('advert');?></b>
								</div>
								<div class="cell"> 
									<?php  if($getCampaignLatest->is_advert == "t") {
										echo count($oxAdvertDetails);
									} else {
										echo "0";
									}?>
								</div>
							</div>
							<div class="row"> 
								<p>&nbsp;</p>
								<div class="seprator_13"></div>
								<b class="orange_color"><?php echo $this->lang->line('tagWords');?></b>
								<p><?php echo $getCampaignLatest->comments; ?></p>
								<div class="seprator_13"></div>
								<p></p>
							</div>
					
						</div>
						<div class="cell blog_right_wrapper">
							<div class="blog_link2_wrapper">
								<div class="tds-button-top"> 
									<a href="<?php echo site_url(lang()).'/advertising/description/'.$campaignId;?>" class="ml6 formTip" title="Edit"><span><div class="projectEditIcon"></div></span></a> 
									<!--<a id="viewIconproject26" class="formTip ml6 viewIcon" target="_blank" href="javacript:void(0)" title="View"><span><div class="projectPreviewIcon"></div></span></a>
									<a id="previewIconproject26" class="formTip ml6 previewIcon" style="display: none;" target="_blank" href="http://localhost/toadsquare/en/competition/preview/124/26/showcase" title="Preview"><span><div class="projectPreviewIcon"></div></span></a>-->
								</div>
								<!--icon_edit_blog-->
							</div>
							<div class="row seprator_30"></div>
							<div class="clear"></div>
							<div class="blog_link3_wrapper">
								<div class="blog_link3_box">
									<div class="icon_crave2_blog"><?php echo $this->lang->line('craves');?></div>
									<div class="blog_link3_point">0</div>
								</div>
							
								<div class="blog_link3_box">
									<div class="icon_view2_blog"><?php echo $this->lang->line('Views');?></div>
									<div class="blog_link3_point">1</div>
								</div>
								<div class="blog_link3_box">
									<div class="icon_lastview2_blog"><?php echo $this->lang->line('Lastview');?><br>
									<b>16 Nov 2013</b>
								</div>
							</div>
						</div>
					</div>
					<div class="row blog_links_wrapper">
						<div class="fl cell">
							<?php
							$relation = array('getShortLink', 'email','share','show','entityTitle'=> $campaignName, 'shareType'=>$section, 'shareLink'=> $viewLink,'id'=> 'Project'.$competitionId,'entityId'=>$entityId,'elementid'=>$competitionId,'projectType'=>$section,'isPublished'=>$isPublished);
							?>
							<div id="relationToSharePublish<?php echo $uniqueId;?>" class="row rtsp" <?php echo $rtspDisplay; ?> >
								<?php $relation['isPublished']='t';
								$this->load->view('common/relation_to_share',array('relation'=>$relation));?>
							</div>
							
							<div id="relationToShareUnPublish<?php echo $uniqueId;?>" class="row rtsup" <?php echo $rtsupDisplay; ?>>
								<?php $relation['isPublished']='f';
									//$this->load->view('common/relation_to_share',array('relation'=>$relation));
								?>
							</div>
						</div>
						 
						<?php
						if($is_published=="t") { ?>
							<div id="PublishButton" class="cell fr PublishButton">
								<div id="publishUnpublish" class="tds-button fr formTip" original-title="You cannot publish this until you have filled in all the Required Fields."><a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0);" style="background-position: 0px -38px; "><span class=" dash_link_hover" onclick="publisheAndUnpublishe('<?php echo  $campaignId; ?>','Are you sure you want to  unpublish this campaign?','f')" style="background-position: 100% -38px; "><?php echo  $this->lang->line('hide'); ?></span></a></div>
							</div>
						<?php } else { ?>	
							<div id="UnPublishButton" class=" cell fr UnPublishButton">
								<div id="publishUnpublish" class="tds-button-orange fr formTip" original-title="You cannot publish this until you have filled in all the Required Fields."><a onmousedown="mousedown_tds_button_orange(this)" onmouseup="mouseup_tds_button_orange(this)" href="javascript:void(0);" style="background-position: 0px 0px; "><span class=" fmoss black_link_hover " onclick="publisheAndUnpublishe('<?php echo  $campaignId; ?>','Are you sure you want to  publish this campaign?','t')" style="background-position: 100% 0px; "><?php echo  $this->lang->line('Publish'); ?></span></a></div>
							</div>
						<?php } ?>	
						<input type="hidden" name="isProjectPublished<?php echo $competitionId;?>" id="isProjectPublished<?php echo $competitionId;?>" value="<?php echo $isPublished;?>"  />
					<div class="clear"></div>
				</div>		
				<div class="clear"></div>
            </div>
        </div>
		<!------Entries details ------>
		<div class="shadow_blog_box"></div>
			<div id="mediaElementList">
				<!--------row  competition entry row start------>
				<?php if($oxAdvertDetails) { 
					foreach($oxAdvertDetails as $oxAdvert) {
						$advertImg = getAdvertImage($oxAdvert->fileinput);?>
						<div id="CE116">
							<div class="row blog_wrapper new_theme_second_gray new_theme_bdr ">
								<div class="blog_box new_theme_second_gray pt4 pb3">
									<div class="cell blog_left_wrapper width_100_per">
										<div class="clear"></div>
										<div class="fl width_106  mr9">
											<div class="user_pic_wp_new_theme mt10">
												<img src="<?php echo $advertImg; ?>" class="max_w_79 max_h_59 user_new_theme_pic">
											</div><!--user_pic_wp_new_theme-->
										</div>
							
										<div class="fl width_422 pt6">
											<div class="orange_color new_theme_sub_heading p0"><?php echo $oxAdvert->title ?></div>
											<div class="new_theme_small_btn_wp ">
												<div class="tds-button-top">   
													<a href="<?php echo site_url(lang()).'/advertising/adverts/'.$campaignId.'/'.$oxAdvert->bannerid;?>" class="formTip" title="Edit"><span><div class="projectEditIcon"></div></span></a>
													<a href='javascript:advertDelete(<?php echo $oxAdvert->bannerid;?>)' class="formTip ml6" title="Delete"><span><div class="projectDeleteIcon"></div></span></a> 
												</div>
											</div>
										</div>					
							
										<div class="fl width_422">
											<div class="width_139 fl mr13 minH66">
											<div class="fl ml5 mt15"><b><?php echo  $oxAdvert->url ?></b></div>
											<div class="clear seprator_15 "></div>
										</div>
									</div>
								</div><!--width_422-->
								<div class="clear"></div>
							</div>
							<!--blog_box-->
						</div>
						<div class="shadow_blog_box"> </div>
						</div>
					<?php 
					}  
				} ?>
			<!--------row  competition entry row end------>		  
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	
	<script>
		function publisheAndUnpublishe(campaignId,msg,is_status){
			if(campaignId != undefined && campaignId > 0){
				if(confirm(msg)){
					var url = baseUrl+language+'/advertising/publisheandunpublishe';
					var setData= {"is_published":is_status,"campaignId":campaignId};
					$.post(url,setData, function(data) {
					  if(data){
							refreshPge();
						}
					},"json");
				}
			}
		}
		
		//delete advert data 
		function advertDelete(advertId){
			var detStatus = confirm('Are you sure you want delete this advert?');
			if(detStatus){
				var deleteData = '&advertId='+advertId;
				var url = baseUrl+language+'/advertising/deleteAdvert';
				$.post(url,deleteData, function(data) {
				  if(data){
						refreshPge();
					}
				},"json");
			}
		}
	</script>
				

					<!--</div>-->
