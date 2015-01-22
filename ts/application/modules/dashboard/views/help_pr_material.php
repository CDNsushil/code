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

<div class="row">
	<!--<a href="<?php //echo site_url().'showcase/additionalInfoForm';?>">-->
		<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15">PR Material
		</div>
		<!--</a>-->
<div class="clear"></div>
<div class="font_size12 font_opensans clr_3d3d3d mt7">
Start your online Public Relations campaign and beef up your Homepage with your PR material. 
</div>
<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	
	
<div class="font_size12 font_opensans clr_3d3d3d mt7">
	<?php if(isset($isIntroducrory) && $isIntroducrory==1) {?>
	<div class="seprator_14"></div>
	<div class="row">
	<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt18">Introductory Video and Video Interview</div>
</div>
	<div class="clear"></div>
	<div class="seprator_5"></div>
	<ul class="dashside_inform">
		<li>
			<div>
				To upload a video file click  
				<img src="<?php echo base_url();?>images/dashboard_images/addinfor.png" class="display_inline mb-5"/>
				 then 
				<img src="<?php echo base_url();?>images/dashboard_images/help_icons/browse.png" class="display_inline mb-10"/>
				, select the file you wish to upload, fill in the Required Fields 
				<img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png" class="display_inline"/>
				and on  
				<img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/>
				 your file will upload. The file types you can upload are listed under the upload field. Choosing to upload a video will take up much more space than embedding one. 
			</div>
		</li>

		<li>
			<div>
				To embed click <img src="<?php echo base_url();?>images/dashboard_images/help_icons/embed.png" class="display_inline mb-10"/>, enter the embed code provided by the site your video is hosted on, fill in the Required Fields <img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png" class="display_inline"/> and <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/>. 
			</div>
		</li>

		<li>
			<div>
				Edit <img src="<?php echo base_url();?>images/dashboard_images/help_icons/editsmall.jpg" class="display_inline mb-5"/> or delete <img src="<?php echo base_url();?>images/dashboard_images/help_icons/deletsmall.png" class="display_inline mb-5"/> your videos at any time.
			</div>
		</li>
	</ul>
<div class="clear"></div>
<?php }?>
<div class="seprator_14"></div>
<div class="row">
	
	<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt18 ">News</div>
</div>
<div class="seprator_5"></div>
	<div class="clear"></div>
	<ul class="dashside_inform">
		<li>
			<div>
				To add <img src="<?php echo base_url();?>images/dashboard_images/addinfor.png" alt="add" class="display_inline mb-5"/> news select the radio button next to Search on Toadsquare, External URL or Embed URL. 
			</div>
		</li>
		<li>To add news using Search on Toadsquare enter your search term, search <img src="<?php echo base_url();?>images/dashboard_images/help_icons/search_icon.png" alt="add" class="display_inline mb-5"/> and click on the news article you wish to add, fill in the Required Fields <img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png" class="display_inline"/> and <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/>.</li>	
		<li>To add an external URL enter the URL, fill in the Required Fields <img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png" alt="add" class="display_inline"/> and <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/>.</li>	
		<li>To embed news enter the embed code provided by the site hosting your work, fill in the Required Fields <img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png" class="display_inline"/> and <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/>.</li>	
	</ul>
<div class="clear"></div>

<div class="seprator_14"></div>
<?php if(!isset($isreviews)) {?>
<div class="row">
	
	<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt18">External Reviews </div>
</div>
<div class="seprator_5"></div>
<div class="clear"></div>
	<ul class="dashside_inform">
		<li>
			<div>
				To add <img src="<?php echo base_url();?>images/dashboard_images/addinfor.png" alt="add" class="display_inline mb-5"/> an External Review use External URL or Embed URL. 
			</div>
		</li>	
	</ul>
<div class="row">
<div class="fl">Note: Reviews written by members of Toadsquare are automatically added to your Showcase.</div>
<div class="row"></div>
</div>
<?php }?>
</div>

</div>
