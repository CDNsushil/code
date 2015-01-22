<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<link rel="stylesheet" type="text/css"   href="<?php echo base_url('player/flowplayer/controls-hulu.css'); ?>"/>
<?php 
    // This code for device
    if(getOsName()=="mobile")
    {
?>

    <link type="text/css" href="<?php echo  base_url().'templates/system/css/'; ?>common.css" rel="stylesheet" media="all" />
    <div style="margin-top:0px;">
        <?php
        
            if($media=='0')
            { ?>
                <div class="nomediafound_bg">	
                    <div class="fl font_size18 clr_white font font_museoSlab mt20">
                        No Media Found.
                    </div>
                    <div class="fr mt10 mr30">
                        <img src="<?php echo base_url('images/audio_iconnomedia.png');?>" />
                    </div>
                </div>
            <?php
            }else
            { 
                echo $media;
            }
             ?>	
    </div>

<?php }else{

// This code for desktop
if($media == NULL) 
{   ?>
  
	<div class="nomediafound_bg">	
		<div class="fl font_size18 clr_white font font_museoSlab mt20">
			No Media Found.
		</div>
		<div class="fr mt10 mr30"><img src="<?php echo base_url('images/audio_iconnomedia.png');?>" /></div>
	</div>
	
<?php }
else {     
?>

<script type="text/javascript" src="<?php echo base_url('player/flowplayer/flowplayer-3.2.12.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('player/flowplayer/flowplayer.controls-3.2.11.js'); ?>"></script>

<div id="videoFile" class="myplayer"></div>
<div id="audioPlayer" class="hulu">  </div>

<?php echo $media; } }?>
