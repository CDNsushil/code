<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="cssmenu" >
   <ul>
      <li class="has-sub last gotobtnli navHeading"> <a href='javascript:void(0)'><span class="gotobtn ff_arial"><?php echo $this->lang->line('Goto');?><img src="<?php echo $imgPath; ?>dropdownarrow.png" alt="" /></span></a> </li>
   </ul>
   <div class="menuslideup  ">
      <div class="externalpanel firstcontainer  radius4	">
         <div class="go_to fs18 font_bold bg_f1592a clr_fff display_table" ><span class="pl30 display_cell veti_midl">Go To</span></div>
        <div class="container">
            <ul class="menu_wrap dropdown-menu">
             <li class="hov_menu bg-non pb20"></li>
               <li data-submenu-id="sub1">
               <a href="<?php echo base_url(lang().'/creatives'); ?>"><?php echo $this->lang->line('memberShowcases');?></a> 
               <ul class="popover dropdown-menu first_main submenuItem" id="sub1">
                  <li class="go_to hov_menu fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('memberShowcases');?></span></li>
                  <li data-submenu-id="sub1_1">
                     <a href="<?php echo base_url(lang().'/creatives'); ?>"><?php echo $this->lang->line('creatives');?></a>
                     <ul class="first_ul" id="sub1_1">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table">
                            <span class="pl36 fs18 display_cell veti_midl"><?php echo $this->lang->line('creatives');?></span>
                        </li>
                        <li><a href="<?php echo base_url(lang().'/creatives/filmvideo'); ?>"><?php echo $this->lang->line('FvCreatives');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/creatives/performingarts'); ?>"><?php echo $this->lang->line('ArtCreatives');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/creatives/photographyart'); ?>"><?php echo $this->lang->line('PaCreatives');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/creatives/musicaudio'); ?>"><?php echo $this->lang->line('MaCreatives');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/creatives/writingpublishing'); ?>"><?php echo $this->lang->line('WpCreatives');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/creatives/reviews'); ?>"><?php echo $this->lang->line('reviewsCreatives');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/creatives/news'); ?>"><?php echo $this->lang->line('newsCreatives');?> </a>
                        </li>
                     </ul>
                   
                      <?php 
                        // load serach form
                        $searchFromData['formName']  = 'creatives';
                        $searchFromData['sectionId'] = '6';
                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                      ?>
                    
                  </li>
                  
                 <li data-submenu-id="sub1_2">
                     <a href="<?php echo base_url(lang().'/associateprofessional'); ?>"><?php echo $this->lang->line('professionalsCreativeIndustries');?></a>
                     <ul class="submenuItem"  id="sub1_2">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl"><?php echo $this->lang->line('professionalsCreativeIndustries');?></span></li>
                        <li><a href="<?php echo base_url(lang().'/associateprofessional/filmvideo'); ?>"><?php echo $this->lang->line('FvProfessionals');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/associateprofessional/performingarts'); ?>"><?php echo $this->lang->line('ArtProfessionals');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/associateprofessional/photographyart'); ?>"><?php echo $this->lang->line('PaProfessionals');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/associateprofessional/musicaudio'); ?>"><?php echo $this->lang->line('MaProfessionals');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/associateprofessional/writingpublishing'); ?>"><?php echo $this->lang->line('WpProfessionals');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/associateprofessional/reviews'); ?>"><?php echo $this->lang->line('reviewsProfessionals');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/associateprofessional/news'); ?>"><?php echo $this->lang->line('newsProfessionals');?></a> 
                        </li>
                     </ul>
                     
                 
                  </li>
                  
                 <li data-submenu-id="sub1_3">
                     <a href="<?php echo base_url(lang().'/enterprises'); ?>"><?php echo $this->lang->line('businessesCreativeIndustries');?></a>
                     <ul class="submenuItem" id="sub1_3">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl"><?php echo $this->lang->line('businessesCreativeIndustries');?></span></li>
                        <li ><a href="<?php echo base_url(lang().'/enterprises/filmvideo'); ?>"><?php echo $this->lang->line('FvBusinesses');?></a></li>
                        <li ><a href="<?php echo base_url(lang().'/enterprises/performingarts'); ?>"><?php echo $this->lang->line('ArtBusinesses');?></a> </li>
                        <li ><a href="<?php echo base_url(lang().'/enterprises/photographyart'); ?>"><?php echo $this->lang->line('PaBusinesses');?></a></li>
                        <li ><a href="<?php echo base_url(lang().'/enterprises/musicaudio'); ?>"><?php echo $this->lang->line('MaBusinesses');?></a></li>
                        <li ><a href="<?php echo base_url(lang().'/enterprises/writingpublishing'); ?>"><?php echo $this->lang->line('WpBusinesses');?></a> </li>
                        <li ><a href="<?php echo base_url(lang().'/enterprises/reviews'); ?>"><?php echo $this->lang->line('reviewsBusinesses');?></a></li>
                        <li >
                           <a href="<?php echo base_url(lang().'/enterprises'); ?>"><?php echo $this->lang->line('newsBusinesses');?></a>
                        </li>
                     </ul>
                  </li>
                  
                 <li data-submenu-id="sub1_4">
                     <a href="<?php echo base_url(lang().'/fans'); ?>"><?php echo $this->lang->line('fansCreativeIndustries');?></a>
                     <ul class="submenuItem" id="sub1_4">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl"><?php echo $this->lang->line('fansCreativeIndustries');?></span></li>
                        <!--<li><a href="<?php echo base_url(lang().'/fans/filmvideo'); ?>"><?php echo $this->lang->line('FvFans');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/fans/performingarts'); ?>"><?php echo $this->lang->line('ArtFans');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/fans/photographyart'); ?>"><?php echo $this->lang->line('PaFans');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/fans/musicaudio'); ?>"><?php echo $this->lang->line('MaFans');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/fans/writingpublishing'); ?>"><?php echo $this->lang->line('WpFans');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/fans/reviews'); ?>"><?php echo $this->lang->line('reviewsFans');?></a></li>
                        <li><a href="<?php echo base_url(lang().'/fans/news'); ?>"><?php echo $this->lang->line('newsFans');?></a>
                        </li>-->
                     </ul> 
                  </li>
                  
               </ul>
            </li>
            <li data-submenu-id="sub2">
               <a href="<?php echo base_url(lang().'/filmnvideo'); ?>"><?php echo $this->lang->line('mediaShowcases');?></a> 
               <ul class="popover dropdown-menu" id="sub2">
                  <li class="go_to fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('mediaShowcases');?></span></li>
                 <li data-submenu-id="sub2_1">
                     <a href="<?php echo base_url(lang().'/filmnvideo'); ?>"><?php echo $this->lang->line('flimsNvideos');?></a>
                     <ul class="submenuItem" id="sub2_1">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl"><?php echo $this->lang->line('flimsNvideos');?></span></li>
                        <li> <a href="<?php echo base_url(lang().'/filmnvideo'); ?>"><?php echo $this->lang->line('FvCollections');?></a></li>
                        <li> <a href="<?php echo base_url(lang().'/filmnvideo/upcoming'); ?>"><?php echo $this->lang->line('FvCollectionUpcoming');?></a></li>
                        <li> <a href="<?php echo base_url(lang().'/filmnvideo/reviews'); ?>"><?php echo $this->lang->line('FvCollectionReviews');?></a></li>
                        <li> <a href="<?php echo base_url(lang().'/filmnvideo/news'); ?>"><?php echo $this->lang->line('FvCollectionNews');?></a>
                           <span class="toadicon"><img alt="toad" src="<?php echo $imgPath; ?>goto_image.png" class="img_toad" /></span>                                 
                        </li>
                     </ul>
                      <?php 
                        // load search form
                        $searchFromData['formName']  = 'filmNvideo';
                        $searchFromData['sectionId'] = '1';
                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                      ?>
                  </li>
                  <li data-submenu-id="sub2_2">
                     <a href="<?php echo base_url(lang().'/photographynart'); ?>">Photo &amp; Art </a>
                     <ul class="submenuItem" id="sub2_2">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Photo &amp; Art </span></li>
                        <li> <a href="<?php echo base_url(lang().'/photographynart'); ?>">Photography Albums </a></li>
                        <li> <a href="<?php echo base_url(lang().'/photographynart/collections'); ?>">Art Collections</a></li>
                        <li> <a href="<?php echo base_url(lang().'/photographynart/upcoming'); ?>">Upcoming Photos &amp; Art</a></li>
                        <li> <a href="<?php echo base_url(lang().'/photographynart/reviews'); ?>">Reviews of Photos &amp; Art</a></li>
                        <li> <a href="<?php echo base_url(lang().'/photographynart/news'); ?>">News about Photos &amp; Art</a>
                           <span class="toadicon"><img alt="toad" src="<?php echo $imgPath; ?>goto_image.png" class="img_toad" /></span>                                 
                        </li>
                     </ul>
                  </li>
                  <li data-submenu-id="sub2_3">
                     <a href="<?php echo base_url(lang().'/musicnaudio'); ?>">Music &amp; Audio</a>
                     <ul class="submenuItem" id="sub2_3">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Music &amp; Audio</span></li>
                        <li> <a href="<?php echo base_url(lang().'/musicnaudio'); ?>">Music Albums</a></li>
                        <li> <a href="<?php echo base_url(lang().'/musicnaudio/collections'); ?>">Audio Collections</a></li>
                        <li> <a href="<?php echo base_url(lang().'/musicnaudio/upcoming'); ?>">Upcoming Music &amp; Audio </a></li>
                        <li> <a href="<?php echo base_url(lang().'/musicnaudio/reviews'); ?>">Reviews of Music &amp; Audio</a></li>
                        <li> <a href="<?php echo base_url(lang().'/musicnaudio/news'); ?>">News about Music &amp; Audio</a>
                           <span class="toadicon"><img alt="toad" src="<?php echo $imgPath; ?>goto_image.png" class="img_toad" /></span>                                 
                        </li>
                     </ul>
                  </li>
                  <li data-submenu-id="sub2_4">
                     <a href="<?php echo base_url(lang().'/writingnpublishing'); ?>">Writing</a>
                     <ul class="submenuItem" id="sub2_4">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Writing</span></li>
                        <li> <a href="<?php echo base_url(lang().'/writingnpublishing'); ?>">Writing Collections</a></li>
                        <li> <a href="<?php echo base_url(lang().'/writingnpublishing/upcoming'); ?>">Upcoming Writings</a></li>
                        <li> <a href="<?php echo base_url(lang().'/writingnpublishing/reviews'); ?>">Reviews of Writings</a></li>
                        <li> <a href="<?php echo base_url(lang().'/writingnpublishing/news'); ?>">News about Writing &amp; Publishing </a>
                           <span class="toadicon"><img alt="toad" src="<?php echo $imgPath; ?>goto_image.png" class="img_toad" /></span>                                 
                        </li>
                     </ul>
                  </li>
                  <li data-submenu-id="sub2_5">
                     <a href="<?php echo base_url(lang().'/educationnmaterial'); ?>">Creative-Industry Education</a>
                     <ul class="submenuItem" id="sub2_5">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Creative-Industry Education</span></li>
                        <li> <a href="<?php echo base_url(lang().'/educationnmaterial'); ?>"> Creative-Industry Educational Collections</a></li>
                        <li> <a href="<?php echo base_url(lang().'/educationnmaterial/upcoming'); ?>">Upcoming Creative-Industry Education</a></li>
                        <li> <a href="<?php echo base_url(lang().'/educationnmaterial/reviews'); ?>">Reviews of Creative-Industry Education</a></li>
                        <li> <a href="<?php echo base_url(lang().'/educationnmaterial/news'); ?>">News about Creative-Industry Education</a>
                           <span class="toadicon"><img alt="toad" src="<?php echo $imgPath; ?>goto_image.png" class="img_toad" /></span>                                 
                        </li>
                     </ul>
                  </li>
               </ul>
            </li>
            <li data-submenu-id="sub3">
               <!--<a href="<?php echo base_url(lang().'/performancesnevents'); ?>">Performances &amp; Events</a>-->
               <a href="javascript:void(0);" onclick="customAlert('Coming Soon');">Performances &amp; Events</a> 
         <!--    
               <ul id="sub3">
                    <li class="go_to fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl">Performances &amp; Events</span></li>
                  <li data-submenu-id="sub3_1">
                     <a href="<?php echo base_url(lang().'/performancesnevents'); ?>">Film &amp; Video Events</a>
                     <ul class="submenuItem" id="sub3_1">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Film &amp; Video Events</span></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Film &amp; Video Events </a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');">Upcoming Film &amp; Video Events</a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');">Notices of Film &amp; Video Events </a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');">Reviews of Film &amp; Video Events</a></li>
                        <li>
                           <a href="javascript:void(0);" onclick="customAlert('Coming Soon');">News about Film &amp; Video Events </a>
                        </li>
                     </ul>
                      <?php 
                        // load search form
                        $searchFromData['formName']  = 'PerformancesNEvents';
                        $searchFromData['sectionId'] = '9';
                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                      ?>
                  </li>
                  <li data-submenu-id="sub3_2">
                     <a href="<?php echo base_url(lang().'/performancesnevents'); ?>">Performing Arts Events</a>
                     <ul class="submenuItem" id="sub3_2">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Performing Arts Events</span></li>
                        <li> <a href="<?php echo base_url(lang().'/performancesnevents'); ?>"> Performing Arts Events</a></li>
                        <li> <a href="<?php echo base_url(lang().'/performancesnevents'); ?>">Upcoming Performing Arts Events</a></li>
                        <li> <a href="<?php echo base_url(lang().'/performancesnevents'); ?>">Notices of Performing Arts Events</a></li>
                        <li> <a href="<?php echo base_url(lang().'/performancesnevents'); ?>">Reviews of Performing Arts Events</a></li>
                        <li>
                           <a href="javascript:void(0);" onclick="customAlert('Coming Soon');">News about Performing Arts Events</a>
                        </li>
                     </ul>
                  </li>
                  <li  data-submenu-id="sub3_3">
                     <a href="javascript:void(0);" onclick="customAlert('Coming Soon');">Photography &amp; Art Events</a>
                     <ul class="submenuItem" id="sub3_3">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Photography &amp; Art Events</span></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Photography &amp; Art Events </a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Upcoming Photography &amp; Art Events </a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Notices of Photography &amp; Art Events</a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Reviews of Photography &amp; Art Events</a></li>
                        <li>
                           <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> News about Photography &amp; Art Events</a>
                        </li>
                     </ul>
                  </li>
                  <li data-submenu-id="sub3_4">
                     <a href="javascript:void(0);" onclick="customAlert('Coming Soon');">Music &amp; Audio Events</a>
                     <ul class="submenuItem" id="sub3_4">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Music &amp; Audio Events</span></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Music &amp; Audio Events </a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Upcoming Music &amp; Audio Events</a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Notices of Music &amp; Audio Events</a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Reviews of Music &amp; Audio Events</a></li>
                        <li>
                           <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> News about Music &amp; Audio Events</a>
                        </li>
                     </ul>
                  </li>
                  <li data-submenu-id="sub3_5">
                     <a href="javascript:void(0);" onclick="customAlert('Coming Soon');">Writing &amp; Publishing Events</a>
                     <ul class="submenuItem" id="sub3_5">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Writing &amp; Publishing Events</span></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Writing &amp; Publishing Events </a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Upcoming Writing &amp; Publishing Events</a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Notices of Writing &amp; Publishing Events</a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Reviews of Writing &amp; Publishing Events </a></li>
                        <li>
                           <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> News about Music &amp; Audio Events</a>
                        </li>
                     </ul>
                  </li>
                  <li data-submenu-id="sub3_6">
                     <a href="javascript:void(0);" onclick="customAlert('Coming Soon');">Creative-Industry Educational Events </a>
                     <ul class="submenuItem" id="sub3_6">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Creative-Industry Educational Events</span></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Creative-Industry Educational Events </a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Upcoming Creative-Industry Educational Events</a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Notices of Creative-Industry Educational Events</a></li>
                        <li> <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> Reviews of Creative-Industry Educational Events </a></li>
                        <li>
                           <a href="javascript:void(0);" onclick="customAlert('Coming Soon');"> News about Creative-Industry Educational Events</a>
                        </li>
                     </ul>
                  </li>
               </ul>
            
           -->
            
                <ul class="comming_soon" id="sub3">
                    <li><img src="<?php echo base_url('images/comming_soon.png');?>" alt=""  /></li>
                </ul> 
                     
            
            </li>
            
            <li data-submenu-id="sub4">
               <a href="<?php echo base_url(lang().'/blogs/index'); ?>">Blogs </a> 
               <ul class="popover dropdown-menu" id="sub4">
                  <li class="go_to fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl">Blogs</span></li>
                  <li data-submenu-id="sub4_1">
                     <a href="<?php echo base_url(lang().'/blogs/index'); ?>">Posts on </a>
                     <ul class="submenuItem" id="sub4_1">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Posts on</span></li>
                        <li> <a href="<?php echo base_url(lang().'/blogs/index'); ?>">The Film &amp; Video Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/blogs/index'); ?>">The Performing Arts Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/blogs/index'); ?>">The Photography &amp; Art Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/blogs/index'); ?>">The Music &amp; Audio Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/blogs/index'); ?>">The Writing &amp; Publishing Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/blogs/index'); ?>">Creative-Industry Education</a></li>
                        <li>
                           <a href="<?php echo base_url(lang().'/blogs/index'); ?>">Everything Else</a>
                        </li>
                     </ul>
                      <?php 
                        // load search form
                        $searchFromData['formName']  = 'Blogs';
                        $searchFromData['sectionId'] = '13';
                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                      ?>
                  </li>
               </ul>
            
            </li>
            <li data-submenu-id="sub5">
               <a href="<?php echo base_url(lang().'/forums'); ?>">Forum </a>
            <!--
               <ul class="popover dropdown-menu" id="sub5">
                  <li class="go_to fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl">Forum</span></li>
                  <li data-submenu-id="sub5_1">
                     <a href="<?php echo base_url(lang().'/forums'); ?>">Topics about</a>
                     <ul class="submenuItem" id="sub5_1">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Topics about</span></li>
                        <li> <a href="<?php echo base_url(lang().'/forums'); ?>">The Film &amp; Video Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/forums'); ?>">The Performing Arts Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/forums'); ?>">The Photography &amp; Art Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/forums'); ?>">The Music &amp; Audio Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/forums'); ?>">The Writing &amp; Publishing Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/forums'); ?>">Creative-Industry Education</a></li>
                        <li> <a href="<?php echo base_url(lang().'/forums'); ?>">Toadsquare</a></li>
                        <li> <a href="<?php echo base_url(lang().'/forums'); ?>">Toadsquare Help</a></li>
                        <li>
                           <a href="<?php echo base_url(lang().'/forums'); ?>">Everything Else</a>
                        </li>
                     </ul>
                     <?php 
                        // load search form
                        $searchFromData['formName']  = 'Forum';
                        $searchFromData['sectionId'] = '28';
                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                      ?>
                  </li>
               </ul>
            -->
                <ul class="comming_soon popover dropdown-menu" id="sub5">
                    <li ><img src="<?php echo base_url('images/comming_soon.png');?>" alt=""  /></li>
                </ul>
            </li>
            <li data-submenu-id="sub6">
               <a href="<?php echo base_url(lang().'/competition/index'); ?>">Competitions</a> 
               <!--
               <ul class="popover dropdown-menu" id="sub6">
                  <li class="go_to fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl">Competitions</span></li>
                  <li data-submenu-id="sub6_1">
                     <a href="<?php echo base_url(lang().'/competition/index'); ?>">Competitions for</a>
                     <ul class="submenuItem" id="sub6_1">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Competitions for</span></li>
                        <li> <a href="<?php echo base_url(lang().'/competition/index'); ?>"> The Film &amp; Video Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/competition/index'); ?>">The Performing Arts Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/competition/index'); ?>">The Photography &amp; Art Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/competition/index'); ?>">The Music &amp; Audio Industries</a></li>
                        <li>
                           <a href="<?php echo base_url(lang().'/competition/index'); ?>">The Writing &amp; Publishing Industries </a>
                        </li>
                     </ul>
                      <?php 
                        // load search form
                        $searchFromData['formName']  = 'Competitions';
                        $searchFromData['sectionId'] = '16';
                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                      ?>
                  </li>
                  <li data-submenu-id="sub6_2">
                     <a href="<?php echo base_url(lang().'/competition/index'); ?>">Competition Entries from</a>
                     <ul class="submenuItem" id="sub6_2">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Competition Entries from</span></li>
                        <li> <a href="<?php echo base_url(lang().'/competition/index'); ?>">The Film &amp; Video Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/competition/index'); ?>">The Performing Arts Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/competition/index'); ?>">The Photography &amp; Art Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/competition/index'); ?>">The Music &amp; Audio Industries</a></li>
                        <li>
                           <a href="<?php echo base_url(lang().'/competition/index'); ?>">The Writing &amp; Publishing Industrie</a>
                        </li>
                     </ul>
                  </li>
               </ul>
                -->
                <ul class="comming_soon popover dropdown-menu" id="sub6">
                    <li><img src="<?php echo base_url('images/comming_soon.png');?>" alt=""  /></li>
                </ul>
            </li>
            <li data-submenu-id="sub7">
               <a href="<?php echo base_url(lang().'/products'); ?>">Classifieds</a> 
               <!--
               <ul class="popover dropdown-menu" id="sub7">
                  <li class="go_to fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl">Classifieds</span></li>
                  <li data-submenu-id="sub7_1">
                     <a href="<?php echo base_url(lang().'/products'); ?>">Products for Sale for use in</a>
                     <ul class="submenuItem" id="sub7_1">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Products for Sale for use in</span></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>"> Film &amp; Video Production</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Performing Arts</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">Photography &amp; Art Production</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">Music &amp; Audio Production</a></li>
                        <li>
                           <a href="<?php echo base_url(lang().'/products'); ?>">Writing &amp; Publishing</a>
                        </li>
                     </ul>
                      <?php 
                        // load search form
                        $searchFromData['formName']  = 'Classifieds';
                        $searchFromData['sectionId'] = '12';
                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                      ?>
                  </li>
                  <li data-submenu-id="sub7_2">
                     <a href="<?php echo base_url(lang().'/products'); ?>">Products Wanted for use in</a>
                     <ul class="submenuItem" id="sub7_2">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Products Wanted for use in</span></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>"> Film &amp; Video Production</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Performing Arts</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">Photography &amp; Art Production</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">Music &amp; Audio Production</a></li>
                        <li>
                           <a href="<?php echo base_url(lang().'/products'); ?>">Writing &amp; Publishing</a>
                        </li>
                     </ul>
                  </li>
                  <li data-submenu-id="sub7_3">
                     <a href="<?php echo base_url(lang().'/products'); ?>">URGENT Work Offered in</a>
                     <ul id="sub7_3">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">URGENT Work Offered in</span></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>"> The Film &amp; Video Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Performing Arts Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Photography &amp; Art Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Music &amp; Audio Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Writing &amp; Publishing Industries</a></li>
                        <li>
                           <a href="<?php echo base_url(lang().'/products'); ?>">Creative-Industry Education</a>
                        </li>
                     </ul>
                  </li>
                  <li data-submenu-id="sub7_4">
                     <a href="<?php echo base_url(lang().'/products'); ?>">Work Experience Offered in</a>
                     <ul class="submenuItem" id="sub7_4">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Work Experience Offered in</span></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Film &amp; Video Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Performing Arts Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Photography &amp; Art Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Music &amp; Audio Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Writing &amp; Publishing Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">Creative-Industry Education </a></li>
                     </ul>
                  </li>
                  <li data-submenu-id="sub7_5">
                     <a href="<?php echo base_url(lang().'/products'); ?>">Work Offered in</a>
                     <ul class="submenuItem" id="sub7_5">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Work Offered in</span></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Film &amp; Video Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Performing Arts Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Photography &amp; Art Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Music &amp; Audio Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Writing &amp; Publishing Industries</a></li>
                        <li>
                           <a href="<?php echo base_url(lang().'/products'); ?>">Creative-Industry Education</a>
                        </li>
                     </ul>
                  </li>
                  <li data-submenu-id="sub7_6">
                     <a href="<?php echo base_url(lang().'/products'); ?>"> Work Experience Wanted in</a>
                     <ul class="submenuItem" id="sub7_6">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Work Experience Wanted in</span></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>"> The Film &amp; Video Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Performing Arts Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Photography &amp; Art Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Music &amp; Audio Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Writing &amp; Publishing Industries</a></li>
                        <li>
                           <a href="<?php echo base_url(lang().'/products'); ?>">Creative-Industry Education</a>
                        </li>
                     </ul>
                  </li>
                  <li data-submenu-id="sub7_7">
                     <a href="<?php echo base_url(lang().'/products'); ?>">Work Wanted in</a>
                     <ul class="submenuItem" id="sub7_7">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Work Wanted in</span></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Film &amp; Video Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Performing Arts Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Photography &amp; Art Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Music &amp; Audio Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">The Writing &amp; Publishing Industries</a></li>
                        <li> <a href="<?php echo base_url(lang().'/products'); ?>">Creative-Industry Education</a></li>
                     </ul>
                  </li>
               </ul>
                -->
                <ul class="comming_soon popover dropdown-menu" id="sub7">
                    <li><img src="<?php echo base_url('images/comming_soon.png');?>" alt=""  /></li>
                </ul>
            </li>
            <li data-submenu-id="sub8">
               <a href="#">Members’ Favourite Sites</a>
               <!--
               <ul class="popover dropdown-menu" id="sub8">
                  <li class="go_to fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl">Members’ Favourite Sites</span></li>
                  <li  data-submenu-id="sub8_1">
                     <a href="#">Members’ Favourite Sites from</a>
                     <ul  class="submenuItem" id="sub8_1">
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl">Flims &amp; Videos</span></li>
                        <li> <a href="#"> The Film &amp; Video Industries</a></li>
                        <li> <a href="#">The Performing Arts Industries</a></li>
                        <li> <a href="#">The Photography &amp; Art Industries</a></li>
                        <li> <a href="#">The Music &amp; Audio Industries</a></li>
                        <li> <a href="#">The Writing &amp; Publishing Industries</a></li>
                        <li>
                           <a href="#">Creative-Industry Education</a>
                        </li>
                     </ul>
                     <span class="goto_search position_absolute">
                     <span class="searchbarbg ff_arial font_weight fl">
                     <input type="text" onblur="placeHoderHideShow(this,'Keywords','show')" onclick="placeHoderHideShow(this,'Keywords','hide')" value="Keywords"  class="font_wN" name="keyWords" />
                     <input name="Submit" type="submit" class="searchbtbbg" value="Submit"  />
                     </span>
                     </span>
                  </li>
               </ul>
                -->
                <ul class="comming_soon popover dropdown-menu" id="sub8">
                    <li><img src="<?php echo base_url('images/comming_soon.png');?>" alt=""  /></li>
                </ul>
            </li>
            <li class="srtip_menu hov_menu pt12 pb14 " ></li>
            <li data-submenu-id="sub9">
               <a href="<?php echo base_url(lang().'/pressRelease'); ?>">News &amp; PR about Toadsquare</a>
               <ul id="sub9" class="popover dropdown-menu">
                  <li class="go_to fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl">News &amp; PR about Toadsquare</span></li>
                  <li>
                     <ul>
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl"></span></li>
                        <li></li>
                     </ul>
                  </li>
               </ul>
            </li>
            <li data-submenu-id="sub10">
               <a href="<?php echo base_url(lang().'/package');?>">Toadsquare Membership Options</a>
               <ul class="popover dropdown-menu" id="sub10">
                  <li class="go_to fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl">Toadsquare Membership Options</span></li>
                  <li >
                     <ul>
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl"></span></li>
                        <li></li>
                     </ul>
                  </li>
               </ul>
            </li>
            <li data-submenu-id="sub11">
               <a href="#">Help</a>
               <!--
               <ul class="popover dropdown-menu" id="sub11">
                  <li class="go_to fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl">Help</span></li>
                  <li data-submenu-id="sub3">
                     <ul>
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl"></span></li>
                        <li></li>
                     </ul>
                  </li>
               </ul>
               -->
               <ul class="comming_soon popover dropdown-menu" id="sub11">
                    <li><img src="<?php echo base_url('images/comming_soon.png');?>" alt=""  /></li>
                </ul>
            </li>
            <li class="srtip_menu hov_menu pt12 pb14 " ></li>
            <li class="last_nav" data-submenu-id="sub12" >
               <a href="#"> Invite a Friend to Join Toadsquare </a>
       
              <!-- <ul class="popover dropdown-menu" id="sub12">
                  <li class="go_to fs18 red bg_f8f8f8 display_table"><span class="pl28 display_cell veti_midl">Invite a Friend to Join Toadsquare</span></li>
                  <li>
                     <ul>
                        <li class="go_to fs21 clr_geern bg_f8f8f8 display_table"><span class="pl36 fs18 display_cell veti_midl"></span></li>
                        <li></li>
                     </ul>
                  </li>
               </ul> -->
            
                <ul class="comming_soon popover dropdown-menu" id="sub12">
                    <li><img src="<?php echo base_url('images/comming_soon.png');?>" alt=""  /></li>
                </ul>
            </li>
																	<li class="hov_menu bg-non pb20"></li>
         </ul>
         </div>
         <div class="clear"></div>
      </div>
   </div>
</div>


				
				<!--top nav script end -->
