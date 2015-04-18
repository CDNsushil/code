<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    //------default image details-------//
    $imagetype          =   $fileConfig['defaultImage_m'];
    $imagetype_xs       =   $fileConfig['defaultImage_xs'];
    $imagetype_s        =   $fileConfig['defaultImage_s'];
   
    //------check project data and convert to single diemential array------//
    if(!empty($projectDataList[0])):
        $projectData = $projectDataList[0];
    endif;
    
    
    //-----------prepare showing data -------------//
    
    $projName                   =   (!empty($projectData['projName']))?$projectData['projName']:'';
    $projDescription            =   (!empty($projectData['projDescription']))?$projectData['projDescription']:'';
    $projShortDesc              =   (!empty($projectData['projShortDesc']))?$projectData['projShortDesc']:'';
    //$projBaseImgPath            =   (!empty($projectData['projBaseImgPath']))?$projectData['projBaseImgPath']:'';
    $craveCount                 =   (!empty($projectData['craveCount']))?$projectData['craveCount']:'0';
    $viewCount                  =   (!empty($projectData['viewCount']))?$projectData['viewCount']:'0';
    $ratingAvg                  =   (!empty($projectData['ratingAvg']))?$projectData['ratingAvg']:'0';
    $reviewCount                =   (!empty($projectData['reviewCount']))?$projectData['reviewCount']:'0';
    $projReleaseDate            =   (!empty($projectData['projReleaseDate']))?$projectData['projReleaseDate']:'';
    $classification             =   (!empty($projectData['classification']))?$projectData['classification']:'';
    $cdCount                    =   (!empty($projectData['cdCount']))?$projectData['cdCount']:'0';
    $audioFileCount             =   (!empty($projectData['audioFileCount']))?$projectData['audioFileCount']:'0';
    $categoryId                 =   (!empty($projectData['projCategory']))?$projectData['projCategory']:'3';
    $categoryName               =   (!empty($projectData['category']))?$projectData['category']:'0';
    $productionHouse            =   (!empty($projectData['productionHouse']))?$projectData['productionHouse']:'';
    $Language                   =   (!empty($projectData['Language']))?$projectData['Language']:'';
    $otpion                     =   (!empty($projectData['otpion']))?$projectData['otpion']:'';
    $isPublished                =   $projectData['isPublished'];
    $cravedALL                  =   '';
    $craveDivAction             =   'craveDiv'.$entityId.''.$projectId;
    $rateDivAction              =   'rateDiv'.$entityId.''.$projectId;
    
    //---------check craved by loggedUserId------------//
    if($loggedUserId){
        $where=array(
            'tdsUid'        =>   $loggedUserId,
            'entityId'      =>   $entityId,
            'elementId'     =>   $projectId
        );
        
        $countResult    =   countResult('LogCrave',$where);
        $cravedALL      =   ($countResult>0)?'cravedALL':'';
    }else{
        $cravedALL='';
    }
    
    //---------- if project image uploaded --------------// 
    $projectImage               =   getProjectCoverImage($projectId,'_b');
    
    //------about page link prepare--------//
    $aboutPageLink       =     'mediafrontend/articledetails/'.$frentendUserId.'/'.$projectId;
    $aboutPageLink       =     base_url_lang($aboutPageLink);
    
    //------create share link by current url-------//
    $currentShortUrl = uri_string();
    
?>

