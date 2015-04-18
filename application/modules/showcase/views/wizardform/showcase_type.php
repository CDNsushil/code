<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'showcaseTypeForm',
    'id'=>'showcaseTypeForm',
);
// set base url
$baseUrl = base_url(lang().'/showcase/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php echo form_open($baseUrl.'/setshowcasetype',$formAttributes); ?>
        <div class="c_1 clearb">
            <h3>What type of Member are you?</h3>
            <div class="sap_15"></div>
            <div class="fs16 lineH18">This helps people find you on Toadsquare and starts to describes your role in the
            Creative Industries.</div>
            <div class="sap_30"></div>
            <?php if($isShowcaseTypeSet != true) { ?>
                <ul class="display_table ml75 fl width155 listpb20 defaultP font_weight ">
                    <li>
                        <label>
                        <input class="ez-hide" type="radio" value="1" name="showcase_type" id="creative">
                        <span class="pl5">Creative</span></label>
                    </li>
                    <li>
                        <label>
                        <input class="ez-hide" type="radio"  value="2" name="showcase_type" id="associatedProfessional">
                        <span class="pl5">Professional</span></label>
                    </li>
                    <li>
                        <label>
                        <input class="ez-hide" type="radio" value="3" name="showcase_type" id="enterprise">
                        <span class="pl5">Business</span></label>
                    </li>
                    <li class="fs18 pl36">
                        OR
                    </li>
                    <li>
                        <label>
                        <input class="ez-hide" type="radio"  checked="checked" value="4" name="showcase_type" id="fans">
                        <span class="pl5">Fan</span></label>
                    </li>
                </ul>

                <div class="fl mb10">
                    <span class="fl"><img src="<?php echo  base_url('/images/braket.png')?>" alt=""  /></span>
                    <span class="red fl mt42 pl10">If you select one of these, you can't change your selecion.</span>
                </div>
                <span class=" clearb mt60 pl30">You can change this selection later.</span>
            <?php
            } else { ?>
                <ul class="display_table ml75 fl width155 listpb20 defaultP font_weight ">
                    <li>
                        <label>
                        <input class="ez-hide" type="radio" checked="checked" value="<?php echo $showcaseTypeVal;?>" name="showcase_type">
                        <span class="pl5"><?php echo $showcaseType;?></span></label>
                    </li>
                 </ul>
            <?php 
            } ?>
        </div>
    <?php echo form_close();?>
   <!-- Form buttons -->
    <?php 
    // set back url
    $data['backPage'] =  '/showcase/editshowcase';
    if(empty($showcaseTypeVal)) {
        $data['showcaseAdd'] = 1;
    }
    // set next form name
    $data['formName'] = 'showcaseTypeForm';
    $this->load->view('wizardform/showcase_buttons',$data);
    ?>
</div>
<!--  content wrap  end --> 
<script type="text/javascript">
    $(document).ready(function() {
        $("#showcaseTypeForm").validate({
            submitHandler: function() {
                var fromData=$("#showcaseTypeForm").serialize();
                $.post('<?php echo $baseUrl.'/setshowcasetype/';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep;
                    }
                }, "json");
            }
        });
    });
</script>

