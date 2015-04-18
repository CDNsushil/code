<?php 

//check is reviews completed for notication
$isGreenIcon = '';
$divDisabledClass="";
if($isReviewsCompleted==false){
    $isGreenIcon = 'green_icon';
    $divDisabledClass="opacityP5 linkdisabled";
}

?>

<li data-submenu-id="sub_t13" class=" add_review common_i toad_menu_open <?php echo $isGreenIcon; ?>">
    <a href="javascript:void(0)">Your Reviews
        <?php if(!empty($isGreenIcon)){ ?>
            <i class="you_todo_icon"></i>
        <?php } ?>
    </a> 
   <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t13">
      <li class=" fs20  clr_geern your_toad bg_f3f3f3 display_table"> <span class="display_cell veti_midl">Manage your Reviews</span></li>
      <li>
         <span class="content_menu pl35  pt30 pr30">
            <?php   if($isReviewsCompleted==false){    ?> 
                <div class="green you_todo_icon "> You have things to do!</div>
                <span class="sap_15"></span>
                <ul class="width100_per  fs14 listpb10 ">
                   <li> <a href="<?php echo base_url($reviewsCurrentStage); ?>" class="text_alignR fr clr_444 red_arrow_list">Complete your Review Collection</a></li>
                </ul>
                <span class="sap_30 bd_t "></span>  
            <?php } ?>
            <ul class="width100_per red_arrow_list listpb15 <?php echo $divDisabledClass; ?>">
               <li><a href="<?php echo base_url_lang("media/reviewswizard/share/".$reviewsProjectId); ?>">Publicise your Reviews Collection</a></li>
               <li><a href="<?php echo base_url(lang().'/media/editwizardcollection/reviews');?>">Edit your Reviews Collection</a></li>
               <li><a href="<?php echo base_url(lang().'/mediafrontend/reviewscollection/'.$isLoginUser);?>">View your Reviews Collection </a></li>
            </ul>
            <div class="sap_20"></div>
            <p class="text_alignC <?php echo $divDisabledClass; ?>">
                <a href="<?php echo base_url(lang().'/media/addreviews');?>">
                    <button class=" width_208">Add a Review</button>
                </a>
            </p>
         </span>
      </li>
   </ul>
</li>
