<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="fl width258"> 
    <?php
    $keyword=$this->input->post('keyWord');
    $postSectionId=($this->input->post('sectionId')>0)?$this->input->post('sectionId'):0;
    
    $formAttributes = array(
    'name'=>'advanceSearchForm',
    'id'=>'advanceSearchForm',
    );
    echo form_open(base_url(lang().'/search/result/'),$formAttributes);
        $keyword=(isset($keyword) && $keyword !='' )?$keyword:$this->lang->line('keywordSearch');
        ?>
        <div class="searchbarbg width258imp clearb mt0 fs13 ml0 fl">
            <input class="font_wN fs13" type="text" name="keyWord" value="<?php echo $keyword;?>"  placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
            <input name="Submit" type="submit" class="searchbtbbg" value="Submit"  />
        </div>
        
        <div class="position_relative clearb fl categary height30 mt8" >
            <?php
                echo form_dropdown('languageId', $languageList, 1,'id="languageId" class="width255 select_shadow fs13" ');
             ?>
        </div>
        
        <div class="position_relative clearb fl categary height30 mt8" >
            <?php
                echo form_dropdown('producedInCountry', $countryList, '','id="producedInCountry" class="width255 select_shadow fs13" ');
             ?>
        </div>
        
        <?php $dateSections='|'.$this->config->item('performancesneventsSectionId').'|';?>
        
        <div class="fl  clearb mt10 dn hs" section_name="date" section="<?php echo $dateSections;?>" >
            <div class="to_wrap fl clearbox position_relative">
                <label class="pl7 width_50 pt7 fl" for="to">From</label>
                <input class="datepicker hasDatepicker" id="eventStartDate" name="eventStartDate" type="text" readonly placeholder="<?php echo date('F : Y');?>" value=""><button type="button" class="ui-datepicker-trigger" onclick='$("#eventStartDate").focus();'>...</button>
            </div>
            <div class="frm_wrap  clearbox position_relative fl mt8">
                <label class="pl7 width_50 pt7 fl" for="to">To</label>
                <input class="datepicker hasDatepicker" id="eventEndDate" name="eventEndDate" type="text" readonly placeholder="<?php echo date('F : Y');?>" value=""><button id="eventEndDateCal" type="button" class="ui-datepicker-trigger" onclick="$('#eventEndDate').focus();">...</button>
            </div>
        </div>
                  
        <?php $citySections='|member|'.$this->config->item('creativesSectionId').'|'.$this->config->item('associateprofessionalSectionId').'|'.$this->config->item('enterprisesSectionId').'|'.$this->config->item('fansSectionId').'|'.$this->config->item('performancesneventsSectionId').'|'.$this->config->item('worksSectionId').'|'.$this->config->item('productsSectionId').'|';?>
        <div class="searchbarbg width258imp clearb fs13 ml0 fl mt8 dn hs" section_name="city" section="<?php echo $citySections;?>" >
            <input class="font_wN fs13" type="text" name="city"  placeholder="<?php echo $this->lang->line('twnRcity');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('twnRcity');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('twnRcity');?>','show')">
        </div>

        <ul class="clearb mt10 select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb0 select_list " section_name="sectionId"  >
            <?php
            //$sectionList = $this->config->item('search_section');
            if(is_array($sectionList) && !empty($sectionList)){
                foreach($sectionList as $sectionId=>$section){ 
                    $checked = (is_numeric($sectionId) && $sectionId == 0)?'checked':'';
                    ?>
                    <li>
                        <label>
                            <input <?php echo $checked;?> selectedoption="selected_<?php echo $sectionId;?>" type="radio" name="sectionId" class="sectionId" value="<?php echo $sectionId;?>" ><?php echo $section;?>
                         </label>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        <?php $memberSections='|member|'.$this->config->item('creativesSectionId').'|'.$this->config->item('associateprofessionalSectionId').'|'.$this->config->item('enterprisesSectionId').'|'.$this->config->item('fansSectionId').'|';?>
        <ul class="clearb mt10 select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="projectPart" section="<?php echo $memberSections;?>" >
        <?php
            $showcase_section = $this->config->item('showcase_section');
            if(is_array($showcase_section) && !empty($showcase_section)){
                foreach($showcase_section as $sectionId=>$part){ 
                    $selectedoption = (!empty($sectionId) && $sectionId == 'member')?'id="selected_member"':'';
                    if(is_array($part)){
                        $selectoption = ($sectionId == 6 || $sectionId == 7 || $sectionId == 8) ? "selected_showcase_industry":"";?>
                        <li class="bbf9b8a4 pb0 mb10 ml30"></li>
                        <li>
                            <label>
                               <input selectedoption="<?php echo $selectoption;?>" type="radio" name="projectPart" class="sectionId" value="<?php echo $sectionId;?>" /><b><?php echo $this->lang->line('searchSection'.$sectionId);?></b>
                             </label>
                        </li> <?php
                        if(!empty($part))foreach($part as $partId=>$projectPart){ ?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" class="sectionId" value="<?php echo $partId;?>" not_in_section="industry" /><?php echo $projectPart;?>
                                 </label>
                            </li><?php
                        }
                    }else{ ?>
                        <li>
                            <label>
                                <input <?php echo $selectedoption;?> type="radio" name="projectPart" class="sectionId" value="<?php echo $sectionId;?>"   /><?php echo $part;?>
                             </label>
                        </li><?php
                    }
                }
            }?>
        </ul>
        
        <?php $mediaSections='|media|'.$this->config->item('filmnvideoSectionId').'|'.$this->config->item('musicnaudioSectionId').'|'.$this->config->item('writingnpublishingSectionId').'|'.$this->config->item('photographynartSectionId').'|'.$this->config->item('educationmaterialSectionId').'|';?>
        <ul class="clearb mt10 select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="sectionId2" section="<?php echo $mediaSections;?>" >
        <?php
            $media_section = $this->config->item('media_section');
            if(is_array($media_section) && !empty($media_section)){
                foreach($media_section as $sectionId=>$part){ 
                    $selectedoption = (!empty($sectionId) && $sectionId == 'media')?'id="selected_media"':''; ?>
                    <li>
                        <label>
                            <input <?php echo $selectedoption;?> selectedoption="selected_<?php echo $sectionId;?>" type="radio" name="sectionId2" class="sectionId" value="<?php echo $sectionId;?>" not_in_section="type|industry" ><?php echo $part;?>
                         </label>
                    </li>
                   <?php
                }
            }?>
        </ul>
        
        <?php $fvSections='|'.$this->config->item('filmnvideoSectionId').'|';?>
        <ul class="clearb mt10 select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="projectPart" section="<?php echo $fvSections;?>" >
        <?php
            $fv_section = $this->config->item('fv_section');
            if(is_array($fv_section) && !empty($fv_section)){
                foreach($fv_section as $sectionId=>$part){
                    $selectedoption = (is_numeric($sectionId) && $sectionId == $this->config->item('filmnvideoSectionId'))?'id="selected_'.$sectionId.'"':'';
                    if(is_array($part)){?>
                        <li class="bbf9b8a4 pb0 mb10 ml30"></li>
                        
                        <?php if($this->lang->line('searchSection'.$sectionId)){?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" class="sectionId" value="<?php echo $sectionId;?>" ><b><?php echo $this->lang->line('searchSection'.$sectionId);?></b>
                                 </label>
                            </li> <?php
                        }
                        if(!empty($part))foreach($part as $partId=>$projectPart){ ?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" class="sectionId" value="<?php echo $partId;?>" not_in_section="type" ><?php echo $projectPart;?>
                                 </label>
                            </li><?php
                        }
                    }else{ ?>
                        <li>
                            <label>
                                <input <?php echo $selectedoption;?> type="radio" name="projectPart" class="sectionId" value="<?php echo $sectionId;?>" not_in_section="type" ><?php echo $part;?>
                             </label>
                        </li><?php
                    }
                }
            }?>
        </ul>
        
        <?php $maSection='|'.$this->config->item('musicnaudioSectionId').'|';?>
        <ul class="clearb mt10 select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="projectPart" section="<?php echo $maSection;?>" >
        <?php
            $ma_section = $this->config->item('ma_section');
            if(is_array($ma_section) && !empty($ma_section)){
                foreach($ma_section as $sectionId=>$part){ 
                    $selectedoption = (is_numeric($sectionId) && $sectionId == $this->config->item('musicnaudioSectionId'))?'id="selected_'.$sectionId.'"':'';
                    if(is_array($part)){?>
                        <li class="bbf9b8a4 pb0 mb10 ml30"></li>
                        <?php if($this->lang->line('searchSection'.$sectionId)){?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" class="sectionId" value="<?php echo $sectionId;?>" ><b><?php echo $this->lang->line('searchSection'.$sectionId);?></b>
                                 </label>
                            </li> <?php
                        }
                        if(!empty($part))foreach($part as $partId=>$projectPart){ ?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" class="sectionId" value="<?php echo $partId;?>" not_in_section="type" ><?php echo $projectPart;?>
                                 </label>
                            </li><?php
                        }
                    }else{ ?>
                        <li>
                            <label>
                                <input <?php echo $selectedoption;?> type="radio" name="projectPart" class="sectionId" value="<?php echo $sectionId;?>" not_in_section="type" ><?php echo $part;?>
                             </label>
                        </li><?php
                    }
                }
            }?>
        </ul>
        
        <?php $wpSections='|'.$this->config->item('writingnpublishingSectionId').'|';?>
        <ul class="clearb mt10 select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="projectPart" section="<?php echo $wpSections;?>" >
        <?php
            $wp_section = $this->config->item('wp_section');
            if(is_array($wp_section) && !empty($wp_section)){
                foreach($wp_section as $sectionId=>$part){ 
                    $selectedoption = (is_numeric($sectionId) && $sectionId == $this->config->item('writingnpublishingSectionId'))?'id="selected_'.$sectionId.'"':'';
                    if(is_array($part)){?>
                        <li class="bbf9b8a4 pb0 mb10 ml30"></li>
                        
                        <?php if($this->lang->line('searchSection'.$sectionId)){?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" class="sectionId" value="<?php echo $sectionId;?>" ><b><?php echo $this->lang->line('searchSection'.$sectionId);?></b>
                                 </label>
                            </li> <?php
                        }
                        if(!empty($part))foreach($part as $partId=>$projectPart){ ?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" class="sectionId" value="<?php echo $partId;?>" not_in_section="type" ><?php echo $projectPart;?>
                                 </label>
                            </li><?php
                        }
                    }else{ ?>
                        <li>
                            <label>
                                <input <?php echo $selectedoption;?> type="radio" name="projectPart" class="sectionId" value="<?php echo $sectionId;?>" not_in_section="type" ><?php echo $part;?>
                             </label>
                        </li><?php
                    }
                }
            }?>
        </ul>
        
        <?php $paSection='|'.$this->config->item('photographynartSectionId').'|';?>
        <ul class="clearb mt10 select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="projectPart" section="<?php echo $paSection;?>" >
        <?php
            $pa_section = $this->config->item('pa_section');
            if(is_array($pa_section) && !empty($pa_section)){
                foreach($pa_section as $sectionId=>$part){ 
                    $selectedoption = (is_numeric($sectionId) && $sectionId == $this->config->item('photographynartSectionId'))?'id="selected_'.$sectionId.'"':'';
                    if(is_array($part)){?>
                        <li class="bbf9b8a4 pb0 mb10 ml30"></li>
                        <?php if($this->lang->line('searchSection'.$sectionId)){?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" class="sectionId" value="<?php echo $sectionId;?>" ><b><?php echo $this->lang->line('searchSection'.$sectionId);?></b>
                                 </label>
                            </li> <?php
                        }
                        if(!empty($part))foreach($part as $partId=>$projectPart){ ?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" class="sectionId" value="<?php echo $partId;?>" not_in_section="type" ><?php echo $projectPart;?>
                                 </label>
                            </li><?php
                        }
                    }else{ ?>
                        <li>
                            <label>
                                <input <?php echo $selectedoption;?> type="radio" name="projectPart" class="sectionId" value="<?php echo $sectionId;?>" not_in_section="type" ><?php echo $part;?>
                             </label>
                        </li><?php
                    }
                }
            }?>
        </ul>
        
        <?php $emSections='|'.$this->config->item('educationmaterialSectionId').'|';?>
        <ul class="clearb mt10 select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="projectPart" section="<?php echo $emSections;?>" >
        <?php
            $em_section = $this->config->item('em_section');
            if(is_array($em_section) && !empty($em_section)){
                foreach($em_section as $sectionId=>$part){ 
                    $selectedoption = (is_numeric($sectionId) && $sectionId == $this->config->item('educationmaterialSectionId'))?'id="selected_'.$sectionId.'"':'';
                    if(is_array($part)){
                        $selectoption = ($sectionId == '10-12-elements') ? "selected_em_industry":"";?>
                        <li class="bbf9b8a4 pb0 mb10 ml30"></li>
                        
                        <?php if($this->lang->line('searchSection'.$sectionId)){?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" selectedoption="<?php echo $selectoption;?>" class="sectionId" value="<?php echo $sectionId;?>" ><b><?php echo $this->lang->line('searchSection'.$sectionId);?></b>
                                 </label>
                            </li> <?php
                        }
                        if(!empty($part))foreach($part as $partId=>$projectPart){ ?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" class="sectionId" value="<?php echo $partId;?>" not_in_section="industry" ><?php echo $projectPart;?>
                                 </label>
                            </li><?php
                        }
                    }else{ ?>
                        <li>
                            <label>
                                <input <?php echo $selectedoption;?> type="radio" name="projectPart" class="sectionId" value="<?php echo $sectionId;?>" not_in_section="industry" ><?php echo $part;?>
                             </label>
                        </li><?php
                    }
                }
            }?>
        </ul>
        
        <?php $eventSections='|'.$this->config->item('performancesneventsSectionId').'|';?>
        <ul class="clearb mt10 select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="projectPart" section="<?php echo $eventSections;?>" >
        <?php
            $event_section = $this->config->item('event_section');
            if(is_array($event_section) && !empty($event_section)){
                foreach($event_section as $sectionId=>$part){ 
                    $selectedoption = (is_numeric($sectionId) && $sectionId == $this->config->item('performancesneventsSectionId'))?'id="selected_'.$sectionId.'"':'';
                    if(is_array($part)){?>
                        <li class="bbf9b8a4 pb0 mb10 ml30"></li>
                        
                        <?php if($this->lang->line('searchSection'.$sectionId)){?>
                            <li>
                                <label>
                                    <input  type="radio" name="projectPart" class="sectionId" selectedoption="selected_<?php echo $sectionId;?>" value="<?php echo $sectionId;?>" ><b><?php echo $this->lang->line('searchSection'.$sectionId);?></b>
                                 </label>
                            </li> <?php
                        }
                        if(!empty($part))foreach($part as $partId=>$projectPart){
                            $selectoption = ($partId == '9-industry-free') ? "selected_".$sectionId :"selected_".$partId;
                            ?>
                            <li>
                                <label>
                                    <input type="radio" name="projectPart" class="sectionId" selectedoption="<?php echo $selectoption;?>" value="<?php echo $partId;?>"  ><?php echo $projectPart;?>
                                 </label>
                            </li><?php
                        }
                    }else{ ?>
                        <li>
                            <label>
                                <input <?php echo $selectedoption;?> type="radio" name="projectPart" class="sectionId" selectedoption="selected_<?php echo $sectionId;?>" value="<?php echo $sectionId;?>"  ><?php echo $part;?>
                             </label>
                        </li><?php
                    }
                }
            }?>
        </ul>

        <?php $industrySections='|'.$this->config->item('creativesSectionId').'|'.$this->config->item('associateprofessionalSectionId').'|'.$this->config->item('enterprisesSectionId').'|';?>
        <ul class="clearb mt10 memberform select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="industry" section="<?php echo $industrySections;?>">
            <li class=" pb12 red bd_none font_bold ml30">Members From</li>
            <?php
            $showcase_industry = $this->config->item('showcase_industry');
            if(is_array($showcase_industry) && !empty($showcase_industry)){
                foreach($showcase_industry as $industryId=>$industry){
                    $selectedoption = (!empty($industryId) && $industryId == 'showcase_industry')?'id="selected_showcase_industry"':'';
                    ?>
                    <li>
                        <label>
                            <input <?php echo $selectedoption;?> type="radio" name="industryId" class="industryId" value="<?php echo $industryId;?>" ><?php echo $industry;?>
                         </label>
                    </li>
                    <?php
                }
            }?>
        </ul>
        
        <?php $industrySections='|'.$this->config->item('educationmaterialSectionId').'|';?>
        <ul class="clearb mt10 memberform select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="industry" section="<?php echo $industrySections;?>">
            <li class=" pb12 red bd_none font_bold ml30">Education For</li>
            <?php
            $em_industry = $this->config->item('em_industry');
            if(is_array($em_industry) && !empty($em_industry)){
                foreach($em_industry as $industryId=>$industry){
                    $selectedoption = (!empty($sectionId) && $sectionId == 'em_industry')?'id="selected_'.$sectionId.'"':'';
                     ?>
                    <li>
                        <label>
                            <input <?php echo $selectedoption;?> type="radio" name="industryId" class="industryId" value="<?php echo $industryId;?>" ><?php echo $industry;?>
                         </label>
                    </li>
                    <?php
                }
            }?>
        </ul>
        
        <?php $industrySections='|'.$this->config->item('performancesneventsSectionId').'-industry|'.$this->config->item('performancesneventsSectionId').'-industry-free|';?>
        <ul class="clearb mt10 memberform select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="industry" section="<?php echo $industrySections;?>">
            <li class=" pb12 red bd_none font_bold ml30">Events For</li>
            <?php
            $event_industry = $this->config->item('event_industry');
            if(is_array($event_industry) && !empty($event_industry)){
                foreach($event_industry as $industryId=>$industry){
                    $selectedoption = (!empty($industryId) && $industryId == $this->config->item('performancesneventsSectionId').'-industry')?'id="selected_'.$industryId.'"':'';
                    ?>
                    <li>
                        <label>
                            <input <?php echo $selectedoption;?> type="radio" name="industryId" class="industryId" value="<?php echo $industryId;?>" ><?php echo $industry;?>
                         </label>
                    </li>
                    <?php
                }
            }?>
        </ul>
        <?php $industrySections='|'.$this->config->item('performancesneventsSectionId').'-upcoming|';?>
        <ul class="clearb mt10 memberform select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="industry" section="<?php echo $industrySections;?>">
            <li class=" pb12 red bd_none font_bold ml30">Events For</li>
            <?php
            $upcoming_events_industry = $this->config->item('upcoming_events_industry');
            if(is_array($upcoming_events_industry) && !empty($upcoming_events_industry)){
                foreach($upcoming_events_industry as $industryId=>$industry){ 
                   $selectedoption = (!empty($industryId) && $industryId == $this->config->item('performancesneventsSectionId').'-upcoming')?'id="selected_'.$industryId.'"':'';
                   ?>
                    <li>
                        <label>
                            <input <?php echo $selectedoption;?> type="radio" name="industryId" class="industryId" value="<?php echo $industryId;?>" ><?php echo $industry;?>
                         </label>
                    </li>
                    <?php
                }
            }?>
        </ul>
        
        <?php $industrySections='|'.$this->config->item('blogsSectionId').'|';?>
        <ul class="clearb mt10 memberform select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="industry" section="<?php echo $industrySections;?>">
            <li class=" pb12 red bd_none font_bold ml30">Blogs About</li>
            <?php
            $blog_industry = $this->config->item('blog_industry');
            if(is_array($blog_industry) && !empty($blog_industry)){
                foreach($blog_industry as $industryId=>$industry){
                    $selectedoption = (!empty($industryId) && $industryId == $this->config->item('blogsSectionId'))?'id="selected_'.$industryId.'"':'';
                    ?>
                    <li>
                        <label>
                            <input <?php echo $selectedoption;?> type="radio" name="industryId" class="industryId" value="<?php echo $industryId;?>" ><?php echo $industry;?>
                         </label>
                    </li>
                    <?php
                }
            }?>
        </ul>
        
        <?php $industrySections='|'.$this->config->item('eventnoticesSectionId').'|';?>
        <ul class="clearb mt10 memberform select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="industry" section="<?php echo $industrySections;?>">
            <li class=" pb12 red bd_none font_bold ml30">Event Notices from</li>
            <?php
            $event_notices_industry = $this->config->item('event_notices_industry');
            if(is_array($event_notices_industry) && !empty($event_notices_industry)){
                foreach($event_notices_industry as $industryId=>$industry){
                    $selectedoption = (!empty($industryId) && $industryId == $this->config->item('eventnoticesSectionId'))?'id="selected_'.$industryId.'"':'';
                    ?>
                    <li>
                        <label>
                            <input <?php echo $selectedoption;?> type="radio" name="industryId" class="industryId" value="<?php echo $industryId;?>" ><?php echo $industry;?>
                         </label>
                    </li>
                    <?php
                }
            }?>
        </ul>
        
        <?php $industrySections='|'.$this->config->item('favouritesitesSectionId').'|';?>
        <ul class="clearb mt10 memberform select_shadow defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb5 select_list dn hs" section_name="industry" section="<?php echo $industrySections;?>">
            <li class=" pb12 red bd_none font_bold ml30">Favourite Sites for</li>
            <?php
            $favourite_sites_industry = $this->config->item('favourite_sites_industry');
            if(is_array($favourite_sites_industry) && !empty($favourite_sites_industry)){
                foreach($favourite_sites_industry as $industryId=>$industry){
                    $selectedoption = (!empty($industryId) && $industryId == $this->config->item('favouritesitesSectionId'))?'id="selected_'.$industryId.'"':'';
                    ?>
                    <li>
                        <label>
                            <input <?php echo $selectedoption;?> type="radio" name="industryId" class="industryId" value="<?php echo $industryId;?>" ><?php echo $industry;?>
                         </label>
                    </li>
                    <?php
                }
            }?>
        </ul>
        
        <?php
		if($catProjectTypelist && is_array($catProjectTypelist) && count($catProjectTypelist) > 0 ){
			foreach($catProjectTypelist as $key=>$projectCatlist){
				$sectionId=$key;
                $typeSection='|'.$sectionId.'|'; ?>
                <div class="clearb mt8 select_shadow defaultP bdr_a1a1a1 fs13 width255 select_list dn hs" section_name="type" section="<?php echo $typeSection;?>">
                    <div class="slect_menu bdr_a1a1a1 select_shadow bg_f6f6f6 p5 m3">
                        <label class="font_bold">
                                <input class="allCheckBox" type="checkbox" name="alltype[]" id="allItem<?php echo $sectionId?>" value="alltype" onclick="checkUncheck(this, 0, '.CheckBox<?php echo $sectionId?>')"  />All 
                        </label>
                    </div> <?php
                    if($projectCatlist && is_array($projectCatlist) && count($projectCatlist) > 0){
                        foreach($projectCatlist as $catId=>$projectTypelist){
                            if($projectTypelist && is_array($projectTypelist) && count($projectTypelist) > 0 ){
                                foreach($projectTypelist as $typeId=>$projectTypeName){ ?>
                                    <div class="clearb block1 select_shadow"><?php 
                                        if (!in_array($sectionId,array($this->config->item('musicnaudioSectionId'),$this->config->item('photographynartSectionId')))){?>
                                            <div class="slect_menu bdr_a1a1a1 bg_f6f6f6 p5 inner_selct">
                                                <label class="all_click font_bold">
                                                    <input class="collection CheckBox<?php echo $sectionId?>" type="checkbox" name="typeId[]" id="typeId<?php echo $typeId;?>" value="<?php echo $typeId;?>" onclick="checkUncheck(this, 0, '.checkbox<?php echo $typeId;?>'); checkUncheckParent('.CheckBox<?php echo $sectionId?>','#allItem<?php echo $sectionId?>')" />
                                                    <?php echo $projectTypeName;?>
                                                </label>
                                                <span onclick="toggleDivArrow('toggleGenreList<?php echo $typeId;?>',this)" class="fr r_arrow"></span> 
                                            </div> <?php
                                        }
                                        if($projectTypeGenerList[$typeId] && is_array($projectTypeGenerList[$typeId]) && count($projectTypeGenerList[$typeId]) > 0 ){ 
                                            $genreSection = '|'.$sectionId.'-'.$catId.'-'.$typeId.'-elements|';
                                            ?>
                                            <ul class="clearb overview dn hs" id="toggleGenreList<?php echo $typeId;?>" section_name="genre" section="<?php echo $genreSection;?>"> <?php
                                                foreach($projectTypeGenerList[$typeId] as $GenreId=>$Genre){ ?>
                                                    <li>
                                                        <label>
                                                        <input class="flims collection CheckBox<?php echo $sectionId?> checkbox<?php echo $typeId;?>" type="checkbox" name="GenreId[]" id="GenreId<?php echo $GenreId;?>" value="<?php echo $GenreId;?>" onclick="checkUncheckParent('.checkbox<?php echo $typeId;?>','#typeId<?php echo $typeId;?>'); checkUncheckParent('.CheckBox<?php echo $sectionId?>','#allItem<?php echo $sectionId?>')"  />
                                                        <span><?php echo $Genre;?></span>
                                                        </label>
                                                    </li>
                                                    <?php
                                                } ?>
                                            </ul><?php
                                        }?>
                                    </div><?php
                                }
                            }
                        }
                    }?>
                </div><?php
			}
		}?>        
        <div class="sap_15"></div>
        <button type="button" class="clearb red fr white_button" onclick="$('#advanceSearchForm').submit();">Search</button>
        <?php 
    echo form_close(); ?>
</div>
