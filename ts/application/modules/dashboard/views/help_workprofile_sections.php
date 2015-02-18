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

<?php if(isset($helpSection) && $helpSection=='personalDetails') { ?>
<!--Start div for Personal Details -->
<div class="row">
	<a href="<?php echo site_url().'workprofile/workProfileForm';?>">
		<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15 underline gray_clr_hover">Personal Details
		</div>
	</a>
<div class="clear"></div>
<div class="font_size12 font_opensans clr_3d3d3d mt7">
Here you can add all the personal details you may not have wanted to put up on your Showcase. It’s private! 
</div>
<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	
	
<div class="font_size12 font_opensans clr_3d3d3d mt7">
	<div class="seprator_14"></div>
	A few points to help fill in the form:
	<div class="clear"></div>
	<div class="seprator_5"></div>
	<ul class="dashside_inform">
		<li>
			<div>
				To upload an <b>Image</b> click <img src="<?php echo base_url();?>images/dashboard_images/help_icons/browse.png" class="display_inline mb-10"/>, select the image, fill in the Required Fields <img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png" class="display_inline"/> and on <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/> the image will upload.
			</div>
		</li>

		<li>
			<div>
				The <b>Achievements & Awards</b> WYSIWYG (What You See Is What You Get) editor allows you to format your text.
			</div>
		</li>
		<li>
			<div>
				Then add your <b>Education and Visa(s)</b>. Fill in the fields and save <img src="<?php echo base_url();?>images/dashboard_images/help_icons/savesmall.png" class="display_inline mb-5"/>. From the lists you can edit <img src="<?php echo base_url();?>images/dashboard_images/help_icons/editsmall.jpg" class="display_inline mb-5"/> or delete <img src="<?php echo base_url();?>images/dashboard_images/help_icons/deletsmall.png" class="display_inline mb-5"/> the entries. After you edit an entry you must re-save. 
			</div>
		</li>
	</ul>
	</div>

<div class="seprator_14"></div>
<div class="clear"></div>
<div class="font_size12 font_opensans clr_3d3d3d mt7">
From here add <img src="<?php echo base_url();?>images/dashboard_images/help_icons/employmenthistory.png" class="display_inline mb-10"/>, <img src="<?php echo base_url();?>images/dashboard_images/help_icons/refrences.png" class="display_inline mb-10"/> and <div class="seprator_5"></div><img src="<?php echo base_url();?>images/dashboard_images/help_icons/socialmedialinks.png" class="display_inline mb-10"/> to your Work Profile.
</div>
</div>
<!--End div for Personal Details -->
<?php } if(isset($helpSection) && $helpSection=='employmentHistory') {?>
<!--Start div for Employment History -->
<div class="row">
	<a href="<?php echo site_url().'workprofile/empHistoryListing';?>">
		<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15 underline gray_clr_hover">Employment History
		</div>
	</a>
<div class="clear"></div>
<div class="font_size12 font_opensans clr_3d3d3d mt7">
Click <img src="<?php echo base_url();?>images/dashboard_images/addinfor.png" alt="add" class="display_inline mb-5"/> and once you have entered the Required Fields <img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png" class="display_inline"/>, <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/>.
</div>
<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	
	
<div class="font_size12 font_opensans clr_3d3d3d mt7">
	<div class="seprator_14"></div>
	From the list of records you can:
	<div class="clear"></div>
	<div class="seprator_5"></div>
	<ul class="dashside_inform">
		<li>
			<div>
				Edit <img src="<?php echo base_url();?>images/dashboard_images/help_icons/editsmall.jpg" class="display_inline mb-5"/>,
			</div>
		</li>

		<li>
			<div>
				Delete <img src="<?php echo base_url();?>images/dashboard_images/help_icons/deletsmall.png" class="display_inline mb-5"/> and
			</div>
		</li>
		<li>
			<div>
				Change the order the records appear on your Showcase using the up <img src="<?php echo base_url();?>images/dashboard_images/help_icons/upsmall.png" class="display_inline mb-5"/> and down <img src="<?php echo base_url();?>images/dashboard_images/help_icons/downsmall.png" class="display_inline mb-5"/> arrows. 
			</div>
		</li>
	</ul>
	</div>
</div>
<!--End div of Employment History -->
<?php } if(isset($helpSection) && $helpSection=='references') {?>
<!--Start div for References -->
<div class="row">
	<a href="<?php echo site_url().'workprofile/referencesRecommendations';?>">
		<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15 underline gray_clr_hover">References
		</div>
	</a>
<div class="clear"></div>
<div class="font_size12 font_opensans clr_3d3d3d mt7">
Click <img src="<?php echo base_url();?>images/dashboard_images/addinfor.png"  class="display_inline mb-5"/> and once you have entered the Required Fields <img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png" class="display_inline"/>, <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/>.
</div>
<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	
	
<div class="font_size12 font_opensans clr_3d3d3d mt7">
	<div class="seprator_14"></div>
	From the list of References you can:
	<div class="clear"></div>
	<div class="seprator_5"></div>
	<ul class="dashside_inform">
		<li>
			<div>
				Edit <img src="<?php echo base_url();?>images/dashboard_images/help_icons/editsmall.jpg" class="display_inline mb-5"/>,
			</div>
		</li>

		<li>
			<div>
				Delete <img src="<?php echo base_url();?>images/dashboard_images/help_icons/deletsmall.png" class="display_inline mb-5"/> and
			</div>
		</li>
		<li>
			<div>
				Change the order the references appear on your Showcase using the up <img src="<?php echo base_url();?>images/dashboard_images/help_icons/upsmall.png" class="display_inline mb-5"/> and down <img src="<?php echo base_url();?>images/dashboard_images/help_icons/downsmall.png" class="display_inline mb-5"/> arrows. 
			</div>
		</li>
	</ul>
	</div>
</div>
<!--End div of References -->
<?php } if(isset($helpSection) && $helpSection=='mediaLinks') {?>

<!--Start div for Social Media Links -->
<div class="row">
	<a href="<?php echo site_url().'workprofile/socialMedia';?>">
		<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15 underline gray_clr_hover">Social Media Links
		</div>
	</a>
	<div class="clear"></div>
	<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	
	
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		<div class="seprator_14"></div>
		Link your social media sites to your Work Profile.
		<div class="clear"></div>
		<div class="seprator_5"></div>
		<ul class="dashside_inform">
			<li>
				<div>
					If you have added links to your Showcase Homepage, click <img src="<?php echo base_url();?>images/dashboard_images/help_icons/copylinksfropsh.png" class="display_inline mb-10"/>.
				</div>
			</li>

			<li>
				<div>
					Or to add a link click <img src="<?php echo base_url();?>images/dashboard_images/addinfor.png"  class="display_inline mb-5"/>, select which site you wish to add from the drop down and enter the URL of your page. For example, Toadsquare’s Facebook URL is https://www.facebook.com/<br/>pages/Toadsquare/<br/>121921117888970.
				</div>
			</li>
			<li>
				<div>
					Once you have entered the Required Fields <img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png" class="display_inline"/>, <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/>.
				</div>
			</li>
		</ul>
	</div>
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		<div class="seprator_14"></div>
		Then from the list of links you can:
		<div class="clear"></div>
		<div class="seprator_5"></div>
		<ul class="dashside_inform">
			<li>
				<div>
					Edit <img src="<?php echo base_url();?>images/dashboard_images/help_icons/editsmall.jpg" class="display_inline mb-5"/>,
				</div>
			</li>

			<li>
				<div>
					Delete <img src="<?php echo base_url();?>images/dashboard_images/help_icons/deletsmall.png" class="display_inline mb-5"/> and
				</div>
			</li>
			<li>
				<div>
					Change the order the links appear on your Showcase using the up <img src="<?php echo base_url();?>images/dashboard_images/help_icons/upsmall.png" class="display_inline mb-5"/> and down <img src="<?php echo base_url();?>images/dashboard_images/help_icons/downsmall.png" class="display_inline mb-5"/> arrows. 
				</div>
			</li>
		</ul>
	</div>
</div>
<!--Start div of Social Media Links-->
<?php } if(isset($helpSection) && $helpSection=='portfolio') {?>

<!--Start div for Portfolio -->
<div class="row">
	<a href="<?php echo site_url().'workprofile/workshowcase';?>">
		<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15 underline gray_clr_hover">Portfolio
		</div>
	</a>
	<div class="clear"></div>
	<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	
	
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		<div class="seprator_14"></div>
		You can add up to six pieces of each type of media to your Portfolio. These pieces will remain private, so you can add those you would not wish to put up on your public Showcase.
		<div class="clear"></div>
		<div class="seprator_5"></div>
		<ul class="dashside_inform">
			<li>
				<div>
					Click <img src="<?php echo base_url();?>images/dashboard_images/addinfor.png" class="display_inline mb-5"/> then <img src="<?php echo base_url();?>images/dashboard_images/help_icons/browse.png" class="display_inline mb-10"/>, select the file you wish to upload, fill in the Required Fields <img src="<?php echo base_url();?>images/dashboard_images/help_icons/requiredicon.png" class="display_inline"/> and on <img src="<?php echo base_url();?>images/dashboard_images/help_icons/save.png" class="display_inline mb-10"/> your file will upload. The file types you can upload for each section are listed under the upload field.
				</div>
			</li>
		</ul>
	</div>
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		<div class="seprator_14"></div>
		Each file needs to convert so that it can be shown properly. The Symbols show the conversion process:
		<div class="clear"></div>
		<div class="seprator_5"></div>
		<ul class="dashside_inform">
			<li>
				<div>
					<img src="<?php echo base_url();?>images/dashboard_images/help_icons/orangeconverter.png" class="display_inline"/> Converting,
				</div>
			</li>

			<li>
				<div>
					<img src="<?php echo base_url();?>images/dashboard_images/help_icons/greentick.png" class="display_inline"/> Converted and
				</div>
			</li>
			<li>
				<div>
						<img src="<?php echo base_url();?>images/dashboard_images/help_icons/redcross.png" class="display_inline"/> Conversion failed, please delete the file and try again.
				</div>
			</li>
		</ul>
	</div>
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		<div class="seprator_14"></div>
		Then from the media lists you can:
		<div class="clear"></div>
		<div class="seprator_5"></div>
		<ul class="dashside_inform">
			<li>
				<div>
					Edit <img src="<?php echo base_url();?>images/dashboard_images/help_icons/editsmall.jpg" class="display_inline mb-5"/> and
				</div>
			</li>

			<li>
				<div>
					Delete <img src="<?php echo base_url();?>images/dashboard_images/help_icons/deletsmall.png" class="display_inline mb-5"/>.
				</div>
			</li>
		</ul>
		<div class="clear seprator_14"></div>
		<div class="orange">All rights remain yours.</div> 
	</div>
	
</div>
<!--Start div of Portfolio-->
<?php } ?>
