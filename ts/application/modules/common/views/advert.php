<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Set click url for advert
if(!empty($bannerData->url)){
	$redirectUrl = $bannerData->url;
	$onClick     = 'onclick = manageAdvertclick('.$bannerData->campaignid.','.$bannerData->bannerid.');';
}else{
	$redirectUrl = 'javascript:void(0)';
	$onClick     = '';
}?>

<a target="_blank" href="<?php echo $redirectUrl;?>" <?php echo $onClick;?>>
<?php if($advertType==3) {
	//echo '<div class="cell ad_box width468px">';
} else if($advertType==5){
		echo '<div class="width778px ml10">
				<div  class="width728px ma" >
					<div class="ad_box mt20 mb10 width728px">';
} ?>
	<!-- Div start of advert here -->
	<div class="AI_table">
		<div class="AI_cell">
			<?php 
			//echo $bannerData->bannerid;
			if($bannerData->storagetype=="web")
			{ 
				$extension = strtolower($bannerData->contenttype);
				if($extension=="jpg" || $extension=="jpeg" || $extension=="gif" || $extension=="png")
				{
					$filePath = ROOTPATH.'openx/www/images/'.$bannerData->filename; //Set root path of file
					if(file_exists($filePath)) {
					?>
						<img src="<?php echo base_url('openx/www/images').'/'.$bannerData->filename ?>"  width="<?php echo $bannerData->width; ?>" height="<?php echo $bannerData->height; ?>"/>
					<?php 
					} else {
						//Load default ad if advert not exists
						if($advertType==2) {
							$this->load->view('common/adv_rhs');
						} else if($advertType==3) {
							$this->load->view('common/adv_content_bot');
						} else if($advertType==4) {
							$this->load->view('common/adv_lhs_bot');
						} else if($advertType==5) {
							$this->load->view('common/adv_728_90');
						}
						 else{
							$this->load->view('common/adv_rhs_forum');
						}
					}
				}else{
					// swf file show code section
					if($extension=="swf"){ ?>
					
						<object width="<?php echo $bannerData->width; ?>" height="<?php echo $bannerData->height; ?>" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
						codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">
						<param name="SRC" value="<?php echo base_url('openx/www/images').'/'.$bannerData->filename ?>">
						<embed src="<?php echo base_url('openx/www/images').'/'.$bannerData->filename ?>" width="<?php echo $bannerData->width; ?>" height="<?php echo $bannerData->height; ?>"></embed>
						</object>
					<?php }
				
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
				//Set html content of advert
				$htmltemplate = $bannerData->htmltemplate;
				$serverPath   = base_url();
				$searchArray  = array("{server_path}","{img_show_0}");
				$replaceArray = array($serverPath,);
				$showCode     =str_replace($searchArray, $replaceArray, $htmltemplate);
				echo $showCode; 
			}
			?>
		</div>
	</div>
	<!-- Div end of advert here -->
	<?php if($advertType==3) {
		//echo '</div">';
	}  else if($advertType==5){
		echo '</div></div></div>';
	} ?>
</a>

<script>
function manageAdvertclick(campaignid,bannerid){
	var BASEPATH = "<?php echo base_url(lang());?>";
	var form_data = {campaignid:campaignid,bannerid:bannerid};
	$.ajax
	({
		type: "POST",
		url: BASEPATH+"/advertising/clickadvert",
		data: form_data,
		success: function(data)
		{		
			return true;
		}
	});
	return false;	
}
</script>
