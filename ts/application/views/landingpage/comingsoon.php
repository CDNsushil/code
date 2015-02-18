<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="clearbox upcoming  mt20 pb20">
    <div class="m_auto width645 shadow_large  patern_404 ">
        <div class="display_table pl50 pb20">
            <div class="thankyou_img clearbox pl50  ">
                <h5>
                    <span><?php echo $comingsoon['msg'];?></span>
                </h5>
            </div>
            <div class="fl clearbox ml10">
                <div class="fl"><img src="<?php echo $imgPath;?>frog_3.png" alt=""  /></div>
                <?php if(isset($comingsoon['title'])){?>
                    <div class="fl upcoming_btn pl25">
                        <a href="<?php echo $comingsoon['url'];?>" class="green_btn fl lineH50 fs15  height51" onclick="return checkIsUserLogin('You must be logged in to Create your Film & Video Showcase');"><?php echo $comingsoon['title'];?></a>
                    </div>
                    <?php
                }?>
            </div>
        </div>
    </div>
</div>
