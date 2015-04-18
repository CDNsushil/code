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
                <?php $this->load->view('auth/login_form_frontend');?> 
              <?php 
              /*
              <div>
                <div class="wp_login_title">Login</div>
                <div class="seprator_5"></div>
                <div class="pl10 pr10">
                  <div class="login_input_bg">
                    <input type="text" name="" value="Username">
                  </div>
                  <div class="seprator_7"></div>
                  <div class="login_input_bg">
                    <input type="text" name="" value="Password">
                  </div>
                </div>
                <div><a class="login_go_btn" onmouseup="mouseup_login_go_btn(this)" onmousedown="mousedown_login_go_btn(this)" href="#">Login</a><span class=""></span></div>
                <div class="seprator_14 clear"></div>
                <div class="line6 ml10 mr10"></div>
                <div class="seprator_5"></div>
                <div class="joinbtn_placing"><a class="login_go_btn" onmouseup="mouseup_login_go_btn(this)" onmousedown="mousedown_login_go_btn(this)" href="#">Join</a></div>
                <div class="wp_login_title">
                
                Join</div>
                <div class="login_input_bg mr10 ml10 mt3">
                  <div class="temp_space" style="width:140px; height:20px;"></div>
                </div>
                <div class="seprator_20"></div>
                <div class="line6 ml10 mr10"></div>
                <div class="seprator_3"></div>
              </div>
              */ ?>
              <!--login & Join box end-->
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

