<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box music_audio">
        <div class="clearb table_cell  img_search">
            <img alt="" src="<?php echo $search->searchImage;?>">
            <span class=" title_creav font_bold">
                <?php
                    echo (isset($search->category) && !empty($search->category))?$search->category:'';
                ?>
            </span>
            <span class="white_title title_creav font_bold "><?php echo getSubString($search->creative_name,50);?></span>
        </div>
        <div class=" text_alighL fl cnt_crev ">
            <div class="clearb pt5 headtitle">
                <span class="pl15">
                    <?php
                    $isExistFreeFile = false;
                    if(isset($search->audioFileCount) && is_numeric($search->audioFileCount) && ($search->audioFileCount > 0)){
                         $isExistFreeFile = true;
                         $ft = ($search->audioFileCount > 1) ? $this->lang->line('musicFiles'): $this->lang->line('musicFile');
                         echo '<b class="pr7">'.$search->audioFileCount.' '.$ft.'</b>';
                    }
                    if($search->sell_option == 'paid'){
                        if(isset($search->cdCount) && is_numeric($search->cdCount) && ($search->cdCount > 0)){
                            if($isExistFreeFile){
                             echo "<br>";   
                            }
                            $ft = ($search->cdCount > 1) ? $this->lang->line('CDs'): $this->lang->line('CD');
                            echo '<b>'.$search->cdCount.' '.$ft.'</b>';
                        }
                    }else{
                        echo '<b class="red">'.$this->lang->line('FREE').'</b>';
                    }?>
                </span>
            <b class="fr red search_cat lettsp1"><?php echo $this->lang->line('musicNaudio');?></b>
            <div class="sap_10"></div>
            </div>
            <div class="gray_box box_siz clearb"> <b class="fl pl15 "><?php echo getSubString($search->title,100);?></b> </div>
            <div class="sap_30"></div>
            <div class=" text_alighL fr pt10 pb12 pr15 width305 ">
                <p class="fs13  clearb ">
                    <?php if(isset($search->online_desctiption)) echo limit_words($search->online_desctiption,'50'); else echo ' ';?>
                </p>
            </div>
            <div class="btd2d2d2 clearb pt15 pl20">
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
