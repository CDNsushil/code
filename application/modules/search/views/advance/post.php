<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box">
        <div class="fl search_post clearb display_table">
            <span class="table_cell ">
                <span class=" box_siz opens_light fs26 post_title"><?php echo $this->lang->line('post');?></span>
                <img alt="" src="<?php echo $search->searchImage;?>">
                <p class="font_bold red pt7 "><?php echo $search->creative_name;?></p>
            </span>
        </div>
        <div class=" text_alighL fr cnt_crev ">
            <div class="pl10 fl font_bold pt5 pb10 width100_per bb_F1592A mb10"> <?php echo getSubString($search->title,50);?></div>
            <b class="fl pb10 pl10 fs13 ">
                <?php if(!empty($search->industry)){ echo "About the ".$search->industry;}else{echo '&nbsp;';} ?>
            </b>
            <div class="min_H110 clearbox pt3">
                <p class="fs13  clearb pl10 pb10"><?php if(isset($search->online_desctiption)) echo limit_words($search->online_desctiption,'50'); else echo ' ';?></p>
            </div>
            <div class="btd2d2d2 pl10 pt3">
                <div class="date pt12 fs13 fl"><?php echo date('d F',strtotime($search->publish_date));?>, <span class="red"> <?php echo date('Y',strtotime($search->publish_date));?> </span></div>
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
