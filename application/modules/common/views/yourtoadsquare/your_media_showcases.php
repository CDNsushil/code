<li data-submenu-id="sub_t9" class="toad_menu_open">
   <a href="#">Your Media Showcases</a>
   <ul class="menu_inner popover  menusecond toad_menu_open_sub"  id="sub_t9">
      <li class=" fs20  clr_geern your_toad bg_f3f3f3 display_table"> <span class="display_cell veti_midl">Your Media Showcases</span></li>
      <li>
         <span class="content_menu ">
             <!--
            <div class="green you_todo_icon "> You have things to do!</div>
            <span class="sap_15"></span>
            <ul class="width100_per fs14 fl  listpb10 red_arrow_list">
               <li><a  class="no_wrap">Complete your  Collection </a></li>
               <li><a>Renew  your Collection </a></li>
               <li  ><a class="red fs12 text_alignL"> Another member has reported a problem with your Showcase
                  The item has been taken off your Showcase. See the item in question. </a>
               </li>
            </ul>
            <span class="sap_30 bd_t "></span>-->
            
                    <?php
                    // You have things to do
                    if(!empty($completetMediaList)){
                    ?>   
                    
                    <div class="green you_todo_icon "> You have things to do!</div>
                    <span class="sap_15"></span>
                    <ul class="width100_per fs14 fl  listpb10 red_arrow_list">
                       <?php if(in_array('1',$completetMediaList)) { ?>     
                        
                            <li><a href="<?php echo base_url(lang().'/media/filmvideo/completeyourcollection');?>"><b><?php echo $this->lang->line('Your_mediaComplete');  ?></b> <?php echo $this->lang->line('Your_mediaFilmVideo');  ?> </a></li>
                            
                            <?php if(isset($subscriptionType) && $subscriptionType==1){ ?>
                                <li><a href="<?php echo base_url(lang().'/media/filmvideo/renewmedialist');?>"><b><?php echo $this->lang->line('Your_mediaRenew');  ?></b> <?php echo $this->lang->line('Your_mediaFilmVideo');  ?></a></li>
                            <?php } ?>
                      
                        <?php } if(in_array('2',$completetMediaList)) { ?> 
                        
                            <li><a href="<?php echo base_url(lang().'/media/musicaudio/completeyourcollection');?>"><b><?php echo $this->lang->line('Your_mediaComplete');  ?></b> <?php echo $this->lang->line('Your_mediamusicAudio');  ?> </a></li>
                           
                            <?php if(isset($subscriptionType) && $subscriptionType==1){ ?>
                                <li><a href="<?php echo base_url(lang().'/media/musicaudio/renewmedialist');?>"><b><?php echo $this->lang->line('Your_mediaRenew');  ?></b> <?php echo $this->lang->line('Your_mediamusicAudio');  ?></a></li>
                            <?php } ?>
                            
                        <?php } if(in_array('4',$completetMediaList)) { ?> 
                            
                            <li><a href="<?php echo base_url(lang().'/media/photographyart/completeyourcollection');?>"><b><?php echo $this->lang->line('Your_mediaComplete');  ?></b> <?php echo $this->lang->line('Your_mediaphotoart');  ?> </a></li>
                           
                            <?php if(isset($subscriptionType) && $subscriptionType==1){ ?>
                                <li><a href="<?php echo base_url(lang().'/media/photographyart/renewmedialist');?>"><b><?php echo $this->lang->line('Your_mediaRenew');  ?></b>  <?php echo $this->lang->line('Your_mediaphotoart');  ?>   </a></li>
                            <?php } ?>
                        
                        <?php } if(in_array('3',$completetMediaList)) { ?> 
                            
                            <li><a href="<?php echo base_url(lang().'/media/writingpublishing/completeyourcollection');?>"><b><?php echo $this->lang->line('Your_mediaComplete');  ?></b> <?php echo $this->lang->line('Your_mediawritecoll');  ?> </a></li>
                            
                            <?php if(isset($subscriptionType) && $subscriptionType==1){ ?>
                                <li><a href="<?php echo base_url(lang().'/media/writingpublishing/renewmedialist');?>"><b><?php echo $this->lang->line('Your_mediaRenew');  ?></b> <?php echo $this->lang->line('Your_mediawritecoll');  ?>  </a></li>
                            <?php } ?>
                            
                        <?php } if(in_array('10',$completetMediaList)) { ?> 
                        
                            <li><a href="<?php echo base_url(lang().'/media/educationmaterials/completeyourcollection');?>"><b><?php echo $this->lang->line('Your_mediaComplete');  ?></b> <?php echo $this->lang->line('Your_mediacreativeindustries');  ?> </a></li>
                            
                            <?php if(isset($subscriptionType) && $subscriptionType==1){ ?>
                                <li><a href="<?php echo base_url(lang().'/media/educationmaterials/renewmedialist');?>"><b><?php echo $this->lang->line('Your_mediaRenew');  ?></b> <?php echo $this->lang->line('Your_mediacreativeindustries');  ?></a></li>
                            <?php } ?>
                            
                        <?php } ?>  
                       
                       <!--
                       <li  ><a class="red fs12 text_alignL"> Another member has reported a problem with your Showcase
                          The item has been taken off your Showcase. See the item in question. </a>
                       </li>-->
                    </ul>
                <?php   }   ?>
            
            <!----- Not converted media file links ----->
            <?php if($isFailedConversion) { ?>
                <ul class="width100_per listpb10 failed_conversion fs14 red red_arrow_list">
                    <?php
                    if( !empty($failedVideoCount) && $failedVideoCount > 0) {
                        echo '<li><a href="'.base_url(lang().'/media/filmvideo/pendingconversion').'"> Your video did not convert </a></li>';
                    }
                    if( !empty($failedAudioCount) && $failedAudioCount > 0) {
                        echo '<li><a href="'.base_url(lang().'/media/musicaudio/pendingconversion').'"> Your audio did not convert </a></li>';
                    }
                    if( !empty($failedTextCount) && $failedTextCount > 0) {
                        echo '<li><a href="'.base_url(lang().'/media/writingpublishing/pendingconversion').'"> Your text file did not convert </a></li>';
                    }
                ?>
                </ul>
                <span class="sap_30 bd_t"></span>
            <?php   }   ?>
            
            <?php if($isFilmNvideo) { ?> 
                <h3 class=" fs18 red opens_light">Film & Video Collections </h3>
                <span class="sap_10"></span> 
                <ul class="width100_per listpb10  fs14  red_arrow_list">
                   <li><a href="<?php echo base_url(lang().'/media/filmvideo/publicisemediacollection');?>"> Publicise your  Collections </a></li>
                   <li><a href="<?php echo base_url(lang().'/mediafrontend/editfilmvideocollection');?>">Edit your  Collections  </a></li>
                   <li><a href="<?php echo base_url(lang().'/mediafrontend/filmvideocollection/'.$isLoginUser);?>">  View your  Collections </a></li>
                </ul>
                <span class="sap_30 bd_t "></span>
              <?php } if($isMusicNaudio) { ?> 
                  
                <h3 class=" fs18 red opens_light">Music Albums & Audio Collections </h3>
                <span class="sap_10"></span> 
                <ul class="width100_per listpb10  fs14  red_arrow_list">
                   <li><a href="<?php echo base_url(lang().'/media/musicaudio/publicisemediacollection');?>"> Publicise your Albums &  Collections </a></li>
                   <li><a href="<?php echo base_url(lang().'/mediafrontend/editmusicaudiocollection');?>">Edit your Albums & Collections  </a></li>
                   <li><a href="<?php echo base_url(lang().'/mediafrontend/musicaudiocollection/'.$isLoginUser);?>">  View your Albums & Collections </a></li>
                </ul>
                <span class="sap_30 bd_t "></span>
            
            <?php } if($isPhotographyNart) { ?>  
            
                <h3 class=" fs18 red opens_light">Photography Albums & Art Collections </h3>
                <span class="sap_10"></span> 
                <ul class="width100_per listpb10  fs14  red_arrow_list">
                   <li><a href="<?php echo base_url(lang().'/media/photographyart/publicisemediacollection');?>"> Publicise your Albums & Collections </a></li>
                   <li><a href="<?php echo base_url(lang().'/mediafrontend/editphotoartcollection');?>">Edit your Albums & Collections  </a></li>
                   <li><a href="<?php echo base_url(lang().'/mediafrontend/photoartcollection/'.$isLoginUser);?>">  View your Albums & Collections </a></li>
                </ul>
                <span class="sap_30 bd_t "></span>
            
            <?php  } if($isWritingNpublishing) { ?>  
            
                <h3 class=" fs18 red opens_light">Writing Collections</h3>
                <span class="sap_10"></span> 
                <ul class="width100_per listpb10  fs14  red_arrow_list">
                   <li><a href="<?php echo base_url(lang().'/media/writingpublishing/publicisemediacollection');?>"> Publicise your  Collections </a></li>
                   <li><a href="<?php echo base_url(lang().'/mediafrontend/editwritingpubcollection');?>">Edit your  Collections  </a></li>
                   <li><a href="<?php echo base_url(lang().'/mediafrontend/writingpubcollection/'.$isLoginUser);?>">  View your  Collections </a></li>
                </ul>
                <span class="sap_30 bd_t "></span>
            <?php  } if($isEducationMaterial) { ?>            
                 
                <h3 class=" fs18 red opens_light">Education Collections</h3>
                <span class="sap_10"></span> 
                <ul class="width100_per listpb10  fs14  red_arrow_list">
                   <li><a href="<?php echo base_url(lang().'/media/educationmaterials/publicisemediacollection');?>"> Publicise your  Collections </a></li>
                   <li><a href="<?php echo base_url(lang().'/mediafrontend/editeducationalcollection');?>">Edit your  Collections  </a></li>
                   <li><a href="<?php echo base_url(lang().'/mediafrontend/educationalcollection/'.$isLoginUser);?>">  View your  Collections </a></li>
                </ul>
            
            <?php } ?>     
            
         </span>
         <div class="your_toad_subhead  bt_none red fs18"> What type of Media do you want to showcase?</div>
         <form action="<?php echo base_url(lang().'/media/setmediaaddtype');?>" method="post" id="mediaAddForm">
             <span class="content_menu pl35  pt30 pr30">
                <ul class="pl41 red_arrow_list menu_radio defaultP  listpb10">
                    <li><input type="radio" name="mediaType" class="mediaselect" id="filmvideo"  checked="checked" value="<?php echo $this->config->item('filmNvideoSectionId');?>"/><?php echo $this->lang->line('Your_FV');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="mediaselect" id="musicaudio"  value="<?php echo $this->config->item('musicNaudioSectionId');?>"/><?php echo $this->lang->line('Your_MA');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="mediaselect" id="photographyart" value="<?php echo $this->config->item('photographyNartSectionId');?>"/><?php echo $this->lang->line('Your_PA');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="mediaselect" id="writingpublishing" value="<?php echo $this->config->item('writingNpublishingSectionId');?>"/><?php echo $this->lang->line('Your_W');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="mediaselect" id="educationmaterials" value="<?php echo $this->config->item('educationMaterialSectionId');?>"/><?php echo $this->lang->line('Your_EM');  ?></a></li>
                </ul>
                <span class="sap_20"></span>
                <p class="text_alignC">
                   <button class=" width_208 gray_btn mediaselctedsubmit" type="button">Add a Media Showcase</button>
                </p>
             </span>
         </form>
      </li>
   </ul>
</li>
