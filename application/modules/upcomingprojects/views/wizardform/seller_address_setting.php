<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* Seller settings section */
$formAttributes = array(
	'name'=>'sellerSettingForm',
	'id'=>'sellerSettingForm'
);

$seller_firstName = array(
	'name'=> 'seller_firstName',
	'class'	=> 'font_wN',
	'id'=> 'seller_firstName',
	'value'	=> $userProfileData->firstName,
	'onclick'=>"placeHoderHideShow(this,'First Name *','hide')",
	'onblur'=>"placeHoderHideShow(this,'First Name *','show')",
	'placeholder'=>"First Name *",
	'disabled' =>'disabled'
 );
$seller_lastName = array(
	'name'=> 'seller_lastName',
	'id'=> 'seller_lastName',
	'class'=> 'copy',
	'value'=> $userProfileData->lastName,
	'onclick'=>"placeHoderHideShow(this,'Last Name *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Last Name *','show')",
	'placeholder'=>"Last Name *",
	'disabled' =>'disabled'
 );
 
$seller_company = array(
	'name'=> 'seller_companyName',
	'id'=> 'seller_companyName',
	'class'	=> 'font_wN',
	'value'	=> set_value('seller_companyName')?set_value('seller_companyName'):$userProfileData->seller_companyName,	
	'onclick'=>"placeHoderHideShow(this,'Company Name ','hide')",
	'onblur'=>"placeHoderHideShow(this,'Company Name','show')",
	'placeholder'=>"Company Name",
	'maxlength'	=> 100,
	'size'	=> 100
);
 
$seller_address1Input = array(
	'name'=> 'seller_address1',
	'id'=> 'seller_address1',
	'class'	=> 'required font_wN',
	'value'	=> set_value('seller_address1')?set_value('seller_address1'):$userProfileData->seller_address1,	
	'onclick'=>"placeHoderHideShow(this,'Address Line 1 *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Address Line 1 *','show')",
	'placeholder'=>"Address Line 1 *",
	'maxlength'	=> 100,
	'size'	=> 100
);

$seller_address2Input = array(
	'name'	=> 'seller_address2',
	'id'	=> 'seller_address2',
	'class'	=> 'required font_wN',
	'value'	=> set_value('seller_address2')?set_value('seller_address2'):$userProfileData->seller_address2,
	'onclick'=>"placeHoderHideShow(this,'Address Line 2 *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Address Line 2 *','show')",
	'placeholder'=>"Address Line 2 *",
	'maxlength'	=> 100,
	'size'	=> 100
);

$seller_cityInput = array(
	'name'	=> 'seller_city',
	'id'	=> 'seller_city',
	'class'	=> 'required font_wN',
	'value'	=> set_value('seller_city')?set_value('seller_city'):$userProfileData->seller_city,
	'onclick'=>"placeHoderHideShow(this,'Town or City *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Town or City *','show')",
	'placeholder'=>"Town or City *",
	'maxlength'	=> 50,
	'size'	=> 50
);

$seller_zipInput = array(
	'name'=> 'seller_zip',
	'id'=>'seller_zip',
	'class'=> 'number font_wN width_160',
	'value'=> set_value('seller_zip')?set_value('seller_zip'):$userProfileData->seller_zip,
	'onclick'=>"placeHoderHideShow(this,'Post Code or ZIP Code *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Post Code or ZIP Code *','show')",
	'placeholder'=>"Post Code or ZIP Code *",
	'maxlength'	=> 50,
	'size'	=> 50
);
$seller_phoneInput = array(
	'name'=>'seller_phone',
	'id'=>'seller_phone',
	'class'=> 'number  font_wN',
	'value'=> set_value('seller_phone')?set_value('seller_phone'):$userProfileData->seller_phone,
	'onclick'=>"placeHoderHideShow(this,'Phone Number *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Phone Number *','show')",
	'placeholder'=>"Phone Number *",
	'maxlength'=> 50,
	'size'=> 50
);

$seller_emailInput = array(
	'name'=>'seller_email',
	'id'=>'seller_email',
	'class'=> 'font_wN',
	'value'=> set_value('seller_email')?set_value('seller_email'):$userProfileData->email,
	'onclick'=>"placeHoderHideShow(this,'Email *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Email *','show')",
	'placeholder'=>"Email *",
	'maxlength'=> 50,
	'size'=> 50,
	'disabled' =>'disabled'
);

$countryValue = ($userProfileData->countryId!='') ? $userProfileData->countryId : 0;
$stateValue = ($userProfileData->seller_state!='') ? $userProfileData->seller_state : 0;

