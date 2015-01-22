<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'otherLangOptionForm',
    'id'=>'otherLangOptionForm',
);
$business = '';
if(isset($isEnterprise)) {
    $business = 'Business';
}
// set base url
$baseUrl = base_url(lang().'/showcase/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php   
    echo form_open($baseUrl.'/otherlanguage/',$formAttributes); 
    ?>
        <div class="c_1 clearb">
            <h3><?php echo $this->lang->line('otherLangOptionHead'.$business);?></h3>
            <div class="sap_15"></div>
            <div class="fs16 lineH18">
               <?php echo $this->lang->line('otherLangOptionHeadNote');?>
            </div>
            <div class="sap_40"></div>
                <ul class=" display_table mb22 clearb font_weight">
                    <li class="defaultP ">
                        <label class="tax_no width_50">
                             <input class="ez-hide" type="radio" value="1" name="other_lang_type" checked = 'checked'>  No 
                        </label>
                        <label class="ml88 tax_yes">
                            <input class="ez-hide" type="radio"  value="2" name="other_lang_type"> Yes
                        </label>
                    </li>
                </ul>
 
        </div>
    <?php echo form_close();?>
     <!-- Form buttons -->
    <?php
    // set back page
    $backPage = '/showcase/developmentpath';
    if($showcaseRes->fans == 't') {
        $backPage = '/showcase/aboutsection';
    }
    $data['backPage'] = $backPage;
    // set next form name
    $data['formName'] = 'otherLangOptionForm';
    $this->load->view('wizardform/showcase_buttons',$data);
    ?>
</div>
