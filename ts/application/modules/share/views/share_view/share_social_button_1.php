<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    if(!empty($isPublished) && $isPublished=='t')
    {				
        $onclickFunction = "sharePopupOpen('".$url."');" ;	
    } else {
        $onclickFunction ='';	
    }
?>
    <li> <a href="javascript:void(0)" onclick="<?php echo $onclickFunction ?>"> Share <i class="ab_share share_me"></i></a></li>
 
<script type="text/javascript">
    function sharePopupOpen (url) {	
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
