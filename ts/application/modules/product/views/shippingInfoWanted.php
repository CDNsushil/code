<?php
if(!isset($productId) || $productId==0)
{
?> 
<div class="row opacity_4">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('shippingCharges'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Education toggle Icon -->							
				<a  class="formTip" >					
					<span><div class="projectToggleIcon" id="eduToggleIcon" toggleDivId="EDUCATION-Content-Box" ></div></span>
				</a>
			</div>
		</div>
	</div>
</div><!--row-->
<?php
}
else{

$formAttributes = array(
		'name'=>'updatePrice',
		'id'=>'updatePrice'
);
	
$productwillingToPayArr = array(
	'name'	=> 'productwillingToPay',
	'id'	=> 'productwillingToPay',
	'class'	=> 'NumGrtrZero required number',
	'value'	=> $productwillingToPay,
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 20
);

$productIdHidden = array(
	'name'	=> 'productId',
	'type'	=> 'hidden',
	'id'	=> 'productId',
	'value'	=> $productId
);

?>

<?php echo form_input($productIdHidden);?>
<!-- Accordin Started -->
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('supportedMedia'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Post add Icon -->
								
				<a  class="formTip" >					
					<span><div class="projectToggleIcon" id="productShipToggleIcon" toggleDivId="productShip-Content-Box" ></div></span>
				</a>
			</div>
		</div>
	</div>
	
</div><!--row-->	

<!-- Accordin Ended -->
<div class="clear"></div>
<div id="productShip-Content-Box" class="frm_strip_bg">	
<?php echo form_open_multipart($this->uri->uri_string(),$formAttributes); ?>
<div class="row"><div class="tab_shadow"></div></div>

<div class="row">
	<div class="label_wrapper cell">
		<label class="select_field"><?php echo $label['project_price'];?></label>
	</div><!--label_wrapper-->
	<div class="cell frm_element_wrapper width330px">
		<div class="cell mr15"  style="height:25px;"><?php echo form_input($productwillingToPayArr); ?></div>
		<? /*
		<div class="cell defaultP"  onclick="changeStatus();">
			<input type="checkbox" value="wnatedShipping" name="wnatedShipping" id="wnatedShipping" <?php if(($mode =='edit') && (count($shippingCountryArray) !=0)){ echo "checked"; }?>/>
		</div>
		<div class="cell">
			<label for="wnatedShipping"><?php echo $label['shipmentPrice']?></label>
			
		</div>
		* */ ?>
		
<div class="seprator_27 row"></div>
<div class="row width273px">
	<div class="Req_fld cell">Required Fields </div>
	<?php echo form_input($productIdHidden);?>
	<?php
		$button=array('save');
		echo Modules::run("common/loadButtons",$button); 
	 ?>
</div>
  <?php echo form_close(); ?>
</div>
<?php 
//To show the main image from promotional images get added
$mainImages = getMainImages('ProductPromotionMedia','filePath,fileName,fileSize','prodId',$productId,1, 'isMain');
$productMainImage='';
if(!empty($mainImages) && is_array($mainImages)) {
	$productMainImage = $mainImages[0]->filePath.$mainImages[0]->fileName;
	$elementFileSize = $mainImages[0]->fileSize;
}

?>
	<div class="picture_size_box">
	  <div class="browse_thumb_wrapper cell margin_0 ">
		<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
		  <tbody>
			<tr>
			  <td><img src="<?php echo getImage($productMainImage,$productDefaultImage);?>" /></td>
			</tr>
		  </tbody>
		</table>
	  </div>
	  
	  <div class="picture_size_des_wp">
		<div> <?php echo $this->lang->line('size');?> : <?php $elementFileSize =0; echo number_format(($elementFileSize/1024),4); echo '&nbsp;'.$this->config->item('mediaUnit');?></div>
		<div> <?php echo $this->lang->line('length');?> : <?php $elementLength=0; echo $elementLength;?> </div>			
	  </div>
	</div>
</div>
	<?php if($mode=='edit') { ?>
	<span id="mySpan" style="display:none"><?php echo count($shippingCountryArray)-1;?></span>
	<?php } else {?>
	<span id="mySpan" style="display:none">0</span>
	<?php }?>


<div class="cell" id='insideShippingWanted'>
<div class="row line1 mt10 mb10"></div>
<?php
		echo Modules::run("shipping/shippingList",$productId,getMasterTableRecord('Product')); 
?>
</div>
<div class="seprator_27 row"></div>
	<div class="clear"></div>
</div><!-- End productShip -->

<div class="row">
	<div class="tab_shadow"></div>
</div>
<script>
$(document).ready(function(){
		$("#updatePrice").validate({
			submitHandler: function() {
				
				var productId = $('#productId').val();
				
				var isproductPrice = (($('#wnatedShipping').attr('checked')) ? 't' : 'f') ;
				
				if(isproductPrice =='t') $('#productwillingToPay').addClass('price_input required number NumGrtrZero');
				else {
					if($('#wnatedShipping').hasClass('required number NumGrtrZero'))	 
						$('#productwillingToPay').removeClass('required number NumGrtrZero');
				}
				if($('#productwillingToPay').val() =='') var productwillingToPay = 0;
				else var productwillingToPay = $('#productwillingToPay').val();
				var data = {"productwillingToPay":productwillingToPay}; 
				AJAX('<?php echo base_url(lang()."/product/updateWantedPrice");?>','',data,productId);
				$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('priceSuccessMsg');?></div>');
				timeout = setTimeout(hideDiv, 5000);
			 } 
			
		});
	});
	
function changeStatus()
{
	if($('#wnatedShipping').attr('checked'))
	{
		$('#insideShippingWanted').css('display','block');
	}else{
		var checkCount = $('#mySpan').html();
		for(var i =0;i<=checkCount; i++)
		{
			$('#removeID_'+i).remove();
		}
		$('#shipping_count').html('0');
		$('#insideShippingWanted').css('display','none');
		
	}
}
</script>
<?php
}
?>
