<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
    'name'=>'nextOptionForm',
    'id'=>'nextOptionForm'
);
$ProjectId = array(
	'name' => 'projectId',
	'id'   => 'projectId',
	'type' => 'hidden',
	'value'=>  (!empty($projectId))?$projectId:0,
);

// set base url
$baseUrl = formBaseUrl();
?>
<div id="TabbedPanels7" class="TabbedPanels tab_setting second_inner mt30"> 
    <!--========== Setup your Auction  =================-->
    <div class="TabbedPanelsContentGroup"> 
        <!--=======================pickup=======================-->    
        <?php echo form_open($baseUrl.DIRECTORY_SEPARATOR.'movetonextnewsreviewstep'.DIRECTORY_SEPARATOR.$projectId.DIRECTORY_SEPARATOR.$elementId,$formAttributes); ?>       
            <div class="TabbedPanelsContent">
                <div class="c_1">
                    <h3 class="red fs21 fnt_mouse  bb_aeaeae"> What would you want to do now? </h3>
                    <div class="sap_40"></div>
                    <ul class=" display_table clearb defaultP">
                        <li >
                            <label>
                                <input type="radio" name="nextOption" value="1" checked="checked"/>
                                <b><?php echo $this->lang->line('addAnotherElement');?></b>
                            </label>
                             <ul class="clearb disc_list pt20">
                                <li>
                                    <?php echo $this->lang->line('addMoreElement');?>
                                </li>
                            </ul>
                        </li>
                       <li class="or_text "> OR </li>
                        <li>
                            <label>
                                <input type="radio" name="nextOption" value="2"/>
                                <b><?php echo $this->lang->line('goToDesignCover');?></b> 
                            </label>
                        </li>
                    </ul>
                </div>
                <!-- form buttons  -->
                <div class="c_1 clearb ">
                    <?php 
                    // set cancel url
                    $data['cancelUrl'] =  base_url(lang().DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.$indusrtyName.DIRECTORY_SEPARATOR.$projectId);
                    // set back page name
                    $data['backUrl'] = $baseUrl.DIRECTORY_SEPARATOR.'articleinfo'.DIRECTORY_SEPARATOR.$projectId.DIRECTORY_SEPARATOR.$elementId;
                    $this->load->view('common_view/common_buttons',$data);
                    //set form hidden fields
                    echo form_input($ProjectId);
                    ?>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
