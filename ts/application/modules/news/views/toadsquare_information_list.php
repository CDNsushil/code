<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    $currentShortUrl = uri_string();
    $logo1path = encode('images+td_LogoonGray.png');
    $logo2path = encode('images+td_LogoonWhite.png');
?>
<div class="row content_wrap" >
    <div class=" pl45 pr25 bg_f1f1f1 fl title_head ">
        <h1 class="pt10 mb0  fl">News &amp; Public Relations</h1>
    </div>
    <div class="clearbox bgfcfcfc pt17 pb15">
        <ul class="dis_nav fr pr23 news_list clearb fs16 mt27 open_sans ">
            <li><a href="<?php echo base_url(lang().'/pressRelease/index');?>">Press Releases</a>  </li>
            <li><a href="<?php echo base_url(lang().'/news/index');?>">In The News </a></li>
            <li><a href="<?php echo base_url(lang().'/news/launch_list');?>">Toadsquare Launch </a></li>
            <li class="active"><a href="javascript:void(0);">Toadsquare Information</a></li>
         </ul>
     </div>
    <div class="clearb width740 pt45 m_auto">
        <div class="content mb15">
            <h2 class="opens_light fs24">Logo</h2>
            <div class="logo_wrap width650 mt46 pl45 pr40"><a href="#" class="fl"><img src="<?php echo base_url('images/td_LogoonGray.png');?>" alt="" /></a> <span class="fr pr12"><button class="common_button" onclick="return window.location = '<?php echo base_url(lang().'/common/downloadFileFrmOrigPath/'.$logo1path);?>'">Download</button></span></div>
            <div class="logo_dark bg4d4c52 width650 mt15 "><a href="#" class="fl"><img src="<?php echo base_url('images/td_LogoonWhite.png');?>" alt="" /></a> <span class="fr pr12"><button class="common_button" onclick="return window.location = '<?php echo base_url(lang().'/common/downloadFileFrmOrigPath/'.$logo2path);?>'">Download</button></span></div>
        </div>
        <div class="sap_50"></div>
    </div>
</div>
            
