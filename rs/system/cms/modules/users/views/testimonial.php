<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form used to add review of users....?>		

<div class="col-md-12 col-sm-9 content">	
	<?php if(isset($testimonials) && !empty($testimonials)): ?>

	<?php foreach($testimonials as $testimonial): 

	 ?>
	<div class="col-md-6 clearfix">
			<!--/ARTICLE/-->
			<article class="testimonial_entry white">
				<div class="heading"><?php echo ucfirst($testimonial->title); ?> 
				<!--<div class="blog_img"><img src="<?php //echo $testimonial->image_path.'/'.$testimonial->image_name; ?>" width="30" height="30"></div> -->
			</div>

				<div  class="hide">
					<?php echo substr($testimonial->description,0,150); ?>
					</div>
				<div  class="show_testi">
					<?php echo $testimonial->description; ?>
				</div>
				<div class=""><?php echo 'Date : '; echo date('d M Y',strtotime($testimonial->created_at)); ?> </div>
				<?php if(strlen($testimonial->description)>150):?>
					<a class="testi_content" href="<?php echo base_url().'users/testimonial/view/'.encode($testimonial->testimonial_id);?>">Read More</a>        
				<?php endif; ?> 
					
				  <span class="testimonial_name"><a><?php echo ucfirst($testimonial->first_name); ?> </a></span>

			</article>
		</div>
		
	<?php endforeach; ?>
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
	<?php else:  ?>
		<div class="text_center"><?php echo lang('global:no_record_found'); ?></div>
	<?php endif;?>
</div>
