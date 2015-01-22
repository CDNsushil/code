<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//-----------navigation--------------//
$isShowcaseHomepage = false;
$isMediaShowcases   = false;
$isBlog             = false;
$isNewsCollection   = false;
$isReviewCollection   = false;
$isCompetition        = false;

//--------Showcase Homepage (sub-navi)------//
$isAboutMe             =   false;
$isVideo               =   false;
$isMyPath              =   false;
$isMyCraves            =   false;
$isCravingMe           =   false;
$isMyPlaylist          =   false;

//-------Media Showcases (sub-navi)---------//
$isFVCollection      =   false;
$isMACollection      =   false;
$isPACollection      =   false;
$isWPCollection      =   false;
$isEMCollection      =   false;
$isUPMedia           =   false;


//get fans status
$fansStatus          = (!empty($showcaseData['fans']))?$showcaseData['fans']:'f';

//-------About Me-------------
$promotionalsection=trim($showcaseData['promotionalsection']);
if(!empty($promotionalsection) && strlen($promotionalsection) > 4){
    $aboutMeLink             =   '/showcase/aboutme/'.$userId;
    $aboutMeLink             =   base_url(lang().$href);
    $isAboutMe               =   true;
    $isShowcaseHomepage      =   true;
}

//-----------Videos--------------//
$introductoryFileId     =   trim($showcaseData['introductoryFileId']);
$interviewFileId        =   trim($showcaseData['interviewFileId']);
if(!empty($introductoryFileId) || !empty($interviewFileId)){
    $videoLink              =   '/showcase/videos/'.$userId;
    $videoLink              =   base_url(lang().$href);
    $isVideo                =   true;
    $isShowcaseHomepage     =   true;
}

//-----------My Path--------------//
$creativeFocus        =   trim($showcaseData['creativeFocus']);
$creativePath        =   trim($showcaseData['interviewFileId']);
if(!empty($creativeFocus) || !empty($creativePath)){
    $myPathLink             =   '/showcase/developementpath/'.$userId;
    $myPathLink             =   base_url(lang().$href);
    $isMyPath               =   true;
    $isShowcaseHomepage     =   true;
}

//---------------My Craves--------------------//
if($cravesCount >0){
    $myCravesLink           =   base_url(lang().'/showcase/mycraves/'.$userId);
    $isMyCraves             =   true;
    $isShowcaseHomepage     =   true;
}

//---------------Craving Me--------------------//
if($cravingmeCount>0){
    $cravingMeLink        =   base_url(lang().'/showcase/cravingme/'.$userId);
    $isCravingMe            =   true;
    $isShowcaseHomepage     =   true;
}

//---------------My Playlist--------------------//
if(getMyPlaylistCount($userId)) {
    $myPlaylistLink         =   base_url(lang().'/showcase/mypaylist/'.$userId);
    $isMyPlaylist           =   true;
    $isShowcaseHomepage     =   true;
}    

//----------------filmNvideo-------------------//
if(in_arrayr( 'filmNvideo', $userNavigations, $key='section', $is_object=0 )){
    $FVCollectionLink       =   base_url(lang().$urlUsername.'/mediafrontend/filmvideocollection/'.$userId);
    $isFVCollection         =   true;
    $isMediaShowcases       =   true;
}

//-------------------musicNaudio----------------------//
if(in_arrayr( 'musicNaudio', $userNavigations, $key='section', $is_object=0 )){
    $MACollectionLink       =   base_url(lang().$urlUsername.'/mediafrontend/musicaudiocollection/'.$userId);
    $isMACollection         =   true;
    $isMediaShowcases       =   true;
}

//-------------- photographyNart--------------------------//
if(in_arrayr( 'photographyNart', $userNavigations, $key='section', $is_object=0 )){
    $PACollectionLink       =   base_url(lang().$urlUsername.'/mediafrontend/photoartcollection/'.$userId);
    $isPACollection         =   true;
    $isMediaShowcases       =   true;
}

//---------------------writingNpublishing-------------------//
if(in_arrayr( 'writingNpublishing', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'news', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'reviews', $userNavigations, $key='section', $is_object=0 )){
    $WPCollectionLink       =   base_url(lang().$urlUsername.'/mediafrontend/writingpubcollection/'.$userId);
    $isWPCollection         =   true;
    $isMediaShowcases       =   true;
}

//--------------------------Creative-Industry Educational Collections----------------------//
if(in_arrayr( 'educationMaterial', $userNavigations, $key='section', $is_object=0 )){
    $EMCollectionLink       =   base_url(lang().$urlUsername.'/mediafrontend/educationalcollection/'.$userId);
    $isEMCollection         =   true;
    $isMediaShowcases       =   true;
}

//--------------Blog---------------//
$urlUsername = isset($urlUsername)?$urlUsername:'';
if(in_arrayr( 'blog', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'post', $userNavigations, $key='section', $is_object=0 )){
    $BlogLink       =   base_url(lang()).'/blogshowcase/index/'.$userId;
    $isBlog         =   true;
}

//-----------News Collection---------------//
if(in_arrayr( 'news', $userNavigations, $key='section', $is_object=0 )){ 
    $NewsCollectionLink       =   'mediafrontend/newscollection/'.$userId;
    $NewsCollectionLink       =   base_url_lang($href);
    $isNewsCollection           =   true;
}

//----------Reviews Collection--------------/ 
if(in_arrayr( 'reviews', $userNavigations, $key='section', $is_object=0 )){ 
    $ReviewCollectionLink     =   'mediafrontend/reviewscollection/'.$userId;
    $ReviewCollectionLink     =   base_url_lang($href);
    $isReviewCollection       =   true;
}

