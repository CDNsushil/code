<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'contactDetailsForm',
    'id'=>'contactDetailsForm',
);
// get workprofile data
$profileFName   = (isset($workProfileDetails->profileFName) && !empty($workProfileDetails->profileFName)) ? $workProfileDetails->profileFName : '';
$profileLName   = (isset($workProfileDetails->profileLName) && !empty($workProfileDetails->profileLName)) ? $workProfileDetails->profileLName : '';
$profileCity    = (isset($workProfileDetails->profileCity) && !empty($workProfileDetails->profileCity)) ? $workProfileDetails->profileCity : '';
$profileAdd     = (isset($workProfileDetails->profileAdd) && !empty($workProfileDetails->profileAdd)) ? $workProfileDetails->profileAdd : '';
$profileStreet  = (isset($workProfileDetails->profileStreet) && !empty($workProfileDetails->profileStreet)) ? $workProfileDetails->profileStreet : '';
$profileState   = (isset($workProfileDetails->profileState) && !empty($workProfileDetails->profileState)) ? $workProfileDetails->profileState : '';
$profileZip     = (isset($workProfileDetails->profileZip) && !empty($workProfileDetails->profileZip)) ? $workProfileDetails->profileZip : '';
$profileCountry = (isset($workProfileDetails->profileCountry) && !empty($workProfileDetails->profileCountry)) ? $workProfileDetails->profileCountry : '';
$profileEmail   = (isset($workProfileDetails->profileEmail) && !empty($workProfileDetails->profileEmail)) ? $workProfileDetails->profileEmail : '';
$profilePhone   = (isset($workProfileDetails->profilePhone) && !empty($workProfileDetails->profilePhone)) ? $workProfileDetails->profilePhone : '';
$profileMobile   = (isset($workProfileDetails->profileMobile) && !empty($workProfileDetails->profileMobile)) ? $workProfileDetails->profileMobile : '';


// get user's profile default data
$userFirstName  = (isset($userProfileData->firstName) && !empty($userProfileData->firstName)) ? $userProfileData->firstName : '';
$userLastName   = (isset($userProfileData->lastName) && !empty($userProfileData->lastName)) ? $userProfileData->lastName : '';
$userCityName   = (isset($userProfileData->cityName) && !empty($userProfileData->cityName)) ? $userProfileData->cityName : '';
$userAdd        = (isset($userProfileData->billing_address1) && !empty($userProfileData->billing_address1)) ? $userProfileData->billing_address1 : '';
$userStreet     = (isset($userProfileData->billing_address2) && !empty($userProfileData->billing_address2)) ? $userProfileData->billing_address2 : '';
$userState      = (isset($userProfileData->stateId) && !empty($userProfileData->stateId)) ? $userProfileData->stateId : '';
$userZip        = (isset($userProfileData->billing_zip) && !empty($userProfileData->billing_zip)) ? $userProfileData->billing_zip : '';
$userCountry    = (isset($userProfileData->countryId) && !empty($userProfileData->countryId)) ? $userProfileData->countryId : '';
$userEmail      = (isset($userProfileData->email) && !empty($userProfileData->email)) ? $userProfileData->email : '';
$userPhone      = (isset($userProfileData->billing_phone) && !empty($userProfileData->billing_phone)) ? $userProfileData->billing_phone : '';

$profileFNameInput = array(
    'name'	    => 'profileFName',
    'value'	    => (!empty($profileFName)) ? $profileFName : $userFirstName,
    'id'	    => 'profileFName',
    'type'	    => 'text',
    'class'     => 'font_wN required',
    'onclick'   =>  "placeHoderHideShow(this,'First name*','hide')",
    'onblur'    =>  "placeHoderHideShow(this,'First name*','show')",
    'placeholder' =>  "First name*",
);

$profileLNameInput = array(
    'name'	=> 'profileLName',
    'value'	=> (!empty($profileLName)) ? $profileLName : $userLastName,
    'id'	=> 'profileLName required',
    'type'	=> 'text',
    'class' => 'font_wN',
    'onclick'         =>  "placeHoderHideShow(this,'Last name','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Last name','show')",
    'placeholder'     => "Last name",
);

$profileAddInput = array(
    'name'	=> 'profileAdd',
    'value'	=> (!empty($profileAdd)) ? $profileAdd : $userAdd,
    'id'	=> 'profileAdd required',
    'type'	=> 'text',
    'class' => 'font_wN',
    'onclick'         =>  "placeHoderHideShow(this,'Address Line 1','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Address Line 1','show')",
    'placeholder'     =>  "Address Line 1",
);

$profileStreetInput = array(
    'name'	=> 'profileStreet',
    'value'	=> (!empty($profileStreet)) ? $profileStreet : $userStreet,
    'id'	=> 'profileStreet required',
    'type'	=> 'text',
    'class' => 'font_wN',
    'onclick'         =>  "placeHoderHideShow(this,'Address Line 2','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Address Line 2','show')",
    'placeholder'     => "Address Line 2",
);

$profileCityInput = array(
    'name'	=> 'profileCity',
    'value'	=> (!empty($profileAdd)) ? $profileAdd : $userAdd,
    'id'	=> 'profileCity required',
    'type'	=> 'text',
    'class' => 'font_wN',
    'onclick'         =>  "placeHoderHideShow(this,'Town or City','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Town or City','show')",
    'placeholder'     =>  "Town or City",
);

