<?php 
// set showcase links
$creative     = LoginUserDetails('creative');
$professional = LoginUserDetails('associatedProfessional'); 
$enterprise   = LoginUserDetails('enterprise'); 
$fans         = LoginUserDetails('fans'); 
$showcaseDisableCls = 'disable';
$disableUrl = 'javascript:void(0);';
$isShowcaseSet = 0;
if($creative=='t' || $professional=='t' || $enterprise=='t' || $fans=='t') {
    // set showcase active status
    $showcaseDisableCls = '';
    $addOtherLangUrl = base_url(lang().'/showcase/addotherlanguage');
    $viewShowcaseUrl = base_url(lang().'/showcase');
    $publiciseUrl = base_url(lang().'/showcase/publishshowcase');
    $isShowcaseSet = 1;
    if($fans == 't') {
        $isShowcaseSet = 2;
    }
    
}
$businessText = '';
if($enterprise=='t'){
    $businessText = "Business's";
}

//check is showcase completed for notication
$isGreenIcon = '';
$divDisabledClass="";
if($isUserShowcaseCompleted==false){
    $isGreenIcon = 'green_icon';
    $divDisabledClass="opacityP5 linkdisabled";
}

?>
<li data-submenu-id="sub_t8" class="Showcase_center common_i toad_menu_open <?php echo $isGreenIcon; ?>">
    <a href="javascript:void(0)">Your Showcase Homepage
        <?php if(!empty($isGreenIcon)){ ?>
            <i class="you_todo_icon"></i>
        <?php } ?>
    </a> 
    <ul class="menu_inner popover    menusecond toad_menu_open_sub"  id="sub_t8">
      <li class=" fs20  clr_geern your_toad  display_table"> <span class="display_cell veti_midl">Your <?php echo $businessText; ?> Showcase Homepage</span></li>
      <li>
         <span class="content_menu  ">
            <?php
                if($isUserShowcaseCompleted==false){
            ?>
                <div class="green you_todo_icon "> You have things to do!</div>
                <span class="sap_15"></span>
                <ul class="width100_per  fs14 listpb10 ">
                   <li> <a href="<?php echo base_url($userShowcaseCurrentStage); ?>" class="text_alignR fr clr_444 red_arrow_list">Complete your Showcase Homepage </a></li>
                </ul>
                <span class="sap_30 bd_t "></span> 
            <?php } ?>
             
            <ul class="width100_per red_arrow_list listpb15 <?php echo $divDisabledClass; ?>">
               <li><a href="<?php echo $publiciseUrl;?>">Publicise your Homepage</a></li>
               <li><a href="<?php echo base_url(lang().'/showcase/editshowcase');?>">Edit your Homepage </a></li>
               <li><a href="<?php echo $addOtherLangUrl;?>">Introduce your Homepage in another Language </a></li>
               <li></li>
               <li><a href="<?php echo base_url(lang().'/showcase/managerecommendations');?>">Manage your Recommendations </a></li>
                <?php if($enterprise=='t'){ ?>
               <li class="pb10"><a href="<?php echo base_url(lang().'showcase/associateshowcase');?>">Manage members connected to your Showcase </a></li>
               <?php } ?>
               <li ><a href="<?php echo $viewShowcaseUrl;?>">View your Homepage </a></li>
            </ul>
         </span>
      </li>
   </ul>
</li>
