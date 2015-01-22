<?php 
//echo "<pre>"; print_r($productSellRecordSet);
$shippingCheckboxArray = array();
$shippingCountryArray = array();
$shippingPriceArray = array();
$shippingDetailArray = array();
$shippingDetail= json_decode($productSellRecordSet['productShipment']);
$shippingDetailArray = object2array($shippingDetail);
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<?php //echo $header;?>

	<span class="clear_seprator "></span>
	<div class="title-content" style="width:520px">
		<div class="title-content-left">
			<div class="title-content-right">
				<div class="title-content-center">
					<div class="title-content-center-label"><?php echo $label['productInformation']?></div>
					<div class="tds-button-top"></div><!-- End tds-button-top-->
				<div class="clearfix"></div>
				</div><!-- End title-content-center-->
			</div><!-- End title-content-right-->
		</div><!-- End title-content-left-->
	</div><!-- End title-content-->
<?php
$formAttributes = array(
	'name'=>'customForm',
	'id'=>'customForm'
);
$productTitle = $productSellRecordSet['productTitle'];

$productOneLineDesc = $productSellRecordSet['productOneLineDesc'];

$productTagWords = $productSellRecordSet['productTagWords'];

$productDescription = $productSellRecordSet['productDescription'];

$productLang1 = array(
	'name'	=> 'productLang1',
	'id'	=> 'productLang1',
	'value'	=> set_value('productLang1'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip single',
	'title'       => $label['selectLanguage'],
);


if(($productSellRecordSet['productDownloadPrice'] !='')){
	$productPriceDownload = $productSellRecordSet['productDownloadPrice'];
}else
{
	$productPriceDownload ='';
}

if(($productSellRecordSet['productPrice'] !='')){
	$productPriceProduct = $productSellRecordSet['productPrice'];
}else
{
	$productPriceProduct='';
}
$productReviewLink = $productSellRecordSet['productReview'];
$productExpiryDate = @substr($productSellRecordSet['productExpiryDate'], 0,-8) ;
?>
<div class="width500px">
	<div class="row">
		<div class="cell">
			<div class="cell orng_lbl">Product Type</div>
			<div class="cell width70px">
				<?php if($productType=='freeStuff'){  echo $label['freeStuff']; } else if($productType=='sell'){  echo $label['sell']; } else if($productType=='wanted'){  echo $label['wanted']; } else { echo $label['sell']; } ?>
			</div>
			<div class="cell orng_lbl"><?php echo $label['project_title'];?></div>
			<div class="cell" >
				<?php echo $productTitle; ?>
			</div>
			<div class="cell "><span class="cell"></span></div>
		</div>
		</div>
		<div class="row heightSpacer"> &nbsp;</div>
		<div class="row">
			<div class="cell">
			<?php if($productSellRecordSet['productLang']!='') {?>
				<div class="orng"><?php echo form_label($label['productLanguage']); ?></div>
				<div class="cell width70px" ><?php 
					echo getLanguage($productSellRecordSet['productLang']);
				?></div>
			<?php } if($productSellRecordSet['productIndustryId'] != ''){?>
				<div class="orng"><?php echo form_label($label['productIndustry'])?></div>
				<div class="cell width70px"><?php
					echo getIndustry($productSellRecordSet['productIndustryId']);
				?></div>
			<?php }?>
			</div>
		</div>

		<div class="row heightSpacer"> &nbsp;</div>
		<div class="row">
		<div class="cell">
			<?php if($productSellRecordSet['productCountryId'] !=''){ ?>
			<div class="orng"><?php echo form_label($label['productLocation']); ?></div>
			<div class="cell width70px"><?php 
				echo getCountry($productSellRecordSet['productCountryId']);
			?></div>
			<?php }?>
			<?php if($productExpiryDate !=''){ ?>
			<div class="cell orng_lbl"><?php echo $label['expiryDate'];?></div>
			<div class="cell width70px">
				<?php echo $productExpiryDate; ?>
			</div>
			<?php }	?>
		</div>
		</div>
		<div class="row heightSpacer"> &nbsp;</div>
		<div class="row width100percent">
		<?php if($productOneLineDesc !=''){ ?>
			<div class="cell orng_lbl"><?php echo $label['project_logLineDescription'];?></div>
			<div class="cell"style="width:60%">
			  <?php echo $productOneLineDesc; ?>
			</div>
		<?php }?>
		</div>
		<div class="row heightSpacer"> &nbsp;</div>
		<div class="row width100percent">
			<div class="cell orng_lbl"><?php echo $label['project_tags'];?></div>
			<div class="cell" style="width:60%">
			   <?php echo $productTagWords; ?>
			</div>
		</div>
		<div class="row heightSpacer"> &nbsp;</div>
		<div class="row width100percent">
			<div class="cell orng_lbl"><?php echo $label['productDescription'];?></div>
			<div class="cell" style="width:60%">
			   <?php echo $productDescription; ?>
			</div>
		</div>
		<?php if($productReviewLink!=''){?>
		<div class="row heightSpacer"> &nbsp;</div>
		<div class="row">
			<div class="cell orng_lbl"><?php echo $label['productReviewLink'];?></div>
			<div class="cell" >
				<?php echo $productReviewLink; ?>
			</div>
			<div class="cell "><span class="cell"></span></div>
		</div>
		<?php }?>

		<?php if($this->uri->segment(5)!='freeStuff') { ?>
		<?php if(!empty($productSellRecordSet)){
			$shippingCountryArray = object2array($shippingDetailArray['shippingCountry']);
			$shippingPriceArray = object2array($shippingDetailArray['shippingPrice']);
		}
		?>
		<div class="row heightSpacer"> &nbsp;</div>
		<div class="row" >
		<?php
		if($this->uri->segment(5)!='wanted') { ?>
		<div class="row " style="clear:none">
			<div class="row">
				<div class="cell orng_lbl"><?php echo $label['deliveryMethod'];?></div>
				
				<div class="cell mr15" style="height:25px;">
					<?php if($productSellRecordSet['productDownloadPrice'] !='') { echo $label['Download']; }?>
				</div>
				<div class="cell width100px" style="height:25px;"> 
					<?php  if($productSellRecordSet['productPrice']!=''){
					echo "Product"; }?> 
				</div>
			</div>
			<div class="row heightSpacer">&nbsp;</div>
			<div class="row width540px">
				<div class="cell"><div class="cell orng_lbl"><?php echo form_label($label['productPrice']); ?></div>
				</div>
				<div class="cell mr15" style="height:25px;"><?php echo  $productPriceDownload ;?>
				</div>
				<div class="cell"><?php echo $productPriceProduct; ?>
				</div>
			</div>
		</div>
		<?php } else{?>
		<div class="row">
				<div class="cell"><div class="cell orng_lbl"><?php echo $label['willingToPay']?></div>
				</div>
				<div class="cell mr15" style="height:25px;">
					<?php if($productSellRecordSet['productwillingToPay']!=0) { echo $productSellRecordSet['productwillingToPay']; }?>
				</div>
				
			</div>
		<?php } ?>
		<div class="row heightSpacer"> &nbsp;</div>
		<!--start -->
		<?php //echo $productSellRecordSet['productPrice'];
		if($productSellRecordSet['productShipment']!=''){
			
			//if(!empty($shippingData) && is_array($shippingData)) $shippingData=$shippingData[0];
			//echo '<pre />hgfhgfh';print_r($shippingData);
			if(!empty($shippingData))
					{
						
								
					 ?>
		<div class="row" id="shippingDiv">
			<div class="orng" style="width: 132px;"><?php echo $label['shippingInformation']?></div>
			<?php //echo "<pre>"; print_r($shippingDetailArray);?>
			<div class="cell" id='insideShipping' style="width:255px;">
				<div class="title-content" style="width:255px">
					<div class="title-content-left">
						<div class="title-content-right">
							<div class="title-content-center">
								<div class="title-content-center-label"><?php //echo $label['shippingInformation']?></div>
								<div class="tds-button-top"></div><!--End tds-button-top-->
									<div class="clearfix" > </div>
								</div><!-- End title-content-center-->
							</div><!-- End title-content-right-->
						</div><!-- End title-content-left-->
					</div><!-- End title-content-->
					<div class="table" style="clear:none">
					<div class="table" id="shippingInfoPara">
						<div class="row mL5">
							<div class="cell  width50px tac "><?php echo $label['sNo']?></div>
							<div class="cell  width82px tac " ><?php echo $label['country']?></div>
							<div class="cell  width70px tac "><?php echo $label['project_price']?></div>
						</div>
					<?php
					$i=0;
						foreach($shippingData as $shippingDataValue)
							{
								//echo '<pre />';print_r($workPromotionMedia);die;
								//echo '<br />';
								$SpCountry = $shippingDataValue->SpCountry;
								$SpAmount = $shippingDataValue->SpAmount;
								$i++;
					?>
						<div class="row mL5">
							<div class="cell width50px tac" style="padding: 0 14px 0 0;">
							<?php echo $i.'.'; ?>
							</div>
							<div class="cell width50px tac" style="padding: 0 14px 0 0;">
							<?php echo getCountry($SpCountry); ?>
							</div>
							<div class="cell width70px tac"><?php echo $this->lang->line('EURO');?><?php echo $SpAmount?></div>
						</div>
				<?php 	} ?>
					</div>
					</div>
					<div class="row heightSpacer"> &nbsp;</div>
				</div>
			<!-- End-->
		</div>
		<?php } }?>
		</div>
		<?php } // End No Free stuff condition.
		else
		{ //Start Image Code for Free Stuff?>
		<div class="row heightSpacer"> &nbsp;</div>
		<div class="row rowHeight40">
		<div class="cell orng_lbl vTop"><?php echo $label['freeStuffImage']?></div>
		<div class="cell">
			<div class="table width100percent">
				<div class="row" >
					<div class="cell dblBorder projectImage">
					<?php if(!empty($productSellRecordSet)) {
						$sliderImages = getProductImages('ProductPromotionMedia','prodId',$productSellRecordSet['productId'],1);

							if(!empty($sliderImages)){
								$product['productImage'] = $sliderImages[0]->filePath.$sliderImages[0]->fileName;
							}else
							{
								$product['productImage'] = '';
							}
						}else
						{
							$product['productImage'] = '';
						}
					?>
						<img class="workProfileImage" src="<?php echo getImage($product['productImage']);?>" />
					</div>
					<div class="cell pl10">&nbsp;</div>
					</div>
			</div>
		</div>
    </div> 
	<div class="row heightSpacer"> &nbsp;</div>
<?php	}?>

</div>
<!--frm_wp-->
<script type="text/javascript">
	
	function calcelForm(productId,productType)
	{
		location.href=baseUrl+language+"/product/"+productType;
	}

</script>
