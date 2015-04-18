<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<link href="<?php echo ADMINCSS?>styleLanguage.css" type="text/css" rel="stylesheet"/>

<div id="wrapperL">
	<h1><?php echo $this->lang->line('admin_Manage_Reports'); ?></h1>
		
	<!--Top menu home link -->
	<div class="box menu">
		<a href="<?php echo site_url('admin/settings/manage_news');?>"><?php echo $this->lang->line('cms_home_link');?></a>
	</div>
	<!-- End top menu home link -->
		
	<!--Display left side titles -->
	<div class="box language">
		<div id="contentLeft">
			<ul>

					<li id="recordsArray">
						<a href="<?php echo base_url('admin/settings/manage_report/manage_invoice'); ?>" class="get_link pb5">
							<?php echo $this->lang->line('admin_manage_invoice');?>
						</a>
					</li>
					
					<li id="recordsArray">
						<a href="<?php echo base_url('admin/settings/manage_report/sales_record'); ?>" class="get_link pb5">
							<?php echo $this->lang->line('admin_manage_sales_record');?>
						</a>
					</li>	
			</ul>
		</div>
	</div>
	<!--End display left side titles -->
		
	<!--Display description of title -->
	
</div>

<!--End cmslist of title -->
