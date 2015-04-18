<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="poup_bx payperview shadow fs14 p_30">
   <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');" ></div>
   
   <?php
            /*************Here check exnternal and interter media**************/ 
            //get media file type 
            if(isset($entityId) && isset($element) && is_array($element) && count($element) > 0 ){
                if($element['isExternal']=="t"){
                    $getMediaUrlData = getMediaUrl($element['filePath']);
                    if($getMediaUrlData['isUrl']){
                        //url is valid 
                        $headerDetails = @get_headers($element['filePath'],1);
                        if(isset($headerDetails['X-Frame-Options'])){
                            $src = base_url().'en/player/videoError/';
                        }
                        else{
                            $src = $element['filePath'];
                        }
                    }
                    else{	
                        $getSrc = $getMediaUrlData['getsource'];
                        if($getMediaUrlData['embedtype'] == 'iframe'){
                            // This code will play embeded ifram code
                            $src = $getSrc;
                        }
                        else{
                            // This code will play other type of embed code
                            $src = base_url().'en/player/commonPlayerIframe/'.$element['fileId'].'_full/'.$entityId.'/'.$element['elementId'].'/'.$element['projId'];
                        } 
                    } 
                }
                else{
                    $src = base_url().'en/player/getMainPlayerIframe/'.$element['fileId'].'_full/'.$entityId.'/'.$element['elementId'].'/'.$element['projId'];
                }?>
                    <iframe src="<?php echo $src; ?>" width="890" height="100%" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>
                <?php
            }else{
                    echo 'no file found.';
            }?> 
   
    
</div>
