<?php 
$data = array();
if($mode=='edit'){

$shippingDetail= json_decode($productShipment);

$shippingCheckboxArray = array();
$shippingCountryArray = array();
$productShipmentArray = array();

$shippingDetailArray = object2array($shippingDetail);
}
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>


<?php
$formAttributes = array(
	'name'=>'customForm',
	'id'=>'customForm'
);

$productTitle = array(
	'name'	=> 'productTitle',
	'id'	=> 'productTitle',
	'class'	=> 'width556px required',
	'value'	=> $productTitle,
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$productOneLineDescArr = array(
	'name'	=> 'productOneLineDesc',
	'id'	=> 'productOneLineDesc',
	'class'	=> 'width556px heightAuto rz required',
	'title'=>  $label['project_logLineDescription'],
	'value'	=> $productOneLineDesc,
	'wordlength'=>"5,30",
	'onkeyup'=>"getRemainingLen(this,30,'descriptionLimit')",
	'rows'	=> 1
);

$productTagWordsArr = array(
	'name'	=> 'productTagWords',
	'id'	=> 'productTagWords',
	'class'	=> 'width556px heightAuto rz required',
	'title'=>  $label['project_tags'],
	'wordlength'=>"5,50",
	'onkeyup'=>"getRemainingLen(this,50,'tagLimit')",
	'value'	=> $productTagWords,
	'rows'	=> 5
);

$productDescriptionArr = array(
	'name'	=> 'productDescription',
	'id'	=> 'productDescription',
	'class'	=> 'width556px heightAuto rz required',
	'title'=>  $label['productDescription'],
	'wordlength'=>"5,50",
	'onkeyup'=>"getRemainingLen(this,50,'description')",
	'value'	=> $productDescription,
	'placeholder'	=> $label['productDescription'],
	'rows'	=> 5
);

$productReview = array(
	'name'	=> 'productReview',
	'id'	=> 'productReview',
	'class'	=> 'width246px formTip cell',
	'title'=>  $label['productReviewLink'],
	'value'	=> $productReview,
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);


?>
<div class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $label['productInformation']?></h1>
		</div>
		<?php echo $header;?>
			
<?php
	echo form_open_multipart('product/addMoreInformation/'.$productId.'/'.$productType,$formAttributes);
	echo form_hidden('productId',$productId);
	echo form_hidden('tdsUid',$tdsUid);
	echo form_hidden('mode',$mode);
	echo form_hidden('productArchived','f');
	echo form_hidden('catId',$catId);
?>

	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['project_title'];?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($productTitle); ?>
			<?php echo form_error($productTitle['name']); ?>
		</div>
	</div><!--from_element_wrapper-->
		<?php 
			$value=$productOneLineDesc;
			$value=htmlentities($value);
			$data=array('name'=>'productOneLineDesc','value'=>$value, 'view'=>'oneline_description', 'required'=>'required');
			echo Modules::run("common/formInputField",$data);
		?>
		<?php 
			$value=$productTagWords;
			$value=htmlentities($value);
			$data=array('name'=>'productTagWords','value'=>$value, 'view'=>'tag_words', 'required'=>'required');
			echo Modules::run("common/formInputField",$data);
		?>
		<?php 
			$value=$productDescription;
			$value=htmlentities($value);
			$data=array('name'=>'productDescription','value'=>$value, 'view'=>'description', 'required'=>'required');
			echo Modules::run("common/formInputField",$data);
		?>
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['productReviewLink'];?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($productReview); ?>
		
			<div class="cell">
				<img src="<?php echo base_url().'images/Search.png'?>" style="margin: 5px 5px 5px 15px; cursor:pointer" class="formTip" title="Search Review from Toadsquare"/>
			</div>
		</div>
		<?php echo form_error($productReview['name']); ?>
	</div><!--from_element_wrapper-->
	
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['productLanguage']; ?></label>
		</div><!--label_wrapper-->
		<?php
		$productLangName = "productLang";
		if($mode =='edit')
			$productLangVal = $productLang;
		else
			$productLangVal = '';
		?>
		<div class=" cell frm_element_wrapper">
			
					<?php 
						$productLangattr = 'id="productLang" class="single dropDown required height25"';
						echo form_dropdown($productLangName, $language, $productLangVal ,$productLangattr);
					?>
				
		</div>
	</div><!--from_element_wrapper-->
	<div class="seprator_5 row"></div>
	
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['productIndustry']; ?></label>
		</div><!--label_wrapper-->
		<?php
		if($mode =='edit')
			$productIndustryIdVal = $productIndustryId;
		else
			$productIndustryIdVal = '';

		$productIndustryIdName = "productIndustryId";
		?>
		<div class=" cell frm_element_wrapper">			
			<?php
				$productIndustryIdattr = 'id="productIndustryId" class="single dropDown required height25"';
				echo form_dropdown($productIndustryIdName, $industry, $productIndustryIdVal ,$productIndustryIdattr);
			?>				
		</div>
	</div><!--from_element_wrapper-->
	<div class="seprator_5 row"></div>
	
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['productLocation']; ?></label>
		</div><!--label_wrapper-->
		<?php
		if($mode =='edit')
			$productCountryIdVal = $productCountryId;
		else
			$productCountryIdVal = '';

		$productCountryIdName = "productCountryId";
		?>
		<div class="cell frm_element_wrapper">
			
					<?php $attr = 'id="productCountryId" class="single dropDown  required height25"';
					echo form_dropdown($productCountryIdName, $location, $productCountryIdVal ,$attr);	?>
				
		</div>
	</div><!--from_element_wrapper-->
		
	<div class="seprator_5 row"></div>

	<?php 
	
	if($this->uri->segment(3)=='freeStuff') 
	{ //Start Image Code for Free Stuff
		 if($mode='edit') 
		 {
			$sliderImages = getProductImages('ProductPromotionMedia','prodId',$productId,1);
			if(!empty($sliderImages)){
				$product['productImage'] = $sliderImages[0]->filePath.$sliderImages[0]->fileName;
			}else{
				$product['productImage'] = '';
			}
		} 
		else {
			$product['productImage'] = '';
		}
		
		$img = '<img id="imgSrc" class="ma" src="'.getImage($product['productImage']).'">';
		
		$fileUpload = array(
			'name'	=> 'userfile',
			'class'	=> 'formTip btn_browse',
			'title'=>  'Upload Image file',
			'value'	=> '',
			'accept'=> $this->config->item('imageAccept'),
			'onchange'=> "$('#fileInput').val(this.value)",
			'onmousedown'=> "mousedown_tds_button(getElementById('browse_btn'));",
			'onmouseup'=> "mouseup_tds_button(getElementById('browse_btn'));"
		);

		$inputArray = array(
			'name'	=> 'fileInput',
			'class'	=> 'width300px fl',
			'value'	=> '',
			'id'	=> 'fileInput',
			'type'	=> 'text',
			'readonly' => true
		);
		
		echo Modules::run("mediatheme/promoImageForm",$label['freeStuffImage'],$img ,$fileUpload,$inputArray,0);
	}
	echo form_hidden('save','Save');
	
	?>
	<div class="clear"></div>	
    <div class="seprator_27 row"></div>
    <div class="row">
		<div class="label_wrapper cell bg-non">
	</div><!--label_wrapper-->
	<div class="cell frm_element_wrapper">
		<div class="Req_fld cell"><?php echo $label['requiredFields']?></div><!--Req_fld-->
		<div class="frm_btn_wrapper padding-right0">
				 <div class="tds-button Fleft"> <button type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div> </span> </button>  </div>
				 <div class="tds-button Fleft"><button type="button" onclick="calcelForm('<?php echo $productType?>');" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft">Cancel</div> <div class="icon-publish-btn"></div></span> </button> </div>
				<div class="seprator_5 cell"></div>
			</div>
	</div><!-- frm_element_wrapper -->
	</div>
</div>
<?php echo form_close(); ?>
</div>
</div>
<?php
if($this->uri->segment(3)!='freeStuff') 
	{ 
		 
		if($mode =='edit')
		{
			$data['shippingCountryArray'] = object2array($shippingDetailArray['shippingCountry']);
			$data['productShipmentArray'] = object2array($shippingDetailArray['shippingPrice']);
		}
		?>
		<div class="row seprator_5"> &nbsp;</div>
		<?php
		if($this->uri->segment(3)=='sell')
		{
			$this->load->view('shippingInfoSale',$data); 
		}
		else 
		{
			$this->load->view('shippingInfoWanted',$data); 
		}
	}// End No Free stuff condition.
	?>
<script type="text/javascript">
	function calcelForm(productType)
	{
		location.href=baseUrl+language+"/product/"+productType;
	}
	
	function checkboxEvent(checkboxValue)
	{
		if(checkboxValue=='product')
		{
			
			if ($('#product').attr('checked')) {
			//alert(test());
			
				$('#shippingDiv').css('display','block');
				$('#insideShipping').css('display','block');
				//Commented for adding number validation
				//$('#productPrice').attr('class','price_input required  NumGrtrZero');
				$('#productPrice').attr('class','price_input required number NumGrtrZero');
				$('#productPrice').removeAttr('disabled');
				$('#productPrice').removeAttr('readonly');
			}else
			{
			//alert($("input[type=checkbox]:checked").size());
				var checkCount = $('#mySpan').html();
				for(var i =0;i<=checkCount; i++)
				{
				//alert('#removeID_'+i)
					$('#removeID_'+i).remove();
					//$('#mySpan').html('');
				}
				$('#shipping_count').html('0');
				$('#shippingDiv').css('display','none');
				$('#insideShipping').css('display','none');
				$('#productPrice').removeClass('required number NumGrtrZero');
				$('#productPrice').attr('class','price_input_disable');
				$('#productPrice').val('');
				$('#productPrice').attr('disabled','disabled');
				$('#productPrice').attr('readonly','readonly');
			}
		}
		
		if(checkboxValue=='download')
		{
			if ($('#download').attr('checked')) {
				$('#productDownloadPrice').removeAttr('disabled');
			}else
			{
				$('#productDownloadPrice').attr('disabled','disabled');
			}
		}
	}

	$(document).ready(function() {
		if($('#download').attr('checked'))
		{
			$('#productDownloadPrice').removeAttr('disabled');
		}
		if($('#product').attr('checked'))
		{
			$('#productPrice').removeAttr('disabled');
			$('#productPrice').removeAttr('readonly');
			$('#shippingDiv').css('display','block');
			$('#insideShipping').css('display','block');
		}else
		{
			$('#productPrice').val('');
			$('#shippingDiv').css('display','none');
			$('#insideShipping').css('display','none');
		}
	});

	$(document).ready(function() {
		if($('#wnatedShipping').attr('checked'))
		{
			$('#insideShippingWanted').css('display','block');
		}
	});
</script>

