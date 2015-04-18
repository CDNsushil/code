<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'addButtonForm',
    'id'=>'addButtonForm',
);

// set base url
$baseUrl = base_url(lang().'/workprofile/');
$btnChecked = '';
if(isset($workProfileDetails->isRequestBtnShowOnShowcase) && $workProfileDetails->isRequestBtnShowOnShowcase == 't') {
	$btnChecked = 'checked';
}
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
	<div class="c_1 clearb">
		<h3>Add buttons to your Homepage to allow other members to:</h3>
		<div class="sap_25"></div>
		<?php echo form_open($baseUrl.'/setaddbutton/',$formAttributes); ?>      
			<p class="defaultP">
				<input type="checkbox" name="isRequestBtnShowOnShowcase" <?php echo $btnChecked;?> />	
				You can add a button to your Showcase Homepage allowing other members to send you a 
				request through Tmail to see your Work Profile & Portfolio 
			</p>
			<div class="clearb pt15">
				<img src="<?php echo site_url() ;?>/images/add_btn.jpg" alt="" class="fr"  />
			</div>		
			<div class="sap_65"></div>
			<ul class="list_mb15 mt30 clearbox">
				<li class="icon_2"> 
					You can remove this button from 
					<span class="arialbold">Your Toadssquare > <a href="">Your Work Profile & Portfolio</a> </span>
				</li>

				<li class="liststyle_none pl33">
					You can read your Tmail from 
					<span class="arialbold">Your Toadssquare > <a href="">Your Message Centre</a></span>
				</li>
			</ul>
		<?php echo form_close();?>	
	</div>

	<!-- Form buttons -->
	<?php 
	// set back page
	$data['backPage'] = '/workprofile/emaillink';
	$data['formName'] = 'addButtonForm';
	
	$this->load->view('workProfile/wizardform/common_buttons',$data);
	?>
</div>

