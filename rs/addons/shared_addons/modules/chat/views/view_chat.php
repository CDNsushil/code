<?php $groupId=userGroup();?>
<div class="col-md-10 col-sm-9 content border_left">
<div class="title_bg col-sm-12 margin10">
<!--/TITTLE OF ABOUT CONTENT/-->
<div class="title padding_left0">View Feedback</div>
<!--/END OF  TITTLE/-->
</div>
<div class="clearfix"></div>
<form class="form-horizontal" role="form">
<div class="form-group">
	<div class="col-lg-12">
		<label>Title : <span class="color_com"><?php echo $feedback->title; ?></span></label>
	</div>
  </div>
  <div class="form-group">
	<div class="col-lg-12">
		<label>Description: <span class="color_com"><?php echo $feedback->description; ?></span></label>
		
	</div>
  </div>
  <div class="form-group">
	<div class="col-lg-12">
		<label>Merchant:  <span class="color_com"><?php echo ucfirst($feedback->first_name); ?></span></label>
	   
	</div>
  </div>
  <div class="form-group">
	<div class="col-lg-12">
		<label>Created On: <span class="color_com"><?php echo date('d M Y',strtotime($feedback->created_at)); ?></span></label>
		
	</div>
  </div>

  <div class="form-group">
	  	  <div class="col-sm-8">
	
			<button type="button" class="btn btn-primary" onClick="history.go(-1)"> 
				 <i class="fa fa-arrow-circle-left fa-fw fa-1x"></i> 
				 <span><?php echo lang('global:back'); ?></span> 
			</button>
			<?php if($groupId==3):?>
			<a href="<?php echo base_url().'merchant/removefeedback/'.$feedback->id; ?>" class="deleteConfirm">
				<button type="button" class="btn btn-primary"> 
				<span><?php echo lang('global:delete'); ?></span> 
				</button>
			</a>	
			<?php endif; ?>
		</div>
	</div>
</form>
<div class="clearfix"></div>
</div>
