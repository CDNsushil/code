<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if($ajaxRequest) {
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
			
			<div onclick="gotourl('<?php echo $showcaseLink;?>',1);" id="uncrave_<?php echo $i ?>" class="border_cacaca shadow_down mb15 display_table fl position_relative">
				<span class="table_cell verti_top  bgf4f4f4 bre9e9e9" > <img src="<?php echo $userImage;?>" alt=""  /></span>
				<div class="table_cell text_alighL fr cnt_crev ">
					<div class="clearbox bbf47a55">
						<h4 class="font_bold fl clr_666"><?php echo getSubString($creative_name,30);?></h4>
						<div class="head_list pr5 fr">
							<?php
							if(isset($crave->isPublished) && ($crave->isPublished == 't') ){ ?>
								<div class="icon_view3_blog icon_so"><?php echo $crave->viewCount;?></div>
								<div class="icon_crave4_blog icon_so"><?php echo $crave->craveCount;?></div>
								<div class="rating fl pt6">
									<img alt="" src="<?php echo base_url($crave->ratingImg);?>" />
								</div>
								<div class="btn_share_icon icon_so"><?php echo $crave->reviewCount;?></div>
							<?php } else {
								echo $this->lang->line('showcaseNA');
							} ?>
						</div>
					</div>
					<div class="minH148">
						<div class="title_box font_bold"><?php echo getSubString($crave->title,70);?></div>
						<div class="sap_15"></div>
						<div class="fs20 open_sans">
							<span class="red">Book</span><span class="green pl15"><?php echo $crave->genre;?></span>
						</div>
					</div>
					<div class=" font_bold pt7 BT_dadada pr3"> 
						<span> <b class="pr7 ">Text File</b> FREE </span> <span class="fr"><?php echo $this->lang->line($crave->projectType);?></span> 
					</div>
				</div>
			</div>
		<!-- Crave remove option -->
		<div class="fl pt100 pl25 removeCrave" id="removecrave_<?php echo $i ?>"> 
			<a href="javascript:void(0);">
				<span onclick="unCrave('<?php echo $crave->entityId ?>','<?php echo $crave->elementId ?>','<?php echo $crave->tdsUid ?>','<?php echo $i ?>')">Remove</span>
			</a>
		</div>
			
		<?php $i++;
		} ?>
		
		<div class="width772">
		<?php
		if($items_total >  $perPageRecord) { 
			$this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/craves/cravingme/'),"divId"=>"elementListingAjaxDiv","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); 
		}
		?>
	</div>
		
	<?php
}else{
	echo '<div class="mt20 b black pl20 pr20">'.$this->lang->line('noRecordFound').'</div>';
}?>

