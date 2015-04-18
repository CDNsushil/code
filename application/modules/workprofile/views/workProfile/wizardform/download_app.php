<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'addButtonForm',
    'id'=>'addButtonForm',
);

// set base url
$baseUrl = base_url(lang().'/workprofile/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
	<div class="c_1 clearb">
		<h3>Download our Toadsquare App.</h3>
		<div class="sap_30"></div>
		<p>Download our Toadsquare App. and sync your Work Profile & Portfolio and its included media with your Smart Phone or Tablet, </p> 
		<div class="sap_60"></div> 
		<div class="width445 m_auto display_table">
			<span class="table_cell">   <a href=""> <img src="<?php echo site_url();?>/images/app_store.png" alt="" /> </a> </span>
			<span class="fr table_cell"> <a href=""><img src="<?php echo site_url();?>/images/android.png" alt="" /> </a>  </span>
		</div>
	</div>
	<!-- Form buttons -->
	<?php
	// set back page
	$data['backPage'] = '/workprofile/addbutton';
	// set next page
	$data['isNextstep'] = '1';
	$data['nextPage'] = '/home';
	$this->load->view('workProfile/wizardform/common_buttons',$data);
	?>
</div>

