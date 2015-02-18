<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row form_wrapper">
<?php include('navigationMenu.php');?>
	<div class="row position_relative">	
		<?php 
			if(strcmp($location5,'promotional_image')!=0)
				echo Modules::run("common/strip"); 
				
			echo form_open('product/deleteProduct',"name='product'");
			echo form_hidden('productId','');
			echo form_hidden('productType','');
		
			if($products){
				echo "<div id='elementListingAjaxDiv' class='row'>";
				$this->load->view('product_listing' , array('products'=>$products) );
				echo "</div>";
			} //End IF for count If no record
			else { 
				if($productType=='freeStuff'){
					$sectionId=$this->config->item('productClassifiedFreeSectionId');
					$defaultImage = $this->config->item('defaultProductFree');
				}elseif($productType=='sell'){
					$sectionId=$this->config->item('productsSellSectionId');
					$defaultImage = $this->config->item('defaultProductForSale_s');
				}else{
					$sectionId=$this->config->item('productsSellSectionId');
					$defaultImage = $this->config->item('defaultProductWanted_s');
				}
				?>
				<div class="blog_box_wrapper">
					<div class="row">
						<div class=" cell width_200 Cat_wrapper">			
							<?php 
							echo Modules::run("common/imageSlider",'',0,$defaultImage);
							?>				
						</div>
					</div>			  
					<div class="cell width_488 margin_left_55 pr">
							<?php
							if($this->uri->segment(4)!='deletedItems'){
								
								$returnUrl='/product/'.$productType.'/0/description/';?>
									<div id="showContainer">
										<script>
												AJAX('<?php echo base_url(lang().'/package/getAvailableUserContainer');?>','showContainer','<?php echo $sectionId?>','<?php echo $returnUrl?>','1');
										</script>
									</div>
								<?php
							}else{
								 //echo "<span class='tac'>".$label['noRecordFound']."</span>";
							}
						?>
					</div>
				</div> <?php
			}
			echo form_close();
			?>
			
			
			<div class="clear"></div>
			<div class="clear seprator_10"></div>
		</div><!-- row position_relative -->
</div><!--row form_wrapper-->


<?php if($this->uri->segment(4)=='deletedItems'){echo '</div>';}?>

	<div class="clearfix"></div>
	<div class="productLightBoxWp" id="productLightBoxWp" style="display:none">
		<div id="close-postPreviewBox" class="tip-tr close-customAlert" original-title=""></div>
		<div class="productFormContainer" id="productFormContainer"></div>
	</div>
	<div class="videoLightBoxWp" id="videoLightBoxWp" style="display:none;">
		<div id="close-productVideoBox" class="tip-tr close-customAlert" original-title=""></div>
		<div class="productFormContainer1" id="productFormContainer1"></div>
	</div>
<?php
/* Product first save freeStuff popup Start*/
	$isShowProductPopup=$this->session->userdata('isShowProductPopup');
	if(isset($isShowProductPopup) && $isShowProductPopup==1){
		$this->session->unset_userdata('isShowProductPopup');
		$freeUrl['indexUrl'] = 'javascript:void(0)';
		$freeUrl['popupSection'] = 'product';
		$freeUrl['isFreeProduct'] = 1;
		$popup_media = $this->load->view('common/afterSavePopup',$freeUrl,true);
		?>
			<script>
				var popup_media = <?php echo json_encode($popup_media);?>;
				loadPopupData('popupBoxWp','popup_box',popup_media);
			</script>
		<?php
	}
/* Product first save freeStuff popup End*/
?>
<script language="javascript" type="text/javascript">
function DeleteAction(productId,productType)
{
	var conBox = confirm('<?php echo $this->lang->line('sureDelMsg')?>');
	if(conBox){
		document.product.productId.value = productId;
		document.product.productType.value = productType;
		document.product.submit();
	}else{
		return false;
	}
}

function previewProduct(productId,productType)
{
	location.href=baseUrl+language+"/product/previewProduct/"+productId+"/"+productType;
}

function playSlider(productId)
{
	location.href=baseUrl+language+"/product/playSlider/"+productId;
}

function DeletePermanentlyAction(productId,productType)
{
	var conBox = confirm('<?php echo $this->lang->line('sureDelMsg')?>');
	if(conBox){
		location.href=baseUrl+language+"/product/deletePermanently/"+productId+'/'+productType;
	}else{
		return false;
	}
}

function restoreRecord(productId,productType)
{
	var conBox = confirm('Are you sure to restore this record?');
	if(conBox){
		location.href=baseUrl+language+"/product/restoreRecord/"+productId+'/'+productType;
	}else{
		return false;
	}
}

</script>
