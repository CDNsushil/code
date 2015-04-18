<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box">
        <div class="clearb pt13 ml15 mr15 bb_F1592A">
            <span class="fl search_title font_bold width_333"><?php echo getSubString($search->title,100);?></span>
            <b class="fr red search_cat lettsp1"><?php echo $this->lang->line('filmNvideo');?></b>
            <div class="sap_10"></div>
        </div>
        <div class="bgf4f4f4 pt8 pb5 display_table  lettsp-1 width100_per">
            <b class="fl pl15  red "><?php echo getSubString($search->creative_name,50);?></b> 
            <?php
            if($search->sell_option != 'paid'){
                echo '<span class="fr fs13 pr15"><b class="red">'.$this->lang->line('FREE').'</b> </span>';
            }?>
        </div>
        <div class="fl search_title_img clearb display_table">
            <span class="table_cell"><img alt="" src="<?php echo $search->searchImage;?>"></span>
        </div>
        <div class=" text_alighL fr cnt_crev ">
            <div class="fs23 pl20 pt5 opens_light">
                <span class="red">
                    <?php
                        echo (isset($search->type) && !empty($search->type))?$search->type:'';
                    ?>
                </span>
                <span class="green pl15">
                <?php
                    echo (isset($search->genre) && !empty($search->genre))?$search->genre:' ';
                ?>
                </span>
            </div>
            <div class="sap_15"></div>
            <b class="pl23 pt10">
                <?php
                    echo (isset($search->subgenre) && !empty($search->subgenre))?$search->subgenre:' ';
                ?>
            </b>
            <div class="sap_10"></div>
            <div class="btd2d2d2 pt15 pl20">
                <?php
                if($search->sell_option != 'paid' && $search->videoFileCount >= 1){
                    echo '<b>'.$this->lang->line('videoFile').'</b>';
                }elseif($search->sell_option == 'paid' && $search->dvdCount >= 1){
                    echo '<b>'.$this->lang->line('DVD').'</b>';
                }?>
                <div class="head_list pr5  fr ">
                    <div class="icon_view3_blog icon_so"><?php echo $search->viewCount>0?$search->viewCount:0;?></div>
                    <div class="icon_crave4_blog icon_so"><?php echo $search->craveCount>0?$search->craveCount:0;?></div>
                    <div class="rating fl pt6"><img src="<?php echo base_url($search->ratingImg);?>"></div>
                    <div class="btn_share_icon icon_so"><?php echo $search->reviewCount>0?$search->reviewCount:0;?></div>
                </div>
            </div>
        </div>
    </div>
</a>
