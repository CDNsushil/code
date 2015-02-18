<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if($ajaxRequest){
 require(APPPATH.'modules/craves/views/cravedata.php');
}
 $craveDataCount=count($craveData);
 if($craveData && is_array($craveData) && $craveDataCount > 0){
		$i=1;
		foreach($craveData as $k=>$crave){
			switch ($crave->projectType) {
				case 'filmNvideo':
					$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
					$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'filmvideo');
					break;
				case 'musicNaudio':
					$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
					$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'musicaudio');
					break;
				case 'photographyNart':
					$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
					$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'photographyart');
					break;
				case 'writingNpublishing':
					$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
					$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'writingpublishing');
					break;
				case 'educationMaterial':
					$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
					$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'educationmaterial');
					break;				
				case 'news':
					$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
					$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'news');
					break;
				case 'reviews':
					$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
					$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'reviews');
					break;
				case 'product':
					$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
					$crave->link=base_url(lang().'/productshowcase/viewproject/'.$linkId);
					break;
				case 'blog':
					$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
					$crave->link=base_url(lang().'/blogs/frontpost/'.$linkId);
					break;
				case 'post':
					$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
					$crave->link=base_url(lang().'/blogs/frontpost/'.$linkId);
					break;
				case 'upcoming':
					$linkId=$crave->userid.'/'.$crave->projectid;
					$crave->link=base_url(lang().'/upcomingfrontend/viewproject/'.$linkId);
					break;
				case 'performancesevents':
					$linkId=$crave->userid.'/'.$crave->projectid;
					$crave->link=base_url(lang().'/eventfrontend/events/'.$crave->element_type.'/'.$linkId);
					break;
				case 'creatives':
					$linkId=$crave->userid.'/';
					$crave->link=base_url(lang().'/showcase/index/'.$linkId);
					break;
				case 'associatedprofessionals':
					$linkId=$crave->userid.'/';
					$crave->link=base_url(lang().'/showcase/index/'.$linkId);
					break;
				case 'enterprises':
					$linkId=$crave->userid.'/';
					$crave->link=base_url(lang().'/showcase/index/'.$linkId);
					break;
				default:
					$craveBgClass='bg_SRFilm';
					$crave->link='#';
			}
			?>
            
        <div onclick="gotourl('<?php echo $crave->link;?>',1);" id="uncrave_<?php echo $i ?>" class="border_cacaca width100_per shadow_down mb15 display_table position_relative">
            <span class="table_cell verti_top  bgf4f4f4 bre9e9e9" > <img src="<?php echo $crave->craveImage;?>" alt=""  /></span>
            <div class="table_cell text_alighL fr cnt_crev ">
               <div class="clearbox bbf47a55">
                  <h4 class="font_bold fl clr_666"><?php echo $crave->creative_name;?></h4>
                  <div class="head_list pr5  fr">
                     <div class="icon_view3_blog icon_so"><?php echo $crave->viewCount;?></div>
                     <div class="icon_crave4_blog icon_so"><?php echo $crave->craveCount;?></div>
                     <div class="rating fl pt6">
                        <img alt="" src="<?php echo base_url($crave->ratingImg);?>" />
                     </div>
                     <div class="btn_share_icon icon_so"><?php echo $crave->reviewCount;?></div>
                  </div>
               </div>
               <div class="minH148">
                  <div class="title_box font_bold"><?php echo $crave->title;?>
                  </div>
                                                                                                            <div class="sap_15"></div>
                  <div class="fs20 open_sans"><span class="red">Book</span><span class="green pl15"><?php echo $crave->genre;?></span>
                  </div>
               </div>
               <div class=" font_bold pt7 BT_dadada pr3"> <span	> <b class="pr7 ">Text File</b> FREE </span> <span class="fr"><?php echo $this->lang->line($crave->projectType);?></span> </div>
            </div>
         </div>
         <!--crave list One-->
         <!--
         <div class="border_cacaca width100_per shadow_down mb15 display_table position_relative">
            <span class="table_cell verti_top  bgf4f4f4  bre9e9e9 " > <img src="images/TempImages/w_4.jpg" alt=""  /> <span class=" title_creav font_bold">Flim &amp; Video Collection</span> </span>
            <div class="table_cell text_alighL fr cnt_crev ">
               <div class="clearbox bbf47a55">
                  <h4 class="font_bold fl clr_666">Timothy Dalton-Moore</h4>
                  <div class="head_list pr5  fr">
                     <div class="icon_view3_blog icon_so">417</div>
                     <div class="icon_crave4_blog icon_so">328</div>
                     <div class="rating fl pt6">
                        <img alt="" src="images/rating/rating_04.5.png" />
                     </div>
                     <div class="btn_share_icon icon_so">3</div>
                  </div>
               </div>
               <div class="minH148">
                  <div class="title_box font_bold"> Far far away, behind the word mountains, far from the
                     countries Vokalia and Consonantia, there 
                  </div>
                  <div class="clearbox pb18">
                     <p class="fs13 ">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my </p>
                  </div>
               </div>
            
                  <div class=" font_bold pt7 BT_dadada">  <span class="fr ">Writing &amp; Publishing</span> </div>
            </div>
         </div>
         -->
        
        
	 <!--old one 
				<div class="ver_contact_wp_big" id="uncrave_<?php echo $i ?>">
				<div class="ptr" onclick="gotourl('<?php echo $crave->link;?>',1);">
					<div class="crave_admin_user_pic_wp">
							<img class="max_w_89 max_h_59" src="<?php echo $crave->craveImage;?>" />
					</div>
					<div class="crave_admin_user_data">
							<span class="orange_color crave_data_heading1 gray_clr_hover"><?php echo getSubString($crave->title,30);?></span>
							<span class="crave_data_heading2"><?php echo $this->lang->line($crave->projectType);?></span>
							<span class="crave_data_heading3"><?php echo getSubString($crave->online_desctiption,70);?></span>
					</div>
				</div>
					<div class="crave_admin_divider"></div>
					<div class="crave_control_box">
						<div class="rating_box_crave">
							<img  src="<?php echo base_url($crave->ratingImg);?>" />
						</div>
						
						<?php if(($module=='craves') && ($crave->tdsUid==$userId)){?>
							<div class="crave_cross_wp">
								<div class="tds-button-top">
									<a href="javascript:void(0);">
										<span onclick="unCrave('<?php echo $crave->entityId ?>','<?php echo $crave->elementId ?>','<?php echo $crave->tdsUid ?>','<?php echo $i ?>')"><div class="projectDeleteIcon"></div></span>
									</a>
								</div>
							</div>
							<?php
						}
						?>
						<div class="clear"></div>
							<div class="blog_link3_box bdr_non mt6">
								<div class="icon_crave2_blog <?php echo $crave->craveClass;?>"> <?php echo $this->lang->line('craves');?> </div>
								<div class="blog_link3_point font_size11 fl pl5"> <?php echo $crave->craveCount;?> </div>
							</div>
					</div>
				</div>
    <!--old one-->
			<?php $i++;
		}
		
		if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
			 <!--start pagination-->
         <div class="pag_1 pt20 pl30">
            <div class="nav_creave border_cacaca   fl "><span class="prev butn_n">Prev</span><span class=" color_444 pagination">1</span><span class=" color_444 pagination">2</span><span class=" color_444 pagination">3</span><span class=" color_444 pagination">4</span><span class=" color_444 pagination">...</span><span class=" color_444 pagination">11</span><span class=" color_444 pagination">12</span><span class=" color_444 pagination">13</span><span class=" color_444 pagination">14</span><span class="butn_n next">Next</span></div>
            <div class="nav_creave display_table  border_cacaca width228 fs13  fr ">
               <span class="pr20 pl25 result_per fl">Results per page</span> 
               <span class="position_relative selct_page  fl">
                  <select>
                     <option>10</option>
                     <option>20</option>
                     <option>30</option>
                     <option>40</option>
                     <option>50</option>
                  </select>
               </span>
            </div>
         </div>
         <!--End pagination--> 
			<?php
		}
		
}else{
	echo '<div class="mt20 b black pl20 pr20">'.$this->lang->line('noRecordFound').'</div>';
}?>