<div class="row content_wrap" >
     <?php
        //---------load header navigation menu---------//
        $viewData = array(
        'headingName'   =>   $this->lang->line('news_detail_heading_'.$categoryId),
        'navigation_1'  =>   $aboutPageLink,
        'activeMenu'    =>  'menu2',
        'categoryId'    =>  "15_0",
        );
        
        $this->load->view('common_view/media_showcase_header_view',$viewData);
    ?>
   <div class="width900 m_auto pt24 sc_album display_table">
    
        <div id="news_element_list">
            <?php 
            
                //---------news collection element list-----------//
                    $this->load->view('news_collections_element_list');
                //---------news collection element list-----------//
            ?>
        </div>
      
      <div class="about_review_text">
         <div class="fl width_325 pr27">
            <span class="text_alighC width100_per"> <img alt="" src="<?php echo $projectImage; ?>"> </span>
            <div class="sap_20"></div>
            <div class="head_list fl pt6 width_273 pb8 pl10 bg_fdfdfd bdr_ececec">
               <p class="fs16 fl pr10">Collection</p>
               <div class="fr pr20 color_666">
                  <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                  <div class="icon_crave4_blog icon_so <?php echo $craveDivAction.' '.$cravedALL; ?>"><?php echo $craveCount;?></div>
                  <div class="rating fl pt6 <?php echo  $rateDivAction; ?>"> <img alt="" src="<?php echo ratingImagePath($ratingAvg);?>"> </div>
                  <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
               </div>
            </div>
            <div class="sap_25"></div>
            <?php 
                $buttonArray = array('projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'project'); 
                $this->load->view('common_view/project_details_show_buttons',$buttonArray);
            ?>
            <div class="sap_25"></div>
            <div class="clearb">
               <b class="red lettsp-1"> Collection Information</b>
               <ul class="edit_list pb2 letter_spP7 fs13  ">
                  
                  <?php if(!empty($Language)){?>
                  <li>
                     <p class="red lineH15">LANGUAGE</p>
                     <p><?php echo $Language; ?></p>
                  </li>
                  <?php } ?>
                   <?php if(!empty($productionHouse)){?>
                   <li>
                     <p class="red lineH15">PRODUCED IN</p>
                     <p><?php echo $productionHouse; ?></p>
                  </li>
                   <?php } ?>
                  <li>
                     <p class="red lineH15">PUBLISHED ON TOADSQUARE</p>
                     <p><?php echo date("d F Y", strtotime($projReleaseDate)); ?></p>
                     <p></p>
                  </li>
                  <!--
                  <li>
                     <p class="red lineH15">PUBLISHER</p>
                     <p>Self Published</p>
                  </li>-->
                    <?php if($otpion) { ?>
                      <li>
                         <p class="red lineH15">SELF CLASSIFICATION</p>
                         <p><?php echo $otpion;?></p>
                      </li>
                  <?php } ?>
               </ul>
            </div>
            <div class="sap_30"></div>
            <span class="text_alighL width100_per"> 
                
                <?php 
                    //----------- advertisement of 250 X 250----------//
                        if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
                            //Manage right side forum advert
                            $bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'1'));
                            if(!empty($bannerRhsData)) {
                                $this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'1','sectionId'=>$advertSectionId));
                            } else {
                                $this->load->view('common/adv_rhs_forum');
                            }
                        } else {
                            $this->load->view('common/adv_rhs_forum');
                        }
                    //----------- advertisement of 250 X 250----------//
                ?>
            </span> 
         </div>
         <div class="width562 rightbox  bt_b7b7 fl pt15">
            <div class="clearbox bg6c6c pt20 pb22">
               <h3 class="fs29 pl18 clr_fff lineH24">About the News Collection </h3>
            </div>
            <div class="fs20 pt17 pb15 pl18 pr15 lineH22 font_bold"><?php echo html_entity_decode($projName);?>
            </div>
            <p class="fs13 pl18 pr15">
                <?php
                    if(strlen(trim($projShortDesc))>2){ ?>
                <?php echo nl2br($projShortDesc);?>
                <?php } ?> </p>
            <div class="sap_20"></div>
            <div class="bg_eceae8 bdr_d9d9 fs13  pb20 pt15 pr15 pl15">
               <?php
                    if(strlen(trim($projDescription))>2){ ?>
                        <?php echo changeToUrl(nl2br($projDescription));?>
                <?php 
                    }
                ?>
            </div>
            <div class="fr pt15 ">
                 <?php 
                    //-----------crave button module load view-----------//
                    $craveButtonTitle  = 'Crave this Collection';
                    $craveButtonData   = array('buttonDesigntype'=>'1','buttonTitle'=>$craveButtonTitle,'elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
                    echo Modules::run("craves/creavebutton",$craveButtonData);

                    //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$projectId,'entityId'=>$entityId,'isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);

                ?>
            </div>
            <div class="box_wrap socail_icon width_542 pb9">
               <ul class="socail_list">
                  <li>
                    <?php 
                        echo ' <span class="fl">';
                            
                            //-----short module link by email module array-----//
                            $shortlinkEmailData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'1');
                            echo Modules::run("share/shareemailbutton",$shortlinkEmailData);								

                            //-----load module shortlink module array-----//
                            $shortlinkData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'1');
                            echo Modules::run("shortlink/shortlinkfrontbuttonnew",$shortlinkData);								

                        echo '</span>';

                            //-------load module of social share---------------//
                            $shareData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'1');
                            echo Modules::run("share/sharesocialshowview",$shareData);		
                    ?>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
         
