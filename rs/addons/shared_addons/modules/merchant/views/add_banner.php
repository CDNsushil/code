<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form to add/edit banner?>
<?php
	$bannerId=isset($banner_id)?$banner_id:'';
	$uploadType=isset($banner_id)?$_banner->upload_type:'0';
	$imageType=isset($banner_id)?$_banner->image_type:'0';
	 $defaultReferralPoint=(isset($referral_point)?$referral_point:'5');

	$userId=is_logged_in();
	$colorCount='1';
	$sizeCount='1';
?>

<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">
	<div class="row">
	<div class="title_bg col-sm-12 margin10">
			<div class="title_bg col-sm-12 margin10">
				<!--/TITTLE OF CREATE CONTENT/-->
				<div class="title padding_left0">General Banner Information</div>
			</div>
		</div>
		 <!--/END OF TITTLE/-->
		 
		 
		 <div class="row">
		 <?php echo form_open_multipart(uri_string(),'class="form-horizontal" role="form"'); ?>
				
					<div class="form-group">
					<div class="col-sm-8">
						<label class="floatL">Item Name <span>*</span></label>
						<label class="item_title">ItemID <span>*</span></label>
						<?php echo form_input('banner_name', $_banner->banner_name,'required class="alpha_num width300" placeholder="Item Name"');?>
						<span class="error"></span>
						<?php echo form_input('item_id', $_banner->item_id ,'required class=" itemIdField" placeholder="Item Id"');?>
						<span class="error"></span>
					</div>
				  </div>
				  	<div class="form-group">
				  	<div class="col-sm-8">
						<label class="floatL">Price <span>*</span></label>
						<label class="item_title">Currency <span>*</span></label>
						<?php echo form_input('banner_price', $_banner->banner_price,'required class="validPrice width300" placeholder="Price" maxlength="20"');?>
						<span class="error "></span>
						<?php echo form_dropdown('currency_type',$currencies,$_banner->currency_type,'required class="itemIdField currency_type" placeholder="Currency"');?>
						<span class="error"></span>
					</div>
				  </div>
				  
				 
				  	<div class="form-group">
				  	<div class="col-sm-8">
						<?php
							 
							$customisecolor=(isset($options)? $options->customise_color:'');
						
						?>
						<?php echo form_checkbox('color_option','','','class="floatL color_option" id="color_option"');?> <label > &nbsp; Add drop-down menu with price option </label>
						
						<div class="customise_content">
							<?php echo form_input('customisecolor',$customisecolor,'class="colorField" placeholder="Product Size"');?>
							<div class="customise_inner_wrap">
							<div class="mt10">
								<label class="floatL width300">Menu option name</label> 
								<label class="customise_price_title">Price</label> 
								<label class="customise_currency_title">Currency</label>
							</div>
							<?php 
								$count=0;
								if(isset($optionDetails) && !empty($optionDetails)){
									
									foreach($optionDetails as $optionData){
										if($optionData->option_type==0){
											$count+=1;
										?>
											<div class="customise_color_div">
												<?php echo form_input('customise_color[]',$optionData->option_name,' class="width300 colorField" placeholder="Option1" required');?>
												<?php echo form_input('customise_price[]',$optionData->price,' class="width140 m10 validPrice colorField" placeholder="" required');?>
												<span class="error color_error"></span>
												<span class="customise_currency curOption"><?php if($_banner->currency_type==''){ echo "USD"; }else{ echo $_banner->currency_type; }?></span> 
											</div>
										<?php
										}
									}
									
							} 
							$colorCount=$count;
							if($colorCount==0 || $bannerId==''){
							?>
								<div class="customise_color_div">
										<?php echo form_input('customise_color[]','',' class="width300 colorField" placeholder="Option1"');?>
										
										<?php echo form_input('customise_price[]','',' class="width140 m10 colorField validPrice" placeholder=""');?>
										<span class="error color_error"></span>
										<span class="customise_currency curOption">USD</span>
									</div>

									<!--end of inner loop -->
							
							<?php } ?>
							</div>
							<div class="clearfix"></div>
							<a class="addColorOption floatL" href="javascript:void(0)">Add another option</a>
							<?php $class=''; if($colorCount==1): $class="hide"; endif; ?>
							<a class="removeColorOption <?php echo $class; ?>" href="javascript:void(0)" >Remove option</a>
							
						</div>
					
					</div>
				  </div>
				  
				    <div class="form-group">
				  	<div class="col-sm-8">
						<?php $checkOption=(isset($options) && $sizeCount!=0)? 'required':''; ?>
						<?php echo form_checkbox('size_option', '','','class="floatL size_option"');?> <label > &nbsp; Add drop-down menu with option</label>
						
						<div class="size_content">
							<?php $customisesize=(isset($options)? $options->customise_size:'');?>
							<?php echo form_input('customisesize',$customisesize,'class="sizeField" placeholder="Product Color"');?>
							<div>
								<label class="floatL width300">Menu option name</label> 
							</div>
							<div class="customise_size_div">
							<?php 
								$count=0;
								if(isset($optionDetails) && !empty($optionDetails)){
									
									foreach($optionDetails as $optionData){
										if($optionData->option_type==1){
											$count+=1;
										?>
												<?php echo form_input('customise_size[]',$optionData->option_name,' class="width300 sizeField" placeholder="Option1" required');?>
										<?php
										}
									}
									
								} 
								$sizeCount=$count;
								if($sizeCount==0 || $bannerId==''){ ?>
									
									<?php echo form_input('customise_size[]','',' class="width300 sizeField" placeholder="Option1"');?>
										
							<?php } ?>
								</div>
							<div class="clearfix"></div>
							<a class="addSizeOption floatL" href="javascript:void(0)">Add another option</a>
							<?php $class=''; if($sizeCount==1): $class='hide'; endif; ?>
							<a class="removeSizeOption <?php echo $class; ?>" href="javascript:void(0)" >Remove option</a>
						
						</div>
					
					</div>
				  </div>
				  
				    <div class="form-group">
					<div class="col-sm-8">
						<label class="floatL">Postage </label>
						<label class="item_title">Tax Rate % </label>
							<?php echo form_input('banner_postage', $_banner->banner_postage,' class="alpha_num width300" placeholder="Postage"');?>
							<span class="error"></span>
							<?php echo form_input('tax_rate',$_banner->tax_rate ,'class="validPrice itemIdField" placeholder="Tax Rate" maxlength="10"');?>
							<span class="error tax_error"></span>
					</div>
				  </div>
				  
				   <div class="form-group">
					<div class="col-sm-8">
						<label >Do you want to let your customer change order quantities? </label>
								<?php $changeOrder= ($_banner->change_order==1)?'checked':''; ?>
								<?php echo form_radio('change_order', '1',$changeOrder,'');?>Yes
								<span class="error"></span>
							<?php $changeOrder=''; if($_banner->change_order!=1){ $changeOrder= 'checked'; }?>
						
							<?php echo form_radio('change_order','0',$changeOrder,'');?>No
							<span class="error"></span>
							
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-sm-8">
						<label >Do you need your customer's shipping address?</label>
						<?php $changeAddres= ($_banner->shipping_address==1)?'checked':''; ?>
							<?php echo form_radio('shipping_address', '1',$changeAddres,'');?>Yes
							
							<?php $changeAddres=''; if($_banner->shipping_address!=1){ $changeAddres= 'checked'; }?>
							<?php echo form_radio('shipping_address', '0',$changeAddres,'');?>No
						
					</div>
				  </div>
				  
				   <div class="form-group">
					<div class="col-sm-8">
						<label >
							Take customers to this URL when they cancel their checkout <span>*</span></label>
							<?php echo form_input('cancel_url', $_banner->cancel_url ,'required class="valid_url"');?>
							<span class="error"></span>
					</div>
				  </div>
				  
				   <div class="form-group">
					<div class="col-sm-8">
						<label >
							Take customers to this URL when they finish checkout <span>*</span></label>
							<?php echo form_input('checkout_url', $_banner->checkout_url,'required class="valid_url"');?>
							<span class="error"></span>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-sm-8">
						<label><?php echo lang('merchant:description');?><span>*</span> </label>
						 <textarea class="form-control" id="banner_description" name="banner_description" placeholder="Banner Description"  class="form-control alpha_num" rows="4"><?php echo $_banner->banner_description; ?></textarea>
						<span class="error"></span>
					</div>
				  </div>
				  
				    <div class="form-group">
					<div class="col-sm-8">
						<label> <?php echo lang('merchant:referral_point');?> <span>*</span></label>
						<?php 
								$referralPoint=$_banner->referral_point;
								if($referralPoint==''){
									$referralPoint=$defaultReferralPoint;
								}
						?>
						<?php echo form_input('referral_point', $referralPoint,'required class="form-control  referral_point" placeholder="Referral Point"');?>
							<span class="error"></span>
					</div>
				  </div>
				  
				  
				<!--  <div class="form-group">
					<div class="col-sm-8">
						<label><?php //echo lang('merchant:target_url');?> <span></span></label>

						<?php //echo form_input('target_url', $_banner->target_url,'required class="form-control valid_url" placeholder="Targer Url"');?>
						<span class="error"></span>
					</div>
				  </div> -->
				  
				 <div class="form-group">
					<div class="col-sm-8">
						<?php  $imgURL='required'; $uploadImg=''; if($_banner->upload_type==1){ $uploadImg='checked'; $imgURL=''; }?>
						<label class="url_radio"> <span><?php echo form_radio('image_option','0',$imgURL,'class=" image_option"')?> <?php echo lang('merchant:image_url');?></span></label>
						<label class="img_radio"> <span><?php echo form_radio('image_option','1',$uploadImg,'class="image_option" id="upload_option"')?> <?php echo 'Upload Image';?></span> </label>
						<span class="img_note">(*Note: Only Image allowed) </span>
						
						<?php echo form_input('image_url', $_banner->image_url,' class="valid_url img_url form-control" placeholder="Imge Url" id="image_url"'.$imgURL.'');?>
						<?php $width=''; $height=''; ?>
						<?php  if( $_banner->image_type==1): $width='70px'; $height='70px'; endif;?>
						<?php  if( $_banner->image_type==2): $width=$_banner->image_width; $height=$_banner->image_height; endif;?>
					
						
						
						<span class="error"></span>
							 <div class="clearfix"></div>  
							<span class="img_upload">
									<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support. </div>
									 <div class="prev_img"><?php if($_banner->upload_type==1){ echo $_banner->upload_image_name; }?></div>
									
										<div id="drop-target" class="upload_area">
											<img  src='<?php if($_banner->upload_image_name!='' && $_banner->upload_path!=''){ echo base_url().$_banner->upload_path.$_banner->upload_image_name; }?>' name="uploaded_img" id='uploaded_img' alt=" Drag Here..." >
											<input type="hidden" name="uploaded_img_name" id="uploaded_img_name" value="<?php echo $_banner->upload_image_name; ?>" >
										
									</div>
									
									<br>
									
									<span id="container" class="selectFile">
										 <a id="pickfiles" href="javascript:;">[Select files]</a> &nbsp;|&nbsp;
										
									</span>
									
							</span>
							 <a href="javascript:void(0)" class="banner_preview">Preview</a>
							 <div id="upload_error" class="error"></div>
					</div>
				  </div>
				  
				 <?php
				//set image for preview
				  if($_banner->upload_image_name!='' && $_banner->upload_path!=''){
					  $imageURL= base_url().$_banner->upload_path.$_banner->upload_image_name;
				  }else{
					 $imageURL=$_banner->image_url;
				  }
				  $previewImg='<img src="'.$imageURL.'" alt="No Image" name="img_preview" id="img_preview" width="'.$width.'" height="'.$height.'" class="img_preview">';
				  
				?>

				  <div class="form-group">
					<div class="col-sm-8">
						<label><?php echo lang('merchant:image_type');?> <span>*</span></label>
						
						<label class="radio-inline">
						 
							<?php  $originalImage=''; if($_banner->image_type=='' || $_banner->image_type==0): $originalImage="checked"; endif; ?>
							<?php echo form_radio('image_type','0',$originalImage,'id="original_image_size" class="selectImgSize"'); ?>
							<?php echo lang('merchant:original_image_size'); ?> 
															
						</label>
						
						<label class="radio-inline">
							 <?php  $defaultImage=''; if($_banner->image_type==1): $defaultImage="checked"; endif; ?>
							<?php 	echo form_radio('image_type','1',$defaultImage,'id="default_image_size" class="selectImgSize"');	?>
							<?php 	echo lang('merchant:default_image_size'); ?> 
						</label>
						
						<label class="radio-inline">
					   <?php  $ownImage=''; if($_banner->image_type==2): $ownImage="checked"; endif; ?>
						<?php	echo form_radio('image_type','2',$ownImage,'id="own_size" class="selectImgSize"'); ?>
						<?php 	echo lang('merchant:own_size'); ?>
						</label>
						 <div class="form-group mt10">
							<div class="col-sm-8">
								<div class="image_param">
								<label for="image_url"><?php echo lang('merchant:width');?> <span>*</span></label>
								<?php echo form_input('image_width', $_banner->image_width,'class="numeric imgParam" id="image_width" required maxlength="3"');?>
								<span class="error"></span>
								</div>
						</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-8">
								<div class="image_param">
									<label for="image_url"><?php echo lang('merchant:height');?> <span>*</span></label>

									<?php echo form_input('image_height', $_banner->image_height,'class="numeric imgParam" id="image_height"  maxlength="3"');?>
									<span class="error"></span>
								</div>
							</div>
						</div>
						
					</div>
				  </div>
				  
				  <div class="form-group">
				
				  <div class="col-sm-8">
					<input type="hidden" name="default_referral_point" id="default_referral_point" value="<?php echo $defaultReferralPoint; ?>">
					 <button type="button" class="btn btn-primary" onclick="history.go(-1)"> 
						<i class="fa fa-arrow-circle-left fa-fw fa-1x"></i> 
					 <span><?php echo lang('global:back'); ?></span> 
					</button>
					 
					<button type="submit" class="btn btn-primary submit_btn"> 
					 <i class="fa fa-plus-square fa-fw fa-1x"></i> 
					 <span>Save</span> 
					</button>
				
					</div>
				  </div>

			<?php echo form_close(); ?>
		 </div>
		 
	</div>
	

