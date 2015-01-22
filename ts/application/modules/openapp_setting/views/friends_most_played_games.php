  <div class="smallTextOp">Most played games for your friends</div>
  <div class="SpaceFix_6"></div>
  <div class="clear"></div>
  <div class="mostPlayedGmsBox">
  <div style="width : 766px;height :164px;display:block;">
	<?php foreach($apps as $app){ ?>
		<div>
			<a href="<?php  echo $app->url; ?>" target="_blank">
				<img width="53" height="53" src="<?php  echo $app->thumbnail; ?>" />
			</a>
		</div>
		<!--<div><img src="<?php //echo OPENSOCIAL_IMG; ?>2.jpg" /></div>
		<div><img src="<?php //echo OPENSOCIAL_IMG; ?>3.jpg" /></div>
		<div><img src="<?php //echo OPENSOCIAL_IMG; ?>4.jpg" /></div>
		<div><img src="<?php //echo OPENSOCIAL_IMG; ?>5.jpg" /></div>
		<div><img src="<?php //echo OPENSOCIAL_IMG; ?>6.jpg" /></div>
		<div><img src="<?php //echo OPENSOCIAL_IMG; ?>7.jpg" /></div>
		<div><img src="<?php //echo OPENSOCIAL_IMG; ?>8.jpg" /></div> -->
	<?php } ?>
  </div>
