<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
$mediaMembershipForm = array(
	'name'=>'mediaMembership',
	'id'=>'mediaMembership'
);
$containerPriceCharged = 0;
$spacePrice = $this->config->item('defaultPrice_per_unitofStorageSpace_paidMember_EURO');
$spacePriceString = $this->config->item('defaultPrice_per_unitofStorageSpace_paidMember');
$defaultUnitofStorageSpace = $this->config->item('defaultUnitofStorageSpace_paidMember_GB');
$defaultUnitofStorageSpaceString = $this->config->item('defaultUnitofStorageSpace_paidMember');
$toadCurrencySign = $this->config->item('toadCurrencySgine');

if( $subscriptionType == 1 && count($availableContainer) == 0 ) {
	$containerPriceCharged = $this->config->item('defaultMediaContainerPrice_EURO');
}

if(isset($subscriptionType) && (int)$subscriptionType == 1) {
	$spacePrice = $this->config->item('defaultPrice_per_unitofStorageSpace_freeMember_EURO');
	$spacePriceString = $this->config->item('defaultPrice_per_unitofStorageSpace_freeMember');
	$defaultUnitofStorageSpace = $this->config->item('defaultUnitofStorageSpace_freeMember_MB');
	$defaultUnitofStorageSpaceString = $this->config->item('defaultUnitofStorageSpace_freeMember');
}

$containerPriceChargedInput = array(
	'name'	=> 'containerPriceCharged',
	'type'	=> 'hidden',
	'id'	=> 'containerPriceCharged',
	'value'	=>(isset($containerPriceCharged) && (int)$containerPriceCharged > 0)?$containerPriceCharged:0
);

// set default size and pricing
$defaultFreeStorageSpace = $this->config->item('defaultContainerStorageSpace_MB'); // as 100MB
$defaultPaidStorageSpace = $this->config->item('defaultStorageSpace_paidMember_GB'); // as 50GB
$defaultFreePriceStorageSpace = $this->config->item('defaultPrice_per_unitofStorageSpace_freeMember_EURO'); // as 0.80
$defaultPaidPriceStorageSpace = $this->config->item('defaultUnitofStorageSpace_paidMember_GB'); // as 10

// set space unit for free subscription
$spaceUnit = $this->lang->line('gb');
// set space value for free subscription
$initialSpace = $defaultPaidPriceStorageSpace;
$convertToUnit = 'gb';
if($subscriptionType == 1) {
	// set space unit for paid subscription
	$spaceUnit = $this->lang->line('mb');
	$convertToUnit = 'mb';
	// set space value for paid subscription
	$initialSpace = $defaultFreeStorageSpace;
}

// set cart total price
$cartTotalPrice = $spacePrice + number_format($containerPriceCharged,2);

// set cart temp data if exists
if(!empty($mediaCartData)) {
	
	$cartTotalPrice = $mediaCartData->totalPrice - $mediaCartData->totalTaxAmt; // set total price
	$spacePrice     = $mediaCartData->price; // set space price
	$initialSpace   = bytestoMB($mediaCartData->size,$convertToUnit); // set space size
}

$extraSpacePriceInput = array(
	'name'	=> 'extraSpacePrice',
	'type'	=> 'hidden',
	'id'	=> 'extraSpacePrice',
	'value'	=> (isset($spacePrice))?$spacePrice:0
);

$cartTotalPriceInput = array(
	'name'	=> 'cartTotalPrice',
	'type'	=> 'hidden',
	'id'	=> 'cartTotalPrice',
	'value'	=> (isset($cartTotalPrice))?$cartTotalPrice:0
);

$totalProductPriceInput = array(
	'name'	=> 'totalProductPrice',
	'type'	=> 'hidden',
	'id'	=> 'totalProductPrice',
	'value'	=> (isset($containerPriceCharged))?$containerPriceCharged:0
);