$profileStateInput = array(
    'name'	=> 'profileState',
    'value'	=> (!empty($profileState)) ? $profileState : '',
    'id'	=> 'profileState required',
    'type'	=> 'text',
    'class' => 'font_wN',
    'onclick'         =>  "placeHoderHideShow(this,'State, Provence or Region','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'State, Provence or Region','show')",
    'placeholder'     =>  "State, Provence or Region",
);

$profileZipInput = array(
    'name'	=> 'profileZip',
    'value'	=> (!empty($profileZip)) ? $profileZip : $userZip,
    'id'	=> 'profileZip required',
    'type'	=> 'text',
    'class' => 'font_wN width235imp',
    'onclick'         =>  "placeHoderHideShow(this,'Zip or Post Code','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Zip or Post Code','show')",
    'placeholder'     => "Zip or Post Code",
);

$profileEmailInput = array(
    'name'	=> 'profileEmail',
    'value'	=> (!empty($profileEmail)) ? $profileEmail : $userEmail,
    'id'	=> 'profileEmail required',
    'type'	=> 'text',
    'class' => 'font_wN',
    'onclick'         =>  "placeHoderHideShow(this,'Email Address','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Email Address','show')",
    'placeholder'     => "Email Address",
);

$profilePhoneInput = array(
    'name'	=> 'profilePhone',
    'value'	=> (!empty($profilePhone)) ? $profilePhone : $userPhone,
    'id'	=> 'profilePhone required',
    'type'	=> 'text',
    'class' => 'font_wN width235imp',
    'onclick'         => "placeHoderHideShow(this,'Phone Number','hide')",
    'onblur'          => "placeHoderHideShow(this,'Phone Number','show')",
    'placeholder'     => "Phone Number",
);

$profileMobileInput = array(
    'name'	=> 'profileMobile',
    'value'	=> $profileMobile,
    'id'	=> 'profileMobile',
    'type'	=> 'text',
    'class' => 'font_wN width235imp',
    'onclick'         => "placeHoderHideShow(this,'Mobile Number','hide')",
    'onblur'          => "placeHoderHideShow(this,'Mobile Number','show')",
    'placeholder'     => "Mobile Number",
);

// set base url
$baseUrl = base_url(lang().'/workprofile/');

?>
 <div class="content display_table  TabbedPanelsContent  m_auto">
	<div class=" clearb">
        <h3 class="width635 fr"><?php echo $this->lang->line('contactDetails');?> </h3>
		<div class="sap_30"></div>
        <?php echo form_open($baseUrl.'/updateShowcaseDetails',$formAttributes); ?>
			<ul class=" billing_form form1 contact_detal">
               
                <li> 
					<label class="employe_label">First name*</label>
					<?php echo form_input($profileFNameInput); ?>
				</li>
                <li> 
					<label class="employe_label">Last name</label>
					<?php echo form_input($profileLNameInput); ?>
				</li>
				<li> 
					<label class="employe_label">Address Line 1</label>
					<?php echo form_input($profileAddInput); ?>
				</li>
				<li> 
					<label class="employe_label">Address Line 2</label>
					<?php echo form_input($profileStreetInput); ?>
				</li>
				<li> 
					<label class="employe_label">Town or City</label>
					<?php echo form_input($profileCityInput); ?>
				</li>
				<li> 
					<label class="employe_label">State, Provence or Region</label>
					<?php echo form_input($profileStateInput); ?>
				</li>
				<li> 
					<label class="employe_label">Zip or Post Code</label>
					<?php echo form_input($profileZipInput); ?>
				</li>
                <li >
					 <label class="employe_label">Country</label>
                   <span  class="width_258 select select_1 position_relative fl"> <?php
                    $countries = getCountryList();
                    $countryId = (!empty($profileCountry)) ? $profileCountry : $userCountry;
                    echo form_dropdown('profileCountry', $countries, $countryId,'id="profileCountry" class=" main_SELECT countriesList selectBox  required"');
                    ?></span>
                </li>
                <li class="mt30" > 
					<label class="employe_label">Email Address</label>
					<?php echo form_input($profileEmailInput); ?>
				</li>
                <li> 
					<label class="employe_label">Phone Number</label>
					<?php echo form_input($profilePhoneInput); ?>
				</li>
				 <li> 
					<label class="employe_label">Mobile Number</label>
					<?php echo form_input($profileMobileInput); ?>
				</li>
            </ul>
           
        <?php echo form_close(); ?>
        <!-- Form buttons -->
        <?php 
        // set back url
        $data['backPage'] =  '/workprofile/yourdetails';
        // set next form name
        $data['formName'] = 'contactDetailsForm';
         $this->load->view('workProfile/wizardform/common_buttons',$data);
        ?>
    </div>
</div>
<!--  content wrap  end --> 
<script>
    radioCheckboxRender();
  
    $(document).ready(function() {
        $("#contactDetailsForm").validate({
            submitHandler: function() {
                var fromData=$("#contactDetailsForm").serialize();
                $.post('<?php echo $baseUrl.'/setcontactdetails';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
    
</script>
