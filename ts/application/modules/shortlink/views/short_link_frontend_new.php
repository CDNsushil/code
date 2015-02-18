<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    // check if project is published then can be create shortlink
    if(!empty($isPublished) && $isPublished=='t')
    {
        $onclickFunction = "generateShortLink('".urlencode($url)."');" ;	
    } else {
        $onclickFunction ='';	
    }
    
?>
    
    <a class="msg_icon short_small" href="javascript:void(0)" onclick="<?php echo $onclickFunction ?>"><?php echo $this->lang->line('getShortLink');?></a>		

<script type="text/javascript">
    
    function generateShortLink (url) {
        $.ajax
        ({     
            type: "POST",
            dataType: 'json',
            data:{url:url},			
            url: "<?php echo base_url(lang().'/shortlink/getshortlink') ?>",
            success: function(msg){ 	
                openLightBox('popupBoxWp','popup_box','/shortlink/shortlinkfrontpopupnew',msg.shortlink);											
            }
        });
    }
</script>
