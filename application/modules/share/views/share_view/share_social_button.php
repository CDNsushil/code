<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    if((!empty($isPublished) && $isPublished=='t') || previewModeActive() )
    {				
        $onclickFunction = "sharePopupOpen('".$url."');" ;	
    } else {
        $onclickFunction ='';	
    }
?>
    <a href="javascript:void(0)" onclick="<?php echo $onclickFunction ?>"><img src="<?php echo $imgPath; ?>share_ic1.png" alt="" class="fl pl10 mr28"  /></a>
 
<script type="text/javascript">
    function sharePopupOpen (url) {	
        
        var isPreview = "<?php echo previewModeActive(); ?>";
        
         //check if preview mode
        if(isPreview=="1"){
            customAlert('You cannot share in preview mode.');
            return false;
        }
        
        $.ajax
        ({     
            type: "POST",
            dataType: 'json',
            data:{url:url},			
            url: "<?php echo base_url_lang('share/getshortlink') ?>",
                success: function(msg){  
                    openUserLightBox('popupBoxWp','popup_box','/share/sharesocialpupupnew',msg.shortlink);
                }
        });			
    }	
</script> 
