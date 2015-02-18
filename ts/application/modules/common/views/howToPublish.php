<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$howToPublish="openLightBox('popupBoxWp','popup_box','/common/howToPublish','".$industryType."')";

if(!isset($class)){
	$class = 'ml20 mt10';
}

if($industryType=='filmNvideo' || $industryType=='musicNaudio' || $industryType=='writingNpublishing' || $industryType=='educationMaterial' || $industryType=='performanceNevent' || $industryType=='photographyNart'){
	$buttonLabel = 'How to Publish & Sell';
	$spanClass = 'width_100';
	$btnClass = 'how_publishPopuptbtn';
}
else{
	$buttonLabel = 'How to Publish';
	$spanClass = 'width_60';
	$btnClass = 'how_publistbtn';
}
	?>
		<div class="<?PHP echo $class;?>">
		<a href="javascript:void(0)"  onclick="<?php echo $howToPublish;?>">
			<div class="<?php echo $btnClass;?>">
				<span class="fr <?php echo $spanClass;?> font_museoSlab font_size15 clr_f1592a mt6 mr18"><?php echo $buttonLabel;?></span>
			</div>
		</a>
	</div>
	

<!--<div class="cell mt35 ml20">
	<div class="howtopublish_btn ptr" onclick="<?php //echo $howToPublish?>">
		<div class="fl font_opensansSBold font_size12 lh50 pl60 orange">
			How to Publish</div>
	</div>
</div>-->
