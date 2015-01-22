<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<style>
	body{
		 margin:0px;
		 padding:0px;
		}
	.myplayer{
		height: 27px;
		top: 17px;
		left: 2px;
		position: absolute;
		width: 270px;
	}
	.show_main{
		background: url(<?php echo  base_url().'templates/frontend/images/'; ?>mainplayer_bg.png) no-repeat;
		height:63px;
		width:281px;
		position:relative;
	}
	
	.show_main_with_divider{
		background: url(<?php echo  base_url().'templates/frontend/images/'; ?>mainplayer_bg_without_divider.png) no-repeat;
		height:63px;
		width:281px;
		position:relative;
	}
	
	.nomediafound_bg{ background:#444444; border-radius:4px 4px 4px 4px; height:60px; padding-left:40px;}
	
	
	.show_loader_div
	{
		position: relative;
		margin: 0px;
		padding-top: 44px;
		padding-left: 118px;
	}	
	
	</style>
	<script>
	 $(document).ready(function() {	
		
	 $("#loader_div_hide").show().fadeOut(3000);
	 
	});
	</script>
		<link type="text/css" href="<?php echo  base_url().'templates/system/css/'; ?>common.css" rel="stylesheet" media="all" />
<?php 
// This code for device
if(getOsName()=="mobile")
{ ?>
	<div >
		<?php
			if($media=='0')
			{ ?>
				<div class="nomediafound_bg">	
					<div class="fl font_size18 clr_white font font_museoSlab mt20">
						No Media Found.
					</div>
					<div class="fr mt10 mr30"><img src="<?php echo base_url('images/audio_iconnomedia.png');?>" /></div>
				</div>
			<?php
				}else
				{
					echo $media;
				}
			?>
	</div>	
<?php 
}else
{

if($media == NULL)
{ ?>
	<div class="nomediafound_bg">	
		<div class="fl font_size18 clr_white font font_museoSlab mt20">
			No Media Found.
		</div>
		<div class="fr mt10 mr30"><img src="<?php echo base_url('images/audio_iconnomedia.png');?>" /></div>
	</div>

<?php  
}
else { 
	
echo '<script type="text/javascript" src="'. base_url('templates/system/javascript/jquery-lib/jquery.js').'"></script>
<script type="text/javascript" src="'. base_url('player/flowplayer/flowplayer-3.2.12.js').'"></script>';	
	?>
	
	<script>
	 $(document).ready(function() {	
		
	 $("#loader_div_hide").show().fadeOut(3000);
	 
	});
	</script>
	<div class="show_main">	
		<div id="loader_div_hide" class="show_loader_div"><img src="<?php echo  base_url().'images/'; ?>loading_wbg.gif"></div>
		<div id="videoFile" class="myplayer"></div>
	 </div>
<?php echo $media;?>
<?php }  } ?>
