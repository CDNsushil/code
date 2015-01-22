<?php defined('BASEPATH') OR exit('No direct script access allowed'); //this for side-bar menu for affiliate.. ?>
<?php  $moduleName = (isset($module))?$module:''; ?>
	<div class="col-sm-3 col-sm-2 sidebar">
                            
	<!--/WIDGET FOR DASHBOARD NAVIGATIONS/-->
	<div class="widget">
		<div class="clearfix"></div>
		
		 <ul class="bullet_arrow2 categories changeproperty">
			<li class="rs_dashboard "><a href="27_merchant_dashboard.html">
				
				<?php echo anchor('affiliate/dashbord',lang('global:dashbord'), 'class=""');?>
			</li>
			<li class="rs_productbanner banners"><a href="26_merchant_banner.html">
				<?php echo anchor('affiliate/banners',lang('global:product_banner'), 'class=""');?>
			</li>
			<li class="rs_payout request"><a href="24_dashbard_payout.html">
				<?php echo anchor('affiliate/request',lang('global:payment_request'), 'class=""');?>
			</li>
			<li class="rs_sales payment"><a href="34_dashbard_payout.html">
				<?php echo anchor('affiliate/payment',lang('global:payment'), 'class=""');?>
			</li>
			 <li class="rs_profile my-profile"><a href="22_dashboard_profile.html">
				<?php echo anchor('users/my-profile',lang('global:profile'), 'class=""');?>
			</li>
			<li class="rs_configuration configuration"><a href="23_dashboard_configuration.html">
				<?php echo anchor('affiliate/configuration',lang('global:configuration'), 'class=""');?>
			</li>
			<!--<li class="rs_testimonial testimonial"><a href="23_dashboard_configuration.html">
				<?php //echo anchor('affiliate/testimonial',lang('global:testimonial'), 'class=""');?>
			</li> -->
			 <li class="rs_membership_details feedback"><a href="24_dashboard_testimonial.html">
				<?php echo anchor('affiliate/feedback','Merchant Feedback', 'class=""');?>
			</li>
			
		</ul>
		
		</div>
</div>

<script type="text/javascript">
	var module='<?php echo $moduleName;?>';
	$( document).ready(function(){
		$('.'+module).addClass('active_nav');
	});
</script>
