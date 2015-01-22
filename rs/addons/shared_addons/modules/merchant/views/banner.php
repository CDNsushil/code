<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form for manage merchant banner?>

<?php
	$userId=is_logged_in();
?>


<!--/CONTENT OF PRODUCT BANNER/-->

<div class="col-md-10 col-sm-9 content border_left">
	<?php echo form_open(base_url().'merchant/action'); ?>
	<div class="row marginb20">
		<div class="floatL">
			
			
			<a href="<?php echo base_url().'merchant/banner/add'; ?>">	
			  <button type="button" class="btn btn-primary"> <i class="fa fa-pencil fa-fw fa-1x"></i> <span><?php echo lang('merchant:add_banner'); ?></span> </button>
			</a> 
		 
			 <button type="submit" class="btn btn-primary button selectMul" name="btnAction" value="Delete"> <i class="fa fa-trash fa-fw fa-1x"></i> <span> Delete</span> </button>
		
		</div>
				
		<div class="floatR">
			<a href="<?php echo base_url().'merchant/exportBannerCSV'?>">
			  <button type="button" class="btn btn-primary "> <i class="fa fa-file-excel-o fa-fw fa-1x"></i> <span>Export CSV</span> </button>
			 </a>
			<a href="<?php echo base_url().'merchant/upload-CSV'?>">
			  <button type="button" class="btn btn-primary "> <i class="fa fa-file-excel-o fa-fw fa-1x"></i> <span>Import CSV</span> </button>
			 </a>
		</div>
		
		<div class="clearfix"></div>
		<div class="bnr_search mt10">
			<input type="text" class="width200" id="search_word" name="search_word" class="search_text" placeholder="Banner Name"  >
			
			
			<button type="button" class="btn btn-default btn-success search_word">
							<?php echo lang('global:search');?>
				 </button>
			 <a href="<?php echo base_url().'merchant/banner/';?>"> 
				 <button type="button" class="btn btn-default btn-success">
					<?php echo lang('global:reset');?>
				  </button>
			 </a>
	
			
		</div>
	</div>
	
  <div class="clearfix"></div>
<!--/DEMO TABLE CONTENT/-->	
<div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
	<table id="example" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
	<thead>
		<tr role="row">
			<th class="text-center sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label=": activate to sort column ascending" style="width: 10px;">
				<input type="checkbox" name="selectall" id="selectall" value="1">
				</th>
			
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Target URL: activate to sort column ascending" style="width: 80px;">
				<?php echo lang('global:image'); ?>
			</th>
			
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Banner Name: activate to sort column ascending" style="width: 200px;">
					<?php echo lang('merchant:banner_name'); ?>
					
			</th>
	
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Order: activate to sort column ascending" style="width: 50px;">
				Order
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Order: activate to sort column ascending" style="width: 80px;">
				Total Click
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Order: activate to sort column ascending" style="width: 82px;">
				Total Share
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 150px;">
				Actions
			</th>
			</tr>
	
	</thead>

<tbody class="bodyContent">
		
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
	<?php endif; ?>	

</tbody>

	
	</table>
	 <table class="border_none">
			<tr class="">
					<td colspan="7" class="border_none">
					<div class="col-md-6 ShowingEntries">
						<div class="dataTables_info" id="example_info" role="status" aria-live="polite">  </div>
						</div>
						<div class="col-md-6 Paginations">
							<div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
														
						<?php if(isset($links)) : echo $links; endif; ?>								
						</div>
					</div>
					</td>
				</tr>
	</table>
	</div>
  
	</div>

</div>
	<!--/END OF DEMO TABLE CONTENT/-->
								
	<?php echo form_close(); ?> 
		<div class="clearfix"></div>
	</div>
	<!--/END OF PRODUCT BANNER CONTENT/-->  
                          

<script>
$(document).ready(function(){
	
	jQuery(document).delegate('.select_banner','click',function(){
		
		if($(this).hasClass('all')){
			$(".check_banner").attr('checked', true);
		}else{
			$(".check_banner").attr('checked', false);
		}
	});
	//to seach banner
	
	$(".search_word").click(function(e) {
		var word=$('#search_word').val();
		if(word==''){
			
			return false;
		}
		$.ajax({
		  type: "POST",
		  url: baseUrl+'merchant/getFilterBanner',
		  data: 'word='+word,
			success: function(data) {
				if(data!=''){
					$('tbody.bodyContent').html('');
					$('tbody.bodyContent').html(data);
					return true;
				}
				$('tbody.bodyContent').html("No record found!");
			}
		});
	});
	//select all banner
	$("#selectall").click(function(e) {
	
		if($('#selectall').is(':checked')){
			$('.check_banner').prop('checked',true);
		}else{
			$('.check_banner').prop('checked',false);
		}
	
	});
});
</script>
