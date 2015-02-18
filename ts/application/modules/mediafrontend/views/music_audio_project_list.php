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
            $audioFileCount     =     (!empty($projectData['audioFileCount']))?$projectData['audioFileCount']:'0';
            $cdCount            =     (!empty($projectData['cdCount']))?$projectData['cdCount']:'0';
            $isPublished        =     (!empty($projectData['isPublished']))?$projectData['isPublished']:'f';
            $projCategory       =     (!empty($projectData['projCategory']))?$projectData['projCategory']:'0';
            
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
            $projectUrl=base_url(lang().'/mediafrontend/aboutalbum/'.$frentendUserId.'/'.$projectId);
            
           
        ?>
            <div class=" border_cacaca display_inline_block mb20">
                 <div class="collection_list_box fl ">
                    <a target="_blank" href="<?php echo $projectUrl; ?>" class="display_table">
                    <span class="table_cell list_img position_relative zindex9" >
                    <img src="<?php echo $projectImage; ?>" alt=""  /></span>
                    <div class="display_inline width_545 pt5 fl pr50 mb50">
                       <h4 class="fs16 font_bold pb14 lineH20"><?php echo $projName; ?>
                       </h4>
                       <div class="fs12 lineH14">
                             <?php echo $projShortDesc; ?>
                        </div>
                       <div class="bb_fac8b8 pb18 mb15"></div>
                       <div class="pl5">
                          <div class="fl"> 
                            
                            <?php if($audioFileCount > 0){ ?>																
                               <span>
                               <b class="red pr7 "><?php echo $audioFileCount; ?></b>
                                    <?php echo $this->lang->line('musicNaudio_music_file'); ?>
                               </span>
                               <?php  if($audioFileCount > 0 && $cdCount >0){?>
                                <span class="pl10 pr10">|</span>
                               <?php  } ?>
                            <?php  } ?>
                            <?php if($cdCount > 0){ ?>
                            <span> <b class="red  pr7"><?php echo  $cdCount; ?></b>
                                <?php echo $this->lang->line('musicNaudio_music_physical'); ?>
                            </span>
                            <?php  } ?>
                            
                          </div>
                          <div class="fr fs16">
                              <?php 
                                echo ($projCategory=="3")?$this->lang->line('musicNaudio_music_album'):$this->lang->line('musicNaudio_audio_collection');
                              ?>
                            </div>
                       </div>
                    </div>
                     </a>
                    <div class="bg_f6f6f6 position_absolute width100_per lb0 pt10 pb9 zindex8">
                       <div class="width550 pr58 fr">
                          <div class="head_list fl pt5">
                             <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                             <div class="icon_crave4_blog icon_so  <?php echo $craveDivAction.' '.$cravedALL; ?>" ><?php echo $craveCount; ?></div>
                             <div class="rating fl pt6 <?php echo $rateDivAction;  ?> ">
                                <img src="<?php echo ratingImagePath($ratingAvg);?>" alt="" />
                              </div>
                              <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                          </div>
                          <div class="fr">
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
      


