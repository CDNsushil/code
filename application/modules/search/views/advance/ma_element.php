<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box">
        <div class="clearb pt12 ml15 mr15 headtitle">
            <span class="fl search_title font_bold width_333"><?php echo getSubString($search->title,100);?></span>
            <b class="fr red search_cat lettsp1"><?php echo $this->lang->line('musicNaudio');?></b>
            <div class="sap_10"></div>
        </div>
        <div class="gray_box">
            <span class="fl lettsp1 textindent203"><?php echo getSubString($search->creative_name,50);?></span> 
            <span class="fr pr15">
                <?php
                if($search->sell_option != 'paid' && $search->audioFileCount >= 1){
                    echo '<b class="pr7">'.$this->lang->line('musicFile').'</b>';
                }elseif($search->sell_option == 'paid' && $search->cdCount >= 1){
                    echo '<b class="pr7">'.$this->lang->line('CD').'</b>';
                }?>
                <b class="red">
                <?php
                if($search->sell_option != 'paid'){
                    echo $this->lang->line('FREE');
                }?>
                </b>
            </span>
        </div>
        <div class="fl  clearb display_table position_relative">
            <span class="table_cell project_box ">
                <img class="max-159" alt="" src="<?php echo $search->searchImage;?>">
            </span>
        </div>
        <div class=" text_alighL fr cnt_crev width375">
            <div class="sap_35"></div>
            <div class="fs23 pl15 pt10 opensans_regular">
                <span class="green">
                    <?php
                        echo (isset($search->genre) && !empty($search->genre))?$search->genre:' ';
                    ?>
                </span>
            </div>
            <div class="sap_25"></div>
            <b class="pl15 pt10">
                <?php
                    echo (isset($search->subgenre) && !empty($search->subgenre))?$search->subgenre:' ';
                ?>
            </b>
            <div class="sap_10"></div>
            <div class="head_list pr5  fr ">
                <div class="icon_view3_blog icon_so"><?php echo $search->viewCount>0?$search->viewCount:0;?></div>
                <div class="icon_crave4_blog icon_so"><?php echo $search->craveCount>0?$search->craveCount:0;?></div>
                <div class="rating fl pt6"><img src="<?php echo base_url($search->ratingImg);?>"></div>
                <div class="btn_share_icon icon_so"><?php echo $search->reviewCount>0?$search->reviewCount:0;?></div>
            </div>
        </div>
    </div>
</a>
