<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form used to add banners by ajax....?>		
<?php if(isset($banners) && !empty($banners)):?>
	
	<?php $class="even"; 
		foreach($banners as $banner):?>
	<?php
		
		$imageSize=lang('merchant:original_image_size');
		if($banner->image_type==1): $imageSize=lang('merchant:default_image_size'); endif;
		if($banner->image_type==2): $imageSize=lang('merchant:own_size').' ('.$banner->image_width.'*'.$banner->image_height.')'; endif;
		if($class=='even'): $class='odd'; else: 'even'; endif;
	?>
		
		   <tr role="row" class="<?php echo $class; ?>">
				<td class="text-center pd_lost valign sorting_1">
					<?php echo form_checkbox('select_banner[]',$banner->banner_id,'','class="check_banner check_option lost_margin"'); ?>
				</td>
				
				<td>
					<?php $bannerImage= ($banner->upload_type==0)?$banner->image_url:$banner->upload_path.$banner->upload_image_name;?>
					<a href="<?php echo base_url().'merchant/banner/view/'.encode($banner->banner_id) ;?>" > 
						<img src="<?php echo $bannerImage; ?>" width="50px" height="30px">
					</a>
				</td>
				<td><?php echo $banner->banner_name; ?></td>
				<td><?php echo $banner->purchaseCount; ?></td>
				<td>
					<?php 
							if(!empty($bannerClick)){
								if(array_key_exists($banner->banner_id,$bannerClick)){
									echo $bannerClick[$banner->banner_id];
								}
							}
					 ?>
				</td>
				<td>
					<?php 
							if(!empty($bannerShare)){
								if(array_key_exists($banner->banner_id,$bannerShare)){
									echo $bannerShare[$banner->banner_id];
								}
							}
					 ?>
				</td>
				<td>
				   <div class="btn-group table_buttons">
					  <a href="<?php echo base_url().'merchant/banner/edit/'.encode($banner->banner_id) ;?>" > 
						  <button type="button" class="btn btn-default btn-success">
							<i class="fa fa-pencil fa-fw fa-1x"></i>
						  </button>
					  </a>
					<a href="<?php echo base_url().'merchant/banner/view/'.encode($banner->banner_id) ;?>" > 

					  <button type="button" class="btn btn-default btn-success">
						<i class="fa fa-eye fa-fw fa-1x"></i>
					  </button>
					 </a>
					 <a href="<?php echo base_url().'merchant/deletebanner/'.$banner->banner_id ;?>" class="deleteConfirm"> 

					  <button type="button" class="btn btn-default btn-danger">
						<i class="fa fa-trash fa-fw fa-1x"></i>
					  </button>
					  </a>
					</div>
				</td>
			</tr>
		
	<?php endforeach;?>

	<?php else :  ?>		
		<tr><td colspan="5"><?php echo lang('global:no_record_found');?></td>
	<?php
	endif;
	
?>
