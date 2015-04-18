<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>

	<div class="popup_gredient ">
	  <div class="row pt15 pb15 pr10 pl10 ">
		<div class="cell width_320 ">
		  
		  <div class="blog_profile_title dash_link_hover"><?php  echo $title; ?></div>
		  <div class="blog_profile_date ml0 pb10"><?php  echo date("d F Y", strtotime($startDate)); ?></div>
		  
		  <div class="blog_profile_txt"><?php  echo $description; ?></div>
		</div>
		<div class="clear seprator_13"></div>
	  </div>
	</div>

</div>