$subscriptionTypeInput = array(
	'name'	=> 'subscriptionType',
	'type'	=> 'hidden',
	'id'	=> 'subscriptionType',
	'value'	=> (isset($subscriptionType))?$subscriptionType:0
);
// set form url
$absoluteFormUrl =  base_url(lang().'/showcase');
?>
<div class="TabbedPanelsContentGroup width_665 m_auto "> 
	<!--==========================     Step 2 Membership Cart==============================-->
	<?php echo form_open($absoluteFormUrl.DIRECTORY_SEPARATOR.'membershipcartpost'.DIRECTORY_SEPARATOR,$mce); ?>
		<div class="TabbedPanelsContent">
			<h3 ><?php echo $this->lang->line('membershipCart');?></h3>
			<div class="sap_40"></div>
			<ul class="total clearb">
				<li class="clearb" >
					<span class="display_cell p_head"> <span class="fs16 font_bold minwidth_165 "><?php echo $this->lang->line('media_showcase');?></span>
					<span class="fs13 pl5"> <?php echo $this->lang->line('validOneYear');?></span></span>
					<span class="price"> <?php echo $toadCurrencySign;?><span id="totalProductPriceHtml"><?php echo $containerPriceCharged ;?></span> </span> 
				</li>
				<li class="clearb  BB_dadada extra_space" >
					<span class="display_cell p_head ">
						<span class="fs16 font_bold minwidth_165"><?php echo $this->lang->line('extraSpace');?></span> 
						<span class="fs13 font_notmal pl5"><?php echo $this->lang->line('spaceExpire');?></span>
					</span>
					<span class="price "> 
						<?php echo $toadCurrencySign;?><span id="extraSpacePriceHtml"><?php echo $spacePrice;?></span> 
					</span> 
				</li>
				<li class="wra_head clearb extra_space" >
					<span class="display_cell fs13   pb15"> 
						<ul class="pt10 list fl mb8">
							<?php if($subscriptionType == 1) { ?>
								<li>
									<?php 
									echo $this->lang->line('eachShowcaseCome');
									echo $this->config->item('defaultContainerStorageSpace'); ?>.
								</li>
							<?php } ?>
							<li>
								<?php echo $this->lang->line('extraCost');
								echo $spacePriceString;
								//echo $this->lang->line('media_showcase');
								echo $this->lang->line('per');
								echo $defaultUnitofStorageSpaceString;?>.
							</li>
						</ul>
						<span class="fr mr20">
							<span class="fs16 fl  lineH30 pt18 pr23"><?php echo $this->lang->line('add');?></span>
							<span class="add_select position_relative mt14 fr  display_inline_block">
								<p>
									<label class="fr mr15 lineH33 fs14 color_818181" for="spinner"> <?php echo $spaceUnit;?> </label>
									<span class="ui-spinner ui-widget ui-widget-content ui-corner-all">
										<input value="<?php echo $initialSpace;?>" name="extraspace" readonly id="extraspace" subscriptionType = "<?php echo $subscriptionType;?>" aria-valuenow="89" class="ui-spinner-input" autocomplete="off" role="spinbutton">
										<a class="ui-spinner-button ui-spinner-up ui-corner-tr ui-button ui-widget ui-state-default ui-button-text-only" tabindex="-1" role="button" aria-disabled="false" id="upSpace">
											<span class="ui-button-text">
												<span class="ui-icon-triangle-1-n"></span>
											</span>
										</a>
										<a class="ui-spinner-button ui-spinner-down ui-corner-br ui-button ui-widget ui-state-default ui-button-text-only" tabindex="-1" role="button" aria-disabled="false" id="downSpace">
											<span class="ui-button-text">
												<span class="ui-icon-triangle-1-s"></span>
											</span>
										</a>
									</span>
									<!--<input id="spinner" name="value" value="100" />-->
								</p>
							</span>
						</span>
					</span>
					<span class="fs19 fshel_midum price"> </span> 
				</li>	
				<li class="clearb BT_dadada" >
					<span class="red p_head font_bold pr36 text_alignR "> <?php echo $this->lang->line('total');?> </span>
					<span class="price red font_bold"> 
						<?php echo $toadCurrencySign;?><span id="cartTotalPriceHtml"><?php echo $cartTotalPrice;?></span> 
					</span> 
				</li>		
			</ul>
			<ul class="list pt20 display_table fl ">
				<li class="icon_2  fl liststyle_none pl36 fs13 mt5"><?php echo $this->lang->line('vatApplicable');?></li>
			</ul>
			<div class="sap_10"></div>
			<?php 
			$data['backPage'] = '/editshowcase';
			$this->load->view('wizardform/common_buttons',$data);
			?>
			
			<div  class="sap_20"></div>
			<h2 class=" fs29 clearb ">
				<?php 
				echo $this->lang->line('upgradeMemNGet');
				echo $this->config->item('defaultStorageSpace_paidMember');
                echo '&nbsp';
				echo $this->lang->line('space');?> 
			</h2>
			<a href="<?php echo base_url(lang().'/package/information');?>" class="fr fs20  pb10 " ><?php echo $this->lang->line('seeMemInfo');?> </a>
		</div>
		<?php
		// set hidden form inputs
		echo form_input($extraSpacePriceInput); 
		echo form_input($cartTotalPriceInput);
		echo form_input($subscriptionTypeInput);
		echo form_input($totalProductPriceInput);
	// close membership cart form
	echo form_close();
  ?>   
