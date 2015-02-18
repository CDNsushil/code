<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   /* echo '<div class="cnt_abtme width605 pl50 fl">';
        echo "<pre>";
        print_r($videoData[0]);
        echo "</pre>";
    echo '</div>';*/
    
    
    //get video data
    if(!empty($videoData)){
        $videoDataShow = $videoData['videoData'];
    }
    
    $entityId  =    $videoData['entityId'];
    $showcaseId  =    $videoData['showcaseId'];
    
?>
<div class="cnt_abtme width605 pl50 fl">
  <div id="slider" class="flexslider video_slider ">
    <ul class="slides">
        
        <?php
            if(!empty($videoDataShow)){
                $countId=1;
                foreach($videoDataShow as $getvideo){
                    
                    $mediaId = $getvideo['fileId'];
                    
                    if($getvideo['isExternal']=="t")
                    {
                        //this section is for external video
                        $getMediaUrlData = getMediaUrl($getvideo['filePath']);
                        
                        if($getMediaUrlData['isUrl'])
                        {
                            //url is valid 
                            $headerDetails = @get_headers($getvideo['filePath'],1);
                            if(isset($headerDetails['X-Frame-Options']))
                            {
                                // This code will show error 
                                $src = base_url().'en/player/videoError/';

                            }else
                            {
                                // This code will play url 
                                $src = $getvideo['filePath'];

                            }
                             
                        }else
                        {	
                            $getSrc = $getMediaUrlData['getsource'];
                            if($getMediaUrlData['embedtype'] == 'iframe')
                            {
                                 // This code will play embeded ifram code
                                 $src = $getSrc;
                            }else
                            {
                                // This code will play other type of embed code
                                $src = base_url().'en/player/commonPlayerIframe/'.$mediaId.'_full/'.$entityId.'/'.$showcaseId.'/'.$showcaseId;
                            } 
                        } 
                          
                    }else
                    {
                        $src = base_url().'en/player/getPlayerIframe/'.$mediaId.'_full/'.$entityId.'/'.$showcaseId.'/'.$showcaseId;
                    }
                    
                    ?>
                        
                         <li iframe_<?php echo $countId; ?>= "<?php echo $src; ?>" class="iframe_<?php echo $countId; ?>" >
                            <iframe src="<?php echo $src; ?>" id="iframe_<?php echo $countId; ?>" width="600" height="340" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>
                            <span class="title_slider opens_light fs22 text_alighC clearb pt20 pb20" > This is the up to 15 word title of the video </span>
                        </li>
                        
                    <?php
                    
                    $countId++;
                }
         
            }
        ?>
    </ul>
  </div>
</div>

   
  <script type="text/javascript">
         $(window).load(function(){
      
         
           $('#slider').flexslider({
             animation: "slide",
             controlNav: true,
             animationLoop: true,
             slideshow: false,
             sync: "#carousel",
             start: function(slider){
             }
           });
         });
        
        //next previous button refresh iframe
        $(document).on("click",'.flex-direction-nav a',function(){
          
            if($(".video_slider").find(".iframe_1").hasClass('iframe_1')){
               var iframe_1 = $(".video_slider").find(".iframe_1").attr('iframe_1');
               $("#iframe_1").attr('src',iframe_1);
            }
            
            if($(".video_slider").find(".iframe_2").hasClass('iframe_2')){
                var iframe_2 = $(".video_slider").find(".iframe_2").attr('iframe_2');
                $("#iframe_2").attr('src',iframe_2);
            }
        });
        
        //next previous button refresh iframe
        $(document).on("click",'.flex-control-nav a',function(){
          
            if($(".video_slider").find(".iframe_1").hasClass('iframe_1')){
               var iframe_1 = $(".video_slider").find(".iframe_1").attr('iframe_1');
               $("#iframe_1").attr('src',iframe_1);
            }
            
            if($(".video_slider").find(".iframe_2").hasClass('iframe_2')){
                var iframe_2 = $(".video_slider").find(".iframe_2").attr('iframe_2');
                $("#iframe_2").attr('src',iframe_2);
            }
        });
        
      
   
</script>
