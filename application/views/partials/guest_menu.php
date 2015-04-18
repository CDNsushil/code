<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

                        <div id="cssmenu" >
                           <ul>
                              <li class="has-sub last gotobtnli"> <a href='javascript:void(0)'><span class="gotobtn "><?php echo $this->lang->line('Goto');?><img src="<?php echo $imgPath; ?>dropdownarrow.png" alt="" /></span></a> </li>
                           </ul>
                           <div class="menuslideup  ">
                              <div class="externalpanel firstcontainer">
                                 <div class="container">
                                    <ul class="menu_wrap dropdown-menu">
                                       <li class="hov_menu bdr12_F1592A pb20"></li>
                                       <!--================= menu 1 ===================-->
                                       <li data-submenu-id="sub1" class="menu_open">
                                          <a ><?php echo $this->lang->line('memberShowcases');?></a> 
                                          <!--============== submenu =========-->
                                          <ul class="popover dropdown-menu sub_menu1 first_main display_block " id="sub1" >
                                             <!--==============  first =========-->
                                            <li class="go_to">
                                                <span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('memberShowcasesShow');?></span>
                                            </li>
                                             <li  data-submenu-id="sub1_1" class="active menu_open2" >
                                                <a ><?php echo $this->lang->line('CreativesShowcases');?></a>
                                                <ul class="popover first_ul sub_menu2" id="sub1_1" >
                                                    <li><a href="<?php echo base_url(lang().'/creatives/index'); ?>"><?php echo $this->lang->line('FvCreatives');?> </a></li>
                                                    <li><a href="<?php echo base_url(lang().'/creatives/musicaudio'); ?>"><?php echo $this->lang->line('MaCreatives');?> </a></li>
                                                    <li><a href="<?php echo base_url(lang().'/creatives/performingarts'); ?>"><?php echo $this->lang->line('ArtCreatives');?></a></li>
                                                    <li><a href="<?php echo base_url(lang().'/creatives/photographyart'); ?>"><?php echo $this->lang->line('PaCreatives');?> </a></li>
                                                    <li><a href="<?php echo base_url(lang().'/creatives/writingpublishing'); ?>"><?php echo $this->lang->line('WpCreatives');?> </a></li>
                                                    <li class=" third_strip box_siz "></li>
                                                    <li><a href="<?php echo base_url(lang().'/creatives/reviews'); ?>"><?php echo $this->lang->line('reviewsCreatives');?></a></li>
                                                    <li><a href="<?php echo base_url(lang().'/creatives/news'); ?>"><?php echo $this->lang->line('newsCreatives');?></a></li>
                                                    <span class="creavtive got_to_menu"> <img src="<?php echo $imgPath; ?>faviore_menu.png" alt="" /></span> 
                                                    <?php 
                                                        // load serach form
                                                        $searchFromData['formName']  = 'member_showcase';
                                                        $searchFromData['sectionId'] = '6';
                                                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                                                    ?> 
                                                </ul>
                                            </li>
                                             <!--==============  second =========-->
                                            <li data-submenu-id="sub1_2"  class="menu_open2">
                                                <a ><?php echo $this->lang->line('professionalsCreativeIndustries');?></a>
                                                <ul id="sub1_2" class="popover sub_menu2">
                                                    <li><a href="<?php echo base_url(lang().'/associateprofessional/filmvideo'); ?>"> <?php echo $this->lang->line('FvProfessionals');?></a></li>
                                                    <li><a href="<?php echo base_url(lang().'/associateprofessional/musicaudio'); ?>"><?php echo $this->lang->line('MaProfessionals');?></a></li>
                                                    <li><a href="<?php echo base_url(lang().'/associateprofessional/performingarts'); ?>"><?php echo $this->lang->line('ArtProfessionals');?></a></li>
                                                    <li><a href="<?php echo base_url(lang().'/associateprofessional/photographyart'); ?>"><?php echo $this->lang->line('PaProfessionals');?></a></li>
                                                    <li><a href="<?php echo base_url(lang().'/associateprofessional/writingpublishing'); ?>"><?php echo $this->lang->line('WpProfessionals');?></a></li>
                                                    <li class=" third_strip box_siz "></li>
                                                    <li><a href="<?php echo base_url(lang().'/associateprofessional/reviews'); ?>"><?php echo $this->lang->line('reviewsProfessionals');?></a></li>
                                                    <li><a href="<?php echo base_url(lang().'/associateprofessional/news'); ?>"><?php echo $this->lang->line('newsProfessionals');?></a> </li>
                                                    <span class="proff_menu  got_to_menu"><img src="<?php echo $imgPath; ?>proff_menu.png" alt="" /></span> 
                                                  <?php 
                                                        // load serach form
                                                        $searchFromData['formName']  = 'member_showcase';
                                                        $searchFromData['sectionId'] = '6';
                                                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                                                    ?> 
                                                </ul>
                                            </li>
                                             <!--============== Thrid=========-->
                                            <li data-submenu-id="sub1_3" class="menu_open2 ">
                                                <a ><?php echo $this->lang->line('businessesCreativeIndustries');?></a>
                                                <ul  id="sub1_3" class="sub_menu2">
                                                    <li ><a href="<?php echo base_url(lang().'/enterprises/index/filmvideo'); ?>"><?php echo $this->lang->line('FvBusinesses');?> </a></li>
                                                    <li ><a href="<?php echo base_url(lang().'/enterprises/musicaudio'); ?>"><?php echo $this->lang->line('MaBusinesses');?> </a></li>
                                                    <li ><a href="<?php echo base_url(lang().'/enterprises/performingarts'); ?>"><?php echo $this->lang->line('ArtBusinesses');?></a> </li>
                                                    <li ><a href="<?php echo base_url(lang().'/enterprises/photographyart'); ?>"><?php echo $this->lang->line('PaBusinesses');?> </a></li>
                                                    <li ><a href="<?php echo base_url(lang().'/enterprises/writingpublishing'); ?>"><?php echo $this->lang->line('WpBusinesses');?></a> </li>
                                                    <li class=" third_strip box_siz "></li>
                                                    <li ><a href="<?php echo base_url(lang().'/enterprises/reviews'); ?>"><?php echo $this->lang->line('reviewsBusinesses');?></a></li>
                                                    <li > <a href="<?php echo base_url(lang().'/enterprises'); ?>"><?php echo $this->lang->line('newsBusinesses');?></a> </li>
                                                    <span class="bussiness_menu got_to_menu"><img src="<?php echo $imgPath; ?>buiseness_2.png" alt="" /></span> 
                                                   <?php 
                                                        // load serach form
                                                        $searchFromData['formName']  = 'member_showcase';
                                                        $searchFromData['sectionId'] = '6';
                                                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                                                    ?> 
                                                </ul>
                                            </li>
                                             <!--============== Forth =========-->
                                                <li data-submenu-id="sub1_4" class="green_menu_li menu_open2"> 
                                                    <a href="<?php echo base_url(lang().'/fans'); ?>">
                                                        <?php echo $this->lang->line('fansCreativeIndustries');?> 
                                                    </a> 
                                                    <ul  id="sub1_4" class="sub_menu2">
                                                        <span class="fans_menu got_to_menu">
                                                            <img src="<?php echo $imgPath; ?>fans_menu.png" alt="" />
                                                        </span> 
                                                        <?php 
                                                            // load serach form
                                                            $searchFromData['formName']  = 'member_showcase';
                                                            $searchFromData['sectionId'] = '6';
                                                            $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                                                        ?> 
                                                      </ul>
                                                </li>
                                               
                                          </ul>
                                          <!--============== submenu  end=========--> 
                                       </li>
                                       <!--================= menu 2 ===================-->
                                       <li data-submenu-id="sub2" class="menu_open">
                                          <a ><?php echo $this->lang->line('mediaShowcases');?></a> 
                                          <!--============== submenu start=========-->
                                          <ul class="popover dropdown-menu sub_menu1" id="sub2" >
                                                <li class="go_to"><span class="pl28 display_cell veti_midl"> <?php echo $this->lang->line('mediaShowcases_head');?> </span></li>
                                                <!--==============Frist =========-->
                                                <li data-submenu-id="sub2_1" class="menu_open2">
                                                <a ><?php echo $this->lang->line('flimsNvideos');?></a>
                                                <ul id="sub2_1" class="sub_menu2">
                                                <li> <a href="<?php echo base_url(lang().'/filmnvideo'); ?>"> <?php echo $this->lang->line('FvCollections');?> </a></li>
                                                <li class=" third_strip box_siz "></li>
                                                <li> <a href="<?php echo base_url(lang().'/filmnvideo/upcoming'); ?>"><?php echo $this->lang->line('FvCollectionUpcoming');?></a></li>
                                                <li> <a href="<?php echo base_url(lang().'/filmnvideo/reviews'); ?>"><?php echo $this->lang->line('FvCollectionReviews');?></a></li>
                                                <li> <a href="<?php echo base_url(lang().'/filmnvideo/news'); ?>"><?php echo $this->lang->line('FvCollectionNews');?></a>
                                                </li>
                                                
                                                     <span class="flim_menu got_to_menu" ><img src="<?php echo $imgPath; ?>flime_menu.png" alt="" /></span>
                                                     <?php 
                                                       // load search form
                                                       $searchFromData['formName']  = 'media_showcase';
                                                       $searchFromData['sectionId'] = '1';
                                                       $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                                                    ?>
                                              </ul>
                                           
                    
                                             </li>
                                             <!--==============Thrid =========-->
                                             <li data-submenu-id="sub2_2" class="menu_open2">
                                                <a ><?php echo $this->lang->line('MaIndustry');  ?></a>
                                                <ul id="sub2_2" class="sub_menu2">
                                             <li> <a href="<?php echo base_url(lang().'/musicnaudio'); ?>"><?php echo $this->lang->line('MaAlbums'); ?></a></li>
                           <li> <a href="<?php echo base_url(lang().'/musicnaudio/collections'); ?>"><?php echo $this->lang->line('MaCollections'); ?></a></li>
                                 <li class=" third_strip box_siz "></li>
                              <li> <a href="<?php echo base_url(lang().'/musicnaudio/upcoming'); ?>"><?php echo $this->lang->line('MaUpcoming'); ?></a></li>
                           <li> <a href="<?php echo base_url(lang().'/musicnaudio/reviews'); ?>"><?php echo $this->lang->line('MaReviews'); ?></a></li>
                           <li> <a href="<?php echo base_url(lang().'/musicnaudio/news'); ?>"><?php echo $this->lang->line('MaNews'); ?></a> </li>
                                         <span class="music_menu got_to_menu"><img src="<?php echo $imgPath; ?>music_menu.png" alt="" /></span> 
                                              <?php 
                                                       // load search form
                                                       $searchFromData['formName']  = 'media_showcase';
                                                       $searchFromData['sectionId'] = '1';
                                                       $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                                                    ?>
                                             </ul>
                                                
                                             </li>
                                             <!--==============second =========-->
                                             <li data-submenu-id="sub2_3" class="menu_open2">
                                                <a ><?php echo $this->lang->line('photoNartw'); ?></a>
                                                <ul id="sub2_3" class="sub_menu2">
                                                   <li> <a href="<?php echo base_url(lang().'/photographynart'); ?>"><?php echo $this->lang->line('PaAlbums'); ?></a></li>
                           <li> <a href="<?php echo base_url(lang().'/photographynart/collections'); ?>"><?php echo $this->lang->line('PaCollections'); ?></a></li>
                           <li class=" third_strip box_siz "></li>
                                           <li> <a href="<?php echo base_url(lang().'/photographynart/upcoming'); ?>"><?php echo $this->lang->line('PaUpcoming'); ?></a></li>
                           <li> <a href="<?php echo base_url(lang().'/photographynart/reviews'); ?>"><?php echo $this->lang->line('PaReviews'); ?></a></li>
                           <li> <a href="<?php echo base_url(lang().'/photographynart/news'); ?>"><?php echo $this->lang->line('PaNews'); ?></a>  </li>
                                <span class="photo_menu got_to_menu" ><img src="<?php echo $imgPath; ?>photo_menu.png" alt="" /></span>
                                  <?php 
                                                       // load search form
                                                       $searchFromData['formName']  = 'media_showcase';
                                                       $searchFromData['sectionId'] = '1';
                                                       $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                                                    ?>
                                </ul>
                                                 
                                             </li>
                                             <!--==============Forth =========-->
                                             <li data-submenu-id="sub2_4" class="menu_open2">
                                                <a ><?php echo $this->lang->line('WpIndustryws'); ?></a>
                                                <ul id="sub2_4" class="sub_menu2">
                                                   <li> <a href="<?php echo base_url(lang().'/writingnpublishing'); ?>"><?php echo $this->lang->line('WpShowcases'); ?></a></li>
                           <li class=" third_strip box_siz "></li>
                          <li> <a href="<?php echo base_url(lang().'/writingnpublishing/upcoming'); ?>"><?php echo $this->lang->line('WpCollectionUpcoming'); ?></a></li>
                           <li> <a href="<?php echo base_url(lang().'/writingnpublishing/reviews'); ?>"><?php echo $this->lang->line('WpCollectionReviews'); ?></a></li>
                           <li> <a href="<?php echo base_url(lang().'/writingnpublishing/news'); ?>"><?php echo $this->lang->line('WpCollectionNews'); ?></a>  </li>
                                          <span class="writing_menu got_to_menu"><img src="<?php echo $imgPath; ?>writing_menu.png" alt=""  /></span> 
                                              <?php 
                                                       // load search form
                                                       $searchFromData['formName']  = 'media_showcase';
                                                       $searchFromData['sectionId'] = '1';
                                                       $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                                                    ?>
                                              </ul>
                                                
                                             </li>
                                             <!--==============fifth =========-->
                                             <li data-submenu-id="sub2_7" class="menu_open2">
                                                <a ><?php echo $this->lang->line('EmIndustry'); ?></a>
                                                <ul id="sub2_7" class="sub_menu2">
                                                   <li> <a href="<?php echo base_url(lang().'/educationnmaterial'); ?>"> <?php echo $this->lang->line('EmIndustrycFV'); ?></a></li>
                       <li> <a href="<?php echo base_url(lang().'/educationnmaterial/upcoming'); ?>"><?php echo $this->lang->line('EmCollectionUpcomingMA'); ?></a></li>
                                    <li> <a href="<?php echo base_url(lang().'/educationnmaterial/reviews'); ?>"><?php echo $this->lang->line('EmCollectionReviewsPA'); ?></a></li>
                           <li> <a href="<?php echo base_url(lang().'/educationnmaterial/news'); ?>"><?php echo $this->lang->line('EmCollectionNewsPhA'); ?></a>  </li>
                          <li> <a href="<?php echo base_url(lang().'/educationnmaterial'); ?>"> <?php echo $this->lang->line('EmIndustrycWP'); ?></a></li>
                                                    <li class=" third_strip box_siz "></li>
                               <li> <a href="<?php echo base_url(lang().'/educationnmaterial/upcoming'); ?>"><?php echo $this->lang->line('EmCollectionUpcoming'); ?></a></li>
                           <li> <a href="<?php echo base_url(lang().'/educationnmaterial/reviews'); ?>"><?php echo $this->lang->line('EmCollectionReviews'); ?></a></li>
                           <li> <a href="<?php echo base_url(lang().'/educationnmaterial/news'); ?>"><?php echo $this->lang->line('EmCollectionNews'); ?></a>  </li>
                                          <span class="education_menu got_to_menu"><img src="<?php echo $imgPath; ?>education_menu.png" alt="" /></span>
                                             <?php 
                                                       // load search form
                                                       $searchFromData['formName']  = 'media_showcase';
                                                       $searchFromData['sectionId'] = '1';
                                                       $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                                                    ?>
                                            </ul>
                                                
                                             </li>
                                          </ul>
                                          <!--============== submenu end=========--> 
                                       </li>
                                       <!--================= menu 3 ===================-->
                                       <li data-submenu-id="sub3" class="menu_open">
                                          <a > <?php echo $this->lang->line('PE');?></a> 
                                          <!--============== submenu start=========-->
                                          <ul class="popover dropdown-menu sub_menu1" id="sub3" >
                                             <li class="go_to"><span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('PE_head');?> </span></li>
                                             <!--==============Frist =========-->
                                             <li data-submenu-id="sub3_1" class="menu_open2">
                                                <a ><?php echo $this->lang->line('PE_sub1');?></a>
                                                <ul id="sub3_1" class="sub_menu2">
                                             <li> <a href="#"> <?php echo $this->lang->line('PE_sub1_a');?> </a></li>
                                 <li class=" third_strip box_siz "></li>
                                                    <li> <a href="#"><?php echo $this->lang->line('PE_sub1_b');?></a></li>
                           <li> <a href="#"><?php echo $this->lang->line('PE_sub1_c');?></a></li>
                           <li> <a href="#"><?php echo $this->lang->line('PE_sub1_d');?></a></li>
                           
                            <span class="flim_menu_event got_to_menu">
                                                   <div class="tex_menu text_alighC fs50 lineH45">
													   <?php echo $this->lang->line('PE_sub1_d_i1');?> <br />
                                                      <?php echo $this->lang->line('PE_sub1_d_i2');?><br />
                                                     <?php echo $this->lang->line('PE_sub1_d_i3');?>
                                                   </div>
                                                   <img src="<?php echo $imgPath; ?>event_menu1.png" alt="" />
                                                </span>
                                                 <?php 
                           // load search form
                           $searchFromData['formName']  = 'media_showcase';
                           $searchFromData['sectionId'] = '1';
                           $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                           ?> 
                           
                         </ul>
                                               
                                             </li>
                                             <!--==============Thrid =========-->
                                             <li data-submenu-id="sub3_2" class="menu_open2">
                                                <a ><?php echo $this->lang->line('PE_sub2');?></a>
                                                <ul id="sub3_2" class="sub_menu2">
                                               <li> <a href="#"><?php echo $this->lang->line('PE_sub2_a'); ?></a></li>
                                                   <li class=" third_strip box_siz "></li>
                                       <li> <a href="#"><?php echo $this->lang->line('PE_sub2_b'); ?></a></li>
                           <li> <a href="#"><?php echo $this->lang->line('PE_sub2_c'); ?></a></li>
                           <li> <a href="#"><?php echo $this->lang->line('PE_sub2_d'); ?></a></li>
                           
                                        <span class="music_menu_event got_to_menu">
                                           <div class="tex_menu clr_fff fs34 lettsp4px fnt_cinzel"><?php echo $this->lang->line('PE_sub2_d_i1'); ?><br />
                                              <?php echo $this->lang->line('PE_sub2_d_i2'); ?><br />
                                              <?php echo $this->lang->line('PE_sub2_d_i3'); ?>
                                           </div>
                                           <img src="<?php echo $imgPath; ?>event_menu5.png" alt="" />
                                        </span>
                                                
                                                </ul>
                                              
                                             </li>
                                             <!--==============second =========-->
                                             <li data-submenu-id="sub3_8" class="menu_open2">
                                                <a ><?php echo $this->lang->line('PE_sub3');?></a>
                                                <ul id="sub3_8" class="sub_menu2">
                                                                   <li> <a href="#"><?php echo $this->lang->line('PE_sub3_a'); ?></a></li>
                                                   <li class=" third_strip box_siz "></li>
                  <li> <a href="#"><?php echo $this->lang->line('PE_sub3_b'); ?></a></li>
                           <li> <a href="#"><?php echo $this->lang->line('PE_sub3_c'); ?></a></li>
                           <li> <a href="#"><?php echo $this->lang->line('PE_sub3_d'); ?></a></li>
                           
                                    <span class="perfoming_menu_event got_to_menu">
                                       <div class="tex_menu clr00f0ef fs36 lettsp4px  text_alignR lineH41 fnt_cinzel"> <?php echo $this->lang->line('PE_sub3_d_i1'); ?> <br />
                                          <?php echo $this->lang->line('PE_sub3_d_i2'); ?> <br />
                                          <?php echo $this->lang->line('PE_sub3_d_i3'); ?> 
                                       </div>
                                       <img src="<?php echo $imgPath; ?>event_menu6.png" alt="" />
                                    </span>
                                                
                                                </ul>
                                              
                                             </li>
                                             <li data-submenu-id="sub3_3" class="menu_open2">
                                                <a ><?php echo $this->lang->line('PE_sub4');?></a>
                                                <ul id="sub3_3" class="sub_menu2">
                                                        <li> <a href="#"><?php echo $this->lang->line('PE_sub4_a'); ?></a></li>
                                                   <li class=" third_strip box_siz "></li>
     <li> <a href="#"><?php echo $this->lang->line('PE_sub4_b'); ?></a></li>
                           <li> <a href="#"><?php echo $this->lang->line('PE_sub4_c'); ?></a></li>
                           <li> <a href="#"><?php echo $this->lang->line('PE_sub4_d'); ?></a>  </li>
                           
                            <span class="photo_menu_event got_to_menu" >
                                                   <div class="tex_menu clr_444 text_shadownone font_mouse fs30"><?php echo $this->lang->line('PE_sub4_d_i1'); ?></div>
                                                   <img src="<?php echo $imgPath; ?>event_menu3.png" alt="" />
                                                </span>
                                                
                                                </ul>
                                               
                                             </li>
                                             <!--==============Forth =========-->
                                             <li data-submenu-id="sub3_4" class="menu_open2">
                                                <a ><?php echo $this->lang->line('PE_sub5');?></a>
                                                <ul id="sub3_4" class="sub_menu2">
                                                  <li> <a href="#"> <?php echo $this->lang->line('PE_sub5_a'); ?></a></li>
                                                   <li class=" third_strip box_siz "></li>
							<li> <a href="#"><?php echo $this->lang->line('PE_sub5_b'); ?></a></li>
                           <li> <a href="#"><?php echo $this->lang->line('PE_sub5_c'); ?></a></li>
                           <li> <a href="#"><?php echo $this->lang->line('PE_sub5_d'); ?></a>  </li>
                                                
                                                <span class="writing_menu_event got_to_menu">
                                                   <div class="tex_menu fnt_Patrick clr_444 fs30 lettsp1  text_shadownone"><?php echo $this->lang->line('PE_sub5_d_i1'); ?>  </div>
                                                   <img src="<?php echo $imgPath; ?>event_menu4.png" alt=""  />
                                                </span>
                                                
                                                </ul>
                                               
                                             </li>
                                             <!--==============fifth =========-->
                                             <li data-submenu-id="sub3_5" class="menu_open2">
                                                <a ><?php echo $this->lang->line('PE_sub6');?></a>
                                                <ul id="sub3_5" class="sub_menu2">
                                             <li> 
                            <a href="#"> <?php echo $this->lang->line('PE_sub6_a'); ?></a></li>
                            <li> <a href="#"><?php echo $this->lang->line('PE_sub6_b'); ?></a></li>
                            <li> <a href="#"><?php echo $this->lang->line('PE_sub6_c'); ?></a></li>
                            <li> <a href="#"><?php echo $this->lang->line('PE_sub6_d'); ?></a>  </li>
                            <li> <a href="#"> <?php echo $this->lang->line('PE_sub6_e'); ?></a></li> 
                            <li class=" third_strip box_siz "></li>
                            <li> <a href="#"><?php echo $this->lang->line('PE_sub6_f'); ?></a></li>
                            <li> <a href="#"><?php echo $this->lang->line('PE_sub6_g'); ?></a></li>
                            <li> <a href="#"><?php echo $this->lang->line('PE_sub6_h'); ?></a>  </li>
                               
                                <span class="creative_menu_event  got_to_menu">
                                   <div class="tex_menu opensan_bold clr_fff fs40 lettsp1 text_alighC lineH35 ">                      
                                      <?php echo $this->lang->line('PE_sub6_h_i1'); ?><br />
                                      <span class="clrf9228d">  <?php echo $this->lang->line('PE_sub6_h_i2'); ?>  </span><br />
                                     <?php echo $this->lang->line('PE_sub6_h_i3'); ?> <br />
                                      <span class="clrf9228d"> <?php echo $this->lang->line('PE_sub6_h_i4'); ?>   </span>
                                   </div>
                                   <img src="<?php echo $imgPath; ?>event_menu2.png" alt="" />
                                </span>
                               
                                 </ul>
                                               
                                             </li>
                                          </ul>
                                          <!--============== submenu end=========--> 
                                       </li>
                                       <li data-submenu-id="sub13" class="menu_open">
                                          <a ><?php echo $this->lang->line('PEN'); ?></a>
                                          <ul class="popover dropdown-menu sub_menu1 green_menu" id="sub13">
                                             <li class="go_to"> <span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('PEN_h'); ?></span></li>
                                           <li> <a href="#"><?php echo $this->lang->line('PEN_sub1'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('PEN_sub2'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('PEN_sub3'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('PEN_sub4'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('PEN_sub5'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('PEN_sub6'); ?></a></li>
                       <span class="event_notice opacity1 got_to_menu">
                                                <div class="tex_menu fs60 font_mouse clr_ffdb00"> What are<br />
                                                <?php echo $this->lang->line('PEN_sub1_i1'); ?>   <br />
                                                 <?php echo $this->lang->line('PEN_sub1_i2'); ?>   
                                                </div>
                                                <img src="<?php echo $imgPath; ?>event_notic_menu.png" alt=""   /> 
                                             </span>
						<?php
						// load search form
                        $searchFromData['formName']  = 'Blogs';
                        $searchFromData['sectionId'] = '13';
                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                        ?>
                                          </ul>
                                       </li>
                                       <!--================= menu 3 ===================-->
                                       <li data-submenu-id="sub4" class="menu_open">
                                          <a ><?php echo $this->lang->line('Blog_Blogs'); ?> </a> 
                                          <!--============== submenu start=========-->
                                          <ul class="popover dropdown-menu sub_menu1 green_menu" id="sub4">
                                             <li class="go_to"> <span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('Blog_Post'); ?></span></li>
                                             <!--==============first=========-->
                                              <li> <a href="<?php echo base_url_lang('blogs/index'); ?>"><?php echo $this->lang->line('Blog_Post_film'); ?></a></li>
                     <li> <a href="<?php echo base_url_lang('blogs/photographyart'); ?>"><?php echo $this->lang->line('Blog_Post_perform'); ?></a></li>
                     <li> <a href="<?php echo base_url_lang('blogs/photographyart'); ?>"><?php echo $this->lang->line('Blog_Post_photo'); ?></a></li>
                     <li> <a href="<?php echo base_url_lang('blogs/musicaudio'); ?>"><?php echo $this->lang->line('Blog_Post_Music'); ?></a></li>
                     <li> <a href="<?php echo base_url_lang('blogs/writingpublishing'); ?>"><?php echo $this->lang->line('Blog_Post_write'); ?></a></li>
                     <li> <a href="<?php echo base_url_lang('blogs/educationmaterial'); ?>"><?php echo $this->lang->line('Blog_Post_Creative'); ?></a></li>
                    <span class="blog_menu opacity1 got_to_menu">
                                                <div class="tex_menu width155 font_bold fs42 lineH41 clr41b5b5 fs36 "><?php echo $this->lang->line('Blog_Post_Creative_i1'); ?> 
                                                </div>
                                                <img src="<?php echo $imgPath; ?>blog_menu.png" alt=""   /> 
                                             </span>
                                           <?php 
                        // load search form
                        $searchFromData['formName']  = 'Blogs';
                        $searchFromData['sectionId'] = '13';
                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                        ?>
                       <!--============== submenu end=========-->
                                          </ul>
                                       </li>
                                       <li data-submenu-id="sub5" class="menu_open">
                                          <a ><?php echo $this->lang->line('Forum_Forum'); ?> </a> 
                                          <!--============== submenu start=========-->
                                          <ul class="popover dropdown-menu sub_menu1 green_menu" id="sub5">
                                             <li class="go_to"> <span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('Forum_Forum2'); ?></span></li>
                                             <!--==============first=========-->
                                          <li> <a href="<?php echo base_url_lang('forums/topics/4'); ?>"><?php echo $this->lang->line('Forum_film'); ?></a></li>
                     <li> <a href="<?php echo base_url_lang('forums/topics/8'); ?>"><?php echo $this->lang->line('Forum_perform'); ?></a></li>
                     <li> <a href="<?php echo base_url_lang('forums/topics/6'); ?>"><?php echo $this->lang->line('Forum_photo'); ?></a></li>
                     <li> <a href="<?php echo base_url_lang('forums/topics/5'); ?>"><?php echo $this->lang->line('Forum_music'); ?></a></li>
                     <li> <a href="<?php echo base_url_lang('forums/topics/7'); ?>"><?php echo $this->lang->line('Forum_write'); ?></a></li>
                     <li> <a href="<?php echo base_url_lang('forums/topics/9'); ?>"><?php echo $this->lang->line('Forum_creative'); ?></a></li>
                       <span class="forum_menu opacity1 got_to_menu"> <img src="<?php echo $imgPath; ?>forum_menu.png" alt=""   /> </span>
                          <?php 
                        // load search form
                        $searchFromData['formName']  = 'Forum';
                        $searchFromData['sectionId'] = '28';
                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                        ?>
                                    </ul>
                                    
                                     
                                          <!--============== submenu end=========--> 
                                       </li>
                                       <li data-submenu-id="sub6" class="menu_open">
                                          <a ><?php echo $this->lang->line('Competitions_Competitions'); ?></a> 
                                          <!--============== submenu start=========-->
                                          <ul class="popover dropdown-menu sub_menu1 green_menu" id="sub6">
                                             <li class="go_to"> <span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('Competitions_Competitions_head'); ?></span></li>
                                             <!--==============first=========-->
                      <li> <a href="#"><?php echo $this->lang->line('Competitions_film'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_perform'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_photo'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_music'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_write'); ?></a></li>
                    <span class="forum_menu opacity1 got_to_menu"> <img src="<?php echo $imgPath; ?>forum_menu.png" alt=""   /> </span> 
                      <?php 
                        // load search form
                        $searchFromData['formName']  = 'Forum';
                        $searchFromData['sectionId'] = '28';
                        $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                        ?>
                                       </ul>
                                          <!--============== submenu end=========--> 
                                       </li>
                                       <li data-submenu-id="sub7" class="menu_open">
                                          <a ><?php echo $this->lang->line('Classifieds_Classifieds'); ?></a> 
                                          <!--============== submenu start=========-->
                                          <ul class="popover dropdown-menu sub_menu1" id="sub7" >
                                             <li class="go_to"><span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('Classifieds_Classifieds_head'); ?></span></li>
                                             <!--==============Frist =========-->
                                             <li data-submenu-id="sub7_1" class="menu_open2">
                                                <a > <?php echo $this->lang->line('CLA_sub1'); ?></a>
                                                <ul id="sub7_1" class="sub_menu2">
                                                    <li> <a href="#"><?php echo $this->lang->line('Competitions_film'); ?></a></li>
                                                    <li> <a href="#"><?php echo $this->lang->line('Competitions_perform'); ?></a></li>
                                                    <li> <a href="#"><?php echo $this->lang->line('Competitions_photo'); ?></a></li>
                                                    <li> <a href="#"><?php echo $this->lang->line('Competitions_music'); ?></a></li>
                                                    <li> <a href="#"><?php echo $this->lang->line('Competitions_write'); ?></a></li>
                                                    
                                                    <span class="classi_menu1  got_to_menu">
                                                       <div class="tex_menu fs40 text_alighC  clr_fff"> <?php echo $this->lang->line('Competitions_trade_i1'); ?> <br />
                                                          <?php echo $this->lang->line('Competitions_trade_i2'); ?> 
                                                       </div>
                                                       <img src="<?php echo $imgPath; ?>classi_menu2.png" alt="" />
                                                    </span>
                                                    <?php 
                                                   // load search form
                                                   $searchFromData['formName']  = 'Favourite_sites';
                                                   $searchFromData['sectionId'] = '36';
                                                   $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                                                   ?> 
                                                   
                                                </ul>
                                                
                                             </li>
                                             <!--==============Thrid =========-->
                                             <li data-submenu-id="sub7_2" class="menu_open2">
                                                <a ><?php echo $this->lang->line('CLA_sub2'); ?></a>
                                                <ul id="sub7_2" class="sub_menu2">
                      <li> <a href="#"><?php echo $this->lang->line('Competitions_film'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_perform'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_photo'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_music'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_write'); ?></a></li>
                     
                                                <span class="classi_menu1  got_to_menu">
                                                   <div class="tex_menu fs40 text_alighC  clr_fff"> <?php echo $this->lang->line('Competitions_trade_i1'); ?> <br />
                                                      <?php echo $this->lang->line('Competitions_trade_i2'); ?> 
                                                   </div>
                                                   <img src="<?php echo $imgPath; ?>classi_menu2.png" alt="" />
                                                </span>
                                                </ul>
                                               
                                             </li>
                                             <li class=" third_strip box_siz "></li>
                                             <!--==============second =========-->
                                             <li data-submenu-id="sub7_3" class="menu_open2">
                                                <a ><?php echo $this->lang->line('CLA_sub3'); ?></a>
                                                <ul id="sub7_3" class="sub_menu2">
                      <li> <a href="#"><?php echo $this->lang->line('Competitions_film'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_perform'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_photo'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_music'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_write'); ?></a></li>
                       <span class="classi_menu2 got_to_menu">
                                                   <div class="tex_menu fs50 text_alighC clrc1d900"> <span><?php echo $this->lang->line('Competitions_find_i1'); ?> </span> <span class="pl5 pr5 lettsp1"> <?php echo $this->lang->line('Competitions_find_i2'); ?> </span></div>
                                                   <img src="<?php echo $imgPath; ?>classi_menu.png" alt="" />
                                                </span>
                                                
                                                </ul>
                                              
                                             </li>
                                             <!--==============Forth =========-->
                                             <li data-submenu-id="sub7_4" class="menu_open2">
                                                <a ><?php echo $this->lang->line('CLA_sub4'); ?></a>
                                                <ul id="sub7_4" class="sub_menu2">
                      <li> <a href="#"><?php echo $this->lang->line('Competitions_film'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_perform'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_photo'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_music'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_write'); ?></a></li>
                          <span class="classi_menu2 got_to_menu">
                                                   <div class="tex_menu fs50 text_alighC clrc1d900"> <span> <?php echo $this->lang->line('Competitions_find_i1'); ?></span> <span class="pl5 pr5 lettsp1"> <?php echo $this->lang->line('Competitions_find_i2'); ?> </span></div>
                                                   <img src="<?php echo $imgPath; ?>classi_menu.png" alt="" />
                                                </span>
                                                
                                                </ul>
                                           
                                             </li>
                                             <!--==============fifth =========-->
                                             <li data-submenu-id="sub7_5" class="menu_open2">
                                                <a ><?php echo $this->lang->line('CLA_sub5'); ?></a>
                                                <ul id="sub7_5" class="sub_menu2">
                      <li> <a href="#"><?php echo $this->lang->line('Competitions_film'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_perform'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_photo'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_music'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_write'); ?></a></li>
                                                <span class="classi_menu2 got_to_menu">
                                                   <div class="tex_menu fs50 text_alighC clrc1d900"> <span> <?php echo $this->lang->line('Competitions_find_i1'); ?></span> <span class="pl5 pr5 lettsp1"> <?php echo $this->lang->line('Competitions_find_i2'); ?> </span></div>
                                                   <img src="<?php echo $imgPath; ?>classi_menu.png" alt="" />
                                                </span>
                                                
                                                </ul>
                                               
                                             </li>
                                             <li data-submenu-id="sub7_6" class="menu_open2">
                                                <a ><?php echo $this->lang->line('CLA_sub6'); ?></a>
                                                <ul id="sub7_6" class="sub_menu2">
                      <li> <a href="#"><?php echo $this->lang->line('Competitions_film'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_perform'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_photo'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_music'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_write'); ?></a></li>
                     
                      <span class="classi_menu2 got_to_menu">
                                                   <div class="tex_menu fs50 text_alighC clrc1d900"> <span> <?php echo $this->lang->line('Competitions_find_i1'); ?></span> <span class="pl5 pr5 lettsp1"> <?php echo $this->lang->line('Competitions_find_i2'); ?> </span></div>
                                                   <img src="<?php echo $imgPath; ?>classi_menu.png" alt="" />
                                                </span>
                                                
                                                </ul>
                                               
                                             </li>
                                             <li data-submenu-id="sub7_7" class="menu_open2">
                                                <a ><?php echo $this->lang->line('CLA_sub7'); ?></a>
                                                <ul id="sub7_7" class="sub_menu2">
                      <li> <a href="#"><?php echo $this->lang->line('Competitions_film'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_perform'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_photo'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_music'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_write'); ?></a></li>
                     
                      <span class="classi_menu2 got_to_menu">
                                                   <div class="tex_menu fs50 text_alighC clrc1d900"> <span> <?php echo $this->lang->line('Competitions_find_i1'); ?></span> <span class="pl5 pr5 lettsp1"> <?php echo $this->lang->line('Competitions_find_i2'); ?> </span></div>
                                                   <img src="<?php echo $imgPath; ?>classi_menu.png" alt="" />
                                                </span>
                                                
                                                </ul>
                                               
                                             </li>
                                          </ul>
                                          <!--============== submenu end=========--> 
                                       </li>
                                       <li data-submenu-id="sub8" class="menu_open">
                                          <a ><?php echo $this->lang->line('Favourite_Favourite'); ?></a>
                                          <ul class="popover sub_menu1 green_menu dropdown-menu" id="sub8">
                                             <!--==============first=========-->
                                             <li class="go_to">
                                                <span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('Favourite_Favourite_from'); ?></span>
                                             </li>
                      <li> <a href="#"><?php echo $this->lang->line('Competitions_film'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_perform'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_photo'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_music'); ?></a></li>
                     <li> <a href="#"><?php echo $this->lang->line('Competitions_write'); ?></a></li>
                                             <span class="mem_fov opacity1 got_to_menu">
                                                <div class="tex_menu fs50 width164  clrc1d900"><?php echo $this->lang->line('Competitions_what_i1'); ?>
                                                </div>
                                                <img src="<?php echo $imgPath; ?>memfov_menu.png" alt=""   /> 
                                             </span>
                                                 <?php 
                           // load search form
                           $searchFromData['formName']  = 'Favourite_sites';
                           $searchFromData['sectionId'] = '36';
                           $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                           ?> 
                                          </ul>
                                       </li>
                                       <li class="srtip_menu hov_menu pt12 pb14 " ></li>
                                       <li data-submenu-id="sub9" class="menu_open">
                                          <a ><?php echo $this->lang->line('News_News'); ?></a>
                                          <ul id="sub9" class="sub_menu1 green_menu popover">
                                             <li class="go_to"><span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('News_Head'); ?></span></li>
                                          <li> <a href="<?php echo base_url(lang().'/pressRelease/index'); ?>"> <?php echo $this->lang->line('News_Press'); ?></a></li>
                     <li> <a href="<?php echo base_url(lang().'/news/index'); ?>"><?php echo $this->lang->line('News_In'); ?></a></li>
                     <li> <a href="<?php echo base_url(lang().'/news/launch_list'); ?>"><?php echo $this->lang->line('News_Toad'); ?></a></li>
                     <li> <a href="<?php echo base_url(lang().'/news/information_list'); ?>"><?php echo $this->lang->line('News_toadInfo'); ?></a></li>
                        <span class="fr seen_on  bg_fff shadow_down  mr20 mb20">
                                                <h2 class="fs33 pt15 opens_light clr_ef5a34 ">Seen on... </h2>
                                                <span class="news_images"><a href=""><img src="<?php echo $imgPath; ?>news_1.png" alt="" /></a> <a href=""><img src="<?php echo $imgPath; ?>news_2.png" alt="" /></a> <a href=""><img src="<?php echo $imgPath; ?>news_3.png" alt="" /></a> <a href=""><img src="<?php echo $imgPath; ?>news_4.png" alt="" /></a> <a href=""><img src="<?php echo $imgPath; ?>news_5.png" alt="" /></a> </span> 
                                             </span>
                                               <span class="pr_menu opacity1 got_to_menu"> <img src="<?php echo $imgPath; ?>news_menu.png"  alt=""   /> </span>
                                           
                                             <?php 
                        // load search form
                        $searchFromData['formName']  = 'news';
                        $searchFromData['sectionId'] = '18';
                         $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                        ?>
                                          </ul>
                                       </li>
                                       <li data-submenu-id="sub10" class="menu_open">
                                          <a ><?php echo $this->lang->line('Memebership_Memebership'); ?></a>
                                          <ul class="popover dropdown-menu sub_menu1" id="sub10">
                                             <li class="go_to"> <span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('Memebership_Head'); ?></span></li>
                                             <li> <span class="membership_menu opacity1 got_to_menu"><img src="<?php echo $imgPath; ?>membership_menu.png" alt="" /> </span> </li>
                                             <span class="mem_text">
                                                <h3 class="clr8b9c00 fl  fs42 mouse_fnt"><?php echo $this->lang->line('Memebership_Free'); ?> </h3>
                                             <button class="bg_f1592a width100 fr  fs18 shadow_down" onclick='window.location="<?php echo base_url(lang().'/package');?>"'><?php echo $this->lang->line('Memebership_Join'); ?></button>
                                             </span>
                                          </ul>
                                       </li>
                                       <li data-submenu-id="sub11" class="menu_open">
                                          <a ><?php echo $this->lang->line('Help_Help'); ?></a>
                                          <ul class="popover dropdown-menu green_menu sub_menu1" id="sub11">
                                             <li class="go_to"><span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('Help_Help_dis'); ?></span></li>
                                             <li data-submenu-id="sub11_1">
                                                <a href="#"> <?php echo $this->lang->line('Help_Help_tip'); ?></a>
                                                <ul id="sub11_1">
                                                   <li> <a href="#"> <?php echo $this->lang->line('Help_Help_sug'); ?></a> </li>
                                                </ul>
                                             </li>
                                             <li data-submenu-id="sub11_2">
                                                <a href="#"><?php echo $this->lang->line('Help_Help_forum'); ?></a>
                                                <ul id="sub11_2">
                                                   <li> <a href="#"><?php echo $this->lang->line('Help_Help_Go'); ?>  <br />
                                                   <?php echo $this->lang->line('Help_Help_Other'); ?>    
                                                      </a> 
                                                   </li>
                                                </ul>
                                             </li>
                                    <?php 
                                    // load search form
                                    $searchFromData['formName']  = 'news';
                                    $searchFromData['sectionId'] = '18';
                                     $this->load->view('partials/guest_menu_search_view',$searchFromData); 
                                    ?>
                                          </ul>
                                       </li>
										 <?php   //if(isLoginUser()){ ?>
                                       <li class="srtip_menu hov_menu pb15 pt10" ></li>
                                       <li class="last_nav menu_open" data-submenu-id="sub12">
                                          <a  class=""><?php echo $this->lang->line('inviteFrnToJoinTdqremovedot'); ?></a>
                                          <ul class="popover dropdown-menu sub_menu1" id="sub12">
                                             <li class="go_to"><span class="pl28 display_cell veti_midl"><?php echo $this->lang->line('inviteFrnToJoinTdqremovedot_r'); ?></span></li>
                                             <li class="bg-non">
                                                <span class="invite_wrap ">
                                                   <img src="<?php echo $imgPath; ?>logo_121.png" alt=""  /> <span class="sap_55"></span>
                                                   <div class="fs20  open_sans clr_444"> <?php echo $this->lang->line('emailFrnToJoinTdqInvite'); ?>  
                                                   </div>
                                                   <span class="sap_50"></span>
                                                   
                                                   <?php 
													//------create share link by current url-------//
													$UrlToShare     = uri_string();
                                                   ?>
                                                   <div class=" addthis_toolbox  mb15 fs12 email_link display_block text_alignc"

													addthis:url="<?php echo $UrlToShare ?>" 
													addthis:title="A Link to my Work Profile (it will work for 15 days)"
													addthis:description=""
                                                   >
                                                      <a class="addthis_button_yahoomail"><span class="yahoo_icon mail_icon " href=""> <?php echo $this->lang->line('Yahoo'); ?> </span></a>
                                                      <a class="addthis_button_gmail"><span class="gmail_icon mail_icon " href=""><?php echo $this->lang->line('Gmail'); ?> </span></a>
                                                      <a class="addthis_button_hotmail"><span class="hotmail_icon mail_icon " href=""><?php echo $this->lang->line('Hotmail'); ?></span></a>
                                                      <a class="addthis_button_rediff"> <span class="reddif_icon mail_icon " href=""><?php echo $this->lang->line('Rediff'); ?> </span></a>
                                                      <a class="addthis_button_mailto"><span class="last pl7 bdr_d1d1d1 pr10 our_icon mail_icon " href=""><?php echo $this->lang->line('Your_Client'); ?></span></a>
                                                   </div>
                                                   
                                                   <span class="sap_45"></span>
                                                </span>
                                             </li>
                                          </ul>
                                       </li>
										 <?php //} ?>
                                       <li class="srtip_menu bgimg_none  hov_menu pb30 pt5" ></li>
                                    </ul>
                                 </div>
                                 <!-- submenu --> 
                              </div>
                           </div>
                        </div>
                       
                       <!---goto end --->

<script  type="text/javascript">
    //login user can sent invitation
    $(document).ready(function(){
        //invite form submit code
        $("#inviteForm_1").validate({
			  submitHandler: function() {
				var fromData=$("#inviteForm_1").serialize();
				fromData = fromData+'&ajaxHit=1';
				$('#inviteFormDiv_1').html('<img  src="<?php echo  base_url(); ?>images/loading_wbg.gif">');
				$.post(baseUrl+language+'/common/invitefriend',fromData, function(data) {
				  if(data){
                        refreshPge();
                    }
				});
			}
		});
        
        $(".goto_menu_link").hover(function(){
            var id      =  $(this).attr('id');
            var section = $(this).attr('section');
            $("#sectionId_"+section).val(id);
        });
	});
</script>
