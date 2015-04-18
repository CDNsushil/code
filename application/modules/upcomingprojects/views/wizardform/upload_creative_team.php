<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// set base url
$baseUrl = base_url(lang().'/upcomingprojects/');
// get count of creative elements
$creativeElementsCount = count($creativeElementRes);
?>
<div class="TabbedPanelsContentGroup  m_auto clearb">
<div class="TabbedPanelsContent creative_wrap width635 m_auto clearb">
    <div class="c_1 ">
        <h3 class=" fs21 fnt_mouse bb_aeaeae pb15"> 
            <span class="red fs21">Creative Team </span> (Optional)
        </h3>
        <h4 class="fs18"> Were other people involved in creating this Artwork? If so, give them credit.</h4>
        <div class="sap_30"></div>
        <?php if($creativesCount == 0 && $creativeElementsCount > 0) { ?>
        <div class="clearb">
            <span class="mr25 fl pt10">Copy Creative team From previous Artwork</span>  
            <span class="fl">
                <ul class="billing_form date mt5 pl10 mr10 clearb fl">
                    <li class="select width_69 min-height_30">
                        <select  name="teamElements" id="teamElements" class="main_SELECT"  >
                            <?php
                            $i = 1;
                            foreach($creativeElementRes as $creativeElementRes) { ?>
                                <option value="<?php echo $creativeElementRes->elementId;?>" ><?php echo $i;?></option>
                            <?php $i++;} ?>
                        </select>
                    </li>
                </ul>
                <button class="white_button red fr p10 width_75 bdr_a0a0a0 fshel_bold" value="Copy" id="copyCreativeTeam" >Copy</button>
                
            </span>
                                                  
            <!--<button class="red p10 bdr_a0a0a0 fshel_bold"  type="button">Select Artwork</button>-->
            <span  class="ml25 fl pt10 fs16"> OR</span>
        </div>
         <div class="sap_35"></div>
        <?php } ?>
    
        <!-- toadsquare members in the Creative Team -->
        <?php $this->load->view('media/form/toad_creative_members');?>
        <div class="sap_30"></div>
         <!-- other members in the Creative Team -->
        <?php $this->load->view('media/form/other_creative_members');?>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
        
        // manage creative team copy functionality  
        $('#copyCreativeTeam').click(function() {
            var teamElement = $('#teamElements').val();
            confirmBox("Do you really want to copy Creative Team.", function () {
                var fromData = 'teamElementId='+teamElement+'&projId='+'<?php echo $elementId;?>'+'&indusrty='+'<?php echo $indusrty;?>'+'&isElement=1';
                $.post('<?php echo $baseUrl.'/copyCreativeTeam/';?>',fromData, function(data) {
                    if(data.countResult > 0) {
                        $('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('successCopyCreatives');?></div>');
                    } else {
                        $('#messageSuccessError').html('<div class="errorMsg"><?php echo $this->lang->line('errorCopyCreatives');?></div>');
                    }
                    window.location.href = window.location.href;
                },'json');
            });
        });
    });
</script>
