<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

    
    if(!empty($projList)){
        
    $isAnyRecord    =  false;    
        
    foreach($projList as $projData){
        
        $baseUrl    =  base_url('media/');
        $projectId  =  $projData->projId;
        $expiryDate  =  $projData->expiryDate;
        
        $renewDay                 =  $this->config->item('container_renew_button_before_day');
        $renewDate                =  date('d-M-Y', strtotime($renewDay, strtotime($expiryDate)));
        $renewDateStrtotime       =  strtotime($renewDate);
        $currentDateStrtotime     =  time();
        
        if($renewDateStrtotime <= $currentDateStrtotime && !empty($packageEndDate)){
            
            $isAnyRecord = true;
?>
      <div class="row" id="removecrave_509">
             <div class=" fl border_cacaca width100_per shadow_down mb15 display_table position_relative width688">
                <span class="table_cell width_235  bgf4f4f4 bre9e9e9">
                <img src="http://localhost/toadsquare/images/default_thumb/education_material_m.jpg" alt="">
                </span>
                <div class="table_cell text_alighL fr cnt_crev ">
                   <div class="clearbox bbf47a55">
                      <h4 class="font_bold fl clr_666"><?php echo showString($projData->projName,50); ?></h4>
                      <div class="head_list pr5  fr">
                 
                      </div>
                   </div>
                   <div class="minH148">
                      <div class="title_box font_bold">
                         <?php echo showString($projData->projDescription,300); ?>                              
                      </div>
               
                   </div>
                </div>
             </div>
         
          <div class="fl pt100 pl25 removeCrave"> 
             <a href="<?php echo $baseUrl.'/renewmediacart/'.$projectId;?>">
                <span >Renew</span>
             </a>
          </div>
       </div>
<?php   } 
 
        }   }  
    
?>

<?php


if($items_total >  $perPageRecord) { 
    $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/media/'.$indusrtymethod.'/renewmedialist/'),"divId"=>"searchResultDiv","formId"=>"editCollectionForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); 
}
?>  
