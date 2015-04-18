<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$formName='internationalShippingPricingForm';
	
	//echo  "countriesId==".$countriesId;
	$formAttributes = array(
		'name'=>$formName,
		'id'=>$formName
	);
	
	if(isset($interationalShipping)){
		extract($interationalShipping);
	}
	
	$spIdInput = array(
		'name'	=> 'spId',
		'id'	=> 'spId',
		'value'	=> (isset($spId) && is_numeric($spId) && ($spId>0))?$spId:0,
		'type'	=> 'hidden'
	);
	
	$amountInput = array(
		'name'	=> 'amount',
		'id'	=> 'amount',
		'class'	=> 'font_wN  width_65 ml10 text_alighC required number',
		'placeholder'	=> '0.00',
		'onblur'	=> "placeHoderHideShow(this,'0.00','show')",
		'onclick'	=> "placeHoderHideShow(this,'0.00','hide')",
		'value'	=> (isset($amount) && is_numeric($amount) && ($amount>0))?$amount:0.00,
		'min'	=> 0.1,
		'title'	=> $this->lang->line('moreThenZero')
	);
	
	$zoneTitleInput = array(
		'name'	=> 'zoneTitle',
		'type'	=> 'hidden',
		'id'	=> 'zoneTitle',
		'class'	=> 'font_wN  width_65 ml10 text_alighC required',
		'placeholder'	=> 'Zone Title',
		'onblur'	=> "placeHoderHideShow(this,'Zone Title','show')",
		'onclick'	=> "placeHoderHideShow(this,'Zone Title','hide')",
		'value'	=> isset($zoneTitle)?$zoneTitle:'',
	);
	
	$shortDesc_minVal=0;
	$shortDesc_maxVal=15;
	$wordLabel=$shortDesc_minVal.' - '.$shortDesc_maxVal.$this->lang->line('words');
	$shortDesc=(isset($shortDesc) && $shortDesc != null && $shortDesc != 'null')?$shortDesc:'';
	$shortDesc=trim($shortDesc);
	
	$description = array(
		'name'	=> 'shortDesc',
		'id'	=> 'shortDesc',
		'class'	=> 'ffont_wN width610 p10 red_bdr_2 height_62 radius0 required',
		'placeholder'	=> 'Delivery Information*',
		'onblur'	=> "placeHoderHideShow(this,'Delivery Information*','show')",
		'onclick'	=> "placeHoderHideShow(this,'Delivery Information*','hide')",
		'value'	=> $shortDesc,
	);
	
	$zonTtitle = (isset($zoneTitle))?$zoneTitle:'';
	
	echo form_open(base_url(lang().'/shipping/saveGlobalShippingPrice'),$formAttributes);
	echo form_input($spIdInput); 
	echo form_input($zoneTitleInput); 
?>
	<div class="c_1">
		<div class="wra_head">
		<h3 class="red fs21 fnt_mouse  bb_aeaeae">Shipping Charge for <?php echo $zonTtitle;?>*</h3>
		<div class="sap_40"></div>
		<ul class="display_table clearb mb20">
		<li>
		<span class="pt7  fl">Shipping Charge <?php echo currencySign()."&nbsp;"?></span> 
			
            <span class="fl amount_inpot">
                <?php echo form_input($amountInput);?>
            </span>
		</li>
		</ul>
		<h3 class="red fs21 fnt_mouse  bb_aeaeae mb20">Delivery Information for <?php echo $zonTtitle;?>*</h3>
			<?php echo form_textarea($description); ?>
		</div>
		<ul class="org_list fl">   <li class="icon_2 ">Changes to these settings will NOT change your Shipping setup for your current sales. 
		<br />
		You will be able to copy this Shipping information to new sales.</li> </ul>
	</div>
	<div class="btn_wrap fr" >
		
		<button class="fl p10 bg_ededed bdr_a0a0a0 ml10 " type="button"  onclick="ajaxSave('<?php echo base_url(lang().'/shipping/globalShipping');?>','#IS_Container','');">Cancel</button>
		<a href="javascript:void(0);"><button class="bg_ededed back ml10 fl bdr_b1b1b1" type="button" onclick="ajaxSave('<?php echo base_url(lang().'/shipping/globalShippingform');?>','#IS_Container','<?php echo $spId;?>');">Back</button></a>
		<button class="fl p10 ml10 bdr_a0a0a0 " type="submit">Save</button>
	</div>
<?php form_close();?>
<script type="text/javascript">
		$(document).ready(function(){
				$("#<?php echo $formName;?>").validate({
						submitHandler: function() {
						 var fromData=$("#<?php echo $formName;?>").serialize();
						 $.post(baseUrl+language+'/shipping/saveGlobalShippingPrice',fromData, function(data) {
							if(data){
								$('#IS_Container').html(data);
								$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('saveShippingZonePrice');?></div>');
								timeout = setTimeout(hideDiv, 5000);
							}
						});
					 }
				});
		});
</script>

