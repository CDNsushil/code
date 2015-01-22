<?php  defined('BASEPATH') or exit('No direct script access allowed');   ?>


<?php
	$membershipDay='30';
	$membership_id = (isset($membershipId) && !empty($membershipId))?$membershipId:'';
	$mPrice = (isset($m_price) && !empty($m_price))?$m_price:'';


	$membershipName='';
	if(isset($memberships) && !empty($memberships)){
		foreach($memberships as $mebership){
		  if($mebership->id==$membership_id){
			 $membershipName=$mebership->membership_title;
			 $membershipDay=$mebership->membership_days;
		  }
		}
	}
?>
<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">
<div class="title_bg col-sm-12 margin10">
	<!--/TITTLE OF ABOUT CONTENT/-->
	<div class="title padding_left0">Upgrade Membeship Package</div>
	<!--/END OF  TITTLE/-->
</div>
<div class="clearfix"></div>

<?php echo form_open(base_url().'users/setPaypalPayment/'.$membership_id, 'class="crud form-horizontal" id="membership_type_form"  role="form"') ?>
   
	
<div class="widget">     
		
	<h4> <div class="feature_head heading">
		
			<div class="floatL ">
				Membership for <?php echo $membershipDay; ?> days
		</div>
		 <div class="paypal_logo">
			 <img src="<?php echo base_url().'system/cms/themes/referral/img//PaymentGateway.jpg'?>" alt="" class="center-block">
			</div>
	</div>
		<div class="clearfix"></div>
			<div class="floatL feature_head heading  clearfix mt10">
				<?php echo $membershipName; ?> <?php if($mPrice!=0){ echo '($'.$mPrice.')'; }?>
			</div>
	
		
	</h4>

	<div class="clearfix"></div>
		<h4> <div class="feature_head heading clearfix">Features :</h4>


	<div class="feature_data ">
		
	<ul class="plan_list">
	  <?php $amt=0; if(isset($features) && !empty($features)): ?>
		<?php foreach($features as $feature): $amt=$feature->membership_price; ?>
			
			<li class="feature_disc">
				<label for="first_name"><?php echo ucfirst($feature->feature_title); ?>  </label>
			</li>
			<div class="hide"><?php echo $feature->feature_description; ?></div>
		 <?php endforeach; ?>
	 <?php endIf; ?>
	</ul>
	</div>
</div>
   
	   
			


  <div class="form-group">
		  <div class="col-sm-8">
			<button type="button" class="btn btn-primary" onclick="history.go(-1)"> 
			 <i class="fa fa-arrow-circle-left fa-fw fa-1x"></i> 
			 <span><?php echo lang('global:back');?></span> 
			</button>
			&nbsp;
			<button type="submit" class="btn btn-primary"> 
		 
			 <span> Continue to Checkout</span> 
			</button>
			</div>
	</div>
<?php form_close(); ?>
</div>
	
<script>
$( document).ready(function() {
	$(document).on('click','.feature_disc', function() {
	  $(this).next('div').slideToggle( "slow");
	});
});
</script>
