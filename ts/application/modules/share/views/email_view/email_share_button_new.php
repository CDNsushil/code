<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    if(!empty($isPublished) && $isPublished=='t')
    {				
        $onclickFunction = "getShortLink('".$url."');" ;	
    } else {
        $onclickFunction ='';	
    }
?>

    <a class="msg_icon email_small mr15" href="javascript:void(0)" onclick="<?php echo $onclickFunction ?>">Email</a>
 
<script type="text/javascript">
    function getShortLink (url) {	
        $.ajax
        ({     
            type: "POST",
            dataType: 'json',
            data:{url:url},			
            url: "<?php echo base_url_lang('share/getshortlink') ?>",
                success: function(msg){  
                    openUserLightBox('popupBoxWp','popup_box','/share/shareemailpupupnew',msg.shortlink);
                }
        });			
    }	
</script> 
