<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'cartSetupForm',
    'id'=>'cartSetupForm',
);

$projectIdField = array(
	'name'	=> 'projId',
	'value'	=> (isset($upcomingRes['projId'])) ? $upcomingRes['projId'] : 0,
	'id'	=> 'projId',
	'type'	=> 'hidden'
);
// set base url
$baseUrl = base_url(lang().'/upcomingprojects/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php echo form_open($baseUrl.'/setshowcasetype',$formAttributes); ?>
        <div class="c_1 clearb">
            <h3><?php echo $this->lang->line('alreadySetupText');?></h3>
            <div class="sap_30"></div>
            <div class=" mt20  ml0 butn pad_2 b_f7f7f7 fs16 bdr_b4b4b4 lineH18 fl"> 
				<span class="defaultP table_cell fs14">						
					<label>
						<input type="radio" value="f" name="changeInfo" class="price_no" checked>
						<?php echo $this->lang->line('No');?></label>
					<label>
						<input type="radio" value="t" name="changeInfo" class="price_yes" >
						<?php echo $this->lang->line('Yes');?> 
					</label>
				</span> 
			</div>
        </div>
    <?php 
		echo form_input($projectIdField);
    echo form_close();?>
   <!-- Form buttons -->
    <?php
    // set next form name
    $data['formName'] = 'cartSetupForm';
    $this->load->view('wizardform/donation_buttons',$data);
    ?>
</div>
<!--  content wrap  end --> 
<script type="text/javascript">
    $(document).ready(function() {
        $("#cartSetupForm").validate({
            submitHandler: function() {
                var fromData=$("#cartSetupForm").serialize();
                $.post('<?php echo $baseUrl.'/setcartsetupstep/';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep;
                    }
                }, "json");
            }
        });
    });
</script>

