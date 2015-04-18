<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$title=$fieldPrefix.'Title';
$description=$fieldPrefix.'Description';
$writer=$fieldPrefix.'Writer';
$publishDate=$fieldPrefix.'PublishDate';
$externalUrl=$fieldPrefix.'ExternalUrl';
$externalUrl=$info[$externalUrl];
$Embed=$fieldPrefix.'Embed';
$Embed=$info[$Embed];
if(isset($info['associatedNewsElementId']) && $info['associatedNewsElementId'] >0){
	//$href=base_url(lang().'/mediafrontend/searchresult/'.$info['tdsUid'].'/'.$info['projId'].'/'.$info['associatedNewsElementId'].'/news');
	$href=base_url(lang().'/mediafrontend/articledetails/'.$info['tdsUid'].'/'.$info['projId'].'/'.$info['associatedNewsElementId']);
	$target='target="_blank"';
}
elseif(!empty($externalUrl)){
	//$externalUrl=urlencode($externalUrl);
	if(strstr($externalUrl,'+')){
		$externalUrl=urldecode($externalUrl); 
	}
	//$href=base_url(lang().'/mediafrontend/externalnews/'.$info['tdsUid'].'/?externalurl='.$externalUrl);
	$href=$externalUrl;
	$target='target="_blank"';
}
elseif(!empty($Embed)){
	if(strstr($Embed,'+')){
		$Embed=urldecode($Embed); 
	}
	$externalUrl=getUrl($Embed);
	//$externalUrl=urlencode($externalUrl);
	//$href=base_url(lang().'/mediafrontend/externalnews/'.$info['tdsUid'].'/?externalurl='.$externalUrl);
	$href=$externalUrl;
	$target='target="_blank"';
}
else{
	$href='#';
	$target='';
}

//if($href !='#') if(substr($href, 0, 4) =='www.'); 'http://'.$href;
?>

 <div class="poup_bx ">
    <div class="row width_451 pt10">
      <div class=" close_btn position_absolute" onclick="$(this).parent().trigger('close');"></div>
      <div class="clearb color_444">
         <a href="<?php echo $href;?>" <?php echo $target;?> <?php if($href !='#'){ ?>onclick="$(this).parent().trigger('close'); return true;" <?php } ?> class="color_444">
            <div class="fl width_114">
               <?php
                 if(!($fieldPrefix=='interv' || $fieldPrefix=='review')){ ?>
                    <div class="blog_profile_img">
                        <div class="AI_table">
                           <div class="AI_cell">
                              <img class="max_w84_h84" src="<?php echo base_url('images/default_thumb/news_s.jpg');?>">
                           </div>
                        </div>
                     </div>
                <?php
                 }
                ?>
               <div class="blog_profile_name"><?php echo $info[$writer];?></div>
               <div class="blog_profile_date"><?php echo get_timestamp('d F Y',$info[$publishDate]);?></div>
            </div>
            <div class="fl width_320 pl15">
               <div class="blog_profile_title bbd3d3d3 pb5 mb5 font_bold"	><?php echo $info[$title];?></div>
               <div class="blog_profile_txt fs12"><?php echo urldecode($info[$description]);?> </div>
            </div>
            <div class="sap_15"></div>
            <div class="popup_blog_status_bar padding_left10 pr10">
               <span class="fl pl126"><?php echo $section;?></span>
            </div>
         </a>
      </div>
    </div>
</div>
