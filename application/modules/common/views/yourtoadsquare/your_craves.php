<li data-submenu-id="sub_t3" class="craves_center common_i toad_menu_open">
   <a href="javascript:void(0)">Your Craves</a> 
   
    <?php  if($myCravesCount > 0){ ?>
       <ul class="menu_inner popover  menusecond toad_menu_open_sub"  id="sub_t3">
          <li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> <span class="display_cell veti_midl">Your Craves</span></li>
          <li>
             <span class=" content_menu width100_per ">
                <span class="sap_20"></span>
                <h3 class=" fs18 red opens_light">You’re craving</h3>
                <span class="sap_20"></span> 
                <span class="fl pt6" >You have <span class="green fs20"> <?php echo $myCravesCount; ?> </span> craves </span>
                <a href="<?php echo base_url('showcase/mycraves') ?>">
                    <button type="button" class="fr gray_btn">Veiw</button>
                </a>
                <a href="<?php echo base_url('craves/index') ?>">
                    <button  type="button" class="fr gray_btn">Edit</button>
                </a>
                <span class="sap_30 mt20 bd_t"></span>
                <h3 class="fs18 red opens_light">Craving Me</h3>
                <span class="sap_20"></span> <span class="fl pt6" >You have <span class="green fs20"> 0 </span> craves </span>
                <a href="<?php echo base_url('showcase/cravingme') ?>">
                    <button  type="button" class="fr gray_btn">Veiw</button>
                </a>
                <a href="<?php echo base_url('craves/cravingme') ?>">
                    <button  type="button" class="fr gray_btn">Edit</button>
                </a>
             </span>
          </li>
       </ul>
   <?php }else{ ?>
    <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t3">
      <li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> <span class="display_cell veti_midl">Toadsquare Craves</span></li>
      <li> <span class="   pl35 pb30 pt20 pr30"> <span class="sap_20"></span>
        <p class="fs16 lineH24 opens_light"> Crave a member or an item on Toadsquare and create a list of your favourites. Use other members’ Craves to help you browse through the site and find things you enjoy.</p>
        </span> </li>
      </ul>
    <?php } ?>
</li>
           
