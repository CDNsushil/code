<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$seller_currency=LoginUserDetails('seller_currency');
$seller_currency=($seller_currency>0)?$seller_currency:0;
$currencySign=$this->config->item('currency'.$seller_currency);
$entityId=getMasterTableRecord('Product');

if(!isset($productId) || $productId==0 )
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
	
$productIdHidden = array(
	'name'	=> 'productId',
	'type'	=> 'hidden',
	'id'	=> 'productId',
	'value'	=> $productId
);

$sellTypeHidden = array(
	'name'	=> 'sellType',
	'type'	=> 'hidden',
	'id'	=> 'sellType',
	'value'	=> $productSellType
);

$productDownloadPriceArr = array(
	'name'	=> 'productDownloadPrice',
	'id'	=> 'productDownloadPrice',
	'class'	=> 'fl price_input required NumGrtrZero',
	
	'value'	=> $productDownloadPrice,
	//'placeholder'	=> 'Price',
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'type'	=> 'text',
	'size'	=> 5
);

if(($mode=='edit') && ($productDownloadPrice !=0)){
	unset($productDownloadPriceArr['disabled']);
}

$productPrice = (isset($productPrice) && $productPrice > 0)? $productPrice:0;
$productPriceArr = array(
	'name'	=> 'productPrice',
	'id'	=> 'productPrice',
	'value'	=> $productPrice,
	'maxlength'	=> 50,
	'style'	=> 'mr10',
	'disabled'	=> 'disabled',
	'size'	=> 5,
	'type'	=> 'text',
	'onkeyup'=> "getDisplayPrice(this,'".$seller_currency."','#totalCommisionProduct','#displayPriceProduct')"
);

if(($mode =='edit') && ($productPrice>0)){
	$productPriceArr = array_merge(array('class'=>'fl price_input NumGrtrZero font_opensansSBold clr_666'),$productPriceArr);
}
else{
	$productPriceArr = array_merge(array('class'	=> 'fl price_input_disable font_opensansSBold clr_666'),$productPriceArr);
}
/*$productPrice = array(
    'name'        => 'productPrice',
    'id'          => 'productPrice',
);*/

$productQuantity=(isset($productQuantity) && ($productQuantity > 0))?$productQuantity:0;
$quantityInput = array(
		'name'	=> 'productQuantity',
		'value'	=> $productQuantity,
		'id'	=> 'productQuantity',
		'type'	=> 'text',
		'class'	=> 'fl price_input font_opensansSBold clr_666 NumGrtrZero required'
	);
$priceDetails=getDisplayPrice($productPrice,$seller_currency);
?>	

<!-- Accordin Started -->
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php //echo $this->lang->line('supportedMedia'); 
			if(isset($productSellType) && $productSellType==2)
			echo $this->lang->line('auctionAccordion'); 
			else
			echo $this->lang->line('saleAccordion'); 
			?>
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

	
<div id="productShip-Content-Box" class="frm_strip_bg">		
<div class="row"><div class="tab_shadow"></div></div>

<?php
if(isset($productSellType) && $productSellType==2) {
	echo Modules::run("auction/auctionForm",array('entityId'=>$entityId,'projectId'=>$productId,'elementId'=>$productId)); //load auction form
} else { 
	echo form_open_multipart($this->uri->uri_string(),$formAttributes); ?>
	<div class="row">
		<div class="label_wrapper cell mt21">
			<label class="select_field"><?php echo $label['deliveryMethod']?></label>
		</div>
		<div class=" cell frm_element_wrapper ">			
				<div class="row ">
					<div class="fl width_330 height_21"> </div>
					<div class="font_opensansSBold ml26 fl widht_63 orange_clr_imp mt-4 lineH16"> <?php echo $this->lang->line('tsCommision');?> </div>
					<div class="font_opensansSBold ml26 fl pt5  clr_white text_alignR consumebg_top height_15"> <?php echo $this->lang->line('displayPrice');?> </div>
					<div class="clear"></div>
				</div>
				<div class="consumebg">
					<div class="row">
						<div class="fl">
							<div class="price_trans_wp">
								<div class="row">
									<div class="cell price_trans_checkbox_wp ">
										<div class="defaultP mt2 ml20 "  onclick="checkboxEvent($('#product').val())">
											<input type='checkbox' name='productPriceCheckbox'  id="product" value='product' <?php if(($mode =='edit') && ($productPrice >0)){ echo "checked"; }?>>
										</div>
									</div>
									<div class="cell price_trans_heading text_alignL pl0 font_opensansSBold  width_100"> <?php echo $this->lang->line('product');?> </div>
									<div class="cell font_opensansSBold ml60 width120px"> 
										 <?php echo form_input($productPriceArr); ?>
									</div>
									<div class="cell font_opensansSBold ml26  widht_63 pt2 text_alignC" id="totalCommisionProduct">
										<?php echo $priceDetails['currencySign'].' '.$priceDetails['totalCommision']?>
									</div>
									<div class=" cell font_opensansSBold ml26  pt2 widht_72 clr_white text_alignR pr19 pl16" id="displayPriceProduct">
										<?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice']?>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="clear"> </div>
				</div>
				<div class="row">
					<div class="fl width_330 height_21"> </div>
					<div class="font_opensansSBold ml26 fl widht_63 height4 pt2"> </div>
					<div class="font_opensansSBold ml26 fl pt2 consumebg widht_72 clr_white text_alignR pr19 pl16 consumebg_bottom"> </div>
					<div class="clear"></div>
				</div>
				
					<div class="row">
						<div class="fl" id="productSaleAfter">
							<div class="price_trans_heading text_alignL pl20 font_opensansSBold cell"> <?php echo $this->lang->line('removeProductAfter');?> </div>
							<div class="font_opensansSBold ml30 cell width100px"> 
									 <?php echo form_input($quantityInput); ?>
							</div>
							<div class="font_opensansSBold ml5 cell widht_63 pt2"><?php echo $this->lang->line('sale(s)');?></div>
						</div>
					</div>
			</div>
	</div>
	
		<div class="row mt15" id="sellerInfo">
			<div class="label_wrapper cell bg-non"></div>
			<div class=" cell frm_element_wrapper ">
				<div class="cell f11 pt10 pl20"><?php echo $this->lang->line('yourSellerSetting1').'<a href="'.base_url('dashboard/globalsettings').'" class="ptr dash_link_hover">'.$this->lang->line('yourSellerSetting2').'</a>'.$this->lang->line('yourSellerSetting3');?></div>
				<!--<div class="Req_fld cell">Required Fields </div>-->
				<?php
				//$button=array('save');
				//echo Modules::run("common/loadButtons",$button); 
			 ?>
			</div>
		</div>	
	<div class="row" >
		<div class="label_wrapper cell bg-non"></div>
		
		<div class=" cell frm_element_wrapper ml-15">
			<div class="cell f11 pt10 pl20"></div>
			<?php
			//Set hidden input fields
			echo form_input($sellTypeHidden);
			$button=array('save');
			echo Modules::run("common/loadButtons",$button); 
		 ?>
		</div>
	</div>	
	
<?php echo form_close(); 
}?>	

