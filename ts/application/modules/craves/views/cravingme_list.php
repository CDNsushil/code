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
			
						
			$userInfo=showCaseUserDetails($crave->tdsUid);
			$userDefaultImage=($userInfo['enterprise']=='t')?$this->config->item('defaultEnterpriseImg_152_210'):($userInfo['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg_152_210'):$this->config->item('defaultCreativeImg_152_210'));
			$userTemplateThumbImage = addThumbFolder($userInfo['userImage'],'_s');	
			$userImage = getImage($userTemplateThumbImage,$userDefaultImage);
			
			
			
			if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
				$creative_name= $userInfo['enterpriseName'];
			}else{
				$creative_name= $userInfo['userFullName'];
			}
			$showcaseLink=base_url(lang().'/showcase/index/'.$crave->tdsUid);
			?>
	
				<div class="ver_contact_wp_big" id="uncrave_<?php echo $i ?>">
				<div class="ptr" onclick="gotourl('<?php echo $showcaseLink;?>',1);">
					<div class="crave_admin_user_pic_wp">
							<img class="max_w_89 max_h_59" src="<?php echo $userImage?>" />
					</div><!--ver_contact_user_pic_box-->
					<div class="crave_admin_user_data">
							<span class="orange_color crave_data_heading1 gray_clr_hover"><?php echo getSubString($creative_name,30);?></span>
							<span class="crave_data_heading2"><?php echo $this->lang->line($crave->projectType);?></span>
							<span class="crave_data_heading3"><?php echo getSubString($crave->title,70);?></span>
					</div><!--crave_admin_user_data-->
				</div>
					<div class="crave_admin_divider"></div><!--crave_admin_divider-->
					<div class="crave_control_box">
						<?php
						if(isset($crave->isPublished) && ($crave->isPublished == 't') ){
							?>
							<div class="row pt10">
								<?php echo $this->lang->line('showcaseHomepage');?>:

							</div>
							
							<div class="rating_box_crave pt15">
								<img  src="<?php echo base_url($crave->ratingImg);?>" />
							</div>
							
							
							<div class="clear"></div>
							<div class="blog_link3_box bdr_non ">
								<div class="icon_crave2_blog <?php echo $crave->craveClass;?>"> <?php echo $this->lang->line('craves');?> </div>
								<div class="blog_link3_point font_size11 fl pl5"> <?php echo $crave->craveCount;?> </div>
							</div>
							<?php
						}else{ ?>
							<div class="row pt20">
								<?php echo $this->lang->line('showcaseNA');?>
							</div>
							<?php
						}
						?>
							
					</div><!--crave_control_box--> 
					
				</div><!--ver_contact_wp-->
		
			<?php $i++;
		}
		
		if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
			 <div class="row">
				<div class="cell width_569  pagingWrapper">
					<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/craves/cravingme/'),"divId"=>"elementListingAjaxDiv","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
				</div>
					<div class="clear"></div>
			</div>
			<?php
		}
		
}else{
	echo '<div class="mt20 b black pl20 pr20">'.$this->lang->line('noRecordFound').'</div>';
}?>

