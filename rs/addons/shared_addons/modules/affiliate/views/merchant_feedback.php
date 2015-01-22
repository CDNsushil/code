				 
<!--/CONTENT OF TESTIMONIALS/-->
<div class="col-md-10 col-sm-9 content border_left">
	 <?php 	if(isset($testimonials) && !empty($testimonials)):?>
	<div class="title_bg col-sm-12 margin10">
		<!--/TITTLE OF TESTIMONIALS/-->
		
		<div class="title padding_left0">Merchant Feedbacks</div>
		
		<!--/END OF TESTIMONIALS/-->
	</div>
	<?php endif;?>
	<div class="clearfix"></div>
	<div class="row">
		<section class="testimonial_wrap clearfix">
			<?php  if(isset($feedbacks) && !empty($feedbacks)):?>
			<?php foreach($feedbacks as $feedback): ?>
				<div class="col-md-6 clearfix">
					<!--/ARTICLE/-->
					<article class="testimonial_entry white">
						<div class="heading"><?php echo ucfirst($feedback->title); ?></div>
						<div  class="hide">
								
						<?php echo substr($feedback->description,0,150); ?>
							</div>
						<div  class="show_testi">
							<?php echo $feedback->description; ?>
						</div>
						
						<span class="">
							
							<div class=""><?php echo 'Date : '; echo date('d M Y',strtotime($feedback->created_at)); ?> </div>
							<a><?php echo ucfirst($feedback->first_name); ?></a> 
						</span>
	
						<?php if(strlen($feedback->description)>150): ?>
						<div class="testi_content">
							<a  href="<?php echo base_url().'affiliate/feedback/view/'.encode($feedback->id); ?>">Read More</a>
						</a>	 
						     
						<?php endif; ?> 
						
					</article>
				</div>
				
			<?php endforeach;?>
			<?php else:?><div class="text_center"><?php echo lang('affiliate:no_feedback_found'); ?></div>  
			<?php endif;?>
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
	
		</section>
		<!--/END OF TESTIMONIALS WRAP & ROW/-->

	</div>
	<!--/END OF ROW/-->  
</div>
<!--/END OF TESTIMONIALS CONTENT/-->  




