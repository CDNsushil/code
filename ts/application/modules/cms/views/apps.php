<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row" >
<div class=" pl45 pr25  bg_f1f1f1 fl title_head ">
<h1 class="pt10 mb0  fl"><?php echo $title;?></h1>
</div>
<div class="clearb display_table width970 pl20 pt23 pr10 m_auto">
<div class="width780 pr10 text_alighL pb10 terms_wrap show_nic_heading">
<?php echo $description; ?>
</div>
<div class="terms_advert verti_top pt13  table_cell bg_f7f7f7" id="advert160_600"><?php 
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
    }?>
</div>

</div>
</div>
