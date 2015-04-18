<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?php echo $search->link;?>" target="_blank" >
    <div class="search_box heightauto">
        <div class="table_cell width_235  text_alighC ">
            <div class="fs28 bdr_ddd radius200 fans_circle m_auto  opens_light display_table "><?php echo $this->lang->line('fan');?></div>
        </div>
        <div class="table_cell text_alighL fr width342  ">
            <div class="clearbox mr10 bbf47a55">
                <div class="sap_20"></div>
                <h4 class="font_bold fl pl30"><?php echo getSubString($search->creative_name,50);?></h4>
                <div class="sap_15"></div>
            </div>
            <div class="  pt12 pb12 pl10 pr10 fl width100_per pr3 box_siz"> 
                <div class="head_list fl">
                    <div class="btn_share_icon icon_so"><?php echo $search->reviewCount>0?$search->reviewCount:0;?></div>
                </div>
                <span class="fr red lineH16 "><?php echo $search->country;?></span>
            </div>
        </div>
    </div>
</a>
