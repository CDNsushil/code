<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'showcaseDetailsForm',
    'id'=>'showcaseDetailsForm',
);

$isBusiness = '';
 $isAdmin = "";
if(isset($isEnterprise)) {
    $isBusiness = 'Business';
    $isAdmin = "Administrator's";
}

$bNameInput = array(
    'name'	=> 'enterpriseName',
    'value'	=> $showcaseRes->enterpriseName,
    'id'	=> 'enterpriseName',
    'type'	=> 'text',
    'class' => 'font_wN required',
    'onclick'         =>  "placeHoderHideShow(this,'Business name','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Business name','show')",
    'placeholder'     =>  "Business name",
);

$fNameInput = array(
    'name'	    => 'firstName',
    'value'	    => $userProfileData->firstName,
    'id'	    => 'firstName',
    'type'	    => 'text',
    'class'     => 'font_wN required',
    'onclick'   =>  "placeHoderHideShow(this,'$isAdmin First name*','hide')",
    'onblur'    =>  "placeHoderHideShow(this,'$isAdmin First name*','show')",
    'placeholder' =>  "$isAdmin First name*",
);

$lNameInput = array(
    'name'	=> 'lastName',
    'value'	=> $userProfileData->lastName,
    'id'	=> 'lastName required',
    'type'	=> 'text',
    'class' => 'font_wN',
    'onclick'         =>  "placeHoderHideShow(this,'$isAdmin Last name','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'$isAdmin Last name','show')",
    'placeholder'     => "$isAdmin Last name",
);

// set base url
$baseUrl = base_url(lang().'/showcase/');

?>
<div class="content display_table  TabbedPanelsContent width635 m_auto wizard_wrap">
    <div class="wra_head clearb">
        <h3 class="red fs21 fnt_mouse bb_aeaeae"> <?php echo $this->lang->line('details'.$isBusiness);?> </h3>
        <div class="sap_40"></div>
        <?php echo form_open($baseUrl.'/updateShowcaseDetails',$formAttributes); ?>
            <ul class=" billing_form form1" >
                <?php if(isset($isEnterprise)) { ?>
                    <li><?php echo form_input($bNameInput); ?></li>
                <?php } ?>
                <li><?php echo form_input($fNameInput); ?></li>
                <li><?php echo form_input($lNameInput); ?></li>

                <li class=" width_258 select select_1">
                    <?php
                    $countries = getCountryList();
                    echo form_dropdown('countryId', $countries, $userProfileData->countryId,'id="countryId" class=" main_SELECT countriesList selectBox bg_f6f6f6 required"');
                    ?>
                </li>
            </ul>
            <ul class="org_list">
                <li class="icon_2"><?php echo $this->lang->line('settingStoreInGlobal');?></li>
            </ul>
        <?php echo form_close(); ?>
        <!-- Form buttons -->
        <?php 
        // set back url
        $data['backPage'] =  '/showcase/aboutyou';
        // set next form name
        $data['formName'] = 'showcaseDetailsForm';
        $this->load->view('wizardform/showcase_buttons',$data);
        ?>
    </div>
</div>
<!--  content wrap  end --> 
<script>
    radioCheckboxRender();
  
    $(document).ready(function() {
        $("#showcaseDetailsForm").validate({
            submitHandler: function() {
                var fromData=$("#showcaseDetailsForm").serialize();
                $.post('<?php echo $baseUrl.'/updateShowcaseDetails';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
    
</script>
