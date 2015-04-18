<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'showcaseLangForm',
    'id'=>'showcaseLangForm',
);

// set base url
$baseUrl = base_url(lang().'/showcase/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php echo form_open($baseUrl.'/setshowcaselanguage',$formAttributes); ?>
        <div class="c_1 clearb">
            <h3>What is your preferred language?</h3>
            <div class="sap_15"></div>
            <div class="fs16 lineH18">
                Toadsquare in currently only in English. However, you can enter information and media
                in other languages. This selection indicates what language the majority of your Showcase
                and media will be in.
            </div>
            <div class="sap_40"></div>
            <div class="select_1  position_relative clear">
                <?php 
                // get language list
                $languageList = getlanguageList();
                echo form_dropdown('langaugeId', $languageList, $langaugeId,'id="languageId" class="required width210" ');
                ?>
                
            </div>
                  <div class="sap_25"></div>
            <span id="prelangid" class="error" ></span>
        </div>
    <?php echo form_close();?>
   <!-- Form buttons -->
    <?php 
    // set back url
    $data['backPage'] =  '/showcase/showcasetype';
    // set next form name
    $data['formName'] = 'showcaseLangForm';
    $this->load->view('wizardform/showcase_buttons',$data);
    ?>
</div>
<!--  content wrap  end --> 
<script type="text/javascript">
    $(document).ready(function() {
        $("#showcaseLangForm").validate({
            submitHandler: function() {
				
                var fromData=$("#showcaseLangForm").serialize();
                
                var prlang = $("#languageId").val();
				
				if(prlang != "0")
				{
					$.post('<?php echo $baseUrl.'/setshowcaselanguage/';?>',fromData, function(data) {
						if(data){
							window.location.href = data.nextStep;
						}
					}, "json");
				}
				else
				{
					$("#prelangid").html('This is a required field.');
				}
            }
        });
  
			$("#languageId").change(function() {
				var prlang = $("#languageId").val();
				if(prlang != "0")
				{
					$("#prelangid").html('');
				}
				else
				{
					$("#prelangid").html('This is a required field.');
				}
			});
    });
</script>
