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
$save = array(
	'name'=>'save',
	'id'=>'save',
	'type'=>'hidden',
	'value'=>''
);

$productTitle = array(
	'name'	=> 'productTitle',
	'id'	=> 'productTitle',
	'class'	=> 'width556px required',
	'value'	=> $productTitle,
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
	'value'	=> set_value('productDescription',$productDescription),
	'class'	=> 'width546px',
	'style' => 'width:0;height:0;visibility:hidden',
	'wordlength'=>"5,500",
	'onkeyup'=>"getRemainingLen(this,500,'description')",
	'rows'	=> 30
);

$productCity = array(
	'name'	=> 'productCity',
	'id'	=> 'productCity',
	'value'	=> $productCity,
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 30
);

$productUrl = array(
	'name'	=> 'productUrl',
	'id'	=> 'productUrl',
	'value'	=> $productUrl,
	'class' => 'required ',
	'maxlength'	=> 100,
	'size'	=> 68
);

$productAdvert = array(
	'name'        => 'productAdvert',
	'id'          => 'productAdvert',
	'value'       => 't',
	'checked'     =>  $isPublished =='t'?FALSE:TRUE,
	'class'		  => 'formTip cell'
);

$productwillingToPayArr = array(
	'name'	=> 'productwillingToPay',
	'id'	=> 'productwillingToPay',
	'class'	=> ' required ',
	'value'	=> $productwillingToPay,
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 20
);

?>
<div class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php 
			if($catId==1) echo $label['productForSaleDescription'];
			if($catId==2) echo $label['productWantedDescription'];
			if($catId==3) echo $label['productFreeDescription'];			
			?></h1>
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
		
		if($this->uri->segment(3)=='freeStuff') 
			{
				 ?>
		<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $this->lang->line('projectUrl');?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<?php echo form_input($productUrl); ?>
		</div>
	</div><!-- row -->
	
		<?php 
	}
			$value=$productTagWords;
			$value=htmlentities($value);
			$data=array('name'=>'productTagWords','value'=>$value, 'view'=>'tag_words', 'required'=>'required');
			echo Modules::run("common/formInputField",$data);
					
			 //Old without editor 
			// $value=$productDescription;
			//$value=htmlentities($value);
			//$data=array('name'=>'productDescription','value'=>$value, 'view'=>'description', 'required'=>'required');
			//echo Modules::run("common/formInputField",$data);
		
			if($this->uri->segment(3)=='sell') { ?>
			<!-- Start product sell type radio option-->
			<?php $productSellType= set_value('productSellType')?set_value('productSellType'):@$productSellType;?>
			<div class="row">
				<div class="cell label_wrapper"> <label class="select_field"><?php echo 'Sell Type';?></label></div>
				<div class="cell frm_element_wrapper">
					<div class="row pt5">
						<div class="cell defaultP">
							<input type="radio" id="productSellType" name="productSellType" <?php if($productSellType==1 || empty($productSellType)) echo 'checked';?> value="1" />
						</div>
							
						<div class="cell mr8">
							<label class="lH25"><?php echo $this->lang->line('setPrice');?></label>
						</div>
						
						<div class="cell defaultP" onclick="$('#sellPriceCollection').hide();">
							<input type="radio" id="productSellTypeAuction" name="productSellType" <?php if($productSellType==2) echo 'checked';?> value="2" />
						</div>
						
						<div class="cell">
							<label class="lH25"><?php echo $this->lang->line('auction');?></label>
						</div>
					</div>	
				</div>
			</div>
		<!--End product sell type  radio option-->
		<?php } ?>
		
		<div class="row">
			<?php //echo $productDescription;?>
			<div class="label_wrapper cell">
				<label><?php echo $this->lang->line('furthrDescription'); ?></label>
			</div><!--label_wrapper-->
			<div class=" cell frm_element_wrapper NIC">
				<div id="myNicPane3" class="cell bdr_e2e2e2 tmailtop_gradient p15 width_536px"></div>
			<div id="myInstance3" class="editordiv frm_Bdr minHeight200px width_545" onblur="checktext();" style="position:relative;z-index:2;">
				<?php echo html_entity_decode($productDescription);?>
			</div>
			<?php echo isset($errors[$productDescriptionArr['name']])?$errors[$productDescriptionArr['name']]:''; ?>
			<div style="position:absolute; top:235px;z-index:1"><?php echo form_textarea($productDescriptionArr); ?>	</div>
			<?php echo form_error($productDescriptionArr['name']); ?>
			
			</div>
		
		</div>
		<div class="row seprator_15"></div>
		<?php /*<div class="row">
			<?php //echo $productDescription;?>
			<div class="label_wrapper cell">
				<label class="select_field" ><?php echo $this->lang->line('productDescription'); ?></label>
			</div><!--label_wrapper-->
			<div class=" cell frm_element_wrapper NIC">
				<div id="myNicPane3"></div>
				<div id="myInstance3"  class="editordiv formTip" onblur="checktext();" title="<?php echo $this->lang->line('productDescription');?>">
					<?php echo html_entity_decode($productDescription);?>
				</div>
				<?php echo isset($errors[$productDescriptionArr['name']])?$errors[$productDescriptionArr['name']]:''; ?>	
				<div id="productDescriptionErr" class="dn orange">Description field is required.</div>
				<?php echo form_textarea($productDescriptionArr); ?>
				<div id="productDescriptionErr" class="dn orange">Description field is required.</div>
			</div>
		
		</div>*/ ?>
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['productLanguage']; ?></label>
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
			$productLangattr = 'id="productLang" class="single dropDown"';
			echo form_dropdown($productLangName, $language, $productLangVal ,$productLangattr);
		?>
				
		</div>
		
	</div><!--from_element_wrapper-->
	<?php 
	if($this->uri->segment(3)=='freeStuff') 
	{ 
		$langTitleClass = "";
		$attr = 'id="productCountryId" class="single dropDown "';
	}
	else
	{
		 $langTitleClass = 'class="select_field"';
		 $attr = 'id="productCountryId" class="single dropDown  required"';
	}
	?>
	<div class="row">
		<div class="label_wrapper cell">
			<label <?php echo $langTitleClass;?>><?php echo $label['productLocation']; ?></label>
		</div><!--label_wrapper-->
		<?php
		if($mode =='edit')
			$productCountryIdVal = $productCountryId;
		else
			$productCountryIdVal = '';

		$productCountryIdName = "productCountryId";
		?>
		<div class="cell frm_element_wrapper">
			
		<?php 
		
		
		echo form_dropdown($productCountryIdName, $location, $productCountryIdVal ,$attr);	
		?>
				
		</div>
	</div><!--row-->
		
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $this->lang->line('twnRcity');?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($productCity); ?>
		</div>
	</div><!--row-->
		
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
				$productIndustryIdattr = 'id="productIndustryId" class="single dropDown required "';
				echo form_dropdown($productIndustryIdName, $industry, $productIndustryIdVal ,$productIndustryIdattr);
			?>				
		</div>
	</div><!--row-->
	
	<?php 
	
	if($this->uri->segment(3)=='freeStuff') 
	{ 
		echo '<div class="seprator_5 row"></div>';
		//Start Image Code for Free Stuff
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
		
		$img = '<img id="imgSrc" class="ma" src="'.getImage($product['productImage'],$this->config->item('defaultProductFree')).'">';
		
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
		$requiredImg = 0;
		echo Modules::run("mediatheme/promoImageForm",$label['freeStuffImage'],$img ,$fileUpload,$inputArray,0,0,$requiredImg);
	}
	echo form_hidden($save);
	
	?>
	
	<div class="row seprator_5"></div> 
