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
		background: url(<?php echo  base_url().'templates/frontend/images/'; ?>player_staticimg.png) no-repeat;
		height:63px;
		width:281px;
		position:relative;
		 margin-top: 66px;
		}
		
	.nomediafound_bg{ background:#444444; border-radius:4px 4px 4px 4px; height:60px; padding-left:40px;}	
		
	</style>
	
	<link type="text/css" href="<?php echo  base_url().'templates/system/css/'; ?>common.css" rel="stylesheet" media="all" />
	
<div class="nomediafound_bg">	
		<div class="fl font_size18 clr_white font font_museoSlab mt20">
			No Media Found.
		</div>
		
		
		
		<div class="fr mt10 mr30"><img src="<?php echo base_url('images/audio_iconnomedia.png');?>" /></div>
</div>
