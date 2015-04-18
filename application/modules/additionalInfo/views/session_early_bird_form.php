<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
	//Ticket Category Defined in Config(head.php) File

	$seller_currency=LoginUserDetails('seller_currency');
	$seller_currency=($seller_currency>0)?$seller_currency:0;
	$currencySign=$this->config->item('currency'.$seller_currency);
	
	$configTicketCategory = $this->config->item('ticketCategory');
	$configTicketCategoryKey = array_keys($this->config->item('ticketCategory'));
	
	if(@$fillSessions['earlyBirdStatus']=='f')
		{
			$earlyBirdStatusTick = ''; 
			
		}
		else
		{
			$earlyBirdStatusTick = 'checked'; 
			
		}
		$earlyBirdCheckBox = array(
			'name'        => 'earlyBirdStatus',
			'id'          => 'earlyBirdStatus',
			'value'       => 'accept',
			'checked'     => $earlyBirdStatusTick,		
			'class' => '',
			'onclick'=>'earlyBird()'
			
		);
?>
<div id="earlyBirdComplete">
<div class="separator_25 clear"></div>

<div class="row">			
	<div class="label_wrapper cell">
		<div class="lable_heading"><h1><?php echo $label['early_bird_offer']; ?></h1></div>	
	</div><!--label_wrapper-->
	<div class="cell">	
		<div class="cell defaultP mt10 ml20"><?php echo form_checkbox($earlyBirdCheckBox);?></div>
		<div class="cell mt10"><?php echo $this->lang->line('earlyBirdMsg');?></div>
	</div>	 			 
</div> <!-- row -->

<div class="row line1 mr11"></div>
<div id="earlyBird">
<div class="row">
<?php 

