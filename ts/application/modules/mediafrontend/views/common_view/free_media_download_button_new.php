<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    //this condition for free and paid project donwload
    $loggedUserId   =   isloginUser();
    $downloadLink   =   'javascript:void(0);';
    $target         =   '';
    
    $beforeDownloadLoggedIn=$this->lang->line('beforeDownloadLoggedIn');
    $downLoadString= $this->lang->line($industryType.'_free_button_2');
    
    if(!empty($loggedUserId)){
        //free collection download button	
        $target='target="_blank"';
        $functionBuyProduct="return checkIsUserLogin('".$beforeDownloadLoggedIn."');";
        $buttonShow = '2';

        // This condition for free project donwload
        $downloadLink=$ownerId.'+'.$elementId.'+'.$industryType.'+'.$loggedUserId.'+0';
        $downloadLink=encode($downloadLink);
        $downloadLink=base_url_lang('mediafrontend/downloadfile/'.$downloadLink);
    }else{
        $beforeBuyProduct = "You must be logged in to buy a product.";		
        $functionBuyProduct="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeBuyProduct."')";
    }
    
?>
    <a <?php echo $target;?> href='<?php echo $downloadLink;?>' onclick="<?php echo $functionBuyProduct;?>">
        <?php if($showview=="projectelement"){?>
            <button class="green_btn mb10" type="button"><?php echo $this->lang->line($industryType.'_free_button_1'); ?> <span class=" pl7 pr7"> |</span> <?php echo $downLoadString;?> </button>
        <?php  } ?>
        
        <?php if($showview=="project"){?>
            <button class="pay_button" type="button"><?php echo $this->lang->line($industryType.'_free_button_1'); ?> <span class="red fr"><?php echo $downLoadString;?></span></button>
        <?php  } ?>
     </a>
         
       
