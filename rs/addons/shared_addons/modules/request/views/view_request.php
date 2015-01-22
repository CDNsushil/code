
<section class="title">
		<h4>View Payment Request</h4>
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
						
							 <label > <div class="view_request">Affiliate :  </div></label>  <?php echo $_request->first_name ;?> 
								
						</li>
						<li class="">
						
							 <label><div class="view_request"> Product Name :  </div></label><?php echo $_request->banner_name ;?> 
	
						</li>
						
						<li class="">
						
							 <label class=""> <div class="view_request"> Product Price : </div> </label> <span class=""><?php echo $_request->product_price.$_request->currency_type; ?></span>

						</li>
						
						<li class="">
	
							 <label class=""> <div class="view_request">Commission : </div> </label> <?php echo $_request->referral_commission.$_request->currency_type; ?>
			
						</li>
						
						<li class="">
						
							 <label> <div class="view_request">Request Date :  </div></label> <?php echo date('d M Y H:i:s',strtotime($_request->created_at)) ;?>
				
						</li>
						
						<li class="">
							 <label ><div class="view_request"> Status : </div> </label>  <span class=""><?php if($_request->payment_status==1){ echo 'Paid'; }else{ echo 'Pending';	 }?> </span>
							
						</li>
						
						
						
						<?php if($_request->payment_status==1){?>
						<li class="">
						
							 <label><div class="view_request"> Transation Id :  </div></label> <?php echo $_request->txn_id ;?>
						
						</li>
						<li class="">
							 <label><div class="view_request"> Transation Date : </div>  </label> <?php echo date('d M Y H:i:s',strtotime($_request->transaction_date)) ;?>
					
						</li>
					
						
						<?php } ?>	
						
					</ul>
					<button type="button" class="btn btn-primary btn_color back_btn" onclick="history.go(-1)" class="my_btn"> 
								
								 Back
								</button>
					<?php if($_request->payment_status==0){?>
						<a href="<?php echo base_url().'admin/request/setAffiliatePayment/'.$_request->request_id?>" class="my_btn button">
							  Pay Now
									</a>
									<?php }?>
				</fieldset>
			</div>
		
		</div>

	
	<?php echo form_close() ?>

	</div>
</section>

