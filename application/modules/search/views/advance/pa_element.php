<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box pa_box">
        <div class="clearb pt12 ml15 mr15 ">
            <span class="fl search_title width_333 font_bold"><?php echo getSubString($search->title,100);?></span>
            <b class="fr red search_cat lettsp1"><?php echo $this->lang->line('photographyNart');?></b>
            <div class="sap_10"></div>
        </div>
        <div class="clearb pl15  pr15 width100_per box_siz display_table">
            <div class="gray_box">
                <b class="fl red pl15"><?php echo getSubString($search->creative_name,50);?></b> 
            </div>
            <div class=" text_alighL    content_box pr27  table_cell">
                <div class="sap_50"></div>
                <div class="fs23 opensans_regular">
                    <span class="green">
                        <?php
                            echo (isset($search->genre) && !empty($search->genre))?$search->genre:' ';
                        ?>
                    </span>
                </div>
                <b class="pt10">
                    <?php
                        echo (isset($search->subgenre) && !empty($search->subgenre))?$search->subgenre:' ';
                    ?>
                </b>
                <div class="pr20 pt10">
                    <?php
                    if($search->sell_option != 'paid' && $search->imageFileCount >= 1){
                        echo '<b class="pr7">'.$this->lang->line('imageFile').'</b>';
                    }elseif($search->sell_option == 'paid' && $search->printCount >= 1){
                        echo '<b class="pr7">'.$this->lang->line('print').'</b>';
                    }?>
                    <b class="red">
                        <?php
                        if($search->sell_option != 'paid'){
                            echo $this->lang->line('FREE');
                        }?>
                    </b>
                </div>
                <div class="sap_10"></div>
                <div class="head_list pr15  fl ">
                    <div class="icon_view3_blog icon_so"><?php echo $search->viewCount>0?$search->viewCount:0;?></div>
                    <div class="icon_crave4_blog icon_so"><?php echo $search->craveCount>0?$search->craveCount:0;?></div>
                    <div class="rating fl pt6"><img src="<?php echo base_url($search->ratingImg);?>"></div>
                    <div class="btn_share_icon icon_so"><?php echo $search->reviewCount>0?$search->reviewCount:0;?></div>
                </div>
            </div>
            <div class="position_relative height171 table_cell pA_img"> <img alt="" src="<?php echo $search->searchImage;?>"></div>
        </div>
    </div>
</a>
