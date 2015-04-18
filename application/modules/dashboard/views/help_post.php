<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="cell shadow_wp strip_absolute_right left0">
	<!-- <img src="images/strip_blog.png"  border="0"/>-->
	<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td height="350"><img src="<?php echo base_url();?>images/dashboard_images/dashboard_newshedow_top.png"></td>
			</tr>
			<tr>
				<td class="dashnew_shadow_mid">&nbsp;</td>
			</tr>
			<tr>
				<td height="378"><img src="<?php echo base_url();?>images/dashboard_images/dashboard_newshedow_bottom.png"></td>
			</tr>
		</tbody>
	</table>
	<div class="clear"></div>
</div>

<?php if(isset($helpSection) && $helpSection=='post') { ?>
<!--Start div of Post details -->
<div class="row">
	<a href="<?php echo site_url().'blog/postForm';?>">
		<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15 underline gray_clr_hover">Posts
		</div>
	</a>
	<div class="clear"></div>
	<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		<div class="seprator_14"></div>
		A few points to help fill in the form:
		<div class="clear"></div>
		<div class="seprator_5"></div>
		<ul class="dashside_inform">
			<li>
				<div>
					To upload an image click <img src="<?php echo base_url();?>images/dashboard_images/help_icons/browse.png" class="display_inline mb-10"/>, select the file you wish to upload, fill in the Required Fields <img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png"  class="display_inline"/> and on <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/> your file will upload. The file types you can upload are listed under the upload field. 
				</div>
			</li>

			<li>
				<div>
					The WYSIWYG (What You See Is What You Get) editor allows you to format your <b>Post</b> and add links and pictures. It also allows you to add pre-loaded images from your <a href="<?php echo site_url().'blog/galleryimages';?>" class="underline dash_link_hover">Media Gallery</a>.
				</div>
			</li>

			<li>
				<div>
					Select a Category from the ones you set up in About Your Blog. People can use these to sort your Posts when looking at your Showcase.
				</div>
			</li>
		</ul>
	</div>

	<div class="seprator_14"></div>
	<div class="clear"></div>
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		Once you have filled in the Required Fields <img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png"  class="display_inline"/>, <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/> and <img src="<?php echo base_url();?>images/dashboard_images/help_icons/publish.png" class="display_inline mb-10"/>your Post from the Blog Index. You can <img src="<?php echo base_url();?>images/dashboard_images/editinfor.png" alt="add" class="display_inline mb-5"/> a Post at any time, it will automatically update on  <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/>.
		<div class="seprator_14"></div>
		<div class="orange">All rights remain yours.</div> 
	</div>
</div>
<!--End div of Post details -->

<?php } if(isset($helpSection) && $helpSection=='mediaGallery') {?>
<!--Start div of Media gallery -->
<div class="row">
	<a href="<?php echo site_url().'blog/galleryimages';?>">
		<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15 underline gray_clr_hover">Media Gallery
		</div>
	</a>
	<div class="clear"></div>
	<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		<div class="seprator_14"></div>
		Upload images so they are available for later use in your Posts.
		<div class="clear"></div>
		<div class="seprator_5"></div>
		<ul class="dashside_inform">
			<li>
				<div>
					To upload an Image click <img src="<?php echo base_url();?>images/dashboard_images/help_icons/browse.png" class="display_inline mb-10"/>, select the file you wish to upload, fill in the Alt Tags and on <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/> your file will upload. The file types you can upload are listed under the upload field. 
				</div>
			</li>
		</ul>
	</div>

	<div class="seprator_14"></div>
	<div class="clear"></div>
	<div class="font_size12 font_opensans clr_3d3d3d mt7 b">
		Note: In addition to helping people find you, Alt Tags appear if an image does not load.
	</div>
	<div class="seprator_14"></div>
		<div class="orange font_size12 font_opensans">All rights remain yours.</div> 
</div>
<!--End div of Media gallery -->
<?php }?>