<?php 
//To show the main image from promotional images get added
/*
$mainImages = getMainImages('ProductPromotionMedia','filePath,fileName,fileSize','prodId',$productId,1, 'isMain');
$productMainImage='';
if(!empty($mainImages) && is_array($mainImages)) {
	$productMainImage = $mainImages[0]->filePath.$mainImages[0]->fileName;
	$elementFileSize = $mainImages[0]->fileSize;
}

?>
<div class="picture_size_box mt6">
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
		<div> <?php echo $this->lang->line('size');?> : <?php $elementFileSize =0; echo number_format(($elementFileSize/1024),3); echo '&nbsp;'.$this->config->item('mediaUnit');?></div>
		<div> <?php echo $this->lang->line('length');?> : <?php $elementLength=0; echo $elementLength;?> </div>			
	  </div>
	</div>
<?php
*/?>
	
	<!--<div class="row">
		<div class="label_wrapper cell bg_none"></div><!--label_wrapper-->
				
		<!--<div class="cell frm_element_wrapper">
		<!-- <div class="row "><div class="cell">*&nbsp;</div><div class="cell" ><?php //echo $this->lang->line('allReqFieldMsg');?></div></div>
			<div class="row height25">
				<div class="cell">*&nbsp;</div>
				<div class="cell" >
					<?php //echo $this->lang->line('shippingProductMsg');?>
				</div>
			</div>
		</div>
	</div>-->
	<div class="clear"></div>
	<div class="row" id="shippingDiv">
		<div class="cell" id='insideShipping' style="<?php  if(($mode =='edit') && (!empty($shippingDetailArray) || (isset($productSellType) && $productSellType==2))){ echo 'display:block'; } else { echo 'display:none'; }?>">
			<div class="row line1 mt10 mb10"></div>
			<?php echo Modules::run("shipping/shippingList",$productId,$entityId); ?>
		</div>	
		<div class="clear"></div>
		<div class="seprator_25 clear row"></div>
	</div><!-- End row-->
	
	<?php echo Modules::run("counsumptiontax/counsumptiontaxForm",$entityId,$productId,$productId); ?>
	<div class="clear"></div>
	
	<!--Requiered field msg -->
	<div class="row mt15" >
		<div class="label_wrapper cell bg-non"></div>
		<div class=" cell frm_element_wrapper ">
			<div class="Req_fld cell">Required Fields </div>
		</div>
	</div>	
	<div class="row">
		<div class="label_wrapper cell bg_none"></div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<div class="row ">
				<div class="cell">*&nbsp;</div>
				<div class="cell" ><?php echo $this->lang->line('allReqFieldMsg');?></div>
			</div>
			<div class="row height25">
				<div class="cell">*&nbsp;</div>
				<div class="cell" >
					<?php echo $this->lang->line('shippingProductMsg');?>
				</div>
			</div>
		</div>
	</div>
	<!--Requiered field msg -->	
<div class="seprator_25 clear row"></div>
</div><!-- End productShip -->
<div class="clear"></div>
<div class="row">
	<div class="tab_shadow"></div>
</div>
<script>
	$(document).ready(function(){
		$("#updatePrice").validate({
			submitHandler: function() {
				
				//var productId = $('#productId').val();
				var productId = '<?php echo $productId;?>';
				
				var isproductDownloadPrice =  (($('#download').attr('checked')) ? 't' : 'f') ;
				var isproductPrice = (($('#product').attr('checked')) ? 't' : 'f') ;
				
				if(isproductPrice =='t') $('#productPrice').addClass('price_input required number');
				else {
					if($('#product').hasClass('required number NumGrtrZero'))	 
						$('#productPrice').removeClass('required number NumGrtrZero');
				}
				if($('#productPrice').val() =='') var productPrice = 0;
				else var productPrice = $('#productPrice').val();
				
				var productQuantity = $('#productQuantity').val();
				
				var data = {"productDownloadPrice":$('#productDownloadPrice').val(),"productPrice":productPrice,"productQuantity":productQuantity}; 
				AJAX('<?php echo base_url(lang()."/product/updatePrice");?>','',data,productId);
				$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('priceSuccessMsg');?></div>');
				timeout = setTimeout(hideDiv, 5000);
				$('#download').attr('checked','t');
				runTimeCheckBox();
			 } 
			
		});
	});
</script>
<?php
}//End If
?>