</div>


<?php
	//load preview view
	$data['previewImg']=$previewImg;
	echo $this->load->view('banner_preview',$data,true);
?>

<script>
	//check image type
	var str='validation';
	var image_type='<?php echo $imageType; ?>';
	var uploadType='<?php echo $uploadType; ?>';

	if(image_type!=2){
		
		$('.imgParam').attr("required",false);
		slideUp('.image_param');
	}
	
	jQuery(document).delegate('.selectImgSize','click',function(){
		var value=$(this).val();
	
		if(value==2){
			$('.imgParam').attr("required",true);
			slideDown('.image_param');
			return true;
		}
		$('.imgParam').attr("required",false);
		slideUp('.image_param');
		$('.imgParam').attr("validation","");
	});
	
	//code for hide show image option
		jQuery(document).delegate('.image_option','click',function(){
		var value=$(this).val();
		$('.img_url').next('span').html('');
		if(value==0){
			$('#uploaded_img').attr("required",false);
			$('.img_url').addClass("valid_url");
			$('.img_upload').hide();
		
			$('.img_url').show();
			$('.img_url').attr("required",true);
		}else{
			
			$('.img_url').hide();
			$('.img_url').attr("required",false);
			$('.img_url').removeClass("valid_url");
		
			$('#uploaded_img').attr("required",true);
			$('.img_upload').show();
		
		
		}
	});
	if(uploadType==0){
		$('.img_upload').hide();
		
	}else{
		$('.img_upload').show();
		$('.img_url').hide();
	}
