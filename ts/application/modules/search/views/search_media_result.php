<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	<?php
	 $searchResultCount=count($searchResult);
	 if($searchResult && is_array($searchResult) && $searchResultCount > 0){
		 ?>
		<div class="width600px pt15 pb5 "> 
			<div id="pagingContent" class="height400scrollY">
				
					<?php 	
					//echo "<pre>";
					//print_r($searchResult);die;
					foreach($searchResult as $k=>$search){
						//$search=htmlEntityDecode($search);
						if(isset($searchResult[$k-1]) && (($searchResult[$k-1]->entityid==($searchResult[$k]->entityid)) && ($searchResult[$k-1]->elementid==($searchResult[$k]->elementid)) && ($searchResult[$k-1]->title==($searchResult[$k]->title))  ) ){
								continue;
						}
						$elementid = $search->elementid;
						$entityid = $search->entityid;
						$projectid = $search->projectid;
						$section = $search->section;
						$createrid = $search->userid;
						$title = str_replace(array('"',"'"), array('&quot;',"&apos;"),$search->title);
						
						$userInfo =showCaseUserDetails($search->userid);
						if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
							$search->creative_name= $userInfo['enterpriseName'];
						}
						/* get Project Image */
						$projectImagePath = getProjectImage($entityid,$elementid,$projectid,$search->section);
						$prosectionId = (isset($prosectionId) && $prosectionId > 0) ? $prosectionId:0;
						
						if(((!empty($sectionId) &&  $sectionId=='media') || isset($prosectionId)) && $fromSection!='abuseReport'){
							if(isset($elementid) && isset($projectid) && $elementid==$projectid){
								$projectType =  $this->lang->line('project');
							}else{
								if($search->section=="news"){
									$projectType =  $this->lang->line('article'); // add by lokendra
								}else{
									$projectType =  $this->lang->line('piece');
								}
							}
							
							/*set bg color for industry*/
							switch($search->section){
								case 'filmNvideo':
								$bgStyle = 'bg_SRFilm';
								break;
								case 'writingNpublishing':
								$bgStyle = 'bg_SRWriting';
								break;
								case 'musicNaudio':
								$bgStyle = 'bg_SRMusic';
								break;
								case 'photographyNart':
								$bgStyle = 'bg_SRArt';
								break;
								case 'educationMaterial':
								$bgStyle = 'bg_SREducational';
								break;
								default:
								$bgStyle = '';
							}
							//echo $bgStyle;
						?>
						
						<a href="javascript://void(0)" rel="<?php echo $elementid;?>" projectid="<?php echo $projectid;?>" entityid="<?php echo $entityid;?>" SupportingProjectName="<?php echo $title;?>" createrid="<?php echo $createrid;?>" onclick="supportingLink(this,1)" >
						<div class="search_result_list_wrapper <?php echo $bgStyle;?> ml2 mb10 minH60">
							<div class="bg_white pt2 pb2 pl2 pr2 pr">
								<div class="bg_3e3e3e minH60">
									<div class="fl width60px bdrR_fff height_60">
										<div class="cell ml20 mt10 thumb_absolute01">
											<div class="AI_table">
												<div class="AI_cell"> 
													<img class="mH30 bdr_cecece max_w34_h41" src="<?php echo $projectImagePath;?>">
												</div>
											</div>
										</div>
									</div>
									<div class="fl width490px ml2">
										<div class="bdr_f15921 font_opensansSBold clr_white ml12 mr17 pt3 pb3">
											<div class="fl font_size14 width250px"><?php echo $search->creative_name; ?></div>
											<div class="fr font_size12"><?php echo $this->lang->line($search->section); ?></div>
											<!--<div class="pa right4 defaultP media_radio"> 
												<input type="radio" name="SupportingProjectName" value="<?php //echo $elementid;?>" projectid="<?php //echo $projectid;?>" entityid="<?php //echo $entityid;?>" SupportingProjectName="<?php //echo $title;?>" createrid="<?php //echo $createrid;?>" onclick="supportingLink(this,0)"  />
											</div>-->
											<div class="clear"></div>
										</div>
										<!--<div class="seprator_7"></div>-->
										<div class="font_opensansSBold clr_white ml12 mr17 pt3 pb3 lH14">
											<div class="fl font_size12 width250px"><?php echo string_decode($search->title); ?></div>
											<div class="fr font_size12"><?php echo $projectType; ?></div>
											<div class="clear"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						</a>
						<?php }else{?>
							<div class="all_list_item">
								<div class="row pl10 pr10 pb30">
									<div class="cell defaultP mr15 "> 
										<input type="radio" name="SupportingProjectName" value="<?php echo $elementid;?>" projectid="<?php echo $projectid;?>" entityid="<?php echo $entityid;?>" SupportingProjectName="<?php echo $title;?>" createrid="<?php echo $createrid;?>" onclick="supportingLink(this,0)"  />
									</div>
									
									<div class="cell mr15  width180px oh"><?php echo $search->creative_name;?></div>
									<div class="cell width300px"><?php echo string_decode($search->title);?></div>
								</div>
							</div>
						<?php
						}
					}?>	
			</div>
		</div>
			
		<?php
		if($items_total >  $perPageRecord){?>
			  <div class="row pt10 pl15 pr16">
			<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/search/searchresult/0/search_media_result/'.$prosectionId.''),"divId"=>"searchontoadsquareResultDiv","formId"=>"searchontoadsquare","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>  
				<div class="clear"></div>
				<div class="seprator_10"></div>
			</div>
			<?php
		}
	}else{
		echo '<div class="pt15">';
		$this->load->view('common/no_search_found');
		echo '</div>';
	}?>
