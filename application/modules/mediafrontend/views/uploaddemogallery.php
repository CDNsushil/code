<?php 
   $fileArray =   glob($dirUploadMedia.'/*.*');
   
   
?>

<div class="row content_wrap" >
   <div class=" pl45 pr25 bg_f1f1f1 fl title_head ">
      <h1 class="letrP-1 mb0  fl">Upload Gallery</h1>
   </div>
   <div class="banner_collection gallery_banner " >
      <div class="width900 display_table m_auto pb30">
         <h2  class=" lineH19 fl">Upload crop files gallery </h2>
      </div>
      <div class=" bg_444 display_table">
         
         <div id="slider" class="flexslider">
            <ul class="slides height562">
                <?php 
                    if(!empty($fileArray)){
                        
                    foreach($fileArray as $file){
                        
                    if(strpos($file,"_crop")){
                ?>
               <li> <img src="<?php echo base_url($file); ?>"  alt=""/> </li>
               <?php } } } ?>
            </ul>
         </div>
      </div>
   </div>
   <div class="sap_10"></div>
   <div class="thumbnail demo_thum gallery_thumb">
      <div id="carousel" class="flexslider">
         <ul class="slides demo_list" id="sldierul_1" >
                <?php 
                    if(!empty($fileArray)){
                    foreach($fileArray as $file){
                    
                     if(strpos($file,"_crop")){
                ?> 
                <li>
                   <div class="table_cell">
                      <img src="<?php echo base_url($file); ?>" alt="" />
                      <div class="thum_text box_onbanner">
                         <span class="title">View this image.</span> 
                         <div class="sap_15"></div>
                      </div>
                   </div>
                </li>
                
                
            <?php } }  } ?>
            
           
         </ul>
      </div>
   </div>
</div>

<script type="text/javascript">
     $(window).load(function(){
       $('#carousel').flexslider({
         animation: "slide",
         controlNav: false,
         animationLoop: true,
         slideshow: false,
         itemWidth: 109,
         asNavFor: '#slider'
       });
     
       $('#slider').flexslider({
         animation: "slide",
         controlNav: false,
         animationLoop: false,
         slideshow: false,
         sync: "#carousel",
         start: function(slider){
         }
       });
     });
</script>          
