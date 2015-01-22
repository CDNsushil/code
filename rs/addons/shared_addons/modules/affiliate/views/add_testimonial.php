<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form used to add f of users....?>		

				 
<!--/CONTENT OF TESTIMONIALS/-->
<div class="col-md-10 col-sm-9 content border_left">
		 <?php 	if(isset($testimonials) && !empty($testimonials)):?>
	<div class="title_bg col-sm-12 margin10">
		<!--/TITTLE OF TESTIMONIALS/-->

		<div class="title padding_left0">Affiliate Testimonials</div>
	
		<!--/END OF TESTIMONIALS/-->
	</div>
		<?php endif;?>
	<div class="clearfix"></div>
	<div class="row">
		<section class="testimonial_wrap clearfix">
			<?php if(isset($testimonials) && !empty($testimonials)):?>
			<?php foreach($testimonials as $testi): ?>
				<div class="col-md-6 clearfix">
					<!--/ARTICLE/-->
					<article class="testimonial_entry white">
						<div class="heading"><?php echo ucfirst($testi->title); ?></div>
						<div  class="hide">
							
							<?php echo substr($testi->description,0,150); ?>
							</div>
						<div  class="show_testi">
							<?php echo $testi->description; ?>
						</div>
						<?php if(strlen($testi->description)>150):?>
							<a class="testi_content" href="<?php echo base_url().'affiliate/testimonial/view/'.encode($testi->id); ?>">Read More</a>        
						<?php endif; ?> 
							<div class=""><?php echo 'Date : '; echo date('d M Y',strtotime($testi->created_at)); ?> </div>
						  <span class="testimonial_name"><a><?php //echo ucfirst($testi->first_name); ?> </a></span>

					</article>
				</div>
			<?php endforeach;?>
			<!-- code for pagination -->
			 <table class="border_none">
			<tr class="">
					<td colspan="7" class="border_none">
					<div class="col-md-6 ShowingEntries">
						<div class="dataTables_info" id="example_info" role="status" aria-live="polite">  </div>
						</div>
						<div class="col-md-6 Paginations">
							<div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
														
						<?php if(isset($links)) : echo $links; endif; ?>								
						</div>
					</div>
					</td>
				</tr>
			</table>
			<?php endif;?>
		
		</section>
		<!--/END OF TESTIMONIALS WRAP & ROW/-->
		
		<div class="clearfix"></div>
		
		
		<div class="title_bg col-sm-12 margin10">
		<!--/TITTLE OF TESTIMONIALS FORM/-->
		<div class="title padding_left0">Add Testmonials</div>
		<!--/END TITTLE OF TESTIMONIALS FORM/-->
		</div>
		<div class="clearfix"></div>
		
		<div class="row dark">
			<!--/TESTIMONIALS FORM CONTENT/-->
			<?php echo form_open_multipart(uri_string()); ?>
	
				<div class="col-md-12">
					<div class="form-group">
						<label><?php echo lang('global:title') ?><span>*</span></label>
						<?php echo form_input('title',$_testimonial->title,'required ')?>
					</div>
				</div>
	
				<div class="col-md-12">
					<div class="form-group">
						
						<label for="description"><?php echo lang('global:description') ?><span>*</span></label>
							<?php echo form_textarea('description',$_testimonial->description,'required')?>
						<span class="error"></span>
					</div>
				</div>
				<div class="col-md-12 marginb10">
				<div class="form-group">
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-check-circle fa-fw fa-1x"></i> <span>Post</span> 
					</button>
				</div>
			   </div>
			<?php echo form_close();?>
			<!--/END OF TESTIMONIALS FORM CONTENT/-->
		</div>
	
	</div>
	<!--/END OF ROW/-->  
</div>
<!--/END OF TESTIMONIALS CONTENT/-->  


