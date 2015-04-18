<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/*Seller Shipping Pickup settings */

$formpickupAttributes = array(
	'name'=>'pickupForm',
	'id'=>'pickupForm'
);
$seller_pickupcity = array(
	'name'	=> 'pickupCity',
	'id'	=> 'pickupCity',
	'class'	=> 'required font_wN width_315',
	'value'	=> set_value('pickupCity')?set_value('pickupCity'):$userProfileData->pickupcity,
	'onclick'=>"placeHoderHideShow(this,'City *','hide')",
	'onblur'=>"placeHoderHideShow(this,'City *','show')",
	'placeholder'=>"City *",
	'maxlength'	=> 50,
	'size'	=> 50
);

$seller_pickupzip = array(
	'name'=> 'pickupZip',
	'id'=>'pickupZip',
	'class'=> 'number required font_wN custom_width',
	'value'=> set_value('pickupZip')?set_value('pickupZip'):$userProfileData->pickupzip,
	'onclick'=>"placeHoderHideShow(this,'Post Code or ZIP Code *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Post Code or ZIP Code *','show')",
	'placeholder'=>"Post Code or ZIP Code *",
	'maxlength'	=> 50,
	'size'	=> 50
);

$seller_pickupsuberb = array(
	'name'=> 'pickupSuberb',
	'id'=>'pickupSuberb',
	'class'=> 'font_wN width_315',
	'value'=> set_value('pickupSuberb')?set_value('pickupSuberb'):$userProfileData->pickupsubrub,
	'onclick'=>"placeHoderHideShow(this,'Suburb','hide')",
	'onblur'=>"placeHoderHideShow(this,'Suburb','show')",
	'placeholder'=>"Suburb ",
	'maxlength'	=> 50,
	'size'	=> 50
);

$pickupRequirements = array(
	'name'=> 'pickupRequirements',
	'id'=>'pickupRequirements',
	'class'=> 'font_wN width610 p10 red_bdr_2 height_89 radius0',
	'type' => 'textarea',
	'value'=> set_value('pickupRequirements')?set_value('pickupRequirements'):'',
	'onclick'=>"placeHoderHideShow(this,'Special Pickup Requirements','hide')",
	'onblur'=>"placeHoderHideShow(this,'Special Pickup Requirements','show')",
	'placeholder'=>"Special Pickup Requirements ",
	'maxlength'	=> 50,
	'size'	=> 50
);

$pickupProjectId = array(
	'name' => 'projectId',
	'id'   => 'projectId',
	'type' => 'hidden',
	'value'=>  (!empty($projectId))?$projectId:0,
);

$pickupElementId = array(
	'name' => 'elementId',
	'id'   => 'elementId',
	'type' => 'hidden',
	'value'=>  (!empty($elementId))?$elementId:0,
);

$pickupEntityId = array(
	'name' => 'entityId',
	'id'   => 'entityId',
	'type' => 'hidden',
	'value'=>  (!empty($entityId))?$entityId:0,
);

$projPickupId = array(
	'name' => 'projPickupId',
	'id'   => 'projPickupId',
	'type' => 'hidden',
	'value'=>  (!empty($pickupId))?$pickupId:0,
);

$pickupIndustry = array(
	'name' => 'indusrty',
	'id'   => 'indusrty',
	'type' => 'hidden',
	'value'=>  (!empty($indusrty))?$indusrty:0,
);

