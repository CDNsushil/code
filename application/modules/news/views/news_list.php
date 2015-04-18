<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row content_wrap" >
    <div class=" pl45 pr25 bg_f3f3f3 fl title_head ">
        <h1 class="pt10 mb0  fl">News &amp; Public Relations</h1>
    </div>
    <div class="clearbox bgfcfcfc pt17 pb15">
        <ul class="dis_nav fr pr23 news_list clearb fs16 mt27 open_sans ">
            <li><a href="<?php echo base_url(lang().'/pressRelease/index');?>">Press Releases</a></li>
            <li class="active"><a href="javascript:void(0);">In The News </a></li>
            <li><a href="<?php echo base_url(lang().'/news/launch_list');?>">Toadsquare Launch </a></li>
            <li><a href="<?php echo base_url(lang().'/news/information_list');?>">Toadsquare Information</a></li>
        </ul>
    </div>
    <div class="clearb width740 pt45  m_auto">    
        <?php
        $sk=0;
        if($press_list)foreach($press_list as $press_listing){ ?>
            <div class="content mb15">
                <h2 class="fs24 opens_light c8b9c00 bbc8c8c9 pb7 lineH26 mb18"><?php echo date("F Y",strtotime($press_listing['monthName']));?></h2>
                <ul class="news_contentlist">
                    <?php
                    $nextDate="";
                    if(isset($press_listing['get_num_rows']) && $press_listing['get_num_rows'] > 0) {
                        foreach($press_listing['get_result'] as $k=>$press_lists){ ?>
                            <li>
                                <span class="fs13 font_bold width_112  fl">
                                    <?php 
                                    if($nextDate != $press_lists['date']){
                                        echo date("d F Y",strtotime($press_lists['date']));
                                    }else{
                                        echo "&nbsp;";
                                    }
                                    ?>
                                </span>
                                <span class="red fr width570">
                                    <a href="<?php echo base_url(lang().'/news/details/'.$press_lists['id']);?>"><?php echo $press_lists['title'];?></a>
                                </span>
                            </li>
                            <?php
                            $nextDate = $press_lists['date'];
                        }
                    }
                    ?>
                </ul>
            </div>
        <?php 	
        }	?> 
    </div>
</div>
<!--End cmslist of title -->
