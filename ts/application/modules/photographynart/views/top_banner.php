<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script>
	$.gallery={options:{_imageListUL:'#imageList',
						_imageHolderDIV:'#imageHolder',
						_imageDiv:"#imageDiv",
						_imageDescriptionDiv:'#imageDescription',
						_imageActiveCSS:'imgActiveBorder',
						_imageLoader:'#loaderDiv',
						_autoPlay:true,
						_delay:5000}};
	
	$(document).ready(function() {
		initialise();
	});	
</script>
<div class="seprator_40"></div>

<div id="imageHolder" class="Banner_box_wp_new">	
    <div id="imageDiv">
		<img src=""  onclick="javascript:bigImageEvent()"/>
        <div id="loaderDiv">loading..</div>
    </div>
    <div id="messageDiv"></div>
    <div id="imageDescription"></div>

<div class="anythingSlider-default">
<span class="arrow back"><a href="javascript:prevImage()"><span></span></a></span>
<span class="arrow forward"><a href="javascript:nextImage()"><span></span></a></span>
</div>

	<div class="dn">
		<ul id="imageList">
			<li onclick="javascript:loadMe(this)" originalImage="<?php echo base_url();?>images/frontend/banners/banner_front_end03.jpg"><img src="<?php echo base_url();?>images/frontend/banners/banner_front_end03.jpg"/></li>
			<li onclick="javascript:loadMe(this)" originalImage="<?php echo base_url();?>images/frontend/banners/banner_front_end02.jpg"><img src="<?php echo base_url();?>images/frontend/banners/banner_front_end02.jpg"/></li>
			<li onclick="javascript:loadMe(this)" originalImage="<?php echo base_url();?>images/frontend/banners/banner_front_end.jpg"><img src="<?php echo base_url();?>images/frontend/banners/banner_front_end.jpg"/></li>
			<li onclick="javascript:loadMe(this)" originalImage="<?php echo base_url();?>images/frontend/banners/banner_front_end02.jpg"><img src="<?php echo base_url();?>images/frontend/banners/banner_front_end02.jpg"/></li>
			<li onclick="javascript:loadMe(this)" originalImage="<?php echo base_url();?>images/frontend/banners/banner_front_end.jpg"><img src="<?php echo base_url();?>images/frontend/banners/banner_front_end.jpg"/></li>
		</ul>
	</div>
 <div class="trans_box_wp_new">
              <!--login & Join box start-->
                <?php $this->load->view('auth/login_form_frontend');?> 
              
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
<div class="clear"></div>

