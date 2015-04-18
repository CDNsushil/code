<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
 
	<div id="s1" class="dn">
		
		<div class="royalSlider rsDefault" id="rs1">			
			<?php foreach($fullscreenArray as $img_count => $img) { ?>
			<a class="rsImg"  data-rsw="632" data-rsh="500" data-rsBigImg="<?php echo $img['l'];?>" href="<?php echo $img['xs'];?>">
				<img id="<?php echo $img_count;?>" data-rsBigImg="<?php echo $img['l'];?>" src="<?php echo $img['xs'];?>"/>
			</a>	
			<!--a class="rsImg"  data-rsw="632" data-rsh="500"   data-rsTmb="<?php echo $img['xs'];?>"  data-rsBigImg="<?php echo $img['l'];?>" href="<?php echo $img['xs'];?>">
				<img data-rsTmb="<?php echo $img['xs'];?>"  id="<?php echo $img_count;?>" data-rsBigImg="<?php echo $img['l'];?>" src="<?php echo $img['xs'];?>"/>
			</a-->	
			<?php } ?>   
		</div>
		
	</div><!-- End Div slider-toolkit -->
	
	<div id="s2" class="dn">
		
		<div class="royalSlider rsDefault"  id="rs2">			
			<?php foreach($fullscreenArray1 as $img_counts => $imgs) { ?>
			<a class="rsImg"  data-rsw="632" data-rsh="500" data-rsBigImg="<?php echo $imgs['l'];?>" href="<?php echo $imgs['xs'];?>">
				<img id="<?php echo $img_count;?>" data-rsBigImg="<?php echo $imgs['l'];?>" src="<?php echo $imgs['xs'];?>"/>
			</a>	
			
			<?php } ?>   
		</div>
		
	</div><!-- End Div slider-toolkit -->
	
 <div id="s3" class="dn">
		
		<div class="royalSlider rsDefault"  id="rs3">			
			<?php foreach($fullscreenArray2 as $img_count => $img) { ?>
			<a class="rsImg"  data-rsw="632" data-rsh="500" data-rsBigImg="<?php echo $img['l'];?>" href="<?php echo $img['xs'];?>">
				<img id="<?php echo $img_count;?>" data-rsBigImg="<?php echo $img['l'];?>" src="<?php echo $img['xs'];?>"/>
			</a>	
			<!--a class="rsImg"  data-rsw="632" data-rsh="500"   data-rsTmb="<?php echo $img['xs'];?>"  data-rsBigImg="<?php echo $img['l'];?>" href="<?php echo $img['xs'];?>">
				<img data-rsTmb="<?php echo $img['xs'];?>"  id="<?php echo $img_count;?>" data-rsBigImg="<?php echo $img['l'];?>" src="<?php echo $img['xs'];?>"/>
			</a-->	
			<?php } ?>   
		</div>
		
	</div><!-- End Div slider-toolkit -->	
	
	
	
	
	
<script>

 $('#rs1').royalSlider({   
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
	keyboardNavEnabled: true	
});
$('#rs2').royalSlider({   
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
	keyboardNavEnabled: true	
});
$('#rs3').royalSlider({   
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
	keyboardNavEnabled: true	
});
</script>
