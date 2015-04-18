<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box">
        <div class="clearb pt13 ml15 mr15 bb_F1592A ">
            <span class="fl search_title width_333 font_bold"><?php echo getSubString($search->title,100);?></span>
            <b class="fr red search_cat lettsp1"><?php echo $this->lang->line('filmNvideo');?></b>
            <div class="sap_10"></div>
        </div>
        <div class="bgf4f4f4 pt8 pb5 display_table  lettsp-1 width100_per">
            <b class="fl pl15 red "><?php echo getSubString($search->creative_name,50);?></b>
            <span class="fr fs13 pr15">
                <?php 
                if(isset($search->videoFileCount) && is_numeric($search->videoFileCount) && ($search->videoFileCount > 0)){
                     $ft = ($search->videoFileCount > 1) ? $this->lang->line('videoFiles'): $this->lang->line('videoFile');
                     echo '<b class="pr7">'.$search->videoFileCount.' '.$ft.'</b>';
                }
                if($search->sell_option == 'paid'){
                    if(isset($search->dvdCount) && is_numeric($search->dvdCount) && ($search->dvdCount > 0)){
                        $ft = ($search->dvdCount > 1) ? $this->lang->line('DVDs'): $this->lang->line('DVD');
                        echo '<b>'.$search->dvdCount.' '.$ft.'</b>';
                    }
                }else{
                    echo '<b class="red">'.$this->lang->line('FREE').'</b>';
                }
                ?>
            </span>
        </div>
        <div class="fl search_title_img clearb display_table">
            <span class="table_cell">
                <img alt="" src="<?php echo $search->searchImage;?>">
            </span>
            <span class=" title_creav font_bold"><?php echo $this->lang->line('FvCollection');?></span>
        </div>
        <div class=" text_alighL fr cnt_crev ">
            <p class="fs13  clearb pl10 pb7">
                <?php  if(isset($search->online_desctiption)) echo limit_words($search->online_desctiption,'50'); else echo ' ';?>
            </p>
            <div class="btd2d2d2 pt15 pl20">
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
