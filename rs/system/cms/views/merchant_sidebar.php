<?php defined('BASEPATH') OR exit('No direct script access allowed'); //this for side-bar menus for merchant.. ?>

<?php  $moduleName = (isset($module))?$module:''; ?>
  <div class="col-sm-3 col-sm-2 sidebar">
                            
	<!--/WIDGET FOR DASHBOARD NAVIGATIONS/-->
	<div class="widget">
		<div class="clearfix"></div>
		
	 <ul class="bullet_arrow2 categories changeproperty">
		 
		<li class="rs_dashboard dashbord"><a href="27_merchant_dashboard.html">
			<?php echo anchor('merchant/dashbord',lang('global:dashbord'), 'class=""');?>
		</li>
		
		<li class="rs_productbanner banner"><a href="26_merchant_banner.html">
			<?php echo anchor('merchant/banner',lang('global:products'), 'class=""');?>
		</li>
		
		 <li class="rs_affiliates affiliates"><a href="35_dashboard_affiliates.html">
			<?php echo anchor('merchant/affiliates',lang('global:affiliates'), 'class=""');?>
		</li>
	
		
		<li class="rs_sales sales">
			<?php echo anchor('merchant/sales',lang('global:sales')); ?>
		
		  <li class="rs_profile my-profile"><a href="22_dashboard_profile.html">
			<?php echo anchor('users/my-profile',lang('global:profile'), 'class=""');?>
		</li>
		
		<li class="rs_configuration configuration"><a href="23_dashboard_configuration.html">
			<?php echo anchor('merchant/configuration',lang('global:configuration'), 'class=""');?>
		</li>
		
		 <li class="rs_testimonial feedback"><a href="24_dashboard_testimonial.html">
			<?php echo anchor('merchant/feedback','Feedback To Affiliates', 'class=""');?>
		</li>
		
		
		<li class="rs_membership_details membership"><a href="21_dashboard_membership">
			<?php echo anchor('users/membership',lang('global:membership'), 'class=""');?>
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
