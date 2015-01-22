
<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">
	<div class="row">
	<div class="title_bg col-sm-12 margin10">
			<div class="title_bg col-sm-12 margin10">
				<!--/TITTLE OF CREATE CONTENT/-->
				<div class="title padding_left0">Import Banner From CSV</div>
			</div>
		</div>
		 <!--/END OF TITTLE/-->
		
		 
		 <div class="row">
		 <?php echo form_open_multipart(uri_string(),'class="form-horizontal" role="form"'); ?>
		 
				<div class="form-group">
					<div class="col-sm-8">
						<label>Import Banner From CSV <span>*</span></label>
						<?php $file=array('name'=>'file_name','type'=>'file','value'=>'','required'=>'required');?>
						<?php echo form_input($file); ?>
						<span class="error"></span>
					</div>
				  </div>

			  	<div class="form-group">
					<div class="col-sm-8">
						Click here to<a href="<?php echo base_url().'merchant/getBannerCSV'; ?>"> Download CSV Sample File </a>
					</div>
				  </div>
				  
				  <div class="form-group">
				<input type="hidden" name="dd" id="dd" value="10">
				  <div class="col-sm-8">
					 <?php echo anchor('merchant/banner',lang('global:back'), 'class="btn btn-primary"');?> &nbsp;
						<button type="submit" class="btn btn-primary"> 
					 <i class="fa fa-plus-square fa-fw fa-1x"></i> 
					 <span>Save</span> 
					</button>
					</div>
				  </div>
			
			<?php echo form_close(); ?>
		 </div>
		 
	</div>
	
	
</div>
<!--/END OF PRODUCT BANNER CONTENT/-->  
<div class="clearfix"></div>
