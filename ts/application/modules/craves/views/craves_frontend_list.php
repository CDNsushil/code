<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if($ajaxRequest){
require(APPPATH.'modules/craves/views/cravedata.php');
}
 $craveDataCount=count($craveData);
	
	 if($craveData && is_array($craveData) && $craveDataCount > 0){?>
		<div id="pagingContent">
			<?php
				
			foreach($craveData as $k=>$crave){
				if($crave->projectType != 'work'){
				switch ($crave->projectType) {
					case 'filmNvideo':
						$craveBgClass='bg_SRFilm';
						$crave->creative_area='';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->wordCount='';
						$crave->city='';
						$crave->industry='';
						$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
						$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'filmvideo');
						break;
					case 'musicNaudio':
						$craveBgClass='bg_SRMusic';
						$crave->creative_area='';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->wordCount='';
						$crave->city='';
						$crave->industry='';
						$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
						$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'musicaudio');
						break;
					case 'photographyNart':
						$craveBgClass='bg_SRArt';
						$crave->creative_area='';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->wordCount='';
						$crave->city='';
						$crave->language='';
						$crave->industry='';
						$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
						$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'photographyart');
						break;
					case 'writingNpublishing':
						$craveBgClass='bg_SRWriting';
						$crave->creative_area='';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->length='';
						$crave->city='';
						$crave->industry='';
						$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
						$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'writingpublishing');
						break;
					case 'educationMaterial':
						$craveBgClass='bg_SREducational';
						$crave->creative_area='';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->length='';
						$crave->wordCount='';
						$crave->city='';
						$crave->industry='';
						$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
						$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'educationmaterial');
						break;
					
					case 'news':
						$craveBgClass='bg_SRNews';
						$crave->creative_area='';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->genreString='';
						$crave->length='';
						$crave->wordCount='';
						$crave->city='';
						$crave->industry='';
						$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
						$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'news');
						break;
					case 'reviews':
						$craveBgClass='bg_SRNews';
						$crave->creative_area='';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->genreString='';
						$crave->length='';
						$crave->wordCount='';
						$crave->city='';
						$crave->industry='';
						$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
						$crave->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'reviews');
						break;
					case 'product':
						$craveBgClass='bg_SRProduct';
						$crave->creative_area='';
						$crave->element_type='';
						$crave->genreString='';
						$crave->length='';
						$crave->wordCount='';
						$crave->industry='';
						$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
						$crave->link=base_url(lang().'/productshowcase/viewproject/'.$linkId);
						break;
					case 'blog':
						$craveBgClass='bg_SRBlogs';
						$crave->creative_area='';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->genreString='';
						$crave->length='';
						$crave->wordCount='';
						$crave->city='';
						$crave->industry='';
						$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
						$crave->link=base_url(lang().'/blogs/frontpost/'.$linkId);
						break;
					case 'post':
						$craveBgClass='bg_SRBlogs';
						$crave->creative_area='';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->genreString='';
						$crave->length='';
						$crave->wordCount='';
						$crave->city='';
						$crave->industry='';
						$linkId=($crave->elementid == $crave->projectid)?$crave->userid.'/'.$crave->projectid.'/':$crave->userid.'/'.$crave->projectid.'/'.$crave->elementid.'/';
						$crave->link=base_url(lang().'/blogs/frontpost/'.$linkId);
						break;
					case 'upcoming':
						$craveBgClass='bg_SRUpcoming';
						$crave->creative_area='';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->genreString='';
						$crave->length='';
						$crave->wordCount='';
						$crave->city='';
						$linkId=$crave->userid.'/'.$crave->projectid;
						$crave->link=base_url(lang().'/upcomingfrontend/viewproject/'.$linkId);
						break;
					case 'performancesevents':
						$craveBgClass='bg_SREvent';
						$crave->creative_area='';
						$crave->projectCategory='';
						$crave->genreString='';
						$crave->length='';
						$crave->wordCount='';
						$crave->city='';
						$crave->industry='';
						$linkId=$crave->userid.'/'.$crave->projectid;
						$crave->link=base_url(lang().'/eventfrontend/events/'.$crave->element_type.'/'.$linkId);
						break;
					case 'creatives':
						$craveBgClass='bg_SRCreative';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->genreString='';
						$crave->length='';
						$crave->wordCount='';
						$crave->creation_date='';
						$crave->city='';
						$crave->industry='';
						$linkId=$crave->userid.'/';
						$crave->link=base_url(lang().'/showcase/index/'.$linkId);
						break;
					case 'associatedprofessionals':
						$craveBgClass='bg_SRCreative';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->genreString='';
						$crave->length='';
						$crave->wordCount='';
						$crave->creation_date='';
						$crave->city='';
						$crave->industry='';
						$linkId=$crave->userid.'/';
						$crave->link=base_url(lang().'/showcase/index/'.$linkId);
						break;
					case 'enterprises':
						$craveBgClass='bg_SRCreative';
						$crave->element_type='';
						$crave->projectCategory='';
						$crave->genreString='';
						$crave->length='';
						$crave->wordCount='';
						$crave->creation_date='';
						$crave->city='';
						$crave->industry='';
						$linkId=$crave->userid.'/';
						$crave->link=base_url(lang().'/showcase/index/'.$linkId);
						break;
					default:
						$craveBgClass='bg_SRFilm';
				}
				
				
				?>
				<div class="all_list_item">
					<?php
						$this->load->view('craves/cravesResult',array('crave'=>$crave,'craveBgClass'=>$craveBgClass));
					?>
				</div>
				<?php
			  }
			}?>
		</div>
		<div class="clear"></div>
		<?php
		if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
			 <div class="row">
				<div class="cell width_760 pagingWrapper">
					<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/craves/craveslist/'),"divId"=>"elementFrontendListingAjaxDiv","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php
		}
	}else{//$this->load->view('common/no_search_found_full'); ?>
		
			<div class="bg_SRCreative width_742 p8 nocravbg_orangeS mb5">
				<div class="nocravebg width_auto"> 
					<div class="nocravebg_inner minH147">
					   <div class="font_opensansSBold font_size30 clr_f1592a bdrB_878688 width385px mt52 ml222 lineH22"><?php echo $this->lang->line('noCraveFound') ?></div>
					</div>

				<div class="nocravebg_btm minH60 ml0 mr0">
				</div>
				</div>
			</div>		
		
	<?php }?>
