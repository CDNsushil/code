<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
    'name'=>'nextOptionForm',
    'id'=>'nextOptionForm'
);
$ElementId = array(
	'name' => 'elementId',
	'id'   => 'elementId',
	'type' => 'hidden',
	'value'=>  (!empty($elementId))?$elementId:0,
);
$IsSampleMedia = array(
	'name' => 'isSample',
	'id'   => 'isSample',
	'type' => 'hidden',
	'value'=>  (!empty($isSample))?$isSample:0,
);
$IsTrailerMedia = array(
	'name' => 'isTrailer',
	'id'   => 'isTrailer',
	'type' => 'hidden',
	'value'=>  (!empty($isTrailer))?$isTrailer:0,
);
// set base url
$baseUrl = formBaseUrl();
?>
<div class="newlanding_container">
    <div class="wizard_wrap fs14">
        <div id="TabbedPanels7" class="TabbedPanels tab_setting second_inner"> 
            <!--========== Setup your Auction  =================-->
            <div class="TabbedPanelsContentGroup"> 
                <!--=======================pickup=======================-->    
                <?php echo form_open($baseUrl.DIRECTORY_SEPARATOR.'movetonextstep'.DIRECTORY_SEPARATOR.$elementId,$formAttributes); ?>       
                    <div class="TabbedPanelsContent">
                        <div class="c_1">
                            <h3 class="red fs21 fnt_mouse  bb_aeaeae"> <?php echo $this->lang->line('whatYouWantNow');?> </h3>
                            <div class="sap_40"></div>
                            <ul class=" display_table clearb defaultP">
                                <li >
                                    <label>
                                        <input type="radio" name="nextOption" value="1" checked="checked"/>
                                        <b><?php echo $addAnotherMedia;?></b>
                                    </label>
                                   <ul class="clearb disc_list pt20">
                                        <li>
                                            <?php 
                                            $remainingSpace  = $this->lang->line('remainingSpace');
                                            $search = array("{{var remainingStorageSpace}}", "{{var totalStorageSpace}}");
                                            $replace   = array($remainingSize, $containerSize);
                                            echo str_replace($search,$replace,$remainingSpace);?>
                                        </li>
                                         <li>
                                            <?php echo $this->lang->line('needMoreSpace');?>
                                        </li>
                                    </ul>
                                </li>
                               <li class="or_text "> OR </li>
                                <li>
                                    <label>
                                        <input type="radio" name="nextOption" value="2"/>
                                        <b><?php echo $designCoverPage;?></b> 
                                    </label>
                                </li>
                                <?php if(!empty($addTrailerMedia)) { ?>
                                    <li class=" or_text"> OR </li>
                                    <li>
                                        <label>
                                            <input type="radio" name="nextOption" value="3"/>
                                            <b><?php echo $addTrailerMedia;?></b>
                                            <ul class="clearb disc_list pt20">
                                                <li>
                                                    You can add this later.
                                                </li>
                                            </ul>
                                            
                                        </label>
                                    </li>
                                <?php } ?>
                                <?php if(!empty($addSampleMedia)) { ?>
                                    <li class=" or_text"> OR </li>
                                    <li>
                                        <label>
                                            <input type="radio" name="nextOption" value="4"/>
                                            <b><?php echo $addSampleMedia;?></b>
                                            <ul class="clearb disc_list pt20">
                                                <li>
                                                    <?php echo $this->lang->line('doThisLater'); ?>
                                                </li>
                                            </ul>
                                            
                                        </label>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <!-- form buttons  -->
                        <div class="c_1 clearb ">
                            <?php 
                            // set cancel url
                            $data['cancelUrl'] = $baseUrl.'/editproject/'.$elementId;
                            // set back page name
                            $data['backUrl'] = $baseUrl.DIRECTORY_SEPARATOR.'uploadcreativeteam'.DIRECTORY_SEPARATOR.$elementId.DIRECTORY_SEPARATOR.$projElementId;
                            $this->load->view('common_view/common_buttons',$data);
                            //set form hidden fields
                            echo form_input($ElementId);
                            echo form_input($IsSampleMedia);
                            echo form_input($IsTrailerMedia);
                            ?>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
