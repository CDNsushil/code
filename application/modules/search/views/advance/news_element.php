<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box">
        <div class="clearb pt13 ml15 mr15 bb_F1592A ">
             <?php
            if(!empty($search->industry)){ ?>
                <span class="red search_cat text_alignR width100_per lettsp1"><b><?php echo $search->industry;?></b></span>
                <?php
            } ?>
            <span class="fl  font_bold"><?php echo getSubString($search->title,50);?></span> 
            <div class="sap_10"></div>
        </div>
        <div class="bgf4f4f4 pt8 pb5 display_table  lettsp-1 width100_per"><b class="fr pr20 red"><?php echo $search->creative_name;?></b></div>
        <div class=" text_alighL fl cnt_crev ">
            <div class="min_H86 pt3">
                <p class="fs13  clearb pl10 pb10"><?php if(isset($search->online_desctiption)) echo limit_words($search->online_desctiption,'50'); else echo ' ';?></p>
            </div>
            <div class=" pt15  pl12">
                <div class="fl font_bold"><?php echo $this->lang->line('newsArticle');?></div>
                <div class="head_list pr5   fr ">
                    <div class="icon_view3_blog icon_so"><?php echo $search->viewCount>0?$search->viewCount:0;?></div>
                    <div class="icon_crave4_blog icon_so"><?php echo $search->craveCount>0?$search->craveCount:0;?></div>
                    <div class="rating fl pt6"><img src="<?php echo base_url($search->ratingImg);?>"></div>
                    <div class="btn_share_icon icon_so"><?php echo $search->reviewCount>0?$search->reviewCount:0;?></div>
                </div>
            </div>
        </div>
        <div class="fl search_title_img  bdr_non display_table"><span class="table_cell"> 
            <img alt="" src="<?php echo $search->searchImage;?>"></span>
        </div>
    </div>
</a>