// set base url
$baseUrl = base_url(lang().'/upcomingprojects');

?>
<div class="TabbedPanelsContent TabbedPanelsContentVisible">
    <?php echo form_open($baseUrl,$formAttributes); ?>
		<div class="c_1">
			<h3 class="red fs21 fnt_mouse bb_aeaeae"> <?php echo $this->lang->line('whatSellerDetails');?> </h3>
			<div class="sap_40"></div>
			<div class=" display_inline_block defaultP">
				<label class="pr20"> 
					<input  type="checkbox" <?php if($userProfileData->seller_isSameAsBuyer=='t'){ echo 'checked'; }?> id="seller_isSameAsBuyer" name="detail_type" value="seller_isSameAsBuyer" onclick="if(this.checked){copyFromBuyer('#seller_')};"  />
					<?php echo $this->lang->line('copyBuyerDetails');?>
				</label>
			</div>
			<div class="sap_40"></div>

			<ul class=" billing_form form1" >
				<li><?php echo form_input($seller_firstName); ?></li>
				<li><?php echo form_input($seller_lastName); ?></li>
				<li><?php echo form_input($seller_company); ?></li>
				<li><?php echo form_input($seller_address1Input); ?></li>
				<li><?php echo form_input($seller_address2Input); ?></li>
				<li><?php echo form_input($seller_cityInput); ?></li>

				<li class=" width_258 select select_1">
					<?php
					$countries = getCountryList();
					echo form_dropdown('seller_country', $countries, $countryValue,'id="countriesList"  class=" main_SELECT countriesList selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
					?>
				</li>
				<li class=" width_258 select select_2 stateListDiv">
					<?php
					$stateList = (!empty($countryValue))?getStatesList($countryValue,true):array(''=>'Select  State, Province or Region');
					echo form_dropdown('seller_state', $stateList, $stateValue,'id="stateList" class=" main_SELECT selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
					?>
				</li>
				<li class="width_190"><?php echo form_input($seller_zipInput); ?></li>
				<li><?php echo form_input($seller_emailInput); ?></li>
				<li class="mb0"><?php echo form_input($seller_phoneInput); ?></li>
			</ul>
			<ul class="org_list">
				<li class="icon_1 red"><?php echo $this->lang->line('allSaleUpdate');?></li>
				<li class="icon_2"><?php echo $this->lang->line('settingStoreInGlobal');?></li>
			</ul>
			<!-- Form buttons --> 
			<div class="fr btn_wrap display_block font_weight">
				<a href="<?php echo base_url(lang().'/upcomingprojects/donation/'.$projId);?>" id="cancleForm"> 
					<button class="bg_ededed bdr_b1b1b1 mr5" type="button"><?php echo $this->lang->line('cancel');?></button>
				</a>
				<a href="<?php echo $baseUrl.'/sellerpaypal/'.$projId;?>" id="backStep">
					<button class="back back_click1 bdr_b1b1b1 mr5" type="button">
						<?php echo $this->lang->line('back');?>
					</button>
				</a>
				<button class="b_F1592A bdr_F1592A" onclick ="return saveSellerSettings();" type="submit">
					<?php echo $this->lang->line('next');?>
				</button>          
			</div>
		</div>	
    <?php echo form_close(); ?>
</div>

<script>
    /* Seller selling details */
    function saveSellerSettings() {
        $("#sellerSettingForm").validate({
            submitHandler: function(form) {
                var fromData=$("#sellerSettingForm").serialize();
                    //fromData = fromData+'&ajaxHit=1'+'&replymsg='+body;
                $.post( baseUrl+language+'/dashboard/saveSellerSettings',fromData, function( data ) {
                    if(data && data.msg){
                        $('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
                        window.location.href = '<?php echo $baseUrl.'/titlendescription/'.$projId;?>';
                        timeout = setTimeout(hideDiv, 5000);
                        }
                }, "json");
            }
        });
    }
    
    function copyFromBuyer(prifix) {
        $(prifix+'address1').val('<?php echo $userProfileData->billing_address1;?>');
        $(prifix+'address2').val('<?php echo $userProfileData->billing_address2;?>');
        $(prifix+'city').val('<?php echo $userProfileData->billing_city;?>');
        $(prifix+'state').val('<?php echo $userProfileData->billing_state;?>');
        $(prifix+'phone').val('<?php echo $userProfileData->billing_phone;?>');
        $(prifix+'zip').val('<?php echo $userProfileData->billing_zip;?>');
        $('SELECT').selectBox(); 
    }
    
/* End */
</script>
