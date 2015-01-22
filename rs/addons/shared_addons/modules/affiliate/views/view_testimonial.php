<?php $groupId=userGroup();?>
<div class="col-md-10 col-sm-9 content border_left">
<div class="title_bg col-sm-12 margin10">
<!--/TITTLE OF ABOUT CONTENT/-->
<div class="title padding_left0">View Testimonial</div>
<!--/END OF  TITTLE/-->
</div>
<div class="clearfix"></div>
<form class="form-horizontal" role="form">
	
	 <div class="row">
				<div class="col-md-2"><label><?php echo lang('global:title');?>:</label></div>
				<div class="col-md-9 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $testimonial->title;?></label></div>
		</div>
	
	
		
		 <div class="row">
				<div class="col-md-2"><label><?php echo lang('global:affiliate');?>:</label></div>
				<div class="col-md-9 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $testimonial->first_name;?></label></div>
		</div>
  
	 <div class="row">
				<div class="col-md-2"><label>Created On:</label></div>
				<div class="col-md-9 color_com" style="margin-left:10px;"><label class="color_com"><?php echo date('d M Y',strtotime($testimonial->created_at)); ?></label></div>
		</div>
		
		 <div class="row">
				<div class="col-md-2"><label><?php echo lang('global:description');?>:</label></div>
				<div class="col-md-9 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $testimonial->description;?></label></div>
		</div>
		
		<div class="row">
				<div class="col-md-2"><label></label></div>
				<div class="col-md-8 color_com" style="margin-left:10px;">
					<label class="color_com">
								<button type="button" class="btn btn-primary" onClick="history.go(-1)"> 
									 <i class="fa fa-arrow-circle-left fa-fw fa-1x"></i> 
									 <span><?php echo lang('global:back'); ?></span> 
								</button>
						</label></div>
		</div>
		


</form>

</div>
