<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'addlinkForm',
    'id'=>'addlinkForm',
);
$websiteUrlInput = array(
    'name'=>'websiteUrl',
    'id'=>'websiteUrl',
    'class'=>"font_wN width_615 url",
    'value'=> (isset($workProfileDetails->websiteUrl) && !empty($workProfileDetails->websiteUrl)) ? $workProfileDetails->websiteUrl : '',
    'placeholder'=>"Your Website URL  eg. www.toadsquare.com",
    'onclick'=>"placeHoderHideShow(this,'Your Website URL  eg. www.toadsquare.com','hide')",
    'onblur'=>"placeHoderHideShow(this,'Your Website URL  eg. www.toadsquare.com','show')"
);
  
// set base url
$baseUrl = base_url(lang().'/workprofile/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php echo form_open($baseUrl.'/setweblink',$formAttributes)?>
        <div class="clearbox">
            <h3>Add a link to your Website</h3>
            <div class="sap_30"></div>
            <?php echo form_input($websiteUrlInput);?>
        </div>
    <?php echo form_close();?>
    <!-- Form buttons -->
    <?php 
    // set back url
    $data['backPage'] = '/workprofile/recommandations';
    // set next form name
    $data['formName'] = 'addlinkForm';
    $this->load->view('workProfile/wizardform/common_buttons',$data);
    ?>
</div>
<script>
  
    $(document).ready(function() {
        $("#addlinkForm").validate({
            submitHandler: function() {
                var fromData=$("#addlinkForm").serialize();
                //loader();
                $.post('<?php echo $baseUrl.'/setweblink';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
    
</script>
