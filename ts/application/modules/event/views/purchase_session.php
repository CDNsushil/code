<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo Modules::run("event/indexNavigation"); ?>
<div class="clear"></div>
<div class="row mt6 position_relative">
<?php 
	//LEFT SHADOW STRIP
	echo Modules::run("common/strip");	
?>
	<div class="cell width_200">
	<div class="seprator_45"> </div>
		<div class="box-min-height">
		  <div class="liquid_box_wrapper">
			<table cellspacing="0" cellpadding="0" border="0">
			  <tbody><tr>
				<td><img border="0" src="<?php echo base_url();?>images/biggroupaerow.png"></td>
			  </tr>
			 <!-- <tr>
			 <td height="175"><a href="<?php //echo base_url().'common/download_event_badges'; ?>" class="ptr"><img border="0" src="<?php //echo base_url();?>images/downloadbadge.png"></a></td>
			  </tr>-->
			</tbody></table>
			<div class="seprator_30"> </div>
			 <div class="rouncircle_dastboard mb14 ml5">
				<a class="ptr" onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)"  href="<?php echo base_url().'common/download_event_badges'; ?>">
					<div class="AI_table">								
						<div class="AI_cell textcontainer dash_link_hover"><?php echo $this->lang->line('downloadYourBadge');?></div>
					</div>
				</a>
			</div>
			
		  </div> 
		</div>
	</div><!-- cell width_200 -->
	<div class="cell width_569 padding_left16">
		<div id="meetingPlaceContent">
		<?php $this->load->view('purchase_session_list') ?>
		</div><!-- meetingPlaceContent -->
	<div class="clear seprator_25"></div>
	</div><!-- cell width_569 padding_left16 -->
</div><!-- row mt6 position_relative -->
<script>	
$(function() {
$('.greencheck input[type="checkbox"]').ezMark({checkboxCls: 'ez-checkbox', checkedCls: 'ez-checked'})
}); 

function gotomeetingpoint(gotoMP){
	$('#usermeetingpoint').attr('action', gotoMP);
	$("#usermeetingpoint").attr('target', '_blank');
	$('#usermeetingpoint').submit();
}

function gortoUserShowcase(url)
{
	window.open(
	  url,
	  '_blank' // <- This is what makes it open in a new window.
	);
}

</script>