$speStartDateDBValue='';
foreach ($masterTickets as $i => $masterTicketsObj) {
		if($speStartDateDBValue==''){
			//echo '<br />@@'.$masterTicketsObj->TicketCategoryId.':'.@$fillSessions['speStartDate'.$masterTicketsObj->TicketCategoryId];
			if((isset($fillSessions['speStartDate'.$masterTicketsObj->TicketCategoryId]) && @$fillSessions['speStartDate'.$masterTicketsObj->TicketCategoryId]!=''))
			$speStartDateDBValue = $fillSessions['speStartDate'.$masterTicketsObj->TicketCategoryId];
	}
}
foreach ($masterTickets as $i => $masterTicketsObj) {
	  	
		$speStartDateCheckBox = array(
			'name'        => 'speStartDateCheckBox[]',
			'id'          => 'speStartDateCheckBox'.$masterTicketsObj->TicketCategoryId,
			'value'       => 'accept',
			'checked'     => FALSE,
			'style'       => 'margin:10px'
		);
		
		$speEndDateCheckBox = array(
			'name'        => 'speEndDateCheckBox[]',
			'id'          => 'speEndDateCheckBox'.$masterTicketsObj->TicketCategoryId,
			'value'       => 'accept',
			'checked'     => FALSE,
			
		);
	
		$PriceScheduleIdDBValue = 0;
		
	
		$spePriceDBValue = (@$fillSessions['speStartPrice'.$masterTicketsObj->TicketCategoryId]!='')?@$fillSessions['speStartPrice'.$masterTicketsObj->TicketCategoryId]:'';
		
		//echo '<pre />';print_r($fillSessions);
		$speStartDate = array(
			'name'	=> 'speStartDate[]',
			'id'	=> 'speStartDate'.$masterTicketsObj->TicketCategoryId,
			'class'	=> 'BdrCommon date-input cat required',			
			'earlyBirdDate'=>'#sessiondate',
			'value'	=> @$speStartDateDBValue,
			'placeholder'	=> $label['selectDate'],			
			'maxlength'	=> 50,
			'size'	=> 25,
			'style'=> 'width:120px;',
			'readonly'=>'readonly',
			'disabled'=>'disabled',
			//"onblur"=>"changeClass('speStartPrice".$masterTicketsObj->TicketCategoryId."')"
		);
		$spePriceDBValue=(isset($spePriceDBValue) && $spePriceDBValue > 0)?$spePriceDBValue:0;
		
		$priceDetails=getDisplayPrice($spePriceDBValue,$seller_currency);
		
		$speStartPrice = array(
			'name'	=> 'speStartPrice['.$configTicketCategoryKey[$masterTicketsObj->TicketCategoryId-1].']',
			'id'	=> 'speStartPrice'.$masterTicketsObj->TicketCategoryId,
			'class'	=> 'fl price_input width120px width100px required NumGrtrZero cat special',
			'value'	=> $spePriceDBValue,
			'displayPrice'	=> $priceDetails['currencySign'].' '.$priceDetails['displayPrice'],
			'maxlength'	=> 50,
			'size'	=> 20,
			'style'=> 'width:65px;',
			'disabled'=>'disabled',
			'onkeyup'=>"getDisplayPrice(this,'".$seller_currency."','#totalCommisionSP".$masterTicketsObj->TicketCategoryId."','#displayPriceSP".$masterTicketsObj->TicketCategoryId."')"
		);
		//echo $PriceScheduleIdDBValue;
		?>
		<?php if($i==0){ ?>
		<div class="row">
			<div class="label_wrapper cell">				
				<label><?php echo $label['beforeFDate']; ?></label>			   
			</div><!--label_wrapper-->
			<div class="cell mt10"  style="width:10px">&nbsp;</div>
			<div class="cell defaultP mt10 ml10"></div>
			<div class="cell  minMaxWidth90px mt10">	<?php echo form_input($speStartDate); ?></div>
				<div class="cell widthSpacer10">&nbsp;</div>
				<div class="cell  mt18 ml40"><img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#<?php echo 'speStartDate'.$masterTicketsObj->TicketCategoryId;?>").focus();' />
				<div class="red"><?php echo form_error($speStartDate['name']); ?></div>
			</div>
			<div class="cell mt10"  style="width:15px">&nbsp;</div>
		  </div>
		<div class="row ">
			<div class="cell width_200">
				<div class="lable_heading">&nbsp;</div> 
			</div>
			<div class="font_opensansSBold ml78 fl width_85 orange_clr_imp mt-4 lineH16">&nbsp;</div>
				<div class="font_opensansSBold ml34 fl width_85 orange_clr_imp mt-4 lineH16">&nbsp;</div>
				<div class="font_opensansSBold ml72 fl width_85 orange_clr_imp mt-4 lineH16"> <?php echo $this->lang->line('tsCommision');?>  </div>
				<div class="font_opensansSBold ml24 fl pt5   clr_white text_alignR consumebg_top height_15"> <?php echo $this->lang->line('displayPrice');?> </div>
			<div class="clear"></div>
		</div>
		
		<?php } ?>
		<div <?php if($i>0) echo 'class="dn"'  ?> id="early<?php echo $masterTicketsObj->TicketCategoryId;?>">
		
		<?php if(strcmp('Free Tickets',$masterTicketsObj->Title)!=0) { 
			
			
			?>		
		
		<div class="row">
			<div class="label_wrapper cell height_24 ">
			  <label class="select_field_contav height_24 lineH24 label_bg_position"><?php echo $masterTicketsObj->Title; ?></label>
			</div>
			<div class=" cell frm_element_wrapper pt0 min_hauto">
			  <div class="consumebg">
				<div class="row">
				  <div class="fl">
					<div class="price_trans_wp">
					  <div class="font_opensansSBold ml5 fl width140px"> <?php echo form_input($speStartPrice);?> </div>
						<div class="font_opensansSBold  width150px fl"> &nbsp; </div>
						 <div class="font_opensansSBold ml60 fl widht_63 pt2 mr14" id="totalCommisionSP<?php echo $masterTicketsObj->TicketCategoryId;?>">
							<?php echo $priceDetails['currencySign'].' '.$priceDetails['totalCommision']?>
						 </div>
						 <div class="font_opensansSBold ml16 fl pt2 widht_72 clr_white text_alignR pr19 pl16" id="displayPriceSP<?php echo $masterTicketsObj->TicketCategoryId;?>">
							<?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice'];?>
						 </div>
					</div>
				  </div>
				</div>
				<div class="clear"> </div>
			  </div>
			</div>
			<div class="clear"></div>
		</div>	
		
	  <?php } ?>
	  </div>
	  
	  <?php if(count($masterTickets) == ($i+1)){ ?>
		<div class="row">
			<div class="cell width_200">&nbsp;</div>
			<div class="fl width_330 height_21">&nbsp;</div>
			<div class="font_opensansSBold ml24 fl width_85 height4 pt2">&nbsp;</div>
			<div class="font_opensansSBold ml26 fl pt2  widht_72 clr_white text_alignR pr19 pl16 consumebg_bottom">&nbsp;</div>
			<div class="clear"></div>
		</div>
		
		<?php } ?>
<?php

}

?>
</div><!-- End for early bird div -->
</div>
</div><!-- End for earlyBirdComplete div -->
<div class="seprator_25 clear row"></div>
<script>
<?php $earlyBirdValueId = (@$fillSessions['earlyBirdStatus'])?@$fillSessions['earlyBirdStatus']:0;?>

if('<?php echo $earlyBirdValueId;?>'=='t') $('#earlyBirdStatus').attr('checked','checked');
else $('#earlyBirdStatus').removeAttr('checked');
function earlyBird()	
{	
	if($("#earlyBirdStatus").is(':checked'))
		$("#earlyBird").show();		
	else
		$("#earlyBird").hide();	
}
earlyBird();
</script>
