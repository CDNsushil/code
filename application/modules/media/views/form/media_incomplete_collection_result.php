<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//------default image details-------//
$isLoginUser         =   isLoginUser();
$imagetype          =   $fileConfig['defaultImage_m'];
$imagetype_xs       =   $fileConfig['defaultImage_xs'];
$imagetype_s        =   $fileConfig['defaultImage_s'];
$sectionId          =   $this->config->item($indusrty.'SectionId');
$projectEntityId    =   getMasterTableRecord('TDS_Project'); // get project entityId
// set base url
$baseUrl = formBaseUrl();
$isPublicise = 0;
if(isset($isPubliciseSection) && !empty($isPubliciseSection)) {
    $isPublicise = $isPubliciseSection;
}
$isIncomplete = 0;
if(isset($isIncompleteSection) && !empty($isIncompleteSection)) {
    $isIncomplete = $isIncompleteSection;
}




$formAttributes =   array(
    'name' =>  'editCollectionForm',
    'id'   =>  'editCollectionForm'
);

echo form_open($baseUrl.'/editproject/',$formAttributes); 

if(!empty($projectListingData)) {
        
        foreach($projectListingData as $projectData){
            
            //$projBaseImgPath  =     (!empty($projectData['projBaseImgPath']))?$projectData['projBaseImgPath']:'';
            $craveCount         =     (!empty($projectData->craveCount))?$projectData->craveCount:0;
            $viewCount          =     (!empty($projectData->viewCount))?$projectData->viewCount:0;
            $ratingAvg          =     (!empty($projectData->ratingAvg))?$projectData->ratingAvg:0;
            $reviewCount        =     (!empty($projectData->reviewCount))?$projectData->reviewCount:0;
            $projName           =     (!empty($projectData->projName))?$projectData->projName:'';
            $projShortDesc      =     (!empty($projectData->projShortDesc))?$projectData->projShortDesc:'';
            $projectId          =     (!empty($projectData->projId))?$projectData->projId:0;
            $entityId           =     (!empty($projectData->entityId))?$projectData->entityId:$projectEntityId;
            $videoFileCount     =     (!empty($projectData->videoFileCount))?$projectData->videoFileCount:'0';
            $dvdCount           =     (!empty($projectData->dvdCount))?$projectData->dvdCount:'0';
            $isPublished        =     (!empty($projectData->isPublished))?$projectData->isPublished:'f';
			$lastStageUrl       =     (!empty($projectData->currentStage))?$projectData->currentStage:'';
            
            //---------- if project image uploaded --------------// 
            $projectImage       =   getProjectCoverImage($projectId,'_m');
            
            //--------crave and rating action data--------//
            $craveDivAction             =   'craveDiv'.$entityId.''.$projectId;
            $rateDivAction              =   'rateDiv'.$entityId.''.$projectId;
    
            $cravedALL      =   '';
            //-------get logged In user craved data------------//
   
            if(!empty($loggedUserId)){
                $where=array(
                            'tdsUid'    =>  $loggedUserId,
                            'entityId'  =>  $entityId,
                            'elementId' =>  $projectId
                        );
                $countResult    =   countResult('LogCrave',$where);
                $cravedALL      =   ($countResult>0)?'cravedALL':'';
            }else{
                $cravedALL='';
            }
            
            //prepare the redirect url of project wise
            if($isPublicise > 0) {
				$lastStageUrl = $baseUrl.'/share/'.$projectId;
				$toggleBtnText = $this->lang->line('publiciseCollection').$this->lang->line('mediaCollectionHeading');
			} else {
				if(!empty($lastStageUrl)) {
					$lastStageUrl = base_url(lang().'/'.$lastStageUrl); // set last stage of project
				} else {
					$lastStageUrl = $baseUrl.'/setupsales/'.$projectId; // set sales stage if project type is sales
					if($projectData->projSellstatus == 'f') {
						$lastStageUrl = $baseUrl.'/uploadfile/'.$projectId; // set sales stage if project type is free
					}
				}
				 	
				$toggleBtnText = $this->lang->line('completeCollection').$this->lang->line('mediaCollectionHeading');
			}
        ?>
    
       
            <div class=" border_cacaca display_inline_block mb20 width100_per">
                <div class="collection_list_box fl ">
                 <a  href="<?php echo $lastStageUrl; ?>" class="display_table">
                 <span class="table_cell list_img position_relative zindex9" >
                        <img src="<?php echo $projectImage; ?>" alt=""  />
                 </span>
                 <div class="display_inline width_545 p20 fr mb50">
                    <h4 class="fs16 font_bold pb14 lineH20"><?php echo $projName; ?>
                    </h4>
                    <div class="fs12 lineH14">
                        <?php echo $projShortDesc; ?>
                    </div>
                    <div class="bb_fac8b8 pb18 mb15"></div>
                    <div class="pl10">	
                         <?php if($videoFileCount > 0){ ?>																
                           <span>
                           <b class="red pr7 "><?php echo $videoFileCount; ?></b>
                                Video Files
                           </span>
                           <?php  if($videoFileCount > 0 && $dvdCount >0){?>
                            <span class="pl10 pr10">|</span>
                           <?php  } ?>
                       <?php  } ?>
                       <?php if($dvdCount > 0){ ?>
                        <span> <b class="red  pr7"><?php echo  $dvdCount; ?></b>DVD</span>
                       <?php  } ?>
                    </div>
                 </div>
                 </a>
                 <div class="bg_f6f6f6 position_absolute width100_per lb0 pt10 pb9 zindex8 ">
                    <div class="width_545 pr18 fr">
                       <div class="head_list fl pt5">
                          <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                          <div class="icon_crave4_blog icon_so  <?php echo $craveDivAction.' '.$cravedALL; ?>" ><?php echo $craveCount; ?></div>
                          <div class="rating fl pt6 <?php echo $rateDivAction;  ?> ">
                            <img src="<?php echo ratingImagePath($ratingAvg);?>" alt="" />
                          </div>
                          <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                       </div>
                    </div>
				</div>
                    
				<div class="edit_btnhov ">
					<span class="display_table width100_per height100per">
						<a href="<?php echo $lastStageUrl; ?>" class="table_cell red text_alignC opens_light">
							<span class="hover_click fs20 lineH22"><?php echo $toggleBtnText;?></span>
						</a>
					</span>
				</div>
                    
			</div>
		</div>
<?php   }   } ?>
<?php echo form_close();?>
<div class="mediaPagination">
	<?php
	if($items_total >  $perPageRecord) { 
		$this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/media/getmediacollectionresult/0/'.$indusrty.'/'.$isPublicise.'/'.$isIncompleteSection),"divId"=>"searchMediaResultDiv","formId"=>"editCollectionForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); 
	}
	?>  
</div>
      


