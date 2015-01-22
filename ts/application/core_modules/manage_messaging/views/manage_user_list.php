<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="wrapperL">
	<h1><?php echo $this->lang->line('messagingManager');?></h1>
	<div class="box menu">
			<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_messaging');?>">Home</a>
	</div>
	<!-- End box language -->
	<div class="box" id="showUserList">
		<?php 
			echo $this->load->view("user_listing"); 
		?>
	</div>
</div>