</script>

<!-- production -->
<script>
	//code for customise color
	var colorCount='<?php echo $colorCount; ?>';
	var bannerId='<?php echo $bannerId; ?>';

	if(bannerId!='' && colorCount>0){
		
		$('.customise_content').show();
		$('.colorField').attr('required',true);
		$('.color_option').attr('checked','checked');
	}else{
		$('.customise_content').hide();
	}
	$(document).ready(function(){
		
	
	jQuery(document).delegate('.color_option','click',function(){
		if($(this).is(':checked',true))
		{
			$('.colorField').attr('required',true);
			$('.customise_content').show();
		}else{
			$('.colorField').attr('required',false);
			$('.customise_content').hide();
		}
	});
	jQuery(document).delegate('.addColorOption','click',function(){
		colorCount=parseInt(colorCount)+1;
		var currencyType=$('.currency_type').val();
	
		var color='	<div class="customise_color_div"><input type="text" name="customise_color[]" placeholder=Option'+colorCount+' class="width300 colorField" required >&nbsp;<input type="text" name="customise_price[]" class="width140 m10 colorField validPrice" required ><span class="error color_error"></span><span class="customise_currency curOption">'+currencyType+'</span></div>';
		$('.customise_inner_wrap').append(color);
		$('.removeColorOption').show();
		$('.removeColorOption').removeClass('hide');
		
	});
	jQuery(document).delegate('.removeColorOption','click',function(){
		if(colorCount==2){
			$('.removeColorOption').hide();
		}
			$( ".customise_inner_wrap div" ).last().remove();
			colorCount=parseInt(colorCount)-1;
	});
	jQuery(document).delegate('.currency_type','change',function(){
		var currencyType=$('.currency_type').val();
		$('.curOption').html(currencyType);
	});
	//code for customise size
	
	var sizeCount='<?php echo $sizeCount;?>';
	if(bannerId!='' && sizeCount>0){
		$('.size_content').show();
		$('.sizeField').attr('required',true);
		$('.size_option').attr('checked','checked');
	}else{
		$('.size_content').hide();
	}
	jQuery(document).delegate('.size_option','click',function(){
		if($(this).is(':checked',true))
		{
			$('.sizeField').attr('required',true);
			$('.size_content').show();
		}else{
			$('.sizeField').attr('required',false);
			$('.size_content').hide();
		}
	});
	jQuery(document).delegate('.addSizeOption','click',function(){
	
		sizeCount=parseInt(sizeCount)+1;
		var size='<input type="text" name="customise_size[]" placeholder=Option'+sizeCount+' class="width300 sizeField" required>';
		$('.customise_size_div').append(size);
		$('.removeSizeOption').show();
		$('.removeSizeOption').removeClass('hide');
	});
		jQuery(document).delegate('.removeSizeOption','click',function(){
				
		if(sizeCount==2){
			$('.removeSizeOption').hide();
		}
			$( ".customise_size_div input" ).last().remove();
			sizeCount=parseInt(sizeCount)-1;
	});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
	
var filePath='<?php echo base_url().SHARED_ADDONPATH.'modules/merchant' ;?>';
var url = "<?php echo base_url().'merchant/uploadImage';?>";
var upload_dir = "<?php echo base_url().'assets/banner_images/';?>";
// Custom example logic
var BASEPATH = filePath+'/plupload';	
var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	drop_element: 'drop-target',
	container: document.getElementById('container'), // ... or DOM Element itself
	url : url,
	flash_swf_url : BASEPATH+'/js/Moxie.swf',
	silverlight_xap_url : BASEPATH+'/js/Moxie.xap',
	
	filters : {
		max_file_size : '8mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"},
		/*	{title : "Zip files", extensions : "zip"} */
		]
	},

	init: {
		PostInit: function() {
			document.getElementById('filelist').innerHTML = '';

		/*	document.getElementById('uploadfiles').onclick = function() {
				uploader.start();
				return false;
			}; */
		},

		FilesAdded: function(up, files) {
			plupload.each(files, function(file) {
				document.getElementById('filelist').innerHTML = '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
				uploader.start();
				$('.prev_img').hide();
				});
		},	

		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			if(file.percent==100){
				$('#uploaded_img').attr('src',upload_dir+file.name);
			
				$('#uploaded_img_name').val(file.name);
			}
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});

uploader.init();
//check upload image validation
$('.submit_btn').click(function(){
	
	if($("#upload_option").is(":checked")){
		var value=$('#uploaded_img_name').val();
	
		if(value==''){
			$('#upload_error').fadeIn('fast');
			$('#upload_error').html('Please upload valid image');
			 $('#upload_error').fadeOut(8000);
			return false;
		}
		$('#upload_error').html('');
	}
});

});
</script>


