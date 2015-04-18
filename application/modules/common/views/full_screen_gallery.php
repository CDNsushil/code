<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
 
	<div id="slider-toolkit" class="dn">
		
		<div class="royalSlider rsDefault">			
			<?php foreach($fullscreenArray as $img_count => $img) {
				
				  if(isset($img['xs']) && ($img['xs']!='')){ ?>
			<a class="rsImg"  data-rsw="632" data-rsh="500" data-rsBigImg="<?php echo $img['org'];?>" href="<?php echo $img['xs'];?>">
				<img id="<?php echo $img_count;?>" data-rsBigImg="<?php echo $img['org'];?>" src="<?php echo $img['xs'];?>"/>
			</a>	
			<!--a class="rsImg"  data-rsw="632" data-rsh="500"   data-rsTmb="<?php echo $img['xs'];?>"  data-rsBigImg="<?php echo $img['l'];?>" href="<?php echo $img['xs'];?>">
				<img data-rsTmb="<?php echo $img['xs'];?>"  id="<?php echo $img_count;?>" data-rsBigImg="<?php echo $img['l'];?>" src="<?php echo $img['xs'];?>"/>
			</a-->	
			<?php }  } ?>   
		</div>
		
	</div><!-- End Div slider-toolkit -->
	
	
<script>

$('.royalSlider').royalSlider({   
	fullscreen: {
		enabled: true,
		nativeFS: true
	},
	//*controlNavigation: 'thumbnails',*/
	autoScaleSlider: true,	
	loop: false,
	usePreloader: true,	
	navigateByClick: true,	
	arrowsNav:true,
	arrowsNavAutoHide: true,
	arrowsNavHideOnTouch: true,
	//imageScaleMode: 'none',
	keyboardNavEnabled: true	
});
</script>
