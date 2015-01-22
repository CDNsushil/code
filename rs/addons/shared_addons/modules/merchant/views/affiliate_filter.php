<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if(isset($purchases) && !empty($purchases)):?>
<?php $class="even"; 
	foreach($purchases as $purchase):?>
	
	   <tr role="row" class="<?php echo $class; ?>">
			
			<td>
				<?php $bannerImage= ($purchase->upload_type==0)?$purchase->image_url:base_url().$purchase->upload_path.$purchase->upload_image_name;?>
			
				<a href="<?php echo base_url().'merchant/banner/view/'.encode($purchase->banner_id);?>">
					<img src="<?php echo $bannerImage; ?>" alt="No Image" width="50" height="30" class="">
				</a>
			
			</td>
			<td><?php echo $purchase->first_name; ?></td>
			<td><?php echo $purchase->banner_name; ?></td>
			<td><?php echo $purchase->banner_quantity; ?></td>
			<td><?php echo $purchase->amount; ?> <?php echo $purchase->currency; ?></td>
			<td><?php echo $purchase->referral_commission; ?> <?php echo $purchase->currency; ?></td>
			<td>
			   <div class="btn-group table_buttons">
			
				<a href="<?php echo base_url().'merchant/banner/view/'.encode($purchase->banner_id) ;?>" > 

				  <button type="button" class="btn btn-default btn-success">
					<i class="fa fa-eye fa-fw fa-1x"></i>
				  </button>
				 </a>
				
				</div>
			</td>
		</tr>
	
<?php endforeach;?>

<?php else :  ?>		
	<tr><td colspan="5"><?php echo lang('global:no_record_found');?></td>
<?php endif; ?>	
