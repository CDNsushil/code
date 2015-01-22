<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form to  banners ?>
<?php
	$userId=is_logged_in();

?>

<div class="col-md-10 col-sm-9 content border_left pd_lost">

	<!--/ROW FOR PRODUCTS CONTENTS/-->
<div class="row">
	<?php if(isset($banners) && !empty($banners)): ?>
			<?php foreach($banners as $banner): ?>
		<div class="col-sm-4">
			<article class="album">
			<header>
				
					<a href="<?php echo base_url().'affiliate/banners/view/'.encode($banner->banner_id); ?>">
						<div class="row img_box ">
						<div class="inner_wrap">
							<?php $width=''; $height=''; ?>
							<?php  if($banner->image_type==1): $width='70px'; $height='70px'; endif;?>
							<?php  if($banner->image_type==2): $width=$banner->image_width; $height=$banner->image_height; endif;?>
							<?php $bannerImage= ($banner->upload_type==0)?$banner->image_url:$banner->upload_path.$banner->upload_image_name;?>
							<img src="<?php echo $bannerImage; ?>" height="<?php echo $height;?>" width="<?php echo $width;?>" >
						</div>
					</div>
							
						</a>																
			
			
			</header>
			<!--/END OF HEADER/-->
			<section class="album_info">
				<h3><a href="<?php echo base_url().'affiliate/banners/view/'.encode($banner->banner_id); ?>"><?php echo $banner->banner_name; ?></a></h3>
				
			</section>
			 <!--/END OF SECTION/-->
		</article>
	  </div>
	  <!--/END OF COL-SM-4/-->
	  	<?php endforeach; ?>
	  	<?php else: ?><div class="text_center"><?php echo lang('affiliate:no_banner_found');?></div> 
		<?php endif; ?>

	</div>
	<!--/END OF ROW/-->


</div>
