<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$isLoginUser = isLoginUser();
if($isLoginUser){
    $userName=LoginUserDetails('firstName');
    if(LoginUserDetails('enterprise')=='t'){
      $enterpriseName = LoginUserDetails('enterpriseName');
      if(!empty($enterpriseName)){
            $userName=$enterpriseName;
        }
    }
     ?>
    
    <div class="fixedposition" id="displaynone1"> </div>
    <div class="yourtoadsquare" >
       <div class="toadsq position_relative navHeading"> <a href="#" class="ff_arial"><?php // echo $userName.'s'?> Your Toadsquare</a></div>
       <div id="TSnavigationContents" class="menu2 ">
          <div class="redarrow_container"><img alt="toprow" src="<?php echo $imgPath; ?>cssmenutoprow.png" /></div>
          <div class="externalpanel shadow">
             <div class="your_toad fs22  brdr brc2c2c2 font_bold bg_f1592a clr_fff display_table ">
                <span class="display_cell veti_midl">Your Toadsquare</span>
             </div>
             <ul class="menufrist ul_first  brdr bgfbf9f9 brc2c2c2  dropdown-menu" >
                <li class="pro_1"><a href="" class="com_1">You have things to do!</a></li>
                <li data-submenu-id="sub_t1">
                   <a href="#">Comment on the Forum</a> 
                   <!--<ul class="menu_inner  menusecond submenuItem" id="sub_t1" >
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Comment on the Forum</span></li>
                   </ul>-->
                   <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t1">
                            <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                       </ul> 
                    
                </li>
                <!---message center start menu-->
                    <li data-submenu-id="sub_t2">
                       <a href="<?php echo base_url(lang().'/tmail'); ?>">Your Message Center</a> 
                       
                       <!--  <ul class="menu_inner  menusecond submenuItem" id="sub_t2" >
                          <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Message Center</span></li>
                          <li>
                              <a href="<?php echo base_url(lang().'/tmail'); ?>" class="head" >Your Tmail</a>
                             <ul>
                                <li>  <a href="<?php echo base_url(lang().'/craves/cravingme'); ?>">Tmail the Members who crave you</a></li>
                                <li>  <a href="<?php echo base_url(lang().'/tmail/compose'); ?>">Compose</a></li>
                             </ul>
                          </li>
                          <li>
                             <a href="<?php echo base_url(lang().'/tmail'); ?>" class="head" >You have <?php echo (!empty($unreadMsgCount))?$unreadMsgCount:0; ?> new Tmails</a>
                             <ul>
                                <li>  <a href="<?php echo base_url(lang().'/tmail'); ?>"> Read </a></li>
                             </ul>
                          </li>
                          <li>
                             <a href="<?php echo base_url(lang().'/notifications/index'); ?>" class="head">Your Notifications</a>
                             <ul>
                                <li><a href="<?php echo base_url(lang().'/notifications/index'); ?>">Your have <?php echo (!empty($notificationCount))?$notificationCount:0; ?> new Notifications</a></li>
                                <li><a href="<?php echo base_url(lang().'/notifications/index'); ?>">Read </a></li>
                             </ul>
                          </li>
                          <li>
                             <a href="<?php echo base_url(lang().'/messagecenter/contacts'); ?>" class="head">Your Contacts</a>
                             <ul>
                                <li>  <a href="<?php echo base_url(lang().'/messagecenter/contacts'); ?>">Your have <?php echo (!empty($contactCount))?$contactCount:0; ?> Contacts</a></li>
                                <li>  <a href="<?php echo base_url(lang().'/messagecenter/contacts'); ?>">View </a></li>
                             </ul>
                          </li>
                       </ul>-->
                        
                      <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t2">
                            <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                       </ul> 
                        
                    </li>
                <!---message center end menu-->
                
                <!---your craves start menu-->
                    <li data-submenu-id="sub_t3">
                       <a href="<?php echo base_url(lang().'/craves'); ?>">Your Craves</a> 
                       <!--
                       <ul class="menu_inner  menusecond submenuItem" id="sub_t3" >
                          <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Craves</span></li>
                          <li>
                             <a href="<?php echo base_url(lang().'/craves'); ?>" class="head">You have <?php echo (!empty($myCravesList))?count($myCravesList):0; ?> Craves </a>
                             <ul>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>" >View </a></li>
                             </ul>
                          </li>
                          <li>
                             <a href="<?php echo base_url(lang().'/craves'); ?>" class="head">Craving your Showcase </a>
                             <ul>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>"><?php echo (!empty($myCraveCategory['yourshowcase']))?count($myCraveCategory['yourshowcase']):'0'; ?> members are craving your Showcase </a></li>
                             </ul>
                          </li>
                          <li data-submenu-id="sub_t2">
                            <a href="<?php echo base_url(lang().'/craves'); ?>" class="head">Craving</a>
                             <ul>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>" >Your Homepage – <?php echo (!empty($myCraveCategory['yourshowcase']))?count($myCraveCategory['yourshowcase']):'0'; ?></a></li>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>" >Your Media Showcases – <?php echo (!empty($myCraveCategory['mediashowcases']))?count($myCraveCategory['mediashowcases']):'0'; ?></a></li>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>" >Your Performances &amp; Events – <?php echo (!empty($myCraveCategory['performancesevents']))?count($myCraveCategory['performancesevents']):'0'; ?></a></li>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>" >Your Blog &amp; Posts – <?php echo (!empty($myCraveCategory['blog']))?count($myCraveCategory['blog']):'0'; ?></a></li>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>" >Your Competitions – <?php echo (!empty($myCraveCategory['competitions']))?count($myCraveCategory['competitions']):'0'; ?></a></li>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>" >Your Competition Entries – <?php echo (!empty($myCraveCategory['competitionentries']))?count($myCraveCategory['competitionentries']):'0'; ?></a></li>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>" >Your Work-Offered Classifieds – <?php echo (!empty($myCraveCategory['workofferedclassifieds']))?count($myCraveCategory['workofferedclassifieds']):'0'; ?></a></li>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>" >Your Work-Wanted Classifieds – <?php echo (!empty($myCraveCategory['workwantedclassifieds']))?count($myCraveCategory['workwantedclassifieds']):'0'; ?></a></li>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>" >Your Product-for-Sale Classifieds – <?php echo (!empty($myCraveCategory['productforsaleclassifieds']))?count($myCraveCategory['productforsaleclassifieds']):'0'; ?></a></li>
                                <li><a href="<?php echo base_url(lang().'/craves'); ?>" >Your Product-Wanted Classifieds – <?php  echo (!empty($myCraveCategory['productwantedclassifieds']))?count($myCraveCategory['productwantedclassifieds']):'0'; ?></a></li>
                             </ul>
                          </li>
                       </ul>
                        -->
                        <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t3">
                            <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                       </ul> 
                    </li>
                <!---your craves start menu-->
              
                <!---Your playlist start menu-->
                    <li data-submenu-id="sub_t4">
                       <a href="<?php echo base_url(lang().'/craves/myplaylist'); ?>">Your Playlist</a> 
                       <ul class="menu_inner  menusecond submenuItem" id="sub_t4" >
                          <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Playlist</span></li>
                          <li>
                             <a href="<?php echo base_url(lang().'/showcase/mypaylist'); ?>" class="head">You have <?php echo ($myPlaylistCount)?$myPlaylistCount:'0'; ?> Music Files in your Playlist</a>
                             <ul>
                                <li><a href="<?php echo base_url(lang().'/showcase/mypaylist'); ?>">Play</a></li>
                             </ul>
                          </li>
                          <li> <a href="<?php echo base_url(lang().'/showcase/mypaylistedit'); ?>" class="head">Edit your Playlist</a> </li>
                       </ul>
                        
                        <!---
                        <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t4">
                            <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                       </ul> -->
                    </li>
                <!---Your playlist end menu-->
                
                <!---Your Shopping Cart start menu-->
                    <li data-submenu-id="sub_t5">
                       <a href="<?php echo base_url(lang().'/cart/mypurchases'); ?>">Your Shopping Cart</a> 
                       <ul class="menu_inner  menusecond submenuItem"  id="sub_t5">
                          <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Shopping Cart</span></li>
                          <li> <a href="<?php echo base_url(lang().'/cart/mywishlist'); ?>" class="head" >Your Wish List </a></li>
                          <li> <a href="<?php echo base_url(lang().'/cart/mypurchases'); ?>" class="head" >Your Purchases</a></li>
                          <li>
                            <a href="<?php echo base_url(lang().'/cart/mysales'); ?>" class="head">Your Sales</a>
                            <ul class="sub_menu">
                                <li><a href="<?php echo base_url(lang().'/cart/mysales'); ?>">Sales</a></li>
                                <li><a href="<?php echo base_url(lang().'/cart/salesinformation'); ?>">Sales Information</a></li>
                             </ul>
                          </li>
                       </ul>
                    </li>
                 <!---Your Shopping Cart end menu-->
                
                <!---Your Membership start menu-->
                <?php 
                
                $selectedPacakge   =  (!empty($packageDetails->subscriptionType))?$packageDetails->subscriptionType:'';
                $packageStartDate  =  (!empty($packageDetails->startDate))?$packageDetails->startDate:'';
                $packageEndDate    =  (!empty($packageDetails->endDate))?$packageDetails->endDate:'';
                $packageSpace      =  (!empty($packageDetails->packageSpace))?$packageDetails->packageSpace:'';
                //get diffrence of date from subscription start date
                $startDateDiffrence = getSubscriptionDayDiff(1);
                //get diffrence of date from subscription end date
                $endDateDiffrence = getSubscriptionDayDiff(2);
                //set day limits 
                $degradeAfterDay = preg_replace("/[^0-9]/", '',$this->config->item('downgrade_button_after_day'));
                $renewBeforeDay = preg_replace("/[^0-9]/", '',$this->config->item('renew_button_before_day'));
                
                ?>
                    <li data-submenu-id="sub_t6">
                       <a href="<?php echo base_url(lang().'/package'); ?>">Your Membership</a> 
                       <ul class="menu_inner  menusecond submenuItem" id="sub_t6" >
                          <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table">
                              <span class="display_cell veti_midl"> Your Membership</span></li>
                            <!-- <li> <a href="<?php echo base_url(lang().'/package'); ?>" class="head">Free Membership - Upgrade</a> </li>
                            <li> <a href="#" class="head">Annual Membership – Renew Date or Renew</a> </li>
                            <li> <a href="#" class="head">3-year Membership – Renew Date or Renew</a> </li>-->
                          
                            <?php 
                                if($selectedPacakge==$this->config->item('package_type_1')){
                                  $membershipTitle =  $this->lang->line('package_title_1');
                                }elseif($selectedPacakge==$this->config->item('package_type_2')){
                                   $membershipTitle = $this->lang->line('package_title_2');
                                }elseif($selectedPacakge==$this->config->item('package_type_3')){
                                  $membershipTitle = $this->lang->line('package_title_3');
                                }
                            ?>   
                            
                            
                            <?php
                                if($selectedPacakge==$this->config->item('package_type_1')){ ?>
                                <li> <a href="<?php echo base_url(lang().'/package/upgradepackage/2'); ?>" class="head">Annual Membership – Upgrade</a> </li>
                            <?php } ?>
                             <?php  if($selectedPacakge==$this->config->item('package_type_1') || $selectedPacakge==$this->config->item('package_type_2')){ ?>
                                <li> <a href="<?php echo base_url(lang().'/package/upgradepackage/3'); ?>" class="head">3-year Membership – Upgrade</a> </li>
                            <?php } ?>
                             
                             
                             <?php
                                 $renewDay                 =  $this->config->item('renew_button_before_day');
                                 $renewDate                =  date('d-M-Y', strtotime($renewDay, strtotime($packageEndDate)));
                                 $renewDateStrtotime       =  strtotime($renewDate);
                                 $currentDateStrtotime     =  time();
                            ?>
                            <?php  if($renewDateStrtotime <= $currentDateStrtotime && !empty($packageEndDate)){ ?>
                                <li>
                                    <a href="<?php echo base_url('/package/renewstageone/1'); ?>" class="head"><?php echo $membershipTitle; ?> –  <?php echo $renewDate; ?> or Renew</a> 
                                </li>
                            <?php } ?>  
                            
                            <?php  if(($selectedPacakge == $this->config->item('package_type_3') || $selectedPacakge == $this->config->item('package_type_2'))) { ?>
                                <li> <a href="javascript:void(0)" class="head">Membership Renew  Date –  <?php echo $renewDate; ?></a> </li>
                            <?php } ?>  
                              
                            <?php  if(($selectedPacakge == $this->config->item('package_type_3') || $selectedPacakge == $this->config->item('package_type_2')) && ($startDateDiffrence <= $degradeAfterDay)) { ?>
                                     <li> <a href="<?php echo base_url('/package/refundpackage'); ?>" class="head"><?php echo $membershipTitle; ?> – Refund Membership </a> </li>
                            <?php } ?>


                            <?php  if(($selectedPacakge == $this->config->item('package_type_3') || $selectedPacakge == $this->config->item('package_type_2')) && ($startDateDiffrence <= $degradeAfterDay  || $endDateDiffrence <= $renewBeforeDay)) { ?>
                           
                                <?php  if($selectedPacakge == $this->config->item('package_type_3')) { ?>
                                     <li> <a href="<?php echo base_url('/package/degradepackage/2');?>" class="head"><?php echo $membershipTitle; ?> – Downgrade to 1 Year</a> </li>
                                <?php } ?>
                               
                                <li> <a href="<?php echo base_url('/package/degradepackage/1');?>" class="head"><?php echo $membershipTitle; ?> – Downgrade to Free</a> </li>
                            
                            <?php } ?>
                             
                       </ul>
                    </li>
                <!---Your Membership end menu-->
               
                <!---Your Global Settings start menu-->
                    <li data-submenu-id="sub_t7">
                       <a href="<?php echo base_url(lang().'/dashboard/globalsettings'); ?>">Your Global Settings</a> 
                       <ul class="menu_inner  menusecond submenuItem" id="sub_t7" >
                          <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl"> Your Membership Settings</span></li>
                          <li>
                             <a href="<?php echo base_url(lang().'/dashboard/globalsettings/1'); ?>" class="head">Your Membership Settings</a>
                             <ul class="sub_menu">
                                <li><a href="<?php echo base_url(lang().'/dashboard/globalsettings/1'); ?>"> Your Contact Details</a></li>
                                <li><a href="<?php echo base_url(lang().'/dashboard/globalsettings/1'); ?>">Your Search Preferences</a></li>
                                <li><a href="<?php echo base_url(lang().'/dashboard/globalsettings/1'); ?>">Delete your Account</a></li>
                             </ul>
                          </li>
                          <li>
                            <a href="<?php echo base_url(lang().'/dashboard/globalsettings/2'); ?>" class="head">Your Social Media</a>
                             <ul class="sub_menu">
                                <li><a href="<?php echo base_url(lang().'/dashboard/globalsettings/2'); ?>">Your Social Media Sites</a></li>
                             </ul>
                          </li>
                          <li>
                             <a href="<?php echo base_url(lang().'/dashboard/globalsettings/3'); ?>" class="head">Your Buyer Settings</a>
                             <ul class="sub_menu">
                                <li><a href="<?php echo base_url(lang().'/dashboard/globalsettings/3'); ?>">Your Billing Details</a></li>
                                <li><a href="<?php echo base_url(lang().'/dashboard/globalsettings/3'); ?>">Your Shipping Details</a></li>
                             </ul>
                          </li>
                          <li>
                             <a href="<?php echo base_url(lang().'/dashboard/globalsettings/4'); ?>" class="head">Your Seller Settings</a>
                             <ul class="sub_menu">
                                <li><a href="<?php echo base_url(lang().'/dashboard/globalsettings/4'); ?>">Your Currency </a></li>
                                <li><a href="<?php echo base_url(lang().'/dashboard/globalsettings/4'); ?>">Your Consumption Tax Settings</a></li>
                                <li><a href="<?php echo base_url(lang().'/dashboard/globalsettings/4'); ?>">Your PayPayl Details</a></li>
                                <li><a href="<?php echo base_url(lang().'/dashboard/globalsettings/4'); ?>">Your Seller Details</a></li>
                                <li><a href="<?php echo base_url(lang().'/dashboard/globalsettings/4'); ?>">Your Shipping</a></li>
                             </ul>
                          </li>
                       </ul>
                    </li>
                <!---Your Global Settings start menu-->
                
                <li class="bd_t  pb10"> </li>
                <li data-submenu-id="sub_t8">
                   <a href="#">Your Showcase Homepage</a> 
                  
                   <ul class="menu_inner  menusecond submenuItem " id="sub_t8" >
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl"> Your Showcase Homepage</span></li>
                      <li>
                         <a href="#" class="head" >Your Showcase Homepage</a>
                        <?php 
                            // set showcase links
                            $creative     = LoginUserDetails('creative');
                            $professional = LoginUserDetails('associatedProfessional'); 
                            $enterprise   = LoginUserDetails('enterprise'); 
                            $fans         = LoginUserDetails('fans'); 
                            $showcaseDisableCls = 'disable';
                            $disableUrl = 'javascript:void(0);';
                            if($creative=='t' || $professional=='t' || $enterprise=='t' || $fans=='t') {
                                // set showcase active status
                                $showcaseDisableCls = '';
                                $addOtherLangUrl = base_url(lang().'/showcase/addotherlanguage');
                                $viewShowcaseUrl = base_url(lang().'/showcase');
                                $publiciseUrl = base_url(lang().'/showcase/publishshowcase');
                            }
                        ?>
                         <ul class="sub_menu">
                            <li class="<?php echo $showcaseDisableCls;?>"><a href="<?php echo (isset($addOtherLangUrl))?$addOtherLangUrl:$disableUrl;?>">Introduce your Homepage in another Language</a></li>
                            <li class="<?php echo $showcaseDisableCls;?>"><a href="<?php echo (isset($publiciseUrl))?$publiciseUrl:$disableUrl;?>">Publicise your Homepage</a></li>
                            <?php if(!empty($showcaseDisableCls)) { ?>
                                <li><a href="<?php echo base_url(lang().'/showcase/showcasetype');?>" >Add your Homepage</a></li>
                            <?php } else { ?>
                                <li class="<?php echo $showcaseDisableCls;?>"><a href="<?php echo base_url(lang().'/showcase/editshowcase');?>" >Edit your Homepage</a></li>
                            <?php } ?>
                            <li class="<?php echo $showcaseDisableCls;?>"><a href="<?php echo (isset($viewShowcaseUrl))?$viewShowcaseUrl:$disableUrl;?>" >View your Homepage</a></li>
                         </ul>
                      </li>
                   </ul>
                   
                    <!--<ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t8">
                            <li><img src="<?php //echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                       </ul>-->
                
                </li>
                <li data-submenu-id="sub_t9">
                   <a href="#">Your Media Showcases</a> 
                   <ul class="menu_inner  menusecond submenuItem" id="sub_t9" >
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Media Showcases</span></li>
                      
                        <?php
                            $filmNvideoDisabled = 'disable';
                            if(in_array('filmNvideo',$showcaseMediaList)){
                                    $filmNvideoDisabled = '';
                            }
                        ?>
                      <li>
                         <a href="#" class="head" >Your Film &amp; Video Showcase</a>
                         <ul class="sub_menu">
                            <li> <a href="<?php echo base_url(lang().'/media/filmvideo'); ?>"><span>Add</span> a Film &amp; Video Collection</a></li>
                            <li class="<?php echo $filmNvideoDisabled ; ?>"> <a href="<?php echo base_url(lang().'/media/filmvideo/publicisemediacollection'); ?>">Publicise your Film &amp; Video Collection</a></li>
                            <li class="<?php echo $filmNvideoDisabled ; ?>"> <a href="<?php echo base_url(lang().'/media/filmvideo/editmediacollection'); ?>">Edit your Film &amp; Video Collection</a></li>
                            <li class="<?php echo $filmNvideoDisabled ; ?>"> <a href="<?php echo base_url_lang('mediafrontend/filmvideocollection/'.$userId); ?>" >View your Film &amp; Video Collection </a></li>
                         </ul>
                      </li>
                      <li>
                        <?php
                            $photographyNartDisabled = 'disable';
                            if(in_array('photographyNart',$showcaseMediaList)){
                                    $photographyNartDisabled = '';
                            }
                        ?>
                         <a href="#" class="head" >Photography &amp; Art </a>
                         <ul class="sub_menu">
                            <li> <a href="<?php echo base_url(lang().'/media/photographyart/'.$this->config->item('PaAlbumCatId')); ?>"><span>Add</span> a Photography Album</a></li>
                            <li> <a href="<?php echo base_url(lang().'/media/photographyart/'.$this->config->item('PaCollectionCatId')); ?>"><span>Add</span> a Art Collection</a></li>
                            <li class="<?php echo $photographyNartDisabled ; ?>"> <a href="<?php echo base_url(lang().'/media/photographyart/publicisemediacollection'); ?>" class="">Publicise your Photography &amp; Art Collection </a></li>
                            <li class="<?php echo $photographyNartDisabled ; ?>"> <a href="<?php echo base_url(lang().'/media/photographyart/editmediacollection'); ?>" class="">Edit your Photography &amp; Art Collection</a></li>
                            <li class="<?php echo $photographyNartDisabled ; ?>"> <a href="<?php echo base_url_lang('mediafrontend/photoartcollection/'.$userId); ?>" >View your Photography &amp; Art Collection </a></li>
                         </ul>
                      </li>
                      <li class="bbe2e2e2 mt20 "> </li>
                      <li class="disable">
                            <?php
                                $musicNaudioDisabled = 'disable';
                                if(in_array('musicNaudio',$showcaseMediaList)){
                                        $musicNaudioDisabled = '';
                                }
                            ?>
                         <a href="#" class="head">Your Music &amp; Audio Showcase</a>
                         <ul class="sub_menu">
                            <li> <a href="<?php echo base_url(lang().'/media/musicaudio/'.$this->config->item('MaAlbumCatId')); ?>"><span>Add</span> a Music Album</a></li>
                            <li> <a href="<?php echo base_url(lang().'/media/musicaudio/'.$this->config->item('MaCollectionCatId')); ?>"><span>Add</span> a  Audio Collection</a></li>
                            <li class="<?php echo $musicNaudioDisabled; ?>"> <a href="<?php echo base_url(lang().'/media/musicaudio/publicisemediacollection'); ?>" class="">Publicise your Music &amp; Audio Collection</a></li>
                            <li class="<?php echo $musicNaudioDisabled; ?>"> <a href="<?php echo base_url(lang().'/media/musicaudio/editmediacollection'); ?>" class="">Edit your Music &amp; Audio Collection</a></li>
                            <li class="<?php echo $musicNaudioDisabled; ?>"> <a href="<?php echo base_url_lang('mediafrontend/musicaudiocollection/'.$userId); ?>" class="">View your Music &amp; Audio Collection</a></li>
                         </ul>
                      </li>
                      <li class="disable">
                            <?php
                                $writingNpublishingDisabled = 'disable';
                                if(in_array('writingNpublishing',$showcaseMediaList)){
                                        $writingNpublishingDisabled = '';
                                }
                            ?>
                         <a href="#" class="head">Your Writing &amp; Publishing Showcase</a>
                         <ul class="sub_menu">
                            <li> <a href="<?php echo base_url(lang().'/media/writingpublishing'); ?>"><span>Add</span> a Writing  &amp; Publishing Collection </a></li>
                            <li class="<?php echo $musicNaudioDisabled; ?>"> <a href="<?php echo base_url(lang().'/media/writingpublishing/publicisemediacollection'); ?>" class="">Publicise your Writing &amp; Publishing Collection </a></li>
                            <li class="<?php echo $musicNaudioDisabled; ?>"> <a href="<?php echo base_url(lang().'/media/writingpublishing/editmediacollection'); ?>" class="">Edit your Writing &amp; Publishing Collection</a></li>
                            <li class="<?php echo $musicNaudioDisabled; ?>"> <a href="<?php echo base_url_lang('mediafrontend/writingpubcollection/'.$userId); ?>" class="">View your Writing &amp; Publishing Collection </a></li>
                         </ul>
                      </li>
                      <li class="disable">
                          <?php
                                $educationMaterialDisabled = 'disable';
                                if(in_array('educationMaterial',$showcaseMediaList)){
                                        $educationMaterialDisabled = '';
                                }
                            ?>
                         <a href="#" class="head"> Your Creative-Industry Education</a>
                         <ul class="sub_menu">
                            <li> <a href="<?php echo base_url(lang().'/media/educationmaterials'); ?>"><span>Add</span> a Creative-Industry Educational Collection</a></li>
                            <li class="<?php echo $musicNaudioDisabled; ?>"> <a href="<?php echo base_url(lang().'/media/educationmaterials/publicisemediacollection'); ?>" class="">Publicise your Creative-Industry Educational Collection</a></li>
                            <li class="<?php echo $musicNaudioDisabled; ?>"> <a href="<?php echo base_url(lang().'/media/educationmaterials/editmediacollection'); ?>" class="">Edit your Creative-Industry Educational Collection</a></li>
                            <li class="<?php echo $musicNaudioDisabled; ?>"> <a href="<?php echo base_url_lang('mediafrontend/educationalcollection/'.$userId); ?>" class="">View your Creative-Industry Educational Collection</a></li>
                         </ul>
                      </li>
                   </ul>
                </li>
                <li data-submenu-id="sub_t10">
                   <a href="#">Your Competition Entries </a> 
                   <!--
                   <ul class="menu_inner  menusecond submenuItem"  id="sub_t10">
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Competition Entries</span></li>
                      <li>
                         <a href="#">Add a Competition</a>
                         <ul>
                            <li><a href="#">Enter a Film &amp; Video Competition </a></li>
                            <li><a href="#">Enter a Music &amp; Audio Competition </a></li>
                            <li><a href="#">Enter a Performing Arts Competition </a></li>
                            <li><a href="#">Enter a Photography &amp; Art Competition </a></li>
                            <li><a href="#">Enter a Writing &amp; Publishing Competition</a></li>
                            <li><a href="#">Publicise your Competition Entries</a></li>
                            <li><a href="#">View your Competition Entries</a></li>
                            <li><a href="#">View your Craved Competitions Entries &amp; Vote for them </a></li>
                         </ul>
                      </li>
                   </ul>
                    -->
                    <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t10">
                            <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                       </ul> 
                
                </li>
                <li class=" shadow_inset pt5 bg-non mt12"> </li>
             
             <li data-submenu-id="sub_t11" class="bg_f1f1f1 pt15">
                   <a href="#"><span>Add</span> a Blog</a>
                   <!--
                   <ul class="menu_inner  menusecond submenuItem"  id="sub_t11">
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl"> Your Blog</span></li>
                      <li>
                         <a href="#">Add a Blog</a>
                         <ul>
                            <li> <a href="#">Add a Post </a></li>
                            <li> <a href="#">Publicise your Posts</a></li>
                            <li> <a href="#">Edit your Posts &amp; your Blog</a></li>
                            <li> <a href="#">View your Blog</a></li>
                         </ul>
                      </li>
                   </ul>
                    -->
                    <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t11">
                            <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                       </ul> 
                </li>
                
                <li data-submenu-id="sub_t12" class="bg_f1f1f1">
                    <a href="#"><span>Add</span> a News Collection</a> 
                  <ul class="menu_inner  menusecond submenuItem" id="sub_t12" >
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl"> Your News Collection</span></li>
                      <li>
                         <a href="#">Add a News Collection</a>
                         <ul>
                            <li> <a href="<?php echo base_url(lang().'/media/newswizard'); ?>"><span>Add</span> an Article </a></li>
                            <li> <a href="<?php echo base_url(lang().'/media/editwizardcollection/news'); ?>">Edit your Collection</a></li>
                            <li class="disable"> <a href="<?php echo base_url(lang().'/mediafrontend/newscollection'.$userId); ?>">View your Collection</a></li>
                         </ul>
                      </li>
                    </ul>
                </li>
             
                <li data-submenu-id="sub_t13" class="bg_f1f1f1">
                    <a href="#"><span>Add</span> a Reviews Collection</a> 
                   <ul class="menu_inner  menusecond submenuItem" id="sub_t13" >
                        <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Reviews Collection</span></li>
                        <li>
                            <a href="">Add a Reviews Collection</a>
                            <ul>
                                <li> <a href="<?php echo base_url(lang().'/media/reviewswizard'); ?>"><span>Add</span> a Review </a></li>
                                <li> <a href="<?php echo base_url(lang().'/media/editwizardcollection/reviews'); ?>">Edit your Collection </a></li>
                                <li class="disable"> <a href="<?php echo base_url(lang().'/mediafrontend/reviewscollection'.$userId); ?>">View your Collection </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                
               <li data-submenu-id="sub_t14" class="bg_f1f1f1">
                   <a href="#"><span>Add</span> an Event</a> 
                   <!--
                   <ul class="menu_inner  menusecond submenuItem" id="sub_t14" >
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Performances &amp; Events</span></li>
                      <li>
                         <a href="#" class="head" >Your Film &amp; Video Events</a>
                         <ul class="sub_menu">
                            <li> <a href="#"><span>Add</span> a Film &amp; Video Event</a></li>
                            <li> <a href="#">Publicise your Film &amp; Video Events</a></li>
                            <li> <a href="#">Edit your Film &amp; Video Events</a></li>
                            <li> <a href="#">View your Film &amp; Video Events </a></li>
                         </ul>
                      </li>
                      <li>
                         <a href="#" class="head" >Photography &amp; Art </a>
                         <ul class="sub_menu">
                            <li> <a href="#"><span>Add</span> a Photography &amp; Art Event</a></li>
                            <li> <a href="#">Publicise your Photography &amp; Art Events </a></li>
                            <li> <a href="#">Edit your Photography &amp; Art Events</a></li>
                            <li> <a href="#">View your Photography &amp; Art Events </a></li>
                         </ul>
                      </li>
                      <li>
                         <a href="#" class="head" >Music &amp; Audio </a>
                         <ul class="sub_menu">
                            <li> <a href="#"><span>Add</span> a Performing Arts Event</a></li>
                            <li class="disable"> <a href="#">Publicise your Performing Arts Events</a></li>
                            <li class="disable"> <a href="#">Edit your Performing Arts Events</a></li>
                            <li class="disable"> <a href="#">View your Performing Arts Events </a></li>
                         </ul>
                      </li>
                      <li>
                         <a href="#" class="head">Writing &amp; Publishing </a>
                         <ul class="sub_menu">
                            <li> <a href="#"><span>Add</span> a Music &amp; Audio Event</a></li>
                            <li class="disable"> <a href="#">Publicise your Music &amp; Audio Events</a></li>
                            <li class="disable"> <a href="#">Edit your Music &amp; Audio Events</a></li>
                            <li class="disable"> <a href="#">View your Music &amp; Audio Events</a></li>
                         </ul>
                      </li>
                      <li>
                         <a href="#" class="head">Educational Material </a>
                         <ul class="sub_menu">
                            <li> <a href="#"><span>Add</span> a Writing  &amp; Publishing Event </a></li>
                            <li class="disable"> <a href="#">Publicise your Writing &amp; Publishing Events </a></li>
                            <li class="disable"> <a href="#">Edit your Writing &amp; Publishing Events</a></li>
                            <li class="disable"> <a href="#">View your Writing &amp; Publishing Events </a></li>
                         </ul>
                      </li>
                      <li>
                         <a href="#" class="head"> Your Creative-Industry Educational Events</a>
                         <ul class="sub_menu">
                            <li> <a href="#"><span>Add</span> a Creative-Industry Educational Event</a></li>
                            <li class="disable"> <a href="#">Publicise your Creative-Industry Educational Events</a></li>
                            <li class="disable"> <a href="#">Edit your Creative-Industry Educational Events</a></li>
                            <li class="disable"> <a href="#">View your Creative-Industry Educational Events</a></li>
                         </ul>
                      </li>
                   </ul>
                    -->
                    <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t14">
                            <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                       </ul> 
                </li>
              <li data-submenu-id="sub_t15" class="bg_f1f1f1">
                   <a href="#"><span>Share</span> Notice of an Event</a> 
                  <!--
                   <ul class="menu_inner  menusecond submenuItem"  id="sub_t15">
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl"> Your Event Notices</span></li>
                      <li>
                         <a href="#"> Share Notice of an Event </a>
                         <ul>
                            <li><a href="#">Share Notice of a Film &amp; Video Event</a></li>
                            <li><a href="#">Share Notice of a Music &amp; Audio Event</a></li>
                            <li><a href="#">Share Notice of a Performing Arts Event</a></li>
                            <li><a href="#">Share Notice of a Photography &amp; Art Event</a></li>
                            <li><a href="#">Share Notice of a Writing &amp; Publishing Event</a></li>
                            <li><a href="#">Share Notice of a Creative-Industry Educational Event</a></li>
                            <li><a href="#">Edit your Event Notices</a></li>
                            <li><a href="#">View you Event Notices </a></li>
                         </ul>
                      </li>
                   </ul>
                    -->
                    <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t15">
                            <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                       </ul> 
                </li>
               <li data-submenu-id="sub_t16" class="bg_f1f1f1">
                   <a href="#"><span>Add</span> an Upcoming Media Showcase</a> 
                <!--
                   <ul class="menu_inner  menusecond submenuItem"  id="sub_t16">
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Upcoming Media Showcase</span></li>
                      <li>
                         <a href="#">	Add an Upcoming Media Showcase</a>
                         <ul>
                            <li><a href="#">Showcase your Upcoming Films &amp; Videos</a></li>
                            <li><a href="#">Showcase your Upcoming Music &amp; Audio </a></li>
                            <li><a href="#">Showcase Upcoming Photos &amp; Art </a></li>
                            <li><a href="#">Showcase Upcoming Writings</a></li>
                            <li><a href="#">Showcase Upcoming Creative-Industry Education</a></li>
                            <li><a href="#">Publicise your Upcoming Media </a></li>
                            <li><a href="#">Edit your Upcoming Media </a></li>
                            <li><a href="#">View your Upcoming Media </a></li>
                         </ul>
                      </li>
                   </ul>
                -->
                <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t16">
                    <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                </ul> 
                </li>
                <li data-submenu-id="sub_t17" class="bg_f1f1f1">
                   <a href="#"><span>Add</span> an Upcoming Event</a> 
                   <!--
                   <ul class="menu_inner  menusecond submenuItem"  id="sub_t17">
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Upcoming Events</span></li>
                      <li>
                         <a href="#">	Add an Upcoming Event</a>
                         <ul>
                            <li><a href="#"><span>Add</span> an Upcoming Film &amp; Video Event</a></li>
                            <li><a href="#"><span>Add</span> an Upcoming Music &amp; Audio Event</a></li>
                            <li><a href="#"><span>Add</span> an Upcoming Photos &amp; Art Event</a></li>
                            <li><a href="#"><span>Add</span> an Upcoming Writing &amp; Publishing Event</a></li>
                            <li><a href="#"><span>Add</span> an Upcoming Creative-Industry Education Event</a></li>
                            <li><a href="#">Publicise your Upcoming Events </a></li>
                            <li><a href="#">Edit your Upcoming Events</a></li>
                            <li><a href="#">View your Upcoming Events </a></li>
                         </ul>
                      </li>
                   </ul>
                    -->
                    <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t17">
                    <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                    </ul> 
                </li>
                <li data-submenu-id="sub_t18" class="bg_f1f1f1">
                   <a href="#"><span>Add</span> a Competition</a> 
                   <!--
                   <ul class="menu_inner  menusecond submenuItem" id="sub_t18" >
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Competition Entries</span></li>
                      <li>
                         <a href="#">Add a Competition</a>
                         <ul>
                            <li><a href="#"><span>Add</span> a Film &amp; Video Competition</a></li>
                            <li><a href="#"><span>Add</span> a Music &amp; Audio Competition</a></li>
                            <li><a href="#"><span>Add</span> a Performing Arts Competition</a></li>
                            <li><a href="#"><span>Add</span> a Photography &amp; Art Competition</a></li>
                            <li><a href="#"><span>Add</span> a Writing &amp; Publishing Competition</a></li>
                            <li><a href="#">Publicise your Competitions </a></li>
                            <li><a href="#">Edit your Competitions</a></li>
                            <li><a href="#">View your Competitions</a></li>
                            <li class="bd_t pb10"> </li>
                            <li><a href="#">View your Craved Competitions &amp; Enter or Vote</a></li>
                         </ul>
                      </li>
                   </ul>
                    -->
                    <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t18">
                        <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                    </ul> 
                </li>
                <li data-submenu-id="sub_t19" class="bg_f1f1f1">
                   <a href="#"><span>Add</span> your Work Profile</a> 
                   <!--
                   <ul class="menu_inner  menusecond submenuItem"  id="sub_t19">
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Work Profile</span></li>
                      <li>
                         <a href="#" class="head">Add your Work Profile</a>
                         <ul class="sub_menu">
                            <li><a href="#">Email your Work Profile</a></li>
                            <li><a href="#">Edit your Work Profiles</a></li>
                            <li><a href="#">View your Work Profile</a></li>
                            <li><a href="#"> Download the Work Profile App. </a></li>
                         </ul>
                      </li>
                   </ul>
                    -->
                    <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t19">
                        <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                    </ul> 
                </li>
                <li data-submenu-id="sub_t20" class="bg_f1f1f1">
                   <a href="#"><span>Add</span> a Work Classified</a> 
                   <!--
                   <ul  class="menu_inner  menusecond submenuItem"  id="sub_t20">
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Work Classifieds</span></li>
                      <li>
                         <a href="#" class="head">Your Work-Offered Classifieds </a>
                         <ul class="sub_menu">
                            <li><a href="#"><span>Add</span> an URGENT-Work-Offered Classified</a></li>
                            <li><a href="#"><span>Add</span> a Work-Experience-Offered Classified</a></li>
                            <li><a href="#"><span>Add</span> a Work-Offered Classified</a></li>
                            <li class="bd_t pb10"> </li>
                            <li><a href="#">Publicise your Work-Offered Classifieds </a></li>
                            <li><a href="#">Edit your Work-Offered Classifieds</a></li>
                            <li><a href="#">View your Work-Offered Classifieds</a></li>
                            <li class="bd_t pb10"> </li>
                            <li><a href="#">View Applications to your Work-Offered Classifieds</a></li>
                            <li><a href="#">View your craved Work-Wanted Classifieds &amp; Apply</a></li>
                         </ul>
                      </li>
                      <li>
                         <a href="#">Your Work-Wanted Classifieds</a>
                         <ul>
                            <li><a href="#"><span>Add</span> a Work-Experience-Wanted Classified</a></li>
                            <li><a href="#"><span>Add</span> a Work-Wanted Classified</a></li>
                            <li><a href="#">Publicise your Work-Wanted Classifieds </a></li>
                            <li><a href="#">Edit your Work-Wanted Classifieds</a></li>
                            <li><a href="#">View your Work-Wanted Classifieds</a></li>
                            <li class="bd_t pb10"> </li>
                            <li><a href="#">View your Applications</a></li>
                            <li><a href="#">View your craved Work-Offered Classified</a></li>
                         </ul>
                      </li>
                   </ul>
                    -->
                    <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t20">
                    <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                </ul> 
                
                </li>
               <li data-submenu-id="sub_t21" class="bg_f1f1f1">
                   <a href="#"><span>Add</span> Product Classifieds </a> 
                   <!--
                   <ul  class="menu_inner  menusecond submenuItem"  id="sub_t21">
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Product Classifieds</span></li>
                      <li>
                         <a href="#" class="head">Add a Product-for-Sale Classified</a>
                         <ul class="sub_menu">
                            <li><a href="#">View your craved Product-for-Sale Classifieds &amp; Buy</a></li>
                         </ul>
                      </li>
                      <li>
                         <a href="#" class="head">Add a Product-Wanted Classified</a>
                         <ul class="sub_menu">
                            <li><a href="#">View your craved Product-Wanted Classifieds &amp; Buy</a></li>
                         </ul>
                      </li>
                      <li>
                         <a href="#">Publicise your Product Classifieds </a> 
                      </li>
                      <li>
                         <a href="#">Edit your Product Classifieds</a> 
                      </li>
                      <li>
                         <a href="#">View your Product Classifieds</a> 
                      </li>
                   </ul>
                    -->
                    <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t21">
                    <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                </ul> 
                </li>
             <li data-submenu-id="sub_t22" class="bg_f1f1f1">
                   <a href="#"><span>Add</span> a Collaboration</a> 
                   <!--
                   <ul  class="menu_inner  menusecond submenuItem" id="sub_t22" >
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Collaborations</span></li>
                      <li>
                         <a href="#" class="head">Your Have XX new Messages </a>
                         <ul class="sub_menu">
                            <li><a href="#">View</a></li>
                            <li><a href="#">Work</a></li>
                         </ul>
                      </li>
                      <li>
                         <a href="#" class="head">Collaborations you manage</a>
                         <ul class="sub_menu">
                            <li><a href="#"><span>Add</span> a Collaboration</a></li>
                            <li><a href="#">Edit your Collaborations</a></li>
                            <li><a href="#">View your Collaborations</a></li>
                         </ul>
                      </li>
                   </ul>
                    -->
                    <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t22">
                    <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                </ul> 
                </li>
               <li data-submenu-id="sub_t23" class="bg_f1f1f1">
                   <a href="#"><span> Add</span> an  Ad Campaign</a> 
                  <!--
                   <ul class="menu_inner  menusecond submenuItem"  id="sub_t23">
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Add Campaigns</span></li>
                      <li>
                         <a href="#" class="head" ><span>Add</span> an Ad Campaign</a>
                         <ul class="sub_menu">
                            <li><a href="#"><span>Add</span> an Ad Campaign</a></li>
                            <li><a href="#">Edit your Ad Campaigns</a></li>
                            <li><a href="#">Renew your Ad Campaign</a></li>
                         </ul>
                      </li>
                   </ul>
                   -->
                   
                   <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t23">
                    <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                </ul> 
                </li>
                <li data-submenu-id="sub_t24" class="bg_f1f1f1 pb15">
                   <a href="#"><span>Share</span> a Favourite Site</a>
                   
                   <!-- 
                   <ul class="menu_inner  menusecond submenuItem" id="sub_t24" >
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Your Favourite Sites</span></li>
                      <li>
                         <a href="#" class="head" >Share a Favourite Site </a>
                         <ul class="sub_menu">
                            <li><a href="#" ><span>Share</span> a Favourite Film &amp; Video Site</a></li>
                            <li><a href="#" ><span>Share</span> a Favourite Music &amp; Audio Site</a></li>
                            <li><a href="#"><span>Share</span> a Favourite Performing Arts Site</a></li>
                            <li><a href="#" ><span>Share</span> a Favourite Photography &amp; Art Site</a></li>
                            <li><a href="#" ><span>Share</span> a Favourite Writing &amp; Publishing Site</a></li>
                            <li><a href="#"><span>Share</span> a Favourite Creative-Industry Educational Site</a></li>
                            <li><a href="#" >Edit your Favourite Sites</a></li>
                            <li><a href="#">View your Favourite Sites</a></li>
                         </ul>
                      </li>
                   </ul>
                
                    -->
                    
                    <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t24">
                    <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                </ul> 
                </li>
                <li class="bd_t"> </li>
              <li class="blue_bottom pt25" data-submenu-id="sub_t25">
                   <a href="#">Invite a Friend to Join Toadsquare</a> 
                   <!--
                   <ul class="menu_inner  menusecond submenuItem" id="sub_t25" >
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Invite a Friend to Join Toadsquare</span></li>
                   </ul>
                   -->
                   <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t25">
                    <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                </ul> 
                </li>
              <li class="blue_bottom pb26" data-submenu-id="sub_t26" >
                   <a href="#">Feedback</a> 
                   <!--
                   <ul class="menu_inner  menusecond submenuItem" id="sub_t26" >
                      <li class=" fs20 font_bold clr_geern your_toad bg_f8f8f8 display_table"><span class="display_cell veti_midl">Feedback</span></li>
                   </ul>-->
                   
                   <ul class="comming_soon menu_inner popover  menusecond submenuItem" id="sub_t26">
                    <li><img src="<?php echo base_url('images/comming_soon.png')?>" alt=""  /></li>
                </ul> 
                </li>
             </ul>
          </div>
       </div>
    </div>

    
    <?php
}?>


