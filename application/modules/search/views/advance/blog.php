<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box">
        <div class="fl search_blog clearb display_table">
            <span class="table_cell "><img alt="" src="<?php echo $search->searchImage;?>"></span>
            <span class=" box_siz opens_light fs26 blog_title"><?php echo $this->lang->line('blog');?></span>
        </div>
        <div class=" text_alighL fr   cnt_crev ">
            <div class="pl10 fl font_bold pt5 width100_per pb8 bb_F1592A mb10"><?php echo getSubString($search->title,50);?></div>
            <b class="fr pb7 red "><?php echo $search->creative_name;?></b>
            <div class="min_H110 clearbox pt3">
                <p class="fs13  clearb pl10 pb10"><?php if(isset($search->online_desctiption)) echo limit_words($search->online_desctiption,'50'); else echo ' ';?></p>
            </div>
                <div class="btd2d2d2 pl10 pt3">
                    <div class="head_list pr5 pt12  fr ">
                    <div class="icon_view3_blog icon_so"><?php echo $search->viewCount>0?$search->viewCount:0;?></div>
                    <div class="icon_crave4_blog icon_so"><?php echo $search->craveCount>0?$search->craveCount:0;?></div>
                    <div class="rating fl pt6"><img src="<?php echo base_url($search->ratingImg);?>"></div>
                    <div class="btn_share_icon icon_so"><?php echo $search->reviewCount>0?$search->reviewCount:0;?></div>
                </div>
            </div>
        </div>
    </div>
</a>
