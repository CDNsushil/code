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
	$href=base_url(lang().'/mediafrontend/searchresult/'.$info['tdsUid'].'/'.$info['projId'].'/'.$info['associatedNewsElementId'].'/news');
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
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<a href="<?php echo $href;?>" <?php echo $target;?> <?php if($href !='#'){?>onclick="$(this).parent().trigger('close'); return true;" <?php }?> >	
	<div class="popup_gredient ">
	  <div class="row pt15 pb15 pr10 pl10 width_451">
		<div class="cell width_114">
		  <?php
			 if(!($fieldPrefix=='interv' || $fieldPrefix=='review')){ ?>
					<div class="blog_profile_img">
						<div class="AI_table">
						  <div class="AI_cell"><img class="max_w84_h84" src="<?php echo base_url('images/default_thumb/news_s.jpg');?>" class="review_thumb"></div>
						</div>
					 </div> 
			<?php
			 }
		   ?>
		  <div class="blog_profile_name"><?php echo $info[$writer];?></div>
		  <div class="blog_profile_date"><?php echo get_timestamp('d F Y',$info[$publishDate]);?></div>
		</div>
		<div class="cell width_320 padding_left16">
		  <div class="blog_profile_title dash_link_hover"><?php echo $info[$title];?></div>
		  <div class="blog_profile_txt"><?php echo urldecode($info[$description]);?></div>
		</div>
		<div class="clear seprator_13"></div>
		
			<div class="popup_blog_status_bar padding_left10 padding_right10">
				<span class="width_118 cell">&nbsp;</span><span class="cell"><?php echo $section;?></span>
			</div>
	  </div>
	</div>
</a>
