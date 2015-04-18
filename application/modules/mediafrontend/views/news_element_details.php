<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    //------check project data and convert to single diemential array------//
    if(!empty($projectData)):
        $projectData = $projectData[0];
    endif;

    //------check project element data and convert to single diemential array------//
    $elementData         =   false;
    $elementPrepareList  =   false;
    $currentElementView  =   0;
    $currentKeyPosition  =   1;
    if(!empty($elementDataList)):
        foreach($elementDataList as $key => $getElementData){
            
            $elementPrepareList[]        =       $getElementData['elementId'];
        
            //check element id and set data
            if($getElementData['elementId']==$elementId){
                $elementData        =  $getElementData;
                $currentKeyPosition =  $key;
                $currentElementView =  $key+1;
            }
        }
    endif;
    
    //-----------next and previous element link prepare----------//
    
    $elementNumberCount    =   count($elementPrepareList);
        
    //--------element require default data--------//
    $imagetype_b            =   $fileConfig['defaultImage_b'];
    $imagetype_m            =   $fileConfig['defaultImage_m'];
    $imagetype_l            =   $fileConfig['defaultImage_l'];
    $imagetype_xl           =   $fileConfig['defaultImage_xl'];
    $imagetype_xxl           =   $fileConfig['defaultImage_xxl'];
    $imagetype_xs           =   $fileConfig['defaultImage_xs'];
    $imagetype_s            =   $fileConfig['defaultImage_s'];
   
   
    //---------preprae project details data----------//
    $projSellstatus               =   ($projectData['projSellstatus']=='t')?true:false;
    $projSellType                 =   (!empty($projectData['projSellType']))?$projectData['projSellType']:'0';

        
    //echo "<pre>";
    //print_r($elementData);
        
    //------prepare the element details data---------//
    $mediaId                =    (!empty($elementData['fileId']))?$elementData['fileId']:'0';  
    //$elementId              =   (!empty($elementData['elementId']))?$elementData['elementId']:'0'; 
    //$projectId              =   (!empty($elementData['projId']))?$elementData['projId']:$elementData['projId']; 
    $title                  =    (!empty($elementData['title']))?$elementData['title']:''; 
    $elementImagePath       =    (!empty($elementData['imagePath']))?$elementData['imagePath']:''; 
    $fileName               =    (!empty($elementData['fileName']))?$elementData['fileName']:''; 
    $filePath               =    (!empty($elementData['filePath']))?$elementData['filePath']:''; 
    $fileSize               =    (!empty($elementData['fileSize']))?$elementData['fileSize']:''; 
    $isExternal             =    (!empty($elementData['isExternal']))?$elementData['isExternal']:'f'; 
    $price                  =    (!empty($elementData['price']))?$elementData['price']:''; 
    $downloadPrice          =    (!empty($elementData['downloadPrice']))?$elementData['downloadPrice']:''; 
    $genreName              =    (!empty($elementData['genrename']))?$elementData['genrename']:''; 
    $projGenreFree          =    (!empty($elementData['projGenreFree']))?$elementData['projGenreFree']:''; 
    $projReleaseDate        =    (!empty($elementData['projReleaseDate']))?$elementData['projReleaseDate']:''; 
    $createdDate            =    (!empty($elementData['createdDate']))?$elementData['createdDate']:''; 
    $countryName            =    (!empty($elementData['countryName']))?$elementData['countryName']:''; 
    $craveCount             =    (!empty($elementData['craveCount']))?$elementData['craveCount']:'0'; 
    $viewCount              =    (!empty($elementData['viewCount']))?$elementData['viewCount']:'0'; 
    $ratingAvg              =    (!empty($elementData['ratingAvg']))?$elementData['ratingAvg']:'0'; 
    $reviewCount            =    (!empty($elementData['reviewCount']))?$elementData['reviewCount']:'0'; 
    $elementType            =    (!empty($elementData['elementType']))?$elementData['elementType']:''; 
    $classification         =    (!empty($elementData['classification']))?$elementData['classification']:''; 
    $producedInCountry      =    (!empty($elementData['producedInCountry']))?getCountry($elementData['producedInCountry']):''; 
    $isPublished            =    $elementData['isPublished']; 
    $categoryId             =    (!empty($elementData['catId']))?$elementData['catId']:'1';
    $isPrice                =    (!empty($elementData['isPrice']))?$elementData['isPrice']:'f'; 
    $isPerViewPrice         =    (!empty($elementData['isPerViewPrice']))?$elementData['isPerViewPrice']:'f'; 
    $isDownloadPrice        =    (!empty($elementData['isDownloadPrice']))?$elementData['isDownloadPrice']:'f'; 
    $selfClassfication      =    (!empty($elementData['otpion']))?$elementData['otpion']:''; 
    $article                =    (!empty($elementData['article']))?$elementData['article']:''; 
    $articleSubject         =    (!empty($elementData['articleSubject']))?$elementData['articleSubject']:''; 
    $Language               =    (!empty($elementData['Language']))?$elementData['Language']:''; 
    $mediaFileType          =    $this->config->item('media_type_document'); // set default media type for document
  
    //get directory size
    $dirSize                =   bytestoMB($fileSize);
    
    $mediaArray['width']    =   '426'; // width
    $mediaArray['height']   =   '298'; // height
    
    //get element image
    $thumbImage          =  addThumbFolder($elementImagePath,'_b');
    $elementImage        =  getImage($thumbImage,$imagetype_b);
    
    //--------crave and rating action data--------//
    $craveDivAction             =   'craveDiv'.$elementEntityId.''.$elementId;
    $rateDivAction              =   'rateDiv'.$elementEntityId.''.$elementId;
    
    $LogSummarywhere    =   array(
            'entityId'  =>  $elementEntityId,
            'elementId' =>  $elementId
    );			

    //------get user craved data ------//
    $cravedALL='';
    if(!empty($loggedUserId)){
        $where          =   array(
        'tdsUid'        =>  $loggedUserId,
        'entityId'      =>  $elementEntityId,
        'elementId'     =>  $elementId
        );
        $countResult    =   countResult('LogCrave',$where);
        $cravedALL      =   ($countResult>0)?'cravedALL':'';
    }
    
    //------about page link prepare--------//
    $aboutPageLink       =     'mediafrontend/newscollection/'.$frentendUserId.'/'.$projectId;
    $aboutPageLink       =     base_url_lang($aboutPageLink);
    
    //------create share link by current url-------//
    $currentShortUrl     = uri_string();
    
