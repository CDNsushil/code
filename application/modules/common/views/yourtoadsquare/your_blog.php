<?php 

//check is blog completed for notication
$isGreenIcon = '';
$divDisabledClass="";
if($isBlogCompleted==false){
    $isGreenIcon = 'green_icon';
    $divDisabledClass="opacityP5 linkdisabled";
}

?>


<li data-submenu-id="sub_t11" class="add_blog  common_i toad_menu_open <?php echo $isGreenIcon; ?>">
    <a href="javascript:void(0)">Your Blog
        <?php if(!empty($isGreenIcon)){ ?>
            <i class="you_todo_icon"></i>
        <?php } ?>
    </a> 
   <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t11">
      <li class=" fs20  clr_geern your_toad bg_f3f3f3 display_table"> <span class="display_cell veti_midl">Manage your Blog</span></li>
      <li>
         <span class="content_menu ">
            <?php   if($isBlogCompleted==false){    ?>
                <div class="green you_todo_icon "> You have things to do!</div>
                <span class="sap_15"></span> <a href="<?php echo base_url($blogCurrentStage); ?>" class="red_arrow_list">Complete your Blog setup </a> <span class="sap_30 bd_t "></span>
            <?php } ?>
            <h3 class=" red fs18">Posts</h3>
            <ul class="width100_per listpb15 <?php echo $divDisabledClass; ?>">
               <li><a href="<?php echo base_url_lang('blog/publiciseposts');?>" class="red_arrow_list">Publicise your Posts </a></li>
               <li class="pb0"><a href="<?php echo base_url_lang('blog/editposts');?>" class="red_arrow_list">Edit your Posts </a></li>
            </ul>
            <div class="sap_20"></div>
            <p class="text_alignC <?php echo $divDisabledClass; ?>">
                <a href="<?php echo base_url_lang('blog/addpost');?>">
                    <button class=" width_208">Add a Post</button>
                </a>
            </p>
            <span class="sap_30 bd_t "></span>
            <h3 class=" red fs18">Blog</h3>
            <ul class="width100_per listpb15 <?php echo $divDisabledClass; ?>">
               <li><a href="<?php echo base_url_lang('blog/managemediagallery');?>" class="red_arrow_list">Manage your Media Gallery </a></li>
               <?php if(!(isset($isBlogPublished) && $isBlogPublished == 't') ) { ?>
                    <li><a href="<?php echo base_url_lang('blog/manageblogpublicise');?>" class="red_arrow_list">Publicise your Blog </a></li>
               <?php } ?>
               <li><a href="<?php echo base_url_lang('blog/manageblogsetup');?>" class="red_arrow_list ">Edit your Blog Setup </a></li>
               <li><a href="<?php echo base_url_lang('blog/managecoverdetails');?>" class="red_arrow_list">Edit you Blog Cover Page </a></li>
               <li><a href="<?php echo base_url_lang('blogshowcase/index');?>" class="red_arrow_list">View your Blog </a></li>
               <li class="pt15"></li>
               
               <?php if(isset($isBlogPublished) && $isBlogPublished == 't' ) { ?>
                <li><a href="" class="red_arrow_list">Hide your Blog from your Showcase</a></li>
               <?php } ?>
               
               <!--
               <li class="pb0"><a href="javascript:void(0)" class="red_arrow_list comming_soon">Delete your Blog </a></li>-->
            </ul>
         </span>
      </li>
   </ul>
</li>
