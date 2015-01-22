<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form to add/edit configuration settings for merchant?>


<?php
	$userId=is_logged_in();
	 if(isset($sidebarOptions)): echo $sidebarOptions; endif;
?>

<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">
	<div class="row">
	<div class="title_bg col-sm-12 margin10">
			<div class="title_bg col-sm-12 margin10">
				<!--/TITTLE OF CREATE CONTENT/-->
				<div class="title padding_left0">General Configuration Settings</div>
			</div>
		</div>
		 <!--/END OF TITTLE/-->
		 
		 
		 <div class="row">
		 <?php echo form_open(uri_string(),'class="form-horizontal" role="form"'); ?>
			  <div class="form-group">
					<div class="col-sm-8">
						<label> <?php echo lang('merchant:paypal_id');?> <span>*</span></label>
							<?php echo form_input('paypal_id', $_config->paypal_id,'required class=""');?>		
					<span class="error"></span>
					</div>
				  </div>

				  <div class="form-group">
					<div class="col-sm-8">
						<label><?php echo lang('merchant:domain_name');?> <span>*</span></label>
						<?php echo form_input('domain_name', $_config->domain_name,'required class="valid_url"');?>
						<span class="error"></span>
					</div>
				  </div>
				

				  <div class="form-group ">
				
				  <div class="col-sm-8">
					
					<button type="submit" class="btn btn-primary"> 
						 <i class="fa fa-plus-square fa-fw fa-1x"></i> 
						 <span><?php echo lang('save_label'); ?></span> 
					</button>
					</div>
				  </div>
			
			<?php echo form_close(); ?>
		 </div>
		 
	</div>
	
	
</div>
<!--/END OF PRODUCT BANNER CONTENT/-->  
                        
