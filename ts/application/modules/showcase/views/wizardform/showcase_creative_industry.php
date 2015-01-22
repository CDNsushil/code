<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'creativeIndustryForm',
    'id'=>'creativeIndustryForm',
);

// set base url
$baseUrl = base_url(lang().'/showcase/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php echo form_open($baseUrl.'/setcreativeindustry',$formAttributes); ?>
        <div class="c_1 clearb">
            <h3><?php echo $creativeIndustryHead?></h3>
            <div class="sap_15"></div>
            <div class="fs16 lineH18">
               <?php echo $creativeIndustryHeadNote?>
            </div>
            <div class="sap_40"></div>
            <div class="select_1  position_relative">
                <?php 
                // get industry list
                 $industryList = getIndustryList();
                echo form_dropdown('industryId', $industryList, $creativeIndustry,'id="industryId" class="required" ');
                ?>
            </div>
        </div>
    <?php echo form_close();?>
    <!-- Form buttons -->
    <?php 
    // set back url
    $data['backPage'] =  '/showcase/showcaselanguage';
    // set next form name
    $data['formName'] = 'creativeIndustryForm';
    $this->load->view('wizardform/showcase_buttons',$data);
    ?>
</div>
<!--  content wrap  end --> 
<script type="text/javascript">
    $(document).ready(function() {
        $("#creativeIndustryForm").validate({
            submitHandler: function() {
                var fromData=$("#creativeIndustryForm").serialize();
                $.post('<?php echo $baseUrl.'/setcreativeindustry/';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep;
                    }
                }, "json");
            }
        });
    });
</script>
