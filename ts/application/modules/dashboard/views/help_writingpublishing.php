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
	<div class="font_opensans font_size14 clr_black lineH22 pb5">Please read the <a href="<?php echo site_url().'dashboard/loadWelcomePage/welcome_writingpublishing';?>"><span class="display_inline clr_f1592a font_opensansSBold gray_clr_hover underline">Writing & Publishing Welcome </span> </a>before you use this section.
		<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	</div>
</div>

<div class="row">
	<?php if(!isset($isnewsReview) && empty($isnewsReview)) { ?>
	<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15">Writing & Publishing Projects</div>

	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		To add a Writing & Publishing Project select the radio button next to the Tool you want to use in the Select Tool – Media box, click <img src="<?php echo base_url();?>images/dashboard_images/help_icons/newproject.png" class="display_inline mb-10"/> and fill in the forms in the wizard.
		<div class="clear"></div>
		<div class="seprator_14"></div>
		Then from the Dash you can:
		<div class="clear"></div>
		<div class="seprator_6"></div>
		<ul class="dashside_inform">
			<li>
				<div>
					Add
					<img src="<?php echo base_url();?>images/dashboard_images/addinfor.png" alt="add" class="display_inline mb-5"/>
					another piece of media to it,
				</div>
			</li>
			<li>
				<div>
					Edit
					<img src="<?php echo base_url();?>images/dashboard_images/editinfor.png" alt="add" class="display_inline mb-5"/> it
				</div>
			</li>

			<li>
				<div>
					View
					<img src="<?php echo base_url();?>images/dashboard_images/viewinfoer.png" alt="add" class="display_inline mb-5"/> 
					it on your Showcase,
				</div>
			</li>
			
			<li> See how much space you have left to use,</li>

			<li>
				<div>
					<img src="<?php echo base_url();?>images/dashboard_images/addspace.png" alt="add" class="display_inline mb-10"/>
					if you exceed the 100 MB limit and
				</div>
			</li>
			
			<li> 
				<div class="seprator_6"></div>
				<img src="<?php echo base_url();?>images/dashboard_images/renew.png" alt="add" class="display_inline mb-10"/> it.
			</li>
		</ul>
		<div class="clear"></div>
		<div class="row mt15">
			<div class="fl">
				On the Writing & Publishing Index <img src="<?php echo base_url();?>images/dashboard_images/help_icons/writingorpublishingindex.png" class="display_inline mb-5"/> you will find more details and management tools.
			</div>
			<div class="row"></div>
		</div>
	
	<div class="seprator_6"></div>
	</div>
	<?php }?>
	<?php if(!isset($isWriting) && empty($isWriting) && !isset($isnewsReview) && empty($isnewsReview)) { ?>
	<div class="row">
	<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt18">What is a Media Tool?</div>
	<div class="font_size12 clr_3d3d3d font_opensans mt12 lineh17">You have three free Media Tools that are valid for the lifetime of your membership. They can be used for Projects in Film & Video, Music & Audio, Photography & Art, Writing & Publishing and Educational Material.<div class="seprator_14"></div>

	A Media Tool guides you through your Showcase setup. If you have no available Media Tools and wish to put up another Writing & Publishing Project, you will need to buy one for €6. Each Tool comes with 100 MB of space. If you need more, you can add it at €0.80 per 100 MB. <div class="seprator_14"></div>

	A Tool is valid for six months after which you need to renew it. You can change the associated space when you renew, and it’s a good time to check it’s up to date.</div>
	</div>
	
	<div class="seprator_6"></div>
	<?php }?>
	
	<?php if(!isset($isWriting) && empty($isWriting)) { ?>
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
	<div class="row">
	<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt18">News Articles and Reviews </div>
	<div class="font_size12 clr_3d3d3d font_opensans mt12 lineh17">A collection of News Articles and a collection of Reviews are free and each comes with 100 MB of space. If you need more, you can add it at €0.80 per 100 MB for six months.<div class="seprator_14"></div>

	To add a News Article or Review click <img src="<?php echo base_url();?>images/dashboard_images/help_icons/newarticle.png" class="display_inline mb-10"/> or <img src="<?php echo base_url();?>images/dashboard_images/help_icons/newreview.png" class="display_inline mb-10"/> and fill in the forms in the wizard.<div class="seprator_14"></div>

	You can also click Review <img src="<?php echo base_url();?>images/dashboard_images/help_icons/review.png" class="display_inline mb-10"/> on another member’s Showcases to add a Review. If you do this, your Review will appear on that member’s Showcase as well as on your Writing & Publishing Showcase.</div>

	<div class="clear"></div>
	<div class="seprator_14"></div>
		Then from the Dash you can:
		<div class="clear"></div>
		<div class="seprator_6"></div>
		<ul class="dashside_inform">
			<li>
				<div>
					Add another
				
					<img src="<?php echo base_url();?>images/dashboard_images/help_icons/newarticle.png" class="display_inline mb-10"/> or <img src="<?php echo base_url();?>images/dashboard_images/help_icons/newreview.png" class="display_inline mb-10"/> 
					to your Writing & Publishing Showcase,
				</div>
			</li>

			<li>
				<div>
					View 
					<img src="<?php echo base_url();?>images/dashboard_images/viewinfoer.png" alt="add" class="display_inline mb-5"/> 
					your latest Article or Review on your Showcase,
				</div>
			</li>
			
			<li> See how much space you have left to use and </li>

			<li>
				<div>
					<img src="<?php echo base_url();?>images/dashboard_images/addspace.png" alt="add" class="display_inline mb-10"/>
					if you exceed the 100 MB limit.
				</div>
			</li>
		</ul>
	<div class="clear"></div>
	</div>
	<div class="row mt15">
	<div class="fl">On the News Collection <img src="<?php echo base_url();?>images/dashboard_images/help_icons/newscollectionindexpage.png" class="display_inline mb-5"/> and Reviews Collection <img src="<?php echo base_url();?>images/dashboard_images/help_icons/reviewcollectionindex.png" class="display_inline mb-5"/> Indices you will find more details and management tools.</div>
	<div class="row"></div>
	</div>

	<div class="seprator_6"></div>


	<div class="row">
	<div class="fl"><a href="<?php echo site_url().'package/information';?>" class="orange underline gray_clr_hover">Membership Information</a> provides a detailed description of all Toadsquare Tools and prices.</div>
	<div class="row"></div>
	</div>
</div>
    <?php }?>
</div>
