<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box">
        <div class="clearb pt13 ml15 mr15 bb_F1592A ">
            <span class="fl search_title width_333 font_bold"><?php echo getSubString($search->title,100);?></span>
            <b class="fr red search_cat lettsp1"><?php echo $this->lang->line('writingNpublishing');?></b>
            <div class="sap_10"></div>
        </div>
        <div class="bgf4f4f4 pt8 position_relative pb5 display_table  lettsp-1 width100_per">
            <div class="fl img_writing clearb display_table">
                <span class="table_cell">
                    <img alt="" src="<?php echo $search->searchImage;?>">
                </span>
                <span class=" title_creav font_bold"><?php echo $this->lang->line('WpCollection');?></span>
            </div>
            <div class="width_380 pr15 fr">
                <b class="fl red "><?php echo getSubString($search->creative_name,50);?></b>
            </div>
        </div>

        <div class=" text_alighL fr pt10 pb15 pr15 width_380 ">
            <p class="fs13  clearb">
                <?php  if(isset($search->online_desctiption)) echo limit_words($search->online_desctiption,'50'); else echo ' ';?>
            </p>
        </div>
        
        <div class="btd2d2d2 clearbox pt10 pb10 pl20 pr15 box_siz ">
            <div class="width_380 fr">
                <span class="fl fs14 pr20">
                    <?php 
                    if(isset($search->docFileCount) && is_numeric($search->docFileCount) && ($search->docFileCount > 0)){
                         $ft = ($search->docFileCount > 1) ? $this->lang->line('textFiles'): $this->lang->line('textFile');
                         echo '<b class="pr7"><span class="red">'.$search->docFileCount.'</span> '.$ft.'</b>';
                    }
                    if($search->sell_option == 'paid'){
                        if(isset($search->docCount) && is_numeric($search->docCount) && ($search->docCount > 0)){
                            $ft = ($search->docCount > 1) ? $this->lang->line('texts'): $this->lang->line('text');
                            echo '<b><span class="red">'.$search->docCount.'</span> '.$ft.'</b>';
                        }
                    }else{
                        echo '<b class="red">'.$this->lang->line('FREE').'</b>';
                    }
                    ?>
                </span>                                
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
