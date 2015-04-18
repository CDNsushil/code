<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box heightauto">
        <div class="table_cell  text_alighC  profesinal_w">
            <div class="blur_profile bulr_box"><img src="<?php echo $search->searchImage;?>"> </div>
            <span class="img_box  position_relative zindex_999"><img src="<?php echo $search->searchImage;?>"></span>
        </div>

        <div class="table_cell text_alighL fr width342  ">
            <div class="clearbox mr10 bbf47a55">
                <div class="sap_20"></div>
                <h4 class="font_bold fl pl30"><?php echo getSubString($search->creative_name,50);?></h4>
                <div class="sap_15"></div>
            </div>

            <div class="bgf4f4f4 pt8 pb8 pr10 red text_alignR display_table width100_per box_siz">
                <?php echo !empty($search->industry)?$search->industry:'&nbsp;';?>
            </div>
            <div class="min_H86 pr10 pt5 pl10 fs13">
                <?php if(isset($search->online_desctiption)) echo limit_words($search->online_desctiption,'50'); else echo ' ';?>
            </div>
            <div class=" font_bold pt12 pb12 pl10 pr10  BT_dadada pr3"> 
                <span class="opens_light fs23 lineH16 green"><?php echo $this->lang->line('professional');?></span>
                <div class="head_list fr">
                    <div class="icon_view3_blog icon_so"><?php echo $search->viewCount>0?$search->viewCount:0;?></div>
                    <div class="icon_crave4_blog icon_so"><?php echo $search->craveCount>0?$search->craveCount:0;?></div>
                    <div class="rating fl pt6"><img src="<?php echo base_url($search->ratingImg);?>"></div>
                    <div class="btn_share_icon icon_so"><?php echo $search->reviewCount>0?$search->reviewCount:0;?></div>
                </div>
            </div>
        </div>
    </div>
</a>
