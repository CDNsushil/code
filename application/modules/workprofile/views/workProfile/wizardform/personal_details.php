<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'personalDetailsForm',
    'id'=>'personalDetailsForm',
);

// get workprofile data
$nationality   = (isset($workProfileDetails->nationality) && !empty($workProfileDetails->nationality)) ? $workProfileDetails->nationality : '';

$nationalityInput = array(
    'name'	    => 'nationality',
    'value'	    => $nationality,
    'id'	    => 'nationality',
    'type'	    => 'text',
    'class'     => 'font_wN required',
    'onclick'   =>  "placeHoderHideShow(this,'Nationality','hide')",
    'onblur'    =>  "placeHoderHideShow(this,'Nationality','show')",
    'placeholder' =>  "Nationality",
);

// set base url
$baseUrl = base_url(lang().'/workprofile/');

?>
<div class="TabbedPanelsContent wizard_wrap tab_setting width635 m_auto clearb">
    <div class="c_1 ">
		<?php echo form_open($baseUrl.'/personaldetails',$formAttributes); ?>
			<h3 class="red fs21 fnt_mouse bb_aeaeae"> <?php echo $this->lang->line('nationality');?> </h3>
			<div class="sap_30"></div>
				<ul class=" billing_form form1" >
					<li><?php echo form_input($nationalityInput); ?></li>
				</ul>
        <?php echo form_close(); ?>
        

		<!-- other members in the Creative Team -->
        <?php $this->load->view('workProfile/wizardform/profile_languages');?>
        <!-- other members in the Creative Team -->
        <?php $this->load->view('workProfile/wizardform/profile_visas');?>
        <!-- Form buttons -->
        <?php 
        // set back url
        $data['backPage'] =  '/workprofile/contactdetails';
        // set next form name
        $data['formName'] = 'personalDetailsForm';
         $this->load->view('workProfile/wizardform/common_buttons',$data);
        ?>
    </div>
</div>

<!--  content wrap  end --> 
<script>
    radioCheckboxRender();
  
    $(document).ready(function() {
        $("#personalDetailsForm").validate({
            submitHandler: function() {
                var fromData=$("#personalDetailsForm").serialize();
                //loader();
                $.post('<?php echo $baseUrl.'/setpersonaldetails';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
    
</script>
