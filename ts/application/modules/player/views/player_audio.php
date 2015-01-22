<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
// This code for device
if(getOsName()=="mobile")
{ ?>

	<div >
		<?php
			if($media=='0')
			{ ?>
				<div class="mainplayerbgwithout Fright mr9 mt87">
					<div class="player_controllerbg f16 fontB pt2 text_alignC">
					No Media Found.
					</div>
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
{?>
	<div class="mainplayerbgwithout Fright mr9 mt87">
		<div class="player_controllerbg f16 fontB pt2 text_alignC">
		No Media Found.
		</div>
	</div>
	
	
<?php }
else { ?>
<div class="mainplayerbg Fright mr9 mt87">
		<div class="player_controllerbg">
		<div id="videoFile" class="myplayer"  style="width:<?php echo $width; ?>; height:<?php echo $height; ?>">
	</div>
	</div>
</div>
<?php echo $media;?>
<?php } } ?>
