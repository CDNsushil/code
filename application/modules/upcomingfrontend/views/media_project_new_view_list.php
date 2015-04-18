<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//------default image details-------//
$isLoginUser         =   isLoginUser();
$imagetype          =   $fileConfig['defaultImage_m'];
$imagetype_xs       =   $fileConfig['defaultImage_xs'];
$imagetype_s        =   $fileConfig['defaultImage_s'];
$sectionId          =   $this->config->item($industryType.'SectionId');
$projectEntityId    =   getMasterTableRecord('TDS_UpcomingProject'); // get project entityId

if(!empty($projectListingData)) {
        
        foreach($projectListingData as $projectData){
            
            //$projBaseImgPath    =     (!empty($projectData['projBaseImgPath']))?$projectData['projBaseImgPath']:'';
            $craveCount         =     (!empty($projectData['craveCount']))?$projectData['craveCount']:0;
            $viewCount          =     (!empty($projectData['viewCount']))?$projectData['viewCount']:0;
            $ratingAvg          =     (!empty($projectData['ratingAvg']))?$projectData['ratingAvg']:0;
            $reviewCount        =     (!empty($projectData['reviewCount']))?$projectData['reviewCount']:0;
            $projName           =     (!empty($projectData['projTitle']))?$projectData['projTitle']:'';
            $projShortDesc      =     (!empty($projectData['proShortDesc']))?$projectData['proShortDesc']:'';
            $projectId          =     (!empty($projectData['projId']))?$projectData['projId']:0;
            $entityId           =     (!empty($projectData['entityId']))?$projectData['entityId']:$projectEntityId;
            $isPublished        =     (!empty($projectData['isPublished']))?$projectData['isPublished']:'f';
            $industryName       =     getIndustry($projectData['projIndustry']);
            
            // set default image 
			$defaultImage = $this->config->item('upcomingImage');
			if($projectData['thumbFileId'] > 0) {
				// get image data of media
				$thumbImageData = getMediaDetail($projectData['thumbFileId']);
				$thumbImgPath = (!empty($thumbImageData)) ? $thumbImageData[0]->filePath : '';
				$thumbImgName = (!empty($thumbImageData)) ? $thumbImageData[0]->fileName : '';
				// set image file path
				$filePath = $thumbImgPath.$thumbImgName;
			} else {
				// set image file path
				$filePath = $projectData['filePath'].$projectData['fileName'];
			}
			// get media image
			$smallImg = addThumbFolder($filePath,'_m');										
			$projectImage  = getImage($smallImg,$defaultImage);	
            
            //--------crave and rating action data--------//
            $craveDivAction    =   'craveDiv'.$entityId.''.$projectId;
            $rateDivAction     =   'rateDiv'.$entityId.''.$projectId;
    
            $cravedALL  =   '';
            //-------get logged In user craved data------------//
   
            if(!empty($loggedUserId)){
                $where=array(
                            'tdsUid'    =>  $loggedUserId,
                            'entityId'  =>  $entityId,
                            'elementId' =>  $projectId
                        );
                $countResult    =   countResult('LogCrave',$where);
                $cravedALL      =   ($countResult>0)?'cravedALL':'';
            } else {
                $cravedALL='';
            }
            
            //prepare the redirect url of project wise
            $projectUrl=base_url(lang().'/mediafrontend/mediashowcases/'.$frentendUserId.'/'.$projectId);
            
             //get user showcase details
			$userInfo   =  showCaseUserDetails($projectData['tdsUid']);

			//get user first name
			$userFullName = $userInfo['userFullName'];
			$imageSize = '_m';
			if(!empty($userInfo['creative']) || !empty($userInfo['associatedProfessional']) || !empty($userInfo['enterprise'])){ 
				$userDefaultImage = ($userInfo['enterprise']=='t')?$this->config->item('defaultEnterpriseImg'.$imageSize):($userInfo['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg'.$imageSize):$this->config->item('defaultCreativeImg'.$imageSize));
			} else {
				$userDefaultImage = $this->config->item('defaultMemberImg'.$imageSize);
			}

			$userTemplateThumbImage = addThumbFolder($userInfo['userImage'],$imageSize);	
			$userImage = getImage($userTemplateThumbImage,$userDefaultImage);
        ?>
			
		<!--Collection list One-->
		
			<div class="border_cacaca display_inline_block mb20">
				<div class="upcoming_list width100_per position_relative display_table cour_poin">
					<span class="table_cell list_img position_relative  zindex_999" onclick="gotourl('<?php echo $projectUrl; ?>')" >
						<div class="display_table width_196">
							<div class="table_cell"><img src="<?php echo $projectImage; ?>"  alt="" /></div>
						</div>
						<div class="display_table">
							<div class="table_cell"><img src="<?php echo $userImage; ?>"  alt="" /> </div>
						</div>
					</span>
					<div class="display_inline width490 pt20 pr20 fr pb20 mb50" onclick="gotourl('<?php echo $projectUrl; ?>')" >
						<h4 class="fs16 font_bold pb10 pl18 lineH20">
							<?php echo $projName; ?>
						</h4>
						<div class="bb_fac8b8  mb15"></div>
						<div class=" lineH20   pl18">
							<?php echo $projShortDesc; ?>
						</div>
					</div>
				
					<div class="bg_f6f6f6 position_absolute width100_per lb0 pt10 pb9 zindex8">
							<div class="width472 pr18 pl20 fr">
								<b class="green fl widht130 pl5"><?php echo $industryName;?></b>
								<div class="head_list fl  pt3 pr20  ">
									<div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
									<div class="icon_crave4_blog icon_so"><?php echo $craveCount; ?></div>
									<div class="rating fl pt6">
										<img src="<?php echo ratingImagePath($ratingAvg);?>" alt="" />
									</div>
								</div>
								<div class="fr">  
									 <?php 
									//-----------crave button load view-----------//
									$showSocialData= array('buttonDesigntype'=>'1','buttonTitle'=>'Crave','elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
									echo Modules::run("craves/creavebutton",$showSocialData);
									
									 //------------rating button module load view------------//
									$ratingButtonData = array('elementId'=>$projectId,'entityId'=>$entityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>$isPublished);
									echo Modules::run("rating/ratingbutton",$ratingButtonData);
									?> 
								</div>
							</div>
						</div>
				</div>
			 </div>
		
		<!--Collection list One-->		          
<?php } 
   
    $url =  base_url(lang().'/upcomingfrontend/upcomingprojectsresults/0/'.$frontendUserId);
    if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
         <div class="row">
                <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>$url,"divId"=>"showmedialisting","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
            <div class="clear"></div>
        </div>
    <?php } ?> 

<?php   } ?>
      


