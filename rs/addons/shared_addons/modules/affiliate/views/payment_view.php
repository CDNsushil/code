<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form to add/edit banner?>
<?php
	$userId=is_logged_in();
?>

<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">
	<div class="title_bg col-sm-12 margin10">
		<div class="title padding_left0">View Payment Details</div>
	</div>
	
<div class="clearfix"></div>
<form class="form-horizontal" role="form">
			<div class="row">
				
			<div class="col-md-6 ">
				<div class="row img_box thum_img">
				<div class="inner_wrap">
					<?php $width=''; $height=''; ?>
						<?php  if( $_banner->image_type==1): $width='100%'; $height='100%'; endif;?>
					<?php  if( $_banner->image_type==2): $width=$_banner->image_width; $height=$_banner->image_height; endif;?>
					
					<?php $bannerImage= ($_banner->upload_type==0)?$_banner->image_url:base_url().$_banner->upload_path.$_banner->upload_image_name;?>
					<img src="<?php echo $bannerImage; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
			</div>
			</div>
			
			
			<!--/END OF FORM GROUP/-->
				 <div class="row margin10 marginb10">
					<div class="btn-group ">

					<button type="button" class="btn btn-primary" onclick="history.go(-1)"> 
						<i class="fa fa-arrow-circle-left fa-fw fa-1x"></i> 
						<span><?php echo lang('global:back');?></span> 
					</button>
				<?php 
					$diff =  strtotime(date('Y-m-d H:i:s'))-strtotime($_banner->order_time);
					$total_date_diff = round($diff/3600/24);
				?>
					
				<?php if($_banner->payment_status==="0"){
					
				}	
				else if($_banner->payment_status!=1){
					if($total_date_diff>30)
					{
						$extra = "id='payment_request' class='btn'";
					}
					else
					{
						$extra = "class='btn btn-default' title='You can request for payment after 30 days of product purchase!'";
					}	
					?>
					<button type="button" <?php echo $extra;?> data-toggle="tooltip" data-placement="left" name="button">Request For Payment</button>
					<input type="hidden" class="request_data" value='<?php echo json_encode($product);?>'>
				<?php }?>
					
				
				</div>
			 
			 </div>
			
			</div>
	
	</form>

			
<div class="col-md-6 product_text" >
			<div class="row fs18">
				<span><?php echo  ucfirst($_banner->banner_name);?></span></div>
					<div class="row">
						<span><?php echo  $_banner->banner_description;?></span>
					</div>
			
		   <div class="row">
				<label>Price:</label>
				<label class="color_com"><?php echo  $_banner->banner_price.' '.$_banner->currency_type;?></label>
				,
				<label>Quantity:</label>
				<span class="color_com"><?php echo  $_banner->banner_quantity;?></span>
			</div>
			
			 <div class="row">
				<label>Referral Commission:</label>
				<label class="color_com"><?php echo  $_banner->referral_commission;?></label>
				,
				<label>Referral Point:</label>
				<span class="color_com"><?php echo  $_banner->referral_point;?></span>
			</div>
			
			 <div class="row">
				<label>Status:</label>
				<?php $status=($_banner->payment_status=='1')?'Paid':'Pending';?>
				<label class="color_com"><?php echo  $status;?></label>
				<?php if($_banner->payment_status==1):?>
					,
					<label>Transation Id:</label>
					<span class="color_com"><?php echo  $_banner->txn_id;?></span>
				<?php endif; ?>
			</div>
			
			 <div class="row">
				<label>Request On:</label>
				
				<label class="color_com"><?php echo  date('d M Y', strtotime($_banner->created_at));?></label>
				<?php if($_banner->payment_status==1):?>
					,
					<label>Payment On:</label>
					<span class="color_com"><?php echo  date('d M Y', strtotime($_banner->transaction_date));?></span>
				<?php endif; ?>
			</div>
				
				<div class="row margin10">
				<?php 
					$refConfig=(isset($config) && !empty($config))?$config->referral_point_amt.' '.$config->currency:'0';
					
				 ?>
				<b>*Note : </b>   <span class="color_com"> 1 Referral Point =  <?php echo $refConfig;?> </span>.
			</div>
			
			
			
	
		 <!--/END OF ROW/-->	
	
	</div>
	<!--/END OF COL-SM-6/-->	

<!--/END OF ROW/-->	
</div>




