<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$deleteCache=$indusrty.'_'.$projectId.'_'.$userId;
	$formAttributes = array(
		'name'=>'updateProjectPrice',
		'id'=>'updateProjectPrice'
	);
	$seller_currency=LoginUserDetails('seller_currency');
	$seller_currency=($seller_currency>0)?$seller_currency:0;
	$currencySign=$this->config->item('currency'.$seller_currency);
	
	$projPrice=($LID->projPrice>0)?$LID->projPrice:0;
	$projDownloadPrice=($LID->projDownloadPrice>0)?$LID->projDownloadPrice:0;
	$projPpvPrice=($LID->projPpvPrice>0)?$LID->projPpvPrice:0;
	$projQuantity=($LID->projQuantity>0)?$LID->projQuantity:0;
	
	$projDownloadPriceInput = array(
		'name'	=> 'projDownloadPrice',
		'value'	=> $projDownloadPrice,
		'id'	=> 'projDownloadPrice',
		'type'	=> 'text',
		'onkeyup'=>"getDisplayPrice(this,'".$seller_currency."','#totalCommisionDownLoad','#displayPriceDownLoad')"
	);
	
	if($LID->isprojDownloadPrice=='t'){
		$projDownloadPriceInput['class']='fl price_input font_opensansSBold clr_666 NumGrtrZero required';
		$projDownloadPriceInput['min']='0.1';
		$IPDPC='checked';
	}else{
		$projDownloadPriceInput['class']='fl price_input_disable font_opensansSBold clr_666';
		$projDownloadPriceInput['readonly']='readonly';
		$IPDPC='';
	}
	
	$projPpvPriceInput = array(
		'name'	=> 'projPpvPrice',
		'value'	=> $projPpvPrice,
		'id'	=> 'projPpvPrice',
		'type'	=> 'text',
		'onkeyup'=> "getDisplayPrice(this,'".$seller_currency."','#totalCommisionPPV','#displayPricePPV')"
	);
	if($LID->isprojPpvPrice=='t'){
		$projPpvPriceInput['class']='fl price_input font_opensansSBold clr_666 NumGrtrZero required';
		$projPpvPriceInput['min']='0.1';
		$IPPVPC='checked';
	}else{
		$projPpvPriceInput['class']='fl price_input_disable font_opensansSBold clr_666';
		$projPpvPriceInput['readonly']='readonly';
		$IPPVPC='';
	}
	
	$projPriceInput = array(
		'name'	=> 'projPrice',
		'value'	=> $projPrice,
		'id'	=> 'projPrice',
		'type'	=> 'text',
		'onkeyup'=> "getDisplayPrice(this,'".$seller_currency."','#totalCommisionProduct','#displayPriceProduct')"
	);
	if($LID->isprojPrice=='t'){
		$projPriceInput['class']='fl price_input font_opensansSBold clr_666 NumGrtrZero required';
		$projPriceInput['min']='0.1';
		$IPPC='checked';
		$dn = '';
	}else{
		$projPriceInput['class']='fl price_input_disable font_opensansSBold clr_666';
		$projPriceInput['readonly']='readonly';
		$IPPC=''; 
		$dn = 'dn';
	}
	$projQuantityInput = array(
		'name'	=> 'projQuantity',
		'value'	=> $projQuantity,
		'id'	=> 'projQuantity',
		'type'	=> 'text',
		'class'	=> 'fl price_input font_opensansSBold clr_666 NumGrtrZero required'
	);
	
	
	$projId = array(
		'name'	=> 'projId',
		'type'	=> 'hidden',
		'id'	=> 'projId',
		'value'	=> $projectId
	);
	$projPriceDetails=getDisplayPrice($projPrice,$seller_currency);
	$projDownloadPriceDetails=getDisplayPrice($projDownloadPrice,$seller_currency);
	$projPpvPriceDetails=getDisplayPrice($projPpvPrice,$seller_currency);