</div>

<script type="text/javascript">
  
	$(document).ready(function() {

		/**
		 * @Description: Manage media extra space and value on up spinner
		 */ 
		$('#upSpace').click(function() {
			// get subscription type
			manageSpace('up');
		});
		
		//------------------------------------------------------------------------
			
		/**
		 * @Description: Manage media extra space and value on down spinner
		 */ 
		$('#downSpace').click(function() {
			// get subscription type
			manageSpace('down');
		});
		
		//------------------------------------------------------------------------
			
		/**
		 * @Description: Manage cart data as spinner changes 
		 */ 
		function manageSpace(spaceType) {
			
			// get subscription type
			var subscriptionType = $('#extraspace').attr('subscriptionType');
			// get extra space value
			var spaceSize = $('#extraspace').val();
			// get extra space price
			var extraSpacePrice = $('#extraSpacePriceHtml').html();
			// get cart total price
			var cartTotalPrice = $('#cartTotalPriceHtml').html();
			// set default space and price
			var extraDefaultSpace = '<?php echo $defaultFreeStorageSpace;?>';
			var extraDefaultPrice = '<?php echo $defaultFreePriceStorageSpace;?>';
			if(subscriptionType!=1) {
				extraDefaultSpace = <?php echo $defaultPaidPriceStorageSpace;?>;
				extraDefaultPrice = <?php echo $defaultPaidStorageSpace;?>;
			}
			
			if( spaceType == 'up' ) {
				spaceSize = parseInt(spaceSize)+parseInt(extraDefaultSpace);
				extraSpacePrice = parseFloat(extraSpacePrice)+parseFloat(extraDefaultPrice);
				cartTotalPrice = parseFloat(cartTotalPrice)+parseFloat(extraDefaultPrice);
			} else {
				if((subscriptionType == 1 && spaceSize > 100) || (subscriptionType != 1 && spaceSize > 10)) {
					spaceSize = parseInt(spaceSize)-extraDefaultSpace;
					extraSpacePrice = parseFloat(extraSpacePrice)-parseFloat(extraDefaultPrice);
					cartTotalPrice = parseFloat(cartTotalPrice)-parseFloat(extraDefaultPrice);
				} else {
					return false;
				}
			}
			// append values as extra space
			$('#extraspace').val(spaceSize);
			$('#extraSpacePriceHtml').html(extraSpacePrice.toFixed(2));
			$('#cartTotalPriceHtml').html(cartTotalPrice.toFixed(2));
			$('#extraSpacePrice').val(extraSpacePrice.toFixed(2));
			$('#cartTotalPrice').val(cartTotalPrice.toFixed(2));
		}
	});
</script>        
