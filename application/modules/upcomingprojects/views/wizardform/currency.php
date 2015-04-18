<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'currencyForm',
    'id'=>'currencyForm',
);
$projectIdField = array(
	'name'	=> 'projId',
	'value'	=> (isset($upcomingRes['projId'])) ? $upcomingRes['projId'] : 0,
	'id'	=> 'projId',
	'type'	=> 'hidden'
);
// set base url
$baseUrl = base_url(lang().'/upcomingprojects/');

/* Currency Page */
$eur=$us= '';	
if(isset($userProfileData->seller_currency) && ($userProfileData->seller_currency!='' )) {
	switch($userProfileData->seller_currency){
		case 1: 
		$text ='US Dollars $';
		$eur  ='dn';
		$is_euro_selected = 'checked';
		$is_usd_selected = '';
		break;

		default: 
		$text ='Euros €';
		$us  ='dn';
		$is_euro_selected = '';
		$is_usd_selected = 'checked';
		break;
	}
}

?>

<!-- =================Currency type==================-->						
<div class="TabbedPanelsContent width635 m_auto"> 	
	<?php echo form_open($baseUrl.'/setcurrency',$formAttributes); ?>	
		<?php if(isset($userProfileData->seller_currency) && ($userProfileData->seller_currency!='' )) { ?>
			<div class="c_1 us_wrap">
				<h3 class="red fs21 fnt_mouse  bb_aeaeae width635 selling_text ">You are selling in <?php echo $text ?></h3>
				<div class="sap_40"></div>
				<ul>
					<li class="icon_1 red"><?php echo $this->lang->line('currencyMsgsale');?></li>
					<li class="icon_2"><?php echo $this->lang->line('currencyMsgchangeshrt');?></li>
				</ul>
			</div>
		<?php } else { ?>
			<div class="c_1 main_price">
				<h3 class="red fs21 fnt_mouse  bb_aeaeae width635 whitespace_now">
					<?php echo $this->lang->line('whatSellerCurrency');?> 
				</h3>
				<div class="sap_40"></div>
				<ul class=" display_table clearb rate_wrap">
					<li class="defaultP ">
						<label class=" pr80 Eu_btn">
							<input  type="radio" name="seller_currency" value="0" <?php echo $is_euro_selected ?> >
							<?php echo $this->lang->line('sellerEuros');?> 
						</label>
						<label class="Us_btn">
							<input  type="radio" name="seller_currency" value="1" <?php echo $is_usd_selected ?> >
							<?php echo $this->lang->line('sellerUSDollars');?> 
						</label>
					</li>
				</ul>

				<ul class="org_list">
					<li class="icon_1 red"><?php echo $this->lang->line('currencyMsgsale');?></li>
					<li class="icon_2"><?php echo $this->lang->line('currencyMsgchange');?></li>
				</ul>
			</div> 
		<?php
		} 
		echo form_input($projectIdField);
    echo form_close();?>	
    <!-- Form buttons -->
    <?php
    // set next form name
    $data['formName'] = 'currencyForm';
    $this->load->view('wizardform/donation_buttons',$data);
    ?>
</div>					

<!--  content wrap  end --> 
<script type="text/javascript">
    $(document).ready(function() {
        $("#currencyForm").validate({
            submitHandler: function() {
                var fromData=$("#currencyForm").serialize();
                $.post('<?php echo $baseUrl.'/setcurrency/';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep;
                    }
                }, "json");
            }
        });
    });
</script>

