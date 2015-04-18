    <li data-submenu-id="sub_t5" class="Cart_center common_i  toad_menu_open">
       <a href="javascript:void(0)">Your Shopping Cart </a> 
        <?php if($wishlistCount > 0 || $purchaseCount > 0 || $salesCount > 0){ ?>
            <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t5">
              <li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> <span class="display_cell veti_midl">Your Shopping Cart</span></li>
              <span class=" content_menu width100_per ">
                 <div class="green you_todo_icon "> You have things to do!</div>
                 <span class="sap_15"></span>
                 <ul class="width100_per listpb10">
                    <li> <a href="<?php echo base_url('cart/mypurchases'); ?>" class="text_alignR fr clr_444 red_arrow_list">Download your Film & Video Collection </a></li>
                    <li> <a href="<?php echo base_url('cart/mypurchases'); ?>" class="text_alignR fr clr_444 red_arrow_list">Confirm you have review your Video </a> </li>
                    <li><a href="<?php echo base_url('cart/mypurchases'); ?>" class="text_alignR fr clr_444 red_arrow_list">View your Video</a> </li>
                 </ul>
              </span>
              <span class="bd_t"></span>
              <li>
                 <span class="content_menu">
                    
                    <?php if($wishlistCount > 0){ ?>
                        <h3 class=" fs18 red opens_light">Your Wish List</h3>
                        <span class="sap_10"></span>
                        <span class=" pt5" ><span class="green fs20"><?php echo $wishlistCount; ?></span> items</span>
                        <a href="<?php  echo base_url_lang('cart/mywishlist') ?>">
                            <button type="button" class="fr ">Buy </button>
                        </a>
                        <span class="sap_10 mt10 bd_t"></span>
                    <?php  } ?>
                    
                    
                    <?php if($purchaseCount > 0){ ?>
                        
                        <h3 class=" fs18 red opens_light">Your Purchases</h3>
                        <span class="sap_10"></span>
                        <a href="<?php  echo base_url_lang('cart/mypurchases') ?>">
                            <button type="button" class="fr ">View</button>
                        </a>
                    <?php  } ?>
                        
                    <?php if($salesCount > 0){ ?>
                        <span class="sap_10 mt10 bd_t"></span>
                        <h3 class=" fs18 red opens_light">Your Sales</h3>
                        <span class="sap_10"></span>
                       
                        <a href="<?php  echo base_url_lang('cart/salesinformation') ?>">
                            <button  type="button" class="fr gray_btn max_w200imp ">Sales Information</button>  
                        </a>
                        <a href="<?php  echo base_url_lang('cart/mysales') ?>">
                            <button type="button" class="fr gray_btn ">View</button>  
                        </a>
                    <?php  } ?>
                    
                 </span>
              </li>
            </ul>
       <?php }else{ ?>
          <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t5">
              <li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> <span class="display_cell veti_midl">Your Shopping Cart</span></li>
              <li> <span class="content_menu"> <span class="sap_20"></span>
              <p class="red opens_light"> We modestly claim to have built a brilliant cart for our members. </p>
              <span class="sap_20"></span>
              <p>Our cart allows members to sell digital and physical products across the globe. It provides a simple, smooth buying experience.</p>
              <span class="sap_15"></span>
              <p>Sales are in Euros or US dollars.</p>
              </span> 
              </li>
          </ul>
        <?php } ?>
    </li>
