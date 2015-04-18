<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="box-min-height">
		<div class="liquid_box_wrapper">
			<table  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top"><img src="<?php echo base_url('images/liquied_top1.png')?>" /></td>
					<td class="liquid_top_mid1">&nbsp;</td>
					<td valign="top"><img src="<?php echo base_url('images/liquied_top3.png')?>" /></td>
				</tr>
				<tr>
					<td class="liquid_mid1">&nbsp;</td>
					<td>
						<script>
							/*$(function() {
								$('#gallery<? echo $imageUniqueId;?> a').lightBox();
							});*/
						</script>
						<div id="gallery<? echo $imageUniqueId;?>" class="gallery">
							<ul>
							<?php 
							//echo $defaultImage;
							$showDefaultImage=0;
							if(!empty($sliderImages)){
							foreach($sliderImages as $k =>$slider){	
								
								
								if(file_exists(ROOTPATH.$slider->filePath.$slider->fileName))
								{
								 //if($k==0) $suffix='_s';
								// else $suffix='_m';
								 $sliderThumbImage = addThumbFolder(@$slider->filePath.@$slider->fileName,'_m');
								 $finalSliderThumbImage = getImage($sliderThumbImage,$defaultImage,1);
												
								?>
								<li>
									<!--a href="<?php echo $finalSliderThumbImage;?>" -->
										<img src="<?php echo $finalSliderThumbImage;?>" alt="" border="0" class="maxWidth165px maxHeight182px" />
									<!--/a-->
								</li>
								<?php 
								}
								else {
									
									if($showDefaultImage==0){
										$showDefaultImage=1;
										?>
										<li>
										<img src="<?php echo getImage($defaultImage);?>" alt="" border="0" class="maxWidth165px maxHeight182px" />
										</li>
										<?php 
									}
								}					
							}
							}
							else{ ?>
								<img src="<?php echo getImage($defaultImage);?>" alt=""  border="0" class="maxWidth165px maxHeight200px" />
								<?php 
							} ?>
							</ul>
							
						</div>
					
					</td>
					<td class="liquid_mid2"> &nbsp;
					</td>
				</tr>
				<tr>
					<td><img src="<?php echo base_url('images/liquied_bottom1.png')?>" /></td>
					<td class="liquid_bottom_mid">&nbsp;</td>
					<td><img src="<?php echo base_url('images/liquied_bottom3.png')?>" /></td>
				</tr>
			</table>
			<div class="liquid_box_shadow"> </div>
		</div>
</div>	