<script>
    $(".navHeading").mouseover(function(){
        $('.submenuItem').css("display", "none");
    });
    
        // top nAVIGATION DELAY TIMTIG JS START
        var $menu = $(".dropdown-menu");
        // jQuery-menu-aim: <meaningful part of the example>
        // Hook up events to be fired on menu row activation.
        $menu.menuAim({
            activate: activateSubmenu,
            deactivate: deactivateSubmenu
        });
        // jQuery-menu-aim: </meaningful part of the example>

        // jQuery-menu-aim: the following JS is used to show and hide the submenu
        // contents. Again, this can be done in any number of ways. jQuery-menu-aim
        // doesn't care how you do this, it just fires the activate and deactivate
        // events at the right times so you know when to show and hide your submenus.
        function activateSubmenu(row) {
            var $row = $(row),
            submenuId = $row.data("submenuId"),
            $submenu = $("#" + submenuId),
            height = $menu.outerHeight(),
            width = $menu.outerWidth();

            $('.submenuItem').css("display", "none");
            $row.find("a").removeClass("maintainHover");
            // Show the submenu
            $submenu.css({
                display: "block",
                top: 1,
            // padding for main dropdown's arrow
            });

            // Keep the currently activated row's highlighted look
            $row.find("a").addClass("maintainHover");
        }

        function deactivateSubmenu(row) {
            var $row = $(row),
            submenuId = $row.data("submenuId"),
            $submenu = $("#" + submenuId);

            // Hide the submenu and remove the row's highlighted look
            $submenu.css("display", "none");
            $row.find("a").removeClass("maintainHover");
        }

        // Bootstrap's dropdown menus immediately close on document click.
        // Don't let this event close the menu if a submenu is being clicked.
        // This event propagation control doesn't belong in the menu-aim plugin
        // itself because the plugin is agnostic to bootstrap.
        $(".dropdown-menu li").click(function(e) {
            e.stopPropagation();
        });


        $("#displaynone").hover(function(){
            $(".popover").css("display", "none");
            $("a.maintainHover").removeClass("maintainHover");
        });

        $("#displaynone1").hover(function(){
            $(".popover").css("display", "none");
            $("a.maintainHover").removeClass("maintainHover");
        });


        // top nAVIGATION DELAY TIMTIG JS END
    </script>
