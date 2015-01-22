<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form used to add banners by ajax....?>		

	<?php if(isset($sales) && !empty($sales)): ?>
	
	<?php $class="even"; 
		foreach($sales as $sale):?>
		
		   <tr role="row" class="<?php echo $class; ?>">
				<td>
					<?php $bannerImage= ($sale->upload_type==0)?$sale->image_url:base_url().$sale->upload_path.$sale->upload_image_name;?>
					<a href="<?php echo base_url().'merchant/banner/view/'.encode($sale->banner_id) ;?>" > 
						<img src="<?php echo $bannerImage;?>" width="50" height="30" >
					</a>
				</td>
				<td>
					<?php echo $sale->banner_name; ?>
				</td>
				<td><?php echo $sale->amount; ?> <?php echo $sale->currency; ?></td>
				
				<td><?php echo $sale->banner_quantity; ?></td>
				<td><?php echo $sale->first_name; ?></td>
				<td><?php echo date('d M Y', strtotime($sale->order_time)); ?></td>
				<td>
				   <div class="btn-group table_buttons">
				
					<a href="<?php echo base_url().'merchant/banner/view/'.encode($sale->banner_id) ;?>" > 

					  <button type="button" class="btn btn-default btn-success">
						<i class="fa fa-eye fa-fw fa-1x"></i>
					  </button>
					 </a>
				
					</div>
				</td>
			</tr>
		
	<?php endforeach;?>

	<?php else :  ?>		
		<tr><td colspan="6"><?php echo lang('global:no_record_found');?></td>
	<?php endif; ?>	
