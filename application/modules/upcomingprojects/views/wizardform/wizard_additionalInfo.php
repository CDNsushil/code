<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// set base url
$baseUrl = base_url(lang().'/upcomingprojects');
?>
<!--  content wrap  start end -->

<div class="newlanding_container">
    <div class="wizard_wrap publicity_wrap fs14">
        <div class="TabbedPanels " id="TabbedPanels1">
            <!-- ================================main tab mmenu ======================= -->
            <ul id="man_haedtab" class="TabbedPanelsTabGroup pt16 position_relative z_index_3 publicity_tab">
                <li class="TabbedPanelsTab <?php echo isset($shareMenu)?$shareMenu:'';?>"><a href="<?php echo $baseUrl.'/share/'.$projId;?>"><span>Stage 1 <b>Share</b></span></a></li>
                <li class="TabbedPanelsTab <?php echo isset($emailMenu)?$emailMenu:'';?>"><a href="<?php echo $baseUrl.'/email/'.$projId;?>"><span>Stage 2 <b>Email</b></span></a></li>
                <li class="TabbedPanelsTab <?php echo isset($PRMenu)?$PRMenu:'';?>"><a href="<?php echo $baseUrl.'/prnews/'.$projId;?>"><span>Stage 3 <b>Add Online PR Material </b></a></span></li>
            </ul>
            <!-- ================================main tab content  ======================= -->
            <div class="TabbedPanelsContentGroup width_914 m_auto main_tab">
            <!--========================== Stage 1  Share ==============================-->
                <div class="TabbedPanelsContent Tabbed2 width635 m_auto clearb TabbedPanelsContentVisible">
                    <?php $this->load->view($innerPage); ?>
                </div>
            </div>
        </div>
    </div>
</div>
