<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    $loggedUserId   =   isloginUser();
    $beforeDonate=$this->lang->line('beforeDonateLoggedIn');
    if(!empty($loggedUserId) && ($ownerId!=$loggedUserId)){
        $donorDetail        =   array('entityId'=>$entityId,'elementId'=>$elementId,'projId'=>$projId,'sectionId'=>$sectionId,'ownerId'=>$ownerId,'currencySign'=>$currencySign,'sellerCurrency'=>$sellerCurrency);	
        $donateInformation  =   $this->load->view("common_view/donate_popup_view",$donorDetail,true);
    ?>
    <script>
        var donateData=<?php echo json_encode($donateInformation);?>;
    </script>
    <?php
        $functionDonate="loadPopupData('popupBoxWp','popup_box',donateData)";
    }else{
        $donateNowMsg = $this->lang->line('donateNowMsg');	
        if(!empty($loggedUserId)){	
            $functionDonate = "customAlert('".$donateNowMsg."','Info')";
        }else{ 
            $functionDonate = "openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeDonate."')";
        }
    }
?>
    <button onclick="javascript:<?php echo $functionDonate;?>"  class="green_btn <?php echo ($showview=='project')?"fl":"fr"; ?> fs16 donate_b" type="button">
        <?php echo $this->lang->line('donate');?>
    </button>
    <?php /*if($showview=="project") { ?>
        <a class="btn_review <?php echo ($showview=='project')?"fl":"fr"; ?> mt15 font_bold " onclick="javascript:<?php echo $functionDonate;?>" href="javascript:void(0)"><?php echo $this->lang->line('project_donate_button_msg'); ?></a>
    <?php }*/ ?>
