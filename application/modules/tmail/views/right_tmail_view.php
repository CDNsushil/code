<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
?>  
<div class="fr <?php echo (isset($className))?$className:''; ?>"> 
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