echo form_open_multipart($this->uri->uri_string(),$formAttributes); ?>
	<div class="row">
		<div class="label_wrapper cell mt21">
			<label class="select_field"><?php echo $bottomPriceHeading; ?></label>
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
									<div class="cell price_trans_checkbox_wp">
										<div class="defaultP mt2 ml20 ">
											<input type="checkbox" name="isprojDownloadPrice" id="isprojDownloadPrice" ceckboxId="projDownloadPrice" <?php echo $IPDPC;?> value="t" price="<?php echo $projDownloadPrice;?>" class="readonly" />
										</div>
									</div>
									<div class="cell price_trans_heading text_alignL pl0 font_opensansSBold width_100"> <?php echo $this->lang->line('download');?> </div>
									<div class="cell font_opensansSBold ml60 width120px"> 
										<?php echo form_input($projDownloadPriceInput); ?>
									</div>
									<div class="cell font_opensansSBold ml26 widht_63 pt2 text_alignC" id="totalCommisionDownLoad">
										<?php echo $projDownloadPriceDetails['currencySign'].' '.$projDownloadPriceDetails['totalCommision']?>
									 </div>
									<div class="cell font_opensansSBold ml26 pt2 widht_72 clr_white text_alignR pr19 pl16" id="displayPriceDownLoad">
										<?php echo $projDownloadPriceDetails['currencySign'].' '.$projDownloadPriceDetails['displayPrice']?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php if(!($indusrty == 'filmNvideo' || $indusrty == 'educationMaterial')) $displayPPV='dn'; else $displayPPV='';?>
					<div class="row <?php echo $displayPPV;?>">
						<div class="fl">
							<div class="price_trans_wp">
								<div class="price_trans_checkbox_wp Fleft">
									<div class="defaultP mt2 ml20 ">
										<input type="checkbox" name="isprojPpvPrice" id="isprojPpvPrice" ceckboxId="projPpvPrice" <?php echo $IPPVPC;?> value="t" price="<?php echo $projPpvPrice;?>" class="readonly" />
									</div>
								</div>
								<div class="price_trans_heading text_alignL pl0 font_opensansSBold Fleft width_100"> <?php echo $this->lang->line('ppv');?> </div>
								<div class="font_opensansSBold ml60 width120px fl"> 
									<?php echo form_input($projPpvPriceInput); ?>
								</div>
								<div class="font_opensansSBold ml26 fl widht_63 pt2 text_alignC " id="totalCommisionPPV">
									<?php echo $projPpvPriceDetails['currencySign'].' '.$projPpvPriceDetails['totalCommision']?>
								</div>
								<div class="font_opensansSBold ml26 fl pt2 widht_72 clr_white text_alignR pr19 pl16" id="displayPricePPV">
									<?php echo $projPpvPriceDetails['currencySign'].' '.$projPpvPriceDetails['displayPrice']?>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="fl">
							<div class="price_trans_wp">
								<div class="price_trans_checkbox_wp Fleft">
									<div class="defaultP mt2 ml20 ">
										<input type="checkbox" name="isprojPrice" id="isprojPrice" ceckboxId="projPrice" <?php echo $IPPC;?> value="t" price="<?php echo $projPrice;?>" class="readonly" />
									</div>
								</div>
								<div class="price_trans_heading text_alignL pl0 font_opensansSBold Fleft width_100"> <?php echo $this->lang->line('product');?> </div>
								<div class="font_opensansSBold ml60 width120px fl"> 
									 <?php echo form_input($projPriceInput); ?>
								</div>
								<div class="font_opensansSBold ml26 fl widht_63 pt2 text_alignC" id="totalCommisionProduct">
									<?php echo $projPriceDetails['currencySign'].' '.$projPriceDetails['totalCommision']?>
								</div>
								<div class="font_opensansSBold ml26 fl pt2 widht_72 clr_white text_alignR pr19 pl16" id="displayPriceProduct">
									<?php echo $projPriceDetails['currencySign'].' '.$projPriceDetails['displayPrice']?>
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
				
				<div id="projectPricesError" class="row width_330 mt-14 dark_Grey dn">
					<?php echo $this->lang->line('chooseAtleastPrice');?>
				</div>
				
				<div class="row <?php echo $dn;?>" id="removeProduct">
					<div class="fl">
						<div class="price_trans_heading text_alignL pl20 font_opensansSBold cell"> <?php echo $this->lang->line('removeProductAfter');?> </div>
						<div class="font_opensansSBold ml30 cell"> 
								 <?php echo form_input($projQuantityInput); ?>
						</div>
						<div class="font_opensansSBold ml5 cell widht_63 pt2"><?php echo $this->lang->line('sale(s)');?></div>
					</div>
				</div>
			</div>
	</div>
	
	<div class="row">
		<div class="label_wrapper cell bg-non"></div>
		<div class=" cell frm_element_wrapper ">	
				<div class="row mt15 mr15">
					<?php echo form_input($projId);
						//$button=array('ajaxSave','buttonId'=>'Price');
						//echo Modules::run("common/loadButtons",$button); 
					 ?>
					 <div class="fr padding-right0 ">
						 <div class="tds-button Fleft"><button id="saveButtonPrice" type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('save'); ?></div> <div class="icon-save-btn"></div></span></button></div>
					</div>
					 
				</div>
		</div>
	</div>
<?php echo form_close(); ?>
	
<script>
	$(document).ready(function(){
		$("#updateProjectPrice").validate({
			submitHandler: function() {
				var projId = $('#projId').val();
				var isprojDownloadPrice =  (($('#isprojDownloadPrice').attr('checked')) ? 't' : 'f') ;
				var isprojPpvPrice = (($('#isprojPpvPrice').attr('checked')) ? 't' : 'f') ;
				var isprojPrice = (($('#isprojPrice').attr('checked')) ? 't' : 'f') ;
				if(isprojDownloadPrice=='t' || isprojPrice=='t' || isprojPpvPrice=='t') {
					$('#projectPricesError').hide();
				} else {
					$('#projectPricesError').show();
					return false;
				}
				var data = {"projDownloadPrice":$('#projDownloadPrice').val(),"projPpvPrice":$('#projPpvPrice').val(),"projPrice":$('#projPrice').val(),"isprojDownloadPrice":isprojDownloadPrice,"isprojPpvPrice":isprojPpvPrice,"isprojPrice":isprojPrice,"projQuantity":$('#projQuantity').val()}; 
				var returnFlag=AJAX('<?php echo base_url(lang()."/media/updateProjectPrice");?>','',data,projId,'<?php echo $deleteCache;?>');
				if(returnFlag){
					$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
					timeout = setTimeout(hideDiv, 5000);
				}
			 } 
		});
		
		$('#isprojPrice').click(function(){
			if($('#isprojPrice').is(':checked') === true) {
				$('#removeProduct').show();
				$('#projectPricesError').hide();
			}else{
				$('#removeProduct').hide();
			}
		});
		
		$('#isprojDownloadPrice').click(function(){
			if($('#isprojDownloadPrice').is(':checked') === true) {
				$('#projectPricesError').hide();
			}
		});
		
		$('#isprojPpvPrice').click(function(){
			if($('#isprojPpvPrice').is(':checked') === true) {
				$('#projectPricesError').hide();
			}
		});
		
		<?php if($LID->isprojPrice=='t'){?>
			$('#shippingList').show();
		<?php }?>
	});
</script>
