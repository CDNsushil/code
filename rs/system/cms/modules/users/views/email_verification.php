<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form used to add review of users....?>		


	<!--/ROW FOR SIDE BAR CONTENTS/-->
	<div class="row">
				<!--/CONTENT OF PRODUCT BANNER/-->

					<div class="title_bg col-sm-12 margin10">
						<!--/TITTLE OF ABOUT CONTENT/-->
						<div class="title">Account-Verification</div>
						<!--/END OF  TITTLE/-->
					</div>
					<div class="clearfix"></div>
				 
							<?php echo form_open(uri_string(),'calss="form-horizontal" role="form"'); ?>
						<div class="form-group">
							<div class="col-lg-12">
								<label><?php echo lang('user:activation_code') ?><span>*</span></label>
								<span class="color_com">	<?php echo form_input('activation_code','','required placeholder="Enter Code" class="width300"')?></span></label>
								
							</div>
					
					   <div class="form-group">
						<div class="col-lg-12">
								   <br>
								   <?php  echo form_submit('save','Save','class="btn btn-primary"');?>
								</div>
						  </div>
			  <?php echo form_close();?>

			   
	</div>

	
