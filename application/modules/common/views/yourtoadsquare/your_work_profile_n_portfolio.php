<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// set workprofile base url
$wpBasePath = base_url_lang('workprofile');
// set session value for edit mode
$this->session->set_userdata('isEditWPMedia',1);
?>
<li data-submenu-id="sub_t20" class="  work_profile common_i toad_menu_open">
   <a href="javascript:void(0)">Your Work Profile &amp; Portfolio</a> 
   <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t28">
      <li class=" fs20  clr_geern your_toad bg_f3f3f3 display_table"> <span class="display_cell veti_midl">Manage your Work Profile & Portfolio</span></li>
      <li>
         <span class=" content_menu width100_per">
            <div class="green you_todo_icon "> You have things to do!</div>
            <span class="sap_15"></span>
            <ul class=" width100_per  red_arrow_list listpb15">
               <li> <a href="" class=""> Reply to a request to see your Work Profile & Portfolio </a></li>
               <li> <a href="" class=""> Renew your Work Profile & Portfolio </a></li>
            </ul>
            <span class="sap_15 mb20 bd_t"></span>
            <ul class=" width100_per  red_arrow_list listpb15">
               <li> <a href="" class=""> Print and/or Save your CV as a PDF</a></li>
               <li> <a href="<?php echo $wpBasePath.'/emaillink';?>" class=""> Share your Profile and / or Portfolio </a></li>
               <li> <a href="<?php echo $wpBasePath.'/yourdetails';?>" class=""> Edit your Profile </a></li>
               <li> <a href="<?php echo $wpBasePath.'/portfoliomediatype';?>" class=""> Edit your Portfolio </a></li>
               <li> <a href="" class=""> View your Work Profile & Portfolio </a></li>
               <li> <a href="<?php echo $wpBasePath.'/recommandations';?>" class=""> Manage your Recommendations </a></li>
               <li> <a href="<?php echo $wpBasePath.'/membershipcart';?>" class=""> Add Storage Space to your Work Profile & Portfolio </a></li>
               <li> <a href="<?php echo $wpBasePath.'/addbutton';?>" class=""> Remove the button allowing members to request your    
                  Work Profile & Portfolio from your Showcase Homepage </a>
               </li>
            </ul>
            <span class="sap_10 mb20 bd_t"></span>
            <div class="fl  pr30 pb10 ">Snyc your Work Profile & Protfolio with your smart phone or tablet using or app.</div>
            <ul class="width100_per  red_arrow_list listpb15">
               <li> <a href="<?php echo $wpBasePath.'/downloadapp';?>" class="">Download the Toadsquare app for iOS <i class="apple_icon common_icon"></i></a></li>
               <li> <a href="<?php echo $wpBasePath.'/downloadapp';?>" class="">Download the Toadsquare  app for Android <i class="android_icon common_icon"></i></a></li>
            </ul>
         </span>
      </li>
   </ul>
</li>
