<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if(count($icons)>0){ ?>
		<div class="social_main">
			<?php 
			if($icons->blogToTwitter == 't') 
			{
			?>
				<a href="" class="icon_twitter"></a>
			<?php
			}
			?>
			<?php 
			if($icons->blogToFacebook == 't') 
			{
			?>
				<a href="" class="icon_facebook"></a>
			<?php
			}
			?>
			<?php 
			if(0) 
			{
			?>
				<a href="" class="icon_linkedin"></a>			
			<?php
			}
			?>
			<a href=""  class="icon_mailbox"></a>
			<a href=""  class="icon_rss"></a>
		</div><!--social_main-->
<?php } ?>

<?php 
// 
?>
