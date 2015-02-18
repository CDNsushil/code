<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<td class="bg_white" valign="top">
	<div class="width_581_fright pr220">
		<div class="row width_776 pt30">
			<!--Next steps shows in this div-->
			<div id="next_steps">
			</div>
			<div id="default_option">
				<div class="f16 ml34 orange_color fm_os" id="insert_msg"></div>
				<div class="row width730px">
					<div class="popup_heading tal"> Please tell us why the media is Abusive or Inappropriate</div>
					<div class="pop_bdr"></div>
					<div class="position_relative">
						<?php
						$formAttributes = array(
							'name'=>'abuseReportOptions',
							'id'=>'abuseReportOptions',
						);
						echo form_open(base_url(lang().'/report_a_problem/reportproblem_step1'),$formAttributes);
						?>
						<div class="cell shadow_wp strip_absolute left_150">
							<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr>
									<td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
								</tr>
								<tr>
									<td class="shadow_mid_small">&nbsp;</td>
								</tr>
								<tr>
									<td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
								</tr>
							</tbody>
							</table>
							<div class="clear"></div>
						</div>
						<div class="seprator_10"></div>
						<div class="row">
							<div class="pop_label_wrapper cell">
								<div class="num_01 Fright"></div>
							</div>
							<!--label_wrapper-->
							<div class="pop_field_wrapper cell">
								<div class="defaultP">
									<input type="radio" checked id="abusiveForm" value="6" name="abusiveComplain">
								</div>
								<div for="month6" class="pop_radio_label">Some of the materials / content published on the website seem to be unacceptable based on my own personal opinion.</div>
							</div>
						</div>
						<div class="seprator_20 clear"></div>
						<div class="row">
							<div class="pop_label_wrapper cell">
								<div class="num_02 Fright"></div>
							</div>
							<!--label_wrapper-->
							<div class="pop_field_wrapper cell">
								<div class="defaultP">
									<input type="radio"  id="abusiveComplain" value="3" name="abusiveComplain">
								</div>
								<div for="month3" class="pop_radio_label">In my opinion some of the materials / content published on the website are illegal / inappropriate according to law.</div>
							</div>
							
							
							
							
							
							
						</div>
 						<div class="seprator_15 clear"></div>
	
						<div class="row">
							<div></div>
							<div class="tds-button Fright mr18"> 
							<button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Next" name="submit" type="submit" id="nextButton"><span><div class="Fleft">Next</div> </span></button>
					<!--<a href="javascript:void(0)" onclick="getReportSteps()" onmouseup=	"mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span>Next</span></a>-->
				</div>
						</div>
						<?php echo form_close(); ?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			
		</div>
	</div>
</td>
<td class="advert_column" valign="top">
<div class="cell  ">
	<!-- Div for 160x600 advert display -->
	<div class="ad_box ml11 mt10 mb10" id="advert160_600"><?php 
		if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
			//Manage right side advert
			$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'2'));
			if(!empty($bannerRhsData)) {
				$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'2','sectionId'=>$advertSectionId)); 
			} else {
				$this->load->view('common/adv_rhs');
			} 
		} else {
			$this->load->view('common/adv_rhs');
		}?>
	</div>
	
<div class="clear"></div>
</div>
</td>
<?php 
	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
		//manage auto advert params and js methods
		echo $advertChangeView;
	} ?>	
<script type="text/javascript">
/* Function to get reason form in abuse report */	
$(document).ready(function(){
	$("#abuseReportOptions").validate({
		submitHandler: function() {
			
			var fromData=$("#abuseReportOptions").serialize(); 	
			
			$('#next_steps').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
			$.post(baseUrl+language+'/report_a_problem/report_step2',fromData, function(data) {
				if(data){
					$('#default_option').hide();
					$('#next_steps').show();	
					$('#next_steps').html(data);		
				}
			});
		}
	});
});

/* Function to step back in abuse report option form*/	
function selection_change() {
	$('#default_option').show();
	$('#next_steps').hide();		
}	
		
</script>
