<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    // check if project is published then can be create shortlink
    if((!empty($isPublished) && $isPublished=='t') || previewModeActive())
    {
        $onclickFunction = "generateShortLink('".urlencode($url)."');" ;	
    } else {
        $onclickFunction ='';	
    }
    
?>
    <?php   if($designType=="1"){ ?>
        <a class="msg_icon short_small" href="javascript:void(0)" onclick="<?php echo $onclickFunction ?>"><?php echo $this->lang->line('getShortLink');?></a>		
    <?php }elseif($designType=="2"){ ?>
         <a class="small_share2 short_share bdr_l_666 pl5 ml5" href="javascript:void(0)" onclick="<?php echo $onclickFunction ?>"></a>	
    <?php } ?>     
<script type="text/javascript">
    
    function generateShortLink (url) {
        
        var isPreview = "<?php echo previewModeActive(); ?>";
        
         //check if preview mode
        if(isPreview=="1"){
            customAlert('You cannot shortlink in preview mode.');
            return false;
        }
         
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