?>

<div class="row content_wrap" >
    <?php
        //---------load header navigation menu---------//
        $viewData = array(
        'headingName'   =>   $this->lang->line('news_detail_heading_'.$categoryId),
        'navigation_1'  =>   $aboutPageLink,
        'activeMenu'    =>  'menu1',
        'categoryId'    =>  "15_1",
        );
        
        $this->load->view('common_view/media_showcase_header_view',$viewData);
    ?>
   <div class="width900 m_auto pt24 sc_album display_table">
      <div class="about_review_text">
         <div class="fl width_325 pr27">
            <span class="text_alighC width100_per"><img src="<?php echo $elementImage; ?>" alt="" /> </span>
            <!--<p class="fr pt8"> <a href="">View Subject <span class="red"> ></span></a></p>-->
            <div class="sap_65"></div>
            <div class="sap_25"></div>
            <div class="head_list fl pt6 width_273 pb8 pl15 bg_fdfdfd bdr_ececec">
               <p class="fs16 fl pr10">Article</p>
               <div class="fr pr20 color_666">
                  <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                  <div class="icon_crave4_blog icon_so <?php echo $craveDivAction.' '.$cravedALL; ?>"><?php echo $craveCount;?></div>
                  <div class="rating fl pt6 <?php echo  $rateDivAction; ?>"> <img alt="" src="<?php echo ratingImagePath($ratingAvg);?>"> </div>
               </div>
            </div>
            <div class="sap_20"></div>
            <?php 
                $buttonArray = array('projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'project'); 
                $this->load->view('common_view/project_details_show_buttons',$buttonArray);
            ?>
            <div class="sap_25"></div>
            <div class="clearb pl16">
               <b class="red lettsp-1"> Article Information</b>
               <ul class="edit_list pb2 letter_spP7 fs13  ">
                   <?php if(!empty($Language)){ ?>
                      <li>
                         <p class="red lineH15">LANGUAGE</p>
                         <p><?php echo $Language; ?></p>
                      </li>
                  <?php } ?>
                    <?php if(!empty($countryName)){ ?>
                        <li>
                            <p class="red lineH15"> PRODUCED IN</p>
                            <p><?php echo $countryName; ?></p>
                        </li>
                    <?php } ?>
                  <li>
                     <p class="red lineH15">PUBLISHED ON TOADSQUARE</p>
                     <p><?php echo date("d F Y", strtotime($createdDate)); ?></p>
                     <p></p>
                  </li>
                  <!--
                  <li>
                     <p class="red lineH15">PUBLISHER</p>
                     <p>Self Published</p>
                  </li>-->
                   <?php if(!empty($selfClassfication)){ ?>
                       <li>
                          <p class="red lineH15">SELF CLASSIFICATION</p>
                          <p><?php echo $selfClassfication; ?></p>
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
         <div class="width562 rightbox   fl">
            <div class="bg_f6f5f4 bt_b7b7 bb_b7b7b7 mb8 news_wrap pb15 pt15 pr15 pl15">
               <h2 class="font_bold fs20" ><?php echo  $title; ?></h2>
               <?php if(!empty($articleSubject)){ ?>
               <span class="clearb opens_light red pt12  fs18"><?php echo $articleSubject; ?></span>
               <div class="sap_25"></div>
               <?php } ?>
               
               <p class="fs15 lineH20 pt3 lettsp_3">
                   
                     <?php 
                         if(!empty($article)){ 
                            echo $article;
                        }
                    ?>   
                </p>
               <div class="fr pt12">
                    <?php 
                    //-----------crave button load view-----------//
                     $craveButtonTitle  = 'Crave this Article';
                    $showSocialData= array('buttonDesigntype'=>'1','buttonTitle'=>$craveButtonTitle,'elementId'=>$elementId,'entityId'=>$elementEntityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
                    echo Modules::run("craves/creavebutton",$showSocialData);
                    
                     //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$elementId,'entityId'=>$elementEntityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);
                        
                ?>
               </div>
      
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
            <div class="cnt_review lineH18 fs14">
                 <?php
                        if(strlen(trim(@$elementData['description']))>2){ ?>
                                <div class="seprator_14"></div>
                                <div class="row pt18">
                                    <?php echo changeToUrl(nl2br($elementData['description']));?>
                                </div>
                            <?php		
                        }
                    ?>
            </div>
         </div>
      </div>
   </div>
</div>
           
