<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if($ajaxRequest){
require(APPPATH.'modules/craves/views/cravingmedata.php');
}
 $craveDataCount=count($craveData);
	
	 if($craveData && is_array($craveData) && $craveDataCount > 0){?>
		
			<?php
				
			foreach($craveData as $k=>$crave){
				$craveBgClass='bg_SRCreative';
				$crave->link=base_url(lang().'/showcase/index/'.$crave->tdsUid);
				
				if($crave->isPublished =='t'){
					$this->load->view('craves/cravesMeResult',array('crave'=>$crave,'craveBgClass'=>$craveBgClass));
				}else{
					$this->load->view('craves/cravesMeResult_members',array('crave'=>$crave,'craveBgClass'=>$craveBgClass));
				}
			}?>
		
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
