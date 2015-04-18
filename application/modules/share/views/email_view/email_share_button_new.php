<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    if((!empty($isPublished) && $isPublished=='t') || previewModeActive())
    {				
        $onclickFunction = "getShortLink('".$url."');" ;	
    } else {
        $onclickFunction ='';	
    }
?>
    <?php 
    if($designType=="1"){
    ?>
        <a class="msg_icon email_small mr15" href="javascript:void(0)" onclick="<?php echo $onclickFunction ?>">Email</a>
    <?php }elseif($designType=="2"){ ?>
         <a class="email_share small_share2 bdr_l_666 pl5 ml5" href="javascript:void(0)" onclick="<?php echo $onclickFunction ?>"></a>
    <?php }elseif($designType=="3"){ ?>
          <a class="email_share small_share2  pl5 ml5" href="javascript:void(0)" onclick="<?php echo $onclickFunction ?>"></a>
    <?php } ?>    
 
<script type="text/javascript">
    function getShortLink (url) {
        
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
                    openUserLightBox('popupBoxWp','popup_box','/share/shareemailpupupnew',msg.shortlink);
                }
        });			
    }	
</script> 
