<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
    'name'=>'publishForm',
    'id'=>'publishForm',
);
// set cancel url
$baseUrl = base_url(lang().'/showcase/');
$isPublished = (isset($isPublished) && ($isPublished=='t'))?'t':'f';
if($isPublished == 't'){
    $yesChecked='checked';
    $noChecked=''; 
}else{
    $yesChecked='';
    $noChecked='checked';
}
?> 
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php echo form_open($baseUrl.'/setpublicise',$formAttributes)?>
        <div class="c_1">
            <h3>Publicise your Homepage </h3>
            <h4 class=" fl width_472  mt20 lineH24">Now you have published your Showcase Homepage,<br />
            would you like to publicise it online? </h4>
            <div class="butn ml0 mr0 b_f7f7f7 fs17 mt30 fr bdr_b4b4b4 lineh16">
                <div class="table_cell pad_2"> 
                    <span class="defaultP fs14 pr0">
                        <label> 
                        Yes<input type="radio" value="t" name="isPublished" <?php echo $yesChecked;?> /></label>
                        <label>
                        No<input type="radio" value="f" name="isPublished" <?php echo $noChecked;?> /></label>
                    </span>
                </div>
            </div>
            <div class="sap_25"></div>
            <ul class="clearb pt15">
                <li class="icon_2 liststyle_none"> You can also do this later in edit mode.</li>
            </ul>
            <div class=" fs14 fr btn_wrap display_block mt5 font_weight">
                <button type="button" class="b_F1592A bdr_b5b5b5 fr pub_1 mr0"  onclick="$('#publishForm').submit();">Finish</button>
            </div>
        </div>
    <?php echo form_close();?>
</div>
