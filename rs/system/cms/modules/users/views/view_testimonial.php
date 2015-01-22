<?php $groupId=userGroup();?>


<div class="col-md-12 col-sm-9 content ">
<div class="title_bg col-sm-12 margin10">
<!--/TITTLE OF ABOUT CONTENT/-->
<div class="title padding_left0">View Testimonial</div>
<!--/END OF  TITTLE/-->
</div>
<div class="clearfix"></div>


	<div class="col-md-12 col-sm-9 content">	


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
					<div class="mt10">
						<div class="	">Posted By : <a><?php  echo ucfirst($testimonial->first_name); ?> </a></div>
						<?php  echo date('d M Y',strtotime($testimonial->created_at)); ?> 
				
					  </div>
					 

				</article>
					<div class="row">
				
							<label class="color_com">
										<button type="button" class="btn btn-primary" onClick="history.go(-1)"> 
											 <i class="fa fa-arrow-circle-left fa-fw fa-1x"></i> 
											 <span><?php echo lang('global:back'); ?></span> 
										</button>
								</label></div>
						</div>
		
			
		
	</div>

</div>
