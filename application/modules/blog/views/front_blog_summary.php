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
	         
<div class="cell width_476 sub_col_1 mr11 ml9">
 <div class="seprator_10"></div> 
		<div class="row">
			<div id="frontPostsInfo">
			<?php
			$userId = $this->uri->segment('4');
			if(!isset($userId)) $userId = LoginUserDetails('user_id');
			//This shows posts related with blog
			$defaultPostAttr['showFlag'] = 1;
			$defaultPostAttr['limitPosts'] = 0;
			echo Modules::run("blog/posts",0,'',$defaultPostAttr,@$userId);
			?>
			
		</div>
		</div>
	</div><!-- cell width_480 -->
	
	
	<div class="cell width_284 padding_left10 padding_right10 backgroundWhite sub_col_2">	
	<?php
		$frontRightArray['userId']=@$userId;
		$frontRightArray['blogId']=0;
		echo Modules::run("blog/frontRight",$frontRightArray);
	?>
</div>
