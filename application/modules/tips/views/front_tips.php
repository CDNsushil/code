<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row content_wrap" >
   <div class="m_auto Crave_cnt film_video clearb  ">
        <div class=" pl45 pr25 bg_f3f3f3 fl title_head ">
            <h1 class=" letrP-1 mb0  fl">Tips</h1>
                <ul class="fr dis_nav fs16 mt25 fr">
                    <li><a href="<?php echo base_url_lang('help') ?>">Help Forum</a> </li>
                    <li class="active"><a href="<?php echo base_url_lang('tips/front_tips') ?>" class="min_widht10">Tips</a> </li>
                </ul>
        </div>
      
      <div class="sap_50"></div>
      <div class="width_270 fl pl45">
         <ul class="open_sans fs16 listpb20 tip_list ">
             
            <?php foreach($tips as $d){
               
                 ?>
                <li class=" <?php   echo ($d['id']==$titleId)?"active":""; ?>"><a href="<?php echo site_url('tips/front_tips/'.$d['id']);?>"><?php echo $d['title'] ?></a></li>		
            <?php } ?> 
            
         </ul>
      </div>
      <div class="pl50 fl width585 bdrL_b4b4b4">
        <div class="textBody">
            
             <?php if(isset($description) && !empty($description)){ 
                $site_base_url = site_url('');
                $searchArray = array("{site_base_url}");
                $replaceArray = array($site_base_url);	
                
             
			foreach($description as $f)
			{ 
            ?>
            
             <h2 class="open_sans fs24">
             <?php
                if(isset($f['title']) && !empty($f['title'])){
                    echo $f['title'];
                 }?>
             </h2>
             <div class="sap_30"></div>

            <?php 
                if(isset($f['description']) && !empty($f['description'])){
                    $tips_description=str_replace($searchArray, $replaceArray, $f['description']);
                    echo changeToUrl($tips_description);
                }
            }
        
         }else{ 
            $site_base_url = site_url('');
            $searchArray = array("{site_base_url}");
            $replaceArray = array($site_base_url);	
        
            foreach($topDescription as $f)
            { 
                ?>
            
            <h2 class="open_sans fs24">
                 <?php
                    if(isset($f['title']) && !empty($f['title'])){
                        echo $f['title'];
                     }?>
                 </h2>
                 <div class="sap_30"></div>

                <?php 
                    if(isset($f['description']) && !empty($f['description'])){
                        $tips_description=str_replace($searchArray, $replaceArray, $f['description']);
                        echo changeToUrl($tips_description);
                    }
               
            } 
        }
        ?> 
        
         </div>
         
         <div class="sap_45"></div>
         <div class="bdrbebebe display_table m_auto shadow_down">
            <?php 
                if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
                    //Manage left side content bottom advert
                    $bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'3'));
                    if(!empty($bannerRhsData)) {
                        $this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'3','sectionId'=>$advertSectionId));
                    } else {
                        $this->load->view('common/adv_content_bot'); 
                    } 
                } else {
                    $this->load->view('common/adv_content_bot');  
                }
            ?>
         </div>
         <div class="sap_30"></div>
      </div>
      <div class="sap_30"></div>
   </div>
</div>
         
