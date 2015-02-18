<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="mediaElementList">

	
	<?php if($competition_entries_data) {
	foreach($competition_entries_data as $competitionData)	
	{	
		?>
		<!--------row  competition entry row start------>
		<div id="CE<?php echo $competitionData->competitionEntryId;?>">
				 <div class="row blog_wrapper new_theme_second_gray new_theme_bdr ">
				  <div class="blog_box new_theme_second_gray pt4 pb3">
					<div class="cell blog_left_wrapper width_100_per">
					
					<?php 
						// get entries cover image
						$mainCoverImage = $competitionData->coverImage;
						$coverImage='';
						$defCoverImage=$this->config->item('defaultcompetitonEntryImg73X110');
						$coverImage = addThumbFolder($mainCoverImage);	
						$entriesCoverImage = getImage($coverImage,$defCoverImage);	
					?>
					<div class="clear"></div>
					<div class="fl width_106  mr9">
						 <div class="user_pic_wp_new_theme mt10">
							<img src="<?php echo  $entriesCoverImage; ?>" class="max_w_79 max_h_59 user_new_theme_pic">
				  
						</div><!--user_pic_wp_new_theme-->
					</div>
					
					<?php 
						$entityId = getMasterTableRecord('CompetitionEntry');	
						$log_summary  = getDataFromTabel('LogSummary', $field='viewCount,lastViewDate',  $whereField=array('entityId'=>$entityId,'elementId' => $competitionData->competitionEntryId), '', '', 'ASC', $limit=1, $offset=0, $resultInArray=false);
						if($log_summary)
						{
							$viewCount  = $log_summary[0]->viewCount;
						}else
						{
							$viewCount  = '0';
						}
					?>
					<div class="fl width_422 pt6">
					
					<div class="orange_color new_theme_sub_heading p0"><?php if(isset($competitionData->title)) echo html_entity_decode($competitionData->title);?></div>
					
					<div class="tds-button-top"> 
							<a href="javascript:void(0)" class="formTip ml6 comingSoon" title="<?php echo $this->lang->line('view'); ?>"><span><div class="projectPreviewIcon"></div></span></a>
							<a href="javascript:void(0)" class="formTip ml6" title="<?php echo $this->lang->line('makeDisQualifiedEntry'); ?>" onclick="makeDisQualifiedEntry('<?php echo $competitionData->competitionEntryId;?>','<?php echo $competitionData->competitionId;?>');"><span><div class="disqualified_icon"></div></span></a>
					 </div>
		
					</div>					
					
					
					<div class="fl width_422">
						<div class="width_139 fl mr13 minH66">
							<div class="new_crave_icon_box mt15">
							</div><!--new_crave_icon_box-->
							
							<div class="fl width_56 ml5 mt15"><?php echo $this->lang->line('votes'); ?></div>
							 <div class="fl width_30 ml5 mt15"><b><?php echo $competitionData->voteCount; ?></b></div>
							 <div class="clear seprator_15 "></div>
							 <div class="crave_admin_divider sparater_show_first pa"  ></div>
						</div>
						
						<div class="width_141 fl minH66">
							<div class="new_views_icon_box mt15">
							</div><!--new_crave_icon_box-->
							
							<div class="fl width_56 ml5 mt15"><?php echo $this->lang->line('Views'); ?></div>
							 <div class="fl width_30 ml5 mt15"><b><?php echo $viewCount; ?></b></div>
							 
							 <div class="clear seprator_15"></div>
							  <div class="crave_admin_divider sparater_show_second pa"  ></div>
						</div>
						
						<div class="new_lastview_wp ml2 mt15"> 
							<?php echo $this->lang->line('project_lastViewed'); ?>					
						 <div class="seprator_5"></div>
							<b><?php echo date('d M Y');?></b>
						</div>
							
						
					</div>
					   
					</div><!--width_422-->
				   
					<div class="clear"></div>
				  </div>
				  <!--blog_box-->
				</div>
				 <div class="shadow_blog_box"> </div>
		</div>
		<!--------row  competition entry row end------>
		<?php 
	} 
}  
if($items_total >  $perPageRecord){?>
	 <div class="row">
		<div class="cell width_569  pagingWrapper">
			<?php $this->load->view('pagination_multi',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/competition/competitionlist/'.$competitionId),"divId"=>"mediaElementList","formId"=>"composeForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
		</div>
		<div class="clear"></div>
	</div>
	<?php
}
		?>	  
</div>
<script>
	function makeDisQualifiedEntry(competitionEntryId,competitionId){
		if(competitionEntryId != undefined && competitionEntryId > 0 && competitionId != undefined && competitionId > 0 ){
					
					
			if(confirm('Are you sure you want to disqualified this entry?')){
				var url = baseUrl+language+'/common/editDataFromTabel';
				var setData= {"isPublished":"f","isBlocked":"t","isArchive":"t","qualified":"f"};
				var table= 'CompetitionEntry';
				var where= {"competitionEntryId":competitionEntryId, "competitionId":competitionId};
				var retunFlag = AJAX(url,'',setData,table,where);
				if(retunFlag){
					$('#CE'+competitionEntryId).remove();
				}
			}
		}
	}
</script>
