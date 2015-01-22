<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="cell  strip_absolute_right shadow_wp">

		<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td height="271">	<img src="<?php echo base_url()?>images/shadow-top.png"></td>
			</tr>
			<tr>
				<td class="shadow_mid">&nbsp;</td>
			</tr>
			<tr>
				<td height="271"><img src="<?php echo base_url()?>images/shadow-bottom.png"></td>
			</tr>
		</tbody>
		</table>

		<div class="clear"></div>
	</div>          
<div class="row summery_post_wrapper">
           
 <div class="cell width_480 sub_col_1">
		<div class="row main_blog_box bg-non">
			<div id="frontPostsInfo">
			<?php
			//This shows posts related with blog
			$defaultPostAttr['showFlag'] = 1;
			$defaultPostAttr['limitPosts'] = 0;
			echo Modules::run("blog/posts",$blogId->blogId,'',$defaultPostAttr);
			?>
			
		</div>
		</div>
	</div><!-- cell width_480 -->
	
	
	<div class="cell width_311 right_panel_gray_bg sub_col_2">	
	<?php
		echo Modules::run("blog/frontRight",$blogId->blogId);
	?>
</div>


</div>
