<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form to add/edit banner?>
<?php
	$userId=is_logged_in();
	$clickCount=(isset($banner_click) && !empty($banner_click))?$banner_click:'0';
	$shareCount=(isset($banner_share) && !empty($banner_share))?$banner_share:'0';
?>

<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">
	<div class="title_bg col-sm-12 margin10">
	<!--/TITTLE OF ABOUT CONTENT/-->
	<div class="title padding_left0"><?php if(isset($banner_heading)): echo $banner_heading; endif; ?></div>
	<!--/END OF  TITTLE/-->
	</div>
<div class="clearfix"></div>

<form class="form-horizontal" role="form">

	<div class="row">
		<div class="col-md-2"><label><?php echo lang('merchant:banner_name');?> :</label></div>
		<div class="col-md-9 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $_banner->banner_name;?></label></div>
	</div>
	
	<div class="row">
		<div class="col-md-2"><label><?php echo lang('merchant:description');?> :</label> </div>
		<div class="col-md-9 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $_banner->banner_description;?></label></div>
	</div>

	<div class="row">
		<div class="col-md-2"><label>Price :</label> </div>
		<div class="col-md-9 color_com" style="margin-left:10px;"><label class="color_com"><?php echo  $_banner->banner_price.' '.$_banner->currency_type;?></label></div>
	</div>
	
	<div class="row">
		<div class="col-md-2"><label><?php echo lang('merchant:image_url');?> :</label> </div>
			<?php $bannerImage= ($_banner->upload_type==0)?$_banner->image_url:base_url().$_banner->upload_path.$_banner->upload_image_name;?>
		
		<div class="col-md-9 color_com" style="margin-left:10px;"><label class="color_com word_break">	
			<a href="<?php echo $bannerImage; ?>" target="_blank"><?php echo  $bannerImage;?> </a>
			</label></div>
	</div>
	
	
	<div class="row">
			<?php
			$width=''; $height=''; 
			
			$imageSize=lang('merchant:original_image_size');
			if($_banner->image_type==0): $imageSize=lang('merchant:original_image_size'); $width='100%'; $height='100%'; endif;
			if( $_banner->image_type==1): $width='70px'; $height='70px';  $imageSize='Default Size (70*70)'; endif;
			
			if($_banner->image_type==2): 
				$width=$_banner->image_width; $height=$_banner->image_height;
				$imageSize=lang('merchant:own_size').' ('.$_banner->image_width.'*'.$_banner->image_height.')';
			endif;
		
			 
			//check file exists
			
			$fileCheck='/merchant/plupload/files/'.$_banner->upload_image_name;
			$fileExist=file_exists($fileCheck);
		?>
			
		<div class="col-md-2"><label <?php if($fileExist){ ?>class="floatL img_title" <?php }?>><?php echo 'Banner'; ?> : </label></div>
		
		<div class="col-sm-6 thum_img  ml25">
			<div class="row ">
				<img src="<?php echo $bannerImage; ?>" alt="No Image" width="<?php echo $width ?>" height="<?php echo $height ?>" class="">
			
		
			</div>
		
		</div>
		</div>
		
		<div class="row">
		<div class="col-md-2"><label></label> </div>
		
		<div class="col-md-9 color_com" style="margin-left:10px;">
			<label class="color_com img_size">	<?php echo  $imageSize;?></label>
			
		</div>
	
	<div class="row">
		<div class="col-md-2"><label><div class="copy_url"><?php echo 'Referral Button (Copy Code)'?> : </div></label> </div>
		
		<div class="col-md-9 " style="margin-left:10px;">
			<label class="color_com">	
						<?php $encodeID=isset($bannerEncodeID)?$bannerEncodeID:'';?>
						<?php $btnImgUrl=base_url().APPPATH.'themes/referral/img/reffer_btn.png';?>
						<?php $ref_commssion=(isset($refCommission) && !empty($refCommission))?$refCommission:'0'; ?>
						<textarea class="urlBtnCode" id="callback-paragraph" rows="10" ><a href="<?php echo base_url()."register/banner_id/".$encodeID;?>" style="color:#1ba3d6; text-decoration:underline; font-size:18px; padding:0 10px;"> <img src="<?php echo $btnImgUrl; ?>" alt="" /><div style="margin-left:19px;">Earn Up to <?php echo $ref_commssion['commission'].' '.$ref_commssion['currency']; ?></div></a></textarea>
						<a id="copy-callbacks" href="javascript:void(0)" class="btn copy_btn"><?php echo 'Copy' ?></a>
					
			</label>
					
					<div class=""><b class="note_row">Total Purchase: </b><span class="color_com note_row"><?php echo $_banner->purchaseCount; ?>,</span> <b class="note_row">Total Click:</b> <span class="color_com note_row"><?php echo $clickCount; ?>,</span> <b class="note_row">Total share:</b> <span class="color_com not_row"><?php echo $shareCount; ?></span>.</div>
					<div class="copy_msg"><?php echo lang('merchant:copy_msg'); ?></div>
			
			</div>
	</div>
	
	<div class="row">
		<div class="col-md-2"><label></label> </div>
		<div class="col-md-1 color_com" style="margin-left:10px;">
		<label class="color_com">	
				<button type="button" class="btn btn-primary" onclick="history.go(-1)"> 
				 <i class="fa fa-arrow-circle-left fa-fw fa-1x"></i> 
				 <span><?php echo lang('global:back');?></span> 
				</button>
				
		</label>
		</div>
	</div>
	

</form>
<div class="clearfix"></div>
</div>
<!--/END OF PRODUCT BANNER CONTENT/-->  
                      


<script type="text/javascript">
$(document).ready(function(){
    $("a#copy-callbacks").zclip({
        path:'<?php echo base_url('addons/shared_addons/modules/merchant/js/zclip/zeroClipboard.swf'); ?>',
        copy:$('#callback-paragraph').text(),
        beforeCopy:function(){
        },
        afterCopy:function(){	
			
			$('.copy_msg').fadeIn();
            $('.copy_msg').css('color','green');
            $('.copy_msg').fadeOut(8000);
        }
    });
	    $('.copy_msg').fadeOut();
});
</script>	
