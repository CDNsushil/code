<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// get user logged user information 
$isLoginUser = isLoginUser();  
$userName=$isLoginUser?LoginUserDetails('firstName'):$this->lang->line('guest');
if($isLoginUser && LoginUserDetails('enterprise')=='t'){
  $userName = LoginUserDetails('enterpriseName');
}
?>
<div class="pheader">
  <div class="toploginbar">
    
    <!--<div class="pwelcomeguest ff_arial"> <?php // echo $this->lang->line('welcome'); ?>
      <span class="ff_arial font_weight"><?php // echo $userName; ?></span> 
      from 
      <span class="ff_arial font_weight"><?php  //  echo getCountryFromIP(); ?></span> </div> -->
    <div class="prightnva">
        <ul class="lineH18">
          <?php if($isLoginUser){?>
          <!--<li><a href="<?php /*echo base_url(lang().'/showcase/index/'.isLoginUser());?>"><?php echo $this->lang->line('showcase')?></a></li>-->
          <!--<li><a href="<?php // echo base_url(lang().'/dashboard/');?>"><?php echo $this->lang->line('dashboardHead') */?></a></li>-->
          <li><a href="<?php echo base_url(lang().'/auth/logout');?>"><?php echo $this->lang->line('logout')?></a></li>
          <?php } else{?>
          <li ><a href="<?php echo base_url(lang().'/package/packagestageone');  ?>" >Join</a></li>
          <li ><a href="javascript:void(0);" onclick="javascript:openLightBox('popupBoxWp','popup_box','/auth/login');">Login</a></li>
          <?php }?>
          <li><a href="<?php echo base_url(lang().'/package/index');  ?>">Membership Options</a></li>
          <li><a href="<?php echo base_url(lang().'/help');  ?>">Help</a></li>
        </ul>
        <?php if(empty($isLoginUser)){ ?>
          <div class="paralaxbtn lineH_17 open_sans btntext mr10 mt3"> <a href="javascript:void(0);" onclick="javascript:open_window('<?php echo getFacebookLoginUrl(); ?>');"> <span class="iconspan"> <img src="<?php echo $imgPath; ?>facebooktext.png" alt="fb"></span> <span class="loginicon">Login</span> </a></div>
        <?php } ?>
    </div>
  </div>
  <div class="bg_fff">
    <div class="logomainnavbg">
       <div class="logo_container"><a href="<?php echo base_url(lang().'/home');  ?>" ><img src="<?php echo $imgPath; ?>/logonew.png" alt="" /></a></div>
       <div class="betabg">Beta</div>
       <div class="fixedposition" id="displaynone"> </div>
          <!-- guest user menus start  -->
          <?php $this->load->view('partials/guest_menu'); ?>
          <!-- guest user menus end  -->
          <!-- serach view start  -->
          <?php $this->load->view('partials/search_view'); ?>
          <!-- serach view start -->  
          <!-- member user menus start  -->
          <?php 
            if(isLoginUser()){
               //dashbaord menu 
                $this->load->view('partials/member_menu'); 
            }else{
                $this->load->view('partials/member_menu_not_loggedin'); 
            }
           
           
          ?>
          <!-- member user menus end  -->
    </div>
          <!--  member user menus start  -->
          <?php 
                
                //header bar show user info
                if(sectionNotShow('member_user_info')){
                    $userId     =   frentendUserId();
                    $this->load->view('partials/member_user_info',array('userId'=>$userId)); 
                }
                
                // member user info header
                /*if(sectionShow('showcase_user_info')){
                    $userId     =   frentendUserId();
                    $this->load->view('partials/showcase_user_info',array('userId'=>$userId)); 
                }
                elseif(sectionNotShow('member_user_info')){
                    $userId     =   frentendUserId();
                    $this->load->view('partials/member_user_info',array('userId'=>$userId)); 
                }*/
                //showcase user info header
                
          ?>
          <!--  member user menus end  -->
  </div>
  <div class="clear"></div>
</div>
