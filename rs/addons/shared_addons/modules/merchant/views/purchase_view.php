<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form to add/edit banner?>
<?php
	$userId=is_logged_in();
	
?>


<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">


<!--/DEMO TABLE CONTENT/-->	
<div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
<table id="example" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
<thead>
	<tr role="row">
		
		<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Banner Name: activate to sort column ascending" style="width: 120px;">
			Banner Name
				
		</th>
		<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Banner Name: activate to sort column ascending" style="width: 100px;">
		TransactionId
				
		</th>
		<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Target URL: activate to sort column ascending" style="width: 100px;">
				Amount(in $)
		</th>

		<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Order: activate to sort column ascending" style="width: 120px;">
			Commission(in $)
		</th>
		<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 150px;">
			Payment Method
		</th>
		<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 100px;">
			Payment On
		</th>
		<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 154px;">
			&nbsp;&nbsp;
		</th>
				
		</tr>


</thead>

<tbody>
	 <?php if(isset($products) && !empty($products)):?>
	<?php foreach($products as $product):?>
	<tr>
		
		
		<td><?php echo  $product->banner_name;?></td>
		<td><?php echo  $product->transaction_id;?></td>
		<td><?php echo  $product->amount;?></td>
		<td><?php echo  $product->commission;?></td>
		<td><?php echo  $product->payment_method;?></td>
		
		<td><?php echo  date('d-m-Y', strtotime($product->created_at));?></td>
		<td><?php echo anchor('merchant/viewbanner/'.$product->banner_id,lang('merchant:view_banner'),'class=""'); ?></td>
	</tr>
	<?php endforeach;?>
<?php endif;?>	
				 
	</tbody>
</table>


 <a href="<?php echo base_url().'merchant/affiliates'; ?>">
	<button type="button" class="btn btn-primary"> 
	 <i class="fa fa-arrow-circle-left fa-fw fa-1x"></i> 
	 <span><?php echo lang('global:back'); ?></span> 
	</button>
</a>

   
</div>

</div>

</div>
<!--/END OF DEMO TABLE CONTENT/-->
						

</div>
<!--/END OF PRODUCT BANNER CONTENT/-->  
                       