<?php 


if($catId==2) 
	   {  ?> 	
	<div class="row">
	<div class="label_wrapper cell">
		<label class="select_field"><?php echo $label['indicativePrice'];?></label>
	</div><!--label_wrapper-->
	
	<div class="cell frm_element_wrapper width330px">
		<div class="cell mr15"  style="height:25px;"><?php echo form_input($productwillingToPayArr); ?></div>
	</div>
	
 </div>
	
	
	
<?php } 
// Changed this condtion as per client req need to hide this section from all product type
if($this->uri->segment(3)=='') 
	{ ?>	
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['review'];?></label>
		</div><!--label_wrapper-->
		
		
		<div class=" cell frm_element_wrapper">
			<div class="row">
				<?php $displaySearch=(isset($associatedReviewsElementId) && $associatedReviewsElementId > 0)?'dn':'';?>
				<div id="displaySearchInputDiv" class="cell search_box_wrapper <?php echo $displaySearch;?>">
					<input id="reviewsSearch" name="reviewsSearch" type="text" class="search_text_box formTip" title="<?php echo $this->lang->line('productLinkTip') ?>" value="<?php echo $this->lang->line('keywordSearch');?>" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
					<div class="search_btn ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/search/searchontoadsquare/',$('#reviewsSearch').val(),'reviews','reviewsSearch');">
						<img src="<?php echo base_url('images/btn_search_box.png');?>">
					</div>
				</div>
				
				<div id="reviewsSearchDiv" class="cell pt8 pl20 pr20 width200px"><?php echo @$reviewsElementTitle;?></div>
				 <?php
				 if(isset($associatedReviewsElementId) && @$associatedReviewsElementId > 0){
					 ?>
					 <div id="reviewsSearchRow" class="cell pt8">
						 <div  class="small_btn formTip " title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteAssociatedreviews('<?php echo $productId;?>')"><div class="cat_smll_plus_icon"></div></a></div>
					 </div>
					  <?php
				  }
				 ?>
				 
				<input id="reviewsSearchelementid_from" name="associatedReviewsElementId" type="hidden" value="0">
			</div>
	    </div>
	</div><!--from_element_wrapper-->
	<div class="clear"></div>	

	<div class="row">
		
		<div class="label_wrapper bg_none cell">
			<?php //echo $label['productAdvert']?>
		</div>
		
		<div class=" cell frm_element_wrapper lineHeight20px">
			<div class="row mt5">
			<div class="cell">
					<div class="cell defaultP" title="<?php echo $label['advertAfterSale']; ?>">
						<?php echo form_checkbox($productAdvert); ?> &nbsp;<?php echo $label['advertAfterSale']; ?>
					</div>
			</div>
					
		</div>
	</div>
		
		</div>
	
	
<?php }

