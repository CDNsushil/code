<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form to show paypal details ?>
<?php
	$bannerId=isset($banner_id)?$banner_id:'';
	$uploadType=isset($banner_id)?$_banner->upload_type:'0';
	

?>

<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-12 col-sm-9 content">
	<div class="row">

			<div class="title_bg col-sm-12 margin10">
					<div class="title padding_left0"><?php echo  ucfirst($_banner->banner_name);?></div>
			   </div>
				<!--/TITTLE OF CREATE CONTENT/-->
				
		
		
		 <!--/END OF TITTLE/-->
	 <?php echo form_open('services/index','class="form-horizontal" role="form"'); ?>
		
		<?php if(isset($_banner) && !empty($_banner)):?>
			
		 <div class="col-md-12 content pd_lost">
                            	<div class="row margin10">
                                    <div class="col-sm-5 thum_img">
                                        <div class="row mt10">
											<?php $bannerImage= ($_banner->upload_type==0)?$_banner->image_url:base_url().$_banner->upload_path.$_banner->upload_image_name;?>
											<?php $width=''; $height=''; ?>
											<?php  if( $_banner->image_type==1): $width='70'; $height='70'; endif;?>
											<?php  if( $_banner->image_type==2): $width=$_banner->image_width; $height=$_banner->image_height; endif;?>
                                           
                                            <img src="<?php echo $bannerImage; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
                                        </div>
                                     
                                    </div>
                                    <!--/END OF COL-SM-6/-->
                                    
                                    <div class="col-sm-6">
									<div class="row">
										<div class=" col-sm-12 ">
										<div class="form-group">
											<div class="col-md-12 ">
												<div class="color_com bdr_blue width100per font_22 "><?php echo  ucfirst($_banner->banner_name);?></div>
											</div>
									   </div>
									  </div>
                                            <div class="padding15 price_box row clear ">  
                            	<div class="row">
									<div class="col-md-5"><label>Price :</label></div>
									<div class="col-md-7 color_com" ><label class="color_com">
										<span class="banner_price">
														<?php echo  $_banner->banner_price;?>
										</span>
										<?php echo  $_banner->currency_type;?>
									</label>
									</div>
								</div>
								<?php $bannerSize=isset($banner_size)?$banner_size:''; 
								 	if(!empty($bannerSize)):?>
							
								<div class="row">
									<div class="col-md-5"><label>Size :</label></div>
									<div class="col-md-7 color_com" ><label class="color_com">
										
										
											<select name="banner_price" id="banner_price" class="service_content">
												<option value="<?php echo  $_banner->banner_price;?>">Select Size</option>
										
											<?php foreach($bannerSize as $size): ?>
													<option value="<?php echo $size->price; ?>"><?php echo $size->option_name; ?></option>
												<?php endforeach;?>	
												
											</select>
													
									</label>
									</div>
								</div>
								<?php endif; ?>
								 <?php $bannerColor=isset($banner_color)?$banner_color:''; ?>
								 	<?php if(!empty($bannerColor)):?>
									<div class="row">
									<div class="col-md-5"><label>Color :</label></div>
									<div class="col-md-7 color_com" ><label class="color_com">
											
										
											<select name="banner_color" id="banner_color" class="service_content">
															<option value="">Default Color</option>
													
														<?php foreach($bannerColor as $color): ?>
																<option ><?php echo $color->option_name; ?></option>
															<?php endforeach;?>	
														
												</select>
													
									</label>
									</div>
								</div>
									<?php endif; ?>
								<?php if($_banner->change_order==1):?>
								<div class="row">
									<div class="col-md-5"><label>Product Quantity:</label></div>
									<div class="col-md-6 color_com" ><label class="color_com">
										<input type="text" name="product_quantity" id="product_quantity" value="1" class="service_content" >
										<span class="error"></span>
									</label>
									</div>
								</div>
								<?php endif; ?>
								
								<div class="row mt10 bdr_non">
									<div class="col-md-5"><label></label></div>
									<div class="col-md-7 color_com" >
										<label class="color_com">
										  <?php $decodeData=(isset($decode_data)?$decode_data:''); ?>
												<input type="hidden" name="decode_data" id="decode_data" value="<?php echo $decode_data ?>">
												 <input type="hidden" name="banner_size" id="banner_size" value="">
												 <input type="hidden" name="pay_banner_price" id="pay_banner_price" value="<?php  echo $_banner->banner_price;?>">
												<button type="submit" class="btn btn-primary btn-block width150"> 
											
												 <span>Buy Now</span> 
												
												</button>	
									</label>
									
									</div>
								</div>
								
								
								

                                        </div>
                                         <!--/END OF ROW/-->	
                                      <div class="col-md-12">
										<div class="pay_get_logo"></div>			
								</div>
                                    </div>
                                    <!--/END OF COL-SM-6/-->
                                </div>
                                <!--/END OF ROW/-->	
                            </div> 
		 
				<?php endif;?>
			<?php echo form_close(); ?>
		 
	</div>
	
</div>
</div>

<script>
	 $( document).ready(function() {
		
		$("#product_quantity").blur(function(e) {
			var value=$('#product_quantity').val();
		
			if(value==0)
			{
				$(this).next('span').fadeIn();
				$('#product_quantity').next('span').html('Quantity should be greater than 0.');
				formError=true;
				return false;
			}else{
				
				$(this).next('span').fadeOut(2000);
				formError=false;
				return true;
			}
		});
			$("#product_quantity").keypress(function(e) {
			
			if(((e.which!=43) && (e.which<48 || e.which>57 ) && (e.which!=8 && e.which!=0)))
			{
				$(this).next('span').fadeIn('fast');
				$(this).next('span').html('Please enter valid digit.');
				formError=true;
				return false;
			}	
			
		});
	});
	

</script>
