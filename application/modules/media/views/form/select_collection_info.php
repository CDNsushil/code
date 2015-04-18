<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'collectionInfoForm',
    'id'=>'collectionInfoForm',
);
// set base url
$baseUrl = formBaseUrl();
// set back n skip url
$backUrl = '/selecttitlendesc/'.$projectId;
$skipUrl = '/selectcreativeteam/'.$projectId;
if(isset($isStage2)) {
    $backUrl = '/newsreviewtitlendesc/'.$projectId.'/'.$elementId; 
    $skipUrl = '/publishcollection/'.$projectId.'/'.$elementId; 
}
// set element id
$elementId = (isset($elementId))?$elementId:'';




?>  

<div class="TabbedPanelsContent">
    <h3 class="fs21 red "><?php echo $this->lang->line('collectionselfcla'.$projCategory); ?></h3>
    <div class="sap_30"></div>
    <?php echo form_open($baseUrl.'/setcollectioninfo/'.$projectId.'/'.$elementId,$formAttributes); ?>
        <ul class="billing_form date pl8  fl">
            <li class="select fl min-height_28 bg_f6f6f6">
                <?php
                $projRating = (isset($projData->projRating))?$projData->projRating:'';
                $Rating = getRatingList(1,lang(),'selectRating');
                echo form_dropdown('projRating', $Rating, $projRating,'id="projRating" class="required"');
                ?>
            </li>
        </ul>
        <ul class="display_inline_block pt4 ">
            <li class="icon_1 fl red fs15 pl25 ml16" > Adults only content is not allowed on Toadsquare. </li>
        </ul>
    <?php echo form_close(); ?>
    <div class="sap_60"></div>
    <!-- Form buttons -->
    <?php 
    // set back url
    $data['backPage'] = $backUrl;
    if(!empty($projRating)) {
        // set skip url
        $data['skipPage'] = $skipUrl;
    }
    // set next form name
    $data['formName'] = 'collectionInfoForm';
    $data['industry'] = $industry;
    $data['projectId'] = $projectId;
    $this->load->view('common_view/cover_buttons',$data);
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#collectionInfoForm").validate({
            submitHandler: function() {
                var fromData=$("#collectionInfoForm").serialize();
                $.post('<?php echo $baseUrl.'/setcollectioninfo/'.$projectId.'/'.$elementId;?>',fromData, function(data) {
                    if(data){
                        window.location.href = '<?php echo $baseUrl ?>' + data.nextStep;
                    }
                }, "json");
            }
        });
    });
</script>
