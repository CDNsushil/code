<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formName='auctionBidForm';
$formAttributes = array(
	'name'=>$formName,
	'id'=>$formName
);

//Set price details as pr minimum bid price
$priceDetails = getDisplayPrice($minimumBidPrice,1); //Get price details
$topBidderRes = getBidderInfo($auctionId,1);
if(isset($topBidderRes) && !empty($topBidderRes)){
	$minBid = $topBidderRes;
} else {
	$minBid = $priceDetails['displayPrice']+1;
}

//$minBid = $priceDetails['displayPrice']+1;

$projectPriceInput = array(
	'name'	    => 'bidPrice',
	'id'	    => 'bidPrice',
	'value'	    => (isset($bidPrice) && $bidPrice !='') ?$bidPrice : '',
	'maxlength'	=> 50,
	'class'     => 'NumGrtrZero required mr10',
	'min'       => $minBid,
	'size'	    => 5,
	'type'	    => 'text',
);

$auctionIdInput = array(
	'name'	=> 'auctionId',
	'id'	=> 'auctionId',
	'value'	=>  $auctionId,
	'type'	=> 'hidden'
);

$bidIdInput = array(
	'name'	=> 'bidId',
	'id'	=> 'bidId',
	'value'	=>  (isset($bidId) && $bidId !='') ?$bidId : 0,
	'type'	=> 'hidden'
);

$minBidPriceInput = array(
	'name'	=> 'minimumBidPrice',
	'id'	=> 'minimumBidPrice',
	'value'	=> $priceDetails['displayPrice'],
	'type'	=> 'hidden'
);

