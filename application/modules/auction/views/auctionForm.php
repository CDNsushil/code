<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$seller_currency=LoginUserDetails('seller_currency');
$seller_currency=($seller_currency>0)?$seller_currency:0;
$currencySign=$this->config->item('currency'.$seller_currency);

//Get users auction record
$where = array('projectId'=>$projectId,'entityId'=>$entityId,'elementId'=>$elementId);
$auctionRes = getDataFromTabel('Auction','*',  $where, '','', '', 1 );

//Set all auction values if auction record exists
if(isset($auctionRes ) && is_array($auctionRes) && count($auctionRes)>0) {
	$auctionId  = $auctionRes[0]->auctionId;
	$projectId  = $auctionRes[0]->projectId;
	$entityId   = $auctionRes[0]->entityId;
	$elementId  = $auctionRes[0]->elementId;
	$auctionEndDate = $auctionRes[0]->endDate;
	$auctionStartDate = $auctionRes[0]->startDate;
	$minimumBidPrice = $auctionRes[0]->minBidPrice;
}

//Set form fields for auction form
$formAttributes = array(
	'name'=>'auctionForm',
	'id'=>'auctionForm'
);

if(isset($auctionStartDate) && !empty($auctionStartDate)) $auctionStartTime = date("d F Y", strtotime(substr(@$auctionStartDate,0,-9)));
$auctionStartDateInput = array(
	'name'	=> 'auctionStartDate',
	'id'	=> 'auctionStartDate',
	'class' => 'now-date-input  required width_196',
	'value'	=> @$auctionStartTime,	
	'readonly' =>true
);

if(isset($auctionEndDate) && !empty($auctionEndDate)) $auctionEndTime = date("d F Y", strtotime(substr(@$auctionEndDate,0,-9)));
$auctionEndDateInput = array(
	'name'	=> 'auctionEndDate',
	'id'	=> 'auctionEndDate',
	'class' => 'now-date-input  required width_196',
	'value'	=> @$auctionEndTime,	
	'readonly' =>true
);

$isStartDateErrorInput = array(
	'name'	=> 'isStartDateError',
	'id'	=> 'isStartDateError',	
	'value'	=> 0,	
	'type' =>'hidden'
);

$isEndDateErrorInput = array(
	'name'	=> 'isEndDateError',
	'id'	=> 'isEndDateError',	
	'value'	=> 0,	
	'type' =>'hidden'
);

$minimumBidPrice = (isset($minimumBidPrice) && $minimumBidPrice > 0)? $minimumBidPrice:'';
$minimumBidPriceInput = array(
	'name'	=> 'minimumBidPrice',
	'id'	=> 'minimumBidPrice',
	'value'	=> $minimumBidPrice,
	'maxlength'	=> 50,
	'class'	=> 'fl price_input font_opensansSBold clr_666 NumGrtrZero required width125px ml-3',
	'size'	=> 5,
	'type'	=> 'text',
	'onkeyup'=> "getDisplayPrice(this,'".$seller_currency."','#totalCommisionProduct','#displayPriceProduct')"
);

$projectIdHidden = array(
	'name'	=> 'projectId',
	'type'	=> 'hidden',
	'id'	=> 'projectId',
	'value'	=> $projectId
);

$entityIdHidden = array(
	'name'	=> 'entityId',
	'type'	=> 'hidden',
	'id'	=> 'entityId',
	'value'	=> $entityId
);

$auctionId = (isset($auctionId) && $auctionId > 0)? $auctionId:0;
$auctionIdHidden = array(
	'name'	=> 'auctionId',
	'type'	=> 'hidden',
	'id'	=> 'auctionId',
	'value'	=> $auctionId
);

$elementIdHidden = array(
	'name'	=> 'elementId',
	'type'	=> 'hidden',
	'id'	=> 'elementId',
	'value'	=> $elementId
);

$sellTypeHidden = array(
	'name'	=> 'sellType',
	'type'	=> 'hidden',
	'id'	=> 'sellType',
	'value'	=> $productSellType
);

//Get price details as pr minimum bid price
$priceDetails=getDisplayPrice($minimumBidPrice,$seller_currency);?>

