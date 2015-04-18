<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	// Workprofile left content area
	$this->load->view('new_version/workportfolio_left');
	
	// set count of images which exists
	if(isset($profileImages) && count($profileImages) > 0) { 
		$existImageCount = 1;
		foreach($profileImages as $images) {
			$filePath = $images->filePath.'/'.$images->fileName;
			if(file_exists(ROOTPATH.$filePath)) {
				$existImageCount++;
			}
		}
	}
	?>
	<!-- Portfolio Image list right content area-->
	<div class=" portslider fl" >
		<!--==================  full screen slider  start ============-->
		<div class="wrap_tab">
			<!--==================  banner start ============-->
			<div id="slider" class="flexslider">
				<ul class="slides">
					<?php  
					// get image count
					$imageCount = count($profileImages);
					if(isset($profileImages) && count($profileImages) > 0) { 
						$i = 1;
						foreach($profileImages as $images) {
							$filePath = $images->filePath.'/'.$images->fileName;
							if(file_exists(ROOTPATH.$filePath)) {
								$profileImagesThumbImage = addThumbFolder($filePath,'_xxl'); 
								$imagePath = getImage($profileImagesThumbImage,$this->config->item('defaultNoMediaImg'));
								?>
								<li>
									<span class="img_slide">   
										<img src="<?php echo $imagePath;?>" /> 
									</span>
									<div class="slide-text box_onbanner">
										<h2 class="text_alighL fl  "><?php echo $images->mediaTitle?> </h2>
										<div class="count"><span class="current-slide"><?php echo $i;?></span> / <span class="total-slides"><?php echo $existImageCount;?></span></div>
									</div>
									<?php if(!empty($images->mediaDesc)) { ?>
										<div class="slide_discrip">
											<div id="discrip" class="display_block active"> Description <i class="downarrow"></i></div>
											<div id="discrip" class="dactive" > Close Description <i class="downarrow"></i></div>
											<div class="discrip_content box_siz lineH22 ">          
												<span>  
													<?php echo nl2br($images->mediaDesc); ?>
												</span>	
												<div class="sap_25 bb_c2c2"></div>
											</div>
										</div>
									<?php } ?>
								</li>
								<?php
								$i++; 
							} 
						}
						
					}?>
				</ul>	
			</div>
		</div>
		<!--==================  full screen banner end ============--> 
		 
		<!--================== thumnail  slider  start ============--> 
		<div class="thumbnail pt12">
			<a href="#" class="prev_buttn btn_ar"> prev</a>
			<!--================== carousel thumnail  start ============--> 
			<div id="carousel" class="flexslider">
				<ul class="slides" id="sldierul_1" >
					<?php  
					// get image count
					$imageCount = count($profileImages);
					if(isset($profileImages) && count($profileImages) > 0) { 
						$i = 1;
						foreach($profileImages as $images) { 			
							$filePath = $images->filePath.'/'.$images->fileName;
							if(file_exists(ROOTPATH.$filePath)) {
								$profileImagesThumbImage = addThumbFolder($filePath,'_m'); 
								$imagePath = getImage($profileImagesThumbImage,$this->config->item('defaultNoMediaImg'));?>
								<li >
									<img src="<?php echo $imagePath;?>" alt="" />
									<div class="thum_text box_onbanner">
										<div class="count"><span class=""><?php echo $i;?></span>/<span class="total-slides"><?php echo $existImageCount;?></span></div>
										<span class="title">
											<?php echo $images->mediaTitle?>
										</span> 
										<a href="#" class="fshel_light fs16">VIEW IMAGE </a> 
									 </div>
								</li>
								<?php
								$i++;
							}
						}
					} ?>
				</ul>
			</div>
			<!--================== carousel slider end ============--> 
			<a href="#" class="next_buttn btn_ar">next </a>
		</div>
	</div>	

<script type="text/javascript">
         $(window).load(function() {
         // The slider being synced must be initialized first
         $('#carousel').flexslider({
           animation: "slide",
           controlNav: false,
           animationLoop: false,
           slideshow: false,
           itemWidth: 207,
           itemMargin: 0,
           asNavFor: '#slider'
         });
         
        $('#slider').flexslider({
                animation: 'slide' ,
                animationLoop: true,
                pauseOnAction: true ,  
                pauseOnHover: true ,
                controlNav: false ,
                directionNav: true ,
                slideshow: false,
                sync: "#carousel",
                controlsContainer: '.container-images .slide-count' ,
                manualControls: '.container-images .flex-direction-nav li a' ,
                useCSS: true ,
                touch: true ,
                start: function(slider){
                    $('.total-slides').text(slider.count);
                },
                before: function(slider){
                   $(".discrip_content").slideUp();
                },
                after: function(slider){
                    $('.current-slide').text(slider.currentSlide+1); // js array starts with 0 .. so +1 
                }
            });
        });
         
         
      </script>
