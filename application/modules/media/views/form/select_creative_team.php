<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = formBaseUrl();
// set margin class, if copy option not exists
$spaceCls = 'mt52';
// get count of creative elements
$creativeElementsCount = count($creativeElementRes); 
if(isset($projectElementId) && !empty($projectElementId)) {
	$elementId = $projectElementId;
}
?>
<div class="TabbedPanelsContent creative_wrap width635 m_auto clearb">
    <div class="selct_img btn_wrap display_none">
       <div class="full_div"></div>
       <div class="paralax_slider_cont width611 pl11 pr11 shadow z_index10000">
          <div id="slider2" class="launchslider pt8 pb8 fr">
             <a class="buttons prev" href="#">left</a>
             <div class="viewport ">
                <ul class="overview first_overview">
                   <li><img src="images/002_thumb.png"  alt=""/></li>
                   <li><img src="images/003_thumb.png" alt="" /></li>
                   <li><img src="images/004_thumb.png"  alt=""/></li>
                   <li><img src="images/005_thumb.png" alt="" /></li>
                   <li><img src="images/002_thumb.png"  alt=""/></li>
                   <li><img src="images/003_thumb.png"  alt=""/></li>
                   <li><img src="images/004_thumb.png"  alt=""/></li>
                   <li><img src="images/005_thumb.png"  alt=""/></li>
                   <li><img src="images/005_thumb.png" alt="" /></li>
                   <li><img src="images/002_thumb.png"  alt=""/></li>
                   <li><img src="images/003_thumb.png"  alt=""/></li>
                   <li><img src="images/004_thumb.png"  alt=""/></li>
                   <li><img src="images/005_thumb.png"  alt=""/></li>
                </ul>
             </div>
             <a class="buttons next" href="#">right</a> 
          </div>
       </div>
       <button class="back butn_unselect bdr_b1b1b1 mt20 fr z_index10000 position_relative">Select</button>
       <button class="back butn_select display_none bdr_b1b1b1 mt20 fr z_index10000 position_relative">Select</button>
    </div>
    <!--========================== if image selected==============================-->
    <div class="c_1 ">
        <?php if($creativesCount == 0 && $creativeElementsCount > 0) { 
            $spaceCls = '';?>
            <div class="c_1">
                <h3 class="fs21  fl red fnt_mouse bd_none "> Copy Creative Team from Image </h3>
                <div class="fr mt52 ml40 display_table width_216">
                    <ul class="billing_form date mt5 pl10 clearb fl">
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
                    <div class="ml40">
                        <input class="red fr p10 width_75 bdr_a0a0a0 fshel_bold" value="Copy" id="copyCreativeTeam" type="button" />
                    </div>
                </div>
            </div>
            <p class="c_1 font_helLight fs23 clearb mt20 mb20 text_alighL" > OR</p>
        <?php } ?>
        <div class="C_1 <?php echo $spaceCls; ?>">
            <h4 class=" bb_aeaeae red  fs21">Creative Team </h4>
            <h4 class="fs17"> Were other people involved in creating this Collection? If so, give them credit.</h4>
        </div>
        
        <div class="sap_45"></div>
        <!-- toadsquare members in the Creative Team -->
        <?php $this->load->view('media/form/toad_creative_members');?>
       
        <div class="sap_60"></div>
         <!-- other members in the Creative Team -->
        <?php $this->load->view('media/form/other_creative_members');?>
    </div>
</div>

<script>
    $(document).ready(function() {
        
        // manage creative team copy functionality  
        $('#copyCreativeTeam').click(function() {
            var teamElement = $('#teamElements').val();
            confirmBox("Do you really want to copy Creative Team.", function () {
                var fromData = 'teamElementId='+teamElement+'&projId='+'<?php echo $elementId;?>'+'&indusrty='+'<?php echo $indusrty;?>';
                $.post('<?php echo $baseUrl.'/copyCreativeTeam/';?>',fromData, function(data) {
                    if(data.countResult > 0) {
                        $('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('successCopyCreatives');?></div>');
                    } else {
                        $('#messageSuccessError').html('<div class="errorMsg"><?php echo $this->lang->line('errorCopyCreatives');?></div>');
                    }
                    window.location = '<?php echo $baseUrl.'/selectcreativeteam/'.$elementId;?>';
                },'json');
            });
        });
    });
</script>
