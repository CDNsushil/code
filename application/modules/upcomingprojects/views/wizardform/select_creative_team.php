<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = base_url(lang().'/upcomingprojects/');
// set margin class, if copy option not exists
$spaceCls = 'mt52';
?>
<div class="TabbedPanelsContent creative_wrap width635 m_auto clearb tab_setting">
    <!--========================== if image selected==============================-->
    <div class="c_1 ">
        <div class="C_1 <?php echo $spaceCls; ?>">
            <h4 class=" bb_aeaeae red  fs21">Creative Team </h4>
            <h4 class="fs17"> Were other people involved in creating this Collection? If so, give them credit.</h4>
        </div>
        
        <div class="sap_15"></div>
        <!-- toadsquare members in the Creative Team -->
        <?php $this->load->view('upcomingprojects/wizardform/toad_creative_members');?>
       
        <div class="sap_30"></div>
         <!-- other members in the Creative Team -->
        <?php $this->load->view('upcomingprojects/wizardform/other_creative_members');?>
    </div>
</div>

