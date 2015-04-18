<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'personalDetailsForm',
    'id'=>'personalDetailsForm',
);

$interestsInput = array(
    'name'        =>  'interests',
    'id'          =>  'interests',
    'class'       =>  'width_615  bdr_adadad height51',
    'value'       =>  (isset($workProfileDetails->interests) && !empty($workProfileDetails->interests)) ? $workProfileDetails->interests : '',
    'placeholder' =>  "e.g. Art House Movies, skiing",
    'onBlur'      =>  "placeHoderHideShow(this,'e.g. Art House Movies, skiing','show')",
    'onClick'     =>  "placeHoderHideShow(this,'e.g. Art House Movies, skiing','hide')"
);

$dob = isset($workProfileDetails->dateOfBirth) ? date('d F Y',strtotime($workProfileDetails->dateOfBirth)) : date('d F Y');
$dateOfBirthInput = array(
    'name'	=> 'dateOfBirth',
    'value'	=> $dob,
    'id'	=> 'dateOfBirth',
    'type'	=> 'text',
    'class'=>'calendar_picker  mt0 required',
    "placeHolder"=>date('d F Y'),
    "onclick"=>"placeHoderHideShow(this,'".date('d F Y')."','hide')",
    "onblur"=>"placeHoderHideShow(this,'".date('d F Y')."','show')",
    "readonly"=>true
);

$otherInterestInput = array(
    'name'        =>  'otherInterest',
    'id'          =>  'otherInterest',
    'class'       =>  'width_615 bdr_adadad height51',
    'value'       =>  (isset($workProfileDetails->otherInterest) && !empty($workProfileDetails->otherInterest)) ? $workProfileDetails->otherInterest : '',
    'placeholder' =>  "e.g. Drivers License Status",
    'onBlur'      =>  "placeHoderHideShow(this,'e.g. Drivers License Status','show')",
    'onClick'     =>  "placeHoderHideShow(this,'e.g. Drivers License Status','hide')"
);

// set base url
$baseUrl = base_url(lang().'/workprofile/');

?>
<div class="TabbedPanelsContent wizard_wrap tab_setting width635 m_auto clearb">
    <?php   
    echo form_open($baseUrl.'/personalinterests/',$formAttributes); 
    ?>
        <div class="c_1">
           <ul class="listpb20 mt25">
				<li>
					<h4 class="red fs20 mb25 bb_c2c2"> <?php echo $this->lang->line('intrests')?> </h4>
					<?php echo form_textarea($interestsInput); ?>
                </li>
                
                <li class="select select_1">
					<div class="wra_head clearb" >
						<h4 class="red fs20 mb25 bb_c2c2"> <?php echo $this->lang->line('maritalStatus')?> </h4>
						<ul class="billing_form form1 mb10">
							<li class=" width_258 select select_1">
								<?php
								$maritalTypeList = getMaritalTypeList();
								$maritalStatus = (isset($workProfileDetails->maritalStatus) && !empty($workProfileDetails->maritalStatus)) ? $workProfileDetails->maritalStatus : '';
								echo form_dropdown('maritalStatus', $maritalTypeList, $maritalStatus,'id="maritalStatus" class=" main_SELECT selectBox bg_f6f6f6"');?>
							</li>
						 </ul>
					 </div>	 
				 </li>
				 
				<li class="position_relative">
					<h4 class="red fs20 bb_c2c2 mb25"> <?php echo $this->lang->line('dob')?> </h4>
					<span class="width_180 position_relative fl ">
						<?php echo form_input($dateOfBirthInput);?>
						<img class="ui-datepicker-trigger ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#dateOfBirth").focus();' alt="..." title="...">
					</span> 
				</li>
						 
                <li>
					<h4 class="red fs20 bb_c2c2 mb25"> <?php echo $this->lang->line('other')?> </h4>
					<?php echo form_textarea($otherInterestInput); ?>
                </li>
          
           </ul>
           <ul class=" pt30 clearb">
		<li class="icon_2">Fill in the above fields as appropriate to your work culture. </li>
	</ul>
        </div>
    <?php echo form_close();?>
    <!-- Form buttons -->
   <?php 
	// set back url
	$data['backPage'] =  '/workprofile/personaldetails';
	// set next form name
	$data['formName'] = 'personalDetailsForm';
	$this->load->view('workProfile/wizardform/common_buttons',$data);
	?>	
</div>

<!--  content wrap  end --> 
<script>
    radioCheckboxRender();
  
    $(document).ready(function() {
        $("#personalDetailsForm").validate({
            submitHandler: function() {
                var fromData=$("#personalDetailsForm").serialize();
                //loader();
                $.post('<?php echo $baseUrl.'/setpersonalinterest';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
    
</script>