//-------------------------competitions-------------------//
if(is_dir(APPPATH.'modules/competition') && in_arrayr( 'competition', $userNavigations, $key='section', $is_object=0 )){
    $CompetitionLink     =     base_url(lang().'/competition/showcase/'.$userId);
    $isCompetition       =     true;
}                        
?>
<div class="fixedposition" id="displaynone2"> </div>
   <div class="Showcase_menu fr fs16 ">
      Showcase Menu
      <div class="show_tabmenu shadow" id="showmenu">
         <ul class="fs13 pt10 pb10 display_table width100_per">
            <?php if($isShowcaseHomepage){ ?>
                <li>
                   <a href="javascript:void(0)"> Showcase Homepage</a>
                   <ul>
                        <?php   if($isAboutMe){  ?> 
                            <li><a href="<?php echo $aboutMeLink;?>">About Me </a></li>
                        <?php } ?>
                        
                        <?php   if($isVideo){  ?> 
                            <li><a href="<?php echo $videoLink;?>">Videos</a></li>
                        <?php } ?>
                        
                        <?php   if($isMyPath){  ?> 
                            <li><a href="<?php echo $myPathLink;?>">My Path</a></li>
                        <?php } ?>
                        
                        <?php   if($isMyCraves){  ?> 
                            <li><a href="<?php echo $myCravesLink;?>">My Craves</a></li>
                        <?php } ?>
                        
                        <?php   if($isCravingMe){  ?> 
                            <li> <a href="<?php echo $cravingMeLink;?>">Craving Me</a> </li>
                        <?php   }   ?>
                       
                        <?php   if($isMyPlaylist){  ?> 
                            <li><a href="<?php echo  $myPlaylistLink ; ?>">My Playlist</a></li>
                        <?php } ?>
                   </ul>
                </li>
            
            <?php } ?>
            
            <?php if($isMediaShowcases && $fansStatus=="f"){ ?>
                <li>
                   <a href="javascript:void(0)">Media Showcases</a>
                   <ul>
                        <?php   if($isFVCollection){  ?> 
                            <li><a href="<?php echo $FVCollectionLink;?>">Film & Video Collections</a></li>
                        <?php   }   ?>
                        
                        <?php   if($isMACollection){  ?> 
                            <li><a href="<?php echo $MACollectionLink;?>">Music Albums </a></li>
                            <li><a href="<?php echo $MACollectionLink;?>">Audio Collections</a></li>
                        <?php   }   ?>
                       
                        <?php   if($isPACollection){  ?> 
                            <li><a href="<?php echo $PACollectionLink;?>">Photography Albums</a></li>
                             <li><a href="<?php echo $PACollectionLink;?>">Art Collections</a></li>
                        <?php   }   ?>
                        
                        <?php   if($isWPCollection){  ?> 
                            <li><a href="<?php echo $WPCollectionLink;?>">Writing Collections</a></li>
                        <?php   }   ?>   
                        
                        <?php   if($isEMCollection){  ?> 
                            <li><a href="<?php echo $EMCollectionLink;?>">Creative-Industry Educational Collections</a></li>
                        <?php   }   ?>
                        
                        <?php
                          
                          /*  //--------------------------Upcoming Media----------------------//
                            if(in_arrayr( 'upcoming', $userNavigations, $key='section', $is_object=0 )){
                        ?>
                            <li><a href="#">Upcoming Media</a></li>
                        <?php   }*/   ?>
                   </ul>
                </li>
            <?php } ?>
            
            <?php   if($isBlog){  ?> 
                <li><a href="<?php echo $BlogLink;?>">Blog</a></li>
            <?php   }   ?>
            
           <?php   if($isNewsCollection){  ?> 
                <li><a href="<?php echo $NewsCollectionLink;?>">News Collection </a></li>
            <?php   }   ?>
            
            <?php   if($isReviewCollection){  ?> 
                <li><a href="<?php echo $ReviewCollectionLink;?>">Reviews Collection</a></li>
            <?php   }   ?>
            
            <!--<li>
               <a href="javascript:void(0)">Performances & Events</a>
               <ul>
                  <li><a href="#">Film & Video Events</a></li>
                  <li><a href="#">Music & Audio Events</a></li>
                  <li><a href="#">Performing Arts Events</a></li>
                  <li><a href="#">Photography & Art Events</a></li>
                  <li><a href="#">Writing & Publishing Events</a></li>
                  <li><a href="#">Creative-Industry Educational Events</a></li>
                  <li><a href="#">Upcoming Events</a></li>
               </ul>
            </li>-->
            
                <?php   /*if($isCompetition){  ?> 
                        <li>
                           <a href="javascript:void(0)">Competitions</a>
                           <ul>
                                <li><a href="<?php echo $CompetitionLink;?>">Competitions</a></li>
                                <!-- <li><a href="#">Competition Entries</a></li>-->
                           </ul>
                        </li>
                <?php   }*/   ?>
            
            <!-- <li>
               <a href="javascript:void(0)">Classifieds</a>
               <ul>
                  <li><a href="#">Work-Offered</a></li>
                  <li><a href="#">Work-Wanted Classifieds</a></li>
                  <li><a href="#">Products-for-Sale Classifieds</a></li>
                  <li><a href="#">Products-Wanted Classifieds</a></li>
               </ul>
            </li>
            <li><a href="#">Event Notices</a></li>
            <li><a href="#">Favourite Sites </a></li>-->
            
         </ul>
      </div>
   </div>

