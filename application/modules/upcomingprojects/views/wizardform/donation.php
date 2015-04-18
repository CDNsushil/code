<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'donationForm',
    'id'=>'donationForm',
);
$projectIdField = array(
	'name'	=> 'projId',
	'value'	=> (isset($upcomingRes['projId'])) ? $upcomingRes['projId'] : 0,
	'id'	=> 'projId',
	'type'	=> 'hidden'
);
$projIndustryField = array(
	'name'	=> 'projIndustry',
	'value'	=> (!empty($projIndustry)) ? $projIndustry : 1,
	'id'	=> 'projIndustry',
	'type'	=> 'hidden'
);

// set base url
$baseUrl = base_url(lang().'/upcomingprojects/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php echo form_open($baseUrl.'/setshowcasetype',$formAttributes); ?>
        <div class="c_1 clearb">
            <h3><?php echo $this->lang->line('askForDonation');?></h3>
            <div class="sap_30"></div>
            <div class="mt20 ml0  butn pad_2 b_f7f7f7 fs16 bdr_b4b4b4 lineH18 fl"> 
				<span class="defaultP table_cell fs14">						
					<?php	
					if(isset($upcomingRes['askForDonation']) && ($upcomingRes['askForDonation'] =='t')){
						$askForDonationYes= 'checked';
						$askForDonationNo= '';
					}else{
						$askForDonationYes= '';
						$askForDonationNo= 'checked';
					} ?>
						
					<label>
						<input type="radio" value="f" name="askForDonation" id="askForDonation" class="price_no" <?php echo $askForDonationNo;?>>
						<?php echo $this->lang->line('No');?></label>
					<label>
						<input type="radio" value="t" name="askForDonation" id="askForDonation" class="price_yes" <?php echo $askForDonationYes;?>>
						<?php echo $this->lang->line('Yes');?> 
					</label>
				</span> 
			</div>
            
            <ul class="org_list">
				<li class="icon_1 red">
					<?php echo $this->lang->line('donationNote1');?>
				</li>
				<li class="icon_2">
					<?php echo $this->lang->line('donationNote2');?>
				</li>
			</ul>
              
        </div>
    <?php 
		echo form_input($projIndustryField);
		echo form_input($projectIdField);
    echo form_close();?>
   <!-- Form buttons -->
    <?php
    // set next form name
    $data['formName'] = 'donationForm';
    $this->load->view('wizardform/donation_buttons',$data);
    ?>
</div>
<!--  content wrap  end --> 
<script type="text/javascript">
    $(document).ready(function() {
        $("#donationForm").validate({
            submitHandler: function() {
                var fromData=$("#donationForm").serialize();
                $.post('<?php echo $baseUrl.'/setdonationtype/';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep;
                    }
                }, "json");
            }
        });
    });
</script>

