<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
 <script>
		// Set up Sliders
		// **************
		$(function(){

			$('#wp_banner_slider').anythingSlider({
				mode                : 'f',   // fade mode - new in v1.8!
				resizeContents      : false, // If true, solitary images/objects in the panel will expand to fit the viewport
				buildNavigation     : false,
				buildStartStop		: false,
				autoPlay            : true,
				hashTags			:false // Should not links change the hashtag in the URL? this required to be false to show clicked Image as default Image			  
				
			});

		});
	</script>

<div class="seprator_40"></div>
<div class="Banner_box_wp_new">
            <ul id="wp_banner_slider">
              <li><img src="<?php echo base_url();?>images/frontend/banners/banner_front_end02.jpg"/></li>
              <li><img src="<?php echo base_url();?>images/frontend/banners/banner_front_end.jpg"/></li>
              <li><img src="<?php echo base_url();?>images/frontend/banners/banner_front_end02.jpg"/></li>
              <li><img src="<?php echo base_url();?>images/frontend/banners/banner_front_end.jpg"/></li>
            </ul><!-- End wp_banner_slider -->
            
            <div class="trans_box_wp_new">
              <!--login & Join box start-->
				<?php $this->load->view('auth/login_form_frontend');?> <!--login & Join box end-->
              <div class="wp_login_title">Search</div>
              <div class="seprator_8"></div>
              <div class="search_box_wrapper ml10 wp_serch_box_wrapper width170px">
                <input type="text" value="Keyword Search..." class="search_text_box wp_login_serch">
                <div class="search_btn"> <img src="<?php echo base_url();?>images/btn_search_box.png"></div>
              </div>
              <div class="seprator_10 clear"></div>
              <!--banner_indigator_wp-->
            </div>
          </div><!--Banner_box_wp-->