<?php echo form_open_multipart($this->uri->uri_string(),$formAttributes); ?>	
	<!--Start row for auction start date-->
	<div class="row">
		<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('auctionStartDate');?></label></div>
		<div class="cell frm_element_wrapper" >
			<div class="cell">
				<?php echo form_input($auctionStartDateInput);
					  echo form_input($isStartDateErrorInput);
				 ?>
				 <div id="startDateError" class="dn dark_Grey" ></div>
			</div>
			<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#auctionStartDate").focus();' /> </div>
		</div>
	</div>
	<!--End row of auctions start date-->
	
	<!--Start row for auction end date-->
	<div class="row">
		<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('auctionEndDate');?></label></div>
		<div class="cell frm_element_wrapper" >
			<div class="cell">
				<?php echo form_input($auctionEndDateInput);
				      echo form_input($isEndDateErrorInput); ?>
				<div id="endDateError" class="dn dark_Grey" ></div>
			</div>
			<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#auctionEndDate").focus();' /> </div>
		</div>
	</div>
	<!--End row of auctions end date-->
	
	<!--Start row for minimum bid price -->
	<div class="row">
		<div class="cell label_wrapper height_60"><label class="select_field mt22"><?php echo $this->lang->line('minimumBidPrice');?></label></div>
		<div class=" cell frm_element_wrapper ">			
			<div class="row">
				<div class="fl width185px height_21"> </div>
				<div class="font_opensansSBold ml26 fl widht_63 orange_clr_imp mt-4 lineH16"> <?php echo $this->lang->line('tsCommision');?> </div>
				<div class="font_opensansSBold ml26 fl pt5  clr_white text_alignR consumebg_top height_15"> <?php echo $this->lang->line('displayPrice');?> </div>
				<div class="clear"></div>
			</div>
			<div class="consumebg ml-145">
				<div class="row">
					<div class="fl">
						<div class="price_trans_wp ml148 width_402">
							<div class="row">
								<div class="cell font_opensansSBold ml5 width172px"> 
									 <?php echo form_input($minimumBidPriceInput); ?>
								</div>
								<div class="cell font_opensansSBold ml26  widht_63 pt2 text_alignC" id="totalCommisionProduct">
									<?php echo $priceDetails['currencySign'].' '.$priceDetails['totalCommision']?>
								</div>
								<div class=" cell font_opensansSBold ml26  pt2 widht_72  text_alignR clr_white pr19" id="displayPriceProduct">
									<?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice']?>
								</div>
								<div class=" cell consumebg">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"> </div>
			</div>		
			<div class="row">
					<div class="fl width185px height_21"> </div>
					<div class="font_opensansSBold ml26 fl widht_63 height4 pt2"> </div>
					<div class="font_opensansSBold ml26 fl pt2 consumebg widht_72 clr_white text_alignR pr19 pl16 consumebg_bottom"> </div>
					<div class="clear"></div>
				</div>
		</div>
	</div>
	<!--End row of minimum bid price-->
	
	<div class="row" >
		<div class="label_wrapper cell bg-non"></div>
		
		<div class=" cell frm_element_wrapper ml-15">
			<div class="cell f11 pt10 pl20"></div>
			<?php
			//Set hidden input fields
			echo form_input($projectIdHidden);
			echo form_input($elementIdHidden);
			echo form_input($entityIdHidden);
			echo form_input($auctionIdHidden);
			echo form_input($sellTypeHidden);
			
			//load auction save button
			//$button=array('save');
			//echo Modules::run("common/loadButtons",$button); 
		 ?>
			<div class="fr padding-right0 ">
				<div class="tds-button Fleft">
					<button type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover" style="background-position: 0px -38px; ">
						<span style="background-position: 100% -38px; ">
							<div class="Fleft"><?php echo $this->lang->line('save');?></div> 
							<div class="icon-save-btn"></div>
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>	
<?php echo form_close();?>	

<script>
	
	$(document).ready(function(){
		
		//Set calender for future dates
		$( ".now-date-input" ).datepicker({ minDate: '0' });
	
		//Manage auction form submission 
		$("#auctionForm").validate({
			submitHandler: function() {
				var isStartDateError = $('#isStartDateError').val();
				var isEndDateError = $('#isEndDateError').val();
				if(isStartDateError==1) {
					$('#auctionStartDate').addClass('error');
					return false;
				} else if(isEndDateError==1) {
					$('#auctionEndDate').addClass('error');
					return false;
				}
				var fromData=$("#auctionForm").serialize(); 	
				$.post('<?php echo base_url(lang()."/auction/setAuctionData");?>',fromData, function(data) {
					if(data){
						$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('priceSuccessMsg');?></div>');
						timeout = setTimeout(hideDiv, 5000);
						refreshPge();
					}
				});
			}
		});
	
		//Manage start date of auction form
		$(document).on('change','#auctionStartDate',function() {
			var startDate = $('#auctionStartDate').val();
			var endDate     = $('#auctionEndDate').val();
			
			var d1 = Date.parse(startDate +' 12:20:44 +0000')/1000;
			var d2 = Date.parse(endDate +' 12:20:44 +0000')/1000;

			if(d1 >= d2 && endDate!='') {
				$('#startDateError').show();
				$('#startDateError').text('Start date must be before the end date.');
				$('#auctionStartDate').addClass('error');
				$('#isStartDateError').val(1);
			}else{
				$('#startDateError').hide();
				$('#isStartDateError').val(0);
				$('#endDateError').hide();
				$('#isEndDateError').val(0);
				$('#auctionEndDate').removeClass('error');
			}
		});
		
		//Manage end date of auction form
		$('#auctionEndDate').change(function() {
			var startDate = $('#auctionStartDate').val();
			var endDate = $('#auctionEndDate').val();
			var d1 = Date.parse(startDate +' 12:20:44 +0000')/1000;
			var d2 = Date.parse(endDate +' 12:20:44 +0000')/1000;
			if(d1 >= d2) {
				$('#endDateError').show();
				$('#endDateError').text('End date must be after the start date.');
				$('#auctionEndDate').addClass('error');
				$('#isEndDateError').val(1);
			}else{
				$('#startDateError').hide();
				$('#isStartDateError').val(0);
				$('#auctionStartDate').removeClass('error');
				$('#endDateError').hide();
				$('#isEndDateError').val(0);
			}
		});
	});
</script>
