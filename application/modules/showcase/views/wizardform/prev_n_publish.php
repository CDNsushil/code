<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set cancel url

$loginUserId= isLoginUser();
$baseUrl      =  base_url(lang().'/showcase/');
$previewLink  =  base_url(lang().'/showcase/index/'.$loginUserId.'/preview');
$isPublished  = (isset($showcaseRes->isPublished)) ? $showcaseRes->isPublished : '';
$showcaseId  = (isset($showcaseRes->showcaseId)) ? $showcaseRes->showcaseId : '';

// set publish btn text
$publishBtnTxt = ($isPublished == 't') ? $this->lang->line('hideHomepage') : $this->lang->line('publishHomepage'); 
?> 
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <div class="c_1">
        <h3 class=" fs21 red  fnt_mouse bb_aeaeae"><?php echo $this->lang->line('prevNPubHead');?></h3>
        <h4 class="fl lineH24 whitespace_now"><?php echo $this->lang->line('prevNPubHeadNote');?></h4>
        <div class="sap_30"></div>
        <div class="clearb finsh_button fl fs16 "> 
            <a target="_blank" href="<?php echo $previewLink;?>" class="ml40 mr15 ">  
                <button class="red bdr_a0a0a0  " type="button" ><?php echo $this->lang->line('previewHomepage');?></button>
            </a>
            <a href="<?php echo $baseUrl.'/managepublishstatus/'.$showcaseId;?>" class="ml15">
                <button class="red bdr_a0a0a0  " type="button"><?php echo $publishBtnTxt;?></button>
            </a>
        </div>

        <div class="sap_25"></div> 

        <ul class="clearb pt15 ">
            <li class="icon_2"> Once your Homepage is published, select <a href="<?php echo $baseUrl.'/editshowcase';?>">Edit your Homepage</a> from <br />
            <b>Your Toadsquare</b> > <b>Your Showcases Homepage</b> to edit it.  
        </ul>

        <div class=" fs14 fr display_block btn_wrap mt20 mb20 font_weight">
            <!--<button type="button" class="back bdr_b5b5b5"  onclick="change()">Pause</button>-->
            <a href="<?php echo $baseUrl.'/socialmedialinks';?>">
                <button type="button" class=" bg_ededed bdr_b5b5b5 fr">Back</button>
            </a>
        </div>
    </div>
</div>

