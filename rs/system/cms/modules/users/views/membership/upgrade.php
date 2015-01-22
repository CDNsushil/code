<?php defined('BASEPATH') OR exit('No direct script access allowed'); //this form used to view profile details?>
<?php
	$membershipId=''; 	
	$expiryClass=(isset($daysDiff) && count($daysDiff)<=15)?'expiryClass':'';
	
 ?>


<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">
<div class="title_bg col-sm-12 margin10">
	<!--/TITTLE OF ABOUT CONTENT/-->
	<div class="title padding_left0"><?php echo 'Membership'; ?></div>
	<!--/END OF  TITTLE/-->
</div>
<div class="clearfix"></div>
<form class="form-horizontal" role="form">

<?php if(isset($_user) && !empty($_user)): ?>
<?php if(isset($userMembership) && !empty($userMembership)): $price=0; ?>
		
	

		 <div class="row">
				<div class="col-md-3"><label><?php echo lang('user:membership_type');?>:</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $userMembership->membership_title;?></label></div>
			</div>
			
			<div class="row">
				<div class="col-md-3"><label><?php echo lang('user:membership_start_from');?>:</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;"><label class="color_com"><?php echo date('d M Y',strtotime($_user->membership_date)); ?></label></div>
			</div>
		
		 <div class="row">
				<div class="col-md-3"><label><?php echo lang('user:membership_expire_on');?>:</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;">
					<label class="color_com "> 
						<?php echo  date('d M Y',strtotime($_user->membership_expiry_date));?> 
						<?php if($expiryClass!=''): ?>
							<span class="<?php echo $expiryClass; ?>"> Please upgrade your membership.</span>
							<?php endif; ?>
						</label>
					</div>
			</div>
			

	
		<?php 
		if(isset($userMembership) && $userMembership->membership_price>0):
		
		?>
		<?php if(isset($daysDiff) && count($daysDiff)<=15): ?>
		 <div class="row">
				<div class="col-md-3"><label><?php echo lang('user:renew_your_membership');?>:</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;">
					<label class="color_com"> 
						
							 <?php  echo anchor('users/membership/view/'.encode($userMembership->id), lang('user:renew'), 'class="btn" title="Renew your membership"');?> </td>

						</label></div>
			</div>
		<?php endif;?>	
		<?php endif;?>
		
		 <div class="row upgrade_row">
				<div class="col-md-3"><label><?php echo "Upgrade Your Membership"; ?> :</label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;">
					<label class="color_com"> 
					<?php  $count=0; foreach($memberships as $membership):  $checked=''; ?>
							<?php if($membership->membership_price>$price && $_user->membership_type!=$membership->id): 
									if($count==0){ $checked='checked'; $count='1'; $membershipId=$membership->id; } 
									$membershipType=array(
										'name'	=> 'membership_type',
										'id'	=> '',
										'checked'=> $checked,
										'value'=> $membership->id,
										'class'=>'membership_type'
									);
							?>
									<?php echo form_radio($membershipType);?>  <?php echo $membership->membership_title; ?></b>
									
								<?php  endIf; ?>
							<?php endforeach;?>
						</label></div>
			</div>

	<?php endIf; ?>
<?php endIf; ?>


 <div class="row upgrade_row">
				<div class="col-md-3"><label></label></div>
				<div class="col-md-7 color_com" style="margin-left:10px;">
					<label class="color_com"> 
						<?php echo anchor('users/membership/view/'.encode($membershipId),'Upgrade Membership', 'class="btn upgrade_btn" title="Upgrade your membership"');?>

						</label></div>
			</div>

</form>                       
 <div class="clearfix"></div>
</div>
<!--/END OF PRODUCT BANNER CONTENT/-->  
	

<script>
	var mcount='<?php echo $count; ?>';
	
	var base_url='<?php echo base_url();?>';
	if(mcount==0)
	{
		$('.upgrade_row').addClass('hide');
	}
	$('.membership_type').click(function(){
		var id=$(this).val();
		 $(".upgrade_btn").attr("href",base_url+"membership/packageview/"+id);
	});
</script>
