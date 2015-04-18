<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'mutilingualForm',
    'id'=>'mutilingualForm',
);
$showcaseLangIdInput  =   array(
  'name'     =>  'showcaseLangId',
  'id'       =>  'showcaseLangId',
  'value'    =>  $showcaseLangId,
  'type'     => 'hidden',    
); 

$showcaseIdInput  =   array(
  'name'     =>  'showcaseId',
  'id'       =>  'showcaseId',
  'value'    =>  $showcaseId,
  'type'     => 'hidden',    
);

$langSectionInput  =   array(
  'name'     =>  'langSection',
  'id'       =>  'langSection',
  'value'    =>  'otherlanguage',
  'type'     => 'hidden',    
);

$nextStepInput  =   array(
  'name'     =>  'nextStep',
  'id'       =>  'nextStep',
  'value'    =>  'aboutothersection',
  'type'     => 'hidden',    
);
// set language id
$langaugeId = (!empty($multilingualData))?$multilingualData->langId:0;
// set base url
$baseUrl = base_url(lang().'/showcase/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php echo form_open($baseUrl.'/setmutilingualdata',$formAttributes); ?>
        <div class="c_1 clearb">
            <h3>Which language do you want to add section in?</h3>
            <div class="sap_30"></div>
            <div class="select_1  position_relative">
                <?php 
                // get language list
                $languageList = getMultilingualLanguageListing($langaugeId);
                echo form_dropdown('langaugeId', $languageList, $langaugeId,'id="languageId" class="required width_248" ');
                ?>
            </div>
        </div>
    <?php 
        echo form_input($showcaseLangIdInput);
        echo form_input($showcaseIdInput);
        echo form_input($langSectionInput); 
        echo form_input($nextStepInput);
    echo form_close();?>
   <!-- Form buttons -->
    <?php 
    // set back url
    $data['backPage'] =  '/showcase/otherlanguage';
    // set next form name
    $data['formName'] = 'mutilingualForm';
    $this->load->view('wizardform/showcase_buttons',$data);
    ?>
</div>
<!--  content wrap  end --> 
<script type="text/javascript">
    $(document).ready(function() {
        runTimeCheckBox();
        $("#mutilingualForm").validate({
            submitHandler: function() {
                var langaugeId = $('#languageId').val();
                if(langaugeId > 0) {
                    var fromData=$("#mutilingualForm").serialize();
                    $.post('<?php echo $baseUrl.'/setmutilingualdata/';?>',fromData, function(data) {
                        if(data){
                            window.location.href = data.nextStep;
                        }
                    }, "json");
                } else {
                    alert('Please select language to add.');
                    return false;
                }
            }
        });
    });
</script>
