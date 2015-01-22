<?php defined('BASEPATH') OR exit('No direct script access allowed'); //this form used to view profile details?>
<?php
	$group=userGroup();
	 $groupName = ($group==2)?lang('global:affiliate'):lang('global:merchant'); 
	 
	
?>

<?php $membershipId=''; ?>
<!-- Container for the user's profile -->



	<!--/CONTENT OF PRODUCT BANNER/-->
	<div class="col-md-10 col-sm-9 content border_left">
		<div class="title_bg col-sm-12 margin10">
			<!--/TITTLE OF ABOUT CONTENT/-->
			<div class="title padding_left0">My Profile</div>
			<!--/END OF  TITTLE/-->
		</div>
		<div class="clearfix"></div>
	   <form class="form-horizontal" role="form">
		   
		   <?php if(isset($_user) && !empty($_user)): ?>
		   
		   <div class="row">
				<div class="col-md-3"><label><?php echo lang('user:first_name');?>:</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $_user->first_name;?></label></div>
			</div>
			
			<div class="row">
				<div class="col-md-3"><label><?php echo lang('user:last_name');?>:</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $_user->last_name;?></label></div>
			</div>
			
			<div class="row">
				<div class="col-md-3"><label><?php echo lang('user:email');?>:</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $_user->email;?></label></div>
			</div>
			
			<div class="row">
				<div class="col-md-3"><label><?php echo lang('user:phone');?>:</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $_user->phone;?></label></div>
			</div>
			
					
			<div class="row">
				<div class="col-md-3"><label><?php echo lang('user:sex');?>:</label></div>
					<?php $gender=($_user->sex==1)?'Female':'Male'; ?>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $gender;?></label></div>
			</div>
			
			<div class="row">
				<div class="col-md-3"><label><?php echo lang('user:date_of_birth');?>:</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  date('d M Y',strtotime($_user->date_of_birth));?></label></div>
			</div>
			
			<div class="row">
				<div class="col-md-3"><label><?php echo lang('user:address');?>:</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $_user->address;?></label></div>
			</div>
			
			
			<div class="row">
				<div class="col-md-3"><label>Created On :</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo date('d M Y', $_user->created_on);?></label></div>
			</div>
			
			<div class="row">
				<div class="col-md-3"><label><?php echo lang('user:regis_type');?> : </label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo $groupName;?></label></div>
			</div>
			
			<div class="row">
				<div class="col-md-3"><label>company :</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $_user->company;?></label></div>
			</div>
			
			<div class="row">
				<div class="col-md-3"><label><?php echo lang('user:website_address');?>:</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $_user->domain_name;?></label></div>
			</div>
			
			<div class="row mt10">
				<div class="col-md-3"><label> <?php echo anchor('users/my-profile/edit','Edit Profile', 'class="btn"');?></label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"></label></div>
			</div>
		 
		   <?php endif; ?>
		  </form>
		 </div>
		
		


