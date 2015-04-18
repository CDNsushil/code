<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box pa_box">
        <div class="clearb pt12 ml15 mr15 bb_F1592A ">
            <span class="fl search_title width_333 font_bold"><?php echo getSubString($search->title,100);?></span>
            <b class="fr red search_cat lettsp1"><?php echo $this->lang->line('photographyNart');?></b>
            <div class="sap_10"></div>
        </div>
        <div class="clearb pl15 mt7 mb10 pr15 display_table">
            <div class=" text_alighL fl  content_box pr27  table_cell">
                <b class="fl red pb6"><?php echo getSubString($search->creative_name,50);?></b>
                <p class="fs13 lineH15 clearb pb7"><?php if(isset($search->online_desctiption)) echo limit_words($search->online_desctiption,'50'); else echo ' ';?></p>
            </div>
            <div class=" clearb table_cell ">
                <span class="table_cell pA_img"><img alt="" src="<?php echo $search->searchImage;?>"></span>
            </div>
        </div>
        <div class="bgf4f4f4 pt8 pb5 display_table position_relative pA_slide  lettsp-1 width100_per">
            <span class=" title_creav font_bold">
                <?php
                    echo (isset($search->category) && !empty($search->category))?$search->category:'';
                ?>
            </span>
            <div class="head_list pr5  fr ">
                <div class="icon_view3_blog icon_so"><?php echo $search->viewCount>0?$search->viewCount:0;?></div>
                <div class="icon_crave4_blog icon_so"><?php echo $search->craveCount>0?$search->craveCount:0;?></div>
                <div class="rating fl pt6"><img src="<?php echo base_url($search->ratingImg);?>"></div>
                <div class="btn_share_icon icon_so"><?php echo $search->reviewCount>0?$search->reviewCount:0;?></div>
            </div>
            <span class="fr fs14 pr20">
                <?php
                if(isset($search->imageFileCount) && is_numeric($search->imageFileCount) && ($search->imageFileCount > 0)){
                     $isExistFreeFile = true;
                     $ft = ($search->imageFileCount > 1) ? $this->lang->line('imageFiles'): $this->lang->line('imageFile');
                     echo '<b class="pr7"><span class="red">'.$search->imageFileCount.'</span> '.$ft.'</b>';
                }
                if($search->sell_option == 'paid'){
                    if(isset($search->printCount) && is_numeric($search->printCount) && ($search->printCount > 0)){
                        $ft = ($search->printCount > 1) ? $this->lang->line('prints'): $this->lang->line('print');
                        echo '<b><span class="red">'.$search->printCount.'</span> '.$ft.'</b>';
                    }
                }else{
                    echo '<b class="red">'.$this->lang->line('FREE').'</b>';
                }?>
            </span> 
        </div>
    </div>
</a>