/*$currentStatus=$isPublished=='t'?$this->lang->line('Publish'):$this->lang->line('hide');
$changeStatus=$isPublished=='t'?$this->lang->line('hide'):$this->lang->line('Publish');
$publisButton=array('currentStatus'=>$currentStatus,'changeStatus'=>$changeStatus,'isPublished'=>$isPublished,'tabelName'=>'Product','pulishField'=>'isPublished','field'=>'productId','fieldValue'=>$productId,'deleteCache'=>$this->router->fetch_method(), 'view'=>'publishUnpublish');
echo Modules::run("common/formInputField",$publisButton);*/
						
?>				
<div class="row">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
	
	<div class="cell frm_element_wrapper mt19 mb25">
		<div class="Req_fld cell"><?php echo $label['requiredFields']?></div><!--Req_fld-->
		<div class="frm_btn_wrapper padding-right0">
			<div class="tds-button Fleft"><button type="button" onclick="cancelForm('<?php echo $productType?>');" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft">Cancel</div><div class="icon-form-cancel-btn"></div></span> </button> </div>
			<div class="tds-button Fleft"> <button type="submit" id="submButton" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div> </span> </button>  </div>
			
		</div>
		<div class="row"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
		<!--Instruction add for  -->
		<?php if($this->uri->segment(3)=='sell') 
		{?>
			<div class="row makeShowcaseBetter"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('productSale1');?>&nbsp;<a href="<?php echo site_url(lang()).'/dashboard/globalsettings';?>"> Seller Settings</a>&nbsp;<?php echo $this->lang->line('productSale2');?></div></div>
		<? }
		 if(isset($productId) && !empty($productId) && $this->uri->segment(3)!='freeStuff'){?>
			<div class="row makeShowcaseBetter">
			<div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('makeShowcaseBetterMsgChange');?>
			<a href="<?php echo site_url(lang()).'/product/'.$this->uri->segment(3).'/'.$productId.'/promotional_image';?>" target="_blank">Promotional Material</a>.</div>
			</div>
		<?php }?>
		<div class="row makeShowcaseBetter">
			<div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('previewPublishInfoChange');?>
			<a href="<?php echo site_url(lang()).'/product/'.$this->uri->segment(3);?>" target="_blank">Index page</a>.</div>
		</div>
		
	</div>
	</div><!-- frm_element_wrapper -->
	
</div>
<?php echo form_close(); ?>
</div>

</div>
<?php
if($this->uri->segment(3)=='sell') 
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
	<div class="clear"></div>
<script type="text/javascript">
	
function deleteAssociatedreviews(productId){
	
	if(confirm(areYouSure)){
			var editdata = {"associatedReviewsElementId":0}; 
			var where = {"productId":productId}; 
			var del=AJAX('<?php echo base_url(lang()."/common/editDataFromTabel");?>','',editdata,'Product',where,'');	
			if(del){
				$('#reviewsSearchelementid_from').val(0);
				$('#reviewsSearchDiv').html('');
				$('#displaySearchInputDiv').show();
				$('#reviewsSearchRow').hide();
			}
	}
}

function checktext(){
	
	var sectionContent = $.trim($('#myInstance3').html());
	
	if( sectionContent == '' ||  sectionContent == '<br>'){
		$('#productDescription').text('');		 
	}
	else{
		$('#productDescription').text(sectionContent);		 
	}
}

	function cancelForm(productType)
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
				$('#productPrice').attr('class','fl price_input required number NumGrtrZero');
				$('#productPrice').removeAttr('disabled');
				$('#productPrice').removeAttr('readonly');
				$('#productSaleAfter').show();
				$('#sellerInfo').show();
				
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
				$('#productPrice').attr('class','fl price_input_disable');
				$('#productPrice').attr('disabled','disabled');
				$('#productPrice').attr('readonly','readonly');
				$("label[for=productPrice]").remove();
				$('#productSaleAfter').hide();
				$('#sellerInfo').hide();
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
			$('#productSaleAfter').show();
			$('#sellerInfo').show();
		}else
		{
			var sellType = $('#sellType').val();
			$('#productPrice').val('');
			if(sellType!=2) {
				$('#shippingDiv').css('display','none');
				$('#insideShipping').css('display','none');
			}
			$('#productSaleAfter').hide();
			$('#sellerInfo').hide();
		}
	});

	$(document).ready(function() {
		if($('#wnatedShipping').attr('checked'))	{
			$('#insideShippingWanted').css('display','block');
		}
	});
	
</script>

<script type="text/javascript">
	bkLib.onDomLoaded(function() {
		var myNicEditor = new nicEditor({buttonList : ['save','bold','italic','underline','left','center','right','justify','ol','ul']});
		myNicEditor.setPanel('myNicPane3');
		myNicEditor.addInstance('myInstance3');
});
</script>
