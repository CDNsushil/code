<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    if((!empty($isPublished) && $isPublished=='t') || previewModeActive())
    {				
        $onclickFunction = "sharePopupOpen('".$url."');" ;	
    } else {
        $onclickFunction ='';	
    }
?>
    <li> <a href="javascript:void(0)" onclick="<?php echo $onclickFunction ?>"> <span class="fl">Share</span>  <i class="ab_share share_me"></i></a></li>
 
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
