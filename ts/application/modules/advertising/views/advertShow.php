<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>
<?php 

/*
echo "<pre>";
print_r($bannerData->url);die();  
*/
if($bannerData->url!="" && $bannerData->url>0){
	$redirectUrl = base_url('advertising/clickadvert/'.$bannerData->bannerid);
}else{
	$redirectUrl = "javascript:void(0)";
}?>

<style>
body{
	margin:0px;
	padding:0px;
}
</style>

<a target="_blank" href="<?php echo $redirectUrl;  ?>">
<?php 
	if($bannerData->storagetype=="web")
		{ 
			$extension = strtolower($bannerData->contenttype);
			if($extension=="jpg" || $extension=="jpeg" || $extension=="gif" || $extension=="png")
			{
		?>
			<img src="<?php echo base_url('openx/www/images').'/'.$bannerData->filename ?>"  width="<?php echo $bannerData->width; ?>" height="<?php echo $bannerData->height; ?>"/>
		<?php 
		
			}else{
				
				// swf file show code section
				if($extension=="swf"){ ?>
					
					<object width="<?php echo $bannerData->width; ?>" height="<?php echo $bannerData->height; ?>" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
					codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">
					<param name="SRC" value="<?php echo base_url('openx/www/images').'/'.$bannerData->filename ?>">
					<embed src="<?php echo base_url('openx/www/images').'/'.$bannerData->filename ?>" width="<?php echo $bannerData->width; ?>" height="<?php echo $bannerData->height; ?>"></embed>
					</object>
				<?php	}
				
				// mov file show code section
				if($extension=="mov"){ ?>
					<object class="toadVideo" width="<?php echo $bannerData->width; ?>" height="<?php echo $bannerData->height; ?>" id="launchVideo_api" name="launchVideo_api" type="application/x-shockwave-flash" data="<?php echo base_url(); ?>/player/flowplayer/flowplayer.commercial-3.2.16.swf"><param name="allowfullscreen" value="true">
						<param name="allowscriptaccess" value="always">
						<param name="wmode" value="transparent">
						<param name="quality" value="high">
						<param name="bgcolor" value="#000000">
						<param name="flashvars" value="config={&quot;key&quot;:&quot;#$943a9847a4c436aa438&quot;,&quot;plugins&quot;:{&quot;controls&quot;:{&quot;autoHide&quot;:&quot;never&quot;}},&quot;playlist&quot;:[{&quot;url&quot;:&quot;<?php echo base_url(); ?>images/launch_img.png&quot;,&quot;scaling&quot;:&quot;orig&quot;},{&quot;autoPlay&quot;:false,&quot;autoBuffering&quot;:true,&quot;url&quot;:&quot;<?php echo base_url('openx/www/images').'/'.$bannerData->filename ?>&quot;}],&quot;playerId&quot;:&quot;launchVideo&quot;,&quot;clip&quot;:{}}"> 
					</object>
				<?php 
				}
				
				// rm file show code section
				if($extension=="rm"){ ?>
				
				rm file show
				
				<?php 
				}
			
			}
		}else{
		echo $showCode; 
	}
?>
</a>
