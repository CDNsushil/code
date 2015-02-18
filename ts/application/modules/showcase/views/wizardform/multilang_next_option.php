<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'nextOptionForm',
    'id'=>'nextOptionForm',
);
// set base url
$baseUrl = base_url(lang().'/showcase/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php echo form_open($baseUrl.'/movenextoption',$formAttributes); ?>
        <div class="c_1 clearb">
            <h3>What whould you like to do now?</h3>
            <div class="sap_50"></div>
                <ul class="display_table ml75 fl width155 listpb20 defaultP font_weight ">
                    <li>
                        <label>
                        <input class="ez-hide" type="radio" checked="checked" value="1" name="next_step_type" >
                        <span class="pl5">Add this section in  another language to your Homepage?</span></label>
                    </li>
                    <li class="fs18 pl36">
                        OR
                    </li>
                    <li>
                        <label>
                        <input class="ez-hide" type="radio" value="2" name="next_step_type">
                        <span class="pl5">Go onto stage 3</span></label>
                    </li>
                </ul>
           
        </div>
    <?php echo form_close();?>
   <!-- Form buttons -->
    <?php 
    // set back url
    $data['backPage'] =  '/showcase/otherdevelopmentsection/'.$showcaseLangId;
    // set next form name
    $data['formName'] = 'nextOptionForm';
    $this->load->view('wizardform/showcase_buttons',$data);
    ?>
</div>


