<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="wrapperL">
	<h1>Suggestions Manager</h1>
	<div class="box menu">
			<a href="#">Home</a>
	</div>
	
	<div class="box"id="showSuggestionsList">
		<?php 
			echo $this->load->view("suggestions_list"); 
		?>
	</div>
</div>
