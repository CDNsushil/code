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

<?php if(isset($helpSection) && $helpSection=='recommendationsReceive') { ?>
<!-- Start div for Recommandation receive section-->
<div class="row">
	<a href="<?php echo site_url().'showcase/recommendations';?>">
		<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15 underline gray_clr_hover">Recommendations Received
		</div>
	</a>
	<div class="clear"></div>
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		If you have allowed other members to recommend you on the <a href="<?php echo site_url().'showcase/showcaseForm';?>" class="underline dash_link_hover">Showcase Homepage form</a>, you can see the Recommendations you receive here.
	</div>
	<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		<div class="seprator_14"></div>
		<ul class="dashside_inform">
			<li>
				<div>
				Choose whether to put a Recommendation on your Showcase Homepage and/or your Work Profile by selecting the appropriate tick-boxes. You can also delete <img src="<?php echo base_url();?>images/dashboard_images/help_icons/deletsmall.png" class="display_inline mb-5"/> a recommendation.
				</div>
			</li>

			<li>
				<div>
					Click the box to see the member’s Showcase.
				</div>
			</li>
		</ul>
	</div>
	<div class="clear"></div>
</div>
<!-- End div of Recommandation receive section-->
<?php } if(isset($helpSection) && $helpSection=='recommendationsGiven') {?>

<!-- Start div for Recommandation given section-->
<div class="row">
	<a href="<?php echo site_url().'showcase/recommendationsgiven';?>">
		<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15 underline gray_clr_hover">Recommendations Given
		</div>
	</a>
	<div class="clear"></div>
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		This is a record of the recommendations you have given to other members. 
	</div>
	<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	
	<div class="font_size12 font_opensans clr_3d3d3d mt7">
		<div class="seprator_14"></div>
		<ul class="dashside_inform">
			<li>
				<div>
				Click the box to see the member’s Showcase.
				</div>
			</li>
		</ul>
	</div>
	<div class="clear"></div>
</div>
<!-- End div of Recommandation given section-->
<?php }?>
