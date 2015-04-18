<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//------default image details-------//
$isLoginUser        =   isLoginUser();
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
            $imageFileCount     =     (!empty($projectData['imageFileCount']))?$projectData['imageFileCount']:'0';
            $printCount         =     (!empty($projectData['printCount']))?$projectData['printCount']:'0';
            $isPublished        =     (!empty($projectData['isPublished']))?$projectData['isPublished']:'f';
            $projCategory       =     (!empty($projectData['projCategory']))?$projectData['projCategory']:'0';
            $projSellType       =     (!empty($projectData['projSellType']))?$projectData['projSellType']:'0';
            $projSellstatus     =     (!empty($projectData['projSellstatus']))?$projectData['projSellstatus']:'f';
            
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
            
            if(isset($isEdit) && $isEdit == TRUE){
                //prepare the edit redirect url of project wise
                $projectUrl =  base_url_lang('media/photographyart/editproject/'.$projectId);
                $showText   =  'EDIT Collection';
            }else{
                 //prepare the redirect url of project wise
                $projectUrl = base_url(lang().'/mediafrontend/photoartdetails/'.$frentendUserId.'/'.$projectId);
                $showText   = 'VIEW Collection';
            }
            
           
        ?>
        
        <div class="border_cacaca display_inline_block mb20">
             <div class="collection_list_box p0 fl ">
                <a href="<?php echo $projectUrl; ?>" class="display_table">
                    <span class="table_cell  list_img position_relative zindex9" >
                    <img src="<?php echo $projectImage; ?>" alt=""  />
                    <span class=" black_title box_siz opens_light lb0">Photography & Art Collection</span>
                    </span>
                    <div class="display_inline width_545 p20 fr mb50">
                       <h4 class="fs20 open_sans pb14 "><?php echo $projName; ?>
                       </h4>
                       <div class=""><?php echo $projShortDesc; ?></div>
                       <div class="edit_btnhov ">
                          <span class="display_table width100_per height100per">
                             <div class="table_cell opens_light fs20 ">  <?php echo $showText; ?></div>
                          </span>
                       </div>
                    </div>
                </a>
                <div class="bg_f6f6f6 position_absolute width100_per lb0 pt10 pb9 zindex8">
                   <div class="width_545 pr18 fr">
                      <div class="head_list fl pt5">
                         <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                         <div class="icon_crave4_blog icon_so <?php echo $craveDivAction.' '.$cravedALL; ?>"><?php echo $craveCount; ?></div>
                         <div class="rating fl pt6 <?php echo $rateDivAction;  ?> ">
                            <img alt="" src="<?php echo ratingImagePath($ratingAvg);?>" />
                         </div>
                         <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                      </div>
                      <div class="pl10 fr open_sans">																	
                            <?php if($imageFileCount > 0){ ?>				 
                            <span>
                            <b class="red pr7 "><?php echo $imageFileCount; ?></b>
                                <?php echo $this->lang->line('photographyNart_photo_file'); ?>
                            </span>
                            <?php  } ?>
                            
                            <?php  if($imageFileCount > 0 && $printCount >0){?>
                                <span class="pl10 pr10">|</span>
                            <?php  } ?>
                           
                            <?php if($printCount > 0){ ?>
                                 <span> <b class="red  pr7"><?php echo $printCount; ?></b><?php echo $this->lang->line('photographyNart_photo_physical'); ?></span>
                            <?php  } ?>
                            
                            <?php  if($projSellstatus=="f" && ($printCount >0 || $imageFileCount > 0)){?>
                                <span class="pl10 pr10">|</span>
                            <?php  } ?>
                            
                            <?php if($projSellstatus=="f"){ ?>
                                <span class="red"> FREE</span>
                            <?php  } ?>
                      </div>
                   </div>
                </div>
                <!-- -->
             </div>
          </div>
       
<?php   }   } ?>
      