$pickupCountryValue = ($userProfileData->pickupcountry!='') ? $userProfileData->pickupcountry : 0;
$pickupStateValue = ($userProfileData->pickupstate!='') ? $userProfileData->pickupstate : 0;
// set base url
$baseUrl = formBaseUrl();
?>
	
	<div id="TabbedPanels7" class="TabbedPanels tab_setting"> 
		<!--========== Setup your Auction  =================-->
		<div class="TabbedPanelsContentGroup"> 
			<!--=======================pickup=======================-->    
			<?php echo form_open($baseUrl.DIRECTORY_SEPARATOR.'saveshippingpickup',$formpickupAttributes); ?>       
				<div class="TabbedPanelsContent">
					<div class="c_1 display_none">
						<h3 class="red fs21 fnt_mouse  bb_aeaeae"> How will you deliver your Prints?* </h3>
						<div class="sap_40"></div>
						<ul class=" display_table clearb pickup rate_wrap defaultP">
							<li >
								<label>
									<input  type="checkbox" name="item1_1" checked="checked " />
									<b>Pickup </b>
								</label>
							</li>
							<li class="pl30">AND/OR </li>
							<li>
								<label>
									<input  type="checkbox" name="item1_2" checked="checked " />
									<b>Domestic</b> Shipping 
								</label>
							</li>
							<li class="pl30">AND/OR</li>
							<li>
								<label>
									<input  type="checkbox" name="item1_1" checked="checked " />
									<b>International</b> Shipping 
								</label>
							</li>
						</ul>
						<ul class=" clearb org_list">
							<li class="icon_1">Buyers can only buy from you if they live in countries you setup shipping for. </li>
							<li class="icon_2">This setting is stored in your <b>Seller Settings</b>.<b> Your Toadsquare </b>menu > <b>Global Setttings</b>. </li>
						</ul>
					</div>
					<div class="c_1 display_none">
						<ul class=" display_table clearb rate_wrap defaultP">
							<li >
								<label>
									<input  type="radio" name="item12" checked="checked " />
									Copy and then edit your Pickup details from your Seller Settings.
								</label>
							</li>

							<li class="pt20 pb20">OR </li>
							<li> 
								<label>
									<input  type="radio" name="item12" checked="checked " />
									Enter new Pickup details. 
								</label>
							</li>
						</ul>
						<ul class=" clearb org_list">
							<li class="icon_1">Buyers can only buy from you if they live in countries you setup shipping for. </li>
							<li class="icon_2">This setting is stored in your <b>Seller Settings</b>. <b>Your Toadsquare</b> menu > <b>Global Setttings.</b> </li>
						</ul>
					</div>
					<div class="c_1">
						<h3 class="red fs21 fnt_mouse  bb_aeaeae"> Pickup Details* </h3>
						<ul class=" mt30 mb20 billing_form domestic_country position_relative height_30 custom_country_domestic">
							<li class="select select_4 width_208">
								<?php
								$countries = getCountryList();
								echo form_dropdown('pickupCountry', $countries, $pickupCountryValue,'id="countriesList" class=" main_SELECT countriesList selectBox bg_f6f6f6  required" title="'.$this->lang->line('packpayment_required_field').'"');
								?>
							</li>
							<li class="select_3 select width_208 stateListDiv">
								<?php
								$stateList = (!empty($pickupCountryValue))?getStatesList($pickupCountryValue,true):array(''=>'Select  State');
								echo form_dropdown('stateList', $stateList, $pickupStateValue,'id="stateList" class=" main_SELECT selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
								?>
							</li>
							<li class="width_345"><?php echo form_input($seller_pickupcity); ?></li>
							<li class="width_345"><?php echo form_input($seller_pickupsuberb); ?></li> 
							<li class="width_160"><?php echo form_input($seller_pickupzip); ?></li>
						</ul>
						<div class="wra_head">
							<h4 class="red fs21 mb25 fnt_mouse  bb_aeaeae">Are there any Pickup requirements?</h4>
							<textarea col="" row="" class="font_wN width610 p10 red_bdr_2 height_89 radius0" value="Special Pickup Requirements" type="text" onClick="placeHoderHideShow(this,'Special Pickup Requirements','hide')" onBlur="placeHoderHideShow(this,'Special Pickup Requirements','show')" placeholder="Special Pickup Requirements" name="pickupRequirements"><?php echo isset($userProfileData->pickuprequirements) ? $userProfileData->pickuprequirements : '' ?></textarea>
							<div class="defaultP lineH20 mt35 fl">
								<label>
									<input type="checkbox" value="1" name="isSameAsGlobal" />
									<span class="display_table"> 
                                        <?php echo $this->lang->line('shippingInfoText1');?>
                                        <a href="<?php echo site_url(lang().'/dashboard/globalsettings/4')?>"><?php echo $this->lang->line('shippingInfoText2');?></a>
                                        <?php echo $this->lang->line('shippingInfoText3');?>
                                    </span>
								</label>
							</div>
						</div>
					</div>
					<!-- form buttons  -->
					<?php 
                    // set back page name
                    $data['backPage'] = 'shipping';
                    if(!empty($pickupId)) {
                        $data['backPage'] = $backPage;
                    }
					$this->load->view('common_view/shipping_buttons',$data);
                    //set form hidden fields
                    echo form_input($projPickupId);
                    echo form_input($pickupProjectId);
                    echo form_input($pickupElementId); 
                    echo form_input($pickupEntityId);
                    echo form_input($pickupIndustry);
                    ?>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#pickupForm").validate({
            submitHandler: function() {
                var fromData=$("#pickupForm").serialize();
                loader();
                $.post('<?php echo $baseUrl.'/saveshippingpickup/';?>',fromData, function(data) {
                    if(data){
                        window.location.href = '<?php echo $baseUrl;?>'+data.nextStep;
                    }
                }, "json");
            }
        });
    });
</script>              
		
