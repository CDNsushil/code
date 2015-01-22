<section class="title">

		<h4>View Merchant Payment</h4>
		<?php echo form_open(uri_string(), 'class="crud"') ?>
</section>

<section class="item">
	<div class="content">
	
		<div class="tabs">
	
			<!-- Content tab -->
			<div class="form_inputs " id="user-basic-data-tab">
				<fieldset class="pd20 request">
					<ul>
					
						<li class="">
							 <label > <div class="view_request">Merchant Name :  </div></label>  <?php echo $payment->first_name ;?> 
						</li>
						<li class="">
							 <label><div class="view_request"> Product Name :  </div></label><?php echo $payment->banner_name ;?> 
						</li>
						
						<li class="">
						
							 <label class=""> <div class="view_request"> Product Price : </div> </label> <span class=""><?php echo $payment->amount.$payment->currency; ?></span>

						</li>
						
						<li class="">
	
							 <label class=""> <div class="view_request">Commission : </div> </label> <?php echo $payment->referral_commission.$payment->currency; ?>
			
						</li>
						
						<li class="">
						
							 <label> <div class="view_request">Payment Date :  </div></label> <?php echo date('d M Y H:i:s',strtotime($payment->order_time)) ;?>
				
						</li>
						
						<li class="">
							 <label ><div class="view_request"> Status : </div> </label>  <span class=""><?php if($payment->pay_status==1){ echo 'Paid'; }else{ echo 'Pending';	 }?> </span>
							
						</li>
						
						<?php if($payment->pay_status==1){?>
						<li class="">
						
							 <label><div class="view_request"> Transation Id :  </div></label> <?php echo $payment->txn_id ;?>
						
						</li>
						
					
						<?php } ?>	
						
					</ul>
					<button type="button" class="btn btn-primary btn_color back_btn" onclick="history.go(-1)" class="my_btn"> 			
								 Back
					</button>
				
				</fieldset>
			</div>
		
		</div>

	
	<?php echo form_close() ?>

	</div>
</section>