<div class="clear seprator_10"></div>

	<div class="clear"></div>
	
	<script>
		function supportingLink(obj,mediaCheck){
			
			var fromSection = $('#fromSection').attr('value');
			
			var entityid_from = $(obj).attr('entityid');
			var projectid = $(obj).attr('projectid');
		
			var SupportingProjectName = $(obj).attr('SupportingProjectName');
			var createrid = $(obj).attr('createrid');
			if(mediaCheck==1){
				var elementid_from = obj.rel;
			}else{
				var elementid_from = obj.value;
			}
			
			
			if($('#'+fromSection+'projectid'))$('#'+fromSection+'projectid').val(projectid);
			if($('#'+fromSection+'entityid_from'))$('#'+fromSection+'entityid_from').val(entityid_from);
			if($('#'+fromSection+'elementid_from'))$('#'+fromSection+'elementid_from').val(elementid_from);
			if($('#isUpdatedSupportingMedia'))$('#isUpdatedSupportingMedia').val(1);
			
			if($('#newsSearch'))$('#newsSearch').val('<?php echo $this->lang->line('keywordSearch');?>');
			if($('#'+fromSection+'Row'))$('#'+fromSection+'Row').hide();
			if($('#'+fromSection+'Result'))$('#'+fromSection+'Result').show();
			if($('#'+fromSection+'Div'))$('#'+fromSection+'Div').show();
			if($('#'+fromSection+'Div'))$('#'+fromSection+'Div').html(SupportingProjectName);
			
			if($('#from_showcaseid'))$('#from_showcaseid').val(projectid);
			if($('#searchEnterPrisesDiv'))$('#searchEnterPrisesDiv').html(SupportingProjectName);
			
			if(fromSection=='abuseReport') {	
				$('#entityId').val(entityid_from);
				$('#elementId').val(elementid_from);
				$('#projectId').val(projectid);
				$('#ownerId').val(createrid);
				$('#SupportingProjectName').val(SupportingProjectName);
				$('#projectName').html(SupportingProjectName);
				if($('#projectId').val(projectid)!='' && SupportingProjectName!='') {
					$('#saveAbuseButton').removeClass('disable_btn').addClass('');
					$('#saveAbuseButton').prop('disabled', false);
				}
			}
			
			$('#popup_close_btn').parent().trigger('close');
		}
		runTimeCheckBox();
	</script>
