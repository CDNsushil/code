<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="fr width620 "> 
    <div class="display_table m_auto fl">
        <p class="text_alighC fs20"><?php echo $this->lang->line('notFindResults')?></p>
        <!--crave list One-->
        <div class="thankyou_img big_cloud   fl">
            <h5 class="fs32 font_museoSlab lineH35 display_table clearb clr_fff fr">
            <span>
            "Refine&nbsp;&nbsp;&nbsp;&nbsp;
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;Search"
            </span>
            </h5>
            <div class=" fl mt-34">
                <img src="<?php echo IMGPATH;?>forg.png" alt="">
            </div>
        </div>
    </div>
    <div class="fr">
        <?php 
        if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
            //Manage right side advert
            $bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'2'));
            if(!empty($bannerRhsData)) {
                $this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'2','sectionId'=>$advertSectionId)); 
            } else {
                $this->load->view('common/adv_rhs');
            } 
        } else {
            $this->load->view('common/adv_rhs');
        }
    ?>  
    </div>
</div>
