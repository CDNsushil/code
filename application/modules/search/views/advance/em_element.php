<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box">
        <div class="clearb pt13 ml15 mr15 bb_F1592A ">
            <span class="red search_cat text_alignR width100_per lettsp1"><b><?php echo $this->lang->line('educationMaterial');?></b>  </span>
            <span class="fl  font_bold"><?php echo getSubString($search->title,100);?></span> 
            <p class="fr"><?php echo $search->language;?></p>
            <div class="sap_10"></div>
        </div>
        <div class="bgf4f4f4 pt8 pb5 display_table  lettsp-1 width100_per"><b class="fl pl15 red "><?php echo getSubString($search->creative_name,50);?></b></div>
        
        <div class="fl search_title_img clearb display_table">
            <span class="table_cell"> 
                <img alt="" src="<?php echo $search->searchImage;?>">
            </span>
        </div>
        <div class=" text_alighL fr cnt_crev ">
            <div class="min_H86 pt3 pl20">
                <b class="red fl clearbox pt10">
                    <?php
                        echo (isset($search->type) && !empty($search->type))?$search->type:' ';
                    ?>
                </b>
                <div class="open_sans fs20 pt10 fl green">
                    <?php
                        echo (isset($search->genre) && !empty($search->genre))?$search->genre:' ';
                    ?>
                </div>             
            </div>
            <div class=" pl20 pt15 ">
                <div class="fl">
                <?php
                $ftString='';
                if($search->videoFileCount > 0){
                    $ftString=$this->lang->line('videoFile');
                }elseif($search->dvdCount > 0){
                    $ftString=$this->lang->line('DVD');
                }elseif($search->audioFileCount > 0){
                    $ftString=$this->lang->line('musicFiles');
                }elseif($search->cdCount > 0){
                    $ftString=$this->lang->line('CD');
                }elseif($search->docFileCount > 0){
                    $ftString=$this->lang->line('textFile');
                }elseif($search->docCount > 0){
                    $ftString=$this->lang->line('text');
                }elseif($search->imageFileCount > 0){
                    $ftString=$this->lang->line('imageFile');
                }elseif($search->printCount > 0){
                    $ftString=$this->lang->line('print');
                }
                $FREE = ($search->sell_option=='free')?$this->lang->line('FREE'):'';
                $estring='<b class="pr7">'.$ftString.'</b><b class="red">'.$FREE.'</b>';
                echo $estring;
                ?>
                </div>
                <div class="head_list pr5   fr ">
                    <div class="icon_view3_blog icon_so"><?php echo $search->viewCount>0?$search->viewCount:0;?></div>
                    <div class="icon_crave4_blog icon_so"><?php echo $search->craveCount>0?$search->craveCount:0;?></div>
                    <div class="rating fl pt6"><img src="<?php echo base_url($search->ratingImg);?>"></div>
                    <div class="btn_share_icon icon_so"><?php echo $search->reviewCount>0?$search->reviewCount:0;?></div>
                </div>
            </div>
        </div>
    </div>
</a>
