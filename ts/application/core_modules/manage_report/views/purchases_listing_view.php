<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul>
	<li>
		<div class="row">
			<div class="cell width100px b"><?php echo $this->lang->line('invoice_Date'); ?></div>
			<div class="cell width130px b"><?php echo $this->lang->line('invoice_No'); ?></div>
			<div class="cell width140px b"><?php echo $this->lang->line('invoice_Seller'); ?></div>
			<div class="cell width140px b"><?php echo $this->lang->line('invoice_Buyer'); ?></div>
			<div class="cell width100px b"><?php echo $this->lang->line('invoice_Type'); ?></div>
			<div class="cell width200px b"><?php echo $this->lang->line('invoice_Title'); ?></div>
		</div>
	</li>
	<?php
		if(isset($purchaseDetails) && !empty($purchaseDetails))
		{
			foreach($purchaseDetails as $purchaseData){
				
				?>
				<li>
					<div class="row">
						<div class="cell width100px"><?php echo date("d F Y",strtotime($purchaseData->ordDateComplete)) ?></div>
						<div class="cell width130px"><?php echo getInvoiceId($purchaseData->receiverTransactionId);?></div>
						<div class="cell width140px"><?php
						$sellerInfo = json_decode($purchaseData->sellerInfo);
						if(!empty($sellerInfo))
						{
							echo ucwords($sellerInfo->firstName.' '.$sellerInfo->lastName);
						}
						?></div>
						<div class="cell width140px"><?php echo ucwords($purchaseData->custName);?></div>
						<div class="cell width100px"><?php echo getPurchaseType($purchaseData->purchaseType); ?></div>
						<div class="cell width200px"><?php echo $purchaseData->itemName;?></div>		
					</div>
				</li>
			<?php
			}
		}
	?>
	<li>
		<?php
		if(isset($items_total)  && isset($items_per_page) && $items_total >  $items_per_page){?>
			<div class="pt15 ml28 mt7 mr15">
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url('admin/settings/manage_report/sales_record'),"divId"=>"showCountryList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
			</div>
			<div class="clear"></div>
			<?php 
		} ?>
	</li>
	<!---------export section design--------->
	<li >
		<?php
		if(isset($countTotal)  && $countTotal > 0){?>
			<div >
				<div class="fr pt15 ml28 mr15">
					<label class="fl mt15"><?php echo $this->lang->line('Export_to'); ?></label>
					  <div class="fl pr selectbox_small">
					  <select style="width:90px;">
						<option selected="selected"><?php echo $this->lang->line('CSV'); ?></option>
					  </select>
				</div>
				<div class="fl mt15">
						<a href="<?php echo base_url('admin/settings/manage_report/sales_record_export'); ?>"> <img src="<?php echo base_url('templates/default'); ?>/images/export.png"></a>
				</div>
            </div> 
           <div class="clear"></div>
			<?php 
		} ?>
	</li>
</ul>	


<script type="text/javascript">
 
$(document).ready(function(){
	selectBox();             		          
});		
</script>
