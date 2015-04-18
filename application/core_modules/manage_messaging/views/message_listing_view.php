<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="wrapperL" class="minHeight600px">
	<h1><?php echo $this->lang->line('messagingManager');?></h1>
	<div class="box menu">
			<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_messaging');?>">Home </a>|
			<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_messaging/compose_mail');?>"><?php echo $this->lang->line('composeMail');?></a>
	</div>
	<!-- End box language -->
	<div class="box" id="showUserList">
		<?php 
			echo $this->load->view("message_listing"); 
		?>
	</div>
</div>

