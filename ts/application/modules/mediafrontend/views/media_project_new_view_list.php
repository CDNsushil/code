<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//------default image details-------//
$imagetype          =   $fileConfig['defaultImage_m'];
$imagetype_xs       =   $fileConfig['defaultImage_xs'];
$imagetype_s        =   $fileConfig['defaultImage_s'];
$sectionId          =   $this->config->item($industryType.'SectionId');
$projectEntityId    =   getMasterTableRecord('TDS_Project'); // get project entityId

if(!empty($projectListingData)) {
        
        foreach($projectListingData as $projectData){
            
            //$projBaseImgPath    =     (!empty($projectData['projBaseImgPath']))?$projectData['projBaseImgPath']:'';
            $craveCount         =     (!empty($projectData['craveCount']))?$projectData['craveCount']:0;
            $viewCount          =     (!empty($projectData['viewCount']))?$projectData['viewCount']:0;
            $ratingAvg          =     (!empty($projectData['ratingAvg']))?$projectData['ratingAvg']:0;
            $reviewCount        =     (!empty($projectData['reviewCount']))?$projectData['reviewCount']:0;
            $projName           =     (!empty($projectData['projName']))?$projectData['projName']:'';
            $projShortDesc      =     (!empty($projectData['projShortDesc']))?$projectData['projShortDesc']:'';
            $projectId          =     (!empty($projectData['projId']))?$projectData['projId']:0;
            $entityId           =     (!empty($projectData['entityId']))?$projectData['entityId']:$projectEntityId;
            $videoFileCount     =     (!empty($projectData['videoFileCount']))?$projectData['videoFileCount']:'0';
            $dvdCount           =   (!empty($projectData['dvdCount']))?$projectData['dvdCount']:'0';
            $isPublished        =     (!empty($projectData['isPublished']))?$projectData['isPublished']:'f';
            
            //---------- if project image uploaded --------------// 
            $projectImage               =   getProjectCoverImage($projectId,'_m');
            
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
            $projectUrl=base_url(lang().'/mediafrontend/mediashowcases/'.$frentendUserId.'/'.$projectId);
            
           
        ?>
    
       
            <div class=" border_cacaca display_inline_block mb20 width100_per">
                <div class="collection_list_box fl ">
                 <a target="_blank" href="<?php echo $projectUrl; ?>" class="display_table">
                 <span class="table_cell list_img position_relative zindex9" >
                        <img src="<?php echo $projectImage; ?>" alt=""  />
                 </span>
                 <div class="display_inline width_545 pt5 fr mb50">
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
                 <div class="bg_f6f6f6 position_absolute width100_per lb0 pt10 pb9 zindex8 height_31">
                    <div class="width_545 pr18 fr">
                       <div class="head_list fl pt5">
                          <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                          <div class="icon_crave4_blog icon_so  <?php echo $craveDivAction.' '.$cravedALL; ?>" ><?php echo $craveCount; ?></div>
                          <div class="rating fl pt6 <?php echo $rateDivAction;  ?> ">
                            <img src="<?php echo ratingImagePath($ratingAvg);?>" alt="" />
                          </div>
                          <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                       </div>
                       <div class="fr ">
                                <?php 
                                    if(!$isDeleteView){
                                    //-----------crave button load view-----------//
                                    $showSocialData= array('buttonDesigntype'=>'1','buttonTitle'=>'Crave','elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
                                    echo Modules::run("craves/creavebutton",$showSocialData);
                                    
                                     //------------rating button module load view------------//
                                    $ratingButtonData = array('elementId'=>$projectId,'entityId'=>$entityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>$isPublished);
                                    echo Modules::run("rating/ratingbutton",$ratingButtonData);
                                  //$this->load->view('rating/rating_form_design',array('elementId'=>$elementId,'entityId'=>$entityId));
                                  
                                    //------------review button view load-------------//
                                    $this->load->view('media/reviewViewNew',array('elementId'=>$projectId,'entityId'=>$entityId,'projName'=>$projName,'section' =>'Film & Video','industryId' =>'1','isPublished'=>$isPublished));
                                }
                                ?> 
                       </div>
                    </div>
                 </div>
                </div>
            </div>
        
    
<?php   }   } ?>
      


