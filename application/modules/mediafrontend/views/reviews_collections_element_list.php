<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    //add preview word if preview mode is active
    $previewWord =  (previewModeActive())?"/preview":"";
    
    $imagetype          =   $fileConfig['defaultImage_m'];
    $imagetype_xs       =   $fileConfig['defaultImage_xs'];
    $imagetype_s        =   $fileConfig['defaultImage_s'];
    
?>
 <?php if(!empty($elementDataList)){ ?>
      <div class="clearbox bg6c6c pt20 pb20 ">
         <h2 class="fs29 pl18 clr_fff lineH24"><?php echo $this->lang->line('reviews_article_list'); ?></h2>
      </div>
      <div class="sap_20"></div>
      <div class="news_cnt">
        
        <?php 
            $n=1;
            foreach($elementDataList as $elementData){
                
                $title          =  $elementData['title'];
                $description    =  $elementData['description'];
                $craveCount     =  $elementData['craveCount'];
                $viewCount      =  $elementData['viewCount'];
                $IndustryName   =  $elementData['IndustryName'];
                $imagePath      =  $elementData['imagePath'];
                $elementId      =  $elementData['elementId'];
                $thumbImage          =  addThumbFolder($imagePath,'_xs');
                $elementImage        =  getImage($thumbImage,$imagetype_xs);

               // echo "<pre>";
               //print_r($elementData);
               
                //---------check craved by loggedUserId------------//
                if($loggedUserId){
                    $where=array(
                        'tdsUid'        =>   $loggedUserId,
                        'entityId'      =>   $elementEntityId,
                        'elementId'     =>   $elementId
                    );
                    
                    $countResult    =   countResult('LogCrave',$where);
                    $cravedALL      =   ($countResult>0)?'cravedALL':'';
                }else{
                    $cravedALL='';
                }
                
                $articleLink       =     'mediafrontend/reviewsdetails/'.$frentendUserId.'/'.$projectId.'/'.$elementId.$previewWord;
                        
        ?>
            <a href="<?php echo $articleLink; ?>" >
              
               
                 
                <div class="review_box <?php echo ($n%2)?'':'bg_fff'; ?>">
                   <div class="img_news table_cell text_alighL"> <img src="<?php echo $elementImage; ?>" alt="review"  /> </div>
                   <div class=" table_cell width650 pt13 pb9 pr15 text_alighL verti_top">
                      <h3 class="font_bold pb7 lett_8p"><?php echo $title ; ?> </h3>
                      <p class="fs13 minH50"><?php echo showString($description,300) ; ?> </p>
                      <div class=" clearbox pt10 mt18 bt_d1cfce">
                         <span class="fl font_bold green"><?php echo $IndustryName; ?></span>
                         <div class="head_list pr5 fr">
                            <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                            <div class="icon_crave4_blog icon_so <?php echo $cravedALL; ?>"><?php echo $craveCount; ?></div>
                         </div>
                      </div>
                   </div>
                </div>
            </a>
        
        
        <?php $n++; } ?>
      </div>

      
    <div class="row">
        <?php
        $url =base_url_lang("mediafrontend/reviewscollection/".$frentendUserId.'/'.$projectId);
        if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
             <div class="row">
                    <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>$url,"divId"=>"review_element_list","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
                <div class="clear"></div>
            </div>
        <?php } ?>  
    </div>

    <div class="sap_35"></div>

      
    <?php   } ?>
