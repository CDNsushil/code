<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	<?php
	 $searchResultCount=count($searchResult);
	 if($searchResult && is_array($searchResult) && $searchResultCount > 0){
		 ?>
    <div class="scroll_right  fr"  >
    <div class="height656 content_3 content overflow_hidden defaultP float_none  pt_34">
        
        <?php 	
					//echo "<pre>";
					//print_r($searchResult);die;
					foreach($searchResult as $k=>$search){
                        
                       // print_r($search);
                        
						//$search=htmlEntityDecode($search);
						if(isset($searchResult[$k-1]) && (($searchResult[$k-1]->entityid==($searchResult[$k]->entityid)) && ($searchResult[$k-1]->elementid==($searchResult[$k]->elementid)) && ($searchResult[$k-1]->title==($searchResult[$k]->title))  ) ){
								continue;
						}
						$elementid = $search->elementid;
						$entityid = $search->entityid;
						$projectid = $search->projectid;
						$section = $search->section;
						$createrid = $search->userid;
                        
                        $viewCount   =  $search->viewCount;
                        $craveCount  =  $search->craveCount;
                        $ratingAvg   =  $search->ratingAvg;
						$reviewCount =  $search->reviewCount;
						$title = str_replace(array('"',"'"), array('&quot;',"&apos;"),$search->title);
						
						$userInfo =showCaseUserDetails($search->userid);
						if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
							$search->creative_name= $userInfo['enterpriseName'];
						}
						/* get Project Image */
						$projectImagePath = getProjectImage($entityid,$elementid,$projectid,$search->section);
						$prosectionId = (isset($prosectionId) && $prosectionId > 0) ? $prosectionId:0;
						
                      
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
                          <div class="section">
                             <div class="fl">
                               <input type="radio" class="radioseletion" name="SupportingProjectName" id="SupportingProjectName_<?php echo $elementid;?>" value="<?php echo $elementid;?>" projectid="<?php echo $projectid;?>" entityid="<?php echo $entityid;?>" SupportingProjectName="<?php echo $title;?>" createrid="<?php echo $createrid;?>"   />
                             </div>
                             <div class="wrap_list fl fs13">
                                <div class=" display_table list_thumb">
                                   <div class="table_cell"> <img src="<?php echo $projectImagePath;?>" alt="" /> </div>
                                </div>
                                <div class="height32 fr pl15 width_478 bb_F1592A pb4 lineH15 mb6">
                                   <p class="fl mt3"> <?php echo string_decode($search->title); ?> </p>
                                   <span class="fr text_alignR ">
                                      <p class="red font_bold fs14"><?php echo $this->lang->line($search->section); ?></p>
                                   </span>
                                </div>
                                <div class="head_list fr pl15 width_478">
                                   <div class="fr wrap_s color_666">
                                      <div class="icon_view3_blog icon_so"><?php echo   $viewCount; ?></div>
                                      <div class="icon_crave4_blog icon_so"><?php echo   $craveCount; ?></div>
                                      <div class="rating pt6 fl mr5">
                                       <img src="<?php echo ratingImagePath($ratingAvg);?>" alt="">
                                      </div>
                                      <div class="btn_share_icon"><?php echo   $reviewCount; ?></div>
                                   </div>
                                </div>
                             </div>
                          </div>
          
                  <?php }   ?>	
                    
                    
        </div>
    </div>
<?php
}else{
		$this->load->view('no_search_found_new');
	}?>

<div class="sap_30"></div>
    <div class="pag_1 pr15 pl30">
        
        <?php
            //------pagination start-------//
            if($items_total >  $perPageRecord){ ?>
                  <div class="row pt10 pl15 pr16">
                <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/search/searchresult/0/search_media_result/'.$prosectionId.''),"divId"=>"searchontoadsquareResultDiv","formId"=>"searchontoadsquare","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>  
                    <div class="clear"></div>
                    <div class="seprator_10"></div>
                </div>
                <?php
            }
            //------pagination end-------//
        ?>
       
        <div class="mr_minus15 fr">
            <button class="bg_f1592a fr p10  bdr_a0a0a0 font_weight" type="button"  onclick="supportingLink()" >Select</button>
          <button class=" bg_ededed p10 mr10 bdr_a0a0a0 font_weight" onclick="$(this).parent().trigger('close');" type="button">Cancel</button>
       </div>
    </div>
	
	<script>
		function supportingLink(){
            
            var ischecked = false;
            var entityid_from           =  "";
            var projectid               =  "";
            var SupportingProjectName   =  "";
            var createrid               =  "";
            var elementid_from          =  "";
                    
            $(".radioseletion").each(function(){
                if($(this).is(":checked")){
                    entityid_from           =  $(this).attr('entityid');
                    projectid               =  $(this).attr('projectid');
                    SupportingProjectName   =  $(this).attr('SupportingProjectName');
                    createrid               =  $(this).attr('createrid');
                    elementid_from          =  $(this).val();
                    ischecked               =  true;
                }
             });
          
            var fromSection = $('#fromSection').attr('value');
           
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

        $(".content_3").mCustomScrollbar({
            scrollInertia:600,
            autoDraggerLength:false
        });
</script>
