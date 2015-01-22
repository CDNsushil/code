<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form used to add f of users....?>		
	 

<div class="col-md-10 col-sm-9 content border_left">
	 <?php 	if(isset($testimonials) && !empty($testimonials)):?>
	<div class="title_bg col-sm-12 margin10">
		<div class="title padding_left0">Feedback To Affiliates</div>
		
	</div>
	<?php endif;?>
	<div class="clearfix"></div>
	<div class="row">
		<section class="testimonial_wrap clearfix">
			<?php  if(isset($testimonials) && !empty($testimonials)):?>
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
							<div class=""><?php echo 'Date : '; echo date('d M Y',strtotime($testi->created_at)); ?> </div>
						<?php 
						if(isset($affiliates)){ foreach($affiliates as $affiliate){
								if($affiliate->affiliate_id==$testi->affiliate_id){
									?>
									<span class="">
										<a><?php echo $affiliate->first_name.' '.$affiliate->last_name; ?></a> 
									</span>
									
									<?php
									break;
								}
							}
						}
						?>
						<div class="testi_content">
						<?php if(strlen($testi->description)>150): ?>
					
							<a  href="<?php echo base_url().'merchant/feedback/view/'.encode($testi->id); ?>">Read More</a> |
						</a>	       
						<?php endif; ?> 
						<a href="<?php echo base_url().'merchant/removefeedback/'.$testi->id; ?>" class="remove_testi deleteConfirm">Delete</a>	
						
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

		
		<div class="clearfix"></div>
		
		
		<div class="title_bg col-sm-12 margin10">
		<div class="title padding_left0">Add Testmonials</div>

		</div>
		<div class="clearfix"></div>
		
		<div class="row dark">

			<?php echo form_open(uri_string()); ?>
			
		
				<div class="col-md-12">
					<div class="form-group">
						<label for="full_topic">Select Affiliate<span>*</span></label>
						<?php  $other='class="" id="" required';
								$affiliateList=array(''=>'Please select affiliate');
								if(isset($affiliates)){ foreach($affiliates as $affiliate){  $affiliateList[$affiliate->affiliate_id]=$affiliate->first_name; }}
							
								echo form_dropdown('affiliate_id',$affiliateList, $_testimonial->affiliate_id, $other); ?>
						<span class="error"></span>
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="form-group">
						<label><?php echo lang('global:title') ?><span>*</span></label>
						<?php echo form_input('title',$_testimonial->title,'required ')?>
					</div>
				</div>
				
				
				<div class="col-md-12">
					<div class="form-group">
						
						<label for="description"><?php echo lang('global:your_feedback') ?><span>*</span></label>
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
		</div>
	</div>
	<!--/END OF ROW/-->  
</div>
<!--/END OF TESTIMONIALS CONTENT/-->  