//Get top bidding info
$bidderList = getBidderInfo($auctionId,5);?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
	<div class="popup_gredient ">
		<div id="auctionBidFormDiv" class="width_566">
			<div class="row">
				<div class="cell join_heading ml18 mr2 pt1 width_157 text_alignR"><?php echo ""; ?></div>
				<div class="cell font_opensans font_size20 pt20 bdr_Borange height_16 width_366">
					<div class="clr_666 pl20"><?php echo $Title; ?></div>
			</div>
            <div class="clear"></div>
		</div>
		<div class="seprator_15"></div>
		<!-- Div shows the end date and base price-->
		<div class="fr font_opensans mr20">
			<div class="row">
				<div class="cell font_size15 width75px"><?php echo $this->lang->line('basePrice'); ?></div>
				<div class="cell"><?php echo ': '.$currencySign.$priceDetails['displayPrice']; ?></div>
			</div>
			<div class="row">
				<div class="cell font_size15 width75px"><?php echo $this->lang->line('auctionEndDate'); ?></div>
				<div class="cell"><?php echo ': '.date("d F Y",strtotime($auctioEndDate));?></div>
			</div>
		</div>
		<!-- Div shows the end date and base price-->
		<?php
		if(isset($bidderList) && !empty($bidderList)){ ?>
			<div class="row">
				<div class="cell join_heading pt10 width_157 ml35 text_alignL"><?php echo $this->lang->line('topBidList'); ?></div>
			</div>
            <div class="clear seprator_10"></div>
            <?php
			foreach ($bidderList as $bidData){ 
				//Get users showcase details
				$getUserShowcase = showCaseUserDetails($bidData->userId);
				//Set users image
				$userDefaultImage=($getUserShowcase['creative']=='t')?$this->config->item('defaultCreativeImg'):(($getUserShowcase['associatedProfessional']=='t')?$this->config->item('defaultAssProfImg'):(($getUserShowcase['enterprise']=='t')?$this->config->item('defaultEnterpriseImg'):''));
				if($getUserShowcase['userImage']!='') {
					$userImage=$getUserShowcase['userImage'];
				}
				$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
				$userImage=getImage($userImage,$userDefaultImage);
				?>
				<div id="showBidList">
					<div class="widht545px"> 
						<div id="pagingContent">				
							<a href="<?php echo site_url(lang()).'/showcase/index/'.$bidData->userId;?>" target="_blank" >
								<div class="search_result_list_wrapper  ml35 mb10 minH60 widht490px">
									<div class="bg_white pt2 pb2 pl2 pr2 pr">
										<div class="bg_3e3e3e minH60">
											<div class="fl width60px bdrR_fff height_60">
												<div class="cell ml20 mt10 thumb_absolute01">
													<div class="AI_table">
														<div class="AI_cell"> 
															<img class="mH30 bdr_cecece max_w34_h41" src="<?php echo $userImage;?>">
														</div>
													</div>
												</div>
											</div>
											<div class="fl width385px ml5">
												<div class="bdr_f15921 font_opensansSBold clr_white ml12 mr17 pt3 pb3">
													<div class="fl font_size14 width250px"><?php echo $getUserShowcase['userFullName']?></div>
													<div class="fr font_size12"><?php echo $currencySign.$bidData->price;?></div>
													<div class="clear"></div>
												</div>
												<div class="font_opensansSBold clr_white ml12 mr17 pt3 pb3 lH14">
													<div class="fl font_size12 width250px"><?php echo date("d-m-Y",strtotime($bidData->modifiedDate));?><br/><?php echo date("h:i A",strtotime($bidData->modifiedDate)); ?></div>
													<div class="fr font_size12"></div>
													<div class="clear"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>						
						</div>
					</div>
					<div class="clear"></div>
				</div>
			<?php
			}
		}
		echo form_open(base_url(lang().'/auction/setProductBid'),$formAttributes);
		echo form_input($minBidPriceInput); 
		echo form_input($auctionIdInput); 
		echo form_input($bidIdInput); 
		?>
		<div class="row">
			<div class="cell join_heading ml35 mr2 pt10 text_alignR"><?php echo $this->lang->line('setYourBid'); ?></div>
		</div>
		<div class="clear"></div>
		<div class="position_relative">
			<div class="cell shadow_wp strip_absolute left_170">
				<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr>
						<td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
					</tr>
					<tr>
						<td class="shadow_mid_small">&nbsp;</td>
					</tr>
					<tr>
						<td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
					</tr>
				  </tbody>
				</table>
				<div class="clear"></div>
			</div>
			<div class="seprator_15"></div>
		  
			<div class="row">
				<div class="join_label_wrapper cell">
					<label class="req_field"><?php echo $this->lang->line('bidPrice'); ?></label>
				</div>
			
				<div class=" cell join_frm_element_wrapper pt10">
					<?php echo $currencySign;?>
					<?php echo form_input($projectPriceInput); ?>
					<div class="dn dark_Grey" id="priceError"><?php echo $this->lang->line('minPriceError');?></div>
				</div>
			
				<div class="clear"></div>
			</div>
			<div class="row">
				<div class="join_label_wrapper cell"> </div>
				<div class=" cell join_frm_element_wrapper ml6">
					<div class="Req_fld font_opensansSBold font_size12 mt10 "> <?php echo $this->lang->line('requiredFields'); ?> </div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="seprator_10"></div>
		<div class="row">
			<?php 
			if($tdsUid==$loggedUserId) { //show alert if product owner and bid user are same
				$beforeBidProduct = "You must be logged in to bid a product";
				$canNotBid = $this->lang->line('Youcannotbidfromyourself');
				$functionBidProject = "if(checkIsUserLogin('".$beforeBidProduct."')){customAlert('".$canNotBid."')}";
			} else { //submit form is users are diffrent
				$functionBidProject = "$('#auctionBidForm').submit();";
			}
			?>
			<div class="tds-button Fright mr35 parent">   
				<button type="button" onclick="<?php echo $functionBidProject ?>" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span class="orange_clr_imp font_opensans"><div class="Fleft"><?php echo $this->lang->line('suggestionSubmit');?></div> <div class="icon-publish-btn"></div></span> </button>
			</div>
		 
			<div class="tds-button Fright mr10"> 
				<button type="button" onclick="javascript:$(this).parent().trigger('close');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span><div class="Fleft"><?php echo $this->lang->line('close');?></div> <div class="icon-form-close-btn"></div> </span></button> 
			</div>
			<div class="clear"></div>
		</div>
		<?php echo form_close(); ?>       
        <div class="seprator_15 clear"></div>  
    </div>
</div>
<script>
	$(document).ready(function(){
		$("#auctionBidForm").validate({
			submitHandler: function() {
				/*var minimumBidPrice = $('#minimumBidPrice').val();
				var bidPrice        = $('#bidPrice').val();
				if(Number(bidPrice)<=Number(minimumBidPrice)) {
					$('#priceError').show();
					$('#bidPrice').addClass('error');
					return false;
				}*/
					
				$('#searchResultDiv').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading.gif" />');
				var fromData=$("#auctionBidForm").serialize();
				$.post(baseUrl+language+'/auction/postBidPrice',fromData, function(data) {
					if(data){
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						refreshPge();
					}
				},"json");
			}
		});
		
		//Check bid price compare with min bid price
		/*$('#bidPrice').change(function(){
			var minimumBidPrice = $('#minimumBidPrice').val();
			var bidPrice        = $('#bidPrice').val();
			if(Number(bidPrice)<=Number(minimumBidPrice)) {
				$('#bidPrice').addClass('error');
				$('#priceError').show();	
			}
		});*/
		
		//hide price error on get price val
		$('#bidPrice').keypress(function() {
			$('#priceError').hide();
		});
	});
	
	$('.parent').hover(function(){
	$(this).find('.orange_clr_imp').toggleClass('gray_color')
	});
</script>
