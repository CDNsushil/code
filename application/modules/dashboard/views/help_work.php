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
	<div class="font_opensans font_size14 clr_black lineH22 pb5">Please read the <a href="<?php echo site_url().'dashboard/loadWelcomePage/welcome_work';?>"><span class="display_inline clr_f1592a font_opensansSBold gray_clr_hover underline">Work Welcome </span></a> before you use this section.
		<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	</div>
</div>
<div class="row">
	<a href="<?php echo site_url().'work';?>">
	<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15 underline gray_clr_hover">Works Classifieds
</div></a>

<div class="font_size12 font_opensans clr_3d3d3d mt7">To add a Work Offered or Work Wanted Classified select the radio button next to the Tool you want to use in the appropriate Select Tool box, click <img src="<?php echo base_url();?>images/dashboard_images/help_icons/newclassified.png" class="display_inline mb-10"/> and fill in the forms in the wizard.
	<div class="clear"></div>
	<div class="seprator_14"></div>
	Then from the Dash you can:
	<div class="clear"></div>
	<div class="seprator_6"></div>
	<ul class="dashside_inform">
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
		
		<li>See how much space you have left to use,</li>

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
<div class="fl">On the Work Offered <img src="<?php echo base_url();?>images/dashboard_images/help_icons/workwantedindex.png" class="display_inline mb-5"/> and Work Wanted <img src="<?php echo base_url();?>images/dashboard_images/help_icons/workwantedindex.png" class="display_inline mb-5"/> Indices you will find more details and management tools.</div>
<div class="row"></div>
</div>

<div class="seprator_6"></div>
<?php if(!isset($isWorkTool) && empty($isWorkTool)) { ?>
<div class="row">
<a href="<?php echo site_url().'dashboard/work/containers';?>">
<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt18 underline gray_clr_hover">What are Work Tools?</div></a>
<div class="font_size12 clr_3d3d3d font_opensans mt12 lineh17">A Work Tool is free when you join. If you joined before 31st March 2014, two Tools are free as part of our opening special.<div class="seprator_14"></div>

A Work Tool guides you through your Showcase setup. The first thing you need to do when you use a Work Tool is choose whether your classified is for Work Wanted or Work Offered. If you have no available Tools and wish to put up another Work Classified, you will need to buy one for €6. Each Tool comes with 100 MB of space. If you need more, you can add it at €0.80 per 100<div class="seprator_14"></div>

A Work Tool is valid for three months after which you need to renew it. You can change the associated space when you renew, and it’s a good time to check it’s up to date.</div>
</div>

<div class="seprator_6"></div>


<div class="row">
<div class="fl"><a href="<?php echo site_url().'package/information';?>" class="orange underline gray_clr_hover">Membership Information</a> provides a detailed description of all Toadsquare Tools and prices.</div>
<div class="row"></div>
</div>
<?php }?>

</div>

</div>
